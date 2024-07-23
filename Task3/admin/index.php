<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

// Simple authentication (you should implement a more secure system)
if (!isset($_SESSION['admin']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'password') {
        $_SESSION['admin'] = true;
    }
}

if (!isset($_SESSION['admin'])) {
    // Show login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - E-commerce Store</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <h1>E-commerce Store Admin</h1>
        </header>
        <main>
            <h2>Admin Login</h2>
            <form action="" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn">Login</button>
            </form>
        </main>
        <footer>
            <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
        </footer>
    </body>
    </html>
    <?php
    exit();
}

// Admin dashboard
$sql = "SELECT COUNT(*) as product_count FROM products";
$result = mysqli_query($conn, $sql);
$product_count = mysqli_fetch_assoc($result)['product_count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-commerce Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>E-commerce Store Admin</h1>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="../index.php">View Site</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Admin Dashboard</h2>
        <p>Total Products: <?php echo $product_count; ?></p>
        <a href="add_product.php" class="btn">Add New Product</a>
    </main>
    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>
