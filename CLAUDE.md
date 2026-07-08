# CLAUDE.md — AHKLOGIX website (Laravel)

Persistent context for this project. Keep this file lean. The full, detailed build
spec and phase order live in `docs/BUILD-PLAN.md` — read that file when asked to work
on a phase.

## What we're building

A fast, SEO-focused marketing website for **AHKLOGIX**, a software engineering studio
(custom web apps, API integration & automation, Zoho, GoHighLevel, Make.com, AI chatbots,
AI integration; plus mobile, digital marketing, SEO; and a product, **POSR** — Point of
Sale for Restaurants). The site is itself a portfolio piece, so code quality, performance,
and polish matter. The owner must be able to manage services, portfolio, reviews, FAQs, and
blog posts from an admin dashboard without touching code. Future roadmap (docs/ROADMAP.md):
AI chatbot + subscription-based mini-apps with Stripe.

## Stack (canonical — do not change without asking)

- **Laravel 12** (PHP 8.3+), **Blade** templates, server-rendered
- **Tailwind CSS v4** via Vite (brand tokens in the `@theme` block in `resources/css/app.css`)
- **MySQL** (local: XAMPP; production: Hostinger's included MySQL)
- **Filament 4** for the admin panel at `/admin` — do NOT hand-build an admin
- **Livewire 3** (comes with Filament) + **Alpine.js** (+ official `x-intersect` plugin)
  for interactive bits (accordions, carousels, mobile nav, count-up stats, scroll reveals)
- **spatie/laravel-medialibrary** for image uploads (stored on local disk — works on
  shared hosting), **spatie/laravel-sitemap** for the sitemap
- SEO handled with Blade layout meta slots + JSON-LD partials
- Dev environment: Windows + XAMPP (Apache + MySQL), `php artisan serve` or vhost;
  `npm run dev` only for Vite asset building

## Brand & design system (canonical)

Logo is in `public/images` (color + mono/white versions; a neural-network mark sits above
the wordmark). Use color logo on light backgrounds, white/mono on the dark footer.

Design principle: clean, light, premium, whitespace-heavy — NOT a dark-gradient agency
look. The brand gradient is a **signature accent used sparingly**, never a full-page or
full-card background.

Color tokens — define in the `@theme` block in `resources/css/app.css`:

| Token | Hex | Use |
|---|---|---|
| `indigo-ink` | `#1E1B4B` | Headings, primary text |
| `indigo-deep` | `#2D1B69` | Dark sections, wordmark tone |
| `violet` | `#7C3AED` | Primary accent, links, icons |
| `magenta` | `#EC1FC4` | Gradient start |
| `blue` | `#2E8BE6` | Gradient end |
| `bg` | `#FFFFFF` | Page background |
| `surface` | `#F7F7FB` | Cards / alternating sections |
| `border` | `#E7E7F0` | Hairline borders |
| `text-body` | `#44425A` | Body copy |
| `text-muted` | `#787690` | Secondary text |

Brand gradient: `linear-gradient(135deg, #EC1FC4 0%, #7C3AED 50%, #2E8BE6 100%)`.
Use it only for: the logo "X", primary CTA buttons, thin section-divider accent lines,
active nav/tab states, and one hero highlight word. Everything else is solid color on white.

Typography: `Space Grotesk` (headings, weight 500–700, tight tracking, sentence case —
never ALL CAPS or Title Case) and `Inter` (body, 16px, line-height 1.7) self-hosted or via
Bunny Fonts. Generous vertical rhythm.

Components: `rounded-xl`/`rounded-2xl`, soft 1px borders over heavy shadows, lots of padding.
Primary button = gradient fill + white text; secondary = white + violet border. Always add
hover and `focus-visible` states.

Motion (canonical): animations must feel engineered, not decorative — this is a software
studio and the site's motion is part of the proof. Defaults: 200–400ms, `ease-out`,
translate/opacity only (GPU-friendly; never animate layout properties), stagger 60–100ms,
elements animate in ONCE on first view. Implementation: CSS keyframes/transitions +
Alpine `x-intersect`; vanilla canvas for the hero network background. No heavy animation
libraries without asking. EVERY animation respects `prefers-reduced-motion` (global
media-query kill switch). Full motion spec: `docs/BUILD-PLAN.md` §8.

## Conventions

- Blade components (`resources/views/components`) for every reusable UI piece: header,
  footer, buttons, cards, section shells, WhatsApp/Book-a-call buttons, chatbot bubble.
- Eloquent models + migrations + seeders for all content types; Filament resources for
  admin CRUD. Keep controllers thin; view-model data via controllers or view composers.
- Route names for everything; slugs for public URLs.
- Images through medialibrary conversions (responsive sizes, webp), lazy-load below the
  fold, width/height set, meaningful alt text.
- Cache rendered pages/queries sensibly (`cache()->remember`) — content changes only via
  admin, so cache aggressively and bust on model save.
- Accessibility: WCAG AA contrast, keyboard nav, focus rings, `prefers-reduced-motion`.
- Use sample/placeholder images wherever real ones aren't available — never block on assets.
- Account-specific values (WhatsApp number, booking-calendar URL, GoHighLevel webhook,
  chatbot embed) live in a `settings` table (editable via a Filament Settings page), with
  env fallbacks. Mark TODOs clearly.

## How to work with me

- **Plan before acting.** For any non-trivial change, propose a short plan and wait for my
  approval before editing files.
- **One phase at a time.** Work a single phase from `docs/BUILD-PLAN.md`, then stop. Do not
  roll into the next phase unless I say so.
- After finishing a phase, summarize what changed and suggest a git commit message.
- Ask before adding new dependencies or changing the stack above.
- Prefer clarity and maintainability over cleverness — this site is a showcase of our work.

## Project structure (Laravel defaults + these specifics)

```
app/Models/            Service, Project, Review, Faq, Post, Setting
app/Filament/          Resources for each model + Settings page
app/Http/Controllers/  Page controllers (Home, Services, Portfolio, Posr, Blog, About,
                       Contact, Faq) + ContactSubmissionController
resources/views/
  layouts/app.blade.php          main layout (meta slots, header/footer, chatbot bubble)
  components/                    UI components
  pages/                         home, services, portfolio, posr, blog, about, contact, faq
resources/css/app.css            Tailwind v4 + @theme brand tokens
routes/web.php
database/migrations, seeders
public/images                    logo, sample images
```
