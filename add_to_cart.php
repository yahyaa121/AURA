<?php
session_start();

$idPerfume = $_GET['id'];
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Créer le panier s’il n’existe pas
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajouter ou incrémenter le produit
if (isset($_SESSION['cart'][$idPerfume])) {
    $_SESSION['cart'][$idPerfume] += $quantity;
} else {
    $_SESSION['cart'][$idPerfume] = $quantity;
}

header("Location: accueil.php");
exit;
?>
