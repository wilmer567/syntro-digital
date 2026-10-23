<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Error') | Sytro Digital</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        :root {
            --bg-dark: #0a0e17;
            --bg-card: rgba(16, 24, 39, 0.85);
            --border-card: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --accent: #0ea5e9;
            --accent-glow: rgba(14, 165, 233, 0.2);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background-image: radial-gradient(circle at 50% 20%, rgba(14, 165, 233, 0.12), transparent 45%);
        }
        .error-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 20px;
            padding: 48px 36px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }
        .error-code {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
            letter-spacing: -0.04em;
        }
        .error-title {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 12px;
        }
        .error-message {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 32px;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #0284c7;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 12px 28px;
            border-radius: 9999px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px var(--accent-glow);
        }
        .btn-home:hover {
            background: #0369a1;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">@yield('code')</div>
        <h1 class="error-title">@yield('heading')</h1>
        <p class="error-message">@yield('message')</p>
        <a href="{{ url('/') }}" class="btn-home">Volver al inicio</a>
    </div>
</body>
</html>
