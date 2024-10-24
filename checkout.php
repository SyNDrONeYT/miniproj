<?php
session_start();

// Capture the total amount passed from the cart page
$total_amount = $_POST['total_amount'] ?? 0;

if ($total_amount <= 0) {
    // Redirect to cart if total amount is zero or invalid
    header("Location: cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="istyle.css"> <!-- External CSS file -->
</head>
<body>
    <section class="checkout-section">
        <div class="container">
            <h1>Payment Options</h1>
            <p>Total Amount: ₹<?php echo htmlspecialchars($total_amount); ?></p>

            <form method="POST" action="payment.php">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">

                <div class="form-group">
                    <label for="payment_method">Choose Payment Method:</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="card">Credit/Debit Card</option>
                        <option value="gpay">Google Pay</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>

                <button type="submit" class="btn">Proceed to Pay</button>
            </form>
        </div>
    </section>
</body>
</html>
