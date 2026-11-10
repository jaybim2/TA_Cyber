@extends('layouts.app', ['title' => 'Dashboard UMKM'])

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Dashboard -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard Admin UMKM</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola profil, katalog produk, dan pantau pesan pengunjung dari satu tempat.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                UMKM Aktif
            </span>
        </div>
    </div>

    <!-- Info Card UMKM Terdaftar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-2xl shadow-sm">
                    {{ strtoupper(substr($organization->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $organization->name ?? 'Nama UMKM' }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-md font-medium">
                            {{ $organization->category ?? 'Umum' }}
                        </span>
                        <span class="text-xs text-slate-400">&bull;</span>
                        <span class="text-xs text-slate-500 font-mono">
                            Slug: {{ $organization->slug ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            @if(isset($organization->slug))
                <a href="{{ url('/u/' . $organization->slug) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 transition">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            @endif
        </div>

        <!-- Detail Data -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6">
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Admin Pengelola</span>
                <span class="text-sm font-medium text-slate-900">{{ Auth::user()->name }}</span>
                <span class="block text-xs text-slate-500 mt-0.5">{{ Auth::user()->email }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kontak Telepon / WA</span>
                <span class="text-sm font-medium text-slate-900">{{ $organization->phone ?? 'Belum diisi' }}</span>
                <span class="block text-xs text-slate-500 mt-0.5">{{ $organization->opening_hours ?? 'Jam buka belum diatur' }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Alamat Usaha</span>
                <span class="text-sm font-medium text-slate-900">{{ $organization->address ?? 'Belum diisi' }}</span>
            </div>
        </div>
    </div>

    <!-- Banner Info Modul Berikutnya -->
    <div class="rounded-xl border border-blue-200 bg-blue-50/70 p-5 text-sm text-blue-900 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="space-y-1">
            <p class="font-semibold text-blue-950">Pendaftaran Berhasil &amp; Sesi Terautentikasi</p>
            <p class="text-xs text-blue-800 leading-relaxed">
                Anda telah terdaftar sebagai <strong>Admin UMKM</strong> dengan isolasi data multi-tenant aktif. Modul autentikasi login terpisah, throttle, serta manajemen katalog produk akan diaktifkan pada task berikutnya sesuai panduan PRD.
            </p>
        </div>
    </div>
</div>
@endsection
