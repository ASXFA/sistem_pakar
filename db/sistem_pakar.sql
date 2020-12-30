-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 30 Des 2020 pada 16.22
-- Versi server: 5.7.24
-- Versi PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_pakar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `analisis`
--

CREATE TABLE `analisis` (
  `id` int(5) NOT NULL,
  `id_tamu` int(5) NOT NULL,
  `id_penyakit` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_tamu`
--

CREATE TABLE `daftar_tamu` (
  `id` int(5) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `daftar_tamu`
--

INSERT INTO `daftar_tamu` (`id`, `nama`, `jenis_kelamin`, `no_hp`, `created_at`) VALUES
(11, 'test', 'Laki-Laki', '082321234231', '2020-12-30 08:08:05'),
(12, 'testing', 'Laki-Laki', '08989767654', '2020-12-30 08:12:37'),
(13, 'test', 'Laki-Laki', '082321234231', '2020-12-30 10:17:03'),
(14, 'cobs', 'Laki-Laki', '08989767654', '2020-12-30 12:11:47'),
(15, 'sadas', 'Laki-Laki', 'asdasdas', '2020-12-30 12:43:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id` int(5) NOT NULL,
  `kode_gejala` varchar(5) NOT NULL,
  `nama_gejala` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id`, `kode_gejala`, `nama_gejala`) VALUES
(2, 'G01', 'Sulit mengunyah'),
(3, 'G02', 'Pembengkakan atau peradangan pada gusi'),
(4, 'G03', 'Gigi bergoyang'),
(5, 'G04', 'Rahang terjadi pembengkakan'),
(6, 'G05', 'Demam'),
(7, 'G06', 'Pembengkakan kelenjar getah bening sekitar rahang atau leher'),
(8, 'G07', 'Bau mulut tak sedap'),
(9, 'G08', 'Rasa sakit atau nyeri di sekitar gusi'),
(10, 'G09', 'Rasa sakit yang hebat selama beberapa hari setelah pencabutan gigi'),
(11, 'G10', 'Tulang terlihat pada socket'),
(12, 'G11', 'Gigi terasa nyilu dan sensitif'),
(13, 'G12', 'Bentuk gigi tampak terkikis'),
(14, 'G13', 'Sakit kepala'),
(15, 'G14', 'Insomnia atau merasa gelisah'),
(16, 'G15', 'Suara gemeretak gigi yang terdengar ketika tidur'),
(17, 'G16', 'Gusi mudah berdarah'),
(18, 'G17', 'Bentuk gusi agak membulat'),
(19, 'G18', 'Konsistensi gusi mejadi lunak'),
(20, 'G19', 'Gusi atau gigi bernanah'),
(21, 'G20', 'Gigi terasa sakit atau berdenyut'),
(22, 'G21', 'Kemerahan pada sudut-sudut mulut'),
(23, 'G22', 'Sudut mulut terasa nyeri'),
(24, 'G23', 'Sudut mulut bersisik'),
(25, 'G24', 'Ulkus (luka pada sudut mulut)'),
(26, 'G25', 'Dentin terlihat'),
(27, 'G26', 'Gigi berlubang'),
(28, 'G27', 'Pulpa terinfeksi/radang pada pulpa'),
(29, 'G28', 'Sakit berdenyut tanpa rangsangan'),
(30, 'G29', 'Bintik putih pada gigi'),
(31, 'G30', 'Bercak putih pada lidah'),
(32, 'G31', 'Bercak putih pada rongga mulut'),
(33, 'G32', 'Terdapat endapan plak'),
(34, 'G33', 'Terdapat karang gigi'),
(35, 'G34', 'Pembusukan gigi'),
(36, 'G35', 'Pulpa mati rasa'),
(37, 'G36', 'Ruang pulpa terbuka'),
(38, 'G37', 'Gusi berwarna merah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id` int(5) NOT NULL,
  `kode_penyakit` varchar(5) NOT NULL,
  `nama_penyakit` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id`, `kode_penyakit`, `nama_penyakit`) VALUES
(1, 'P01', 'Abses Periodontal'),
(2, 'P02', 'Abses Peripikal'),
(3, 'P03', 'Alveolar Osteitis'),
(4, 'P04', 'Abrasi Gigi'),
(5, 'P05', 'Bruxism(Gigi Gemeretak)'),
(6, 'P06', 'Gingivitis(Radang Gusi)'),
(7, 'P07', 'Gusi Bernanah'),
(8, 'P08', 'Gangguan Gigi Bungsu'),
(9, 'P09', 'Angular Ceilitis(Radang Sudut Bibir)'),
(10, 'P10', 'Karies Media'),
(11, 'P11', 'Karies Profunda'),
(12, 'P12', 'Karies Superfisial'),
(13, 'P13', 'Kandidiasis'),
(14, 'P14', 'Kalkulus (Karang gigi)'),
(15, 'P15', 'Nekrosis pulpa'),
(17, 'P16', 'Periodontitis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(5) NOT NULL,
  `id_penyakit` int(5) NOT NULL,
  `id_gejala` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `id_penyakit`, `id_gejala`) VALUES
(49, 1, 3),
(50, 1, 2),
(51, 1, 4),
(52, 2, 8),
(53, 2, 2),
(54, 2, 5),
(55, 2, 9),
(56, 2, 6),
(57, 2, 7),
(58, 3, 8),
(59, 3, 10),
(60, 3, 11),
(61, 4, 12),
(62, 4, 13),
(63, 5, 12),
(64, 5, 14),
(65, 5, 15),
(66, 5, 16),
(67, 6, 3),
(68, 6, 17),
(69, 6, 18),
(70, 6, 19),
(71, 7, 3),
(72, 7, 6),
(73, 7, 7),
(74, 7, 20),
(75, 7, 21),
(76, 8, 8),
(77, 8, 2),
(78, 8, 5),
(79, 8, 9),
(80, 8, 3),
(81, 9, 22),
(82, 9, 23),
(83, 9, 24),
(84, 9, 25),
(85, 10, 27),
(86, 10, 26),
(88, 10, 12),
(89, 11, 27),
(90, 11, 26),
(91, 11, 28),
(92, 11, 29),
(93, 12, 27),
(94, 12, 30),
(95, 13, 8),
(96, 13, 31),
(97, 13, 32),
(98, 14, 8),
(99, 14, 17),
(100, 14, 33),
(101, 14, 34),
(102, 15, 27),
(103, 15, 35),
(104, 15, 36),
(105, 15, 37),
(106, 17, 8),
(107, 17, 17),
(108, 17, 3),
(109, 17, 20),
(110, 17, 38);

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id` int(5) NOT NULL,
  `kode_solusi` varchar(5) NOT NULL,
  `id_penyakit` int(5) NOT NULL,
  `nama_solusi` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id`, `kode_solusi`, `id_penyakit`, `nama_solusi`) VALUES
(1, 'S01', 1, 'Pemberian antibiotik'),
(2, 'S02', 2, 'Pemberian antibiotik'),
(3, 'S03', 3, 'Pemberian antibiotik'),
(4, 'S04', 4, 'Melakukan penambalan gigi, menggunakan sikat gigi yang berbulu halus'),
(5, 'S05', 5, 'menggunakan night guard pada saat tidur, melatih postur tubuh yang baik. '),
(6, 'S06', 6, 'menggunakan obat kumur, rajin menyikat gigi'),
(7, 'S07', 7, 'Pemberian antibiotik'),
(8, 'S08', 8, 'melakukan pencabutan pada gigi bungsu'),
(9, 'S09', 9, 'menggunakan obat anti jamur, mengkonsumsi banyak air'),
(10, 'S10', 10, 'melakukan penambalan '),
(11, 'S11', 11, 'melakukan penambalan '),
(12, 'S12', 12, 'melakukan penambalan '),
(13, 'S13', 13, 'menggunakan obat anti jamur'),
(14, 'S14', 14, 'melakukan scalling / pembersihan karang gigi'),
(15, 'S15', 15, 'melakukan pencabutan gigi'),
(17, 'S16', 17, 'melakukan pembersihan pada karang gigi, memperbaiki akar gigi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_analisa`
--

CREATE TABLE `temp_analisa` (
  `id` int(6) NOT NULL,
  `id_tamu` int(5) NOT NULL,
  `id_penyakit` int(5) NOT NULL,
  `id_gejala` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_gejala`
--

CREATE TABLE `temp_gejala` (
  `id` int(5) NOT NULL,
  `id_tamu` int(5) NOT NULL,
  `id_gejala` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_konsultasi`
--

CREATE TABLE `temp_konsultasi` (
  `id` int(5) NOT NULL,
  `id_daftar_tamu` int(3) NOT NULL,
  `id_gejala` int(3) NOT NULL,
  `jawaban` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_penyakit`
--

CREATE TABLE `temp_penyakit` (
  `id` int(5) NOT NULL,
  `id_tamu` int(5) NOT NULL,
  `id_penyakit` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(150) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'admin', 'administrator', '$2y$10$H1FpA6Rym4uDjdJoBKlvhuqEZs9uOhmiuRcvpW4Dh6KuisLIulOaW', 1, '2020-12-22 07:42:24', '-', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `analisis`
--
ALTER TABLE `analisis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_tamu`
--
ALTER TABLE `daftar_tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_analisa`
--
ALTER TABLE `temp_analisa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_gejala`
--
ALTER TABLE `temp_gejala`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_konsultasi`
--
ALTER TABLE `temp_konsultasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp_penyakit`
--
ALTER TABLE `temp_penyakit`
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
-- AUTO_INCREMENT untuk tabel `analisis`
--
ALTER TABLE `analisis`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `daftar_tamu`
--
ALTER TABLE `daftar_tamu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT untuk tabel `solusi`
--
ALTER TABLE `solusi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `temp_analisa`
--
ALTER TABLE `temp_analisa`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=706;

--
-- AUTO_INCREMENT untuk tabel `temp_gejala`
--
ALTER TABLE `temp_gejala`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `temp_konsultasi`
--
ALTER TABLE `temp_konsultasi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT untuk tabel `temp_penyakit`
--
ALTER TABLE `temp_penyakit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
