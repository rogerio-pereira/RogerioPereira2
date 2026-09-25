# FDR-002: Project docs and agent setup

**Feature:** 02
**Branch:** `docs/f02-project-docs` · **Wave:** 0 (orchestrator, after F01 is merged) · **Depends on:** F01 · **Status:** Done once its PR is merged (in progress)

**References:**
- Feature List: [F02 Project docs and agent setup](../../05%20-%20Feature%20List.md#f02-project-docs-and-agent-setup)
- ADRs: [ADR-001](../../ADRs/ADR_001_complete_refactor_fresh_starter_kit_frontporch_base.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md)
- FrontPorch (read-only): `.cursor/**` (incl. `mcp.json`, `.env.mcp.example`), `.gitignore`, `docs/integration/TURNSTILE_SETUP.md`, `GOOGLE_ANALYTICS_SETUP.md`, `META_PIXEL_SETUP.md`
- Template: none

---

## How it works

Everything is generated from the plan and written in English:

- `.cursor/` is FrontPorch's, with only these changes: deleted `rules/livewire-class-components.mdc` and the skills `frontend-livewire-flux`, `laravel-livewire-crud`, `frontend-vue-vuetify`; `AGENTS.md` adjusted (stack line, main rule at the top, "no queues, jobs, workers or scheduler", PR target `new-website`, quality gates); `rules/simplify-content-schemas.mdc` notes that cases and blog articles are hard-deleted with their images.
- `CLAUDE.md` is a short entry point that sends the agent to `.cursor/AGENTS.md`.
- `.gitignore` is FrontPorch's.
- Docs layout: `docs/01 PRD.md`, `02 HLD.md` (with the Deployment section), `03 - Branding Manual.md`, `04 - Design System.md`, `05 - Feature List.md`, `ADRs/ADR_001…ADR_012`, `FDRs/ToDo/FDR_003…FDR_013`, `FDRs/Done/FDR_001`, `FDR_002`, and `integration/` (Turnstile, GA4, Meta Pixel adapted from FrontPorch, plus a new `SLACK_SETUP.md`).

---

## How to test

Docs only; nothing to run. Review:

- Every file of the docs layout exists and is in English.
- Nothing contradicts the plan and nothing is added beyond it.
- Every FDR has all required sections.
- `.cursor/.env.mcp` stays untracked and ignored.

---

## Acceptance criteria

- [x] Every file of the docs layout exists, in English, consistent with the plan (no contradictions, nothing added).
- [x] Each FDR has: Feature number, References (Feature List anchor, ADRs, FrontPorch and template files), How it works, How to test, Acceptance criteria, Tasks.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Copy FrontPorch `.cursor/` and apply the changes above. | `docs(agents): port agent rules and skills from FrontPorch` |
| 2 | `CLAUDE.md`; FrontPorch `.gitignore` entries. | `docs(agents): add CLAUDE.md entry point` |
| 3 | `docs/01 PRD.md`, `docs/02 HLD.md` (one commit each). | `docs: add PRD` / `docs: add HLD` |
| 4 | `docs/03 - Branding Manual.md`, `docs/04 - Design System.md` (one commit each). | `docs: add branding manual` / `docs: add design system` |
| 5 | `docs/05 - Feature List.md` (feature index with anchors, waves). | `docs: add feature list and waves` |
| 6 | ADR_001–ADR_012, in small groups. | `docs(adr): add ADR_001–ADR_004` … |
| 7 | FDR_001–FDR_013, one or two per commit, each carrying the approved copy it needs. | `docs(fdr): add FDR_003 …` … |
| 8 | FrontPorch's three `docs/integration/*` guides, adapted, and a new short `SLACK_SETUP.md`. | `docs(integration): add Turnstile, GA4 and Meta Pixel guides` / `docs(integration): add Slack setup guide` |
