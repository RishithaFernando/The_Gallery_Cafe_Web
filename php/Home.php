<?php
session_start(); // Ensure session is started

include "./connection.php";



// Query to select special foods with a limit of 4
$sql = "SELECT id, name, description, price, image FROM specialfood LIMIT 8";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>The Gallery Cafe - Home</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <style>
        .special-foods {
            padding: 20px;
            background: #f9f9f9;
        }
        .special-foods h1 {
            color:#000025;
            text-align: center;
            margin-bottom: 20px;
            margin-top:20px;
        }
        .special-foods h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .special-foods .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .special-foods .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 300px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .special-foods .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .special-foods .product-card h3 {
            margin: 10px 0;
            color:#000025;
        }
        .special-foods .product-card p {
            color: #777;
        }
        .special-foods .product-card .price {
            font-size: 1.2em;
            color: #333;
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
                <li><a href="./eventandpromotions.php">Event & Promotions</a></li>
                <li><a href="./index.php" class="join-btn">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- hero section -->
<div class="hero">
    <div class="container">
        <div class="content_wrapper">
            <h3>Where Every Meal Tells a Story</h3>
            <h1>A Culinary <span style="color:#b0c9e9">Art</span><br>
              Experience!</h1>
              <a href="./menu.php">
    <button class="join-btn">Explore more</button>
</a>
        </div>
    </div>
</div>

<!-- special foods section -->
<div class="special-foods">
    <h1>The Special Foods</h1>
    <div class="container">
        
        <div class="products-container">
            <?php
            // Check if there are any special foods in the result set
            if (mysqli_num_rows($result) > 0) {
                // Loop through each special food and display it
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product-card">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) .
                     '" alt="Special Food Image"/>';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="price">LKR ' . number_format($row['price'], 2) . '</p>';
                    echo '</div>';
                }
            } else {
                // Display a message if no special foods are available
                echo '<p>No special foods available.</p>';
            }
            ?>
        </div>
    </div>
    <br><br><br>
</div>

<!-- offer section -->
<div class="offer">
    <div class="container">
        <h1>A BIG OFFER FOR THIS SUMMER</h1>
        <p>Join Us for Special Events and Exclusive Promotions</p>
        <a href="./eventandpromotions.php">
    <button class="join-btn">Explore more</button>
</a>

    </div>
</div>

<!-- Choose us -->
<div class="choose-us">
    <div class="container">
        <div class="heading">
            <h1>WHY YOU SHOULD CHOOSE US?</h1>
            <p>The Gallery Café positions itself as a premier dining destination that offers convenience,
                culinary excellence, a beautiful ambiance, and personalized service.</p>
        </div>
        <div class="row">
            <div class="col">
                <img src="../images/front/img1.jpg" alt="">
                <h3>Pre-Ordering Convenience</h3>
                <p>Skip the wait and have your meal ready when you arrive.
                     Pre-order your favorite dishes through our website and enjoy a seamless 
                     dining experience. Ideal for those with limited lunch breaks or tight schedules. 
                     Ensure your meal is ready exactly when you need it. Plan your special events with ease.</p>
            </div>
            <div class="col">
                <img src="../images/front/img2.png" alt="">
                <h3>World-Class Chef</h3>
                <p>Our head chef brings years of international experience, crafting exquisite 
                    dishes that blend tradition and innovation. Indulge in exclusive creations only 
                    available at The Gallery Café, prepared with the finest ingredients and utmost care.
                     Our chef is dedicated to creating memorable dining experiences, with a focus on taste,
                      presentation, and quality.</p>
            </div>
            <div class="col">
                <img src="../images/front/img3.png" alt="">
                <h3>Breathtaking View</h3>
                <p>Enjoy your meal with a stunning view of Colombo's vibrant cityscape,
                     providing a perfect backdrop for a relaxing and enjoyable dining experience.
                      Take advantage of our beautiful outdoor seating area, offering a refreshing atmosphere
                       and a perfect spot for al fresco dining.</p>
            </div>
            <div class="col">
                <img src="../images/front/img4.png" alt="">
                <h3>Customizable Dining Options</h3>
                <p>Whether you have dietary restrictions or specific preferences,
                     our customizable menus ensure that every guest enjoys a meal tailored to their tastes.
                      Choose from intimate tables for two, larger tables for groups, or private dining areas for 
                      special occasions.</p>
            </div>
        </div>
    </div>
</div>
<?php
     include "./Footer.php";
     
    ?>
<script src="../js/home.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
