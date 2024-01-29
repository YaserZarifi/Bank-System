-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 29, 2024 at 01:14 AM
-- Server version: 8.2.0
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `card_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `iban` varchar(22) NOT NULL,
  `balance` decimal(30,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `iban` (`iban`),
  UNIQUE KEY `card_number` (`card_number`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `card_number`, `iban`, `balance`) VALUES
(4, 4, '40000000000003311', 'IBAN3226432736', '120040.00'),
(5, 5, '40000000000004688', 'IBAN8050150468', '53148964.00'),
(19, 6, '40000000000008904', 'IBAN3388665354', '60532426.00'),
(20, 7, '40000000000001662', 'IBAN6549803616', '6474473.00'),
(21, 7, '40000000000002798', 'IBAN8302835608', '9974473.00'),
(22, 5, '40000000000006851', 'IBAN1147040689', '2499961.00'),
(23, 5, '40000000000002169', 'IBAN3822794403', '100002.00'),
(24, 4, '40000000000004338', 'IBAN2638189447', '99999995.00');

-- --------------------------------------------------------

--
-- Table structure for table `daily_transfers`
--

DROP TABLE IF EXISTS `daily_transfers`;
CREATE TABLE IF NOT EXISTS `daily_transfers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_card_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `receiver_card_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transfer_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_transfers`
--

INSERT INTO `daily_transfers` (`id`, `sender_card_no`, `receiver_card_no`, `amount`, `transfer_date`) VALUES
(1, 'Omid', '40000000000005870', '200500.00', '2024-01-28'),
(2, 'Omid', '40000000000005870', '555552.00', '2024-01-28'),
(5, 'Omid', '40000000000005870', '200000.00', '2024-01-28'),
(6, 'Omid', '40000000000005870', '22.00', '2024-01-28'),
(7, 'Omid', '40000000000005870', '23.00', '2024-01-28'),
(8, 'Omid', '40000000000005870', '212.00', '2024-01-28'),
(9, 'Omid', '40000000000005870', '25.00', '2024-01-28'),
(10, 'Omid', '40000000000005870', '20.00', '2024-01-28'),
(11, 'Omid', '40000000000005870', '35.00', '2024-01-28'),
(12, 'Omid', '40000000000004688', '200000.00', '2024-01-28'),
(13, 'Omid', '40000000000005870', '200000.00', '2024-01-28'),
(14, 'Omid', '40000000000004688', '10.00', '2024-01-28'),
(15, 'Omid', '40000000000005870', '20.00', '2024-01-28'),
(16, 'Omid', '40000000000004688', '200000.00', '2024-01-28'),
(17, 'Omid', '40000000000005870', '200000.00', '2024-01-28'),
(18, 'Omid', '40000000000005870', '11.00', '2024-01-28'),
(19, 'Omid', '40000000000005870', '25.00', '2024-01-28'),
(20, 'Omid', '40000000000003311', '27.00', '2024-01-28'),
(21, 'Omid', '40000000000004688', '25.00', '2024-01-28'),
(22, 'Omid', '40000000000005870', '25656.00', '2024-01-28'),
(23, 'Omid', '40000000000005870', '7.00', '2024-01-28'),
(24, 'Omid', '40000000000003311', '3.00', '2024-01-28'),
(26, 'Omid', '40000000000003311', '200000.00', '2024-01-28'),
(27, 'Omid', '', '65.00', '2024-01-28'),
(28, 'Omid', '', '32.00', '2024-01-28'),
(29, 'Omid', '40000000000005870', '23.00', '2024-01-28'),
(30, 'Omid', '40000000000003311', '32.00', '2024-01-28'),
(31, 'Omid', '40000000000005870', '24343.00', '2024-01-28'),
(32, 'Omid', '40000000000005870', '323.00', '2024-01-28'),
(33, 'Omid', '40000000000005870', '232.00', '2024-01-28'),
(34, 'Omid', '40000000000005870', '2000000.00', '2024-01-28'),
(35, 'Omid', '40000000000005870', '23.00', '2024-01-28'),
(36, 'Omid', '40000000000005870', '2.00', '2024-01-28'),
(37, 'Omid', '', '433.00', '2024-01-28'),
(38, 'Omid', '', '3434.00', '2024-01-28'),
(39, 'Omid', '', '224.00', '2024-01-28'),
(40, 'Omid', '', '21.00', '2024-01-28'),
(41, 'Omid', '', '21.00', '2024-01-28'),
(42, 'Omid', '', '54.00', '2024-01-28'),
(43, 'Omid', 'IBAN3226432736', '2.00', '2024-01-28'),
(44, 'Omid', 'IBAN3226432736', '1.00', '2024-01-28'),
(45, 'Omid', 'IBAN3226432736', '100000.00', '2024-01-28'),
(46, 'Omid', '40000000000007645', '2.00', '2024-01-28'),
(47, 'Omid', '40000000000007645', '2.00', '2024-01-28'),
(48, 'Omid', 'IBAN3226432736', '43.00', '2024-01-28'),
(49, 'Omid', 'IBAN3258076975', '2.00', '2024-01-28'),
(50, 'Omid', 'IBAN3226432736', '2.00', '2024-01-28'),
(51, 'Omid', 'IBAN3226432736', '21.00', '2024-01-28'),
(52, 'Omid', 'IBAN3226432736', '23.00', '2024-01-28'),
(53, 'Omid', '40000000000005870', '22.00', '2024-01-28'),
(54, 'Omid', 'IBAN3258076975', '43.00', '2024-01-28'),
(55, 'Omid', 'IBAN3226432736', '2.00', '2024-01-28'),
(56, 'Omid', 'IBAN3226432736', '11.00', '2024-01-28'),
(57, 'Omid', '40000000000005870', '2.00', '2024-01-28'),
(58, 'Shaker.Shamsi', 'IBAN3226432736', '4900000.00', '2024-01-28'),
(59, 'Shaker.Shamsi', 'IBAN3226432736', '2.00', '2024-01-28'),
(60, 'Shaker.Shamsi', 'IBAN3226432736', '2.00', '2024-01-28'),
(61, 'Shaker.Shamsi', 'IBAN3226432736', '2.00', '2024-01-28'),
(62, 'mahdi.mohammadi', 'IBAN3226432736', '2.00', '2024-01-28'),
(63, 'Omid', 'IBAN8050150468', '2.00', '2024-01-29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `source_account` varchar(50) DEFAULT NULL,
  `destination_account` varchar(50) DEFAULT NULL,
  `amount` decimal(50,2) NOT NULL,
  `transaction_type` varchar(20) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tracking_code` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'SUCCESS',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tracking_code` (`tracking_code`),
  KEY `source_account` (`source_account`),
  KEY `destination_account` (`destination_account`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `source_account`, `destination_account`, `amount`, `transaction_type`, `timestamp`, `tracking_code`, `status`) VALUES
(4, 'IBAN8050150468', 'IBAN3226432736', '11.00', 'Paya', '2024-01-28 01:01:39', 'TR-1706403699--752a39d7', 'SUCCESS'),
(5, '40000000000004688', '40000000000005870', '2.00', 'Card to Card', '2024-01-28 01:02:00', 'TR-1706403720--1a21174b', 'SUCCESS'),
(7, '40000000000008904', '40000000000003311', '2.00', 'Card to Card', '2024-01-28 01:46:56', 'TR-1706406416--79530310', 'SUCCESS'),
(8, 'IBAN3388665354', 'IBAN3226432736', '2.00', 'Paya', '2024-01-28 01:47:20', 'TR-1706406440--27a725ac', 'SUCCESS'),
(9, 'IBAN3388665354', 'IBAN3226432736', '2.00', 'Paya', '2024-01-28 01:49:15', 'TR-1706406555--19c1ef5a', 'SUCCESS'),
(10, 'IBAN3388665354', 'IBAN3226432736', '2.00', 'Satna', '2024-01-28 01:49:39', 'TR-1706406579--7eb88e52', 'SUCCESS'),
(12, 'IBAN6549803616', 'IBAN3226432736', '2.00', 'Satna', '2024-01-28 17:01:47', 'TR-1706461307--fe5bd1d6', 'SUCCESS'),
(13, '40000000000004688', '40000000000003311', '35.00', 'Card to Card', '2024-01-28 22:47:26', 'TR-1706482046--462b1b89', 'SUCCESS'),
(14, 'IBAN8050150468', 'IBAN8050150468', '2.00', 'Paya', '2024-01-28 22:49:25', 'TR-1706482165--665117b6', 'SUCCESS'),
(15, '40000000000004688', '40000000000003311', '2.00', 'Card to Card', '2024-01-28 23:15:24', 'TR-1706483724-Omid-8c1ccffd', 'SUCCESS'),
(16, '40000000000003311', '400000000000076454343', '1233.00', 'Card to Card', '2024-01-29 01:01:53', 'TR-1706490113-de2bd1c9', 'FAILED'),
(17, '40000000000003311', '40000000000004688', '1.00', 'Card to Card', '2024-01-29 01:02:35', 'TR-1706490155-be83ef42', 'SUCCESS'),
(18, '40000000000003311', '40000000000004688', '321424234234.00', 'Card to Card', '2024-01-29 01:06:18', 'TR-1706490378-08d82b6d', 'FAILED'),
(19, 'IBAN3226432736', 'IBAN3822794403', '324567865434567865.00', 'Paya', '2024-01-29 01:09:38', 'TR-1706490578-726e3a64', 'FAILED'),
(20, 'IBAN3226432736', 'IBAN38227944033', '200000.00', 'Paya', '2024-01-29 01:10:03', 'TR-1706490603-744c099f', 'FAILED'),
(21, 'IBAN3226432736', 'IBAN3822794403', '2.00', 'Paya', '2024-01-29 01:10:18', 'TR-1706490618-7dce2b92', 'SUCCESS'),
(22, 'IBAN3226432736', 'IBAN3226432736wre43', '34.00', 'Satna', '2024-01-29 01:12:22', 'TR-1706490742-da39a3d1', 'FAILED'),
(23, 'IBAN3226432736', 'IBAN3822794403', '465346534653465346536.00', 'Paya', '2024-01-29 01:12:37', 'TR-1706490757-d6f3ad72', 'FAILED'),
(24, 'IBAN3226432736', 'IBAN8050150468', '2.00', 'Satna', '2024-01-29 01:12:48', 'TR-1706490768-65235759', 'SUCCESS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `n_ID` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `username`, `password`, `n_ID`) VALUES
(4, 'YASER', 'Zarifi', 'yzarifi', '$2y$10$14ud4t0MO4eDahjLZGib0e1Auu3In372e.Ncf0bUrJh5UsfgaAfey', '1234567890'),
(5, 'Omid', 'Yaqubi', 'Omid', '$2y$10$1K7UAE.umJbF7B4z6wy8gOcWCmze2nx1hIe84/5G5yHsi/WkGiJGK', '847393'),
(6, 'Shaker', 'Shamsi', 'Shaker.Shamsi', '$2y$10$Ck/yEghMHV7eLOasZUvB6.TDF3GBS95bXWwZfukdsPSlp9jPiWQRa', '1236548987'),
(7, 'Mahdi', 'Mohammadi', 'mahdi.mohammadi', '$2y$10$NKIdbBoMKmY.opZZzurP0.9U/KGbtoHMKWuGTWKYoQXaUo42BKjA2', '9878584');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
