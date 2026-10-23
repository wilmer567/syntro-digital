@extends('layouts.admin')

@section('title', 'Gestión de Servicios — Sytro Digital')
@section('header_title', 'Servicios')

@section('content')
<div style="display: flex; flex-direction: column; gap: 28px;">

    <!-- Section Header Texts -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Encabezado de la Sección de Servicios</span>
            </h3>
        </div>
        <form action="{{ route('admin.services.header') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="services_heading">Título de la Sección</label>
                <input type="text" id="services_heading" name="services_heading" class="admin-input" value="{{ old('services_heading', $heading) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="services_subheading">Subtítulo / Descripción</label>
                <textarea id="services_subheading" name="services_subheading" class="admin-textarea" rows="2">{{ old('services_subheading', $subheading) }}</textarea>
            </div>
            <button type="submit" class="admin-btn-secondary admin-btn-sm">
                Guardar Títulos de Sección
            </button>
        </form>
    </div>

    <!-- Add New Service -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Agregar Nuevo Servicio</span>
            </h3>
        </div>
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="new_title">Nombre del Servicio</label>
                    <input type="text" id="new_title" name="title" class="admin-input" placeholder="Ej: Auditoría de Seguridad" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_topline">Estilo de Línea Superior</label>
                    <select id="new_topline" name="topline_color" class="admin-select" required>
                        <option value="default">Cian / Turquesa (Estándar)</option>
                        <option value="alt">Azul / Gradiente Alternativo</option>
                        <option value="gold">Dorado / Oro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_order">Orden de Aparición</label>
                    <input type="number" id="new_order" name="order" class="admin-input" value="{{ $services->count() + 1 }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="new_description">Descripción del Servicio</label>
                <textarea id="new_description" name="description" class="admin-textarea" rows="2" placeholder="Detalle qué soluciona o qué incluye este servicio..." required></textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #d1dfed; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: #0db5c0;">
                    <span>Mostrar este servicio en el sitio web (Activo)</span>
                </label>

                <button type="submit" class="admin-btn-primary">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Crear Servicio</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Current Services List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>Servicios Registrados ({{ $services->count() }})</span>
            </h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($services as $service)
                <div style="background: rgba(8, 20, 34, 0.85); border: 1px solid var(--admin-border); border-radius: 10px; padding: 20px;">
                    <form action="{{ route('admin.services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 12px;">
                            <div>
                                <label class="form-label">Título</label>
                                <input type="text" name="title" class="admin-input" value="{{ $service->title }}" required>
                            </div>
                            <div>
                                <label class="form-label">Color de Línea</label>
                                <select name="topline_color" class="admin-select" required>
                                    <option value="default" {{ $service->topline_color == 'default' ? 'selected' : '' }}>Cian / Turquesa</option>
                                    <option value="alt" {{ $service->topline_color == 'alt' ? 'selected' : '' }}>Azul / Alternativo</option>
                                    <option value="gold" {{ $service->topline_color == 'gold' ? 'selected' : '' }}>Dorado / Oro</option>
                                </select>
                            </div>
                            <div style="max-width: 120px;">
                                <label class="form-label">Orden</label>
                                <input type="number" name="order" class="admin-input" value="{{ $service->order }}" required>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 14px;">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="admin-textarea" rows="2" required>{{ $service->description }}</textarea>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.86rem; color: #b5c7d8; cursor: pointer;">
                                <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }} style="accent-color: #0db5c0;">
                                <span>Activo en portada</span>
                            </label>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <button type="submit" class="admin-btn-secondary admin-btn-sm" style="color: #6fe4d6;">
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Actualizar</span>
                                </button>
                    </form>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn-danger">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                </div>
            @empty
                <div style="text-align: center; padding: 30px; color: #8fa2b6;">
                    No hay servicios configurados actualmente.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
