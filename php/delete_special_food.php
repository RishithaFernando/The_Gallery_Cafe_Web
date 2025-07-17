<?php
  include "./connection.php";

// Delete the special food item
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];
    $sql = "DELETE FROM SpecialFood WHERE id='$food_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special food item deleted successfully!'); window.location.href = 'view_special_items.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Invalid special food item ID.'); window.location.href = 'view_special_items.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>
