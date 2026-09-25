---
name: domain-planning-interview
description: >-
  Runs a domain-by-domain planning interview (one question at a time), writes
  per-domain decision docs, and syncs contradictions in parent plans. Use when
  simplifying an overengineered plan, locking schemas before build, or when the
  user asks to interview by domain / break down a backend plan.
---

# Domain planning interview

## When to use

- User says a plan is overengineered and wants to simplify
- Locking DB/admin decisions before implementation
- Breaking a large backend/CMS plan into domains

## Workflow

1. **List domains** (content types, media, shared/auth/config). Agree order.
2. **Create** `docs/planning/<plan-slug>/` (or project equivalent) with:
   - `README.md` — domain index + interview status
   - One markdown file per domain
3. **Per domain file** (English; chat may be another language):

```markdown
# Domain: <Name>

**Status:** Interview in progress | Complete

## Decisions (locked)
| # | Decision | Date | Notes |

## Locked model
(columns / relations — update as answers arrive)

## Rejected / out of scope

## Interview queue
| Q# | Topic | Status |

## Interview log
### <date> — Qn (user)
- Answer summary
**Applied:** Dn
### Next question (Qn+1)
**Question:** …
```

4. **Ask one question at a time.** Prefer questions that cut complexity first (scope, formats, publish model), then fields, then admin surface, then IDs.
5. After each answer: update Decisions + log + locked model; **fix any contradictory** parent plan / product docs.
6. Mark domain Complete; start the next domain’s Q1.
7. When all domains are done, set parent plan status to ready-to-implement and point to domain docs as source of truth.

## Question design heuristics

- What is editable in CMS vs hardcoded in the UI?
- Taxonomy table vs free-text label?
- Draft/publish flags vs presence + SoftDeletes?
- Dual content formats vs one?
- Derived fields (slug) via Observer + controller comment?
- Full resource with Show vs Index/Create/Edit only (`show` → 404)?
- Nested children on parent form vs separate admin resource?
- Uploads: parent submit vs dedicated endpoint?
- Empty sections: hide entire block?

## Do not

- Implement code during the interview unless asked
- Bundle multiple unrelated questions in one turn
- Leave obsolete plan text that contradicts locked decisions
