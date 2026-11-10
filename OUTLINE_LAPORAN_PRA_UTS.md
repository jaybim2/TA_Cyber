# Outline Laporan Tugas Besar Cyber Security (Pra-UTS)

**Judul Proyek:** Pengembangan Platform Website Profil dan Katalog Siap Pakai Berbasis Web dengan Model SaaS untuk UMKM  
**Mata Kuliah:** Keamanan Siber / Cyber Security  
**Format Penyerahan:** Dokumen Laporan PDF Resmi, Repositori Git, dan URL Live FQDN + HTTPS

---

## DAFTAR ISI LAPORAN

1. **HALAMAN JUDUL & IDENTITAS**
   - Judul Tugas Besar / Pra-UTS
   - Nama Mahasiswa, NIM, Program Studi, Fakultas, Perguruan Tinggi
   - Tanggal dan Semester Akademik

2. **BAB I: PENDAHULUAN**
   - **1.1 Latar Belakang:** Kebutuhan digitalisasi jutaan UMKM Indonesia yang terkendala biaya pembuatan website mandiri, kompleksitas pemeliharaan teknis, serta risiko keamanan siber pada website UMKM yang rentan peretasan (web defacement, pencurian data pesan pelanggan, dan serangan injeksi).
   - **1.2 Rumusan Masalah:** Bagaimana merancang platform SaaS multi-tenant yang memungkinkan UMKM memiliki website profil dan katalog siap pakai dalam hitungan detik dengan jaminan isolasi keamanan data yang ketat antar-penyewa?
   - **1.3 Tujuan Proyek:**
     - Mengembangkan platform web multi-tenant siap pakai dengan alokasi URL unik `/u/{slug}` per UMKM.
     - Mengimplementasikan kontrol akses berbasis peran (RBAC) dan isolasi tenant otomatis (`TenantScope`).
     - Melindungi ekosistem dari kerentanan utama OWASP Top 10 (SQLi, XSS, IDOR, Broken Authentication).
   - **1.4 Batasan Masalah (Scope Pra-UTS):** Model multi-tenant basis data tunggal (shared database, separate organization scope), 11 layar aplikasi web, 4 tabel utama, tanpa sistem checkout pembayaran pihak ketiga atau booking kompleks.

3. **BAB II: ARSITEKTUR SISTEM & PERANCANGAN**
   - **2.1 Arsitektur Aplikasi:** Arsitektur MVC (Model-View-Controller) Laravel 12 dengan pemisahan peran yang tegas antara Vendor Platform, Admin UMKM, dan Pengunjung Publik.
   - **2.2 Diagram Alur Multi-Tenancy (Tenant Scoping):**
     - Alur autentikasi user & pengikatan `organization_id` pada session.
     - Skema query global via `TenantScope` yang secara otomatis menyaring `WHERE organization_id = ?` pada setiap interaksi tabel `products` dan `inquiries`.
   - **2.3 Skema Basis Data (4 Tabel Utama):**
     - `organizations`: Entitas penyewa (tenant) UMKM (`id`, `name`, `slug`, `category`, `phone`, `address`, `opening_hours`, `is_active`).
     - `users`: Autentikasi dan otorisasi (`role`: `vendor` / `umkm_admin`, `organization_id`).
     - `products`: Katalog item (`organization_id`, `name`, `category`, `price`, `description`, `photo_url`, `status`).
     - `inquiries`: Pesan pengunjung (`organization_id`, `visitor_name`, `visitor_contact`, `message`, `status`).

4. **BAB III: IMPLEMENTASI FITUR (11 LAYAR PLATFORM)**
   - Layar 1: Landing Page Platform (`/`)
   - Layar 2: Login & Logout (`/login`)
   - Layar 3: Registrasi UMKM (`/register-umkm`)
   - Layar 4: Dashboard Vendor Platform (`/vendor`)
   - Layar 5: Kelola & Daftar UMKM Mode Baca Saja (`/vendor`)
   - Layar 6: Dashboard Pengelola UMKM (`/dashboard`)
   - Layar 7: Kelola Profil Bisnis UMKM (`/dashboard/profil`)
   - Layar 8: Daftar & Formulir Produk CRUD (`/dashboard/produk`)
   - Layar 9: Daftar & Detail Pesan Pertanyaan Pengunjung (`/dashboard/pertanyaan`)
   - Layar 10: Laporan & Ekspor Data CSV (`/dashboard/laporan`)
   - Layar 11: Halaman Publik UMKM (`/u/{slug}`)

5. **BAB IV: ANALISIS DAN IMPLEMENTASI KEAMANAN SIBER**
   - **4.1 Prinsip CIA Triad:**
     - *Confidentiality:* Data pertanyaan dan katalog terlindungi melalui isolasi tenant; vendor dilarang membaca pesan UMKM.
     - *Integrity:* Validasi masukan server-side ketat, perlindungan manipulasi parameter ID (Anti-IDOR).
     - *Availability:* Perlindungan rate limiting (`throttle`), optimasi query database, perlindungan DoS pada formulir publik.
   - **4.2 Pencegahan Kerentanan Spesifik:**
     - *Anti-SQL Injection:* Penggunaan PDO Prepared Statements dan Parameter Binding Eloquent ORM.
     - *Anti-XSS (Cross-Site Scripting):* Auto-escaping pada engine Blade `{!! nl2br(e(...)) !!}` dan sanitasi input form.
     - *Anti-IDOR (Insecure Direct Object Reference):* Dual-layer protection menggunakan `TenantScope` dan metode otorisasi eksplisit `authorizeOwnership()`.
     - *Brute-Force & Credential Stuffing:* Throttling login (maksimal 5 kegagalan per email), validasi kekuatan password minimal 8 karakter, hashing satu arah Bcrypt.
     - *Anti-Spam Form Publik:* Throttle rate limiting per alamat IP pengunjung pada endpoint pengiriman pesan.
     - *CSV Formula Injection Protection:* Sanitasi karakter berbahaya (`=`, `+`, `-`, `@`) saat mengekspor data laporan ke spreadsheet.
     - *HTTP Security Headers:* Penerapan `X-Frame-Options` (Anti-Clickjacking), `X-Content-Type-Options` (Anti-MIME Sniffing), `X-XSS-Protection`, dan HSTS.

6. **BAB V: HASIL PENGUJIAN KEAMANAN (SELF-TESTING)**
   - Tabel Hasil Pengujian 7 Skenario Keamanan (Detail pada Bagian 7 Outline ini).
   - Analisis Sebelum vs. Sesudah Perbaikan Hardening.
   - Bukti Audit Dependensi (`composer audit` — 0 Vulnerabilities).

7. **BAB VI: PANDUAN DEPLOYMENT & BUKTI OPERASIONAL**
   - Konfigurasi server publik berstandar FQDN (Domain/Subdomain resmi) dan sertifikat SSL Let's Encrypt (HTTPS).
   - Bukti tangkapan layar (Screenshot) operasional:
     1. Tampilan Landing Page Platform.
     2. Tampilan Form & Alur Login dengan Rate Limiting.
     3. Tampilan Dashboard Pengelola UMKM dengan Ringkasan Statistik.
     4. Tampilan CRUD Katalog Produk & Modal Konfirmasi Hapus.
     5. Tampilan Halaman Publik `/u/{slug}` dan Pengiriman Pertanyaan Pengunjung.
     6. Tampilan Laporan Visual & Berkas Ekspor CSV.
     7. Bukti Status Gembok Hijau SSL / HTTPS Valid di Web Browser.

8. **BAB VII: POTENSI PENGEMBANGAN SKRIPSI / TUGAS AKHIR**
   - Pengembangan modul Automated Threat Detection (WAF terintegrasi AI).
   - Pengujian keamanan berbasis Dynamic Application Security Testing (DAST) menggunakan OWASP ZAP.
   - Perluasan skema multi-tenancy dinamis (Multi-Database Tenant Architecture dengan auto-provisioning).

9. **BAB VIII: KENDALA DAN RENCANA PERBAIKAN**
   - Kendala pembatasan sandbox lokal pada Windows ACL dan penanganannya melalui script otomasi pengujian mandiri.
   - Rencana penguatan mekanisme Two-Factor Authentication (2FA) dan logging audit trail berbasis SIEM di masa mendatang.

10. **BAB IX: KESIMPULAN & PENUTUP**

---

## TABEL HASIL SELF-TESTING KEAMANAN SIBER

| No | Skenario Pengujian | Metode & Payload Pengujian | Hasil Pengujian | Status & Mitigasi Keamanan |
| :---: | :--- | :--- | :--- | :---: |
| **1** | **SQL Injection (SQLi)** | Injeksi payload SQL (`' OR '1'='1`, `'; DROP TABLE products;--`) pada kolom pencarian nama produk dan parameter kategori di URL. | Query builder memperlakukan payload sebagai string literal. Tidak ada kebocoran data produk lain dan tabel tetap utuh. | **LOLOS (PASS)**<br>Mitigasi: Prepared statements PDO & parameter binding Eloquent. |
| **2** | **Cross-Site Scripting (XSS)** | Input tag skrip berbahaya (`<script>alert('XSS')</script>`, `<img src=x onerror=...>`) pada deskripsi produk dan formulir pesan pengunjung publik. | Seluruh tag HTML berbahaya berhasil di-escape menjadi entitas teks aman (`&lt;script&gt;`). Browser tidak mengeksekusi payload. | **LOLOS (PASS)**<br>Mitigasi: Sanitasi output otomatis Blade `e()` dan `{!! nl2br(e(...)) !!}`. |
| **3** | **Insecure Direct Object Reference (IDOR)** | Admin UMKM A (Toko ABC) memanipulasi ID di URL untuk membuka, mengedit, atau menghapus produk/pertanyaan milik UMKM B (Peyeum Kuningan). | Akses langsung diblokir seketika dengan status HTTP 403 Forbidden atau 404 Not Found. Data UMKM lain tidak dapat disentuh. | **LOLOS (PASS)**<br>Mitigasi: `TenantScope` global + metode otorisasi eksplisit `authorizeOwnership()`. |
| **4** | **Role-Based Access Control (RBAC)** | Admin UMKM mencoba mengakses URL khusus vendor (`/vendor`), dan pengunjung anonim mencoba mengakses `/dashboard`. | Akses ke `/vendor` diblokir dengan HTTP 403 Forbidden oleh middleware `EnsureRole`. Akses ke `/dashboard` diredirect ke `/login`. | **LOLOS (PASS)**<br>Mitigasi: Middleware `EnsureRole` dan `auth` guard. |
| **5** | **Password & Brute-Force Rate Limiting** | Pendaftaran dengan password lemah (< 8 karakter) serta simulasi serangan brute force login lebih dari 5 kali kegagalan berturut-turut. | Pendaftaran ditolak oleh validator password. Setelah 5 kegagalan login, sistem memblokir request dan menerapkan throttle lockout. | **LOLOS (PASS)**<br>Mitigasi: Validasi min:8, Rate Limiter login, hash Bcrypt satu arah. |
| **6** | **HTTP Security Headers & HTTPS** | Pengujian response headers pada request web dan simulasi koneksi secure HTTPS. | Seluruh header keamanan aktif: `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection`, dan HSTS. | **LOLOS (PASS)**<br>Mitigasi: Global Web Middleware `SecurityHeaders`. |
| **7** | **Git Hygiene & Secret Management** | Pemindaian berkas terlacak repositori Git (`git ls-files`) dan audit keamanan dependensi package. | Tidak ada berkas `.env` atau database SQLite binary yang ter-commit. `composer audit` melaporkan 0 celah kerentanan. | **LOLOS (PASS)**<br>Mitigasi: `.gitignore` ketat, `.env.example` placeholder, dependensi terbarui. |

