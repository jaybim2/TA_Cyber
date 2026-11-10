# Platform Website Profil dan Katalog Siap Pakai untuk UMKM (Model SaaS)

> **Tugas Besar Cyber Security (Pra-UTS)**  
> **Judul Terkunci (2026-11-09):** Pengembangan Platform Website Profil dan Katalog Siap Pakai Berbasis Web dengan Model SaaS untuk UMKM  
> **Stack Terkunci:** Laravel 12, PHP 8.2+, Tailwind CSS, SQLite / PostgreSQL / MySQL  
> **Lisensi & Keamanan:** Private Academic Repository — Mematuhi Prinsip Keamanan OWASP Top 10

---

## 1. Deskripsi Proyek

Platform web berbasis Software as a Service (SaaS) multi-tenant yang dirancang khusus untuk memfasilitasi pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) dalam memiliki website profil bisnis dan katalog produk digital siap pakai secara instan tanpa perlu membangun website dari nol, menyewa web hosting, ataupun memahami pemrograman.

Setiap UMKM yang terdaftar memperoleh:
1. **Alamat Web Publik Resmi:** `/u/{slug}` (contoh: `/u/peyeum-kuningan`, `/u/toko-abc`) yang responsif, memuat profil usaha, katalog produk dengan filter kategori, tombol pemesanan langsung via WhatsApp, dan formulir pengiriman pertanyaan yang aman.
2. **Dashboard Pengelola UMKM:** `/dashboard` untuk mengelola profil usaha, katalog produk (CRUD), menindaklanjuti pesan pengunjung dengan alur status (`Baru` &rarr; `Dibalas` &rarr; `Selesai`), serta melihat grafik laporan performa dan mengekspor data ke file CSV.
3. **Isolasi Keamanan Ketat (Multi-Tenant Scoping):** Seluruh data UMKM terisolasi secara otomatis di tingkat basis data dan query Eloquent (`TenantScope`), mencegah terjadinya kebocoran data antar-penyewa maupun serangan manipulasi ID (Anti-IDOR).

---

## 2. Fitur Utama Platform (11 Layar)

| No | Layar Aplikasi | Rute Utama | Akses Peran | Deskripsi Fungsional |
| :-: | :--- | :--- | :--- | :--- |
| **1** | **Landing Page Platform** | `/` | Publik (Anonim) | Hero promosi, alur 3 langkah kerja, 4 kartu keunggulan fitur, dan showcase contoh UMKM Toko ABC. |
| **2** | **Login & Logout** | `/login`, `/logout` | Publik / User | Otentikasi aman dengan perlindungan brute-force (rate limiting 5x kegagalan) dan pengalihan peran cerdas. |
| **3** | **Registrasi UMKM** | `/register-umkm` | Publik (Anonim) | Pendaftaran instan UMKM baru, pembuatan slug URL otomatis, dan auto-login langsung ke dashboard. |
| **4** | **Dashboard Vendor** | `/vendor` | Vendor Platform | Pantauan metrik agregat ekosistem seluruh UMKM terdaftar (tanpa membuka isi pesan rahasia UMKM). |
| **5** | **Kelola & Daftar UMKM** | `/vendor` | Vendor Platform | Daftar seluruh UMKM terdaftar dalam mode baca saja (read-only) untuk pemantauan kepatuhan. |
| **6** | **Dashboard UMKM** | `/dashboard` | Admin UMKM | Ringkasan statistik performa katalog, jumlah pesan baru, dan jalan pintas ke fitur utama. |
| **7** | **Kelola Profil Usaha** | `/dashboard/profil` | Admin UMKM | Formulir pengubahan profil usaha, jam operasional, alamat, nomor WhatsApp, dan preview slug live. |
| **8** | **Daftar & Form Produk** | `/dashboard/produk` | Admin UMKM | CRUD katalog produk lengkap dengan pencarian nama, filter kategori, status tampil/sembunyi, dan modal konfirmasi hapus. |
| **9** | **Daftar & Detail Pesan** | `/dashboard/pertanyaan` | Admin UMKM | Manajemen pesan masuk dengan alur status (`Baru`, `Dibalas`, `Selesai`, `Buka Lagi`), balas via WA/Email, dan hapus pesan. |
| **10** | **Laporan & Ekspor CSV** | `/dashboard/laporan` | Admin UMKM | Grafik distribusi produk, persentase status pesan, tabel rekap, dan tombol unduh file CSV terproteksi formula injection. |
| **11** | **Halaman Publik UMKM** | `/u/{slug}` | Publik (Anonim) | Halaman profil resmi UMKM, katalog interaktif dengan filter chip, tombol direct WA, dan formulir pertanyaan anti-spam. |

---

## 3. Aspek Keamanan Siber (Cyber Security Hardening)

Aplikasi dibangun dengan memprioritaskan keamanan siber sejak tahap perancangan (*Security by Design*):

1. **Anti-SQL Injection (SQLi):** Seluruh query basis data menggunakan PDO Prepared Statements dan Parameter Binding Eloquent ORM. Karakter petik tunggal atau injeksi UNION SELECT dinetralisir sebagai string literal biasa.
2. **Anti-Cross Site Scripting (XSS):** Seluruh output deskripsi produk dan pesan pengunjung disanitasi secara ketat menggunakan escaping bawaan Blade `{!! nl2br(e(...)) !!}`. Tag `<script>` maupun event handler JavaScript tidak dapat dieksekusi di browser.
3. **Anti-Insecure Direct Object Reference (IDOR):** Diterapkan pertahanan berlapis (*Defense-in-Depth*):
   - **Layer 1:** `TenantScope` global Eloquent secara otomatis menyisipkan klausa `WHERE organization_id = ?` sesuai ID tenant user yang sedang login.
   - **Layer 2:** Pengecekan eksplisit `authorizeProductOwnership()` dan `authorizeInquiryOwnership()` yang langsung mengembalikan HTTP 403 Forbidden bila terdeteksi manipulasi ID URL.
4. **Role-Based Access Control (RBAC):** Middleware `EnsureRole` memastikan admin UMKM tidak dapat menembus area `/vendor`, dan vendor tidak dapat membaca pesan rahasia UMKM.
5. **Brute-Force & Rate Limiting Protection:**
   - Throttle login dibatasi maksimal 5 kali kegagalan berturut-turut sebelum akun/IP dikunci sementara.
   - Endpoint pengiriman pertanyaan pengunjung publik dilindungi rate limiting anti-spam (`throttle:10,1`).
6. **Password Hashing:** Password pengguna selalu disimpan dalam bentuk hash kriptografi satu arah (Bcrypt / Argon2) dan tidak pernah tersimpan secara plaintext.
7. **CSV Formula Injection Sanitization:** Pencegahan eksekusi formula berbahaya (`=`, `+`, `-`, `@`) saat mengekspor laporan CSV ke Microsoft Excel / Google Sheets.
8. **HTTP Security Headers:** Menerapkan middleware keamanan global (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection: 1; mode=block`, `Referrer-Policy`, dan HSTS untuk koneksi HTTPS).

---

## 4. Hasil Verifikasi Keamanan (Self-Testing Suite)

Seluruh 7 skenario pengujian keamanan telah diuji secara otomatis melalui test suite mandiri (`scratch/verify_t16_security.php`) dengan hasil **100% Lolos**:

| Skenario Pengujian | Metode & Payload Uji | Hasil Uji | Status |
| :--- | :--- | :--- | :---: |
| **1. SQL Injection** | Payload `' OR '1'='1` dan `'; DROP TABLE;--` pada form pencarian dan parameter URL. | Parameter dibinding dengan aman, tidak ada bypass otentikasi maupun kebocoran baris data. | **PASS** |
| **2. Cross-Site Scripting (XSS)** | Payload `<script>alert('XSS')</script>` pada input nama, deskripsi produk, dan pesan pertanyaan. | Tag HTML berbahaya terkonversi aman menjadi entitas `&lt;script&gt;` di browser. | **PASS** |
| **3. Anti-IDOR** | Admin UMKM A mencoba membuka, mengedit, atau menghapus produk/pesan milik UMKM B via manipulasi ID URL. | Sistem menolak akses seketika dengan status HTTP 403 Forbidden / 404 Not Found. | **PASS** |
| **4. Kontrol Akses Peran (RBAC)** | Admin UMKM mengakses `/vendor`; Pengunjung anonim mengakses `/dashboard`. | Akses `/vendor` diblokir (403); Akses `/dashboard` dialihkan (302 redirect ke `/login`). | **PASS** |
| **5. Password & Rate Limiting** | Pendaftaran password lemah (< 8 karakter) dan simulasi 5 kali kegagalan login berturut-turut. | Password lemah ditolak validator; 5 kegagalan login langsung memicu lockout throttle. | **PASS** |
| **6. Security Headers & HTTPS** | Pemeriksaan header HTTP response pada server web dan koneksi aman HTTPS. | Header `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, dan HSTS aktif sempurna. | **PASS** |
| **7. Git Hygiene & Dependency Audit** | Pemindaian berkas terlacak Git (`git ls-files`) dan eksekusi `composer audit`. | Tidak ada berkas `.env` atau database SQLite yang ter-commit. `composer audit` 0 vulnerabilitas. | **PASS** |

---

## 5. Cara Instalasi & Menjalankan Lokal

### Prasyarat Sistem
- PHP 8.2 atau lebih baru
- Composer 2.x
- Ekstensi PHP: `pdo_sqlite` (atau `pdo_mysql` / `pdo_pgsql`), `mbstring`, `curl`, `xml`, `zip`
- Git

### Langkah Instalasi
1. **Clone Repositori:**
   ```bash
   git clone https://github.com/jaybim2/TA_Cyber.git
   cd TA_Cyber/umkm-saas
   ```

2. **Instal Dependensi PHP:**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Siapkan Basis Data & Jalankan Seeder:**
   ```bash
   # Buat berkas database SQLite lokal
   touch database/database.sqlite

   # Jalankan migrasi dan data dummy resmi PRD
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban web di: `http://127.0.0.1:8000`

---

## 6. Akun Uji Coba untuk Demonstrasi / Penilaian

Database seeder telah menyiapkan akun dummy sesuai ketetapan PRD:

| Peran Pengguna | Alamat Email | Password Uji Coba | Akses Halaman |
| :--- | :--- | :--- | :--- |
| **Vendor Platform** | `vendor@platformkamu.test` | Ditetapkan saat seeder lokal / demo | `/vendor` |
| **Admin Toko ABC** | `admin@tokoabc.test` | Ditetapkan saat seeder lokal / demo | `/dashboard` & `/u/toko-abc` |
| **Admin Peyeum Kuningan** | `admin@peyeum.test` | Ditetapkan saat seeder lokal / demo | `/dashboard` & `/u/peyeum-kuningan` |
| **Pengunjung Umum** | *(Tanpa Login)* | *(Tanpa Password)* | `/` & `/u/{slug}` |

---

## 7. Panduan Deployment Produksi (FQDN + HTTPS)

Panduan deployment lengkap untuk hosting publik berstandar domain resmi (FQDN) dengan sertifikat SSL aktif (HTTPS) dapat dibaca pada berkas:  
&rarr; [**Panduan Deployment Produksi (`DEPLOYMENT.md`)**](file:///d:/VSCODE/TA_Cyber/DEPLOYMENT.md)

---

## 8. Outline Laporan Tugas Besar (PDF)

Struktur kerangka laporan PDF akademik resmi untuk penyerahan Tugas Besar / Pra-UTS mencakup bab pendahuluan, arsitektur, implementasi keamanan, tabel hasil pengujian, tangkapan layar bukti, serta potensi skripsi dapat dibaca pada berkas:  
&rarr; [**Outline Laporan Akademik (`OUTLINE_LAPORAN_PRA_UTS.md`)**](file:///d:/VSCODE/TA_Cyber/OUTLINE_LAPORAN_PRA_UTS.md)

---

## 9. Transparansi Pemakaian Kecerdasan Buatan (AI Usage)

Pengembangan platform ini memanfaatkan bantuan asisten kecerdasan buatan (*AI Pair Programmer* — Google Antigravity / Gemini) secara bertahap dan terstruktur task demi task (T01 hingga T16):
- **Perancangan Arsitektur:** Membantu perancangan relasi multi-tenancy `TenantScope` dan pemisahan middleware peran.
- **Scaffolding & Templating:** Membantu pembuatan antarmuka Blade CSS responsif berbasis Tailwind CSS.
- **Security Hardening:** Meninjau dan menyusun mitigasi kerentanan OWASP Top 10 (escaping output, parameter binding, CSV sanitization, security headers).
- **Automated Verification:** Menulis skrip otomasi pengujian mandiri (*self-testing suite*) untuk memverifikasi setiap kriteria selesai sebelum kode di-commit.
- **Integritas Kode:** Seluruh kode yang dihasilkan telah melalui proses verifikasi eksekusi lokal dan peninjauan mandiri tanpa pelanggaran aturan scope PRD.
