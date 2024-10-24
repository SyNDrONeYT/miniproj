<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Upload image if provided
    if (!empty($image)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_sql = ", image='$image'";
    } else {
        $image_sql = "";
    }

    // Update product details
    $sql = "UPDATE products SET name=?, price=?, stock=? $image_sql WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $name, $price, $stock, $id);
    $stmt->execute();

    header('Location: manage_products.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <nav class="navbar">
        <h2>Edit Product</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><form method="post" action="logout.php"><button type="submit" name="logout" class="button-secondary">Logout</button></form></li>
        </ul>
    </nav>

    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <label for="name">Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>

            <label for="image">Product Image</label>
            <input type="file" name="image">

            <button type="submit" name="submit" class="button-primary">Update Product</button>
        </form>
    </div>
</body>
</html>
