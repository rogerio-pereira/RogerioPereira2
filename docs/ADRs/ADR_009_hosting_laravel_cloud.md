# ADR-009: Hosting on Laravel Cloud

## Status

Approved

## Context

FrontPorch already runs on Laravel Cloud with PHP 8.5. The site needs PostgreSQL, an object storage bucket and mail, and no background processing.

## Decision

- **Hosting: Laravel Cloud (D20)** with PostgreSQL, an object storage bucket, and mail via env. No worker and no scheduler. PHP 8.5 is supported.
- **Production mail via env (D48)**: SES, as in FrontPorch. `MAIL_FROM_ADDRESS` must be a mailbox Rogerio reads, because visitors may reply to the Calendly email.
- The launch checklist is the Deployment section of [02 HLD](../02%20HLD.md).

## Consequences

- **Positive:**
    - Same hosting setup as FrontPorch.
- **Negative:**
    - Depends on Laravel Cloud and on Rogerio's accounts for setup.
- **Neutral:**
    - Deploys run `php artisan migrate --force`; the first deploy also seeds the real data once.
