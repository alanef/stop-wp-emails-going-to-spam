To  develop

Clone the repo

run npm install

run composer update

development is in /src  .

<!-- tooling:start (managed by wordpress-plugin-boilerplate/tooling - do not edit by hand) -->
## Development

This repository uses the standard Fullworks free-plugin tooling, documented in
[wordpress-plugin-boilerplate](https://github.com/alanef/wordpress-plugin-boilerplate/blob/main/CLAUDE.md).

[![Plugin Check](https://github.com/alanef/stop-wp-emails-going-to-spam/actions/workflows/checks.yml/badge.svg)](https://github.com/alanef/stop-wp-emails-going-to-spam/actions/workflows/checks.yml)

```
stop-wp-emails-going-to-spam/                     # repository root: development tooling
├── .github/workflows/             # checks.yml on push/PR, release.yml on tag
├── tests/                         # PHPUnit suite, run inside wp-env
├── .wp-env.json                   # dev :8740, tests :8741
├── composer.json                  # dev dependencies and quality scripts
├── package.json                   # wp-env and test scripts
├── phpunit.xml.dist / run-tests.sh
└── stop-wp-emails-going-to-spam/                # the plugin (shipped as-is via .distignore)
```

```bash
composer install && npm install        # dev tools
npm run start                          # http://localhost:8740  (admin / password)
composer run check                     # PHPCompatibility + security sniffs
npm test                               # PHPUnit in the wp-env tests container
composer run build                     # zipped/stop-wp-emails-going-to-spam-free.zip
```

Changes go in `stop-wp-emails-going-to-spam/changelog.txt` under `= Unreleased =`. Releases run through
`/tk-release X.Y.Z` then `/tk-deploy live` (see CLAUDE.md): the tag makes CI build the zip,
create the GitHub release and deploy wherever the readme `Type:` says.
<!-- tooling:end -->
