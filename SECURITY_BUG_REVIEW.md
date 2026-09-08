# Security and Bug Review

Review date: 2026-09-08

Scope: Current worktree, including untracked changes. Security and functional bugs were prioritized, with maintainability and readability guiding the recommendations. No application source files were edited during the review.

## High Priority

1. **[P1] Tenant sessions can impersonate main-database users.**

   Both middleware classes exempt the main domain: [EnsureTenantSessionMatchesHost.php:21-22](app/Http/Middleware/EnsureTenantSessionMatchesHost.php#L21), [ConnectToUserDatabase.php:28-29](app/Http/Middleware/ConnectToUserDatabase.php#L28). With shared file sessions and matching numeric user IDs, replaying a tenant's own cookie against the main domain authenticates as the main account. This identity substitution was reproduced in isolation. Enforce session scope on every authenticated origin, including LogViewer's separate API middleware.

2. **[P1] Reusing a deleted tenant name can expose the replacement account.**

   [ProfileController.php:65-69](app/Http/Controllers/Settings/ProfileController.php#L65) invalidates only the current session before deleting the tenant database. Another session retains the tenant name and user ID. Re-registering that name creates the same initial ID, allowing the previous owner's unexpired session to identify the replacement user. Bind sessions to a non-reusable account identifier, not just the tenant name.

3. **[P1] Password-reset links trust the incoming Host header.**

   [ForgotPasswordController.php:38-44](app/Http/Controllers/Auth/ForgotPasswordController.php#L38) generates signed URLs from the request origin. Single-user mode does not validate that origin. If the deployment accepts arbitrary Host headers, an attacker can cause genuine reset emails to link to their server and capture the reset credentials. Reject untrusted hosts and use a trusted origin for recovery links.

4. **[P1] Editing a client silently clears its hourly rate.**

   [clients/edit.blade.php:46](resources/turbo/clients/edit.blade.php#L46) disables inherited rates without passing the client's own rate explicitly. [HourlyRate.php:67-79](app/View/Components/Form/HourlyRate.php#L67) consequently renders an empty amount. An EUR 80/hour client was confirmed to render blank with USD selected; saving a name-only change clears the rate. Pass the existing rate through the component's `hourlyRate` prop.

## Other Bugs

5. **[P2] Money attributes have inconsistent persistence and caching behavior.**

   [TimeEntry.php:147-154](app/Models/TimeEntry.php#L147), [ProjectController.php:80-104](app/Http/Controllers/ProjectController.php#L80). Assigning `$timeEntry->hourlyRate` produces a nonexistent `hourlyRate` database column, breaking "Update old time entries too." Separately, reading a project's cached camel-case rate and then clearing `hourly_rate` restores the old value. Both behaviors were reproduced. Standardize on one attribute name and consistent casting behavior.

6. **[P2] Tenant migrations report success without applying migrations.**

   [MigrateTenantDatabases.php:26-31](app/Console/Commands/MigrateTenantDatabases.php#L26) supplies an absolute `--path` without `--realpath`. Laravel prepends the application path again and discovers no migrations. Existing tenants remain on the old schema. The smallest fix is to omit `--path` and use Laravel's default directory.

7. **[P2] Automatic password rehashing corrupts the password.**

   [User.php:41-45](app/Models/User.php#L41) hashes every assigned value. Laravel's automatic rehash supplies an already-hashed password, so a bcrypt cost change causes double hashing: the triggering login succeeds, but subsequent logins fail. Replace the unconditional mutator with Laravel's `hashed` cast.

8. **[P2] Remember-me restoration causes tenant users to receive HTTP 403.**

   [EnsureTenantSessionMatchesHost.php:31-35](app/Http/Middleware/EnsureTenantSessionMatchesHost.php#L31). A valid remember cookie restores authentication after session expiry, but not the custom `tenant` session key. The middleware then rejects the user, including access to login/logout. Establish the tenant binding during verified remember-token restoration; reject incomplete ordinary sessions by clearing them and returning to login.

9. **[P2] Password changes do not consistently revoke previous credentials.**

   [PasswordController.php:22-24](app/Http/Controllers/Settings/PasswordController.php#L22), [ResetPasswordController.php:52-61](app/Http/Controllers/Auth/ResetPasswordController.php#L52). Existing authenticated sessions survive password resets because no password-hash session validation is enabled. Settings changes also retain outstanding reset and remember tokens. Apply one consistent credential-rotation policy across settings, email recovery, and CLI recovery.

10. **[P2] CSV escaping permits field breakout despite formula sanitization.**

    [CsvExportService.php:112-124](app/Services/CsvExportService.php#L112). The default `fputcsv()` backslash escape can break CSV field boundaries. A nine-column record was reproduced as eleven columns, with an embedded `=1+1` appearing as a separate unsanitized cell. Explicitly use `escape: ''` and test round-trip parsing, not only output substrings.

11. **[P2] Stale timer controls act on a different timer.**

    [RunningTimerSessionController.php:40-55](app/Http/Controllers/RunningTimerSessionController.php#L40), [TimerSessionCompletionController.php:16-25](app/Http/Controllers/TimerSessionCompletionController.php#L16). Open timer A in two tabs, stop it and start B in one, then use the old controls in the other. They modify, stop, or delete B because requests identify only "the running timer." Submit the displayed entry ID and verify it inside the lock.

12. **[P2] Project-only entries disappear from client-filtered reports.**

    [TimeEntryController.php:69-75](app/Http/Controllers/TimeEntryController.php#L69) allows a project with no direct client, while [TimeEntry.php:55-57](app/Models/TimeEntry.php#L55) filters only the direct `client_id`. Valid billable entries therefore disappear when filtering by their project's client. Normalize the client association when saving, or consistently account for the project relationship when filtering.

13. **[P2] "Last Month" returns the current month at month-end.**

    [DateRangeFilter.php:70-73](app/ValueObjects/DateRangeFilter.php#L70). Carbon's month subtraction overflows. With the clock set to March 31, March 1-31 was reproduced instead of February. Use `subMonthNoOverflow()` or subtract after moving to the current month's start.

14. **[P2] Time-entry pagination drops active filters.**

    [TimeEntryController.php:24-33](app/Http/Controllers/TimeEntryController.php#L24). Page-two links omit client, project, and date filters. The surrounding Turbo page can still display the old selections while showing unfiltered entries. Add `withQueryString()`, matching the other indexes.

15. **[P2] Session recovery uses the wrong Turbo event contracts.**

    [session_recovery_controller.js:87-118](resources/js/controllers/session_recovery_controller.js#L87), [session_recovery_controller.js:265-279](resources/js/controllers/session_recovery_controller.js#L265). `preventDefault()` does not stop `turbo:submit-start`, so resubmission can repeat a request. The response event also lacks the request options being captured, preventing reliable recovery after a 419. Simplify this around Turbo's `before-fetch-request` pause/resume mechanism instead of maintaining a parallel request-replay system.

16. **[P2] Rolling back the precision migration allows money to be rescaled twice.**

    [normalize_money_precision.php:26-34](database/migrations/2026_09_07_001358_normalize_money_precision.php#L26). There is no `down()`, but Laravel can remove the migration record during rollback. Reapplying then converts already-normalized amounts again. Implement a deliberate reverse conversion or explicitly prevent rollback.

17. **[P2] Database downloads are not consistent backups.**

    [DatabaseBackupController.php:33-35](app/Http/Controllers/Settings/DatabaseBackupController.php#L33) streams the live SQLite file. Concurrent writes can produce an inconsistent copy; WAL-mode databases can omit committed changes. Generate a SQLite snapshot first, then download it.

## Dependency Security

`composer audit --locked --no-dev --format=json` reported advisories affecting production dependencies, including Laravel **12.48.1** and Symfony Mime **7.4.4**: [composer.lock:1445-1446](composer.lock#L1445), [composer.lock:4792-4793](composer.lock#L4792).

These include signed-URL and email-validation/injection advisories. Update to patched compatible releases and rerun the audit. The audit does not establish that every flagged vulnerability is reachable through this application.

## Maintainability

The highest-value improvements are small and targeted:

- Standardize money attribute naming and casting across the four models.
- Apply client/project validation and normalization consistently to manual entries and timers.
- Keep account identity, session binding, and credential revocation under one clear policy.
- Replace custom frontend retry bookkeeping with Turbo's supported lifecycle APIs.

Avoid a broad architectural rewrite while fixing these defects.

## Verification

- Reviewed the current worktree, including untracked changes. No application source files were edited.
- Focused PHPUnit runs: **89 passed, 8 failed**.
- All eight failures are `ArgumentCountError` failures in tenant tests/helpers expecting injected `Request` parameters: [TenantDatabaseServiceTest.php:28](tests/Unit/Services/TenantDatabaseServiceTest.php#L28), [EnsureTenantSessionMatchesHostTest.php:63](tests/Unit/Middleware/EnsureTenantSessionMatchesHostTest.php#L63), [EnsureTenantUserTest.php:21](tests/Unit/Http/Middleware/EnsureTenantUserTest.php#L21).
- Used isolated runtime checks for identity substitution, money attributes, client-rate rendering, password hashing, reset-link origins, date ranges, and CSV parsing.
- Full-suite, browser, and concurrency verification were not run.

Fix tenant isolation and silent rate loss first, with regression tests before implementation.
