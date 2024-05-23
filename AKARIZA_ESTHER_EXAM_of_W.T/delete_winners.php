<?php
include('db_connection.php');

// Check if WinnerID is set
if(isset($_REQUEST['WinnerID'])) {
    $winner_id = $_REQUEST['WinnerID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM winners WHERE WinnerID=?");
    $stmt->bind_param("i", $winner_id);
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
        <input type="hidden" name="winner_id" value="<?php echo $winner_id; ?>">
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
    echo "Winner ID is not set.";
}

$connection->close();
?>
