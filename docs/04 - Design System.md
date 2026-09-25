# Rogerio Pereira Website — Design System (web)

**Version:** 1.0 · **Source:** planning-new-website.md v2.1 (§5)

**The exact values live in `landing-page/assets/css/site.css`** (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/assets/css/site.css`); that file is the visual spec. Port values, do not redesign. Brand rules: [03 - Branding Manual](03%20-%20Branding%20Manual.md).

---

## 1. Color tokens

| Token (`@theme`) | Value | Use |
|---|---|---|
| `--color-primary` | `#00BEBE` | Signature teal: neon edge, labels, primary button, links, focus ring |
| `--color-support` | `#EC4899` | Pink, small doses only: category labels (`.cat`), "×" marks in the fit check, a faint corner light |
| `--color-steel` | `#151719` | Page background (brushed steel) |
| `--color-steel-2` | `#1B1E21` | Raised surfaces |
| `--color-text` | `#EFE9E2` | Headings, strong text |
| `--color-text-soft` | `#DCD5CC` | Body text |
| `--color-muted` | `#9AA1A8` | Labels, meta, handle |
| `--color-glass` | `rgba(18,20,23,.55)` | Glass panel fill |
| `--color-glass-solid` | `rgba(18,20,23,.82)` | Denser panels |
| `--color-line` | `rgba(255,255,255,.13)` | Panel borders |
| `--color-line-soft` | `rgba(255,255,255,.07)` | Dividers |

Also keep the helper variables used by the CSS: `--primary-rgb: 0,190,190`, `--support-rgb: 236,72,153`, `--neon` (`0 0 22px rgba(primary,.85), 0 0 44px rgba(primary,.45)`), `--shadow`, `--wrap: 1180px`, `--gutter: clamp(16px,4vw,40px)`, `--radius: 2px`.

## 2. Typography

| Role | Font | Details |
|---|---|---|
| Headings (h1–h3), buttons, brand name | Space Grotesk 700 | line-height 1.08, letter-spacing −0.02em, `text-wrap: balance` |
| Body | Sora 300 | 17px, line-height 1.65; `.prose` 18.5px / 1.8 |
| Labels (`.log`, nav links, meta, `.cat`) | Droid Sans Mono 400 | 11–13px, uppercase, letter-spacing .08–.16em |

Self-hosted with `@font-face` and `font-display: swap`. No Google Fonts, no Bunny fonts (remove the starter kit's font loading).

## 3. Backgrounds and textures

- **Body:** brushed steel (repeating vertical lines over a dark gradient) plus the edge light: teal haze from the left at 20% and a pink glow bottom-right at 12% (`body::before` / `body::after` in `site.css`).
- **`.blueprint`** section variant: engineering grid (200px + 40px lines in teal at 5.5% / 2.5%). Used on hero, services, process, start, page heads.
- **`.pegboard`** section variant: perforated steel. Used on About.
- **`.divider`:** 1px gradient line between sections.

## 4. Components (class names kept from `site.css`)

| Class | What it is |
|---|---|
| `.log` (`b` teal, `i` pink) | Section label bar in mono |
| `.panel`, `.panel.edge` | Glass panel; `.edge` adds the 5px teal neon bar on the left |
| `.btn`, `.btn-primary`, `.btn-ghost`, `.arrow` | Buttons (52px min height), glow on hover, arrow nudge |
| `.nav`, `.brand`, `.menu-btn` | Sticky blurred header, mobile menu below 920px |
| `.hero`, `.portrait`, `.strip` | Hero, portrait card, proof strip |
| `.pains`, `.answer` | Problem grid |
| `.services`, `.svc` | Service cards (row of 2, then row of 3; icons are inline SVGs from the template) |
| `.cases`, `.case`, `.nda-note` | Case cards |
| `.steps`, `.step`, `.terms`, `.deliver`, `.checklist` | How it works |
| `.fit` (`.yes`, `.no`) | Fit check |
| `.about`, `.stack` | About + tech chips |
| `.faq details/summary/.a` | FAQ accordion (native `<details>`) |
| `.start`, `.next`, `.form`, `.field`, `.chips`, `.success`, `.err` | Start a project form |
| `.posts`, `.post-card`, `.cover`, `.cover-ph` | Blog cards |
| `.cat`, `.card-link`, `.more`, `.section-more`, `.sec-cta`, `.cta-band` | Shared card and CTA pieces |
| `.page-head`, `.crumbs`, `.list-top`, `.pager` | List and detail page heads, pagination |
| `.case-page`, `.case-block`, `.metrics`, `.metric`, `.lesson`, `.case-side`, `.side`, `.side-cta`, `.case-nav` | Case detail |
| `.post-meta`, `.post-cover`, `.article-wrap`, `.prose`, `.author-box` | Article detail |
| `footer`, `.social`, `.mcta` | Footer and the sticky mobile CTA |

**Additions required by the new behavior (keep them in the same style):**

- `.prose img` — Markdown renders images as `<p><img></p>`, which the template does not style. Add: full width, `height:auto`, `border:1px solid var(--line)`, same margins as `.prose figure`.
- Error state for the whole form (rate limit or Turnstile failure): reuse `.field .err` styling in pink, shown above the submit button.
- Empty state line on `/cases` and `/blog`: mono, muted, like `.list-top`.
- Footer legal links (Privacy · Terms): mono, muted, small, like `footer .copy`.
- Turnstile widget: dark theme, placed above the submit row.

## 5. Motion and accessibility

- `.reveal` fades up on scroll (IntersectionObserver, `rootMargin 0 0 -8% 0`, `threshold .08`); everything shows immediately with `prefers-reduced-motion: reduce`. Implement once as a small Vue directive (`v-reveal`); no animation library.
- Sticky mobile CTA (`.mcta`, visible below 760px): on the home page it shows after the hero and hides while the form is on screen; on other pages it shows after 480px of scroll.
- Skip link to `#main`, visible focus ring (`2px solid primary`, offset 3px), `aria-expanded` on the menu button, `aria-current="page"` in crumbs and pager, labels on every form field, `role="status"` on the success panel.
- Smooth scrolling for anchors; `scroll-margin-top: 68px` on sections (sticky nav height).

## 6. CSS architecture

Decision: [ADR_003](ADRs/ADR_003_hybrid_css_tailwind_tokens_template_classes.md). Two files, both created by F03, so no other feature edits CSS files:

1. `resources/css/app.css`: `@import "tailwindcss"`, `@font-face` rules, `@theme` with the tokens of sections 1–2 (colors, `--font-head`, `--font-body`, `--font-mono`), the admin theme variables (section 7), and `@import "./site.css"`.
2. `resources/css/site.css`: every **visual** rule of the template's `site.css` (typography, colors, borders, backgrounds, pseudo-elements, states, motion), in `@layer components`, with the same class names and values, plus the additions of section 4. **Layout** rules (grid, flex, gap, columns and their breakpoints) are left out of this file: the feature that builds each section writes them as Tailwind utilities in its Vue component, with the same values and breakpoints as the template (use `max-[920px]:`-style variants for the template's max-width breakpoints).

Port values as they are; do not redesign. Agents copy the template markup and class names into the Vue components, so the look matches by construction.

## 7. Admin theme (`/core`)

Same approach as FrontPorch (its `resources/css/app.css` and `HandleAppearance` middleware):

- Keep the starter kit's layout and shadcn-vue/reka components, including the Dashboard and Appearance pages.
- Put the brand values in the starter kit theme variables, in `:root` and `.dark`, the way FrontPorch put its own brand values there: `--primary` teal `#00BEBE` with foreground `#081414`; in `.dark`: `--background` steel `#151719`, `--card`/`--popover`/`--sidebar-background` steel-2 `#1B1E21`, `--foreground` text `#EFE9E2`, `--muted-foreground` muted `#9AA1A8`, `--border`/`--input` line, `--ring` teal. Keep the starter kit's destructive red. Body font Sora; headings Space Grotesk.
- The admin panel (`/dashboard`, `/core/*`, `/settings/*`) is forced dark by FrontPorch's `HandleAppearance` middleware (`$forceDark`).
- No glass panels, neon edges or textures in the admin.
