<?php
  include "./connection.php";

// Delete the meal
if (isset($_GET['id'])) {
    $meal_id = $_GET['id'];
    $sql = "DELETE FROM Menu WHERE id='$meal_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Meal deleted successfully!'); window.location.href = 'view_products.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Invalid meal ID.'); window.location.href = 'view_products.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>
