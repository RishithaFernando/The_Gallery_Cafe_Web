<?php
session_start(); // Ensure session is started

include "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update order status in the database
    $sql = "UPDATE orders SET status='$status' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Order status updated successfully!'); window.location.href = 'view_ordera.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'view_ordera.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
