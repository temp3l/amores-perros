# Gutenberg Migration Report

Stand: 14. Juli 2026

## Sicherheitsbasis

- Arbeitsbranch: `refactor/gutenberg-editor-first`.
- Datenbankexport vor schreibenden Aenderungen: `backups/pre-gutenberg-refactor.sql`.
- Aktiver Theme-Slug vor Migration: `beziehungssache-hund`.
- Keine WordPress-Core-, `vendor/`-, `node_modules/`- oder Legacy-Dateien wurden veraendert.
- Keine bestehenden Inhalte, Medien oder Datenbank-Overrides wurden geloescht.
- Max Mega Menu wurde lokal deaktiviert, aber nicht deinstalliert.

Das SQL-Backup liegt absichtlich im Git-ignorierten lokalen Backup-Verzeichnis und darf nicht committed werden.

## Migrationswerkzeug

Die MU-Plugin-Bootstrap-Datei `wordpress/wp-content/mu-plugins/bsh-site-editor-migration.php` laedt den WP-CLI-Befehl aus `wordpress/wp-content/mu-plugins/site-editor-migration/site-editor-migration.php`.

```bash
docker compose run --rm wp-cli site-editor-migration audit
docker compose run --rm wp-cli site-editor-migration migrate --dry-run
docker compose run --rm wp-cli site-editor-migration migrate
docker compose run --rm wp-cli site-editor-migration verify
```

Eigenschaften:

- Der Audit schreibt nicht in die Datenbank.
- Der Dry-Run schreibt nicht in die Datenbank.
- Legacy-Hashes verhindern die Migration unerwartet veraenderter Ausgangsinhalte.
- `_bsh_editor_first_version` kennzeichnet den Migrationsstand.
- `_bsh_editor_first_backup_v1` und der zugehoerige Hash sichern den vorherigen Inhalt.
- WordPress-Revisionen bleiben erhalten; nach Abschluss existieren lokal 226 Revisionen.
- Pattern-Referenzen werden genau einmal in unabhaengige Core-Bloecke expandiert.
- Bereits migrierte Seiten, Header und Global Styles werden uebersprungen.
- Fehler fuehren zu einem nicht erfolgreichen WP-CLI-Abschluss.
- Medien werden nicht dupliziert; das Site Logo wurde einmalig als Attachment ID 448 importiert und markiert.

## Migrierte Seiten

Die bestehenden IDs, Slugs, Status und URLs blieben erhalten.

| ID | Slug | Ergebnis | Bloecke | HTML/Pattern danach |
| ---: | --- | --- | ---: | --- |
| 5 | `startseite` | migriert | 228 | 0 / 0 |
| 6 | `hundetraining-hamburg` | migriert | 61 | 0 / 0 |
| 7 | `erstgespraech` | migriert | 113 | 0 / 0 |
| 8 | `einzeltraining` | migriert | 93 | 0 / 0 |
| 9 | `dogspace-hamburg` | migriert | 29 | 0 / 0 |
| 10 | `workshops-seminare` | migriert | 31 | 0 / 0 |
| 11 | `coaching-mit-hund` | migriert | 28 | 0 / 0 |
| 12 | `ueber-jacky-rebien` | migriert | 26 | 0 / 0 |
| 13 | `preise` | migriert | 52 | 0 / 0 |
| 14 | `kontakt` | migriert | 33 | 0 / 0; ein Forminator-Shortcode |
| 95 | `faq` | migriert | 264 | 0 / 0 |
| 15 | `ratgeber` | migriert | 24 | 0 / 0 |
| 16 | `impressum` | migriert | 21 | 0 / 0 |
| 17 | `datenschutz` | migriert | 26 | 0 / 0 |

## Inhaltliche Umwandlungen

- `core/pattern`-Referenzen wurden in normale, seiteneigene Bloecke aufgeloest.
- Grosse redaktionelle `core/html`-Bloecke wurden in Core Group, Columns, Heading, Paragraph, List, Image, Gallery, Details und Buttons ueberfuehrt.
- FAQ-Fragen und Antworten sind Core Details; Deep-Link-Anker und interne Links blieben erhalten.
- Manuelle Picture-Ausgaben sind Core Image.
- Der Bildslider ist eine Core Gallery mit progressiver Frontend-Erweiterung.
- Preiskarten, Angebotsbeschreibungen, CTAs und Kontaktumfeld sind normale Seitenbloecke.
- Forminator bleibt fuer die Formularfunktion verantwortlich; der vorhandene Shortcode wurde nicht ersetzt oder dupliziert.

## Datenbank-Overrides

| Objekt | ID | Behandlung |
| --- | ---: | --- |
| Header `wp_template_part` | 411 | vorhandenen Inhalt gesichert und in place auf Site Logo/Core Navigation migriert |
| Global Styles | 32 | vorherige JSON-Daten gesichert; konflikterzeugende Benutzereinstellungen auf leer normalisiert |
| Hauptnavigation `wp_navigation` | 413 | unveraendert beibehalten; kein automatisches Loeschen |
| `wp_template` | - | keine Datenbankeintraege vorhanden |
| `wp_block` | - | keine Synced Patterns vorhanden |

## Zweite Reparaturstufe

Der erste Browser-Audit erkannte eine Core-Image-Validierungsabweichung, weil erzeugtes gespeichertes Markup `loading`, `decoding` und Dimensionsattribute enthielt, die der Core Image Block nicht in dieser Form serialisierte. Migration Version 2 entfernte nur diese nicht kanonischen gespeicherten Attribute. Danach wurden alle 14 Seiten ohne Invalid-Block-Warnung geoeffnet.

Migration Version 3 korrigiert die Integritaetspruefsumme vorhandener Originalbackups. Das Backup selbst wurde in Version 2 nicht ueberschrieben; Version 3 berechnet den Hash konsequent aus dem einmalig gesicherten Inhalt und laesst `verify` jede Abweichung melden.

Migration Version 4 importiert lokale Theme-Bilder idempotent in die Medienbibliothek und setzt die Attachment-IDs in den vorhandenen Core Image Bloecken. Der aktuelle editorisch verwaltete Inhalt wird dabei in place transformiert und zusaetzlich unter `_bsh_editor_first_backup_v4` gesichert. Auf der Startseite wurden neun Bildbloecke, insgesamt 50 Bildvorkommen mit 17 eindeutigen Quelldateien, auf Medien-Attachments umgestellt.

Migration Version 5 normalisiert vier nicht unterstuetzte `aria-hidden`-Attribute in B.O.N.D.-Paragraphen. Migration Version 6 entfernt `metadata.patternName` aus 16 expandierten Patterninstanzen. Davon lagen sieben auf der Startseite. Die Abschnitte sind danach unabhaengiger Seiteninhalt und werden nicht mehr als verbundene `Vorlage` behandelt.

Die gespeicherten Praeferenzen von `local_admin` kombinierten obere Werkzeugleiste und ablenkungsfreien Modus, wodurch `Ersetzen` ausserhalb des sichtbaren Bereichs lag. Die Migration sichert diese Praeferenzen und deaktiviert nur den ablenkungsfreien Modus; die obere Werkzeugleiste bleibt erhalten.

## Idempotenznachweis

Ein erneuter `migrate --dry-run` meldet fuer alle 14 Seiten `bereits migriert`, fuer Header `bereits migriert` und fuer Global Styles `bereits normalisiert`. Es werden keine Seiten oder Medien doppelt angelegt.

## Rollback

1. Vor jeder Ruecksetzung zuerst einen Export des aktuellen Stands erstellen.
2. Fuer einzelne Seiten bevorzugt die von WordPress erzeugte Revision wiederherstellen.
3. Der vorherige Inhalt liegt zusaetzlich im `_bsh_editor_first_backup_v1`-Post-Meta.
4. Fuer eine vollstaendige lokale Ruecksetzung den Export `backups/pre-gutenberg-refactor.sql` ueber den dokumentierten DB-Import-Workflow einspielen.

Ein Rollback darf nicht auf Produktion und nicht ohne vorherigen aktuellen Export ausgefuehrt werden.

## Nicht migrierter Scope

Die veroeffentlichten experimentellen Seiten `landing-2` (ID 269) und `kitesplash` (ID 418) sowie der Entwurf `kopie-landing-page` (ID 281) gehoeren nicht zum kanonischen Seitenbaum. Sie wurden bewusst nicht veraendert. Frische Installationen legen `landing-2` und `kitesplash` nicht mehr automatisch als Seiten an. Vor einer fachlichen Freigabe muessen ihre Patterns separat editor-first refaktoriert werden.
