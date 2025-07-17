<?php
include "./connection.php";

// Query to select special events
$sql = "SELECT id, event_name, event_description, event_image FROM SpecialEvents";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe-View Special Events</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <script>
        function searchSpecialEvents() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('specialEventsTable');
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
    <div class="view-special-events-container">
        <h2>Available Special Events</h2>
        <input type="text" id="searchInput" onkeyup="searchSpecialEvents()" placeholder="Search for special events..">
        <table border="1" id="specialEventsTable">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are any special events in the result
            if (mysqli_num_rows($result) > 0) {
                // Fetch and display each special event
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['event_name'] . "</td>";
                    echo "<td>" . $row['event_description'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['event_image']) . '" alt="Special Event Image" style="width:100px;height:100px;"/></td>';
                    echo '<td>';
                    echo '<a href="edit_special_event.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_special_event.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this special event?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No special events found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
        <a href="special_event.php">Back</a>
    </div>
</body>
</html>
