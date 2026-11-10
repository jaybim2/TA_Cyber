# Panduan Deployment & Hosting FQDN + HTTPS — Platform UMKM SaaS

Dokumen ini merupakan panduan deployment resmi untuk Tugas Besar Cyber Security (Pra-UTS) agar aplikasi dapat diakses secara live melalui **FQDN (Fully Qualified Domain Name)** dengan **HTTPS aktif (SSL valid)**.

---

## 1. Arsitektur & Persyaratan Produksi

- **Web Server:** Nginx 1.18+ / Caddy / Apache 2.4+
- **PHP Version:** PHP 8.2+ (disarankan PHP 8.3 / 8.4)
- **Ekstensi PHP Wajib:** `php-fpm`, `php-sqlite3` (atau `php-pgsql` / `php-mysql`), `php-mbstring`, `php-xml`, `php-curl`, `php-zip`, `php-bcmath`
- **Database:** SQLite (lokal/testing) atau PostgreSQL / MySQL (produksi)
- **Sertifikat SSL:** Let's Encrypt Certbot (Gratis) / Cloudflare Universal SSL
- **Domain:** FQDN aktif (misal: `https://umkm-saas.namamahasiswa.my.id` atau subdomain dari penyedia cloud)

---

## 2. Checklist Keamanan Lingkungan Produksi

Sebelum merilis ke publik, pastikan variabel `.env` produksi dikonfigurasi dengan aman:

```env
APP_NAME="UMKM SaaS"
APP_ENV=production
APP_KEY=base64:... (Generate via: php artisan key:generate --force)
APP_DEBUG=false
APP_URL=https://nama-domain-anda.com

# Database Produksi (PostgreSQL atau MySQL disarankan)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/umkm-saas/database/database.sqlite

# Session & Cookie Security
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
```

> [!IMPORTANT]
> - Pastikan `APP_DEBUG=false`. Jangan pernah menyalakan debug di server publik karena dapat membocorkan stack trace dan env credentials.
> - Pastikan `SESSION_SECURE_COOKIE=true` agar cookie session hanya dikirim melalui koneksi HTTPS.

---

## 3. Pilihan Metode Deployment

### Opsi A: Deployment via Cloud VPS (Ubuntu 22.04 / 24.04 + Nginx)

1. **Clone Repositori:**
   ```bash
   cd /var/www
   git clone https://github.com/jaybim2/TA_Cyber.git umkm-platform
   cd umkm-platform/umkm-saas
   ```

2. **Instalasi Dependensi & Setup Env:**
   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   php artisan key:generate
   ```

3. **Migrasi & Seeder Database:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --force
   php artisan db:seed --force
   ```

4. **Atur Permission Folder:**
   ```bash
   sudo chown -R www-data:www-data /var/www/umkm-platform/umkm-saas/storage
   sudo chown -R www-data:www-data /var/www/umkm-platform/umkm-saas/bootstrap/cache
   sudo chown -R www-data:www-data /var/www/umkm-platform/umkm-saas/database
   sudo chmod -R 775 storage bootstrap/cache database
   ```

5. **Optimasi Cache Laravel:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Konfigurasi Virtual Host Nginx (`/etc/nginx/sites-available/umkm-saas`):**
   ```nginx
   server {
       listen 80;
       server_name umkm-saas.namamahasiswa.my.id;
       root /var/www/umkm-platform/umkm-saas/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       add_header X-XSS-Protection "1; mode=block";
       add_header Referrer-Policy "strict-origin-when-cross-origin";

       index index.php;
       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

7. **Aktifkan HTTPS via Let's Encrypt Certbot:**
   ```bash
   sudo ln -s /etc/nginx/sites-available/umkm-saas /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl reload nginx
   sudo certbot --nginx -d umkm-saas.namamahasiswa.my.id
   ```

---

### Opsi B: Deployment via Cloud PaaS Modern (Railway / Render / Fly.io)

1. Hubungkan repositori GitHub `jaybim2/TA_Cyber` ke dashboard PaaS.
2. Atur **Root Directory** ke `umkm-saas`.
3. Tambahkan environment variables:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=base64:...`
   - `APP_URL=https://<app-name>.up.railway.app`
4. Build Command:
   `composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan db:seed --force`
5. Start Command:
   `php artisan serve --host=0.0.0.0 --port=$PORT` (atau via Nginx buildpack).
6. Sambungkan Custom Domain FQDN di menu Networking PaaS untuk sertifikat SSL gratis otomatis.

---

## 4. Akun Uji Coba untuk Demonstrasi / Dosen Penguji

| Peran | Email | Password Akses Uji | URL Akses |
| --- | --- | --- | --- |
| **Vendor Platform** | `vendor@platformkamu.test` | Ditetapkan saat seeding lokal / demo | `/vendor` |
| **Admin UMKM Toko ABC** | `admin@tokoabc.test` | Ditetapkan saat seeding lokal / demo | `/dashboard` & `/u/toko-abc` |
| **Admin UMKM Peyeum Kuningan** | `admin@peyeum.test` | Ditetapkan saat seeding lokal / demo | `/dashboard` & `/u/peyeum-kuningan` |
| **Pengunjung Umum** | *(Tanpa Login)* | *(Tanpa Password)* | `/` & `/u/{slug}` |

---

## 5. Pemeliharaan Selama Penilaian

Aplikasi harus dipastikan tetap live dan menyala 24/7 hingga seluruh proses penilaian tugas besar diumumkan. Gunakan monitoring uptime gratis seperti **UptimeRobot** atau **Healthchecks.io** yang mengarah ke endpoint `/up`.
