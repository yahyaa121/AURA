<?php
session_start();

$idPerfume = isset($_GET['id']) ? intval($_GET['id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($idPerfume > 0) {
    if (isset($_SESSION['cart'][$idPerfume])) {
        $_SESSION['cart'][$idPerfume] += $quantity;
    } else {
        $_SESSION['cart'][$idPerfume] = $quantity;
    }
}

// Detect AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($isAjax) {
    echo 'success';
    exit;
} else {
    header("Location: accueil.php");
    exit;
}
?>
