<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Index</title>
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
  <section class="main">
    <div class="main-container">
      <div>
        <h2>Comfort of the Year</h2>
        <h1>We bring you The Best Products!</h1>
        <p>At Sports Co-op, we are dedicated to bringing you the best sports products available. Whether you're a seasoned athlete or just starting your fitness journey, our carefully curated selection features top-quality gear from the most trusted brands. We pride ourselves on offering the latest innovations in sports equipment, apparel, and accessories to help you achieve your goals. Shop with confidence knowing that every product is chosen with your performance and satisfaction in mind. Elevate your game with us today!</p>
        <a href="products.php" class="btn main-btn">Show more</a>
      </div>
      <img src="3.png" alt="">
    </div>
  </section>

  <section class="secondary">
    <div class="second-container">
      <div class="overlay"></div>
      <img src="2.png"alt="">
      <div class="content">
          <h1>Our Flagship product</h1>
          <h3>Check it out on <strong>Products</strong></h3>
         <p>Introducing our flagship product at Sports Co-op, designed to set new standards in performance and quality. This exceptional piece of equipment has been meticulously crafted to meet the demands of athletes who seek the best. Whether you're training for a competition or simply looking to enhance your workout, our flagship product delivers unmatched durability, comfort, and efficiency. Experience the pinnacle of sports innovation with this standout item, and see why it's become a favorite among top performers. Elevate your game with the best—only at Sports Co-op!</p>
          <a href="products.php" class="show">Show More</a>
          <a href="products.php" class="check">Checkout</a>
      </div>
    </div>
  </section> 
</body>
</html>