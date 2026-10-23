@extends('layouts.admin')

@section('title', 'Mensajes de Contacto — Sytro Digital')
@section('header_title', 'Bandeja de Mensajes Recibidos')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <svg style="width: 20px; height: 20px; color: #f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <span>Consultas de Clientes ({{ $messages->total() }})</span>
        </h3>
        @if($unreadCount > 0)
            <span class="badge-count" style="margin-left: 0; padding: 4px 10px; font-size: 0.8rem;">
                {{ $unreadCount }} pendientes de leer
            </span>
        @endif
    </div>

    @if($messages->isEmpty())
        <div style="text-align: center; padding: 48px 20px; color: #8fa2b6;">
            <svg style="width: 50px; height: 50px; margin: 0 auto 12px; opacity: 0.35;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            <p style="margin: 0; font-size: 1rem;">No hay mensajes en la bandeja por el momento.</p>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Remitente</th>
                        <th>Contacto</th>
                        <th>Servicio de Interés</th>
                        <th>Fecha</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $msg)
                        <tr>
                            <td>
                                @if(!$msg->is_read)
                                    <span class="status-badge unread">● No leído</span>
                                @else
                                    <span class="status-badge read">Leído</span>
                                @endif
                            </td>
                            <td style="font-weight: 600; color: #ffffff;">{{ $msg->name }}</td>
                            <td>
                                <div>{{ $msg->email }}</div>
                                @if($msg->phone)
                                    <div style="font-size: 0.78rem; color: #8fa2b6;">{{ $msg->phone }}</div>
                                @endif
                            </td>
                            <td>
                                <span style="color: #0db5c0; font-size: 0.82rem;">{{ $msg->service_interest ?? 'Consulta general' }}</span>
                            </td>
                            <td style="color: #8fa2b6; font-size: 0.8rem;">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 8px;">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="admin-btn-secondary admin-btn-sm">
                                        Ver Mensaje
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('¿Eliminar este mensaje?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn-danger admin-btn-sm" title="Eliminar">
                                            &times;
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
