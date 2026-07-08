# ROADMAP.md — Future development: AI chatbot & subscription apps (Laravel)

Forward plan for extending the AHKLOGIX website into (a) an AI customer chatbot and
(b) a platform of subscription-based mini-apps (e.g. e-commerce pricing calculator).
Build AFTER the main site is live and stable. One phase per session via Claude Code.

---

## 1. Stack verdict

**Laravel is an excellent fit for both features — arguably better for the owner than
the Node stack, because the whole SaaS layer is first-party Laravel:**

| Need | Addition |
|---|---|
| Customer accounts (separate from admin) | Laravel auth (Breeze/Fortify) on a `customers` guard/table |
| Subscriptions & payments | **Laravel Cashier (Stripe)** — official package: checkout, webhooks, billing portal, `subscribed()` checks |
| Paid-feature gating | Middleware + policy checks (`$user->subscribed('pro')`) |
| AI chatbot | Anthropic Claude API via Laravel HTTP client; SSE streaming route; Alpine chat UI |

Nothing in the main site changes; these layer on top.

---

## 2. Feature A — AI customer chatbot

**Goal:** a live chatbot on ahklogix.com answering questions about services, process,
pricing, and POSR — doubling as a sales demo, since AI chatbots are a service the studio
sells. "Talk to the same bot we'll build for you."

**Architecture:**
- Backend: `POST /api/chat` route calling the **Claude API** (Messages API, streaming via
  SSE). API key server-side in `.env` (`ANTHROPIC_API_KEY`) — never exposed to the browser.
- Knowledge: system prompt assembled from DB content (services, FAQs, POSR features,
  process, contact options) so answers stay current with admin edits. Cache the compiled
  prompt; bust on model save. Prompt-stuffing is enough at this content size.
- Frontend: upgrade the chatbot bubble into a chat panel (Alpine + streamed fetch):
  open/close, message list, streaming text, mobile-friendly.
- Behaviors: answer from studio knowledge; on hire/quote intent, hand off to WhatsApp /
  booking / contact form. Log conversations to a `chat_sessions` table (+ Filament
  resource) for lead insight — disclose logging in the widget.
- Guardrails: scope to studio topics; rate-limit the route (Laravel RateLimiter); cap
  message length; graceful fallback on API errors.

**Phases:**
- **C1 — Chat API route:** Claude API integration, streaming, system prompt from DB,
  rate limiting. Test via curl. STOP.
- **C2 — Chat UI:** bubble → full streaming chat panel, brand styling. STOP.
- **C3 — Handoff + logging:** intent handoff, `chat_sessions` + Filament resource. STOP.

---

## 3. Feature B — Subscription apps platform

**Goal:** an `/apps` section presenting mini-apps as tiles; each app has its own page;
free features open to everyone (or after free signup); premium features require an active
subscription. First app: **e-commerce pricing calculator** (marketplace fees, COGS,
margins, profit) — ideal first candidate: pure logic, no heavy infra.

**Information architecture:**
```
/apps                → tiles grid (from an `apps` table)
/apps/{slug}         → app landing: what it does, free vs pro, screenshots, CTA
/apps/{slug}/use     → the actual app UI (Livewire component; pro features gated)
/account             → customer dashboard: profile, plan, billing portal link
/login, /register    → customer auth (separate from /admin Filament login)
```

**Data model additions:**
- `customers` — auth table (separate guard from Filament admin users): name, email,
  password; Cashier adds `stripe_id` + subscription tables via its migrations.
- `apps` — title, slug, icon, tile image, description, feature_list (JSON, each item
  flagged free/pro), status (live/coming-soon).
- Filament resources for both (admin visibility of customers + subscriptions).

**Payments (Laravel Cashier + Stripe):**
- Products/Prices in Stripe (monthly/yearly). Start with ONE "Pro" plan covering all
  apps — simplest; per-app pricing later if needed.
- Checkout: Cashier's Stripe Checkout integration; success/cancel back to the app page.
- Webhooks: Cashier's built-in webhook controller keeps subscription state in sync.
- Billing management: Stripe Customer Portal link from `/account` (no custom billing UI).

**Gating pattern:**
- Middleware/policies check `$customer->subscribed('pro')` before executing pro features
  — server-side always; never gate client-side only.
- Free tier: calculator basic mode. Pro examples: saved scenarios, multi-marketplace fee
  profiles, export to Excel/PDF, bulk calculations.

**Phases:**
- **S1 — Customer auth:** `customers` guard + register/login/logout + `/account` shell. STOP.
- **S2 — Apps catalog:** `apps` table + Filament resource, `/apps` tiles, `/apps/{slug}`
  landing pages. STOP.
- **S3 — First app (free tier):** pricing calculator as a Livewire component at
  `/apps/pricing-calculator/use`, polished UX. STOP.
- **S4 — Stripe subscriptions:** Cashier install, products/prices, Checkout, webhooks,
  Customer Portal link. Test fully in Stripe test mode. STOP.
- **S5 — Gating + pro features:** middleware/policies, pro features (saved scenarios,
  exports), upgrade prompts. STOP.
- **S6 — Polish + analytics:** empty/error states, usage tracking, Filament views of
  customers/subscriptions. STOP.

---

## 4. Sequencing

1. Launch the marketing site (DEPLOYMENT.md) — live and indexed first.
2. Chatbot (C1–C3) — fastest win, immediate sales asset.
3. Apps platform (S1–S6) — bigger lift; validate with the calculator before more apps.

## 5. New env vars / accounts (when these start)

- `ANTHROPIC_API_KEY` — Claude API (chatbot)
- `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET` (Cashier)
- Stripe account, test mode for all development

## 6. Hosting note for later

The marketing site + chatbot run fine on shared hosting. If the apps platform grows
(webhooks, queues, scheduled jobs), consider moving to a small VPS with the same Laravel
codebase — zero code changes, just better process control (queue workers, cron).
Laravel's scheduler + queue can run on shared hosting via cron with `queue:work --stop-when-empty`,
which is enough to start.
