<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>New Arrivals - Perfume Shop</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: serif;
    }

    body {
      background-color: #fff;
      color: #000;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .header, .footer {
      text-align: center;
      padding: 20px;
    }
    .main-content {
      max-width: 1200px;
      margin: 0 auto 40px;
      padding: 0 20px;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .product {
      position: relative;
      text-align: center;
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .product:hover {
      transform: scale(1.02);
    }

    .product-image-container {
      position: relative;
      width: 100%;
      height: 250px;
    }

    .product img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      background-color: #fff;
      transition: opacity 0.4s ease;
      position: absolute;
      top: 0;
      left: 0;
    }

    .product img.hover-img {
      opacity: 0;
    }

    .product:hover img.hover-img {
      opacity: 1;
    }

    .product:hover img.main-img {
      opacity: 0;
    }

    .product-name {
      margin-top: 10px;
      font-size: 14px;
    }

    .product-brand {
      font-style: italic;
      font-size: 13px;
    }

    .product-price {
      font-weight: bold;
      margin-top: 5px;
    }
    .section-title {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
      gap: 20px;
      margin-top:60px;
    }

    .section-title::before,
    .section-title::after {
      content: "";
      flex: 1;
      height: 1px;
      background-color: #ccc;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <?php include 'include/header.php'; ?>

  <!-- Trait de séparation -->
  <hr class="full-width" />

  <!-- Contenu principal sans filtres -->
  <div class="main-content">
    <div class="section-title">
      <h2 style="font-size: 24px;">New Arrivals</h2>
    </div>

    <div class="products">
      <?php
      // Connexion à la base de données
      $db = new PDO('mysql:host=127.0.0.1:3306;dbname=aura', 'root', ''); // Remplacez par vos identifiants
      
      // Requête pour récupérer les 6 derniers parfums ajoutés
      $query = "SELECT p.*, pi.urlImage, pi.urlHover, c.collectionName 
                FROM perfumes p
                JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
                JOIN collections c ON p.idCollection = c.idCollection
                ORDER BY p.addDate DESC
                LIMIT 6";
      
      $stmt = $db->query($query);
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      foreach($products as $product):
      ?>
      <div class="product">
        <a href="product.php?id=<?= $product['idPerfume'] ?>">
          <div class="product-image-container">
            <img src="perfume/<?= $product['urlImage'] ?>" alt="<?= $product['perfumeName'] ?>" class="main-img" />
            <img src="perfume/<?= $product['urlHover'] ?>" alt="<?= $product['perfumeName'] ?>" class="hover-img" />
          </div>
          <div class="product-name"><?= $product['perfumeName'] ?></div>
          <div class="product-brand"><?= $product['collectionName'] ?></div>
          <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include 'include/footer.php'; ?>

</body>
</html>
