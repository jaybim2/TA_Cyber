<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Product;
use Illuminate\View\View;

class PublicUmkmController extends Controller
{
    /**
     * Tampilkan Halaman Publik Profil UMKM (Layar 11).
     * Dapat diakses oleh publik tanpa login.
     */
    public function show(string $slug): View
    {
        // 1. Cari organisasi berdasarkan slug (tanpa batasan scope tenant)
        $organization = Organization::withoutTenant()
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Jika UMKM nonaktif, produk TIDAK tampil sama sekali
        if (!$organization->is_active) {
            return view('public.umkm', [
                'organization' => $organization,
                'products' => collect(),
                'categories' => collect(),
                'adminEmail' => null,
            ]);
        }

        // 3. Hanya ambil produk dengan status 'Tampil' (produk 'Sembunyi' tidak pernah dimuat)
        $products = Product::withoutTenant()
            ->where('organization_id', $organization->id)
            ->where('status', 'Tampil')
            ->orderBy('id', 'asc')
            ->get();

        // Ambil daftar kategori produk unik untuk chip filter
        $categories = $products->pluck('category')->unique()->filter()->values();

        // Ambil email admin pengelola untuk kontak
        $adminEmail = $organization->users()->first()?->email;

        return view('public.umkm', [
            'organization' => $organization,
            'products' => $products,
            'categories' => $categories,
            'adminEmail' => $adminEmail,
        ]);
    }
}
