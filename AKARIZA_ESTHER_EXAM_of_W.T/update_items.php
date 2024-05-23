<?php
include('db_connection.php');

// Check if ItemID is set
if (isset($_REQUEST['ItemID'])) {
    $item_id = $_REQUEST['ItemID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM items WHERE ItemID=?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['Title'];
        $description = $row['Description'];
        $starting_price = $row['StartingPrice'];
        $category = $row['Category'];
    } else {
        echo "Item not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Item Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update item information form -->
    <h2><u>Update Item Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
        <br><br>

        <label for="description">Description:</label>
        <input type="text" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
        <br><br>

        <label for="starting_price">Starting Price:</label>
        <input type="number" name="starting_price" value="<?php echo isset($starting_price) ? $starting_price : ''; ?>">
        <br><br>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo isset($category) ? $category : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $starting_price = $_POST['starting_price'];
    $category = $_POST['category'];

    // Update the item in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE items SET Title=?, Description=?, StartingPrice=?, Category=? WHERE ItemID=?");
    $stmt->bind_param("ssisi", $title, $description, $starting_price, $category, $item_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: items.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
