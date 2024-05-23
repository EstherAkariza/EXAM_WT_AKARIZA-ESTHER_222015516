<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {

 include('db_connection.php');

    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'auctions' => "SELECT  AuctionID FROM auctions WHERE AuctionID LIKE '%$searchTerm%'",
        'bids' => "SELECT BidID FROM bids WHERE BidID LIKE '%$searchTerm%'",
        'items' => "SELECT  Title FROM items WHERE  Title LIKE '%$searchTerm%'",
        'reports' => "SELECT  ReportID FROM reports WHERE ReportID LIKE '%$searchTerm%'",
        'payments' => "SELECT PaymentStatus FROM payments WHERE PaymentStatus LIKE '%$searchTerm%'",
         'reviews' => "SELECT ReviewID FROM reviews WHERE ReviewID LIKE '%$searchTerm%'",
        'shipping_details' => "SELECT  ShippingMethod FROM shipping_details WHERE ShippingMethod LIKE '%$searchTerm%'",
        'watchlist' => "SELECT WatchlistID FROM watchlist WHERE WatchlistID LIKE '%$searchTerm%'",
        'winners' => "SELECT WinnerID FROM winners WHERE WinnerID LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
