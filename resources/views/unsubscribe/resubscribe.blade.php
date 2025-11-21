<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resubscribe - Rogerio Pereira</title>
    
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
        
        .content-box {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            padding: 40px;
            border: 1px solid var(--bg-tertiary);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .content-box p {
            color: var(--text-primary);
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.8;
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
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }
        
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #7D49CC 0%, #643AA3 100%);
            color: #ffffff;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            display: inline-block;
            background-color: transparent;
            color: var(--text-secondary);
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            border: 1px solid var(--bg-tertiary);
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            border-color: var(--text-secondary);
            color: #ffffff;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        @media (max-width: 640px) {
            .content-box {
                padding: 30px 20px;
            }
            
            .page-title h1 {
                font-size: 2rem;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn-primary,
            .btn-secondary {
                width: 100%;
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
                <div style="display: flex; gap: 20px; align-items: center;">
                    <a href="{{ route('shop.index') }}" style="color: var(--text-secondary); text-decoration: none;">Shop</a>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="page-title">
                <h1>Resubscribe</h1>
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

            <div class="content-box">
                <p>Hi {{ $contact->name }},</p>
                
                <p>You have been unsubscribed from our email list.</p>
                
                <p>If you'd like to receive emails from us again, you can resubscribe below. We'll send you valuable content, updates, and special offers.</p>
                
                <div class="button-group">
                    <form action="{{ route('unsubscribe.resubscribe.confirm', $contact->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-primary">Yes, Resubscribe</button>
                    </form>
                    
                    <a href="{{ route('home') }}" class="btn-secondary">No, Thanks</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

