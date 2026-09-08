# KEPL Planner

Aplikasi web Laravel sederhana untuk mencatat langkah kerja berikutnya. Tugas disimpan pada session pengguna sehingga dapat langsung dicoba tanpa konfigurasi database tambahan.

## Menjalankan aplikasi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Buka `http://localhost:8000`, lalu tambahkan tugas melalui form pada halaman utama.

## Pemeriksaan kualitas

```bash
php artisan test
npm install
npm run build
```

Workflow GitHub Actions menjalankan pemeriksaan Laravel dan build frontend pada setiap push serta pull request ke `main` atau `dev`.
