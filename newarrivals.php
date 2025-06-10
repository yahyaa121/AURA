<!-- HEADER -->
  <?php 
  include "include/init.php";
  include 'include/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
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
      grid-template-columns: repeat(3, 1fr););
      gap: 30px;
      padding: 20px;
    }

    .product {
      position: relative;
      text-align: center;
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .product:hover {
      transform: translateY(-8px);
    }

    .product-image-container {
      position: relative;
      width: 100%;
      height: 250px;
      margin-bottom: 15px;
    }

    .product img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      transition: opacity 0.4s ease;
      position: absolute;
      top: 0;
      left: 0;
    }

    .hover-img {
      opacity: 0;
    }

    .product:hover .hover-img {
      opacity: 1;
    }

    .product:hover .main-img {
      opacity: 0;
    }

    .product-name {
      margin-top: 10px;
      font-size: 14px;
    }

    .product-brand {
      font-style: italic;
      font-size: 13px;
      color: #555;
    }

    .product-price {
      font-weight: bold;
      margin-top: 5px;
      font-size: 16px;
    }
    
    .section-title {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
      gap: 20px;
      margin-top: 60px;
    }

    .section-title::before,
    .section-title::after {
      content: "";
      flex: 1;
      height: 1px;
      background-color: #ccc;
    }
    
    /* New styles from best sellers */
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

    .product:hover .product-icons {
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
  bottom: 0px;           /* descend le bouton */
  left: 50%;
  width: 60%;             /* réduit la largeur */
  transform: translateX(-50%);
  background-color: #0a2e38;
  color: #fff;
  border: none;
  padding: 8px 0;         /* réduit la hauteur */
  font-size: 13px;        /* réduit la taille du texte */
  cursor: pointer;
  border-radius: 4px;
  opacity: 0;
  transition: opacity 0.3s, transform 0.3s, box-shadow 0.3s, background-color 0.3s;
  z-index: 2;
}

.product:hover .add-to-cart-btn {
  opacity: 1;
  transform: translateX(-50%) translateY(4px); /* descend encore un peu au hover */
}
    .add-to-cart-btn:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      background-color: #15414e;
    }
    
    /* Quick View Modal */
    #quickViewModal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 20px;
      box-sizing: border-box;
    }
  </style>
</head>
<body>

  

  <!-- Contenu principal -->
  <div class="main-content">
    <div class="section-title">
      <h2 style="font-size: 24px;"><?= $lang["new_arrivals"] ?></h2>
    </div>

    <div class="products">
      <?php
      // Connexion à la base de données
      $db = new PDO('mysql:host=127.0.0.1:3306;dbname=aura', 'root', '');
      
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
        <div class="product-image-container">
          <a href="product.php?id=<?= $product['idPerfume'] ?>">
            <img src="perfumes/<?= $product['urlImage'] ?>" alt="<?= $product['perfumeName'] ?>" class="main-img" />
            <img src="perfumes/<?= $product['urlHover'] ?>" alt="<?= $product['perfumeName'] ?>" class="hover-img" />
          </a>
          
          <div class="product-icons">
            <i class="fas fa-eye" onclick="openQuickView(<?= $product['idPerfume'] ?>)" title="Quick View"></i>
            <?php
            $isInWishlist = in_array($product['idPerfume'], $_SESSION['wishlist'] ?? []);
            ?>
            <a href="#" class="add-to-wishlist" data-id="<?= $product['idPerfume'] ?>" title="Ajouter à la wishlist">
              <i class="<?= $isInWishlist ? 'fas' : 'far' ?> fa-heart wishlist-heart" style="<?= $isInWishlist ? 'color:#c0392b;' : '' ?>"></i>
            </a>
          </div>
          
          <button class="add-to-cart-btn" onclick="addToCart(<?= $product['idPerfume'] ?>)">
            <?= $lang['add_to_cart'] ?>
          </button>
        </div>
        <div class="product-brand"><?= $product['collectionName'] ?></div>
        <div class="product-name"><?= $product['perfumeName'] ?></div>
        <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Quick View Modal -->
  <div id="quickViewModal"></div>

  <!-- FOOTER -->
  <?php include 'include/footer.php'; ?>

  <script>
    // Quick View Function
    function openQuickView(productId) {
      const modal = document.getElementById('quickViewModal');
      
      modal.innerHTML = '<div style="color:white; font-size:20px;">Chargement...</div>';
      modal.style.display = 'flex';
      
      fetch('get_product_details.php?id=' + productId)
        .then(response => {
          if (!response.ok) throw new Error('Erreur réseau');
          return response.json();
        })
        .then(product => {
          const basePrice = parseFloat(product.price);
          const priceRange = `${basePrice}€ – ${basePrice + 100}€`;
          
          modal.innerHTML = `
            <div style="background:#fff; padding:20px; border-radius:12px; max-width:800px; width:100%;
                 box-shadow:0 10px 25px rgba(0,0,0,0.2); position:relative; overflow-y:auto; max-height:90vh; display:flex; flex-wrap:wrap; gap:20px;">
                
                <button id="closeQuickView"
                  style="position:absolute; top:15px; right:15px; font-size:22px; font-weight:bold;
                  border:none; background:none; cursor:pointer; color:#666;">&times;</button>

                <div style="flex:1 1 250px; text-align:center;">
                    <img src="perfumes/${product.urlImage}" alt="${product.perfumeName}" style="max-width:100%; border-radius:8px;">
                </div>

                <div style="flex:1 1 400px; font-family:'Helvetica Neue',Arial,sans-serif; color:#333;">
                    <h1 style="font-size:24px; font-weight:300; letter-spacing:1px; margin-bottom:5px;">${product.perfumeName}</h1>
                    <div style="font-size:14px; color:#777; margin-bottom:20px;">Collection ${product.collectionName}</div>
                    <div style="font-size:16px; margin-bottom:15px;">${priceRange}</div>
                    <div style="font-size:14px; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; color:#555;">
                        ${product.fragranceFamily || 'Fragrance notes not specified'}
                    </div>
                    <div style="font-size:14px; margin-bottom:20px; font-weight:300;">Extrait de Parfum</div>

                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; font-size:14px;">
                        <div><span style="color:#777;">${product.season || 'All seasons'}</span></div>
                    </div>

                    <div style="margin-bottom:20px;">50 ml e 1.7 FLOZ. SPRAY</div>

                    <div style="display:flex; align-items:center; margin-bottom:25px;">
                        <button class="quantity-btn minus" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">-</button>
                        <input type="text" class="quantity-input" value="1" style="width:40px; height:28px; text-align:center; border:1px solid #ddd; margin:0 5px;">
                        <button class="quantity-btn plus" style="width:30px; height:30px; background:#f5f5f5; border:1px solid #ddd; font-size:16px; cursor:pointer;">+</button>
                    </div>

                    <button class="add-to-cart" onclick="addToCart(${product.idPerfume})" 
                        style="background:#000; color:#fff; border:none; padding:12px 25px; font-size:14px; text-transform:uppercase; letter-spacing:1px; cursor:pointer;">
                        <?= $lang['add_to_cart'] ?>
                    </button>
                </div>
            </div>`;
            
            document.getElementById('closeQuickView').addEventListener('click', closeQuickView);
            
            const minusBtn = modal.querySelector('.quantity-btn.minus');
            const plusBtn = modal.querySelector('.quantity-btn.plus');
            const quantityInput = modal.querySelector('.quantity-input');
            
            minusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) quantityInput.value = value - 1;
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
                </div>`;
        });
    }

    function closeQuickView() {
      document.getElementById('quickViewModal').style.display = 'none';
    }

    // Wishlist Function
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

    // Add to Cart Function (simplified - you should implement your actual cart logic)
    function addToCart(productId) {
      fetch('cart.php?action=add&id=' + productId, { method: 'GET' })
        .then(response => {
          alert('Produit ajouté au panier !');
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>
</body>
</html>
