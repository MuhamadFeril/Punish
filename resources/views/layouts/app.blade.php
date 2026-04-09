<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Punish - Sistem Manajemen Pelanggaran' }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        
        <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { 
                    margin: 0; 
                    padding: 0; 
                    box-sizing: border-box; 
                }
                
                body { 
                    font-family: 'Inter', 'Instrument Sans', sans-serif; 
                    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                    background-attachment: fixed;
                    color: #1f2937; 
                    transition: all 0.3s ease;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                
                @keyframes slideInLeft {
                    from { opacity: 0; transform: translateX(-20px); }
                    to { opacity: 1; transform: translateX(0); }
                }
                
                @keyframes slideInRight {
                    from { opacity: 0; transform: translateX(20px); }
                    to { opacity: 1; transform: translateX(0); }
                }
                
                @keyframes pulse {
                    0%, 100% { opacity: 1; }
                    50% { opacity: 0.5; }
                }
                
                @keyframes bounce {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-5px); }
                }
                
                main { animation: fadeIn 0.5s ease; }
                
                .container { 
                    max-width: 1200px; 
                    margin: 0 auto; 
                    padding: 0 20px; 
                }
                
                .btn { 
                    padding: 10px 18px; 
                    border: none;
                    border-radius: 6px; 
                    cursor: pointer; 
                    text-decoration: none; 
                    display: inline-block; 
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    font-weight: 500;
                    font-size: 14px;
                }
                
                .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                }
                
                .btn-primary { 
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white; 
                }
                
                .btn-primary:hover { 
                    background: linear-gradient(135deg, #5568d3 0%, #6b3d8a 100%);
                }
                
                .btn-secondary { 
                    background-color: #e5e7eb; 
                    color: #1f2937; 
                    border: 1px solid #d1d5db;
                }
                
                .btn-secondary:hover { 
                    background-color: #d1d5db;
                    border-color: #9ca3af;
                }
                
                .btn-danger { 
                    background: linear-gradient(135deg, #f93b1d 0%, #ea2e0d 100%);
                    color: white; 
                }
                
                .btn-danger:hover { 
                    background: linear-gradient(135deg, #f52a0d 0%, #d11e00 100%);
                }
                
                .btn-sm { 
                    padding: 6px 12px; 
                    font-size: 13px; 
                }
                
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                }
                
                th, td { 
                    padding: 14px; 
                    text-align: left; 
                    border-bottom: 1px solid #e5e7eb; 
                }
                
                th { 
                    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
                    font-weight: 600; 
                    color: #374151;
                }
                
                tr { 
                    transition: background-color 0.2s ease;
                }
                
                tr:hover { 
                    background-color: #f9fafb;
                }
                
                input, select, textarea { 
                    padding: 10px 12px; 
                    border: 1px solid #d1d5db; 
                    border-radius: 6px; 
                    font-family: inherit; 
                    font-size: 14px;
                    transition: all 0.3s ease;
                }
                
                input:focus, select:focus, textarea:focus { 
                    outline: none; 
                    border-color: #667eea;
                    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                }
                
                .alert { 
                    padding: 14px 16px; 
                    border-radius: 8px; 
                    margin-bottom: 16px;
                    animation: slideInRight 0.4s ease;
                    border-left: 4px solid;
                    position: relative;
                    cursor: pointer;
                }
                
                .alert-success { 
                    background-color: #d1fae5; 
                    color: #065f46;
                    border-left-color: #10b981;
                }
                
                .alert-error { 
                    background-color: #fee2e2; 
                    color: #991b1b;
                    border-left-color: #ef4444;
                }
                
                .alert-info { 
                    background-color: #dbeafe; 
                    color: #1e40af;
                    border-left-color: #3b82f6;
                }
                
                .alert-warning { 
                    background-color: #fef3c7; 
                    color: #92400e;
                    border-left-color: #f59e0b;
                }
                
                /* Toast Notifications */
                .toast-container {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    max-width: 400px;
                }
                
                .toast {
                    background: white;
                    border-radius: 12px;
                    padding: 16px 20px;
                    margin-bottom: 12px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
                    border-left: 4px solid;
                    animation: slideInRight 0.4s ease, fadeOut 0.4s ease 3s forwards;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255,255,255,0.2);
                }
                
                .toast.success {
                    border-left-color: #10b981;
                    background: linear-gradient(135deg, #d1fae5 0%, rgba(255,255,255,0.9) 100%);
                }
                
                .toast.error {
                    border-left-color: #ef4444;
                    background: linear-gradient(135deg, #fee2e2 0%, rgba(255,255,255,0.9) 100%);
                }
                
                .toast.info {
                    border-left-color: #3b82f6;
                    background: linear-gradient(135deg, #dbeafe 0%, rgba(255,255,255,0.9) 100%);
                }
                
                .toast.warning {
                    border-left-color: #f59e0b;
                    background: linear-gradient(135deg, #fef3c7 0%, rgba(255,255,255,0.9) 100%);
                }
                
                .toast-icon {
                    font-size: 20px;
                    flex-shrink: 0;
                }
                
                .toast-content {
                    flex: 1;
                    font-size: 14px;
                    font-weight: 500;
                }
                
                .toast-close {
                    background: none;
                    border: none;
                    font-size: 18px;
                    cursor: pointer;
                    opacity: 0.6;
                    transition: opacity 0.2s ease;
                    padding: 0;
                    width: 20px;
                    height: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .toast-close:hover {
                    opacity: 1;
                }
                
                @keyframes fadeOut {
                    to {
                        opacity: 0;
                        transform: translateX(100%);
                    }
                }
                
                .card { 
                    background: white; 
                    border: 1px solid #e5e7eb; 
                    border-radius: 12px; 
                    padding: 24px; 
                    margin-bottom: 20px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                    transition: all 0.3s ease;
                    animation: fadeIn 0.4s ease;
                }
                
                .card:hover {
                    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                    border-color: #d1d5db;
                }
                
                header { 
                    background: white; 
                    border-bottom: 1px solid #e5e7eb; 
                    padding: 16px 0; 
                    margin-bottom: 30px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                    animation: slideInLeft 0.4s ease;
                }
                
                nav { 
                    display: flex; 
                    gap: 20px; 
                    align-items: center; 
                }
                
                nav a { 
                    text-decoration: none; 
                    color: #4b5563;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    position: relative;
                }
                
                nav a::after {
                    content: '';
                    position: absolute;
                    bottom: -5px;
                    left: 0;
                    width: 0;
                    height: 2px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    transition: width 0.3s ease;
                }
                
                nav a:hover {
                    color: #667eea;
                }
                
                nav a:hover::after {
                    width: 100%;
                }
                
                .sidebar { width: 250px; }
                .main { flex: 1; }
                .layout-wrapper { display: flex; gap: 20px; }
                
                .text-sm { font-size: 13px; }
                .text-lg { font-size: 18px; }
                .text-xl { font-size: 20px; }
                .text-2xl { font-size: 28px; }
                .text-3xl { font-size: 32px; }
                .text-4xl { font-size: 40px; }
                
                .font-semibold { font-weight: 600; }
                .font-bold { font-weight: 700; }
                
                .mb-4 { margin-bottom: 20px; }
                .mb-6 { margin-bottom: 24px; }
                .mt-4 { margin-top: 20px; }
                .mt-6 { margin-top: 24px; }
                
                .gap-2 { gap: 8px; display: flex; }
                .gap-4 { gap: 16px; display: flex; }
                
                .text-gray-600 { color: #4b5563; }
                .text-gray-400 { color: #9ca3af; }
                
                .flex { display: flex; }
                .justify-between { justify-content: space-between; }
                .justify-center { justify-content: center; }
                .items-center { align-items: center; }
                
                .w-full { width: 100%; }
                .max-w-md { max-width: 28rem; }
                .max-w-2xl { max-width: 42rem; }
                
                .min-h-screen { min-height: 100vh; }
                .bg-white { background-color: white; }
                
                footer { 
                    background: white; 
                    border-top: 1px solid #e5e7eb; 
                    margin-top: 60px; 
                    padding-top: 40px;
                    padding-bottom: 40px;
                    text-align: center;
                    color: #6b7280;
                    font-size: 14px;
                }
                
                .grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 20px;
                }
                
                .status-badge {
                    padding: 6px 12px;
                    border-radius: 999px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-block;
                }
                
                .status-aktif {
                    background-color: #d1fae5;
                    color: #065f46;
                }
                
                .status-non-aktif {
                    background-color: #fee2e2;
                    color: #991b1b;
                }
                
                .loading {
                    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }
                
                @media (max-width: 768px) {
                    .container { padding: 0 16px; }
                    nav { gap: 12px; font-size: 14px; }
                    .btn { padding: 8px 14px; font-size: 13px; }
                    table { font-size: 13px; }
                    th, td { padding: 10px; }
                }
            </style>
        @endif
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="container">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Punish
                        </a>
                        <nav class="hidden sm:flex gap-6">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('karyawan.index.web') }}">Karyawan</a>
                                @endif
                                <a href="{{ route('departemen.index') }}">Departemen</a>
                                <a href="{{ route('jenis-pelanggaran.index') }}">Jenis Pelanggaran</a>
                                <a href="{{ route('pelanggaran.index.web') }}">Pelanggaran</a>
                                <a href="{{ route('sanksi.index') }}">Sanksi</a>
                            @endauth
                        </nav>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <span class="text-sm text-gray-600">👤 {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container py-8">
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>❌ Error!</strong>
                    <ul style="margin-top: 8px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <p>&copy; {{ date('Y') }} <strong>Punish</strong> - Sistem Manajemen Pelanggaran Karyawan. All rights reserved.</p>
            </div>
        </footer>

        <!-- Toast Notifications Container -->
        <div class="toast-container" id="toastContainer"></div>

        <!-- JavaScript for Toast Notifications -->
        <script>
            // Toast notification system
            class Toast {
                constructor(message, type = 'info', duration = 4000) {
                    this.message = message;
                    this.type = type;
                    this.duration = duration;
                    this.element = null;
                    this.create();
                    this.show();
                    this.autoHide();
                }

                create() {
                    const toast = document.createElement('div');
                    toast.className = `toast ${this.type}`;
                    
                    const icons = {
                        success: '✅',
                        error: '❌',
                        info: 'ℹ️',
                        warning: '⚠️'
                    };

                    toast.innerHTML = `
                        <div class="toast-icon">${icons[this.type] || 'ℹ️'}</div>
                        <div class="toast-content">${this.message}</div>
                        <button class="toast-close" onclick="this.parentElement.remove()">×</button>
                    `;

                    this.element = toast;
                }

                show() {
                    document.getElementById('toastContainer').appendChild(this.element);
                    
                    // Trigger animation
                    setTimeout(() => {
                        this.element.style.transform = 'translateX(0)';
                    }, 10);
                }

                autoHide() {
                    setTimeout(() => {
                        if (this.element && this.element.parentElement) {
                            this.element.remove();
                        }
                    }, this.duration);
                }
            }

            // Function to show toast
            function showToast(message, type = 'info') {
                new Toast(message, type);
            }

            // Convert session messages to toasts
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    showToast("{{ session('success') }}", 'success');
                @endif
                
                @if(session('error'))
                    showToast("{{ session('error') }}", 'error');
                @endif
                
                @if(session('warning'))
                    showToast("{{ session('warning') }}", 'warning');
                @endif
                
                @if(session('info'))
                    showToast("{{ session('info') }}", 'info');
                @endif
            });

            // Enhanced form validation with toast feedback
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.textContent = '⏳ Memproses...';
                            submitBtn.disabled = true;
                            submitBtn.classList.add('loading');
                        }
                    });
                });

                // Enhanced delete confirmations
                const deleteButtons = document.querySelectorAll('button[onclick*="confirm"]');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const message = this.getAttribute('onclick').match(/confirm\('([^']+)'\)/);
                        if (message && !confirm(message[1])) {
                            return false;
                        }
                        this.form.submit();
                    });
                });
            });
        </script>
    </body>
</html>
