<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKMSaaS - Website Profil &amp; Katalog Siap Pakai untuk UMKM</title>
    
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
    <!-- 1. Header Publik (Nama Platform, Menu Navigasi, Tombol Masuk & Daftar UMKM) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 transition">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Monogram & Nama Platform -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:bg-blue-700 transition">
                    U
                </div>
                <div>
                    <span class="font-extrabold text-slate-900 tracking-tight text-lg">UMKM<span class="text-blue-600">SaaS</span></span>
                    <span class="hidden sm:inline-block ml-2 text-[11px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-semibold">Katalog Siap Pakai</span>
                </div>
            </a>

            <!-- Menu Navigasi: Beranda, Cara Kerja, Fitur, Contoh -->
            <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Kerja</a>
                <a href="#fitur" class="hover:text-blue-600 transition">Fitur Platform</a>
                <a href="#contoh" class="hover:text-blue-600 transition">Contoh UMKM</a>
            </nav>

            <!-- Tombol Aksi: Masuk dan Daftar UMKM -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="px-3.5 py-2 text-slate-700 hover:text-blue-600 text-xs sm:text-sm font-semibold transition">
                    Masuk
                </a>
                <a href="{{ route('register-umkm') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold text-xs sm:text-sm hover:bg-blue-700 shadow-sm hover:shadow transition">
                    <span>Daftar UMKM</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 space-y-20 sm:space-y-28 pb-20">
        <!-- 2. Hero Section: Headline, Subheadline, Tombol Aksi -->
        <section class="relative bg-gradient-to-b from-blue-50/50 via-white to-slate-50 pt-16 sm:pt-24 pb-12 overflow-hidden border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
                <!-- Badge Pill -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Platform Profil &amp; Katalog Siap Pakai untuk UMKM</span>
                </div>

                <!-- Headline Utama (Sesuai Spesifikasi T15) -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight max-w-4xl mx-auto">
                    Website UMKM Rapi, <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                        Tanpa Bangun dari Nol
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="text-sm sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Satu website profil dan katalog siap pakai per UMKM. Tampilkan produk unggulan, terima pertanyaan pelanggan, dan terhubung langsung ke WhatsApp tanpa repot sewa hosting atau coding.
                </p>

                <!-- Tombol CTA Hero (Daftar UMKM & Lihat Contoh Halaman) -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3.5">
                    <a href="{{ route('register-umkm') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md hover:shadow-lg shadow-blue-500/20 transition active:scale-95">
                        <span>Daftar UMKM Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="#contoh"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm border border-slate-200 shadow-xs transition">
                        <span>Lihat Contoh Halaman</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>

                <!-- Preview Mockup Singkat Browser / Banner Fitur -->
                <div class="pt-8 max-w-3xl mx-auto">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-3 sm:p-4 text-left">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                            <span class="text-[11px] font-mono text-slate-400 ml-2 truncate">https://platformkamu.test/u/nama-umkm-anda</span>
                        </div>
                        <div class="pt-3 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="block font-bold text-slate-900">1 Menit</span>
                                <span class="text-[11px] text-slate-500">Langsung Aktif</span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="block font-bold text-slate-900">Multi-Tenant</span>
                                <span class="text-[11px] text-slate-500">Data Terisolasi</span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="block font-bold text-slate-900">Direct WA</span>
                                <span class="text-[11px] text-slate-500">Order Sekali Klik</span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="block font-bold text-slate-900">Anti-Spam</span>
                                <span class="text-[11px] text-slate-500">Rate Limiting</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Langkah Cara Kerja (3 Langkah: Daftar UMKM -> Lengkapi Profil & Produk -> Bagikan Link Halaman) -->
        <section id="cara-kerja" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Langkah Sederhana</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Tiga Langkah Membuka Website Usaha Anda
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Tidak perlu keahlian teknis, ikuti tiga alur mudah untuk memiliki website katalog siap pakai.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Step 1 -->
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-extrabold text-lg flex items-center justify-center border border-blue-100">
                            01
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">
                            Daftar UMKM
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Daftarkan nama bisnis Anda dan tentukan alamat web unik Anda (misalnya <code>/u/toko-anda</code>). Akun pengelola langsung aktif saat itu juga.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-[11px] font-semibold text-blue-600 flex items-center gap-1">
                        <span>Layar Registrasi Instan</span>
                        <span>&rarr;</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 font-extrabold text-lg flex items-center justify-center border border-indigo-100">
                            02
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">
                            Lengkapi Profil &amp; Produk
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Masukkan informasi kontak WhatsApp, jam operasional, dan tambahkan produk ke dalam katalog dengan harga serta foto produk yang jelas.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-[11px] font-semibold text-indigo-600 flex items-center gap-1">
                        <span>Dashboard Manajemen UMKM</span>
                        <span>&rarr;</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition relative flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 font-extrabold text-lg flex items-center justify-center border border-emerald-100">
                            03
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">
                            Bagikan Link Halaman
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Website profil publik Anda langsung aktif di <code>/u/{slug}</code>. Bagikan tautan ke bio Instagram, WhatsApp, atau Google Maps usaha Anda.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                        <span>Halaman Siap Dikunjungi</span>
                        <span>&rarr;</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Fitur Utama & Showcase Contoh UMKM Toko ABC -->
        <section id="fitur" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Keunggulan Sistem</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Fitur Lengkap untuk Kemudahan UMKM
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Fokus menjual dan melayani pelanggan, biar sistem yang mengurus tampilan katalog dan keamanan data.
                </p>
            </div>

            <!-- 4 Kartu Fitur -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Fitur 1: Website Profil Siap Pakai -->
                <div class="bg-white rounded-3xl border border-slate-200 p-7 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Website Profil Siap Pakai</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Halaman profil resmi dengan desain bersih, responsif di HP maupun desktop, memuat jam buka, alamat fisik, dan deskripsi bisnis Anda.
                    </p>
                </div>

                <!-- Fitur 2: Katalog Produk Digital -->
                <div class="bg-white rounded-3xl border border-slate-200 p-7 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Katalog Produk &amp; Filter Kategori</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Tampilkan harga transparan, foto produk, dan tombol filter kategori yang interaktif. Pengunjung dapat memilih produk favorit secara praktis.
                    </p>
                </div>

                <!-- Fitur 3: Form Pertanyaan & Direct WhatsApp -->
                <div class="bg-white rounded-3xl border border-slate-200 p-7 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Form Pertanyaan &amp; WhatsApp Cepat</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Terima pesan dari calon pembeli melalui formulir anti-spam atau sediakan tombol chat WhatsApp langsung yang otomatis mengisi detail produk.
                    </p>
                </div>

                <!-- Fitur 4: Isolasi Keamanan Multi-Tenant -->
                <div class="bg-white rounded-3xl border border-slate-200 p-7 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Keamanan Siber &amp; Anti-IDOR</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Data produk, profil usaha, dan pesan pelanggan terlindungi oleh isolasi tenant otomatis. UMKM lain tidak dapat mengintip atau mengubah data Anda.
                    </p>
                </div>
            </div>

            <!-- 1 Kartu Contoh: Showcase Toko ABC (Sesuai Spesifikasi T15) -->
            <div id="contoh" class="pt-6">
                <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
                    <div class="max-w-2xl space-y-5 relative z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-200 text-xs font-semibold border border-blue-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Studi Kasus Nyata: Toko ABC</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Lihat Tampilan Website Resmi Toko ABC
                        </h3>
                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                            Contoh UMKM kuliner yang telah menggunakan platform ini. Rasakan langsung kemudahan navigasi profil, katalog menu makanan, dan formulir pertanyaan pengunjung.
                        </p>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ url('/u/toko-abc') }}" target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs sm:text-sm shadow-md transition active:scale-95">
                                <span>Buka Halaman /u/toko-abc</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section Akhir -->
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-600 text-white rounded-3xl p-8 sm:p-12 text-center space-y-6 shadow-xl">
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight max-w-2xl mx-auto">
                    Siap Membawa Bisnis UMKM Anda Tampil Lebih Profesional?
                </h2>
                <p class="text-blue-100 text-xs sm:text-sm max-w-lg mx-auto">
                    Daftar gratis dalam 1 menit, lengkapi profil dan produk Anda, lalu dapatkan tautan website yang rapi dan siap dibagikan.
                </p>
                <div>
                    <a href="{{ route('register-umkm') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-white text-blue-700 hover:bg-blue-50 font-bold text-sm shadow-md transition active:scale-95">
                        <span>Daftarkan UMKM Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- 5. Footer (Kontak Vendor & Link Masuk/Daftar) -->
    <footer class="bg-white border-t border-slate-200 py-12 text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <!-- Info Brand -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                            U
                        </div>
                        <span class="font-extrabold text-slate-900 tracking-tight text-base">UMKM<span class="text-blue-600">SaaS</span></span>
                    </div>
                    <p class="text-xs text-slate-500 max-w-sm leading-relaxed">
                        Solusi platform website profil dan katalog siap pakai berbasis web dengan model SaaS untuk pelaku UMKM.
                    </p>
                    <p class="text-[11px] text-slate-400">
                        Kontak Vendor / Platform: <strong class="text-slate-600">vendor@platformkamu.test</strong>
                    </p>
                </div>

                <!-- Tautan Cepat: Masuk & Daftar -->
                <div class="flex flex-wrap items-center gap-6 font-semibold text-slate-700">
                    <a href="{{ route('login') }}" class="hover:text-blue-600 transition">Masuk Pengelola</a>
                    <a href="{{ route('register-umkm') }}" class="hover:text-blue-600 transition">Daftar Akun UMKM</a>
                    <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Kerja</a>
                    <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                    <a href="{{ url('/u/toko-abc') }}" target="_blank" class="hover:text-blue-600 transition">Contoh Halaman</a>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-slate-400">
                <p>&copy; {{ date('Y') }} Platform SaaS Profil &amp; Katalog UMKM. Tugas Besar Keamanan Siber.</p>
                <p>Tanpa biaya tersembunyi &bull; 100% Siap Pakai &bull; Multi-Tenant Aman</p>
            </div>
        </div>
    </footer>
</body>
</html>
