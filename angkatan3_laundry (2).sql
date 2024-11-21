-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2024 pada 09.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angkatan3_laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `nama_customer`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Indah', '123', 'Jakarta', '2024-11-15 01:35:58', '2024-11-15 01:36:26'),
(2, 'Chika', '12345678', 'Bekasi', '2024-11-15 02:56:23', '2024-11-15 02:57:00'),
(3, 'Putri', '123456', 'Tangerang', '2024-11-15 02:56:42', '2024-11-15 02:57:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_transaksi`
--

CREATE TABLE `data_transaksi` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `kode_order` varchar(50) NOT NULL,
  `tanggal_order` datetime NOT NULL,
  `status_order` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_transaksi`
--

INSERT INTO `data_transaksi` (`id`, `id_customer`, `kode_order`, `tanggal_order`, `status_order`, `created_at`, `updated_at`) VALUES
(18, 3, '#INV2011202400017', '2024-11-20 00:00:00', 1, '2024-11-20 04:55:48', '2024-11-21 04:27:36'),
(20, 3, '#INV2111202400019', '2024-11-14 00:00:00', 1, '2024-11-21 04:40:08', '2024-11-21 06:49:35'),
(21, 2, '#INV2111202400021', '2024-11-20 00:00:00', 0, '2024-11-21 04:42:34', '2024-11-21 04:42:34'),
(22, 2, '#INV2111202400022', '2024-11-13 00:00:00', 0, '2024-11-21 07:48:20', '2024-11-21 07:48:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id`, `nama_level`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '2024-11-13 06:20:21', '2024-11-13 06:20:21'),
(2, 'Operator', '2024-11-13 06:20:21', '2024-11-13 06:20:21'),
(4, 'Pimpinan', '2024-11-14 06:43:40', '2024-11-14 06:43:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `nama_paket`, `harga`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Cuci dan Gosok', '5000', 'Sudah terbungkus rapih', '2024-11-15 02:14:58', '2024-11-15 02:14:58'),
(2, 'Hanya Cuci', '4500', 'Hanya melayani cuci pakaian', '2024-11-15 02:15:37', '2024-11-15 02:15:37'),
(3, 'Hanya Gosok', '5000', 'Hanya melayani gosok pakaian', '2024-11-15 02:16:04', '2024-11-15 02:16:04'),
(4, 'Laundry Besar (Selimut, Karpet, Mantel, Sprei My L', '7000', 'Hanya melayani Laundry Besar', '2024-11-15 02:27:27', '2024-11-15 02:27:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `id_order`, `id_paket`, `qty`, `subtotal`, `catatan`, `created_at`, `updated_at`) VALUES
(19, 18, 3, 2, 10000, '', '2024-11-20 04:55:48', '2024-11-20 04:55:48'),
(20, 18, 2, 2, 9000, '', '2024-11-20 04:55:48', '2024-11-20 04:55:48'),
(23, 20, 3, 2, 10000, '', '2024-11-21 04:40:08', '2024-11-21 04:40:08'),
(24, 20, 2, 3, 13500, '', '2024-11-21 04:40:08', '2024-11-21 04:40:08'),
(25, 21, 1, 2, 10000, '', '2024-11-21 04:42:34', '2024-11-21 04:42:34'),
(26, 21, 2, 3, 13500, '', '2024-11-21 04:42:34', '2024-11-21 04:42:34'),
(27, 22, 3, 2, 10000, '', '2024-11-21 07:48:20', '2024-11-21 07:48:20'),
(28, 22, 2, 1, 4500, '', '2024-11-21 07:48:20', '2024-11-21 07:48:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_pengambilan`
--

CREATE TABLE `transaksi_pengambilan` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_pay` double(10,2) NOT NULL,
  `pickup_change` double(10,2) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_pengambilan`
--

INSERT INTO `transaksi_pengambilan` (`id`, `id_order`, `id_customer`, `pickup_date`, `pickup_pay`, `pickup_change`, `note`, `created_at`, `updated_at`) VALUES
(3, 18, 3, '2024-11-21', 20000.00, 1000.00, '', '2024-11-21 04:27:36', '2024-11-21 04:27:36'),
(4, 20, 3, '2024-11-21', 50000.00, 26500.00, '', '2024-11-21 06:49:35', '2024-11-21 06:49:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama`, `email`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', 'admin', '12345678', '2024-11-13 06:44:14', '2024-11-13 06:44:14'),
(2, 2, 'arsa', 'finkaaa@gmail.com', 'arsa', '12345678', '2024-11-13 08:23:40', '2024-11-15 02:35:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_transaksi_ibfk_1` (`id_customer`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_detail_ibfk_1` (`id_order`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indeks untuk tabel `transaksi_pengambilan`
--
ALTER TABLE `transaksi_pengambilan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ibfk_1` (`id_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `transaksi_pengambilan`
--
ALTER TABLE `transaksi_pengambilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  ADD CONSTRAINT `data_transaksi_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `data_transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
