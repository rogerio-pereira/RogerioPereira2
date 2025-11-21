<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Rogerio Pereira</title>
    
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
            max-width: 1200px;
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
            margin-bottom: 30px;
        }
        
        .page-title h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .cart-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
        }
        
        @media (max-width: 968px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
        }
        
        .cart-items {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--bg-tertiary);
        }
        
        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr auto auto;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid var(--bg-tertiary);
            align-items: center;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 120px;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 8px;
            background-color: var(--bg-tertiary);
        }
        
        .cart-item-info h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .cart-item-category {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: #ffffff;
        }
        
        .cart-item-price {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .cart-item-actions {
            display: flex;
            align-items: center;
        }
        
        .cart-item-price-display {
            text-align: right;
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
        }
        
        .cart-summary {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--bg-tertiary);
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: var(--text-secondary);
        }
        
        .summary-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 2px solid var(--bg-tertiary);
            margin-top: 15px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
        }
        
        .btn {
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            text-align: center;
            font-size: 1.1rem;
            margin-top: 20px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #7D49CC 0%, #C3329E 100%);
            color: #ffffff;
        }
        
        .btn-primary:hover {
            transform: scale(1.02);
            opacity: 0.9;
            filter: brightness(1.1);
        }
        
        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: #ffffff;
            margin-top: 10px;
        }
        
        .btn-secondary:hover {
            background-color: var(--text-secondary);
        }
        
        .btn-danger {
            background-color: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(220, 38, 38, 0.3);
            padding: 8px 16px;
            font-size: 0.9rem;
            width: auto;
            margin: 0;
        }
        
        .btn-danger:hover {
            background-color: rgba(220, 38, 38, 0.3);
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        
        .empty-cart h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }
        
        .alert-error {
            background-color: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
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
            <div class="page-title">
                <h1>Shopping Cart</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd;">
                    {{ session('info') }}
                </div>
            @endif

            @if(count($ebooks) > 0)
                <div class="cart-container">
                    <div class="cart-items">
                        @foreach($ebooks as $ebook)
                            <div class="cart-item">
                                <div>
                                    @if($ebook->image_url)
                                        <img src="{{ $ebook->image_url }}" alt="{{ $ebook->name }}" class="cart-item-image">
                                    @else
                                        <div class="cart-item-image" style="display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.8rem;">
                                            No image
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="cart-item-info">
                                    @if($ebook->category)
                                        <span class="cart-item-category" style="background-color: {{ $ebook->category->color ?? '#7D49CC' }}">
                                            {{ $ebook->category->name }}
                                        </span>
                                    @endif
                                    <h3>{{ $ebook->name }}</h3>
                                </div>
                                
                                <div class="cart-item-actions">
                                    <form action="{{ route('cart.remove', $ebook) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                                
                                <div class="cart-item-price-display">
                                    ${{ number_format($ebook->price, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="cart-summary">
                        <h2 style="margin-bottom: 20px;">Order Summary</h2>
                        
                        <div class="summary-row">
                            <span>Subtotal ({{ count($ebooks) }} items)</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <a href="{{ route('shop.checkout') }}" class="btn btn-primary">
                            Proceed to Checkout
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">
                                Clear Cart
                            </button>
                        </form>
                        
                        <a href="{{ route('shop.index') }}" class="btn btn-secondary" style="margin-top: 10px;">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <h2>Your cart is empty</h2>
                    <p>Add some ebooks to get started!</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary" style="margin-top: 20px; width: auto; display: inline-block;">
                        Browse Ebooks
                    </a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>

