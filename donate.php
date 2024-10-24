<?php
session_start();
include('connection.php'); // Include the database connection

// Check if the user is logged in before allowing them to donate
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Process donation form submission
if (isset($_POST['donate'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO donations (name, email, amount) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssi", $name, $email, $amount); // "ssi" means string, string, integer types
        if ($stmt->execute()) {
            // Store the donation details in the session for payment processing
            $_SESSION['payment'] = [
                'type' => 'donation',
                'name' => $name,
                'email' => $email,
                'amount' => $amount
            ];

            // Thank you message or redirect to payment page
            $_SESSION['message'] = "Thank you for your donation!";
        } else {
            $_SESSION['message'] = "Error processing your donation. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to prepare the database statement.";
    }

    // Redirect to the payment page for completing the donation
    header("Location: payment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donate Now</title>
  <link rel="stylesheet" href="istyle.css">
</head>
<body>
  <nav class="navbar">
    <div class="container">
      <h2>Sports Co-op</h2>
      <ul class="nav">
        <li><a href="products.php">Products</a></li>
        <li><a href="membership.php">Membership</a></li>
        <li><a href="support.php">Support Us</a></li>
        <li><a href="cart.php" class="cart">Cart(<?php echo count($_SESSION['cart'] ?? []); ?>)</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </div>
  </nav>

  <section class="donate-section">
    <div class="container">
      <h1>Support Us with a Donation</h1>

      <?php
      if (isset($_SESSION['message'])) {
          echo "<p class='thank-you'>" . $_SESSION['message'] . "</p>";
          unset($_SESSION['message']);
      }
      ?>

      <form method="POST" action="donate.php">
        <div class="form-group">
          <label for="name">Full Name:</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="amount">Donation Amount (₹):</label>
          <input type="number" id="amount" name="amount" required min="1" step="any">
        </div>

        <button type="submit" name="donate" class="btn">Donate Now</button>
      </form>
    </div>
  </section>
</body>
</html>
