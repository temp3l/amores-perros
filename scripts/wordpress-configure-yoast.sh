#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

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

wait_for_wordpress() {
  local timeout="${1:-120}"
  local elapsed=0

  while (( elapsed < timeout )); do
    if wp core is-installed >/dev/null 2>&1; then
      return 0
    fi

    sleep 2
    elapsed=$((elapsed + 2))
  done

  echo "WordPress ist noch nicht installiert." >&2
  return 1
}

echo "Pruefe Docker-Services ..."
wait_for_health database 180
wait_for_health wordpress 180
wait_for_wordpress 120

echo "Installiere bzw. aktiviere Yoast SEO ..."
if wp plugin is-installed wordpress-seo >/dev/null 2>&1; then
  wp plugin activate wordpress-seo >/dev/null
else
  wp plugin install wordpress-seo --activate >/dev/null
fi

echo "Synchronisiere Yoast-Einstellungen ..."
wp eval "if (function_exists('bsh_sync_yoast_seo')) { bsh_sync_yoast_seo(); } else { fwrite(STDERR, 'Yoast-Sync-Funktion nicht gefunden.' . PHP_EOL); exit(1); }" >/dev/null

if wp help yoast >/dev/null 2>&1; then
  echo "Baue Yoast-Indexables neu auf ..."
  wp yoast index --reindex >/dev/null
fi

echo "Yoast SEO ist installiert und konfiguriert."
