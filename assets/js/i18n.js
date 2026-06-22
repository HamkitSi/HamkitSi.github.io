(function () {
  'use strict';

  var SUPPORTED = ['fr', 'en', 'ja'];
  var DEFAULT_LANG = 'fr';

  function getPageName() {
    return document.documentElement.getAttribute('data-page') || 'index';
  }

  function getLangFromUrl() {
    var params = new URLSearchParams(window.location.search);
    var lang = params.get('lang');
    return SUPPORTED.indexOf(lang) >= 0 ? lang : null;
  }

  function getPreferredLang() {
    var fromUrl = getLangFromUrl();
    if (fromUrl) return fromUrl;
    var saved = localStorage.getItem('portfolio-lang');
    if (SUPPORTED.indexOf(saved) >= 0) return saved;
    var browser = (navigator.language || '').slice(0, 2);
    return SUPPORTED.indexOf(browser) >= 0 ? browser : DEFAULT_LANG;
  }

  function closestSectionHash() {
    if (window.location.hash) return window.location.hash;
    var sections = Array.prototype.slice.call(document.querySelectorAll('section[id], header[id]'));
    var best = null;
    var bestDistance = Infinity;
    sections.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var distance = Math.abs(rect.top);
      if (rect.top <= 160 && distance < bestDistance) {
        best = section;
        bestDistance = distance;
      }
    });
    return best ? '#' + best.id : '';
  }

  function setUrlLang(lang) {
    var url = new URL(window.location.href);
    url.searchParams.set('lang', lang);
    if (!url.hash) url.hash = closestSectionHash();
    history.replaceState(null, '', url.toString());
  }

  function setActiveLang(lang) {
    document.querySelectorAll('[data-set-lang]').forEach(function (button) {
      button.classList.toggle('active', button.getAttribute('data-set-lang') === lang);
    });
  }

  function getDictionary(xml, page) {
    var dict = {};
    var pages = Array.prototype.slice.call(xml.querySelectorAll('page'));
    pages.forEach(function (pageNode) {
      if (pageNode.getAttribute('id') !== page) return;
      Array.prototype.slice.call(pageNode.querySelectorAll('bloc')).forEach(function (bloc) {
        var key = bloc.getAttribute('id');
        dict[key] = {};
        Array.prototype.slice.call(bloc.querySelectorAll('texte')).forEach(function (texte) {
          dict[key][texte.getAttribute('lang')] = texte.textContent;
        });
      });
    });
    return dict;
  }

  function applyDictionary(dict, lang) {
    document.querySelectorAll('[data-i18n]').forEach(function (el) {
      var key = el.getAttribute('data-i18n');
      var value = dict[key] && (dict[key][lang] || dict[key][DEFAULT_LANG]);
      if (value !== undefined) el.textContent = value.trim();
    });

    document.querySelectorAll('[data-i18n-html]').forEach(function (el) {
      var key = el.getAttribute('data-i18n-html');
      var value = dict[key] && (dict[key][lang] || dict[key][DEFAULT_LANG]);
      if (value !== undefined) el.innerHTML = value.trim();
    });

    document.querySelectorAll('[data-i18n-attr]').forEach(function (el) {
      var rules = el.getAttribute('data-i18n-attr').split(';');
      rules.forEach(function (rule) {
        var parts = rule.split(':');
        if (parts.length !== 2) return;
        var attr = parts[0].trim();
        var key = parts[1].trim();
        var value = dict[key] && (dict[key][lang] || dict[key][DEFAULT_LANG]);
        if (value !== undefined) el.setAttribute(attr, value.trim());
      });
    });

    document.documentElement.lang = lang;
    setActiveLang(lang);
    localStorage.setItem('portfolio-lang', lang);
    setUrlLang(lang);
  }

  function wireLanguageButtons(applyFn) {
    document.querySelectorAll('[data-set-lang]').forEach(function (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        var lang = button.getAttribute('data-set-lang');
        applyFn(lang);
      });
    });
  }

  function init() {
    var page = getPageName();
    var lang = getPreferredLang();

    fetch('data/contenu.xml', { cache: 'no-cache' })
      .then(function (response) { return response.text(); })
      .then(function (text) {
        var xml = new DOMParser().parseFromString(text, 'application/xml');
        if (xml.querySelector('parsererror')) throw new Error('XML non valide');
        var dict = getDictionary(xml, page);
        var apply = function (nextLang) { applyDictionary(dict, nextLang); };
        wireLanguageButtons(apply);
        apply(lang);
      })
      .catch(function (error) {
        console.warn('Le contenu XML multilingue n’a pas pu être chargé :', error);
        setActiveLang(lang);
        wireLanguageButtons(function (nextLang) {
          localStorage.setItem('portfolio-lang', nextLang);
          setUrlLang(nextLang);
          location.reload();
        });
      });
  }

  document.addEventListener('DOMContentLoaded', init);
}());
