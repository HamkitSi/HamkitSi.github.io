// Maintient l'ancre (#section) quand on change de langue.
document.querySelectorAll('[data-lang-link]').forEach(function (link) {
  link.addEventListener('click', function () {
    var hash = window.location.hash || '';
    if (hash && !link.href.includes('#')) {
      link.href = link.href + hash;
    }
  });
});
