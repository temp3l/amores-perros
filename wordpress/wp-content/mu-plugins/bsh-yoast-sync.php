<?php

if (! defined('ABSPATH')) {
    exit("This file must run inside WordPress.\n");
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if (! function_exists('bsh_sync_yoast_seo')) {
    /**
     * Apply canonical Yoast SEO settings for the seeded page structure.
     */
    function bsh_sync_yoast_seo(): void
    {
        if (! is_plugin_active('wordpress-seo/wp-seo.php')) {
            fwrite(STDERR, "Yoast SEO ist nicht aktiv.\n");
            exit(1);
        }

        $title_settings = get_option('wpseo_titles', []);

        if (! is_array($title_settings)) {
            $title_settings = [];
        }

        $title_settings['website_name'] = 'Beziehungssache Hund';
        $title_settings['company_or_person'] = 'person';
        $title_settings['company_name'] = 'Beziehungssache Hund';
        $title_settings['person_name'] = 'Jacky Rebien';
        $title_settings['title-separator'] = 'sc-pipe';

        update_option('wpseo_titles', $title_settings);

        $social_settings = get_option('wpseo_social', []);

        if (! is_array($social_settings)) {
            $social_settings = [];
        }

        $social_settings['instagram_url'] = 'https://instagram.com/cazoobi';

        update_option('wpseo_social', $social_settings);

        $page_metadata = [
            'startseite' => [
                'title' => 'Hundetraining Hamburg | Beziehungssache Hund',
                'description' => 'Hundetraining in Hamburg fuer Mensch-Hund-Teams, die Ruhe, Klarheit und alltagstaugliche naechste Schritte suchen.',
                'focus_keyphrase' => 'Hundetraining Hamburg',
                'cornerstone' => true,
            ],
            'hundetraining-hamburg' => [
                'title' => 'Individuelles Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Individuelles Hundetraining in Hamburg mit klarer Begleitung, passenden Loesungen und Blick auf den Alltag.',
                'focus_keyphrase' => 'individuelles Hundetraining in Hamburg',
                'cornerstone' => true,
            ],
            'erstgespraech' => [
                'title' => 'Erstgespräch Hundetraining Hamburg | Beziehungssache Hund',
                'description' => 'Im Erstgespräch klären wir eure Situation, Ziele und den nächsten sinnvollen Schritt für dich und deinen Hund in Hamburg. 60 Minuten, 85 €.',
                'focus_keyphrase' => 'Erstgespräch Hundetraining Hamburg',
            ],
            'einzeltraining' => [
                'title' => 'Einzeltraining fuer Hund und Mensch in Hamburg | Beziehungssache Hund',
                'description' => 'Einzeltraining in Hamburg fuer Leinenfuehrigkeit, Alleinbleiben und andere konkrete Alltagsthemen.',
                'focus_keyphrase' => 'Einzeltraining in Hamburg',
            ],
            'dogspace-hamburg' => [
                'title' => 'DOGSpace Hamburg | Begleitete Begegnungen und Training',
                'description' => 'DOGSpace Hamburg: begleiteter Raum fuer Begegnung, Austausch und passende Formate.',
                'focus_keyphrase' => 'DOGSpace Hamburg',
            ],
            'workshops-seminare' => [
                'title' => 'Workshops und Seminare fuer Hund und Mensch | Beziehungssache Hund',
                'description' => 'Workshops in Hamburg fuer Hund und Mensch, bedarfsorientiert und mit klarem Rahmen.',
                'focus_keyphrase' => 'Workshops in Hamburg',
            ],
            'coaching-mit-hund' => [
                'title' => 'Coaching mit Hund in Hamburg | Beziehungssache Hund',
                'description' => 'Coaching mit Hund in Hamburg als eigene Linie fuer Klarheit, Praesenz und Reflexion.',
                'focus_keyphrase' => 'Coaching mit Hund in Hamburg',
            ],
            'ueber-jacky-rebien' => [
                'title' => 'Jacky Rebien | Hundetrainerin in Hamburg',
                'description' => 'Jacky Rebien in Hamburg: Haltung, Qualifikationen und Arbeitsweise auf einen Blick.',
                'focus_keyphrase' => 'Jacky Rebien in Hamburg',
            ],
            'preise' => [
                'title' => 'Preise fuer Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Preise fuer Hundetraining in Hamburg: Erstgespraech, Einzeltraining und 5er-Karte.',
                'focus_keyphrase' => 'Preise fuer Hundetraining in Hamburg',
            ],
            'kontakt' => [
                'title' => 'Kontakt fuer Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Kontakt zu Beziehungssache Hund per E-Mail, Telefon oder Formular fuer Anfragen.',
                'focus_keyphrase' => 'Kontakt fuer Hundetraining in Hamburg',
            ],
            'faq' => [
                'title' => 'Häufige Fragen zum Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Antworten zu Leinenfuehrigkeit, Alleinbleiben, Grenzen setzen, angespannten Spaziergängen, aggressivem Verhalten und dem Ablauf des Einzeltrainings.',
                'focus_keyphrase' => 'Häufige Fragen Hundetraining Hamburg',
            ],
            'ratgeber' => [
                'title' => 'Ratgeber Hundetraining Hamburg | Beziehungssache Hund',
                'description' => 'Ratgeber fuer Hundetraining in Hamburg mit Einordnungen, Fachartikeln und Alltagshilfe.',
                'focus_keyphrase' => 'Ratgeber fuer Hundetraining in Hamburg',
            ],
            'impressum' => [
                'title' => 'Impressum | Beziehungssache Hund',
                'description' => 'Impressum von Beziehungssache Hund mit den rechtlich erforderlichen Angaben.',
                'focus_keyphrase' => 'Impressum Beziehungssache Hund',
            ],
            'datenschutz' => [
                'title' => 'Datenschutz | Beziehungssache Hund',
                'description' => 'Datenschutzhinweise von Beziehungssache Hund zu Website, Kommunikation und Formularen.',
                'focus_keyphrase' => 'Datenschutz Beziehungssache Hund',
            ],
        ];

        $updated_pages = 0;

        foreach ($page_metadata as $slug => $metadata) {
            $page = get_page_by_path($slug, OBJECT, 'page');

            if (! $page instanceof WP_Post) {
                continue;
            }

            update_post_meta($page->ID, '_yoast_wpseo_title', $metadata['title']);
            update_post_meta($page->ID, '_yoast_wpseo_metadesc', $metadata['description']);
            update_post_meta($page->ID, '_yoast_wpseo_focuskw', $metadata['focus_keyphrase']);

            if (! empty($metadata['cornerstone'])) {
                update_post_meta($page->ID, '_yoast_wpseo_is_cornerstone', '1');
            } else {
                delete_post_meta($page->ID, '_yoast_wpseo_is_cornerstone');
            }

            $updated_pages++;
        }

        echo sprintf("Yoast SEO Metadaten synchronisiert: %d Seiten\n", $updated_pages);
    }
}
