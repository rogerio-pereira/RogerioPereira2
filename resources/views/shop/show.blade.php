<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->name }} - Rogerio Pereira</title>
    <meta name="description" content="{{ $ebook->description }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Poppins:wght@600&display=swap" rel="stylesheet">
    
    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    
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
        
        .ebook-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            .ebook-detail {
                grid-template-columns: 1fr;
            }
        }
        
        .ebook-image-container {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--bg-tertiary);
        }
        
        .ebook-image {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            display: block;
        }
        
        .ebook-info {
            background-color: var(--bg-secondary);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
        }
        
        .ebook-category {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .ebook-title {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .ebook-price {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .ebook-description {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
            font-weight: 600;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--bg-tertiary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            color: #ffffff;
            font-size: 1rem;
            font-family: 'Nunito', sans-serif;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #7D49CC;
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
        }
        
        .btn-primary {
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
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background-color: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
        }
        
        #card-element {
            padding: 12px 16px;
            background-color: var(--bg-tertiary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            color: #ffffff;
        }
        
        #card-element:focus {
            outline: none;
            border-color: #7D49CC;
        }
        
        #card-errors {
            color: #fca5a5;
            margin-top: 5px;
            font-size: 0.9rem;
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="header-logo">Rogerio Pereira</a>
                <a href="{{ route('shop.index') }}" style="color: var(--text-secondary); text-decoration: none;">← Back to Shop</a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="ebook-detail">
                <div class="ebook-image-container">
                    @if($ebook->image_url)
                        <img src="{{ $ebook->image_url }}" alt="{{ $ebook->name }}" class="ebook-image">
                    @else
                        <div style="padding: 100px 20px; text-align: center; color: var(--text-secondary);">
                            No image
                        </div>
                    @endif
                </div>
                
                <div class="ebook-info">
                    @if($ebook->category)
                        <span class="ebook-category" style="background-color: {{ $ebook->category->color ?? '#7D49CC' }}">
                            {{ $ebook->category->name }}
                        </span>
                    @endif
                    
                    <h1 class="ebook-title">{{ $ebook->name }}</h1>
                    
                    <div class="ebook-price">${{ number_format($ebook->price, 2) }}</div>
                    
                    @if($ebook->description)
                        <div class="ebook-description">
                            {{ $ebook->description }}
                        </div>
                    @endif
                    
                    <div id="payment-error" class="alert alert-error" style="display: none;"></div>
                    
                    <form id="payment-form">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-input" 
                                placeholder="John Doe"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email to receive the ebook</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="your@email.com"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone (Optional)</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-input" 
                                placeholder="+1 (555) 123-4567"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Card Information</label>
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                        
                        <button 
                            type="submit" 
                            id="submit-button"
                            class="btn btn-primary"
                            style="background: {{ $ebook->category?->color ?? '#7D49CC' }};"
                        >
                            <span id="button-text">Buy Now</span>
                        </button>
                    </form>
                    
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary">
                        Continue Browsing
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    @if($clientSecret)
    <script>
        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            const stripeKey = '{{ config('cashier.key') ?: env('STRIPE_KEY') }}';
            
            if (!stripeKey) {
                console.error('Stripe key is not configured');
                document.getElementById('payment-error').textContent = 'Payment system is not configured. Please contact support.';
                document.getElementById('payment-error').style.display = 'block';
                return;
            }
            
            if (typeof Stripe === 'undefined') {
                console.error('Stripe.js library is not loaded');
                document.getElementById('payment-error').textContent = 'Payment library failed to load. Please refresh the page.';
                document.getElementById('payment-error').style.display = 'block';
                return;
            }
            
            const stripe = Stripe(stripeKey);
            const elements = stripe.elements();
            
            const clientSecret = '{{ $clientSecret }}';
            
            if (!clientSecret) {
                console.error('Client secret is missing');
                document.getElementById('payment-error').textContent = 'Payment initialization failed. Please refresh the page.';
                document.getElementById('payment-error').style.display = 'block';
                return;
            }
            
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        color: '#ffffff',
                        fontFamily: 'Nunito, sans-serif',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#949FA6',
                        },
                    },
                    invalid: {
                        color: '#fca5a5',
                    },
                },
            });
            
            const cardElementContainer = document.getElementById('card-element');
            if (!cardElementContainer) {
                console.error('Card element container not found');
                return;
            }
            
            cardElement.mount('#card-element');
            
            const cardErrors = document.getElementById('card-errors');
            const paymentError = document.getElementById('payment-error');
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            
            cardElement.on('change', function(event) {
                if (event.error) {
                    cardErrors.textContent = event.error.message;
                } else {
                    cardErrors.textContent = '';
                }
            });
            
            form.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            // Disable button
            submitButton.disabled = true;
            buttonText.innerHTML = '<span class="loading"></span>Processing...';
            
            // Hide previous errors
            paymentError.style.display = 'none';
            cardErrors.textContent = '';
            
            const {error: submitError} = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value,
                        phone: document.getElementById('phone').value || undefined,
                    },
                },
            });
            
            if (submitError) {
                cardErrors.textContent = submitError.message;
                submitButton.disabled = false;
                buttonText.textContent = 'Buy Now';
                return;
            }
            
            // Payment succeeded, now send to server
            const {paymentIntent} = await stripe.retrievePaymentIntent(clientSecret);
            
            if (paymentIntent.status === 'succeeded') {
                // Send to server
                const formData = new FormData();
                formData.append('name', document.getElementById('name').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('payment_intent_id', paymentIntent.id);
                formData.append('_token', '{{ csrf_token() }}');
                
                try {
                    const response = await fetch('{{ route('shop.checkout', $ebook) }}', {
                        method: 'POST',
                        body: formData,
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        paymentError.textContent = data.error || 'Payment processing failed. Please try again.';
                        paymentError.style.display = 'block';
                        submitButton.disabled = false;
                        buttonText.textContent = 'Buy Now';
                    }
                } catch (error) {
                    paymentError.textContent = 'An error occurred. Please try again.';
                    paymentError.style.display = 'block';
                    submitButton.disabled = false;
                    buttonText.textContent = 'Buy Now';
                }
            } else {
                paymentError.textContent = 'Payment was not successful. Please try again.';
                paymentError.style.display = 'block';
                submitButton.disabled = false;
                buttonText.textContent = 'Buy Now';
                }
            });
        });
    </script>
    @else
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentError = document.getElementById('payment-error');
            if (paymentError) {
                paymentError.textContent = 'Payment system is not available. Please refresh the page.';
                paymentError.style.display = 'block';
            }
        });
    </script>
    @endif
</body>
</html>

