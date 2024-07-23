<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

$cart_items = get_cart_items($conn);
$total = 0;

foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - E-commerce Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>E-commerce Store</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../products/index.php">Products</a></li>
                <li><a href="index.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Your Cart</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>