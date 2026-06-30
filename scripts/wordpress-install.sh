#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

if [[ -f .env ]]; then
  # shellcheck disable=SC1091
  source .env
fi

: "${WORDPRESS_URL:=http://localhost:8080}"
: "${WORDPRESS_TITLE:=Beziehungssache Hund - Lokal}"
: "${WORDPRESS_TAGLINE:=Lokale Entwicklungsumgebung fuer Theme- und Inhaltsaufbau.}"
: "${WORDPRESS_ADMIN_USER:=local_admin}"
: "${WORDPRESS_ADMIN_PASSWORD:=change-me}"
: "${WORDPRESS_ADMIN_EMAIL:=admin@example.test}"

compose() {
  docker compose "$@"
}

wp() {
  compose run --rm wp-cli "$@"
}

service_health() {
  local service="$1"
  local container_id

  container_id="$(compose ps -q "${service}")"
  if [[ -z "${container_id}" ]]; then
    echo "missing"
    return 0
  fi

  docker inspect -f '{{if .State.Health}}{{.State.Health.Status}}{{else}}{{.State.Status}}{{end}}' "${container_id}"
}

wait_for_health() {
  local service="$1"
  local timeout="${2:-180}"
  local elapsed=0
  local status

  while (( elapsed < timeout )); do
    status="$(service_health "${service}")"
    if [[ "${status}" == "healthy" ]]; then
      return 0
    fi

    if [[ "${status}" == "missing" ]]; then
      printf 'Service "%s" laeuft noch nicht. Bitte zuerst `docker compose up -d` ausfuehren.\n' "${service}" >&2
      return 1
    fi

    sleep 2
    elapsed=$((elapsed + 2))
  done

  printf 'Service "%s" wurde nicht rechtzeitig healthy.\n' "${service}" >&2
  return 1
}

wait_for_wordpress_files() {
  local timeout="${1:-120}"
  local elapsed=0

  while (( elapsed < timeout )); do
    if wp core version >/dev/null 2>&1; then
      return 0
    fi

    sleep 2
    elapsed=$((elapsed + 2))
  done

  echo "WordPress-Core-Dateien sind ueber WP-CLI noch nicht verfuegbar." >&2
  return 1
}

activate_theme_if_available() {
  if wp theme is-installed beziehungssache-hund >/dev/null 2>&1; then
    wp theme activate beziehungssache-hund >/dev/null
  fi
}

echo "Pruefe Docker-Services ..."
wait_for_health database 180
wait_for_health wordpress 180
wait_for_wordpress_files 120

echo "Pruefe Installationsstatus ..."
if ! wp core is-installed >/dev/null 2>&1; then
  echo "Installiere WordPress ..."
  wp core install \
    --url="${WORDPRESS_URL}" \
    --title="${WORDPRESS_TITLE}" \
    --admin_user="${WORDPRESS_ADMIN_USER}" \
    --admin_password="${WORDPRESS_ADMIN_PASSWORD}" \
    --admin_email="${WORDPRESS_ADMIN_EMAIL}" \
    --locale="de_DE"
else
  echo "WordPress ist bereits installiert."
fi

echo "Aktiviere deutsche Spracheinstellungen ..."
wp language core install de_DE --activate >/dev/null
wp site switch-language de_DE >/dev/null
wp option update WPLANG de_DE >/dev/null

echo "Setze lokale Optionen ..."
wp option update timezone_string Europe/Berlin >/dev/null
wp option update date_format 'j. F Y' >/dev/null
wp option update time_format 'H:i' >/dev/null
wp option update blogname "${WORDPRESS_TITLE}" >/dev/null
wp option update blogdescription "${WORDPRESS_TAGLINE}" >/dev/null
wp rewrite structure '/%postname%/' --hard >/dev/null
wp rewrite flush --hard >/dev/null

activate_theme_if_available

echo "Synchronisiere Seitenstruktur und Basisinhalte ..."
wp eval-file wp-content/themes/beziehungssache-hund/seed-content.php >/dev/null

installed_locale="$(wp option get WPLANG)"
if [[ "${installed_locale}" != "de_DE" ]]; then
  printf 'Sprache konnte nicht korrekt gesetzt werden. Erwartet: de_DE, erhalten: %s\n' "${installed_locale}" >&2
  exit 1
fi

echo "WordPress lokal installiert und auf de_DE verifiziert."
