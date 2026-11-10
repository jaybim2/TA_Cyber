<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Platform UMKM SaaS' }} - Solusi Katalog & Profil Digital</title>
    
    <!-- Tailwind CSS CDN untuk preview dan render instan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-blue-500 selection:text-white">
    <!-- Navbar Navigasi -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:bg-blue-700 transition">
                        U
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 tracking-tight text-lg">UMKM<span class="text-blue-600">SaaS</span></span>
                        <span class="hidden sm:inline-block ml-2 text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-medium">Katalog Siap Pakai</span>
                    </div>
                </a>
            </div>

            <nav class="flex items-center gap-3 text-sm font-medium">
                @auth
                    <span class="text-slate-600 text-xs sm:text-sm">
                        Halo, <strong class="text-slate-900">{{ Auth::user()->name }}</strong>
                        @if(Auth::user()->isVendor())
                            <span class="ml-1 text-[11px] bg-purple-100 text-purple-700 font-semibold px-2 py-0.5 rounded-full">Vendor</span>
                        @elseif(Auth::user()->organization)
                            <span class="text-slate-400">({{ Auth::user()->organization->name }})</span>
                        @endif
                    </span>
                    @if(Auth::user()->isVendor())
                        <a href="{{ url('/vendor') }}" class="px-3 py-1.5 rounded-lg text-slate-700 hover:text-blue-600 transition">
                            Area Vendor
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="px-3 py-1.5 rounded-lg text-slate-700 hover:text-blue-600 transition">
                            Dashboard
                        </a>
                        <a href="{{ route('umkm.profile.edit') }}" class="px-3 py-1.5 rounded-lg text-slate-700 hover:text-blue-600 transition">
                            Profil Usaha
                        </a>
                    @endif
                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-rose-600 hover:bg-rose-50 text-xs font-semibold transition">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="px-3.5 py-2 text-slate-700 hover:text-blue-600 text-sm font-semibold transition">
                        Masuk
                    </a>
                    <a href="{{ url('/register-umkm') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 shadow-sm hover:shadow transition">
                        Daftar UMKM
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Notifikasi Flash Message -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="flex-1 font-medium">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- Konten Utama -->
    <main class="flex-1 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} Platform SaaS Profil & Katalog UMKM. Tugas Besar Keamanan Siber.</p>
        </div>
    </footer>
</body>
</html>

