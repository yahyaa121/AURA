<?php 
include "include/init.php";
include('include/header.php'); ?>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="accueil.css">

<main><br>

  <!-- Hero Section (Carousel) -->
  <section class="hero">
    <div class="hero-carousel">
      <img src="banners/byerdo3.jpg" class="active" alt="Slide 1">
      <img src="banners/jpg.jpg" alt="Slide 2">
      <img src="banners/lv.webp" alt="Slide 3">
      <button id="prevSlide" class="carousel-btn">&#10094;</button>
      <button id="nextSlide" class="carousel-btn">&#10095;</button>
    </div>
    <div class="carousel-dots">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </section>
<!-- Best Sellers Section -->
  <section class="section best-sellers">
  <div class="section-title">
    <h2><?= $lang['best_sellers'] ?></h2>
    
  </div>

    <div class="product-grid">

    <?php
require __DIR__ . "/database.php";

// Vérification de la connexion
if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    die("Erreur : La connexion à la base de données a échoué");
}

try {
     $query = "SELECT 
                  p.idPerfume, 
                  p.perfumeName, 
                  p.price, 
                  c.collectionName, 
                  pi.urlImage, 
                  pi.urlHover,
                  SUM(d.quantity) AS total_sold
              FROM perfumes p
              JOIN collections c ON p.idCollection = c.idCollection
              JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
              JOIN details d ON p.idPerfume = d.idPerfume
              GROUP BY p.idPerfume, p.perfumeName, p.price, c.collectionName, pi.urlImage, pi.urlHover
              ORDER BY total_sold DESC
              LIMIT 4"; 
    
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
  <div class="product-image-container">
    <a href="product.php?id=<?= $product['idPerfume'] ?>">
      <img src="perfumes/<?= htmlspecialchars($product['urlImage']) ?>" alt="<?= htmlspecialchars($product['perfumeName']) ?>" class="main-img" />
      <img src="perfumes/<?= htmlspecialchars($product['urlHover']) ?>" alt="<?= htmlspecialchars($product['perfumeName']) ?> Hover" class="hover-img" />
    </a>
    <div class="product-icons">
      <i class="fas fa-eye" onclick="openQuickView(<?= $product['idPerfume'] ?>)" title="Quick View"></i>
      <?php $isInWishlist = in_array($product['idPerfume'], $_SESSION['wishlist'] ?? []); ?>
      <a href="#" class="add-to-wishlist" data-id="<?= $product['idPerfume'] ?>" title="Ajouter à la wishlist">
        <i class="<?= $isInWishlist ? 'fas' : 'far' ?> fa-heart wishlist-heart" style="<?= $isInWishlist ? 'color:#009688;' : '' ?>"></i>
      </a>
    </div>
    <button class="add-to-cart-btn" style="bottom: -35px;" onclick="addToCart(<?= $product['idPerfume'] ?>)">
      <?= $lang['add_to_cart'] ?>
    </button>
  </div>
  <div class="product-info">
    <p class="product-brand"><?= htmlspecialchars($product['collectionName']) ?></p>
    <p class="product-name"><?= htmlspecialchars($product['perfumeName']) ?></p>
    <p class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
  </div>
</div>
    <?php endforeach; ?>
</div>


    </div>
  </section>
<div id="quickViewModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; padding:20px; box-sizing:border-box;">
</div>
  <!-- Quote Section -->
  <section class="section quote enhanced-quote">
  <div class="quote-content">
    <i class="fas fa-quote-left quote-icon"></i>
    <blockquote>
      <p><?=$lang["quote_text"]?></p>
      <cite>- Julien Sprecher</cite>
    </blockquote>
    <div class="quote-decoration"></div>
  </div>
</section>

<!-- Description Section -->
<section class="desc-section">
  <div class="desc-content">
    <img src="perfumes/17-17.png" alt="About Us" class="desc-img">
    <div>
      <h3><?= $lang['about_us'] ?? 'About Us' ?></h3>
      <p>
        We select exceptional perfumes to reveal your personality.<br>
        Let yourself be inspired by our unique olfactory universe.
      </p>
    </div>
  </div>
</section>

<!-- Categories Section -->
<section class="cat-section">
  <h3 class="cat-title"><?= $lang['discover_collections'] ?? 'Discover our collections' ?></h3>
  <div class="cat-cards">
    <!-- Pour Elle -->
    <a href="perfume.php?gender=Female" class="cat-card">
      <div class="cat-card-images">
        <img src="perfumes/2.png" alt="Pour Elle 1">
        <img src="perfumes/4.png" alt="Pour Elle 2">
        <img src="perfumes/6.png" alt="Pour Elle 3">
      </div>
      <span><?= $lang['for_her'] ?? 'For Her' ?></span>
    </a>
    <!-- Pour Lui -->
    <a href="perfume.php?gender=Male" class="cat-card">
      <div class="cat-card-images">
        <img src="perfumes/14.png" alt="Pour Lui 1">
        <img src="perfumes/15.png" alt="Pour Lui 2">
        <img src="perfumes/13.png" alt="Pour Lui 3">
      </div>
      <span><?= $lang['for_him'] ?? 'For Him' ?></span>
    </a>
  </div>
</section>
 


  <!-- JavaScript pour carrousel -->
  <script>
    const slides = document.querySelectorAll('.hero-carousel img');
    const dots = document.querySelectorAll('.carousel-dots .dot');
    let currentIndex = 0;
    let carouselInterval;

    function showSlide(index) {
      slides[currentIndex].classList.remove('active');
      dots[currentIndex].classList.remove('active');
      currentIndex = (index + slides.length) % slides.length;
      slides[currentIndex].classList.add('active');
      dots[currentIndex].classList.add('active');
    }

    function nextSlide() {
      showSlide(currentIndex + 1);
    }

    function prevSlide() {
      showSlide(currentIndex - 1);
    }

    function startCarousel() {
      carouselInterval = setInterval(nextSlide, 3600);
    }

    function resetCarousel() {
      clearInterval(carouselInterval);
      startCarousel();
    }

    document.getElementById('nextSlide').addEventListener('click', function() {
      nextSlide();
      resetCarousel();
    });
    document.getElementById('prevSlide').addEventListener('click', function() {
      prevSlide();
      resetCarousel();
    });
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        showSlide(index);
        resetCarousel();
      });
    });

    startCarousel();
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
            const priceRange = `${basePrice}€`;
            
            // Remplir le modal avec le template exact
            modal.innerHTML = `
                 <div style="background:#fff; padding:30px; border-radius:16px; max-width:900px; width:100%;
                 box-shadow:0 10px 30px rgba(0,0,0,0.15); position:relative; overflow-y:auto; max-height:90vh; display:flex; flex-wrap:wrap; gap:30px;">
                
                <button id="closeQuickView"
                  style="position:absolute; top:20px; right:20px; font-size:24px; font-weight:bold;
                  border:none; background:none; cursor:pointer; color:#999;">&times;</button>

                <div style="flex:1 1 300px; text-align:center; display:flex; align-items:center; justify-content:center;">
                    <img src="perfumes/${product.urlImage}" alt="${product.perfumeName}" style="max-width:100%; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
                </div>

                <div style="flex:1 1 500px; font-family:'Helvetica Neue',Arial,sans-serif; color:#333;">
                    <h1 style="font-size:28px; font-weight:400; letter-spacing:1px; margin-bottom:10px;">${product.perfumeName}</h1>
                    <div style="font-size:16px; color:#777; margin-bottom:20px;">Collection: <span style="color:#333;">${product.collectionName}</span></div>
                    <div style="font-size:18px; font-weight:500; margin-bottom:20px; color:#2daeba;">${priceRange}</div>
                    <div style="font-size:14px; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; color:#555;">
                        ${product.fragranceFamily || 'Fragrance notes not specified'}
                    </div>
                    <div style="font-size:14px; margin-bottom:20px; font-weight:300;">Extrait de Parfum</div>

                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; font-size:14px;">
                        <div><span style="color:#777;">${product.season || 'All seasons'}</span></div>
                    </div>

                    <div style="margin-bottom:20px; font-size:14px; color:#555;">50 ml e 1.7 FLOZ. SPRAY</div>

                    <div style="display:flex; align-items:center; margin-bottom:30px;">
                        <button class="quantity-btn minus" style="width:40px; height:40px; background:#f5f5f5; border:1px solid #ddd; font-size:18px; cursor:pointer; border-radius:8px;">-</button>
                        <input type="number" id="quickViewQty" class="quantity-input" value="1" min="1" style="width:50px; height:40px; text-align:center; border:1px solid #ddd; margin:0 10px; border-radius:8px; font-size:16px;">
                        <button class="quantity-btn plus" style="width:40px; height:40px; background:#f5f5f5; border:1px solid #ddd; font-size:18px; cursor:pointer; border-radius:8px;">+</button>
                    </div>

                    <button class="add-to-cart" onclick="addToCart(${product.idPerfume}, document.querySelector('#quickViewModal .quantity-input').value)" 
                        style="background:#2daeba; color:#fff; border:none; padding:15px 30px; font-size:16px; text-transform:uppercase; letter-spacing:1px; cursor:pointer; border-radius:8px; box-shadow:0 5px 15px rgba(45,175,186,0.2);">
                        <?= $lang['add_to_cart'] ?>
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
                if (value < 5) {
                    quantityInput.value = value + 1;
                }
            });
            
            // Prevent manual input above 5 or below 1
            quantityInput.addEventListener('input', () => {
                let value = parseInt(quantityInput.value) || 1;
                if (value > 5) value = 5;
                if (value < 1) value = 1;
                quantityInput.value = value;
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
<script>
function addToCart(idPerfume) {
    // Default quantity is 1 for grid view
    const quantity = 1;

    fetch('add_to_cart.php?id=' + idPerfume, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'quantity=' + quantity
    })
    .then(response => {
        // Optionally, update cart counter here
        // For now, just show a confirmation
        alert('Product added to cart !');
        // Optionally, reload or update cart icon/counter
         location.reload();
    })
    .catch(error => {
        alert('Error adding product to cart.');
        console.error(error);
    });
}
</script>
<script>
function addToCartFromModal(idPerfume) {
    const modal = document.getElementById('quickViewModal');
    const quantityInput = modal.querySelector('.quantity-input');
    let quantity = 1;
    if (quantityInput) {
        quantity = parseInt(quantityInput.value) || 1;
    }

    fetch('add_to_cart.php?id=' + idPerfume, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'quantity=' + quantity
    })
    .then(response => {
        alert('Product added to cart!');
        closeQuickView();
        location.reload(); // Optionally reload the page to update cart counter
    })
    .catch(error => {
        alert('Error adding product to cart.');
        console.error(error);
    });
}
</script>
<script>
function addToCart(productId) {
        let quantity = 1;
        const modal = document.getElementById('quickViewModal');
        if (modal && modal.style.display === 'flex') {
            const qtyInput = modal.querySelector('.quantity-input');
            if (qtyInput) {
                quantity = parseInt(qtyInput.value) || 1;
            }
        }
        fetch(`add_to_cart.php?id=${productId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `quantity=${quantity}`
        })
        .then(response => {
            if (response.ok) {
                showCartNotification('Produit ajouté au panier !');
                
            } else {
                showCartNotification('Erreur lors de l\'ajout au panier.', true);
            }
            
        })
        .catch(() => {
            showCartNotification('Erreur lors de l\'ajout au panier.', true);
        });
        location.reload();
    }
</script>
  <?php include('include/newsletter.php'); ?>
</main>
<br><br><br><br>
<?php include('include/footer.php'); ?>