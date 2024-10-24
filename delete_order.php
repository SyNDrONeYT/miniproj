<?php
session_start();
include('connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the order from the database
    $sql = "DELETE FROM orders WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: manage_orders.php');
        exit();
    } else {
        echo "Error deleting order: " . $conn->error;
    }
} else {
    header('Location: manage_orders.php');
    exit();
}
?>
