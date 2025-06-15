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
  <link rel="stylesheet" href="newarrivals.css">
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
   <br><br><br><br>
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
          const priceRange = `${basePrice} €`;
          
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
                        <input type="text" class="quantity-input" value="1" style="width:50px; height:40px; text-align:center; border:1px solid #ddd; margin:0 10px; border-radius:8px; font-size:16px;">
                        <button class="quantity-btn plus" style="width:40px; height:40px; background:#f5f5f5; border:1px solid #ddd; font-size:18px; cursor:pointer; border-radius:8px;">+</button>
                    </div>

                    <button class="add-to-cart" onclick="addToCart(${product.idPerfume}, document.querySelector('#quickViewModal .quantity-input').value)" 
                        style="background:#2daeba; color:#fff; border:none; padding:15px 30px; font-size:16px; text-transform:uppercase; letter-spacing:1px; cursor:pointer; border-radius:8px; box-shadow:0 5px 15px rgba(45,175,186,0.2);">
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
                if (value < 5) quantityInput.value = value + 1; // Limit max quantity to 5
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
    function addToCart(productId, quantity = 1) {
      fetch('add_to_cart.php?id=' + encodeURIComponent(productId), {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'quantity=' + encodeURIComponent(quantity)
      })
      .then(response => response.text())
      .then(text => {
        if (text.trim() === 'success') {
          
          window.location.href = window.location.pathname + window.location.search;
        } else {
          alert('Erreur lors de l\'ajout au panier.');
        }
      })
      .catch(() => {
        alert('Erreur lors de l\'ajout au panier.');
      });
    }
  </script>
</body>
</html>