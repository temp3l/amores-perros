SHELL := /bin/bash

.PHONY: setup start stop restart logs status install wp db-export db-import reset clean screenshots visual-check visual-update visual-summary visual-summary-ci audit-images

setup:
	@if [[ ! -f .env ]]; then cp .env.example .env; fi
	@docker compose up -d
	@./scripts/wordpress-install.sh

start:
	@docker compose up -d

stop:
	@docker compose stop

restart:
	@docker compose restart

logs:
	@docker compose logs -f --tail=200

status:
	@docker compose ps

install:
	@./scripts/wordpress-install.sh

wp:
	@docker compose run --rm wp-cli $(ARGS)

db-export:
	@./scripts/wordpress-export-db.sh

db-import:
	@if [[ -z "$(FILE)" ]]; then echo "FILE=<pfad-zur-sql> ist erforderlich." >&2; exit 1; fi
	@./scripts/wordpress-import-db.sh "$(FILE)"

reset:
	@./scripts/wordpress-reset.sh

clean:
	@docker compose down --remove-orphans

screenshots: visual-check

visual-check:
	@./scripts/visual-check.sh check

visual-update:
	@./scripts/visual-check.sh update

visual-summary:
	@node scripts/visual-report-summary.mjs

visual-summary-ci:
	@node scripts/visual-report-summary.mjs --ci

audit-images:
	@./scripts/image-format-audit.sh
