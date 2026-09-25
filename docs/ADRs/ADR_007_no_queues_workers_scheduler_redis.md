# ADR-007: No queues, workers, scheduler or Redis

## Status

Approved

## Context

The site has no work that needs to run in the background. FrontPorch's Sail setup includes Redis and its guide describes queues and Horizon.

## Decision

- **No queues, jobs, workers, scheduler or Redis (D19).** `QUEUE_CONNECTION=sync`; everything runs in the request. `CACHE_STORE=database`, `SESSION_DRIVER=database` (FrontPorch). The starter kit migrations stay as they are (only the users table changes, as in FrontPorch).
- **Sail environment = FrontPorch's `compose.yaml` and `docker/` without Redis (D21)** (PHP 8.5, Octane/Swoole, pgsql, pgadmin, mailpit, minio, createbuckets). Default bucket name `rogeriopereira`. Octane listens on `--port=80` inside the container, which parallel worktrees require.
- Orphan image cleanup is immediate, not scheduled ([ADR-005](ADR_005_media_storage_compression_orphan_deletion.md)).

Deviation found in F01: Postgres uses a named volume `sail-pgsql` for its data directory (see [02 HLD](../02%20HLD.md)).

## Consequences

- **Positive:**
    - Fewer services locally and in production; no worker to keep alive.
- **Negative:**
    - Slow work (email, Slack) runs in the request.
- **Neutral:**
    - Laravel Cloud runs no worker and no scheduler.
