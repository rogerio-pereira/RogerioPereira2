# FDR-013: Launch readiness

**Feature:** 13
**Branch:** `chore/f13-launch` · **Wave:** 5 · **Runs:** orchestrator · **Depends on:** everything

**References:**
- Feature List: [F13 Launch readiness](../../05%20-%20Feature%20List.md#f13-launch-readiness)
- ADRs: [ADR-009](../../ADRs/ADR_009_hosting_laravel_cloud.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md)
- Docs: [02 HLD](../../02%20HLD.md) (Deployment section = the launch checklist)
- FrontPorch: none
- Template: none

---

## How it works

- Docs are synced with the delivered site: the Feature List shows every wave as Done, and the HLD records any deviation found during the build. The Deployment section of the HLD is the launch checklist.
- Full gates are run. The launch PR `new-website` → `main` is opened (GitHub MCP) with the launch checklist (HLD, Deployment section) in its description. Rogerio merges and deploys. No queue worker and no scheduler are configured.

---

## How to test

- Run the full gates: `sail npm run build`, `sail artisan test --parallel --coverage --min=90`, `sail artisan test --type-coverage --min=90 --parallel`, `sail exec laravel.test vendor/bin/pint --parallel`, `sail npm run lint:check`.
- Check that CI is green on the launch PR and that every FDR is in `Done/`.
- After deploy, follow the "After deploy" list of the HLD Deployment section.

---

## Acceptance criteria

- [ ] Every FDR is in `Done/`; gates green; the launch PR is open with the checklist.

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Sync docs: Feature List (all waves Done), HLD (Deployment section; any deviation found during the build). | `docs: sync docs with the delivered site` |
| 2 | Full gates. Open the PR `new-website` → `main` (GitHub MCP) with the launch checklist in the description. Rogerio merges and deploys. | — |
