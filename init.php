<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$langue = $_SESSION['lang'] ?? 'fr';

$lang_file = "lang/$langue.php";
if (file_exists($lang_file)) {
    include $lang_file;
} else {
    include "lang/fr.php";
}
