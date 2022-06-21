-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 23, 2022 at 09:57 AM
-- Server version: 5.7.31
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(500) DEFAULT NULL,
  `name_ar` varchar(500) DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `major_classification` tinyint(4) DEFAULT '1',
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `base` tinyint(4) DEFAULT '0',
  `currency_id` int(11) DEFAULT NULL,
  `closing_account_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `person_id`, `base`, `currency_id`, `closing_account_type`) VALUES
(1, NULL, 'الأصول', 1, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(2, NULL, 'الزبائن', 101, 1, 1, 1, NULL, NULL, 0, NULL, 3),
(3, NULL, 'حسابات النقدية', 102, 1, 1, 1, NULL, NULL, 0, NULL, 1),
(4, NULL, 'صندوق ل.س', 1301, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(5, NULL, 'حسابات نقدية المندوبين', 103, 1, 1, 1, NULL, NULL, 0, NULL, NULL),
(6, NULL, 'المصروفات', 3, NULL, 1, 1, NULL, NULL, 0, NULL, 3),
(7, NULL, 'مصروف سيارة المندوب', 301, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(8, NULL, 'اجور شحن ومصروف مبيعات', 302, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(9, NULL, 'مصاريف مختلفة ', 303, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(10, NULL, 'حسابات المواد', 4, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(11, NULL, 'مشتريات', 401, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(12, NULL, 'مردود مشتريات', 402, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(13, NULL, 'مبيعات', 403, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(14, NULL, 'مردود مبيعات', 404, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(15, NULL, 'الحسم الممنوح', 405, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(16, NULL, 'الحسم المكتسب', 406, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(17, NULL, 'الإيرادات', 5, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(18, 'Supplers', 'الموردون', 104, 1, 1, 1, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `response` longtext,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` bigint(20) DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bill_type_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `note` longtext,
  `is_cash` tinyint(4) DEFAULT '1',
  `bill_number` varchar(200) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `ex_rate` decimal(10,2) NOT NULL,
  `equalizer` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `after_discount` decimal(10,2) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `p_code` varchar(50) NOT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  `checked_for_update` tinyint(4) NOT NULL DEFAULT '0',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `delete_action` varchar(10) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bills_files`
--

DROP TABLE IF EXISTS `bills_files`;
CREATE TABLE IF NOT EXISTS `bills_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` varchar(200) DEFAULT NULL,
  `bill_id` int(11) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_item`
--

DROP TABLE IF EXISTS `bill_item`;
CREATE TABLE IF NOT EXISTS `bill_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_type`
--

DROP TABLE IF EXISTS `bill_type`;
CREATE TABLE IF NOT EXISTS `bill_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `prefix` varchar(500) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bill_type`
--

INSERT INTO `bill_type` (`id`, `name_en`, `name_ar`, `code`, `prefix`, `active`, `sorting`) VALUES
(1, 'فاتورة شراء', 'فاتورة شراء', 1, 'Bill-', 1, NULL),
(2, 'فاتورة مبيع', 'فاتورة مبيع', 2, 'INV-', 1, NULL),
(3, 'فاتورة مردود شراء', 'فاتورة مردود شراء', 3, 'PR-', 1, NULL),
(4, 'فاتورة مردود مبيع', 'فاتورة مردود مبيع', 4, 'SR-', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `closing_accounts_types`
--

DROP TABLE IF EXISTS `closing_accounts_types`;
CREATE TABLE IF NOT EXISTS `closing_accounts_types` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorting` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closing_accounts_types`
--

INSERT INTO `closing_accounts_types` (`id`, `name_ar`, `sorting`, `active`) VALUES
(1, 'الميزانية', 1, 1),
(2, 'المتاجرة', 2, 1),
(3, 'الأرباح والخسائر', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_apicustom`
--

DROP TABLE IF EXISTS `cms_apicustom`;
CREATE TABLE IF NOT EXISTS `cms_apicustom` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `permalink` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aksi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kolom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_query_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sql_where` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `method_type` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` longtext COLLATE utf8mb4_unicode_ci,
  `responses` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_apikey`
--

DROP TABLE IF EXISTS `cms_apikey`;
CREATE TABLE IF NOT EXISTS `cms_apikey` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `screetkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_dashboard`
--

DROP TABLE IF EXISTS `cms_dashboard`;
CREATE TABLE IF NOT EXISTS `cms_dashboard` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_queues`
--

DROP TABLE IF EXISTS `cms_email_queues`;
CREATE TABLE IF NOT EXISTS `cms_email_queues` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `send_at` datetime DEFAULT NULL,
  `email_recipient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_cc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_content` text COLLATE utf8mb4_unicode_ci,
  `email_attachments` text COLLATE utf8mb4_unicode_ci,
  `is_sent` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_templates`
--

DROP TABLE IF EXISTS `cms_email_templates`;
CREATE TABLE IF NOT EXISTS `cms_email_templates` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_email_templates`
--

INSERT INTO `cms_email_templates` (`id`, `name`, `slug`, `subject`, `content`, `description`, `from_name`, `from_email`, `cc_email`, `created_at`, `updated_at`) VALUES
(1, 'Email Template Forgot Password Backend', 'forgot_password_backend', NULL, '<p>Hi,</p><p>Someone requested forgot password, here is your new password : </p><p>[password]</p><p><br></p><p>--</p><p>Regards,</p><p>Admin</p>', '[password]', 'System', 'system@crudbooster.com', NULL, '2019-05-30 03:06:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_logs`
--

DROP TABLE IF EXISTS `cms_logs`;
CREATE TABLE IF NOT EXISTS `cms_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `id_cms_users` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3584 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus`
--

DROP TABLE IF EXISTS `cms_menus`;
CREATE TABLE IF NOT EXISTS `cms_menus` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'url',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `is_front` tinyint(4) DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_menus`
--

INSERT INTO `cms_menus` (`id`, `name`, `type`, `path`, `color`, `icon`, `parent_id`, `is_active`, `is_dashboard`, `is_front`, `id_cms_privileges`, `sorting`, `lang_id`, `created_at`, `updated_at`) VALUES
(156, 'تصنيفات المواد', 'Route', 'AdminItemCategoriesControllerGetIndex', 'normal', 'fa fa-tags', 161, 1, 0, NULL, 1, 2, NULL, '2020-03-10 18:13:59', '2020-04-05 14:06:04'),
(158, 'الزبائن', 'Route', 'AdminPersonsControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 4, NULL, '2020-03-10 18:30:11', '2021-12-18 15:52:11'),
(157, 'الحسابات', 'Route', 'AdminAccountsControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 2, NULL, '2020-03-10 18:24:42', '2020-04-05 14:03:23'),
(155, 'المواد', 'Route', 'AdminItemsControllerGetIndex', 'normal', 'fa fa-glass', 161, 1, 0, NULL, 1, 1, NULL, '2020-03-10 18:09:47', '2020-04-05 14:05:46'),
(154, 'الوحدات', 'Route', 'AdminItemUnitsControllerGetIndex', 'normal', 'fa fa-gear', 161, 1, 0, NULL, 1, 3, NULL, '2020-03-10 18:04:48', '2020-04-05 14:06:18'),
(159, 'المستودعات', 'Route', 'AdminInventoriesControllerGetIndex', 'normal', 'fa fa-th-large', 181, 1, 0, NULL, 1, 2, NULL, '2020-03-11 08:25:53', '2021-12-18 16:05:40'),
(160, 'العملات', 'Route', 'AdminCurrenciesControllerGetIndex', 'normal', 'fa fa-money', 176, 1, 0, NULL, 1, 1, NULL, '2020-03-11 08:43:55', '2020-04-05 14:11:31'),
(161, 'إدارة المواد', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 5, NULL, '2020-03-11 08:50:37', '2020-04-05 14:05:30'),
(162, 'الفواتير', 'URL', '#', 'normal', 'fa fa-money', 0, 1, 0, NULL, 1, 3, NULL, '2020-03-12 08:08:41', '2020-04-05 14:04:02'),
(165, 'Entries Details', 'Route', 'AdminEntries89ControllerGetIndex', 'normal', 'fa fa-glass', 167, 1, 0, NULL, 1, 2, NULL, '2020-03-12 11:34:08', '2020-03-12 12:00:36'),
(166, 'All Entries', 'Route', 'AdminEntryBaseControllerGetIndex', 'normal', 'fa fa-glass', 167, 1, 0, NULL, 1, 1, NULL, '2020-03-12 11:43:57', '2020-03-12 12:00:44'),
(167, 'Entry Management', 'URL', '#', 'normal', 'fa fa-th-list', 0, 0, 0, NULL, 1, 4, NULL, '2020-03-12 11:59:55', '2020-06-08 07:12:26'),
(168, 'Item Tracking', 'Route', 'AdminItemTrackingControllerGetIndex', NULL, 'fa fa-glass', 170, 0, 0, NULL, 1, 2, NULL, '2020-03-14 12:25:27', NULL),
(169, 'Items Inventory', 'Route', 'AdminItemTracking92ControllerGetIndex', NULL, 'fa fa-search', 170, 0, 0, NULL, 1, 1, NULL, '2020-03-14 12:46:35', NULL),
(170, 'Tracking', 'URL', '/modules/item_tracking', 'normal', 'fa fa-th-list', 181, 0, 0, NULL, 1, 4, NULL, '2020-03-14 13:52:53', '2020-03-31 11:56:51'),
(171, 'فواتير المبيعات', 'Route', 'AdminBillsSalesInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 2, NULL, '2020-03-16 08:04:56', '2020-04-05 14:04:38'),
(172, 'فواتير المشتريات', 'Route', 'AdminBillsPurchaseInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 1, NULL, '2020-03-16 08:08:12', '2020-04-05 14:04:17'),
(173, 'فواتير مردودات المشتريات', 'Route', 'AdminBillsPurchaseReturnInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 3, NULL, '2020-03-16 08:37:32', '2020-04-05 14:04:57'),
(174, 'فواتير مردودات المبيعات', 'Route', 'AdminBillsSalesReturnInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 4, NULL, '2020-03-16 08:38:49', '2020-04-09 07:36:12'),
(176, 'إدارة العملات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 7, NULL, '2020-03-16 14:02:38', '2020-04-05 14:10:37'),
(177, 'Reports budgets', 'Route', 'AdminReportsControllerGetIndex', 'normal', 'fa fa-file-o', 179, 0, 0, NULL, 1, 6, NULL, '2020-03-17 14:33:29', '2020-04-05 14:14:28'),
(178, 'Currencies', 'Statistic', 'statistic_builder/show/statistic', 'normal', 'fa fa-glass', 0, 1, 1, NULL, 1, 1, NULL, '2020-03-18 07:00:09', '2020-05-06 05:29:49'),
(179, 'التقارير', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 8, NULL, '2020-03-20 11:09:58', '2020-04-09 07:47:15'),
(180, 'الحسابات', 'Route', 'AdminReports99ControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 2, NULL, '2020-03-20 11:30:37', '2020-04-09 07:36:22'),
(181, 'إدارة المستودعات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 6, NULL, '2020-03-20 14:55:48', '2021-12-18 16:08:07'),
(182, 'إدارة الحسابات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 2, NULL, '2020-03-20 14:57:41', '2021-12-26 11:26:07'),
(183, 'بضاعة اول المدة', 'Route', 'AdminItemTracking100ControllerGetIndex', 'normal', 'fa fa-glass', 181, 1, 0, NULL, 1, 1, NULL, '2020-03-25 11:49:34', '2020-04-05 14:06:51'),
(184, 'نقل مواد', 'Route', 'AdminItemTracking101ControllerGetIndex', 'normal', 'fa fa-glass', 181, 1, 0, NULL, 1, 3, NULL, '2020-03-25 20:08:05', '2021-12-18 16:05:59'),
(185, 'حركة المواد', 'Route', 'AdminItemTracking102ControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 1, NULL, '2020-03-26 06:35:24', '2020-06-01 11:01:41'),
(186, 'أرصدة المواد (جرد)', 'Route', 'AdminInventoryAccountingControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 3, NULL, '2020-03-28 17:55:05', '2020-06-01 11:01:51'),
(188, 'Delegates', 'Route', 'AdminDelegatesControllerGetIndex', 'normal', 'fa fa-glass', 0, 0, 0, NULL, 1, 8, NULL, '2020-03-29 23:36:02', '2020-04-05 14:14:04'),
(189, 'كشف حساب (زبون - مورد)', 'Route', 'AdminAccountstatementControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 4, NULL, '2020-04-02 03:59:52', '2020-04-05 14:13:26'),
(190, 'تقرير المندوبين', 'Route', 'AdminSalesmenReportControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 5, NULL, '2020-04-02 13:46:57', '2020-04-05 14:13:53'),
(191, 'السندات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 4, NULL, '2020-04-12 04:14:40', '2020-06-01 05:36:20'),
(192, 'سندات القبض', 'Route', 'AdminReceiptVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 1, NULL, '2020-04-12 04:16:07', '2020-06-01 05:36:27'),
(193, 'سندات الدفع', 'Route', 'AdminPaymentVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 2, NULL, '2020-04-12 05:20:36', '2020-06-01 05:36:35'),
(196, 'Bill Files', 'Route', 'AdminBillsFilesControllerGetIndex', 'normal', 'fa fa-glass', 0, 0, 0, NULL, 1, 11, NULL, '2020-05-26 15:01:31', '2020-06-01 11:57:51'),
(195, 'File Voucher', 'Route', 'AdminFilesVouchers111ControllerGetIndex', 'normal', 'fa fa-glass', 0, 0, 0, NULL, 1, 10, NULL, '2020-05-26 11:25:57', '2020-05-26 12:55:12'),
(197, 'توثيق عقد الرهن', 'Route', 'AdminBillItem113ControllerGetIndex', 'normal', 'fa fa-glass', 0, 0, 0, NULL, 1, 12, NULL, '2020-06-04 03:53:31', '2020-06-08 07:11:15'),
(198, 'سندات التحويل', 'Route', 'AdminTransferVouchersControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 3, NULL, '2020-06-08 08:42:29', '2020-06-09 04:38:09'),
(200, 'سندات الأرصدة الافتتاحية', 'Route', 'AdminInitialVoucherControllerGetIndex', NULL, 'fa fa-glass', 191, 1, 0, NULL, 1, 4, NULL, '2021-11-16 06:38:11', NULL),
(201, 'أنواع حسابات الإقفال', 'Route', 'AdminClosingAccountsTypesControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 1, NULL, '2021-12-04 11:29:04', NULL),
(202, 'حسابات الإقفال', 'Route', 'AdminReports117ControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 6, NULL, '2021-12-04 11:29:33', NULL),
(204, 'سند قيد عام', 'Route', 'AdminReports118ControllerGetIndex', NULL, 'fa fa-glass', 179, 1, 0, NULL, 1, 7, NULL, '2021-12-06 12:15:51', NULL),
(205, 'تدوير الحسابات', 'Route', 'AdminReportsRotateDataControllerGetIndex', NULL, 'fa fa-glass', 182, 1, 0, NULL, 1, 3, NULL, '2021-12-06 16:05:39', NULL),
(206, 'الموردون', 'Route', 'AdminSuppliersControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 5, NULL, '2021-12-18 06:22:57', '2021-12-18 16:05:05'),
(207, 'سجل سعر صرف العملات', 'Route', 'AdminCurrencyHistoryControllerGetIndex', NULL, 'fa fa-glass', 176, 1, 0, NULL, 1, 2, NULL, '2022-01-04 05:18:50', NULL),
(208, 'أرشيف القيود المعدلة', 'Route', 'AdminReportsEntriesHistoryControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 8, NULL, '2022-01-18 14:18:11', '2022-01-18 14:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus_privileges`
--

DROP TABLE IF EXISTS `cms_menus_privileges`;
CREATE TABLE IF NOT EXISTS `cms_menus_privileges` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cms_menus` int(11) DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=551 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_menus_privileges`
--

INSERT INTO `cms_menus_privileges` (`id`, `id_cms_menus`, `id_cms_privileges`) VALUES
(259, 125, 1),
(258, 124, 1),
(257, 123, 1),
(256, 122, 1),
(255, 121, 1),
(254, 121, 2),
(250, 117, 1),
(249, 117, 2),
(248, 116, 1),
(247, 116, 2),
(246, 115, 1),
(245, 115, 2),
(251, 114, 2),
(252, 114, 1),
(242, 61, 1),
(240, 112, 1),
(238, 105, 1),
(236, 104, 1),
(234, 68, 1),
(232, 67, 1),
(230, 59, 1),
(228, 57, 1),
(226, 64, 1),
(224, 65, 1),
(220, 55, 1),
(218, 56, 1),
(216, 54, 1),
(214, 66, 1),
(212, 63, 1),
(210, 58, 1),
(208, 60, 1),
(206, 113, 1),
(239, 112, 2),
(237, 105, 2),
(235, 104, 2),
(202, 62, 1),
(200, 102, 1),
(199, 102, 2),
(198, 100, 1),
(197, 100, 2),
(196, 74, 1),
(195, 73, 1),
(194, 73, 2),
(193, 72, 1),
(192, 71, 1),
(221, 70, 2),
(222, 70, 1),
(189, 69, 1),
(188, 69, 2),
(187, 37, 1),
(186, 37, 2),
(233, 68, 2),
(231, 67, 2),
(213, 66, 2),
(223, 65, 2),
(225, 64, 2),
(211, 63, 2),
(201, 62, 2),
(241, 61, 2),
(207, 60, 2),
(229, 59, 2),
(209, 58, 2),
(227, 57, 2),
(217, 56, 2),
(219, 55, 2),
(215, 54, 2),
(260, 126, 1),
(261, 127, 1),
(262, 128, 1),
(263, 129, 1),
(264, 130, 1),
(265, 131, 1),
(266, 132, 1),
(267, 133, 1),
(268, 134, 1),
(269, 135, 1),
(270, 136, 2),
(271, 136, 1),
(277, 137, 1),
(276, 137, 2),
(274, 138, 2),
(275, 138, 1),
(278, 139, 1),
(279, 140, 1),
(280, 141, 1),
(281, 142, 1),
(282, 143, 1),
(283, 151, 1),
(296, 153, 2),
(441, 154, 1),
(440, 154, 2),
(437, 155, 1),
(439, 156, 1),
(422, 157, 1),
(533, 158, 1),
(532, 158, 4),
(297, 153, 1),
(436, 155, 2),
(438, 156, 2),
(421, 157, 2),
(540, 159, 1),
(539, 159, 4),
(455, 160, 1),
(454, 160, 2),
(435, 161, 1),
(434, 161, 2),
(428, 162, 1),
(313, 163, 1),
(427, 162, 2),
(426, 162, 4),
(453, 160, 3),
(320, 164, 1),
(326, 165, 3),
(329, 166, 3),
(507, 167, 1),
(506, 167, 2),
(505, 167, 3),
(327, 165, 2),
(328, 165, 1),
(330, 166, 2),
(331, 166, 1),
(332, 168, 1),
(333, 169, 1),
(391, 170, 1),
(390, 170, 2),
(389, 170, 3),
(431, 171, 1),
(470, 174, 1),
(476, 179, 1),
(472, 180, 1),
(486, 175, 1),
(451, 176, 1),
(450, 176, 2),
(449, 176, 3),
(467, 177, 1),
(490, 195, 1),
(488, 194, 1),
(530, 178, 1),
(475, 179, 2),
(474, 179, 4),
(473, 179, 3),
(466, 177, 2),
(465, 177, 3),
(471, 180, 4),
(549, 207, 1),
(544, 181, 1),
(543, 181, 4),
(548, 182, 1),
(547, 182, 4),
(546, 182, 2),
(445, 183, 1),
(541, 184, 4),
(498, 185, 4),
(500, 186, 4),
(375, 187, 1),
(464, 188, 1),
(462, 189, 1),
(463, 190, 1),
(425, 162, 3),
(429, 172, 1),
(430, 171, 4),
(432, 173, 1),
(469, 174, 4),
(492, 191, 4),
(494, 192, 4),
(496, 193, 4),
(502, 196, 1),
(493, 191, 1),
(495, 192, 1),
(497, 193, 1),
(499, 185, 1),
(501, 186, 1),
(504, 197, 1),
(509, 198, 4),
(510, 198, 1),
(520, 199, 1),
(519, 199, 4),
(521, 200, 1),
(523, 201, 1),
(524, 189, 4),
(525, 202, 1),
(526, 203, 1),
(527, 204, 1),
(528, 205, 1),
(542, 184, 1),
(538, 206, 1),
(545, 182, 3),
(550, 208, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_moduls`
--

DROP TABLE IF EXISTS `cms_moduls`;
CREATE TABLE IF NOT EXISTS `cms_moduls` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `hasImage` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `has_page_client` tinyint(4) DEFAULT '0',
  `main_field` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_effected` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_moduls`
--

INSERT INTO `cms_moduls` (`id`, `name`, `icon`, `path`, `table_name`, `controller`, `is_protected`, `is_active`, `hasImage`, `created_at`, `updated_at`, `deleted_at`, `has_page_client`, `main_field`, `lang_effected`) VALUES
(55, 'Email Receivers', 'fa fa-glass', 'email_receiver', 'email_receiver', 'AdminEmailReceiverController', 5, 0, 0, '2019-10-13 11:15:12', NULL, NULL, 0, NULL, NULL),
(52, 'Menu Management Client', 'fa fa-bars', 'menu_management_client', 'cms_menus', 'MenusClientController', 5, 1, 0, '2019-05-29 22:06:58', NULL, NULL, 0, NULL, NULL),
(29, 'FormFields', 'fa fa-glass', 'form_field', 'form_field', 'AdminFormFieldController', 5, 0, 0, '2019-09-10 16:16:31', NULL, NULL, 0, NULL, NULL),
(28, 'Forms', 'fa fa-mail-forward', 'forms', 'forms', 'AdminFormsController', 5, 0, 0, '2019-09-10 10:42:22', NULL, NULL, 0, NULL, NULL),
(11, 'Log User Access', 'fa fa-flag-o', 'logs', 'cms_logs', 'LogsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(10, 'API Generator', 'fa fa-cloud-download', 'api_generator', '', 'ApiCustomController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(9, 'Statistic Builder', 'fa fa-dashboard', 'statistic_builder', 'cms_statistics', 'StatisticBuilderController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(8, 'Email Templates', 'fa fa-envelope-o', 'email_templates', 'cms_email_templates', 'EmailTemplatesController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(7, 'Menu Management', 'fa fa-bars', 'menu_management', 'cms_menus', 'MenusController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 1, NULL, NULL),
(6, 'Module Generator', 'fa fa-database', 'module_generator', 'cms_moduls', 'ModulsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(5, 'Settings', 'fa fa-cog', 'settings', 'cms_settings', 'SettingsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(4, 'إدارة المستخدمين', 'fa fa-users', 'users', 'cms_users', 'AdminCmsUsersController', 0, 0, 0, '2019-05-30 04:06:58', NULL, NULL, 1, NULL, NULL),
(3, 'أدوار الصلاحيات', 'fa fa-cog', 'privileges_roles', 'cms_privileges_roles', 'PrivilegesRolesController', 1, 0, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(2, 'الصلاحيات', 'fa fa-cog', 'privileges', 'cms_privileges', 'PrivilegesController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(1, 'Notifications', 'fa fa-cog', 'notifications', 'cms_notifications', 'NotificationsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(83, 'الزبائن', 'fa fa-glass', 'persons', 'persons', 'AdminPersonsController', 0, 0, 0, '2020-03-10 18:30:11', NULL, NULL, 1, 'name_en', 'field'),
(82, 'الحسابات', 'fa fa-glass', 'accounts', 'accounts', 'AdminAccountsController', 0, 0, 0, '2020-03-10 18:24:42', NULL, NULL, 1, 'name_en', 'field'),
(81, 'تصنيفات المواد', 'fa fa-tags', 'item_categories', 'item_categories', 'AdminItemCategoriesController', 0, 0, 0, '2020-03-10 18:13:59', NULL, NULL, 1, 'name_en', 'field'),
(80, 'المواد', 'fa fa-glass', 'items', 'items', 'AdminItemsController', 0, 0, 0, '2020-03-10 18:09:47', NULL, NULL, 1, 'name_en', 'record'),
(79, 'الوحدات', 'fa fa-gear', 'item_units', 'item_units', 'AdminItemUnitsController', 0, 0, 0, '2020-03-10 18:04:48', NULL, NULL, 1, NULL, 'field'),
(78, 'تصنيفات العميل', 'fa fa-list-alt', 'person_type', 'person_type', 'AdminPersonTypeController', 5, 0, 0, '2020-03-10 18:00:59', NULL, NULL, 1, 'name_en', 'field'),
(84, 'المستودعات', 'fa fa-file-o', 'inventories', 'inventories', 'AdminInventoriesController', 0, 0, 0, '2020-03-11 08:25:46', NULL, NULL, 1, 'name_en', 'field'),
(85, 'العملات', 'fa fa-money', 'currencies', 'currencies', 'AdminCurrenciesController', 0, 0, 0, '2020-03-11 08:43:48', NULL, NULL, 1, 'name_en', 'field'),
(86, 'Invoices', 'fa fa-money', 'bills', 'bills', 'AdminBillsController', 5, 0, 0, '2020-03-12 08:08:41', NULL, NULL, 1, 'name_en', 'field'),
(87, 'Bill Items', 'fa fa-glass', 'bill_item', 'bill_item', 'AdminBillItemController', 5, 0, 0, '2020-03-12 08:43:18', NULL, NULL, 1, 'name_en', 'record'),
(88, 'Entries', 'fa fa-forward', 'entries', 'entries', 'AdminEntriesController', 5, 0, 0, '2020-03-12 11:11:55', NULL, '2020-03-12 11:20:13', 1, 'name_en', 'field'),
(89, 'entries', 'fa fa-glass', 'entries89', 'entries', 'AdminEntries89Controller', 5, 0, 0, '2020-03-12 11:34:08', NULL, NULL, 1, 'name', 'field'),
(90, 'All Entries', 'fa fa-glass', 'entry_base', 'entry_base', 'AdminEntryBaseController', 5, 0, 0, '2020-03-12 11:43:57', NULL, NULL, 1, 'name', 'field'),
(91, 'Item Tracking', 'fa fa-glass', 'item_tracking', 'item_tracking', 'AdminItemTrackingController', 5, 0, 0, '2020-03-14 12:25:26', NULL, NULL, 1, 'code', 'field'),
(92, 'Items Inventory', 'fa fa-search', 'item_tracking92', 'item_tracking', 'AdminItemTracking92Controller', 5, 0, 0, '2020-03-14 12:46:35', NULL, NULL, 1, 'code', 'field'),
(93, 'فواتير المبيعات', 'fa fa-glass', 'bills_sales_invoice', 'bills', 'AdminBillsSalesInvoiceController', 0, 0, 0, '2020-03-16 08:04:56', NULL, NULL, 1, NULL, 'field'),
(94, 'فواتير المشتريات', 'fa fa-glass', 'bills_purchase_invoice', 'bills', 'AdminBillsPurchaseInvoiceController', 0, 0, 0, '2020-03-16 08:08:11', NULL, NULL, 1, NULL, 'record'),
(95, 'فواتير مردودات المشتريات', 'fa fa-glass', 'bills_purchase_return_invoice', 'bills', 'AdminBillsPurchaseReturnInvoiceController', 0, 0, 0, '2020-03-16 08:37:32', NULL, NULL, 1, NULL, 'record'),
(96, 'فواتير مردودات المبيعات', 'fa fa-glass', 'bills_sales_return_invoice', 'bills', 'AdminBillsSalesReturnInvoiceController', 0, 0, 0, '2020-03-16 08:38:49', NULL, NULL, 0, NULL, 'record'),
(120, 'الموردون', 'fa fa-glass', 'suppliers', 'persons', 'AdminSuppliersController', 0, 0, 0, '2021-12-18 06:22:55', NULL, NULL, 0, NULL, 'record'),
(98, 'Reports', 'fa fa-file-o', 'reports', 'reports', 'AdminReportsController', 5, 0, 0, '2020-03-17 14:33:29', NULL, NULL, 1, NULL, 'record'),
(99, 'تقرير الحسابات', 'fa fa-glass', 'reports99', 'reports', 'AdminReports99Controller', 0, 0, 0, '2020-03-20 11:30:37', NULL, NULL, 1, NULL, 'field'),
(100, 'بضاعة أول المدة', 'fa fa-glass', 'item_tracking100', 'item_tracking', 'AdminItemTracking100Controller', 0, 0, 0, '2020-03-25 11:49:34', NULL, NULL, 1, NULL, 'record'),
(101, 'نقل مواد', 'fa fa-glass', 'item_tracking101', 'item_tracking', 'AdminItemTracking101Controller', 0, 0, 0, '2020-03-25 20:08:05', NULL, NULL, 1, NULL, 'record'),
(102, 'تقرير حركة المواد', 'fa fa-glass', 'item_tracking102', 'item_tracking', 'AdminItemTracking102Controller', 0, 0, 0, '2020-03-26 06:35:24', NULL, NULL, 1, NULL, 'record'),
(103, 'تقرير أرصدة المواد (جرد)', 'fa fa-glass', 'inventory_accounting', 'item_tracking', 'AdminInventoryAccountingController', 0, 0, 0, '2020-03-28 17:55:05', NULL, NULL, 1, NULL, 'record'),
(104, 'Inventory Accounting', 'fa fa-glass', 'item_tracking104', 'item_tracking', 'AdminItemTracking104Controller', 5, 0, 0, '2020-03-28 18:14:27', NULL, '2020-03-28 18:38:28', 1, NULL, 'record'),
(105, 'Delegates', 'fa fa-glass', 'delegates', 'delegates', 'AdminDelegatesController', 5, 0, 0, '2020-03-29 23:36:02', NULL, NULL, 0, NULL, 'record'),
(106, 'تقرير كشف حساب (زبون - مورد)', 'fa fa-glass', 'accountstatement', 'entries', 'AdminAccountstatementController', 0, 0, 0, '2020-04-02 03:59:52', NULL, NULL, 1, NULL, 'record'),
(107, 'تقرير المندوبين', 'fa fa-glass', 'salesmen_report', 'bills', 'AdminSalesmenReportController', 0, 0, 0, '2020-04-02 13:46:56', NULL, NULL, 1, NULL, 'record'),
(108, 'سندات القبض', NULL, 'receipt_voucher', 'vouchers', 'AdminReceiptVoucherController', 0, 0, 0, '2020-04-12 04:16:07', NULL, NULL, 1, NULL, 'record'),
(109, 'سندات الدفع', 'fa fa-glass', 'payment_voucher', 'vouchers', 'AdminPaymentVoucherController', 0, 0, 0, '2020-04-12 05:20:36', NULL, NULL, 1, NULL, 'record'),
(111, 'File Voucher', 'fa fa-glass', 'files_ vouchers111', 'files_ vouchers', 'AdminFilesVouchers111Controller', 5, 0, 0, '2020-05-26 11:25:57', NULL, NULL, 1, NULL, 'record'),
(112, 'Bill Files', 'fa fa-glass', 'bills_files', 'bills_files', 'AdminBillsFilesController', 5, 0, 0, '2020-05-26 15:01:31', NULL, NULL, 1, NULL, 'record'),
(113, 'توثيق عقد الرهن', 'fa fa-glass', 'bill_item113', 'bill_item', 'AdminBillItem113Controller', 5, 0, 0, '2020-06-04 03:53:31', NULL, NULL, 0, NULL, 'record'),
(114, 'سندات التحويل', 'fa fa-glass', 'transfer_vouchers', 'vouchers', 'AdminTransferVouchersController', 0, 0, 0, '2020-06-08 08:42:29', NULL, NULL, 1, NULL, 'record'),
(115, 'سندات الأرصدة الإفتتاحية', 'fa fa-glass', 'initial_voucher', 'vouchers', 'AdminInitialVoucherController', 0, 0, 0, '2021-11-16 06:38:11', NULL, NULL, 1, NULL, 'record'),
(116, 'أنواع حسابات الإقفال', 'fa fa-glass', 'closing_accounts_types', 'closing_accounts_types', 'AdminClosingAccountsTypesController', 0, 0, 0, '2021-11-29 05:15:23', NULL, NULL, 0, NULL, 'field'),
(117, 'تقرير حسابات الإقفال', 'fa fa-glass', 'reports117', 'reports', 'AdminReports117Controller', 0, 0, 0, '2021-11-29 05:41:01', NULL, NULL, 1, NULL, 'field'),
(118, 'سند قيد عام', 'fa fa-glass', 'reports118', 'reports', 'AdminReports118Controller', 0, 0, 0, '2021-12-06 12:15:51', NULL, NULL, 0, NULL, 'field'),
(119, 'تدوير الحسابات', 'fa fa-glass', 'reports_rotate_data', 'reports', 'AdminReportsRotateDataController', 0, 0, 0, '2021-12-06 16:05:39', NULL, NULL, 0, NULL, 'record'),
(121, 'سجل سعر صرف العملات', 'fa fa-glass', 'currency_history', 'currency_history', 'AdminCurrencyHistoryController', 0, 0, 0, '2022-01-04 05:18:49', NULL, NULL, 0, NULL, 'record'),
(122, 'أرشيف القيود المعدلة', 'fa fa-glass', 'entries_history', 'reports', 'AdminReportsEntriesHistoryController', 0, 0, 0, '2022-01-18 14:18:11', NULL, NULL, 0, NULL, 'record');

-- --------------------------------------------------------

--
-- Table structure for table `cms_notifications`
--

DROP TABLE IF EXISTS `cms_notifications`;
CREATE TABLE IF NOT EXISTS `cms_notifications` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cms_users` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_privileges`
--

DROP TABLE IF EXISTS `cms_privileges`;
CREATE TABLE IF NOT EXISTS `cms_privileges` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) DEFAULT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_privileges`
--

INSERT INTO `cms_privileges` (`id`, `name`, `is_superadmin`, `theme_color`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 1, 'skin-red', '2019-05-30 06:06:58', NULL),
(2, 'normal user', 0, 'skin-red', NULL, NULL),
(3, 'accountant', 0, 'skin-purple', NULL, NULL),
(4, 'salesman', 0, 'skin-green', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_privileges_roles`
--

DROP TABLE IF EXISTS `cms_privileges_roles`;
CREATE TABLE IF NOT EXISTS `cms_privileges_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_visible` tinyint(1) DEFAULT NULL,
  `is_create` tinyint(1) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `id_cms_moduls` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_privileges_roles`
--

INSERT INTO `cms_privileges_roles` (`id`, `is_visible`, `is_create`, `is_read`, `is_edit`, `is_delete`, `id_cms_privileges`, `id_cms_moduls`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 12, NULL, NULL),
(2, 1, 1, 1, 1, 1, 1, 13, NULL, NULL),
(3, 1, 1, 1, 1, 1, 1, 14, NULL, NULL),
(4, 1, 1, 1, 1, 1, 1, 15, NULL, NULL),
(5, 1, 1, 1, 1, 1, 1, 16, NULL, NULL),
(6, 1, 1, 1, 1, 1, 1, 17, NULL, NULL),
(7, 1, 1, 1, 1, 1, 1, 18, NULL, NULL),
(8, 1, 1, 1, 1, 1, 1, 19, NULL, NULL),
(9, 1, 1, 1, 1, 1, 1, 20, NULL, NULL),
(10, 1, 1, 1, 1, 1, 1, 21, NULL, NULL),
(11, 1, 1, 1, 1, 1, 1, 22, NULL, NULL),
(12, 1, 1, 1, 1, 1, 1, 23, NULL, NULL),
(13, 1, 1, 1, 1, 1, 1, 24, NULL, NULL),
(14, 1, 1, 1, 1, 1, 1, 25, NULL, NULL),
(15, 1, 1, 1, 1, 1, 1, 26, NULL, NULL),
(16, 1, 1, 1, 1, 1, 1, 27, NULL, NULL),
(17, 1, 1, 1, 1, 1, 1, 28, NULL, NULL),
(18, 1, 1, 1, 1, 1, 1, 29, NULL, NULL),
(19, 1, 1, 1, 1, 1, 1, 53, NULL, NULL),
(20, 1, 1, 1, 1, 1, 1, 54, NULL, NULL),
(21, 1, 1, 1, 1, 1, 1, 55, NULL, NULL),
(22, 1, 1, 1, 1, 1, 1, 56, NULL, NULL),
(56, 1, 1, 1, 1, 1, 1, 59, NULL, NULL),
(55, 1, 1, 1, 1, 1, 1, 58, NULL, NULL),
(85, 1, 1, 1, 1, 1, 2, 78, NULL, NULL),
(84, 1, 1, 1, 1, 1, 2, 80, NULL, NULL),
(83, 1, 1, 1, 1, 1, 2, 79, NULL, NULL),
(82, 1, 1, 1, 1, 1, 2, 81, NULL, NULL),
(81, 1, 1, 1, 1, 1, 2, 84, NULL, NULL),
(80, 1, 1, 1, 1, 1, 2, 85, NULL, NULL),
(79, 1, 1, 1, 1, 1, 2, 82, NULL, NULL),
(46, 1, 1, 1, 1, 1, 1, 57, NULL, NULL),
(57, 1, 1, 1, 1, 1, 1, 60, NULL, NULL),
(58, 1, 1, 1, 1, 1, 1, 72, NULL, NULL),
(59, 1, 1, 1, 1, 1, 1, 73, NULL, NULL),
(60, 1, 1, 1, 1, 1, 1, 74, NULL, NULL),
(61, 1, 1, 1, 1, 1, 1, 75, NULL, NULL),
(62, 1, 1, 1, 1, 1, 1, 76, NULL, NULL),
(63, 1, 1, 1, 1, 1, 1, 77, NULL, NULL),
(64, 1, 1, 1, 1, 1, 1, 78, NULL, NULL),
(65, 1, 1, 1, 1, 1, 1, 79, NULL, NULL),
(66, 1, 1, 1, 1, 1, 1, 80, NULL, NULL),
(67, 1, 1, 1, 1, 1, 1, 81, NULL, NULL),
(68, 1, 1, 1, 1, 1, 1, 82, NULL, NULL),
(69, 1, 1, 1, 1, 1, 1, 83, NULL, NULL),
(77, 1, 1, 1, 1, 1, 1, 84, NULL, NULL),
(78, 1, 1, 1, 1, 1, 1, 85, NULL, NULL),
(86, 1, 1, 1, 1, 1, 2, 83, NULL, NULL),
(87, 0, 0, 0, 1, 0, 2, 4, NULL, NULL),
(88, 1, 1, 1, 1, 1, 1, 86, NULL, NULL),
(89, 1, 1, 1, 1, 1, 1, 87, NULL, NULL),
(168, 1, 1, 1, 1, 1, 1, 121, NULL, NULL),
(167, 1, 1, 1, 1, 1, 3, 85, NULL, NULL),
(93, 1, 1, 1, 1, 1, 1, 88, NULL, NULL),
(94, 1, 1, 1, 1, 1, 1, 89, NULL, NULL),
(95, 1, 1, 1, 1, 1, 1, 90, NULL, NULL),
(96, 1, 1, 1, 1, 1, 1, 91, NULL, NULL),
(97, 1, 1, 1, 1, 1, 1, 92, NULL, NULL),
(98, 1, 1, 1, 1, 1, 1, 93, NULL, NULL),
(99, 1, 1, 1, 1, 1, 1, 94, NULL, NULL),
(100, 1, 1, 1, 1, 1, 1, 95, NULL, NULL),
(101, 1, 1, 1, 1, 1, 1, 96, NULL, NULL),
(102, 1, 1, 1, 1, 1, 1, 97, NULL, NULL),
(103, 1, 1, 1, 1, 1, 1, 98, NULL, NULL),
(104, 1, 1, 1, 1, 1, 1, 99, NULL, NULL),
(105, 1, 1, 1, 1, 1, 1, 100, NULL, NULL),
(106, 1, 1, 1, 1, 1, 1, 101, NULL, NULL),
(107, 1, 1, 1, 1, 1, 1, 102, NULL, NULL),
(108, 1, 1, 1, 1, 1, 1, 103, NULL, NULL),
(109, 1, 1, 1, 1, 1, 1, 104, NULL, NULL),
(110, 1, 1, 1, 1, 1, 1, 105, NULL, NULL),
(111, 1, 1, 1, 1, 1, 1, 106, NULL, NULL),
(112, 1, 1, 1, 1, 1, 1, 107, NULL, NULL),
(166, 1, 1, 1, 1, 0, 4, 101, NULL, NULL),
(138, 1, 1, 1, 1, 1, 1, 114, NULL, NULL),
(137, 1, 1, 1, 1, 1, 1, 113, NULL, NULL),
(165, 1, 1, 1, 1, 0, 4, 96, NULL, NULL),
(164, 1, 1, 1, 1, 0, 4, 93, NULL, NULL),
(163, 1, 1, 1, 1, 0, 4, 108, NULL, NULL),
(162, 1, 1, 1, 1, 0, 4, 109, NULL, NULL),
(127, 1, 1, 1, 1, 1, 1, 112, NULL, NULL),
(126, 1, 1, 1, 1, 1, 1, 111, NULL, NULL),
(125, 1, 1, 1, 1, 1, 1, 110, NULL, NULL),
(119, 1, 1, 1, 1, 1, 1, 109, NULL, NULL),
(118, 1, 1, 1, 1, 1, 1, 108, NULL, NULL),
(161, 1, 1, 1, 0, 0, 4, 114, NULL, NULL),
(160, 1, 1, 1, 1, 0, 4, 102, NULL, NULL),
(159, 1, 1, 1, 1, 0, 4, 103, NULL, NULL),
(158, 1, 1, 1, 1, 1, 4, 79, NULL, NULL),
(157, 1, 1, 1, 1, 0, 4, 84, NULL, NULL),
(149, 1, 1, 1, 1, 1, 1, 115, NULL, NULL),
(150, 1, 1, 1, 1, 1, 1, 116, NULL, NULL),
(151, 1, 1, 1, 1, 1, 1, 117, NULL, NULL),
(152, 1, 1, 1, 1, 1, 1, 118, NULL, NULL),
(153, 1, 1, 1, 1, 1, 1, 119, NULL, NULL),
(154, 1, 1, 1, 1, 1, 1, 120, NULL, NULL),
(156, 1, 1, 1, 1, 0, 4, 83, NULL, NULL),
(155, 1, 1, 1, 0, 0, 4, 82, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
CREATE TABLE IF NOT EXISTS `cms_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `content_input_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataenum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_setting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `name`, `content`, `content_input_type`, `dataenum`, `helper`, `created_at`, `updated_at`, `group_setting`, `label`) VALUES
(1, 'login_background_color', NULL, 'text', NULL, 'Input hexacode', '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Background Color'),
(2, 'login_font_color', NULL, 'text', NULL, 'Input hexacode', '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Font Color'),
(3, 'login_background_image', NULL, 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Background Image'),
(4, 'email_sender', '', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Email Sender'),
(5, 'smtp_driver', 'smtp', 'select', 'smtp,mail,sendmail', NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Mail Driver'),
(6, 'smtp_host', '', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Host'),
(7, 'smtp_port', '465', 'text', NULL, 'default 25', '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Port'),
(8, 'smtp_username', '', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Username'),
(9, 'smtp_password', '', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Password'),
(10, 'appname', '$$company_name$$', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Application Name'),
(11, 'default_paper_size', 'Legal', 'text', NULL, 'Paper size, ex : A4, Legal, etc', '2019-05-30 06:06:58', NULL, 'Application Setting', 'Default Paper Print Size'),
(12, 'logo', 'uploads/2019-11/bc8434249b214a4bf1cf55c8671f38f1.png', 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Logo'),
(13, 'favicon', 'uploads/2019-11/001d874b14a004be36933953e0f56e81.png', 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Favicon'),
(14, 'api_debug_mode', 'false', 'select', 'true,false', NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'API Debug Mode'),
(15, 'google_api_key', NULL, 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Google API Key'),
(16, 'google_fcm_key', NULL, 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Google FCM Key');

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistics`
--

DROP TABLE IF EXISTS `cms_statistics`;
CREATE TABLE IF NOT EXISTS `cms_statistics` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_statistics`
--

INSERT INTO `cms_statistics` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(3, 'statistic', 'statistic', '2020-03-18 06:00:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistic_components`
--

DROP TABLE IF EXISTS `cms_statistic_components`;
CREATE TABLE IF NOT EXISTS `cms_statistic_components` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cms_statistics` int(11) DEFAULT NULL,
  `componentID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_statistic_components`
--

INSERT INTO `cms_statistic_components` (`id`, `id_cms_statistics`, `componentID`, `component_name`, `area_name`, `sorting`, `name`, `config`, `created_at`, `updated_at`) VALUES
(1, 2, 'e43e265a2e3a22218477d1bbca62ef97', 'smallbox', 'area1', 0, NULL, '{\"name\":\"Events Request\",\"icon\":\"ion-bag\",\"color\":\"bg-red\",\"link\":\"\\/admin\\/request_event\",\"sql\":\"select count(*) from request_events\"}', '2019-06-20 05:45:33', NULL),
(3, 2, '2ab24cc96db3a09f3efb8b7007125e00', 'smallbox', 'area2', 0, NULL, '{\"name\":\"Contact Us Requests\",\"icon\":\"ion-bag\",\"color\":\"bg-aqua\",\"link\":\"\\/admin\\/contact_us\",\"sql\":\"select count(*)  from contact_us\"}', '2019-06-20 05:53:35', NULL),
(4, 2, '5cfc7783207ae24ac240114a13521ea6', 'table', 'area5', 0, NULL, '{\"name\":\"Events\",\"sql\":\"select title_en as Title ,country,location, start_date as \'start Date\' , end_date as \'End Date\'  from events order by start_date desc\"}', '2019-06-26 04:53:31', NULL),
(5, 2, '40436fbc84fba971792d2a59862a03c5', 'smallbox', 'area3', 0, NULL, '{\"name\":\"Course Requests\",\"icon\":\"ion-bag\",\"color\":\"bg-yellow\",\"link\":\"\\/admin\\/request_course\",\"sql\":\"SELECT count( *) FROM `request_course`\"}', '2019-11-05 12:18:10', NULL),
(6, 2, '683394552c8f25051cfb7fdbbfeeafd3', 'chartarea', NULL, 0, 'Untitled', NULL, '2019-11-05 12:20:09', NULL),
(7, 2, '125b2f4fb803a4da9bfc3397232de911', 'chartarea', NULL, 0, 'Untitled', NULL, '2019-11-05 12:20:13', NULL),
(8, 2, '8cf4705d0d16ef23e7d44dffda63d471', 'smallbox', 'area4', 0, NULL, '{\"name\":\"Courses Count\",\"icon\":\"ion-bag\",\"color\":\"bg-green\",\"link\":\"\\/admin\\/courses\",\"sql\":\"SELECT count( *) FROM `courses`\"}', '2019-11-05 12:21:56', NULL),
(9, 2, '453235bcffcd5413269a2f37b5b7dfcd', 'chartarea', NULL, 0, 'Untitled', NULL, '2019-11-05 12:26:28', NULL),
(10, 2, 'c4b8bc5f16781681008bf7aab61400e8', 'chartarea', NULL, 0, 'Untitled', NULL, '2019-11-05 12:26:33', NULL),
(11, 2, '0268139a72f13ef8fe4077a1940af5c5', 'chartarea', 'area5', 0, NULL, '{\"name\":\"statistic\",\"sql\":\"select count(*) as value, b.title_en as label  from request_course a , courses b  where a.course_id=b.id group by label  Order by label\",\"area_name\":\"label\",\"goals\":null}', '2019-11-05 12:26:40', NULL),
(12, 3, 'cf1bb6baa2b316672577a4fbd15de369', 'smallbox', 'area1', 0, NULL, '{\"name\":\"\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0644.\\u0633\",\"icon\":\"ion-bag\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=15&delegate_id=-1&from_date=&to_date=&currency_id=1\",\"sql\":\"select FORMAT(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'15\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=15 AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:00:35', NULL),
(13, 3, '51f70839f7f55677f1a8d1327ce5511c', 'smallbox', 'area2', 0, NULL, '{\"name\":\"\\u0635\\u0646\\u062f\\u0648\\u0642  \\u0627\\u0644\\u062f\\u0648\\u0644\\u0627\\u0631\",\"icon\":\"ion-social-usd\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=16\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'16\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=16 AND entries.currency_id=2 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:28:32', NULL),
(14, 5, 'f3f2b406dfaa83d94322e885d2e3a42a', 'smallbox', 'area2', 1, NULL, '{\"name\":\"\\u0627\\u0644\\u0645\\u0634\\u062a\\u0631\\u064a\\u0627\\u062a \\u0627\\u0644\\u0644\\u064a\\u0631\\u0629 \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a\\u0629\",\"icon\":\"ion-ios-cart\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=33\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'33\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:30:40', NULL),
(17, 3, 'c93cc73b87364bd0e0c866d610a10651', 'smallbox', 'area4', 0, NULL, '{\"name\":\"\\u0627\\u0644\\u0645\\u0628\\u064a\\u0639\\u0627\\u062a\",\"icon\":\"ion-arrow-graph-up-right\",\"color\":\"bg-yellow\",\"link\":\"\\/modules\\/reports99?account_id=35\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'35\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 02:44:01', NULL),
(16, 3, '4d218f1832c3a13a4b59d1c1c93451e5', 'smallbox', NULL, 0, 'Untitled', NULL, '2020-03-18 04:37:32', NULL),
(20, 5, '05c3b18df7b97b09a4e1160b9006a126', 'smallbox', 'area3', 2, NULL, '{\"name\":\"\\u0645\\u0631\\u062f\\u0648\\u062f \\u0645\\u0634\\u062a\\u0631\\u064a\\u0627\\u062a\",\"icon\":\"ion-arrow-swap\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=34\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'34\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:12:26', NULL),
(18, 3, '8339ad35e433b80e7ac3791d632ef4da', 'smallbox', 'area3', 1, NULL, '{\"name\":\"\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u064a\\u0648\\u0631\\u0648\",\"icon\":\"ion-social-euro\",\"color\":\"bg-aqua\",\"link\":\"\\/modules\\/reports99?account_id=17\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'17\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=17 AND entries.currency_id=3 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:01:22', NULL),
(19, 5, 'fc26d0e519c256777017217031c57b03', 'smallbox', 'area1', 1, NULL, '{\"name\":\"\\u0645\\u0631\\u062f\\u0648\\u062f \\u0645\\u0628\\u064a\\u0639\\u0627\\u062a\",\"icon\":\"ion-arrow-swap\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=36\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'36\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:05:18', NULL),
(21, 5, '01c39a8ebf193b30402c531941ad5757', 'smallbox', 'area4', 1, NULL, '{\"name\":\"\\u0627\\u0644\\u062d\\u0633\\u0645 \\u0627\\u0644\\u0645\\u0643\\u062a\\u0633\\u0628\",\"icon\":\"ion-plus-circled\",\"color\":\"bg-aqua\",\"link\":\"\\/modules\\/reports99?account_id=38\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'38\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:14:52', NULL),
(22, 5, '93fb5a7c619adde01c332cb2cfb15d0c', 'smallbox', 'area1', 2, NULL, '{\"name\":\"\\u0627\\u0644\\u062d\\u0633\\u0645 \\u0627\\u0644\\u0645\\u0645\\u0646\\u0648\\u062d\",\"icon\":\"ion-minus-circled\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=37\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'37\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:18:42', NULL),
(23, 4, 'dd9437903c553af409bf7a5b0391fe78', 'smallbox', 'area3', 0, NULL, '{\"name\":\"\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u0644\\u064a\\u0631\\u0629 \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a\\u0629\",\"icon\":\"ion-bag\",\"color\":\"bg-green\",\"link\":\"#\",\"sql\":null}', '2021-12-08 06:25:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE IF NOT EXISTS `cms_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `customers_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `name`, `photo`, `email`, `password`, `id_cms_privileges`, `created_at`, `updated_at`, `status`, `inventory_id`, `account_id`, `customers_account_id`) VALUES
(1, 'Super Admin', '/images/portfolio1_logo.png', 'superadmin@voila.digital', '$2y$10$MyiovAMt9R8jmFl4vUUCVO2kw6.q76HWLQJvuUZ.zlZIJCzRpwvDy', 1, '2019-05-30 03:06:58', '2020-07-21 09:55:23', 'Active', NULL, 0, 0),
(2, 'Admin', '/images/portfolio1_logo.png', '$$email$$', '$$password$$', 1, '2019-05-30 03:06:58', '2020-07-21 09:55:23', 'Active', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `in_used` tinyint(4) DEFAULT '1',
  `is_major` tinyint(4) DEFAULT '1',
  `note` longtext COLLATE utf8_unicode_ci,
  `ex_rate` decimal(10,2) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name_en`, `name_ar`, `account_id`, `in_used`, `is_major`, `note`, `ex_rate`, `icon`, `color`, `active`, `sorting`) VALUES
(1, 'S.P', 'ل.س', 4, 1, 1, 'العملة الاساسية', '1.00', 'fa fa-money', 'red', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency_history`
--

DROP TABLE IF EXISTS `currency_history`;
CREATE TABLE IF NOT EXISTS `currency_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_rate` decimal(10,0) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `edit_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `delegates`
--

DROP TABLE IF EXISTS `delegates`;
CREATE TABLE IF NOT EXISTS `delegates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_receiver`
--

DROP TABLE IF EXISTS `email_receiver`;
CREATE TABLE IF NOT EXISTS `email_receiver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` longtext,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_base_id` int(11) DEFAULT NULL,
  `debit` decimal(10,2) DEFAULT NULL,
  `credit` decimal(10,2) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `rotate_year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry_base`
--

DROP TABLE IF EXISTS `entry_base`;
CREATE TABLE IF NOT EXISTS `entry_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_number` int(11) DEFAULT NULL,
  `narration` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `rotate_year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `multi` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `title`, `multi`) VALUES
(1, 'text', 0),
(2, 'email', 0),
(3, 'radio', 1),
(4, 'checkbox', 1),
(5, 'select', 1);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files_vouchers`
--

DROP TABLE IF EXISTS `files_vouchers`;
CREATE TABLE IF NOT EXISTS `files_vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `file_id` varchar(500) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `response` longtext,
  `send_to` varchar(500) DEFAULT NULL,
  `row_type` varchar(500) DEFAULT NULL,
  `sorting` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form_field`
--

DROP TABLE IF EXISTS `form_field`;
CREATE TABLE IF NOT EXISTS `form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `required_filed` varchar(10) DEFAULT NULL,
  `label_filed` varchar(20) DEFAULT NULL,
  `values` varchar(500) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `form_field`
--

INSERT INTO `form_field` (`id`, `form_id`, `field_id`, `required_filed`, `label_filed`, `values`, `active`, `sorting`) VALUES
(10, 1, 3, 'No', 'Gender', 'female , male', 1, 1),
(11, 1, 5, 'No', 'Country', 'syria,lebanon', 1, 2),
(12, 1, 4, 'Yes', 'lang', 'ar , en', 1, 3),
(13, 1, 1, 'Yes', 'First Name', NULL, 1, 4),
(14, 1, 2, 'Yes', 'Email  Address', NULL, 1, 5),
(15, 1, 1, 'Yes', 'age', NULL, 1, 6),
(16, 2, 1, 'Yes', 'Name', NULL, 1, 1),
(17, 2, 4, 'Yes', 'Email', 'eman , test', 1, 2),
(18, 2, 2, 'Yes', 'email', NULL, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `image_model`
--

DROP TABLE IF EXISTS `image_model`;
CREATE TABLE IF NOT EXISTS `image_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(500) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `path` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `image_model`
--

INSERT INTO `image_model` (`id`, `model`, `model_id`, `path`) VALUES
(1, 'Purchase invoice', 111, '/images/pexels-photo-750073.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
CREATE TABLE IF NOT EXISTS `inventories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  `major_classification` tinyint(4) DEFAULT '1',
  `note` longtext COLLATE utf8_unicode_ci,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_type_id`
--

DROP TABLE IF EXISTS `inventory_type_id`;
CREATE TABLE IF NOT EXISTS `inventory_type_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `prefix` varchar(1000) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_type_id`
--

INSERT INTO `inventory_type_id` (`id`, `name_en`, `name_ar`, `prefix`, `active`, `sorting`) VALUES
(1, 'bill', 'فاتورة شراء', 'Bill-', 1, NULL),
(2, 'invoice', 'فاتورة مبيع', 'INV-', 1, NULL),
(3, 'Purchase return', 'مردود مشتريات', 'PR-', 1, NULL),
(4, 'Sales return', 'مردود مبيعات', 'SR-', 1, NULL),
(5, 'inventory beginning', 'بضاعة اول مدة', 'IB-', 1, NULL),
(6, 'Transfer', 'مناقلة', 'TO-', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` longtext,
  `name_ar` longtext,
  `code` bigint(20) DEFAULT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_unit_id` int(11) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

DROP TABLE IF EXISTS `item_categories`;
CREATE TABLE IF NOT EXISTS `item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `major_classification` smallint(6) DEFAULT '1',
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_tracking`
--

DROP TABLE IF EXISTS `item_tracking`;
CREATE TABLE IF NOT EXISTS `item_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` bigint(20) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `inventory_id_type_id` int(11) DEFAULT NULL,
  `source` int(11) DEFAULT NULL,
  `destination` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `note` text,
  `transaction_operation` varchar(50) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `p_code` varchar(50) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `delete_action` varchar(10) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_units`
--

DROP TABLE IF EXISTS `item_units`;
CREATE TABLE IF NOT EXISTS `item_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_units`
--

INSERT INTO `item_units` (`id`, `name_en`, `name_ar`, `active`, `sorting`) VALUES
(1, NULL, 'كغ', 1, NULL),
(2, NULL, 'كيس', 1, NULL),
(3, NULL, 'ظرف', 1, NULL),
(4, NULL, 'لتر', 1, NULL),
(5, NULL, 'عبوة 50 لتر', 1, NULL),
(6, NULL, 'بيدون 5 ليتر', 1, NULL),
(7, NULL, 'بيدون', 1, NULL),
(8, NULL, 'عبوة 1 لتر', 1, NULL),
(9, NULL, 'عبوة 1/2 كغ', 1, NULL),
(10, NULL, 'عبوة 1 كغ', 1, NULL),
(11, NULL, 'كيس 10 كغ', 1, NULL),
(12, NULL, 'عبوة 7.5كغ', 1, NULL),
(13, NULL, 'علبة 1/4 ليتر', 1, NULL),
(14, NULL, 'عبوة 5 كغ', 1, NULL),
(15, NULL, 'عبوة 2 كغ', 1, NULL),
(16, NULL, 'كيس 5 كغ', 1, NULL),
(17, NULL, 'سطل 10 كغ', 1, NULL),
(18, NULL, 'سطل 1 كغ', 1, NULL),
(19, NULL, 'كيس 2 كغ', 1, NULL),
(20, NULL, 'بيدون 20 ليتر', 1, NULL),
(21, NULL, 'علبة', 1, NULL),
(22, NULL, 'كرتونة', 1, NULL),
(23, NULL, 'لصاقة', 1, NULL),
(24, NULL, 'غطاء', 1, NULL),
(25, NULL, 'عبوة', 1, NULL),
(26, NULL, 'سطل', 1, NULL),
(27, NULL, 'خزان', 1, NULL),
(28, NULL, 'برميل', 1, NULL),
(29, NULL, 'جوان', 1, NULL),
(30, NULL, 'طابع', 1, NULL),
(31, NULL, 'قطعة', 1, NULL),
(32, '', 'طن', 1, NULL),
(33, '', 'كيس 10كغ', 1, NULL),
(34, '', 'سطل 10كغ', 1, NULL),
(35, '', 'كيس 5كغ', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

DROP TABLE IF EXISTS `landing_pages`;
CREATE TABLE IF NOT EXISTS `landing_pages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `background` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` longtext COLLATE utf8mb4_unicode_ci,
  `from_scratch` tinyint(1) DEFAULT NULL,
  `background_color` longtext COLLATE utf8mb4_unicode_ci,
  `sorting` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_pages`
--

INSERT INTO `landing_pages` (`id`, `title`, `code`, `is_active`, `created_at`, `updated_at`, `background`, `background_image`, `from_scratch`, `background_color`, `sorting`, `active`) VALUES
(70, 'Landing Title', '<section class=\"ge-sect\"><div class=\"container bs-container\"><div class=\"row ge-row ui-sortable\"><div class=\"col-sm-12 col-xs-12 column ui-sortable col-md-9\" style=\"\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\" data-fe-type=\"form\" data-form-id=\"1\"><div class=\"col-xs-12\"><form method=\"POST\" data-form=\"1\" action=\"/request/form/1\" class=\"col-lg-12 well\" style=\"background:#FFF\">1</form></div></div></div><div class=\"col-md-3 col-sm-3 col-xs-12 column ui-sortable\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\" data-fe-type=\"image\"><img src=\"/images/service6.jpg\" alt=\"/images/service6.jpg\" class=\"img-responsive\"></div></div><div class=\"col-md-3 col-sm-3 col-xs-12 column ui-sortable\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\"></div></div></div></div></section>', 1, '2019-11-21 12:36:41', '2019-11-21 12:36:41', 'rgba(0, 0, 0, 0) none repeat scroll 0% 0% / auto padding-box border-box', NULL, 1, NULL, NULL, 1),
(69, 'Landing Title', '<section class=\"ge-sect\"><div class=\"container bs-container\"><div class=\"row ge-row ui-sortable\"><div class=\"col-md-6 col-sm-6 col-xs-12 column ui-sortable\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\" data-fe-type=\"form\" data-form-id=\"1\"><div class=\"col-xs-12\"><form method=\"POST\" data-form=\"1\" action=\"/request/form/1\" class=\"col-lg-12 well\" style=\"background:#FFF\">1</form></div></div></div><div class=\"col-md-6 col-sm-6 col-xs-12 column ui-sortable\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\"></div></div></div></div></section>', 1, '2019-11-17 04:48:43', '2019-11-17 04:48:43', 'rgba(0, 0, 0, 0) none repeat scroll 0% 0% / auto padding-box border-box', NULL, 1, NULL, NULL, 1),
(68, 'Landing Title', '<section class=\"ge-sect\"><div class=\"container bs-container\"></div></section><section class=\"ge-sect\"><div class=\"container bs-container\"><div class=\"row ge-row ui-sortable\"><div class=\"col-md-5 col-sm-5 col-xs-12 column ui-sortable\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\" data-fe-type=\"form\" data-form-id=\"2\"><div class=\"col-xs-12\"><form method=\"POST\" data-form=\"2\" action=\"/request/form/2\" class=\"col-lg-12 well\" style=\"background: rgb(255, 255, 255);\">2</form></div></div></div><div class=\"col-sm-3 col-xs-12 column ui-sortable col-md-7\" style=\"\"><div class=\"ge-content ge-content-type-tinymce ui-droppable\" data-ge-content-type=\"tinymce\" style=\"background-color: inherit;\" data-fe-type=\"form\" data-form-id=\"1\"><div class=\"col-xs-12\"><form method=\"POST\" data-form=\"1\" action=\"/request/form/1\" class=\"col-lg-12 well\" style=\"background:#FFF\">1</form></div></div></div></div></div></section>', 1, '2019-11-14 10:34:58', '2019-11-14 11:49:29', 'rgba(0, 0, 0, 0) none repeat scroll 0% 0% / auto padding-box border-box', NULL, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `created_at`, `updated_at`, `active`, `sorting`) VALUES
(1, 'English', 'en', NULL, NULL, 1, NULL),
(2, 'franch', 'fr', '2020-02-04 22:00:00', '2020-02-25 22:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `title_en` varchar(200) DEFAULT NULL,
  `title_ar` varchar(200) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `cms_moduls_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `order_item` int(11) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_08_07_145904_add_table_cms_apicustom', 1),
(2, '2016_08_07_150834_add_table_cms_dashboard', 1),
(3, '2016_08_07_151210_add_table_cms_logs', 1),
(4, '2016_08_07_151211_add_details_cms_logs', 1),
(5, '2016_08_07_152014_add_table_cms_privileges', 1),
(6, '2016_08_07_152214_add_table_cms_privileges_roles', 1),
(7, '2016_08_07_152320_add_table_cms_settings', 1),
(8, '2016_08_07_152421_add_table_cms_users', 1),
(9, '2016_08_07_154624_add_table_cms_menus_privileges', 1),
(10, '2016_08_07_154624_add_table_cms_moduls', 1),
(11, '2016_08_17_225409_add_status_cms_users', 1),
(12, '2016_08_20_125418_add_table_cms_notifications', 1),
(13, '2016_09_04_033706_add_table_cms_email_queues', 1),
(14, '2016_09_16_035347_add_group_setting', 1),
(15, '2016_09_16_045425_add_label_setting', 1),
(16, '2016_09_17_104728_create_nullable_cms_apicustom', 1),
(17, '2016_10_01_141740_add_method_type_apicustom', 1),
(18, '2016_10_01_141846_add_parameters_apicustom', 1),
(19, '2016_10_01_141934_add_responses_apicustom', 1),
(20, '2016_10_01_144826_add_table_apikey', 1),
(21, '2016_11_14_141657_create_cms_menus', 1),
(22, '2016_11_15_132350_create_cms_email_templates', 1),
(23, '2016_11_15_190410_create_cms_statistics', 1),
(24, '2016_11_17_102740_create_cms_statistic_components', 1),
(25, '2017_06_06_164501_add_deleted_at_cms_moduls', 1);

-- --------------------------------------------------------

--
-- Table structure for table `package_config`
--

DROP TABLE IF EXISTS `package_config`;
CREATE TABLE IF NOT EXISTS `package_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NULL DEFAULT '1',
  `users_num` int(11) NOT NULL DEFAULT '1',
  `inventories_num` int(11) NOT NULL DEFAULT '1',
  `currencies_num` int(11) NOT NULL DEFAULT '1',
  `free_trial_start_date` date DEFAULT NULL,
  `free_trial_end_date` date DEFAULT NULL,
  `subscription_start_date` date DEFAULT NULL,
  `subscription_end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_config`
--

INSERT INTO `package_config` (`id`, `package_id`, `users_num`, `inventories_num`, `currencies_num`,`free_trial_start_date`,`free_trial_end_date`,`subscription_start_date`,`subscription_end_date`) VALUES
(1, $$package_id$$, $$users_num$$, $$inventories_num$$, $$currencies_num$$,'$$free_trial_start_date$$','$$free_trial_end_date$$','$$subscription_start_date$$','$$subscription_end_date$$');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `phone_number` varchar(1000) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `person_type_id` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_type`
--

DROP TABLE IF EXISTS `person_type`;
CREATE TABLE IF NOT EXISTS `person_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person_type`
--

INSERT INTO `person_type` (`id`, `name_en`, `name_ar`, `active`, `sorting`) VALUES
(1, 'customer', 'زبون', 1, NULL),
(2, 'vendor', 'مورد', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(1000) DEFAULT NULL,
  `received_amount` decimal(10,0) DEFAULT NULL,
  `paid_amount` decimal(10,0) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rotate_data_result`
--

DROP TABLE IF EXISTS `rotate_data_result`;
CREATE TABLE IF NOT EXISTS `rotate_data_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rotate_date` date DEFAULT NULL,
  `profit_and_loss` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
CREATE TABLE IF NOT EXISTS `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description_en` varchar(3000) DEFAULT NULL,
  `description_ar` varchar(3000) DEFAULT NULL,
  `keywords_en` varchar(3000) DEFAULT NULL,
  `keywords_ar` varchar(3000) DEFAULT NULL,
  `author_en` varchar(3000) DEFAULT NULL,
  `author_ar` varchar(3000) DEFAULT NULL,
  `title_ar` varchar(3000) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `title_en` varchar(300) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `image` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `description_en`, `description_ar`, `keywords_en`, `keywords_ar`, `author_en`, `author_ar`, `title_ar`, `model`, `model_id`, `title_en`, `created_at`, `updated_at`, `image`) VALUES
(42, 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', 'Horizons Taiba', 'Horizons Taiba', 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', 'course', NULL, 'Horizons Taiba Aviation Support and Services launched operation on January 2015. It is a company owned by knowledgeable and well-experienced individuals who also have extensive experience in the aviation industry.', '2019-09-10', '2019-09-10', NULL),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'event', NULL, NULL, '2019-11-05', '2019-11-05', NULL),
(46, 'bvsdfvsfd', NULL, 'sds , qewr', 'ewrfqwef , rewqew', 'Maysaa Al Ahmar', NULL, 'svdfvsdfbv', 'news', NULL, 'csvsfv', '2019-11-12', '2019-11-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE IF NOT EXISTS `social_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(200) DEFAULT NULL,
  `title_ar` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `title_en`, `title_ar`, `icon`, `value`, `sorting`, `active`) VALUES
(1, 'facebook', NULL, 'fa fa-facebook-f', 'https://www.facebook.com', 1, 1),
(2, 'twitter', NULL, 'fa fa-twitter', 'https://twitter.com', 5, 1),
(3, 'instagram', NULL, 'fa fa-instagram', 'https://www.instagram.com/', 3, 1),
(4, 'youtube', NULL, 'fa fa-youtube-play', 'https://www.youtube.com', 4, 1),
(5, 'linkedin', NULL, 'fa fa-linkedin', 'https://www.linkedin.com/', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `statistics_setting`
--

DROP TABLE IF EXISTS `statistics_setting`;
CREATE TABLE IF NOT EXISTS `statistics_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statistics_setting`
--

INSERT INTO `statistics_setting` (`id`, `name`, `value`) VALUES
(1, 'طريقة العرض', '1'),
(2, 'الحسابات', '4');

-- --------------------------------------------------------

--
-- Table structure for table `system_config`
--

DROP TABLE IF EXISTS `system_config`;
CREATE TABLE IF NOT EXISTS `system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_config`
--

INSERT INTO `system_config` (`id`, `config_key`, `config_value`) VALUES
(1, 'Purchases_Account', '11'),
(2, 'Purchases_Return_Account', '12'),
(3, 'Sales_Account', '13'),
(4, 'Sales_Return_Account', '14'),
(5, 'Earned_Discount', '16'),
(6, 'Granted_Discount', '15'),
(7, 'Customers_Account', '2'),
(8, 'Delegates_Parent_Account', '5'),
(9, 'Currencies_Parent_Account', '3'),
(10, 'Incomes_Account', '17'),
(11, 'Outgoings_Account', '6'),
(12, 'Main_Accounts_ids', '2,3,5,6,11,12,13,14,15,16,17');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `p_code` varchar(50) NOT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `credit` int(11) NOT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `narration` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` decimal(50,2) NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) NOT NULL DEFAULT '0',
  `delete_action` varchar(20) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

DROP TABLE IF EXISTS `voucher_types`;
CREATE TABLE IF NOT EXISTS `voucher_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name_ar`, `name_en`, `prefix`, `active`, `sorting`) VALUES
(1, 'سند قبض', 'receipt voucher', 'RV-', 1, NULL),
(2, 'سند دفع', 'payment voucher', 'PV-', 1, NULL),
(3, 'سند تحويل', 'transfer voucher', 'TV-', 1, NULL),
(4, 'سند افتتاحي', 'initial voucher', 'IV-', 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
