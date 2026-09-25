<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title>@yield('title') · {{ config('app.name', 'Rogerio Pereira') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        {{-- Inline styles: error pages must render even when the Vite build is missing. --}}
        <style>
            @font-face {
                font-family: 'Space Grotesk';
                src: url('/fonts/SpaceGrotesk-Variable.woff2') format('woff2');
                font-weight: 300 700;
                font-display: swap;
            }

            @font-face {
                font-family: 'Sora';
                src: url('/fonts/Sora-Variable.woff2') format('woff2');
                font-weight: 100 800;
                font-display: swap;
            }

            @font-face {
                font-family: 'Droid Sans Mono';
                src: url('/fonts/DroidSansMono.woff2') format('woff2');
                font-weight: 400;
                font-display: swap;
            }

            :root {
                --primary: #00BEBE;
                --primary-rgb: 0, 190, 190;
                --steel: #151719;
                --text: #EFE9E2;
                --text-soft: #DCD5CC;
                --muted: #9AA1A8;
                --glass: rgba(18, 20, 23, 0.55);
                --line: rgba(255, 255, 255, 0.13);
                --shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.6), 0 12px 24px -12px rgba(0, 0, 0, 0.5);
                --neon: 0 0 22px rgba(var(--primary-rgb), 0.85), 0 0 44px rgba(var(--primary-rgb), 0.45);
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background-color: var(--steel);
                background-image:
                    linear-gradient(rgba(var(--primary-rgb), 0.055) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(var(--primary-rgb), 0.055) 1px, transparent 1px),
                    linear-gradient(rgba(var(--primary-rgb), 0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(var(--primary-rgb), 0.025) 1px, transparent 1px);
                background-size: 200px 200px, 200px 200px, 40px 40px, 40px 40px;
                color: var(--text-soft);
                font-family: 'Sora', system-ui, sans-serif;
                font-weight: 300;
                font-size: 17px;
                line-height: 1.65;
            }

            .shell {
                width: 100%;
                max-width: 1180px;
                margin: 0 auto;
                padding: 24px clamp(16px, 4vw, 40px) 48px;
                display: flex;
                flex: 1;
                flex-direction: column;
            }

            .brand {
                display: inline-flex;
                align-items: baseline;
                gap: 12px;
                align-self: flex-start;
                text-decoration: none;
            }

            .brand strong {
                font-family: 'Space Grotesk', system-ui, sans-serif;
                font-weight: 700;
                font-size: 19px;
                letter-spacing: -0.01em;
                color: var(--text);
            }

            .brand span {
                font-family: 'Droid Sans Mono', ui-monospace, Menlo, monospace;
                font-size: 12px;
                letter-spacing: 0.14em;
                color: var(--primary);
            }

            .main {
                display: flex;
                flex: 1;
                align-items: center;
                justify-content: center;
                padding-block: 48px;
            }

            .card {
                position: relative;
                width: 100%;
                max-width: 36rem;
                padding: 40px 32px 36px 40px;
                border: 1px solid var(--line);
                border-radius: 2px;
                background: var(--glass);
                box-shadow: var(--shadow);
            }

            .card::before {
                content: '';
                position: absolute;
                left: -1px;
                top: -1px;
                bottom: -1px;
                width: 5px;
                background: var(--primary);
                box-shadow: var(--neon);
            }

            .status {
                margin: 0 0 12px;
                font-family: 'Droid Sans Mono', ui-monospace, Menlo, monospace;
                font-size: 13px;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: var(--muted);
            }

            .code {
                margin: 0 0 12px;
                font-family: 'Space Grotesk', system-ui, sans-serif;
                font-size: clamp(3.5rem, 9vw, 5.5rem);
                font-weight: 700;
                line-height: 1.05;
                letter-spacing: -0.02em;
                color: var(--primary);
                text-shadow: 0 0 28px rgba(var(--primary-rgb), 0.35);
            }

            .heading {
                margin: 0 0 12px;
                font-family: 'Space Grotesk', system-ui, sans-serif;
                font-size: clamp(1.75rem, 3.4vw, 2.25rem);
                font-weight: 700;
                line-height: 1.1;
                letter-spacing: -0.02em;
                color: var(--text);
            }

            .message {
                margin: 0 0 28px;
                max-width: 30rem;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 52px;
                padding: 16px 26px;
                border: 1px solid transparent;
                border-radius: 2px;
                background: var(--primary);
                color: #081414;
                font-family: 'Space Grotesk', system-ui, sans-serif;
                font-size: 17px;
                font-weight: 700;
                text-decoration: none;
                transition: box-shadow 0.2s, transform 0.2s;
            }

            .btn:hover {
                box-shadow: 0 0 22px rgba(var(--primary-rgb), 0.55), 0 0 44px rgba(var(--primary-rgb), 0.25);
                transform: translateY(-1px);
            }

            :focus-visible {
                outline: 2px solid var(--primary);
                outline-offset: 3px;
            }

            @media (prefers-reduced-motion: reduce) {
                .btn {
                    transition: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <a href="{{ url('/') }}" class="brand" data-test="error-home-logo" aria-label="Rogerio Pereira, home">
                <strong>Rogerio Pereira</strong>
                <span>@@rogeriopereira.dev</span>
            </a>

            <main class="main">
                <div class="card" data-test="error-card">
                    <p class="status" data-test="error-status">@yield('status')</p>
                    <p class="code" aria-hidden="true">@yield('code')</p>
                    <h1 class="heading" data-test="error-heading">@yield('heading')</h1>
                    <p class="message" data-test="error-message">@yield('message')</p>
                    <a href="{{ url('/') }}" class="btn" data-test="error-home">@yield('action')</a>
                </div>
            </main>
        </div>
    </body>
</html>
