<?php
session_start();

if (isset($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

$paymentDetails = $_SESSION['cart'];

// Clear the session data
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You</title>
  <link rel="stylesheet" href="istyle.css"> <!-- Link to external CSS -->
</head>
<body>
  <section class="thankyou-section">
    <div class="container">
      <h1>Thank You!</h1>
      <p>Your payment for <strong><?php echo ucfirst($paymentDetails['type']); ?></strong> has been successfully processed.</p>
      <p><strong>Amount Paid:</strong> ₹<?php echo htmlspecialchars($paymentDetails['amount']); ?></p>

      <a href="index.php" class="btn">Return to Home Page</a>
    </div>
  </section>
</body>
</html>
