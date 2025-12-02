<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->name }} - Rogerio Pereira</title>
    <meta name="description" content="{{ $ebook->description }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #05080D;
            --bg-secondary: #111826;
            --bg-tertiary: #2E4959;
            --text-muted: #949FA6;
            --text-bright: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            font-weight: 300;
            background-color: var(--bg-primary);
            color: var(--text-bright);
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        header {
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--bg-tertiary);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .header-logo {
            font-size: 24px;
            color: var(--text-bright);
            text-decoration: none;
        }

        .header-links {
            display: flex;
            gap: 18px;
            font-size: 0.95rem;
        }

        .header-links a {
            text-decoration: none;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .header-links a:hover {
            color: var(--text-bright);
        }

        main {
            padding: 60px 0 100px;
        }

        .hero {
            background: linear-gradient(135deg, rgba(125,73,204,0.2) 0%, rgba(44,191,179,0.3) 100%);
            border: 1px solid var(--bg-tertiary);
            border-radius: 24px;
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            align-items: center;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .hero-title {
            font-size: clamp(2.5rem, 1.8rem + 1vw, 3rem);
            margin: 20px 0;
        }

        .hero-description {
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .hero-price {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s ease, opacity 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: {{ $ebook->category?->color ?? '#7D49CC' }};
            color: #ffffff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--text-bright);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
        }

        .hero-image {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--bg-tertiary);
            background-color: var(--bg-secondary);
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .stat-grid {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
        }

        .stat-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 16px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section {
            margin-top: 60px;
        }

        .section h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .section-description {
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .feature-card {
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.02);
        }

        .feature-card h3 {
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            main {
                padding: 40px 0 80px;
            }

            .hero {
                padding: 30px;
            }

            .header-content {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <header>
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="header-logo">Rogerio Pereira</a>
                <div class="header-links">
                    <a href="{{ route('shop.index') }}">All Ebooks</a>
                    <a href="{{ route('cart.index') }}">Cart</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <section class="hero">
                <div>
                    @if($ebook->category)
                        <span class="category-pill" style="background-color: {{ $ebook->category->color ?? '#7D49CC' }};">
                            {{ $ebook->category->name }}
                        </span>
                    @endif

                    <h1 class="hero-title">{{ $ebook->name }}</h1>
                    <p class="hero-description">{{ $ebook->description }}</p>
                    <div class="hero-price">${{ number_format($ebook->price, 2) }}</div>

                    <div class="hero-actions">
                        <form action="{{ route('cart.add', $ebook) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">View Cart</a>
                    </div>

                    <div class="stat-grid">
                        <div class="stat-card">
                            <div class="stat-label">Downloads</div>
                            <div class="stat-value">{{ number_format($ebook->downloads ?? 0) }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Category</div>
                            <div class="stat-value">{{ $ebook->category?->name ?? 'Independent' }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Available since</div>
                            <div class="stat-value">{{ $ebook->created_at ?? 'Coming soon' }}</div>
                        </div>
                    </div>
                </div>

                <div class="hero-image">
                    @if($ebook->image_url)
                        <img src="{{ $ebook->image_url }}" alt="{{ $ebook->name }}">
                    @else
                        <div style="padding: 120px 20px; text-align: center; color: var(--text-muted);">Image coming soon</div>
                    @endif
                </div>
            </section>

        </div>
    </main>
</body>
</html>

