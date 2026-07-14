(function () {
  function activeIndex(track, slides) {
    var index = 0;
    var distance = Number.POSITIVE_INFINITY;

    slides.forEach(function (slide, candidate) {
      var candidateDistance = Math.abs(slide.offsetLeft - track.scrollLeft);
      if (candidateDistance < distance) {
        distance = candidateDistance;
        index = candidate;
      }
    });

    return index;
  }

  function scrollToSlide(track, slides, index) {
    if (!slides[index]) {
      return;
    }

    track.scrollTo({
      left: slides[index].offsetLeft,
      behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
    });
  }

  function initSlider(track, sliderIndex) {
    var slides = Array.prototype.slice.call(track.children).filter(function (child) {
      return child.classList.contains('wp-block-image');
    });

    if (slides.length < 2) {
      return;
    }

    var shell = document.createElement('div');
    var hint = document.createElement('p');
    var pagination = document.createElement('div');
    var controls = document.createElement('div');
    var previous = document.createElement('button');
    var next = document.createElement('button');
    var label = track.closest('section') && track.closest('section').querySelector('h2')
      ? track.closest('section').querySelector('h2').textContent.trim()
      : 'Bildergalerie';

    shell.className = 'bsh-image-slider-shell';
    hint.className = 'bsh-image-slider__hint';
    hint.textContent = 'Wische oder nutze die Pfeile.';
    pagination.className = 'bsh-image-slider__pagination';
    pagination.setAttribute('aria-label', label + ' Seiten');
    controls.className = 'bsh-image-slider__controls';
    previous.className = 'bsh-image-slider__button';
    previous.type = 'button';
    previous.textContent = 'Zurück';
    next.className = 'bsh-image-slider__button';
    next.type = 'button';
    next.textContent = 'Weiter';

    track.id = track.id || 'bsh-image-slider-' + sliderIndex;
    track.tabIndex = 0;
    track.setAttribute('role', 'region');
    track.setAttribute('aria-label', label);
    previous.setAttribute('aria-controls', track.id);
    next.setAttribute('aria-controls', track.id);

    track.parentNode.insertBefore(shell, track);
    shell.appendChild(track);
    shell.appendChild(hint);
    shell.appendChild(pagination);
    controls.appendChild(previous);
    controls.appendChild(next);
    shell.appendChild(controls);

    slides.forEach(function (_slide, index) {
      var dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'bsh-image-slider__dot';
      dot.setAttribute('aria-label', 'Bild ' + (index + 1));
      dot.addEventListener('click', function () {
        scrollToSlide(track, slides, index);
      });
      pagination.appendChild(dot);
    });

    function sync() {
      var index = activeIndex(track, slides);
      var max = track.scrollWidth - track.clientWidth;
      previous.disabled = track.scrollLeft <= 4;
      next.disabled = track.scrollLeft >= max - 4;
      Array.prototype.forEach.call(pagination.children, function (dot, candidate) {
        var current = candidate === index;
        dot.classList.toggle('is-active', current);
        dot.setAttribute('aria-current', current ? 'true' : 'false');
      });
    }

    previous.addEventListener('click', function () {
      scrollToSlide(track, slides, Math.max(0, activeIndex(track, slides) - 1));
    });
    next.addEventListener('click', function () {
      scrollToSlide(track, slides, Math.min(slides.length - 1, activeIndex(track, slides) + 1));
    });
    track.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });
    sync();
  }

  function init() {
    document.querySelectorAll('.wp-block-gallery.bsh-image-slider').forEach(function (track, index) {
      initSlider(track, index + 1);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();
