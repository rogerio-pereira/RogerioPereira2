# Cloudflare Turnstile Setup

This document explains how to configure Cloudflare Turnstile to protect the project request form ("Start a project") against spam.

## What is Cloudflare Turnstile?

Cloudflare Turnstile is a reCAPTCHA alternative that protects forms from bots without forcing visitors to solve visual puzzles. It is free and more user-friendly than traditional captchas.

## Package

This project uses [ryangjchandler/laravel-cloudflare-turnstile](https://github.com/ryangjchandler/laravel-cloudflare-turnstile).

The package handles:

- Script loading (`<x-turnstile.scripts />` in `resources/views/app.blade.php`)
- Server-side token validation (`RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile`)
- Test fakes (`Turnstile::fake()` / `Turnstile::dummy()`)

You do **not** need to call Cloudflare’s `siteverify` URL yourself.

## You do not need to move DNS

**Important:** Turnstile works **without** pointing your DNS at Cloudflare. You can:

- Keep DNS where it already is (GoDaddy, Namecheap, Route53, etc.)
- Use Turnstile normally
- Create a free Cloudflare account only to access Turnstile

Turnstile is an independent product and does not require Cloudflare DNS management.

## How to get credentials

### 1. Open the Cloudflare dashboard

1. Go to [https://dash.cloudflare.com/](https://dash.cloudflare.com/)
2. Create a free account if you do not have one (you do not need to add a domain)
3. Sign in if you already have an account

### 2. Open Turnstile (without adding a domain)

1. Open [https://dash.cloudflare.com/?to=/:account/turnstile](https://dash.cloudflare.com/?to=/:account/turnstile)
2. Or find **Turnstile** in the sidebar (sometimes under Security)
3. Ignore any prompt to add a domain to Cloudflare DNS — you do not need that

### 3. Create a Turnstile site

1. Click **Add Site**
2. Fill in:
   - **Site name**: a descriptive label (for example, `Rogerio Pereira project request form`)
   - **Domain**: the domain where the form runs (for example `rogeriopereira.dev`, or `*.rogeriopereira.dev` for subdomains). Use the real form domain even if DNS is not on Cloudflare.
   - **Widget mode**: **Managed** (recommended) or **Non-interactive**
3. Click **Create**
4. Ignore DNS-related notices — Turnstile still works

### 4. Copy the keys

After creation you get:

- **Site Key**: public key (frontend widget)
- **Secret Key**: private key (backend validation — keep it secret)

## Laravel configuration

### 1. Package installation

```bash
./vendor/bin/sail composer require ryangjchandler/laravel-cloudflare-turnstile
```

### 2. Environment variables

Add to `.env`:

```env
TURNSTILE_SITE_KEY=your_site_key_here
TURNSTILE_SECRET_KEY=your_secret_key_here
```

**Important:**

- Never commit `.env`
- Keep the secret key private
- Prefer different keys for local and production

### 3. `config/services.php`

```php
'turnstile' => [
    'key' => env('TURNSTILE_SITE_KEY'),
    'secret' => env('TURNSTILE_SECRET_KEY'),
],
```

The package reads these keys automatically.

### 4. Frontend (Inertia + Vue)

- Scripts: Turnstile API with `?render=explicit` in `resources/views/app.blade.php` (required for Vue — implicit auto-render often runs before the form widget exists in the DOM)
- Widget on the project request form: `StartSection.vue` (widget code ported from FrontPorch `ContactSection.vue`) calls `window.turnstile.render()` on mount using the shared Inertia prop `site.turnstileSiteKey`
- In automated browser tests (`APP_ENV=testing`), the form submits a hidden `cf-turnstile-response` token while `Turnstile::fake()` handles verification

### 5. Backend validation

In `ContactRequest`:

```php
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;

'cf-turnstile-response' => ['required', new Turnstile],
```

## Test keys (local)

Cloudflare provides always-pass test keys:

- **Site Key:** `1x00000000000000000000AA`
- **Secret Key:** `1x0000000000000000000000000000000AA`

Use them for local smoke checks without registering `localhost`.

In Pest Feature tests, prefer:

```php
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Turnstile::fake();
});

// successful submit
'cf-turnstile-response' => Turnstile::dummy(),

// force failure
Turnstile::fake()->fail();
```

## Verification checklist

1. Set `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY` in `.env`
2. Open the home page "Start a project" section (`/#start`)
3. Confirm the Turnstile widget appears above the submit button
4. Submit the form — the token is validated by the `Turnstile` rule
5. On failure, the form shows a validation error for `cf-turnstile-response`

## Troubleshooting

### Cloudflare asks you to move DNS

Ignore it. Open Turnstile directly, create the site, and use the keys — DNS can stay elsewhere.

### Widget does not appear

- Confirm `TURNSTILE_SITE_KEY` is set
- Confirm `<x-turnstile.scripts />` is in `app.blade.php`
- Check the browser console for script errors
- Confirm the current domain is listed on the Turnstile site

### Validation always fails

- Confirm `TURNSTILE_SECRET_KEY` is correct
- Check Laravel logs
- Confirm the browser domain is allowed on the Turnstile site
- The domain must be registered in Turnstile; DNS can remain with any provider

### Error “Invalid site key”

- Confirm the site key value
- Confirm the current hostname is registered
- For local development, use Cloudflare’s test keys

## Resources

- [Official Turnstile docs](https://developers.cloudflare.com/turnstile/)
- [Turnstile dashboard](https://dash.cloudflare.com/?to=/:account/turnstile)
- [Server-side integration guide](https://developers.cloudflare.com/turnstile/get-started/server-side-rendering/)
- [Package README](https://github.com/ryangjchandler/laravel-cloudflare-turnstile)
