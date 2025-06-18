<?php
header('Content-Type: application/json');
$mysqli = require 'database.php';

$q = $_GET['q'] ?? '';
$q = trim($q);

if(strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$stmt = $mysqli->prepare("SELECT id, name FROM perfumes WHERE name LIKE CONCAT('%', ?, '%') LIMIT 10");
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();

$perfumes = [];
while ($row = $result->fetch_assoc()) {
    $perfumes[] = ['id' => $row['id'], 'name' => $row['name']];
}

echo json_encode($perfumes);
