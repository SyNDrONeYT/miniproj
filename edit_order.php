<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if (isset($_POST['update_order'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the order's status in the database
    $sql = "UPDATE orders SET status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header('Location: manage_orders.php');
        exit();
    } else {
        echo "Error updating order: " . $conn->error;
    }
}

// Fetch order data for the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM orders WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
} else {
    header('Location: manage_orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Order</h1>
        <form method="POST" action="edit_order.php">
            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
            <label for="status">Status</label>
            <select name="status">
                <option value="pending" <?php if($order['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                <option value="completed" <?php if($order['status'] === 'completed') echo 'selected'; ?>>Completed</option>
                <option value="canceled" <?php if($order['status'] === 'canceled') echo 'selected'; ?>>Canceled</option>
            </select>
            <button type="submit" name="update_order">Update Order</button>
        </form>
        <a href="manage_orders.php">Back to Manage Orders</a>
    </div>
</body>
</html>
