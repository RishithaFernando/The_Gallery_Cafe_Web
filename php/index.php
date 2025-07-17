<?php
     include "./connection.php";
     session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe - Welcome</title>
    <link rel="shortcut icon" href="../images/logo/ll.png">
    <link rel="stylesheet" href="../css/welcome.css">
</head>
<body>
   <div class="container ">
    <div class="row">
        <nav class="navbar">
            <img src ="../images/logo/ll.png">
        </nav>
        <div class="content">
            <h1>Welcome</h1>
            <h2>The Gallery Cafe</h2>
            <a href="login.php">Join For Free</a>
        </div>
    </div>
   </div>
   <hr>
  
    <div class="welcome-container">
        <div class="image-container">
            <img src="../images/background/welcome2.jpg" alt="Restaurant Image">
            <img src="../images/background/img.jpg" alt="Restaurant2 Image">
            <img src="../images/background/img2.jpg" alt="Restaurant3 Image">
        </div>

       <div class="welcome-container-paragraphs">
        <p class="intro-paragraph">
            Step into the culinary wonderland of The Gallery Café, a cherished gem in the heart of Colombo. 
        </p>
        <p class="intro-paragraph">
            At The Gallery Café, we blend the charm of tradition with the innovation of the 
            modern age to bring you an unparalleled dining journey. 
        </p>
        <p class="intro-paragraph">
            Join us as we embark on this exciting new chapter. Whether you're a loyal patron
             or a first-time visitor, we promise to make your experience at The Gallery Café truly memorable. 
        </p>
        <p class="intro-paragraph">
            <strong>The Gallery Café</strong> "Where tradition meets technology, and every meal is
             a masterpiece".
        </p>
        <p class="intro-paragraph">
            Welcome to a new era of dining excellence!
        </p>
        </div>
    </div>

    <!-- banners -->
     <div class="banner-title">
        <h1>Discover What We Offer</h1>
     </div>
     <div class="banners"></div>

<br><br>
<div class="team-section">
<div class="title">
                <h1>Meat Our Team</h1>
                <p>At The Gallery Café, our team is the heart and soul of our establishment.<br>
                     Each member brings their unique skills and passion to ensure every guest has an exceptional<br>
                      dining experience.
                     
                       </p>
            </div>
    <div class="containers">
        <div class="row">
            
        </div>
        <div class="team-card">
            <div class="image-section">
                <img src="../images/team/chef.jpg" alt="" srcset="">
            </div>
            <div class="contents">
                <h2>John Snow</h2>
                <h3>Head Chef</h3>
                <p>John brings over 20 years of culinary experience to The Gallery Café. 
                    Known for his innovative approach to classic dishes, John is passionate about using locally
                     sourced ingredients to create mouthwatering meals. His dedication to excellence and creativity 
                     in the kitchen has earned him numerous accolades and a loyal following.
                </p>
            </div>
        </div>
       
        
        <div class="team-card">
            <div class="image-section">
                <img src="../images/team/owner.jpg" alt="" srcset="">
            </div>
            <div class="contents">
                <h2>Bran Coner</h2>
                <h3>Owner</h3>
                <p>Bran Coner is the visionary behind The Gallery Café. 
                    With a passion for culinary excellence and a dedication to creating a unique dining 
                    experience, Bran founded the café in 1995. His leadership and commitment to quality 
                    have transformed The Gallery Café into one of Colombo's most beloved dining destinations. 
                    Bran's hands-on approach and deep understanding of hospitality ensure that every guest feels
                     welcomed and valued. Under his guidance, The Gallery Café continues to thrive,
                      offering exceptional food, service, and ambiance.
                </p>
            </div>
        </div>
        <div class="team-card">
            <div class="image-section">
                <img src="../images/team/Woman.jpg" alt="" srcset="">
            </div>
            <div class="contents">
                <h2>Samantha Lee</h2>
                <h3>Restaurant Manager</h3>
                <p>With a background in hospitality management, Samantha ensures that every 
                    guest at The Gallery Café receives exceptional service. Her attention to detail and
                     warm personality make her a key part of our team. Samantha is always available to address
                      any concerns and to ensure your dining experience is nothing short of perfect.</p>
            </div>
        </div>
    </div>
</div>

   
<script src="../js/script.js"></script>
</body>
</html>