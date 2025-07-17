<?php
include "./connection.php";

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    $sql = "DELETE FROM user WHERE id='$staff_id' AND usertype='Staff'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Staff member deleted successfully!'); window.location.href = 'view_staff.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Invalid staff member ID.'); window.location.href = 'view_staff.php';</script>";
}

mysqli_close($conn);
?>
