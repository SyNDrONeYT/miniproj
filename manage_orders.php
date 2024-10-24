<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch all orders
$sql = "SELECT orders.*, users.first_name, users.last_name FROM orders JOIN users ON orders.user_id = users.id";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching orders: " . $conn->error);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <nav class="navbar">
        <h2>Manage Orders</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_orders.php">Manage Orders</a></li>
            <li>
                <form method="post" action="logout.php">
                    <button type="submit" name="logout" class="button-secondary">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h1>All Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td>₹<?php echo htmlspecialchars($order['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td class="table-actions">
                        <a href="edit_order.php?id=<?php echo $order['id']; ?>">Edit</a>
                        <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
