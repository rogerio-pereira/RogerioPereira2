---
name: admin-resource-crud
description: >-
  Scaffolds or reviews admin CRUD using index/create/store/edit/update/destroy
  without a Show page (show → 404), optional SoftDeletes, and Observer-derived
  fields with controller comments. Use when building admin resources, CMS
  controllers, or Inertia admin pages.
---

# Admin resource CRUD (no Show)

## Default surface

| Method | Behavior |
|--------|----------|
| `index` | List |
| `create` / `store` | Create form + persist |
| `edit` / `update` | Edit form + persist |
| `destroy` | Delete (soft or hard per model) |
| `show` | **404** or empty — no Show view |

Resource routes are fine; still implement `show` as 404 if the framework registers it.

## Patterns

1. **Route key:** UUID PK (or project convention) in admin URLs.
2. **Derived fields:** Observer sets `slug` / attribution fields; **comment on `store`/`update`** that the Observer runs.
3. **Children:** Prefer syncing images/relations on the parent form; avoid a separate child admin resource unless listing children alone is a product need.
4. **Validation:** Form Requests; password flows include confirmation when creating/updating users.
5. **Auth:** Prefer `auth` only when the product has few admins and no ACL requirement; do not add roles “just in case.”

## UI

- No Show page components
- Hide public sections when the related collection is empty
- Stable test selectors (`data-test` / equivalent)

## Anti-patterns

- Full resource + Show “because REST”
- Separate MediaUploadController when parent multipart submit is enough
- `is_published` plus SoftDeletes plus drafts without a stated need
