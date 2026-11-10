@extends('layouts.app', ['title' => 'Dashboard UMKM - ' . ($organization->name ?? 'Admin')])

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Header Dashboard -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold mb-2 border border-blue-200">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                <span>Dashboard Pengelola UMKM</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                {{ $organization->name ?? 'UMKM Anda' }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola profil usaha, pantau produk katalog, dan kelola pesan pengunjung.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('umkm.profile.edit') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Kelola Profil Usaha</span>
            </a>
            @if(isset($organization->slug))
                <a href="{{ url('/u/' . $organization->slug) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold border border-slate-200 shadow-sm transition">
                    <span>Buka Halaman Publik</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Ringkasan Angka Statistik (Stat Cards) -->
    <div>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ringkasan Katalog &amp; Interaksi</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Produk -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
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
                <div class="mt-2 text-[11px] text-slate-500">
                    Katalog terdaftar
                </div>
            </div>

            <!-- Card 2: Produk Tampil -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
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
                <div class="mt-2 text-[11px] text-slate-500">
                    Tampil di website publik
                </div>
            </div>

            <!-- Card 3: Total Pertanyaan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
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
                <div class="mt-2 text-[11px] text-slate-500">
                    Masuk dari pengunjung
                </div>
            </div>

            <!-- Card 4: Pertanyaan Baru -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Perlu Tindak Lanjut</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-rose-600 tracking-tight">{{ $stats['inquiries_baru'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">baru</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500">
                    Status pesan 'Baru'
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pertanyaan Breakdown & Info Profil -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Breakdown Pertanyaan per Status -->
        <div class="lg:col-span-1 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Status Pesan Pertanyaan</span>
            </h3>

            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <span class="text-xs font-semibold text-slate-700">Baru</span>
                    </div>
                    <span class="text-sm font-bold text-slate-900">{{ $stats['inquiries_baru'] }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span class="text-xs font-semibold text-slate-700">Dibalas</span>
                    </div>
                    <span class="text-sm font-bold text-slate-900">{{ $stats['inquiries_dibalas'] }}</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-semibold text-slate-700">Selesai</span>
                    </div>
                    <span class="text-sm font-bold text-slate-900">{{ $stats['inquiries_selesai'] }}</span>
                </div>
            </div>
        </div>

        <!-- Info Profil UMKM -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Informasi Profil Bisnis</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Nama Usaha</span>
                    <span class="text-sm font-bold text-slate-800">{{ $organization->name ?? '-' }}</span>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Kategori</span>
                    <span class="text-sm font-bold text-slate-800">{{ $organization->category ?? '-' }}</span>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Alamat Web Publik</span>
                    <span class="text-xs font-mono text-blue-600 font-semibold">/u/{{ $organization->slug ?? '-' }}</span>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Status Publikasi</span>
                    @if($organization->is_active ?? true)
                        <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-rose-700 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                        </span>
                    @endif
                </div>

                <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Admin Pengelola</span>
                    <span class="text-xs font-medium text-slate-800">{{ $user->name }} &bull; {{ $user->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Isolation Notice -->
    <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-200 text-xs text-blue-900 flex items-start gap-3">
        <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <div>
            <span class="font-semibold text-blue-950">Isolasi Keamanan Tenant Aktif:</span>
            <span> Seluruh query angka produk dan pesan dibatasi khusus untuk <strong>{{ $organization->name ?? 'UMKM Anda' }}</strong> melalui <code>TenantScope</code>. Anda tidak dapat melihat maupun mengakses data UMKM lain.</span>
        </div>
    </div>
</div>
@endsection
