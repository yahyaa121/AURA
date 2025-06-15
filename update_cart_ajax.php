<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPerfume'], $_POST['quantity'])) {
    $id = (int)$_POST['idPerfume'];
    $qty = min(5, max(1, (int)$_POST['quantity'])); // Limit quantity between 1 and 5

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