# Current Products and Services

Date: 2026-06-28

Scope: current offers, prices, durations, terms, and offer signals found in the FTP dump

## Current Offer Table

| Offer | Current type | Price | Duration | Current description / conditions | Target audience inferred from current copy | Current CTA | Source file(s) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Erstgespräch | Introductory consultation | `85€` on `index.html`; `65€` on `home-1.html` | Not explicitly stated | Open, empathetic first conversation to understand the situation, behaviour causes, and Mensch-Hund-Beziehung; on `home-1.html` it says `20€` is credited toward the first training session | Mensch-Hund-Teams with behavioural or relationship questions | `E-Mail schreiben`, `Anrufen`, `Book Appointment` | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Einzelstunde | 1:1 training | `65€` | `45min.` | Plus travel costs on `index.html` | Existing clients after consultation | Same as above | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Einzelstunde | 1:1 training | `110€` | `90min.` | No extra condition stated | Existing clients after consultation | Same as above | `amores-perros/index.html`, `amores-perros/home-1.html` |
| 5er-Karte / 5-erKart | Package | `280€` | `5 x 45min.` implied | Spelling inconsistent; no detailed package rules found | Repeat clients | Same as above | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Training | Ongoing service | Not separately priced | Not found in current FTP dump | Individual, fair, practical training adapted to everyday life, progress, setbacks, and team pace | Mensch-Hund-Teams wanting behaviour change and daily-life support | Same as above | `amores-perros/index.html`, `amores-perros/home-1.html` |
| DOGSpace | Guided social/training space | Not separately priced | Not found in current FTP dump | Guided sessions near other dogs; not free play; used for workshops, seminars, and meetings; requires valid rabies vaccination and liability insurance | Mensch-Hund-Teams wanting guided contact/training around other dogs | `E-Mail schreiben`, `Anrufen` | `amores-perros/index.html` |
| Stammtisch / Hundecafé | Group / meetup format | `10€` | Not found in current FTP dump | Includes coffee and cold drinks on `home-1.html`; described as not free play and tied to guided exchange | Dog owners seeking exchange and guided sessions | `Book Appointment` on `home-1.html` | `amores-perros/home-1.html`, `amores-perros/index.html` |
| Workshop participation | Event participation | `25€` | Not found in current FTP dump | Dates/details `werden rechtzeitig bekannt gegeben` | Dog owners and possibly trainers | Sitewide contact CTA only | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Seminar participation | Event participation | `45€` | Not found in current FTP dump | Dates/details `werden rechtzeitig bekannt gegeben` | Dog owners and possibly trainers | Sitewide contact CTA only | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Hundetrainer/innen Austausch | Trainer meetup / peer exchange | `15€` | Not found in current FTP dump | Coffee and cold drinks included on `home-1.html` | Dog trainers | Sitewide contact CTA only | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Supervision | Professional service | `55€` | Not found in current FTP dump | No further explanation found | Dog trainers / professionals | Sitewide contact CTA only | `amores-perros/index.html` |
| Mantrailing | Mention only | Not found in current FTP dump | Not found in current FTP dump | Only appears as a footer link label with no service description | Not clear from current website | No visible CTA | `amores-perros/informationen.html` |

## SEO and Offer-Clarity Weaknesses

| Offer | Severity | SEO weakness | Why it is weak | Source |
| --- | --- | --- | --- | --- |
| All services | Critical | No standalone landing pages | Search engines cannot map a clear URL to one service or query intent | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Erstgespräch | High | Conflicting price | `85€` and `65€` both exist in current export | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Training | High | No standalone pricing or outcome framing | Service is described conceptually but not packaged for conversion | `amores-perros/index.html`, `amores-perros/home-1.html` |
| DOGSpace / Stammtisch | High | Unclear naming and positioning | `DOGSpace`, `Stammtisch`, and `Hundecafé` describe overlapping concepts | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Workshop / Seminar | Medium | No topics, dates, audience split, or format details | Hard to rank or convert for event-related queries | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Hundetrainer/innen Austausch | Medium | Buried in price list only | Not discoverable as a professional offer | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Supervision | High | No explanation beyond price | A high-intent service exists but has almost no content | `amores-perros/index.html` |
| Mantrailing | High | Mention without substance | Creates expectation without deliverable information | `amores-perros/informationen.html` |

## Recommended Rebuild Treatment

| Current offer | Recommended rebuild treatment | Suggested content model | Website-facing recommendation in German |
| --- | --- | --- | --- |
| Erstgespräch | Dedicated landing page plus short booking funnel | Standard page + reusable FAQ block + CTA block | `Erstgespräch für Hundetraining in Hamburg` |
| Einzeltraining 45 / 90 / 5er-Karte | One core service page plus clear pricing table | Standard page + structured price module | `Einzeltraining für dich und deinen Hund` |
| Training | Fold into the Einzeltraining service architecture instead of leaving it generic | Reusable “Ablauf”, “Für wen”, “Methodik” blocks | `Individuelles Hundetraining mit klaren nächsten Schritten` |
| DOGSpace | Separate page if this is an active offer; clarify whether it is social training, controlled group work, or event venue | Standard page or custom “Service” entry | `DOGSpace: begleitete Begegnungen und Training in Hamburg` |
| Stammtisch / Hundecafé | Split from DOGSpace if it is a recurring community event | Event or recurring format content type | `Stammtisch für Hundemenschen` |
| Workshop / Seminar | Use event-oriented pages with date, topic, audience, and booking CTA | Custom post type `Events` or similar | `Workshops und Seminare rund um Hund und Mensch` |
| Hundetrainer/innen Austausch | Give it a dedicated B2B/professional page if still offered | Event or service entry | `Austausch für Hundetrainer:innen` |
| Supervision | Give it a dedicated professional services page | Standard page or service entry | `Supervision für Hundetrainer:innen` |
| Mantrailing | Do not build a public page until service scope is confirmed; if confirmed, create a dedicated offer page with legal framing | Standard page only after business confirmation | `Mantrailing in Hamburg` only if the service is real and active |

## Facts That Must Be Confirmed Before Rebuild

| Severity | Item requiring confirmation | Reason | Source |
| --- | --- | --- | --- |
| Critical | Correct `Erstgespräch` price | Two different values exist | `amores-perros/index.html`, `amores-perros/home-1.html` |
| High | Whether `DOGSpace`, `Stammtisch`, and `Hundecafé` are the same offer or separate offers | Current copy mixes them | `amores-perros/index.html`, `amores-perros/home-1.html` |
| High | Whether `Mantrailing` is a real current service | Mention exists without supporting content | `amores-perros/informationen.html` |
| High | Conditions for the 5er-Karte | Only price and implied duration are present | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Medium | Whether workshop/seminar/trainer exchange dates are recurring or occasional | No scheduling model found in the dump | `amores-perros/index.html`, `amores-perros/home-1.html` |
| Medium | Whether `Supervision` is for dog trainers, dog owners, or both | Only the price is visible | `amores-perros/index.html` |

