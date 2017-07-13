-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13 Iul 2017 la 11:43
-- Versiune server: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvcadrian`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Salvarea datelor din tabel `category`
--

INSERT INTO `category` (`id`, `name`, `modified`, `created`) VALUES
(7, 'Personal Computer', '2017-07-12 14:41:12', '2017-07-09 23:02:30'),
(8, 'Headphones', '0000-00-00 00:00:00', '2017-07-09 23:02:51'),
(9, 'Mobile', '0000-00-00 00:00:00', '2017-07-09 23:03:08');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `quantity_type`, `image`, `modified`, `created`) VALUES
(7, 'Asus Gaming Laptop', 50, 'Personal Computer', 'Personal_Computer_7_Asus.jpg', '2017-07-13 00:51:24', '2017-07-09 19:54:59'),
(8, 'Roccat Kulo Headphone', 100, 'Headphones', 'Headphones_8_Roccat.jpg', '2017-07-13 00:51:18', '2017-07-09 19:55:17'),
(9, 'Arctic Silver 5 thermal conductor', 100, 'Mobile', 'Mobile_9_Arctic.jpg', '2017-07-13 00:49:33', '2017-07-09 19:56:01'),
(27, 'The joke', 69, 'Mobile', 'Mobile_27_the_joke.jpg', '2017-07-13 00:51:37', '2017-07-12 21:33:45');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `modified`, `created`) VALUES
(1, 'onterra', '815692191ed392a41f244a662b53ffbb', 'marica.adrian@yahoo.com', 'Marica Adrian', '2017-07-09 03:04:26', '2017-07-09 00:03:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
