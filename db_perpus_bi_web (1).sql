-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 02 Jun 2025 pada 15.06
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
-- Database: `db_perpus_bi_web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'nonaktif',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `email`, `password`, `id_role`, `status`, `create_date`) VALUES
(4, 'admin', 'wibowo21@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 'aktif', '2025-05-26 15:02:30'),
(6, 'staff', 'admin01@email.com', '1562206543da764123c21bd524674f0a8aaf49c8a89744c97352fe677f7e4006', 2, 'aktif', '2025-05-27 07:07:22'),
(8, 'kiki', 'kiki@email.com', '888da5db853449fff82b07cbdbf7c755ece0783aa670bb36cc5c4cc9a68fb864', 3, 'aktif', '2025-05-27 07:10:01'),
(9, 'rizky123', 'rizky@example.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 3, 'aktif', '2025-05-28 04:45:33'),
(11, 'rapa', 'rapa@gmail.com', 'f560fc33424ca9455e92634fdf4042f8343bc81ccb484b60c4e56ada60781da1', 3, 'nonaktif', '2025-05-28 07:22:59'),
(15, 'baal', 'baal@gmail.com', '567d0eeedf641e682bfed58c3d6f5ee5d4f3251d44c9bcb078c5013a904baf21', 3, 'aktif', '2025-05-28 07:50:11'),
(16, 'rafi', 'rafi@gmail.com', 'dd5d261e81f6abcab8a32e901c85dbcba409e482cd1c98a1e803d8ffb44e7cde', 3, 'aktif', '2025-05-28 08:06:45');

--
-- Trigger `akun`
--
DELIMITER $$
CREATE TRIGGER `insert_into_anggota_if_role_anggota` AFTER INSERT ON `akun` FOR EACH ROW BEGIN
    DECLARE role_name VARCHAR(20);

    -- Ambil nama role berdasarkan id_role
    SELECT nama_role INTO role_name
    FROM role
    WHERE id_role = NEW.id_role;

    -- Jika role adalah 'anggota', masukkan juga ke tabel anggota
    IF role_name = 'anggota' THEN
        INSERT INTO anggota (id_akun, nama, kelas, status)
        VALUES (NEW.id_akun, '', '', NEW.status);
        -- Nama dan kelas bisa diisi belakangan
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sync_status_akun_to_anggota` AFTER UPDATE ON `akun` FOR EACH ROW BEGIN
    UPDATE anggota
    SET status = NEW.status
    WHERE id_akun = NEW.id_akun;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `id_akun`, `nama`, `alamat`, `kelas`, `status`) VALUES
(2, 8, 'Kiki', 'Tangsel', 'DKV-1', 'aktif'),
(4, 9, 'Rizky', 'Tangsel', 'DKV-1', 'aktif'),
(5, 11, 'rapa adya', 'Tangsel', 'XI-RPL', 'nonaktif'),
(12, 15, 'baal pamulang', 'Tangsel', 'XI-RPL', 'aktif'),
(13, 16, 'Rafi sauqi', 'CIputat', 'XI-RPL', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT 10,
  `create_by` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `create_by`, `create_date`, `gambar`) VALUES
(11, 'Belajar SQL untuk Pemula', 'Andi Santoso', 'PT. Edukasi', '2021', 9, 4, '2025-05-28 02:33:43', 'buku_sql.png\r\n'),
(12, 'Pemrograman Python Lanjutan', 'Siti Rahma', 'Gramedia', '2020', 9, 4, '2025-05-28 02:33:43', 'buku_phyton.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pinjam`
--

CREATE TABLE `detail_pinjam` (
  `id_detail` int(11) NOT NULL,
  `id_pinjam` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali') DEFAULT 'dipinjam',
  `create_by` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_anggota`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `create_by`, `create_date`) VALUES
(11, 2, 11, '2025-05-20', '2025-05-30', 'kembali', 4, '2025-05-28 04:59:46'),
(12, 4, 12, '2025-05-20', '2025-05-30', 'dipinjam', 4, '2025-05-28 04:59:46'),
(15, 2, 12, '2025-05-28', '2025-06-04', 'kembali', 8, '2025-05-28 06:46:47'),
(19, 12, 11, '2025-05-28', '2025-06-04', 'dipinjam', 15, '2025-05-28 07:51:04'),
(20, 13, 11, '2025-05-28', '2025-06-04', 'dipinjam', 16, '2025-05-28 08:08:06'),
(21, 12, 11, '2025-05-28', '2025-06-04', 'dipinjam', 15, '2025-05-28 08:10:20');

--
-- Trigger `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `after_peminjaman_kembali` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
    DECLARE telat INT DEFAULT 0;
    DECLARE total_denda DECIMAL(10,2) DEFAULT 0.00;

    -- Cek jika status berubah dari dipinjam ke kembali
    IF OLD.status = 'dipinjam' AND NEW.status = 'kembali' THEN
        -- Hitung selisih hari antara tanggal kembali aktual dan tanggal_kembali yang dijadwalkan
        SET telat = DATEDIFF(CURDATE(), NEW.tanggal_kembali);

        -- Hitung denda jika lebih dari 2 hari
        IF telat > 2 THEN
            SET total_denda = (telat - 2) * 2000;
        ELSE
            SET total_denda = 0;
        END IF;

        -- Masukkan data ke tabel pengembalian
        INSERT INTO pengembalian (id_pinjam, tanggal_kembali, denda)
        VALUES (
            NEW.id_pinjam,
            CURDATE(),        -- Tanggal pengembalian aktual
            total_denda
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_kembali` int(11) NOT NULL,
  `id_pinjam` int(11) NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `denda` decimal(10,2) DEFAULT 0.00,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_kembali`, `id_pinjam`, `tanggal_kembali`, `denda`, `create_date`) VALUES
(1, 11, '2025-05-28', 0.00, '2025-05-28 05:04:33'),
(2, 11, '2025-05-28', 0.00, '2025-05-28 05:04:33'),
(3, 15, '2025-05-28', 0.00, '2025-05-28 06:49:23'),
(4, 15, '2025-05-28', 0.00, '2025-05-28 06:49:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` enum('admin','staff','anggota') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'anggota');

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `staff`
--

INSERT INTO `staff` (`id_staff`, `id_akun`, `nama`, `no_telepon`) VALUES
(1, 6, 'bale', '081234567890');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_anggota_terajin`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_anggota_terajin` (
`nama` varchar(100)
,`total_transaksi` bigint(21)
,`total_buku_dipinjam` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_buku_terlaris`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_buku_terlaris` (
`judul` varchar(200)
,`total_dipinjam` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_anggota_terajin`
--
DROP TABLE IF EXISTS `view_anggota_terajin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_anggota_terajin`  AS SELECT `a`.`nama` AS `nama`, count(distinct `p`.`id_pinjam`) AS `total_transaksi`, sum(`dp`.`jumlah`) AS `total_buku_dipinjam` FROM ((`anggota` `a` join `peminjaman` `p` on(`a`.`id_anggota` = `p`.`id_anggota`)) join `detail_pinjam` `dp` on(`p`.`id_pinjam` = `dp`.`id_pinjam`)) GROUP BY `a`.`id_anggota` ORDER BY sum(`dp`.`jumlah`) DESC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_buku_terlaris`
--
DROP TABLE IF EXISTS `view_buku_terlaris`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_buku_terlaris`  AS SELECT `b`.`judul` AS `judul`, sum(`dp`.`jumlah`) AS `total_dipinjam` FROM (`detail_pinjam` `dp` join `buku` `b` on(`dp`.`id_buku` = `b`.`id_buku`)) GROUP BY `dp`.`id_buku` ORDER BY sum(`dp`.`jumlah`) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `fk_anggota_akun` (`id_akun`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `create_by` (`create_by`);

--
-- Indeks untuk tabel `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pinjam` (`id_pinjam`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD KEY `id_akun` (`id_akun`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `fk_anggota_akun` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `akun` (`id_akun`);

--
-- Ketidakleluasaan untuk tabel `detail_pinjam`
--
ALTER TABLE `detail_pinjam`
  ADD CONSTRAINT `detail_pinjam_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`),
  ADD CONSTRAINT `detail_pinjam_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `akun` (`id_akun`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`);

--
-- Ketidakleluasaan untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
