---
name: temanten-documentation-handover
description: Use this rule when creating or improving README, setup guides, handover documentation, feature documentation, demo credentials, project structure notes, or developer onboarding docs for the Laravel Temanten wedding invitation app.
---

# Temanten Documentation and Handover

## Purpose

You are acting as a technical writer and Laravel project maintainer for the Temanten wedding invitation app.

Your goal is to make the project understandable, installable, testable, and presentable to another developer, reviewer, employer, client, or future maintainer.

Good documentation should make the project feel professional.

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

Guest creates order → Admin approves order → Client edits invitation → Guest opens public invitation → Guest submits RSVP/ucapan.

## Main rule

Documentation must be specific to the actual project.

Avoid generic README filler.

Do not invent features that do not exist.

If a feature is planned but not implemented, mark it as planned or roadmap.

If credentials, URLs, commands, or setup steps are uncertain, inspect the project first.

Do not expose real secrets, tokens, or production credentials.

## Documentation targets

The project should ideally include:

- README.md
- installation guide
- local development guide
- feature list
- role and user flow explanation
- demo credentials if safe
- environment variable example guidance
- database setup steps
- migration/seeder steps
- build commands
- test commands
- deployment checklist
- known limitations
- roadmap
- troubleshooting section

## README structure

Recommended `README.md` structure:

```md
# Temanten

Short project description.

## Overview

What the project does and who it is for.

## Features

- feature

## Tech Stack

- Laravel
- Blade
- Vite
- Tailwind CSS
- Alpine.js
- Flowbite
- MySQL

## User Roles

### Guest
What guest can do.

### Client
What client can do.

### Admin
What admin can do.

## Main Flow

1. Guest creates order.
2. Admin approves order.
3. Client edits invitation.
4. Guest opens public invitation.
5. Guest submits RSVP/ucapan.

## Requirements

- PHP version
- Composer
- Node.js
- NPM
- MySQL
- Laragon or local server

## Installation

```bash
git clone ...
cd temanten
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

## Local Development

```bash
php artisan serve
npm run dev
```

Or explain Laragon setup if applicable.

## Demo Account

Only include safe dummy accounts.

## Useful Commands

```bash
php artisan route:list
php artisan test
php artisan view:clear
npm run build
```

## Testing

Explain test commands and test scope.

## Deployment Notes

Explain production checklist.

## Project Structure

Explain important folders.

## Known Limitations

Be honest.

## Roadmap

List next improvements.

## License

State license if known.
```

Adjust based on actual project.

## Demo credentials rules

Only include demo credentials if they are safe dummy credentials.

Never include real accounts.

Use `.example.test` emails for documentation if creating seeders.

Example:

```txt
Admin:
Email: admin@example.test
Password: password

Client:
Email: client@example.test
Password: password
```

If demo credentials do not exist, either create safe seeders if requested or document that users must register/create accounts manually.

## Setup guide rules

Installation steps must be accurate.

Before documenting commands, inspect:

- `composer.json`
- `package.json`
- `.env.example`
- database config
- migrations
- seeders
- existing tests
- Vite config
- storage usage

Do not assume Sail, Docker, queues, mail, or Redis unless present.

## Handover document

If asked for project handover, create or update:

```txt
docs/HANDOVER.md
```

Recommended structure:

```md
# Temanten Project Handover

## Project Summary

## Current Status

## Main Features

## User Roles

## Important Flows

## Important Files

## Database Notes

## Environment Notes

## How to Run Locally

## How to Test

## How to Deploy

## Known Issues

## Recommended Next Work
```

## Feature documentation

If asked to document features, use this format:

```md
## Feature Name

Purpose:
Role:
Route/Page:
Main files:
How it works:
Validation:
Known limitations:
Testing notes:
```

## Troubleshooting section

Include only real issues or likely Laravel issues.

Good troubleshooting entries:

- 500 error after pull: run `composer install`, check `.env`, run migrations.
- Vite assets not loading: run `npm install` and `npm run dev` or `npm run build`.
- Uploaded images not showing: run `php artisan storage:link`.
- Route not found after changes: run `php artisan route:list` and clear route cache if used.
- Blade changes not visible: run `php artisan view:clear`.
- Database error: verify MySQL database and `.env` values.

## Documentation quality rules

Good documentation is:

- specific
- accurate
- concise
- structured
- honest
- command-oriented
- useful for onboarding

Avoid:

- exaggerated claims
- fake production readiness
- unverified feature lists
- generic marketing text
- undocumented assumptions
- outdated commands
- real credentials

## Safe editing protocol

When improving docs:

1. Inspect current documentation.
2. Inspect actual project files.
3. Update only relevant docs.
4. Do not invent features.
5. Mark uncertain items as TODO or verify before documenting.
6. Keep examples safe and dummy.
7. Report changed docs.

## Final report format

```md
# Documentation Report

## Scope

Docs changed:
Project files inspected:
Assumptions made:

## Changes

### 1. Document name
What changed:
Why it matters:

## Remaining gaps

- item

## Recommended next docs

1.
2.
3.
```

## Completion criteria

A documentation task is complete only when:

- docs match the actual project
- setup commands are realistic
- demo credentials are safe or omitted
- limitations are honest
- next steps are clear
- no secrets are exposed
