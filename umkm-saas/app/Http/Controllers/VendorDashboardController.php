<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Organization;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VendorDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Vendor Platform (Layar 4) & Daftar UMKM mode baca saja (Layar 5).
     * Angka agregat seluruh ekosistem tanpa menampilkan isi pesan UMKM.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Metrik Agregat Ekosistem Platform
        $totalOrganizations = Organization::count();
        $totalProducts = Product::aggregateCount();
        $totalInquiries = Inquiry::aggregateCount(); // Angka saja, bukan isi pesan

        // Daftar UMKM vendor (mode baca saja): nama, slug, kategori, aktif/tidak
        $organizations = Organization::latest()->get([
            'id',
            'name',
            'slug',
            'category',
            'is_active',
            'created_at',
        ]);

        return view('vendor.dashboard', [
            'user' => $user,
            'stats' => [
                'total_organizations' => $totalOrganizations,
                'total_products' => $totalProducts,
                'total_inquiries' => $totalInquiries,
            ],
            'organizations' => $organizations,
        ]);
    }
}

