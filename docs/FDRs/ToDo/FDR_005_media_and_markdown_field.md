# FDR-005: Media and Markdown field

**Feature:** 05
**Branch:** `feat/f05-media-markdown` · **Wave:** 2 · **Depends on:** [F03 Public design system and layout](../../05%20-%20Feature%20List.md#f03-public-design-system-and-layout), [F04 Admin shell, auth and users](../../05%20-%20Feature%20List.md#f04-admin-shell-auth-and-users)

**References:**
- Feature List: [F05 Media and Markdown field](../../05%20-%20Feature%20List.md#f05-media-and-markdown-field)
- ADRs: [ADR-005](../../ADRs/ADR_005_media_storage_compression_orphan_deletion.md), [ADR-004](../../ADRs/ADR_004_content_model_markdown_uuids.md), [ADR-011](../../ADRs/ADR_011_delivery_workflow.md) (shared files, definition of done)
- FrontPorch (read-only): `app/Services/ImageCompressor.php`, `app/Services/MediaUploader.php`, `app/Http/Controllers/Core/MediaUploadController.php`, `Requests/Core/MediaUploadRequest.php`, `app/Concerns/ImageValidationRules.php`, `resources/js/lib/xsrf.ts`, `GenerateImageTool` (how it stores images), and its compressor, uploader and endpoint tests
- Template: none

**Owns:** `app/Services/ImageCompressor.php`, `app/Services/MediaUploader.php`, `Core/MediaUploadController`, `Core/MediaUploadRequest`, `app/Concerns/ImageValidationRules.php`, `resources/js/components/core/MarkdownField.vue`.

---

## How it works

- `ImageCompressor` is ported as it is (JPEG quality 82, no resize).
- `MediaUploader::store()` passes the file through `ImageCompressor::forWeb()`, saves it as `{uuid}.jpg` (the way FrontPorch's `GenerateImageTool` stores images) and returns the public URL.
- `MediaUploader::delete(string $url)` deletes the file only when the URL starts with `Storage::url('')`; it ignores anything else or a missing file.
- `MediaUploader::deleteRemovedImages(string $oldMarkdown, string $newMarkdown)` deletes image URLs present in the old Markdown and missing in the new one.
- `POST /core/media` (`MediaUploadController`, `MediaUploadRequest`, `ImageValidationRules`) uploads one image and returns `{ url }`.
- `MarkdownField.vue` is a labeled textarea bound with `v-model` with an error slot and an "Insert image" button: file picker, upload to `/core/media` (FrontPorch `xsrf.ts`), insert `![](url)` at the cursor. Rogerio writes the alt text inside the brackets.

---

## How to test

- Tests with `Storage::fake()`: port FrontPorch's compressor, uploader and endpoint tests.
- Add tests for `delete` and `deleteRemovedImages`: own URLs are deleted, external URLs are ignored, missing files do not fail.
- Browser coverage of the Markdown field comes with F08 and F09.

---

## Acceptance criteria

- [ ] Every upload is stored as a compressed JPEG (FrontPorch `ImageCompressor`, quality 82) and returns a public URL.
- [ ] Deleting never fails on external or missing URLs, and never touches files outside the disk.
- [ ] The Markdown field inserts a working image URL at the cursor (Browser coverage comes with F08/F09).

---

## Tasks

| # | Task | Commit |
|---|---|---|
| 1 | Port `ImageCompressor` (as it is) and `MediaUploader`; `store()` passes the file through `ImageCompressor::forWeb()` and saves it as `{uuid}.jpg`, then returns the public URL. | `feat(core): compress and store uploaded images` |
| 2 | Add `MediaUploader::delete(string $url)` and `MediaUploader::deleteRemovedImages(string $oldMarkdown, string $newMarkdown)`. | `feat(core): delete replaced and removed images` |
| 3 | Port `POST /core/media` (`MediaUploadController`, `MediaUploadRequest`, `ImageValidationRules`). | `feat(core): add image upload endpoint` |
| 4 | `MarkdownField.vue`: labeled textarea bound with `v-model`, error slot, "Insert image" button → file picker → upload to `/core/media` → inserts `![](url)` at the cursor. | `feat(core): add Markdown field with image upload` |
| 5 | Tests with `Storage::fake()`: port FrontPorch's compressor, uploader and endpoint tests; add tests for `delete` and `deleteRemovedImages`. | `test(core): cover media deletion` |
