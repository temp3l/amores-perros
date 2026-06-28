# Current Site Inventory

Date: 2026-06-28

Scope: FTP dump in `./amores-perros`

## Repository Summary

| Area | Findings | Source |
| --- | --- | --- |
| Primary website folder | Static export in `amores-perros/` rather than a live WordPress codebase | `amores-perros/` |
| Existing docs | Only `docs/amores-perros-seo-marketing-audit.md` and `docs/business/mantrailing-service-strategy.md` existed before this audit | `docs/` |
| Extra project note | Small planning note in `info.md` about setup, domain finding, and this analysis task | `info.md` |

## Detected Site Architecture

### Facts

| Item | Findings | Source |
| --- | --- | --- |
| Build system / generator | The site appears to be exported from Blocs. CSS header says “Built with Blocs”, the JS form handler expects Blocs form conventions, and page markup uses `bloc`, `blocsapp`, and `scrollToTarget(...)` patterns | `amores-perros/style.css`, `amores-perros/js/formHandler.js`, `amores-perros/index.html` |
| CMS | Not found in current FTP dump. No `wp-content`, `wp-config.php`, theme folders, plugin folders, database export, or WordPress PHP templates were present | `amores-perros/` |
| Frontend stack | Bootstrap, jQuery, Ionicons, lazysizes, universal-parallax, and Blocs runtime JS | `amores-perros/css/bootstrap.min.css`, `amores-perros/js/jquery.min.js`, `amores-perros/js/bootstrap.bundle.min.js`, `amores-perros/js/blocs.min.js`, `amores-perros/js/lazysizes.min.js`, `amores-perros/js/universal-parallax.min.js` |
| Typography dependency | Google Fonts `Oswald` is loaded externally on all HTML pages | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/about.html`, `amores-perros/contact-us.html`, `amores-perros/informationen.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |
| Form processing | Static HTML forms post via AJAX to local PHP files in `includes/` | `amores-perros/js/formHandler.js`, `amores-perros/includes/*.php` |

## File Inventory

### Counts

| File type | Count | Notes | Source |
| --- | --- | --- | --- |
| HTML | 6 | Includes one hidden nested page copy under `https/amores-perrosde/abouthtml/` | `amores-perros/**/*.html` |
| PHP | 3 | Form handlers only | `amores-perros/includes/*.php` |
| JavaScript | 7 | Mostly minified vendor/runtime files plus one custom form handler | `amores-perros/js/*` |
| CSS | 3 | Bootstrap, Ionicons, site stylesheet | `amores-perros/css/*`, `amores-perros/style.css` |
| Images | 24 | JPG, JPEG, PNG, WEBP, GIF | `amores-perros/img/*`, `amores-perros/favicon.png` |
| Font files | 4 | Ionicons webfont assets | `amores-perros/fonts/*` |

### Directory Tree Summary

```text
amores-perros/
├── index.html
├── home-1.html
├── contact-us.html
├── about.html
├── informationen.html
├── https/amores-perrosde/abouthtml/über.html
├── includes/
│   ├── contact_form.php
│   ├── form_20481.php
│   └── form_37698.php
├── css/
│   ├── bootstrap.min.css
│   └── ionicons.min.css
├── js/
│   ├── jquery.min.js
│   ├── bootstrap.bundle.min.js
│   ├── blocs.min.js
│   ├── jqBootstrapValidation.js
│   ├── formHandler.js
│   ├── lazysizes.min.js
│   └── universal-parallax.min.js
├── img/
├── fonts/
├── style.css
└── favicon.png
```

## Page Inventory

| File | Current role | Title tag | Key headings | Notes | Source |
| --- | --- | --- | --- | --- | --- |
| `amores-perros/index.html` | Main public homepage / one-page service site | `Home` | `Wilkommen`, `Mein Training`, `Preise`, `Über mich`, `Terminvereinbarung`, `Öffnungszeiten im DOGSpace` | Current strongest candidate for the live homepage | `amores-perros/index.html` |
| `amores-perros/home-1.html` | Alternate homepage variant | `Home-1` | Same section structure as `index.html`, but content/pricing/hours differ in places | Likely draft or older alternate export | `amores-perros/home-1.html` |
| `amores-perros/contact-us.html` | Standalone contact page | `Contact Us` | `schreib mir eine nachricht`, `Opening Hours` | Contains English CTA copy and generic office hours | `amores-perros/contact-us.html` |
| `amores-perros/about.html` | Footer/info-only page variant | `about` | Footer headings only | No real about-page body content | `amores-perros/about.html` |
| `amores-perros/informationen.html` | Footer/info-only page variant | `about` | Footer headings only | Mentions `Mantrailing` only in a footer link label | `amores-perros/informationen.html` |
| `amores-perros/https/amores-perrosde/abouthtml/über.html` | Nested duplicate “Über mich” page | `About` | `über mich` | Hidden leftover export path with relative navigation back to root | `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Form Inventory

| Form location | Form ID | Current fields | Processor target | Notes | Source |
| --- | --- | --- | --- | --- | --- |
| `index.html` | `contact_form` | No text inputs. Only CTA buttons for `mailto:` and `tel:` remain inside a form wrapper | `includes/contact_form.php` if submitted conventionally by Blocs JS | Form wrapper exists, but no real message fields are exposed | `amores-perros/index.html`, `amores-perros/js/formHandler.js`, `amores-perros/includes/contact_form.php` |
| `contact-us.html` | `contact_form` | `Name`, `Email`, `Message` | `includes/contact_form.php` | Uses generic success/fail text from Blocs template | `amores-perros/contact-us.html`, `amores-perros/js/formHandler.js`, `amores-perros/includes/contact_form.php` |
| `home-1.html` | `form_20481` | `Name`, `Email`, `Message` | `includes/form_20481.php` | Uses separate processor file and a generic “Book Appointment” submit label | `amores-perros/home-1.html`, `amores-perros/js/formHandler.js`, `amores-perros/includes/form_20481.php` |
| `includes/form_37698.php` | N/A | Not referenced by any HTML file found in the dump | N/A | Orphaned processor file | `amores-perros/includes/form_37698.php` |

### Form Processor Findings

| Finding | Severity | Details | Source |
| --- | --- | --- | --- |
| Placeholder recipient address | Critical | All PHP handlers still send to `receiver@yoursite.com` from `contact@yoursite.com` | `amores-perros/includes/contact_form.php`, `amores-perros/includes/form_20481.php`, `amores-perros/includes/form_37698.php` |
| Generic subject line | Medium | Subject stays `Message from a Blocs website.` | Same as above |
| No anti-spam protection found | Medium | No reCAPTCHA or honeypot implementation found in current HTML/PHP dump | `amores-perros/contact-us.html`, `amores-perros/home-1.html`, `amores-perros/includes/*.php` |

## Stylesheet Inventory

| File | Approx. size | Role | Source |
| --- | --- | --- | --- |
| `amores-perros/css/bootstrap.min.css` | 162 KB | Framework styles | `amores-perros/css/bootstrap.min.css` |
| `amores-perros/css/ionicons.min.css` | 51 KB | Icon library | `amores-perros/css/ionicons.min.css` |
| `amores-perros/style.css` | 18 KB | Project stylesheet generated by Blocs | `amores-perros/style.css` |

### Style Notes

| Finding | Details | Source |
| --- | --- | --- |
| Responsive indicators present | Viewport meta and multiple media queries exist | `amores-perros/index.html`, `amores-perros/style.css` |
| Parallax/background-heavy layout | Multiple sections rely on parallax backgrounds and texture overlays | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/style.css` |
| Preloader present | A full-screen preloader is implemented with `pageload-spinner.gif` | `amores-perros/index.html`, `amores-perros/style.css`, `amores-perros/img/pageload-spinner.gif` |

## Script Inventory

| File | Approx. size | Role | Source |
| --- | --- | --- | --- |
| `amores-perros/js/jquery.min.js` | 88 KB | jQuery dependency | `amores-perros/js/jquery.min.js` |
| `amores-perros/js/bootstrap.bundle.min.js` | 83 KB | Bootstrap JS | `amores-perros/js/bootstrap.bundle.min.js` |
| `amores-perros/js/blocs.min.js` | 28 KB | Blocs runtime | `amores-perros/js/blocs.min.js` |
| `amores-perros/js/jqBootstrapValidation.js` | 36 KB | Form validation | `amores-perros/js/jqBootstrapValidation.js` |
| `amores-perros/js/formHandler.js` | 3.5 KB | AJAX form submit helper | `amores-perros/js/formHandler.js` |
| `amores-perros/js/lazysizes.min.js` | 7.9 KB | Lazy-loading helper | `amores-perros/js/lazysizes.min.js` |
| `amores-perros/js/universal-parallax.min.js` | 3.9 KB | Parallax effect | `amores-perros/js/universal-parallax.min.js` |

## Image Inventory

### Images referenced in page content

| Image | Format(s) | Approx. source dimensions | Current alt text | Notes | Source |
| --- | --- | --- | --- | --- | --- |
| `FullLogo_NoBuffer (1)` | PNG, WEBP | 1280x1258 | `logo` | Used as main logo on `index.html` and `informationen.html` | `amores-perros/index.html`, `amores-perros/informationen.html`, `amores-perros/img/FullLogo_NoBuffer (1).png` |
| `logo` | PNG, WEBP | 44x44 | `logo` | Used on `about.html`, `home-1.html` | `amores-perros/about.html`, `amores-perros/home-1.html`, `amores-perros/img/logo.png` |
| `waldi im gespröch` | JPG, WEBP | 3564x2529 | `waldi%20im%20gespröch` | Service image | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/img/waldi im gespröch.jpg` |
| `friedi` | JPG, WEBP | 4032x3024 | `runi` | Mismatched alt text | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/img/friedi.jpg` |
| `runi` | JPG, WEBP | 3024x2689 | `runi` | DOGSpace / Stammtisch card image | `amores-perros/index.html`, `amores-perros/home-1.html`, `amores-perros/img/runi.jpg` |
| `IMG_2251` | JPEG, WEBP | 1500x1125 | `wir` | Used on `index.html` about section | `amores-perros/index.html`, `amores-perros/img/IMG_2251.jpeg` |
| `ich und waldi` | JPG, WEBP | 2737x3024 | `wir` | Used on `home-1.html` and hidden nested about page | `amores-perros/home-1.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html`, `amores-perros/img/ich und waldi.jpg` |

### Largest media files

| File | Approx. size | Observation | Source |
| --- | --- | --- | --- |
| `img/ich und waldi.webp` | 968 KB | Large portrait asset | `amores-perros/img/ich und waldi.webp` |
| `img/ich und waldi.jpg` | 652 KB | Duplicate raster source of same image | `amores-perros/img/ich und waldi.jpg` |
| `img/waldi im gespröch.jpg` | 546 KB | Large service image | `amores-perros/img/waldi im gespröch.jpg` |
| `img/runi.jpg` | 514 KB | Large service image | `amores-perros/img/runi.jpg` |
| `img/friedi.jpg` | 510 KB | Large service image | `amores-perros/img/friedi.jpg` |

## Link and Navigation Inventory

| Pattern | Findings | Source |
| --- | --- | --- |
| Internal links | Strong bias toward linking everything back to `index.html`; very few dedicated destination pages exist | `amores-perros/index.html`, `amores-perros/about.html`, `amores-perros/informationen.html` |
| Scroll links | Main navigation in the homepages uses `href="#"` plus `onclick="scrollToTarget(...)"` instead of crawl-friendly section anchors | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Legacy absolute links | Several nav/footer links point to `http://www.amores-perros.de/About.html` | `amores-perros/index.html`, `amores-perros/about.html`, `amores-perros/contact-us.html`, `amores-perros/informationen.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |
| Social links | Mixed real and placeholder-looking targets: `instagram.com/cazoobi`, `facebook.com/cazoobi`, `twitter.com/blocsapp`, `twitter.com/`, `facebook.com/` | `amores-perros/index.html`, `amores-perros/about.html`, `amores-perros/informationen.html`, `amores-perros/contact-us.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Business and Legal Surface Inventory

| Item | Finding | Source |
| --- | --- | --- |
| Business / brand name | `Amores Perros` | `amores-perros/index.html`, `amores-perros/contact-us.html`, `amores-perros/informationen.html` |
| Person name | `Jacqueline Rebien` / `Jacky Rebien` | `amores-perros/index.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |
| Address | `Bundesstr. 74 20144 Hamburg` | `amores-perros/index.html`, `amores-perros/contact-us.html`, `amores-perros/about.html`, `amores-perros/informationen.html` |
| Email | `info@amores-perros.de` | `amores-perros/index.html`, `amores-perros/about.html`, `amores-perros/informationen.html` |
| Phone | `015228385291` | `amores-perros/index.html` |
| Privacy page | Not found in current FTP dump | `amores-perros/` |
| Cookie page | Not found in current FTP dump | `amores-perros/` |
| Dedicated Datenschutz page | Not found in current FTP dump | `amores-perros/` |
| Dedicated Impressum page | Not found as a clean public page in the root export. The only likely target is the nested `https/.../über.html` path or footer text snippets | `amores-perros/about.html`, `amores-perros/informationen.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |

## Inventory Risks and Rebuild Implications

| Severity | Finding | Why it matters | Source |
| --- | --- | --- | --- |
| Critical | The export contains multiple competing page variants (`index.html`, `home-1.html`, `about.html`, `informationen.html`, nested `über.html`) | Content and pricing conflict. A rebuild must choose one factual source of truth per service and business detail | Multiple files listed above |
| Critical | Form mail handlers still use placeholder email addresses | Contact leads would fail unless server-side code was manually changed outside the dump | `amores-perros/includes/*.php` |
| High | `informationen.html` and `about.html` are mostly navigation/footer fragments, not complete pages | Suggests the site structure was never finalized | `amores-perros/about.html`, `amores-perros/informationen.html` |
| High | No machine-readable SEO/configuration files were found | Later rebuild must create metadata, redirects, schema, robots, and sitemap from scratch | `amores-perros/` |
| Medium | Hidden nested page path uses a decomposed umlaut filename (`über.html`) while one link points to `über.html` | This can cause path mismatch issues depending on filesystem normalization | `amores-perros/about.html`, `amores-perros/https/amores-perrosde/abouthtml/über.html` |

