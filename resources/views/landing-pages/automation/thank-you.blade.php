<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Rogerio Pereira Business Automation</title>
    <meta name="description" content="Thank you for your interest in business automation. Check your email for your free guide.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&family=Space+Grotesk:wght@600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* Dark Mode Base Palette */
            --bg-primary: #05080D;
            --bg-secondary: #111826;
            --bg-tertiary: #2E4959;
            --text-secondary: #949FA6;
            --text-primary: #496773;
            
            /* Primary Color - Automation */
            --primary: #2CBFB3;
            
            /* Typography */
            --font-base: 'Inter', sans-serif;
            --font-title: 'Space Grotesk', sans-serif;
        }
        
        body {
            font-family: var(--font-base);
            font-weight: 300;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-title);
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
            font-family: var(--font-title);
            font-size: 24px;
            color: var(--primary);
            font-weight: 600;
        }
        
        .header-right {
            text-align: right;
            font-family: var(--font-title);
            font-size: 18px;
            color: rgba(44, 191, 179, 0.7);
            font-weight: 300;
        }
        
        /* Thank You Section */
        .thank-you-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
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
            background: rgba(44, 191, 179, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            border: 3px solid var(--primary);
            animation: pulse 2s infinite;
        }
        
        .thank-you-icon svg {
            width: 60px;
            height: 60px;
            fill: var(--primary);
        }
        
        .thank-you-content h1 {
            font-family: var(--font-title);
            font-size: 48px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .thank-you-content .subtitle {
            font-size: 20px;
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .thank-you-content p {
            font-size: 16px;
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
            font-family: var(--font-title);
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 15px;
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
            font-family: var(--font-title);
            font-size: 28px;
            color: #ffffff;
            margin-bottom: 20px;
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
            font-size: 16px;
            line-height: 1.7;
        }
        
        .next-steps li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        @keyframes pulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(44, 191, 179, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(44, 191, 179, 0);
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
                font-size: 36px;
            }
        }
        
        @media (max-width: 640px) {
            .thank-you-content h1 {
                font-size: 28px;
            }
            
            .thank-you-content .subtitle {
                font-size: 18px;
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
            
            .next-steps h3 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="header-logo">Rogerio Pereira</div>
                <div class="header-right">Business Automation</div>
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
                <p class="subtitle">Your free automation guide is on its way</p>
                
                <p>I'm excited to help you transform your business operations and reclaim your time. Your free guide contains 10 practical automation strategies that will save you hours every week and help you focus on what actually grows your business.</p>
                
                <div class="email-reminder">
                    <h3>Check Your Email</h3>
                    <p>I've sent your free automation guide to your email address. Please check your inbox (and spam folder) to access the guide with step-by-step strategies you can implement right away.</p>
                </div>
                
                <div class="next-steps">
                    <h3>What's Inside Your Guide?</h3>
                    <ul>
                        <li>10 automation strategies that save 10+ hours weekly</li>
                        <li>Step-by-step implementation instructions</li>
                        <li>No-code tools you can use without technical skills</li>
                        <li>Real examples of automations you can set up today</li>
                        <li>Tips to avoid common automation mistakes</li>
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

