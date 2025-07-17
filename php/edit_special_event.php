<?php
include "./connection.php";

// Fetch the special event details
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $sql = "SELECT * FROM SpecialEvents WHERE id='$event_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Special event not found.'); window.location.href = 'view_special_events.php';</script>";
        exit();
    }
}

// Update special event details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['id'];
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];
    
    // Handle image upload
    if (isset($_FILES['event_image']['name']) && $_FILES['event_image']['name'] != "") {
        $event_image = addslashes(file_get_contents($_FILES['event_image']['tmp_name']));
        $sql = "UPDATE SpecialEvents SET event_name='$event_name', event_description='$event_description', event_image='$event_image' WHERE id='$event_id'";
    } else {
        $sql = "UPDATE SpecialEvents SET event_name='$event_name', event_description='$event_description' WHERE id='$event_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special event updated successfully!'); window.location.href = 'view_special_events.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The GalleryCafe-Edit Special Event</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Special Event</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
            
            <label for="event_name">Event Name</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>" required>
            
            <label for="event_description">Event Description</label>
            <textarea id="event_description" name="event_description" required><?php echo $event['event_description']; ?></textarea>
            
            <label for="event_image">Event Image</label>
            <input type="file" id="event_image" name="event_image">
            
            <button type="submit">Update Special Event</button>
        </form>
        <a href="view_special_events.php">Cancel</a>
    </div>
</body>
</html>
