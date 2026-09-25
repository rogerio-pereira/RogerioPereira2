# FDR-008: Cases

**Feature:** 08
**Branch:** `feat/f08-cases` · **Wave:** 3 · **Depends on:** [F05 Media and Markdown field](../../05%20-%20Feature%20List.md#f05-media-and-markdown-field), [F07 Home page (static sections)](../../05%20-%20Feature%20List.md#f07-home-page-static-sections)

**References:**
- Feature List: [F08 Cases](../../05%20-%20Feature%20List.md#f08-cases)
- ADRs: [ADR-004](../../ADRs/ADR_004_content_model_markdown_uuids.md), [ADR-005](../../ADRs/ADR_005_media_storage_compression_orphan_deletion.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [02 HLD](../../02%20HLD.md) (data model, routes, SEO)
- FrontPorch (read-only, patterns only; the schema is new): case study model, observer, factory, seeder, `Core/CaseStudyController`, `pages/core/case-studies/*`, `PortfolioController`, `PortfolioStudyCaseController`, and their tests
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): `cases/index.html`, `cases/case-slug/index.html`, cases section of `index.html`

**Owns:** `case_studies` migration, `CaseStudy` model, observer, factory, `CaseStudiesSeeder`, `Core/CaseStudyController`, `Core/CaseStudyRequest`, `pages/core/case-studies/*`, `CasesController`, `CaseStudyController` (public), `pages/cases/Cases.vue`, `pages/case-study/CaseStudy.vue`, `components/site/CaseCard.vue`, `pages/home/sections/CasesSection.vue`.

---

## How it works

- **Table `case_studies`** (model `CaseStudy`, UUID PK, no SoftDeletes): `category` (string, required), `title` (string, unique, required), `slug` (unique, auto), `problem_short`, `decision_short`, `result_short` (strings, required), `problem`, `constraints_alternatives`, `decision`, `result` (text, required, plain paragraphs split on blank lines), `case_study` (text, required, Markdown), `my_role` (string, optional), `stack` (JSON array of strings, optional), `metrics` (JSON array of `{value, label}`, optional, max 3), `lesson` (text, optional), timestamps.
- **Model:** casts `stack` and `metrics` to `array`; appended accessor `case_study_html` = `Str::markdown($this->case_study, [...safe options])` (`html_input => 'strip'`, `allow_unsafe_links => false`). FrontPorch slug observer: slug from the title on create and on every title change.
- **Seeder:** `CaseStudiesSeeder` (local/testing, from factories, like FrontPorch) in the fake-data part of `DatabaseSeeder`.
- **Admin (`/core/case-studies`, FrontPorch pattern):** index newest first; form with every field, `MarkdownField` (directory `case-studies`) for `case_study`, one comma-separated input for `stack`, three fixed value + label pairs for `metrics`; sidebar item "Case studies". `CaseStudyRequest`: required fields, unique title; `prepareForValidation` turns `stack` into an array of trimmed non-empty items and drops empty metric pairs; `metrics` max 3. The controller comments that the observer sets the slug. `update` calls `deleteRemovedImages(old, new)`; `destroy` deletes the `case_study` images, then the row. `show` returns 404.
- **Public:** `GET /cases` (12 per page, newest first) and `GET /cases/{caseStudy:slug}` (previous = next older, next = next newer, each `{title, slug}` or null). SEO: `/cases` title `Case notes · Rogerio Pereira`, description from the template `cases/index.html` meta; a case has title `{title} · Case notes · Rogerio Pereira`, description `problem_short`, `og:image` `/og-image.jpg`.
- **List page:** `PageHead`, "Showing X–Y of N · // Newest first", grid of `CaseCard`, `SitePagination`.
- **Detail page:** Problem, Constraints and alternatives, Decision, Result (plain text split on blank lines into `<p>`), metrics, Case study (`.prose` + `case_study_html`), Lesson, previous/next, side panel (category, my role, stack chips), side CTA, "All case notes" link. Empty optional fields render nothing.
- **Home:** `CasesSection.vue` shows the 3 newest cases, the NDA note and "Read all case notes", after Services; hidden when there are none.
- Markup, classes and copy come verbatim from the template.

### Approved copy (empty state)

- `/cases` with no cases: `No case notes published yet.` (one line, mono, muted, like `.list-top`)

---

## How to test

- Admin tests (Feature + Browser), including inserting an image with the Markdown field.
- Public tests: pagination, order, 404, optional blocks hidden, previous/next, empty state, home section hidden when empty, SEO tags; Browser smoke. Add the routes to `tests/Browser/WebRoutesTest.php`.
- Deleting a case removes the row and its images (`Storage::fake()`).
- Changing a title regenerates the slug.

---

## Acceptance criteria

- [ ] Cases can be managed in `/core`; deleting one removes it and its images.
- [ ] `/cases` and `/cases/{slug}` use the template markup and classes; empty optional fields leave no empty blocks.
- [ ] Changing a title regenerates the slug.
- [ ] The home shows the 3 newest cases, or no section at all.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Migration. | `chore(db): create case_studies table` |
| 2 | `CaseStudy` model (`HasUuids`; casts; `case_study_html` accessor), FrontPorch slug observer, factory. | `feat(cases): add case study model, observer and factory` |
| 3 | `CaseStudiesSeeder` (local/testing, factories) in the fake-data part of `DatabaseSeeder`. | `chore(db): seed demo cases for local development` |
| 4 | Admin CRUD (FrontPorch pattern) as described above; `CaseStudyRequest`; `update` calls `deleteRemovedImages`; `destroy` deletes the images, then the row; `show` → 404. | `feat(core): add case studies admin` |
| 5 | Admin tests (Feature + Browser, including inserting an image with the Markdown field). | `test(core): cover case studies admin` |
| 6 | Public controllers `CasesController` and `CaseStudyController`; `seo` per page; routes `GET /cases`, `GET /cases/{caseStudy:slug}`. | `feat(cases): add public case routes` |
| 7 | `CaseCard.vue` and `Cases.vue` (`PageHead`, showing line, grid, `SitePagination`, empty-state line). | `feat(cases): add case notes list page` |
| 8 | `CaseStudy.vue` (detail page as described above). | `feat(cases): add case detail page` |
| 9 | `CasesSection.vue` on the home page, `cases` prop in `HomeController`, after Services; hidden when empty. | `feat(home): show the latest cases` |
| 10 | Public tests: pagination, order, 404, optional blocks hidden, previous/next, empty state, home section hidden when empty, SEO tags; Browser smoke. | `test(cases): cover public case pages` |
