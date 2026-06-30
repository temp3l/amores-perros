#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

if [[ -f .env ]]; then
  # shellcheck disable=SC1091
  source .env
fi

: "${WORDPRESS_DB_NAME:=wordpress}"
: "${WORDPRESS_DB_USER:=wordpress}"
: "${WORDPRESS_DB_PASSWORD:=change-me}"

timestamp="$(date +%Y%m%d-%H%M%S)"
output_file="${ROOT_DIR}/backups/${WORDPRESS_DB_NAME}-${timestamp}.sql"

docker compose exec -T database sh -lc \
  'exec mariadb-dump --single-transaction --quick --lock-tables=false -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" "$WORDPRESS_DB_NAME"' \
  > "${output_file}"

echo "Datenbank exportiert nach ${output_file}."
