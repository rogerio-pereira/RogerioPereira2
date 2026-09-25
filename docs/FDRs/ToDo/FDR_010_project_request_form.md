# FDR-010: Project request form

**Feature:** 10
**Branch:** `feat/f10-project-request` · **Wave:** 3 · **Depends on:** [F07 Home page (static sections)](../../05%20-%20Feature%20List.md#f07-home-page-static-sections)

**References:**
- Feature List: [F10 Project request form](../../05%20-%20Feature%20List.md#f10-project-request-form)
- ADRs: [ADR-006](../../ADRs/ADR_006_project_request_flow.md), [ADR-007](../../ADRs/ADR_007_no_queues_workers_scheduler_redis.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [02 HLD](../../02%20HLD.md) (project request flow, integrations), [TURNSTILE_SETUP.md](../../integration/TURNSTILE_SETUP.md), [SLACK_SETUP.md](../../integration/SLACK_SETUP.md)
- FrontPorch (read-only): `ContactController`, `ContactRequest`, `ContactLeadSubmitted`, `SendLeadSlackNotification`, `SendLeadSchedulingEmail`, `LeadSchedulingEmail` + `resources/views/emails/lead-scheduling.blade.php`, `EventServiceProvider`, `Notifications/SlackNotification`, `config/services.php` (`slack`, `turnstile`), Turnstile props in `HandleInertiaRequests`, Turnstile widget code from `pages/home/component/ContactSection.vue`, `types/global.d.ts`, and their tests
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): the `#start` section of `index.html`

**Owns:** Turnstile and Slack packages and config, `ContactController`, `ContactRequest`, `ContactLeadSubmitted`, `SendLeadSlackNotification`, `SendLeadSchedulingEmail`, `LeadSchedulingEmail` + view, `EventServiceProvider`, `SlackNotification`, `pages/home/sections/StartSection.vue`.

---

## How it works

```
ContactController@store
  ContactRequest validates the fields and Turnstile
  → if RateLimiter says this IP already sent one in the last hour: back with a form error
  → ContactLeadSubmitted::dispatch($lead)
        SendLeadSlackNotification   (one attempt; try/catch → Log::error with the lead)
        SendLeadSchedulingEmail     (FrontPorch as is: 3 attempts → Log::error; no CALENDAR_URL → Log::warning)
  → RateLimiter::hit(key, 3600)
  → back() with the flash that shows the success panel
```

- Nothing is stored in the database; no email goes to Rogerio. FrontPorch's `SendLeadEmail` and `LeadEmail` are not ported. `EventServiceProvider` registers only the two listeners.
- **Validation (`ContactRequest`):** `name` required, max 255; `email` required, email, max 255; `website` `nullable|url|max:255`, with `prepareForValidation()` adding `https://` when a non-empty value starts with neither `http://` nor `https://`; `type` required array, each `in:website,system,ai,automation,consulting,not-sure`, distinct; `problem` required string, max 5000; `timeline` required `in:lt-1m,1-3m,3-6m,flexible`; `cf-turnstile-response` required + Turnstile. Custom messages only where the approved copy gives one; everything else uses Laravel's default messages.
- **Rate limit:** `RateLimiter`, key `contact:{ip}`, 1 per 3600 seconds, checked in `ContactController`; blocked → back with the message below on `form`; only a successful send counts (`RateLimiter::hit` after dispatch).
- **Turnstile:** required, fails closed; the widget sits above the submit row (dark theme).
- **`StartSection.vue`:** template markup and copy with the changes below (no honeypot); Inertia `useForm` with `preserveScroll`; chips as checkboxes; field errors in the template style; form-level error above the submit button (reuse `.field .err` styling in pink); "Sending…" state; success panel when the flash is present (`role="status"`). Turnstile widget code ported from FrontPorch `ContactSection.vue`. Placed after FAQ.
- **Config:** `composer require ryangjchandler/laravel-cloudflare-turnstile laravel/slack-notification-channel`; port `config/services.php` (`turnstile`, `slack`), the Turnstile script tag in `app.blade.php`, the Turnstile props in `HandleInertiaRequests`, `calendar_url` in `config/site.php`, and the env keys `CALENDAR_URL`, `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY`, `SLACK_BOT_USER_OAUTH_TOKEN`, `SLACK_BOT_USER_DEFAULT_CHANNEL` in `.env.example` (test keys: Cloudflare's always-pass `TURNSTILE_SITE_KEY=1x00000000000000000000AA`, `TURNSTILE_SECRET_KEY=1x0000000000000000000000000000000AA`).

### Approved copy

**A.1 Start a project section**

| Where | Template | New |
|---|---|---|
| "What happens next", step 2 | **I reply within one business day** — With questions, or a time for a briefing call. | **You get a link to book the briefing call** — By email, right after you send the form. |
| Success panel text (label `RECEIVED` and title "Got it. Thanks." stay) | I'll read it and reply within one business day, with questions or a time for a briefing call. | Check your email for a link to book the briefing call. |
| Website field placeholder | yourcompany.com | https://yourcompany.com |
| Form fields | Hidden honeypot field `website_url` | Removed. The Turnstile widget sits above the submit row. |

**A.2 Form messages**

| Case | Message |
|---|---|
| Security check missing or failed | Please complete the security check. |
| Already sent in the last hour | You already sent a project request in the last hour. Check your email for the booking link. |
| Name, email, type, problem, timeline | The template texts: "Please add your name.", "Please add a valid email.", "Please pick at least one. "Not sure yet" is fine.", "A few sentences are enough.", "Please choose a timeline." |
| Website | Laravel's default `url` message |

**A.3 Booking link email (`LeadSchedulingEmail`)**

- **Subject:** Book your briefing call
- **Body** (Laravel Markdown mail, FrontPorch view adapted):

```
# Thanks, {name}

I got the details of your project. The next step is a short briefing call, where we go through the requirements together.

Pick a time that works for you:

[Book the briefing call]   ← button to CALENDAR_URL

If the button does not work, open this link: {CALENDAR_URL}

If none of the times work for you, just reply to this email.

Rogerio Pereira
Senior full-stack engineer · rogeriopereira.dev
```

**A.4 Slack message format**

```
New project request
Name: {name}
Email: {email}
Website: {website | "(not provided)"}
Needs: {labels, comma-separated}
Timeline: {label}
Problem:
{problem}
```

Labels: `website` → Website, `system` → System, `ai` → AI integration, `automation` → Automation, `consulting` → Consulting, `not-sure` → Not sure yet. Timelines: `lt-1m` → Less than a month, `1-3m` → 1–3 months, `3-6m` → 3–6 months, `flexible` → Flexible.

---

## How to test

- Port and adapt FrontPorch's tests: validation, Turnstile fake, Slack, scheduling email retries and warnings, Browser happy path.
- Add: a Slack failure is logged; a failed validation does not count for the rate limit; a second successful send within an hour is blocked.
- Confirm nothing is written to the database.

---

## Acceptance criteria

- [ ] A valid submission posts to Slack and emails the visitor the Calendly link, then shows the success panel.
- [ ] Nothing is written to the database; failures end up in the log.
- [ ] Turnstile is required (fails closed). One successful submission per IP per hour; validation errors never lock a visitor out.
- [ ] Copy = template + the approved copy above.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Packages, `config/services.php`, Turnstile script tag, Turnstile props, `calendar_url`, env keys. | `build: add Turnstile and Slack notifications` |
| 2 | Port `ContactRequest` with the template fields and rules above. | `feat(lead): validate project requests` |
| 3 | Port `ContactLeadSubmitted`, `SlackNotification`, `SendLeadSlackNotification` (message format A.4; add `try/catch` → `Log::error` with the lead), `SendLeadSchedulingEmail` and `LeadSchedulingEmail` (as they are, with the copy of A.3), `EventServiceProvider` registering only these two listeners. | `feat(lead): notify Slack and email the booking link` |
| 4 | Port `ContactController@store` and `POST /contact`: rate-limit check, dispatch the event, `RateLimiter::hit`, back with the flash that shows the success panel. | `feat(lead): handle project requests` |
| 5 | `StartSection.vue` as described above, placed after FAQ. | `feat(home): add the start a project form` |
| 6 | Port and adapt FrontPorch's tests and add the three tests above. | `test(lead): cover project requests` |
