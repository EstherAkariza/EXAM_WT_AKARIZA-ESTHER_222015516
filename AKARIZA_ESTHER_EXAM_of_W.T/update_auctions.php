<?php
include('db_connection.php');

// Check if AuctionID is set
if (isset($_REQUEST['AuctionID'])) {
    $auction_id = $_REQUEST['AuctionID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM auctions WHERE AuctionID=?");
    $stmt->bind_param("i", $auction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $item_id = $row['ItemID'];
        $user_id = $row['UserID'];
        $start_date = $row['StartDate'];
        $end_date = $row['EndDate'];
    } else {
        echo "Auction not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Auction Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update auction information form -->
    <h2><u>Update Auction Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="item_id">Item ID:</label>
        <input type="number" name="item_id" value="<?php echo isset($item_id) ? $item_id : ''; ?>">
        <br><br>

        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <label for="start_date">Start Date:</label>
        <input type="text" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
        <br><br>

        <label for="end_date">End Date:</label>
        <input type="text" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $item_id = $_POST['item_id'];
    $user_id = $_POST['user_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the auction in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE auctions SET ItemID=?, UserID=?, StartDate=?, EndDate=? WHERE AuctionID=?");
    $stmt->bind_param("iissi", $item_id, $user_id, $start_date, $end_date, $auction_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: auctions.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
