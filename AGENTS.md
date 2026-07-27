# AGENTS.md

## Stack
- Laravel 13 / PHP 8.3, Blade + Alpine.js + Tailwind CSS v4
- MySQL (prod) / SQLite in-memory (tests)
- Midtrans Snap API (payments), simplesoftwareio/simple-qrcode, barryvdh/laravel-dompdf

## Commands
| Task | Command |
|------|---------|
| First-time setup | `composer run setup` |
| Dev server (all-in-one) | `composer run dev` |
| Tests | `composer run test` |
| Frontend build | `npm run build` |

- `composer run dev` runs `php artisan serve`, `queue:listen`, `pail` (log tail), and `vite` concurrently via `concurrently`. All four must be running for full local functionality.
- `composer run test` clears config cache first, then runs PHPUnit. Tests use SQLite `:memory:`, `QUEUE_CONNECTION=sync`.
- Run a single test: `php artisan test --filter TestClassName`

## Required .env Keys
`.env.example` defaults to SQLite. For MySQL dev, uncomment `DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD` and set `DB_CONNECTION=mysql`.

Midtrans keys (not in `.env.example`, must be added manually):
```
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_SECRET_KEY=
MIDTRANS_PRODUCTION=false
```

## Architecture
- `TicketType` → `Order` (belongs-to) → `Payment` (has-one)
- `Order.ticket_id` is the public-facing ID (`TIX-XXXXXXXX`), not `Order.id`. Midtrans uses `ticket_id` as `order_id`.
- `Order.$guarded = []` — all fields mass-assignable.
- Stock is decremented with `lockForUpdate()` inside `DB::transaction()` in `TicketController::store`. Don't bypass the transaction.
- Midtrans webhook endpoint: `POST /payment/notification` — signature verified via HMAC-SHA256 on raw request body (`X-Midtrans-Signature` header).
- `config('services.midtrans.secret_key')` is used for webhook verification (maps to `MIDTRANS_SECRET_KEY`), while `config('services.midtrans.server_key')` is used for Snap token generation.
- QR code only generates when `payment_status === 'success'`.

## Routes Summary
- Public: `GET /tickets`, `POST /tickets/book`, `GET /ticket/{ticketId}`, `GET /ticket/{ticketId}/qrcode`, `GET /download-ticket/{ticketId}`
- Webhook: `POST /payment/notification` (no auth — Midtrans calls this)
- Admin (auth required): `admin/tickets` and `admin/orders` (resource routes via `AdminController` and `OrderController`)

## UI/UX — Neobrutalism
Tokens live in both `tailwind.config.js` and `vite.config.js` (duplicated — keep in sync):
- Colors: `yellow` #FFD43B, `pink` #FF4D8D, `cyan` #4CC9F0
- Shadow: `shadow-neobrutalism` = `6px 6px 0px 0px #000000`
- Radii: `rounded-xl` 16px (buttons/inputs), `rounded-2xl` 20px (cards), `rounded-3xl` 24px (modals)
- Borders: `border-3` or `border-4` (3–4px solid black)
- Animation: 150–250ms, scale hover only. No blur, no gradients, no transparency animations.
- Fonts: `font-poppins`, `font-inter`

## Quirks
- `tailwind.config.js` and `vite.config.js` both define the same Tailwind theme — this is intentional (Tailwind v4 Vite plugin config). Edit both when adding tokens.
- `OrderController` missing `store` method and `showTicket` doesn't live in `TicketController` — ticket display is on `OrderController::showTicket`. Don't move it.
- No CI pipeline, no pre-commit hooks.
- PDF tickets use `barryvdh/laravel-dompdf` rendered from `resources/views/ticket/pdf.blade.php`.
- Design reference: `PRD ADVANCED.md` (sections 5–7, 13–16) for feature spec.
