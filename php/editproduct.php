<?php
  include "./connection.php";

// Fetch the meal details
if (isset($_GET['id'])) {
    $meal_id = $_GET['id'];
    $sql = "SELECT * FROM Menu WHERE id='$meal_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $meal = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Meal not found.'); window.location.href = 'view_products.php';</script>";
        exit();
    }
}

// Update meal details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meal_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $role = $_POST['role'];

    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE Menu SET name='$name', description='$description', price='$price', stock='$stock', image='$image', role='$role' WHERE id='$meal_id'";
    } else {
        $sql = "UPDATE Menu SET name='$name', description='$description', price='$price', stock='$stock', role='$role' WHERE id='$meal_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Meal updated successfully!'); window.location.href = 'view_products.php';</script>";
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
    <title>The Gallery Cafe-Edit Meal</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Meal</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $meal['id']; ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $meal['name']; ?>" required>
            
            <label for="description">Description</label>
            <input type="text" id="description" name="description" value="<?php echo $meal['description']; ?>" required>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="<?php echo $meal['price']; ?>" required>
            
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?php echo $meal['stock']; ?>" required>
            
            <label for="role">Type</label>
            <select id="role" name="role" required>
                <option value="" disabled>Select a type</option>
                <option value="Sri Lankan" <?php if ($meal['role'] == 'Sri Lankan') echo 'selected'; ?>>Sri Lankan</option>
                <option value="Indian" <?php if ($meal['role'] == 'Indian') echo 'selected'; ?>>Indian</option>
                <option value="Italian" <?php if ($meal['role'] == 'Italian') echo 'selected'; ?>>Italian</option>
                <option value="Beverages" <?php if ($meal['role'] == 'Beverages') echo 'selected'; ?>>Beverages</option>
            </select>
            
            <label for="image">Image</label>
            <input type="file" id="image" name="image">
            
            <button type="submit">Update Meal</button>
        </form>
        <a href="view_products.php">Cancel</a>
    </div>
</body>
</html>
