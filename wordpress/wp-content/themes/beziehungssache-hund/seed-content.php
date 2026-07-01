<?php

if (! defined('ABSPATH')) {
    exit("This file must run inside WordPress.\n");
}

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

function bsh_page_hero(string $eyebrow, string $title, string $lead): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-hero bsh-page-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-hero bsh-page-hero">
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
                        'placeholder' => 'Bitte waehlen',
                        'options' => [
                            [
                                'label' => 'Erstgespraech',
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
    $settings['thankyou-message'] = 'Danke, ich melde mich so schnell wie moeglich bei dir.';
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
            'email-subject' => 'Neue Kontaktanfrage ueber das Formular',
            'email-editor' => "Du hast eine neue Anfrage ueber die Website erhalten:<br />{all_fields}<br /><br />---<br />Diese Nachricht wurde ueber {site_url} gesendet.",
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

function bsh_seo_support_section(string $keyphrase): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section bsh-section--soft">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">{$keyphrase} genauer betrachtet</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>{$keyphrase} steht auf dieser Seite nicht als Schlagwort fuer sich allein, sondern als klare Orientierung fuer Menschen, die wissen wollen, was in der jeweiligen Situation wirklich hilft. Darum geht es hier immer um Einordnung, alltagstaugliche naechste Schritte und die Frage, wie aus einem abstrakten Thema ein sauberer, ruhiger und verstaendlicher Weg wird. Genau dieser Blick macht den Unterschied zwischen einer schnellen Reaktion und einer Begleitung, die langfristig tragfaehig ist.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Wenn du dich mit {$keyphrase} beschaeftigst, geht es oft um mehr als nur ein einzelnes Verhalten. Meist spielen Alltag, Vorgeschichte, Erwartungen, Umgebung und euer Zusammenspiel eine Rolle. Deshalb lohnt sich ein genauerer Blick auf Zusammenhaenge, bevor man zu frueh an einer kleinen Oberflaeche herumkorrigiert. Die Seite soll dir genau diese Einordnung geben und dir helfen, das Thema schnell, aber nicht oberflaechlich zu verstehen.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Woran du gute naechste Schritte erkennst</h3>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Ein sinnvoller naechster Schritt erkennt sich daran, dass er zu eurem Alltag passt. Er darf klar sein, aber nicht ueberfordernd. Er darf Orientierung geben, aber nicht mit Regeln ueberladen. Wenn du {$keyphrase} suchst, ist es meistens hilfreich, zuerst zu verstehen, welches Ziel ihr eigentlich verfolgt: mehr Ruhe, mehr Sicherheit, bessere Kommunikation oder eine belastbare Struktur im Alltag. Erst danach wird aus einem allgemeinen Wunsch eine konkrete Entscheidung.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Gute Begleitung beantwortet nicht nur die Frage, was getan werden soll, sondern auch warum ein Schritt zu diesem Zeitpunkt sinnvoll ist. Das ist besonders wichtig, wenn mehrere Themen zusammenkommen oder wenn du schon verschiedene Ansatze ausprobiert hast. Dann ist nicht mehr Tempo entscheidend, sondern Klarheit. Genau deshalb ist {$keyphrase} hier so eingebettet, dass du den Inhalt nicht nur lesen, sondern fuer eure Situation einordnen kannst.</p>
  <!-- /wp:paragraph -->

  <!-- wp:list -->
  <ul class="wp-block-list">
    <li>das Thema wird sofort klar benannt</li>
    <li>die Seite zeigt dir den naechsten sinnvollen Einstieg</li>
    <li>Alltag und Ziel stehen vor abstrakten Tipps</li>
    <li>du erkennst schnell, ob Kontakt oder Erstgespraech passt</li>
  </ul>
  <!-- /wp:list -->
</section>
<!-- /wp:group -->
HTML;
}

function bsh_seo_faq_section(string $keyphrase): string
{
    return <<<HTML
<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group bsh-section">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Haeufige Fragen zu {$keyphrase}</h2>
  <!-- /wp:heading -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Muss ich schon genau wissen, was ich brauche?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Nein. Oft reicht es voellig aus, wenn du beschreiben kannst, was im Alltag gerade schwierig ist und was du dir stattdessen wuenschst. {$keyphrase} ist gerade dafuer gedacht, aus einer vagen Belastung eine klar benennbare Situation zu machen. Aus dieser Klarheit laesst sich dann leichter ableiten, ob ein Erstgespraech, ein direktes Training oder eine andere Form von Begleitung sinnvoll ist.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Wie schnell wird aus dem Thema ein naechster Schritt?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Das haengt davon ab, wie komplex eure Ausgangslage ist. Manchmal reicht ein klares Erstgespraech, um Richtung zu geben. Manchmal braucht es mehrere Termine, weil das Verhalten eures Hundes, eure Gewohnheiten und die Umgebung zusammenwirken. {$keyphrase} wird hier deshalb nicht als Schnellloesung verstanden, sondern als saubere Ausgangsbasis fuer eine vernuenftige Entscheidung.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Was bringt mir die Seite im Vergleich zu allgemeinen Tipps?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Allgemeine Tipps koennen hilfreich sein, wenn es um Grundwissen geht. Sobald aber ein konkreter Alltag, eine konkrete Belastung oder eine konkrete Beziehung zwischen Mensch und Hund im Spiel ist, braucht es mehr Einordnung. {$keyphrase} hilft genau dabei, den Kontext mitzudenken. Das spart Zeit, verhindert Missverstaendnisse und macht spaetere Schritte deutlich treffsicherer.</p>
  <!-- /wp:paragraph -->

  <!-- wp:heading {"level":3} -->
  <h3 class="wp-block-heading">Woran erkenne ich, dass ich nach aussen fragen sollte?</h3>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Spaetestens dann, wenn du merkst, dass ihr im Kreis laeuft, lohnt sich ein externer Blick. Auch wenn du schon einiges ausprobiert hast, kann eine ruhige, strukturierte Einschaetzung entscheidend sein. Die Seite soll dich genau an diesen Punkt fuehren: erst verstehen, dann entscheiden und erst danach den naechsten Schritt gehen. So bleibt {$keyphrase} nicht nur ein Suchbegriff, sondern wird zu einem brauchbaren Einstieg.</p>
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
  <h2 class="wp-block-heading">{$keyphrase} und die naechsten Schritte</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>Wenn du nach {$keyphrase} suchst, ist der naechste sinnvolle Schritt meist kein Sprung ins Blaue, sondern ein ruhiges Einordnen der Situation. Genau dafuer ist diese Seite gebaut: Sie hilft dir, das Thema nicht nur zu benennen, sondern in Beziehung zu eurem Alltag, eurem Ziel und dem passenden Kontaktweg zu setzen. So wird aus einem Suchbegriff eine klare Entscheidungshilfe.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Besonders hilfreich ist es, wenn du bei einer Anfrage kurz schreibst, was aktuell schwierig ist, wie sich das im Alltag zeigt und was ihr bis jetzt schon versucht habt. Dann laesst sich {$keyphrase} viel schneller einordnen und du bekommst eine Rueckmeldung, die wirklich auf eure Lage passt. Das ist meist der beste Weg, um Zeit zu sparen und Fehlstarts zu vermeiden.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Wenn du noch zwischen mehreren Angeboten schaust, nimm dir die Zeit fuer den Vergleich. {$keyphrase} ist nur dann sinnvoll, wenn es auch wirklich zu eurer Frage passt. Genau deshalb sind die Inhalte auf dieser Seite so gebaut, dass du die Richtung, den Nutzen und den naechsten Schritt ohne Umwege verstehen kannst. Danach faellt die Kontaktaufnahme deutlich leichter.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>So bleibt der Fokus auf dem Wesentlichen: ein klarer Einstieg, ein verstaendlicher Rahmen und eine ehrliche Einschaetzung dessen, was euch naechst hilft. Wenn du soweit bist, kannst du direkt zum passenden Termin oder zur Kontaktseite wechseln und die Anfrage kurz und sachlich stellen.</p>
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
  <p>Rechtsseiten wie {$keyphrase} brauchen eine andere Art von Text als Leistungsseiten. Hier geht es weniger um Verkauf, sondern um Klarheit, Vollstaendigkeit und verlaessliche Orientierung. Deshalb bleibt der Platzhalter bewusst als Arbeitsstand sichtbar: Die Ziel-URL steht fest, die Struktur ist vorbereitet und spaetere Pflichtangaben koennen sauber eingepflegt werden, ohne dass die Navigation oder das Seitenkonzept noch einmal umgebaut werden muss.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Fuer Nutzer:innen ist es hilfreich, wenn schon jetzt erkennbar ist, wofuer die Seite steht und welche Rolle sie spaeter im Gesamtauftritt einnimmt. {$keyphrase} macht also nicht nur eine Pflicht sichtbar, sondern zeigt auch, dass die Website strukturell sauber aufgesetzt ist. So ist die Seite bereits im Rebuild verankert und kann vor dem Launch mit den final geprueften Angaben ersetzt werden.</p>
  <!-- /wp:paragraph -->

  <!-- wp:paragraph -->
  <p>Bis dahin dient diese Seite als klarer Platzhalter fuer die spaetere Finalisierung. Das ist bewusst transparent geloest, damit du im lokalen Aufbau schon die richtige URL, den richtigen Seitentyp und den richtigen Platz im Menue hast. Wenn die rechtlich geprueften Texte vorliegen, kann derselbe Rahmen ohne Umwege mit finalem Inhalt gefuellt werden.</p>
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

$pages = [
    [
        'title' => 'Startseite',
        'slug' => 'startseite',
        'order' => 1,
        'content' => implode("\n\n", [
            '<!-- wp:pattern {"slug":"beziehungssache-hund/startseiten-hero"} /-->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Warum Beziehungssache Hund</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Hundetraining Hamburg bedeutet bei Beziehungssache Hund keine laute Methode von der Stange, sondern persoenliche Begleitung fuer Mensch-Hund-Teams, die im Alltag wirklich weiterkommen wollen. Der Blick richtet sich auf Beziehung, Kommunikation und die Frage, welche kleinen Schritte euch wirklich entlasten. So wird aus einer unklaren Situation ein klarer Weg, der zu euch passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du gerade erst beginnst, ist oft das <a href="/erstgespraech/">Erstgespraech</a> der beste Einstieg. Wenn dein Thema schon konkreter ist, kann direktes <a href="/einzeltraining/">Einzeltraining</a> sinnvoll sein. Fuer Formate mit Begegnung oder Austausch lohnt sich ein Blick auf den <a href="/dogspace-hamburg/">DOGSpace</a>. Auf <a href="https://instagram.com/cazoobi">Instagram</a> gibt es zusaetzlich punktuelle Einblicke in Haltung und Arbeitsweise.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-1600.webp" alt="Hundetraining Hamburg bei Beziehungssache Hund" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So findest du den passenden Einstieg</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Die Startseite fuehrt bewusst nicht alles bis ins Detail aus. Sie soll dir vor allem zeigen, wie Beziehungssache Hund denkt: ruhig, persoenlich und ohne unnötigen Druck. Wenn du Leinenfuehrigkeit, Alleinbleiben, Grenzen oder unsichere Begegnungen besser verstehen willst, findest du auf den einzelnen Leistungsseiten die passenden Informationen. So kannst du in Ruhe entscheiden, welcher naechste Schritt fuer dich und deinen Hund sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Seite ist damit kein bloßer Werbeauftakt, sondern ein echter Orientierungspunkt. Sie verbindet die wichtigsten Einstiege, verweist auf die Kernangebote und macht sichtbar, dass Hundetraining in Hamburg hier immer aus der konkreten Situation heraus gedacht wird.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/problemkarten"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/prozessschritte"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/angebotsuebersicht"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/trainerprofil"} /-->',
            '<!-- wp:pattern {"slug":"beziehungssache-hund/preiskarten"} /-->',
            bsh_seo_support_section('Hundetraining Hamburg'),
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
                'Individuelles Hundetraining in Hamburg fuer Mensch-Hund-Teams, die alltagstaugliche Loesungen, Klarheit und eine ruhige Begleitung suchen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Warum individuelles Hundetraining in Hamburg sinnvoll ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Individuelles Hundetraining in Hamburg passt besonders dann, wenn du keine allgemeine Gruppenstunde suchst, sondern einen klaren Blick auf euren konkreten Alltag brauchst. Beziehungssache Hund begleitet Mensch-Hund-Teams individuell statt pauschal. Im Fokus stehen Alltag, Kommunikation und realistische naechste Schritte, nicht ein lauter Kurskatalog. So entsteht Hundetraining in Hamburg, das zu deinem Hund, zu deinem Tempo und zu eurer Lebensrealitaet passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Viele Themen wirken von aussen aehnlich, haben aber in Wirklichkeit sehr unterschiedliche Ursachen. Darum beginnt individuelles Hundetraining in Hamburg nicht mit schnellen Rezepten, sondern mit einer genauen Einordnung. Ob Leinenfuehrigkeit, Alleinbleiben, Begegnungsstress oder wiederkehrende Unsicherheit: Entscheidend ist, was in eurem Fall wirklich hilft.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>Leinenfuehrigkeit</li><li>Alleinbleiben</li><li>Grenzen und Regeln im Alltag</li><li>Unsicherheit oder Stress in Begegnungen</li><li>aggressive Hunde nur nach Absprache</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="Individuelles Hundetraining in Hamburg mit Mensch und Hund" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So laeuft Hundetraining in Hamburg bei Beziehungssache Hund ab</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Im ersten Schritt klaeren wir, wo ihr gerade steht und welches Ziel fuer euch sinnvoll ist. Danach entscheiden wir, ob ein <a href="/erstgespraech/">Erstgespraech</a>, direktes <a href="/einzeltraining/">Einzeltraining</a> oder ein passender Rahmen wie der <a href="/dogspace-hamburg/">DOGSpace</a> der richtige Einstieg ist. Hundetraining in Hamburg soll euch im Alltag helfen, nicht nur fuer eine einzelne Stunde funktionieren.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du vorab mehr Einblicke in meine Arbeit moechtest, findest du aktuelle Eindruecke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Die eigentliche Anfrage sollte aber immer von eurer konkreten Situation ausgehen, damit der naechste Schritt wirklich sinnvoll ist.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Passende Einstiege</h2><!-- /wp:heading --><!-- wp:columns {"className":"bsh-card-grid"} --><div class="wp-block-columns bsh-card-grid"><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Erstgespraech</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn du zuerst einordnen moechtest, was fuer euch sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/erstgespraech/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Einzeltraining</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ihr bereits wisst, dass eine individuelle Begleitung gebraucht wird.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/einzeltraining/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"bsh-card","layout":{"type":"constrained"}} --><div class="wp-block-group bsh-card"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">DOGSpace</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Wenn ein geschuetzter Raum fuer Begegnung, Austausch oder Formate sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href="/dogspace-hamburg/">Zur Seite</a></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --></section><!-- /wp:group -->',
            bsh_seo_support_section('individuelles Hundetraining in Hamburg'),
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
                'Einzeltraining fuer Hund und Mensch in Hamburg',
                'Einzeltraining in Hamburg bedeutet bei Beziehungssache Hund eine individuelle, ruhige und alltagstaugliche Begleitung mit nachvollziehbaren Entwicklungsschritten.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Einzeltraining mit Hund in Hamburg – nah an eurem Alltag</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Wer mit einem Hund in Hamburg lebt, kennt die kleinen Herausforderungen des Alltags. Auf dem Gehweg ist wenig Platz, an der naechsten Ecke kommt ploetzlich ein anderer Hund entgegen und im Park sind Fahrräder, Kinder, Jogger und freilaufende Hunde gleichzeitig unterwegs. Selbst ein kurzer Spaziergang durch den Kiez kann schnell anstrengend werden, wenn der eigene Hund unsicher ist, stark an der Leine zieht oder bei Hundebegegnungen kaum noch ansprechbar ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Genau deshalb ist Einzeltraining mit Hund in Hamburg sinnvoll, wenn allgemeine Tipps nicht mehr weiterhelfen. Denn es macht einen Unterschied, ob eine Uebung auf einer ruhigen Wiese funktioniert oder morgens zwischen Haustuer, Strassenverkehr und der ersten Begegnung vor dem Café bestehen muss.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Im Einzeltraining geht es nicht darum, moeglichst viele Kommandos zu ueben. Viel wichtiger ist die Frage: Was braucht dieses Mensch-Hund-Team, damit der Alltag wieder entspannter wird?</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vielleicht moechtest du mit deinem Hund ruhiger durch den Kiez laufen. Vielleicht wird jede Begegnung auf einem engen Gehweg zum Kraftakt. Oder dein Hund ist draussen so aufgeregt, dass er dich kaum noch wahrnimmt. Solche Situationen lassen sich am besten dort anschauen, wo sie tatsaechlich entstehen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Hundetraining dort, wo das Problem auftritt</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Das individuelle Hundetraining kann an unterschiedlichen Orten in Hamburg stattfinden. Je nach Thema kann das eure gewohnte Spazierstrecke, das Wohnumfeld, ein Park, ein ruhigerer Trainingsort oder der DOGSpace sein.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn dein Hund beispielsweise bei <a href="/faq/#hundebegegnungen">Hundebegegnungen</a> an der Leine reagiert, hilft es wenig, ausschliesslich in einer abgeschirmten Umgebung zu trainieren. Dann sollte das Training schrittweise auf echte Alltagssituationen vorbereiten. Dabei geht es nicht darum, deinen Hund sofort in schwierige Begegnungen zu fuehren. Zuerst schauen wir, bei welchem Abstand er noch ansprechbar ist und wie du ihm Sicherheit und Orientierung geben kannst.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Auch bei <a href="/faq/#leinenfuehrigkeit">Leinenfuehrigkeit</a> in Hamburg spielen die Bedingungen vor Ort eine grosse Rolle. Ein Hund laeuft auf einer breiten, ruhigen Strecke oft ganz anders als auf einem schmalen Gehweg mit vielen Geruechen und Ablenkungen. Deshalb muessen die Uebungen zu eurem tatsaechlichen Alltag passen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was mir bei gutem Einzeltraining wichtig ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Als Hundetrainerin moechte ich nicht nur sagen, was du anders machen sollst. Ich moechte, dass du verstehst, warum dein Hund in einer bestimmten Situation so reagiert und woran du erkennst, dass wir Fortschritte machen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Gutes Einzeltraining sollte deshalb:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>das Verhalten des Hundes verstaendlich erklaeren,</li><li>konkrete Uebungen fuer den Alltag vermitteln,</li><li>das Tempo an Hund und Halter anpassen,</li><li>auch kleine Fortschritte sichtbar machen,</li><li>ohne Druck und pauschale Loesungen auskommen.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Nicht jeder Spaziergang wird nach einer Trainingsstunde sofort entspannt sein. Aber es hilft, einen klaren Plan zu haben und zu wissen, was man in schwierigen Momenten tun kann.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Typische Themen im Einzeltraining</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein persoenliches Hundetraining in Hamburg kann unter anderem sinnvoll sein, wenn:</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>dein Hund bei <a href="/faq/#hundebegegnungen">Hundebegegnungen</a> bellt oder in die Leine springt,</li><li>entspannte <a href="/faq/#angespannte-spaziergaenge">Spaziergaenge kaum noch moeglich</a> sind,</li><li>dein Hund draussen <a href="/faq/#leinenfuehrigkeit">stark zieht</a>,</li><li>er in <a href="/faq/#stress-belebte-umgebung">belebter Umgebung schnell gestresst</a> ist,</li><li>der <a href="/faq/#rueckruf-unter-ablenkung">Rueckruf unter Ablenkung</a> nicht funktioniert,</li><li>du im Umgang mit deinem Hund <a href="/faq/#unsicherheit-hundehalter">unsicher geworden</a> bist,</li><li>ihr bereits <a href="/faq/#trainingsansaetze-ohne-erfolg">verschiedene Trainingsansaetze ohne Erfolg</a> ausprobiert habt,</li><li>du einen <a href="/faq/#alltagstauglicher-trainingsplan">alltagstauglichen Trainingsplan fuer deinen Hund</a> suchst.</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--accent","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--accent"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Schritt fuer Schritt zu mehr Sicherheit im Kiez</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein gutes Ergebnis bedeutet nicht, dass dein Hund ploetzlich perfekt funktioniert. Viel wichtiger ist, wieder entspannter aus der Haustuer gehen zu koennen, Begegnungen frueher einzuschaetzen und in schwierigen Situationen einen klaren naechsten Schritt zu kennen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Genau dabei kann individuelles Hundetraining helfen: nicht mit einem allgemeinen Rezept, sondern mit Uebungen, die zu deinem Hund, deinem Wohnumfeld und eurem gemeinsamen Alltag in Hamburg passen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du noch nicht weisst, ob Einzeltraining fuer euch der richtige Einstieg ist, kann zunaechst ein Erstgespraech sinnvoll sein. Dort klaeren wir, worum es konkret geht, welche Unterstuetzung ihr benoetigt und an welchem Ort das Training am meisten Sinn ergibt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Einzeltraining in Hamburg mit Hundetrainerin" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">So sieht Einzeltraining in Hamburg aus</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Im Einzeltraining beobachten wir zuerst die Situation, ordnen Verhalten und Auslöser ein und entwickeln daraus umsetzbare Schritte für euren Alltag. Du bekommst keine abstrakten Ratschläge, sondern eine Begleitung, die zu eurem Tempo, euren Möglichkeiten und eurem Ziel passt. Wenn der Einstieg über ein <a href="/erstgespraech/">Erstgespräch</a> sinnvoller ist, kannst du auch dort beginnen.</p><!-- /wp:paragraph --><!-- wp:list {"ordered":true,"className":"bsh-step-list"} --><ol class="wp-block-list bsh-step-list"><li>Situation beobachten</li><li>Verhalten und Zusammenhänge einordnen</li><li>realistisches Ziel definieren</li><li>konkrete Schritte für den Alltag entwickeln</li><li>Fortschritte und Rückschritte gemeinsam auswerten</li></ol><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Mehr zum Ablauf des Einzeltrainings findest du auch in den <a href="/faq/#ablauf-einzeltraining">häufigen Fragen</a>.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Preislogik und naechste Schritte</h2><!-- /wp:heading --><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Hinweis</th></tr></thead><tbody><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gueltig fuer 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Trainingsort und moegliche Anfahrtskosten stimmen wir vor dem Termin individuell ab. Wenn du vorab einen persoenlicheren Eindruck von meiner Arbeit bekommen moechtest, findest du einzelne Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Fuer die eigentliche Anfrage ist aber die <a href="/kontakt/">Kontaktseite</a> oder das <a href="/erstgespraech/">Erstgespraech</a> der beste Weg.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Einzeltraining in Hamburg'),
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
                'DOGSpace Hamburg ist ein begleiteter Lern- und Begegnungsraum fuer Austausch, Training und passende Formate.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was DOGSpace Hamburg besonders macht</h2><!-- /wp:heading --><!-- wp:paragraph --><p>DOGSpace Hamburg ist kein Toberaum und kein Ersatz fuer individuelles Einzeltraining. Er schafft einen geschuetzten Rahmen fuer bewusste Begegnung, kleine Trainingsformate und fachlichen Austausch. Gerade fuer Mensch-Hund-Teams, die Struktur, klare Regeln und einen ruhigen Rahmen brauchen, kann DOGSpace Hamburg eine sinnvolle Ergaenzung zum Einzeltraining sein.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Im Mittelpunkt stehen nicht moeglichst viele Reize, sondern passende Bedingungen. Darum werden Formate, Teilnehmerzahl und Zielgruppe bewusst eingegrenzt. So bleibt der Rahmen uebersichtlich und fuer die Beteiligten gut einschatzbar. Wenn du unsicher bist, ob DOGSpace Hamburg fuer euch passt, ist ein kurzer Einstieg ueber die <a href="/kontakt/">Kontaktseite</a> oder das <a href="/erstgespraech/">Erstgespraech</a> sinnvoll.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>DOGSpace kann fuer Teams interessant sein, die erst einmal ankommen, beobachten und in einem kontrollierten Umfeld Erfahrungen sammeln moechten. Das Format ist bewusst nicht auf Schaustuecke oder laute Gruppen ausgelegt, sondern auf ruhige Entwicklung, klaren Umgang miteinander und eine Atmosphaere, in der Hunde und Menschen aufmerksamer wahrnehmen koennen.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>begleitete Begegnung</li><li>Austausch</li><li>Hundecafe und Stammtisch im passenden Rahmen</li><li>Workshops und Seminare</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="DOGSpace Hamburg fuer Begegnung und Training" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Oeffnungszeiten und Einblicke</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Montag bis Freitag von 13:00 bis 18:00 Uhr, nur mit Anmeldung. Aktuelle Einblicke in Formate und Atmosphaere findest du punktuell auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Oeffentliche Preise fuer DOGSpace Hamburg werden erst dann dargestellt, wenn sie verifiziert und stabil sind. Bis dahin bleibt die Seite bewusst als Orientierungsseite angelegt, damit du schnell einschaetzen kannst, ob der Raum und die Art der Begleitung zu euch passen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('DOGSpace Hamburg'),
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
                'Workshops in Hamburg ergaenzen das Einzeltraining mit bedarfsorientierten Formaten fuer Mensch-Hund-Teams und passende Themen rund um Alltag, Kommunikation und Lernen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie Workshops in Hamburg bei Beziehungssache Hund gedacht sind</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Workshops in Hamburg sollen bei Beziehungssache Hund keine beliebige Eventliste fuellen, sondern ein klares Thema in einem passenden Rahmen vertiefen. Wenn Formate angeboten werden, stehen Thema, Zielgruppe und Ablauf deutlich im Vordergrund. So entsteht kein Bauchladen, sondern ein Angebot, das fuer Mensch-Hund-Teams nachvollziehbar und hilfreich bleibt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Je nach Thema koennen Workshops in Hamburg im DOGSpace oder an einem anderen geeigneten Ort stattfinden. Die Entscheidung haengt davon ab, ob mehr Beobachtung, mehr Ruhe oder mehr Raum fuer praktische Uebungen gebraucht wird. Wenn du wissen moechtest, ob ein geplanter Workshop zu eurer Situation passt, kannst du vorab ueber die <a href="/kontakt/">Kontaktseite</a> anfragen. Das reduziert Missverstaendnisse und hilft dabei, nur passende Teilnehmer:innen einzuladen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Fuer mich ist wichtig, dass Workshops nicht nur Inhalte liefern, sondern zu einem besseren Verstaendnis zwischen Mensch und Hund beitragen. Darum sind Zielgruppe, Erwartung und praktische Umsetzbarkeit Teil der Beschreibung, nicht bloß ein Randhinweis.</p><!-- /wp:paragraph --><!-- wp:list --><ul class="wp-block-list"><li>klare Themenfokusse statt Bauchladen</li><li>Durchfuehrung im DOGSpace oder an einem passenden Ort</li><li>kommunizierte Zielgruppe und Anforderungen vorab</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/hero-pack-960.webp" alt="Workshops in Hamburg fuer Mensch-Hund-Teams" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Aktuelle Orientierung</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Da Workshops in Hamburg nicht als starres Dauerversprechen kommuniziert werden, gibt es derzeit keinen vollen Veranstaltungskalender. Einblicke in Themen und Haltung findest du gelegentlich auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Wenn du eher eine direkte Begleitung brauchst, ist das <a href="/einzeltraining/">Einzeltraining</a> meist der bessere Einstieg. So bleibt die Seite ehrlich und verwechselt keine Planung mit einem bereits laufenden Programm.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Der Schwerpunkt liegt damit auf Orientierung statt Kalenderflaeche. Das ist fuer Menschen hilfreich, die wissen wollen, ob ein Workshop zu ihrem aktuellen Bedarf passt und welche Formate sinnvoll waeren, bevor Termine ueberhaupt feststehen.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Workshops in Hamburg'),
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
                'Coaching mit Hund in Hamburg ist eine eigenstaendige Angebotslinie, klar getrennt vom klassischen Hundetraining.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Worum es beim Coaching mit Hund in Hamburg geht</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Coaching mit Hund in Hamburg ist kein allgemeines Business-Coaching und kein pauschales Fuehrungskraefteprogramm. Im Mittelpunkt stehen Klarheit, Praesenz und erlebbare Rueckmeldung im passenden Rahmen. Der Hund wird dabei nicht als Dekoration eingesetzt, sondern als Teil eines Settings, das Wahrnehmung, Koerpersprache und Verhalten sichtbar machen kann.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Arbeit ist auf Reflexion und unmittelbare Erfahrung ausgerichtet. Das kann fuer Menschen interessant sein, die mit ihrem Hund nicht nur ein Verhalten beobachten, sondern auch die eigene Wirkung, Haltung und Kommunikation besser verstehen wollen. Weil Coaching mit Hund in Hamburg eine eigene Angebotslinie ist, wird es bewusst vom klassischen Hundetraining getrennt kommuniziert.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du unsicher bist, ob dieses Format oder eher <a href="/einzeltraining/">Einzeltraining</a> fuer dich sinnvoll ist, laesst sich das vorab ueber die <a href="/kontakt/">Kontaktseite</a> klaeren. So wird schnell sichtbar, ob eher praktische Trainingsarbeit oder ein reflektierenderes Setting besser zu eurem Ziel passt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Coaching mit Hund in Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Aktueller Stand</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ein oeffentlicher Preis ist derzeit noch nicht verifiziert. Anfragen werden deshalb individuell geklaert. Wenn du einen persoenlicheren Eindruck von Haltung und Arbeitsweise bekommen moechtest, findest du punktuelle Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Dort gibt es eher einzelne Arbeitsfenster als einen formalen Produktkatalog, was gut zu diesem Angebot passt.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Coaching mit Hund in Hamburg'),
            bsh_seo_faq_section('Coaching mit Hund in Hamburg'),
            bsh_seo_closing_section('Coaching mit Hund in Hamburg'),
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
                'Jacky Rebien in Hamburg steht fuer eine ruhige, klare und alltagstaugliche Begleitung von Mensch-Hund-Teams mit Blick auf Beziehung und Entwicklung.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Jacky Rebien in Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wer Jacky Rebien in Hamburg in die Arbeit mitbringt</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Jacky Rebien in Hamburg arbeitet ruhig, zugewandt und mit einem hohen Anspruch an alltagstaugliche Loesungen. Statt pauschaler Rezepte geht es darum, eure Situation zu verstehen und daraus einen realistischen Weg zu entwickeln. Mir ist wichtig, dass Hundetraining nicht einschuechtert, sondern Orientierung gibt und zu euch als Mensch-Hund-Team passt.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Diese Haltung zeigt sich nicht nur in einzelnen Uebungen, sondern auch in der Art, wie Ziele gesetzt und Erwartungen geklaert werden. Ich arbeite lieber mit klaren Prioritaeten als mit zu vielen gleichzeitigen Anforderungen. Das hilft besonders dann, wenn ein Hund unsicher, angespannt oder sehr reaktiv ist und Menschen schnell den Ueberblick verlieren koennen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du zuerst die Arbeitsweise kennenlernen moechtest, findest du ueber das <a href="/erstgespraech/">Erstgespraech</a> einen guten Einstieg. Zusaetzliche Einblicke in meine Arbeit gibt es punktuell auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. So kannst du dir vorab ein Bild machen, ohne direkt in eine verbindliche Trainingssituation einzusteigen.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Qualifikationen</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Hundetrainerin nach § 11 TierSchG</li><li>Resilienz Coach</li><li>Mensch-Hund-Beraterin</li><li>Mediatorin</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            bsh_seo_support_section('Jacky Rebien in Hamburg'),
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
                'Preise fuer Hundetraining in Hamburg',
                'Preise fuer Hundetraining in Hamburg sollen dir bei Beziehungssache Hund von Anfang an Klarheit geben, ohne versteckte Bedingungen und ohne widerspruechliche Altwerte.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie du die Preise fuer Hundetraining in Hamburg einordnen kannst</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Preise fuer Hundetraining in Hamburg sollen bei Beziehungssache Hund nicht verwirren, sondern dir einen klaren Ueberblick geben. Darum stehen hier nur die Leistungen, die aktuell verifiziert sind. So kannst du besser einschaetzen, ob fuer euch eher ein Einstieg ueber das <a href="/erstgespraech/">Erstgespraech</a>, direktes <a href="/einzeltraining/">Einzeltraining</a> oder eine wiederholte Begleitung mit der 5er-Karte sinnvoll ist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Preisuebersicht ist absichtlich schlank gehalten: Sie soll Orientierung geben, nicht neue Fragen erzeugen. Wenn du zum Beispiel erst einmal klären moechtest, wie ernst euer Thema wirklich ist und welcher Ansatz sinnvoll erscheint, ist das Erstgespraech die passende erste Stufe. Wenn du hingegen schon weisst, dass ihr regelmaessige Begleitung braucht, ist die 5er-Karte oft der bessere Rahmen.</p><!-- /wp:paragraph --><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/logo-full-640.webp" alt="Preise fuer Hundetraining in Hamburg" /></figure><!-- /wp:image --><!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Angebot</th><th>Preis</th><th>Dauer oder Hinweis</th></tr></thead><tbody><tr><td>Erstgespraech</td><td>85 EUR</td><td>60 Minuten</td></tr><tr><td>Einzeltraining</td><td>65 EUR</td><td>45 Minuten</td></tr><tr><td>Einzeltraining</td><td>110 EUR</td><td>90 Minuten</td></tr><tr><td>5er-Karte</td><td>280 EUR</td><td>gueltig fuer 3 Jahre</td></tr></tbody></table></figure><!-- /wp:table --><!-- wp:paragraph --><p>Die 5er-Karte ist vor allem dann sinnvoll, wenn bereits klar ist, dass ihr wiederholte Begleitung braucht. Fuer DOGSpace, Workshops und Coaching mit Hund werden noch keine verifizierten oeffentlichen Preise dargestellt. Wenn du Einblicke in Haltung und Arbeitsweise suchst, findest du punktuell auch etwas auf <a href="https://instagram.com/cazoobi">Instagram</a>. Fuer eine erste Einordnung hilft dir ausserdem das <a href="/erstgespraech/">Erstgespraech</a>.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Preise fuer Hundetraining in Hamburg'),
            bsh_seo_faq_section('Preise fuer Hundetraining in Hamburg'),
            bsh_seo_closing_section('Preise fuer Hundetraining in Hamburg'),
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
                'Kontakt fuer Hundetraining in Hamburg ist bei Beziehungssache Hund direkt per E-Mail, Telefon oder Anfrageformular moeglich.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/portrait-720.webp" alt="Kontakt fuer Hundetraining in Hamburg" /></figure><!-- /wp:image --><!-- wp:list {"className":"bsh-contact-list"} --><ul class="wp-block-list bsh-contact-list"><li>Beziehungssache Hund</li><li>Jacky Rebien</li><li>Bundesstr. 74, 20144 Hamburg</li><li><a href="mailto:info@beziehungssache-hund.de">info@beziehungssache-hund.de</a></li><li><a href="tel:+4915228385291">01522 8385291</a></li><li>Hamburg und Umgebung</li></ul><!-- /wp:list --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","anchor":"erstgespraech-anfragen","className":"bsh-section","layout":{"type":"constrained"}} --><section id="erstgespraech-anfragen" class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wie Kontakt für Hundetraining in Hamburg am einfachsten funktioniert</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Kontakt für Hundetraining in Hamburg soll dir bei Beziehungssache Hund möglichst wenig Hürden machen. Wenn du ein <a href="/erstgespraech/">Erstgespräch</a>, <a href="/einzeltraining/">Einzeltraining</a> oder eine Rückfrage zu DOGSpace, Workshops oder Coaching mit Hund hast, kannst du direkt per E-Mail, Telefon oder Anfrageformular schreiben. Hilfreich ist, wenn du kurz beschreibst, worum es geht und welcher Alltag euch gerade herausfordert.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Ich antworte am liebsten mit einem kurzen, klaren Blick auf deine Situation, damit wir nicht aneinander vorbeireden. Je genauer du dein Thema beschreibst, desto besser kann ich einschätzen, ob ein Erstgespräch, direktes Einzeltraining oder eine andere Form der Begleitung zu euch passt. Auf diese Weise bleibt Kontakt bei Beziehungssache Hund kein unpersönlicher Posteingang, sondern der Startpunkt für eine echte Einordnung.</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Was du anfragen kannst</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Erstgespräch</li><li>Einzeltraining</li><li>DOGSpace</li><li>Workshops oder Seminare</li><li>Coaching mit Hund</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Wenn du vorab einen kleinen Eindruck von Haltung und Stil bekommen möchtest, findest du einzelne Einblicke auch auf <a href="https://instagram.com/cazoobi">Instagram</a>. Für verbindliche Absprachen nutze bitte immer die direkten Kontaktwege auf dieser Seite. So landen deine Fragen nicht in einem allgemeinen Formular-Template, sondern bei den Informationen, die für eine gute Antwort wirklich wichtig sind.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Kontakt fuer Hundetraining in Hamburg'),
            bsh_seo_faq_section('Kontakt fuer Hundetraining in Hamburg'),
            bsh_seo_closing_section('Kontakt fuer Hundetraining in Hamburg'),
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
                'Der Ratgeber fuer Hundetraining in Hamburg buendelt spaeter Fachartikel, Einordnungen und hilfreiche Inhalte fuer Mensch-Hund-Teams.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Wofuer der Ratgeber fuer Hundetraining in Hamburg gedacht ist</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Der Ratgeber fuer Hundetraining in Hamburg ist als Beitragsuebersicht vorgesehen. Hier sollen spaeter Fachartikel, Einordnungen und hilfreiche Inhalte erscheinen, die typische Alltagsthemen fuer Mensch-Hund-Teams verstaendlich aufgreifen. Dazu koennen Themen wie Leinenfuehrigkeit, Alleinbleiben, Grenzen, Orientierung im Alltag oder die Einordnung verschiedener Trainingswege gehoeren. Die Seite ist damit kein theoretischer Lueckenfueller, sondern ein geplanter Ort fuer konkrete, alltagsnahe Inhalte.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Die Seite ist bewusst nicht als fertiges Wissensportal behauptet, solange diese Inhalte noch nicht redaktionell gepflegt sind. Wenn du aktuell eher direkte Unterstuetzung brauchst, ist das <a href="/erstgespraech/">Erstgespraech</a> oder <a href="/einzeltraining/">Einzeltraining</a> sinnvoller. Neue Artikel koennen in WordPress spaeter als Beitraege gepflegt werden. So bleibt die Struktur schon jetzt klar, ohne Inhalte vorzutäuschen, die noch gar nicht veroeffentlicht sind.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} --><figure class="wp-block-image size-full"><img src="/wp-content/themes/beziehungssache-hund/assets/optimized/logo-full-640.webp" alt="Ratgeber Hundetraining Hamburg" /></figure><!-- /wp:image --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Welche Themen hier spaeter Platz finden</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Sobald der Ratgeber befuellt wird, koennen hier Beiträge zu typischen Fragen im Hundetraining erscheinen. Denkbar sind zum Beispiel Texte zu Leinenfuehrigkeit, Alltag mit Hund, Begegnungsstress, Erwartungen an Training oder die Frage, wann ein Erstgespraech sinnvoll ist. Gerade bei Suchanfragen rund um Hundetraining in Hamburg kann so ein inhaltlich sauberes Archiv helfen, statt nur kurze Teaser sichtbar zu machen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Wenn du spaeter auf einen einzelnen Beitrag verlinkst, kann der Ratgeber als stabile Uebersichtsseite dienen. Bis dahin bleibt er bewusst offen und freundlich als Platzhalter angelegt, damit die redaktionelle Entwicklung sauber nachvollziehbar bleibt. Auf diese Weise ist der Ratgeber schon jetzt in die Struktur eingehängt, ohne falsche Versprechen abzugeben.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Ratgeber fuer Hundetraining in Hamburg'),
            bsh_seo_faq_section('Ratgeber fuer Hundetraining in Hamburg'),
            bsh_seo_closing_section('Ratgeber fuer Hundetraining in Hamburg'),
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
                'Das Impressum Beziehungssache Hund ist die verpflichtende Rechtsseite fuer Anbieterangaben und Kontaktinformationen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung bewusst als Platzhalter angelegt, damit die Ziel-URL und Seitenstruktur bereits bestehen.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch muessen hier die rechtlich geprueften Impressumsangaben eingefuegt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Impressum Beziehungssache Hund'),
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
                'Der Datenschutz Beziehungssache Hund beschreibt den Umgang mit personenbezogenen Daten auf dieser Website und bei Anfragen.'
            ),
            '<!-- wp:group {"tagName":"section","className":"bsh-section bsh-section--soft","layout":{"type":"constrained"}} --><section class="wp-block-group bsh-section bsh-section--soft"><!-- wp:paragraph --><p>Diese Seite ist in der lokalen Entwicklungsumgebung als Platzhalter angelegt, damit die Ziel-URL und spaetere Navigation bereits vorhanden sind.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vor einem Launch muessen hier die rechtlich geprueften Datenschutzinhalte, inklusive Formular- und Trackingbezug, eingefuegt werden.</p><!-- /wp:paragraph --></section><!-- /wp:group -->',
            bsh_seo_support_section('Datenschutz Beziehungssache Hund'),
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

echo sprintf("Seiten synchronisiert: %d\n", count($page_ids));
