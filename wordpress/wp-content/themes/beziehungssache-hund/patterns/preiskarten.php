<?php
/**
 * Title: Preiskarten
 * Slug: beziehungssache-hund/preiskarten
 * Categories: beziehungssache-hund
 * Inserter: yes
 */

echo bsh_price_cards_section(
    'Preise im Überblick',
    [
        [
            'title' => 'Erstgespräch',
            'price' => '85 EUR',
            'detail' => '60 Minuten',
            'description' => 'Der Einstieg für neue Mensch-Hund-Teams.',
        ],
        [
            'title' => 'Einzeltraining',
            'price' => 'ab 65 EUR',
            'detail' => '45 oder 90 Minuten sowie 5er-Karte',
            'description' => 'Individuell abgestimmt auf euren Bedarf.',
        ],
    ]
);
