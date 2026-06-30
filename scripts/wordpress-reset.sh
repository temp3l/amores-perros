#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

if [[ "${FORCE:-0}" != "1" ]]; then
  read -r -p "Lokale WordPress-, Upload- und DB-Daten werden geloescht. Fortfahren? [y/N] " confirmation
  if [[ "${confirmation}" != "y" && "${confirmation}" != "Y" ]]; then
    echo "Abgebrochen."
    exit 1
  fi
fi

docker compose down --volumes --remove-orphans

echo "Lokale Docker-Volumes wurden entfernt."
