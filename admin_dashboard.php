<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <nav class="navbar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_orders.php">Manage Orders</a></li>
            <li><form method="post" action="logout.php"><button type="submit" name="logout" class="button-secondary">Logout</button></form></li>
        </ul>
    </nav>

    <div class="container">
        <div class="dashboard-cards">
            <div class="card">
                <h3>Products</h3>
                <p>Manage your product catalog.</p>
                <a href="manage_products.php" class="button-primary">Go to Products</a>
            </div>
            <div class="card">
                <h3>Users</h3>
                <p>Manage registered users.</p>
                <a href="manage_users.php" class="button-primary">Go to Users</a>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <p>Track and manage orders.</p>
                <a href="manage_orders.php" class="button-primary">Go to Orders</a>
            </div>
        </div>
    </div>
</body>
</html>
