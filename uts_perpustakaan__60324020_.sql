
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `kode_kategori` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Aktif','Nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `kategori` (`id_kategori`, `kode_kategori`, `nama_kategori`, `deskripsi`, `status`, `created_at`) VALUES
(1, 'KAT-001', 'Pemrograman', 'Buku-buku tentang bahasa pemrograman', 'Aktif', '2026-05-04 13:49:32'),
(2, 'KAT-002', 'Database', 'Buku-buku tentang sistem basis data', 'Aktif', '2026-05-04 13:49:32'),
(3, 'KAT-003', 'Jaringan', 'Buku-buku tentang jaringan komputer', 'Aktif', '2026-05-04 13:49:32'),
(4, 'KAT-005', 'Dasar Desain', 'Untuk Pemula', 'Aktif', '2026-05-04 15:06:22');


ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);

ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
