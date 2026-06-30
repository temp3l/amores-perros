# Codex Prompt — Analyze the Blocs Project and Reconcile It with Existing Documentation

You are working in the root of the Amores Perros rebuild repository.

The current website was created with Blocs and is not a WordPress website.

The repository contains:

```text
./amores-perros/
```

This directory contains the original Blocs project and/or associated website files.

Existing analysis and rebuild documentation is under:

```text
./docs/
```

Your task is to analyze the Blocs-specific project data and update the existing documentation only where the project reveals useful information that was unavailable or unclear from the exported website files.

Do not rebuild the website.

Do not create the WordPress environment.

Do not modify the Blocs project or legacy website files.

## Objectives

1. Identify all Blocs project files and associated asset directories.
2. Determine which parts of the project can be inspected safely as structured text or package contents.
3. Extract project-level page, design, metadata, asset, and interaction information.
4. Compare the Blocs project with the exported production website.
5. Identify hidden, unused, draft, missing, or divergent content.
6. Update the existing documentation with confirmed findings.
7. Record limitations where the Blocs project format cannot be interpreted reliably.

## Read-only rules

Treat all Blocs and production files as read-only.

Do not:

* open or rewrite the project through automated conversion tools
* execute embedded scripts
* modify project metadata
* rename, move, or delete project files
* expose FTP credentials or publishing settings
* copy secret values into documentation
* assume undocumented fields are understood
* attempt to reverse-engineer encrypted or proprietary binary structures

Use static inspection only.

## 1. Identify Blocs project artifacts

Search for:

```text
*.bloc
*.blocs
*.blocsproject
*.zip
*.package
```

Also identify:

* asset directories
* image directories
* font directories
* external resource references
* custom Blocs
* custom Brics
* generated exports
* backups
* autosaves
* alternate project versions

Document:

* file path
* file type
* size
* modification date where available
* likely purpose
* whether it is text, archive, package, or binary
* whether it can be inspected safely

Do not assume a file extension without confirming its actual type.

## 2. Safely inspect the project structure

Use non-destructive inspection such as:

* file type detection
* archive listing
* text extraction where the file is plain text
* structured JSON, XML, plist, or package inspection where applicable
* string searching without altering the file

Do not execute the project.

Do not attempt destructive conversion.

If the project is a package or archive, inspect a copy or list contents without modifying the source.

## 3. Extract project-level information

Where discoverable, extract:

* project name
* project version
* Blocs version
* page names
* page hierarchy
* page filenames
* home page
* navigation relationships
* page titles
* meta descriptions
* canonical settings
* social metadata
* page visibility or draft state
* reusable Blocs
* global areas
* shared headers and footers
* classes
* breakpoints
* colors
* typography
* spacing conventions
* grid and layout conventions
* forms
* interactions
* animations
* custom HTML
* custom CSS
* custom JavaScript
* short codes
* external resources
* favicon and application icons
* image optimization settings
* WebP settings
* export settings
* publishing settings without exposing credentials
* asset references
* embedded assets
* missing assets
* always-export assets

Classify findings as:

```text
Status: Confirmed
Status: Probable
Status: Unknown
```

Include source paths or project object references where practical.

## 4. Compare project and exported site

Compare the Blocs project with the deployed/exported website files.

Identify:

* project pages missing from production
* production pages missing from the project
* different page titles
* different meta descriptions
* changed headings or body content
* assets present only in the project
* assets present only in production
* custom code present only in production
* custom code present only in the project
* sections that are hidden or disabled
* duplicate or obsolete pages
* unused components
* missing external assets
* broken resource references
* manual edits made after export
* export-generated files that should not be treated as source

Do not assume that the project is newer than production solely from filenames.

Use file modification dates only as supporting evidence.

## 5. Extract design-system information

Document reusable design characteristics that may guide the WordPress rebuild:

* primary and secondary colors
* font families
* font sizes
* heading scale
* body text styles
* button styles
* border radii
* spacing scale
* container widths
* image treatments
* card patterns
* navigation patterns
* hero sections
* service sections
* testimonial sections
* contact sections
* footer patterns
* responsive behavior
* repeated layout structures

Distinguish between:

* design elements worth preserving
* elements requiring modernization
* accessibility problems
* inconsistent styling
* obsolete patterns
* Blocs-specific implementation details that should not be copied

Update the appropriate existing documentation instead of creating an isolated design audit unless necessary.

## 6. Analyze assets

Identify:

* embedded project assets
* externally linked assets
* assets missing from the FTP export
* original high-resolution images
* cropped variants
* logos
* icons
* fonts
* videos
* PDFs
* downloadable files
* unused project assets
* duplicated assets
* assets referenced only from custom code

Do not copy or modify assets.

Update media migration recommendations where relevant.

## 7. Analyze custom code and integrations

Inspect project-level custom code for:

* scripts
* styles
* third-party widgets
* forms
* analytics
* maps
* social embeds
* cookie tools
* tracking
* external APIs
* custom interactions
* custom Brics
* external fonts and stylesheets

Document:

* location
* purpose
* affected pages
* migration requirement
* privacy impact
* whether it should be retained, replaced, or removed

Never expose secret values.

## 8. Update existing documentation

Review and update where supported:

```text
docs/current-site-inventory.md
docs/current-content-extraction.md
docs/current-products-and-services.md
docs/current-seo-audit.md
docs/current-marketing-audit.md
docs/wordpress-rebuild-content-map.md
docs/wordpress-rebuild-technical-plan.md
docs/rebuild-task-list.md
docs/questions/before-rebuild.md
```

Do not replace existing documents.

Do not repeat already documented findings.

Add only material new evidence, corrections, or migration implications.

## 9. Optional Blocs-specific documentation

Create this file only if the findings justify a dedicated document:

```text
docs/legacy/blocs-project-analysis.md
```

It should contain:

* identified project artifacts
* Blocs project version where discoverable
* inspectable project structure
* project-versus-production differences
* reusable design patterns
* hidden or unused content
* asset findings
* custom code findings
* migration implications
* analysis limitations

Do not create generic boilerplate.

## 10. Limitations

Clearly state when information cannot be determined because:

* the project file is binary or proprietary
* external assets are missing
* the project depends on unavailable custom Brics
* the project was created with a different Blocs version
* the FTP export was manually modified
* publishing credentials are unavailable
* the project lacks embedded assets
* the fresh Blocs export is unavailable

Use:

```text
Not determinable from static inspection of the current Blocs project.
```

when applicable.

## Validation

Before completion:

1. Verify no Blocs or production file changed.
2. Review the Git diff.
3. Verify referenced paths.
4. Verify no credentials or publishing secrets entered documentation.
5. Verify existing docs were extended rather than replaced.
6. Verify facts and recommendations remain separate.
7. Verify uncertain interpretations are clearly labeled.
8. Verify the task list includes any newly discovered migration dependencies.

## Final response

Report:

* Blocs project artifacts found
* information successfully extracted
* project-versus-production differences
* useful design and content findings
* missing or external assets
* custom code and integrations
* documents updated
* new documents created
* migration risks
* unresolved limitations
* confirmation that legacy files were not modified

Do not rebuild the website.

