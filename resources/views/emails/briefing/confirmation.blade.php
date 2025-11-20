<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Received Your Project Briefing</title>
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
        
        .status-box {
            background-color: #05080D;
            border-left: 4px solid #7D49CC;
            padding: 25px;
            margin: 30px 0;
            border-radius: 4px;
        }
        
        .status-box h2 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 20px;
            color: #7D49CC;
            margin-bottom: 15px;
        }
        
        .status-box p {
            color: #6B8A99;
            font-size: 15px;
            line-height: 1.7;
        }
        
        .next-steps {
            background-color: #05080D;
            border: 1px solid #2E4959;
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
        }
        
        .next-steps h2 {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            font-size: 22px;
            color: #7D49CC;
            margin-bottom: 20px;
        }
        
        .next-steps ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .next-steps li {
            color: #6B8A99;
            font-size: 15px;
            padding: 10px 0;
            padding-left: 25px;
            position: relative;
            line-height: 1.7;
        }
        
        .next-steps li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: #7D49CC;
            font-weight: bold;
            font-family: 'Share Tech Mono', 'Courier New', monospace;
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
                <div class="greeting">Hi {{ $briefing->name }},</div>
                
                <h1>We Received Your Project Briefing</h1>
                
                <p class="intro">Thank you for submitting your detailed project briefing. We've received all the information about your software project and are currently analyzing your requirements.</p>
                
                <div class="status-box">
                    <h2>Current Status</h2>
                    <p>Your briefing is now in our analysis queue. Our team is reviewing your project requirements, technical needs, and business goals to provide you with a comprehensive assessment.</p>
                </div>
                
                <div class="next-steps">
                    <h2>What Happens Next?</h2>
                    <ul>
                        <li><strong>Analysis Phase:</strong> We're reviewing your project requirements, technical specifications, and business objectives</li>
                        <li><strong>Technical Assessment:</strong> We'll evaluate the feasibility, recommend the best technology stack, and identify potential challenges</li>
                        <li><strong>Architecture Planning:</strong> We'll design a scalable architecture that meets your current needs and future growth</li>
                        <li><strong>Detailed Response:</strong> You'll receive a comprehensive assessment with technical recommendations, timeline estimates, and a detailed quote</li>
                        <li><strong>Follow-up Call:</strong> We'll schedule a call to discuss your project in detail and answer any questions you may have</li>
                    </ul>
                </div>
                
                <p style="color: #6B8A99; font-size: 16px; margin-top: 30px; line-height: 1.8;">We typically respond to briefings within 2-3 business days. If you have any urgent questions or need to provide additional information, please don't hesitate to reach out.</p>
                
                <p style="margin-top: 30px; color: #6B8A99;">
                    Best regards,<br>
                    <strong style="color: #7D49CC;">Rogerio Pereira</strong><br>
                    <span style="color: #B4C0C6; font-size: 14px;">Software Development Specialist</span>
                </p>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>&copy; 2025 Rogerio Pereira. All rights reserved.</p>
                <p><a href="{{ route('software-development') }}">Visit Our Software Development Page</a></p>
            </div>
        </div>
    </div>
</body>
</html>


