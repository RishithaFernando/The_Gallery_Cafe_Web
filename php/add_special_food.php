<?php
  include "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and escape special characters
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    

    // Retrieve and process the image file
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // Insert new special food item into the database
    $sql = "INSERT INTO SpecialFood (name, description, price, stock, image, special_type) 
            VALUES ('$name', '$description', '$price', '$stock', '$imgContent', '$special_type')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special food item added successfully!'); window.location.href = 'add_special_food.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'add_special_food.php';</script>";
    }
}

// Query to select special food items
$sql = "SELECT id, name, description, price, stock, image FROM SpecialFood";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - Add Special Food</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <script>
        function validateSpecialFoodForm() {
            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;
            var price = document.getElementById('price').value;
            var stock = document.getElementById('stock').value;
           
            var image = document.getElementById('image').value;

            if (name == "") {
                alert("Special food name must be filled out");
                return false;
            }
            if (description == "") {
                alert("Special food description must be filled out");
                return false;
            }
            if (price == "" || isNaN(price) || price <= 0) {
                alert("Valid special food price must be filled out");
                return false;
            }
            if (stock == "" || isNaN(stock) || stock < 0) {
                alert("Valid special food stock must be filled out");
                return false;
            }
          
            if (image == "") {
                alert("Special food image must be selected");
                return false;
            }
            return true;
        }

        function searchSpecialFoods() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('specialFoodsTable');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = 'none';
                var td = tr[i].getElementsByTagName('td');
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .Back {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .Back a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .Back a:hover {
            border-color= "#0275e0";
        }
    </style>
</head>
<body>
    <div class="Back">
        <a href="../html/admin.html">Go Back</a><br><br>
    </div>
    
    <h3>Add New Special Food</h3>
    <form action="add_special_food.php" method="post" enctype="multipart/form-data" onsubmit="return validateSpecialFoodForm()">
        <label for="name">Special Food Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Special Food Description:</label>
        <textarea id="description" name="description" required></textarea>
        <label for="price">Special Food Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <label for="stock">Special Food Stock:</label>
        <input type="number" id="stock" name="stock" required>
        <label for="image">Special Food Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Add Special Food</button>
    </form>

    <h3>Available Special Foods</h3>
    <input type="text" id="searchInput" onkeyup="searchSpecialFoods()" placeholder="Search for special foods..">
    <table border="1" id="specialFoodsTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            
            <th>Actions</th>
        </tr>
        <?php
        // Check if there are any special food items in the result
        if (mysqli_num_rows($result) > 0) {
            // Fetch and display each special food item
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Special Food Image" style="width:100px;height:100px;"/></td>';
                
                echo '<td>';
                echo '<a href="edit_special_food.php?id=' . $row['id'] . '">Edit</a> | ';
                echo '<a href="delete_special_food.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this special food item?\')">Delete</a>';
                echo '</td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No special foods found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
