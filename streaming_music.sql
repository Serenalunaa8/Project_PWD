-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 07:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streaming_music`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `bio`, `image_url`, `created_at`) VALUES
(1, 'Hindia', 'Hindia adalah penyanyi Indonesia dengan gaya musik alternatif dan lirik puitis.', 'upload/cover_music/cover_artis/hindia.jpg', '2025-05-16 12:19:46'),
(2, 'Ariana Grande', 'Ariana adalah penyanyi pop asal Amerika yang dikenal dengan suara tinggi dan lagu-lagu hit.', 'upload/cover_music/cover_artis/ariana.jpg', '2025-05-16 12:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `song_id`, `created_at`) VALUES
(1, 1, 1, '2025-05-13 14:38:49'),
(2, 2, 2, '2025-05-13 14:38:49'),
(15, 3, 18, '2025-06-02 08:50:03'),
(17, 3, 10, '2025-06-02 08:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(3, 'Hip Hop'),
(4, 'Jazz'),
(1, 'Pop'),
(2, 'Rock');

-- --------------------------------------------------------

--
-- Table structure for table `play_history`
--

CREATE TABLE `play_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `song_id` bigint(20) UNSIGNED DEFAULT NULL,
  `played_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `play_history`
--

INSERT INTO `play_history` (`id`, `user_id`, `song_id`, `played_at`) VALUES
(1, 3, 3, '2025-06-01 14:28:45'),
(2, 3, 3, '2025-06-01 15:54:28'),
(3, 3, 5, '2025-06-01 15:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `song_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `song_url` text NOT NULL,
  `play_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_play` int(225) NOT NULL,
  `tgl_rilis` date NOT NULL,
  `cover_image_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `artist_id`, `title`, `song_url`, `play_count`, `created_at`, `user_play`, `tgl_rilis`, `cover_image_url`) VALUES
(1, 1, 'semua lagu cinta terdengar sama', 'upload/songs/Hindia/semua lagu cinta terdengar sama.mp3', 29928743, '2025-05-14 16:14:25', 0, '0000-00-00', 'upload/cover_music/4f47be92df2b8f160b23e5ef066609b7.1000x1000x1.png'),
(2, 1, 'everything u are', 'upload/songs/Hindia/everything u are.mp3', 23289400, '2025-05-14 16:57:34', 0, '0000-00-00', 'upload/cover_music/4f47be92df2b8f160b23e5ef066609b7.1000x1000x1.png'),
(3, 1, 'Evaluasi', 'upload/songs/Hindia/Evaluasi.mp3\r\n', 396408424, '2025-05-14 17:02:55', 0, '0000-00-00', 'upload/cover_music/evaluasi.jpg'),
(4, 1, 'Secukupnya', 'upload/songs/Hindia/Secukupnya.mp3', 908888, '2025-05-15 06:37:14', 0, '0000-00-00', 'upload/cover_music/secukupnya.jpg'),
(5, 1, 'Berdansalah, Karir Tak Ada Artinya', 'upload/songs/Hindia/Berdansalah, Karir Tak Ada Artinya.mp3', 123432114, '2025-05-16 08:15:16', 0, '0000-00-00', 'upload/cover_music/berdansalah.jpg'),
(6, 1, 'Evakuasi', 'upload/songs/Hindia/Evakuasi.mp3', 123456, '2025-05-16 08:15:16', 0, '0000-00-00', 'upload/cover_music/evakuasi.png'),
(7, 1, 'Cincin', 'upload/songs/Hindia/Hindia - Cincin (Official Lyric Video).mp3', 998754, '2025-05-16 08:15:16', 0, '0000-00-00', 'upload/cover_music/cincin.jfif'),
(8, 1, 'Rumah Ke rumah', 'upload/songs/Hindia/Hindia - Rumah Ke Rumah (Official Lyric & Commentary Video).mp3', 7866699, '2025-05-16 08:15:16', 0, '0000-00-00', 'upload/cover_music/hindia/cincin.jpg'),
(9, 1, 'Membasuh', 'upload/songs/Hindia/Hindia ft.Rara Sekar - Membasuh.mp3', 908765, '2025-05-16 08:15:16', 0, '0000-00-00', 'upload/cover_music/hindia/cincin.jpg'),
(10, 2, 'Into You', 'upload/songs/Ariana Grande/Ariana Grande - Into You (Official Video).mp3', 1613014390, '2025-05-16 11:58:26', 0, '0000-00-00', 'upload/cover_music/ariana/into end of the.jpg'),
(11, 2, 'into (end of the world)', 'upload/songs/Ariana Grande/Ariana Grande - intro (end of the world) (lyric visualizer).mp3', 349088878, '2025-05-16 11:58:26', 0, '0000-00-00', 'upload/cover_music/ariana/into end of the.jpg'),
(15, 2, 'we can\'t be friends (wait for your love)', 'upload/songs/Ariana Grande/Ariana Grande - we can\'t be friends (wait for your love) (official music video).mp3', 67890000, '2025-05-16 12:04:01', 0, '0000-00-00', 'upload/cover_music/ariana/into end of the.jpg'),
(18, 2, 'Everyday', 'upload/songs/Ariana Grande/Ariana Grande ft. Future - Everyday (Official Video) ft. Future.mp3', 98987666, '2025-05-16 12:04:28', 0, '0000-00-00', 'upload/cover_music/ariana/ariana.jpg'),
(20, 2, 'positions', 'upload/songs/Ariana Grande/Ariana Grande - positio...', 222222, '2025-06-02 15:54:08', 0, '0000-00-00', 'upload/cover_music/ariana/position.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `song_genres`
--

CREATE TABLE `song_genres` (
  `song_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `song_genres`
--

INSERT INTO `song_genres` (`song_id`, `genre_id`) VALUES
(1, 4),
(2, 2),
(3, 1),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 1),
(9, 1),
(10, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 4),
(15, 4),
(16, 4),
(17, 3),
(18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `trending`
--

CREATE TABLE `trending` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `week_start` date NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trending`
--

INSERT INTO `trending` (`id`, `song_id`, `week_start`, `rank`) VALUES
(1, 2, '2025-05-12', 1),
(2, 1, '2025-05-12', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_profile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `foto_profile`) VALUES
(3, 'cismis', 'serena@gmail.com', '12345', '2025-05-13 14:49:27', '0'),
(4, 'ikram', 'ikram@gmail.com', '12345', '2025-06-02 00:12:34', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `play_history`
--
ALTER TABLE `play_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`user_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_songs_artist` (`artist_id`);

--
-- Indexes for table `song_genres`
--
ALTER TABLE `song_genres`
  ADD PRIMARY KEY (`song_id`,`genre_id`);

--
-- Indexes for table `trending`
--
ALTER TABLE `trending`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `play_history`
--
ALTER TABLE `play_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `trending`
--
ALTER TABLE `trending`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `play_history`
--
ALTER TABLE `play_history`
  ADD CONSTRAINT `play_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `play_history_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`);

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`);

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `fk_songs_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
