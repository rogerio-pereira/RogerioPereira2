<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Rogerio Pereira Software Development</title>
    <meta name="description" content="Thank you for your interest in software development services. Check your email for next steps.">
    
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
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Share Tech Mono', monospace;
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
            font-family: 'Share Tech Mono', monospace;
            font-size: 24px;
            color: var(--accent);
        }
        
        .header-right {
            text-align: right;
            font-family: 'Share Tech Mono', monospace;
            font-size: 18px;
            color: rgba(125, 73, 204, 0.7);
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
            background: rgba(125, 73, 204, 0.1);
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
            font-weight: 400;
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
                box-shadow: 0 0 0 0 rgba(125, 73, 204, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(125, 73, 204, 0);
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
                <div class="header-right">Software Development</div>
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
                <p class="subtitle">Your request has been received successfully</p>
                
                <p>I've received your project information and I'm excited to help you bring your software idea to life. I'll review your details and get back to you soon with a comprehensive assessment and next steps.</p>
                
                <div class="email-reminder">
                    <h3>Check Your Email</h3>
                    <p>I've sent you a confirmation email with your project assessment request details. Please check your inbox (and spam folder) for important information about your software development project.</p>
                </div>
                
                <div class="next-steps">
                    <h3>What Happens Next?</h3>
                    <ul>
                        <li><strong>Check Email for Instructions:</strong> Check your inbox (and spam folder) to receive detailed instructions about the next steps</li>
                        <li><strong>Complete the Briefing:</strong> Fill out the detailed briefing form (estimated 30-40 minutes) to help us better understand your project. Most questions require thoughtful answers about your business and project needs</li>
                        <li><strong>Analysis Phase:</strong> We're reviewing your project requirements, technical specifications, and business objectives</li>
                        <li><strong>Technical Assessment:</strong> We'll evaluate the feasibility, recommend the best technology stack, and identify potential challenges</li>
                        <li><strong>Architecture Planning:</strong> We'll design a scalable architecture that meets your current needs and future growth</li>
                        <li><strong>Detailed Response:</strong> You'll receive a comprehensive assessment with technical recommendations, timeline estimates, and a detailed quote</li>
                        <li><strong>Follow-up Call:</strong> We'll schedule a call to discuss your project in detail and answer any questions you may have</li>
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

