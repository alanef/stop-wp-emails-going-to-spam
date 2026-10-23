# Change Impact Assessment: 2.2.3

## Risk Level: Low

### Factors Considered
- Number of issues: 3 (one tooling-only)
- Security-sensitive changes: 0 in SWEGTS's own code. The library tightens Skip with a `manage_options` check.
- API changes: no
- Database changes: no new keys. The uninstall routine now also deletes `SWEGTS_form_rendered`.
- Breaking changes: no

## Affected Areas

### Code Areas
- Bundled `alanef/free_plugin_lib` (includes/vendor), 1.2.4 -> 1.3.3: opt-in notice, dismiss, redirect to the opt-in screen.
- `includes/class-uninstall.php`: one line, `Main::plugin_uninstall('SWEGTS')`.

### Configuration
- None.

### Dependencies
- alanef/free_plugin_lib constraint `^v1.0.0` -> `^1.3.3` (excludes the bad 1.3.1).

## Behaviour change users will notice
- Admins who left the opt-in screen without choosing are sent back there from SWEGTS's settings page until they choose.
- On multi-plugin sites, the plugins that never stored a choice may each ask once.
- The library class is shared and the first copy to load wins. CSCF, FSS, LHF, MMT, RSHFD, SSFGM and SUE all sort
  before SWEGTS, so on a site with one of them the library behaviour comes from that plugin's copy. SUE already
  ships 1.3.2.

## Rollback Plan

### Immediate Rollback
```bash
git revert <Release 2.2.3>..85c1e9d   # then release as 2.2.4; wp.org rollbacks ship as a new version
```

### Database Rollback
N/A

### Configuration Rollback
N/A

## Monitoring
- wp.org support forum for SWEGTS (notice/redirect reports)
