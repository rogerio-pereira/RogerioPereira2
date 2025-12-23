<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.tracking-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Automation - Rogerio Pereira - Stop Wasting Time on Manual Tasks</title>
    <meta name="description" content="Transform your business with practical automation solutions. Save hours daily, respond faster to leads, and scale your operations effortlessly.">
    
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
        
        /* Hero Section */
        .hero {
            padding: 80px 0 60px;
            background: linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .hero-text h1 {
            font-family: var(--font-title);
            font-size: 48px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-text .subheadline {
            font-size: 20px;
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .hero-text .benefits-list {
            list-style: none;
            margin: 30px 0;
        }
        
        .hero-text .benefits-list li {
            padding: 12px 0;
            padding-left: 30px;
            position: relative;
            color: var(--text-primary);
            font-size: 16px;
        }
        
        .hero-text .benefits-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
            font-size: 20px;
        }
        
        /* Form Section */
        .form-container {
            background-color: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .form-container h2 {
            font-family: var(--font-title);
            font-size: 28px;
            color: #ffffff;
            margin-bottom: 10px;
        }
        
        .form-container p {
            color: var(--text-secondary);
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--bg-primary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            color: #ffffff;
            font-family: var(--font-base);
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .form-group input::placeholder {
            color: var(--text-secondary);
        }
        
        .btn-primary {
            width: 100%;
            padding: 16px;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: var(--font-title);
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 191, 179, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .privacy-note {
            font-size: 12px;
            color: var(--text-secondary);
            text-align: center;
            margin-top: 15px;
        }
        
        /* Section Styles */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-family: var(--font-title);
            font-size: 36px;
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 18px;
            margin-bottom: 50px;
            max-width: 770px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Problems Section (Dor + Identificação) */
        .problems {
            background-color: var(--bg-secondary);
        }
        
        .problems-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .problem-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 30px;
            transition: transform 0.3s, border-color 0.3s;
        }
        
        .problem-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }
        
        .problem-card h3 {
            font-family: var(--font-title);
            font-size: 20px;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .problem-card p {
            color: var(--text-primary);
            font-size: 15px;
            line-height: 1.6;
        }
        
        /* Transformation Section (Antes e Depois) */
        .transformation {
            background-color: var(--bg-primary);
        }
        
        .transformation-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 50px;
        }
        
        .before-after-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 40px;
        }
        
        .before-after-card h3 {
            font-family: var(--font-title);
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .before-after-card.before h3 {
            color: #ff6b6b;
        }
        
        .before-after-card.after h3 {
            color: var(--primary);
        }
        
        .before-after-card ul {
            list-style: none;
            margin-top: 20px;
        }
        
        .before-after-card li {
            padding: 10px 0;
            padding-left: 25px;
            position: relative;
            color: var(--text-primary);
            font-size: 16px;
        }
        
        .before-after-card.before li:before {
            content: "×";
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-size: 20px;
            font-weight: bold;
        }
        
        .before-after-card.after li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--primary);
            font-size: 20px;
            font-weight: bold;
        }
        
        /* Solution Section */
        .solution {
            background-color: var(--bg-secondary);
        }
        
        .solution-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            margin-top: 50px;
        }
        
        .solution-text h2 {
            font-family: var(--font-title);
            font-size: 36px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .solution-text p {
            color: var(--text-primary);
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        /* Benefits Section */
        .benefits {
            background-color: var(--bg-primary);
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .benefit-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s, border-color 0.3s;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }
        
        .benefit-card .benefit-icon {
            width: 80px;
            height: 80px;
            background-color: var(--bg-tertiary);
            border-radius: 12px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            transition: transform 0.3s, background-color 0.3s;
        }
        
        .benefit-card:hover .benefit-icon {
            transform: scale(1.1);
            background-color: rgba(44, 191, 179, 0.1);
        }
        
        .benefit-card .benefit-icon svg {
            width: 40px;
            height: 40px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 2;
        }
        
        .benefit-card h3 {
            font-family: var(--font-title);
            font-size: 20px;
            color: #ffffff;
            margin-bottom: 15px;
        }
        
        .benefit-card p {
            color: var(--text-primary);
            font-size: 15px;
            line-height: 1.6;
        }
        
        /* Social Proof Section */
        .social-proof {
            background-color: var(--bg-secondary);
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }
        
        .stat-item {
            padding: 30px;
        }
        
        .stat-number {
            font-family: var(--font-title);
            font-size: 48px;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 16px;
        }
        
        /* Author Section (Quem Sou Eu) */
        .author {
            background-color: var(--bg-primary);
        }
        
        .author-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 60px;
            align-items: center;
            margin-top: 50px;
        }
        
        .author-image {
            background-color: var(--bg-secondary);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--bg-tertiary);
        }
        
        .author-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .author-text h2 {
            font-family: var(--font-title);
            font-size: 36px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .author-text p {
            color: var(--text-primary);
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        .author-credentials {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid var(--bg-tertiary);
        }
        
        .author-credentials h3 {
            font-family: var(--font-title);
            font-size: 20px;
            color: var(--primary);
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
            color: var(--primary);
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            text-align: center;
        }
        
        .cta-section h2 {
            font-family: var(--font-title);
            font-size: 42px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            color: var(--text-secondary);
            font-size: 20px;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-secondary {
            display: inline-block;
            padding: 18px 50px;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: var(--font-title);
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 191, 179, 0.4);
        }
        
        /* Section CTA (CTAs ao final de cada seção) */
        .section-cta {
            text-align: center;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px solid var(--bg-tertiary);
        }
        
        .btn-section-cta {
            display: inline-block;
            padding: 16px 40px;
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 8px;
            font-family: var(--font-title);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-section-cta:hover {
            background-color: var(--primary);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 191, 179, 0.3);
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
        .problem-card p,
        .benefit-card p,
        .author-text p {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        /* Micro Animations */
        .problem-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .problem-card:nth-child(1) { animation-delay: 0.1s; }
        .problem-card:nth-child(2) { animation-delay: 0.2s; }
        .problem-card:nth-child(3) { animation-delay: 0.3s; }
        .problem-card:nth-child(4) { animation-delay: 0.4s; }
        .problem-card:nth-child(5) { animation-delay: 0.5s; }
        .problem-card:nth-child(6) { animation-delay: 0.6s; }
        
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
        
        .benefit-card .benefit-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        .benefit-card:nth-child(2) .benefit-icon { animation-delay: 0.5s; }
        .benefit-card:nth-child(3) .benefit-icon { animation-delay: 1s; }
        .benefit-card:nth-child(4) .benefit-icon { animation-delay: 1.5s; }
        .benefit-card:nth-child(5) .benefit-icon { animation-delay: 2s; }
        .benefit-card:nth-child(6) .benefit-icon { animation-delay: 2.5s; }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(44, 191, 179, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(44, 191, 179, 0); }
        }
        
        .btn-primary {
            animation: pulse 2s infinite;
        }
        
        /* Z-Pattern Layout */
        .problem-card:nth-child(odd) {
            transform: translateX(-10px);
        }
        
        .problem-card:nth-child(even) {
            transform: translateX(10px);
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
            border-left: 4px solid var(--primary);
            position: relative;
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 60px;
            color: var(--primary);
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
            color: var(--primary);
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
            border-color: var(--primary);
            color: var(--primary);
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
            border-color: var(--primary);
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
            color: var(--primary);
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
            background: var(--primary);
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
        
        /* Responsive */
        @media (max-width: 968px) {
            .header-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .header-right {
                text-align: center;
            }
            
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .hero-text h1 {
                font-size: 36px;
            }
            
            .transformation-content {
                grid-template-columns: 1fr;
            }
            
            
            .author-content {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .cta-section h2 {
                font-size: 32px;
            }
        }
        
        @media (max-width: 640px) {
            .hero {
                padding: 40px 0 30px;
            }
            
            .hero-text h1 {
                font-size: 28px;
            }
            
            .hero-text .subheadline {
                font-size: 18px;
            }
            
            .form-container {
                padding: 30px 20px;
            }
            
            .problems-grid,
            .benefits-grid {
                grid-template-columns: 1fr;
            }
            
            .section {
                padding: 50px 0;
            }
            
            .section-title {
                font-size: 24px;
            }
            
            .cta-section {
                padding: 50px 0;
            }
            
            .cta-section h2 {
                font-size: 24px;
            }
            
            .problem-card:nth-child(odd),
            .problem-card:nth-child(even) {
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
    </style>
</head>
<body>
    @include('partials.tracking-body')
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="header-logo">Rogerio Pereira</div>
                <div class="header-right">Business Automation</div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>You're Spending Your Mornings Putting Out Fires Instead of Growing Your Business</h1>
                    <p class="subheadline">Stop wasting your mornings fighting with spreadsheets and manual tasks. Automate your repetitive work and get back 10+ hours every week to focus on what actually matters.</p>
                    
                    <ul class="benefits-list">
                        <li>Respond to leads instantly with automated sequences</li>
                        <li>Eliminate manual data entry and repetitive tasks</li>
                        <li>Never miss a follow-up or lose a lead again</li>
                        <li>Scale your operations without hiring more staff</li>
                    </ul>
                </div>
                
                <div class="form-container">
                    <h2>Get Your Free Guide</h2>
                    <p>Discover 10 automation strategies that will save you hours every week</p>
                    
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
                    
                    <form id="leadForm" action="{{ route('automation.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                placeholder="Enter your full name" 
                                required
                                value="{{ old('name') }}"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder="your.email@example.com" 
                                required
                                value="{{ old('email') }}"
                            >
                        </div>

                        <input
                            type='hidden'
                            name='captcha'
                            value=''
                        >
                        
                        <button type="submit" class="btn-primary">
                            Get My Free Guide Now
                        </button>
                    </form>
                    <p style="text-align: center; color: var(--text-secondary); font-size: 0.85rem; margin-top: 15px;">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dor + Identificação Section -->
    <section class="section problems">
        <div class="container">
            <h2 class="section-title">Are You Struggling With These Common Business Challenges?</h2>
            <p class="section-subtitle">If you're spending too much time on manual tasks, you're not alone. Here are the top problems automation solves:</p>
            
            <div class="problems-grid">
                <div class="problem-card">
                    <h3>Lack of Time</h3>
                    <p>Manual tasks drain your energy and prevent you from focusing on growth. You're stuck doing repetitive work instead of building your business.</p>
                </div>
                
                <div class="problem-card">
                    <h3>Slow Response Times</h3>
                    <p>Leads go cold because you can't respond fast enough. By the time you get back to them, they've already moved on to a competitor.</p>
                </div>
                
                <div class="problem-card">
                    <h3>Cold Leads</h3>
                    <p>Your communication doesn't resonate because it's not aligned with what leads actually need. They disengage before you can help them.</p>
                </div>
                
                <div class="problem-card">
                    <h3>Late Payments</h3>
                    <p>You forget to send invoices or follow up on payments. Revenue slips through the cracks because there's no organized system.</p>
                </div>
                
                <div class="problem-card">
                    <h3>Inconsistent Marketing</h3>
                    <p>You post sporadically when you "have time." This creates a perception of unprofessionalism and hurts your brand credibility.</p>
                </div>
                
                <div class="problem-card">
                    <h3>Scheduling Chaos</h3>
                    <p>Double bookings, missed appointments, and no-show clients. Your calendar is a mess and you're constantly putting out fires.</p>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Get Your Free Guide Now</a>
            </div>
        </div>
    </section>

    <!-- Transformação (Antes e Depois) Section -->
    <section class="section transformation">
        <div class="container">
            <h2 class="section-title">The Transformation: Before vs After Automation</h2>
            <p class="section-subtitle">See the dramatic difference automation makes in your daily operations</p>
            
            <div class="transformation-content">
                <div class="before-after-card before">
                    <h3>Before Automation</h3>
                    <p>Your business without automation is a constant struggle:</p>
                    <ul>
                        <li>Spending 3+ hours daily on repetitive tasks</li>
                        <li>Leads waiting hours or days for responses</li>
                        <li>Missing follow-ups and losing potential clients</li>
                        <li>Manual invoicing and payment tracking</li>
                        <li>Inconsistent social media presence</li>
                        <li>Calendar conflicts and missed appointments</li>
                        <li>No clear metrics or data to guide decisions</li>
                        <li>Everything depends on you being available</li>
                    </ul>
                </div>
                
                <div class="before-after-card after">
                    <h3>After Automation</h3>
                    <p>Your business with automation runs smoothly:</p>
                    <ul>
                        <li>10+ hours saved per week on manual tasks</li>
                        <li>Instant responses to leads 24/7</li>
                        <li>Never miss a follow-up with automated sequences</li>
                        <li>Automated invoicing and payment reminders</li>
                        <li>Consistent, scheduled social media content</li>
                        <li>Smart calendar management with confirmations</li>
                        <li>Clear dashboards showing key metrics</li>
                        <li>Systems that work even when you're not there</li>
                    </ul>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Start Your Transformation Today</a>
            </div>
        </div>
    </section>

    <!-- Apresentação da Solução Section -->
    <section class="section solution">
        <div class="container">
            <h2 class="section-title">The Solution: Practical Business Automation</h2>
            <p class="section-subtitle">You don't need complex systems or expensive software. Simple automation strategies can transform your business.</p>
            
            <div class="solution-content">
                <div class="solution-text">
                    <h2>How Business Automation Works</h2>
                    <p>Business automation isn't about replacing you—it's about freeing you to focus on what matters most. With the right strategies, you can:</p>
                    
                    <p style="margin-top: 20px;">Automate lead responses and follow-up sequences so you never lose a potential client. Set up payment reminders and invoice automation to ensure consistent cash flow. Create content calendars and social media scheduling to maintain a professional presence without the daily effort.</p>
                    
                    <p>Implement appointment booking with automatic confirmations to eliminate scheduling conflicts. Build simple dashboards to track your key metrics and make data-driven decisions. Standardize customer service with scripts and templates that ensure consistent quality.</p>
                    
                    <p style="margin-top: 30px; color: var(--primary); font-weight: 600;">All of this is possible with tools you probably already use—no coding required.</p>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Learn How to Automate Your Business</a>
            </div>
        </div>
    </section>

    <!-- Benefícios Diretos Section -->
    <section class="section benefits">
        <div class="container">
            <h2 class="section-title">Direct Benefits You'll Experience</h2>
            <p class="section-subtitle">These are the immediate results you can expect when you implement business automation</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3>Save 10+ Hours Weekly</h3>
                    <p>Reclaim your time by automating repetitive tasks. Focus on growth instead of maintenance.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                    </div>
                    <h3>3x Faster Lead Response</h3>
                    <p>Respond to leads instantly with automated sequences. Never lose a potential client to slow response times.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 1v6m0 6v6M5.64 5.64l4.24 4.24m4.24 4.24l4.24 4.24M1 12h6m6 0h6M5.64 18.36l4.24-4.24m4.24-4.24l4.24-4.24"/>
                        </svg>
                    </div>
                    <h3>85% Less Manual Work</h3>
                    <p>Eliminate manual data entry, repetitive tasks, and time-consuming processes. Let automation handle the routine work.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <h3>Never Miss a Payment</h3>
                    <p>Automated invoicing and payment reminders ensure consistent cash flow. No more forgotten invoices or late payments.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <line x1="18" y1="20" x2="18" y2="10"/>
                            <line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <h3>Consistent Marketing</h3>
                    <p>Maintain a professional online presence with automated content scheduling. Build credibility without daily effort.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="22 6 13.5 14.5 8.5 9.5 2 16"/>
                            <polyline points="16 6 22 6 22 12"/>
                        </svg>
                    </div>
                    <h3>Data-Driven Decisions</h3>
                    <p>Track key metrics with simple dashboards. Make informed decisions based on real data, not guesswork.</p>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Get Your Free Automation Guide</a>
            </div>
        </div>
    </section>

    <!-- Prova Social Section -->
    <section class="section social-proof">
        <div class="container">
            <h2 class="section-title">Join Business Owners Who've Transformed Their Operations</h2>
            <p class="section-subtitle">See how automation has helped others save time and scale their businesses</p>
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Hours Saved Per Week</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3x</div>
                    <div class="stat-label">Faster Lead Response</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">85%</div>
                    <div class="stat-label">Reduction in Manual Tasks</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Never Miss a Follow-up</div>
                </div>
            </div>
            
            <!-- Case Study - COMMENTED OUT (uncomment when you have case study data) -->
            <!--
            <div class="case-study">
                <div class="case-study-header">
                    <h3 class="case-study-title">Case Study: Service Business Automation</h3>
                    <div class="case-study-metrics">
                        <div class="metric-item">
                            <span class="metric-number">15+</span>
                            <span class="metric-label">Hours Saved</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">3x</span>
                            <span class="metric-label">Faster Response</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-number">90%</span>
                            <span class="metric-label">Less Manual Work</span>
                        </div>
                    </div>
                </div>
                <div class="case-study-content">
                    <p>A service business owner was spending 4 hours daily on manual tasks: responding to leads, sending invoices, scheduling appointments, and following up. After implementing automation workflows, they reduced manual work by 90%, respond to leads 3x faster, and saved 15+ hours per week. They now focus on growing the business instead of managing it.</p>
                </div>
            </div>
            -->
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Join These Successful Business Owners</a>
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
            <p class="section-subtitle">Real feedback from businesses that automated their operations.</p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">I was drowning in manual tasks. After automating our workflows, I got back 15 hours per week. Now I can actually focus on growing the business instead of just maintaining it.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Lisa Anderson</h4>
                            <p>Owner, Service Business</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">The automation system changed everything. We respond to leads instantly now, never miss a follow-up, and our invoicing is automatic. Best investment we made.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>James Wilson</h4>
                            <p>Founder, Consulting Firm</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">We went from chaotic manual processes to a smooth automated system. The time savings alone paid for the investment in the first month.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-author-info">
                            <h4>Maria Garcia</h4>
                            <p>CEO, Small Business</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section-cta" style="margin-top: 50px;">
                <a href="#leadForm" class="btn-section-cta">Get Your Free Automation Guide</a>
            </div>
        </div>
    </section>
    -->
    
    <!-- FAQ Section -->
    <section class="section faq" id="faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Get answers to common questions about business automation.</p>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How long does it take to set up automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Most automation workflows can be set up in 1-2 weeks. Simple automations (like email sequences) can be done in days, while complex systems may take 2-4 weeks. The timeline depends on your specific needs.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do I need technical skills to use automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>No. The automation tools I recommend are no-code or low-code, meaning you can set them up without programming knowledge. I provide step-by-step guidance for everything.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What tasks can be automated?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Common automations include: lead response sequences, email follow-ups, invoice generation, payment reminders, appointment scheduling, social media posting, data entry, and report generation. Almost any repetitive task can be automated.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How much money can automation save me?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Most businesses save 10-20 hours per week, which translates to significant cost savings. You also reduce errors, improve response times, and can scale without hiring more staff. ROI is typically seen within the first month.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Will automation replace my employees?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>No. Automation handles repetitive tasks, freeing your team to focus on high-value work like customer relationships, strategy, and growth. It makes your team more productive, not redundant.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What tools do you use for automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>I work with popular no-code tools like N8N, Mautic, ChatGPT (or similar), and others. Most of these tools are open-source, which means they're cost-effective and give you more control over your automation.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I automate my existing processes?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. You'll learn how to identify repetitive tasks and automate them step by step. The automation integrates with your existing tools and systems, so you don't need to change everything.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I know if automation is right for my business?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>If you spend more than 5 hours per week on repetitive tasks, automation will save you time and money. Common signs: manual data entry, repetitive emails, scheduling conflicts, missed follow-ups, or spending time on tasks that don't grow your business.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What if something goes wrong with the automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>You'll learn how to build error handling and monitoring into your automations to prevent issues. If something goes wrong, you can simply deactivate the automation while you fix it, so it won't cause problems in the meantime.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do I need to maintain the automation myself?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Once set up, most automations run on their own. I provide documentation so you understand how they work. You'll only need to adjust them if your processes change significantly.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can automation work with my CRM or other tools?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Many automation tools integrate with popular CRMs, email platforms, payment processors, and business tools. In the worst case scenario, most CRMs have an API which you can use to make API calls and connect your automation that way.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How much does automation cost?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Automation tools typically cost $20-100/month depending on usage. The time savings usually pay for the tools many times over. I help you choose cost-effective solutions that fit your budget.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Will automation make my business feel impersonal?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>No. Automation handles routine tasks, but you still maintain personal relationships. In fact, by automating repetitive work, you have more time for meaningful customer interactions and personalized service.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I start with just one automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely. I recommend starting with your biggest time-waster. Once you see the results, you can gradually add more automations. You don't need to automate everything at once.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What's the biggest mistake people make with automation?</span>
                        <div class="faq-icon"></div>
                    </div>
                    <div class="faq-answer">
                        <p>Trying to automate everything at once or automating processes that aren't working well manually. Start with one high-impact automation, get it working perfectly, then expand. Quality over quantity.</p>
                    </div>
                </div>
            </div>
            
            <div class="section-cta" style="margin-top: 50px;">
                <a href="#leadForm" class="btn-section-cta">Get Your Free Guide</a>
            </div>
        </div>
    </section>

    <!-- Quem Sou Eu (Autor) Section -->
    <section class="section author">
        <div class="container">
            <h2 class="section-title">Who Am I</h2>
            <p class="section-subtitle">Let me introduce myself and why I'm passionate about helping you automate your business</p>
            
            <div class="author-content">
                <div class="author-image">
                    <img src="img/rogerio-pereira-automation.jpg" alt="Rogerio Pereira - Business Automation Expert">
                </div>
                
                <div class="author-text">
                    <h2>I've Been Where You Are</h2>
                    <p>I know exactly what it feels like to be overwhelmed by manual tasks, drowning in repetitive work, and watching potential clients slip away because I simply couldn't respond fast enough. I've experienced the frustration of working 14-hour days only to realize I had accomplished very little that actually moved my business forward. The inevitable happened: I lost my first business in 2018 after 4 years of strugling, leaving me with a debt of BRL$40,000 (~$7,500 USD). My biggest mistakes were lack of proper tracking and inefficient marketing—mistakes that could have been prevented with the right automation systems.</p>
                    
                    <p>That's why I dedicated years to mastering business automation. Through my own journey, I've learned what works and what doesn't. I've successfully helped businesses transform their operations from chaotic and time-consuming to streamlined and efficient. The strategies I share aren't theoretical—they're practical solutions I've tested and refined.</p>
                    
                    <p>My mission is simple: help you reclaim your time, scale your business, and achieve the freedom you started your business for in the first place.</p>
                    
                    <div class="author-credentials">
                        <h3>What I Bring to the Table</h3>
                        <ul>
                            <li>Years of experience studying and implementing business automation</li>
                            <li>Hands-on experience helping businesses automate their operations</li>
                            <li>Deep understanding of no-code automation solutions</li>
                            <li>Practical knowledge of tools and strategies that actually work</li>
                            <li>Real-world insights from implementing automation in my own business</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="#leadForm" class="btn-section-cta">Get Started with My Free Guide</a>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="section cta-section">
        <div class="container">
            <h2>Ready to Automate Your Business?</h2>
            <p>Get started today with our free guide. Learn the exact automation strategies that will save you hours every week and transform how your business operates.</p>
            <a href="#leadForm" class="btn-secondary">Get My Free Guide Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Rogerio Pereira. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Smooth scroll to form
        document.querySelectorAll('a[href="#leadForm"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('leadForm').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
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
    </script>
</body>
</html>
