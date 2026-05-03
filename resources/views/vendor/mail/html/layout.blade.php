<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presento - Vérification email</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            padding: 32px;
            text-align: center;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 8px 20px;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            color: #4f46e5;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        
        .content {
            padding: 40px 32px;
        }
        
        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 24px;
        }
        
        .message {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            color: white !important;
            text-decoration: none;
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            margin: 16px 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .features {
            background: #f3f4f6;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .feature-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            padding: 24px 32px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">
                    <div class="logo-icon">P</div>
                    <div class="logo-text">presento</div>
                </div>
            </div>
            
            <div class="content">
                {{ $slot }}
            </div>
            
            <div class="footer">
                <p>© 2026 presento. Tous droits réservés.</p>
                <p>
                    <a href="{{ config('app.url') }}">presento.fr</a> • 
                    <a href="#">Mentions légales</a> • 
                    <a href="#">Confidentialité</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>