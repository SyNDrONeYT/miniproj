<?php
session_start();
include('connection.php'); // Include the MySQLi database connection

// Ensure cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle removing product from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id'] == $product_id) {
            //unset($_SESSION['cart'][$key]);
            // Reindex array after removal
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break;
        }
    }
}

// Handle updating product quantity
if (isset($_POST['update_cart'])) {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    // You can implement quantity update logic here if needed
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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

        .cart-section {
            max-width: 800px;
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

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .cart-table th, .cart-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .cart-table td {
            vertical-align: middle; /* Align content in the middle */
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .cart-total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .cart-actions a {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }

        .cart-actions .btn {
            width: 100%;
        }

        p {
            text-align: center;
            font-size: 18px;
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
                <li><a href="cart.php" class="cart">Cart(<?php echo count($_SESSION['cart']); ?>)</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <section class="cart-section">
        <div class="container">
            <h1>Your Cart</h1>
            <?php if (count($_SESSION['cart']) > 0): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $cart_item):
                            $item_total = $cart_item['price'];
                            $total += $item_total;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cart_item['name']); ?></td>
                            <td>₹<?php echo htmlspecialchars($cart_item['price']); ?></td>
                            <td>₹<?php echo $item_total; ?></td>
                            <td>
                                <form method="POST" action="cart.php" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($cart_item['id']); ?>">
                                    <button type="submit" name="remove_from_cart" class="btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">
                    <h2>Total: ₹<?php echo $total; ?></h2>
                </div>

                <div class="cart-actions">
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                    <a href="products.php" class="btn">Continue Shopping</a>
                </div>

            <?php else: ?>
                <p>Your cart is empty. <a href="products.php">Start shopping now!</a></p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
