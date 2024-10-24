<?php
session_start();
include('connection.php');

// Check if payment details are present in the session
if (!isset($_SESSION['payment'])) {
    header("Location: index.php");
    exit();
}

$paymentDetails = $_SESSION['payment'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
    $payment_status = "Success"; // Mock payment success for this demo

    // Process payment based on payment type
    if ($paymentDetails['type'] == 'donation') {
        $name = $paymentDetails['name'];
        $email = $paymentDetails['email'];
        $amount = $paymentDetails['amount'];

        // Insert donation record into the database
        $query = "INSERT INTO donations (name, email, amount, payment_method, payment_status) VALUES ('$name', '$email', '$amount', 'Card', '$payment_status')";
        mysqli_query($conn, $query);

    } elseif ($paymentDetails['type'] == 'membership') {
        $user_id = $paymentDetails['user_id'];
        $membership_plan = $paymentDetails['membership_plan'];

        // Update membership plan in the users table
        $query = "UPDATE users SET membership_plan = '$membership_plan', payment_method = 'Card', payment_status = '$payment_status' WHERE id = '$user_id'";
        mysqli_query($conn, $query);

    } elseif ($paymentDetails['type'] == 'cart') {
        $user_id = $_SESSION['user_id'];

        // Process each item in the cart and insert into the orders table
        foreach ($paymentDetails['items'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $query = "INSERT INTO orders (user_id, product_id, quantity, total_price, payment_method, payment_status) VALUES ('$user_id', '$product_id', '$quantity', '$price', 'Card', '$payment_status')";
            mysqli_query($conn, $query);
        }
    }

    // Clear the payment session
    unset($_SESSION['payment']);

    // Redirect to thank you page
    header("Location: thankyou.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Payment</title>
    <link rel="stylesheet" href="istyle.css">
</head>
<body>
    <section class="card-payment-section">
        <div class="container">
            <h1>Enter Your Card Details</h1>
            <form method="POST" action="card_payment.php">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($paymentDetails['amount']); ?>">

                <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" required>
                </div>

                <div class="form-group">
                    <label for="card_expiry">Expiry Date (MM/YYYY):</label>
                    <input type="text" id="card_expiry" name="card_expiry" required placeholder="MM/YYYY">
                </div>

                <div class="form-group">
                    <label for="card_cvc">CVC:</label>
                    <input type="text" id="card_cvc" name="card_cvc" required>
                </div>

                <button type="submit" class="btn">Pay Now</button>
            </form>
        </div>
    </section>
</body>
</html>
