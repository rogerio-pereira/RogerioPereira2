<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ebook Download</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 400;
            background-color: #05080D;
            color: #6B8A99;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111826;
            padding: 40px 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            font-family: 'Share Tech Mono', monospace;
            font-size: 24px;
            color: #7D49CC;
            margin-bottom: 20px;
        }
        
        .content {
            background-color: #05080D;
            border-radius: 12px;
            padding: 40px 30px;
            border: 1px solid #2E4959;
        }
        
        h1 {
            font-family: 'Share Tech Mono', monospace;
            font-size: 32px;
            color: #ffffff;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .greeting {
            color: #B4C0C6;
            font-size: 16px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .ebook-info {
            background-color: #111826;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #2E4959;
        }
        
        .ebook-name {
            font-family: 'Share Tech Mono', monospace;
            font-size: 22px;
            color: #7D49CC;
            margin-bottom: 15px;
        }
        
        .ebook-description {
            color: #B4C0C6;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .download-button {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #7D49CC 0%, #5D2F9E 100%);
            color: #ffffff;
            padding: 16px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Share Tech Mono', monospace;
            font-size: 16px;
            margin: 30px 0;
            transition: transform 0.2s;
        }
        
        .download-button:hover {
            transform: translateY(-2px);
        }
        
        .confirmation-note {
            background-color: #111826;
            border-left: 4px solid #7D49CC;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        
        .confirmation-note p {
            color: #B4C0C6;
            font-size: 14px;
            margin: 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #2E4959;
        }
        
        .footer-text {
            color: #B4C0C6;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .footer-link {
            color: #7D49CC;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Rogerio Pereira</div>
        </div>
        
        <div class="content">
            <h1>Thank You for Your Purchase!</h1>
            
            <p class="greeting">
                Hi {{ $purchase->name }},
            </p>
            
            <p style="color: #B4C0C6; font-size: 16px; margin-bottom: 30px; text-align: center;">
                Your purchase was successful! You can now download your ebook using the link below.
            </p>
            
            <div class="ebook-info">
                <div class="ebook-name">{{ $purchase->ebook->name }}</div>
                @if($purchase->ebook->description)
                    <div class="ebook-description">{{ $purchase->ebook->description }}</div>
                @endif
            </div>
            
            <a href="{{ route('ebooks.download', ['ebook' => $purchase->ebook->id, 'confirmation' => $purchase->confirmation_hash]) }}" class="download-button">
                Download Your Ebook
            </a>
            
            <div class="confirmation-note">
                <p>
                    <strong>Confirmation:</strong> Your download link is unique and secure. 
                    If you have any questions, please don't hesitate to contact us.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                This email was sent to {{ $purchase->email }}<br>
                <a href="{{ route('home') }}" class="footer-link">Visit our website</a>
            </p>
        </div>
    </div>
</body>
</html>

