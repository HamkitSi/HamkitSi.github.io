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
$target = 'index.html?lang=' . rawurlencode($lang);
header('Location: ' . $target, true, 302);
exit;
