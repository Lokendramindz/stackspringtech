# Deployment guide — stackspringtech.com

## 1. Before you deploy
Set these in `.env` on the server (never commit `.env`):
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://stackspringtech.com
DB_CONNECTION=mysql   # DB_HOST / DB_DATABASE / DB_USERNAME / DB_PASSWORD
MAIL_MAILER=smtp      # MAIL_HOST / MAIL_PORT / MAIL_USERNAME / MAIL_PASSWORD / MAIL_FROM_ADDRESS
CONTACT_EMAIL=hello@stackspringtech.com
ADMIN_EMAIL=you@yourdomain.com
ADMIN_PASSWORD=<long unique password>   # set BEFORE seeding
SESSION_SECURE_COOKIE=true
```

## 2. Option A — VPS (Ubuntu + Nginx + PHP-FPM) — recommended
```bash
sudo apt install nginx mysql-server php8.3-fpm php8.3-{mysql,mbstring,xml,curl,zip,bcmath,intl} composer git
git clone <your-repo> /var/www/stackspring && cd /var/www/stackspring
composer install --no-dev --optimize-autoloader
cp .env.example .env && nano .env && php artisan key:generate
php artisan migrate --seed --force
sudo chown -R www-data:www-data storage bootstrap/cache
php artisan optimize        # caches config, routes, views
```
Nginx site (`/etc/nginx/sites-available/stackspringtech.com`):
```nginx
server {
    server_name stackspringtech.com www.stackspringtech.com;
    root /var/www/stackspring/public;
    index index.php;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Referrer-Policy "strict-origin-when-cross-origin";
    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ { include snippets/fastcgi-php.conf; fastcgi_pass unix:/run/php/php8.3-fpm.sock; }
    location ~ /\.(?!well-known) { deny all; }
}
```
Enable it, then HTTPS: `sudo certbot --nginx -d stackspringtech.com -d www.stackspringtech.com`.

## 3. Option B — shared hosting / cPanel
1. Upload the project **outside** `public_html`; point the domain's document root to the project's `public/` folder (or copy `public/*` into `public_html` and edit the two paths in `index.php`).
2. Run Composer via SSH, or run `composer install --no-dev` locally and upload `vendor/`.
3. Create a MySQL DB in cPanel, fill `.env`, then `php artisan key:generate && php artisan migrate --seed --force`.
4. Make `storage/` and `bootstrap/cache/` writable (775).

## 4. Updating later
```bash
git pull && composer install --no-dev -o && php artisan migrate --force && php artisan optimize:clear && php artisan optimize
```

## 5. Launch checklist
- [ ] Admin password changed; no other user accounts exist.
- [ ] `APP_DEBUG=false`; HTTPS working; test the contact form and confirm the email arrives.
- [ ] Packages, prices and About text reviewed in admin (seeded values are indicative).
- [ ] Domain/trademark checks from the launch plan completed.
- [ ] Submit `https://stackspringtech.com/sitemap.xml` in Google Search Console; verify the domain.
- [ ] Add per-page SEO title/description in admin (Meta fields on services, posts, pages).
- [ ] Set up daily DB backups (e.g. `mysqldump` cron) and uptime monitoring.
