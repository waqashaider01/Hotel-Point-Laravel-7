-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 07:07 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelpointlaraveltest`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL,
  `vat` int(11) NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availabilities`
--

INSERT INTO `availabilities` (`id`, `date`, `room_id`, `room_type_id`, `reservation_id`, `created_at`, `updated_at`) VALUES
(84, '2022-11-20', 11, 4, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(85, '2022-11-21', 11, 4, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(86, '2022-11-22', 11, 4, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(87, '2022-11-23', 11, 4, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(88, '2022-12-01', 13, 5, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05'),
(89, '2022-12-02', 13, 5, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `booking_agencies`
--

CREATE TABLE `booking_agencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `oxygen_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` int(11) NOT NULL,
  `tax_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headquarters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channex_channel_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_payment_mode_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supports_virtual_card` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `virtual_card_payment_mode_id` bigint(20) UNSIGNED DEFAULT NULL,
  `default_payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `charge_date_days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_agencies`
--

INSERT INTO `booking_agencies` (`id`, `hotel_settings_id`, `oxygen_id`, `name`, `bg`, `activity`, `vat_number`, `tax_office`, `address`, `category`, `headquarters`, `branch`, `postal_code`, `phone_number`, `country`, `channex_channel_id`, `default_payment_mode_id`, `supports_virtual_card`, `virtual_card_payment_mode_id`, `default_payment_method_id`, `charge_date_days`, `channel_code`, `charge_mode`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Individual', 'storage/uploads/bg-1668585969.jpg', 'ABC', 111, 'ABC', 'ABC', 'ABC', 'ABC', 'ABC', '1111', '543234', '3', '8a627849-ea2f-4ed9-bee1-f1bcd1da5591', 1, '0', 1, 1, NULL, 'CBE', NULL, NULL, '2022-11-16 03:06:09'),
(2, 1, 'eb23ae26-1779-4494-857b-7909a7a21fe1', 'Channel 1', 'http://localhost/images/logo/logo.png', 'BWUIW', 112, 'BDW', 'CWU NDWO', 'BFWIWI', 'NCEKWB', 'NWWI', '111', '456788765', '5', '212e142e-f7f2-4d95-b151-ddd4da47977f', 1, 'no', NULL, 1, NULL, 'OSA', NULL, '2022-11-14 12:55:34', '2022-11-14 12:55:34'),
(3, 2, NULL, 'Booking Engine', 'http://127.0.0.1:8000/images/logo/logo.png', 'BWBW', 1111, 'BWIE', 'BIE BFEBB', 'BW', 'BWR', 'BIR', '111', '234543', '161', '9fc9ffe2-9b7d-4a63-b535-67dfc5985289', 5, 'no', NULL, 5, NULL, 'OSA', NULL, '2022-11-18 06:58:19', '2022-11-18 06:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `breakfast_percentages`
--

CREATE TABLE `breakfast_percentages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `value` double(8,2) NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `reg_cash` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_of_sale_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `cost_of_sale_id`, `created_at`, `updated_at`) VALUES
(1, 'Operating Expense', 1, '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(2, 'Operating Expense', 2, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(3, 'Cost Of Sales', 2, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(4, 'Spa Operating Expenses', 3, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(5, 'Other Income Expenses', 3, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(6, 'A&G Operating Expenses', 4, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(7, 'Sales Operating Expenses', 5, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(8, 'Marketing Operating Expenses', 5, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(9, 'R&M Operating Expenses', 6, '2022-11-13 02:58:13', '2022-11-13 02:58:13'),
(10, 'Energy Costs', 6, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(11, 'Basic Management Fees', 7, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(12, 'Non Operating Items', 8, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(13, 'Fixed Charges', 9, '2022-11-13 02:58:14', '2022-11-13 02:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `type`, `date`, `description`, `room_id`, `created_at`, `updated_at`) VALUES
(2, 'hk', '2022-11-24', 'I am in house', 11, '2022-11-24 13:55:20', '2022-11-24 14:34:09'),
(3, 'fd', '2022-11-26', 'Its n front', 11, '2022-11-24 14:26:09', '2022-11-24 14:26:09'),
(4, 'fb', '2022-11-25', 'Its housekeeping', 11, '2022-11-24 14:29:36', '2022-11-24 14:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` int(11) DEFAULT NULL,
  `tax_office` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headquarters` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `has_community_vat` tinyint(1) DEFAULT NULL,
  `oxygen_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `hotel_settings_id`, `name`, `activity`, `vat_number`, `tax_office`, `address`, `category`, `headquarters`, `branch`, `postal_code`, `phone_number`, `email`, `country_id`, `discount`, `has_community_vat`, `oxygen_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'Uzma Co.', 'DBW', 111, 'KRR', 'RHR WOO', 'WRBW', 'BOFW', 'EFW', '111', '9876567', NULL, 15, 0, 0, '60ddaf3f-edf2-49f8-bf1c-240ba45cc85b', '2022-11-14 05:45:15', '2022-11-14 05:45:15'),
(2, 1, 'Uzma Co.', 'BWIHW', 233, 'BSIH ', 'NFWORW', 'BW', 'WOQ', 'BWE', '11', '234554', NULL, 161, 0, 0, 'fc8ba29a-08d7-4ef2-ab33-115247cc640d', '2022-11-22 05:23:39', '2022-11-22 05:23:39'),
(3, 1, 'Tech Co.', 'VW WD', 344, 'VWUDVW', 'VW WK WKB', 'BWIW', 'EOHO', NULL, '2222', '345654465', 'email@email.com', 4, NULL, NULL, '8a84fe47-cc9b-4da7-8dd6-c4d623cbd099', '2022-11-26 16:10:05', '2022-11-26 16:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `cost_of_sales`
--

CREATE TABLE `cost_of_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cost_of_sales`
--

INSERT INTO `cost_of_sales` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Rooms Department', '2022-11-13 02:58:11', '2022-11-13 02:58:11'),
(2, 'F & B Department', '2022-11-13 02:58:11', '2022-11-13 02:58:11'),
(3, 'Other Operating department', '2022-11-13 02:58:11', '2022-11-13 02:58:11'),
(4, 'Administration and General Department', '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(5, 'Sales and Marketing Department', '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(6, 'Repairs-Maintenance and Energy Cost', '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(7, 'Basic Management Fees', '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(8, 'Non-Operating Items', '2022-11-13 02:58:12', '2022-11-13 02:58:12'),
(9, 'Fixed Charges', '2022-11-13 02:58:12', '2022-11-13 02:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alpha_two_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `flag`, `name`, `alpha_two_code`, `phone_code`, `created_at`, `updated_at`) VALUES
(1, 'afghanistan.png', 'Afghanistan', 'AF', '+93', NULL, NULL),
(2, 'aland-islands.png', 'Åland Islands', 'AX', '+358 18', NULL, NULL),
(3, 'albania.png', 'Albania', 'AL', '+355', NULL, NULL),
(4, 'algeria.png', 'Algeria', 'DZ', '+213', NULL, NULL),
(5, 'american-samoa.png', 'American Samoa', 'AS', '+1 684', NULL, NULL),
(6, 'andorra.png', 'Andorra', 'AD', '+376', NULL, NULL),
(7, 'angola.png', 'Angola', 'AO', '+244', NULL, NULL),
(8, 'anguilla.png', 'Anguilla', 'AI', '+1 264', NULL, NULL),
(9, 'antigua-and-barbuda.png', 'Antigua and Barbuda', 'AG', '+1', NULL, NULL),
(10, 'argentina.png', 'Argentina', 'AR', '+54', NULL, NULL),
(11, 'armenia.png', 'Armenia', 'AM', '+374', NULL, NULL),
(12, 'aruba.png', 'Aruba', 'AW', '+297', NULL, NULL),
(13, 'australia.png', 'australia', 'AU', '+61', NULL, NULL),
(14, 'austria.png', 'Austria', 'AT', '+43', NULL, NULL),
(15, 'azerbaijan.png', 'Azerbaijan', 'AZ', '+994', NULL, NULL),
(16, 'bahamas.png', 'Bahamas', 'BS', '+1 242', NULL, NULL),
(17, 'bahrain.png', 'Bahrain', 'BH', '+973', NULL, NULL),
(18, 'bangladesh.png', 'Bangladesh', 'BD', '+880', NULL, NULL),
(19, 'barbados.png', 'Barbados', 'BB', '+1 246', NULL, NULL),
(20, 'belarus.png', 'Belarus', 'BY', '+375', NULL, NULL),
(21, 'belgium.png', 'Belgium', 'BE', '+32', NULL, NULL),
(22, 'belize.png', 'Belize', 'BZ', '+501', NULL, NULL),
(23, 'benin.png', 'Benin', 'BJ', '+229', NULL, NULL),
(24, 'bermuda.png', 'Bermuda', 'BM', '+1 441', NULL, NULL),
(25, 'bhutan.png', 'Bhutan', 'BT', '+975', NULL, NULL),
(26, 'bolivia.png', 'Bolivia', 'BO', '+591', NULL, NULL),
(27, 'bonaire.png', 'Bonaire, Sint Eustatius and Saba', 'BQ', '+599 7', NULL, NULL),
(28, 'bosnia-and-herzegovina.png', 'Bosnia and Herzegovina', 'BA', '+387', NULL, NULL),
(29, 'botswana.png', 'Botswana', 'BW', '+267', NULL, NULL),
(30, 'brazil.png', 'Brazil', 'BR', '+55', NULL, NULL),
(31, 'british-indian-ocean-territory.png', 'British Indian Ocean Territory', 'IO', '+246', NULL, NULL),
(32, 'british-virgin-islands.png', 'British Virgin Islands', 'VG', '+1 284', NULL, NULL),
(33, 'brunei.png', 'Brunei Darussalam', 'BN', '+673', NULL, NULL),
(34, 'bulgaria.png', 'Bulgaria', 'BG', '+359', NULL, NULL),
(35, 'burkina-faso.png', 'Burkina Faso', 'BF', '+226', NULL, NULL),
(36, 'burundi.png', 'Burundi', 'BI', '+257', NULL, NULL),
(37, 'cambodia.png', 'Cambodia', 'KH', '+855', NULL, NULL),
(38, 'cameroon.png', 'Cameroon', 'CM', '+237', NULL, NULL),
(39, 'canada.png', 'Canada', 'CA', '+1', NULL, NULL),
(40, 'cayman-islands.png', 'Cayman Islands', 'KY', '+1 345', NULL, NULL),
(41, 'central-african-republic.png', 'Central African Republic', 'CF', '+236', NULL, NULL),
(42, 'chad.png', 'Chad', 'TD', '+235', NULL, NULL),
(43, 'chile.png', 'Chile', 'CL', '+56', NULL, NULL),
(44, 'china.png', 'China', 'CN', '+86', NULL, NULL),
(45, 'christmas-island.png', 'Christmas Island', 'CX', '+61 89164', NULL, NULL),
(46, 'cocos-island.png', 'Cocos (Keeling) Islands', 'CC', '+61 89162', NULL, NULL),
(47, 'colombia.png', 'Colombia', 'CO', '+57', NULL, NULL),
(48, 'comoros.png', 'Comoros', 'KM', '+269', NULL, NULL),
(49, 'democratic-republic-of-congo.png', 'Congo, (Democratic Republic)', 'CD', '+243', NULL, NULL),
(50, 'cook-islands.png', 'Cook Islands', 'CK', '+682', NULL, NULL),
(51, 'costa-rica.png', 'Costa Rica', 'CR', '+506', NULL, NULL),
(52, 'croatia.png', 'Croatia', 'HR', '+385', NULL, NULL),
(53, 'cuba.png', 'Cuba', 'CU', '+53', NULL, NULL),
(54, 'curacao.png', 'Curaçao', 'CW', '+599 9', NULL, NULL),
(55, 'cyprus.png', 'Cyprus', 'CY', '+357', NULL, NULL),
(56, 'czech-republic.png', 'Czech Republic', 'CZ', '+420', NULL, NULL),
(57, 'denmark.png', 'Denmark', 'DK', '+45', NULL, NULL),
(58, 'djibouti.png', 'Djibouti', 'DJ', '+253', NULL, NULL),
(59, 'dominica.png', 'Dominica', 'DM', '+1 767', NULL, NULL),
(60, 'dominican-republic.png', 'Dominican Republic', 'DO', '+1 809', NULL, NULL),
(61, 'ecuador.png', 'Ecuador', 'EC', '+593', NULL, NULL),
(62, 'egypt.png', 'Egypt', 'EG', '+20', NULL, NULL),
(63, 'el-salvador.png', 'El Salvador', 'SV', '+503', NULL, NULL),
(64, 'equatorial-guinea.png', 'Equatorial Guinea', 'GQ', '+240', NULL, NULL),
(65, 'eritrea.png', 'Eritrea', 'ER', '+291', NULL, NULL),
(66, 'estonia.png', 'Estonia', 'EE', '+372', NULL, NULL),
(67, 'ethiopia.png', 'Ethiopia', 'ET', '+251', NULL, NULL),
(68, 'falkland-islands.png', 'Falkland Islands (Malvinas)', 'FK', '+500', NULL, NULL),
(69, 'faroe-islands.png', 'Faroe Islands', 'FO', '+298', NULL, NULL),
(70, 'fiji.png', 'Fiji', 'FJ', '+679', NULL, NULL),
(71, 'finland.png', 'Finland', 'FI', '+358', NULL, NULL),
(72, 'france.png', 'France', 'FR', '+33', NULL, NULL),
(73, 'french-guiana.png', 'French Guiana', 'GF', '+594', NULL, NULL),
(74, 'french-polynesia.png', 'French Polynesia', 'PF', '+689', NULL, NULL),
(75, 'gabon.png', 'Gabon', 'GA', '+241', NULL, NULL),
(76, 'gambia.png', 'Gambia', 'GM', '+220', NULL, NULL),
(77, 'georgia.png', 'Georgia', 'GE', '+995', NULL, NULL),
(78, 'germany.png', 'Germany', 'DE', '+49', NULL, NULL),
(79, 'ghana.png', 'Ghana', 'GH', '+233', NULL, NULL),
(80, 'gibraltar.png', 'Gibraltar', 'GI', '+350', NULL, NULL),
(81, 'greece.png', 'Greece', 'GR', '+30', NULL, NULL),
(82, 'greenland.png', 'Greenland', 'GL', '+299', NULL, NULL),
(83, 'grenada.png', 'Grenada', 'GD', '+1 473', NULL, NULL),
(84, 'guadeloupe.png', 'Guadeloupe', 'GP', '+590', NULL, NULL),
(85, 'guam.png', 'Guam', 'GU', '+1 671', NULL, NULL),
(86, 'guatemala.png', 'Guatemala', 'GT', '+502', NULL, NULL),
(87, 'guernsey.png', 'Guernsey', 'GG', '+44 1481', NULL, NULL),
(88, 'guinea.png', 'Guinea', 'GN', '+224', NULL, NULL),
(89, 'guinea-bissau.png', 'Guinea-Bissau', 'GW', '+245', NULL, NULL),
(90, 'guyana.png', 'Guyana', 'GY', '+592', NULL, NULL),
(91, 'haiti.png', 'Haiti', 'HT', '+509', NULL, NULL),
(92, 'honduras.png', 'Honduras', 'HN', '+504', NULL, NULL),
(93, 'hong-kong.png', 'Hong Kong', 'HK', '+852', NULL, NULL),
(94, 'hungary.png', 'Hungary', 'HU', '+36', NULL, NULL),
(95, 'iceland.png', 'Iceland', 'IS', '+354', NULL, NULL),
(96, 'india.png', 'India', 'IN', '+91', NULL, NULL),
(97, 'indonesia.png', 'Indonesia', 'ID', '+62', NULL, NULL),
(98, 'iran.png', 'Iran, Islamic Republic', 'IR', '+98', NULL, NULL),
(99, 'iraq.png', 'Iraq', 'IQ', '+964', NULL, NULL),
(100, 'ireland.png', 'Ireland', 'IE', '+353', NULL, NULL),
(101, 'isle-of-man.png', 'Isle of Man', 'IM', '+44 1624', NULL, NULL),
(102, 'israel.png', 'Israel', 'IL', '+972', NULL, NULL),
(103, 'italy.png', 'Italy', 'IT', '+39', NULL, NULL),
(104, 'jamaica.png', 'Jamaica', 'JM', '+1 658', NULL, NULL),
(105, 'japan.png', 'Japan', 'JP', '+81', NULL, NULL),
(106, 'jersey.png', 'Jersey', 'JE', '+44 1534', NULL, NULL),
(107, 'jordan.png', 'Jordan', 'JO', '+962', NULL, NULL),
(108, 'kazakhstan.png', 'Kazakhstan', 'KZ', '+7 6', NULL, NULL),
(109, 'kenya.png', 'Kenya', 'KE', '+254', NULL, NULL),
(110, 'kiribati.png', 'Kiribati', 'KI', '+686', NULL, NULL),
(111, 'north-korea.png', 'Korea, Democratic People\'s Republic', 'KP', '+850', NULL, NULL),
(112, 'south-korea.png', 'Korea, Republic of Korea', 'KR', '+82', NULL, NULL),
(113, 'kuwait.png', 'Kuwait', 'KW', '+965', NULL, NULL),
(114, 'kyrgyzstan.png', 'Kyrgyzstan', 'KG', '+996', NULL, NULL),
(115, 'laos.png', 'Lao People\'s Democratic Republic', 'LA', '+856', NULL, NULL),
(116, 'latvia.png', 'Latvia', 'LV', '+371', NULL, NULL),
(117, 'lebanon.png', 'Lebanon', 'LB', '+961', NULL, NULL),
(118, 'lesotho.png', 'Lesotho', 'LS', '+266', NULL, NULL),
(119, 'liberia.png', 'Liberia', 'LR', '+231', NULL, NULL),
(120, 'libya.png', 'Libya', 'LY', '+218', NULL, NULL),
(121, 'liechtenstein.png', 'Liechtenstein', 'LI', '+423', NULL, NULL),
(122, 'lithuania.png', 'Lithuania', 'LT', '+370', NULL, NULL),
(123, 'luxembourg.png', 'Luxembourg', 'LU', '+352', NULL, NULL),
(124, 'macao.png', 'Macao', 'MO', '+853', NULL, NULL),
(125, 'north-macedonia.png', 'North Macedonia', 'MK', '+389', NULL, NULL),
(126, 'madagascar.png', 'Madagascar', 'MG', '+261', NULL, NULL),
(127, 'malawi.png', 'Malawi', 'MW', '+265', NULL, NULL),
(128, 'malaysia.png', 'Malaysia', 'MY', '+60', NULL, NULL),
(129, 'maldives.png', 'Maldives', 'MV', '+960', NULL, NULL),
(130, 'mali.png', 'Mali', 'ML', '+223', NULL, NULL),
(131, 'malta.png', 'Malta', 'MT', '+356', NULL, NULL),
(132, 'marshall-islands.png', 'Marshall Islands', 'MH', '+692', NULL, NULL),
(133, 'martinique.png', 'Martinique', 'MQ', '+596', NULL, NULL),
(134, 'mauritania.png', 'Mauritania', 'MR', '+222', NULL, NULL),
(135, 'mauritius.png', 'Mauritius', 'MU', '+230', NULL, NULL),
(136, 'mayotte.png', 'Mayotte', 'YT', '+262 269', NULL, NULL),
(137, 'mexico.png', 'Mexico', 'MX', '+52', NULL, NULL),
(138, 'micronesia.png', 'Micronesia, Federated States', 'FM', '+691', NULL, NULL),
(139, 'moldova.png', 'Moldova, Republic', 'MD', '+373', NULL, NULL),
(140, 'monaco.png', 'Monaco', 'MC', '+377', NULL, NULL),
(141, 'mongolia.png', 'Mongolia', 'MN', '+976', NULL, NULL),
(142, 'montenegro.png', 'Montenegro', 'ME', '+382', NULL, NULL),
(143, 'montserrat.png', 'Montserrat', 'MS', '+1 664', NULL, NULL),
(144, 'morocco.png', 'Morocco', 'MA', '+212', NULL, NULL),
(145, 'mozambique.png', 'Mozambique', 'MZ', '+258', NULL, NULL),
(146, 'myanmar.png', 'Myanmar', 'MM', '+95', NULL, NULL),
(147, 'namibia.png', 'Namibia', 'NA', '+264', NULL, NULL),
(148, 'nauru.png', 'Nauru', 'NR', '+674', NULL, NULL),
(149, 'nepal.png', 'Nepal', 'NP', '+977', NULL, NULL),
(150, 'netherlands.png', 'Netherlands', 'NL', '+31', NULL, NULL),
(151, 'new-caledonia.png', 'New Caledonia', 'NC', '+687', NULL, NULL),
(152, 'new-zealand.png', 'New Zealand', 'NZ', '+64', NULL, NULL),
(153, 'nicaragua.png', 'Nicaragua', 'NI', '+505', NULL, NULL),
(154, 'niger.png', 'Niger', 'NE', '+227', NULL, NULL),
(155, 'nigeria.png', 'Nigeria', 'NG', '+234', NULL, NULL),
(156, 'niue.png', 'Niue', 'NU', '+683', NULL, NULL),
(157, 'norfolk-island.png', 'Norfolk Island', 'NF', '+672 3', NULL, NULL),
(158, 'northern-mariana-islands.png', 'Northern Mariana Islands', 'MP', '+1 670', NULL, NULL),
(159, 'norway.png', 'Norway', 'NO', '+47', NULL, NULL),
(160, 'oman.png', 'Oman', 'OM', '+968', NULL, NULL),
(161, 'pakistan.png', 'Pakistan', 'PK', '+92', NULL, NULL),
(162, 'palau.png', 'Palau', 'PW', '+680', NULL, NULL),
(163, 'palestine.png', 'Palestine', 'PS', '+970', NULL, NULL),
(164, 'panama.png', 'Panama', 'PA', '+507', NULL, NULL),
(165, 'papua-new-guinea.png', 'Papua New Guinea', 'PG', '+675', NULL, NULL),
(166, 'paraguay.png', 'Paraguay', 'PY', '+595', NULL, NULL),
(167, 'peru.png', 'Peru', 'PE', '+51', NULL, NULL),
(168, 'philippines.png', 'Philippines', 'PH', '+63', NULL, NULL),
(169, 'pitcairn.png', 'Pitcairn Islands', 'PN', '+64', NULL, NULL),
(170, 'poland.png', 'Poland', 'PL', '+48', NULL, NULL),
(171, 'portugal.png', 'Portugal', 'PT', '+351', NULL, NULL),
(172, 'puerto-rico.png', 'Puerto Rico', 'PR', '+1 787', NULL, NULL),
(173, 'qatar.png', 'Qatar', 'QA', '+974', NULL, NULL),
(174, 'reunion.png', 'Réunion', 'RE', '+262', NULL, NULL),
(175, 'romania.png', 'Romania', 'RO', '+40', NULL, NULL),
(176, 'russian-federation.png', 'Russian Federation', 'RU', '+7', NULL, NULL),
(177, 'rwanda.png', 'Rwanda', 'RW', '+250', NULL, NULL),
(178, 'saint-barthelemy.png', 'Saint Barthélemy', 'BL', '+590', NULL, NULL),
(179, 'saint-helena.png', 'Saint Helena, Ascension and Tristan da Cunha', 'SH', '+290', NULL, NULL),
(180, 'saint-kitts-and-nevis.png', 'Saint Kitts and Nevis', 'KN', '+1 869', NULL, NULL),
(181, 'saint-lucia.png', 'Saint Lucia', 'LC', '+1 758', NULL, NULL),
(182, 'saint-martin-french.png', 'Saint Martin (French part)', 'MF', '+590', NULL, NULL),
(183, 'saint-pierre-and-miquelon.png', 'Saint Pierre and Miquelon', 'PM', '+508', NULL, NULL),
(184, 'saint-vincent-and-grenadines.png', 'Saint Vincent and the Grenadines', 'VC', '+1 784', NULL, NULL),
(185, 'samoa.png', 'Samoa', 'WS', '+685', NULL, NULL),
(186, 'san-marino.png', 'San Marino', 'SM', '+378', NULL, NULL),
(187, 'sao-tome-and-principe.png', 'Sao Tome and Principe', 'ST', '+239', NULL, NULL),
(188, 'saudi-arabia.png', 'Saudi Arabia', 'SA', '+966', NULL, NULL),
(189, 'senegal.png', 'Senegal', 'SN', '+221', NULL, NULL),
(190, 'serbia.png', 'Serbia', 'RS', '+381', NULL, NULL),
(191, 'seychelles.png', 'Seychelles', 'SC', '+248', NULL, NULL),
(192, 'sierra-leone.png', 'Sierra Leone', 'SL', '+232', NULL, NULL),
(193, 'singapore.png', 'Singapore', 'SG', '+65', NULL, NULL),
(194, 'sint-maarten.png', 'Sint Maarten (Dutch part)', 'SX', '+599 3', NULL, NULL),
(195, 'slovakia.png', 'Slovakia', 'SK', '+421', NULL, NULL),
(196, 'slovenia.png', 'Slovenia', 'SI', '+386', NULL, NULL),
(197, 'solomon-islands.png', 'Solomon Islands', 'SB', '+677', NULL, NULL),
(198, 'somalia.png', 'Somalia', 'SO', '+252', NULL, NULL),
(199, 'south-africa.png', 'South Africa', 'ZA', '+27', NULL, NULL),
(200, 'south-georgia.png', 'South Georgia and the South Sandwich Islands', 'GS', '+500', NULL, NULL),
(201, 'south-sudan.png', 'South Sudan', 'SS', '+211', NULL, NULL),
(202, 'spain.png', 'Spain', 'ES', '+34', NULL, NULL),
(203, 'sri-lanka.png', 'Sri Lanka', 'LK', '+94', NULL, NULL),
(204, 'sudan.png', 'Sudan', 'SD', '+249', NULL, NULL),
(205, 'suriname.png', 'Suriname', 'SR', '+597', NULL, NULL),
(206, 'svalbard.png', 'Svalbard and Jan Mayen', 'SJ', '+47 79', NULL, NULL),
(207, 'sweden.png', 'Sweden', 'SE', '+46', NULL, NULL),
(208, 'switzerland.png', 'Switzerland', 'CH', '+41', NULL, NULL),
(209, 'syria.png', 'Syrian Arab Republic', 'SY', '+963', NULL, NULL),
(210, 'taiwan.png', 'Taiwan', 'TW', '+886', NULL, NULL),
(211, 'tajikistan.png', 'Tajikistan', 'TJ', '+992', NULL, NULL),
(212, 'tanzania.png', 'Tanzania, United Republic', 'TZ', '+255', NULL, NULL),
(213, 'thailand.png', 'Thailand', 'TH', '+66', NULL, NULL),
(214, 'timor-leste.png', 'Timor-Leste', 'TL', 'TLS', NULL, NULL),
(215, 'togo.png', 'Togo', 'TG', '+228', NULL, NULL),
(216, 'tokelau.png', 'Tokelau', 'TK', '+690', NULL, NULL),
(217, 'tonga.png', 'Tonga', 'TO', '+676', NULL, NULL),
(218, 'trinidad-and-tobago.png', 'Trinidad and Tobago', 'TT', '+1 868', NULL, NULL),
(219, 'tunisia.png', 'Tunisia', 'TN', '+216', NULL, NULL),
(220, 'turkey.png', 'Turkey', 'TR', '+90', NULL, NULL),
(221, 'turkmenistan.png', 'Turkmenistan', 'TM', '+993', NULL, NULL),
(222, 'turks-and-caicos-islands.png', 'Turks and Caicos Islands', 'TC', '+1 649', NULL, NULL),
(223, 'tuvalu.png', 'Tuvalu', 'TV', '+688', NULL, NULL),
(224, 'uganda.png', 'Uganda', 'UG', '+256', NULL, NULL),
(225, 'ukraine.png', 'Ukraine', 'UA', '+380', NULL, NULL),
(226, 'united-arab-emirates.png', 'United Arab Emirates', 'AE', '+971', NULL, NULL),
(227, 'united-kingdom.png', 'United Kingdom', 'GB', '+44', NULL, NULL),
(228, 'united-states.png', 'United States', 'US', '+1', NULL, NULL),
(229, 'uruguay.png', 'Uruguay', 'UY', '+598', NULL, NULL),
(230, 'uzbekistan.png', 'Uzbekistan', 'UZ', '+998', NULL, NULL),
(231, 'vanuatu.png', 'Vanuatu', 'VU', '+679', NULL, NULL),
(232, 'venezuela.png', 'Venezuela, Bolivarian Republic', 'VE', '+58', NULL, NULL),
(233, 'vietnam.png', 'Viet Nam', 'VN', '+84', NULL, NULL),
(234, 'virgin-islands.png', 'Virgin Islands, U.S.', 'VI', '+1 340', NULL, NULL),
(235, 'wallis-and-futuna.png', 'Wallis and Futuna', 'WF', '+681', NULL, NULL),
(236, 'yemen.png', 'Yemen', 'YE', '+967', NULL, NULL),
(237, 'zambia.png', 'Zambia', 'ZM', '+260', NULL, NULL),
(238, 'zimbabwe.png', 'Zimbabwe', 'ZW', '+263', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `initials`, `symbol`, `created_at`, `updated_at`) VALUES
(1, 'Albania Lek', 'ALL', 'Lek', NULL, NULL),
(2, 'Afghanistan Afghani', 'AFN', '؋', NULL, NULL),
(3, 'Argentina Peso', 'ARS', '$', NULL, NULL),
(4, 'Aruba Guilder', 'AWG', 'ƒ', NULL, NULL),
(5, 'Australia Dollar', 'AUD', '$', NULL, NULL),
(6, 'Azerbaijan Manat', 'AZN', '₼', NULL, NULL),
(7, 'Bahamas Dollar', 'BSD', '$', NULL, NULL),
(8, 'Barbados Dollar', 'BBD', '$', NULL, NULL),
(9, 'Belarus Ruble', 'BYN', 'Br', NULL, NULL),
(10, 'Belize Dollar', 'BZD', 'BZ$', NULL, NULL),
(11, 'Bermuda Dollar', 'BMD', '$', NULL, NULL),
(12, 'Bolivia Bolíviano', 'BOB', '$b', NULL, NULL),
(13, 'Bosnia and Herzegovina Convertible Mark', 'BAM', 'KM', NULL, NULL),
(14, 'Botswana Pula', 'BWP', 'P', NULL, NULL),
(15, 'Bulgaria Lev', 'BGN', 'лв', NULL, NULL),
(16, 'Brazil Real', 'BRL', 'R$', NULL, NULL),
(17, 'Brunei Darussalam Dollar', 'BND', '$', NULL, NULL),
(18, 'Cambodia Riel', 'KHR', '៛', NULL, NULL),
(19, 'Canada Dollar', 'CAD', '$', NULL, NULL),
(20, 'Cayman Islands Dollar', 'KYD', '$', NULL, NULL),
(21, 'Chile Peso', 'CLP', '$', NULL, NULL),
(22, 'China Yuan Renminbi', 'CNY', '¥', NULL, NULL),
(23, 'Colombia Peso', 'COP', '$', NULL, NULL),
(24, 'Costa Rica Colon', 'CRC', '₡', NULL, NULL),
(25, 'Croatia Kuna', 'HRK', 'kn', NULL, NULL),
(26, 'Cuba Peso', 'CUP', '₱', NULL, NULL),
(27, 'Czech Republic Koruna', 'CZK', 'Kč', NULL, NULL),
(28, 'Denmark Krone', 'DKK', 'kr', NULL, NULL),
(29, 'Dominican Republic Peso', 'DOP', 'RD$', NULL, NULL),
(30, 'East Caribbean Dollar', 'XCD', '$', NULL, NULL),
(31, 'Egypt Pound', 'EGP', '£', NULL, NULL),
(32, 'El Salvador Colon', 'SVC', '$', NULL, NULL),
(33, 'Euro Member Countries', 'EUR', '€', NULL, NULL),
(34, 'Falkland Islands (Malvinas) Pound', 'FKP', '£', NULL, NULL),
(35, 'Fiji Dollar', 'FJD', '$', NULL, NULL),
(36, 'Ghana Cedi', 'GHS', '¢', NULL, NULL),
(37, 'Gibraltar Pound', 'GIP', '£', NULL, NULL),
(38, 'Guatemala Quetzal', 'GTQ', 'Q', NULL, NULL),
(39, 'Guernsey Pound', 'GGP', '£', NULL, NULL),
(40, 'Guyana Dollar', 'GYD', '$', NULL, NULL),
(41, 'Honduras Lempira', 'HNL', 'L', NULL, NULL),
(42, 'Hong Kong Dollar', 'HKD', '$', NULL, NULL),
(43, 'Hungary Forint', 'HUF', 'Ft', NULL, NULL),
(44, 'Iceland Krona', 'ISK', 'kr', NULL, NULL),
(45, 'India Rupee', 'INR', '₹', NULL, NULL),
(46, 'Indonesia Rupiah', 'IDR', 'Rp', NULL, NULL),
(47, 'Iran Rial', 'IRR', '﷼', NULL, NULL),
(48, 'Isle of Man Pound', 'IMP', '£', NULL, NULL),
(49, 'Israel Shekel', 'ILS', '₪', NULL, NULL),
(50, 'Jamaica Dollar', 'JMD', 'J$', NULL, NULL),
(51, 'Japan Yen', 'JPY', '¥', NULL, NULL),
(52, 'Jersey Pound', 'JEP', '£', NULL, NULL),
(53, 'Kazakhstan Tenge', 'KZT', 'лв', NULL, NULL),
(54, 'Korea (North) Won', 'KPW', '₩', NULL, NULL),
(55, 'Korea (South) Won', 'KRW', '₩', NULL, NULL),
(56, 'Kyrgyzstan Som', 'KGS', 'лв', NULL, NULL),
(57, 'Laos Kip', 'LAK', '₭', NULL, NULL),
(58, 'Lebanon Pound', 'LBP', '£', NULL, NULL),
(59, 'Liberia Dollar', 'LRD', '$', NULL, NULL),
(60, 'Macedonia Denar', 'MKD', 'ден', NULL, NULL),
(61, 'Malaysia Ringgit', 'MYR', 'RM', NULL, NULL),
(62, 'Mauritius Rupee', 'MUR', '₨', NULL, NULL),
(63, 'Mexico Peso', 'MXN', '$', NULL, NULL),
(64, 'Mongolia Tughrik', 'MNT', '₮', NULL, NULL),
(65, 'Moroccan-dirham', 'MNT', 'د.إ', NULL, NULL),
(66, 'Mozambique Metical', 'MZN', 'MT', NULL, NULL),
(67, 'Namibia Dollar', 'NAD', '$', NULL, NULL),
(68, 'Nepal Rupee', 'NPR', '₨', NULL, NULL),
(69, 'Netherlands Antilles Guilder', 'ANG', 'ƒ', NULL, NULL),
(70, 'New Zealand Dollar', 'NZD', '$', NULL, NULL),
(71, 'Nicaragua Cordoba', 'NIO', 'C$', NULL, NULL),
(72, 'Nigeria Naira', 'NGN', '₦', NULL, NULL),
(73, 'Norway Krone', 'NOK', 'kr', NULL, NULL),
(74, 'Oman Rial', 'OMR', '﷼', NULL, NULL),
(75, 'Pakistan Rupee', 'PKR', '₨', NULL, NULL),
(76, 'Panama Balboa', 'PAB', 'B', NULL, NULL),
(77, 'Paraguay Guarani', 'PYG', 'Gs', NULL, NULL),
(78, 'Peru Sol', 'PEN', 'S', NULL, NULL),
(79, 'Philippines Peso', 'PHP', '₱', NULL, NULL),
(80, 'Poland Zloty', 'PLN', 'zł', NULL, NULL),
(81, 'Qatar Riyal', 'QAR', '﷼', NULL, NULL),
(82, 'Romania Leu', 'RON', 'lei', NULL, NULL),
(83, 'Russia Ruble', 'RUB', '₽', NULL, NULL),
(84, 'Saint Helena Pound', 'SHP', '£', NULL, NULL),
(85, 'Saudi Arabia Riyal', 'SAR', '﷼', NULL, NULL),
(86, 'Serbia Dinar', 'RSD', 'Дин', NULL, NULL),
(87, 'Seychelles Rupee', 'SCR', '₨', NULL, NULL),
(88, 'Singapore Dollar', 'SGD', '$', NULL, NULL),
(89, 'Solomon Islands Dollar', 'SBD', '$', NULL, NULL),
(90, 'Somalia Shilling', 'SOS', 'S', NULL, NULL),
(91, 'South Korean Won', 'KRW', '₩', NULL, NULL),
(92, 'South Africa Rand', 'ZAR', 'R', NULL, NULL),
(93, 'Sri Lanka Rupee', 'LKR', '₨', NULL, NULL),
(94, 'Sweden Krona', 'SEK', 'kr', NULL, NULL),
(95, 'Switzerland Franc', 'CHF', 'CHF', NULL, NULL),
(96, 'Suriname Dollar', 'SRD', '$', NULL, NULL),
(97, 'Syria Pound', 'SYP', '£', NULL, NULL),
(98, 'Taiwan New Dollar', 'TWD', 'NT$', NULL, NULL),
(99, 'Thailand Baht', 'THB', '฿', NULL, NULL),
(100, 'Trinidad and Tobago Dollar', 'TTD', 'TT$', NULL, NULL),
(101, 'Turkey Lira', 'TRY', '₺', NULL, NULL),
(102, 'Tuvalu Dollar', 'TVD', '$', NULL, NULL),
(103, 'Ukraine Hryvnia', 'UAH', '₴', NULL, NULL),
(104, 'UAE-Dirham', 'AED', 'AED', NULL, NULL),
(105, 'United Kingdom Pound', 'GBP', '£', NULL, NULL),
(106, 'United States Dollar', 'USD', '$', NULL, NULL),
(107, 'Uruguay Peso', 'UYU', '$U', NULL, NULL),
(108, 'Uzbekistan Som', 'UZS', 'лв', NULL, NULL),
(109, 'Venezuela Bolívar', 'VEF', 'Bs', NULL, NULL),
(110, 'Viet Nam Dong', 'VND', '₫', NULL, NULL),
(111, 'Yemen Rial', 'YER', '﷼', NULL, NULL),
(112, 'Zimbabwe Dollar', 'ZWD', 'Z$', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_rates`
--

CREATE TABLE `daily_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `price` double(8,2) NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_rates`
--

INSERT INTO `daily_rates` (`id`, `date`, `price`, `reservation_id`, `created_at`, `updated_at`) VALUES
(58, '2022-11-20', 100.00, 19, '2022-11-20 03:35:24', '2022-11-20 03:35:24'),
(59, '2022-11-20', 200.00, 20, '2022-11-20 04:02:13', '2022-11-23 06:47:10'),
(60, '2022-11-21', 100.00, 19, '2022-11-21 12:21:23', '2022-11-21 12:21:23'),
(61, '2022-11-22', 100.00, 19, '2022-11-21 12:23:18', '2022-11-21 12:23:18'),
(62, '2022-12-01', 500.00, 21, '2022-11-21 13:19:00', '2022-11-21 13:19:00'),
(63, '2022-12-02', 600.00, 21, '2022-11-21 13:19:00', '2022-11-21 13:19:00'),
(64, '2022-11-21', 200.00, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(65, '2022-11-22', 200.00, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(66, '2022-11-23', 200.00, 20, '2022-11-23 06:47:10', '2022-11-23 06:47:10'),
(67, '2022-12-01', 900.00, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05'),
(68, '2022-12-02', 900.00, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_types`
--

CREATE TABLE `deposit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposit_types`
--

INSERT INTO `deposit_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Prepayment', '2022-11-13 02:58:30', '2022-11-13 02:58:30'),
(2, 'First Charge', '2022-11-13 02:58:30', '2022-11-13 02:58:30'),
(3, 'Second Charge', '2022-11-13 02:58:31', '2022-11-13 02:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `descriptions`
--

CREATE TABLE `descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `descriptions`
--

INSERT INTO `descriptions` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Guest amenities & supplies', 1, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(2, 'Cleaning materials & consumables', 1, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(3, 'Outside laundry & dry cleaning', 1, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(4, 'Contract cleaning', 1, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(5, 'Staff uniforms', 1, '2022-11-13 02:58:14', '2022-11-13 02:58:14'),
(6, 'Flowers & decorations', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(7, 'Travel agent commissions', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(8, 'Tour operators commissions', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(9, 'IDS commissions', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(10, 'Affiliation commissions', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(11, 'Newspapers & Magazines', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(12, 'Equipment replacement', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(13, 'Staff travel expenses & training', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(14, 'Miscellaneous', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(15, 'Own web site commissions', 1, '2022-11-13 02:58:15', '2022-11-13 02:58:15'),
(16, 'Home / villa OTAs commissions', 1, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(17, 'Complimentary', 1, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(18, 'Food cost', 3, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(19, 'Beverage cost', 3, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(20, 'Other cost of sales', 3, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(21, 'Outside laundry & dry cleaning', 2, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(22, 'Staff uniforms', 2, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(23, 'Staff travel expenses & training', 2, '2022-11-13 02:58:16', '2022-11-13 02:58:16'),
(24, 'Kitchen supplies & cleaning materials', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(25, 'Rest./Bar Supplies & cleaning materials', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(26, 'Kitchen equipment replacement', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(27, 'Rest./Bar equipment replacement', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(28, 'Flowers & decorations', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(29, 'Contract cleaning', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(30, 'Music & entertainment', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(31, 'Miscellaneous', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(32, 'Other rents (equipment rent)', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(33, 'Complimentary', 2, '2022-11-13 02:58:17', '2022-11-13 02:58:17'),
(34, 'Spa products', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(35, 'Spa amenities & consumables', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(36, 'Cleaning materials', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(37, 'Outside laundry Dry cleaning', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(38, 'Staff uniforms', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(39, 'External therapists fees', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(40, 'Flowers & Decorations', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(41, 'Contract Cleaning', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(42, 'Equipment replacement', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(43, 'Miscellaneous', 4, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(44, 'Outside laundry & dry cleaning', 5, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(45, 'Guest transfers cost', 5, '2022-11-13 02:58:18', '2022-11-13 02:58:18'),
(46, 'Excursion costs', 5, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(47, 'Cigars', 5, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(48, 'Guest Sundries / Souven./Newspapers', 5, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(49, 'Miscellaneous', 5, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(50, 'Credit card commissions', 6, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(51, 'Telephones Costs (OTE) & mobiles', 6, '2022-11-13 02:58:19', '2022-11-13 02:58:19'),
(52, 'Bank charges & exchange difference', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(53, 'Postage & Courier', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(54, 'Printing & stationery', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(55, 'Travel expenses', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(56, 'Information tech & system costs', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(57, 'Tax - legal & professional services', 6, '2022-11-13 02:58:20', '2022-11-13 02:58:20'),
(58, 'Subscriptions & Chambers costs', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(59, 'Licences & Permits', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(60, 'Staff recruitment & training', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(61, 'Transportation costs', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(62, 'Miscellaneous', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(63, 'Other Rents (personnel Houses)', 6, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(64, 'Travel & Subsistence', 7, '2022-11-13 02:58:21', '2022-11-13 02:58:21'),
(65, 'External Entertainment', 7, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(66, 'Complimentary Rooms / House checks', 7, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(67, 'Trade shows participation', 7, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(68, 'Training', 7, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(69, 'Other sales expenses', 7, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(70, 'Advertising - magazines', 8, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(71, 'Advertising - Guides & TO brochures', 8, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(72, 'Advertising - GDS', 8, '2022-11-13 02:58:22', '2022-11-13 02:58:22'),
(73, 'Advertising - Internet', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(74, 'Brochures', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(75, 'Promotional & Collateral Material', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(76, 'Web site fees', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(77, 'Affiliation marketing fees', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(78, 'Public relations', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(79, 'Photography', 8, '2022-11-13 02:58:23', '2022-11-13 02:58:23'),
(80, 'Direct mail', 8, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(81, 'Other marketing expense', 8, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(82, 'Maintenance contracts', 9, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(83, 'FF&E replacement', 9, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(84, 'Painting & decorating', 9, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(85, 'Carpentry', 9, '2022-11-13 02:58:24', '2022-11-13 02:58:24'),
(86, 'Electrical & Lighting', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(87, 'Plumbing', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(88, 'Heating & air-conditioning', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(89, 'Tools & consumables', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(90, 'Pest control', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(91, 'Health / Hygiene & safety', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(92, 'Fire precautions', 9, '2022-11-13 02:58:25', '2022-11-13 02:58:25'),
(93, 'Plants & landscaping', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(94, 'Waste removal', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(95, 'Storage', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(96, 'Engineering & design', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(97, 'Lift maintenance', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(98, 'Other R&M costs', 9, '2022-11-13 02:58:26', '2022-11-13 02:58:26'),
(99, 'FF&E repairs', 9, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(100, 'Electrical supply (EH)', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(101, 'Water supply & drainage', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(102, 'Gas', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(103, 'Vehicles gas / diesel', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(104, 'Petroleum', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(105, 'Other energy costs', 10, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(106, 'Management Fee (on revenue)', 11, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(107, 'Fixed management fee', 11, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(108, 'Non operating expenses (OB)', 12, '2022-11-13 02:58:27', '2022-11-13 02:58:27'),
(109, 'Extraordinary expenses', 12, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(110, 'Prior year expenses', 12, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(111, 'Rent', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(112, 'Insurance', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(113, 'Taxes & Levies', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(114, 'Stamp Duty', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(115, 'Circulation Taxes', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(116, 'VAT', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28'),
(117, 'Other Taxes', 13, '2022-11-13 02:58:28', '2022-11-13 02:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) NOT NULL,
  `row` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enumeration` int(11) NOT NULL,
  `print_date` date NOT NULL,
  `print_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` int(11) NOT NULL,
  `city_vat` double(8,2) DEFAULT NULL,
  `taxable_amount` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `net_value` double(8,2) DEFAULT NULL,
  `discount_net_value` double(8,2) DEFAULT NULL,
  `municipal_tax` double(8,2) DEFAULT NULL,
  `tax` double(8,2) DEFAULT NULL,
  `tax_2` double(8,2) DEFAULT NULL,
  `paid` double(8,2) NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `document_type_id` bigint(20) UNSIGNED NOT NULL,
  `mark_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_infos`
--

CREATE TABLE `document_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_agency_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `turnover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `row` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enumeration` int(11) NOT NULL,
  `uniform_enumeration` int(11) DEFAULT NULL,
  `initials` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `hotel_settings_id`, `type`, `language`, `name`, `debit`, `credit`, `turnover`, `row`, `enumeration`, `uniform_enumeration`, `initials`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Greece', 'Απόδειξη Παροχής Με Ακυρωτικά', '+', '-', '+', 'E', 7, 1, 'ΑΠΜΑ', 1, '2022-11-13 02:58:07', '2022-11-22 12:25:24'),
(2, 1, 2, 'Greece', 'Ειδικό Ακυρωτικό Δελτίο', '-', '+', '-', 'C', 2, 1, 'ΕΑΔ', 1, '2022-11-13 02:58:07', '2022-11-19 14:07:43'),
(3, 1, 3, 'Greece', 'Απόδειξη Φόρου Διαμονής', '+', '-', '-', 'E', 21, 1, 'ΑΦΔ', 1, '2022-11-13 02:58:07', '2022-11-21 11:24:32'),
(4, 1, 4, 'Greece', 'Τιμολόγιο Παροχής Υπηρεσιών', '+', '-', '+', 'E', 6, 10, 'ΤΠΥ', 1, '2022-11-13 02:58:07', '2022-11-21 11:52:30'),
(5, 1, 5, 'Greece', 'Απόδειξη Παροχής Υπηρεσιών', '+', '-', '+', 'E', 8, 1, 'ΑΠΥ', 1, '2022-11-13 02:58:07', '2022-11-19 14:09:44'),
(6, 1, 6, 'Greece', 'Πιστωτικό Τιμολόγιο', '-', '+', '-', 'E', 1, 1, 'ΠΤ', 1, '2022-11-13 02:58:08', '2022-11-13 02:58:08'),
(7, 2, 1, 'Greece', 'Απόδειξη Παροχής Με Ακυρωτικά', '+', '-', '+', 'Α', 1, 1, 'ΑΠΜΑ', 1, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(8, 2, 2, 'Greece', 'Ειδικό Ακυρωτικό Δελτίο', '-', '+', '-', 'Α', 1, 1, 'ΕΑΔ', 1, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(9, 2, 3, 'Greece', 'Απόδειξη Φόρου Διαμονής', '+', '-', '-', 'Α', 20, 1, 'ΑΦΔ', 1, '2022-11-18 06:52:41', '2022-11-20 16:08:59'),
(10, 2, 4, 'Greece', 'Τιμολόγιο Παροχής Υπηρεσιών', '+', '-', '+', 'E', 3, 10, 'ΤΠΥ', 1, '2022-11-18 06:52:41', '2022-11-20 16:05:26'),
(11, 2, 5, 'Greece', 'Απόδειξη Παροχής Υπηρεσιών', '+', '-', '+', 'Α', 6, 1, 'ΑΠΥ', 1, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(12, 2, 6, 'Greece', 'Πιστωτικό Τιμολόγιο', '-', '+', '-', 'Α', 1, 1, 'ΠΤ', 1, '2022-11-18 06:52:41', '2022-11-18 06:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `extra_charges`
--

CREATE TABLE `extra_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `extra_charge_category_id` bigint(20) UNSIGNED NOT NULL,
  `extra_charge_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extra_charges`
--

INSERT INTO `extra_charges` (`id`, `hotel_settings_id`, `product`, `status`, `vat`, `unit_price`, `extra_charge_category_id`, `extra_charge_type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Burger Black Angus', 'Enabled', '13', 30.00, 2, 1, '2022-11-13 02:58:30', '2022-11-13 02:58:30'),
(2, 1, 'Pizza Margarita ', 'Enabled', '13', 20.00, 2, 1, '2022-11-13 02:58:30', '2022-11-13 02:58:30'),
(3, 1, 'Coca Cola 250 ml', 'Enabled', '13', 8.00, 2, 2, '2022-11-13 02:58:30', '2022-11-13 02:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `extra_charges_categories`
--

CREATE TABLE `extra_charges_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extra_charges_categories`
--

INSERT INTO `extra_charges_categories` (`id`, `hotel_settings_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Room Service', '2022-11-13 02:58:29', '2022-11-13 02:58:29'),
(2, 1, 'Restaurant', '2022-11-13 02:58:29', '2022-11-13 02:58:29'),
(3, 1, 'Bar', '2022-11-13 02:58:29', '2022-11-13 02:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `extra_charges_types`
--

CREATE TABLE `extra_charges_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extra_charges_types`
--

INSERT INTO `extra_charges_types` (`id`, `hotel_settings_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Food', '2022-11-13 02:58:29', '2022-11-13 02:58:29'),
(2, 1, 'Beverage', '2022-11-13 02:58:29', '2022-11-13 02:58:29'),
(3, 1, 'Spa', '2022-11-13 02:58:29', '2022-11-13 02:58:29'),
(4, 1, 'Other Income', '2022-11-13 02:58:30', '2022-11-13 02:58:30'),
(5, 1, 'Miscellaneous', '2022-11-13 02:58:30', '2022-11-13 02:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `ex_reservations`
--

CREATE TABLE `ex_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `indexes` int(11) DEFAULT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `booking_date` date NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `guests` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_agency_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oxygen_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `hotel_settings_id`, `full_name`, `email`, `email_2`, `country_id`, `city`, `address`, `language`, `phone`, `mobile`, `postal_code`, `oxygen_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Uzma Azhar', 'uzma@gmail.com', NULL, 3, 'Lahore', 'Strret No 2', 'urdu', '5678765', '7654567', '100', NULL, NULL, NULL),
(2, 1, 'Uzma Azhar', 'uzma@gmail.com', NULL, 3, NULL, NULL, NULL, '5678765', NULL, NULL, NULL, '2022-11-15 09:55:46', '2022-11-15 09:55:46'),
(9, 2, 'George Karantzias', 'director@mykonianrevenue.com', NULL, 81, 'Athens ', 'Nikis 24', '', '414547874', NULL, '15676', NULL, '2022-11-18 08:26:29', '2022-11-18 08:26:29'),
(10, 2, 'George Karantzias', 'director@mykonianrevenue.com', NULL, 81, 'Athens ', 'Nikis 24', '', '414547874', NULL, '15676', NULL, '2022-11-18 08:28:02', '2022-11-18 08:28:02'),
(13, 2, 'Elina Kapolos', 'kapolos@hotmail.gr', NULL, 159, 'Geilo', 'Patakoipu 1', '', '54878485478', NULL, '3580', NULL, '2022-11-18 10:06:54', '2022-11-18 10:06:54'),
(14, 2, 'Elina Kapolos', 'kapolos@hotmail.gr', NULL, 159, 'Geilo', 'Patakoipu 1', '', '54878485478', NULL, '3580', NULL, '2022-11-18 10:25:27', '2022-11-18 10:25:27'),
(15, 2, 'Elina Kapolos', 'kapolos@hotmail.gr', NULL, 159, 'Geilo', 'Patakoipu 1', '', '54878485478', NULL, '3580', NULL, '2022-11-19 01:45:04', '2022-11-19 01:45:04'),
(16, 2, 'Elina Kapolos', 'kapolos@hotmail.gr', NULL, 159, 'Geilo', 'Patakoipu 1', '', '54878485478', NULL, '3580', NULL, '2022-11-19 01:53:51', '2022-11-19 01:53:51'),
(18, 2, 'Elina Kapolos', 'kapolos@hotmail.gr', NULL, 159, 'Geilo', 'Patakoipu 1', '', '54878485478', NULL, '3580', NULL, '2022-11-19 02:02:08', '2022-11-19 02:02:08'),
(19, 1, 'Uzma', 'uzma@gmail.com', NULL, 161, NULL, NULL, NULL, '87654567', '8765455678', '1111', NULL, '2022-11-19 06:21:57', '2022-11-19 07:23:25'),
(20, 1, 'Uzma', 'uzma@gmail.com', NULL, 161, NULL, NULL, NULL, '987654567', '8765432', '111', NULL, '2022-11-19 13:56:40', '2022-11-19 13:59:00'),
(21, 1, 'Uzma Parveen', 'uzma@gmail.com', NULL, 161, 'Sargodha', 'Sargodha', '', '654334554', '87654567', '10040', 'f533732c-d707-4e66-b175-4af52a5da5c0', '2022-11-20 03:35:23', '2022-11-21 10:23:27'),
(22, 1, 'Uzma Parveen', 'uzma@gmail.com', NULL, 161, 'Sargodha', 'Sargodha', '', '654334554', NULL, '10040', NULL, '2022-11-20 04:02:12', '2022-11-20 04:02:12'),
(23, 1, 'Uzma Azhar', 'uzma@gmail.com', NULL, 161, NULL, NULL, NULL, '234567654', NULL, NULL, NULL, '2022-11-21 13:18:59', '2022-11-21 13:18:59'),
(24, 2, 'Uzma Asiatika', 'director@mykonianrevenue.com', NULL, 39, 'TORONTO ', 'Maniatika 15', '', '8548548548', NULL, '65488', NULL, '2022-11-23 14:27:05', '2022-11-23 14:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `guest_accommodation_payments`
--

CREATE TABLE `guest_accommodation_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deposit` tinyint(4) NOT NULL DEFAULT 0,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `deposit_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_accommodation_payments`
--

INSERT INTO `guest_accommodation_payments` (`id`, `value`, `date`, `comments`, `transaction_id`, `is_deposit`, `reservation_id`, `payment_method_id`, `deposit_type_id`, `created_at`, `updated_at`) VALUES
(1, 100.00, '2022-11-26', NULL, 'FE56767', 1, 20, 1, 1, '2022-11-26 05:59:59', '2022-11-26 05:59:59'),
(2, 10.00, '2022-11-26', NULL, 'FNEF6787', 1, 19, 1, 1, '2022-11-26 06:00:32', '2022-11-26 06:00:32'),
(3, 100.00, '2022-11-26', NULL, '', 0, 20, 2, NULL, '2022-11-26 06:08:14', '2022-11-26 06:08:14'),
(4, 60.00, '2022-11-26', NULL, 'BEF6767', 0, 20, 1, NULL, '2022-11-26 06:23:31', '2022-11-26 06:23:31'),
(5, 50.00, '2022-11-26', NULL, 'VEF6789876', 0, 20, 1, NULL, '2022-11-26 06:28:32', '2022-11-26 06:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `guest_extras_payments`
--

CREATE TABLE `guest_extras_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_overnight_tax_payments`
--

CREATE TABLE `guest_overnight_tax_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_budgets`
--

CREATE TABLE `hotel_budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL,
  `budget_year` int(11) NOT NULL,
  `january` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `february` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `march` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `april` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `may` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `june` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `july` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `august` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `september` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `october` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `november` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `december` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_settings`
--

CREATE TABLE `hotel_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `general_commercial_register` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_receiver_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_tax` double(8,2) NOT NULL,
  `cancellation_vat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `overnight_tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cookie_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered_checkin_hour` time NOT NULL,
  `ordered_checkout_hour` time NOT NULL,
  `housekeeping` int(11) NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `cashier_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complimentary_rate` double(8,2) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `swift_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_status` tinyint(1) NOT NULL,
  `oxygen_api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_settings`
--

INSERT INTO `hotel_settings` (`id`, `created_by_id`, `logo`, `name`, `brand_name`, `activity`, `tax_id`, `tax_office`, `general_commercial_register`, `address`, `postal_code`, `city`, `phone`, `website`, `email`, `notification_receiver_email`, `vat_id`, `city_tax`, `cancellation_vat_id`, `overnight_tax_id`, `cookie_value`, `ordered_checkin_hour`, `ordered_checkout_hour`, `housekeeping`, `currency_id`, `date`, `cashier_pass`, `complimentary_rate`, `bank_name`, `swift_code`, `iban`, `bank_status`, `oxygen_api_key`, `created_at`, `updated_at`) VALUES
(1, 2, 'http://localhost/images/logo/logo.png', 'HotelPoint', 'Test Brand', 'Test Activity', '123455', 'Islamabad', '4321', 'test address', 1234, 'Quetta', '03041234123', 'test.com', 'test@test.com', 'test@test.com', 1, 0.50, 1, 1, 'none yet', '07:11:06', '07:11:06', 1, 33, '2022-11-13', '$2y$10$WkCyqnSXc5InojZDrrGiduuh40/8qZyjSvqJGD.1VjhSyr6vCHkca', 5.00, 'ABC', '32421', 'aej33r4', 1, 'faee7ef0-5bd9-4751-acd2-ebb0699bd832', '2022-11-13 02:58:06', '2022-11-21 15:23:02'),
(2, 2, 'http://localhost/images/logo/logo.png', 'Sun Hotel', 'Test Brand', 'Test Activity', '123455', 'Islamabad', '4321', 'test address', 1234, 'Quetta', '123456789123', 'test.com', 'test@test.com', 'test@test.com', NULL, 5.00, NULL, 1, 'none yet', '11:11:40', '11:11:40', 1, 33, '2022-11-18', '123456', 5.00, 'ABC', '32421', 'aej33r4', 1, NULL, '2022-11-18 06:52:40', '2022-11-18 06:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_settings_users`
--

CREATE TABLE `hotel_settings_users` (
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_settings_users`
--

INSERT INTO `hotel_settings_users` (`hotel_settings_id`, `user_id`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_tax_categories`
--

CREATE TABLE `hotel_tax_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` int(11) NOT NULL,
  `tax` double(5,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_tax_categories`
--

INSERT INTO `hotel_tax_categories` (`id`, `category`, `tax`, `description`, `created_at`, `updated_at`) VALUES
(1, 6, 0.50, '1-2 star Hotels', '2022-11-13 02:58:05', '2022-11-13 02:58:05'),
(2, 7, 1.50, '3 star Hotels', '2022-11-13 02:58:05', '2022-11-13 02:58:05'),
(3, 8, 3.00, '4 star Hotels', '2022-11-13 02:58:06', '2022-11-13 02:58:06'),
(4, 9, 4.00, '5 star Hotels', '2022-11-13 02:58:06', '2022-11-13 02:58:06'),
(5, 10, 0.50, 'Apartments- rooms', '2022-11-13 02:58:06', '2022-11-13 02:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_vats`
--

CREATE TABLE `hotel_vats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `oxygen_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `vat_option_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_vats`
--

INSERT INTO `hotel_vats` (`id`, `oxygen_id`, `hotel_settings_id`, `vat_option_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(2, NULL, 1, 2, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(3, NULL, 1, 3, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(4, NULL, 1, 4, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(5, NULL, 1, 5, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(6, NULL, 1, 6, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(7, NULL, 1, 8, '2022-11-13 02:58:10', '2022-11-13 02:58:10'),
(8, NULL, 2, 1, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(9, NULL, 2, 2, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(10, NULL, 2, 3, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(11, NULL, 2, 4, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(12, NULL, 2, 5, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(13, NULL, 2, 6, '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(14, NULL, 2, 8, '2022-11-18 06:52:41', '2022-11-18 06:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ids` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `ids`, `room_id`, `start_date`, `end_date`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(1, 'a1', 12, '2022-11-16', '2022-11-19', 'true', 'Sanitary issue', '2022-11-16 05:57:48', '2022-11-16 05:57:48'),
(8, 'a1', 7, '2022-11-19', '2022-11-29', 'true', 'bein', '2022-11-19 03:25:27', '2022-11-19 03:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_01_31_132735_create_currencies_table', 1),
(2, '2014_08_09_193349_create_countries_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_01_13_141315_create_permission_tables', 1),
(8, '2022_01_16_003129_create_payment_modes_table', 1),
(9, '2022_01_16_003130_create_payment_methods_table', 1),
(10, '2022_01_16_003231_create_booking_agencies_table', 1),
(11, '2022_01_19_050310_create_guests_table', 1),
(12, '2022_01_19_050716_create_room_types_table', 1),
(13, '2022_01_19_050932_create_rooms_table', 1),
(14, '2022_01_19_062507_create_companies_table', 1),
(15, '2022_01_19_062625_create_rate_type_cancellation_policies_table', 1),
(16, '2022_01_19_062626_create_rate_type_categories_table', 1),
(17, '2022_01_19_062627_create_rate_types_table', 1),
(18, '2022_01_19_092241_create_reservations_table', 1),
(19, '2022_01_19_152101_create_daily_rates_table', 1),
(20, '2022_01_31_132103_create_hotel_settings_table', 1),
(21, '2022_01_31_134422_create_media_table', 1),
(22, '2022_02_01_212735_create_document_types_table', 1),
(23, '2022_02_02_150531_create_templates_table', 1),
(24, '2022_02_09_085931_create_maintenances_table', 1),
(25, '2022_02_12_072352_create_restrictions_table', 1),
(26, '2022_02_12_073122_create_availabilities_table', 1),
(27, '2022_02_13_103608_create_room_conditions_table', 1),
(28, '2022_02_13_130548_create_extra_charges_categories_table', 1),
(29, '2022_02_13_130656_create_extra_charges_types_table', 1),
(30, '2022_02_13_130732_create_extra_charges_table', 1),
(31, '2022_02_13_132534_create_reservation_extra_charges_table', 1),
(32, '2022_02_20_122205_create_deposit_types_table', 1),
(36, '2022_02_21_143848_create_ex_reservations_table', 1),
(37, '2022_02_26_101505_create_documents_table', 1),
(38, '2022_02_26_102712_create_document_infos_table', 1),
(39, '2022_02_26_103302_create_activities_table', 1),
(40, '2022_02_26_112817_create_suppliers_table', 1),
(41, '2022_02_26_112829_create_cost_of_sales_table', 1),
(42, '2022_02_26_112839_create_categories_table', 1),
(43, '2022_02_26_112849_create_descriptions_table', 1),
(44, '2022_02_26_112909_create_opex_data_table', 1),
(45, '2022_02_28_140425_create_cash_registers_table', 1),
(46, '2022_03_08_125547_create_reservation_deposits_table', 1),
(48, '2022_06_11_132440_create_properties_table', 1),
(49, '2022_06_12_065604_add_created_by_id_column_to_users_table', 1),
(50, '2022_06_25_064351_create_hotel_budgets_table', 1),
(51, '2022_07_24_182036_modify_indexes_and_guest_id_columns_of_ex_reservations_table', 1),
(52, '2022_08_09_093535_add_saas_relation_columns_to_multiple_tables', 1),
(53, '2022_08_17_180427_create_breakfast_percentages_table', 1),
(54, '2022_08_21_144558_create_hotel_settings_users', 1),
(55, '2022_08_25_053455_add_oxygen_api_key_column_to_hotel_settings_table', 1),
(56, '2022_08_25_055947_add_oxygen_id_column_to_payment_methods_table', 1),
(57, '2022_09_01_082029_add_hotel_settings_id_in_hotel_budget_and_documents', 1),
(58, '2022_09_12_102848_add_occupancy_payment_logic_column_to_rate_types_table', 1),
(59, '2022_09_14_085749_guest_company_oxygen_update', 1),
(60, '2022_09_14_174916_change_reference_code_column_type_to_string_in_rate_types_table', 1),
(61, '2022_09_22_082033_add_channex_columns_to_reservations_table', 1),
(62, '2022_10_11_093602_add_hotel_settings_id_to_templates_table', 1),
(63, '2022_10_17_052040_create_vat_options_table', 1),
(64, '2022_10_20_104430_create_hotel_vats_table', 1),
(65, '2022_10_22_120042_create_hotel_tax_categories_table', 1),
(66, '2022_10_23_144909_change_hotel_settings_columns_and_add_foreign_keys', 1),
(67, '2022_10_27_135214_change_reservation_column_type_channex_cards', 1),
(68, '2022_11_02_173801_change_document_info_field', 1),
(69, '2022_11_11_101317_add_oxygen_id_column_to_booking_agencies_table', 1),
(71, '2022_11_14_100930_add_foreign_keys_in_companies_table', 2),
(74, '2022_11_17_223904_update_column_types_in_table', 3),
(75, '2022_03_14_132723_create_comments_table', 4),
(79, '2022_02_21_133303_create_guest_overnight_tax_payments_table', 7),
(80, '2022_02_21_064908_create_guest_accommodation_payments_table', 8),
(81, '2022_02_21_132419_create_guest_extras_payments_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 2),
(6, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 2),
(8, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 2),
(9, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 2),
(10, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 2),
(11, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 2),
(12, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 2),
(13, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 2),
(14, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 2),
(15, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 2),
(16, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 2),
(17, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 2),
(18, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 2),
(19, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 2),
(20, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 2),
(21, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 2),
(22, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 2),
(23, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 2),
(24, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 2),
(25, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 2),
(26, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 2),
(27, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 2),
(28, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 2),
(29, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 2),
(30, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 2),
(31, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 2),
(32, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 2),
(33, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 2),
(34, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 2),
(35, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 2),
(36, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 2),
(37, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 2),
(38, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 2),
(39, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 2),
(40, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 2),
(41, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 2),
(42, 'App\\Models\\User', 1),
(42, 'App\\Models\\User', 2),
(43, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 2),
(44, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 2),
(45, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 2),
(46, 'App\\Models\\User', 1),
(46, 'App\\Models\\User', 2),
(47, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 2),
(48, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 2),
(49, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 2),
(50, 'App\\Models\\User', 1),
(50, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `opex_data`
--

CREATE TABLE `opex_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cos_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `description_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opex_data`
--

INSERT INTO `opex_data` (`id`, `hotel_settings_id`, `date`, `invoice_number`, `invoice_type`, `amount`, `vat`, `payment`, `file`, `bill_no`, `cos_id`, `category_id`, `description_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-11-09', '345678', 'Invoice', '1200', '11', 'Cash', 'opex_form-1669495194.pdf', '', 2, 2, 24, 1, '2022-11-26 15:39:54', '2022-11-26 15:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_card_type` tinyint(1) NOT NULL,
  `channex_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oxygen_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `hotel_settings_id`, `name`, `commission_percentage`, `is_card_type`, `channex_id`, `oxygen_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Visa', '10', 1, 'VI', '46b8caee-3b40-48e3-a2b8-f956feb07175', '2022-11-14 02:03:07', '2022-11-14 02:03:07'),
(2, 1, 'Cash', '10', 0, 'Cash', 'e14b9ef1-33a7-4750-95cc-d9df26173584', '2022-11-14 02:03:31', '2022-11-14 02:03:31'),
(3, 1, 'ELO', '11', 1, 'EL', '03615f6d-8b99-4f3c-8de0-68bfae6ddc99', '2022-11-14 15:27:09', '2022-11-14 15:27:09'),
(4, 1, 'BC', '13', 1, 'BC', '341395f5-ee21-4288-9b98-7281e0306aa9', '2022-11-14 15:29:21', '2022-11-14 15:29:21'),
(5, 2, 'Visa', '11', 1, 'VI', NULL, '2022-11-18 06:56:00', '2022-11-18 06:56:00'),
(6, 2, 'Cash', '11', 0, 'Cash', NULL, '2022-11-18 06:56:16', '2022-11-18 06:56:52'),
(7, 2, 'Master Card', '11', 1, 'MC', NULL, '2022-11-18 06:56:29', '2022-11-18 06:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE `payment_modes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`id`, `hotel_settings_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Guests Settles Extras', '2022-11-13 02:58:08', '2022-11-13 02:58:08'),
(2, 1, 'Pay Own Account', '2022-11-13 02:58:08', '2022-11-13 02:58:08'),
(3, 1, 'Company Full Account ', '2022-11-13 02:58:08', '2022-11-13 02:58:08'),
(4, 2, 'Guests Settles Extras', '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(5, 2, 'Pay Own Account', '2022-11-18 06:52:41', '2022-11-18 06:52:41'),
(6, 2, 'Company Full Account ', '2022-11-18 06:52:41', '2022-11-18 06:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Account Report', 'web', NULL, NULL),
(2, 'Actual Budget', 'web', NULL, NULL),
(3, 'Add Supplier', 'web', NULL, NULL),
(4, 'B2B Report', 'web', NULL, NULL),
(5, 'Booking Channels', 'web', NULL, NULL),
(6, 'Booking Engine', 'web', NULL, NULL),
(7, 'Calendar', 'web', NULL, NULL),
(8, 'Cancel Reservation', 'web', NULL, NULL),
(9, 'Cancellation Fee', 'web', NULL, NULL),
(10, 'Channel', 'web', NULL, NULL),
(11, 'Channel Manager', 'web', NULL, NULL),
(12, 'Commission', 'web', NULL, NULL),
(13, 'Commission List', 'web', NULL, NULL),
(14, 'Companies', 'web', NULL, NULL),
(15, 'Credit Card List', 'web', NULL, NULL),
(16, 'Credit Note', 'web', NULL, NULL),
(17, 'Daily Cashier', 'web', NULL, NULL),
(18, 'Debtor Ledger', 'web', NULL, NULL),
(19, 'Ex Reservation', 'web', NULL, NULL),
(20, 'Extra Charge', 'web', NULL, NULL),
(21, 'Finance', 'web', NULL, NULL),
(22, 'Guest Profile', 'web', NULL, NULL),
(23, 'Hotel Budget', 'web', NULL, NULL),
(24, 'Hotel Setting', 'web', NULL, NULL),
(25, 'Housekeeping', 'web', NULL, NULL),
(26, 'Inventory', 'web', NULL, NULL),
(27, 'Invoice List', 'web', NULL, NULL),
(28, 'KPI Report', 'web', NULL, NULL),
(29, 'Meal Categories', 'web', NULL, NULL),
(30, 'Modified Reservation', 'web', NULL, NULL),
(31, 'No Show List', 'web', NULL, NULL),
(32, 'Opex', 'web', NULL, NULL),
(33, 'Opex Form', 'web', NULL, NULL),
(34, 'Opex List', 'web', NULL, NULL),
(35, 'Opex Report', 'web', NULL, NULL),
(36, 'Overnight Tax', 'web', NULL, NULL),
(37, 'Payment Tracker', 'web', NULL, NULL),
(38, 'Rate Plan', 'web', NULL, NULL),
(39, 'Receipt List', 'web', NULL, NULL),
(40, 'Reporting', 'web', NULL, NULL),
(41, 'Reservation List', 'web', NULL, NULL),
(42, 'Reservations', 'web', NULL, NULL),
(43, 'Revenue Report', 'web', NULL, NULL),
(44, 'Room and Rates', 'web', NULL, NULL),
(45, 'Room Division Report', 'web', NULL, NULL),
(46, 'Room Type and Rooms', 'web', NULL, NULL),
(47, 'Settings', 'web', NULL, NULL),
(48, 'Special Annual Doc', 'web', NULL, NULL),
(49, 'Tax Document', 'web', NULL, NULL),
(50, 'User Setting', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Channex API', 'fb36da95a3edee520385a5bdfba6406471f5cec2c9805bba43959bb6329120ce', '[\"*\"]', '2022-11-22 17:18:06', '2022-11-21 03:06:36', '2022-11-22 17:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `hotel_id`, `property_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Channex', 1, 'f4bb401b-ce2a-42ff-bb6d-6af790b51caf', 1, '2022-11-14 01:59:04', '2022-11-14 02:56:57'),
(2, 'Channex', 2, '1a149ef7-d852-4328-9cab-d6c37880e19a', 1, '2022-11-18 06:52:40', '2022-11-18 06:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `rate_types`
--

CREATE TABLE `rate_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `reservation_rate` int(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `charge_type` int(11) NOT NULL,
  `reservation_charge_days` int(11) NOT NULL,
  `charge2` int(11) NOT NULL,
  `reservation_charge_days_2` int(11) NOT NULL,
  `charge_percentage` int(11) NOT NULL,
  `no_show_charge_percentage` int(11) NOT NULL,
  `early_checkout_charge_percentage` int(11) NOT NULL,
  `description_to_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prepayment` int(11) DEFAULT NULL,
  `channex_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `rate_type_category_id` bigint(20) UNSIGNED NOT NULL,
  `primary_occupancy` int(11) NOT NULL,
  `parent_rate_plan_id` int(11) DEFAULT NULL,
  `sell_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancellation_charge` int(11) NOT NULL,
  `cancellation_charge_days` int(11) NOT NULL,
  `reference_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_type_cancellation_policy_id` bigint(20) UNSIGNED NOT NULL,
  `children_fee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `infant_fee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_rate_increase_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_rate_increase_vale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_rate_decrease_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_rate_decrease_vale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cascade_select_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cascade_select_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupancy_logic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rate_types`
--

INSERT INTO `rate_types` (`id`, `hotel_settings_id`, `name`, `status`, `reservation_rate`, `charge`, `charge_type`, `reservation_charge_days`, `charge2`, `reservation_charge_days_2`, `charge_percentage`, `no_show_charge_percentage`, `early_checkout_charge_percentage`, `description_to_document`, `prepayment`, `channex_id`, `room_type_id`, `rate_type_category_id`, `primary_occupancy`, `parent_rate_plan_id`, `sell_mode`, `rate_mode`, `cancellation_charge`, `cancellation_charge_days`, `reference_code`, `rate_type_cancellation_policy_id`, `children_fee`, `infant_fee`, `auto_rate_increase_type`, `auto_rate_increase_vale`, `auto_rate_decrease_type`, `auto_rate_decrease_vale`, `cascade_select_type`, `cascade_select_value`, `occupancy_logic`, `created_at`, `updated_at`) VALUES
(1, 1, 'Standard', 1, 100, 50, 0, 5, 0, 0, 10, 50, 50, 'Breakfast', 50, '583b62a0-fed9-4b64-bd08-b88ba5b7cca6', 3, 1, 2, NULL, 'per_person', 'manual', 100, 4, 'SRT', 1, '10', '5', NULL, NULL, NULL, NULL, NULL, NULL, '\"\"', '2022-11-15 03:46:05', '2022-11-15 03:46:05'),
(2, 1, 'Standard Rate', 1, 100, 0, 0, 0, 0, 0, 10, 60, 40, 'Breakfast', 100, 'c8c1219b-5a1e-48ad-a9e5-a5d761d27365', 4, 1, 2, NULL, 'per_person', 'manual', 10, 3, 'STD', 2, '10', '5', NULL, NULL, NULL, NULL, NULL, NULL, '\"\"', '2022-11-15 09:21:03', '2022-11-15 09:21:03'),
(6, 1, 'Derived', 1, 100, 0, 0, 0, 0, 0, 10, 20, 20, 'Breakfast', 100, '0a46dfc1-7a72-4b74-982a-e61180f574bc', 4, 1, 2, 2, 'per_person', 'derived', 20, 14, 'DD', 2, '5', '0', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"modifier\":\"increase_by_amount\",\"value\":null},{\"modifier\":\"decrease_by_amount\",\"value\":\"10\"}]', '2022-11-17 17:01:27', '2022-11-17 17:06:45'),
(7, 1, 'Cascade', 1, 100, 0, 0, 0, 0, 0, 10, 25, 35, 'Breakfast', 100, '43595673-c082-40fc-b64b-ba8ecdf63da2', 4, 1, 2, 2, 'per_person', 'cascade', 20, 3, 'CSS', 2, '20', '10', NULL, NULL, NULL, NULL, 'increase_by_amount', '10', '[]', '2022-11-17 17:04:03', '2022-11-17 17:04:03'),
(8, 2, 'Standard', 1, 100, 100, 1, 14, 0, 0, 5, 100, 100, 'Breakfast', 0, '40c146da-b2e8-4de4-b3c8-1833e9ce9c32', 5, 2, 2, NULL, 'per_person', 'derived', 100, 14, 'SUITE', 6, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '{\"1\":{\"modifier\":\"decrease_by_percent\",\"value\":\"0\"}}', NULL, NULL),
(14, 1, 'derived Test 1', 1, 100, 0, 0, 0, 0, 0, 10, 100, 100, 'Breakfast', 100, '968fec1c-1ab2-49ef-8487-63823be0809d', 3, 1, 2, NULL, 'per_person', 'derived', 100, 12, 'DRRR', 2, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"modifier\":\"decrease_by_amount\",\"value\":null},{\"modifier\":\"decrease_by_amount\",\"value\":\"10\"}]', '2022-11-23 08:09:09', '2022-11-23 08:09:09'),
(15, 1, 'Derived without rate', 1, 100, 0, 0, 0, 0, 0, 10, 100, 100, 'Breakfast', 100, 'be0a5667-a58f-4298-8b5b-d5039b516bb6', 4, 1, 2, NULL, 'per_person', 'derived', 100, 11, 'DWR', 2, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"modifier\":\"decrease_by_amount\",\"value\":null},{\"modifier\":\"decrease_by_amount\",\"value\":\"10\"},{\"modifier\":\"decrease_by_amount\",\"value\":null},{\"modifier\":\"increase_by_amount\",\"value\":\"10\"},{\"modifier\":\"increase_by_amount\",\"value\":\"10\"},{\"modifier\":\"increase_by_amount\",\"value\":\"10\"}]', '2022-11-23 08:12:53', '2022-11-23 08:14:19'),
(16, 1, 'Derive with few rates', 1, 100, 0, 0, 0, 0, 0, 10, 100, 100, 'Breakfast', 100, 'f3d075fa-9ba5-4273-a972-7a920be3eb78', 4, 1, 2, NULL, 'per_person', 'derived', 100, 11, 'DWFR', 2, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"modifier\":\"decrease_by_amount\",\"value\":null},{\"modifier\":\"decrease_by_amount\",\"value\":\"10\"},{\"modifier\":\"increase_by_amount\",\"value\":null},{\"modifier\":\"increase_by_amount\",\"value\":\"0\"},{\"modifier\":\"increase_by_amount\",\"value\":\"10\"},{\"modifier\":\"increase_by_amount\",\"value\":\"10\"}]', '2022-11-23 08:16:12', '2022-11-23 08:16:12'),
(17, 1, 'Derived Rate 1', 1, 100, 0, 0, 0, 0, 0, 10, 100, 100, 'Breakfast', 100, '243717fc-64fb-4f8b-bb5e-bad75f070988', 3, 1, 2, NULL, 'per_person', 'derived', 100, 12, 'DDR', 2, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"modifier\":\"decrease_by_amount\",\"value\":null},{\"modifier\":\"decrease_by_amount\",\"value\":\"0.1\"}]', '2022-11-24 04:36:14', '2022-11-24 04:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `rate_type_cancellation_policies`
--

CREATE TABLE `rate_type_cancellation_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rate_type_cancellation_policies`
--

INSERT INTO `rate_type_cancellation_policies` (`id`, `hotel_settings_id`, `name`, `amount`, `charge_days`, `created_at`, `updated_at`) VALUES
(1, 1, 'Based At Nights', '0', '0', NULL, NULL),
(2, 1, 'Based At Percent', '0', '0', NULL, NULL),
(3, 1, 'Fixed Amount Per Booking', '0', '0', NULL, NULL),
(4, 1, 'Fixed Amount Per Booking Room', '0', '0', NULL, NULL),
(5, 2, 'Based At Nights', '0', '0', NULL, NULL),
(6, 2, 'Based At Percent', '0', '0', NULL, NULL),
(7, 2, 'Fixed Amount Per Booking', '0', '0', NULL, NULL),
(8, 2, 'Fixed Amount Per Booking Room', '0', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rate_type_categories`
--

CREATE TABLE `rate_type_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_to_document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_breakfast` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rate_type_categories`
--

INSERT INTO `rate_type_categories` (`id`, `hotel_settings_id`, `name`, `charge_percentage`, `vat`, `desc_to_document`, `has_breakfast`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bed and Breakfast', '10', '11', 'Breakfast', '1', '2022-11-15 03:43:29', '2022-11-15 03:43:29'),
(2, 2, 'Bed and Breakfast', '11', '11', 'Breakfast', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channex_booking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channex_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_agency_id` bigint(20) UNSIGNED NOT NULL,
  `revenue_amount_accommodation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `payment_mode_id` bigint(20) UNSIGNED NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival_date` date NOT NULL,
  `departure_date` date NOT NULL,
  `actual_checkin` date DEFAULT NULL,
  `actual_checkout` date DEFAULT NULL,
  `overnights` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_hour` time DEFAULT NULL,
  `cancellation_date` date DEFAULT NULL,
  `offer_expire_date` date DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `adults` int(11) NOT NULL,
  `kids` int(11) NOT NULL,
  `infants` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `checkin_guest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reservation_amount` double(8,2) DEFAULT NULL,
  `commission_amount` double(8,2) DEFAULT NULL,
  `reservation_revision_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_inserted_at` datetime DEFAULT NULL,
  `reservation_payment_collect` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channex_booking_room_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ota_reservation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `virtual_card` int(11) DEFAULT NULL,
  `notif_status` int(11) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `channex_cards` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `hotel_settings_id`, `booking_code`, `channex_booking_id`, `channex_status`, `status`, `booking_agency_id`, `revenue_amount_accommodation`, `charge_date`, `payment_method_id`, `payment_mode_id`, `discount`, `check_in`, `check_out`, `arrival_date`, `departure_date`, `actual_checkin`, `actual_checkout`, `overnights`, `arrival_hour`, `cancellation_date`, `offer_expire_date`, `country_id`, `adults`, `kids`, `infants`, `booking_date`, `comment`, `guest_id`, `checkin_guest_id`, `rate_type_id`, `room_id`, `reservation_amount`, `commission_amount`, `reservation_revision_id`, `system_id`, `reservation_inserted_at`, `reservation_payment_collect`, `channex_booking_room_id`, `reservation_unique_id`, `ota_reservation_code`, `virtual_card`, `notif_status`, `company_id`, `channex_cards`, `created_at`, `updated_at`) VALUES
(19, 1, '341F691B79', '4f167e3a-8b6e-4ef3-8b9d-02b811e90e98', 'cancelled', 'Cancelled', 2, '1', '2022-11-20', 1, 1, '0', '2022-11-20', '2022-11-23', '2022-11-20', '2022-11-23', '2022-11-20', '2022-11-21', '3', '22:20:00', NULL, NULL, 161, 1, 0, 0, '2022-11-20', NULL, 21, 21, 2, 10, 300.00, 0.00, '713283f1-bd28-4b0d-8caa-1dc101ad2720', '7030cd03-c40c-4fff-85d1-ae3ef416a408', '2022-11-20 07:57:45', 'property', '43954ad8-7587-46b9-8b67-bedeb4a4859a', 'OSA-341F691B79', '341F691B79', 0, 0, NULL, 'f4c922401dfd4b45ab30cd94f08cdc6f', '2022-11-20 03:35:24', '2022-11-21 13:14:58'),
(20, 1, 'OSA-341F691B79', '4f167e3a-8b6e-4ef3-8b9d-02b811e90e98', 'new', 'Confirmed', 2, '1', '2022-11-20', 1, 1, '0', '2022-11-20', '2022-11-24', '2022-11-20', '2022-11-24', NULL, NULL, '4', NULL, NULL, NULL, 161, 1, 0, 0, '2022-11-20', NULL, 22, NULL, 2, 11, 800.00, 0.00, '713283f1-bd28-4b0d-8caa-1dc101ad2720', '7030cd03-c40c-4fff-85d1-ae3ef416a408', '2022-11-20 07:57:45', 'property', '43954ad8-7587-46b9-8b67-bedeb4a4859a', 'OSA-341F691B79', 'OSA-341F691B79', 0, 0, NULL, '', '2022-11-20 04:02:13', '2022-11-23 06:47:10'),
(21, 1, '9000000001', NULL, 'cancelled', 'Cancelled', 1, NULL, '2022-11-21', 2, 2, '0', '2022-12-01', '2022-12-03', '2022-12-01', '2022-12-03', NULL, NULL, '2', NULL, '2022-11-21', NULL, 161, 1, 0, 0, '2022-11-21', 'abc', 23, NULL, 6, 10, 1100.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-21 13:18:59', '2022-11-21 13:19:38'),
(22, 2, 'OSA-1D19356F12', '29c85ff0-c80c-495d-9d60-6d2c5dc9559b', 'new', 'Confirmed', 3, '1', '2022-11-23', 5, 5, '0', '2022-12-01', '2022-12-03', '2022-12-01', '2022-12-03', NULL, NULL, '2', NULL, NULL, NULL, 39, 2, 0, 0, '2022-11-23', 'airport pick up ', 24, NULL, 8, 13, 1800.00, 0.00, 'bccb458e-c8da-4d5a-bf7e-862c33fb5e91', 'e6cf00e2-2294-4711-bc90-4601ca808cbc', '2022-11-23 16:01:51', 'property', '97c7efae-7f45-4c94-89be-3349f6915729', 'OSA-1D19356F12', 'OSA-1D19356F12', 0, 0, NULL, '', '2022-11-23 14:27:05', '2022-11-23 14:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_deposits`
--

CREATE TABLE `reservation_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `has_prepayment` int(11) NOT NULL,
  `prepayment_value` double(8,2) DEFAULT NULL,
  `prepayment_date_to_pay` date DEFAULT NULL,
  `prepayment_is_paid` int(11) DEFAULT NULL,
  `prepayment_payment_date` date DEFAULT NULL,
  `has_first_charge` int(11) NOT NULL,
  `first_charge_value` double(8,2) DEFAULT NULL,
  `first_charge_date_to_pay` date DEFAULT NULL,
  `first_charge_is_paid` int(11) DEFAULT NULL,
  `first_charge_payment_date` date DEFAULT NULL,
  `has_second_charge` int(11) NOT NULL,
  `second_charge_value` double(8,2) DEFAULT NULL,
  `second_charge_date_to_pay` date DEFAULT NULL,
  `second_charge_is_paid` int(11) DEFAULT NULL,
  `second_charge_payment_date` date DEFAULT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation_deposits`
--

INSERT INTO `reservation_deposits` (`id`, `has_prepayment`, `prepayment_value`, `prepayment_date_to_pay`, `prepayment_is_paid`, `prepayment_payment_date`, `has_first_charge`, `first_charge_value`, `first_charge_date_to_pay`, `first_charge_is_paid`, `first_charge_payment_date`, `has_second_charge`, `second_charge_value`, `second_charge_date_to_pay`, `second_charge_is_paid`, `second_charge_payment_date`, `reservation_id`, `created_at`, `updated_at`) VALUES
(9, 1, 100.00, '2022-11-20', 0, NULL, 0, 0.00, NULL, 0, NULL, 0, 0.00, NULL, 0, NULL, 19, '2022-11-20 03:35:24', '2022-11-20 03:35:24'),
(10, 1, 100.00, '2022-11-20', 0, NULL, 0, 0.00, NULL, 0, NULL, 0, 0.00, NULL, 0, NULL, 20, '2022-11-20 04:02:13', '2022-11-20 04:02:13'),
(11, 0, 0.00, NULL, 0, NULL, 1, 1800.00, '2022-12-01', 0, NULL, 0, 0.00, NULL, 0, NULL, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_extra_charges`
--

CREATE TABLE `reservation_extra_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `units` int(11) NOT NULL,
  `extra_charge_total` double(8,2) NOT NULL,
  `receipt_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `extra_charge_discount` double(8,2) NOT NULL,
  `is_paid` int(11) NOT NULL DEFAULT 0,
  `extra_charge_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restrictions`
--

CREATE TABLE `restrictions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `rate_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2022-11-13 02:57:49', '2022-11-13 02:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `max_adults` int(11) NOT NULL,
  `max_kids` int(11) NOT NULL,
  `max_infants` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `status`, `room_type_id`, `max_capacity`, `max_adults`, `max_kids`, `max_infants`, `created_at`, `updated_at`) VALUES
(7, 'SNG-001', 'Enabled', 3, 2, 2, 0, 1, NULL, NULL),
(8, 'SNG-002', 'Enabled', 3, 2, 2, 0, 1, NULL, NULL),
(9, 'SNG-003', 'Disabled', 3, 2, 2, 0, 1, NULL, NULL),
(10, 'DBL-001', 'Enabled', 4, 2, 2, 1, 1, NULL, NULL),
(11, 'DBL-002', 'Enabled', 4, 2, 2, 1, 1, NULL, NULL),
(12, 'DBL-003', 'Enabled', 4, 2, 2, 1, 1, NULL, NULL),
(13, 'SUIT-001', 'Enabled', 5, 3, 2, 0, 0, NULL, NULL),
(14, 'SUIT-002', 'Enabled', 5, 3, 2, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_conditions`
--

CREATE TABLE `room_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_conditions`
--

INSERT INTO `room_conditions` (`id`, `status`, `date`, `room_id`, `reservation_id`, `created_at`, `updated_at`) VALUES
(11, 'Clean', '2022-11-22', 13, 9, '2022-11-18 08:26:29', '2022-11-18 08:26:29'),
(12, 'Clean', '2022-11-23', 13, 9, '2022-11-18 08:26:29', '2022-11-18 08:26:29'),
(13, 'Dirty', '2022-11-24', 13, 9, '2022-11-18 08:26:29', '2022-11-18 08:26:29'),
(14, 'Clean', '2022-11-22', 14, 10, '2022-11-18 08:28:03', '2022-11-18 08:28:03'),
(15, 'Clean', '2022-11-23', 14, 10, '2022-11-18 08:28:03', '2022-11-18 08:28:03'),
(16, 'Dirty', '2022-11-24', 14, 10, '2022-11-18 08:28:03', '2022-11-18 08:28:03'),
(17, 'Dirty', '2022-11-22', 14, 11, '2022-11-18 10:06:54', '2022-11-18 10:06:54'),
(18, 'Clean', '2022-11-23', 14, 11, '2022-11-18 10:06:54', '2022-11-18 10:06:54'),
(19, 'Dirty', '2022-11-24', 14, 11, '2022-11-18 10:06:55', '2022-11-18 10:06:55'),
(20, 'Dirty', '2022-11-22', 13, 12, '2022-11-18 10:25:28', '2022-11-18 10:25:28'),
(21, 'Clean', '2022-11-23', 13, 12, '2022-11-18 10:25:28', '2022-11-18 10:25:28'),
(22, 'Dirty', '2022-11-24', 13, 12, '2022-11-18 10:25:28', '2022-11-18 10:25:28'),
(23, 'Clean', '2022-11-20', 10, 19, '2022-11-20 03:35:24', '2022-11-20 03:35:24'),
(24, 'Clean', '2022-11-20', 11, 20, '2022-11-20 04:02:13', '2022-11-20 04:02:13'),
(25, 'Clean', '2022-12-01', 13, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05'),
(26, 'Clean', '2022-12-02', 13, 22, '2022-11-23 14:27:05', '2022-11-23 14:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channex_room_type_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_status` int(11) NOT NULL,
  `adults_channex` int(11) NOT NULL,
  `kids_channex` int(11) NOT NULL,
  `infants_channex` int(11) NOT NULL,
  `default_occupancy_channex` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `cancellation_charge` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `hotel_settings_id`, `name`, `channex_room_type_id`, `reference_code`, `description`, `type_status`, `adults_channex`, `kids_channex`, `infants_channex`, `default_occupancy_channex`, `position`, `cancellation_charge`, `created_at`, `updated_at`) VALUES
(3, 1, 'Single Room', '7f370364-3fca-40d3-8019-25f3012b48f3', 'SNG', 'ABC', 1, 2, 1, 0, 2, 0, 0, '2022-11-14 03:00:53', '2022-11-14 03:00:55'),
(4, 1, 'Double Room', 'faf9e9db-181c-4e16-838e-844b26d0574f', 'DBL', 'XYZ', 1, 5, 1, 1, 2, 0, 0, '2022-11-15 09:19:24', '2022-11-15 09:19:26'),
(5, 2, 'Suite', '0c4c1a8e-d45b-4bfe-b08c-7e238c643611', 'SUIT', '55 sqrmeter Terrace', 1, 2, 0, 0, 2, 0, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `hotel_settings_id`, `name`, `tax_number`, `address`, `category`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ayesha Sehar', '34567', 'BWI WJ', 'F&B', 'ayesha@gmail.coom', '9876567', '2022-11-26 15:35:07', '2022-11-26 15:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_settings_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `hotel_settings_id`, `name`, `template`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'George template', '<p>Name: [guest_name]</p><p>Phone No: [guest_phone]</p><p>Email: [guest_email]</p>', 'checkin', '2022-11-14 13:13:39', '2022-11-20 17:42:11'),
(2, 2, 'sun template', '<p>Name:</p><p><br></p><p>Email:</p>', 'checkin', '2022-11-20 17:41:29', '2022-11-20 17:41:29'),
(3, 1, 'Email Template', '<p>Name:  [guest_name]</p><p>Emial: [guest_email]</p><p>Daily rate: [daily_rate]</p><p>Reservation amount : [total_reservation_amount]</p>', 'email', '2022-11-23 06:45:41', '2022-11-23 06:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_by_id`, `first_name`, `last_name`, `role`, `email`, `address`, `phone`, `email_verified_at`, `password`, `country_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 'Super Administrator', 'super_admin@test.com', 'abc', '12341234', '2022-11-13 02:57:49', '$2y$10$g89iEeY3CLC3OIybb46EI.17rayYJdRmUZEa.2IFLKbhme2suU9jG', 22, NULL, '2022-11-13 02:57:50', '2022-11-13 02:57:50'),
(2, 1, 'George', 'KA', 'Administrator', 'george@test.com', 'abc', '12341234', '2022-11-13 02:57:49', '$2y$10$8CkyBfYcJvpBlaSL3BiwrOzBFSo40VL9k/U9SzKsQ9.AxEs9vc9Ia', 71, NULL, '2022-11-13 02:57:56', '2022-11-13 02:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `vat_options`
--

CREATE TABLE `vat_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vat_options`
--

INSERT INTO `vat_options` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, '24', '2022-11-13 02:58:04', '2022-11-13 02:58:04'),
(2, '13', '2022-11-13 02:58:04', '2022-11-13 02:58:04'),
(3, '6', '2022-11-13 02:58:04', '2022-11-13 02:58:04'),
(4, '17', '2022-11-13 02:58:05', '2022-11-13 02:58:05'),
(5, '9', '2022-11-13 02:58:05', '2022-11-13 02:58:05'),
(6, '4', '2022-11-13 02:58:05', '2022-11-13 02:58:05'),
(8, '0', '2022-11-13 02:58:05', '2022-11-13 02:58:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_reservation_id_foreign` (`reservation_id`),
  ADD KEY `activities_document_id_foreign` (`document_id`);

--
-- Indexes for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availabilities_room_id_foreign` (`room_id`),
  ADD KEY `availabilities_room_type_id_foreign` (`room_type_id`),
  ADD KEY `availabilities_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `booking_agencies`
--
ALTER TABLE `booking_agencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_agencies_default_payment_mode_id_foreign` (`default_payment_mode_id`),
  ADD KEY `booking_agencies_virtual_card_payment_mode_id_foreign` (`virtual_card_payment_mode_id`),
  ADD KEY `booking_agencies_default_payment_method_id_foreign` (`default_payment_method_id`),
  ADD KEY `booking_agencies_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `breakfast_percentages`
--
ALTER TABLE `breakfast_percentages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `breakfast_percentages_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_cost_of_sale_id_foreign` (`cost_of_sale_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_room_id_foreign` (`room_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_hotel_settings_id_foreign` (`hotel_settings_id`),
  ADD KEY `companies_country_id_foreign` (`country_id`);

--
-- Indexes for table `cost_of_sales`
--
ALTER TABLE `cost_of_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_rates`
--
ALTER TABLE `daily_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_rates_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `deposit_types`
--
ALTER TABLE `deposit_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `descriptions_category_id_foreign` (`category_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `documents_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `document_infos`
--
ALTER TABLE `document_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_infos_company_id_foreign` (`company_id`),
  ADD KEY `document_infos_booking_agency_id_foreign` (`booking_agency_id`),
  ADD KEY `document_infos_document_id_foreign` (`document_id`),
  ADD KEY `document_infos_guest_id_foreign` (`guest_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_types_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `extra_charges`
--
ALTER TABLE `extra_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extra_charges_extra_charge_category_id_foreign` (`extra_charge_category_id`),
  ADD KEY `extra_charges_extra_charge_type_id_foreign` (`extra_charge_type_id`),
  ADD KEY `extra_charges_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `extra_charges_categories`
--
ALTER TABLE `extra_charges_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extra_charges_categories_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `extra_charges_types`
--
ALTER TABLE `extra_charges_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extra_charges_types_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `ex_reservations`
--
ALTER TABLE `ex_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ex_reservations_booking_agency_id_foreign` (`booking_agency_id`),
  ADD KEY `ex_reservations_country_id_foreign` (`country_id`),
  ADD KEY `ex_reservations_room_type_id_foreign` (`room_type_id`),
  ADD KEY `ex_reservations_guest_id_foreign` (`guest_id`),
  ADD KEY `ex_reservations_rate_type_id_foreign` (`rate_type_id`),
  ADD KEY `ex_reservations_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guests_country_id_foreign` (`country_id`);

--
-- Indexes for table `guest_accommodation_payments`
--
ALTER TABLE `guest_accommodation_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_accommodation_payments_reservation_id_foreign` (`reservation_id`),
  ADD KEY `guest_accommodation_payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `guest_accommodation_payments_deposit_type_id_foreign` (`deposit_type_id`);

--
-- Indexes for table `guest_extras_payments`
--
ALTER TABLE `guest_extras_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_extras_payments_reservation_id_foreign` (`reservation_id`),
  ADD KEY `guest_extras_payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `guest_overnight_tax_payments`
--
ALTER TABLE `guest_overnight_tax_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_overnight_tax_payments_reservation_id_foreign` (`reservation_id`),
  ADD KEY `guest_overnight_tax_payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `hotel_budgets`
--
ALTER TABLE `hotel_budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_budgets_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_settings_currency_id_foreign` (`currency_id`),
  ADD KEY `hotel_settings_created_by_id_foreign` (`created_by_id`),
  ADD KEY `hotel_settings_overnight_tax_id_foreign` (`overnight_tax_id`),
  ADD KEY `hotel_settings_vat_id_foreign` (`vat_id`),
  ADD KEY `hotel_settings_cancellation_vat_id_foreign` (`cancellation_vat_id`);

--
-- Indexes for table `hotel_settings_users`
--
ALTER TABLE `hotel_settings_users`
  ADD KEY `hotel_settings_users_hotel_settings_id_foreign` (`hotel_settings_id`),
  ADD KEY `hotel_settings_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `hotel_tax_categories`
--
ALTER TABLE `hotel_tax_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_vats`
--
ALTER TABLE `hotel_vats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_vats_hotel_settings_id_foreign` (`hotel_settings_id`),
  ADD KEY `hotel_vats_vat_option_id_foreign` (`vat_option_id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_room_id_foreign` (`room_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `opex_data`
--
ALTER TABLE `opex_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opex_data_cos_id_foreign` (`cos_id`),
  ADD KEY `opex_data_category_id_foreign` (`category_id`),
  ADD KEY `opex_data_description_id_foreign` (`description_id`),
  ADD KEY `opex_data_supplier_id_foreign` (`supplier_id`),
  ADD KEY `opex_data_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_modes_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `rate_types`
--
ALTER TABLE `rate_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rate_types_room_type_id_foreign` (`room_type_id`),
  ADD KEY `rate_types_rate_type_category_id_foreign` (`rate_type_category_id`),
  ADD KEY `rate_types_rate_type_cancellation_policy_id_foreign` (`rate_type_cancellation_policy_id`),
  ADD KEY `rate_types_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `rate_type_cancellation_policies`
--
ALTER TABLE `rate_type_cancellation_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rate_type_cancellation_policies_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `rate_type_categories`
--
ALTER TABLE `rate_type_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rate_type_categories_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_booking_agency_id_foreign` (`booking_agency_id`),
  ADD KEY `reservations_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `reservations_payment_mode_id_foreign` (`payment_mode_id`),
  ADD KEY `reservations_country_id_foreign` (`country_id`),
  ADD KEY `reservations_guest_id_foreign` (`guest_id`),
  ADD KEY `reservations_checkin_guest_id_foreign` (`checkin_guest_id`),
  ADD KEY `reservations_rate_type_id_foreign` (`rate_type_id`),
  ADD KEY `reservations_company_id_foreign` (`company_id`),
  ADD KEY `reservations_hotel_settings_id_foreign` (`hotel_settings_id`),
  ADD KEY `reservations_room_id_foreign` (`room_id`);

--
-- Indexes for table `reservation_deposits`
--
ALTER TABLE `reservation_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_deposits_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `reservation_extra_charges`
--
ALTER TABLE `reservation_extra_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_extra_charges_extra_charge_id_foreign` (`extra_charge_id`),
  ADD KEY `reservation_extra_charges_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `restrictions`
--
ALTER TABLE `restrictions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restrictions_room_type_id_foreign` (`room_type_id`),
  ADD KEY `restrictions_rate_type_id_foreign` (`rate_type_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_conditions`
--
ALTER TABLE `room_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_conditions_room_id_foreign` (`room_id`),
  ADD KEY `room_conditions_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_types_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_hotel_settings_id_foreign` (`hotel_settings_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_id_foreign` (`created_by_id`);

--
-- Indexes for table `vat_options`
--
ALTER TABLE `vat_options`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `booking_agencies`
--
ALTER TABLE `booking_agencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `breakfast_percentages`
--
ALTER TABLE `breakfast_percentages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cost_of_sales`
--
ALTER TABLE `cost_of_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `daily_rates`
--
ALTER TABLE `daily_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `deposit_types`
--
ALTER TABLE `deposit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `document_infos`
--
ALTER TABLE `document_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `extra_charges`
--
ALTER TABLE `extra_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `extra_charges_categories`
--
ALTER TABLE `extra_charges_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `extra_charges_types`
--
ALTER TABLE `extra_charges_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ex_reservations`
--
ALTER TABLE `ex_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `guest_accommodation_payments`
--
ALTER TABLE `guest_accommodation_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guest_extras_payments`
--
ALTER TABLE `guest_extras_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_overnight_tax_payments`
--
ALTER TABLE `guest_overnight_tax_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_budgets`
--
ALTER TABLE `hotel_budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel_tax_categories`
--
ALTER TABLE `hotel_tax_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hotel_vats`
--
ALTER TABLE `hotel_vats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `opex_data`
--
ALTER TABLE `opex_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_modes`
--
ALTER TABLE `payment_modes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rate_types`
--
ALTER TABLE `rate_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rate_type_cancellation_policies`
--
ALTER TABLE `rate_type_cancellation_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rate_type_categories`
--
ALTER TABLE `rate_type_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservation_deposits`
--
ALTER TABLE `reservation_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservation_extra_charges`
--
ALTER TABLE `reservation_extra_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restrictions`
--
ALTER TABLE `restrictions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `room_conditions`
--
ALTER TABLE `room_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vat_options`
--
ALTER TABLE `vat_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `activities_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `availabilities_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `availabilities_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `booking_agencies`
--
ALTER TABLE `booking_agencies`
  ADD CONSTRAINT `booking_agencies_default_payment_method_id_foreign` FOREIGN KEY (`default_payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `booking_agencies_default_payment_mode_id_foreign` FOREIGN KEY (`default_payment_mode_id`) REFERENCES `payment_modes` (`id`),
  ADD CONSTRAINT `booking_agencies_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `booking_agencies_virtual_card_payment_mode_id_foreign` FOREIGN KEY (`virtual_card_payment_mode_id`) REFERENCES `payment_modes` (`id`);

--
-- Constraints for table `breakfast_percentages`
--
ALTER TABLE `breakfast_percentages`
  ADD CONSTRAINT `breakfast_percentages_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_cost_of_sale_id_foreign` FOREIGN KEY (`cost_of_sale_id`) REFERENCES `cost_of_sales` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `companies_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `daily_rates`
--
ALTER TABLE `daily_rates`
  ADD CONSTRAINT `daily_rates_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `descriptions`
--
ALTER TABLE `descriptions`
  ADD CONSTRAINT `descriptions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`),
  ADD CONSTRAINT `documents_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);

--
-- Constraints for table `document_infos`
--
ALTER TABLE `document_infos`
  ADD CONSTRAINT `document_infos_booking_agency_id_foreign` FOREIGN KEY (`booking_agency_id`) REFERENCES `booking_agencies` (`id`),
  ADD CONSTRAINT `document_infos_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `document_infos_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `document_infos_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`);

--
-- Constraints for table `document_types`
--
ALTER TABLE `document_types`
  ADD CONSTRAINT `document_types_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `extra_charges`
--
ALTER TABLE `extra_charges`
  ADD CONSTRAINT `extra_charges_extra_charge_category_id_foreign` FOREIGN KEY (`extra_charge_category_id`) REFERENCES `extra_charges_categories` (`id`),
  ADD CONSTRAINT `extra_charges_extra_charge_type_id_foreign` FOREIGN KEY (`extra_charge_type_id`) REFERENCES `extra_charges_types` (`id`),
  ADD CONSTRAINT `extra_charges_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `extra_charges_categories`
--
ALTER TABLE `extra_charges_categories`
  ADD CONSTRAINT `extra_charges_categories_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `extra_charges_types`
--
ALTER TABLE `extra_charges_types`
  ADD CONSTRAINT `extra_charges_types_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `ex_reservations`
--
ALTER TABLE `ex_reservations`
  ADD CONSTRAINT `ex_reservations_booking_agency_id_foreign` FOREIGN KEY (`booking_agency_id`) REFERENCES `booking_agencies` (`id`),
  ADD CONSTRAINT `ex_reservations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `ex_reservations_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`),
  ADD CONSTRAINT `ex_reservations_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `ex_reservations_rate_type_id_foreign` FOREIGN KEY (`rate_type_id`) REFERENCES `rate_types` (`id`),
  ADD CONSTRAINT `ex_reservations_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `guest_accommodation_payments`
--
ALTER TABLE `guest_accommodation_payments`
  ADD CONSTRAINT `guest_accommodation_payments_deposit_type_id_foreign` FOREIGN KEY (`deposit_type_id`) REFERENCES `deposit_types` (`id`),
  ADD CONSTRAINT `guest_accommodation_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `guest_accommodation_payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `guest_extras_payments`
--
ALTER TABLE `guest_extras_payments`
  ADD CONSTRAINT `guest_extras_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `guest_extras_payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `guest_overnight_tax_payments`
--
ALTER TABLE `guest_overnight_tax_payments`
  ADD CONSTRAINT `guest_overnight_tax_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `guest_overnight_tax_payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `hotel_budgets`
--
ALTER TABLE `hotel_budgets`
  ADD CONSTRAINT `hotel_budgets_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `hotel_settings`
--
ALTER TABLE `hotel_settings`
  ADD CONSTRAINT `hotel_settings_cancellation_vat_id_foreign` FOREIGN KEY (`cancellation_vat_id`) REFERENCES `hotel_vats` (`id`),
  ADD CONSTRAINT `hotel_settings_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `hotel_settings_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `hotel_settings_overnight_tax_id_foreign` FOREIGN KEY (`overnight_tax_id`) REFERENCES `hotel_tax_categories` (`id`),
  ADD CONSTRAINT `hotel_settings_vat_id_foreign` FOREIGN KEY (`vat_id`) REFERENCES `hotel_vats` (`id`);

--
-- Constraints for table `hotel_settings_users`
--
ALTER TABLE `hotel_settings_users`
  ADD CONSTRAINT `hotel_settings_users_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `hotel_settings_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hotel_vats`
--
ALTER TABLE `hotel_vats`
  ADD CONSTRAINT `hotel_vats_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `hotel_vats_vat_option_id_foreign` FOREIGN KEY (`vat_option_id`) REFERENCES `vat_options` (`id`);

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opex_data`
--
ALTER TABLE `opex_data`
  ADD CONSTRAINT `opex_data_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `opex_data_cos_id_foreign` FOREIGN KEY (`cos_id`) REFERENCES `cost_of_sales` (`id`),
  ADD CONSTRAINT `opex_data_description_id_foreign` FOREIGN KEY (`description_id`) REFERENCES `descriptions` (`id`),
  ADD CONSTRAINT `opex_data_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `opex_data_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD CONSTRAINT `payment_modes_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `rate_types`
--
ALTER TABLE `rate_types`
  ADD CONSTRAINT `rate_types_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `rate_types_rate_type_cancellation_policy_id_foreign` FOREIGN KEY (`rate_type_cancellation_policy_id`) REFERENCES `rate_type_cancellation_policies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rate_types_rate_type_category_id_foreign` FOREIGN KEY (`rate_type_category_id`) REFERENCES `rate_type_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rate_types_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rate_type_cancellation_policies`
--
ALTER TABLE `rate_type_cancellation_policies`
  ADD CONSTRAINT `rate_type_cancellation_policies_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `rate_type_categories`
--
ALTER TABLE `rate_type_categories`
  ADD CONSTRAINT `rate_type_categories_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_booking_agency_id_foreign` FOREIGN KEY (`booking_agency_id`) REFERENCES `booking_agencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_checkin_guest_id_foreign` FOREIGN KEY (`checkin_guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`),
  ADD CONSTRAINT `reservations_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_payment_mode_id_foreign` FOREIGN KEY (`payment_mode_id`) REFERENCES `payment_modes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_rate_type_id_foreign` FOREIGN KEY (`rate_type_id`) REFERENCES `rate_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation_deposits`
--
ALTER TABLE `reservation_deposits`
  ADD CONSTRAINT `reservation_deposits_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `reservation_extra_charges`
--
ALTER TABLE `reservation_extra_charges`
  ADD CONSTRAINT `reservation_extra_charges_extra_charge_id_foreign` FOREIGN KEY (`extra_charge_id`) REFERENCES `extra_charges` (`id`),
  ADD CONSTRAINT `reservation_extra_charges_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `restrictions`
--
ALTER TABLE `restrictions`
  ADD CONSTRAINT `restrictions_rate_type_id_foreign` FOREIGN KEY (`rate_type_id`) REFERENCES `rate_types` (`id`),
  ADD CONSTRAINT `restrictions_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_conditions`
--
ALTER TABLE `room_conditions`
  ADD CONSTRAINT `room_conditions_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `room_conditions_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `room_types`
--
ALTER TABLE `room_types`
  ADD CONSTRAINT `room_types_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_hotel_settings_id_foreign` FOREIGN KEY (`hotel_settings_id`) REFERENCES `hotel_settings` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
