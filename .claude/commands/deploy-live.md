<!-- Managed by wordpress-plugin-boilerplate/tooling (deploy-live.free.md) - fix there first, then run bin/sync-tooling.sh -->
# Deploy live: Stop WP Emails Going to Spam

Run by `/tk-deploy live`. Releases the version already set in the plugin header through
the single-tag pipeline: one tag here runs `release.yml`, which re-runs the checks, creates
the GitHub release with `stop-wp-emails-going-to-spam-$V.zip` attached and deploys to what `Type: free`
in `stop-wp-emails-going-to-spam/readme.txt` asks for.

Stop at the first failure and report it. Never retry a tag push, never force
anything, never delete a tag to "try again". Use absolute paths throughout:
`CDPATH` is set on Alan's machines and sends a relative `cd` somewhere else.

```bash
P=$(git rev-parse --show-toplevel)
GIT_TERMINAL_PROMPT=0 git -C $P fetch origin --tags
V=$(grep -m1 -oP '^[ \t]*\*?[ \t]*Version:[ \t]*\K\S+' $P/stop-wp-emails-going-to-spam/stop-wp-emails-going-to-spam.php)
TAG=v$V          # this repo's tag style (pin "tag_prefix" in .tooling.json)
PREV=$(git -C $P tag -l | grep -E '^v?[0-9]+(\.[0-9]+)+$' | awk '{t=$0; sub(/^v/,"",t); print t" "$0}' | sort -V | tail -1 | cut -d' ' -f2)
KEY=$(grep -oP '^YOUTRACK_PROJECT=["'\'']?\K[A-Za-z0-9_]+' $P/.env.youtrack 2>/dev/null)
KEY=${KEY:-}   # empty: YouTrack step is skipped with a note
```

Check `git -C $P remote get-url origin` names `alanef/stop-wp-emails-going-to-spam` before going on.

## Preconditions

All must hold, otherwise stop:

- On `main` and level with `origin/main`
  (`git -C $P rev-parse HEAD` = `git -C $P rev-parse origin/main`).
- No tracked changes: `git -C $P status --porcelain --untracked-files=no` is empty.
- Version agreement everywhere, no prerelease suffix, changelog heading in place:
  `$P/scripts/release/bump-version.sh --check $V` exits 0.
- Tag absent locally and on origin, in either style (release.yml fires on both):
  `git -C $P tag -l "$V" "v$V"` and
  `GIT_TERMINAL_PROMPT=0 git -C $P ls-remote --tags origin "refs/tags/$V" "refs/tags/v$V"` are empty.
- `$P/.sdlc/releases/$V/RELEASE_NOTES.md` exists (from `/tk-release $V`).
- `$P/.sdlc/releases/$V/TESTS_PASSED.md` exists, and its commit
  `C=$(grep -oP '^\*\*Commit:\*\* \K[0-9a-f]+' $P/.sdlc/releases/$V/TESTS_PASSED.md)`
  is an ancestor of HEAD (`git -C $P merge-base --is-ancestor $C HEAD`) with no plugin
  code changed since
  (`git -C $P diff --quiet $C HEAD -- stop-wp-emails-going-to-spam/ ':!stop-wp-emails-going-to-spam/changelog.txt'`).
  Otherwise re-run `$P/scripts/release/run-tests-and-mark.sh $V`. If the marker shows
  PHPUnit `SKIPPED`, say so to the user when asking for confirmation.
- `$P/.sdlc/releases/$V/DEPENDENCY_AUDIT.md` exists (from `scripts/release/check-dependencies.sh`).
- The latest `checks.yml` run on `main` is for HEAD and succeeded:
  `gh run list -R alanef/stop-wp-emails-going-to-spam --workflow checks.yml --branch main --limit 1 --json headSha,status,conclusion`
  shows `headSha` = HEAD, `completed`, `success`.

Then show the user: `$PREV..HEAD` (`git -C $P log --oneline $PREV..HEAD`; no tags yet
means `$PREV` is empty, so show `git -C $P log --oneline -20` and say it is a first release), the issue ids
in range, the `= $V =` section of `stop-wp-emails-going-to-spam/changelog.txt`, and exactly what the next
step will publish. **Ask for explicit confirmation before tagging.** Anything other than a
clear yes means stop.

## Tag and push

```bash
git -C $P tag $TAG && GIT_TERMINAL_PROMPT=0 git -C $P push origin $TAG
```

If the push fails, stop and report: the tag then exists only locally. Do not delete it,
retry or force; tell the user.

## Watch release.yml

```bash
gh run list -R alanef/stop-wp-emails-going-to-spam --workflow release.yml --limit 5 --json databaseId,headBranch,status
gh run watch <id> -R alanef/stop-wp-emails-going-to-spam --exit-status     # the run whose headBranch is $TAG
```

Run the watch in the background and wait for completion. Every job must succeed. On
failure show `gh run view <id> -R alanef/stop-wp-emails-going-to-spam --log-failed` and stop.

## Confirm what landed

```bash
gh release view $TAG -R alanef/stop-wp-emails-going-to-spam --json assets -q '.assets[].name'   # must list stop-wp-emails-going-to-spam-$V.zip
```

WordPress.org SVN must have the tag:

```bash
curl -s https://plugins.svn.wordpress.org/stop-wp-emails-going-to-spam/tags/ | grep -c ">$V/<"   # must be 1
```

The wordpress.org API
(`https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request%5Bslug%5D=stop-wp-emails-going-to-spam`)
will NOT show `$V` yet if release confirmation is on: the release waits for a committer to
confirm it. That is expected; see the manual steps.

## Publish the changelog

`update-changelog.sh` is on PATH from dev_scripts. It reads `.env.wordpress` in the
project root (gitignored: site, credentials, KB post id, `CHANGELOG_FILE`) and finds
`stop-wp-emails-going-to-spam/changelog.txt` itself. Only some plugins have that file.

```bash
if [ -f $P/.env.wordpress ]; then (cd $P && update-changelog.sh); else echo "no .env.wordpress: KB changelog not published for this plugin"; fi
```

A non-zero exit means the KB update failed. The release has already shipped, so report it
and carry on to YouTrack; do not re-tag or re-run the release.

## YouTrack

If `$KEY` is empty, skip this step and say so: no `.env.youtrack` `YOUTRACK_PROJECT` and no
`youtrack_project` pin in `.tooling.json`.

Issues in the release: the `Issues Included` table in `.sdlc/releases/$V/RELEASE_NOTES.md`,
else ids at the start of commit subjects in range
(`git -C $P log --format=%s $PREV..$TAG | grep -oE "^$KEY-[0-9]+" | sort -u`), not body
mentions.

Decide per issue whether it shipped plugin code: list the paths its commits in range touch,
and check whether any is inside `stop-wp-emails-going-to-spam/`. Decide by path, never by commit subject:

```bash
ID=<issue id>   # \b keeps QPP-6 from matching QPP-61
for c in $(git -C $P log --format=%H --grep="^$ID\b" -E $PREV..$TAG); do
  git -C $P diff-tree --no-commit-id --name-only -r $c
done | grep -q '^stop-wp-emails-going-to-spam/' && echo shipped || echo non-shipping
```

For each issue:

- Stage: `Deployed`, **only if it shipped plugin code**. An issue whose commits in range touch
  only paths outside `stop-wp-emails-going-to-spam/` (tests, tooling, marketing, docs) keeps its Stage as it is.
- Resolution: `Done`, if the issue is not already resolved.
- Fix versions: `$V`, only if that version already exists in the project's Fix versions
  bundle (check the field schema with `get_issue_fields_schema`). If it does not, say so in
  the report and leave the field alone; never create the version.
- Comment, on every issue in range including non-shipping ones: `Released in $V`, with the
  GitHub release link (`https://github.com/alanef/stop-wp-emails-going-to-spam/releases/tag/$TAG`) and, for anything
  user-visible, one line on what changed.

## Tell the user what is still manual

Always end with these, explicitly:

- **Confirm the release on wordpress.org.** Release confirmation holds `$V` until a
  committer approves it from the confirmation email or the plugin's release confirmation
  page. Until then the directory still serves `$PREV`.
- Any server side follow-ups recorded in the release notes.

Then report: tag, release.yml run, what was confirmed, changelog result, YouTrack updates.
