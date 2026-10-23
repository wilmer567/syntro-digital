<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Principle;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an initial admin only when deployment secrets are supplied;
        // never reset an existing administrator's password during seeding.
        $initialAdmin = config('auth.initial_admin');

        if (filled($initialAdmin['email']) && filled($initialAdmin['password'])) {
            User::firstOrCreate(
                ['email' => $initialAdmin['email']],
                [
                    'name' => $initialAdmin['name'],
                    'password' => Hash::make($initialAdmin['password']),
                    'email_verified_at' => now(),
                ]
            );
        }

        // 2. Site Settings
        $settings = [
            // General / Brand
            ['key' => 'brand_name', 'value' => 'Sytro Digital', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Sytro Digital: ingeniería, estrategia y software para instituciones y negocios.', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hola@sytrodigital.com', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+593 99 000 0000', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => 'Riobamba, Ecuador', 'group' => 'general'],
            ['key' => 'contact_linkedin', 'value' => '#contacto', 'group' => 'general'],
            ['key' => 'footer_about', 'value' => 'Ingeniería y estrategia digital para negocios e instituciones que necesitan sistemas confiables.', 'group' => 'general'],
            ['key' => 'footer_copyright', 'value' => '© 2026 Sytro Digital. Todos los derechos reservados.', 'group' => 'general'],
            ['key' => 'footer_tagline', 'value' => 'Conectando visión, código y resultados.', 'group' => 'general'],

            // Hero Section
            ['key' => 'hero_eyebrow', 'value' => 'Ingeniería y estrategia digital · Ecuador', 'group' => 'hero'],
            ['key' => 'hero_title_line1', 'value' => 'Conectamos visión,', 'group' => 'hero'],
            ['key' => 'hero_title_line2', 'value' => 'código y resultados.', 'group' => 'hero'],
            ['key' => 'hero_description', 'value' => 'Diseñamos y construimos sistemas web para negocios e instituciones: portales de gestión, automatización de procesos y plataformas que se mantienen estables cuando el volumen crece.', 'group' => 'hero'],
            ['key' => 'hero_primary_text', 'value' => 'Cuéntanos tu proyecto', 'group' => 'hero'],
            ['key' => 'hero_primary_url', 'value' => '#contacto', 'group' => 'hero'],
            ['key' => 'hero_secondary_text', 'value' => 'Ver proyectos realizados', 'group' => 'hero'],
            ['key' => 'hero_secondary_url', 'value' => '#proyectos', 'group' => 'hero'],
            ['key' => 'stat_1_number', 'value' => '+3', 'group' => 'hero'],
            ['key' => 'stat_1_text', 'value' => 'Sectores institucionales atendidos', 'group' => 'hero'],
            ['key' => 'stat_2_number', 'value' => '100%', 'group' => 'hero'],
            ['key' => 'stat_2_text', 'value' => 'Proyectos con soporte post-entrega', 'group' => 'hero'],
            ['key' => 'stat_3_number', 'value' => '1:1', 'group' => 'hero'],
            ['key' => 'stat_3_text', 'value' => 'Trato directo con quien programa', 'group' => 'hero'],

            // Services Section Header
            ['key' => 'services_heading', 'value' => 'Una tecnología, aplicada a lo que tu institución necesita hoy.', 'group' => 'services'],
            ['key' => 'services_subheading', 'value' => 'Modernizamos, integramos y automatizamos procesos para resolver problemas reales con una arquitectura preparada para crecer.', 'group' => 'services'],

            // About Section
            ['key' => 'about_heading', 'value' => 'Un socio técnico cercano, no un proveedor más.', 'group' => 'about'],
            ['key' => 'about_subheading', 'value' => 'Trabajamos directamente con cooperativas, centros de salud, institutos y pequeños negocios que necesitan resultados claros, no jerga técnica.', 'group' => 'about'],
            ['key' => 'mission_kicker', 'value' => 'Misión', 'group' => 'about'],
            ['key' => 'mission_title', 'value' => 'Impulsar lo que sigue.', 'group' => 'about'],
            ['key' => 'mission_description', 'value' => 'Ayudar a negocios e instituciones a modernizar su operación con software escalable y decisiones tecnológicas bien fundamentadas, sin complejidad innecesaria.', 'group' => 'about'],
            ['key' => 'vision_kicker', 'value' => 'Visión 2030', 'group' => 'about'],
            ['key' => 'vision_title', 'value' => 'Ser referentes en evolución tecnológica.', 'group' => 'about'],
            ['key' => 'vision_description', 'value' => 'Consolidarnos como una firma referente en ingeniería de software y arquitectura en la nube para instituciones de la región.', 'group' => 'about'],

            // Principles Section Header
            ['key' => 'principles_heading', 'value' => 'La forma también importa.', 'group' => 'principles'],
            ['key' => 'principles_subheading', 'value' => 'Cinco principios que se notan en cada entrega, no solo en la propuesta.', 'group' => 'principles'],

            // Process Section Header
            ['key' => 'process_heading', 'value' => 'Cómo trabajamos, paso a paso.', 'group' => 'process'],
            ['key' => 'process_subheading', 'value' => 'Un proceso consultivo pensado para que sepas exactamente en qué etapa está tu proyecto.', 'group' => 'process'],

            // Projects Section Header
            ['key' => 'projects_heading', 'value' => 'Sistemas que ya están en operación.', 'group' => 'projects'],
            ['key' => 'projects_subheading', 'value' => 'Una muestra de plataformas diseñadas y construidas para resolver problemas reales.', 'group' => 'projects'],

            // CTA Section
            ['key' => 'cta_heading', 'value' => '¿Tienes un proyecto en mente?', 'group' => 'cta'],
            ['key' => 'cta_subheading', 'value' => 'Cuéntanos qué necesitas y te respondemos con una propuesta clara.', 'group' => 'cta'],
            ['key' => 'cta_button_text', 'value' => 'Escríbenos', 'group' => 'cta'],
            ['key' => 'cta_button_url', 'value' => '#contacto', 'group' => 'cta'],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'group' => $item['group']]
            );
        }

        // 3. Services
        if (Service::count() === 0) {
            Service::create([
                'title' => 'Software a la medida',
                'description' => 'Aplicaciones web, portales de autogestión y plataformas internas diseñadas alrededor de tus procesos.',
                'topline_color' => 'default',
                'order' => 1,
                'is_active' => true,
            ]);
            Service::create([
                'title' => 'Procesos conectados',
                'description' => 'Integramos APIs, pasarelas de pago y sistemas existentes para eliminar tareas repetitivas.',
                'topline_color' => 'alt',
                'order' => 2,
                'is_active' => true,
            ]);
            Service::create([
                'title' => 'Plataformas preparadas',
                'description' => 'Infraestructura en nube, buenas prácticas de seguridad y soporte continuo para sistemas que no pueden fallar.',
                'topline_color' => 'gold',
                'order' => 3,
                'is_active' => true,
            ]);
        }

        // 4. Principles
        if (Principle::count() === 0) {
            $principles = [
                ['title' => 'Rigor e innovación', 'description' => 'Código limpio, arquitectura segura y tecnología elegida con criterio, no por moda.', 'order' => 1],
                ['title' => 'Sinergia y cercanía', 'description' => 'Colaboración directa y transparente: trabajamos como parte de tu equipo, no como un tercero lejano.', 'order' => 2],
                ['title' => 'Escalabilidad sostenible', 'description' => 'Soluciones que se adaptan al crecimiento del negocio y optimizan recursos sin desperdiciar inversión.', 'order' => 3],
                ['title' => 'Integridad y confianza', 'description' => 'Información protegida, compromisos claros y entregas verificadas antes de pasar a la siguiente fase.', 'order' => 4],
                ['title' => 'Agilidad funcional', 'description' => 'Respuesta rápida al cambio con entregables útiles en cada etapa del proyecto.', 'order' => 5],
            ];
            foreach ($principles as $p) {
                Principle::create(array_merge($p, ['is_active' => true]));
            }
        }

        // 5. Process Steps
        if (ProcessStep::count() === 0) {
            $steps = [
                ['step_number' => '01', 'title' => 'Auditoría técnica inicial', 'description' => 'Revisamos tu operación actual, detectamos cuellos de botella y proponemos un camino claro.', 'order' => 1],
                ['step_number' => '02', 'title' => 'Propuesta y alcance', 'description' => 'Definimos entregables, tiempos y presupuesto en una propuesta escrita, sin letra pequeña ni sorpresas.', 'order' => 2],
                ['step_number' => '03', 'title' => 'Desarrollo consultivo', 'description' => 'Avanzamos en ciclos cortos, con prioridades transparentes y demostraciones funcionales en cada etapa.', 'order' => 3],
                ['step_number' => '04', 'title' => 'Entrega y soporte', 'description' => 'Capacitamos a tu equipo, documentamos el sistema y quedamos disponibles para mejorar y escalar.', 'order' => 4],
            ];
            foreach ($steps as $s) {
                ProcessStep::create(array_merge($s, ['is_active' => true]));
            }
        }

        // 6. Projects
        if (Project::count() === 0) {
            Project::create([
                'tag' => 'SECTOR FINANCIERO',
                'title' => 'Portal para cooperativa',
                'description' => 'Módulos de gestión y atención al socio con un sistema de diseño unificado.',
                'order' => 1,
                'is_active' => true,
            ]);
            Project::create([
                'tag' => 'EDUCACIÓN TÉCNICA',
                'title' => 'Sistema de bitácoras',
                'description' => 'Registro y seguimiento de actividades académicas para un instituto superior.',
                'order' => 2,
                'is_active' => true,
            ]);
            Project::create([
                'tag' => 'SALUD',
                'title' => 'Plataforma de citas médicas',
                'description' => 'Agenda en línea con perfiles para pacientes y administración.',
                'order' => 3,
                'is_active' => true,
            ]);
        }

        // 7. Initial contact message sample
        if (ContactMessage::count() === 0) {
            ContactMessage::create([
                'name' => 'Carlos Mendoza',
                'email' => 'carlos@instituto.edu.ec',
                'phone' => '+593 98 765 4321',
                'service_interest' => 'Software a la medida',
                'message' => 'Hola, estamos interesados en cotizar un sistema a medida para la gestión de matrículas y estudiantes de nuestro instituto. Quisiéramos agendar una reunión.',
                'is_read' => false,
            ]);
        }
    }
}
