# WordPress Rebuild Content Map

Date: 2026-06-28

Purpose: map the current FTP-dump content into a clean WordPress information architecture

## Proposed New Page Hierarchy

```text
/
├── hundetraining-hamburg
├── erstgespraech
├── einzeltraining-hund-hamburg
├── dogspace-hamburg
├── workshops-seminare-hamburg
├── austausch-fuer-hundetrainerinnen
├── supervision-fuer-hundetrainerinnen
├── ueber-jacqueline-rebien
├── preise
├── kontakt
├── impressum
└── datenschutz
```

## Old-to-New Content Mapping

| Old source | Proposed new page | Recommended slug | Page purpose | Primary keyword | Secondary keywords | Primary CTA in German | Source content to reuse | Content to rewrite | Content gaps |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `index.html` | Homepage | `/` | Brand overview, strongest entry page, service hub | `Hundetraining Hamburg` | `Hundeschule Hamburg`, `Mensch-Hund-Team Hamburg` | `Erstgespräch anfragen` | Welcome text, training philosophy, bio elements, DOGSpace introduction, prices | Titles, hero, value proposition, CTA flow, local SEO copy | Testimonials, FAQ, service summary, local proof |
| `index.html` + `home-1.html` | Erstgespräch | `/erstgespraech` | Entry offer page | `Erstgespräch Hundetraining Hamburg` | `Hundetrainerin Hamburg Erstgespräch`, `Verhaltensberatung Hund Hamburg` | `Erstgespräch anfragen` | Consultation description and process framing | Clarify exact price, duration, booking flow | What happens after the first meeting, who it is for, area served |
| `index.html` + `home-1.html` | Einzeltraining | `/einzeltraining-hund-hamburg` | Core 1:1 training service | `Einzeltraining Hund Hamburg` | `individuelles Hundetraining Hamburg`, `Hundeverhalten Training Hamburg` | `Einzeltraining anfragen` | Training methodology paragraphs, price list entries | Add problem/solution structure, outcomes, typical cases | FAQ, examples, process, expectations |
| `index.html` | DOGSpace | `/dogspace-hamburg` | Explain the DOGSpace format clearly | `DOGSpace Hamburg` | `soziales Hundetraining Hamburg`, `Training mit anderen Hunden Hamburg` | `DOGSpace kennenlernen` | DOGSpace description, opening hours, vaccination/liability condition | Clarify what it is and what it is not | Capacity, rules, booking model, address details, photos |
| `home-1.html` + `index.html` | Workshops & Seminare | `/workshops-seminare-hamburg` | Event landing page and archive | `Workshops Hund Hamburg` | `Seminare Hund Hamburg`, `Hundeworkshop Hamburg` | `Über aktuelle Termine informieren` | Price snippets and event mentions | Build a real event content structure | Topics, dates, booking, cancellation rules |
| `home-1.html` + `index.html` | Austausch für Hundetrainer:innen | `/austausch-fuer-hundetrainerinnen` | B2B/professional community offer | `Austausch Hundetrainer Hamburg` | `Netzwerk Hundetrainer Hamburg`, `Fortbildung Hundetrainer Hamburg` | `Austausch anfragen` | Price snippets and trainer references | Create full audience-specific copy | Format, frequency, outcomes, eligibility |
| `index.html` | Supervision | `/supervision-fuer-hundetrainerinnen` | Professional service landing page | `Supervision Hundetrainer Hamburg` | `Supervision Hundetraining`, `fachliche Begleitung Hundetrainer` | `Supervision anfragen` | Price only | Nearly the entire page must be written fresh | Description, target group, format, credentials, CTA |
| `index.html` + nested `über.html` | About | `/ueber-jacqueline-rebien` | Trust page with biography and qualifications | `Hundetrainerin Hamburg Jacqueline Rebien` | `Hundetrainerin Hamburg`, `Mensch-Hund-Beraterin Hamburg` | `Mich kennenlernen` | Biography, 2004 thesis reference, trainer/mediator background, portrait content | Tighten language, add credibility blocks | Certifications, continuing education, photos, philosophy |
| `index.html` + `home-1.html` | Prices | `/preise` | Transparent pricing overview | `Preise Hundetraining Hamburg` | `Hundetraining Kosten Hamburg`, `DOGSpace Preise` | `Passendes Angebot anfragen` | Price tables | Resolve conflicting values and naming | Policy notes, package rules, payment terms |
| `index.html` + `contact-us.html` | Contact | `/kontakt` | Contact and inquiry page | `Kontakt Hundetraining Hamburg` | `Hundetrainerin Hamburg Kontakt` | `Nachricht senden` | Email, phone, address, intro text | Replace English template copy and generic hours | GDPR text, consent, map, service area |
| footer text only | Impressum | `/impressum` | Legal page | `Impressum` | N/A | None | Business name, address | Full legal text required | All legal content not present in dump |
| Not found in current FTP dump | Datenschutz | `/datenschutz` | Privacy page | `Datenschutz` | N/A | None | None | Entire page required | Full privacy copy |

## Content That Should Not Become a Public Page Without Confirmation

| Current mention | Recommendation | Reason | Source |
| --- | --- | --- | --- |
| `Mantrailing` | Hold until business scope is confirmed | Only a footer label exists in the dump; no actual service copy or legal framing | `amores-perros/informationen.html` |
| `about.html` and `informationen.html` as standalone pages | Do not preserve as-is | They are mostly footer/navigation fragments | `amores-perros/about.html`, `amores-perros/informationen.html` |
| `home-1.html` as a public page | Do not preserve as-is | It is a competing homepage variant | `amores-perros/home-1.html` |

## Reusable Block Recommendations

| Reusable block | Use on pages | Current source material |
| --- | --- | --- |
| Welcome / empathy intro | Homepage, Erstgespräch | `index.html`, `home-1.html` |
| “How I work” method block | Homepage, Einzeltraining, About | `index.html`, `home-1.html` |
| Trainer biography block | Homepage, About | `index.html`, `home-1.html`, nested `über.html` |
| Price table block | Homepage, Prices, service pages | `index.html`, `home-1.html` |
| Contact CTA block | Homepage, service pages, About | `index.html`, `contact-us.html`, `home-1.html` |
| DOGSpace rules block | DOGSpace page, FAQ | `index.html`, `home-1.html` |

