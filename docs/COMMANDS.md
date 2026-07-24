# COMMANDS.md — Claude Code prompts for every phase

Copy-paste one prompt per session. Rhythm every time:
**fresh session (or `/clear`) → send prompt → review plan → approve → let it build →
test yourself → `git add . && git commit -m "..."` → next phase.**

Do NOT batch phases. Do not start a phase until the previous one is tested + committed.

---

## Build phases (docs/BUILD-PLAN.md)

**Phase 1 — Scaffold**
> Read docs/BUILD-PLAN.md. Do Phase 1 only (scaffold: Laravel 12 + Vite + Tailwind v4 +
> brand tokens + fonts, MySQL connected via XAMPP, Filament 4 installed, admin user
> seeded — verify /admin login works). Plan first, wait for my approval, then stop.
> Don't start Phase 2.

Commit: `Phase 1: Laravel + Tailwind v4 + Filament scaffold`
(Before sending: make sure XAMPP's MySQL service is running.)

**Phase 2 — Design system & layout**
> Read docs/BUILD-PLAN.md. Do Phase 2 only (design system & layout: main Blade layout,
> header with scroll shrink, footer, buttons with hover micro-interactions, typography,
> container, WhatsApp + Book-a-call + chatbot-bubble components, meta slots, and the
> motion primitives from §8 — x-intersect setup, the <x-reveal> component, and the
> prefers-reduced-motion kill switch). Plan first, wait for my approval, then stop.

Commit: `Phase 2: design system, layout, motion primitives`

**Phase 3 — Data model + admin**
> Read docs/BUILD-PLAN.md. Do Phase 3 only (data model + admin: all migrations, models,
> seeders with sample content, Filament resources for services, projects, reviews, faqs,
> posts, contact_submissions, plus the Settings page — verify CRUD works in /admin).
> Plan first, wait for my approval, then stop.

Commit: `Phase 3: data model, seeders, Filament admin`

**Phase 4 — Home page**
> Read docs/BUILD-PLAN.md. Do Phase 4 only (home page: all 12 sections with sample
> content/images pulling from the database, plus the landing motion system from §8 —
> hero network canvas, hero entrance stagger, rotating headline word, scroll reveals on
> all sections, count-up stats, card hovers, and the process timeline draw). Plan first,
> wait for my approval, then stop.

Commit: `Phase 4: home page + landing animations`
(Test the hero canvas on your phone too, not just desktop.)

**Phase 5 — Inner pages**
> Read docs/BUILD-PLAN.md. Do Phase 5 only (inner pages: services hub + service detail,
> portfolio grid with filters + case study pages, POSR product page, about, and faq).
> Plan first, wait for my approval, then stop.

Commit: `Phase 5: inner pages`

**Phase 6 — Blog**
> Read docs/BUILD-PLAN.md. Do Phase 6 only (blog: index + post pages, rich-text
> rendering, tags, related posts). Plan first, wait for my approval, then stop.

Commit: `Phase 6: blog`

**Phase 7 — Contact + lead flow**
> Read docs/BUILD-PLAN.md. Do Phase 7 only (contact + lead flow: validated form with
> honeypot/rate limit, storage to contact_submissions, email notification, GoHighLevel
> webhook placeholder, booking-calendar embed from Settings). Plan first, wait for my
> approval, then stop.

Commit: `Phase 7: contact form + lead flow`

**Phase 8 — SEO + performance**
> Read docs/BUILD-PLAN.md. Do Phase 8 only (SEO + performance: per-page meta/OG,
> sitemap via spatie/laravel-sitemap, robots.txt, JSON-LD partials, medialibrary image
> conversions, caching with cache-busting on save, Lighthouse tuning). Plan first, wait
> for my approval, then stop.

Commit: `Phase 8: SEO + performance`

**Phase 9 — Polish**
> Read docs/BUILD-PLAN.md. Do Phase 9 only (polish: motion QA pass per §8 — timing
> consistency, reduced-motion verified, hero canvas performance on mobile, no jank —
> plus the optional tech marquee if it looks clean, remaining Alpine transitions,
> responsive QA, accessibility, empty states, and a 404 page). Plan first, wait for my
> approval, then stop.

Commit: `Phase 9: polish + motion QA`

---

## Deployment phases (docs/DEPLOYMENT.md) — after Phase 9

**Phase D1 — Production readiness**
> Read docs/DEPLOYMENT.md. Do Phase D1 only (production readiness: .env.example,
> debug/env hardening, mail setup, prebuilt Vite assets, storage symlink handling, and
> a deploy script/hook covering composer install, migrate --force, and config/route/view
> caches — verify npm run build passes and the app boots in production mode locally).
> Plan first, wait for my approval, then stop.

Commit: `Phase D1: production readiness`

**Phase D2 — Deploy assist (go live)**
> Read docs/DEPLOYMENT.md. Do Phase D2 only (deploy assist: walk me through hPanel
> step-by-step — MySQL database creation, Git connection with auto-deploy, document
> root change to the app's public folder, one-time SSH setup commands, SSL/domain
> verification, and the first-run checklist). I'm on Hostinger with the domain
> ahklogix.com. Go one step at a time and wait for me to confirm each step before
> continuing.

Commit (after live verification): `Phase D2: production deploy config`

---

## Chatbot phases (docs/ROADMAP.md) — after the site is live

Budget note: C1 was built Claude-only and Claude API needs prepaid credit. The plan now
is provider-agnostic — run on Google Gemini's **free tier** (or fully free rule-based)
and switch to a paid model later with one env variable. See ROADMAP.md §2.0.

**Phase C0 — Refactor to provider drivers** (replaces/extends the existing C1)
> Read docs/ROADMAP.md §2. Do Phase C0 only (refactor to drivers: extract the existing
> Claude-only chat API call behind a ChatDriver contract, add CHAT_DRIVER env switching,
> implement GeminiDriver for Google's free tier, and keep ClaudeDriver working). Test
> both via curl. Plan first, wait for my approval, then stop.

Commit: `Phase C0: provider-agnostic chat drivers`
(Before sending: get a free Gemini API key from Google AI Studio — no credit card needed.)

**Phase C0b — Rule-based fallback driver**
> Read docs/ROADMAP.md §2. Do Phase C0b only (RuleBasedDriver: answer from the faqs and
> services tables using keyword/full-text matching with WhatsApp handoff when there's no
> match, and wire it as the automatic fallback whenever the active driver errors, returns
> 429, or has no API key configured). Test by unsetting the API key. Plan first, wait for
> my approval, then stop.

Commit: `Phase C0b: rule-based fallback driver`

**Phase C2 — Chat UI**
> Read docs/ROADMAP.md §2. Do Phase C2 only (chat UI: upgrade the chatbot bubble into a
> full streaming chat panel with brand styling, open/close, message list, and
> mobile-friendly layout — it must work identically on any driver). Plan first, wait for
> my approval, then stop.

Commit: `Phase C2: chatbot UI`

**Phase C3 — Handoff + logging**
> Read docs/ROADMAP.md §2. Do Phase C3 only (handoff + logging: intent-based handoff to
> WhatsApp/booking/contact, chat_sessions table with a Filament resource, quota/error
> visibility in admin, per-IP rate limiting plus a CHAT_DAILY_LIMIT ceiling to protect the
> free quota, and logging disclosure in the widget). Plan first, wait for my approval,
> then stop.

Commit: `Phase C3: chatbot handoff + logging`

**Switching provider later (no phase needed)**
> Change CHAT_DRIVER in .env to `claude` (or `openai`) and make sure the matching API key
> is set. Confirm the chat route works, then clear config cache.

---

## Subscription apps phases (docs/ROADMAP.md)

**Phase S1 — Customer auth**
> Read docs/ROADMAP.md. Do Phase S1 only (customer auth: customers guard + table
> separate from the Filament admin, register/login/logout pages, and the /account
> shell). Plan first, wait for my approval, then stop.

Commit: `Phase S1: customer auth`

**Phase S2 — Apps catalog**
> Read docs/ROADMAP.md. Do Phase S2 only (apps catalog: apps table + Filament resource,
> the /apps tiles grid, and /apps/{slug} landing pages). Plan first, wait for my
> approval, then stop.

Commit: `Phase S2: apps catalog`

**Phase S3 — First app, free tier**
> Read docs/ROADMAP.md. Do Phase S3 only (first app, free tier: the e-commerce pricing
> calculator as a Livewire component at /apps/pricing-calculator/use with polished UX —
> free features only). Plan first, wait for my approval, then stop.

Commit: `Phase S3: pricing calculator (free tier)`

**Phase S4 — Stripe subscriptions**
> Read docs/ROADMAP.md. Do Phase S4 only (Stripe subscriptions: install Laravel
> Cashier, products/prices, Checkout flow, webhooks, and the Customer Portal link from
> /account — test everything in Stripe test mode). Plan first, wait for my approval,
> then stop.

Commit: `Phase S4: Stripe subscriptions (Cashier)`

**Phase S5 — Gating + pro features**
> Read docs/ROADMAP.md. Do Phase S5 only (gating + pro features: server-side
> middleware/policy checks on subscription status, the calculator's pro features —
> saved scenarios and exports — and upgrade prompts in the UI). Plan first, wait for my
> approval, then stop.

Commit: `Phase S5: feature gating + pro features`

**Phase S6 — Polish + analytics**
> Read docs/ROADMAP.md. Do Phase S6 only (polish + analytics: empty/error states, usage
> tracking, and Filament views of customers and subscriptions). Plan first, wait for my
> approval, then stop.

Commit: `Phase S6: apps platform polish`

---

## Handy extras (use anytime)

Fix a bug without starting a phase:
> [Describe the exact error + where it appears]. Investigate and fix it. Don't start
> any new phase.

Resume after a break:
> Read CLAUDE.md and docs/BUILD-PLAN.md. Summarize the current state of the project and
> which phase is next. Don't build anything yet.

Run the site locally:
> Start the local dev environment for me (confirm MySQL is reachable, run migrations if
> pending, npm run dev for Vite, and tell me the URL to open).
