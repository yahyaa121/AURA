<?php 
include "include/init.php";
include('include/header.php'); ?>

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
    padding-right:200px;
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
    padding-left: 186px;
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
    background-color: #0a2e38;
    color: #fff;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    z-index: 2;
}

.product-card:hover .add-to-cart-btn {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.add-to-cart-btn:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background-color: #15414e; /* Paler version of #0a2e38 */
}
.section-title {
  display: flex;
  align-items: center;
  text-align: center;
  font-size: 24px;
  margin: 40px 0;
  position: relative;
  justify-content: center;
}

.section-title::before,
.section-title::after {
  content: "";
  flex: 1;
  height: 1px;
  background: #ccc; /* ou une autre couleur */
  margin: 0 20px;
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
  <h2 class="section-title"><?= $lang['best_sellers'] ?></h2>


    <div class="product-grid">

    <?php
require __DIR__ . "/database.php";

// Vérification de la connexion
if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    die("Erreur : La connexion à la base de données a échoué");
}

try {
     $query = "SELECT p.idPerfume, p.perfumeName, p.price, c.collectionName, pi.urlImage, pi.urlHover
              FROM perfumes p
              JOIN collections c ON p.idCollection = c.idCollection
              JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
              ORDER BY RAND() LIMIT 4"; 
    
    $result = $mysqli->query($query);
    
    if (!$result) {
        die("Erreur de requête : " . $mysqli->error);
    }
    
    $products = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
?>

<!-- Affichage des produits -->
<div class="product-grid">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <div class="product-image-frame">
            <div class="product-image">
              <a href="product.php?id=<?= $product['idPerfume'] ?>">

                <img src="perfumes/<?= htmlspecialchars($product['urlImage']) ?>" 
                     alt="<?= htmlspecialchars($product['perfumeName']) ?>" 
                     class="img-default">
                <img src="perfumes/<?= htmlspecialchars($product['urlHover']) ?>" 
                     alt="<?= htmlspecialchars($product['perfumeName']) ?> Hover" 
                     class="img-hover"></a>

                <div class="product-icons">
                  <i class="fas fa-eye" onclick="openQuickView(<?= $product['idPerfume'] ?>)" title="Quick View"></i>
                    
            <?php
$isInWishlist = in_array($product['idPerfume'], $_SESSION['wishlist'] ?? []);
?>
<a href="#" class="add-to-wishlist" data-id="<?= $product['idPerfume'] ?>" title="Ajouter à la wishlist">
  <i class="<?= $isInWishlist ? 'fas' : 'far' ?> fa-heart wishlist-heart" style="<?= $isInWishlist ? 'color:#c0392b;' : '' ?>"></i>
</a>
                </div>
                <button class="add-to-cart-btn" 
                        onclick="addToCart(<?= $product['idPerfume'] ?>)">
                    <?= $lang['add_to_cart'] ?>
                </button>
            </div>
        </div>
        <p><?= htmlspecialchars($product['collectionName']) ?></p>
        <p><?= htmlspecialchars($product['perfumeName']) ?></p>
        <p><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
    </div>
    <?php endforeach; ?>
</div>


    </div>
  </section>
<div id="quickViewModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; padding:20px; box-sizing:border-box;">
</div>
  <!-- Quote Section -->
  <section class="section quote">
    <blockquote>
      <p><?=$lang["quote_text"]?></p>
      <cite>- Julien Sprecher</cite>
    </blockquote>
  </section>

  <!-- Description Section -->
  <section class="section description">
    <div class="description-text">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
      </p>
      <a href="#"> <?= $lang['add_to_cart'] ?></a>
    </div>
    <div class="description-image">
      <img src="perfumes/17-17.jpg" alt="Description Image">
    </div>
  </section>

  <!-- Categories Section -->
  <section class="section categories">
    <div class="category">
      <img src="perfumes/2.png" alt="Perfumes for Women" class="category-image">
      <p> <?= $lang['perfumes_women'] ?></p>
      <a href="#"> <?= $lang['discover'] ?></a>
    </div>
    <div class="category offset">
      <img src="perfumes/14.jpg" alt="Perfumes for Men" class="category-image">
      <p> <?= $lang['perfumes_men'] ?></p>
      <a href="#"> <?= $lang['discover'] ?></a>
    </div>
  </section>
 


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

 <script>
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    
    // Afficher un indicateur de chargement
    modal.innerHTML = '<div style="color:white; font-size:20px;">Chargement...</div>';
    modal.style.display = 'flex';
    
    fetch('get_product_details.php?id=' + productId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(product => {
            // Formatage du prix pour la plage (ajoutez 100€ au prix de base pour l'exemple)
            const basePrice = parseFloat(product.price);
            const priceRange = `${basePrice}€ – ${basePrice + 100}€`;
            
            // Remplir le modal avec le template exact
            modal.innerHTML = `
                <div style="background:#fff; padding:20px; border-radius:12px; max-width:800px; width:100%;
                     box-shadow:0 10px 25px rgba(0,0,0,0.2); position:relative; overflow-y:auto; max-height:90vh; display:flex; flex-wrap:wrap; gap:20px;">
                    
                    <button id="closeQuickView"
                      style="position:absolute; top:15px; right:15px; font-size:22px; font-weight:bold;
                      border:none; background:none; cursor:pointer; color:#666;">&times;</button>

                    <div style="flex:1 1 250px; text-align:center;">
                        <img src="perfumes/${product.urlImage}" alt="${product.perfumeName}" style="max-width:100%; border-radius:8px;">
                    </div>

                    <div class="product-container" style="flex:1 1 400px; font-family:'Helvetica Neue',Arial,sans-serif; color:#333;">
                        <h1 class="product-title" style="font-size:24px; font-weight:300; letter-spacing:1px; margin-bottom:5px;">${product.perfumeName}</h1>
                        <div class="collection" style="font-size:14px; color:#777; margin-bottom:20px;">Collection ${product.collectionName}</div>
                        <div class="price-range" style="font-size:16px; margin-bottom:15px;">${priceRange}</div>
                        <div class="fragrance-notes" style="font-size:14px; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; color:#555;">
                            ${product.fragranceFamily }
                        </div>
                        <div class="product-type" style="font-size:14px; margin-bottom:20px; font-weight:300;">Extrait de Parfum</div>

                        <div class="size-options" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; font-size:14px;">
                           
                            <div class="size-option"><span class="size-label" style="color:#777;">  ${product.season}</span></div>
                           
                        </div>

                        <div class="size-selector" style="margin-bottom:20px;">
                           
                                50 ml e 1.7 FLOZ. SPRAY
                              
                        </div>

                        <div class="quantity-selector" style="display:flex; align-items:center; margin-bottom:25px;">
                            <button class="quantity-btn minus" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">-</button>
                            <input type="text" class="quantity-input" value="1" style="width:40px; height:28px; text-align:center; border:1px solid #ddd; margin:0 5px;">
                            <button class="quantity-btn plus" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">+</button>
                        </div>

                        <button class="add-to-cart" onclick="addToCart(${product.idPerfume})" 
                            style="background:#000; color:#fff; border:none; padding:12px 25px; font-size:14px; text-transform:uppercase; letter-spacing:1px; cursor:pointer;">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;
            
            // Ajouter les écouteurs d'événements
            document.getElementById('closeQuickView').addEventListener('click', closeQuickView);
            
            // Gestion de la quantité
            const minusBtn = modal.querySelector('.quantity-btn.minus');
            const plusBtn = modal.querySelector('.quantity-btn.plus');
            const quantityInput = modal.querySelector('.quantity-input');
            
            minusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
            
            plusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                quantityInput.value = value + 1;
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
            modal.innerHTML = `
                <div style="background:#fff; padding:20px; border-radius:8px; max-width:500px; width:100%; text-align:center;">
                    <p style="color:red; font-size:16px;">Erreur: Impossible de charger les détails du produit.</p>
                    <button onclick="closeQuickView()" style="margin-top:15px; padding:8px 15px; background:#000; color:#fff; border:none; cursor:pointer;">
                        Fermer
                    </button>
                </div>
            `;
        });
}

function closeQuickView() {
    document.getElementById('quickViewModal').style.display = 'none';
}
</script>
<script>
document.querySelectorAll('.add-to-wishlist').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    const id = this.dataset.id;
    const icon = this.querySelector('i');
    fetch('wishlist.php?action=add&id=' + id, { method: 'GET' })
      .then(res => {
        icon.classList.remove('far');
        icon.classList.add('fas');
        icon.style.color = '#c0392b';
      });
  });
});
</script>

  <?php include('include/newsletter.php'); ?>
</main>

<?php include('include/footer.php'); ?>
