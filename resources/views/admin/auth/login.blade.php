<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | SubPilot</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e6e6fa 0%, #d8bfd8 50%, #dda0dd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(216, 191, 216, 0.4) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(221, 160, 221, 0.3) 0%, transparent 70%);
            bottom: -120px;
            left: -120px;
            border-radius: 50%;
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(138, 43, 226, 0.15);
            padding: 36px 32px;
            position: relative;
        }

        .visual-header {
            text-align: center;
            margin-bottom: 32px;
            position: relative;
        }

        .illustration {
            width: 140px;
            height: 100px;
            margin: 0 auto 20px;
            position: relative;
        }

        .illustration svg {
            width: 100%;
            height: 100%;
        }

        .logo-badge {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #ba55d3 0%, #9370db 100%);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 6px 20px rgba(186, 85, 211, 0.25);
        }

        .logo-badge svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .visual-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: #6b46c1;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .visual-header p {
            color: #9f7aea;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #805ad5;
            margin-bottom: 8px;
            font-size: 12px;
            letter-spacing: 0.2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #b794f4;
            pointer-events: none;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 1.5px solid rgba(159, 122, 234, 0.3);
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
            color: #553c9a;
            font-weight: 400;
        }

        .form-control::placeholder {
            color: #b794f4;
            font-size: 12px;
        }

        .form-control:focus {
            outline: none;
            border-color: #9f7aea;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.15);
        }

        .error-message {
            background: rgba(245, 101, 101, 0.1);
            border-left: 3px solid rgba(245, 101, 101, 0.5);
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            color: #c53030;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #ba55d3 0%, #9370db 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(186, 85, 211, 0.3);
            letter-spacing: 0.3px;
            margin-top: 6px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(186, 85, 211, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid rgba(159, 122, 234, 0.2);
        }

        .footer-text p {
            color: #9f7aea;
            font-size: 11px;
            letter-spacing: 0.2px;
        }

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

        .login-card {
            animation: fadeInUp 0.6s ease;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .logo-badge {
            animation: float 3s ease-in-out infinite;
        }

        /* Decorative elements */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(186, 85, 211, 0.1), rgba(147, 112, 219, 0.1));
        }

        .deco-circle-1 {
            width: 60px;
            height: 60px;
            top: -20px;
            right: -20px;
        }

        .deco-circle-2 {
            width: 40px;
            height: 40px;
            bottom: -10px;
            left: -10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="deco-circle deco-circle-1"></div>
            <div class="deco-circle deco-circle-2"></div>
            
            <div class="visual-header">
                <div class="illustration">
                    <svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Cloud-like background -->
                        <ellipse cx="100" cy="100" rx="80" ry="35" fill="#e6e6fa" opacity="0.4"/>
                        <ellipse cx="100" cy="95" rx="70" ry="30" fill="#d8bfd8" opacity="0.3"/>
                        
                        <!-- Dashboard screen -->
                        <rect x="45" y="40" width="110" height="70" rx="8" fill="url(#grad1)" stroke="#9370db" stroke-width="2"/>
                        <rect x="50" y="45" width="100" height="60" rx="4" fill="#f8f4ff"/>
                        
                        <!-- Dashboard elements -->
                        <rect x="58" y="52" width="30" height="4" rx="2" fill="#ba55d3" opacity="0.6"/>
                        <rect x="58" y="60" width="45" height="3" rx="1.5" fill="#d8bfd8"/>
                        <rect x="58" y="66" width="35" height="3" rx="1.5" fill="#d8bfd8"/>
                        
                        <circle cx="125" cy="62" r="12" fill="#e6e6fa" stroke="#ba55d3" stroke-width="2"/>
                        <path d="M125 56 L125 62 L130 62" stroke="#ba55d3" stroke-width="1.5" stroke-linecap="round"/>
                        
                        <!-- Bottom bars -->
                        <rect x="58" y="80" width="20" height="18" rx="2" fill="#dda0dd" opacity="0.5"/>
                        <rect x="82" y="88" width="20" height="10" rx="2" fill="#ba55d3" opacity="0.5"/>
                        <rect x="106" y="85" width="20" height="13" rx="2" fill="#9370db" opacity="0.5"/>
                        
                        <defs>
                            <linearGradient id="grad1" x1="45" y1="40" x2="155" y2="110" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#e6e6fa"/>
                                <stop offset="100%" stop-color="#d8bfd8"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                
                <div class="logo-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                
                <h3>SubPilot</h3>
                <p>Admin Access</p>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                
                @error('login')
                <div class="error-message">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </div>
                @enderror

                @error('access')
                <div class="error-message">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </div>
                @enderror

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button class="btn-login" type="submit">
                    Sign In
                </button>

                <div class="footer-text">
                    <p>© 2025 SubPilot</p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>