(function () {
  var ROOT_SELECTOR = '.bsh-faq-page';
  var TOPIC_SELECTOR = '.faq-topic';
  var TARGETS = new Map([
    ['ablauf-einzeltraining', 'ablauf-einzeltraining'],
    ['hundebegegnungen', 'hundebegegnungen'],
    ['angespannte-spaziergaenge', 'angespannte-spaziergaenge'],
    ['leinenfuehrigkeit', 'leinenfuehrigkeit'],
    ['stress-belebte-umgebung', 'stress-belebte-umgebung'],
    ['rueckruf-unter-ablenkung', 'rueckruf-unter-ablenkung'],
    ['unsicherheit-hundehalter', 'unsicherheit-hundehalter'],
    ['trainingsansaetze-ohne-erfolg', 'trainingsansaetze-ohne-erfolg'],
    ['alltagstauglicher-trainingsplan', 'alltagstauglicher-trainingsplan'],
    ['alleinbleiben', 'alleinbleiben'],
    ['grenzen-setzen', 'grenzen-setzen'],
    ['aggressives-verhalten', 'aggressives-verhalten']
  ]);

  var root = null;
  var navLinks = [];
  var header = null;
  var scrollOffset = 0;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  function normalizeHash(hash) {
    return (hash || '').replace(/^#/, '');
  }

  function getTarget(hash) {
    var targetId = TARGETS.get(hash);

    if (!targetId) {
      return null;
    }

    return document.getElementById(targetId);
  }

  function updateScrollOffset() {
    var headerHeight = header ? Math.round(header.getBoundingClientRect().height) : 0;
    var adminBar = document.getElementById('wpadminbar');
    var adminBarHeight = adminBar ? Math.round(adminBar.getBoundingClientRect().height) : 0;

    scrollOffset = headerHeight + adminBarHeight + 24;
    document.documentElement.style.setProperty('--faq-scroll-offset', scrollOffset + 'px');
  }

  function setActiveLink(hash) {
    navLinks.forEach(function (link) {
      var isActive = normalizeHash(link.getAttribute('href')) === hash;
      link.classList.toggle('is-active', isActive);

      if (isActive) {
        link.setAttribute('aria-current', 'location');
      } else {
        link.removeAttribute('aria-current');
      }
    });
  }

  function cancelAnimation(panel) {
    if (panel.__bshFaqTransitionEndHandler) {
      panel.removeEventListener('transitionend', panel.__bshFaqTransitionEndHandler);
      panel.__bshFaqTransitionEndHandler = null;
    }

    if (panel.getAnimations) {
      panel.getAnimations().forEach(function (animation) {
        animation.cancel();
      });
    }

    panel.style.transition = '';
    panel.style.height = '';
    panel.style.overflow = '';
  }

  function openDetails(details, instant) {
    var panel = details.querySelector('.faq-answer');

    if (!panel) {
      details.open = true;
      return;
    }

    cancelAnimation(panel);
    details.open = true;

    if (instant || reducedMotion.matches) {
      panel.style.height = 'auto';
      return;
    }

    panel.style.overflow = 'hidden';
    panel.style.height = '0px';
    panel.getBoundingClientRect();

    requestAnimationFrame(function () {
      panel.style.transition = 'height 280ms ease';
      panel.style.height = panel.scrollHeight + 'px';
    });

    panel.__bshFaqTransitionEndHandler = function onTransitionEnd(event) {
      if (event.propertyName !== 'height') {
        return;
      }

      panel.removeEventListener('transitionend', onTransitionEnd);
      panel.__bshFaqTransitionEndHandler = null;
      panel.style.height = 'auto';
      panel.style.overflow = '';
      panel.style.transition = '';
    };

    panel.addEventListener('transitionend', panel.__bshFaqTransitionEndHandler);
  }

  function closeDetails(details, instant) {
    var panel = details.querySelector('.faq-answer');

    if (!panel) {
      details.open = false;
      return;
    }

    cancelAnimation(panel);

    if (instant || reducedMotion.matches) {
      details.open = false;
      return;
    }

    details.open = true;
    panel.style.overflow = 'hidden';
    panel.style.height = panel.scrollHeight + 'px';
    panel.getBoundingClientRect();

    requestAnimationFrame(function () {
      panel.style.transition = 'height 260ms ease';
      panel.style.height = '0px';
    });

    panel.__bshFaqTransitionEndHandler = function onTransitionEnd(event) {
      if (event.propertyName !== 'height') {
        return;
      }

      panel.removeEventListener('transitionend', onTransitionEnd);
      panel.__bshFaqTransitionEndHandler = null;
      details.open = false;
      panel.style.height = '';
      panel.style.overflow = '';
      panel.style.transition = '';
    };

    panel.addEventListener('transitionend', panel.__bshFaqTransitionEndHandler);
  }

  function scrollAndFocus(target) {
    updateScrollOffset();

    var top = window.scrollY + target.getBoundingClientRect().top - scrollOffset;

    window.scrollTo({
      top: top,
      behavior: 'auto'
    });

    var heading = target.querySelector('h2[tabindex="-1"]');
    var summary = target.querySelector('summary');

    requestAnimationFrame(function () {
      if (heading) {
        heading.focus({ preventScroll: true });
        return;
      }

      if (summary) {
        summary.focus({ preventScroll: true });
      }
    });
  }

  function activateHash(hash) {
    var target = getTarget(hash);

    setActiveLink(hash);

    if (!target) {
      return;
    }

    var firstDetails = target.querySelector('details.faq-item');

    if (firstDetails) {
      openDetails(firstDetails, true);
    }

    scrollAndFocus(target);
  }

  function handleHashChange() {
    var hash = normalizeHash(window.location.hash);

    if (!TARGETS.has(hash)) {
      setActiveLink('');
      return;
    }

    activateHash(hash);
  }

  function handleDocumentClick(event) {
    var link = event.target.closest('a[href^="#"]');

    if (!link || !root || !root.contains(link)) {
      return;
    }

    var hash = normalizeHash(link.getAttribute('href'));

    if (!TARGETS.has(hash)) {
      return;
    }

    event.preventDefault();

    if (normalizeHash(window.location.hash) === hash) {
      activateHash(hash);
      return;
    }

    window.location.hash = hash;
  }

  function handleSummaryClick(event) {
    var summary = event.target.closest('summary');

    if (!summary) {
      return;
    }

    var details = summary.closest('details.faq-item');

    if (!details) {
      return;
    }

    event.preventDefault();

    if (details.open) {
      closeDetails(details, false);
      return;
    }

    openDetails(details, false);
  }

  function init() {
    root = document.querySelector(ROOT_SELECTOR);

    if (!root) {
      return;
    }

    header = document.querySelector('.site-header');
    navLinks = Array.prototype.slice.call(root.querySelectorAll('.faq-topics-nav__link'));

    updateScrollOffset();
    setActiveLink(normalizeHash(window.location.hash));
    handleHashChange();

    root.addEventListener('click', handleDocumentClick);
    root.addEventListener('click', handleSummaryClick);
    window.addEventListener('hashchange', handleHashChange);
    window.addEventListener('resize', updateScrollOffset, { passive: true });

    if (window.ResizeObserver && header) {
      new ResizeObserver(updateScrollOffset).observe(header);
    }

    if (reducedMotion.addEventListener) {
      reducedMotion.addEventListener('change', updateScrollOffset);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
    return;
  }

  init();
})();
