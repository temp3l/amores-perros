#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

if [[ $# -lt 1 ]]; then
  echo "Verwendung: $0 <datei.sql>" >&2
  exit 1
fi

input_file="$1"

if [[ ! -f "${input_file}" ]]; then
  printf 'SQL-Datei nicht gefunden: %s\n' "${input_file}" >&2
  exit 1
fi

if [[ -f .env ]]; then
  # shellcheck disable=SC1091
  source .env
fi

: "${WORDPRESS_DB_NAME:=wordpress}"
: "${WORDPRESS_DB_USER:=wordpress}"
: "${WORDPRESS_DB_PASSWORD:=change-me}"

docker compose exec -T database sh -lc \
  'exec mariadb -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" "$WORDPRESS_DB_NAME"' \
  < "${input_file}"

echo "Datenbank importiert aus ${input_file}."
