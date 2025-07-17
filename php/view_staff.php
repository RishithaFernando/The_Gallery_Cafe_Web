<?php
include "./connection.php";

// Query to select all staff members
$sql = "SELECT id, name, email, address, contact, usertype FROM user WHERE usertype='Staff'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery CafeView Staff Members</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css"> 
    <script>
        function searchStaff() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('staffTable');
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
    <div class="view-staff-container">
        <h2>Staff Members</h2>
        <input type="text" id="searchInput" onkeyup="searchStaff()" placeholder="Search for staff members..">
        <table id="staffTable" border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>";
                    echo '<td>';
                    echo '<a href="edit_staff.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_staff.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this staff member?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No staff members found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
        <a href="../html/admin.html">Back</a>
    </div>
</body>
</html>
