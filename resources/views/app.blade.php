<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class(['dark' => ($forceDark ?? false) || ($appearance ?? 'system') == 'dark'])
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const forceDark = {{ ($forceDark ?? false) ? 'true' : 'false' }};
                const appearance = '{{ $appearance ?? "system" }}';

                if (forceDark || appearance === 'dark') {
                    document.documentElement.classList.add('dark');
                    return;
                }

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color (brand steel) before the CSS loads --}}
        <style>
            html {
                background-color: #151719;
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])

        @php
            $seo = array_merge(config('site.seo'), $seo ?? []);
        @endphp
        <x-inertia::head>
            <title inertia>{{ $seo['title'] }}</title>
            <meta name="description" content="{{ $seo['description'] }}">
            <link rel="canonical" href="{{ url()->current() }}">
            <meta property="og:type" content="website">
            <meta property="og:title" content="{{ $seo['title'] }}">
            <meta property="og:description" content="{{ $seo['description'] }}">
            <meta property="og:url" content="{{ url()->current() }}">
            <meta property="og:image" content="{{ url($seo['image']) }}">
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="{{ $seo['twitter_site'] }}">
            <meta name="twitter:image" content="{{ url($seo['image']) }}">
            <meta name="theme-color" content="{{ $seo['theme_color'] }}">
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
