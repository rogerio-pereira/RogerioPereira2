# ADR-006: Project request flow: Slack + Calendly email, no persistence, Turnstile, 1 per hour

## Status

Approved

## Context

The site's goal is to turn visitors into qualified project requests. FrontPorch already has a lead flow (event, Slack listener, scheduling-email listener, Turnstile). Rogerio does not want a CRM or stored leads.

## Decision

- **On submit (D32):** (1) Slack message; (2) email to the visitor with the Calendly booking link. Nothing is stored in the database and no email goes to Rogerio. Implemented with FrontPorch's lead flow: `ContactController` dispatches `ContactLeadSubmitted`; listeners `SendLeadSlackNotification` and `SendLeadSchedulingEmail` are registered in `EventServiceProvider`. FrontPorch's `SendLeadEmail` is not ported.
- **Failure handling (D33):** Slack = one attempt; a `try/catch` logs `Log::error` with the lead data (the only change to FrontPorch's listener). Calendly email = FrontPorch's listener as it is: 3 attempts, then `Log::error`; skipped with `Log::warning` when `CALENDAR_URL` is empty. Slack is skipped when its env values are empty.
- **Copy (D34):** only the success message and step 2 of "What happens next" change for Calendly.
- **Anti-spam (D35):** Cloudflare Turnstile (fail closed), shared props as in FrontPorch. The template's honeypot field is removed.
- **Rate limit (D36):** 1 successful submission per IP per hour. FrontPorch's `throttle` middleware counts every request, so a visitor who fails validation would be locked out for an hour. The limit is checked in `ContactController` with `RateLimiter` and only a successful send counts.
- **Form fields (D37)** follow the template: name, email, website (optional), type (multi), problem, timeline. Website uses `nullable|url|max:255` with Laravel's default message; `ContactRequest::prepareForValidation()` adds `https://` when the value is not empty and does not start with `http://` or `https://`.

References:
- [02 HLD](../02%20HLD.md), project request flow
- [TURNSTILE_SETUP.md](../integration/TURNSTILE_SETUP.md), [SLACK_SETUP.md](../integration/SLACK_SETUP.md)

## Consequences

- **Positive:**
    - No lead data at rest, no CRM to maintain.
    - Validation errors never lock a visitor out.
- **Negative:**
    - A failed Slack message is only in the log (one attempt).
    - Leads are lost if both deliveries fail, except for the log entry.
- **Neutral:**
    - The rate-limit check in `ContactController` is the only lead-flow addition to FrontPorch.
