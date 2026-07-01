(function () {
  var hero = document.querySelector('.bsh-landing-hero');
  var media = hero ? hero.querySelector('[data-bsh-parallax-media]') : null;
  var reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  var ticking = false;

  if (!hero || !media) {
    return;
  }

  function sync() {
    ticking = false;

    if (reducedMotionQuery.matches) {
      media.style.removeProperty('--bsh-parallax-shift');
      return;
    }

    var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    var rect = hero.getBoundingClientRect();

    if (rect.bottom <= 0 || rect.top >= viewportHeight) {
      return;
    }

    var travel = viewportHeight + rect.height;
    var progress = (viewportHeight - rect.top) / travel;
    var shift = (progress - 0.5) * -60;

    media.style.setProperty('--bsh-parallax-shift', shift.toFixed(2) + 'px');
  }

  function requestSync() {
    if (ticking) {
      return;
    }

    ticking = true;
    window.requestAnimationFrame(sync);
  }

  sync();
  window.addEventListener('scroll', requestSync, { passive: true });
  window.addEventListener('resize', requestSync);

  if (typeof reducedMotionQuery.addEventListener === 'function') {
    reducedMotionQuery.addEventListener('change', requestSync);
  }
})();
