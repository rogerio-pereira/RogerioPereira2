# FDR-007: Home page (static sections)

**Feature:** 07
**Branch:** `feat/f07-home` · **Wave:** 2 · **Depends on:** [F03 Public design system and layout](../../05%20-%20Feature%20List.md#f03-public-design-system-and-layout)

**References:**
- Feature List: [F07 Home page (static sections)](../../05%20-%20Feature%20List.md#f07-home-page-static-sections)
- ADRs: [ADR-002](../../ADRs/ADR_002_client_side_inertia_server_side_seo_meta.md), [ADR-003](../../ADRs/ADR_003_hybrid_css_tailwind_tokens_template_classes.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [02 HLD](../../02%20HLD.md) (home sections, SEO), [04 - Design System](../../04%20-%20Design%20System.md)
- FrontPorch (read-only): `HomeController` and `Home.vue` (structure only)
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): `index.html` (copy and SVG icons verbatim)

**Owns:** `HomeController` (creates), route `/`, `pages/home/Home.vue`, `pages/home/sections/{HeroSection,ProofStrip,ProblemSection,ServicesSection,ProcessSection,FitSection,AboutSection}.vue`.

---

## How it works

- Invokable `HomeController` renders `home/Home` with the home `seo` (title `Rogerio Pereira · Web systems that hold up in production`, description from the template `index.html` meta, `og:image` `/og-image.jpg`). Route `GET /` is named `home`.
- `Home.vue` composes the sections in this order; other features add theirs later (cases: F08, FAQ: F06, start form: F10, blog: F09):

| # | Section (template id) | Component | Data |
|---|---|---|---|
| 1 | Hero (`#top`) | `HeroSection.vue` | static |
| 2 | Proof strip | `ProofStrip.vue` | static |
| 3 | Problem (`#problem`) | `ProblemSection.vue` | static |
| 4 | Services (`#services`) | `ServicesSection.vue` | static (5 services, inline SVG icons) |
| 5 | Cases (`#cases`) | `CasesSection.vue` (F08) | DB, hidden if none |
| 6 | How it works (`#process`) | `ProcessSection.vue` | static |
| 7 | Fit check (`#fit`) | `FitSection.vue` | static |
| 8 | About (`#about`) | `AboutSection.vue` | static |
| 9 | FAQ (`#faq`) | `FaqSection.vue` (F06) | DB, hidden if none |
| 10 | Start a project (`#start`) | `StartSection.vue` (F10) | form |
| 11 | Blog (`#blog`) | `BlogSection.vue` (F09) | DB, hidden if none |

- Each section component renders its own leading `.divider`.
- Copy, markup, classes and icons come verbatim from the template.

---

## How to test

- Feature: `/` renders; SEO tags are in the server HTML.
- Browser: section ids present, mobile menu, mobile CTA.
- Manual: compare with the template on desktop and mobile.

---

## Acceptance criteria

- [ ] `/` shows the static sections with the template copy, markup, classes and icons, desktop and mobile.
- [ ] Section ids `top`, `problem`, `services`, `process`, `fit`, `about` exist.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Invokable `HomeController` rendering `home/Home` with the home `seo`; route `GET /` named `home`. | `feat(home): add home route and controller` |
| 2 | `Home.vue` composing the sections in the order above (other features add theirs later). | `feat(home): add home page skeleton` |
| 3 | Hero (portrait `<picture>`, CTAs to `#start` and `#process`, micro line) and proof strip. | `feat(home): add hero and proof strip` |
| 4 | Problem section. | `feat(home): add problem section` |
| 5 | Services section (5 cards, inline SVG icons, section CTA). | `feat(home): add services section` |
| 6 | How it works (steps, terms, "What you get"). | `feat(home): add how it works section` |
| 7 | Fit check and About. | `feat(home): add fit check and about sections` |
| 8 | Tests: Feature (renders, SEO tags); Browser (section ids present, mobile menu, mobile CTA). | `test(home): cover the home page` |
