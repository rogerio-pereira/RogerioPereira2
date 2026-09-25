# FDR-006: FAQs

**Feature:** 06
**Branch:** `feat/f06-faqs` · **Wave:** 2 · **Depends on:** [F04 Admin shell, auth and users](../../05%20-%20Feature%20List.md#f04-admin-shell-auth-and-users); task 4 also on [F07 Home page (static sections)](../../05%20-%20Feature%20List.md#f07-home-page-static-sections) (merged)

**References:**
- Feature List: [F06 FAQs](../../05%20-%20Feature%20List.md#f06-faqs)
- ADRs: [ADR-004](../../ADRs/ADR_004_content_model_markdown_uuids.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- FrontPorch (read-only): `Faq` model, migration, factory, `Core/FaqController`, `Core/FaqRequest`, `pages/core/faqs/*`, and its FAQ tests
- Template (`/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`): FAQ section of `index.html` (`<details>`/`<summary>` markup)

**Owns:** `faqs` migration, `Faq` model and factory, `FaqSeeder`, `Core/FaqController`, `Core/FaqRequest`, `pages/core/faqs/*`, `pages/home/sections/FaqSection.vue`.

---

## How it works

- `faqs` table (FrontPorch, without `service_id`): `id` UUID, `question` (string, required, max 255), `answer` (text, required, plain text escaped on render), `sort_order` (integer, ascending on the home page), timestamps, `deleted_at` (SoftDeletes).
- `FaqSeeder` creates the 8 FAQs below in this order (`sort_order` 1–8, text verbatim from the template); it belongs to the real-data part of `DatabaseSeeder`.
- The `/core/faqs` admin is FrontPorch's without services (sidebar item "FAQs"; `show` returns 404).
- After F07 is merged: `FaqSection.vue` uses the template markup (`<details>`/`<summary>`), the `faqs` prop in `HomeController` is ordered by `sort_order`, and the section sits after About. It is hidden when there are no FAQs. It renders its own leading `.divider`.

### FAQ seed (approved copy, verbatim from the template)

1. **How long does a project take?** — It depends on the scope. A simple application usually takes 4 to 8 weeks. A complex system can take 3 to 6 months. The proposal always includes a delivery date.
2. **Do I need a full spec before we talk?** — No. A clear problem or idea and a rough timeline are enough. We define the scope together during the assessment.
3. **What stack do you use?** — Mostly PHP (Laravel), Vue.js and AWS, with automated tests and CI/CD. If you already have a system, tell me what it runs on and I'll tell you if I'm the right person for it.
4. **What happens after delivery?** — There's a short fix window. If a bug shows up in what I delivered, I fix it. The length is set in the proposal. After that, you own the system and run it with the docs I leave. New features are a new project.
5. **What if the scope changes in the middle?** — Small changes are fine. For bigger ones, we agree on the new timeline and price before I start on them. You're never surprised by the final bill.
6. **Do you work hourly or on a retainer?** — No retainers. Well-defined work has a fixed scope and a fixed price. Exploratory or advisory work, like some consulting, is priced by time.
7. **Will you sign an NDA?** — Yes. Your work stays confidential. That's also why the cases on this page never name a client.
8. **Can I hire you full-time or part-time?** — No. I work on projects only, as a self-employed engineer. There's no employment relationship, office hours or staff meetings.

---

## How to test

- Port FrontPorch's FAQ admin tests (without services).
- Home tests: FAQs follow `sort_order`; the section is not rendered when there are no FAQs.
- Browser: a FAQ opens and closes.
- `sail artisan migrate:fresh --seed` creates the 8 FAQs in template order.

---

## Acceptance criteria

- [ ] FAQs can be created, edited, ordered (`sort_order`) and deleted in `/core` (FrontPorch behavior).
- [ ] The home FAQ uses the template markup and follows `sort_order`; with no FAQs, the section is not rendered.
- [ ] `migrate:fresh --seed` creates the 8 FAQs in template order.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port FrontPorch's FAQ migration, model and factory without `service_id`. | `feat(faq): add FAQ table, model and factory` |
| 2 | `FaqSeeder` with the 8 FAQs above (real-data part of `DatabaseSeeder`). | `chore(db): seed the FAQs from the landing page` |
| 3 | Port FrontPorch's FAQ admin without services; sidebar item "FAQs"; port its tests. | `feat(core): add FAQs admin` |
| 4 | After F07 is merged: rebase; `FaqSection.vue` with the template markup, `faqs` prop in `HomeController` (by `sort_order`), placed after About; hidden when empty. Tests: order, hidden when empty, Browser open/close. | `feat(home): show FAQs from the database` |
