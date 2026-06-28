You are a senior WordPress, SEO, technical marketing, and migration auditor.

Project context:
- The existing amores-perros.de website has been downloaded from FTP into `./amores-perros`.
- Existing project documentation is under `./docs`.
- The goal is to fully document the current website so it can later be rebuilt with Codex and WordPress using a much better structure, SEO strategy, content strategy, and conversion strategy.
- The current website has weak SEO reach, unclear marketing structure, and likely technical/content issues.
- Do not rebuild the website yet.
- Do not delete or overwrite existing documentation.
- Extend the existing documentation under `./docs`.

Your task:
Analyze the complete existing website in `./amores-perros`, including all pages, content, products, metadata, assets, SEO signals, forms, scripts, styles, links, media, and any shop/product-related data.

Then create or extend documentation files inside `./docs` so the current state is fully captured and ready for a later WordPress rebuild.

Important requirements:
1. First inspect the repository structure.
2. Identify the framework/CMS/static structure currently used.
3. Find all HTML/PHP/JS/CSS/config/content files.
4. Extract all visible page content.
5. Extract all metadata:
   - title tags
   - meta descriptions
   - canonical URLs
   - Open Graph tags
   - Twitter cards
   - robots tags
   - schema.org / JSON-LD
   - headings H1-H6
   - image alt text
   - internal links
   - external links
   - redirects if detectable
6. Extract all products/services/offers/prices, including:
   - product/service name
   - price
   - duration
   - description
   - source file
   - target audience
   - current CTA
   - SEO weakness
   - recommended rebuild approach
7. Extract contact, legal and business information:
   - name
   - address
   - phone
   - email
   - opening hours
   - social links
   - imprint/legal pages
   - privacy/cookie pages
8. Analyze technical SEO:
   - URL structure
   - missing metadata
   - duplicate titles/descriptions
   - heading problems
   - broken or suspicious internal links
   - missing alt text
   - large/unoptimized images
   - render-blocking or excessive scripts/styles
   - sitemap/robots presence
   - favicon/app icons
   - mobile/responsive indicators
9. Analyze marketing and conversion:
   - value proposition
   - clarity of services
   - trust signals
   - CTAs
   - contact path
   - local SEO for Hamburg
   - pricing presentation
   - content gaps
   - offer hierarchy
10. Analyze WordPress rebuild implications:
   - recommended page hierarchy
   - reusable blocks/sections
   - custom post types if useful
   - product/service content model
   - SEO plugin metadata mapping
   - redirect plan from old URLs to new URLs
   - media migration plan
   - schema.org plan
11. Be careful with existing docs:
   - read existing files under `./docs`
   - extend them where appropriate
   - create new files only when needed
   - do not overwrite useful existing content
   - preserve previous recommendations and add findings from the FTP dump

Deliverables:
Create or update the following documentation files under `./docs`:

1. `./docs/current-site-inventory.md`
   - complete inventory of current files, pages, assets, forms, scripts, styles, and detected structure

2. `./docs/current-content-extraction.md`
   - extracted current page content
   - current headings
   - current CTAs
   - current service/product descriptions
   - current legal/contact text

3. `./docs/current-products-and-services.md`
   - all products, services, offers, prices, durations, conditions, source locations, and recommended rebuild treatment

4. `./docs/current-seo-audit.md`
   - technical SEO audit
   - metadata audit
   - heading audit
   - image alt audit
   - link audit
   - schema audit
   - sitemap/robots audit
   - duplicate/missing SEO issues

5. `./docs/current-marketing-audit.md`
   - positioning analysis
   - target audience analysis
   - conversion issues
   - trust issues
   - local SEO issues
   - offer clarity issues
   - recommended marketing improvements

6. `./docs/wordpress-rebuild-content-map.md`
   - map old pages/content/offers to proposed new WordPress pages
   - recommended slugs
   - page purpose
   - primary keyword
   - secondary keywords
   - CTA
   - source content to reuse
   - content to rewrite
   - content gaps

7. `./docs/wordpress-rebuild-technical-plan.md`
   - recommended WordPress theme/plugin strategy
   - recommended content types
   - SEO metadata mapping
   - schema.org plan
   - redirect plan
   - image/media migration plan
   - performance checklist
   - launch QA checklist

8. `./docs/rebuild-task-list.md`
   - actionable implementation tasks grouped by phase:
     - discovery
     - content rewrite
     - WordPress setup
     - SEO setup
     - design/components
     - migration
     - redirects
     - QA
     - launch

Documentation style:
- Use clear Markdown.
- Use tables where useful.
- Include source file paths for every extracted finding.
- Include severity levels for issues:
  - Critical
  - High
  - Medium
  - Low
- Separate facts found in the current website from recommendations.
- Do not invent facts that are not present in the files.
- If something cannot be determined from the FTP files, explicitly write “Not found in current FTP dump”.
- Use German for website-facing content recommendations.
- Use English for technical documentation and task descriptions.
- Keep the final docs practical for implementation.

Suggested analysis approach:
1. Print a short repository/file tree summary.
2. Search for common page/content files:
   - `.html`
   - `.php`
   - `.js`
   - `.css`
   - `.json`
   - `.xml`
   - `.txt`
   - `.md`
3. Search for SEO-relevant fields:
   - `<title`
   - `meta name="description"`
   - `canonical`
   - `og:`
   - `twitter:`
   - `schema.org`
   - `application/ld+json`
   - `robots`
   - `sitemap`
   - `h1`
   - `alt=`
4. Search for business/product terms:
   - Preis
   - €
   - Erstgespräch
   - Einzelstunde
   - Workshop
   - Seminar
   - Stammtisch
   - Supervision
   - DOGSpace
   - Mantrailing
   - Kontakt
   - Impressum
   - Datenschutz
5. Extract URLs and links.
6. Extract image paths and alt text.
7. Identify stale, duplicate, missing, or low-quality SEO data.
8. Generate the documentation files.
9. Print a concise final summary:
   - files created/updated
   - major findings
   - highest priority rebuild tasks
   - anything that could not be determined

Acceptance criteria:
- The docs folder contains a complete factual snapshot of the current website.
- Every important extracted item references its source file.
- Products/services/prices are documented separately.
- SEO and marketing weaknesses are documented with severity.
- A clear WordPress rebuild content map exists.
- A clear technical rebuild plan exists.
- A phased task list exists.
- No website rebuild or destructive changes are performed.