-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 20, 2022 at 05:51 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbr`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_hasil`
--

CREATE TABLE `data_hasil` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenis_kelamin` int(1) DEFAULT NULL,
  `umur` float DEFAULT NULL,
  `hipertensi` int(1) DEFAULT NULL,
  `penyakit_jantung` int(1) DEFAULT NULL,
  `status_pernikahan` int(1) DEFAULT NULL,
  `jenis_pekerjaan` float DEFAULT NULL,
  `tempat_tinggal` int(1) DEFAULT NULL,
  `glukosa` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `status_merokok` float DEFAULT NULL,
  `stroke` int(1) DEFAULT NULL,
  `similaritas` float DEFAULT NULL,
  `similar_dengan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_hasil`
--

INSERT INTO `data_hasil` (`id`, `nama`, `jenis_kelamin`, `umur`, `hipertensi`, `penyakit_jantung`, `status_pernikahan`, `jenis_pekerjaan`, `tempat_tinggal`, `glukosa`, `bmi`, `status_merokok`, `stroke`, `similaritas`, `similar_dengan`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, 1, 0.333333, 1, 1, 1, 0.25, 1, 1, 1, 1, NULL, NULL, NULL),
(3, 'jug', 1, 0.333333, 1, 1, 1, 0.25, 1, 1, 1, 1, NULL, NULL, NULL),
(4, 'a', 0, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 0.736477, 152),
(5, 'jargon', 1, 0.333333, 0, 0, 0, 0.75, 0, 0.333333, 0.666667, 0.5, 0, 0.920943, 1433);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_hasil`
--
ALTER TABLE `data_hasil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_hasil`
--
ALTER TABLE `data_hasil`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
