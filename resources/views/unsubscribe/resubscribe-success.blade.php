<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resubscribed Successfully - Rogerio Pereira</title>
    
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
            text-align: center;
        }
        
        .success-icon {
            font-size: 64px;
            color: #86efac;
            margin-bottom: 20px;
        }
        
        .content-box h2 {
            color: #ffffff;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .content-box p {
            color: var(--text-primary);
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.8;
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
            margin-top: 20px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 640px) {
            .content-box {
                padding: 30px 20px;
            }
            
            .page-title h1 {
                font-size: 2rem;
            }
            
            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
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
                <h1>Welcome Back!</h1>
            </div>

            <div class="content-box">
                <div class="success-icon">✓</div>
                
                <h2>You've Been Resubscribed Successfully</h2>
                
                <p>Hi {{ $contact->name }},</p>
                
                <p>Great news! You've been successfully resubscribed to our email list.</p>
                
                <p>You'll now receive our latest updates, valuable content, and special offers.</p>
                
                <p>Thank you for staying connected with us!</p>
                
                <a href="{{ route('home') }}" class="btn-primary">Go to Homepage</a>
            </div>
        </div>
    </main>
</body>
</html>

