<?php
session_start(); // Ensure session is started

include "./connection.php";

// Query to select all special events
$sql = "SELECT event_name, event_description, event_image FROM specialevents";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - Special Events</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .events-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }

        .event-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 300px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .event-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .event-card h3 {
            margin: 10px 0;
        }

        .event-card p {
            color: #777;
        }
        

        
        
    </style>
</head>
<body>
<header>
    <nav>
       <div class="logo">
        <img src="../images/logo/ll.png" alt="">
        <h1>The <span>Gallery</span> Cafe</h1>
        </div>

        <div class="nav-items">
        <i class="fa-solid fa-bars" id="menu-icon" onclick="showmenu()"></i>
            <ul class="nav-list">
                <li><a href="./Home.php">Home</a></li>
                <li><a href="./aboutus.php">About</a></li>
                <li><a href="./menu.php">Menu</a></li>
                <li><a href="./reservation.php">Reservation</a></li>
                <li><a href="">Event & Promotions</a></li>
                <li><a href="./index.php" class="join-btn">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="events-container">
    <?php
    // Check if there are any events in the result set
    if (mysqli_num_rows($result) > 0) {
        // Loop through each event and display it
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="event-card">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['event_image']) . '" alt="Event Image"/>';
            echo '<h3>' . htmlspecialchars($row['event_name']) . '</h3>';
            echo '<p>' . htmlspecialchars($row['event_description']) . '</p>';
            echo '</div>';
        }
    } else {
        // Display a message if no events are available
        echo '<p>No special events available.</p>';
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
</div>
<?php
     include "./Footer.php";
     
    ?>
</body>
</html>
