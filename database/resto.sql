-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 08:12 AM
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
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_bahan` varchar(50) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `stok` float NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `id_kategori` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id`, `tanggal`, `nama_bahan`, `harga`, `stok`, `satuan`, `id_kategori`) VALUES
(18, '2024-05-16', 'Sapu Lantai', 10000, 0.5, '', 8),
(19, '2024-05-31', 'Pulpen Faster', 5000, 2.5, '', 7),
(20, '2024-05-23', 'Kain Pel', 15000, 5, '', 8),
(38, '2024-05-25', 'asd', 123, 53, 'kg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_masuk`
--

CREATE TABLE `bahan_masuk` (
  `id` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `stok_masuk` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_masuk`
--

INSERT INTO `bahan_masuk` (`id`, `id_bahan`, `id_transaksi`, `stok_masuk`) VALUES
(1, 18, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_transaksi`
--

CREATE TABLE `bahan_transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_transaksi`
--

INSERT INTO `bahan_transaksi` (`id`, `tanggal`) VALUES
(21, '2024-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `detail_menu`
--

CREATE TABLE `detail_menu` (
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `kebutuhan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_menu`
--

INSERT INTO `detail_menu` (`id_menu`, `id_bahan`, `id`, `kebutuhan`) VALUES
(36, 1, 5, 1),
(37, 7, 6, 3),
(37, 6, 7, 1),
(38, 1, 8, 1),
(38, 7, 9, 3),
(39, 1, 10, 1),
(40, 1, 11, 5),
(40, 2, 12, 3),
(40, 3, 13, 4),
(43, 1, 14, 1),
(43, 3, 15, 1),
(44, 10, 16, 2),
(44, 14, 17, 1),
(44, 15, 18, 2),
(45, 27, 19, 7),
(46, 18, 20, 1),
(47, 18, 21, 1),
(48, 18, 22, 1.5),
(48, 19, 23, 2.5),
(49, 18, 24, 5),
(50, 18, 25, 3),
(51, 18, 26, 1),
(52, 18, 27, 1),
(53, 18, 28, 1),
(54, 18, 29, 1),
(55, 18, 30, 1),
(56, 18, 31, 1),
(57, 18, 32, 1),
(58, 18, 33, 1),
(59, 18, 34, 1),
(60, 18, 35, 1),
(61, 18, 36, 1),
(62, 18, 37, 1),
(63, 18, 38, 1),
(64, 18, 39, 1),
(65, 18, 40, 3),
(66, 19, 41, 4),
(68, 18, 43, 10),
(69, 38, 44, 10),
(20, 18, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id` int(20) NOT NULL,
  `id_penjualan` int(20) NOT NULL,
  `id_menu` int(20) NOT NULL,
  `amount` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id`, `id_penjualan`, `id_menu`, `amount`) VALUES
(77, 57, 40, 1),
(78, 58, 44, 1),
(79, 59, 48, 1),
(80, 60, 16, 1),
(81, 60, 40, 1),
(82, 60, 38, 1),
(83, 60, 42, 1),
(84, 61, 44, 2),
(85, 62, 44, 1),
(86, 63, 69, 2),
(87, 64, 69, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_bahan`
--

CREATE TABLE `kategori_bahan` (
  `id` int(10) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_bahan`
--

INSERT INTO `kategori_bahan` (`id`, `kategori`) VALUES
(1, 'Bahan Baku Soto'),
(2, 'Bahan Baku Nasi dan Mie'),
(3, 'Bahan Se\'i'),
(4, 'Bahan Baku Kerupuk'),
(5, 'Bahan Baku Minuman'),
(6, 'Bahan-bahan plastik'),
(7, 'Bahan ATK (Alat Tulis Kantor)'),
(8, 'Alat dan Bahan Kebersihan'),
(9, 'Rokok'),
(10, 'Energy'),
(11, 'Bahan untuk Lauk karyawan'),
(23, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tipe` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `harga`, `gambar`, `tipe`) VALUES
(13, 'Nasi Soto Bale Gule', 60000, '', 0),
(14, 'Nasi Cumi Pak Kris', 50000, '', 0),
(15, 'Nasi Goreng', 50000, '', 0),
(16, 'Bakso', 50000, '', 0),
(38, 'Rawon', 50000, 'assets/img/663cdc6212cb9.jpg', 0),
(39, 'Ayam Bakar', 100000, 'assets/img/663ce25f28f50.jpg', 0),
(40, 'X', 1000000, 'assets/img/663f95ba2a9fc.jpg', 0),
(42, 'Josua', 5000, 'assets/img/663e004a061bd.jpg', 1),
(43, 'Ayam Geprek', 15000, 'assets/img/663e018bc9805.png', 0),
(44, 'Nasi Gule', 50000, 'assets/img/66442de178356.jpg', 0),
(45, 'seblak', 5000, 'assets/img/6648ac5fb1259.jpg', 0),
(46, 'burjo', 5000, 'assets/img/6648acfc7e970.jpg', 0),
(47, 'asd', 213, 'assets/img/6648adde8325e.jpg', 0),
(48, 'Rawon', 15000, 'assets/img/6648ae950de2d.jpg', 0),
(49, 'testing', 2131, 'assets/img/6651fa33365c5.jpg', 0),
(50, 'coba', 1231, 'assets/img/6651fc0704dd9.jpg', 0),
(65, 'Es Teh', 5000, 'assets/img/6652028db7d2f.jpeg', 1),
(66, 'woyyyyyyyyy', 1231, 'assets/img/66520879770c3.jpg', 0),
(68, 'tes bug', 10000, 'assets/img/6656af2857444.jpeg', 0),
(69, 'BUG FIXING', 1312, 'assets/img/6658641f25c39.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(15) NOT NULL,
  `total_harga` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal`, `shift`, `total_harga`) VALUES
(57, '2024-06-05', 'siang', 1000000),
(58, '2024-05-15', 'pagi', 50000),
(59, '2024-05-18', 'pagi', 15000),
(60, '2024-05-18', 'pagi', 1105000),
(61, '2024-05-28', 'pagi', 100000),
(62, '2024-06-02', 'malam', 50000),
(63, '2024-06-02', 'malam', 2624),
(64, '2024-07-02', 'pagi', 6560);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `administrator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `administrator`) VALUES
(3, 'user', 'user', 'user', 0),
(4, 'webitkupang', 'webit', 'webit', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_transaksi`
--
ALTER TABLE `bahan_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_menu`
--
ALTER TABLE `detail_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan_transaksi`
--
ALTER TABLE `bahan_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `detail_menu`
--
ALTER TABLE `detail_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
