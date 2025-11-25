<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rogerio Pereira - Professional Services Hub</title>
    <meta name="description" content="Choose your service: Marketing Strategy, Software Development, or Business Automation. Professional solutions tailored to your needs.">
    
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
            
            /* Primary Colors by Service */
            --marketing: #C3329E;
            --development: #7D49CC;
            --automation: #2CBFB3;
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
            max-width: 1400px;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            color: #ffffff;
            font-weight: 600;
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            padding: 80px 0;
        }
        
        .hero-content {
            text-align: center;
        }
        
        .hero-text h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-text .subheadline {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 60px;
            font-weight: 300;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Hero CTAs - Three Columns */
        .hero-ctas {
            display: grid;
            grid-template-columns: 1fr 1.4fr 1fr;
            gap: 30px;
            margin-top: 60px;
            align-items: stretch;
        }
        
        .hero-cta-card {
            background: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 40px;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .hero-cta-card.marketing {
            border-left: 4px solid var(--marketing);
        }
        
        .hero-cta-card.marketing:hover {
            border-color: var(--marketing);
        }
        
        .hero-cta-card.development {
            border-left: 4px solid var(--development);
            background: linear-gradient(135deg, rgba(125, 73, 204, 0.1) 0%, var(--bg-secondary) 100%);
            padding: 50px 45px;
            min-height: calc(100% + 50px);
            margin-top: -25px;
            position: relative;
            z-index: 10;
        }
        
        .hero-cta-card.development:hover {
            border-color: var(--development);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .hero-cta-card.automation {
            border-left: 4px solid var(--automation);
        }
        
        .hero-cta-card.automation:hover {
            border-color: var(--automation);
        }
        
        .hero-cta-card h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .hero-cta-card.marketing h3 {
            color: var(--marketing);
        }
        
        .hero-cta-card.development h3 {
            color: var(--development);
            font-size: 2rem;
        }
        
        .hero-cta-card.automation h3 {
            color: var(--automation);
        }
        
        .hero-cta-card p {
            color: var(--text-primary);
            margin-bottom: 30px;
            flex-grow: 1;
            line-height: 1.7;
        }
        
        .btn-hero-cta {
            width: 100%;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .hero-cta-card.marketing .btn-hero-cta {
            background: var(--marketing);
            color: #ffffff;
        }
        
        .hero-cta-card.marketing .btn-hero-cta:hover,
        .btn-hero-cta.marketing:hover {
            background: #a0287d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(195, 50, 158, 0.3);
        }
        
        .hero-cta-card.development .btn-hero-cta {
            background: var(--development);
            color: #ffffff;
        }
        
        .hero-cta-card.development .btn-hero-cta:hover,
        .btn-hero-cta.development:hover {
            background: #6a3db0;
            transform: translateY(-2px);
            /* Pulse animation applied via .btn-hero-cta.development:hover below */
        }
        
        .hero-cta-card.automation .btn-hero-cta {
            background: var(--automation);
            color: #ffffff;
        }
        
        .hero-cta-card.automation .btn-hero-cta:hover,
        .btn-hero-cta.automation:hover {
            background: #24a89a;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 191, 179, 0.3);
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
        
        /* Three Columns Grid for Sections */
        .three-columns {
            display: grid;
            grid-template-columns: 1fr 1.4fr 1fr;
            gap: 30px;
            align-items: stretch;
        }
        
        .column-card {
            background: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        
        .column-card > *:last-child {
            margin-bottom: 0;
        }
        
        /* Push button to bottom of card when card has flex layout */
        .column-card .btn-final-cta {
            margin-top: auto;
            padding-top: 30px;
            width: 100%;
            text-align: center;
        }
        
        .column-card.marketing {
            border-left: 4px solid var(--marketing);
        }
        
        .column-card.development {
            border-left: 4px solid var(--development);
            background: linear-gradient(135deg, rgba(125, 73, 204, 0.1) 0%, var(--bg-secondary) 100%);
            padding: 40px 35px;
            min-height: calc(100% + 50px);
            margin-top: -25px;
            position: relative;
            z-index: 10;
        }
        
        /* Ensure all cards have same base height */
        .three-columns > .column-card {
            height: 100%;
        }
        
        .column-card.automation {
            border-left: 4px solid var(--automation);
        }
        
        .column-card h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .column-card.marketing h3 {
            color: var(--marketing);
        }
        
        .column-card.development h3 {
            color: var(--development);
            font-size: 1.7rem;
        }
        
        .column-card.automation h3 {
            color: var(--automation);
        }
        
        .column-card p {
            color: var(--text-primary);
            margin-bottom: 15px;
            line-height: 1.7;
            flex-grow: 0;
        }
        
        .column-card > p:last-child {
            margin-bottom: 0;
        }
        
        .column-card ul {
            list-style: none;
            padding: 0;
            flex-grow: 0;
        }
        
        .column-card li {
            padding: 10px 0;
            padding-left: 25px;
            position: relative;
            color: var(--text-primary);
        }
        
        .column-card.marketing li::before {
            content: "×";
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-weight: bold;
        }
        
        .column-card.development li::before {
            content: "×";
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-weight: bold;
        }
        
        .column-card.automation li::before {
            content: "×";
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-weight: bold;
        }
        
        .column-card.marketing li.after::before {
            content: "✓";
            color: var(--marketing);
        }
        
        .column-card.development li.after::before {
            content: "✓";
            color: var(--development);
        }
        
        .column-card.automation li.after::before {
            content: "✓";
            color: var(--automation);
        }
        
        /* Pain Points Section */
        .pain-points {
            background: var(--bg-secondary);
        }
        
        /* Transformation Section */
        .transformation {
            background: var(--bg-primary);
        }
        
        /* Solution Section */
        .solution {
            background: var(--bg-secondary);
        }
        
        /* Benefits Section */
        .benefits {
            background: var(--bg-primary);
        }
        
        .benefit-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--bg-tertiary);
            flex-grow: 0;
        }
        
        .benefit-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .benefit-item h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        
        .column-card.marketing .benefit-item h4 {
            color: var(--marketing);
        }
        
        .column-card.development .benefit-item h4 {
            color: var(--development);
        }
        
        .column-card.automation .benefit-item h4 {
            color: var(--automation);
        }
        
        /* Social Proof Section */
        .social-proof {
            background: var(--bg-secondary);
        }
        
        .proof-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .proof-item {
            text-align: center;
            padding: 20px;
        }
        
        .proof-number {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .column-card.marketing .proof-number {
            color: var(--marketing);
        }
        
        .column-card.development .proof-number {
            color: var(--development);
        }
        
        .column-card.automation .proof-number {
            color: var(--automation);
        }
        
        .proof-label {
            color: var(--text-primary);
            font-size: 0.9rem;
            line-height: 1.3;
            min-height: 3.9em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Author Section */
        .author {
            background: var(--bg-primary);
        }
        
        .author-image-container {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .author-image {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            background: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
            overflow: hidden;
            position: relative;
            aspect-ratio: 7 / 4;
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
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
        
        .final-cta-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .btn-final-cta {
            padding: 18px 30px;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-final-cta.marketing {
            background: var(--marketing);
            color: #ffffff;
        }
        
        .btn-final-cta.marketing:hover {
            background: #a0287d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(195, 50, 158, 0.3);
        }
        
        .btn-final-cta.development {
            background: var(--development);
            color: #ffffff;
        }
        
        .btn-final-cta.development:hover {
            background: #6a3db0;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(125, 73, 204, 0.3);
        }
        
        .btn-final-cta.automation {
            background: var(--automation);
            color: #ffffff;
        }
        
        .btn-final-cta.automation:hover {
            background: #24a89a;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 191, 179, 0.3);
        }
        
        /* Generic CTA Button */
        .btn-generic-cta {
            display: inline-block;
            padding: 18px 40px;
            background: linear-gradient(135deg, var(--marketing) 0%, var(--development) 50%, var(--automation) 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }
        
        .btn-generic-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(125, 73, 204, 0.4);
        }
        
        /* Section CTA Container */
        .section-cta-container {
            text-align: center;
            margin-top: 50px;
            padding-top: 40px;
        }
        
        .section-cta-three-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 900px;
            margin: 40px auto 0;
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
        
        /* Micro Animations */
        .hero-cta-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .hero-cta-card.marketing {
            animation-delay: 0.1s;
        }
        
        .hero-cta-card.development {
            animation-delay: 0.2s;
        }
        
        .hero-cta-card.automation {
            animation-delay: 0.3s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        /* Ensure cards stay visible after animation */
        .hero-cta-card.animation-complete,
        .hero-cta-card:hover {
            opacity: 1 !important;
        }
        
        .column-card {
            opacity: 0;
            animation: fadeInScale 0.6s ease forwards;
        }
        
        .column-card.marketing {
            animation-delay: 0.1s;
        }
        
        .column-card.development {
            animation-delay: 0.2s;
        }
        
        .column-card.automation {
            animation-delay: 0.3s;
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Smooth hover transitions - using transform instead of animation to avoid conflicts */
        .hero-cta-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            opacity: 1;
        }
        
        .column-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .column-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes pulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(125, 73, 204, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 8px rgba(125, 73, 204, 0);
            }
        }
        
        .btn-hero-cta,
        .btn-final-cta {
            position: relative;
        }
        
        /* Development buttons: pulse effect always on (like specific pages) */
        .btn-hero-cta.development,
        .btn-final-cta.development {
            animation: pulse 2s infinite;
        }
        
        .btn-hero-cta.development:hover,
        .btn-final-cta.development:hover {
            box-shadow: none; /* Remove static shadow, pulse animation provides the effect */
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .hero-ctas,
            .three-columns,
            .final-cta-buttons,
            .section-cta-three-buttons {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .hero-cta-card.development,
            .column-card.development {
                transform: scale(1);
                order: 2;
            }
            
            .hero-cta-card.marketing,
            .column-card.marketing {
                order: 1;
            }
            
            .hero-cta-card.automation,
            .column-card.automation {
                order: 3;
            }
            
            .proof-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.5rem;
            }
            
            .hero-text .subheadline {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .hero-cta-card,
            .column-card {
                padding: 25px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .final-cta h2 {
                font-size: 2rem;
            }

            .hero-cta-card.development {
                margin-top: 0;
                padding: 25px;
                min-height: auto;
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
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Choose Your Service</h1>
                    <p class="subheadline">Professional solutions tailored to your business needs. Select the service that best fits your goals.</p>
                </div>
                
                <div class="hero-ctas">
                    <!-- Marketing CTA -->
                    <div class="hero-cta-card marketing">
                        <h3>Marketing Strategy</h3>
                        <p>Transform your marketing from chaotic and ineffective to strategic and profitable. Get proven strategies that generate qualified leads and convert visitors into customers.</p>
                        <a href="/marketing" class="btn-hero-cta marketing">Get Started</a>
                    </div>
                    
                    <!-- Software Development CTA (Featured) -->
                    <div class="hero-cta-card development">
                        <h3>Software Development</h3>
                        <p>Need your software project developed? I build it for you. Professional software development services with clean code, scalable architecture, and production-ready solutions.</p>
                        <a href="/software-development" class="btn-hero-cta development">Get a Quote</a>
                    </div>
                    
                    <!-- Business Automation CTA -->
                    <div class="hero-cta-card automation">
                        <h3>Business Automation</h3>
                        <p>Stop wasting hours on manual tasks. Transform repetitive work into automated systems. Save 10+ hours per week and focus on what truly grows your business.</p>
                        <a href="/automation" class="btn-hero-cta automation">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pain Points Section (Dor + Identificação) -->
    <section class="section pain-points" id="pain-points">
        <div class="container">
            <h2 class="section-title">Common Problems You Might Be Facing</h2>
            <p class="section-subtitle">These are the issues that prevent businesses from reaching their full potential. Each service addresses different challenges.</p>
            
            <div class="three-columns">
                <!-- Marketing Problems -->
                <div class="column-card marketing">
                    <h3>Marketing</h3>
                    <ul>
                        <li>No clear marketing strategy</li>
                        <li>Limited budget competing with big brands</li>
                        <li>Content gets no engagement</li>
                        <li>Inconsistent social media presence</li>
                        <li>Can't measure what works</li>
                        <li>Wrong leads, no conversions</li>
                    </ul>
                </div>
                
                <!-- Development Problems -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <ul>
                        <li>Wrong technology choice</li>
                        <li>Poor architecture</li>
                        <li>Security vulnerabilities</li>
                        <li>Performance issues</li>
                        <li>Brittle integrations</li>
                        <li>No testing</li>
                    </ul>
                </div>
                
                <!-- Automation Problems -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <ul>
                        <li>Lack of time for important tasks</li>
                        <li>Slow response times to leads</li>
                        <li>Cold leads that don't convert</li>
                        <li>Late payments and invoicing issues</li>
                        <li>Inconsistent marketing</li>
                        <li>Scheduling chaos</li>
                    </ul>
                </div>
            </div>
            
            <div class="section-cta-container">
                <a href="#hero" class="btn-generic-cta">Get Started Today</a>
            </div>
        </div>
    </section>
    
    <!-- Transformation Section (Antes e Depois) -->
    <section class="section transformation" id="transformation">
        <div class="container">
            <h2 class="section-title">The Transformation</h2>
            <p class="section-subtitle">See the difference between struggling with these challenges and having the right solution in place.</p>
            
            <div class="three-columns">
                <!-- Marketing Transformation -->
                <div class="column-card marketing">
                    <h3>Marketing</h3>
                    <p style="margin-bottom: 20px;"><strong style="color: #ff6b6b;">Before:</strong></p>
                    <ul>
                        <li>Random posting without a plan</li>
                        <li>Wasting money on non-converting ads</li>
                        <li>No idea which strategies work</li>
                        <li>Attracting leads that never buy</li>
                    </ul>
                    <p style="margin: 30px 0 20px 0;"><strong style="color: var(--marketing);">After:</strong></p>
                    <ul>
                        <li class="after">Clear strategy with measurable goals</li>
                        <li class="after">Organic strategies for any budget</li>
                        <li class="after">Data-driven decisions with real metrics</li>
                        <li class="after">Qualified leads that convert</li>
                    </ul>
                </div>
                
                <!-- Development Transformation -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <p style="margin-bottom: 20px;"><strong style="color: #ff6b6b;">Before:</strong></p>
                    <ul>
                        <li>Poor architecture hard to maintain</li>
                        <li>Performance issues from day one</li>
                        <li>Security vulnerabilities built in</li>
                        <li>Brittle integrations that break</li>
                    </ul>
                    <p style="margin: 30px 0 20px 0;"><strong style="color: var(--development);">After:</strong></p>
                    <ul>
                        <li class="after">Clean architecture for growth</li>
                        <li class="after">Optimized performance from start</li>
                        <li class="after">Security best practices built in</li>
                        <li class="after">Robust integrations with error handling</li>
                    </ul>
                </div>
                
                <!-- Automation Transformation -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <p style="margin-bottom: 20px;"><strong style="color: #ff6b6b;">Before:</strong></p>
                    <ul>
                        <li>3+ hours daily on repetitive tasks</li>
                        <li>Leads waiting hours or days</li>
                        <li>Missing follow-ups and losing clients</li>
                        <li>Manual invoicing and payment tracking</li>
                    </ul>
                    <p style="margin: 30px 0 20px 0;"><strong style="color: var(--automation);">After:</strong></p>
                    <ul>
                        <li class="after">10+ hours saved weekly on tasks</li>
                        <li class="after">Instant responses to leads 24/7</li>
                        <li class="after">Never miss follow-ups with automation</li>
                        <li class="after">Automated invoicing and reminders</li>
                    </ul>
                </div>
            </div>
            
            <div class="section-cta-container">
                <a href="#hero" class="btn-generic-cta">Start Your Transformation</a>
            </div>
        </div>
    </section>
    
    <!-- Solution Section -->
    <section class="section solution" id="solution">
        <div class="container">
            <h2 class="section-title">The Solution</h2>
            <p class="section-subtitle">Each service provides a comprehensive solution to address your specific challenges.</p>
            
            <div class="three-columns">
                <!-- Marketing Solution -->
                <div class="column-card marketing">
                    <h3>Marketing Strategy</h3>
                    <p>I've helped dozens of small businesses transform their marketing from chaotic and ineffective to strategic and profitable. The secret isn't having a huge budget—it's having the right strategy, the right systems, and the right approach.</p>
                    <p>Through years of testing, analyzing, and optimizing marketing campaigns, I've identified the exact strategies that generate qualified leads and convert visitors into customers—even when you're competing with bigger brands.</p>
                    <a href="/marketing" class="btn-final-cta marketing">Transform Your Marketing</a>
                </div>
                
                <!-- Development Solution -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <p>I'm a software developer who builds your project. When you hire me, I develop your application from start to finish: architecture, coding, testing, deployment, and documentation.</p>
                    <p>I've built software and APIs for clients across different industries (including governments). I choose the right technology stack, design scalable architecture, write clean code, implement security best practices, and set up professional deployment pipelines.</p>
                    <p>You get a working application that's production-ready, maintainable, and built to scale.</p>
                    <a href="/software-development" class="btn-final-cta development">Get a Development Quote</a>
                </div>
                
                <!-- Automation Solution -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <p>Business automation isn't about replacing you—it's about freeing you to focus on what matters most. With the right strategies, you can automate lead responses, payment reminders, content scheduling, and more.</p>
                    <p>All of this is possible with tools you probably already use—no coding required. Simple automation strategies can transform your business operations and save you hours every week.</p>
                    <a href="/automation" class="btn-final-cta automation">Start Automating Now</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="section benefits" id="benefits">
        <div class="container">
            <h2 class="section-title">What You'll Get</h2>
            <p class="section-subtitle">Direct benefits you'll experience with each service.</p>
            
            <div class="three-columns">
                <!-- Marketing Benefits -->
                <div class="column-card marketing">
                    <h3>Marketing</h3>
                    <div class="benefit-item">
                        <h4>Clear Strategy</h4>
                        <p>A step-by-step marketing plan with defined goals, priorities, and a roadmap of actions.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Budget-Friendly Tactics</h4>
                        <p>Organic marketing strategies and low-cost tactics with high ROI.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Qualified Leads</h4>
                        <p>Strategies to attract and qualify leads that match your ideal customer profile.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Measurable Results</h4>
                        <p>Simple dashboards and essential KPIs so you know exactly what's working.</p>
                    </div>
                </div>
                
                <!-- Development Benefits -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <div class="benefit-item">
                        <h4>Working Application</h4>
                        <p>A fully functional application that works. Not prototypes or demos—a real, production-ready system.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Clean, Scalable Code</h4>
                        <p>Clean, well-structured code with proper architecture. Your codebase is maintainable and extensible.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Security Built In</h4>
                        <p>Security best practices throughout: authentication, authorization, data validation, and protection.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Complete Documentation</h4>
                        <p>I document setup, deployment, API endpoints, and code structure for easy maintenance.</p>
                    </div>
                </div>
                
                <!-- Automation Benefits -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <div class="benefit-item">
                        <h4>Save 10+ Hours Weekly</h4>
                        <p>Reclaim your time by automating repetitive tasks. Focus on growth instead of maintenance.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>3x Faster Lead Response</h4>
                        <p>Respond to leads instantly with automated sequences. Never lose a potential client.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>85% Less Manual Work</h4>
                        <p>Eliminate manual data entry, repetitive tasks, and time-consuming processes.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Consistent Marketing</h4>
                        <p>Maintain a professional online presence with automated content scheduling.</p>
                    </div>
                </div>
            </div>
            
            <div class="section-cta-container">
                <a href="#hero" class="btn-generic-cta">Get These Benefits</a>
            </div>
        </div>
    </section>
    
    <!-- Social Proof Section -->
    <section class="section social-proof" id="social-proof">
        <div class="container">
            <h2 class="section-title">Results You Can Achieve</h2>
            <p class="section-subtitle">These are realistic outcomes when you work with the right professional.</p>
            
            <div class="three-columns">
                <!-- Marketing Proof -->
                <div class="column-card marketing">
                    <h3>Marketing</h3>
                    <div class="proof-grid">
                        <div class="proof-item">
                            <div class="proof-number">10x</div>
                            <div class="proof-label">Average<br>ROI<br>Increase</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">85%</div>
                            <div class="proof-label">Lead<br>Quality<br>Improvement</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">3x</div>
                            <div class="proof-label">Conversion<br>Rate<br>Increase</div>
                        </div>
                    </div>
                </div>
                
                <!-- Development Proof -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <div class="proof-grid">
                        <div class="proof-item">
                            <div class="proof-number">5x</div>
                            <div class="proof-label">Faster<br>Launch<br>Time</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">80%</div>
                            <div class="proof-label">Fewer<br>Production<br>Bugs</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">3x</div>
                            <div class="proof-label">Easier<br>to<br>Maintain</div>
                        </div>
                    </div>
                </div>
                
                <!-- Automation Proof -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <div class="proof-grid">
                        <div class="proof-item">
                            <div class="proof-number">10+</div>
                            <div class="proof-label">Hours<br>Saved Per<br>Week</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">3x</div>
                            <div class="proof-label">Faster<br>Lead<br>Response</div>
                        </div>
                        <div class="proof-item">
                            <div class="proof-number">85%</div>
                            <div class="proof-label">Reduction in<br>Manual<br>Tasks</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section-cta-container">
                <a href="#hero" class="btn-generic-cta">Achieve These Results</a>
            </div>
        </div>
    </section>
    
    <!-- Author Section -->
    <section class="section author" id="author">
        <div class="container">
            <h2 class="section-title">Who Am I</h2>
            
            <div class="author-image-container">
                <div class="author-image">
                    <img src="img/rogerio-pereira.png" alt="Rogerio Pereira - Professional Services">
                </div>
            </div>
            
            <p class="section-subtitle">Let me introduce myself and why I'm passionate about helping you succeed.</p>
            
            <div class="three-columns">
                <!-- Marketing Author -->
                <div class="column-card marketing">
                    <h3>Marketing</h3>
                    <p>I'm someone who's been where you are—trying different marketing tactics, spending money on things that didn't work, and feeling frustrated when nothing seemed to stick.</p>
                    <p>After stepping away from marketing for a while, I'm coming back with a fresh perspective and a focus on what actually works—not the complicated theories, but the simple, practical approaches that get results.</p>
                    <a href="/marketing" class="btn-final-cta marketing">Get Marketing Help</a>
                </div>
                
                <!-- Development Author -->
                <div class="column-card development">
                    <h3>Software Development</h3>
                    <p>I'm a software developer who builds custom software applications for clients. I've developed software and APIs across different industries (including governments).</p>
                    <p>When you hire me, I will develop your entire application end-to-end: I choose the tech stack, design the architecture, write the code, implement features, set up testing, configure deployment, and deliver documentation.</p>
                    <a href="/software-development" class="btn-final-cta development">Build Your Software</a>
                </div>
                
                <!-- Automation Author -->
                <div class="column-card automation">
                    <h3>Business Automation</h3>
                    <p>I know exactly what it feels like to be overwhelmed by manual tasks, drowning in repetitive work, and watching potential clients slip away because I simply couldn't respond fast enough.</p>
                    <p>That's why I dedicated years to mastering business automation. The strategies I share aren't theoretical—they're practical solutions I've tested and refined.</p>
                    <a href="/automation" class="btn-final-cta automation">Automate Your Business</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Final CTA Section -->
    <section class="final-cta" id="final-cta">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p>Choose the service that best fits your needs and take the first step toward transforming your business.</p>
            
            <div class="final-cta-buttons">
                <a href="/marketing" class="btn-final-cta marketing">Marketing Strategy</a>
                <a href="/software-development" class="btn-final-cta development">Software Development</a>
                <a href="/automation" class="btn-final-cta automation">Business Automation</a>
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
