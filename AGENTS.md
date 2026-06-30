# AGENTS.md

## Zweck des Repos

Dieses Repository ist die Arbeitsbasis fuer den Rebuild von `beziehungssache-hund.de`.

Ziel ist eine lokal entwickelbare WordPress-Website fuer `Beziehungssache Hund`, die spaeter auf Standard-WordPress-Hosting deploybar ist.

Die lokale Entwicklungsumgebung soll mit `docker-compose` betrieben werden:

- ein WordPress-Container
- ein Datenbank-Container
- projektbezogener Code und Inhalte im Repository

Docker ist nur fuer die lokale Entwicklung gedacht. Die Produktivumgebung darf nicht von Docker, Node, Composer, WP-CLI oder Shell-Zugriff abhaengen.

## Kanonische Quellen

Bevor Code, Content-Struktur oder technische Entscheidungen angepasst werden, muessen die vorhandenen Dokumente geprueft werden.

Prioritaet der Quellen:

1. `docs/README.md`
2. `docs/structure.md`
3. `docs/technical/rebuild-decisions.md`
4. `docs/technical/rebuild-sequence.md`
5. `docs/technical/wordpress-page-tree.md`
6. `docs/wordpress-theme.md`
7. Fachliche Stammdaten unter `docs/business/`
8. SEO-Vorgaben unter `docs/seo/` und `docs/technical/redirects-final.md`
9. Content-Drafts unter `docs/content/`
10. Historische Analyse- und Audit-Dokumente nur als Referenz

Bei Widerspruechen gilt:

- die spezifischere Datei geht vor der allgemeineren Datei
- die neuere Umsetzungsentscheidung geht vor aelteren Audit-Notizen
- Business-Fakten, Preise, Kontakt und Oeffnungszeiten kommen nie aus Theme-Code oder geratenen Annahmen

## Fachlicher Rahmen

Die Website verwendet:

- Sprache: Deutsch
- Ansprache: Du
- Marke: `Beziehungssache Hund`
- Person: `Jacqueline Rebien` / `Jacky Rebien`
- Ort: Hamburg

Die Kernangebote sind:

1. Startseite
2. Erstgespraech
3. Einzeltraining
4. Ueber mich
5. Kontakt
6. Preise

Ergaenzende Seiten:

1. DOGSpace
2. Workshops und Seminare
3. Coaching mit Hund
4. Impressum
5. Datenschutz

Die Reihenfolge fuer den Aufbau folgt `docs/technical/rebuild-sequence.md`.

## Technische Zielarchitektur

Der bevorzugte Zielzustand ist:

- leichtgewichtiges eigenes WordPress Block Theme
- Gutenberg statt schwerem Page Builder
- page-basierte Informationsarchitektur
- CPTs nur, wenn spaeter wirklich noetig
- ein gepflegtes Formularsystem mit SMTP
- saubere SEO-Basis mit gepflegtem SEO-Plugin

Nicht einfuehren ohne ausdrueckliche Doku-Grundlage:

- Elementor
- Divi
- WPBakery
- komplexe Builder-Abhaengigkeiten
- unnoetige Plugin-Last

## Lokale Entwicklungsregeln

Wenn die lokale WordPress-Umgebung eingerichtet oder erweitert wird, gelten diese Regeln:

- WordPress und Datenbank werden ueber `docker-compose` gestartet.
- Laufzeitdaten von Datenbank und Uploads muessen klar von Quellcode getrennt sein.
- Eigenes Theme, eigene Plugins und MU-Plugins liegen im Repository und sind versionierbar.
- Zugangsdaten, Salts, Dumps und Backups duerfen nicht in Git landen.
- Lokale Konfiguration wird ueber `.env` oder gleichwertige lokale Dateien gesteuert.
- Die lokale Umgebung muss auf einer frischen Maschine mit Docker Compose nachvollziehbar startbar sein.

Bevorzugte Struktur fuer neue Implementierung:

- `compose.yaml` fuer WordPress + DB
- `src/wp-content/themes/<projekt-theme>/`
- optional `src/wp-content/plugins/`
- optional `src/wp-content/mu-plugins/`
- `config/` fuer lokale PHP- oder WordPress-Konfiguration
- `scripts/` fuer wiederholbare lokale Helfer

## Umgang mit Legacy-Material

Das Verzeichnis `amores-perros/` ist ein Legacy-Snapshot der alten Website und nur Referenzmaterial.

Erlaubt:

- Dateien lesen
- HTML, Assets, Texte und Alt-Strukturen analysieren
- alte URLs fuer Redirects oder Content-Migration nachvollziehen

Nicht erlaubt:

- Dateien darin aendern
- Dateien verschieben oder loeschen
- das Legacy-Verzeichnis als neue WordPress-Basis verwenden
- alte Formulare, PHP-Mailer oder Theme-Strukturen ungeprueft uebernehmen

Legacy-Code ist nie die Source of Truth. Source of Truth sind die aktuellen Dokumente unter `docs/`.

## Content- und SEO-Regeln

Beim Aufbau der WordPress-Site gilt:

- jede Seite braucht klare Ziel-URL und klaren Suchintent
- Slugs, Metadaten und Redirects muessen mit `docs/seo/` abgestimmt sein
- Impressum und Datenschutz sind Pflichtseiten vor einem Launch
- Business-Daten muessen ueber alle Seiten konsistent sein
- Preise nur aus `docs/business/pricing.yaml`
- Kontaktangaben nur aus `docs/business/contact-details.yaml`
- Oeffnungszeiten nur aus `docs/business/opening-hours.yaml`
- Inhalte muessen die Positionierung aus `docs/brand/positioning.md` einhalten

## Entscheidungs- und Dokumentationspflicht

Wenn ein Agent eine relevante neue technische Entscheidung trifft, muss er:

1. die betroffenen Dokumente pruefen
2. die Entscheidung an bestehende Vorgaben anpassen
3. bei Abweichungen die Begruendung knapp dokumentieren

Keine generischen Boilerplate-Aenderungen an der Doku. Dokumentation soll den tatsaechlichen Repo-Zustand beschreiben.

## Arbeitsstil fuer Agenten

Agenten sollen:

- zuerst die relevanten Doku-Dateien lesen
- dann den kleinsten tragfaehigen naechsten Schritt umsetzen
- bestehende Entscheidungen respektieren
- Struktur, Lesbarkeit und Wartbarkeit hoch halten
- lokale Developer-Workflows einfach und reproduzierbar halten

Agenten sollen nicht:

- fachliche Fakten erfinden
- ungeklaerte Leistungen als live verfuegbar darstellen
- Theme-Code mit Stammdaten hart verdrahten
- das Projekt mit schwerer Tooling-Komplexitaet ueberfrachten

## Definition of Done fuer Infrastrukturarbeit

Infrastruktur- oder Setup-Arbeit ist erst fertig, wenn:

- die lokale Umgebung dokumentiert ist
- WordPress und DB per `docker-compose` startbar sind
- Source-Code und Laufzeitdaten getrennt sind
- Secrets nicht im Repository liegen
- die Struktur den WordPress-Rebuild fuer dieses Projekt tatsaechlich unterstuetzt
