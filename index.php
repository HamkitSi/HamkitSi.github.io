<?php
session_start();
$available = ['fr', 'en', 'ja'];
$default = 'fr';

function normalize_lang($lang, $available) {
    $lang = strtolower(substr(trim((string)$lang), 0, 2));
    return in_array($lang, $available, true) ? $lang : null;
}

$lang = null;
if (isset($_GET['lang'])) {
    $lang = normalize_lang($_GET['lang'], $available);
} elseif (isset($_POST['lang'])) {
    $lang = normalize_lang($_POST['lang'], $available);
} elseif (isset($_SESSION['lang'])) {
    $lang = normalize_lang($_SESSION['lang'], $available);
} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $part) {
        $candidate = normalize_lang(explode(';', $part)[0], $available);
        if ($candidate !== null) { $lang = $candidate; break; }
    }
}
if ($lang === null) { $lang = $default; }
$_SESSION['lang'] = $lang;

$xml = simplexml_load_file(__DIR__ . '/data/contenu.xml');
function t($id) {
    global $xml, $lang;
    $nodes = $xml->xpath('/portfolio/language[@code="' . $lang . '"]/block[@id="' . $id . '"]');
    if ($nodes && isset($nodes[0])) { return htmlspecialchars((string)$nodes[0], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    return htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$map = ['fr'=>'index.php?lang=fr', 'en'=>'index.php?lang=en', 'ja'=>'index.php?lang=ja'];
?><!doctype html>
<html lang="<?= $lang ?>" dir="ltr" itemscope="itemscope" itemtype="https://schema.org/ProfilePage">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= t('description') ?>" />
  <meta name="author" content="Hasina RAKOTOARISON" />
  <title><?= t('title') ?></title>
  <link rel="alternate" href="https://hamkitsi.github.io/index.php?lang=fr" hreflang="fr" />
  <link rel="alternate" href="https://hamkitsi.github.io/index.php?lang=en" hreflang="en" />
  <link rel="alternate" href="https://hamkitsi.github.io/index.php?lang=ja" hreflang="ja" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <a class="skip-link" href="#contenu">Aller au contenu</a>
  <form class="lang-switcher" method="post" action="index.php">
    <button name="lang" value="fr" class="<?= $lang==='fr'?'active':'' ?>" lang="fr">Français</button>
    <button name="lang" value="en" class="<?= $lang==='en'?'active':'' ?>" lang="en">English</button>
    <button name="lang" value="ja" class="<?= $lang==='ja'?'active':'' ?>" lang="ja">日本語</button>
  </form>
  <header id="accueil" class="site-header">
    <section class="hero">
      <div itemscope="itemscope" itemtype="https://schema.org/Person">
        <p class="badge">🌿 <?= t('hero_badge') ?></p>
        <h1 itemprop="name"><?= t('hero_title') ?></h1>
        <p class="lead" itemprop="description"><?= t('hero_text') ?></p>
        <p><a class="button-link" href="#tp1"><?= t('hero_cta') ?></a></p>
        <meta itemprop="givenName" content="Hasina" />
        <meta itemprop="familyName" content="RAKOTOARISON" />
        <meta itemprop="affiliation" content="Université Paris 13 — INFOA2" />
        <link itemprop="url" href="https://hamkitsi.github.io/" />
      </div>
      <div class="hero-card">
        <img src="assets/img/video-poster.svg" alt="Portfolio Web sémantique" style="width:100%;border-radius:1rem" />
      </div>
    </section>
  </header>
  <main id="contenu" class="page-shell">
    <section class="section grid">
      <article class="card"><h2><?= t('identity_title') ?></h2><p><?= t('identity_text') ?></p></article>
      <article class="card"><h2><?= t('rules_title') ?></h2><p><?= t('rules_text') ?></p></article>
    </section>
    <section id="video" class="section video-box">
      <h2><?= t('video_title') ?></h2><p><?= t('video_text') ?></p>
      <div class="youtube-frame">
        <iframe src="https://www.youtube.com/embed/r795n3AffgA" title="<?= htmlspecialchars(t('video_title'), ENT_QUOTES, 'UTF-8') ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen="allowfullscreen"></iframe>
      </div>
    </section>
    <section id="tp1" class="section"><h2><?= t('tp1_title') ?></h2><p class="lead"><?= t('tp1_text') ?></p><p><a class="button-link" href="tp1/bon.xml"><?= t('tp1_link') ?></a></p></section>
    <section id="compagnie" class="section"><h2><?= t('compagnie_title') ?></h2><p class="lead"><?= t('compagnie_text') ?></p><p><a class="button-link" href="tp1/compagnie.html">Compagnie XML</a></p></section>
    <section id="svg" class="section"><h2><?= t('svg_title') ?></h2><p class="lead"><?= t('svg_text') ?></p><p><a class="button-link" href="tp1/svg/mariage-groupe-ws.svg">SVG</a></p></section>
    <section id="xslt" class="section"><h2><?= t('xslt_title') ?></h2><p class="lead"><?= t('xslt_text') ?></p><p><a class="button-link" href="xml-xslt/index.html">TP2</a></p></section>
    <section id="rdf" class="section"><h2><?= t('rdf_title') ?></h2><p class="lead"><?= t('rdf_text') ?></p><p><a class="button-link" href="rdf-corese/glaces.ttl">RDF/Turtle</a></p></section>
    <section id="validation" class="section"><h2><?= t('validation_title') ?></h2><p class="lead"><?= t('validation_text') ?></p></section>
  </main>
  <footer class="site-footer"><p><?= t('footer') ?></p></footer>
</body>
</html>
