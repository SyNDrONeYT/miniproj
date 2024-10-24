<?php
session_start();
include('connection.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    header('Location: manage_users.php');
    exit();
}
?>
