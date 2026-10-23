@extends('layouts.admin')

@section('title', 'Principios y Valores — Sytro Digital')
@section('header_title', 'Principios / Valores')

@section('content')
<div style="display: flex; flex-direction: column; gap: 28px;">

    <!-- Section Header Texts -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Encabezado de la Sección</span>
            </h3>
        </div>
        <form action="{{ route('admin.principles.header') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="principles_heading">Título de la Sección</label>
                <input type="text" id="principles_heading" name="principles_heading" class="admin-input" value="{{ old('principles_heading', $heading) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="principles_subheading">Subtítulo / Bajada</label>
                <textarea id="principles_subheading" name="principles_subheading" class="admin-textarea" rows="2">{{ old('principles_subheading', $subheading) }}</textarea>
            </div>
            <button type="submit" class="admin-btn-secondary admin-btn-sm">
                Guardar Títulos
            </button>
        </form>
    </div>

    <!-- Add New Principle -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Agregar Nuevo Principio</span>
            </h3>
        </div>
        <form action="{{ route('admin.principles.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="new_title">Nombre del Principio</label>
                    <input type="text" id="new_title" name="title" class="admin-input" placeholder="Ej: Transparencia total" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_order">Orden</label>
                    <input type="number" id="new_order" name="order" class="admin-input" value="{{ $principles->count() + 1 }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="new_desc">Descripción</label>
                <textarea id="new_desc" name="description" class="admin-textarea" rows="2" placeholder="Qué significa este principio en el trabajo del día a día..." required></textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #d1dfed; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: #0db5c0;">
                    <span>Mostrar en la web (Activo)</span>
                </label>

                <button type="submit" class="admin-btn-primary">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Crear Principio</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Principles List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>Principios Registrados ({{ $principles->count() }})</span>
            </h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($principles as $principle)
                <div style="background: rgba(8, 20, 34, 0.85); border: 1px solid var(--admin-border); border-radius: 10px; padding: 20px;">
                    <form action="{{ route('admin.principles.update', $principle) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; grid-template-columns: 1fr 100px; gap: 14px; margin-bottom: 12px;">
                            <div>
                                <label class="form-label">Nombre del Principio</label>
                                <input type="text" name="title" class="admin-input" value="{{ $principle->title }}" required>
                            </div>
                            <div>
                                <label class="form-label">Orden</label>
                                <input type="number" name="order" class="admin-input" value="{{ $principle->order }}" required>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 14px;">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="admin-textarea" rows="2" required>{{ $principle->description }}</textarea>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.86rem; color: #b5c7d8; cursor: pointer;">
                                <input type="checkbox" name="is_active" value="1" {{ $principle->is_active ? 'checked' : '' }} style="accent-color: #0db5c0;">
                                <span>Activo en el sitio</span>
                            </label>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <button type="submit" class="admin-btn-secondary admin-btn-sm" style="color: #6fe4d6;">
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Actualizar</span>
                                </button>
                    </form>
                                <form action="{{ route('admin.principles.destroy', $principle) }}" method="POST" onsubmit="return confirm('¿Eliminar este principio?');" style="margin: 0;">
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
                    No hay principios registrados actualmente.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
