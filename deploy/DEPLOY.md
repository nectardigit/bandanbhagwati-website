# Bandan Bhagwati — Secure Deploy & Cutover Runbook

Apply **one item at a time**, verify, and keep the rollback ready. Order matters.

---

## 0. Pre-cutover snapshot (always reversible)
```bash
# On the server, before anything:
tar czf /root/backup-files-$(date +%F).tgz /var/www/bandanbhagwati
mysqldump -u root -p bandan > /root/backup-db-$(date +%F).sql
```
Rollback for the whole deploy = restore these two.

---

## 1. Deploy the clean build (from this repo, NOT by patching a live tree)
```bash
cd /var/www/bandanbhagwati
git clone <your-repo> .            # or rsync the local project (exclude .env, vendor, node_modules, storage/*.key)
composer install --no-dev --optimize-autoloader
cp .env.production.example .env    # then edit real secrets
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force        # first deploy only; prints the generated admin password — save it
php artisan storage:link
php artisan optimize               # config + route + view cache
```
**Verify:** `https://bandanbhagwati.com` loads; `https://bandanbhagwati.com/admin/login` loads.
**Rollback:** restore snapshot from step 0.

---

## 2. File permissions (least privilege)
```bash
cd /var/www/bandanbhagwati
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache      # only these are writable by the web user
sudo chmod 600 .env                             # secrets not world-readable
```
**Verify:** site still loads; uploads via the admin file manager work.
**Rollback:** permissions rarely need rollback; if uploads break, re-run the `775 storage` line.

---

## 3. Web server hardening
- **Nginx:** install `deploy/nginx.conf`, then `nginx -t && systemctl reload nginx`.
- **Apache/cPanel:** follow `deploy/apache.md` (hardened `public/.htaccess` + `storage/.htaccess` + php.ini).

**Verify each (must all be true):**
```bash
curl -I https://bandanbhagwati.com/.env            # -> 403/404 (NOT 200)
curl -I https://bandanbhagwati.com/storage/test.php # -> 403 (PHP blocked in storage)
curl -I https://bandanbhagwati.com/                 # -> 200 + security headers present
curl -I https://bandanbhagwati.com/admin/login      # -> 200
```
**Rollback:** restore previous vhost/.htaccess and reload.

---

## 4. PHP-FPM / OPcache (`/etc/php/8.3/fpm/pool.d/www.conf` + php.ini)
```ini
; php.ini
expose_php = Off
display_errors = Off
log_errors = On
opcache.enable = 1
opcache.validate_timestamps = 0      ; prod: code doesn't change between deploys (clear OPcache on deploy)
opcache.memory_consumption = 192
opcache.max_accelerated_files = 20000
realpath_cache_size = 4096k
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,show_source
```
Reload: `systemctl reload php8.3-fpm`. On each future deploy run `php artisan optimize` and reload FPM (to clear OPcache).

---

## 5. Cloudflare (DNS proxied — orange cloud)
1. **SSL/TLS mode:** **Full (strict)** — never "Flexible" (it allows http origin loops).
2. **Always Use HTTPS:** On. **Automatic HTTPS Rewrites:** On. **HSTS:** enable (6mo+, includeSubDomains).
3. **WAF → Managed Rules:** enable Cloudflare Managed Ruleset + OWASP Core.
4. **Rate limiting:** rule on `/admin/login` and `/contact` → e.g. 10 req/min/IP → managed challenge.
5. **Bot Fight Mode:** On. Add **Turnstile** to the contact/enquiry forms if spam appears.
6. **Custom WAF rules:**
   - Block direct hits to sensitive paths: `(http.request.uri.path contains "/.env") or (http.request.uri.path contains "/.git") or (http.request.uri.path contains "/vendor/")` → **Block**.
   - Challenge `/admin*` from outside your country/IP if desired.
7. **Origin lockdown:** at the origin firewall, **allow only Cloudflare IP ranges** on 80/443 (https://www.cloudflare.com/ips/) so attackers can't bypass Cloudflare by hitting the IP directly.
8. **Restore real visitor IP** at the origin (so logs/throttling see the user, not Cloudflare): Nginx `ngx_http_realip_module` with `set_real_ip_from <cf-ranges>; real_ip_header CF-Connecting-IP;`. In Laravel, trust the proxy — `bootstrap/app.php` → `$middleware->trustProxies(at: '*')` (or the CF ranges).

**Rollback:** Cloudflare changes are per-rule; disable the specific rule. Set DNS to "DNS only" (grey cloud) to bypass entirely in an emergency.

---

## 6. Server-only hardening
```bash
# Firewall
sudo ufw default deny incoming && sudo ufw allow OpenSSH && sudo ufw allow 'Nginx Full' && sudo ufw enable
# Fail2Ban (SSH + nginx)
sudo apt install fail2ban -y
# SSH: key-only, no root login  (/etc/ssh/sshd_config)
#   PermitRootLogin no
#   PasswordAuthentication no
sudo systemctl reload ssh
```

---

## 7. Post-deploy verification & monitoring
- Re-run all `curl -I` checks in step 3 — confirm clean.
- **Search Console:** add property, verify (paste code in Admin → Site Settings → `google_verification`), submit `https://bandanbhagwati.com/sitemap.xml`, Request Indexing for key pages.
- **Backups:** cron `mysqldump` + files nightly, stored off-host.
- **Integrity:** keep the git baseline; `git status` on the server should be clean — any unexpected diff = investigate.
- **Logs:** watch `storage/logs/laravel.log` + web access logs for repeated `/.env`, `/wp-*`, `/vendor/` probes.

---

## Definition of done
- [ ] `APP_DEBUG=false`, `APP_ENV=production`, secrets in `.env` (chmod 600), **admin password rotated** (`php artisan app:admin-password`).
- [ ] `/admin` reachable only by `is_admin` users (and optionally IP-restricted).
- [ ] `.env`, `.git`, `vendor/`, `storage/app` not web-reachable; PHP cannot execute under `storage`/uploads.
- [ ] Security headers present; HTTPS forced; Cloudflare Full(strict) + WAF + origin lockdown.
- [ ] Backups + Fail2Ban + firewall on; sitemap submitted.
