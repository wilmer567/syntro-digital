<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_visit_to_home_is_recorded(): void
    {
        $this->assertDatabaseCount('visits', 0);

        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ])->get('/');

        $response->assertStatus(200);
        $this->assertDatabaseCount('visits', 1);

        $visit = Visit::first();
        $this->assertEquals('/', $visit->url);
        $this->assertEquals('desktop', $visit->device);
        $this->assertEquals('Chrome', $visit->browser);
        $this->assertEquals('Windows', $visit->platform);
        $this->assertNotEmpty($visit->ip_hash);
    }

    public function test_mobile_user_agent_is_detected(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
        ])->get('/');

        $response->assertStatus(200);
        $this->assertDatabaseCount('visits', 1);

        $visit = Visit::first();
        $this->assertEquals('mobile', $visit->device);
        $this->assertEquals('Safari', $visit->browser);
        $this->assertEquals('iOS', $visit->platform);
    }

    public function test_bot_crawler_is_ignored(): void
    {
        $response = $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        ])->get('/');

        $response->assertStatus(200);
        $this->assertDatabaseCount('visits', 0);
    }

    public function test_authenticated_user_visit_is_not_recorded(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $this->assertDatabaseCount('visits', 0);
    }

    public function test_admin_dashboard_renders_visit_metrics(): void
    {
        $user = User::factory()->create();

        // Create some sample visits
        Visit::create([
            'ip_hash' => hash('sha256', '192.168.1.10'),
            'url' => '/',
            'device' => 'desktop',
            'browser' => 'Chrome',
            'platform' => 'Windows',
        ]);

        Visit::create([
            'ip_hash' => hash('sha256', '192.168.1.11'),
            'url' => '/',
            'device' => 'mobile',
            'browser' => 'Safari',
            'platform' => 'iOS',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Contador y Estadísticas de Visitas');
        $response->assertSee('Total de Visitas');
        $response->assertSee('Visitantes Únicos');
        $response->assertSee('Tendencia de Tráfico');
        $response->assertSee('Dispositivos de Entrada');
    }
}
