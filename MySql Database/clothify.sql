-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 02:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothify`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `about_id` int(10) NOT NULL,
  `about_heading` text NOT NULL,
  `about_short_desc` text NOT NULL,
  `about_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`about_id`, `about_heading`, `about_short_desc`, `about_desc`) VALUES
(1, 'About Us', '                ', ' Clothify was founded with a mission to provide high-quality products and exceptional customer service to our valued customers. We are a team of dedicated individuals who are passionate about e-commerce and providing a seamless shopping experience for our customers.\r\n\r\nOur goal is to make it easy for you to find and purchase the products you love. We source our products from trusted suppliers and work tirelessly to ensure that every order is processed and shipped quickly and efficiently. We understand the importance of fast and reliable shipping, which is why we partner with the best shipping companies in the business to ensure that your order is delivered on time and in perfect condition.\r\n\r\nCustomer satisfaction is at the heart of everything we do. Our dedicated customer support team is always available to answer any questions or concerns you may have. We strive to provide you with a 5-star shopping experience, and we’re not satisfied until you are.\r\n\r\nThank you for choosing Clothify.co.in. We look forward to serving you and providing you with the best shopping experience possible.    ');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_image` text DEFAULT NULL,
  `admin_contact` varchar(255) NOT NULL,
  `admin_country` text NOT NULL,
  `admin_job` varchar(255) NOT NULL,
  `admin_about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(8, 'Nishu Sachan', 'admin@gmail.com', '$2y$10$58atOCc2kaqIRL8FS662VuIuC6iog2dQbNXAp5eLKPtfw5S1UWUzO', 'user_default.png', '8005200059', 'India', 'CEO', 'I am a Web Developer.');

-- --------------------------------------------------------

--
-- Table structure for table `boxes_section`
--

CREATE TABLE `boxes_section` (
  `box_id` int(100) NOT NULL,
  `box_title` varchar(255) DEFAULT NULL,
  `box_desc` varchar(255) DEFAULT NULL,
  `box_icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boxes_section`
--

INSERT INTO `boxes_section` (`box_id`, `box_title`, `box_desc`, `box_icon`) VALUES
(1, 'MONEY BACK', '                                                                                                                     7 DAY MONEY BACK GUARANTEE                                                                                                                ', 'fa fa-indian-rupee-sign'),
(2, 'FREE SHIPPING', '            FREE SHIPPING-ON ORDERS ABOVE ₹ 599.00', 'fa fa-truck'),
(3, 'SPECIAL OFFERS', '                                                                                        ALL ITEMS SALE UP TO 90% OFF                                                                                                                   ', 'fa fa-gift'),
(5, 'Easy returns', 'We offer 5 days return policy', 'fa fa-rotate-left');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `cust_id` int(100) NOT NULL,
  `p_id` int(100) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(100) NOT NULL,
  `size` text NOT NULL,
  `color` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_desc`) VALUES
(8, 'Men', '                                                                                                                                                                                                                                                                                                                                                                            '),
(9, 'Women', '                                                                                                                                                '),
(10, 'Kids', ''),
(11, 'Fashion Accessories', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contact_id` int(10) NOT NULL,
  `contact_email` text NOT NULL,
  `contact_heading` text NOT NULL,
  `contact_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`contact_id`, `contact_email`, `contact_heading`, `contact_desc`) VALUES
(1, 'clothifystoreinfo@mail.com', 'Contact  To Us', '    If you have any questions, please feel free to contact us, our customer service center is working for you 24/7.    ');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(100) NOT NULL,
  `cust_name` varchar(255) NOT NULL,
  `cust_email` varchar(255) NOT NULL,
  `cust_pass` varchar(255) NOT NULL,
  `cust_contact` varchar(255) NOT NULL,
  `cust_image` text NOT NULL,
  `otp_code` int(10) NOT NULL,
  `otp_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cust_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `cust_name`, `cust_email`, `cust_pass`, `cust_contact`, `cust_image`, `otp_code`, `otp_timestamp`, `cust_ip`) VALUES
(31, 'ANKIT SACHAN', 'ANKITSACHAN@GMAIL.COM', '$2y$10$M7Bu.VVo9SvDbvpf1iJ1zuTbnFPOKEXLg.FZKUWvh1mdH8Xp2IOuq', '8923671243', '2.jpeg', 0, '2024-11-20 16:54:34', '::1'),
(32, 'NISHU SACHAN', 'NISHUSACHAN30@GMAIL.COM', '$2y$10$IN4YigbUgpClNvQGlrzQyOwQktVQlVUMLd0ju/XGJ1wGeubObu2aO', '9005673408', '2.jpeg', 3137, '2024-11-26 11:54:21', '::1'),
(33, 'ANKIT SACHAN', 'NISHUSACHAN3@GMAIL.COM', '$2y$10$bC0CF/BG7TXd5iMYlNNfXebW95K2ynVCy3Qg6eEsZoKPQlVKxdMVe', '8005207559', '', 5938, '2024-11-20 12:49:14', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `address_id` int(100) NOT NULL,
  `cust_id` int(100) NOT NULL,
  `cust_name` text NOT NULL,
  `cust_contact` varchar(255) NOT NULL,
  `house_no` varchar(255) NOT NULL,
  `street_name` text NOT NULL,
  `landmark` text DEFAULT NULL,
  `city` text NOT NULL,
  `district` text NOT NULL,
  `state` text NOT NULL,
  `pincode` int(100) NOT NULL,
  `country` text NOT NULL DEFAULT 'INDIA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`address_id`, `cust_id`, `cust_name`, `cust_contact`, `house_no`, `street_name`, `landmark`, `city`, `district`, `state`, `pincode`, `country`) VALUES
(0, 32, 'NISHU SACHAN', '80052074956', '45C', 'B BLOCK', 'GOPALA TOWER', 'KANPUR', 'KANPUR NAGAR', 'UTTAR PRADESH', 209312, 'INDIA'),
(0, 34, 'KUNDAN SACHAN', '05678123456', '88', 'JGH', '', 'HG', 'KANPUR NAGAR', 'GJG', 789877787, 'INDIA');

-- --------------------------------------------------------

--
-- Table structure for table `customer_bank_details`
--

CREATE TABLE `customer_bank_details` (
  `bank_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_holder_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `upi_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_bank_details`
--

INSERT INTO `customer_bank_details` (`bank_id`, `cust_id`, `bank_name`, `account_holder_name`, `account_number`, `ifsc_code`, `upi_id`, `created_at`) VALUES
(3, 32, 'STATE BANK OF INDIA', 'NISHU SACHAN', '765432134564', 'SBIN6723147', '800520744505@okaxis', '2024-11-14 15:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing_address`
--

CREATE TABLE `customer_billing_address` (
  `billing_address_id` int(10) NOT NULL,
  `cust_id` int(10) NOT NULL,
  `cust_contact` varchar(255) NOT NULL,
  `cust_name` text NOT NULL,
  `house_no` varchar(100) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `landmark` text DEFAULT NULL,
  `city` text NOT NULL,
  `district` text NOT NULL,
  `state` text NOT NULL,
  `pincode` int(10) NOT NULL,
  `country` text NOT NULL DEFAULT 'india'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_billing_address`
--

INSERT INTO `customer_billing_address` (`billing_address_id`, `cust_id`, `cust_contact`, `cust_name`, `house_no`, `street_name`, `landmark`, `city`, `district`, `state`, `pincode`, `country`) VALUES
(4, 32, '8005207456', 'NISHU SACHAN', '45C', 'B BLOCK', 'GOPALA TOWER', 'KANPUR', 'KANPUR NAGAR', 'UTTAR PRADESH', 209312, 'INDIA'),
(5, 34, '05678123456', 'KUNDAN SACHAN', '88', 'JGH', '', 'HG', 'KANPUR NAGAR', 'GJG787', 789877, 'INDIA');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` int(10) NOT NULL,
  `cust_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `payment_status` text DEFAULT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `payment_id` int(10) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `ship_address` varchar(255) NOT NULL,
  `bill_address` varchar(255) NOT NULL,
  `order_status` enum('Seller is processing your order','Shipped','Out for Delivery','Delivered','Cancelled','Returned/Refunded') NOT NULL DEFAULT 'Seller is processing your order',
  `exp_delivery_date` date DEFAULT NULL,
  `delivered_on` datetime DEFAULT NULL,
  `return_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`order_id`, `cust_id`, `product_id`, `due_amount`, `invoice_no`, `qty`, `size`, `payment_status`, `payment_mode`, `payment_id`, `order_date`, `ship_address`, `bill_address`, `order_status`, `exp_delivery_date`, `delivered_on`, `return_status`) VALUES
(3, 32, 64, 501.99, 'INV185396', 1, 'M', 'Completed', 'PayPal', 3, '2024-11-27 12:43:13', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(6, 32, 55, 400.99, 'INV437931', 1, 'M', 'Completed', 'PayPal', 6, '2024-11-27 14:46:25', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(7, 32, 55, 400.99, 'INV612056', 1, 'M', 'Completed', 'PayPal', 7, '2024-11-27 14:32:52', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(9, 32, 55, 400.99, 'INV835035', 1, 'M', 'Completed', 'PayPal', 9, '2024-11-27 14:29:51', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(71, 32, 55, 400.99, 'INV407635', 1, 'M', 'Completed', 'PayPal', 71, '2024-11-27 14:38:04', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(93, 32, 55, 400.99, 'INV243252', 1, 'M', 'Completed', 'PayPal', 93, '2024-11-27 18:19:08', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(280, 32, 53, 654.49, 'INV-674297A601921', 1, 'M', '', 'COD', NULL, '2024-11-24 08:34:06', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Delivered', '2024-12-01', '2024-11-24 08:35:05', ''),
(281, 32, 28, 334.99, 'INV-67433828B4AF1', 1, 'M', '', 'COD', NULL, '2024-11-24 19:58:56', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Seller is processing your order', '2024-12-01', NULL, ''),
(300, 32, 64, 501.99, 'INV-67453F0C5277D', 1, 'S', '', 'COD', NULL, '2024-11-26 08:52:52', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Shipped', '2024-12-03', NULL, ''),
(302, 32, 72, 424.22, 'INV-67461587537EF', 1, 'M', NULL, 'COD', NULL, '2024-11-27 00:07:59', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Seller is processing your order', '2024-12-04', NULL, ''),
(303, 32, 69, 309.08, 'INV-674620B2C6439', 1, 'M', 'Pending', 'COD', NULL, '2024-11-27 00:55:38', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Seller is processing your order', '2024-12-04', NULL, ''),
(304, 32, 55, 400.99, 'INV961403', 1, 'M', 'Completed', 'PayPal', 0, '2024-11-27 13:15:18', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(305, 32, 55, 400.99, 'INV326598', 1, 'M', 'Completed', 'PayPal', 0, '2024-11-27 14:18:24', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(306, 32, 55, 400.99, 'INV552526', 1, 'M', 'Completed', 'PayPal', 0, '2024-11-27 14:42:09', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'NISHU SACHAN, 45C, B BLOCK,  NEAR GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH, INDIA - 209312', 'Seller is processing your order', '2024-12-04', NULL, 'Not Applicable'),
(307, 32, 55, 400.99, 'INV-67473E4757EF8', 1, 'L', NULL, 'COD', NULL, '2024-11-27 21:14:07', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', 'Seller is processing your order', '2024-12-04', NULL, '');

--
-- Triggers `customer_order`
--
DELIMITER $$
CREATE TRIGGER `set_delivery_date` BEFORE INSERT ON `customer_order` FOR EACH ROW BEGIN
    SET NEW.exp_delivery_date = DATE_ADD(NEW.order_date, INTERVAL 7 DAY);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_refund_status` BEFORE UPDATE ON `customer_order` FOR EACH ROW BEGIN
    IF NEW.return_status = 'returned' THEN
        SET NEW.refund_status = 'refunded';
    ELSEIF OLD.return_status <> NEW.return_status THEN
        SET NEW.refund_status = NEW.return_status;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_types`
--

CREATE TABLE `enquiry_types` (
  `enquiry_id` int(10) NOT NULL,
  `enquiry_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enquiry_types`
--

INSERT INTO `enquiry_types` (`enquiry_id`, `enquiry_title`) VALUES
(1, 'Order and Delivery Support'),
(2, 'Technical Support'),
(3, 'Price Concern');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(10) NOT NULL,
  `manufacturer_title` text NOT NULL,
  `manufacturer_top` text NOT NULL,
  `manufacturer_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_title`, `manufacturer_top`, `manufacturer_image`) VALUES
(10, 'Polo', 'yes', ''),
(11, 'Lacoste', 'yes', ''),
(12, 'Denim', 'yes', ''),
(13, 'Zara', 'yes', ''),
(14, 'Levis', 'yes', ''),
(15, 'H&M', 'yes', ''),
(16, 'Allen Solly', 'yes', ''),
(17, 'Van Heusen', 'no', ''),
(18, 'Pepe Jeans', 'no', ''),
(19, 'Louis Philippe', 'no', ''),
(20, 'Roadster', 'no', '');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscription_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `subscription_date`) VALUES
(1, 'nsdfias@gmail.com', '2024-11-19 17:24:05'),
(2, 'nishusachan30@gmail.com', '2024-11-19 17:24:24'),
(3, 'NISHUSACHAN3@GMAIL.COM', '2024-11-20 10:17:56'),
(4, 'NISHUACHAN30@GMAIL.COMs', '2024-11-25 12:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payid` int(11) NOT NULL,
  `order_id` int(10) NOT NULL,
  `cust_id` int(10) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `amount` varchar(40) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `payment_mode` text NOT NULL,
  `payment_date` text DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payid`, `order_id`, `cust_id`, `invoice_no`, `ref_no`, `txn_id`, `amount`, `product_id`, `currency`, `mobile`, `email`, `payment_mode`, `payment_date`, `status`) VALUES
(100, 291, 32, 'INV-67433EF605ECC', 'REF-67433EF6063E4', '', '400.99', 28, 'INR', '9005673421', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(101, 292, 32, 'INV-674366D240F9F', 'REF-674366D242DEA', '', '300.99', 71, 'INR', '9005673421', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(102, 293, 32, 'INV-674366D242CAF', 'REF-674366D242DEA', '', '654.49', 47, 'INR', '9005673421', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(103, 294, 32, 'INV-67436782143B4', 'REF-6743678214758', '', '592.89', 45, 'INR', '9005673421', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(104, 295, 34, 'INV-67436DB670103', 'REF-67436DB670660', '', '3264.34', 66, 'INR', '5678123456', 'KUNDANSACHAN@GMAIL.COM', 'COD', NULL, 'Pending'),
(105, 296, 34, 'INV-6743E0A83F144', 'REF-6743E0A846F06', '', '400.99', 41, 'INR', '5678123456', 'KUNDANSACHAN@GMAIL.COM', 'COD', '2024-11-25 07:58:46', 'Completed'),
(106, 297, 34, 'INV-6743E1B331E5C', 'REF-6743E1B3321E5', '', '1915.99', 51, 'INR', '5678123456', 'KUNDANSACHAN@GMAIL.COM', 'COD', '2024-11-25 08:02:42', 'Completed'),
(107, 298, 34, 'INV-6743E39FBDD48', 'REF-6743E39FBE0F3', '', '400.99', 55, 'INR', '5678123456', 'KUNDANSACHAN@GMAIL.COM', 'COD', '2024-11-25 08:11:02', 'Completed'),
(108, 299, 34, 'INV-6743E57C6F927', 'REF-6743E57C6FC45', '', '350.49', 35, 'INR', '5678123456', 'KUNDANSACHAN@GMAIL.COM', 'COD', '2024-11-25 08:18:48', 'Completed'),
(109, 300, 32, 'INV-67453F0C5277D', 'REF-67453F0C53728', '', '501.99', 64, 'INR', '9005673408', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(111, 302, 32, 'INV-67461587537EF', 'REF-674615875480F', '', '424.22', 72, 'INR', '9005673408', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending'),
(112, 303, 32, 'INV-674620B2C6439', 'REF-674620B2C7026', '', '309.08', 69, 'INR', '9005673408', 'NISHUSACHAN30@GMAIL.COM', 'COD', '2024-11-27 00:55:38', 'Pending'),
(113, 307, 32, 'INV-67473E4757EF8', 'REF-67473E4760506', '', '400.99', 55, 'INR', '9005673408', 'NISHUSACHAN30@GMAIL.COM', 'COD', NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `policy_details`
--

CREATE TABLE `policy_details` (
  `policy_id` int(11) NOT NULL,
  `policy_version` varchar(50) NOT NULL,
  `effective_date` date NOT NULL,
  `policy_title` text NOT NULL,
  `policy_desc` text NOT NULL,
  `policy_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policy_details`
--

INSERT INTO `policy_details` (`policy_id`, `policy_version`, `effective_date`, `policy_title`, `policy_desc`, `policy_link`, `created_at`, `updated_at`) VALUES
(5, '1.0', '2024-11-24', ' Information We Collect', 'We collect the following types of information when you visit our website, make a purchase, or interact with our services:\r\n\r\nPersonal Identification Information: This includes your name, email address, phone number, billing and shipping addresses, and payment information.\r\nNon-Personal Identification Information: This includes details such as your browser type, IP address, device information, and website usage patterns.\r\nCookies and Tracking Technologies: We use cookies and similar tracking technologies to enhance your shopping experience, track website usage, and personalize content.', 'link-1', '2024-11-24 07:02:31', '2024-11-24 07:52:57'),
(7, '1.0', '2024-11-24', 'How We Use Your Information', 'We may use the information we collect for the following purposes:\r\n\r\nTo process transactions: We use your information to process your orders, send order confirmations, and deliver your products.\r\nTo improve customer service: Your information helps us respond to your customer service requests and support needs more effectively.\r\nTo send promotional emails: With your consent, we may send you emails about new products, special offers, or updates to our website.\r\nTo personalize your experience: We may use your data to improve our website\'s content, product offerings, and user interface based on your preferences and browsing history.', 'link-2', '2024-11-24 07:11:11', '2024-11-24 07:54:11'),
(8, '1.0', '2024-11-24', 'Data Security', 'We take the security of your personal data seriously. Clothify uses industry-standard encryption to protect sensitive information during transactions. We also implement various security measures to maintain the safety of your personal information.\r\n\r\nHowever, no method of transmission over the Internet or electronic storage is 100% secure. While we strive to protect your personal data, we cannot guarantee absolute security.', 'link-3', '2024-11-24 07:12:14', '2024-11-24 07:54:29'),
(9, '1.0', '2024-11-24', 'Sharing Your Information', 'We do not sell, trade, or rent your personal information to third parties. We may share your information with trusted service providers who assist us in operating our website, conducting business, or servicing you. These third parties are obligated to keep your information confidential.\r\n\r\nWe may also share your information if required by law, in response to legal requests, or to protect our rights and property.', 'link-4', '2024-11-24 07:12:54', '2024-11-24 07:54:41'),
(10, '1.0', '2024-11-24', 'Cookies and Tracking Technologies', 'We use cookies to enhance your browsing experience on Clothify. Cookies are small files that are stored on your device to remember your preferences and personalize your shopping experience.\r\n\r\nYou can choose to disable cookies through your browser settings, but please note that some features of our website may not function properly if cookies are disabled.', 'link-5', '2024-11-24 07:13:25', '2024-11-24 07:54:52'),
(11, '1.0', '2024-11-24', 'Third-Party Links', 'Our website may contain links to third-party websites or services. These external sites have their own privacy policies, and we do not accept any responsibility for their content or privacy practices. We encourage you to review the privacy policies of any third-party websites you visit.', 'link-6', '2024-11-24 07:13:58', '2024-11-24 07:55:04'),
(12, '1.0', '2024-11-24', 'Your Rights and Choices', 'You have the right to:\r\n\r\nAccess your personal data: You can request a copy of the personal information we hold about you.\r\nCorrect or update your information: If any information we hold about you is incorrect or incomplete, you can update it.\r\nOpt-out of marketing communications: You can unsubscribe from our promotional emails at any time by clicking the unsubscribe link in the email.\r\nDelete your information: You can request the deletion of your personal data, subject to certain exceptions (such as ongoing transactions).', 'link-7', '2024-11-24 07:14:37', '2024-11-24 07:55:19'),
(13, '1.0', '2024-11-24', 'Data Retention', 'We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law.', 'link-8', '2024-11-24 07:16:11', '2024-11-24 07:55:38'),
(15, '', '0000-00-00', 'Contact Us', '                        If you have any questions or concerns about this Privacy Policy or how your data is being handled, please contact us:\r\n\r\nEmail: support@clothify.com\r\nPhone: +1 800 123 4567\r\nAddress: 1st floor Kishan Nagar, Kanpur Nagar, Uttar Pradesh - 208025                         ', 'link-10', '2024-11-24 07:35:16', '2024-11-24 07:59:33'),
(16, '1.0', '2024-11-24', 'Changes to This Privacy Policy', 'Clothify reserves the right to update or modify this Privacy Policy at any time. Any changes will be posted on this page, and the \"Effective Date\" will be updated accordingly. We encourage you to review this Privacy Policy periodically to stay informed about how we are protecting your information.', 'link-9', '2024-11-24 07:56:37', '2024-11-24 07:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `p_cat_id` int(100) NOT NULL,
  `cat_id` int(100) NOT NULL,
  `manufacturer_id` int(10) NOT NULL,
  `p_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_availability` int(100) NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_price` int(200) NOT NULL,
  `mrp` int(100) NOT NULL,
  `product_label` text NOT NULL,
  `product_desc` text NOT NULL,
  `product_keyword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `p_date`, `product_title`, `product_availability`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `mrp`, `product_label`, `product_desc`, `product_keyword`) VALUES
(19, 26, 8, 10, '2024-11-23 05:20:33', 'Men Solid Polo Neck Pure Cotton Dark Green T-Shirt', 29, 'xxl-1spctn-stellers-original-imagtnmr4qg7e4hw.jpeg', 'xxl-1spctn-stellers-original-imagtnmrb2y9zdff.jpeg', 'xxl-1spctn-stellers-original-imagtnmrnpfphqch.jpeg', 499, 1999, 'T-Shirt', '<div class=\"row\" style=\"text-align: justify;\"><strong>Type&nbsp;</strong> Polo Neck</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Sleeve</strong>&nbsp;Short Sleeve</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fit</strong>&nbsp;Regular</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fabric</strong>&nbsp;Pure Cotton</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Sales Package</strong>&nbsp;Package contains: 1 t-shirt</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Pack of</strong>&nbsp;1</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Style Code</strong>&nbsp;1SPCTN</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Neck Type&nbsp;</strong>Polo Neck</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Ideal For</strong>&nbsp;Men</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Pattern</strong>&nbsp;Solid</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Suitable For</strong>&nbsp;Western Wear</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\"><strong>Reversible</strong>&nbsp;No</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fabric Care</strong>&nbsp;Regular Machine Wash</div>\r\n</div>\r\n<div class=\"row\">\r\n<div class=\"col col-3-12 _9NUIO9\" style=\"text-align: justify;\"><strong>Net Quantity</strong>&nbsp;1</div>\r\n</div>\r\n<div class=\"_4aGEkW\">This super premium knitwear is a product of fidelity to tradition and quest for excellence. This Polo is a result of our conscious effort in making a pattern for a perfect golfers fit.</div>', 'men polo tshirt green'),
(20, 26, 8, 10, '2024-11-23 05:09:38', 'Men Solid Polo Neck Pure Cotton Green T-Shirt', 5, 'xxl-1spctn-stellers-original-imagtnmq5sjfrhmz.jpeg', 'xxl-1spctn-stellers-original-imagtnmqr2dus6ez.jpeg', 'xxl-1spctn-stellers-original-imagtnmqz4acwa3f.jpeg', 479, 1999, 'T-Shirt', '<div class=\"row\" style=\"text-align: justify;\"><strong>Type&nbsp;</strong> Polo Neck</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Sleeve</strong>&nbsp;Short Sleeve</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fit</strong>&nbsp;Regular</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fabric</strong>&nbsp;Pure Cotton</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Sales Package</strong>&nbsp;Package contains: 1 t-shirt</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Pack of</strong>&nbsp;1</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Style Code</strong>&nbsp;1SPCTN</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Neck Type&nbsp;</strong>Polo Neck</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Ideal For</strong>&nbsp;Men</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Pattern</strong>&nbsp;Solid</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Suitable For</strong>&nbsp;Western Wear</div>\r\n</div>\r\n<div class=\"row\" style=\"text-align: justify;\"><strong>Reversible</strong>&nbsp;No</div>\r\n<div class=\"row\" style=\"text-align: justify;\">\r\n<div class=\"col col-3-12 _9NUIO9\"><strong>Fabric Care</strong>&nbsp;Regular Machine Wash</div>\r\n</div>\r\n<div class=\"row\">\r\n<div class=\"col col-3-12 _9NUIO9\" style=\"text-align: justify;\"><strong>Net Quantity</strong>&nbsp;1</div>\r\n</div>\r\n<div class=\"_4aGEkW\">This super premium knitwear is a product of fidelity to tradition and quest for excellence. This Polo is a result of our conscious effort in making a pattern for a perfect golfers fit.</div>', 'men polo tshirt green'),
(21, 26, 8, 10, '2024-11-23 03:48:02', 'Men Solid Polo Neck Pure Cotton Purple T-Shirt', 26, '3xl-1spctn-stellers-original-imagtnmqdaemxkma.jpeg', '3xl-1spctn-stellers-original-imagtnmqxzhmkedc.jpeg', '3xl-1spctn-stellers-original-imagtnmqjvweqzzg.jpeg', 479, 1999, 'T-Shirt', '<p>Type Polo Neck Sleeve Short Sleeve Fit Regular Fabric Pure Cotton Sales Package Package contains: 1 t-shirt Pack of 1 Style Code 1SPCTN Neck Type Polo Neck</p>', 'men polo tshirt pink'),
(23, 26, 8, 10, '2024-11-24 02:55:47', 'Men Solid Polo Neck Pure Cotton Black T-Shirt', 4, 'l-1spctn-stellers-original-imah59fygd4ff65s.jpeg', 'l-1spctn-stellers-original-imah59fyvzjdw2vf.jpeg', 'l-1spctn-stellers-original-imah59fyuemyfur3.jpeg', 479, 1999, 'T-Shirt', '<p>Type Polo Neck Sleeve Short Sleeve Fit Regular Fabric Pure Cotton Sales Package Package contains: 1 t-shirt Pack of 1 Style Code 1SPCTN</p>', 'men polo tshirt black'),
(24, 26, 8, 20, '2024-11-23 04:42:04', 'Men Solid Round Neck Pure Cotton White T-Shirt', 8, 'm-29555092-roadster-original-imah4ztyagghnmbd.jpeg', 'm-29555092-roadster-original-imah4ztydtt4tsms.jpeg', 'm-29555092-roadster-original-imah4ztyzbufaguk.jpeg', 357, 699, 'T-Shirt', '<p>Type Round Neck Sleeve Short Sleeve Fit Loose Fabric Pure Cotton Pack of 1 Style Code 29555092 Neck Type Round Neck Ideal For Men</p>', 'men tshirt'),
(25, 26, 8, 11, '2024-11-23 03:51:32', 'Men Printed Round Neck Polyester Light Green T-Shirt', 70, 'xl-ts12-vebnor-original-imahfbc3yrzrcmxb.jpeg', 'xl-ts12-vebnor-original-imahfbc3ss8amdgh.jpeg', 'xl-ts12-vebnor-original-imahfbc3yfnxp9j9.jpeg', 259, 999, 'T-Shirt', '<p>Type Round Neck Sleeve Full Sleeve Fit Regular Fabric Polyester Sales Package 1 T shirt Pack of 1 Style Code TS12 Neck Type Round Neck</p>', 'men tshirt'),
(26, 27, 8, 11, '2024-11-23 03:54:45', 'Men Regular Fit Washed Cut Away Collar Casual Shirt', 2, 'm-crc-den-db-blu-shd-carbonn-cloth-original-imagh3yyrgrcwhfx.jpeg', 'm-crc-den-db-blu-shd-carbonn-cloth-original-imagh3yyhef47paw.jpeg', 'm-crc-den-db-blu-shd-carbonn-cloth-original-imagh3yyrgrcwhfx.jpeg', 430, 1699, 'Shirt', '<p>Style Code CRC-DEN-01 Closure Button Fit Regular Fabric Denim Sleeve Full Sleeve Pattern Washed Reversible No</p>', 'men shirt'),
(27, 28, 8, 17, '2024-11-24 15:10:30', 'Men Slim Fit Solid Spread Collar Formal Shirt', 92, 'm-r-peacock-blue-stoneberg-original-imah5f7wrynbprrd.jpeg', 'm-r-peacock-blue-stoneberg-original-imah5f7wwvpucfyr.jpeg', 'm-r-peacock-blue-stoneberg-original-imah5f7w2guyxhum.jpeg', 431, 1599, 'Shirt', '<p>Pack of 1 Style Code R-PEACOCK BLUE Closure BUTTON Fit Slim Fabric Cotton Blend Sleeve Full Sleeve Pattern Solid Reversible No</p>', 'men shirt'),
(28, 28, 8, 14, '2024-11-24 14:57:04', 'Men Regular Fit Printed Spread Collar Casual Shirt', 6, 'l-st42-vebnor-original-imah4vzyhuex9h6w.jpeg', 'l-st42-vebnor-original-imah4vzyeyaggwez.jpeg', 'l-st42-vebnor-original-imah4vzy35fg9hye.jpeg', 299, 999, 'Shirt', '<p>Pack of 1 Style Code ST42 Closure Button Fit Regular Fabric Poly Viscose Sleeve Full Sleeve Pattern Printed Reversible No</p>', 'men shirt'),
(29, 27, 8, 12, '2024-11-23 04:42:50', 'Men Slim Fit Checkered Spread Collar Casual Shirt', 5, 's-khsh000073-ketch-original-imag5zqwnhgg7drf.jpeg', 's-khsh000073-ketch-original-imag5zqwgqdsuyav.jpeg', 's-khsh000073-ketch-original-imag5zqwtfqfbhcd.jpeg', 399, 899, 'Shirt', '<p>Pack of 1 Style Code KHSH000073 Fit Slim Fabric Cotton Blend Sleeve 3/4th Sleeve Pattern Checkered Reversible No Collar Spread</p>', 'men shirt'),
(30, 29, 8, 14, '2024-11-23 04:34:12', 'Men Relaxed Fit Mid Rise Blue Jeans', 7, '30-29596496-harvard-original-imah4t2wmpduntye.jpeg', '30-29596496-harvard-original-imah4t2w6jwuzhff.jpeg', '30-29596496-harvard-original-imah4t2wzwgpfhhn.jpeg', 1173, 2299, 'Jeans', '<p>Style Code 29596496 Ideal For Men Suitable For Western Wear Pack Of 1 Reversible No Fabric Cotton Blend Faded Light Fade Rise Mid Rise</p>', 'men jeans'),
(31, 29, 8, 18, '2024-11-04 08:07:09', 'Men Slim Mid Rise Dark Blue Jeans', 0, '-original-imah5h7z4pxkzzyq.jpeg', '-original-imah5h7z7hfkhg6w.jpeg', '-original-imah5h7zvu7vthhf.jpeg', 999, 1999, 'Jeans', '<p>Style Code FMJEN6722 Ideal For Men Suitable For Western Wear Pack Of 1 Pocket Type Coin Pocket Pattern Solid Reversible Yes Closure BUTTON</p>', 'men jeans'),
(32, 29, 8, 18, '2024-11-23 03:05:59', 'Men Slim Mid Rise Blue Jeans', 33, '-original-imah5h7nqkkszcba.jpeg', '-original-imah5h7nzkkedfth.jpeg', '-original-imah5h7ncxsq5qmy.jpeg', 1149, 2299, 'Jeans', '<p>Style Code FMJEN6746 Ideal For Men Suitable For Western Wear Pack Of 1 Pattern Solid Reversible Yes Closure BUTTON Fabric Cotton Blend</p>', 'men jeans'),
(33, 29, 8, 17, '2024-11-23 03:05:49', 'Men Relaxed Fit Mid Rise Blue Jeans', 33, '30-29758752-mast-harbour-original-imah5gdjs66rybmg.jpeg', '30-29758752-mast-harbour-original-imah5gdjvjpxxkq5.jpeg', '30-29758752-mast-harbour-original-imah5gdjcycg7mfy.jpeg', 1525, 2499, 'Jeans', '<p>Style Code 29758752 Ideal For Men Suitable For Western Wear Pack Of 1 Reversible No Fabric Cotton Blend Faded Light Fade Rise Mid Rise</p>', 'men jeans'),
(34, 30, 8, 15, '2024-11-23 04:37:09', 'Men Regular Fit Grey Cotton Blend Trousers', 3, '26-p-bk-1-fashion-willa-original-imagqnf6bhgv5xec.jpeg', '26-p-bk-1-fashion-willa-original-imagqnf6dkuy3pyg.jpeg', '26-p-bk-1-fashion-willa-original-imagqnf6bxdnqkfd.jpeg', 299, 999, 'Trouser', '<p>Fit Regular Fit Occasion Casual Color Grey Pack of 1 Type Casual Trousers Suitable For Western Wear Alteration Required No Belt Loops Yes</p>', 'men trousers'),
(35, 30, 8, 16, '2024-11-25 02:48:12', 'Men Slim Fit Grey Lycra Blend Trousers', 21, '32-mendoublenew-tenit-original-imahywphu6s35k84.jpeg', '32-mendoublenew-tenit-original-imahywphxvxahypq.jpeg', '32-mendoublenew-tenit-original-imahywph9zgrdkf8.jpeg', 249, 999, 'Trouser', '<p>Fit Slim Fit Occasion Formal Color Grey Pack of 1 Type Formal Trouser Suitable For Western Wear Rise Mid Pattern Solid</p>', 'men trousers'),
(36, 31, 8, 14, '2024-11-24 14:41:25', 'Men Regular Fit Blue Cotton Blend Trousers', 19, '34-sv-blu-streetvibes-original-imahfgznhezjqhag.jpeg', '34-sv-blu-streetvibes-original-imahfgznpycnya4g.jpeg', '34-sv-blu-streetvibes-original-imahfgzn8dadtgxf.jpeg', 419, 1599, 'Trouser', '<p>Fit Regular Fit Occasion Formal Color Blue Pack of 1 Type Formal Trouser Suitable For Western Wear Alteration Required No Belt Loops Yes</p>', 'men trousers'),
(37, 30, 8, 13, '2024-11-24 18:17:03', 'Men Slim Fit Khaki Lycra Blend Trousers', 18, '30-vr-trouser-khakhi-vr-excellent-original-imahftdafphgryhm.jpeg', '30-vr-trouser-khakhi-vr-excellent-original-imahftdarwq3nwyu.jpeg', '30-vr-trouser-khakhi-vr-excellent-original-imahftdavhsjgvqt.jpeg', 249, 999, 'Trouser', '<p>Fit Slim Fit Occasion Formal Color Khaki Pack of 1 Type Formal Trouser Suitable For Western Wear Rise Mid Pattern Solid</p>', 'men trousers'),
(38, 31, 8, 16, '2024-11-20 15:36:26', 'Flexi Wasit-Ankle Length Cherry Lycra Men Slim Fit Maroon Lycra Blend Trousers', 22, '30-2203-formal-trouser-red-cherry-original-imah2hujagpfvfbu.jpeg', '30-2203-formal-trouser-red-cherry-original-imah2hujuk4a8eph.jpeg', '30-2203-formal-trouser-red-cherry-original-imah2hujarj3584x.jpeg', 489, 1999, 'Trouser', 'Fit\r\nSlim Fit\r\nOccasion\r\nFormal\r\nColor\r\nMaroon\r\nPack of\r\n1\r\nType\r\nFormal Trouser\r\nSuitable For\r\nWestern Wear\r\nAlteration Required\r\nNo\r\nBelt Loops\r\nYes', 'men trousers'),
(39, 31, 8, 15, '2024-11-23 03:48:11', 'Flexi Wasit-Ankle Length Green Lycra Men Slim Fit Green Lycra Blend Trousers', 0, '34-2203-formal-trouser-red-cherry-original-imah2hugkpn8wgma.jpeg', '34-2203-formal-trouser-red-cherry-original-imah2hughvazvhsh.jpeg', '34-2203-formal-trouser-red-cherry-original-imah2hugsyfrzsya.jpeg', 473, 1999, 'Trouser', 'Fit\r\nSlim Fit\r\nOccasion\r\nFormal\r\nColor\r\nGreen\r\nPack of\r\n1\r\nType\r\nFormal Trouser\r\nSuitable For\r\nWestern Wear\r\nAlteration Required\r\nYes\r\nBelt Loops\r\nYes', 'men trousers'),
(40, 32, 8, 20, '2024-11-23 05:01:53', 'Men Printed Black Track Pants', 0, 's-solid-sports-wear-yazole-original-imah2gjhtkyfmvpp.jpeg', 's-solid-sports-wear-yazole-original-imah2gjhyusnyfyb.jpeg', 's-solid-sports-wear-yazole-original-imah2gjh3mtzthtf.jpeg', 259, 1499, 'Track Pants', 'Style Code\r\nSolid Sports Wear\r\nClosure\r\nDrawstring, Elastic\r\nPockets\r\n2 zipper pocket at side\r\nFabric Care\r\nGentle Machine Wash Only\r\nFabric\r\nPolyester\r\nPattern\r\nPrinted\r\nColor\r\nBlack', 'men trackpants'),
(41, 32, 8, 20, '2024-11-25 02:27:33', 'Men Colorblock Grey, Black Track Pants', 48, 'm-1-5-yunek-original-imagnx8nyzg5ppfe.jpeg', 'm-1-5-yunek-original-imagnx8nfnnwtdth.jpeg', 'm-1-5-yunek-original-imagnx8npfp3zkdk.jpeg', 299, 1799, 'Track Pants', 'Style Code\r\n1-5\r\nClosure\r\nElastic\r\nPockets\r\nSide Pockets, 1 zipper pockt at side\r\nFabric Care\r\nMachine Wash\r\nFabric\r\nPolyester\r\nPattern\r\nColorblock\r\nColor\r\nGrey, Black\r\nNet Quantity\r\n1', 'men trackpants'),
(42, 32, 8, 20, '2024-11-23 06:11:03', 'Pack of 2 Men Printed Black, Grey Track Pants', 4, 'xxl-tr12-vebnor-original-imah4b4eszrycte9.jpeg', 'xxl-tr12-vebnor-original-imah4b4eagdxzfeq.jpeg', 'xxl-tr12-vebnor-original-imah4b4ecksft7zp.jpeg', 479, 999, 'Track Pants', 'Style Code\r\nTR12.\r\nClosure\r\nDrawstring\r\nPockets\r\n2 slant pocket at Front\r\nFabric Care\r\nNormal machine wash or hand wash\r\nOther Details\r\nlower for men\r\nSales Package\r\n2 Track Pants\r\nFabric\r\nPolyester\r\nPattern\r\nPrinted', 'men trackpants'),
(43, 33, 8, 19, '2024-11-26 19:29:29', 'Colorblock Men Track Suit', 21, 'm-56-black-yuvraah-original-imah4dzk5kmg3yuu.jpeg', 'm-56-black-yuvraah-original-imah3jcqkszc7uup.jpeg', 'm-56-black-yuvraah-original-imah4dzk3eufx3gj.jpeg', 429, 2099, 'Track Suits', 'Color\r\nBlack\r\nPattern\r\nColorblock\r\nStyle Code\r\n(56)-(BLACK)\r\nFabric\r\nPolyester\r\nFabric Care\r\nNormal Machine Or Hand Wash\r\nSales Package\r\n1', 'men tracksuits'),
(44, 33, 8, 19, '2024-11-22 17:59:57', 'Colorblock Men Track Suit', 0, 'xl-24-green-yuvraah-original-imah3jddzycg3zkv.jpeg', 'xl-24-green-yuvraah-original-imah3jddffru6ejq.jpeg', 'xl-24-green-yuvraah-original-imah3jddsdtzv7rt.jpeg', 379, 999, 'Track Suits', 'Color\r\nGreen\r\nPattern\r\nColorblock\r\nStyle Code\r\n24_GREEN\r\nFabric\r\nPolyester', 'men tracksuits'),
(45, 33, 8, 19, '2024-11-24 17:49:48', 'Solid Men Track Suit', 20, 'l-track-suit-04-unianta-original-imah5f94bm4cfgzd.jpeg', 'l-track-suit-04-unianta-original-imah5f94y2fcvh8n.jpeg', 'l-track-suit-04-unianta-original-imah5f94y3gfnfxt.jpeg', 489, 2999, 'Track Suits', 'Color\r\nBlack\r\nPattern\r\nSolid\r\nStyle Code\r\nTRACK SUIT-04\r\nTop Closure\r\nSlip on Closure\r\nFabric\r\nPolyester Blend\r\nFabric Care\r\nMachine Wash\r\nSales Package\r\n1 Track T-Shirt, 1 Track Pant\r\nOther Details\r\nTrack suit made of polyster blend material can use running wear, gym wear, regular wear,sports wear', 'men tracksuits'),
(46, 34, 8, 17, '2024-11-23 04:49:27', 'Men Full Sleeve Solid Sweatshirt', 3, 'm-solid-os-lavnder-m-farrowx-original-imah5pfzmug2rhu5.jpeg', 'm-solid-os-lavnder-m-farrowx-original-imah5pfzr4gydv6h.jpeg', 'm-solid-os-lavnder-m-farrowx-original-imah5pfzjaxsyjt4.jpeg', 499, 1999, 'Sweatshirts', 'Color\r\nPurple\r\nFabric\r\nFleece\r\nPattern\r\nSolid\r\nNeck\r\nRound Neck\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\nSOLID-OS-LAVNDER-M\r\nSales Package\r\n1 Sweatshirt\r\nOccasion\r\nCasual', 'men sweatshirts'),
(47, 34, 8, 19, '2024-11-24 17:41:04', 'Men 3/4th Sleeve Solid Sweatshirt', 51, 'xxl-sw401-parona-original-imagsy4ehwdeezc5.jpeg', 'xxl-sw401-parona-original-imagsy4ekf5rmec3.jpeg', 'xxl-sw401-parona-original-imagsy4ehwdeezc5.jpeg', 599, 1899, 'Sweatshirts', 'Color\r\nGreen\r\nFabric\r\nFleece\r\nPattern\r\nSolid\r\nNeck\r\nHigh Neck\r\nSleeve\r\n3/4th Sleeve\r\nStyle Code\r\nsw401\r\nOccasion\r\nCasual\r\nHooded\r\nNo', 'men sweatshirts'),
(48, 34, 8, 19, '2024-11-25 18:14:09', 'Men Full Sleeve Solid Hooded Sweatshirt', 1, 'l-men-hd-sweatshirt-maroon-being-wanted-original-imagspedhtydctha.jpeg', 'l-men-hd-sweatshirt-maroon-being-wanted-original-imagspedchhecyyn.jpeg', 'l-men-hd-sweatshirt-maroon-being-wanted-original-imagspedhtydctha.jpeg', 349, 1249, 'Sweatshirts', 'Color\r\nMaroon\r\nFabric\r\nPure Cotton\r\nPattern\r\nSolid\r\nNeck\r\nHooded Neck\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\nMEN-HD-SWEATSHIRT-MAROON\r\nSales Package\r\n1 Cotton Sweatshirt\r\nOccasion\r\nCasual', 'men sweatshirts'),
(49, 35, 8, 17, '2024-11-20 15:38:15', 'Men Solid Bomber Jacket', 27, 'xxl-12645820-here-now-original-imafyurmdnnj5wby.jpeg', 'l-12645820-here-now-original-imafyurmzwsecnyg.jpeg', 'xxl-12645820-here-now-original-imafyurmnejn74nx.jpeg', 988, 3799, 'Jacket', 'Color\r\nBlue\r\nFabric\r\nPolyester\r\nPattern\r\nSolid\r\nStyle code\r\n12645820\r\nIdeal for\r\nMen\r\nSleeve\r\nFull Sleeve\r\nClosure\r\nZipper\r\nPack of\r\n1', 'men jacket'),
(50, 35, 8, 12, '2024-11-23 04:31:09', 'Men Solid Leather Jacket', 0, 'm-no-hoc-kblack-houseofcommon-original-imah5wybaftbyewh.jpeg', 'm-no-hoc-kblack-houseofcommon-original-imah5wybky6qx6wy.jpeg', 'm-no-hoc-kblack-houseofcommon-original-imah5wybgxabyagh.jpeg', 649, 2299, 'Jacket', 'Color\r\nBlack\r\nFabric\r\nFaux Leather\r\nPattern\r\nSolid\r\nStyle code\r\nHOC-KBLACK\r\nIdeal for\r\nMen\r\nSleeve\r\nFull Sleeve\r\nClosure\r\nZipper\r\nSales package\r\n1 Jacket', 'men jacket'),
(51, 35, 8, 17, '2024-11-25 02:32:03', 'Men Solid Bomber Jacket', 20, 'm-1-no-dtaw24jk004-c-ducati-original-imah5ytdygmgqy73.jpeg', 'm-1-no-dtaw24jk004-c-ducati-original-imah5ytdfhghpjjj.jpeg', 'm-1-no-dtaw24jk004-c-ducati-original-imah5ytdefu4ypaz.jpeg', 1799, 5999, 'Jacket', 'Color\r\nOff White\r\nFabric\r\nCotton Blend\r\nPattern\r\nSolid\r\nStyle code\r\nDTAW24JK004_C\r\nIdeal for\r\nMen\r\nSleeve\r\nshort_sleeve\r\nClosure\r\nNo Closure\r\nPack of\r\n1', 'men jacket'),
(52, 36, 8, 15, '2024-11-12 03:40:13', 'Men Solid Hooded Neck Blue Sweater', 4, 'm-pcpleceeziphood0001-riverhill-original-imafcf3eureeqkaa.jpeg', 'l-pcpleceeziphood0001-riverhill-original-imafcf3e7grgumg7.jpeg', 's-pcpleceeziphood0001-riverhill-original-imafcf3exhychfpa.jpeg', 749, 1299, 'Sweater', 'Color\r\nBlue\r\nFabric\r\nFleece\r\nNeck\r\nHooded Neck\r\nPattern\r\nSolid\r\nSleeve\r\nFull Sleeve\r\nSales Package\r\n1 Sweater\r\nStyle Code\r\nPCPLECEEZIPHOOD0001\r\nSuitable For\r\nWestern Wear', 'men sweaters'),
(53, 36, 8, 15, '2024-11-24 03:03:15', 'Men Self Design V Neck Black Sweater', 49, 'xl-27-v-kite-sweater-black-kilvested-original-imah4ss9ukrpvxyh.jpeg', 'xl-27-v-kite-sweater-black-kilvested-original-imah4ss9h8ehwnza.jpeg', 'xl-27-v-kite-sweater-black-kilvested-original-imah4ss9cvrkgkz3.jpeg', 599, 999, 'Sweater', 'Color\r\nYellow\r\nFabric\r\nAcrylic Wool Blend\r\nNeck\r\nV Neck\r\nPattern\r\nSelf Design\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\nDKMANJI\r\nSuitable For\r\nWestern Wear\r\nClosure\r\nNo Closure', 'men sweaters'),
(54, 36, 8, 19, '2024-11-23 06:14:49', 'Men Woven High Neck Green Sweater', 1, 'm-nik-green-t-neck-freaks-original-imagwmdfj46kv8c8.jpeg', 'm-nik-green-t-neck-freaks-original-imagwmdfkqhmg6gu.jpeg', 'm-nik-green-t-neck-freaks-original-imagwmdftdtgjpk4.jpeg', 339, 999, 'Sweater', 'Color\r\nGreen\r\nFabric\r\nWool Blend\r\nNeck\r\nHigh Neck\r\nPattern\r\nWoven\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\nNIK GREEN T-NECK\r\nSuitable For\r\nWestern Wear\r\nClosure\r\nNo Closure', 'men sweaters'),
(55, 37, 8, 15, '2024-11-27 07:42:47', 'Men Solid Cotton Blend Asymmetric Kurta  (Light Green)', 2, 'l-901-tibra-collection-original-imaggeza2bzvqqz3.jpeg', 'l-901-tibra-collection-original-imaggezabht8cced.jpeg', 'l-901-tibra-collection-original-imaggezae4avsjqf.jpeg', 299, 1699, 'Kurta', 'Ideal For\r\nMen\r\nLength Type\r\nKnee Length\r\nBrand Color\r\nOlive\r\nOccasion\r\nFestive & Party\r\nPattern\r\nSolid\r\nType\r\nAsymmetric\r\nFabric\r\nCotton Blend\r\nNeck\r\nMandarin/Chinese Neck', 'men kurta'),
(56, 37, 8, 15, '2024-11-25 04:46:19', 'Pack of 2 Men Floral Print Cotton Blend Straight Kurta  (Green, Yellow)', 27, 's-flww01-deemoon-original-imaghe7faae6tm3y.jpeg', 's-flw01-deemoon-original-imagk2ejgcjdgkgm.jpeg', 'l-flw02-deemoon-original-imagk2ejzuefdhzj.jpeg', 649, 2099, 'Kurta', 'Ideal For\r\nMen\r\nLength Type\r\nHip Length\r\nBrand Color\r\nGreen & Yellow\r\nOccasion\r\nFestive & Party\r\nPattern\r\nFloral Print\r\nType\r\nStraight\r\nFabric\r\nCotton Blend\r\nStyle\r\n2 Type Design', 'men kurta'),
(57, 37, 8, 15, '2024-11-23 04:58:46', 'Men Striped Cotton Blend A-line Kurta  (Maroon)', 29, 'xl-kurta-maroon-almora-original-imagxnf3evwseeug.jpeg', 'xl-kurta-maroon-almora-original-imagxnf3hyy8yyxp.jpeg', 'xl-kurta-maroon-almora-original-imagxnf3s5caghgh.jpeg', 269, 999, 'Kurta', 'Ideal For\r\nMen\r\nLength Type\r\nLong\r\nBrand Color\r\nMorpanki\r\nOccasion\r\nCasual\r\nPattern\r\nStriped\r\nType\r\nA-line\r\nFabric\r\nCotton Blend\r\nNeck\r\nCollared Neck', 'men kurta'),
(63, 38, 8, 13, '2024-11-26 03:18:10', 'Men Silk Blend Kurta Pyjama Set', 0, '38-110-tibra-collection-original-imagyz38tkjzcskn.jpeg', '38-110-tibra-collection-original-imagyz386ugkzbyb.jpeg', '38-110-tibra-collection-original-imagyz38rtrfqgte.jpeg', 449, 2999, 'Ethnic Set', 'Fabric\r\nSilk Blend\r\nType\r\nKurta and Pyjama Set\r\nSales Package\r\n(Kurta Churidar)\r\nStyle Code\r\n110\r\nSecondary color\r\nGold\r\nLining material\r\ncotton\r\nTop fabric\r\nCotton\r\nBottom fabric\r\nCotton', 'men ethnic set'),
(64, 38, 8, 15, '2024-11-27 06:50:09', 'Men Cotton Blend Kurta Pyjama Set', 11, 'm-men-printed-kurta-and-pyjama-set-cotton-cellux-original-imagrepq4a7zevnh.jpeg', 'm-men-printed-kurta-and-pyjama-set-cotton-cellux-original-imagrepqw4hfhmdw.jpeg', 'm-men-printed-kurta-and-pyjama-set-cotton-cellux-original-imagrepqmtezhfhs.jpeg', 399, 2499, 'Ethnic Set', 'Fabric\r\nCotton Blend\r\nType\r\nKurta and Pyjama Set\r\nSales Package\r\n1 Kurta 1 Payjama\r\nStyle Code\r\nMen Printed Kurta and Pyjama Set Cotton\r\nTop fabric\r\nCotton Blend\r\nBottom fabric\r\nCotton\r\nTop type\r\nKurta\r\nBottom type\r\nPyjama', 'men ethnic set'),
(65, 38, 8, 17, '2024-11-09 10:07:47', 'Men Pure Cotton Kurta Pyjama Set', 0, 'xl-jokp-p-5006purple-jompers-original-imagrvh7ytkttspe.jpeg', 'xl-jokp-p-5006purple-jompers-original-imagrvh7ycffhfxq.jpeg', 'xl-jokp-p-5006purple-jompers-original-imagrvh7f56gzqvf.jpeg', 1334, 5499, 'Ethnic Set', 'Fabric\r\nPure Cotton\r\nType\r\nKurta and Pyjama Set\r\nSales Package\r\n1 Kurta, 1 Pyjama\r\nStyle Code\r\nJOKP_P_5006Purple\r\nSecondary color\r\nWhite\r\nTop fabric\r\nCotton\r\nBottom fabric\r\nCotton\r\nTop type\r\nKurta', 'men ethnic set'),
(66, 39, 8, 15, '2024-11-24 18:06:44', 'DIAMOND Wedding Embroidered Sherwani', 4, 's-rd40-diamond-original-imah3fmy6yzvavn6.jpeg', 's-rd40-diamond-original-imah3fmyanexnvza.jpeg', 's-rd40-diamond-original-imah3fmypqwanfxg.jpeg', 3134, 9999, 'Sherwani', '\r\nType\r\nSherwani with Dupatta\r\nFabric\r\nJacquard\r\nDesign\r\nHAND SHERWANI\r\nStyle\r\nWedding Sherwani\r\nNeck\r\nBandhgala Neck', 'men sherwani '),
(67, 39, 8, 11, '2024-11-18 15:29:27', 'Brand Boy Printed Sherwani', 0, 's-mens-indo-western-n-b-f-fashion-original-imagqhahh2fqwbpe.jpeg', 's-mens-indo-western-n-b-f-fashion-original-imagqhahpzvkvzqe.jpeg', 's-mens-indo-western-n-b-f-fashion-original-imagqhahyyjayfjw.jpeg', 1779, 3999, 'Sherwani', '\r\nColor: Blue\r\nFabric: Jacquard\r\nPattern: Printed\r\nNeck Type: Round Neck\r\nFit: Regular', 'men sherwani '),
(68, 39, 8, 11, '2024-11-23 04:43:31', 'Diamond Style Embroidered Sherwani', 4, 'l-rd45-diamond-style-original-imah3zwzc8vjx4jd.jpeg', 'l-rd45-diamond-style-original-imah3zwzwfwxzpe5.jpeg', 'l-rd45-diamond-style-original-imah3zwzyzu4bz5h.jpeg', 4238, 9999, 'Sherwani', '\r\n1 Sherwani With Mala, 1 Pajama, 1 Fancy Dupatta, + Cover And Hanger', 'men sherwani '),
(69, 47, 9, 11, '2024-11-26 18:58:56', 'Women Black Blue Colour blocked Relaxed Fit T-shirt With Twisted Design', 9, 'n4ytg_512.webp', 'aml96_512.webp', 't6h5x_512.webp', 208, 499, 'T-Shirt', 'Name : Women Black Blue Colour blocked Relaxed Fit T-shirt With Twisted Design\r\n\r\nFabric : Polycotton\r\n\r\nSleeve Length : Long Sleeves\r\n\r\nPattern : Colorblocked\r\n\r\nNet Quantity (N) : 1\r\n\r\nSizes :  \r\n\r\nS (Bust Size : 34 in)\r\n\r\nM (Bust Size : 36 in)\r\n\r\nL (Bust Size : 39 in)\r\n\r\nXL (Bust Size : 42 in)\r\n\r\n \r\n\r\nWomen Black Blue Colour blocked Relaxed Fit T-shirt With Twisted Design\r\n\r\nIt will enhance your fashion .statement as it comes with a color block pattern which adds a tinge of sophistication to it.\r\n\r\nAnd change your fashion and look gorgeous.\r\n\r\nCountry of Origin : India', 'women tshirt blue'),
(70, 47, 9, 15, '2024-11-24 14:42:34', 'Women Self Design Round Neck Wool Orange T-Shirt', 7, 'fwxs3_512.webp', 'e51pb_512.webp', 'pbxfu_512.webp', 249, 599, 'T-Shirt', 'Name : Women Self Design Round Neck Wool Orange T-Shirt\r\n\r\nFabric : Wool\r\n\r\nSleeve Length : Short Sleeves\r\n\r\nPattern : Self-Design\r\n\r\nNet Quantity (N) : 1\r\n\r\nSizes :  \r\n\r\nS (Bust Size : 36 in, Length Size: 23 in)\r\n\r\nM (Bust Size : 38 in, Length Size: 23 in)\r\n\r\nL (Bust Size : 40 in, Length Size: 24 in)\r\n\r\nXL (Bust Size : 42 in, Length Size: 24 in)\r\n\r\n \r\n\r\nCute Waffle Knit Tops-this awesome tops for women is made by Cotton and spandex blend waffle knit fabric, it is light weighted, stretchy and very soft, the fabric of this waffle top drapes nicely, making it looks fashionable.\r\n\r\nCountry of Origin : India', 'women tshirt red brown'),
(71, 47, 9, 16, '2024-11-24 17:40:52', 'T-shirt Polyester Activewear Gym, Sports Light Grey T-Shirt', 7, 'gp7qk_512.webp', 'mjx4p_512.webp', 'kqlrg_512.webp', 249, 599, 'T-Shirt', 'Name : T-shirt Polyester Activewear Gym, Sports Light Grey T-Shirt\r\n\r\nFabric : Polyester\r\n\r\nSleeve Length : Short Sleeves\r\n\r\nPattern : Solid\r\n\r\nNet Quantity (N) : 1\r\n\r\nSizes :  \r\n\r\nS (Bust Size : 32 in, Length Size: 27 in)\r\n\r\nM (Bust Size : 42 in, Length Size: 30 in)\r\n\r\nL (Bust Size : 35 in, Length Size: 28 in)\r\n\r\nXL (Bust Size : 34 in, Length Size: 27 in)\r\n\r\nXXL (Bust Size : 38 in, Length Size: 29 in)\r\n\r\nXXXL (Bust Size : 37 in, Length Size: 28 in)\r\n\r\n \r\n\r\nIt is Comfortable and gives you perfect look. The T-shirts are Breathable, Comfortable and Skin Friendly. Used for Multipurpose Sports Gym, Running, Casual Wear, Sports, Yoga, Casual Wear.\r\n\r\nCountry of Origin : India', 'women tshirt blue'),
(72, 47, 9, 15, '2024-11-27 06:29:30', 'SELVIKE STYLISH WOMENS COLORBLOCKED TSHIRT COMBO', 4, 'knhtf_512.webp', 'ubt1t_512.webp', 'pcwrw_512.webp', 322, 799, 'T-Shirt', '<p>Name : SELVIKE STYLISH WOMENS COLORBLOCKED TSHIRT COMBO Fabric : Cotton Blend Sleeve Length : Long Sleeves Pattern : Striped Net Quantity (N) : 2 Sizes : S (Bust Size : 34 in) M (Bust Size : 36 in) L (Bust Size : 38 in) XL (Bust Size : 40 in)</p>', 'women tshirt brown black combo'),
(74, 48, 9, 13, '2024-11-23 06:24:50', 'Women Regular Fit Solid Spread Collar Casual Shirt', 6, 'uan2g_512.webp', '8iwfv_512.webp', 'fmobh_512.webp', 299, 999, 'Shirt', '', 'women casual shirt'),
(75, 48, 9, 13, '2024-11-28 16:33:01', 'Women Regular Fit Solid Spread Collar Casual Shirt', 9, 'xl-689stk11603-selvia-original-imah2hjzgghxev7n.jpeg', 'xl-689stk11603-selvia-original-imah2hjznfjwqak3.jpeg', 'xl-689stk11603-selvia-original-imah2hjzz9tyj7mz.jpeg', 199, 799, 'Shirt', 'Pack of\r\n1\r\nStyle Code\r\n689STK11603\r\nClosure\r\nButton\r\nFit\r\nRegular\r\nFabric\r\nLycra Blend\r\nSleeve\r\nHalf Sleeve\r\nPattern\r\nSolid\r\nReversible\r\nNo', 'women casual shirt'),
(76, 48, 9, 20, '2024-11-28 16:35:01', 'Women Regular Fit Solid Spread Collar Casual Shirt', 9, '3xl-new-shirt-funday-fashion-original-imahyvwhfbu3nska.jpeg', '3xl-new-shirt-funday-fashion-original-imahyvwhr7pyryh8.jpeg', '3xl-new-shirt-funday-fashion-original-imahyvwhstkj4neq.jpeg', 199, 799, 'Shirt', 'Pack of\r\n1\r\nStyle Code\r\nNew Shirt\r\nFit\r\nRegular\r\nFabric\r\nViscose Rayon\r\nSleeve\r\nFull Sleeve\r\nPattern\r\nSolid\r\nReversible\r\nNo\r\nCollar\r\nSpread', 'women casual shirt'),
(77, 49, 9, 14, '2024-11-28 16:38:31', 'Women Regular Fit Solid Spread Collar Formal Shirt', 21, 's-329tk252-selvia-original-imagupvb6gzvm5vu.jpeg', 's-329tk252-selvia-original-imagpehebjnzreqn.jpeg', 's-329tk252-selvia-original-imagpehepca5zckr.jpeg', 229, 899, 'Shirt', 'Pack of\r\n1\r\nStyle Code\r\n329TK252\r\nFit\r\nRegular\r\nFabric\r\nCotton Blend\r\nSleeve\r\n3/4th Sleeve\r\nPattern\r\nSolid\r\nReversible\r\nNo\r\nCollar\r\nSpread', 'women formal shirt'),
(78, 49, 9, 11, '2024-11-28 16:40:30', 'Women Regular Fit Solid Curved Collar Formal Shirt', 2, 'm-103-fs-sky-blue-ronin-original-imagf38x8j2ypeep.jpeg', 'm-103-fs-sky-blue-ronin-original-imagf38xh4fwdn4q.jpeg', 'm-103-fs-sky-blue-ronin-original-imagf38xgpczy598.jpeg', 220, 799, 'Shirt', 'Pack of\r\n1\r\nStyle Code\r\n103_FS_SKY\r\nSecondary Color\r\nLight Blue\r\nClosure\r\nButton\r\nFit\r\nRegular\r\nFabric\r\nCotton Blend\r\nSleeve\r\n3/4th Sleeve\r\nPattern\r\nSolid', 'women formal shirt'),
(79, 50, 9, 12, '2024-11-28 16:43:12', 'Women Skinny Mid Rise Dark Blue Jeans', 13, '28-wwjn001099-wrangler-original-imagsy5ff5sewxwz.jpeg', '28-wwjn001099-wrangler-original-imagsy5fbewqkadw.jpeg', '28-wwjn001099-wrangler-original-imagsy5fskknscsh.jpeg', 399, 1299, 'Jeans', 'Style Code\r\nWWJN001099\r\nIdeal For\r\nWomen\r\nSuitable For\r\nWestern Wear\r\nPack Of\r\n0\r\nPocket Type\r\nCoin Pocket, Curved Pocket, Patch Pocket\r\nPattern\r\nWashed\r\nReversible\r\nNo\r\nSales Package\r\n1 Jeans', 'women jeans'),
(80, 50, 9, 17, '2024-11-28 16:45:30', 'Women Boyfriend High Rise Blue Jeans', 9, '32-j-1320-blue-kashian-original-imagz9cwk22hhgxv.jpeg', '32-j-1320-blue-kashian-original-imagz9cwuve3afhz.jpeg', '32-j-1320-blue-kashian-original-imagz9cwcvysarz9.jpeg', 349, 1999, 'Jeans', 'Style Code\r\nj-1320-BLUE\r\nIdeal For\r\nWomen\r\nSuitable For\r\nWestern Wear\r\nPack Of\r\n1\r\nPocket Type\r\nPatch Pocket\r\nPattern\r\nWashed\r\nReversible\r\nNo\r\nSales Package\r\n1 JEANS', 'women jeans'),
(81, 52, 9, 13, '2024-11-28 16:48:31', 'Women Regular Fit Black Viscose Rayon Trousers', 10, '28-kttwomenspant261-kotty-original-imagnrr9xcy9zgru.jpeg', '28-kttwomenspant261-kotty-original-imagnrr9vgfuhcz2.jpeg', '28-kttwomenspant261-kotty-original-imagnrr9hgxqh7y7.jpeg', 249, 899, 'Trouser', 'Fit\r\nRegular Fit\r\nOccasion\r\nCasual\r\nColor\r\nBlack\r\nPack of\r\n1\r\nType\r\nCasual Trousers\r\nSuitable For\r\nWestern Wear\r\nBelt Loops\r\nYes\r\nRise\r\nHigh', 'women trouser trousers'),
(82, 52, 9, 15, '2024-11-28 16:51:19', 'Women Regular Fit White Cotton Blend Trousers', 4, '26-sw0007-one-sky-original-imahfj7f5a3wubuc.jpeg', '26-sw0007-one-sky-original-imahfj7fa7fm2zrb.jpeg', '26-sw0007-one-sky-original-imahfj7fq4fwgjjf.jpeg', 299, 999, 'Trouser', 'Fit\r\nRegular Fit\r\nOccasion\r\nCasual\r\nColor\r\nBlack\r\nPack of\r\n1\r\nType\r\nCasual Trousers\r\nSuitable For\r\nWestern Wear\r\nBelt Loops\r\nYes\r\nRise\r\nHigh', 'women trouser trousers'),
(83, 53, 9, 16, '2024-11-28 16:53:24', 'Colorblock Women Track Suit', 9, 'l-purple-track-suit-benzos-original-imah5tjd8xnsx7g9.jpeg', 'l-purple-track-suit-benzos-original-imah5tjdxszy5ndy.jpeg', 'l-purple-track-suit-benzos-original-imah5tjdhz7tje6e.jpeg', 399, 999, 'Track Suits', 'Color\r\nPurple\r\nPattern\r\nColorblock\r\nStyle Code\r\nPURPLE TRACK SUIT\r\nSecondary Color\r\nBlack\r\nTop Closure\r\nzipper\r\nFabric\r\nPolyester Blend\r\nFabric Care\r\nhand wash, Do Not Blech\r\nSales Package\r\n1 Pants, 1 upper', 'women tracksuit tracksuits'),
(84, 53, 9, 19, '2024-11-28 16:55:04', 'Solid Women Track Suit', 12, 'xl-ttcs000038-tokyo-talkies-original-imagg9uwghzkzwmz.jpeg', 'xl-ttcs000038-tokyo-talkies-original-imagg9uwpdy8gtmr.jpeg', 'xl-ttcs000038-tokyo-talkies-original-imagg9uwvbeh7fat.jpeg', 199, 999, 'Track Suits', 'Color\r\nBrown\r\nPattern\r\nSolid\r\nStyle Code\r\nTTCS000038\r\nFabric\r\nCotton Blend\r\nSales Package\r\nCLOTHING SET', 'women tracksuit tracksuits'),
(85, 54, 9, 11, '2024-11-28 17:22:30', 'Women Full Sleeve Printed Hooded Sweatshirt', 10, 'm-jhd0423blpt25-juneberry-original-imah6pu8k4stehqk.jpeg', 'm-jhd0423blpt25-juneberry-original-imah6pu8n7hzbsfz.jpeg', 'm-jhd0423blpt25-juneberry-original-imah6pu8uuryzszk.jpeg', 199, 699, 'Sweatshirt', 'Color\r\nBlue\r\nFabric\r\nCotton Fleece Blend\r\nPattern\r\nPrinted\r\nNeck\r\nHooded Neck\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\nJHD0423BLPT25\r\nSales Package\r\n1 hoodie\r\nOccasion\r\nCasual', 'women sweatshirt sweatshirts'),
(86, 54, 9, 15, '2024-11-28 17:24:30', 'Women Full Sleeve Solid Sweatshirt', 12, 'xs-15158456-roadster-original-imaghgg36fmnrskh.jpeg', 'xs-15158456-roadster-original-imaghgg3zepqkb9p.jpeg', 'xs-15158456-roadster-original-imaghgg3uzvpg4ft.jpeg', 199, 599, 'Sweatshirt', 'Color\r\nGrey\r\nFabric\r\nPure Cotton\r\nPattern\r\nSolid\r\nNeck\r\nRound Neck\r\nSleeve\r\nFull Sleeve\r\nStyle Code\r\n15158456\r\nOccasion\r\nCasual\r\nHooded\r\nNo', 'women sweatshirt sweatshirts'),
(87, 55, 9, 19, '2024-11-28 17:26:37', 'Women Solid Quilted Jacket', 12, 'l-39240-fkblack-shopglobal-women-original-imaggjhjwvb8cwny.jpeg', 'l-39240-fkblack-shopglobal-women-original-imaggjhjzwhxwsqk.jpeg', 'l-39240-fkblack-shopglobal-women-original-imaggjhjbzktgnfx.jpeg', 699, 1299, 'Jacket', 'Color\r\nBlack\r\nFabric\r\nNylon\r\nPattern\r\nSolid\r\nStyle code\r\n39240 FKBLACK\r\nIdeal for\r\nWomen\r\nSleeve\r\nFull Sleeve\r\nClosure\r\nZipper\r\nPack of\r\n1', 'women jacket'),
(88, 55, 9, 19, '2024-11-28 17:29:04', 'Women Solid Puffer Jacket', 8, 'm-1-no-rtwjkts003fsred-rare-times-original-imah6npsgpphuwga.jpeg', 'm-1-no-rtwjkts003fsred-rare-times-original-imah6npssugkjqq6.jpeg', 'm-1-no-rtwjkts003fsred-rare-times-original-imah6npsc2qa7qcv.jpeg', 699, 12, 'Jacket', 'Color\r\nRed\r\nFabric\r\nNylon\r\nPattern\r\nSolid\r\nStyle code\r\nRTWJKTS003FSRED\r\nIdeal for\r\nWomen\r\nSleeve\r\nFull Sleeve\r\nClosure\r\nZipper\r\nSales package\r\n1 Women Jacket', 'women jacket'),
(89, 56, 9, 11, '2024-11-28 17:32:33', 'Women Printed Round Neck Purple Sweater', 11, 's-hair5-purple-ewools-original-imaghxxqcfhd5ugz.jpeg', 's-hair5-purple-ewools-original-imaghxxqgdquhev8.jpeg', 's-hair5-purple-ewools-original-imaghxxqqfyvj8ye.jpeg', 220, 599, 'Sweater', 'Color\r\nPurple\r\nFabric\r\nWool Blend\r\nNeck\r\nRound Neck\r\nPattern\r\nPrinted\r\nSleeve\r\nFull Sleeve\r\nSales Package\r\nPack of 1 Sweater\r\nStyle Code\r\nHair5-Purple\r\nSuitable For\r\nWestern Wear', 'Women Sweater'),
(90, 56, 9, 11, '2024-11-28 17:34:14', 'Women Woven Collared Neck Beige Sweater', 9, '4xl-coat8-camel-ewools-original-imag6v4v2hyaftkr.jpeg', '4xl-coat8-camel-ewools-original-imag6v4vs3dbwhc7.jpeg', '4xl-coat8-camel-ewools-original-imag6v4v3mm8uz9r.jpeg', 299, 799, 'Sweater', 'Color\r\nBeige\r\nFabric\r\nWool Blend\r\nNeck\r\nCollared Neck\r\nPattern\r\nWoven\r\nSleeve\r\nFull Sleeve\r\nSales Package\r\n1 Sweater\r\nStyle Code\r\nCoat8-Camel\r\nSuitable For\r\nWestern Wear', 'Women Sweater'),
(91, 57, 9, 16, '2024-11-28 17:37:07', 'Women Printed Viscose Rayon Straight Kurta  (Blue)', 11, 'xxl-23auw19727-220490-w-original-imagrnh3ghgpyt6u.jpeg', 'xxl-23auw19727-220490-w-original-imagrnh3jbfghhkv.jpeg', 'xxl-23auw19727-220490-w-original-imagrnh3p9grew9d.jpeg', 220, 899, 'Kurti', 'Ideal For\r\nWomen\r\nLength Type\r\nCalf Length\r\nBrand Color\r\nNavy blue\r\nOccasion\r\nCasual\r\nPattern\r\nPrinted\r\nType\r\nStraight\r\nFabric\r\nViscose Rayon\r\nNeck\r\nKeyhole Neck', 'Women Sweater'),
(92, 57, 9, 11, '2024-11-28 17:39:24', 'Women Embroidered Cotton Rayon Straight Kurta  (Pink)', 5, 's-victoria-pink-gd-gosriki-original-imah3qz64ydyvgve.jpeg', 's-victoria-pink-gd-gosriki-original-imah3qz6zwvafqbf.jpeg', 's-victoria-pink-gd-gosriki-original-imah3qz6mm3zbrqs.jpeg', 299, 899, 'Kurti', 'Ideal For\r\nWomen\r\nLength Type\r\nCalf Length\r\nBrand Color\r\nPink\r\nOccasion\r\nFestive & Party\r\nPattern\r\nEmbroidered\r\nType\r\nStraight\r\nFabric\r\nCotton Rayon\r\nNeck\r\nSweetheart Neck', 'Women Sweater'),
(93, 62, 10, 20, '2024-11-28 17:44:16', 'Baby Boys & Baby Girls Typography, Printed Cotton Blend Regular T Shirt  (Multicolor, Pack of 2)', 21, '11-12-years-cb-2-906-style-hood-blk-grey-m-uzee-original-imaguxrrxthps5vd.jpeg', '11-12-years-cb-2-906-style-hood-blk-grey-m-uzee-original-imaguxrrjydvrtp7.jpeg', '11-12-years-cb-2-906-style-hood-blk-grey-m-uzee-original-imaguxrrxthps5vd.jpeg', 220, 699, 'Dress', 'Brand\r\nrotaqo\r\nStyle Code\r\nCB(2)-906-STYLE-HOOD-BLK+GREY-26\r\nSize\r\n4 - 5 Years\r\nBrand Color\r\nMULTICOLOR\r\nIdeal For\r\nBaby Boys & Baby Girls\r\nFabric\r\nCotton Blend\r\nPrimary Color\r\nMulticolor\r\nPattern\r\nTypography, Printed', 'kids dress'),
(94, 62, 10, 11, '2024-11-28 17:47:31', 'Boys Printed Pure Cotton Regular T Shirt  (Black, Pack of 1)', 9, '10-12-years-pb540949-pepe-jeans-original-imahy8gqnftar5sy.jpeg', '10-12-years-pb540949-pepe-jeans-original-imahy8gqnnetfzzc.jpeg', '10-12-years-pb540949-pepe-jeans-original-imahy8gqcbhac5qp.jpeg', 179, 399, 'T-Shirt', 'Size: \r\n6 - 8 Years', 'kids tshirt'),
(95, 61, 10, 20, '2024-11-28 17:50:27', 'Boys Regular Fit Solid Casual Shirt', 9, '3-4-years-d32-a11-02-155-juniors-original-imah5wrdge4ejrzy.jpeg', '3-4-years-d32-a11-02-155-juniors-original-imah5wrdwmdk2ryw.jpeg', '3-4-years-d32-a11-02-155-juniors-original-imah5wrdcne7jb94.jpeg', 169, 599, 'Shirt', 'Size: 5-6 Years', 'boy tshirt kids tshirt'),
(96, 61, 10, 11, '2024-11-28 17:53:04', 'Girls Regular Fit Striped Casual Shirt', 9, '5-6-years-ntd-41-fizacreation-original-imah4h5uwghwxzjr.jpeg', '5-6-years-ntd-41-fizacreation-original-imah4h5ujfhfegpd.jpeg', '5-6-years-ntd-41-fizacreation-original-imah4h5ufwfj6z9q.jpeg', 169, 599, 'Shirt', 'Size : 5-6 Years', 'girl tshirt'),
(97, 63, 10, 11, '2024-11-28 17:56:03', 'Girls Maxi/Full Length Casual Dress  (Dark Blue, 3/4 Sleeve)', 8, '8-9-years-girls-jacket-set-queen-navy-19-imsy-original-imaggdpgtne3nyun.jpeg', '10-11-years-jacket-set-child-navy-neysa-original-imag4hz2vusksgeb.jpeg', '10-11-years-jacket-set-child-navy-neysa-original-imag4hz2qesfvxxx.jpeg', 299, 799, 'Dress', 'Size: 8-9 Years', 'girls dress'),
(98, 63, 10, 11, '2024-11-28 18:00:19', 'Girls Maxi/Full Length Casual Dress  (Dark Blue, 3/4 Sleeve)', 8, '8-9-years-girls-jacket-set-queen-navy-19-imsy-original-imaggdpgtne3nyun.jpeg', '10-11-years-jacket-set-child-navy-neysa-original-imag4hz2vusksgeb.jpeg', '10-11-years-jacket-set-child-navy-neysa-original-imag4hz2qesfvxxx.jpeg', 299, 799, 'Dress', 'Size: 8-9 Years', 'girls dress'),
(99, 63, 10, 11, '2024-11-28 18:13:42', 'Girls Below Knee Festive/Wedding Dress  (Maroon, Half Sleeve)', 9, '7-8-years-bol-pint-plating-sk-jj-dresses-original-imagyhv5guwbvuqy.jpeg', '7-8-years-bol-pint-plating-sk-jj-dresses-original-imagyhv5ak6pbexg.jpeg', '7-8-years-bol-pint-plating-sk-jj-dresses-original-imagyhv5vzqcgzyz.jpeg', 299, 799, 'Dress', 'Size: 6-7 Years color: red & white', 'girls dress'),
(100, 66, 11, 11, '2024-11-29 01:45:02', 'Embroidered Sports/Regular Cap', 21, 'free-latest-design-924-polo-store-original-imah59gvgtunhkmh.jpeg', 'free-latest-design-804-polo-store-original-imagz6f6gheujrhg.jpeg', 'free-latest-design-904-polo-store-original-imah58pkjdp6fqgg.jpeg', 79, 299, 'Cap', 'Fabric\r\n50% Cotton, 50% Polyester\r\nColor\r\nMaroon\r\nPattern\r\nEmbroidered\r\nStyle code\r\nLatest design 924\r\nFastener\r\nBuckle\r\nFabric care\r\nHand wash, Do not wring\r\nOther details\r\nProtect your skin from harmful UV rays and keep your hair out of your face and eyes by wearing this baseball caps during all yours outdoor indoor activities. Durable lightweight and easy to care.\r\nNet Quantity\r\n1', 'cap'),
(101, 64, 11, 11, '2024-11-29 01:46:56', 'Men Casual Multicolor Nylon Belt', 9, 'one-size-mdl-opd-50-sty-opd-50-belt-provogue-original-imahf9k9gjfypydq.jpeg', 'one-size-mdl-opd-50-sty-opd-50-belt-provogue-original-imahf9k9spzzdkxn.jpeg', 'one-size-mdl-opd-49-sty-opd-49-belt-provogue-original-imahf9k9hzgvfyvb.jpeg', 99, 299, 'Belt', 'Model Name\r\nMDL-OPD-50\r\nType\r\nBELT\r\nLeather Type\r\nNapa\r\nSize\r\nOne Size\r\nTanning Process\r\nSynthetic\r\nPatterned Belt\r\nWoven Design\r\nOther Features\r\nFOR DAY TO DAY USE,BROADNESS OF BELT-40 MM,1.4 INCHES\r\nBelt Width\r\n1.4 inches', 'belt'),
(102, 68, 11, 11, '2024-11-29 01:49:13', 'by Lenskart Polarized, UV Protection Rectangular Sunglasses (57)  (For Men & Women, Blue)', 8, '57-vc-s13830-vincent-chase-original-imahyq7jsxfd4guv.jpeg', '57-vc-s13830-vincent-chase-original-imah4ebsr3ahgfby.jpeg', '57-vc-s13830-vincent-chase-original-imah4ebsrggmmwbg.jpeg', 129, 299, 'Sun Glass', 'Size\r\nThis product is sold as Medium by the Brand\r\nIdeal For\r\nMen & Women\r\nPurpose\r\nStyle, Eye Protection, Driving, Biking, Running\r\nLens Color and Material\r\nBlue, Polycarbonate\r\nFeatures\r\nPolarized, UV Protection\r\nFrame Color\r\nGrey\r\nModel Name\r\nThe Metal Edit\r\nType\r\nRectangular', 'sun glasses');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` text NOT NULL,
  `p_cat_desc` text NOT NULL,
  `cat_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`p_cat_id`, `p_cat_title`, `p_cat_desc`, `cat_id`) VALUES
(26, 'T-Shirts', '                                                                                                                                                                                                                                                                                                                ', 8),
(27, 'Casual Shirts', '                                                                    ', 8),
(28, 'Formal Shirts', '                                                                                                                                        ', 8),
(29, 'Jeans', '', 8),
(30, 'Casual Trousers', '', 8),
(31, 'Formal Trousers', '', 8),
(32, 'Track Pants', '', 8),
(33, 'Track Suits', '', 8),
(34, 'Sweatshirts', '', 8),
(35, 'Jackets', '', 8),
(36, 'Sweaters', '', 8),
(37, 'Kurtas', '', 8),
(38, 'Ethnic Sets', '', 8),
(39, 'Sherwanis', '', 8),
(47, 'T-Shirts', '                                                                            ', 9),
(48, 'Casual Shirt', '', 9),
(49, 'Formal Shirt', '', 9),
(50, 'Jeans', '', 9),
(52, 'Trousers', '', 9),
(53, 'Track Suits', '', 9),
(54, 'Sweatshirts', '', 9),
(55, 'Jackets', '', 9),
(56, 'Sweaters', '', 9),
(57, 'Kurti', '                                                                            ', 9),
(61, 'Shirts', '', 10),
(62, 'T-Shirt', '', 10),
(63, 'Dresses', '', 10),
(64, 'Belt', '', 11),
(66, 'Cap', '', 11),
(68, 'Sun Glasses', '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `review_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `review_text` text NOT NULL,
  `review_rating` varchar(100) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`review_id`, `product_id`, `reviewer_name`, `review_text`, `review_rating`, `review_date`) VALUES
(1, 14, '', 'good', '4', '2024-10-28 02:06:34'),
(2, 14, '', 'good', '3', '2024-10-28 02:06:49'),
(3, 14, '', 'safds', '3', '2024-10-28 02:17:38'),
(4, 14, '', 'j', '3', '2024-10-28 02:26:12'),
(5, 14, '', 'fc', '2', '2024-10-28 02:26:21'),
(6, 11, '', 'nice', '4', '2024-10-28 02:29:59'),
(7, 11, 'deepak', 'Good', '2', '2024-10-28 07:04:19'),
(8, 11, '', 'good', '3', '2024-10-28 02:35:53'),
(9, 11, '', 'ff', '3', '2024-10-28 02:36:07'),
(10, 11, 'Deepak Kumar', 'j', '2', '2024-10-28 02:37:27'),
(11, 11, 'Ankit Sachan', 'good', '2', '2024-10-28 02:57:30'),
(12, 11, 'Ankit Sachan', 'good', '2', '2024-10-28 02:58:11'),
(13, 11, 'ANMOL TIWARI', 'fd', '2', '2024-10-28 03:02:14'),
(14, 11, 'fgh', 'fgh', '3', '2024-10-28 03:02:32'),
(15, 10, 'Ankit Sachan', 'dfs', '3', '2024-10-28 03:03:07'),
(16, 10, 'ANMOL TIWARI', 'wedrw', '2', '2024-10-28 03:05:16'),
(17, 10, 'Nishu Sachan', 'fine', '4', '2024-10-28 03:06:45'),
(18, 10, 'Nishu Sachan', 'fghfh', '2', '2024-10-28 03:08:45'),
(19, 14, 'nishu', '', '2', '2024-10-28 03:52:43'),
(20, 14, 'sda', '', '1', '2024-10-28 03:58:16'),
(21, 31, 'minku', 'Nice jeans', '3', '2024-11-03 23:17:36'),
(22, 31, 'vinay', '', '1', '2024-11-03 23:17:57'),
(23, 31, 'Vaishnavi Srivastava', '', '5', '2024-11-03 23:19:45'),
(24, 68, 'Jeetu pal', 'Very good product.', '5', '2024-11-11 23:09:03'),
(25, 67, 'VAISHNAVI SRIVASTAVA', '', '3', '2024-11-12 03:27:18'),
(26, 46, 'Jeetu pal', 'Best tshirt', '5', '2024-11-21 04:59:55'),
(27, 46, 'Ankit', 'Good', '4', '2024-11-21 05:00:13'),
(28, 41, 'Ankit Sachan', 'nice pant for men', '5', '2024-11-24 18:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `return_refund`
--

CREATE TABLE `return_refund` (
  `return_refund_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `return_refund_status` enum('None','Requested','Approved','Rejected','Returned / Refunded') DEFAULT 'None',
  `return_refund_reason` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_at` timestamp NULL DEFAULT NULL,
  `transfer_method` varchar(20) NOT NULL DEFAULT 'bank_transfer',
  `refund_amount` decimal(10,2) NOT NULL,
  `refunded_to` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `ship_address` varchar(255) NOT NULL,
  `bill_address` varchar(255) NOT NULL,
  `cust_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_refund`
--

INSERT INTO `return_refund` (`return_refund_id`, `order_id`, `product_id`, `cust_id`, `invoice_no`, `transaction_id`, `product_title`, `return_refund_status`, `return_refund_reason`, `requested_at`, `processed_at`, `transfer_method`, `refund_amount`, `refunded_to`, `order_date`, `ship_address`, `bill_address`, `cust_contact`) VALUES
(41, 280, 53, 32, 'INV-674297A601921', 'TXN-67429d24aced9-1732418852', 'Men Self Design V Neck Black Sweater', 'Returned / Refunded', 'Item does not match description', '2024-11-24 03:25:39', '2024-11-24 03:27:32', 'bank_transfer', 599.00, 'NISHU SACHAN, STATE BANK OF INDIA (765432134564), IFSC: SBIN6723145', '2024-11-24 08:34:06', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '45C B BLOCK, GOPALA TOWER, KANPUR, KANPUR NAGAR, UTTAR PRADESH - 209312, INDIA', '9005673421');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(10) NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_image` text NOT NULL,
  `slider_url` varchar(255) DEFAULT NULL,
  `slider_season` text DEFAULT NULL,
  `slider_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `slider_name`, `slider_image`, `slider_url`, `slider_season`, `slider_text`) VALUES
(24, '1', 'clothifyai.png', 'http://localhost:8000/shop.php', '', ''),
(25, '2', '1600w-lYcbGpUSVGo.webp', 'http://localhost:8000/shop.php?p_cat=36', '', ''),
(26, '3', 'maxresdefault.jpg', 'http://localhost:8000/shop.php?p_cat=47', '', ''),
(27, '4', 'R.jpeg', 'http://localhost:8000/shop.php?p_cat=26', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `term_id` int(10) NOT NULL,
  `term_title` varchar(100) NOT NULL,
  `term_link` varchar(100) NOT NULL,
  `term_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_id`, `term_title`, `term_link`, `term_desc`) VALUES
(1, 'Payment Terms', 'link-1', 'All payments must be made in Rupee (Indian Currency). We accept payment by Credit Card/Debit Card/Net banking/UPI/Wallet/Cash On Delivery(COD).'),
(2, 'Refund and Replace Policy', 'link-2', 'If you are not satisfied with your purchase, you may return and replace the item(s) within 5 days of receipt for a full refund of the purchase price or a \r\nexchange of the purchased product, excluding shipping and handling charges. Returns and Replace must be in new and unused condition, in the original packaging, and with all original tags attached. We reserve the right to refuse any return and exchange that does not meet these requirements.'),
(3, 'Shipping and Delivery', 'link-3', 'Shipping and delivery dates are estimates only and cannot be guaranteed. We will use commercially reasonable efforts to deliver products as quickly as possible. Title to the products and risk of loss or damage to the products will pass to you upon delivery to the carrier.'),
(4, 'Product Availability', 'link-4', 'We make every effort to display the products and their details accurately on our website. However, we do not guarantee that the product descriptions, prices, or any other content available on the site are error-free, complete, or current. In the event that a product is listed at an incorrect price, we shall have the right to refuse or cancel orders placed for that product.'),
(5, 'Order Processing', 'link-5', 'Your receipt of an electronic or other form of order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell. We reserve the right at any time after receipt of your order to accept or decline your order for any reason. We may require additional verifications or information before accepting any order.'),
(6, 'Governing Law', 'link-6', 'These terms and conditions are governed by and construed in accordance with the laws of India and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.'),
(7, 'Disclaimers', 'link-7', 'The materials on Clothify’s website are provided “as is”. Clothify makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, Clothiy does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its website or otherwise relating to such materials or on any sites linked to this site.');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `cust_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `cust_id`, `product_id`, `posting_date`) VALUES
(28, 7, 14, '2024-10-28 13:22:30'),
(32, 7, 24, '2024-11-05 04:33:17'),
(36, 8, 68, '2024-11-12 03:38:36'),
(45, 32, 0, '2024-11-24 14:06:07'),
(57, 34, 66, '2024-11-25 04:40:48'),
(59, 32, 71, '2024-11-26 03:19:05'),
(60, 32, 46, '2024-11-26 03:19:19'),
(61, 32, 54, '2024-11-26 12:08:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `boxes_section`
--
ALTER TABLE `boxes_section`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `customer_bank_details`
--
ALTER TABLE `customer_bank_details`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `customer_billing_address`
--
ALTER TABLE `customer_billing_address`
  ADD PRIMARY KEY (`billing_address_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payid`);

--
-- Indexes for table `policy_details`
--
ALTER TABLE `policy_details`
  ADD PRIMARY KEY (`policy_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `return_refund`
--
ALTER TABLE `return_refund`
  ADD PRIMARY KEY (`return_refund_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `about_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `boxes_section`
--
ALTER TABLE `boxes_section`
  MODIFY `box_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `customer_bank_details`
--
ALTER TABLE `customer_bank_details`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_billing_address`
--
ALTER TABLE `customer_billing_address`
  MODIFY `billing_address_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  MODIFY `enquiry_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `policy_details`
--
ALTER TABLE `policy_details`
  MODIFY `policy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `review_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `return_refund`
--
ALTER TABLE `return_refund`
  MODIFY `return_refund_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `term_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_bank_details`
--
ALTER TABLE `customer_bank_details`
  ADD CONSTRAINT `customer_bank_details_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE;

--
-- Constraints for table `return_refund`
--
ALTER TABLE `return_refund`
  ADD CONSTRAINT `return_refund_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`),
  ADD CONSTRAINT `return_refund_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
