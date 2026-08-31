-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2026 at 02:00 PM
-- Server version: 10.11.18-MariaDB-cll-lve
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisp4435_sipambblabfor`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_bukti`
--

CREATE TABLE `barang_bukti` (
  `id_bb` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foto_bb`
--

CREATE TABLE `foto_bb` (
  `id_fb` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `foto` varchar(225) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penanggung_jawab`
--

CREATE TABLE `penanggung_jawab` (
  `id_pj` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `nrp` varchar(225) NOT NULL,
  `jabatan` varchar(225) NOT NULL,
  `ttd` varchar(225) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` int(11) NOT NULL,
  `no_surat` varchar(225) NOT NULL,
  `id_bb` int(11) NOT NULL,
  `id_pj` int(11) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tersangka` varchar(225) NOT NULL,
  `lokasi_penangkapan` varchar(225) NOT NULL,
  `waktu_penangkapan` time NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_bukti`
--
ALTER TABLE `barang_bukti`
  ADD PRIMARY KEY (`id_bb`);

--
-- Indexes for table `foto_bb`
--
ALTER TABLE `foto_bb`
  ADD PRIMARY KEY (`id_fb`);

--
-- Indexes for table `penanggung_jawab`
--
ALTER TABLE `penanggung_jawab`
  ADD PRIMARY KEY (`id_pj`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_bukti`
--
ALTER TABLE `barang_bukti`
  MODIFY `id_bb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_bb`
--
ALTER TABLE `foto_bb`
  MODIFY `id_fb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penanggung_jawab`
--
ALTER TABLE `penanggung_jawab`
  MODIFY `id_pj` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
