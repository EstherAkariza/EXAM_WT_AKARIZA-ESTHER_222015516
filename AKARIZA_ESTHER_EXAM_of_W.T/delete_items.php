<?php
include('db_connection.php');

// Check if ItemID is set
if(isset($_REQUEST['ItemID'])) {
    $item_id = $_REQUEST['ItemID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM items WHERE ItemID=?");
    $stmt->bind_param("i", $item_id);
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
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
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
    echo "Item ID is not set.";
}

$connection->close();
?>
