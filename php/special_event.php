<?php
include "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and escape special characters
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    
    // Retrieve and process the image file
    $event_image = $_FILES['event_image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($event_image));

    // Insert new special event into the database
    $sql = "INSERT INTO SpecialEvents (event_name, event_description, event_image) 
            VALUES ('$event_name', '$event_description', '$imgContent')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special event added successfully!'); window.location.href = 'special_event.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'special_event.php';</script>";
    }
}

// Query to select special events
$sql = "SELECT id, event_name, event_description, event_image FROM SpecialEvents";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - Add Special Event</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <script>
        function validateSpecialEventForm() {
            var event_name = document.getElementById('event_name').value;
            var event_description = document.getElementById('event_description').value;
            var event_image = document.getElementById('event_image').value;

            if (event_name == "") {
                alert("Event name must be filled out");
                return false;
            }
            if (event_description == "") {
                alert("Event description must be filled out");
                return false;
            }
            if (event_image == "") {
                alert("Event image must be selected");
                return false;
            }
            return true;
        }

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
            border-color: "#0275e0";
        }
    </style>
</head>
<body>
    <div class="Back">
        <a href="../html/admin.html">Go Back</a><br><br>
    </div>
    
    <h3>Add New Special Event</h3>
    <form action="special_event.php" method="post" enctype="multipart/form-data" onsubmit="return validateSpecialEventForm()">
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>
        <label for="event_description">Event Description:</label>
        <textarea id="event_description" name="event_description" required></textarea>
        <label for="event_image">Event Image:</label>
        <input type="file" id="event_image" name="event_image" accept="image/*" required>
        <button type="submit">Add Special Event</button>
    </form>

    <h3>Available Special Events</h3>
    <input type="text" id="searchInput" onkeyup="searchSpecialEvents()" placeholder="Search for special events..">
    <table border="1" id="specialEventsTable">
        <tr>
            <th>ID</th>
            <th>Event Name</th>
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
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['event_image']) . '" alt="Event Image" style="width:100px;height:100px;"/></td>';
                
                echo '<td>';
                echo '<a href="edit_special_event.php?id=' . $row['id'] . '">Edit</a> | ';
                echo '<a href="delete_special_event.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this special event?\')">Delete</a>';
                echo '</td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No special events found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
