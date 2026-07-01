(function () {
  var liveSelector = '.forminator-ui.forminator-custom-form input.forminator-input, .forminator-ui.forminator-custom-form textarea.forminator-textarea, .forminator-ui.forminator-custom-form select.forminator-select2';
  var timers = new WeakMap();

  function validateField(field) {
    if (!field || typeof field !== 'object') {
      return;
    }

    if (field.classList && field.classList.contains('select2-search__field')) {
      return;
    }

    if (window.jQuery) {
      window.jQuery(field).trigger('focusout');
      return;
    }

    field.dispatchEvent(new Event('change', { bubbles: true }));
  }

  function scheduleValidation(field) {
    var timer = timers.get(field);

    if (timer) {
      window.clearTimeout(timer);
    }

    timer = window.setTimeout(function () {
      validateField(field);
      timers.delete(field);
    }, 140);

    timers.set(field, timer);
  }

  document.addEventListener(
    'input',
    function (event) {
      var target = event.target;

      if (!target || !target.matches(liveSelector)) {
        return;
      }

      scheduleValidation(target);
    },
    true
  );

  document.addEventListener(
    'change',
    function (event) {
      var target = event.target;

      if (!target || !target.matches('.forminator-ui.forminator-custom-form select.forminator-select2')) {
        return;
      }

      validateField(target);
    },
    true
  );
})();
