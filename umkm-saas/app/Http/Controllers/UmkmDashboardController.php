<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UmkmDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Admin UMKM (Layar 6).
     * Semua query otomatis dibatasi ke organization_id milik user login via TenantScope.
     */
    public function index(): View
    {
        $user = Auth::user();
        $organization = $user->organization;

        // Metrik Produk milik UMKM yang login
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'Tampil')->count();
        $hiddenProducts = Product::where('status', 'Sembunyi')->count();

        // Metrik Pertanyaan per status milik UMKM yang login
        $inquiriesBaru = Inquiry::where('status', 'Baru')->count();
        $inquiriesDibalas = Inquiry::where('status', 'Dibalas')->count();
        $inquiriesSelesai = Inquiry::where('status', 'Selesai')->count();
        $totalInquiries = Inquiry::count();

        return view('dashboard', [
            'user' => $user,
            'organization' => $organization,
            'stats' => [
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'hidden_products' => $hiddenProducts,
                'inquiries_baru' => $inquiriesBaru,
                'inquiries_dibalas' => $inquiriesDibalas,
                'inquiries_selesai' => $inquiriesSelesai,
                'total_inquiries' => $totalInquiries,
            ],
        ]);
    }
}
