# Combined Verification Report: PLUGINS_SMALL-6 (SWEGTS)

**Issue:** free_plugin_lib: setup notice can't be dismissed and never goes away (all free plugins)
**Date:** 2026-10-23
**Commit:** 85c1e9d..8c033ab; free_plugin_lib v1.3.3 (4f34052)

## Executive Summary

| Review | Status |
|--------|--------|
| Commit Integrity | not-applicable (no claimed SHAs); change-set non-empty |
| Code Review | passed: library reviewed independently for v1.3.0..v1.3.2 (see stop-user-enumeration .sdlc/PLUGINS_SMALL-6/verification.md); 1.3.3 adds only PLUGINS_SMALL-7 |
| Acceptance Review | passed: every ticket item checked over HTTP in this plugin's wp-env |
| Browser-Test Gate | n-a: no layout change. Notice HTML and redirects inspected over HTTP |
| **Overall** | **APPROVED** |

## Where the code is
The fix is in alanef/free_plugin_lib (v1.3.0..v1.3.3, 35 PHPUnit tests, mutation-checked). SWEGTS changes the
constraint to `^1.3.3`, adds changelog bullets, and adds one line to `includes/class-uninstall.php`:
`Main::plugin_uninstall('SWEGTS')`, which the 1.3.0 upgrade notes require and SWEGTS lacked.

## Acceptance (wp-env :8740, admin, library loaded from SWEGTS's own includes/vendor, v1.3.3)

| Check | Result |
|---|---|
| Status 'rendering': dashboard / admin-ajax heartbeat | 200 / 200 (no redirect hijack) |
| Notice | rendered with `data-shortname="SWEGTS"`, links to `options-general.php?page=ffpl-opt-in-SWEGTS` |
| Dismiss AJAX round-trip | `{"success":true}`; `SWEGTS_notice_dismissed` = 1; notice gone on reload |
| Settings page while 'rendering' | 302 to `ffpl-opt-in-SWEGTS` |
| Skip | 302; status `optout`; settings page then 200 |
| Uninstall routine | removes both `stop-wp-emails-going-to-spam-settings-1` and `SWEGTS_form_rendered` |
| `composer run check` / `npm test` | clean / OK (3 tests) |
| CI (checks.yml) on 85c1e9d | run 39918568038, both jobs success |

All test options and user meta were reset afterwards.

## Commit Range Covered
**Commit range covered:** `85c1e9d..8c033ab`

| SHA | Subject |
|-----|---------|
| 85c1e9d | Take free_plugin_lib 1.3.3 (PLUGINS_SMALL-6, PLUGINS_SMALL-7) |
| 8c033ab | Declare PHP 7.4 in composer.json, matching the library |

8c033ab carries no issue ID. It follows from this rollout: the library requires PHP 7.4 or later, and Alan decided
plugins must declare 7.4. It changes only `"php"` in the plugin directory's composer.json, and the plugin header
already said `Requires PHP: 7.4`. Checked on it: `composer run check` clean, `npm test` OK (3 tests), checks.yml run
39921312162 with both jobs success, and the tests-passed marker re-run on it. Release 3ae25e8 precedes it, and the
marker now names the later commit. No other out-of-range commits.

---
Verified by: AI Assistant
Date: 2026-10-23
