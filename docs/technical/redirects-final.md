# Redirects Final

## Grundsatz

Alle alten Export-URLs werden auf eindeutige, neue Zielseiten geleitet. Es gibt keine parallelen Zielseiten fuer dieselbe Suchintention.

## Weiterleitungstabelle

| Alt | Neu | Hinweis |
| --- | --- | --- |
| `/index.html` | `/` | Hauptseite |
| `/home-1.html` | `/` | Duplikat der Startseite |
| `/contact-us.html` | `/kontakt/` | Alte Kontaktseite |
| `/about.html` | `/ueber-jacky-rebien/` | Alte About-Seite wird zur Ueber-mich-Seite |
| `/informationen.html` | `/impressum/` | Alte Fragmentseite wird zur Rechtsseite |
| `/https/amores-perrosde/abouthtml/über.html` | `/ueber-jacky-rebien/` | Export-Artefakt |

## SEO-Regeln für Weiterleitungen

- Jede alte URL bekommt genau ein Ziel.
- Keine Redirect-Ketten.
- Keine 302 fuer dauerhaft verschobene Inhalte.
- Legacy-Links auf `http://www.amores-perros.de/About.html` werden entfernt.
