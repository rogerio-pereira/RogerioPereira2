# FDR-009: Blog

**Feature:** 09
**Branch:** `feat/f09-blog` · **Wave:** 3 · **Depends on:** [F05 Media and Markdown field](../../05%20-%20Feature%20List.md#f05-media-and-markdown-field), [F07 Home page (static sections)](../../05%20-%20Feature%20List.md#f07-home-page-static-sections)

**References:**
- Feature List: [F09 Blog](../../05%20-%20Feature%20List.md#f09-blog)
- ADRs: [ADR-004](../../ADRs/ADR_004_content_model_markdown_uuids.md), [ADR-005](../../ADRs/ADR_005_media_storage_compression_orphan_deletion.md), [ADR-012](../../ADRs/ADR_012_no_ai_in_the_site.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [02 HLD](../../02%20HLD.md) (data model, routes, SEO)
- FrontPorch (read-only, all blog files): `BlogArticle` model, observer, factory, `BlogArticlesSeeder`, migration, `Core/BlogArticleController`, `Core/BlogArticleRequest`, `pages/core/blog-articles/*`, `BlogController`, `BlogArticleController`, and their tests
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): `blog/index.html`, `blog/title-slug/index.html`, blog section of `index.html`

**Owns:** `blog_articles` migration, `BlogArticle` model, observer, factory, `BlogArticlesSeeder`, `Core/BlogArticleController`, `Core/BlogArticleRequest`, `pages/core/blog-articles/*`, `BlogController`, `BlogArticleController`, `pages/blog/Blog.vue`, `pages/blog-article/BlogArticle.vue`, `components/site/PostCard.vue`, `pages/home/sections/BlogSection.vue`.

---

## How it works

- **Table `blog_articles`** (FrontPorch, adapted; UUID PK, no SoftDeletes): `title` (string, unique, required), `slug` (unique, auto), `excerpt` (string, required; the template's name for FrontPorch's `description`), `category` (string, required, free text), `image` (string, required, cover URL), `content` (text, required, Markdown), `published_by` (string, auto), timestamps (`created_at` = publish date shown).
- **Model:** appended accessor `content_html` = `Str::markdown($this->content, [...safe options])` (`html_input => 'strip'`, `allow_unsafe_links => false`). FrontPorch observer: slug on create and on every title change; `published_by` (name of the logged-in user) on create. Cover `alt` = article title.
- **Seeder:** `BlogArticlesSeeder` (local/testing) in the fake-data part of `DatabaseSeeder`.
- **Admin (`/core/blog/articles`):** FrontPorch's blog admin with `RichTextEditor` replaced by `MarkdownField` (directory `blog`) and an `excerpt` field; cover required on create, optional on update. `update`: when a new cover is sent, delete the old one (`MediaUploader::delete`); `deleteRemovedImages(old, new)` on the content. `destroy`: delete the cover and the content images, then the row. Sidebar item "Blog articles". `show` returns 404.
- **Public:** `GET /blog` (12 per page, newest first) and `GET /blog/{article:slug}` (`more` = 3 newest except the current one). SEO: `/blog` title `Blog · Rogerio Pereira`, description from the template `blog/index.html` meta; an article has title `{title} · Rogerio Pereira`, description `excerpt`, `og:image` = the cover URL.
- **List page:** `PageHead` "Notes from the week.", list-top, grid of `PostCard`, `SitePagination`.
- **Article page:** page head (crumbs, category, title, post-meta with the portrait, author, date `M j, Y` in `<time datetime="Y-m-d">`), cover (`alt` = title), `.prose` content, author box (template bio), "More articles" (hidden if empty), CTA band.
- **Home:** `BlogSection.vue` shows the 3 newest articles and "Read all articles" as the last section; hidden when there are none.
- Markup, classes and copy come verbatim from the template.

### Approved copy (empty state)

- `/blog` with no articles: `No articles published yet.` (one line, mono, muted, like `.list-top`)

---

## How to test

- Port and adapt FrontPorch's admin tests (Feature + Browser).
- Public tests: pagination, order, 404, "More articles" excludes the current one, `og:image` is the cover, empty states, home section; Browser smoke. Add the routes to `tests/Browser/WebRoutesTest.php`.
- Replacing a cover or removing an image from the Markdown deletes the old file; deleting an article deletes its cover and images (`Storage::fake()`).
- Changing a title regenerates the slug; the author is the user who created the article.

---

## Acceptance criteria

- [ ] Articles are written in Markdown with inline images and a compressed cover; replacing or deleting removes the old files.
- [ ] `/blog` and `/blog/{slug}` use the template markup and classes; the server HTML of an article has its title, excerpt and cover in the meta tags.
- [ ] Changing a title regenerates the slug; the author is the user who created the article.
- [ ] The home shows the 3 newest articles, or no section at all.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port FrontPorch's `blog_articles` migration with the changes above (`excerpt` instead of `description`, no SoftDeletes). | `chore(db): create blog_articles table` |
| 2 | Port `BlogArticle` model (+ `content_html` accessor), FrontPorch observer, factory. | `feat(blog): add blog article model, observer and factory` |
| 3 | Port `BlogArticlesSeeder` (local/testing) into the fake-data part of `DatabaseSeeder`. | `chore(db): seed demo articles for local development` |
| 4 | Port FrontPorch's blog admin with `MarkdownField`, `excerpt`, file deletion on `update` and `destroy`; sidebar item "Blog articles". | `feat(core): add blog articles admin` |
| 5 | Port and adapt FrontPorch's admin tests (Feature + Browser). | `test(core): cover blog articles admin` |
| 6 | Port `BlogController` (12 per page) and `BlogArticleController` (`more`); `seo` per page; routes `GET /blog`, `GET /blog/{article:slug}`. | `feat(blog): add public blog routes` |
| 7 | `PostCard.vue` and `Blog.vue` (`PageHead` "Notes from the week.", list-top, grid, `SitePagination`, empty-state line). | `feat(blog): add blog list page` |
| 8 | `BlogArticle.vue` (article page as described above). | `feat(blog): add article page` |
| 9 | `BlogSection.vue` on the home page, `articles` prop in `HomeController`, last section; hidden when empty. | `feat(home): show the latest articles` |
| 10 | Public tests: pagination, order, 404, "More articles", `og:image`, empty states, home section; Browser smoke. | `test(blog): cover public blog pages` |
