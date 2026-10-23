<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="{{ $settings['site_description'] ?? 'Sytro Digital: ingeniería, estrategia y software para instituciones y negocios.' }}">
    <title>{{ $settings['brand_name'] ?? 'Sytro Digital' }} — Ingeniería y Estrategia Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="topbar-inner">
                <a class="brand" href="#inicio" aria-label="{{ $settings['brand_name'] ?? 'Sytro Digital' }}, inicio">
                    <img src="{{ asset('images/sytro-digital.svg') }}" alt="{{ $settings['brand_name'] ?? 'Sytro Digital' }}" class="brand-logo">
                    <span class="brand-name">{{ $settings['brand_name'] ?? 'Sytro Digital' }}</span>
                </a>

                <nav class="main-nav" aria-label="Navegación principal">
                    <a href="#servicios">Servicios</a>
                    <a href="#nosotros">Nosotros</a>
                    <a href="#proceso">Cómo trabajamos</a>
                    <a href="#proyectos">Proyectos</a>
                </nav>

                <div style="display: flex; align-items: center; gap: 14px;">
                    <a class="header-button" href="#contacto">Hablemos</a>
                </div>
            </div>
        </header>

        <main class="content-shell">
            <!-- HERO SECTION -->
            <section class="hero" id="inicio">
                <div class="hero-copy">
                    <div class="eyebrow">
                        <span class="status-dot"></span>
                        <span>{{ $settings['hero_eyebrow'] ?? 'Ingeniería y estrategia digital · Ecuador' }}</span>
                    </div>

                    <h1>Conectamos<br>visión, código y<br><span>resultados.</span></h1>

                    <p>
                        {{ $settings['hero_description'] ?? 'Diseñamos y construimos sistemas web para negocios e instituciones: portales de gestión, automatización de procesos y plataformas que se mantienen estables cuando el volumen crece.' }}
                    </p>

                    <div class="hero-actions">
                        <a class="primary-button" href="{{ $settings['hero_primary_url'] ?? '#contacto' }}">
                            <span>{{ $settings['hero_primary_text'] ?? 'Cuéntanos tu proyecto' }}</span>
                            <span style="font-size: 1.15rem; line-height: 1;">→</span>
                        </a>
                        <a class="secondary-link" href="{{ $settings['hero_secondary_url'] ?? '#proyectos' }}">
                            {{ $settings['hero_secondary_text'] ?? 'Ver proyectos realizados' }}
                        </a>
                    </div>
                </div>

                <!-- 3D WORLD IN MOTION (EL MUNDO EN MOVIMIENTO) -->
                <div class="hero-visual" aria-label="El mundo de Sytro Digital en movimiento 3D">
                    <!-- Ambient Radial Glow -->
                    <div class="globe-ambient-glow"></div>

                    <!-- 3D Stage -->
                    <div class="globe-stage">
                        <!-- 3D Wireframe Spinning Globe Sphere -->
                        <div class="globe-sphere">
                            <!-- Parallel Latitude Rings -->
                            <div class="globe-lat lat-top"></div>
                            <div class="globe-lat lat-upper"></div>
                            <div class="globe-lat lat-equator"></div>
                            <div class="globe-lat lat-lower"></div>
                            <div class="globe-lat lat-bottom"></div>

                            <!-- Rotating 3D Meridian Rings -->
                            <div class="globe-meridian meridian-1"></div>
                            <div class="globe-meridian meridian-2"></div>
                            <div class="globe-meridian meridian-3"></div>
                            <div class="globe-meridian meridian-4"></div>
                            <div class="globe-meridian meridian-5"></div>
                            <div class="globe-meridian meridian-6"></div>
                        </div>

                        <!-- Tilted Outer Orbit -->
                        <div class="orbit-ring-outer"></div>

                        <!-- Inner Rotating Orbit with Traveling Satellite Beacon -->
                        <div class="orbit-ring-inner">
                            <span class="orbit-satellite"></span>
                        </div>

                        <!-- Floating 3D Sytro Emblem at Center -->
                        <div class="globe-core">
                            <img src="{{ asset('images/logodigital.png') }}" alt="Emblema S de Sytro Digital" class="core-emblem">
                            <div class="core-light"></div>
                        </div>

                        <!-- Floating Glass Badges with Glowing Indicators -->
                        <div class="floating-badge badge-portals">
                            <span class="badge-dot"></span>
                            <span>Portales de gestión</span>
                        </div>

                        <div class="floating-badge badge-automation">
                            <span class="badge-dot"></span>
                            <span>Automatización</span>
                        </div>

                        <div class="floating-badge badge-support">
                            <span class="badge-dot"></span>
                            <span>Soporte post-entrega</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FULL-WIDTH GRADIENT STATS BANNER -->
            <section class="hero-stats-banner">
                <div class="stats-banner-inner">
                    <div class="stat-banner-item">
                        <span class="stat-banner-number">{{ $settings['stat_1_number'] ?? '+3' }}</span>
                        <span class="stat-banner-label">{{ $settings['stat_1_text'] ?? 'Sectores institucionales atendidos' }}</span>
                    </div>
                    <div class="stat-banner-item">
                        <span class="stat-banner-number">{{ $settings['stat_2_number'] ?? '100%' }}</span>
                        <span class="stat-banner-label">{{ $settings['stat_2_text'] ?? 'Proyectos con soporte post-entrega' }}</span>
                    </div>
                    <div class="stat-banner-item">
                        <span class="stat-banner-number">{{ $settings['stat_3_number'] ?? 'Web' }}</span>
                        <span class="stat-banner-label">{{ $settings['stat_3_text'] ?? 'Sistemas a medida, de diseño a producción' }}</span>
                    </div>
                </div>
            </section>

            <!-- SERVICES SECTION -->
            <section class="services section" id="servicios">
                <div class="section-header narrow">
                    <h2>{{ $settings['services_heading'] ?? 'Una tecnología, aplicada a lo que tu institución necesita hoy.' }}</h2>
                    <p>
                        {{ $settings['services_subheading'] ?? 'Modernizamos, integramos y automatizamos procesos para resolver problemas reales con una arquitectura preparada para crecer.' }}
                    </p>
                </div>

                <div class="feature-grid">
                    @forelse($services as $service)
                        <article class="feature-card">
                            <span class="feature-topline {{ $service->topline_color === 'alt' ? 'alt' : ($service->topline_color === 'gold' ? 'gold' : '') }}"></span>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                        </article>
                    @empty
                        <article class="feature-card">
                            <span class="feature-topline"></span>
                            <h3>Software a la medida</h3>
                            <p>Aplicaciones web, portales de autogestión y plataformas internas diseñadas alrededor de tus procesos.</p>
                        </article>
                    @endforelse
                </div>
            </section>

            <!-- ABOUT US SECTION -->
            <section class="about section" id="nosotros">
                <div class="section-header split">
                    <h2>{{ $settings['about_heading'] ?? 'Un socio técnico cercano, no un proveedor más.' }}</h2>
                    <p>
                        {{ $settings['about_subheading'] ?? 'Trabajamos directamente con cooperativas, centros de salud, institutos y pequeños negocios que necesitan resultados claros, no jerga técnica.' }}
                    </p>
                </div>

                <div class="mission-grid">
                    <article class="mission-card">
                        <span class="card-kicker">{{ $settings['mission_kicker'] ?? 'Misión' }}</span>
                        <h3>{{ $settings['mission_title'] ?? 'Impulsar lo que sigue.' }}</h3>
                        <p>
                            {{ $settings['mission_description'] ?? 'Ayudar a negocios e instituciones a modernizar su operación con software escalable y decisiones tecnológicas bien fundamentadas, sin complejidad innecesaria.' }}
                        </p>
                    </article>

                    <article class="mission-card alt-card">
                        <span class="card-kicker">{{ $settings['vision_kicker'] ?? 'Visión 2030' }}</span>
                        <h3>{{ $settings['vision_title'] ?? 'Ser referentes en evolución tecnológica.' }}</h3>
                        <p>
                            {{ $settings['vision_description'] ?? 'Consolidarnos como una firma referente en ingeniería de software y arquitectura en la nube para instituciones de la región.' }}
                        </p>
                    </article>
                </div>
            </section>

            <!-- PRINCIPLES SECTION -->
            <section class="principles section" id="proceso">
                <div class="section-header values-head">
                    <h2>{{ $settings['principles_heading'] ?? 'La forma también importa.' }}</h2>
                    <p>{{ $settings['principles_subheading'] ?? 'Cinco principios que se notan en cada entrega, no solo en la propuesta.' }}</p>
                </div>

                <div class="values-grid">
                    @forelse($principles as $principle)
                        <article class="value-row">
                            <h4>{{ $principle->title }}</h4>
                            <p>{{ $principle->description }}</p>
                        </article>
                    @empty
                        <article class="value-row">
                            <h4>Rigor e innovación</h4>
                            <p>Código limpio, arquitectura segura y tecnología elegida con criterio, no por moda.</p>
                        </article>
                    @endforelse
                </div>
            </section>

            <!-- PROCESS / HOW WE WORK SECTION -->
            <section class="process section">
                <div class="section-header center">
                    <h2>{{ $settings['process_heading'] ?? 'Cómo trabajamos, paso a paso.' }}</h2>
                    <p>{{ $settings['process_subheading'] ?? 'Un proceso consultivo pensado para que sepas exactamente en qué etapa está tu proyecto.' }}</p>
                </div>

                <div class="timeline">
                    @forelse($processSteps as $step)
                        <article class="timeline-item">
                            <span class="timeline-number">{{ $step->step_number }}</span>
                            <div>
                                <h3>{{ $step->title }}</h3>
                                <p>{{ $step->description }}</p>
                            </div>
                        </article>
                    @empty
                        <article class="timeline-item">
                            <span class="timeline-number">01</span>
                            <div>
                                <h3>Auditoría técnica inicial</h3>
                                <p>Revisamos tu operación actual, detectamos cuellos de botella y proponemos un camino claro.</p>
                            </div>
                        </article>
                    @endforelse
                </div>
            </section>

            <!-- PROJECTS SECTION (Sistemas que ya están en operación) -->
            <section class="projects section" id="proyectos">
                <div class="section-header center">
                    <h2>{{ $settings['projects_heading'] ?? 'Sistemas que ya están en operación.' }}</h2>
                    <p>{{ $settings['projects_subheading'] ?? 'Una muestra de plataformas diseñadas y construidas para resolver problemas reales.' }}</p>
                </div>

                <div class="project-grid">
                    @forelse($projects as $project)
                        <article class="project-card">
                            <div class="card-deco-circle"></div>
                            @if($project->image_url || $project->images->isNotEmpty())
                                <div class="project-image-wrap" data-image-gallery>
                                    @if($project->image_url)
                                        <img src="{{ $project->image_url }}" alt="{{ $project->image_description ?: $project->title }}" data-image-caption="{{ $project->image_description ?: $project->title }}" loading="lazy" data-fullscreen-image role="button" tabindex="0" aria-label="Ver imagen completa: {{ $project->title }}">
                                    @endif
                                    @foreach($project->images as $projectImage)
                                        <img src="{{ $projectImage->url }}" alt="{{ $projectImage->description ?: $project->title }}" data-image-caption="{{ $projectImage->description ?: $project->title }}" loading="lazy" data-fullscreen-image role="button" tabindex="0" aria-label="Ver imagen completa: {{ $project->title }}">
                                    @endforeach
                                </div>
                            @endif
                            <span class="project-tag">{{ $project->tag }}</span>
                            <h3>{{ $project->title }}</h3>
                            <p>{{ $project->description }}</p>
                            @if($project->result)
                                <div class="project-result">{{ $project->result }}</div>
                            @endif
                            @if($project->url)
                                <div class="project-link-wrap">
                                    <a href="{{ $project->url }}" target="_blank" class="project-link">
                                        <span>Conocer más</span>
                                        <span>↗</span>
                                    </a>
                                </div>
                            @endif
                        </article>
                    @empty
                        <article class="project-card">
                            <div class="card-deco-circle"></div>
                            <span class="project-tag">SECTOR FINANCIERO</span>
                            <h3>Portal para cooperativa</h3>
                            <p>Módulos de gestión y atención al socio con un sistema de diseño unificado.</p>
                        </article>
                        <article class="project-card">
                            <div class="card-deco-circle"></div>
                            <span class="project-tag">EDUCACIÓN TÉCNICA</span>
                            <h3>Sistema de bitácoras</h3>
                            <p>Registro y seguimiento de actividades académicas para un instituto superior.</p>
                        </article>
                        <article class="project-card">
                            <div class="card-deco-circle"></div>
                            <span class="project-tag">SALUD</span>
                            <h3>Plataforma de citas médicas</h3>
                            <p>Agenda en línea con perfiles para pacientes y administración.</p>
                        </article>
                    @endforelse
                </div>
            </section>

            <!-- CTA BANNER SECTION (¿Tienes un proyecto en mente?) -->
            <section class="cta-banner-section section">
                <div class="cta-gradient-card">
                    <div class="cta-circle-deco-bottom"></div>
                    <div class="cta-circle-deco-top"></div>
                    <div class="cta-content">
                        <h2>{{ $settings['cta_heading'] ?? '¿Tienes un proyecto en mente?' }}</h2>
                        <p>{{ $settings['cta_subheading'] ?? 'Cuéntanos qué necesitas y te respondemos con una propuesta clara.' }}</p>
                        <a class="cta-pill-button" href="{{ $settings['cta_button_url'] ?? '#contacto' }}">
                            <span>{{ trim(str_replace('→', '', $settings['cta_button_text'] ?? 'Escríbenos')) }}</span>
                            <span style="font-size: 1.15rem; line-height: 1;">→</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- CONTACT SECTION & FORM -->
            <section class="contact-section section" id="contacto">
                <div class="contact-card-grid">
                    <div class="contact-info-col">
                        <div>
                            <div class="eyebrow" style="margin-bottom: 12px;">
                                <span class="status-dot"></span>
                                Inicia tu proyecto
                            </div>
                            <h3>Conversemos sobre lo que tu empresa necesita.</h3>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="contact-info-meta">
                                <span>Correo directo</span>
                                <a href="mailto:{{ $settings['contact_email'] ?? 'hola@sytrodigital.com' }}">
                                    {{ $settings['contact_email'] ?? 'hola@sytrodigital.com' }}
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="contact-info-meta">
                                <span>Teléfono / WhatsApp</span>
                                <a href="tel:{{ $settings['contact_phone'] ?? '+593 99 000 0000' }}">
                                    {{ $settings['contact_phone'] ?? '+593 99 000 0000' }}
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="contact-info-meta">
                                <span>Sede</span>
                                <p>{{ $settings['contact_address'] ?? 'Riobamba, Ecuador' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-col">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            {{-- Honeypot trap for automated spam bots --}}
                            <div style="position: absolute; left: -9999px; top: -9999px; opacity: 0; pointer-events: none;" aria-hidden="true">
                                <label for="hp_contact_check">No completar este campo</label>
                                <input type="text" id="hp_contact_check" name="hp_contact_check" tabindex="-1" autocomplete="off" value="">
                            </div>

                            @if(session('contact_success'))
                                <div class="contact-success-box">
                                    {{ session('contact_success') }}
                                </div>
                            @endif

                            <div>
                                <label class="contact-label" for="contact_name">Tu Nombre *</label>
                                <input type="text" id="contact_name" name="name" class="contact-input" placeholder="Nombre o Institución" required value="{{ old('name') }}">
                            </div>

                            <div>
                                <label class="contact-label" for="contact_email_input">Tu Correo *</label>
                                <input type="email" id="contact_email_input" name="email" class="contact-input" placeholder="correo@ejemplo.com" required value="{{ old('email') }}">
                            </div>

                            <div>
                                <label class="contact-label" for="contact_phone_input">Teléfono</label>
                                <input type="text" id="contact_phone_input" name="phone" class="contact-input" placeholder="+593 99..." value="{{ old('phone') }}">
                            </div>

                            <div>
                                <label class="contact-label" for="contact_service">Servicio de Interés</label>
                                <select id="contact_service" name="service_interest" class="contact-select">
                                    <option value="Software a la medida">Software a la medida</option>
                                    <option value="Procesos conectados y APIs">Procesos conectados y APIs</option>
                                    <option value="Plataformas en nube">Plataformas en nube</option>
                                    <option value="Auditoría técnica">Auditoría técnica</option>
                                    <option value="Otro requerimiento">Otro requerimiento</option>
                                </select>
                            </div>

                            <div class="full-width">
                                <label class="contact-label" for="contact_msg">Cuéntanos sobre tu proyecto o consulta *</label>
                                <textarea id="contact_msg" name="message" class="contact-textarea" rows="4" placeholder="Describe brevemente tus necesidades, objetivos o dudas..." required>{{ old('message') }}</textarea>
                            </div>

                            <div class="full-width">
                                <button type="submit" class="primary-button" style="width: 100%; justify-content: center; cursor: pointer; border: none;">
                                    Enviar Mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a class="brand footer-brand-link" href="#inicio" aria-label="{{ $settings['brand_name'] ?? 'Sytro Digital' }}, inicio">
                        <img src="{{ asset('images/sytro-digital.svg') }}" alt="{{ $settings['brand_name'] ?? 'Sytro Digital' }}" class="brand-logo small-logo">
                        <span class="brand-name">{{ $settings['brand_name'] ?? 'Sytro Digital' }}</span>
                    </a>
                    <p>{{ $settings['footer_about'] ?? 'Ingeniería y estrategia digital para negocios e instituciones que necesitan sistemas confiables.' }}</p>
                </div>

                <div class="footer-col">
                    <h4>Navegación</h4>
                    <ul>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="#proceso">Cómo trabajamos</a></li>
                        <li><a href="#proyectos">Proyectos</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Servicios</h4>
                    <ul>
                        @foreach($services->take(4) as $s)
                            <li><a href="#servicios">{{ $s->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Contacto</h4>
                    <ul>
                        <li><a href="mailto:{{ $settings['contact_email'] ?? 'hola@sytrodigital.com' }}">{{ $settings['contact_email'] ?? 'hola@sytrodigital.com' }}</a></li>
                        <li><a href="tel:{{ $settings['contact_phone'] ?? '+593990000000' }}">{{ $settings['contact_phone'] ?? '+593 99 000 0000' }}</a></li>
                        <li><span>{{ $settings['contact_address'] ?? 'Riobamba, Ecuador' }}</span></li>
                        @if(!empty($settings['contact_linkedin']))
                            <li><a href="{{ $settings['contact_linkedin'] }}" target="_blank">LinkedIn</a></li>
                        @endif
                        <li style="margin-top: 10px; border-top: 1px solid var(--line); padding-top: 10px;">
                            <a href="{{ route('admin.dashboard') }}" style="color: #6fe4d6; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Panel de Administración</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>{{ $settings['footer_copyright'] ?? '© 2026 Sytro Digital. Todos los derechos reservados.' }}</span>
                <span>{{ $settings['footer_tagline'] ?? 'Conectando visión, código y resultados.' }}</span>
            </div>
        </footer>
    </div>

    <dialog class="image-lightbox" data-image-lightbox aria-label="Visor de imágenes">
        <form method="dialog" class="image-lightbox-close-form">
            <button class="image-lightbox-close" type="submit" data-lightbox-close aria-label="Cerrar imagen" autofocus><span>Cerrar</span><span aria-hidden="true">&times;</span></button>
        </form>
        <button class="image-lightbox-nav image-lightbox-prev" type="button" data-lightbox-prev aria-label="Imagen anterior">&#10094;</button>
        <figure class="image-lightbox-figure">
            <img data-lightbox-image alt="">
            <figcaption data-lightbox-caption></figcaption>
        </figure>
        <button class="image-lightbox-nav image-lightbox-next" type="button" data-lightbox-next aria-label="Imagen siguiente">&#10095;</button>
        <span class="image-lightbox-counter" data-lightbox-counter aria-live="polite"></span>
        <span class="image-lightbox-hint">Pulsa Esc o haz clic en la imagen para salir</span>
    </dialog>
</body>
</html>
