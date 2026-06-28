## Gewählte Perspektive

Ich bewerte die Unterlagen als **Senior WordPress Solution Architect, Technical SEO Lead und Conversion-Strategist für lokale Dienstleistungsunternehmen**.

Dabei trenne ich vier Ebenen:

1. Geschäftsmodell und Positionierung
2. Informationsarchitektur und Nutzerführung
3. SEO und Inhalte
4. Technische Umsetzung mit WordPress und Codex

---

# Gesamtbewertung

Die Dokumentation ist als **Bestandsaufnahme sehr gut**. Sie erfasst die vorhandenen Seiten, Inhalte, Produkte, Preise, Bilder, technischen Altlasten und offensichtlichen SEO-Probleme systematisch.

Für einen direkten Codex-Rebuild ist sie jedoch noch **nicht entscheidungsreif**.

Der größte Mangel ist nicht fehlende Technik, sondern eine fehlende verbindliche **Business Source of Truth**. Mehrere wichtige Aussagen widersprechen sich:

* Erstgespräch: 65 € oder 85 €
* DOGSpace-Freitag: ab 11 Uhr oder ab 13 Uhr
* DOGSpace, Hundecafé und Stammtisch: identisches oder separates Angebot?
* Mantrailing: Freizeitangebot, reguläres Training oder private Vermisstensuche?
* Supervision: Zielgruppe, Dauer und konkreter Nutzen unklar
* Workshops und Seminare: regelmäßig, gelegentlich oder aktuell gar nicht buchbar

Diese Konflikte sind in den Unterlagen korrekt erkannt worden.  

**Mein Urteil über die Dokumentationsqualität: 8/10.**

**Reifegrad für die Implementierung: etwa 5/10.**

Codex sollte noch nicht einfach alle vorgeschlagenen Seiten bauen. Sonst automatisiert es unbestätigte Annahmen und erzeugt möglicherweise eine technisch saubere, aber geschäftlich falsche Website.

---

# Die wichtigsten Erkenntnisse

## 1. Der aktuelle Webauftritt muss wirklich neu gebaut werden

Ein kosmetisches Redesign wäre nicht sinnvoll.

Der Export besteht aus mehreren konkurrierenden und teilweise unfertigen Blocs-Seiten. Es gibt:

* doppelte Homepage-Versionen
* fragmentarische Unterseiten
* generische Seitentitel
* leere Meta Descriptions
* keine Service-Landingpages
* keine H1-Struktur
* keine Canonicals
* kein strukturiertes Datenmodell
* fragwürdige oder kaputte interne Links
* fehlerhafte Formular-Empfänger
* keine vollständigen Rechtsseiten

Besonders kritisch: Die Formular-Handler verwenden noch Platzhalteradressen wie `receiver@yoursite.com`. Kontaktanfragen könnten daher verloren gehen. 

Die technische SEO-Analyse bestätigt zudem, dass fast alle grundlegenden Ranking-Signale fehlen. 

**Konsequenz:** Neubau statt Migration des bestehenden HTML-Layouts.

---

## 2. Die vorgeschlagene Seitenstruktur ist teilweise zu groß

Die ausführliche Audit-Datei schlägt unter anderem separate Seiten vor für:

* Hundeschule Hamburg
* Hundetraining Hamburg
* Einzeltraining Hund Hamburg
* Erstgespräch
* Welpentraining
* Junghundetraining
* Problemverhalten
* DOGSpace
* Mantrailing
* Vermisstensuche
* Workshops
* Supervision
* Führungskräfte-Coaching

Das ist als langfristige Themenlandkarte sinnvoll, aber nicht als sofortige Startarchitektur.

Insbesondere separate Seiten für:

* `/hundeschule-hamburg/`
* `/hundetraining-hamburg/`
* `/einzeltraining-hund-hamburg/`

können bei ähnlichen Inhalten miteinander konkurrieren. Ohne klare Suchintention und eigenständigen Inhalt entsteht Keyword-Kannibalisierung.

Auch Seiten wie „Welpentraining“ oder „Problemverhalten“ sollten nur gebaut werden, wenn Jacqueline diese Leistungen tatsächlich gezielt anbietet und fachlich entsprechend positionieren möchte. Die aktuelle Website belegt diese Angebote noch nicht eindeutig. 

## Empfohlene Launch-Struktur

```text
/
├── hundetraining-hamburg/
│   ├── erstgespraech/
│   └── einzeltraining/
├── dogspace-hamburg/
├── workshops-termine/
├── fuer-hundetrainer/
├── ueber-mich/
├── preise/
├── kontakt/
├── impressum/
└── datenschutz/
```

Dabei ist `/hundetraining-hamburg/` die zentrale SEO-Pillar-Page.

Erst später, nach Suchdaten und realer Nachfrage, können Seiten wie diese ergänzt werden:

```text
/welpentraining-hamburg/
/junghundetraining-hamburg/
/hundebegegnungen-hamburg/
/leinenfuehrigkeit-hamburg/
/mantrailing-hamburg/
```

---

## 3. Mantrailing und Vermisstensuche sollten nicht vorschnell integriert werden

Das Mantrailing-Dokument beschreibt ein eigenständiges, hochsensibles Geschäftsmodell:

* Notfallkontakte
* vermisste Kinder
* Demenzpatienten
* Einsätze
* Dokumentation
* Sicherheitsausrüstung
* Nacht- und Wochenendzuschläge
* Zusammenarbeit mit Ermittlern und Organisationen

Das ist etwas völlig anderes als reguläres Hundetraining oder Mantrailing als Freizeitbeschäftigung. 

### Meine Empfehlung

**Training-Mantrailing** kann bei Amores Perros integriert werden:

> Mantrailing als Beschäftigung, Nasenarbeit und gemeinsames Training.

**Private Personensuche** sollte zunächst getrennt behandelt werden:

* eigene Marke oder Submarke
* eigene Landingpage oder Microsite
* eigene Telefonnummer beziehungsweise Notfallkommunikation
* eigener Haftungs- und Einsatzprozess
* juristisch geprüfte Formulierungen
* dokumentierte Einsatzvoraussetzungen
* klare Abgrenzung zu Polizei und Rettungsdiensten

Die Aussage „private Einsätze können oft schneller organisiert werden“ sollte nicht ungeprüft als Marketingversprechen veröffentlicht werden.

Die bestehende Dokumentation empfiehlt bereits, die Mantrailing-Seite zurückzustellen, bis Umfang und rechtliche Einordnung bestätigt sind. Das ist richtig. 

---

## 4. Die Positionierung ist noch zu breit

Aktuell stehen nebeneinander:

* Hundetraining für Privatkunden
* DOGSpace
* Workshops
* Hundetrainer-Austausch
* Supervision
* Mantrailing
* private Vermisstensuche
* Führungskräfte-Coaching mit Hund

Das sind mindestens drei unterschiedliche Märkte:

### B2C

Hundehaltende mit Alltags- oder Verhaltensfragen.

### B2B/Fachpublikum

Hundetrainerinnen und Hundetrainer für Austausch und Supervision.

### Spezial- beziehungsweise Einsatzdienst

Private Mantrailing-Unterstützung.

Optional kommt mit Führungskräfte-Coaching ein vierter Markt hinzu.

Diese Angebote sollten nicht alle gleich stark in der Hauptnavigation stehen. Sonst versteht ein neuer Besucher nicht, was das Kerngeschäft ist.

## Empfohlene Positionierung

**Primär:**

> Individuelles Hundetraining in Hamburg für Menschen, die ihren Hund besser verstehen und ihren Alltag gemeinsam entspannter gestalten möchten.

**Sekundär:**

> DOGSpace, Veranstaltungen und fachliche Angebote für Hundetrainer:innen.

**Separat oder später:**

> Mantrailing-Einsätze und Führungskräfte-Coaching.

Die vorhandene persönliche, ruhige und beziehungsorientierte Tonalität ist eine echte Stärke. Die Marketinganalyse erkennt diese ebenfalls, weist aber zu Recht darauf hin, dass Beweise, Zielgruppentrennung und klare Conversion-Wege fehlen. 

---

# Was in den Unterlagen noch fehlt

## 1. Keine echte Keyword- und SERP-Validierung

Die vorgeschlagenen Keywords wirken plausibel, wurden aber offenbar nicht anhand folgender Daten validiert:

* tatsächliches Suchvolumen
* lokale Suchergebnisse in Hamburg
* Wettbewerbsstärke
* Google-Maps-Ergebnisse
* Suchintention
* bestehende Rankings der Domain
* Google Search Console
* Google Business Profile
* saisonale Nachfrage

Die Dokumente liefern eine gute Hypothese, aber noch keine belastbare Keyword-Strategie.

Vor dem finalen Content-Briefing sollte eine Tabelle entstehen:

| Seite | Hauptintention | Hauptkeyword | Varianten | Wettbewerber | Inhaltstyp | Priorität |
| ----- | -------------- | ------------ | --------- | ------------ | ---------- | --------- |

---

## 2. Keine vorhandenen Leistungsdaten

Für die Migration fehlen mindestens:

* aktuelle organische Besucherzahlen
* derzeit indexierte URLs
* vorhandene Backlinks
* Google-Search-Console-Daten
* Google-Business-Profile-Daten
* bestehende Google-Bewertungen
* aktuell rankende Suchbegriffe
* wichtigste Einstiegsseiten
* Formular- und Anruf-Conversions

Ohne diese Daten könnte der Rebuild bestehende Rankings oder Backlinks unbeabsichtigt verlieren.

---

## 3. Keine verbindliche Content-Governance

Es fehlt ein zentrales Dokument, das Codex und WordPress als einzige Faktenquelle nutzen.

Ich empfehle:

```text
docs/
├── business/
│   ├── business-facts.yaml
│   ├── services.yaml
│   ├── pricing.yaml
│   ├── opening-hours.yaml
│   ├── credentials.yaml
│   └── contact-details.yaml
├── brand/
│   ├── positioning.md
│   ├── tone-of-voice.md
│   └── visual-guidelines.md
├── seo/
│   ├── keyword-map.csv
│   ├── url-map.csv
│   ├── metadata.csv
│   └── redirect-map.csv
├── content/
│   ├── pages/
│   ├── faqs/
│   └── testimonials/
└── technical/
    ├── architecture.md
    ├── wordpress-setup.md
    └── launch-checklist.md
```

Die YAML-Dateien verhindern, dass Preise, Öffnungszeiten und Kontaktdaten an vielen Stellen manuell dupliziert werden.

---

# Empfohlene technische Strategie mit Codex

## Variante A: Custom WordPress Block Theme

Das ist meine bevorzugte Lösung.

Codex erstellt ein schlankes eigenes Block-Theme mit:

* `theme.json`
* Gutenberg-Templates
* Template Parts
* Block Patterns
* sauberem CSS
* möglichst wenig JavaScript
* responsiven Bildern
* semantischem HTML
* zentralen Design Tokens
* wiederverwendbaren CTA-, Service- und FAQ-Patterns

### Vorteile

* sehr gute Performance
* vollständige Versionskontrolle
* keine Abhängigkeit von einem Pagebuilder
* Codex kann Struktur und Komponenten zuverlässig bearbeiten
* langfristig wartbar
* geringe Plugin-Abhängigkeit

### Nachteile

* etwas höherer Initialaufwand
* Änderungen am Layout benötigen mehr technisches Verständnis
* Jacqueline sollte Inhalte bearbeiten können, ohne die Designstruktur zu zerstören

Die technische Planung schlägt ebenfalls Gutenberg und ein leichtgewichtiges Block-Theme vor. 

---

## Variante B: GeneratePress/Kadence plus Child Theme

Diese Variante ist sinnvoll, wenn Jacqueline später viel selbst gestalten möchte.

### Vorteile

* schnellerer Start
* komfortable Layoutsteuerung
* geringere Einstiegshürde

### Nachteile

* mehr herstellerspezifische Einstellungen
* schwierigere reproduzierbare Codex-Änderungen
* Design kann inkonsistent werden
* potenziell mehr CSS- und Plugin-Overhead

## Entscheidung

Für einen Codex-geführten, technisch sauberen Rebuild:

> **Eigenes schlankes Block-Theme, Gutenberg für Inhalte, keine Elementor- oder Divi-Abhängigkeit.**

---

# Empfohlene Repository-Struktur

```text
amores-perros-rebuild/
├── README.md
├── docs/
├── wordpress/
│   ├── wp-content/
│   │   ├── themes/
│   │   │   └── amores-perros/
│   │   ├── mu-plugins/
│   │   └── plugins/
│   └── wp-cli.yml
├── content/
│   ├── pages/
│   ├── metadata/
│   └── imports/
├── scripts/
│   ├── validate-content.ts
│   ├── validate-links.ts
│   ├── generate-redirects.ts
│   └── optimize-images.ts
├── tests/
│   ├── e2e/
│   ├── accessibility/
│   └── seo/
├── docker-compose.yml
└── .github/workflows/
```

WordPress Core und Uploads sollten nicht unkontrolliert in Git eingecheckt werden. Versioniert werden vor allem:

* Theme
* eigene Plugins beziehungsweise MU-Plugins
* Konfiguration
* Content-Quelldateien
* Importskripte
* Tests
* Redirect-Regeln

---

# Empfohlenes WordPress-Datenmodell

## Standardseiten

Für:

* Startseite
* Hundetraining
* Erstgespräch
* Einzeltraining
* DOGSpace
* Über mich
* Preise
* Kontakt

## Custom Post Type `event`

Nur wenn wirklich regelmäßig Termine veröffentlicht werden:

```text
event
├── title
├── start_datetime
├── end_datetime
├── location
├── capacity
├── price
├── audience
├── booking_url
├── status
└── description
```

## Kein Services-CPT zum Start

Bei sechs bis acht stabilen Leistungen sind normale Seiten einfacher.

Ein Services-CPT lohnt sich erst, wenn:

* viele Angebote existieren
* ein Service-Archiv benötigt wird
* dieselben strukturierten Felder regelmäßig wiederkehren
* Inhalte automatisiert ausgespielt werden sollen

Die technische Planung bezeichnet den Services-CPT ebenfalls nur als optional. 

---

# Wiederverwendbare Komponenten

Codex sollte folgende Patterns bauen:

```text
Hero
TrustBar
ProblemList
ServiceCardGrid
ServiceIntroduction
ForWhomSection
NotSuitableForSection
ProcessSteps
PricingTable
TrainerProfile
CredentialsGrid
TestimonialList
FAQAccordion
LocationSection
ContactCTA
EventCard
StickyMobileContactBar
```

Jede Leistungsseite sollte grundsätzlich dieser Struktur folgen:

```text
H1 und Nutzenversprechen
Kurze Einordnung
Für wen ist das Angebot?
Typische Ausgangssituationen
So läuft es ab
Trainingsansatz
Preis und Bedingungen
Über Jacqueline / Vertrauenssignal
FAQ
Kontakt-CTA
```

---

# SEO-Architektur

## Homepage

Primäre Aufgabe:

* Marke erklären
* lokale Relevanz herstellen
* zu passenden Angeboten weiterleiten
* Erstgespräch als primäre Conversion etablieren

Nicht versuchen, auf der Startseite jedes Keyword vollständig abzudecken.

## Pillar-Page Hundetraining

```text
/hundetraining-hamburg/
```

Diese Seite bündelt:

* individuelles Hundetraining
* Alltag
* Kommunikation
* Hundebegegnungen
* Leinenführigkeit
* Rückruf
* Mensch-Hund-Beziehung
* Verbindung zu Erstgespräch und Einzeltraining

## Unterstützende Seiten

```text
/hundetraining-hamburg/erstgespraech/
/hundetraining-hamburg/einzeltraining/
```

Damit ist die thematische Beziehung auch in der URL sichtbar.

## DOGSpace

```text
/dogspace-hamburg/
```

Nur dann als eigenständige SEO-Seite, wenn klar erklärt werden kann:

* Was genau wird dort angeboten?
* Ist es ein Ort, ein Zeitfenster oder ein Kursformat?
* Wie meldet man sich an?
* Wie viele Teams nehmen teil?
* Was kostet es?
* Welche Voraussetzungen gelten?

---

# Conversion-Strategie

## Eine primäre Conversion

Die Website sollte nicht gleichzeitig mit fünf gleichwertigen Kontaktmöglichkeiten arbeiten.

Primärer CTA:

> Erstgespräch anfragen

Sekundäre Aktionen:

* anrufen
* E-Mail schreiben
* DOGSpace kennenlernen
* Termin ansehen

## Formular

Das Audit empfiehlt viele Felder. Ich würde das Formular kürzer halten:

```text
Name
E-Mail oder Telefonnummer
Name und Alter des Hundes
Worum geht es?
Bevorzugte Kontaktart
Datenschutz-Einwilligung
```

Rasse, Wohnort, gewünschtes Angebot und weitere Details können später abgefragt werden. Ein zu langes Erstkontaktformular reduziert wahrscheinlich die Anzahl der Anfragen.

## Keine automatische „kostenlose Beratung“ versprechen

In einer Audit-Datei wird ein kostenloses Kennenlerngespräch vorgeschlagen. Das passt möglicherweise nicht zum kostenpflichtigen Erstgespräch und muss geschäftlich geklärt werden. 

---

# Empfohlener Umsetzungsplan

## Phase 0: Entscheidungen und Fakten

Noch kein Theme bauen.

Ergebnisse:

```text
business-facts.yaml
services.yaml
pricing.yaml
opening-hours.yaml
credentials.yaml
positioning.md
```

## Phase 1: Informationsarchitektur

Ergebnisse:

```text
sitemap.md
navigation.md
url-map.csv
redirect-map.csv
internal-link-map.csv
```

## Phase 2: Content Briefs

Für jede Seite:

```text
Suchintention
Zielgruppe
Primärziel
H1
Abschnittsstruktur
Haupt-CTA
interne Links
benötigte Nachweise
benötigte Bilder
Schema-Typ
```

## Phase 3: Designsystem

Codex erstellt:

* Farben
* Typografie
* Abstände
* Breakpoints
* Buttons
* Karten
* Formularzustände
* Fokuszustände
* Bildformate
* Gutenberg-Patterns

## Phase 4: MVP-Implementierung

Zuerst:

1. Startseite
2. Hundetraining
3. Erstgespräch
4. Einzeltraining
5. DOGSpace
6. Über mich
7. Preise
8. Kontakt
9. Rechtstexte

## Phase 5: Qualitätssicherung

Automatisiert prüfen:

* HTML-Semantik
* genau eine H1 je Seite
* fehlende Alt-Texte
* defekte Links
* Redirects
* Metadaten
* Canonicals
* strukturierte Daten
* Sitemap
* Mobile Navigation
* Formulardelivery
* Tastaturbedienung
* Kontrast
* Performance-Budgets

## Phase 6: Erweiterung

Erst nach dem Launch:

* Workshops und Events
* Blog
* weitere Suchintentionen
* Supervision
* Mantrailing-Training
* lokale Unterthemen
* Lead-Magnet oder Newsletter

---

# Fragen, die vor dem Rebuild beantwortet werden müssen

## Kritisch

1. **Wie hoch ist der aktuelle Preis des Erstgesprächs: 65 € oder 85 €?**

2. **Wie lange dauert das Erstgespräch?**

3. **Sind DOGSpace, Hundecafé und Stammtisch dasselbe Angebot oder drei unterschiedliche Formate?**

4. **Welche DOGSpace-Öffnungszeiten gelten aktuell, insbesondere am Freitag?**

5. **Ist DOGSpace während der Öffnungszeiten frei besuchbar, nur mit Anmeldung oder ausschließlich über feste Termine?**

6. **Welche Leistungen werden aktuell tatsächlich verkauft?**
   Bitte jeweils mit `aktiv`, `geplant` oder `nicht mehr angeboten` kennzeichnen:

   * Erstgespräch
   * Einzeltraining
   * 5er-Karte
   * DOGSpace
   * Stammtisch
   * Workshops
   * Seminare
   * Hundetrainer-Austausch
   * Supervision
   * Mantrailing-Training
   * private Vermisstensuche
   * Führungskräfte-Coaching

7. **Besitzt Jacqueline die erforderliche Erlaubnis nach § 11 TierSchG, und darf diese öffentlich genannt werden?**

8. **Welche Qualifikationen, Ausbildungen und Fortbildungen dürfen mit genauer Bezeichnung veröffentlicht werden?**

9. **Soll „Amores Perros“ definitiv als Marke bestehen bleiben oder wird weiterhin ein neuer Name wie Hundekompass geprüft?**

10. **Ist die Adresse Bundesstraße 74 ein öffentlich besuchbarer Trainingsstandort?**

## Positionierung

11. Soll die Website primär Menschen mit konkreten Problemen ansprechen oder auch präventives Alltagstraining?

12. Gibt es Welpen- oder Junghundetraining wirklich als eigenständige Leistung?

13. Welche drei Probleme kommen bei Kunden am häufigsten vor?

14. Welche Art von Training wird ausdrücklich nicht angeboten?

15. Wie groß ist das tatsächliche Einzugsgebiet?

16. Soll die Kommunikation konsequent mit „du“ erfolgen?

17. Was unterscheidet Jacqueline konkret von anderen Hundeschulen in Hamburg?

## Buchung und Betrieb

18. Soll man direkt einen Termin buchen oder zunächst nur eine Anfrage senden?

19. Welche Reaktionszeit kann realistisch versprochen werden?

20. Wird WhatsApp geschäftlich eingesetzt?

21. Welche Zahlungsarten werden akzeptiert?

22. Welche Stornierungsregeln gelten?

23. Welche Fahrtkosten gelten bei Außenterminen?

24. Welche Bedingungen gelten für die 5er-Karte?

## Vertrauen und Inhalte

25. Gibt es echte Google-Bewertungen oder schriftliche Kundenstimmen?

26. Dürfen Fotos von Kunden und Hunden verwendet werden?

27. Gibt es Zertifikate, Presseberichte, Partner oder Kooperationen?

28. Welche Social-Media-Profile sind tatsächlich aktiv?

29. Existieren Google Search Console, Google Analytics oder ein Google Business Profile?

30. Gibt es Zugriff auf die aktuelle Domain-, Hosting- und DNS-Verwaltung?

---

# Meine klare Empfehlung

Baue **nicht sofort alle im Audit genannten Seiten**.

Der beste Weg ist:

1. Zuerst eine verbindliche Business-Faktenbasis erstellen.
2. Das Kerngeschäft auf Hundetraining in Hamburg fokussieren.
3. Mit acht bis zehn hochwertigen Seiten starten.
4. Ein schlankes eigenes Gutenberg-Block-Theme durch Codex bauen lassen.
5. Inhalte und Geschäftsdaten getrennt vom Theme verwalten.
6. Mantrailing-Einsätze und Führungskräfte-Coaching zunächst vom Hauptangebot trennen.
7. Weitere Landingpages nur aufgrund echter Angebote und Suchdaten ergänzen.

Die vorhandene Task-Liste ist grundsätzlich sinnvoll, vermischt aber noch Discovery, Content, Technik und Launch.  Codex sollte diese Arbeit deshalb in klar abgegrenzten Phasen erledigen und nach jeder Phase strukturierte Artefakte erzeugen, statt sofort WordPress-Code und SEO-Texte gleichzeitig zu generieren.
