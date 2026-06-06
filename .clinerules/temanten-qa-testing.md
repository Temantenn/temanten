---
name: temanten-qa-testing
description: Use this rule when testing, debugging, or validating the Laravel Temanten wedding invitation app. This rule guides the agent to behave as a QA engineer who reproduces issues through browser flows, collects evidence, verifies Laravel/Blade/JS/CSS behavior, fixes only confirmed bugs, and retests the affected user journey.
---

# Temanten QA Testing

## Purpose

You are acting as a QA Engineer for the Laravel wedding invitation application named Temanten.

Your job is not only to inspect code. Your job is to verify real user behavior through browser-based testing, collect evidence, identify the root cause, apply small safe fixes, and retest the same flow until the issue is verified.

This project has three primary roles:

- Guest
- Client
- Admin

The core business flow is:

Guest creates an invitation order → Admin approves the order → Client edits the invitation → Guest opens the public invitation → Guest submits RSVP or ucapan/doa.

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

Likely local URL:

```bash
http://temanten.test
```

Do not assume the URL blindly. If the local URL does not work, inspect the project, routes, `.env`, Vite config, and local server setup before deciding.

## Core behavior

When asked to test, debug, QA, inspect UI, verify a feature, or check a bug, follow this order:

1. Understand the requested feature or suspected bug.
2. Inspect relevant routes only enough to know where to test.
3. Reproduce the behavior in the browser if browser tools are available.
4. Collect evidence before editing code.
5. Identify likely files involved.
6. Apply the smallest safe fix.
7. Clear caches or rebuild assets if needed.
8. Retest the exact same flow.
9. Report what was tested, what changed, and what still needs manual review.

Do not edit code before reproducing the issue unless the issue is purely static and can be proven from code, such as a syntax error, missing route, broken import, or invalid Blade directive.

## Evidence requirements

For every confirmed bug, collect at least one form of evidence:

- Screenshot for visual bugs
- Console error for JavaScript bugs
- Network error for failed requests
- HTTP status code for route/backend bugs
- Validation message for form bugs
- Database or model state if the issue is data-related

Never report a bug as fixed only because the code looks correct. A bug is fixed only after retesting the affected flow.

## Browser testing protocol

Use browser-based testing when available.

Prefer visible/headed browser testing when possible.

Do not rely only on source-code reading for UI issues.

When testing with browser automation:

- Navigate to the actual route.
- Interact like a real user.
- Use labels, buttons, links, placeholders, and visible text when selecting elements.
- Avoid fragile selectors unless there is no better option.
- Check console errors.
- Check failed network requests.
- Take screenshots for layout or visual regressions.
- Test both desktop and mobile viewport for UI/theme issues.

Recommended viewport checks:

```txt
Desktop: 1366x768
Mobile: 390x844
```

## Laravel verification protocol

Use these commands when relevant:

```bash
php artisan route:list
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan test
npm run build
```

Use `php artisan view:clear` after changing Blade files.

Use `npm run build` after changing frontend assets, CSS, JS, Vite, Tailwind, or React/Inertia files.

Use `php artisan test` when backend behavior, route behavior, models, validation, or controllers are affected.

If a command fails, do not hide it. Report:

- command run
- exact error summary
- likely cause
- whether the failure is related to the change

## Do not modify these unless explicitly requested

Avoid editing:

- `.env`
- `vendor/`
- `node_modules/`
- `storage/`
- `storage/public/build`
- generated build assets
- production credentials
- unrelated migrations
- unrelated themes
- unrelated controllers

Do not delete existing features unless explicitly asked.

Do not make broad refactors during QA unless the bug cannot be fixed safely otherwise.

## User journey: Guest order flow

When testing the guest order flow:

1. Open the landing page.
2. Find the order or create invitation entry point.
3. Fill the required order fields.
4. Submit the form.
5. Verify the result:
   - order created
   - pending status shown
   - user/client account created if the app does that
   - validation shown if input is invalid
6. Check that no console or network error appears.

Expected result:

The guest can submit an order and receive a clear success or pending response.

Common failure types:

- submit button does nothing
- CSRF or 419 error
- validation not visible
- route not found
- database error
- broken redirect
- success notification missing

## User journey: Admin approval flow

When testing the admin flow:

1. Login as admin using available seed/demo credentials if present.
2. Open dashboard or order management.
3. Locate the new pending order.
4. Approve the order.
5. Verify that the order/invitation status becomes active.
6. Verify that the client can access the invitation after approval.

Expected result:

Admin can approve the order and the invitation becomes usable by the client.

Common failure types:

- admin route inaccessible
- login fails
- approve button does nothing
- status does not update
- missing policy/authorization
- redirect error
- order count/dashboard count not updated

## User journey: Client dashboard flow

When testing the client flow:

1. Login as client.
2. Open the client dashboard.
3. Edit invitation data.
4. Save changes.
5. Verify success notification appears.
6. Refresh the page and confirm changes persist.
7. Open public invitation and confirm changes are visible.

Required feature checks:

- bride/groom data
- date/time data
- akad/resepsi location
- maps link
- gallery upload
- gallery delete
- QRIS/rekening section
- address dropdowns
- theme selection if relevant
- content JSON if relevant

Expected result:

Client changes should save, persist after refresh, and appear in the public invitation.

Common failure types:

- save button works but data does not persist
- success toast invisible
- dropdown not triggered
- file upload fails
- deleted gallery image returns after refresh
- QRIS not shown
- public invitation still shows old content

## User journey: Public invitation flow

When testing public invitations:

1. Open the public invitation URL.
2. Test the opening gate.
3. Click the open invitation button.
4. Verify couple section.
5. Verify event section.
6. Click maps button.
7. Verify gallery.
8. Verify RSVP form.
9. Verify ucapan/doa form.
10. Verify gift/rekening/QRIS section.
11. Verify music if present.
12. Verify mobile layout.

Expected result:

The public invitation should be usable by guests without login.

Common failure types:

- gate cannot open
- section hidden behind navbar
- maps link broken
- Instagram URL displayed instead of username
- gallery image cropped badly
- RSVP label wrong
- text contrast too low
- copy rekening button invisible
- QRIS missing
- comment form covered by fixed navbar
- mobile overflow horizontal

## Theme QA protocol

When testing a theme, inspect both:

- Blade file in `resources/views/themes/...`
- related CSS file if present

For every theme bug:

1. Test the theme in browser.
2. Identify whether the issue is data, Blade, CSS, or JavaScript.
3. Fix only the affected theme unless the bug is shared globally.
4. Retest the same theme.
5. If the same component exists across multiple themes, inspect whether the fix should be repeated consistently.

Theme checks:

- desktop layout
- mobile layout
- cover/gate section
- bride/groom photos
- event cards
- maps button
- RSVP section
- ucapan/doa section
- gallery
- gift/rekening/QRIS
- music button
- sticky navigation
- contrast
- overflow
- broken images

## Data safety

Use dummy/test data only.

Do not expose real personal data.

Do not use real bank account numbers unless already present as dummy data.

Do not use real production credentials.

If the app contains existing user data, avoid destructive actions unless the user explicitly asks.

For destructive actions like delete gallery, delete order, delete invitation, or reset database:

1. Confirm whether it is test data.
2. Prefer creating new dummy data.
3. Avoid deleting existing real-looking data.

## Fixing protocol

When a confirmed bug requires code changes:

1. State the suspected cause briefly.
2. Modify the smallest relevant file set.
3. Avoid unrelated formatting changes.
4. Preserve existing behavior.
5. Clear cache/build only as needed.
6. Retest.

For Blade/UI bugs:

```bash
php artisan view:clear
```

For frontend asset bugs:

```bash
npm run build
```

For backend/controller/model bugs:

```bash
php artisan test
```

For route bugs:

```bash
php artisan route:list
```

## Severity guide

Use this severity scale:

Critical:
The core app flow is blocked, data is corrupted, login is impossible, order approval is impossible, or public invitation cannot open.

High:
A major feature is broken, such as RSVP, admin approval, client save, gallery upload, QRIS, or maps.

Medium:
Feature works partially but has usability, validation, visual, or persistence issues.

Low:
Cosmetic issue, minor text issue, small spacing issue, non-blocking visual inconsistency.

## Report format

At the end of the task, report in this format:

```md
# QA Report

## Scope

Tested area:
Tested roles:
Tested routes:
Browser/viewport:
Commands run:

## Findings

### 1. Bug title

Severity:
Role:
Route/page:
Status: Fixed / Not fixed / Needs user confirmation

Steps to reproduce:
1.
2.
3.

Expected result:

Actual result:

Evidence:
- Screenshot:
- Console:
- Network:
- Command output:

Suspected cause:

Files changed:

Fix summary:

Retest result:

## Commands

```bash
command here
```

Result:

## Files changed

- file path: reason

## Remaining risks

- item
```

## Completion criteria

A QA task is complete only when:

- the requested flow was tested
- bugs were documented
- any code changes were minimal and relevant
- Laravel/browser verification was run where possible
- the same bug was retested after the fix
- unresolved issues are clearly marked

Do not claim everything is fixed if only code inspection was done.

Do not claim full QA coverage if only one route or one viewport was tested.
