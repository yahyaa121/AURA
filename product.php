<?php include('include/header.php'); ?>
<style>
  body {
    background-color: #f8f8f6;
    color: #1e1e1e;
    font-family: 'Futura', 'Trebuchet MS', 'Segoe UI', sans-serif;
}

.product-details {
    background-color: #fffdf8;
    box-shadow: 0 6px 28px rgba(0, 0, 0, 0.07);
}

.container {
    display: flex;
    flex-wrap: wrap;
    gap: 80px;
    padding: 80px 60px;
    justify-content: center;
    align-items: flex-start;
}

.image-container {
    flex: 1;
    max-width: 500px;
    border: none;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    border-radius: 0;
    width: 100%;
}

.product-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    background-color: #fdfdfd;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    max-width: 500px;
}

.product-details h2 {
    font-size: 34px;
    font-weight: 600;
    margin-bottom: 14px;
    font-family: 'Futura', sans-serif;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 1px;
    line-height: 1.2;
    text-align: left;
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 10px;
}

.product-details p {
    margin: 8px 0;
    font-size: 15px;
    color: #444;
}

.quantity-and-cart {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.quantity-control {
    display: flex;
    align-items: center;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #fff;
    overflow: hidden;
    height: 38px;
}

.quantity-btn {
    width: 32px;
    height: 38px;
    font-size: 18px;
    background: #f5f5f5;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}

.quantity-btn:active {
    background: #e5e5e5;
}

.quantity-input {
    width: 40px;
    height: 38px;
    text-align: center;
    font-size: 15px;
    border: none;
    outline: none;
}

.add-to-cart {
    background-color: #1a1a1a;
    text-transform: uppercase;
    font-family: 'Cormorant Garamond', serif;
    letter-spacing: 1px;
    padding: 12px 30px;
    font-size: 16px;
    border-radius: 0;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.add-to-cart:hover {
    background-color: #222;
}

.wishlist {
    margin-top: 14px;
    font-size: 13px;
    color: #777;
    cursor: pointer;
}
.wishlist:hover {
    color: #b12704;
    text-decoration: underline;
}

.description {
    padding: 40px 60px;
    text-align: center;
    max-width: 800px;
    margin: auto;
}

.description h3 {
    font-size: 20px;
    margin-bottom: 14px;
}

.notes {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    padding: 40px 60px;
}

.note-box {
    flex: 1;
    width: 100px;
    min-width: 180px;
    background: #ffffff;
    padding: 24px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    text-align: center;
    transition: box-shadow 0.3s ease, background-color 0.3s ease;
}

.note-box:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    background-color: #fffdf9;
}

.note-box h4 {
    font-size: 16px;
    margin-bottom: 8px;
}

.similar-products {
    padding: 50px 30px;
}

.similar-products h3 {
    font-size: 20px;
    margin-bottom: 24px;
    text-align: center;
}

.similar-products .product-grid {
    display: flex; /* FLEX au lieu de GRID */
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 30px;
    max-width: 1100px;
    margin: 0 auto;
}

.similar-products .product-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    width: 200px;
}

.similar-products .product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.similar-products .product-image-frame {
    background: #fff;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
}

.similar-products .product-image {
    width: 100%;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.similar-products .product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: opacity 0.4s ease;
    position: relative;
}

.similar-products .img-hover {
    opacity: 0;
    position: absolute;
}

.similar-products .product-card:hover .img-hover {
    opacity: 1;
}

.similar-products .product-card p {
    margin: 8px 0;
    font-size: 14px;
    color: #333;
}

.similar-products .product-card p:nth-of-type(2) {
    font-weight: bold;
    font-size: 15px;
}

.similar-products .product-card p:last-of-type {
    color: #b12704;
    font-weight: bold;
    font-size: 16px;
}
.similar-products .product-card p:last-of-type::before {
    content: "€";
    margin-right: 4px;
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
        <p><strong>Price :</strong> <?= $product['price'] ?>€</p>
        <p><strong>Elements of Perfume :</strong> <?= $product['fragranceFamily'] ?></p>
        <p><strong>Type of Perfume :</strong> Eau de Parfum</p>
        <p>50 ml @ 1.7 FL.OZ. SPRAY</p>

        <div class="quantity-and-cart">
            <div class="quantity-control">
                <button type="button" class="quantity-btn" id="qty-minus">-</button>
                <input type="number" class="quantity-input" id="qty-input" value="1" min="1" max="4">
                <button type="button" class="quantity-btn" id="qty-plus">+</button>
            </div>
            <button class="add-to-cart">Add to Cart</button>
        </div>

        <div class="wishlist">♡ Add to wishlist</div>
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
        <h4>TOP NOTES</h4>
        <p><?= $product['topNotes'] ?></p>
    </div>
    <div class="note-box">
        <h4>HEART NOTES</h4>
        <p><?= $product['middleNotes'] ?></p>
    </div>
    <div class="note-box">
        <h4>BASE NOTES</h4>
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
    <h3>Similar products</h3>
    <div class="product-grid">
        <?php while ($similarProduct = $resultSimilar->fetch_assoc()) : ?>
        <div class="product-card">
            <div class="product-image-frame">
                <div class="product-image">
                    <img src="perfume/<?= $similarProduct['urlImage'] ?>" alt="Product" class="img-default">
                    <img src="perfume/<?= $similarProduct['urlHover'] ?>" alt="Product Hover" class="img-hover">
                </div>
            </div>
            <p><?= $similarProduct['perfumeName'] ?></p>
            <p><?= $similarProduct['collectionName'] ?></p>
            <p><?= $similarProduct['price'] ?></p>
        </div>
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

<?php include('include/footer.php'); ?>
