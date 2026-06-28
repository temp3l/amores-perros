# Rebuild Task List

Date: 2026-06-28

## Discovery

- Confirm the live source of truth for `Erstgespräch` pricing because `index.html` and `home-1.html` conflict.
- Confirm the correct Friday DOGSpace opening hour because `index.html` and `home-1.html` conflict.
- Confirm whether `DOGSpace`, `Hundecafé`, and `Stammtisch` are one offer or multiple offers.
- Confirm whether `Mantrailing` is an active public service or only an idea.
- Gather missing legal content for Impressum and Datenschutz.
- Gather full credentials, certifications, continuing education, and any legal business/training permits that should become trust signals.
- Collect real testimonials, before/after examples, FAQs, and local proof points if available.

## Content Rewrite

- Rewrite the homepage around a single local value proposition for Hamburg.
- Create a dedicated page draft for `Erstgespräch`.
- Create a dedicated page draft for `Einzeltraining`.
- Write a clear DOGSpace page that explains purpose, rules, and suitability.
- Write event-ready copy for workshops and seminars.
- Write professional-audience copy for trainer exchange and supervision if those offers remain active.
- Rewrite the biography into a tighter, more trust-oriented About page.
- Standardize offer naming, spelling, and tone across all pages.

## WordPress Setup

- Set up WordPress with a lightweight block-based theme approach.
- Create the core page architecture defined in `docs/wordpress-rebuild-content-map.md`.
- Create reusable blocks/patterns for hero, service intro, process, prices, CTA, and trust sections.
- Create an events content type if workshops/seminars need recurring entries.
- Configure a reliable form solution with SMTP delivery.

## SEO Setup

- Define one primary keyword and one user intent per page.
- Write unique titles and meta descriptions for every page.
- Add canonicals, social metadata, and XML sitemap support.
- Add structured data for LocalBusiness, Service, FAQ, Event, and ContactPage where appropriate.
- Create a clean robots.txt strategy.
- Prepare 301 redirects from all old exported URLs.

## Design / Components

- Design a homepage that immediately explains who the service is for and what happens next.
- Build a service page template with reusable sections for audience, process, pricing, FAQs, and CTA.
- Build an event page template for workshops and seminars.
- Build a trust section with biography, credentials, testimonials, and local relevance.
- Build a contact section with visible phone, email, address, hours, and privacy-safe form handling.

## Migration

- Migrate the usable text content from `index.html`, `home-1.html`, and nested `über.html`.
- Exclude fragment pages such as `about.html` and `informationen.html` from direct migration.
- Select one canonical image version per asset.
- Re-export and compress the chosen images for WordPress.
- Add proper German alt text and filenames where appropriate.

## Redirects

- Redirect `/index.html` to `/`.
- Redirect `/home-1.html` to the homepage or split-page targets after content finalization.
- Redirect `/contact-us.html` to `/kontakt/`.
- Redirect `/about.html`, `/informationen.html`, and `/https/amores-perrosde/abouthtml/über.html` to final public destinations.
- Test old absolute internal links and remove any remaining references to `http://www.amores-perros.de/About.html`.

## QA

- Validate all page content against the confirmed business facts.
- Check all forms for successful delivery and error handling.
- Check all internal links and redirect targets.
- Check metadata, schema, and sitemap output.
- Check mobile layout, image loading, and CTA visibility.
- Check that no placeholder social links or template copy remain.

## Launch

- Freeze final URLs and redirect rules.
- Submit sitemap to search engines after launch.
- Re-verify contact methods, legal pages, and opening hours on the live site.
- Monitor form submissions, crawl errors, and indexing signals during the first weeks after launch.
