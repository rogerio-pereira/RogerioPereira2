<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Software Development Project Assessment</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
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
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .email-wrapper {
            background-color: #05080D;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111826;
        }
        
        .header {
            background-color: #111826;
            padding: 30px 30px 20px;
            text-align: center;
            border-bottom: 1px solid #2E4959;
        }
        
        .logo {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 24px;
            color: #7D49CC;
            margin-bottom: 10px;
        }
        
        .header-tagline {
            font-size: 14px;
            color: rgba(125, 73, 204, 0.7);
            font-family: 'Share Tech Mono', 'Courier New', monospace;
        }
        
        .content {
            background-color: #111826;
            padding: 40px 30px;
        }
        
        .greeting {
            color: #B4C0C6;
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        h1 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 32px;
            color: #ffffff;
            margin-bottom: 20px;
            line-height: 1.2;
            background: linear-gradient(135deg, #ffffff 0%, #7D49CC 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .intro {
            color: #6B8A99;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .process-section {
            background-color: #05080D;
            border: 1px solid #2E4959;
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .process-section h2 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 22px;
            color: #7D49CC;
            margin-bottom: 20px;
        }
        
        .process-step {
            margin-bottom: 25px;
            padding-left: 30px;
            position: relative;
        }
        
        .process-step::before {
            content: counter(step-counter);
            counter-increment: step-counter;
            position: absolute;
            left: 0;
            top: 0;
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 18px;
            color: #7D49CC;
            font-weight: bold;
        }
        
        .process-steps {
            counter-reset: step-counter;
        }
        
        .process-step h3 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 18px;
            color: #ffffff;
            margin-bottom: 10px;
        }
        
        .process-step p {
            color: #6B8A99;
            font-size: 15px;
            line-height: 1.7;
        }
        
        .benefits-box {
            background-color: #05080D;
            border-left: 4px solid #7D49CC;
            padding: 25px;
            margin: 30px 0;
            border-radius: 4px;
        }
        
        .benefits-box h2 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 20px;
            color: #7D49CC;
            margin-bottom: 15px;
        }
        
        .benefits-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .benefits-box li {
            color: #6B8A99;
            font-size: 15px;
            padding: 10px 0;
            padding-left: 25px;
            position: relative;
            line-height: 1.7;
        }
        
        .benefits-box li::before {
            content: ">";
            position: absolute;
            left: 0;
            color: #7D49CC;
            font-weight: bold;
            font-family: 'Share Tech Mono', 'Courier New', monospace;
        }
        
        .cta-section {
            text-align: center;
            margin: 50px 0 30px;
            padding: 40px 30px;
            background: linear-gradient(135deg, rgba(125, 73, 204, 0.1) 0%, rgba(100, 58, 163, 0.1) 100%);
            border-radius: 12px;
            border: 1px solid #2E4959;
        }
        
        .cta-section h2 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 15px;
        }
        
        .cta-section p {
            color: #B4C0C6;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #7D49CC 0%, #643AA3 100%);
            color: #ffffff !important;
            padding: 16px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
        }
        
        .footer {
            background-color: #05080D;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #2E4959;
        }
        
        .footer p {
            color: #B4C0C6;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .footer a {
            color: #7D49CC;
            text-decoration: none;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            
            .content {
                padding: 30px 20px !important;
            }
            
            h1 {
                font-size: 28px !important;
            }
            
            .cta-button {
                padding: 14px 30px !important;
                font-size: 15px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="header">
                <div class="logo">Rogerio Pereira</div>
                <div class="header-tagline">Software Development</div>
            </div>
            
            <!-- Content -->
            <div class="content">
                <div class="greeting">Hi {{ $contact->name }},</div>
                
                <h1>Let's Build Your Software Project Together</h1>
                
                <p class="intro">Thank you for your interest in my software development services.</p>
                
                <p class="intro">You have a software idea that could transform your business. But you need someone who will take your idea and turn it into a complete, working application—with proper architecture, security, and documentation from day one.</p>
                
                <p class="intro">That's exactly what I do. I build software projects from scratch with clean code, scalable architecture, and production-ready solutions. No shortcuts, no technical debt, no "we'll fix it later" promises.</p>
                
                <div class="process-section">
                    <h2>How I Work</h2>
                    <div class="process-steps">
                        <div class="process-step">
                            <h3>Project Assessment</h3>
                            <p>I review your project requirements and technical needs. I'll identify potential challenges, recommend the right technology stack, and create a clear roadmap for your project.</p>
                        </div>
                        
                        <div class="process-step">
                            <h3>Architecture Design</h3>
                            <p>I design clean, modular architecture that scales with your business. This isn't just code—it's a system that grows with you, making future changes and additions easy.</p>
                        </div>
                        
                        <div class="process-step">
                            <h3>Development</h3>
                            <p>I write clean, maintainable code following best practices. Every feature is built with security, performance, and scalability in mind from day one.</p>
                        </div>
                        
                        <div class="process-step">
                            <h3>Testing & Quality Assurance</h3>
                            <p>I implement automated tests to ensure quality throughout development. Bugs are caught early, not in production. You get software that actually works.</p>
                        </div>
                        
                        <div class="process-step">
                            <h3>Deployment & Documentation</h3>
                            <p>I handle deployment and provide complete documentation. You'll have everything you need to maintain, scale, and extend your application.</p>
                        </div>
                    </div>
                </div>
                
                <div class="benefits-box">
                    <h2>What You Get When You Work With Me</h2>
                    <ul>
                        <li><strong>Clean Architecture:</strong> Code organized with clear separation of concerns, making it easy to maintain and extend</li>
                        <li><strong>Security Built-In:</strong> Security measures implemented from day one—authentication, data protection, and protection against common attacks</li>
                        <li><strong>Performance Optimized:</strong> Applications built for speed and scalability from the start, so you don't hit bottlenecks when you grow</li>
                        <li><strong>Automated Testing:</strong> Comprehensive test coverage that gives you confidence to make changes without breaking things</li>
                        <li><strong>Complete Documentation:</strong> Technical documentation, API docs, and setup guides so you or your team can maintain the project</li>
                        <li><strong>Production-Ready:</strong> Software that's ready to deploy and scale, not a prototype that needs to be rebuilt</li>
                    </ul>
                </div>
                
                <p style="color: #6B8A99; font-size: 16px; margin-top: 30px; line-height: 1.8;">I've built software for clients including governments, and I bring that same level of professionalism and attention to detail to every project. Your software idea deserves to be built right.</p>
                
                <div class="cta-section">
                    <h2>Ready to Get Started?</h2>
                    <p>Tell me more about your project, and I'll provide you with a detailed assessment, technical recommendations, and a clear quote.</p>
                    <p style="margin-bottom: 25px;">Let's schedule a call to discuss your project in detail and see how I can help bring your software idea to life.</p>
                    <a href="{{ route('software-development') }}#hero" class="cta-button">Get a Quote for Your Project</a>
                </div>
                
                <p style="color: #6B8A99; font-size: 16px; margin-top: 30px; line-height: 1.8;">I'm here to help you bring your software idea to life. When you're ready, tell me about your project and I'll provide you with a detailed assessment and quote.</p>
                
                <p style="margin-top: 30px; color: #6B8A99;">
                    Best regards,<br>
                    <strong style="color: #7D49CC;">Rogerio Pereira</strong><br>
                    <span style="color: #B4C0C6; font-size: 14px;">Software Development Specialist</span>
                </p>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>&copy; 2025 Rogerio Pereira. All rights reserved.</p>
                <p><a href="{{ route('software-development') }}">Visit Our Software Development Page</a> | <a href="#">Unsubscribe</a></p>
            </div>
        </div>
    </div>
</body>
</html>
