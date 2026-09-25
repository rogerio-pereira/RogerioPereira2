# ADR-002: Client-side Inertia rendering with server-side SEO meta (no SSR, no JSON-LD)

## Status

Approved

## Context

Public pages and the admin are built with Inertia + Vue. Crawlers (LinkedIn, X, Facebook) need the right meta tags without running JavaScript, but full SSR adds moving parts.

## Decision

- **Inertia + Vue for public pages and `/core`, client-side rendering, no SSR (D11).** Vue renders pages from Inertia props that come from the database.
- **SEO meta tags are printed by the server (D12)** in `resources/views/app.blade.php` from a `seo` array passed by each controller (`->withViewData('seo', [...])`), built from the database data. Vue only sets `<Head :title>` for client-side navigation.
- **No JSON-LD anywhere (D15).** The template's JSON-LD blocks are removed.
- **One server-side block prints the same set of tags on every page (D40):** title, description, canonical (`url()->current()`), `og:type=website`, `og:title`, `og:description`, `og:url`, `og:image`, `twitter:card`, `twitter:site`, `twitter:image`, `theme-color`. An article's `og:image` is its cover; other pages use `/og-image.jpg`. Plus FrontPorch's `sitemap.xml`, `robots.txt` and `llms.txt`.

## Consequences

- **Positive:**
    - Crawlers get correct tags without JavaScript.
    - No SSR server to run or deploy.
- **Negative:**
    - Page body content is rendered on the client.
    - No structured data for search engines.
- **Neutral:**
    - Every public controller builds a `seo` array (title and description per page; see [02 HLD](../02%20HLD.md)).
