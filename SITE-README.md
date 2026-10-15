# StackSpring Technologies — Laravel site + admin (Laravel 11/12, PHP 8.2+)

`./install.sh` creates a fresh Laravel app, copies these files in, migrates and seeds.

**Public:** Home, About, Services (+detail pages), Packages, Blog (+posts), Contact (lead form).
**Admin (/admin/login):** dashboard, lead manager (search, status, notes, delete), CRUD for services, packages, posts and pages (About). Body fields accept Markdown.

- Set `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env` before running the seeder; change the password afterwards. Don't register extra users — any user can log in to admin.
- Set `MAIL_*` and `CONTACT_EMAIL` so lead emails are delivered (otherwise they're only logged; leads are always saved).
- Seeded packages/prices are indicative from the launch plan — edit in admin before launch.
- Production: `APP_ENV=production`, `APP_DEBUG=false`, `php artisan config:cache`.

## SEO & launch
Per-page meta title/description (services, posts, pages), canonical URLs, Open Graph/Twitter tags, Organization JSON-LD, `/sitemap.xml`, `robots.txt` (admin blocked), custom 404. See `DEPLOYMENT.md` for server setup and the launch checklist.
