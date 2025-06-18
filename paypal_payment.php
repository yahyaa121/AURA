<?php
session_start();
require 'database.php';


$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: checkout.php');
    exit;
}
$grandTotal = 0;
$ids = implode(',', array_map('intval', array_keys($cart)));
if ($ids) {
    $query = "SELECT idPerfume, price FROM perfumes WHERE idPerfume IN ($ids)";
    $result = $mysqli->query($query);
    while ($row = $result->fetch_assoc()) {
        $id = $row['idPerfume'];
        $qty = $cart[$id];
        $price = $row['price'];
        $grandTotal += $price * $qty;
    }
}

// Email sandbox PayPal
$paypal_email = "";

echo '
<form id="paypalForm" action="" method="post">
  <input type="hidden" name="business" value="'.$paypal_email.'">
  <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="item_name" value="Order from My Store">
  <input type="hidden" name="amount" value="'.number_format($grandTotal, 2, '.', '').'">
  <input type="hidden" name="currency_code" value="EUR">
  <input type="hidden" name="return" value="http://localhost/2/successful_payment.php">
  <input type="hidden" name="cancel_return" value="http://localhost/2/checkout.php">
</form>
<script>document.getElementById("paypalForm").submit();</script>
';
exit;
?>