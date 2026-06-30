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
                'description' => 'Individuelles Hundetraining in Hamburg mit ruhiger, persoenlicher Begleitung, klaren naechsten Schritten und Fokus auf die Mensch-Hund-Beziehung.',
                'focus_keyphrase' => 'Hundetraining Hamburg',
                'cornerstone' => true,
            ],
            'hundetraining-hamburg' => [
                'title' => 'Individuelles Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Individuelles Hundetraining in Hamburg fuer Mensch-Hund-Teams, die alltagstaugliche Loesungen, Klarheit und eine bessere Kommunikation suchen.',
                'focus_keyphrase' => 'individuelles Hundetraining Hamburg',
                'cornerstone' => true,
            ],
            'erstgespraech' => [
                'title' => 'Erstgespraech Hundetraining Hamburg | Beziehungssache Hund',
                'description' => 'Im Erstgespraech klaeren wir eure Situation, euer Ziel und die sinnvollen naechsten Schritte fuer euch und euren Hund.',
                'focus_keyphrase' => 'Erstgespraech Hundetraining Hamburg',
            ],
            'einzeltraining' => [
                'title' => 'Einzeltraining fuer Hund und Mensch in Hamburg | Beziehungssache Hund',
                'description' => 'Massgeschneidertes Einzeltraining fuer Alltag, Leinenfuehrigkeit, Alleinbleiben und mehr.',
                'focus_keyphrase' => 'Einzeltraining Hund Hamburg',
            ],
            'dogspace-hamburg' => [
                'title' => 'DOGSpace Hamburg | Begleitete Begegnungen und Training',
                'description' => 'Geschuetzter Raum fuer begleitete Begegnungen, Workshops und Gemeinschaft mit klaren Regeln.',
                'focus_keyphrase' => 'DOGSpace Hamburg',
            ],
            'workshops-seminare' => [
                'title' => 'Workshops und Seminare fuer Hund und Mensch | Beziehungssache Hund',
                'description' => 'Workshops und Seminare rund um Hundetraining, Beziehung und Alltag in Hamburg.',
                'focus_keyphrase' => 'Workshops Hund Hamburg',
            ],
            'coaching-mit-hund' => [
                'title' => 'Coaching mit Hund in Hamburg | Beziehungssache Hund',
                'description' => 'Coaching mit Hund als eigenstaendige Angebotslinie fuer Klarheit, Praesenz und erlebbare Rueckmeldung im passenden Rahmen.',
                'focus_keyphrase' => 'Coaching mit Hund Hamburg',
            ],
            'ueber-jacky-rebien' => [
                'title' => 'Jacky Rebien | Hundetrainerin in Hamburg',
                'description' => 'Erfahre mehr ueber Jacky Rebien, ihre Haltung, Qualifikationen und ihren Weg im Hundetraining.',
                'focus_keyphrase' => 'Jacky Rebien Hundetrainerin Hamburg',
            ],
            'preise' => [
                'title' => 'Preise fuer Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Uebersicht zu Preisen, Paketen und naechsten Schritten im Hundetraining.',
                'focus_keyphrase' => 'Preise Hundetraining Hamburg',
            ],
            'kontakt' => [
                'title' => 'Kontakt fuer Hundetraining in Hamburg | Beziehungssache Hund',
                'description' => 'Nimm Kontakt auf, wenn du ein Erstgespraech oder ein passendes Angebot fuer euch anfragen moechtest.',
                'focus_keyphrase' => 'Kontakt Hundetraining Hamburg',
            ],
            'ratgeber' => [
                'title' => 'Ratgeber Hundetraining Hamburg | Beziehungssache Hund',
                'description' => 'Fachartikel, Einordnungen und hilfreiche Inhalte rund um Hundetraining, Alltag und die Mensch-Hund-Beziehung in Hamburg.',
                'focus_keyphrase' => 'Ratgeber Hundetraining Hamburg',
            ],
            'impressum' => [
                'title' => 'Impressum | Beziehungssache Hund',
                'description' => 'Impressum von Beziehungssache Hund mit den rechtlich erforderlichen Anbieterangaben.',
                'focus_keyphrase' => 'Impressum Beziehungssache Hund',
            ],
            'datenschutz' => [
                'title' => 'Datenschutz | Beziehungssache Hund',
                'description' => 'Datenschutzhinweise von Beziehungssache Hund zu Website, Kontaktformular und Kommunikation.',
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
