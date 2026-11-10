@extends('layouts.app', ['title' => 'Katalog Produk - ' . ($organization->name ?? 'Admin')])

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1.5 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Katalog Produk</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Katalog Produk</span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">
                    {{ $products->total() }} Produk
                </span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola daftar produk dan layanan yang ditampilkan pada halaman profil UMKM Anda.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm hover:shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <!-- Pencarian Nama -->
            <div class="sm:col-span-5">
                <label for="q" class="block text-xs font-semibold text-slate-700 mb-1">Cari Produk</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="{{ $filters['q'] ?? '' }}"
                        placeholder="Ketik nama produk..."
                        class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="sm:col-span-3">
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                <select name="category" id="category"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ ($filters['category'] ?? '') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-2">
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="Tampil" {{ ($filters['status'] ?? '') === 'Tampil' ? 'selected' : '' }}>Tampil</option>
                    <option value="Sembunyi" {{ ($filters['status'] ?? '') === 'Sembunyi' ? 'selected' : '' }}>Sembunyi</option>
                </select>
            </div>

            <!-- Tombol Aksi Filter -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
                @if(!empty($filters['q']) || !empty($filters['category']) || !empty($filters['status']))
                    <a href="{{ route('products.index') }}"
                        title="Reset filter pencarian"
                        class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Produk -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-16 text-center">Foto</th>
                            <th scope="col" class="py-3.5 px-4">Nama Produk &amp; Deskripsi</th>
                            <th scope="col" class="py-3.5 px-4">Kategori</th>
                            <th scope="col" class="py-3.5 px-4">Harga</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Foto Produk -->
                                <td class="py-3 px-4 text-center">
                                    @if($product->photo_url)
                                        <img src="{{ $product->photo_url }}" alt="{{ $product->name }}"
                                            class="w-12 h-12 rounded-lg object-cover mx-auto border border-slate-200 bg-slate-100"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs mx-auto border border-blue-100\'>{{ substr($product->name, 0, 1) }}</div>';">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs mx-auto border border-slate-200">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <!-- Nama & Deskripsi -->
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ $product->name }}
                                    </div>
                                    @if($product->description)
                                        <p class="text-slate-500 text-xs mt-0.5 line-clamp-1 max-w-md">
                                            {{ $product->description }}
                                        </p>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">Tanpa deskripsi</span>
                                    @endif
                                </td>

                                <!-- Kategori -->
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $product->category }}
                                    </span>
                                </td>

                                <!-- Harga -->
                                <td class="py-3 px-4 font-bold text-slate-900 font-mono text-xs">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                <!-- Status -->
                                <td class="py-3 px-4 text-center">
                                    @if($product->status === 'Tampil')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Tampil</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Sembunyi</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-3 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:text-blue-600 hover:bg-blue-50 text-xs font-semibold transition"
                                            title="Edit data produk">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('products.destroy', $product) }}', '{{ addslashes($product->name) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-semibold transition"
                                            title="Hapus produk">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($products->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Zero State / Hasil Pencarian Kosong -->
            <div class="py-12 px-4 text-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border border-blue-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada produk ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if(!empty($filters['q']) || !empty($filters['category']) || !empty($filters['status']))
                        Tidak ada produk yang sesuai dengan kriteria filter pencarian Anda. Silakan coba kata kunci lain atau reset filter.
                    @else
                        Katalog produk UMKM Anda masih kosong. Mulai tambahkan produk atau paket layanan pertama Anda sekarang!
                    @endif
                </p>
                <div class="mt-4 flex items-center justify-center gap-2">
                    @if(!empty($filters['q']) || !empty($filters['category']) || !empty($filters['status']))
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            <span>Reset Filter</span>
                        </a>
                    @endif
                    <a href="{{ route('products.create') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Produk Baru</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus Produk -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm hidden" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 animate-scale-in">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 id="deleteModalTitle" class="text-base font-bold text-slate-900">
                    Konfirmasi Hapus Produk
                </h3>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                    Apakah Anda yakin ingin menghapus produk <strong id="modalProductName" class="text-slate-900 font-bold"></strong> dari katalog?
                </p>
                <div class="mt-2 p-2.5 rounded-lg bg-rose-50 border border-rose-100 text-[11px] text-rose-700">
                    Peringatan: Produk ini akan dihapus secara permanen dari katalog dan tidak akan lagi muncul di halaman website profil publik UMKM Anda.
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-2.5">
            <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition">
                Batal
            </button>
            <form id="deleteProductForm" method="POST" action="" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition">
                    Ya, Hapus Produk
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, productName) {
        document.getElementById('deleteProductForm').setAttribute('action', actionUrl);
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Tutup modal jika user menekan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Tutup modal jika user klik di luar area modal content
    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection

