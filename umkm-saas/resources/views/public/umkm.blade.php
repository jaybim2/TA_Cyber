<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $organization->name }} - Profil &amp; Katalog Resmi</title>
    
    <!-- Tailwind CSS CDN -->
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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    @php
        $cleanPhone = preg_replace('/[^0-9]/', '', $organization->phone ?? '');
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
        $waGeneralUrl = $cleanPhone ? 'https://wa.me/' . $cleanPhone . '?text=' . urlencode('Halo ' . $organization->name . ', saya ingin bertanya mengenai produk dan layanan Anda.') : '#';
    @endphp

    <!-- 1. Header Publik (Navigasi: Profil, Produk, Kontak) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 transition">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Monogram & Nama UMKM -->
            <a href="{{ url('/u/' . $organization->slug) }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:bg-blue-700 transition">
                    {{ strtoupper(substr($organization->name, 0, 1)) }}
                </div>
                <div>
                    <span class="font-bold text-slate-900 tracking-tight text-base sm:text-lg block leading-tight">
                        {{ $organization->name }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        {{ $organization->category }}
                    </span>
                </div>
            </a>

            <!-- Navigasi Menu: Profil, Produk, Pertanyaan, Kontak -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                <a href="#profil" class="hover:text-blue-600 transition">Profil</a>
                <a href="#produk" class="hover:text-blue-600 transition">Katalog Produk</a>
                <a href="#pertanyaan" class="hover:text-blue-600 transition">Kirim Pertanyaan</a>
                <a href="#kontak" class="hover:text-blue-600 transition">Kontak WA</a>
            </nav>

            <!-- Tombol CTA WhatsApp Cepat -->
            <div class="flex items-center gap-3">
                @if($cleanPhone)
                    <a href="{{ $waGeneralUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm hover:shadow transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z" />
                        </svg>
                        <span>Hubungi via WA</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    @if(!$organization->is_active)
        <!-- 5. Tampilan Khusus Jika UMKM Nonaktif -->
        <main class="flex-1 flex items-center justify-center py-16 px-4 sm:px-6">
            <div class="max-w-md w-full bg-white border border-amber-200 rounded-3xl p-8 text-center shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto border border-amber-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Halaman UMKM ini sedang tidak aktif</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        Halaman profil dan katalog untuk <strong>{{ $organization->name }}</strong> sedang dinonaktifkan sementara oleh pemilik usaha.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </main>
    @else
        <!-- Konten Halaman Aktif UMKM -->
        <main class="flex-1 pb-16 space-y-12">
            <!-- 2. Hero Section: Foto Sampul, Nama Besar, Deskripsi, Tombol Aksi -->
            <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 text-white overflow-hidden py-16 sm:py-24">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
                
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="max-w-3xl space-y-6">
                        <!-- Chip Kategori -->
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-200 text-xs font-semibold border border-blue-400/30 backdrop-blur-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            <span>{{ $organization->category }}</span>
                        </div>

                        <!-- Nama Besar UMKM (H1) -->
                        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                            {{ $organization->name }}
                        </h1>

                        <!-- Deskripsi UMKM -->
                        @if($organization->description)
                            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                                {{ $organization->description }}
                            </p>
                        @endif

                        <!-- Dua Tombol Aksi: Hubungi via WA dan Lihat Produk -->
                        <div class="pt-4 flex flex-wrap items-center gap-3">
                            @if($cleanPhone)
                                <a href="{{ $waGeneralUrl }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 transition active:scale-95">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z" />
                                    </svg>
                                    <span>Hubungi via WA</span>
                                </a>
                            @endif

                            <a href="#produk"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-semibold border border-white/20 backdrop-blur-sm transition">
                                <span>Lihat Katalog Produk</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Profil Section: Alamat, Jam Buka, Telepon, Email Kontak -->
            <section id="profil" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Informasi &amp; Alamat Bisnis</span>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-xs">
                        <!-- Alamat Fisik -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[11px]">Alamat Usaha</span>
                            <span class="font-medium text-slate-800 text-sm leading-snug block">
                                {{ $organization->address ?? 'Alamat belum diatur' }}
                            </span>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[11px]">Jam Buka</span>
                            <span class="font-medium text-slate-800 text-sm leading-snug block">
                                {{ $organization->opening_hours ?? 'Senin - Minggu' }}
                            </span>
                        </div>

                        <!-- Telepon / WhatsApp -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[11px]">Telepon / WA</span>
                            <span class="font-medium text-slate-800 text-sm leading-snug block font-mono">
                                {{ $organization->phone ?? '-' }}
                            </span>
                        </div>

                        <!-- Email Kontak -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[11px]">Email Kontak</span>
                            <span class="font-medium text-slate-800 text-sm leading-snug block">
                                {{ $adminEmail ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Produk Section: Chip Filter Kategori & Grid Kartu Produk (HANYA PRODUK TAMPIL) -->
            <section id="produk" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Katalog Unggulan</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">
                            Daftar Produk &amp; Layanan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Pilih produk pilihan kami untuk pemesanan langsung melalui WhatsApp.
                        </p>
                    </div>

                    <div class="text-xs text-slate-500 font-medium">
                        Menampilkan <strong id="productCount" class="text-slate-900">{{ $products->count() }}</strong> produk
                    </div>
                </div>

                <!-- Chip Filter Kategori Interaktif -->
                @if($categories->count() > 0)
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <button type="button" onclick="filterCategory('all', this)"
                            class="category-chip active px-4 py-1.5 rounded-full text-xs font-semibold bg-blue-600 text-white shadow-xs transition">
                            Semua ({{ $products->count() }})
                        </button>
                        @foreach($categories as $cat)
                            @php
                                $catCount = $products->where('category', $cat)->count();
                            @endphp
                            <button type="button" onclick="filterCategory('{{ $cat }}', this)"
                                class="category-chip px-4 py-1.5 rounded-full text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition">
                                {{ $cat }} ({{ $catCount }})
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Grid Kartu Produk -->
                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
                    @forelse($products as $prod)
                        <div class="product-card bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between"
                             data-category="{{ $prod->category }}">
                            <div class="space-y-3">
                                <!-- Badge Kategori & Status -->
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                        {{ $prod->category }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Siap Dipesan
                                    </span>
                                </div>

                                <!-- Foto Produk (Jika Ada) atau Placeholder -->
                                @if($prod->photo_url)
                                    <div class="h-44 w-full rounded-2xl overflow-hidden bg-slate-100 mb-3">
                                        <img src="{{ $prod->photo_url }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endif

                                <!-- Nama Produk -->
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight leading-snug">
                                    {{ $prod->name }}
                                </h3>

                                <!-- Deskripsi Produk -->
                                @if($prod->description)
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                        {{ $prod->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                                <div>
                                    <span class="block text-[10px] uppercase font-semibold text-slate-400">Harga Satuan</span>
                                    <span class="text-lg font-extrabold text-slate-900 tracking-tight">
                                        Rp {{ number_format($prod->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if($cleanPhone)
                                    @php
                                        $waProductUrl = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode('Halo ' . $organization->name . ', saya ingin memesan produk "' . $prod->name . '" (Rp ' . number_format($prod->price, 0, ',', '.') . '). Apakah stok tersedia?');
                                    @endphp
                                    <a href="{{ $waProductUrl }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition">
                                        <span>Pesan</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white border border-slate-200 rounded-3xl p-8">
                            <div class="max-w-sm mx-auto space-y-2">
                                <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p class="text-sm font-bold text-slate-800">Katalog Produk Sedang Disiapkan</p>
                                <p class="text-xs text-slate-500">
                                    Belum ada produk aktif yang ditampilkan untuk saat ini. Silakan hubungi kami langsung via WhatsApp untuk pertanyaan produk.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- 5. Pertanyaan & Kontak Section: Form Pertanyaan Langsung & Info Pemesanan (T13 / Layar 11) -->
            <section id="pertanyaan" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <!-- Notifikasi Flash Pesan Pertanyaan -->
                @if(session('inquiry_success'))
                    <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm shadow-sm flex items-start gap-3.5">
                        <svg class="w-6 h-6 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong class="font-bold block text-emerald-900">Pesan Berhasil Terkirim!</strong>
                            <p class="mt-0.5 text-emerald-700 leading-relaxed">{{ session('inquiry_success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('inquiry_error'))
                    <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm flex items-start gap-3.5">
                        <svg class="w-6 h-6 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong class="font-bold block text-rose-900">Pengiriman Ditolak</strong>
                            <p class="mt-0.5 text-rose-700 leading-relaxed">{{ session('inquiry_error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Kolom Kiri: Formulir Kirim Pertanyaan Pengunjung (Layar 11 Form Pertanyaan) -->
                    <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                        <div class="border-b border-slate-100 pb-4 mb-6">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Layanan Pengunjung</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mt-1">
                                Kirim Pertanyaan ke {{ $organization->name }}
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Punya pertanyaan seputar ketersediaan stok, harga khusus, atau layanan pengiriman? Kirimkan pesan Anda di bawah ini.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('public.umkm.inquiry', $organization->slug) }}" class="space-y-4">
                            @csrf

                            <!-- Nama Lengkap Pengunjung -->
                            <div>
                                <label for="visitor_name" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Nama Lengkap Anda <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="visitor_name" id="visitor_name" required maxlength="150"
                                    value="{{ old('visitor_name') }}"
                                    placeholder="Contoh: Budi Santoso, Ibu Ratna"
                                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('visitor_name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('visitor_name')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kontak Pengunjung (Opsional: No WA / Email) -->
                            <div>
                                <label for="visitor_contact" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Kontak untuk Balasan (Opsional)
                                </label>
                                <input type="text" name="visitor_contact" id="visitor_contact" maxlength="100"
                                    value="{{ old('visitor_contact') }}"
                                    placeholder="Contoh: 08123456789 (WhatsApp) atau budi@example.com"
                                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('visitor_contact') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('visitor_contact')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-[11px] text-slate-400 mt-1">Cantumkan WhatsApp atau email agar admin UMKM dapat membalas pesan Anda.</p>
                            </div>

                            <!-- Pesan / Pertanyaan -->
                            <div>
                                <label for="message" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Pesan / Pertanyaan Anda <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="message" id="message" rows="4" required maxlength="2000"
                                    placeholder="Tuliskan pertanyaan Anda mengenai produk, estimasi pemesanan, atau lainnya..."
                                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('message') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Proteksi & Tombol Kirim -->
                            <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <span class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Dilindungi Rate Limiting Anti-Spam</span>
                                </span>
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold shadow-sm hover:shadow transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    <span>Kirim Pertanyaan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Kolom Kanan: Banner Kontak Cepat & Chat WhatsApp Langsung (id=kontak) -->
                    <div id="kontak" class="lg:col-span-5 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl p-6 sm:p-8 shadow-md relative overflow-hidden flex flex-col justify-between h-full space-y-6">
                        <div class="space-y-4 relative z-10">
                            <span class="text-xs font-bold text-blue-200 uppercase tracking-wider">Konsultasi Cepat</span>
                            <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight">
                                Butuh Respons Cepat via WhatsApp?
                            </h3>
                            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                                Anda juga dapat menghubungi tim {{ $organization->name }} secara langsung melalui WhatsApp untuk konsultasi pesanan instan.
                            </p>

                            <div class="space-y-2 pt-2 text-xs text-blue-100">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Pemesanan eceran dan partai besar</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Konsultasi estimasi ongkos kirim</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 relative z-10">
                            @if($cleanPhone)
                                <a href="{{ $waGeneralUrl }}" target="_blank"
                                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-xs sm:text-sm font-bold shadow transition active:scale-95">
                                    <svg class="w-4 h-4 fill-current text-emerald-600" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z" />
                                    </svg>
                                    <span>Chat Langsung via WhatsApp</span>
                                </a>
                            @else
                                <span class="text-xs text-blue-200 italic">Nomor WhatsApp belum dikonfigurasi. Silakan gunakan form pertanyaan di samping.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endif

    <!-- Footer Publik UMKM -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-6xl mx-auto px-4 space-y-2">
            <p class="font-semibold text-slate-700">&copy; {{ date('Y') }} {{ $organization->name }}. Hak Cipta Dilindungi.</p>
            <p class="text-slate-400 text-[11px]">Diberdayakan oleh Platform Website Profil &amp; Katalog Siap Pakai untuk UMKM.</p>
        </div>
    </footer>

    <!-- Script Filter Kategori Client-Side -->
    <script>
        function filterCategory(category, clickedButton) {
            // Update tampilan tombol aktif
            document.querySelectorAll('.category-chip').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-xs');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-700');
            });
            clickedButton.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-700');
            clickedButton.classList.add('bg-blue-600', 'text-white', 'shadow-xs');

            // Filter kartu produk
            const cards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update counter
            const countElement = document.getElementById('productCount');
            if (countElement) {
                countElement.textContent = visibleCount;
            }
        }
    </script>
</body>
</html>
