<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Rogerio Pereira Marketing Strategy</title>
    <meta name="description" content="Thank you for your interest in marketing strategy services. Check your email for your free guide.">
    
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
            --text-secondary: #B4C0C6;
            --text-primary: #6B8A99;
            --accent: #C3329E;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            font-weight: 300;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
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
        
        /* Header */
        header {
            background-color: var(--bg-secondary);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--bg-tertiary);
        }
        
        .header-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
        }
        
        .header-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            color: var(--accent);
            font-weight: 600;
        }
        
        .header-right {
            text-align: right;
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            color: rgba(195, 50, 158, 0.7);
            font-weight: 300;
        }
        
        /* Thank You Section */
        .thank-you-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            padding: 100px 0;
        }
        
        .thank-you-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .thank-you-icon {
            width: 120px;
            height: 120px;
            background: rgba(195, 50, 158, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            border: 3px solid var(--accent);
            animation: pulse 2s infinite;
        }
        
        .thank-you-icon svg {
            width: 60px;
            height: 60px;
            fill: var(--accent);
        }
        
        .thank-you-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .thank-you-content .subtitle {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            font-weight: 300;
        }
        
        .thank-you-content p {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .email-reminder {
            background: var(--bg-secondary);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
            margin-top: 40px;
        }
        
        .email-reminder h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .email-reminder p {
            color: var(--text-primary);
            margin-bottom: 0;
        }
        
        .next-steps {
            margin-top: 50px;
            padding-top: 50px;
            border-top: 1px solid var(--bg-tertiary);
        }
        
        .next-steps h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #ffffff;
        }
        
        .next-steps ul {
            list-style: none;
            padding: 0;
            text-align: left;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .next-steps li {
            padding: 15px 0;
            padding-left: 40px;
            position: relative;
            color: var(--text-primary);
            font-size: 1rem;
            line-height: 1.7;
        }
        
        .next-steps li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--accent);
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        @keyframes pulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(195, 50, 158, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(195, 50, 158, 0);
            }
        }
        
        /* Footer */
        footer {
            background-color: var(--bg-primary);
            padding: 40px 0;
            text-align: center;
            border-top: 1px solid var(--bg-tertiary);
        }
        
        footer p {
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        /* Responsive Design */
        @media (max-width: 968px) {
            .header-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .header-right {
                text-align: center;
            }
            
            .thank-you-content h1 {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 640px) {
            .thank-you-content h1 {
                font-size: 2rem;
            }
            
            .thank-you-content .subtitle {
                font-size: 1.2rem;
            }
            
            .thank-you-icon {
                width: 100px;
                height: 100px;
            }
            
            .thank-you-icon svg {
                width: 50px;
                height: 50px;
            }
            
            .email-reminder {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="header-logo">Rogerio Pereira</div>
                <div class="header-right">Marketing Strategy</div>
            </div>
        </div>
    </header>

    <!-- Thank You Section -->
    <section class="thank-you-section">
        <div class="container">
            <div class="thank-you-content">
                <div class="thank-you-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                
                <h1>Thank You!</h1>
                <p class="subtitle">Your free marketing strategy guide is on its way</p>
                
                <p>I'm excited to help you transform your marketing from chaotic and ineffective to strategic and profitable. Your free guide contains proven strategies that generate qualified leads and convert visitors into customers—even when you're competing with bigger budgets.</p>
                
                <div class="email-reminder">
                    <h3>Check Your Email</h3>
                    <p>I've sent your free marketing strategy guide to your email address. Please check your inbox (and spam folder) to access the guide with actionable strategies you can implement right away.</p>
                </div>
                
                <div class="next-steps">
                    <h3>What's Inside Your Guide?</h3>
                    <ul>
                        <li>Clear marketing strategy framework with defined goals</li>
                        <li>Budget-friendly tactics that work for small businesses</li>
                        <li>Strategies to attract and qualify leads that actually convert</li>
                        <li>Simple dashboards to measure what's working</li>
                        <li>Step-by-step implementation guide</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Rogerio Pereira. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

