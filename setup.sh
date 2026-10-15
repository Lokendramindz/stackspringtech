#!/usr/bin/env bash
# One-time local setup. Needs PHP 8.2+ and Composer.
set -e
composer install
[ -f .env ] || cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # remove if you use MySQL (edit DB_* in .env)
php artisan migrate --seed
echo "Ready: php artisan serve  ->  http://localhost:8000   Admin: /admin/login  (ADMIN_EMAIL / ADMIN_PASSWORD from .env)"
