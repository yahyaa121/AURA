<?php
session_start();
require 'vendor/autoload.php'; // Path to Stripe's autoload.php
require 'database.php';

\Stripe\Stripe::setApiKey(''); // Replace with your actual Stripe secret key

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}
// put the user address in the session 
$_SESSION['order_address'] = $_POST['address'] ?? '';
// Fetch product info from DB
$ids = implode(',', array_map('intval', array_keys($cart)));
$query = "SELECT * FROM perfumes WHERE idPerfume IN ($ids)";
$result = $mysqli->query($query);

$line_items = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['idPerfume'];
    $quantity = $cart[$id];
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $row['perfumeName'],
            ],
            'unit_amount' => intval($row['price'] * 100), // Stripe expects amount in cents
        ],
        'quantity' => $quantity,
    ];
}

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'http://localhost/PFE/successful_payment.php',
    'cancel_url' => 'http://localhost/PFE/checkout.php',
]);

header("Location: " . $session->url);
exit;
?>