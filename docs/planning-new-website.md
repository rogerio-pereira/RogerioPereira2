# New website — planning (2026-09-24, v2.1)

Full plan: `/home/rogerio/Desktop/RogerioPereira_Social Media/site/planning-new-website.md` (single file, English). Executed later by a separate Claude Code session; the Cowork session only plans and never implements.

## Ground rules
- Clean Code + KISS + YAGNI above everything.
- **FrontPorch (`805d19c`) is the base model; nothing beyond what it has.** New pieces are allowed only if the template or Rogerio's decisions require them; the complete list is §9.3 of the plan.
- Quality = exactly FrontPorch's tools: Pest (Feature + Browser, coverage ≥ 90%), Pest type coverage ≥ 90%, Pint, ESLint. No Larastan, no Prettier/vue-tsc gates, no screenshot checks.
- Don't assume; ask Rogerio. PRs via the GitHub MCP (never `gh`); Rogerio merges every PR.

## Key decisions
- Complete refactor of `/home/rogerio/www/RogerioPereira` (remote RogerioPereira2). Step 0: backup branch `bkp_20260924_old-website` from current HEAD (`remove-stripe-logs` @ 2a200ba). No redirects.
- Integration branch `new-website`; feature PRs into it; final PR to `main`. One wave per Claude Code session, max 3 agents in parallel (worktrees with their own ports).
- Fresh Laravel 13 Vue starter kit + FrontPorch pieces ported. FrontPorch Sail setup (PHP 8.5, Octane, pgsql, pgadmin, mailpit, minio) without Redis. Inertia + Vue, client-side rendering, no SSR; SEO meta printed server-side in `app.blade.php`. No JSON-LD.
- CSS: Tailwind 4 `@theme` tokens + one `site.css` with the template's visual rules; layout via utilities.
- DB (UUIDs, FrontPorch): cases (`case_studies`, JSON `stack`/`metrics`, simple admin inputs converted to JSON), blog articles, FAQs (soft deletes), users. Markdown + textarea (`Str::markdown` safe mode). No drafts. No AI. Slugs follow the title (FrontPorch observers).
- Media: FrontPorch `MediaUploader` + `ImageCompressor` (JPEG 82, no resize); orphan files deleted immediately; cases/articles hard-deleted.
- Form: FrontPorch lead flow (event + Slack listener + scheduling-email listener with `CALENDAR_URL`). No DB, no email to Rogerio. Turnstile, honeypot removed, 1 successful send per IP per hour. Website: placeholder `https://yourcompany.com`; `https://` added when missing, then Laravel's `url` rule with the default message.
- Privacy + Terms, GA4 + Meta Pixel (env-gated), no cookie banner. Sitemap, robots, llms.txt.
- /core = FrontPorch admin (CRUD cases, blog, FAQs, users; admin forced dark; Dashboard and Appearance kept). UserSeeder copied from FrontPorch.
- No queues/jobs/workers/scheduler/Redis. Hosting: Laravel Cloud.
- Docs: FrontPorch `.cursor/` copied (minus Livewire/Flux/Vuetify) + `CLAUDE.md`; docs 01–05 + 12 ADRs + FDRs; FrontPorch's 3 integration guides + new `SLACK_SETUP.md`.

## How to start
Keep the plan outside the repo. `cd ~/www/RogerioPereira && claude --add-dir "/home/rogerio/Desktop/RogerioPereira_Social Media" --add-dir ~/www`, then ask for Wave 0 only (Step 0, F01, F02).

## Copy
All Appendix A copy approved on 2026-09-24. Only the final Privacy and Terms texts (F11) still need Rogerio's review in that PR.