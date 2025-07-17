<?php
session_start(); // Ensure session is started

include "./connection.php";

// Handle POST requests for updating order status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        // Update order status
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // Update order status in the database
        $sql = "UPDATE orders SET status='$status' WHERE id='$order_id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Order status updated successfully!'); window.location.href = 'view_order_admin.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'view_order_admin.php';</script>";
        }
        exit();
    }
}

// Query to get all orders
$sql = "SELECT id AS order_id, product_ids, quantities, total, status FROM orders";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The gallery Cafe-View Orders</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-dropdown {
            width: 150px;
        }

        .update-button {
            background-color: #000025;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .update-button:hover {
            background-color: #0275e0;
        }

        .back-link {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color:#000025;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .back-link:hover {
            background-color: #0275e0;
        }
    </style>
</head>
<body>
    <h2>Order Management</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Products</th>
            <th>Quantities</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        // Check if there are any orders in the result set
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_ids = htmlspecialchars($row['product_ids']);
                $quantities = htmlspecialchars($row['quantities']);
                $products_list = $product_ids; // Assuming product IDs are used as product names
                $quantities_list = $quantities; // Assuming quantities are displayed as is

                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
                echo '<td>' . $products_list . '</td>';
                echo '<td>' . $quantities_list . '</td>';
                echo '<td>$' . number_format($row['total'], 2) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '<td>';
                echo '<form method="post" action="view_order_admin.php" style="margin: 0;">';
                echo '<input type="hidden" name="order_id" value="' . htmlspecialchars($row['order_id']) . '">';
                echo '<select name="status" class="status-dropdown">';
                echo '<option value="Pending"' . ($row['status'] == 'Pending' ? ' selected' : '') . '>Pending</option>';
                echo '<option value="Processing"' . ($row['status'] == 'Processing' ? ' selected' : '') . '>Processing</option>';
                echo '<option value="Completed"' . ($row['status'] == 'Completed' ? ' selected' : '') . '>Completed</option>';
                echo '</select>';
                echo '<button type="submit" name="update_status" class="update-button">Update</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='6'>No orders found</td></tr>";
        }
        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
    <a href="../html/admin.html" class="back-link">Back to Admin Dashboard</a>
</body>
</html>
