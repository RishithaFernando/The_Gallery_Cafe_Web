<?php
include "./connection.php";

// Query to select special food items
$sql = "SELECT id, name, description, price, stock, image FROM SpecialFood";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe-View Special Food Items</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <script>
        function searchSpecialItems() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('specialItemsTable');
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
</head>
<body>
    <div class="view-special-items-container">
        <h2>Available Special Food Items</h2>
        <input type="text" id="searchInput" onkeyup="searchSpecialItems()" placeholder="Search for special food items..">
        <table border="1" id="specialItemsTable">
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
                echo "<tr><td colspan='7'>No special food items found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
        <a href="add_special_food.php">Back</a>
    </div>
</body>
</html>
