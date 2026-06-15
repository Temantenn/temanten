# Temanten — Bug Audit Report (Canonical)

## Test Status

```text
Tests: 47 passed (133 assertions)
```

Last verified: `php artisan test` after B15/B16 housekeeping.

---

## Scope

Canonical audit doc. Parallel/stale bug reports removed. Keep future audit notes here only.

Removed duplicates:

- `docs/BUG_REPORT.md`
- `docs/BUG_REPORT_INDONESIA.md`

---

## Current Status Matrix

| ID | Priority | Area | Status | Resolution |
| --- | --- | --- | --- | --- |
| B1 | P0 | `Guest` mass assignment | Fixed | `app/Models/Guest.php` now uses explicit `$fillable` whitelist incl. `jumlah_tamu`, `comment`; no broad `$guarded = ['id']`. |
| B2 | P0 | `.env` write race | Fixed/Mitigated | `AdminController::updateDefaultPrice()` uses cache lock, temp file, `LOCK_EX`, atomic rename, cleanup. |
| B3 | P0 | approval email race | Fixed/Mitigated | Approval flow locks user row, runs in transaction, checks unique email under lock, catches/logs failures. |
| B4 | P0 | approval notification email logic | Fixed | Original email saved before user email mutation; notification check uses original email. |
| B5 | P1 | guest slug collision | Fixed | Guest model and public `saveGuestResponse()` now generate random 8-char suffixes. |
| B6 | P1 | client authorization | Fixed | `InvitationPolicy`, `GuestPolicy`, controller authorization/ownership checks added. |
| B7 | P1 | gallery delete permanence | Fixed/Mitigated | Gallery deletion now supports soft-trash pattern instead of immediate silent loss. |
| B8 | P1 | signed image throttling | Fixed | `/storage/invitations/{uuid}/{filename}` uses signed URL + dedicated `throttle:signed-images`. |
| B9 | P2 | `name` vs `nama` mismatch | Fixed | Public request aliases normalized; tests/schema consistent. |
| B10 | P2 | guest import partial writes | Fixed | Import flow wrapped with transaction/error handling. |
| B11 | P2 | WhatsApp normalization | Fixed | Shared `App\Support\WhatsAppNumber` validation/normalization. |
| B12 | P2 | CSV template/export stream errors | Fixed | CSV built in-memory with BOM + escaped rows + try/catch/logging + safe download headers. |
| B13 | P2 | order flow unknowns | Fixed/Verified | `OrderController::success()` exists; `OrderService`/`QrisService` exist; QRIS config via env; success access guarded by owner/session. |
| B14 | P3 | scaffold tests | Fixed | Default `tests/Unit/ExampleTest.php` + `tests/Feature/ExampleTest.php` removed; phpunit uses dirs only. |
| B15 | P3 | duplicate audit docs | Fixed | This file is canonical; stale duplicate docs deleted. |
| B16 | P3 | root `template_admin.html` clutter | Fixed | Moved to `docs/template_admin.html`; root project no longer cluttered; no irreversible delete. |
| B17 | P3 | public registration | Fixed | Auth routes still exist, but controller aborts unless `PUBLIC_REGISTRATION_ENABLED=true` (default false). |

---

## Notes Merged From Removed Reports

- Older claim “`/order-success/{id}` missing method” is stale: route now maps `/order-success/{order_number}` to `OrderController::success()`.
- Older claim “`OrderService`/`QrisService` missing” is stale: both services exist and are injected.
- Older claim “Unsplash API key hardcoded” is stale: demo lookup uses `config('temanten.unsplash.key', '')` / `.env`.
- Older claim “QRIS master string hardcoded” is stale: uses `config('temanten.qris_master_string')` / `.env`.
- Older claim “import file validation missing” is stale: `ImportGuestsRequest` validates `csv,txt,xlsx,xls|max:2048`.
- Older claim “guest export missing `jumlah_tamu`” is stale: export includes `Jumlah Tamu`.
- Older claim “CSV missing BOM/no error handling” is stale: B12 fixed.
- Older claim “debug exception leaks” is stale: admin errors now return generic message; details logged.
- Invitation page cache is invalidated on RSVP/comment save and expired invitation detection via `Cache::forget("invitation:{slug}")`.

---

## Remaining Watch Items

- Public RSVP/comment aliases (`/kirim-ucapan`, `/undangan/{slug}/ucapan`, `/rsvp/{id}`) intentionally remain for backward compatibility; keep tests around them.
- Unsplash remote API remains optional; ensure missing key/failure fallback stays graceful.
- `.env` runtime writes are still operationally fragile vs DB-backed settings, even with locking. Future improvement: move settings to DB.

---

## Docs Policy

- Keep audit/bug status in `docs/AUDIT_BUG_REPORT.md` only.
- Do not create parallel `BUG_REPORT*.md` files.
- When a bug is fixed, update status + add verification command/result.