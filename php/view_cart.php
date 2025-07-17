<?php
session_start(); // Ensure session is started

include "./connection.php";

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty.'); window.location.href = 'menu.php';</script>";
    exit();
}

// Handle POST requests for removing items or confirming the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        // Remove product from cart
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            if (empty($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
            echo "<script>alert('Product removed from cart!'); window.location.href = 'view_cart.php';</script>";
            exit();
        }
    } elseif (isset($_POST['confirm_order'])) {
        // Confirm the order
        $user_id = $_SESSION['user_id'] ?? null; // Use user_id from session, if available
        $customer_name = $_SESSION['username'] ?? 'Guest'; // Use username as customer name, fallback to 'Guest'
        $product_ids = implode(',', array_keys($_SESSION['cart']));
        $quantities = implode(',', $_SESSION['cart']);
        $total = $_POST['total'];

        // Insert order into the database
        $sql = "INSERT INTO orders (user_id, product_ids, quantities, total) 
        VALUES ('$user_id', '$product_ids', '$quantities', '$total')";

        if (mysqli_query($conn, $sql)) {
            $order_id = mysqli_insert_id($conn);
            $order_summary = "Order ID: " . $order_id . "\\n";
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $sql = "SELECT name FROM menu WHERE id='$id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $order_summary .= $row['name'] . " (Quantity: $quantity)\\n";
                }
            }
            $order_summary .= "Total: $total";
            unset($_SESSION['cart']);
            echo "<script>alert('Order confirmed!\\n$order_summary'); window.location.href = 'menu.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'view_cart.php';</script>";
        }
        exit();
    }
}

// Get the product IDs from the cart
$cart = $_SESSION['cart'];
$product_ids = implode(',', array_keys($cart));

// Query to get product details for items in the cart
$sql = "SELECT id, name, price FROM menu WHERE id IN ($product_ids)";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Galler Cafe-View Cart</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/additem.css">
    <style>
        *{
            background=url("../images/background/home.jpg")
        }
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
            background-color: #000025;
            color: #fff;
        }

        .total {
            font-size: 1.5em;
            margin-top: 20px;
            text-align: right;
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }

        .back-link, .confirm-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #000025;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .back-link:hover, .confirm-button:hover {
            background-color: #0275e0;
        }

        .remove-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            width: 80px;
        }

        .remove-button:hover {
            background-color: #e53935;
        }

        .action-column {
            width: 100px;
        }
    </style>
</head>
<body>
    <h2>Your Cart</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th class="action-column">Action</th>
        </tr>
        <?php
        $total = 0;
        // Check if there are any products in the result set
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $quantity = $cart[$row['id']];
                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>$' . number_format($row['price'], 2) . '</td>';
                echo '<td>' . htmlspecialchars($quantity) . '</td>';
                echo '<td>$' . number_format($subtotal, 2) . '</td>';
                echo '<td class="action-column">';
                echo '<form method="post" action="view_cart.php" style="margin: 0;">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" name="remove" class="remove-button">Remove</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No products found.</td></tr>';
        }
        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
    <div class="total">
        <strong>Total: $<?php echo number_format($total, 2); ?></strong>
    </div>
    <form method="post" action="view_cart.php">
        <input type="hidden" name="total" value="<?php echo number_format($total, 2); ?>">
        <button type="submit" name="confirm_order" class="confirm-button">Confirm Order</button>
    </form>
    <a href="menu.php" class="back-link">Continue Shopping</a>
    
</body>
</html>
