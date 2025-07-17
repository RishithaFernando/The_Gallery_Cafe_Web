<?php
include "./connection.php";

$staff = null; // Initialize the variable

// Check if an ID is provided
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id='$staff_id' AND usertype='Staff'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and returned a result
    if ($result && mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Staff member not found.'); window.location.href = 'view_staff.php';</script>";
        exit();
    }
}

// Handle form submission for editing staff member
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    // Handle password update
    if ($password != "") {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET name='$name', email='$email', address='$address', contact='$contact', password='$password' WHERE id='$staff_id' AND usertype='Staff'";
    } else {
        $sql = "UPDATE user SET name='$name', email='$email', address='$address', contact='$contact' WHERE id='$staff_id' AND usertype='Staff'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Staff member updated successfully!'); window.location.href = 'view_staff.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Galery Cafe-Edit Staff Member</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css"> 
</head>
<body>
    <div class="form-container">
        <h2>Edit Staff Member</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $staff['id'] ?? ''; ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $staff['name'] ?? ''; ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $staff['email'] ?? ''; ?>" required>
            
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $staff['address'] ?? ''; ?>" required>
            
            <label for="contact">Contact</label>
            <input type="text" id="contact" name="contact" value="<?php echo $staff['contact'] ?? ''; ?>" required>
            
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" id="password" name="password">
            
            <button type="submit">Update Staff Member</button>
        </form>
        <a href="view_staff.php">Cancel</a>
    </div>
</body>
</html>
