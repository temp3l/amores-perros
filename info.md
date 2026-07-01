# amore perros 

## 26.06 ?
* 20 min setup + downloads
* 1h beratungs gepsräch + strato
* 10 min domain findung
total: 1:30h analyse, aufbereitung + mailing (28.06)

## 28.06
* 45 min
* gpt chat finden und in tasks umsetzen
* analyse aktuelle website
* ergebnisse:
    * https://chatgpt.com/share/6a410622-48f0-83eb-80f2-9477edb74a9c

## 29.06
* 45min - local wordpress: 6:15 - 7:00
* 3h structure + setiup + theme


## 30.06
* 75 min Gespraech (Domain + Fragen)
* chatgpt init 18:36
* 300 min 

1.07
* 1h tele, 30min uplkoad

## TODO:
- Starte Codex anschließend mit dem Inhalt aus `docs/prompts/implement-faq-page.md`.
- Den Codex-Prompt aus `docs/prompts/wire-faq-einzeltraining-extension.md` ausführen.
- fix the german umlaute! erstgepraech should be erstgespräch, but keep the umlaut version whenever using hrefs,links,ids,url-paths or safe identifiers



## Domains 22:05
    * amores-perros.berlin, zum 23.06.2027
    * amores-perros.hamburg



## Blocs

codex -m gpt-5.3-codex for prompts/03-analyze-blocs-package.md
    * high reasoning
./amores-perros/          # original Blocs project and assets
./blocs-package/          # packaged editable project
./blocs-export/           # newly generated output
./production-ftp/         # actual deployed website snapshot


## prompts


codex -m gpt-5.3-codex for prompts/01-run-codex-wordpress-prompt.md

    

### analysis and setup
i have downloaded the existing amores-perros ewbsite from ftp in the ./amores-perros folder.
provide me a codex prompt to analyze the existing website, including products and all meta information.
goal is to document everything inside the docs folder so that i can rebuild the whole website using codex and wordpress later on.
the current website has a lot of issues, bad SEO reach and marketing issues.

it should extend the existing documentation under ./docs




# Prompts

create an FAQ page.
add the following topics:
Erstgespraech
Einzeltraining
DOGSpace
Workshops oder Seminare
Coaching mit Hund



    Leinenfuehrigkeit

home 

* remove: hero banner 
    * statt hero: kurze prägnante information zum thema
    * beim scrollen mehr infos
* 3 produkte - kurzer text mit photo

* 6 pages
    * erstgespraech
        * preise und umfang auf jede page statt hero
    * 





* landing page mit vielen kurzen informationen zum  durchscrollen
    * jeweils mit bild
 






the landing page should have a product grid with all of the available products as "cards".
use max 3 items in the grid per row on desktop view, and single item in mobile
each card item should have a relevant image in the top and a short outline about product below in the card body text.
for the text use the text from this image: "images/old-landingpage-product-grid.png" for the relevant product, or cretae a a similar one.


the grid on the landing page should have max 2 items per row.
it should be visually appealing with hover effects. all cards should have same height and widht.
    


ich möchte das alle preise so gestyled sind wie in der sektion "Preise im Überblick" auf der landing page




the following image should be be full width, parallax scrolling, first item on the landing page: images/logos/log-cropped.jpg.
additionally scale that image down and use it as logo in the header bar and as favicon


use the following text on the landing page, right after the log-cropped section:
"""
Wilkommen

 auf meiner Webseite – schön, dass du dich für meine Arbeitsweise interessierst.

In dem Buch "Hund und Mensch" von Kurt Kotrschal findet sich sinngemäß ein schöner Satz:

„Hunde erleichtern es, emotionale Beziehungen zu Menschen aufzubauen um mit den Herausforderungen des Lebens besser zurechtzukommen.“

Doch was, wenn der Hund in manchen Lebensbereichen keine Erleichterung oder Bereicherung darstellt, sondern zur Belastungsprobe wird?

Welche Möglichkeiten gibt es für Hund und Halter, die Beziehung zu verbessern, an den richtigen Stellschrauben zu drehen und sinnvolle Veränderungen herbeizuführen?

Genau diese Möglichkeiten möchte ich gemeinsam mit dir herausfinden.

Am Anfang meiner Arbeit stehen deshalb: Zuhören, genaues Hinschauen, Beobachten und Analysieren. Ich stelle viele Fragen – und manche Antworten finden wir gemeinsam. Ich schaue auf Eure Werte, Einstellungen und Wünsche.
Wo an welcher Stelle befindet ihre Euch, lassen sich zB. gemeinsame Hobbies entdecken und können wir einen Weg für eine verständliche Kommunikation finden. 

Daraus entsteht ein erstes Bild der Mensch-Hund-Beziehung. Auf dieser Grundlage entwickeln wir gemeinsam eine individuelle Trainingsmethode.

Wir definieren ein realistisches Ziel, legen konkrete Schritte fest, anhand derer Fortschritte messbar sind, und bestimmen einen Zeitpunkt, bis wann dieses Ziel erreicht werden soll.

Und ich werde euch so eng wie möglich begleiten. """


