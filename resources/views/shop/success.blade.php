<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Successful - Rogerio Pereira</title>
    
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
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .success-content {
            text-align: center;
            padding: 80px 0;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #7D49CC 0%, #C3329E 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #ffffff;
        }
        
        .success-title {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .success-message {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        .ebook-info {
            background-color: var(--bg-secondary);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
            margin-bottom: 30px;
            text-align: left;
        }
        
        .ebook-info h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .ebook-info p {
            color: var(--text-secondary);
            margin-bottom: 5px;
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
            margin: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #7D49CC 0%, #C3329E 100%);
            color: #ffffff;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(125, 73, 204, 0.4);
        }
        
        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: #ffffff;
        }
        
        .btn-secondary:hover {
            background-color: var(--text-secondary);
        }
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <div class="container">
        <div class="success-content">
            <div class="success-icon">✓</div>
            
            <h1 class="success-title">Purchase Successful!</h1>
            
            <p class="success-message">
                Thank you for your purchase{{ count($purchases ?? []) > 1 ? 's' : '' }}. You will receive the ebook{{ count($purchases ?? []) > 1 ? 's' : '' }} by email shortly.
            </p>
            
            @if($purchase && count($purchases ?? []) > 0)
                <div class="ebook-info">
                    <h3>Order Details</h3>
                    <p><strong>Name:</strong> {{ $purchase->name }}</p>
                    <p><strong>Email:</strong> {{ $purchase->email }}</p>
                    @if($purchase->phone)
                        <p><strong>Phone:</strong> {{ $purchase->phone }}</p>
                    @endif
                    
                    @if(count($purchases) > 1)
                        <p style="margin-top: 15px; margin-bottom: 10px;"><strong>Purchased Items:</strong></p>
                        <ul style="list-style: none; padding: 0; margin: 0 0 15px 0;">
                            @foreach($purchases as $p)
                                <li style="padding: 5px 0; color: var(--text-secondary);">
                                    • {{ $p->ebook->name }} - ${{ number_format($p->amount, 2) }}
                                </li>
                            @endforeach
                        </ul>
                        <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--bg-tertiary);">
                            <strong>Total Amount:</strong> ${{ number_format($total, 2) }}
                        </p>
                    @else
                        <p><strong>Ebook:</strong> {{ $purchase->ebook->name }}</p>
                        <p><strong>Amount:</strong> ${{ number_format($purchase->amount, 2) }}</p>
                    @endif
                    
                    <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--bg-tertiary);">
                        <strong>Date:</strong> {{ $purchase->completed_at ?? $purchase->created_at }}
                    </p>
                </div>
            @endif
            
            <div>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    View More Ebooks
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>

