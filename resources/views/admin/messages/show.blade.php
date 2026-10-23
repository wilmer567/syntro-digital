@extends('layouts.admin')

@section('title', 'Detalle del Mensaje — Sytro Digital')
@section('header_title', 'Mensaje de ' . $message->name)

@section('content')
<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;">
    <div>
        <a href="{{ route('admin.messages.index') }}" class="admin-btn-secondary admin-btn-sm" style="margin-bottom: 16px;">
            ← Volver a la bandeja
        </a>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title" style="margin-bottom: 4px;">{{ $message->name }}</h3>
                <span style="color: #8fa2b6; font-size: 0.82rem;">Recibido el {{ $message->created_at->format('d/m/Y \a \l\a\s H:i') }}</span>
            </div>
            <div>
                @if($message->is_read)
                    <span class="status-badge read">Leído</span>
                @else
                    <span class="status-badge unread">● No leído</span>
                @endif
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--admin-border);">
            <div>
                <div style="font-size: 0.76rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Correo</div>
                <a href="mailto:{{ $message->email }}" style="color: #0db5c0; font-weight: 600; text-decoration: none;">
                    {{ $message->email }}
                </a>
            </div>

            <div>
                <div style="font-size: 0.76rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Teléfono</div>
                @if($message->phone)
                    <a href="tel:{{ $message->phone }}" style="color: #f4c77b; font-weight: 600; text-decoration: none;">
                        {{ $message->phone }}
                    </a>
                @else
                    <span style="color: #8fa2b6;">No especificado</span>
                @endif
            </div>

            <div>
                <div style="font-size: 0.76rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Servicio de Interés</div>
                <span style="color: #ffffff; font-weight: 500;">
                    {{ $message->service_interest ?? 'Consulta general' }}
                </span>
            </div>
        </div>

        <div style="margin-bottom: 28px;">
            <div style="font-size: 0.76rem; color: #8fa2b6; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Mensaje</div>
            <div style="background: rgba(6, 17, 28, 0.85); border: 1px solid var(--admin-border); border-radius: 8px; padding: 18px; line-height: 1.6; color: #edf3f8; white-space: pre-wrap; font-size: 0.95rem;">{{ $message->message }}</div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-top: 1px solid var(--admin-border); padding-top: 20px;">
            <div style="display: flex; gap: 10px;">
                <a href="mailto:{{ $message->email }}?subject=Respuesta de Sytro Digital" class="admin-btn-primary">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Responder por Correo</span>
                </a>

                @if($message->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="admin-btn-secondary" style="color: #34d399;">
                        <span>WhatsApp ↗</span>
                    </a>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <form action="{{ route('admin.messages.toggleRead', $message) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="admin-btn-secondary admin-btn-sm">
                        {{ $message->is_read ? 'Marcar como no leído' : 'Marcar como leído' }}
                    </button>
                </form>

                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este mensaje de forma permanente?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn-danger admin-btn-sm">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
