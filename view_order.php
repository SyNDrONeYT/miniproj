<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include('connection.php');

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // Fetch order details
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Fetch products associated with the order
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Order</title>
    <link rel="stylesheet" href="lstyle.css">
</head>
<body>
    <div class="container">
        <h1>Order Details</h1>

        <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
        <p><strong>User ID:</strong> <?php echo $order['user_id']; ?></p>
        <p><strong>Total Amount:</strong> $<?php echo htmlspecialchars($order['total_amount']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>

        <h2>Order Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $order_items->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $item['product_id']; ?></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <form method="post" action="logout.php">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
