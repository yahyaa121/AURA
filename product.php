<?php include('include/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="product.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
</body>
</html>
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
} else {
    echo "<p>No product selected.</p>";
    exit;
}
?>

<!-- ---------- MAIN CONTENT ---------- -->
<div class="container">
    <div class="image-container" id="image-container">
        <img src="perfume/<?= $product['urlImage'] ?>" class="product-image" id="product-image" alt="Product Image">
    </div>

    <div class="product-details">
        <h2><?= $product['perfumeName'] ?></h2>
        <div class="price-range"><?= $product['price'] ?>$</div>
        <div class="product-collection"><?= $product['fragranceFamily'] ?></div>
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

        <div class="wishlist">♡ ADD TO WISHLIST</div>
    </div>
</div>

<hr style="margin: 0; border: 1px solid #e0e0e0; width: 100%; margin-top: 50px;">

<!-- ---------- DESCRIPTION ---------- -->
<div class="description">
    <h3>DESCRIPTION</h3>
    <p><?= $product['description'] ?></p>
</div>

<!-- ---------- NOTES ---------- -->
<div class="notes">
    <div class="note-box">
        <h4>NOTES DE TÊTE</h4>
        <p><?= $product['topNotes'] ?></p>
    </div>
    <div class="note-box">
        <h4>NOTES DE COEUR</h4>
        <p><?= $product['middleNotes'] ?></p>
    </div>
    <div class="note-box">
        <h4>NOTES DE FOND</h4>
        <p><?= $product['baseNotes'] ?></p>
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
    <hr style="margin: 10; border: 1px solid #e0e0e0; width: 100%; margin-top: 50px;">
    <h3>Similar products</h3>
    <div class="product-grid">
        <?php while ($similarProduct = $resultSimilar->fetch_assoc()) : ?>
            <div class="product-card">
                <a href="product.php?id=<?= $similarProduct['idPerfume'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="product-image-frame">
                        <div class="product-image">
                            <img src="perfume/<?= $similarProduct['urlImage'] ?>" alt="<?= htmlspecialchars($similarProduct['perfumeName']) ?>" class="img-default">
                            <img src="perfume/<?= $similarProduct['urlHover'] ?>" alt="<?= htmlspecialchars($similarProduct['perfumeName']) ?> Hover" class="img-hover">
                            <div class="product-icons">
                                <i class="fas fa-eye" onclick="openQuickViewSimilar(<?= $similarProduct['idPerfume'] ?>)" title="Quick View"></i>
                                <i class="fas fa-heart"></i>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCart(<?= $similarProduct['idPerfume'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                    <p><?= htmlspecialchars($similarProduct['perfumeName']) ?></p>
                    <p><?= htmlspecialchars($similarProduct['collectionName']) ?></p>
                    <p><?= $similarProduct['price'] ?> €</p>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

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

<?php include('include/footer.php'); ?>