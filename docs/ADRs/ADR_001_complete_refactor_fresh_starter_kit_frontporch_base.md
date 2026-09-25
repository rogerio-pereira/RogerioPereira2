# ADR-001: Complete refactor on a fresh starter kit, with FrontPorch as the base model and its quality tools

## Status

Approved

## Context

The current website is a Laravel 12 + Livewire site with features that the new site does not need (shop, Stripe, briefing, service landings, unsubscribe, Mautic). Rogerio wants a clean start where the simplest path always wins. FrontPorch (`https://github.com/rogerio-pereira/FrontPorch` at commit `805d19c`) already solves most of what the site needs.

## Decision

- **Complete refactor (D01).** Nothing from the old site survives: code, features, URLs, database structure. No redirects and no special 404 handling for old URLs. Old code lives only in the backup branch `bkp_20260924_old-website` (D02, created from the local state before the rewrite).
- **Fresh Laravel 13 Vue starter kit (D05)**, then port from FrontPorch only the pieces this site uses. All old migrations are deleted; the database starts from zero.
- **Clean Code + KISS + YAGNI is the main rule of the whole project (D06).** Abstractions, layers, interfaces, service classes, DTOs, repositories, config flags or packages that add complexity without a real gain are not allowed.
- **FrontPorch is the base model; nothing goes beyond what it has (D07).** Where FrontPorch has a solution, it is ported as-is and only changed where the plan says so. Only three things may be new: what the frontend template requires, what Rogerio decided, and the plan's list of new pieces. Anything else needs Rogerio's approval first. FrontPorch is read-only.
- **Quality = FrontPorch's tools only (D47):** Pest (Feature + Browser, coverage ≥ 90%), Pest type coverage ≥ 90%, Pint, ESLint. CI = FrontPorch's workflows without the Flux credential steps. No Larastan, no Prettier or vue-tsc gates, no screenshot comparisons.

Deviations found while executing F01 (see [02 HLD](../02%20HLD.md)):

- The scaffolding used the `laravelsail/php84-composer` image, because a `php85-composer` image does not exist.
- Postgres uses a named volume `sail-pgsql`.
- CI runs on PHP 8.5.
- The `Browser` testsuite was removed from `phpunit.xml` until `tests/Browser` exists; F03 re-adds it.

References:
- [FrontPorch](https://github.com/rogerio-pereira/FrontPorch)

## Consequences

- **Positive:**
    - Small, predictable codebase; every piece has a model to copy.
    - No leftover code or data from the old site.
- **Negative:**
    - Any need outside FrontPorch and the plan stops work until Rogerio decides.
    - Old URLs break (accepted).
- **Neutral:**
    - The old code is reachable only through the backup branch.
