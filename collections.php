<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfume Shop</title>
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

    .category-bar {
      text-align: center;
      margin: 40px 0 20px;
      font-size: 18px;
    }

    .category-bar a {
      margin: 0 15px;
      font-weight: bold;
      color: #000;
      border-bottom: 2px solid transparent;
      padding-bottom: 4px;
    }

    .category-bar a:hover {
      border-bottom: 2px solid #000;
    }

    hr.full-width {
      width: 100%;
      border: none;
      border-top: 1px solid #ccc;
      margin: 0 auto 40px;
    }

    .container {
      display: flex;
      max-width: 1200px;
      margin: 0 auto 40px;
      gap: 40px;
      padding: 0 20px;
    }

    .filters {
      width: 250px;
      padding-right: 20px;
      border-right: 1px solid #ddd;
      background-color: #fafafa;
      padding-top: 10px;
      padding-bottom: 30px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .filters h2 {
      font-size: 22px;
      margin-bottom: 25px;
      font-weight: 600;
      color: #2c3e50;
      border-bottom: 2px solid #e0e0e0;
      padding-bottom: 10px;
      margin-right: 10px;
    }

    .filter-group {
      margin-bottom: 25px;
    }

    .filter-group h3 {
      font-size: 15px;
      font-weight: 600;
      color: #444;
      margin-bottom: 12px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .filter-group select {
      width: 100%;
      padding: 10px 12px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #fff;
      cursor: pointer;
      transition: border-color 0.2s ease;
    }

    .filter-group select:focus {
      border-color: #2c3e50;
      outline: none;
    }

    .filter-group label {
      display: flex;
      align-items: center;
      font-size: 14px;
      margin-bottom: 10px;
      color: #333;
      cursor: pointer;
      transition: color 0.2s ease;
      padding-left: 2px;
    }

    .filter-group label:hover {
      color: #000;
    }

    .filter-group input[type="checkbox"] {
      margin-right: 8px;
      accent-color: rgb(45, 175, 186);
      transform: scale(1.1);
    }

    .main-content {
      flex: 1;
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

    .header, .footer {
      text-align: center;
      padding: 20px;
    }

    .filter-btn {
      background-color:rgb(45, 175, 186);
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      width: 100%;
      margin-top: 20px;
      font-size: 16px;
      text-align: center;
    }

    .filter-btn:hover {
      background-color:rgb(33, 110, 136);
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <?php include 'include/header.php'; ?>

  <!-- Barre des catégories -->
  <div class="category-bar">
   <?php if(isset($_POST['designer'])) { ?>
    <a href="#"><?= $_POST['designer']  ?></a> <?php } ?>
  </div>

  <!-- Trait de séparation pleine largeur -->
  <hr class="full-width" />

  <!-- Contenu principal -->
  <div class="container">
    <!-- Filtres -->
    <div class="filters">
      <h2>Filter</h2>

      <form method="GET" action="filtered_results.php">
        <div class="filter-group">
          <h3>Price</h3>
          <select name="price_order">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>
        </div>

        <div class="filter-group">
          <h3>Olfactory notes</h3>
          <label><input type="checkbox" name="note[]" value="floral"> Floral</label>
          <label><input type="checkbox" name="note[]" value="woody"> Woody</label>
          <label><input type="checkbox" name="note[]" value="citrus"> Citrus</label>
          <label><input type="checkbox" name="note[]" value="spicy"> Spicy</label>
          <label><input type="checkbox" name="note[]" value="Amber"> Amber</label>
          <label><input type="checkbox" name="note[]" value="Leather"> Leather</label>
        </div>

        <div class="filter-group">
          <h3>Season</h3>
          <label><input type="checkbox" name="season[]" value="all"> All</label>
          <label><input type="checkbox" name="season[]" value="spring"> Spring</label>
          <label><input type="checkbox" name="season[]" value="summer"> Summer</label>
          <label><input type="checkbox" name="season[]" value="autumn"> Autumn</label>
          <label><input type="checkbox" name="season[]" value="winter"> Winter</label>
        </div>

        <button type="submit" class="filter-btn">Apply Filters</button>
      </form>
    </div>

    <!-- Produits -->
    <div class="main-content">
      <div class="products">
        <?php for($i = 0; $i < 6; $i++): ?>
        <div class="product">
          <div class="product-image-container">
            <img src="6.jpg" alt="Product Image" class="main-img" />
            <img src="hover6.jpg" alt="Hover Image" class="hover-img" />
          </div>
          <div class="product-name">Name of perfume</div>
          <div class="product-brand">Brand Name</div>
          <div class="product-price">$99.99</div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include 'include/footer.php'; ?>

</body>
</html>
