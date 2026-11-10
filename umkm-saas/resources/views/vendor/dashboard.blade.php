@extends('layouts.app', ['title' => 'Dashboard Vendor Platform'])

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Header Vendor -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-semibold mb-2 border border-purple-200">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-600"></span>
                <span>Area Vendor Platform</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                Dashboard Ringkasan Platform
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Pantau angka agregat seluruh ekosistem UMKM dan daftar UMKM terdaftar (Mode Baca Saja).
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.export') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold shadow-sm transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Ekspor Rekap CSV (Agregat)</span>
            </a>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                Login: {{ $user->name }}
            </span>
        </div>
    </div>

    <!-- Stat Cards: Angka Agregat Ekosistem Platform -->
    <div>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ringkasan Agregat Ekosistem</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Card 1: Total UMKM -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total UMKM Terdaftar</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['total_organizations'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">organisasi</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500">
                    Ekosistem platform aktif
                </div>
            </div>

            <!-- Card 2: Total Produk Agregat -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total Produk Seluruh UMKM</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-blue-600 tracking-tight">{{ $stats['total_products'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">item produk</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500">
                    Angka agregat platform
                </div>
            </div>

            <!-- Card 3: Total Pertanyaan Agregat -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500">Total Pertanyaan Masuk</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $stats['total_inquiries'] }}</span>
                    <span class="text-xs text-slate-500 ml-1">pertanyaan</span>
                </div>
                <div class="mt-2 text-[11px] text-slate-500">
                    Angka saja, tanpa isi pesan
                </div>
            </div>
        </div>
    </div>

    <!-- Layar 5: Daftar UMKM Vendor (Mode Baca Saja) -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>Daftar UMKM Terdaftar (Mode Baca Saja)</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Vendor bebas melihat daftar seluruh UMKM yang tergabung dalam ekosistem platform.
                </p>
            </div>
            <div class="text-xs text-slate-400 font-medium">
                Total: {{ $organizations->count() }} UMKM
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Nama UMKM</th>
                        <th scope="col" class="px-6 py-3.5">Slug URL</th>
                        <th scope="col" class="px-6 py-3.5">Kategori</th>
                        <th scope="col" class="px-6 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($organizations as $org)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-semibold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($org->name, 0, 1)) }}
                                </div>
                                <span>{{ $org->name }}</span>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-500">
                                <span class="bg-slate-100 px-2 py-0.5 rounded text-[11px] text-slate-600">/u/{{ $org->slug }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                    {{ $org->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($org->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-8 h-8 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="font-medium text-slate-600 text-xs">Belum ada UMKM terdaftar</p>
                                    <p class="text-[11px] text-slate-400">Pendaftaran UMKM baru akan otomatis muncul pada tabel ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Security Isolation Notice -->
    <div class="p-4 rounded-xl bg-purple-50/70 border border-purple-200 text-xs text-purple-900 flex items-start gap-3">
        <svg class="w-4 h-4 text-purple-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <span class="font-semibold text-purple-950">Prinsip Keamanan Siber (Privasi Data UMKM):</span>
            <span> Vendor hanya diizinkan melihat daftar profil UMKM dan angka agregat total. Vendor <strong>dilarang keras dan diblokir secara sistem</strong> untuk membaca isi pesan pertanyaan pengunjung maupun mengubah produk milik UMKM lain.</span>
        </div>
    </div>
</div>
@endsection
