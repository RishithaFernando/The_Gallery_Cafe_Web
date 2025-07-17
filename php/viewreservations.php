<?php
session_start(); // Ensure session is started

include "./connection.php";




// Fetch reservations from the database
$sql = "SELECT * FROM reservations";
$reservations = $conn->query($sql);

if (!$reservations) {
    die("Error: Could not fetch reservations: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <title>The Gallery Cafe - View Reservations</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
</head>
<body>


<div class="container">
    <h2>Reservation Details</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Date</th>
                <th>Time</th>
                <th>Table Category</th>
                <th>Total Price</th>
                <th>Tables</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $reservations->fetch_assoc()) {
                $reservationId = $row['id'];

                // Fetch reserved tables for this reservation
                $tableSql = "SELECT tables FROM reserve_tables WHERE reservation_id = ?";
                $stmt = $conn->prepare($tableSql);
                $stmt->bind_param("i", $reservationId);
                $stmt->execute();
                $tableResult = $stmt->get_result();

                $tables = [];
                while ($tableRow = $tableResult->fetch_assoc()) {
                    $tables[] = $tableRow['tables'];
                }
                $tablesList = implode(", ", $tables);

                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['user_name']}</td>
                    <td>{$row['user_email']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['reservation_date']}</td>
                    <td>{$row['reservation_time']}</td>
                    <td>{$row['table_category']}</td>
                    <td>Rs. {$row['total_price']}</td>
                    <td>{$tablesList}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="../html/admin.html">Back  </a>
</div>

</body>
</html>
