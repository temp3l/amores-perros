# Gutenberg Verification Report

Stand: 14. Juli 2026

## Ergebnis

Die 14 kanonischen Seiten sind als native Gutenberg-Inhalte migriert und im visuellen Editor ohne Invalid-Block-Warnung geoeffnet worden. Header, Footer und Core Navigation sind im Site Editor erreichbar. Frontend- und Editor-Tests zeigen keine funktionale Regression.

## Automatisierte Pruefungen

### WP-CLI

```bash
docker compose run --rm wp-cli site-editor-migration audit
docker compose run --rm wp-cli site-editor-migration migrate --dry-run
docker compose run --rm wp-cli site-editor-migration verify
```

Ergebnis:

- 14 von 14 Seiten im Status `migrated`.
- 14 von 14 Seiten ohne `core/html` und ohne `core/pattern`.
- Ein dokumentierter Forminator-Shortcode auf Kontakt.
- Wiederholter Dry-Run ohne Datenbankaenderung.
- Verify: `Alle migrierten Seiten und der Header sind editor-first verifiziert.`

### Gutenberg- und Site-Editor-Smoke-Test

`tests/visual/editor-first.spec.ts` meldet:

- alle 14 kanonischen Seiten im WordPress-7.0-Editor-iframe geladen.
- kein Text `unerwarteter oder ungueltiger Inhalt` beziehungsweise `unexpected or invalid content`.
- editierbarer Canvas vorhanden.
- neun Startseiten-Bildbloecke mit Medien-ID gefunden.
- jeder Startseiten-Bildblock stellt `Ersetzen` bereit.
- `Ersetzen` > `Mediathek öffnen` oeffnet den WordPress-Mediendialog.
- keine expandierte Patterninstanz wird weiter ueber `metadata.patternName` als verbundene Vorlage behandelt.
- Header-Template-Part im Site Editor geoeffnet.
- Core Navigation im Header gefunden.
- Footer-Template-Part im Site Editor geoeffnet.

Die Editor-Smoke-Tests laufen nur im Desktop-Projekt; ihre drei Mobile-Duplikate werden absichtlich uebersprungen, weil der WordPress-Editor-iframe nicht viewportabhaengig doppelt getestet werden muss.

### Frontend und technische Laufzeit

Die 14 kanonischen Frontends wurden geprueft auf:

- JavaScript-`pageerror` und Console Errors.
- Same-Origin-Requests mit HTTP-Status ab 400.
- defekte Bilder und fehlende Assets.
- doppelte HTML-IDs.
- FAQ-Anker und eindeutige Fragetexte.
- Deep Links, Fokus nach Hash-Navigation und Browser-History.
- mehrere gleichzeitig geoeffnete FAQ-Details.
- Funktion ohne JavaScript.
- `prefers-reduced-motion`.

Ergebnis: keine Fehler in diesen Pruefungen.

### Visuelle Regression

```bash
./scripts/visual-check.sh check
```

Abschluss: `42 passed`, `4 skipped`, Exit Code 0. Desktop- und Mobile-Baselines fuer 12 geschaeftskritische Seiten stimmen ueberein. Die Ganzseitenvergleiche erlauben maximal fuenf abweichende Pixel, um nichtdeterministisches Subpixel-Antialiasing abzufangen; strukturelle Abweichungen bleiben dadurch weiterhin sichtbar.

### Syntax und Metadaten

Ergebnis:

- alle acht geaenderten PHP-Einstiegspunkte ohne Syntaxfehler.
- Slider- und Report-JavaScript bestehen `node --check`.
- `theme.json` ist syntaktisch valides JSON und verwendet Schema/Version 3.
- Installations- und Visual-Shellskript bestehen `bash -n`.
- `git diff --check` meldet keine Whitespace-Fehler.
- keine Aenderung unter WordPress Core, `vendor/`, `node_modules/` oder `amores-perros/`.

### REST und Debugging

- REST-Index `/wp-json/`: HTTP 200.
- migrierte Seite `/wp-json/wp/v2/pages/5?context=view`: HTTP 200.
- Der PHP-Debug-Log erhielt waehrend Migration und Abschlusslauf keine neue Meldung.
- Vorhandene historische Eintraege betreffen `bsh-yoast-sync` am 30. Juni, Duplicator-Warnings, Core-Widget-Deprecations und damals fehlende Pattern-Dateien. Der neueste Eintrag stammt vom 14. Juli 2026 um 10:36:43 UTC und liegt vor dem finalen Refactoring-/Testlauf.

## Editor-Akzeptanzabdeckung

| Aktion | Status | Nachweis |
| --- | --- | --- |
| Seite im visuellen Editor oeffnen | bestanden | automatisiert auf 14 Seiten |
| Ueberschrift/Absatz bearbeiten | technisch freigegeben | native Heading-/Paragraph-Bloecke, editierbarer Canvas |
| Bild/Alt-Text bearbeiten | technisch freigegeben | native Image-/Gallery-Bloecke mit Medien-IDs |
| Button-Text/Link bearbeiten | technisch freigegeben | native Button-Bloecke |
| Abschnitt verschieben/duplizieren/loeschen | technisch freigegeben | keine Locks, normale Group-Bloecke |
| Abschnitt aus-/einblenden | technisch freigegeben | registrierter Core-Group-Stil `bsh-hidden`; im Editor weiterhin sichtbar |
| neuen Block einfuegen | technisch freigegeben | kein `templateLock`/`contentOnly`/`allowedBlocks` |
| speichern/neu laden | bestanden | Migration und Editor-Laden gegen gespeicherten Inhalt |
| Revision wiederherstellen | vorbereitet | Revisionen und Migrationsbackup vorhanden |
| Frontend pruefen | bestanden | technische und visuelle Browser-Suite |

Die automatisierte Suite veraendert absichtlich keine veroeffentlichten fachlichen Texte und stellt keine Revision destruktiv wieder her. Die konkreten Klickfolgen fuer Bearbeiten, Duplizieren, Loeschen und Wiederherstellen sind daher vor Launch einmal mit einer Testkopie manuell zu bestaetigen.

## Site-Editor-Abdeckung

| Aktion | Status |
| --- | --- |
| Header oeffnen | bestanden |
| Footer oeffnen | bestanden |
| Navigation oeffnen | bestanden |
| Site Logo als Core Block vorhanden | bestanden |
| Template oeffnen | bestanden |
| Global Styles aus `theme.json` laden | bestanden |
| Veraendern und speichern | manuelle Launch-Pruefung, um globale Produktionsaenderungen zu vermeiden |

## Barrierefreiheit

- Skip-Link bleibt vorhanden.
- Globale sichtbare `:focus-visible`-Zustaende sind definiert.
- FAQ basiert auf nativen `details`/`summary`-Elementen.
- FAQ-Deep-Links setzen den Fokus auf die Summary.
- Slider autoplayt nicht und bleibt ohne JavaScript lesbar.
- Reduced Motion deaktiviert Bewegungen.
- Ueberschriftenstruktur und doppelte IDs wurden automatisiert geprueft; ein vollstaendiger manueller Screenreader-Test bleibt vor Launch empfohlen.

## Visuelle Einordnung

| Bereich | Einordnung | Begruendung |
| --- | --- | --- |
| Grundlayout, Farben und Typografie | unveraendert | vorhandenes Erscheinungsbild und Tokens beibehalten |
| Navigation | technisch notwendig | Plugin-Ausgabe durch editierbaren Core Navigation Block ersetzt |
| Header-/Footer-Logo | technisch notwendig | hart codiertes Picture durch austauschbares Site Logo ersetzt |
| FAQ | bewusst verbessert | native Details statt grosser HTML-Bloecke bei erhaltenen Deep Links |
| Bildergalerien | bewusst verbessert | native Medienbloecke und funktionierendes mobiles Fallback |
| B.O.N.D.-Karten | bewusst verbessert | kompaktere native Core-Block-Struktur |
| Ungewollte Regression | keine festgestellt | finale Desktop-/Mobile-Baselines und Funktionspruefungen bestanden |

## Verbleibende manuelle Pruefpunkte

1. Auf einer Testkopie je einer Hauptseite die komplette Editor-Klickfolge inklusive Verschieben, Duplizieren, Loeschen, Speichern und Revision-Wiederherstellung ausfuehren.
2. Logo, Navigation und Footer einmal im Site Editor aendern, speichern, rueckgaengig machen und mehrere Frontends pruefen.
3. Tastatur- und Screenreader-Spotcheck mit realem Browser/Assistive Technology ausfuehren.
4. Impressum und Datenschutz vor Launch rechtlich freigeben.
5. Experimentelle Seiten `landing-2` und `kitesplash` entweder separat migrieren oder vor einem Launch aus dem oeffentlichen Scope nehmen.
