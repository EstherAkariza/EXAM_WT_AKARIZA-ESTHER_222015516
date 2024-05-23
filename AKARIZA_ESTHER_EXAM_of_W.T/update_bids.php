<?php
include('db_connection.php');

// Check if BidID is set
if (isset($_REQUEST['BidID'])) {
    $bid_id = $_REQUEST['BidID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM bids WHERE BidID=?");
    $stmt->bind_param("i", $bid_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $auction_id = $row['AuctionID'];
        $bidder_id = $row['BidderID'];
        $amount = $row['Amount'];
        $bid_time = $row['BidTime'];
    } else {
        echo "Bid not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Bid Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update bid information form -->
    <h2><u>Update Bid Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="auction_id">Auction ID:</label>
        <input type="number" name="auction_id" value="<?php echo isset($auction_id) ? $auction_id : ''; ?>">
        <br><br>

        <label for="bidder_id">Bidder ID:</label>
        <input type="number" name="bidder_id" value="<?php echo isset($bidder_id) ? $bidder_id : ''; ?>">
        <br><br>

        <label for="amount">Amount:</label>
        <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>">
        <br><br>

        <label for="bid_time">Bid Time:</label>
        <input type="text" name="bid_time" value="<?php echo isset($bid_time) ? $bid_time : ''; ?>">
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
    $bidder_id = $_POST['bidder_id'];
    $amount = $_POST['amount'];
    $bid_time = $_POST['bid_time'];

    // Update the bid in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE bids SET AuctionID=?, BidderID=?, Amount=?, BidTime=? WHERE BidID=?");
    $stmt->bind_param("iiisi", $auction_id, $bidder_id, $amount, $bid_time, $bid_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: bids.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
