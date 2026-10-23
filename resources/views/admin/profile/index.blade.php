@extends('layouts.admin')

@section('title', 'Mi Cuenta — Sytro Digital')
@section('header_title', 'Configuración de Mi Cuenta')

@section('content')
<div style="max-width: 800px; display: flex; flex-direction: column; gap: 24px;">

    <!-- Account Details -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Datos del Administrador</span>
            </h3>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="name">Nombre Completo</label>
                    <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Correo Electrónico (Usuario de acceso)</label>
                    <input type="email" id="email" name="email" class="admin-input" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <button type="submit" class="admin-btn-primary">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Actualizar Datos</span>
            </button>
        </form>
    </div>

    <!-- Password Change -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Cambiar Contraseña</span>
            </h3>
        </div>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="current_password">Contraseña Actual</label>
                <input type="password" id="current_password" name="current_password" class="admin-input" required placeholder="••••••••">
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" class="admin-input" required placeholder="Mínimo 6 caracteres">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="admin-input" required placeholder="Repite la nueva contraseña">
                </div>
            </div>

            <button type="submit" class="admin-btn-secondary" style="color: #f4c77b; border-color: rgba(244, 199, 123, 0.3);">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                <span>Actualizar Contraseña</span>
            </button>
        </form>
    </div>
</div>
@endsection
