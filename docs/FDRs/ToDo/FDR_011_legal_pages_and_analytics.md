# FDR-011: Legal pages and analytics

**Feature:** 11
**Branch:** `feat/f11-legal-analytics` · **Wave:** 4 · **Depends on:** [F10 Project request form](../../05%20-%20Feature%20List.md#f10-project-request-form)

**References:**
- Feature List: [F11 Legal pages and analytics](../../05%20-%20Feature%20List.md#f11-legal-pages-and-analytics)
- ADRs: [ADR-008](../../ADRs/ADR_008_legal_pages_analytics_no_cookie_banner.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [GOOGLE_ANALYTICS_SETUP.md](../../integration/GOOGLE_ANALYTICS_SETUP.md), [META_PIXEL_SETUP.md](../../integration/META_PIXEL_SETUP.md), [03 - Branding Manual](../../03%20-%20Branding%20Manual.md) (voice rules)
- FrontPorch (read-only): analytics snippets in `app.blade.php` and their tests, `PrivacyController`, `TermsController`, `pages/privacy/*`, `pages/terms/*`, and their tests
- Template: none (uses `PageHead` and `.prose` from F03)

**Owns:** `PrivacyController`, `TermsController`, `pages/privacy/*`, `pages/terms/*`, analytics part of `app.blade.php`, analytics keys in `config/site.php`, footer legal links in `SiteFooter.vue`.

---

## How it works

- GA4 and Meta Pixel snippets and keys are ported from FrontPorch. They load only when `GOOGLE_ANALYTICS_ID` / `META_PIXEL_ID` are set. No cookie banner.
- `/privacy` and `/terms` follow FrontPorch's page structure (`PageHead` + `.prose`, `seo`) with new text. SEO: title `Privacy Policy · Rogerio Pereira` and `Terms · Rogerio Pereira`, one plain sentence of description each, `og:image` `/og-image.jpg`.
- The footer shows small "Privacy" · "Terms" links (mono, muted, small, like `footer .copy`).
- The agent writes the final text from the approved outline below and the site's real behavior, following the voice rules of the Branding Manual. Both texts are listed in the PR for Rogerio's review. Not legal advice.

### Approved outlines (outline approved; final text reviewed by Rogerio in the PR)

**Privacy Policy** — Who runs the site (Rogerio Pereira, Central Florida, USA) · What the project form collects (name, email, website, project types, problem description, timeline) · Why (to reply and to send the booking link) · Where it goes (a private Slack workspace and the email provider; the site does not store requests in its database; server logs may keep them only when a delivery fails) · Services involved (Cloudflare Turnstile, Slack, the email provider, Calendly when the visitor books, Laravel Cloud hosting, Google Analytics and Meta Pixel when enabled) · Cookies (session and security cookies, Turnstile, analytics cookies; no consent banner is shown) · How long data is kept · The visitor's choices and how to reach Rogerio (through the project form) · Changes to the policy · Last updated date.

**Terms** — Using the site means accepting the terms · The site is informational; sending a project request does not create a client relationship; paid work is covered by a separate written agreement · No guarantee of results · Site content belongs to Rogerio Pereira · External links are not his responsibility · Limitation of liability · Governing law: Central Florida, USA · Changes to the terms · Contact through the project form · Last updated date.

---

## How to test

- Port FrontPorch's analytics and legal page tests, adapted: no script without an ID; both scripts load when IDs are set; `/privacy` and `/terms` render with their `seo` tags.
- Add the routes to `tests/Browser/WebRoutesTest.php`; check the footer links.

---

## Acceptance criteria

- [ ] `/privacy` and `/terms` render in the site style and describe what the site does; both texts are listed in the PR for Rogerio's review.
- [ ] No analytics script without an ID; both load when IDs are set. No cookie banner.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port FrontPorch's GA4 and Meta Pixel snippets and keys, and their tests. | `feat(analytics): load GA4 and Meta Pixel when configured` |
| 2 | Port FrontPorch's Privacy page structure (`PageHead` + `.prose`, `seo`) with the new text. | `feat(legal): add privacy policy page` |
| 3 | Same for Terms. | `feat(legal): add terms page` |
| 4 | Footer links "Privacy" · "Terms". | `feat(ui): link legal pages in the footer` |
| 5 | Tests (FrontPorch's analytics and legal page tests, adapted). | `test(legal): cover legal pages and analytics` |
