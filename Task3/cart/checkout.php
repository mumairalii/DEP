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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the order (simplified version)
    $order_id = uniqid();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // In a real application, you would save the order details to the database
    // and process the payment here.

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to a thank you page
    header('Location: thank_you.php?order_id=' . $order_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - E-commerce Store</title>
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
        <h2>Checkout</h2>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <h3>Order Summary</h3>
            <ul>
                <?php foreach ($cart_items as $item): ?>
                    <li><?php echo $item['name']; ?> (x<?php echo $item['quantity']; ?>) - $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>

            <button type="submit" class="btn">Place Order</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>