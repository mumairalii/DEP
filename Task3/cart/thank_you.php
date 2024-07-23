<?php
if (!isset($_GET['order_id'])) {
    header('Location: ../index.php');
    exit();
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - E-commerce Store</title>
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
        <h2>Thank You for Your Order</h2>
        <p>Your order has been successfully placed. Your order ID is: <?php echo htmlspecialchars($order_id); ?></p>
        <p>We'll process your order soon and send you a confirmation email with shipping details.</p>
        <a href="../index.php" class="btn">Continue Shopping</a>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>