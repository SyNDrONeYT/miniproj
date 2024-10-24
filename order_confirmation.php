<?php
session_start();
include('connection.php'); // Include the MySQLi database connection

// Redirect to checkout page if the form hasn't been submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

// Retrieve user details from POST request
$name = isset($_POST['name']) ? $_POST['name'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Initialize variables for order summary
$order_summary = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_amount = 0;

// Calculate total amount
foreach ($order_summary as $item) {
    $total_amount += $item['price'];
}

// Store order in the database (this part is optional and should be implemented as needed)
// Example: Insert into orders table
// $stmt = $conn->prepare("INSERT INTO orders (name, address, phone, total_amount) VALUES (?, ?, ?, ?)");
// $stmt->bind_param("sssd", $name, $address, $phone, $total_amount);
// $stmt->execute();
// $stmt->close();

// Clear the cart after storing the order
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="istyle.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
            padding: 15px;
            color: white;
        }

        .navbar h2 {
            margin: 0;
            display: inline-block;
        }

        .navbar .nav {
            list-style: none;
            float: right;
            margin: 0;
            padding: 0;
        }

        .navbar .nav li {
            display: inline;
            margin-left: 20px;
        }

        .navbar .nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .confirmation-section {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .thank-you {
            text-align: center;
            margin: 20px 0;
            font-size: 1.2em;
            color: green;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-summary th, .order-summary td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .order-summary th {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h2>Sports Co-op</h2>
            <ul class="nav">
                <li><a href="products.php">Products</a></li>
                <li><a href="membership.php">Membership</a></li>
                <li><a href="support.php">Support Us</a></li>
                <li><a href="cart.php">Cart(<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <section class="confirmation-section">
        <h1>Thank You for Your Order!</h1>
        <div class="thank-you">Your order has been successfully placed.</div>
        
        <h2>Shipping Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_summary as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total Amount: ₹<?php echo $total_amount; ?></h3>
        </div>
        
        <a href="products.php" class="btn">Continue Shopping</a>
    </section>
</body>
</html>
