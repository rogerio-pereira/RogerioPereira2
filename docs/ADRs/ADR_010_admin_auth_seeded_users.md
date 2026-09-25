# ADR-010: Admin, auth and seeded users (FrontPorch)

## Status

Approved

## Context

Rogerio manages cases, articles, FAQs and users from an admin. FrontPorch already has one.

## Decision

- **`/core` = FrontPorch's admin (D41)** with CRUD for cases, blog articles, FAQs and users: `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` returns 404. Controllers in `App\Http\Controllers\Core`, routes in `routes/core.php`, middleware `auth` only. Flash toasts as in FrontPorch.
- **Admin look (D42):** starter-kit layout and components with the brand values in the theme variables (`:root` and `.dark`), and the admin panel forced dark by FrontPorch's `HandleAppearance` middleware. The starter kit Dashboard and Appearance pages stay. No glass, neon or textures in the admin.
- **Auth (D43):** Fortify from the starter kit. Public registration disabled. Login, password reset, profile, password and 2FA stay. After login: `/dashboard`.
- **Seeders (D44) = FrontPorch:** `UserSeeder` copied as it is (Rogerio and Sarah, password hashes in code; Rogerio accepted the risk of a public repo); `UserLocalSeeder` in local/testing; `FaqSeeder` with the 8 FAQs from the template; demo cases and articles from factories in local/testing (`fake()->imageUrl()` for images).
- **Favicon (D45):** an "RP" monogram `favicon.svg` (Space Grotesk 700, teal `#00BEBE` on steel `#151719`), plus `favicon.ico` and `apple-touch-icon.png` generated from it.
- **Branded error pages (D46):** 404, 500 and 503 (FrontPorch's error views, new look).

## Consequences

- **Positive:**
    - Proven admin; small port.
- **Negative:**
    - Password hashes of the seeded users are in a public repo (accepted by Rogerio).
    - `UserSeeder` is not idempotent; run once in production.
- **Neutral:**
    - The admin panel is always dark.
