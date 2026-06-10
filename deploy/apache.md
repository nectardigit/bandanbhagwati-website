# Apache / cPanel hardening

Use this when the host runs **Apache** (most shared/cPanel hosting). Nginx users: use `deploy/nginx.conf` instead.

## 0. Document root
Point the domain's document root at the project's **`public/`** folder (cPanel → *Domains* → set "Document Root" to `.../bandanbhagwati/public`).
**Never** serve the project root — that exposes `.env`, `vendor/`, `storage/`.
If you cannot change the docroot, see step 3.

---

## 1. Hardened `public/.htaccess`
Replace the default Laravel `public/.htaccess` with this (it keeps Laravel routing and adds headers):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Force HTTPS + apex (non-www)
    RewriteCond %{HTTPS} off [OR]
    RewriteCond %{HTTP_HOST} ^www\. [NC]
    RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]
    RewriteRule ^ https://%1%{REQUEST_URI} [L,R=301]

    # Handle Authorization header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect trailing slashes
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Front controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

<IfModule mod_headers.c>
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=(), payment=()"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    Header always set Content-Security-Policy "default-src 'self'; img-src 'self' data: https:; media-src 'self' https:; font-src 'self' https://fonts.gstatic.com data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; script-src 'self' 'unsafe-inline' 'unsafe-eval'; frame-ancestors 'self'; base-uri 'self'; form-action 'self';"
    Header unset X-Powered-By
    Header always unset X-Powered-By
</IfModule>

# Block access to dotfiles / sensitive files
<FilesMatch "(^\.|\.(env|git|gitignore|lock|sql|sqlite|bak|old|swp|dist|ini|log|sh)$)">
    Require all denied
</FilesMatch>

ServerSignature Off
```

---

## 2. Block PHP execution in writable folders
Create **`storage/.htaccess`** (and the same in any uploads dir) so a planted shell can't run:

```apache
# storage/.htaccess
<FilesMatch "\.(php|phtml|php3|php4|php5|php7|phar|cgi|pl)$">
    Require all denied
</FilesMatch>
php_flag engine off
Options -ExecCGI -Indexes
```

> The unisharp file manager writes to `storage/app/public/...` (symlinked to `public/storage`).
> Add the same `.htaccess` inside `public/storage/` too.

---

## 3. If you are forced to use the project root as docroot (last resort)
Put this `.htaccess` in the **project root** to push everything into `public/` and hide the rest:

```apache
RewriteEngine On
RewriteRule ^(\.env|composer\.(json|lock)|artisan|storage|vendor|bootstrap|database|app|config|routes|resources/views) - [F,L]
RewriteRule ^(.*)$ public/$1 [L]
```
This is weaker than a correct docroot — prefer step 0.

---

## 4. php.ini (cPanel → MultiPHP INI Editor)
```ini
expose_php = Off
display_errors = Off
display_startup_errors = Off
allow_url_fopen = Off            ; if nothing needs remote fopen (test first)
allow_url_include = Off
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_multi_exec,parse_ini_file,show_source
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```
> Test after enabling `disable_functions` — the image localiser used `Http` (cURL) but not the disabled ones; unisharp uses GD, not exec.
