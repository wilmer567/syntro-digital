<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@sytrodigital.com',
            'name' => 'Admin Sytro',
        ]);
    }

    public function test_guests_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'editor@sytrodigital.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'editor@sytrodigital.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_access_dashboard_when_authenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Resumen');
    }

    public function test_admin_can_update_site_settings(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/settings', [
            'brand_name' => 'Sytro Digital Pro',
            'contact_email' => 'contacto@sytrodigital.com',
            'contact_phone' => '+593 99 123 4567',
            'contact_address' => 'Quito, Ecuador',
            'contact_linkedin' => 'https://linkedin.com/company/sytro',
            'site_description' => 'Descripción de prueba',
            'hero_eyebrow' => 'Innovación digital',
            'hero_title_line1' => 'Transformamos negocios',
            'hero_title_line2' => 'con software sólido',
            'hero_description' => 'Construimos tecnología de primer nivel.',
            'hero_primary_text' => 'Comenzar',
            'hero_primary_url' => '#contacto',
            'hero_secondary_text' => 'Nuestros Proyectos',
            'hero_secondary_url' => '#proyectos',
            'stat_1_number' => '+10',
            'stat_1_text' => 'Años de experiencia',
            'stat_2_number' => '99%',
            'stat_2_text' => 'Satisfacción',
            'stat_3_number' => '24/7',
            'stat_3_text' => 'Soporte',
            'cta_heading' => 'Hablemos hoy',
            'cta_button_text' => 'Escríbenos',
            'cta_button_url' => '#contacto',
            'footer_about' => 'Pie de página de prueba',
            'footer_copyright' => '© 2026 Sytro',
            'footer_tagline' => 'Visión y código',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('Sytro Digital Pro', SiteSetting::get('brand_name'));
        $this->assertEquals('contacto@sytrodigital.com', SiteSetting::get('contact_email'));
    }

    public function test_admin_can_crud_services(): void
    {
        // Create
        $response = $this->actingAs($this->admin)->post('/admin/services', [
            'title' => 'Inteligencia Artificial',
            'description' => 'Modelos y automatizaciones inteligentes.',
            'topline_color' => 'gold',
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', [
            'title' => 'Inteligencia Artificial',
        ]);

        $service = Service::where('title', 'Inteligencia Artificial')->first();

        // Update
        $this->actingAs($this->admin)->put("/admin/services/{$service->id}", [
            'title' => 'Inteligencia Artificial y ML',
            'description' => 'Modelos avanzados.',
            'topline_color' => 'alt',
            'order' => 2,
            'is_active' => '1',
        ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Inteligencia Artificial y ML',
        ]);

        // Delete
        $this->actingAs($this->admin)->delete("/admin/services/{$service->id}");
        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_admin_can_crud_projects(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $validImage = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $image = \Illuminate\Http\UploadedFile::fake()->createWithContent('project.png', $validImage);

        $response = $this->actingAs($this->admin)->post('/admin/projects', [
            'tag' => 'Finanzas',
            'title' => 'Billetera Virtual',
            'description' => 'Pagos en tiempo real con QR.',
            'image' => $image,
            'image_description' => 'Pantalla principal de la billetera virtual.',
            'result' => '100k transacciones procesadas',
            'url' => 'https://ejemplo.com',
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/projects');
        $project = Project::where('title', 'Billetera Virtual')->first();
        $this->assertNotNull($project->image);
        $this->assertSame('Pantalla principal de la billetera virtual.', $project->image_description);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($project->image);

        // Update and remove image
        $response = $this->actingAs($this->admin)->put("/admin/projects/{$project->id}", [
            'tag' => 'Finanzas Pro',
            'title' => 'Billetera Virtual Pro',
            'description' => 'Pagos actualizados.',
            'remove_image' => '1',
            'order' => 1,
            'is_active' => '1',
        ]);

        $project->refresh();
        $this->assertNull($project->image);
        $this->assertNull($project->image_description);

        $this->actingAs($this->admin)->delete("/admin/projects/{$project->id}");
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_admin_can_upload_and_remove_multiple_project_images(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $validImage = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $firstImage = \Illuminate\Http\UploadedFile::fake()->createWithContent('screen-one.png', $validImage);
        $secondImage = \Illuminate\Http\UploadedFile::fake()->createWithContent('screen-two.png', $validImage);

        $this->actingAs($this->admin)->post('/admin/projects', [
            'tag' => 'Finanzas',
            'title' => 'Galería de proyecto',
            'description' => 'Proyecto con varias capturas.',
            'images' => [$firstImage, $secondImage],
            'new_image_descriptions' => ['Página de inicio', 'Panel administrativo'],
            'order' => 1,
            'is_active' => '1',
        ])->assertRedirect('/admin/projects');

        $project = Project::where('title', 'Galería de proyecto')->firstOrFail();
        $this->assertCount(2, $project->images);
        $this->assertSame('Página de inicio', $project->images[0]->description);
        $this->assertSame('Panel administrativo', $project->images[1]->description);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($project->images[0]->path);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($project->images[1]->path);

        $imageToRemove = $project->images[0];
        $imageToKeep = $project->images[1];

        $this->actingAs($this->admin)->put("/admin/projects/{$project->id}", [
            'tag' => $project->tag,
            'title' => $project->title,
            'description' => $project->description,
            'remove_images' => [$imageToRemove->id],
            'image_descriptions' => [$imageToKeep->id => 'Vista actualizada del panel administrativo'],
            'order' => $project->order,
            'is_active' => '1',
        ])->assertRedirect('/admin/projects');

        $this->assertDatabaseMissing('project_images', ['id' => $imageToRemove->id]);
        $this->assertDatabaseHas('project_images', ['id' => $imageToKeep->id]);
        $this->assertDatabaseHas('project_images', [
            'id' => $imageToKeep->id,
            'description' => 'Vista actualizada del panel administrativo',
        ]);
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($imageToRemove->path);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($imageToKeep->path);
    }

    public function test_admin_can_view_descriptions_for_each_project_image(): void
    {
        $project = Project::create([
            'tag' => 'Educación',
            'title' => 'Portal educativo',
            'description' => 'Plataforma de gestión académica.',
            'order' => 1,
            'is_active' => true,
        ]);
        $image = $project->images()->create([
            'path' => 'projects/portal.jpg',
            'description' => 'Vista principal del portal educativo.',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/projects')
            ->assertOk()
            ->assertSee('Descripción de la imagen')
            ->assertSee('image_descriptions['.$image->id.']', false)
            ->assertSee('Vista principal del portal educativo.');
    }

    public function test_visitor_can_submit_contact_message(): void
    {
        $response = $this->post('/contacto', [
            'name' => 'María Torres',
            'email' => 'maria@empresa.com',
            'phone' => '+593 99 999 8888',
            'service_interest' => 'Software a la medida',
            'message' => 'Deseo cotizar una aplicación para mi negocio.',
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'María Torres',
            'email' => 'maria@empresa.com',
        ]);
    }

    public function test_admin_can_view_and_manage_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@test.com',
            'message' => 'Mensaje de prueba',
            'is_read' => false,
        ]);

        // Viewing detail marks as read
        $response = $this->actingAs($this->admin)->get("/admin/messages/{$message->id}");
        $response->assertStatus(200);
        $this->assertTrue($message->fresh()->is_read);

        // Delete message
        $this->actingAs($this->admin)->delete("/admin/messages/{$message->id}");
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/logout');
        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_admin_can_trigger_firebase_sync(): void
    {
        \Illuminate\Support\Facades\Http::fake([
            '*' => \Illuminate\Support\Facades\Http::response(['status' => 'ok'], 200),
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/firebase/sync');
        $response->assertRedirect();
        $response->assertSessionHas('status');
    }
}
