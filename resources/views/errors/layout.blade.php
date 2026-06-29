<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title') - Punish System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --accent: #ec4899;
            --bg-color: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html, body {
            height: 100%;
            height: 100dvh;
        }

        body {
            background-color: var(--bg-color);
            background-image:
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0.3) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339,49%,30%,0.3) 0, transparent 50%);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            overflow: hidden;
            position: relative;
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
            padding-left: env(safe-area-inset-left);
            padding-right: env(safe-area-inset-right);
        }

        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        .blob-1 {
            width: 200px;
            height: 200px;
            background: rgba(79, 70, 229, 0.4);
            top: 10%;
            left: 20%;
        }

        .blob-2 {
            width: 250px;
            height: 250px;
            background: rgba(236, 72, 153, 0.3);
            bottom: 10%;
            right: 15%;
            animation-delay: -5s;
        }

        .error-container {
            position: relative;
            z-index: 10;
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 32px 24px;
            text-align: center;
            max-width: 520px;
            width: calc(90% - env(safe-area-inset-left) - env(safe-area-inset-right));
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(40px);
        }

        .error-code {
            font-size: clamp(64px, 15vw, 120px);
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(to right, #818cf8, #c084fc, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -4px;
            position: relative;
            display: inline-block;
            text-shadow: 0 0 40px rgba(139, 92, 246, 0.3);
        }

        .error-title {
            font-size: clamp(20px, 5vw, 28px);
            font-weight: 700;
            margin-bottom: 16px;
            color: #f1f5f9;
        }

        .error-message {
            font-size: clamp(14px, 3.5vw, 16px);
            color: var(--text-muted);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            text-decoration: none;
            border-radius: 9999px;
            font-weight: 600;
            font-size: clamp(13px, 3.5vw, 15px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(79, 70, 229, 0.8);
        }

        .btn-home:hover::before {
            opacity: 1;
        }

        .btn-home svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .btn-home:hover svg {
            transform: translateX(-4px);
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .blob-1 { width: 140px; height: 140px; }
            .blob-2 { width: 180px; height: 180px; }
            .error-container {
                padding: 28px 20px;
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="error-container">
        <div class="error-code">@yield('code')</div>
        <h1 class="error-title">@yield('heading')</h1>
        <p class="error-message">@yield('message')</p>

        <a href="{{ url('/') }}" class="btn-home">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
