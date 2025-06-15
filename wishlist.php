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
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Wishlist</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="perfume.css">
  <style>
    .wishlist-banner {
      background: linear-gradient(90deg, #2daeba 0%, #1a8c98 100%);
      text-align: center;
      height: 90px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0;
      border-radius: 0 0 18px 18px;
      box-shadow: 0 2px 8px rgba(45,175,186,0.07);
    }
    .wishlist-banner h1 {
      color: #fff;
      font-size: 2.2rem;
      font-weight: 700;
      letter-spacing: 2px;
      margin: 0;
      text-shadow: 0 2px 8px rgba(45,175,186,0.13);
    }
    .wishlist-main {
      max-width: 1200px;
      margin: 40px auto 0 auto;
      padding: 0 20px 60px 20px;
      min-height: 70vh;
    }
    .wishlist-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 50vh;
      background: #fafdff;
      border-radius: 18px;
      box-shadow: 0 2px 12px rgba(45,175,186,0.07);
      padding: 60px 20px;
      margin-top: 40px;
    }
    .wishlist-icon svg {
      width: 120px;
      height: 120px;
      stroke: #e0e0e0;
      margin-bottom: 24px;
    }
    .wishlist-title {
      font-size: 1.7rem;
      color: #2daeba;
      font-weight: 700;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }
    .wishlist-message {
      color: #15414e;
      font-size: 1.1rem;
      margin-bottom: 18px;
      text-align: center;
      max-width: 400px;
    }
    .wishlist-button {
      padding: 12px 32px;
      background: #fff;
      color: #2daeba;
      border: 2px solid #2daeba;
      text-decoration: none;
      font-weight: 700;
      border-radius: 24px;
      font-size: 1.08rem;
      letter-spacing: 1px;
      box-shadow: 0 2px 8px rgba(45,175,186,0.08);
      transition: 
        background 0.18s,
        color 0.18s,
        border-color 0.18s,
        transform 0.18s;
      margin-top: 18px;
      display: inline-block;
      position: relative;
      overflow: hidden;
    }
    .wishlist-button::after {
      content: "";
      position: absolute;
      left: 50%;
      top: 50%;
      width: 0;
      height: 0;
      background: rgba(45,174,186,0.08);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.3s, height 0.3s;
      z-index: 0;
    }
    .wishlist-button:hover {
      background: #2daeba;
      color: #fff;
      border-color: #2daeba;
      transform: translateY(-2px) scale(1.04);
    }
    .wishlist-button:hover::after {
      width: 220%;
      height: 220%;
    }
    .wishlist-products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      margin-top: 40px;
    }
    .wishlist-product-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 18px rgba(45,175,186,0.07), 0 1.5px 6px rgba(0,0,0,0.04);
      padding: 18px 10px 22px 10px;
      transition: box-shadow 0.3s, transform 0.3s;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      min-height: 390px;
    }
    .wishlist-product-card:hover {
      box-shadow: 0 8px 32px rgba(45,175,186,0.13), 0 2px 8px rgba(0,0,0,0.08);
      transform: translateY(-8px) scale(1.03);
    }
    .wishlist-product-image-container {
      background: linear-gradient(135deg, #e8f8f9 0%, #f8fafd 100%);
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(45,175,186,0.07);
      margin-bottom: 56px;
      position: relative;
      height: 220px;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
    }
    .wishlist-product-image-container img {
      max-width: 90%;
      max-height: 90%;
      object-fit: contain;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      transition: opacity 0.4s;
    }
    .wishlist-product-info {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: auto;
      margin-bottom: 0;
      padding-bottom: 8px;
    }
    .wishlist-product-brand {
      font-size: 15px;
      color: #2daeba;
      font-weight: 600;
      margin-bottom: 2px;
      letter-spacing: 0.5px;
      margin-top: 40px;
    }
    .wishlist-product-name {
      font-size: 17px;
      color: #222;
      font-weight: 500;
      margin-bottom: 4px;
      letter-spacing: 0.2px;
      margin-top: 7px;
    }
    .wishlist-product-price {
      font-weight: bold;
      font-size: 19px;
      color: #0a2e38;
      margin-bottom: 0;
    }
    .wishlist-remove-icon {
      position: absolute;
      top: 14px;
      right: 14px;
      color: #999;
      cursor: pointer;
      font-size: 1.3rem;
      background: #fff;
      border-radius: 50%;
      padding: 7px;
      transition: color 0.3s, background 0.2s, transform 0.2s;
      z-index: 2;
      border: 1.5px solid #e0e0e0;
    }
    .wishlist-remove-icon:hover {
      color: #c0392b;
      background: #f8eaea;
      transform: scale(1.13);
    }
    @media (max-width: 1100px) {
      .wishlist-products-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 700px) {
      .wishlist-products-grid {
        grid-template-columns: 1fr;
        gap: 18px;
      }
      .wishlist-main {
        padding: 0 4vw 40px 4vw;
      }
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
  <main class="wishlist-main">
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
      <div class="wishlist-products-grid">
        <?php foreach ($products as $product): ?>
          <div class="wishlist-product-card">
            <a href="wishlist.php?action=remove&id=<?= $product['idPerfume'] ?>" class="wishlist-remove-icon" title="Remove from wishlist">
              <i class="fas fa-times"></i>
            </a>
            <a href="product.php?id=<?= $product['idPerfume'] ?>" style="display:block;width:100%;height:100%;">
              <div class="wishlist-product-image-container">
                <img src="perfumes/<?= htmlspecialchars($product['urlImage']) ?>" alt="<?= htmlspecialchars($product['perfumeName']) ?>">
              </div>
              <div class="wishlist-product-info">
                <div class="wishlist-product-brand"><?= htmlspecialchars($product['collectionName']) ?></div>
                <div class="wishlist-product-name"><?= htmlspecialchars($product['perfumeName']) ?></div>
                <div class="wishlist-product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
  <?php include 'include/footer.php'; ?>
</body>
</html>