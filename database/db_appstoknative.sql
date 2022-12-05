-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2022 at 12:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_appstoknative`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `kd_admin` int(6) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `gambar` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`kd_admin`, `nama`, `email`, `password`, `gambar`) VALUES
(5, 'admin', 'admin@gmail.com', '123456', 'tokokita-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kd_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(60) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga_jual` int(15) NOT NULL,
  `harga_beli` int(15) NOT NULL,
  `stok` int(4) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kd_barang`, `nama_barang`, `satuan`, `harga_jual`, `harga_beli`, `stok`, `status`) VALUES
('BR-00001', 'Rokok Evo Mild', 'BUNGKUS', 18500, 18000, 10, '0'),
('BR-000010', 'Susu Ultra 100 ml', 'PCS', 11000, 10000, 100, '0'),
('BR-000011', 'Susu UHT', 'DUS', 21000, 18000, 50, '0'),
('BR-00002', 'Susu Bendera Full Cream', 'DUS', 83000, 78000, 11, '0'),
('BR-00003', 'Bear Brand', 'KALENG', 11500, 9000, 20, '0'),
('BR-00005', 'Dji Sam Soe', 'BUNGKUS', 20000, 18500, 60, '0'),
('BR-00006', 'Rokok Sampoerna Kretek', 'BUNGKUS', 18500, 17000, 22, '0'),
('BR-00007', 'Mie Soto Kuah', 'DUS', 31000, 29500, 5, '0'),
('BR-00009', 'Sarimi Mie Ayam Bawang', 'DUS', 30000, 28000, 3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `barangp_sementara`
--

CREATE TABLE `barangp_sementara` (
  `id_barangp` int(6) NOT NULL,
  `kd_pembelian` char(8) NOT NULL,
  `nama_barangp` varchar(225) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `harga_barangp` double NOT NULL,
  `item` int(4) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_pembelian`
--

CREATE TABLE `barang_pembelian` (
  `kd_barang_beli` int(6) NOT NULL,
  `kd_pembelian` char(8) NOT NULL,
  `nama_barang_beli` varchar(225) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `harga_beli` double NOT NULL,
  `item` int(4) NOT NULL,
  `total` double NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_pembelian`
--

INSERT INTO `barang_pembelian` (`kd_barang_beli`, `kd_pembelian`, `nama_barang_beli`, `satuan`, `harga_beli`, `item`, `total`, `status`) VALUES
(128, 'PEM00001', 'Rokok Evo Mild', 'BUNGKUS', 18000, 10, 180000, '1'),
(129, 'PEM00001', 'Rokok Sampoerna Kretek', 'BUNGKUS', 17000, 27, 459000, '1'),
(131, 'PEM00002', 'Sarimi Mie Ayam Bawang', 'DUS', 28000, 3, 84000, '1'),
(132, 'PEM00002', 'Mie Soto Kuah', 'DUS', 29500, 5, 147500, '1'),
(134, 'PEM00003', 'Susu Ultra 100 ml', 'PCS', 10000, 100, 1000000, '1'),
(135, 'PEM00003', 'Susu UHT', 'DUS', 18000, 50, 900000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `d_pembelian`
--

CREATE TABLE `d_pembelian` (
  `id_pembelian` int(6) NOT NULL,
  `kd_pembelian` char(8) NOT NULL,
  `kd_barang_beli` int(6) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_pembelian`
--

INSERT INTO `d_pembelian` (`id_pembelian`, `kd_pembelian`, `kd_barang_beli`, `jumlah`, `subtotal`) VALUES
(7, 'PEM00001', 128, 10, 180000),
(8, 'PEM00001', 129, 27, 459000),
(10, 'PEM00002', 131, 3, 84000),
(11, 'PEM00002', 132, 5, 147500),
(13, 'PEM00003', 134, 100, 1000000),
(14, 'PEM00003', 135, 50, 900000);

-- --------------------------------------------------------

--
-- Table structure for table `d_penjualan`
--

CREATE TABLE `d_penjualan` (
  `id_penjualan` int(6) NOT NULL,
  `kd_penjualan` char(8) NOT NULL,
  `kd_barang` varchar(20) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_penjualan`
--

INSERT INTO `d_penjualan` (`id_penjualan`, `kd_penjualan`, `kd_barang`, `jumlah`, `subtotal`) VALUES
(1, 'PEN00001', 'BR-00003', 10, 115000),
(2, 'PEN00001', 'BR-00005', 2, 40000),
(4, 'PEN00002', 'BR-00005', 8, 160000),
(5, 'PEN00003', 'BR-00006', 5, 92500);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `kd_pembelian` char(8) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `kd_admin` int(6) NOT NULL,
  `kd_supplier` int(6) NOT NULL,
  `total_pembelian` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`kd_pembelian`, `tgl_pembelian`, `kd_admin`, `kd_supplier`, `total_pembelian`) VALUES
('PEM00001', '2022-10-19', 5, 10, 639000),
('PEM00002', '2022-11-02', 5, 12, 231500),
('PEM00003', '2022-10-20', 5, 12, 1900000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `kd_penjualan` char(8) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `kd_admin` int(6) NOT NULL,
  `dibayar` double NOT NULL,
  `total_penjualan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`kd_penjualan`, `tgl_penjualan`, `kd_admin`, `dibayar`, `total_penjualan`) VALUES
('PEN00001', '2022-10-19', 5, 160000, 155000),
('PEN00002', '2022-11-01', 5, 200000, 160000),
('PEN00003', '2022-10-20', 5, 100000, 92500);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_sementara`
--

CREATE TABLE `penjualan_sementara` (
  `id_penjualan_sementara` int(11) NOT NULL,
  `kd_penjualan` char(8) NOT NULL,
  `kd_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(225) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `harga` double NOT NULL,
  `item` int(4) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `kd_perusahaan` int(11) NOT NULL,
  `nama_perusahaan` varchar(225) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `pemilik` varchar(225) NOT NULL,
  `kota` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`kd_perusahaan`, `nama_perusahaan`, `alamat`, `pemilik`, `kota`) VALUES
(1, 'Toko Kita', 'Jl. Aspal No. 18 Jawa Barat', 'Juragan Toko', 'Sukabumi');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kd_supplier` int(6) NOT NULL,
  `nama_supplier` varchar(60) NOT NULL,
  `alamat` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kd_supplier`, `nama_supplier`, `alamat`) VALUES
(10, 'Sinar Angkasa', 'Jl. Pasar Pelita No. 10'),
(12, 'Multi Grosir', 'Jl. Rawasalak No. 9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kd_admin`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indexes for table `barangp_sementara`
--
ALTER TABLE `barangp_sementara`
  ADD PRIMARY KEY (`id_barangp`),
  ADD KEY `kd_pembelian` (`kd_pembelian`);

--
-- Indexes for table `barang_pembelian`
--
ALTER TABLE `barang_pembelian`
  ADD PRIMARY KEY (`kd_barang_beli`);

--
-- Indexes for table `d_pembelian`
--
ALTER TABLE `d_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `kd_pembelian` (`kd_pembelian`),
  ADD KEY `kd_pembelian_2` (`kd_pembelian`),
  ADD KEY `kd_barang_beli` (`kd_barang_beli`),
  ADD KEY `kd_barang_beli_2` (`kd_barang_beli`);

--
-- Indexes for table `d_penjualan`
--
ALTER TABLE `d_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `kd_penjualan` (`kd_penjualan`),
  ADD KEY `kd_barang` (`kd_barang`),
  ADD KEY `kd_barang_2` (`kd_barang`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`kd_pembelian`),
  ADD KEY `kd_admin` (`kd_admin`),
  ADD KEY `kd_supplier` (`kd_supplier`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`kd_penjualan`),
  ADD KEY `kd_admin` (`kd_admin`);

--
-- Indexes for table `penjualan_sementara`
--
ALTER TABLE `penjualan_sementara`
  ADD PRIMARY KEY (`id_penjualan_sementara`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`kd_perusahaan`),
  ADD KEY `kd_perusahaan` (`kd_perusahaan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `kd_admin` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `barangp_sementara`
--
ALTER TABLE `barangp_sementara`
  MODIFY `id_barangp` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `barang_pembelian`
--
ALTER TABLE `barang_pembelian`
  MODIFY `kd_barang_beli` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `d_pembelian`
--
ALTER TABLE `d_pembelian`
  MODIFY `id_pembelian` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `d_penjualan`
--
ALTER TABLE `d_penjualan`
  MODIFY `id_penjualan` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penjualan_sementara`
--
ALTER TABLE `penjualan_sementara`
  MODIFY `id_penjualan_sementara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `kd_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `kd_supplier` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `d_pembelian`
--
ALTER TABLE `d_pembelian`
  ADD CONSTRAINT `d_pembelian_ibfk_3` FOREIGN KEY (`kd_pembelian`) REFERENCES `pembelian` (`kd_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_pembelian_ibfk_4` FOREIGN KEY (`kd_barang_beli`) REFERENCES `barang_pembelian` (`kd_barang_beli`);

--
-- Constraints for table `d_penjualan`
--
ALTER TABLE `d_penjualan`
  ADD CONSTRAINT `d_penjualan_ibfk_3` FOREIGN KEY (`kd_barang`) REFERENCES `barang` (`kd_barang`),
  ADD CONSTRAINT `d_penjualan_ibfk_4` FOREIGN KEY (`kd_penjualan`) REFERENCES `penjualan` (`kd_penjualan`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`kd_supplier`) REFERENCES `supplier` (`kd_supplier`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`kd_admin`) REFERENCES `admin` (`kd_admin`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`kd_admin`) REFERENCES `admin` (`kd_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
