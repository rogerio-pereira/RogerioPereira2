<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Software Development Services - Build Your Application Right</title>
    <meta name="description" content="Hire a professional software developer to build your application, system, or project. Clean code, scalable architecture, and production-ready solutions.">
    
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
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            position: relative;
            padding: 80px 0;
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .hero-text h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-text .subheadline {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            font-weight: 400;
        }
        
        .hero-text p {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 40px;
            line-height: 1.8;
        }
        
        
        /* Form Section */
        .form-container {
            background: var(--bg-secondary);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .form-container h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .form-container p {
            color: var(--text-secondary);
            margin-bottom: 25px;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: var(--bg-primary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            color: #ffffff;
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(125, 73, 204, 0.1);
        }
        
        .form-group input::placeholder {
            color: var(--text-secondary);
        }
        
        .btn-primary {
            width: 100%;
            padding: 16px 32px;
            background: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            background: #6a3db0;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(125, 73, 204, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        /* Section Styles */
        .section {
            padding: 100px 0;
        }
        
        .section-title {
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 1.2rem;
            margin-bottom: 60px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Pain Points Section */
        .pain-points {
            background: var(--bg-secondary);
        }
        
        .pain-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .pain-card {
            background: var(--bg-primary);
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid var(--accent);
            transition: transform 0.3s ease;
        }
        
        .pain-card:hover {
            transform: translateY(-5px);
        }
        
        .pain-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .pain-card p {
            color: var(--text-primary);
            line-height: 1.7;
        }
        
        .cta-inline {
            text-align: center;
            margin-top: 50px;
        }
        
        .btn-secondary {
            display: inline-block;
            padding: 16px 40px;
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
            border-radius: 8px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-secondary:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        /* Transformation Section */
        .transformation {
            background: var(--bg-primary);
        }
        
        .before-after {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 60px;
        }
        
        .before, .after {
            background: var(--bg-secondary);
            padding: 40px;
            border-radius: 12px;
        }
        
        .before h3, .after h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .before h3 {
            color: #ff6b6b;
        }
        
        .after h3 {
            color: var(--accent);
        }
        
        .before ul, .after ul {
            list-style: none;
            padding: 0;
        }
        
        .before li, .after li {
            padding: 12px 0;
            padding-left: 30px;
            position: relative;
            color: var(--text-primary);
        }
        
        .before li::before {
            content: "X";
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .after li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--accent);
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        /* Solution Section */
        .solution {
            background: var(--bg-secondary);
        }
        
        .solution-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
        
        .solution-content p {
            font-size: 1.2rem;
            color: var(--text-primary);
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        /* Benefits Section */
        .benefits {
            background: var(--bg-primary);
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }
        
        .benefit-card {
            background: var(--bg-secondary);
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            border-top: 3px solid var(--accent);
        }
        
        .benefit-icon {
            width: 80px;
            height: 80px;
            background: rgba(125, 73, 204, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--accent);
        }
        
        .benefit-icon svg {
            width: 40px;
            height: 40px;
            fill: currentColor;
        }
        
        .benefit-card h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .benefit-card p {
            color: var(--text-primary);
            line-height: 1.7;
        }
        
        /* Social Proof Section */
        .social-proof {
            background: var(--bg-secondary);
        }
        
        .proof-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }
        
        .proof-card {
            background: var(--bg-primary);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--bg-tertiary);
        }
        
        .proof-number {
            font-size: 3rem;
            font-family: 'Share Tech Mono', monospace;
            color: var(--accent);
            margin-bottom: 10px;
        }
        
        .proof-label {
            color: var(--text-primary);
            font-size: 1rem;
        }
        
        /* Author Section */
        .author {
            background: var(--bg-primary);
        }
        
        .author-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 50px;
            align-items: center;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .author-image {
            width: 100%;
            height: 300px;
            background: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--bg-tertiary);
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .author-text h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #ffffff;
        }
        
        .author-text p {
            color: var(--text-primary);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .author-credentials {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid var(--bg-tertiary);
        }
        
        .author-credentials h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            color: var(--accent);
            margin-bottom: 15px;
        }
        
        .author-credentials ul {
            list-style: none;
        }
        
        .author-credentials li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            color: var(--text-primary);
            font-size: 15px;
        }
        
        .author-credentials li:before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--accent);
        }
        
        /* Final CTA Section */
        .final-cta {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            padding: 100px 0;
            text-align: center;
        }
        
        .final-cta h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #ffffff;
        }
        
        .final-cta p {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Responsive Design */
        @media (max-width: 968px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
            
            .header-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .header-right {
                text-align: center;
            }
            
            .before-after {
                grid-template-columns: 1fr;
            }
            
            .author-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
        }
        
        @media (max-width: 640px) {
            .hero-text h1 {
                font-size: 2rem;
            }
            
            .hero-text .subheadline {
                font-size: 1.2rem;
            }
            
            .form-container {
                padding: 30px 20px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .final-cta h2 {
                font-size: 2rem;
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
        
        /* Improved Contrast */
        .pain-card p,
        .benefit-card p,
        .author-text p {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Animations */
        .pain-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .pain-card:nth-child(1) { animation-delay: 0.1s; }
        .pain-card:nth-child(2) { animation-delay: 0.2s; }
        .pain-card:nth-child(3) { animation-delay: 0.3s; }
        .pain-card:nth-child(4) { animation-delay: 0.4s; }
        .pain-card:nth-child(5) { animation-delay: 0.5s; }
        .pain-card:nth-child(6) { animation-delay: 0.6s; }
        .pain-card:nth-child(7) { animation-delay: 0.7s; }
        .pain-card:nth-child(8) { animation-delay: 0.8s; }
        .pain-card:nth-child(9) { animation-delay: 0.9s; }
        .pain-card:nth-child(10) { animation-delay: 1s; }
        .pain-card:nth-child(11) { animation-delay: 1.1s; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .benefit-card {
            opacity: 0;
            animation: fadeInScale 0.6s ease forwards;
        }
        
        .benefit-card:nth-child(1) { animation-delay: 0.1s; }
        .benefit-card:nth-child(2) { animation-delay: 0.2s; }
        .benefit-card:nth-child(3) { animation-delay: 0.3s; }
        .benefit-card:nth-child(4) { animation-delay: 0.4s; }
        .benefit-card:nth-child(5) { animation-delay: 0.5s; }
        .benefit-card:nth-child(6) { animation-delay: 0.6s; }
        .benefit-card:nth-child(7) { animation-delay: 0.7s; }
        .benefit-card:nth-child(8) { animation-delay: 0.8s; }
        .benefit-card:nth-child(9) { animation-delay: 0.9s; }
        .benefit-card:nth-child(10) { animation-delay: 1s; }
        .benefit-card:nth-child(11) { animation-delay: 1.1s; }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .benefit-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        .benefit-card:nth-child(2) .benefit-icon { animation-delay: 0.5s; }
        .benefit-card:nth-child(3) .benefit-icon { animation-delay: 1s; }
        .benefit-card:nth-child(4) .benefit-icon { animation-delay: 1.5s; }
        .benefit-card:nth-child(5) .benefit-icon { animation-delay: 2s; }
        .benefit-card:nth-child(6) .benefit-icon { animation-delay: 2.5s; }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(125, 73, 204, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(125, 73, 204, 0); }
        }
        
        .btn-primary {
            animation: pulse 2s infinite;
        }
        
        /* Testimonials */
        .testimonials {
            background: var(--bg-primary);
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }
        
        .testimonial-card {
            background: var(--bg-secondary);
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid var(--accent);
            position: relative;
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 60px;
            color: var(--accent);
            opacity: 0.3;
            font-family: serif;
        }
        
        .testimonial-text {
            color: var(--text-primary);
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.7;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .testimonial-author-info h4 {
            color: #ffffff;
            font-size: 1rem;
            margin-bottom: 5px;
        }
        
        .testimonial-author-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        /* Case Study */
        .case-study {
            background: var(--bg-secondary);
            padding: 40px;
            border-radius: 12px;
            margin-top: 40px;
            border: 1px solid var(--bg-tertiary);
        }
        
        .case-study-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .case-study-title {
            font-size: 1.8rem;
            color: #ffffff;
        }
        
        .case-study-metrics {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .metric-item {
            text-align: center;
        }
        
        .metric-number {
            font-size: 2rem;
            color: var(--accent);
            font-weight: 600;
            display: block;
        }
        
        .metric-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .case-study-content {
            color: var(--text-primary);
            line-height: 1.8;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Client Logos */
        .client-logos {
            background: var(--bg-secondary);
            padding: 40px 0;
        }
        
        .logos-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 40px;
            opacity: 0.6;
        }
        
        .logo-item {
            font-size: 1.5rem;
            color: var(--text-secondary);
            font-weight: 600;
            padding: 15px 30px;
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .logo-item:hover {
            opacity: 1;
            border-color: var(--accent);
            color: var(--accent);
        }
        
        /* FAQ */
        .faq {
            background: var(--bg-primary);
        }
        
        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .faq-item {
            background: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .faq-item.active {
            border-color: var(--accent);
        }
        
        .faq-question {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .faq-question:hover {
            color: var(--accent);
        }
        
        .faq-icon {
            width: 24px;
            height: 24px;
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }
        
        .faq-icon::before,
        .faq-icon::after {
            content: '';
            position: absolute;
            background: var(--accent);
            transition: all 0.3s ease;
        }
        
        .faq-icon::before {
            width: 2px;
            height: 16px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        
        .faq-icon::after {
            width: 16px;
            height: 2px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 20px;
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 20px 20px 20px;
        }
        
        .faq-answer p {
            color: var(--text-primary);
            line-height: 1.7;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Z-Pattern Layout */
        .pain-card:nth-child(odd) {
            transform: translateX(-10px);
        }
        
        .pain-card:nth-child(even) {
            transform: translateX(10px);
        }
        
        @media (max-width: 640px) {
            .pain-card:nth-child(odd),
            .pain-card:nth-child(even) {
                transform: translateX(0);
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
                <div class="header-right">Software Development</div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>You Have a Software Idea But Don't Know Where to Start</h1>
                    <p class="subheadline">Turn your software idea into a working application. I build your project from scratch with clean code, scalable architecture, and production-ready solutions.</p>
                    <p>You have a software idea that could transform your business, but you don't have the technical expertise to build it yourself. You need a developer who will take your idea and turn it into a complete, working application—with proper architecture, security, and documentation from day one.</p>
                </div>
                
                <div class="form-container">
                <h3>Get a Free Project Assessment</h3>
                <p>Tell me about your new project idea and I'll send you a free assessment with technical recommendations and next steps.</p>
                <form id="leadForm" action="#" method="POST">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your best email address" required>
                    </div>
                    <button type="submit" class="btn-primary">Get My Free Assessment</button>
                </form>
                <p style="text-align: center; color: var(--text-secondary); font-size: 0.85rem; margin-top: 15px;">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pain Points Section -->
    <section class="section pain-points" id="pain-points">
        <div class="container">
            <h2 class="section-title">Common Problems When Building Software Projects</h2>
            <p class="section-subtitle">These are the issues that kill software projects. When I develop your project, I build it right from the start to avoid these problems.</p>
            
            <div class="pain-grid">
                <div class="pain-card">
                    <h3>Wrong Technology Choice</h3>
                    <p>Choosing the wrong tech stack leads to performance issues, scalability problems, and expensive rewrites later. I select the right technologies based on your project's specific needs.</p>
                </div>
                <div class="pain-card">
                    <h3>Poor Architecture</h3>
                    <p>Bad architecture makes code hard to maintain, extend, and scale. I design clean, modular architecture that grows with your needs.</p>
                </div>
                <div class="pain-card">
                    <h3>Security Vulnerabilities</h3>
                    <p>Security flaws can destroy your project. I build security into every layer—authentication, data validation, and protection against common attacks.</p>
                </div>
                <div class="pain-card">
                    <h3>Performance Issues</h3>
                    <p>Slow applications lose users. I optimize database queries, implement caching, and design for performance from day one.</p>
                </div>
                <div class="pain-card">
                    <h3>Brittle Integrations</h3>
                    <p>Third-party integrations break and cause failures. I build robust integrations with proper error handling, retry logic, and fallback strategies.</p>
                </div>
                <div class="pain-card">
                    <h3>No Testing</h3>
                    <p>Bugs discovered in production damage your reputation. I write comprehensive tests so your application works reliably before it goes live.</p>
                </div>
                <div class="pain-card">
                    <h3>Technical Debt</h3>
                    <p>Quick fixes become permanent problems. I write clean, maintainable code that won't become a maintenance nightmare.</p>
                </div>
                <div class="pain-card">
                    <h3>Deployment Problems</h3>
                    <p>Manual deployments are error-prone and risky. I set up automated CI/CD pipelines for safe, reliable deployments.</p>
                </div>
                <div class="pain-card">
                    <h3>Can't Scale</h3>
                    <p>Applications that can't handle growth fail. I architect for scalability from the start—database optimization, caching, and horizontal scaling.</p>
                </div>
                <div class="pain-card">
                    <h3>No Monitoring</h3>
                    <p>You discover problems only when users complain. I set up logging, error tracking, and performance monitoring so you know how your application is performing.</p>
                </div>
                <div class="pain-card">
                    <h3>No Documentation</h3>
                    <p>Software without documentation is impossible to maintain or extend. Future updates become expensive and risky when nobody understands how the system works. I document everything: setup, deployment, APIs, and code structure.</p>
                </div>
            </div>
            
            <div class="cta-inline">
                <a href="#hero" class="btn-secondary">Get The Solution Now</a>
            </div>
        </div>
    </section>
    
    <!-- Transformation Section -->
    <section class="section transformation" id="transformation">
        <div class="container">
            <h2 class="section-title">The Transformation</h2>
            <p class="section-subtitle">See the difference between projects built wrong and projects built right from the start.</p>
            
            <div class="before-after">
                <div class="before">
                    <h3>Projects Built Wrong</h3>
                    <ul>
                        <li>Poor architecture that's hard to maintain</li>
                        <li>Performance issues from day one</li>
                        <li>Security vulnerabilities built into the system</li>
                        <li>Brittle integrations that break frequently</li>
                        <li>No testing, bugs discovered in production</li>
                        <li>Technical debt accumulating from the start</li>
                        <li>No documentation, hard to understand later</li>
                        <li>Manual deployments that are error-prone</li>
                        <li>System can't scale when you need it</li>
                        <li>No monitoring, problems discovered too late</li>
                    </ul>
                </div>
                <div class="after">
                    <h3>Projects Built Right</h3>
                    <ul>
                        <li>Clean architecture designed for growth</li>
                        <li>Optimized performance from the start</li>
                        <li>Security best practices built in</li>
                        <li>Robust integrations with proper error handling</li>
                        <li>Comprehensive testing before deployment</li>
                        <li>Minimal technical debt, maintainable code</li>
                        <li>Complete documentation for future reference</li>
                        <li>Automated deployments with CI/CD pipeline</li>
                        <li>Scalable architecture ready for growth</li>
                        <li>Full monitoring and observability from launch</li>
                    </ul>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Start Your Transformation</a>
            </div>
        </div>
    </section>
    
    <!-- Solution Section -->
    <section class="section solution" id="solution">
        <div class="container">
            <div class="solution-content">
                <h2 class="section-title">I'm a Software Developer Who will Build Your Project</h2>
                <p>When you hire me, I will develop your application end-to-end: architecture, coding, testing, deployment, and documentation.</p>
                <p>I've built software and APIs for clients across different industries (including governments). I choose the right technology stack, design scalable architecture, write clean code, implement security best practices, and set up professional deployment pipelines.</p>
                <p>You get a working application that's production-ready, maintainable, and built to scale. I deliver the code, the infrastructure setup, and everything needed to run your project successfully.</p>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Tell Me About Your Project</a>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="section benefits" id="benefits">
        <div class="container">
            <h2 class="section-title">What I Deliver When I Develop Your Project</h2>
            <p class="section-subtitle">When you hire me to build your software, this is what you get.</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3>Working Application</h3>
                    <p>I deliver a fully functional application that works. Not prototypes or demos—a real, production-ready system you can deploy and use.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                        </svg>
                    </div>
                    <h3>Clean, Scalable Code</h3>
                    <p>I write clean, well-structured code with proper architecture. Your codebase is maintainable, extensible, and built to handle growth.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                        </svg>
                    </div>
                    <h3>Security Built In</h3>
                    <p>I implement security best practices throughout: authentication, authorization, data validation, and protection against vulnerabilities.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 0 1 9.5 16 6.5 6.5 0 0 1 3 9.5 6.5 6.5 0 0 1 9.5 3m0 2C7.01 5 5 7.01 5 9.5S7.01 14 9.5 14 14 11.99 14 9.5 11.99 5 9.5 5z"/>
                        </svg>
                    </div>
                    <h3>All Integrations Working</h3>
                    <p>I build integrations with APIs, payment gateways, and third-party services. They work reliably with proper error handling and fallbacks.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <h3>Thoroughly Tested</h3>
                    <p>I write tests for critical functionality. Your application works reliably because I test it before delivery.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3>Optimized Performance</h3>
                    <p>I optimize database queries, implement caching, and design for speed. Your application performs well from day one.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <h3>Complete Documentation</h3>
                    <p>I document setup, deployment, API endpoints, and code structure. You can understand and maintain the project easily.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </div>
                    <h3>Deployment Ready</h3>
                    <p>I set up CI/CD pipelines and deployment configurations. You can deploy updates safely and reliably.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0L19.2 12l-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                        </svg>
                    </div>
                    <h3>Source Code & Access</h3>
                    <p>You get the complete source code, repository access, and everything needed to run and maintain the project yourself.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                    </div>
                    <h3>Monitoring Setup</h3>
                    <p>I configure logging, error tracking, and performance monitoring so you know how your application is performing.</p>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get These Benefits Now</a>
            </div>
        </div>
    </section>
    
    <!-- Social Proof Section -->
    <section class="section social-proof" id="social-proof">
        <div class="container">
            <h2 class="section-title">Results When You Hire a Professional Developer</h2>
            <p class="section-subtitle">These are the outcomes you get when your software is built by an experienced developer who writes quality code.</p>
            
            <div class="proof-grid">
                <div class="proof-card">
                    <div class="proof-number">5x</div>
                    <div class="proof-label">Faster Time to Market</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">80%</div>
                    <div class="proof-label">Fewer Production Bugs</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">3x</div>
                    <div class="proof-label">Easier to Maintain</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">90%</div>
                    <div class="proof-label">Lower Long-Term Costs</div>
                </div>
            </div>
            
            <!-- Case Study - COMMENTED OUT (uncomment when you have case study data) -->
            <!--
            <div class="case-study">
                <div class="case-study-header">
                    <h3 class="case-study-title">Case Study: E-Commerce Platform</h3>
                    <div class="case-study-metrics">
                        <div class="metric-item">
                            <span class="metric-number">80%</span>
                            <span class="metric-label">Fewer Bugs</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">5x</span>
                            <span class="metric-label">Faster Launch</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">90%</span>
                            <span class="metric-label">Cost Reduction</span>
                        </div>
                    </div>
                </div>
                <div class="case-study-content">
                    <p>An e-commerce startup had been through 3 developers and $50,000 in failed attempts. The codebase was a mess with security vulnerabilities and couldn't handle traffic. After a complete rebuild with proper architecture, automated testing, and CI/CD, they launched in 3 months instead of 12, with 80% fewer production bugs and 90% lower maintenance costs.</p>
                </div>
            </div>
            -->
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Join These Success Stories</a>
            </div>
        </div>
    </section>
    
    <!-- Client Logos Section - COMMENTED OUT (uncomment when you have client data) -->
    <!--
    <section class="client-logos">
        <div class="container">
            <div class="logos-container">
                <div class="logo-item">Client A</div>
                <div class="logo-item">Client B</div>
                <div class="logo-item">Client C</div>
                <div class="logo-item">Client D</div>
                <div class="logo-item">Client E</div>
            </div>
        </div>
    </section>
    -->
    
    <!-- Testimonials Section - COMMENTED OUT (uncomment when you have testimonial data) -->
    <!--
    <section class="section testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title">What Clients Say</h2>
            <p class="section-subtitle">Real feedback from businesses that got their software built right.</p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">We'd been through 3 developers and wasted $50k. Rogerio rebuilt our entire platform with clean architecture. No more 2 AM bug fixes. The code actually works.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>David Martinez</h4>
                            <p>CTO, Tech Startup</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">Finally, a developer who writes code that makes sense. The documentation is clear, the architecture is scalable, and we haven't had a production bug in months.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Jennifer Kim</h4>
                            <p>Founder, SaaS Platform</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">Best investment we made. The system handles 10x more traffic now, and we can actually add features without breaking everything. Worth every penny.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Robert Thompson</h4>
                            <p>CEO, E-Commerce Company</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Your Free Assessment</a>
            </div>
        </div>
    </section>
    -->
    
    <!-- FAQ Section -->
    <section class="section faq" id="faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Get answers to common questions about software development services.</p>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How long does it take to develop a software project?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Timeline depends on project scope and complexity. Simple applications can be completed in 4-8 weeks, while complex systems may take 3-6 months. I provide detailed timelines after reviewing your requirements.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What technologies do you work with?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>My main stack is PHP (Laravel), Vue.js, and AWS/Laravel Cloud. I choose the best technology for your specific project needs and requirements.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you provide ongoing maintenance and support?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The code is well-documented and maintainable, so your team can handle updates and maintenance after delivery. I can also collaborate on new requirements and features as needed (new work may be priced separately).</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if I need changes after the project is complete?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The architecture is designed to be extensible. Your team can handle updates and new features using the provided documentation, or we can collaborate together on new requirements and features (new work may be priced separately).</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do you ensure code quality?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I write comprehensive tests, follow best practices, conduct code reviews, and use automated testing tools. Code quality is built into the development process from day one.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you handle deployment and infrastructure setup?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. I set up CI/CD pipelines, configure deployment environments, and provide infrastructure setup. Depending on your preference, the project can be ready to deploy or already deployed and ready to use.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if my project has security requirements?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Security is built into every layer: authentication, authorization, data validation, encryption, and protection against common vulnerabilities. I follow security best practices throughout development.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can you work with my existing codebase?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>While I can work with existing codebases, it's not uncommon for legacy projects to be easier and faster to rebuild from scratch rather than refactoring existing code. I assess each situation and provide honest recommendations.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do you handle project communication and updates?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I provide regular updates, use project management tools, and maintain clear communication throughout development. You're always informed about progress and can provide feedback.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What's included in the final delivery?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>You receive the complete source code, documentation (setup, deployment, API docs), repository access, deployment configuration, and everything needed to run and maintain the project. Depending on your preference, final delivery can include the project deployed and ready to use.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you work with remote teams or other developers?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. I can work with remote teams or other developers, but I work independently—not as a company employee. This includes my work hours, meeting availability, and work days.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if the project scope changes during development?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I handle scope changes transparently. We discuss impact on timeline and budget, and adjust the plan accordingly. The architecture is flexible enough to accommodate changes.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do you ensure the application can scale?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I design for scalability from the start: database optimization, caching strategies, horizontal scaling capabilities, and performance monitoring. The architecture grows with your needs. Note that while the code is ready to scale, it may require scaling the infrastructure as well.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What happens if there are bugs after launch?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I provide a warranty period for critical bugs. The comprehensive testing minimizes issues, and monitoring and error tracking catch issues early. After the warranty period, any new changes or bug fixes may be handled as new work and priced accordingly.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can you help with technical decisions and architecture choices?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely. For new projects, I provide technical recommendations, help choose the right stack, design architecture, and guide technical decisions based on your project requirements and long-term goals.</p>
                    </div>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Your Free Assessment</a>
            </div>
        </div>
    </section>
    
    <!-- Author Section -->
    <section class="section author" id="author">
        <div class="container">
            <h2 class="section-title">Who Am I</h2>
            <p class="section-subtitle">Let me introduce myself and why I'm passionate about helping you build your software project</p>
            
            <div class="author-content">
                <div class="author-image">
                    <img src="img/rogerio-pereira-development.jpg" alt="Rogerio Pereira - Software Developer">
                </div>
                <div class="author-text">
                    <h2>I Turn Your Ideas Into Working Software</h2>
                    <p>I've developed software and APIs across different industries (including governments). I've worked with various technologies and learned what works in production and what doesn't.</p>
                    <p>When you hire me, I will develop your entire application end-to-end: I choose the tech stack, design the architecture, write the code, implement features, set up testing, configure deployment, and deliver documentation. You get a complete, working application.</p>
                    <p>If you need software developed and want it built right—with clean code, proper architecture, and best practices—let's discuss your project.</p>
                    
                    <div class="author-credentials">
                        <h3>What I Bring to the Table</h3>
                        <ul>
                            <li>Years of experience developing software and APIs for various industries</li>
                            <li>Hands-on experience building production-ready applications from scratch</li>
                            <li>Deep understanding of software architecture and best practices</li>
                            <li>Practical knowledge of technologies that work in production</li>
                            <li>Real-world insights from developing software for clients including governments</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Started With Me</a>
            </div>
        </div>
    </section>
    
    <!-- Final CTA Section -->
    <section class="final-cta" id="final-cta">
        <div class="container">
            <h2>Ready to Get Your Software Project Developed?</h2>
            <p>Stop searching for developers or worrying about technical details. Hire a professional developer who will build your application right—clean code, scalable architecture, and production-ready from day one.</p>
            <a href="#hero" class="btn-primary" style="display: inline-block; text-decoration: none;">Get a Quote</a>
        </div>
    </section>
    
    <script>
        // Smooth scroll for CTA buttons
        document.querySelectorAll('a[href="#hero"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector('#hero').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
        
        // Form submission handler (to be integrated with Mautic)
        document.getElementById('leadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // This will be replaced with Mautic integration
            alert('Thank you! Your information has been submitted. I\'ll get back to you soon with a quote.');
        });
        
        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function() {
                const faqItem = this.parentElement;
                const isActive = faqItem.classList.contains('active');
                
                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });
    </script>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Rogerio Pereira. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

