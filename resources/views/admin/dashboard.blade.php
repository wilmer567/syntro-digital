@extends('layouts.admin')

@section('title', 'Panel Principal — Sytro Digital')
@section('header_title', 'Resumen General')

@section('content')
<div style="display: flex; flex-direction: column; gap: 28px;">
    <!-- Welcome Banner -->
    <div style="background: linear-gradient(135deg, rgba(13, 181, 192, 0.15) 0%, rgba(14, 32, 51, 0.9) 100%); border: 1px solid rgba(13, 181, 192, 0.3); border-radius: 14px; padding: 24px 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 16px;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 700; color: #ffffff; margin: 0 0 6px;">¡Hola, {{ auth()->user()->name }}! 👋</h2>
            <p style="margin: 0; color: #b5c7d8; font-size: 0.92rem;">
                Administra todo el contenido público de tu sitio web de <strong>Sytro Digital</strong> en tiempo real.
            </p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('home') }}" target="_blank" class="admin-btn-primary">
                <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>Ver Sitio Web en Vivo</span>
            </a>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px;">
        <!-- Servicios -->
        <div class="admin-card" style="margin: 0; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #8fa2b6; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Servicios</span>
                <span style="background: rgba(13, 181, 192, 0.15); color: #0db5c0; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #ffffff;">{{ $stats['services_count'] }}</div>
            <div style="color: #34d399; font-size: 0.8rem; margin-top: 4px;">{{ $stats['services_active'] }} activos en portada</div>
        </div>

        <!-- Proyectos -->
        <div class="admin-card" style="margin: 0; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #8fa2b6; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Proyectos</span>
                <span style="background: rgba(244, 199, 123, 0.15); color: #f4c77b; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                </span>
            </div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #ffffff;">{{ $stats['projects_count'] }}</div>
            <div style="color: #34d399; font-size: 0.8rem; margin-top: 4px;">{{ $stats['projects_active'] }} mostrados</div>
        </div>

        <!-- Principios -->
        <div class="admin-card" style="margin: 0; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #8fa2b6; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Principios / Valores</span>
                <span style="background: rgba(147, 51, 234, 0.15); color: #c084fc; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </span>
            </div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #ffffff;">{{ $stats['principles_count'] }}</div>
            <div style="color: #b5c7d8; font-size: 0.8rem; margin-top: 4px;">Pilares institucionales</div>
        </div>

        <!-- Mensajes de contacto -->
        <div class="admin-card" style="margin: 0; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #8fa2b6; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Mensajes</span>
                <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <div style="font-size: 1.8rem; font-weight: 700; color: #ffffff;">{{ $stats['messages_count'] }}</div>
            <div style="color: {{ $stats['messages_unread'] > 0 ? '#f87171' : '#34d399' }}; font-size: 0.8rem; margin-top: 4px; font-weight: 600;">
                {{ $stats['messages_unread'] }} sin leer
            </div>
        </div>
    </div>

    <!-- Quick Sections Navigation -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Acciones Rápidas de Edición</span>
            </h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
            <a href="{{ route('admin.settings.index') }}" style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--admin-border); border-radius: 10px; text-decoration: none; color: inherit; transition: all 0.2s ease;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(13, 181, 192, 0.15); display: flex; align-items: center; justify-content: center; color: #0db5c0; flex-shrink: 0;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <div style="font-weight: 600; color: #ffffff; font-size: 0.92rem;">Hero & Configuración</div>
                    <div style="color: #8fa2b6; font-size: 0.78rem;">Títulos, estadísticas, datos de contacto</div>
                </div>
            </a>

            <a href="{{ route('admin.services.index') }}" style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--admin-border); border-radius: 10px; text-decoration: none; color: inherit; transition: all 0.2s ease;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(244, 199, 123, 0.15); display: flex; align-items: center; justify-content: center; color: #f4c77b; flex-shrink: 0;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </div>
                <div>
                    <div style="font-weight: 600; color: #ffffff; font-size: 0.92rem;">Gestión de Servicios</div>
                    <div style="color: #8fa2b6; font-size: 0.78rem;">Tarjetas de servicios y colores</div>
                </div>
            </a>

            <a href="{{ route('admin.projects.index') }}" style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--admin-border); border-radius: 10px; text-decoration: none; color: inherit; transition: all 0.2s ease;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(52, 211, 153, 0.15); display: flex; align-items: center; justify-content: center; color: #34d399; flex-shrink: 0;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <div style="font-weight: 600; color: #ffffff; font-size: 0.92rem;">Vitrina de Proyectos</div>
                    <div style="color: #8fa2b6; font-size: 0.78rem;">Sectores atendidos y resultados</div>
                </div>
            </a>

            <a href="{{ route('admin.messages.index') }}" style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--admin-border); border-radius: 10px; text-decoration: none; color: inherit; transition: all 0.2s ease;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(239, 68, 68, 0.15); display: flex; align-items: center; justify-content: center; color: #f87171; flex-shrink: 0;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <div>
                    <div style="font-weight: 600; color: #ffffff; font-size: 0.92rem;">Bandeja de Mensajes</div>
                    <div style="color: #8fa2b6; font-size: 0.78rem;">Consultas de clientes potenciales</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Messages Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span>Últimas Consultas de Contacto</span>
            </h3>
            <a href="{{ route('admin.messages.index') }}" class="admin-btn-secondary admin-btn-sm">
                Ver todos los mensajes →
            </a>
        </div>

        @if($recentMessages->isEmpty())
            <div style="text-align: center; padding: 40px 20px; color: #8fa2b6;">
                <svg style="width: 44px; height: 44px; margin: 0 auto 12px; opacity: 0.4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p style="margin: 0; font-size: 0.95rem;">No hay mensajes de contacto registrados todavía.</p>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Email / Teléfono</th>
                            <th>Interés</th>
                            <th>Fecha</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMessages as $msg)
                            <tr>
                                <td>
                                    @if(!$msg->is_read)
                                        <span class="status-badge unread">● Nuevo</span>
                                    @else
                                        <span class="status-badge read">Leído</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600; color: #ffffff;">{{ $msg->name }}</td>
                                <td>
                                    <div>{{ $msg->email }}</div>
                                    @if($msg->phone)
                                        <div style="font-size: 0.76rem; color: #8fa2b6;">{{ $msg->phone }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span style="color: #0db5c0; font-size: 0.82rem;">{{ $msg->service_interest ?? 'Consulta general' }}</span>
                                </td>
                                <td style="color: #8fa2b6; font-size: 0.8rem;">
                                    {{ $msg->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="admin-btn-secondary admin-btn-sm">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Firebase Cloud Integration -->
    <div class="admin-card" style="border-color: rgba(244, 199, 123, 0.3); background: linear-gradient(135deg, rgba(14, 32, 51, 0.85) 0%, rgba(244, 199, 123, 0.05) 100%);">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 22px; height: 22px; color: #f4c77b;" viewBox="0 0 24 24" fill="currentColor"><path d="M4.14 16.94L6.96 1.76a.48.48 0 0 1 .91-.07l3.05 5.8-6.78 9.45zm15.72 0l-1.92-12.2a.48.48 0 0 0-.82-.26L3.89 17l7.35 4.14a1.5 1.5 0 0 0 1.5 0l7.12-4.2zm-9.35-7.79l2.42-4.63a.48.48 0 0 1 .86 0l2.42 4.63-5.7 7.94z"/></svg>
                <span>Conexión Firebase Cloud (exsamen-49932)</span>
            </h3>
            <span class="status-badge active">● Conectado</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <div style="background: rgba(0,0,0,0.25); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--admin-border);">
                <div style="font-size: 0.74rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700;">Proyecto Firebase</div>
                <div style="color: #ffffff; font-weight: 600; margin-top: 2px;">{{ config('firebase.project_id', 'exsamen-49932') }}</div>
            </div>

            <div style="background: rgba(0,0,0,0.25); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--admin-border);">
                <div style="font-size: 0.74rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700;">Realtime Database</div>
                <div style="color: #0db5c0; font-weight: 600; font-size: 0.84rem; margin-top: 2px; word-break: break-all;">
                    {{ config('firebase.database_url') }}
                </div>
            </div>

            <div style="background: rgba(0,0,0,0.25); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--admin-border);">
                <div style="font-size: 0.74rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700;">Storage Bucket</div>
                <div style="color: #f4c77b; font-weight: 600; font-size: 0.84rem; margin-top: 2px; word-break: break-all;">
                    {{ config('firebase.storage_bucket') }}
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-top: 1px solid var(--admin-border); padding-top: 16px;">
            <p style="margin: 0; color: #8fa2b6; font-size: 0.84rem; max-width: 580px;">
                Los mensajes de contacto enviados por los visitantes se guardan automáticamente en tu Realtime Database. Puedes sincronizar todos los servicios, proyectos y configuraciones con un solo clic.
            </p>

            <form action="{{ route('admin.firebase.sync') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-btn-secondary" style="border-color: rgba(244, 199, 123, 0.4); color: #f4c77b;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Sincronizar Contenido a Firebase</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
