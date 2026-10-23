<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Control') — Sytro Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --admin-bg: #061524;
            --admin-sidebar: #091c2f;
            --admin-card: rgba(14, 32, 51, 0.75);
            --admin-border: rgba(140, 165, 195, 0.16);
            --admin-accent: #0db5c0;
            --admin-accent-glow: rgba(13, 181, 192, 0.2);
            --admin-gold: #f4c77b;
            --admin-text: #edf3f8;
            --admin-muted: #8fa2b6;
        }

        body.admin-body {
            background-color: var(--admin-bg);
            color: var(--admin-text);
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 270px;
            background: var(--admin-sidebar);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 40;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 22px 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            width: 36px;
            height: auto;
        }

        .sidebar-brand .brand-title {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand .brand-badge {
            font-size: 0.65rem;
            color: var(--admin-accent);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 20px 14px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-label {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--admin-muted);
            padding: 10px 14px 4px;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #b5c7d8;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(13, 181, 192, 0.18) 0%, rgba(13, 181, 192, 0.05) 100%);
            border-left: 3px solid var(--admin-accent);
            padding-left: 11px;
            font-weight: 600;
        }

        .sidebar-link svg {
            width: 19px;
            height: 19px;
            opacity: 0.85;
            flex-shrink: 0;
        }

        .sidebar-link.active svg {
            opacity: 1;
            color: var(--admin-accent);
        }

        .badge-count {
            margin-left: auto;
            background: #ef4444;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Main Content Area */
        .admin-main {
            flex: 1;
            margin-left: 270px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: radial-gradient(circle at 80% 10%, rgba(13, 181, 192, 0.04) 0%, transparent 40%);
        }

        .admin-header {
            height: 68px;
            background: rgba(9, 28, 47, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .header-title-wrap h1 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-view-site {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #d1e2f2;
            border: 1px solid var(--admin-border);
            border-radius: 7px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.04);
            text-decoration: none;
        }

        .btn-view-site:hover {
            border-color: var(--admin-accent);
            color: #ffffff;
            background: rgba(13, 181, 192, 0.1);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0db5c0 0%, #075a6c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-content {
            padding: 32px;
            flex: 1;
        }

        /* Flash Alerts */
        .admin-alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #a7f3d0;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .admin-alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        /* Generic Admin Components */
        .admin-card {
            background: var(--admin-card);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 24px;
            backdrop-filter: blur(8px);
            margin-bottom: 24px;
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--admin-border);
            margin-bottom: 22px;
        }

        .admin-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #0db5c0 0%, #089ba4 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .admin-btn-primary:hover {
            filter: brightness(1.1);
            box-shadow: 0 4px 14px rgba(13, 181, 192, 0.35);
        }

        .admin-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.07);
            color: #dbe7f3;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid var(--admin-border);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .admin-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .admin-btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .admin-btn-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .admin-btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Inputs & Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: #d1dfed;
            margin-bottom: 6px;
        }

        .form-hint {
            font-size: 0.76rem;
            color: var(--admin-muted);
            margin-top: 4px;
        }

        .admin-input, .admin-textarea, .admin-select {
            width: 100%;
            background: rgba(8, 20, 34, 0.85);
            border: 1px solid rgba(140, 165, 195, 0.25);
            border-radius: 8px;
            padding: 10px 14px;
            color: #ffffff;
            font-size: 0.9rem;
            font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box;
        }

        .admin-input:focus, .admin-textarea:focus, .admin-select:focus {
            outline: none;
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 3px rgba(13, 181, 192, 0.2);
        }

        .admin-textarea {
            resize: vertical;
            min-height: 90px;
        }

        /* Tables */
        .admin-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            background: rgba(9, 23, 37, 0.6);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.88rem;
        }

        .admin-table th {
            padding: 14px 18px;
            background: rgba(14, 34, 55, 0.85);
            color: #9bb1c8;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table td {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(140, 165, 195, 0.08);
            color: #edf3f8;
            vertical-align: middle;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 0.74rem;
            font-weight: 600;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-badge.inactive {
            background: rgba(156, 163, 175, 0.15);
            color: #9ca3af;
            border: 1px solid rgba(156, 163, 175, 0.25);
        }

        .status-badge.unread {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-badge.read {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.25);
        }

        /* Mobile Responsive */
        .mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            color: #ffffff;
            cursor: pointer;
            padding: 6px;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .admin-content {
                padding: 18px;
            }

            .admin-header {
                padding: 0 18px;
            }
        }
    </style>
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('images/sytro-digital.svg') }}" alt="Sytro Logo">
                <div class="brand-title">
                    <span>Sytro Digital</span>
                    <span class="brand-badge">Administración</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <span class="nav-label">General</span>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Resumen</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Ajustes & Hero</span>
                </a>

                <span class="nav-label">Contenido Web</span>
                <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Servicios</span>
                </a>

                <a href="{{ route('admin.about.index') }}" class="sidebar-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Nosotros & Visión</span>
                </a>

                <a href="{{ route('admin.principles.index') }}" class="sidebar-link {{ request()->routeIs('admin.principles.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Principios / Valores</span>
                </a>

                <a href="{{ route('admin.process.index') }}" class="sidebar-link {{ request()->routeIs('admin.process.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Cómo trabajamos</span>
                </a>

                <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    <span>Proyectos</span>
                </a>

                <span class="nav-label">Interacción</span>
                @php $unreadNav = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Mensajes recibidos</span>
                    @if($unreadNav > 0)
                        <span class="badge-count">{{ $unreadNav }}</span>
                    @endif
                </a>

                <span class="nav-label">Administrador</span>
                <a href="{{ route('admin.profile.index') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Mi Cuenta</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" target="_blank" class="btn-view-site" style="justify-content: center;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Ver Sitio Web ↗</span>
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="admin-main">
            <!-- Header bar -->
            <header class="admin-header">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="header-title-wrap">
                        <h1>@yield('header_title', 'Administración Sytro Digital')</h1>
                    </div>
                </div>

                <div class="admin-header-actions">
                    <div class="user-dropdown">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="user-name">{{ auth()->user()->name ?? 'Administrador' }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="admin-btn-secondary admin-btn-sm" style="color: #f87171;" title="Cerrar sesión">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Alerts & Page Content -->
            <main class="admin-content">
                @if (session('status'))
                    <div class="admin-alert-success" id="alert-status">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('status') }}</span>
                        </div>
                        <button onclick="document.getElementById('alert-status').remove()" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 1.1rem;">&times;</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="admin-alert-error">
                        <div style="font-weight: 700; margin-bottom: 6px;">Por favor corrige los siguientes errores:</div>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
