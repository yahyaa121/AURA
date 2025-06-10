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
  <style>
    body {
      font-family: 'Inter', 'Segoe UI', 'Roboto', Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f6fa;
      color: #111;
    }

    body,
    input,
    select,
    textarea,
    button,
    .checkout-form,
    .order-summary,
    .order-item,
    .order-item-name,
    .order-item-qty,
    .order-item-price,
    .order-total {
  font-family: 'Inter', 'Segoe UI', 'Roboto', Arial, sans-serif !important;
}

    .container {
      max-width: 1200px;
      margin: 40px auto;
      display: flex;
      gap: 40px;
      padding: 40px 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .checkout-form {
      flex: 2;
      min-width: 320px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(30, 64, 175, 0.07), 0 1.5px 6px rgba(0,0,0,0.03);
      padding: 36px 32px 28px 32px;
      margin-bottom: 30px;
    }

    .checkout-form h2 {
      font-size: 28px;
      margin-bottom: 24px;
      font-weight: 600;
      color: #1a365d;
      letter-spacing: 1px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 7px;
      font-size: 15px;
      color: #333;
      font-weight: 500;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 1.5px solid #dde3ec;
      border-radius: 8px;
      font-size: 15px;
      background: #f7fafd;
      transition: border 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #635bff;
      outline: none;
      background: #fff;
    }

    .payment-buttons {
      display: flex;
      gap: 18px;
      margin-top: 24px;
      justify-content: flex-start;
    }

    .btn-submit {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 56px;
      height: 56px;
      border: none;
      border-radius: 12px;
      font-size: 32px;
      cursor: pointer;
      transition: box-shadow 0.18s, transform 0.18s, background 0.18s, filter 0.18s;
      box-shadow: 0 2px 12px rgba(30,64,175,0.08);
      outline: none;
      padding: 0;
    }

    .stripe-btn {
      background: linear-gradient(90deg, #635bff 60%, #7f53ac 100%);
      color: #fff;
    }

    .stripe-btn:hover, .stripe-btn:focus {
      background: linear-gradient(90deg, #7f53ac 60%, #635bff 100%);
      filter: brightness(1.08) drop-shadow(0 4px 18px #7f53ac33);
      transform: scale(1.15);
      box-shadow: 0 6px 24px rgba(99,91,255,0.18);
    }

    .stripe-btn i {
      color: #fff !important;
      font-size: 38px;
      transition: color 0.2s;
    }

    .paypal-btn {
      background: linear-gradient(90deg, #ffc439 60%, #003087 100%);
      color: #003087;
    }

    .paypal-btn:hover, .paypal-btn:focus {
      background: linear-gradient(90deg, #003087 60%, #ffc439 100%);
      filter: brightness(1.08) drop-shadow(0 4px 18px #00308733);
      transform: scale(1.15);
      box-shadow: 0 6px 24px rgba(0,48,135,0.13);
    }

    .paypal-btn i {
      color: #003087 !important;
      font-size: 38px;
      transition: color 0.2s;
    }

    .paypal-btn:hover i,
    .paypal-btn:focus i {
      color: #fff !important;
    }

    .order-summary {
      flex: 1;
      background: #f8fafc;
      padding: 32px 24px 24px 24px;
      border-radius: 18px;
      min-width: 320px;
      box-shadow: 0 4px 24px rgba(30, 64, 175, 0.07), 0 1.5px 6px rgba(0,0,0,0.03);
      margin-bottom: 30px;
      border: 1.5px solid #e6eaf3;
    }

    .order-summary h3 {
      font-size: 24px;
      margin-bottom: 22px;
      border-bottom: 2px solid #e0e0e0;
      padding-bottom: 12px;
      color: #1a365d;
      font-weight: 700;
      letter-spacing: 1px;
      text-align: center;
    }

    .order-items-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-bottom: 18px;
    }

    .order-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #fff;
      border-radius: 10px;
      padding: 10px 14px;
      box-shadow: 0 1px 6px rgba(30,64,175,0.04);
      transition: box-shadow 0.18s, transform 0.18s;
    }

    .order-item:hover {
      box-shadow: 0 4px 16px rgba(30,64,175,0.10);
      transform: scale(1.015);
    }

    .order-item-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .order-item-img {
      width: 48px;
      height: 48px;
      object-fit: contain;
      border-radius: 8px;
      background: #f7fafd;
      border: 1px solid #e6eaf3;
    }

    .order-item-name {
      font-weight: 500;
      color: #1a365d;
      font-size: 16px;
    }

    .order-item-qty {
      display: inline-block;
      background: #e6eaf3;
      color:rgb(37, 131, 135);
      font-size: 14px;
      font-weight: 600;
      border-radius: 12px;
      padding: 2px 10px;
      margin-left: 8px;
      min-width: 28px;
      text-align: center;
      letter-spacing: 1px;
      box-shadow: 0 1px 3px rgba(99,91,255,0.07);
    }

    .order-item-price {
      font-weight: 600;
      color: #222;
      font-size: 16px;
      min-width: 70px;
      text-align: right;
    }

    .order-total {
      border-top: 2px solid #b6d0e2;
      margin-top: 22px;
      padding-top: 16px;
      font-weight: bold;
      font-size: 20px;
      color: #1a365d;
      text-align: right;
      letter-spacing: 1px;
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        gap: 0;
        padding: 20px 4px;
      }
      .checkout-form, .order-summary {
        margin-bottom: 24px;
        min-width: 0;
      }
    }

    @media (max-width: 600px) {
      .btn-submit {
        width: 42px;
        height: 42px;
        font-size: 20px;
      }
      .stripe-btn i, .paypal-btn i {
        font-size: 24px;
      }
      .checkout-form, .order-summary {
        padding: 16px 6px;
      }
    }
  </style>
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
            $img = !empty($row['urlImage']) ? 'perfume/' . $row['urlImage'] : 'perfume/default.jpg';
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
