-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2025 pada 09.51
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
-- Database: `db_jma`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `username`, `comment`, `rating`, `created_at`) VALUES
(1, 3, 'Selinecosu', 'gacor', 1, '2025-03-25 02:20:05'),
(7, 3, 'Selinecosu', 'omg aku nak meletup', 5, '2025-04-21 11:07:11'),
(18, 4, 'Cukimai', 'tes 3', 2, '2025-05-15 13:21:25'),
(19, 4, 'Cukimai', 'tes 4', 3, '2025-05-15 13:22:02'),
(20, 4, 'Cukimai', 'tes 5', 4, '2025-05-15 13:22:15'),
(21, 4, 'Cukimai', 'tes 6', 2, '2025-05-15 13:24:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `verified`, `created_at`) VALUES
(1, 'BryneF2K', 'xvivydiva@gmail.com', '$2y$10$yYVdSQpfGfsIMUwEPnPa3udC669tV7vVFgpzGfnWhudPWPBS8gN9e', 0, '2025-03-25 01:50:12'),
(2, 'Sseline_fly', 'sonmartro86@gmail.com', '$2y$10$vO.gVV8MwbBNv5hs599Fu.JxWDbqfDWZYyOcwGT1zlwi1rH5V2pyy', 0, '2025-03-25 01:57:21'),
(3, 'Selinecosu', 'calvarychristine08@gmail.com', '$2y$10$kMFecVOgXnYp/OT47Q7ktetyZtzK9CCgUsbS4Rf2TQbgzaGGqs4.i', 0, '2025-03-25 01:58:21'),
(4, 'Cukimai', 'bayud.kematian@gmail.com', '$2y$10$GH0pHPrBMgNHQAEseo4xOOSpl7RZIC9LmTZbRUQ2y9ZxBRYb98j7S', 1, '2025-04-21 12:15:54'),
(5, 'selin', 'selin@gmail.com', '$2y$10$AJ/2pzxNm/TjfU1F0Ez02.3npFC7pB7insnbw0Nz28k2SBtlWyU6K', 1, '2025-04-22 09:58:45'),
(7, 'asdasd', 'selin@gmail.com', '$2y$10$CduQXXqM7ncg6J1T0v1uYeL5/Pl3PA064kTLI3J.fkn2pJ2HZZyba', 1, '2025-04-24 14:38:25'),
(8, 'gading', 'gading@gmail.com', '$2y$10$YQr/B6dEUAJXGg5gQ.O83Ox3GL6VdoHrQkmjjIqMbW8zgJ8RcAc5y', 1, '2025-04-25 02:15:28'),
(9, 'Admin', 'jmacleaningservice@hotmail.com', '$2y$10$Arz1Y5tLnOQDX/viYNyqzOdFSCRSdvzDmCiIqIZhB8CDsrygFf4o2', 1, '2025-05-15 12:11:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
