---
name: temanten-ui-ux-quality
description: Use this rule when designing, reviewing, or improving UI/UX for the Laravel Temanten wedding invitation app. This rule prevents generic AI-looking output, enforces visual hierarchy, responsive quality, design consistency, accessibility, and tasteful wedding invitation aesthetics.
---

# Temanten UI/UX Quality Rule

## Purpose

You are acting as a UI/UX designer, frontend reviewer, and product-minded Laravel/Blade implementer for the Temanten wedding invitation app.

Your goal is to improve the interface so it feels intentional, polished, usable, and appropriate for a real wedding invitation product.

Do not create generic AI-generated UI.

Avoid "AI slop": random gradients, excessive glassmorphism, meaningless floating objects, inconsistent spacing, unreadable text, decorative clutter, emoji abuse, fake luxury styling, and generic marketing copy that does not fit the actual product.

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

Main UI areas:

- Landing page
- Guest order page
- Admin dashboard
- Client dashboard
- Client invitation editor
- Public invitation themes
- RSVP and ucapan/doa forms
- Gift/rekening/QRIS section
- Gallery section
- Maps section

Primary users:

- Guest
- Client / wedding couple
- Admin

## Core UI principle

Every design decision must have a purpose.

Before adding decoration, ask:

- Does it improve clarity?
- Does it improve emotion?
- Does it improve trust?
- Does it improve usability?
- Does it fit the selected theme?
- Does it still work on mobile?

If not, do not add it.

## Anti AI-slop rules

Avoid these patterns unless the existing design system already uses them intentionally:

- random gradient blobs
- too many shadows
- too many rounded cards
- glassmorphism everywhere
- floating emojis
- random decorative icons
- inconsistent illustration style
- meaningless hero text
- fake dashboard widgets
- large empty sections with generic copy
- overused "modern SaaS" layout for a wedding app
- low-contrast pastel text
- every section using the same card style
- inconsistent button styles
- inconsistent spacing between sections
- decorative elements blocking content
- animation that distracts from reading
- using icons where labels are clearer
- making all text centered without hierarchy
- using stock-like placeholder copy
- adding new colors without a reason
- using many font sizes without a scale
- changing many themes at once without verifying each one

Do not make the UI look "fancier" by adding random effects. Make it clearer, calmer, more consistent, and more appropriate.

## Design quality targets

A good Temanten UI should feel:

- warm
- elegant
- personal
- calm
- readable
- mobile-first
- trustworthy
- easy for non-technical users
- appropriate for Indonesian wedding use cases

For admin/client pages, prioritize:

- clarity
- speed
- simple navigation
- visible status
- clear forms
- clear save feedback
- safe destructive actions

For public invitation themes, prioritize:

- emotional presentation
- readable content
- smooth guest flow
- mobile comfort
- tasteful decoration
- reliable maps/RSVP/gallery/gift behavior

## Visual hierarchy

Every page or section should have a clear hierarchy:

1. Primary title
2. Supporting description
3. Main action
4. Secondary action
5. Additional details

Do not make all text the same size, weight, or color.

For each section, identify:

- What should users notice first?
- What should they do next?
- What information is secondary?
- What can be visually quieter?

Use size, spacing, contrast, and weight before adding decoration.

## Layout rules

Use consistent spacing.

Prefer a simple spacing rhythm:

- small gap: 8px
- medium gap: 16px
- large gap: 24px
- section gap: 48px to 72px

Avoid random margins like 13px, 37px, or inconsistent one-off spacing unless required by an existing layout.

For mobile:

- content must not touch screen edges
- buttons must be easy to tap
- fixed bottom navigation must not cover forms
- long text must wrap cleanly
- forms must fit without horizontal scroll
- gallery must not crop important faces
- modals must fit small screens

For desktop:

- avoid stretching content too wide
- use max-width containers
- use columns only when they improve scanning
- do not create large empty spaces just to look premium

## Typography rules

Use typography to improve reading.

Avoid:

- too many font families
- decorative font for long text
- tiny pastel text
- very thin font weight for important content
- uppercase labels everywhere
- centered paragraphs that are too long

For wedding themes:

- decorative font may be used for names or headings
- body text must remain readable
- date/time/location must be highly legible
- RSVP and gift instructions must be practical and clear

For dashboards:

- use clean sans-serif
- prioritize form labels, table readability, and status badges
- avoid decorative fonts

## Color and contrast

Do not add many colors.

Each page/theme should have:

- background color
- primary text color
- muted text color
- primary accent color
- secondary accent color if needed
- border/divider color
- success/error/warning colors for feedback

Never sacrifice readability for aesthetic pastel colors.

Check:

- button text contrast
- muted text contrast
- placeholder contrast
- card background vs page background
- links and active states
- disabled states
- error messages
- success notifications

If text is hard to read, fix contrast before adding effects.

## Component quality

For every component, define its purpose.

Buttons:

- primary button for main action
- secondary button for less important action
- destructive button for delete actions
- disabled state when action is unavailable
- loading state during submit if possible

Forms:

- label every field clearly
- show validation errors near fields
- show success feedback after save
- preserve user input on validation failure
- group related fields
- avoid very long unstructured forms

Cards:

- use cards to group related information
- do not wrap every tiny element in a card
- avoid excessive shadows
- keep border radius consistent

Tables/lists:

- show useful status
- include empty state
- include clear action buttons
- avoid hidden important actions
- make mobile behavior usable

## Wedding invitation theme quality

Each public theme must have a coherent identity.

Before editing or creating a theme, define:

- theme mood
- color palette
- typography style
- decorative motif
- section rhythm
- image treatment
- animation restraint

Examples of coherent theme directions:

- Classic elegant
- Islamic minimal
- Javanese traditional
- Sundanese soft
- Floral pastel
- Rustic garden
- Modern clean
- Luxury gold
- Ocean calm
- Terracotta boho

Do not mix unrelated motifs in one theme.

Avoid:

- random hearts
- random sparkles
- random emoji
- floating character without meaning
- mismatched ornaments
- luxury gold on every style
- overanimated gate
- decorative assets covering text or buttons

Theme sections must remain functional:

- open invitation button works
- couple names readable
- date/time readable
- location readable
- maps button visible
- RSVP form usable
- ucapan/doa usable
- gallery usable
- gift/QRIS section clear
- bottom navigation does not cover forms

## Indonesian UX copy rules

Use clear Indonesian.

Avoid generic AI copy like:

- "Rasakan pengalaman digital yang luar biasa"
- "Solusi terbaik untuk kebutuhan Anda"
- "Nikmati kemudahan tanpa batas"
- "Desain modern dan elegan untuk semua"

Prefer specific copy based on actual function:

- "Buat undangan digital dalam beberapa langkah."
- "Kelola tamu, RSVP, galeri, dan informasi acara dari satu dashboard."
- "Bagikan link undangan setelah pesanan disetujui admin."
- "Simpan perubahan, lalu cek tampilan undangan publik."

For buttons, use direct verbs:

- Simpan
- Lihat Undangan
- Tambah Tamu
- Upload Foto
- Hapus Foto
- Salin Nomor
- Buka Maps
- Kirim Ucapan
- Konfirmasi Kehadiran

Avoid overly clever labels.

## Dashboard UX rules

Client dashboard should answer:

- What is the status of my invitation?
- What should I complete next?
- Where do I edit content?
- Has my change been saved?
- How do I preview the public invitation?
- How do I manage guests, RSVP, gallery, QRIS, and maps?

Admin dashboard should answer:

- Which orders need approval?
- Which invitations are active?
- Which clients need attention?
- What action should admin take next?
- Was the action successful?

Use clear status badges:

- Pending
- Approved
- Active
- Draft
- Rejected
- Paid / Unpaid if payment exists

Do not rely only on color. Use text labels.

## UX feedback rules

Every user action should have feedback.

For save/update:

- show success message
- keep user on relevant page or redirect clearly
- preserve scroll/section context when practical

For delete:

- confirm destructive action
- show deleted state
- avoid accidental deletion

For upload:

- show allowed file type/size
- show preview if practical
- show error if upload fails

For loading:

- disable repeated submit if practical
- show clear state if operation takes time

## Accessibility basics

Follow these basics:

- buttons must be actual buttons or links with clear purpose
- links should have meaningful text
- form inputs need labels
- color alone should not communicate status
- focus state should remain visible
- images should have useful alt text when meaningful
- decorative images can have empty alt
- text must be readable on mobile
- interactive targets should be large enough to tap

## Implementation rules

When improving UI/UX:

1. Inspect the existing page/component.
2. Identify the actual UX problem.
3. Define the intended user outcome.
4. Improve hierarchy, spacing, copy, contrast, or interaction.
5. Avoid changing backend logic unless required.
6. Avoid unrelated redesigns.
7. Keep changes small and reviewable.
8. Test desktop and mobile.
9. Report before/after clearly.

Do not rewrite the entire UI when a smaller improvement solves the problem.

Do not redesign all themes at once.

For theme fixes, change only the affected theme unless the problem is shared and safe to standardize.

## Tailwind and CSS rules

Prefer existing design tokens/classes if available.

Avoid creating many one-off arbitrary values.

Use consistent patterns:

- max width containers
- readable line height
- consistent gap
- consistent rounded radius
- consistent shadow level
- clear responsive breakpoints

Avoid excessive inline CSS unless the theme already uses it and there is no better option.

If a Blade file becomes too large, consider extracting repeated UI into partials/components, but do not over-engineer.

## Review checklist

Before finishing a UI/UX task, check:

- Does the page have clear hierarchy?
- Is the main action obvious?
- Is the copy specific and useful?
- Is mobile layout comfortable?
- Is desktop layout not overly stretched?
- Are buttons visible and tappable?
- Is text readable?
- Are errors and success messages visible?
- Are decorative elements restrained?
- Does it avoid generic AI-looking styling?
- Did you avoid unrelated changes?
- Was the affected page tested?

## Report format

At the end of a UI/UX task, report:

```md
# UI/UX Improvement Report

## Scope

Page/component:
Role:
Viewport tested:
Files changed:

## Problem

What was weak before:

## Design decision

What changed:
Why this is better:
What was intentionally not changed:

## Verification

Desktop:
Mobile:
Console errors:
Build/check command:

## Files changed

- path: reason

## Remaining risks

- item
```

## Completion criteria

A UI/UX task is complete only when:

- the UI problem is clearly identified
- the design decision is intentional
- the fix improves clarity/usability/readability
- mobile and desktop are considered
- the result avoids generic AI-looking patterns
- affected page is verified where possible
- remaining risks are stated honestly
