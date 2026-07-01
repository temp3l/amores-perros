# Codex-Prompt: FAQ um den Ablauf des Einzeltrainings erweitern

## Zielpfad

Empfohlener Ablageort dieses Prompts:

```text
docs/prompts/wire-faq-einzeltraining-extension.md
```

## Verbindliche Inhaltsquelle

```text
docs/content/faq-einzeltraining-extension.de.md
```

---

Erweitere die bestehende FAQ-Seite der WordPress-Website um den neuen Themenbereich **„So läuft Einzeltraining in Hamburg ab“**.

Arbeite autonom. Analysiere zuerst das Repository und die bestehende FAQ-Implementierung. Stelle keine Rückfragen, wenn Struktur, Konventionen oder gewünschtes Verhalten aus `AGENTS.md`, dem vorhandenen Theme oder den bestehenden FAQ-Dateien hervorgehen.

## 1. Vorbedingungen und Repository-Regeln

1. Lies zuerst alle für die bearbeiteten Pfade geltenden `AGENTS.md`-Dateien.
2. Prüfe den aktuellen Git-Status.
3. Verändere keine fachfremden oder bereits uncommitteten Dateien.
4. Analysiere:
   - die bestehende FAQ-Seite,
   - die zentrale FAQ-Datenquelle,
   - Templates und Partials,
   - Accordion-JavaScript,
   - Hash-/Scroll-Navigation,
   - Styles,
   - Tests,
   - vorhandene Kontakt-CTA-Komponenten.
5. Verwende die bestehende Architektur. Erzeuge keine zweite parallele FAQ-Implementierung.
6. Füge keine externe Bibliothek hinzu.

## 2. Inhaltsquelle integrieren

Verwende verbindlich:

```text
docs/content/faq-einzeltraining-extension.de.md
```

Integriere daraus den vollständigen FAQ-Bereich in die bestehende zentrale Inhalts- oder Datenstruktur.

Falls die bestehende FAQ-Quelle lautet:

```text
docs/content/faq-page-content.de.md
```

führe die Inhalte nachvollziehbar dort zusammen. Die neue Extension-Datei darf als redaktionelle Ursprungsdatei erhalten bleiben, sofern dies zu den Repository-Konventionen passt.

Keine fachlichen Kürzungen ohne zwingenden technischen Grund. Keine Erfolgs-, Heil- oder Zeitgarantien ergänzen.

## 3. Neuer FAQ-Bereich

Öffentliche Überschrift:

```text
So läuft Einzeltraining in Hamburg ab
```

Stabile technische ID:

```text
ablauf-einzeltraining
```

Deep Link:

```text
/faq/#ablauf-einzeltraining
```

Die ID ist Teil der öffentlichen URL und darf nicht dynamisch aus der Überschrift erzeugt werden.

Unterthemen:

1. Situation beobachten
2. Verhalten und Zusammenhänge einordnen
3. Ein realistisches Ziel definieren
4. Konkrete Schritte für den Alltag entwickeln
5. Fortschritte und Rückschritte gemeinsam auswerten

Die Fragen und Antworten innerhalb dieser Unterthemen stammen aus der Inhaltsquelle.

## 4. Bestehende Themen-Navigation erweitern

Ergänze den neuen Bereich in der vorhandenen FAQ-Sprungnavigation.

Sichtbarer Linktext:

```text
Ablauf des Einzeltrainings
```

Linkziel:

```text
#ablauf-einzeltraining
```

Anforderungen:

- normaler semantischer `<a>`-Link,
- ohne JavaScript als Anker nutzbar,
- responsive,
- tastaturbedienbar,
- vorhandene Hover-, Active- und Focus-Stile wiederverwenden,
- bestehende Reihenfolge sinnvoll ergänzen.

Empfohlene Position: vor den problembezogenen FAQ-Bereichen oder direkt nach der FAQ-Einleitung. Entscheide anhand der bestehenden Seitenstruktur.

## 5. Hash-Whitelist erweitern

Die vorhandene explizite Whitelist beziehungsweise Map muss um den neuen Wert ergänzt werden:

```js
['ablauf-einzeltraining', 'ablauf-einzeltraining']
```

Falls IDs serverseitig validiert oder zentral typisiert werden, ergänze den Wert auch dort.

Verwende den Hash niemals ungeprüft als CSS-Selektor.

## 6. Deep-Link-Verhalten

Für `/faq/#ablauf-einzeltraining` muss das bestehende Verhalten vollständig gelten:

1. Bereich anhand der Whitelist auflösen.
2. Zum Bereich scrollen.
3. Sticky-Header-Offset berücksichtigen.
4. Das erste zugehörige FAQ-Element öffnen.
5. Slide-open-Animation verwenden.
6. Fokus sinnvoll auf Überschrift oder erstes `<summary>` setzen.
7. Initialen Seitenaufruf mit Hash unterstützen.
8. Klicks innerhalb der Seite unterstützen.
9. `hashchange`, Browser-Zurück und Browser-Vorwärts unterstützen.
10. `prefers-reduced-motion` respektieren.
11. Ohne JavaScript als normaler Anker funktionieren.

Ändere vorhandene, funktionierende Mechanismen nur, wenn dies für den neuen Abschnitt notwendig ist.

## 7. Informationsarchitektur

Bevorzuge folgende Struktur, angepasst an das bestehende Markup:

```html
<section
  id="ablauf-einzeltraining"
  class="faq-topic"
  aria-labelledby="faq-topic-ablauf-einzeltraining"
>
  <h2 id="faq-topic-ablauf-einzeltraining" tabindex="-1">
    So läuft Einzeltraining in Hamburg ab
  </h2>

  <p>...</p>

  <div class="faq-list">
    <details class="faq-item">
      <summary>Warum wird die Situation zuerst beobachtet?</summary>
      <div class="faq-answer">...</div>
    </details>
  </div>
</section>
```

Nutze die bereits bestehende FAQ-Komponente und ihre semantische Struktur. Dupliziere kein Markup für diesen einen Bereich.

## 8. Optionaler Ablauf-Überblick

Wenn das vorhandene Design eine Prozessdarstellung unterstützt, ergänze am Anfang des neuen Bereichs einen kompakten, barrierearmen Ablauf-Überblick:

1. Situation beobachten
2. Zusammenhänge einordnen
3. Ziel definieren
4. Alltagsschritte entwickeln
5. Entwicklung auswerten

Anforderungen:

- als geordnete Liste oder bestehende Step-Komponente,
- keine rein dekorative Timeline, die mobil oder mit Screenreader unverständlich wird,
- kein zusätzliches JavaScript,
- keine Verdopplung aller FAQ-Antworten.

Falls keine passende bestehende Komponente existiert, verwende eine einfache `<ol>` und erweitere die Architektur nicht unnötig.

## 9. Einzeltraining-Seite verlinken

Suche nach der bestehenden Seite beziehungsweise Section mit dem Text:

```text
So sieht Einzeltraining in Hamburg aus
```

Ergänze dort eine kontextuelle Verlinkung zur neuen FAQ-Section.

Empfohlener Linktext:

```text
Mehr zum Ablauf des Einzeltrainings
```

Link:

```text
/faq/#ablauf-einzeltraining
```

Nutze die bestehende WordPress-URL-Auflösung, zum Beispiel `home_url()` oder eine vorhandene interne Link-Hilfsfunktion. Keine hart codierte Domain.

Der Link muss nach Navigation zur FAQ-Seite:

- den Zielbereich erreichen,
- ihn automatisch öffnen,
- zum Abschnitt scrollen.

## 10. Bestehenden Einführungstext prüfen

Prüfe diesen vorhandenen Text:

```text
So sieht Einzeltraining in Hamburg aus

Im Einzeltraining beobachten wir zuerst die Situation, ordnen Verhalten und Ausloeser ein und entwickeln daraus uebbare Schritte fuer euren Alltag. Du bekommst keine abstrakten Ratschlaege, sondern eine Begleitung, die zu eurem Tempo, euren Moeglichkeiten und eurem Ziel passt. Wenn der Einstieg ueber ein Erstgespraech sinnvoller ist, kannst du auch dort beginnen.
```

Falls dies sichtbarer Website-Content ist, korrigiere ihn in reguläres Deutsch und gleiche ihn redaktionell an:

```text
So sieht Einzeltraining in Hamburg aus

Im Einzeltraining beobachten wir zuerst die Situation, ordnen Verhalten und Auslöser ein und entwickeln daraus konkrete, umsetzbare Schritte für euren Alltag. Du bekommst keine abstrakten Ratschläge, sondern eine Begleitung, die zu eurem Tempo, euren Möglichkeiten und eurem Ziel passt. Wenn der Einstieg über ein Erstgespräch sinnvoller ist, kannst du auch dort beginnen.
```

Erhalte Tonalität und Bedeutung. Vermeide doppelte Einführungstexte, falls bereits eine redaktionell bessere Version vorhanden ist.

## 11. CTA

Nutze am Ende des neuen FAQ-Bereichs die bestehende qualifizierte Kontaktanfrage.

Bevorzugte Beschriftung:

```text
Einzeltraining anfragen
```

Kein direkter Kalenderlink, sofern die Website weiterhin qualifizierte Anfragen statt unmittelbarer Buchung verwendet.

Bei Aggressions- oder bekannten Beißthemen muss die bestehende Vorabklärung erhalten bleiben.

## 12. SEO und strukturierte Daten

1. Behalte genau eine `<h1>` auf der FAQ-Seite.
2. Verwende den neuen Bereich als `<h2>`.
3. Verwende Fragen entsprechend der bestehenden FAQ-Semantik.
4. Der gesamte Inhalt muss im initialen HTML verfügbar sein.
5. Aktualisiere vorhandenes FAQ-Schema nur über den bereits etablierten Mechanismus.
6. Erzeuge keinen zweiten `FAQPage`-JSON-LD-Block.
7. Nimm nur öffentlich sichtbare Fragen und Antworten in strukturierte Daten auf.
8. Prüfe, ob Yoast, Rank Math oder das Theme bereits Schema erzeugt.

## 13. WordPress-Sicherheit und Wartbarkeit

- Daten zentral pflegen.
- Kein kopiertes Einzel-Template für den neuen Bereich.
- Dynamische Ausgaben kontextgerecht escapen:
  - `esc_html()`
  - `esc_attr()`
  - `esc_url()`
  - `wp_kses_post()`
- Keine Inline-Scripts.
- Keine Inline-Styles.
- Bestehende Enqueue- und Asset-Versionierungsstrategie verwenden.
- FAQ-Assets weiterhin nur laden, wo sie benötigt werden.

## 14. Tests

Erweitere den vorhandenen Test-Stack mindestens um folgende Fälle:

1. `ablauf-einzeltraining` existiert genau einmal.
2. Die Navigation enthält `#ablauf-einzeltraining`.
3. Die Whitelist akzeptiert den neuen Hash.
4. Direkter Aufruf `/faq/#ablauf-einzeltraining` öffnet den Bereich.
5. Das erste FAQ-Element wird geöffnet.
6. Scrollen und Fokus werden ausgelöst.
7. Sticky-Header-Offset bleibt korrekt.
8. `hashchange` funktioniert.
9. Browser-Zurück und Browser-Vorwärts funktionieren.
10. Unbekannte Hashes bleiben weiterhin sicher.
11. Reduced Motion deaktiviert Animationen.
12. Ohne JavaScript funktioniert der Anker.
13. Der Link von der Einzeltraining-Seite zeigt auf den korrekten Deep Link.
14. Der neue Bereich erscheint im bestehenden FAQ-Schema genau einmal, falls Schema aktiv ist.
15. FAQ-spezifische Assets werden weiterhin nicht global geladen.
16. Umlaute werden im sichtbaren Text korrekt dargestellt.

Falls kein automatisierter Browser-Teststack vorhanden ist, ergänze keine unverhältnismäßige Infrastruktur. Dokumentiere stattdessen einen reproduzierbaren manuellen Testplan.

## 15. Qualitätsprüfung

Führe alle relevanten vorhandenen Prüfungen aus:

- PHP-Syntaxprüfung,
- WordPress Coding Standards,
- JavaScript-Linting,
- CSS-/SCSS-Linting,
- Formatter,
- Unit-/DOM-Tests,
- Build,
- vorhandene Integrationstests.

Prüfe manuell oder automatisiert:

- Desktop,
- Mobile,
- Tastatur,
- Fokuszustände,
- Deep Link von derselben Seite,
- Deep Link von der Einzeltraining-Seite,
- Reload mit Hash,
- Browser-History,
- Reduced Motion,
- JavaScript deaktiviert,
- lange FAQ-Antworten,
- keine Fehler in der Browser-Konsole.

## 16. Dokumentation

Dokumentiere kurz:

- welche Dateien geändert wurden,
- wo der neue FAQ-Inhalt gepflegt wird,
- wie die stabile ID registriert ist,
- wie der Link von der Einzeltraining-Seite funktioniert,
- welche Tests ausgeführt wurden,
- welche manuellen Prüfpunkte verbleiben.

## 17. Abschlussbericht

Beende mit:

1. Zusammenfassung
2. Geänderte Dateien
3. Integration in die bestehende FAQ-Architektur
4. Deep-Link- und Accordion-Verhalten
5. Accessibility und SEO
6. Tests mit Ergebnis
7. Verbleibende Risiken

Committe nichts, sofern dies nicht ausdrücklich verlangt wurde.
