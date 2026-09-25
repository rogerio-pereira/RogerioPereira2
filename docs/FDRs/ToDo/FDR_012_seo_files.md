# FDR-012: SEO files

**Feature:** 12
**Branch:** `feat/f12-seo-files` · **Wave:** 4 · **Depends on:** [F08 Cases](../../05%20-%20Feature%20List.md#f08-cases), [F09 Blog](../../05%20-%20Feature%20List.md#f09-blog)

**References:**
- Feature List: [F12 SEO files](../../05%20-%20Feature%20List.md#f12-seo-files)
- ADRs: [ADR-002](../../ADRs/ADR_002_client_side_inertia_server_side_seo_meta.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- FrontPorch (read-only): `SitemapController`, `public/robots.txt`, `public/llms.txt`, and its sitemap and robots tests
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): `index.html` copy (source of the `llms.txt` content)

**Owns:** `SitemapController`, `public/robots.txt`, `public/llms.txt`.

---

## How it works

- `GET /sitemap.xml` (`SitemapController`, ported) lists `/`, `/cases`, `/blog`, `/privacy`, `/terms`, every case and every article.
- `public/robots.txt` is ported; its sitemap URL is `https://rogeriopereira.dev/sitemap.xml`.
- `public/llms.txt` is ported with content taken only from the template copy: who, the five services, how it works, project terms, links to `/cases`, `/blog`, `/#start` and the social profiles.

---

## How to test

- Port FrontPorch's sitemap and robots tests, adapted.
- Manual: `/sitemap.xml`, `/robots.txt` and `/llms.txt` are served.

---

## Acceptance criteria

- [ ] Sitemap lists every public URL; robots and llms.txt are served.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port `SitemapController`: `/`, `/cases`, `/blog`, `/privacy`, `/terms`, every case and article. | `feat(seo): add sitemap` |
| 2 | Port `robots.txt` (sitemap URL `https://rogeriopereira.dev/sitemap.xml`). | `feat(seo): add robots.txt` |
| 3 | Port `llms.txt` with content taken only from the template copy. | `feat(seo): add llms.txt` |
| 4 | Port FrontPorch's sitemap and robots tests, adapted. | `test(seo): cover sitemap and robots` |
