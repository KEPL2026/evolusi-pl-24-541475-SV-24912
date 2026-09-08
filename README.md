# KEPL Planner

Monorepo task planner dengan TanStack Start React sebagai frontend dan Laravel sebagai backend API. Task disimpan pada session Laravel sehingga belum membutuhkan tabel task tambahan.

## Struktur

```text
frontend/   TanStack Start, React, TanStack Router, GSAP
backend/    Laravel API, session, validation, dan PHPUnit
```

## Menjalankan aplikasi

Terminal 1, backend:

```powershell
cd backend
composer install
copy .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

Terminal 2, frontend:

```powershell
cd frontend
npm install
npm run dev -- --host 127.0.0.1
```

Buka `http://127.0.0.1:3000`. Frontend memanggil `http://127.0.0.1:8000/api/tasks` dengan session Laravel dan credentialed CORS.

## Pemeriksaan kualitas

```powershell
cd backend
php artisan test

cd ..\frontend
npm run build
```

CI menjalankan test backend dan build frontend pada setiap push serta pull request ke `main` atau `dev`.
