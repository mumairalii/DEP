<?php
function get_featured_products($conn, $limit = 4) {
    $sql = "SELECT * FROM products WHERE featured = 1 LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_product($conn, $id) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function add_to_cart($product_id, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function get_cart_items($conn) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }

    $cart_items = [];
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product = get_product($conn, $product_id);
        $product['quantity'] = $quantity;
        $cart_items[] = $product;
    }

    return $cart_items;
}