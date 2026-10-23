<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_responses_include_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), geolocation=(), microphone=()')
            ->assertHeader('Content-Security-Policy', "base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'");
    }

    public function test_admin_pages_are_not_cacheable(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Frame-Options', 'DENY');
    }

    public function test_admin_login_is_rate_limited_per_identity_and_ip(): void
    {
        $email = 'throttle-test@example.com';

        foreach (range(1, 5) as $attempt) {
            $this->post('/admin/login', [
                'email' => $email,
                'password' => 'wrong-password',
            ])->assertRedirect('/admin/login');
        }

        $this->post('/admin/login', [
            'email' => $email,
            'password' => 'wrong-password',
        ])->assertStatus(429);
    }

    public function test_admin_rejects_javascript_urls_in_site_settings(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/settings', [
            'brand_name' => 'Sytro Digital',
            'contact_email' => 'contact@example.com',
            'hero_title_line1' => 'Conectamos',
            'hero_title_line2' => 'resultados',
            'hero_description' => 'Descripción de prueba.',
            'hero_primary_url' => 'javascript:alert(1)',
        ])->assertSessionHasErrors('hero_primary_url');

        $this->assertNull(SiteSetting::get('hero_primary_url'));
    }

    public function test_contact_form_redirect_cannot_be_controlled_by_referer(): void
    {
        Http::fake(['*' => Http::response(['name' => 'message-id'], 200)]);

        $this->withHeader('Referer', 'https://attacker.example/')
            ->post('/contacto', [
                'name' => 'Visita de prueba',
                'email' => 'visitor@example.com',
                'message' => 'Consulta de seguridad.',
            ])
            ->assertRedirect('/#contacto');
    }

    public function test_admin_firebase_test_does_not_return_database_content_or_error_details(): void
    {
        $admin = User::factory()->create();
        Http::fake(['*' => Http::response(['private_data' => 'must-not-leak'], 200)]);

        $this->actingAs($admin)
            ->get('/admin/firebase/test')
            ->assertOk()
            ->assertJson(['success' => true, 'status' => 200])
            ->assertJsonMissingPath('data')
            ->assertDontSee('must-not-leak');
    }

    public function test_admin_cannot_upload_svg_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/projects', [
            'tag' => 'Prueba',
            'title' => 'Proyecto de prueba',
            'description' => 'Descripción de prueba.',
            'image' => UploadedFile::fake()->createWithContent('payload.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
            'order' => 1,
        ])->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('projects', ['title' => 'Proyecto de prueba']);
    }

    public function test_database_seeder_does_not_create_an_admin_with_default_credentials(): void
    {
        config()->set('auth.initial_admin', [
            'name' => 'Administrador Sytro',
            'email' => null,
            'password' => null,
        ]);

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_admin_password_change_requires_a_strong_password_and_updates_credentials(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('Old-Admin-Password-2026!'),
        ]);

        $this->actingAs($admin)->put('/admin/profile/password', [
            'current_password' => 'Old-Admin-Password-2026!',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ])->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('Old-Admin-Password-2026!', $admin->fresh()->password));

        $this->put('/admin/profile/password', [
            'current_password' => 'Old-Admin-Password-2026!',
            'password' => 'New-Admin-Password-2026!',
            'password_confirmation' => 'New-Admin-Password-2026!',
        ])->assertRedirect('/admin/profile');

        $this->assertTrue(Hash::check('New-Admin-Password-2026!', $admin->fresh()->password));
    }

    public function test_contact_form_honeypot_silently_discards_spam(): void
    {
        Http::fake(['*' => Http::response(['name' => 'message-id'], 200)]);

        $response = $this->post('/contacto', [
            'name' => 'Spam Bot',
            'email' => 'spambot@example.com',
            'message' => 'Buy cheap meds at shady.url',
            'hp_contact_check' => 'I am a bot filling all fields',
        ]);

        $response->assertRedirect('/#contacto');
        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'spambot@example.com',
        ]);
    }

    public function test_security_headers_include_coop_and_strip_x_powered_by(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $this->assertFalse($response->headers->has('X-Powered-By'));
    }

    public function test_custom_error_pages_render_without_system_information_leak(): void
    {
        $response = $this->get('/non-existent-page-random-12345');

        $response->assertNotFound()
            ->assertSee('Página no encontrada')
            ->assertSee('Sytro Digital')
            ->assertDontSee('Fatal error')
            ->assertDontSee('Exception');
    }
}
