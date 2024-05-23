-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 05:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctionplatform`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `AuctionID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`AuctionID`, `ItemID`, `UserID`, `StartDate`, `EndDate`) VALUES
(1, 5, 3, '2024-05-10 09:00:00', '2024-05-12 09:00:00'),
(2, 2, 2, '2024-05-11 10:00:00', '2024-05-13 10:00:00'),
(3, 3, 4, '2024-05-12 11:00:00', '2024-05-14 11:00:00'),
(4, 1, 2, '2024-05-13 12:00:00', '2024-05-15 12:00:00'),
(5, 3, 1, '2024-05-14 13:00:00', '2024-05-16 13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `BidID` int(11) NOT NULL,
  `AuctionID` int(11) DEFAULT NULL,
  `BidderID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `BidTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`BidID`, `AuctionID`, `BidderID`, `Amount`, `BidTime`) VALUES
(6, 3, 2, 50.00, '2024-05-11 09:30:00'),
(7, 5, 3, 75.00, '2024-05-12 10:30:00'),
(8, 3, 4, 100.00, '2024-05-13 11:30:00'),
(9, 4, 2, 125.00, '2024-05-14 12:30:00'),
(10, 2, 1, 150.00, '2024-05-15 13:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `StartingPrice` float DEFAULT NULL,
  `Category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Title`, `Description`, `StartingPrice`, `Category`) VALUES
(1, 'Smartphone', 'Brand new smartphone with high-resolution display.', 499.99, 'Electronics'),
(2, 'Coffee Maker', 'Premium coffee maker for brewing delicious coffee.', 89.99, 'Kitchen Appliances'),
(3, 'Running Shoes', 'High-performance running shoes for athletes.', 129.99, 'Sports & Outdoors'),
(4, 'Digital Camera', 'Compact digital camera for capturing stunning photos.', 349.99, 'Electronics'),
(5, 'Gaming Console', 'Next-generation gaming console for immersive gaming experiences.', 399.99, 'Electronics');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `BidID` int(11) DEFAULT NULL,
  `PaymentAmount` float DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `BidID`, `PaymentAmount`, `PaymentDate`, `PaymentStatus`) VALUES
(6, 10, 5000, '2024-05-11', 'Completed'),
(7, 8, 7500, '2024-05-12', 'Completed'),
(8, 9, 10000, '2024-05-13', 'Completed'),
(9, 7, 12500, '2024-05-14', 'Completed'),
(10, 6, 15000, '2024-05-15', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ReportID` int(11) NOT NULL,
  `ReporterID` int(11) DEFAULT NULL,
  `ReportedUserID` int(11) DEFAULT NULL,
  `ReportedItemID` int(11) DEFAULT NULL,
  `ReportReason` text DEFAULT NULL,
  `ReportTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`ReportID`, `ReporterID`, `ReportedUserID`, `ReportedItemID`, `ReportReason`, `ReportTime`) VALUES
(1, 1, 2, 2, 'Seller is not responding to messages.', '2024-05-12 16:00:00'),
(2, 2, 3, 4, 'Item not as described.', '2024-05-13 16:00:00'),
(3, 3, 4, 2, 'Suspicious activity observed.', '2024-05-14 16:00:00'),
(4, 4, 2, 3, 'Seller has a history of non-delivery.', '2024-05-15 16:00:00'),
(5, 5, 1, 1, 'Item appears to be counterfeit.', '2024-05-16 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `ReviewText` text DEFAULT NULL,
  `ReviewDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `UserID`, `ItemID`, `Rating`, `ReviewText`, `ReviewDate`) VALUES
(1, 2, 1, 5, 'Great item! Exactly as described.', '2024-05-12 15:00:00'),
(2, 3, 2, 4, 'Good item, but shipping took longer than expected.', '2024-05-13 15:00:00'),
(3, 4, 3, 4, 'Item arrived in good condition, happy with purchase.', '2024-05-14 15:00:00'),
(4, 2, 4, 5, 'Excellent item, fast shipping!', '2024-05-15 15:00:00'),
(5, 1, 5, 5, 'Very satisfied with the item. Thank you!', '2024-05-16 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `ShippingDetailsID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `ShippingCost` decimal(10,2) DEFAULT NULL,
  `ShippingMethod` varchar(255) DEFAULT NULL,
  `EstimatedDeliveryTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`ShippingDetailsID`, `ItemID`, `ShippingCost`, `ShippingMethod`, `EstimatedDeliveryTime`) VALUES
(1, 5, 5.00, 'bk', 5),
(2, 2, 7.00, 'momo pay', 3),
(3, 1, 10.00, 'equity', 7),
(4, 4, 8.00, 'cash', 4),
(5, 3, 6.00, 'Momo', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `activation_code` varchar(50) DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `creationdate`, `activation_code`, `is_activated`) VALUES
(1, 'AKARIZA', 'ESTHER', 'esterkarza', 'esterakariza@gmail.com', '07855544423', '$2y$10$LVZYoixEIgZmL3WRuinRee/lYPArvzkuJMWy1EZ0o.l9OqHyz6FJa', '2024-05-16 15:12:57', '2345', 0),
(2, 'thomas', 'habimana', 'thomashbmn', 'habimana@gmail.com', '07855544423', '$2y$10$NzHMfFSHzS3E4r/C9i3kmeAmlkGEWCLWuRWvDR6AX1B21nkuUwNZ6', '2024-05-16 15:13:40', '234543', 0),
(3, 'ornela', 'tumukunde', 'ornelat', 'tumukundeornela@gmail.com', '0789876543', '$2y$10$PxodiJ04Y6ubRi4dVnSDzu7T3Q.0Pl2aVVy5JuFVOBvuPrTQkzLly', '2024-05-16 15:14:26', '8888', 0),
(4, 'poulisca', 'vincent', 'pulisivincnt', 'vincentpoulisca@gmail.com', '07567876543', '$2y$10$s.r9jxF/6YYd3UGC0a9hhOM70hRnumZt6kflPTn5w9BNECN4YtLzO', '2024-05-16 15:15:21', '98765', 0);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `WatchlistID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`WatchlistID`, `UserID`, `ItemID`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 4),
(4, 4, 5),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `WinnerID` int(11) NOT NULL,
  `AuctionID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BidID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`WinnerID`, `AuctionID`, `UserID`, `BidID`) VALUES
(1, 2, NULL, 8),
(2, 4, NULL, 10),
(3, 5, NULL, 9),
(4, 3, NULL, 7),
(5, 1, NULL, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`AuctionID`),
  ADD KEY `ItemID` (`ItemID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`BidID`),
  ADD KEY `AuctionID` (`AuctionID`),
  ADD KEY `BidderID` (`BidderID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `BidID` (`BidID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `ReportedUserID` (`ReportedUserID`),
  ADD KEY `ReportedItemID` (`ReportedItemID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`ShippingDetailsID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`WatchlistID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ItemID` (`ItemID`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`WinnerID`),
  ADD KEY `AuctionID` (`AuctionID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BidID` (`BidID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `AuctionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `BidID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `ShippingDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `WatchlistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `WinnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`),
  ADD CONSTRAINT `auctions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`AuctionID`) REFERENCES `auctions` (`AuctionID`),
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`BidderID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`BidID`) REFERENCES `bids` (`BidID`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`ReportedUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`ReportedItemID`) REFERENCES `items` (`ItemID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`);

--
-- Constraints for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD CONSTRAINT `shipping_details_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`);

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`);

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_1` FOREIGN KEY (`AuctionID`) REFERENCES `auctions` (`AuctionID`),
  ADD CONSTRAINT `winners_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `winners_ibfk_3` FOREIGN KEY (`BidID`) REFERENCES `bids` (`BidID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
