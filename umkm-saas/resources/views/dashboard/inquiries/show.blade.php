@extends('layouts.app', ['title' => 'Detail Pertanyaan - ' . $inquiry->visitor_name])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb & Header Navigasi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span>/</span>
                <a href="{{ route('inquiries.index') }}" class="hover:text-blue-600 transition">Pertanyaan Masuk</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Detail #{{ $inquiry->id }}</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Pesan dari {{ $inquiry->visitor_name }}</span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('inquiries.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Main Card Detail Pesan -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden divide-y divide-slate-100">
        <!-- Informasi Header Pengirim & Status -->
        <div class="p-6 sm:p-8 bg-slate-50/60">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg shrink-0">
                        {{ strtoupper(substr($inquiry->visitor_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-bold text-slate-900">{{ $inquiry->visitor_name }}</h2>
                            <span class="text-xs text-slate-400">#{{ $inquiry->id }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5 flex flex-wrap items-center gap-2">
                            <span>Diterima pada {{ $inquiry->created_at->format('d F Y, H:i') }} WIB</span>
                            <span>&bull;</span>
                            <span>{{ $inquiry->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-400">Status Saat Ini:</span>
                    @if($inquiry->status === 'Baru')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Baru</span>
                        </span>
                    @elseif($inquiry->status === 'Dibalas')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>Dibalas</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Selesai</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Kontak Pengirim & Tombol Hubungi Cepat -->
            <div class="mt-6 pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div>
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-[11px] block">Kontak Balasan</span>
                    @if($inquiry->visitor_contact)
                        <span class="font-bold text-slate-800 text-sm font-mono">{{ $inquiry->visitor_contact }}</span>
                    @else
                        <span class="text-slate-400 italic">Pengunjung tidak mencantumkan kontak email atau telepon.</span>
                    @endif
                </div>

                @if($inquiry->visitor_contact)
                    @php
                        $cleanContact = preg_replace('/[^0-9]/', '', $inquiry->visitor_contact);
                        if (str_starts_with($cleanContact, '0')) {
                            $cleanContact = '62' . substr($cleanContact, 1);
                        }
                        $isPossiblePhone = strlen($cleanContact) >= 8;
                        $isEmail = filter_var($inquiry->visitor_contact, FILTER_VALIDATE_EMAIL);
                    @endphp

                    <div class="flex items-center gap-2">
                        @if($isPossiblePhone)
                            <a href="https://wa.me/{{ $cleanContact }}?text={{ urlencode('Halo ' . $inquiry->visitor_name . ', kami dari ' . ($organization->name ?? 'UMKM') . ' menindaklanjuti pertanyaan Anda mengenai: ' . \Illuminate\Support\Str::limit($inquiry->message, 40)) }}"
                                target="_blank"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z" />
                                </svg>
                                <span>Balas via WhatsApp</span>
                            </a>
                        @endif

                        @if($isEmail)
                            <a href="mailto:{{ $inquiry->visitor_contact }}?subject={{ urlencode('Tanggapan Pertanyaan dari ' . ($organization->name ?? 'UMKM')) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Kirim Email</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Isi Pesan Lengkap (Di-escape secara aman: anti-XSS) -->
        <div class="p-6 sm:p-8 space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Isi Pesan Pertanyaan</span>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-sm leading-relaxed whitespace-pre-wrap font-sans">
                {{-- Seluruh teks pesan di-escape untuk anti-XSS, baris baru diformat dengan aman --}}
                {!! nl2br(e($inquiry->message)) !!}
            </div>
        </div>

        <!-- Kontrol Alur Status & Tombol Tindakan -->
        <div class="p-6 sm:p-8 bg-slate-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold text-slate-700 mr-1">Ubah Status:</span>

                <!-- Tombol Tandai Dibalas -->
                @if($inquiry->status !== 'Dibalas')
                    <form method="POST" action="{{ route('inquiries.update-status', $inquiry) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Dibalas">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            <span>Tandai Dibalas</span>
                        </button>
                    </form>
                @endif

                <!-- Tombol Tandai Selesai -->
                @if($inquiry->status !== 'Selesai')
                    <form method="POST" action="{{ route('inquiries.update-status', $inquiry) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Selesai">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tandai Selesai</span>
                        </button>
                    </form>
                @endif

                <!-- Tombol Buka Lagi (Kembalikan ke 'Baru') -->
                @if($inquiry->status !== 'Baru')
                    <form method="POST" action="{{ route('inquiries.update-status', $inquiry) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Baru">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-xs transition">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Buka Lagi</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Tombol Hapus Pertanyaan -->
            <div>
                <button type="button" onclick="openDeleteModal()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus Pertanyaan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Pertanyaan -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 id="deleteModalTitle" class="text-base font-bold text-slate-900">
                    Konfirmasi Hapus Pesan
                </h3>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                    Apakah Anda yakin ingin menghapus pesan dari <strong>{{ $inquiry->visitor_name }}</strong>? Pesan yang dihapus tidak dapat dipulihkan kembali.
                </p>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-2.5">
            <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition">
                Batal
            </button>
            <form method="POST" action="{{ route('inquiries.destroy', $inquiry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition">
                    Ya, Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
