<!-- HEADER -->
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
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
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

    .category-bar a.active {
      border-bottom: 2px solid #000;
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

    /* UPDATED PRODUCT GRID STYLES TO MATCH BEST SELLERS */
    .products {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      margin-bottom: 40px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .product {
      text-align: center;
      transition: transform 0.3s ease;
      position: relative;
    }

    .product:hover {
      transform: translateY(-8px);
    }
    .product-image-container {
     position: relative;
    width: 100%;
    height: 250px;
    padding-right:200px;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    }

    .product img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      position: absolute;
      transition: opacity 0.4s ease;
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
      margin: 8px 0;
      font-size: 16px;
      color: #333;
    }

    .product-brand {
      font-size: 16px;
      color: #333;
    }

    .product-price {
      font-weight: bold;
      font-size: 18px;
      color: #000;
    }

    /* NEW PRODUCT CARD ELEMENTS */
    .product-icons {
  position: absolute;
  top: 10px;
  right: 0px; /* <-- augmente la valeur ici (ex: 30px) */
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
  bottom: 0px;
  left: 55%;      /* <-- passe de 50% à 60% pour décaler à droite */
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
    .product:hover .add-to-cart-btn {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    .add-to-cart-btn:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      background-color: #15414e;
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
    
    .no-results {
      grid-column: 1 / -1;
      text-align: center;
      padding: 50px;
      font-size: 18px;
      color: #666;
    }
    
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 30px;
      gap: 10px;
    }
    
    .pagination a, .pagination span {
      padding: 8px 16px;
      border: 1px solid #ddd;
      color: #333;
      text-decoration: none;
      transition: background-color 0.3s;
    }
    
    .pagination a:hover {
      background-color: #f1f1f1;
    }
    
    .pagination .active {
      background-color: rgb(45, 175, 186);
      color: white;
      border-color: rgb(45, 175, 186);
    }
    
    .pagination .disabled {
      color: #aaa;
      pointer-events: none;
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
                        <p class="product-price">$'.number_format($perfume['price'], 2).'</p>
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
                // Format price range (add 100 to base price for example)
                const basePrice = parseFloat(product.price);
                const priceRange = `${basePrice}€ – ${basePrice + 100}€`;
                
                // Fill modal with template
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
                                <div class="size-option"><span class="size-label" style="color:#777;"> ${product.season }</span></div>
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
                
                // Add event listeners
                document.getElementById('closeQuickView').addEventListener('click', closeQuickView);
                
                // Quantity management
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
        // Implement your add to cart functionality here
        console.log('Adding product to cart:', productId);
        // You can use AJAX to send the product ID to your server
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
