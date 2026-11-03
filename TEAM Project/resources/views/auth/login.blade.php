<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول - {{ config('app.name', 'لوحة التحكم الذكية') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Readex+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-page: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-focus-border: #6366f1;
            --input-focus-bg: #ffffff;
            --pill-bg: #f1f5f9;
            --pill-border: #e2e8f0;
            --pill-text: #334155;
            --pill-active-bg: rgba(99, 102, 241, 0.1);
            --pill-active-border: #6366f1;
            --pill-active-text: #4f46e5;
            --dark-panel-bg: #0f172a;
            --dark-panel-border: #1e293b;
        }

        .dark {
            --bg-page: #070b14;
            --card-bg: #0f172a;
            --card-border: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: #070b14;
            --input-border: #1e293b;
            --input-focus-border: #818cf8;
            --input-focus-bg: #0b1120;
            --pill-bg: #1e293b;
            --pill-border: #334155;
            --pill-text: #cbd5e1;
            --pill-active-bg: rgba(99, 102, 241, 0.22);
            --pill-active-border: #818cf8;
            --pill-active-text: #c7d2fe;
            --dark-panel-bg: #070b14;
            --dark-panel-border: #1e293b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', 'Readex Pro', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: background-color 0.3s ease;
        }

        /* Ambient Glow Blobs (Dashboard Sync) */
        .ambient-blob-1 {
            position: fixed;
            top: -140px;
            right: -140px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.18) 0%, rgba(99, 102, 241, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }
        .ambient-blob-2 {
            position: fixed;
            bottom: -140px;
            left: -140px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.14) 0%, rgba(168, 85, 247, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* Main Floating Card */
        .login-card-wrapper {
            width: 100%;
            max-width: 1000px;
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 30px 70px -15px rgba(15, 23, 42, 0.15), 0 0 1px 1px rgba(99, 102, 241, 0.05);
            display: flex;
            flex-direction: row;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        @media (max-width: 860px) {
            .login-card-wrapper {
                flex-direction: column;
                max-width: 480px;
                border-radius: 24px;
            }
        }

        /* Dark Left Sidebar Branding Panel */
        .dark-side-panel {
            width: 42%;
            background: linear-gradient(155deg, #0f172a 0%, #1e1b4b 60%, #090d16 100%) !important;
            border-right: 1px solid var(--dark-panel-border);
            padding: 42px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff !important;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 860px) {
            .dark-side-panel {
                width: 100%;
                border-right: none;
                border-top: 1px solid var(--dark-panel-border);
                padding: 30px 24px;
            }
        }

        .dark-side-panel * {
            color: #ffffff;
        }

        .side-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 11.5px;
            font-weight: 700;
            color: #c7d2fe !important;
            margin-bottom: 20px;
            width: fit-content;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 10px #10b981;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .side-hero-title {
            font-size: 26px;
            font-weight: 900;
            line-height: 1.35;
            color: #ffffff !important;
            margin-bottom: 8px;
            min-height: 72px;
            font-family: 'Readex Pro', sans-serif;
        }

        .side-hero-title-highlight {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 26px;
            font-weight: 900;
            display: inline;
            font-family: 'Readex Pro', sans-serif;
        }

        .typewriter-cursor {
            display: inline-block;
            width: 3.5px;
            height: 1.15em;
            background: #818cf8;
            vertical-align: middle;
            margin-right: 4px;
            border-radius: 2px;
            box-shadow: 0 0 10px #818cf8, 0 0 18px rgba(129, 140, 248, 0.7);
            animation: blink-cursor 0.8s infinite;
        }

        @keyframes blink-cursor {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .side-desc {
            font-size: 12px;
            color: #94a3b8 !important;
            line-height: 1.7;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
            transition: all 0.25s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
        }

        .feature-text-title {
            font-size: 12px;
            font-weight: 700;
            color: #f8fafc !important;
            margin-bottom: 2px;
        }

        .feature-text-sub {
            font-size: 10.5px;
            color: #94a3b8 !important;
            font-weight: 500;
        }

        .feature-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .feature-icon-users {
            background: linear-gradient(135deg, #06b6d4 0%, #2563eb 100%);
        }

        .feature-icon-roles {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
        }

        .feature-icon-backups {
            background: linear-gradient(135deg, #6366f1 0%, #9333ea 100%);
        }

        .side-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 16px;
            margin-top: 20px;
        }

        .side-footer-version {
            color: #c7d2fe !important;
            font-size: 11px;
            font-weight: 800;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            padding: 3px 10px;
            border-radius: 8px;
        }

        .side-footer-copy {
            color: #64748b !important;
            font-size: 11px;
            font-weight: 600;
        }

        /* Right Side Form Panel */
        .form-side-panel {
            width: 58%;
            padding: 38px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: var(--card-bg);
            transition: background-color 0.3s ease;
        }

        @media (max-width: 860px) {
            .form-side-panel {
                width: 100%;
                padding: 28px 20px;
            }
        }

        .form-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .form-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            border: 1px solid var(--card-border);
            background: var(--input-bg);
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .form-title-main {
            font-size: 21px;
            font-weight: 900;
            color: var(--text-main);
            line-height: 1.25;
        }

        .form-title-sub {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .theme-pill-btn {
            background-color: var(--pill-bg);
            border: 1px solid var(--pill-border);
            color: var(--pill-text);
            border-radius: 9999px;
            padding: 6px 14px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .theme-pill-btn:hover {
            background-color: var(--card-border);
            transform: translateY(-1px);
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .req-star {
            color: #ef4444;
            font-weight: 900;
        }

        .input-container {
            position: relative;
            width: 100%;
        }

        .form-input {
            width: 100%;
            border-radius: 14px;
            border: 1.5px solid var(--input-border);
            background-color: var(--input-bg);
            color: var(--text-main);
            font-size: 13px;
            font-weight: 600;
            padding: 12px 42px 12px 16px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--input-focus-border);
            background-color: var(--input-focus-bg);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .form-input::placeholder {
            color: var(--text-muted);
            font-weight: 500;
            opacity: 0.7;
        }

        .input-icon-right {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .toggle-password-btn:hover {
            color: var(--input-focus-border);
        }

        .password-mask {
            -webkit-text-security: disc !important;
            text-security: disc !important;
            letter-spacing: 2px;
        }
        .password-unmask {
            -webkit-text-security: none !important;
            text-security: none !important;
            letter-spacing: normal;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            cursor: pointer;
            user-select: none;
        }

        .custom-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: #6366f1;
            cursor: pointer;
        }

        .remember-text {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .remember-row:hover .remember-text {
            color: var(--text-main);
        }

        .submit-btn-primary {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #4338ca 100%) !important;
            color: #ffffff !important;
            border: none;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.45);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-family: 'Readex Pro', sans-serif;
        }

        .submit-btn-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 50%, #6366f1 100%) !important;
            box-shadow: 0 14px 30px -4px rgba(79, 70, 229, 0.55);
            transform: translateY(-1px) scale(1.01);
        }

        .submit-btn-primary:active {
            transform: scale(0.99);
        }

        .submit-btn-text {
            color: #ffffff !important;
            font-weight: 900;
            font-size: 15px;
            letter-spacing: 0.2px;
        }

        .submit-arrow-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .submit-btn-primary:hover .submit-arrow-circle {
            transform: translateX(-3px);
            background-color: rgba(255, 255, 255, 0.3) !important;
        }

        /* Demo Accounts Section */
        .demo-section-wrapper {
            border-top: 1px solid var(--card-border);
            padding-top: 18px;
            margin-top: 20px;
        }

        .demo-section-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .dark .demo-section-title {
            color: #818cf8;
        }

        .demo-pills-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .demo-chip {
            background-color: var(--pill-bg);
            border: 1px solid var(--pill-border);
            color: var(--pill-text);
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .demo-chip:hover {
            border-color: var(--pill-active-border);
            color: var(--pill-active-text);
            transform: translateY(-1px);
        }

        .demo-chip.active-chip {
            background-color: var(--pill-active-bg) !important;
            border: 1.5px solid var(--pill-active-border) !important;
            color: var(--pill-active-text) !important;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>

<body x-data="{ 
        isDark: localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : false, 
        showPassword: false,
        activeDemo: '',
        fillDemo(email, pass, roleKey) {
            this.activeDemo = roleKey;
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            if (emailInput) { 
                emailInput.value = email; 
                emailInput.focus();
            }
            if (passInput) { 
                passInput.value = pass; 
            }
        }
      }"
      x-init="$watch('isDark', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          if (val) {
              document.documentElement.classList.add('dark');
          } else {
              document.documentElement.classList.remove('dark');
          }
      });
      if (isDark) { document.documentElement.classList.add('dark'); }"
      :class="isDark ? 'dark' : ''">

    <!-- Ambient Glowing Blobs -->
    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <!-- Main Container Card (Dual Column) -->
    <div class="login-card-wrapper">

        <!-- ========================================================
             RIGHT COLUMN: Form Panel (نموذج تسجيل الدخول)
             ======================================================== -->
        <div class="form-side-panel">
            
            <div>
                <!-- Return to Home & Register Quick Links -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--card-border);">
                    <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: var(--text-muted); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>العودة للرئيسية</span>
                    </a>
                    <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 800; color: #4f46e5; text-decoration: none; padding: 4px 10px; border-radius: 8px; background: rgba(79, 70, 229, 0.08);">
                        <span>حساب جديد (فرق / شركات / استشارات) ←</span>
                    </a>
                </div>

                <!-- Top Header Row -->
                <div class="form-header-row">
                    <!-- Right: Logo and System Titles -->
                    <div class="form-title-group">
                        <div class="logo-box">
                            <img src="{{ asset('logo.png') }}" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%234f46e5\'><path d=\'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\'/></svg>';" alt="الشعار">
                        </div>
                        <div>
                            <h2 class="form-title-main">تسجيل الدخول للنظام</h2>
                            <p class="form-title-sub">أدخل بيانات حسابك للمتابعة والوصول للمنظومة</p>
                        </div>
                    </div>

                    <!-- Left: Theme Toggle Pill Button -->
                    <div>
                        <button type="button" @click="isDark = !isDark" id="themeToggleBtn" class="theme-pill-btn" title="تبديل الوضع">
                            <template x-if="!isDark">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.3 4.9c.4-.2.6-.7.5-1.1s-.6-.7-1-.5C6.4 4.8 2.5 9.4 2.5 15c0 6.4 5.2 11.5 11.5 11.5 5.6 0 10.2-3.9 11.7-9.3.1-.4-.1-.9-.5-1-.4-.2-.9 0-1.1.4-1.3 2.8-4.1 4.7-7.4 4.7-4.5 0-8.2-3.7-8.2-8.2 0-3.3 1.9-6.1 4.8-7.2z" />
                                    </svg>
                                    <span>الوضع الليلي</span>
                                </div>
                            </template>
                            <template x-if="isDark">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <svg width="14" height="14" fill="none" stroke="#f59e0b" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span style="color: #f59e0b;">الوضع النهاري</span>
                                </div>
                            </template>
                        </button>
                    </div>
                </div>

                <!-- Session Status Alerts -->
                <x-auth-session-status class="mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs font-bold text-emerald-600 dark:text-emerald-400" :status="session('status')" />

                <!-- Main Login Form -->
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <!-- Anti-Autofill Decoys -->
                    <input type="text" style="display:none !important; position:absolute !important; opacity:0 !important; width:0 !important; height:0 !important;" name="_prevent_autofill_user" tabindex="-1" autocomplete="off" aria-hidden="true" />
                    <input type="password" style="display:none !important; position:absolute !important; opacity:0 !important; width:0 !important; height:0 !important;" name="_prevent_autofill_pwd" tabindex="-1" autocomplete="new-password" aria-hidden="true" />

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            البريد الإلكتروني <span class="req-star">*</span>
                        </label>
                        <div class="input-container">
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                required autofocus placeholder="admin@gmail.com" autocomplete="off"
                                data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other"
                                class="form-input">
                            
                            <div class="input-icon-right">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            كلمة المرور <span class="req-star">*</span>
                        </label>
                        <div class="input-container">
                            <input id="password" type="text" name="password" required placeholder="••••••••"
                                autocomplete="off"
                                spellcheck="false"
                                autocorrect="off"
                                autocapitalize="off"
                                data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other"
                                :class="showPassword ? 'password-unmask' : 'password-mask'"
                                class="form-input" style="padding-left: 42px; padding-right: 42px;">
                            
                            <!-- Toggle Show / Hide Password Button -->
                            <button type="button" @click="showPassword = !showPassword" id="togglePasswordBtn" class="toggle-password-btn" title="إظهار / إخفاء كلمة المرور" tabindex="-1">
                                <svg x-show="!showPassword" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 013.682-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.692-4.692a3 3 0 00-4.243-4.243" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                </svg>
                            </button>

                            <!-- Lock Icon -->
                            <div class="input-icon-right">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-[11px] text-rose-500 font-bold" />
                    </div>

                    <!-- Remember Me Checkbox -->
                    <label class="remember-row">
                        <input type="checkbox" name="remember" class="custom-checkbox">
                        <span class="remember-text">تذكر الحساب على هذا الجهاز</span>
                    </label>

                    <!-- Submit Primary Action Button -->
                    <button type="submit" class="submit-btn-primary">
                        <span class="submit-btn-text">الدخول إلى المنظومة</span>
                        <div class="submit-arrow-circle">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </div>
                    </button>

                </form>
            </div>

            <!-- Demo Accounts 1-Click Selectors -->
            <div class="demo-section-wrapper">
                <div class="demo-section-title">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>حسابات تجريبية سريعة بنقرة واحدة:</span>
                </div>

                <div class="demo-pills-row">
                    <!-- Super Admin -->
                    <button type="button" @click="fillDemo('admin@gmail.com', 'admin123', 'admin')"
                        :class="activeDemo === 'admin' ? 'active-chip' : ''" class="demo-chip">
                        <span>👑</span>
                        <span>مدير النظام</span>
                    </button>

                    <!-- Manager -->
                    <button type="button" @click="fillDemo('manager@gmail.com', 'admin123', 'manager')"
                        :class="activeDemo === 'manager' ? 'active-chip' : ''" class="demo-chip">
                        <span>💼</span>
                        <span>مدير الإدارة</span>
                    </button>

                    <!-- User -->
                    <button type="button" @click="fillDemo('user@admin.com', 'password', 'user')"
                        :class="activeDemo === 'user' ? 'active-chip' : ''" class="demo-chip">
                        <span>👤</span>
                        <span>مستخدم النظام</span>
                    </button>

                    <!-- Viewer -->
                    <button type="button" @click="fillDemo('viewer@gmail.com', 'admin123', 'viewer')"
                        :class="activeDemo === 'viewer' ? 'active-chip' : ''" class="demo-chip">
                        <span>👁️</span>
                        <span>مستعرض فقط</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- ========================================================
             LEFT COLUMN: Dark Sidebar Branding Panel (اللوحة الداكنة)
             ======================================================== -->
        <div class="dark-side-panel">
            
            <!-- Top Branding -->
            <div>
                <div class="side-pill-badge">
                    <span class="status-dot"></span>
                    <span>لوحة التحكم والأنظمة الذكية</span>
                </div>

                <h1 class="side-hero-title">
                    لوحة التحكم المركزية <br/>
                    <span class="side-hero-title-highlight" id="typewriter-text">وإدارة المشاريع</span><span class="typewriter-cursor"></span>
                </h1>

                <p class="side-desc">
                    منظومة متكاملة وحديثة لإدارة المستخدمين، الأدوار والصلاحيات، القوائم المساعدة، والنسخ الاحتياطي وفق أعلى المعايير.
                </p>

                <!-- 3 Feature Cards -->
                <div class="feature-card">
                    <div class="feature-icon-box feature-icon-users">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="feature-text-title">إدارة المستخدمين ومصفوفة الصلاحيات</div>
                        <div class="feature-text-sub">تحكم دقيق بصلاحيات الأدوار وحسابات الموظفين</div>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box feature-icon-roles">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <div class="feature-text-title">مصفوفة الصلاحيات والحماية الفائقة</div>
                        <div class="feature-text-sub">نظام حماية وتصاريح متقدم (Spatie)</div>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box feature-icon-backups">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                    </div>
                    <div>
                        <div class="feature-text-title">النسخ الاحتياطي وسجلات التدقيق</div>
                        <div class="feature-text-sub">تأمين لقواعد البيانات ومراقبة فورية للنشاطات</div>
                    </div>
                </div>
            </div>

            <!-- Footer: Version & Copyright -->
            <div class="side-footer">
                <span class="side-footer-copy">جميع الحقوق محفوظة © {{ date('Y') }}</span>
                <span class="side-footer-version">v2026.1</span>
            </div>

        </div>

    </div>

    <!-- Typewriter Effect & Fallback script -->
    <script>
        (function() {
            const phrases = [
                "وإدارة المشاريع",
                "والأنظمة الذكية",
                "ومصفوفة الصلاحيات",
                "والنسخ الاحتياطي",
                "وسجلات الأمان والتدقيق"
            ];
            
            let phraseIndex = 0;
            let charIndex = phrases[0].length;
            let isDeleting = true;
            const typingSpeed = 110;
            const deletingSpeed = 55;
            const pauseFull = 2500;
            const pauseEmpty = 400;

            function runTypewriter() {
                const target = document.getElementById('typewriter-text');
                if (!target) return;

                const currentPhrase = phrases[phraseIndex];

                if (isDeleting) {
                    charIndex--;
                    target.textContent = currentPhrase.substring(0, charIndex);

                    if (charIndex <= 0) {
                        isDeleting = false;
                        phraseIndex = (phraseIndex + 1) % phrases.length;
                        setTimeout(runTypewriter, pauseEmpty);
                        return;
                    }
                    setTimeout(runTypewriter, deletingSpeed);
                } else {
                    charIndex++;
                    target.textContent = currentPhrase.substring(0, charIndex);

                    if (charIndex >= currentPhrase.length) {
                        isDeleting = true;
                        setTimeout(runTypewriter, pauseFull);
                        return;
                    }
                    setTimeout(runTypewriter, typingSpeed);
                }
            }

            setTimeout(runTypewriter, 2000);

            function clearPasswordOnLoad() {
                var passInput = document.getElementById('password');
                if (passInput && !passInput.value && document.activeElement !== passInput) {
                    passInput.value = '';
                }
            }
            window.addEventListener('DOMContentLoaded', clearPasswordOnLoad);

            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.Alpine === 'undefined') {
                    const themeBtn = document.getElementById('themeToggleBtn');
                    if (themeBtn) {
                        let isDark = localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : false;
                        function applyTheme() {
                            if (isDark) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        }
                        applyTheme();
                        themeBtn.addEventListener('click', function() {
                            isDark = !isDark;
                            localStorage.setItem('theme', isDark ? 'dark' : 'light');
                            applyTheme();
                        });
                    }

                    const passInput = document.getElementById('password');
                    const toggleBtn = document.getElementById('togglePasswordBtn');
                    if (passInput && toggleBtn) {
                        let show = false;
                        toggleBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            show = !show;
                            if (show) {
                                passInput.classList.remove('password-mask');
                                passInput.classList.add('password-unmask');
                            } else {
                                passInput.classList.remove('password-unmask');
                                passInput.classList.add('password-mask');
                            }
                        });
                    }
                }
            });
        })();
    </script>

</body>

</html>
