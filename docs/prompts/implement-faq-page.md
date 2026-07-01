# Codex-Prompt: WordPress-FAQ-Seite implementieren

## Empfohlener Ablageort

```text
docs/prompts/implement-faq-page.md
```

Diesen Prompt kannst du aus dem Repository heraus an Codex übergeben.

---

Implementiere eine produktionsreife FAQ-Seite für die bestehende WordPress-Website.

Arbeite vollständig autonom und führe Analyse, Implementierung, Tests und Dokumentation in einem Durchlauf aus. Stelle keine Rückfragen, sofern die Antwort aus dem Repository, `AGENTS.md`, bestehenden Theme-Konventionen oder dem vorhandenen Seitendesign abgeleitet werden kann.

## Verbindliche Inhaltsquelle

Verwende als redaktionelle Quelle:

```text
docs/content/faq-page-content.de.md
```

Die Inhalte dürfen typografisch und strukturell an das Theme angepasst, aber nicht fachlich verkürzt, verfälscht oder mit Erfolgsversprechen ergänzt werden.

## 1. Repository analysieren

1. Lies zuerst alle relevanten `AGENTS.md`-Dateien und befolge sie strikt.
2. Untersuche:
   - WordPress- und Theme-Struktur,
   - bestehende Seitentemplates,
   - wiederverwendbare Komponenten,
   - CSS-/SCSS-Architektur,
   - JavaScript-Buildsystem,
   - bestehende Accordion-Komponenten,
   - Design-Tokens,
   - vorhandene Kontakt- und CTA-Komponenten.
3. Verwende die bestehende Architektur.
4. Führe keinen Page Builder und kein zusätzliches UI-Framework ein.
5. Verwende keine externe Accordion- oder Scroll-Bibliothek.

## 2. FAQ-Seite

Erstelle eine öffentliche WordPress-Seite beziehungsweise ein passendes Template:

- Seitentitel: `Häufige Fragen`
- bevorzugter Slug: `/faq/`

Bereiche:

1. Hero
2. Themen-Sprungnavigation
3. gruppiertes FAQ-Accordion
4. Kontakt-CTA

Themen:

- Leinenführigkeit
- Alleinbleiben
- Grenzen setzen
- Angespannte Spaziergänge
- Hunde mit aggressivem Verhalten

## 3. Stabile Deep-Link-IDs

Verwende exakt:

```text
leinenfuehrigkeit
alleinbleiben
grenzen-setzen
angespannte-spaziergaenge
aggressives-verhalten
```

Beispiele:

```text
/faq/#leinenfuehrigkeit
/faq/#alleinbleiben
/faq/#grenzen-setzen
/faq/#angespannte-spaziergaenge
/faq/#aggressives-verhalten
```

Diese IDs sind öffentliche URLs und dürfen nicht dynamisch aus Überschriften generiert werden.

## 4. Sprungnavigation

Erstelle unterhalb des Hero-Bereichs eine responsive Navigation mit semantischen Ankerlinks:

```html
<a href="#alleinbleiben">Alleinbleiben</a>
```

Anforderungen:

- ohne JavaScript funktionsfähig,
- große Touch-Flächen,
- sichtbare Fokuszustände,
- responsive,
- klare aktive Darstellung des Zielbereichs.

## 5. Accordion

Bevorzuge semantische `<details>`- und `<summary>`-Elemente.

Beispiel:

```html
<section
  id="alleinbleiben"
  class="faq-topic"
  aria-labelledby="faq-topic-alleinbleiben"
>
  <h2 id="faq-topic-alleinbleiben" tabindex="-1">Alleinbleiben</h2>

  <div class="faq-list">
    <details class="faq-item">
      <summary>
        <span class="faq-question">
          Wie lernt mein Hund, entspannt allein zu bleiben?
        </span>
        <span class="faq-icon" aria-hidden="true"></span>
      </summary>

      <div class="faq-answer">
        ...
      </div>
    </details>
  </div>
</section>
```

Anforderungen:

- korrekte Überschriftenhierarchie,
- Tastaturbedienung,
- Screenreader-Kompatibilität,
- sichtbare Fokuszustände,
- keine klickbaren `<div>`-Elemente,
- mindestens 44 × 44 Pixel große interaktive Flächen.

## 6. Hash-Navigation und Scroll-to-Verhalten

Implementiere eine wiederverwendbare Funktion für FAQ-Deep-Links.

Bei `/faq/#alleinbleiben` oder `#alleinbleiben`:

1. Hash über eine feste Whitelist validieren.
2. Zielbereich ermitteln.
3. Erstes FAQ-Element dieses Bereichs öffnen.
4. Zielbereich weich ins Sichtfeld scrollen.
5. Sticky Header berücksichtigen.
6. Fokus auf die Themenüberschrift oder das erste `<summary>` setzen.
7. Browser-Zurück und Browser-Vorwärts unterstützen.
8. Initiale Hashes beim Seitenaufruf unterstützen.

Events:

- `DOMContentLoaded`
- Klicks auf interne FAQ-Hashlinks
- `hashchange`

Vermeide doppelte Event-Registrierungen.

Sichere Zielauflösung:

```js
const FAQ_TARGETS = new Map([
  ['leinenfuehrigkeit', 'leinenfuehrigkeit'],
  ['alleinbleiben', 'alleinbleiben'],
  ['grenzen-setzen', 'grenzen-setzen'],
  ['angespannte-spaziergaenge', 'angespannte-spaziergaenge'],
  ['aggressives-verhalten', 'aggressives-verhalten'],
]);
```

Übergib niemals beliebige URL-Hashes ungeprüft an `querySelector()`.

## 7. Slide-open-Animation

Beim automatischen und manuellen Öffnen soll die Antwort dezent aufgleiten.

Anforderungen:

- dynamische Höhe mit `scrollHeight`,
- keine harte `max-height`,
- Öffnen und Schließen animieren,
- Dauer ungefähr 220–320 ms,
- optional zusätzliche Opacity-Animation,
- schnelle Mehrfachklicks robust behandeln,
- nach dem Öffnen `height: auto`,
- Inhalte bei Resize nicht abschneiden,
- native `open`-Semantik erhalten.

Reduced Motion:

```css
@media (prefers-reduced-motion: reduce) {
  /* keine Scroll- oder Accordion-Animation */
}
```

Bei Reduced Motion:

- `scroll-behavior: auto`,
- sofort öffnen und schließen,
- keine Height- oder Opacity-Animation.

## 8. Scroll-Offset

Nutze bevorzugt:

```css
.faq-topic {
  scroll-margin-top: var(--faq-scroll-offset);
}
```

Leite den Wert aus vorhandenen Header- oder Theme-Variablen ab. Falls die Header-Höhe dynamisch ist, schreibe sie robust in eine CSS Custom Property.

## 9. Accordion-Verhalten

- Mehrere Fragen dürfen gleichzeitig geöffnet bleiben.
- Bei einem Themenlink wird mindestens das erste FAQ des Zielbereichs geöffnet.
- Andere bereits geöffnete FAQ-Elemente bleiben offen.
- Wiederholtes Anklicken scrollt erneut zuverlässig zum Bereich.
- URL-Hash ohne Reload aktualisieren.
- Browser-History korrekt unterstützen.

## 10. Design

Nutze vorhandene Design-Tokens.

Ziele:

- moderne, ruhige Cards,
- dezente Schatten,
- abgerundete Ecken,
- gute Lesbarkeit,
- klare Hover- und Fokuszustände,
- animiertes Chevron oder Plus/Minus,
- ausreichender Kontrast,
- mobile Optimierung.

Keine Inline-Styles oder Inline-Scripts, sofern die Architektur dies nicht verlangt.

## 11. Inhalte und Sicherheit

Übernimm die Inhalte aus:

```text
docs/content/faq-page-content.de.md
```

Für den Bereich `aggressives-verhalten`:

- sichtbarer Hinweis `Training nur nach vorheriger Absprache`,
- bekannte Schnapp- oder Beißvorfälle abfragen,
- Sicherheitsmanagement erwähnen,
- mögliche tierärztliche oder verhaltensmedizinische Abklärung erwähnen,
- keine Erfolgs- oder Heilversprechen.

Rendere die Inhalte aus einer zentral wartbaren Struktur. Vermeide dupliziertes Template-Markup.

Escape WordPress-Ausgaben kontextgerecht:

```php
esc_html()
esc_attr()
esc_url()
wp_kses_post()
```

## 12. SEO

Implementiere:

- genau eine `<h1>`,
- logische `<h2>`-/`<h3>`-Struktur,
- crawlbare Inhalte im initialen HTML,
- sinnvollen Seitentitel,
- passende Meta Description über das vorhandene SEO-System.

Prüfe vorhandene Plugins wie Yoast SEO oder Rank Math.

Erzeuge FAQPage-JSON-LD nur dann selbst, wenn kein bestehendes System bereits FAQ-Schema ausgibt. Verhindere doppelte strukturierte Daten.

## 13. Verlinkungen im bestehenden Content

Suche im Repository nach:

- Leinenführigkeit
- Alleinbleiben
- Grenzen setzen
- angespannte Spaziergänge
- aggressive Hunde
- aggressives Verhalten

Verlinke bereits vorhandene passende CTA- oder Themenlinks auf:

```text
/faq/#leinenfuehrigkeit
/faq/#alleinbleiben
/faq/#grenzen-setzen
/faq/#angespannte-spaziergaenge
/faq/#aggressives-verhalten
```

Schreibe bestehende redaktionelle Inhalte nicht unnötig um.

## 14. JavaScript-Qualität

Die Implementierung muss:

- in einem eigenen Modul liegen,
- defensiv mit fehlenden Elementen umgehen,
- keine globalen Variablen erzeugen,
- nur bei vorhandener FAQ-Komponente initialisieren,
- eine feste Hash-Whitelist nutzen,
- keine unnötigen DOM-Scans ausführen,
- keine ungedrosselten Resize-Handler verwenden,
- bestehende Lint- und Formatierungsregeln erfüllen.

## 15. WordPress-Integration

Registriere Assets korrekt:

```php
wp_enqueue_style()
wp_enqueue_script()
```

Lade FAQ-spezifische Assets nur auf der FAQ-Seite.

Verwende vorhandenes Asset-Versioning oder `filemtime()`, falls dies im Theme bereits üblich ist.

Keine hart codierten `<script>`-Tags im Template.

## 16. Progressive Enhancement

Ohne JavaScript müssen weiterhin funktionieren:

- Ankerlinks,
- native `<details>`-Elemente,
- vollständige Inhalte,
- Tastaturbedienung.

JavaScript verbessert nur:

- automatisches Öffnen,
- Animation,
- Scroll-Offset,
- Fokus,
- Hash-Navigation.

## 17. Tests

Nutze den vorhandenen Test-Stack.

Teste mindestens:

1. Jede der fünf IDs existiert genau einmal.
2. Klick auf `#alleinbleiben` setzt den Hash.
3. Der Zielbereich wird geöffnet.
4. Das erste FAQ des Bereichs wird geöffnet.
5. Initialer Aufruf mit `/faq/#grenzen-setzen`.
6. Initialer Aufruf mit `/faq/#aggressives-verhalten`.
7. Unbekannte Hashes verursachen keinen Fehler.
8. `hashchange` unterstützt Browser-Zurück/-Vorwärts.
9. Tastaturbedienung funktioniert.
10. Mehrere FAQ-Elemente dürfen offen bleiben.
11. Reduced Motion deaktiviert Animationen.
12. Ohne JavaScript bleiben Inhalte zugänglich.
13. Lange Inhalte werden nicht abgeschnitten.
14. Sticky Header verdeckt die Überschrift nicht.
15. FAQ-Assets werden nicht global geladen.
16. Kein doppeltes FAQ-Schema.

Falls kein Browser-Testsystem vorhanden ist, ergänze keine unverhältnismäßige neue Infrastruktur. Dokumentiere stattdessen einen präzisen manuellen Testplan.

## 18. Qualitätsprüfung

Führe alle relevanten vorhandenen Prüfungen aus:

- PHP-Syntaxprüfung,
- WordPress Coding Standards,
- JavaScript-Linting,
- CSS-/SCSS-Linting,
- Formatter,
- Tests,
- Build.

Prüfe zusätzlich:

- Desktop,
- Mobile,
- Tastatur,
- Fokuszustände,
- direkte Deep Links,
- Browser-History,
- Reduced Motion,
- Layout ohne JavaScript,
- lange Inhalte,
- Textvergrößerung,
- Browser-Konsole.

## 19. Dokumentation

Dokumentiere:

- geänderte Dateien,
- Pflege neuer Fragen,
- Ergänzen weiterer stabiler IDs,
- Hash-Navigation,
- Animation und Reduced Motion,
- ausgeführte Tests.

## 20. Abschlussbericht

Beende mit:

1. Zusammenfassung
2. Geänderte Dateien
3. Technische Entscheidungen
4. Accessibility- und SEO-Maßnahmen
5. Tests und Ergebnisse
6. Verbleibende Risiken

Ändere keine fachfremden Dateien und committe nichts, sofern dies nicht ausdrücklich verlangt wurde.
