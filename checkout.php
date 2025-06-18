<?php
session_start(); 
if (!isset($_SESSION['idUser'])) {
    header('Location: connexion.php');
    exit;
}else {
   

include 'include/header.php';
require 'database.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$user = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : null;

$query = "SELECT * FROM users WHERE idUser = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    list($firstName, $lastName) = explode(' ', $row['username']);
    $email = $row['email'];
    $address = $row['adresse'];
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout | My Store</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="checkout.css" />
</head>
<body>
  <div class="container">
    <!-- Billing Form -->
    <div class="checkout-form">
      <h2>Billing Information</h2>
      <form action="" method="POST" id="checkoutForm">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($lastName); ?>" disabled>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($firstName); ?>" disabled>
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" id="address" rows="3" required><?php echo htmlspecialchars($address); ?></textarea>
        </div>
        <div class="payment-buttons">
          <button type="submit" class="btn-submit stripe-btn" name="stripe_payment">
            <i class="fa-brands fa-cc-stripe"></i>
          </button>
          <button type="submit" class="btn-submit paypal-btn" name="paypal_payment">
            <i class="fa-brands fa-cc-paypal"></i>
          </button>
        </div>
      </form>
      <script>
        // Change form action depending on which button is clicked
        document.querySelector('.stripe-btn').onclick = function() {
          document.getElementById('checkoutForm').action = 'stripe_session.php';
        };
        document.querySelector('.paypal-btn').onclick = function() {
          document.getElementById('checkoutForm').action = 'paypal_payment.php';
        };
      </script>
    </div>

    <!-- Order Summary -->
     <?php
$cart = $_SESSION['cart'] ?? [];
$grandTotal = 0;

if (!empty($cart)) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $query = "SELECT * FROM perfumes NATURAL JOIN perfumeimage WHERE idPerfume IN ($ids)";
    $result = $mysqli->query($query);
    ?>
    <div class="order-summary">
      <h3>Your Order</h3>
      <div class="order-items-list">
        <?php while ($row = $result->fetch_assoc()):
            $id = $row['idPerfume'];
            $perfume = $row['perfumeName'];
            $quantity = $cart[$id];
            $price = $row['price'];
            $total = $price * $quantity;
            $grandTotal += $total;
            $img = !empty($row['urlImage']) ? 'perfumes/' . $row['urlImage'] : 'perfumes/default.png';
        ?>
        <div class="order-item">
          <div class="order-item-info">
            <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($perfume); ?>" class="order-item-img">
            <span class="order-item-name"><?php echo htmlspecialchars($perfume); ?></span>
            <span class="order-item-qty">x<?php echo $quantity; ?></span>
          </div>
          <span class="order-item-price"><?php echo number_format($total, 2); ?> EURO</span>
        </div>
        <?php endwhile; ?>
      </div>
      <div class="order-total">
        Total: <?php echo number_format($grandTotal, 2); ?> EURO
      </div>
    </div>
    <?php
} else {
    echo '<div class="order-summary"><h3>Your Order</h3><p>Your cart is empty.</p></div>';
}
?>
  </div>
</body>
</html>
<br><br><br><br>
<?php include 'include/footer.php'; ?>
