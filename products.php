<?php
session_start();
include('connection.php');  // Include the MySQLi database connection

// Ensure cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fetch products from the database using MySQLi
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Add product to the cart
if (isset($_POST['add_to_cart'])) {
    // Sanitize input to prevent tampering
  if (isset($_SESSION['user_id'])) {  
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    // Validate if the product exists in the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();
    $product = $product_result->fetch_assoc();

    if ($product) {
        // Check if the product is already in the cart
        $already_in_cart = false;
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['id'] == $product_id) {
                $already_in_cart = true;
                break;
            }
        }

        // Add the product to the cart if not already added
        if (!$already_in_cart) {
            $_SESSION['cart'][] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price']];
        } else {
            echo "<script>alert('Product already in cart!');</script>";
        }
    } else {
        echo "<script>alert('Invalid product!');</script>";
    }
  }
} else{
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="istyle.css">
  

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
        <li><a href="cart2.php" class="cart">Cart(<?php echo count($_SESSION['cart']); ?>)</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </div>
  </nav>

  <section class="product-section">
    <div class="container">
      <h1>Our Products</h1>
      <div class="product-grid">
        <?php if (count($products) > 0): ?>
          <?php foreach ($products as $product): ?>
            <div class="product-item">
              <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
              <p>₹<?php echo htmlspecialchars($product['price']); 
				  	$_SESSION['amount'] = $product['price'];
				  ?></p>
              <form method="POST" action="products.php">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No products available at the moment.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</body>
</html>
