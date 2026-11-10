@extends('layouts.app', ['title' => 'Dashboard Vendor Platform'])

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Area Vendor Platform</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola ekosistem UMKM dan pantau ringkasan agregat platform.
            </p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                Vendor Platform Terverifikasi
            </span>
        </div>
    </div>

    <!-- Info Card Vendor -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm mb-6">
        <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
            <div class="w-14 h-14 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-2xl shadow-sm">
                V
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }} &bull; Peran: Vendor Pengelola Platform</p>
            </div>
        </div>

        <div class="pt-6">
            <div class="rounded-xl border border-purple-200 bg-purple-50/70 p-5 text-sm text-purple-900 flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div class="space-y-1">
                    <p class="font-semibold text-purple-950">Akses Khusus Vendor Berhasil Diotentikasi</p>
                    <p class="text-xs text-purple-800 leading-relaxed">
                        Anda berada di area terisolasi vendor (`/vendor`). Rute ini terlindungi oleh middleware otorisasi peran sehingga tidak dapat diakses oleh Admin UMKM maupun publik. Fitur statistik agregat dan kelola daftar UMKM akan diisi pada Task T08.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
