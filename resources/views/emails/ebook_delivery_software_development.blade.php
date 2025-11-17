<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your E-book: {{ $ebookName }}</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; font-family: 'IBM Plex Sans', Arial, sans-serif; font-weight: 400; background-color: #05080D; color: #6B8A99; line-height: 1.6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #05080D;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #111826; border-radius: 12px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #111826; padding: 30px 40px; border-bottom: 1px solid #2E4959;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td>
                                        <h1 style="margin: 0; font-family: 'Share Tech Mono', monospace; font-size: 24px; color: #7D49CC;">Rogerio Pereira</h1>
                                    </td>
                                    <td align="right">
                                        <p style="margin: 0; font-family: 'Share Tech Mono', monospace; font-size: 16px; color: rgba(125, 73, 204, 0.7);">Software Development</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 60px 40px; background: linear-gradient(135deg, #05080D 0%, #111826 100%);">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding-bottom: 40px;">
                                        <div style="width: 120px; height: 120px; background: rgba(125, 73, 204, 0.1); border-radius: 50%; display: inline-block; border: 3px solid #7D49CC; text-align: center; line-height: 120px;">
                                            <span style="font-size: 60px;">✓</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 20px;">
                                        <h1 style="margin: 0; font-family: 'Share Tech Mono', monospace; font-size: 36px; color: #ffffff; line-height: 1.2; background: linear-gradient(135deg, #ffffff 0%, #7D49CC 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Thank You!</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 30px;">
                                        <p style="margin: 0; font-size: 20px; color: #B4C0C6; font-weight: 400;">Your e-book: <strong style="color: #ffffff;">{{ $ebookName }}</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 30px;">
                                        <p style="margin: 0; font-size: 16px; color: #6B8A99; line-height: 1.8;">Thank you for purchasing <strong style="color: #ffffff;">{{ $ebookName }}</strong>. Click the button below to download your e-book and start implementing the development strategies right away.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 30px 0;">
                                        <a href="{{ $downloadUrl }}?hash={{ $hashPlaceholder }}" style="display: inline-block; background-color: #7D49CC; color: #ffffff; padding: 14px 40px; text-decoration: none; border-radius: 6px; font-family: 'Share Tech Mono', monospace; font-size: 16px;">Download E-book</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #111826; padding: 30px; border-radius: 12px; border: 1px solid #2E4959; margin-top: 40px;">
                                        <h3 style="margin: 0 0 15px 0; font-family: 'Share Tech Mono', monospace; font-size: 20px; color: #ffffff;">Need Help?</h3>
                                        <p style="margin: 0; font-size: 14px; color: #6B8A99; line-height: 1.6;">If you have any questions about your purchase or need assistance, please don't hesitate to contact us.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #05080D; padding: 30px 40px; text-align: center; border-top: 1px solid #2E4959;">
                            <p style="margin: 0; font-size: 14px; color: #B4C0C6;">&copy; 2025 Rogerio Pereira. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

