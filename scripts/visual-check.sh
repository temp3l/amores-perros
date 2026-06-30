#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"

if [[ -f .env ]]; then
  # shellcheck disable=SC1091
  source .env
fi

: "${WORDPRESS_URL:=http://localhost:8080}"

usage() {
  cat <<'EOF'
Usage:
  ./scripts/visual-check.sh check
  ./scripts/visual-check.sh update

Commands:
  check   Fuehrt den visuellen Vergleich gegen vorhandene Baselines aus.
  update  Aktualisiert die Baselines absichtlich.
EOF
}

command_name="${1:-check}"

if [[ "${command_name}" != "check" && "${command_name}" != "update" ]]; then
  usage >&2
  exit 1
fi

if [[ ! -d node_modules/@playwright/test ]]; then
  echo "Playwright-Abhaengigkeiten fehlen. Bitte zuerst \`npm install\` ausfuehren." >&2
  exit 1
fi

if ! command -v curl >/dev/null 2>&1; then
  echo "curl ist erforderlich, um die lokale WordPress-URL zu pruefen." >&2
  exit 1
fi

docker_services=""
if docker_services="$(docker compose ps --services --status running 2>/dev/null)"; then
  if ! grep -qx 'wordpress' <<<"${docker_services}"; then
    echo "Der WordPress-Container laeuft nicht. Bitte zuerst \`docker compose up -d\` ausfuehren." >&2
    exit 1
  fi
fi

if ! curl --silent --show-error --fail --location "${WORDPRESS_URL}" >/dev/null; then
  echo "WordPress ist unter ${WORDPRESS_URL} nicht erreichbar. Bitte lokales Setup und Ports pruefen." >&2
  exit 1
fi

mkdir -p artifacts/visual/current

status=0
if [[ "${command_name}" == "update" ]]; then
  npx playwright test --update-snapshots || status=$?
else
  npx playwright test || status=$?
fi

node scripts/visual-report-summary.mjs

exit "${status}"
