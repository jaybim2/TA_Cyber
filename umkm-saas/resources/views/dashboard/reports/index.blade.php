@extends('layouts.app', ['title' => 'Laporan & Ekspor - ' . ($organization->name ?? 'Admin')])

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Breadcrumb & Header Navigasi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Laporan &amp; Ekspor</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Laporan &amp; Rekap Data UMKM</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Pantau visualisasi metrik bisnis, tabel rekap data, serta unduh laporan resmi dalam format file CSV.
            </p>
        </div>

        <!-- Tombol Aksi Ekspor CSV Otomatis (Membawa Filter Aktif) -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('reports.export-products', request()->query()) }}"
                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs hover:shadow transition"
                title="Unduh seluruh data produk hasil filter ke file CSV">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Ekspor CSV Produk</span>
            </a>

            <a href="{{ route('reports.export-inquiries', request()->query()) }}"
                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs hover:shadow transition"
                title="Unduh data pertanyaan masuk hasil filter ke file CSV">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Ekspor CSV Pertanyaan</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar Terpadu (Rentang Tanggal, Kategori, Status) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3.5 items-end">
            <!-- Tanggal Awal -->
            <div class="sm:col-span-3">
                <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <!-- Tanggal Akhir -->
            <div class="sm:col-span-3">
                <label for="end_date" class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <!-- Kategori Produk -->
            <div class="sm:col-span-2">
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">Kategori Produk</label>
                <select name="category" id="category"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ ($filters['category'] ?? '') === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Pertanyaan -->
            <div class="sm:col-span-2">
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status Pesan</label>
                <select name="status" id="status"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ ($filters['status'] ?? '') === 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Dibalas" {{ ($filters['status'] ?? '') === 'Dibalas' ? 'selected' : '' }}>Dibalas</option>
                    <option value="Selesai" {{ ($filters['status'] ?? '') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Tombol Terapkan & Reset -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
                @if($hasActiveFilter)
                    <a href="{{ route('reports.index') }}"
                        title="Reset semua filter"
                        class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alert Khusus Bila Hasil Filter Kosong (Kriteria Selesai T14) -->
    @if($isResultEmpty)
        <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-amber-900">Data Tidak Ditemukan untuk Kriteria Filter Ini</h3>
                    <p class="text-xs text-amber-700 mt-0.5 leading-relaxed">
                        Tidak ada data produk maupun pertanyaan yang cocok dengan rentang tanggal, kategori, atau status yang Anda tentukan.
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('reports.index') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Filter</span>
                </a>
            </div>
        </div>
    @endif

    <!-- 1. Kartu Ringkasan Metrik (Total Produk, Produk Tampil, Total Pertanyaan, Baru/Dibalas/Selesai) -->
    <div>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ringkasan Metrik Terfilter</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Produk -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total Produk</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['total_products'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">item</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500 flex items-center justify-between border-t border-slate-100 pt-2">
                    <span>Sembunyi: <strong>{{ $stats['hidden_products'] }}</strong></span>
                    <span>Tampil: <strong>{{ $stats['active_products'] }}</strong></span>
                </div>
            </div>

            <!-- Card 2: Produk Tampil -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Produk Tampil</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $stats['active_products'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">aktif</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500 border-t border-slate-100 pt-2">
                    Dipublikasikan di website
                </div>
            </div>

            <!-- Card 3: Total Pertanyaan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total Pertanyaan</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['total_inquiries'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">pesan</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500 border-t border-slate-100 pt-2">
                    Masuk dari pengunjung publik
                </div>
            </div>

            <!-- Card 4: Rincian Status Pertanyaan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Status Pertanyaan</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold text-rose-600">{{ $stats['inquiries_baru'] }}</span>
                    <span class="text-xs text-slate-400">Baru</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-2xl font-extrabold text-amber-600">{{ $stats['inquiries_dibalas'] }}</span>
                    <span class="text-xs text-slate-400">Dibalas</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-2xl font-extrabold text-emerald-600">{{ $stats['inquiries_selesai'] }}</span>
                    <span class="text-xs text-slate-400">Selesai</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500 border-t border-slate-100 pt-2">
                    Baru &bull; Dibalas &bull; Selesai
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Bagian Grafik Sederhana (Visual Bar & Chart Breakdown) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik 1: Produk per Kategori -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                        <span>Distribusi Produk per Kategori</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Komposisi item katalog berdasarkan kategori produk.</p>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                    {{ $stats['total_products'] }} Produk
                </span>
            </div>

            @if(count($productsByCategory) > 0)
                <div class="space-y-4">
                    @php $totalProd = max(1, $stats['total_products']); @endphp
                    @foreach($productsByCategory as $catName => $count)
                        @php $pct = round(($count / $totalProd) * 100); @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-700">{{ $catName }}</span>
                                <span class="text-slate-900 font-bold font-mono">{{ $count }} item <span class="text-slate-400 font-normal">({{ $pct }}%)</span></span>
                            </div>
                            <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center text-xs text-slate-400">
                    Belum ada data produk yang terdaftar untuk ditampilkan pada grafik ini.
                </div>
            @endif
        </div>

        <!-- Grafik 2: Pertanyaan per Status -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Distribusi Pertanyaan per Status</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Persentase tindak lanjut pesan yang masuk dari pengunjung.</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                    {{ $stats['total_inquiries'] }} Pesan
                </span>
            </div>

            @if($stats['total_inquiries'] > 0)
                @php $totalInq = max(1, $stats['total_inquiries']); @endphp
                <div class="space-y-4">
                    <!-- Status Baru -->
                    @php $pctBaru = round(($stats['inquiries_baru'] / $totalInq) * 100); @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                            <span class="text-rose-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>Perlu Tindak Lanjut (Baru)</span>
                            </span>
                            <span class="text-slate-900 font-bold font-mono">{{ $stats['inquiries_baru'] }} pesan <span class="text-slate-400 font-normal">({{ $pctBaru }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full transition-all duration-500" style="width: {{ $pctBaru }}%"></div>
                        </div>
                    </div>

                    <!-- Status Dibalas -->
                    @php $pctDibalas = round(($stats['inquiries_dibalas'] / $totalInq) * 100); @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                            <span class="text-amber-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>Sedang Diproses (Dibalas)</span>
                            </span>
                            <span class="text-slate-900 font-bold font-mono">{{ $stats['inquiries_dibalas'] }} pesan <span class="text-slate-400 font-normal">({{ $pctDibalas }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: {{ $pctDibalas }}%"></div>
                        </div>
                    </div>

                    <!-- Status Selesai -->
                    @php $pctSelesai = round(($stats['inquiries_selesai'] / $totalInq) * 100); @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                            <span class="text-emerald-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Tuntas (Selesai)</span>
                            </span>
                            <span class="text-slate-900 font-bold font-mono">{{ $stats['inquiries_selesai'] }} pesan <span class="text-slate-400 font-normal">({{ $pctSelesai }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $pctSelesai }}%"></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-12 text-center text-xs text-slate-400">
                    Belum ada data pertanyaan pengunjung untuk ditampilkan pada grafik ini.
                </div>
            @endif
        </div>
    </div>

    <!-- 3. Tabel Rekap Produk Terfilter -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Tabel Rekap Produk ({{ $products->count() }} Item)</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar item produk yang sesuai dengan rentang tanggal dan kategori terpilih.</p>
            </div>
            <div>
                <a href="{{ route('reports.export-products', request()->query()) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Ekspor CSV</span>
                </a>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Nama Produk</th>
                            <th scope="col" class="py-3 px-4">Kategori</th>
                            <th scope="col" class="py-3 px-4">Harga Satuan</th>
                            <th scope="col" class="py-3 px-4 text-center">Status</th>
                            <th scope="col" class="py-3 px-4 text-right">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($products as $idx => $prod)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 text-center font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $prod->name }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                        {{ $prod->category }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                    Rp {{ number_format($prod->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($prod->status === 'Tampil')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tampil
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sembunyi
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right font-mono text-slate-500">
                                    {{ $prod->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-8 text-center text-xs text-slate-400">
                Tidak ada data produk yang memenuhi kriteria filter.
            </div>
        @endif
    </div>

    <!-- 4. Tabel Rekap Pertanyaan Masuk Terfilter -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span>Tabel Rekap Pertanyaan Masuk ({{ $inquiries->count() }} Pesan)</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pertanyaan pengunjung yang masuk berdasarkan rentang tanggal dan status.</p>
            </div>
            <div>
                <a href="{{ route('reports.export-inquiries', request()->query()) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Ekspor CSV</span>
                </a>
            </div>
        </div>

        @if($inquiries->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4 w-32">Tanggal Masuk</th>
                            <th scope="col" class="py-3 px-4 w-44">Pengunjung &amp; Kontak</th>
                            <th scope="col" class="py-3 px-4">Ringkasan Pesan</th>
                            <th scope="col" class="py-3 px-4 text-center w-24">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($inquiries as $idx => $inq)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 text-center font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 whitespace-nowrap font-mono text-slate-600">
                                    {{ $inq->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $inq->visitor_name }}</div>
                                    <div class="text-[11px] text-blue-600 font-mono">{{ $inq->visitor_contact ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="text-xs text-slate-700 line-clamp-1">
                                        {{ $inq->message }}
                                    </p>
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    @if($inq->status === 'Baru')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Baru
                                        </span>
                                    @elseif($inq->status === 'Dibalas')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Dibalas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-8 text-center text-xs text-slate-400">
                Tidak ada data pertanyaan yang memenuhi kriteria filter.
            </div>
        @endif
    </div>
</div>
@endsection

