<?php include('include/header.php'); ?>
<style>
body {
    background-color: #ffffff;
    color: #333333;
    font-family: 'Arial', 'Helvetica', sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

.container {
    display: flex;
    flex-wrap: wrap;
    gap: 60px;
    padding: 40px 20px;
    justify-content: center;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto;
}


.image-container {
    flex: 1;
    max-width: 450px;
    min-width: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f8f8;
    padding: 20px;
    border-radius: 8px;
}

.product-image {
    width: 100%;
    max-width: 350px;
    height: auto;
    object-fit: contain;
}

.product-details {
    flex: 1;
    max-width: 500px;
    min-width: 300px;
    padding: 20px 0;
    background: transparent;
    box-shadow: none;
    border-radius: 0;
}

.product-details h2 {
    font-size: 36px;
    font-weight: 300;
    margin: 0 0 20px 0;
    font-family: 'Arial', sans-serif;
    color: #333333;
    text-transform: uppercase;
    letter-spacing: 2px;
    line-height: 1.2;
}

.price-range {
    font-size: 18px;
    color: #666666;
    margin-bottom: 15px;
    font-weight: normal;
}

.product-collection {
    font-size: 14px;
    color: #888888;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-type {
    font-size: 14px;
    color: #666666;
    margin-bottom: 10px;
}

.product-size {
    font-size: 14px;
    color: #666666;
    margin-bottom: 30px;
}

.product-details p {
    margin: 8px 0;
    font-size: 14px;
    color: #666666;
    font-weight: normal;
}

/* Size selection styling */
.size-selection {
    margin-bottom: 25px;
}

.size-selection label {
    font-size: 12px;
    color: #666666;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: block;
}

.size-options {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.size-option {
    padding: 8px 15px;
    border: 1px solid #dddddd;
    background: #ffffff;
    color: #666666;
    font-size: 12px;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.2s ease;
}

.size-option:hover,
.size-option.selected {
    border-color: #333333;
    background: #333333;
    color: #ffffff;
}

.quantity-and-cart {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #dddddd;
    background: #ffffff;
    height: 45px;
    min-width: 120px;
}

.quantity-btn {
    width: 35px;
    height: 45px;
    font-size: 16px;
    background: #ffffff;
    border: none;
    cursor: pointer;
    color: #666666;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background: #f5f5f5;
}

.quantity-input {
    width: 50px;
    height: 45px;
    text-align: center;
    font-size: 14px;
    border: none;
    outline: none;
    background: #ffffff;
    color: #333333;
}

.add-to-cart {
    background-color: #333333;
    color: #ffffff;
    padding: 12px 25px;
    font-size: 12px;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: normal;
    transition: background-color 0.2s ease;
    height: 45px;
    min-width: 150px;
}

.add-to-cart:hover {
    background-color: #555555;
}

.wishlist {
    margin-top: 15px;
    font-size: 12px;
    color: #888888;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.wishlist:hover {
    color: #333333;
    text-decoration: underline;
}

.description {
    padding: 60px 20px 40px;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    border-top: 1px solid #eeeeee;
    margin-top: 40px;
}

.description h3 {
    font-size: 14px;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #333333;
    font-weight: normal;
}

.description p {
    font-size: 14px;
    color: #666666;
    line-height: 1.8;
    margin-bottom: 15px;
}

.notes {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 40px;
    padding: 40px 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.note-box {
    flex: 1;
    min-width: 200px;
    max-width: 280px;
    background: #ffffff;
    padding: 20px;
    text-align: center;
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.note-box:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.note-box h4 {
    font-size: 12px;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #333333;
    font-weight: normal;
}

.note-box p {
    font-size: 13px;
    color: #666666;
    line-height: 1.6;
    font-style: italic;
}

.similar-products {
    padding: 60px 20px;
    background: #fafafa;
}

.similar-products h3 {
    font-size: 18px;
    margin-bottom: 40px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #333333;
    font-weight: normal;
}

.similar-products .product-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.similar-products .product-card {
    background: #ffffff;
    overflow: hidden;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    width: 250px;
    border: 1px solid #f0f0f0;
}

.similar-products .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.similar-products .product-image-frame {
    background: #f8f8f8;
    overflow: hidden;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.similar-products .product-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.similar-products .product-image img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
    transition: opacity 0.4s ease;
}

.similar-products .img-hover {
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.similar-products .product-card:hover .img-hover {
    opacity: 1;
}

.similar-products .product-card:hover .img-default {
    opacity: 0;
}

.similar-products .product-card .product-info {
    padding: 20px 15px;
}

.similar-products .product-card p {
    margin: 8px 0;
    font-size: 13px;
    color: #666666;
}

.similar-products .product-card p:first-child {
    font-size: 14px;
    color: #333333;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: normal;
}

.similar-products .product-card p:nth-of-type(2) {
    font-size: 12px;
    color: #888888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.similar-products .product-card p:last-of-type {
    color: #333333;
    font-weight: normal;
    font-size: 14px;
    margin-top: 10px;
}

.similar-products .product-card p:last-of-type::before {
    content: "€";
    margin-right: 2px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        gap: 30px;
        padding: 20px 15px;
    }
    
    .image-container,
    .product-details {
        max-width: 100%;
    }
    
    .product-details h2 {
        font-size: 28px;
    }
    
    .notes {
        flex-direction: column;
        gap: 20px;
    }
    
    .similar-products .product-grid {
        justify-content: center;
    }
    
    .similar-products .product-card {
        width: 200px;
    }
}
</style>

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
            <div class="quantity-control">
                <button type="button" class="quantity-btn" id="qty-minus">-</button>
                <input type="number" class="quantity-input" id="qty-input" value="1" min="1" max="4">
                <button type="button" class="quantity-btn" id="qty-plus">+</button>
            </div>
            <button class="add-to-cart">ADD TO CART</button>
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
            <a href="product.php?id=<?= $similarProduct['idPerfume'] ?>" class="product-card-link">
        <div class="product-card">
            <div class="product-image-frame">
                <div class="product-image">
                    <img src="perfume/<?= $similarProduct['urlImage'] ?>" alt="Product" class="img-default">
                    <img src="perfume/<?= $similarProduct['urlHover'] ?>" alt="Product Hover" class="img-hover">
                </div>
            </div>
            <div class="product-info">
                <p><?= $similarProduct['perfumeName'] ?></p>
                <p><?= $similarProduct['collectionName'] ?></p>
                <p><?= $similarProduct['price'] ?></p>
            </div>
        </div>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<!-- ---------- IMAGE ZOOM SCRIPT ---------- -->
<script>
    const imageContainer = document.getElementById("image-container");
    const productImage = document.getElementById("product-image");

    imageContainer.addEventListener("mousemove", (e) => {
        const rect = imageContainer.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        productImage.style.transformOrigin = `${x}% ${y}%`;
        productImage.style.transform = "scale(2)";
    });

    imageContainer.addEventListener("mouseleave", () => {
        productImage.style.transform = "scale(1)";
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
        qtyInput.value = value + 1;
    });

    qtyInput.addEventListener('input', function() {
        let value = parseInt(qtyInput.value, 10);
        if (isNaN(value) || value < 1) {
            qtyInput.value = 1;
        }
    });
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
