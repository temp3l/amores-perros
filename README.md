# Beziehungssache Hund: Lokale WordPress-Entwicklung

Dieses Repository richtet eine rein lokale WordPress-Entwicklungsumgebung fuer den Rebuild von `beziehungssache-hund.de` ein. Die Infrastruktur dient der Entwicklung eines eigenen, leichtgewichtigen Block-Themes und der spaeteren redaktionellen Umsetzung. Deployment, finale Inhalte und produktive Zugangsdaten sind nicht Teil dieses Setups.

## Voraussetzungen

- Docker Engine
- Docker Compose V2
- GNU Make fuer die Komfortbefehle oder alternativ direkte `docker compose`-Aufrufe
- Linux, macOS oder Windows mit WSL2; unter Windows sollte Docker Desktop mit WSL2-Backend aktiv sein

## Ersteinrichtung

1. `.env.example` nach `.env` kopieren und sichere lokale Werte eintragen.
2. Container starten.
3. WordPress installieren und lokalisieren.

```bash
cp .env.example .env
docker compose up -d
./scripts/wordpress-install.sh
```

Alternativ:

```bash
make setup
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
```

Direkt ohne Make:

```bash
docker compose up -d
docker compose run --rm wp-cli core version
docker compose run --rm wp-cli theme list
```

## Projektstruktur

- `compose.yaml`: lokale Services fuer WordPress, MariaDB, WP-CLI, Adminer und Mailpit
- `docker/wordpress/*.ini`: lokale PHP-Konfiguration
- `scripts/`: wiederholbare Installations-, Reset- und Datenbankskripte
- `wordpress/wp-content/themes/beziehungssache-hund/`: minimales Block-Theme-Startgeruest
- `wordpress/wp-content/plugins/` und `wordpress/wp-content/mu-plugins/`: versionierbare Projekt-Erweiterungen
- `backups/`: lokale SQL-Exporte, standardmaessig nicht versioniert

Uploads liegen lokal in einem Docker-Volume und werden nicht als Quellcode versioniert.

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

## Sicherheits- und Scope-Hinweise

- Das Setup ist ausschliesslich fuer lokale Entwicklung gedacht.
- Keine produktiven Passwoerter oder Secrets in `.env.example`, Git oder Dokumentation eintragen.
- Es gibt kein automatisches Deployment.
- Datenbankinhalte und Uploads gehoeren nicht in ein spaeteres Theme-ZIP.
- Theme-Code und redaktionelle WordPress-Inhalte bleiben getrennt.
