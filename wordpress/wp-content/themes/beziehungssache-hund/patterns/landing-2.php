<?php
/**
 * Title: Landing 2
 * Slug: beziehungssache-hund/landing-2
 * Categories: beziehungssache-hund
 * Inserter: yes
 */

if (! function_exists('bsh_landing_2_icon')) {
    function bsh_landing_2_icon(string $name): string
    {
        $icons = [
            'paw' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="6.2" cy="8.1" r="1.7" /><circle cx="10" cy="5.8" r="1.5" /><circle cx="14" cy="5.8" r="1.5" /><circle cx="17.8" cy="8.1" r="1.7" /><path d="M7.1 14.2c0-2.6 2.3-4.3 4.9-4.3s4.9 1.7 4.9 4.3c0 1.8-1.5 3-4.9 3s-4.9-1.2-4.9-3Z" /></svg>',
            'heart' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 20.7c-1.1-.7-7.9-4.8-9.6-8.6C.9 8.9 2.8 5.8 6.1 5.8c2 0 3.2 1 4.3 2.4 1.1-1.4 2.3-2.4 4.3-2.4 3.3 0 5.2 3.1 3.7 6.3C19.9 15.9 13.1 20 12 20.7Z" /></svg>',
            'leaf' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4.3 16.4c6.1-.1 11-4.7 14-11 .7 4.8-.6 10.6-4.9 13.1-3.2 1.8-7.5 1.2-9.1-2.1Z" /><path d="M7 15c2.2-1 4.9-3.1 7.3-6.2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" /></svg>',
            'chat' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 6.2h14v9H9l-4 3.4V15H5V6.2Z" /></svg>',
            'target' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="7.2" fill="none" stroke="currentColor" stroke-width="1.6" /><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.6" /><path d="M12 3.8V6.5M20.2 12H17.5M12 20.2v-2.7M3.8 12h2.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'team' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="8" cy="9" r="2.1" /><circle cx="15.7" cy="8.6" r="1.8" /><path d="M4.8 18.2c.4-2.6 2.3-4.1 4.8-4.1s4.4 1.5 4.8 4.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /><path d="M13.3 17.4c.3-2 1.8-3.1 3.5-3.1 1.6 0 3 .9 3.4 2.8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'tree' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5.2c2.7 0 5 2 5 4.7 0 1.7-.8 2.8-1.8 3.4.7.4 1.2 1 1.2 2 0 1.5-1.2 2.7-2.7 2.7H8.3c-1.5 0-2.7-1.2-2.7-2.7 0-1 .5-1.6 1.2-2-.9-.6-1.8-1.7-1.8-3.4 0-2.7 2.3-4.7 5-4.7Z" /><path d="M12 16.2V20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'calendar' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="4.2" y="5.2" width="15.6" height="14.4" rx="2.2" fill="none" stroke="currentColor" stroke-width="1.6" /><path d="M7 3.8v3.1M17 3.8v3.1M4.2 9.2h15.6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" /></svg>',
            'pin' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 21s4.8-5.3 6.4-8.3A6.9 6.9 0 1 0 5.6 12.7C7.2 15.7 12 21 12 21Z" fill="none" stroke="currentColor" stroke-width="1.6" /><circle cx="12" cy="11.5" r="2.2" /></svg>',
            'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="5" y="5" width="14" height="14" rx="4" fill="none" stroke="currentColor" stroke-width="1.6" /><circle cx="12" cy="12" r="3.4" fill="none" stroke="currentColor" stroke-width="1.6" /><circle cx="16.7" cy="7.3" r="0.9" /></svg>',
            'arrow' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4.5 12h15" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.7" /><path d="M13.1 5.7 19.5 12l-6.4 6.3" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" /></svg>',
        ];

        return $icons[$name] ?? '';
    }
}
?>
<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__hero">
  <!-- wp:group {"className":"landing-2__inner","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__inner">
    <div class="landing-2__hero-grid">
      <div class="landing-2__hero-copy">
        <!-- wp:paragraph {"className":"landing-2__eyebrow"} -->
        <p class="landing-2__eyebrow">Hundetraining in Hamburg</p>
        <!-- /wp:paragraph -->

        <!-- wp:heading {"level":1,"className":"landing-2__title"} -->
        <h1 class="wp-block-heading landing-2__title">Klarer Kopf.<br>Starke Beziehung.<br>Ein Team.</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"landing-2__lead"} -->
        <p class="landing-2__lead">Ich begleite Mensch-Hund-Teams in Hamburg mit Einzeltraining, Coachings und Workshops - alltagstauglich, wertschätzend und auf Augenhöhe.</p>
        <!-- /wp:paragraph -->

        <!-- wp:html -->
        <div class="landing-2__actions">
          <a class="landing-2__button landing-2__button--primary" href="/erstgespraech/">
            Erstgespräch anfragen
            <span class="landing-2__button-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('paw'); ?></span>
          </a>
          <a class="landing-2__button landing-2__button--secondary" href="/ueber-jacky-rebien/">
            Mehr über mich
          </a>
        </div>
        <!-- /wp:html -->

        <!-- wp:html -->
        <ul class="landing-2__highlights" aria-label="Kernaussagen">
          <li class="landing-2__highlight">
            <span class="landing-2__highlight-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('heart'); ?></span>
            <span>Beziehung stärken</span>
          </li>
          <li class="landing-2__highlight">
            <span class="landing-2__highlight-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('chat'); ?></span>
            <span>Verhalten verstehen</span>
          </li>
          <li class="landing-2__highlight">
            <span class="landing-2__highlight-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('leaf'); ?></span>
            <span>Alltag meistern</span>
          </li>
        </ul>
        <!-- /wp:html -->
      </div>

      <!-- wp:html -->
      <figure class="landing-2__hero-media">
        <img
          src="<?php echo esc_url(get_theme_file_uri('assets/hero-images/beziehung-hund/beziehung-hund-vertrauen-blickkontakt-hundetraining.webp')); ?>"
          alt="Mensch und Hund in einer ruhigen, vertrauten Alltagssituation"
          width="1448"
          height="1086"
          loading="eager"
          fetchpriority="high"
          decoding="async"
        />
      </figure>
      <!-- /wp:html -->
    </div>
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__process-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__process-section">
  <!-- wp:group {"className":"landing-2__section-shell","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__section-shell">
    <!-- wp:paragraph {"className":"landing-2__section-kicker"} -->
    <p class="landing-2__section-kicker">So arbeite ich</p>
    <!-- /wp:paragraph -->

    <!-- wp:html -->
    <div class="landing-2__process-underline" aria-hidden="true"></div>
    <!-- /wp:html -->

    <!-- wp:html -->
    <div class="landing-2__process-grid">
      <article class="landing-2__process-card">
        <span class="landing-2__process-number">1</span>
        <span class="landing-2__process-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('chat'); ?></span>
        <h3>Verstehen</h3>
        <p>Wir schauen genau hin und besprechen eure Themen beim Erstgespräch.</p>
      </article>
      <span class="landing-2__process-arrow" aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span>
      <article class="landing-2__process-card">
        <span class="landing-2__process-number">2</span>
        <span class="landing-2__process-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('target'); ?></span>
        <h3>Ziele setzen</h3>
        <p>Wir definieren klare Ziele, die zu euch und eurem Alltag passen.</p>
      </article>
      <span class="landing-2__process-arrow" aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span>
      <article class="landing-2__process-card">
        <span class="landing-2__process-number">3</span>
        <span class="landing-2__process-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('team'); ?></span>
        <h3>Individuell trainieren</h3>
        <p>Mit passender Methode, Empathie und Struktur arbeiten wir an Lösungen.</p>
      </article>
      <span class="landing-2__process-arrow" aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span>
      <article class="landing-2__process-card">
        <span class="landing-2__process-number">4</span>
        <span class="landing-2__process-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('heart'); ?></span>
        <h3>Verbindung stärken</h3>
        <p>Für mehr Leichtigkeit, Verständnis und Freude im Miteinander.</p>
      </article>
    </div>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__offers-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__offers-section">
  <!-- wp:group {"className":"landing-2__section-shell","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__section-shell">
    <!-- wp:paragraph {"className":"landing-2__section-title"} -->
    <p class="landing-2__section-title">Meine Angebote</p>
    <!-- /wp:paragraph -->

    <!-- wp:html -->
    <div class="landing-2__offer-grid" role="list" aria-label="Angebote">
      <article class="landing-2__offer-card" role="listitem">
        <span class="landing-2__offer-badge" aria-hidden="true"><?php echo bsh_landing_2_icon('paw'); ?></span>
        <h3>Einzeltraining</h3>
        <p>Individuelles Training für deinen Hund und deinen Alltag.</p>
        <a href="/einzeltraining/">Mehr erfahren <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      </article>
      <article class="landing-2__offer-card" role="listitem">
        <span class="landing-2__offer-badge" aria-hidden="true"><?php echo bsh_landing_2_icon('team'); ?></span>
        <h3>Workshops &amp; Seminare</h3>
        <p>Wissen vertiefen, Fragen klären und gemeinsam wachsen.</p>
        <a href="/workshops-seminare/">Mehr erfahren <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      </article>
      <article class="landing-2__offer-card" role="listitem">
        <span class="landing-2__offer-badge" aria-hidden="true"><?php echo bsh_landing_2_icon('tree'); ?></span>
        <h3>DOGSpace</h3>
        <p>Begleiteter Lern- und Begegnungsraum in Hamburg.</p>
        <a href="/dogspace-hamburg/">Mehr erfahren <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      </article>
      <article class="landing-2__offer-card" role="listitem">
        <span class="landing-2__offer-badge" aria-hidden="true"><?php echo bsh_landing_2_icon('heart'); ?></span>
        <h3>Coaching mit Hund</h3>
        <p>Persönlichkeitsentwicklung für Menschen - mit Hund an deiner Seite.</p>
        <a href="/coaching-mit-hund/">Mehr erfahren <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      </article>
    </div>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__about-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__about-section">
  <!-- wp:group {"className":"landing-2__section-shell landing-2__about-shell","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__section-shell landing-2__about-shell">
    <!-- wp:html -->
    <figure class="landing-2__about-image">
      <img
        src="<?php echo esc_url(get_theme_file_uri('assets/brand/ich-und-waldi.webp')); ?>"
        alt="Jacky Rebien mit Hund auf dem Spaziergang"
        width="2737"
        height="3024"
        loading="lazy"
        decoding="async"
      />
    </figure>
    <!-- /wp:html -->

    <div class="landing-2__about-copy">
      <!-- wp:paragraph {"className":"landing-2__section-title landing-2__section-title--left"} -->
      <p class="landing-2__section-title landing-2__section-title--left">Über mich</p>
      <!-- /wp:paragraph -->

      <!-- wp:heading {"level":2,"className":"landing-2__about-title"} -->
      <h2 class="wp-block-heading landing-2__about-title">Ich bin Jacky Rebien – Hundetrainerin mit Blick für das Mensch-Hund-Team.</h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph -->
      <p>Seit vielen Jahren begleite ich Mensch-Hund-Teams mit Ruhe, Klarheit und ganz viel Herz. Mir ist wichtig, dass ihr Zusammenhänge versteht und im Alltag nicht nur kurzfristig, sondern nachhaltig weiterkommt.</p>
      <!-- /wp:paragraph -->

      <!-- wp:paragraph -->
      <p>Wenn du dir einen klaren, persönlichen Einstieg wünschst, ist das Erstgespräch oft der beste Anfang.</p>
      <!-- /wp:paragraph -->

      <!-- wp:html -->
      <a class="landing-2__text-link" href="/ueber-jacky-rebien/">Mehr über mich <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      <!-- /wp:html -->
    </div>

    <!-- wp:html -->
    <ul class="landing-2__about-points" aria-label="Schwerpunkte">
      <li><span aria-hidden="true"><?php echo bsh_landing_2_icon('heart'); ?></span>Ruhige, klare Begleitung</li>
      <li><span aria-hidden="true"><?php echo bsh_landing_2_icon('leaf'); ?></span>Individuelle Lösungen</li>
      <li><span aria-hidden="true"><?php echo bsh_landing_2_icon('target'); ?></span>Alltagstauglich &amp; realistisch</li>
      <li><span aria-hidden="true"><?php echo bsh_landing_2_icon('pin'); ?></span>In Hamburg und Umgebung</li>
    </ul>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__faq-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__faq-section">
  <!-- wp:group {"className":"landing-2__section-shell landing-2__faq-shell","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__section-shell landing-2__faq-shell">
    <div class="landing-2__faq-copy">
      <!-- wp:paragraph {"className":"landing-2__section-title landing-2__section-title--center"} -->
      <p class="landing-2__section-title landing-2__section-title--center">Häufige Fragen</p>
      <!-- /wp:paragraph -->

      <!-- wp:html -->
      <div class="landing-2__faq-list">
        <details class="landing-2__faq-item">
          <summary>Für wen ist das Training geeignet?</summary>
          <div class="landing-2__faq-answer"><p>Für Mensch-Hund-Teams, die sich eine ruhige, individuelle Begleitung im Alltag wünschen.</p></div>
        </details>
        <details class="landing-2__faq-item">
          <summary>Wie läuft ein Erstgespräch ab?</summary>
          <div class="landing-2__faq-answer"><p>Wir schauen gemeinsam auf eure Situation, klären Ziele und besprechen den passenden nächsten Schritt.</p></div>
        </details>
        <details class="landing-2__faq-item">
          <summary>Wo finden die Trainings statt?</summary>
          <div class="landing-2__faq-answer"><p>Je nach Thema in Hamburg, im Alltag, im Wohnumfeld oder an einem passenden Ort.</p></div>
        </details>
      </div>
      <a class="landing-2__text-link" href="/faq/">Alle Fragen ansehen <span aria-hidden="true"><?php echo bsh_landing_2_icon('arrow'); ?></span></a>
      <!-- /wp:html -->
    </div>

    <!-- wp:html -->
    <figure class="landing-2__faq-dog">
      <img
        src="<?php echo esc_url(get_theme_file_uri('assets/brand/dog-mark-open.png')); ?>"
        alt=""
        width="1100"
        height="1042"
        loading="lazy"
        decoding="async"
      />
    </figure>
    <!-- /wp:html -->

    <aside class="landing-2__cta-card" aria-label="Kontaktaufruf">
      <!-- wp:paragraph {"className":"landing-2__cta-kicker"} -->
      <p class="landing-2__cta-kicker">Bereit für euren nächsten Schritt?</p>
      <!-- /wp:paragraph -->

      <!-- wp:paragraph -->
      <p>Ich freue mich darauf, euch kennenzulernen und gemeinsam passende Lösungen zu finden.</p>
      <!-- /wp:paragraph -->

      <!-- wp:html -->
      <a class="landing-2__button landing-2__button--primary" href="/erstgespraech/">
        Erstgespräch anfragen
        <span class="landing-2__button-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('paw'); ?></span>
      </a>
      <p class="landing-2__cta-note">Oder direkt schreiben</p>
      <a class="landing-2__button landing-2__button--whatsapp" href="https://wa.me/4915228385291" target="_blank" rel="noreferrer noopener">WhatsApp schreiben</a>
      <!-- /wp:html -->
    </aside>
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"landing-2 landing-2__info-strip-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull landing-2 landing-2__info-strip-section">
  <!-- wp:group {"className":"landing-2__info-strip","layout":{"type":"constrained"}} -->
  <div class="wp-block-group landing-2__info-strip">
    <div class="landing-2__info-item">
      <span class="landing-2__info-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('calendar'); ?></span>
      <p>Montag bis Freitag von 13:00 bis 18:00 Uhr nur mit Anmeldung.</p>
    </div>
    <div class="landing-2__info-item">
      <span class="landing-2__info-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('pin'); ?></span>
      <p>In Hamburg und Umgebung.</p>
    </div>
    <div class="landing-2__info-item">
      <span class="landing-2__info-icon" aria-hidden="true"><?php echo bsh_landing_2_icon('instagram'); ?></span>
      <p>Einblicke und News auf <a href="https://instagram.com/cazoobi" target="_blank" rel="noreferrer noopener">Instagram</a></p>
    </div>
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
