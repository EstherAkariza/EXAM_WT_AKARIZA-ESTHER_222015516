<?php
include('db_connection.php');

// Check if WatchlistID is set
if (isset($_REQUEST['WatchlistID'])) {
    $watchlist_id = $_REQUEST['WatchlistID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM watchlist WHERE WatchlistID=?");
    $stmt->bind_param("i", $watchlist_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['UserID'];
        $item_id = $row['ItemID'];
    } else {
        echo "Watchlist not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Watchlist Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update watchlist information form -->
    <h2><u>Update Watchlist Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br>

        <label for="item_id">Item ID:</label>
        <input type="number" name="item_id" value="<?php echo isset($item_id) ? $item_id : ''; ?>">
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

    // Update the watchlist in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE watchlist SET UserID=?, ItemID=? WHERE WatchlistID=?");
    $stmt->bind_param("iii", $user_id, $item_id, $watchlist_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: watchlist.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
