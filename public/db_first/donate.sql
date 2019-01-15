-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2018 at 02:18 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donate`
--

-- --------------------------------------------------------

--
-- Table structure for table `brokers`
--

CREATE TABLE `brokers` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `alias_name` varchar(250) NOT NULL,
  `information` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brokers`
--

INSERT INTO `brokers` (`id`, `name`, `alias_name`, `information`, `created_at`, `updated_at`) VALUES
(25, 'نفسه', 'نفسه', '', '2018-07-26 06:47:54', '2018-07-26 06:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `broker_contacts`
--

CREATE TABLE `broker_contacts` (
  `id` int(11) NOT NULL,
  `broker_id` int(11) NOT NULL,
  `contact_type` int(11) NOT NULL,
  `contact_details` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `broker_donor`
--

CREATE TABLE `broker_donor` (
  `id` int(11) NOT NULL,
  `broker_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donation_details`
--

CREATE TABLE `donation_details` (
  `id` int(11) NOT NULL,
  `donations_id` int(11) NOT NULL,
  `broker_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `coin_type` int(11) NOT NULL,
  `sar` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `alias_name` varchar(250) NOT NULL,
  `information` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donor_contacts`
--

CREATE TABLE `donor_contacts` (
  `id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `contact_type` int(11) NOT NULL,
  `contact_details` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lookups`
--

CREATE TABLE `lookups` (
  `lookup_id` int(10) NOT NULL,
  `lookup_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lookup_slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lookup_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lookup_parent` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lookups`
--

INSERT INTO `lookups` (`lookup_id`, `lookup_title`, `lookup_slug`, `lookup_description`, `lookup_parent`, `notes`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(26, 'نوع رقم المشروع', NULL, NULL, NULL, NULL, '2017-09-23 02:32:03', 1, '2017-09-23 02:32:03', NULL, NULL, NULL),
(27, 'رقم التصميم', NULL, NULL, 26, NULL, '2017-09-23 02:32:50', 1, '2017-09-23 02:32:50', NULL, NULL, NULL),
(28, 'رقم تسلسلي جديد', NULL, NULL, 26, NULL, '2017-09-23 02:33:00', 1, '2017-09-23 02:33:00', NULL, NULL, NULL),
(29, 'نوع الطلبية', NULL, NULL, NULL, NULL, '2017-09-23 11:06:29', 1, '2017-09-23 11:06:29', NULL, NULL, NULL),
(30, 'نقدي', NULL, NULL, 29, NULL, '2017-09-23 11:06:51', 1, '2017-09-23 11:06:51', NULL, NULL, NULL),
(31, 'آجل', NULL, NULL, 29, NULL, '2017-09-23 11:07:19', 1, '2017-09-23 11:07:19', NULL, NULL, NULL),
(32, 'لون المادة', NULL, NULL, NULL, NULL, '2017-09-23 11:07:41', 1, '2017-09-23 11:07:41', NULL, NULL, NULL),
(33, 'بيج 1', NULL, NULL, 32, NULL, '2017-09-23 11:07:50', 1, '2017-09-29 11:05:31', 1, NULL, NULL),
(34, 'بيج نص', NULL, NULL, 32, NULL, '2017-09-23 11:07:56', 1, '2017-09-29 11:06:30', 1, NULL, NULL),
(35, 'بيج ربع', NULL, NULL, 32, NULL, '2017-09-23 11:08:01', 1, '2017-09-29 11:06:47', 1, NULL, NULL),
(36, 'نوع المادة', NULL, NULL, NULL, NULL, '2017-09-23 11:08:13', 1, '2017-09-23 11:08:13', NULL, NULL, NULL),
(37, 'G.R.C', NULL, NULL, 36, NULL, '2017-09-23 11:08:32', 1, '2017-09-29 11:09:58', 1, NULL, NULL),
(38, 'حجر', NULL, NULL, 36, NULL, '2017-09-23 11:08:40', 1, '2017-09-29 11:09:46', 1, NULL, NULL),
(39, 'الوحدات', NULL, NULL, NULL, NULL, '2017-09-23 11:08:57', 1, '2017-09-29 11:03:03', 1, NULL, NULL),
(40, 'متر مربع', NULL, NULL, 39, NULL, '2017-09-23 11:09:10', 1, '2017-09-29 11:07:28', 1, NULL, NULL),
(41, 'متر طولي', NULL, NULL, 39, NULL, '2017-09-23 11:09:18', 1, '2017-09-29 11:07:15', 1, NULL, NULL),
(42, 'مكان التصنيع', NULL, NULL, NULL, NULL, '2017-09-23 11:09:27', 1, '2017-09-29 11:43:20', 1, NULL, NULL),
(43, 'مصنع العين', NULL, NULL, 42, NULL, '2017-09-23 11:09:36', 1, '2017-09-29 11:03:21', 1, NULL, NULL),
(44, 'مصنع دبي', NULL, NULL, 42, NULL, '2017-09-23 11:09:43', 1, '2017-09-29 11:04:35', 1, NULL, NULL),
(45, 'حالة الطلبية', NULL, NULL, NULL, NULL, '2017-09-24 13:13:01', 1, '2017-09-24 13:13:01', NULL, NULL, NULL),
(46, 'قيد التصنيع', NULL, NULL, 45, NULL, '2017-09-24 13:13:15', 1, '2017-09-29 11:10:30', 1, NULL, NULL),
(47, 'تم التصنيع', NULL, NULL, 45, NULL, '2017-09-24 13:13:27', 1, '2017-09-29 11:10:17', 1, NULL, NULL),
(48, 'مرتجع', NULL, NULL, 45, NULL, '2017-09-24 13:14:11', 1, '2017-09-29 11:07:02', 1, NULL, NULL),
(49, 'مصنع البريمي', NULL, NULL, 42, NULL, '2017-09-29 11:04:55', 1, '2017-09-29 11:04:55', NULL, NULL, NULL),
(50, 'حبة', NULL, NULL, 39, NULL, '2017-09-29 11:07:39', 1, '2017-09-29 11:07:39', NULL, NULL, NULL),
(51, 'التخصيم', NULL, NULL, NULL, NULL, '2017-09-29 16:52:19', 1, '2017-09-29 16:52:19', NULL, NULL, NULL),
(52, 'المورد', NULL, NULL, 51, NULL, '2017-09-29 16:52:51', 1, '2017-09-29 16:52:51', NULL, NULL, NULL),
(53, 'بيج ثمن', NULL, NULL, 32, NULL, '2017-09-30 03:21:23', 1, '2017-09-30 03:21:23', NULL, NULL, NULL),
(54, 'بيج 3', NULL, NULL, 32, NULL, '2017-09-30 03:21:37', 1, '2017-09-30 03:21:37', NULL, NULL, NULL),
(55, 'بيج 5', NULL, NULL, 32, NULL, '2017-09-30 03:21:50', 1, '2017-09-30 03:21:50', NULL, NULL, NULL),
(56, 'بيج 7 قديم', NULL, NULL, 32, NULL, '2017-09-30 03:22:03', 1, '2017-09-30 03:22:03', NULL, NULL, NULL),
(57, 'بيج 7', NULL, NULL, 32, NULL, '2017-09-30 03:22:16', 1, '2017-09-30 03:22:16', NULL, NULL, NULL),
(58, 'رملي 1', NULL, NULL, 32, NULL, '2017-09-30 03:22:26', 1, '2017-09-30 03:22:26', NULL, NULL, NULL),
(59, 'رملي 2', NULL, NULL, 32, NULL, '2017-09-30 03:22:35', 1, '2017-09-30 03:22:35', NULL, NULL, NULL),
(60, 'رملي 3', NULL, NULL, 32, NULL, '2017-09-30 03:22:54', 1, '2017-09-30 03:22:54', NULL, NULL, NULL),
(61, 'أصفر 1', NULL, NULL, 32, NULL, '2017-09-30 03:28:57', 1, '2017-09-30 03:28:57', NULL, NULL, NULL),
(62, 'أصفر 3', NULL, NULL, 32, NULL, '2017-09-30 03:29:46', 1, '2017-09-30 03:29:46', NULL, NULL, NULL),
(63, 'أصفر نص', NULL, NULL, 32, NULL, '2017-09-30 03:30:01', 1, '2017-09-30 03:30:01', NULL, NULL, NULL),
(64, 'أصفر ربع', NULL, NULL, 32, NULL, '2017-09-30 03:30:09', 1, '2017-09-30 03:30:09', NULL, NULL, NULL),
(65, 'أبيض', NULL, NULL, 32, NULL, '2017-09-30 03:30:36', 1, '2017-09-30 03:30:36', NULL, NULL, NULL),
(66, 'رمادي فاتح', NULL, NULL, 32, NULL, '2017-09-30 03:30:53', 1, '2017-09-30 03:30:53', NULL, NULL, NULL),
(67, 'رمادي غامق', NULL, NULL, 32, NULL, '2017-09-30 03:31:04', 1, '2017-09-30 03:31:04', NULL, NULL, NULL),
(68, 'اسم المادة', NULL, NULL, NULL, NULL, '2017-10-07 16:40:22', 1, '2017-10-07 16:40:22', NULL, NULL, NULL),
(69, 'حجر تدمري 1', NULL, NULL, 68, NULL, '2017-10-07 16:41:04', 1, '2017-10-07 16:41:04', NULL, NULL, NULL),
(70, 'بيانات التواصل', NULL, NULL, NULL, NULL, '2018-06-25 07:36:01', 0, NULL, NULL, NULL, NULL),
(81, 'رقم الجوال', 'number', NULL, 70, NULL, '2018-06-25 08:36:47', 0, '2018-06-26 11:17:23', NULL, NULL, NULL),
(82, 'الايميل', 'email', NULL, 70, NULL, '2018-06-25 08:36:47', 0, '2018-06-25 08:39:53', NULL, NULL, NULL),
(83, 'الفيس بوك', NULL, NULL, 70, NULL, '2018-06-25 08:37:50', 0, NULL, NULL, NULL, NULL),
(84, 'العنوان', NULL, NULL, 70, NULL, '2018-06-25 08:37:50', 0, NULL, NULL, NULL, NULL),
(85, 'العملات', NULL, NULL, NULL, NULL, '2018-06-25 08:38:07', 0, NULL, NULL, NULL, NULL),
(86, 'الدينار', NULL, NULL, 85, NULL, '2018-06-25 08:38:37', 0, NULL, NULL, NULL, NULL),
(87, 'الدولار', NULL, NULL, 85, NULL, '2018-06-25 08:38:37', 0, NULL, NULL, NULL, NULL),
(88, 'الريال', NULL, NULL, 85, NULL, '2018-06-25 08:39:00', 0, NULL, NULL, NULL, NULL),
(89, 'الشيكل', NULL, NULL, 85, NULL, '2018-06-25 08:39:00', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_06_10_092904_create_audits_table', 1),
(2, '2018_06_10_125503_create_winners_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(132, 'user_display', 'عرض المستخدمين', 'عرض المستخدمين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(133, 'user_create', 'اضافة مستخدمين', 'اضافة مستخدمين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(134, 'user_update', 'تعديل المستخدمين', 'تعديل المستخدمين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(135, 'user_delete', 'حذف مستخدمين', 'حذف مستخدمين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(136, 'donor_display', 'عرض متبرعين', 'عرض متبرعين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(137, 'donor_create', 'اضافة متبرعين', 'اضافة متبرعين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(138, 'donor_update', 'تعديل متبرعين', 'تعديل متبرعين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(139, 'donor_delete', 'حذف متبرعين', 'حذف متبرعين', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(140, 'broker_display', 'عرض الوسطاء', 'عرض الوسطاء', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(141, 'broker_create', 'اضافة وسطاء', 'اضافة وسطاء', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(142, 'broker_update', 'تعديل وسطاء', 'تعديل وسطاء', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(143, 'broker_delete', 'حذف وسطاء', 'حذف وسطاء', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(144, 'project_display', 'عرض المشاريع', 'عرض المشاريع', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(145, 'project_create', 'اضافة مشاريع', 'اضافة مشاريع', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(146, 'project_update', 'تعديل مشاريع', 'تعديل مشاريع', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(147, 'project_delete', 'حذف مشاريع', 'حذف مشاريع', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(148, 'donation_display', 'عرض التبرعات', 'عرض التبرعات', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(149, 'donation_create', 'اضافة تبرعات', 'اضافة تبرعات', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(150, 'donation_update', 'تعديل تبرعات', 'تعديل تبرعات', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(151, 'donation_delete', 'حذف تبرعات', 'حذف تبرعات', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(152, 'import', 'استيراد', 'استيراد', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(153, 'export', 'تصدير', 'تصدير', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(154, 'search', 'صفحة البحث', 'صفحة البحث', '2018-07-04 10:13:33', '2018-07-04 10:13:33'),
(155, 'home_page', 'عرض الصفحة الرئيسية', 'عرض الصفحة الرئيسية', '2018-07-14 07:39:08', '2018-07-14 07:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_user`
--

INSERT INTO `permission_user` (`user_id`, `permission_id`) VALUES
(30, 136),
(30, 137),
(30, 150),
(30, 152),
(25, 138),
(25, 141),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(1, 140),
(1, 141),
(1, 142),
(1, 143),
(1, 144),
(1, 145),
(1, 146),
(1, 147),
(1, 148),
(1, 149),
(1, 150),
(1, 151),
(1, 152),
(1, 153),
(1, 154),
(1, 155),
(31, 135),
(31, 137),
(31, 141),
(31, 142),
(31, 146),
(31, 150);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `information` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(8, 'user', 'user', 'user', '2017-09-19 14:03:33', '2017-09-19 14:03:33'),
(9, 'admin', 'admin', 'admin', '2017-09-20 05:46:32', '2017-09-20 06:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 8),
(1, 9),
(30, 8),
(31, 8),
(32, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(10) DEFAULT NULL,
  `section_id` int(3) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1',
  `api_token` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `user_pass`, `unit_id`, `section_id`, `isActive`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System administrator', 'admin', 'admin@admin.com', '$2y$10$yjvesdbXfgWJqWHS5LHh3uYZa2GlSVC05h2duUfOXPm5VplNqyely', NULL, NULL, 1, 'sMwVgHtBGZLx1e06tV6wgoE7UxGIwQlmYZRs9uhJh0SXDd3F5dSYgwoG1ggogtHmGeLHXtZOdGWDymt90ffOam6y598wvzzuAnDGTz8ubE24PIHh9HOGgvuI7hApWiIuCS0wemXbYCve93VRibmtNn', 'UgEAWJQCap8rfis50XOALpBls7PdxAQb2NzpmGLJxCRl6THPwhVcHJNsohin', '2017-03-24 03:10:58', '2018-06-25 07:38:52'),
(25, 'Ahmed', 'mohAdmin123', 'mod7s@gmail.com', '$2y$10$.c0QBhpai4xlUsPwncOihemNqIvx7lY6FysYHg9Zt2mQchZuhFK6C', NULL, NULL, 1, NULL, 'I55PIvYKLHLHUTeaIr8N6ocx9tQ4vwXNXyuaU6JnwxMyLabr05TCuHQLZRSU', '2018-06-05 06:10:17', '2018-07-04 09:51:29'),
(30, 'Ali', 'rrrrrr', 'morham1995@hotmail.com', '$2y$10$ZGzqI1R9pgZBz6I.sOoAIulmpoJgjdHzov3UOuVH/CyzAS0X.ow4S', NULL, NULL, 1, NULL, 'muVRyhdNslPk9m59jhVMHm7eTbOxfRE2wKkfaBeNFBd16swfAcCpScXvQ1Zv', '2018-07-05 04:14:16', '2018-07-05 04:14:16'),
(31, 'Khalid', 'gggrrrr', 'moggreeds@gmail.com', '$2y$10$OwVFZ9KG0xuRU/PKItxwj.2kv1njBAYRuSFuI8SzK.L8JnmWPPcRG', NULL, NULL, 1, NULL, NULL, '2018-07-15 03:12:35', '2018-07-15 03:12:35'),
(32, 'ddddd', 'dddddd', 'ddd@gmail.com', '$2y$10$UrB.O5ZFxgzjlwxva/1nOOQz9g6CNlXyW1TAmMn94/QPs3.eT1PCK', NULL, NULL, 1, NULL, NULL, '2018-08-02 09:17:51', '2018-08-02 09:17:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brokers`
--
ALTER TABLE `brokers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `broker_contacts`
--
ALTER TABLE `broker_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `broker_contacts_ibfk_1` (`broker_id`),
  ADD KEY `broker_contacts_ibfk_2` (`contact_type`);

--
-- Indexes for table `broker_donor`
--
ALTER TABLE `broker_donor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_brokers_ibfk_1` (`broker_id`),
  ADD KEY `donor_brokers_ibfk_2` (`donor_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_details`
--
ALTER TABLE `donation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_details_ibfk_1` (`broker_id`),
  ADD KEY `donations_details_ibfk_2` (`donor_id`),
  ADD KEY `donations_details_ibfk_3` (`project_id`),
  ADD KEY `donations_details_ibfk_4` (`coin_type`),
  ADD KEY `donations_details_ibfk_5` (`donations_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donor_contacts`
--
ALTER TABLE `donor_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_contacts_ibfk_1` (`donor_id`),
  ADD KEY `donor_contacts_ibfk_2` (`contact_type`);

--
-- Indexes for table `lookups`
--
ALTER TABLE `lookups`
  ADD PRIMARY KEY (`lookup_id`),
  ADD KEY `lookup_parent` (`lookup_parent`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD KEY `permission_user_ibfk_2` (`permission_id`),
  ADD KEY `permission_user_ibfk_1` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_token` (`api_token`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `broker_contacts`
--
ALTER TABLE `broker_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `broker_donor`
--
ALTER TABLE `broker_donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `donation_details`
--
ALTER TABLE `donation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `donor_contacts`
--
ALTER TABLE `donor_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `lookups`
--
ALTER TABLE `lookups`
  MODIFY `lookup_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `broker_contacts`
--
ALTER TABLE `broker_contacts`
  ADD CONSTRAINT `broker_contacts_ibfk_1` FOREIGN KEY (`broker_id`) REFERENCES `brokers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `broker_contacts_ibfk_2` FOREIGN KEY (`contact_type`) REFERENCES `lookups` (`lookup_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donation_details`
--
ALTER TABLE `donation_details`
  ADD CONSTRAINT `donations_details_ibfk_1` FOREIGN KEY (`broker_id`) REFERENCES `brokers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_details_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_details_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_details_ibfk_4` FOREIGN KEY (`coin_type`) REFERENCES `lookups` (`lookup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donations_details_ibfk_5` FOREIGN KEY (`donations_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donor_contacts`
--
ALTER TABLE `donor_contacts`
  ADD CONSTRAINT `donor_contacts_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donor_contacts_ibfk_2` FOREIGN KEY (`contact_type`) REFERENCES `lookups` (`lookup_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
