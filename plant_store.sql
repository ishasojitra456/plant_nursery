-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 06:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plant_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `profile`) VALUES
('SC1ILHZWbDUTNQrImXun', 'mansi', 'manusojitra@234gmail.com', '$2y$10$oJE04acv6BYFbLUbP.I/Vui1Ee/47Tf5C7iUK27DAtw', 'mansi 3.jpg'),
('6DINCrTmMorIbx2vyVZP', 'sojitra pruthvi', 'pruthvisojitra358@gmail.com', '$2y$10$LDd8bCPrJU.YZ0W3VhzSROPS47CIfYnw4boDINIYRw/', '0.jpg'),
('SCsDS1AV3V1lh8bEBbgj', 'yukta', 'ishasojitrabca22142@gmail.com', '$2y$10$9Kpuxe1ha3W8X/LZ4vsomuxt8iAJSz2yIV4akI1U0.i', '01.jpg'),
('S4LhAVyeRB3tYsJccydT', 'isha', 'isha234@gmail.com', '$2y$10$gGEt/dkcCMpq7Dn3b8u8ze.kvzASQzuxhsfX35WB2zO', '02.jpg'),
('AuUCIfUnH7QKAyXxYu9c', 'vanshil', 'khuhshj@gmail.com', '$2y$10$jsyZfR7gzw4GREucFWyb5el6J1uGGyOzVPbVWmbZ.X7', '01.jpg'),
('7Z6wPK6xoVmvz5shkuGr', 'vanshil', 'cvsdvnb@gmail.com', '$2y$10$4sjDBva9DGal4breHdztvuDttWJKF.4bI9FTs2xRfQQ', '01.jpg'),
('NY3FA3GM0PudKm05pTS7', 'prince', 'p@gmail.com', '$2y$10$mslmoIVwFZnH5fBJOwXqmeEs190Qmf81d2PTPFQFAj0', '01.jpg'),
('99d6AQpe9rcNvck7pmZJ', 'kris', 'kris@gmail.com', '$2y$10$NtjfwHQrDfH4F4qGxHox9.IYS5W6grK2o08/CmN1sIo', '02.jpg'),
('6eM1AahpOcr6eKs5Mvon', 'isha', 'isha123@gmail.com', 'e3cc845ebc6144fc4d71cf5f07a0ce9db6fdfa91', 'pc1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
('66ecec608fc6d6.62241', '', 'zye0IYY3A8WTvGvbiNNj', 126, 1),
('66ecff79855ee7.57532', '', 'iNSgPxnFXozVHZ6OQ54l', 4563, 1),
('66f59e57d579d8.41560', '66f5952ec5f0e', '5HRP4H2RWwnWrglLdbQj', 3543, 1),
('66f64ce7531910.27239', '66f63bbd049a1', 'iNSgPxnFXozVHZ6OQ54l', 4563, 2),
('66f64cea7c14c9.52818', '66f63bbd049a1', '5HRP4H2RWwnWrglLdbQj', 3543, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
('', '', 'ARESTYFYUGU', 'krish@gmail.com', '', 'SRDTFYGUIO[;LKJHGFDS');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address _type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` varchar(2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `address_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address _type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`, `address_type`) VALUES
('66f598e449611', '66f5952ec5f0e', 'nirali', 2147483647, 'lakhaniyukta7@gmail.com', 'kargil, varacha, surat, india, 395010', '', 'cash on delivery', 'iNSgPxnFXozVHZ6OQ54l', 4563, '1', '0000-00-00', '', 'pending', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_detail`, `status`) VALUES
('iNSgPxnFXozVHZ6OQ54l', 'ddfghj', 4563, 'hibiscus.webp', 'refjhkjhgdsfafghjk', 'deactive'),
('5HRP4H2RWwnWrglLdbQj', 'easr', 3543, 'marigold.webp', 'asfdghjklhgfds', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(100) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
('66f63bbd049a1', 'krish', 'krish@gmail.com', 'krish', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('66eaabf465a0f9.10562', '', 'Ativo6Xu6RHT4gVUSmP1', 0),
('66f59ed0224845.35501', '66f5952ec5f0e', 'iNSgPxnFXozVHZ6OQ54l', 4563);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
