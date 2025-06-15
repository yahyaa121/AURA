<?php
require __DIR__ . "/database.php";

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID produit manquant']);
    exit;
}

$productId = $_GET['id'];

try {
    $query = "SELECT p.idPerfume,p.fragranceFamily,p.season, p.perfumeName, p.price, p.description, 
                     c.collectionName, pi.urlImage, pi.urlHover
              FROM perfumes p
              JOIN collections c ON p.idCollection = c.idCollection
              JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
              WHERE p.idPerfume = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Produit non trouvé']);
        exit;
    }
    
    $product = $result->fetch_assoc();
    echo json_encode($product);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur: ' . $e->getMessage()]);
}
?>