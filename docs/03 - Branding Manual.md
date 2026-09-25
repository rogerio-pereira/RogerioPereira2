# Rogerio Pereira Website — Branding Manual

**Version:** 1.0 · **Source:** planning-new-website.md v2.1 (§4). Derived from the social media `DESIGN_SYSTEM.md`, `voice-and-tone.md`, the landing-page decisions and the template itself.

---

## 1. Identity

| Item | Value |
|---|---|
| Name | Rogerio Pereira |
| Role line | Senior full-stack engineer |
| Handle (site chrome) | `@rogeriopereira.dev` |
| Domain | `https://rogeriopereira.dev` |
| Location line | Central Florida, USA |
| Languages | English and Portuguese (site is English only) |
| Proof | "15+ years" is the only number used |
| Social links (footer) | LinkedIn `https://www.linkedin.com/in/rogerio-e-pereira/` · GitHub `https://github.com/rogerio-pereira` · Instagram `https://www.instagram.com/rogeriopereira.dev/` · X `https://x.com/rpereira_dev` (`twitter:site` = `@rpereira_dev`). No email in the footer. |
| Hero promise | "Web systems that hold up in production." |

## 2. Brand essence

- **Concept: a builder's garage at night.** Raw, industrial surfaces (dark brushed steel, engineering grids, a garage pegboard) lit by a subtle neon light from the edges. The garage dominates; the neon is only an accent. The tone is a builder's log: records and notes from someone who makes things.
- **What a visitor should take away:** technically excellent, reliable, knows what he is doing, and lives with the consequences of his choices.
- **Never looks like:** a generic profile, a "tech influencer", a guru. Never tells people what to do; shows how Rogerio does it.
- **Stays out of every visual:** Matrix look (black and green), hacker/Anonymous imagery, **yellow**, cartoonish or childish illustration, liquid "bubble" glassmorphism, mascots or characters.

## 3. Voice and copy rules (for any new copy)

- Direct, senior, results-driven, no jargon-as-performance. Say the point in the first sentence.
- **Simple English:** short sentences, common words ("use", not "leverage"), one idea per sentence, no idioms.
- No pricing, rates or "affordable". No urgency. No "DM me", "Want to work together?" or any sales question. No recruiter language ("open to work", "available immediately").
- The full-time role is mentioned as a filter (few projects at a time). The fit check is firm but calm. No mention of bringing a team.
- **Cases:** never name a client, company or product. Describe the type of problem. Use a direction or size ("cut roughly in half") when an exact number is not cleared.
- **Blog:** "Notes from the week" = short retrospectives from Rogerio's weekly notes (the same Friday Intake used for social media): what happened, what he decided, what he would do differently. Never invented.
- Section labels on the site are titles only (for example `THE PROBLEM`), with no `LOG 001` numbering.
- Public copy is never invented. It comes verbatim from the landing-page template, except for the approved copy written in the FDRs. Any other new text needs Rogerio's approval in the PR.
- Privacy rule for content: cases and articles never name clients, companies or products. This is an editorial rule for Rogerio; the code does not enforce it.

## 4. Assets

| Asset | Source (template) | Target in repo |
|---|---|---|
| Space Grotesk variable (headings) | `landing-page/assets/fonts/SpaceGrotesk-Variable.woff2` | `public/fonts/SpaceGrotesk-Variable.woff2` |
| Sora variable (body) | `landing-page/assets/fonts/Sora-Variable.woff2` | `public/fonts/Sora-Variable.woff2` |
| Droid Sans Mono (labels) | `landing-page/assets/fonts/DroidSansMono.woff2` | `public/fonts/DroidSansMono.woff2` |
| Font licenses | `.claude/design/fonts/OFL-Sora.txt`, `OFL-SpaceGrotesk.txt` (Droid Sans Mono: Apache 2.0) | `public/fonts/` next to the fonts |
| Portrait | `landing-page/assets/rogerio-pereira.jpg` and `.webp` (720×720) | `public/images/rogerio-pereira.jpg` / `.webp` |
| Share image | `landing-page/assets/og-image.jpg` (1200×630) | `public/og-image.jpg` |
| Favicon | New: an "RP" monogram `favicon.svg` (Space Grotesk 700, teal `#00BEBE` on steel `#151719`), plus `favicon.ico` and `apple-touch-icon.png` generated from it | `public/favicon.svg`, `public/favicon.ico`, `public/apple-touch-icon.png` |

(`landing-page/` is `/home/rogerio/Desktop/RogerioPereira_Social Media/site/landing-page/`; `.claude/design/` is `/home/rogerio/Desktop/RogerioPereira_Social Media/.claude/design/`.)

Related: [04 - Design System](04%20-%20Design%20System.md).
