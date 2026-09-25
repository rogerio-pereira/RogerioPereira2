# FDR-001: Foundation reset

**Feature:** 01
**Branch:** `feat/f01-foundation` · **Wave:** 0 (orchestrator, right after Step 0) · **Depends on:** Step 0 · **Status:** Done (PR #1 open)

**References:**
- Feature List: [F01 Foundation reset](../../05%20-%20Feature%20List.md#f01-foundation-reset)
- ADRs: [ADR-001](../../ADRs/ADR_001_complete_refactor_fresh_starter_kit_frontporch_base.md), [ADR-007](../../ADRs/ADR_007_no_queues_workers_scheduler_redis.md)
- FrontPorch (read-only, `~/www/FrontPorch` at `805d19c`): `compose.yaml`, `docker/8.5/**`, `docker/pgsql/**`, `phpunit.xml`, `pint.json`, `eslint.config.js`, `package.json` (`lint`/`lint:check` scripts), `.github/workflows/tests.yml`, `lint.yml`, `_lint-reusable.yml`, `.env.example`
- Template: none

**Goal:** the repo holds a clean Laravel 13 Vue starter kit with FrontPorch's Sail setup, test tools and CI, and nothing from the old site.

---

## How it works

- Every tracked file of the old site is removed (the old code stays in `bkp_20260924_old-website`).
- A fresh Laravel 13 Vue starter kit is installed at the repo root.
- FrontPorch's Sail setup is ported without Redis: default bucket `rogeriopereira`, Octane `--port=80`.
- Octane (Swoole) and S3 storage packages are added, as in FrontPorch.
- `.env.example` follows the plan's environment variables, without the project settings block (F10 and F11 add those keys).
- FrontPorch's Pest browser, type coverage, Pint and ESLint setup and CI workflows are ported (without the Flux credential steps; PR triggers on `main` and `new-website`).

**Deviations found while executing:**
- The scaffolding used the `laravelsail/php84-composer:latest` image, because a `php85-composer` image does not exist.
- Postgres uses a named volume `sail-pgsql` for its data directory.
- CI runs on PHP 8.5.
- The `Browser` testsuite was removed from `phpunit.xml` until `tests/Browser` exists (F03 or later re-adds it).

---

## How to test

- `sail up -d` starts `laravel.test`, `pgsql`, `pgadmin`, `mailpit`, `minio`, `createbuckets`; there is no Redis; the `rogeriopereira` bucket exists.
- `sail artisan migrate` runs on PostgreSQL; `/login` renders.
- Run the gates: `sail npm run build`, `sail artisan test --parallel --coverage --min=90`, `sail artisan test --type-coverage --min=90 --parallel`, `sail exec laravel.test vendor/bin/pint --parallel`, `sail npm run lint:check`.
- CI is green on the PR.

---

## Acceptance criteria

- [x] `bkp_20260924_old-website` and `new-website` exist on `origin`.
- [x] No file of the old site remains; old ignored folders are gone from disk (Step 0.9).
- [x] `sail up -d` starts `laravel.test`, `pgsql`, `pgadmin`, `mailpit`, `minio`, `createbuckets`; no Redis; the `rogeriopereira` bucket exists.
- [x] Migrations run on PostgreSQL; `/login` renders.
- [x] Gates green locally and in CI.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Remove every tracked file of the old site. | `chore: remove the old website (kept in bkp_20260924_old-website)` |
| 2 | Create the starter kit in a temp folder with the Composer container, move everything (dotfiles too) to the repo root, delete the temp folder. | `chore: install the Laravel 13 Vue starter kit` |
| 3 | `composer require laravel/sail --dev`; port FrontPorch `compose.yaml`, `docker/8.5/`, `docker/pgsql/`: remove the `redis` service and its `depends_on`, default bucket `rogeriopereira`, Octane `--port=80` in `SUPERVISOR_PHP_COMMAND`. | `build(sail): add FrontPorch Sail services without Redis` |
| 4 | `composer require laravel/octane league/flysystem-aws-s3-v3` and Octane install with Swoole, as in FrontPorch. | `build: add Octane and S3 storage packages` |
| 5 | `.env.example` as in the plan's environment variables, without the "PROJECT SETTINGS" block. | `chore(config): set up the environment example` |
| 6 | Test and lint tools from FrontPorch: `pestphp/pest-plugin-browser`, `pestphp/pest-plugin-type-coverage`, `playwright` (npm); FrontPorch `phpunit.xml` env block, `pint.json`, `eslint.config.js` and `lint`/`lint:check` scripts. Nothing else. | `test: configure Pest browser tests, type coverage, Pint and ESLint` |
| 7 | Port FrontPorch CI without the Flux credential steps; PR triggers on `main` and `new-website`. | `ci: add lint and test workflows` |
| 8 | Start and verify, fix starter kit tests broken by tasks 1–7, open the PR. | `test: keep the starter kit suite green` |

Additional commits made during execution: `fix(sail): use a named volume for the pgsql data directory`, `style(api/ui): Fix code style (pint and lint)`, `ci: run workflows on PHP 8.5`.
