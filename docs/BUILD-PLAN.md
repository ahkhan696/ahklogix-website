# BUILD-PLAN.md — AHKLOGIX website (Laravel)

Detailed build spec and phase order. Stack, brand tokens, and conventions are defined in
the root `CLAUDE.md` (canonical) — this file adds page-level detail and the build sequence.

Work **one phase at a time** (see "Build phases" at the bottom). Propose a plan, get
approval, build, then stop and suggest a commit.

---

## 1. Site structure (routes)

```
/                      Home (landing — full narrative, conversion-focused)
/services              Services overview hub
/services/{slug}       Individual service detail page (from DB)
/portfolio             Portfolio grid (filterable)
/portfolio/{slug}      Case study detail page (from DB)
/posr                  POSR product page (Point of Sale for Restaurants)
/blog                  Blog index (from DB)
/blog/{slug}           Blog post detail page (from DB)
/about                 About / team / process
/contact               Contact page (form + WhatsApp + book a call)
/faq                   FAQ page (from DB)
/admin                 Filament admin panel
```

Site-wide: floating WhatsApp "Start a project" button, persistent "Book a call" button,
and an AI-chatbot bubble placeholder bottom-right (renders embed code from Settings if
present; real chatbot later per ROADMAP.md).

## 2. Home page sections (in order)

1. **Header / nav** — logo left; links: Services, Portfolio, POSR, Blog, About, Contact;
   right: "Book a call" (secondary) + "Start a project" (gradient → WhatsApp). Sticky,
   shrinks on scroll, mobile hamburger (Alpine).
2. **Hero** — outcome-focused headline (one word in brand gradient), subhead, two CTAs,
   sample hero image/illustration.
3. **Trust bar** — 250+ projects, 50+ happy clients, platforms (Fiverr, Upwork, direct).
   Big numbers, count-up on scroll (Alpine intersection observer).
4. **Services** — grid of service cards from DB (icon, title, one-liner, link to detail).
5. **Portfolio highlights** — 3–6 featured projects (`featured` flag), sample images.
6. **Why choose us** — 3–4 differentiators (e.g. "We build on the stack we recommend",
   "CRM + AI baked into delivery", "250+ projects of proof").
7. **Process** — Discovery → Planning → Build & Test → Launch & Support. Horizontal
   timeline on desktop with a gradient connector, stacked on mobile.
8. **POSR teaser** — short product callout + sample screenshot, link to `/posr`.
9. **Reviews** — carousel/grid from DB (name, company, photo, rating, quote).
10. **FAQ preview** — top 4–5 FAQs accordion from DB, link to `/faq`.
11. **Final CTA band** — gradient-accented "Ready to start?" with both CTAs.
12. **Footer** — mono logo, nav, services list, contact (email, WhatsApp), socials, copyright.

## 3. Other pages

- **/services** — intro + grid of all services → `/services/{slug}`.
- **/services/{slug}** — hero, problem framing, what's included, related portfolio, CTA.
  SEO-targeted per service (e.g. "Zoho implementation", "GoHighLevel setup",
  "Make.com automation", "AI chatbot development").
- **/portfolio** — filterable grid (filter by category/service tag).
- **/portfolio/{slug}** — case study: client, problem, solution, stack, sample images,
  results, testimonial, CTA.
- **/posr** — product page: hero, feature list, sample screenshots, who it's for
  (restaurant owners), pricing or "request demo" CTA.
- **/blog** + **/blog/{slug}** — index cards (cover, title, excerpt, date, tags) and full
  posts (rich text, cover, author, reading time, related posts).
- **/about** — studio story, team (web/mobile/marketing/SEO), process, the numbers.
- **/contact** — form (name, email, company, service of interest, message) with server
  validation + honeypot/rate limit; WhatsApp button; "Book a call" (Cal.com or GHL embed —
  placeholder URL from Settings); email; response-time note.
- **/faq** — full accordion grouped by category.

## 4. Data model + Filament admin (this IS the admin dashboard)

Migrations + Eloquent models + Filament resources (all CRUD at `/admin`):

- **services** — title, slug, icon, short_description, body (rich editor), featured,
  order, seo_title, seo_description.
- **projects** (portfolio) — title, slug, client, category/tags, cover image + gallery
  (medialibrary), problem, solution, stack, results (rich editor), featured, order, SEO fields.
- **reviews** — name, company, photo (medialibrary), rating (1–5), quote, featured, order.
- **faqs** — question, answer (rich editor), category (enum/select), order.
- **posts** (blog) — title, slug, cover image, excerpt, body (rich editor), author, tags,
  published_at, status (draft/published), SEO fields.
- **contact_submissions** — name, email, company, service, message, status (new/handled);
  read-only-ish Filament resource so leads are visible in admin.
- **settings** — key/value (or spatie/laravel-settings): contact email, WhatsApp number,
  socials, booking URL, chatbot embed code. Filament Settings page.

Admin auth: Filament login; one admin user seeded (change password in production).
Filament resources use sensible list columns, filters (featured/status), and ordering.

## 5. Functionality

- **WhatsApp CTAs** → `https://wa.me/{number}?text={prefilled}` (number from Settings).
- **Book a call** → booking URL from Settings (Cal.com / GHL embed; placeholder).
- **Contact form** → validated POST; stores to `contact_submissions`, sends notification
  email (Laravel Mail, log driver in dev), and leaves a clearly-marked TODO + placeholder
  for the **GoHighLevel** webhook so leads flow into the studio's CRM. Success/error states.
- **AI chatbot** → bubble component renders Settings embed code if present.
- **FAQ accordion** → accessible (button + `aria-expanded`), Alpine.
- **Newsletter (optional)** → footer email capture into a `subscribers` table.

## 6. SEO & performance

- Layout meta slots per page (title, description, OG, Twitter), driven by model SEO
  fields where available; canonical URLs.
- `spatie/laravel-sitemap` generating sitemap.xml (all public routes + slugs); robots.txt.
- JSON-LD Blade partials: `Organization` (home), `Service` (service pages), `BlogPosting`
  (posts), `FAQPage` (faq), `Product` (POSR).
- Semantic HTML, one `<h1>` per page; responsive webp conversions via medialibrary;
  lazy-loading; query/view caching with cache-busting on model save.
- Target Lighthouse 95+; no layout shift; clean slug URLs.

## 7. Images

Placeholder/sample images everywhere (hero, services, portfolio, POSR, blog covers, team,
avatars) with correct dimensions and alt text so the owner swaps real images later without
layout breakage. Don't block the build waiting on assets.

## 8. Animations & motion (landing page)

Motion principles are canonical in `CLAUDE.md` (200–400ms, ease-out, transform/opacity
only, once-on-first-view, `prefers-reduced-motion` kill switch). The landing page motion
system, in build priority order:

1. **Hero network background** (signature, on-brand — the logo mark is a neural network):
   a lightweight vanilla-JS `<canvas>` behind the hero — 30–50 slowly drifting nodes,
   lines connecting nodes within proximity, faint brand colors (violet/magenta/blue at
   low opacity on white). Subtle mouse-proximity attraction on desktop. Must be cheap:
   requestAnimationFrame, capped device-pixel ratio, paused when tab hidden, disabled
   entirely under reduced-motion and on very small screens.
2. **Hero entrance stagger:** headline, subhead, CTAs, and hero visual fade + slide up
   in sequence (~80ms stagger) on page load.
3. **Rotating headline word:** one slot in the hero headline cycles through offerings —
   "web apps" → "automations" → "AI chatbots" → "CRM systems" — vertical flip/fade every
   ~2.5s (Alpine). The rotating word carries the brand gradient.
4. **Scroll reveals:** every home section's children fade + translate-up on first entry
   into viewport (Alpine `x-intersect`, staggered). One shared Blade component/directive
   so it's consistent, e.g. `<x-reveal>`.
5. **Count-up stats** (trust bar): animate 0 → value on first view, ~1.2s ease-out.
6. **Card hover:** portfolio/service cards lift 4–6px with a soft shadow and a 1px
   gradient border fade-in; icon nudges. 200ms.
7. **Process timeline draw:** the gradient connector line "draws" across (scaleX with
   transform-origin left; stroke-dashoffset if SVG) as the section scrolls into view;
   step dots pop in sequence.
8. **Button micro-interactions:** primary gradient shifts hue slightly + arrow icon
   translates 2–3px on hover; active state compresses 1px.
9. **Header:** shrink + backdrop-blur + hairline border fade-in after ~50px scroll.
10. **Chatbot bubble:** single gentle pulse every ~8s (attention without annoyance).
11. **Marquee (optional, only if it looks clean):** slow auto-scrolling strip of
    tech/platform names the studio works with (Laravel, Zoho, GoHighLevel, Make, Stripe,
    AI) — pause on hover, duplicate-list CSS animation technique.

Restraint rules: no parallax-heavy scenes, no scroll-jacking, no spinning/bouncing
gimmicks, nothing animating on loop in content areas (only the hero canvas and the
optional marquee are continuous, both subtle). Inner pages reuse only reveals + hovers.

---

## Build phases (do ONE per session, then stop)

1. **Scaffold** — Laravel 12 + Vite + Tailwind v4 + brand tokens + fonts; MySQL connected
   (XAMPP); Filament 4 installed; admin user seeded. Verify `/admin` login works. STOP.
2. **Design system & layout** — main Blade layout, header (incl. scroll shrink), footer,
   buttons (incl. hover micro-interactions), typography, container, WhatsApp + Book-a-call +
   chatbot-bubble components, meta slots, and the motion primitives: `x-intersect` setup,
   `<x-reveal>` component, reduced-motion kill switch (§8 items 4, 8, 9, 10). STOP.
3. **Data model + admin** — all migrations, models, seeders (sample content), Filament
   resources + Settings page + contact_submissions resource. Verify CRUD in `/admin`. STOP.
4. **Home page** — all 12 sections with sample content/images, pulling from DB, plus the
   landing motion system from §8: hero network canvas, hero entrance stagger, rotating
   headline word, scroll reveals on all sections, count-up stats, card hovers, timeline
   draw (§8 items 1–7). STOP.
5. **Inner pages** — services hub + detail, portfolio grid + case study, POSR, about, faq. STOP.
6. **Blog** — index + post pages, rich-text rendering, tags, related posts. STOP.
7. **Contact + lead flow** — form, validation, storage + email notification, GHL webhook
   placeholder, booking embed. STOP.
8. **SEO + performance pass** — meta/OG, sitemap, robots, JSON-LD, image conversions,
   caching, Lighthouse tuning. STOP.
9. **Polish** — motion QA pass (§8: timing consistency, reduced-motion verified, hero
   canvas performance on mobile, no jank/layout shift), optional tech marquee (§8 item 11)
   if it looks clean, remaining Alpine transitions, responsive QA, accessibility, empty
   states, 404 page. STOP.

After each phase: summarize changes and suggest a commit message. Wait for me before the
next phase.
