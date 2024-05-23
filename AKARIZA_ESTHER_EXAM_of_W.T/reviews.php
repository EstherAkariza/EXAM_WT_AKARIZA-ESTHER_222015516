<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="mystyle.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reviews Page</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 15px; /* Adjust this value as needed */
      padding: 8px;
    }
  </style>

  <!-- JavaScript validation and content load for insert data-->
  <script>
    function confirmInsert() {
        return confirm('Are you sure you want to insert this record?');
    }
  </script>
</head>

<body bgcolor="darkgray">
<header>
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
      <img src="./image/log.jpeg" width="90" height="60" alt="Logo">
    </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./auctions.php">Auctions</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./bids.php">Bids</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./items.php">Items</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./payments.php">Payments</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./reports.php">Reports</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./reviews.php">REVIEWS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./shipping_details.php">Shipping Details</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./watchlist.php">Watchlist</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./winners.php">Winners</a></li>
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li>
  </ul>
</header>

<section>
  <h1><u>Reviews Form</u></h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="ReviewID">ReviewID:</label>
    <input type="number" id="ReviewID" name="ReviewID" required><br><br>
    <label for="UserID">UserID:</label>
    <input type="number" id="UserID" name="UserID" required><br><br>
    <label for="ItemID">ItemID:</label>
    <input type="text" id="ItemID" name="ItemID" required><br><br>
    <label for="Rating">Rating:</label>
    <input type="text" id="Rating" name="Rating" required><br><br>
    <label for="ReviewText">ReviewText:</label>
    <input type="text" id="ReviewText" name="ReviewText" required><br><br>
    <label for="ReviewDate">ReviewDate:</label>
    <input type="date" id="ReviewDate" name="ReviewDate" required><br><br>
    <input type="submit" name="add" value="Insert">
  </form>

  <?php
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Include database connection file
      include('db_connection.php');
      // Prepare and bind the parameters
      $stmt = $connection->prepare("INSERT INTO reviews(ReviewID, UserID, ItemID, Rating, ReviewText, ReviewDate) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("iiisss", $ReviewID, $UserID, $ItemID, $Rating, $ReviewText, $ReviewDate);
      // Set parameters and execute
      $ReviewID = $_POST['ReviewID'];
      $UserID = $_POST['UserID'];
      $ItemID = $_POST['ItemID'];
      $Rating = $_POST['Rating'];
      $ReviewText = $_POST['ReviewText'];
      $ReviewDate = $_POST['ReviewDate'];
      if ($stmt->execute() === TRUE) {
          echo "New record has been added successfully";
      } else {
          echo "Error: " . $stmt->error;
      }
      $stmt->close();
      $connection->close();
  }
  ?>
</section>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Review Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
  <center><h2>Reviews Table</h2></center>
  <table border="3">
    <tr>
      <th>ReviewID</th>
      <th>UserID</th>
      <th>ItemID</th>
      <th>Rating</th>
      <th>ReviewText</th>
      <th>ReviewDate</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    include('db_connection.php');
    // Prepare SQL query to retrieve all reviews
    $sql = "SELECT * FROM reviews";
    $result = $connection->query($sql);
    // Check if there are any reviews
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            $ReviewID = $row['ReviewID']; // Fetch the ReviewID
            echo "<tr>
              <td>" . $row['ReviewID'] . "</td>
              <td>" . $row['UserID'] . "</td>
              <td>" . $row['ItemID'] . "</td>
              <td>" . $row['Rating'] . "</td>
              <td>" . $row['ReviewText'] . "</td>
              <td>" . $row['ReviewDate'] . "</td>
              <td><a style='padding:4px' href='delete_reviews.php?ReviewID=$ReviewID'>Delete</a></td> 
              <td><a style='padding:4px' href='update_reviews.php?ReviewID=$ReviewID'>Update</a></td> 
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No data found</td></tr>";
    }
    // Close the database connection
    $connection->close();
    ?>
  </table>
</body>
</html>

<footer>
  <center> 
   <b><h2>UR CBE BIT &copy; 2024 &reg;, Designed by: AKARIZA ESTHER</h2></b>
  </center>
</footer>
</body>
</html>
