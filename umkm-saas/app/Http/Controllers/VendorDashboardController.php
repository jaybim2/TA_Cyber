<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Organization;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * Ekspor rekap agregat ekosistem UMKM untuk vendor.
     * HANYA berisi angka agregat dan data status UMKM, TANPA ISI PESAN (Sesuai Aturan Global #3).
     */
    public function exportCsv(): StreamedResponse
    {
        $filename = 'Rekap_Ekosistem_Vendor_' . date('Y-m-d') . '.csv';

        $organizations = Organization::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($organizations) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fputs($file, "\xEF\xBB\xBF");

            // Header Agregat (tanpa isi pesan)
            fputcsv($file, [
                'No',
                'Nama UMKM',
                'Slug Halaman',
                'Kategori Usaha',
                'Status Operasional',
                'Tanggal Terdaftar',
                'Total Produk',
                'Produk Tampil',
                'Total Pertanyaan Masuk',
                'Pertanyaan Perlu Tindak Lanjut (Baru)',
            ]);

            $no = 1;
            foreach ($organizations as $org) {
                $totalProd = Product::withoutTenant()->where('organization_id', $org->id)->count();
                $activeProd = Product::withoutTenant()->where('organization_id', $org->id)->where('status', 'Tampil')->count();
                $totalInq = Inquiry::withoutTenant()->where('organization_id', $org->id)->count();
                $baruInq = Inquiry::withoutTenant()->where('organization_id', $org->id)->where('status', 'Baru')->count();

                fputcsv($file, [
                    $no++,
                    $this->sanitizeCsvField($org->name),
                    $org->slug,
                    $this->sanitizeCsvField($org->category),
                    $org->is_active ? 'Aktif' : 'Nonaktif',
                    $org->created_at->format('Y-m-d H:i:s'),
                    $totalProd,
                    $activeProd,
                    $totalInq,
                    $baruInq,
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Sanitasi anti-CSV Formula Injection.
     */
    protected function sanitizeCsvField(?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $dangerousPrefixes = ['=', '+', '-', '@', "\t", "\r"];
        $firstChar = substr($value, 0, 1);

        if (in_array($firstChar, $dangerousPrefixes, true)) {
            return "'" . $value;
        }

        return $value;
    }
}

