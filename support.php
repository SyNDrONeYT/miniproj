<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Support Us</title>
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
      </ul>
    </div>
  </nav>

  <section class="support-section">
    <div class="container">
      <h1>Support Sports Co-op</h1>
      <p>We appreciate your interest in supporting us! By donating to Sports Co-op, you help us continue to bring top-quality sports products and services to athletes everywhere.</p>
      <button><a href="donate.php" class="btn">Donate Now</a></button>
    </div>
  </section>
</body>
</html>
