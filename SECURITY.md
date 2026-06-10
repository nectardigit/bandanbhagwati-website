# Security notes — Bandan Bhagwati

Status: **pre-launch hardening of a clean, never-deployed build** (no compromise; `composer audit` clean; no PHP in uploads; no webshells found).

## Applied (Tier 1 — in the app)
| Area | What |
|---|---|
| Debug/secrets | `.env.production.example` ships `APP_DEBUG=false`, `APP_ENV=production`, secure cookies, HTTPS. |
| Admin access | `User::canAccessPanel()` gates `/admin` to `is_admin` users only. New/other users can't reach it. |
| Admin password | Seeder no longer hardcodes `password`; uses `ADMIN_PASSWORD` or generates a random one. Rotate with `php artisan app:admin-password`. |
| Response headers | `SecurityHeaders` middleware: X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy, HSTS (https only). |
| Uploads | unisharp restricted to image/video MIME; `.php`/`.html` blocked by the library; behind `auth`. Server config additionally blocks PHP execution under `storage`/uploads. |

## Staged (Tier 2 — `deploy/`)
`nginx.conf`, `apache.md`, `DEPLOY.md` — web-server/PHP/Cloudflare hardening + cutover runbook with rollbacks. **These must be applied on the server** (can't be tested locally).

## Accepted / documented decisions
- **`$guarded = []` on models** — kept deliberately. Filament admin forms mass-assign validated schema fields, so restricting `$fillable` would break admin saves while adding no real protection there. The **only** unauthenticated writes are the contact / newsletter / equipment-enquiry forms, and those controllers build the insert from **explicit, validated arrays** (`create(['name' => $data['name'], ...])`), never `$request->all()` — so request-driven mass assignment is not exploitable. If public-writable models are added later, give them explicit `$fillable`.
- **CSRF exempt for `/filemanager/*`** — required because the unisharp UI doesn't emit a token; the routes are already behind `auth`. Acceptable.
- **`X-Powered-By`** — PHP appends it after Laravel, so the middleware can't strip it. Removed via `expose_php = Off` in the server php.ini (see `deploy/`).

## Must-do before go-live (checklist)
1. `php artisan app:admin-password admin@bandanbhagwati.com` → set a strong password (current local one is the dev default).
2. Use a **dedicated least-privilege MySQL user**, not `root`.
3. Set real **SMTP** (contact/enquiry emails currently log only).
4. Deploy with **`public/` as docroot**; apply `deploy/` configs and run every verification `curl -I` in `DEPLOY.md`.
5. Set Cloudflare **Full (strict)** + WAF + origin IP lockdown.
