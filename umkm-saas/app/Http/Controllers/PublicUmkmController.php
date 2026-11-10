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
        $organization = Organization::withoutTenant()
            ->where('slug', $slug)
            ->firstOrFail();

        // Ambil produk Tampil saja
        $products = Product::withoutTenant()
            ->where('organization_id', $organization->id)
            ->where('status', 'Tampil')
            ->get();

        return view('public.umkm', [
            'organization' => $organization,
            'products' => $products,
        ]);
    }
}
