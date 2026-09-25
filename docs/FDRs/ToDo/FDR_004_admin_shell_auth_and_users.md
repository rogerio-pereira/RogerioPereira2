# FDR-004: Admin shell, auth and users

**Feature:** 04
**Branch:** `feat/f04-admin-shell` · **Wave:** 1 · **Depends on:** [F02 Project docs and agent setup](../../05%20-%20Feature%20List.md#f02-project-docs-and-agent-setup)

**References:**
- Feature List: [F04 Admin shell, auth and users](../../05%20-%20Feature%20List.md#f04-admin-shell-auth-and-users)
- ADRs: [ADR-010](../../ADRs/ADR_010_admin_auth_seeded_users.md), [ADR-004](../../ADRs/ADR_004_content_model_markdown_uuids.md) (UUIDs), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- Docs: [02 HLD](../../02%20HLD.md) (admin routes), [04 - Design System](../../04%20-%20Design%20System.md) (admin theme)
- FrontPorch (read-only): `app/Http/Middleware/HandleAppearance.php`, `resources/js/layouts/core/*`, `components/AppSidebar.vue`, `components/NavMain.vue`, `pages/core/component/*`, `pages/core/users/*`, `lib/flashToast.ts`, `lib/xsrf.ts`, `routes/core.php`, `Core/UserController.php`, `Requests/Core/UserRequest.php`, users migration, `HasUuids` on `User`, `database/seeders/{DatabaseSeeder,UserSeeder,UserLocalSeeder}.php`, and its tests for these parts
- Template: none

**Owns:** users migration and model, Fortify config, `HandleAppearance`, `routes/core.php` (creates), `resources/js/layouts/core/*`, `AppSidebar.vue` (creates the items list), `NavMain.vue`, `pages/core/component/*`, `pages/core/users/*`, `lib/flashToast.ts`, `lib/xsrf.ts`, `Core/UserController`, `Core/UserRequest`, `database/seeders/{DatabaseSeeder,UserSeeder,UserLocalSeeder}.php`.

---

## How it works

- Users use UUID primary keys (`HasUuids`); `sessions.user_id` is a `foreignUuid` (FrontPorch). No SoftDeletes.
- Public registration is disabled (Fortify feature, pages, tests). The starter kit Welcome page is removed (the home route comes in F07).
- `CoreLayout`, the sidebar and flash toasts are ported from FrontPorch. `routes/core.php` uses prefix `core`, name `core.` and middleware `auth`. Dashboard and settings use the admin layout. `HandleAppearance` forces the admin panel dark (`$forceDark`).
- Users CRUD is ported from FrontPorch: `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` returns 404.
- `UserSeeder` is copied as it is (Rogerio and Sarah). `UserLocalSeeder` runs only in local/testing. `DatabaseSeeder` splits real data (always) and fake data (local/testing).
- Sidebar items are added by later features (Blog articles, Case studies, FAQs), with small additive edits.

---

## How to test

- Port FrontPorch's tests for these parts: guest access, users CRUD, seeders, Browser smoke.
- Guests requesting `/core/*`, `/dashboard` or `/settings/*` are redirected to `/login`; `/register` returns 404.
- `sail artisan migrate:fresh --seed` creates Rogerio, Sarah and (local) the test user.
- Manual: login, password reset, profile, password and 2FA work; the admin is dark.

---

## Acceptance criteria

- [ ] `/register` does not exist; `/core/*`, `/dashboard` and `/settings/*` redirect guests to `/login`; login, password reset, profile, password and 2FA work; the admin is dark.
- [ ] Users CRUD works as in FrontPorch; `show` returns 404.
- [ ] `sail artisan migrate:fresh --seed` creates Rogerio, Sarah and (local) the test user.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port FrontPorch's UUID users (migration, `sessions.user_id`, `HasUuids`); fix affected tests. | `chore(db): use UUID primary keys for users` |
| 2 | Disable registration (Fortify feature, pages, tests). Remove the starter kit Welcome page. | `feat(auth): disable public registration` |
| 3 | Port FrontPorch's admin shell: `CoreLayout`, sidebar, `HandleAppearance` (`$forceDark`), flash toasts, `routes/core.php` (prefix `core`, name `core.`, middleware `auth`); Dashboard and settings use the admin layout. | `feat(core): add the admin layout, sidebar and routes` |
| 4 | Port FrontPorch's users CRUD. | `feat(core): add users admin` |
| 5 | Port FrontPorch's `UserSeeder` (as it is), `UserLocalSeeder` and `DatabaseSeeder` (real/fake split). | `chore(db): seed admin users` |
| 6 | Port FrontPorch's tests for these parts (guest access, users CRUD, seeders, Browser smoke). | `test(core): cover admin access and users` |
