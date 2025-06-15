<?php 
include "include/init.php";
include('include/header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="product.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
require_once('database.php'); 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM perfumes 
              NATURAL JOIN perfumeimage 
              NATURAL JOIN olfactivenotes 
              WHERE idPerfume = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} elseif (isset($_GET['name'])) {
    $name = $_GET['name'];
    $query = "SELECT * FROM perfumes 
              NATURAL JOIN perfumeimage 
              NATURAL JOIN olfactivenotes 
              WHERE perfumeName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $id = $product['idPerfume']; // For similar products section
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product selected.</p>";
    exit;
}
?>
<!-- ---------- MAIN CONTENT ---------- -->
<div class="container">
    <div class="image-container" id="image-container">
        <img src="perfumes/<?= htmlspecialchars($product['urlImage']) ?>" class="product-image" id="product-image" alt="Product Image">
    </div>

    <div class="product-details">
        <h2><?= htmlspecialchars($product['perfumeName']) ?></h2>
        <div class="price-range"><?= htmlspecialchars($product['price']) ?> €</div>
        <div class="product-collection"><?= htmlspecialchars($product['fragranceFamily']) ?></div>
        <div class="product-type">Extrait de Parfum</div>
        <div class="product-size">50 ml e 1.7 FL.OZ. VAPORISATEUR<br></div>

        <!-- Size Selection -->
        <div class="size-selection">
            <label>CONTENANCE:</label>
            <div class="size-options">
                <div class="size-option selected" data-size="50ml">50ml</div>
            </div>
        </div>

        <div class="quantity-and-cart">
            <form action="add_to_cart.php?id=<?= $product['idPerfume'] ?>" method="post">
                <div class="quantity-control">
                    <button type="button" class="quantity-btn" id="qty-minus">-</button>
                    <input type="number" name="quantity" class="quantity-input" id="qty-input" value="1" min="1" max="5">
                    <input type="hidden" name="idPerfume" value="<?= $product['idPerfume'] ?>">
                    <button type="button" class="quantity-btn" id="qty-plus">+</button>
                </div>
                <button class="add-to-cart" name="ADD">ADD TO CART</button>
            </form>
        </div>

        <div class="wishlist">
            <a href="#" class="add-to-wishlist" data-id="<?= $product['idPerfume'] ?>" title="Ajouter à la wishlist" style="display:inline-flex; align-items:center; gap:6px; text-decoration:none;">
              <i class="<?= in_array($product['idPerfume'], $_SESSION['wishlist'] ?? []) ? 'fas' : 'far' ?> fa-heart wishlist-heart"></i>
              <span style="font-size:13px; color:#888; font-family:'Futura PT', Futura, Arial, sans-serif;">ADD TO WISHLIST</span>
            </a>
        </div>
    </div>
</div>

<hr style="margin: 0; border: 1px solid #e0e0e0; width: 100%; margin-top: 50px;">

<!-- ---------- DESCRIPTION ---------- -->
<div class="description">
    <h3 style="font-size: medium;">DESCRIPTION</h3>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
</div>

<!-- ---------- NOTES ---------- -->
<div class="notes">
    <div class="note-box">
        <h4>NOTES DE TÊTE</h4>
        <p><?= htmlspecialchars($product['topNotes']) ?></p>
    </div>
    <div class="note-box">
        <h4>NOTES DE COEUR</h4>
        <p><?= htmlspecialchars($product['middleNotes']) ?></p>
    </div>
    <div class="note-box">
        <h4>NOTES DE FOND</h4>
        <p><?= htmlspecialchars($product['baseNotes']) ?></p>
    </div>
</div>

<!-- ---------- SIMILAR PRODUCTS ---------- -->
<?php
$fragranceFamily = $product['fragranceFamily'];
$querySimilar = "SELECT * FROM perfumes 
                 NATURAL JOIN perfumeimage 
                 NATURAL JOIN olfactivenotes
                 NATURAL JOIN collections
                 WHERE fragranceFamily = ? AND idPerfume != ? 
                 LIMIT 4";
$stmtSimilar = $mysqli->prepare($querySimilar);
$stmtSimilar->bind_param("si", $fragranceFamily, $id);
$stmtSimilar->execute();
$resultSimilar = $stmtSimilar->get_result();
?>
<div class="similar-products">
    <hr style="margin: 0; border: 1px solid #e0e0e0; width: 100%; margin-top: 50px;">
    <div class="section-title">
        <h2><?= $lang["similar_products"] ?? "Similar Products" ?></h2>
    </div>
    <div class="products">
        <?php while ($similarProduct = $resultSimilar->fetch_assoc()) : ?>
            <div class="product">
                <div class="product-image-container">
                    <a href="product.php?id=<?= $similarProduct['idPerfume'] ?>">
                        <img src="perfumes/<?= $similarProduct['urlImage'] ?>" alt="<?= htmlspecialchars($similarProduct['perfumeName']) ?>" class="main-img" />
                        <img src="perfumes/<?= $similarProduct['urlHover'] ?>" alt="<?= htmlspecialchars($similarProduct['perfumeName']) ?> Hover" class="hover-img" />
                    </a>
                    <div class="product-icons">
                        <i class="fas fa-eye" onclick="openQuickView(<?= $similarProduct['idPerfume'] ?>)" title="Quick View"></i>
                        <a href="#" class="add-to-wishlist" data-id="<?= $similarProduct['idPerfume'] ?>" title="Ajouter à la wishlist">
                            <i class="far fa-heart wishlist-heart"></i>
                        </a>
                    </div>
                    <button class="add-to-cart-btn" onclick="addToCart(<?= $similarProduct['idPerfume'] ?>)">
                        <?= $lang['add_to_cart'] ?? 'Add to Cart' ?>
                    </button>
                </div>
                <div class="product-brand"><?= htmlspecialchars($similarProduct['collectionName']) ?></div>
                <div class="product-name"><?= htmlspecialchars($similarProduct['perfumeName']) ?></div>
                <div class="product-price"><?= number_format($similarProduct['price'], 2, ',', ' ') ?> €</div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<!-- Quick View Modal -->
<div id="quickViewModal"></div>

<script>
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    modal.innerHTML = '<div style="color:white; font-size:20px;">Loading...</div>';
    modal.style.display = 'flex';

    fetch('get_product_details.php?id=' + productId)
        .then(response => {
            if (!response.ok) throw new Error('Network error');
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

        <button class="add-to-cart" onclick="addToCartFromModal(${product.idPerfume})" 
            style="background:#2daeba; color:#fff; border:none; padding:15px 30px; font-size:16px; text-transform:uppercase; letter-spacing:1px; cursor:pointer; border-radius:8px; box-shadow:0 5px 15px rgba(45,175,186,0.2);">
            Add to Cart
        </button>
    </div>
</div>
            `;

            document.getElementById('closeQuickView').addEventListener('click', closeQuickView);

            // Quantity controls inside modal
            const minusBtn = modal.querySelector('.quantity-btn.minus');
            const plusBtn = modal.querySelector('.quantity-btn.plus');
            const quantityInput = modal.querySelector('.quantity-input');
            quantityInput.setAttribute('max', 5);

            minusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value) || 1;
                if (value > 1) quantityInput.value = value - 1;
            });

            plusBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value) || 1;
                if (value < 5) quantityInput.value = value + 1;
            });

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

// Add to cart from modal
function addToCartFromModal(productId) {
    const modal = document.getElementById('quickViewModal');
    const quantityInput = modal.querySelector('.quantity-input');
    let quantity = 1;
    if (quantityInput) {
        quantity = parseInt(quantityInput.value) || 1;
    }
    fetch('add_to_cart.php?id=' + productId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'quantity=' + quantity
    })
    .then(response => {
        if (response.ok) {
            alert('Produit ajouté au panier !');
            closeQuickView();
        } else {
            alert('Erreur lors de l\'ajout au panier.');
        }
    })
    .catch(() => {
        alert('Erreur lors de l\'ajout au panier.');
    });
}
</script>

<!-- ---------- IMAGE ZOOM SCRIPT ---------- -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const imageContainer = document.getElementById("image-container");
        const productImage = document.getElementById("product-image");

        // --- Configuration ---
        const ZOOM_LEVEL = 1.8; // How much to zoom in (e.g., 1.5 for 50% larger, 2 for double)
        const TRANSITION_DURATION = 0.15; // In seconds, for smooth animation

        // Apply transition duration to the image
        productImage.style.transition = `transform ${TRANSITION_DURATION}s ease-out`;

        imageContainer.addEventListener("mousemove", (e) => {
            // Only zoom if the image has loaded
            if (!productImage.complete) {
                return;
            }

            const rect = imageContainer.getBoundingClientRect();
            // Calculate mouse position relative to the container, as a percentage
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            // Set the transform origin to the mouse position
            productImage.style.transformOrigin = `${x}% ${y}%`;
            // Apply the zoom
            productImage.style.transform = `scale(${ZOOM_LEVEL})`;
        });

        imageContainer.addEventListener("mouseleave", () => {
            // Reset zoom when the mouse leaves the container
            productImage.style.transform = "scale(1)";
        });

        // Optional: Handle image loading to ensure the script works correctly
        productImage.addEventListener('load', () => {
            console.log('Product image loaded successfully!');
            // You could add a loader animation here if needed
        });

        productImage.addEventListener('error', () => {
            console.error('Error loading product image. Please check the image URL.');
            // Display a placeholder or error message to the user
            productImage.src = 'placeholder-image.jpg'; // Provide a fallback image
            productImage.alt = 'Image Not Available';
        });
    });
</script>

<!-- ---------- QUANTITY CONTROL SCRIPT ---------- -->
<script>
    const qtyInput = document.getElementById('qty-input');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');

    qtyMinus.addEventListener('click', function() {
        let value = parseInt(qtyInput.value, 10) || 1;
        if (value > 1) qtyInput.value = value - 1;
    });

    qtyPlus.addEventListener('click', function() {
        let value = parseInt(qtyInput.value, 10) || 1;
        if (value < 5) {
            qtyInput.value = value + 1;
        }
    });

    qtyInput.addEventListener('input', function() {
        let value = parseInt(qtyInput.value, 10);
        if (isNaN(value) || value < 1) {
            qtyInput.value = 1;
        } else if (value > 5) {
            qtyInput.value = 5;
        }
    });

    function addToCart(idPerfume) {
        const quantity = parseInt(document.getElementById('qty-input').value);
        
        fetch('cart_operations.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=add&idPerfume=${idPerfume}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data); // Pour déboguer
            if (data.success) {
                if (confirm('Product added to cart. Would you like to view your cart?')) {
                    window.location.href = 'cart.php';
                }
            } else {
                alert(data.message); // Affiche le message d'erreur exact
            }
        });
    }
</script>

<!-- ---------- SIZE SELECTION SCRIPT ---------- -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Size selection functionality
        const sizeOptions = document.querySelectorAll('.size-option');
        
        sizeOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                sizeOptions.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked option
                this.classList.add('selected');
            });
        });
    });
</script>
<!-- Quick View Script -->
<script>
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
          alert('Produit ajouté au panier !');
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
<br><br><br><br>
<?php include('include/footer.php'); ?>