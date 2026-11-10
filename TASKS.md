# PRD — Platform Website Profil dan Katalog Siap Pakai untuk UMKM

## Tugas 1-1 untuk Antigravity (Laravel)

**Judul terkunci 2026-11-09:** Pengembangan Platform Website Profil dan Katalog Siap Pakai Berbasis Web dengan Model SaaS untuk UMKM

**Stack terkunci 2026-11-09:** Laravel 12, PHP 8.2+, SQLite untuk tes migrate pertama (Postgres/MySQL untuk deploy, aturan CHECK hanya ditegakkan di sana)

**Scope satu kalimat:** Satu website profil dan katalog siap pakai per UMKM, yang dikelola dari dashboard.

**Tugas Besar:** Cyber Security, individu, batas Pra-UTS. Aplikasi web nyata, bukan prototipe statis. Harus live via FQDN + HTTPS, repo Git, laporan PDF.

---

## Cara pakai file ini di Antigravity

1. Kerjakan **satu task saja** dalam satu sesi. Jangan minta Antigravity mengerjakan T01–T16 sekaligus.
2. Buka folder proyek `umkm-saas` di Antigravity, lalu salin blok **Prompt untuk Antigravity** pada task yang sedang dikerjakan, tempel, dan biarkan selesai.
3. Jalankan **Verifikasi** di task itu. Kalau ada yang gagal, perbaiki task itu dulu, jangan loncat.
4. Kalau lolos, `git commit` dengan pesan yang ada di task, lalu lanjut ke task berikutnya.
5. Kalau Antigravity menawarkan fitur di luar task, tolak. Patokannya adalah bagian **Jangan lakukan** di tiap task.

---

## Aturan global — berlaku untuk semua task

1. Jangan pernah commit `.env` atau password asli. Secret hanya di `.env` lokal dan `.env.example` berisi placeholder saja.
2. Password selalu di-hash bcrypt/argon2, tidak pernah plaintext.
3. Setiap query produk, pertanyaan, dan profil selalu difilter `organization_id` milik user yang login. Vendor hanya boleh melihat daftar UMKM dan angka agregat, bukan isi pesan UMKM lain.
4. Semua query memakai parameter binding, semua output deskripsi/pesan di-escape (anti SQLi/XSS).
5. Jangan tambah tabel, kolom, atau fitur di luar PRD ini. Yang di luar scope Pra-UTS: drag-and-drop builder, banyak template, payment gateway/checkout, booking rumit, domain khusus per UMKM, database terpisah per UMKM, upload file rumit, scanner otomatis.
6. Jangan ubah nama tabel, kolom, slug, atau status yang sudah ada di skema.
7. Setiap perubahan yang selesai harus bisa didemo, bukan hanya ada kodenya.
8. Kalau ada perintah yang gagal, laporkan baris yang gagal, jangan dipaksakan lanjut.

---

## Ringkasan produk

### Peran

| Peran | Bisa | Tidak bisa |
| --- | --- | --- |
| Vendor | Kelola daftar UMKM, lihat angka agregat | Membaca isi pertanyaan UMKM, mengubah produk UMKM |
| Admin UMKM | Kelola profil dan produk UMKM-nya, membalas pertanyaan, melihat laporan UMKM-nya | Membuka `/vendor`, melihat data UMKM lain |
| Pengunjung | Membuka halaman publik `/u/{slug}`, mengirim pertanyaan tanpa login | Membuka dashboard |

### Layar (11)

1. Landing Page Platform — 2. Login — 3. Registrasi UMKM — 4. Dashboard Vendor — 5. Kelola UMKM — 6. Dashboard UMKM — 7. Kelola Profil UMKM — 8. Daftar & Form Produk — 9. Daftar & Detail Pertanyaan — 10. Laporan & Ekspor — 11. Halaman Publik UMKM

### Tabel (4 saja)

| Tabel | Kunci |
| --- | --- |
| `organizations` | `slug` UNIQUE, `is_active` default TRUE |
| `users` | `email` UNIQUE, `organization_id` NULL = vendor, `role` = `vendor` / `umkm_admin` |
| `products` | `organization_id` NOT NULL, `price` DECIMAL(12,2) >= 0, `status` = `Tampil` / `Sembunyi` |
| `inquiries` | `organization_id` NOT NULL, `status` = `Baru` / `Dibalas` / `Selesai` |

Relasi: Organization hasMany User/Product/Inquiry. User belongsTo Organization. Product/Inquiry belongsTo Organization.

### Rute utama

- `/` landing platform — `/login` — `/register-umkm` — `/vendor` (vendor saja) — `/dashboard` (admin UMKM) — `/u/{slug}` (publik, hanya UMKM Aktif + produk Tampil)

### Data dummy (contoh, bukan data asli bisnis)

- Toko ABC — `toko-abc` — Kuliner — Aktif
- Peyeum Khas Kuningan — `peyeum-kuningan` — Kuliner — Aktif — studi kasus saja, bukan klaim kemitraan. Harga contoh: Peyeum Ember Kecil Rp75.000 Tampil, Peyeum Ember Besar Rp90.000 Tampil, Paket Oleh-oleh Peyeum Rp150.000 Sembunyi.
- **Jangan seed Peyeum Keju.** Tambahkan live saat demo.
- Akun dummy: `vendor@platformkamu.test`, `admin@tokoabc.test`, `admin@peyeum.test` — email saja, password ditetapkan saat build, jangan ditulis di repo.
- Batik Laras hanya contoh kontras Fashion, tidak wajib di-seed.

---

### T16 — Slice 4b: Self-testing, deploy, dan README final

**Tujuan:** Aplikasi live, aman, dan bisa diserahkan dengan bukti.

**Prompt untuk Antigravity:**

> Kerjakan T16 saja, dan hanya setelah T01–T15 selesai. Lakukan self-testing keamanan, siapkan deploy, dan rapikan README serta outline laporan. Jangan tambah fitur baru di task ini.

**Langkah:**

- [x] Self-testing, dokumentasikan di tabel skenario/cara uji/hasil/perbaikan, minimal 5 skenario, dengan bukti sebelum-sesudah untuk yang diperbaiki:

- SQL Injection di kolom cari produk dan parameter URL
- XSS di deskripsi produk dan pesan pertanyaan
- IDOR: admin UMKM A membuka produk/pertanyaan UMKM B lewat ID/slug di URL
- Peran: admin UMKM membuka `/vendor`, pengunjung membuka `/dashboard`
- Password lemah ditolak + rate limiting login + logout mengunci dashboard
- HTTPS + security headers (securityheaders.com / SSL Labs)
- Secret tidak ter-commit + audit dependency

- [x] Deploy: hosting publik via FQDN, wajib HTTPS valid, bukan localhost/IP mentah, aplikasi tetap aktif sampai nilai diumumkan
- [x] README final: deskripsi, fitur, teknologi, cara instalasi dan jalan lokal, konfigurasi env tanpa nilai rahasia, URL aplikasi, akun uji (vendor + admin UMKM), ringkasan pemakaian AI dan hasil self-testing
- [x] Outline laporan PDF: identitas, latar belakang dan tujuan, fitur utama, arsitektur + diagram, penerapan keamanan, potensi skripsi, hasil self-testing, screenshot (login, kelola produk, halaman publik, laporan, bukti HTTPS), kendala dan rencana perbaikan

**Kriteria selesai:** URL publik bisa dibuka dosen, login akun uji berhasil, laporan dan README lengkap, dan tidak ada secret di repo.

**Jangan lakukan:** Jangan tambah fitur di task ini, apalagi payment, booking, atau template baru.

---