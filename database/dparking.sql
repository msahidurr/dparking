-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2023 at 08:48 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 7.3.33-11+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dparking`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED DEFAULT 1,
  `type` varchar(50) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `limit_count` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_wise_floor_slots`
--

CREATE TABLE `category_wise_floor_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `slot_name` varchar(191) NOT NULL,
  `slotId` varchar(191) NOT NULL,
  `identity` varchar(191) DEFAULT NULL,
  `remarks` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'af', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(2, 'Åland Islands', 'ax', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(3, 'Albania', 'al', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(4, 'Algeria', 'dz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(5, 'American Samoa', 'as', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(6, 'Andorra', 'ad', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(7, 'Angola', 'ao', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(8, 'Anguilla', 'ai', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(9, 'Antarctica', 'aq', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(10, 'Antigua and Barbuda', 'ag', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(11, 'Argentina', 'ar', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(12, 'Armenia', 'am', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(13, 'Aruba', 'aw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(14, 'Australia', 'au', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(15, 'Austria', 'at', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(16, 'Azerbaijan', 'az', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(17, 'Bahamas', 'bs', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(18, 'Bahrain', 'bh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(19, 'Bangladesh', 'bd', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(20, 'Barbados', 'bb', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(21, 'Belarus', 'by', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(22, 'Belgium', 'be', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(23, 'Belize', 'bz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(24, 'Benin', 'bj', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(25, 'Bermuda', 'bm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(26, 'Bhutan', 'bt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(27, 'Bolivia (Plurinational State of)', 'bo', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(28, 'Bonaire, Sint Eustatius and Saba', 'bq', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(29, 'Bosnia and Herzegovina', 'ba', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(30, 'Botswana', 'bw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(31, 'Bouvet Island', 'bv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(32, 'Brazil', 'br', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(33, 'British Indian Ocean Territory', 'io', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(34, 'Brunei Darussalam', 'bn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(35, 'Bulgaria', 'bg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(36, 'Burkina Faso', 'bf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(37, 'Burundi', 'bi', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(38, 'Cabo Verde', 'cv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(39, 'Cambodia', 'kh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(40, 'Cameroon', 'cm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(41, 'Canada', 'ca', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(42, 'Cayman Islands', 'ky', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(43, 'Central African Republic', 'cf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(44, 'Chad', 'td', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(45, 'Chile', 'cl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(46, 'China', 'cn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(47, 'Christmas Island', 'cx', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(48, 'Cocos (Keeling) Islands', 'cc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(49, 'Colombia', 'co', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(50, 'Comoros', 'km', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(51, 'Congo', 'cg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(52, 'Congo, Democratic Republic of the', 'cd', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(53, 'Cook Islands', 'ck', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(54, 'Costa Rica', 'cr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(55, 'Côte dIvoire', 'ci', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(56, 'Croatia', 'hr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(57, 'Cuba', 'cu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(58, 'Curaçao', 'cw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(59, 'Cyprus', 'cy', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(60, 'Czechia', 'cz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(61, 'Denmark', 'dk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(62, 'Djibouti', 'dj', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(63, 'Dominica', 'dm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(64, 'Dominican Republic', 'do', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(65, 'Ecuador', 'ec', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(66, 'Egypt', 'eg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(67, 'El Salvador', 'sv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(68, 'Equatorial Guinea', 'gq', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(69, 'Eritrea', 'er', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(70, 'Estonia', 'ee', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(71, 'Eswatini', 'sz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(72, 'Ethiopia', 'et', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(73, 'Falkland Islands (Malvinas)', 'fk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(74, 'Faroe Islands', 'fo', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(75, 'Fiji', 'fj', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(76, 'Finland', 'fi', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(77, 'France', 'fr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(78, 'French Guiana', 'gf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(79, 'French Polynesia', 'pf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(80, 'French Southern Territories', 'tf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(81, 'Gabon', 'ga', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(82, 'Gambia', 'gm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(83, 'Georgia', 'ge', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(84, 'Germany', 'de', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(85, 'Ghana', 'gh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(86, 'Gibraltar', 'gi', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(87, 'Greece', 'gr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(88, 'Greenland', 'gl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(89, 'Grenada', 'gd', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(90, 'Guadeloupe', 'gp', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(91, 'Guam', 'gu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(92, 'Guatemala', 'gt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(93, 'Guernsey', 'gg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(94, 'Guinea', 'gn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(95, 'Guinea-Bissau', 'gw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(96, 'Guyana', 'gy', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(97, 'Haiti', 'ht', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(98, 'Heard Island and McDonald Islands', 'hm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(99, 'Holy See', 'va', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(100, 'Honduras', 'hn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(101, 'Hong Kong', 'hk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(102, 'Hungary', 'hu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(103, 'Iceland', 'is', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(104, 'India', 'in', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(105, 'Indonesia', 'id', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(106, 'Iran (Islamic Republic of)', 'ir', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(107, 'Iraq', 'iq', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(108, 'Ireland', 'ie', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(109, 'Isle of Man', 'im', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(110, 'Israel', 'il', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(111, 'Italy', 'it', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(112, 'Jamaica', 'jm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(113, 'Japan', 'jp', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(114, 'Jersey', 'je', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(115, 'Jordan', 'jo', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(116, 'Kazakhstan', 'kz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(117, 'Kenya', 'ke', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(118, 'Kiribati', 'ki', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(119, 'Korea (Democratic Peoples Republic of)', 'kp', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(120, 'Korea, Republic of', 'kr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(121, 'Kuwait', 'kw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(122, 'Kyrgyzstan', 'kg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(123, 'Lao Peoples Democratic Republic', 'la', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(124, 'Latvia', 'lv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(125, 'Lebanon', 'lb', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(126, 'Lesotho', 'ls', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(127, 'Liberia', 'lr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(128, 'Libya', 'ly', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(129, 'Liechtenstein', 'li', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(130, 'Lithuania', 'lt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(131, 'Luxembourg', 'lu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(132, 'Macao', 'mo', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(133, 'Madagascar', 'mg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(134, 'Malawi', 'mw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(135, 'Malaysia', 'my', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(136, 'Maldives', 'mv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(137, 'Mali', 'ml', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(138, 'Malta', 'mt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(139, 'Marshall Islands', 'mh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(140, 'Martinique', 'mq', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(141, 'Mauritania', 'mr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(142, 'Mauritius', 'mu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(143, 'Mayotte', 'yt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(144, 'Mexico', 'mx', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(145, 'Micronesia (Federated States of)', 'fm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(146, 'Moldova, Republic of', 'md', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(147, 'Monaco', 'mc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(148, 'Mongolia', 'mn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(149, 'Montenegro', 'me', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(150, 'Montserrat', 'ms', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(151, 'Morocco', 'ma', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(152, 'Mozambique', 'mz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(153, 'Myanmar', 'mm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(154, 'Namibia', 'na', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(155, 'Nauru', 'nr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(156, 'Nepal', 'np', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(157, 'Netherlands', 'nl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(158, 'New Caledonia', 'nc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(159, 'New Zealand', 'nz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(160, 'Nicaragua', 'ni', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(161, 'Niger', 'ne', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(162, 'Nigeria', 'ng', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(163, 'Niue', 'nu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(164, 'Norfolk Island', 'nf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(165, 'North Macedonia', 'mk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(166, 'Northern Mariana Islands', 'mp', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(167, 'Norway', 'no', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(168, 'Oman', 'om', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(169, 'Pakistan', 'pk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(170, 'Palau', 'pw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(171, 'Palestine, State of', 'ps', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(172, 'Panama', 'pa', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(173, 'Papua New Guinea', 'pg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(174, 'Paraguay', 'py', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(175, 'Peru', 'pe', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(176, 'Philippines', 'ph', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(177, 'Pitcairn', 'pn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(178, 'Poland', 'pl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(179, 'Portugal', 'pt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(180, 'Puerto Rico', 'pr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(181, 'Qatar', 'qa', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(182, 'Réunion', 're', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(183, 'Romania', 'ro', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(184, 'Russian Federation', 'ru', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(185, 'Rwanda', 'rw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(186, 'Saint Barthélemy', 'bl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(187, 'Saint Helena, Ascension and Tristan da Cunha', 'sh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(188, 'Saint Kitts and Nevis', 'kn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(189, 'Saint Lucia', 'lc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(190, 'Saint Martin (French part)', 'mf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(191, 'Saint Pierre and Miquelon', 'pm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(192, 'Saint Vincent and the Grenadines', 'vc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(193, 'Samoa', 'ws', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(194, 'San Marino', 'sm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(195, 'Sao Tome and Principe', 'st', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(196, 'Saudi Arabia', 'sa', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(197, 'Senegal', 'sn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(198, 'Serbia', 'rs', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(199, 'Seychelles', 'sc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(200, 'Sierra Leone', 'sl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(201, 'Singapore', 'sg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(202, 'Sint Maarten (Dutch part)', 'sx', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(203, 'Slovakia', 'sk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(204, 'Slovenia', 'si', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(205, 'Solomon Islands', 'sb', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(206, 'Somalia', 'so', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(207, 'South Africa', 'za', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(208, 'South Georgia and the South Sandwich Islands', 'gs', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(209, 'South Sudan', 'ss', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(210, 'Spain', 'es', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(211, 'Sri Lanka', 'lk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(212, 'Sudan', 'sd', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(213, 'Suriname', 'sr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(214, 'Svalbard and Jan Mayen', 'sj', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(215, 'Sweden', 'se', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(216, 'Switzerland', 'ch', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(217, 'Syrian Arab Republic', 'sy', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(218, 'Taiwan, Province of China', 'tw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(219, 'Tajikistan', 'tj', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(220, 'Tanzania, United Republic of', 'tz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(221, 'Thailand', 'th', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(222, 'Timor-Leste', 'tl', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(223, 'Togo', 'tg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(224, 'Tokelau', 'tk', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(225, 'Tonga', 'to', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(226, 'Trinidad and Tobago', 'tt', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(227, 'Tunisia', 'tn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(228, 'Turkey', 'tr', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(229, 'Turkmenistan', 'tm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(230, 'Turks and Caicos Islands', 'tc', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(231, 'Tuvalu', 'tv', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(232, 'Uganda', 'ug', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(233, 'Ukraine', 'ua', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(234, 'United Arab Emirates', 'ae', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(235, 'United Kingdom of Great Britain and Northern Ireland', 'gb', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(236, 'United States of America', 'us', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(237, 'United States Minor Outlying Islands', 'um', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(238, 'Uruguay', 'uy', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(239, 'Uzbekistan', 'uz', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(240, 'Vanuatu', 'vu', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(241, 'Venezuela (Bolivarian Republic of)', 've', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(242, 'Viet Nam', 'vn', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(243, 'Virgin Islands (British)', 'vg', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(244, 'Virgin Islands (U.S.)', 'vi', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(245, 'Wallis and Futuna', 'wf', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(246, 'Western Sahara', 'eh', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(247, 'Yemen', 'ye', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(248, 'Zambia', 'zm', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29'),
(249, 'Zimbabwe', 'zw', 1, '2023-07-09 21:25:29', '2023-07-09 21:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `name` varchar(191) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `country_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Master', 'master', 236, 2, '2023-07-09 21:25:29', '2023-07-09 21:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_27_184007_create_roles_table', 1),
(4, '2018_03_27_184207_create_role_user_table', 1),
(5, '2018_05_13_105030_add_status_column_in_users_table', 1),
(6, '2018_08_11_101437_create_salt_column_in_users_table', 1),
(7, '2019_02_11_045412_create_categories_table', 1),
(8, '2019_10_24_080706_create_parkings_table', 1),
(9, '2019_10_24_140234_create_tariffs_table', 1),
(10, '2019_10_31_181407_add_limit_on_category_table', 1),
(11, '2022_01_06_144511_create_settings_table', 1),
(12, '2022_01_17_111714_create_floors_table', 1),
(13, '2022_01_17_122657_create_category_wise_floor_slots_table', 1),
(14, '2022_01_19_144319_add_slot_id_in_parkings_table', 1),
(15, '2022_01_19_145300_add_order_id_to_floors_table', 1),
(16, '2022_01_30_124535_change_myisam_to_innobd__all_tables', 1),
(17, '2022_02_22_162827_create_places_table', 1),
(18, '2022_03_15_151241_create_languages_table', 1),
(19, '2022_03_15_151620_add_translation_column_in_general_settings_table', 1),
(20, '2022_03_15_152811_add_place_and_language_column_in_users_table', 1),
(21, '2022_06_26_143802_create_countries_table', 1),
(22, '2022_06_26_145107_add_colomn_country_id_on_languages_table', 1),
(23, '2022_07_25_110634_add_place_id_in_floors_table', 1),
(24, '2022_07_25_111412_add_place_id_in_tariffs_table', 1),
(25, '2022_07_25_111948_add_place_id_in_parkings_table', 1),
(26, '2022_07_25_161319_add_place_id_in_category_wise_floor_slots_table', 1),
(27, '2022_07_27_101210_change_unique_key_in_category_wise_floor_slots_table', 1),
(28, '2022_07_27_101307_change_unique_key_in_floors_table', 1),
(29, '2022_09_05_182108_create_rfid_vehicles_table', 1),
(30, '2022_09_06_183028_change_parkings_table_add_rfid_no', 1),
(31, '2023_07_06_042452_change_settings_table_add_time_format', 1),
(32, '2023_07_09_082046_add_exit_floor_id_parkings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parkings`
--

CREATE TABLE `parkings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(191) NOT NULL,
  `vehicle_no` varchar(191) NOT NULL,
  `rfid_no` varchar(191) DEFAULT NULL,
  `driver_name` varchar(191) DEFAULT NULL,
  `driver_mobile` varchar(191) DEFAULT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime DEFAULT NULL,
  `exit_floor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `description`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Default Place', NULL, 1, 1, NULL, '2023-07-09 21:25:28', '2023-07-09 21:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `rfid_vehicles`
--

CREATE TABLE `rfid_vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_no` varchar(12) NOT NULL,
  `rfid_no` varchar(24) NOT NULL,
  `driver_name` varchar(191) DEFAULT NULL,
  `driver_mobile` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin User', '2023-07-09 21:25:28', '2023-07-09 21:25:28'),
(2, 'operator', 'Operator', '2023-07-09 21:25:28', '2023-07-09 21:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(191) NOT NULL,
  `site_title` varchar(191) NOT NULL,
  `favicon` varchar(191) NOT NULL,
  `login_image` varchar(191) NOT NULL,
  `translation` text NOT NULL,
  `date_format` varchar(191) DEFAULT 'm-d-Y H:i:s',
  `date_format_sql` varchar(191) DEFAULT '%m-%d-%Y %H:%i:%s',
  `app_timezone` varchar(191) DEFAULT 'UTC',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `site_title`, `favicon`, `login_image`, `translation`, `date_format`, `date_format_sql`, `app_timezone`, `created_at`, `updated_at`) VALUES
(1, 'img/logo.png', 'Demo Site', 'img/favicon.ico', 'img/login-bg.jpg', '', 'm-d-Y H:i:s', '%m-%d-%Y %H:%i:%s', 'UTC', '2023-07-09 21:25:28', '2023-07-09 21:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `tariffs`
--

CREATE TABLE `tariffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `min_amount` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `place_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `place_id`, `language_id`, `email_verified_at`, `password`, `salt`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Name', 'admin@gmail.com', NULL, 1, NULL, '$2y$10$aGeIG9oF/S.I7CrSbaODU.p4YqrUcIuHy02lJi.QtAIT5TjwFg7RS', NULL, 1, NULL, '2023-07-09 21:25:28', '2023-07-09 21:25:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_place_id_type_unique` (`place_id`,`type`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_modified_by_foreign` (`modified_by`);

--
-- Indexes for table `category_wise_floor_slots`
--
ALTER TABLE `category_wise_floor_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slot_name_unique` (`place_id`,`floor_id`,`category_id`,`slot_name`),
  ADD UNIQUE KEY `category_wise_floor_slots_slotid_unique` (`place_id`,`slotId`),
  ADD KEY `category_wise_floor_slots_category_id_foreign` (`category_id`),
  ADD KEY `category_wise_floor_slots_created_by_foreign` (`created_by`),
  ADD KEY `category_wise_floor_slots_updated_by_foreign` (`updated_by`),
  ADD KEY `category_wise_floor_slots_floor_id_foreign` (`floor_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `floors_place_id_name_unique` (`place_id`,`name`),
  ADD UNIQUE KEY `floors_name_unique` (`place_id`,`name`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`),
  ADD KEY `languages_country_id_foreign` (`country_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkings`
--
ALTER TABLE `parkings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parkings_barcode_unique` (`barcode`),
  ADD KEY `parkings_category_id_foreign` (`category_id`),
  ADD KEY `parkings_created_by_foreign` (`created_by`),
  ADD KEY `parkings_modified_by_foreign` (`modified_by`),
  ADD KEY `parkings_slot_id_foreign` (`slot_id`),
  ADD KEY `parkings_place_id_foreign` (`place_id`),
  ADD KEY `parkings_exit_floor_id_foreign` (`exit_floor_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `places_name_unique` (`name`),
  ADD KEY `places_created_by_foreign` (`created_by`),
  ADD KEY `places_modified_by_foreign` (`modified_by`);

--
-- Indexes for table `rfid_vehicles`
--
ALTER TABLE `rfid_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfid_vehicles_category_id_vehicle_no_unique` (`category_id`,`vehicle_no`),
  ADD UNIQUE KEY `rfid_vehicles_category_id_rfid_no_unique` (`category_id`,`rfid_no`),
  ADD KEY `rfid_vehicles_created_by_foreign` (`created_by`),
  ADD KEY `rfid_vehicles_modified_by_foreign` (`modified_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tariffs_category_id_foreign` (`category_id`),
  ADD KEY `tariffs_created_by_foreign` (`created_by`),
  ADD KEY `tariffs_modified_by_foreign` (`modified_by`),
  ADD KEY `tariffs_place_id_foreign` (`place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_place_id_foreign` (`place_id`),
  ADD KEY `users_language_id_foreign` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_wise_floor_slots`
--
ALTER TABLE `category_wise_floor_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `parkings`
--
ALTER TABLE `parkings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rfid_vehicles`
--
ALTER TABLE `rfid_vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_wise_floor_slots`
--
ALTER TABLE `category_wise_floor_slots`
  ADD CONSTRAINT `category_wise_floor_slots_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_wise_floor_slots_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_wise_floor_slots_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_wise_floor_slots_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  ADD CONSTRAINT `category_wise_floor_slots_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `floors_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `parkings`
--
ALTER TABLE `parkings`
  ADD CONSTRAINT `parkings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parkings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parkings_exit_floor_id_foreign` FOREIGN KEY (`exit_floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parkings_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parkings_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  ADD CONSTRAINT `parkings_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `category_wise_floor_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `places_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rfid_vehicles`
--
ALTER TABLE `rfid_vehicles`
  ADD CONSTRAINT `rfid_vehicles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rfid_vehicles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rfid_vehicles_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD CONSTRAINT `tariffs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tariffs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tariffs_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tariffs_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `users_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
