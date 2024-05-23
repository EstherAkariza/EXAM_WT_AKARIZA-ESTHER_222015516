<?php
include('db_connection.php');

// Check if PaymentID is set
if (isset($_REQUEST['PaymentID'])) {
    $payment_id = $_REQUEST['PaymentID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM payments WHERE PaymentID=?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bid_id = $row['BidID'];
        $payment_amount = $row['PaymentAmount'];
        $payment_date = $row['PaymentDate'];
        $payment_status = $row['PaymentStatus'];
    } else {
        echo "Payment not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Payment Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update payment information form -->
    <h2><u>Update Payment Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="bid_id">Bid ID:</label>
        <input type="number" name="bid_id" value="<?php echo isset($bid_id) ? $bid_id : ''; ?>">
        <br><br>

        <label for="payment_amount">Payment Amount:</label>
        <input type="text" name="payment_amount" value="<?php echo isset($payment_amount) ? $payment_amount : ''; ?>">
        <br><br>

        <label for="payment_date">Payment Date:</label>
        <input type="text" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>">
        <br><br>

        <label for="payment_status">Payment Status:</label>
        <input type="text" name="payment_status" value="<?php echo isset($payment_status) ? $payment_status : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $bid_id = $_POST['bid_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];

    // Update the payment in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE payments SET BidID=?, PaymentAmount=?, PaymentDate=?, PaymentStatus=? WHERE PaymentID=?");
    $stmt->bind_param("idsii", $bid_id, $payment_amount, $payment_date, $payment_status, $payment_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: payments.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
