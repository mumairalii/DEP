<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    $sql = "INSERT INTO products (name, description, price, image_url, featured) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdsi", $name, $description, $price, $image_url, $featured);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Product added successfully!";
    } else {
        $error_message = "Error adding product: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - E-commerce Store</title>
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
        <h2>Add New Product</h2>
        <?php
        if (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
        <form action="" method="POST">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image_url">Image URL:</label>
            <input type="url" id="image_url" name="image_url" required>

            <label for="featured">
                <input type="checkbox" id="featured" name="featured">
                Featured Product
            </label>

            <button type="submit" class="btn">Add Product</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 E-commerce Store. All rights reserved.</p>
    </footer>
</body>
</html>