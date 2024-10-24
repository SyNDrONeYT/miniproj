<?php
session_start();
include('connection.php'); // Include the database connection

// Check if payment details are present in the session
if (isset($_SESSION['cart'])) {
    header("Location: #");
    exit();
}

$paymentDetails = $_SESSION['cart'];
$payment_method = $_POST['payment_method'];
$payment_status = "Success"; // Assuming payment is successful

// Different processing based on payment type
if ($paymentDetails['type'] == 'donation') {
    // Insert the donation record into the database
    $stmt = $conn->prepare("INSERT INTO donations (name, email, amount, payment_method, payment_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $paymentDetails['name'], $paymentDetails['email'], $paymentDetails['amount'], $payment_method, $payment_status);

    if ($stmt->execute()) {
        // Donation successful
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

} elseif ($paymentDetails['type'] == 'membership') {
    // Update the membership plan in the users table
    $stmt = $conn->prepare("UPDATE users SET membership_plan = ?, payment_method = ?, payment_status = ? WHERE id = ?");
    $stmt->bind_param("ssii", $paymentDetails['membership_plan'], $payment_method, $payment_status, $paymentDetails['user_id']);

    if ($stmt->execute()) {
        // Membership update successful
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

} elseif ($paymentDetails['type'] == 'cart') {
    // Process cart purchase (You would typically store this order in an orders table)
    foreach ($paymentDetails['items'] as $item) {
        // For each item, insert into the orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $_SESSION['user_id'], $item['product_id'], $item['quantity'], $item['price'], $payment_method, $payment_status);

        if (!$stmt->execute()) {
            // Handle error
            echo "Error: " . $stmt->error;
        } else {
			header("Location: #");
		}
    }
}

// Clear the payment session after processing
unset($_SESSION['payment']);

// Redirect to the thank you page with an appropriate message
header("Location: thankyou.php");
exit();
?>
