# Codex Prompt — Bootstrap the Amores Perros WordPress Rebuild Repository

You are working in the root of the Amores Perros website rebuild repository.

Your task is to inspect the existing repository and implement a complete, maintainable local WordPress development environment using Docker Compose.

Do not stop after planning. Implement the setup, validate it, and update the documentation.

---

## Existing repository context

The repository already contains a complete legacy website snapshot downloaded from the production FTP server at:

```text
./amores-perrors/
```

Treat this directory as a read-only legacy reference.

The repository also already contains analysis and planning documentation:

```text
docs/
├── amores-perros-seo-marketing-audit.md
├── current-content-extraction.md
├── current-marketing-audit.md
├── current-products-and-services.md
├── current-seo-audit.md
├── current-site-inventory.md
├── rebuild-task-list.md
├── wordpress-rebuild-content-map.md
├── wordpress-rebuild-technical-plan.md
├── business/
│   └── mantrailing-service-strategy.md
└── questions/
    └── before-rebuild.md
```

These documents are existing project knowledge and must be preserved.

Do not repeat the full website audit unless required to resolve a contradiction or missing implementation detail.

Use these documents as the source of truth for:

- business goals
- existing content
- products and services
- SEO requirements
- marketing requirements
- rebuild scope
- target site structure
- unresolved questions
- migration requirements
- technical recommendations

Before implementing anything, read all of these documents and reconcile their recommendations.

When recommendations conflict:

1. Document the conflict.
2. Prefer the most specific and most recent project document.
3. Prefer the solution that best supports:
   - SEO effectiveness
   - usability
   - maintainability
   - security
   - performance
   - compatibility with standard managed WordPress hosting
4. Record important architectural decisions under `docs/architecture/decisions/`.

Do not overwrite existing documentation with generic boilerplate.

---

# Primary goals

Set up:

1. A reliable local WordPress development environment using Docker Compose.
2. A maintainable repository structure for:
   - custom theme development
   - custom plugins
   - must-use plugins
   - configuration
   - scripts
   - documentation
   - tests
   - backups
   - deployment packages
3. A complete root `AGENTS.md` for Codex and other coding agents.
4. Safe configuration and secret handling.
5. Developer-friendly commands for setup, startup, shutdown, reset, backup, restore, database import/export, linting, testing, and packaging.
6. A deployment workflow compatible with production hosting where only FTP/SFTP and possibly phpMyAdmin are available.
7. Clear separation between:
   - the legacy site snapshot
   - the new source code
   - local runtime data
   - deployment artifacts
   - project documentation

---

# Critical constraints

The production site may only provide:

- FTP or SFTP access
- WordPress administration access
- phpMyAdmin or another database administration interface

Therefore:

- Docker is for local development only.
- Production must not depend on Docker.
- Production must not require Node.js, Composer, WP-CLI, SSH, or build tooling.
- All production build artifacts must be generated locally.
- The custom theme and plugins must run on a standard WordPress installation.
- Do not modify WordPress core.
- Do not copy the legacy site wholesale into the new environment.
- Do not make the new implementation depend on the legacy directory.
- Do not include local configuration in deployment packages.
- Do not include credentials, salts, logs, caches, sessions, backups, or private data in Git or documentation.
- Avoid unnecessary plugins and page builders.
- Do not introduce Elementor, Divi, WPBakery, or another page builder unless an existing project document explicitly requires it.
- Prefer native WordPress blocks, reusable patterns, theme templates, and project-owned code.
- Keep the implementation portable between local Docker and ordinary shared WordPress hosting.

---

# Legacy snapshot rules

The directory:

```text
./amores-perrors/
```

contains the downloaded production website.

Agents may:

- inspect and search it
- compare it with existing documentation
- locate legacy content, media, themes, plugins, and custom code
- verify existing findings
- identify migration dependencies
- inspect template structure
- inspect plugin integrations
- inspect media paths
- inspect custom post types, taxonomies, menus, shortcodes, and widgets
- identify hardcoded domains and paths
- identify compatibility and security concerns

Agents must not:

- modify files inside `./amores-perrors/`
- format files inside it
- move or rename files inside it
- delete files inside it
- execute unknown PHP or shell scripts from it
- run the legacy site as the new development environment
- copy WordPress core files from it
- copy plugins or themes without review
- copy credentials, salts, sessions, logs, cache files, or private data
- treat legacy code as secure or authoritative
- use it as the deployment source
- commit it to Git

The directory must be excluded from Git but remain available for Codex inspection.

Add this to `.gitignore`:

```gitignore
# Read-only legacy production website snapshot
/amores-perrors/
```

The new implementation under `src/` is the source of truth.

---

# Required target repository structure

Create or adapt the repository toward:

```text
.
├── AGENTS.md
├── README.md
├── .env.example
├── .gitignore
├── .editorconfig
├── .gitattributes
├── compose.yaml
├── Makefile
├── package.json
├── composer.json
│
├── amores-perrors/                  # legacy snapshot, ignored, read-only
│
├── config/
│   ├── php/
│   │   ├── php.ini
│   │   └── uploads.ini
│   └── wordpress/
│       └── wp-config-local.php
│
├── docker/
│   ├── wordpress/
│   │   └── Dockerfile
│   └── scripts/
│       ├── entrypoint.sh
│       └── healthcheck.sh
│
├── src/
│   └── wp-content/
│       ├── themes/
│       │   └── amores-perros/
│       ├── plugins/
│       │   └── amores-perros-core/
│       └── mu-plugins/
│
├── runtime/
│   ├── uploads/
│   └── logs/
│
├── scripts/
│   ├── setup.sh
│   ├── start.sh
│   ├── stop.sh
│   ├── restart.sh
│   ├── reset.sh
│   ├── doctor.sh
│   ├── wp.sh
│   ├── db-export.sh
│   ├── db-import.sh
│   ├── backup.sh
│   ├── restore.sh
│   ├── package-theme.sh
│   ├── package-plugin.sh
│   └── package-deployment.sh
│
├── docs/
│   ├── README.md
│   ├── amores-perros-seo-marketing-audit.md
│   ├── current-content-extraction.md
│   ├── current-marketing-audit.md
│   ├── current-products-and-services.md
│   ├── current-seo-audit.md
│   ├── current-site-inventory.md
│   ├── rebuild-task-list.md
│   ├── wordpress-rebuild-content-map.md
│   ├── wordpress-rebuild-technical-plan.md
│   │
│   ├── business/
│   │   └── mantrailing-service-strategy.md
│   │
│   ├── questions/
│   │   └── before-rebuild.md
│   │
│   ├── architecture/
│   │   ├── overview.md
│   │   ├── repository-structure.md
│   │   ├── wordpress-boundaries.md
│   │   ├── content-architecture.md
│   │   ├── seo-architecture.md
│   │   └── decisions/
│   │       ├── ADR-001-local-docker-wordpress.md
│   │       ├── ADR-002-theme-plugin-boundary.md
│   │       └── ADR-003-managed-hosting-deployment.md
│   │
│   ├── development/
│   │   ├── local-setup.md
│   │   ├── commands.md
│   │   ├── coding-standards.md
│   │   ├── debugging.md
│   │   └── troubleshooting.md
│   │
│   ├── deployment/
│   │   ├── ftp-deployment.md
│   │   ├── database-migration.md
│   │   ├── media-migration.md
│   │   ├── release-checklist.md
│   │   └── rollback.md
│   │
│   ├── security/
│   │   ├── security-baseline.md
│   │   └── secrets-and-configuration.md
│   │
│   └── codex/
│       ├── repository-map.md
│       ├── task-workflow.md
│       ├── implementation-priorities.md
│       └── definition-of-done.md
│
├── tests/
│   ├── smoke/
│   └── integration/
│
├── backups/
│   └── .gitkeep
│
└── artifacts/
    └── .gitkeep
```

Only create `package.json`, `composer.json`, or a custom Dockerfile when they provide executable value.

Document every meaningful deviation from this structure.

---

# Docker Compose requirements

Create `compose.yaml` with:

- WordPress
- MariaDB or MySQL
- WP-CLI
- Mailpit
- phpMyAdmin only if justified

Requirements:

- Use explicit stable image versions.
- Do not use `latest`.
- Use a named database volume.
- Use a dedicated network.
- Load configuration from `.env`.
- Add health checks.
- Use service dependency health conditions where supported.
- Do not expose the database port to the host unless explicitly needed.
- Make the WordPress port configurable.
- Make the Mailpit port configurable.
- Make phpMyAdmin configurable if included.
- Bind-mount only project-owned WordPress source directories.
- Keep WordPress core in Docker-managed runtime storage.
- Persist uploads locally under `runtime/uploads/` or a named volume.
- Avoid root-owned repository files.
- Configure PHP upload, execution, memory, and post size limits appropriate for local WordPress development.
- Configure local email delivery through Mailpit.
- Ensure WP-CLI communicates with the WordPress container.
- Ensure normal container restart preserves database and uploads.
- Ensure a full reset requires explicit confirmation.

---

# Environment configuration

Create `.env.example` containing documented placeholders:

```dotenv
COMPOSE_PROJECT_NAME=amores-perros

WORDPRESS_PORT=8080
MAILPIT_PORT=8025
PHPMYADMIN_PORT=8081

WORDPRESS_DB_NAME=wordpress
WORDPRESS_DB_USER=wordpress
WORDPRESS_DB_PASSWORD=change-me
WORDPRESS_DB_ROOT_PASSWORD=change-root-password
WORDPRESS_TABLE_PREFIX=wp_

WORDPRESS_ADMIN_USER=admin
WORDPRESS_ADMIN_PASSWORD=change-admin-password
WORDPRESS_ADMIN_EMAIL=admin@example.test
WORDPRESS_SITE_TITLE=Amores Perros Local
WORDPRESS_SITE_URL=http://localhost:8080

WP_ENVIRONMENT_TYPE=local
WP_DEBUG=true
WP_DEBUG_LOG=true
WP_DEBUG_DISPLAY=false
SCRIPT_DEBUG=true

WORDPRESS_TIMEZONE=Europe/Berlin
```

Requirements:

- Never commit `.env`.
- Never put production credentials in `.env.example`.
- Never reuse secrets discovered in the legacy snapshot.
- Validate required variables before setup.
- Document all variables.
- Keep environment-specific values out of theme and plugin code.

---

# Idempotent setup workflow

Implement `make setup` and `scripts/setup.sh`.

It must:

1. Validate required commands.
2. Validate `.env`.
3. Validate required variables.
4. Start Docker services.
5. Wait for database readiness.
6. Wait for WordPress readiness.
7. Install WordPress only when it is not already installed.
8. Configure:
   - `siteurl`
   - `home`
   - site title
   - admin account
   - permalink structure `/%postname%/`
   - timezone `Europe/Berlin`
   - local search-engine discouragement
   - local debug behavior
9. Activate the new Amores Perros theme when available.
10. Activate the core project plugin when available.
11. Flush rewrite rules.
12. Print useful local URLs and commands.

Normal setup must never erase an existing database.

---

# Theme scaffold

Create:

```text
src/wp-content/themes/amores-perros/
```

Use the existing documentation to determine the intended site structure and content architecture.

Create a minimal, maintainable custom block theme or classic theme based on the recommendations already documented in:

- `docs/wordpress-rebuild-technical-plan.md`
- `docs/wordpress-rebuild-content-map.md`
- `docs/current-content-extraction.md`
- `docs/current-products-and-services.md`
- `docs/current-seo-audit.md`

Do not arbitrarily choose a theme architecture without reading those files.

At minimum, include the required WordPress theme files for the chosen architecture.

For a classic theme, include:

```text
style.css
functions.php
index.php
front-page.php
home.php
header.php
footer.php
page.php
single.php
archive.php
404.php
search.php
inc/
template-parts/
assets/css/
assets/js/
assets/images/
languages/
```

For a block theme, include:

```text
style.css
theme.json
functions.php
templates/
parts/
patterns/
assets/
languages/
```

Theme requirements:

- semantic HTML
- accessible navigation
- responsive layout
- mobile-first behavior
- strong Core Web Vitals defaults
- no render-blocking dependency bloat
- no unnecessary frontend framework
- no jQuery dependency unless required
- escape dynamic output
- sanitize and validate inputs
- use native WordPress APIs
- use file modification times for local asset cache busting
- support title tags
- support featured images
- support responsive embeds
- support custom logo
- support editor styles where appropriate
- register menus and required image sizes
- keep business logic outside the theme
- implement reusable template parts or block patterns
- align page templates with the documented content map
- provide SEO-friendly heading and landmark structure
- avoid hardcoded production URLs

Do not implement all final page content unless the existing rebuild task list explicitly calls for it as part of setup.

The setup phase should establish the architecture and a functional baseline.

---

# Core project plugin scaffold

Create:

```text
src/wp-content/plugins/amores-perros-core/
```

Purpose:

- project-owned functionality that must survive theme changes
- custom post types
- taxonomies
- structured data support
- reusable business behavior
- integrations
- administrative functionality

Only implement features justified by existing documentation.

Recommended structure:

```text
amores-perros-core/
├── amores-perros-core.php
├── README.md
├── src/
│   ├── Plugin.php
│   ├── Admin/
│   ├── Content/
│   ├── Seo/
│   ├── Integrations/
│   └── Support/
└── languages/
```

Requirements:

- use namespaces
- avoid global functions where practical
- guard direct file access
- use hooks instead of core modifications
- do not add destructive uninstall behavior
- use activation hooks only when necessary
- keep presentation-specific code in the theme
- document the theme/plugin boundary
- do not duplicate functionality already provided by a deliberately selected SEO plugin

---

# AGENTS.md requirements

Create a comprehensive root `AGENTS.md`.

It must be tailored to this repository and include all of the following.

## Project purpose

Explain that the repository rebuilds the Amores Perros website with goals including:

- improved SEO
- clear information architecture
- user-friendly navigation
- maintainability
- performance
- accessibility
- secure WordPress implementation
- compatibility with managed hosting and FTP/SFTP deployment

## Sources of truth

Define:

```text
docs/current-*.md
docs/amores-perros-seo-marketing-audit.md
docs/wordpress-rebuild-content-map.md
docs/wordpress-rebuild-technical-plan.md
docs/rebuild-task-list.md
docs/business/
docs/questions/
```

as business, content, SEO, and rebuild sources of truth.

Define:

```text
src/wp-content/
```

as the implementation source of truth.

Define:

```text
amores-perrors/
```

as read-only legacy reference material.

## Repository map

Explain the purpose of:

- `amores-perrors/`
- `src/`
- `runtime/`
- `config/`
- `scripts/`
- `docs/`
- `tests/`
- `backups/`
- `artifacts/`

## Legacy snapshot policy

State explicitly:

- agents may inspect `amores-perrors/`
- agents must never modify it
- agents must never execute unknown code from it
- agents must never copy secrets from it
- agents must never commit it
- legacy code must be reviewed before reuse

## WordPress rules

Include:

- Never edit WordPress core.
- Never store business functionality only in the theme when it must survive a theme change.
- Never add a plugin merely to avoid implementing small, maintainable project-owned functionality.
- Never introduce a page builder unless explicitly requested.
- Use hooks and WordPress APIs.
- Escape output late.
- Sanitize input early.
- Validate all state-changing requests.
- Use nonces and capability checks.
- Use prepared queries through WordPress APIs.
- Avoid direct database access unless justified.
- Avoid hardcoded URLs and paths.
- Keep code compatible with the documented target PHP and WordPress versions.
- Preserve accessibility and semantic HTML.
- Keep frontend assets minimal.

## SEO rules

Require agents to:

- follow the documented content map
- preserve one clear search intent per page
- use one logical H1 per page
- maintain semantic heading order
- avoid duplicate pages and thin content
- preserve canonical URL strategy
- provide meaningful title and meta-description support
- preserve local SEO considerations
- use structured data only where valid
- avoid keyword stuffing
- optimize image alt text based on actual image purpose
- preserve redirects when URLs change
- update internal links when page slugs change
- consider Core Web Vitals in implementation decisions

## Content rules

Require agents to:

- use existing content extraction as the baseline
- not invent business facts, prices, certifications, availability, guarantees, or service areas
- mark unresolved claims for review
- preserve German language consistency unless a task explicitly introduces localization
- place unresolved business questions under `docs/questions/`
- avoid publishing legal or safety-sensitive claims without source confirmation

## Security rules

Include:

- never commit secrets
- never expose salts
- never copy production credentials
- never log sensitive information
- validate file uploads
- use least privilege
- review legacy plugins before reuse
- do not include backups in web-accessible deployment directories
- do not enable debug display in production
- do not trust imported HTML or shortcodes
- treat database import, reset, and search-replace as destructive
- do not execute unknown legacy code

## Coding standards

Include:

- WordPress Coding Standards
- PHP syntax validation
- namespaced plugin code
- small focused functions
- explicit documentation for non-obvious behavior
- no dead code
- no speculative abstraction
- no unnecessary dependency
- accessible and semantic templates
- deterministic build and packaging commands

## Commands

Document the exact commands created by this setup.

## Task workflow

Require agents to:

1. Read relevant source documents.
2. Inspect existing implementation.
3. Identify affected pages and architecture boundaries.
4. Implement the smallest complete solution.
5. Add or update tests.
6. Run applicable validation.
7. Update documentation.
8. Update `docs/codex/repository-map.md` after structural changes.
9. Update `docs/rebuild-task-list.md` only when task status changes.
10. Report assumptions and unresolved issues.

## Definition of done

A task is complete only when:

- implementation is functional
- no legacy source file was modified
- relevant lint and syntax checks pass
- smoke tests pass when applicable
- accessibility implications were considered
- SEO implications were considered
- documentation reflects the implementation
- deployment packaging still works
- no secrets or runtime artifacts were added
- final response lists files changed and validation performed

## Prohibited changes

Explicitly prohibit:

- modifying `amores-perrors/`
- editing WordPress core
- committing `.env`
- committing uploads, backups, or database dumps
- blindly copying legacy plugins or themes
- introducing a page builder without instruction
- changing business facts without documentation
- deleting existing docs
- rewriting existing audits without justification
- using production credentials locally
- automating destructive production database operations

---

# README requirements

Create a concise root `README.md` covering:

1. project purpose
2. repository structure
3. prerequisites
4. copying `.env.example` to `.env`
5. first-time setup
6. local URLs
7. common commands
8. WP-CLI usage
9. testing and linting
10. packaging deployable artifacts
11. links to detailed documentation
12. explicit warning that `amores-perrors/` is read-only legacy material

---

# Makefile command interface

Create targets:

```text
make setup
make start
make stop
make restart
make status
make logs
make doctor
make wp ARGS="..."
make shell
make db-shell
make db-export
make db-import FILE=...
make backup
make restore FILE=...
make reset
make lint
make format
make test
make smoke-test
make package-theme
make package-plugin
make package-deployment
```

Requirements:

- delegate complex logic to scripts
- fail clearly
- quote variables safely
- support spaces in paths where practical
- require explicit confirmation for destructive operations

Examples:

```bash
CONFIRM_RESET=yes make reset
CONFIRM_IMPORT=yes make db-import FILE=path/to/database.sql
CONFIRM_RESTORE=yes make restore FILE=path/to/backup.tar.gz
```

---

# Backup and restore

Implement local backup and restore.

Backup should include:

- database export
- uploads
- relevant local runtime metadata
- timestamped manifest
- checksums

Do not include:

- legacy snapshot
- Docker database internals
- secrets
- cache files
- logs unless explicitly requested

Restore must:

- validate the archive
- state what will be overwritten
- require confirmation
- create a pre-restore backup where practical

Generated backups must be ignored by Git.

---

# Deployment packaging

Implement local packaging for FTP/SFTP deployment.

Create:

```text
artifacts/deploy-YYYYMMDD-HHMMSS/
├── wp-content/
│   ├── themes/amores-perros/
│   ├── plugins/amores-perros-core/
│   └── mu-plugins/
├── manifest.txt
└── checksums.sha256
```

Requirements:

- exclude local configuration
- exclude `.env`
- exclude Git metadata
- exclude tests
- exclude development dependencies
- exclude source maps unless intentionally required
- exclude logs
- exclude caches
- exclude backups
- exclude legacy files
- exclude unbuilt source files not needed in production
- include all production assets
- include version or timestamp information

Do not automate upload to production unless an existing, reviewed deployment mechanism already exists.

Document manual FTP/SFTP deployment, activation, validation, rollback, and database migration.

---

# Database and content migration documentation

Document:

- production backup first
- serialized WordPress data
- safe WP-CLI search-replace locally
- why raw SQL URL replacement is unsafe
- handling site URL and home URL
- table prefixes
- users and credentials
- uploads migration
- media URL validation
- menus and widgets
- block content and shortcodes
- redirect mapping
- SEO metadata migration
- post-migration validation
- rollback procedure

Do not create a script that automatically overwrites production.

---

# Coding standards and tooling

Add Composer tooling when useful.

Recommended PHP tooling:

- PHP_CodeSniffer
- WordPress Coding Standards
- PHPCompatibility
- PHPStan only if configured meaningfully for WordPress

Add npm tooling only if actual frontend build or linting is needed.

If Composer is introduced, include commands such as:

```text
composer lint
composer lint:fix
composer analyse
```

If npm is introduced, include commands such as:

```text
npm run lint
npm run format
npm run build
```

Requirements:

- use pinned or constrained versions
- keep dependency footprint small
- do not require Composer or Node on production
- exclude `vendor/` and `node_modules/` from Git and deployment
- document local installation

---

# Health checks and tests

Create a `doctor` command that checks:

- Docker
- Docker Compose
- `.env`
- required variables
- port conflicts where practical
- container status
- database connectivity
- WordPress installation state
- theme presence
- plugin presence
- uploads writability
- local HTTP availability
- Mailpit availability

Create smoke tests for:

- home page response
- WordPress login page
- WordPress REST API
- Mailpit
- active theme
- active core plugin
- permalink response
- absence of obvious PHP fatal errors

Do not make tests depend on production.

---

# Security baseline

Document and implement appropriate defaults for:

- local secrets
- production secret handling
- admin credentials
- WordPress salts
- file permissions
- debug behavior
- plugin updates
- theme updates
- dependency scanning
- nonces
- capabilities
- sanitization
- escaping
- file uploads
- REST API exposure
- XML-RPC considerations
- backup protection
- deployment review
- legacy source review

Do not add aggressive production hardening that makes local development unreliable.

---

# Documentation integration

Preserve all existing documents.

Create missing operational and architectural documents, but do not duplicate existing content.

Add `docs/README.md` as a documentation index.

It must categorize:

- current-state audits
- business strategy
- content inventory
- rebuild planning
- architecture
- development
- deployment
- security
- Codex guidance
- open questions

Add cross-links between related documents.

Where an existing document already covers a topic, link to it rather than rewriting it.

Create `docs/codex/implementation-priorities.md` by deriving implementation order from:

- `docs/rebuild-task-list.md`
- `docs/wordpress-rebuild-technical-plan.md`
- `docs/wordpress-rebuild-content-map.md`
- `docs/current-seo-audit.md`
- `docs/current-marketing-audit.md`

Do not mark tasks complete merely because scaffolding exists.

---

# Validation requirements

Before completion:

1. Validate `compose.yaml`.
2. Validate shell scripts with `shellcheck` when available.
3. Validate PHP syntax.
4. Run PHP coding-standard checks.
5. Run configured static analysis.
6. Run frontend checks when configured.
7. Verify setup is idempotent.
8. Verify restart preserves database state.
9. Verify reset requires explicit confirmation.
10. Verify the legacy directory was not modified.
11. Verify packaging excludes legacy and local-only files.
12. Verify smoke tests.
13. Verify documentation paths and commands.
14. Verify `.gitignore` correctly ignores:
    - `.env`
    - `amores-perrors/`
    - runtime uploads
    - logs
    - backups
    - artifacts
    - database files
    - dependencies

If Docker cannot run in the execution environment, perform static validation and clearly report skipped runtime checks.

---

# Required implementation workflow

Follow this order:

1. Inspect the repository tree.
2. Read all existing documents listed above.
3. Inspect `amores-perrors/` only where needed to verify implementation details.
4. Record any conflicts or missing information.
5. Preserve existing documentation.
6. Create or adapt the target repository structure.
7. Implement Docker Compose.
8. Implement environment configuration.
9. Implement scripts and Makefile.
10. Scaffold the theme.
11. Scaffold the project plugin.
12. Configure validation tooling.
13. Create `AGENTS.md`.
14. Create missing architecture, development, deployment, security, and Codex documentation.
15. Create tests.
16. Validate the setup.
17. Confirm that `amores-perrors/` was not modified.
18. Report all created and modified files.
19. Report commands executed and results.
20. Report unresolved questions and recommended next task.

---

# Final response requirements

At completion, provide:

- concise implementation summary
- final repository tree
- exact first-run commands
- local URLs
- validation results
- assumptions
- unresolved conflicts found in existing documentation
- runtime checks that could not be performed
- files intentionally not created
- confirmation that `amores-perrors/` was not modified
- recommended next implementation task

Do not stop after generating a plan.

Implement the complete setup in the repository.
