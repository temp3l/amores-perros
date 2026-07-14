# Gutenberg Editor Benutzeranleitung

Stand: 14. Juli 2026

## Normale Seiten bearbeiten

1. In WordPress `Seiten` oeffnen und die gewuenschte Seite waehlen.
2. Den visuellen Editor verwenden. Die Listenansicht oben links zeigt alle Abschnitte und Bloecke.
3. Text direkt anklicken und bearbeiten.
4. Vor dem Speichern die Vorschau fuer Desktop, Tablet und Mobil pruefen.
5. Mit `Speichern` veroeffentlichen. WordPress legt dabei eine Revision an.

Ueberschriften, Absaetze, Listen, Preise, Karten, FAQ-Inhalte und CTA-Texte sind normale Bloecke. Dafuer ist keine Codeaenderung erforderlich.

## Bilder und Alt-Texte

1. Einen Bildblock anklicken.
2. In der Block-Werkzeugleiste `Ersetzen` waehlen.
3. Ein vorhandenes Medium waehlen oder ein neues Bild hochladen.
4. Den Alternativtext in den Block-Einstellungen eintragen. Er beschreibt den Bildinhalt; rein dekorative Bilder erhalten einen leeren Alt-Text.
5. Bildausschnitt und Seitenverhaeltnis in Desktop- und Mobilvorschau pruefen.

Eine Slider-Galerie bleibt im Editor als normale Galerie sichtbar. Bilder koennen dort ausgetauscht und neu angeordnet werden. Die Slider-Steuerung wird erst im Frontend ergaenzt.

## Buttons und Links

1. Button anklicken und den Text direkt bearbeiten.
2. Das Link-Symbol in der Block-Werkzeugleiste waehlen.
3. Interne Seite suchen oder eine vollstaendige externe URL eingeben.
4. Bei externen Zielen nur bei fachlichem Bedarf `In neuem Tab oeffnen` aktivieren.
5. Link speichern und in der Vorschau testen.

Normale Textlinks werden im Rich-Text-Menue auf die gleiche Weise bearbeitet.

## Abschnitte verwalten

Die oberste Group eines Inhaltsbereichs entspricht normalerweise einem Abschnitt.

- Verschieben: Abschnitt in der Listenansicht per Pfeil oder Drag-and-drop bewegen.
- Duplizieren: Drei-Punkte-Menue des Blocks, dann `Duplizieren`.
- Loeschen: Drei-Punkte-Menue, dann `Loeschen`.
- Ausblenden: Die aeussere Group markieren, in den Block-Einstellungen `Stile` oeffnen und `Auf Website ausblenden` waehlen. Der Abschnitt bleibt im Editor abgeblendet sichtbar und wird nur im Frontend verborgen. Zum Einblenden den Standardstil wieder waehlen.
- Neu einfuegen: Plus-Schaltflaeche an der gewuenschten Position verwenden.

Vor dem Verschieben oder Loeschen in der Listenansicht pruefen, ob die aeussere Group und nicht nur ein einzelner Absatz markiert ist.

## Patterns einfuegen

1. Block-Inserter mit `+` oeffnen.
2. Zum Reiter `Patterns` wechseln.
3. Ein Theme-Pattern auswaehlen.
4. Nach dem Einfuegen Texte, Bilder und Links an die Seite anpassen.

Die Theme-Patterns sind Ausgangslayouts. Eingefuegte Instanzen sind voneinander unabhaengig und koennen frei veraendert werden.

## Synced Patterns erkennen

Synced Patterns tragen im Inserter und in der Werkzeugleiste einen Synchronisationshinweis. Aenderungen wirken auf alle Instanzen. Im aktuellen Projekt gibt es noch kein fachlich erforderliches Synced Pattern. Vor dem Erstellen eines neuen Synced Patterns klaeren, ob der Inhalt wirklich global identisch bleiben soll.

Pattern Overrides sind nur relevant, wenn spaeter ein synchronisiertes Layout mit einzelnen instanzspezifischen Feldern eingefuehrt wird.

## FAQ bearbeiten

1. Die Seite `FAQ` im Seiteneditor oeffnen.
2. In der Listenansicht den passenden Themenabschnitt suchen.
3. Einen Details-Block oeffnen.
4. Die Frage in der Summary und die Antwort im aufgeklappten Bereich bearbeiten.
5. Stabile Anker-IDs in den erweiterten Block-Einstellungen nicht ohne Redirect-/Linkpruefung aendern.

Das FAQ-Schema wird automatisch aus den sichtbaren Fragen und Antworten erzeugt. Es muss nicht separat gepflegt werden.

## Header, Footer und Navigation

1. `Design` > `Editor` oeffnen.
2. Fuer Header oder Footer `Design` > `Vorlagen` beziehungsweise `Patterns` > `Template-Teile verwalten` waehlen.
3. Das Site Logo ueber den Logo-Block austauschen.
4. Fuer die Navigation den Navigation-Block waehlen und Links oder Untermenues in der Listenansicht bearbeiten.
5. Globale Aenderungen speichern und anschliessend mehrere Seiten im Frontend pruefen.

Header, Footer und Navigation sind global. Eine Aenderung wirkt nicht nur auf die gerade geoeffnete Seite.

## Globale Styles

Im Site Editor oeffnet das Styles-Symbol die globalen Farben, Typografie und Layoutoptionen. Diese Einstellungen wirken siteweit und sollten nur fuer eine bewusste Designsystem-Aenderung verwendet werden. Fuer einen einzelnen Abschnitt stattdessen dessen Block-Einstellungen verwenden.

## Aenderungen zuruecksetzen

- Ungespeicherte Aenderung: Rueckgaengig-Schaltflaeche oben im Editor.
- Gespeicherte Seite: In den Seiteneinstellungen `Revisionen` oeffnen, Version vergleichen und gezielt wiederherstellen.
- Globales Template oder Styles: Im Site Editor die Revisions-/Reset-Funktion des jeweiligen Bereichs verwenden und vorher Auswirkungen auf mehrere Seiten pruefen.

## Designfehler vermeiden

- Vorhandene Farb-, Typografie- und Abstands-Presets verwenden statt freie Einzelwerte einzutragen.
- Keine Custom-HTML-Bloecke fuer normale Texte, Bilder, Karten oder Buttons verwenden.
- Ueberschriftenhierarchie einhalten: eine H1 pro Seite, danach logisch H2/H3.
- Keine leeren Spacer zur mobilen Layoutkorrektur stapeln.
- Bilder komprimiert und mit treffendem Alt-Text einsetzen.
- Nach groesseren Aenderungen Desktop-, Tablet- und Mobilvorschau pruefen.
- Globale Styles und Template-Parts nur aendern, wenn die Wirkung auf die gesamte Website beabsichtigt ist.
