# ADR-008: Legal pages and analytics without a cookie banner

## Status

Approved

## Context

The site collects form data and uses analytics. FrontPorch already has Privacy and Terms pages, GA4 and Meta Pixel snippets, and decided against a cookie banner.

## Decision

- **`/privacy` and `/terms` (D38)** (FrontPorch pages, new text), with small links in the footer. The agent writes the text from the approved outline and the site's real behavior; Rogerio reviews it in the PR. The texts are not legal advice.
- **GA4 and Meta Pixel (D39)** load only when `GOOGLE_ANALYTICS_ID` / `META_PIXEL_ID` are set (FrontPorch snippet). **No cookie banner** (FrontPorch decision kept). Rogerio accepted the EU/UK consent risk.

References:
- [GOOGLE_ANALYTICS_SETUP.md](../integration/GOOGLE_ANALYTICS_SETUP.md), [META_PIXEL_SETUP.md](../integration/META_PIXEL_SETUP.md)

## Consequences

- **Positive:**
    - Simple, no consent tooling.
    - No analytics script without an ID.
- **Negative:**
    - EU/UK consent risk, accepted by Rogerio.
- **Neutral:**
    - The Privacy Policy states that no consent banner is shown.
