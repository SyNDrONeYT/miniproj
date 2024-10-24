<?php
// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session at the very top
session_start();
include('connection.php');

// Initialize an empty error message
$error_message = "";

// Handle user registration
if (isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $dob = $_POST['dob'];
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone_number = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($dob) || empty($email) || empty($address) || empty($phone_number) || empty($password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already registered. Please use a different email.";
        } else {
            // Proceed to register the user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user data into the database
            $sql = "INSERT INTO users (first_name, last_name, dob, email, address, phone_number, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $first_name, $last_name, $dob, $email, $address, $phone_number, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php?register=success");
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        // Close the statement
        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="lstyle.css">
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        <?php if ($error_message): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="date" name="dob" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>

