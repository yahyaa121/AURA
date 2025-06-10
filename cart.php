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
    <title>Mon Panier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css" type="text/css">
</head>
<body>
<div class="cart-container">
    <h2 class="cart-title">Cart</h2>

    <?php if (!empty($cart)) :
        $ids = implode(',', array_keys($cart));
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
                        <img src="perfume/<?= $row['urlImage'] ?? 'default.jpg'; ?>" alt="<?= $row['perfumeName']; ?>" class="product-img">
                        <span class="product-name"><?= $row['perfumeName']; ?></span>
                    </td>
                    <td><?= number_format($row['price'], 2); ?> €</td>
                    <td>
                        <input type="number" min="1" class="qty-input" data-id="<?= $id; ?>" data-price="<?= $row['price']; ?>" value="<?= $quantity; ?>">
                        <span class="update-msg" style="display:none; color: green; font-size: 12px; margin-left: 5px;">Updated ✓</span>
                    </td>
                    <td class="subtotal" data-id="<?= $id; ?>"><?= number_format($subtotal, 2); ?> €</td>
                    <td>
                        <a href="cart.php?remove=<?= $id; ?>" class="remove-btn" onclick="return confirm('Delete this product?')">✖</a>
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
            <div class="cart-actions">
                <a href="cart.php?clear=1" class="clear-cart-btn" onclick="return confirm('Voulez-vous vraiment vider le panier ?')">Empty the cart</a>
            </div>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>
    <?php else : ?>
        <p class="empty-msg">Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>

<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', function () {
        const id = this.dataset.id;
        const qty = parseInt(this.value);
        const price = parseFloat(this.dataset.price);

        if (qty < 1) {
            alert("The minimum is 1.");
            this.value = 1;
            return;
        }

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
                    const q = parseInt(inp.value);
                    const p = parseFloat(inp.dataset.price);
                    total += q * p;
                });
                document.getElementById('cart-total').textContent = total.toFixed(2) + ' €';
            } else {
                alert("Erreur : " + data.message);
            }
        });
    });
});
</script>

</body>
</html>
