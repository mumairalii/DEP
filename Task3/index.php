<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$featured_products = get_featured_products($conn, 4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>E-commerce Store</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products/index.php">Products</a></li>
                <li><a href="cart/index.php">Cart</a></li>
                <li><a href="admin/index.php" class="admin-button">Admin</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <div class="container">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                    <div class="product-info">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <a href="products/product.php?id=<?php echo $product['id']; ?>" class="btn">View Product</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>