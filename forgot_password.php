<?php
// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session at the very top
session_start();
include('connection.php');

// Initialize an empty message
$message = "";

// Handle password reset request
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));  // Generate a unique token
        $token_expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));  // Token expires in 1 hour

        // Save the token in the database (create columns `reset_token` and `reset_token_expiry` in your `users` table)
        $sql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $token_expiry, $email);
        if ($stmt->execute()) {
            // Send reset email with a link to reset_password.php including the token as a parameter
            $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click on the following link to reset your password: $reset_link";
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($email, $subject, $message, $headers)) {
                $message = "An email has been sent to reset your password.";
            } else {
                $message = "Failed to send reset email.";
            }
        } else {
            $message = "Failed to generate reset link.";
        }
    } else {
        $message = "No user found with that email address.";
    }

    // Close the statement
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="lstyle.css">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
