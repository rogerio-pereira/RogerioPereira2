# CLAUDE.md

Read `.cursor/AGENTS.md` first.

**NEVER EVER BREAK:** For the entire project, make it a primary rule to follow Clean Code, KISS, and YAGNI principles—meaning every implementation should take the simplest and fastest path to achieve the goal; abstractions, layers, etc, that add complexity without real benefit should be replaced by the simplest (yet safe) way to achieve the result.

FrontPorch is the base model. Docs are in `docs/`.

Original plan: `/home/rogerio/Desktop/RogerioPereira_Social Media/site/planning-new-website.md`

## Mandatory rules

- The FrontPorch repo (`/home/rogerio/www/FrontPorch`) is **read-only**. Never change anything there.
- All new code goes only in `/home/rogerio/www/RogerioPereira`.
- Small, incremental commits (Conventional Commits).
- Do not assume. Ask.
- Never read or change `.env` (it holds production credentials).
- The design system and tone live in `/home/rogerio/Desktop/RogerioPereira_Social Media`.
- The approved frontend template is at `/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page`.
- Keep the plan in `docs/` up to date with the project status.
