# Beziehungssache Hund: Lokale WordPress-Entwicklung

Dieses Repository richtet eine rein lokale WordPress-Entwicklungsumgebung fuer den Rebuild von `beziehungssache-hund.de` ein. Die Infrastruktur dient der Entwicklung eines eigenen, leichtgewichtigen Block-Themes und der spaeteren redaktionellen Umsetzung. Deployment, finale Inhalte und produktive Zugangsdaten sind nicht Teil dieses Setups.

## Voraussetzungen

- Docker Engine
- Docker Compose V2
- GNU Make fuer die Komfortbefehle oder alternativ direkte `docker compose`-Aufrufe
- Node.js 22+ und npm fuer lokale Visual-Checks mit Playwright
- Linux, macOS oder Windows mit WSL2; unter Windows sollte Docker Desktop mit WSL2-Backend aktiv sein

## Ersteinrichtung

1. `.env.example` nach `.env` kopieren und sichere lokale Werte eintragen.
2. Container starten.
3. WordPress installieren und lokalisieren.
4. Playwright fuer lokale Screenshot-Checks installieren.

```bash
cp .env.example .env
docker compose up -d
./scripts/wordpress-install.sh
npm install
```

Alternativ:

```bash
make setup
npm install
```

Eine bereits vorhandene lokale `.env` wird von `make setup` nicht ueberschrieben.

## Lokale URLs

- WordPress: `http://localhost:8080`
- Admin: `http://localhost:8080/wp-admin/`
- Adminer: `http://localhost:8081`
- Mailpit: `http://localhost:8025`

Adminer und Mailpit sind ausschliesslich lokale Entwicklungswerkzeuge.

## Haeufige Befehle

```bash
make start
make stop
make restart
make logs
make status
make install
make wp ARGS="plugin list"
make db-export
make db-import FILE=backups/example.sql
make reset
make clean
make audit-images
```

Direkt ohne Make:

```bash
docker compose up -d
docker compose run --rm wp-cli core version
docker compose run --rm wp-cli theme list
```

## Visuelle Layout-Checks

Fuer lokale Desktop- und Mobile-Screenshots ist eine Playwright-basierte Visual-Check-Strecke hinterlegt. Sie prueft die geschäftskritischen Seiten gegen versionierte Baselines und schreibt Laufzeit-Artefakte getrennt von Theme-Code weg.

### Abgedeckte Seiten

- `/`
- `/hundetraining-hamburg/`
- `/erstgespraech/`
- `/einzeltraining/`
- `/dogspace-hamburg/`
- `/workshops-seminare/`
- `/coaching-mit-hund/`
- `/ueber-jacky-rebien/`
- `/kontakt/`
- `/preise/`
- `/impressum/`
- `/datenschutz/`

### Viewports

- Desktop: `1440x900`
- Mobile: `390x844`

### Einmalige Einrichtung

```bash
npm install
npx playwright install chromium
```

`chromium` reicht fuer diesen lokalen Workflow aus.

### Ausfuehren

```bash
make visual-check
```

Alias:

```bash
make screenshots
```

Der Befehl:

- prueft, ob der lokale WordPress-Container laeuft
- prueft, ob `WORDPRESS_URL` aus `.env` erreichbar ist
- fuehrt anschliessend den visuellen Vergleich aus
- gibt danach eine kurze Summary mit HTML-Report-Pfad und eventuellen Fehlseiten aus

### Baselines absichtlich aktualisieren

```bash
make visual-update
```

Das sollte nur nach einer bewusst akzeptierten Layout-Aenderung verwendet werden.

### Nur Summary ausgeben

```bash
make visual-summary
```

Das ist nuetzlich, wenn du nach einem fehlgeschlagenen Lauf nur noch die Report-Datei und die betroffenen Seiten sehen willst.

### Kompakte CI-Summary

```bash
make visual-summary-ci
```

Die Ausgabe ist absichtlich kurz und maschinenfreundlich, zum Beispiel mit `VISUAL_FAILURE_COUNT=` und einer Zeile pro fehlgeschlagener Seite.

### Bildformat-Audit

```bash
make audit-images
```

Prueft im Headless-Browser, ob die optimierten Bildquellen fuer Header, Footer, Portrait und Hero auf AVIF mit WebP-Fallback aufloesen.

### Artefakte und Baselines

- Baselines: `tests/visual/baselines/`
- Laufzeit-Artefakte, Diffs, Traces: `artifacts/visual/test-results/`
- HTML-Report: `artifacts/visual/report/`

Die Baselines sind Teil des Repos. Laufzeit-Artefakte bleiben lokal.

## Projektstruktur

- `compose.yaml`: lokale Services fuer WordPress, MariaDB, WP-CLI, Adminer und Mailpit
- `docker/wordpress/*.ini`: lokale PHP-Konfiguration
- `scripts/`: wiederholbare Installations-, Reset- und Datenbankskripte inklusive Seitensynchronisation
- `wordpress/wp-content/themes/beziehungssache-hund/`: eigenes Block-Theme fuer Templates, Patterns und Styles
- `wordpress/wp-content/plugins/` und `wordpress/wp-content/mu-plugins/`: versionierbare Projekt-Erweiterungen
- `backups/`: lokale SQL-Exporte, standardmaessig nicht versioniert

Uploads liegen lokal in einem Docker-Volume und werden nicht als Quellcode versioniert.

## Aktueller WordPress-Stand

- Das Setup aktiviert automatisch das Theme `beziehungssache-hund`.
- `./scripts/wordpress-install.sh` erstellt bzw. aktualisiert die kanonischen Seiten aus `docs/technical/wordpress-page-tree.md` und `docs/seo/url-map.md`.
- `./scripts/wordpress-install.sh` installiert und aktiviert zusaetzlich `Yoast SEO` und synchronisiert die kanonischen Seitentitel und Descriptions fuer die angelegten Seiten.
- Die Startseite wird als statische Frontpage gesetzt, `Ratgeber` als Beitragsseite.
- `Impressum` und `Datenschutz` werden lokal als Platzhalterseiten angelegt und muessen vor einem Launch mit rechtlich geprueften Inhalten ersetzt werden.

## Fehlersuche

- Belegter Port:
  Passe `WORDPRESS_PORT`, `ADMINER_PORT` oder `MAILPIT_HTTP_PORT` in `.env` an und starte neu.
- Datenbank noch nicht gesund:
  `docker compose ps` und `docker compose logs database` pruefen; `./scripts/wordpress-install.sh` wartet auf den Healthcheck.
- Falsche Dateirechte:
  `docker compose run --rm wp-cli core version` pruefen; der WP-CLI-Service laeuft als `www-data` (`33:33`).
- WordPress-Installationsstatus:
  `docker compose run --rm wp-cli core is-installed`
- Sprache pruefen:
  `docker compose run --rm wp-cli option get WPLANG`
  `docker compose run --rm wp-cli language core list`
- Docker-Volumes zuruecksetzen:
  `make reset` oder `FORCE=1 ./scripts/wordpress-reset.sh`
- Apache-Rewrite oder Permalinks:
  `docker compose run --rm wp-cli option get permalink_structure`
  `docker compose run --rm wp-cli rewrite flush --hard`
- WP-CLI-Verbindung zur Datenbank:
  `docker compose run --rm wp-cli db check`
- Visual-Check meldet fehlende Abhaengigkeiten:
  `npm install` und `npx playwright install chromium`
- Visual-Check meldet unerreichbare Seite:
  `docker compose up -d`, dann `curl http://localhost:8080` oder die konfigurierte `WORDPRESS_URL` pruefen

## Sicherheits- und Scope-Hinweise

- Das Setup ist ausschliesslich fuer lokale Entwicklung gedacht.
- Keine produktiven Passwoerter oder Secrets in `.env.example`, Git oder Dokumentation eintragen.
- Es gibt kein automatisches Deployment.
- Datenbankinhalte und Uploads gehoeren nicht in ein spaeteres Theme-ZIP.
- Theme-Code und redaktionelle WordPress-Inhalte bleiben getrennt.
