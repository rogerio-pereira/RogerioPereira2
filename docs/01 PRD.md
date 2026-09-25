# Rogerio Pereira Website — Product Requirements Document (PRD)

**Version:** 1.0 · **Source:** planning-new-website.md v2.1 (§2, §14)

---

## 1. Summary

The personal website of **Rogerio Pereira**, a senior full-stack engineer (15+ years) who takes on freelance projects on the side of a full-time role. Domain: `rogeriopereira.dev`.

The site replaces the current Laravel 12 + Livewire site. It is a **complete refactor**: nothing from the old project exists in the new one, including old URLs and the old database structure (see [ADR_001](ADRs/ADR_001_complete_refactor_fresh_starter_kit_frontporch_base.md)).

## 2. Goal

Turn visitors into qualified project requests.

One offer: websites, systems, AI integration, automation and consulting, delivered as projects with a clear scope, a start and a finish. No pricing, no urgency, no "DM me".

## 3. Audience

Direct clients looking for project-based work.

## 4. Pages and features

- **Home** (`/`): a long landing page migrated from the approved HTML template, with three database-backed parts: latest cases, FAQ and latest blog articles.
- **Case notes** (`/cases`, `/cases/{slug}`): anonymized case studies with a fixed structure.
- **Blog** (`/blog`, `/blog/{slug}`): "Notes from the week", short retrospectives written by Rogerio.
- **Start a project form**: pings Slack and emails the visitor a Calendly booking link. Nothing is stored in the database.
- **Privacy and Terms** pages (`/privacy`, `/terms`).
- **Analytics and SEO**: GA4 and Meta Pixel (env-gated, no cookie banner), server-side SEO meta tags, `sitemap.xml`, `robots.txt` and `llms.txt`.
- **Admin** under `/core`: manage cases, articles, FAQs and users (the FrontPorch admin).

Full details: [02 HLD](02%20HLD.md) and [05 Feature List](05%20-%20Feature%20List.md).

## 5. Out of scope

Anything not in FrontPorch and not listed in the plan's "new pieces" list · AI writing or image generation · drafts or scheduled publishing · storing leads, CRM, email to Rogerio on new leads · Mautic, Stripe, ebooks, briefing form, service pages, testimonials, anything from the old site · redirects from old URLs · SSR · JSON-LD · cookie banner · newsletter, comments, search, RSS · category taxonomy or filters · languages other than English · queues, jobs, workers, scheduler, Redis · image resizing · cleanup of images uploaded in the editor but never saved · restoring deleted cases or articles · Larastan, Prettier or vue-tsc as gates, screenshot comparisons.
