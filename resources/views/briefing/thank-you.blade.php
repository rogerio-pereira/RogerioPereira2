<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Project Briefing Received</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
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
            --text-secondary: #B4C0C6;
            --text-primary: #6B8A99;
            --accent: #7D49CC;
        }
        
        body {
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 400;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        h1, h2, h3 {
            font-family: 'Share Tech Mono', monospace;
            color: #ffffff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        .thank-you-content {
            text-align: center;
            background: var(--bg-secondary);
            padding: 60px 40px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
        }
        
        .thank-you-icon {
            width: 120px;
            height: 120px;
            background: rgba(125, 73, 204, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            border: 3px solid var(--accent);
        }
        
        .thank-you-icon svg {
            width: 60px;
            height: 60px;
            fill: var(--accent);
        }
        
        .thank-you-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .thank-you-content p {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .email-reminder {
            background: var(--bg-primary);
            padding: 30px;
            border-radius: 8px;
            border: 1px solid var(--bg-tertiary);
            margin-top: 40px;
        }
        
        .email-reminder h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .email-reminder p {
            color: var(--text-primary);
            margin-bottom: 0;
        }
        
        @media (max-width: 640px) {
            .container {
                padding: 40px 10px;
            }
            
            .thank-you-content {
                padding: 40px 25px;
            }
            
            .thank-you-content h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <div class="container">
        <div class="thank-you-content">
            <div class="thank-you-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            
            <h1>Thank You!</h1>
            <p class="subtitle">We received your project briefing</p>
            
            <p>Thank you for submitting your project briefing. We've received all the information and are currently analyzing your requirements.</p>
            
            <div class="email-reminder">
                <h3>Check Your Email</h3>
                <p>We've sent you a confirmation email to let you know we received your briefing and are analyzing it. Please check your inbox (and spam folder) for the confirmation.</p>
            </div>
            
            <p style="margin-top: 30px;">We'll review your project requirements and get back to you soon with our analysis and next steps.</p>
        </div>
    </div>
</body>
</html>


