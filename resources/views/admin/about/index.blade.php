@extends('layouts.admin')

@section('title', 'Nosotros, Misión y Visión — Sytro Digital')
@section('header_title', 'Nosotros, Misión y Visión')

@section('content')
<form action="{{ route('admin.about.update') }}" method="POST">
    @csrf

    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
        <button type="submit" class="admin-btn-primary">
            <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Guardar Cambios</span>
        </button>
    </div>

    <!-- Section Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Encabezado de la Sección Nosotros</span>
            </h3>
        </div>

        <div class="form-group">
            <label class="form-label" for="about_heading">Título Principal</label>
            <input type="text" id="about_heading" name="about_heading" class="admin-input" value="{{ old('about_heading', $about['about_heading']) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="about_subheading">Descripción / Subtítulo</label>
            <textarea id="about_subheading" name="about_subheading" class="admin-textarea" rows="3" required>{{ old('about_subheading', $about['about_subheading']) }}</textarea>
        </div>
    </div>

    <!-- Mission & Vision Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
        <!-- Misión -->
        <div class="admin-card" style="margin: 0;">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <svg style="width: 20px; height: 20px; color: #6fe4d6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Tarjeta de Misión</span>
                </h3>
            </div>

            <div class="form-group">
                <label class="form-label" for="mission_kicker">Etiqueta / Kicker</label>
                <input type="text" id="mission_kicker" name="mission_kicker" class="admin-input" value="{{ old('mission_kicker', $about['mission_kicker']) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="mission_title">Título</label>
                <input type="text" id="mission_title" name="mission_title" class="admin-input" value="{{ old('mission_title', $about['mission_title']) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="mission_description">Descripción de la Misión</label>
                <textarea id="mission_description" name="mission_description" class="admin-textarea" rows="4" required>{{ old('mission_description', $about['mission_description']) }}</textarea>
            </div>
        </div>

        <!-- Visión -->
        <div class="admin-card" style="margin: 0;">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Tarjeta de Visión</span>
                </h3>
            </div>

            <div class="form-group">
                <label class="form-label" for="vision_kicker">Etiqueta / Kicker</label>
                <input type="text" id="vision_kicker" name="vision_kicker" class="admin-input" value="{{ old('vision_kicker', $about['vision_kicker']) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="vision_title">Título</label>
                <input type="text" id="vision_title" name="vision_title" class="admin-input" value="{{ old('vision_title', $about['vision_title']) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="vision_description">Descripción de la Visión</label>
                <textarea id="vision_description" name="vision_description" class="admin-textarea" rows="4" required>{{ old('vision_description', $about['vision_description']) }}</textarea>
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
        <button type="submit" class="admin-btn-primary" style="padding: 11px 24px;">
            <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Guardar Cambios</span>
        </button>
    </div>
</form>
@endsection
