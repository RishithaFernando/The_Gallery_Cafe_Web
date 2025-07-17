<?php
session_start(); // Ensure session is started

include "./connection.php";

if (!isset($_SESSION['user_email'])) {
    header("location:../php/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $tableCategory = $_POST['tableCategory'];
    $totalPrice = $_POST['totalPrice'];
    $tables = isset($_POST['tables']) ? $_POST['tables'] : array(); // Handle the tables input

    // Check if at least one table is selected
    if (!empty($tables)) {
        // Insert reservation data into reservations table
        $sql = "INSERT INTO reservations (user_name, user_email, contact_number, reservation_date, reservation_time, table_category, total_price) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Initialize a statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the variables to the prepared statement as parameters
            $stmt->bind_param("sssssss", $name, $email, $contact, $date, $time, $tableCategory, $totalPrice);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Get the ID of the inserted reservation
                $reservationId = $stmt->insert_id;
                
                // Prepare to insert table information into reserve_tables table
                $stmt = $conn->prepare("INSERT INTO reserve_tables (reservation_id, tables) VALUES (?, ?)");

                // Check if the prepare statement was successful
                if ($stmt) {
                    foreach ($tables as $table) {
                        // Bind the reservation ID and table to the prepared statement
                        $stmt->bind_param("is", $reservationId, $table);
                        $stmt->execute();
                    }

                    if ($stmt->affected_rows > 0) {
                        echo '<script>alert("Successfully Placed Reservation");</script>';
                        header("Location: Home.php");
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    // Close the table insertion statement
                    $stmt->close();
                } else {
                    echo "Error: Could not prepare the query for reserve_tables: $conn->error";
                }
            } else {
                echo "Error: Could not execute the query for reservations: $stmt->error";
            }

            // Close the reservation statement
            $stmt->close();
        } else {
            echo "Error: Could not prepare the query for reservations: $conn->error";
        }
    } else {
        echo '<script>alert("Please select at least one table.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <title>The Gallery Cafe - Table Reservation</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/Reservation.css">
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <img src="../images/logo/ll.png" alt="">
            <h1>The <span>Gallery</span> Cafe</h1>
        </div>
        <div class="nav-items">
            
            <ul class="nav-list">
                <li><a href="./Home.php">Home</a></li>
                <li><a href="./aboutus.php">About</a></li>
                <li><a href="./menu.php">Menu</a></li>
                <li><a href="">Reservation</a></li>
                <li><a href="./eventandpromotions.php">Event & Promotions</a></li>
                <li><a href="./index.php" class="join-btn">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <div class="left-section">
        <section>
            <form id="reservationForm" action="" method="POST">
                <label for="name">Name :</label><br>
                <input type="text" id="name" name="name" value="<?php echo $_SESSION["user_name"]; ?>" required>
                <br><br>

                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION["user_email"]; ?>" required>
                <br><br>

                <label for="contact">Contact Number :</label><br>
                <input type="number" id="contact" name="contact" required><br><br>

                <label for="date">Choose a Date :</label>
                <input type="date" id="date" name="date" required><br><br>

                <label for="time">Choose a Time :</label>
                <select id="time" name="time" required>
                    <option value="12:00 PM - 2:00 PM">12:00 PM - 2:00 PM</option>
                    <option value="2:30 PM - 4:30 PM">2:30 PM - 4:30 PM</option>
                    <option value="5:00 PM - 7:00 PM">5:00 PM - 7:00 PM</option>
                    <option value="7:30 PM - 9:30 PM">7:30 PM - 9:30 PM</option>
                    <option value="10:00 PM - 12:00 AM">10:00 PM - 12:00 AM</option>
                </select><br><br>

                <label for="tableCategory">Table Category :</label><br>
                <select id="tableCategory" name="tableCategory" required onchange="updateTotalPrice()">
                    <option value="2" data-price="2000.00">Table For 2 People</option>
                    <option value="4" data-price="3000.00">Table For 4 People</option>
                    <option value="6" data-price="5000.00">Table For 6 People</option>
                    <option value="8" data-price="7000.00">Table For 8 People</option>
                    <option value="10" data-price="9000.00">Table For 10 People</option>
                </select><br><br>

                <label>Total Price :</label>
                <input type="text" id="totalPrice" name="totalPrice" value="" readonly>

                <input type="hidden" name="tables" id="tables"> <!-- To handle selected tables -->
                <div class="tables" data-table-price="2000.00"></div>

                <br><br>

                <div class="abc">
                    <div class="ab">
                        <span style='color:red;font-size:40px;font-color:#fff;
                         margin-left: 20px; background-color: red; border-radius: 5px;'>&#9744;</span>
                        <p>Reserved</p>
                    </div>
                    <br><br>
                    <div class="ab">
                        <span style='color:#eaebef; font-size:40px; margin-left: 20px; 
                        background-color: #eaebef; border-radius: 5px;'>&#9744;</span>
                        <p>Available</p>
                    </div>
                    <br><br>
                    <div class="ab">
                        <span style='color:#cedd00; font-size:40px; margin-left: 20px;
                        background-color: #cedd00; border-radius: 5px;'>&#9744;</span>
                        <p>Selected</p>
                    </div>
                    <br><br>
                </div>

                <input type="submit" id="submitButton" value="Reserve">
            </form>
        </section>
    </div>
   
<script defer src="../js/Reservation.js"></script>

</body>
</html>
