-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2023 at 08:06 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `samjangpos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_tbl`
--

CREATE TABLE `attendance_tbl` (
  `att_id` int(11) NOT NULL,
  `att_users_id` int(11) NOT NULL,
  `att_id_number` varchar(255) NOT NULL,
  `att_login` time NOT NULL,
  `att_logout` time NOT NULL,
  `att_date` date NOT NULL,
  `att_position` varchar(255) NOT NULL,
  `att_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_tbl`
--

INSERT INTO `attendance_tbl` (`att_id`, `att_users_id`, `att_id_number`, `att_login`, `att_logout`, `att_date`, `att_position`, `att_isdel`) VALUES
(1, 1, '0006988756', '04:41:35', '04:41:54', '2022-02-16', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart_tbl`
--

CREATE TABLE `cart_tbl` (
  `cart_id` int(11) NOT NULL,
  `cart_users_id` int(11) NOT NULL,
  `cart_prod_id` int(11) NOT NULL,
  `cart_order_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_amount` double(10,2) NOT NULL,
  `cart_discount` double(10,2) NOT NULL,
  `cart_dine` double(10,2) NOT NULL,
  `cart_take` double(10,2) NOT NULL,
  `cart_order_type` varchar(255) NOT NULL,
  `cart_datecreated` date NOT NULL,
  `cart_status` varchar(255) NOT NULL,
  `cart_isdel` int(11) NOT NULL,
  `cart_flavor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_tbl`
--

INSERT INTO `cart_tbl` (`cart_id`, `cart_users_id`, `cart_prod_id`, `cart_order_id`, `cart_qty`, `cart_amount`, `cart_discount`, `cart_dine`, `cart_take`, `cart_order_type`, `cart_datecreated`, `cart_status`, `cart_isdel`, `cart_flavor_id`) VALUES
(1, 1, 1, 1, 3, 297.00, 0.00, 210.00, 270.00, 'Dine In', '2022-02-15', 'Paid', 1, 1),
(2, 1, 1, 1, 2, 198.00, 0.00, 140.00, 180.00, 'Dine In', '2022-02-15', 'Paid', 1, 6),
(3, 1, 1, 1, 1, 99.00, 0.00, 70.00, 90.00, 'Dine In', '2022-02-15', 'Paid', 1, 2),
(4, 1, 5, 1, 2, 140.00, 0.00, 140.00, 0.00, 'Dine In', '2022-02-15', 'Paid', 1, 0),
(5, 1, 8, 1, 2, 200.00, 0.00, 150.00, 0.00, 'Dine In', '2022-02-15', 'Paid', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cashier_holder_tbl`
--

CREATE TABLE `cashier_holder_tbl` (
  `ch_id` int(11) NOT NULL,
  `ch_users_id` int(11) NOT NULL,
  `ch_id_number` varchar(255) NOT NULL,
  `ch_login` time NOT NULL,
  `ch_logout` time NOT NULL,
  `ch_date` date NOT NULL,
  `ch_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories_tbl`
--

CREATE TABLE `categories_tbl` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL,
  `cat_datecreated` date NOT NULL,
  `cat_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories_tbl`
--

INSERT INTO `categories_tbl` (`cat_id`, `cat_name`, `cat_description`, `cat_datecreated`, `cat_isdel`) VALUES
(1, 'K-Pops', '', '2022-01-14', 0),
(2, 'K-Pops with Rice', '', '2022-01-14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers_tbl`
--

CREATE TABLE `customers_tbl` (
  `cus_id` int(11) NOT NULL,
  `cus_users_id` int(11) NOT NULL,
  `cus_name` varchar(255) NOT NULL,
  `cus_phone` varchar(255) NOT NULL,
  `cus_email` varchar(255) NOT NULL,
  `cus_address` varchar(255) NOT NULL,
  `cus_datecreated` date NOT NULL,
  `cus_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discount_history_tbl`
--

CREATE TABLE `discount_history_tbl` (
  `dh_id` int(11) NOT NULL,
  `dh_disc_id` int(11) NOT NULL,
  `dh_name` varchar(255) NOT NULL,
  `dh_cart_id` int(11) NOT NULL,
  `dh_idnum` varchar(255) NOT NULL,
  `dh_datecreated` date NOT NULL,
  `dh_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discount_tbl`
--

CREATE TABLE `discount_tbl` (
  `disc_id` int(11) NOT NULL,
  `disc_users_id` int(11) NOT NULL,
  `disc_name` varchar(255) NOT NULL,
  `disc_description` varchar(255) NOT NULL,
  `disc_value` varchar(255) NOT NULL,
  `disc_datecreated` date NOT NULL,
  `disc_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discount_tbl`
--

INSERT INTO `discount_tbl` (`disc_id`, `disc_users_id`, `disc_name`, `disc_description`, `disc_value`, `disc_datecreated`, `disc_isdel`) VALUES
(1, 1, 'Senior Citizen', '', '.20', '2022-01-16', 0),
(2, 1, 'Grand Opening', '', '.10', '2022-02-11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees_tbl`
--

CREATE TABLE `employees_tbl` (
  `emp_id` int(11) NOT NULL,
  `emp_users_Id` int(11) NOT NULL,
  `emp_number` varchar(255) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `emp_email` varchar(255) NOT NULL,
  `emp_contact` varchar(255) NOT NULL,
  `emp_address` varchar(255) NOT NULL,
  `emp_position_id` int(11) NOT NULL,
  `emp_image` varchar(255) NOT NULL,
  `emp_datecreated` date NOT NULL,
  `emp_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees_tbl`
--

INSERT INTO `employees_tbl` (`emp_id`, `emp_users_Id`, `emp_number`, `emp_name`, `emp_email`, `emp_contact`, `emp_address`, `emp_position_id`, `emp_image`, `emp_datecreated`, `emp_isdel`) VALUES
(1, 1, '0006988756', 'Charles Tubil', 'charlestubil@gmail.com', '09554676908', '455 Pasig Candaba Pampanga', 1, 'chad.jpg', '2022-02-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `flavors_tbl`
--

CREATE TABLE `flavors_tbl` (
  `flavor_id` int(11) NOT NULL,
  `flavor_users_id` int(11) NOT NULL,
  `flavor_prod_id` int(11) NOT NULL,
  `flavor_name` varchar(255) NOT NULL,
  `flavor_date` date NOT NULL,
  `flavor_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flavors_tbl`
--

INSERT INTO `flavors_tbl` (`flavor_id`, `flavor_users_id`, `flavor_prod_id`, `flavor_name`, `flavor_date`, `flavor_isdel`) VALUES
(1, 1, 1, 'Gangjang Maneul', '2022-02-14', 0),
(2, 1, 1, 'Yangnyeom', '2022-02-14', 0),
(3, 1, 1, 'Danbam', '2022-02-14', 0),
(4, 1, 1, 'Honey Butter', '2022-02-14', 0),
(5, 1, 1, 'Jangga', '2022-02-14', 0),
(6, 1, 1, 'Dakgangjeong', '2022-02-14', 0),
(7, 1, 2, 'Gangjang Maneul', '2022-02-14', 0),
(8, 1, 2, 'Yangnyeom', '2022-02-14', 0),
(9, 1, 2, 'Danbam', '2022-02-14', 0),
(10, 1, 2, 'Honey Butter', '2022-02-14', 0),
(11, 1, 2, 'Jangga', '2022-02-14', 0),
(12, 1, 2, 'Dakgangjeong', '2022-02-14', 0),
(13, 1, 3, 'Gangjang Maneul', '2022-02-14', 0),
(14, 1, 3, 'Yangnyeom', '2022-02-14', 0),
(15, 1, 3, 'Danbam', '2022-02-14', 0),
(16, 1, 3, 'Honey Butter', '2022-02-14', 0),
(17, 1, 3, 'Jangga', '2022-02-14', 0),
(18, 1, 3, 'Dakgangjeong', '2022-02-14', 0),
(19, 1, 4, 'Gangjang Maneul', '2022-02-14', 0),
(20, 1, 4, 'Yangnyeom', '2022-02-14', 0),
(21, 1, 4, 'Danbam', '2022-02-14', 0),
(22, 1, 4, 'Honey Butter', '2022-02-14', 0),
(23, 1, 4, 'Jangga', '2022-02-14', 0),
(24, 1, 4, 'Dakgangjeong', '2022-02-14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE `order_tbl` (
  `order_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `order_users_id` int(11) NOT NULL,
  `order_cus_id` int(11) NOT NULL,
  `order_datecreated` date NOT NULL,
  `order_totalamount` double(10,2) NOT NULL,
  `order_totaldiscount` double(10,2) NOT NULL,
  `order_tax` double(10,2) NOT NULL,
  `order_cash` double(10,2) NOT NULL,
  `order_change` double(10,2) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_tbl`
--

INSERT INTO `order_tbl` (`order_id`, `order_number`, `order_users_id`, `order_cus_id`, `order_datecreated`, `order_totalamount`, `order_totaldiscount`, `order_tax`, `order_cash`, `order_change`, `order_type`, `order_status`, `order_isdel`) VALUES
(1, 1, 1, 0, '2022-02-15', 934.00, 0.00, 28.02, 1000.00, 66.00, 'Dine In', 'PAID', 0);

-- --------------------------------------------------------

--
-- Table structure for table `position_tbl`
--

CREATE TABLE `position_tbl` (
  `pos_id` int(11) NOT NULL,
  `pos_name` varchar(255) NOT NULL,
  `pos_description` varchar(255) NOT NULL,
  `pos_date` date NOT NULL,
  `pos_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position_tbl`
--

INSERT INTO `position_tbl` (`pos_id`, `pos_name`, `pos_description`, `pos_date`, `pos_isdel`) VALUES
(1, 'Admin', '', '2022-02-02', 0),
(2, 'Owner', '', '2022-02-02', 0),
(3, 'Manager', '', '2022-02-02', 0),
(4, 'Cashier', '', '2022-02-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_tbl`
--

CREATE TABLE `products_tbl` (
  `prod_id` int(11) NOT NULL,
  `prod_image` varchar(255) NOT NULL,
  `prod_code` varchar(255) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_cat_id` int(11) NOT NULL,
  `prod_dine` double(10,2) NOT NULL,
  `prod_take` double(10,2) NOT NULL,
  `prod_price` double(10,2) NOT NULL,
  `prod_description` varchar(255) NOT NULL,
  `prod_isactive` int(11) NOT NULL,
  `prod_isdel` int(11) NOT NULL,
  `prod_users_id` int(11) NOT NULL,
  `prod_flavor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_tbl`
--

INSERT INTO `products_tbl` (`prod_id`, `prod_image`, `prod_code`, `prod_name`, `prod_cat_id`, `prod_dine`, `prod_take`, `prod_price`, `prod_description`, `prod_isactive`, `prod_isdel`, `prod_users_id`, `prod_flavor`) VALUES
(1, 'chad.jpg', '0000000111231', 'K4', 2, 70.00, 90.00, 99.00, '', 0, 0, 1, 1),
(2, 'photo_2021-12-16_16-31-26.jpg', '0000000111232', 'K1', 2, 30.00, 0.00, 50.00, '', 0, 0, 1, 1),
(3, 'photo_2021-12-16_16-31-26.jpg', '0000000111233', 'K3', 2, 40.00, 0.00, 60.00, '', 0, 0, 1, 1),
(4, 'photo_2021-12-16_16-31-26.jpg', '0000000111234', 'K2', 2, 50.00, 0.00, 70.00, '', 0, 0, 1, 1),
(5, 'photo_2021-12-16_16-31-26.jpg', '', 'S1', 1, 70.00, 0.00, 70.00, '', 0, 0, 1, 0),
(6, 'photo_2021-12-16_16-31-26.jpg', '', 'S2', 1, 50.00, 0.00, 70.00, '', 0, 0, 1, 0),
(7, 'photo_2021-12-16_16-31-26.jpg', '', 'S3', 1, 70.00, 0.00, 99.00, '', 0, 0, 1, 0),
(8, 'photo_2021-12-16_16-31-26.jpg', '', 'S4', 1, 75.00, 0.00, 100.00, '', 0, 0, 1, 0),
(9, 'chad.jpg', '', 'K4', 2, 50.00, 0.00, 119.00, '', 0, 0, 2, 0),
(10, '', '', 'Rice', 2, 0.00, 0.00, 20.00, '', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `units_tbl`
--

CREATE TABLE `units_tbl` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `unit_description` varchar(255) NOT NULL,
  `unit_datecreated` date NOT NULL,
  `unit_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units_tbl`
--

INSERT INTO `units_tbl` (`unit_id`, `unit_name`, `unit_description`, `unit_datecreated`, `unit_isdel`) VALUES
(1, 'Pcs', '', '2021-12-17', 0),
(2, 'Kg', '', '2021-12-17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `users_id` int(11) NOT NULL,
  `users_name` varchar(255) NOT NULL,
  `users_phone` varchar(255) NOT NULL,
  `users_email` varchar(255) NOT NULL,
  `users_username` varchar(255) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `users_status` varchar(255) NOT NULL,
  `users_datecreated` date NOT NULL,
  `users_isdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`users_id`, `users_name`, `users_phone`, `users_email`, `users_username`, `users_password`, `users_status`, `users_datecreated`, `users_isdel`) VALUES
(1, 'SFI Main', '09123456789', '', 'SFIMain', 'Admin_1234', 'Active', '2021-12-14', 0),
(2, 'Chad Tubil', '09554676908', 'gisulpro@gmail.com', 'ChadTubil', 'Chad_1234', 'Active', '2021-12-16', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cashier_holder_tbl`
--
ALTER TABLE `cashier_holder_tbl`
  ADD PRIMARY KEY (`ch_id`);

--
-- Indexes for table `categories_tbl`
--
ALTER TABLE `categories_tbl`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers_tbl`
--
ALTER TABLE `customers_tbl`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `discount_history_tbl`
--
ALTER TABLE `discount_history_tbl`
  ADD PRIMARY KEY (`dh_id`);

--
-- Indexes for table `discount_tbl`
--
ALTER TABLE `discount_tbl`
  ADD PRIMARY KEY (`disc_id`);

--
-- Indexes for table `employees_tbl`
--
ALTER TABLE `employees_tbl`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `flavors_tbl`
--
ALTER TABLE `flavors_tbl`
  ADD PRIMARY KEY (`flavor_id`);

--
-- Indexes for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `position_tbl`
--
ALTER TABLE `position_tbl`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `products_tbl`
--
ALTER TABLE `products_tbl`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `units_tbl`
--
ALTER TABLE `units_tbl`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cashier_holder_tbl`
--
ALTER TABLE `cashier_holder_tbl`
  MODIFY `ch_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories_tbl`
--
ALTER TABLE `categories_tbl`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers_tbl`
--
ALTER TABLE `customers_tbl`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_history_tbl`
--
ALTER TABLE `discount_history_tbl`
  MODIFY `dh_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_tbl`
--
ALTER TABLE `discount_tbl`
  MODIFY `disc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees_tbl`
--
ALTER TABLE `employees_tbl`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flavors_tbl`
--
ALTER TABLE `flavors_tbl`
  MODIFY `flavor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_tbl`
--
ALTER TABLE `order_tbl`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position_tbl`
--
ALTER TABLE `position_tbl`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products_tbl`
--
ALTER TABLE `products_tbl`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units_tbl`
--
ALTER TABLE `units_tbl`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
