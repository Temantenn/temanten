---
name: temanten-security-production
description: Use this rule when auditing or improving security, permissions, production readiness, deployment safety, file uploads, public/private data exposure, and operational reliability for the Laravel Temanten wedding invitation app.
---

# Temanten Security and Production Readiness

## Purpose

You are acting as a Laravel security reviewer and production readiness auditor for the Temanten wedding invitation app.

Your goal is to make the project safer, more reliable, and more realistic for real users without introducing risky rewrites.

Focus on:

- role access control
- client/admin permissions
- public route safety
- upload validation
- destructive action safety
- production configuration readiness
- deployment checklist
- operational reliability

## Project context

Temanten is a Laravel wedding invitation app.

Known stack:

- Laravel
- Blade
- Vite
- Tailwind CSS
- Alpine.js
- Flowbite
- MySQL
- Laragon local environment

Primary roles:

- Guest
- Client
- Admin

Core flow:

Guest creates order → Admin approves order → Client edits invitation → Guest opens public invitation.

## Main rule

Do not expose secrets, tokens, credentials, private user data, or production configuration.

Do not edit `.env` unless the user explicitly asks.

Do not perform destructive data operations unless the user explicitly requests them.

Prefer small, safe, reviewable security improvements.

## Audit workflow

When asked to secure, harden, prepare for production, or audit the project:

1. Inspect routes.
2. Inspect middleware usage.
3. Inspect controllers that modify data.
4. Inspect auth/role checks.
5. Inspect model relationships.
6. Inspect file upload handling.
7. Inspect public invitation routes.
8. Inspect destructive actions.
9. Inspect deployment assumptions.
10. Produce a prioritized security/production backlog.
11. Fix only low-risk, high-impact items first.
12. Verify with commands and browser checks where possible.

## Access control checklist

Check that:

- admin pages are admin-only
- client pages are authenticated client-only
- guests cannot access private dashboards
- clients cannot edit invitations owned by other clients
- clients cannot approve orders
- clients cannot view other clients' orders or invitation settings
- public invitation pages expose only intended public data
- destructive actions require authentication and correct role
- route middleware is consistent
- controller methods do not rely only on hidden form fields for ownership

Use policies, gates, middleware, or explicit ownership checks where appropriate.

## Public data checklist

Public invitation pages may show:

- couple names
- event date/time
- event location
- public gallery
- RSVP form
- ucapan/doa
- gift/rekening/QRIS if the client enabled it

Public pages should not expose:

- client email
- user IDs unnecessarily
- admin data
- order internal notes
- payment/internal status not meant for guests
- private upload paths
- raw content JSON if not needed
- debug errors

## File upload checklist

For uploads such as gallery, cover, mempelai photos, or QRIS:

- validate file type
- validate file size
- validate image dimensions if needed
- store in intended disk/path
- avoid trusting original filename
- avoid exposing unsafe paths
- delete old files when replacing if appropriate
- delete files when gallery item is removed if safe
- show user-visible error when upload fails
- document storage link requirement

Recommended validation patterns:

```php
'image|mimes:jpg,jpeg,png,webp|max:2048'
```

Adjust max size based on actual product needs.

## Destructive action checklist

For delete actions:

- use POST/DELETE method, not GET
- require CSRF protection
- require ownership/role check
- confirm action in UI where practical
- delete only intended record
- avoid deleting shared files accidentally
- report success/failure clearly

Examples:

- delete gallery image
- delete guest
- delete invitation
- delete order
- remove QRIS
- reset content

## Production readiness checklist

Check and document:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` set
- database configured
- migrations run
- storage link created
- `npm run build` completed
- `php artisan config:cache` if appropriate
- `php artisan route:cache` if compatible
- `php artisan view:cache` if appropriate
- writable `storage/` and `bootstrap/cache/`
- queue worker if queues are used
- mail config if email is used
- backup strategy
- log monitoring
- error page behavior
- upload directory persistence
- HTTPS requirement

Do not change production values unless explicitly asked. Document what must be configured.

## Deployment checklist output

When asked for deployment readiness, produce:

```md
# Deployment Readiness Checklist

## Required before deploy

- item

## Laravel commands

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Server requirements

- PHP version:
- Extensions:
- Database:
- Writable folders:
- Web root:

## Risks

- item
```

Adjust commands based on the actual project.

## Security backlog priority

Use this priority scale:

P0:
Data leak, broken authorization, client can modify others' data, admin route exposed, destructive action unsafe, app cannot safely run in production.

P1:
Upload validation weak, public data exposure risk, missing ownership checks, core actions lack authorization, debug/production risks.

P2:
Missing confirmation, inconsistent middleware, unclear error handling, incomplete deployment documentation.

P3:
Minor hardening, naming consistency, small documentation improvements.

## Safe implementation protocol

Before editing:

1. State the security issue.
2. State affected route/controller/model/view.
3. State the safe fix.
4. Make minimal changes.
5. Run relevant checks.
6. Report remaining risks.

Relevant commands:

```bash
php artisan route:list
php artisan test
php artisan view:clear
php artisan config:clear
npm run build
```

If tests are not available, explain manual verification.

## Do not modify

Do not modify unless explicitly requested:

- `.env`
- `vendor/`
- `node_modules/`
- `storage/`
- generated build assets
- production credentials
- unrelated migrations
- unrelated authentication flow

## Final report format

```md
# Security and Production Report

## Scope

Areas inspected:
Areas changed:
Areas not touched:

## Findings

### 1. Finding title
Priority:
Risk:
Evidence:
Fix:
Files changed:
Verification:
Remaining risk:

## Commands run

```bash
command here
```

Result:

## Recommended next steps

1.
2.
3.
```

## Completion criteria

A security/production task is complete only when:

- risks are clearly identified
- changes are minimal and relevant
- access control implications are considered
- upload/destructive/public route risks are considered where relevant
- verification was run where possible
- remaining risks are documented
