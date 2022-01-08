-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2022 at 07:29 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slm_desa_rasau_jaya_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_layanan`
--

CREATE TABLE `tb_layanan` (
  `id_layanan` bigint(20) NOT NULL,
  `waktu_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(10) NOT NULL,
  `nama` text NOT NULL,
  `nik` varchar(16) NOT NULL,
  `keperluan` mediumtext NOT NULL,
  `no_surat` text,
  `status` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_layanan`
--

INSERT INTO `tb_layanan` (`id_layanan`, `waktu_data`, `id_user`, `nama`, `nik`, `keperluan`, `no_surat`, `status`) VALUES
(1, '2022-01-08 00:30:54', 1, 'Ronald', '2983928302302930', 'testajs ajsabsajsausj ajb', '02830323', '0'),
(2, '2022-01-08 00:31:37', 1, 'Ronal', '2030293029309090', 'ksjdkjs', 'jksjdksj', '0'),
(3, '2022-01-08 00:32:06', 1, 'Ronal', '2030293029309090', 'ksjdkjs', 'jksjdksj', '0'),
(4, '2022-01-08 00:32:19', 1, 'aksjaksjkjk', '2084039403940390', 'ishdjhsdh', 'ijdksjd', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` enum('operator','atasan') NOT NULL,
  `nama_lengkap` text NOT NULL,
  `email` text,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` text,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `level`, `nama_lengkap`, `email`, `no_hp`, `foto`, `last_login`, `create_datetime`, `status`) VALUES
(1, 'operator', '$2y$10$Hi/tubm7R.k00GMXnclhjOvK/tGZuIvlShde3.2hi6AHHmU72/ZYa', 'operator', 'Operator 1', 'operator1@sungairaya.com', NULL, '61d87f10abde5.png', '2022-01-07 15:21:23', '2022-01-07 22:22:09', '1'),
(2, 'atasan', '$2y$10$qgezsHdwYlGEnUQ7VeAJZODIaBROgvI7pRgfLON4D2SKjLR2jEP9u', 'atasan', 'Wiwin Galuh', 'wiwin@gmail.com', NULL, NULL, '2022-01-07 15:22:16', '2022-01-07 22:22:51', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_layanan`
--
ALTER TABLE `tb_layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_layanan`
--
ALTER TABLE `tb_layanan`
  MODIFY `id_layanan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
