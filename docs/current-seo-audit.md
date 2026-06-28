# Current SEO Audit

Date: 2026-06-28

Scope: technical SEO, metadata, headings, links, assets, and crawl signals found in the FTP dump

## Executive Summary

The current export is a small static Blocs site with multiple conflicting page variants, almost no meaningful SEO metadata, no structured data, no clear crawlable page architecture for individual services, and several weak or suspicious internal links. The site is indexable in the narrow sense because pages contain `meta name="robots" content="index, follow"`, but most ranking and click-through signals are either missing or low quality.

## Metadata Snapshot

| Page | Title | Meta description | Canonical | Open Graph | Twitter card | Robots | JSON-LD / schema | Source |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `index.html` | `Home` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/index.html` |
| `home-1.html` | `Home-1` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/home-1.html` |
| `contact-us.html` | `Contact Us` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/contact-us.html` |
| `about.html` | `about` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/about.html` |
| `informationen.html` | `about` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/informationen.html` |
| nested `über.html` | `About` | Empty | Not found in current FTP dump | Not found in current FTP dump | Not found in current FTP dump | `index, follow` | Not found in current FTP dump | `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## High-Priority Issues

| Severity | Issue | Evidence | Source |
| --- | --- | --- | --- |
| Critical | No service-specific crawlable URL structure | The current public content is mainly a homepage plus partial/duplicate pages. Offers such as Erstgespräch, Einzeltraining, DOGSpace, workshops, trainer exchange, and supervision do not have dedicated URLs | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/about.html`, `amores-perros/informationen.html` |
| High | Titles are generic or duplicate | `Home`, `Home-1`, `Contact Us`, `about`, `about`, `About` | Same files as above |
| High | Meta descriptions are empty on every HTML page | `meta name="description" content=""` on all pages | Same files as above |
| High | No canonical tags | None found on any page | Same files as above |
| High | No Open Graph or Twitter metadata | None found on any page | Same files as above |
| High | No schema.org / JSON-LD found | No `application/ld+json` blocks found | Same files as above |
| High | No H1 tags found anywhere | All meaningful section titles are H3/H4/H5 instead of a proper H1-led hierarchy | Same files as above |
| High | Duplicate and fragment-like pages are indexable | `about.html`, `informationen.html`, and nested `über.html` appear indexable but do not provide clean standalone value | `amores-perros/about.html`, `amores-perros/informationen.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Heading Audit

| Page | H1 | H2 | H3 | H4 | H5 | Issue summary | Source |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `index.html` | None | None | Section headings used as H3 | Service labels used as H4 | Prices and footer items used as H5 | Missing H1/H2 and weak semantic ladder | `amores-perros/index.html` |
| `home-1.html` | None | None | Section headings used as H3 | Service labels used as H4 | Prices and footer items used as H5 | Same issue as `index.html` | `amores-perros/home-1.html` |
| `contact-us.html` | None | None | `schreib mir eine nachricht`, `Opening Hours` | None | None | Missing H1; mixed-language headings | `amores-perros/contact-us.html` |
| `about.html` | None | None | None | None | Footer headings only | Not a meaningful content page | `amores-perros/about.html` |
| `informationen.html` | None | None | None | None | Footer headings only | Not a meaningful content page | `amores-perros/informationen.html` |
| nested `über.html` | None | None | `über mich` | `Jacky Rebien mit Waldemar Watson` | None | Missing H1 and shallow content | `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Image Alt Audit

| Page / image | Current alt text | Severity | Issue | Source |
| --- | --- | --- | --- | --- |
| `index.html` logo | `logo` | Low | Generic but acceptable for a logo | `amores-perros/index.html` |
| `index.html` `waldi im gespröch` | `waldi%20im%20gespröch` | Medium | File-name alt text instead of descriptive alt text | `amores-perros/index.html` |
| `index.html` `friedi.jpg` | `runi` | High | Wrong alt text | `amores-perros/index.html` |
| `index.html` / `home-1.html` portrait images | `wir` | Medium | Too vague for content images | `amores-perros/index.html`, `amores-perros/home-1.html` |
| nested `über.html` portrait | `Barber 1 young man with beard smiling and wearing a brown shirt` | High | Irrelevant stock-template alt text | `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Link Audit

| Severity | Link issue | Evidence | Source |
| --- | --- | --- | --- |
| High | Legacy absolute links to old mixed-case URL | Multiple links point to `http://www.amores-perros.de/About.html` | `amores-perros/index.html`, `amores-perros/about.html`, `amores-perros/contact-us.html`, `amores-perros/informationen.html`, nested `über.html` |
| High | Internal navigation collapses to the homepage | Many footer and nav items point to `index.html` regardless of offer label | `amores-perros/about.html`, `amores-perros/informationen.html` |
| High | Broken or suspicious local path variant | `about.html` links to `./https/amores-perrosde/abouthtml/über.html`, but the dumped file path uses the decomposed filename `über.html` | `amores-perros/about.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |
| Medium | Homepage nav uses JS-only scroll behaviour with `href="#"` | Less explicit for crawlers and less robust if JS fails | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Medium | Social links look partially templated | `twitter.com/`, `facebook.com/`, `twitter.com/blocsapp` are unlikely to be correct business profiles | `amores-perros/about.html`, `amores-perros/informationen.html`, `amores-perros/contact-us.html`, `amores-perros/index.html`, nested `über.html` |

## Technical SEO Audit

| Area | Severity | Findings | Source |
| --- | --- | --- | --- |
| URL structure | High | Root pages use generic names (`about.html`, `contact-us.html`, `informationen.html`, `home-1.html`), and key services have no URLs of their own | `amores-perros/` |
| Duplicate content risk | High | `index.html` and `home-1.html` share most content; `about.html` and `informationen.html` are partial duplicates; nested `über.html` duplicates “about” intent | Same as above |
| Sitemap | High | Not found in current FTP dump | `amores-perros/` |
| Robots.txt | High | Not found in current FTP dump | `amores-perros/` |
| Favicon / icons | Medium | Only `favicon.png` was found. No manifest, touch icons, or app icons found | `amores-perros/favicon.png` |
| Mobile / responsive | Low | Viewport meta, Bootstrap, and media queries indicate responsive intent | `amores-perros/index.html`, `amores-perros/style.css` |
| Structured data | High | Not found in current FTP dump | `amores-perros/` |
| Analytics | Medium | Pages contain empty `<!-- Analytics -->` placeholders; no active analytics snippet found | All HTML pages |

## Performance and Asset Observations

| Severity | Issue | Evidence | Source |
| --- | --- | --- | --- |
| High | Large original images | Multiple JPG/WEBP files exceed 500 KB and use multi-megapixel originals | `amores-perros/img/friedi.jpg`, `amores-perros/img/runi.jpg`, `amores-perros/img/waldi im gespröch.jpg`, `amores-perros/img/ich und waldi.webp` |
| Medium | Heavy render path for a small site | Bootstrap CSS, Ionicons CSS, Google Font, jQuery, Bootstrap JS, Blocs JS, validation JS, parallax JS, and preloader all load on pages | `amores-perros/index.html`, `amores-perros/contact-us.html`, `amores-perros/home-1.html` |
| Medium | Decorative preloader adds non-essential work | Page preloader references `pageload-spinner.gif` and injects UX delay complexity | `amores-perros/style.css`, `amores-perros/img/pageload-spinner.gif` |
| Low | Lazy-loading is implemented | `lazysizes.min.js` plus placeholder pixel are used consistently | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/js/lazysizes.min.js` |

## Redirects

| Item | Findings | Source |
| --- | --- | --- |
| Server redirects | Not found in current FTP dump. No `.htaccess`, Nginx config, or redirect map found | Repository root and `amores-perros/` |
| Redirect need | A rebuild will require redirects from `index.html`, `home-1.html`, `contact-us.html`, `about.html`, `informationen.html`, and the nested `https/.../über.html` path | Current page inventory |

## Recommended Rebuild Priorities

| Priority | Recommendation |
| --- | --- |
| 1 | Create a clean service URL architecture with one page per core offer |
| 2 | Replace all titles, descriptions, canonicals, and OG data with unique, query-led metadata |
| 3 | Introduce a valid H1/H2 structure on every page |
| 4 | Remove duplicate/fragment pages from the public architecture and set proper redirects |
| 5 | Add sitemap, robots.txt, schema, and real legal pages |
| 6 | Replace weak alt text and compress/re-crop core images |

