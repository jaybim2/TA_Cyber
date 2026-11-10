@extends('layouts.app', ['title' => 'Daftar UMKM Baru'])

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-3 border border-blue-200">
            <span>🚀 Mulai Dalam 1 Menit</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Daftarkan UMKM Anda</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-lg mx-auto">
            Buat website profil dan katalog siap pakai sekarang. Dikelola mudah dari dashboard dengan keamanan tingkat tinggi.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
            <div class="font-semibold flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Mohon periksa kembali formulir pendaftaran:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <form action="{{ url('/register-umkm') }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- Bagian 1: Data Profil UMKM -->
            <div>
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                        1
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Profil Usaha / UMKM</h2>
                        <p class="text-xs text-slate-500">Informasi utama bisnis yang akan tampil pada halaman publik website Anda.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama UMKM -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama UMKM <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            placeholder="Contoh: Peyeum Khas Kuningan"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('name') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('name')
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
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                placeholder="peyeum-kuningan"
                                class="flex-1 min-w-0 block w-full px-3.5 py-2.5 rounded-none rounded-r-lg border @error('slug') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">Hanya huruf kecil, angka, dan tanda hubung (-). Tanpa spasi.</p>
                        @error('slug')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="sm:col-span-1">
                        <label for="category" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori Usaha <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" id="category" required
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('category') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @php
                                $categories = ['Kuliner', 'Fashion', 'Kerajinan', 'Jasa', 'Pertanian', 'Toko Kelontong', 'Lainnya'];
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon / WA -->
                    <div class="sm:col-span-1">
                        <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Telepon / WhatsApp
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('phone') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('phone')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Buka -->
                    <div class="sm:col-span-2">
                        <label for="opening_hours" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jam Operasional
                        </label>
                        <input type="text" name="opening_hours" id="opening_hours" value="{{ old('opening_hours') }}"
                            placeholder="Contoh: Setiap Hari, 08:00 - 20:00 WIB"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('opening_hours') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('opening_hours')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Usaha
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                            placeholder="Contoh: Jl. Siliwangi No. 45, Kuningan, Jawa Barat"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('address') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('address')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi UMKM -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Singkat UMKM
                        </label>
                        <textarea name="description" id="description" rows="3"
                            placeholder="Ceritakan keunggulan produk dan bisnis UMKM Anda secara singkat..."
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('description') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Data Akun Admin UMKM -->
            <div>
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        2
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Akun Pengelola (Admin UMKM)</h2>
                        <p class="text-xs text-slate-500">Akun ini memiliki hak akses penuh untuk mengelola katalog, pertanyaan, dan profil usaha.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Admin -->
                    <div class="sm:col-span-1">
                        <label for="admin_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Admin <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="admin_name" id="admin_name" value="{{ old('admin_name') }}" required
                            placeholder="Contoh: Budi Santoso"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('admin_name') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('admin_name')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Admin -->
                    <div class="sm:col-span-1">
                        <label for="admin_email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email Admin (Untuk Login) <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required
                            placeholder="admin@peyeum.test"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('admin_email') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('admin_email')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Admin -->
                    <div class="sm:col-span-2">
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Password Admin <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                            placeholder="Minimal 8 karakter kombinasi huruf & angka"
                            class="w-full px-3.5 py-2.5 rounded-lg border @error('password') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Standar Keamanan: Minimal 8 karakter, kombinasi huruf dan angka. Password lemah (seperti 123456) ditolak otomatis.</span>
                        </p>
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Submit & Aksi -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500 text-center sm:text-left">
                    Dengan mendaftar, Anda menyetujui ketentuan platform SaaS UMKM.
                </p>
                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 shadow-sm hover:shadow transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span>Daftarkan UMKM & Masuk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug dari nama UMKM jika input slug belum diubah manual
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    let userEditedSlug = false;

    slugInput.addEventListener('input', function() {
        userEditedSlug = true;
    });

    nameInput.addEventListener('input', function() {
        if (!userEditedSlug) {
            const slug = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });
</script>
@endsection

