<?php include('include/header.php'); ?>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  main {
    padding: 0 20px;
  }

  /* Hero Carousel */
  .hero-carousel {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
  }

  .hero-carousel img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    position: absolute;
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }

  .hero-carousel img.active {
    opacity: 1;
    z-index: 1;
  }

  .section {
    margin: 40px 0;
    text-align: center;
  }

  h2 {
    font-size: 28px;
    margin-bottom: 20px;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .product-card {
    text-align: center;
    transition: transform 0.3s ease;
    position: relative;
  }

  .product-card:hover {
    transform: translateY(-8px);
  }

  .product-image {
    position: relative;
    width: 100%;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    position: absolute;
    transition: opacity 0.4s ease;
  }

  .img-hover {
    opacity: 0;
  }

  .product-card:hover .img-hover {
    opacity: 1;
  }

  .product-card:hover .img-default {
    opacity: 0;
  }

  .product-card p {
    margin: 8px 0;
    font-size: 16px;
    color: #333;
  }

  .product-card p:nth-of-type(2) {
    font-weight: bold;
    font-size: 18px;
  }

  .product-card p:last-of-type {
    color: black;
    font-weight: bold;
  }

  .quote blockquote {
    font-style: italic;
    font-size: 40px;
    max-width: 800px;
    margin: 0 auto;
  }

  .quote cite {
    display: block;
    margin-top: 12px;
    font-weight: bold;
    font-size: 18px;
  }

  .description {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    align-items: center;
    text-align: left;
  }

  .description-text {
    max-width: 400px;
  }

  .description-text a {
    display: inline-block;
    margin-top: 10px;
    color: #000;
    text-decoration: underline;
  }

  .description-image img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
    padding-right:10px;
    padding-top:30px;
  }

  .categories {
    display: flex;
    justify-content: center;
    gap: 300px;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .category {
    text-align: center;
    max-width: 200px;
  }

  .category.offset {
    margin-top: 100px;
  }

  .category-image {
    width: 600px;
    max-width: 300px;
    height: auto;
    aspect-ratio: 3 / 4;
    object-fit: cover;
    border-radius: 8px;
  }

  .category a {
    display: inline-block;
    margin-top: 10px;
    text-decoration: underline;
    color: #000;
  }

  .product-icons {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    z-index: 2;
  }

  .product-card:hover .product-icons {
    opacity: 1;
    transform: translateX(0);
  }

  .product-icons i {
    background-color: #fff;
    color: #000;
    border: 1px solid #000;
    padding: 8px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    transition: transform 0.2s ease;
  }

  .product-icons i:hover {
    transform: scale(1.1);
  }

  .add-to-cart-btn {
    position: absolute;
    bottom: 0px;
    left: 50%;
    width: 80%;
    transform: translateX(-50%) translateY(20px);
    background-image: linear-gradient(to right, #20c997, #17a2b8);
    color: #fff;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    z-index: 2;
  }

  .product-card:hover .add-to-cart-btn {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }

  .add-to-cart-btn:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background-image: linear-gradient(to right, #1cbfa5, #109ca6);
  }
</style>

<main>

  <!-- Hero Section (Carousel) -->
  <section class="hero">
    <div class="hero-carousel">
      <img src="banners/byerdo3.jpg" class="active" alt="Slide 1">
      <img src="banners/byerdo.jpg" alt="Slide 2">
      <img src="banners/imagin.jpg" alt="Slide 3">
    </div>
  </section>
<!-- Best Sellers Section -->
  <section class="section best-sellers">
    <h2>Best sellers</h2>
    <div class="product-grid">

     <!-- Produit 1 -->

  <div class="product-card">
    <div class="product-image-frame">
      <div class="product-image">
        <img src="2.jpg" alt="Parfum Élégance" class="img-default">
        <img src="hover2.jpg" alt="Parfum Élégance Hover" class="img-hover">

        <div class="product-icons">
          <i class="fas fa-eye" onclick="openQuickView()" title="Quick View"></i>
          <i class="fas fa-heart"></i>
        </div>
        <button class="add-to-cart-btn">Ajouter au panier</button>
      </div>
    </div>
    <p>Parfum Élégance</p>
    <p>Maison Aura</p>
    <p>59.90 €</p>
  </div>


<!-- Produit 2 -->
<a href="product.php" style="text-decoration: none; color: inherit;">
  <div class="product-card">
    <div class="product-image-frame">
      <div class="product-image">
        <img src="6.jpg" alt="Mystic Oud" class="img-default">
        <img src="hover6.jpg" alt="Mystic Oud Hover" class="img-hover">

        <div class="product-icons">
          <i class="fas fa-eye" onclick="openQuickView()" title="Quick View"></i>
          <i class="fas fa-heart"></i>
        </div>
        <button class="add-to-cart-btn">Ajouter au panier</button>
      </div>
    </div>
    <p>Mystic Oud</p>
    <p>Julien Parfums</p>
    <p>72.00 €</p>
  </div>
</a>

<!-- Produit 3 -->
<a href="product.php" style="text-decoration: none; color: inherit;">
  <div class="product-card">
    <div class="product-image-frame">
      <div class="product-image">
        <img src="image/3.jpg" alt="Fleur de Lune" class="img-default">
        <img src="hover3.jpg" alt="Fleur de Lune Hover" class="img-hover">

        <div class="product-icons">
          <i class="fas fa-eye" onclick="openQuickView()" title="Quick View"></i>
          <i class="fas fa-heart"></i>
        </div>
        <button class="add-to-cart-btn">Ajouter au panier</button>
      </div>
    </div>
    <p>Fleur de Lune</p>
    <p>Luxe France</p>
    <p>49.50 €</p>
  </div>
</a>

<!-- Produit 4 -->
<a href="product.php" style="text-decoration: none; color: inherit;">
  <div class="product-card">
    <div class="product-image-frame">
      <div class="product-image">
        <img src="10.jpg" alt="Bois Intense" class="img-default">
        <img src="hover8.jpg" alt="Bois Intense Hover" class="img-hover">

        <div class="product-icons">
          <i class="fas fa-eye" onclick="openQuickView()" title="Quick View"></i>
          <i class="fas fa-heart"></i>
        </div>
        <button class="add-to-cart-btn">Ajouter au panier</button>
      </div>
    </div>
    <p>Bois Intense</p>
    <p>Essence Noble</p>
    <p>65.00 €</p>
  </div>
</a>

    </div>
  </section>

  <!-- Quote Section -->
  <section class="section quote">
    <blockquote>
      <p>« I wanted to build a High Perfumery house where tradition meets the present".»</p>
      <cite>- Julien Sprecher</cite>
    </blockquote>
  </section>

  <!-- Description Section -->
  <section class="section description">
    <div class="description-text">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
      </p>
      <a href="#">Discover</a>
    </div>
    <div class="description-image">
      <img src="33.jpg" alt="Description Image">
    </div>
  </section>

  <!-- Categories Section -->
  <section class="section categories">
    <div class="category">
      <img src="6.jpg" alt="Perfumes for Women" class="category-image">
      <p>Perfumes for Women</p>
      <a href="#">Discover</a>
    </div>
    <div class="category offset">
      <img src="2.jpg" alt="Perfumes for Men" class="category-image">
      <p>Perfumes for Men</p>
      <a href="#">Discover</a>
    </div>
  </section>
 <!-- Quick View Modal -->
<div id="quickViewModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; padding:20px; box-sizing:border-box;">

  <div style="background:#fff; padding:20px; border-radius:12px; max-width:800px; width:100%;
       box-shadow:0 10px 25px rgba(0,0,0,0.2); position:relative; overflow-y:auto; max-height:90vh; display:flex; flex-wrap:wrap; gap:20px;">

    <!-- Close button -->
    <button id="closeQuickView"
      style="position:absolute; top:15px; right:15px; font-size:22px; font-weight:bold;
      border:none; background:none; cursor:pointer; color:#666;">&times;</button>

    <!-- Left: Product Image -->
    <div style="flex:1 1 250px; text-align:center;">
      <img src="10.jpg" alt="Product" style="max-width:100%; border-radius:8px;">
    </div>

    <!-- Right: Product Content -->
    <div class="product-container" style="flex:1 1 400px; font-family:'Helvetica Neue',Arial,sans-serif; color:#333;">
      <h1 class="product-title" style="font-size:24px; font-weight:300; letter-spacing:1px; margin-bottom:5px;">HUNDRED SILENT WAYS</h1>
      <div class="collection" style="font-size:14px; color:#777; margin-bottom:20px;">Collection Rumi</div>
      <div class="price-range" style="font-size:16px; margin-bottom:15px;">100$ – 370$</div>
      <div class="fragrance-notes" style="font-size:14px; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; color:#555;">FLORAL / GOURMAND / MUSKY</div>
      <div class="product-type" style="font-size:14px; margin-bottom:20px; font-weight:300;">Extrait de Parfum</div>

      <div class="size-options" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; font-size:14px;">
        <div class="size-option"><span class="size-label" style="color:#777;">15 ml e 0.5 FLOZ. SPRAY</span></div>
        <div class="size-option"><span class="size-label" style="color:#777;">50 ml e 1.7 FLOZ. SPRAY</span></div>
        <div class="size-option"><span class="size-label" style="color:#777;">100 ml e 3.4 FLOZ. SPRAY</span></div>
      </div>

      <div class="size-selector" style="margin-bottom:20px;">
        <label class="size-label" style="margin-right:10px; color:#777;">Size:</label>
        <select class="size-select" style="padding:8px 12px; border:1px solid #ddd; border-radius:4px; background:#fff; min-width:200px;">
          <option>Choose an option</option>
          <option>15 ml e 0.5 FLOZ. SPRAY</option>
          <option>50 ml e 1.7 FLOZ. SPRAY</option>
          <option>100 ml e 3.4 FLOZ. SPRAY</option>
        </select>
      </div>

      <div class="quantity-selector" style="display:flex; align-items:center; margin-bottom:25px;">
        <button class="quantity-btn" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">-</button>
        <input type="text" class="quantity-input" value="1" style="width:40px; height:28px; text-align:center; border:1px solid #ddd; margin:0 5px;">
        <button class="quantity-btn" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">+</button>
      </div>

      <button class="add-to-cart" style="background:#000; color:#fff; border:none; padding:12px 25px; font-size:14px; text-transform:uppercase; letter-spacing:1px; cursor:pointer;">Add to Cart</button>
    </div>

  </div>
</div>


  <!-- JavaScript pour carrousel -->
  <script>
    const slides = document.querySelectorAll('.hero-carousel img');
    let currentIndex = 0;

    setInterval(() => {
      slides[currentIndex].classList.remove('active');
      currentIndex = (currentIndex + 1) % slides.length;
      slides[currentIndex].classList.add('active');
    }, 3600); // Change d'image toutes les 4 secondes
  </script>

  <!-- JavaScript pour Quick View -->
  <script>
    const modal = document.getElementById('quickViewModal');
    const closeBtn = document.getElementById('closeQuickView');

    function openQuickView() {
      modal.style.display = 'flex';
    }

    function closeQuickView() {
      modal.style.display = 'none';
    }

    closeBtn.addEventListener('click', closeQuickView);

    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        closeQuickView();
      }
    });
  </script>

  <?php include('include/newsletter.php'); ?>
</main>

<?php include('include/footer.php'); ?>
