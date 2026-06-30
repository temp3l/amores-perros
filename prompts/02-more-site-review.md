# Codex Prompt — Verify the Non-WordPress Legacy Website Analysis and Close Migration Gaps

You are working in the root of the Amores Perros website rebuild repository.

The existing production website was downloaded from FTP into:

```text
./amores-perros/
```

The current website is **not a WordPress website**.

Existing audit, extraction, and rebuild-planning documentation is under:

```text
./docs/
```

A broad content, SEO, marketing, product, and migration analysis has already been completed.

Do not repeat the full initial audit.

Your task is to verify the existing documentation against the legacy website files, identify material omissions and contradictions, and update the documentation so it is technically complete and ready to guide a future WordPress rebuild.

Do not rebuild the website.

Do not create the WordPress environment.

Do not modify any file under `./amores-perros/`.

## Existing documentation

Read every existing Markdown file under `./docs`, including:

```text
docs/amores-perros-seo-marketing-audit.md
docs/current-content-extraction.md
docs/current-marketing-audit.md
docs/current-products-and-services.md
docs/current-seo-audit.md
docs/current-site-inventory.md
docs/rebuild-task-list.md
docs/wordpress-rebuild-content-map.md
docs/wordpress-rebuild-technical-plan.md
docs/business/mantrailing-service-strategy.md
docs/questions/before-rebuild.md
```

Preserve useful content.

Update existing files in place.

Do not create duplicate documents named `v2`, `final`, `updated`, or similar.

## Primary objectives

1. Verify the existing analysis against the downloaded website.
2. Determine the actual legacy architecture and runtime model.
3. Identify undocumented forms, integrations, dynamic behavior, and dependencies.
4. Identify security, integrity, and migration risks.
5. Reconcile contradictions across existing documentation.
6. Refine the WordPress migration plan.
7. Refine the rebuild task list with priorities, dependencies, risks, and acceptance criteria.
8. Record questions that cannot be answered from the FTP snapshot.

## Read-only legacy policy

Treat:

```text
./amores-perros/
```

as a read-only production snapshot.

You may inspect and search its files.

You must not:

* modify, format, move, rename, or delete files
* execute legacy PHP, JavaScript, shell scripts, binaries, or unknown files
* start the legacy website
* upload or transmit repository contents
* expose credentials, tokens, personal data, or secret values
* copy legacy code into the future implementation
* commit files from the legacy directory

Verify before and after the task that no legacy file changed.

## 1. Identify the actual legacy architecture

Determine where possible:

* static HTML versus server-rendered pages
* PHP or another backend runtime
* framework, CMS, site generator, or custom implementation
* templating system
* shared includes and partials
* routing model
* server configuration
* rewrite rules
* generated versus source files
* data files
* content storage approach
* build tooling
* package managers
* deployment assumptions
* hosting-specific dependencies

Inspect relevant files such as:

```text
.htaccess
web.config
composer.json
package.json
gulpfile.*
webpack.*
vite.config.*
config.*
*.php
*.html
*.json
*.xml
```

Do not infer a framework only from directory names.

Classify important findings as:

```text
Status: Confirmed
Status: Probable
Status: Unknown
```

Include safe source paths.

## 2. Analyze templates and reusable structure

Identify:

* shared headers and footers
* navigation implementation
* reusable page sections
* layout templates
* service or product templates
* form components
* gallery components
* sliders
* accordions
* modal dialogs
* reusable calls to action
* shared SEO includes
* shared tracking includes
* duplicated markup
* hardcoded content
* hardcoded URLs and filesystem paths
* embedded styles and scripts

Document which elements should become:

* WordPress theme templates
* template parts
* block patterns
* reusable blocks
* global styles
* navigation menus
* widget only when justified
* project plugin functionality
* content managed through the WordPress editor

## 3. Analyze dynamic behavior

Inspect JavaScript and backend scripts for:

* dynamically inserted content
* navigation behavior
* form validation
* form submission
* AJAX or fetch requests
* API calls
* maps
* galleries
* sliders
* cookie banners
* tracking
* social integrations
* booking links
* email handling
* redirects
* client-side routing
* local storage and cookies
* third-party widgets
* hidden or conditional content

For every material behavior, document:

* source path
* purpose
* external dependency
* data sent or received
* migration recommendation
* WordPress replacement target
* privacy implications
* failure risk

Do not execute external requests.

## 4. Forms and lead-generation analysis

Inventory every form and submission path.

Identify where possible:

* form location
* form fields
* required fields
* validation
* target script or external provider
* email recipients without exposing private addresses unnecessarily
* spam protection
* consent fields
* success and error behavior
* redirect after submission
* stored data
* attachments
* privacy implications

Document whether each form should be rebuilt using:

* a maintained WordPress forms plugin
* project-owned plugin functionality
* an external booking or CRM integration
* a simple mail link only when appropriate

Do not submit forms.

Do not expose personal data.

## 5. External integration inventory

Search for:

* analytics identifiers
* tag managers
* map providers
* social embeds
* fonts
* CDNs
* booking systems
* payment systems
* newsletter systems
* CRM integrations
* CAPTCHA
* consent platforms
* email services
* API endpoints
* iframe embeds
* video providers
* external JavaScript
* external CSS

For each integration, document:

* provider
* purpose
* source path
* affected page or feature
* privacy impact
* cookie/consent impact
* migration decision
* whether it remains necessary

Redact API keys and identifiers where appropriate.

## 6. Dependency and licensing inventory

Identify local and third-party dependencies:

* JavaScript libraries
* CSS frameworks
* PHP libraries
* icon sets
* fonts
* templates
* stock assets
* plugins or widgets belonging to another system
* copied vendor files

Record where discoverable:

* name
* version
* license
* source path
* usage
* maintenance status
* migration recommendation

Flag:

* obsolete dependencies
* unlicensed or unclear assets
* locally modified vendor code
* libraries with known unsafe patterns
* dependencies that should not be copied into the rebuild

Do not make definitive licensing claims when evidence is incomplete.

## 7. Static security and integrity review

Perform static inspection only.

Search for:

* hardcoded passwords
* API keys
* SMTP credentials
* database credentials
* backup files
* database exports
* debug logs
* temporary files
* publicly accessible configuration
* unsafe file permissions where represented
* `eval`
* `base64_decode`
* `gzinflate`
* dynamic includes
* remote includes
* unsafe SQL
* command execution
* arbitrary file uploads
* missing input validation
* missing output escaping
* exposed email scripts
* open redirects
* outdated libraries
* PHP files in media or upload directories
* suspicious duplicate files
* compromised or obfuscated code

Never copy secret values into documentation.

Classify findings by severity:

* Critical
* High
* Medium
* Low
* Informational

Classify confidence:

* Confirmed issue
* Suspicious pattern
* Maintenance risk
* Requires manual verification

Create this file if necessary:

```text
docs/legacy/security-and-integrity-review.md
```

## 8. File hygiene and deployable-source analysis

Identify:

* backup copies
* dated copies
* temporary files
* editor swap files
* generated files
* minified duplicates
* unused scripts
* unused styles
* orphan pages
* obsolete assets
* duplicate images
* server logs
* caches
* archived versions
* files that appear publicly accessible but should not be

Separate:

* actual production source
* generated production output
* content assets
* server-only files
* obsolete files
* suspicious files

Update:

```text
docs/current-site-inventory.md
```

with this classification.

## 9. Verify content and SEO findings

Do not repeat the full content extraction.

Instead, verify that the existing documentation includes:

* every public page
* hidden or orphan pages
* alternate page variants
* all service and product pages
* legal pages
* contact paths
* metadata
* canonical behavior
* robots directives
* schema markup
* headings
* image alt text
* internal links
* external links
* sitemap and robots files
* redirects and rewrite behavior
* JavaScript-inserted SEO-relevant content

Correct only material omissions or inaccuracies.

Clearly distinguish:

* facts found in files
* inferred behavior
* facts requiring live-site verification

## 10. Reconcile existing documents

Compare all existing documentation for:

* conflicting page names
* conflicting URLs or slugs
* conflicting prices
* conflicting service descriptions
* contradictory target audiences
* duplicate recommendations
* inconsistent technical recommendations
* inconsistent WordPress migration recommendations
* unsupported business claims
* inconsistent Hamburg or service-area references
* contradictory redirect mappings

When correcting an issue:

1. preserve useful context
2. correct the inaccurate statement
3. add a concise correction note when material
4. reference supporting source paths
5. move unresolved issues into the questions document

Do not silently delete important prior conclusions.

## 11. Refine the WordPress migration mapping

Update:

```text
docs/wordpress-rebuild-content-map.md
docs/wordpress-rebuild-technical-plan.md
```

For each material legacy feature or content type, map it to one of:

* standard WordPress page
* WordPress post
* custom post type
* taxonomy
* custom field
* navigation menu
* reusable block
* block pattern
* theme template
* theme template part
* `amores-perros-core` plugin functionality
* maintained third-party plugin
* external service
* removed legacy behavior

Avoid unnecessary custom post types, custom fields, and plugins.

Document:

* migration source
* target representation
* migration complexity
* manual work required
* dependencies
* acceptance criteria
* SEO implications
* redirect implications

## 12. Update unresolved questions

Update:

```text
docs/questions/before-rebuild.md
```

Group questions under:

* Business
* Services
* Pricing
* Content
* Contact information
* Legal and privacy
* SEO
* Branding and design
* Forms
* External integrations
* Hosting
* WordPress architecture
* Migration

Do not duplicate existing questions.

Do not invent answers.

## 13. Refine the rebuild task list

Update:

```text
docs/rebuild-task-list.md
```

Each material task should include:

* priority
* phase
* dependencies
* objective
* relevant documentation
* acceptance criteria
* migration risk

Use:

* P0 — blocker or critical risk
* P1 — required for launch
* P2 — important improvement
* P3 — optional or post-launch

Organize tasks into:

1. unresolved decisions
2. repository and local environment
3. content architecture
4. WordPress foundation
5. theme foundation
6. reusable components
7. project plugin functionality
8. forms and integrations
9. content migration
10. media migration
11. SEO metadata and redirects
12. accessibility
13. performance
14. security
15. QA
16. launch
17. post-launch validation

Do not mark implementation tasks complete during this analysis.

## Optional focused documents

Create these only where they add information not already represented:

```text
docs/legacy/
├── architecture-and-runtime-inventory.md
├── templates-and-components.md
├── forms-and-integrations.md
├── dependency-and-license-inventory.md
├── security-and-integrity-review.md
├── migration-dependency-map.md
└── evidence-index.md
```

Do not create empty boilerplate files.

## Evidence and limitation rules

For important findings use:

```text
Status: Confirmed | Probable | Unknown
Source: amores-perros/path/to/file
```

Explicitly state when a fact requires:

* live-site access
* server configuration not present in the FTP dump
* form submission testing
* analytics access
* Search Console access
* database access
* hosting control-panel access

Use:

```text
Not determinable from the current FTP snapshot.
```

where appropriate.

## Validation

Before completion:

1. Verify every original documentation file still exists.
2. Verify no file under `./amores-perros/` changed.
3. Review the complete Git diff.
4. Verify referenced source paths.
5. Check Markdown links where practical.
6. Verify no secrets or personal data were copied.
7. Verify no legacy binaries, backups, or generated files were added to Git.
8. Verify facts and recommendations remain separate.
9. Verify unresolved questions are centralized.
10. Verify migration tasks are actionable.
11. Verify the documentation does not describe the current site as WordPress.

## Final response

Report:

* documents updated
* documents created
* important omissions found
* contradictions corrected
* legacy architecture identified
* dynamic features and integrations found
* security or integrity concerns
* migration dependencies
* unresolved questions
* highest-priority rebuild tasks
* analysis limitations
* validation commands and results
* confirmation that `./amores-perros/` was not modified

Do not rebuild the website.

Complete the verification and documentation update only.

