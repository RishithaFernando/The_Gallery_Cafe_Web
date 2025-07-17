<?php
session_start(); // Ensure session is started

include "./connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Gallery cafe-Feedback</title>
  <link rel="stylesheet" href="../css/feedback.css">
</head>
<body>
  <div class="container">
    <?php
      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $query = "INSERT INTO feedback (name, feedback, rating) VALUES ('$name', '$feedback', '$rating')";
        $result = mysqli_query($conn, $query);

        if ($result) {
          $msg = "Thank you for your feedback and rating!";
          echo "<script type='text/javascript'>alert('$msg');</script>";
        } else {
          echo "Error: Unable to submit feedback. " . mysqli_error($conn);
        }
      }

      // Retrieve and display feedbacks
      $query = "SELECT name, feedback, rating, created_at FROM feedback ORDER BY created_at DESC";
      $result = mysqli_query($conn, $query);

      if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Feedback and Reviews</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='feedback-item'>";
          echo "<h3>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['rating']) . " Stars</h3>";
          echo "<p>" . htmlspecialchars($row['feedback']) . "</p>";
          echo "<small>Submitted on: " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</small>";
          echo "</div><hr>";
        }
      } else {
        echo "<p>No feedback available yet.</p>";
      }
    ?>

    <h2>Submit Your Feedback</h2>
    <form id="feedbackForm" action="feedback.php" method="post" onsubmit="submitFeedback(event)">
      <div class="form-group">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Your Name" required>
      </div>
      <div class="form-group">
        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="4" placeholder="Enter Your Feedback" required></textarea>
      </div>
      <div class="form-group">
        <label for="rating">Rating:</label>
        <div class="rating">
          <input type="radio" id="star5" name="rating" value="5"><label for="star5">5 stars</label>
          <input type="radio" id="star4" name="rating" value="4"><label for="star4">4 stars</label>
          <input type="radio" id="star3" name="rating" value="3"><label for="star3">3 stars</label>
          <input type="radio" id="star2" name="rating" value="2"><label for="star2">2 stars</label>
          <input type="radio" id="star1" name="rating" value="1"><label for="star1">1 star</label>
        </div>
      </div>
      <div class="form-group">
        <input type="submit" value="Submit">
        <a href="./home.php">Back</a>
      </div>
    </form>
    <div id="feedbackMessage"></div>
  </div>
  <script src="../js/index.js"></script>
</body>
</html>
