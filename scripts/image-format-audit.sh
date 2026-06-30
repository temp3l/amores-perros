#!/usr/bin/env bash

set -Eeuo pipefail

theme_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)/wordpress/wp-content/themes/beziehungssache-hund"
tmp_dir="$(mktemp -d)"
trap 'rm -rf "$tmp_dir"' EXIT

html="$tmp_dir/image-audit.html"

cat > "$html" <<EOF
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
      .hero {
        width: 800px;
        height: 300px;
        background-image:
          linear-gradient(180deg, rgba(15, 15, 15, 0.18), rgba(15, 15, 15, 0.9)),
          image-set(
            url("file://${theme_root}/assets/optimized/hero-pack-960.avif") type("image/avif") 1x,
            url("file://${theme_root}/assets/optimized/hero-pack-1600.avif") type("image/avif") 2x,
            url("file://${theme_root}/assets/optimized/hero-pack-960.webp") type("image/webp") 1x,
            url("file://${theme_root}/assets/optimized/hero-pack-1600.webp") type("image/webp") 2x
          );
        background-size: cover;
      }
      img {
        display: block;
      }
    </style>
  </head>
  <body>
    <picture>
      <source
        type="image/avif"
        srcset="file://${theme_root}/assets/optimized/logo-square-96.avif 1x, file://${theme_root}/assets/optimized/logo-square-192.avif 2x"
      />
      <source
        type="image/webp"
        srcset="file://${theme_root}/assets/optimized/logo-square-96.webp 1x, file://${theme_root}/assets/optimized/logo-square-192.webp 2x"
      />
      <img id="headerLogo" src="file://${theme_root}/assets/optimized/logo-square-96.webp" alt="" width="96" height="85" />
    </picture>

    <picture>
      <source
        type="image/avif"
        srcset="file://${theme_root}/assets/optimized/logo-full-320.avif 1x, file://${theme_root}/assets/optimized/logo-full-640.avif 2x"
      />
      <source
        type="image/webp"
        srcset="file://${theme_root}/assets/optimized/logo-full-320.webp 1x, file://${theme_root}/assets/optimized/logo-full-640.webp 2x"
      />
      <img id="footerLogo" src="file://${theme_root}/assets/optimized/logo-full-320.webp" alt="" width="320" height="274" />
    </picture>

    <picture>
      <source
        type="image/avif"
        srcset="file://${theme_root}/assets/optimized/portrait-360.avif 360w, file://${theme_root}/assets/optimized/portrait-720.avif 720w"
        sizes="360px"
      />
      <source
        type="image/webp"
        srcset="file://${theme_root}/assets/optimized/portrait-360.webp 360w, file://${theme_root}/assets/optimized/portrait-720.webp 720w"
        sizes="360px"
      />
      <img id="portrait" src="file://${theme_root}/assets/optimized/portrait-720.webp" alt="" width="720" height="795" />
    </picture>

    <picture>
      <source
        type="image/avif"
        srcset="file://${theme_root}/assets/optimized/hero-pack-960.avif 1x, file://${theme_root}/assets/optimized/hero-pack-1600.avif 2x"
      />
      <source
        type="image/webp"
        srcset="file://${theme_root}/assets/optimized/hero-pack-960.webp 1x, file://${theme_root}/assets/optimized/hero-pack-1600.webp 2x"
      />
      <img id="heroProbe" src="file://${theme_root}/assets/optimized/hero-pack-960.webp" alt="" width="960" height="720" />
    </picture>

    <div class="hero" id="hero"></div>

    <pre id="output"></pre>

    <script>
      window.addEventListener('load', () => {
        setTimeout(() => {
          const resources = performance.getEntriesByType('resource')
            .map((entry) => entry.name)
            .filter((name) =>
              name.includes('hero-pack') ||
              name.includes('logo-square') ||
              name.includes('logo-full') ||
              name.includes('portrait')
            );

          const report = {
            headerCurrentSrc: document.getElementById('headerLogo').currentSrc,
            footerCurrentSrc: document.getElementById('footerLogo').currentSrc,
            portraitCurrentSrc: document.getElementById('portrait').currentSrc,
            heroCurrentSrc: document.getElementById('heroProbe').currentSrc,
            heroBackgroundComputed: getComputedStyle(document.getElementById('hero')).backgroundImage,
            backgroundResources: resources,
          };

          document.getElementById('output').textContent = JSON.stringify(report, null, 2);
        }, 250);
      });
    </script>
  </body>
</html>
EOF

chromium \
  --headless \
  --disable-gpu \
  --no-sandbox \
  --disable-breakpad \
  --disable-crash-reporter \
  --disable-crashpad \
  --allow-file-access-from-files \
  --virtual-time-budget=2000 \
  --dump-dom "file://${html}" \
  | sed -n '/<pre id="output">/,/<\/pre>/p'
