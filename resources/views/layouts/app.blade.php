<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Punish') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for mobile menu and dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* To hide scrollbar when using alpine modal if needed */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-800 antialiased selection:bg-indigo-500 selection:text-white">

    {{-- ===== NAVBAR ===== --}}
    @auth
        @if(!auth()->user()->otp_verified_at)
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('otp.verify.form') }}" class="text-xl font-bold text-gray-900 tracking-tight">
                            <span class="text-indigo-600">Punish</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="hidden sm:inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200 uppercase tracking-wide">OTP Pending</span>
                        <span class="hidden sm:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-xs font-medium px-3 py-1.5 rounded-md bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @elseif(auth()->user()->role === 'admin')
        <nav x-data="{ open: false, profileOpen: false }" class="bg-slate-900 sticky top-0 z-50 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white tracking-tight">
                            <span class="text-indigo-400">Punish</span> Admin
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('karyawan.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('karyawan.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Karyawan</a>
                        <a href="{{ route('departemen.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('departemen.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Departemen</a>
                        <a href="{{ route('jenis-pelanggaran.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('jenis-pelanggaran.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Jenis Pelanggaran</a>
                        <a href="{{ route('pelanggaran.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('pelanggaran.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Pelanggaran</a>
                        <a href="{{ route('sanksi.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('sanksi.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Sanksi</a>
                    </div>

                    <!-- Right Side -->
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/15 text-indigo-300 border border-indigo-500/30 uppercase tracking-wide">Admin</span>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 bg-white/5 border border-white/10 px-3 py-1.5 rounded-full hover:bg-white/10 transition">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold text-white overflow-hidden border border-indigo-400">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        {{ auth()->user()->initials ?? substr(auth()->user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-slate-200">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="profileOpen" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 transition">
                            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-cloak class="md:hidden bg-slate-900 border-t border-slate-800">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Dashboard</a>
                    <a href="{{ route('karyawan.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('karyawan.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Karyawan</a>
                    <a href="{{ route('departemen.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('departemen.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Departemen</a>
                    <a href="{{ route('jenis-pelanggaran.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('jenis-pelanggaran.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Jenis Pelanggaran</a>
                    <a href="{{ route('pelanggaran.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pelanggaran.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Pelanggaran</a>
                    <a href="{{ route('sanksi.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('sanksi.*') ? 'bg-indigo-500/20 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Sanksi</a>
                </div>
                <div class="pt-4 pb-3 border-t border-slate-800">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-sm font-bold text-white border border-indigo-400">
                                {{ auth()->user()->initials ?? substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-slate-400">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- ===== NAVBAR USER ===== --}}
        @else
        <nav x-data="{ open: false, profileOpen: false }" class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900 tracking-tight">
                            <span class="text-indigo-600">Punish</span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Dashboard</a>
                        <a href="{{ route('pelanggaran.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('pelanggaran.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Pelanggaran</a>
                        <a href="{{ route('departemen.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('departemen.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Departemen</a>
                        <a href="{{ route('jenis-pelanggaran.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('jenis-pelanggaran.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Jenis Pelanggaran</a>
                        <a href="{{ route('sanksi.index.web') }}" class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('sanksi.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Sanksi</a>
                    </div>

                    <!-- Right Side -->
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-200 uppercase tracking-wide">Karyawan</span>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 bg-indigo-50/50 border border-indigo-100 px-3 py-1.5 rounded-full hover:bg-indigo-50 transition">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold text-white overflow-hidden border border-indigo-200">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        {{ auth()->user()->initials ?? substr(auth()->user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="profileOpen" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-cloak class="md:hidden bg-white border-t border-gray-100 shadow-lg">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Dashboard</a>
                    <a href="{{ route('pelanggaran.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pelanggaran.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Pelanggaran</a>
                    <a href="{{ route('departemen.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('departemen.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Departemen</a>
                    <a href="{{ route('jenis-pelanggaran.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('jenis-pelanggaran.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Jenis Pelanggaran</a>
                    <a href="{{ route('sanksi.index.web') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('sanksi.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">Sanksi</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-100 bg-gray-50">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-sm font-bold text-white border border-indigo-200">
                                {{ auth()->user()->initials ?? substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endif

    {{-- ===== NAVBAR GUEST ===== --}}
    @else
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <a href="/" class="text-2xl font-bold text-gray-900 tracking-tight">
                        <span class="text-indigo-600">Punish</span>
                    </a>
                    <div class="flex items-center gap-2 sm:gap-3">
                        @unless(request()->routeIs('login'))
                            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold px-3 sm:px-4 py-2 hover:bg-indigo-50 rounded-lg transition text-sm">Masuk</a>
                        @endunless
                        @unless(request()->routeIs('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white font-semibold px-3 sm:px-4 py-2 rounded-lg hover:bg-indigo-700 transition shadow-sm text-sm">Daftar</a>
                        @endunless
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    {{-- ===== FLASH MESSAGES & CONTENT ===== --}}
    <main class="flex-1 app-shell">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} <span class="font-bold text-indigo-600">Punish</span> &mdash; Sistem Manajemen Pelanggaran. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
