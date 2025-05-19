<?php include('include/header.php'); ?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        padding: 40px 80px;
        gap: 60px;
    }

    /* ----------- IMAGE ZOOM ----------- */
    .image-container {
        position: relative;
        width: 500px;
        height: 500px;
        overflow: hidden;
        border: 1px solid #ccc;
    }

    .product-image {
        width: 100%;
        height: 100%;
        transition: transform 0.2s ease;
        object-fit: contain; /* Ensures image fits fully in the container */
    }

    .product-details {
        flex: 1;
        padding-left: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color:rgb(231, 231, 231);
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .product-details h2 {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-details p {
        margin: 10px 0;
        color: #444;
        line-height: 1.5;
    }

    .brand-btn {
        background-color: #ddd;
        color: #333;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 15px;
        cursor: default;
    }

    /* ----------- CHOOSE OPTION AND BUTTON STYLES ----------- */
    .capacity-select {
        padding: 8px;
        font-size: 14px;  /* Smaller font size */
        border: 1px solid #ccc;
        margin-bottom: 15px;
        border-radius: 4px;
        width: 150px;  /* Smaller width */
    }

    .add-to-cart {
        padding: 10px 18px;  /* Smaller padding */
        background-color: black;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 14px;  /* Smaller font size */
        cursor: pointer;
        transition: background 0.3s;
        width: 180px;  /* Smaller width */
    }

    .add-to-cart:hover {
        background-color: #333;
    }

    .wishlist {
        margin-top: 12px;
        color: #666;
        cursor: pointer;
        font-size: 14px;
    }

    /* ----------- QUANTITY AND ADD TO CART INLINE ----------- */
    .quantity-and-cart {
        display: flex;
        align-items: center;
        gap: 15px; /* Adjust space between the quantity control and the button */
        margin-bottom: 20px;
    }

    /* ----------- DESCRIPTION ----------- */
    .description {
        padding: 40px;
        text-align: center;
        max-width: 900px;
        margin: auto;
        line-height: 1.6;
    }

    .notes {
        display: flex;
        justify-content: space-around;
        padding: 40px;
        text-align: center;
    }

    .note-box {
        width: 30%;
        background: #f8f8f8;
        padding: 20px;
    }

   /* ---------- SIMILAR PRODUCTS ---------- */
/* ---------- SIMILAR PRODUCTS ---------- */
.similar-products {
    padding: 40px;
}

.similar-products h3 {
    margin-bottom: 20px;
    font-size: 22px;
    text-align: center;
}

.similar-products .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.similar-products .product-card {
    text-align: center;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.similar-products .product-card:hover {
    transform: translateY(-8px);
}

.similar-products .product-card:hover .product-image-frame {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.similar-products .product-image-frame {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.similar-products .product-image {
    position: relative;
    width: 100%;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.similar-products .product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    position: absolute;
    transition: opacity 0.4s ease;
}

.similar-products .img-hover {
    opacity: 0;
}

.similar-products .product-card:hover .img-hover {
    opacity: 1;
}

.similar-products .product-card p {
    margin: 8px 0;
    font-size: 16px;
    color: #333;
}

.similar-products .product-card p:nth-of-type(2) {
    font-weight: bold;
    font-size: 18px;
}

.similar-products .product-card p:last-of-type {
    color: #a00;
    font-weight: bold;
}

</style>

<!-- ---------- MAIN CONTENT ---------- -->
<div class="container">
    <!-- IMAGE -->
    <div class="image-container" id="image-container">
        <img src="6.jpg" alt="Product Image" class="product-image" id="product-image">
    </div>

    <!-- DETAILS -->
    <div class="product-details">
        
        <h2>Name of Perfume</h2>
       
        <p><strong>Price:</strong> €99.99</p>
        <p><strong>Elements of Perfume:</strong> Floral, Citrus, Woody</p>
        <p><strong>Type of Perfume:</strong> Eau de Parfum</p>

        <p>
            50 ml @ 1.7 FL.OZ. SPRAY<br>
            100 ml @ 3.4 FL.OZ. VAPORISATEUR
        </p>

        <select class="capacity-select">
            <option>Choose an option</option>
            <option>50 ml</option>
            <option>100 ml</option>
        </select>

        <!-- New Flex Container for Quantity and Add to Cart button -->
        <div class="quantity-and-cart">
            <div class="quantity-control">
                <button>-</button>
                <input type="number" value="1" min="1" style="width: 50px; text-align:center;">
                <button>+</button>
            </div>
            <button class="add-to-cart">Add to Cart</button>
        </div>

        <div class="wishlist">♡ Add to wishlist</div>
    </div>
</div>

<!-- ---------- DESCRIPTION ---------- -->
<div class="description">
    <h3>DESCRIPTION</h3>
    <p>Lorem Ipsumora est une création immersive textuelle.</p>
    <p>
        Le verbe effervescent du Lorem s’entrelace avec la cadence délicate de l’Ipsum ; la syntaxe fluide épouse la rigueur du rythme tandis qu’en arrière-plan résonnent, comme une mélodie distante, les <strong>profondeurs</strong>.
    </p>
    <p>
        Silences éloquents, enveloppés d’une ponctuation subtile et maîtrisée.
    </p>
    <p><em>Lorem Ipsumora : l’essence du texte intemporel.</em></p>
</div>

<!-- ---------- NOTES ---------- -->
<div class="notes">
    <div class="note-box">
        <h4>TOP NOTES</h4>
        <p>Elements</p>
    </div>
    <div class="note-box">
        <h4>HEART NOTES</h4>
        <p>Elements</p>
    </div>
    <div class="note-box">
        <h4>BASE NOTES</h4>
        <p>Elements</p>
    </div>
</div>

<!-- ---------- SIMILAR PRODUCTS ---------- -->
<div class="similar-products">
    <h3>Similar products</h3>
    <div class="product-grid">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
        <div class="product-card">
            <div class="product-image-frame">
                <div class="product-image">
                    <img src="10.jpg" alt="Product" class="img-default">
                    <img src="hover8.jpg" alt="Product Hover" class="img-hover">
                </div>
            </div>
            <p>Name of perfume</p>
            <p>Brand Name</p>
            <p>€Price</p>
        </div>
        <?php endfor; ?>
    </div>
</div>

</div>

<!-- ---------- IMAGE ZOOM SCRIPT ---------- -->
<script>
    const imageContainer = document.getElementById("image-container");
    const productImage = document.getElementById("product-image");

    imageContainer.addEventListener("mousemove", (e) => {
        let rect = imageContainer.getBoundingClientRect();
        let x = (e.clientX - rect.left) / rect.width * 100;
        let y = (e.clientY - rect.top) / rect.height * 100;
        productImage.style.transformOrigin = `${x}% ${y}%`;
        productImage.style.transform = "scale(2)";
    });

    imageContainer.addEventListener("mouseleave", () => {
        productImage.style.transform = "scale(1)";
    });
</script>

<?php include('include/footer.php'); ?>
