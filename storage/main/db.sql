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
  `closing_account_type` int(11) DEFAULT NULL,
  `visible_to_delegates` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `closing_account_type`, `visible_to_delegates`) VALUES
(1, NULL, 'الأصول', 1, NULL, 1, 1, NULL, NULL, NULL),
(2, NULL, 'الزبائن', 101, 1, 1, 1, NULL, 3, NULL),
(3, NULL, 'حسابات النقدية', 102, 1, 1, 1, NULL, 1, NULL),
(4, NULL, 'الصندوق العام', 10201, 3, 0, 1, NULL, NULL, NULL),
(5, NULL, 'حسابات نقدية المندوبين', 103, 1, 1, 1, NULL, NULL, NULL),
(6, NULL, 'المصروفات', 3, NULL, 1, 1, NULL, 3, NULL),
(7, NULL, 'مصروف سيارة المندوب', 301, 6, 0, 1, NULL, NULL, 1),
(8, NULL, 'اجور شحن ومصروف مبيعات', 302, 6, 0, 1, NULL, NULL, 1),
(9, NULL, 'مصاريف مختلفة ', 303, 6, 0, 1, NULL, NULL, NULL),
(10, NULL, 'حسابات المواد', 4, NULL, 1, 1, NULL, NULL, NULL),
(11, NULL, 'مشتريات', 401, 10, 0, 1, NULL, NULL, NULL),
(12, NULL, 'مردود مشتريات', 402, 10, 0, 1, NULL, NULL, NULL),
(13, NULL, 'مبيعات', 403, 10, 0, 1, NULL, NULL, NULL),
(14, NULL, 'مردود مبيعات', 404, 10, 0, 1, NULL, NULL, NULL),
(15, NULL, 'الحسم الممنوح', 405, 10, 0, 1, NULL, NULL, NULL),
(16, NULL, 'الحسم المكتسب', 406, 10, 0, 1, NULL, NULL, NULL),
(17, NULL, 'الإيرادات', 5, NULL, 1, 1, NULL, NULL, NULL),
(18, 'Supplers', 'الموردون', 104, 1, 1, 1, NULL, NULL, NULL);

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
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `attachs_folder` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

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
  `date` datetime DEFAULT NULL,
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
  `status` INT(11) NOT NULL DEFAULT '1', 
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `edit_at` timestamp NULL DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `action` varchar(10) DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
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
-- Table structure for table `bills_items`
--

DROP TABLE IF EXISTS `bills_items`;
CREATE TABLE IF NOT EXISTS `bills_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(50,2) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `subtotal` decimal(50,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_types`
--

DROP TABLE IF EXISTS `bill_types`;
CREATE TABLE IF NOT EXISTS `bill_types` (
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
-- Dumping data for table `bill_types`
--

INSERT INTO `bill_types` (`id`, `name_en`, `name_ar`, `code`, `prefix`, `active`, `sorting`) VALUES
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
(1, 'Email Template Forgot Password Backend', 'forgot_password_backend', 'Mohasabeh Password Change', '<p>Hi,</p><p>Someone requested forgot password, here is your new password : </p><p>[password]</p><p><br></p><p>--</p><p>Regards,</p><p>Admin</p>', '[password]', 'System', 'info@mohasabeh.com', NULL, '2019-05-30 03:06:59', NULL),
(2, 'Domain Request', 'domain_request', 'New Domain Request', '<p>Dear Admin,</p> \r\n	<p>Customer want change his website domain to this domain <strong>[customer_domain]</strong>.</p>\r\n	<p><strong>His Message</strong> is</p>\r\n	<p>[customer_message]</p>\r\n	<p>His <strong>website url</strong> is</p>\r\n	<p><a href=\"[site_url]\" target=\"_blank\">[site_url]</a></p>\r\n	<p>Thanks.</p>', 'Domain Request', NULL, NULL, 'haider.ali.issa@gmail.com', '2022-12-25 10:34:06', NULL),
(3, 'Mail Mohasabeh Team', 'mail_mohasabeh_team', 'Mail Mohasabeh Team', '<p>Dear Admin,</p>\r\n	<p>Customer want contact.</p>\r\n	<p><strong>His Message</strong> is</p>\r\n	<p>[customer_message]</p>\r\n	<p>His <strong>website information</strong> are</p>\r\n	<p><a href=\"[site_url]\" target=\"_blank\">[site_url]</a></p><a href=\"[site_url]\" target=\"_blank\">\r\n	<p>Thanks.</p></a>', 'Mail Mohasabeh Team', NULL, NULL, 'haider.ali.issa@gmail.com', '2022-12-25 10:38:16', NULL),
(4, 'Renewal Request', 'renewal_request', 'Renewal Request', '<p>Dear Admin,</p>\r\n	<p>Customer want change his website avilable period to this period &nbsp; <strong>[renewal_period]</strong>.</p>\r\n	<p><strong>His Message</strong> is</p>\r\n	<p>[customer_message]</p>\r\n	<p>His <strong>website information</strong> are</p>\r\n	<p><a href=\"[site_url]\" target=\"_blank\">[site_url]</a></p><a href=\"[site_url]\" target=\"_blank\">\r\n	<p>Thanks.</p></a>', 'Renewal Request', NULL, NULL, 'haider.ali.issa@gmail.com', '2022-12-25 10:42:16', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_menus`
--

INSERT INTO `cms_menus` (`id`, `name`, `type`, `path`, `color`, `icon`, `parent_id`, `is_active`, `is_dashboard`, `is_front`, `id_cms_privileges`, `sorting`, `lang_id`, `created_at`, `updated_at`) VALUES
(156, 'تصنيفات المواد', 'Route', 'Items\\ItemCategoriesControllerGetIndex', 'normal', 'fa fa-tags', 161, 1, 0, NULL, 1, 2, NULL, '2020-03-10 18:13:59', '2022-07-19 10:07:07'),
(158, 'الزبائن', 'Route', 'Accounts\\CustomersControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 3, NULL, '2020-03-10 18:30:11', '2022-10-19 06:57:35'),
(157, 'الحسابات', 'Route', 'Accounts\\AccountsControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 1, NULL, '2020-03-10 18:24:42', '2022-10-17 14:20:25'),
(155, 'المواد', 'Route', 'Items\\ItemsControllerGetIndex', 'normal', 'fa fa-glass', 161, 1, 0, NULL, 1, 1, NULL, '2020-03-10 18:09:47', '2022-10-19 05:50:44'),
(154, 'الواحدات', 'Route', 'Items\\ItemUnitsControllerGetIndex', 'normal', 'fa fa-gear', 161, 1, 0, NULL, 1, 3, NULL, '2020-03-10 18:04:48', '2022-07-19 10:07:17'),
(159, 'المستودعات', 'Route', 'Inventories\\InventoriesControllerGetIndex', 'normal', 'fa fa-th-large', 181, 1, 0, NULL, 1, 2, NULL, '2020-03-11 08:25:53', '2022-10-19 05:51:10'),
(160, 'العملات', 'Route', 'Currencies\\CurrenciesControllerGetIndex', 'normal', 'fa fa-money', 176, 1, 0, NULL, 1, 1, NULL, '2020-03-11 08:43:55', '2022-10-18 08:54:43'),
(161, 'إدارة المواد', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 5, NULL, '2020-03-11 08:50:37', '2022-10-19 05:50:18'),
(162, 'الفواتير', 'URL', '#', 'normal', 'fa fa-money', 0, 1, 0, NULL, 1, 3, NULL, '2020-03-12 08:08:41', '2022-10-19 05:49:02'),
(171, 'فواتير المبيعات', 'Route', 'Bills\\BillsSalesInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 2, NULL, '2020-03-16 08:04:56', '2022-10-19 05:49:45'),
(172, 'فواتير المشتريات', 'Route', 'Bills\\BillsPurchaseInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 1, NULL, '2020-03-16 08:08:12', '2022-10-19 05:49:18'),
(173, 'فواتير مردودات المشتريات', 'Route', 'Bills\\BillsPurchaseReturnInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 3, NULL, '2020-03-16 08:37:32', '2022-10-19 05:49:29'),
(174, 'فواتير مردودات المبيعات', 'Route', 'Bills\\BillsSalesReturnInvoiceControllerGetIndex', 'normal', 'fa fa-glass', 162, 1, 0, NULL, 1, 4, NULL, '2020-03-16 08:38:49', '2022-10-19 05:49:58'),
(176, 'إدارة العملات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 7, NULL, '2020-03-16 14:02:38', '2022-10-18 08:54:56'),
(178, 'إحصائيات', 'Statistic', 'statistic_builder/show/statistic', 'normal', 'fa fa-glass', 0, 1, 1, NULL, 1, 1, NULL, '2020-03-18 07:00:09', '2022-08-06 12:14:28'),
(179, 'التقارير', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 8, NULL, '2020-03-20 11:09:58', '2022-10-19 06:58:43'),
(180, 'الحسابات', 'Route', 'Reports\\AccountReportControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 2, NULL, '2020-03-20 11:30:37', '2022-10-19 06:58:58'),
(181, 'إدارة المستودعات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 6, NULL, '2020-03-20 14:55:48', '2022-10-19 05:50:58'),
(182, 'إدارة الحسابات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 2, NULL, '2020-03-20 14:57:41', '2022-10-19 06:57:24'),
(183, 'بضاعة اول المدة', 'Route', 'Inventories\\InventoryBeginningControllerGetIndex', 'normal', 'fa fa-glass', 181, 1, 0, NULL, 1, 1, NULL, '2020-03-25 11:49:34', '2022-07-19 10:07:45'),
(184, 'نقل مواد', 'Route', 'Inventories\\TransferItemsControllerGetIndex', 'normal', 'fa fa-glass', 181, 1, 0, NULL, 1, 3, NULL, '2020-03-25 20:08:05', '2022-10-19 05:51:22'),
(185, 'حركة المواد', 'Route', 'Reports\\ItemMovementControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 1, NULL, '2020-03-26 06:35:24', '2022-10-19 05:51:48'),
(186, 'أرصدة المواد (جرد)', 'Route', 'Reports\\InventoryAccountingControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 3, NULL, '2020-03-28 17:55:05', '2022-10-19 05:52:26'),
(189, 'كشف حساب (زبون - مورد)', 'Route', 'Reports\\AccountstatementControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 4, NULL, '2020-04-02 03:59:52', '2022-10-19 06:59:12'),
(190, 'تقرير المندوبين', 'Route', 'Reports\\SalesmenReportControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 5, NULL, '2020-04-02 13:46:57', '2022-10-17 14:25:32'),
(191, 'السندات', 'URL', '#', 'normal', 'fa fa-th-list', 0, 1, 0, NULL, 1, 4, NULL, '2020-04-12 04:14:40', '2022-10-19 06:58:06'),
(192, 'سندات القبض', 'Route', 'Vouchers\\ReceiptVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 1, NULL, '2020-04-12 04:16:07', '2022-10-19 06:58:16'),
(193, 'سندات الدفع', 'Route', 'Vouchers\\PaymentVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 2, NULL, '2020-04-12 05:20:36', '2022-10-19 06:58:26'),
(198, 'سندات التحويل', 'Route', 'Vouchers\\TransferVouchersControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 3, NULL, '2020-06-08 08:42:29', '2022-10-19 13:32:29'),
(200, 'سندات الأرصدة الافتتاحية', 'Route', 'Vouchers\\InitialVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 6, NULL, '2021-11-16 06:38:11', '2022-10-17 14:23:12'),
(201, 'أنواع حسابات الإقفال', 'Route', 'AdminClosingAccountsTypesControllerGetIndex', 'normal', 'fa fa-glass', 182, 0, 0, NULL, 1, 1, NULL, '2021-12-04 11:29:04', '2022-06-11 09:57:17'),
(202, 'حسابات الإقفال', 'Route', 'Reports\\ClosingAccountsControllerGetIndex', 'normal', 'fa fa-glass', 179, 0, 0, NULL, 1, 6, NULL, '2021-12-04 11:29:33', '2022-06-11 09:57:49'),
(204, 'دفتر اليومية', 'Route', 'Reports\\GeneralEntryRecordControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 6, NULL, '2021-12-06 12:15:51', '2022-10-17 14:26:16'),
(205, 'تدوير الحسابات', 'Route', 'Data\\RotateDataControllerGetIndex', 'normal', 'fa fa-recycle', 182, 1, 0, NULL, 1, 2, NULL, '2021-12-06 16:05:39', '2022-06-11 09:57:26'),
(206, 'الموردون', 'Route', 'Accounts\\SuppliersControllerGetIndex', 'normal', 'fa fa-glass', 182, 1, 0, NULL, 1, 4, NULL, '2021-12-18 06:22:57', '2022-10-19 06:57:55'),
(207, 'سجل سعر صرف العملات', 'Route', 'Currencies\\CurrencyHistoryControllerGetIndex', 'normal', 'fa fa-glass', 176, 1, 0, NULL, 1, 2, NULL, '2022-01-04 05:18:50', '2022-07-19 14:53:23'),
(208, 'أرشيف القيود المعدلة', 'Route', 'Reports\\EntriesHistoryControllerGetIndex', 'normal', 'fa fa-glass', 179, 1, 0, NULL, 1, 7, NULL, '2022-01-18 14:18:11', '2022-10-17 14:26:30'),
(211, 'سندات اليومية', 'Route', 'Vouchers\\DailyVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 4, NULL, '2022-06-18 03:03:24', '2022-10-17 16:02:47'),
(210, 'دليل استيراد البيانات', 'Route', 'Data\\ImportDataGuideControllerGetIndex', 'normal', 'fa fa-book', 0, 1, 0, NULL, 1, 10, NULL, '2022-05-28 05:54:12', '2022-11-28 09:02:09'),
(215, 'سندات التصريف', 'Route', 'Vouchers\\ExchangeVoucherControllerGetIndex', 'normal', 'fa fa-glass', 191, 1, 0, NULL, 1, 5, NULL, '2022-07-19 12:47:38', '2022-10-17 16:04:02'),
(218, 'إشعارات القبض', 'Route', 'Notifications\\ReceiptNotificationsControllerGetIndex', 'normal', 'fa fa-list', 191, 1, 0, NULL, 1, 7, NULL, '2022-12-04 08:47:29', '2022-12-04 09:25:14'),
(219, 'إشعارات استلام المواد', 'Route', 'Notifications\\ReceiptItemsNotificationsControllerGetIndex', 'normal', 'fa fa-cubes', 181, 1, 0, NULL, 1, 4, NULL, '2022-12-06 09:55:33', '2022-12-06 10:02:42'),
(220, 'الدورات المالية', 'Module', 'financial_cycles', 'normal', 'fa fa-history', 0, 1, 0, NULL, 1, 9, NULL, '2023-02-08 06:40:00', '2023-02-12 07:09:29');
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
) ENGINE=MyISAM AUTO_INCREMENT=1123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(640, 154, 1),
(639, 154, 2),
(990, 155, 4),
(637, 156, 1),
(721, 157, 5),
(1048, 158, 4),
(1047, 158, 5),
(297, 153, 1),
(989, 155, 5),
(636, 156, 2),
(720, 157, 2),
(554, 209, 1),
(1000, 159, 4),
(1055, 206, 4),
(1046, 158, 3),
(984, 161, 4),
(983, 161, 5),
(960, 172, 4),
(313, 163, 1),
(954, 162, 4),
(953, 162, 5),
(929, 160, 5),
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
(972, 171, 4),
(978, 174, 4),
(1016, 185, 4),
(1087, 180, 4),
(486, 175, 1),
(1080, 179, 4),
(955, 162, 6),
(1041, 182, 4),
(467, 177, 1),
(490, 195, 1),
(488, 194, 1),
(711, 178, 1),
(1079, 179, 5),
(1078, 179, 3),
(1077, 179, 2),
(466, 177, 2),
(465, 177, 3),
(1086, 180, 5),
(696, 207, 1),
(995, 181, 4),
(994, 181, 5),
(1045, 158, 2),
(1040, 182, 5),
(1039, 182, 3),
(645, 183, 1),
(999, 159, 5),
(1015, 185, 5),
(1028, 186, 4),
(375, 187, 1),
(464, 188, 1),
(1094, 189, 4),
(797, 190, 2),
(952, 162, 3),
(959, 172, 5),
(971, 171, 5),
(966, 173, 4),
(977, 174, 5),
(1061, 191, 5),
(1067, 192, 5),
(1073, 193, 5),
(502, 196, 1),
(1060, 191, 3),
(1066, 192, 3),
(1072, 193, 3),
(1014, 185, 3),
(1027, 186, 5),
(504, 197, 1),
(1100, 198, 5),
(1099, 198, 3),
(520, 199, 1),
(519, 199, 4),
(774, 200, 2),
(559, 201, 1),
(1093, 189, 5),
(561, 202, 1),
(526, 203, 1),
(800, 204, 2),
(560, 205, 1),
(1004, 184, 4),
(1054, 206, 5),
(1038, 182, 2),
(803, 208, 2),
(1003, 184, 5),
(868, 211, 5),
(867, 211, 3),
(958, 172, 3),
(965, 173, 5),
(1053, 206, 3),
(579, 212, 1),
(580, 213, 1),
(581, 214, 1),
(1037, 182, 7),
(719, 157, 1),
(1044, 158, 7),
(1052, 206, 2),
(951, 162, 2),
(957, 172, 2),
(970, 171, 3),
(964, 173, 3),
(976, 174, 3),
(1059, 191, 2),
(1065, 192, 2),
(1071, 193, 2),
(1098, 198, 2),
(866, 211, 2),
(773, 200, 1),
(982, 161, 3),
(988, 155, 3),
(638, 156, 5),
(641, 154, 5),
(993, 181, 3),
(646, 183, 5),
(998, 159, 3),
(1002, 184, 1),
(931, 176, 5),
(1013, 185, 2),
(1085, 180, 3),
(1026, 186, 3),
(1092, 189, 3),
(796, 190, 1),
(799, 204, 1),
(802, 208, 1),
(1102, 210, 1),
(877, 215, 5),
(876, 215, 3),
(930, 176, 1),
(928, 160, 1),
(697, 207, 5),
(981, 161, 2),
(987, 155, 2),
(709, 216, 4),
(708, 216, 5),
(713, 217, 1),
(714, 217, 5),
(1051, 206, 7),
(969, 171, 2),
(963, 173, 2),
(975, 174, 2),
(1058, 191, 7),
(1064, 192, 7),
(1070, 193, 7),
(1097, 198, 7),
(865, 211, 1),
(875, 215, 2),
(775, 200, 5),
(1084, 180, 2),
(1025, 186, 2),
(1091, 189, 2),
(798, 190, 5),
(801, 204, 5),
(804, 208, 5),
(1036, 182, 1),
(1043, 158, 1),
(1050, 206, 1),
(950, 162, 1),
(956, 172, 1),
(968, 171, 1),
(962, 173, 1),
(974, 174, 1),
(1057, 191, 1),
(1063, 192, 1),
(1069, 193, 1),
(1096, 198, 1),
(869, 211, 4),
(874, 215, 1),
(878, 215, 4),
(980, 161, 1),
(986, 155, 1),
(997, 159, 1),
(992, 181, 1),
(1012, 185, 1),
(1083, 180, 7),
(1024, 186, 1),
(1090, 189, 7),
(1076, 179, 7),
(961, 172, 6),
(967, 173, 6),
(973, 171, 6),
(979, 174, 6),
(985, 161, 6),
(991, 155, 6),
(996, 181, 6),
(1001, 159, 6),
(1005, 184, 6),
(1075, 179, 1),
(1017, 185, 6),
(1082, 180, 1),
(1029, 186, 6),
(1089, 189, 1),
(1042, 182, 6),
(1049, 158, 6),
(1056, 206, 6),
(1062, 191, 4),
(1068, 192, 4),
(1074, 193, 4),
(1081, 179, 6),
(1088, 180, 6),
(1095, 189, 6),
(1101, 198, 4),
(1104, 218, 7),
(1105, 218, 1),
(1106, 218, 2),
(1107, 218, 3),
(1108, 218, 4),
(1114, 219, 6),
(1113, 219, 4),
(1116, 220, 7),
(1117, 220, 1),
(1118, 220, 2),
(1119, 220, 3),
(1120, 220, 5),
(1121, 220, 4),
(1122, 220, 6);

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
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_moduls`
--

INSERT INTO `cms_moduls` (`id`, `name`, `icon`, `path`, `table_name`, `controller`, `is_protected`, `is_active`, `hasImage`, `created_at`, `updated_at`, `deleted_at`, `has_page_client`, `main_field`, `lang_effected`) VALUES
(11, 'سجلات النظام', 'fa fa-flag-o', 'logs', 'cms_logs', 'LogsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(10, 'API Generator', 'fa fa-cloud-download', 'api_generator', NULL, 'ApiCustomController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(9, 'Statistic Builder', 'fa fa-dashboard', 'statistic_builder', 'cms_statistics', 'StatisticBuilderController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(8, 'Email Templates', 'fa fa-envelope-o', 'email_templates', 'cms_email_templates', 'EmailTemplatesController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(7, 'إدارة القوائم', 'fa fa-bars', 'menu_management', 'cms_menus', 'MenusController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 1, NULL, NULL),
(6, 'Module Generator', 'fa fa-database', 'module_generator', 'cms_moduls', 'ModulsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(5, 'Settings', 'fa fa-cog', 'settings', 'cms_settings', 'SettingsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(4, 'إدارة المستخدمين', 'fa fa-users', 'users', 'cms_users', 'Users\\UsersController', 0, 0, 0, '2019-05-30 04:06:58', NULL, NULL, 1, NULL, NULL),
(3, 'أدوار الصلاحيات', 'fa fa-cog', 'privileges_roles', 'cms_privileges_roles', 'PrivilegesRolesController', 1, 0, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(2, 'رخص ومزايا', 'fa fa-cog', 'privileges', 'cms_privileges', 'PrivilegesController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(1, 'Notifications', 'fa fa-cog', 'notifications', 'cms_notifications', 'NotificationsController', 1, 1, 0, '2019-05-30 04:06:58', NULL, NULL, 0, NULL, NULL),
(83, 'الزبائن', 'fa fa-glass', 'persons', 'persons', 'Accounts\\CustomersController', 0, 0, 0, '2020-03-10 18:30:11', NULL, NULL, 1, 'name_en', 'field'),
(82, 'الحسابات', 'fa fa-glass', 'accounts', 'accounts', 'Accounts\\AccountsController', 0, 0, 0, '2020-03-10 18:24:42', NULL, NULL, 1, 'name_en', 'field'),
(81, 'تصنيفات المواد', 'fa fa-tags', 'item_categories', 'item_categories', 'Items\\ItemCategoriesController', 0, 0, 0, '2020-03-10 18:13:59', NULL, NULL, 1, 'name_en', 'field'),
(80, 'المواد', 'fa fa-glass', 'items', 'items', 'Items\\ItemsController', 0, 0, 0, '2020-03-10 18:09:47', NULL, NULL, 1, 'name_en', 'record'),
(79, 'الواحدات', 'fa fa-gear', 'item_units', 'item_units', 'Items\\ItemUnitsController', 0, 0, 0, '2020-03-10 18:04:48', NULL, NULL, 1, NULL, 'field'),
(84, 'المستودعات', 'fa fa-file-o', 'inventories', 'inventories', 'Inventories\\InventoriesController', 0, 0, 0, '2020-03-11 08:25:46', NULL, NULL, 1, 'name_en', 'field'),
(85, 'العملات', 'fa fa-money', 'currencies', 'currencies', 'Currencies\\CurrenciesController', 0, 0, 0, '2020-03-11 08:43:48', NULL, NULL, 1, 'name_en', 'field'),
(93, 'فواتير المبيعات', 'fa fa-glass', 'bills_sales_invoice', 'bills', 'Bills\\BillsSalesInvoiceController', 0, 0, 0, '2020-03-16 08:04:56', NULL, NULL, 1, NULL, 'field'),
(94, 'فواتير المشتريات', 'fa fa-glass', 'bills_purchase_invoice', 'bills', 'Bills\\BillsPurchaseInvoiceController', 0, 0, 0, '2020-03-16 08:08:11', NULL, NULL, 1, NULL, 'record'),
(95, 'فواتير مردودات المشتريات', 'fa fa-glass', 'bills_purchase_return_invoice', 'bills', 'Bills\\BillsPurchaseReturnInvoiceController', 0, 0, 0, '2020-03-16 08:37:32', NULL, NULL, 1, NULL, 'record'),
(96, 'فواتير مردودات المبيعات', 'fa fa-glass', 'bills_sales_return_invoice', 'bills', 'Bills\\BillsSalesReturnInvoiceController', 0, 0, 0, '2020-03-16 08:38:49', NULL, NULL, 0, NULL, 'record'),
(120, 'الموردون', 'fa fa-glass', 'suppliers', 'persons', 'Accounts\\SuppliersController', 0, 0, 0, '2021-12-18 06:22:55', NULL, NULL, 0, NULL, 'record'),
(99, 'تقرير الحسابات', 'fa fa-glass', 'accounts_report', 'reports', 'Reports\\AccountReportController', 0, 0, 0, '2020-03-20 11:30:37', NULL, NULL, 1, NULL, 'field'),
(100, 'بضاعة أول المدة', 'fa fa-glass', 'inventory_beginning', 'item_tracking', 'Inventories\\InventoryBeginningController', 0, 0, 0, '2020-03-25 11:49:34', NULL, NULL, 1, NULL, 'record'),
(101, 'نقل مواد', 'fa fa-glass', 'transfer_items', 'item_tracking', 'Inventories\\TransferItemsController', 0, 0, 0, '2020-03-25 20:08:05', NULL, NULL, 1, NULL, 'record'),
(102, 'تقرير حركة المواد', 'fa fa-glass', 'item_movement_report', 'item_tracking', 'Reports\\ItemMovementController', 0, 0, 0, '2020-03-26 06:35:24', NULL, NULL, 1, NULL, 'record'),
(103, 'تقرير أرصدة المواد (جرد)', 'fa fa-glass', 'inventory_accounting_report', 'item_tracking', 'Reports\\InventoryAccountingController', 0, 0, 0, '2020-03-28 17:55:05', NULL, NULL, 1, NULL, 'record'),
(106, 'تقرير كشف حساب (زبون - مورد)', 'fa fa-glass', 'account_statement_report', 'entries', 'Reports\\AccountstatementController', 0, 0, 0, '2020-04-02 03:59:52', NULL, NULL, 1, NULL, 'record'),
(107, 'تقرير المندوبين', 'fa fa-glass', 'salesmen_report', 'bills', 'Reports\\SalesmenReportController', 0, 0, 0, '2020-04-02 13:46:56', NULL, NULL, 1, NULL, 'record'),
(108, 'سندات القبض', NULL, 'receipt_voucher', 'vouchers', 'Vouchers\\ReceiptVoucherController', 0, 0, 0, '2020-04-12 04:16:07', NULL, NULL, 1, NULL, 'record'),
(109, 'سندات الدفع', 'fa fa-glass', 'payment_voucher', 'vouchers', 'Vouchers\\PaymentVoucherController', 0, 0, 0, '2020-04-12 05:20:36', NULL, NULL, 1, NULL, 'record'),
(114, 'سندات التحويل', 'fa fa-glass', 'transfer_vouchers', 'vouchers', 'Vouchers\\TransferVouchersController', 0, 0, 0, '2020-06-08 08:42:29', NULL, NULL, 1, NULL, 'record'),
(115, 'سندات الأرصدة الإفتتاحية', 'fa fa-glass', 'initial_voucher', 'vouchers', 'Vouchers\\InitialVoucherController', 0, 0, 0, '2021-11-16 06:38:11', NULL, NULL, 1, NULL, 'record'),
(116, 'أنواع حسابات الإقفال', 'fa fa-glass', 'closing_accounts_types', 'closing_accounts_types', 'Accounts\\ClosingAccountsTypesController', 0, 0, 0, '2021-11-29 05:15:23', NULL, NULL, 0, NULL, 'field'),
(117, 'تقرير حسابات الإقفال', 'fa fa-glass', 'closing_accounts_report', 'reports', 'Reports\\ClosingAccountsController', 0, 0, 0, '2021-11-29 05:41:01', NULL, NULL, 1, NULL, 'field'),
(118, 'دفتر اليومية', 'fa fa-glass', 'general_entry_record_report', 'reports', 'Reports\\GeneralEntryRecordController', 0, 0, 0, '2021-12-06 12:15:51', NULL, NULL, 0, NULL, 'field'),
(119, 'تدوير الحسابات', 'fa fa-recycle', 'rotate_data', 'reports', 'Data\\RotateDataController', 0, 0, 0, '2021-12-06 16:05:39', NULL, NULL, 0, NULL, 'record'),
(121, 'سجل سعر صرف العملات', 'fa fa-glass', 'currency_history', 'currency_history', 'Currencies\\CurrencyHistoryController', 0, 0, 0, '2022-01-04 05:18:49', NULL, NULL, 0, NULL, 'record'),
(122, 'أرشيف القيود المعدلة', 'fa fa-glass', 'entries_history_report', 'reports', 'Reports\\EntriesHistoryController', 0, 0, 0, '2022-01-18 14:18:11', NULL, NULL, 0, NULL, 'record'),
(123, 'دليل استيراد البيانات', 'fa fa-book', 'import_data_guide', 'reports', 'Data\\ImportDataGuideController', 0, 0, 0, '2022-05-28 05:54:12', NULL, NULL, 0, NULL, 'record'),
(124, 'سندات اليومية', 'fa fa-glass', 'daily_voucher', 'vouchers', 'Vouchers\\DailyVoucherController', 0, 0, 0, '2022-06-18 03:03:24', NULL, NULL, 0, NULL, 'record'),
(125, 'الجولات', 'fa fa-list-ol', 'tours', 'tours', 'Tours\\ToursController', 0, 0, 0, '2022-07-02 14:37:11', NULL, NULL, 0, NULL, 'record'),
(126, 'خطوات الجولة', 'fa fa-list', 'tours_steps', 'tours_steps', 'Tours\\ToursStepsController', 0, 0, 0, '2022-07-02 15:13:16', NULL, NULL, 0, NULL, 'record'),
(127, 'عناصر الخطوات', 'fa fa-star-o', 'tours_steps_elements', 'tours_steps_elements', 'Tours\\ToursStepsElementsController', 0, 0, 0, '2022-07-02 15:28:12', NULL, NULL, 0, NULL, 'record'),
(128, 'سندات التصريف', 'fa fa-glass', 'exchange_voucher', 'vouchers', 'Vouchers\\ExchangeVoucherController', 0, 0, 0, '2022-07-19 12:47:36', NULL, NULL, 0, NULL, 'record'),
(129, 'إشعارات القبض', 'fa fa-list', 'receipt_notifications', 'vouchers', 'Notifications\\ReceiptNotificationsController', 0, 0, 0, '2022-12-04 08:47:28', NULL, NULL, 0, NULL, 'record'),
(130, 'إشعارات استلام المواد', 'fa fa-cubes', 'receipt_items_notifications', 'transfer_tracking', 'Notifications\\ReceiptItemsNotificationsController', 0, 0, 0, '2022-12-06 09:55:33', NULL, NULL, 0, NULL, 'record'),
(131, 'إدارة النسخ الإحتياطية', 'fa fa-database', 'backups_management', 'backups', 'Data\\BackupsManagementController', 0, 0, 0, '2022-12-20 12:20:40', NULL, NULL, 0, NULL, 'record'),
(132, 'إعدادات محاسبة', 'fa  fa-asterisk', 'mohasabeh_configration', 'reports', 'Configration\\MohasabehConfigrationController', 0, 0, 0, '2022-12-24 12:20:40', NULL, NULL, 0, NULL, 'record'),
(133, 'إعدادات النظام', 'fa fa-cogs', 'system_settings', 'reports', 'Configration\\SystemSettingsController', 0, 0, 0, '2023-01-08 10:20:40', NULL, NULL, 0, NULL, 'record'),
(134, 'الدورات المالية', 'fa fa-history', 'financial_cycles', 'financial_cycles', 'FinancialCycles\\FinancialCyclesController', 0, 0, 0, '2023-02-08 12:20:40', NULL, NULL, 0, NULL, 'record');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_privileges`
--

INSERT INTO `cms_privileges` (`id`, `name`, `is_superadmin`, `theme_color`, `created_at`, `updated_at`) VALUES
(1, 'الأدمن', 1, 'skin-red', '2019-05-30 03:06:58', NULL),
(2, 'مدير', 0, 'skin-green', NULL, NULL),
(3, 'مدير مبيعات', 0, 'skin-green-light', NULL, NULL),
(4, 'مندوب', 0, 'skin-green', NULL, NULL),
(5, 'مشاهدة فقط', 0, 'skin-blue', NULL, NULL),
(6, 'مندوب معمل', 0, 'skin-green-light', NULL, NULL),
(7, 'أمين صندوق المعمل', 0, 'skin-purple-light', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=857 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(88, 1, 1, 1, 1, 1, 1, 86, NULL, NULL),
(89, 1, 1, 1, 1, 1, 1, 87, NULL, NULL),
(168, 1, 1, 1, 1, 1, 1, 121, NULL, NULL),
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
(180, 1, 1, 1, 1, 1, 1, 123, NULL, NULL),
(138, 1, 1, 1, 1, 1, 1, 114, NULL, NULL),
(137, 1, 1, 1, 1, 1, 1, 113, NULL, NULL),
(801, 1, 1, 1, 1, 0, 4, 95, NULL, NULL),
(800, 1, 1, 1, 1, 0, 4, 96, NULL, NULL),
(799, 1, 1, 1, 1, 0, 4, 94, NULL, NULL),
(798, 1, 1, 1, 1, 0, 4, 93, NULL, NULL),
(127, 1, 1, 1, 1, 1, 1, 112, NULL, NULL),
(126, 1, 1, 1, 1, 1, 1, 111, NULL, NULL),
(125, 1, 1, 1, 1, 1, 1, 110, NULL, NULL),
(119, 1, 1, 1, 1, 1, 1, 109, NULL, NULL),
(118, 1, 1, 1, 1, 1, 1, 108, NULL, NULL),
(797, 1, 1, 1, 1, 0, 4, 124, NULL, NULL),
(796, 1, 1, 1, 1, 0, 4, 108, NULL, NULL),
(795, 1, 1, 1, 1, 0, 4, 109, NULL, NULL),
(794, 1, 1, 1, 1, 0, 4, 128, NULL, NULL),
(793, 1, 1, 1, 1, 1, 4, 114, NULL, NULL),
(149, 1, 1, 1, 1, 1, 1, 115, NULL, NULL),
(150, 1, 1, 1, 1, 1, 1, 116, NULL, NULL),
(151, 1, 1, 1, 1, 1, 1, 117, NULL, NULL),
(152, 1, 1, 1, 1, 1, 1, 118, NULL, NULL),
(153, 1, 1, 1, 1, 1, 1, 119, NULL, NULL),
(154, 1, 1, 1, 1, 1, 1, 120, NULL, NULL),
(792, 1, 0, 1, 0, 0, 4, 115, NULL, NULL),
(791, 1, 0, 0, 0, 0, 4, 106, NULL, NULL),
(790, 1, 0, 0, 0, 0, 4, 102, NULL, NULL),
(789, 1, 0, 0, 0, 0, 4, 99, NULL, NULL),
(788, 1, 0, 0, 0, 0, 4, 103, NULL, NULL),
(195, 1, 1, 1, 1, 1, 1, 124, NULL, NULL),
(787, 1, 0, 1, 0, 0, 4, 100, NULL, NULL),
(786, 1, 1, 1, 1, 1, 4, 79, NULL, NULL),
(785, 1, 0, 1, 1, 0, 4, 120, NULL, NULL),
(784, 1, 0, 1, 0, 0, 4, 80, NULL, NULL),
(214, 1, 1, 1, 1, 1, 1, 125, NULL, NULL),
(215, 1, 1, 1, 1, 1, 1, 126, NULL, NULL),
(216, 1, 1, 1, 1, 1, 1, 127, NULL, NULL),
(783, 1, 0, 1, 1, 0, 4, 84, NULL, NULL),
(831, 1, 0, 1, 0, 0, 5, 95, NULL, NULL),
(830, 1, 0, 1, 0, 0, 5, 96, NULL, NULL),
(829, 1, 0, 1, 0, 0, 5, 94, NULL, NULL),
(828, 1, 0, 1, 0, 0, 5, 93, NULL, NULL),
(827, 1, 0, 1, 0, 0, 5, 124, NULL, NULL),
(826, 1, 0, 1, 0, 0, 5, 108, NULL, NULL),
(825, 1, 0, 1, 0, 0, 5, 109, NULL, NULL),
(824, 1, 0, 1, 0, 0, 5, 128, NULL, NULL),
(823, 1, 0, 1, 0, 0, 5, 114, NULL, NULL),
(822, 1, 0, 1, 0, 0, 5, 115, NULL, NULL),
(821, 1, 0, 0, 0, 0, 5, 121, NULL, NULL),
(820, 1, 0, 0, 0, 0, 5, 118, NULL, NULL),
(819, 1, 0, 0, 0, 0, 5, 106, NULL, NULL),
(818, 1, 0, 0, 0, 0, 5, 102, NULL, NULL),
(817, 1, 0, 0, 0, 0, 5, 107, NULL, NULL),
(816, 1, 0, 0, 0, 0, 5, 99, NULL, NULL),
(815, 1, 0, 0, 0, 0, 5, 103, NULL, NULL),
(814, 1, 0, 1, 0, 0, 5, 81, NULL, NULL),
(813, 1, 0, 1, 0, 0, 5, 100, NULL, NULL),
(812, 1, 0, 1, 0, 0, 5, 79, NULL, NULL),
(811, 1, 0, 1, 0, 0, 5, 120, NULL, NULL),
(810, 1, 0, 1, 0, 0, 5, 80, NULL, NULL),
(809, 1, 0, 1, 0, 0, 5, 84, NULL, NULL),
(808, 1, 0, 1, 0, 0, 5, 85, NULL, NULL),
(807, 1, 0, 1, 0, 0, 5, 83, NULL, NULL),
(806, 1, 0, 1, 0, 0, 5, 134, NULL, NULL),
(805, 1, 0, 1, 0, 0, 5, 82, NULL, NULL),
(804, 1, 0, 1, 0, 0, 5, 4, NULL, NULL),
(265, 1, 1, 1, 1, 1, 1, 128, NULL, NULL),
(782, 1, 1, 1, 1, 1, 4, 83, NULL, NULL),
(781, 1, 0, 1, 0, 0, 4, 134, NULL, NULL),
(780, 1, 1, 1, 0, 0, 4, 82, NULL, NULL),
(779, 1, 0, 1, 0, 0, 4, 129, NULL, NULL),
(756, 1, 0, 1, 0, 0, 2, 96, NULL, NULL),
(755, 1, 0, 1, 0, 0, 2, 94, NULL, NULL),
(754, 1, 0, 1, 0, 0, 2, 93, NULL, NULL),
(753, 1, 1, 1, 1, 1, 2, 124, NULL, NULL),
(752, 1, 1, 1, 1, 1, 2, 108, NULL, NULL),
(751, 1, 1, 1, 1, 1, 2, 109, NULL, NULL),
(750, 1, 1, 1, 1, 1, 2, 128, NULL, NULL),
(749, 1, 1, 1, 1, 1, 2, 114, NULL, NULL),
(748, 1, 1, 1, 1, 1, 2, 115, NULL, NULL),
(747, 1, 0, 0, 0, 0, 2, 123, NULL, NULL),
(746, 1, 0, 0, 0, 0, 2, 118, NULL, NULL),
(745, 1, 0, 0, 0, 0, 2, 106, NULL, NULL),
(744, 1, 0, 0, 0, 0, 2, 102, NULL, NULL),
(743, 1, 0, 0, 0, 0, 2, 107, NULL, NULL),
(742, 1, 0, 0, 0, 0, 2, 99, NULL, NULL),
(741, 1, 0, 0, 0, 0, 2, 103, NULL, NULL),
(740, 1, 0, 1, 0, 0, 2, 81, NULL, NULL),
(739, 1, 0, 1, 0, 0, 2, 79, NULL, NULL),
(738, 1, 1, 1, 1, 1, 2, 120, NULL, NULL),
(737, 1, 0, 1, 0, 0, 2, 80, NULL, NULL),
(775, 1, 1, 1, 1, 0, 3, 96, NULL, NULL),
(774, 1, 1, 1, 1, 0, 3, 94, NULL, NULL),
(773, 1, 1, 1, 1, 0, 3, 93, NULL, NULL),
(772, 1, 1, 1, 1, 0, 3, 124, NULL, NULL),
(771, 1, 1, 1, 1, 0, 3, 108, NULL, NULL),
(770, 1, 1, 1, 1, 0, 3, 109, NULL, NULL),
(769, 1, 1, 1, 1, 0, 3, 128, NULL, NULL),
(768, 1, 1, 1, 1, 1, 3, 114, NULL, NULL),
(767, 1, 0, 0, 0, 0, 3, 106, NULL, NULL),
(766, 1, 0, 0, 0, 0, 3, 102, NULL, NULL),
(765, 1, 0, 0, 0, 0, 3, 99, NULL, NULL),
(764, 1, 0, 0, 0, 0, 3, 103, NULL, NULL),
(763, 1, 1, 1, 1, 1, 3, 120, NULL, NULL),
(762, 1, 0, 1, 0, 0, 3, 80, NULL, NULL),
(761, 1, 0, 1, 0, 0, 3, 84, NULL, NULL),
(760, 1, 1, 1, 1, 1, 3, 83, NULL, NULL),
(803, 1, 0, 0, 0, 0, 5, 122, NULL, NULL),
(759, 1, 0, 1, 0, 0, 3, 134, NULL, NULL),
(736, 1, 1, 1, 1, 1, 2, 83, NULL, NULL),
(735, 1, 0, 1, 0, 0, 2, 134, NULL, NULL),
(734, 1, 0, 1, 0, 0, 2, 82, NULL, NULL),
(733, 1, 0, 1, 0, 0, 2, 129, NULL, NULL),
(846, 1, 1, 1, 1, 0, 6, 95, NULL, NULL),
(845, 1, 1, 1, 1, 0, 6, 96, NULL, NULL),
(844, 1, 1, 1, 1, 0, 6, 94, NULL, NULL),
(843, 1, 1, 1, 1, 0, 6, 93, NULL, NULL),
(842, 1, 0, 0, 0, 0, 6, 106, NULL, NULL),
(841, 1, 0, 0, 0, 0, 6, 102, NULL, NULL),
(840, 1, 0, 0, 0, 0, 6, 99, NULL, NULL),
(839, 1, 0, 0, 0, 0, 6, 103, NULL, NULL),
(838, 1, 1, 1, 0, 0, 6, 120, NULL, NULL),
(837, 1, 0, 1, 0, 0, 6, 80, NULL, NULL),
(836, 1, 0, 1, 1, 0, 6, 84, NULL, NULL),
(835, 1, 1, 1, 0, 0, 6, 83, NULL, NULL),
(834, 1, 0, 1, 0, 0, 6, 134, NULL, NULL),
(855, 1, 1, 1, 1, 1, 7, 109, NULL, NULL),
(854, 1, 1, 1, 1, 1, 7, 114, NULL, NULL),
(853, 1, 0, 0, 0, 0, 7, 106, NULL, NULL),
(852, 1, 0, 0, 0, 0, 7, 99, NULL, NULL),
(851, 1, 0, 1, 0, 0, 7, 120, NULL, NULL),
(850, 1, 0, 1, 0, 0, 7, 83, NULL, NULL),
(849, 1, 0, 1, 0, 0, 7, 134, NULL, NULL),
(534, 1, 1, 1, 1, 1, 1, 129, NULL, NULL),
(732, 1, 0, 0, 0, 0, 2, 122, NULL, NULL),
(758, 1, 0, 1, 0, 0, 3, 129, NULL, NULL),
(778, 1, 0, 1, 0, 0, 4, 130, NULL, NULL),
(848, 1, 0, 1, 0, 0, 7, 129, NULL, NULL),
(610, 1, 1, 1, 1, 1, 1, 130, NULL, NULL),
(777, 0, 0, 0, 1, 0, 4, 4, NULL, NULL),
(833, 1, 0, 1, 0, 0, 6, 130, NULL, NULL),
(757, 1, 0, 1, 0, 0, 2, 95, NULL, NULL),
(776, 1, 1, 1, 1, 0, 3, 95, NULL, NULL),
(802, 1, 1, 1, 1, 1, 4, 101, NULL, NULL),
(832, 1, 0, 1, 0, 0, 5, 101, NULL, NULL),
(847, 1, 1, 1, 1, 1, 6, 101, NULL, NULL),
(856, 1, 1, 1, 1, 1, 7, 108, NULL, NULL);

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
(4, 'email_sender', 'Mohasabeh', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Email Sender'),
(5, 'smtp_driver', 'smtp', 'select', 'smtp,mail,sendmail', NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Mail Driver'),
(6, 'smtp_host', 'mail.mohasabeh.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Host'),
(7, 'smtp_port', '587', 'text', NULL, 'default 25', '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Port'),
(8, 'smtp_username', 'info@mohasabeh.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Username'),
(9, 'smtp_password', 'scTn7LpLHJ', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Password'),
(10, 'appname', '$$company_name$$', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Application Name'),
(11, 'default_paper_size', 'Legal', 'text', NULL, 'Paper size, ex : A4, Legal, etc', '2019-05-30 06:06:58', NULL, 'Application Setting', 'Default Paper Print Size'),
(12, 'logo', NULL, 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Logo'),
(13, 'favicon', NULL, 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Favicon'),
(14, 'api_debug_mode', 'false', 'select', 'true,false', NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'API Debug Mode'),
(15, 'google_api_key', NULL, 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Google API Key'),
(16, 'google_fcm_key', NULL, 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Google FCM Key'),
(17, 'main_website', 'https://cloudsellpos.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Main website');


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
  `last_login_date` timestamp NULL DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `customers_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `name`, `photo`, `email`, `password`, `id_cms_privileges`, `created_at`, `updated_at`, `status`, `account_id`, `customers_account_id`) VALUES
(1, 'Super Admin', '/images/portfolio1_logo.png', 'superadmin@voila.digital', '$2y$10$MyiovAMt9R8jmFl4vUUCVO2kw6.q76HWLQJvuUZ.zlZIJCzRpwvDy', 1, '2019-05-30 03:06:58', '2020-07-21 09:55:23', 'Active',  0, 0),
(2, 'Admin', '/images/portfolio1_logo.png', '$$email$$', '$$password$$', 1, '2019-05-30 03:06:58', '2020-07-21 09:55:23', 'Active',  0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_id` int(11) NOT NULL,
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

INSERT INTO `currencies` (`id`, `name_en`, `name_ar`, `code`, `account_id`, `is_major`, `note`, `ex_rate`, `icon`, `color`, `active`, `sorting`) VALUES
(1, 'S.P', 'ل.س', 'SYP', 4, 1, 'العملة الاساسية', '1.00', 'fa fa-money', 'red', 1, 1);

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
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_base_id` int(11) DEFAULT NULL,
  `debit` decimal(60,2) DEFAULT NULL,
  `credit` decimal(60,2) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '1',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `edit_at` timestamp NULL DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `action` varchar(10) DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
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
  `date` datetime DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `edit_at` timestamp NULL DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `action` varchar(10) DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `financial_cycles`
--

CREATE TABLE `financial_cycles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle_name` varchar(255) DEFAULT NULL,
  `rotate_date` date DEFAULT NULL,
  `currencies_ex_rate` varchar(255) DEFAULT NULL,
  `item_cost_type` int(11) DEFAULT NULL,
  `profits_account_id` int(11) DEFAULT NULL,
  `diff_ex_rate_account_id` int(11) DEFAULT NULL,
  `last_inventories_items_value_account_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'current',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `financial_cycles`
--

INSERT INTO `financial_cycles` (`id`, `cycle_name`, `rotate_date`, `currencies_ex_rate`, `item_cost_type`, `profits_account_id`, `diff_ex_rate_account_id`, `last_inventories_items_value_account_id`, `status`, `created_date`, `active`, `sorting`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'current', '2023-02-18 10:18:39', 0, 0);

-- --------------------------------------------------------
--
-- Table structure for table `vouchers_files`
--

DROP TABLE IF EXISTS `vouchers_files`;
CREATE TABLE IF NOT EXISTS `vouchers_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `file_id` varchar(500) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


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
-- Table structure for table `initial_vouchers_groups`
--

DROP TABLE IF EXISTS `initial_vouchers_groups`;
CREATE TABLE IF NOT EXISTS `initial_vouchers_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_number` varchar(200) DEFAULT NULL,
  `narration` longtext,
  `date` datetime NOT NULL,
  `staff_id` int(11) NOT NULL,
  `cycle_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `initial_vouchers_list`
--


DROP TABLE IF EXISTS `initial_vouchers_list`;
CREATE TABLE IF NOT EXISTS `initial_vouchers_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iv_group_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` decimal(60,2) NOT NULL,
  `p_code` varchar(50) NOT NULL,
  `cycle_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
  `major_classification` tinyint(4) DEFAULT '1',
  `note` longtext COLLATE utf8_unicode_ci,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `inventories_delegates`
--

DROP TABLE IF EXISTS `inventories_delegates`;
CREATE TABLE IF NOT EXISTS `inventories_delegates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` int(11) DEFAULT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_beginning_items_list`
--

DROP TABLE IF EXISTS `inventory_beginning_items_list`;
CREATE TABLE IF NOT EXISTS `inventory_beginning_items_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_tracking_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(50,2) NOT NULL,
  `p_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
  `active` int(11) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_beginning_tracking`
--

DROP TABLE IF EXISTS `inventory_beginning_tracking`;
CREATE TABLE IF NOT EXISTS `inventory_beginning_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_number` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `cycle_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` longtext,
  `name_ar` longtext,
  `item_number` varchar(50) DEFAULT NULL,
  `code` bigint(20) DEFAULT NULL,
  `p_code` varchar(200) DEFAULT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_unit_id` int(11) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `mix_number` varchar(50) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `visible_to_delegates` int(11) DEFAULT '1',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_tracking_types`
--

DROP TABLE IF EXISTS `item_tracking_types`;
CREATE TABLE IF NOT EXISTS `item_tracking_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `prefix` varchar(1000) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_tracking_types`
--

INSERT INTO `item_tracking_types` (`id`, `name_en`, `name_ar`, `prefix`, `active`, `sorting`) VALUES
(1, 'bill', 'فاتورة شراء', 'Bill-', 1, NULL),
(2, 'invoice', 'فاتورة مبيع', 'INV-', 1, NULL),
(3, 'Purchase return', 'مردود مشتريات', 'PR-', 1, NULL),
(4, 'Sales return', 'مردود مبيعات', 'SR-', 1, NULL),
(5, 'inventory beginning', 'بضاعة اول مدة', 'IB-', 1, NULL),
(6, 'Transfer', 'مناقلة', 'TO-', 1, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `item_tracking`
--

DROP TABLE IF EXISTS `item_tracking`;
CREATE TABLE IF NOT EXISTS `item_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` bigint(20) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_tracking_type_id` int(11) DEFAULT NULL,
  `source` int(11) DEFAULT NULL,
  `destination` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` decimal(50,2) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `note` text,
  `transaction_operation` varchar(50) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '1',
  `p_code` varchar(50) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `edit_at` timestamp NULL DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT '0',
  `action` varchar(10) DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
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
-- Table structure for table `mohasabeh_info`
--

DROP TABLE IF EXISTS `mohasabeh_info`;
CREATE TABLE IF NOT EXISTS `mohasabeh_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` text,
  `company` varchar(255) DEFAULT NULL,
  `logo` text,
  `contact_emails` text,
  `mohasabeh_phone` varchar(255) DEFAULT NULL,
  `mohasabeh_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mohasabeh_info`
--

INSERT INTO `mohasabeh_info` (`id`, `first_name`, `last_name`, `email`, `phone`, `photo`, `company`, `logo`, `contact_emails`, `mohasabeh_phone`, `mohasabeh_email`) VALUES
(1, '$$first_name$$', '$$last_name$$', '$$email$$', '$$phone$$', NULL, '$$company_name$$', NULL, '$$contact_emails$$', '$$mohasabeh_phone$$', '$$mohasabeh_email$$');
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
  `clients_num` int(11) NOT NULL DEFAULT '1',
  `backups_size` int(50) NOT NULL,
  `attachs_size` int(50) NOT NULL,
  `free_trial_start_date` date DEFAULT NULL,
  `free_trial_end_date` date DEFAULT NULL,
  `subscription_start_date` date DEFAULT NULL,
  `subscription_end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_config`
--

INSERT INTO `package_config` (`id`, `package_id`, `users_num`, `inventories_num`, `currencies_num`, `clients_num`, `backups_size`, `attachs_size`,`free_trial_start_date`,`free_trial_end_date`,`subscription_start_date`,`subscription_end_date`) VALUES
(1, $$package_id$$, $$users_num$$, $$inventories_num$$, $$currencies_num$$, $$clients_num$$, $$backups_size$$, $$attachs_size$$,'$$free_trial_start_date$$','$$free_trial_end_date$$','$$subscription_start_date$$','$$subscription_end_date$$');

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
-- Table structure for table `recalculate_cycle_history`
--

CREATE TABLE `recalculate_cycle_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle_id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `options` varchar(255) NOT NULL,
  `upgrade_cycle_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
  `cycle_id` int(11) NOT NULL,
  `rotate_date` date DEFAULT NULL,
  `net_profit` double DEFAULT NULL,
  `gross_profit` double DEFAULT NULL,
  `sales` double DEFAULT NULL,
  `purchases` double DEFAULT NULL,
  `sales_return` double DEFAULT NULL,
  `purchases_return` double DEFAULT NULL,
  `earned_discount` double DEFAULT NULL,
  `granted_discount` double DEFAULT NULL,
  `last_inventories_items_value` double DEFAULT NULL,
  `begin_inventories_items_value` double DEFAULT NULL,
  `incomes` double DEFAULT NULL,
  `outgoings` double DEFAULT NULL,
  `ex_rate_difference_value` double DEFAULT NULL,
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
-- Table structure for table `suppliers_delegates`
--

DROP TABLE IF EXISTS `suppliers_delegates`;
CREATE TABLE `suppliers_delegates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 'Main_Accounts_ids', '2,3,5,6,11,12,13,14,15,16,17'),
(13, 'General_Box', '4');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'system_stop', 'off'),
(2, 'image_max_size', '5'),
(3, 'image_types', 'png,jpg,jpeg'),
(4, 'image_quality', '100'),
(5, 'negative_bills', 'off'),
(6, 'old_cycle_edited', 'false'),
(7, 'old_cycle_edited_id', ''),
(8, 'lock_system_url', 'off'),
(9, 'unlock_system_url_token', ''),
(10, 'https_option', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
CREATE TABLE IF NOT EXISTS `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `page_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `module_id`, `page_type`, `active`, `sorting`) VALUES
(1, 'جولة ضمن صفحة شجرة الحسابات', 82, 'getIndex', 1, NULL),
(2, 'جولة ضمن صفحة إضافة حساب', 82, 'getAdd', 1, NULL),
(3, 'جولة ضمن صفحة تعديل حساب', 82, 'getEdit', 1, NULL),
(4, 'جولة ضمن تفصيل الحساب', 82, 'getDetail', 1, NULL),
(5, 'جولة ضمن صفحة عرض فواتير المشتريات', 94, 'getIndex', 1, NULL),
(6, 'جولة ضمن صفحة إضافة فاتورة شراء', 94, 'getAdd', 1, NULL),
(7, 'جولة ضمن صفحة تعديل فاتورة شراء', 94, 'getEdit', 1, NULL),
(9, 'جولة ضمن تقرير الحسابات', 99, 'getIndex', 1, NULL),
(10, 'جولة ضمن صفحة الإعدادات الخاص بالأدمن', NULL, 'getAdminStatisticsSetting', 1, NULL),
(11, 'جولة ضمن صفحة استيراد البيانات', NULL, 'importDataForm', 1, NULL),
(12, 'جولة ضمن الصفحة الرئيسية DashBoard', NULL, 'getAdminStatistics', 1, NULL),
(13, 'جولة ضمن فواتير مردود المشتريات', 95, 'getIndex', 1, NULL),
(14, 'جولة ضمن صفحة إضافة فاتورة مردود شراء', 95, 'getAdd', 1, NULL),
(15, 'جولة ضمن صفحة تعديل فاتورة مردود شراء', 95, 'getEdit', 1, NULL),
(16, 'جولة ضمن فواتير المبيعات', 93, 'getIndex', 1, NULL),
(17, 'جولة ضمن صفحة إضافة فاتورة مبيع', 93, 'getAdd', 1, NULL),
(19, 'جولة ضمن صفحة تعديل فاتورة مبيع', 93, 'getEdit', 1, NULL),
(20, 'جولة ضمن فواتير مردود المبيعات', 96, 'getIndex', 1, NULL),
(21, 'جولة ضمن صفحة إضافة فاتورة مردود مبيعات', 96, 'getAdd', 1, NULL),
(22, 'جولة ضمن صفحة تعديل فاتورة مردود المبيعات', 96, 'getEdit', 1, NULL),
(23, 'جولة ضمن موديول الزبائن', 83, 'getIndex', 1, NULL),
(24, 'جولة ضمن صفحة إضافة زبون', 83, 'getAdd', 1, NULL),
(25, 'جولة ضمن صفحة تعديل الزبون', 83, 'getEdit', 1, NULL),
(26, 'جولة ضمن موديول الموردون', 120, 'getIndex', 1, NULL),
(27, 'جولة ضمن صفحة إضافة مورد', 120, 'getAdd', 1, NULL),
(28, 'جولة ضمن صفحة تعديل مورد', 120, 'getEdit', 1, NULL),
(29, 'جولة ضمن موديول المواد', 80, 'getIndex', 1, NULL),
(30, 'جولة ضمن صفحة إضافة مادة', 80, 'getAdd', 1, NULL),
(31, 'جولة ضمن صفحة تعديل المادة', 80, 'getEdit', 1, NULL),
(32, 'جولة ضمن صفحة شجرة التصنيفات', 81, 'getIndex', 1, NULL),
(33, 'جولة بصفحة إضافة تصنيف للمواد', 81, 'getAdd', 1, NULL),
(34, 'جولة ضمن صفحة تعديل تصنيف المادة', 81, 'getEdit', 1, NULL),
(35, 'جولة بصفحة عرض سندات القبض', 108, 'getIndex', 1, NULL),
(36, 'جولة بصفحة إضافة سند قبض', 108, 'getAdd', 1, NULL),
(37, 'جولة ضمن صفحة تعديل سند القبض', 108, 'getEdit', 1, NULL),
(38, 'جولة ضمن صفحة عرض سندات الدفع', 109, 'getIndex', 1, NULL),
(39, 'جولة ضمن صفحة إضافة سند دفع', 109, 'getAdd', 1, NULL),
(40, 'جولة بصفحة تعديل سند الدفع', 109, 'getEdit', 1, NULL),
(41, 'جولة ضمن صفحة عرض سندات التحويل', 114, 'getIndex', 1, NULL),
(42, 'جولة ضمن صفحة إضافة سند تحويل', 114, 'getAdd', 1, NULL),
(43, 'جولة ضمن صفحة تعديل سند التحويل', 114, 'getEdit', 1, NULL),
(44, 'جولة ضمن صفحة عرض السندات اليومية', 124, 'getIndex', 1, NULL),
(45, 'جولة ضمن صفحة إضافة سند اليومية', 124, 'getAdd', 1, NULL),
(46, 'جولة ضمن صفحة تعديل سند اليومية', 124, 'getEdit', 1, NULL),
(47, 'جولة ضمن صفحة عرض سندات التصريف', 128, 'getIndex', 1, NULL),
(48, 'جولة ضمن صفحة إضافة سند تصريف', 128, 'getAdd', 1, NULL),
(49, 'جولة ضمن صفحة تعديل سند التصريف', 128, 'getEdit', 1, NULL),
(50, 'جولة ضمن صفحة عرض سندات الأرصدة الافتتاحية', 115, 'getIndex', 1, NULL),
(51, 'جولة ضمن صفحة إضافة سند افتتاحي', 115, 'getAdd', 1, NULL),
(52, 'جولة ضمن صفحة تعديل سند افتتاحي', 115, 'getEdit', 1, NULL),
(53, 'جولة ضمن صفحة عرض إشعارات القبض', 129, 'getIndex', 1, NULL),
(54, 'جولة ضمن صفحة تفصيل إشعار القبض', 129, 'getDetail', 1, NULL),
(55, 'جولة ضمن صفحة عرض المستودعات', 84, 'getIndex', 1, NULL),
(56, 'جولة ضمن صفحة إضافة مستودع', 84, 'getAdd', 1, NULL),
(57, 'جولة ضمن صفحة تعديل المستودع', 84, 'getEdit', 1, NULL),
(58, 'جولة ضمن صفحة عرض بضاعة أول المدة', 100, 'getIndex', 1, NULL),
(59, 'جولة ضمن صفحة إضافة بضاعة أول المدة', 100, 'getAdd', 1, NULL),
(60, 'جولة ضمن صفحة تعديل بضاعة أول المدة', 100, 'getEdit', 1, NULL),
(61, 'جولة ضمن صفحة عرض عمليات نقل المواد', 101, 'getIndex', 1, NULL),
(62, 'جولة ضمن صفحة إضافة عملية نقل مواد', 101, 'getAdd', 1, NULL),
(63, 'جولة ضمن صفحة تعديل عملية نقل مواد', 101, 'getEdit', 1, NULL),
(64, 'جولة ضمن صفحة عرض العملات', 85, 'getIndex', 1, NULL),
(65, 'جولة ضمن صفحة إضافة عملة', 85, 'getAdd', 1, NULL),
(66, 'جولة ضمن صفحة تعديل العملة', 85, 'getEdit', 1, NULL),
(67, 'جولة ضمن تقرير كشف حساب (زبون ، مورد)', 106, 'getIndex', 1, NULL),
(68, 'جولة ضمن تقرير حركة المادة', 102, 'getIndex', 1, NULL),
(69, 'جولة ضمن تقرير أرصدة المواد (الجرد)', 103, 'getIndex', 1, NULL),
(70, 'جولة ضمن تقرير المندوبين', 107, 'getIndex', 1, NULL),
(71, 'جولة ضمن دفتر اليومية', 118, 'getIndex', 1, NULL),
(72, 'جولة ضمن ارشيف القيود المعدلة', 122, 'getIndex', 1, NULL),
(73, 'جولة ضمن موديول الدورات المالية', 134, 'getIndex', 1, NULL),
(74, 'جولة ضمن صفحة إدارة المستخدمين', 4, 'getIndex', 1, NULL),
(75, 'جولة ضمن صفحة إضافة مستخدم جديد', 4, 'getAdd', 1, NULL),
(76, 'جولة ضمن صفحة تعديل معلومات المستخدم', 4, 'getEdit', 1, NULL),
(77, 'جولة ضمن صفحة عرض النسخ الاحتياطية', 131, 'getIndex', 1, NULL),
(78, 'جولة ضمن صفحة إنشاء نسخة احتياطية', 131, 'createBackup', 1, NULL),
(79, 'جولة ضمن صفحة إعدادات محاسبة', 132, 'getIndex', 1, NULL),
(80, 'جولة ضمن صفحة عرض إشعارات استلام المواد', 130, 'getIndex', 1, NULL),
(81, 'جولة ضمن صفحة تفصيل إشعار استلام المواد', 130, 'getDetail', 1, NULL),
(82, 'جولة ضمن الصفحة الرئيسية للمندوب', NULL, 'getSalesmenStatistics', 1, NULL),
(83, 'جولة ضمن الصفحة الرئيسية للمدير', NULL, 'getManagerStatistics', 1, NULL),
(84, 'جولة ضمن صفحة الرئيسية لمدير المبيعات', NULL, 'getSalesManagerStatistics', 1, NULL),
(85, 'جولة ضمن صفحة الرئيسية لمندوب المعمل', NULL, 'getFactoryDelegateStatistics', 1, NULL),
(86, 'جولة ضمن الصفحة الرئيسية لأمين صندوق المعمل', NULL, 'getFactoryCashierStatistics', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours_steps`
--

DROP TABLE IF EXISTS `tours_steps`;
CREATE TABLE IF NOT EXISTS `tours_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tour_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `element_id` int(11) NOT NULL,
  `element_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=881 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours_steps`
--

INSERT INTO `tours_steps` (`id`, `tour_id`, `title`, `description`, `element_id`, `element_key`, `active`, `sorting`) VALUES
(1, 1, 'رسالة تنبيه', 'أقرأ رسالة التنبيه بدقة ستساعدك بفهم ألية عمل النظام', 1, '', 1, 1),
(2, 1, 'إضافة حساب جديد', 'يمكنك إضافة حساب جديد من هنا. حيث تقوم بملأ البطاقة واختيار الحساب الأب الذي سيندرج تحته الحساب الجديد', 2, '', 1, 2),
(3, 1, 'أزرار إدارة العناصر', 'يمكنك استخدام  هذه الأزرار لإدارة العناصر من مشاهدة أو تعديل أو حذف', 3, '', 1, 3),
(4, 1, 'مشاهدة الأبناء', 'لمشاهدة أبناء حساب معين يمكنك استخدام هذه الزر', 4, '', 1, 4),
(5, 2, 'املأ حقول البطاقة', 'أملأ  حقول بطاقة الحساب مع الانتباه إلى أن * تدل على أن الحقل إجباري', 5, '', 1, 1),
(6, 2, 'حفظ البطاقة', 'بعد ملأ معلومات البطاقة يمكنك حفظها من هنا', 6, '', 1, 2),
(7, 2, 'الرجوع بدون حفظ البطاقة', 'إن اردت عدم حفظ البطاقة إضغط على زر للخلف', 7, '', 1, 3),
(8, 2, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة البطاقة ومن ثم فتح بطاقة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, 4),
(9, 2, 'للعودة إلى صفحة عرض العناصر', 'للعودة لصفحة عرض العناصر من هنا يمكنك القيام بذلك', 9, '', 1, 5),
(11, 3, 'تعديل بطاقة الحساب', 'قم بتعديل الحقول التي تريد تعديلها', 5, '', 1, NULL),
(12, 3, 'حفظ التعديل', 'لحفظ التعديل على بطاقة الحساب أضغط على هذا الزر', 6, '', 1, NULL),
(13, 3, 'تجاهل التعديل', 'يمكنك تجاهل التعديل والتراجع من خلال الضغط على هذا الزر', 7, '', 1, NULL),
(14, 4, 'مشاهدت معلومات الحساب', 'يمكنك مشاهدة معلومات الحساب جميعها من هذه الصفحة', 0, '', 1, NULL),
(15, 4, 'رجوع إلى شجرة الحسابات', 'يمكنك الرجوع إلى شجرة الحسابات من هنا', 9, '', 1, NULL),
(16, 5, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول فواتير المشتريات. ونوضح لك آلية العمل ضمن هذا الموديول.\r\nكن مستعداً', 0, '', 1, 2),
(17, 5, 'إضافة فاتورة شراء', 'يمكنك إضافة فاتورة شراء من هنا عندما يكون لديك مورد واحد على الأقل. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 3),
(18, 5, 'أزرار إدارة الفواتير', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الفاتورة من هنا.', 3, '', 1, 4),
(19, 5, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الفواتير والبحث ضمنها.', 10, '', 1, 5),
(20, 5, 'البحث باستخدام الكلمات', 'يمكنك البحث عن فاتورة معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الفواتير', 12, '', 1, 6),
(21, 5, 'تغيير عدد الفواتير التي تظهر بالصفحات', 'يمكنك التحكم بعدد الفواتير التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(22, 5, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, 8),
(23, 5, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض فواتير الشراء.', 0, '', 1, 9),
(24, 6, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة فاتورة شراء', 0, '', 1, 1),
(25, 6, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-bill_number', 1, 2),
(26, 6, 'إدخال المورد', 'يجب إختيار المورد المراد الشراء منه. وإن كانت الفاتورة مع مورد ليس له حساب ضمن النظام فلا يجب اختيار المورد. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة شراء أجل من مورد ليس له حساب ضمن النظام.', 0, '#form-group-credit', 1, 3),
(27, 6, 'اختيار المستودع', 'اختيار المستودع الذي ستدخل البضاعة المشتراة ضمن الفاتورة ضمنه أمر ضروري.', 0, '#form-group-inventory_id', 1, 4),
(28, 6, 'اختيار العملة', 'يمكنك اختيار العملة التي سيتم التعامل بها. بشكل افتراضي يتم تحديد العملة الاساسية للنظام ولكن يمكنك أختيار أي عملة أخرى ضمن النظام.', 0, '#form-group-currency_id', 1, 5),
(29, 6, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 0, '#form-group-ex_rate', 1, 6),
(194, 6, 'حالة الفاتورة', 'يمكن اختيار حالة الفاتورة (منفذة أو مسودة) من هنا. في حال اختيار الحالة مسودة يتم تعليق الفاتورة ولا يتم تفعيلها إلا بعد تعديل الحالة إلى منفذة من استمارة تعديل الفاتورة', 24, '', 1, 16),
(30, 6, 'طريقة الدفع', 'يمكنك اختيار طريقة الدفع كاش ام أجل. علما أنه يجب اختيار المورد إن كان الدفع أجل لكي يتم احتساب قيمة الفاتورة لصالح حساب المورد المختار.', 0, '#form-group-is_cash', 1, 7),
(31, 6, 'إضافة مواد للفاتورة', 'يمكنك إضافة مواد للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد شراءه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 0, '.child-form-area', 1, 8),
(32, 6, 'إضافة  المادة إلى سلة المشتريات', 'يمكنك إضافة المادة لسلة المشتريات من هنا', 17, '', 1, 10),
(33, 6, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 9),
(34, 6, 'سلة المشتريات', 'يمكنك إدارة المواد المختارة ضمن فاتورة الشراء. تمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفواتير.', 19, '', 1, 11),
(37, 6, 'اجمالي الفاتورة', 'بعد الانتهاء من جميع عملية اختيار المواد وإدخال المعلومات الأساسية يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 13),
(36, 6, 'إضافة مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 12),
(38, 6, 'الحسم', 'يمكنك وضع قيمة الحسم على فاتورة الشراء من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 14),
(39, 6, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 15),
(40, 6, 'إضافة الفاتورة', 'بعد اتمام ادخال جميع معلومات الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 17),
(41, 6, 'تراجع', 'يمكن التراجع عن إضافة الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 18),
(42, 6, 'حفظ وإضافة المزيد', 'يمكن حفظ الفاتورة وفتح إضافة فاتورة فورا بدون الرجوع لصفحة عرض الفواتير من خلال الضغط على هذا الزر', 8, '', 1, 19),
(43, 6, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 20),
(44, 7, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل فاتورة شراء', 0, '', 1, 1),
(45, 7, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-bill_number', 1, 2),
(46, 7, 'تعديل المورد', 'يمكن تعديل المورد المراد الشراء منه. وإن كانت الفاتورة مع مورد ليس له حساب ضمن النظام فلا يجب اختيار المورد. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة شراء أجل من مورد ليس له حساب ضمن النظام.', 0, '#form-group-credit', 1, 3),
(47, 7, 'تعديل المستودع', 'تعديل المستودع الذي ستدخل البضاعة المشتراة ضمن الفاتورة ضمنه.', 0, '#form-group-inventory_id', 1, 4),
(48, 7, 'تعديل العملة', 'يمكنك تعديل العملة التي سيتم التعامل بها. ولكن يجب الانتباه في حال غيرت عملة الفاتورة يجب تغيير أسعار المواد المختارة للتوافق مع العملة الجديدة للفاتورة', 0, '#form-group-currency_id', 1, 5),
(49, 7, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 0, '#form-group-ex_rate', 1, 6),
(195, 7, 'حالة الفاتورة', 'يمكن تعديل حالة الفاتورة من هنا.', 24, '', 1, 17),
(50, 7, 'طريقة الدفع', 'يمكنك تعديل طريقة الدفع كاش ام أجل. علما أنه يجب اختيار المورد إن كان الدفع أجل لكي يتم احتساب قيمة الفاتورة لصالح حساب المورد المختار.', 0, '#form-group-is_cash', 1, 7),
(51, 7, 'إضافة مواد جديدة للفاتورة', 'يمكنك إضافة مواد جديدة للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد شراءه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 0, '.child-form-area', 1, 8),
(52, 7, 'إضافة  المادة إلى سلة المشتريات', 'يمكنك إضافة المادة لسلة المشتريات من هنا', 17, '', 1, 10),
(53, 7, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 9),
(54, 7, 'سلة المشتريات', 'يمكنك إدارة المواد المختارة ضمن فاتورة الشراء. تمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفواتير.', 19, '', 1, 11),
(55, 7, 'اجمالي الفاتورة', 'بعد الانتهاء من جميع عملية التعديل . يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 14),
(56, 7, 'تعديل مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 12),
(57, 7, 'الحسم', 'يمكنك تعديل قيمة الحسم على فاتورة الشراء من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 15),
(58, 7, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 16),
(59, 7, 'تعديل الفاتورة', 'بعد اتمام تعديل الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 18),
(60, 7, 'تراجع', 'يمكن التراجع  عن تعديل الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 19),
(63, 9, 'البداية', 'هذا التقرير يسمح لك بمراقبة جميع الحسابات الخاصة بك زبائن، موردون، ... الخ. حيث يقوم بعرض تفصيلي لجميع العمليات التي قام بها الحساب سواء فواتير أو سندات ويعرض الرصيد النهائي. حيث يمكنك عرض التقرير شامل لجميع العملات. ويمكنك اختيار عملة معينة لعرض التقرير الخاص بها', 0, '', 1, 2),
(62, 7, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 20),
(65, 9, 'اختيار الحساب', 'يجب اختيار الحساب أولا لعرض التقرير الخاص به. فبعد اختيارك للحساب أضغط على زر عرض.', 0, '#report-filter-account', 1, 3),
(66, 9, 'اختيار العملة', 'يمكنك اختيار العملة لعرض التقرير الخاص بالحساب وفقا للعملة المختارة وإن لم يتم اختيارها يقوم بعرض تقرير تفصيلي بجميع عملات النظام', 0, '#report-filter-currency', 1, 4),
(68, 9, 'عرض', 'بعد اختيارك للحساب و العملة يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 5),
(70, 9, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 6),
(72, 9, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 7),
(73, 9, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 8),
(74, 9, 'النهاية', 'بعد اختيارك للحساب والضغط على زر عرض. يظهر التقرير  النتائج النهائية لرصيد الحساب أسفل الصفحة. لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 9),
(75, 10, 'البداية', 'يوفر النظام مجموعة من الإعدادات التي تسمح للأدمن بالتحكم بالحسابات التي تظهر على الصفحة الرئيسية. حيث تمكنه من مراقبة مجموعة من الحسابات بشكل يومي. وتمكنه من تغيير الشكل التي تظهر فيه أرصدة الحسابات.', 0, '', 1, NULL),
(76, 10, 'اختيار طريقة عرض الحسابات', 'يمكنك اختيار أحد طرق عرض الحسابات على الصفحة الرئيسية على شكل صناديق أو بشكل جداول', 0, '#form-setting-show-method', 1, NULL),
(77, 10, 'اختيار الحسابات', 'يسمح النظام بإختيار الحسابات التي تظهر على الصفحة الرئيسية. بحيث توفر إمكانية مراقبة عدد من الحسابات بشكل يومي من قبل الأدمن.', 0, '#form-setting-accounts', 1, NULL),
(78, 10, 'حفظ التعديلات', 'لحفظ التعديلات يجب أن تقوم بالضغط على هذا الزر ثم الضغط على زر رجوع للعودة للصفحة الرئيسية', 0, '#edit-setting', 1, NULL),
(79, 10, 'رجوع', 'يمكنك الرجوع للصفحة الرئيسية من هنا . مع الانتباه أن يجب القيام بالضغط على حفظ التعديلات في حال أردت تعديلها قبل الرجوع للصفحة الرئيسية', 0, '#go-back', 1, NULL),
(80, 10, 'النهاية', 'بذلك نكون قد وصلنا لنهاية الجولة ضمن صفحة الإعدادات.', 0, '', 1, NULL),
(81, 11, 'البداية', 'أداة استيراد البيانات توفر إمكانية استيراد مجموعة من العناصر دفعة واحدة. بحيث توفر الوقت والجهد.', 0, '', 1, NULL),
(82, 11, 'التعليمات', 'يجب قراءة هذه التعليمات بدقة. قبل القيام بعملية الاستراد لأنها ستسهل عليك العملية كثيرا. وتوفر ضمن التعليمات مجموعة من الملفات التي يجب الاعتماد عليها ببناء النماذج الموافقة لعمل هذه الآلية بشل الأمثل.', 0, '#info-message', 1, NULL),
(83, 11, 'اختيار الملف الحاوي على البيانات', 'يجب الانتباه أن الملف الذي يجب أختياره يجب أن يكون مطابق لبنية ملف النموذج. ولمنع أي إشكالية يفضل تنزيل النموزج ومن ثم ملأه بالبيانات التي يراد استيرادها.', 0, '#upload-file-sect', 1, NULL),
(84, 11, 'اختيار طريقة التعامل مع البيانات المتشابها', 'يوفر النظام طريقتين للتعامل مع البيانات المتشابها. وهي إم التجاهل أو الاستبدال لمنع عملية تضارب البيانات أو تكرارها.', 0, '#process_method-sect', 1, NULL),
(85, 11, 'بدأ الاستيراد', 'لبدأ عملية الاستيراد يجب الضغط على هذه الزر.', 0, '#submit-btn', 1, NULL),
(86, 11, 'رجوع', 'إن قررت عدم الاستمرار بالعملية الاستيراد إضغط على زر رجوع.', 0, '#go-back', 1, NULL),
(87, 11, 'النهاية', 'بعد الضغط على زر استيراد سيقوم النظام بطلب تأكيد للأستمرار. وفي حال الموافقة يقوم النظام بالاستيراد البيانات وعرض تقرير بنتيجة الاستيراد.', 0, '', 1, NULL),
(88, 12, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(89, 12, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(90, 12, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(91, 12, 'متابعة الحسابات', 'يمكنك متابعة حسابات الصناديق من الصفحة الرئيسية للموقع. بالإضافة يمكنك اختيار مجموعة من الحسابات الأخرى لتظهر هنا لمتابعتها بشكل يومي.', 0, '#accounts-sect', 1, NULL),
(92, 12, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(93, 12, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(94, 12, 'الإعدادات', 'يمكنك التحكم بالحسابات التي تظهر على الصفحة الرئيسية و طريقة عرضها.', 0, '#btn-settings', 1, NULL),
(95, 12, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL),
(96, 13, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول فواتير مردود المشتريات. ونوضح لك آلية العمل ضمن هذا الموديول.\r\nكن مستعداً', 0, '', 1, NULL),
(97, 13, 'إضافة فاتورة مردود شراء', 'يمكنك إضافة فاتورة  مردود شراء من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(98, 13, 'أزرار إدارة الفواتير', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الفاتورة.', 3, '', 1, NULL),
(99, 13, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الفواتير والبحث ضمنها.', 10, '', 1, NULL),
(100, 13, 'البحث باستخدام الكلمات', 'يمكنك البحث عن فاتورة معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الفواتير', 12, '', 1, NULL),
(101, 13, 'تغيير عدد الفواتير التي تظهر بالصفحات', 'يمكنك التحكم بعدد الفواتير التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(102, 13, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(103, 13, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض فواتير مردودات المشتريات.', 0, '', 1, NULL),
(104, 14, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة فاتورة مردود شراء', 0, '', 1, 1),
(105, 14, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-bill_number', 1, 2),
(106, 14, 'إدخال المورد', 'يجب إختيار المورد المراد الشراء منه. وإن كانت الفاتورة مع مورد ليس له حساب ضمن النظام فلا يجب اختيار المورد. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مردود شراء أجل مع مورد ليس له حساب ضمن النظام.', 0, '#form-group-debit', 1, 3),
(107, 14, 'اختيار المستودع', 'اختيار المستودع الذي ستخرج البضاعة المردودة ضمن الفاتورة منه أمر ضروري.', 0, '#form-group-inventory_id', 1, 4),
(108, 14, 'اختيار العملة', 'يمكنك اختيار العملة التي سيتم التعامل بها. بشكل افتراضي يتم تحديد العملة الاساسية للنظام ولكن يمكنك أختيار أي عملة أخرى ضمن النظام.', 0, '#form-group-currency_id', 1, 5),
(109, 14, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 0, '#form-group-ex_rate', 1, 6),
(197, 14, 'حالة الفاتورة', 'يمكن اختيار حالة الفاتورة (منفذة أو مسودة) من هنا. في حال اختيار الحالة مسودة يتم تعليق الفاتورة ولا يتم تفعيلها إلا بعد تعديل الحالة إلى منفذة من استمارة تعديل الفاتورة', 24, '', 1, 16),
(110, 14, 'طريقة الدفع', 'يمكنك اختيار طريقة الدفع كاش ام أجل. علما أنه يجب اختيار المورد إن كان الدفع أجل لكي يتم احتساب قيمة الفاتورة من حساب المورد المختار.', 0, '#form-group-is_cash', 1, 7),
(111, 14, 'إضافة مواد للفاتورة', 'يمكنك إضافة مواد للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد أرجاعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 0, '.child-form-area', 1, 8),
(112, 14, 'إضافة  المادة إلى سلة المردودات', 'يمكنك إضافة المادة لسلة المردودات من هنا', 17, '', 1, 10),
(113, 14, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 9),
(114, 14, 'سلة االمردودات', 'يمكنك إدارة المواد المختارة ضمن فاتورة مردود شراء. يمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, 11),
(115, 14, 'اجمالي الفاتورة', 'بعد الانتهاء من عملية اختيار المواد وإدخال المعلومات الأساسية يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 13),
(116, 14, 'إضافة مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 12),
(117, 14, 'الحسم', 'يمكنك وضع قيمة الحسم على فاتورة مردود شراء من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 14),
(118, 14, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 15),
(119, 14, 'إضافة الفاتورة', 'بعد اتمام ادخال جميع معلومات الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 17),
(120, 14, 'تراجع', 'يمكن التراجع عن إضافة الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 18),
(121, 14, 'حفظ وإضافة المزيد', 'يمكن حفظ الفاتورة وفتح إضافة فاتورة فورا بدون الرجوع لصفحة عرض الفواتير من خلال الضغط على هذا الزر', 8, '', 1, 19),
(122, 14, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 20),
(123, 15, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل فاتورة مردود شراء', 0, '', 1, 1),
(124, 15, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-bill_number', 1, 2),
(125, 15, 'تعديل المورد', 'يمكن تعديل المورد المراد ارجاع البضاعة إليه. وإن كانت الفاتورة مع مورد ليس له حساب ضمن النظام فلا يجب اختيار المورد. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مردود شراء أجل من مورد ليس له حساب ضمن النظام.', 0, '#form-group-debit', 1, 3),
(126, 15, 'تعديل المستودع', 'تعديل المستودع الذي ستخرج  منه البضاعة المحددة ضمن الفاتورة.', 0, '#form-group-inventory_id', 1, 4),
(127, 15, 'تعديل العملة', 'يمكنك تعديل العملة التي سيتم التعامل بها. ولكن يجب الانتباه في حال غيرت عملة الفاتورة يجب تغيير أسعار المواد المختارة للتوافق مع العملة الجديدة للفاتورة', 0, '#form-group-currency_id', 1, 5),
(128, 15, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 0, '#form-group-ex_rate', 1, 6),
(198, 15, 'حالة الفاتورة', 'يمكن تعديل حالة الفاتورة من هنا', 24, '', 1, 17),
(129, 15, 'طريقة الدفع', 'يمكنك تعديل طريقة الدفع كاش ام أجل. علما أنه يجب اختيار المورد إن كان الدفع أجل لكي يتم احتساب قيمة الفاتورة من حساب المورد المختار.', 0, '#form-group-is_cash', 1, 7),
(130, 15, 'إضافة مواد جديدة للفاتورة', 'يمكنك إضافة مواد جديدة للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد ارجاعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 0, '.child-form-area', 1, 8),
(131, 15, 'إضافة  المادة إلى سلة المردودات', 'يمكنك إضافة المادة لسلة المردودات من هنا', 17, '', 1, 10),
(132, 15, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 9),
(133, 15, 'سلة المردودات', 'يمكنك إدارة المواد المختارة ضمن فاتورة مردود شراء. تمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, 11),
(134, 15, 'اجمالي الفاتورة', 'بعد الانتهاء من جميع عملية التعديل . يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 14),
(135, 15, 'تعديل مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 12),
(136, 15, 'الحسم', 'يمكنك تعديل قيمة الحسم على فاتورة مردود شراء من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 15),
(137, 15, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 16),
(138, 15, 'تعديل الفاتورة', 'بعد اتمام تعديل الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 18),
(139, 15, 'تراجع', 'يمكن التراجع  عن تعديل الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 19),
(140, 15, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 20),
(174, 17, 'إضافة مواد للفاتورة', 'يمكنك إضافة مواد للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد بيعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 0, '.child-form-area', 1, 8),
(172, 17, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 0, '#form-group-ex_rate', 1, 6),
(200, 17, 'حالة الفاتورة', 'يمكن اختيار حالة الفاتورة (منفذة أو مسودة) من هنا. في حال اختيار الحالة مسودة يتم تعليق الفاتورة ولا يتم تفعيلها إلا بعد تعديل الحالة إلى منفذة من استمارة تعديل الفاتورة', 24, '', 1, 16),
(173, 17, 'طريقة الدفع', 'يمكنك اختيار طريقة الدفع كاش ام أجل. علما أنه يجب اختيار الزبون إن كان الدفع أجل لكي يتم احتساب قيمة الفاتورة من حساب الزبون المختار.', 0, '#form-group-is_cash', 1, 7),
(171, 17, 'اختيار العملة', 'يمكنك اختيار العملة التي سيتم التعامل بها. بشكل افتراضي يتم تحديد العملة الاساسية للنظام ولكن يمكنك اختيار أي عملة أخرى ضمن النظام.', 0, '#form-group-currency_id', 1, 5),
(170, 17, 'اختيار المستودع', 'اختيار المستودع الذي ستخرج منه البضاعة المباعة ضمن الفاتورة أمر ضروري.', 0, '#form-group-inventory_id', 1, 4),
(168, 17, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-bill_number', 1, 2),
(169, 17, 'اختيار الزبون', 'يجب إختيار الزبون المراد بيعه. وإن كانت الفاتورة مع زبون ليس له حساب ضمن النظام فلا يجب اختيار الزبون. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مبيع أجل مع زبون ليس له حساب ضمن النظام.', 0, '#form-group-debit', 1, 3),
(166, 16, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض فواتير المبيعات.', 0, '', 1, 8),
(165, 16, 'الأجراء الجماعي', 'يمكنك تنفيذ بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, 7),
(164, 16, 'تغيير عدد الفواتير التي تظهر بالصفحات', 'يمكنك التحكم بعدد الفواتير التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 6),
(163, 16, 'البحث باستخدام الكلمات', 'يمكنك البحث عن فاتورة معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الفواتير', 12, '', 1, 5),
(162, 16, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الفواتير والبحث ضمنها.', 10, '', 1, 4),
(167, 17, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة فاتورة مبيع', 0, '', 1, 1),
(161, 16, 'أزرار إدارة الفواتير', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الفاتورة.', 3, '', 1, 3),
(160, 16, 'إضافة فاتورة مبيع', 'يمكنك إضافة فاتورة مبيع من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 2),
(159, 16, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول فواتير المبيعات. ونوضح لك آلية العمل ضمن هذا الموديول.\r\nكن مستعداً', 0, '', 1, 1),
(175, 17, 'إضافة  المادة إلى قائمة المواد المباعة', 'يمكنك إضافة المادة لقائمة المواد المباعة من هنا', 17, '', 1, 10),
(176, 17, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 9),
(177, 17, 'قائمة المواد المباعة', 'يمكنك إدارة المواد المختارة ضمن فاتورة المبيع. حيث يمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, 11),
(178, 17, 'اجمالي الفاتورة', 'بعد الانتهاء من عملية اختيار المواد وإدخال المعلومات الأساسية يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 13),
(179, 17, 'إضافة مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 12),
(180, 17, 'الحسم', 'يمكنك وضع قيمة الحسم على فاتورة المبيع من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 14),
(181, 17, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 15),
(182, 17, 'إضافة الفاتورة', 'بعد اتمام ادخال جميع معلومات الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 17),
(183, 17, 'تراجع', 'يمكن التراجع عن إضافة الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 18),
(184, 17, 'حفظ وإضافة المزيد', 'يمكن حفظ الفاتورة وفتح إضافة فاتورة فورا بدون الرجوع لصفحة عرض الفواتير من خلال الضغط على هذا الزر', 8, '', 1, 19),
(185, 17, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 20),
(189, 1, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 5),
(190, 2, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 6),
(191, 3, 'للعودة إلى شجرة الحسابات', 'للعودة لصفحة عرض الحسابات من هنا يمكنك القيام بذلك', 9, '', 1, NULL),
(192, 3, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(193, 4, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(196, 7, 'إدارة مرفقات الفاتورة', 'يمكنك إدارة المرفقات (تعديل، حذف) من هنا', 0, '#table-adafsor', 1, 13),
(199, 15, 'إدارة المرفقات', 'يمكن إدارة مرفقات الفاتورة (تعديل، حذف) من هنا.', 0, '#table-adafsor', 1, 13),
(201, 19, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل فاتورة مبيع', 0, '', 1, 1),
(202, 19, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 25, '', 1, 2),
(203, 19, 'تعديل الزبون', 'يمكن تعديل الزبون المراد بيعه. وإن كانت الفاتورة مع زبون ليس له حساب ضمن النظام فلا يجب اختيار الزبون. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مبيع أجل مع زبون ليس له حساب ضمن النظام.', 0, '#form-group-debit', 1, 3),
(204, 19, 'تعديل المستودع', 'تعديل المستودع الذي ستخرج البضاعة المباعة ضمن الفاتورة منه.', 26, '', 1, 4),
(205, 19, 'تعديل العملة', 'يمكنك تعديل العملة التي سيتم التعامل بها. ولكن يجب الانتباه في حال غيرت عملة الفاتورة يجب تغيير أسعار المواد المختارة للتوافق مع العملة الجديدة للفاتورة', 27, '', 1, 5),
(206, 19, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 28, '', 1, 6),
(207, 19, 'طريقة الدفع', 'يمكنك تعديل طريقة الدفع كاش ام أجل. علما أنه يجب اختيار الزبون إن كان الدفع أجل لكي يتم تحصيل قيمة الفاتورة من حساب الزبون المختار.', 29, '', 1, 7),
(208, 19, 'إضافة مواد جديدة للفاتورة', 'يمكنك إضافة مواد جديدة للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد بيعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 30, '', 1, 8),
(209, 19, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, 10),
(210, 19, 'إضافة المادة إلى سلة المبيعات', 'يمكنك إضافة المادة لسلة المبيعات من هنا', 17, '', 1, 11),
(211, 19, 'سلة المبيعات', 'يمكنك إدارة المواد المختارة ضمن فاتورة المبيع. تمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, 12),
(212, 19, 'تعديل مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, 13),
(213, 19, 'إدارة مرفقات الفاتورة', 'يمكنك إدارة المرفقات (تعديل، حذف) من هنا', 33, '', 1, 14),
(214, 19, 'اجمالي الفاتورة', 'بعد الانتهاء من جميع عملية التعديل . يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, 15),
(215, 19, 'الحسم', 'يمكنك تعديل قيمة الحسم على فاتورة المبيعات من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, 16),
(216, 19, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, 17),
(217, 19, 'حالة الفاتورة', 'يمكن تعديل حالة الفاتورة من هنا.', 24, '', 1, 18),
(218, 19, 'تعديل الفاتورة', 'بعد اتمام تعديل الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, 19),
(219, 19, 'تراجع', 'يمكن التراجع عن تعديل الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, 20),
(220, 19, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 21),
(221, 19, 'جعل المادة مجانية', 'لايمكنك إضافة مواد بسعر صفر إلى الفاتورة. وبالتالي لإضافة مادة مجانية للفاتورة يجب عليك تشييك هذا الحقل.', 34, '', 1, 9),
(222, 20, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول فواتير مردود المبيعات. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(223, 20, 'إضافة فاتورة مردود مبيع', 'يمكنك إضافة فاتورة مردود مبيع من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(224, 20, 'أزرار إدارة الفواتير', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الفاتورة من هنا', 3, '', 1, NULL),
(225, 20, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الفواتير والبحث ضمنها.', 10, '', 1, NULL),
(226, 20, 'البحث باستخدام الكلمات', 'يمكنك البحث عن فاتورة معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الفواتير', 12, '', 1, NULL),
(227, 20, 'تغيير عدد الفواتير التي تظهر بالصفحات', 'يمكنك التحكم بعدد الفواتير التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(228, 20, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(229, 20, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض فواتير مردودات المبيعات.', 0, '', 1, NULL),
(230, 21, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة فاتورة مردود مبيعات', 0, '', 1, NULL),
(231, 21, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 25, '', 1, NULL),
(232, 21, 'إدخال زبون', 'يجب إختيار الزبون المراد رد المواد له. وإن كانت الفاتورة مع زبون ليس له حساب ضمن النظام فلا يجب اختيار الزبون. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مردود مبيعات أجل مع زبون ليس له حساب ضمن النظام.', 0, '#form-group-credit', 1, NULL),
(233, 21, 'اختيار المستودع', 'اختيار المستودع الذي ستدخل البضاعة المردودة ضمن الفاتورة إليه أمر ضروري.', 26, '', 1, NULL),
(234, 21, 'اختيار العملة', 'يمكنك اختيار العملة التي سيتم التعامل بها. بشكل افتراضي يتم تحديد العملة الاساسية للنظام ولكن يمكنك إختيار أي عملة أخرى ضمن النظام.', 27, '', 1, NULL),
(235, 21, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 28, '', 1, NULL),
(236, 21, 'طريقة الدفع', 'يمكنك اختيار طريقة الدفع كاش ام أجل. علما أنه يجب اختيار الزبون إن كان الدفع أجل لكي يتم إضافة قيمة الفاتورة لحساب الزبون المختار.', 29, '', 1, NULL),
(237, 21, 'إضافة مواد للفاتورة', 'يمكنك إضافة مواد للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد إرجاعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 30, '', 1, NULL),
(238, 21, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, NULL),
(239, 21, 'إضافة المادة إلى سلة المردودات', 'يمكنك إضافة المادة لسلة المردودات من هنا', 17, '', 1, NULL),
(240, 21, 'سلة االمردودات', 'يمكنك إدارة المواد المختارة ضمن فاتورة مردود المبيعات. يمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, NULL),
(241, 21, 'إضافة مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هنا', 20, '', 1, NULL),
(242, 21, 'اجمالي الفاتورة', 'بعد الانتهاء من عملية اختيار المواد وإدخال المعلومات الأساسية يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, NULL),
(243, 21, 'الحسم', 'يمكنك وضع قيمة الحسم على فاتورة مردود المبيعات من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, NULL),
(244, 21, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, NULL),
(245, 21, 'حالة الفاتورة', 'يمكن اختيار حالة الفاتورة (منفذة أو مسودة) من هنا. في حال اختيار الحالة مسودة يتم تعليق الفاتورة ولا يتم تفعيلها إلا بعد تعديل الحالة إلى منفذة من استمارة تعديل الفاتورة', 24, '', 1, NULL),
(246, 21, 'إضافة الفاتورة', 'بعد اتمام ادخال جميع معلومات الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, NULL),
(247, 21, 'تراجع', 'يمكن التراجع عن إضافة الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, NULL),
(248, 21, 'حفظ وإضافة المزيد', 'يمكن حفظ الفاتورة وفتح إضافة فاتورة فورا بدون الرجوع لصفحة عرض الفواتير من خلال الضغط على هذا الزر', 8, '', 1, NULL),
(249, 21, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(250, 22, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل فاتورة مردود المبيعات', 0, '', 1, NULL),
(251, 22, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 25, '', 1, NULL),
(252, 22, 'تعديل الزبون', 'يمكن تعديل الزبون المراد ارجاع البضاعة منه. وإن كانت الفاتورة مع زبون ليس له حساب ضمن النظام فلا يجب اختيار الزبون. ولكن يجب الانتباه أنه لايمكن القيام بفاتورة مردود مبيعات أجل مع زبون ليس له حساب ضمن النظام.', 0, '#form-group-credit', 1, NULL),
(253, 22, 'تعديل المستودع', 'تعديل المستودع الذي ستدخل إليه البضاعة المحددة ضمن الفاتورة.', 26, '', 1, NULL),
(254, 22, 'تعديل العملة', 'يمكنك تعديل العملة التي سيتم التعامل بها. ولكن يجب الانتباه في حال غيرت عملة الفاتورة يجب تغيير أسعار المواد المختارة للتوافق مع العملة الجديدة للفاتورة', 27, '', 1, NULL),
(255, 22, 'سعر صرف العملة', 'يقوم النظام بعرض أخر سعر صرف للعملة المختارة. وفي حال أردت تغييرها يمكنك كتابة سعر صرف جديد.', 28, '', 1, NULL),
(256, 22, 'طريقة الدفع', 'يمكنك تعديل طريقة الدفع كاش ام أجل. علما أنه يجب اختيار الزبون إن كان الدفع أجل لكي يتم رد قيمة الفاتورة لحساب الزبون المختار.', 29, '', 1, NULL),
(257, 22, 'إضافة مواد جديدة للفاتورة', 'يمكنك إضافة مواد جديدة للفاتورة من هنا. حيث يجب قيامك باختيار المادة و العدد المراد ارجاعه و سعر الواحدة ، فيقوم النظام بحساب المجموع تلقائيا', 30, '', 1, NULL),
(258, 22, 'إعادة تعيين المادة', 'يمكنك محو جميع معلومات المادة والبدأ بإدخال المادة من جديد.', 18, '', 1, NULL),
(259, 22, 'إضافة المادة إلى سلة المردودات', 'يمكنك إضافة المادة لسلة المردودات من هنا', 17, '', 1, NULL),
(260, 22, 'سلة المردودات', 'يمكنك إدارة المواد المختارة ضمن فاتورة مردود المبيعات. تمكنك من حذف أو تعديل المواد وينعكس أي تعديل على المجموع النهائي للفاتورة.', 19, '', 1, NULL),
(261, 22, 'تعديل مرفقات الفاتورة', 'يمكنك إضافة مرفقات للفاتورة من هن', 20, '', 1, NULL),
(262, 22, 'إدارة المرفقات', 'يمكن إدارة مرفقات الفاتورة (تعديل، حذف) من هنا', 33, '', 1, NULL),
(263, 22, 'اجمالي الفاتورة', 'بعد الانتهاء من جميع عملية التعديل . يقوم النظام بحساب اجمالي الفاتورة', 21, '', 1, NULL),
(264, 22, 'الحسم', 'يمكنك تعديل قيمة الحسم على فاتورة مردود شراء من هنا. حيث يقتطع قيمة الحسم من اجمالي الفاتورة تلقائيا', 22, '', 1, NULL),
(265, 22, 'إجمالي الفاتورة بعد الحسم', 'يقوم النظام بحساب اجمالي الفاتورة بعد إدخال الحسم.', 23, '', 1, NULL),
(266, 22, 'حالة الفاتورة', 'يمكن تعديل حالة الفاتورة من هنا', 24, '', 1, NULL),
(267, 22, 'تعديل الفاتورة', 'بعد اتمام تعديل الفاتورة يمكنك حفظ الفاتورة من خلال الضغط على هذا الزر', 6, '', 1, NULL),
(268, 22, 'تراجع', 'يمكن التراجع عن تعديل الفاتورة من خلال الضغط على زر للخلف', 7, '', 1, NULL),
(269, 22, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(270, 23, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول الزبائن. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(271, 23, 'إضافة زبون', 'يمكنك إضافة زبون من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 2),
(272, 23, 'أزرار إدارة الزبائن', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الزبائن من هنا.', 3, '', 1, 4),
(273, 23, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الزبائن والبحث ضمنها.', 10, '', 1, 5),
(274, 23, 'البحث باستخدام الكلمات', 'يمكنك البحث عن الزبون معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الزبائن', 12, '', 1, 6),
(275, 23, 'تغيير عدد الزبائن التي تظهر بالصفحات', 'يمكنك التحكم بعدد الزبائن التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(276, 23, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض الزبائن.', 0, '', 1, 8),
(277, 23, 'استيراد البيانات', 'يمكنك الاستفادة من أداة استيراد البيانات من أجل القيام باستيراد بيانات مجموعة من الزبائن من ملف إكسل لتوفير الوقت والجهد.', 35, '', 1, 3),
(278, 24, 'املأ حقول بطاقة الزبون', 'أملأ حقول بطاقة الزبون مع الانتباه إلى أن * تدل على أن الحقل إجباري.\r\nعند إضافة زبون يقوم النظام بتوليد حساب خاص بالزبون ويضيفه لشجرة الحسابات تحت حساب زبائن المستخدم الذي تقوم بربط الزبون به.', 0, '', 1, NULL),
(279, 24, 'حفظ بطاقة الزبون', 'بعد ملأ معلومات البطاقة يمكنك حفظها من هنا', 6, '', 1, NULL),
(280, 24, 'الرجوع بدون حفظ بطاقة الزبون', 'إن أردت عدم حفظ بطاقة الزبون إضغط على زر للخلف', 7, '', 1, NULL),
(281, 24, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة زبون ومن ثم فتح استمارة إضافة بطاقة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, NULL),
(282, 24, 'للعودة إلى صفحة عرض الزبائن', 'للعودة لصفحة عرض الزبائن من هنا يمكنك القيام بذلك', 9, '', 1, NULL),
(283, 24, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(284, 25, 'تعديل بطاقة الزبون', 'قم بتعديل الحقول التي تريد تعديلها', 5, '', 1, 1),
(285, 25, 'حفظ التعديل', 'لحفظ التعديل على بطاقة الزبون أضغط على هذا الزر', 6, '', 1, 3),
(286, 25, 'تجاهل التعديل', 'يمكنك تجاهل التعديل والتراجع من خلال الضغط على هذا الزر', 7, '', 1, 4),
(287, 25, 'للعودة إلى صفحة عرض الزبائن', 'للعودة لصفحة عرض الزبائن من هنا يمكنك القيام بذلك', 9, '', 1, 5),
(288, 25, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 6),
(289, 25, 'تعديل المندوب الذي يتعامل مع الزبون', 'عند تعديل المندوب المرتبط مع الزبون يتم نقل حساب الزبون ضمن الشجرة وإدراجه ضمن حسابات زبائن المندوب الجديد', 0, '#form-group-delegate_id', 1, 2),
(290, 26, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول الموردون. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(291, 26, 'إضافة مورد', 'يمكنك إضافة مورد من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(292, 26, 'أزرار إدارة الموردون', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل الزبائن من هنا.', 3, '', 1, NULL),
(293, 26, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة الموردون والبحث ضمنها.', 10, '', 1, NULL),
(294, 26, 'البحث باستخدام الكلمات', 'يمكنك البحث عن مورد معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن الموردون', 12, '', 1, NULL),
(295, 26, 'تغيير عدد الموردين التي تظهر بالصفحات', 'يمكنك التحكم بعدد الموردين الذي يظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(296, 26, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض الموردين.', 0, '', 1, NULL),
(297, 27, 'املأ حقول بطاقة المورد', 'أملأ حقول بطاقة المورد مع الانتباه إلى أن * تدل على أن الحقل إجباري. عند إضافة مورد يقوم النظام بتوليد حساب خاص بالمورد ويضيفه لشجرة الحسابات تحت حساب الأب المختار.', 5, '', 1, 1),
(298, 27, 'حفظ بطاقة المورد', 'بعد ملأ معلومات البطاقة يمكنك حفظها من هنا', 6, '', 1, 4),
(299, 27, 'الرجوع بدون حفظ بطاقة المورد', 'إن أردت عدم حفظ بطاقة المورد إضغط على زر للخلف', 7, '', 1, 5),
(300, 27, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة مورد ومن ثم فتح استمارة إضافة بطاقة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, 6),
(301, 27, 'للعودة إلى صفحة عرض الموردين', 'للعودة لصفحة عرض الموردين من هنا يمكنك القيام بذلك', 9, '', 1, 7),
(302, 27, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 8),
(303, 27, 'اختيار حساب الأب للمورد الجديد', 'يجب اختيار حساب الأب الذي سيندرج حساب المورد المراد إنشاءه ضمنه بشجرة الحسابات', 0, '#form-group-account_id', 1, 2),
(304, 27, 'اختيار المندوبين', 'قم باختيار المندوبين الذين سيتعاملون مع هذا المورد عند القيام بقواتير المشتريات ومردود المشتريات', 0, '#form-group-supplier_delegates', 1, 3),
(305, 28, 'تعديل بطاقة المورد', 'قم بتعديل الحقول التي تريد تعديلها', 5, '', 1, NULL),
(306, 28, 'تعديل المندوبين الذين يتعامل معهم المورد', 'يمكنك تعديل قائمة المندوبين الذين يتعامل معهم المورد من هنا', 0, '#form-group-supplier_delegates', 1, NULL),
(307, 28, 'حفظ التعديل', 'لحفظ التعديل على بطاقة المورد أضغط على هذا الزر', 6, '', 1, NULL),
(308, 28, 'تجاهل التعديل', 'يمكنك تجاهل التعديل والتراجع من خلال الضغط على هذا الزر', 7, '', 1, NULL),
(309, 28, 'للعودة إلى صفحة عرض الموردين', 'للعودة لصفحة عرض الموردين من هنا يمكنك القيام بذلك', 9, '', 1, NULL),
(310, 28, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(311, 29, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول المواد. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(312, 29, 'إضافة مادة', 'يمكنك إضافة مادة من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(313, 29, 'استيراد البيانات', 'يمكنك الاستفادة من أداة استيراد البيانات من أجل القيام باستيراد بيانات مجموعة من المواد من ملف إكسل لتوفير الوقت والجهد.', 35, '', 1, NULL),
(314, 29, 'أزرار إدارة المواد', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل المواد من هنا.', 3, '', 1, NULL),
(315, 29, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة المواد والبحث ضمنها.', 10, '', 1, NULL),
(316, 29, 'البحث باستخدام الكلمات', 'يمكنك البحث عن مادة معينة من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن المواد', 12, '', 1, NULL),
(317, 29, 'تغيير عدد المواد التي تظهر بالصفحة', 'يمكنك التحكم بعدد المواد التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(318, 29, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض المواد.', 0, '', 1, NULL),
(319, 30, 'املأ حقول بطاقة المادة', 'أملأ حقول بطاقة المادة مع الانتباه إلى أن * تدل على أن الحقل إجباري.', 5, '', 1, 1),
(320, 30, 'حفظ بطاقة المادة', 'بعد ملأ معلومات البطاقة يمكنك حفظها من هنا', 6, '', 1, 5),
(321, 30, 'الرجوع بدون حفظ بطاقة المادة', 'إن أردت عدم حفظ بطاقة المادة إضغط على زر للخلف', 7, '', 1, 6),
(322, 30, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة زبون ومن ثم فتح استمارة إضافة بطاقة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, 7),
(323, 30, 'للعودة إلى صفحة عرض المواد', 'للعودة لصفحة عرض المواد من هنا يمكنك القيام بذلك', 9, '', 1, 8),
(324, 30, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 9),
(325, 30, 'اختيار تصنيف المادة', 'قم باختيار تصنيف المادة. علما أن تصنيف المادة يستخدم في تشكيل رمز المادة المضافة', 0, '#form-group-item_category_id', 1, 2),
(326, 30, 'اختيار الواحدة', 'قم باختيار الواحدة التي تقاس فيها كمية المادة', 0, '#form-group-item_unit_id', 1, 3),
(327, 30, 'تحديد صلاحية المندوبين على المادة المضافة', 'قم باختيار حالة المادة بالنسبة للمندوبين. هل يمكن للمندوبين التعامل مع المادة المضافة أم لا.', 0, '#form-group-visible_to_delegates', 1, 4),
(328, 31, 'تعديل بطاقة المادة', 'قم بتعديل الحقول التي تريد تعديلها', 5, '', 1, 2),
(329, 31, 'حفظ التعديل', 'لحفظ التعديل على بطاقة المادة أضغط على هذا الزر', 6, '', 1, 3),
(330, 31, 'تجاهل التعديل', 'يمكنك تجاهل التعديل والتراجع من خلال الضغط على هذا الزر', 7, '', 1, 4),
(331, 31, 'للعودة إلى صفحة عرض المواد', 'للعودة لصفحة عرض المواد من هنا يمكنك القيام بذلك', 9, '', 1, 5),
(332, 31, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 6),
(333, 31, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل بطاقة المادة', 0, '', 1, 1),
(334, 30, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة بطاقة المادة', 0, '', 1, NULL),
(335, 32, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول تصنيفات المواد. ونوضح لك آلية العمل ضمن هذا الموديول.\r\nكن مستعداً', 0, '', 1, 1),
(336, 32, 'إضافة تصنيف جديد', 'يمكنك إضافة تصنيف جديد من هنا. حيث تقوم بملأ حقول الاستمارة.', 2, '', 1, 2),
(337, 32, 'أزرار إدارة العناصر', 'يمكنك استخدام هذه الأزرار لإدارة العناصر من مشاهدة أو تعديل أو حذف', 3, '', 1, 4),
(338, 32, 'مشاهدة الأبناء', 'لمشاهدة أبناء تصنيف معين يمكنك استخدام هذه الزر', 4, '', 1, 5),
(339, 32, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 6),
(340, 32, 'استيراد البيانات', 'يمكن استيراد شجرة التصنيفات من ملف إكسل بالاستفادة من أداة استيراد البيانات التي يوفرها النظام.', 0, '#btn-import-data', 1, 3),
(341, 33, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة تصنيف', 0, '', 1, 1),
(342, 33, 'املأ حقول الاستمارة', 'أملأ حقول الاستمارة مع الانتباه إلى أن * تدل على أن الحقل إجباري', 5, '', 1, 2),
(343, 33, 'حفظ التصنيف', 'بعد ملأ معلومات التصنيف يمكنك حفظه من هنا', 6, '', 1, 5),
(344, 33, 'الرجوع بدون حفظ التصنيف', 'إن اردت عدم حفظ التصنيف إضغط على زر للخلف', 7, '', 1, 6),
(345, 33, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة التصنيف ومن ثم فتح استمارة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, 7),
(346, 33, 'للعودة إلى صفحة شجرة التصنيفات', 'للعودة لصفحة عرض العناصر من هنا يمكنك القيام بذلك', 9, '', 1, 8),
(347, 33, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 9),
(348, 33, 'قم باختيار التصنيف الأب للتصنيف المضاف', 'ملاحظة: في حال كان التصنيف تصنيف رئيسي وليس له حساب أب. لا تنسى إدخال رمز التصنيف لكي يتم اعتماده ضمن شجرة التصنيفات', 0, '#form-group-parent_id', 1, 3),
(349, 33, 'قم باختيار حالة التصنيف', 'هل هو تصنيف رئيسي أم تصنيف غير رئيسي. التصنيف الرئيسي يمكن إضافة تصنيفات فرعية ضمنه. أم التصنيف الغير رئيسي لا يمكن إضافة تصنيفات ضمنه.', 0, '#form-group-major_classification', 1, 4),
(350, 34, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل التصنيف', 0, '', 1, NULL),
(351, 34, 'تعديل حقول الاستمارة', 'قم بتعديل الحقول التي تريد تعديلها', 5, '', 1, NULL),
(352, 34, 'حفظ التعديل', 'لحفظ التعديل على التصنيف أضغط على هذا الزر', 6, '', 1, NULL),
(353, 34, 'تجاهل التعديل', 'يمكنك تجاهل التعديل والتراجع من خلال الضغط على هذا الزر', 7, '', 1, NULL),
(354, 34, 'للعودة إلى شجرة التصنيفات', 'للعودة لصفحة عرض الحسابات من هنا يمكنك القيام بذلك', 9, '', 1, NULL),
(355, 34, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(356, 35, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات القبض. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(357, 35, 'إضافة سند قبض', 'يمكنك إضافة سند قبض من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(358, 35, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, NULL),
(359, 35, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, NULL),
(360, 35, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند قبض معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, NULL),
(361, 35, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(362, 35, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(363, 35, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات القبض', 0, '', 1, NULL),
(364, 36, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند قبض', 0, '', 1, 1),
(365, 36, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(366, 36, 'إضافة سند القبض', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 12),
(367, 36, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 13),
(368, 36, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 14),
(369, 36, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 15),
(370, 36, 'قم باختيار الحساب', 'قم باختيار الحساب المراد قبض مبلغ مالي معين منه. حيث تدخل قيمة سند القبض مباشرة إلى صندوق المستخدم.', 0, '#form-group-credit', 1, 3),
(371, 36, 'ادخل البيان', 'قم بإدخال توصيف لعملية القبض', 0, '#form-group-narration', 1, 4),
(372, 36, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد قبضه من الحساب.', 0, '#form-group-currency_id', 1, 5),
(373, 36, 'ادخل المبلغ المراد قبضه', 'قم بإدخال قيمة المبلغ المراد قبضه من الحساب بحسب العملة المختارة', 0, '#form-group-amount', 1, 6),
(374, 36, 'المقابل', 'يمكنك تحويل المبلغ المقبوض من الحساب لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خسم قيمة المبلغ بالعملة المقبوضة من الحساب و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها إلى صندوق المستخدم.', 0, '#form-group-opposite', 1, 7),
(375, 36, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد قبضه إليها بالنسبة لعملة المبلغ المقبوض.', 0, '#form-group-ex_rate', 1, 8),
(376, 36, 'القيمة المسددة من الحساب', 'وتكون القيمة بالعملة المحدد بحقل المقابل وهي التي يتم إضافتها لصندوق المستخدم.', 0, '#form-group-equalizer', 1, 9),
(377, 36, 'إضافة مرفق', 'يمكن إضافة مرفق للسند القبض من هنا', 37, '', 1, 10),
(378, 36, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 11),
(379, 37, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند قبض', 0, '', 1, 1),
(380, 37, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(381, 37, 'تعديل سند القبض', 'بعد اتمام تعديل  معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 12),
(382, 37, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 13),
(394, 38, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات الدفع. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(395, 38, 'إضافة سند الدفع', 'يمكنك إضافة سند الدفع من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(384, 37, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 15),
(385, 37, 'تعديل الحساب', 'قم باختيار الحساب المراد قبض مبلغ مالي معين منه. حيث تدخل قيمة سند القبض مباشرة إلى صندوق المستخدم.', 0, '#form-group-credit', 1, 3),
(386, 37, 'تعديل البيان', 'قم بإدخال توصيف لعملية القبض', 0, '#form-group-narration', 1, 4),
(387, 37, 'تعديل العملة', 'قم باختيار عملة المبلغ المراد قبضه من الحساب. عند تعديل العملة سيحدث تغيرات بحقل المقابل أرجو التدقيق بالتغيرات الناتجة عن عملية تغيير العملة.', 0, '#form-group-currency_id', 1, 5),
(388, 37, 'تعديل المبلغ المراد قبضه', 'قم بإدخال قيمة المبلغ المراد قبضه من الحساب بحسب العملة المختارة', 0, '#form-group-amount', 1, 6),
(389, 37, 'المقابل', 'يمكنك تحويل المبلغ المقبوض من الحساب لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خصم قيمة المبلغ بالعملة المقبوضة من الحساب و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها إلى صندوق المستخدم.', 0, '#form-group-opposite', 1, 7),
(390, 37, 'تعديل سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد قبضه إليها بالنسبة لعملة المبلغ المقبوض. تغيير سعر الصرف يؤدي لتغيير القيمة المسددة من الحساب', 0, '#form-group-ex_rate', 1, 8),
(391, 37, 'القيمة المسددة من الحساب', 'وتكون القيمة بالعملة المحدد بحقل المقابل وهي التي يتم إضافتها لصندوق المستخدم.', 0, '#form-group-equalizer', 1, 9),
(392, 37, 'إضافة مرفق', 'يمكن إضافة مرفق للسند القبض من هنا', 37, '', 1, 10),
(393, 37, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 11),
(396, 38, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, NULL),
(397, 38, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, NULL),
(398, 38, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند دفع معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, NULL),
(399, 38, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(400, 38, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(401, 38, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات الدفع', 0, '', 1, NULL),
(402, 39, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند الدفع', 0, '', 1, 1),
(403, 39, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(404, 39, 'إضافة سند الدفع', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 12),
(405, 39, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 13),
(406, 39, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 14),
(407, 39, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 15),
(408, 39, 'قم باختيار الحساب', 'قم باختيار الحساب المراد دفع مبلغ مالي معين له. حيث تخرج قيمة سند الدفع من صندوق المستخدم و تدخل مباشرة إلى الحساب المختار.', 0, '#form-group-debit', 1, 3),
(409, 39, 'ادخل البيان', 'قم بإدخال توصيف لعملية الدفع', 0, '#form-group-narration', 1, 4),
(410, 39, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد دفعه للحساب.', 0, '#form-group-currency_id', 1, 5),
(411, 39, 'ادخل المبلغ المراد دفعه', 'قم بإدخال قيمة المبلغ المراد دفعه للحساب بحسب العملة المختارة', 0, '#form-group-amount', 1, 6),
(412, 39, 'المقابل', 'يمكنك تحويل المبلغ المراد دفعه للحساب لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خسم قيمة المبلغ بالعملة المدفوعة من صندوق المستخدم  و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها للحساب المختار.', 0, '#form-group-opposite', 1, 7),
(413, 39, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد دفعه للحساب إليها بالنسبة لعملة المبلغ المدفوع.', 0, '#form-group-ex_rate', 1, 8);
INSERT INTO `tours_steps` (`id`, `tour_id`, `title`, `description`, `element_id`, `element_key`, `active`, `sorting`) VALUES
(414, 39, 'القيمة المدفوعة', 'وتكون القيمة بالعملة المحددة بحقل المقابل وهي التي يتم إضافتها للحساب المختار.', 0, '#form-group-equalizer', 1, 9),
(415, 39, 'إضافة مرفق', 'يمكن إضافة مرفق للسند الدفع من هنا', 37, '', 1, 10),
(416, 39, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 11),
(417, 40, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند الدفع', 0, '', 1, 1),
(418, 40, 'تعديل رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(419, 40, 'تعديل سند الدفع', 'بعد اتمام تعديل  معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 12),
(420, 40, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 13),
(421, 40, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 15),
(422, 40, 'تعديل الحساب', 'قم باختيار الحساب المراد دفع مبلغ مالي معين له. حيث تدخل قيمة سند الدفع مباشرة للحساب المختار.', 0, '#form-group-debit', 1, 3),
(423, 40, 'تعديل البيان', 'قم بإدخال توصيف لعملية الدفع', 0, '#form-group-narration', 1, 4),
(424, 40, 'تعديل العملة', 'قم باختيار عملة المبلغ المراد دفعه للحساب المختار. عند تعديل العملة سيحدث تغيرات بحقل المقابل أرجو التدقيق بالتغيرات الناتجة عن عملية تغيير العملة.', 0, '#form-group-currency_id', 1, 5),
(425, 40, 'تعديل المبلغ المراد دفعه', 'قم بإدخال قيمة المبلغ المراد دفعه للحساب بحسب العملة المختارة', 0, '#form-group-amount', 1, 6),
(426, 40, 'المقابل', 'يمكنك تحويل المبلغ المراد دفعه للحساب المختار لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خصم قيمة المبلغ بالعملة المدفوعة من صندوق المستخدم و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها للحساب.', 0, '#form-group-opposite', 1, 7),
(427, 40, 'تعديل سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد دفعه إليها بالنسبة لعملة المبلغ المدفوع. تغيير سعر الصرف يؤدي لتغيير القيمة المعادلة', 0, '#form-group-ex_rate', 1, 8),
(428, 40, 'القيمة المعادلة', 'وتكون القيمة بالعملة المحدد بحقل المقابل وهي التي يتم إضافتها لصندوق المستخدم.', 0, '#form-group-equalizer', 1, 9),
(429, 40, 'إضافة مرفق', 'يمكن إضافة مرفق للسند الدفع من هنا', 37, '', 1, 10),
(430, 40, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 11),
(431, 41, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات التحويل. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(432, 41, 'إضافة سند تحويل', 'يمكنك إضافة سند تحويل من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(433, 41, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, NULL),
(434, 41, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, NULL),
(435, 41, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, NULL),
(436, 41, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(437, 41, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(438, 41, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات التحويل', 0, '', 1, NULL),
(439, 42, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند تحويل', 0, '', 1, 1),
(440, 42, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(441, 42, 'إضافة سند تحويل', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 10),
(442, 42, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 11),
(443, 42, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 12),
(444, 42, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 13),
(445, 42, 'قم باختيار حساب المدين', 'قم باختيار الحساب المراد نقل مبلغ مالي معين له. حيث تخرج قيمة سند التحويل من حساب الدائن و تدخل مباشرة إلى الحساب المدين.', 0, '#form-group-debit', 1, 3),
(446, 42, 'ادخل البيان', 'قم بإدخال توصيف لعملية التحويل', 0, '#form-group-narration', 1, 5),
(447, 42, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد تحويله للحساب المدين.', 0, '#form-group-currency_id', 1, 6),
(448, 42, 'ادخل المبلغ المراد تحويله', 'قم بإدخال قيمة المبلغ المراد تحويله لحساب المدين بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(449, 42, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 8),
(450, 42, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 9),
(451, 42, 'قم بإدخال حساب الدائن', 'الحساب الدائن هو صندوق المستخدم يقوم النظام بتحديده تلقائيا', 0, '#form-group-credit', 1, 4),
(452, 43, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند تحويل', 0, '', 1, 1),
(453, 43, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(454, 43, 'حفظ التعديلات', 'بعد اتمام تعديل معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 10),
(455, 43, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 11),
(465, 44, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات اليومية. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(466, 44, 'إضافة سند يومية', 'يمكنك إضافة سند يومية من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(457, 43, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 13),
(458, 43, 'قم باختيار حساب المدين', 'قم باختيار الحساب المراد نقل مبلغ مالي معين له. حيث تخرج قيمة سند التحويل من حساب الدائن و تدخل مباشرة إلى الحساب المدين.', 0, '#form-group-debit', 1, 3),
(459, 43, 'ادخل البيان', 'قم بإدخال توصيف لعملية التحويل', 0, '#form-group-narration', 1, 5),
(460, 43, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد تحويله للحساب المدين.', 0, '#form-group-currency_id', 1, 6),
(461, 43, 'ادخل المبلغ المراد تحويله', 'قم بإدخال قيمة المبلغ المراد تحويله لحساب المدين بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(462, 43, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 8),
(463, 43, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 9),
(464, 43, 'قم بإدخال حساب الدائن', 'الحساب الدائن هو صندوق المستخدم يقوم النظام بتحديده تلقائيا', 0, '#form-group-credit', 1, 4),
(467, 44, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, NULL),
(468, 44, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, NULL),
(469, 44, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, NULL),
(470, 44, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(471, 44, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(472, 44, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات اليومية', 0, '', 1, NULL),
(473, 45, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند يومية', 0, '', 1, 1),
(474, 45, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(475, 45, 'إضافة سند اليومية', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 13),
(476, 45, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 14),
(477, 45, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 15),
(478, 45, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 16),
(479, 45, 'قم باختيار حساب المدين', 'قم باختيار الحساب المراد نقل مبلغ مالي معين له. حيث تخرج قيمة سند اليومية من حساب الدائن و تدخل مباشرة إلى حساب المدين.', 0, '#form-group-debit', 1, 3),
(480, 45, 'ادخل البيان', 'قم بإدخال توصيف لعملية سند اليومية', 0, '#form-group-narration', 1, 5),
(481, 45, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد نقله من حساب الدائن.', 0, '#form-group-currency_id', 1, 6),
(482, 45, 'ادخل المبلغ المراد نقله', 'قم بإدخال قيمة المبلغ المراد نقله للحساب المدين بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(483, 45, 'المقابل', 'يمكنك تحويل المبلغ المراد نقله للحساب المدين لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خصم قيمة المبلغ بالعملة الدائن من حساب الدائن  و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها للحساب المدين.', 0, '#form-group-opposite', 1, 8),
(484, 45, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد نقله للحساب المدين إليها بالنسبة لعملة الدائن.', 0, '#form-group-ex_rate', 1, 9),
(485, 45, 'القيمة المعادلة', 'وتكون القيمة بالعملة المحددة بحقل المقابل وهي التي يتم نقلها للحساب المدين.', 0, '#form-group-equalizer', 1, 10),
(486, 45, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 11),
(487, 45, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 12),
(488, 45, 'قم باختيار حساب الدائن', 'قم باختيار الحساب المراد نقل المبلغ منه إلى حساب المدين', 0, '#form-group-credit', 1, 4),
(489, 46, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند يومية', 0, '', 1, 1),
(490, 46, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(491, 46, 'تعديل سند اليومية', 'بعد اتمام تعديل معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 13),
(492, 46, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 14),
(505, 47, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات التصريف. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, NULL),
(494, 46, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 16),
(495, 46, 'قم باختيار حساب المدين', 'قم باختيار الحساب المراد نقل مبلغ مالي معين له. حيث تخرج قيمة سند اليومية من حساب الدائن و تدخل مباشرة إلى حساب المدين.', 0, '#form-group-debit', 1, 3),
(496, 46, 'ادخل البيان', 'قم بإدخال توصيف لعملية سند اليومية', 0, '#form-group-narration', 1, 5),
(497, 46, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد نقله من حساب الدائن. مع الانتباه إلى أن تعديل العملة يؤدي إلى تغيير قيمة حقل المقابل.', 0, '#form-group-currency_id', 1, 6),
(498, 46, 'ادخل المبلغ المراد نقله', 'قم بإدخال قيمة المبلغ المراد نقله للحساب المدين بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(499, 46, 'المقابل', 'يمكنك تحويل المبلغ المراد نقله للحساب المدين لعملة أخرى من خلال اختيار العملة المراد تحويل المبلغ لها. فيتم خصم قيمة المبلغ بالعملة الدائن من حساب الدائن  و إدخال قيمة المبلغ بعد تحويله للعملة المقابلة وبحسب سعر الصرف المدخل لها للحساب المدين.', 0, '#form-group-opposite', 1, 8),
(500, 46, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المراد التحويل المبلغ المراد نقله للحساب المدين إليها بالنسبة لعملة الدائن.', 0, '#form-group-ex_rate', 1, 9),
(501, 46, 'القيمة المعادلة', 'وتكون القيمة بالعملة المحددة بحقل المقابل وهي التي يتم نقلها للحساب المدين.', 0, '#form-group-equalizer', 1, 10),
(502, 46, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 11),
(503, 46, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 12),
(504, 46, 'قم باختيار حساب الدائن', 'قم باختيار الحساب المراد نقل المبلغ منه إلى حساب المدين', 0, '#form-group-credit', 1, 4),
(506, 47, 'إضافة سند تصريف', 'يمكنك إضافة سند تصريف من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, NULL),
(507, 47, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, NULL),
(508, 47, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, NULL),
(509, 47, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, NULL),
(510, 47, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, NULL),
(511, 47, 'الأجراء الجماعي', 'يمكنك تنفيز بعض العمليات على مجموعة من العناصر معا من هنا.', 16, '', 1, NULL),
(512, 47, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات التصريف', 0, '', 1, NULL),
(513, 48, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند تصريف', 0, '', 1, 1),
(514, 48, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(515, 48, 'إضافة سند تصريف', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 13),
(516, 48, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 14),
(517, 48, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 15),
(518, 48, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 16),
(519, 48, 'قم باختيار حساب المدين', 'علما أن بسند التصريف حساب الدائن والمدين هو نفس الحساب (صندوق المستخدم) ويقوم النظام بتحديده تلقائيا.', 0, '#form-group-debit', 1, 3),
(520, 48, 'ادخل البيان', 'قم بإدخال توصيف لعملية سند التصريف', 0, '#form-group-narration', 1, 5),
(521, 48, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد تصريفه من حساب الدائن (صندوق المستخدم).', 0, '#form-group-currency_id', 1, 6),
(522, 48, 'ادخل المبلغ المراد تصريفه', 'قم بإدخال قيمة المبلغ المراد تصريفه بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(523, 48, 'المقابل', 'يجب أختبار عملة مختلفة عن العملة المختارة سابقا. من أجل تصريف المبلغ إلى العملة المختار بحقل المقابل.', 0, '#form-group-opposite', 1, 8),
(529, 49, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند تصريف', 0, '', 1, 1),
(524, 48, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المختارة بحقل المقابل بالنسبة للعملة المختارة سابقا من أجل تحويل المبلغ المراد تصريفه إليها.', 0, '#form-group-ex_rate', 1, 9),
(525, 48, 'القيمة المعادلة', 'وتكون القيمة بالعملة المحددة بحقل المقابل وهي قيمة المبلغ بعد تصريفه.', 0, '#form-group-equalizer', 1, 10),
(526, 48, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 11),
(527, 48, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 12),
(528, 48, 'قم باختيار حساب الدائن', 'علما أن بسند التصريف حساب الدائن والمدين هو نفس الحساب (صندوق المستخدم) ويقوم النظام بتحديده تلقائيا.', 0, '#form-group-credit', 1, 4),
(530, 49, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(531, 49, 'تعديل سند تصريف', 'بعد اتمام تعديل معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 13),
(532, 49, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 14),
(545, 50, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول سندات الأرصدة الافتتاحية. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(546, 50, 'إضافة سند افتتاحي', 'يمكنك إضافة سند افتتاحي من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 2),
(534, 49, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 16),
(535, 49, 'قم باختيار حساب المدين', 'علما أن بسند التصريف حساب الدائن والمدين هو نفس الحساب (صندوق المستخدم) ويقوم النظام بتحديده تلقائيا.', 0, '#form-group-debit', 1, 3),
(536, 49, 'ادخل البيان', 'قم بإدخال توصيف لعملية سند التصريف', 0, '#form-group-narration', 1, 5),
(537, 49, 'اختيار العملة', 'قم باختيار عملة المبلغ المراد تصريفه من حساب الدائن (صندوق المستخدم).', 0, '#form-group-currency_id', 1, 6),
(538, 49, 'ادخل المبلغ المراد تصريفه', 'قم بإدخال قيمة المبلغ المراد تصريفه بحسب العملة المختارة', 0, '#form-group-amount', 1, 7),
(539, 49, 'المقابل', 'يجب اختيار عملة مختلفة عن العملة المختارة سابقا. من أجل تصريف المبلغ إلى العملة المختار بحقل المقابل.', 0, '#form-group-opposite', 1, 8),
(540, 49, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المختارة بحقل المقابل بالنسبة للعملة المختارة سابقا من أجل تحويل المبلغ المراد تصريفه إليها.', 0, '#form-group-ex_rate', 1, 9),
(541, 49, 'القيمة المعادلة', 'وتكون القيمة بالعملة المحددة بحقل المقابل وهي قيمة المبلغ بعد تصريفه.', 0, '#form-group-equalizer', 1, 10),
(542, 49, 'إضافة مرفق', 'يمكن إضافة مرفق للسند من هنا', 37, '', 1, 11),
(543, 49, 'إدارة المرفقات', 'يمكنك إدارة المرفقات (تعديل ، حذف) من هنا', 33, '', 1, 12),
(544, 49, 'قم باختيار حساب الدائن', 'علما أن بسند التصريف حساب الدائن والمدين هو نفس الحساب (صندوق المستخدم) ويقوم النظام بتحديده تلقائيا.', 0, '#form-group-credit', 1, 4),
(547, 50, 'أزرار إدارة السندات', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل السند من هنا', 3, '', 1, 4),
(548, 50, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة السندات والبحث ضمنها.', 10, '', 1, 5),
(549, 50, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  سند معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن السندات', 12, '', 1, 6),
(550, 50, 'تغيير عدد السندات التي تظهر بالصفحة', 'يمكنك التحكم بعدد السندات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(551, 50, 'استيراد البيانات', 'يمكنك الاستفادة من أداة استيراد البيانات من أجل اختصار الوقت والجهد. عن طريق استيراد بيانات الأرصدة الافتتاحية من ملف إكسل', 35, '', 1, 3),
(552, 50, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض سندات الأرصدة الافتتاحية', 0, '', 1, 8),
(553, 51, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة سند افتتاحي', 0, '', 1, 1),
(554, 51, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(555, 51, 'إضافة سند افتتاحي', 'بعد اتمام ادخال جميع معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 8),
(556, 51, 'تراجع', 'يمكن التراجع عن إضافة السند من خلال الضغط على زر للخلف', 7, '', 1, 9),
(557, 51, 'حفظ وإضافة المزيد', 'يمكن حفظ السند وفتح إضافة استمارة الإضافة فورا بدون الرجوع لصفحة عرض السندات من خلال الضغط على هذا الزر', 8, '', 1, 10),
(558, 51, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(559, 51, 'قم بإدخال البيان', 'قم بإدخال توصيف للسند الافتتاحي', 0, '#form-group-narration', 1, 3),
(560, 51, 'إدخال الأرصدة ضمن السند الافتتاحي', 'قم بملأ بيانات الحساب المراد إضافته للسندات الافتتاحية. علما أن القيمة الافتتاحية إن كانت موجبة يكون الحساب دائن وإن كانت سالبة يكون الحساب مدين.', 0, '#panel-form-adfelalsndat .child-form-area', 1, 4),
(561, 51, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات الحساب جميعها معا.', 0, '#btn-reset-form-adfelalsndat', 1, 5),
(562, 51, 'إضافة لقائمة السندات الافتتاحية', 'بعد ملأ معلومات الحساب قم بالضغط على هذا الزر من أجل إضافة الحساب إلى قائمة السندات الافتتاحية', 0, '#btn-add-table-adfelalsndat', 1, 6),
(563, 51, 'إدارة قائمة السندات الافتتاحية', 'يمكنك إدارة قائمة السندات الافتتاحية (حذف، تعديل) من هنا', 0, '#table-adfelalsndat', 1, 7),
(564, 52, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل سند افتتاحي', 0, '', 1, 1),
(565, 52, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 36, '', 1, 2),
(566, 52, 'تعديل سند افتتاحي', 'بعد اتمام تعديل معلومات السند يمكنك حفظ السند من خلال الضغط على هذا الزر', 6, '', 1, 8),
(567, 52, 'تجاهل التعديل', 'يمكن التراجع عن تعديل السند من خلال الضغط على زر للخلف', 7, '', 1, 9),
(575, 53, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول إشعارات القبض. ونوضح لك آلية العمل ضمن هذا الموديول. حيث عندما يقوم أحد المستخدمين بإرسال سند تحويل إليك يقوم النظام بعرض إشعار لك على الصفحة الرئيسية لتأكيد استلامك للمبلغ. وهذا الموديول يتيح لك مشاهدة سندات التحويل المرسلة لك ويوفر إمكانية تأكيد الاستلام. ويعرض حالة السندات التحويل المرسلة لك.', 0, '', 1, 1),
(569, 52, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(570, 52, 'قم بإدخال البيان', 'قم بإدخال توصيف للسند الافتتاحي', 0, '#form-group-narration', 1, 3),
(571, 52, 'إدخال الأرصدة ضمن السند الافتتاحي', 'قم بملأ بيانات الحساب المراد إضافته للسندات الافتتاحية. علما أن القيمة الافتتاحية إن كانت موجبة يكون الحساب دائن وإن كانت سالبة يكون الحساب مدين.', 0, '#panel-form-adfelalsndat .child-form-area', 1, 4),
(572, 52, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات الحساب جميعها معا.', 0, '#btn-reset-form-adfelalsndat', 1, 5),
(573, 52, 'إضافة حسابات جديدة لقائمة السندات الافتتاحية', 'بعد ملأ معلومات الحساب قم بالضغط على هذا الزر من أجل إضافة الحساب إلى قائمة السندات الافتتاحية', 0, '#btn-add-table-adfelalsndat', 1, 6),
(574, 52, 'إدارة قائمة السندات الافتتاحية', 'يمكنك إدارة قائمة السندات الافتتاحية (حذف، تعديل) من هنا', 0, '#table-adfelalsndat', 1, 7),
(576, 53, 'أزرار لإدارة إشعارت القبض', 'يمكنك مشاهدة تفصيل سند التحويل المرسل إليك و مشاهدة حالة السند التحويل و يمكن تأكيد استلامك للمبلغ من هنا', 3, '', 1, 4),
(577, 53, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة سندات التحويل المرسلة لك والبحث ضمنها.', 10, '', 1, 5),
(578, 53, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  إشعار معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن إشعارات القبض المرسلة لك.', 12, '', 1, 6),
(579, 53, 'تغيير عدد الإشعارات التي تظهر بالصفحة', 'يمكنك التحكم بعدد الإشعارت التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(580, 53, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض إشعارات القبض', 0, '', 1, 8),
(581, 54, 'البداية', 'سنعرض لك اقسام صفحة تفصيل إشعار القبض', 0, '', 1, 1),
(582, 54, 'تفصيل سند التحويل', 'قسم عرض بيانات سند التحويل المرسل إليك من قبل أحد المستخدمين الأخرين.', 0, '#parent-form-area', 1, 2),
(583, 54, 'قسم عرض حالة إشعار القبض', 'هذا القسم يقوم بعرض حالة إشعار القبض (هل تم استلامه أم لا). ويتيح لك تأكيد استلام المبلغ. ويعرض من قام بعملية الاستلام وتاريخ الاستلام.', 0, '#content_section .col-sm-4 > .panel:nth-child(2)', 1, 3),
(584, 54, 'قسم معلومات الوثيقة', 'هذا القسم يقوم بعرض معلومات الوثيقة (من قام بإعدادها، من قام بالتعديل عليها، من قام بتأكيد استلامها ... الخ)', 0, '#content_section .col-sm-4 > .panel:nth-child(3)', 1, 4),
(585, 54, 'قسم الإجراءات المتاحة', 'هذا القسم يعرض جميع الإجراءات المساعدة للتعامل مع الإشعار', 0, '.detail-page-btns', 1, 5),
(586, 54, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض إشعار القبض', 0, '', 1, 7),
(587, 54, 'العودة إلى قائمة إشعارات القبض', 'يمكن العودة إلى قائمة إشعارات القبض من هنا', 9, '', 1, 6),
(588, 55, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول المستودعات. ونوضح لك آلية العمل ضمن هذا الموديول.\r\nكن مستعداً', 0, '', 1, 1),
(589, 55, 'إضافة مستودع جديد', 'يمكنك إضافة مستودع جديد من هنا. حيث تقوم بملأ حقول الاستمارة.', 2, '', 1, 2),
(590, 55, 'أزرار إدارة العناصر', 'يمكنك استخدام هذه الأزرار لإدارة العناصر من مشاهدة أو تعديل أو حذف', 3, '', 1, 4),
(591, 55, 'مشاهدة الأبناء', 'لمشاهدة أبناء مستودع معين يمكنك استخدام هذه الزر', 4, '', 1, 5),
(592, 55, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 6),
(593, 56, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة مستودع جديد', 0, '', 1, 1),
(594, 56, 'املأ حقول الاستمارة', 'أملأ حقول الاستمارة مع الانتباه إلى أن * تدل على أن الحقل إجباري', 5, '', 1, 2),
(595, 56, 'حفظ المستودع', 'بعد ملأ معلومات المستودع يمكنك حفظه من هنا', 6, '', 1, 6),
(596, 56, 'الرجوع بدون حفظ المستودع', 'إن اردت عدم حفظ المستودع إضغط على زر للخلف', 7, '', 1, 7),
(597, 56, 'حفظ و إضافة المزيد', 'من أجل توفير الوقت يمكنك إضافة المستودع ومن ثم فتح استمارة جديدة فورا من خلال استخدام هذا الزر', 8, '', 1, 8),
(598, 56, 'للعودة إلى صفحة شجرة المستودعات', 'للعودة لصفحة عرض العناصر من هنا يمكنك القيام بذلك', 9, '', 1, 9),
(599, 56, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 10),
(600, 56, 'قم باختيار التصنيف الأب للمستودع المضاف', 'ملاحظة: في حال كان المضاف تصنيف رئيسي وليس له حساب أب. لا تنسى إدخال رمز التصنيف لكي يتم اعتماده ضمن شجرة المستودعات', 0, '#form-group-parent_id', 1, 4),
(601, 56, 'قم باختيار حالة التصنيف', 'هل هو تصنيف رئيسي أم تصنيف غير رئيسي. التصنيف الرئيسي يمكن إضافة مستودعات فرعية ضمنه. أم التصنيف الغير رئيسي لا يمكن إضافة مستودعات ضمنه.', 0, '#form-group-major_classification', 1, 5),
(602, 56, 'قم بتحديد المندوبين', 'قم بتحديد المستخدمين  المشرفين على المستودع من هنا. إن كان المستودع المضاف (مستودع رئيسي) ليس هناك حاجة لملأ هذا الحقل.', 0, '#form-group-delegates', 1, 3),
(603, 57, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل معلومات المستودع', 0, '', 1, 1),
(604, 57, 'تعديل حقول الاستمارة', 'قم بتعديل حقول الاستمارة مع الانتباه إلى أن * تدل على أن الحقل إجباري', 5, '', 1, 2),
(605, 57, 'تعديل المستودع', 'بعد تعديل معلومات المستودع يمكنك حفظه من هنا', 6, '', 1, 6),
(606, 57, 'تجاهل التعديل', 'إن اردت عدم حفظ التعديلات إضغط على زر للخلف', 7, '', 1, 7),
(613, 58, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول بضاعة أول المدة. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(608, 57, 'للعودة إلى صفحة شجرة المستودعات', 'للعودة لصفحة عرض العناصر من هنا يمكنك القيام بذلك', 9, '', 1, 9),
(609, 57, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 10),
(610, 57, 'قم باختيار التصنيف الأب للمستودع المضاف', 'ملاحظة: في حال كان المضاف تصنيف رئيسي وليس له حساب أب. لا تنسى إدخال رمز التصنيف لكي يتم اعتماده ضمن شجرة المستودعات', 0, '#form-group-parent_id', 1, 4),
(611, 57, 'قم باختيار حالة التصنيف', 'هل هو تصنيف رئيسي أم تصنيف غير رئيسي. التصنيف الرئيسي يمكن إضافة مستودعات فرعية ضمنه. أم التصنيف الغير رئيسي لا يمكن إضافة مستودعات ضمنه.', 0, '#form-group-major_classification', 1, 5),
(612, 57, 'قم بتحديد المندوبين', 'قم بتحديد المستخدمين  المشرفين على المستودع من هنا. إن كان المستودع المضاف (مستودع رئيسي) ليس هناك حاجة لملأ هذا الحقل.', 0, '#form-group-delegates', 1, 3),
(614, 58, 'إضافة بضاعة أول المدة', 'يمكنك إضافة  بضاعة أول المدة من هنا. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 2),
(615, 58, 'أزرار إدارة قوائم بضاعة أول المدة', 'يمكنك تعديل أو حذف أو مشاهدة تفصيل بضاعة أول المدة من هنا', 3, '', 1, 4),
(616, 58, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة العناصر والبحث ضمنها.', 10, '', 1, 5),
(617, 58, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  عنصر معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن العناصر', 12, '', 1, 6),
(618, 58, 'تغيير عدد العناصر التي تظهر بالصفحة', 'يمكنك التحكم بعدد العناصر التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(619, 58, 'استيراد البيانات', 'يمكنك الاستفادة من أداة استيراد البيانات من أجل اختصار الوقت والجهد. عن طريق استيراد بيانات بضاعة أول المدة من ملف إكسل', 35, '', 1, 3),
(620, 58, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض قوائم بضاعة أول المدة', 0, '', 1, 8),
(621, 59, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة بضاعة أول المدة', 0, '', 1, 1),
(622, 59, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-ib_number', 1, 2),
(623, 59, 'إضافة بضاعة أول المدة', 'بعد اتمام ادخال جميع معلومات قائمة بضاعة أول المدة يمكنك حفظ القائمة من خلال الضغط على هذا الزر', 6, '', 1, 9),
(624, 59, 'تراجع', 'يمكن التراجع عن إضافة القائمة من خلال الضغط على زر للخلف', 7, '', 1, 10),
(625, 59, 'حفظ وإضافة المزيد', 'يمكن حفظ القائمة وفتح استمارة الإضافة فورا بدون الرجوع لصفحة عرض العناصر من خلال الضغط على هذا الزر', 8, '', 1, 11),
(626, 59, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 12),
(627, 59, 'قم بإدخال الملاحظات', 'قم بإدخال توصيف لبضاعة اول المدة في حال وجوده.', 0, '#form-group-note', 1, 4),
(628, 59, 'إدخال المواد ضمن قائمة بضاعة أول المدة', 'قم بملأ بيانات المادة المراد إضافتها لقائمة بضاعة أول المدة.', 0, '#panel-form-adaflljdol .child-form-area', 1, 5),
(665, 63, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل عملية نقل مواد', 0, '', 1, 1),
(629, 59, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات المادة جميعها معا.', 0, '#btn-reset-form-adaflljdol', 1, 6),
(630, 59, 'إضافة لقائمة بضاعة أول المدة', 'بعد ملأ معلومات المادة قم بالضغط على هذا الزر من أجل إضافة المادة إلى قائمة بضاعة أول المدة', 0, '#btn-add-table-adaflljdol', 1, 7),
(631, 59, 'إدارة قائمة بضاعة أول المدة', 'يمكنك إدارة قائمة بضاعة أول المدة (حذف، تعديل) من هنا', 0, '#table-adaflljdol', 1, 8),
(632, 59, 'اختيار المستودع', 'قم باختيار المستودع المرتبط مع قائمة بضاعة أول المدة', 0, '#form-group-source', 1, 3),
(633, 60, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل بضاعة أول المدة', 0, '', 1, 1),
(634, 60, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-ib_number', 1, 2),
(635, 60, 'تعديل بضاعة أول المدة', 'بعد اتمام تعديل معلومات قائمة بضاعة أول المدة يمكنك حفظ التعديل من خلال الضغط على هذا الزر', 6, '', 1, 9),
(636, 60, 'تجاهل التعديل', 'يمكن التراجع عن تعديل القائمة من خلال الضغط على زر للخلف', 7, '', 1, 10),
(645, 61, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول نقل المواد. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(646, 61, 'إضافة عملية نقل مواد', 'يمكنك إجراء عملية نقل مواد بين مستودعاتك. أيضا يمكنك استخدام الاختصار Ctrl+a لفتح صفحة الإضافة.', 2, '', 1, 2),
(638, 60, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 12),
(639, 60, 'قم بإدخال الملاحظات', 'قم بإدخال توصيف لبضاعة اول المدة في حال وجوده.', 0, '#form-group-note', 1, 4),
(640, 60, 'إدخال المواد ضمن قائمة بضاعة أول المدة', 'قم بملأ بيانات المادة المراد إضافتها لقائمة بضاعة أول المدة.', 0, '#panel-form-adaflljdol .child-form-area', 1, 5),
(641, 60, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات المادة جميعها معا.', 0, '#btn-reset-form-adaflljdol', 1, 6),
(642, 60, 'إضافة لقائمة بضاعة أول المدة', 'بعد ملأ معلومات المادة قم بالضغط على هذا الزر من أجل إضافة المادة إلى قائمة بضاعة أول المدة', 0, '#btn-add-table-adaflljdol', 1, 7),
(643, 60, 'إدارة قائمة بضاعة أول المدة', 'يمكنك إدارة قائمة بضاعة أول المدة (حذف، تعديل) من هنا', 0, '#table-adaflljdol', 1, 8),
(644, 60, 'اختيار المستودع', 'قم باختيار المستودع المرتبط مع قائمة بضاعة أول المدة', 0, '#form-group-source', 1, 3),
(647, 61, 'أزرار إدارة عملية نقل المواد', 'يمكنك مشاهدة حالة عملية النقل و مشاهدة صفحة التفصيل الخاصة بها. ويمكنك إضافة تعليقات في حال لم يتم استلام المواد بعد. ويمكنك التعديل على عملية النقل طالما لم يتم استلامها بعد.', 3, '', 1, 4),
(648, 61, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة العناصر والبحث ضمنها.', 10, '', 1, 5),
(649, 61, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  عنصر معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن العناصر', 12, '', 1, 6),
(650, 61, 'تغيير عدد العناصر التي تظهر بالصفحة', 'يمكنك التحكم بعدد العناصر التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(651, 61, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض عمليات نقل المواد', 0, '', 1, 8),
(652, 62, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة عملية نقل مواد', 0, '', 1, 1),
(653, 62, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-transfer_number', 1, 2),
(654, 62, 'إضافة عملية النقل', 'بعد اتمام ادخال جميع معلومات  الاستمارة يمكنك حفظها من خلال الضغط على هذا الزر', 6, '', 1, 10),
(655, 62, 'تراجع', 'يمكن التراجع عن إضافة عملية النقل من خلال الضغط على زر للخلف', 7, '', 1, 11),
(656, 62, 'حفظ وإضافة المزيد', 'يمكن حفظ عملية النقل وفتح استمارة الإضافة فورا بدون الرجوع لصفحة عرض العناصر من خلال الضغط على هذا الزر', 8, '', 1, 12),
(657, 62, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 13),
(659, 62, 'إدخال المواد المراد نقلها', 'قم بملأ بيانات المادة المراد إضافتها لقائمة المواد المنقولة', 0, '#panel-form-adaflljdol .child-form-area', 1, 6),
(660, 62, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات المادة جميعها معا.', 0, '#btn-reset-form-adaflljdol', 1, 7),
(661, 62, 'إضافة المادة لقائمة المواد المنقولة', 'بعد ملأ معلومات المادة قم بالضغط على هذا الزر من أجل إضافة المادة إلى قائمة المواد المنقولة', 0, '#btn-add-table-adaflljdol', 1, 8),
(662, 62, 'إدارة قائمة المواد المنقولة', 'يمكنك إدارة قائمة المواد المنقولة (حذف، تعديل) من هنا', 0, '#table-adaflljdol', 1, 9),
(663, 62, 'اختيار المستودع المصدر', 'قم باختيار المستودع  المراد نقل المواد منه.', 0, '#form-group-source', 1, 3),
(664, 62, 'اختيار المستودع الهدف', 'قم باختيار المستودع الهدف المراد نقل المواد إليه.', 0, '#form-group-destination', 1, 4),
(666, 63, 'إدخال رقم الوثيقة', 'رقم الوثيقة إختياري. في حال توفره يفضل إدخاله', 0, '#form-group-transfer_number', 1, 2),
(667, 63, 'حفظ التعديل', 'بعد اتمام تعديل معلومات  الاستمارة يمكنك حفظها من خلال الضغط على هذا الزر', 6, '', 1, 10),
(668, 63, 'تجاهل التعديل', 'يمكن التراجع عن تعديل عملية النقل من خلال الضغط على زر للخلف', 7, '', 1, 11),
(677, 64, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول العملات. ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(678, 64, 'إضافة عملة جديدة', 'يمكنك إضافة عملة جديدة دائما. مع أخز بعين الاعتبار أن سعر صرف أي عملة جديدة يجب أن يكون بالنسبة للعملة الرئيسية.', 2, '', 1, 3),
(670, 63, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 13),
(671, 63, 'إدخال المواد المراد نقلها', 'قم بملأ بيانات المادة المراد إضافتها لقائمة المواد المنقولة', 0, '#panel-form-adaflljdol .child-form-area', 1, 6),
(672, 63, 'اعادة التعيين', 'يمكن استخدام اعادة تعيين من أجل محو معلومات المادة جميعها معا.', 0, '#btn-reset-form-adaflljdol', 1, 7),
(673, 63, 'إضافة المادة جديدة لقائمة المواد المنقولة', 'بعد ملأ معلومات المادة قم بالضغط على هذا الزر من أجل إضافة المادة إلى قائمة المواد المنقولة', 0, '#btn-add-table-adaflljdol', 1, 8),
(674, 63, 'إدارة قائمة المواد المنقولة', 'يمكنك إدارة قائمة المواد المنقولة (حذف، تعديل) من هنا', 0, '#table-adaflljdol', 1, 9),
(675, 63, 'اختيار المستودع المصدر', 'قم باختيار المستودع  المراد نقل المواد منه.', 0, '#form-group-source', 1, 3),
(676, 63, 'اختيار المستودع الهدف', 'قم باختيار المستودع الهدف المراد نقل المواد إليه.', 0, '#form-group-destination', 1, 4),
(679, 64, 'أزرار إدارة العملات', 'يمكن إدارة العملات مشاهدة التفاصيل ، تعديل، حذف من هنا', 3, '', 1, 4),
(685, 65, 'املأ حقول بطاقة العملة', 'أملأ حقول بطاقة العملة مع الانتباه إلى أن * تدل على أن الحقل إجباري.', 5, '', 1, 1),
(680, 64, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة العناصر والبحث ضمنها.', 10, '', 1, 5),
(681, 64, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  عنصر معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن العناصر', 12, '', 1, 6),
(682, 64, 'تغيير عدد العناصر التي تظهر بالصفحة', 'يمكنك التحكم بعدد العناصر التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(683, 64, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض العملات', 0, '', 1, 8),
(684, 64, 'العملة الرئيسية', 'العملة الرئيسية للنظام تكون مضافة عند بدأ عمل النظام.وهي الليرة السورية وسعر الصرف الخاص بها دائما 1. ويمكن تعديلها طالما لم يتم إجراء اي عمليات مالية ضمن النظام. ولا يمكن حذفها.', 0, '', 1, 2),
(686, 65, 'حفظ بطاقة العملة', 'بعد ملأ معلومات البطاقة يمكنك حفظها من هنا', 6, '', 1, 7),
(687, 65, 'الرجوع بدون حفظ بطاقة العملة', 'إن أردت عدم حفظ بطاقة العملة إضغط على زر للخلف', 7, '', 1, 8),
(688, 65, 'حفظ و إضافة المزيد', 'يمكنك إضافة العملة ومن ثم فتح استمارة الإضافة من جديد من خلال استخدام هذا الزر', 8, '', 1, 9),
(689, 65, 'للعودة إلى صفحة عرض العملات', 'للعودة لصفحة عرض العملات من هنا يمكنك القيام بذلك', 9, '', 1, 10),
(690, 65, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(691, 65, 'اختيار رمز العملة', 'قم باختيار رمز العملة من القائمة.', 0, '#form-group-code', 1, 2),
(692, 65, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة المضافة مقابل العملة الرئيسية', 0, '#form-group-ex_rate', 1, 3),
(693, 65, 'تحديد هل العملة رئيسية أم لا', 'النظام له عملة رئيسية واحد فقط. وبتالي عند وضع العملة المضافة كعملة رئيسية يقوم النظام بعتمادها كعملة رئيسية. ولكن لا يمكن القيام بتغيير العملية الرئيسية إلى في  حال عدم وجود أي معاملات مالية ضمن النظام.', 0, '#form-group-is_major', 1, 4),
(694, 65, 'اختيار أيقونة العملة', 'يمكن اختيار أيقونة تمثل العملة المضافة من هنا', 0, '#form-group-icon', 1, 5),
(695, 65, 'اختيار لون يمثل العملة', 'يمكن اختيار لون يمثل العملة ضمن النظام من هنا', 0, '#form-group-color', 1, 6),
(696, 66, 'تعديل حقول بطاقة العملة', 'قم بتعديل بيانات بطاقة العملة مع الانتباه إلى أن * تدل على أن الحقل إجباري.', 5, '', 1, 2),
(697, 66, 'حفظ تعديل بطاقة العملة', 'بعد الانتهاء من تعديل بيانات بطاقة العملة يمكنك حفظها من هنا', 6, '', 1, 8),
(698, 66, 'تجاهل التعديل', 'إن أردت عدم حفظ تعديل بطاقة العملة إضغط على زر للخلف', 7, '', 1, 9),
(709, 67, 'البداية', 'هذا التقرير يسمح لك بمراقبة جميع حسابات عملائك (زبائن، موردون). حيث يقوم بعرض تفصيلي لجميع العمليات التي قام بها الحساب سواء فواتير أو سندات ويعرض الرصيد النهائي. حيث يمكنك عرض التقرير شامل لجميع العملات. ويمكنك اختيار عملة معينة لعرض التقرير الخاص بها', 0, '', 1, 1),
(700, 66, 'للعودة إلى صفحة عرض العملات', 'للعودة لصفحة عرض العملات من هنا يمكنك القيام بذلك', 9, '', 1, 11),
(701, 66, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 12),
(702, 66, 'اختيار رمز العملة', 'قم باختيار رمز العملة من القائمة.', 0, '#form-group-code', 1, 3),
(703, 66, 'تحديد سعر الصرف', 'قم بتحديد سعر صرف العملة مقابل العملة الرئيسية. مع الانتباه أن تعديل سعر الصرف سينعكس على كامل النظام. وستتأثر به جميع العمليات المالية من لحظة تعديله.', 0, '#form-group-ex_rate', 1, 4),
(704, 66, 'تحديد هل العملة رئيسية أم لا', 'النظام له عملة رئيسية واحد فقط. وبتالي عند وضع العملة كعملة رئيسية يقوم النظام بعتمادها كعملة رئيسية. ولكن لا يمكن القيام بتغيير العملية الرئيسية إلى في  حال عدم وجود أي معاملات مالية ضمن النظام.', 0, '#form-group-is_major', 1, 5),
(705, 66, 'اختيار أيقونة العملة', 'يمكن اختيار أيقونة تمثل العملة من هنا', 0, '#form-group-icon', 1, 6),
(706, 66, 'اختيار لون يمثل العملة', 'يمكن اختيار لون يمثل العملة ضمن النظام من هنا', 0, '#form-group-color', 1, 7),
(707, 66, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل بطاقة العملة', 0, '', 1, 1),
(708, 65, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة عملة جديدة', 0, '', 1, NULL),
(710, 67, 'اختيار حساب العميل', 'يجب اختيار الحساب أولا لعرض التقرير الخاص به. فبعد اختيارك للحساب أضغط على زر عرض.', 0, '#report-filter-person', 1, 2),
(711, 67, 'اختيار العملة', 'يمكنك اختيار العملة لعرض التقرير الخاص بالحساب وفقا للعملة المختارة وإن لم يتم اختيارها يقوم بعرض تقرير تفصيلي بجميع عملات النظام', 0, '#report-filter-currency', 1, 3),
(712, 67, 'عرض', 'بعد اختيارك للحساب و العملة يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 5),
(713, 67, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 6),
(714, 67, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 7),
(715, 67, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 8),
(716, 67, 'النهاية', 'بعد اختيارك للحساب والضغط على زر عرض. يظهر التقرير  النتائج النهائية لرصيد الحساب أسفل الصفحة. لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 9),
(717, 67, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقول التاريخ (من، إلى) لعرض النتائج ضمن مجال زمني معين.', 0, '#report-filter-from_date', 1, 4),
(718, 68, 'البداية', 'هذا التقرير يسمح لك بمراقبة جميع العمليات التي تأثرت بها مادة معينة. ويسمح بعملية فلترة نتائج البحث على مجموعة من المعاملات.', 0, '', 1, 1),
(719, 68, 'اختيار المادة', 'يجب اختيار المادة المراد البحث عنها أولا لعرض التقرير الخاص بها. فبعد اختيارك للمادة أضغط على زر عرض.', 0, '#report-filter-item', 1, 2),
(720, 68, 'اختيار المستودع', 'يمكنك اختيار  مستودع معين. من أجل توجيه عملية البحث نحو العمليات التي تمت ضمن المستودع المختار', 0, '#report-filter-inventory', 1, 3),
(727, 68, 'اختيار نوع العملية', 'يمكنك تحديد نوع العملية المارد البحث عنها. من أجل توجيه البحث بتجاه عملية معينة.', 0, '#report-filter-operation', 1, 4),
(721, 68, 'عرض', 'بعد اختيارك للمادة و المعاملات المراد إدخالها بعملية البحث يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 6),
(722, 68, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 7),
(723, 68, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 8),
(724, 68, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 9),
(725, 68, 'النهاية', 'بعد اختيارك للمادة والضغط على زر عرض. يظهر التقرير  النتائج النهائية المعبرة عن حركة المادة أسفل الصفحة. لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 10),
(726, 68, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقول التاريخ (من، إلى) لعرض النتائج ضمن مجال زمني معين.', 0, '#report-filter-from_date', 1, 5),
(728, 69, 'البداية', 'هذا التقرير يعرض لك رصيد المستودعات من المواد. ويسمح بعملية فلترة نتائج البحث على مجموعة من المعاملات. قيمكنك معرفة مخزون مستودع معين من المواد أو يمكنك معرفة كمية مادة معينة ضمن جميع مستودعات الشركة.', 0, '', 1, 1),
(729, 69, 'اختيار المادة', 'يمكنك اختيار المادة معينة لفلترة نتائج البحث و عرض التقرير متعلق بالمادة المختارة. فبعد اختيارك للمادة أضغط على زر عرض.', 0, '#report-filter-item', 1, 2),
(730, 69, 'اختيار المستودع', 'يمكنك اختيار  مستودع معين. من أجل توجيه عملية البحث نحو العمليات التي تمت ضمن المستودع المختار. وعرض تقرير مفصل عن كمية المواد الموجودة ضمن المستودع المختار.', 0, '#report-filter-inventory', 1, 3),
(732, 69, 'عرض', 'بعد اختيارك للمعاملات المراد إدخالها بعملية البحث يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 6),
(733, 69, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 7),
(734, 69, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 8),
(735, 69, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 9),
(736, 69, 'النهاية', 'لقد انتهت الجولة ضمن تقرير أرصدة المواد (جرد). شكرا جزيلا', 0, '', 1, 10),
(738, 70, 'اختيار المندوب', 'يجب اختيار المندوب أولا لعرض التقرير الخاص به. فبعد اختيارك للمندوب أضغط على زر عرض.', 0, '#report-filter-delegate', 1, 2),
(737, 69, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقل التاريخ لعرض النتائج قبل تاريخ معين. علما أن النظام يقوم بعرض جميع النتائج قبل تاريخ الحالي بشكل افتراضي ما لم يتم تحديد تاريخ معين ضمن حقل التاريخ.', 0, '#report-filter-date', 1, 5),
(747, 71, 'البداية', 'هذا التقرير يسمح لك بمشاهدة جميع القيود المالية التي تتم ضمن النظام. ويسمح لك بفلترة النتائج على مجموعة من المعاملات التي تساعدك بالبحث عن قيود معينة.', 0, '', 1, 1),
(740, 70, 'عرض', 'بعد اختيارك للمندوب يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 5),
(741, 70, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 6),
(742, 70, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 7),
(743, 70, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 8),
(744, 70, 'النهاية', 'بعد اختيارك للمندوب والضغط على زر عرض. يظهر التقرير  النتائج النهائية الخاص بالمندوب المختار أسفل الصفحة. لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 9),
(745, 70, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقول التاريخ (من، إلى) لعرض النتائج ضمن مجال زمني معين.', 0, '#report-filter-from_date', 1, 4),
(746, 70, 'البداية', 'هذا التقرير يسمح لك بمراقبة جميع العمليات التي يقوم بها المندوبين من فواتير وسندات.', 0, '', 1, NULL),
(756, 71, 'اختيار المندوب', 'يمكنك اختيار المندوب الذي تبحث عن قيود متعلقة به عند الحاجة.', 0, '#report-filter-delegate', 1, 3),
(748, 71, 'اختيار حساب', 'يمكنك تحديد حساب معين لعرض القيود الخاصة به. فبعد اختيارك للحساب أضغط على زر عرض.', 0, '#report-filter-account', 1, 2),
(749, 71, 'اختيار العملة', 'يمكنك اختيار العملة لعرض التقرير الخاص بالحساب وفقا للعملة المختارة وإن لم يتم اختيارها يقوم بعرض تقرير تفصيلي بجميع عملات النظام', 0, '#report-filter-currency', 1, 4),
(750, 71, 'عرض', 'بعد اختيارك للحساب يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 6),
(751, 71, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 7),
(752, 71, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 8),
(753, 71, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 9),
(754, 71, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 10),
(757, 72, 'البداية', 'هذا التقرير يسمح لك بمشاهدة جميع القيود المالية (المحذوفة أو المعدلة) التي تتم ضمن النظام. ويسمح لك بفلترة النتائج على مجموعة من المعاملات التي تساعدك بالبحث عن قيود معينة.', 0, '', 1, 1),
(755, 71, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقول التاريخ (من، إلى) لعرض النتائج ضمن مجال زمني معين.', 0, '#report-filter-from_date', 1, 5),
(758, 72, 'اختيار المندوب', 'يمكنك اختيار المندوب الذي تبحث عن قيود متعلقة به عند الحاجة.', 0, '#report-filter-delegate', 1, 3),
(759, 72, 'اختيار حساب', 'يمكنك تحديد حساب معين لعرض القيود (المحذوفة أو المعدلة) الخاصة به. فبعد اختيارك للحساب أضغط على زر عرض.', 0, '#report-filter-account', 1, 2),
(760, 72, 'اختيار العملة', 'يمكنك اختيار العملة لعرض التقرير الخاص بالحساب وفقا للعملة المختارة وإن لم يتم اختيارها يقوم بعرض تقرير تفصيلي بجميع عملات النظام', 0, '#report-filter-currency', 1, 4),
(761, 72, 'عرض', 'بعد اختيارك للحساب يجب الضغط على هذا الزر من أجل عرض التقرير الموافق للمعلومات التي قمت باختيارها.', 0, '#search', 1, 7),
(762, 72, 'إعادة تعيين', 'يقوم هذا الزر بإعادة حقول الفلتر إلى قيمها الافتراضية.', 0, '#reset', 1, 8),
(763, 72, 'الطباعة', 'يقوم هذا الزر بفتح صفحة معاينة قبل الطباعة. يمكن الاستفادة منها بطباعة تقريرك او تحويله إلى pdf', 0, '#PrintReport', 1, 9),
(764, 72, 'التصدير', 'يمكن النظام بتصدير التقرير إلى ملف إكسل.', 0, '#export', 1, 10),
(765, 72, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(766, 72, 'فلترة النتائج بالاعتماد على التاريخ', 'يمكن الاستفادة من حقول التاريخ (من، إلى) لعرض النتائج ضمن مجال زمني معين.', 0, '#report-filter-from_date', 1, 6),
(767, 72, 'اختيار الإجراء', 'يمكنك فلترة نتائج البحث بتحديد نوع الإجراء المتعلق بالقيود (حذف أو تعديل أو جميع الإجراءات) عند الحاجة.', 0, '#report-filter-action', 1, 5),
(768, 73, 'البداية', 'بعد كل عملية تدوير للبيانات ضمن النظام. يقوم النظام بإغلاق الدورة المالية والبدأ بدورة مالية جديدة. ولاستعراض بيانات الدورات المالية السابقة يمكنك القيام بذلك من هذا الموديول الذي يقوم بعرض جميع الدورات المالية السابقة (المدورة) ويوفر إمكانية استعراضها. ومشاهدة نتائجها.', 0, '', 1, 1),
(769, 73, 'أزرار لإدارة الدورة المالية', 'يمكنك استعراض الدورة المالية و مشاهدة نتائج تدوير الدورة المالية و معرفة الشروط التي تم اعتمادها لحظة تدوير هذه الدورة المالية. بالإضافة يمكنك مشاهدة سجل الإجراءات التي تاثرت بها الدورة المالية المستعرضة.', 3, '', 1, 4),
(770, 73, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة النتائج والبحث ضمنها.', 10, '', 1, 5),
(771, 73, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  دورة مالية معينة من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن نتيجة البحث.', 12, '', 1, 6),
(772, 73, 'تغيير عدد الدورات المالية التي تظهر بالصفحة', 'يمكنك التحكم بعدد الدورات المالية التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(773, 73, 'النهاية', 'لقد انتهت الجولة ضمن موديول الدورات المالية', 0, '', 1, 8),
(774, 74, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول إدارة المستخدمين . ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(775, 74, 'إضافة مستخدم جديد', 'يمكنك إضافة مستخدم جديد للنظام من هنا.', 2, '', 1, 2),
(781, 74, 'استعراض الرخص', 'يمكنك استعراض الأدوار وصلاحيات كل منها ضمن النظام من هنا.', 0, '#astaarad-alrkhs', 1, 3),
(776, 74, 'أزرار إدارة المستخدمين', 'يمكن إدارة المستخدمين مشاهدة التفاصيل ، تعديل، حذف من هنا', 3, '', 1, 5),
(777, 74, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة العناصر والبحث ضمنها.', 10, '', 1, 6),
(778, 74, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  عنصر معين من خلال استخدام حقل البحث وكتابة كلمة مفتاحية للبحث عنها ضمن العناصر', 12, '', 1, 7),
(779, 74, 'تغيير عدد العناصر التي تظهر بالصفحة', 'يمكنك التحكم بعدد العناصر التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 8),
(780, 74, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض المستخدمين', 0, '', 1, 9),
(782, 74, 'تنبيه', 'رجاءا قم بقراءة هذه الملاحظة لتساعدك بفهم آلية إضافة مندوب للنظام وربطه مع المستودعات الخاصة به.', 0, '.callout-info', 1, 4),
(783, 75, 'املأ حقول الاستمارة', 'أملأ الحقول مع الانتباه إلى أن * تدل على أن الحقل إجباري.', 5, '', 1, 2),
(784, 75, 'حفظ المستخدم', 'بعد ملأ معلومات الاستمارة يمكنك حفظها من هنا.', 6, '', 1, 7),
(785, 75, 'الرجوع بدون إضافة المستخدم', 'إن أردت عدم إضافة المستخدم إضغط على زر للخلف', 7, '', 1, 8),
(786, 75, 'حفظ و إضافة المزيد', 'يمكنك إضافة المستخدم ومن ثم فتح استمارة الإضافة من جديد من خلال استخدام هذا الزر', 8, '', 1, 9),
(787, 75, 'للعودة إلى صفحة عرض المستخدمين', 'للعودة لصفحة عرض المستخدمين من هنا يمكنك القيام بذلك', 9, '', 1, 10),
(788, 75, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(789, 75, 'اسم المستخدم', 'قم بإدخال اسم المستخدم', 0, '#form-group-name', 1, 3),
(795, 75, 'إدخال كلمة المرور', 'من فضلك ادخل كلمة المرور على الأقل 8 محارف.', 0, '#form-group-password', 1, 6),
(792, 75, 'البريد الإلكتروني', 'قم بإدخال البريد الإلكتروني', 0, '#form-group-email', 1, 4),
(793, 75, 'اختيار الرخصة (دور المستخدم ضمن النظام)', 'قم باختيار الرخصة  (أدمن، مدير، مدير مبيعات، مندوب، مندوب معمل، أمين صندوق معمل، مشاهدة فقط) التي تمثل دور المستخدم ضمن النظام. علما أنه عند اختيار بعض الرخص تظهر بعض الحقول الجديدة ضمن الاستمارة. تساعدك بربط المستخدم بـ (مستودعات، موردين ...الخ)', 0, '#form-group-id_cms_privileges', 1, 5),
(794, 75, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإضافة مستخدم جديد', 0, '', 1, 1),
(796, 76, 'تعديل حقول الاستمارة', 'قم بتعديل الحقول مع الانتباه إلى أن * تدل على أن الحقل إجباري.', 5, '', 1, 2),
(797, 76, 'حفظ التعديل', 'بعد تعديل معلومات الاستمارة يمكنك حفظها من هنا.', 6, '', 1, 7),
(798, 76, 'تجاهل التعديل', 'إن أردت عدم حفظ التعديل إضغط على زر للخلف', 7, '', 1, 8),
(807, 77, 'البداية', 'سنقوم بأخذك بجولة ضمن موديول إدارة النسخ الاحتياطية . ونوضح لك آلية العمل ضمن هذا الموديول. كن مستعداً', 0, '', 1, 1),
(800, 76, 'للعودة إلى صفحة عرض المستخدمين', 'للعودة لصفحة عرض المستخدمين من هنا يمكنك القيام بذلك', 9, '', 1, 10),
(801, 76, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 11),
(802, 76, 'اسم المستخدم', 'يمكنك تعديل اسم المستخدم من هنا', 0, '#form-group-name', 1, 3),
(803, 76, 'تعديل كلمة المرور', 'من فضلك ادخل كلمة المرور الجديدة وقم بإدخال تأكيد كلمة المرور ومن قم الضغط على حفظ من أجل تغيير كلمة السر.', 0, '#form-group-password', 1, 6),
(804, 76, 'البريد الإلكتروني', 'يمكنك تعديل البريد الإلكتروني الخاص بالمستخدم', 0, '#form-group-email', 1, 4),
(805, 76, 'اختيار الرخصة (دور المستخدم ضمن النظام)', 'لايمكن تعديل رخصة المستخدم', 0, '#form-group-id_cms_privileges', 1, 5),
(808, 77, 'إنشاء نسخة احتياطية', 'يمكنك إنشاء نسخة احتياطية للنظام من هنا', 0, '#ensha-nskh-ehtyaty', 1, 2),
(806, 76, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لتعديل معلومات المستخدم', 0, '', 1, 1),
(810, 77, 'أزرار إدارة النسخ الاحتياطية', 'يمكن إدارة النسخ الاحتياطية  (استرجاع النسخة الاحتياطية ،تعديل الاسم، حذف) من هنا. علما أنه عند استرجاع النسخة الاحتياطية يقوم النظام بالعودة بحالة النظام لوقت تاريخ انشاء النسخة الاحتياطية.', 3, '', 1, 5),
(811, 77, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة العناصر والبحث ضمنها.', 10, '', 1, 6),
(812, 77, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  عنصر معين من خلال استخدام حقل البحث وكتابة كلمة مفتاحية للبحث عنها ضمن العناصر', 12, '', 1, 7),
(813, 77, 'تغيير عدد العناصر التي تظهر بالصفحة', 'يمكنك التحكم بعدد العناصر التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 8);
INSERT INTO `tours_steps` (`id`, `tour_id`, `title`, `description`, `element_id`, `element_key`, `active`, `sorting`) VALUES
(814, 77, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض النسخة الاحتياطية', 0, '', 1, 9),
(815, 77, 'انتبه', 'يجب الانتباه لحجم النسخ الاحتياطية دائما لأنه عند تجاوز الحجم المسموح به. يقوم النظام بعدم السماح لك بإنشاء نسخة احتياطية جديدة. وبالتالي قم بإنشاء نسخة احتياطية عند الضرورة فقط. علما أن النظام يقوم بإنشاء نسخة أحتياطية قبل القيام بعملية تدوير بيانات دورة مالية معينة.', 0, '.info-box', 1, 4),
(816, 78, 'التعليمات', 'يجب قراءة هذه التعليمات بدقة. قبل القيام بعملية إنشاء نسخة احتياطية لأنها ستسهل عليك العملية كثيرا.', 0, '#info-message', 1, 2),
(817, 78, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة لإنشاء نسخة احتياطية جديدة', 0, '', 1, 1),
(818, 78, 'اسم النسخة الاحتياطية', 'قم بإدخال اسم النسخة الاحتياطية المراد إنشاءها.', 0, '#backup_name', 1, 3),
(819, 78, 'ملاحظات النسخة الاحتياطية', 'قم بإدخال وصف النسخة الاحتياطية . (وصف دقيق لحالة النظام قبل عملية إنشاء النسخة الاحتياطية). من أجل المساعدة في معرف والاستدلال للنسخة الاحتياطية عند الحاجة للبحث عن نسخة احتياطية معينة من أجل استرجاعها لسبب ما.', 0, '#backup_notes', 1, 4),
(820, 78, 'البدأ بعملية إنشاء النسخة الاحتياطية', 'عند الضغط على هذا الزر يبدأ النظام بإنشاء نسخة احتياطية.', 0, '#submit-btn', 1, 5),
(821, 78, 'الرجوع', 'عند الحاجة للرجوع وعدم اكمال إنشاء  النسخة الاحتياطية يمكن الرجوع لصفحة عرض النسخ الاحتياطية من هنا.', 0, '#go-back', 1, 6),
(822, 78, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, 7),
(823, 79, 'البداية', 'في هذه الجولة سنوضح لك بعض الأمور الاساسية المساعدة بإدارة حسابك مع شركة محاسبة.', 0, '', 1, NULL),
(824, 79, 'معلومات حسابك', 'معلومات حسابك المشترك فيه مع موقع محاسبة.', 0, '#account_information', 1, NULL),
(825, 79, 'معلومات الإشتراك', 'هذه المعلومات تبين نوع الإشتراك و مدته. وتاريخ انتهاء الاشتراك.', 0, '#subscribe_information', 1, NULL),
(826, 79, 'معلومات الباقة', 'هذه قائمة بعناصر الباقة التي اشتركت بها. وتبين مدى استهلاك كل منها حتى الآن', 0, '#package_information', 1, NULL),
(827, 79, 'طلب دومين جديد', 'يمكن التواصل مع فريق محاسبة وطلب دومين جديد من هنا', 0, '#DomainRequestBtn', 1, NULL),
(828, 79, 'راسل فريق محاسبة', 'يمكن إراسل إيميل إلى فريق محاسبة في أي وقت.', 0, '#MailMohasabehTeamBtn', 1, NULL),
(829, 79, 'طلب تجديد', 'يمكن ارسال طلب تجديد الاشتراك أو تغييره من هنا', 0, '#RenewalRequestBtn', 1, NULL),
(830, 79, 'النهاية', 'لقد انتهت الجولة. شكرا جزيلا', 0, '', 1, NULL),
(831, 80, 'البداية', 'هذا الموديول يقوم بعرض إشعارات إستلام المواد التي ترسل إلى مستودعاتك بموجب عملية نقل مواد. علماأنه يمكن استلام المواد المرسلة إلى مستودع ما من قبل أي من المشرفين عليه (المندوبين).', 0, '', 1, 1),
(832, 80, 'أزرار لإدارة إشعار الاستلام', 'يمكن مشاهدة تفاصيل عملية نقل المواد و تأكيد الاستلام المواد و مشاهدة التعليقات من هنا', 3, '', 1, 4),
(837, 81, 'البداية', 'سنعرض لك اقسام صفحة تفصيل إشعار استلام المواد', 0, '', 1, 1),
(838, 81, 'تفصيل عملية النقل', 'قسم عرض بيانات عملية النقل المرسل إليك من قبل أحد المستخدمين الأخرين.', 0, '#parent-form-area', 1, 2),
(833, 80, 'الفرز والتصفية', 'يمكنك الاستفادة من ميزات الفرز والتصفية لفلترة النتائج والبحث ضمنها.', 10, '', 1, 5),
(834, 80, 'البحث باستخدام الكلمات', 'يمكنك البحث عن  إشعار معين من خلال استخدام حقل البحث وكتابة بعض الكلمات المفتاحية للبحث عنها ضمن نتيجة البحث.', 12, '', 1, 6),
(835, 80, 'تغيير عدد الإشعارات التي تظهر بالصفحة', 'يمكنك التحكم بعدد الإشعارات التي تظهر ضمن الصفحة الواحدة من هنا', 13, '', 1, 7),
(836, 80, 'النهاية', 'لقد انتهت الجولة ضمن موديول إشعارات استلام المواد', 0, '', 1, 8),
(839, 81, 'قسم عرض حالة إشعار استلام المواد', 'هذا القسم يقوم بعرض حالة إشعار استلام المواد (هل تم استلامها كليا أو جزئيا أم لم يتم استلام المواد بعد). ويتيح لك تأكيد استلام المواد. ويعرض من قام بعملية الاستلام وتاريخ الاستلام.', 0, '#content_section .col-sm-6 > .panel:nth-child(2)', 1, 3),
(840, 81, 'قسم معلومات الوثيقة', 'هذا القسم يقوم بعرض معلومات الوثيقة (من قام بإعدادها، من قام بالتعديل عليها، من قام بتأكيد استلامها ... الخ)', 0, '#content_section .col-sm-6 > .panel:nth-child(4)', 1, 5),
(841, 81, 'قسم الإجراءات المتاحة', 'هذا القسم يعرض جميع الإجراءات المساعدة للتعامل مع الإشعار', 0, '.detail-page-btns', 1, 6),
(842, 81, 'النهاية', 'لقد انتهت الجولة ضمن صفحة عرض إشعار استلام المواد', 0, '', 1, 8),
(843, 81, 'العودة إلى قائمة إشعارات استلام المواد', 'يمكن العودة إلى قائمة إشعارات استلام المواد من هنا', 9, '', 1, 7),
(844, 81, 'إضافة ملاحظات على عملية الاستلام', 'في حال وجود أي إشكالية أو ملاحظة على عملية الاستلام يمكن ارسال رسالة لمرسل المواد من هنا.', 0, '#content_section .col-sm-6 > .panel:nth-child(3)', 1, 4),
(845, 82, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(846, 82, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(847, 82, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(848, 82, 'متابعة حساب صندوقك', 'يمكنك متابعة حساب صندوقك من الصفحة الرئيسية للموقع. بالإضافة يمكنك متابعة أرصدة عملائك بشكل يومي. وتظهر إشعارات القبض وإشعارات استلام المواد ضمن قسم مخصص لها.', 0, '', 1, NULL),
(849, 82, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(850, 82, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(853, 83, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(852, 82, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL),
(854, 83, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(855, 83, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(856, 83, 'متابعة حساب صندوقك', 'يمكنك متابعة حساب صندوقك من الصفحة الرئيسية للموقع. بالإضافة يمكنك متابعة أرصدة عملائك بشكل يومي. وتظهر إشعارات القبض وإشعارات استلام المواد ضمن قسم مخصص لها.', 0, '', 1, NULL),
(857, 83, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(858, 83, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(859, 83, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL),
(860, 84, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(861, 84, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(862, 84, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(863, 84, 'متابعة حساب صندوقك', 'يمكنك متابعة حساب صندوقك من الصفحة الرئيسية للموقع. بالإضافة يمكنك متابعة أرصدة عملائك بشكل يومي. وتظهر إشعارات القبض وإشعارات استلام المواد ضمن قسم مخصص لها.', 0, '', 1, NULL),
(864, 84, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(865, 84, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(866, 84, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL),
(867, 85, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(868, 85, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(869, 85, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(870, 85, 'متابعة حسابات الزبائن', 'يمكنك متابعة أرصدة عملائك بشكل يومي على الصفحة الرئيسية. وتظهر إشعارات استلام المواد ضمن قسم مخصص لها.', 0, '', 1, NULL),
(874, 86, 'البداية', 'شكرا لاختيارك نظام المحاسبة لإدارة أعمالك. نظام المحاسبة يوفر الكثير من الميزات التي ستساعدك على إدارة بياناتك من حسابات و فواتير و سندات و إدارة المستودعات والمواد. ويوفر العديد من التقارير التي ستساعدك بتتبع أعمالك.', 0, '', 1, NULL),
(871, 85, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(872, 85, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(873, 85, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL),
(875, 86, 'القسم الخاص بالمستخدم', 'بالضغط على هذا القسم تظهر لك نافزة تحوي مجموعة من الأزرار التي تسمح لك بمجموعة من المهام مثل مشاهدة البروفايل و تسجيل الخروج و إغلاق الشاشة في حال التوقف عن العمل مؤقتا.', 0, '.user-menu', 1, NULL),
(876, 86, 'التنقل', 'يمكنك انتقال بين الصفحات من خلال هذا القسم بالضغط على الصفحة المراد الدخول لها.', 0, '.sidebar', 1, NULL),
(877, 86, 'متابعة حساب صندوقك', 'يمكنك متابعة حساب صندوقك من الصفحة الرئيسية للموقع. بالإضافة يمكنك متابعة أرصدة عملائك بشكل يومي. وتظهر إشعارات القبض وإشعارات استلام المواد ضمن قسم مخصص لها.', 0, '', 1, NULL),
(878, 86, 'توسيع صفحة العمل', 'بالضغط على هذا الزر يمكن التحكم بعرض صفحة العمل', 0, '#SideBarToggle', 1, NULL),
(879, 86, 'الاستفادة من التتوريل', 'يوفر النظام تتوريل لجميع صفحات النظام يمكنك الاستفادة منه من خلال الضغط على هنا', 0, '#StartTour', 1, NULL),
(880, 86, 'النهاية', 'انتهت جولتنا ضمن الصفحة الرئيسية . لا تنسى أنه يمكن الاستفادة من التتوريل ضمن اي صفحة من صفحات الموقع لتساعدك بإدارة بياناتك.', 0, '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours_steps_elements`
--

DROP TABLE IF EXISTS `tours_steps_elements`;
CREATE TABLE IF NOT EXISTS `tours_steps_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `element_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours_steps_elements`
--

INSERT INTO `tours_steps_elements` (`id`, `name`, `element_key`, `active`, `sorting`) VALUES
(1, 'رسالة التنبيه', '#massege-info', 1, NULL),
(2, 'زر الإضافة', '#btn_add_new_data', 1, NULL),
(3, 'أزرار التحكم بالعناصر عرض، تعديل ، حذف', '.button_action', 1, NULL),
(4, 'زر عرض الأبناء ضمن الشجرة', '.indicator', 1, NULL),
(5, 'استمارة الإضافة أو التعديل', '#parent-form-area', 1, NULL),
(6, 'زر حفظ أو تعديل', '#btn-save-data', 1, NULL),
(7, 'زر للخلف', '#btn-back', 1, NULL),
(8, 'زر حفظ وإضافة المزيد', '#btn-save-more', 1, NULL),
(9, 'عودة إلى قائمة البيانات', '#go-back', 1, NULL),
(10, 'الفرز والتصفية', '#btn_advanced_filter', 1, NULL),
(17, 'إضافة إلى السلة', '#btn-add-table-adafmad', 1, NULL),
(12, 'حقل البحث', '#box-tool-search', 1, NULL),
(13, 'قسم تحديد عدد العناصر بالصفحة الواحدة', '#form-limit-paging', 1, NULL),
(14, 'التنقل بين صفحات الجدول', '.pagination', 1, NULL),
(16, 'الأجراء الجماعي', '.selected-action', 1, NULL),
(18, 'إعادة تعيين', '#btn-reset-form-adafmad', 1, NULL),
(19, 'جدول تفاصيل المواد المختارة', '#table-adafmad', 1, NULL),
(20, 'اضافة صورة الفاتورة', '#adafsorfile_id', 1, NULL),
(21, 'حقل اجمالي الفاتورة', '#form-group-amount', 1, NULL),
(22, 'حقل الحسم', '#form-group-discount', 1, NULL),
(23, 'حقل اجمالي الفاتورة بعد الحسم', '#form-group-after_discount', 1, NULL),
(24, 'حالة الفاتورة', '#form-group-status', 1, NULL),
(25, 'حقل رقم الفاتورة', '#form-group-bill_number', 1, NULL),
(26, 'حقل المستودع', '#form-group-inventory_id', 1, NULL),
(27, 'حقل العملة', '#form-group-currency_id', 1, NULL),
(28, 'حقل سعر الصرف', '#form-group-ex_rate', 1, NULL),
(29, 'حقل طريقة الدفع', '#form-group-is_cash', 1, NULL),
(30, 'إضافة مادة جديدة للفاتورة', '#form-group-adafmad .child-form-area', 1, NULL),
(33, 'جدول المرفقات', '#table-adafsor', 1, NULL),
(34, 'حقل المادة مجانية', '#adafmad_is_free', 1, NULL),
(35, 'زر استيراد البيانات', '#astyrad-albyanat', 1, NULL),
(36, 'رقم السند', '#form-group-voucher_number', 1, NULL),
(37, 'إضافة مرفق للسند', '#adafsorfile_id', 1, NULL);

-- --------------------------------------------------------
--
-- Table structure for table `transfer_items_list`
--
DROP TABLE IF EXISTS `transfer_items_list`;
CREATE TABLE `transfer_items_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_tracking_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(50,2) NOT NULL,
  `p_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
  `active` int(11) DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `transfer_tracking`
--
DROP TABLE IF EXISTS `transfer_tracking`;
CREATE TABLE `transfer_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_number` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delegate_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '1',
  `receipt_date` TIMESTAMP NULL DEFAULT NULL,
  `receipt_by` INT(11) NOT NULL DEFAULT '0',
  `cycle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_tracking_notes`
--

DROP TABLE IF EXISTS `transfer_tracking_notes`;
CREATE TABLE IF NOT EXISTS `transfer_tracking_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_tracking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `p_code` varchar(50) NOT NULL,
  `voucher_number` varchar(200) DEFAULT NULL,
  `voucher_type_id` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `credit` int(11) NOT NULL,
  `delegate_id` int(11) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `narration` varchar(50) NOT NULL,
  `date` datetime DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` decimal(50,2) NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `sorting` int(11) DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '1',
  `receipt_date` TIMESTAMP NULL DEFAULT NULL,
  `receipt_by` INT(11) NOT NULL DEFAULT '0',
  `checked_for_update` tinyint(4) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `edit_at` timestamp NULL DEFAULT NULL,
  `edit_by` int(11) NOT NULL DEFAULT '0',
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) NOT NULL DEFAULT '0',
  `action` varchar(20) DEFAULT NULL,
  `cycle_id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name_ar`, `name_en`, `prefix`, `active`, `sorting`) VALUES
(1, 'سند قبض', 'receipt voucher', 'RV-', 1, NULL),
(2, 'سند دفع', 'payment voucher', 'PV-', 1, NULL),
(3, 'سند تحويل', 'transfer voucher', 'TV-', 1, NULL),
(4, 'سند افتتاحي', 'initial voucher', 'IV-', 1, NULL),
(5, 'سند يومي', 'daily voucher', 'DV-', 1, NULL),
(6, 'سند تصريف', 'exchange voucher', 'EV-', 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
