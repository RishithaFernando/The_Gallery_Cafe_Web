<?php
session_start(); // Ensure session is started

include "./connection.php";

// Initialize search query
$search_query = "";

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
    $sql = "SELECT id, name, description, price, stock, image FROM menu WHERE role LIKE '%$search_query%'";
} else {
    // Default query to select all products
    $sql = "SELECT id, name, description, price, stock, image FROM menu";
}

$result = mysqli_query($conn, $sql);

// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = (int)$_POST['quantity'];

    // Initialize the cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update the cart with the new product or add a new product
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Alert user and redirect to product view page
    echo "<script>alert('Meals added to cart!'); window.location.href = 'menu.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - Menu</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
<link rel="stylesheet" href="../css/home.css">
    <style>
        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }

        .product-card {
            background:#fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 300px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 10px 0;
            color:#000025;
        }

        .product-card p {
            color: #777;
        }

        .product-card .price {
            font-size: 1.2em;
            color: #333;
        }

        .product-card form {
            margin-top: 10px;
        }

        .product-card input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-right: 10px;
        }

        .product-card button {
            padding: 5px 10px;
            background-color: #000025;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-card button:hover {
            background-color: #03488a;
        }

        .cart-link {
            display: block;
            width: 200px;
            margin: 20px;
            padding: 10px 20px;
            background-color: #000025;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .cart-link:hover {
            background-color: #03488a;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .cart-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .cart-content h2 {
            margin-bottom: 20px;
        }

        .cart-content ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .cart-content ul li {
            margin-bottom: 10px;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #000025;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #03488a;
        }
       
       
    </style>
    <script>
        function toggleCart() {
            const cartOverlay = document.getElementById('cart-overlay');
            const body = document.body;

            cartOverlay.classList.toggle('active');
            body.classList.toggle('blur-background');
        }
    </script>
</head>
<body>
<header>
    <nav>
       <div class="logo">
        <img src="../images/logo/ll.png" alt="">
        <h1>The <span>Gallery</span> Cafe</h1>
        </div>

        <div class="nav-items">
        <i class="fa-solid fa-bars" id="menu-icon"onclick="showmenu()"></i>
            <ul class="nav-list">
                <li><a href="./Home.php">Home</a></li>
                <li><a href="./aboutus.php">About</a></li>
                <li><a href="./menu.php">Menu</a></li>
                <li><a href="./reservation.php">Reservation</a></li>
                <li><a href="./eventandpromotions.php">Event & Promotions</a></li>
                <li><a href="./index.php"class="join-btn">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="search-container" style="text-align: center; margin: 20px;">
    <form method="post" action="menu.php">
        <input type="text" name="search_query" placeholder="Enter type of food"
         value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit" name="search" style="padding: 10px 20px; background-color: #000025;
         color: white; border: none; border-radius: 5px; cursor: pointer;">Search</button>
    </form>
</div>

<div class="products-container">
    <?php
    // Check if there are any products in the result set
    if (mysqli_num_rows($result) > 0) {
        // Loop through each product and display it
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/>';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p class="price">$ ' . $row['price'] . '</p>';
            echo '<form method="post" action="menu.php">';
            echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
            echo '<input type="number" name="quantity" value="1" min="1" max="' . $row['stock'] . '" required>';
            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        // Display a message if no products are available
        echo '<p>No products available.</p>';
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
</div>
<a href="view_cart.php" class="cart-link" onclick="toggleCart()">View Cart</a>

<!-- Cart Overlay -->
<div id="cart-overlay" class="cart-overlay">
    <div class="cart-content">
        <h2>Your Cart</h2>
        <ul>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    // Fetch product details from the database
                    $product_sql = "SELECT name, price FROM menu WHERE id = $product_id";
                    $product_result = mysqli_query($conn, $product_sql);
                    $product = mysqli_fetch_assoc($product_result);

                    echo '<li>' . $product['name'] . ' - ' . $quantity . ' x $' . $product['price'] . '</li>';
                }
            } else {
                echo '<li>Your cart is empty.</li>';
            }
            ?>
        </ul>
        <a href="menu.php" class="back-button" onclick="toggleCart()">Back</a>
    </div>
</div>

<?php
     include "./Footer.php";
     
    ?>
</body>
</html>
