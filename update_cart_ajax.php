<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPerfume'], $_POST['quantity'])) {
    $id = (int)$_POST['idPerfume'];
    $qty = max(1, (int)$_POST['quantity']);

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = $qty;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Produit non trouvé dans le panier.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
exit;
?>