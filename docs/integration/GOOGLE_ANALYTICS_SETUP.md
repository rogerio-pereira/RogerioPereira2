# Google Analytics 4 Setup

This document explains how to create a Google Analytics 4 (GA4) property and wire the Measurement ID into the Rogerio Pereira website.

## What Google Analytics 4 does

GA4 measures site traffic, page views, and audience insights. It is **optional**. The GA4 script loads only when `GOOGLE_ANALYTICS_ID` is set. An empty value means no GA4 tags are injected.

Meta Pixel is configured separately — see [Meta Pixel Setup](./META_PIXEL_SETUP.md).

## Cookie consent

This project does **not** show a cookie consent banner before loading analytics. That is intentional — see [ADR-008](../ADRs/ADR_008_legal_pages_analytics_no_cookie_banner.md). Rogerio accepted the EU/UK consent risk.

The Privacy Policy discloses analytics cookies and states that no consent banner is shown.

## How the app loads GA4

When `GOOGLE_ANALYTICS_ID` is set, `resources/views/app.blade.php` injects `gtag.js` and `gtag('config', …)`.

Config mapping:

```php
// config/site.php
'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', null),
```

You only need to set the env var. No package install is required.

---

## How to get a Measurement ID

### 1. Create or open a Google Analytics account

1. Go to [https://analytics.google.com/](https://analytics.google.com/)
2. Sign in with the Google account that should own the property
3. If you have no account yet, follow **Start measuring** and create one

### 2. Create a GA4 property

1. Open **Admin** (gear icon)
2. Under **Property**, create a new GA4 property (for example, `Rogerio Pereira`)
3. Set the time zone and currency appropriate for the business (Florida, USA)

### 3. Create a Web data stream

1. In the property, open **Data streams** → **Add stream** → **Web**
2. Enter:
   - **Website URL**: `https://rogeriopereira.dev` (or the real production URL)
   - **Stream name**: a clear label (for example, `Production web`)
3. Create the stream

### 4. Copy the Measurement ID

On the stream details page, copy the **Measurement ID**. It looks like:

```text
G-XXXXXXXXXX
```

That value is what you put in `.env` as `GOOGLE_ANALYTICS_ID`.

### 5. (Optional) Local / staging streams

Prefer a **separate** GA4 property or data stream for staging so test traffic does not pollute production reports. Use a different Measurement ID in non-production `.env` files.

---

## Laravel configuration

### 1. Environment variable

Add to `.env` (production first; leave empty locally if you do not want GA4 in development):

```env
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

**Important:**

- Never commit `.env`
- Prefer different IDs for production and staging
- After changing env values, clear cached config if needed: `./vendor/bin/sail artisan config:clear`

### 2. Confirm `config/site.php`

This key should already exist:

```php
'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', null),
```

### 3. Confirm Blade injection

`resources/views/app.blade.php` reads `config('site.google_analytics_id')` and outputs the GA4 snippet when the value is non-empty.

No frontend rebuild is required for env-only changes.

---

## Verification checklist

1. Set `GOOGLE_ANALYTICS_ID` in `.env` and clear config cache if needed
2. Open the home page (or any public Inertia page) in a browser
3. View page source (or DevTools → Network / Elements) and confirm `googletagmanager.com/gtag/js` and your `G-…` ID
4. In GA4: **Reports** → **Realtime** — open the site and confirm a live user

Automated coverage:

- Feature and Browser tests for the analytics scripts (added in F11, adapted from FrontPorch).

---

## Troubleshooting

### Script does not appear in the HTML

- Confirm `GOOGLE_ANALYTICS_ID` is set (not an empty string in a cached config)
- Run `./vendor/bin/sail artisan config:clear`
- Confirm you are looking at a full page load of an Inertia response (script lives in `app.blade.php` `<head>`)

### Realtime shows nothing

- Confirm the Measurement ID matches the stream for this domain
- Disable ad blockers / privacy extensions for the test
- Wait a minute and refresh Realtime
- Confirm the browser is not blocking `googletagmanager.com`

### Wrong property receiving data

- You likely reused a staging ID in production (or the reverse)
- Create separate streams and keep env files distinct

---

## Resources

- [Google Analytics 4 help](https://support.google.com/analytics/answer/9304153)
- [Set up a GA4 web data stream](https://support.google.com/analytics/answer/9304153#web)
- Project decision: [ADR-008 Legal pages and analytics without a cookie banner](../ADRs/ADR_008_legal_pages_analytics_no_cookie_banner.md)
- Related: [Meta Pixel Setup](./META_PIXEL_SETUP.md)
- Related: [Cloudflare Turnstile Setup](./TURNSTILE_SETUP.md)
