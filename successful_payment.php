<?php
session_start();
require 'database.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['cart'])) {
    $userId = $_SESSION['idUser'];
    $cart = $_SESSION['cart'];
    $orderAddress = $_SESSION['order_address'] ?? '';

    $mysqli->begin_transaction();

    try {
        // Insert into orders table
        $orderDate = date('Y-m-d H:i:s');
        $orderStatus = 'Pending';
        $stmt = $mysqli->prepare("INSERT INTO orders (orderDate, orderStatus, orderAddress, idUser) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $orderDate, $orderStatus, $orderAddress, $userId);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();

        // Insert into details table for each perfume
        foreach ($cart as $perfumeId => $quantity) {
            $stmt = $mysqli->prepare("SELECT price FROM perfumes WHERE idPerfume = ?");
            $stmt->bind_param("i", $perfumeId);
            $stmt->execute();
            $stmt->bind_result($price);
            $stmt->fetch();
            $stmt->close();

            $stmt = $mysqli->prepare("INSERT INTO details (quantity, price, idOrder, idPerfume) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idii", $quantity, $price, $orderId, $perfumeId);
            $stmt->execute();
            $stmt->close();
        }

        $mysqli->commit();
    } catch (Exception $e) {
        $mysqli->rollback();
        // Optionally log the error or show a message
        die("An error occurred while processing your order. Please try again.");
    }
}

unset($_SESSION['cart']);
unset($_SESSION['order_address']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .success-container {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(30, 64, 175, 0.13), 0 2px 8px rgba(0,0,0,0.04);
      padding: 48px 36px 36px 36px;
      max-width: 400px;
      width: 100%;
      text-align: center;
      animation: fadeIn 1s;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px);}
      to { opacity: 1; transform: translateY(0);}
    }
    .success-icon {
      font-size: 60px;
      color: #20c997;
      margin-bottom: 18px;
      display: inline-block;
      animation: pop 0.7s;
    }
    @keyframes pop {
      0% { transform: scale(0.5);}
      70% { transform: scale(1.2);}
      100% { transform: scale(1);}
    }
    .success-title {
      font-size: 2rem;
      font-weight: 600;
      color: #1a365d;
      margin-bottom: 12px;
    }
    .success-message {
      font-size: 1.1rem;
      color: #444;
      margin-bottom: 32px;
    }
    .home-btn {
      display: inline-block;
      padding: 12px 32px;
      background: linear-gradient(90deg, #20c997, #17a2b8);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(30, 64, 175, 0.08);
      transition: background 0.2s, transform 0.2s;
      cursor: pointer;
    }
    .home-btn:hover {
      background: linear-gradient(90deg, #17a2b8, #20c997);
      transform: translateY(-2px) scale(1.04);
    }
  </style>
  <!-- Optionally use FontAwesome for the check icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="success-container">
    <div class="success-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <div class="success-title">Thank You for Your Purchase!</div>
    <div class="success-message">
      Your payment was successful.<br>
      We appreciate your trust and hope you enjoy your new perfume.<br>
      A confirmation email has been sent to you.
    </div>
    <a href="accueil.php" class="home-btn">Home Page</a>
  </div>
 
</body>
</html>
