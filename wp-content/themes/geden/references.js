// Scripts spécifiques à la page Références
(function () {
  function sortCardsIn(sectionId) {
    const $section = $('#' + sectionId);
    if (!$section.length) return;

    const $cards = $section.find('.ref-card');

    const getYearKey = (cardEl) => {
      const text = $(cardEl).find('.ref-year').first().text() || '';
      const matches = text.match(/\d{4}/g);
      if (!matches) return -Infinity;
      return Math.max.apply(null, matches.map(Number));
    };

    const sorted = $cards
      .get()
      .map((el) => ({ el, key: getYearKey(el) }))
      .sort((a, b) => b.key - a.key)
      .map((o) => o.el);

    $section.append(sorted);
  }

  sortCardsIn('passees');
  sortCardsIn('encours');
})();

jQuery(function ($) {
  $('.pubs-acc')
    .off('click.pubsAcc')
    .on('click.pubsAcc', '.pubs-year__toggle', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var $toggle = $(this);
      var $year = $toggle.closest('.pubs-year');
      var $panel = $year.children('.pubs-year__panel');

      var isOpen = $year.hasClass('is-open');

      $year.siblings('.pubs-year.is-open')
        .removeClass('is-open')
        .children('.pubs-year__panel')
        .stop(true, true)
        .slideUp(180)
        .end()
        .find('.pubs-year__toggle')
        .attr('aria-expanded', 'false');

      $year.toggleClass('is-open', !isOpen);
      $toggle.attr('aria-expanded', String(!isOpen));

      $panel.stop(true, true);
    });
});