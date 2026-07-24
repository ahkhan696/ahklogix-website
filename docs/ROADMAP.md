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
| AI chatbot | Provider-agnostic driver (Gemini free tier / Claude / OpenAI / rule-based) via Laravel HTTP client; SSE streaming route; Alpine chat UI |

Nothing in the main site changes; these layer on top.

---

## 2. Feature A — AI customer chatbot

**Goal:** a live chatbot on ahklogix.com answering questions about services, process,
pricing, and POSR — doubling as a sales demo, since AI chatbots are a service the studio
sells. "Talk to the same bot we'll build for you."

### 2.0 Budget decision (IMPORTANT — read before building)

LLM APIs are pay-as-you-go; there is no free ride via consumer subscriptions.
**ChatGPT Plus does NOT include API access** — the OpenAI API is billed separately.
Same for Claude Pro. So the chatbot must run on one of these:

| Mode | Cost | Notes |
|---|---|---|
| **A. Free-tier LLM (default for now)** | free | Google Gemini free tier (Flash / Flash-Lite). No credit card, no expiry, commercial use allowed. Rate-limited per day; Google may use free-tier data for training; limits change without notice — verify live figures in Google AI Studio. |
| **B. Paid LLM (best quality/reliability)** | small prepaid credit | Claude (Haiku-class) or OpenAI. Cheap per-conversation for a marketing site; no rate-limit anxiety, no training on your data. Switch to this when budget allows. |
| **C. Zero-API fallback** | free, forever | Rule-based FAQ bot: keyword/full-text match against the `faqs` + `services` tables, canned answers, handoff to WhatsApp when no match. No LLM at all. |

**Decision: build provider-agnostic, run on Mode A (Gemini free tier) now, with Mode C
as the automatic fallback when quota/API fails. Switching to Mode B later must be an
env-variable change, not a rewrite.**

### 2.1 Architecture (provider-agnostic)

- **Driver interface:** `ChatDriver` contract with `stream(array $messages, string $system)`.
  Implementations: `GeminiDriver`, `ClaudeDriver`, `OpenAiDriver`, `RuleBasedDriver`.
  Selected via `CHAT_DRIVER` in `.env` (`gemini` | `claude` | `openai` | `rules`).
  Bound in a service provider; the rest of the app never references a vendor directly.
  (Optionally evaluate a Laravel multi-LLM package such as Prism instead of hand-rolling —
  only if it doesn't add heavy dependencies.)
- **Backend:** `POST /api/chat` route → selected driver. Keys server-side in `.env`
  (`GEMINI_API_KEY` / `ANTHROPIC_API_KEY` / `OPENAI_API_KEY`) — never exposed to the browser.
- **Graceful degradation:** if the active driver errors, is rate-limited (429), or has no
  key configured, automatically fall back to `RuleBasedDriver` so the widget never appears
  broken to a prospect. Log the failure for the admin.
- **Knowledge:** system prompt assembled from DB content (services, FAQs, POSR features,
  process, contact options), cached and busted on model save. Prompt-stuffing is enough at
  this content size.
- **Frontend:** chatbot bubble → chat panel (Alpine + streamed fetch): open/close, message
  list, streaming text, mobile-friendly. Identical UI regardless of driver.
- **Guardrails:** scope to studio topics; rate-limit the route per IP/session (Laravel
  RateLimiter) to protect the free quota; cap message length and conversation turns;
  daily request ceiling so free-tier limits are never blown by a bot/scraper.
- **Privacy:** if running on a free tier whose provider may train on inputs, state briefly
  in the widget/privacy page that conversations are processed by a third-party AI provider.
  Never send customer-confidential data through a free tier.

### 2.2 Phases

- **C0 — Refactor to drivers (do this first; C1 already exists as Claude-only):**
  extract the existing Claude API call behind a `ChatDriver` contract, add `CHAT_DRIVER`
  env switching, add `GeminiDriver`, keep `ClaudeDriver` working. Test both via curl. STOP.
- **C0b — Rule-based fallback driver:** `RuleBasedDriver` answering from `faqs`/`services`
  with keyword/full-text matching + WhatsApp handoff; wire it as the automatic fallback on
  driver error/429/missing key. Test by unsetting the API key. STOP.
- **C2 — Chat UI:** bubble → full streaming chat panel, brand styling, mobile layout.
  Must work identically on any driver. STOP.
- **C3 — Handoff + logging:** intent-based handoff to WhatsApp/booking/contact,
  `chat_sessions` table + Filament resource, quota/error visibility in admin, logging
  disclosure in the widget. STOP.

*(If budget is zero and you want to ship sooner: run C0b + C2 + C3 only, with
`CHAT_DRIVER=rules`. The widget works, costs nothing, and upgrading later is one env
variable.)*

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
2. Chatbot (C0 → C0b → C2 → C3) — fastest win, immediate sales asset. Runs free on
   Gemini's free tier (or fully free rule-based), upgradeable to a paid model later by
   changing one env variable.
3. Apps platform (S1–S6) — bigger lift; validate with the calculator before more apps.
   NOTE: Stripe subscriptions (S4+) require a real budget/merchant setup — that's the
   phase where paid infrastructure genuinely starts.

## 5. New env vars / accounts (when these start)

Chatbot (only the key for the active driver is required):
- `CHAT_DRIVER` — `gemini` | `claude` | `openai` | `rules`
- `GEMINI_API_KEY` — Google AI Studio (free tier; no card required)
- `ANTHROPIC_API_KEY` — Claude API (paid; already set up)
- `OPENAI_API_KEY` — optional alternative (paid; NOT covered by ChatGPT Plus)
- `CHAT_DAILY_LIMIT` — safety ceiling so free-tier quota can't be exhausted by bots

Subscriptions:
- `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET` (Cashier)
- Stripe account, test mode for all development

## 6. Hosting note for later

The marketing site + chatbot run fine on shared hosting. If the apps platform grows
(webhooks, queues, scheduled jobs), consider moving to a small VPS with the same Laravel
codebase — zero code changes, just better process control (queue workers, cron).
Laravel's scheduler + queue can run on shared hosting via cron with `queue:work --stop-when-empty`,
which is enough to start.
