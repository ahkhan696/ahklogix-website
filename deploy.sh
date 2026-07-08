#!/usr/bin/env bash
# deploy.sh — run on the server after each git pull
# Usage: bash deploy.sh
set -euo pipefail

echo "── Composer ────────────────────────────────────────────────"
composer install --no-dev --optimize-autoloader

echo "── Database ────────────────────────────────────────────────"
php artisan migrate --force

echo "── Storage symlink ─────────────────────────────────────────"
php artisan storage:link --quiet 2>/dev/null || true

echo "── Caches ──────────────────────────────────────────────────"
php artisan config:cache
# route:cache is intentionally omitted — Livewire 3 registers routes via
# closures that are incompatible with the route cache on this host.
# view:cache is intentionally omitted — Filament uses dynamic anonymous
# components that cannot be precompiled. Views are cached on first request.

echo "── Done ────────────────────────────────────────────────────"
