<?php
include "./connection.php";

// Delete the special event
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $sql = "DELETE FROM SpecialEvents WHERE id='$event_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special event deleted successfully!'); window.location.href = 'view_special_events.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Invalid special event ID.'); window.location.href = 'view_special_events.php';</script>";
}

// Close the connection
mysqli_close($conn);
?>
