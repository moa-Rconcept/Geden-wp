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

$(function () {
  $('.pubs-acc').on('click', '.pubs-year__toggle', function () {
    var $year = $(this).closest('.pubs-year');
    var $panel = $year.find('.pubs-year__panel');

    var $others = $year.siblings('.pubs-year.is-open');
    $others.removeClass('is-open')
      .find('.pubs-year__toggle').attr('aria-expanded', 'false').end()
      .find('.pubs-year__panel').stop(true, true).slideUp(180);

    var isOpen = $year.hasClass('is-open');
    $year.toggleClass('is-open', !isOpen);
    $(this).attr('aria-expanded', String(!isOpen));
    $panel.stop(true, true).slideToggle(180);
  });

  $('.pubs-year').each(function () {
    var $p = $(this).find('.pubs-year__panel');
    if ($p.is(':visible')) {
      $(this).addClass('is-open')
        .find('.pubs-year__toggle').attr('aria-expanded', 'true');
    }
  });
});
