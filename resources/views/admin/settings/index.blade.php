@extends('layouts.admin')

@section('title', 'Ajustes Generales y Hero — Sytro Digital')
@section('header_title', 'Ajustes Generales, Hero y Contacto')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
        <button type="submit" class="admin-btn-primary">
            <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Guardar Todos los Cambios</span>
        </button>
    </div>

    <!-- 1. HERO SECTION -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Sección Principal (Hero)</span>
            </h3>
            <span style="font-size: 0.8rem; color: #8fa2b6;">Lo primero que ven los visitantes al entrar</span>
        </div>

        <div class="form-group">
            <label class="form-label" for="hero_eyebrow">Distintivo superior (Eyebrow)</label>
            <input type="text" id="hero_eyebrow" name="hero_eyebrow" class="admin-input" value="{{ old('hero_eyebrow', $settings['hero_eyebrow'] ?? 'Ingeniería y estrategia digital · Ecuador') }}">
            <div class="form-hint">Aparece arriba del título principal con el punto indicador verde.</div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="hero_title_line1">Título Principal — Línea 1</label>
                <input type="text" id="hero_title_line1" name="hero_title_line1" class="admin-input" value="{{ old('hero_title_line1', $settings['hero_title_line1'] ?? 'Conectamos visión,') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="hero_title_line2">Título Principal — Línea 2 (Destacada)</label>
                <input type="text" id="hero_title_line2" name="hero_title_line2" class="admin-input" value="{{ old('hero_title_line2', $settings['hero_title_line2'] ?? 'código y resultados.') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="hero_description">Descripción o Párrafo del Hero</label>
            <textarea id="hero_description" name="hero_description" class="admin-textarea" rows="3" required>{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="hero_primary_text">Botón Principal (Texto)</label>
                <input type="text" id="hero_primary_text" name="hero_primary_text" class="admin-input" value="{{ old('hero_primary_text', $settings['hero_primary_text'] ?? 'Cuéntanos tu proyecto') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="hero_primary_url">Botón Principal (Enlace)</label>
                <input type="text" id="hero_primary_url" name="hero_primary_url" class="admin-input" value="{{ old('hero_primary_url', $settings['hero_primary_url'] ?? '#contacto') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="hero_secondary_text">Botón Secundario (Texto)</label>
                <input type="text" id="hero_secondary_text" name="hero_secondary_text" class="admin-input" value="{{ old('hero_secondary_text', $settings['hero_secondary_text'] ?? 'Ver proyectos realizados') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="hero_secondary_url">Botón Secundario (Enlace)</label>
                <input type="text" id="hero_secondary_url" name="hero_secondary_url" class="admin-input" value="{{ old('hero_secondary_url', $settings['hero_secondary_url'] ?? '#proyectos') }}">
            </div>
        </div>

        <!-- Hero Stats -->
        <div style="border-top: 1px solid var(--admin-border); padding-top: 18px; margin-top: 10px;">
            <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem; margin-bottom: 14px;">Estadísticas e Indicadores Clave del Hero</div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
                <!-- Stat 1 -->
                <div style="background: rgba(0, 0, 0, 0.2); padding: 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
                    <label class="form-label">Estadística 1</label>
                    <input type="text" name="stat_1_number" class="admin-input" placeholder="Ej: +3" value="{{ old('stat_1_number', $settings['stat_1_number'] ?? '+3') }}" style="margin-bottom: 8px;">
                    <input type="text" name="stat_1_text" class="admin-input" placeholder="Etiqueta" value="{{ old('stat_1_text', $settings['stat_1_text'] ?? 'Sectores institucionales atendidos') }}">
                </div>

                <!-- Stat 2 -->
                <div style="background: rgba(0, 0, 0, 0.2); padding: 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
                    <label class="form-label">Estadística 2</label>
                    <input type="text" name="stat_2_number" class="admin-input" placeholder="Ej: 100%" value="{{ old('stat_2_number', $settings['stat_2_number'] ?? '100%') }}" style="margin-bottom: 8px;">
                    <input type="text" name="stat_2_text" class="admin-input" placeholder="Etiqueta" value="{{ old('stat_2_text', $settings['stat_2_text'] ?? 'Proyectos con soporte post-entrega') }}">
                </div>

                <!-- Stat 3 -->
                <div style="background: rgba(0, 0, 0, 0.2); padding: 14px; border-radius: 8px; border: 1px solid var(--admin-border);">
                    <label class="form-label">Estadística 3</label>
                    <input type="text" name="stat_3_number" class="admin-input" placeholder="Ej: 1:1" value="{{ old('stat_3_number', $settings['stat_3_number'] ?? '1:1') }}" style="margin-bottom: 8px;">
                    <input type="text" name="stat_3_text" class="admin-input" placeholder="Etiqueta" value="{{ old('stat_3_text', $settings['stat_3_text'] ?? 'Trato directo con quien programa') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CONTACT & BUSINESS INFO -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Información de Contacto y Marca</span>
            </h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="brand_name">Nombre de Marca</label>
                <input type="text" id="brand_name" name="brand_name" class="admin-input" value="{{ old('brand_name', $settings['brand_name'] ?? 'Sytro Digital') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_email">Correo de Contacto</label>
                <input type="email" id="contact_email" name="contact_email" class="admin-input" value="{{ old('contact_email', $settings['contact_email'] ?? 'hola@sytrodigital.com') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_phone">Teléfono / WhatsApp</label>
                <input type="text" id="contact_phone" name="contact_phone" class="admin-input" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+593 99 000 0000') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_address">Ubicación / Ciudad</label>
                <input type="text" id="contact_address" name="contact_address" class="admin-input" value="{{ old('contact_address', $settings['contact_address'] ?? 'Riobamba, Ecuador') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_linkedin">Enlace LinkedIn / Red Social</label>
                <input type="text" id="contact_linkedin" name="contact_linkedin" class="admin-input" value="{{ old('contact_linkedin', $settings['contact_linkedin'] ?? '#contacto') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="site_description">Meta Descripción (SEO)</label>
                <input type="text" id="site_description" name="site_description" class="admin-input" value="{{ old('site_description', $settings['site_description'] ?? 'Sytro Digital: ingeniería, estrategia y software para instituciones y negocios.') }}">
            </div>
        </div>
    </div>

    <!-- 3. CALL TO ACTION (CTA) BANNER -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                <span>Banda de Llamado a la Acción (CTA)</span>
            </h3>
            <span style="font-size: 0.8rem; color: #8fa2b6;">Franja destacada antes del formulario y footer</span>
        </div>

        <div class="form-group">
            <label class="form-label" for="cta_heading">Frase Destacada</label>
            <input type="text" id="cta_heading" name="cta_heading" class="admin-input" value="{{ old('cta_heading', $settings['cta_heading'] ?? 'Tu siguiente sistema empieza con una conversación.') }}">
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="cta_button_text">Texto del Botón</label>
                <input type="text" id="cta_button_text" name="cta_button_text" class="admin-input" value="{{ old('cta_button_text', $settings['cta_button_text'] ?? 'Agenda tu auditoría gratuita') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="cta_button_url">Enlace o Acción del Botón</label>
                <input type="text" id="cta_button_url" name="cta_button_url" class="admin-input" value="{{ old('cta_button_url', $settings['cta_button_url'] ?? '#contacto') }}">
            </div>
        </div>
    </div>

    <!-- 4. FOOTER SETTINGS -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #8fa2b6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>Pie de Página (Footer)</span>
            </h3>
        </div>

        <div class="form-group">
            <label class="form-label" for="footer_about">Resumen / Descripción en Footer</label>
            <textarea id="footer_about" name="footer_about" class="admin-textarea" rows="2">{{ old('footer_about', $settings['footer_about'] ?? 'Ingeniería y estrategia digital para negocios e instituciones que necesitan sistemas confiables.') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="footer_copyright">Texto de Derechos Reservados</label>
                <input type="text" id="footer_copyright" name="footer_copyright" class="admin-input" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '© 2026 Sytro Digital. Todos los derechos reservados.') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="footer_tagline">Lema inferior</label>
                <input type="text" id="footer_tagline" name="footer_tagline" class="admin-input" value="{{ old('footer_tagline', $settings['footer_tagline'] ?? 'Conectando visión, código y resultados.') }}">
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 10px; margin-bottom: 40px;">
        <button type="submit" class="admin-btn-primary" style="padding: 12px 28px; font-size: 0.95rem;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Guardar Todos los Cambios</span>
        </button>
    </div>
</form>
@endsection
