@extends('layouts.app', ['title' => 'Kelola Profil UMKM - ' . $organization->name])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span>/</span>
                <span class="text-blue-600">Kelola Profil UMKM</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Profil Usaha</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Perbarui identitas profil, informasi kontak, dan tautan website publik UMKM Anda.
            </p>
        </div>
    </div>

    <!-- Live Public Link Card (Komponen Interaktif Link Publik) -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-xs font-bold text-blue-700 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Link Website Publik Anda
                </span>
                <p class="text-xs text-slate-600">
                    Alamat web yang dapat dibagikan kepada pelanggan untuk melihat profil dan katalog Anda.
                </p>
                <div class="pt-1">
                    <span id="publicUrlText" class="font-mono text-sm sm:text-base font-bold text-blue-900 break-all select-all">
                        {{ url('/u/' . $organization->slug) }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <!-- Tombol Salin Link -->
                <button type="button" id="copyBtn" onclick="copyPublicLink()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold border border-slate-300 shadow-sm transition active:scale-95">
                    <svg id="copyIcon" class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    <span id="copyText">Salin Link</span>
                </button>

                <!-- Tombol Lihat Halaman -->
                <a id="viewPageBtn" href="{{ url('/u/' . $organization->slug) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                    <span>Lihat Halaman</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Form Kelola Profil UMKM -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <form action="{{ route('umkm.profile.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Nama UMKM -->
                <div class="sm:col-span-1">
                    <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama UMKM <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $organization->name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('name') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bidang Usaha (Kategori) -->
                <div class="sm:col-span-1">
                    <label for="category" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Bidang Usaha (Kategori) <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" id="category" required
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('category') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                        @php
                            $categories = ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Toko Kelontong', 'Lainnya'];
                        @endphp
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $organization->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug URL Publik -->
                <div class="sm:col-span-2">
                    <label for="slug" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Slug Alamat Web Publik <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-3.5 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-xs select-none">
                            {{ url('/u') }}/
                        </span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $organization->slug) }}" required
                            placeholder="peyeum-kuningan"
                            class="flex-1 min-w-0 block w-full px-3.5 py-2.5 rounded-none rounded-r-lg border @error('slug') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Hanya huruf kecil, angka, dan tanda hubung (-). Mengubah slug akan langsung mengubah URL publik UMKM Anda.
                    </p>
                    @error('slug')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon / WhatsApp (WAJIB DIISI) -->
                <div class="sm:col-span-1">
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $organization->phone) }}" required
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('phone') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Kontak Admin -->
                <div class="sm:col-span-1">
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Email Kontak Admin <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        placeholder="admin@domain.com"
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('email') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Buka -->
                <div class="sm:col-span-2">
                    <label for="opening_hours" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jam Operasional / Jam Buka
                    </label>
                    <input type="text" name="opening_hours" id="opening_hours" value="{{ old('opening_hours', $organization->opening_hours) }}"
                        placeholder="Contoh: Setiap Hari, 08:00 - 20:00 WIB"
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('opening_hours') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @error('opening_hours')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Fisik -->
                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Usaha
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $organization->address) }}"
                        placeholder="Contoh: Jl. Siliwangi No. 12, Kuningan, Jawa Barat"
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('address') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @error('address')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Sampul URL (Opsional) -->
                <div class="sm:col-span-2">
                    <label for="cover_url" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Sampul URL (Opsional)
                    </label>
                    <input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url') }}"
                        placeholder="https://images.unsplash.com/photo-..."
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('cover_url') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Tautan gambar langsung (HTTPS) untuk latar belakang header profil publik.</p>
                    @error('cover_url')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Profil UMKM -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi Lengkap Profil UMKM
                    </label>
                    <textarea name="description" id="description" rows="4"
                        placeholder="Ceritakan sejarah, keunggulan produk, dan keunikan usaha UMKM Anda..."
                        class="w-full px-3.5 py-2.5 rounded-lg border @error('description') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('description', $organization->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi Simpan -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm hover:shadow transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Interaktif untuk Live Link & Salin Clipboard -->
<script>
    const baseUrl = "{{ url('/u') }}";
    const slugInput = document.getElementById('slug');
    const publicUrlText = document.getElementById('publicUrlText');
    const viewPageBtn = document.getElementById('viewPageBtn');

    // Live update preview link publik saat slug diubah
    slugInput.addEventListener('input', function() {
        const cleanSlug = slugInput.value.trim().toLowerCase();
        const newUrl = baseUrl + '/' + cleanSlug;
        publicUrlText.textContent = newUrl;
        viewPageBtn.setAttribute('href', newUrl);
    });

    // Salin Link ke Clipboard dengan Feedback Visual
    function copyPublicLink() {
        const urlToCopy = publicUrlText.textContent.trim();
        navigator.clipboard.writeText(urlToCopy).then(function() {
            const copyText = document.getElementById('copyText');
            const copyBtn = document.getElementById('copyBtn');
            const originalText = copyText.textContent;

            copyText.textContent = 'Tersalin!';
            copyBtn.classList.remove('bg-white', 'text-slate-700');
            copyBtn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');

            setTimeout(function() {
                copyText.textContent = originalText;
                copyBtn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                copyBtn.classList.add('bg-white', 'text-slate-700');
            }, 2000);
        }).catch(function(err) {
            alert('Gagal menyalin link: ' + err);
        });
    }
</script>
@endsection
