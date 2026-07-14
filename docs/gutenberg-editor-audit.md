# Gutenberg Editor Audit

Stand: 14. Juli 2026

## Zusammenfassung

Die Hauptursache war keine einzelne Gutenberg-Sperre, sondern eine Vermischung von redaktionellem Inhalt und Theme-Erzeugung. Kanonische Seiten enthielten grosse `core/html`-Bloecke und nicht aufgeloeste `core/pattern`-Referenzen. FAQ, Bildgalerien und einzelne Inhaltskarten waren dadurch nur als undurchsichtige Markup-Pakete oder nur nach einer Codeaenderung pflegbar. Zusaetzlich ueberschrieb das Setup vorhandenen Seiteninhalt, der Editor lud nicht alle relevanten Frontend-Styles, und ein gespeicherter Header-Template-Part ueberlagerte die Theme-Datei.

Betroffen waren alle 14 kanonischen Seiten, besonders Startseite, FAQ, Kontakt, Angebotsseiten und globale Navigation. Das Risiko war hoch: redaktionelle Aenderungen konnten beim naechsten Setup-Lauf verloren gehen, Theme-Aenderungen konnten wegen Datenbank-Overrides unsichtbar bleiben, und komplexes HTML war im visuellen Editor nicht sinnvoll bearbeitbar.

Die Zielarchitektur verwendet schlanke Templates, normalen `post_content`, Core-Bloecke, nicht synchronisierte Patterns als Ausgangslayouts, Core Navigation im Site Editor und eine idempotente WP-CLI-Migration. Es wurden keine Custom Blocks und kein Page Builder eingefuehrt.

## Umgebung

| Pruefpunkt | Ergebnis |
| --- | --- |
| WordPress | 7.0.1 |
| Aktives Theme | `beziehungssache-hund` 0.3.0, kein Child Theme |
| PHP | 8.4.22 |
| Datenbank | MariaDB 11.4.12 |
| WP-CLI | 2.12.0 |
| Gutenberg-Plugin | nicht installiert; Core Gutenberg wird verwendet |
| Aktive Plugins nach Migration | Duplicator 1.5.16.1, Forminator 1.55.1, Yoast SEO 28.0 |
| Deaktiviertes Plugin | Max Mega Menu 3.10.6; durch Core Navigation ersetzt |
| MU-Plugins | lokale Mailpit-Anbindung, Yoast-Sync, Editor-first-Migration |
| Build-Prozess | kein Theme-Build; Node/Playwright nur fuer Browser- und Visual-Tests |
| Custom Blocks | keine projektbezogenen Custom Blocks |
| Geschaeftliche CPTs | keine; nur Core- und Forminator-Post-Types |
| Shortcodes | Core-, Forminator-, Yoast- und Plugin-Shortcodes; Kontaktformular bleibt Forminator |

`wp block-type list` ist in der vorhandenen WP-CLI-Version nicht verfuegbar. Als sichere Alternative wurde die registrierte Block-Type-Registry per WP-CLI ausgewertet. Neben Core-Bloecken waren nur Plugin-Bloecke von Yoast und Max Mega Menu registriert; das Theme registriert keine Custom Blocks.

## Inhaltsmatrix

| Seite | Abschnitt | aktuelle Quelle vor Migration | im Editor bearbeitbar | Problem | Zielarchitektur |
| --- | --- | --- | --- | --- | --- |
| Startseite | Hero, Intro, Angebote, B.O.N.D., CTA | `post_content`, Theme-Patterns, `core/html` | teilweise | Pattern-Referenzen und HTML-Bloecke banden Inhalte an PHP | unabhaengige Core-Bloecke in `post_content` |
| Hundetraining Hamburg | Intro, Leistungen, CTA | `post_content`, Pattern-Referenzen | teilweise | Layout nur ueber Theme-Pattern reproduzierbar | aufgeloeste Core-Bloecke |
| Erstgespraech | Intro, Preis, Ablauf, CTA | `post_content`, `core/html` | teilweise | Eyebrow und Medien-Markup nicht nativ | Paragraph, Image, Group, Buttons |
| Einzeltraining | Intro, Themen, Preise, FAQ-Links | `post_content`, Patterns | teilweise | wiederverwendetes Markup blieb codeabhaengig | unabhaengige Core-Bloecke und Links |
| DOGSpace | Intro, Angebot, Galerie, CTA | `post_content`, `core/html` | teilweise | Bildergalerie war ein HTML-String | Core Gallery und Core Image |
| Workshops und Seminare | Intro, Angebot, CTA | `post_content`, Patterns | teilweise | Theme-Referenzen statt Seitenbloecken | normale Seitenbloecke |
| Coaching mit Hund | Intro, Angebot, CTA | `post_content`, Patterns | teilweise | Theme-Referenzen statt Seitenbloecken | normale Seitenbloecke |
| Ueber Jacky Rebien | Profil, Bild, Haltung, CTA | `post_content`, Pattern, HTML-Bild | teilweise | Bild und Profil an PHP gebunden | Core Image, Heading, Paragraph |
| Preise | Preiskarten, Hinweise, CTA | `post_content`, Patterns | teilweise | Preise nur indirekt im Layout pflegbar | Core Groups, Headings, Paragraphs, Lists |
| Kontakt | Kontaktdaten, Formular, CTA | `post_content`, Shortcode | ja/teilweise | Formular technisch als Shortcode; Umfeld teils Pattern | Core-Bloecke plus dokumentierter Forminator-Shortcode |
| FAQ | Navigation, Fragen, Antworten, CTA | drei grosse `core/html`-Bloecke | nein | Fragen und Antworten waren undurchsichtige HTML-Strings | Core Details, Heading, Paragraph, List |
| Ratgeber | Intro und Beitragsausgabe | `post_content`, Template | ja | keine wesentliche Editor-Sperre | normaler Inhalt plus Query-/Home-Template |
| Impressum | Rechtstext | `post_content` | ja | rechtliche Freigabe bleibt erforderlich | normale Core-Bloecke |
| Datenschutz | Rechtstext | `post_content` | ja | rechtliche Freigabe bleibt erforderlich | normale Core-Bloecke |
| Global | Header und Navigation | `wp_template_part` ID 411 | teilweise | Datenbankversion ueberlagerte Theme-Datei; Plugin-Navigation | behaltenes und migriertes Template-Part mit Site Logo/Core Navigation |
| Global | Footer | Theme-Template-Part | teilweise | Logo als hart codiertes Picture | Core Site Logo im Template-Part |
| Global | Design Tokens | `theme.json` plus `wp_global_styles` ID 32 | teilweise | alte DB-Palette widersprach dem Theme | Override gesichert und auf leere Einstellungen normalisiert |
| Experimental | Landing 2, Kitesplash | PHP-Patterns mit HTML/Pattern-Referenzen | nein | nicht Teil des kanonischen Seitenbaums | vor Nutzung separat auf Core-Bloecke migrieren |

Nach Migration enthalten alle 14 kanonischen Seiten weder `core/html` noch nicht aufgeloeste `core/pattern`-Bloecke.

Ein nachgelagerter Editor-Akzeptanztest zeigte zwei weitere WordPress-7.0-spezifische Ursachen: expandierte Patterns behielten `metadata.patternName` und wurden deshalb weiter als verbundene Vorlagen behandelt; Bildbloecke referenzierten Theme-Dateien ohne Attachment-ID. Beide Zustaende sind mit Migration V6 behoben. Die neun Startseitenbilder besitzen jetzt Medien-IDs, und die sieben Startseiten-Patterninstanzen sind normale unabhaengige Gruppen.

## Block-Locking

In Templates, Template-Parts, Patterns und Seiteninhalt wurden kein `templateLock`, kein `contentOnly` und keine individuellen `lock`-Attribute gefunden. WordPress 7.0 setzte fuer die kanonischen Seiten keinen nicht verlassbaren Content-only-Modus durch. Die List View und normale Blocknavigation bleiben verfuegbar.

Klassifikation:

| Sperre | Bewertung | Massnahme |
| --- | --- | --- |
| Template-Lock | nicht vorhanden | keine |
| Content-only | nicht vorhanden | keine |
| Move-/Remove-Lock | nicht vorhanden | keine |
| `allowedBlocks` | nicht restriktiv gesetzt | keine |

## Datenbank-Overrides

- `wp_template`: keine gespeicherten Overrides.
- `wp_template_part`: Header ID 411 war eine Site-Editor-Version und ueberschrieb `parts/header.html`. Der Datensatz wurde nicht geloescht, sondern gesichert und auf native Core-Bloecke migriert.
- `wp_block`: keine Synced Patterns vorhanden.
- `wp_global_styles`: ID 32 enthielt eine abweichende Palette. Der Inhalt wurde gesichert und auf leere benutzerspezifische Einstellungen normalisiert, damit `theme.json` wieder kanonisch ist.
- `wp_navigation`: ID 413 war vorhanden. Die aktive Header-Ausgabe verwendet nun den Core Navigation Block; der Datensatz bleibt erhalten.

## Findings

### GEA-001

ID: GEA-001  
Schweregrad: HIGH  
Dateien: `seed-content.php`, `inc/hero-images.php`, mehrere Seiten in der Datenbank  
Betroffene Seiten: alle kanonischen Seiten, besonders Startseite, DOGSpace und Ueber mich  
Beobachtung: Redaktionelle Bilder, Karten und Abschnittsteile lagen in `core/html`.  
Technische Ursache: PHP-Helfer erzeugten grosse HTML-Strings statt serialisiertem Core-Block-Markup.  
Auswirkung auf Redakteure: Bilder, Alt-Texte, Links und Texte waren nicht als einzelne Bloecke erreichbar.  
Empfohlene Lösung: Native Image-, Gallery-, Group-, Heading-, Paragraph- und Button-Bloecke.  
Migrationsrisiko: Markup- und Abstandsveraenderungen bei der Umwandlung.  
Validierung: Alle 14 Seiten im Editor geoeffnet; kein Invalid-Block-Hinweis; Visual-Baselines aktualisiert und geprueft.

### GEA-002

ID: GEA-002  
Schweregrad: HIGH  
Dateien: `seed-content.php`, `patterns/`  
Betroffene Seiten: alle aus Patterns aufgebauten Angebotsseiten  
Beobachtung: Gespeicherte `core/pattern`-Referenzen machten bestehende Seiten von Theme-PHP abhaengig.  
Technische Ursache: Seed-Inhalte speicherten Referenzen, statt nicht synchronisierte Patterns in unabhaengige Bloecke aufzulösen.  
Auswirkung auf Redakteure: Struktur und Inhalt konnten durch Theme-Code beeinflusst werden.  
Empfohlene Lösung: Referenzen einmalig expandieren und anschliessend normalen `post_content` besitzen lassen.  
Migrationsrisiko: Doppelte Expansion bei nicht idempotenter Migration.  
Validierung: Migration erkennt Version und Legacy-Hash; wiederholter Dry-Run meldet nur Skips.

### GEA-003

ID: GEA-003  
Schweregrad: BLOCKER  
Dateien: `seed-content.php`, `scripts/wordpress-install.sh`  
Betroffene Seiten: alle kanonischen Seiten  
Beobachtung: Wiederholte Installation schrieb den generierten Inhalt erneut in bestehende Seiten.  
Technische Ursache: Upsert behandelte Theme-Seeds als dauerhaft kanonische Inhaltsquelle.  
Auswirkung auf Redakteure: Gutenberg-Aenderungen konnten verloren gehen.  
Empfohlene Lösung: Nur leere Seiten seeden; bestehende redaktionelle Inhalte niemals ueberschreiben.  
Migrationsrisiko: Frische Installationen muessen weiterhin vollstaendig erzeugt werden.  
Validierung: Library-only-Modus und Schutz fuer nichtleeren `post_content`; Setup-Logik syntaktisch und per WP-CLI geprueft.

### GEA-004

ID: GEA-004  
Schweregrad: HIGH  
Dateien: `inc/faq.php`, `assets/css/faq.css`, `functions.php`  
Betroffene Seiten: FAQ  
Beobachtung: FAQ-Inhalt bestand aus drei grossen HTML-Bloecken.  
Technische Ursache: Fragen, Antworten, Listen, Navigation und JSON-LD wurden als HTML-String generiert.  
Auswirkung auf Redakteure: Keine direkte Bearbeitung einzelner Fragen und Antworten.  
Empfohlene Lösung: Core Details und normale Text-/Listenbloecke; Schema dynamisch aus gespeichertem Blockinhalt erzeugen.  
Migrationsrisiko: Deep Links und Schema koennten auseinanderlaufen.  
Validierung: Eindeutige Anker, Deep Links, Browser-History, Fokus und mehrere offene Details sind automatisiert getestet.

### GEA-005

ID: GEA-005  
Schweregrad: HIGH  
Dateien: `inc/hero-images.php`, `assets/js/image-slider.js`, `assets/css/editor.css`  
Betroffene Seiten: Startseite, DOGSpace, Ueber mich und weitere bildreiche Seiten  
Beobachtung: Responsive Pictures und Slider waren nur im Code austauschbar.  
Technische Ursache: Manuell aufgebautes Picture-/Slider-Markup ohne Medienblock.  
Auswirkung auf Redakteure: Bild, Alt-Text und Reihenfolge waren nicht nativ pflegbar.  
Empfohlene Lösung: Core Image/Gallery; Slider nur als progressive Frontend-Erweiterung anhand einer Blockklasse.  
Migrationsrisiko: Gespeichertes Image-Markup muss exakt der Core-Serialisierung entsprechen.  
Validierung: Eine anfangs erkannte Validierungsabweichung bei nicht gespeicherten Image-Attributen wurde in Migration V2 repariert; danach alle Seiten ohne Warnung.

### GEA-006

ID: GEA-006  
Schweregrad: MEDIUM  
Dateien: `functions.php`, `assets/css/editor.css`, `assets/css/faq.css`, `style.css`  
Betroffene Seiten: alle  
Beobachtung: FAQ- und Editor-spezifische Inhaltsstyles fehlten im iframe-basierten Editor.  
Technische Ursache: `add_editor_style` band nur einen Teil der Frontend-Styles ein.  
Auswirkung auf Redakteure: Abstaende, FAQ und Slider entsprachen nicht dem Frontend oder erschwerten die Auswahl.  
Empfohlene Lösung: Inhaltsspezifische Styles im Editor laden und interaktive Frontend-Anordnung dort als bearbeitbares Grid darstellen.  
Migrationsrisiko: Frontend-Regeln duerfen keine Editor-UI ueberlagern.  
Validierung: Editor-iframe auf allen kanonischen Seiten geladen; Inhalte auswählbar und editierbar.

### GEA-007

ID: GEA-007  
Schweregrad: HIGH  
Dateien: `parts/header.html`, Datenbank-Template-Part ID 411  
Betroffene Seiten: globaler Header  
Beobachtung: Eine gespeicherte Header-Version maskierte die Theme-Datei und verwendete Max Mega Menu.  
Technische Ursache: Block Themes priorisieren gespeicherte `wp_template_part`-Anpassungen.  
Auswirkung auf Redakteure: Codeaenderungen griffen nicht; Navigation war an ein Plugin gebunden.  
Empfohlene Lösung: Override sichern und in place auf Site Logo plus Core Navigation migrieren.  
Migrationsrisiko: Verlust lokaler Navigation bei blindem Loeschen.  
Validierung: Kein Datensatz geloescht; Header, Navigation und Footer direkt im Site Editor automatisiert geoeffnet.

### GEA-008

ID: GEA-008  
Schweregrad: MEDIUM  
Dateien: `theme.json`, `style.css`, Datenbank-Global-Styles ID 32  
Betroffene Seiten: global  
Beobachtung: Die gespeicherte Palette wich von den Theme-Tokens ab.  
Technische Ursache: Alte Site-Editor-Anpassungen ueberschrieben `theme.json`.  
Auswirkung auf Redakteure: Editor und Frontend konnten unterschiedliche Designwerte anbieten.  
Empfohlene Lösung: Override sichern und nur benutzerspezifische Einstellungen normalisieren; Design-Tokens zentral in `theme.json`.  
Migrationsrisiko: Absichtlich gesetzte globale Stilvarianten koennten entfallen.  
Validierung: Vorherige JSON-Daten als Post Meta gesichert; Theme-Palette und Visual-Tests geprueft.

### GEA-009

ID: GEA-009  
Schweregrad: INFO  
Dateien: Theme-Templates, Patterns und Datenbankinhalte  
Betroffene Seiten: alle  
Beobachtung: Es gab keine unbeabsichtigten Block-Sperren und keine projektbezogenen Custom Blocks.  
Technische Ursache: nicht zutreffend.  
Auswirkung auf Redakteure: Nach Entfernung der HTML-/Pattern-Barrieren sind Move, Duplicate, Remove und Insert regulaer verfuegbar.  
Empfohlene Lösung: Lock-freien Standard beibehalten; Custom Blocks nur bei echter Spezialfunktionalitaet.  
Migrationsrisiko: keines.  
Validierung: Quellcode- und Block-Attributsuche sowie Editor-Tests.

### GEA-010

ID: GEA-010  
Schweregrad: MEDIUM  
Dateien: `patterns/landing-2.php`, `patterns/kitesplash.php`  
Betroffene Seiten: keine kanonische Seite  
Beobachtung: Zwei experimentelle Demo-Patterns enthalten weiterhin HTML-/Pattern-Konstruktionen.  
Technische Ursache: Sie gehoeren nicht zum dokumentierten Seitenbaum und wurden nicht in die Inhaltsmigration aufgenommen.  
Auswirkung auf Redakteure: Bei spaeterer Verwendung waeren Teile nicht editor-first.  
Empfohlene Lösung: Vor Freigabe separat in Core-Bloecke umsetzen oder entfernen, nachdem die fachliche Verwendung entschieden wurde.  
Migrationsrisiko: Unbeabsichtigte Aenderung nicht freigegebener Experimente.  
Validierung: Kein Vorkommen dieser Patterns in den 14 kanonischen Seiten.

### GEA-011

ID: GEA-011  
Schweregrad: BLOCKER  
Dateien: Datenbankinhalt der Startseite, `site-editor-migration.php`, gespeicherte Benutzerpraeferenzen  
Betroffene Seiten: Startseite und weitere aus Patterns erzeugte Seiten  
Beobachtung: Bildbloecke zeigten zwar eine Ersetzen-Schaltflaeche, waren aber nicht als Medien-Attachments gespeichert; ausserdem wurden expandierte Abschnitte weiter als verbundene Vorlagen angezeigt.  
Technische Ursache: Fehlende `id`-Attribute in `core/image`, verbliebenes `metadata.patternName` und die Kombination aus oberer Werkzeugleiste plus ablenkungsfreiem Modus.  
Auswirkung auf Redakteure: Der normale Austausch ueber die Mediathek war nicht verlaesslich erreichbar; Abschnitte erschienen als `Vorlage` statt als unabhaengiger Seiteninhalt.  
Empfohlene Lösung: Theme-Bilder idempotent importieren, Attachment-IDs setzen, Pattern-Metadaten beim Expandieren entfernen und die kollidierende lokale Editor-Praeferenz gesichert normalisieren.  
Migrationsrisiko: Medien-Duplikate oder Ueberschreiben bereits geaenderter Seiteninhalte.  
Validierung: Migration transformiert vorhandenen `post_content` in place, verwendet Quellmarker gegen Duplikate und der Browser-Test oeffnet `Ersetzen` > `Mediathek öffnen` bis zum Dialog.

## Entscheidungsuebersicht

| Komponente | Entscheidung | Begruendung |
| --- | --- | --- |
| Core Block | Standard fuer Text, Bild, Galerie, Liste, Button, Details, Layout und Navigation | beste Editor-, A11y- und Migrationsunterstuetzung |
| Pattern | nicht synchronisierte Ausgangslayouts | nach Einfuegen unabhaengig bearbeitbar |
| Synced Pattern | aktuell keines angelegt | keine fachlich bestaetigte globale Inhaltsinstanz ausser Template-Parts |
| Pattern mit Overrides | aktuell nicht erforderlich | kein bestaetigter Anwendungsfall mit zentralem Layout und instanzspezifischem Inhalt |
| Custom Block | keiner | Core-Bloecke decken die Anforderungen ab |
| Dynamischer Block | Forminator-Shortcode bleibt Plugin-Verantwortung; FAQ-Schema serverseitig aus Inhalt | portable Formularlogik und konsistentes Schema ohne Inhaltsduplikat |
| Template Part | Header und Footer | echte globale Site-Struktur, im Site Editor pflegbar |
| Normale Seiteninhalte | alle seitenspezifischen Texte, Preise, Bilder, Links, FAQs und CTAs | volle redaktionelle Kontrolle in `post_content` |

## Diagnose

Die Editor- und Frontend-Pruefungen fanden nach der Reparatur keine Block-Validation-Warnings, JavaScript-Ausnahmen, fehlenden Assets, defekten Bilder, doppelten IDs oder Same-Origin-HTTP-Fehler. REST-Index und REST-Seitenendpunkt antworteten mit HTTP 200. Der PHP-Debug-Log erhielt waehrend Migration und Abschlusslauf keinen neuen Eintrag; aeltere Meldungen vor dem Refactoring sind im Verifikationsbericht abgegrenzt.
