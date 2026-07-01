<?php

if (! defined('ABSPATH')) {
    exit("This file must run inside WordPress.\n");
}

require_once __DIR__ . '/inc/hero-images.php';
require_once __DIR__ . '/inc/faq.php';

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

function bsh_page_hero(string $eyebrow, string $title, string $lead, string $hero_image = '', string $hero_position = 'center center'): string
{
    $hero_style = bsh_hero_image_style($hero_image, $hero_position);

    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-hero bsh-page-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-hero bsh-page-hero"{$hero_style}>
  <!-- wp:html -->
  <div class="bsh-eyebrow">{$eyebrow}</div>
  <!-- /wp:html -->
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

function bsh_contact_form_definition(): array
{
    return [
        'name' => 'Kontaktformular',
        'fields' => [
            [
                'wrapper_id' => 'wrapper-bsh-contact-name',
                'fields' => [
                    [
                        'element_id' => 'text-1',
                        'type' => 'text',
                        'cols' => '12',
                        'required' => 'true',
                        'field_label' => 'Name',
                    ],
                ],
            ],
            [
                'wrapper_id' => 'wrapper-bsh-contact-email',
                'fields' => [
                    [
                        'element_id' => 'email-1',
                        'type' => 'email',
                        'cols' => '12',
                        'required' => 'true',
                        'field_label' => 'E-Mail',
                        'validation' => true,
                        'validation_text' => 'Bitte gib eine gueltige E-Mail-Adresse ein.',
                    ],
                ],
            ],
            [
                'wrapper_id' => 'wrapper-bsh-contact-topic',
                'fields' => [
                    [
                        'element_id' => 'select-1',
                        'type' => 'select',
                        'cols' => '12',
                        'required' => 'true',
                        'field_label' => 'Thema',
                        'placeholder' => 'Bitte wählen',
                        'options' => [
                            [
                                'label' => 'Erstgespräch',
                                'value' => 'erstgespraech',
                            ],
                            [
                                'label' => 'Einzeltraining',
                                'value' => 'einzeltraining',
                            ],
                            [
                                'label' => 'DOGSpace',
                                'value' => 'dogspace',
                            ],
                            [
                                'label' => 'Workshops und Seminare',
                                'value' => 'workshops-und-seminare',
                            ],
                            [
                                'label' => 'Coaching mit Hund',
                                'value' => 'coaching-mit-hund',
                            ],
                            [
                                'label' => 'Allgemeine Frage',
                                'value' => 'allgemeine-frage',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'wrapper_id' => 'wrapper-bsh-contact-message',
                'fields' => [
                    [
                        'element_id' => 'textarea-1',
                        'type' => 'textarea',
                        'cols' => '12',
                        'required' => 'true',
                        'field_label' => 'Nachricht',
                        'placeholder' => 'Beschreibe kurz dein Anliegen und die aktuelle Situation mit deinem Hund.',
                        'input_type' => 'paragraph',
                        'limit' => '2000',
                        'limit_type' => 'characters',
                    ],
                ],
            ],
        ],
    ];
}

function bsh_contact_form_settings(): array
{
    $settings = class_exists('Forminator_Template_Contact_Form')
        ? (new Forminator_Template_Contact_Form())->settings()
        : [];

    $settings['form-type'] = 'default';
    $settings['submission-behaviour'] = 'behaviour-thankyou';
    $settings['thankyou-message'] = 'Danke, ich melde mich so schnell wie möglich bei dir.';
    $settings['submitData']['custom-submit-text'] = 'Nachricht senden';
    $settings['submitData']['custom-invalid-form-message'] = 'Bitte pruefe die markierten Felder.';
    $settings['enable-ajax'] = 'true';
    $settings['validation-inline'] = true;
    $settings['fields-style'] = 'open';
    $settings['basic-fields-style'] = 'open';
    $settings['form-expire'] = 'no_expire';
    $settings['use-admin-email'] = 'true';
    $settings['notification_count'] = 1;
    $settings['formName'] = 'Kontaktformular';

    return $settings;
}

function bsh_contact_form_notifications(): array
{
    return [
        [
            'slug' => 'notification-bsh-contact-1',
            'label' => 'Admin Email',
            'email-recipients' => 'default',
            'recipients' => 'info@beziehungssache-hund.de',
            'email-subject' => 'Neue Kontaktanfrage über das Formular',
            'email-editor' => "Du hast eine neue Anfrage über die Website erhalten:<br />{all_fields}<br /><br />---<br />Diese Nachricht wurde über {site_url} gesendet.",
            'email-attachment' => 'false',
            'type' => 'default',
            'from-name' => 'Beziehungssache Hund',
            'form-email' => 'info@beziehungssache-hund.de',
            'replyto-email' => '{email-1}',
        ],
    ];
}

function bsh_contact_form_fields(): array
{
    $fields = [];

    foreach (bsh_contact_form_definition()['fields'] as $row) {
        foreach ($row['fields'] as $field_definition) {
            $field = new Forminator_Form_Field_Model();
            $field->form_id = $row['wrapper_id'];
            $field->slug = $field_definition['element_id'];
            unset($field_definition['element_id']);
            $field->import($field_definition);
            $fields[] = $field;
        }
    }

    return $fields;
}

function bsh_sync_contact_form(): int
{
    if (! class_exists('Forminator_Form_Model') || ! class_exists('Forminator_Form_Field_Model')) {
        return 0;
    }

    $stored_id = (int) get_option('bsh_contact_form_id');
    $form_model = null;

    if ($stored_id > 0 && 'forminator_forms' === get_post_type($stored_id)) {
        $form_model = Forminator_Base_Form_Model::get_model($stored_id);
    }

    if (! $form_model instanceof Forminator_Form_Model) {
        $form_model = new Forminator_Form_Model();
    }

    $form_model->clear_fields();
    $form_model->name = 'Kontaktformular';
    $form_model->status = Forminator_Form_Model::STATUS_PUBLISH;
    $form_model->settings = bsh_contact_form_settings();
    $form_model->notifications = bsh_contact_form_notifications();

    foreach (bsh_contact_form_fields() as $field) {
        $form_model->add_field($field);
    }

    $saved_id = $form_model->save();
    if ($saved_id instanceof WP_Error) {
        fwrite(STDERR, $saved_id->get_error_message() . PHP_EOL);
        exit(1);
    }

    update_option('bsh_contact_form_id', (int) $saved_id, false);

    return (int) $saved_id;
}

function bsh_contact_form_shortcode_block(): string
{
    $form_id = bsh_sync_contact_form();

    if ($form_id <= 0) {
        return '';
    }

    return sprintf('<!-- wp:shortcode -->[forminator_form id="%d"]<!-- /wp:shortcode -->', $form_id);
}

function bsh_seo_faq_section(string $keyphrase): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Häufige Fragen zu {$keyphrase}</h2>
  <!-- /wp:heading -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Muss ich schon genau wissen, was ich brauche?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Nein. Oft reicht es völlig aus, wenn du beschreiben kannst, was im Alltag gerade schwierig ist und was du dir stattdessen wünschst. {$keyphrase} ist gerade dafür gedacht, aus einer vagen Belastung eine klar benennbare Situation zu machen. Aus dieser Klarheit lässt sich dann leichter ableiten, ob ein Erstgespräch, ein direktes Training oder eine andere Form von Begleitung sinnvoll ist.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Wie schnell wird aus dem Thema ein nächster Schritt?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Das hängt davon ab, wie komplex eure Ausgangslage ist. Manchmal reicht ein klares Erstgespräch, um Richtung zu geben. Manchmal braucht es mehrere Termine, weil das Verhalten eures Hundes, eure Gewohnheiten und die Umgebung zusammenwirken. {$keyphrase} wird hier deshalb nicht als Schnelllösung verstanden, sondern als saubere Ausgangsbasis für eine vernünftige Entscheidung.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Was bringt mir die Seite im Vergleich zu allgemeinen Tipps?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Allgemeine Tipps können hilfreich sein, wenn es um Grundwissen geht. Sobald aber ein konkreter Alltag, eine konkrete Belastung oder eine konkrete Beziehung zwischen Mensch und Hund im Spiel ist, braucht es mehr Einordnung. {$keyphrase} hilft genau dabei, den Kontext mitzudenken. Das spart Zeit, verhindert Missverständnisse und macht spätere Schritte deutlich treffsicherer.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Woran erkenne ich, dass ich nach außen fragen sollte?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Spätestens dann, wenn du merkst, dass ihr im Kreis läuft, lohnt sich ein externer Blick. Auch wenn du schon einiges ausprobiert hast, kann eine ruhige, strukturierte Einschaetzung entscheidend sein. Die Seite soll dich genau an diesen Punkt führen: erst verstehen, dann entscheiden und erst danach den nächsten Schritt gehen. So bleibt {$keyphrase} nicht nur ein Suchbegriff, sondern wird zu einem brauchbaren Einstieg.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;
}

function bsh_seo_closing_section(string $keyphrase): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--accent","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--accent">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">{$keyphrase} und die nächsten Schritte</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Wenn du nach {$keyphrase} suchst, ist der nächste sinnvolle Schritt meist kein Sprung ins Blaue, sondern ein ruhiges Einordnen der Situation. Genau dafür ist diese Seite gebaut: Sie hilft dir, das Thema nicht nur zu benennen, sondern in Beziehung zu eurem Alltag, eurem Ziel und dem passenden Kontaktweg zu setzen. So wird aus einem Suchbegriff eine klare Entscheidungshilfe.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Besonders hilfreich ist es, wenn du bei einer Anfrage kurz schreibst, was aktuell schwierig ist, wie sich das im Alltag zeigt und was ihr bis jetzt schon versucht habt. Dann lässt sich {$keyphrase} viel schneller einordnen und du bekommst eine Rückmeldung, die wirklich auf eure Lage passt. Das ist meist der beste Weg, um Zeit zu sparen und Fehlstarts zu vermeiden.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Wenn du noch zwischen mehreren Angeboten schaust, nimm dir die Zeit für den Vergleich. {$keyphrase} ist nur dann sinnvoll, wenn es auch wirklich zu eurer Frage passt. Genau deshalb sind die Inhalte auf dieser Seite so gebaut, dass du die Richtung, den Nutzen und den nächsten Schritt ohne Umwege verstehen kannst. Danach fällt die Kontaktaufnahme deutlich leichter.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>So bleibt der Fokus auf dem Wesentlichen: ein klarer Einstieg, ein verständlicher Rahmen und eine ehrliche Einschätzung dessen, was euch nächst hilft. Wenn du soweit bist, kannst du direkt zum passenden Termin oder zur Kontaktseite wechseln und die Anfrage kurz und sachlich stellen.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;
}

function bsh_seo_legal_note_section(string $keyphrase): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">{$keyphrase} sauber zu Ende gedacht</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Rechtsseiten wie {$keyphrase} brauchen eine andere Art von Text als Leistungsseiten. Hier geht es weniger um Verkauf, sondern um Klarheit, Vollständigkeit und verlässliche Orientierung. Deshalb bleibt der Platzhalter bewusst als Arbeitsstand sichtbar: Die Ziel-URL steht fest, die Struktur ist vorbereitet und spätere Pflichtangaben können sauber eingepflegt werden, ohne dass die Navigation oder das Seitenkonzept noch einmal umgebaut werden muss.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Für Nutzer:innen ist es hilfreich, wenn schon jetzt erkennbar ist, wofür die Seite steht und welche Rolle sie später im Gesamtauftritt einnimmt. {$keyphrase} macht also nicht nur eine Pflicht sichtbar, sondern zeigt auch, dass die Website strukturell sauber aufgesetzt ist. So ist die Seite bereits im Rebuild verankert und kann vor dem Launch mit den final geprüften Angaben ersetzt werden.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Bis dahin dient diese Seite als klarer Platzhalter für die spätere Finalisierung. Das ist bewusst transparent gelöst, damit du im lokalen Aufbau schon die richtige URL, den richtigen Seitentyp und den richtigen Platz im Menü hast. Wenn die rechtlich geprüften Texte vorliegen, kann derselbe Rahmen ohne Umwege mit finalem Inhalt gefüllt werden.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;
}

function bsh_erstgespraech_process_step(string $number, string $title, string $text): string
{
    return sprintf(
        <<<'HTML'
<!-- wp:column -->
<div class="wp-block-column">
  <!-- wp:group {"className":"bsh-card bsh-process-step","layout":{"type":"constrained"}} -->
  <div class="wp-block-group bsh-card bsh-process-step">
    <!-- wp:paragraph {"className":"bsh-process-step__number"} -->
    <p class="bsh-process-step__number">%1$s</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":3} -->
    <h3 class="wp-block-heading">%2$s</h3>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
    <p>%3$s</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:column -->
HTML,
        esc_html($number),
        esc_html($title),
        wp_kses_post($text)
    );
}

function bsh_erstgespraech_faq_card(string $question, string $answer): string
{
    return sprintf(
        <<<'HTML'
<!-- wp:group {"className":"bsh-card bsh-erstgespraech-faq-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group bsh-card bsh-erstgespraech-faq-card">
  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">%1$s</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>%2$s</p>
  <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
HTML,
        esc_html($question),
        wp_kses_post($answer)
    );
}

function bsh_erstgespraech_page_content(): string
{
    $process_steps = [
        [
            'number' => '01',
            'title' => 'Die aktuelle Situation schildern',
            'text' => 'Du beschreibst kurz, was im Alltag gerade schwierig ist und wobei du dir Orientierung wünschst.',
        ],
        [
            'number' => '02',
            'title' => 'Ich frage gezielt nach Kontext',
            'text' => 'Ich frage nach Hund, Alltag, Hintergrund und bisherigen Erfahrungen, damit wir nicht aneinander vorbeireden.',
        ],
        [
            'number' => '03',
            'title' => 'Ein realistisches erstes Ziel',
            'text' => 'Gemeinsam formulieren wir ein Ziel, das zu euch passt und nicht schon in der ersten Stunde zu viel verlangt.',
        ],
        [
            'number' => '04',
            'title' => 'Der nächste Schritt',
            'text' => 'Am Ende steht eine klare Empfehlung, ob Einzeltraining, eine andere Begleitung oder zunächst etwas anderes sinnvoll ist.',
        ],
    ];

    $faq_cards = [
        [
            'question' => 'Muss ich schon genau wissen, worin das Problem liegt?',
            'answer' => 'Nein. Es reicht, wenn du beschreibst, was im Alltag schwierig ist und wann es vorkommt. Die genaue Einordnung erarbeiten wir gemeinsam.',
        ],
        [
            'question' => 'Muss mein Hund beim Erstgespräch dabei sein?',
            'answer' => 'Nicht zwingend. Ob dein Hund dabei sein sollte, hängt davon ab, was wir ansehen müssen und welcher Ort sinnvoll ist. Das klären wir vorab individuell.',
        ],
        [
            'question' => 'Finden bereits praktische Übungen statt?',
            'answer' => 'Je nach Situation kann ich dir schon erste sinnvolle Hinweise geben. Der Schwerpunkt liegt aber auf einer sauberen Einschätzung und Orientierung, nicht auf einem kompletten Trainingstermin.',
        ],
        [
            'question' => 'Wo findet das Erstgespräch statt?',
            'answer' => 'Der Ort richtet sich nach eurer Situation. Trainingsort und mögliche Anfahrtskosten stimmen wir vor dem Termin individuell ab.',
        ],
        [
            'question' => 'Was passiert nach dem Gespräch?',
            'answer' => 'Du bekommst eine klare Einschätzung und eine Empfehlung für den nächsten Schritt, zum Beispiel <a href="/einzeltraining/">Einzeltraining</a>, eine andere Form der Begleitung oder zunächst eine andere Priorität.',
        ],
        [
            'question' => 'Ist das Erstgespräch Voraussetzung für Einzeltraining?',
            'answer' => 'Nicht in jedem Fall. Ob ein Erstgespräch sinnvoll oder notwendig ist, hängt davon ab, wie klar eure Ausgangslage bereits ist.',
        ],
    ];

    $content = [];

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-hero bsh-page-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-hero bsh-page-hero">
  <!-- wp:html -->
  <div class="bsh-eyebrow">Einstieg</div>
  <!-- /wp:html -->
  <!-- wp:heading {"level":1,"className":"bsh-page-hero__title"} -->
  <h1 class="wp-block-heading bsh-page-hero__title">Erstgespräch für Hundetraining in Hamburg</h1>
  <!-- /wp:heading -->
  <!-- wp:paragraph {"className":"bsh-page-hero__lead"} -->
  <p class="bsh-page-hero__lead">Wir schauen gemeinsam auf eure aktuelle Situation und klären, welcher nächste Schritt zu dir und deinem Hund passt.</p>
  <!-- /wp:paragraph -->
  <!-- wp:group {"className":"bsh-hero__meta","layout":{"type":"flex","flexWrap":"wrap"}} -->
  <div class="wp-block-group bsh-hero__meta">
    <!-- wp:html -->
    <span>60 Minuten</span><span>85 €</span><span>Termin und Ort nach individueller Absprache</span>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->
  <!-- wp:buttons -->
  <div class="wp-block-buttons">
    <!-- wp:button -->
    <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/kontakt/#erstgespraech-anfragen">Erstgespräch anfragen</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--soft">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Wann ein Erstgespräch hilfreich ist</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Ein Erstgespräch hilft dir besonders dann, wenn du merkst, dass ihr gerade mehr braucht als einen schnellen Tipp.</p>
  <!-- /wp:paragraph -->

  <!-- wp:list -->
  <ul class="wp-block-list">
    <li>du noch unsicher bist, welches Angebot zu euch passt</li>
    <li>Spaziergänge, Leinenführigkeit oder Hundebegegnungen euch spürbar stressen</li>
    <li>Alleinbleiben, Regeln oder Grenzen im Alltag immer wieder kippen</li>
    <li>mehrere Versuche bisher nicht das gebracht haben, was ihr braucht</li>
    <li>du vor dem Einstieg ins <a href="/einzeltraining/">Einzeltraining</a> erst eine klare Einschätzung möchtest</li>
    <li>du mit einem sehr schwierigen oder aggressiven Hund nur nach vorheriger Absprache anfragen möchtest</li>
  </ul>
  <!-- /wp:list -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = bsh_image_slider_section(
        'Was du im Erstgespräch mitbringst',
        'Oft reicht ein ehrlicher Einblick in den Alltag. Die Bilder unten zeigen genau diese ruhige, reale und nicht perfekte Seite.',
        [
            ['slug' => 'vertrauensaufbau-hund-mensch-tierheim', 'alt' => 'Vertrauensaufbau zwischen Hund und Mensch', 'eager' => true],
            ['slug' => 'mensch-hund-beziehung-naehe-zuhause', 'alt' => 'Naehe und Beziehung zwischen Mensch und Hund zuhause'],
        ]
    );

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Du musst nichts perfekt vorbereiten</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Du musst mir keine perfekte Erklärung liefern. Es reicht, wenn du beschreibst, was im Alltag gerade schwierig ist.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Ich schaue dann auf den Kontext: wann das Verhalten auftaucht, wo es passiert, wie euer Alltag aussieht und was ihr schon versucht habt. Wenn ich den Eindruck habe, dass ein anderer Weg sinnvoller ist als dieses Erstgespräch oder ein direkter Einstieg ins Einzeltraining, sage ich dir das offen.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--soft">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">So läuft das Gespräch ab</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Das Gespräch ist kein starres Schema, sondern ein klarer Rahmen, in dem wir euer Thema sortieren.</p>
  <!-- /wp:paragraph -->

  <!-- wp:columns {"className":"bsh-process-grid"} -->
  <div class="wp-block-columns bsh-process-grid">
HTML;

    foreach ($process_steps as $step) {
        $content[] = bsh_erstgespraech_process_step(
            $step['number'],
            $step['title'],
            $step['text']
        );
    }

    $content[] = <<<'HTML'
  </div>
  <!-- /wp:columns -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--accent","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--accent">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Nach dem Erstgespräch weißt du …</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Das Gespräch soll dir Klarheit geben, nicht ein Verhalten in einer Stunde endgültig lösen.</p>
  <!-- /wp:paragraph -->

  <!-- wp:list -->
  <ul class="wp-block-list">
    <li>wie ich eure Situation fachlich einordne</li>
    <li>welches Thema zuerst angegangen werden sollte</li>
    <li>welches erste Ziel im Moment realistisch ist</li>
    <li>ob <a href="/einzeltraining/">Einzeltraining</a> für euch sinnvoll ist</li>
    <li>welcher nächste praktische Schritt zu euch passt</li>
  </ul>
  <!-- /wp:list -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = bsh_image_slider_section(
        'Erstgespräch und erste Orientierung',
        'Zwischen Gespräch und erster Einordnung entsteht oft schon das Gefühl, dass es wieder einen klaren Weg gibt.',
        [
            ['slug' => 'beziehung-hund-vertrauen-blickkontakt-hundetraining', 'alt' => 'Blickkontakt und Vertrauen im Hundetraining'],
            ['slug' => 'intelligenter-hund-high-five-training', 'alt' => 'Hundetraining mit Zusammenarbeit und High Five'],
            ['slug' => 'entspannung-mit-hund-ruhe-und-vertrauen', 'alt' => 'Ruhe und Entspannung mit Hund'],
        ]
    );

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Preis und Rahmen</h2>
  <!-- /wp:heading -->

  <!-- wp:table -->
  <figure class="wp-block-table">
    <table>
      <thead>
        <tr>
          <th>Leistung</th>
          <th>Umfang</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Erstgespräch</td>
          <td>60 Minuten</td>
        </tr>
        <tr>
          <td>Preis</td>
          <td>85 €</td>
        </tr>
        <tr>
          <td>Ort</td>
          <td>individuell nach Situation vereinbart</td>
        </tr>
      </tbody>
    </table>
  </figure>
  <!-- /wp:table -->

  <!-- wp:paragraph -->
  <p>Trainingsort und mögliche Anfahrtskosten stimmen wir vor dem Termin individuell ab. Ob dein Hund beim Erstgespräch dabei ist und welcher Ort sinnvoll ist, klären wir vorab anhand eurer Situation.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Wenn du die Leistungen vorab vergleichen möchtest, findest du die Übersicht auch auf der Seite <a href="/preise/">Preise</a>.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--soft">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Wofür das Erstgespräch da ist</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Es gibt kein starres Standardrezept und keine Garantie, dass ein Thema nach 60 Minuten gelöst ist. Das Erstgespräch soll euch Orientierung geben, die Situation sauber einordnen und verhindern, dass ihr mit einem unpassenden Einstieg startet.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Manchmal ist danach direktes <a href="/einzeltraining/">Einzeltraining</a> sinnvoll, manchmal zuerst etwas anderes. Bei Hunden mit starkem Aggressionsverhalten oder bekannten Beißvorfällen klären wir vorab, ob das Erstgespräch für eure Situation überhaupt der richtige Rahmen ist. Ehrlichkeit ist mir wichtiger als dir ein bestimmtes Paket zu verkaufen.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Warum das in Hamburg oft besonders wichtig ist</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Im Hamburger Alltag treffen viele Hunde auf engem Raum auf Fahrräder, andere Hunde, Lieferverkehr, schmale Gehwege und oft wenig Abstand. Deshalb ordnen wir Probleme nicht abstrakt ein, sondern mit Blick auf euren echten Alltag.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Genau das hilft, wenn du wissen möchtest, welches Hundetraining zu deinem Hund passt oder ob das Problem eher im Umfeld, im Timing oder in der bisherigen Kommunikation liegt. Wenn sich zeigt, dass ihr konkret üben müsst, ist <a href="/einzeltraining/">Einzeltraining</a> meist der nächste Schritt.</p>
  <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--soft">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Häufige Fragen</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Hier beantworte ich die Fragen, die vor einem Erstgespräch am häufigsten auftauchen.</p>
  <!-- /wp:paragraph -->
HTML;

    foreach ($faq_cards as $faq_card) {
        $content[] = bsh_erstgespraech_faq_card($faq_card['question'], $faq_card['answer']);
    }

    $content[] = <<<'HTML'
</section>
<!-- /wp:group -->
HTML;

    $content[] = <<<'HTML'
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--accent","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--accent">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Beschreib kurz, was euch im Alltag beschäftigt</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Du musst noch nicht genau wissen, was ihr braucht. Schreib mir kurz, worin die Schwierigkeit besteht, und wir klären gemeinsam, ob das Erstgespräch der passende Einstieg ist.</p>
  <!-- /wp:paragraph -->

  <!-- wp:buttons -->
  <div class="wp-block-buttons">
    <!-- wp:button -->
    <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/kontakt/#erstgespraech-anfragen">Erstgespräch anfragen</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
</section>
<!-- /wp:group -->
HTML;

    return implode("\n\n", $content);
}

/**
 * @param int $menu_id
 * @return void
 */
function bsh_delete_nav_menu_items(int $menu_id): void
{
    $items = wp_get_nav_menu_items($menu_id);

    if (! is_array($items)) {
        return;
    }

    foreach ($items as $item) {
        if ($item instanceof WP_Post) {
            wp_delete_post($item->ID, true);
        }
    }
}

/**
 * @param int $menu_id
 * @param array<string, mixed> $args
 * @return int
 */
function bsh_add_nav_menu_item(int $menu_id, array $args): int
{
    $menu_item_id = wp_update_nav_menu_item($menu_id, 0, $args);

    if (is_wp_error($menu_item_id)) {
        fwrite(STDERR, $menu_item_id->get_error_message() . PHP_EOL);
        exit(1);
    }

    return (int) $menu_item_id;
}

/**
 * @param array<string, int|WP_Error> $page_ids
 * @return void
 */
function bsh_sync_primary_navigation(array $page_ids): void
{
    $menu_name = 'Hauptnavigation';
    $menu      = wp_get_nav_menu_object($menu_name);

    if (! $menu instanceof WP_Term) {
        $menu_id = wp_create_nav_menu($menu_name);
        if (is_wp_error($menu_id)) {
            fwrite(STDERR, $menu_id->get_error_message() . PHP_EOL);
            exit(1);
        }
        $menu = wp_get_nav_menu_object((int) $menu_id);
    }

    if (! $menu instanceof WP_Term) {
        fwrite(STDERR, "Hauptnavigation konnte nicht angelegt werden." . PHP_EOL);
        exit(1);
    }

    bsh_delete_nav_menu_items((int) $menu->term_id);

    $add_page_item = static function (int $menu_id, string $slug, string $title) use ($page_ids): ?int {
        if (! isset($page_ids[$slug]) || ! is_numeric($page_ids[$slug])) {
            return null;
        }

        $page = get_post((int) $page_ids[$slug]);
        if (! $page instanceof WP_Post) {
            return null;
        }

        return bsh_add_nav_menu_item(
            $menu_id,
            [
                'menu-item-title' => $title,
                'menu-item-object-id' => $page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ]
        );
    };

    foreach ([
        ['slug' => 'startseite', 'title' => 'Startseite'],
        ['slug' => 'erstgespraech', 'title' => 'Erstgespräch'],
        ['slug' => 'einzeltraining', 'title' => 'Einzeltraining'],
        ['slug' => 'ueber-jacky-rebien', 'title' => 'Über mich'],
        ['slug' => 'preise', 'title' => 'Preise'],
        ['slug' => 'kontakt', 'title' => 'Kontakt'],
    ] as $definition) {
        $add_page_item((int) $menu->term_id, $definition['slug'], $definition['title']);
    }

    $more_item_id = bsh_add_nav_menu_item(
        (int) $menu->term_id,
        [
            'menu-item-title' => 'Mehr',
            'menu-item-url' => '#',
            'menu-item-object' => 'custom',
            'menu-item-type' => 'custom',
            'menu-item-status' => 'publish',
        ]
    );

    foreach ([
        ['slug' => 'dogspace-hamburg', 'title' => 'DOGSpace'],
        ['slug' => 'workshops-seminare', 'title' => 'Workshops und Seminare'],
        ['slug' => 'coaching-mit-hund', 'title' => 'Coaching mit Hund'],
    ] as $definition) {
        if (! isset($page_ids[$definition['slug']]) || ! is_numeric($page_ids[$definition['slug']])) {
            continue;
        }

        $page = get_post((int) $page_ids[$definition['slug']]);
        if (! $page instanceof WP_Post) {
            continue;
        }

        bsh_add_nav_menu_item(
            (int) $menu->term_id,
            [
                'menu-item-title' => $definition['title'],
                'menu-item-object-id' => $page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-parent-id' => $more_item_id,
                'menu-item-status' => 'publish',
            ]
        );
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    if (! is_array($locations)) {
        $locations = [];
    }
    $locations['primary'] = (int) $menu->term_id;
    set_theme_mod('nav_menu_locations', $locations);

    $settings = get_option('megamenu_settings', []);
    if (! is_array($settings)) {
        $settings = [];
    }
    $settings['primary'] = array_merge(
        [
            'enabled' => '1',
            'theme' => 'default',
        ],
        isset($settings['primary']) && is_array($settings['primary']) ? $settings['primary'] : []
    );
    $settings['primary']['enabled'] = '1';
    $settings['primary']['theme'] = 'default';
    update_option('megamenu_settings', $settings);

    if (function_exists('do_action')) {
        do_action('megamenu_delete_cache');
    }
}

$pages = [
    [
        'title' => 'Startseite',
        'slug' => 'startseite',
        'order' => 1,
        'content' => implode("\n\n", [
            '<!-- wp:pattern {"slug":"beziehungssache-hund/startseiten-hero"} /-->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Warum Beziehungssache Hund</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Hundetraining Hamburg bedeutet bei Beziehungssache Hund keine laute Methode von der Stange, sondern persönliche Begleitung für Mensch-Hund-Teams, die im Alltag wirklich weiterkommen wollen. Der Blick richtet sich auf Beziehung, Kommunikation und die Frage, welche kleinen Schritte euch wirklich entlasten. So wird aus einer unklaren Situation ein klarer Weg, der zu euch passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du gerade erst beginnst, ist oft das <a href="/erstgespraech/">Erstgespräch</a> der beste Einstieg. Wenn dein Thema schon konkreter ist, kann direktes <a href="/einzeltraining/">Einzeltraining</a> sinnvoll sein. Für Formate mit Begegnung oder Austausch lohnt sich ein Blick auf den <a href="/dogspace-hamburg/">DOGSpace</a>. Auf <a href="https://instagram.com/cazoobi">Instagram</a> gibt es zusätzlich punktuelle Einblicke in Haltung und Arbeitsweise.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Bilder aus eurem Alltag',
                'Hamburger Alltag ist selten glatt oder ruhig. Darum zeigen die Seiten hier keine generischen Platzhalter, sondern echte Szenen, die zu Beziehung, Vertrauen und gemeinsamer Entwicklung passen.',
                [
                    ['slug' => 'mensch-hund-beziehung-naehe-zuhause', 'alt' => 'Mensch und Hund in vertrauter Naehe zuhause', 'eager' => true],
                    ['slug' => 'beziehung-hund-vertrauen-blickkontakt-hundetraining', 'alt' => 'Blickkontakt und Vertrauen im Hundetraining'],
                    ['slug' => 'entspannung-mit-hund-ruhe-und-vertrauen', 'alt' => 'Ruhe und Entspannung mit Hund'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-1600.webp" alt="Hundetraining Hamburg bei Beziehungssache Hund" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So findest du den passenden Einstieg</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Die Startseite führt bewusst nicht alles bis ins Detail aus. Sie soll dir vor allem zeigen, wie Beziehungssache Hund denkt: ruhig, persönlich und ohne unnötigen Druck. Wenn du Leinenführigkeit, Alleinbleiben, Grenzen oder unsichere Begegnungen besser verstehen willst, findest du auf den einzelnen Leistungsseiten die passenden Informationen. So kannst du in Ruhe entscheiden, welcher nächste Schritt für dich und deinen Hund sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Seite ist damit kein bloßer Werbeauftakt, sondern ein echter Orientierungspunkt. Sie verbindet die wichtigsten Einstiege, verweist auf die Kernangebote und macht sichtbar, dass Hundetraining in Hamburg hier immer aus der konkreten Situation heraus gedacht wird.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/problemkarten"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/prozessschritte"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/angebotsübersicht"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/trainerprofil"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/preiskarten"} /-->',
            bsh_seo_faq_section('Hundetraining Hamburg'),
            bsh_seo_closing_section('Hundetraining Hamburg'),
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
                'Individuelles Hundetraining in Hamburg für Mensch-Hund-Teams, die alltagstaugliche Lösungen, Klarheit und eine ruhige Begleitung suchen.',
                'einzeltraining-photorealistisch-01.png',
                '55% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Warum individuelles Hundetraining in Hamburg sinnvoll ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Individuelles Hundetraining in Hamburg passt besonders dann, wenn du keine allgemeine Gruppenstunde suchst, sondern einen klaren Blick auf euren konkreten Alltag brauchst. Beziehungssache Hund begleitet Mensch-Hund-Teams individuell statt pauschal. Im Fokus stehen Alltag, Kommunikation und realistische nächste Schritte, nicht ein lauter Kurskatalog. So entsteht Hundetraining in Hamburg, das zu deinem Hund, zu deinem Tempo und zu eurer Lebensrealität passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Viele Themen wirken von außen ähnlich, haben aber in Wirklichkeit sehr unterschiedliche Ursachen. Darum beginnt individuelles Hundetraining in Hamburg nicht mit schnellen Rezepten, sondern mit einer genauen Einordnung. Ob Leinenführigkeit, Alleinbleiben, Begegnungsstress oder wiederkehrende Unsicherheit: Entscheidend ist, was in eurem Fall wirklich hilft.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Leinenführigkeit</li><li>Alleinbleiben</li><li>Grenzen und Regeln im Alltag</li><li>Unsicherheit oder Stress in Begegnungen</li><li>aggressive Hunde nur nach Absprache</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Wie Hundetraining im Alltag aussieht',
                'Nicht jede Aufgabe passiert auf einer Trainingswiese. Gerade in Hamburg ist es hilfreich, Situationen dort zu zeigen, wo sie wirklich auftauchen: draußen, unterwegs und mitten im Alltag.',
                [
                    ['slug' => 'hund-und-mensch-gemeinsam-im-regen', 'alt' => 'Hund und Mensch gemeinsam unterwegs im Regen', 'eager' => true],
                    ['slug' => 'hundetraining-teamwork-pfote-geben', 'alt' => 'Teamwork im Hundetraining mit Pfote geben'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="Individuelles Hundetraining in Hamburg mit Mensch und Hund" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So läuft Hundetraining in Hamburg bei Beziehungssache Hund ab</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Im ersten Schritt klären wir, wo ihr gerade steht und welches Ziel für euch sinnvoll ist. Danach entscheiden wir, ob ein <a href="/erstgespraech/">Erstgespräch</a>, direktes <a href="/einzeltraining/">Einzeltraining</a> oder ein passender Rahmen wie der <a href="/dogspace-hamburg/">DOGSpace</a> der richtige Einstieg ist. Hundetraining in Hamburg soll euch im Alltag helfen, nicht nur für eine einzelne Stunde funktionieren.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du vorab mehr Einblicke in meine Arbeit möchtest, findest du aktuelle Eindrücke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Die eigentliche Anfrage sollte aber immer von eurer konkreten Situation ausgehen, damit der nächste Schritt wirklich sinnvoll ist.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Passende Einstiege</h2><!-- /wp:heading --><!-- wp:columns {"className":"bsh-card-grid"} --><div class="wp-block-columns bsh-card-grid"><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Erstgespräch</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn du zuerst einordnen möchtest, was für euch sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/erstgespraech/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Einzeltraining</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ihr bereits wisst, dass eine individuelle Begleitung gebraucht wird.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/einzeltraining/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">DOGSpace</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ein geschützter Raum für Begegnung, Austausch oder Formate sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/dogspace-hamburg/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --></section><!-- /wp:group -->',
            bsh_seo_faq_section('individuelles Hundetraining in Hamburg'),
            bsh_seo_closing_section('individuelles Hundetraining in Hamburg'),
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Erstgespräch',
        'slug' => 'erstgespraech',
        'order' => 3,
        'content' => bsh_erstgespraech_page_content(),
    ],
    [
        'title' => 'Einzeltraining',
        'slug' => 'einzeltraining',
        'order' => 4,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Kernangebot',
                'Einzeltraining für Hund und Mensch in Hamburg',
                'Einzeltraining in Hamburg bedeutet bei Beziehungssache Hund eine individuelle, ruhige und alltagstaugliche Begleitung mit nachvollziehbaren Entwicklungsschritten.',
                'einzeltraining-photorealistisch-02.png',
                '62% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Einzeltraining mit Hund in Hamburg – nah an eurem Alltag</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Wer mit einem Hund in Hamburg lebt, kennt die kleinen Herausforderungen des Alltags. Auf dem Gehweg ist wenig Platz, an der nächsten Ecke kommt plötzlich ein anderer Hund entgegen und im Park sind Fahrräder, Kinder, Jogger und freilaufende Hunde gleichzeitig unterwegs. Selbst ein kurzer Spaziergang durch den Kiez kann schnell anstrengend werden, wenn der eigene Hund unsicher ist, stark an der Leine zieht oder bei Hundebegegnungen kaum noch ansprechbar ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Genau deshalb ist Einzeltraining mit Hund in Hamburg sinnvoll, wenn allgemeine Tipps nicht mehr weiterhelfen. Denn es macht einen Unterschied, ob eine Übung auf einer ruhigen Wiese funktioniert oder morgens zwischen Haustür, Straßenverkehr und der ersten Begegnung vor dem Café bestehen muss.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Im Einzeltraining geht es nicht darum, möglichst viele Kommandos zu üben. Viel wichtiger ist die Frage: Was braucht dieses Mensch-Hund-Team, damit der Alltag wieder entspannter wird?</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vielleicht möchtest du mit deinem Hund ruhiger durch den Kiez laufen. Vielleicht wird jede Begegnung auf einem engen Gehweg zum Kraftakt. Oder dein Hund ist draußen so aufgeregt, dass er dich kaum noch wahrnimmt. Solche Situationen lassen sich am besten dort anschauen, wo sie tatsächlich entstehen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Alltag, Reize und gemeinsame Haltung',
                'Gerade im Einzeltraining ist es wichtig, nicht nur das Verhalten zu zeigen, sondern auch die Bedingungen dahinter: Raum, Reizlage, Distanz und dein Handling im Moment.',
                [
                    ['slug' => 'mensch-hund-spielen-gemeinsame-zeit', 'alt' => 'Mensch und Hund beim gemeinsamen Spielen', 'eager' => true],
                    ['slug' => 'mensch-hund-bindung-gemeinsam-sonnenuntergang', 'alt' => 'Mensch und Hund in einer verbindenden Alltagssituation bei Sonnenuntergang'],
                    ['slug' => 'beziehung-hund-vertrauen-blickkontakt-hundetraining', 'alt' => 'Vertrauen und Blickkontakt im Hundetraining'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Hundetraining dort, wo das Problem auftritt</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Das individuelle Hundetraining kann an unterschiedlichen Orten in Hamburg stattfinden. Je nach Thema kann das eure gewohnte Spazierstrecke, das Wohnumfeld, ein Park, ein ruhigerer Trainingsort oder der DOGSpace sein.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn dein Hund beispielsweise bei <a href="/faq/#hundebegegnungen">Hundebegegnungen</a> an der Leine reagiert, hilft es wenig, ausschließlich in einer abgeschirmten Umgebung zu trainieren. Dann sollte das Training schrittweise auf echte Alltagssituationen vorbereiten. Dabei geht es nicht darum, deinen Hund sofort in schwierige Begegnungen zu führen. Zuerst schauen wir, bei welchem Abstand er noch ansprechbar ist und wie du ihm Sicherheit und Orientierung geben kannst.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Auch bei <a href="/faq/#leinenfuehrigkeit">Leinenführigkeit</a> in Hamburg spielen die Bedingungen vor Ort eine große Rolle. Ein Hund läuft auf einer breiten, ruhigen Strecke oft ganz anders als auf einem schmalen Gehweg mit vielen Gerüchen und Ablenkungen. Deshalb müssen die Übungen zu eurem tatsächlichen Alltag passen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was mir bei gutem Einzeltraining wichtig ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Als Hundetrainerin möchte ich nicht nur sagen, was du anders machen sollst. Ich möchte, dass du verstehst, warum dein Hund in einer bestimmten Situation so reagiert und woran du erkennst, dass wir Fortschritte machen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Gutes Einzeltraining sollte deshalb:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>das Verhalten des Hundes verständlich erklären,</li><li>konkrete Übungen für den Alltag vermitteln,</li><li>das Tempo an Hund und Halter anpassen,</li><li>auch kleine Fortschritte sichtbar machen,</li><li>ohne Druck und pauschale Lösungen auskommen.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Nicht jeder Spaziergang wird nach einer Trainingsstunde sofort entspannt sein. Aber es hilft, einen klaren Plan zu haben und zu wissen, was man in schwierigen Momenten tun kann.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Typische Themen im Einzeltraining</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein persönliches Hundetraining in Hamburg kann unter anderem sinnvoll sein, wenn:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>dein Hund bei <a href="/faq/#hundebegegnungen">Hundebegegnungen</a> bellt oder in die Leine springt,</li><li>entspannte <a href="/faq/#angespannte-Spaziergänge">Spaziergänge kaum noch möglich</a> sind,</li><li>dein Hund draußen <a href="/faq/#leinenfuehrigkeit">stark zieht</a>,</li><li>er in <a href="/faq/#stress-belebte-umgebung">belebter Umgebung schnell gestresst</a> ist,</li><li>der <a href="/faq/#rueckruf-unter-ablenkung">Rueckruf unter Ablenkung</a> nicht funktioniert,</li><li>du im Umgang mit deinem Hund <a href="/faq/#unsicherheit-hundehalter">unsicher geworden</a> bist,</li><li>ihr bereits <a href="/faq/#trainingsansaetze-ohne-erfolg">verschiedene Trainingsansaetze ohne Erfolg</a> ausprobiert habt,</li><li>du einen <a href="/faq/#alltagstauglicher-trainingsplan">alltagstauglichen Trainingsplan für deinen Hund</a> suchst.</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--accent","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--accent"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Schritt für Schritt zu mehr Sicherheit im Kiez</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein gutes Ergebnis bedeutet nicht, dass dein Hund plötzlich perfekt funktioniert. Viel wichtiger ist, wieder entspannter aus der Haustür gehen zu können, Begegnungen früher einzuschätzen und in schwierigen Situationen einen klaren nächsten Schritt zu kennen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Genau dabei kann individuelles Hundetraining helfen: nicht mit einem allgemeinen Rezept, sondern mit Übungen, die zu deinem Hund, deinem Wohnumfeld und eurem gemeinsamen Alltag in Hamburg passen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du noch nicht weißt, ob Einzeltraining für euch der richtige Einstieg ist, kann zunächst ein Erstgespräch sinnvoll sein. Dort klären wir, worum es konkret geht, welche Unterstützung ihr benötigt und an welchem Ort das Training am meisten Sinn ergibt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Fortschritt sichtbar machen',
                'Fortschritt ist oft leise. Darum machen die Bilder hier sichtbar, wie Entwicklung im kleinen, realistischen Rahmen aussehen kann: ruhig, kooperativ und ohne Zwang.',
                [
                    ['slug' => 'intelligenter-hund-high-five-training', 'alt' => 'Hund im Training mit High-Five und Zusammenarbeit'],
                    ['slug' => 'vertrauensaufbau-hund-mensch-tierheim', 'alt' => 'Vertrauensaufbau zwischen Hund und Mensch'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Einzeltraining in Hamburg mit Hundetrainerin" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So sieht Einzeltraining in Hamburg aus</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Im Einzeltraining beobachten wir zuerst die Situation, ordnen Verhalten und Auslöser ein und entwickeln daraus umsetzbare Schritte für euren Alltag. Du bekommst keine abstrakten Ratschläge, sondern eine Begleitung, die zu eurem Tempo, euren Möglichkeiten und eurem Ziel passt. Wenn der Einstieg über ein <a href="/erstgespraech/">Erstgespräch</a> sinnvoller ist, kannst du auch dort beginnen.</p><!-- /wp:paragraph --><!-- wp:list {"ordered":true,"className":"bsh-step-list"} --><ol class="wp-block-list bsh-step-list"><li>Situation beobachten</li><li>Verhalten und Zusammenhänge einordnen</li><li>realistisches Ziel definieren</li><li>konkrete Schritte für den Alltag entwickeln</li><li>Fortschritte und Rückschritte gemeinsam auswerten</li></ol><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Mehr zum Ablauf des Einzeltrainings findest du auch in den <a href="/faq/#ablauf-einzeltraining">häufigen Fragen</a>.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Preislogik und nächste Schritte</h2><!-- /wp:heading --><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Hinweis</th></tr></thead><tbody><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gueltig für 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Trainingsort und mögliche Anfahrtskosten stimmen wir vor dem Termin individuell ab. Wenn du vorab einen persönlicheren Eindruck von meiner Arbeit bekommen möchtest, findest du einzelne Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Für die eigentliche Anfrage ist aber die <a href="/kontakt/">Kontaktseite</a> oder das <a href="/erstgespraech/">Erstgespräch</a> der beste Weg.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_faq_section('Einzeltraining in Hamburg'),
            bsh_seo_closing_section('Einzeltraining in Hamburg'),
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
                'DOGSpace Hamburg ist ein begleiteter Lern- und Begegnungsraum für Austausch, Training und passende Formate.',
                'dogspace-hamburg-photorealistisch-02.png',
                '55% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was DOGSpace Hamburg besonders macht</h2><!-- /wp:heading --><!-- wp:paragraph --><p>DOGSpace Hamburg ist kein Toberaum und kein Ersatz für individuelles Einzeltraining. Er schafft einen geschützten Rahmen für bewusste Begegnung, kleine Trainingsformate und fachlichen Austausch. Gerade für Mensch-Hund-Teams, die Struktur, klare Regeln und einen ruhigen Rahmen brauchen, kann DOGSpace Hamburg eine sinnvolle Ergänzung zum Einzeltraining sein.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Im Mittelpunkt stehen nicht möglichst viele Reize, sondern passende Bedingungen. Darum werden Formate, Teilnehmerzahl und Zielgruppe bewusst eingegrenzt. So bleibt der Rahmen übersichtlich und für die Beteiligten gut einschätzbar. Wenn du unsicher bist, ob DOGSpace Hamburg für euch passt, ist ein kurzer Einstieg über die <a href="/kontakt/">Kontaktseite</a> oder das <a href="/erstgespraech/">Erstgespräch</a> sinnvoll.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>DOGSpace kann für Teams interessant sein, die erst einmal ankommen, beobachten und in einem kontrollierten Umfeld Erfahrungen sammeln möchten. Das Format ist bewusst nicht auf Schaustücke oder laute Gruppen ausgelegt, sondern auf ruhige Entwicklung, klaren Umgang miteinander und eine Atmosphäre, in der Hunde und Menschen aufmerksamer wahrnehmen können.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>begleitete Begegnung</li><li>Austausch</li><li>Hundecafe und Stammtisch im passenden Rahmen</li><li>Workshops und Seminare</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Ruhiger Rahmen für Begegnung',
                'DOGSpace ist bewusst kein lauter Ort. Die Bilder zeigen die ruhige, beobachtende und strukturierte Seite des Formats.',
                [
                    ['slug' => 'entspannung-mit-hund-ruhe-und-vertrauen', 'alt' => 'Entspannung mit Hund und Vertrauen'],
                    ['slug' => 'mensch-hund-spielen-gemeinsame-zeit', 'alt' => 'Gemeinsame Zeit beim Spielen'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="DOGSpace Hamburg für Begegnung und Training" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Oeffnungszeiten und Einblicke</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Montag bis Freitag von 13:00 bis 18:00 Uhr, nur mit Anmeldung. Aktuelle Einblicke in Formate und Atmosphaere findest du punktuell auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Oeffentliche Preise für DOGSpace Hamburg werden erst dann dargestellt, wenn sie verifiziert und stabil sind. Bis dahin bleibt die Seite bewusst als Orientierungsseite angelegt, damit du schnell einschätzen kannst, ob der Raum und die Art der Begleitung zu euch passen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_faq_section('DOGSpace Hamburg'),
            bsh_seo_closing_section('DOGSpace Hamburg'),
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
                'Workshops in Hamburg ergänzen das Einzeltraining mit bedarfsorientierten Formaten für Mensch-Hund-Teams und passende Themen rund um Alltag, Kommunikation und Lernen.',
                'dogspace-hamburg-photorealistisch-03.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie Workshops in Hamburg bei Beziehungssache Hund gedacht sind</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Workshops in Hamburg sollen bei Beziehungssache Hund keine beliebige Eventliste füllen, sondern ein klares Thema in einem passenden Rahmen vertiefen. Wenn Formate angeboten werden, stehen Thema, Zielgruppe und Ablauf deutlich im Vordergrund. So entsteht kein Bauchladen, sondern ein Angebot, das für Mensch-Hund-Teams nachvollziehbar und hilfreich bleibt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Je nach Thema können Workshops in Hamburg im DOGSpace oder an einem anderen geeigneten Ort stattfinden. Die Entscheidung hängt davon ab, ob mehr Beobachtung, mehr Ruhe oder mehr Raum für praktische Übungen gebraucht wird. Wenn du wissen möchtest, ob ein geplanter Workshop zu eurer Situation passt, kannst du vorab über die <a href="/kontakt/">Kontaktseite</a> anfragen. Das reduziert Missverständnisse und hilft dabei, nur passende Teilnehmer:innen einzuladen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Für mich ist wichtig, dass Workshops nicht nur Inhalte liefern, sondern zu einem besseren Verständnis zwischen Mensch und Hund beitragen. Darum sind Zielgruppe, Erwartung und praktische Umsetzbarkeit Teil der Beschreibung, nicht bloß ein Randhinweis.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>klare Themenfokusse statt Bauchladen</li><li>Durchführung im DOGSpace oder an einem passenden Ort</li><li>kommunizierte Zielgruppe und Anforderungen vorab</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Workshops mit klarer Struktur',
                'Wenn Formate passen, dann nicht als Eventflaeche, sondern als ruhiger, nachvollziehbarer Rahmen für passende Themen.',
                [
                    ['slug' => 'intelligenter-hund-high-five-training', 'alt' => 'Intelligentes Training mit Hund und High Five'],
                    ['slug' => 'hund-und-mensch-gemeinsam-im-regen', 'alt' => 'Hund und Mensch gemeinsam im Regen'],
                    ['slug' => 'vertrauensaufbau-hund-mensch-tierheim', 'alt' => 'Vertrauensaufbau zwischen Hund und Mensch'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="Workshops in Hamburg für Mensch-Hund-Teams" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Aktuelle Orientierung</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Da Workshops in Hamburg nicht als starres Dauerversprechen kommuniziert werden, gibt es derzeit keinen vollen Veranstaltungskalender. Einblicke in Themen und Haltung findest du gelegentlich auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Wenn du eher eine direkte Begleitung brauchst, ist das <a href="/einzeltraining/">Einzeltraining</a> meist der bessere Einstieg. So bleibt die Seite ehrlich und verwechselt keine Planung mit einem bereits laufenden Programm.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Der Schwerpunkt liegt damit auf Orientierung statt Kalenderfläche. Das ist für Menschen hilfreich, die wissen wollen, ob ein Workshop zu ihrem aktuellen Bedarf passt und welche Formate sinnvoll wären, bevor Termine überhaupt feststehen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_faq_section('Workshops in Hamburg'),
            bsh_seo_closing_section('Workshops in Hamburg'),
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
                'Coaching mit Hund in Hamburg ist eine eigenständige Angebotslinie, klar getrennt vom klassischen Hundetraining.',
                'erstgespraech-photorealistisch-03.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Worum es beim Coaching mit Hund in Hamburg geht</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Coaching mit Hund in Hamburg ist kein allgemeines Business-Coaching und kein pauschales Führungskräfteprogramm. Im Mittelpunkt stehen Klarheit, Präsenz und erlebbare Rückmeldung im passenden Rahmen. Der Hund wird dabei nicht als Dekoration eingesetzt, sondern als Teil eines Settings, das Wahrnehmung, Körpersprache und Verhalten sichtbar machen kann.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Arbeit ist auf Reflexion und unmittelbare Erfahrung ausgerichtet. Das kann für Menschen interessant sein, die mit ihrem Hund nicht nur ein Verhalten beobachten, sondern auch die eigene Wirkung, Haltung und Kommunikation besser verstehen wollen. Weil Coaching mit Hund in Hamburg eine eigene Angebotslinie ist, wird es bewusst vom klassischen Hundetraining getrennt kommuniziert.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du unsicher bist, ob dieses Format oder eher <a href="/einzeltraining/">Einzeltraining</a> für dich sinnvoll ist, lässt sich das vorab über die <a href="/kontakt/">Kontaktseite</a> klären. So wird schnell sichtbar, ob eher praktische Trainingsarbeit oder ein reflektierenderes Setting besser zu eurem Ziel passt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Coaching und Selbstwahrnehmung',
                'Coaching mit Hund lebt von Beziehung, Blickkontakt und klarer Rückmeldung. Darum sind die Bilder hier ruhiger und nah an der Kommunikation zwischen Mensch und Hund.',
                [
                    ['slug' => 'mensch-hund-bindung-gemeinsam-sonnenuntergang', 'alt' => 'Mensch und Hund gemeinsam im Sonnenuntergang'],
                    ['slug' => 'alte-hunde-treue-freundschaft-mensch-hund', 'alt' => 'Treue Freundschaft zwischen Mensch und Hund'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Coaching mit Hund in Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Aktueller Stand</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein öffentlicher Preis ist derzeit noch nicht verifiziert. Anfragen werden deshalb individuell geklärt. Wenn du einen persönlicheren Eindruck von Haltung und Arbeitsweise bekommen möchtest, findest du punktuelle Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Dort gibt es eher einzelne Arbeitsfenster als einen formalen Produktkatalog, was gut zu diesem Angebot passt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_faq_section('Coaching mit Hund in Hamburg'),
            bsh_seo_closing_section('Coaching mit Hund in Hamburg'),
            '<!-- wp:pattern {"slug":"beziehungssache-hund/abschluss-cta"} /-->',
        ]),
    ],
    [
        'title' => 'Über Jacky Rebien',
        'slug' => 'ueber-jacky-rebien',
        'order' => 8,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Vertrauen',
                'Jacky Rebien',
                'Jacky Rebien in Hamburg steht für eine ruhige, klare und alltagstaugliche Begleitung von Mensch-Hund-Teams mit Blick auf Beziehung und Entwicklung.',
                'erstgespraech-photorealistisch-02.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Jacky Rebien in Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wer Jacky Rebien in Hamburg in die Arbeit mitbringt</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Jacky Rebien in Hamburg arbeitet ruhig, zugewandt und mit einem hohen Anspruch an alltagstaugliche Lösungen. Statt pauschaler Rezepte geht es darum, eure Situation zu verstehen und daraus einen realistischen Weg zu entwickeln. Mir ist wichtig, dass Hundetraining nicht einschuechtert, sondern Orientierung gibt und zu euch als Mensch-Hund-Team passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Diese Haltung zeigt sich nicht nur in einzelnen Übungen, sondern auch in der Art, wie Ziele gesetzt und Erwartungen geklaert werden. Ich arbeite lieber mit klaren Prioritaeten als mit zu vielen gleichzeitigen Anforderungen. Das hilft besonders dann, wenn ein Hund unsicher, angespannt oder sehr reaktiv ist und Menschen schnell den Überblick verlieren können.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du zuerst die Arbeitsweise kennenlernen möchtest, findest du über das <a href="/erstgespraech/">Erstgespräch</a> einen guten Einstieg. Zusaetzliche Einblicke in meine Arbeit gibt es punktuell auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. So kannst du dir vorab ein Bild machen, ohne direkt in eine verbindliche Trainingssituation einzusteigen.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Qualifikationen</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Hundetrainerin nach § 11 TierSchG</li><li>Resilienz Coach</li><li>Mensch-Hund-Beraterin</li><li>Mediatorin</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Alltag und Beziehung',
                'Über mich soll nicht nur ein Portrait zeigen, sondern auch, welche Art von Beziehung und Alltag ich mit meiner Arbeit begleite.',
                [
                    ['slug' => 'mensch-hund-spielen-gemeinsame-zeit', 'alt' => 'Gemeinsame Zeit von Mensch und Hund beim Spielen'],
                    ['slug' => 'mensch-hund-beziehung-naehe-zuhause', 'alt' => 'Naehe und Beziehung von Mensch und Hund zuhause'],
                ]
            ),
            bsh_seo_faq_section('Jacky Rebien in Hamburg'),
            bsh_seo_closing_section('Jacky Rebien in Hamburg'),
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
                'Preise für Hundetraining in Hamburg',
                'Preise für Hundetraining in Hamburg sollen dir bei Beziehungssache Hund von Anfang an Klarheit geben, ohne versteckte Bedingungen und ohne widersprüchliche Altwerte.',
                'einzeltraining-photorealistisch-03.png',
                '56% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie du die Preise für Hundetraining in Hamburg einordnen kannst</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Preise für Hundetraining in Hamburg sollen bei Beziehungssache Hund nicht verwirren, sondern dir einen klaren Überblick geben. Darum stehen hier nur die Leistungen, die aktuell verifiziert sind. So kannst du besser einschätzen, ob für euch eher ein Einstieg über das <a href="/erstgespraech/">Erstgespräch</a>, direktes <a href="/einzeltraining/">Einzeltraining</a> oder eine wiederholte Begleitung mit der 5er-Karte sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Preisübersicht ist absichtlich schlank gehalten: Sie soll Orientierung geben, nicht neue Fragen erzeugen. Wenn du zum Beispiel erst einmal klären möchtest, wie ernst euer Thema wirklich ist und welcher Ansatz sinnvoll erscheint, ist das Erstgespräch die passende erste Stufe. Wenn du hingegen schon weißt, dass ihr regelmäßige Begleitung braucht, ist die 5er-Karte oft der bessere Rahmen.</p><!-- /wp:paragraph --><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/logo-full-640.webp" alt="Preise für Hundetraining in Hamburg" /></figure><!-- /wp:image --><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Dauer oder Hinweis</th></tr></thead><tbody><tr><td>Erstgespräch</td><td>85 EUR</td><td>60 Minuten</td></tr><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gültig für 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Die 5er-Karte ist vor allem dann sinnvoll, wenn bereits klar ist, dass ihr wiederholte Begleitung braucht. Für DOGSpace, Workshops und Coaching mit Hund werden noch keine verifizierten öffentlichen Preise dargestellt. Wenn du Einblicke in Haltung und Arbeitsweise suchst, findest du punktuell auch etwas auf <a href="https://instagram.com/cazoobi">Instagram</a>. Für eine erste Einordnung hilft dir außerdem das <a href="/erstgespraech/">Erstgespräch</a>.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_gallery_section(
                'Preise mit Kontext',
                'Die Preisseite soll nicht trocken wirken. Bilder helfen hier, den Einstieg als persönliche, ruhig abgestimmte Leistung zu verstehen.',
                [
                    ['slug' => 'vertrauensaufbau-hund-mensch-tierheim', 'alt' => 'Vertrauen zwischen Hund und Mensch im Training'],
                    ['slug' => 'alte-hunde-treue-freundschaft-mensch-hund', 'alt' => 'Treue Freundschaft zwischen Mensch und Hund'],
                ]
            ),
            bsh_seo_faq_section('Preise für Hundetraining in Hamburg'),
            bsh_seo_closing_section('Preise für Hundetraining in Hamburg'),
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
                'Kontakt für Hundetraining in Hamburg ist bei Beziehungssache Hund direkt per E-Mail, Telefon oder Anfrageformular möglich.',
                'erstgespraech-photorealistisch-01.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Kontakt für Hundetraining in Hamburg" /></figure><!-- /wp:image --><!-- wp:list {"className":"bsh-contact-list"} --><ul class="wp-block-list bsh-contact-list"><li>Beziehungssache Hund</li><li>Jacky Rebien</li><li>Bundesstr. 74, 20144 Hamburg</li><li><a href="mailto:info@beziehungssache-hund.de">info@beziehungssache-hund.de</a></li><li><a href="tel:+4915228385291">01522 8385291</a></li><li>Hamburg und Umgebung</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","anchor":"erstgespraech-anfragen","className":"bsh-section","layout":{"type":"constrained"}} --><section id="erstgespraech-anfragen" class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie Kontakt für Hundetraining in Hamburg am einfachsten funktioniert</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Kontakt für Hundetraining in Hamburg soll dir bei Beziehungssache Hund möglichst wenig Hürden machen. Wenn du ein <a href="/erstgespraech/">Erstgespräch</a>, <a href="/einzeltraining/">Einzeltraining</a> oder eine Rückfrage zu DOGSpace, Workshops oder Coaching mit Hund hast, kannst du direkt per E-Mail, Telefon oder Anfrageformular schreiben. Hilfreich ist, wenn du kurz beschreibst, worum es geht und welcher Alltag euch gerade herausfordert.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Ich antworte am liebsten mit einem kurzen, klaren Blick auf deine Situation, damit wir nicht aneinander vorbeireden. Je genauer du dein Thema beschreibst, desto besser kann ich einschätzen, ob ein Erstgespräch, direktes Einzeltraining oder eine andere Form der Begleitung zu euch passt. Auf diese Weise bleibt Kontakt bei Beziehungssache Hund kein unpersönlicher Posteingang, sondern der Startpunkt für eine echte Einordnung.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was du anfragen kannst</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Erstgespräch</li><li>Einzeltraining</li><li>DOGSpace</li><li>Workshops oder Seminare</li><li>Coaching mit Hund</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Wenn du vorab einen kleinen Eindruck von Haltung und Stil bekommen möchtest, findest du einzelne Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Für verbindliche Absprachen nutze bitte immer die direkten Kontaktwege auf dieser Seite. So landen deine Fragen nicht in einem allgemeinen Formular-Template, sondern bei den Informationen, die für eine gute Antwort wirklich wichtig sind.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Direkt ansprechbar',
                'Die Kontaktseite soll Vertrauen schaffen und den Einstieg erleichtern, nicht nur Informationen sammeln.',
                [
                    ['slug' => 'mensch-hund-beziehung-naehe-zuhause', 'alt' => 'Naehe und Beziehung zwischen Mensch und Hund zuhause'],
                    ['slug' => 'hund-und-mensch-gemeinsam-im-regen', 'alt' => 'Gemeinsam unterwegs im Regen'],
                    ['slug' => 'mensch-hund-spielen-gemeinsame-zeit', 'alt' => 'Gemeinsame Zeit mit Hund beim Spielen'],
                ]
            ),
            bsh_seo_faq_section('Kontakt für Hundetraining in Hamburg'),
            bsh_seo_closing_section('Kontakt für Hundetraining in Hamburg'),
            '<!-- wp:pattern {"slug":"beziehungssache-hund/anfrageformular-bereich"} /-->',
            bsh_contact_form_shortcode_block(),
        ]),
    ],
    [
        'title' => 'Häufige Fragen',
        'slug' => 'faq',
        'order' => 11,
        'content' => bsh_faq_page_content(),
    ],
    [
        'title' => 'Ratgeber',
        'slug' => 'ratgeber',
        'order' => 12,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Ratgeber',
                'Ratgeber rund um Hundetraining und Alltag',
                'Der Ratgeber für Hundetraining in Hamburg bündelt später Fachartikel, Einordnungen und hilfreiche Inhalte für Mensch-Hund-Teams.',
                'dogspace-hamburg-photorealistisch-01.png',
                '48% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wofür der Ratgeber für Hundetraining in Hamburg gedacht ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Der Ratgeber für Hundetraining in Hamburg ist als Beitragsübersicht vorgesehen. Hier sollen später Fachartikel, Einordnungen und hilfreiche Inhalte erscheinen, die typische Alltagsthemen für Mensch-Hund-Teams verständlich aufgreifen. Dazu können Themen wie Leinenführigkeit, Alleinbleiben, Grenzen, Orientierung im Alltag oder die Einordnung verschiedener Trainingswege gehören. Die Seite ist damit kein theoretischer Lückenfüller, sondern ein geplanter Ort für konkrete, alltagsnahe Inhalte.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Seite ist bewusst nicht als fertiges Wissensportal behauptet, solange diese Inhalte noch nicht redaktionell gepflegt sind. Wenn du aktuell eher direkte Unterstützung brauchst, ist das <a href="/erstgespraech/">Erstgespräch</a> oder <a href="/einzeltraining/">Einzeltraining</a> sinnvoller. Neue Artikel können in WordPress später als Beiträge gepflegt werden. So bleibt die Struktur schon jetzt klar, ohne Inhalte vorzutäuschen, die noch gar nicht veröffentlicht sind.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Bild-Slider für spätere Inhalte',
                'Auch der Ratgeber bekommt schon jetzt visuelle Anker, damit die Seite nicht leer wirkt, bevor Artikel gepflegt werden.',
                [
                    ['slug' => 'beziehung-hund-vertrauen-blickkontakt-hundetraining', 'alt' => 'Vertrauen und Blickkontakt im Hundetraining'],
                    ['slug' => 'entspannung-mit-hund-ruhe-und-vertrauen', 'alt' => 'Entspannung und Ruhe mit Hund'],
                ]
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/logo-full-640.webp" alt="Ratgeber Hundetraining Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Welche Themen hier später Platz finden</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Sobald der Ratgeber befüllt wird, können hier Beiträge zu typischen Fragen im Hundetraining erscheinen. Denkbar sind zum Beispiel Texte zu Leinenführigkeit, Alltag mit Hund, Begegnungsstress, Erwartungen an Training oder die Frage, wann ein Erstgespräch sinnvoll ist. Gerade bei Suchanfragen rund um Hundetraining in Hamburg kann so ein inhaltlich sauberes Archiv helfen, statt nur kurze Teaser sichtbar zu machen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du später auf einen einzelnen Beitrag verlinkst, kann der Ratgeber als stabile Übersichtsseite dienen. Bis dahin bleibt er bewusst offen und freundlich als Platzhalter angelegt, damit die redaktionelle Entwicklung sauber nachvollziehbar bleibt. Auf diese Weise ist der Ratgeber schon jetzt in die Struktur eingehängt, ohne falsche Versprechen abzugeben.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_faq_section('Ratgeber für Hundetraining in Hamburg'),
            bsh_seo_closing_section('Ratgeber für Hundetraining in Hamburg'),
        ]),
    ],
    [
        'title' => 'Impressum',
        'slug' => 'impressum',
        'order' => 13,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Recht',
                'Impressum',
                'Das Impressum Beziehungssache Hund ist die verpflichtende Rechtsseite für Anbieterangaben und Kontaktinformationen.',
                'erstgespraech-photorealistisch-03.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung bewusst als Platzhalter angelegt, damit die Ziel-URL und Seitenstruktur bereits bestehen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch müssen hier die rechtlich geprüften Impressumsangaben eingefügt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Ein ruhiger Slider-Zwischenraum',
                'Auch die Pflichtseiten bekommen einen klaren visuellen Anker zwischen Einordnung und den finalen Rechtstexten.',
                [
                    ['slug' => 'entspannung-mit-hund-ruhe-und-vertrauen', 'alt' => 'Ruhe und Vertrauen mit Hund', 'eager' => true],
                ]
            ),
            bsh_seo_faq_section('Impressum Beziehungssache Hund'),
            bsh_seo_closing_section('Impressum Beziehungssache Hund'),
            bsh_seo_legal_note_section('Impressum Beziehungssache Hund'),
        ]),
    ],
    [
        'title' => 'Datenschutz',
        'slug' => 'datenschutz',
        'order' => 14,
        'content' => implode("\n\n", [
            bsh_page_hero(
                'Recht',
                'Datenschutz',
                'Der Datenschutz Beziehungssache Hund beschreibt den Umgang mit personenbezogenen Daten auf dieser Website und bei Anfragen.',
                'erstgespraech-photorealistisch-03.png',
                '50% center'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung als Platzhalter angelegt, damit die Ziel-URL und spätere Navigation bereits vorhanden sind.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch müssen hier die rechtlich geprüften Datenschutzinhalte, inklusive Formular- und Trackingbezug, eingefügt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_image_slider_section(
                'Daten und Verantwortung im Slider',
                'Zwischen Einordnung und Pflichttexten schafft ein Bild mit ruhiger, geschützter Stimmung einen passenden Übergang.',
                [
                    ['slug' => 'mensch-hund-beziehung-naehe-zuhause', 'alt' => 'Naehe und Beziehung zwischen Mensch und Hund zuhause', 'eager' => true],
                ]
            ),
            bsh_seo_faq_section('Datenschutz Beziehungssache Hund'),
            bsh_seo_closing_section('Datenschutz Beziehungssache Hund'),
            bsh_seo_legal_note_section('Datenschutz Beziehungssache Hund'),
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

bsh_sync_primary_navigation($page_ids);

echo sprintf("Seiten synchronisiert: %d\n", count($page_ids));
