<?php
  include "./connection.php";

// Fetch the special food details
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];
    $sql = "SELECT * FROM SpecialFood WHERE id='$food_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $food = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Special food item not found.'); window.location.href = 'view_special_items.php';</script>";
        exit();
    }
}

// Update special food details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $food_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
   

    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE SpecialFood SET name='$name', description='$description', 
        price='$price', stock='$stock', image='$image' WHERE id='$food_id'";
    } else {
        $sql = "UPDATE SpecialFood SET name='$name', description='$description', 
        price='$price', stock='$stock' WHERE id='$food_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special food item updated successfully!');
         window.location.href = 'view_special_items.php';</script>";
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
    <title>The Gallery Cafe-Edit Special Food Item</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Special Food Item</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $food['id']; ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $food['name']; ?>" required>
            
            <label for="description">Description</label>
            <input type="text" id="description" name="description" value="<?php echo $food['description']; ?>" required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $food['price']; ?>" required>
            
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?php echo $food['stock']; ?>" required>
            
         
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Update Special Food Item</button>
        </form>
        <a href="view_special_items.php">Cancel</a>
    </div>
</body>
</html>
