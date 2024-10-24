<?php
session_start();

// Make sure the user has a valid session and the payment details exist

// Retrieve total amount from the session's payment details
$totalAmount = $_SESSION['total_amount'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <link rel="stylesheet" href="istyle.css">
</head>
<body>
    <section class="payment-section">
        <div class="container">
            <h1>Select Payment Method</h1>
            <p><strong>Total Amount: </strong> ₹<?php echo $totalAmount; ?></p>

            <form method="POST" action="process_payment.php">
                <div class="form-group">
                    <label>
                        <input type="radio" name="payment_method" value="card" required>
                        Credit/Debit Card
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" name="payment_method" value="upi" required>
                        UPI
                    </label>
                </div>
                <button type="submit" class="btn">Continue</button>
            </form>
        </div>
    </section>
</body>
</html>
