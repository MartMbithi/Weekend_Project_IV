-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 24, 2022 at 05:33 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `house_rental_mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `caretaker_assigns`
--

CREATE TABLE `caretaker_assigns` (
  `assignment_id` int(200) NOT NULL,
  `assignment_caretaker_id` int(200) NOT NULL,
  `assignment_property_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caretaker_assigns`
--

INSERT INTO `caretaker_assigns` (`assignment_id`, `assignment_caretaker_id`, `assignment_property_id`) VALUES
(2, 8, 1),
(3, 7, 3),
(5, 8, 4),
(6, 7, 11),
(7, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(200) NOT NULL,
  `category_code` varchar(200) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_code`, `category_name`) VALUES
(1, 'JVUFB71325', 'Bedsitters'),
(2, 'AYLST06814', 'Single'),
(3, 'VODQP34258', 'Condos'),
(4, 'ZMVFY68045', '2 Bedroooms');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(200) NOT NULL,
  `expense_ref` varchar(200) DEFAULT NULL,
  `expense_name` varchar(200) DEFAULT NULL,
  `expense_amount` varchar(200) DEFAULT NULL,
  `expense_desc` longtext DEFAULT NULL,
  `expense_date_added` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_ref`, `expense_name`, `expense_amount`, `expense_desc`, `expense_date_added`) VALUES
(2, 'TOKED47985', 'Electrical Repairs', '454500', 'Electrical Repairs expenses', '2022-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(200) NOT NULL,
  `payment_ref` varchar(200) NOT NULL,
  `payment_lease_id` int(200) NOT NULL,
  `payment_amount` varchar(200) NOT NULL,
  `payment_mode` varchar(200) NOT NULL,
  `payment_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_ref`, `payment_lease_id`, `payment_amount`, `payment_mode`, `payment_date`) VALUES
(5, 'D912S7Z34O', 1, '18000', 'Debit/Credit Card', '2022-03-13 11:40:54'),
(8, 'DOWT7L8P6E', 3, '18000', 'Cash', '13 Mar 2022 9:56am'),
(9, 'LXTDHBVUGK', 6, '36000', 'Debit/Credit Card', '15 Mar 2022 4:26am'),
(10, 'WMC28EK1A6', 7, '12500', 'Debit/Credit Card', '15 Mar 2022 12:51pm'),
(11, 'VN5G0PJCD4', 9, '15000', 'Cash', '24 Mar 2022 5:05pm');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(200) NOT NULL,
  `property_code` varchar(200) NOT NULL,
  `property_name` longtext NOT NULL,
  `property_cost` varchar(200) NOT NULL,
  `property_category_id` int(200) NOT NULL,
  `property_landlord_id` int(200) NOT NULL,
  `property_address` longtext NOT NULL,
  `property_status` varchar(200) NOT NULL DEFAULT 'Vacant',
  `property_img_1` longtext DEFAULT NULL,
  `property_img_2` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `property_code`, `property_name`, `property_cost`, `property_category_id`, `property_landlord_id`, `property_address`, `property_status`, `property_img_1`, `property_img_2`) VALUES
(1, 'UFMGK78325', 'James Flatts', '4500', 2, 4, '90126 Localhost', 'Leased', NULL, NULL),
(3, 'YKRVN86405', 'Jim Appartments', '45000', 3, 4, '90126 Localhost', 'Leased', NULL, NULL),
(4, 'SZVXF76481', 'Ice Age Appartments', '9000', 3, 4, '90126 Localhost Drive', 'Leased', NULL, NULL),
(5, 'QZOUJ30814', 'My Appartment', '12500', 4, 4, '127 9000 Localhost', 'Leased', 'QZOUJ30814garrett-parker-xQWLtlQb7L0-unsplash.jpg', 'QZOUJ30814alexandra-gorn-JIUjvqe2ZHg-unsplash.jpg'),
(6, 'XYJRS60192', '90236 Appartments', '5000', 4, 3, '9017 Localhost', 'Vacant', NULL, NULL),
(11, 'WHISL68053', 'Pike Appartments', '9000', 1, 4, '90 Lakeview ', 'Vacant', 'matthias-iordache-MVd4rDf4O2Q-unsplash.jpg', 'evangelos-mpikakis-_JAEIbT6KOM-unsplash.jpg'),
(12, 'LTKEZ45971', 'Iyke Appartments', '9000', 3, 3, '127 Lakeview Strt', 'Leased', 'LTKEZ45971matthias-iordache-MVd4rDf4O2Q-unsplash.jpg', 'LTKEZ45971garrett-parker-xQWLtlQb7L0-unsplash.jpg'),
(13, 'NLMYV06493', 'Apache Flatts', '15000', 3, 3, '127 Bronx New Yolk', 'Vacant', 'NLMYV06493sigmund-CwTfKH5edSk-unsplash.jpg', 'NLMYV06493asia-culturecenter-YjCY61CTRpE-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `property_leases`
--

CREATE TABLE `property_leases` (
  `lease_id` int(200) NOT NULL,
  `lease_ref` varchar(200) NOT NULL,
  `lease_property_id` int(200) NOT NULL,
  `lease_tenant_id` int(200) NOT NULL,
  `lease_duration` varchar(200) NOT NULL,
  `lease_payment_status` varchar(200) NOT NULL DEFAULT 'Pending',
  `lease_date_added` varchar(200) NOT NULL,
  `lease_eviction_status` int(200) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property_leases`
--

INSERT INTO `property_leases` (`lease_id`, `lease_ref`, `lease_property_id`, `lease_tenant_id`, `lease_duration`, `lease_payment_status`, `lease_date_added`, `lease_eviction_status`) VALUES
(1, 'HABCE90167', 1, 2, '4', 'Paid', '13 Mar 2022 7:42am', 0),
(3, 'ZEPXO78652', 1, 10, '4', 'Paid', '13 Mar 2022 9:12am', 0),
(4, 'LWBDX97310', 4, 10, '5', 'Pending', '15 Mar 2022 4:16am', 1),
(6, 'QXZUS06129', 4, 2, '4', 'Paid', '15 Mar 2022 4:24am', 0),
(7, 'LCZGP80519', 5, 2, '1', 'Paid', '15 Mar 2022 12:37pm', 0),
(8, 'CGMDH75462', 11, 2, '2', 'Pending', '24 Mar 2022 4:47pm', 1),
(9, 'SUEZO27391', 13, 2, '1', 'Paid', '24 Mar 2022 5:04pm', 1),
(10, 'WFIVU53769', 12, 2, '1', 'Pending', '24 Mar 2022 5:16pm', 1),
(11, 'HWOKQ38421', 11, 2, '3', 'Pending', '24 Mar 2022 5:17pm', 1),
(12, '', 12, 2, '4', 'Pending', '24 Mar 2022 5:32pm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `user_email` varchar(200) DEFAULT NULL,
  `user_phoneno` varchar(200) DEFAULT NULL,
  `user_address` longtext DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_access_level` varchar(200) DEFAULT NULL,
  `user_idno` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phoneno`, `user_address`, `user_password`, `user_access_level`, `user_idno`) VALUES
(1, 'System Administrator', 'sysadmin@gmail.com', '0712345678', '90126 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'admin', '35590051'),
(2, 'James Doe', 'jamesdoe@gmail.com', '071908786', '90238 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'tenant', '35574881'),
(3, 'Todd James', 'toddjames@gmail.com', '899763423', '9026 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'landlord', '78876313'),
(4, 'Jane Landlord Doe', 'janelandlorddoe@gmail.com', '+9003148913', '90126 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'landlord', '9001267'),
(7, 'Caretaker 001 ', 'caretaker001@gmail.com', '+1898412941', '90126 Localhost', '67a74306b06d0c01624fe0d0249a570f4d093747', 'caretaker', '35599885'),
(8, 'Caretaker 002', 'caretaker002@gmail.com', '+245899078', '90126 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'caretaker', '90012678'),
(10, 'Jane Doe', 'janedoe@gmail.90com', '9012677564', '90126 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'tenant', '9007874234'),
(12, 'Staff 001', 'staff90126-001@gmail.com', '088988998', '90126 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'staff', '901267547'),
(13, 'Staff 002', 'staff002@gmail.com', '08999977413', '90236 Localhost', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'staff', '906677312');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caretaker_assigns`
--
ALTER TABLE `caretaker_assigns`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `AssignedCaretaker` (`assignment_caretaker_id`),
  ADD KEY `AssignedProperty` (`assignment_property_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `PaymentLeases` (`payment_lease_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `PropertyCategory` (`property_category_id`),
  ADD KEY `PropertyOwner` (`property_landlord_id`);

--
-- Indexes for table `property_leases`
--
ALTER TABLE `property_leases`
  ADD PRIMARY KEY (`lease_id`),
  ADD KEY `leaseProprtyID` (`lease_property_id`),
  ADD KEY `LeaseTenantID` (`lease_tenant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caretaker_assigns`
--
ALTER TABLE `caretaker_assigns`
  MODIFY `assignment_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `property_leases`
--
ALTER TABLE `property_leases`
  MODIFY `lease_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `caretaker_assigns`
--
ALTER TABLE `caretaker_assigns`
  ADD CONSTRAINT `AssignedCaretaker` FOREIGN KEY (`assignment_caretaker_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AssignedProperty` FOREIGN KEY (`assignment_property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `PaymentLeases` FOREIGN KEY (`payment_lease_id`) REFERENCES `property_leases` (`lease_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `PropertyCategory` FOREIGN KEY (`property_category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `PropertyOwner` FOREIGN KEY (`property_landlord_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `property_leases`
--
ALTER TABLE `property_leases`
  ADD CONSTRAINT `LeaseTenantID` FOREIGN KEY (`lease_tenant_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leaseProprtyID` FOREIGN KEY (`lease_property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
