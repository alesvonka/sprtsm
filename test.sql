-- Adminer 4.8.1 MySQL 5.5.5-10.6.5-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `test`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID záznamu',
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Název značky',
  `update_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Datum změny/vytvoření',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `brand` (`id`, `name`, `update_datetime`) VALUES
(1,	'Adidas',	'2022-09-17 15:22:43'),
(2,	'Nike',	'2022-09-17 15:22:47'),
(3,	'Rebook',	'2022-09-17 15:22:53'),
(4,	'Vans',	'2022-09-17 15:22:59'),
(5,	'Prestige',	'2022-09-17 15:23:30'),
(6,	'Umbro',	'2022-09-17 15:23:40'),
(7,	'Mark & Spencer',	'2022-09-17 15:24:03'),
(8,	'H&M',	'2022-09-17 15:24:15'),
(9,	'CCC',	'2022-09-17 15:24:28'),
(10,	'ASUS',	'2022-09-17 15:24:39'),
(11,	'Lenovo',	'2022-09-17 15:24:43'),
(12,	'Apple',	'2022-09-17 15:24:48'),
(13,	'Compage',	'2022-09-17 15:25:15'),
(14,	'Zanussi',	'2022-09-17 15:25:24'),
(15,	'Tefal',	'2022-09-17 15:25:28'),
(16,	'Xiaomi',	'2022-09-17 15:25:41'),
(17,	'Samsung',	'2022-09-17 15:25:54'),
(18,	'Huawei',	'2022-09-17 15:26:01'),
(19,	'Oppo',	'2022-09-17 15:26:08'),
(20,	'Indesit',	'2022-09-17 15:26:22'),
(21,	'Romo',	'2022-09-17 15:26:27'),
(22,	'Sharp',	'2022-09-17 15:26:32'),
(23,	'JVC',	'2022-09-17 15:26:36'),
(24,	'LG',	'2022-09-17 15:26:42'),
(25,	'Logitech',	'2022-09-17 15:27:18'),
(26,	'Concept',	'2022-09-17 15:27:27'),
(27,	'Nokia',	'2022-09-17 15:27:33'),
(28,	'Ericsson',	'2022-09-17 15:27:39'),
(29,	'Alcatel',	'2022-09-17 15:27:43'),
(30,	'Sony',	'2022-09-17 15:27:55');

-- 2022-09-17 15:29:13
