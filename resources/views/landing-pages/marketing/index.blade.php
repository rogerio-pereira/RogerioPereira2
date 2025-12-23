<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transform Your Marketing Strategy - Stop Wasting Time and Money</title>
    <meta name="description" content="Discover proven marketing strategies that generate qualified leads and convert visitors into customers, even with limited budget.">
    
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
            font-weight: 300;
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
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(195, 50, 158, 0.1);
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            background: #a0287d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(195, 50, 158, 0.3);
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Alternating Layout for Pain Points - Z-Pattern */
        .pain-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .pain-card:nth-child(odd) {
            transform: translateX(-10px);
        }
        
        .pain-card:nth-child(even) {
            transform: translateX(10px);
        }
        
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
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
            background: rgba(195, 50, 158, 0.1);
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
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
            
            .pain-card:nth-child(odd),
            .pain-card:nth-child(even) {
                transform: translateX(0);
            }
            
            .case-study-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .case-study-metrics {
                width: 100%;
                justify-content: space-around;
            }
            
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            .faq-question {
                font-size: 0.95rem;
                padding: 15px;
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
        
        /* Testimonials Section */
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
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
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
        
        /* Case Study Section */
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
        
        /* FAQ Section */
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
        
        /* Alternating Layout for Solution Section */
        .solution-alternate {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            margin-top: 60px;
        }
        
        .solution-alternate:nth-child(even) {
            direction: rtl;
        }
        
        .solution-alternate:nth-child(even) > * {
            direction: ltr;
        }
        
        /* Micro Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .benefit-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        .benefit-card:nth-child(2) .benefit-icon {
            animation-delay: 0.5s;
        }
        
        .benefit-card:nth-child(3) .benefit-icon {
            animation-delay: 1s;
        }
        
        .benefit-card:nth-child(4) .benefit-icon {
            animation-delay: 1.5s;
        }
        
        .benefit-card:nth-child(5) .benefit-icon {
            animation-delay: 2s;
        }
        
        .benefit-card:nth-child(6) .benefit-icon {
            animation-delay: 2.5s;
        }
        
        /* Pulse animation for CTA buttons */
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(195, 50, 158, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(195, 50, 158, 0); }
        }
        
        .btn-primary {
            animation: pulse 2s infinite;
        }
        
        /* Scroll animations */
        .fade-in-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
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

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Your Social Media Posts Get 3 Likes While Competitors Get Hundreds</h1>
                    <p class="subheadline">Stop spending your mornings putting out fires with random marketing tactics. Get a proven system that turns your limited budget into qualified leads that actually buy.</p>
                    <p>You're posting daily, running Facebook ads, trying Instagram reels, doing weird TikTok dances hoping it somehow helps your brand, and nothing sticks. Your content gets ignored, your ads burn cash, and you're left wondering if marketing even works for small businesses. The problem isn't your budget—it's your strategy.</p>
                </div>
                
                <div class="form-container">
                <h3>Get Your Free Marketing Strategy Guide</h3>
                <p>Discover the exact strategies that help small businesses compete with bigger budgets and generate consistent leads.</p>
                
                @if(session('error'))
                    <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('message'))
                    <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                        {{ session('message') }}
                    </div>
                @endif
                
                <form id="leadForm" action="{{ route('marketing.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your best email address" required value="{{ old('email') }}">
                    </div>

                    <input type='hidden' name='captcha' value='' >

                    <button type="submit" class="btn-primary">Get My Free Guide Now</button>
                </form>
                <p style="text-align: center; color: var(--text-secondary); font-size: 0.85rem; margin-top: 15px;">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pain Points Section -->
    <section class="section pain-points" id="pain-points">
        <div class="container">
            <h2 class="section-title">Are You Struggling With These Marketing Challenges?</h2>
            <p class="section-subtitle">If you recognize yourself in any of these situations, you're not alone—and there's a solution.</p>
            
            <div class="pain-grid">
                <div class="pain-card">
                    <h3>No Clear Strategy</h3>
                    <p>You're trying different tactics but don't have a clear direction. You're not sure which channels to prioritize or what message to send.</p>
                </div>
                <div class="pain-card">
                    <h3>Limited Budget</h3>
                    <p>You can't compete with big brands' advertising budgets. You need strategies that work without breaking the bank.</p>
                </div>
                <div class="pain-card">
                    <h3>Content Gets No Engagement</h3>
                    <p>Your posts, stories, and campaigns barely get any likes, comments, or shares. You're posting but no one seems to care.</p>
                </div>
                <div class="pain-card">
                    <h3>Inconsistent Social Media</h3>
                    <p>You go days or weeks without posting. When you do post, it's random and doesn't align with any clear plan.</p>
                </div>
                <div class="pain-card">
                    <h3>Can't Measure What Works</h3>
                    <p>You don't know which campaigns generate leads, what content performs best, or your actual ROI. You're making decisions based on guesswork.</p>
                </div>
                <div class="pain-card">
                    <h3>Wrong Leads, No Conversions</h3>
                    <p>You're attracting people who don't buy. Your traffic is high but conversions are low. Visitors don't fill out forms or take action.</p>
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
            <p class="section-subtitle">See the difference between struggling with marketing and having a system that works.</p>
            
            <div class="before-after">
                <div class="before">
                    <h3>Before</h3>
                    <ul>
                        <li>Posting randomly without a plan</li>
                        <li>Wasting money on ads that don't convert</li>
                        <li>No idea which strategies actually work</li>
                        <li>Attracting leads that never buy</li>
                        <li>Feeling overwhelmed by all the options</li>
                        <li>No clear way to measure results</li>
                        <li>Competing with bigger budgets and losing</li>
                    </ul>
                </div>
                <div class="after">
                    <h3>After</h3>
                    <ul>
                        <li>Clear marketing strategy with measurable goals</li>
                        <li>Organic strategies that work on any budget</li>
                        <li>Data-driven decisions based on real metrics</li>
                        <li>Qualified leads that actually convert</li>
                        <li>Consistent content calendar that builds authority</li>
                        <li>Simple dashboards showing what works</li>
                        <li>Unique positioning that sets you apart</li>
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
                <h2 class="section-title">The Solution: Proven Marketing Strategies That Actually Work</h2>
                <p>I've helped dozens of small businesses transform their marketing from chaotic and ineffective to strategic and profitable. The secret isn't having a huge budget—it's having the right strategy, the right systems, and the right approach.</p>
                <p>Through years of testing, analyzing, and optimizing marketing campaigns, I've identified the exact strategies that generate qualified leads and convert visitors into customers—even when you're competing with bigger brands.</p>
                <p>This isn't about complex theories or expensive tools. It's about practical, actionable strategies you can implement right away to start seeing real results.</p>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Access to These Strategies</a>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="section benefits" id="benefits">
        <div class="container">
            <h2 class="section-title">What You'll Get</h2>
            <p class="section-subtitle">Practical strategies and systems that transform your marketing from guesswork into a predictable system.</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <h3>Clear Strategy</h3>
                    <p>A step-by-step marketing plan with defined goals, priorities, and a roadmap of actions that align with your business objectives.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3>Budget-Friendly Tactics</h3>
                    <p>Organic marketing strategies and low-cost tactics with high ROI. Learn how to compete effectively without a massive advertising budget.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <h3>Qualified Leads</h3>
                    <p>Strategies to attract and qualify leads that match your ideal customer profile, so you stop wasting time on people who don't buy.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                        </svg>
                    </div>
                    <h3>Consistent Presence</h3>
                    <p>An automated content calendar and production system that keeps your social media active and builds authority without constant manual work.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                    </div>
                    <h3>Measurable Results</h3>
                    <p>Simple dashboards and essential KPIs so you know exactly what's working, what's not, and where to focus your efforts.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                        </svg>
                    </div>
                    <h3>Higher Conversions</h3>
                    <p>Optimized landing pages and conversion funnels that turn visitors into leads and leads into customers.</p>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get These Benefits Now</a>
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
    
    <!-- Social Proof Section -->
    <section class="section social-proof" id="social-proof">
        <div class="container">
            <h2 class="section-title">What's Possible With The Right Approach</h2>
            <p class="section-subtitle">These are realistic outcomes you can achieve when you stop guessing and start following a clear, systematic approach to marketing.</p>
            
            <div class="proof-grid">
                <div class="proof-card">
                    <div class="proof-number">10x</div>
                    <div class="proof-label">Average ROI Increase</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">85%</div>
                    <div class="proof-label">Lead Quality Improvement</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">3x</div>
                    <div class="proof-label">Conversion Rate Increase</div>
                </div>
                <div class="proof-card">
                    <div class="proof-number">60%</div>
                    <div class="proof-label">Cost Reduction</div>
                </div>
            </div>
            
            <!-- Case Study - COMMENTED OUT (uncomment when you have case study data) -->
            <!--
            <div class="case-study">
                <div class="case-study-header">
                    <h3 class="case-study-title">Case Study: Local Service Business</h3>
                    <div class="case-study-metrics">
                        <div class="metric-item">
                            <span class="metric-number">250%</span>
                            <span class="metric-label">Lead Increase</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">40%</span>
                            <span class="metric-label">Cost Reduction</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">3.5x</span>
                            <span class="metric-label">ROI Improvement</span>
                        </div>
                    </div>
                </div>
                <div class="case-study-content">
                    <p>A local service business was spending $2,000/month on Facebook ads with minimal results. After implementing a strategic content calendar, organic SEO tactics, and proper lead qualification, they reduced ad spend to $800/month while increasing qualified leads by 250%. The key was focusing on the right channels and messaging that resonated with their ideal customers.</p>
                </div>
            </div>
            -->
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Join These Success Stories</a>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section - COMMENTED OUT (uncomment when you have testimonial data) -->
    <!--
    <section class="section testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title">What Clients Say</h2>
            <p class="section-subtitle">Real feedback from businesses that transformed their marketing approach.</p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">We were throwing money at ads with no strategy. After implementing the marketing system, we cut our ad spend in half and doubled our qualified leads. Finally, we know what's working.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Sarah Johnson</h4>
                            <p>Owner, Local Business</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">I was posting randomly and getting no engagement. The content calendar and strategic approach changed everything. Now we have consistent leads coming in organically.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Michael Chen</h4>
                            <p>Founder, Tech Startup</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">Best investment we made. We stopped guessing and started measuring. The dashboards show exactly what's working, and we're finally competing with bigger budgets.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Emily Rodriguez</h4>
                            <p>CEO, Service Company</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Your Free Strategy Guide</a>
            </div>
        </div>
    </section>
    -->
    
    <!-- FAQ Section -->
    <section class="section faq" id="faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Get answers to common questions about marketing strategy and implementation.</p>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How long does it take to see results from a marketing strategy?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Most businesses start seeing initial results within 30-60 days, with significant improvements in lead quality and conversion rates within 90 days. Organic strategies take longer to build momentum but provide sustainable, long-term results.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do I need a large budget to implement these strategies?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>No. The strategies focus on organic, budget-friendly tactics that work for small businesses. Many successful implementations start with minimal ad spend, focusing instead on content, SEO, and strategic positioning.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if I don't have time to manage marketing daily?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The system includes automation and content calendars that reduce daily management to just a few hours per week. Most tasks can be batched and scheduled in advance.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Will this work for my specific industry?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The core principles apply across industries, but the implementation is customized to your specific market, audience, and business model. The strategies adapt to B2B, B2C, service-based, and product-based businesses.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do I need technical skills or marketing experience?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>No technical skills required. The guide provides step-by-step instructions using tools you likely already have or can easily learn. The focus is on practical, actionable strategies, not complex technical setups.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I measure if the strategy is working?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Simple dashboards track key metrics: lead quality, conversion rates, cost per lead, and ROI. You'll know exactly what's working and what needs adjustment, eliminating guesswork.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What channels should I focus on first?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>This depends on where your ideal customers are. The guide helps you identify the 2-3 most effective channels for your business, so you're not spread thin across every platform.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I implement this alongside my current marketing efforts?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. The strategy helps you optimize what's working and eliminate what's not. You'll gradually shift resources to the most effective tactics while maintaining what already brings results.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if I'm already spending on ads that aren't working?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The guide includes optimization strategies to improve existing ad performance. Often, small adjustments to targeting, messaging, or landing pages can dramatically improve results without increasing spend.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How is this different from other marketing guides?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>This focuses on practical, budget-friendly strategies tested with small businesses, not theoretical concepts. It's a step-by-step system, not just tips. You get actionable frameworks you can implement immediately.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you provide ongoing support after I get the guide?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>The guide is comprehensive and self-contained, but additional support options may be available. The system is designed to be implemented independently with clear instructions.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if I'm in a competitive market with bigger competitors?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Small businesses can compete effectively through strategic positioning, niche focus, and organic tactics that don't require massive budgets. The guide shows how to find and dominate your specific market segment.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I know if my marketing is actually working?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>You'll track specific metrics: qualified leads generated, conversion rates, cost per acquisition, and ROI. The dashboards make it clear what's driving results versus what's just activity without outcomes.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I use this for both online and offline marketing?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. The principles apply to both digital and traditional marketing. The guide focuses on digital tactics but the strategic framework works for any channel where you connect with customers.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What's the biggest mistake small businesses make with marketing?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Spreading efforts too thin across too many channels without a clear strategy. The guide helps you focus on 2-3 high-impact channels and master them before expanding, ensuring better results with less effort.</p>
                    </div>
                </div>
            </div>
            
            <div class="cta-inline" style="margin-top: 50px;">
                <a href="#hero" class="btn-secondary">Get Your Free Guide Now</a>
            </div>
        </div>
    </section>
    
    <!-- Author Section -->
    <section class="section author" id="author">
        <div class="container">
            <h2 class="section-title">Who Am I</h2>
            <p class="section-subtitle">Let me introduce myself and why I'm passionate about helping you transform your marketing</p>
            
            <div class="author-content">
                <div class="author-image">
                    <img src="img/rogerio-pereira-marketing.jpg" alt="Rogerio Pereira - Marketing Strategy Expert">
                </div>
                <div class="author-text">
                    <h2>Marketing Doesn't Have to Be This Hard</h2>
                    <p>I'm someone who's been where you are—trying different marketing tactics, spending money on things that didn't work, and feeling frustrated when nothing seemed to stick.</p>
                    <p>I learned what doesn't work the hard way, by doing it myself. But here's the thing: marketing is actually easier today than it was before. There are better tools, clearer strategies, and more accessible resources available now.</p>
                    <p>After stepping away from marketing for a while, I'm coming back with a fresh perspective and a focus on what actually works—not the complicated theories, but the simple, practical approaches that get results.</p>
                    <p>If you're tired of wasting time and money on marketing that doesn't work, let's figure out what will work for you together.</p>
                    
                    <div class="author-credentials">
                        <h3>What I Bring to the Table</h3>
                        <ul>
                            <li>Years of experience testing and analyzing marketing strategies</li>
                            <li>Hands-on experience helping small businesses compete with bigger budgets</li>
                            <li>Deep understanding of what actually works in modern marketing</li>
                            <li>Clear perspective on what doesn't work, learned from real experience</li>
                            <li>Focus on simple, practical approaches rather than complicated theories</li>
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
            <h2>Ready to Transform Your Marketing?</h2>
            <p>Stop guessing what works. Get proven strategies that generate qualified leads and convert visitors into customers.</p>
            <a href="#hero" class="btn-primary" style="display: inline-block; text-decoration: none;">Get Your Free Marketing Strategy Guide</a>
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
        
        // Form will submit normally to the server
        
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
        
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
            observer.observe(el);
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

