<?php
include('db_connection.php');

// Check if WinnerID is set
if (isset($_REQUEST['WinnerID'])) {
    $winner_id = $_REQUEST['WinnerID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM winners WHERE WinnerID=?");
    $stmt->bind_param("i", $winner_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $auction_id = $row['AuctionID'];
        $user_id = $row['UserID'];
        $bid_id = $row['BidID'];
    } else {
        echo "Winner not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Winner Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update winner information form -->
    <h2><u>Update Winner Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="auction_id">Auction ID:</label>
        <input type="number" name="auction_id" value="<?php echo isset($auction_id) ? $auction_id : ''; ?>">
        <br><br>

        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <label for="bid_id">Bid ID:</label>
        <input type="number" name="bid_id" value="<?php echo isset($bid_id) ? $bid_id : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $auction_id = $_POST['auction_id'];
    $user_id = $_POST['user_id'];
    $bid_id = $_POST['bid_id'];

    // Update the winner in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE winners SET AuctionID=?, UserID=?, BidID=? WHERE WinnerID=?");
    $stmt->bind_param("iiii", $auction_id, $user_id, $bid_id, $winner_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: winners.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
