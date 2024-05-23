<?php
include('db_connection.php');

// Check if ReviewID is set
if (isset($_REQUEST['ReviewID'])) {
    $review_id = $_REQUEST['ReviewID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM reviews WHERE ReviewID=?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['UserID'];
        $item_id = $row['ItemID'];
        $rating = $row['Rating'];
        $review_text = $row['ReviewText'];
        $review_date = $row['ReviewDate'];
    } else {
        echo "Review not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Review Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update review information form -->
    <h2><u>Update Review Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <label for="item_id">Item ID:</label>
        <input type="number" name="item_id" value="<?php echo isset($item_id) ? $item_id : ''; ?>">
        <br><br>

        <label for="rating">Rating:</label>
        <input type="number" name="rating" value="<?php echo isset($rating) ? $rating : ''; ?>">
        <br><br>

        <label for="review_text">Review Text:</label>
        <input type="text" name="review_text" value="<?php echo isset($review_text) ? $review_text : ''; ?>">
        <br><br>

        <label for="review_date">Review Date:</label>
        <input type="text" name="review_date" value="<?php echo isset($review_date) ? $review_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['user_id'];
    $item_id = $_POST['item_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $review_date = $_POST['review_date'];

    // Update the review in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE reviews SET UserID=?, ItemID=?, Rating=?, ReviewText=?, ReviewDate=? WHERE ReviewID=?");
    $stmt->bind_param("iiissi", $user_id, $item_id, $rating, $review_text, $review_date, $review_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: reviews.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
