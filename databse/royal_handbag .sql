-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 16, 2025 at 12:29 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `royal_handbag`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `name`, `email`, `password`, `image`) VALUES
(1, 'Dapu Chauhan', 'dapu@gmail.com', 'Dapu@123', '1753690643_5a.png'),
(2, 'Trushali Babariya', 'trushi@gmail.com', 'Trushi@123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(27, 7, 73, 1, '2025-07-13 14:42:30'),
(28, 7, 68, 1, '2025-07-13 14:42:46'),
(31, 10, 77, 1, '2025-07-14 15:04:16'),
(32, 6, 77, 1, '2025-07-14 15:29:36'),
(33, 6, 72, 1, '2025-07-14 15:29:43'),
(35, 11, 77, 2, '2025-09-02 10:31:58'),
(36, 11, 73, 1, '2025-09-02 10:33:03'),
(37, 11, 76, 1, '2025-09-02 10:36:30'),
(46, 12, 47, 1, '2025-09-10 10:55:46'),
(47, 12, 68, 1, '2025-09-10 10:56:04'),
(52, 1, 52, 1, '2025-09-11 09:17:08'),
(54, 1, 71, 1, '2025-09-11 09:23:57'),
(55, 1, 65, 1, '2025-09-11 09:24:18'),
(56, 3, 76, 4, '2025-09-12 11:06:07'),
(58, 1, 76, 2, '2025-09-13 09:19:53'),
(59, 1, 75, 2, '2025-09-13 09:22:02'),
(60, 3, 77, 5, '2025-09-13 09:26:51'),
(61, 3, 48, 1, '2025-09-14 09:17:24'),
(62, 1, 77, 2, '2025-09-16 07:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Handbags'),
(2, 'Clutches'),
(3, 'Tote Bags'),
(4, 'Sling Bags'),
(5, 'Shoulder Bags'),
(6, 'Satchel Bags'),
(7, 'Wallets'),
(8, 'Mini Bags');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `state_id`, `name`) VALUES
(1, 1, 'Los Angeles'),
(2, 1, 'San Francisco'),
(3, 1, 'San Diego'),
(4, 1, 'Sacramento'),
(5, 2, 'Houston'),
(6, 2, 'Dallas'),
(7, 2, 'Austin'),
(8, 2, 'San Antonio'),
(9, 3, 'Miami'),
(10, 3, 'Orlando'),
(11, 3, 'Tampa'),
(12, 3, 'Jacksonville'),
(13, 4, 'New York City'),
(14, 4, 'Buffalo'),
(15, 4, 'Rochester'),
(16, 4, 'Albany'),
(17, 11, 'London'),
(18, 11, 'Manchester'),
(19, 11, 'Birmingham'),
(20, 11, 'Liverpool'),
(21, 12, 'Edinburgh'),
(22, 12, 'Glasgow'),
(23, 12, 'Aberdeen'),
(24, 12, 'Dundee'),
(25, 15, 'Toronto'),
(26, 15, 'Ottawa'),
(27, 15, 'Mississauga'),
(28, 15, 'Brampton'),
(29, 16, 'Montreal'),
(30, 16, 'Quebec City'),
(31, 16, 'Laval'),
(32, 16, 'Gatineau'),
(33, 25, 'Sydney'),
(34, 25, 'Newcastle'),
(35, 25, 'Wollongong'),
(36, 25, 'Parramatta'),
(37, 26, 'Melbourne'),
(38, 26, 'Geelong'),
(39, 26, 'Ballarat'),
(40, 26, 'Bendigo'),
(41, 7, 'Ahmedabad'),
(42, 7, 'Surat'),
(43, 7, 'Vadodara'),
(44, 7, 'Rajkot'),
(45, 7, 'Bhavnagar'),
(46, 7, 'Jamnagar'),
(47, 7, 'Junagadh'),
(48, 7, 'Gandhinagar'),
(49, 7, 'Anand'),
(50, 7, 'Navsari'),
(51, 7, 'Morbi'),
(52, 7, 'Nadiad'),
(53, 7, 'Surendranagar'),
(54, 7, 'Bharuch'),
(55, 7, 'Porbandar'),
(56, 7, 'Godhra'),
(57, 7, 'Valsad'),
(58, 7, 'Mehsana'),
(59, 7, 'Palanpur'),
(60, 7, 'Veraval'),
(61, 7, 'Botad'),
(62, 7, 'Dahod'),
(63, 7, 'Amreli'),
(64, 7, 'Patan'),
(65, 7, 'Vyara'),
(66, 7, 'Modasa'),
(67, 7, 'Kalol'),
(68, 7, 'Himatnagar'),
(69, 7, 'Deesa');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `email`, `message`, `submitted_at`) VALUES
(1, 'trushalibabariya1@gmail.com', 'gvhc', '2025-07-06 10:17:25'),
(2, 'd@gmail.com', 'jkdkjccf', '2025-09-10 09:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'India'),
(2, 'United States'),
(3, 'United Kingdom'),
(4, 'Canada'),
(5, 'Australia'),
(6, 'Germany'),
(7, 'France'),
(8, 'China'),
(9, 'Japan'),
(10, 'Russia'),
(11, 'Afghanistan'),
(12, 'Albania'),
(13, 'Algeria'),
(14, 'Andorra'),
(15, 'Angola'),
(16, 'Argentina'),
(17, 'Armenia'),
(18, 'Austria'),
(19, 'Azerbaijan'),
(20, 'Bahamas'),
(21, 'Bahrain'),
(22, 'Bangladesh'),
(23, 'Barbados'),
(24, 'Belarus'),
(25, 'Belgium'),
(26, 'Belize'),
(27, 'Benin'),
(28, 'Bhutan'),
(29, 'Bolivia'),
(30, 'Bosnia and Herzegovina'),
(31, 'Botswana'),
(32, 'Brazil'),
(33, 'Brunei'),
(34, 'Bulgaria'),
(35, 'Burkina Faso'),
(36, 'Burundi'),
(37, 'Cambodia'),
(38, 'Cameroon'),
(39, 'Cape Verde'),
(40, 'Central African Republic'),
(41, 'Chad'),
(42, 'Chile'),
(43, 'Colombia'),
(44, 'Comoros'),
(45, 'Congo'),
(46, 'Costa Rica'),
(47, 'Croatia'),
(48, 'Cuba'),
(49, 'Cyprus'),
(50, 'Czech Republic'),
(51, 'Denmark'),
(52, 'Djibouti'),
(53, 'Dominican Republic'),
(54, 'Ecuador'),
(55, 'Egypt'),
(56, 'El Salvador'),
(57, 'Estonia'),
(58, 'Ethiopia'),
(59, 'Fiji'),
(60, 'Finland'),
(61, 'Gabon'),
(62, 'Gambia'),
(63, 'Georgia'),
(64, 'Ghana'),
(65, 'Greece'),
(66, 'Guatemala'),
(67, 'Guinea'),
(68, 'Guyana'),
(69, 'Haiti'),
(70, 'Honduras'),
(71, 'Hungary'),
(72, 'Iceland'),
(73, 'Indonesia'),
(74, 'Iran'),
(75, 'Iraq'),
(76, 'Ireland'),
(77, 'Israel'),
(78, 'Italy'),
(79, 'Jamaica'),
(80, 'Jordan'),
(81, 'Kazakhstan'),
(82, 'Kenya'),
(83, 'Kuwait'),
(84, 'Kyrgyzstan'),
(85, 'Laos'),
(86, 'Latvia'),
(87, 'Lebanon'),
(88, 'Lesotho'),
(89, 'Liberia'),
(90, 'Libya'),
(91, 'Lithuania'),
(92, 'Luxembourg'),
(93, 'Madagascar'),
(94, 'Malawi'),
(95, 'Malaysia'),
(96, 'Maldives'),
(97, 'Mali'),
(98, 'Malta'),
(99, 'Mauritania'),
(100, 'Mauritius'),
(101, 'Mexico'),
(102, 'Moldova'),
(103, 'Monaco'),
(104, 'Mongolia'),
(105, 'Montenegro'),
(106, 'Morocco'),
(107, 'Mozambique'),
(108, 'Myanmar'),
(109, 'Namibia'),
(110, 'Nepal'),
(111, 'Netherlands'),
(112, 'New Zealand'),
(113, 'Nicaragua'),
(114, 'Niger'),
(115, 'Nigeria'),
(116, 'North Korea'),
(117, 'Norway'),
(118, 'Oman'),
(119, 'Pakistan'),
(120, 'Palestine'),
(121, 'Panama'),
(122, 'Paraguay'),
(123, 'Peru'),
(124, 'Philippines'),
(125, 'Poland'),
(126, 'Portugal'),
(127, 'Qatar'),
(128, 'Romania'),
(129, 'Rwanda'),
(130, 'Saudi Arabia'),
(131, 'Senegal'),
(132, 'Serbia'),
(133, 'Seychelles'),
(134, 'Sierra Leone'),
(135, 'Singapore'),
(136, 'Slovakia'),
(137, 'Slovenia'),
(138, 'Somalia'),
(139, 'South Africa'),
(140, 'South Korea'),
(141, 'Spain'),
(142, 'Sri Lanka'),
(143, 'Sudan'),
(144, 'Suriname'),
(145, 'Swaziland'),
(146, 'Sweden'),
(147, 'Switzerland'),
(148, 'Syria'),
(149, 'Taiwan'),
(150, 'Tajikistan'),
(151, 'Tanzania'),
(152, 'Thailand'),
(153, 'Togo'),
(154, 'Trinidad and Tobago'),
(155, 'Tunisia'),
(156, 'Turkey'),
(157, 'Turkmenistan'),
(158, 'Uganda'),
(159, 'Ukraine'),
(160, 'United Arab Emirates'),
(161, 'Uruguay'),
(162, 'Uzbekistan'),
(163, 'Venezuela'),
(164, 'Vietnam'),
(165, 'Yemen'),
(166, 'Zambia'),
(167, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `product_id`, `order_id`, `comment`, `image`, `created_at`) VALUES
(1, 3, 72, 1, 'vbhfkrgfikrgehi', 'feedback_img/fb_68c9386f529fa.jpg', '2025-09-16 15:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read') DEFAULT 'unread',
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `created_at`, `status`, `link`) VALUES
(1, 'New user registered: ', '2025-07-05 21:08:32', 'read', NULL),
(2, 'New user registered: ', '2025-07-05 21:08:42', 'read', NULL),
(3, 'New user registered: ', '2025-07-05 21:08:50', 'read', NULL),
(4, 'New user registered: ', '2025-07-05 21:08:52', 'read', NULL),
(5, 'New user registered: ', '2025-07-05 21:08:53', 'read', NULL),
(6, 'New user registered: ', '2025-07-05 21:08:55', 'read', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_details` text,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `email`, `phone`, `address`, `city`, `zip`, `payment_method`, `payment_details`, `total_amount`, `created_at`, `status`, `user_id`) VALUES
(1, 'trushi babariya', 't@gmail.com', '9873498696', 'mckbvkfb', 'junagadh', '726384', 'cod', 'Cash on Delivery', '750.00', '2025-09-16 10:02:53', 'Delivered', 3),
(2, 'trushi babariya', 't@gmail.com', '9873498696', 'ncmjbvbkg', 'jamnagar', '673974', 'cod', 'Cash on Delivery', '850.00', '2025-09-16 10:05:22', 'Delivered', 3),
(3, 'trushi babariya', 't@gmail.com', '9873498696', 'kbdkjfbbk', 'junagadh', '364798', 'cod', 'Cash on Delivery', '700.00', '2025-09-16 10:22:24', 'Pending', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `image`) VALUES
(1, 1, 72, 'Sling Bags', '650.00', 1, '140a.jpg'),
(2, 2, 57, 'Tote Bags', '750.00', 1, '121a.jpg'),
(3, 3, 69, 'Mini Bags', '600.00', 1, '108a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  `is_featured` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image1`, `image2`, `image3`, `category_id`, `stock`, `is_featured`) VALUES
(1, 'handbag', '500.00', '', '48.webp', '', '', 1, 10, 0),
(2, 'handbag', '600.00', '', '000.jfif', '', '', 1, 30, 0),
(3, 'handbag', '1200.00', 'hgdef', '43a.jpg', '43b.jpg', '43c.jpg', 2, 6, 0),
(4, 'Soft Pink Leather Handbag', '9000.00', 'Elegant and stylish structured soft pink leather handbag with gold twist-lock closure and a top handle. Perfect for both casual and formal occasions. Durable finish with a classic feminine look.\r\n', '2a.jpg', '', '', 1, 20, 0),
(5, 'bag', '8764.00', 'pirutiweurge', '15a.jpg', '', '', 3, 12, 0),
(7, 'handbag', '900.00', 'best bag quality', '12a.jpg', '', '', 8, 10, 0),
(8, 'handbag', '969.00', 'gsylfdi', '31a.jpg', '', '', 2, 3, 0),
(9, 'handbag', '1000.00', 'best quality ', '56a.jpg', '', '', 6, 15, 0),
(10, 'Handbags', '999.00', 'best handbag', '49a.jpg', '', '', 6, 20, 0),
(11, 'Satchel Bags', '999.00', 'hbhssbwj', '4a.jpg', '', '', 6, 25, 0),
(12, 'Shoulder Bags', '1100.00', 'hsvhbsh', '89a.jpg', '89b.jpg', '', 5, 15, 0),
(13, 'Shoulder Bags', '999.00', '', '90a.jpg', '', '', 5, 25, 0),
(14, 'Shoulder Bags', '899.00', 'mhvsa', '54a.jpg', '', '', 5, 30, 0),
(15, 'Shoulder Bags', '500.00', 'nakHVVAH', '76a.jpg', '', '', 5, 10, 0),
(16, 'Shoulder Bags', '700.00', 'ygfdgdr', '69a.jpg', '', '', 5, 20, 0),
(17, 'Satchel Bags', '800.00', 'hgcdyucg', '5a.jpg', '5b.jpg', '', 6, 30, 0),
(18, 'Satchel Bags', '999.00', 'best quality bags', '7a.jpg', '7b.jpg', '', 6, 15, 0),
(19, 'Sling Bags', '1000.00', 'best quality', '9a.jpg', '9b.jpg', '', 4, 30, 0),
(20, 'Satchel Bags', '999.00', 'best quality', '2c.jpg', '2b.jpg', '', 6, 10, 0),
(21, 'Shoulder Bags', '850.00', 'best choice', '41a.jpg', '41b.jpg', '41c.jpg', 5, 15, 0),
(22, 'Shoulder Bags', '500.00', 'best choice bags', '42a.jpg', '42b.jpg', '42c.jpg', 5, 12, 0),
(23, 'Clutches', '700.00', 'best bags', '20a.jpg', '', '', 2, 25, 0),
(24, 'Satchel Bags', '999.00', 'white bag', '37a.webp', '', '', 6, 50, 0),
(25, 'Shoulder Bags', '464.00', 'kjjg', '2d.jpg', '2c.jpg', '', 2, 30, 0),
(27, 'Shoulder Bags', '888.00', 'ytfg', '46a.jpg', '46b.jpg', '46c.jpg', 5, 25, 0),
(28, 'Shoulder Bags', '750.00', 'hghfg', '48a.jpg', '48.jpg', '48c.jpg', 5, 22, 0),
(29, 'Satchel Bags', '1100.00', 'jhyvxsg', '80a.jpg', '', '', 6, 30, 0),
(30, 'Satchel Bags', '1200.00', '', '86a.jpg', '', '', 6, 30, 0),
(31, 'Tote Bags', '800.00', '', '88a.jpg', '88b.jpg', '', 3, 52, 0),
(32, 'Satchel Bags', '850.00', '', '83a.jpg', '', '', 6, 25, 0),
(33, 'Mini Bags', '500.00', '', '84a.jpg', '', '', 8, 29, 0),
(34, 'Handbags', '600.00', '', '81a.jpg', '', '', 1, 56, 0),
(35, 'Sling Bags', '555.00', 'gsccn', '64a.jpg', '64b.jpg', '', 4, 20, 0),
(36, 'Handbags', '650.00', '', '61a.jpg', '63a.jpg', '', 1, 25, 0),
(37, 'Handbags', '750.00', '', '66a.jpg', '', '', 1, 28, 0),
(38, 'Sling Bags', '850.00', '', '65a.jpg', '', '', 4, 21, 0),
(39, 'Tote Bags', '450.00', '', '72a.jpg', '', '', 3, 35, 0),
(40, 'Sling Bags', '400.00', '', '58a.jpg', '59a.jpg', '', 4, 26, 0),
(41, 'Shoulder Bags', '600.00', '', '67a.jpg', '', '', 5, 19, 0),
(42, 'Handbags', '750.00', '', '33a.jpg', '', '', 1, 14, 0),
(43, 'Handbags', '650.00', '', '70a.jpg', '71a.jpg', '', 1, 35, 0),
(44, 'Handbags', '600.00', '', '75a.jpg', '', '', 1, 45, 0),
(45, 'Tote Bags', '750.00', '', '77a.jpg', '', '', 3, 30, 0),
(46, 'Handbags', '552.00', '', '74a.jpg', '', '', 1, 20, 0),
(47, 'Clutches', '444.00', '', '6a.jpg', '6b.jpg', '', 2, 35, 0),
(48, 'Tote Bags', '650.00', '', '8a.jpg', '', '', 3, 35, 0),
(49, 'Mini Bags', '670.00', '', '113a.jpg', '113b.jpg', '113c.jpg', 8, 36, 0),
(50, 'Sling Bags', '500.00', '', '111a.jpg', '111b.jpg', '', 4, 22, 0),
(51, 'Tote Bags', '456.00', '', '107a.jpg', '107b.jpg', '', 3, 45, 0),
(52, 'Satchel Bags', '800.00', '', '102a.jpg', '102b.jpg', '', 6, 52, 0),
(53, 'Tote Bags', '800.00', '', '101a.jpg', '', '', 3, 11, 0),
(54, 'Tote Bags', '900.00', '', '97a.jpg', '', '', 3, 15, 0),
(55, 'Sling Bags', '666.00', '', '114a.jpg', '', '', 4, 14, 0),
(56, 'Tote Bags', '870.00', '', '118a.jpg', '', '', 3, 25, 0),
(57, 'Tote Bags', '750.00', '', '121a.jpg', '', '', 3, 18, 0),
(58, 'Clutches', '800.00', 'hbxvc', '124a.jpg', '', '', 2, 20, 0),
(59, 'Clutches', '750.00', '', '127a.jpg', '', '', 2, 10, 0),
(60, 'Clutches', '600.00', '', '130a.jpg', '', '', 2, 30, 0),
(61, 'Clutches', '800.00', '', '128a.jpg', '', '', 2, 15, 0),
(62, 'Clutches', '860.00', '', '129a.jpg', '', '', 2, 25, 0),
(63, 'Mini Bags', '600.00', '', '132a.jpg', '', '', 8, 40, 0),
(64, 'Mini Bags', '500.00', 'vvgvj', '133a.jpg', '133b.jpg', '', 8, 46, 0),
(65, 'Mini Bags', '545.00', '', '135a.jpg', '135b.jpg', '', 8, 45, 0),
(66, 'Mini Bags', '600.00', '', '134a.jpg', '134b.jpg', '', 8, 30, 0),
(67, 'Mini Bags', '600.00', '', '136a.jpg', '136b.jpg', '', 8, 25, 0),
(68, 'Mini Bags', '450.00', '', '104a.jpg', '', '', 8, 60, 0),
(69, 'Mini Bags', '600.00', '', '108a.jpg', '107c.jpg', '107d.jpg', 8, 19, 0),
(70, 'Sling Bags', '600.00', '', '139a.jpg', '139b.jpg', '', 4, 30, 0),
(71, 'Sling Bags', '700.00', '', '138a.jpg', '138b.jpg', '', 4, 52, 0),
(72, 'Sling Bags', '650.00', '', '140a.jpg', '', '', 4, 29, 0),
(73, 'Wallets & Pouches', '300.00', '', '144a.jpg', '144b.jpg', '144c.jpg', 7, 45, 0),
(74, 'Wallets & Pouches', '400.00', '', '143a.jpg', '', '', 7, 9, 0),
(75, 'Wallets & Pouches', '500.00', '', '145a.jpg', '', '', 7, 50, 0),
(76, 'Wallets & Pouches', '500.00', '', '143a.jpg', '', '', 7, 20, 1),
(77, 'Wallets & Pouches', '600.00', '', '142a.jpg', '142b.jpg', '142c.jpg', 7, 20, 1),
(78, 'Wallets & Pouches', '600.00', '', '141a.jpg', '141b.jpg', '', 7, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `country` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `code` varchar(6) NOT NULL,
  `profile_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `email`, `password`, `phone_no`, `country`, `state`, `city`, `code`, `profile_img`) VALUES
(1, 'darpana chauhan', 'd@gmail.com', 'Darpana@123', '9376456846', 'india', 'gujarat', 'amreli', '365440', 'profile_img/usr_685fc568818e3.png'),
(2, 'jiya patel', 'j@gmail.com', 'Jiya@123', '9376478346', 'india', 'gujarat', 'surat', '365440', 'profile_img/usr_685fc5aeac55e.png'),
(3, 'trushi babariya', 't@gmail.com', 'Trushali@123', '9873498696', 'india', 'gujarat', 'amreli', '365440', 'profile_img/usr_685fc79bb5bf1.png'),
(4, 'krisha shah', 'k@gmailcom', 'Krisha@1234', '3640875378', 'india', 'gujarat', 'baroda', '782630', 'profile_img/usr_686945f60691d.png'),
(5, 'dharmi patel', 'dharmi@gmail.com', 'Dharmi@123', '9650946509', 'india', 'gujarat', 'amreli', '879465', 'profile_img/usr_6869517c82f4f.png'),
(6, 'nensi dobariya', 'n@gmail.com', 'Nensi@123', '9634092653', 'india', 'gujarat', 'surat', '786347', 'profile_img/usr_686cd2f68cf8d.jpg'),
(7, 'babariya dhruti', 'd@gmail.com', 'Dhruti@123', '3764985940', 'india', 'gujarat', 'junagadh', '746785', 'profile_img/usr_6873c5a13fa5d.jpg'),
(8, 'khayati maru', 'k@gmail.com', 'Khyati@123', '7486375835', 'india', 'gujarat', 'baroda', '459343', 'profile_img/usr_687517047c010.png'),
(9, 'tanvi bhayani', 't@gmail.com', 'Tanvi@123', '7386548745', 'india', 'gujarat', 'junagadh', '387647', 'profile_img/usr_6875189ac6035.png'),
(10, 'riya chauhan', 'riya@gmail.com', 'Riya@098', '8394680597', 'india', 'gujarat', 'surat', '387647', 'profile_img/usr_68751c00aedb2.png'),
(11, 'aarya satashiya', 'aarya@gmail.com', 'Aarya@123', '9946094574', '1', '7', '63', '365440', 'profile_img/usr_68b6c76e782b9.png'),
(12, 'galani vanshi', 'vanshi@gmail.com', 'Vanshi@123', '8745897456', '1', '7', '48', '745676', 'profile_img/usr_68c1591053b07.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `country_id`, `name`) VALUES
(1, 1, 'Andhra Pradesh'),
(2, 1, 'Arunachal Pradesh'),
(3, 1, 'Assam'),
(4, 1, 'Bihar'),
(5, 1, 'Chhattisgarh'),
(6, 1, 'Goa'),
(7, 1, 'Gujarat'),
(8, 1, 'Haryana'),
(9, 1, 'Himachal Pradesh'),
(10, 1, 'Jharkhand'),
(11, 1, 'Karnataka'),
(12, 1, 'Kerala'),
(13, 1, 'Madhya Pradesh'),
(14, 1, 'Maharashtra'),
(15, 1, 'Manipur'),
(16, 1, 'Meghalaya'),
(17, 1, 'Mizoram'),
(18, 1, 'Nagaland'),
(19, 1, 'Odisha'),
(20, 1, 'Punjab'),
(21, 1, 'Rajasthan'),
(22, 1, 'Sikkim'),
(23, 1, 'Tamil Nadu'),
(24, 1, 'Telangana'),
(25, 1, 'Tripura'),
(26, 1, 'Uttar Pradesh'),
(27, 1, 'Uttarakhand'),
(28, 1, 'West Bengal'),
(29, 1, 'Andaman and Nicobar Islands'),
(30, 1, 'Chandigarh'),
(31, 1, 'Dadra and Nagar Haveli and Daman and Diu'),
(32, 1, 'Delhi'),
(33, 1, 'Jammu and Kashmir'),
(34, 1, 'Ladakh'),
(35, 1, 'Lakshadweep'),
(36, 1, 'Puducherry'),
(37, 2, 'California'),
(38, 2, 'Texas'),
(39, 2, 'Florida'),
(40, 2, 'New York'),
(41, 2, 'Illinois'),
(42, 2, 'Pennsylvania'),
(43, 2, 'Ohio'),
(44, 2, 'Georgia'),
(45, 2, 'North Carolina'),
(46, 2, 'Michigan'),
(47, 3, 'England'),
(48, 3, 'Scotland'),
(49, 3, 'Wales'),
(50, 3, 'Northern Ireland'),
(51, 4, 'Ontario'),
(52, 4, 'Quebec'),
(53, 4, 'British Columbia'),
(54, 4, 'Alberta'),
(55, 4, 'Manitoba'),
(56, 4, 'Saskatchewan'),
(57, 4, 'Nova Scotia'),
(58, 4, 'New Brunswick'),
(59, 4, 'Prince Edward Island'),
(60, 4, 'Newfoundland and Labrador'),
(61, 5, 'New South Wales'),
(62, 5, 'Victoria'),
(63, 5, 'Queensland'),
(64, 5, 'Western Australia'),
(65, 5, 'South Australia'),
(66, 5, 'Tasmania'),
(67, 5, 'Australian Capital Territory'),
(68, 5, 'Northern Territory');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(3, 3, 78, '2025-07-07 11:38:33'),
(99, 6, 77, '2025-07-08 15:08:44'),
(102, 6, 78, '2025-07-08 15:12:50'),
(133, 6, 68, '2025-07-08 15:39:23'),
(134, 6, 64, '2025-07-08 15:39:25'),
(142, 6, 69, '2025-07-08 15:49:50'),
(143, 6, 67, '2025-07-08 15:50:49'),
(144, 6, 63, '2025-07-08 15:50:55'),
(150, 6, 73, '2025-07-08 15:59:28'),
(167, 6, 76, '2025-07-08 16:15:36'),
(169, 6, 75, '2025-07-08 16:18:16'),
(170, 6, 72, '2025-07-08 17:19:39'),
(172, 3, 74, '2025-07-08 17:21:00'),
(182, 7, 72, '2025-07-13 14:43:14'),
(186, 3, 69, '2025-07-13 15:21:17'),
(199, 3, 75, '2025-07-13 15:26:45'),
(210, 10, 76, '2025-07-14 15:02:44'),
(211, 10, 75, '2025-07-14 15:02:46'),
(214, 10, 77, '2025-07-14 15:04:09'),
(217, 6, 71, '2025-07-14 15:26:50'),
(218, 6, 74, '2025-07-14 15:26:56'),
(220, 1, 74, '2025-08-10 05:36:01'),
(221, 1, 63, '2025-08-15 12:09:15'),
(222, 1, 64, '2025-08-15 12:09:22'),
(223, 1, 61, '2025-09-07 07:51:34'),
(225, 1, 60, '2025-09-07 07:51:39'),
(226, 1, 59, '2025-09-07 07:51:41'),
(229, 1, 71, '2025-09-07 07:51:56'),
(253, 1, 49, '2025-09-07 08:12:35'),
(257, 1, 68, '2025-09-07 08:20:57'),
(259, 1, 69, '2025-09-07 08:21:05'),
(261, 1, 67, '2025-09-07 08:35:50'),
(270, 1, 72, '2025-09-10 09:10:39'),
(281, 1, 73, '2025-09-10 09:11:15'),
(293, 1, 78, '2025-09-10 09:14:44'),
(294, 12, 61, '2025-09-10 10:55:33'),
(295, 12, 60, '2025-09-10 10:55:36'),
(297, 3, 71, '2025-09-12 11:12:36'),
(298, 1, 76, '2025-09-13 09:19:52'),
(301, 1, 75, '2025-09-16 07:51:03'),
(302, 1, 77, '2025-09-16 07:51:08'),
(303, 3, 77, '2025-09-16 07:57:57'),
(304, 3, 76, '2025-09-16 07:58:06'),
(305, 3, 72, '2025-09-16 10:22:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
