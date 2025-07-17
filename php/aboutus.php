<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - About Us</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <header>
        <nav>
           <div class="logo">
                <img src="../images/logo/ll.png" alt="The Gallery Cafe Logo">
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
                    <li><a href="./login.php" class="join-btn">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="about">
        <h1>About Us</h1>
        <section class="content-section">
            <h2>Our History</h2>
            <p>The Gallery Café was established in 1995 in the vibrant city of Colombo. Our journey began with a simple mission: to create a warm and welcoming space where food lovers could enjoy delicious meals and great company. Over the years, we’ve transformed from a quaint café into one of Colombo's most beloved dining destinations. Our commitment to quality and service remains steadfast, and we continue to be a favorite spot for locals and tourists alike.</p>
        </section>

        <section class="content-section">
            <h2>Reservation Information</h2>
            <p>At The Gallery Café, we strive to make your dining experience as seamless as possible. Reservations can be made online through our website or by calling us directly. We recommend booking in advance, especially during peak times and special events, to ensure you get the table of your choice. Our online reservation system allows you to select your preferred dining time, view available table options, and even pre-order your meals. If you have any special requests or dietary requirements, please let us know at the time of booking.</p>
        </section>

        <section class="content-section1"  id="terms-and-services">
            <h2>Terms and Services</h2>
            <h3 id="privacy-and-policy">Privacy Policy</h3>
            <p>We value your privacy and are committed to protecting your personal information. Our Privacy Policy outlines how we collect, use, and safeguard the data you provide when using our website and services. We ensure that your information is kept confidential and only used for the purposes of improving your experience at The Gallery Café.</p>

            <h3>Terms of Service</h3>
            <p>By accessing and using our website, you agree to comply with our Terms of Service. These terms govern your use of the site and our services, including making reservations, pre-ordering meals, and any other interactions you have with The Gallery Café. We reserve the right to update these terms at any time, so please review them regularly.</p>

            <h3>Booking and Cancellation</h3>
            <p>Reservations at The Gallery Café are subject to availability. We recommend booking in advance, especially during peak times. Cancellations must be made at least 24 hours before your reservation time to avoid charges. For special events and large groups, additional terms may apply.</p>

            <h3>User Responsibilities</h3>
            <p>Users are responsible for providing accurate information when making reservations or interacting with our services. Any misuse of the site or violation of our terms may result in the suspension or termination of your access to our services.</p>

            <h3>Liability</h3>
            <p>The Gallery Café is not liable for any damages or losses arising from the use of our website or services. We strive to provide accurate and up-to-date information, but we do not guarantee the completeness or accuracy of the content on our site.</p>
        </section>
    </div>

    <?php include "./Footer.php"; ?>
</body>
</html>
