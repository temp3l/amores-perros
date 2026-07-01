# Dokumentation Übersicht

Diese Dokumentation ist die Arbeitsgrundlage für den Rebuild von `Beziehungssache Hund`.

Die hierarchische Übersicht findest du in [docs/structure.md](structure.md).

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
- [Öffnungszeiten](business/opening-hours.yaml)
- [Positionierung](brand/positioning.md)

## SEO und Struktur

- [URL-Map](seo/url-map.md)
- [Weiterleitungsplan](seo/redirect-map.md)
- [Metadaten](seo/metadata.md)
- [Sitemap](technical/sitemap.md)

## Theme und Stil

Die visuelle und technische Leitlinie für das WordPress-Theme ist in [wordpress-theme.md](wordpress-theme.md) beschrieben. Die wichtigsten Vorgaben sind:

- eigenes, leichtgewichtiges WordPress Block Theme
- Gutenberg und Full Site Editing statt Page Builder
- zentrale Designsteuerung über `theme.json`
- wiederverwendbare Block Patterns für Hero, Angebote, Prozess, Preise, CTA und Trust-Bereiche
- keine harten Theme-Abhängigkeiten für Business-Daten

### Stilrichtung

- ruhig, persönlich, klar und hochwertig
- visuell an `amores-perros.de` angelehnt mit dunklen Flächen, warmem Terrakotta und viel Weißraum
- keine dominanten Pfotenmuster, Comic-Hunde oder aggressive Animationen
- keine dominanten Slider, Autoplay-Videos oder überladene Kartenlayouts
- sparsam eingesetzte, manuell bedienbare Bild-Slider sind als Ausnahme erlaubt

### Vorläufige Gestaltung

- Farben: Schwarz/Anthrazit, Terrakotta, Cremeweiss, warmes Beige und gedecktes Grau
- Typografie: Lora für Überschriften, Inter für Fließtext und Navigation
- Fonts sollen lokal eingebunden werden
- Header und Footer greifen die dunkle, reduzierte Legacy-Anmutung auf
- Cremeweiß und Beige für Flächen und abgesetzte Bereiche
- Terrakotta für primäre Buttons und Akzente
- Legacy-Bilder und Logos aus `amores-perros/` werden als lokale Theme-Assets genutzt

## Rebuild und Umsetzung

- [Rebuild-Entscheidungen](technical/rebuild-decisions.md)
- [Rebuild-Reihenfolge](technical/rebuild-sequence.md)
- [WordPress-Seitenbaum](technical/wordpress-page-tree.md)
- [Weiterleitungen final](technical/redirects-final.md)
- [Launch-Checkliste](technical/launch-checklist.md)

## Content-Drafts

- [Startseite](content/startseite-draft.md)
- [Erstgespräch](content/erstgespraech-draft.md)
- [Einzeltraining](content/einzeltraining-draft.md)
- [Über mich](content/ueber-mich-draft.md)
- [Preise](content/preise-draft.md)
- [Kontakt](content/kontakt-draft.md)
- [DOGSpace](content/dogspace-draft.md)
- [Workshops und Seminare](content/workshops-seminare-draft.md)
- [Coaching mit Hund](content/coaching-mit-hund-draft.md)

## Hero-Content

- [Hero-Übersicht](heros/README.md)
- [Bild-Prompts](heros/image-prompts.md)

## Sprachregel für diese Dokumentation

- Interne Arbeitsdokumente sind deutsch.
- Alte Exportnamen bleiben nur in Audit- und Migrationsdokumenten sichtbar.
- Neue Website-Texte verwenden ausschließlich den neuen Markennamen.

## Hinweis zum Archiv

Das historische Material ist in [docs/archive/README.md](archive/README.md) gebündelt.
