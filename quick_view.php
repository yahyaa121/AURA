<?php
require __DIR__ . "/database.php";

if (!isset($_GET['id'])) {
    echo json_encode(null);
    exit;
}

$id = (int) $_GET['id'];
$query = "SELECT p.perfumeName AS name, p.price, c.collectionName AS collection,
                 p.notes, p.type, pi.urlImage AS image
          FROM perfumes p
          JOIN collections c ON p.idCollection = c.idCollection
          JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
          WHERE p.idPerfume = $id
          LIMIT 1";

$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(null);
}
?>
