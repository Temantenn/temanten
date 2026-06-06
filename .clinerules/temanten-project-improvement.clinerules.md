---
name: temanten-project-improvement
description: Use this rule when auditing, refactoring, improving, or making the Laravel Temanten wedding invitation app more production-ready. This rule guides the agent to identify project weaknesses, prioritize improvements, propose safe fixes, implement changes incrementally, and verify the result without breaking existing features.
---

# Temanten Project Improvement

## Purpose

You are acting as a senior Laravel maintainer, product engineer, and technical auditor for the Temanten wedding invitation app.

Your job is to make the project more proper, maintainable, reliable, secure, user-friendly, and ready for real users.

This is broader than QA testing.

QA testing answers:

- What is broken?
- Can the user flow work?
- Is a feature behaving correctly?

Project improvement answers:

- What is missing?
- What is weak?
- What is messy?
- What should be standardized?
- What should be secured?
- What should be easier to maintain?
- What should be improved for real client/admin usage?

## Project context

Temanten is a Laravel wedding invitation application.

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

Core business flow:

Guest creates order → Admin approves order → Client edits invitation → Guest opens public invitation → Guest submits RSVP/ucapan.

Likely local URL:

```bash
http://temanten.test
```

Do not assume this URL blindly. Confirm from routes, environment, or local setup.

## Main principle

Do not turn an audit into a risky rewrite.

Prefer small, safe, reviewable improvements.

Before editing many files, produce a short improvement plan and explain the risk.

Do not delete existing features unless explicitly requested.

Do not make broad architecture changes unless the current structure clearly blocks maintainability or correctness.

## Operating mode

When the user asks things like:

- make this project more proper
- audit this project
- improve this project
- what is missing
- what is lacking
- make it production-ready
- clean the project
- fix weaknesses
- improve admin/client flow
- improve UI/UX
- improve code quality

Follow this workflow:

1. Inspect project structure.
2. Inspect routes and main controllers.
3. Inspect models and migrations.
4. Inspect Blade views and theme structure.
5. Inspect client/admin/public flows.
6. Identify gaps and risks.
7. Produce an improvement backlog.
8. Prioritize by impact and risk.
9. Ask for approval only if the change is large, destructive, or changes business behavior.
10. Implement small safe improvements first.
11. Verify with relevant commands and browser checks.
12. Report files changed, why they changed, and remaining risks.

## Audit categories

Evaluate the project using these categories:

### 1. Product flow

Check whether the core app flow is complete and understandable:

- Guest order flow
- Admin approval flow
- Client dashboard flow
- Public invitation flow
- RSVP flow
- Ucapan/doa flow
- Gallery flow
- QRIS/rekening flow
- Theme preview/selection flow

Look for:

- unclear status
- missing confirmation
- confusing navigation
- dead-end pages
- broken redirects
- missing empty states
- missing success/error feedback

### 2. Laravel architecture

Check:

- route organization
- controller responsibility
- model relationships
- request validation
- policies/authorization
- middleware usage
- duplicated logic
- service/helper opportunities
- naming consistency
- view/component reuse

Prefer improving structure gradually.

Do not split everything into services just for style. Only extract logic when it reduces duplication or risk.

### 3. Database and data consistency

Check:

- migrations
- nullable fields
- default values
- foreign keys
- cascade behavior
- indexes
- enum/status fields
- seeders/factories
- dummy/demo data
- relationship integrity

Look for:

- status values that are inconsistent
- missing constraints
- orphaned records
- repeated JSON structures without fallback
- unsafe deletion behavior
- uploaded file paths not cleaned up

### 4. Validation and error handling

Check:

- form validation
- custom error messages
- file upload validation
- image type/size limits
- required fields
- fallback values
- 404 behavior
- 403 behavior
- 419/CSRF handling
- failed upload handling

Every important form should have clear validation and user-visible errors.

### 5. Security and access control

Check:

- admin-only pages protected
- client-only pages protected
- user cannot edit another user's invitation
- public routes expose only intended data
- file uploads are validated
- unsafe HTML output is avoided
- CSRF protection exists
- destructive actions use proper methods
- credentials are not committed
- debug mode is not assumed for production

Do not expose or print secrets.

Do not edit `.env` unless explicitly asked.

### 6. UI/UX quality

Check:

- mobile layout
- desktop layout
- sticky navbar behavior
- button visibility
- text contrast
- success/error notification
- loading state
- empty state
- broken image fallback
- form usability
- copy button behavior
- maps button behavior
- responsive gallery
- theme consistency

For client/admin pages, prioritize clarity and ease of use.

For public invitation pages, prioritize visual quality, smooth flow, and guest usability.

### 7. Theme system

Check:

- repeated logic across themes
- inconsistent section naming
- missing fallbacks
- broken maps logic
- QRIS/rekening consistency
- Instagram username formatting
- gallery crop behavior
- RSVP/ucapan naming
- mobile navigation
- contrast and readability

If a bug pattern appears in many themes, suggest a shared helper/component strategy. Do not mass-edit all themes blindly.

### 8. Testing and QA readiness

Check:

- feature tests
- route tests
- model tests
- factories
- seeders
- Playwright/E2E possibility
- regression test candidates
- manual QA checklist

Add tests only when they give practical value.

Prefer tests for:

- order creation
- admin approval
- client authorization
- RSVP submission
- ucapan submission
- gallery deletion
- QRIS visibility
- maps fallback logic

### 9. Performance and maintainability

Check:

- duplicated Blade blocks
- excessive inline CSS/JS
- large Blade files
- repeated helpers
- N+1 query risk
- image loading
- asset build issues
- cache usage
- route/model binding
- unnecessary queries

Do not optimize prematurely. Prioritize obvious maintainability and user-facing issues.

### 10. Deployment readiness

Check:

- build command works
- route list works
- migrations run
- storage link requirement
- uploaded file storage
- environment assumptions
- error pages
- production config risks
- queue requirement if any
- mail/payment/external service dependency

Do not configure production credentials.

Only document what is needed unless the user explicitly asks to implement deployment setup.

## Prioritization guide

Use this priority scale:

P0:
Blocks core business flow, causes data loss, breaks login/order/admin approval/public invitation, or creates a serious security issue.

P1:
Major feature incomplete or unreliable, such as client save, gallery, RSVP, QRIS, maps, authorization, or dashboard order handling.

P2:
Important quality issue, maintainability issue, repeated UI bug, confusing UX, missing validation, or inconsistent theme behavior.

P3:
Cosmetic polish, naming cleanup, small spacing issue, low-risk refactor, or documentation improvement.

## Improvement backlog format

When auditing, report findings like this:

```md
# Temanten Improvement Backlog

## Summary

Overall condition:
Main risks:
Best next step:

## P0 - Critical

### 1. Finding title
Area:
Evidence:
Why it matters:
Suggested fix:
Risk:
Estimated files:

## P1 - High

### 1. Finding title
Area:
Evidence:
Why it matters:
Suggested fix:
Risk:
Estimated files:

## P2 - Medium

### 1. Finding title
Area:
Evidence:
Why it matters:
Suggested fix:
Risk:
Estimated files:

## P3 - Low

### 1. Finding title
Area:
Evidence:
Why it matters:
Suggested fix:
Risk:
Estimated files:

## Recommended implementation order

1.
2.
3.

## Do not touch yet

- item
```

## Safe implementation protocol

When implementing improvements:

1. Pick one small improvement group.
2. State files likely affected.
3. Make the minimum necessary change.
4. Avoid unrelated formatting changes.
5. Preserve existing behavior.
6. Run verification.
7. Report results.
8. Move to the next improvement only after the first one is stable.

If the requested task is broad, do not attempt to fix everything at once. Start with the highest-impact low-risk improvements.

## Commands to use

Use relevant commands depending on the change:

```bash
php artisan route:list
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan migrate:status
php artisan test
npm run build
```

Use `php artisan view:clear` after Blade changes.

Use `npm run build` after CSS/JS/Vite/Tailwind changes.

Use `php artisan test` after backend/controller/model/validation changes.

If a command fails, report the exact failure summary and whether it is related to the change.

## Browser verification

When UI or flow changes are made, verify with browser if available.

Check:

- affected route
- desktop viewport
- mobile viewport
- console errors
- network errors
- visible success/error feedback
- persistence after refresh if data is saved

Do not claim UI is fixed from code inspection only.

## Files and areas to avoid

Do not modify unless explicitly requested:

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
- large unrelated refactors

## Data safety

Use dummy/test data.

Avoid destructive actions on real-looking data.

For delete/reset operations, prefer creating new dummy records and deleting only those records.

Do not expose personal data, secrets, tokens, or production credentials.

## When to ask before changing

Ask or pause before changing when:

- database schema changes are required
- destructive data operations are required
- many themes must be edited
- authentication/authorization behavior changes
- route names or URLs change
- existing business logic changes
- large refactor is needed
- production config is involved

For normal small UI, validation, typo, fallback, or bug fixes, proceed safely and report clearly.

## Final report format

At the end of an improvement task, report:

```md
# Project Improvement Report

## Scope

Requested goal:
Areas inspected:
Areas changed:
Areas not touched:

## Summary

What improved:
Why it matters:
Remaining risks:

## Findings handled

### 1. Finding title
Priority:
Status:
Before:
After:
Files changed:
Verification:

## Commands run

```bash
command here
```

Result:

## Files changed

- path: reason

## Recommended next steps

1.
2.
3.
```

## Completion criteria

A project improvement task is complete only when:

- the improvement scope is clear
- risks are identified
- changes are small and relevant
- commands/browser verification are run where possible
- files changed are explained
- remaining risks are not hidden
- next steps are prioritized

Do not claim the whole project is production-ready unless a full audit and verification were actually performed.
