<?php
include('db_connection.php');

// Check if AuctionID is set
if(isset($_REQUEST['AuctionID'])) {
    $auction_id = $_REQUEST['AuctionID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM auctions WHERE AuctionID=?");
    $stmt->bind_param("i", $auction_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Auction ID is not set.";
}

$connection->close();
?>
