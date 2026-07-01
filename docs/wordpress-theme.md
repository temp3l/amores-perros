# Theme-Anforderungen für Beziehungssache Hund

## 1. Projektziel

Für **beziehungssache-hund.de** wird ein eigenes, leichtgewichtiges WordPress Block Theme entwickelt.

Die Website soll:

* die Marke verständlich positionieren,
* Vertrauen in Jacky Rebien und ihre Arbeitsweise aufbauen,
* die Angebote klar voneinander abgrenzen,
* lokale Auffindbarkeit in Hamburg unterstützen,
* Interessenten zu einer qualifizierten Anfrage führen,
* ohne schweren Page Builder auskommen,
* langfristig einfach über den WordPress-Editor pflegbar bleiben.

Die Entwicklung erfolgt zunächst vollständig lokal. Das spätere Deployment wird manuell durchgeführt und ist nicht Teil der ersten Implementierungsphase.

Dieses Dokument beschreibt vor allem Anforderungen an Theme, Templates, Patterns und redaktionelle Struktur. Geschäftsdaten wie Preise, Kontaktdaten, Öffnungszeiten und Qualifikationen bleiben fachliche Stammdaten und dürfen nicht hart im Theme-Code hinterlegt werden.

---

## 2. Positionierung

**Beziehungssache Hund** steht für individuelles Hundetraining und persönliche Begleitung in Hamburg.

### Kernbotschaft

Individuelles Hundetraining für Mensch-Hund-Teams, die ihre Situation besser verstehen und alltagstaugliche, klare Lösungen entwickeln möchten.

### Markenwerte

* persönlich
* ruhig
* klar
* kompetent
* empathisch
* verbindlich
* individuell
* alltagstauglich

### Abgrenzung

Die Marke soll nicht wirken wie:

* eine große standardisierte Hundeschule,
* ein starrer Kurskatalog,
* eine laute oder autoritäre Trainingsmarke,
* ein verspieltes Tierbedarf-Portal,
* ein esoterisches Coaching-Angebot,
* eine generische WordPress-Vorlage.

### Sprachliche Leitidee

> Ruhig statt laut. Klar statt beliebig. Individuell statt pauschal.

## 2.1 Visuelle Referenz

Die optische Grundstimmung orientiert sich am Legacy-Snapshot von `amores-perros.de`:

- dunkle Flaechen fuer Navigation und Footer
- warmes Terrakotta als Akzentfarbe
- weisse und cremefarbene Typografie auf dunklen Zonen
- echte Fotomotive und Logos aus dem Legacy-Material statt generischer Platzhalter
- sparsam eingesetzte, manuell bedienbare Bild-Slider sind als contentnahe Ausnahme erlaubt, solange sie nicht autoplayen oder die Lesbarkeit stoeren

Die Startseite darf eine bildstarke Hero-Fläche verwenden. Unterseiten wie Kontakt, Erstgespraech oder Preise bekommen dagegen eine ruhigere, dunkel gefasste Seiten-Hero ohne grossflächiges Hintergrundbild, damit der Inhalt schneller lesbar und klarer getrennt ist.

Fuer grosse Fotos und Portraits wird AVIF als Primärformat mit WebP-Fallback genutzt. Logo- und Markenmotive werden ebenfalls in den zu ihrem sichtbaren Einsatz passenden Zielgroessen ausgeliefert, statt in den Originalabmessungen geladen zu werden.

Die Hauptnavigation im Header wird ueber Max Mega Menu an einer registrierten Theme-Location ausgespielt, damit Dropdowns klickbar bleiben und ohne Sonderlogik im WordPress-Backend pflegbar sind.

Die Umsetzung bleibt dennoch ein eigenes WordPress-Theme und keine 1:1-Kopie des alten Blocs-Layouts.

---

## 3. Zielgruppen

Die primäre Zielgruppe sind Hundehalterinnen und Hundehalter in Hamburg, die:

* konkrete Probleme im Alltag mit ihrem Hund erleben,
* eine individuelle Begleitung suchen,
* keine pauschalen Standardlösungen möchten,
* Zusammenhänge zwischen Mensch, Hund und Alltag verstehen wollen,
* bereit sind, an ihrer gemeinsamen Entwicklung zu arbeiten.

Typische Themen:

* Leinenführigkeit
* Alleinbleiben
* Grenzen und Regeln
* schwierige Hundebegegnungen
* Unsicherheit im Alltag
* reaktives Verhalten
* angespannte Spaziergänge
* Orientierung und Kommunikation
* allgemeine Beziehungs- und Alltagsthemen

Aggressive oder besonders schwierige Hunde werden nur nach vorheriger Absprache angenommen.

---

## 4. Hauptziel der Website

Die primäre Conversion ist:

> **Qualifizierte Anfrage senden**

Die Website bietet zunächst keine direkte Kalender- oder Terminbuchung an.

Interessenten sollen über ein strukturiertes Anfrageformular Angaben zu ihrer Situation machen. Anschließend wird der passende nächste Schritt persönlich abgestimmt.

### Primärer CTA

> Erstgespräch anfragen

### Sekundäre Kontaktmöglichkeiten

* WhatsApp
* Telefon
* E-Mail
* Kontaktformular

---

## 5. Angebotsstruktur

### Kernangebote

1. Erstgespräch
2. Einzeltraining

### Ergänzende Angebote

3. DOGSpace
4. Workshops und Seminare
5. Coaching mit Hund

Die Kernangebote werden in Navigation, Startseite und Call-to-Actions stärker gewichtet als die ergänzenden Leistungen.

---

## 6. Erstgespräch

Das Erstgespräch ist der bevorzugte Einstieg für neue Kunden.

### Ziel

* Situation einordnen
* Fragen zu Mensch, Hund und Alltag klären
* Ziele definieren
* nächsten sinnvollen Schritt festlegen

### Umfang

* Dauer: 60 Minuten
* Preis: 85 Euro

### Erwartungsmanagement

Das Erstgespräch bietet:

* eine individuelle Einordnung,
* eine erste fachliche Orientierung,
* eine Empfehlung für das weitere Vorgehen.

Es bietet nicht:

* ein pauschales Standardrezept,
* eine vollständige Problemlösung innerhalb einer Stunde,
* garantierte Ergebnisse,
* einen automatischen Einstieg in ein bestimmtes Trainingspaket.

---

## 7. Einzeltraining

Das Einzeltraining ist die zentrale operative Leistung.

### Positionierung

Individuelles Training für Mensch und Hund mit Fokus auf alltagstaugliche Lösungen, Beziehung und nachvollziehbare Entwicklungsschritte.

### Mögliche Trainingsorte

Der Trainingsort richtet sich nach dem jeweiligen Problem und kann beispielsweise stattfinden:

* draußen im Alltag,
* im Wohnumfeld des Kunden,
* an einem geeigneten öffentlichen Ort,
* im DOGSpace,
* an einem individuell vereinbarten Trainingsort.

Es wird kein einzelner fester Trainingsort für alle Fälle versprochen.

### Vorgehensweise

1. Situation beobachten
2. Verhalten und Zusammenhänge einordnen
3. realistisches Ziel definieren
4. konkrete Schritte entwickeln
5. Übungen in den Alltag übertragen
6. Fortschritte und Rückschritte auswerten
7. Vorgehen bei Bedarf anpassen

### Preise

* 45 Minuten: 65 Euro
* 90 Minuten: 110 Euro
* 5er-Karte: 280 Euro

### 5er-Karte

Die konkrete zeitliche Aufteilung und Nutzung der fünf Einheiten erfolgt flexibel nach Vereinbarung.

Die dokumentierte Gültigkeit beträgt drei Jahre.

---

## 8. Anfahrt und Ortsvereinbarungen

Da das Training je nach Problem an unterschiedlichen Orten stattfindet, werden Trainingsort, Anfahrt und mögliche zusätzliche Bedingungen individuell vereinbart.

Die Website soll daher keine pauschale Kilometerregel oder starre Anfahrtspreise nennen.

Empfohlener Hinweis:

> Trainingsort und mögliche Anfahrtskosten stimmen wir vor dem Termin individuell ab.

---

## 9. DOGSpace

DOGSpace ist ein begleiteter Raum in Hamburg für:

* Begegnung
* Austausch
* Hundecafé
* Stammtisch
* Workshops
* gemeinsame Lern- und Alltagssituationen

### Öffnungszeiten

Aktueller inhaltlicher Stand für die erste Planung:

Montag bis Freitag, 13:00 bis 18:00 Uhr.

Die finalen öffentlichen Öffnungszeiten müssen vor Launch noch bestätigt werden und dürfen nicht als hartcodierte Theme-Konstante umgesetzt werden.

### Voraussetzungen

* Nutzung nur mit vorheriger Anmeldung
* klare Absprachen
* ruhiger und begleiteter Rahmen
* Berücksichtigung von Hundeverträglichkeit und Gruppensituation

### Klare Abgrenzung

DOGSpace ist:

* kein Hundepark,
* kein unkontrollierter Freilauf,
* kein offener Hundespielplatz,
* kein Ersatz für individuelles Einzeltraining.

---

## 10. Workshops und Seminare

Workshops und Seminare werden bedarfsorientiert angeboten.

### Mögliche Themen

* Alltag und Beziehung
* Leinenführigkeit
* Hundebegegnungen
* Kommunikation
* Orientierung
* Umgang mit herausfordernden Situationen

### Organisation

* Durchführung im DOGSpace oder an einem passenden Ort
* keine erfundenen Termine
* kein dauerhaftes Kursprogramm versprechen
* spätere Erweiterung um echte Veranstaltungen möglich

In der ersten Theme-Version reicht eine statische Übersichtsseite. Ein eigener Event-Custom-Post-Type soll erst eingeführt werden, wenn regelmäßig mehrere Termine gepflegt werden.

---

## 11. Coaching mit Hund

Coaching mit Hund ist eine eigenständige Angebotslinie und wird vom klassischen Hundetraining klar abgegrenzt.

### Zielgruppe

Menschen, die:

* die Beziehung zu ihrem Hund reflektieren möchten,
* ihre eigene Haltung und Rolle betrachten wollen,
* Zusammenhänge zwischen persönlichem Verhalten, Alltag und Hund verstehen möchten,
* mehr als reine Trainingsanleitungen suchen.

### Hund im Coaching

Das Coaching erfolgt mit dem Hund des Kunden.

### Abgrenzung

Das Angebot ist:

* kein klassisches Hundetraining,
* kein pauschales Führungskräfte-Coaching,
* kein allgemeines Business-Coaching,
* kein therapeutisches Leistungsversprechen.

---

## 12. Über Jacky Rebien

Die Website verwendet durchgehend die Ich-Perspektive und Du-Ansprache.

### Öffentliche Qualifikationen

* Hundetrainerin nach § 11 TierSchG
* Resilienz Coach
* Mensch-Hund-Beraterin
* Mediatorin

### Inhaltlicher Fokus

Die Über-mich-Seite soll vermitteln:

* wer Jacky Rebien ist,
* wie sie arbeitet,
* warum Beziehung und Alltag zusammen betrachtet werden,
* welche fachlichen Grundlagen vorhanden sind,
* was ihre Begleitung von Standardangeboten unterscheidet.

Die Seite soll kein vollständiger chronologischer Lebenslauf werden.

---

## 13. Preise und Zahlungsarten

### Bestätigte Preise

| Angebot        | Preis | Umfang                                                |
| -------------- | ----: | ----------------------------------------------------- |
| Erstgespräch   |  85 € | 60 Minuten                                            |
| Einzeltraining |  65 € | 45 Minuten                                            |
| Einzeltraining | 110 € | 90 Minuten                                            |
| 5er-Karte      | 280 € | flexible Nutzung nach Vereinbarung, drei Jahre gültig |

### Zahlungsarten

* Überweisung
* Barzahlung
* Kartenzahlung
* PayPal

Für DOGSpace, Workshops und Coaching mit Hund werden keine Preise veröffentlicht, bis diese abschließend festgelegt sind.

Alle Preise und Zahlungsarten sind Content-Daten. Das Theme soll diese sauber darstellen, aber nicht als feste Werte in Templates, Patterns oder PHP hinterlegen.

---

## 14. Bewertungen und Referenzen

Aktuell liegen keine freigegebenen Kundenbewertungen vor.

Die erste Theme-Version darf daher:

* keine erfundenen Testimonials enthalten,
* keine Sternebewertungen simulieren,
* keine angeblichen Kundenzitate verwenden,
* keine Bewertungsanzahl anzeigen.

Das Theme darf ein deaktiviertes oder optionales Testimonial-Pattern enthalten, das später mit echten freigegebenen Bewertungen verwendet werden kann.

---

## 15. Logo

Für die lokale Entwicklung wird ein Dummy-Logo verwendet.

### Anforderungen an das Dummy-Logo

* Wortmarke „Beziehungssache Hund“
* optional einfache abstrakte Mensch-Hund-Linie
* keine geschützten Fremdelemente
* keine komplizierte Illustration
* als austauschbares SVG oder Bild eingebunden
* Logo darf nicht fest im Template codiert sein
* Austausch über die WordPress-Site-Logo-Funktion

Das Dummy-Logo ist ausschließlich ein Entwicklungsplatzhalter und darf nicht als finales Markenlogo behandelt werden.

---

## 16. Bildmaterial

Für die erste Entwicklungsphase werden Dummy-Fotos verwendet.

### Benötigte Platzhalter

* Hero-Foto Mensch und Hund
* Portrait von Jacky
* Trainingssituation
* DOGSpace
* Coaching mit Hund
* Workshop oder kleine Gruppe
* Kontakt- oder Abschlussbild

### Anforderungen

* einheitliche Bildformate
* leicht austauschbar
* keine Bilder fest im Theme-Code verankern
* responsive WordPress-Bildgrößen verwenden
* Alt-Texte als Platzhalter deutlich kennzeichnen
* keine fremden Bilder ohne passende Lizenz in die spätere Produktion übernehmen

Die Templates müssen auch funktionieren, wenn noch kein finales Bild hinterlegt wurde.

---

## 17. Seitenstruktur

```text
/
├── hundetraining-hamburg/
├── erstgespraech/
├── einzeltraining/
├── dogspace-hamburg/
├── workshops-seminare/
├── coaching-mit-hund/
├── ueber-jacky-rebien/
├── preise/
├── kontakt/
├── ratgeber/
├── impressum/
└── datenschutz/
```

### Hauptnavigation

* Start
* Hundetraining Hamburg
* Erstgespräch
* Einzeltraining
* DOGSpace
* Weitere Angebote
* Über mich
* Preise
* Kontakt

### Untermenü „Weitere Angebote“

* Workshops und Seminare
* Coaching mit Hund

### Hervorgehobener Header-CTA

> Erstgespräch anfragen

---

## 18. Startseitenstruktur

### 1. Hero

**Headline:**

> Individuelles Hundetraining in Hamburg

**Subline:**

> Für Mensch und Hund – mit Blick auf Beziehung, Alltag und klare nächste Schritte.

**CTAs:**

* Erstgespräch anfragen
* Angebote ansehen

### 2. Typische Situationen

* Spaziergänge sind regelmäßig angespannt.
* Dein Hund kann schlecht allein bleiben.
* Begegnungen mit anderen Hunden führen zu Stress.
* Grenzen und Regeln funktionieren im Alltag nicht.
* Du bist unsicher, welches Angebot zu euch passt.

### 2b. SEO-Einstieg Hundetraining Hamburg

Zusätzlich zur Startseite wird eine eigenständige Pillar Page `/hundetraining-hamburg/` benötigt.

Sie dient als zentraler SEO-Einstieg für das Thema Hundetraining in Hamburg und soll:

* das Leistungsfeld übergreifend einordnen,
* typische Alltagsthemen bündeln,
* sinnvoll auf Erstgespräch, Einzeltraining und passende Unterseiten verlinken,
* lokal relevante Orientierung bieten, ohne künstliche Stadtteilseiten zu erzeugen.

### 3. Arbeitsweise

1. Situation verstehen
2. Zusammenhänge erkennen
3. Ziele klären
4. alltagstaugliche Schritte entwickeln

### 4. Angebotsübersicht

Hervorgehoben:

* Erstgespräch
* Einzeltraining

Ergänzend:

* DOGSpace
* Coaching mit Hund
* Workshops und Seminare

### 5. Über Jacky

Kurze persönliche Einordnung mit:

* Dummy-Portrait
* Qualifikationen
* Arbeitsweise
* Link zur Über-mich-Seite

### 6. Preiseinstieg

* Erstgespräch: 85 Euro
* Einzeltraining ab 65 Euro

### 7. Abschluss-CTA

> Lass uns gemeinsam herausfinden, welcher nächste Schritt zu dir und deinem Hund passt.

Button:

> Erstgespräch anfragen

---

## 19. Kontaktseite

### Kontaktdaten

**Beziehungssache Hund**
Jacky Rebien
Bundesstraße 74
20144 Hamburg

E-Mail: [info@beziehungssache-hund.de](mailto:info@beziehungssache-hund.de)
Telefon: 01522 8385291

### Kontaktwege

* WhatsApp
* Telefon
* E-Mail
* Anfrageformular

Telefonnummern sollen technisch korrekt mit `tel:` verlinkt werden.

WhatsApp soll über einen klar gekennzeichneten externen Link geöffnet werden. Beim Einsatz von Tracking oder externen Widgets ist die Datenschutzwirkung zu berücksichtigen. Ein einfacher WhatsApp-Link ist einem schweren Drittanbieter-Widget vorzuziehen.

Kontaktdaten sind redaktionell pflegbare Stammdaten und dürfen nicht fest im Theme-Code dupliziert werden.

---

## 20. Anfrageformular

Das Formular soll eine qualifizierte Anfrage ermöglichen.

### Pflichtfelder

* Name
* E-Mail-Adresse
* Name des Hundes
* Alter des Hundes
* gewünschtes Angebot
* Beschreibung der Situation
* Datenschutz-Zustimmung

### Optionale Felder

* Telefonnummer
* bevorzugte Kontaktart
* bevorzugter Trainingsort
* zeitliche Verfügbarkeit

### Angebotsauswahl

* Erstgespräch
* Einzeltraining
* DOGSpace
* Workshop oder Seminar
* Coaching mit Hund
* Ich bin noch unsicher

### Bevorzugte Kontaktart

* WhatsApp
* Telefon
* E-Mail

### Technische Anforderungen

* serverseitige Validierung
* Spam-Schutz
* zugängliche Fehlermeldungen
* korrekte Formularbeschriftungen
* SMTP-Versand
* keine direkte Terminbuchung
* keine unnötige Erhebung sensibler Daten
* verständliche Erfolgsmeldung
* dokumentiertes Verhalten bei Versandfehlern

### Scope in Version 1

Das Theme stellt dafür den Formular-Bereich, passende Layouts und Einbindepunkte bereit.

Die eigentliche Formularlogik, SMTP-Anbindung, Spam-Abwehr und Versandverarbeitung sollen über genau ein Formularsystem umgesetzt werden, vorzugsweise per Plugin oder klar getrenntem Integrationsbaustein, nicht als ad-hoc Theme-Logik.

---

## 21. Sprache

Die Website wird ausschließlich auf Deutsch veröffentlicht.

### Tonalität

* Du-Ansprache
* Ich-Perspektive
* freundlich
* direkt
* ruhig
* verständlich
* fachlich, aber nicht akademisch
* keine englischen Template-Texte
* keine übertriebenen Werbeversprechen
* keine Garantien für Trainingserfolge

Mehrsprachigkeit muss in Version 1 nicht vorbereitet werden, solange dies keine unnötige Zusatzkomplexität verursacht.

---

## 22. Designrichtung

### Stil

* warm
* modern
* natürlich
* ruhig
* hochwertig
* professionell
* persönlich

### Vorläufige Farben

```text
Anthrazit:    #1F1A17
Warmes Grau:  #B8AEA2
Warmes Beige: #E8DCCB
Cremeweiß:    #FAF7F1
Terrakotta:   #AE7C4F
Dunkelbraun:  #0F0F0F
Hellgrau:     #E8E3DB
```

### Verwendung

* Anthrazit und Dunkelbraun: Header, Footer, Überschriften, Text
* Cremeweiß: Hauptflächen
* Beige: abgesetzte Inhaltsbereiche
* Terrakotta: primäre Buttons
* Warmes Grau: sekundäre Akzente
* Legacynahes Markenmaterial: Logo-Mark und persönliche Bildwelt aus dem alten Auftritt

### Typografie

Vorläufig:

* Überschriften: Lora
* Fließtext und Navigation: Inter

Die Schriften sollen lokal eingebunden werden.

### Gestaltung vermeiden

* Pfotenmuster als dominantes Element
* Comic-Hunde
* unnötige Slider
* Autoplay-Videos
* aggressive Animationen
* überladene Kartenlayouts
* verspielte Tierbedarf-Optik
* zufällige Farbvarianten im Editor

---

## 23. WordPress-Architektur

### Theme-Typ

Eigenes WordPress Block Theme.

### Editor

* Gutenberg
* Full Site Editing
* wiederverwendbare Block Patterns
* zentrale Designsteuerung über `theme.json`

### Nicht verwenden

* Elementor
* Divi
* WPBakery
* proprietäre Theme Builder
* unnötige JavaScript-Frameworks

### Inhaltstypen in Version 1

Standardseiten für:

* Startseite
* Hundetraining Hamburg
* Erstgespräch
* Einzeltraining
* DOGSpace
* Workshops und Seminare
* Coaching mit Hund
* Über mich
* Preise
* Kontakt
* Impressum
* Datenschutz

Zusätzlich eine Beitragsübersicht für den Ratgeber.

WordPress-Beiträge für:

* Ratgeber
* Fachartikel
* lokale Inhalte

### Noch keine Custom Post Types

In Version 1 werden keine Custom Post Types für Services, Testimonials oder FAQs benötigt.

Ein Event-Custom-Post-Type kann später ergänzt werden, sobald tatsächlich regelmäßig Termine gepflegt werden.

---

## 24. Benötigte Patterns

* Startseiten-Hero
* Service-Hero
* Hero ohne Bild
* Problemkarten
* Angebotsübersicht
* Prozessschritte
* Trainerprofil
* Qualifikationsliste
* Preiskarten
* DOGSpace-Infoblock
* Zahlungsarten
* Kontaktinformationen
* Kontakt-CTA
* Anfrageformular-Bereich
* FAQ-Bereich
* Ratgeber-Teaser
* Abschluss-CTA
* optionales Testimonial-Pattern ohne Dummy-Bewertungen

### Anforderungen an Patterns

* vollständig responsiv
* Inhalte im Editor änderbar
* Design Tokens aus `theme.json`
* keine hartcodierten Farben
* keine Inline-Styles
* semantische HTML-Struktur
* korrekte Überschriftenhierarchie
* Tastaturbedienbarkeit
* ausreichende Kontraste
* austauschbare Bilder und Logos

---

## 25. SEO-Grundstruktur

### Primäre Themen

| Seite          | Primärer Suchintent                |
| -------------- | ---------------------------------- |
| Startseite     | Hundetraining Hamburg              |
| Erstgespräch   | Erstgespräch Hundetraining Hamburg |
| Einzeltraining | Einzeltraining Hund Hamburg        |
| DOGSpace       | DOGSpace Hamburg                   |
| Workshops      | Workshops Hund Hamburg             |
| Coaching       | Coaching mit Hund                  |
| Über mich      | Hundetrainerin Hamburg             |
| Preise         | Preise Hundetraining Hamburg       |
| Kontakt        | Kontakt Hundetraining Hamburg      |

### SEO-Grundsätze

* keine Keyword-Überladung
* individuelle Seitentitel
* individuelle Meta Descriptions
* selbstreferenzierende Canonicals
* Open-Graph-Metadaten
* XML-Sitemap
* Breadcrumbs
* klare interne Verlinkung
* konsistente Unternehmensdaten
* sprechende deutsche URLs
* keine erfundenen Bewertungen
* keine künstlichen Stadtteilseiten ohne echten Inhalt

Die URL-Zielarchitektur aus `docs/seo/url-map.md` ist maßgeblich und muss von Theme-Templates, Navigation und interner Verlinkung vollständig unterstützt werden.

### Strukturierte Daten

* `WebSite`
* `LocalBusiness`
* `Person`
* `Service`
* `ContactPage`
* `BreadcrumbList`
* `FAQPage` nur bei echten sichtbaren FAQs
* `Event` erst bei realen Veranstaltungen

---

## 26. Performance

### Ziele

* möglichst wenig eigenes JavaScript
* keine Page-Builder-Abhängigkeit
* keine unnötigen Frontend-Bibliotheken
* lokale Schriftarten
* responsive Bilder
* moderne Bildformate
* minimales CSS
* keine Preloader
* keine schweren Animationen
* keine automatischen Slider
* Drittanbieter-Skripte nur bei nachvollziehbarem Nutzen

### Orientierungswerte

* Lighthouse Performance mobil möglichst über 90
* LCP unter 2,5 Sekunden
* CLS unter 0,1
* INP unter 200 Millisekunden

---

## 27. Barrierefreiheit

Das Theme soll mindestens folgende Anforderungen berücksichtigen:

* semantische Landmarken
* sichtbare Fokuszustände
* vollständige Tastaturbedienbarkeit
* Skip-Link
* verständliche Linktexte
* korrekte Formular-Labels
* zugängliche Fehlerhinweise
* ausreichende Farbkontraste
* keine Information ausschließlich über Farbe
* sinnvolle Überschriftenstruktur
* Unterstützung von `prefers-reduced-motion`
* Alt-Texte über die Medienbibliothek pflegbar

---

## 28. Lokale Entwicklung

Die Website wird zunächst lokal entwickelt.

### Empfohlene Umgebung

* Docker Compose
* WordPress
* MariaDB oder MySQL
* optional Mailpit für lokalen E-Mail-Test
* WP-CLI
* Theme-Verzeichnis als lokales Volume
* versionierte Projektdateien
* `.env.example`
* keine produktiven Zugangsdaten im Repository

### Lokale Testdaten

Codex darf erstellen:

* Dummy-Logo
* Dummy-Fotos
* Beispielseiten
* Beispielnavigation
* lokale Formularziele
* nicht produktive Demo-Inhalte

Dummy-Inhalte müssen eindeutig als Platzhalter erkennbar und leicht austauschbar sein.

---

## 29. Deployment

Das Deployment erfolgt später manuell.

Die erste Implementierungsphase soll daher:

* keine automatische Produktionsbereitstellung erstellen,
* keine Annahmen über Strato-Zugänge treffen,
* keine produktiven Zugangsdaten benötigen,
* das Theme als installierbares ZIP exportierbar machen,
* eine Deployment-Anleitung dokumentieren,
* eine Liste benötigter Plugins bereitstellen,
* Datenbankinhalte und Theme-Code klar voneinander trennen.

---

## 30. Definition of Done für die erste Theme-Version

Die erste Version ist abgeschlossen, wenn:

* das Theme lokal installierbar und aktivierbar ist,
* alle vorgesehenen Templates vorhanden sind,
* Header und Footer responsiv funktionieren,
* Dummy-Logo austauschbar ist,
* Dummy-Fotos austauschbar sind,
* alle Kernseiten angelegt oder als importierbare Inhalte vorbereitet sind,
* die Navigation funktioniert,
* das Anfrageformular eingebunden und lokal testbar ist,
* WhatsApp-, Telefon- und E-Mail-Links funktionieren,
* Preise konsistent dargestellt werden,
* keine erfundenen Bewertungen enthalten sind,
* `theme.json` das Design-System zentral steuert,
* Patterns im Editor verwendbar sind,
* mobile Darstellung geprüft wurde,
* grundlegende Accessibility-Checks bestanden sind,
* keine offensichtlichen PHP- oder JavaScript-Fehler auftreten,
* das Theme als ZIP erzeugt werden kann,
* lokale Einrichtung und manuelles Deployment dokumentiert sind.
