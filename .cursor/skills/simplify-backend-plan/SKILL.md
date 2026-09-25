---
name: simplify-backend-plan
description: >-
  Audits a backend/CMS plan for overengineering and proposes simpler defaults
  (visibility, relations, admin surface, uploads, config). Use when a plan feels
  bloated, before migrations, or when the user asks to simplify schema/admin design.
---

# Simplify a backend / CMS plan

## Goal

Replace speculative complexity with defaults that are easy to reverse later if needed.

## Pass checklist

Work through the plan domain by domain. For each entity, ask whether each item is **required now**:

### Visibility
- [ ] Can “in DB + not soft-deleted” replace `is_published` / drafts?
- [ ] SoftDeletes for content; hard delete only when intentional (e.g. accounts)?

### Shape
- [ ] Drop unused columns (nav labels duplicated by title, cover fields if first gallery image works, etc.)
- [ ] Free-text label instead of a category/taxonomy CRUD?
- [ ] One body format instead of JSON blocks + dual Markdown/HTML?

### Identity & URLs
- [ ] UUID PK (or project standard) consistently?
- [ ] Public `slug` from title via Observer + controller comment?

### Admin
- [ ] Resource without Show (`show` → 404)?
- [ ] Nested images/relations on parent Create/Edit instead of child resource controllers?
- [ ] Auth-only middleware when user count is tiny and ACL is unused?

### Media & config
- [ ] Uploads on parent form submit unless mid-edit URL is required?
- [ ] Site chrome (email, calendar URL) in env/config instead of a settings table?
- [ ] Hardcode rarely changed marketing copy in the frontend?

### Public UI
- [ ] Hide empty sections entirely?
- [ ] Prefer simple ordering (`created_at` desc, `inRandomOrder`, or `sort_order`) — not all three?

## Output

1. Short list of **cuts** (what to remove)
2. **Locked simplified model** per domain (or point to domain interview docs)
3. Open questions only where a choice is still required — **one at a time** if interviewing

## Related

- Skill: [domain-planning-interview](../domain-planning-interview/SKILL.md)
- Rules: `domain-planning-interview`, `simplify-content-schemas`, `admin-resource-without-show`
