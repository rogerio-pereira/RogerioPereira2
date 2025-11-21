<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ebook Shop - Rogerio Pereira</title>
    <meta name="description" content="Buy digital ebooks about Marketing, Software Development and Automation.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Poppins:wght@600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-primary: #05080D;
            --bg-secondary: #111826;
            --bg-tertiary: #2E4959;
            --text-secondary: #949FA6;
            --text-primary: #496773;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            font-weight: 300;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--bg-secondary);
            padding: 20px 0;
            border-bottom: 1px solid var(--bg-tertiary);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            color: #ffffff;
            font-weight: 600;
            text-decoration: none;
        }
        
        .main-content {
            padding: 60px 0;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .page-title h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .ebooks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .ebook-card {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--bg-tertiary);
        }
        
        .ebook-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .ebook-image {
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            background-color: var(--bg-tertiary);
        }
        
        .ebook-content {
            padding: 20px;
        }
        
        .ebook-category {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 10px;
            color: #ffffff;
        }
        
        .ebook-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #ffffff;
        }
        
        .ebook-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .ebook-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        .ebook-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-primary {
            color: #ffffff;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            opacity: 0.9;
            filter: brightness(1.1);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <header>
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="header-logo">Rogerio Pereira</a>
                <div style="display: flex; gap: 20px; align-items: center;">
                    <a href="{{ route('shop.index') }}" style="color: var(--text-secondary); text-decoration: none;">Shop</a>
                    <a href="{{ route('cart.index') }}" style="color: var(--text-secondary); text-decoration: none; position: relative;">
                        Cart
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = count($cart);
                        @endphp
                        @if($cartCount > 0)
                            <span style="background: #7D49CC; color: #ffffff; border-radius: 50%; padding: 2px 6px; font-size: 0.75rem; margin-left: 5px;">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #86efac; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="page-title">
                <h1>Our Ebooks</h1>
                <p style="color: var(--text-secondary);">Digital knowledge to boost your business</p>
            </div>

            @if($categories->count() > 0)
                <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 40px; flex-wrap: wrap;">
                    <a 
                        href="{{ route('shop.index') }}" 
                        style="
                            padding: 10px 20px;
                            border-radius: 8px;
                            text-decoration: none;
                            font-weight: 600;
                            transition: all 0.3s ease;
                            {{ !$category ? 'background: var(--bg-tertiary); color: #ffffff;' : 'background: var(--bg-secondary); color: var(--text-secondary); border: 1px solid var(--bg-tertiary);' }}
                        "
                    >
                        All
                    </a>
                    @foreach($categories as $cat)
                        @php
                            $categorySlug = \Illuminate\Support\Str::slug($cat->name);
                            $isActive = $category === $categorySlug;
                        @endphp
                        <a 
                            href="{{ route('shop.index', ['category' => $categorySlug]) }}" 
                            style="
                                padding: 10px 20px;
                                border-radius: 8px;
                                text-decoration: none;
                                font-weight: 600;
                                transition: all 0.3s ease;
                                {{ $isActive ? 'background: ' . ($cat->color ?? '#7D49CC') . '; color: #ffffff;' : 'background: var(--bg-secondary); color: var(--text-secondary); border: 1px solid var(--bg-tertiary);' }}
                            "
                        >
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if($ebooks->count() > 0)
                <div class="ebooks-grid">
                    @foreach($ebooks as $ebook)
                        <div class="ebook-card">
                            @if($ebook->image_url)
                                <img src="{{ $ebook->image_url }}" alt="{{ $ebook->name }}" class="ebook-image">
                            @else
                                <div class="ebook-image" style="display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                    No image
                                </div>
                            @endif
                            <div class="ebook-content">
                                @if($ebook->category)
                                    <span class="ebook-category" style="background-color: {{ $ebook->category->color ?? '#7D49CC' }}">
                                        {{ $ebook->category->name }}
                                    </span>
                                @endif
                                <h3 class="ebook-title">{{ $ebook->name }}</h3>
                                @if($ebook->description)
                                    <p class="ebook-description">{{ $ebook->description }}</p>
                                @endif
                                <div class="ebook-footer">
                                    <span class="ebook-price">${{ number_format($ebook->price, 2) }}</span>
                                    <form action="{{ route('cart.add', $ebook) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="btn btn-primary"
                                            style="background: {{ $ebook->category?->color ?? '#7D49CC' }};"
                                        >
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <h2>No ebooks available at the moment</h2>
                    <p>Come back soon to see our products!</p>
                </div>
            @endif
        </div>
    </main>
</body>
</html>

