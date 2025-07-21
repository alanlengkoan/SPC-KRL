-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 12:09 PM
-- Server version: 5.7.25
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_spc_krl`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_classification`
--

CREATE TABLE `tb_classification` (
  `id_classification` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_classification`
--

INSERT INTO `tb_classification` (`id_classification`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Kelas 1', 'merah hati,ungu,hijau tua,besar,gemuk,bersih', '2024-03-21 16:21:29', '2024-04-29 06:52:24'),
(2, 'Kelas 2', 'merah,hitam,hijau,kecil,pendek,berlumut', '2024-03-21 16:21:51', '2024-04-29 06:51:55'),
(3, 'Kelas 3', 'putih pucat,pendek,mudah patah,hancur,kotor', '2024-03-21 16:22:23', '2024-04-29 06:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `tb_consultation`
--

CREATE TABLE `tb_consultation` (
  `id_consultation` int(11) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_classification` int(11) DEFAULT NULL,
  `image` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_consultation`
--

INSERT INTO `tb_consultation` (`id_consultation`, `id_users`, `id_classification`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'e4f1daf05f523adc32928bf579d65c45.jpg', '2024-11-11 12:02:10', '2024-11-11 12:02:10'),
(2, 1, 2, '1dbe4dbe8ef856e9dd7cfcf1fdf74274.jpg', '2024-11-11 12:10:15', '2024-11-11 12:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_datatraining`
--

CREATE TABLE `tb_datatraining` (
  `id_datatraining` int(11) NOT NULL,
  `id_classification` int(11) NOT NULL,
  `image` text,
  `contrast` double DEFAULT NULL,
  `correlation` double DEFAULT NULL,
  `energy` double DEFAULT NULL,
  `homogeneity` double DEFAULT NULL,
  `r` double DEFAULT NULL,
  `g` double DEFAULT NULL,
  `b` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_datatraining`
--

INSERT INTO `tb_datatraining` (`id_datatraining`, `id_classification`, `image`, `contrast`, `correlation`, `energy`, `homogeneity`, `r`, `g`, `b`, `created_at`, `updated_at`) VALUES
(1, 3, '6e0a1d8c0cf4d93d57b32b0eda28957c.jpg', 122160643, 1, 29016160954732, 11847436.07207, 169, 168, 168, '2024-11-11 12:08:49', '2024-11-11 12:08:49'),
(2, 2, '058f6c03a51130b0f48d28b69c84df9f.jpg', 120353307, 1, 15642293272928, 11847761.330354, 151, 151, 151, '2024-11-11 12:09:42', '2024-11-11 12:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` enum('admin','users') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ins` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `id_users`, `nama`, `email`, `foto`, `username`, `password`, `roles`, `ins`, `upd`) VALUES
(1, 1, 'sitti lailatul tansila', 'lailatultansila@gmail.com', '11ef68675e93b9624c36b3dedaa2c24e.jpg', 'admin', '$2y$10$UrvEbnhpVkCREvEz1WjUAu5EUEdbeTjFtQE0faPjufKxl68AtJmsi', 'admin', '2021-07-22 01:56:34', '2024-05-08 13:46:30'),
(5, 30385941, 'budi', 'budi@gmail.com', NULL, 'budi', '$2y$10$k9O.QzgDuebFeXcrN5Gpj.3bIl5dbcePVg/vE/dUa8OgtaYgH37EG', 'users', '2024-04-28 07:13:44', '2024-04-28 07:13:44'),
(6, 59640713, 'Zeka', 'zeka@gmail.com', NULL, 'Zeka', '$2y$10$Ts/Qqj6ogSgjHr.tDrhSseRgp3zI/QHmSq67ryaWNo.0KvM2IMjXu', 'users', '2024-04-28 07:47:55', '2024-04-28 07:47:55'),
(7, 31302957, 'laila', 'lailatultansila@gmail.com', NULL, 'laila', '$2y$10$Zcq806OKKtjDXNfBNlKTx.bN0c46J8cVMOxuL1yDzeYDT.6alveZS', 'users', '2024-04-28 21:19:51', '2024-04-28 21:19:51'),
(9, 36129857, 'uli', 'uli@gmail.com', NULL, 'uli', '$2y$10$ofnofq9RSsO52zzaqHnEQuG76tJr7yZ6SGRDlZQ9NOfJ0gSgS3K9u', 'users', '2024-04-28 21:20:14', '2024-04-28 21:20:14'),
(10, 84781956, 'Maulana', 'maulana@gmail.com', NULL, 'Maulana', '$2y$10$0vJ8tmc2S6sUYIX67Ec03uu8inSFa1GlE63TM5PuTu9uJbXJpAULy', 'users', '2024-04-29 06:58:50', '2024-04-29 06:58:50'),
(11, 85374296, 'alan', 'alan@gmail.com', NULL, 'alan', '$2y$10$bmXFnMo5rO9SbEpws0411.nfmC6fbooUDx6xWKn34UvcM3TtVqhWa', 'users', '2024-05-06 02:53:25', '2024-05-06 02:53:25'),
(12, 78743290, 'lala', 'lala@gmail.com', NULL, 'lala', '$2y$10$BbwZ4dKTH5vJCh6D1H3.MO9kCMCLaeBr.EbsMypqcZTo6oxc9biR2', 'users', '2024-05-07 18:44:50', '2024-05-07 18:44:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_classification`
--
ALTER TABLE `tb_classification`
  ADD PRIMARY KEY (`id_classification`);

--
-- Indexes for table `tb_consultation`
--
ALTER TABLE `tb_consultation`
  ADD PRIMARY KEY (`id_consultation`),
  ADD KEY `c_to_u` (`id_users`),
  ADD KEY `c_to_cla` (`id_classification`);

--
-- Indexes for table `tb_datatraining`
--
ALTER TABLE `tb_datatraining`
  ADD PRIMARY KEY (`id_datatraining`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649FA06E4D9` (`id_users`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_classification`
--
ALTER TABLE `tb_classification`
  MODIFY `id_classification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_consultation`
--
ALTER TABLE `tb_consultation`
  MODIFY `id_consultation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_datatraining`
--
ALTER TABLE `tb_datatraining`
  MODIFY `id_datatraining` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_consultation`
--
ALTER TABLE `tb_consultation`
  ADD CONSTRAINT `c_to_cla` FOREIGN KEY (`id_classification`) REFERENCES `tb_classification` (`id_classification`) ON DELETE CASCADE,
  ADD CONSTRAINT `c_to_u` FOREIGN KEY (`id_users`) REFERENCES `tb_users` (`id_users`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
