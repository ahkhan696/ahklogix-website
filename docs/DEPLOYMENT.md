# DEPLOYMENT.md — Taking ahklogix.com live (Laravel on Hostinger)

Production deployment plan for the AHKLOGIX website (Laravel + MySQL + Filament).
Place in `docs/`. This is the big win of the PHP stack: it deploys to the Hostinger
plan you already have, using the MySQL database included in that plan — no external
database or storage accounts needed.

---

## 1. Key facts

- **Host:** existing Hostinger shared/business plan (native PHP + MySQL).
- **Database:** a MySQL database created in hPanel (included in the plan). Local dev
  uses XAMPP MySQL; production uses Hostinger MySQL. Same engine, no adapter changes —
  only `.env` values differ.
- **Media uploads:** stored on the server disk (`storage/app/public` → symlinked).
  Persistent on shared hosting — no blob storage needed. Include uploads in backups.
- **Deploys:** Git auto-deploy from a private GitHub repo via hPanel (the same
  workflow used for other client projects), or manual via hPanel Git pull.
- **PHP version:** set to 8.3+ in hPanel for the domain.

## 2. Pre-deploy checklist (code)

1. `.env` is gitignored; `.env.example` documents every variable (APP_KEY, DB_*,
   MAIL_*, settings fallbacks).
2. `APP_ENV=production`, `APP_DEBUG=false` on live. Strong admin password (replace the
   seeded dev credential).
3. Production build of assets: `npm run build` → commit or build in CI; Vite manifest
   present. (Shared hosting doesn't run Node at request time — assets are prebuilt.)
4. Contact form mail configured (Hostinger SMTP or transactional provider) — test it.
5. HTTPS forced (Hostinger SSL is free/managed); `APP_URL=https://ahklogix.com`.

## 3. Hostinger structure (document root)

Laravel must serve from its `public/` folder. On Hostinger, the standard approach:

- Deploy the repo to a folder OUTSIDE `public_html` (e.g. `~/ahklogix`), then point the
  domain's document root to `~/ahklogix/public` (hPanel allows changing the doc root),
  **or** deploy into `public_html` and set the doc root to `public_html/public`.
- Do NOT use the old "copy public/* into public_html and edit index.php paths" hack
  unless doc-root change is unavailable — it complicates every future deploy.

## 4. Go-live steps (in order)

1. **Push to GitHub** (private repo `ahklogix-website-laravel`).
2. **Create the MySQL database** in hPanel (database + user + password). Note the
   credentials and DB host.
3. **Connect Git in hPanel** (Websites → your domain → Git): repo URL + branch,
   deploy path. Enable auto-deploy webhook so pushes redeploy.
4. **Server setup (one time)** via hPanel SSH/terminal:
   - `composer install --no-dev --optimize-autoloader`
   - copy `.env.example` → `.env`, fill production values, `php artisan key:generate`
   - `php artisan migrate --seed` (seed only what production needs: admin user, settings)
   - `php artisan storage:link`
   - `php artisan config:cache && php artisan route:cache && php artisan view:cache`
5. **Point document root** to the app's `public` folder; verify PHP 8.3 selected.
6. **SSL + domain check:** https://ahklogix.com loads; www redirect configured.
7. **First-run:** log into `/admin`, change the admin password, verify content, upload
   the real logo, submit a test contact form (check email + admin resource).
8. **Post-launch:** sitemap.xml + robots.txt reachable; Lighthouse pass; submit sitemap
   in Google Search Console; set up hPanel automatic backups (files + database).

## 5. Ongoing workflow

- `git push` → Hostinger auto-deploys. After deploys that change DB or config, run
  `php artisan migrate --force` and re-cache config/routes/views (can be scripted in a
  post-deploy hook).
- Content edits happen in `/admin` on the live site — stored in MySQL, untouched by
  deploys.
- Weekly automatic backups in hPanel; test a restore once.

---

## Deployment phases (feed Claude Code ONE at a time)

- **Phase D1 — Production readiness:** `.env.example`, debug/env hardening, mail setup,
  prebuilt assets, storage symlink handling, deploy script/hook (composer install,
  migrate --force, caches). Verify `npm run build` + a production-mode boot locally. STOP.
- **Phase D2 — Deploy assist:** walk me through hPanel step-by-step: MySQL database
  creation, Git connection + auto-deploy, document root change, SSH one-time setup
  commands, SSL/domain verification, first-run checklist. STOP.
