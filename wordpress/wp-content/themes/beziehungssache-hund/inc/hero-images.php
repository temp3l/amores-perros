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

        $hero_image_uri = get_theme_file_uri('assets/hero-images/' . ltrim($asset_filename, '/'));

        return sprintf(
            ' style="--bsh-hero-image: url(\'%s\'); --bsh-hero-image-position: %s;"',
            esc_url($hero_image_uri),
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
        $loading = $eager ? 'eager' : 'lazy';

        return <<<HTML
<!-- wp:html -->
<figure class="bsh-image-frame">
  <picture>
    <source
      type="image/avif"
      srcset="{$base}-720.avif 720w, {$base}-1448.avif 1448w"
      sizes="(max-width: 781px) calc(100vw - 2rem), 720px"
    />
    <source
      type="image/webp"
      srcset="{$base}-720.webp 720w, {$base}-1448.webp 1448w"
      sizes="(max-width: 781px) calc(100vw - 2rem), 720px"
    />
    <img src="{$base}-1448.webp" alt="{$alt}" loading="{$loading}" decoding="async" width="1448" height="1086" />
  </picture>
</figure>
<!-- /wp:html -->
HTML;
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
        $slider_id = sprintf('bsh-image-slider-%d', $slider_index);
        $slider_label = esc_attr($title);
        $slides = [];

        foreach ($images as $image) {
            $slides[] = sprintf(
                '<li class="bsh-image-slider__slide">%s</li>',
                trim(
                    bsh_beziehung_hund_picture(
                        $image['slug'],
                        $image['alt'],
                        ! empty($image['eager'])
                    )
                )
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

  <!-- wp:html -->
  <div class="bsh-image-slider" data-bsh-slider>
    <div class="bsh-image-slider__viewport">
      <ul class="bsh-image-slider__track" id="{$slider_id}" aria-label="{$slider_label}" tabindex="0">
        {$slide_markup}
      </ul>
    </div>
    <p class="bsh-image-slider__hint">Wische oder nutze die Pfeile.</p>
    <div class="bsh-image-slider__pagination" data-bsh-slider-dots aria-label="{$slider_label} Seiten"></div>
    <div class="bsh-image-slider__controls">
      <button type="button" class="bsh-image-slider__button" data-bsh-slider-prev aria-controls="{$slider_id}">Zurück</button>
      <button type="button" class="bsh-image-slider__button" data-bsh-slider-next aria-controls="{$slider_id}">Weiter</button>
    </div>
  </div>
  <!-- /wp:html -->
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

  <!-- wp:html -->
  <div class="bsh-image-grid">
    {$picture_markup}
  </div>
  <!-- /wp:html -->
</section>
<!-- /wp:group -->
HTML;
    }
}
