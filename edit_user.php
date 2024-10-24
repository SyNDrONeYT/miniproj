<?php
session_start();
include('connection.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update the user's details in the database
    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $role, $id);

    if ($stmt->execute()) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

// Fetch user data for the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST" action="edit_user.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="role">Role</label>
            <select name="role">
                <option value="user" <?php if($user['role'] === 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>

            <button type="submit" name="update_user">Update User</button>
        </form>
        <a href="manage_users.php">Back to Manage Users</a>
    </div>
</body>
</html>
