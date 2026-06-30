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

wp eval-file wp-content/themes/beziehungssache-hund/seed-content.php
