<?php
/**
 * Title: Kitesplash
 * Slug: beziehungssache-hund/kitesplash
 * Categories: beziehungssache-hund
 * Inserter: yes
 */

if (! function_exists('bsh_kitesplash_icon')) {
    function bsh_kitesplash_icon(string $name): string
    {
        $icons = [
            'users' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="8" cy="9" r="2.1" /><circle cx="15.8" cy="8.6" r="1.8" /><path d="M4.8 18.1c.4-2.6 2.3-4.1 4.8-4.1s4.4 1.5 4.8 4.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /><path d="M13.5 17.3c.3-1.9 1.8-3 3.5-3 1.7 0 3 .9 3.4 2.8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'kite' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="m12 3.5 4.2 4.3L12 12.1 7.8 7.8 12 3.5Z" /><path d="M12 12.1 8.2 19" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /><path d="M12 12.1 15.8 19" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /><path d="M12 12.1l-4.5 2.2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /><path d="M12 12.1l4.5 2.2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'clock' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="7.8" fill="none" stroke="currentColor" stroke-width="1.6" /><path d="M12 7.8V12l2.8 1.6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" /></svg>',
            'paddle' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M16.9 3.8c.7-.7 1.9-.7 2.6 0 .7.7.7 1.9 0 2.6l-8.8 8.8-3.9.9.9-3.9 8.8-8.8Z" /><path d="M5.2 18.8 8 16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'box' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="5" y="6.5" width="14" height="11" rx="1.8" fill="none" stroke="currentColor" stroke-width="1.6" /><path d="M8 6.5v-1.9h8v1.9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'cart' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 6.5h2l1.2 8.1h8.7l1.7-5.8H8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" /><circle cx="10.1" cy="18.4" r="1.2" /><circle cx="16.2" cy="18.4" r="1.2" /></svg>',
            'star' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="m12 4 2.1 4.4 4.9.7-3.5 3.4.8 4.9-4.3-2.3-4.3 2.3.8-4.9-3.5-3.4 4.9-.7L12 4Z" /></svg>',
            'bubble' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 6.5h14v8.2H9.1L5 18V6.5Z" /></svg>',
            'globe' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="7.6" fill="none" stroke="currentColor" stroke-width="1.6" /><path d="M4.8 12h14.4M12 4.4c2 2.1 3 4.8 3 7.6s-1 5.5-3 7.6c-2-2.1-3-4.8-3-7.6s1-5.5 3-7.6Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.4" /></svg>',
            'phone' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7.6 4.8 6.1 6.3c-.7.7-.8 1.8-.3 2.7 1.5 2.6 3.6 4.7 6.2 6.2.9.5 2 .4 2.7-.3l1.5-1.5 2.7 2.7-1.8 1.8c-1 1-2.5 1.3-3.8.7-3.2-1.4-6.4-4.7-7.8-7.8-.6-1.3-.3-2.8.7-3.8l1.8-1.8 2.7 2.7Z" /></svg>',
            'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 4.2c4.3 0 7.8 3.2 7.8 7.2S16.3 18.6 12 18.6c-.9 0-1.7-.1-2.5-.4L5.4 19l1.1-3.2c-.8-1.1-1.2-2.3-1.2-3.8 0-4 3.4-7.8 7.7-7.8Zm-3.2 4.7c-.2 0-.4.1-.6.2-.3.2-.7.7-.7 1.4 0 .8.5 1.6 1.1 2.4.8 1.1 2 2.1 3.5 2.7.6.2 1.1.3 1.5.3.5 0 1.1-.2 1.4-.5.4-.3.5-.8.3-1.2l-.5-1.1c-.1-.3-.4-.5-.7-.4l-1 .2c-.2 0-.4 0-.6-.1-.9-.4-1.6-1-2.1-1.9-.1-.2-.1-.5 0-.7l.5-.8c.1-.2.1-.5 0-.7L9.6 9c-.2-.1-.5-.1-.8-.1Z" /></svg>',
            'location' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 21s4.8-5.2 6.4-8.2A6.9 6.9 0 1 0 5.6 12.8C7.2 15.8 12 21 12 21Z" fill="none" stroke="currentColor" stroke-width="1.6" /><circle cx="12" cy="11.6" r="2.1" /></svg>',
        ];

        return $icons[$name] ?? '';
    }
}
?>
<!-- wp:group {"tagName":"section","align":"full","className":"kitesplash-page","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull kitesplash-page" id="start">
  <div class="kitesplash-page__inner">
    <!-- wp:html -->
    <header class="kitesplash-page__header">
      <a class="kitesplash-page__brand" href="https://www.kitesplash.com" aria-label="Kitesplash Startseite">
        <img
          src="<?php echo esc_url(get_theme_file_uri('assets/kitesplash/logo.png')); ?>"
          alt="Kitesplash"
          width="320"
          height="90"
          loading="eager"
          fetchpriority="high"
          decoding="async"
        />
      </a>

      <nav class="kitesplash-page__nav" aria-label="Website">
        <a href="#start">Schule</a>
        <a href="#preise">Preise</a>
        <a href="#preise">Galerie</a>
        <a href="#kontakt">Bewertungen</a>
        <a href="#kontakt">Kontakt</a>
        <a href="#kontakt">Impressum</a>
        <a href="#preise">FAQ</a>
        <a href="#preise">Kurse</a>
        <a href="#preise">Angebote</a>
        <a href="#kontakt">Gutscheine</a>
        <a href="#kontakt">Mehr</a>
      </nav>
    </header>

    <div class="kitesplash-page__hero">
      <div class="kitesplash-page__hero-copy">
        <h1 class="kitesplash-page__title">KITESURFEN<br>LERNEN AUF<br><span>FEHMARN.</span></h1>

        <p class="kitesplash-page__lead">Station auf dem Strandcamping Wallnau Platz K141 und<br>mobil an jedem Spot auf Fehmarn! <strong>Meldet euch jetzt gern bei uns an!</strong></p>
      </div>

      <figure class="kitesplash-page__hero-media" aria-label="Kitesurfen auf Fehmarn">
        <img
          src="<?php echo esc_url(get_theme_file_uri('assets/kitesplash/hero.png')); ?>"
          alt="Kitesurfen lernen auf Fehmarn"
          width="900"
          height="470"
          loading="eager"
          fetchpriority="high"
          decoding="async"
        />
      </figure>
    </div>

    <section class="kitesplash-page__prices" id="preise" aria-label="Leistungen und Preise">
      <div class="kitesplash-page__price-grid">
        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(31, 77, 134, 0.10); --kitesplash-badge-color: #1f4d86;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('users'); ?></span>
          <h2 class="kitesplash-page__price-name">Kiteschnupperkurs</h2>
          <div class="kitesplash-page__price-figure">129 €</div>
          <p class="kitesplash-page__price-note">1–2 Personen</p>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(42, 156, 170, 0.12); --kitesplash-badge-color: #2a9cab;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('kite'); ?></span>
          <h2 class="kitesplash-page__price-name">Kiteanfängerkurs</h2>
          <div class="kitesplash-page__price-figure">299 €</div>
          <p class="kitesplash-page__price-note">p.P. inkl. Material</p>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(244, 179, 40, 0.14); --kitesplash-badge-color: #f4b328;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('clock'); ?></span>
          <h2 class="kitesplash-page__price-name">Privatstunde</h2>
          <div class="kitesplash-page__price-figure">95 €</div>
          <p class="kitesplash-page__price-note">inkl. Material</p>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(42, 156, 170, 0.12); --kitesplash-badge-color: #2a9cab;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('kite'); ?></span>
          <h2 class="kitesplash-page__price-name">Betreutes Kiten</h2>
          <div class="kitesplash-page__price-figure kitesplash-page__price-figure--inline"><span>ab</span> 33 € <small>/ h</small></div>
          <p class="kitesplash-page__price-note">inkl. Material</p>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(31, 77, 134, 0.10); --kitesplash-badge-color: #1f4d86;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('box'); ?></span>
          <h2 class="kitesplash-page__price-name">Materialverleih</h2>
          <div class="kitesplash-page__price-figure">90 €</div>
          <p class="kitesplash-page__price-note">komplett für 3 Stunden</p>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(42, 156, 170, 0.12); --kitesplash-badge-color: #2a9cab;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('paddle'); ?></span>
          <h2 class="kitesplash-page__price-name">SUP &amp; Kurse</h2>
          <div class="kitesplash-page__price-list">
            <p><strong>SUP 10 € / h</strong></p>
            <p>SUP Anfängerkurs <strong>30 € p.P.</strong></p>
          </div>
        </article>

        <article class="kitesplash-page__price-card" style="--kitesplash-badge-bg: rgba(244, 179, 40, 0.14); --kitesplash-badge-color: #f4b328;">
          <span class="kitesplash-page__price-badge" aria-hidden="true"><?php echo bsh_kitesplash_icon('cart'); ?></span>
          <h2 class="kitesplash-page__price-name">Materialverkauf</h2>
          <p class="kitesplash-page__price-note kitesplash-page__price-note--stacked">und</p>
          <div class="kitesplash-page__price-script">-testing</div>
        </article>
      </div>
    </section>

    <section class="kitesplash-page__info-panel" id="kontakt" aria-label="Kontakt und Hinweise">
      <div class="kitesplash-page__info-strip">
        <div class="kitesplash-page__info-item">
          <span class="kitesplash-page__info-icon" aria-hidden="true"><?php echo bsh_kitesplash_icon('star'); ?></span>
          <p>Lerne Kiten und verbessere Deine Kiteskills auf Fehmarn, dem Top Kiterevier an der Ostsee in der Nähe von Hamburg, Heiligenhafen und Lübeck.</p>
        </div>
        <div class="kitesplash-page__info-item">
          <span class="kitesplash-page__info-icon" aria-hidden="true"><?php echo bsh_kitesplash_icon('bubble'); ?></span>
          <p>Anfragen kannst Du gerne per Telefon oder Whatsapp an Sören und Team <strong>01744043579</strong> stellen.</p>
        </div>
        <div class="kitesplash-page__info-item">
          <span class="kitesplash-page__info-icon" aria-hidden="true"><?php echo bsh_kitesplash_icon('globe'); ?></span>
          <p><strong>We also speak English.</strong> Hablamos español tambien.</p>
        </div>
      </div>
    </section>

    <footer class="kitesplash-page__cta">
      <div class="kitesplash-page__buttons">
        <a class="kitesplash-page__button kitesplash-page__button--primary" href="tel:+491744043579">
          <span class="kitesplash-page__button-icon" aria-hidden="true"><?php echo bsh_kitesplash_icon('phone'); ?></span>
          Jetzt Anrufen
        </a>
        <a class="kitesplash-page__button kitesplash-page__button--secondary" href="https://api.whatsapp.com/send?phone=+491744043579&amp;text=Hallo%20ich%20m%C3%B6chte%20gerne%20Informationen%20zum%20Kiten/SUP.%20Danke." target="_blank" rel="noreferrer noopener">
          <span class="kitesplash-page__button-icon" aria-hidden="true"><?php echo bsh_kitesplash_icon('whatsapp'); ?></span>
          Whatsapp Anfrage senden
        </a>
      </div>

      <div class="kitesplash-page__tagline">
        <span class="kitesplash-page__tagline-line">Kitesplash - das Original -</span>
        <strong>Kiten fast wie in der Karibik 😀</strong>
      </div>

      <img
        class="kitesplash-page__footer-art"
        src="<?php echo esc_url(get_theme_file_uri('assets/kitesplash/footer.png')); ?>"
        alt=""
        width="320"
        height="100"
        loading="lazy"
        decoding="async"
        aria-hidden="true"
      />
    </footer>
  </div>
</section>
<!-- /wp:group -->
