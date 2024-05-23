<?php
include('db_connection.php');

// Check if BidID is set
if(isset($_REQUEST['BidID'])) {
    $bid_id = $_REQUEST['BidID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM bids WHERE BidID=?");
    $stmt->bind_param("i", $bid_id);
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
        <input type="hidden" name="bid_id" value="<?php echo $bid_id; ?>">
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
    echo "Bid ID is not set.";
}

$connection->close();
?>
