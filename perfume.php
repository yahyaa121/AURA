<?php 
  include "include/init.php";
  include 'include/header.php';
  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $lang["all_products"] ?></title>
  <!-- FontAwesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="perfume.css">
</head>
<body>

<!-- Replace your existing notification div with this -->
<div id="cart-notification" style="
  display:none;
  position:fixed;
  top:20px;
  left:50%;
  transform:translateX(-50%) translateY(-30px);
  min-width:280px;
  max-width:90vw;
  background:#2daeba;
  color:#fff;
  padding:14px 38px 14px 18px;
  border-radius:8px;
  z-index:9999;
  font-size:16px;
  box-shadow:0 4px 18px rgba(0,0,0,0.18);
  font-family:Arial,sans-serif;
  transition:opacity 0.4s, transform 0.4s;
  opacity:0;
  pointer-events:none;
">
  <span id="cart-notification-icon" style="margin-right:10px;font-size:18px;vertical-align:middle;"></span>
  <span id="cart-notification-message"></span>
  <span id="cart-notification-close" style="position:absolute;top:8px;right:12px;cursor:pointer;font-size:18px;opacity:0.7;">&times;</span>
</div>

  <!-- Barre des catégories -->
  <div class="category-bar">
    <?php
    $genderOptions = [
      'all' => $lang['gender_all'],
      'Male' => $lang['gender_male'],
      'Female' => $lang['gender_female'],
      'Unisex' => $lang['gender_unisex']
    ];
    foreach($genderOptions as $value => $label) {
      $activeClass = (isset($_GET['gender']) && $_GET['gender'] == $value) || (!isset($_GET['gender']) && $value == 'all') ? 'active' : '';
      echo '<a href="?gender='.$value.'" class="'.$activeClass.'">'.$label.'</a>';
    }
    ?>
  </div>

  <!-- Trait de séparation pleine largeur -->
  <hr class="full-width" />

  <!-- Contenu principal -->
  <div class="container">
    <!-- Filtres -->
    <div class="filters">
      <h2><?= $lang['filter_title'] ?></h2>

      <form method="GET" action="">
        <!-- Preserve gender selection -->
        <?php if(isset($_GET['gender'])): ?>
          <input type="hidden" name="gender" value="<?= htmlspecialchars($_GET['gender']) ?>">
        <?php endif; ?>
        
        <div class="filter-group">
          <h3><?= $lang['filter_price'] ?></h3>
          <select name="price_order">
            <option value=""><?= $lang['filter_price_select'] ?></option>
            <option value="asc" <?= (isset($_GET['price_order']) && $_GET['price_order'] == 'asc') ? 'selected' : '' ?>><?= $lang['filter_price_asc'] ?></option>
            <option value="desc" <?= (isset($_GET['price_order']) && $_GET['price_order'] == 'desc') ? 'selected' : '' ?>><?= $lang['filter_price_desc'] ?></option>
          </select>
        </div>

        <div class="filter-group">
          <h3><?= $lang['filter_olfactory'] ?></h3>
          <?php
          $noteOptions = [
            'floral' => $lang['filter_note_floral'],
            'woody' => $lang['filter_note_woody'],
            'citrus' => $lang['filter_note_citrus'],
            'spicy' => $lang['filter_note_spicy'],
            'amber' => $lang['filter_note_amber'],
            'leather' => $lang['filter_note_leather']
          ];
          
          foreach($noteOptions as $value => $label) {
            $checked = (isset($_GET['note']) && in_array($value, $_GET['note'])) ? 'checked' : '';
            echo '<label><input type="checkbox" name="note[]" value="'.$value.'" '.$checked.'> '.$label.'</label>';
          }
          ?>
        </div>

        <div class="filter-group">
          <h3><?= $lang['filter_season'] ?></h3>
          <?php
          $seasonOptions = [
            'spring' => $lang['filter_season_spring'],
            'summer' => $lang['filter_season_summer'],
            'autumn' => $lang['filter_season_autumn'],
            'winter' => $lang['filter_season_winter']
          ];
          
          foreach($seasonOptions as $value => $label) {
            $checked = (isset($_GET['season']) && in_array($value, $_GET['season'])) ? 'checked' : '';
            echo '<label><input type="checkbox" name="season[]" value="'.$value.'" '.$checked.'> '.$label.'</label>';
          }
          ?>
        </div>

        <button type="submit" class="filter-btn"><?= $lang['filter_apply'] ?></button>
      </form>
    </div>

    <!-- Produits -->
    <div class="main-content">
      <div class="products">
        <?php
        // Connexion à la base de données
        $host = '127.0.0.1:3306';
        $dbname = 'aura';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Pagination settings
            $perPage = 6;
            $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($page - 1) * $perPage;

            // Base query for counting total items
            $countQuery = "
                SELECT COUNT(*) as total
                FROM perfumes p
                JOIN collections c ON p.idCollection = c.idCollection
                JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
                JOIN olfactivenotes o ON p.idPerfume = o.idPerfume
                WHERE 1=1
            ";
            
            // Base query for getting items
            $query = "
                SELECT p.*, pi.urlImage, pi.urlHover, c.collectionName 
                FROM perfumes p
                JOIN collections c ON p.idCollection = c.idCollection
                JOIN perfumeimage pi ON p.idPerfume = pi.idPerfume
                JOIN olfactivenotes o ON p.idPerfume = o.idPerfume
                WHERE 1=1
            ";
            
            $params = [];
            $countParams = [];
            
            // Gender filter
            if(isset($_GET['gender']) && $_GET['gender'] != 'all') {
                $query .= " AND p.gender = :gender";
                $countQuery .= " AND p.gender = :gender";
                $params[':gender'] = $_GET['gender'];
                $countParams[':gender'] = $_GET['gender'];
            }
            
            // Olfactory notes filter
            if(isset($_GET['note']) && is_array($_GET['note'])) {
                $noteConditions = [];
                foreach($_GET['note'] as $note) {
                    switch($note) {
                        case 'floral':
                            $noteConditions[] = "(o.topNotes LIKE '%Rose%' OR o.middleNotes LIKE '%Rose%' OR o.baseNotes LIKE '%Rose%' 
                                              OR o.topNotes LIKE '%Jasmine%' OR o.middleNotes LIKE '%Jasmine%' OR o.baseNotes LIKE '%Jasmine%')";
                            break;
                        case 'woody':
                            $noteConditions[] = "(o.baseNotes LIKE '%Wood%' OR o.baseNotes LIKE '%Cedar%' OR o.baseNotes LIKE '%Sandalwood%')";
                            break;
                        case 'citrus':
                            $noteConditions[] = "(o.topNotes LIKE '%Bergamot%' OR o.topNotes LIKE '%Citrus%' OR o.topNotes LIKE '%Orange%')";
                            break;
                        case 'spicy':
                            $noteConditions[] = "(o.topNotes LIKE '%Saffron%' OR o.middleNotes LIKE '%Cinnamon%' OR o.topNotes LIKE '%Pepper%')";
                            break;
                        case 'amber':
                            $noteConditions[] = "(o.baseNotes LIKE '%Amber%')";
                            break;
                        case 'leather':
                            $noteConditions[] = "(o.middleNotes LIKE '%Leather%')";
                            break;
                    }
                }
                if(!empty($noteConditions)) {
                    $query .= " AND (" . implode(" OR ", $noteConditions) . ")";
                    $countQuery .= " AND (" . implode(" OR ", $noteConditions) . ")";
                }
            }
            
            // Season filter
            if(isset($_GET['season']) && is_array($_GET['season'])) {
                $seasonConditions = [];
                foreach($_GET['season'] as $season) {
                    switch($season) {
                        case 'spring':
                            $seasonConditions[] = "p.season LIKE '%Spring%'";
                            break;
                        case 'summer':
                            $seasonConditions[] = "p.season LIKE '%Summer%'";
                            break;
                        case 'autumn':
                            $seasonConditions[] = "p.season LIKE '%Autumn%'";
                            break;
                        case 'winter':
                            $seasonConditions[] = "p.season LIKE '%Winter%'";
                            break;
                    }
                }
                if(!empty($seasonConditions)) {
                    $query .= " AND (" . implode(" OR ", $seasonConditions) . ")";
                    $countQuery .= " AND (" . implode(" OR ", $seasonConditions) . ")";
                }
            }
            
            // Price order
            $orderBy = "";
            if(isset($_GET['price_order'])) {
                if($_GET['price_order'] == 'asc') {
                    $orderBy = " ORDER BY p.price ASC";
                } elseif($_GET['price_order'] == 'desc') {
                    $orderBy = " ORDER BY p.price DESC";
                }
            } else {
                $orderBy = " ORDER BY RAND()";
            }
            
            // Add pagination to main query
            $query .= $orderBy . " LIMIT :offset, :perPage";
            
            // Get total count for pagination
            $countStmt = $pdo->prepare($countQuery);
            foreach($countParams as $key => $value) {
                $countStmt->bindValue($key, $value);
            }
            $countStmt->execute();
            $totalItems = $countStmt->fetchColumn();
            $totalPages = ceil($totalItems / $perPage);
            
            // Reset page number if it's greater than total pages
            if($page > $totalPages && $totalPages > 0) {
                $page = 1;
                $offset = 0;
                // Update the query with new offset
                $query = str_replace("LIMIT :offset, :perPage", "LIMIT 0, :perPage", $query);
            }
            
            // Prepare and execute main query
            $stmt = $pdo->prepare($query);
            
            // Bind parameters
            foreach($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            // Bind pagination parameters
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            
            $stmt->execute();
            $perfumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($perfumes) > 0) {
                foreach($perfumes as $perfume) {
                    $isInWishlist = in_array($perfume['idPerfume'], $_SESSION['wishlist'] ?? []);
                    echo '
                    <div class="product">
                        <div class="product-image-container">
                        <a href="product.php?action=add&id='.$perfume['idPerfume'].'">
                            <img src="perfumes/'.$perfume['urlImage'].'" alt="'.$perfume['perfumeName'].'" class="main-img" />
                            <img src="perfumes/'.$perfume['urlHover'].'" alt="'.$perfume['perfumeName'].'" class="hover-img" />
                            </a>
                            
                            <div class="product-icons">
                                <i class="fas fa-eye" onclick="openQuickView('.$perfume['idPerfume'].')" title="'.$lang['product_quick_view'].'"></i>
                                <a href="#" class="add-to-wishlist" data-id="'.$perfume['idPerfume'].'" title="Ajouter à la wishlist">
                                    <i class="'.($isInWishlist ? 'fas' : 'far').' fa-heart wishlist-heart" style="'.($isInWishlist ? 'color:#c0392b;' : '').'"></i>
                                </a>
                            </div>
                            
                            <button class="add-to-cart-btn" onclick="addToCart('.$perfume['idPerfume'].')">
                                '.$lang['product_add_to_cart'].'
                            </button>
                        </div>
                        <p class="product-brand">'.$perfume['collectionName'].'</p>
                        <p class="product-name">'.$perfume['perfumeName'].'</p>
                        <p class="product-price">'.number_format($perfume['price'], 2).' €</p>
                    </div>
                    ';
                }
            } else {
                echo '<div class="no-results">'.$lang['no_results'].'</div>';
            }
        } catch(PDOException $e) {
            echo '<div class="no-results">Database error: ' . $e->getMessage() . '</div>';
        }
        ?>
      </div>
      
      <?php
      // Pagination
      if(isset($totalPages) && $totalPages > 1) {
          echo '<div class="pagination">';
          
          // Previous button
          if($page > 1) {
              echo '<a href="?'.http_build_query(array_merge($_GET, ['page' => $page - 1])).'">'.$lang['pagination_prev'].'</a>';
          } else {
              echo '<span class="disabled">'.$lang['pagination_prev'].'</span>';
          }
          
          // Page numbers
          for($i = 1; $i <= $totalPages; $i++) {
              if($i == $page) {
                  echo '<span class="active">'.$i.'</span>';
              } else {
                  echo '<a href="?'.http_build_query(array_merge($_GET, ['page' => $i])).'">'.$i.'</a>';
              }
          }
          
          // Next button
          if($page < $totalPages) {
              echo '<a href="?'.http_build_query(array_merge($_GET, ['page' => $page + 1])).'">'.$lang['pagination_next'].'</a>';
          } else {
              echo '<span class="disabled">'.$lang['pagination_next'].'</span>';
          }
          
          echo '</div>';
      }
      ?>
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
        
        // Show loading indicator
        modal.innerHTML = '<div style="color:white; font-size:20px;">Loading...</div>';
        modal.style.display = 'flex';
        
        fetch('get_product_details.php?id=' + productId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network error');
                }
                return response.json();
            })
            .then(product => {
               
                const basePrice = parseFloat(product.price);
                const priceRange = `${basePrice} €`;
                
                // Fill modal with template
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
            </div>
                `;
                
                // Add event listeners
                document.getElementById('closeQuickView').addEventListener('click', closeQuickView);
                
                // Quantity management
                const minusBtn = modal.querySelector('.quantity-btn.minus');
                const plusBtn = modal.querySelector('.quantity-btn.plus');
                const quantityInput = modal.querySelector('.quantity-input');
                quantityInput.setAttribute('max', 5); // Set max to 5

                minusBtn.addEventListener('click', () => {
                    let value = parseInt(quantityInput.value);
                    if (value > 1) {
                        quantityInput.value = value - 1;
                    }
                });
                
                plusBtn.addEventListener('click', () => {
                    let value = parseInt(quantityInput.value);
                    if (value < 5) { // Prevent going above 5
                        quantityInput.value = value + 1;
                    }
                });
                
                // Optionally, prevent manual input above 5 or below 1
                quantityInput.addEventListener('input', () => {
                    let value = parseInt(quantityInput.value) || 1;
                    if (value > 5) value = 5;
                    if (value < 1) value = 1;
                    quantityInput.value = value;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                modal.innerHTML = `
                    <div style="background:#fff; padding:20px; border-radius:8px; max-width:500px; width:100%; text-align:center;">
                        <p style="color:red; font-size:16px;">Error: Could not load product details.</p>
                        <button onclick="closeQuickView()" style="margin-top:15px; padding:8px 15px; background:#000; color:#fff; border:none; cursor:pointer;">
                            Close
                        </button>
                    </div>
                `;
            });
    }

    function closeQuickView() {
        document.getElementById('quickViewModal').style.display = 'none';
    }

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

    function showCartNotification(message, isError = false) {
        const notif = document.getElementById('cart-notification');
        const icon = document.getElementById('cart-notification-icon');
        const msg = document.getElementById('cart-notification-message');
        const closeBtn = document.getElementById('cart-notification-close');
        msg.textContent = message;
        notif.style.background = isError ? '#c0392b' : '#2daeba';
        icon.innerHTML = isError
            ? '<i class="fas fa-times-circle" style="color:#fff;"></i>'
            : '<i class="fas fa-check-circle" style="color:#fff;"></i>';
        notif.style.opacity = '1';
        notif.style.transform = 'translateX(-50%) translateY(0)';
        notif.style.display = 'block';
        notif.style.pointerEvents = 'auto';

        // Close on click
        closeBtn.onclick = function() {
            notif.style.opacity = '0';
            notif.style.transform = 'translateX(-50%) translateY(-30px)';
            setTimeout(() => {
                notif.style.display = 'none';
            }, 400);
        };

        // Auto close after 2.2s
        clearTimeout(notif._timeout);
        notif._timeout = setTimeout(() => {
            notif.style.opacity = '0';
            notif.style.transform = 'translateX(-50%) translateY(-30px)';
            setTimeout(() => {
                notif.style.display = 'none';
            }, 400);
        }, 2200);
    }

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
</body>
</html>