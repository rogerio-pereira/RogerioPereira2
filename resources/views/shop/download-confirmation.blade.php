<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Ebook - Rogerio Pereira</title>
    
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
        
        .download-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
        }
        
        @media (max-width: 968px) {
            .download-container {
                grid-template-columns: 1fr;
            }
        }
        
        .ebook-info {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--bg-tertiary);
        }
        
        .ebook-image-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        
        .ebook-image {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 8px;
            background-color: var(--bg-tertiary);
        }
        
        .ebook-category {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .ebook-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .ebook-description {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .download-actions {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--bg-tertiary);
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .download-actions h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
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
        
        .form-help {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 5px;
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
        
        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #93c5fd;
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
        
        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #93c5fd;
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
                <h1>Download Ebook</h1>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            <div class="download-container">
                <div class="ebook-info">
                    <div class="ebook-image-container">
                        @if($ebook->image_url)
                            <img src="{{ $ebook->image_url }}" alt="{{ $ebook->name }}" class="ebook-image">
                        @else
                            <div class="ebook-image" style="display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                <span>No Image</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($ebook->category)
                        <span class="ebook-category" style="background-color: {{ $ebook->category->color ?? '#7D49CC' }}">
                            {{ $ebook->category->name }}
                        </span>
                    @endif
                    
                    <h2 class="ebook-title">{{ $ebook->name }}</h2>
                    
                    @if($ebook->description)
                        <div class="ebook-description">
                            {{ $ebook->description }}
                        </div>
                    @endif
                </div>
                
                <div class="download-actions">
                    <h2>Download</h2>
                    
                    <form method="GET" action="{{ route('ebooks.download', ['ebook' => $ebook->id]) }}">
                        <div class="form-group">
                            <label for="confirmation" class="form-label">Confirmation Hash</label>
                            <input 
                                type="text" 
                                id="confirmation" 
                                name="confirmation" 
                                class="form-input" 
                                placeholder="Enter your confirmation hash"
                                required
                                autofocus
                            >
                            <p class="form-help">
                                The confirmation hash was sent to your email after purchase. 
                                Please check your email for the download link.
                            </p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            Download Ebook
                        </button>
                    </form>
                    
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary">
                        Back to Shop
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

