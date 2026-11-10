<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $organization->name }} - Profil & Katalog Resmi</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-blue-500 selection:text-white">
    <!-- Header Publik UMKM -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-base shadow-sm">
                    {{ strtoupper(substr($organization->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="font-bold text-slate-900 text-base leading-tight">{{ $organization->name }}</h1>
                    <span class="text-[11px] text-slate-500">{{ $organization->category }}</span>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                @if($organization->phone)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $organization->phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                        <span>Hubungi via WA</span>
                    </a>
                @endif
            </nav>
        </div>
    </header>

    @if(!$organization->is_active)
        <!-- Banner Jika UMKM Sedang Nonaktif -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 mt-8 w-full">
            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-center space-y-2">
                <span class="inline-block p-3 rounded-full bg-amber-100 text-amber-700 mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <h2 class="text-base font-bold text-amber-900">Halaman UMKM ini sedang tidak aktif</h2>
                <p class="text-xs text-amber-800 max-w-md mx-auto">
                    Katalog dan informasi usaha sedang ditangguhkan sementara oleh pengelola. Silakan kembali lagi nanti.
                </p>
            </div>
        </div>
    @else
        <!-- Konten Halaman Publik UMKM -->
        <main class="flex-1 py-8 max-w-5xl mx-auto px-4 sm:px-6 w-full space-y-8">
            <!-- Hero Profil UMKM -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-sm relative overflow-hidden">
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-4 border border-blue-200">
                        <span>{{ $organization->category }}</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                        {{ $organization->name }}
                    </h2>

                    @if($organization->description)
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                            {{ $organization->description }}
                        </p>
                    @endif

                    <!-- Detail Alamat & Kontak -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100 text-xs text-slate-600">
                        @if($organization->address)
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <strong class="block text-slate-900 font-semibold mb-0.5">Alamat</strong>
                                    <span>{{ $organization->address }}</span>
                                </div>
                            </div>
                        @endif

                        @if($organization->opening_hours)
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <strong class="block text-slate-900 font-semibold mb-0.5">Jam Buka</strong>
                                    <span>{{ $organization->opening_hours }}</span>
                                </div>
                            </div>
                        @endif

                        @if($organization->phone)
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <strong class="block text-slate-900 font-semibold mb-0.5">Telepon / WhatsApp</strong>
                                    <span>{{ $organization->phone }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bagian Produk Katalog (Hanya Produk Tampil) -->
            @if(isset($products) && $products->count() > 0)
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900">Katalog Produk</h3>
                        <span class="text-xs text-slate-500">{{ $products->count() }} produk tersedia</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($products as $prod)
                            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                                <div>
                                    <span class="text-[11px] font-semibold text-blue-600 uppercase tracking-wider">{{ $prod->category }}</span>
                                    <h4 class="font-bold text-slate-900 text-base mt-1">{{ $prod->name }}</h4>
                                    @if($prod->description)
                                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $prod->description }}</p>
                                    @endif
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-sm font-extrabold text-slate-900">
                                        Rp {{ number_format($prod->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded font-medium">Tersedia</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
    @endif

    <footer class="bg-white border-t border-slate-200 py-6 mt-auto text-center text-xs text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} {{ $organization->name }}. Diberdayakan oleh Platform SaaS UMKM.</p>
        </div>
    </footer>
</body>
</html>
