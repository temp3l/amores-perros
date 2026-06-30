# WordPress Rebuild Technical Plan

Date: 2026-06-28

Purpose: define a practical WordPress rebuild approach based on the current FTP export

## Recommended Build Strategy

### Platform direction

| Decision area | Recommendation | Why |
| --- | --- | --- |
| Theme approach | Use a lightweight custom block theme or a carefully constrained child theme with reusable patterns | The current site is small, content-led, and does not need a heavy page-builder dependency |
| Editor approach | Prefer Gutenberg blocks/patterns for standard pages | Services, prices, about, and contact content fit a page-and-pattern model |
| Content model | Use pages for core services, and introduce CPTs only where repeated content truly benefits | This keeps complexity appropriate for a local service business |
| Forms | Replace the current Blocs/PHP mail setup with a maintained WordPress form plugin and proper SMTP delivery | The current handlers use placeholder email targets |
| SEO | Use one maintained SEO plugin to control titles, descriptions, canonicals, sitemap, schema support, and social metadata | The current export has almost no usable SEO layer |

## Recommended WordPress Content Types

| Content type | Recommendation | Reason | Current source |
| --- | --- | --- | --- |
| Standard pages | Yes | Core architecture should be page-based | `index.html`, `home-1.html`, `contact-us.html` |
| Services CPT | Optional | Useful only if services will expand, share common fields, and need archives | Current offers list |
| Events / Workshops CPT | Recommended | Workshops, seminars, and trainer exchange are recurring/event-like items | `index.html`, `home-1.html` |
| Testimonials CPT | Optional but useful | Helpful if reviews and case examples are collected later | Not found in current FTP dump |
| FAQs CPT | Optional | Can be handled as page sections unless many FAQs are planned | Not found in current FTP dump |

## Recommended Field Model

| Entity | Fields |
| --- | --- |
| Service | Title, slug, hero heading, intro, problem, audience, approach, duration, price, conditions, CTA text, CTA link, FAQ, hero image, schema description |
| Event / Workshop | Title, slug, summary, audience, date, time, price, capacity, location, instructor, booking CTA, cancellation notes |
| About page | Intro, full biography, qualifications, training philosophy, portrait images, trust signals, CTA |
| Contact page | Email, phone, address, opening hours, service area, consent text, embedded map if used |

## SEO Metadata Mapping

| Current item | WordPress destination | Notes |
| --- | --- | --- |
| Title tag | SEO plugin page title field | Replace generic titles completely |
| Empty meta description | SEO plugin meta description field | Write unique local-intent descriptions |
| No canonical | SEO plugin canonical field | Set self-referencing canonicals by default |
| No OG/Twitter | SEO plugin social metadata fields | Add titles, descriptions, and share images |
| No schema | SEO plugin schema settings plus page-specific schema blocks where needed | Add LocalBusiness / Service / FAQ / Event / Breadcrumb schema |
| Footer-only business data | Site settings + contact page + schema | Normalize business NAP data once |

## Schema.org Plan

| Page / entity | Recommended schema |
| --- | --- |
| Sitewide business entity | `LocalBusiness` or the closest accurate supported subtype, plus contact details |
| Homepage | `WebSite`, `Organization`/business entity, `BreadcrumbList` if breadcrumbs are used |
| Service pages | `Service` |
| About page | `Person` plus business entity references |
| FAQ sections | `FAQPage` where genuinely useful |
| Workshops / seminars | `Event` |
| Contact page | `ContactPage` |

## Redirect Plan

| Old URL / file | New target | Notes |
| --- | --- | --- |
| `/index.html` | `/` | Primary homepage redirect |
| `/home-1.html` | `/` or the most relevant service page if some copy is split out | Use after final content selection |
| `/contact-us.html` | `/kontakt/` | Replace English template slug |
| `/about.html` | `/ueber-jacky-rebien/` | Current file is not a real about page |
| `/informationen.html` | `/impressum/` | Current file is not a real information page |
| `/https/amores-perrosde/abouthtml/über.html` | `/ueber-jacky-rebien/` | Redirect nested export artifact |

## Media Migration Plan

| Task | Recommendation |
| --- | --- |
| Preserve originals | Archive the FTP dump before editing or re-exporting assets |
| Select canonical images | Choose one preferred version per image rather than keeping parallel JPG and WEBP everywhere |
| Re-export hero/service images | Resize/crop for web use and create consistent aspect ratios |
| Replace weak alt text | Write descriptive German alt text that matches page intent |
| Add image metadata | Store caption/credit/alt data in the WordPress media library |
| Remove template leftovers | Exclude placeholder assets such as irrelevant stock alt text and unused variants |

## Performance Checklist

| Area | Recommendation |
| --- | --- |
| Theme weight | Avoid rebuilding with a heavy visual builder unless there is a clear business reason |
| Fonts | Limit font families and consider local/self-hosted delivery if appropriate |
| Images | Generate responsive sizes and modern formats; avoid multi-megapixel uploads without need |
| JS | Minimize front-end JS; remove preloader and unnecessary parallax if they do not add value |
| CSS | Keep component CSS scoped and avoid unused framework overhead where possible |
| Caching | Enable full-page cache, browser cache headers, and image optimization |
| Forms | Use SMTP and server monitoring so leads do not silently fail |

## Launch QA Checklist

| Stage | Checks |
| --- | --- |
| Content QA | Confirm final prices, service names, opening hours, legal names, email, and phone |
| SEO QA | Validate titles, descriptions, canonicals, schema, sitemap, robots, redirects, and open graph images |
| UX QA | Test mobile nav, contact flow, CTA visibility, and key service journeys |
| Technical QA | Check image compression, Core Web Vitals basics, broken links, and form delivery |
| Legal QA | Confirm Impressum, Datenschutz, consent text, and any required cookies/tools notices |
| Local QA | Verify address formatting, map data if used, and consistency with business listings |
