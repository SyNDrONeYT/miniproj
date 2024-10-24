<?php
session_start();
include('connection.php'); // Include database connection

// Check if the user is logged in before allowing them to choose membership
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Process membership form submission
if (isset($_POST['choose_membership'])) {
    $membership_plan = $_POST['membership_plan'];
    $user_id = $_SESSION['user_id'];

    // Update the membership plan in the database
    $stmt = $conn->prepare("UPDATE users SET membership_plan = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $membership_plan, $user_id); // "si" means string and integer types
        if ($stmt->execute()) {
            // Store membership details in session for payment processing
            $_SESSION['payment'] = [
                'type' => 'membership',
                'user_id' => $user_id,
                'membership_plan' => $membership_plan,
                'amount' => $membership_plan == 'Basic' ? 400 : ($membership_plan == 'Premium' ? 700 : 1000)
            ];
            $_SESSION['message'] = "You have successfully chosen the $membership_plan plan!";
        } else {
            $_SESSION['message'] = "Failed to update membership plan. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to prepare the database statement.";
    }

    // Redirect to the payment page
    header("Location: payment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plans</title>
    <link rel="stylesheet" href="istyle.css"> <!-- Link to external CSS -->
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

    <section class="membership-section">
        <div class="container">
            <h1>Choose Your Membership Plan</h1>
            <p>At Sports Co-op, we offer various membership plans designed to meet the needs of all our customers. Whether you're looking for basic access or premium benefits, we have something for everyone.</p>

            <?php
            if (isset($_SESSION['message'])) {
                echo "<p class='thank-you'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>

            <div class="membership-options">
                <!-- Basic Membership Plan -->
                <div class="membership-plan">
                    <h3>Basic Plan</h3>
                    <p class="price">₹400/month</p>
                    <ul>
                        <li>Access to basic products</li>
                        <li>Monthly newsletter</li>
                        <li>Exclusive discounts</li>
                    </ul>
                    <form method="POST" action="membership.php">
                        <input type="hidden" name="membership_plan" value="Basic">
                        <button type="submit" name="choose_membership" class="btn" style="background-color: green; padding:5px; font-size: 20px;">Choose Plan</button>
                    </form>
                </div>

                <!-- Premium Membership Plan -->
                <div class="membership-plan">
                    <h3>Premium Plan</h3>
                    <p class="price">₹700/month</p>
                    <ul>
                        <li>Everything in Basic Plan</li>
                        <li>Access to premium products</li>
                        <li>Priority customer support</li>
                        <li>Free shipping on orders</li>
                    </ul>
                    <form method="POST" action="membership.php">
                        <input type="hidden" name="membership_plan" value="Premium">
                        <button type="submit" name="choose_membership" class="btn" style="background-color: green; padding:5px; font-size: 20px;">Choose Plan</button>
                    </form>
                </div>

                <!-- VIP Membership Plan -->
                <div class="membership-plan">
                    <h3>VIP Plan</h3>
                    <p class="price">₹1000/month</p>
                    <ul>
                        <li>All Premium Plan benefits</li>
                        <li>Personalized product recommendations</li>
                        <li>Early access to new releases</li>
                        <li>Exclusive VIP events</li>
                    </ul>
                    <form method="POST" action="membership.php">
                        <input type="hidden" name="membership_plan" value="VIP">
                        <button type="submit" name="choose_membership" class="btn" style="background-color: green; padding:5px; font-size: 20px;">Choose Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
