<?php
include('db_connection.php');

// Check if ShippingDetailsID is set
if (isset($_REQUEST['ShippingDetailsID'])) {
    $shipping_details_id = $_REQUEST['ShippingDetailsID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM shipping_details WHERE ShippingDetailsID=?");
    $stmt->bind_param("i", $shipping_details_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $item_id = $row['ItemID'];
        $shipping_cost = $row['ShippingCost'];
        $shipping_method = $row['ShippingMethod'];
        $estimated_delivery_time = $row['EstimatedDeliveryTime'];
    } else {
        echo "Shipping details not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Shipping Details</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update shipping details form -->
    <h2><u>Update Shipping Details</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="item_id">Item ID:</label>
        <input type="number" name="item_id" value="<?php echo isset($item_id) ? $item_id : ''; ?>">
        <br><br>

        <label for="shipping_cost">Shipping Cost:</label>
        <input type="text" name="shipping_cost" value="<?php echo isset($shipping_cost) ? $shipping_cost : ''; ?>">
        <br><br>

        <label for="shipping_method">Shipping Method:</label>
        <input type="text" name="shipping_method" value="<?php echo isset($shipping_method) ? $shipping_method : ''; ?>">
        <br><br>

        <label for="estimated_delivery_time">Estimated Delivery Time:</label>
        <input type="text" name="estimated_delivery_time" value="<?php echo isset($estimated_delivery_time) ? $estimated_delivery_time : ''; ?>">
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
    $shipping_cost = $_POST['shipping_cost'];
    $shipping_method = $_POST['shipping_method'];
    $estimated_delivery_time = $_POST['estimated_delivery_time'];

    // Update the shipping details in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE shipping_details SET ItemID=?, ShippingCost=?, ShippingMethod=?, EstimatedDeliveryTime=? WHERE ShippingDetailsID=?");
    $stmt->bind_param("idssi", $item_id, $shipping_cost, $shipping_method, $estimated_delivery_time, $shipping_details_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: shipping_details.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
