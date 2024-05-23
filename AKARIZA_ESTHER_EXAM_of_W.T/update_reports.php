<?php
include('db_connection.php');

// Check if ReportID is set
if (isset($_REQUEST['ReportID'])) {
    $report_id = $_REQUEST['ReportID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM reports WHERE ReportID=?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reporter_id = $row['ReporterID'];
        $reported_user_id = $row['ReportedUserID'];
        $reported_item_id = $row['ReportedItemID'];
        $report_reason = $row['ReportReason'];
        $report_time = $row['ReportTime'];
    } else {
        echo "Report not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Report Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update report information form -->
    <h2><u>Update Report Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="reporter_id">Reporter ID:</label>
        <input type="number" name="reporter_id" value="<?php echo isset($reporter_id) ? $reporter_id : ''; ?>">
        <br><br>

        <label for="reported_user_id">Reported User ID:</label>
        <input type="number" name="reported_user_id" value="<?php echo isset($reported_user_id) ? $reported_user_id : ''; ?>">
        <br><br>

        <label for="reported_item_id">Reported Item ID:</label>
        <input type="number" name="reported_item_id" value="<?php echo isset($reported_item_id) ? $reported_item_id : ''; ?>">
        <br><br>

        <label for="report_reason">Report Reason:</label>
        <input type="text" name="report_reason" value="<?php echo isset($report_reason) ? $report_reason : ''; ?>">
        <br><br>

        <label for="report_time">Report Time:</label>
        <input type="text" name="report_time" value="<?php echo isset($report_time) ? $report_time : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $reporter_id = $_POST['reporter_id'];
    $reported_user_id = $_POST['reported_user_id'];
    $reported_item_id = $_POST['reported_item_id'];
    $report_reason = $_POST['report_reason'];
    $report_time = $_POST['report_time'];

    // Update the report in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE reports SET ReporterID=?, ReportedUserID=?, ReportedItemID=?, ReportReason=?, ReportTime=? WHERE ReportID=?");
    $stmt->bind_param("iiissi", $reporter_id, $reported_user_id, $reported_item_id, $report_reason, $report_time, $report_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: reports.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
