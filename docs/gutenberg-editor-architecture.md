# Gutenberg Editor Architecture

Stand: 14. Juli 2026

## Leitprinzip

```text
Templates = globale Seitenstruktur
Patterns = wiederverwendbare Ausgangslayouts
Post Content = individuelle Seiteninhalte
theme.json = Designsystem
Custom Blocks = echte Spezialfunktionalitaet
Plugins = portable Geschaeftslogik
```

Seitenspezifische Texte, Bilder, Preise, Karten, Links und CTAs gehoeren in den `post_content`. Ein erneuter Setup-Lauf darf diesen Inhalt nicht ueberschreiben.

## Theme-Struktur

- `templates/`: schlanke Block-Templates mit Header, Main/Post Content und Footer.
- `parts/`: globale Header- und Footer-Struktur fuer den Site Editor.
- `patterns/`: nicht synchronisierte Ausgangslayouts. Beim Seeding werden Referenzen in unabhaengige Bloecke aufgeloest.
- `theme.json`: globale Design-Tokens, Layoutbreiten und Block-Styles.
- `style.css`: strukturelle und markenspezifische Frontend-Regeln.
- `assets/css/editor.css`: nur editorbedingte Inhaltsanpassungen, keine Gutenberg-Admin-UI-Regeln.
- `assets/css/faq.css`: gemeinsame FAQ-Inhaltsdarstellung fuer Editor und Frontend.
- `assets/js/image-slider.js`: progressive Frontend-Erweiterung einer nativen Core Gallery.
- `inc/faq.php`: Erzeugung nativer FAQ-Bloecke und serverseitige Schema-Ausgabe aus dem gespeicherten Inhalt.
- `inc/hero-images.php`: Erzeugung von Core Image/Gallery-Markup fuer frische Seeds.
- `seed-content.php`: Initialinhalt fuer leere Seiten, keine dauerhafte redaktionelle Quelle.

## Templates und Template-Parts

Normale Seiten-Templates enthalten keine redaktionellen Seitentexte. Sie rahmen `core/post-content` mit globalem Header und Footer ein.

Header und Footer sind globale Template-Parts:

- Logo: `core/site-logo`, austauschbar ueber Medienbibliothek/Site Editor.
- Navigation: `core/navigation` mit Core Navigation Link und Submenu.
- Footer-Inhalte: Core Paragraph, Navigation und Site Logo.
- Der technische Skip-Link bleibt als kleines HTML-Fragment im Header; er ist kein redaktioneller Inhalt.

Ein gespeicherter Header-Override bleibt in der Datenbank, damit Site-Editor-Aenderungen regulaer funktionieren. Migrationen duerfen solche Overrides nie blind loeschen.

## Seiteninhalt und Patterns

Patterns dienen als Einfuegehilfe oder Seed-Vorlage. Nach dem Einfuegen sind sie nicht synchronisiert und vollstaendig Teil der jeweiligen Seite. Verwendet werden Core-Bloecke wie:

- Group, Columns und Column fuer Layout.
- Heading, Paragraph, List und Details fuer Textstruktur.
- Image und Gallery fuer Medien und Alt-Texte.
- Buttons und Button fuer CTAs und Links.
- Separator und Spacer nur dort, wo semantisches Layout nicht ausreicht.

Synced Patterns werden erst eingefuehrt, wenn ein Inhalt nachweislich zentral gepflegt werden muss. Fuer instanzspezifische Werte in einem solchen Pattern sind WordPress Pattern Overrides zu bevorzugen. Aktuell existiert kein fachlich notwendiges Synced Pattern.

## FAQ

Jede Frage ist ein Core Details Block in einem semantisch gruppierten Themenabschnitt. Frage, Antwort, Listen und Links sind native Inhalte. Stabile Themenanker bleiben erhalten.

FAQ-JSON-LD wird zur Laufzeit aus den Details-Bloecken der FAQ-Seite gelesen. Dadurch gibt es keine zweite, manuell zu synchronisierende Inhaltsquelle. Aenderungen im Editor wirken sowohl sichtbar als auch im Schema.

## Bilder und Slider

Bilder werden als Core Image gespeichert und referenzieren vorhandene Medien-IDs. Alt-Texte bleiben ueber den Medienblock editierbar. Der Slider ist eine Core Gallery mit der Klasse `bsh-image-slider`:

- Ohne JavaScript bleibt eine lesbare Bildergalerie sichtbar.
- Im Editor bleibt die Galerie ein normales, direkt bearbeitbares Grid.
- Nur im Frontend werden Navigation und Statuspunkte progressiv ergaenzt.
- Keine Bild- oder Textdaten liegen ausschliesslich in JavaScript.

Theme-Seedbilder werden bei der Migration einmalig als WordPress-Attachments importiert. `_bsh_editor_first_theme_asset` verknuepft die urspruengliche Theme-Datei mit dem Attachment und verhindert Duplikate. Bereits editorisch veraenderter `post_content` wird bei spaeteren Migrationsversionen nur in place transformiert und nicht erneut aus Seed-Dateien aufgebaut.

## Formulare und Geschaeftslogik

Das Kontaktformular bleibt bei Forminator, weil Formularvalidierung, Einreichungen und Mailversand portable Plugin-Logik sind. Die Seite enthaelt den dokumentierten Shortcode; Ueberschriften, Erklaertexte und Kontaktlinks bleiben Core-Bloecke.

Business-Fakten werden weiterhin aus den kanonischen Dateien unter `docs/business/` bezogen. Sie duerfen nicht als Konstanten in Theme-CSS oder Layout-Code dupliziert werden.

## Design Tokens

`theme.json` Version 3 ist die kanonische Designsystemquelle. Es definiert insbesondere:

- Farbpalette und Farbverwendung.
- Typografie und Schriftgroessen.
- Content- und Wide-Breite.
- Spacing-Presets.
- Radius- und Shadow-Presets.
- Blockbezogene Basisstyles.

CSS nutzt, soweit moeglich, die generierten `--wp--preset--*`-Variablen. Datenbank-Global-Styles duerfen bewusste redaktionelle Anpassungen enthalten, aber keine unerklaerte zweite Token-Palette.

## Asset Loading

- Frontend-Styles werden regulaer ueber das Theme geladen.
- `add_editor_style()` bindet `style.css`, `assets/css/faq.css` und `assets/css/editor.css` in den iframe-basierten Editor ein.
- Editor-CSS adressiert den Inhaltscanvas und nicht globale Admin-Elemente.
- Frontend-JavaScript wird nur geladen, wenn der aktuelle Inhalt eine Slider-Galerie enthaelt.
- Es gibt keine Custom Blocks und damit aktuell keine `block.json`-Assets. Ein spaeterer Custom Block muss API Version 3 verwenden und Styles ueber Block-Metadaten registrieren.

## Block-Locking

Normale Seiten bleiben ohne `templateLock`, `contentOnly` und Move-/Remove-Locks. Redaktionelle Nutzer koennen Text und Links aendern, Bilder austauschen, Abschnitte verschieben, duplizieren, entfernen und neue Bloecke einfuegen.

Der registrierte Core-Group-Stil `bsh-hidden` erlaubt ein reversibles Ausblenden einzelner Abschnitte. Im Frontend verwendet er `display: none`; im Editor bleibt die Group sichtbar, abgeblendet und markiert, damit sie weiterhin ausgewaehlt und wieder eingeblendet werden kann.

Eine neue Sperre ist nur zulaessig, wenn sie eine nachweisbare Layout- oder Compliance-Anforderung schuetzt und alle Inhaltsattribute weiterhin erreichbar bleiben. Die Begruendung gehoert in diese Dokumentation.

## Datenmigration

Die Migration liegt unter `wordpress/wp-content/mu-plugins/site-editor-migration/` und ist als WP-CLI-Befehl verfuegbar. Sie:

- besitzt Audit, Dry-Run, Migrate und Verify.
- prueft Legacy-Hashes und Migrationsversionen.
- sichert den vorherigen Seiteninhalt als Post Meta und WordPress-Revision.
- expandiert Pattern-Referenzen genau einmal.
- entfernt nach der Expansion `metadata.patternName`, damit eingefuegte Ausgangslayouts unabhaengige Seitenbloecke sind.
- importiert Theme-Bilder einmalig und ergaenzt die Medien-IDs der Core Image Bloecke.
- migriert Header- und Global-Styles-Overrides in place.
- importiert das Site Logo nur einmal.
- bricht bei unerwartetem, bereits redaktionell veraendertem Quellinhalt ab.

Details und Befehle stehen in `docs/gutenberg-migration-report.md`.

## Erweiterungsregeln

1. Zuerst pruefen, ob Core Blocks plus Pattern die Funktion abbilden.
2. Seitenspezifischen Inhalt nie in `templates/*.html` oder PHP hart codieren.
3. Patterns standardmaessig nicht synchronisieren.
4. Custom Blocks nur fuer strukturierte Spezialdaten, dynamische Daten oder echte Interaktion einsetzen.
5. Neue Custom Blocks mit `block.json`, API Version 3, typisierten Content-Attributen, nativen Eingabekomponenten und Editor-/Frontend-Styles bauen.
6. Aenderungen an statischem `save()`-Markup nur mit `deprecated`-Migration ausliefern.
7. Datenmigrationen idempotent, mit Dry-Run, Backup und Verify implementieren.
8. Site-Editor-Overrides vor Theme-Aenderungen immer inventarisieren.
9. Keine WordPress-Core-, `vendor/`- oder `node_modules/`-Dateien aendern.

## Testbefehle

```bash
docker compose run --rm wp-cli site-editor-migration audit
docker compose run --rm wp-cli site-editor-migration migrate --dry-run
docker compose run --rm wp-cli site-editor-migration verify
./scripts/visual-check.sh check
php -l wordpress/wp-content/themes/beziehungssache-hund/functions.php
node --check wordpress/wp-content/themes/beziehungssache-hund/assets/js/image-slider.js
```
