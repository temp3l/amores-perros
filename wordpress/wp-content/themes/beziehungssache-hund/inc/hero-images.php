<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit("This file must run inside WordPress.\n");
}

if (! function_exists('bsh_hero_image_style')) {
    function bsh_hero_image_style(string $asset_filename = '', string $position = 'center center'): string
    {
        if ($asset_filename === '') {
            return '';
        }

        $asset_filename = ltrim($asset_filename, '/');
        $hero_image_uri = get_theme_file_uri('assets/hero-images/' . $asset_filename);
        $asset_base = preg_replace('/\.[^.]+$/', '', $asset_filename);
        $hero_avif_uri = get_theme_file_uri('assets/hero-images/' . $asset_base . '.avif');
        $hero_webp_uri = get_theme_file_uri('assets/hero-images/' . $asset_base . '.webp');
        $hero_image_set = sprintf(
            'image-set(url(\'%1$s\') type("image/avif") 1x, url(\'%2$s\') type("image/webp") 1x, url(\'%3$s\') type("image/png") 1x)',
            esc_url($hero_avif_uri),
            esc_url($hero_webp_uri),
            esc_url($hero_image_uri)
        );

        return sprintf(
            ' style="--bsh-hero-image: url(\'%1$s\'); --bsh-hero-image-set: %2$s; --bsh-hero-image-position: %3$s;"',
            esc_url($hero_image_uri),
            esc_attr($hero_image_set),
            esc_attr($position)
        );
    }
}

if (! function_exists('bsh_beziehung_hund_picture')) {
    /**
     * @param string $slug
     * @param string $alt
     * @param bool $eager
     * @return string
     */
    function bsh_beziehung_hund_picture(string $slug, string $alt, bool $eager = false): string
    {
        $base = '/wp-content/themes/beziehungssache-hund/assets/optimized/beziehung-hund/' . ltrim($slug, '/');
        $attributes = [
            'sizeSlug' => 'full',
            'linkDestination' => 'none',
            'className' => 'bsh-image-frame',
        ];

        return sprintf(
            '<!-- wp:image %1$s -->%2$s<figure class="wp-block-image size-full bsh-image-frame"><img src="%3$s" alt="%4$s" /></figure>%2$s<!-- /wp:image -->',
            wp_json_encode($attributes, JSON_UNESCAPED_SLASHES),
            "\n",
            esc_url($base . '-1448.webp'),
            esc_attr($alt)
        );
    }
}

if (! function_exists('bsh_image_slider_section')) {
    /**
     * @param string $title
     * @param string $lead
     * @param array<int, array{slug:string,alt:string,eager?:bool}> $images
     * @param string $section_class
     * @return string
     */
    function bsh_image_slider_section(string $title, string $lead, array $images, string $section_class = 'bsh-section bsh-section--soft'): string
    {
        static $slider_index = 0;

        $slider_index++;
        $slides = [];

        foreach ($images as $image) {
            $slides[] = bsh_beziehung_hund_picture(
                $image['slug'],
                $image['alt'],
                ! empty($image['eager'])
            );
        }

        $slide_markup = implode("\n    ", $slides);

        return <<<HTML
<!-- wp:group {"tagName":"section","className":"{$section_class}","layout":{"type":"constrained"}} -->
<section class="wp-block-group {$section_class}">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">{$title}</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>{$lead}</p>
  <!-- /wp:paragraph -->

  <!-- wp:gallery {"columns":1,"linkTo":"none","className":"bsh-image-slider"} -->
  <figure class="wp-block-gallery has-nested-images columns-1 is-cropped bsh-image-slider">
    {$slide_markup}
  </figure>
  <!-- /wp:gallery -->
</section>
<!-- /wp:group -->
HTML;
    }
}

if (! function_exists('bsh_image_gallery_section')) {
    /**
     * @param string $title
     * @param string $lead
     * @param array<int, array{slug:string,alt:string,eager?:bool}> $images
     * @param string $section_class
     * @return string
     */
    function bsh_image_gallery_section(string $title, string $lead, array $images, string $section_class = 'bsh-section bsh-section--soft'): string
    {
        $pictures = [];

        foreach ($images as $image) {
            $pictures[] = bsh_beziehung_hund_picture(
                $image['slug'],
                $image['alt'],
                ! empty($image['eager'])
            );
        }

        $picture_markup = implode("\n    ", $pictures);

        return <<<HTML
<!-- wp:group {"tagName":"section","className":"{$section_class}","layout":{"type":"constrained"}} -->
<section class="wp-block-group {$section_class}">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">{$title}</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p>{$lead}</p>
  <!-- /wp:paragraph -->

  <!-- wp:gallery {"linkTo":"none","className":"bsh-image-grid"} -->
  <figure class="wp-block-gallery has-nested-images columns-default is-cropped bsh-image-grid">
    {$picture_markup}
  </figure>
  <!-- /wp:gallery -->
</section>
<!-- /wp:group -->
HTML;
    }
}
