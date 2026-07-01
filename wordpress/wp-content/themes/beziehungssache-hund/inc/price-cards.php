<?php

declare(strict_types=1);

if (! function_exists('bsh_price_card')) {
    /**
     * @param array{
     *     title:string,
     *     price:string,
     *     detail?:string,
     *     description?:string
     * } $card
     */
    function bsh_price_card(array $card): string
    {
        $title = esc_html($card['title'] ?? '');
        $price = esc_html($card['price'] ?? '');
        $detail = esc_html($card['detail'] ?? '');
        $description = esc_html($card['description'] ?? '');
        $parts = [];

        $parts[] = "<!-- wp:column -->";
        $parts[] = '<div class="wp-block-column">';
        $parts[] = '  <!-- wp:group {"className":"bsh-card bsh-price-card","layout":{"type":"constrained"}} -->';
        $parts[] = '  <div class="wp-block-group bsh-card bsh-price-card">';
        $parts[] = '    <!-- wp:group {"className":"bsh-price-card__body","layout":{"type":"constrained"}} -->';
        $parts[] = '    <div class="wp-block-group bsh-price-card__body">';
        $parts[] = '      <!-- wp:heading {"level":3} -->';
        $parts[] = '      <h3 class="wp-block-heading">' . $title . '</h3>';
        $parts[] = '      <!-- /wp:heading -->';
        $parts[] = '      <!-- wp:paragraph {"className":"bsh-price-card__value"} -->';
        $parts[] = '      <p class="bsh-price-card__value">' . $price . '</p>';
        $parts[] = '      <!-- /wp:paragraph -->';

        if ($detail !== '') {
            $parts[] = '      <!-- wp:paragraph -->';
            $parts[] = '      <p>' . $detail . '</p>';
            $parts[] = '      <!-- /wp:paragraph -->';
        }

        if ($description !== '') {
            $parts[] = '      <!-- wp:paragraph -->';
            $parts[] = '      <p>' . $description . '</p>';
            $parts[] = '      <!-- /wp:paragraph -->';
        }

        $parts[] = '    </div>';
        $parts[] = '    <!-- /wp:group -->';
        $parts[] = '  </div>';
        $parts[] = '  <!-- /wp:group -->';
        $parts[] = '</div>';
        $parts[] = '<!-- /wp:column -->';

        return implode("\n", $parts);
    }
}

if (! function_exists('bsh_price_cards_section')) {
    /**
     * @param array<int, array{
     *     title:string,
     *     price:string,
     *     detail?:string,
     *     description?:string
     * }> $cards
     */
    function bsh_price_cards_section(string $heading, array $cards, string $section_class = 'bsh-section'): string
    {
        $cards_markup = implode("\n", array_map('bsh_price_card', $cards));
        $heading = esc_html($heading);
        $section_class = esc_attr($section_class);

        return implode("\n", [
            '<!-- wp:group {"tagName":"section","className":"' . $section_class . '","layout":{"type":"constrained"}} -->',
            '<section class="wp-block-group ' . $section_class . '">',
            '  <!-- wp:heading {"level":2} -->',
            '  <h2 class="wp-block-heading">' . $heading . '</h2>',
            '  <!-- /wp:heading -->',
            '',
            '  <!-- wp:columns {"className":"bsh-card-grid"} -->',
            '  <div class="wp-block-columns bsh-card-grid">',
            $cards_markup,
            '  </div>',
            '  <!-- /wp:columns -->',
            '</section>',
            '<!-- /wp:group -->',
        ]);
    }
}
