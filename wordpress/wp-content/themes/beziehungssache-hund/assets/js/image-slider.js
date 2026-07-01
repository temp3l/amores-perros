(function () {
  function getSlides(track) {
    return Array.from(track.querySelectorAll('.bsh-image-slider__slide'));
  }

  function getActiveIndex(track, slides) {
    const scrollLeft = track.scrollLeft;

    if (!slides.length) {
      return 0;
    }

    let activeIndex = 0;
    let smallestDistance = Number.POSITIVE_INFINITY;

    slides.forEach((slide, index) => {
      const distance = Math.abs(slide.offsetLeft - scrollLeft);

      if (distance < smallestDistance) {
        smallestDistance = distance;
        activeIndex = index;
      }
    });

    return activeIndex;
  }

  function scrollToIndex(track, slides, index) {
    const slide = slides[index];

    if (!slide) {
      return;
    }

    track.scrollTo({
      left: slide.offsetLeft,
      behavior: 'smooth',
    });
  }

  function updateControls(track, prevButton, nextButton, controls, dots, hint, slides) {
    const maxScrollLeft = track.scrollWidth - track.clientWidth;
    const isScrollable = maxScrollLeft > 4 && slides.length > 1;
    const activeIndex = getActiveIndex(track, slides);

    controls.hidden = ! isScrollable;
    dots.hidden = ! isScrollable;
    hint.hidden = ! isScrollable;

    prevButton.disabled = ! isScrollable || track.scrollLeft <= 4;
    nextButton.disabled = ! isScrollable || track.scrollLeft >= maxScrollLeft - 4;

    controls.querySelectorAll('[data-bsh-slider-dot]').forEach(function (button) {
      const index = Number.parseInt(button.getAttribute('data-bsh-slider-dot') || '0', 10);
      const isActive = index === activeIndex;
      button.setAttribute('aria-current', isActive ? 'true' : 'false');
      button.classList.toggle('is-active', isActive);
    });
  }

  function initSlider(slider) {
    const track = slider.querySelector('.bsh-image-slider__track');
    const prevButton = slider.querySelector('[data-bsh-slider-prev]');
    const nextButton = slider.querySelector('[data-bsh-slider-next]');
    const controls = slider.querySelector('.bsh-image-slider__controls');
    const dots = slider.querySelector('[data-bsh-slider-dots]');
    const hint = slider.querySelector('.bsh-image-slider__hint');
    const slides = getSlides(track);

    if (! track || ! prevButton || ! nextButton || ! controls || ! dots) {
      return;
    }

    dots.innerHTML = '';

    slides.forEach(function (_slide, index) {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'bsh-image-slider__dot';
      dot.setAttribute('data-bsh-slider-dot', String(index));
      dot.setAttribute('aria-label', 'Bild ' + (index + 1));
      dot.addEventListener('click', function () {
        scrollToIndex(track, slides, index);
      });
      dots.appendChild(dot);
    });

    const sync = () => updateControls(track, prevButton, nextButton, controls, dots, hint, slides);

    prevButton.addEventListener('click', function () {
      scrollToIndex(track, slides, Math.max(0, getActiveIndex(track, slides) - 1));
    });

    nextButton.addEventListener('click', function () {
      scrollToIndex(track, slides, Math.min(slides.length - 1, getActiveIndex(track, slides) + 1));
    });

    track.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });
    sync();
  }

  function init() {
    document.querySelectorAll('[data-bsh-slider]').forEach(initSlider);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();
