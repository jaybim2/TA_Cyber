@extends('layouts.app', ['title' => 'Pertanyaan Masuk - ' . ($organization->name ?? 'Admin')])

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Pertanyaan Masuk</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Daftar Pertanyaan Masuk</span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">
                    {{ $inquiries->total() }} Pesan
                </span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola dan tindak lanjuti pesan masuk dari calon pembeli atau pengunjung halaman profil UMKM Anda.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if(isset($organization->slug))
                <a href="{{ url('/u/' . $organization->slug . '#pertanyaan') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold border border-slate-200 shadow-sm transition">
                    <span>Lihat Form Publik</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Tab Filter Status -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-2">
        <a href="{{ route('inquiries.index', array_filter(['q' => $filters['q'] ?? null])) }}"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ empty($filters['status']) ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua Pesan ({{ $counts['all'] }})
        </a>
        <a href="{{ route('inquiries.index', array_filter(['status' => 'Baru', 'q' => $filters['q'] ?? null])) }}"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ ($filters['status'] ?? '') === 'Baru' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full {{ ($filters['status'] ?? '') === 'Baru' ? 'bg-white' : 'bg-rose-500' }}"></span>
            <span>Baru ({{ $counts['baru'] }})</span>
        </a>
        <a href="{{ route('inquiries.index', array_filter(['status' => 'Dibalas', 'q' => $filters['q'] ?? null])) }}"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ ($filters['status'] ?? '') === 'Dibalas' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full {{ ($filters['status'] ?? '') === 'Dibalas' ? 'bg-white' : 'bg-amber-500' }}"></span>
            <span>Dibalas ({{ $counts['dibalas'] }})</span>
        </a>
        <a href="{{ route('inquiries.index', array_filter(['status' => 'Selesai', 'q' => $filters['q'] ?? null])) }}"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 {{ ($filters['status'] ?? '') === 'Selesai' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full {{ ($filters['status'] ?? '') === 'Selesai' ? 'bg-white' : 'bg-emerald-500' }}"></span>
            <span>Selesai ({{ $counts['selesai'] }})</span>
        </a>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <form method="GET" action="{{ route('inquiries.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <!-- Hidden status jika sedang difilter tab -->
            @if(!empty($filters['status']))
                <input type="hidden" name="status" value="{{ $filters['status'] }}">
            @endif

            <!-- Pencarian Kata Kunci -->
            <div class="sm:col-span-8">
                <label for="q" class="block text-xs font-semibold text-slate-700 mb-1">Cari Pertanyaan</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="{{ $filters['q'] ?? '' }}"
                        placeholder="Ketik nama pengunjung, kontak, atau isi pesan..."
                        class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Tombol Aksi Pencarian -->
            <div class="sm:col-span-4 flex items-center gap-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari Pesan</span>
                </button>
                @if(!empty($filters['q']) || !empty($filters['status']))
                    <a href="{{ route('inquiries.index') }}"
                        title="Reset semua filter pencarian"
                        class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Pertanyaan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($inquiries->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-36">Waktu Masuk</th>
                            <th scope="col" class="py-3.5 px-4 w-48">Pengirim &amp; Kontak</th>
                            <th scope="col" class="py-3.5 px-4">Ringkasan Pesan</th>
                            <th scope="col" class="py-3.5 px-4 text-center w-28">Status</th>
                            <th scope="col" class="py-3.5 px-4 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-slate-50/80 transition {{ $inquiry->status === 'Baru' ? 'bg-rose-50/20' : '' }}">
                                <!-- Waktu Masuk -->
                                <td class="py-3.5 px-4 whitespace-nowrap text-slate-500">
                                    <div class="font-semibold text-slate-800">{{ $inquiry->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $inquiry->created_at->format('H:i') }} WIB</div>
                                </td>

                                <!-- Nama & Kontak -->
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ $inquiry->visitor_name }}
                                    </div>
                                    @if($inquiry->visitor_contact)
                                        <div class="text-[11px] text-blue-600 font-mono mt-0.5 truncate max-w-xs">
                                            {{ $inquiry->visitor_contact }}
                                        </div>
                                    @else
                                        <div class="text-[11px] text-slate-400 italic mt-0.5">
                                            Tanpa kontak
                                        </div>
                                    @endif
                                </td>

                                <!-- Pesan (Di-escape secara aman) -->
                                <td class="py-3.5 px-4">
                                    <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed">
                                        {{ $inquiry->message }}
                                    </p>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($inquiry->status === 'Baru')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Baru</span>
                                        </span>
                                    @elseif($inquiry->status === 'Dibalas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Dibalas</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Selesai</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('inquiries.show', $inquiry) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold transition"
                                        title="Buka detail pertanyaan">
                                        <span>Buka</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($inquiries->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $inquiries->links() }}
                </div>
            @endif
        @else
            <!-- Zero State / Kosong -->
            <div class="py-12 px-4 text-center">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 border border-amber-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada pertanyaan ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if(!empty($filters['q']) || !empty($filters['status']))
                        Tidak ada pertanyaan yang sesuai dengan filter pencarian Anda. Silakan coba reset filter.
                    @else
                        Belum ada pertanyaan masuk dari pengunjung untuk saat ini. Form pertanyaan aktif di halaman profil publik Anda.
                    @endif
                </p>
                @if(!empty($filters['q']) || !empty($filters['status']))
                    <div class="mt-4">
                        <a href="{{ route('inquiries.index') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            <span>Reset Filter</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

