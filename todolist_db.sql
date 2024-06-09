-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jun 2024 pada 07.57
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int(11) NOT NULL,
  `tasklabel` varchar(50) NOT NULL,
  `taskstatus` enum('open','close') NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `due_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`taskid`, `tasklabel`, `taskstatus`, `createdat`, `description`, `due_date`, `due_time`) VALUES
(8, 'ajus lope nia', 'open', '2024-06-04 02:56:24', 'percintaan yang NT', '2024-06-02', '00:00:00'),
(10, 'metodologi ilmiah', 'open', '2024-06-04 04:01:31', 'buatkan proposal tentang teknologi informasi', '2024-06-06', '00:00:00'),
(13, 'ajus lope nia', 'open', '2024-06-04 05:16:44', 'sveg', '2024-05-31', '00:00:00'),
(14, 'jir bikin to do list', 'close', '2024-06-09 01:52:45', 'gas', '2024-06-09', '00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$c1AVOoGF5yDUXi/Os4hE6e9m38sho1FR8VoDX030EdQYUfXG/GjBu', '2024-06-09 03:53:30'),
(2, 'okta', '$2y$10$Locxdxb4qAKPZdL6fxCMzerGjfaBdPfULs56On.VhyPtFIL/3vTX2', '2024-06-09 03:54:09'),
(5, 'wildan', '$2y$10$Wf5ZFQdk021rSup3Drw9o.RKuGSeDPr8tfJqJ02rPvUn.cpyW.fxa', '2024-06-09 04:42:14'),
(6, 'ajus', '$2y$10$79GlgjYRaWtvFTakKO2bRe0olNm2kBznpX6nq4k9MXhU2cQ7N6k4G', '2024-06-09 05:33:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
