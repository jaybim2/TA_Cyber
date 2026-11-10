@extends('layouts.app', ['title' => 'Edit Produk: ' . $product->name])

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="pb-4 border-b border-slate-200">
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5 font-medium">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition">Katalog Produk</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Edit Produk</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                    Edit Produk: {{ $product->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Perbarui informasi, harga, atau status visibilitas produk ini.
                </p>
            </div>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-slate-900 text-xs font-semibold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Error Global Notice -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs shadow-sm">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Terdapat kesalahan pada formulir produk:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir Edit Produk -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nama Produk <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" required maxlength="150"
                    value="{{ old('name', $product->name) }}"
                    placeholder="Contoh: Peyeum Keju, Keripik Singkong Renyah"
                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 mt-1">Maksimal 150 karakter.</p>
            </div>

            <!-- Grid Kategori & Harga -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Kategori Dropdown -->
                <div>
                    <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">
                        Kategori Produk <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" id="category" required
                        class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('category') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @php
                            $currentCategory = old('category', $product->category);
                            $predefinedCategories = [
                                'Kuliner',
                                'Makanan & Minuman',
                                'Fashion & Pakaian',
                                'Kerajinan & Seni',
                                'Pertanian & Perkebunan',
                                'Kecantikan & Kesehatan',
                                'Jasa & Layanan',
                                'Lainnya',
                            ];
                        @endphp
                        @if(!in_array($currentCategory, $predefinedCategories) && !empty($currentCategory))
                            <option value="{{ $currentCategory }}" selected>{{ $currentCategory }} (Kategori Tersimpan)</option>
                        @endif
                        @foreach($predefinedCategories as $catOption)
                            <option value="{{ $catOption }}" {{ $currentCategory === $catOption ? 'selected' : '' }}>
                                {{ $catOption }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Produk -->
                <div>
                    <label for="price" class="block text-xs font-semibold text-slate-700 mb-1">
                        Harga (Rupiah) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs font-semibold">
                            Rp
                        </div>
                        <input type="number" name="price" id="price" required min="0" step="1000"
                            value="{{ old('price', (int)$product->price) }}"
                            placeholder="75000"
                            class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('price') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    @error('price')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-slate-400 mt-1">Harus berupa angka positif atau 0 (gratis/kontak kami).</p>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 mb-1">
                    Deskripsi Produk (Opsional)
                </label>
                <textarea name="description" id="description" rows="4" maxlength="1000"
                    placeholder="Tuliskan spesifikasi, keunggulan, varian rasa, ukuran, atau bahan produk..."
                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('description') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 mt-1">Maksimal 1000 karakter. Seluruh output di-escape secara aman.</p>
            </div>

            <!-- URL Foto Produk -->
            <div>
                <label for="photo_url" class="block text-xs font-semibold text-slate-700 mb-1">
                    URL Foto Produk (Opsional)
                </label>
                <input type="url" name="photo_url" id="photo_url" maxlength="500"
                    value="{{ old('photo_url', $product->photo_url) }}"
                    placeholder="https://images.unsplash.com/... atau link foto web publik"
                    class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('photo_url') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('photo_url')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
                @if($product->photo_url)
                    <div class="mt-2 flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                        <img src="{{ $product->photo_url }}" alt="Preview Foto" class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                        <span class="text-xs text-slate-500">Preview foto produk yang saat ini tersimpan.</span>
                    </div>
                @endif
            </div>

            <!-- Status Tampil / Sembunyi -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <label class="block text-xs font-bold text-slate-800 mb-2">
                    Status Publikasi Produk <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-emerald-500 transition">
                        <input type="radio" name="status" value="Tampil"
                            {{ old('status', $product->status) === 'Tampil' ? 'checked' : '' }}
                            class="mt-1 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Tampil di Publik
                            </span>
                            <span class="text-[11px] text-slate-500">
                                Produk langsung dapat dilihat oleh pengunjung di website profil UMKM Anda.
                            </span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-amber-500 transition">
                        <input type="radio" name="status" value="Sembunyi"
                            {{ old('status', $product->status) === 'Sembunyi' ? 'checked' : '' }}
                            class="mt-1 text-amber-600 focus:ring-amber-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Sembunyi (Draft)
                            </span>
                            <span class="text-[11px] text-slate-500">
                                Produk disimpan di katalog dashboard, tetapi disembunyikan dari halaman publik.
                            </span>
                        </div>
                    </label>
                </div>
                @error('status')
                    <p class="text-rose-600 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('products.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm hover:shadow transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

