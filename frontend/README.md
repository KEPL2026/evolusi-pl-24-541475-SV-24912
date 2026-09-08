# KEPL Planner Frontend

The KEPL Planner frontend uses TanStack Start, TanStack Router, React, and GSAP. Laravel remains the backend and owns the session-backed task API.

## Development

Run Laravel first from the repository root:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Then run the frontend:

```powershell
npm install
npm run dev -- --host 127.0.0.1
```

Open `http://127.0.0.1:3000`.

The API base defaults to `http://127.0.0.1:8000` and can be overridden with `VITE_API_BASE_URL`.

## Production

Build and start the TanStack server with `npm run build` and `npm run start`. Put the TanStack server and Laravel behind the same reverse proxy in deployment so `/api/*` is routed to Laravel.

## Animation

GSAP uses the official React `useGSAP` hook with a scoped context and respects `prefers-reduced-motion` for the page entrance sequence.
