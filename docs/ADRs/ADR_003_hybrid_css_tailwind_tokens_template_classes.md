# ADR-003: Hybrid CSS: Tailwind tokens + the template's visual classes

## Status

Approved

## Context

The approved landing-page template ships a hand-written `site.css`. The project uses Tailwind 4. The look must match the template by construction, without redesigning.

## Decision

Hybrid CSS (D13):

- Design tokens live in Tailwind 4 `@theme` (`resources/css/app.css`).
- The template's **visual** rules are ported from `site.css` into one `resources/css/site.css` (`@layer components`), with the same class names and values.
- **Layout** rules (grid, flex, gap, columns and breakpoints) are written as Tailwind utilities in each Vue component, with the same values and breakpoints as the template.
- Both CSS files are created by F03, so no other feature edits CSS files.

References:
- [04 - Design System](../04%20-%20Design%20System.md)

## Consequences

- **Positive:**
    - Agents copy the template markup and class names, so the look matches by construction.
    - Tokens are available as Tailwind utilities and CSS variables.
- **Negative:**
    - Visual rules (`site.css`) and layout utilities (components) live in two places.
- **Neutral:**
    - The template's `site.css` remains the visual spec.
