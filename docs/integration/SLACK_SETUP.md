# Slack Setup

This document explains how to create a Slack app and wire it into the Rogerio Pereira website, so every valid project request posts a "New project request" message to a Slack channel.

## What Slack does here

When a visitor sends the "Start a project" form, the site posts one message to a Slack channel (message format in [FDR-010](../FDRs/ToDo/FDR_010_project_request_form.md)). It is **optional**: the notification is skipped when `SLACK_BOT_USER_OAUTH_TOKEN` or `SLACK_BOT_USER_DEFAULT_CHANNEL` is empty. Nothing else is stored: the Slack message is the only copy of the request (see [ADR-006](../ADRs/ADR_006_project_request_flow.md)).

There is one attempt per request. If Slack fails, the error is logged with the lead data (`Log::error`) and the visitor still sees the success panel.

## Package

This project uses [laravel/slack-notification-channel](https://github.com/laravel/slack-notification-channel) (added in F10).

The package handles:

- Sending the message with the bot token (`Notification::route('slack', $channel)`)
- The `SlackMessage` builder used by `App\Notifications\SlackNotification`

## How to get credentials

### 1. Create a Slack app

1. Go to [https://api.slack.com/apps](https://api.slack.com/apps)
2. Click **Create New App** → **From scratch**
3. Fill in:
   - **App name**: a descriptive label (for example, `Rogerio Pereira website`)
   - **Workspace**: the (private) workspace that should receive the requests
4. Click **Create App**

### 2. Add the bot token scopes

1. Open **OAuth & Permissions**
2. Under **Scopes** → **Bot Token Scopes**, add:
   - `chat:write` (post messages)
   - `chat:write.public` (optional: post to public channels without inviting the bot)

### 3. Install the app and copy the token

1. In **OAuth & Permissions**, click **Install to Workspace** and allow it
2. Copy the **Bot User OAuth Token**. It starts with `xoxb-`

That value is what you put in `.env` as `SLACK_BOT_USER_OAUTH_TOKEN`.

### 4. Choose the channel

1. Create or pick the channel that should receive the requests (for example, `#project-requests`)
2. For a private channel (or a public one if you did not add `chat:write.public`), invite the bot: in the channel, run `/invite @<app name>`
3. Use the channel name (for example `#project-requests`) or the channel ID (in Slack: channel details → bottom of the **About** tab, for example `C0123456789`) as `SLACK_BOT_USER_DEFAULT_CHANNEL`

## Laravel configuration

### 1. Environment variables

Add to `.env`:

```env
SLACK_BOT_USER_OAUTH_TOKEN=xoxb-your-token-here
SLACK_BOT_USER_DEFAULT_CHANNEL=#project-requests
```

**Important:**

- Never commit `.env`
- Keep the token private
- Leave both empty locally if you do not want Slack messages in development
- After changing env values, clear cached config if needed: `./vendor/bin/sail artisan config:clear`

### 2. `config/services.php`

```php
'slack' => [
    'notifications' => [
        'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
        'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
    ],
],
```

## Verification checklist

1. Set `SLACK_BOT_USER_OAUTH_TOKEN` and `SLACK_BOT_USER_DEFAULT_CHANNEL` in `.env`
2. Send the "Start a project" form on the home page (`/#start`)
3. Confirm the "New project request" message arrives in the channel

## Troubleshooting

### No message arrives

- Confirm both env values are set (an empty value skips the notification) and clear the config cache
- Check the Laravel log for a `Log::error` entry with the lead data
- Confirm the app is installed in the workspace

### `not_in_channel` or `channel_not_found`

- Invite the bot to the channel, or add the `chat:write.public` scope (public channels only)
- Use the channel ID instead of the name

### `invalid_auth` or `token_revoked`

- Confirm you copied the **Bot User OAuth Token** (`xoxb-…`), not another token
- Reinstall the app and copy the new token

## Resources

- [Slack API: creating an app](https://api.slack.com/quickstart)
- [Slack API: `chat.postMessage`](https://api.slack.com/methods/chat.postMessage)
- [Laravel Slack notifications](https://laravel.com/docs/notifications#slack-notifications)
- Related: [Cloudflare Turnstile Setup](./TURNSTILE_SETUP.md)
