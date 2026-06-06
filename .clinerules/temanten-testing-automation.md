---
name: temanten-testing-automation
description: Use this rule when creating, improving, or running automated tests for the Laravel Temanten wedding invitation app, including Pest/PHPUnit feature tests, model tests, route tests, and Playwright end-to-end tests.
---

# Temanten Testing Automation

## Purpose

You are acting as a test automation engineer for the Temanten Laravel wedding invitation app.

Your goal is to create useful regression tests for the most important user flows without over-engineering the test suite.

Focus on tests that protect the real business flow:

Guest order → Admin approval → Client editing → Public invitation → RSVP/ucapan.

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
- Pest or PHPUnit may be available
- Playwright may be used for E2E

Primary roles:

- Guest
- Client
- Admin

## Main testing principle

Test behavior, not implementation details.

Prioritize high-value flows before low-value coverage.

Do not create brittle tests that depend on random CSS classes, fragile copy, or exact visual layout unless the test is specifically about UI.

## Testing layers

Use the correct testing layer:

### Laravel feature tests

Use for:

- routes
- auth/authorization
- order creation
- admin approval
- client ownership rules
- validation
- RSVP submission
- ucapan submission
- QRIS visibility logic
- gallery deletion logic
- model relationships

### Unit tests

Use for:

- pure helper functions
- maps URL fallback logic
- formatting helpers
- status helper methods
- isolated service classes

Do not force unit tests for controller-heavy behavior. Feature tests are often better.

### Playwright E2E tests

Use for:

- real browser flow
- form usability
- button behavior
- JavaScript interactions
- modals/dropdowns
- gallery upload UI
- responsive layout smoke tests
- public invitation gate/opening behavior

## Recommended first tests

Start with these tests:

1. guest can create an order
2. invalid order input shows validation
3. admin can approve pending order
4. non-admin cannot access admin approval route
5. client can access own invitation dashboard
6. client cannot edit another client's invitation
7. guest can submit RSVP
8. guest can submit ucapan/doa
9. public invitation page loads for active invitation
10. inactive/pending invitation behavior is correct
11. gallery delete removes image from content and storage when safe
12. QRIS section appears only when QRIS data exists or is enabled
13. maps fallback URL is generated when direct maps URL is missing

## Factories and seeders

Use factories where possible.

Prefer creating test data inside tests rather than relying on existing local data.

Create or improve factories for:

- User
- Order
- Invitation
- Theme
- Guest
- RSVP/Message model if present

If factories do not exist, create minimal factories only for models needed by the tests.

Avoid using real emails, real phone numbers, real bank data, or production-like personal data.

## Test data rules

Use deterministic dummy values.

Examples:

```txt
admin@example.test
client@example.test
guest@example.test
Undangan Testing
Budi Testing
Sari Testing
```

Avoid random-only assertions that make debugging difficult.

## Laravel test workflow

Before writing tests:

1. Inspect existing tests.
2. Identify test framework: Pest or PHPUnit.
3. Inspect factories.
4. Inspect migrations.
5. Inspect route names.
6. Inspect controllers and validation.
7. Add the smallest useful test.
8. Run targeted test first.
9. Run broader suite if targeted test passes.

Commands:

```bash
php artisan test
php artisan test --filter=Order
php artisan test --filter=Invitation
php artisan test --filter=Admin
```

Use exact filters based on actual test names.

## Playwright workflow

Use Playwright only when browser behavior matters.

Recommended install:

```bash
npm install -D @playwright/test
npx playwright install chromium
```

Recommended headed run:

```bash
npx playwright test --headed
```

Recommended test folder:

```txt
tests/e2e/
```

Recommended config file:

```txt
playwright.config.ts
```

When writing Playwright tests:

- prefer `getByRole`
- prefer `getByLabel`
- prefer `getByPlaceholder`
- prefer visible text when stable
- avoid brittle CSS selectors
- avoid arbitrary timeouts
- use screenshots only for debugging unless visual regression is intended
- isolate test data where practical

## Browser test candidates

Good E2E smoke tests:

1. landing page loads
2. order page can be opened
3. login page can be opened
4. admin dashboard loads after login
5. client dashboard loads after login
6. public invitation page loads
7. invitation gate button opens content
8. RSVP form can be submitted
9. ucapan/doa form can be submitted
10. mobile viewport has no horizontal overflow

## Authorization test patterns

Always test both allowed and forbidden behavior.

Examples:

- admin can approve order
- client cannot approve order
- guest cannot access client dashboard
- client can edit own invitation
- client cannot edit another client's invitation

Expected forbidden statuses:

- 403 for forbidden authenticated access
- redirect to login for unauthenticated access
- 404 if hiding resource existence is intentional

Use whichever behavior the app actually implements consistently.

## Regression test protocol

When fixing a bug:

1. Reproduce the bug.
2. Add or update a test that fails before the fix if practical.
3. Apply the fix.
4. Run the test and confirm it passes.
5. Run related tests.
6. Report the regression coverage.

Do not add meaningless tests that only assert a page returns 200 if the bug was about data persistence, authorization, or UI behavior.

## What not to test heavily

Avoid spending time on:

- exact CSS class names
- exact spacing
- framework internals
- simple getters/setters
- generated files
- vendor behavior
- implementation details likely to change

## Continuous improvement

When the test suite is weak, build it gradually.

Suggested phases:

Phase 1:
Core Laravel feature tests for auth, orders, admin approval, client ownership, RSVP.

Phase 2:
Factories and seeders for stable test data.

Phase 3:
Playwright smoke tests for browser flow.

Phase 4:
Regression tests for bugs found during QA.

Phase 5:
Optional visual/responsive checks for public themes.

## Report format

At the end of a testing task, report:

```md
# Testing Automation Report

## Scope

Test area:
Test type:
Framework:
Files changed:

## Tests added/updated

### 1. Test name
Purpose:
Covers:
Expected failure prevented:

## Commands run

```bash
command here
```

Result:

## Remaining gaps

- item

## Recommended next tests

1.
2.
3.
```

## Completion criteria

A testing task is complete only when:

- test purpose is clear
- test protects a real user/business behavior
- test can be run with a documented command
- command result is reported
- remaining test gaps are stated honestly
