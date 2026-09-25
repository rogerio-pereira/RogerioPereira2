---
description: Default agent orientation for repositories using this .cursor setup
---

# Agent guide

**Main rule of this project: Clean Code + KISS + YAGNI.** Always take the simplest and fastest path that reaches the goal safely. FrontPorch (`~/www/FrontPorch`, read-only) is the base model: port its solutions and change only what the docs say. Nothing beyond FrontPorch. If a rule below conflicts with this one, this one wins. If something is not in `docs/`, ask; do not assume.

Reusable defaults for agents working in any repository that includes this `.cursor` folder. **Product scope, domain rules, and feature specs** live under `docs/`—read them before implementing.

Workflow details (Ralph loop, FDR lifecycle, commits, skills): `.cursor/rules/` and `.cursor/skills/`.

---

## Documentation layout

| Topic | Path |
|-------|------|
| Product requirements | `docs/01 PRD.md` |
| High-level design | `docs/02 HLD.md` |
| Branding | `docs/03 - Branding Manual.md` |
| Design system | `docs/04 - Design System.md` |
| Feature list and dependencies | `docs/05 - Feature List.md` |
| Architecture decisions | `docs/ADRs/` |
| Feature specs (todo / done) | `docs/FDRs/ToDo/`, `docs/FDRs/Done/` |
| Feature list & wave status (source of truth) | `docs/05 - Feature List.md` |
| Ralph plan state (ephemeral, gitignored) | `docs/FDRs/ImplementationPlans/` |

Do not invent requirements that contradict these documents.

---

## Stack (team default)

- PHP 8.5+
- Laravel 13 + Inertia + Vue 3 + TypeScript + Tailwind 4 + shadcn-vue/reka-ui
- Pest PHP (Feature and Browser tests; coverage thresholds in `phpunit.xml`)
- Laravel Pint, ESLint
- Laravel Sail (Docker)
- PostgreSQL

---

## Language (mandatory)

- **All repository files** must be written in **English**: source code, documentation under `docs/`, models/comments, examples, tutorials, commit messages, ADRs, FDRs, planning docs, tests descriptions, UI copy in code, and any other in-repo text.
- Chat with the human may follow the user's preferred language; **files committed to the repo stay English**.

## Coding standards

### PHP

- Follow the Language rule above (English).
- PSR style: one statement per line.
- No ternary operators in PHP (`condition ? a : b`); use `if` / `else` or early returns.
- Fluent chains: one method call per line; consistent indentation (extra indent for `->` or `.` after assignment).
- For standalone fluent chains, use a single continuation indent level for `->` or `.` lines.
- Thin controllers; business logic in services; Form Requests for validation; service interfaces when useful.
- Every Eloquent model has a factory in `database/factories`.
- Prefer readable code over cleverness.
- Keep controllers thin and move business logic to services.
- Prefer Form Requests for validation.
- Use interfaces for services when appropriate.
- Every Eloquent model must have an equivalent factory in `database/factories`.
- UI: Vue 3 components with shadcn-vue/reka-ui for the admin; follow `docs/04 - Design System.md` and `docs/03 - Branding Manual.md` (Tailwind tokens, template classes).
- **ALWAYS** Follow Clean Code and treat this motto as non‑negotiable:
    > Any fool can write code that a computer can understand. Good programmers write code that humans can understand. — Robert C. Martin

### UI

- Follow `docs/04 - Design System.md` and `docs/03 - Branding Manual.md` (theme, tokens, layout patterns).
- Feedback via toasts (check stack).

### Tests

- **Pest Browser** for E2E; **do not** use Laravel Dusk.
- Stable selectors: `data-test="..."` (Pest maps `@name` to `[data-test="name"]`) and/or form `name` attributes.
- Each new screen: dedicated browser tests; add routes to smoke coverage (e.g. `tests/Browser/WebRoutesTest.php`).
- Translation tests when the app is localized.
- At least one E2E or Feature test per critical journey—for example: create a record → validate → submit → assert persistence or redirect (e.g. lead → opportunity → pipeline stage).

### Readability

> Any fool can write code that a computer can understand. Good programmers write code that humans can understand. — Robert C. Martin

Prefer clear code over clever shortcuts.

---

## Environment and commands

All commands must run inside Sail. Use the rule in `.cursor/rules/starting-environment.mdc` as the source of truth for setup and test commands.

Start the environment: `./vendor/bin/sail up -d`.

### Quality gates (exactly these tools, nothing else)

Run in this order before opening a PR:

```
./vendor/bin/sail npm run build
./vendor/bin/sail artisan test --parallel --coverage --min=90
./vendor/bin/sail artisan test --type-coverage --min=90 --parallel
./vendor/bin/sail exec laravel.test vendor/bin/pint --parallel
./vendor/bin/sail npm run lint:check
```

That is: build, the full Pest suite once (Feature + Browser), Pest type coverage, Pint, ESLint. No Larastan, no Prettier or vue-tsc gates, no extra tools.

Browser tests load assets from `public/build` (they ignore `public/hot`), so `npm run dev` alone is not enough.

---

## No queues, jobs, workers or scheduler

This project has **no queues, jobs, workers, scheduler, Redis or Horizon**. `QUEUE_CONNECTION=sync`; everything runs inside the request. Do not add any of them.

---

## Pull requests

When a feature branch is complete and pushed:

When a feature is complete and the branch is pushed, **create the PR using the GitHub MCP server** (MCP tools), not the `gh` CLI. If MCP is unavailable, push the branch and tell the user to open the PR manually (branch name + repo URL).

Target the integration branch **`new-website`** (not `main`). Never merge; the owner merges.

---

## Notes

- Use `docs/` for product, architecture, feature and setup specifications.
- Update this guide only when **team-wide** defaults change (stack versions, coverage gates, queue conventions, PR workflow).

# Code Styleguide (**IMPORTANT**)
- Read **AND FOLLOW** `.cursor/rules/style-guide.md`
- How to start the environment and usefull commands `.cursor/rules/starting-environment.mdc`

---

# RULES
- Never run python scripts for anything, you don´t need to rely on python for any simple operation, like, reading logs, acessing pages, understanting text output (including git, logs, tests, etc)