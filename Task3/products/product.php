<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$product = get_product($conn, $_GET['id']);

if (!$product) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    add_to_cart($product['id'], $quantity);
    header('Location: ../cart/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - E-commerce Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>E-commerce Store</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="index.php">Products</a></li>
                <li><a href="../cart/index.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="product-details">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            <h2><?php echo $product['name']; ?></h2>
            <div class="product-info">
            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
            <p><?php echo $product['description']; ?></p>
            <form action="" method="POST">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                <button type="submit" class="btn">Add to Cart</button>
            </form>
</div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>

