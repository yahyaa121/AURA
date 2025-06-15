<?php
session_start();

// Vider tout le panier si demandé
if (isset($_GET['clear']) && $_GET['clear'] == 1) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// Supprimer un article si demandé
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
    }
    header('Location: cart.php');
    exit;
}

require 'database.php';
include 'include/header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CART</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css" type="text/css">
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<div class="cart-container">
    <h2 class="cart-title">
        Cart
        <?php if (!empty($cart)): ?>
            <span class="cart-badge"><?= array_sum($cart); ?> item<?= array_sum($cart) > 1 ? 's' : ''; ?></span>
        <?php endif; ?>
    </h2>

    <?php
    $idsArray = array_filter(array_keys($cart), function($k) { return is_numeric($k) && $k > 0; });
    if (!empty($idsArray)) {
        $ids = implode(',', $idsArray);
        $result = $mysqli->query("SELECT * FROM perfumes NATURAL JOIN perfumeimage WHERE idPerfume IN ($ids)");
    ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Perfume</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) :
                $id = $row['idPerfume'];
                $quantity = $cart[$id];
                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;
            ?>
                <tr>
                    <td class="product-info">
                        <a href="product.php?id=<?= $row['idPerfume']; ?>">
                            <img src="perfumes/<?= $row['urlImage'] ?? 'default.jpg'; ?>" alt="<?= $row['perfumeName']; ?>" class="product-img">
                        </a>
                        <span class="product-name"><?= $row['perfumeName']; ?></span>
                    </td>
                    <td><?= number_format($row['price'], 2); ?> €</td>
                    <td>
                        <input type="number" name="quantity" min="1" max="5" value="<?= $quantity; ?>" class="qty-input" data-id="<?= $id; ?>" data-price="<?= $row['price']; ?>">
                        <span class="update-msg" style="display:none; color: green; font-size: 12px; margin-left: 5px;">Updated ✓</span>
                    </td>
                    <td class="subtotal" data-id="<?= $id; ?>"><?= number_format($subtotal, 2); ?> €</td>
                    <td>
                        <a href="cart.php?remove=<?= $id; ?>" class="remove-btn" title="Remove" onclick="return confirm('Delete this product?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total-label">Total</td>
                    <td colspan="2" class="total-value" id="cart-total"><?= number_format($total, 2); ?> €</td>
                </tr>
            </tfoot>
        </table>
        <div class="checkout-btn-container">
            <div class="cart-actions-group">
                <a href="perfume.php" class="continue-shopping-btn"> Continue Shopping</a>
                <a href="cart.php?clear=1" class="clear-cart-btn" onclick="return confirm('Voulez-vous vraiment vider le panier ?')">Empty the cart</a>
            </div>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>
    <?php
    } else {
        echo '<div class="cart-empty-section">
                <div class="cart-empty-icon">
                    <i class="fas fa-shopping-cart" style="font-size:64px; color:#2daeba;"></i>
                </div>
                <div class="cart-empty-title">Your cart is empty</div>
                <div class="cart-empty-message">
                    Looks like you haven’t added anything yet.<br>
                    Discover our latest arrivals and find your favorite scent!
                </div>
                <a href="perfume.php" class="cart-empty-btn">Browse Perfumes</a>
            </div>';
    }
    ?>
</div>
<br><br><br><br>
<?php include 'include/footer.php'; ?>

<script>
document.querySelectorAll('.qty-input').forEach(input => {
    // Handle change event (AJAX update)
    input.addEventListener('change', function () {
        let qty = parseInt(this.value, 10);
        if (isNaN(qty) || qty < 1) qty = 1;
        if (qty > 5) qty = 5;
        this.value = qty;

        const id = this.dataset.id;
        const price = parseFloat(this.dataset.price);

        fetch('update_cart_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `idPerfume=${id}&quantity=${qty}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // ✅ Message de confirmation
                const msg = this.nextElementSibling;
                msg.style.display = 'inline';
                msg.style.opacity = '1';

                setTimeout(() => {
                    msg.style.transition = 'opacity 0.5s';
                    msg.style.opacity = '0';
                }, 1000);
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 1500);

                // ✅ Sous-total de la ligne
                const subtotal = (qty * price).toFixed(2);
                const subtotalCell = document.querySelector(`.subtotal[data-id="${id}"]`);
                if (subtotalCell) subtotalCell.textContent = `${subtotal} €`;

                // ✅ Recalcul du total global
                let total = 0;
                document.querySelectorAll('.qty-input').forEach(inp => {
                    const q = parseInt(inp.value, 10) || 1;
                    const p = parseFloat(inp.dataset.price);
                    total += q * p;
                });
                document.getElementById('cart-total').textContent = total.toFixed(2) + ' €';

                const row = this.closest('tr');
                row.classList.add('updated');
                setTimeout(() => row.classList.remove('updated'), 700);
            } else {
                alert("Erreur : " + data.message);
            }
        });
    });

    // Handle input event (UI feedback)
    input.addEventListener('input', function () {
        let value = this.value;
        if (value === '') return; // Allow empty while typing
        let qty = parseInt(value, 10);
        if (isNaN(qty) || qty < 1) this.value = 1;
        if (qty > 5) this.value = 5;
    });

    // Handle blur event (reset empty to 1)
    input.addEventListener('blur', function () {
        if (this.value === '' || isNaN(parseInt(this.value, 10))) {
            this.value = 1;
        }
    });
});

const input = document.getElementById('quantityInput');
const message = document.getElementById('quantityMessage');

input.addEventListener('input', function() {
    let value = parseInt(this.value, 10);

    if (isNaN(value) || value < 1) {
        this.value = 1;
        message.style.display = 'none';
    } else if (value > 5) {
        this.value = 5;
        message.style.display = 'inline';
    } else {
        message.style.display = 'none';
    }
});

document.querySelectorAll('input[name="quantity"]').forEach(function(input) {
    input.addEventListener('input', function() {
        if (parseInt(this.value) > 5) this.value = 5;
        if (parseInt(this.value) < 1) this.value = 1;
    });
});
</script>

</body>
</html>
