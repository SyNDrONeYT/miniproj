<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Upload image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert product into database
    $sql = "INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdis", $name, $price, $stock, $image);
    $stmt->execute();

    header('Location: manage_products.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <nav class="navbar">
        <h2>Add New Product</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><form method="post" action="logout.php"><button type="submit" name="logout" class="button-secondary">Logout</button></form></li>
        </ul>
    </nav>

    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <label for="name">Product Name</label>
            <input type="text" name="name" required>
            
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" required>
            
            <label for="stock">Stock</label>
            <input type="number" name="stock" required>

            <label for="image">Product Image</label>
            <input type="file" name="image" required>

            <button type="submit" name="submit" class="button-primary">Add Product</button>
        </form>
    </div>
</body>
</html>
