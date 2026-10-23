<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Administrativo — Sytro Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #071b2d;
            background-image: 
                radial-gradient(at 0% 0%, rgba(13, 181, 192, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(244, 199, 123, 0.08) 0px, transparent 50%);
            color: #edf3f8;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            margin: 0;
            box-sizing: border-box;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(14, 32, 51, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(140, 165, 195, 0.2);
            border-radius: 16px;
            padding: 38px 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-header img {
            width: 48px;
            height: auto;
            margin: 0 auto 16px;
        }

        .login-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
        }

        .login-header p {
            color: #8fa2b6;
            font-size: 0.88rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: #d1dfed;
            margin-bottom: 8px;
        }

        .admin-input {
            width: 100%;
            background: rgba(7, 20, 33, 0.9);
            border: 1px solid rgba(140, 165, 195, 0.25);
            border-radius: 8px;
            padding: 12px 14px;
            color: #ffffff;
            font-size: 0.95rem;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .admin-input:focus {
            outline: none;
            border-color: #0db5c0;
            box-shadow: 0 0 0 3px rgba(13, 181, 192, 0.2);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #0db5c0 0%, #089ba4 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 13px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(13, 181, 192, 0.35);
            margin-top: 10px;
        }

        .btn-submit:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.86rem;
            margin-bottom: 20px;
        }

        .alert-status {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #a7f3d0;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.86rem;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-top: 20px;
            font-size: 0.84rem;
            color: #8fa2b6;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #0db5c0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/sytro-digital.svg') }}" alt="Sytro Digital Logo">
            <h1>Sytro Digital</h1>
            <p>Acceso al Panel de Administración Web</p>
        </div>

        @if(session('status'))
            <div class="alert-status">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="admin-input" 
                    required 
                    autofocus
                    placeholder="tu-correo@dominio.com"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="admin-input" 
                    required 
                    placeholder="••••••••"
                >
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.84rem; color: #b5c7d8; cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: #0db5c0;">
                    <span>Recordar sesión</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Iniciar Sesión
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">
            ← Volver al sitio web principal
        </a>
    </div>
</body>
</html>
