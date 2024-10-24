<?php
// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session and include connection
session_start();
include('connection.php');

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the user details from the session and database
$user_id = $_SESSION['user_id'];

$sql = "SELECT first_name, last_name, dob, email, address, phone_number FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Fetch user's order history from the 'orders' table
$order_sql = "SELECT * FROM orders WHERE user_id = ?";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$orders = $order_result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="lstyle.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>

        <!-- Display user information -->
        <div class="profile-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
        </div>

        <div style="padding-bottom: 5px;">
            <form method="post" action="index.php">
                <button type="submit" name="home">Go back home</button>
            </form>
        </div>

        <!-- Logout button -->
        <form method="post" action="logout.php">
            <button type="submit" name="logout">Logout</button>
        </form>

        <!-- Display order history -->
        <h2>Your Order History</h2>
        <?php if (!empty($orders)): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Products</th>
                    <th>Total Amount (₹)</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['products']); ?></td>
                    <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>You have not placed any orders yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
