# Dokumentation Uebersicht

Diese Dokumentation ist die Arbeitsgrundlage fuer den Rebuild von `Beziehungssache Hund`.

Die hierarchische Uebersicht findest du in [docs/structure.md](structure.md).

## Kanonische Fakten

- Marke: `Beziehungssache Hund`
- Person: `Jacqueline Rebien` / `Jacky Rebien`
- Sprache: Deutsch
- Ansprache: Du
- Standort: Hamburg
- Email: `info@beziehungssache-hund.de`
- Website: `beziehungssache-hund.de`

## Inhaltliche Quellen

- [Business-Fakten](business/business-facts.yaml)
- [Kontakt](business/contact-details.yaml)
- [Leistungen](business/services.yaml)
- [Preise](business/pricing.yaml)
- [Oeffnungszeiten](business/opening-hours.yaml)
- [Positionierung](brand/positioning.md)

## SEO und Struktur

- [URL-Map](seo/url-map.md)
- [Weiterleitungsplan](seo/redirect-map.md)
- [Metadaten](seo/metadata.md)
- [Sitemap](technical/sitemap.md)

## Theme und Stil

Die visuelle und technische Leitlinie fuer das WordPress-Theme ist in [wordpress-theme.md](wordpress-theme.md) beschrieben. Die wichtigsten Vorgaben sind:

- eigenes, leichtgewichtiges WordPress Block Theme
- Gutenberg und Full Site Editing statt Page Builder
- zentrale Designsteuerung ueber `theme.json`
- wiederverwendbare Block Patterns fuer Hero, Angebote, Prozess, Preise, CTA und Trust-Bereiche
- keine harten Theme-Abhaengigkeiten fuer Business-Daten

### Stilrichtung

- ruhig, persoenlich, klar und hochwertig
- visuell an `amores-perros.de` angelehnt mit dunklen Flaechen, warmem Terrakotta und viel Weissraum
- keine dominanten Pfotenmuster, Comic-Hunde oder aggressive Animationen
- keine Slider, Autoplay-Videos oder ueberladene Kartenlayouts

### Vorlaeufige Gestaltung

- Farben: Schwarz/Anthrazit, Terrakotta, Cremeweiss, warmes Beige und gedecktes Grau
- Typografie: Lora fuer Ueberschriften, Inter fuer Fliesstext und Navigation
- Fonts sollen lokal eingebunden werden
- Header und Footer greifen die dunkle, reduzierte Legacy-Anmutung auf
- Cremeweiss und Beige fuer Flaechen und abgesetzte Bereiche
- Terrakotta fuer primaere Buttons und Akzente
- Legacy-Bilder und Logos aus `amores-perros/` werden als lokale Theme-Assets genutzt

## Rebuild und Umsetzung

- [Rebuild-Entscheidungen](technical/rebuild-decisions.md)
- [Rebuild-Reihenfolge](technical/rebuild-sequence.md)
- [WordPress-Seitenbaum](technical/wordpress-page-tree.md)
- [Weiterleitungen final](technical/redirects-final.md)
- [Launch-Checkliste](technical/launch-checklist.md)

## Content-Drafts

- [Startseite](content/startseite-draft.md)
- [Erstgespraech](content/erstgespraech-draft.md)
- [Einzeltraining](content/einzeltraining-draft.md)
- [Ueber mich](content/ueber-mich-draft.md)
- [Preise](content/preise-draft.md)
- [Kontakt](content/kontakt-draft.md)
- [DOGSpace](content/dogspace-draft.md)
- [Workshops und Seminare](content/workshops-seminare-draft.md)
- [Coaching mit Hund](content/coaching-mit-hund-draft.md)

## Sprachregel fuer diese Dokumentation

- Interne Arbeitsdokumente sind deutsch.
- Alte Exportnamen bleiben nur in Audit- und Migrationsdokumenten sichtbar.
- Neue Website-Texte verwenden ausschliesslich den neuen Markennamen.

## Hinweis zum Archiv

Das historische Material ist in [docs/archive/README.md](archive/README.md) gebündelt.
