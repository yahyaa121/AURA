<?php
session_start();
require 'database.php';

// Initialiser la wishlist en session
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Ajouter/supprimer des produits
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'add' && !in_array($id, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $id;
    } elseif ($_GET['action'] === 'remove') {
        $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], fn($pid) => $pid != $id);
    }
    // Si AJAX, ne pas rediriger
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Location: wishlist.php');
        exit;
    }
    exit;
}

// Récupération des produits
$products = [];
if (!empty($_SESSION['wishlist'])) {
    $ids = implode(',', array_map('intval', $_SESSION['wishlist']));
    $query = "SELECT p.idPerfume, p.perfumeName, p.price, c.collectionName, pi.urlImage, pi.urlHover
              FROM perfumes p
              JOIN collections c ON p.idCollection = c.idCollection
              JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
              WHERE p.idPerfume IN ($ids)";
    $result = $mysqli->query($query);
    if ($result) $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Wishlist</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      color: #222;
    }

    main {
      padding: 40px;
      min-height: 70vh;
      max-width: 1200px;
      margin: 0 auto;
    }

    .wishlist-banner {
      background-color: #0a2e38;
      text-align: center;
      height: 80px;
    }

    .wishlist-banner h1 {
      color: white;
      padding-top: 20px;
      font-size: 30px;
      font-weight: 600;
      margin: 0;
      letter-spacing: 2px;
    }

    .wishlist-container {
      text-align: center;
      padding: 50px;
    }

    .wishlist-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 50vh;
    }

    .wishlist-icon svg {
      width: 150px;
      height: 150px;
      stroke: #e0e0e0;
      margin-bottom: 30px;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
      margin-bottom: 30px;
    }

    .product-item {
      display: flex;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding-bottom: 20px;
      position: relative;
    }

    .product-image {
      width: 150px;
      margin-right: 30px;
    }

    .product-image img {
      width: 100%;
      height: auto;
    }

    .product-info {
      flex: 1;
      text-align: left;
    }

    .product-name {
      font-size: 1.2rem;
      margin: 0 0 10px 0;
      color: #333;
    }

    .product-collection {
      color: #666;
      margin-bottom: 5px;
    }

    .product-price {
      font-weight: bold;
      font-size: 1.1rem;
      color: #0a2e38;
    }

    .remove-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      color: #999;
      cursor: pointer;
      font-size: 1.2rem;
      transition: color 0.3s;
    }

    .remove-icon:hover {
      color: #c0392b;
    }

    .wishlist-button {
      padding: 12px 24px;
      background-color: #0a2e38;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      border-radius: 4px;
      transition: background-color 0.3s ease;
      display: inline-block;
      margin-top: 20px;
    }
    
    .wishlist-button:hover {
      background-color: #0f1d14;
    }
  </style>
</head>
<body>
  <?php
  include "include/init.php";
   include 'include/header.php'; ?>
  <div class="wishlist-banner">
    <h1>WISHLIST</h1>
  </div>

  <main>
    <?php if (empty($products)): ?>
      <div class="wishlist-empty">
        <div class="wishlist-icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 
                     5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 
                     1.06-1.06a5.5 5.5 0 000-7.78z"/>
          </svg>
        </div>
       <h1 class="wishlist-title"><?= $lang['wishlist_empty_title'] ?></h1>
<p class="wishlist-message">
  <?= nl2br($lang['wishlist_empty_message']) ?>
</p>
<a href="perfume.php" class="wishlist-button"><?= $lang['wishlist_return_shop'] ?></a>

      </div>
    <?php else: ?>
      <div class="products-grid">
        <?php foreach ($products as $product): ?>
          <div class="product-item">
            <a href="product.php?id=<?= $product['idPerfume'] ?>" style="display:flex;align-items:center;text-decoration:none;color:inherit;">
              <div class="product-image">
                <img src="perfumes/<?= htmlspecialchars($product['urlImage']) ?>" alt="<?= htmlspecialchars($product['perfumeName']) ?>">
              </div>
              <div class="product-info">
                <h3 class="product-name"><?= htmlspecialchars($product['perfumeName']) ?></h3>
                <p class="product-collection"><?= htmlspecialchars($product['collectionName']) ?></p>
                <p class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
              </div>
            </a>
            <a href="wishlist.php?action=remove&id=<?= $product['idPerfume'] ?>" class="remove-icon" title="Remove from wishlist">
              <i class="fas fa-times"></i>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <?php include 'include/footer.php'; ?>
</body>
</html>