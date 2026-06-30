(function () {
  var body = document.body;
  var mobileMenuClass = 'bsh-mobile-menu-open';

  if (!body) {
    return;
  }

  var condensedClass = 'bsh-header-condensed';
  var threshold = 24;

  function syncHeaderState() {
    if (window.scrollY > threshold) {
      body.classList.add(condensedClass);
      return;
    }

    body.classList.remove(condensedClass);
  }

  function syncMobileMenuState() {
    var openContainer = document.querySelector(
      '.site-header .wp-block-navigation__responsive-container.is-menu-open'
    );

    body.classList.toggle(mobileMenuClass, Boolean(openContainer));
  }

  syncHeaderState();
  syncMobileMenuState();
  window.addEventListener('scroll', syncHeaderState, { passive: true });

  var observer = new MutationObserver(syncMobileMenuState);
  observer.observe(body, {
    attributes: true,
    childList: true,
    subtree: true,
    attributeFilter: ['class']
  });
})();
