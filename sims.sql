-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 10:39 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sims`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE `employee_accounts` (
  `Employee_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `Person_id` int(8) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_accounts`
--

INSERT INTO `employee_accounts` (`Employee_id`, `Person_id`, `Password`) VALUES
(00000001, 1, '202cb962ac59075b964b07152d234b70'),
(00000002, 2, '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `Invoice_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Trans_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Total` double NOT NULL,
  `Discount` double NOT NULL,
  `Payment` double NOT NULL,
  `Payment_type` enum('Cash','Card','SIMS-Code') NOT NULL,
  `Card_number` varchar(50) DEFAULT NULL,
  `SIMS_code` int(8) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Invoice_id`, `Trans_id`, `Total`, `Discount`, `Payment`, `Payment_type`, `Card_number`, `SIMS_code`) VALUES
(0000000001, 0000000001, 500, 0, 500, 'Cash', NULL, NULL),
(0000000002, 0000000004, 1150, 0, 1200, 'Cash', NULL, NULL),
(0000000003, 0000000005, 2400, 0, 2500, 'Cash', NULL, NULL),
(0000000050, 0000000053, 1200, 0, 1500, 'Cash', NULL, 00000030),
(0000000051, 0000000054, 72, 0, 100, 'Cash', NULL, 00000030),
(0000000052, 0000000055, 1200, 0, 1500, 'Cash', NULL, 00000030),
(0000000055, 0000000056, 1450, 0, 2000, 'Cash', NULL, NULL),
(0000000056, 0000000057, 5120, 0, 5200, 'Cash', NULL, 00000030);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Trans_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Prod_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Trans_id`, `Prod_id`, `Qty`) VALUES
(0000000001, 0000000001, 100),
(0000000001, 0000000007, 20),
(0000000004, 0000000002, 500),
(0000000004, 0000000008, 50),
(0000000005, 0000000001, 100),
(0000000005, 0000000004, 100),
(0000000053, 0000000002, 10),
(0000000054, 0000000001, 6),
(0000000055, 0000000001, 100),
(0000000056, 0000000001, 20),
(0000000056, 0000000003, 1),
(0000000056, 0000000005, 20),
(0000000056, 0000000008, 20),
(0000000056, 0000000009, 20),
(0000000057, 0000000002, 40),
(0000000057, 0000000004, 10);

-- --------------------------------------------------------

--
-- Table structure for table `person_info`
--

CREATE TABLE `person_info` (
  `Person_id` int(8) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL DEFAULT 'user.png',
  `Contact_no` varchar(15) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Age` int(3) DEFAULT NULL,
  `Gender` enum('Male','Female') DEFAULT NULL,
  `Date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `Person_type` enum('Cashier','Manager','Supplier','Customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person_info`
--

INSERT INTO `person_info` (`Person_id`, `Fname`, `Lname`, `Email`, `Image`, `Contact_no`, `Address`, `Age`, `Gender`, `Date_added`, `Person_type`) VALUES
(1, 'Rj123', 'Oliverio', 'rj@gmail.com', '../images/user.png', '9123456789', 'asd', 45, 'Male', '2020-03-20 16:32:28', 'Cashier'),
(2, 'Humera', 'Ardiente', 'hums@gmail.com', 'user.png', '9123654987', 'Lapu2x, Magellan', 35, 'Female', '2020-03-20 16:32:28', 'Manager'),
(32, 'Aljann', 'Ondoy', 'aljann.ondoy@gmail.com', 'user.png', '09123456789', 'Tuburan, Cebu', 20, 'Male', '2020-03-25 20:41:45', 'Supplier'),
(33, 'Rj', 'Oliverio', 'oliverioyani@yahoo.com', 'user.png', '09238694442', 'poblacion,compostela,cebu', 20, 'Male', '2020-03-26 21:11:22', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Prod_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `ProdName` varchar(255) NOT NULL,
  `ProdType` enum('Beverages','Bread','Canned','Dairy','Baking Goods','Produce','Cleaners','Paper Goods','Personal Care','Other') NOT NULL,
  `Qty` int(10) NOT NULL,
  `Price` double NOT NULL,
  `Date_added` date NOT NULL DEFAULT current_timestamp(),
  `Expiry_date` date NOT NULL,
  `Supplier_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Prod_id`, `ProdName`, `ProdType`, `Qty`, `Price`, `Date_added`, `Expiry_date`, `Supplier_id`) VALUES
(0000000001, 'Coca-Cola', 'Beverages', 140, 12, '2020-03-25', '2021-03-25', 1),
(0000000002, 'Pampers', 'Personal Care', 700, 120, '2020-03-25', '2021-03-25', 1),
(0000000003, 'Tissues', 'Paper Goods', 15, 50, '2020-03-25', '2021-03-25', 1),
(0000000004, 'Cabbage', 'Produce', 290, 32, '2020-03-25', '2021-03-25', 1),
(0000000005, 'Carrots', 'Produce', 438, 20, '2020-03-25', '2021-03-25', 1),
(0000000006, 'Hersheys', 'Dairy', 0, 75, '2020-03-25', '2021-03-25', 1),
(0000000007, 'Axe Gold', 'Personal Care', 80, 40, '2020-03-25', '2021-03-25', 1),
(0000000008, 'Corned Beef', 'Canned', 240, 20, '2020-03-25', '2021-03-25', 1),
(0000000009, 'Beef Loaf', 'Canned', 190, 18, '2020-03-25', '2021-03-25', 1),
(0000000010, 'Nature Spring 1L', 'Beverages', 150, 20, '2020-03-25', '2021-03-25', 1),
(0000000011, 'SIMS Code Membership', 'Other', 100, 150, '0000-00-00', '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `simscode_membership`
--

CREATE TABLE `simscode_membership` (
  `SIMS_code` int(8) UNSIGNED ZEROFILL NOT NULL,
  `Person_id` int(8) NOT NULL,
  `Points` double NOT NULL,
  `Date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `Expiry_date` date NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simscode_membership`
--

INSERT INTO `simscode_membership` (`SIMS_code`, `Person_id`, `Points`, `Date_created`, `Expiry_date`, `Active`) VALUES
(00000030, 33, 96, '2020-03-26 21:11:22', '2022-03-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `simscode_transaction`
--

CREATE TABLE `simscode_transaction` (
  `SIMS_trans_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `SIMS_code` int(8) UNSIGNED ZEROFILL NOT NULL,
  `Invoice_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Transaction_type` enum('Add','Deduct') NOT NULL,
  `Amount` double NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `simscode_transaction`
--

INSERT INTO `simscode_transaction` (`SIMS_trans_id`, `SIMS_code`, `Invoice_id`, `Transaction_type`, `Amount`, `Date`) VALUES
(0000000017, 00000030, 0000000050, 'Add', 12, '2020-04-25'),
(0000000018, 00000030, 0000000052, 'Add', 12, '2020-04-25'),
(0000000019, 00000030, 0000000056, 'Add', 51, '2020-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_store`
--

CREATE TABLE `supplier_store` (
  `Supplier_id` int(10) NOT NULL,
  `Person_id` int(8) NOT NULL,
  `Storename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_store`
--

INSERT INTO `supplier_store` (`Supplier_id`, `Person_id`, `Storename`) VALUES
(1, 32, 'Aljan WholeSale'),
(2, 2, 'ShopNimo Card');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `Trans_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Employee_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`Trans_id`, `Employee_id`, `Date`) VALUES
(0000000001, 00000001, '2020-03-27 00:46:56'),
(0000000004, 00000001, '2020-04-16 13:47:18'),
(0000000005, 00000001, '2020-04-16 13:47:30'),
(0000000053, 00000001, '2020-04-25 20:09:30'),
(0000000054, 00000001, '2020-04-25 20:10:59'),
(0000000055, 00000001, '2020-04-25 20:24:00'),
(0000000056, 00000001, '2020-05-02 19:29:52'),
(0000000057, 00000001, '2020-05-03 21:04:29'),
(0000000058, 00000001, '2021-01-02 21:54:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD PRIMARY KEY (`Employee_id`),
  ADD KEY `Person_id` (`Person_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Invoice_id`),
  ADD KEY `Trans_id` (`Trans_id`),
  ADD KEY `SIMS_code` (`SIMS_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Trans_id`,`Prod_id`),
  ADD KEY `Trans_id` (`Trans_id`),
  ADD KEY `Prod_id` (`Prod_id`);

--
-- Indexes for table `person_info`
--
ALTER TABLE `person_info`
  ADD PRIMARY KEY (`Person_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Prod_id`),
  ADD KEY `Supplier_id` (`Supplier_id`);

--
-- Indexes for table `simscode_membership`
--
ALTER TABLE `simscode_membership`
  ADD PRIMARY KEY (`SIMS_code`),
  ADD KEY `Person_id` (`Person_id`);

--
-- Indexes for table `simscode_transaction`
--
ALTER TABLE `simscode_transaction`
  ADD PRIMARY KEY (`SIMS_trans_id`),
  ADD KEY `Invoice_id` (`Invoice_id`),
  ADD KEY `SIMS_code` (`SIMS_code`);

--
-- Indexes for table `supplier_store`
--
ALTER TABLE `supplier_store`
  ADD PRIMARY KEY (`Supplier_id`),
  ADD KEY `Person_id` (`Person_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`Trans_id`),
  ADD KEY `Employee_id` (`Employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `Employee_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Invoice_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `person_info`
--
ALTER TABLE `person_info`
  MODIFY `Person_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Prod_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `simscode_membership`
--
ALTER TABLE `simscode_membership`
  MODIFY `SIMS_code` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `simscode_transaction`
--
ALTER TABLE `simscode_transaction`
  MODIFY `SIMS_trans_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `supplier_store`
--
ALTER TABLE `supplier_store`
  MODIFY `Supplier_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `Trans_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD CONSTRAINT `employee_accounts_ibfk_1` FOREIGN KEY (`Person_id`) REFERENCES `person_info` (`Person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Trans_id`) REFERENCES `transactions` (`Trans_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`SIMS_code`) REFERENCES `simscode_membership` (`SIMS_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Trans_id`) REFERENCES `transactions` (`Trans_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`Prod_id`) REFERENCES `products` (`Prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Supplier_id`) REFERENCES `supplier_store` (`Supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simscode_membership`
--
ALTER TABLE `simscode_membership`
  ADD CONSTRAINT `simscode_membership_ibfk_1` FOREIGN KEY (`Person_id`) REFERENCES `person_info` (`Person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simscode_transaction`
--
ALTER TABLE `simscode_transaction`
  ADD CONSTRAINT `simscode_transaction_ibfk_1` FOREIGN KEY (`Invoice_id`) REFERENCES `invoice` (`Invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simscode_transaction_ibfk_2` FOREIGN KEY (`SIMS_code`) REFERENCES `simscode_membership` (`SIMS_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_store`
--
ALTER TABLE `supplier_store`
  ADD CONSTRAINT `Person_pkfk` FOREIGN KEY (`Person_id`) REFERENCES `person_info` (`Person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`Employee_id`) REFERENCES `employee_accounts` (`Employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
