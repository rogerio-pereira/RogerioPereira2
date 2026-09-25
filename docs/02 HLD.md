# Rogerio Pereira Website — High-Level Design (HLD)

**Version:** 1.0 · **Source:** planning-new-website.md v2.1 (§2, §3, §5.6, §6, §7, §8, §13)

**Base model:** FrontPorch (`https://github.com/rogerio-pereira/FrontPorch` at commit `805d19c`, read-only). Nothing goes beyond what FrontPorch has, except the pieces listed in the plan's "new pieces" table ([ADR_001](ADRs/ADR_001_complete_refactor_fresh_starter_kit_frontporch_base.md)).

---

## 1. Stack

Laravel 13 Vue starter kit (Inertia + Vue 3 + TypeScript + Tailwind 4 + reka-ui/shadcn-vue + Fortify + Wayfinder), PHP 8.5, Octane (Swoole) and the rest of FrontPorch's Sail setup, PostgreSQL, S3-compatible storage (MinIO locally), Pest (Feature + Browser). Hosting: Laravel Cloud.

Quality tools are exactly FrontPorch's: Pest (coverage ≥ 90%), Pest type coverage ≥ 90%, Pint, ESLint. No Larastan, no Prettier or vue-tsc gates.

## 2. Rendering and SEO

- **Inertia + Vue for public pages and `/core`, client-side rendering, no SSR.** Vue renders the pages from Inertia props that come from the database. ([ADR_002](ADRs/ADR_002_client_side_inertia_server_side_seo_meta.md))
- **SEO meta tags are printed by the server** in `resources/views/app.blade.php` from a `seo` array passed by each controller (`->withViewData('seo', [...])`), built from the database data. Crawlers (LinkedIn, X, Facebook) get the right tags without JavaScript. Vue only sets `<Head :title>` for client-side navigation.
- One server-side block prints the same set of tags on every page: title, description, canonical (`url()->current()`), `og:type=website`, `og:title`, `og:description`, `og:url`, `og:image`, `twitter:card`, `twitter:site`, `twitter:image`, `theme-color`. An article's `og:image` is its cover; other pages use `/og-image.jpg`.
- **No JSON-LD anywhere.**
- Plus FrontPorch's `sitemap.xml`, `robots.txt` and `llms.txt`.

Per-page values:

| Page | `<title>` | Description | `og:image` |
|---|---|---|---|
| Home | `Rogerio Pereira · Web systems that hold up in production` | template `index.html` meta | `/og-image.jpg` |
| `/cases` | `Case notes · Rogerio Pereira` | template `cases/index.html` meta | `/og-image.jpg` |
| Case | `{title} · Case notes · Rogerio Pereira` | `problem_short` | `/og-image.jpg` |
| `/blog` | `Blog · Rogerio Pereira` | template `blog/index.html` meta | `/og-image.jpg` |
| Article | `{title} · Rogerio Pereira` | `excerpt` | the article cover URL |
| `/privacy`, `/terms` | `Privacy Policy · Rogerio Pereira`, `Terms · Rogerio Pereira` | one plain sentence each | `/og-image.jpg` |

Defaults (site name, home title and description, default image, `@rpereira_dev`) live in FrontPorch's `config/site.php`. Titles are passed complete; the Inertia `title` callback returns them unchanged.

## 3. CSS

Hybrid ([ADR_003](ADRs/ADR_003_hybrid_css_tailwind_tokens_template_classes.md)): design tokens in Tailwind 4 `@theme`; the template's visual rules ported from `site.css` into one `resources/css/site.css` (`@layer components`, same class names); section layout with Tailwind utilities. Details: [04 - Design System](04%20-%20Design%20System.md).

## 4. Routes

### 4.1 Public routes (`routes/web.php`)

| Method + URL | Controller | Inertia page | Template source |
|---|---|---|---|
| `GET /` | `HomeController` (invokable) | `home/Home` | `landing-page/index.html` |
| `POST /contact` | `ContactController@store` (FrontPorch) | — (redirect back) | form in `index.html` `#start` |
| `GET /cases` | `CasesController` (invokable, like FrontPorch `PortfolioController`) | `cases/Cases` | `cases/index.html` |
| `GET /cases/{caseStudy:slug}` | `CaseStudyController` (invokable, like FrontPorch `PortfolioStudyCaseController`) | `case-study/CaseStudy` | `cases/case-slug/index.html` |
| `GET /blog` | `BlogController` (invokable, FrontPorch) | `blog/Blog` | `blog/index.html` |
| `GET /blog/{article:slug}` | `BlogArticleController@show` (FrontPorch) | `blog-article/BlogArticle` | `blog/title-slug/index.html` |
| `GET /privacy` | `PrivacyController` (FrontPorch) | `privacy/Privacy` | FrontPorch page, new text |
| `GET /terms` | `TermsController` (FrontPorch) | `terms/Terms` | FrontPorch page, new text |
| `GET /sitemap.xml` | `SitemapController` (FrontPorch) | — (XML) | — |
| static | `public/robots.txt`, `public/llms.txt` (FrontPorch files, new content) | — | — |

Public controllers are thin, like FrontPorch's: query, build the `seo` array, render.

### 4.2 Admin and auth routes (FrontPorch)

| URL | What |
|---|---|
| Fortify | `/login`, `/forgot-password`, `/reset-password/{token}`, `/two-factor-challenge`, `/user/confirm-password`. Registration disabled. After login → `/dashboard`. |
| `/dashboard` | Starter kit Dashboard page (kept, as in FrontPorch) |
| `/core/users` | `Core\UserController` resource |
| `/core/faqs` | `Core\FaqController` resource |
| `/core/case-studies` | `Core\CaseStudyController` resource |
| `/core/blog/articles` | `Core\BlogArticleController` resource |
| `POST /core/media` | `Core\MediaUploadController@store`: uploads one image for the Markdown field and returns `{ url }` |
| `/settings/*` | Starter kit settings (profile, security, appearance), admin layout |

Every admin resource: `show` returns 404 (FrontPorch). All `/core/*`, `/dashboard` and `/settings/*` routes use the `auth` middleware only. Admin routes bind models by UUID; public routes by slug. The admin panel is forced dark by FrontPorch's `HandleAppearance` middleware ([ADR_010](ADRs/ADR_010_admin_auth_seeded_users.md)).

### 4.3 Navigation

- Header (every public page): brand (`Rogerio Pereira` + `@rogeriopereira.dev`) → `/`; links Services → `/#services`, Cases → `/cases`, How it works → `/#process`, FAQ → `/#faq`, Blog → `/blog`; button "Start a project" → `/#start`. Plain `<a>` for `/#...` anchors; Inertia `<Link>` for `/cases` and `/blog`.
- Footer: handle, four social icons (template SVGs), `© {year} Rogerio Pereira`, plus small Privacy · Terms links.
- Sticky mobile CTA "Start a project" → `/#start` (template).

### 4.4 Home page sections

| # | Section (template id) | Component (`resources/js/pages/home/sections/`) | Data | Owner feature |
|---|---|---|---|---|
| 1 | Hero (`#top`) | `HeroSection.vue` | static | F07 |
| 2 | Proof strip | `ProofStrip.vue` | static | F07 |
| 3 | Problem (`#problem`) | `ProblemSection.vue` | static | F07 |
| 4 | Services (`#services`) | `ServicesSection.vue` | static (5 services, inline SVG icons) | F07 |
| 5 | Cases (`#cases`) | `CasesSection.vue` | **DB:** 3 newest cases; hidden if none | F08 |
| 6 | How it works (`#process`) | `ProcessSection.vue` | static | F07 |
| 7 | Fit check (`#fit`) | `FitSection.vue` | static | F07 |
| 8 | About (`#about`) | `AboutSection.vue` | static | F07 |
| 9 | FAQ (`#faq`) | `FaqSection.vue` | **DB:** all FAQs by `sort_order`; hidden if none | F06 |
| 10 | Start a project (`#start`) | `StartSection.vue` | form → `POST /contact` | F10 |
| 11 | Blog (`#blog`) | `BlogSection.vue` | **DB:** 3 newest articles; hidden if none | F09 |

Each section component renders its own leading `.divider`, so a hidden section does not leave a double divider.

## 5. Data model

All old migrations are gone. The starter kit migrations stay as they are, except the users table (UUID, as in FrontPorch). Every table uses a UUID primary key (`HasUuids`, FrontPorch). No `is_published`, no `published_at`: a row in the table is published, and the date shown is `created_at`. ([ADR_004](ADRs/ADR_004_content_model_markdown_uuids.md))

Database-backed content: cases, blog articles, FAQs, users. Everything else (services, pains, process, fit check, about, footer) is hardcoded in Vue.

### 5.1 `users` (FrontPorch)

FrontPorch's users migration: `id` UUID PK, `name`, `email` unique, `email_verified_at`, `password`, two-factor columns, `remember_token`, timestamps; `sessions.user_id` as `foreignUuid`. No SoftDeletes.

### 5.2 `faqs` (FrontPorch, without `service_id`)

| Column | Type | Notes |
|---|---|---|
| `id` | UUID PK | |
| `question` | string | required, max 255 |
| `answer` | text | required, plain text (escaped on render) |
| `sort_order` | integer | ascending on the home page |
| timestamps | | |
| `deleted_at` | nullable timestamp | SoftDeletes (FrontPorch) |

### 5.3 `case_studies` (model `CaseStudy`, new schema from the template)

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | UUID PK | | |
| `category` | string | yes | free text, pink `.cat` label |
| `title` | string, unique | yes | |
| `slug` | string, unique | auto | FrontPorch Observer: from the title on create and on every title change |
| `problem_short` | string | yes | card + meta description |
| `decision_short` | string | yes | card |
| `result_short` | string | yes | card |
| `problem` | text | yes | plain paragraphs (split on blank lines) |
| `constraints_alternatives` | text | yes | plain paragraphs |
| `decision` | text | yes | plain paragraphs |
| `result` | text | yes | plain paragraphs |
| `case_study` | text | yes | **Markdown** (images allowed) |
| `my_role` | string | no | side panel; hidden when empty |
| `stack` | JSON (array of strings) | no | side panel chips; hidden when empty |
| `metrics` | JSON (array of `{value, label}`) | no | up to 3 (the template grid holds 3); hidden when empty |
| `lesson` | text | no | lesson panel; hidden when empty |
| timestamps | | | `created_at` orders lists and previous/next |

No SoftDeletes. Casts: `stack`, `metrics` → `array`. Appended accessor `case_study_html` = `Str::markdown($this->case_study, [...safe options])`.

In the `/core` form, `stack` is one comma-separated input and `metrics` are three fixed value + label pairs; the Form Request turns them into arrays (empty items dropped) before saving.

### 5.4 `blog_articles` (FrontPorch, adapted)

| Column | Type | Required | Notes |
|---|---|---|---|
| `id` | UUID PK | | |
| `title` | string, unique | yes | |
| `slug` | string, unique | auto | FrontPorch Observer: from the title on create and on every title change |
| `excerpt` | string | yes | card + meta description (the template's name for FrontPorch's `description`) |
| `category` | string | yes | free text |
| `image` | string | yes | cover **URL** (FrontPorch) |
| `content` | text | yes | **Markdown** |
| `published_by` | string | auto | FrontPorch Observer on create (name of the logged-in user) |
| timestamps | | | `created_at` = publish date shown |

No SoftDeletes. Appended accessor `content_html` = `Str::markdown($this->content, [...safe options])`. Date shown as `M j, Y` inside `<time datetime="Y-m-d">`. Cover `alt` = article title.

### 5.5 Markdown

Long text is Markdown in a plain textarea, rendered with `Str::markdown()` (league/commonmark ships with Laravel) with `html_input => 'strip'` and `allow_unsafe_links => false`, called directly in the model accessor. An "Insert image" button uploads a file (`POST /core/media`) and inserts `![](url)` at the cursor; Rogerio writes the alt text inside the brackets. FrontPorch's TipTap editor is not ported.

### 5.6 Slugs, listings, deletion

- **Slugs follow the title** (FrontPorch Observer): generated from the title on create and regenerated whenever the title changes. A broken old link is accepted. Titles are unique (validated).
- `/cases` and `/blog` show 12 per page (`?page=N`), newest first. The home shows the 3 latest of each. An empty home section is hidden. An empty list page shows one line of empty-state copy.
- An article shows "More articles" = the 3 newest articles except the current one (hidden if none). A case shows previous (older) and next (newer) case (each hidden if none).
- Deleting a case or an article is a **real delete** and its images are deleted from storage. FAQs keep SoftDeletes (FrontPorch). Users are hard-deleted.

### 5.7 Factories and seeders (FrontPorch)

- A factory for every model (`User`, `Faq`, `CaseStudy`, `BlogArticle`). Images use `fake()->imageUrl()`, as in FrontPorch.
- `DatabaseSeeder` = FrontPorch's: **real data** always (`UserSeeder`, `FaqSeeder`); **fake data** only in `local` and `testing` (`UserLocalSeeder`, `CaseStudiesSeeder`, `BlogArticlesSeeder`, each creating records from factories).
- `UserSeeder`: FrontPorch's file as it is (Rogerio and Sarah, password hashes in code).
- `FaqSeeder`: the 8 FAQs from the template, in template order, `sort_order` 1–8, text verbatim.

## 6. Media

([ADR_005](ADRs/ADR_005_media_storage_compression_orphan_deletion.md))

- **Storage:** MinIO in Sail, Laravel Cloud bucket in production, through the `s3` disk (FrontPorch). The database stores the **public URL** of each image (FrontPorch `MediaUploader`).
- **Every uploaded image is compressed with FrontPorch's `ImageCompressor` as it is** (JPEG quality 82, no resize). `MediaUploader::store()` calls it. Validation: FrontPorch `ImageValidationRules`.
- **Orphan files are deleted immediately, no scheduling:** the old cover when it is replaced; images removed from the Markdown when a record is saved; all images of a record when it is deleted. Added to `MediaUploader` as `delete(url)` and `deleteRemovedImages(oldMarkdown, newMarkdown)`, which only touch URLs that belong to the storage disk. Uploads made in the editor and never saved are not handled (accepted).

## 7. Integrations

| Integration | Used for | Config | When not configured | Doc |
|---|---|---|---|---|
| **Cloudflare Turnstile** (FrontPorch) | Anti-spam on the form | `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY` | Fails closed | [TURNSTILE_SETUP.md](integration/TURNSTILE_SETUP.md) |
| **Slack** (FrontPorch `SlackNotification`) | "New project request" message | `SLACK_BOT_USER_OAUTH_TOKEN`, `SLACK_BOT_USER_DEFAULT_CHANNEL` | Skipped; on error, one attempt and `Log::error` | [SLACK_SETUP.md](integration/SLACK_SETUP.md) |
| **Mail + Calendly** (FrontPorch `LeadSchedulingEmail`) | Email with the booking link | `CALENDAR_URL`, `MAIL_*` | Skipped with `Log::warning`; 3 attempts, then `Log::error`. Local: Mailpit. Production: SES. | This document |
| **Google Analytics 4** (FrontPorch) | Traffic | `GOOGLE_ANALYTICS_ID` | Script not printed | [GOOGLE_ANALYTICS_SETUP.md](integration/GOOGLE_ANALYTICS_SETUP.md) |
| **Meta Pixel** (FrontPorch) | Ads measurement | `META_PIXEL_ID` | Script not printed | [META_PIXEL_SETUP.md](integration/META_PIXEL_SETUP.md) |
| **S3-compatible storage** (FrontPorch) | Covers and Markdown images | `FILESYSTEM_DISK=s3`, `AWS_*` | Required | This document |
| **Laravel Cloud** | Hosting, PostgreSQL, bucket | Cloud dashboard + env | — | Deployment section below |

GA4 and Meta Pixel load only when their IDs are set. No cookie banner ([ADR_008](ADRs/ADR_008_legal_pages_analytics_no_cookie_banner.md)).

### 7.1 Project request flow

([ADR_006](ADRs/ADR_006_project_request_flow.md))

**On submit:** (1) Slack message; (2) email to the visitor with the Calendly booking link. Nothing is stored in the database and no email goes to Rogerio. Implemented with FrontPorch's lead flow: `ContactController` dispatches `ContactLeadSubmitted`; listeners `SendLeadSlackNotification` and `SendLeadSchedulingEmail` are registered in `EventServiceProvider`. FrontPorch's `SendLeadEmail` (email to the owner) is not ported.

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

**Failure handling:** Slack = one attempt; a `try/catch` around the notification logs `Log::error` with the lead data (the only change to FrontPorch's listener). Calendly email = FrontPorch's listener as it is: 3 attempts, then `Log::error`; skipped with `Log::warning` when `CALENDAR_URL` is empty. Slack is skipped when its env values are empty.

**Anti-spam:** Cloudflare Turnstile (fail closed), shared props as in FrontPorch. The template's honeypot field is removed.

**Rate limit:** 1 successful submission per IP per hour. FrontPorch's `throttle` middleware counts every request, so with a 1-per-hour limit a visitor who fails validation would be locked out for an hour. The limit is therefore checked in `ContactController` with `RateLimiter` and only a successful send counts.

**Form fields** follow the template: name, email, website (optional), type (multi), problem, timeline. Website uses FrontPorch's rule `nullable|url|max:255` with Laravel's default validation message. Before validating, `ContactRequest::prepareForValidation()` adds `https://` when the value is not empty and does not start with `http://` or `https://`.

## 8. Environments

### 8.1 Local (Sail)

Sail environment = FrontPorch's `compose.yaml` and `docker/` (PHP 8.5, Octane/Swoole, pgsql, pgadmin, mailpit, minio, createbuckets) **without Redis**. Default bucket name `rogeriopereira`. Octane listens on `--port=80` inside the container so parallel worktrees can each map their own `APP_PORT`.

Everything runs in Sail; never install PHP, Composer or packages on the host. Environment variables: see `.env.example`.

**Deviations found while building F01 (Foundation reset):**

- The scaffolding used the `laravelsail/php84-composer:latest` image, because a `laravelsail/php85-composer` image does not exist. The app itself runs on PHP 8.5 in Sail.
- Postgres uses a named volume `sail-pgsql` for its data directory, instead of a bind mount.
- CI (GitHub Actions) runs on PHP 8.5.
- The `Browser` testsuite was removed from `phpunit.xml` until `tests/Browser` exists; F03 or the first feature that adds a Browser test re-adds it.

### 8.2 Production (Laravel Cloud)

Hosting on Laravel Cloud: PostgreSQL, object storage bucket, mail via env. No worker and no scheduler. PHP 8.5 is supported (FrontPorch already runs there). Production mail is SES (as in FrontPorch); `MAIL_FROM_ADDRESS` must be a mailbox Rogerio reads, because visitors may reply to the Calendly email. ([ADR_009](ADRs/ADR_009_hosting_laravel_cloud.md))

**No queues, jobs, workers, scheduler or Redis** ([ADR_007](ADRs/ADR_007_no_queues_workers_scheduler_redis.md)): `QUEUE_CONNECTION=sync`, everything runs in the request. `CACHE_STORE=database`, `SESSION_DRIVER=database` (FrontPorch).

## 9. Deployment

Launch checklist for Laravel Cloud. It is also the description of the launch PR (`new-website` → `main`). Items marked **(Rogerio)** need his accounts.

**Before merging `new-website` → `main`**
- [ ] All FDRs in `Done/`, gates green, CI green on the launch PR.
- [ ] Rogerio approved the final Privacy and Terms texts.

**Laravel Cloud setup (Rogerio)**
- [ ] App connected to `rogerio-pereira/RogerioPereira2`, deploying from `main` (same setup as FrontPorch).
- [ ] Laravel Postgres database attached.
- [ ] Object storage bucket attached with public read; `FILESYSTEM_DISK=s3` and the injected `AWS_*` values in place.
- [ ] Environment (production values): `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://rogeriopereira.dev`, `MAIL_MAILER=ses` with SES credentials and region, `MAIL_FROM_ADDRESS` (a mailbox Rogerio reads), `MAIL_FROM_NAME`, `CALENDAR_URL`, `TURNSTILE_SITE_KEY` / `TURNSTILE_SECRET_KEY` (site for `rogeriopereira.dev`), `SLACK_BOT_USER_OAUTH_TOKEN`, `SLACK_BOT_USER_DEFAULT_CHANNEL`, `GOOGLE_ANALYTICS_ID`, `META_PIXEL_ID`, `QUEUE_CONNECTION=sync`, `CACHE_STORE=database`, `SESSION_DRIVER=database`.
- [ ] Deploy runs `php artisan migrate --force`. First deploy only: `php artisan db:seed --force` (production runs only the real-data seeders; `UserSeeder` is not idempotent, run it once).
- [ ] No queue worker and no scheduler.
- [ ] Custom domain `rogeriopereira.dev` and DNS moved from the old host.

**After deploy**
- [ ] Open `/`, `/cases`, `/blog`, a case, an article, `/privacy`, `/terms`, `/sitemap.xml`, `/login`.
- [ ] Send a real project request: the Slack message and the booking email arrive; a second send within an hour is blocked.
- [ ] Share an article link on LinkedIn: the preview shows its title, excerpt and cover.
