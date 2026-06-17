-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 11:17 AM
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
-- Database: `presentase`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_preferensi`
--

CREATE TABLE `data_preferensi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `desain` int(11) DEFAULT NULL,
  `kenyamanan` int(11) DEFAULT NULL,
  `durasi_tidur` int(11) DEFAULT NULL,
  `random_forest` int(11) DEFAULT NULL,
  `gradient_boosting` int(11) DEFAULT NULL,
  `naive_bayes` int(11) DEFAULT NULL,
  `kmeans_cluster` int(11) DEFAULT NULL,
  `kesimpulan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_preferensi`
--

INSERT INTO `data_preferensi` (`id`, `nama`, `jenis_kelamin`, `usia`, `harga`, `desain`, `kenyamanan`, `durasi_tidur`, `random_forest`, `gradient_boosting`, `naive_bayes`, `kmeans_cluster`, `kesimpulan`, `created_at`) VALUES
(601, 'Kece Series', 'P', 23, 4, 3, 1, 10, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(602, 'Kece Series', 'L', 26, 3, 5, 3, 9, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(603, 'Premium Series', 'P', 22, 1, 3, 4, 4, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(604, 'Kece Series', 'P', 45, 5, 4, 3, 7, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(605, 'Deluxe Series', 'L', 56, 5, 5, 3, 4, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(606, 'Sultan Series', 'P', 50, 1, 2, 1, 7, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(607, 'Kasur Lipat Tebal Yuureco', 'P', 22, 4, 4, 5, 10, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(608, 'Premium Series', 'P', 18, 3, 2, 4, 8, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(609, 'Signature Series', 'P', 29, 2, 5, 4, 7, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(610, 'Deluxe Series', 'L', 19, 3, 3, 3, 7, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(611, 'Premium Series', 'P', 23, 1, 4, 1, 10, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(612, 'Kids Signature Series', 'P', 48, 1, 5, 3, 7, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(613, 'Premium Series', 'L', 41, 2, 1, 1, 10, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(614, 'Splendor Series', 'P', 41, 2, 5, 3, 8, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(615, 'Kece Series', 'L', 47, 1, 3, 4, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(616, 'Royale Series', 'P', 51, 5, 5, 2, 6, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(617, 'Kids Signature Series', 'L', 35, 5, 2, 2, 6, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(618, 'Premium Series', 'L', 50, 2, 1, 2, 6, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(619, 'Kids Signature Series', 'L', 52, 2, 4, 4, 9, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(620, 'Dakron Silikon Grade A Yuureco', 'P', 39, 4, 2, 5, 5, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(621, 'Dakron Silikon Grade A Yuureco', 'L', 21, 3, 4, 3, 9, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(622, 'Deluxe Series', 'P', 30, 2, 4, 1, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(623, 'Kasur Lipat Tebal Yuureco', 'P', 41, 1, 3, 1, 6, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(624, 'Dakron Silikon Grade A Yuureco', 'P', 37, 1, 4, 5, 10, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(625, 'Deluxe Series', 'P', 33, 4, 5, 5, 6, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(626, 'Kece Series', 'P', 60, 4, 2, 4, 8, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(627, 'Kids Signature Series', 'L', 56, 1, 4, 5, 8, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(628, 'Sultan Series', 'L', 22, 3, 3, 2, 7, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(629, 'Kece Series', 'P', 28, 2, 1, 3, 8, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(630, 'Deluxe Series', 'L', 36, 5, 1, 1, 7, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(631, 'Sultan Series', 'P', 46, 1, 1, 5, 7, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(632, 'Royale Series', 'L', 31, 2, 1, 2, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(633, 'Sultan Series', 'P', 53, 1, 1, 2, 9, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(634, 'Premium Series', 'P', 60, 3, 2, 5, 4, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(635, 'Sultan Series', 'L', 50, 4, 4, 5, 5, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(636, 'Splendor Series', 'L', 48, 1, 2, 1, 7, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(637, 'Kids Signature Series', 'P', 41, 2, 4, 1, 4, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(638, 'Signature Series', 'P', 29, 4, 2, 4, 5, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(639, 'Kece Series', 'L', 27, 2, 4, 4, 5, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(640, 'Premium Series', 'P', 23, 2, 1, 3, 7, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(641, 'Kids Signature Series', 'L', 23, 1, 3, 3, 9, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(642, 'Kece Series', 'L', 25, 2, 3, 2, 5, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(643, 'Kids Signature Series', 'P', 58, 2, 4, 1, 8, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(644, 'Kece Series', 'P', 50, 1, 3, 1, 7, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(645, 'Dakron Silikon Grade A Yuureco', 'L', 43, 1, 2, 2, 9, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(646, 'Kasur Lipat Tebal Yuureco', 'L', 42, 1, 3, 1, 10, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(647, 'Premium Series', 'L', 56, 1, 3, 1, 4, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(648, 'Royale Series', 'P', 44, 1, 5, 3, 8, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(649, 'Splendor Series', 'P', 33, 1, 1, 1, 8, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(650, 'Royale Series', 'L', 42, 1, 4, 2, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(651, 'Royale Series', 'P', 44, 2, 4, 3, 4, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(652, 'Dakron Silikon Grade A Yuureco', 'L', 58, 5, 2, 3, 6, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(653, 'Splendor Series', 'L', 45, 2, 4, 1, 7, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(654, 'Kece Series', 'L', 22, 4, 5, 2, 7, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(655, 'Premium Series', 'P', 20, 5, 3, 1, 5, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(656, 'Kece Series', 'P', 48, 5, 4, 3, 9, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(657, 'Premium Series', 'L', 20, 2, 2, 2, 10, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(658, 'Splendor Series', 'P', 44, 2, 5, 5, 10, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(659, 'Dakron Silikon Grade A Yuureco', 'L', 47, 2, 5, 4, 4, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(660, 'Splendor Series', 'P', 30, 2, 1, 3, 4, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(661, 'Royale Series', 'L', 60, 5, 1, 2, 8, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(662, 'Kasur Lipat Tebal Yuureco', 'L', 58, 5, 4, 3, 6, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(663, 'Deluxe Series', 'L', 33, 1, 1, 5, 9, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(664, 'Royale Series', 'L', 43, 2, 5, 2, 8, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(665, 'Royale Series', 'P', 40, 5, 4, 2, 4, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(666, 'Kece Series', 'P', 44, 1, 3, 4, 7, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(667, 'Kids Signature Series', 'P', 38, 2, 5, 5, 7, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(668, 'Royale Series', 'P', 30, 4, 4, 1, 6, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(669, 'Splendor Series', 'L', 40, 2, 1, 1, 8, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(670, 'Sultan Series', 'P', 49, 1, 2, 2, 6, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(671, 'Deluxe Series', 'L', 43, 1, 3, 5, 7, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(672, 'Premium Series', 'P', 29, 2, 1, 1, 7, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(673, 'Kece Series', 'P', 21, 1, 3, 5, 7, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(674, 'Premium Series', 'P', 56, 2, 1, 1, 7, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(675, 'Splendor Series', 'P', 36, 2, 3, 5, 7, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(676, 'Deluxe Series', 'L', 31, 3, 2, 4, 8, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(677, 'Deluxe Series', 'P', 39, 4, 4, 4, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(678, 'Sultan Series', 'P', 24, 5, 3, 4, 8, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(679, 'Sultan Series', 'P', 57, 3, 5, 2, 10, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(680, 'Sultan Series', 'L', 55, 4, 5, 1, 6, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(681, 'Dakron Silikon Grade A Yuureco', 'L', 26, 3, 4, 2, 5, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(682, 'Signature Series', 'P', 30, 5, 5, 1, 10, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(683, 'Royale Series', 'L', 39, 5, 2, 3, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(684, 'Signature Series', 'L', 29, 4, 4, 2, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(685, 'Royale Series', 'L', 37, 2, 4, 2, 8, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(686, 'Deluxe Series', 'P', 45, 4, 5, 2, 8, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(687, 'Deluxe Series', 'L', 55, 2, 2, 5, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(688, 'Splendor Series', 'L', 19, 4, 4, 2, 8, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(689, 'Splendor Series', 'P', 35, 2, 2, 5, 5, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(690, 'Kasur Lipat Tebal Yuureco', 'P', 49, 1, 2, 4, 6, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(691, 'Deluxe Series', 'L', 27, 3, 3, 2, 7, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(692, 'Deluxe Series', 'P', 40, 3, 1, 2, 6, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(693, 'Kece Series', 'P', 41, 4, 4, 4, 5, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(694, 'Kids Signature Series', 'L', 46, 2, 5, 2, 9, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(695, 'Splendor Series', 'P', 43, 5, 4, 1, 9, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(696, 'Dakron Silikon Grade A Yuureco', 'L', 27, 5, 3, 4, 10, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(697, 'Deluxe Series', 'L', 33, 1, 3, 2, 10, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(698, 'Royale Series', 'L', 51, 2, 2, 3, 10, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(699, 'Dakron Silikon Grade A Yuureco', 'P', 34, 3, 2, 1, 5, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(700, 'Royale Series', 'P', 35, 4, 5, 4, 8, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(701, 'Deluxe Series', 'P', 32, 1, 5, 4, 4, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(702, 'Kece Series', 'L', 22, 5, 5, 5, 7, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(703, 'Sultan Series', 'L', 51, 5, 2, 2, 4, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(704, 'Splendor Series', 'L', 52, 4, 3, 2, 5, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(705, 'Signature Series', 'P', 24, 5, 4, 1, 9, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(706, 'Dakron Silikon Grade A Yuureco', 'P', 39, 1, 2, 2, 10, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(707, 'Dakron Silikon Grade A Yuureco', 'P', 30, 5, 3, 3, 7, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(708, 'Dakron Silikon Grade A Yuureco', 'P', 28, 4, 4, 5, 4, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(709, 'Kece Series', 'P', 43, 4, 2, 2, 6, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(710, 'Dakron Silikon Grade A Yuureco', 'L', 34, 2, 4, 2, 8, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(711, 'Premium Series', 'L', 60, 2, 2, 1, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(712, 'Sultan Series', 'P', 53, 1, 5, 3, 9, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(713, 'Kids Signature Series', 'L', 40, 5, 5, 5, 9, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(714, 'Kids Signature Series', 'P', 25, 1, 4, 1, 8, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(715, 'Premium Series', 'L', 39, 2, 3, 2, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(716, 'Premium Series', 'L', 48, 3, 5, 2, 9, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(717, 'Dakron Silikon Grade A Yuureco', 'L', 25, 4, 1, 4, 4, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(718, 'Dakron Silikon Grade A Yuureco', 'L', 53, 2, 2, 2, 5, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(719, 'Splendor Series', 'L', 33, 2, 1, 3, 6, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(720, 'Splendor Series', 'L', 22, 3, 1, 5, 9, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(721, 'Deluxe Series', 'L', 53, 4, 4, 1, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(722, 'Sultan Series', 'L', 51, 5, 1, 5, 9, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(723, 'Dakron Silikon Grade A Yuureco', 'L', 57, 5, 3, 3, 4, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(724, 'Kasur Lipat Tebal Yuureco', 'L', 34, 4, 4, 3, 4, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(725, 'Kasur Lipat Tebal Yuureco', 'P', 52, 5, 3, 4, 9, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(726, 'Deluxe Series', 'P', 22, 1, 4, 2, 7, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(727, 'Kids Signature Series', 'P', 60, 5, 5, 5, 9, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(728, 'Royale Series', 'L', 48, 4, 2, 4, 9, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(729, 'Premium Series', 'L', 57, 5, 3, 3, 5, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(730, 'Signature Series', 'L', 51, 4, 3, 4, 10, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(731, 'Deluxe Series', 'L', 47, 1, 2, 2, 10, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(732, 'Royale Series', 'P', 23, 4, 3, 2, 7, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(733, 'Kasur Lipat Tebal Yuureco', 'L', 32, 4, 4, 2, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(734, 'Signature Series', 'P', 32, 1, 1, 3, 6, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(735, 'Deluxe Series', 'L', 19, 5, 2, 1, 5, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(736, 'Signature Series', 'P', 48, 5, 5, 3, 5, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(737, 'Dakron Silikon Grade A Yuureco', 'P', 31, 4, 5, 3, 9, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(738, 'Splendor Series', 'L', 49, 1, 4, 2, 6, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(739, 'Premium Series', 'L', 55, 4, 3, 1, 5, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(740, 'Deluxe Series', 'P', 20, 5, 4, 4, 5, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(741, 'Kasur Lipat Tebal Yuureco', 'P', 40, 1, 2, 2, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(742, 'Sultan Series', 'P', 60, 2, 5, 1, 4, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(743, 'Premium Series', 'L', 38, 4, 4, 5, 10, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(744, 'Sultan Series', 'L', 29, 1, 4, 1, 6, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(745, 'Royale Series', 'L', 32, 3, 3, 5, 10, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(746, 'Royale Series', 'P', 53, 1, 3, 3, 6, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(747, 'Kece Series', 'P', 23, 3, 1, 5, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(748, 'Splendor Series', 'P', 39, 5, 4, 3, 8, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(749, 'Deluxe Series', 'P', 33, 1, 2, 3, 7, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(750, 'Kasur Lipat Tebal Yuureco', 'L', 30, 4, 2, 3, 9, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(751, 'Kids Signature Series', 'L', 25, 5, 2, 3, 6, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(752, 'Splendor Series', 'L', 38, 4, 5, 3, 10, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(753, 'Kece Series', 'L', 42, 5, 2, 5, 10, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(754, 'Splendor Series', 'L', 25, 2, 4, 3, 5, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(755, 'Premium Series', 'P', 25, 4, 1, 4, 9, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(756, 'Kasur Lipat Tebal Yuureco', 'L', 29, 1, 1, 5, 5, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(757, 'Kasur Lipat Tebal Yuureco', 'L', 48, 4, 3, 2, 6, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(758, 'Kasur Lipat Tebal Yuureco', 'L', 35, 5, 1, 5, 4, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(759, 'Deluxe Series', 'P', 47, 1, 1, 2, 4, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(760, 'Signature Series', 'L', 36, 5, 1, 4, 7, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(761, 'Royale Series', 'P', 49, 2, 1, 5, 7, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(762, 'Kids Signature Series', 'L', 40, 1, 1, 4, 9, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(763, 'Kids Signature Series', 'P', 49, 5, 1, 5, 6, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(764, 'Sultan Series', 'P', 51, 3, 3, 3, 10, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(765, 'Sultan Series', 'L', 35, 3, 2, 2, 10, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(766, 'Sultan Series', 'L', 48, 2, 4, 3, 4, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(767, 'Premium Series', 'P', 51, 2, 3, 2, 6, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(768, 'Premium Series', 'P', 39, 5, 2, 5, 8, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(769, 'Kasur Lipat Tebal Yuureco', 'L', 36, 3, 2, 4, 6, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(770, 'Dakron Silikon Grade A Yuureco', 'P', 21, 2, 2, 4, 9, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(771, 'Splendor Series', 'L', 18, 5, 2, 2, 6, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(772, 'Kids Signature Series', 'P', 57, 4, 3, 5, 4, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(773, 'Signature Series', 'P', 44, 2, 3, 3, 7, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(774, 'Kids Signature Series', 'P', 30, 4, 4, 5, 6, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(775, 'Kasur Lipat Tebal Yuureco', 'L', 21, 3, 1, 2, 10, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(776, 'Kece Series', 'L', 26, 2, 2, 4, 5, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(777, 'Dakron Silikon Grade A Yuureco', 'L', 28, 1, 4, 5, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(778, 'Premium Series', 'P', 58, 3, 2, 1, 9, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(779, 'Dakron Silikon Grade A Yuureco', 'L', 21, 1, 5, 3, 8, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(780, 'Dakron Silikon Grade A Yuureco', 'P', 42, 1, 3, 3, 5, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(781, 'Kece Series', 'P', 19, 2, 4, 1, 7, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(782, 'Sultan Series', 'P', 57, 4, 5, 3, 10, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(783, 'Kids Signature Series', 'P', 51, 3, 4, 2, 10, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(784, 'Kids Signature Series', 'L', 57, 4, 3, 1, 6, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(785, 'Royale Series', 'P', 40, 1, 4, 3, 4, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(786, 'Kece Series', 'L', 57, 4, 1, 5, 8, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(787, 'Signature Series', 'P', 48, 1, 3, 1, 10, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(788, 'Premium Series', 'P', 56, 2, 3, 2, 6, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(789, 'Signature Series', 'P', 60, 2, 1, 3, 8, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(790, 'Kids Signature Series', 'L', 26, 4, 1, 3, 5, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(791, 'Premium Series', 'L', 48, 4, 1, 1, 5, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(792, 'Kasur Lipat Tebal Yuureco', 'L', 42, 4, 4, 5, 9, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(793, 'Kids Signature Series', 'P', 48, 1, 4, 4, 6, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(794, 'Kasur Lipat Tebal Yuureco', 'P', 51, 4, 3, 1, 7, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(795, 'Sultan Series', 'L', 55, 3, 1, 1, 4, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(796, 'Kasur Lipat Tebal Yuureco', 'L', 27, 5, 5, 1, 9, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(797, 'Kids Signature Series', 'L', 25, 3, 4, 2, 4, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(798, 'Kids Signature Series', 'L', 18, 3, 1, 2, 6, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(799, 'Premium Series', 'L', 60, 5, 3, 4, 7, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(800, 'Premium Series', 'L', 57, 2, 3, 1, 5, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(801, 'Sultan Series', 'L', 45, 3, 3, 4, 8, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(802, 'Deluxe Series', 'P', 42, 3, 3, 1, 7, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(803, 'Kasur Lipat Tebal Yuureco', 'L', 33, 1, 4, 1, 5, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(804, 'Dakron Silikon Grade A Yuureco', 'L', 48, 3, 3, 4, 6, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(805, 'Dakron Silikon Grade A Yuureco', 'L', 35, 5, 1, 5, 10, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(806, 'Royale Series', 'L', 32, 4, 1, 4, 4, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(807, 'Splendor Series', 'L', 39, 3, 2, 3, 9, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(808, 'Splendor Series', 'P', 31, 4, 1, 5, 10, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(809, 'Premium Series', 'L', 45, 4, 5, 5, 9, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(810, 'Signature Series', 'P', 56, 1, 5, 1, 10, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(811, 'Kece Series', 'L', 46, 1, 3, 2, 8, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(812, 'Royale Series', 'L', 35, 1, 1, 3, 8, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(813, 'Dakron Silikon Grade A Yuureco', 'L', 22, 5, 1, 2, 9, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(814, 'Dakron Silikon Grade A Yuureco', 'L', 52, 3, 1, 3, 9, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(815, 'Kece Series', 'P', 32, 3, 2, 1, 10, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(816, 'Royale Series', 'L', 56, 5, 5, 4, 9, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(817, 'Premium Series', 'P', 18, 2, 4, 5, 5, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(818, 'Royale Series', 'P', 38, 3, 2, 5, 6, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(819, 'Signature Series', 'P', 24, 1, 3, 5, 6, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(820, 'Kece Series', 'L', 32, 4, 2, 1, 8, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(821, 'Dakron Silikon Grade A Yuureco', 'P', 33, 2, 5, 1, 9, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(822, 'Deluxe Series', 'L', 56, 3, 1, 2, 6, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(823, 'Deluxe Series', 'L', 52, 1, 1, 4, 9, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(824, 'Splendor Series', 'L', 44, 2, 2, 2, 8, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(825, 'Dakron Silikon Grade A Yuureco', 'P', 40, 1, 1, 5, 6, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(826, 'Kids Signature Series', 'L', 26, 5, 1, 5, 9, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(827, 'Kasur Lipat Tebal Yuureco', 'L', 23, 4, 2, 2, 8, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(828, 'Kece Series', 'P', 21, 2, 1, 4, 4, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(829, 'Royale Series', 'L', 55, 4, 2, 5, 9, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(830, 'Kids Signature Series', 'L', 44, 5, 3, 5, 8, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(831, 'Signature Series', 'L', 27, 1, 1, 1, 7, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(832, 'Dakron Silikon Grade A Yuureco', 'P', 30, 5, 4, 1, 4, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(833, 'Deluxe Series', 'L', 28, 2, 4, 1, 8, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(834, 'Sultan Series', 'P', 41, 5, 1, 1, 8, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(835, 'Royale Series', 'P', 39, 1, 2, 3, 10, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(836, 'Kasur Lipat Tebal Yuureco', 'P', 18, 1, 1, 5, 10, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(837, 'Kids Signature Series', 'L', 55, 2, 5, 1, 5, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(838, 'Signature Series', 'P', 32, 5, 3, 4, 4, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(839, 'Premium Series', 'L', 43, 1, 5, 5, 10, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(840, 'Kasur Lipat Tebal Yuureco', 'P', 35, 4, 1, 5, 10, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(841, 'Deluxe Series', 'P', 50, 1, 1, 3, 7, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(842, 'Kids Signature Series', 'P', 38, 4, 2, 5, 5, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(843, 'Kids Signature Series', 'L', 21, 4, 4, 3, 7, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(844, 'Kasur Lipat Tebal Yuureco', 'P', 18, 5, 2, 2, 10, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(845, 'Kece Series', 'L', 27, 3, 5, 4, 9, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(846, 'Signature Series', 'P', 46, 1, 5, 5, 7, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(847, 'Kids Signature Series', 'L', 49, 1, 5, 3, 4, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(848, 'Premium Series', 'P', 39, 1, 2, 4, 10, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(849, 'Deluxe Series', 'P', 49, 5, 1, 1, 9, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(850, 'Kids Signature Series', 'L', 37, 4, 2, 2, 7, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(851, 'Premium Series', 'P', 30, 4, 2, 2, 10, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(852, 'Kece Series', 'L', 23, 3, 1, 1, 5, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(853, 'Kasur Lipat Tebal Yuureco', 'P', 52, 3, 1, 2, 8, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(854, 'Sultan Series', 'L', 47, 5, 3, 5, 4, 0, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(855, 'Kece Series', 'L', 25, 3, 4, 1, 10, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(856, 'Kece Series', 'L', 21, 4, 1, 3, 6, 0, 1, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(857, 'Deluxe Series', 'P', 42, 1, 4, 2, 9, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(858, 'Kasur Lipat Tebal Yuureco', 'P', 38, 2, 3, 3, 6, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(859, 'Kece Series', 'L', 19, 4, 2, 5, 8, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(860, 'Sultan Series', 'L', 52, 4, 1, 4, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(861, 'Kece Series', 'L', 33, 3, 4, 3, 6, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(862, 'Sultan Series', 'P', 42, 4, 5, 5, 8, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(863, 'Royale Series', 'L', 35, 4, 1, 5, 6, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(864, 'Signature Series', 'L', 58, 2, 1, 3, 6, 0, 0, 1, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(865, 'Premium Series', 'P', 33, 4, 5, 1, 10, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(866, 'Kece Series', 'L', 60, 2, 4, 5, 10, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(867, 'Dakron Silikon Grade A Yuureco', 'P', 53, 3, 4, 1, 6, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(868, 'Kids Signature Series', 'L', 26, 5, 1, 4, 6, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(869, 'Deluxe Series', 'L', 20, 2, 5, 1, 5, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(870, 'Splendor Series', 'L', 52, 1, 3, 3, 8, 1, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(871, 'Sultan Series', 'P', 47, 3, 4, 1, 5, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(872, 'Kids Signature Series', 'P', 39, 2, 2, 1, 7, 1, 1, 0, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(873, 'Signature Series', 'L', 41, 3, 2, 2, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(874, 'Premium Series', 'P', 28, 4, 1, 5, 10, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(875, 'Dakron Silikon Grade A Yuureco', 'P', 20, 5, 4, 2, 10, 1, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(876, 'Dakron Silikon Grade A Yuureco', 'L', 48, 3, 1, 2, 7, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(877, 'Kids Signature Series', 'P', 35, 3, 2, 5, 6, 1, 0, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(878, 'Premium Series', 'P', 39, 1, 2, 3, 4, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(879, 'Dakron Silikon Grade A Yuureco', 'P', 51, 1, 2, 5, 5, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(880, 'Sultan Series', 'L', 44, 2, 1, 1, 7, 0, 0, 1, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(881, 'Premium Series', 'P', 47, 1, 4, 1, 10, 1, 1, 1, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(882, 'Splendor Series', 'P', 30, 4, 3, 1, 8, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(883, 'Kece Series', 'L', 32, 3, 5, 5, 8, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(884, 'Dakron Silikon Grade A Yuureco', 'P', 49, 4, 1, 5, 7, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(885, 'Kasur Lipat Tebal Yuureco', 'L', 47, 4, 3, 1, 5, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(886, 'Kece Series', 'P', 38, 3, 4, 5, 10, 1, 0, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(887, 'Sultan Series', 'P', 23, 2, 2, 5, 10, 1, 1, 0, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(888, 'Sultan Series', 'P', 35, 2, 2, 3, 7, 0, 1, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(889, 'Kids Signature Series', 'P', 47, 1, 5, 4, 4, 0, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(890, 'Signature Series', 'L', 36, 1, 2, 4, 4, 0, 0, 0, 2, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(891, 'Premium Series', 'L', 48, 5, 3, 2, 10, 1, 1, 1, 1, 'Direkomendasikan', '2026-06-17 03:16:19'),
(892, 'Kasur Lipat Tebal Yuureco', 'L', 41, 5, 5, 5, 4, 0, 0, 1, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(893, 'Royale Series', 'L', 57, 1, 3, 1, 8, 1, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(894, 'Splendor Series', 'L', 49, 3, 1, 2, 8, 0, 1, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(895, 'Premium Series', 'L', 44, 1, 4, 5, 6, 0, 0, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(896, 'Kids Signature Series', 'P', 55, 2, 5, 2, 5, 0, 1, 0, 1, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(897, 'Signature Series', 'L', 52, 4, 4, 5, 10, 0, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(898, 'Kece Series', 'L', 46, 5, 1, 4, 5, 1, 0, 0, 3, 'Cukup Direkomendasikan', '2026-06-17 03:16:19'),
(899, 'Deluxe Series', 'P', 54, 5, 2, 2, 7, 1, 1, 0, 2, 'Direkomendasikan', '2026-06-17 03:16:19'),
(900, 'Kids Signature Series', 'P', 24, 5, 5, 1, 7, 1, 0, 1, 3, 'Direkomendasikan', '2026-06-17 03:16:19'),
(901, 'a', 'L', 45, 5, 5, 1, 23, 1, 1, 1, 1, 'Menyukai Produk Premium', '2026-06-17 03:17:51'),
(902, 'b', 'P', 12, 4, 4, 2, 12, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 03:22:28'),
(903, 'b', 'P', 12, 4, 4, 2, 12, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 03:22:41'),
(904, 'splendor', 'L', 21, 4, 3, 5, 8, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 03:23:26'),
(905, 'admin', 'L', 23, 4, 2, 4, 21, 1, 1, 1, 1, 'Menyukai Produk Premium', '2026-06-17 07:31:06'),
(906, '231', 'P', 21, 1, 1, 5, 21, 1, 0, 1, 0, 'Menyukai Produk Premium', '2026-06-17 07:31:58'),
(907, '2heheh', 'L', 21, 5, 1, 5, 21, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 07:32:36'),
(908, 'ass', 'L', 12, 1, 1, 1, 12, 1, 0, 1, 0, 'Menyukai Produk Premium', '2026-06-17 07:33:26'),
(909, 'qqq', 'L', 34, 4, 1, 5, 12, 1, 1, 1, 1, 'Menyukai Produk Premium', '2026-06-17 07:57:46'),
(910, 'admin', 'P', 12, 1, 1, 1, 12, 0, 0, 0, 0, 'Tidak Menyukai Produk Premium', '2026-06-17 07:58:16'),
(911, 'a', 'L', 21, 5, 1, 5, 12, 1, 1, 1, 1, 'Menyukai Produk Premium', '2026-06-17 07:58:35'),
(912, '121', 'L', 21, 1, 5, 1, 12, 0, 0, 0, 1, 'Tidak Menyukai Produk Premium', '2026-06-17 07:58:58'),
(913, 'asdf', 'P', 34, 2, 4, 5, 12, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 08:02:57'),
(914, 'asdf', 'P', 34, 2, 4, 5, 12, 1, 1, 1, 0, 'Menyukai Produk Premium', '2026-06-17 08:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '12345', '2026-06-15 07:37:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_preferensi`
--
ALTER TABLE `data_preferensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_preferensi`
--
ALTER TABLE `data_preferensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=915;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
