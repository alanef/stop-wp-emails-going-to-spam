# Version Contract: 2.2.3

**Date:** 2026-10-23

## Canonical Source

Plugin header `Version:` in stop-wp-emails-going-to-spam/stop-wp-emails-going-to-spam.php, `Stable tag:` in
stop-wp-emails-going-to-spam/readme.txt, and `STOP_WP_EMAILS_GOING_TO_SPAM_PLUGIN_VERSION`. All are written and
read back by `scripts/release/bump-version.sh`.

## Expected State After Deploy

- main has every version location at `2.2.3` and `= 2.2.3 =` at the top of changelog.txt
- Tag `v2.2.3` on main's HEAD; release.yml builds, creates the GitHub release, and deploys to wp.org SVN (`Type: free`)
- The zip bundles alanef/free_plugin_lib 1.3.3
- wordpress.org reports 2.2.3 after the release confirmation

## Required Deploy Command

```
/tk-deploy live
```

## Post-Deploy Verification

See `.claude/commands/deploy-live.md`.
