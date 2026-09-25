# ADR-011: Delivery workflow: integration branch, waves of up to 3 agents, PRs merged by the owner

## Status

Approved

## Context

The rewrite is executed by Claude Code sessions with sub-agents. Rogerio wants to review everything and keep small commits.

## Decision

- **Integration branch `new-website` (D03)**, created from `main`. Each feature is a `feat/...` branch with a PR into `new-website`. At launch, one PR `new-website` → `main`.
- **Rogerio merges every PR (D04).** Agents open PRs (GitHub MCP, never the `gh` CLI) and stop. The next wave starts only after the current wave's PRs are merged. After each merge, the orchestrator rebases the other open PRs of the wave and re-runs the gates. Merge without squash, to keep the small commits.
- **Parallelism (D09):** at most 3 feature agents per wave, each on its own branch and git worktree, each worktree with its own ports in `.env`.
- The waves are in [05 - Feature List](../05%20-%20Feature%20List.md). Branches, ports, orchestrator protocol, shared files and the definition of done are below.
- Docs are in English (D10); the docs in `docs/` are generated from the plan and become the day-to-day source of truth. If they disagree with the plan, stop and ask Rogerio.

### Branches, worktrees and ports

- One branch per feature, created from the latest `origin/new-website`: `feat/f03-design-system`, `feat/f04-admin-shell`, and so on (F01 uses `feat/f01-foundation`, F02 uses `docs/f02-project-docs`).
- Each parallel feature runs in its own git worktree, for example: `git worktree add ../RogerioPereira-worktrees/f03 -b feat/f03-design-system origin/new-website`.
- Each worktree has its own `.env` (copied from `.env.example`) with its own port slot. Docker Compose uses the folder name as the project name, so containers and volumes do not collide.

| Slot | `APP_PORT` | `VITE_PORT` | `FORWARD_DB_PORT` | `FORWARD_PGADMIN_PORT` | `FORWARD_MAILPIT_PORT` | `FORWARD_MAILPIT_DASHBOARD_PORT` | `FORWARD_MINIO_PORT` | `FORWARD_MINIO_CONSOLE_PORT` |
|---|---|---|---|---|---|---|---|---|
| main checkout | 80 | 5173 | 5432 | 5050 | 1025 | 8025 | 9000 | 8900 |
| agent 1 | 8081 | 5174 | 5433 | 5051 | 1026 | 8026 | 9001 | 8901 |
| agent 2 | 8082 | 5175 | 5434 | 5052 | 1027 | 8027 | 9002 | 8902 |
| agent 3 | 8083 | 5176 | 5435 | 5053 | 1028 | 8028 | 9003 | 8903 |

Also set `APP_URL=http://localhost:{APP_PORT}` and `AWS_URL=http://localhost:{FORWARD_MINIO_PORT}/rogeriopereira` in each worktree `.env`. Stop a worktree's containers (`sail down`) when its feature PR is opened; remove the worktree after the PR is merged.

### Orchestrator protocol

1. Before a wave: `git fetch`, confirm every PR of the previous wave is merged into `new-website`.
2. Create the worktrees and `.env` files (ports above), then start one sub-agent per feature.
3. While agents work: answer their questions only from the plan and the repo docs. Anything not covered goes to Rogerio.
4. When an agent reports its PR: check the gates passed, nothing beyond FrontPorch was added (except the plan's list of new pieces), the PR lists any new text needing approval, and the FDR was moved to `Done/`. Tell Rogerio the PR is ready.
5. After Rogerio merges a PR: rebase every other open PR of the wave on `origin/new-website`, resolve conflicts in shared files, run the full gates again, push (`--force-with-lease`), and report.
6. After the wave: update `docs/05 - Feature List.md` (wave status "Done") in a separate `docs` PR or as part of the last PR of the wave, and remove the worktrees.

### Shared files (touched by more than one feature)

Agents change shared files **only with small, additive edits** (add a route, a sidebar item, a prop, a section tag). Never reformat or reorder them. The orchestrator resolves conflicts during rebases.

| File | Touched by |
|---|---|
| `resources/js/app.ts` (layout resolver) | F03 (public pages → `SiteLayout`), F04 (`core/`, `settings/`, `Dashboard` → `CoreLayout`, as in FrontPorch) |
| `routes/web.php` | F07, F08, F09, F10, F11, F12 |
| `routes/core.php` | F04, F05, F06, F08, F09 |
| `resources/js/components/AppSidebar.vue` (nav items) | F04, F06, F08, F09 |
| `app/Http/Controllers/HomeController.php`, `resources/js/pages/home/Home.vue` | F07 (creates), F06, F08, F09, F10 |
| `database/seeders/DatabaseSeeder.php` | F04 (creates), F06, F08, F09 |
| `config/site.php` | F03 (ports it, SEO defaults), F10 (`calendar_url`), F11 (analytics IDs) |
| `resources/views/app.blade.php` | F03 (ports it and adds the SEO block), F10 (Turnstile script), F11 (analytics) |
| `app/Http/Middleware/HandleInertiaRequests.php` | F10 (Turnstile props, FrontPorch) |
| `resources/js/components/site/SiteFooter.vue` | F03 (creates), F11 (legal links) |
| `.env.example` | F01 (creates), F10, F11 |
| `tests/Browser/WebRoutesTest.php` (smoke list) | every feature that adds a route |

### Definition of done (every feature)

- All acceptance criteria of the FDR are met and covered by tests (Feature, plus Browser for each new screen, plus the route in `WebRoutesTest.php`).
- Gates green: `sail npm run build`, the full Pest suite once (`--parallel --coverage --min=90`), Pest type coverage (`--min=90`), Pint, `sail npm run lint:check`.
- Nothing added beyond FrontPorch except the plan's list of new pieces.
- Commits are small and follow Conventional Commits; the FDR is moved to `Done/` in a separate docs commit.
- PR open against `new-website` (GitHub MCP), not merged.

## Consequences

- **Positive:**
    - Small reviewable PRs; the owner controls every merge.
- **Negative:**
    - One wave per session; merges gate the next wave.
- **Neutral:**
    - Shared files get small additive edits only; the orchestrator resolves conflicts during rebases.
