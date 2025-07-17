<?php
  include "./connection.php";

// Query to select meals
$sql = "SELECT id, name, description, price, stock, image, role FROM Menu";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe-View Meals</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <script>
        function searchMeals() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('mealsTable');
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
    <div class="view-meals-container">
        <h2>Available Meals</h2>
        <input type="text" id="searchInput" onkeyup="searchMeals()" placeholder="Search for meals..">
        <table id="mealsTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are any meals in the result
            if (mysqli_num_rows($result) > 0) {
                // Fetch and display each meal
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['stock'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Meal Image" style="width:100px;height:100px;"/></td>';
                    echo "<td>" . $row['role'] . "</td>";
                    echo '<td>';
                    echo '<a href="editproduct.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="deleteproduct.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this meal?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No meals found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
        <a href="addmenu.php">Back  </a>
    </div>
</body>
</html>
