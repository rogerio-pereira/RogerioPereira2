# ADR-004: Content model: cases, blog and FAQs in the database; Markdown; no drafts; slugs follow the title; UUIDs

## Status

Approved

## Context

The site has three kinds of editable content (cases, blog articles, FAQs) plus users. Everything else is fixed copy. The content model must stay as simple as FrontPorch's.

## Decision

- **Database-backed content (D14):** cases, blog articles, FAQs, users. Everything else (services, pains, process, fit check, about, footer) is hardcoded in Vue.
- **No drafts (D16).** A row in the table is published. No `is_published`, no `published_at`. The date shown is `created_at`.
- **Long text is Markdown (D18)** in a plain textarea, rendered with `Str::markdown()` with `html_input => 'strip'` and `allow_unsafe_links => false`, called directly in the model accessor. An "Insert image" button uploads a file and inserts `![](url)` at the cursor. FrontPorch's TipTap editor is not ported.
- **Cases (D22):** one table `case_studies`, model `CaseStudy` (FrontPorch names; `case` is a reserved word in PHP). The optional lists `stack` and `metrics` are nullable JSON columns. In the admin form `stack` is one comma-separated input and `metrics` are three fixed value + label pairs; the Form Request turns them into arrays.
- **Slugs follow the title (D23)** (FrontPorch Observer): generated on create and regenerated whenever the title changes. A broken old link is accepted. Titles are unique.
- **Blog author (D24)** = name of the logged-in user, set by the Observer on create (`published_by`). Cover `alt` = article title.
- **Listings (D25):** `/cases` and `/blog` show 12 per page, newest first; the home shows the 3 latest of each; an empty home section is hidden; an empty list page shows one line of empty-state copy.
- **Detail navigation (D26):** an article shows "More articles" (the 3 newest except the current one); a case shows previous (older) and next (newer) case. Each is hidden if none.
- **Deletes (D27):** deleting a case or an article is a real delete and its images are deleted from storage. FAQs keep SoftDeletes (FrontPorch). Users are hard-deleted.
- **UUID primary keys (D28)** on users and every content table (FrontPorch).

References:
- [02 HLD](../02%20HLD.md), data model section

## Consequences

- **Positive:**
    - Fewer columns, states and admin screens.
    - Same patterns as FrontPorch (Observer, factories, seeders).
- **Negative:**
    - Nothing can be saved unpublished.
    - Renaming a title changes its URL.
    - Deleted cases and articles cannot be restored.
- **Neutral:**
    - Public copy of the fixed sections lives in Vue components, not in the database.
