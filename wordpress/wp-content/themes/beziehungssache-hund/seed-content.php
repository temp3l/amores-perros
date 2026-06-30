<?php

if (! defined('ABSPATH')) {
    exit("This file must run inside WordPress.\n");
}

/**
 * @param array{title:string,slug:string,order:int,content:string} $definition
 * @return int|WP_Error
 */
function bsh_upsert_page(array $definition)
{
    $existing = get_page_by_path($definition['slug'], OBJECT, 'page');

    $postarr = [
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $definition['title'],
        'post_name' => $definition['slug'],
        'post_content' => $definition['content'],
        'menu_order' => $definition['order'],
    ];

    if ($existing instanceof WP_Post) {
        $postarr['ID'] = $existing->ID;

        return wp_update_post($postarr, true);
    }

    return wp_insert_post($postarr, true);
}

function bsh_page_hero(string $eyebrow, string $title, string $lead): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-hero bsh-page-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-hero bsh-page-hero">
  <!-- wp:paragraph {"className":"bsh-eyebrow"} -->
  <p class="bsh-eyebrow">{$eyebrow}</p>
  <!-- /wp:paragraph -->
  <!-- wp:heading {"level":1,"className":"bsh-page-hero__title"} -->
  <h1 class="wp-block-heading bsh-page-hero__title">{$title}</h1>
  <!-- /wp:heading -->
  <!-- wp:paragraph {"className":"bsh-page-hero__lead"} -->
  <p class="bsh-page-hero__lead">{$lead}</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;
}

$pages = [
    [
        'title' => 'Startseite',
        'slug' => 'startseite',
        'order' => 1,
        'content' => implode("\n\n", [
            '<!-- wp:pattern {"slug":"beziehungssache-hund/startseiten-hero"} /-->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Warum Beziehungssache Hund</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Im Mittelpunkt steht kein starres Trainingsprogramm, sondern die Frage, was euch im Alltag wirklich weiterhilft. Die Arbeit bleibt persoenlich, klar und auf eure konkrete Situation bezogen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/problemkarten"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/prozessschritte"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/angebotsuebersicht"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/trainerprofil"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/preiskarten"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Hundetraining Hamburg',
        'slug' => 'hundetraining-hamburg',
        'order' => 2,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Pillar Page',
                'Hundetraining in Hamburg',
                'Orientierung fuer Mensch-Hund-Teams, die alltagstaugliche Loesungen, Klarheit und eine ruhige Begleitung suchen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:paragraph --><p>Beziehungssache Hund begleitet Mensch-Hund-Teams in Hamburg individuell statt pauschal. Im Fokus stehen Alltag, Kommunikation und realistische naechste Schritte, nicht ein lauter Kurskatalog.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Leinenfuehrigkeit</li><li>Alleinbleiben</li><li>Grenzen und Regeln im Alltag</li><li>Unsicherheit oder Stress in Begegnungen</li><li>aggressive Hunde nur nach Absprache</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Passende Einstiege</h2><!-- /wp:heading --><!-- wp:columns {"className":"bsh-card-grid"} --><div class="wp-block-columns bsh-card-grid"><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Erstgespraech</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn du zuerst einordnen moechtest, was fuer euch sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/erstgespraech/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Einzeltraining</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ihr bereits wisst, dass eine individuelle Begleitung gebraucht wird.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/einzeltraining/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">DOGSpace</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ein geschuetzter Raum fuer Begegnung, Austausch oder Formate sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/dogspace-hamburg/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Erstgespraech',
        'slug' => 'erstgespraech',
        'order' => 3,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Einstieg',
                'Erstgespraech fuer Hundetraining in Hamburg',
                'Gemeinsam klaeren wir eure Situation und den naechsten sinnvollen Schritt fuer Mensch und Hund.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wann das Erstgespraech sinnvoll ist</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>wenn du bei Leinenfuehrigkeit, Alleinbleiben oder Grenzen setzen Orientierung brauchst</li><li>wenn du noch nicht sicher bist, welches Angebot zu euch passt</li><li>wenn ihr einen ruhigen, individuellen Einstieg statt eines Standardprogramms sucht</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So laeuft es ab</h2><!-- /wp:heading --><!-- wp:list {"ordered":true,"className":"bsh-step-list"} --><ol class="wp-block-list bsh-step-list"><li>Wir ordnen die aktuelle Situation ein.</li><li>Ich frage nach Hund, Mensch und Alltag.</li><li>Wir definieren ein realistisches Ziel.</li><li>Danach legen wir den naechsten sinnvollen Schritt fest.</li></ol><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Preis und Dauer</h2><!-- /wp:heading --><!-- wp:table --><figure class="wp-block-table"><table><tbody><tr><td>Preis</td><td>85 EUR</td></tr><tr><td>Dauer</td><td>60 Minuten</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Das Erstgespraech ist kein pauschales Standardrezept und keine garantierte Komplettloesung in einer Stunde. Es dient der fundierten Einordnung und Orientierung.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Einzeltraining',
        'slug' => 'einzeltraining',
        'order' => 4,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Kernangebot',
                'Einzeltraining fuer Hund und Mensch in Hamburg',
                'Individuell, ruhig und alltagstauglich, mit Fokus auf nachvollziehbare Entwicklungsschritte.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Typische Themen</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Leinenfuehrigkeit</li><li>Alleinbleiben</li><li>Grenzen setzen</li><li>angespannte Spaziergaenge</li><li>aggressive Hunde nur nach Absprache</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So sieht die Begleitung aus</h2><!-- /wp:heading --><!-- wp:list {"ordered":true,"className":"bsh-step-list"} --><ol class="wp-block-list bsh-step-list"><li>Situation beobachten</li><li>Verhalten und Zusammenhaenge einordnen</li><li>realistisches Ziel definieren</li><li>konkrete Schritte fuer den Alltag entwickeln</li><li>Fortschritte und Rueckschritte gemeinsam auswerten</li></ol><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Preislogik</h2><!-- /wp:heading --><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Hinweis</th></tr></thead><tbody><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gueltig fuer 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Trainingsort und moegliche Anfahrtskosten stimmen wir vor dem Termin individuell ab.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'DOGSpace',
        'slug' => 'dogspace-hamburg',
        'order' => 5,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Sekundaeres Angebot',
                'DOGSpace in Hamburg',
                'Ein begleiteter Lern- und Begegnungsraum fuer Austausch, Training und passende Formate.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:paragraph --><p>Der DOGSpace ist kein Toberaum und kein Ersatz fuer individuelles Einzeltraining. Er schafft einen geschuetzten Rahmen fuer bewusste Begegnung, kleine Trainingsformate und fachlichen Austausch.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>begleitete Begegnung</li><li>Austausch</li><li>Hundecafe und Stammtisch im passenden Rahmen</li><li>Workshops und Seminare</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Oeffnungszeiten</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Montag bis Freitag von 13:00 bis 18:00 Uhr, nur mit Anmeldung.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Workshops und Seminare',
        'slug' => 'workshops-seminare',
        'order' => 6,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Weitere Angebote',
                'Workshops und Seminare',
                'Bedarfsorientierte Formate fuer Mensch-Hund-Teams und passende Themen rund um Alltag, Kommunikation und Lernen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:paragraph --><p>Workshops und Seminare werden nicht als starrer Veranstaltungskalender versprochen. Wenn Formate angeboten werden, stehen Thema, Zielgruppe und Rahmen klar im Vordergrund.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>klare Themenfokusse statt Bauchladen</li><li>Durchfuehrung im DOGSpace oder an einem passenden Ort</li><li>kommunizierte Zielgruppe und Anforderungen vorab</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Coaching mit Hund',
        'slug' => 'coaching-mit-hund',
        'order' => 7,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Weitere Angebote',
                'Coaching mit Hund',
                'Eine eigenstaendige Angebotslinie, klar getrennt vom klassischen Hundetraining.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:paragraph --><p>Coaching mit Hund ist kein allgemeines Business-Coaching und kein pauschales Fuehrungskraefteprogramm. Im Mittelpunkt stehen Klarheit, Praesenz und erlebbare Rueckmeldung im passenden Rahmen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Ein oeffentlicher Preis ist derzeit noch nicht verifiziert. Anfragen werden deshalb individuell geklaert.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Ueber Jacky Rebien',
        'slug' => 'ueber-jacky-rebien',
        'order' => 8,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Vertrauen',
                'Jacky Rebien',
                'Hundetrainerin in Hamburg mit Blick auf Beziehung, Alltag und klare naechste Schritte.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:paragraph --><p>Ich arbeite ruhig, zugewandt und mit einem hohen Anspruch an alltagstaugliche Loesungen. Statt pauschaler Rezepte geht es darum, eure Situation zu verstehen und daraus einen realistischen Weg zu entwickeln.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Qualifikationen</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Hundetrainerin nach § 11 TierSchG</li><li>Resilienz Coach</li><li>Mensch-Hund-Beraterin</li><li>Mediatorin</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Preise',
        'slug' => 'preise',
        'order' => 9,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Transparenz',
                'Preise fuer Hundetraining in Hamburg',
                'Klare Preise fuer die wichtigsten Leistungen, ohne versteckte Bedingungen und ohne widerspruechliche Altwerte.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Dauer oder Hinweis</th></tr></thead><tbody><tr><td>Erstgespraech</td><td>85 EUR</td><td>60 Minuten</td></tr><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gueltig fuer 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Fuer DOGSpace, Workshops und Coaching mit Hund werden noch keine verifizierten oeffentlichen Preise dargestellt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Kontakt',
        'slug' => 'kontakt',
        'order' => 10,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Kontakt',
                'Kontakt zu Beziehungssache Hund',
                'Schreibe mir oder ruf an, wenn du ein Erstgespraech oder ein passendes Training anfragen moechtest.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:list {"className":"bsh-contact-list"} --><ul class="wp-block-list bsh-contact-list"><li>Beziehungssache Hund</li><li>Jacky Rebien</li><li>Bundesstr. 74, 20144 Hamburg</li><li><a href="mailto:info@beziehungssache-hund.de">info@beziehungssache-hund.de</a></li><li><a href="tel:+4915228385291">01522 8385291</a></li><li>Hamburg und Umgebung</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was du anfragen kannst</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Erstgespraech</li><li>Einzeltraining</li><li>DOGSpace</li><li>Workshops oder Seminare</li><li>Coaching mit Hund</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/anfrageformular-bereich"} /-->',
        ]),
    ],
    [
        'title' => 'Ratgeber',
        'slug' => 'ratgeber',
        'order' => 11,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Ratgeber',
                'Ratgeber rund um Hundetraining und Alltag',
                'Hier werden spaeter Fachartikel, Einordnungen und hilfreiche Inhalte fuer Mensch-Hund-Teams gebuendelt.'
            ),
            '<!-- wp:paragraph --><p>Die Seite ist als Beitragsuebersicht vorgesehen. Neue Artikel koennen in WordPress als Beitraege gepflegt werden.</p><!-- /wp:paragraph -->',
        ]),
    ],
    [
        'title' => 'Impressum',
        'slug' => 'impressum',
        'order' => 12,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Recht',
                'Impressum',
                'Lokale Entwicklungsseite fuer die verpflichtende Rechtsseite.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung bewusst als Platzhalter angelegt, damit die Ziel-URL und Seitenstruktur bereits bestehen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch muessen hier die rechtlich geprueften Impressumsangaben eingefuegt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
        ]),
    ],
    [
        'title' => 'Datenschutz',
        'slug' => 'datenschutz',
        'order' => 13,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Recht',
                'Datenschutz',
                'Lokale Entwicklungsseite fuer die verpflichtende Rechtsseite.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung als Platzhalter angelegt, damit die Ziel-URL und spaetere Navigation bereits vorhanden sind.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch muessen hier die rechtlich geprueften Datenschutzinhalte, inklusive Formular- und Trackingbezug, eingefuegt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
        ]),
    ],
];

$page_ids = [];

foreach ($pages as $page_definition) {
    $page_id = bsh_upsert_page($page_definition);

    if ($page_id instanceof WP_Error) {
        fwrite(STDERR, $page_id->get_error_message() . PHP_EOL);
        exit(1);
    }

    $page_ids[$page_definition['slug']] = $page_id;
}

$sample_page = get_page_by_path('sample-page', OBJECT, 'page');

if ($sample_page instanceof WP_Post) {
    wp_trash_post($sample_page->ID);
}

if (isset($page_ids['startseite'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['startseite']);
}

if (isset($page_ids['ratgeber'])) {
    update_option('page_for_posts', $page_ids['ratgeber']);
}

if (isset($page_ids['datenschutz'])) {
    update_option('wp_page_for_privacy_policy', $page_ids['datenschutz']);
}

echo sprintf("Seiten synchronisiert: %d\n", count($page_ids));
