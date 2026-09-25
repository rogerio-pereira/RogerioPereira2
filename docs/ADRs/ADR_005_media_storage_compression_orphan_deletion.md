# ADR-005: Media: S3-compatible storage, FrontPorch compression, immediate orphan deletion

## Status

Approved

## Context

Case and article images (covers and Markdown images) must be stored, kept small, and not left behind when content changes. There is no queue or scheduler to clean up later (see [ADR-007](ADR_007_no_queues_workers_scheduler_redis.md)).

## Decision

- **Storage (D29):** MinIO in Sail, Laravel Cloud bucket in production, through the `s3` disk (FrontPorch). The database stores the **public URL** of each image (FrontPorch `MediaUploader`).
- **Compression (D30):** every uploaded image is compressed with FrontPorch's `ImageCompressor` as it is (JPEG quality 82, no resize). `MediaUploader::store()` calls it. Validation: FrontPorch `ImageValidationRules`.
- **Orphan files are deleted immediately, no scheduling (D31):** the old cover when it is replaced; images removed from the Markdown when a record is saved; all images of a record when it is deleted. Added to `MediaUploader` as `delete(url)` and `deleteRemovedImages(oldMarkdown, newMarkdown)`, which only touch URLs that belong to the storage disk. Uploads made in the editor and never saved are not handled (accepted).

## Consequences

- **Positive:**
    - Storage stays clean without a scheduler.
    - Deleting never fails on external or missing URLs.
- **Negative:**
    - Images uploaded in the editor and never saved stay in storage.
    - No image resizing.
- **Neutral:**
    - Images are stored as JPEG.
