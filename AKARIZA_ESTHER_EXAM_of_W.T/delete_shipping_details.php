<?php
include('db_connection.php');

// Check if ShippingDetailsID is set
if(isset($_REQUEST['ShippingDetailsID'])) {
    $shipping_details_id = $_REQUEST['ShippingDetailsID'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM shipping_details WHERE ShippingDetailsID=?");
    $stmt->bind_param("i", $shipping_details_id);
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
        <input type="hidden" name="shipping_details_id" value="<?php echo $shipping_details_id; ?>">
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
    echo "Shipping Details ID is not set.";
}

$connection->close();
?>
