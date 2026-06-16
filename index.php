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

// Source de données multilingue : data/contenu.xml.
// Lecture volontairement légère : fonctionne même sur un petit serveur PHP sans SimpleXML.
$xmlText = file_get_contents(__DIR__ . '/data/contenu.xml');
function t($id) {
    global $xmlText, $lang;
    $langSafe = preg_quote($lang, '/');
    $idSafe = preg_quote($id, '/');
    $pattern = '/<language\s+code="' . $langSafe . '"\s*>.*?<block\s+id="' . $idSafe . '"\s*>(.*?)<\/block>.*?<\/language>/s';
    if (preg_match($pattern, $xmlText, $m)) {
        return htmlspecialchars_decode(trim($m[1]), ENT_QUOTES);
    }
    return htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?><!doctype html>
<html lang="<?= $lang ?>" dir="ltr" itemscope="itemscope" itemtype="https://schema.org/ProfilePage">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars(t('description'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" />
  <meta name="author" content="Hasina RAKOTOARISON" />
  <title><?= htmlspecialchars(t('title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
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
        <p class="badge">🌿 <?= htmlspecialchars(t('hero_badge'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <h1 itemprop="name"><?= htmlspecialchars(t('hero_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h1>
        <p class="lead" itemprop="description"><?= htmlspecialchars(t('hero_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <p><a class="button-link" href="#tp1"><?= htmlspecialchars(t('hero_cta'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></a></p>
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
      <article class="card"><h2><?= htmlspecialchars(t('identity_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p><?= htmlspecialchars(t('identity_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p></article>
      <article class="card"><h2><?= htmlspecialchars(t('rules_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p><?= htmlspecialchars(t('rules_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p></article>
    </section>
    <section id="video" class="section video-box">
      <h2><?= htmlspecialchars(t('video_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p><?= htmlspecialchars(t('video_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
      <video controls="controls" preload="metadata" poster="assets/img/video-poster.svg">
        <source src="assets/video/intro-<?= $lang ?>.mp4" type="video/mp4" />
        <track kind="subtitles" src="assets/video/captions-<?= $lang ?>.vtt" srclang="<?= $lang ?>" label="<?= $lang ?>" default="default" />
      </video>
    </section>
    <section id="tp1" class="section"><h2><?= htmlspecialchars(t('tp1_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('tp1_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p><p><a class="button-link" href="tp1/bon.xml"><?= htmlspecialchars(t('tp1_link'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></a></p></section>
    <section id="compagnie" class="section"><h2><?= htmlspecialchars(t('compagnie_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('compagnie_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p><p><a class="button-link" href="tp1/compagnie.html">Compagnie XML</a></p></section>
    <section id="svg" class="section"><h2><?= htmlspecialchars(t('svg_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('svg_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p><p><a class="button-link" href="tp1/svg/mariage-groupe-ws.svg">SVG</a></p></section>
    <section id="xslt" class="section"><h2><?= htmlspecialchars(t('xslt_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('xslt_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p><p><a class="button-link" href="xml-xslt/index.html">TP2</a></p></section>
    <section id="rdf" class="section"><h2><?= htmlspecialchars(t('rdf_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('rdf_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p><p><a class="button-link" href="rdf-corese/glaces.ttl">RDF/Turtle</a></p></section>
    <section id="validation" class="section"><h2><?= htmlspecialchars(t('validation_title'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h2><p class="lead"><?= htmlspecialchars(t('validation_text'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p></section>
  </main>
  <footer class="site-footer"><p><?= htmlspecialchars(t('footer'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p></footer>
</body>
</html>
