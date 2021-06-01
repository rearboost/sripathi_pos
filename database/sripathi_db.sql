-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 01:22 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sripathi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `nic` text NOT NULL,
  `contact` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `nic`, `contact`) VALUES
(1, 'anne fernando', 'Alwiz road, Bentara', '984567892V', 771234567),
(2, 'Imashi Liyanage', 'Egodamulla, Ahungalla', '952550057V', 771234567);

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_items`
--

CREATE TABLE `dashboard_items` (
  `item_id` int(11) NOT NULL,
  `item` varchar(250) NOT NULL,
  `min_price` double(10,2) NOT NULL,
  `max_price` double(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock_qty` int(11) NOT NULL,
  `stock_status` varchar(50) NOT NULL DEFAULT 'instock'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `customer` varchar(250) NOT NULL,
  `date` varchar(100) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `cheque_no` varchar(100) NOT NULL,
  `cheque_dueDate` varchar(100) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `card_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `total`, `discount`, `payment`, `customer`, `date`, `payment_type`, `bank`, `cheque_no`, `cheque_dueDate`, `card_type`, `card_no`) VALUES
(1, '40000.00', '0.00', '40000.00', 'Amanda Ranasinghe', '2021-06-02', 'cash', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product` varchar(300) NOT NULL,
  `measurement` varchar(10) NOT NULL,
  `weight` double(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product`, `measurement`, `weight`, `price`, `discount`, `amount`) VALUES
(1, 1, 'Rings', '18', 200.00, '200.00', '0.00', '40000.00');

-- --------------------------------------------------------

--
-- Table structure for table `material_stock`
--

CREATE TABLE `material_stock` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `measurement` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `note` text NOT NULL,
  `update_date` varchar(20) NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_stock`
--

INSERT INTO `material_stock` (`id`, `item_name`, `measurement`, `weight`, `price`, `note`, `update_date`) VALUES
(1, 'Rings', '18', 2200, 200.00, 'Jewellery is commonly measured in carats, grams or troy ounces. \r\nOne carat is equal to exactly 0.2g (200mg).                                                  ', '2021-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `mortgage`
--

CREATE TABLE `mortgage` (
  `M_id` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `mortgageDate` text NOT NULL,
  `rescueDate` text NOT NULL,
  `itemDetail` text NOT NULL,
  `weight` text NOT NULL,
  `interestRate` double(10,2) NOT NULL,
  `timePeriod` varchar(10) NOT NULL,
  `mortgageAdvance` double(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mortgage`
--

INSERT INTO `mortgage` (`M_id`, `customerID`, `mortgageDate`, `rescueDate`, `itemDetail`, `weight`, `interestRate`, `timePeriod`, `mortgageAdvance`, `status`) VALUES
(1, 1, '2021-04-29', '2021-12-30', 'Lorem epsum', '200', 5.00, '01/08/00', 30000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `renewing`
--

CREATE TABLE `renewing` (
  `id` int(7) NOT NULL,
  `renewDate` varchar(20) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `payment` double(10,2) NOT NULL DEFAULT '0.00',
  `dueInterest` double(10,2) NOT NULL,
  `total_paid` double(10,2) NOT NULL,
  `renewAmt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pawningID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `renewing`
--

INSERT INTO `renewing` (`id`, `renewDate`, `month`, `year`, `payment`, `dueInterest`, `total_paid`, `renewAmt`, `pawningID`) VALUES
(1, '2021-06-01', '06', '2021', 2000.00, 1500.00, 2000.00, '29500.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp_pos`
--

CREATE TABLE `temp_pos` (
  `id` int(11) NOT NULL,
  `product` varchar(500) NOT NULL,
  `measurement` varchar(10) DEFAULT NULL,
  `weight` double(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `stock_weight` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `user_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `user_role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'user', '698d51a19d8a121ce581499d7b701668', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_items`
--
ALTER TABLE `dashboard_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_stock`
--
ALTER TABLE `material_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mortgage`
--
ALTER TABLE `mortgage`
  ADD PRIMARY KEY (`M_id`);

--
-- Indexes for table `renewing`
--
ALTER TABLE `renewing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_pos`
--
ALTER TABLE `temp_pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dashboard_items`
--
ALTER TABLE `dashboard_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `material_stock`
--
ALTER TABLE `material_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mortgage`
--
ALTER TABLE `mortgage`
  MODIFY `M_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `renewing`
--
ALTER TABLE `renewing`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `temp_pos`
--
ALTER TABLE `temp_pos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
