-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 06:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptop'),
(2, 'Phones'),
(3, 'Watches');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `username` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Contact_info` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `re_password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`username`, `id`, `f_name`, `l_name`, `email`, `Address`, `Contact_info`, `password`, `re_password`, `type`, `Date`) VALUES
('Admin', 41, 'Abdelrahman', 'Karam', 'Admin66@gmail.com', 'set', '01124800767', '$2y$10$.soryR9w4hotQdD7mW2vruI7dXCgX08PrXzcc9MBUE2ycUekjFqC2', '$2y$10$98n4txrk8YWKVkOxxXphV.O5ITZl5etfulvH3l/vvREBC2Xu6hAA.', 1, '2023-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_for_user` int(11) NOT NULL,
  `id_for_product` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `order_state` int(11) NOT NULL DEFAULT 0 COMMENT 'Pending=0 , Confermed=1 , Completed=2',
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `received_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_for_user`, `id_for_product`, `Quantity`, `order_state`, `order_date`, `received_date`) VALUES
(332, 41, 5, 1, 2, '2024-01-25', '2024-01-25'),
(333, 41, 6, 1, 2, '2024-01-25', '2024-01-25'),
(336, 41, 12, 1, 2, '2024-01-25', '2024-01-25'),
(337, 41, 7, 1, 2, '2024-01-25', '2024-01-25'),
(341, 41, 5, 1, 2, '2024-01-25', '2024-01-25'),
(342, 41, 6, 1, 2, '2024-01-25', '2024-01-25'),
(343, 41, 7, 1, 2, '2024-01-25', '2024-01-25'),
(344, 41, 5, 1, 1, '2024-01-25', NULL),
(345, 41, 6, 1, 1, '2024-01-25', NULL),
(346, 41, 5, 1, 1, '2024-01-25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `image`, `category`) VALUES
(5, 'Laptop', '[description place]', '$400', '916_154_1.jpg', 1),
(6, 'DELL LAPTOP', '[description place]', '$359', '681_HP Probook 650g2.webp', 1),
(7, 'DELL', '[description place]', '$320', '420_Dell Inspiron 17.webp', 1),
(8, 'LAPTOP', '[description place]', '$354', '466_laptops.jpg', 1),
(9, 'HP LAPTOP', '[description place]', '$399', '107_download.jpg', 1),
(10, 'HP Notebook-15', '[description place]', '$526', '596_HP-Notebook-15.webp', 1),
(11, 'Samsoung Galaxy', '[description place]', '$143', '215_71Y06Do6hxL._AC_SX679_.jpg', 2),
(12, 'Sasoung', '[description place]', '$120', '832_61mOx8va+LL._AC_SX679_.jpg', 2),
(13, 'Readmi', '[description place]', '$200', '911_51JXERYpvHL._AC_SX679_.jpg', 2),
(14, 'Vevo', '[description place]', '$170', '912_51USF-7Z-xL._AC_SX425_.jpg', 2),
(15, 'Oppo A16', '[description place]', '$160', '629_61uwPrEh7bL._AC_SX425_.jpg', 2),
(23, 'Black Watche', 'This any description..', '$25', '573_187_702_watch3.jpg', 3),
(24, 'Classic Watche', 'Description....', '$30', '616_2_watch1.png', 3),
(25, 'Watche', 'Description...', '$22', '583_568_watch1.jpg', 3),
(26, 'Watche', 'Description...', '$26', '86_90_watch2.jpg', 3),
(27, 'Watche', 'Description....', '$29', '182_89_watch4.jpg', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `order_id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_cons` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category_cons` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
