# ADR-012: No AI in the site

## Status

Approved

## Context

FrontPorch has an AI-based blog agent (`laravel/ai`, tools and a weekly command). Rogerio writes his own articles and cases.

## Decision

**No AI in the site (D17).** FrontPorch's `laravel/ai` agent, tools and weekly command are not ported (`app/Ai/**`, `GenerateWeeklyBlogArticleCommand`, `config/ai.php`, `config/blog.php`, `docs/ai/**`). Articles and cases are written by hand in `/core`.

## Consequences

- **Positive:**
    - No AI dependency, keys or cost; fewer packages.
- **Negative:**
    - Every article is written manually.
- **Neutral:**
    - Blog content is short retrospectives from Rogerio's weekly notes.
