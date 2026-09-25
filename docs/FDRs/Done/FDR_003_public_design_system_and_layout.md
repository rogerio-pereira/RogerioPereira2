# FDR-003: Public design system and layout

**Feature:** 03
**Branch:** `feat/f03-design-system` · **Wave:** 1 · **Depends on:** [F02 Project docs and agent setup](../../05%20-%20Feature%20List.md#f02-project-docs-and-agent-setup)

**References:**
- Feature List: [F03 Public design system and layout](../../05%20-%20Feature%20List.md#f03-public-design-system-and-layout)
- ADRs: [ADR-002](../../ADRs/ADR_002_client_side_inertia_server_side_seo_meta.md), [ADR-003](../../ADRs/ADR_003_hybrid_css_tailwind_tokens_template_classes.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [03 - Branding Manual](../../03%20-%20Branding%20Manual.md), [04 - Design System](../../04%20-%20Design%20System.md), [02 HLD](../../02%20HLD.md) (SEO)
- FrontPorch (read-only): `resources/views/app.blade.php`, `config/site.php`, `resources/views/errors/*`, `resources/js/layouts/app/SitePagination.vue`, `resources/css/app.css` (theme variables)
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): `assets/css/site.css`, `assets/js/site.js`, header and footer markup of `index.html`, fonts and images in `assets/`

**Owns:** `resources/css/app.css`, `resources/css/site.css`, `public/fonts/`, `public/images/`, `public/og-image.jpg`, `public/favicon.svg|ico`, `public/apple-touch-icon.png`, `resources/views/app.blade.php`, `resources/views/errors/`, `config/site.php`, `resources/js/layouts/SiteLayout.vue`, `resources/js/components/site/{SiteHeader,SiteFooter,MobileCta,PageHead,SitePagination}.vue`, `resources/js/directives/reveal.ts`, font loading in `vite.config.ts`.

---

## How it works

- Fonts (Space Grotesk, Sora, Droid Sans Mono) are self-hosted from `public/fonts/` with `@font-face` and `font-display: swap`; the starter kit's font loading is removed.
- `resources/css/app.css` holds `@import "tailwindcss"`, the `@font-face` rules, the `@theme` tokens (colors, `--font-head`, `--font-body`, `--font-mono`), the admin theme variables (`:root` and `.dark`) and `@import "./site.css"`.
- `resources/css/site.css` holds every visual rule of the template's `site.css` in `@layer components`, with the same class names and values, plus the additions listed in the Design System. Layout rules are left to the Vue components (later features).
- `SiteLayout.vue` renders a skip link, `SiteHeader`, `<main id="main">`, `SiteFooter` and `MobileCta`. Markup and SVG icons come verbatim from the template; nav links follow the HLD (Services, Cases, How it works, FAQ, Blog, "Start a project"). The `v-reveal` directive, the mobile menu and the sticky CTA behavior come from `site.js`. Public pages resolve to `SiteLayout` in `resources/js/app.ts`.
- `app.blade.php` and `config/site.php` are ported from FrontPorch. A server-side SEO block prints the tag set of ADR-002 from a `$seo` array merged with the defaults. The Inertia `title` callback returns the title unchanged.
- `PageHead.vue` renders crumbs, label, h1 and lead. `SitePagination.vue` is ported to the template `.pager` markup. Both are used by F08, F09 and F11.
- FrontPorch's error pages (404, 500, 503) are ported with the new look.
- The `Browser` testsuite is re-added to `phpunit.xml` when `tests/Browser` is created (it was removed in F01 until then).

---

## How to test

- Feature test with a test-only route that renders an Inertia page with `seo` data and asserts the tags in the server HTML (no JavaScript).
- Feature tests for the 404, 500 and 503 pages.
- Browser test of the layout on a test-only page: header links, mobile menu, skip link.
- Manual: no external font request in the browser network panel.

---

## Acceptance criteria

- [x] Fonts are self-hosted; no external font request.
- [x] Tokens available as Tailwind utilities and CSS variables; `site.css` holds the template's visual rules with the same class names and values.
- [x] The server HTML of a public page contains the SEO tags with the right values, without JavaScript.
- [x] Error pages use the brand; the admin uses the brand values.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Copy fonts (+ licenses), portrait (jpg/webp) and `og-image.jpg` (Branding Manual, Assets). | `feat(ui): add brand fonts and images` |
| 2 | Favicon files (RP monogram); remove the starter kit icons. | `feat(ui): add RP monogram favicon` |
| 3 | `app.css`: `@font-face`, `@theme` tokens, admin theme variables, `@import "./site.css"`; remove the starter kit font loading. | `feat(ui): add design tokens and brand theme` |
| 4 | `site.css`: port the template's visual rules and the Design System additions. | `feat(ui): port the template styles` |
| 5 | `SiteLayout.vue` (skip link, `SiteHeader`, `<main id="main">`, `SiteFooter`, `MobileCta`), `v-reveal` directive, mobile menu and sticky CTA behavior from `site.js`; public pages resolve to `SiteLayout` in `app.ts`. Markup and SVG icons verbatim from the template. | `feat(ui): add the public site layout` |
| 6 | Port FrontPorch `config/site.php` and `app.blade.php`; add the SEO block fed by `$seo` merged with the defaults; Inertia `title` callback returns the title unchanged. | `feat(seo): render meta tags on the server` |
| 7 | `PageHead.vue` (crumbs, label, h1, lead) and port `SitePagination.vue` to the template `.pager` markup. | `feat(ui): add page head and pagination components` |
| 8 | Port FrontPorch error pages (404, 500, 503) with the new look. | `feat(ui): add branded error pages` |
| 9 | Tests: Feature test with a test-only route asserting the tags in the HTML; error pages; Browser test of the layout on a test-only page. | `test(ui): cover layout, SEO tags and error pages` |

---

## Implementation notes

- `--muted` and `--radius` are the shadcn admin values everywhere and the template values (`#9AA1A8`, `2px`) only inside the `.site` wrapper of `SiteLayout`. The template's body and element rules (`body`, `img`, `a`, `h1`–`h3`, `section`, `footer`, `p`) are scoped to `.site` so the admin is not affected.
- Small layout-free "atoms" keep their `display:inline-flex` in `site.css` (`.btn`, `.log`, `.status`, `.more`, `.pager a`, footer social links, `.cover-ph`, FAQ `summary`); arrangements of sections and cards are left to the components.
- Class names for the Design System additions without a name: `.form-err`, `.list-empty`, `footer .legal a`. The Turnstile widget needs no CSS.
- Droid Sans Mono ships without its Apache 2.0 license file (the sources only have the two OFL files).
- The test-only page `resources/js/pages/testing/Layout.vue` is used by the Feature and Browser tests.
