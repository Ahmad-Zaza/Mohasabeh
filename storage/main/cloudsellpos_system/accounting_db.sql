-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2022 at 08:17 AM
-- Server version: 8.0.26
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `name_en` varchar(500) DEFAULT NULL,
  `name_ar` varchar(500) DEFAULT NULL,
  `code` bigint DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `major_classification` tinyint DEFAULT '1',
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `person_id` int DEFAULT NULL,
  `base` tinyint DEFAULT '0',
  `currency_id` int DEFAULT NULL,
  `closing_account_type` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `person_id`, `base`, `currency_id`, `closing_account_type`) VALUES
(1, NULL, 'الأصول', 1, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(2, NULL, 'الزبائن', 12, 1, 1, 1, NULL, NULL, 0, NULL, NULL),
(3, NULL, 'زبائن دمشق', 1201, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(4, NULL, 'زبائن أيمن نجار ', 1202, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(5, NULL, 'زبائن سمير', 1203, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(6, NULL, 'زبائن د. أحمد قباطي', 1204, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(7, NULL, 'زبائن اسامة طاهر', 1205, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(8, NULL, 'زبائن فراس قدور', 1206, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(9, NULL, 'زبائن شادي فروح', 1207, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(10, NULL, 'زبائن مصعب الحسين', 1208, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(11, NULL, 'زبائن عيسى احمد', 1209, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(12, NULL, 'زبائن محمود الخطيب', 1210, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(13, NULL, 'زبائن أحمد الابراهيم', 1211, 2, 1, 1, NULL, NULL, 0, NULL, NULL),
(14, NULL, 'حسابات النقدية', 13, 1, 1, 1, NULL, NULL, 0, NULL, NULL),
(15, NULL, 'الصندوق', 1301, 14, 0, 1, NULL, NULL, 0, NULL, NULL),
(16, 'dollar box', 'صندوق الدولار', 1302, 14, 0, 1, NULL, NULL, 0, NULL, NULL),
(17, 'euro box', 'صندوق اليورو', 1303, 14, 0, 1, NULL, NULL, 0, NULL, NULL),
(18, NULL, 'حسابات نقدية المندوبين', 14, 1, 1, 1, NULL, NULL, 0, NULL, NULL),
(19, NULL, 'صندوق ايمن نجار', 1401, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(20, NULL, 'صندوق سمير ', 1402, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(21, NULL, 'صندوق أحمد قباطي', 1403, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(22, NULL, 'صندوق اسامة طاهر', 1404, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(23, NULL, 'صندوق مصعب الحسين', 1405, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(24, NULL, 'صندوق عيسى احمد', 1406, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(25, NULL, 'صندوق فراس قدور', 1407, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(26, NULL, 'صندوق محمود الخطيب', 1408, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(27, NULL, 'صندوق احمد الابراهيم', 1409, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(28, NULL, 'المصروفات', 3, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(29, NULL, 'مصروف سيارة المندوب', 301, 28, 0, 1, NULL, NULL, 0, NULL, NULL),
(30, NULL, 'اجور شحن ومصروف مبيعات', 302, 28, 0, 1, NULL, NULL, 0, NULL, NULL),
(31, NULL, 'مصاريف مختلفة ', 303, 28, 0, 1, NULL, NULL, 0, NULL, NULL),
(32, NULL, 'حسابات المواد', 4, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(33, NULL, 'مشتريات', 401, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(34, NULL, 'مردود مشتريات', 402, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(35, NULL, 'مبيعات', 403, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(36, NULL, 'مردود مبيعات', 404, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(37, NULL, 'الحسم الممنوح', 405, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(38, NULL, 'الحسم المكتسب', 406, 32, 0, 1, NULL, NULL, 0, NULL, NULL),
(39, NULL, 'توفيق المصري - حماه - قديم', 120101, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(40, NULL, 'دحام الكيصوم', 120102, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(41, NULL, 'باسم الكور', 120103, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(42, NULL, 'خالد عمران', 120104, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(43, NULL, 'صلاح عياش', 120105, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(44, NULL, 'محمود مجركش', 120106, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(45, NULL, 'حمادي حمادي', 120107, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(46, NULL, 'علي عبد الله', 120108, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(47, NULL, 'علي حيدر', 120109, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(48, NULL, 'عبد الرحمن ديكو', 120110, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(49, NULL, 'خالد الساكت', 120111, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(50, NULL, 'خالد زرقان', 120112, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(51, NULL, 'اغيد سحلول', 120113, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(52, NULL, 'حسن عبود', 120114, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(53, NULL, 'البعلبكي للزراعة', 120115, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(54, NULL, 'شركة جهاد الشامي', 120116, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(55, NULL, 'الشركة الوطنية للتطوير الزراعي', 120117, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(56, NULL, 'خليل خطاب', 120118, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(57, NULL, 'صلاح حلواني', 120119, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(58, NULL, 'جودت العسكري', 120120, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(59, NULL, 'علي الكيلاني', 120121, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(60, NULL, 'عدنان عرسان', 120122, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(61, NULL, 'بشار الطباع', 120123, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(62, NULL, 'عمار مجركش', 120124, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(63, NULL, 'حسن السيد', 120125, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(64, NULL, 'ناصر الطوالبة - نوى', 120126, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(65, NULL, 'توفيق المصري - حماه - جديد', 120127, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(66, NULL, 'توفيق المصري / سولفيرتو - حماه - جديد', 120128, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(67, NULL, 'باسم الأحمد', 120129, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(68, NULL, 'حسن السيد ل.س', 120130, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(69, NULL, 'محمود الحمران', 120131, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(70, NULL, 'اتحاد غرف الزراعة', 120132, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(71, NULL, 'علي نصر الله - جديد-', 120133, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(72, NULL, 'امجد قويدر', 120134, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(73, NULL, 'عرفان زيادة', 120135, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(74, NULL, 'احمد خلوف', 120136, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(75, NULL, 'عدنان الملك', 120137, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(76, NULL, 'خليل خطاب - جديد -', 120138, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(77, NULL, 'حسين العلاوي - قديم', 120139, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(78, NULL, 'العامرة المنطقة الشرقية - بودرة', 120140, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(79, NULL, 'فريد الصلخدي', 120141, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(80, NULL, 'العامرة المنطقة الشرقية - جل', 120142, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(81, NULL, 'العامرة المنطقة الشرقية - بذور', 120143, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(82, NULL, 'العامرة المنطقة الشرقية - متفرقات', 120144, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(83, NULL, 'شادي متوج', 120145, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(84, NULL, 'سيتان الجندي', 120146, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(85, NULL, 'صالح الشبلي', 120147, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(86, NULL, 'موسى الجرخ', 120148, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(87, NULL, 'محمد الشاويش - معدان الكمية - حلب', 120149, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(88, NULL, 'قاسم وفا - ضمير - قديم', 120150, 3, 0, 1, NULL, NULL, 0, NULL, NULL),
(89, NULL, 'ابراهيم البردان', 120301, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(90, NULL, 'ابراهيم قهوجي - درعا - قديم', 120302, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(91, NULL, 'ابو معروف رجب', 120303, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(92, NULL, 'احمد السعدي ', 120304, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(93, NULL, 'احمد العيشات', 120305, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(94, NULL, 'احمد حاج علي - جديد', 120306, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(95, NULL, 'احمد حوراني - جديد', 120307, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(96, NULL, 'احمد عبد الرزاق الزعبي', 120308, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(97, NULL, 'احمد كامل الزعبي - حديد', 120309, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(98, NULL, 'اياد عساوده', 120310, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(99, NULL, 'اياد نابلسي - قديم', 120311, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(100, NULL, 'بسام برمو', 120312, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(101, NULL, 'بلال مبارك - جاسم', 120313, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(102, NULL, 'جمال نابلسي -قديم-', 120314, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(103, NULL, 'حسام خريبة - جديد', 120315, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(104, NULL, 'حسان العاسمي', 120316, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(105, NULL, 'حمدان الحسن - درعا - قديم', 120317, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(106, NULL, 'خليل البردان - درعا - قديم', 120318, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(107, NULL, 'راني كيوان - قديم', 120319, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(108, NULL, 'رياض ربداوي - جديد', 120320, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(109, NULL, 'سالم النجار - جديد', 120321, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(110, NULL, 'سامح حرندين', 120322, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(111, NULL, 'سفيان نصيرات - جديد', 120323, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(112, NULL, 'صهيب الربداوي', 120324, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(113, NULL, 'طلحة ابو سعيفان - جديد', 120325, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(114, NULL, 'عبد الله غزالي - جديد', 120326, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(115, NULL, 'عبد الناصر الخبي', 120327, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(116, NULL, 'عبد الناصر كيوان', 120328, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(117, NULL, 'علي البردان - جديد', 120329, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(118, NULL, 'علي الشرف -نصيب-', 120330, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(119, NULL, 'عماد الشريف', 120331, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(120, NULL, 'عمر جباوي', 120332, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(121, NULL, 'فادي الزعبي - جديد', 120333, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(122, NULL, 'فايز ابو نعيم - جديد', 120334, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(123, NULL, 'قاسم ابو شنب - قديم', 120335, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(124, NULL, 'قاسم أبو حوران', 120336, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(125, NULL, 'قاسم مفعلاني - قديم - درعا', 120337, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(126, NULL, 'قصي النعسان', 120338, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(127, NULL, 'كمال الزعبي - قديم', 120339, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(128, NULL, 'كمال فالح الزعبي - جديد', 120340, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(129, NULL, 'م . عمران السموري', 120341, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(130, NULL, 'م. محمد نور برمو', 120342, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(131, NULL, 'م.محمد النوفل', 120343, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(132, NULL, 'مجيد النوفل - درعا', 120344, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(133, NULL, 'محمد الزعبي - جديد', 120345, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(134, NULL, 'محمد الصفوري - جديد', 120346, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(135, NULL, 'محمد جباوي', 120347, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(136, NULL, 'محمد خريبة - جديد', 120348, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(137, NULL, 'محمد قهوجي', 120349, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(138, NULL, 'محمد كامل الزعبي -قديم', 120350, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(139, NULL, 'محمد كيوان', 120351, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(140, NULL, 'محمود ابو نقطة - جديد', 120352, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(141, NULL, 'محمود الناطور', 120353, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(142, NULL, 'محمود سليمان - درعا', 120354, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(143, NULL, 'محمود كامل الزعبي', 120355, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(144, NULL, 'مصعب الزعبي -قديم -', 120356, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(145, NULL, 'معاذ برمو - جديد', 120357, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(146, NULL, 'معاذ كيوان', 120358, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(147, NULL, 'موسى البيطاري - جديد', 120359, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(148, NULL, 'ناصر محمد النابلسي', 120360, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(149, NULL, 'نبيل عيشات - جديد', 120361, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(150, NULL, 'نسيم ربداوي', 120362, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(151, NULL, 'هايل العوض', 120363, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(152, NULL, 'هشام نابلسي', 120364, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(153, NULL, 'وسيم العاسمي', 120365, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(154, NULL, 'وسيم حريذين', 120366, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(155, NULL, 'ياسر ابو خروب', 120367, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(156, NULL, 'ياسين الصبح', 120368, 5, 0, 1, NULL, NULL, 0, NULL, NULL),
(157, NULL, 'اَلان بشارة', 120501, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(158, NULL, 'ابراهيم حسن', 120502, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(159, NULL, 'ابراهيم شاهين قديم', 120503, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(160, NULL, 'احمد اسماعيل - قديم', 120504, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(161, NULL, 'احمد حيدر - جبلة - جديد', 120505, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(162, NULL, 'احمد خضر - جديد', 120506, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(163, NULL, 'احمد صبحي -جديد-', 120507, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(164, NULL, 'احمد عبيد -جديد-', 120508, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(165, NULL, 'احمد غنوم - بانياس', 120509, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(166, NULL, 'اسامة اسماعيل - بانياس - جديد', 120510, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(167, NULL, 'اكرم عابده -قديم', 120511, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(168, NULL, 'المهندس احمد امين - جديد', 120512, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(169, NULL, 'المهندس خضر احمد', 120513, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(170, NULL, 'المهندس رامز حسن - جديد', 120514, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(171, NULL, 'المهندس سليمان ناصر- قديم', 120515, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(172, NULL, 'المهندس عصام ديب - جديد', 120516, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(173, NULL, 'المهندس علي ابراهيم - جديد', 120517, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(174, NULL, 'المهندس علي عباس - قديم', 120518, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(175, NULL, 'المهندس علي محمد - جديد', 120519, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(176, NULL, 'المهندس مازن برو - جديد', 120520, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(177, NULL, 'المهندس ماهر حمد', 120521, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(178, NULL, 'المهندس نور الدين علي - جديد', 120522, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(179, NULL, 'المهندس وسام جبور - جديد', 120523, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(180, NULL, 'ايهاب مهنا - جديد', 120524, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(181, NULL, 'جمال دراج', 120525, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(182, NULL, 'جهاد صعبية - جبلة', 120526, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(183, NULL, 'حسام يا شوطي', 120527, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(184, NULL, 'حيدر خليل - اللاذقية', 120528, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(185, NULL, 'خليل خليل - جبلة', 120529, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(186, NULL, 'خيرات قدور-جديد-', 120530, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(187, NULL, 'د. احمد الصالح - جديد', 120531, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(188, NULL, 'د. حيدر شاهين - جديد', 120532, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(189, NULL, 'رامي الشغري - بانياس', 120533, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(190, NULL, 'رجب العلي - طرطوس- جديد', 120534, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(191, NULL, 'رفعت محفوض', 120535, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(192, NULL, 'رفعت محفوض -جديد', 120536, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(193, NULL, 'زياد سعد - جبلة', 120537, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(194, NULL, 'سامر احمد', 120538, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(195, NULL, 'سامر عبد الكريم - حريصون', 120539, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(196, NULL, 'سامر علوش', 120540, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(197, NULL, 'سليمان ناصر جديد', 120541, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(198, NULL, 'سيمون يعقوب -جديد-', 120542, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(199, NULL, 'شادي رسلان - بانياس', 120543, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(200, NULL, 'شعبان عيسى -قديم', 120544, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(201, NULL, 'عبد الكريم (أجمية ) - طرطوس - جديد', 120545, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(202, NULL, 'عبد الكريم غانم', 120546, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(203, NULL, 'علاء ونوس', 120547, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(204, NULL, 'علي منصور - الخراب', 120548, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(205, NULL, 'عيسى عيسى - حريصون - جديد', 120549, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(206, NULL, 'عيسى عيسى طرطوس جديد', 120550, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(207, NULL, 'غاندي داغر - البلاطة غربية', 120551, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(208, NULL, 'غاندي شاهين', 120552, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(209, NULL, 'فادي بجود', 120553, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(210, NULL, 'فراس حسين - الخراب - جديد', 120554, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(211, NULL, 'فراس حسين - الخراب - قديم', 120555, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(212, NULL, 'فراس حسين - طرطوس - جديد', 120556, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(213, NULL, 'فؤاد عيسى - جبلة - جديد', 120557, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(214, NULL, 'قتيبة درويش - جديد', 120558, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(215, NULL, 'كامل فوس - طرطوس - قديم', 120559, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(216, NULL, 'كرم نجار - طرطوس - جديد', 120560, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(217, NULL, 'لؤي حسين- طرطوس', 120561, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(218, NULL, 'م. عبد المنعم عباس - قديم', 120562, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(219, NULL, 'م. غسان حسن $', 120563, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(220, NULL, 'ماجد الحسين-قديم -', 120564, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(221, NULL, 'ماهر حمد قديم', 120565, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(222, NULL, 'محسن ترسيسي - جديد', 120566, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(223, NULL, 'محمد خليل - البيضة - مشتل البركة', 120567, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(224, NULL, 'محمد خليل - بانياس - جديد', 120568, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(225, NULL, 'محمد خير رسول - النبك', 120569, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(226, NULL, 'محمد صهيوني - طرطوس - قديم', 120570, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(227, NULL, 'محمد عبدو طجمية', 120571, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(228, NULL, 'محمد علي -قديم-', 120572, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(229, NULL, 'محمد قزيمة -جديد-', 120573, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(230, NULL, 'محمود الشيخ جديد', 120574, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(231, NULL, 'محمود الشيخ طرطوس', 120575, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(232, NULL, 'مروان حمود', 120576, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(233, NULL, 'معن دياب -قديم-', 120577, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(234, NULL, 'منصور اسماعيل - جديد', 120578, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(235, NULL, 'موسى فارس - الخراب', 120579, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(236, NULL, 'نادر ديوب - بانياس - جديد', 120580, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(237, NULL, 'نبيل قزيمة - جديد', 120581, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(238, NULL, 'نزار حسين - الخراب', 120582, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(239, NULL, 'نضال ديب', 120583, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(240, NULL, 'هاني شاهين - طرطوس', 120584, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(241, NULL, 'وسيم درميني', 120585, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(242, NULL, 'وسيم عيسى -جديد-', 120586, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(243, NULL, 'ياسر وحود - بانياس', 120587, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(244, NULL, 'يوسف الموعي', 120588, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(245, NULL, 'يوسف عفيف - جبلة - جديد', 120589, 7, 0, 1, NULL, NULL, 0, NULL, NULL),
(246, NULL, 'ابراهيم الدايخ - محردة - جديد', 1207001, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(247, NULL, 'ابراهيم الضامن -جديد', 1207002, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(248, NULL, 'ابراهيم خضر', 1207003, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(249, NULL, 'ابراهيم نجار - محردة', 1207004, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(250, NULL, 'ابراهيم وسيل', 1207005, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(251, NULL, 'ابراهيم ونوس - قلعة جراس - قديم', 1207006, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(252, NULL, 'احمد اسبر - جديد', 1207007, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(253, NULL, 'احمد العتمان - حلفايا', 1207008, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(254, NULL, 'احمد سلطان الابراهيم', 1207009, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(255, NULL, 'احمد عثمان', 1207010, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(256, NULL, 'ادريس ادريس - مصياف', 1207011, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(257, NULL, 'اديب سعيد - السقيلبية', 1207012, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(258, NULL, 'اديب عليشة جديد', 1207013, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(259, NULL, 'اسامة خير بيك - الصقيلبية', 1207014, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(260, NULL, 'اسامة غريب', 1207015, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(261, NULL, 'اسكندر علي', 1207016, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(262, NULL, 'اصف عبد الناصر - المحروسة', 1207017, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(263, NULL, 'اكرم الخليف', 1207018, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(264, NULL, 'اكرم الملحم قديم', 1207019, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(265, NULL, 'الياس الياس', 1207020, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(266, NULL, 'امير عيسى - عين الكروم - قديم', 1207021, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(267, NULL, 'امين اسماعيل - نهر البارد - جديد', 1207022, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(268, NULL, 'انس سوتل', 1207023, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(269, NULL, 'باسل محمد - الصارمية', 1207024, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(270, NULL, 'بسام اليوسف - تيزين', 1207025, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(271, NULL, 'بسيم البودي', 1207026, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(272, NULL, 'بهيج النونو', 1207027, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(273, NULL, 'جرجس نصار - كفربو', 1207028, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(274, NULL, 'جمال المرعي', 1207029, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(275, NULL, 'جهاد الحمود', 1207030, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(276, NULL, 'حسام معلا - سلحب', 1207031, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(277, NULL, 'حسن المحمود - المحروسة', 1207032, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(278, NULL, 'حسين القليح', 1207033, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(279, NULL, 'خالد المصطفى', 1207034, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(280, NULL, 'خطاب القاسم - محردة', 1207035, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(281, NULL, 'خليل ضاهر - محردة', 1207036, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(282, NULL, 'رامز حمادة - المحروسة', 1207037, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(283, NULL, 'ربيع سليمان - الربيعة', 1207038, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(284, NULL, 'رضوان الرضوان - قديم', 1207039, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(285, NULL, 'رياض المحمود', 1207040, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(286, NULL, 'زكريا الاحمد', 1207041, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(287, NULL, 'زياد زرزور - محردة', 1207042, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(288, NULL, 'زياد عابده - خطاب - قديم', 1207043, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(289, NULL, 'سامر يعقوب - محردة', 1207044, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(290, NULL, 'سعد سعد', 1207045, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(291, NULL, 'سعود صوان - البياضية', 1207046, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(292, NULL, 'سلطان عيسى', 1207047, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(293, NULL, 'سليم عاصي', 1207048, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(294, NULL, 'سليمان المحمود - المحروسة', 1207049, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(295, NULL, 'سليمان المحمود -قديم', 1207050, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(296, NULL, 'سمير الجداوي - سلحب', 1207051, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(297, NULL, 'شادي حمود - الربيعة', 1207052, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(298, NULL, 'ضرار المحمود / عماد النعسان - السقيلبية', 1207053, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(299, NULL, 'طلال ابراهيم - كفربو - جديد', 1207054, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(300, NULL, 'عامر المصطفى - كرناز', 1207055, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(301, NULL, 'عبد الرحمن الشقيع', 1207056, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(302, NULL, 'عبد العزيز المحمد - جركيس', 1207057, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(303, NULL, 'عبد الكريم كرنازي - شيزر', 1207058, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(304, NULL, 'عبد الله الطالب', 1207059, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(305, NULL, 'عبد الله خباص', 1207060, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(306, NULL, 'عبد الله سوقية - صفصافية', 1207061, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(307, NULL, 'عبد المعطي الحسين', 1207062, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(308, NULL, 'عبد المعين غزال - خطاب', 1207063, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(309, NULL, 'عبد الهادي غزال', 1207064, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(310, NULL, 'عبدالله الطالب -قديم', 1207065, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(311, NULL, 'عبدو مرعي -نهر البارد-جديد', 1207066, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(312, NULL, 'عدي حيدر', 1207067, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(313, NULL, 'عروة ديوب', 1207068, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(314, NULL, 'عصام محفوض', 1207069, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(315, NULL, 'علاء الاطرش', 1207070, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(316, NULL, 'علاء شحود - جرجرة', 1207071, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(317, NULL, 'علاء عليشة-قديم -', 1207072, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(318, NULL, 'علي الخضر - مصياف', 1207073, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(319, NULL, 'علي ديبو - المحروسة', 1207074, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(320, NULL, 'عماد جماشيري', 1207075, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(321, NULL, 'عماد نعسان جديد', 1207076, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(322, NULL, 'عمار زيود- نبع الضب- جديد محرده', 1207077, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(323, NULL, 'عمر ابراهيم', 1207078, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(324, NULL, 'غسان ديب- عين الكروم محرده -جديد', 1207079, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(325, NULL, 'غسان سلوم - محردة', 1207080, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(326, NULL, 'فادي الخيرات - جديد', 1207081, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(327, NULL, 'فخر الدين المصري', 1207082, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(328, NULL, 'فراس نعوم - كفربهم - جديد', 1207083, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(329, NULL, 'فهد محفوض - كفر بهم- جديد', 1207084, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(330, NULL, 'قتيبة حاصود - حلفايا', 1207085, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(331, NULL, 'كامل محمود - المحروسة', 1207086, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(332, NULL, 'ليلى الحمود - البياضية', 1207087, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(333, NULL, 'متروك الرجب - جديد', 1207088, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(334, NULL, 'مجد السلوم - الصفصافية', 1207089, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(335, NULL, 'محمد الاحمد - كفر هود', 1207090, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(336, NULL, 'محمد المصطفى - جديد', 1207091, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(337, NULL, 'محمد خليل', 1207092, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(338, NULL, 'محمد منصور - الصفصافية - قديم', 1207093, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(339, NULL, 'مدحت النعسان', 1207094, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(340, NULL, 'مضر دومان - سلحب', 1207095, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(341, NULL, 'معتز الحسن - جديد', 1207096, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(342, NULL, 'منهل نصار - السقيلبية', 1207097, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(343, NULL, 'مهند الحسن - الكرامة', 1207098, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(344, NULL, 'مياد سلوم- محردة -جديد', 1207099, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(345, NULL, 'ناصر رمضان', 1207100, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(346, NULL, 'نجوان خيزران', 1207101, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(347, NULL, 'نزار يعقوب - محردة', 1207102, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(348, NULL, 'نزيه ماعود - كفربهم', 1207103, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(349, NULL, 'نضال بكور - جديد', 1207104, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(350, NULL, 'نضال شحود - المحروسة', 1207105, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(351, NULL, 'هشام ميواك', 1207106, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(352, NULL, 'وديع صقر - السقيلبية - جديد', 1207107, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(353, NULL, 'وسيم الاسعد', 1207108, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(354, NULL, 'ياسر الحكيم', 1207109, 9, 0, 1, NULL, NULL, 0, NULL, NULL),
(355, NULL, 'ابراهيم طفور - دوما', 120201, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(356, NULL, 'ابو حسن سعد - ضمير', 120202, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(357, NULL, 'ابو حسن عربية - ضمير', 120203, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(358, NULL, 'ابو علوش - عدرا الصناعية', 120204, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(359, NULL, 'ابو محمد ( صحية )', 120205, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(360, NULL, 'احمد فرحان - عدرا الصناعية', 120206, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(361, NULL, 'اسامة الشيخ - جديد', 120207, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(362, NULL, 'اسامة مهرة', 120208, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(363, NULL, 'اسماعيل بكر', 120209, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(364, NULL, 'اياد نصير - درعا', 120210, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(365, NULL, 'ايهاب زغيب', 120211, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(366, NULL, 'بشير برخش - دوما', 120212, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(367, NULL, 'حازم نصير', 120213, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(368, NULL, 'حسام ادريس', 120214, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(369, NULL, 'خالد رحمة - الشيفونية - جديد', 120215, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(370, NULL, 'خلدون معروف - سوق الهال الجديد', 120216, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(371, NULL, 'خليل عبد الفتاح - الكسوة', 120217, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(372, NULL, 'رجب الاحمد - الضمير', 120218, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(373, NULL, 'سامر اللحام - الغوطة', 120219, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(374, NULL, 'سعيد الوغا', 120220, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(375, NULL, 'سهيل تكروري - جديد', 120221, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(376, NULL, 'صالح المحمد', 120222, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(377, NULL, 'صبحي طه', 120223, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(378, NULL, 'ضاهر عبد النبي - الصبورة', 120224, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(379, NULL, 'ظافر الاحمد', 120225, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(380, NULL, 'عارف الدج - دوما - جديد', 120226, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(381, NULL, 'عامر الزبيبي - سوق الهال', 120227, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(382, NULL, 'عبد الحي الصباغ', 120228, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(383, NULL, 'عبد الله الشبلي - النشابية', 120229, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(384, NULL, 'عبد الله شرف الدين', 120230, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(385, NULL, 'عبدو نكد', 120231, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(386, NULL, 'علاء الشبلي - سوق الهال - قديم', 120232, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(387, NULL, 'علي الصبح ( ربيع الخليل ) - القنية', 120233, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(388, NULL, 'علي سلطان - الشيفونية', 120234, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(389, NULL, 'عماد ابو يزبك - السويداء', 120235, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(390, NULL, 'عمار ادلبي', 120236, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(391, NULL, 'عمار عبد العزيز', 120237, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(392, NULL, 'عوض الخلف - عدرا الصناعية', 120238, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(393, NULL, 'عوني جمعة', 120239, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(394, NULL, 'غسان بطراكي - عدرا', 120240, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(395, NULL, 'غياث طه', 120241, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(396, NULL, 'قاسم طعمة', 120242, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(397, NULL, 'قاسم محمد سرحان - عدرا', 120243, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(398, NULL, 'م. علي نصر الله - سوق الهال', 120244, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(399, NULL, 'مالك شعبان', 120245, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(400, NULL, 'مأمون الاصفر', 120246, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(401, NULL, 'مأمون الحافي', 120247, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(402, NULL, 'محمد الاجوه', 120248, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(403, NULL, 'محمد الصوص', 120249, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(404, NULL, 'محمد زهير أبو جيب - دوما - جديد', 120250, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(405, NULL, 'محمود دعاس', 120251, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(406, NULL, 'مصطفى الأشرف - عدرا', 120252, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(407, NULL, 'مصطفى الصواف - الكسوة', 120253, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(408, NULL, 'مصطفى عبد الواحد', 120254, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(409, NULL, 'مصطفى علي', 120255, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(410, NULL, 'معمر بردان', 120256, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(411, NULL, 'موفق الجوجو', 120257, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(412, NULL, 'موفق شرف - الصبورة', 120258, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(413, NULL, 'هايل مزهر', 120259, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(414, NULL, 'يوسف السعدي - الضمير', 120260, 4, 0, 1, NULL, NULL, 0, NULL, NULL),
(415, NULL, 'ابراهيم رستناوي - صوران - جديد', 120801, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(416, NULL, 'احمد ادريس', 120802, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(417, NULL, 'احمد الصالح - الشيخ علي - جديد', 120803, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(418, NULL, 'احمد الضاهر -قديم-', 120804, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(419, NULL, 'احمد القاسم - سريحين', 120805, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(420, NULL, 'احمد عواد - تلبيسة - جديد', 120806, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(421, NULL, 'اديب عرابي', 120807, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(422, NULL, 'ايمن صويص - تلبيسة - جديد', 120808, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(423, NULL, 'جانيت صنعون', 120809, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(424, NULL, 'جمال سعيد - جرجيسة', 120810, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(425, NULL, 'حسن الشيخ حسن - سلمية - جديد', 120811, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(426, NULL, 'خالد الحميدي - يسيرين', 120812, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(427, NULL, 'خالد العسكري - تل قطا', 120813, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(428, NULL, 'سومر عبود-قديم', 120814, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(429, NULL, 'شادي الفرا-قديم-', 120815, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(430, NULL, 'صفوان السح - حماه - قديم', 120816, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(431, NULL, 'عامر خورشيد-قديم-', 120817, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(432, NULL, 'عامر صوي', 120818, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(433, NULL, 'عبد الرحمن القطميش', 120819, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(434, NULL, 'عبد الرحيم الجمعة - تلبيسة', 120820, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(435, NULL, 'عبد الرزاق النائب - حماه', 120821, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(436, NULL, 'عبد السلام الاكسح - الزعفرانة', 120822, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(437, NULL, 'عبد الكريم المدني -قديم', 120823, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(438, NULL, 'عبد الله مطر - الرستن', 120824, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(439, NULL, 'عبد المنعم الابراهيم -مورك -قديم', 120825, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(440, NULL, 'عبد المنعم السمرة - طيبة الامام', 120826, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(441, NULL, 'عبد المنعم سلورة - حماه', 120827, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(442, NULL, 'عبدالرحمن القطميش -قديم', 120828, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(443, NULL, 'عبدالله مطر -قديم', 120829, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(444, NULL, 'عثمان ايوب -قديم-', 120830, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(445, NULL, 'علاء اليوسف - ضاهرية', 120831, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(446, NULL, 'عمار السرميني - زعفرانة - جديد', 120832, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(447, NULL, 'فراس عدرا - سلمية', 120833, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(448, NULL, 'فرحان الشقفة - حماه', 120834, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(449, NULL, 'لؤي النجار - الرستن', 120835, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(450, NULL, 'محمد الابراهيم - جرجيسة', 120836, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(451, NULL, 'محمد الجرف - سلمية', 120837, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(452, NULL, 'محمد الكفري', 120838, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(453, NULL, 'محمد سودين - قمحانة - جديد', 120839, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(454, NULL, 'محمد شنو - دير الفرديس - جديد', 120840, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(455, NULL, 'محمود الخطيب - تلبيسة', 120841, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(456, NULL, 'مهند اليوسف - زور سريحين - جديد', 120842, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(457, NULL, 'ناصر يحيى - السلمية - جديد', 120843, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(458, NULL, 'هاشم شحود - سلمية - قديم', 120844, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(459, NULL, 'يامن ياسين - معر شحور - جديد', 120845, 10, 0, 1, NULL, NULL, 0, NULL, NULL),
(460, NULL, 'آلان امين - عامودا', 120901, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(461, NULL, 'بلال صالح بركات - القامشلي', 120902, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(462, NULL, 'بهجت محمود - القامشلي', 120903, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(463, NULL, 'ثلاج الكرو - القحطانية', 120904, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(464, NULL, 'جاك حشيشو - الحسكة', 120905, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(465, NULL, 'جمعة عمو - راس العين', 120906, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(466, NULL, 'جنيد شيخي - القامشلي', 120907, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(467, NULL, 'جوان عبد الرحمن - عامودا', 120908, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(468, NULL, 'جوان عيسى احمد - القامشلي', 120909, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(469, NULL, 'حاتم الجوادية - الجوادية', 120910, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(470, NULL, 'حسن حاج ابراهيم - القامشلي', 120911, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(471, NULL, 'حميد عبد العزيز - راس العين', 120912, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(472, NULL, 'حواس دللي - القامشلي', 120913, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(473, NULL, 'خليل حسن - القامشلي - جديد', 120914, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(474, NULL, 'خير الدين اوصمان - القامشلي', 120915, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(475, NULL, 'د. حسين الحنوش - القامشلي - جديد', 120916, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(476, NULL, 'د.اسعد مجباس - الحسكة', 120917, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(477, NULL, 'رائد حناوي - القحطانية', 120918, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(478, NULL, 'زبير حسي - القامشلي', 120919, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(479, NULL, 'زهدي داود - القامشلي', 120920, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(480, NULL, 'سامي عمسو - القامشلي', 120921, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(481, NULL, 'سرباز حاول - القحطانية', 120922, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(482, NULL, 'صالح بركات - القامشلي', 120923, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(483, NULL, 'صلاح حمزة - المالكية', 120924, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(484, NULL, 'ضياء الحق حسين - القحطانية', 120925, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(485, NULL, 'عز الدين خليل - عامودا', 120926, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(486, NULL, 'علاء المرعي - راس العين', 120927, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(487, NULL, 'علي برغوث - ابو راسين', 120928, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(488, NULL, 'فرزند الملا - الدرباسية', 120929, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(489, NULL, 'فواز زيدان - القحطانية', 120930, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(490, NULL, 'كبرئيل اسمان - القامشلي - جديد', 120931, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(491, NULL, 'لاوين سيف الدين - المعبدة', 120932, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(492, NULL, 'لزكين حرسان', 120933, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(493, NULL, 'م.جوزيف كوريه - المالكية', 120934, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(494, NULL, 'م.حسن جمعة - ابو راسين', 120935, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(495, NULL, 'م.محمد جياد - الحسكة - جديد', 120936, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(496, NULL, 'م.محمد عبد العزيز - راس العين', 120937, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(497, NULL, 'محمد حكمي - ابو راسين', 120938, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(498, NULL, 'محمد حمادي - القامشلي', 120939, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(499, NULL, 'محمد شاكر - القحطانية', 120940, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(500, NULL, 'محمود بدرو - راس العين', 120941, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(501, NULL, 'محمود حسن - القامشلي', 120942, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(502, NULL, 'مراد مصطفى - القامشلي', 120943, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(503, NULL, 'مصطفى ابو الصوف - القامشلي', 120944, 11, 0, 1, NULL, NULL, 0, NULL, NULL),
(504, NULL, 'احمد الزير - بانياس - قديم', 120601, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(505, NULL, 'احمد عبيد -قديم', 120602, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(506, NULL, 'اسامة اسماعيل - بانياس - قديم', 120603, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(507, NULL, 'ايهاب مهنا -قديم -', 120604, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(508, NULL, 'باسل سعود -قديم-', 120605, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(509, NULL, 'خيرات قدور -قديم -', 120606, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(510, NULL, 'رغيد بشارة -قديم', 120607, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(511, NULL, 'زياد موسى - الخراب', 120608, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(512, NULL, 'سعد خليل', 120609, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(513, NULL, 'صفيان كاملة', 120610, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(514, NULL, 'طلال ونوس -قديم', 120611, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(515, NULL, 'عبد الغني الشغري -جديد-', 120612, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(516, NULL, 'عبد القادر منصور-قديم-', 120613, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(517, NULL, 'عبد الله عيوش - قديم', 120614, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(518, NULL, 'علي بياسي -قديم', 120615, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(519, NULL, 'علي سليمان -قديم', 120616, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(520, NULL, 'علي معروف -قديم-', 120617, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(521, NULL, 'عيسى عيسى - حريصون', 120618, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(522, NULL, 'كامل موسى - الخراب - بانياس', 120619, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(523, NULL, 'ماهر عبود - قديم', 120620, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(524, NULL, 'محمد الشغري - بانياس', 120621, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(525, NULL, 'محمد رحمون ( حميد ) - بانياس', 120622, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(526, NULL, 'محمد لولو', 120623, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(527, NULL, 'محمد وحود', 1215, 2, 0, 1, NULL, NULL, 0, NULL, NULL),
(528, NULL, 'محمود منصور - قديم', 120625, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(529, NULL, 'مصطفى غلاونجي', 120626, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(530, NULL, 'مضر حويجة -قديم -', 120627, 8, 0, 1, NULL, NULL, 0, NULL, NULL),
(531, NULL, 'احمد المحمود دير حافر -قديم', 121001, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(532, NULL, 'اسماعيل كالو - تل عرن - حلب - جديد', 121002, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(533, NULL, 'المهندس يوسف كالو - تل عرن - حلب - جديد', 121003, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(534, NULL, 'جفال الجفال - تل عرن - حلب', 121004, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(535, NULL, 'حسن خليل جديد- السفيرة', 121005, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(536, NULL, 'حمود حمام- تل عرن- جديد', 121006, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(537, NULL, 'خالد النجار -جديد -', 121007, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(538, NULL, 'خليل الحسين جديد', 121008, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(539, NULL, 'د. عبد الرزاق الابراهيم - دير حافر - حلب - جديد', 121009, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(540, NULL, 'د. عبد اللطيف العساف - كويرس - حلب - جديد', 121010, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(541, NULL, 'د. محمد نور الدين العساف - دير حافر - حلب - جديد', 121011, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(542, NULL, 'صالح شبلي', 121012, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(543, NULL, 'صبحي فلاحة - حلب', 121013, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(544, NULL, 'عبود حرجة - تل عرن - حلب - جديد', 121014, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(545, NULL, 'علي ميرزو - تل حاصل - حلب - جديد', 121015, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(546, NULL, 'فهد الدبس - تل عرن - حلب - جديد', 121016, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(547, NULL, 'فهد عاشوري - دير حافر - حلب', 121017, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(548, NULL, 'م. خالد عاصي - حلب - جديد', 121018, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(549, NULL, 'م. خليل الحسين - تل عرن - حلب', 121019, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(550, NULL, 'م. عبد العزيز الصالح - السفيرة - حلب - جديد', 121020, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(551, NULL, 'م. مازن جاويش - حلب - جديد', 121021, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(552, NULL, 'م. محمد الكضيب - دير حافر - حلب', 121022, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(553, NULL, 'م. محمد خليل - حلب - جديد', 121023, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(554, NULL, 'م. محمود الحميدان - حلب - جديد', 121024, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(555, NULL, 'م. محمود الشيخ نوري - مسكنة - حلب - جديد', 121025, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(556, NULL, 'م. نبهان النبهان - النيرب - حلب - جديد', 121026, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(557, NULL, 'م.خالد عاصي - قديم', 121027, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(558, NULL, 'م.علي العمر - السفيرة - حلب - جديد', 121028, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(559, NULL, 'م.مازن جاويش -قديم', 121029, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(560, NULL, 'م.محمود ابريق - حلب', 121030, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(561, NULL, 'محمود الشيخ نوري -قديم -', 121031, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(562, NULL, 'مصطفى حنكول - حلب', 121032, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(563, NULL, 'نبهان النبهان -قديم -', 121033, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(564, NULL, 'هيثم هلول - تل عرن - حلب - جديد', 121034, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(565, NULL, 'اكرم بيريني -قديم -', 121101, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(566, NULL, 'انطوان نويران', 121102, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(567, NULL, 'اياد كفى - حمص', 121103, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(568, NULL, 'بسام فركوح - حمص', 121104, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(569, NULL, 'تامر غنوم - نقيرة', 121105, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(570, NULL, 'جهاد بريجاوي - حمص', 121106, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(571, NULL, 'حافظ العلي - حمص', 121107, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(572, NULL, 'حسام جمال - حمص - قديم', 121108, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(573, NULL, 'حسان وسوف - حمص', 121109, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(574, NULL, 'حسين القاسم - قديم', 121110, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(575, NULL, 'خالد اسماعيل -الزهورية -جديد', 121111, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(576, NULL, 'ديب نجم - زيدل - حمص', 121112, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(577, NULL, 'سمير حلاق', 121113, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(578, NULL, 'طارق مرش - حمص', 121114, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(579, NULL, 'عبد الحليم الجنيدي - حمص', 121115, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(580, NULL, 'عبد المعطي السمرة - حمص', 121116, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(581, NULL, 'عبد الناصر الكنج - قديم', 121117, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(582, NULL, 'علي الرضوان - حمص', 121118, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(583, NULL, 'غياث جبر - حمص', 121119, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(584, NULL, 'غياث ديوب - خربة التين - حمص', 121120, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(585, NULL, 'فيكتور عطية - حمص', 121121, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(586, NULL, 'محمد الابراهيم -قديم -', 121122, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(587, NULL, 'محمد خير عرفات - حمص- جديد', 121123, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(588, NULL, 'محمد سالم زكريا -قديم-', 121124, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(589, NULL, 'محمد مصطفى الحسن - حمص - جديد', 121125, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(590, NULL, 'محمد يونس موسى - حمص', 121126, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(591, NULL, 'وديع نصار - حمص', 121127, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(592, NULL, 'احمد ابو غازي النوفل - قديم', 120401, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(593, NULL, 'احمد الحريري-جديد-', 120402, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(594, NULL, 'احمد الحريري-قديم-', 120403, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(595, NULL, 'بشار نصير - ازرع - قديم', 120404, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(596, NULL, 'طارق الدنيفات', 120405, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(597, NULL, 'طارق قطف-جديد-', 120406, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(598, NULL, 'عبد الله العنزي -قديم', 120407, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(599, NULL, 'عبد الله غزالي - قديم', 120408, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(600, NULL, 'عبد المؤمن الشبلي', 120409, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(601, NULL, 'علي العنزي - الحراك - قديم', 120410, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(602, NULL, 'عمار العباس -قديم -', 120411, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(603, NULL, 'كمال الصبحات - طفس- جديد', 120412, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(604, NULL, 'م. بشار نصير - جديد -', 120413, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(605, NULL, 'محمد السعدي - قديم', 120414, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(606, NULL, 'مذكر عباس', 120415, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(607, NULL, 'مروان الشبلي -جديد-', 120416, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(608, NULL, 'مهند جباوي - جاسم -- جديد', 120417, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(609, NULL, 'نبيل عيشات - قديم', 120418, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(610, NULL, 'هشام نصير - ازرع - قديم', 120419, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(611, NULL, 'وليد ابو شنب - جديد', 120420, 6, 0, 1, NULL, NULL, 0, NULL, NULL),
(612, NULL, 'temp box', 1221, 2, 0, 1, NULL, NULL, 0, NULL, NULL),
(613, NULL, 'حيدر خليل  اللاذقية', 121035, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(614, NULL, 'عبد الله العنزي قديم', 121128, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(615, NULL, 'المهندس رامز حسن  قديم', 121036, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(616, NULL, 'مهند جباوي قديم', 121129, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(617, NULL, 'ابراهيم ونوس  قلعة جراس  قديم', 121037, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(618, NULL, 'طلال ابراهيم  كفر بهم  قديم', 121038, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(619, NULL, 'محمود الخطيب قديم', 121039, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(620, NULL, 'عبد الله عيوش  قديم', 122101, 612, 0, 1, NULL, NULL, 0, NULL, NULL),
(621, NULL, 'حمدان الحسن  درعا  قديم', 121040, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(622, NULL, 'فراس حسين طرطوس قديم', 121041, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(623, NULL, 'شادي حمود  الربيعة', 121042, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(624, NULL, 'عبد العزيز المحمد جريكيس قديم', 121043, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(625, NULL, 'د. احمد الصالح  قديم', 121044, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(626, NULL, 'علي الشرف نصيب', 121045, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(627, NULL, 'م. خالد النجار  منبج', 121046, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(628, NULL, 'احمد كامل الزعبي  قديم', 121047, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(629, NULL, 'رضوان الرضوان  قديم', 121048, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(630, NULL, 'محمد علي قديم', 121049, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(631, NULL, 'امين اسماعيل  قديم', 121130, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(632, NULL, 'علي معروف قديم', 122102, 612, 0, 1, NULL, NULL, 0, NULL, NULL),
(633, NULL, 'علي الرضوان قديم', 121131, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(634, NULL, 'مراد مصطفى  القامشلي', 121050, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(635, NULL, 'م. صخر العبدو  منبج', 121051, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(636, NULL, 'عبد الله غزالي  قديم', 121052, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(637, NULL, 'عبد المعطي الحسينقديم ', 121053, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(638, NULL, 'احمد الحريريقديم', 121132, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(639, NULL, 'نبهان النبهان قديم ', 121133, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(640, NULL, 'اسامة الشيخ  قديم', 121054, 12, 0, 1, NULL, NULL, 0, NULL, NULL);
INSERT INTO `accounts` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `person_id`, `base`, `currency_id`, `closing_account_type`) VALUES
(641, NULL, 'قاسم ابو شنب  قديم', 121055, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(642, NULL, 'وسيم عيسى قديم', 121056, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(643, NULL, 'المهندس وسام جبور  قديم', 121057, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(644, NULL, 'احمد حميد عبادي ع/ط اسماعيل العيسى  منبج', 121058, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(645, NULL, 'م.خالد عاصي  قديم', 121134, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(646, NULL, 'المهندس يوسف كالو  تل عرن  حلب  قديم', 121135, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(647, NULL, 'زياد موسى  الخراب', 121059, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(648, NULL, 'ابراهيم الدايغ  محردة  قديم', 121060, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(649, NULL, 'محسن ترسيسي  قديم', 121061, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(650, NULL, 'ابراهيم الضامن كررناز محرده قديم', 121062, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(651, NULL, 'حسين القاسم  قديم', 121136, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(652, NULL, 'مصعب الزعبي قديم ', 121063, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(653, NULL, 'رمضان شدو  منبج', 121064, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(654, NULL, 'ابراهيم قهوجي  درعا  قديم', 121065, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(655, NULL, 'وديع صقر  السقيلبية  قديم', 121066, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(656, NULL, 'سليمان المحمود قديم', 121067, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(657, NULL, 'راني كيوان  قديم', 121068, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(658, NULL, 'د. عبد الرزاق الابراهيم  دير حافر  حلب  قديم', 121137, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(659, NULL, 'علي البردان  قديم', 121069, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(660, NULL, 'فادي الخيرات  قديم', 121070, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(661, NULL, 'ادهم الزعيم  منبج', 121071, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(662, NULL, 'مصطفى حنكول  حلب', 121072, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(663, NULL, 'المهندس مازن برو  قديم', 121073, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(664, NULL, 'سفيان نصيرات  قديم', 121074, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(665, NULL, 'محمد خير عرفات  حمص  قديم', 121138, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(666, NULL, 'خليل البردان  درعا  قديم', 121075, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(667, NULL, 'ابراهيم رستناوي قديم', 121076, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(668, NULL, 'كمال الزعبي  قديم', 121077, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(669, NULL, 'قتيبة حاصود  قديم', 121078, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(670, NULL, 'معاذ برمو  قديم', 121079, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(671, NULL, 'يامن ياسين  معر شحور  قديم', 121080, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(672, NULL, 'قاسم مفعلاني  قديم  درعا', 121081, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(673, NULL, 'احمد حاج علي  قديم', 121082, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(674, NULL, 'احمد خضر  قديم', 121083, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(675, NULL, 'مجد سلوم  الصفصافية  قديم', 121084, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(676, NULL, 'ايهاب مهنا قديم ', 121085, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(677, NULL, 'مصطفى الصواف  الكسوة', 121086, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(678, NULL, 'المهندس نور الدين علي  قديم', 121087, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(679, NULL, 'محمد خريبة  قديم', 121088, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(680, NULL, 'د. محمد نور الدين العساف  دير حافر  حلب  قديم', 121139, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(681, NULL, 'علي بياسي قديم', 1217, 2, 0, 1, NULL, NULL, 0, NULL, NULL),
(682, NULL, 'حافظ العلي  حمص قديم', 121140, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(683, NULL, 'محمد رحمون ( حميد )  بانياس', 121089, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(684, NULL, 'خيرات قدور قديم ', 1219, 2, 0, 1, NULL, NULL, 0, NULL, NULL),
(685, NULL, 'المهندس احمد امين  قديم', 121090, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(686, NULL, 'مياد سلوم  حرده قديم', 121091, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(687, NULL, 'محمد زهير أبو جيب  دوما  قديم', 121092, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(688, NULL, 'المهندس عصام ديب  قديم', 121093, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(689, NULL, 'عماد ابو يزبك  السويداء', 121094, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(690, NULL, 'ضاهر عبد النبي  الصبورة', 121095, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(691, NULL, 'فراس حسين  الخراب  قديم', 121096, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(692, NULL, 'جهاد بريجاوي  قديم', 121141, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(693, NULL, 'محمود ابو نقطة  قديم', 121097, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(694, NULL, 'خليل عبد الفتاح  الكسوة', 121098, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(695, NULL, 'م. محمود طباش  منبج', 121099, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(696, NULL, 'د. حيدر شاهين  قديم', 121100, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(697, NULL, 'علي الحمادي  الطبقة', 121101, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(698, NULL, 'قاسم وفا  ضمير  قديم', 121102, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(699, NULL, 'بلال صالح بركات  القامشلي', 121103, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(700, NULL, 'حمادي الايوب ( ابو مشهود )  منبج', 121104, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(701, NULL, 'جمعة عمو  راس العين', 121105, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(702, NULL, 'عيسى عيسى  حريصون', 121106, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(703, NULL, 'سامر اللحام الغوطة  قديم ', 121107, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(704, NULL, 'جهاد حمود  قديم', 121108, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(705, NULL, 'اسماعيل العيسى ( الهواش )', 121109, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(706, NULL, 'العامرة المنطقة الشرقية  بذور', 121110, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(707, NULL, 'احمد اسماعيل  قديم', 121111, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(708, NULL, 'عبد الحليم الجنيدي قديم', 121142, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(709, NULL, 'العامرة المنطقة الشرقية  متفرقات', 121112, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(710, NULL, 'نبيل عيشات  قديم', 121113, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(711, NULL, 'كامل موسى  الخراب  بانياس', 121114, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(712, NULL, 'حسين العلاوي  قديم', 121115, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(713, NULL, 'احمد صبحي قديم', 121116, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(714, NULL, 'حسام خريبة  قديم', 121117, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(715, NULL, 'احمد عبيد قديم', 121118, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(716, NULL, 'محمد كامل الزعبي قديم', 121119, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(717, NULL, 'محمد الزعبي  قديم', 121120, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(718, NULL, 'اسامة اسماعيل  بانياس  قديم', 121121, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(719, NULL, 'محمد الاحمد كفر هود قديم', 121122, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(720, NULL, 'د. عبد اللطيف العساف  كويرس  حلب  قديم', 121143, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(721, NULL, 'مجيد النوفل  درعا', 121123, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(722, NULL, 'احمد ابو غازي النوفل  قديم', 121144, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(723, NULL, 'سالم النجار  قديم', 121124, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(724, NULL, 'محمود سليمان  درعا', 121125, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(725, NULL, 'بشار نصير  ازرع  قديم', 121145, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(726, NULL, 'محمد الصفوري  قديم', 121126, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(727, NULL, 'احمد السعدي  قديم', 121127, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(728, NULL, 'خالد اسماعيل  الزهراوية  قديم', 121146, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(729, NULL, 'موسى البيطاري  قديم', 121128, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(730, NULL, 'علاء الشبلي  سوق الهال  قديم', 121129, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(731, NULL, 'العامرة المنطقة الشرقية  جل', 121130, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(732, NULL, 'العامرة المنطقة الشرقية  بودرة', 121131, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(733, NULL, 'م. علي نصر الله  سوق الهال', 121132, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(734, NULL, 'طارق قطف قديم ', 121147, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(735, NULL, 'احمد حوراني  قديم', 121133, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(736, NULL, 'فايز ابو نعيم  قديم', 121134, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(737, NULL, 'محمد سالم زكريا قديم', 121148, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(738, NULL, 'المهندس علي عباس  قديم', 121135, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(739, NULL, 'مجد السلوم  الصفصافية', 121136, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(740, NULL, 'علي الصبح ( ربيع الخليل )  القنية', 121137, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(741, NULL, 'توفيق المصري  حماه  قديم', 121138, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(742, NULL, 'عبد العزيز المحمد  جركيس', 121139, 12, 0, 1, NULL, NULL, 0, NULL, NULL),
(743, NULL, 'محمد السعدي جديد', 121149, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(744, NULL, 'مروان الشبلي جديد', 121150, 13, 0, 1, NULL, NULL, 0, NULL, NULL),
(745, NULL, 'صندوق شادي فروح', 1410, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(746, NULL, 'صندوق عبود الجاسم', 1411, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(747, NULL, 'صندوق محمود الناصر', 1412, 18, 0, 1, NULL, NULL, 0, NULL, NULL),
(749, 'محمود الخطيب', 'محمود الخطيب', 140801, 26, 0, 1, NULL, NULL, 0, NULL, NULL),
(750, NULL, 'الخصوم', 2, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(751, NULL, 'الموردون', 201, 750, 1, 1, NULL, NULL, 0, NULL, NULL),
(752, NULL, 'عمر', 20101, 751, 0, 1, NULL, NULL, 0, NULL, NULL),
(753, NULL, 'عمر', 20102, 751, 0, 1, NULL, NULL, 0, NULL, NULL),
(769, NULL, 'الإيرادات', 5, NULL, 1, 1, NULL, NULL, 0, NULL, NULL),
(770, NULL, 'فرق سعر الصرف', 44, NULL, 0, 1, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `response` longtext,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `form_id`, `response`, `created_at`, `updated_at`, `active`) VALUES
(1, 1, '<table class=\'table\'><thead><tr><th>First Name</th><th>Email  Address</th><th>Gender</th><th>lang</th><th>Country</th></tr></thead><body><tr><td>fesal ali</td><td>fesalali05@gmail.com</td><td>female</td><td>ar,en,</td><td>syria</td></tr></tbody></table>', '2019-09-12', '2019-09-12', 1),
(2, 1, '<table class=\'table\'><thead><tr><th>First Name</th><th>Email  Address</th><th>Gender</th><th>lang</th><th>Country</th></tr></thead><body><tr><td>fesal ali</td><td>testpage@gmail.com</td><td>female</td><td>ar,en,</td><td>syria</td></tr></tbody></table>', '2019-09-15', '2019-09-15', 1),
(3, 1, '<table class=\'table\'><thead><tr><th>First Name</th><th>Email  Address</th><th>Gender</th><th>lang</th><th>Country</th></tr></thead><body><tr><td>fesal ali</td><td>werew@gmail.com</td><td>female</td><td>ar,en,</td><td>lebanon</td></tr></tbody></table>', '2019-09-15', '2019-09-15', 1),
(4, 1, '<table class=\'table\'><thead><tr><th>age</th><th>First Name</th><th>Email  Address</th><th>Gender</th><th>lang</th><th>Country</th></tr></thead><body><tr><td>123</td><td>fesal</td><td>fesalali05@gmail.com</td><td>female</td><td>ar,en,</td><td>lebanon</td></tr></tbody></table>', '2019-09-15', '2019-09-15', 1),
(5, 1, '<table class=\'table\'><thead><tr><th>age</th><th>First Name</th><th>Email  Address</th><th>Gender</th><th>lang</th><th>Country</th></tr></thead><body><tr><td>26</td><td>Fesal Ali</td><td>fesalali05@gmail.com</td><td>male</td><td>ar,en,</td><td>syria</td></tr></tbody></table>', '2019-09-16', '2019-09-16', 1),
(6, 1, '<table class=\'table\'><thead><tr><th>age</th><th>lang</th><th>Email  Address</th><th>First Name</th><th>Country</th><th>Gender</th></tr></thead><body><tr><td>123</td><td>ar,en,</td><td>fesal@gmail.com</td><td>sdf</td><td>syria</td><td>female</td></tr></tbody></table>', '2019-09-29', '2019-09-29', 1),
(7, 1, '<table class=\'table\'><thead><tr><th>age</th><th>lang</th><th>Email  Address</th><th>First Name</th><th>Country</th><th>Gender</th></tr></thead><body><tr><td>20</td><td>ar,en,</td><td>fesal@gmail.com</td><td>sdf</td><td>syria</td><td>female</td></tr></tbody></table>', '2019-09-29', '2019-09-29', 1),
(8, 1, '<table class=\'table\'><thead><tr><th>age</th><th>lang</th><th>Email  Address</th><th>First Name</th><th>Country</th><th>Gender</th></tr></thead><body><tr><td>22</td><td>ar,en,</td><td>balkis@voila.digital</td><td>Thaer</td><td>lebanon</td><td>female</td></tr></tbody></table>', '2019-10-14', '2019-10-14', 1),
(9, 2, '<table class=\'table\'><thead><tr><th>email</th><th>Email</th><th>Name</th></tr></thead><body><tr><td>eman@voila.digital</td><td>eman,test,</td><td>ايمان</td></tr></tbody></table>', '2019-10-14', '2019-10-14', 1),
(10, 1, '<table class=\'table\'><thead><tr><th>Gender</th><th>Country</th><th>lang</th><th>First Name</th><th>Email  Address</th><th>age</th></tr></thead><body><tr><td></td><td>lebanon</td><td>ar,en,</td><td>23</td><td>fesalali04@gmail.co.com</td><td>132</td></tr></tbody></table>', '2019-11-14', '2019-11-14', 1),
(11, 2, '<table class=\'table\'><thead><tr><th>Name</th><th>Email</th><th>email</th></tr></thead><body><tr><td>fesa</td><td>eman,test,</td><td>fesalali05@gmail.com</td></tr></tbody></table>', '2019-11-14', '2019-11-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int NOT NULL,
  `code` bigint DEFAULT NULL,
  `debit` int DEFAULT NULL,
  `credit` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bill_type_id` int DEFAULT NULL,
  `inventory_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `staff_id` int DEFAULT NULL,
  `note` longtext,
  `is_cash` tinyint DEFAULT '1',
  `bill_number` varchar(200) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `ex_rate` decimal(10,2) NOT NULL,
  `equalizer` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `after_discount` decimal(10,2) NOT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `p_code` varchar(50) NOT NULL,
  `delegate_id` int DEFAULT NULL,
  `checked_for_update` tinyint NOT NULL DEFAULT '0',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int DEFAULT '0',
  `delete_action` varchar(10) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `code`, `debit`, `credit`, `date`, `bill_type_id`, `inventory_id`, `currency_id`, `staff_id`, `note`, `is_cash`, `bill_number`, `amount`, `ex_rate`, `equalizer`, `discount`, `after_discount`, `active`, `sorting`, `p_code`, `delegate_id`, `checked_for_update`, `create_at`, `create_by`, `delete_at`, `delete_by`, `delete_action`, `rotate_year`) VALUES
(1, 1, 564, 35, '2021-11-13', 2, 15, 2, 21, NULL, 0, '391/11-93-deleted', '2250.00', '2300.00', '0.00', '0.00', '2250.00', 1, NULL, 'INV-1-93-deleted', 21, 0, NULL, NULL, '2021-12-22 08:12:02', 1, 'delete', NULL),
(2, 1, 564, NULL, '2021-11-13', 2, 15, 2, 21, NULL, 0, '390/10-89-edited', '2250.00', '2300.00', '0.00', '0.00', '2250.00', 1, NULL, 'INV-1-89-edited', 21, 0, NULL, NULL, '2021-12-07 10:34:38', 1, NULL, NULL),
(3, 1, 564, 35, '2021-11-13', 2, 15, 2, 1, NULL, 0, '390/11-31-edited', '2250.00', '2300.00', '0.00', '0.00', '2250.00', 1, NULL, 'INV-1-31-edited', 21, 0, NULL, NULL, '2021-12-16 10:41:39', 21, 'edit', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bills_files`
--

CREATE TABLE `bills_files` (
  `id` int NOT NULL,
  `file_id` varchar(200) DEFAULT NULL,
  `bill_id` int NOT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bills_files`
--

INSERT INTO `bills_files` (`id`, `file_id`, `bill_id`, `active`, `sorting`) VALUES
(1, NULL, 3, 1, 1),
(2, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bill_item`
--

CREATE TABLE `bill_item` (
  `id` int NOT NULL,
  `bill_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bill_item`
--

INSERT INTO `bill_item` (`id`, `bill_id`, `item_id`, `unit_price`, `quantity`, `active`, `sorting`, `subtotal`) VALUES
(1, 2, 143, '15.00', 150, 1, 1, '2250'),
(2, 3, 143, '15.00', 150, 1, 1, '2250'),
(3, 1, 143, '15.00', 150, 1, 1, '2250');

-- --------------------------------------------------------

--
-- Table structure for table `bill_type`
--

CREATE TABLE `bill_type` (
  `id` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `code` bigint DEFAULT NULL,
  `prefix` varchar(500) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `closing_accounts_types` (
  `id` int NOT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorting` int DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
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

CREATE TABLE `cms_apicustom` (
  `id` int UNSIGNED NOT NULL,
  `permalink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kolom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_query_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sql_where` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `method_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `responses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_apikey`
--

CREATE TABLE `cms_apikey` (
  `id` int UNSIGNED NOT NULL,
  `screetkey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit` int DEFAULT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_dashboard`
--

CREATE TABLE `cms_dashboard` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_queues`
--

CREATE TABLE `cms_email_queues` (
  `id` int UNSIGNED NOT NULL,
  `send_at` datetime DEFAULT NULL,
  `email_recipient` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_cc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_sent` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_email_templates`
--

CREATE TABLE `cms_email_templates` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_email_templates`
--

INSERT INTO `cms_email_templates` (`id`, `name`, `slug`, `subject`, `content`, `description`, `from_name`, `from_email`, `cc_email`, `created_at`, `updated_at`) VALUES
(1, 'Email Template Forgot Password Backend', 'forgot_password_backend', 'forget password', '<span style=\"direction:rtl !important;\">\r\n<p>مرحبا،</p>\r\n<p>لقد قمت بطلب كلمة السر هذه كلمة السر الجديدة الخاصة بك :&nbsp;</p>\r\n<p>[password]</p>\r\n<p><br></p>\r\n<p>--</p>\r\n<p>مع تحياتي،</p>\r\n<p>Admin</p>\r\n</span>', '[password]', 'System', 'info@voitest.com', NULL, '2019-05-30 03:06:59', '2021-12-29 15:25:07'),
(2, 'Form contact us', 'form_submit_contact_us', 'Form contact us', '<p><b>This is submit from Page Contact Us :</b></p><p><span style=\"font-weight: 700;\">&nbsp;email</span>: [email]&nbsp;<br></p><p><span style=\"font-weight: 700;\">Name</span>&nbsp;: [name]&nbsp;</p><p><b>message</b>: [message]&nbsp;</p><p>Thank You .</p><p><br></p>', 'email for any submit in site', 'Aviation Taiba', 'info@voitest.com', NULL, '2019-10-10 02:57:35', '2021-12-29 13:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `cms_logs`
--

CREATE TABLE `cms_logs` (
  `id` int UNSIGNED NOT NULL,
  `ipaddress` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_cms_users` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_logs`
--

INSERT INTO `cms_logs` (`id`, `ipaddress`, `useragent`, `url`, `description`, `details`, `id_cms_users`, `created_at`, `updated_at`) VALUES
(1, '5.155.145.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 5.155.145.118', '', 1, '2022-03-16 03:26:50', NULL),
(2, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'admin@voila.digital سجل دخل من رقم آيبي 94.47.37.133', '', 2, '2022-03-19 11:38:34', NULL),
(3, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/users/edit-save/21', 'تعديل محمود الخطيب في إدارة المستخدمين', '<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>password</td><td>$2y$10$MyiovAMt9R8jmFl4vUUCVO2kw6.q76HWLQJvuUZ.zlZIJCzRpwvDy</td><td>$2y$10$9ILrPSMdoEZLPEDISWZQLe1f/SRGuUtq1iVNa/8V8C1Cmhaei/VOu</td></tr><tr><td>inventory_id</td><td>15</td><td></td></tr></tbody></table>', 2, '2022-03-19 11:40:43', NULL),
(4, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/logout', 'admin@voila.digital تسجيل خروج', '', 2, '2022-03-19 11:40:57', NULL),
(5, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 94.47.37.133', '', 21, '2022-03-19 11:41:21', NULL),
(6, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/logout', 'mahmod.alkhateb@alamera.com تسجيل خروج', '', 21, '2022-03-19 11:44:38', NULL),
(7, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'admin@voila.digital سجل دخل من رقم آيبي 94.47.37.133', '', 2, '2022-03-19 11:44:56', NULL),
(8, '94.47.37.133', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/logout', 'admin@voila.digital تسجيل خروج', '', 2, '2022-03-19 11:55:55', NULL),
(9, '96.45.75.109', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'admin@voila.digital سجل دخل من رقم آيبي 96.45.75.109', '', 2, '2022-03-19 22:58:48', NULL),
(10, '96.45.75.109', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'admin@voila.digital سجل دخل من رقم آيبي 96.45.75.109', '', 2, '2022-03-19 22:59:07', NULL),
(11, '77.44.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 77.44.225.145', '', 1, '2022-03-20 07:21:24', NULL),
(12, '94.47.43.80', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 94.47.43.80', '', 21, '2022-03-20 09:36:43', NULL),
(13, '77.44.205.172', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 77.44.205.172', '', 1, '2022-03-21 05:06:52', NULL),
(14, '5.0.44.55', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 5.0.44.55', '', 21, '2022-03-21 08:09:50', NULL),
(15, '5.0.44.55', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 5.0.44.55', '', 21, '2022-03-21 08:09:53', NULL),
(16, '5.0.44.55', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/receipt_voucher/edit-save/206', 'تعديل  في سندات القبض', '<table class=\"table table-striped\"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody><tr><td>code</td><td>9</td><td></td></tr><tr><td>p_code</td><td>RV-9</td><td></td></tr><tr><td>amount</td><td>187000.00</td><td>0</td></tr><tr><td>sorting</td><td></td><td></td></tr><tr><td>create_at</td><td>2021-12-15 14:41:11</td><td></td></tr><tr><td>delete_at</td><td></td><td></td></tr><tr><td>delete_action</td><td></td><td></td></tr><tr><td>rotate_year</td><td></td><td></td></tr></tbody></table>', 21, '2022-03-21 08:51:31', NULL),
(17, '77.44.203.159', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 77.44.203.159', '', 1, '2022-03-21 12:51:15', NULL),
(18, '5.0.0.89', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 5.0.0.89', '', 21, '2022-03-23 06:52:46', NULL),
(19, '77.44.203.159', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 77.44.203.159', '', 1, '2022-03-23 08:02:08', NULL),
(20, '5.0.0.89', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36', 'http://cloudsellpos.com/modules/receipt_voucher/add-save', 'اضافة بيانات جديدة  في سندات القبض', '', 21, '2022-03-23 08:48:56', NULL),
(21, '188.133.17.158', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'admin@voila.digital سجل دخل من رقم آيبي 188.133.17.158', '', 2, '2022-03-23 09:27:31', NULL),
(22, '77.44.203.159', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'superadmin@voila.digital سجل دخل من رقم آيبي 77.44.203.159', '', 1, '2022-03-27 04:32:53', NULL),
(23, '5.155.27.18', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36', 'http://cloudsellpos.com/modules/login', 'mahmod.alkhateb@alamera.com سجل دخل من رقم آيبي 5.155.27.18', '', 21, '2022-03-27 09:47:00', NULL),
(24, '5.155.27.18', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36', 'http://cloudsellpos.com/modules/logout', 'mahmod.alkhateb@alamera.com تسجيل خروج', '', 21, '2022-03-27 09:55:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus`
--

CREATE TABLE `cms_menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'url',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `is_front` tinyint DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `sorting` int DEFAULT NULL,
  `lang_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(207, 'سجل سعر صرف العملات', 'Route', 'AdminCurrencyHistoryControllerGetIndex', 'normal', 'fa fa-glass', 176, 1, 0, NULL, 1, 2, NULL, '2022-01-04 05:18:50', '2022-01-10 08:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus_privileges`
--

CREATE TABLE `cms_menus_privileges` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_menus` int DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(549, 207, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_moduls`
--

CREATE TABLE `cms_moduls` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `hasImage` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `has_page_client` tinyint DEFAULT '0',
  `main_field` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_effected` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(121, 'سجل سعر صرف العملات', 'fa fa-glass', 'currency_history', 'currency_history', 'AdminCurrencyHistoryController', 0, 0, 0, '2022-01-04 05:18:49', NULL, NULL, 0, NULL, 'record');

-- --------------------------------------------------------

--
-- Table structure for table `cms_notifications`
--

CREATE TABLE `cms_notifications` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_users` int DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_privileges`
--

CREATE TABLE `cms_privileges` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) DEFAULT NULL,
  `theme_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `cms_privileges_roles` (
  `id` int UNSIGNED NOT NULL,
  `is_visible` tinyint(1) DEFAULT NULL,
  `is_create` tinyint(1) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_edit` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `id_cms_moduls` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(164, 1, 1, 1, 1, 0, 4, 93, NULL, NULL),
(138, 1, 1, 1, 1, 1, 1, 114, NULL, NULL),
(137, 1, 1, 1, 1, 1, 1, 113, NULL, NULL),
(163, 1, 1, 1, 1, 0, 4, 108, NULL, NULL),
(162, 1, 1, 1, 1, 0, 4, 109, NULL, NULL),
(161, 1, 1, 1, 0, 0, 4, 114, NULL, NULL),
(160, 1, 1, 1, 1, 0, 4, 102, NULL, NULL),
(127, 1, 1, 1, 1, 1, 1, 112, NULL, NULL),
(126, 1, 1, 1, 1, 1, 1, 111, NULL, NULL),
(125, 1, 1, 1, 1, 1, 1, 110, NULL, NULL),
(119, 1, 1, 1, 1, 1, 1, 109, NULL, NULL),
(118, 1, 1, 1, 1, 1, 1, 108, NULL, NULL),
(159, 1, 1, 1, 1, 0, 4, 103, NULL, NULL),
(158, 1, 1, 1, 1, 1, 4, 79, NULL, NULL),
(157, 1, 1, 1, 1, 0, 4, 84, NULL, NULL),
(156, 1, 1, 1, 1, 0, 4, 83, NULL, NULL),
(155, 1, 1, 1, 0, 0, 4, 82, NULL, NULL),
(149, 1, 1, 1, 1, 1, 1, 115, NULL, NULL),
(150, 1, 1, 1, 1, 1, 1, 116, NULL, NULL),
(151, 1, 1, 1, 1, 1, 1, 117, NULL, NULL),
(152, 1, 1, 1, 1, 1, 1, 118, NULL, NULL),
(153, 1, 1, 1, 1, 1, 1, 119, NULL, NULL),
(154, 1, 1, 1, 1, 1, 1, 120, NULL, NULL),
(165, 1, 1, 1, 1, 0, 4, 96, NULL, NULL),
(166, 1, 1, 1, 1, 0, 4, 101, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content_input_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataenum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_setting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `name`, `content`, `content_input_type`, `dataenum`, `helper`, `created_at`, `updated_at`, `group_setting`, `label`) VALUES
(1, 'login_background_color', NULL, 'text', NULL, 'Input hexacode', '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Background Color'),
(2, 'login_font_color', NULL, 'text', NULL, 'Input hexacode', '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Font Color'),
(3, 'login_background_image', NULL, 'upload_image', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Login Register Style', 'Login Background Image'),
(4, 'email_sender', 'info@voitest.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Email Sender'),
(5, 'smtp_driver', 'smtp', 'select', 'smtp,mail,sendmail', NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'Mail Driver'),
(6, 'smtp_host', 'mail.voilahost.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Host'),
(7, 'smtp_port', '2525', 'text', NULL, 'default 25', '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Port'),
(8, 'smtp_username', 'info@voitest.com', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Username'),
(9, 'smtp_password', '934WeLclP#', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Email Setting', 'SMTP Password'),
(10, 'appname', 'نظام المحاسبة', 'text', NULL, NULL, '2019-05-30 06:06:58', NULL, 'Application Setting', 'Application Name'),
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

CREATE TABLE `cms_statistics` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_statistics`
--

INSERT INTO `cms_statistics` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(3, 'statistic', 'statistic', '2020-03-18 06:00:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_statistic_components`
--

CREATE TABLE `cms_statistic_components` (
  `id` int UNSIGNED NOT NULL,
  `id_cms_statistics` int DEFAULT NULL,
  `componentID` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_name` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sorting` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 3, 'cf1bb6baa2b316672577a4fbd15de369', 'smallbox', 'area1', 0, NULL, '{\"name\":\"\\u0631\\u0635\\u064a\\u062f \\u0627\\u0644\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u0644\\u064a\\u0631\\u0629 \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a\\u0629\",\"icon\":\"ion-bag\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=15&delegate_id=-1&from_date=&to_date=&currency_id=1\",\"sql\":\"select FORMAT(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'15\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=15 AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:00:35', NULL),
(13, 3, '51f70839f7f55677f1a8d1327ce5511c', 'smallbox', 'area2', 0, NULL, '{\"name\":\"\\u0631\\u0635\\u064a\\u062f \\u0627\\u0644\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u062f\\u0648\\u0644\\u0627\\u0631\",\"icon\":\"ion-social-usd\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=16\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'16\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=16 AND entries.currency_id=2 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:28:32', NULL),
(14, 5, 'f3f2b406dfaa83d94322e885d2e3a42a', 'smallbox', 'area2', 1, NULL, '{\"name\":\"\\u0627\\u0644\\u0645\\u0634\\u062a\\u0631\\u064a\\u0627\\u062a \\u0627\\u0644\\u0644\\u064a\\u0631\\u0629 \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a\\u0629\",\"icon\":\"ion-ios-cart\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=33\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'33\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2020-03-18 04:30:40', NULL),
(17, 3, 'c93cc73b87364bd0e0c866d610a10651', 'smallbox', 'area4', 0, NULL, '{\"name\":\"\\u0627\\u0644\\u0645\\u0628\\u064a\\u0639\\u0627\\u062a\",\"icon\":\"ion-arrow-graph-up-right\",\"color\":\"bg-yellow\",\"link\":\"\\/modules\\/reports99?account_id=35\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'35\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 02:44:01', NULL),
(16, 3, '4d218f1832c3a13a4b59d1c1c93451e5', 'smallbox', NULL, 0, 'Untitled', NULL, '2020-03-18 04:37:32', NULL),
(20, 5, '05c3b18df7b97b09a4e1160b9006a126', 'smallbox', 'area3', 2, NULL, '{\"name\":\"\\u0645\\u0631\\u062f\\u0648\\u062f \\u0645\\u0634\\u062a\\u0631\\u064a\\u0627\\u062a\",\"icon\":\"ion-arrow-swap\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=34\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'34\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:12:26', NULL),
(18, 3, '8339ad35e433b80e7ac3791d632ef4da', 'smallbox', 'area3', 1, NULL, '{\"name\":\"\\u0631\\u0635\\u064a\\u062f \\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u064a\\u0648\\u0631\\u0648\",\"icon\":\"ion-social-euro\",\"color\":\"bg-aqua\",\"link\":\"\\/modules\\/reports99?account_id=17\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'17\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id and entries.account_id=17 AND entries.currency_id=3 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:01:22', NULL),
(19, 5, 'fc26d0e519c256777017217031c57b03', 'smallbox', 'area1', 1, NULL, '{\"name\":\"\\u0645\\u0631\\u062f\\u0648\\u062f \\u0645\\u0628\\u064a\\u0639\\u0627\\u062a\",\"icon\":\"ion-arrow-swap\",\"color\":\"bg-green\",\"link\":\"\\/modules\\/reports99?account_id=36\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'36\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:05:18', NULL),
(21, 5, '01c39a8ebf193b30402c531941ad5757', 'smallbox', 'area4', 1, NULL, '{\"name\":\"\\u0627\\u0644\\u062d\\u0633\\u0645 \\u0627\\u0644\\u0645\\u0643\\u062a\\u0633\\u0628\",\"icon\":\"ion-plus-circled\",\"color\":\"bg-aqua\",\"link\":\"\\/modules\\/reports99?account_id=38\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'38\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:14:52', NULL),
(22, 5, '93fb5a7c619adde01c332cb2cfb15d0c', 'smallbox', 'area1', 2, NULL, '{\"name\":\"\\u0627\\u0644\\u062d\\u0633\\u0645 \\u0627\\u0644\\u0645\\u0645\\u0646\\u0648\\u062d\",\"icon\":\"ion-minus-circled\",\"color\":\"bg-red\",\"link\":\"\\/modules\\/reports99?account_id=37\",\"sql\":\"select FORMAT(ABS(IFNULL(( sum(IFNULL(entries.debit,0))-sum(IFNULL(entries.credit,0))),0)),2)  from entries , entry_base , accounts , currencies WHERE  accounts.id=entries.account_id and accounts.id = \'37\' AND entry_base.id=entries.entry_base_id AND currencies.id=entries.currency_id  AND entries.currency_id=1 and entry_base.delete_by=0 and entries.delete_by=0 and entries.rotate_year is NULL;\"}', '2021-11-24 03:18:42', NULL),
(23, 4, 'dd9437903c553af409bf7a5b0391fe78', 'smallbox', 'area3', 0, NULL, '{\"name\":\"\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0627\\u0644\\u0644\\u064a\\u0631\\u0629 \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a\\u0629\",\"icon\":\"ion-bag\",\"color\":\"bg-green\",\"link\":\"#\",\"sql\":null}', '2021-12-08 06:25:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE `cms_users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_id` int DEFAULT NULL,
  `account_id` int NOT NULL,
  `customers_account_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `name`, `photo`, `email`, `password`, `id_cms_privileges`, `created_at`, `updated_at`, `status`, `inventory_id`, `account_id`, `customers_account_id`) VALUES
(1, 'Super Admin', '/images/portfolio1_logo.png', 'superadmin@voila.digital', '$2y$10$MyiovAMt9R8jmFl4vUUCVO2kw6.q76HWLQJvuUZ.zlZIJCzRpwvDy', 1, '2019-05-30 06:06:58', '2020-07-21 12:55:23', 'Active', NULL, 0, 0),
(2, 'admin', '/images/portfolio1_logo.png', 'admin@voila.digital', '$2y$10$2QiQZt8mijdTuU/CqnJMweYq.pi42WZYcycEG.xgkf.IdrsFj3x2S', 1, '2019-06-18 06:02:41', '2019-11-13 07:34:57', 'Active', NULL, 0, 0),
(20, 'اسامة', NULL, 'osama@amera.com', '$2y$10$5kVP2uYfWf5fkGJeNst2B.5HBzwp47pDacMVKcWSQuYlYHlLV0pXq', 4, '2020-07-02 08:10:40', '2021-12-22 08:05:56', NULL, 9, 22, 7),
(21, 'محمود الخطيب', NULL, 'mahmod.alkhateb@alamera.com', '$2y$10$9ILrPSMdoEZLPEDISWZQLe1f/SRGuUtq1iVNa/8V8C1Cmhaei/VOu', 4, '2021-11-18 11:47:50', '2022-03-19 11:40:43', NULL, 15, 26, 12),
(3, 'سمير خليل', NULL, 'samirKhalil@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:08:04', NULL, NULL, 20, 5),
(5, 'شادي فروح', NULL, 'shadiFarouh@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:07:51', NULL, NULL, 745, 9),
(6, 'ايمن نجار', NULL, 'aymanNajar@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:07:39', NULL, NULL, 19, 4),
(7, 'مصعب الحسين', NULL, 'mosabAlhosain@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:07:27', NULL, NULL, 23, 10),
(8, 'عيسى احمد', NULL, 'issaAhmad@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:07:14', NULL, NULL, 24, 11),
(9, 'فراس قدور', NULL, 'firasKador@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:06:50', NULL, NULL, 25, 8),
(11, 'احمد ابراهيم', NULL, 'ahmadIbrahim@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:06:38', NULL, NULL, 27, 13),
(12, 'احمد قباطي قديم', NULL, 'ahmadKabati@test.com', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 4, NULL, '2021-12-22 08:06:08', NULL, NULL, 21, 6),
(22, 'feras Kador', NULL, 'ferasKador@alamera.com', '$2y$10$zAxPC9/7zjpTspDo1tNR8e0ZWuC0xbX35P8Tc/RviD10mTBAbIz9q', 4, '2021-11-21 12:57:28', '2021-12-22 08:07:02', NULL, NULL, 25, 8);

-- --------------------------------------------------------

--
-- Table structure for table `cms_users_old`
--

CREATE TABLE `cms_users_old` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cms_privileges` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_id` int DEFAULT NULL,
  `account_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_users_old`
--

INSERT INTO `cms_users_old` (`id`, `name`, `photo`, `email`, `password`, `id_cms_privileges`, `created_at`, `updated_at`, `status`, `inventory_id`, `account_id`) VALUES
(1, 'Super Admin', '/images/portfolio1_logo.png', 'superadmin@voila.digital', '$2y$10$zUf73J0YOPbLH/fIHgC.wOIA2ADWJxxleMm4RJjvuC3AA6VtNC.U6', 1, '2019-05-30 06:06:58', '2020-07-21 12:55:23', 'Active', NULL, 0),
(2, 'admin', '/images/portfolio1_logo.png', 'admin@voila.digital', '$2y$10$dZqguQ0G5A1y772hYvp6YOz.9umngOxSOF7//jUcXCFtAzfkyxngC', 2, '2019-06-18 06:02:41', '2019-11-13 07:34:57', 'Active', NULL, 0),
(20, 'اسامة', NULL, 'osama@amera.com', '$2y$10$5kVP2uYfWf5fkGJeNst2B.5HBzwp47pDacMVKcWSQuYlYHlLV0pXq', 4, '2020-07-02 08:10:40', '2020-07-02 08:53:11', NULL, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int NOT NULL,
  `name_en` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `in_used` tinyint DEFAULT '1',
  `is_major` tinyint DEFAULT '1',
  `note` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ex_rate` decimal(10,2) NOT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name_en`, `name_ar`, `in_used`, `is_major`, `note`, `ex_rate`, `active`, `sorting`) VALUES
(1, 'S.P', 'ل.س', 1, 1, 'العملة الاساسية', '3450.00', 1, 1),
(2, 'USD', 'دولار', 1, 0, NULL, '3900.00', 1, 2),
(3, 'euro', 'يورو', 1, 0, NULL, '2500.00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currency_history`
--

CREATE TABLE `currency_history` (
  `id` int NOT NULL,
  `ex_rate` decimal(10,0) DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `edit_by` int NOT NULL DEFAULT '0',
  `edit_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `currency_history`
--

INSERT INTO `currency_history` (`id`, `ex_rate`, `currency_id`, `edit_by`, `edit_at`, `active`, `sorting`) VALUES
(1, '2400', 2, 1, '2022-01-10 08:28:41', 1, NULL),
(2, '2300', 2, 1, '2022-01-10 08:28:58', 1, NULL),
(3, '3450', 1, 21, '2022-03-21 12:51:31', 1, NULL),
(4, '3900', 2, 21, '2022-03-23 12:48:55', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delegates`
--

CREATE TABLE `delegates` (
  `id` int NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `phone` int NOT NULL,
  `active` tinyint NOT NULL,
  `sorting` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `email_receiver`
--

CREATE TABLE `email_receiver` (
  `id` int NOT NULL,
  `email` longtext,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `email_receiver`
--

INSERT INTO `email_receiver` (`id`, `email`, `active`, `sorting`) VALUES
(2, 'balkis@voila.digital', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int NOT NULL,
  `entry_base_id` int DEFAULT NULL,
  `debit` decimal(50,2) DEFAULT NULL,
  `credit` decimal(50,2) DEFAULT NULL,
  `account_id` int DEFAULT NULL,
  `currency_id` int NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int DEFAULT '0',
  `rotate_year` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `entry_base_id`, `debit`, `credit`, `account_id`, `currency_id`, `ex_rate`, `equalizer`, `opposite`, `active`, `sorting`, `create_at`, `create_by`, `delete_at`, `delete_by`, `rotate_year`) VALUES
(1, 1, NULL, '12941.26', 63, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(2, 2, NULL, '700.00', 613, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(3, 3, NULL, '40.00', 614, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(4, 4, '15.50', NULL, 615, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(5, 5, '28.00', NULL, 616, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(6, 6, '40.50', NULL, 202, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(7, 7, '45.00', NULL, 391, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(8, 8, '59.00', NULL, 617, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(9, 9, '72.00', NULL, 618, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(10, 10, '75.00', NULL, 619, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(11, 11, '82.50', NULL, 620, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(12, 12, '85.50', NULL, 621, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(13, 13, '96.00', NULL, 622, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(14, 14, '119.50', NULL, 146, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(15, 15, '120.00', NULL, 623, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(16, 16, '122.15', NULL, 624, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(17, 17, '128.00', NULL, 625, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(18, 18, '130.00', NULL, 626, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(19, 19, '138.00', NULL, 627, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(20, 20, '139.00', NULL, 628, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(21, 21, '149.00', NULL, 629, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(22, 22, '152.00', NULL, 630, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(23, 23, '156.00', NULL, 631, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(24, 24, '156.00', NULL, 632, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(25, 25, '156.00', NULL, 633, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(26, 26, '160.00', NULL, 634, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(27, 27, '165.85', NULL, 635, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(28, 28, '176.00', NULL, 636, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(29, 29, '187.90', NULL, 637, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(30, 30, '200.00', NULL, 137, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(31, 31, '200.00', NULL, 152, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(32, 32, '203.00', NULL, 638, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(33, 33, '205.50', NULL, 110, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(34, 34, '214.00', NULL, 639, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(35, 35, '216.00', NULL, 408, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(36, 36, '240.00', NULL, 116, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(37, 37, '240.50', NULL, 640, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(38, 38, '241.00', NULL, 641, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(39, 39, '248.00', NULL, 642, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(40, 40, '260.00', NULL, 135, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(41, 41, '264.00', NULL, 643, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(42, 42, '270.00', NULL, 112, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(43, 43, '270.00', NULL, 644, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(44, 44, '288.00', NULL, 645, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(45, 45, '309.00', NULL, 646, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(46, 46, '310.00', NULL, 647, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(47, 47, '313.90', NULL, 648, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(48, 48, '322.00', NULL, 89, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(49, 49, '330.00', NULL, 649, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(50, 50, '335.50', NULL, 232, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(51, 51, '350.00', NULL, 650, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(52, 52, '350.00', NULL, 651, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(53, 53, '361.00', NULL, 652, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(54, 54, '382.00', NULL, 653, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(55, 55, '420.00', NULL, 654, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(56, 56, '421.00', NULL, 655, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(57, 57, '447.50', NULL, 656, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(58, 58, '472.00', NULL, 151, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(59, 59, '541.80', NULL, 346, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(60, 60, '580.50', NULL, 657, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(61, 61, '643.00', NULL, 658, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(62, 62, '700.00', NULL, 70, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(63, 63, '703.00', NULL, 659, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(64, 64, '720.00', NULL, 155, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(65, 65, '721.00', NULL, 660, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(66, 66, '730.10', NULL, 661, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(67, 67, '734.00', NULL, 662, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(68, 68, '735.00', NULL, 663, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(69, 69, '739.50', NULL, 104, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(70, 70, '760.00', NULL, 664, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(71, 71, '779.00', NULL, 665, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(72, 72, '791.00', NULL, 666, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(73, 73, '801.50', NULL, 667, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(74, 74, '810.00', NULL, 668, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(75, 75, '821.50', NULL, 405, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(76, 76, '900.00', NULL, 413, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(77, 77, '910.00', NULL, 385, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(78, 78, '934.50', NULL, 669, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(79, 79, '971.00', NULL, 670, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(80, 80, '1000.50', NULL, 671, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(81, 81, '1138.00', NULL, 672, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(82, 82, '1249.00', NULL, 673, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(83, 83, '1275.00', NULL, 674, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(84, 84, '1278.30', NULL, 675, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(85, 85, '1424.00', NULL, 676, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(86, 86, '1440.00', NULL, 677, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(87, 87, '1488.00', NULL, 678, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(88, 88, '1499.00', NULL, 679, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(89, 89, '1525.00', NULL, 680, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(90, 90, '1544.50', NULL, 141, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(91, 91, '1550.00', NULL, 681, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(92, 92, '1576.00', NULL, 682, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(93, 93, '1611.50', NULL, 131, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(94, 94, '1626.00', NULL, 683, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(95, 95, '1678.00', NULL, 684, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(96, 96, '1709.00', NULL, 129, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(97, 97, '1780.50', NULL, 685, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(98, 98, '1826.20', NULL, 686, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(99, 99, '1827.00', NULL, 687, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(100, 100, '1860.00', NULL, 688, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(101, 101, '1876.00', NULL, 689, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(102, 102, '1919.00', NULL, 690, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(103, 103, '1956.00', NULL, 526, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(104, 104, '1970.00', NULL, 691, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(105, 105, '1975.00', NULL, 85, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(106, 106, '2000.00', NULL, 40, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(107, 107, '2000.00', NULL, 69, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(108, 108, '2025.00', NULL, 119, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(109, 109, '2040.00', NULL, 231, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(110, 110, '2042.00', NULL, 692, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(111, 111, '2072.00', NULL, 96, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(112, 112, '2188.00', NULL, 693, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(113, 113, '2257.00', NULL, 694, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(114, 114, '2300.00', NULL, 695, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(115, 115, '2497.45', NULL, 696, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(116, 116, '2530.00', NULL, 697, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(117, 117, '2530.50', NULL, 698, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(118, 118, '2547.00', NULL, 699, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(119, 119, '2590.00', NULL, 700, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(120, 120, '2711.00', NULL, 701, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(121, 121, '2731.00', NULL, 702, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(122, 122, '2769.00', NULL, 703, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(123, 123, '2955.00', NULL, 704, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(124, 124, '3000.00', NULL, 705, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(125, 125, '3040.35', NULL, 403, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(126, 126, '3071.00', NULL, 706, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(127, 127, '3090.00', NULL, 707, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(128, 128, '3316.00', NULL, 48, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(129, 129, '3353.75', NULL, 708, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(130, 130, '3472.00', NULL, 363, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(131, 131, '3481.60', NULL, 709, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(132, 132, '3494.85', NULL, 710, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(133, 133, '3653.00', NULL, 711, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(134, 134, '3698.00', NULL, 712, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(135, 135, '3792.00', NULL, 527, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(136, 136, '3891.00', NULL, 713, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(137, 137, '4128.50', NULL, 714, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(138, 138, '4240.00', NULL, 130, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(139, 139, '4517.00', NULL, 715, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(140, 140, '4621.50', NULL, 716, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(141, 141, '4684.00', NULL, 717, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(142, 142, '4750.00', NULL, 718, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(143, 143, '4768.90', NULL, 719, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(144, 144, '5280.00', NULL, 720, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(145, 145, '5291.00', NULL, 721, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(146, 146, '5442.00', NULL, 722, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(147, 147, '6101.00', NULL, 723, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(148, 148, '6242.00', NULL, 84, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(149, 149, '6588.00', NULL, 724, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(150, 150, '6670.00', NULL, 725, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(151, 151, '6784.50', NULL, 726, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(152, 152, '7081.00', NULL, 727, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(153, 153, '7568.75', NULL, 728, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(154, 154, '8448.00', NULL, 729, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(155, 155, '9417.00', NULL, 730, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(156, 156, '9872.00', NULL, 731, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(157, 157, '10178.00', NULL, 100, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(158, 158, '10394.00', NULL, 732, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(159, 159, '11739.80', NULL, 733, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(160, 160, '15331.75', NULL, 734, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(161, 161, '15724.51', NULL, 735, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(162, 162, '17000.00', NULL, 736, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(163, 163, '17191.50', NULL, 221, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(164, 164, '18456.00', NULL, 737, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(165, 165, '19185.08', NULL, 738, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(166, 166, '34000.00', NULL, 739, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(167, 167, '35687.00', NULL, 740, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(168, 168, '71734.02', NULL, 741, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(169, 169, '75600.00', NULL, 307, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(170, 170, '225500.00', NULL, 742, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(171, 171, '306250.00', NULL, 743, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(172, 172, '420000.00', NULL, 744, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(173, 173, '1419000.00', NULL, 19, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(174, 174, '30806475.00', NULL, 20, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(175, 175, NULL, '172000.00', 21, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(176, 176, '4978000.00', NULL, 22, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(177, 177, '227100.00', NULL, 23, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(178, 178, '0.00', NULL, 24, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(179, 179, '159000.00', NULL, 25, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(180, 180, NULL, '10548500.00', 26, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(181, 181, '3482300.00', NULL, 27, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(182, 182, '917252.00', NULL, 745, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(183, 183, '87700.00', NULL, 746, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(184, 184, '500000.00', NULL, 747, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(185, 185, '100.00', NULL, 20, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(186, 186, '2076.00', NULL, 22, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(187, 187, '500.00', NULL, 23, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(188, 188, '3100.00', NULL, 27, 2, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL),
(193, 191, '500.00', NULL, 26, 2, '3450.00', '500.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(194, 191, NULL, '500.00', 562, 2, '3450.00', '500.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(195, 192, '163.00', NULL, 26, 2, '3450.00', '163.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(196, 192, NULL, '163.00', 539, 2, '3450.00', '163.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(197, 193, '214.00', NULL, 26, 2, '3450.00', '214.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(198, 193, NULL, '214.00', 563, 2, '3450.00', '214.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(199, 194, '2250.00', NULL, 26, 2, '3450.00', '2250.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(200, 194, NULL, '2250.00', 564, 2, '3450.00', '2250.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(201, 195, '2250.00', NULL, 26, 2, '3450.00', '2250.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(202, 195, NULL, '2250.00', 564, 2, '3450.00', '2250.00', 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(203, 196, '2250.00', NULL, 564, 2, '2300.00', '5175000.00', NULL, 1, NULL, NULL, NULL, '2021-12-07 10:34:38', 1, NULL),
(204, 196, NULL, '2250.00', NULL, 2, '2300.00', '5175000.00', NULL, 1, NULL, NULL, NULL, '2021-12-07 10:34:38', 1, NULL),
(205, 197, '19000.00', NULL, 29, 1, '1.00', '19000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(206, 197, NULL, '19000.00', 26, 1, '1.00', '19000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(207, 198, '40000.00', NULL, 29, 1, '1.00', '40000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(208, 198, NULL, '40000.00', 26, 1, '1.00', '40000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(209, 199, '75000.00', NULL, 30, 1, '1.00', '75000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(210, 199, NULL, '75000.00', 26, 1, '1.00', '75000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(211, 200, '40000.00', NULL, 30, 1, '1.00', '40000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(212, 200, NULL, '40000.00', 26, 1, '1.00', '40000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(213, 201, '8000.00', NULL, 30, 1, '1.00', '8000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(214, 201, NULL, '8000.00', 26, 1, '1.00', '8000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(215, 202, '19000.00', NULL, 29, 1, '1.00', '19000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(216, 202, NULL, '19000.00', 26, 1, '1.00', '19000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(217, 203, '8800000.00', NULL, 19, 1, '1.00', '8800000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(218, 203, NULL, '8800000.00', 26, 1, '1.00', '8800000.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(219, 204, '1500.00', NULL, 31, 1, '1.00', '1500.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(220, 204, NULL, '1500.00', 26, 1, '1.00', '1500.00', 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(221, 205, '2250.00', NULL, 564, 2, '2300.00', '5175000.00', NULL, 1, NULL, '2021-12-07 10:34:38', 1, '2021-12-16 10:41:39', 21, NULL),
(222, 205, NULL, '2250.00', 35, 2, '2300.00', '5175000.00', NULL, 1, NULL, '2021-12-07 10:34:38', 1, '2021-12-16 10:41:39', 21, NULL),
(223, 206, '6524000.00', NULL, 26, 1, '3450.00', '1891.01', 2, 1, NULL, '2021-12-14 11:07:31', 21, '2021-12-14 11:13:45', 21, NULL),
(224, 206, NULL, '1891.01', 540, 2, '3450.00', '1891.01', 2, 1, NULL, '2021-12-14 11:07:31', 21, '2021-12-14 11:13:45', 21, NULL),
(225, 207, '2760000.00', NULL, 26, 1, '3450.00', '800.00', 2, 1, NULL, '2021-12-14 11:12:07', 21, NULL, 0, NULL),
(226, 207, NULL, '800.00', 662, 2, '3450.00', '800.00', 2, 1, NULL, '2021-12-14 11:12:07', 21, NULL, 0, NULL),
(227, 208, '300.00', NULL, 26, 2, '2300.00', '300.00', 2, 1, NULL, '2021-12-14 11:12:59', 21, NULL, 0, NULL),
(228, 208, NULL, '300.00', 562, 2, '2300.00', '300.00', 2, 1, NULL, '2021-12-14 11:12:59', 21, NULL, 0, NULL),
(229, 209, '6524000.00', NULL, 26, 1, '1.00', '6524000.00', 1, 1, NULL, '2021-12-14 11:13:45', 21, NULL, 0, NULL),
(230, 209, NULL, '6524000.00', 540, 1, '1.00', '6524000.00', 1, 1, NULL, '2021-12-14 11:13:45', 21, NULL, 0, NULL),
(231, 210, '187000.00', NULL, 26, 1, '3450.00', '54.20', 2, 1, NULL, '2021-12-15 12:41:11', 21, '2022-03-21 08:51:31', 21, NULL),
(232, 210, NULL, '54.20', 537, 2, '3450.00', '54.20', 2, 1, NULL, '2021-12-15 12:41:11', 21, '2022-03-21 08:51:31', 21, NULL),
(233, 211, '2250.00', NULL, 564, 2, '2300.00', '5175000.00', NULL, 1, NULL, '2021-12-16 10:41:39', 21, '2021-12-22 08:12:02', 1, NULL),
(234, 211, NULL, '2250.00', 35, 2, '2300.00', '5175000.00', NULL, 1, NULL, '2021-12-16 10:41:39', 21, '2021-12-22 08:12:02', 1, NULL),
(235, 212, '0.00', NULL, 26, 1, '3450.00', '54.20', 2, 1, NULL, '2022-03-21 10:51:31', 21, NULL, 0, NULL),
(236, 212, NULL, '54.20', 537, 2, '3450.00', '54.20', 2, 1, NULL, '2022-03-21 10:51:31', 21, NULL, 0, NULL),
(237, 213, '56.00', NULL, 26, 2, '3900.00', '56.00', 2, 1, NULL, '2022-03-23 10:48:56', 21, NULL, 0, NULL),
(238, 213, NULL, '56.00', 531, 2, '3900.00', '56.00', 2, 1, NULL, '2022-03-23 10:48:56', 21, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entry_base`
--

CREATE TABLE `entry_base` (
  `id` int NOT NULL,
  `entry_number` int DEFAULT NULL,
  `narration` varchar(1000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bill_id` int DEFAULT NULL,
  `voucher_id` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int DEFAULT '0',
  `rotate_year` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `entry_base`
--

INSERT INTO `entry_base` (`id`, `entry_number`, `narration`, `date`, `bill_id`, `voucher_id`, `active`, `sorting`, `create_at`, `create_by`, `delete_at`, `delete_by`, `rotate_year`) VALUES
(1, 1, 'سند افتتاحي', '2021-11-17', NULL, 1, 1, NULL, NULL, NULL, NULL, 0, NULL),
(2, 2, 'سند افتتاحي', '2021-11-17', NULL, 2, 1, NULL, NULL, NULL, NULL, 0, NULL),
(3, 3, 'سند افتتاحي', '2021-11-17', NULL, 3, 1, NULL, NULL, NULL, NULL, 0, NULL),
(4, 4, 'سند افتتاحي', '2021-11-17', NULL, 4, 1, NULL, NULL, NULL, NULL, 0, NULL),
(5, 5, 'سند افتتاحي', '2021-11-17', NULL, 5, 1, NULL, NULL, NULL, NULL, 0, NULL),
(6, 6, 'سند افتتاحي', '2021-11-17', NULL, 6, 1, NULL, NULL, NULL, NULL, 0, NULL),
(7, 7, 'سند افتتاحي', '2021-11-17', NULL, 7, 1, NULL, NULL, NULL, NULL, 0, NULL),
(8, 8, 'سند افتتاحي', '2021-11-17', NULL, 8, 1, NULL, NULL, NULL, NULL, 0, NULL),
(9, 9, 'سند افتتاحي', '2021-11-17', NULL, 9, 1, NULL, NULL, NULL, NULL, 0, NULL),
(10, 10, 'سند افتتاحي', '2021-11-17', NULL, 10, 1, NULL, NULL, NULL, NULL, 0, NULL),
(11, 11, 'سند افتتاحي', '2021-11-17', NULL, 11, 1, NULL, NULL, NULL, NULL, 0, NULL),
(12, 12, 'سند افتتاحي', '2021-11-17', NULL, 12, 1, NULL, NULL, NULL, NULL, 0, NULL),
(13, 13, 'سند افتتاحي', '2021-11-17', NULL, 13, 1, NULL, NULL, NULL, NULL, 0, NULL),
(14, 14, 'سند افتتاحي', '2021-11-17', NULL, 14, 1, NULL, NULL, NULL, NULL, 0, NULL),
(15, 15, 'سند افتتاحي', '2021-11-17', NULL, 15, 1, NULL, NULL, NULL, NULL, 0, NULL),
(16, 16, 'سند افتتاحي', '2021-11-17', NULL, 16, 1, NULL, NULL, NULL, NULL, 0, NULL),
(17, 17, 'سند افتتاحي', '2021-11-17', NULL, 17, 1, NULL, NULL, NULL, NULL, 0, NULL),
(18, 18, 'سند افتتاحي', '2021-11-17', NULL, 18, 1, NULL, NULL, NULL, NULL, 0, NULL),
(19, 19, 'سند افتتاحي', '2021-11-17', NULL, 19, 1, NULL, NULL, NULL, NULL, 0, NULL),
(20, 20, 'سند افتتاحي', '2021-11-17', NULL, 20, 1, NULL, NULL, NULL, NULL, 0, NULL),
(21, 21, 'سند افتتاحي', '2021-11-17', NULL, 21, 1, NULL, NULL, NULL, NULL, 0, NULL),
(22, 22, 'سند افتتاحي', '2021-11-17', NULL, 22, 1, NULL, NULL, NULL, NULL, 0, NULL),
(23, 23, 'سند افتتاحي', '2021-11-17', NULL, 23, 1, NULL, NULL, NULL, NULL, 0, NULL),
(24, 24, 'سند افتتاحي', '2021-11-17', NULL, 24, 1, NULL, NULL, NULL, NULL, 0, NULL),
(25, 25, 'سند افتتاحي', '2021-11-17', NULL, 25, 1, NULL, NULL, NULL, NULL, 0, NULL),
(26, 26, 'سند افتتاحي', '2021-11-17', NULL, 26, 1, NULL, NULL, NULL, NULL, 0, NULL),
(27, 27, 'سند افتتاحي', '2021-11-17', NULL, 27, 1, NULL, NULL, NULL, NULL, 0, NULL),
(28, 28, 'سند افتتاحي', '2021-11-17', NULL, 28, 1, NULL, NULL, NULL, NULL, 0, NULL),
(29, 29, 'سند افتتاحي', '2021-11-17', NULL, 29, 1, NULL, NULL, NULL, NULL, 0, NULL),
(30, 30, 'سند افتتاحي', '2021-11-17', NULL, 30, 1, NULL, NULL, NULL, NULL, 0, NULL),
(31, 31, 'سند افتتاحي', '2021-11-17', NULL, 31, 1, NULL, NULL, NULL, NULL, 0, NULL),
(32, 32, 'سند افتتاحي', '2021-11-17', NULL, 32, 1, NULL, NULL, NULL, NULL, 0, NULL),
(33, 33, 'سند افتتاحي', '2021-11-17', NULL, 33, 1, NULL, NULL, NULL, NULL, 0, NULL),
(34, 34, 'سند افتتاحي', '2021-11-17', NULL, 34, 1, NULL, NULL, NULL, NULL, 0, NULL),
(35, 35, 'سند افتتاحي', '2021-11-17', NULL, 35, 1, NULL, NULL, NULL, NULL, 0, NULL),
(36, 36, 'سند افتتاحي', '2021-11-17', NULL, 36, 1, NULL, NULL, NULL, NULL, 0, NULL),
(37, 37, 'سند افتتاحي', '2021-11-17', NULL, 37, 1, NULL, NULL, NULL, NULL, 0, NULL),
(38, 38, 'سند افتتاحي', '2021-11-17', NULL, 38, 1, NULL, NULL, NULL, NULL, 0, NULL),
(39, 39, 'سند افتتاحي', '2021-11-17', NULL, 39, 1, NULL, NULL, NULL, NULL, 0, NULL),
(40, 40, 'سند افتتاحي', '2021-11-17', NULL, 40, 1, NULL, NULL, NULL, NULL, 0, NULL),
(41, 41, 'سند افتتاحي', '2021-11-17', NULL, 41, 1, NULL, NULL, NULL, NULL, 0, NULL),
(42, 42, 'سند افتتاحي', '2021-11-17', NULL, 42, 1, NULL, NULL, NULL, NULL, 0, NULL),
(43, 43, 'سند افتتاحي', '2021-11-17', NULL, 43, 1, NULL, NULL, NULL, NULL, 0, NULL),
(44, 44, 'سند افتتاحي', '2021-11-17', NULL, 44, 1, NULL, NULL, NULL, NULL, 0, NULL),
(45, 45, 'سند افتتاحي', '2021-11-17', NULL, 45, 1, NULL, NULL, NULL, NULL, 0, NULL),
(46, 46, 'سند افتتاحي', '2021-11-17', NULL, 46, 1, NULL, NULL, NULL, NULL, 0, NULL),
(47, 47, 'سند افتتاحي', '2021-11-17', NULL, 47, 1, NULL, NULL, NULL, NULL, 0, NULL),
(48, 48, 'سند افتتاحي', '2021-11-17', NULL, 48, 1, NULL, NULL, NULL, NULL, 0, NULL),
(49, 49, 'سند افتتاحي', '2021-11-17', NULL, 49, 1, NULL, NULL, NULL, NULL, 0, NULL),
(50, 50, 'سند افتتاحي', '2021-11-17', NULL, 50, 1, NULL, NULL, NULL, NULL, 0, NULL),
(51, 51, 'سند افتتاحي', '2021-11-17', NULL, 51, 1, NULL, NULL, NULL, NULL, 0, NULL),
(52, 52, 'سند افتتاحي', '2021-11-17', NULL, 52, 1, NULL, NULL, NULL, NULL, 0, NULL),
(53, 53, 'سند افتتاحي', '2021-11-17', NULL, 53, 1, NULL, NULL, NULL, NULL, 0, NULL),
(54, 54, 'سند افتتاحي', '2021-11-17', NULL, 54, 1, NULL, NULL, NULL, NULL, 0, NULL),
(55, 55, 'سند افتتاحي', '2021-11-17', NULL, 55, 1, NULL, NULL, NULL, NULL, 0, NULL),
(56, 56, 'سند افتتاحي', '2021-11-17', NULL, 56, 1, NULL, NULL, NULL, NULL, 0, NULL),
(57, 57, 'سند افتتاحي', '2021-11-17', NULL, 57, 1, NULL, NULL, NULL, NULL, 0, NULL),
(58, 58, 'سند افتتاحي', '2021-11-17', NULL, 58, 1, NULL, NULL, NULL, NULL, 0, NULL),
(59, 59, 'سند افتتاحي', '2021-11-17', NULL, 59, 1, NULL, NULL, NULL, NULL, 0, NULL),
(60, 60, 'سند افتتاحي', '2021-11-17', NULL, 60, 1, NULL, NULL, NULL, NULL, 0, NULL),
(61, 61, 'سند افتتاحي', '2021-11-17', NULL, 61, 1, NULL, NULL, NULL, NULL, 0, NULL),
(62, 62, 'سند افتتاحي', '2021-11-17', NULL, 62, 1, NULL, NULL, NULL, NULL, 0, NULL),
(63, 63, 'سند افتتاحي', '2021-11-17', NULL, 63, 1, NULL, NULL, NULL, NULL, 0, NULL),
(64, 64, 'سند افتتاحي', '2021-11-17', NULL, 64, 1, NULL, NULL, NULL, NULL, 0, NULL),
(65, 65, 'سند افتتاحي', '2021-11-17', NULL, 65, 1, NULL, NULL, NULL, NULL, 0, NULL),
(66, 66, 'سند افتتاحي', '2021-11-17', NULL, 66, 1, NULL, NULL, NULL, NULL, 0, NULL),
(67, 67, 'سند افتتاحي', '2021-11-17', NULL, 67, 1, NULL, NULL, NULL, NULL, 0, NULL),
(68, 68, 'سند افتتاحي', '2021-11-17', NULL, 68, 1, NULL, NULL, NULL, NULL, 0, NULL),
(69, 69, 'سند افتتاحي', '2021-11-17', NULL, 69, 1, NULL, NULL, NULL, NULL, 0, NULL),
(70, 70, 'سند افتتاحي', '2021-11-17', NULL, 70, 1, NULL, NULL, NULL, NULL, 0, NULL),
(71, 71, 'سند افتتاحي', '2021-11-17', NULL, 71, 1, NULL, NULL, NULL, NULL, 0, NULL),
(72, 72, 'سند افتتاحي', '2021-11-17', NULL, 72, 1, NULL, NULL, NULL, NULL, 0, NULL),
(73, 73, 'سند افتتاحي', '2021-11-17', NULL, 73, 1, NULL, NULL, NULL, NULL, 0, NULL),
(74, 74, 'سند افتتاحي', '2021-11-17', NULL, 74, 1, NULL, NULL, NULL, NULL, 0, NULL),
(75, 75, 'سند افتتاحي', '2021-11-17', NULL, 75, 1, NULL, NULL, NULL, NULL, 0, NULL),
(76, 76, 'سند افتتاحي', '2021-11-17', NULL, 76, 1, NULL, NULL, NULL, NULL, 0, NULL),
(77, 77, 'سند افتتاحي', '2021-11-17', NULL, 77, 1, NULL, NULL, NULL, NULL, 0, NULL),
(78, 78, 'سند افتتاحي', '2021-11-17', NULL, 78, 1, NULL, NULL, NULL, NULL, 0, NULL),
(79, 79, 'سند افتتاحي', '2021-11-17', NULL, 79, 1, NULL, NULL, NULL, NULL, 0, NULL),
(80, 80, 'سند افتتاحي', '2021-11-17', NULL, 80, 1, NULL, NULL, NULL, NULL, 0, NULL),
(81, 81, 'سند افتتاحي', '2021-11-17', NULL, 81, 1, NULL, NULL, NULL, NULL, 0, NULL),
(82, 82, 'سند افتتاحي', '2021-11-17', NULL, 82, 1, NULL, NULL, NULL, NULL, 0, NULL),
(83, 83, 'سند افتتاحي', '2021-11-17', NULL, 83, 1, NULL, NULL, NULL, NULL, 0, NULL),
(84, 84, 'سند افتتاحي', '2021-11-17', NULL, 84, 1, NULL, NULL, NULL, NULL, 0, NULL),
(85, 85, 'سند افتتاحي', '2021-11-17', NULL, 85, 1, NULL, NULL, NULL, NULL, 0, NULL),
(86, 86, 'سند افتتاحي', '2021-11-17', NULL, 86, 1, NULL, NULL, NULL, NULL, 0, NULL),
(87, 87, 'سند افتتاحي', '2021-11-17', NULL, 87, 1, NULL, NULL, NULL, NULL, 0, NULL),
(88, 88, 'سند افتتاحي', '2021-11-17', NULL, 88, 1, NULL, NULL, NULL, NULL, 0, NULL),
(89, 89, 'سند افتتاحي', '2021-11-17', NULL, 89, 1, NULL, NULL, NULL, NULL, 0, NULL),
(90, 90, 'سند افتتاحي', '2021-11-17', NULL, 90, 1, NULL, NULL, NULL, NULL, 0, NULL),
(91, 91, 'سند افتتاحي', '2021-11-17', NULL, 91, 1, NULL, NULL, NULL, NULL, 0, NULL),
(92, 92, 'سند افتتاحي', '2021-11-17', NULL, 92, 1, NULL, NULL, NULL, NULL, 0, NULL),
(93, 93, 'سند افتتاحي', '2021-11-17', NULL, 93, 1, NULL, NULL, NULL, NULL, 0, NULL),
(94, 94, 'سند افتتاحي', '2021-11-17', NULL, 94, 1, NULL, NULL, NULL, NULL, 0, NULL),
(95, 95, 'سند افتتاحي', '2021-11-17', NULL, 95, 1, NULL, NULL, NULL, NULL, 0, NULL),
(96, 96, 'سند افتتاحي', '2021-11-17', NULL, 96, 1, NULL, NULL, NULL, NULL, 0, NULL),
(97, 97, 'سند افتتاحي', '2021-11-17', NULL, 97, 1, NULL, NULL, NULL, NULL, 0, NULL),
(98, 98, 'سند افتتاحي', '2021-11-17', NULL, 98, 1, NULL, NULL, NULL, NULL, 0, NULL),
(99, 99, 'سند افتتاحي', '2021-11-17', NULL, 99, 1, NULL, NULL, NULL, NULL, 0, NULL),
(100, 100, 'سند افتتاحي', '2021-11-17', NULL, 100, 1, NULL, NULL, NULL, NULL, 0, NULL),
(101, 101, 'سند افتتاحي', '2021-11-17', NULL, 101, 1, NULL, NULL, NULL, NULL, 0, NULL),
(102, 102, 'سند افتتاحي', '2021-11-17', NULL, 102, 1, NULL, NULL, NULL, NULL, 0, NULL),
(103, 103, 'سند افتتاحي', '2021-11-17', NULL, 103, 1, NULL, NULL, NULL, NULL, 0, NULL),
(104, 104, 'سند افتتاحي', '2021-11-17', NULL, 104, 1, NULL, NULL, NULL, NULL, 0, NULL),
(105, 105, 'سند افتتاحي', '2021-11-17', NULL, 105, 1, NULL, NULL, NULL, NULL, 0, NULL),
(106, 106, 'سند افتتاحي', '2021-11-17', NULL, 106, 1, NULL, NULL, NULL, NULL, 0, NULL),
(107, 107, 'سند افتتاحي', '2021-11-17', NULL, 107, 1, NULL, NULL, NULL, NULL, 0, NULL),
(108, 108, 'سند افتتاحي', '2021-11-17', NULL, 108, 1, NULL, NULL, NULL, NULL, 0, NULL),
(109, 109, 'سند افتتاحي', '2021-11-17', NULL, 109, 1, NULL, NULL, NULL, NULL, 0, NULL),
(110, 110, 'سند افتتاحي', '2021-11-17', NULL, 110, 1, NULL, NULL, NULL, NULL, 0, NULL),
(111, 111, 'سند افتتاحي', '2021-11-17', NULL, 111, 1, NULL, NULL, NULL, NULL, 0, NULL),
(112, 112, 'سند افتتاحي', '2021-11-17', NULL, 112, 1, NULL, NULL, NULL, NULL, 0, NULL),
(113, 113, 'سند افتتاحي', '2021-11-17', NULL, 113, 1, NULL, NULL, NULL, NULL, 0, NULL),
(114, 114, 'سند افتتاحي', '2021-11-17', NULL, 114, 1, NULL, NULL, NULL, NULL, 0, NULL),
(115, 115, 'سند افتتاحي', '2021-11-17', NULL, 115, 1, NULL, NULL, NULL, NULL, 0, NULL),
(116, 116, 'سند افتتاحي', '2021-11-17', NULL, 116, 1, NULL, NULL, NULL, NULL, 0, NULL),
(117, 117, 'سند افتتاحي', '2021-11-17', NULL, 117, 1, NULL, NULL, NULL, NULL, 0, NULL),
(118, 118, 'سند افتتاحي', '2021-11-17', NULL, 118, 1, NULL, NULL, NULL, NULL, 0, NULL),
(119, 119, 'سند افتتاحي', '2021-11-17', NULL, 119, 1, NULL, NULL, NULL, NULL, 0, NULL),
(120, 120, 'سند افتتاحي', '2021-11-17', NULL, 120, 1, NULL, NULL, NULL, NULL, 0, NULL),
(121, 121, 'سند افتتاحي', '2021-11-17', NULL, 121, 1, NULL, NULL, NULL, NULL, 0, NULL),
(122, 122, 'سند افتتاحي', '2021-11-17', NULL, 122, 1, NULL, NULL, NULL, NULL, 0, NULL),
(123, 123, 'سند افتتاحي', '2021-11-17', NULL, 123, 1, NULL, NULL, NULL, NULL, 0, NULL),
(124, 124, 'سند افتتاحي', '2021-11-17', NULL, 124, 1, NULL, NULL, NULL, NULL, 0, NULL),
(125, 125, 'سند افتتاحي', '2021-11-17', NULL, 125, 1, NULL, NULL, NULL, NULL, 0, NULL),
(126, 126, 'سند افتتاحي', '2021-11-17', NULL, 126, 1, NULL, NULL, NULL, NULL, 0, NULL),
(127, 127, 'سند افتتاحي', '2021-11-17', NULL, 127, 1, NULL, NULL, NULL, NULL, 0, NULL),
(128, 128, 'سند افتتاحي', '2021-11-17', NULL, 128, 1, NULL, NULL, NULL, NULL, 0, NULL),
(129, 129, 'سند افتتاحي', '2021-11-17', NULL, 129, 1, NULL, NULL, NULL, NULL, 0, NULL),
(130, 130, 'سند افتتاحي', '2021-11-17', NULL, 130, 1, NULL, NULL, NULL, NULL, 0, NULL),
(131, 131, 'سند افتتاحي', '2021-11-17', NULL, 131, 1, NULL, NULL, NULL, NULL, 0, NULL),
(132, 132, 'سند افتتاحي', '2021-11-17', NULL, 132, 1, NULL, NULL, NULL, NULL, 0, NULL),
(133, 133, 'سند افتتاحي', '2021-11-17', NULL, 133, 1, NULL, NULL, NULL, NULL, 0, NULL),
(134, 134, 'سند افتتاحي', '2021-11-17', NULL, 134, 1, NULL, NULL, NULL, NULL, 0, NULL),
(135, 135, 'سند افتتاحي', '2021-11-17', NULL, 135, 1, NULL, NULL, NULL, NULL, 0, NULL),
(136, 136, 'سند افتتاحي', '2021-11-17', NULL, 136, 1, NULL, NULL, NULL, NULL, 0, NULL),
(137, 137, 'سند افتتاحي', '2021-11-17', NULL, 137, 1, NULL, NULL, NULL, NULL, 0, NULL),
(138, 138, 'سند افتتاحي', '2021-11-17', NULL, 138, 1, NULL, NULL, NULL, NULL, 0, NULL),
(139, 139, 'سند افتتاحي', '2021-11-17', NULL, 139, 1, NULL, NULL, NULL, NULL, 0, NULL),
(140, 140, 'سند افتتاحي', '2021-11-17', NULL, 140, 1, NULL, NULL, NULL, NULL, 0, NULL),
(141, 141, 'سند افتتاحي', '2021-11-17', NULL, 141, 1, NULL, NULL, NULL, NULL, 0, NULL),
(142, 142, 'سند افتتاحي', '2021-11-17', NULL, 142, 1, NULL, NULL, NULL, NULL, 0, NULL),
(143, 143, 'سند افتتاحي', '2021-11-17', NULL, 143, 1, NULL, NULL, NULL, NULL, 0, NULL),
(144, 144, 'سند افتتاحي', '2021-11-17', NULL, 144, 1, NULL, NULL, NULL, NULL, 0, NULL),
(145, 145, 'سند افتتاحي', '2021-11-17', NULL, 145, 1, NULL, NULL, NULL, NULL, 0, NULL),
(146, 146, 'سند افتتاحي', '2021-11-17', NULL, 146, 1, NULL, NULL, NULL, NULL, 0, NULL),
(147, 147, 'سند افتتاحي', '2021-11-17', NULL, 147, 1, NULL, NULL, NULL, NULL, 0, NULL),
(148, 148, 'سند افتتاحي', '2021-11-17', NULL, 148, 1, NULL, NULL, NULL, NULL, 0, NULL),
(149, 149, 'سند افتتاحي', '2021-11-17', NULL, 149, 1, NULL, NULL, NULL, NULL, 0, NULL),
(150, 150, 'سند افتتاحي', '2021-11-17', NULL, 150, 1, NULL, NULL, NULL, NULL, 0, NULL),
(151, 151, 'سند افتتاحي', '2021-11-17', NULL, 151, 1, NULL, NULL, NULL, NULL, 0, NULL),
(152, 152, 'سند افتتاحي', '2021-11-17', NULL, 152, 1, NULL, NULL, NULL, NULL, 0, NULL),
(153, 153, 'سند افتتاحي', '2021-11-17', NULL, 153, 1, NULL, NULL, NULL, NULL, 0, NULL),
(154, 154, 'سند افتتاحي', '2021-11-17', NULL, 154, 1, NULL, NULL, NULL, NULL, 0, NULL),
(155, 155, 'سند افتتاحي', '2021-11-17', NULL, 155, 1, NULL, NULL, NULL, NULL, 0, NULL),
(156, 156, 'سند افتتاحي', '2021-11-17', NULL, 156, 1, NULL, NULL, NULL, NULL, 0, NULL),
(157, 157, 'سند افتتاحي', '2021-11-17', NULL, 157, 1, NULL, NULL, NULL, NULL, 0, NULL),
(158, 158, 'سند افتتاحي', '2021-11-17', NULL, 158, 1, NULL, NULL, NULL, NULL, 0, NULL),
(159, 159, 'سند افتتاحي', '2021-11-17', NULL, 159, 1, NULL, NULL, NULL, NULL, 0, NULL),
(160, 160, 'سند افتتاحي', '2021-11-17', NULL, 160, 1, NULL, NULL, NULL, NULL, 0, NULL),
(161, 161, 'سند افتتاحي', '2021-11-17', NULL, 161, 1, NULL, NULL, NULL, NULL, 0, NULL),
(162, 162, 'سند افتتاحي', '2021-11-17', NULL, 162, 1, NULL, NULL, NULL, NULL, 0, NULL),
(163, 163, 'سند افتتاحي', '2021-11-17', NULL, 163, 1, NULL, NULL, NULL, NULL, 0, NULL),
(164, 164, 'سند افتتاحي', '2021-11-17', NULL, 164, 1, NULL, NULL, NULL, NULL, 0, NULL),
(165, 165, 'سند افتتاحي', '2021-11-17', NULL, 165, 1, NULL, NULL, NULL, NULL, 0, NULL),
(166, 166, 'سند افتتاحي', '2021-11-17', NULL, 166, 1, NULL, NULL, NULL, NULL, 0, NULL),
(167, 167, 'سند افتتاحي', '2021-11-17', NULL, 167, 1, NULL, NULL, NULL, NULL, 0, NULL),
(168, 168, 'سند افتتاحي', '2021-11-17', NULL, 168, 1, NULL, NULL, NULL, NULL, 0, NULL),
(169, 169, 'سند افتتاحي', '2021-11-17', NULL, 169, 1, NULL, NULL, NULL, NULL, 0, NULL),
(170, 170, 'سند افتتاحي', '2021-11-17', NULL, 170, 1, NULL, NULL, NULL, NULL, 0, NULL),
(171, 171, 'سند افتتاحي', '2021-11-17', NULL, 171, 1, NULL, NULL, NULL, NULL, 0, NULL),
(172, 172, 'سند افتتاحي', '2021-11-17', NULL, 172, 1, NULL, NULL, NULL, NULL, 0, NULL),
(173, 173, 'سند افتتاحي', '2021-11-17', NULL, 173, 1, NULL, NULL, NULL, NULL, 0, NULL),
(174, 174, 'سند افتتاحي', '2021-11-17', NULL, 174, 1, NULL, NULL, NULL, NULL, 0, NULL),
(175, 175, 'سند افتتاحي', '2021-11-17', NULL, 175, 1, NULL, NULL, NULL, NULL, 0, NULL),
(176, 176, 'سند افتتاحي', '2021-11-17', NULL, 176, 1, NULL, NULL, NULL, NULL, 0, NULL),
(177, 177, 'سند افتتاحي', '2021-11-17', NULL, 177, 1, NULL, NULL, NULL, NULL, 0, NULL),
(178, 178, 'سند افتتاحي', '2021-11-17', NULL, 178, 1, NULL, NULL, NULL, NULL, 0, NULL),
(179, 179, 'سند افتتاحي', '2021-11-17', NULL, 179, 1, NULL, NULL, NULL, NULL, 0, NULL),
(180, 180, 'سند افتتاحي', '2021-11-17', NULL, 180, 1, NULL, NULL, NULL, NULL, 0, NULL),
(181, 181, 'سند افتتاحي', '2021-11-17', NULL, 181, 1, NULL, NULL, NULL, NULL, 0, NULL),
(182, 182, 'سند افتتاحي', '2021-11-17', NULL, 182, 1, NULL, NULL, NULL, NULL, 0, NULL),
(183, 183, 'سند افتتاحي', '2021-11-17', NULL, 183, 1, NULL, NULL, NULL, NULL, 0, NULL),
(184, 184, 'سند افتتاحي', '2021-11-17', NULL, 184, 1, NULL, NULL, NULL, NULL, 0, NULL),
(185, 185, 'سند افتتاحي', '2021-11-17', NULL, 185, 1, NULL, NULL, NULL, NULL, 0, NULL),
(186, 186, 'سند افتتاحي', '2021-11-17', NULL, 186, 1, NULL, NULL, NULL, NULL, 0, NULL),
(187, 187, 'سند افتتاحي', '2021-11-17', NULL, 187, 1, NULL, NULL, NULL, NULL, 0, NULL),
(188, 188, 'سند افتتاحي', '2021-11-17', NULL, 188, 1, NULL, NULL, NULL, NULL, 0, NULL),
(191, 190, 'دفعة على الحساب (1725000)', '2021-11-21', NULL, 189, 1, NULL, NULL, NULL, NULL, 0, NULL),
(192, 191, 'دفعة على الحساب (562000)', '2021-11-14', NULL, 190, 1, NULL, NULL, NULL, NULL, 0, NULL),
(193, 192, 'ا.قبض 355/10 من نبهان النبهان ترصيد حساب (378000)', '2021-11-14', NULL, 191, 1, NULL, NULL, NULL, NULL, 0, NULL),
(194, 193, 'ا.قبض 356/10 من هيثم هلول ترصيد حساب (7762000)', '2021-11-14', NULL, 192, 1, NULL, NULL, NULL, NULL, 0, NULL),
(195, 194, 'ا.قبض 356/10 من هيثم هلول ترصيد حساب (7762000)', '2021-11-14', NULL, 193, 1, NULL, NULL, NULL, NULL, 0, NULL),
(196, 195, NULL, '2021-11-13', 2, NULL, 1, NULL, NULL, NULL, '2021-12-07 10:34:38', 1, NULL),
(197, 196, 'بنزين 25 ليتر بسعر 750 ل.س', '2021-11-07', NULL, 194, 1, NULL, NULL, NULL, NULL, 0, NULL),
(198, 197, 'بنزين 10 ليتر بسعر 4000 ل.س', '2021-11-10', NULL, 195, 1, NULL, NULL, NULL, NULL, 0, NULL),
(199, 198, 'اجار نقل من عدرا الى حلب', '2021-11-10', NULL, 196, 1, NULL, NULL, NULL, NULL, 0, NULL),
(200, 199, 'اجار نقل من حلب الى مستودع تل عرن', '2021-11-10', NULL, 197, 1, NULL, NULL, NULL, NULL, 0, NULL),
(201, 200, 'عمال تحميل وتنزيل', '2021-11-10', NULL, 198, 1, NULL, NULL, NULL, NULL, 0, NULL),
(202, 201, 'بنزين 25 ليتر بسعر 750 ل.س', '2021-11-12', NULL, 199, 1, NULL, NULL, NULL, NULL, 0, NULL),
(203, 202, 'دفعة الى ايمن النجار سلمت في سوق الهال', '2021-11-14', NULL, 200, 1, NULL, NULL, NULL, NULL, 0, NULL),
(204, 203, 'حوالة بريدية', '2021-11-07', NULL, 201, 1, NULL, NULL, NULL, NULL, 0, NULL),
(205, 204, NULL, '2021-11-13', 3, NULL, 1, NULL, '2021-12-07 10:34:38', 1, '2021-12-16 10:41:39', 21, NULL),
(206, 205, 'ا.قبض 359/10 من عبد اللطيف العساف دفعة على الحساب', '2021-12-07', NULL, 205, 1, NULL, '2021-12-14 11:07:31', 21, '2021-12-14 11:13:45', 21, NULL),
(207, 206, 'ا.قبض 358/10 من مصطفى حنكول دفعة على الحساب (27600', '2021-12-02', NULL, 203, 1, NULL, '2021-12-14 11:12:07', 21, NULL, 0, NULL),
(208, 207, 'ا.قبض 360/10 من مصطفى حنكول دفعة على الحساب', '2021-12-09', NULL, 204, 1, NULL, '2021-12-14 11:12:59', 21, NULL, 0, NULL),
(209, 208, 'ا.قبض 359/10 من عبد اللطيف العساف دفعة على الحساب ', '2021-12-07', NULL, 202, 1, NULL, '2021-12-14 11:13:45', 21, NULL, 0, NULL),
(210, 209, 'وثيقة شحن 423/10', '2021-10-03', NULL, 207, 1, NULL, '2021-12-15 12:41:11', 21, '2022-03-21 08:51:31', 21, NULL),
(211, 210, NULL, '2021-11-13', 1, NULL, 1, NULL, '2021-12-16 10:41:39', 21, '2021-12-22 08:12:02', 1, NULL),
(212, 211, 'وثيقة شحن 423/10', '2021-10-03', NULL, 206, 1, NULL, '2022-03-21 10:51:31', 21, NULL, 0, NULL),
(213, 212, 'ا.قبض 715/11 ثمن وثيقة الشحن رقم 734', '2014-09-12', NULL, 208, 1, NULL, '2022-03-23 10:48:55', 21, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `multi` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `files` (
  `id` int NOT NULL,
  `path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `files_vouchers`
--

CREATE TABLE `files_vouchers` (
  `id` int NOT NULL,
  `voucher_id` int NOT NULL,
  `file_id` varchar(500) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `files_vouchers`
--

INSERT INTO `files_vouchers` (`id`, `voucher_id`, `file_id`, `active`, `sorting`) VALUES
(1, 206, 'http://cloudsellpos.com/uploads/21/2022-03/2cf95078d332d4b6ff6e909d400a64bc.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `response` longtext,
  `send_to` varchar(500) DEFAULT NULL,
  `row_type` varchar(500) DEFAULT NULL,
  `sorting` tinyint DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `response`, `send_to`, `row_type`, `sorting`, `active`) VALUES
(1, 'First Form Aviation taiba', 'thank you for your submit ..', 'fesalali05@gmai.com', 'col-lg-12', NULL, 1),
(2, 'Test Form', 'Thanks', 'eman@voila.digital', 'col-lg-12', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_field`
--

CREATE TABLE `form_field` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `field_id` int DEFAULT NULL,
  `required_filed` varchar(10) DEFAULT NULL,
  `label_filed` varchar(20) DEFAULT NULL,
  `values` varchar(500) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `image_model` (
  `id` int NOT NULL,
  `model` varchar(500) DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `path` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `image_model`
--

INSERT INTO `image_model` (`id`, `model`, `model_id`, `path`) VALUES
(1, 'Purchase invoice', 111, '/images/pexels-photo-750073.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int NOT NULL,
  `name_en` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` bigint DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `delegate_id` int DEFAULT NULL,
  `major_classification` tinyint DEFAULT '1',
  `note` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `delegate_id`, `major_classification`, `note`, `active`, `sorting`) VALUES
(1, NULL, 'دمشق', 11, NULL, NULL, 1, NULL, 1, NULL),
(2, NULL, 'مستودع المعمل', 1101, 1, NULL, 0, NULL, 1, NULL),
(3, NULL, 'مستودع المكتب', 1102, 1, NULL, 0, NULL, 1, NULL),
(4, NULL, 'درعا', 12, NULL, NULL, 1, NULL, 1, NULL),
(5, NULL, 'مستودع سمير', 1201, 4, 3, 0, NULL, 1, NULL),
(6, NULL, 'مستودع القباطي', 1202, 4, 12, 0, NULL, 1, NULL),
(7, NULL, 'الساحل', 13, NULL, NULL, 1, NULL, 1, NULL),
(8, NULL, 'مستودع اسامة طاهر', 1301, 7, 20, 0, NULL, 1, NULL),
(9, NULL, 'حمص', 14, NULL, NULL, 1, NULL, 1, NULL),
(10, NULL, 'مستودع التقيرة 3 - احمد ابراهيم', 1401, 9, 11, 0, NULL, 1, NULL),
(11, NULL, 'مستودعات ', 15, NULL, NULL, 1, NULL, 1, NULL),
(12, NULL, 'مستودع محردة - شادي', 1501, 11, 5, 0, NULL, 1, NULL),
(13, NULL, 'مستودع منبج', 1502, 11, NULL, 0, NULL, 1, NULL),
(14, NULL, 'مستودع القامشلي - عيسى احمد', 1503, 11, 8, 0, NULL, 1, NULL),
(15, NULL, 'مستودع حلب - محمود الخطيب', 1504, 11, 21, 0, NULL, 1, NULL),
(16, NULL, 'مستودع حماه - مصعب الحسين', 1505, 11, 7, 0, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_type_id`
--

CREATE TABLE `inventory_type_id` (
  `id` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `prefix` varchar(1000) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `items` (
  `id` int NOT NULL,
  `name_en` longtext,
  `name_ar` longtext,
  `code` bigint DEFAULT NULL,
  `item_category_id` int DEFAULT NULL,
  `item_unit_id` int DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name_en`, `name_ar`, `code`, `item_category_id`, `item_unit_id`, `cost`, `price`, `active`, `sorting`) VALUES
(1, NULL, 'تريفيرتو حبيبي بطيء ( 17-12- 12) - 25 كغ', 11014, 2, 1, NULL, '25.00', 1, NULL),
(2, NULL, 'زفتة كوركو - 1 كغ', 21035, 2, 1, NULL, '0.00', 1, NULL),
(3, NULL, 'سماد سولفيرتو متوازن ( 20 - 20 - 20 ) 25 كغ', 11015, 2, 1, NULL, '0.00', 1, NULL),
(4, NULL, 'سماد سولفيرتو بوتاس ( 16 - 0 - 37 ) 25 كغ', 11016, 2, 1, NULL, '40.00', 1, NULL),
(5, NULL, 'حمض الكبريت', 21052, 2, 1, NULL, '0.00', 1, NULL),
(6, NULL, 'سلفات الامونيوم 25 كغ - مصرية', 21050, 2, 1, NULL, '0.00', 1, NULL),
(7, NULL, 'غوفار امينو اسيد ( احماض امينية ) 20 كغ', 21051, 2, 1, NULL, '80.00', 1, NULL),
(8, NULL, 'سماد تريفيرتو سلفات امونيوم 25 كغ', 21000, 2, 1, NULL, '0.00', 1, NULL),
(9, NULL, 'عالي الفوسفور ( 10 - 40 - 10 ) 25 كغ', 21003, 2, 1, NULL, '0.00', 1, NULL),
(10, NULL, 'مانع تجبل صيني', 21005, 2, 1, NULL, '0.00', 1, NULL),
(11, NULL, 'حمض ستريك - 25 كغ', 21008, 2, 1, NULL, '0.00', 1, NULL),
(12, NULL, 'ماءات البوتاسيوم - 25 كغ', 21009, 2, 1, NULL, '0.00', 1, NULL),
(13, NULL, 'سلفات الحديد', 21010, 2, 1, NULL, '0.00', 1, NULL),
(14, NULL, 'سلفات النحاس - وطني', 21011, 2, 1, NULL, '0.00', 1, NULL),
(15, NULL, 'سلفات الزنك', 21012, 2, 1, NULL, '0.00', 1, NULL),
(16, NULL, 'تكسابون', 21013, 2, 1, NULL, '0.00', 1, NULL),
(17, NULL, 'سلفات امونيوم بلجيكي 25 كغ', 21014, 2, 1, NULL, '0.00', 1, NULL),
(18, NULL, 'حمض فوسفور', 21015, 2, 1, NULL, '0.00', 1, NULL),
(19, NULL, 'عناصر صغرى', 21016, 2, 1, NULL, '0.00', 1, NULL),
(20, NULL, 'سلفات المنغنيز', 21017, 2, 1, NULL, '0.00', 1, NULL),
(21, NULL, 'سلفات مغنزيوم مائي 25 كغ', 21018, 2, 1, NULL, '0.00', 1, NULL),
(22, NULL, 'صباغ ازرق بودرة', 21019, 2, 1, NULL, '0.00', 1, NULL),
(23, NULL, 'جبريليك اسيد 90 %', 21020, 2, 1, NULL, '0.00', 1, NULL),
(24, NULL, 'يوريا 46', 21021, 2, 1, NULL, '0.00', 1, NULL),
(25, NULL, 'صبغة تركواز', 21022, 2, 1, NULL, '0.00', 1, NULL),
(26, NULL, 'صبغة فلورسنت نهدي ( بيكمنت 48.1 )', 21004, 2, 1, NULL, '0.00', 1, NULL),
(27, NULL, 'صبغة احمر ميتيل', 21024, 2, 1, NULL, '0.00', 1, NULL),
(28, NULL, 'حمض آزوت', 21025, 2, 1, NULL, '0.00', 1, NULL),
(29, NULL, 'فورمول', 21026, 2, 1, NULL, '0.00', 1, NULL),
(30, NULL, 'مانع رغوة', 21023, 2, 1, NULL, '0.00', 1, NULL),
(31, NULL, 'كبريت', 21028, 2, 1, NULL, '0.00', 1, NULL),
(32, NULL, 'ماءات امونيوم', 21029, 2, 1, NULL, '0.00', 1, NULL),
(33, NULL, 'كربونات الكالسيوم', 21031, 2, 1, NULL, '0.00', 1, NULL),
(34, NULL, 'كلس حجري', 21027, 2, 1, NULL, '0.00', 1, NULL),
(35, NULL, 'بوريك اسيد', 21032, 2, 1, NULL, '0.00', 1, NULL),
(36, NULL, 'عالي البوتاسيوم ( 10 - 10 - 30 ) 25 كغ', 21007, 2, 1, NULL, '0.00', 1, NULL),
(37, NULL, 'ايبسلون ( M K P ) - م ك ب 25 كغ', 21036, 2, 1, NULL, '0.00', 1, NULL),
(38, NULL, 'كحول ايتيلي', 21034, 2, 1, NULL, '0.00', 1, NULL),
(39, NULL, 'صبغة اسيد نايلون اصفر 1 كغ', 21037, 2, 1, NULL, '0.00', 1, NULL),
(40, NULL, 'فولفيك اسيد ( انيرجي ) 25 كغ', 21033, 2, 1, NULL, '2.50', 1, NULL),
(41, NULL, 'هيومك اسيد سريع الذوبان 1 كغ', 21038, 2, 1, NULL, '0.00', 1, NULL),
(42, NULL, 'هيومك اسيد بطيء الذوبان 1 كغ', 21039, 2, 1, NULL, '0.00', 1, NULL),
(43, NULL, 'سلفات البوتاسيوم', 21040, 2, 1, NULL, '0.00', 1, NULL),
(44, NULL, 'حمض كلور الماء', 21001, 2, 1, NULL, '0.00', 1, NULL),
(45, NULL, 'نوفو امينو اسيد', 21041, 2, 1, NULL, '0.00', 1, NULL),
(46, NULL, 'سماد كرستا اب ( 18 - 44 - 0 ) 25 كغ', 21044, 2, 1, NULL, '0.00', 1, NULL),
(47, NULL, 'صبغة احمر', 21030, 2, 1, NULL, '0.00', 1, NULL),
(48, NULL, 'هيومك بلاك جاينت بورون', 21043, 2, 1, NULL, '2.50', 1, NULL),
(49, NULL, 'كزانتان 400 ( سائل )', 21045, 2, 1, NULL, '0.00', 1, NULL),
(50, NULL, 'ايبسيلون ماب 25 كغ ( 12 - 61 -0 )', 21006, 2, 1, NULL, '0.00', 1, NULL),
(51, NULL, 'سلفات مغنزيوم لامائي 25 كغ', 21042, 2, 1, NULL, '0.00', 1, NULL),
(52, NULL, 'كزانتان 1000 ( بودرة )', 21046, 2, 1, NULL, '0.00', 1, NULL),
(53, NULL, 'هيومنرتش ( 4 - 0 - 9004 ) - 25 كغ', 21048, 2, 2, NULL, '0.00', 1, NULL),
(54, NULL, 'الترا سول سلفات البوتاسيوم - بلجيكي', 21047, 2, 1, NULL, '0.00', 1, NULL),
(55, NULL, 'مانع تجبل أردني', 21002, 2, 1, NULL, '0.00', 1, NULL),
(56, NULL, 'متوازن ( 20 - 20 - 20 ) بودرة', 21049, 2, 1, NULL, '0.00', 1, NULL),
(57, NULL, 'سماد سولفيرتو فوسفور ( 0 - 44 - 18 ) 25 كغ', 11017, 2, 1, NULL, '40.00', 1, NULL),
(58, NULL, 'ماءات بوتاسيوم اردني - 1000 كغ', 21053, 2, 1, NULL, '0.00', 1, NULL),
(59, NULL, 'سلفات بوتاسيوم اردني - 25 كغ', 21054, 2, 1, NULL, '0.00', 1, NULL),
(60, NULL, 'كربونات كالسيوم - الجبة', 21055, 2, 1, NULL, '0.00', 1, NULL),
(61, NULL, 'حمض ستريك لامائي - 25 كغ', 21056, 2, 1, NULL, '0.00', 1, NULL),
(62, NULL, 'سكر تونسي - 50 كغ', 21058, 2, 1, NULL, '0.00', 1, NULL),
(63, NULL, 'خميرة', 21057, 2, 1, NULL, '0.00', 1, NULL),
(64, NULL, 'كزانتان 4000 ( بودرة )', 21059, 2, 1, NULL, '0.00', 1, NULL),
(65, NULL, 'سيليكون مائي - 25 كغ', 21060, 2, 1, NULL, '0.00', 1, NULL),
(66, NULL, 'صباغ اصفر بودرة', 21061, 2, 1, NULL, '0.00', 1, NULL),
(67, NULL, 'كربونات كالسيوم - اجنبي', 21062, 2, 1, NULL, '0.00', 1, NULL),
(68, NULL, 'فيرتان كالسيوم - نترات امونيوم الكالسيوم', 21063, 2, 1, NULL, '0.00', 1, NULL),
(69, NULL, 'صبغة اخضر', 21064, 2, 1, NULL, '0.00', 1, NULL),
(70, NULL, 'صبغة ازرق جديد', 21065, 2, 1, NULL, '0.00', 1, NULL),
(71, NULL, 'سلفات امونيوم صينية', 21066, 2, 1, NULL, '0.00', 1, NULL),
(72, NULL, 'صبغة احمر بودرة', 21067, 2, 1, NULL, '0.00', 1, NULL),
(73, NULL, 'اغرو فلكس', 21068, 2, 1, NULL, '0.00', 1, NULL),
(74, NULL, 'غاز امونيا', 21069, 2, 1, NULL, '0.00', 1, NULL),
(75, NULL, 'ماب صيني', 21070, 2, 1, NULL, '0.00', 1, NULL),
(76, NULL, 'سلفات بوتاسيوم صيني', 21071, 2, 1, NULL, '0.00', 1, NULL),
(77, NULL, 'ماءات بوتاسيوم صيني', 21072, 2, 1, NULL, '0.00', 1, NULL),
(78, NULL, 'امينو اسيد حامضي', 21073, 2, 1, NULL, '0.00', 1, NULL),
(79, NULL, 'سلفات النحاس - اجنبي', 21074, 2, 1, NULL, '0.00', 1, NULL),
(80, NULL, 'هيومك اسيد', 21075, 2, 1, NULL, '0.00', 1, NULL),
(81, NULL, 'ماءات امونيم سائلة', 21076, 2, 1, NULL, '0.00', 1, NULL),
(82, NULL, 'صباغ احمر معلق', 21077, 2, 1, NULL, '0.00', 1, NULL),
(83, NULL, 'صباغ اخضر معلق', 21078, 2, 1, NULL, '0.00', 1, NULL),
(84, NULL, 'صباغ ازرق معلق', 21080, 2, 1, NULL, '0.00', 1, NULL),
(85, NULL, 'كوسا غزالة ظرف 500 بزرة', 12001, 4, 3, NULL, '0.00', 1, NULL),
(86, NULL, 'بذور بندورة ريد كات ظرف', 12002, 4, 3, NULL, '15.00', 1, NULL),
(87, NULL, 'بذور فليفلة حارقة ظرف', 12003, 4, 3, NULL, '0.00', 1, NULL),
(88, NULL, 'بذور خيار جود - ظرف 2500 بذرة', 12004, 4, 3, NULL, '28.00', 1, NULL),
(89, NULL, 'بندورة هلا ظرف', 12005, 4, 3, NULL, '0.00', 1, NULL),
(90, NULL, 'بذور بطيخ - روان F1 - ظرف 1000 بذرة', 12006, 4, 3, NULL, '45.00', 1, NULL),
(91, NULL, 'بذور بندورة - نسمه F1 - ظرف 1000 بذرة', 12007, 4, 3, NULL, '20.00', 1, NULL),
(92, NULL, 'بذور كوسا غزالة - ظرف 1000بذرة', 12008, 4, 3, NULL, '0.00', 1, NULL),
(93, NULL, 'بذور خيار هبا - ظرف 2500 بذرة', 12009, 4, 3, NULL, '0.00', 1, NULL),
(94, NULL, 'بذور فليفلة حارقة جنى - ظرف 1000 بذرة', 12010, 4, 3, NULL, '0.00', 1, NULL),
(95, NULL, 'بذور بندورة الرائدة - ظرف 1000 بذرة', 12011, 4, 3, NULL, '43.00', 1, NULL),
(96, NULL, 'بذور بندورة صلبة - ظرف 1000 بذرة', 12012, 4, 3, NULL, '32.00', 1, NULL),
(97, NULL, 'بذور بطيخ اصفر ( اباتش ) - ظرف 1000 بذرة', 12013, 4, 3, NULL, '55.00', 1, NULL),
(98, NULL, 'بطيخ احمر كروزر', 12014, 4, 3, NULL, '42.00', 1, NULL),
(99, NULL, 'بذور بطيخ تشالنجر', 12015, 4, 3, NULL, '42.00', 1, NULL),
(100, NULL, 'تورب 225 ليتر MK S 1', 11008, 5, 4, NULL, '0.00', 1, NULL),
(101, NULL, 'تورب  50 ليتر   - MP S1', 11010, 5, 5, NULL, '0.00', 1, NULL),
(102, NULL, 'فوسفور 0 - 62 - 0', 11024, 5, 6, NULL, '0.00', 1, NULL),
(103, NULL, 'فوسفور - خاص القباني', 11025, 5, 1, NULL, '0.00', 1, NULL),
(104, NULL, 'عالي البوتاس - قباني', 11026, 5, 1, NULL, '0.00', 1, NULL),
(105, NULL, 'متوازن - القباني', 11027, 5, 1, NULL, '0.00', 1, NULL),
(106, NULL, 'باور لاور 7.5 كغ', 11028, 5, 7, NULL, '15.00', 1, NULL),
(107, NULL, 'بابلي 1 لتر', 11029, 5, 8, NULL, '12.00', 1, NULL),
(108, NULL, 'بافر 1لتر', 11030, 5, 8, NULL, '4.00', 1, NULL),
(109, NULL, 'غوفار امينواسيد 50% - 1/2 كغ', 13053, 6, 9, NULL, '3.00', 1, NULL),
(110, NULL, 'غوفار بورون   25 كغ ', 13054, 6, 1, NULL, '0.00', 1, NULL),
(111, NULL, 'غوفار 600   ظرف 400 غرام /كرتونة 40 ظرف ', 13055, 6, 3, NULL, '6.00', 1, NULL),
(112, NULL, 'غوفار بورون -1 كغ', 13001, 6, 10, NULL, '6.00', 1, NULL),
(113, NULL, 'سولفيرتو متوازن ( 20 - 20 - 20 ) 1 كغ', 13002, 6, 10, NULL, '4.00', 1, NULL),
(114, NULL, 'سولفيرتو فوسفور ( 18- 44 - 0 ) 1 كغ', 13003, 6, 10, NULL, '4.00', 1, NULL),
(115, NULL, 'سولفيرتو بوتاس ( 16 - 0 - 37 ) 1 كغ', 13004, 6, 10, NULL, '4.00', 1, NULL),
(116, NULL, 'نترو ملتي غرو ( 40 - 0 - 5 ) - 10 كغ', 13005, 6, 11, NULL, '0.00', 1, NULL),
(117, NULL, 'ملتي غرو فوسفور 62 - 7.5 كغ', 13006, 6, 12, NULL, '12.80', 1, NULL),
(118, NULL, 'مغلظ سائل ( 0 - 19 - 45 ) 1 لتر', 13007, 6, 8, NULL, '4.00', 1, NULL),
(119, NULL, 'مغلظ سائل ( 0 - 19 - 45 ) 5 لتر', 13008, 6, 6, NULL, '20.00', 1, NULL),
(120, NULL, 'نترو ملتي غرو اكسترا - 1كغ', 13009, 6, 10, NULL, '3.00', 1, NULL),
(121, NULL, 'ملتي غرو تيكس سائل - 1/4 ليتر', 13010, 6, 13, NULL, '1.00', 1, NULL),
(122, NULL, 'ملتي غرو تيكس سائل - 1 ليتر', 13011, 6, 8, NULL, '2.50', 1, NULL),
(123, NULL, 'ملتي غرو نحاس كوبر - 1 ليتر', 13012, 6, 8, NULL, '5.00', 1, NULL),
(124, NULL, 'ملتي غرو كالسيوم -1 ليتر', 13013, 6, 8, NULL, '4.00', 1, NULL),
(125, NULL, 'نترو غو 40 - 5 ليتر', 13014, 6, 6, NULL, '6.00', 1, NULL),
(126, NULL, 'ملتي غرو حديد 1/4 ليتر', 13015, 6, 13, NULL, '1.50', 1, NULL),
(127, NULL, 'ملتي غرو حديد - 1 ليتر', 13016, 6, 8, NULL, '4.00', 1, NULL),
(128, NULL, 'ملتي غرو سيلفر - 1 ليتر', 13028, 6, 8, NULL, '3.50', 1, NULL),
(129, NULL, 'فيرست ك ت س - 5 ليتر', 13019, 6, 6, NULL, '17.00', 1, NULL),
(130, NULL, 'ملتي غرو جل متوازن ( 30 - 30 - 30 ) 5كغ', 13020, 6, 14, NULL, '12.00', 1, NULL),
(131, NULL, 'ملتي غرو جل متوازن ( 30 - 30 - 30 ) 2كغ', 13021, 6, 15, NULL, '4.50', 1, NULL),
(132, NULL, 'ملتي غرو جل فوسفور ( 10 - 50 - 10 ) 5كغ', 13023, 6, 14, NULL, '12.00', 1, NULL),
(133, NULL, 'ملتي غرو جل فوسفور ( 10 - 50 - 10 ) 2 كغ', 13024, 6, 15, NULL, '4.50', 1, NULL),
(134, NULL, 'ملتي غرو جل بوتاس ( 5 - 25 - 36 ) 5كغ', 13025, 6, 14, NULL, '12.00', 1, NULL),
(135, NULL, 'ملتي غرو جل بوتاس ( 5 - 25 - 36 ) 2كغ', 13026, 6, 15, NULL, '4.50', 1, NULL),
(136, NULL, 'ملتي هيوم 1 ليتر', 13030, 6, 8, NULL, '2.00', 1, NULL),
(137, NULL, 'فيرست ك ت س - 1 ليتر', 13018, 6, 8, NULL, '4.00', 1, NULL),
(138, NULL, 'ملتي غرو سيلفر - 5 ليتر', 13029, 6, 6, NULL, '12.00', 1, NULL),
(139, NULL, 'ملتي غرو بي اتش ريجيو ليتر - 1 ليتر', 13027, 6, 8, NULL, '4.00', 1, NULL),
(140, NULL, 'ملتي غرو هيوم - 5 كغ', 13031, 6, 16, NULL, '15.00', 1, NULL),
(141, NULL, 'ملتي غرو هيوم - 1 كغ', 13032, 6, 10, NULL, '3.50', 1, NULL),
(142, NULL, 'باور فيد انيرجي - 5 كغ', 13058, 6, 16, NULL, '21.00', 1, NULL),
(143, NULL, 'ملتي غرو جل متوازن ( 30 - 30 - 30 ) 10 كغ', 13022, 6, 17, NULL, '20.00', 1, NULL),
(144, NULL, 'ملتي غرو جل فوسفور ( 10 - 50 - 10 ) 10 كغ', 13033, 6, 17, NULL, '20.00', 1, NULL),
(145, NULL, 'ملتي غرو جل بوتاس ( 5 - 25 - 36 ) 10 كغ', 13034, 6, 17, NULL, '20.00', 1, NULL),
(146, NULL, 'ملتي غرو سيت - 1 كغ', 13035, 6, 18, NULL, '4.00', 1, NULL),
(147, NULL, 'باور فيد ازوت ( 40 - 0 - 5 ) - 10 كغ', 13056, 6, 11, NULL, '0.00', 1, NULL),
(148, NULL, 'فيرست ك ت س - 5 ليتر - عضوي -', 13017, 6, 6, NULL, '0.00', 1, NULL),
(149, NULL, 'ملتي غرو انيرجي 1/2 كغ', 13036, 6, 9, NULL, '3.00', 1, NULL),
(150, NULL, 'ملتي غرو العملاق - 1 ليتر', 13037, 6, 8, NULL, '4.00', 1, NULL),
(151, NULL, 'ملتي غرو العملاق - 5 ليتر', 13038, 6, 6, NULL, '20.00', 1, NULL),
(152, NULL, 'ملتي غرو متوازن بودرة (10-10-10) - 10 كغ', 13039, 6, 2, NULL, '20.00', 1, NULL),
(153, NULL, 'عالي الفوسفور بودرة ( 10 - 26 - 5 ) - 10 كغ', 13040, 6, 2, NULL, '20.00', 1, NULL),
(154, NULL, 'ملتي غرو كالسيوم - 5 ليتر', 13041, 6, 6, NULL, '15.00', 1, NULL),
(155, NULL, 'ملتي غرو جل ازوت ( 32 - 15 - 6 ) - 10 كغ', 13042, 6, 17, NULL, '20.00', 1, NULL),
(156, NULL, 'باور فيد جل فوسفور ( 10 - 40 - 10 ) - 10 كغ', 13043, 6, 17, NULL, '20.00', 1, NULL),
(157, NULL, 'باور فيد جل متوازن ( 20 - 20 - 20 ) - 10 كغ', 13044, 6, 17, NULL, '20.00', 1, NULL),
(158, NULL, 'باور فيد جل بوتاس ( 10 - 10 - 36 ) - 10 كغ', 13045, 6, 17, NULL, '20.00', 1, NULL),
(159, NULL, 'نترو باور فيد اكسترا - 2 كغ', 13046, 6, 19, NULL, '6.00', 1, NULL),
(160, NULL, 'ملتي غرو العملاق - 10 كغ', 13047, 6, 17, NULL, '22.00', 1, NULL),
(161, NULL, 'كال غيفت - 1 ليتر', 13048, 6, 8, NULL, '3.50', 1, NULL),
(162, NULL, 'باور فيد تيكس - 1 ليتر', 13049, 6, 8, NULL, '2.50', 1, NULL),
(163, NULL, 'كال غيفت - 5 ليتر', 13050, 6, 6, NULL, '15.00', 1, NULL),
(164, NULL, 'نترو ملتي غرو ( 20 - 20 - 20 ) بودرة - 10 كغ', 13051, 6, 11, NULL, '0.00', 1, NULL),
(165, NULL, 'باور فيد ك ت س - 1 ليتر', 13052, 6, 8, NULL, '4.00', 1, NULL),
(166, NULL, 'ملتي غرو جل ازوت ( 32 - 15 - 6 ) - 1 كغ', 13057, 6, 18, NULL, '3.50', 1, NULL),
(167, NULL, 'بوروتاس هيوم - 1 كغ', 13059, 6, 10, NULL, '4.50', 1, NULL),
(168, NULL, 'باور فيد هيومات - 5 كغ', 13060, 6, 16, NULL, '15.00', 1, NULL),
(169, NULL, 'نترو ملتي غرو ( 10 - 40 - 10 ) بودرة - 10 كغ', 13061, 6, 11, NULL, '0.00', 1, NULL),
(170, NULL, 'بومبر - 5 كغ', 13064, 6, 16, NULL, '15.00', 1, NULL),
(171, NULL, 'نترو ملتي غرو ( 10 - 10 - 30 ) بودرة - 10 كغ', 13062, 6, 11, NULL, '0.00', 1, NULL),
(172, NULL, 'بومبر - 1/2 كغ', 13063, 6, 9, NULL, '3.00', 1, NULL),
(173, NULL, 'شوغار باور - 1/2 كغ', 13065, 6, 9, NULL, '3.00', 1, NULL),
(174, NULL, 'شوغار باور - 5 كغ', 13066, 6, 16, NULL, '21.00', 1, NULL),
(175, NULL, 'باور فيد انيرجي - 1/2 كغ', 13067, 6, 9, NULL, '3.50', 1, NULL),
(176, NULL, 'باور فيد سيلفر - 5 ليتر', 13068, 6, 6, NULL, '12.00', 1, NULL),
(177, NULL, 'باور فيد 62 - 5 ليتر ( 7.5 كغ )', 13069, 6, 6, NULL, '12.80', 1, NULL),
(178, NULL, 'نترو ملتي غرو ( 20 - 20 - 20 ) بودرة - 5 كغ', 13070, 6, 16, NULL, '6.50', 1, NULL),
(179, NULL, 'باور فيد هيومات - 1 كغ', 13071, 6, 10, NULL, '3.50', 1, NULL),
(180, NULL, 'سولفيرتو متوازن ( 20 - 20 - 20 ) - 10 كغ', 13073, 6, 11, NULL, '0.00', 1, NULL),
(181, NULL, 'بومبر جل ( 12 - 12 - 12 ) - 10 كغ', 13072, 6, 17, NULL, '22.00', 1, NULL),
(182, NULL, 'نتروغو 40 - 1 ليتر', 13076, 6, 8, NULL, '2.00', 1, NULL),
(183, NULL, 'باور فيد ك ت س - 5 ليتر', 13077, 6, 6, NULL, '17.00', 1, NULL),
(184, NULL, 'نترو غو 40 - 20 ليتر', 13078, 6, 20, NULL, '18.00', 1, NULL),
(185, NULL, 'باور سيلفو كوبر - 1 ليتر', 13079, 6, 8, NULL, '3.50', 1, NULL),
(186, NULL, 'سولفيرتو فوسفور ( 18- 44 -0 ) - 10 كغ', 13074, 6, 11, NULL, '0.00', 1, NULL),
(187, NULL, 'سولفيرتو بوتاس ( 16 - 0 - 37 ) - 10 كغ', 13075, 6, 11, NULL, '0.00', 1, NULL),
(188, NULL, 'باور فيد جل ( 10 - 65 - 10 ) - 10 كغ', 13080, 6, 17, NULL, '20.00', 1, NULL),
(189, NULL, 'باور فيد جل ( 30 - 30 - 30 ) - 10 كغ', 13081, 6, 17, NULL, '20.00', 1, NULL),
(190, NULL, 'باور فيد جل ( 5 - 25 - 41 ) - 10 كغ', 13082, 6, 17, NULL, '20.00', 1, NULL),
(191, NULL, 'ايرون فيكس - 1 ليتر', 13083, 6, 8, NULL, '0.00', 1, NULL),
(192, NULL, 'باور فيد ( 20 - 20 - 20 ) بودرة - 10 كغ', 13084, 6, NULL, NULL, '0.00', 1, NULL),
(193, NULL, 'باور فيد فوسفور( 10 - 40 - 10 ) بودرة - 10 كغ', 13085, 6, 11, NULL, '0.00', 1, NULL),
(194, NULL, 'باور فيد ( 10 - 10 - 30 ) بودرة - 10 كغ', 13086, 6, 11, NULL, '0.00', 1, NULL),
(195, NULL, 'باور فيد سيلفر - 1 لتر', 13087, 6, 8, NULL, '4.50', 1, NULL),
(196, NULL, 'ملتي غرو انيرجي - 5 كغ بودرة', 13088, 6, 16, NULL, '21.00', 1, NULL),
(197, NULL, 'باور فيد ( 10 - 10 - 10 ) 10كغ بودرة / طحالب', 13089, 6, 11, NULL, '0.00', 1, NULL),
(198, NULL, 'ملتي غرو ( 20 - 20 - 20 ) 5 لتر', 13090, 6, 6, NULL, '6.50', 1, NULL),
(199, NULL, 'بومبر بلس ( 10 - 10 - 10 ) 5كغ بودرة', 13091, 6, 16, NULL, '12.50', 1, NULL),
(200, NULL, 'ملتي غرو فوسفور 5 لتر', 13092, 6, 6, NULL, '6.50', 1, NULL),
(201, NULL, 'ملتي غرو بوتاس 5 لتر', 13093, 6, 6, NULL, '5.50', 1, NULL),
(202, NULL, 'تريفيرتو سلفات امونيوم بلجيكي 10 كغ بودرة', 13094, 6, 11, NULL, '0.00', 1, NULL),
(203, NULL, 'نترو ملتي غرو عناصر 10 كغ', 13095, 6, 1, NULL, '0.00', 1, NULL),
(204, NULL, 'غرين ماتركس ( 10 - 25 - 43 ) 10كغ', 13096, 6, NULL, NULL, '0.00', 1, NULL),
(205, NULL, 'غرين ماتركس ( 30 - 30 - 30 ) 10كغ', 13097, 6, NULL, NULL, '0.00', 1, NULL),
(206, NULL, 'غرين ماتركس ( 10 - 65 - 10 ) 10كغ', 13098, 6, NULL, NULL, '0.00', 1, NULL),
(207, NULL, 'نترو ملتي غرو 40 - 0 - 5 سلفات امونيوم 10 كغ', 13099, 6, 11, NULL, '0.00', 1, NULL),
(208, NULL, 'لاور 8', 13100, 6, 7, NULL, '0.00', 1, NULL),
(209, NULL, 'بابلي معلق ( 0 - 30 - 60 ) 10كغ', 13101, 6, NULL, NULL, '0.00', 1, NULL),
(210, NULL, 'بابلي معلق ( 5 - 25 - 42 ) 10كغ', 13102, 6, NULL, NULL, '0.00', 1, NULL),
(211, NULL, 'بابلي معلق ( 25 - 25 - 25 ) 10كغ', 13103, 6, NULL, NULL, '0.00', 1, NULL),
(212, NULL, 'بابلي معلق ( 10 - 65 - 10 ) 10كغ', 13104, 6, NULL, NULL, '0.00', 1, NULL),
(213, NULL, 'آمي غرين 5كغ', 13105, 6, NULL, NULL, '0.00', 1, NULL),
(214, NULL, 'علبة كرتون نترو ملتي غرو اكسترا 1 كغ', 31002, 8, 21, NULL, '0.00', 1, NULL),
(215, NULL, 'علبة كرتون ملتي غرو هيوم 1 كغ', 31007, 8, 21, NULL, '0.00', 1, NULL),
(216, NULL, 'علبة كرتون غوفار بورون 1 كغ', 31008, 8, 21, NULL, '0.00', 1, NULL),
(217, NULL, 'علبة كرتون ملتي غرو انيرجي - 1/2 كغ', 31001, 8, 21, NULL, '0.00', 1, NULL),
(218, NULL, 'علبة كرتون سولفيرتو متوازن ( 20 - 20 - 20 ) 1 كغ', 31003, 8, 21, NULL, '0.00', 1, NULL),
(219, NULL, 'علبة كرتون سولفيرتو فوسفور ( 18 - 44 - 0 ) 1 كغ', 31004, 8, 21, NULL, '0.00', 1, NULL),
(220, NULL, 'علبة كرتون فارغة غوفار امينو اسيد 1/2 كغ', 31006, 8, 21, NULL, '0.00', 1, NULL),
(221, NULL, 'علبة كرتون سولفيرتو بوتاس ( 16 - 0 - 37 ) 1 كغ', 31005, 8, 21, NULL, '0.00', 1, NULL),
(222, NULL, 'علبة كرتون بوروتاس هيوم - 1 كغ', 31009, 8, 21, NULL, '0.00', 1, NULL),
(223, NULL, 'علبة كرتون باور فيد انيرجي - 1/2 كغ', 31010, 8, 21, NULL, '0.00', 1, NULL),
(224, NULL, 'علبة كرتون باور فيد هيومات - 1 كغ', 31011, 8, 21, NULL, '0.00', 1, NULL),
(225, NULL, 'علبة كرتون بومبر - 1/2 كغ', 31012, 8, 21, NULL, '0.00', 1, NULL),
(226, NULL, 'علبة كرتون شوغار باور - 1/2 كغ', 31013, 8, 21, NULL, '0.00', 1, NULL),
(227, NULL, 'علبة كرتون باور فيد ( 10 - 10 - 10 ) 1 كغ', 31014, 8, 21, NULL, '0.00', 1, NULL),
(228, NULL, 'كيس نايلون شفاف ( 30 * 30 ) سعة 2 كغ', 35006, 9, 1, NULL, '0.00', 1, NULL),
(229, NULL, 'كيس قصدير المنيوم متلايز ( 40 * 55 ) سعة 5 كغ', 35004, 9, 1, NULL, '0.00', 1, NULL),
(230, NULL, 'كيس قصدير المنيوم ( 20 * 30 ) سعة 1 كغ', 35001, 9, 1, NULL, '0.00', 1, NULL),
(231, NULL, 'كيس ملون تعبئة نترو ملتي غرو - سعة 10 كغ', 35009, 9, 1, NULL, '0.00', 1, NULL),
(232, NULL, 'كيس نايلون شفاف ( 20 * 30 ) سعة 1 كغ سميك', 35005, 9, 1, NULL, '0.00', 1, NULL),
(233, NULL, 'كيس قصدير المنيوم ( 34 * 45 ) سعة 5 كغ', 35003, 9, 1, NULL, '0.00', 1, NULL),
(234, NULL, 'كيس نايلون شفاف ( 40* 60 ) سعة 10 كغ', 35008, 9, 1, NULL, '0.00', 1, NULL),
(235, NULL, 'كيس نايلون شفاف ( 30 * 50 ) سعة 5 كغ', 35007, 9, 1, NULL, '0.00', 1, NULL),
(236, NULL, 'كيس قصدير المنيوم متلايز ( 25 * 38 ) سعة 2 كغ', 35002, 9, 1, NULL, '0.00', 1, NULL),
(237, NULL, 'كيس ملون باور فيد ( 40 * 60 ) - سعة 10 كغ', 35011, 9, 1, NULL, '0.00', 1, NULL),
(238, NULL, 'كيس ملون سولفيرتو ( 40 * 60 ) - سعة 10 كغ', 35012, 9, 1, NULL, '0.00', 1, NULL),
(239, NULL, 'كيس تريفيرتو سلفات امونيوم سعة 10 كغ', 35013, 9, 1, NULL, '0.00', 1, NULL),
(240, NULL, 'كيس نايلو شفاف ( 20 * 30 ) رقيق سعة 1 كغ', 35014, 9, 1, NULL, '0.00', 1, NULL),
(241, NULL, 'كرتونة دبل ابيض سادة 32.5 * 32.5 * 28.5 / حجم 2 + 5 كغ جل', 36007, 10, 22, NULL, '0.00', 1, NULL),
(242, NULL, 'كرتونة 2 + 5 كغ جل قواطع', 36008, 10, 22, NULL, '0.00', 1, NULL),
(243, NULL, 'كرتونة دبل ابيض 39.5 * 28 * 29 / حجم 5 ليتر بيدون', 36002, 10, 22, NULL, '0.00', 1, NULL),
(244, NULL, 'كرتونة دبل ابيض 36 * 27.5 * 26 - حجم 1 ليتر سائل', 36001, 10, 22, NULL, '0.00', 1, NULL),
(245, NULL, 'كرتونة دبل ابيض 26.3 * 19.5 * 27.3 / حجم 1/4 ليتر', 36000, 10, 22, NULL, '0.00', 1, NULL),
(246, NULL, 'كرتونة دبل كرافت 43.5 * 32.5 * 28.5 / حجم 5 كغ بودرة', 36005, 10, 22, NULL, '0.00', 1, NULL),
(247, NULL, 'كرتونة دبل كرافت 39.5 * 25 * 31 / حجم 1 كغ جل', 36006, 10, 22, NULL, '0.00', 1, NULL),
(248, NULL, 'كرتونة اجنبي دبل ابيض 43.5 * 28.5 * 22.3 / حجم 1 كغ بودرة', 36003, 10, 22, NULL, '0.00', 1, NULL),
(249, NULL, 'كرتونة وطني دبل ابيض 43.5 * 28.5 * 22.3 / حجم 1 كغ بودرة', 36004, 10, 22, NULL, '0.00', 1, NULL),
(250, NULL, 'كرتونة 43.5 * 32.5 * 33.5', 36009, 10, 22, NULL, '0.00', 1, NULL),
(251, NULL, 'كرتونة ( 39.5 - 29 - 29 ) حجم 5 لتر', 36010, 10, 22, NULL, '0.00', 1, NULL),
(252, NULL, 'كرتونة ( 39.5 - 29 - 24 )', 36011, 10, 22, NULL, '0.00', 1, NULL),
(253, NULL, 'كرتونة ( 43.5 - 32.5 - 24 )', 36012, 10, 22, NULL, '0.00', 1, NULL),
(254, NULL, 'لصاقة ملتي غرو تيكس - 1 ليتر', 33001, 11, 23, NULL, '0.00', 1, NULL),
(255, NULL, 'لصاقة ملتي غرو كالسيوم - 1 ليتر', 33002, 11, 23, NULL, '0.00', 1, NULL),
(256, NULL, 'لصاقة ملتي غرو سيلفر - 5 ليتر', 33003, 11, 23, NULL, '0.00', 1, NULL),
(257, NULL, 'لصاقة ملتي غرو كوبر - 1 ليتر', 33004, 11, 23, NULL, '0.00', 1, NULL),
(258, NULL, 'لصاقة ملتي غرو حديد - 1 ليتر', 33005, 11, 23, NULL, '0.00', 1, NULL),
(259, NULL, 'لصاقة ملتي غرو تيكس - 1/4 ليتر', 33006, 11, 23, NULL, '0.00', 1, NULL),
(260, NULL, 'لصاقة ملتي غرو جل ( 30 - 30 -30 ) - 2 كغ', 33007, 11, 23, NULL, '0.00', 1, NULL),
(261, NULL, 'لصاقة باور فيد سيلفر - 5 ليتر', 33069, 11, 23, NULL, '0.00', 1, NULL),
(262, NULL, 'لصاقة ملتي غرو حديد - 1/4 ليتر', 33009, 11, 23, NULL, '0.00', 1, NULL),
(263, NULL, 'لصاقة ملتي غرو سيلفر - 1 ليتر', 33010, 11, 23, NULL, '0.00', 1, NULL),
(264, NULL, 'لصاقة ملتي هيوم - 1 لتر', 33011, 11, 23, NULL, '0.00', 1, NULL),
(265, NULL, 'لصاقة ملتي غرو 62 - 5 لتر', 33012, 11, 23, NULL, '0.00', 1, NULL),
(266, NULL, 'لصاقة نترو ملتي غرو ( 40 - 0 - 5 ) بودرة - 10 كغ', 33013, 11, 23, NULL, '0.00', 1, NULL),
(267, NULL, 'لصاقة المغلظ - 1 ليتر', 33014, 11, 23, NULL, '0.00', 1, NULL),
(268, NULL, 'لصاقة المغلظ - 5 ليتر', 33015, 11, 23, NULL, '0.00', 1, NULL),
(269, NULL, 'لصاقة فيرست ك ت اس - 5 ليتر', 33016, 11, 23, NULL, '0.00', 1, NULL),
(270, NULL, 'لصاقة فيرست ك ت اس - 1 ليتر', 33017, 11, 23, NULL, '0.00', 1, NULL),
(271, NULL, 'لصاقة ملتي غرو جل ( 5 - 25 - 36 ) - 2 كغ', 33018, 11, 23, NULL, '0.00', 1, NULL),
(272, NULL, 'لصاقة ملتي غرو جل ( 5 - 25 - 36 ) - 5 كغ', 33019, 11, 23, NULL, '0.00', 1, NULL),
(273, NULL, 'لصاقة ملتي غرو جل ( 10 - 50 - 10 ) - 2 كغ', 33020, 11, 23, NULL, '0.00', 1, NULL),
(274, NULL, 'لصاقة ملتي غرو جل ( 10 - 50 - 10 ) - 5 كغ', 33021, 11, 23, NULL, '0.00', 1, NULL),
(275, NULL, 'لصاقة غوفار بورون - 1 كغ', 33022, 11, 23, NULL, '0.00', 1, NULL),
(276, NULL, 'لصاقة غوفار امينو اسيد - 1/2 كغ', 33023, 11, 23, NULL, '0.00', 1, NULL),
(277, NULL, 'لصاقة باور فيد انيرجي - 5 كغ', 33063, 11, 23, NULL, '0.00', 1, NULL),
(278, NULL, 'لصاقة باور سيلفو كوبر - 1 ليتر', 33064, 11, 23, NULL, '0.00', 1, NULL),
(279, NULL, 'لصاقة بوروتاس هيوم - 5 كغ', 33065, 11, 23, NULL, '0.00', 1, NULL),
(280, NULL, 'لصاقة نترو ملتي غرو اكسترا - 1 كغ', 33024, 11, 23, NULL, '0.00', 1, NULL),
(281, NULL, 'لصاقة سولفيرتو متوازن ( 20 - 20 - 20 ) - 10 كغ', 33074, 11, 23, NULL, '0.00', 1, NULL),
(282, NULL, 'لصاقة نترو غو - 5 ليتر', 33025, 11, 23, NULL, '0.00', 1, NULL),
(283, NULL, 'لصاقة ملتي غرو جل ( 30 - 30 - 30 ) - 5 كغ', 33008, 11, 23, NULL, '0.00', 1, NULL),
(284, NULL, 'لصاقة نترو ملتي غرو ( 10 - 10 - 30 ) بودرة - 10 كغ', 33028, 11, 23, NULL, '0.00', 1, NULL),
(285, NULL, 'لصاقة نترو ملتي غرو ( 10 - 40 - 10 ) بودرة - 10 كغ', 33029, 11, 23, NULL, '0.00', 1, NULL),
(286, NULL, 'لصاقة بومبر - 5 كغ', 33026, 11, 23, NULL, '0.00', 1, NULL),
(287, NULL, 'لصاقة ملتي غرو جل ( 10 - 50 - 10 ) - 10 كغ', 33032, 11, 23, NULL, '0.00', 1, NULL),
(288, NULL, 'لصاقة ملتي غرو جل ( 5 - 25 - 36 ) - 10 كغ', 33033, 11, 23, NULL, '0.00', 1, NULL),
(289, NULL, 'لصاقة ملتي غرو جل ( 30 - 30 - 30 ) - 10 كغ', 33031, 11, 23, NULL, '0.00', 1, NULL),
(290, NULL, 'لصاقة ملتي غرو بي اتش - 1 ليتر', 33034, 11, 23, NULL, '0.00', 1, NULL),
(291, NULL, 'لصاقة باور فيد ازوت ( 40 - 0 - 5 ) - 10 كغ', 33059, 11, 23, NULL, '0.00', 1, NULL),
(292, NULL, 'لصاقة ملتي غرو سيت - 1 كغ', 33035, 11, 23, NULL, '0.00', 1, NULL),
(293, NULL, 'لصاقة باور فيد ايرون - 1 ليتر', 33066, 11, 23, NULL, '0.00', 1, NULL),
(294, NULL, 'لصاقة غريناج - 5 ليتر', 33041, 11, 23, NULL, '0.00', 1, NULL),
(295, NULL, 'لصاقة ملتي غرو العملاق - 1 ليتر', 33036, 11, 23, NULL, '0.00', 1, NULL),
(296, NULL, 'لصاقة ملتي غرو العملاق - 5 ليتر', 33037, 11, 23, NULL, '0.00', 1, NULL),
(297, NULL, 'لصاقة ملتي غرو كالسيوم - 5 ليتر', 33039, 11, 23, NULL, '0.00', 1, NULL),
(298, NULL, 'لصاقة غريناج - 1 ليتر', 33040, 11, 23, NULL, '0.00', 1, NULL),
(299, NULL, 'لصاقة كال غيفت - 1 ليتر', 33042, 11, 23, NULL, '0.00', 1, NULL),
(300, NULL, 'لصاقة كال غيفت - 5 ليتر', 33043, 11, 23, NULL, '0.00', 1, NULL),
(301, NULL, 'لصاقة باور لاين - 1/4 ليتر', 33044, 11, 23, NULL, '0.00', 1, NULL),
(302, NULL, 'لصاقة باور لاين - 1 ليتر', 33045, 11, 23, NULL, '0.00', 1, NULL),
(303, NULL, 'لصاقة ملتي غرو جل ازوت ( 32 - 15 - 6 ) - 2 كغ', 33047, 11, 23, NULL, '0.00', 1, NULL),
(304, NULL, 'لصاقة ملتي غرو جل ازوت ( 32- 15 - 6 ) - 10 كغ', 33048, 11, 23, NULL, '0.00', 1, NULL),
(305, NULL, 'لصاقة ايرون فيكس - 1 ليتر', 33049, 11, 23, NULL, '0.00', 1, NULL),
(306, NULL, 'لصاقة بلاش سوبر - 5 ليتر', 33050, 11, 23, NULL, '0.00', 1, NULL),
(307, NULL, 'لصاقة ملتي غرو 65 - 5 ليتر', 33051, 11, 23, NULL, '0.00', 1, NULL),
(308, NULL, 'لصاقة ملتي غرو جل ازوت ( 32 - 15 - 6 ) - 1 كغ', 33046, 11, 23, NULL, '0.00', 1, NULL),
(309, NULL, 'لصاقة باور فيد سيلفر - 1 ليتر', 33052, 11, 23, NULL, '0.00', 1, NULL),
(310, NULL, 'لصاقة باور فيد ك ت س - 1 ليتر', 33053, 11, 23, NULL, '0.00', 1, NULL),
(311, NULL, 'لصاقة ملتي غرو العملاق - 10 كغ', 33038, 11, 23, NULL, '0.00', 1, NULL),
(312, NULL, 'لصاقة باور فيد جل ( 10 - 10 - 36 ) - 10 كغ', 33056, 11, 23, NULL, '0.00', 1, NULL),
(313, NULL, 'لصاقة باور فيد جل ( 10 - 40 - 10 ) - 10 كغ', 33057, 11, 23, NULL, '0.00', 1, NULL),
(314, NULL, 'لصاقة باور فيد جل ( 20 - 20 - 20 ) - 10 كغ', 33058, 11, 23, NULL, '0.00', 1, NULL),
(315, NULL, 'لصاقة باور فيد تيكس - 1 ليتر', 33055, 11, 23, NULL, '0.00', 1, NULL),
(316, NULL, 'لصاقة بافر ( 0 - 32 - 0 ) - 1 ليتر', 33054, 11, 23, NULL, '0.00', 1, NULL),
(317, NULL, 'لصاقة نترو باور فيد اكسترا - 2 كغ', 33061, 11, 23, NULL, '0.00', 1, NULL),
(318, NULL, 'لصاقة ملتي غرو هيوم - 5 كغ', 33060, 11, 23, NULL, '0.00', 1, NULL),
(319, NULL, 'لصاقة نترو ملتي غرو ( 20 - 20 - 20 ) بودرة - 10 كغ', 33030, 11, 23, NULL, '0.00', 1, NULL),
(320, NULL, 'لصاقة باور فيد 62 - 5 ليتر', 33067, 11, 23, NULL, '0.00', 1, NULL),
(321, NULL, 'لصاقة باور فيد هيومات - 5 كغ', 33062, 11, 23, NULL, '0.00', 1, NULL),
(322, NULL, 'لصاقة شوغار باور - 5 كغ', 33027, 11, 23, NULL, '0.00', 1, NULL),
(323, NULL, 'لصاقة باور فيد ( 10 - 10 - 10 + 40% ) - 10 كغ', 33068, 11, 23, NULL, '0.00', 1, NULL),
(324, NULL, 'لصاقة باور فيد جل ( 30 - 30 - 30 ) - 10 كغ', 33071, 11, 23, NULL, '0.00', 1, NULL),
(325, NULL, 'لصاقة باور فيد جل ( 10 - 65 - 10 ) - 10 كغ', 33072, 11, 23, NULL, '0.00', 1, NULL),
(326, NULL, 'لصاقة باور فيد جل ( 5 - 25 - 41 ) - 10 كغ', 33073, 11, 23, NULL, '0.00', 1, NULL),
(327, NULL, 'لصاقة بومبر جل ( 12 - 12 - 12 ) - 10 كغ', 33070, 11, 23, NULL, '0.00', 1, NULL),
(328, NULL, 'لصاقة سولفيرتو فوسفور ( 18- 44 -0 ) - 10 كغ', 33075, 11, 23, NULL, '0.00', 1, NULL),
(329, NULL, 'لصاقة سولفيرتو بوتاس ( 16 - 0 - 37 ) - 10 كغ', 33076, 11, 23, NULL, '0.00', 1, NULL),
(330, NULL, 'لصاقة بابلي - 1 ليتر', 33077, 11, 23, NULL, '0.00', 1, NULL),
(331, NULL, 'لصاقة باور فيد ك ت س - 5 ليتر', 33078, 11, 23, NULL, '0.00', 1, NULL),
(332, NULL, 'لصاقة نترو غو - 1 ليتر', 33079, 11, 23, NULL, '0.00', 1, NULL),
(333, NULL, 'لصاقة نترو غو - 20 ليتر', 33080, 11, 23, NULL, '0.00', 1, NULL),
(334, NULL, 'لصاقة باور لاور - 7.5 كغ', 33081, 11, 23, NULL, '0.00', 1, NULL),
(335, NULL, 'لصاقة ملتي غرو انيرجي - 5 كغ', 33082, 11, 23, NULL, '0.00', 1, NULL),
(336, NULL, 'لصاقة باور فيد ( 20 - 20 - 20 ) بودرة - 10 كغ', 33083, 11, 23, NULL, '0.00', 1, NULL),
(337, NULL, 'لصاقة باور فيد ( 10 - 10 - 30 ) بودرة - 10 كغ', 33084, 11, 23, NULL, '0.00', 1, NULL),
(338, NULL, 'لصاقة باور فيد ( 10 - 40 - 10 ) بودرة - 10 كغ', 33085, 11, 23, NULL, '0.00', 1, NULL),
(339, NULL, 'لصاقة باور لاور 1 لتر', 33086, 11, 23, NULL, '0.00', 1, NULL),
(340, NULL, 'لصاقة بابلي 1/4 لتر', 33087, 11, 23, NULL, '0.00', 1, NULL),
(341, NULL, 'لصاقة بومبر بلاس ( 10 - 10 - 10) 5كغ', 33088, 11, 23, NULL, '0.00', 1, NULL),
(342, NULL, 'لصاقة ملتي غرو ( 20 - 20 - 20 ) 5لتر', 33090, 11, 23, NULL, '0.00', 1, NULL),
(343, NULL, 'لصاقة ملتي غرو بوتاس 5 لتر', 33092, 11, 23, NULL, '0.00', 1, NULL),
(344, NULL, 'لصاقة ملتي غرو فوسفور 5 لتر', 33094, 11, 23, NULL, '0.00', 1, NULL),
(345, NULL, 'لصاقة بومبر اكسترا 10كغ', 33096, 11, 23, NULL, '0.00', 1, NULL),
(346, NULL, 'لصاقة تريفيرتو سلفات امونيوم 10كغ', 33097, 11, 23, NULL, '0.00', 1, NULL),
(347, NULL, 'لصاقة غرين ماتركس 30 - 30 - 30', 33098, 11, 23, NULL, '0.00', 1, NULL),
(348, NULL, 'لصاقة غرين ماتركس 10 - 25 - 43', 33100, 11, 23, NULL, '0.00', 1, NULL),
(349, NULL, 'لصاقة غرين ماتركس 10 - 65 - 10', 33102, 11, 23, NULL, '0.00', 1, NULL),
(350, NULL, 'لصاقة هيومنريتش 25كغ', 33103, 11, 23, NULL, '0.00', 1, NULL),
(351, NULL, 'لصاقة لاور 8', 33104, 11, 23, NULL, '0.00', 1, NULL),
(352, NULL, 'لصاقة بابلي ( 0 - 30 - 60 ) 10كغ', 33105, 11, 23, NULL, '0.00', 1, NULL),
(353, NULL, 'لصاقة بابلي ( 5 - 25 - 42 ) 10كغ', 33106, 11, 23, NULL, '0.00', 1, NULL),
(354, NULL, 'لصاقة بابلي ( 25 - 25 - 25 ) 10كغ', 33107, 11, 23, NULL, '0.00', 1, NULL),
(355, NULL, 'لصاقة بابلي ( 10 - 65 - 10 ) 10كغ', 33108, 11, 23, NULL, '0.00', 1, NULL),
(356, NULL, 'لصاقة آمي غرين 5 كغ', 33109, 11, 23, NULL, '0.00', 1, NULL),
(357, NULL, 'بيدون مربع 25 كغ', 32001, 11, 7, NULL, '0.00', 1, NULL),
(358, NULL, 'غطاء ابيض 10 كغ', 32024, 11, 24, NULL, '0.00', 1, NULL),
(359, NULL, 'عبوة اخضر فارغة 1 ليتر', 32005, 11, 25, NULL, '0.00', 1, NULL),
(360, NULL, 'بيدون اسود مع غطاء - 30 كغ', 32029, 11, 7, NULL, '0.00', 1, NULL),
(361, NULL, 'غطاء اصفر 1 - 5 ليتر', 32009, 11, 24, NULL, '0.00', 1, NULL),
(362, NULL, 'غطاء علبة مدورة 2 كغ + 5 كغ', 32013, 11, 24, NULL, '0.00', 1, NULL),
(363, NULL, 'بيدون ازرق + ملون ( مانع رغوة ) 20 كغ', 32002, 11, 7, NULL, '0.00', 1, NULL),
(364, NULL, 'عبوة ابيض فارغة 1 ليتر', 32006, 11, 25, NULL, '0.00', 1, NULL),
(365, NULL, 'عبوة بلاستيك مدورة كبيرة سعة 5 كغ', 32012, 11, 25, NULL, '0.00', 1, NULL),
(366, NULL, 'عبوة بلاستيك مدورة صغيرة سعة 2 كغ', 32011, 11, 25, NULL, '0.00', 1, NULL),
(367, NULL, 'سطل ابيض بلاستيك مطبوع ملتي غرو جل فوسفور ( 10 - 50 - 10 ) - 10 كغ', 32026, 11, 26, NULL, '0.00', 1, NULL),
(368, NULL, 'سطل ابيض بلاستيك مطبوع ملتي غرو جل بوتاس ( 5 - 25 - 36 ) - 10 كغ', 32027, 11, 26, NULL, '0.00', 1, NULL),
(369, NULL, 'بيدون بلاستيك اخضر فارغ سعة 5 ليتر', 32007, 11, 7, NULL, '0.00', 1, NULL),
(370, NULL, 'خزانات بلاستيك', 32000, 11, 27, NULL, '0.00', 1, NULL),
(371, NULL, 'غطاء اصفر 10 كغ', 32020, 11, 24, NULL, '0.00', 1, NULL),
(372, NULL, 'سطل ابيض بلاستيك مطبوع ملتي غرو جل ازوت ( 32 - 15 - 6 ) - 10 كغ', 32028, 11, 26, NULL, '0.00', 1, NULL),
(373, NULL, 'سطل اخضر 1 كغ', 32016, 11, 26, NULL, '0.00', 1, NULL),
(374, NULL, 'غطاء اصفر 1/4 لتر', 32015, 11, 24, NULL, '0.00', 1, NULL),
(375, NULL, 'غطاء اصفر 1 كغ', 32017, 11, 24, NULL, '0.00', 1, NULL),
(376, NULL, 'برميل بلاستيك ازرق مدور', 32003, 11, 28, NULL, '0.00', 1, NULL),
(377, NULL, 'برميل كحول اثيلي حديد', 32004, 11, 28, NULL, '0.00', 1, NULL),
(378, NULL, 'عبوة فارغة 1/4 لتر', 32014, 11, 25, NULL, '0.00', 1, NULL),
(379, NULL, 'سطل ابيض بلاستيك مطبوع ملتي غرو جل متوازن ( 30 - 30 - 30 ) - 10 كغ', 32025, 11, 26, NULL, '0.00', 1, NULL),
(380, NULL, 'غطاء ازرق 10 كغ', 32021, 11, 24, NULL, '0.00', 1, NULL),
(381, NULL, 'غطاء اخضر 10 كغ', 32023, 11, 24, NULL, '0.00', 1, NULL),
(382, NULL, 'غطاء احمر 10 كغ', 32022, 11, 24, NULL, '0.00', 1, NULL),
(383, NULL, 'سطل اخضر 10 كغ', 32018, 11, 26, NULL, '0.00', 1, NULL),
(384, NULL, 'سطل ابيض 10 كغ', 32019, 11, 26, NULL, '0.00', 1, NULL),
(385, NULL, 'غطاء احمر 1 - 5 ليتر', 32010, 11, 24, NULL, '0.00', 1, NULL),
(386, NULL, 'بيدون بلاستيك ابيض فارغ سعة 5 ليتر', 32008, 11, 7, NULL, '0.00', 1, NULL),
(387, NULL, 'غطاء اخضر 1 - 5 ليتر', 32030, 11, 24, NULL, '0.00', 1, NULL),
(388, NULL, 'غطاء اصفر 20 لتر', 32031, 11, 24, NULL, '0.00', 1, NULL),
(389, NULL, 'غطاء اخضر 20 لتر', 32033, 11, 24, NULL, '0.00', 1, NULL),
(390, NULL, 'بيدون اسود 20 لتر مع غطاء', 32035, 11, 7, NULL, '0.00', 1, NULL),
(391, NULL, 'بيدون ابيض 20 لتر', 32037, 11, 7, NULL, '0.00', 1, NULL),
(392, NULL, 'اسطوانات غاز', 32038, 11, 28, NULL, '0.00', 1, NULL),
(393, NULL, 'سطل ابيض 12 لتر مع غطاء', 32039, 11, 26, NULL, '0.00', 1, NULL),
(394, NULL, 'غطا ازرق 1+5 لتر', 32040, 11, 26, NULL, '0.00', 1, NULL),
(395, NULL, 'جوانات التراسونيك 50 مم / 1/4 ليتر', 34004, 13, 29, NULL, '0.00', 1, NULL),
(396, NULL, 'جوان التراسونيك ( صباب ) فالة 62 مم', 34003, 13, 29, NULL, '0.00', 1, NULL),
(397, NULL, 'جوان قصدير علب جل 2 + 5 كغ', 34007, 13, 1, NULL, '0.00', 1, NULL),
(398, NULL, 'جوان كرتون دوائر لتعبئة علب 1/4 لتر', 34001, 13, 29, NULL, '0.00', 1, NULL),
(399, NULL, 'جوان كرتون دوائر لتعبئة علب 1 لتر + 5 لتر', 34002, 13, 29, NULL, '0.00', 1, NULL),
(400, NULL, 'جوان قصدير علب 1/4 لتر', 34005, 13, 29, NULL, '0.00', 1, NULL),
(401, NULL, 'جوان قصدير علب 1 + 5 لتر', 34006, 13, 1, NULL, '0.00', 1, NULL),
(402, NULL, 'جوان فلين علب 1 + 5 لتر', 34009, 13, 29, NULL, '0.00', 1, NULL),
(403, NULL, 'جوان فلين علب 1/4 لتر', 34008, 13, 29, NULL, '0.00', 1, NULL),
(404, NULL, 'طابع نقابي 1 ل.س', 37000, 14, 30, NULL, '0.00', 1, NULL),
(405, NULL, 'حزامات اكياس', 37007, 14, 31, NULL, '0.00', 1, NULL),
(406, NULL, 'لاصق عريض 5 سم', 37004, 14, 1, NULL, '0.00', 1, NULL),
(407, NULL, 'طابع نقابي 2 ل.س', 37001, 14, 30, NULL, '0.00', 1, NULL),
(408, NULL, 'لاصق الفادوكس شعلة', 37003, 14, 1, NULL, '0.00', 1, NULL),
(409, NULL, 'مغارف المنيوم', 37008, 14, 31, NULL, '0.00', 1, NULL),
(410, NULL, 'طابع نقابي 5 ل.س', 37002, 14, 30, NULL, '0.00', 1, NULL),
(411, NULL, 'طابع نقابي 4 ل.س', 37009, 14, 31, NULL, '0.00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `code` bigint DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `major_classification` smallint DEFAULT '1',
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `item_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `item_id`) VALUES
(1, NULL, 'المواد الاولية', 2, NULL, 1, 1, NULL, NULL),
(2, NULL, 'مواد اولية - مواد كيميائية', 21, 1, 1, 1, NULL, NULL),
(3, NULL, 'المواد الجاهزة', 1, NULL, 1, 1, NULL, NULL),
(4, NULL, 'البذور', 12, 3, 1, 1, NULL, NULL),
(5, NULL, 'السماد', 11, 3, 1, 1, NULL, NULL),
(6, NULL, 'مواد زراعية مختلفة', 13, 3, 1, 1, NULL, NULL),
(7, NULL, 'مواد التعبئة والتغليف', 3, NULL, 1, 1, NULL, NULL),
(8, NULL, 'علب الكرتون', 31, 7, 1, 1, NULL, NULL),
(9, NULL, 'اكياس', 35, 7, 1, 1, NULL, NULL),
(10, NULL, 'طرود خارجية', 36, 7, 1, 1, NULL, NULL),
(11, NULL, 'لصاقات', 33, 7, 1, 1, NULL, NULL),
(12, NULL, 'عبوات و بيدونات و اغطية', 32, 7, 1, 1, NULL, NULL),
(13, NULL, 'جوانات', 34, 7, 1, 1, NULL, NULL),
(14, NULL, 'مواد تعبئة و تغليف اخرى', 37, 7, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_tracking`
--

CREATE TABLE `item_tracking` (
  `id` int NOT NULL,
  `code` bigint DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `inventory_id_type_id` int DEFAULT NULL,
  `source` int DEFAULT NULL,
  `destination` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `bill_id` int DEFAULT NULL,
  `note` text,
  `transaction_operation` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `p_code` varchar(50) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int DEFAULT '0',
  `delete_action` varchar(10) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `item_tracking`
--

INSERT INTO `item_tracking` (`id`, `code`, `item_id`, `inventory_id_type_id`, `source`, `destination`, `date`, `quantity`, `bill_id`, `note`, `transaction_operation`, `active`, `sorting`, `p_code`, `create_at`, `create_by`, `delete_at`, `delete_by`, `delete_action`, `rotate_year`) VALUES
(1, 12007, 91, 5, 3, NULL, '2021-11-17', 167, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, 12011, 95, 5, 3, NULL, '2021-11-16', 134, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(3, 12012, 96, 5, 3, NULL, '2021-11-16', 53, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(4, 12013, 97, 5, 3, NULL, '2021-11-16', 157, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(5, 12015, 99, 5, 3, NULL, '2021-11-16', 25, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(6, 11028, 106, 5, 15, NULL, '2021-11-16', -16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(7, 11029, 107, 5, 15, NULL, '2021-11-16', 238, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, 12011, 95, 5, 15, NULL, '2021-11-16', 18, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(9, 13002, 113, 5, 15, NULL, '2021-11-16', -305, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(10, 13003, 114, 5, 15, NULL, '2021-11-16', 1549, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(11, 13004, 115, 5, 15, NULL, '2021-11-16', -310, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(12, 13005, 116, 5, 15, NULL, '2021-11-16', -49, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(13, 13006, 117, 5, 15, NULL, '2021-11-16', -43, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(14, 13009, 120, 5, 15, NULL, '2021-11-16', 286, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(15, 13010, 121, 5, 15, NULL, '2021-11-16', -240, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(16, 13011, 122, 5, 15, NULL, '2021-11-16', 72, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(17, 13012, 123, 5, 15, NULL, '2021-11-16', 133, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(18, 13014, 125, 5, 15, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(19, 13016, 127, 5, 15, NULL, '2021-11-16', 345, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(20, 13019, 129, 5, 15, NULL, '2021-11-16', 16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(21, 13021, 131, 5, 15, NULL, '2021-11-16', -14, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(22, 13022, 143, 5, 15, NULL, '2021-11-16', -10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(23, 13024, 133, 5, 15, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(24, 13026, 135, 5, 15, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(25, 13027, 139, 5, 15, NULL, '2021-11-16', 35, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(26, 13028, 128, 5, 15, NULL, '2021-11-16', -24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(27, 13029, 138, 5, 15, NULL, '2021-11-16', -3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(28, 13030, 136, 5, 15, NULL, '2021-11-16', 552, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(29, 13033, 144, 5, 15, NULL, '2021-11-16', -88, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(30, 13034, 145, 5, 15, NULL, '2021-11-16', -42, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(31, 13036, 149, 5, 15, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(32, 13038, 151, 5, 15, NULL, '2021-11-16', -4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(33, 13047, 160, 5, 15, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(34, 13050, 163, 5, 15, NULL, '2021-11-16', -4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(35, 13051, 164, 5, 15, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(36, 13059, 167, 5, 15, NULL, '2021-11-16', 204, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(37, 13061, 169, 5, 15, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(38, 13062, 171, 5, 15, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(39, 13063, 172, 5, 15, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(40, 13065, 173, 5, 15, NULL, '2021-11-16', -96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(41, 13069, 177, 5, 15, NULL, '2021-11-16', 52, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(42, 13071, 179, 5, 15, NULL, '2021-11-16', -12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(43, 13084, 192, 5, 15, NULL, '2021-11-16', -100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(44, 13089, 197, 5, 15, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(45, 13091, 199, 5, 15, NULL, '2021-11-16', -10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(46, 13092, 200, 5, 15, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(47, 13093, 201, 5, 15, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(48, 13097, 205, 5, 15, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(49, 13101, 209, 5, 15, NULL, '2021-11-16', -20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(50, 13102, 210, 5, 15, NULL, '2021-11-16', -20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(51, 13103, 211, 5, 15, NULL, '2021-11-16', -20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(52, 21048, 53, 5, 15, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(53, 11028, 106, 5, 10, NULL, '2021-11-16', 116, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(54, 11029, 107, 5, 10, NULL, '2021-11-16', 260, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(55, 11030, 108, 5, 10, NULL, '2021-11-16', 81, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(56, 12011, 95, 5, 10, NULL, '2021-11-16', 60, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(57, 12013, 97, 5, 10, NULL, '2021-11-16', 107, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(58, 12015, 99, 5, 10, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(59, 13001, 112, 5, 10, NULL, '2021-11-16', 83, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(60, 13002, 113, 5, 10, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(61, 13003, 114, 5, 10, NULL, '2021-11-16', 96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(62, 13004, 115, 5, 10, NULL, '2021-11-16', 192, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(63, 13005, 116, 5, 10, NULL, '2021-11-16', 54, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(64, 13006, 117, 5, 10, NULL, '2021-11-16', 108, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(65, 13007, 118, 5, 10, NULL, '2021-11-16', 280, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(66, 13008, 119, 5, 10, NULL, '2021-11-16', 167, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(67, 13009, 120, 5, 10, NULL, '2021-11-16', 594, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(68, 13010, 121, 5, 10, NULL, '2021-11-16', 1488, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(69, 13011, 122, 5, 10, NULL, '2021-11-16', 119, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(70, 13012, 123, 5, 10, NULL, '2021-11-16', 107, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(71, 13013, 124, 5, 10, NULL, '2021-11-16', 179, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(72, 13014, 125, 5, 10, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(73, 13016, 127, 5, 10, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(74, 13018, 137, 5, 10, NULL, '2021-11-16', 311, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(75, 13019, 129, 5, 10, NULL, '2021-11-16', 56, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(76, 13021, 131, 5, 10, NULL, '2021-11-16', 488, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(77, 13022, 143, 5, 10, NULL, '2021-11-16', 171, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(78, 13024, 133, 5, 10, NULL, '2021-11-16', 158, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(79, 13026, 135, 5, 10, NULL, '2021-11-16', 663, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(80, 13027, 139, 5, 10, NULL, '2021-11-16', 402, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(81, 13028, 128, 5, 10, NULL, '2021-11-16', 286, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(82, 13029, 138, 5, 10, NULL, '2021-11-16', 38, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(83, 13030, 136, 5, 10, NULL, '2021-11-16', 168, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(84, 13031, 140, 5, 10, NULL, '2021-11-16', 85, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(85, 13032, 141, 5, 10, NULL, '2021-11-16', 118, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(86, 13033, 144, 5, 10, NULL, '2021-11-16', 148, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(87, 13034, 145, 5, 10, NULL, '2021-11-16', 189, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(88, 13035, 146, 5, 10, NULL, '2021-11-16', 117, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(89, 13036, 149, 5, 10, NULL, '2021-11-16', 315, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(90, 13037, 150, 5, 10, NULL, '2021-11-16', 396, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(91, 13038, 151, 5, 10, NULL, '2021-11-16', 100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(92, 13041, 154, 5, 10, NULL, '2021-11-16', 38, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(93, 13048, 161, 5, 10, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(94, 13050, 163, 5, 10, NULL, '2021-11-16', 64, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(95, 13052, 165, 5, 10, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(96, 13063, 172, 5, 10, NULL, '2021-11-16', 106, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(97, 13064, 170, 5, 10, NULL, '2021-11-16', 263, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(98, 13065, 173, 5, 10, NULL, '2021-11-16', 415, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(99, 13066, 174, 5, 10, NULL, '2021-11-16', 145, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(100, 13067, 175, 5, 10, NULL, '2021-11-16', 2278, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(101, 13071, 179, 5, 10, NULL, '2021-11-16', 36, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(102, 13073, 180, 5, 10, NULL, '2021-11-16', 424, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(103, 13075, 187, 5, 10, NULL, '2021-11-16', 394, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(104, 13079, 185, 5, 10, NULL, '2021-11-16', 181, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(105, 13083, 191, 5, 10, NULL, '2021-11-16', 336, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(106, 13084, 192, 5, 10, NULL, '2021-11-16', 100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(107, 13087, 195, 5, 10, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(108, 13090, 198, 5, 10, NULL, '2021-11-16', 56, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(109, 13091, 199, 5, 10, NULL, '2021-11-16', 30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(110, 13092, 200, 5, 10, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(111, 13093, 201, 5, 10, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(112, 13096, 204, 5, 10, NULL, '2021-11-16', 66, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(113, 13097, 205, 5, 10, NULL, '2021-11-16', 203, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(114, 13098, 206, 5, 10, NULL, '2021-11-16', 195, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(115, 13101, 209, 5, 10, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(116, 13102, 210, 5, 10, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(117, 13103, 211, 5, 10, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(118, 13104, 212, 5, 10, NULL, '2021-11-16', 25, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(119, 13105, 213, 5, 10, NULL, '2021-11-16', 13, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(120, 21048, 53, 5, 10, NULL, '2021-11-16', 50, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(121, 32018, 383, 5, 10, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(122, 32019, 384, 5, 10, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(123, 33031, 289, 5, 10, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(124, 33100, 348, 5, 10, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(125, 33103, 350, 5, 10, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(126, 37002, 410, 5, 10, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(127, 11028, 106, 5, 6, NULL, '2021-11-16', 166, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(128, 12011, 95, 5, 6, NULL, '2021-11-16', 25, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(129, 12012, 96, 5, 6, NULL, '2021-11-16', 18, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(130, 13001, 112, 5, 6, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(131, 13002, 113, 5, 6, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(132, 13003, 114, 5, 6, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(133, 13004, 115, 5, 6, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(134, 13006, 117, 5, 6, NULL, '2021-11-16', 60, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(135, 13007, 118, 5, 6, NULL, '2021-11-16', 60, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(136, 13008, 119, 5, 6, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(137, 13009, 120, 5, 6, NULL, '2021-11-16', 432, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(138, 13012, 123, 5, 6, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(139, 13014, 125, 5, 6, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(140, 13016, 127, 5, 6, NULL, '2021-11-16', 48, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(141, 13018, 137, 5, 6, NULL, '2021-11-16', 51, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(142, 13019, 129, 5, 6, NULL, '2021-11-16', 50, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(143, 13031, 140, 5, 6, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(144, 13032, 141, 5, 6, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(145, 13035, 146, 5, 6, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(146, 13037, 150, 5, 6, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(147, 13038, 151, 5, 6, NULL, '2021-11-16', 17, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(148, 13048, 161, 5, 6, NULL, '2021-11-16', 156, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(149, 13052, 165, 5, 6, NULL, '2021-11-16', 96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(150, 13058, 142, 5, 6, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(151, 13064, 170, 5, 6, NULL, '2021-11-16', 148, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(152, 13071, 179, 5, 6, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(153, 13076, 182, 5, 6, NULL, '2021-11-16', 108, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(154, 13088, 196, 5, 6, NULL, '2021-11-16', 30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(155, 13092, 200, 5, 6, NULL, '2021-11-16', 14, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(156, 13093, 201, 5, 6, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(157, 13096, 204, 5, 6, NULL, '2021-11-16', 52, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(158, 13097, 205, 5, 6, NULL, '2021-11-16', 95, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(159, 13098, 206, 5, 6, NULL, '2021-11-16', 157, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(160, 13101, 209, 5, 6, NULL, '2021-11-16', 30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(161, 13104, 212, 5, 6, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(162, 21048, 53, 5, 6, NULL, '2021-11-16', 36, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(163, 11028, 106, 5, 5, NULL, '2021-11-16', -10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(164, 12004, 88, 5, 5, NULL, '2021-11-16', 19, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(165, 12011, 95, 5, 5, NULL, '2021-11-16', 212, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(166, 12012, 96, 5, 5, NULL, '2021-11-16', 147, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(167, 12013, 97, 5, 5, NULL, '2021-11-16', 777, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(168, 12014, 98, 5, 5, NULL, '2021-11-16', 106, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(169, 12015, 99, 5, 5, NULL, '2021-11-16', 89, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(170, 13002, 113, 5, 5, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(171, 13004, 115, 5, 5, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(172, 13007, 118, 5, 5, NULL, '2021-11-16', -12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(173, 13008, 119, 5, 5, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(174, 13009, 120, 5, 5, NULL, '2021-11-16', -12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(175, 13015, 126, 5, 5, NULL, '2021-11-16', 648, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(176, 13016, 127, 5, 5, NULL, '2021-11-16', 108, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(177, 13018, 137, 5, 5, NULL, '2021-11-16', -74, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(178, 13019, 129, 5, 5, NULL, '2021-11-16', -4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(179, 13021, 131, 5, 5, NULL, '2021-11-16', 80, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(180, 13022, 143, 5, 5, NULL, '2021-11-16', 7, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(181, 13024, 133, 5, 5, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(182, 13028, 128, 5, 5, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(183, 13029, 138, 5, 5, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(184, 13032, 141, 5, 5, NULL, '2021-11-16', -24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(185, 13033, 144, 5, 5, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(186, 13034, 145, 5, 5, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(187, 13042, 155, 5, 5, NULL, '2021-11-16', 41, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(188, 13048, 161, 5, 5, NULL, '2021-11-16', -24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(189, 13052, 165, 5, 5, NULL, '2021-11-16', -36, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(190, 13053, 109, 5, 5, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(191, 13058, 142, 5, 5, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(192, 13059, 167, 5, 5, NULL, '2021-11-16', 189, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(193, 13064, 170, 5, 5, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(194, 13071, 179, 5, 5, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(195, 13079, 185, 5, 5, NULL, '2021-11-16', 96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(196, 13088, 196, 5, 5, NULL, '2021-11-16', -12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(197, 13096, 204, 5, 5, NULL, '2021-11-16', -39, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(198, 13097, 205, 5, 5, NULL, '2021-11-16', -40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(199, 13098, 206, 5, 5, NULL, '2021-11-16', -96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(200, 21048, 53, 5, 5, NULL, '2021-11-16', -5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(201, 11015, 3, 5, 2, NULL, '2021-11-16', 9925, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(202, 11016, 4, 5, 2, NULL, '2021-11-16', 668, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(203, 11017, 57, 5, 2, NULL, '2021-11-16', 1625, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(204, 11028, 106, 5, 2, NULL, '2021-11-16', 130, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(205, 11029, 107, 5, 2, NULL, '2021-11-16', 696, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(206, 11030, 108, 5, 2, NULL, '2021-11-16', 828, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(207, 12011, 95, 5, 2, NULL, '2021-11-16', 150, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(208, 12012, 96, 5, 2, NULL, '2021-11-16', 700, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(209, 12013, 97, 5, 2, NULL, '2021-11-16', 1340, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(210, 13001, 112, 5, 2, NULL, '2021-11-16', 26, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(211, 13002, 113, 5, 2, NULL, '2021-11-16', 190, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(212, 13003, 114, 5, 2, NULL, '2021-11-16', 1346, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(213, 13004, 115, 5, 2, NULL, '2021-11-16', 281, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(214, 13005, 116, 5, 2, NULL, '2021-11-16', 272, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(215, 13006, 117, 5, 2, NULL, '2021-11-16', 111, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(216, 13007, 118, 5, 2, NULL, '2021-11-16', 1197, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(217, 13008, 119, 5, 2, NULL, '2021-11-16', 510, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(218, 13009, 120, 5, 2, NULL, '2021-11-16', 1080, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(219, 13010, 121, 5, 2, NULL, '2021-11-16', 2433, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(220, 13011, 122, 5, 2, NULL, '2021-11-16', 605, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(221, 13012, 123, 5, 2, NULL, '2021-11-16', 986, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(222, 13013, 124, 5, 2, NULL, '2021-11-16', 180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(223, 13014, 125, 5, 2, NULL, '2021-11-16', 6, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(224, 13015, 126, 5, 2, NULL, '2021-11-16', 1817, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(225, 13016, 127, 5, 2, NULL, '2021-11-16', 376, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(226, 13018, 137, 5, 2, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(227, 13019, 129, 5, 2, NULL, '2021-11-16', 64, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(228, 13020, 130, 5, 2, NULL, '2021-11-16', 136, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(229, 13021, 131, 5, 2, NULL, '2021-11-16', 230, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(230, 13022, 143, 5, 2, NULL, '2021-11-16', 6, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(231, 13024, 133, 5, 2, NULL, '2021-11-16', 490, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(232, 13026, 135, 5, 2, NULL, '2021-11-16', 423, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(233, 13027, 139, 5, 2, NULL, '2021-11-16', 478, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(234, 13028, 128, 5, 2, NULL, '2021-11-16', 780, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(235, 13029, 138, 5, 2, NULL, '2021-11-16', 278, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(236, 13030, 136, 5, 2, NULL, '2021-11-16', 833, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(237, 13031, 140, 5, 2, NULL, '2021-11-16', 309, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(238, 13032, 141, 5, 2, NULL, '2021-11-16', 2973, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(239, 13033, 144, 5, 2, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(240, 13034, 145, 5, 2, NULL, '2021-11-16', 347, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(241, 13035, 146, 5, 2, NULL, '2021-11-16', 1293, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(242, 13036, 149, 5, 2, NULL, '2021-11-16', 2434, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(243, 13037, 150, 5, 2, NULL, '2021-11-16', 398, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(244, 13038, 151, 5, 2, NULL, '2021-11-16', 105, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(245, 13041, 154, 5, 2, NULL, '2021-11-16', 208, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(246, 13042, 155, 5, 2, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(247, 13044, 157, 5, 2, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(248, 13045, 158, 5, 2, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(249, 13046, 159, 5, 2, NULL, '2021-11-16', 41, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(250, 13047, 160, 5, 2, NULL, '2021-11-16', 378, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(251, 13048, 161, 5, 2, NULL, '2021-11-16', 1034, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(252, 13049, 162, 5, 2, NULL, '2021-11-16', 879, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(253, 13050, 163, 5, 2, NULL, '2021-11-16', 16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(254, 13051, 164, 5, 2, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(255, 13052, 165, 5, 2, NULL, '2021-11-16', 453, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(256, 13053, 109, 5, 2, NULL, '2021-11-16', 2043, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(257, 13055, 111, 5, 2, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(258, 13056, 147, 5, 2, NULL, '2021-11-16', 128, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(259, 13058, 142, 5, 2, NULL, '2021-11-16', 228, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(260, 13059, 167, 5, 2, NULL, '2021-11-16', 9, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(261, 13060, 168, 5, 2, NULL, '2021-11-16', 219, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(262, 13061, 169, 5, 2, NULL, '2021-11-16', 30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(263, 13062, 171, 5, 2, NULL, '2021-11-16', 67, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(264, 13063, 172, 5, 2, NULL, '2021-11-16', 1785, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(265, 13064, 170, 5, 2, NULL, '2021-11-16', 237, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(266, 13065, 173, 5, 2, NULL, '2021-11-16', 2004, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(267, 13066, 174, 5, 2, NULL, '2021-11-16', 177, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(268, 13067, 175, 5, 2, NULL, '2021-11-16', 2736, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(269, 13068, 176, 5, 2, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(270, 13069, 177, 5, 2, NULL, '2021-11-16', 145, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(271, 13071, 179, 5, 2, NULL, '2021-11-16', 1365, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(272, 13072, 181, 5, 2, NULL, '2021-11-16', 104, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(273, 13073, 180, 5, 2, NULL, '2021-11-16', 606, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(274, 13074, 186, 5, 2, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(275, 13075, 187, 5, 2, NULL, '2021-11-16', 103, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(276, 13076, 182, 5, 2, NULL, '2021-11-16', 516, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(277, 13077, 183, 5, 2, NULL, '2021-11-16', 180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(278, 13078, 184, 5, 2, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(279, 13079, 185, 5, 2, NULL, '2021-11-16', 50, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(280, 13080, 188, 5, 2, NULL, '2021-11-16', 23, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(281, 13081, 189, 5, 2, NULL, '2021-11-16', 440, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(282, 13084, 192, 5, 2, NULL, '2021-11-16', 23, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(283, 13085, 193, 5, 2, NULL, '2021-11-16', 64, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(284, 13086, 194, 5, 2, NULL, '2021-11-16', 59, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(285, 13087, 195, 5, 2, NULL, '2021-11-16', 1788, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(286, 13088, 196, 5, 2, NULL, '2021-11-16', 43, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(287, 13089, 197, 5, 2, NULL, '2021-11-16', 146, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(288, 13090, 198, 5, 2, NULL, '2021-11-16', 144, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(289, 13091, 199, 5, 2, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(290, 13092, 200, 5, 2, NULL, '2021-11-16', 308, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(291, 13093, 201, 5, 2, NULL, '2021-11-16', 499, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(292, 13094, 202, 5, 2, NULL, '2021-11-16', 400, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(293, 13096, 204, 5, 2, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(294, 13097, 205, 5, 2, NULL, '2021-11-16', 10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(295, 13098, 206, 5, 2, NULL, '2021-11-16', 113, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(296, 13100, 208, 5, 2, NULL, '2021-11-16', 72, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(297, 13101, 209, 5, 2, NULL, '2021-11-16', 185, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(298, 13102, 210, 5, 2, NULL, '2021-11-16', 19, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(299, 13103, 211, 5, 2, NULL, '2021-11-16', 13, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(300, 13104, 212, 5, 2, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(301, 13105, 213, 5, 2, NULL, '2021-11-16', 560, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(302, 21002, 55, 5, 2, NULL, '2021-11-16', 75, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(303, 21004, 26, 5, 2, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(304, 21008, 11, 5, 2, NULL, '2021-11-16', 4008, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(305, 21010, 13, 5, 2, NULL, '2021-11-16', 412, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(306, 21011, 14, 5, 2, NULL, '2021-11-16', 422, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(307, 21012, 15, 5, 2, NULL, '2021-11-16', 324, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(308, 21013, 16, 5, 2, NULL, '2021-11-16', 183, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(309, 21015, 18, 5, 2, NULL, '2021-11-16', 19180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(310, 21016, 19, 5, 2, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(311, 21017, 20, 5, 2, NULL, '2021-11-16', 262, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(312, 21018, 21, 5, 2, NULL, '2021-11-16', 16081, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(313, 21019, 22, 5, 2, NULL, '2021-11-16', 9, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(314, 21020, 23, 5, 2, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(315, 21021, 24, 5, 2, NULL, '2021-11-16', 76690, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(316, 21022, 25, 5, 2, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(317, 21023, 30, 5, 2, NULL, '2021-11-16', 136, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(318, 21024, 27, 5, 2, NULL, '2021-11-16', 7, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(319, 21025, 28, 5, 2, NULL, '2021-11-16', 22210, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(320, 21026, 29, 5, 2, NULL, '2021-11-16', 94, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(321, 21027, 34, 5, 2, NULL, '2021-11-16', 500, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(322, 21028, 31, 5, 2, NULL, '2021-11-16', 600, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(323, 21030, 47, 5, 2, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(324, 21031, 33, 5, 2, NULL, '2021-11-16', 3517, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(325, 21032, 35, 5, 2, NULL, '2021-11-16', 825, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(326, 21033, 40, 5, 2, NULL, '2021-11-16', 3340, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(327, 21034, 38, 5, 2, NULL, '2021-11-16', 10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(328, 21037, 39, 5, 2, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(329, 21045, 49, 5, 2, NULL, '2021-11-16', 503, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(330, 21046, 52, 5, 2, NULL, '2021-11-16', 114, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(331, 21048, 53, 5, 2, NULL, '2021-11-16', 482, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(332, 21052, 5, 5, 2, NULL, '2021-11-16', 23594, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(333, 21053, 58, 5, 2, NULL, '2021-11-16', 9000, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(334, 21054, 59, 5, 2, NULL, '2021-11-16', 17508, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(335, 21055, 60, 5, 2, NULL, '2021-11-16', 2318, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(336, 21061, 66, 5, 2, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(337, 21063, 68, 5, 2, NULL, '2021-11-16', 4000, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(338, 21064, 69, 5, 2, NULL, '2021-11-16', 17, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(339, 21065, 70, 5, 2, NULL, '2021-11-16', 58, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(340, 21066, 71, 5, 2, NULL, '2021-11-16', 61900, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(341, 21067, 72, 5, 2, NULL, '2021-11-16', 46, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(342, 21068, 73, 5, 2, NULL, '2021-11-16', 51175, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(343, 21069, 74, 5, 2, NULL, '2021-11-16', 1340, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(344, 21071, 76, 5, 2, NULL, '2021-11-16', 58400, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(345, 21072, 77, 5, 2, NULL, '2021-11-16', 48735, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(346, 21073, 78, 5, 2, NULL, '2021-11-16', 21835, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(347, 21074, 79, 5, 2, NULL, '2021-11-16', 1785, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(348, 21076, 81, 5, 2, NULL, '2021-11-16', 575, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(349, 21077, 82, 5, 2, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(350, 21078, 83, 5, 2, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(351, 21080, 84, 5, 2, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(352, 31001, 217, 5, 2, NULL, '2021-11-16', 1196, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(353, 31002, 214, 5, 2, NULL, '2021-11-16', 4601, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(354, 31003, 218, 5, 2, NULL, '2021-11-16', 3825, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(355, 31004, 219, 5, 2, NULL, '2021-11-16', 6575, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(356, 31005, 221, 5, 2, NULL, '2021-11-16', 5545, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(357, 31006, 220, 5, 2, NULL, '2021-11-16', 8823, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(358, 31007, 215, 5, 2, NULL, '2021-11-16', -40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(359, 31008, 216, 5, 2, NULL, '2021-11-16', 4104, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(360, 31009, 222, 5, 2, NULL, '2021-11-16', 2531, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(361, 31010, 223, 5, 2, NULL, '2021-11-16', 4099, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(362, 31012, 225, 5, 2, NULL, '2021-11-16', 2647, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(363, 31013, 226, 5, 2, NULL, '2021-11-16', 6184, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(364, 31014, 227, 5, 2, NULL, '2021-11-16', 5000, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(365, 32000, 370, 5, 2, NULL, '2021-11-16', 91, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(366, 32002, 363, 5, 2, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(367, 32003, 376, 5, 2, NULL, '2021-11-16', 21, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(368, 32004, 377, 5, 2, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(369, 32006, 364, 5, 2, NULL, '2021-11-16', 6535, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(370, 32007, 369, 5, 2, NULL, '2021-11-16', 956, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(371, 32008, 386, 5, 2, NULL, '2021-11-16', 6452, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(372, 32009, 361, 5, 2, NULL, '2021-11-16', 3480, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(373, 32010, 385, 5, 2, NULL, '2021-11-16', 15896, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(374, 32011, 366, 5, 2, NULL, '2021-11-16', 2932, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(375, 32012, 365, 5, 2, NULL, '2021-11-16', 1113, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(376, 32013, 362, 5, 2, NULL, '2021-11-16', 4045, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(377, 32014, 378, 5, 2, NULL, '2021-11-16', 1522, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(378, 32015, 374, 5, 2, NULL, '2021-11-16', 1522, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(379, 32016, 373, 5, 2, NULL, '2021-11-16', 1209, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(380, 32017, 375, 5, 2, NULL, '2021-11-16', 1209, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(381, 32018, 383, 5, 2, NULL, '2021-11-16', 307, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(382, 32019, 384, 5, 2, NULL, '2021-11-16', 368, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(383, 32020, 371, 5, 2, NULL, '2021-11-16', 501, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(384, 32021, 380, 5, 2, NULL, '2021-11-16', 114, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(385, 32023, 381, 5, 2, NULL, '2021-11-16', 64, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(386, 32024, 358, 5, 2, NULL, '2021-11-16', 3181, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(387, 32025, 379, 5, 2, NULL, '2021-11-16', 1468, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(388, 32026, 367, 5, 2, NULL, '2021-11-16', 500, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(389, 32027, 368, 5, 2, NULL, '2021-11-16', 425, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(390, 32028, 372, 5, 2, NULL, '2021-11-16', 782, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(391, 32029, 360, 5, 2, NULL, '2021-11-16', 27, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(392, 32030, 387, 5, 2, NULL, '2021-11-16', 6276, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(393, 32031, 388, 5, 2, NULL, '2021-11-16', 510, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(394, 32035, 390, 5, 2, NULL, '2021-11-16', 209, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(395, 32037, 391, 5, 2, NULL, '2021-11-16', 504, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(396, 32039, 393, 5, 2, NULL, '2021-11-16', 2744, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(397, 32040, 394, 5, 2, NULL, '2021-11-16', 1082, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(398, 33001, 254, 5, 2, NULL, '2021-11-16', 6655, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(399, 33002, 255, 5, 2, NULL, '2021-11-16', 4832, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(400, 33003, 256, 5, 2, NULL, '2021-11-16', 3624, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(401, 33004, 257, 5, 2, NULL, '2021-11-16', 419, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(402, 33005, 258, 5, 2, NULL, '2021-11-16', 4708, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(403, 33006, 259, 5, 2, NULL, '2021-11-16', 4707, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(404, 33007, 260, 5, 2, NULL, '2021-11-16', 3608, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(405, 33008, 283, 5, 2, NULL, '2021-11-16', 4957, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(406, 33009, 262, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(407, 33010, 263, 5, 2, NULL, '2021-11-16', 6803, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(408, 33011, 264, 5, 2, NULL, '2021-11-16', 5936, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(409, 33012, 265, 5, 2, NULL, '2021-11-16', 2158, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(410, 33013, 266, 5, 2, NULL, '2021-11-16', 21883, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(411, 33014, 267, 5, 2, NULL, '2021-11-16', 6483, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(412, 33015, 268, 5, 2, NULL, '2021-11-16', 5160, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(413, 33016, 269, 5, 2, NULL, '2021-11-16', 6587, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(414, 33017, 270, 5, 2, NULL, '2021-11-16', 5099, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(415, 33018, 271, 5, 2, NULL, '2021-11-16', 2054, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(416, 33019, 272, 5, 2, NULL, '2021-11-16', 2098, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(417, 33020, 273, 5, 2, NULL, '2021-11-16', 8663, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(418, 33021, 274, 5, 2, NULL, '2021-11-16', 2031, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(419, 33022, 275, 5, 2, NULL, '2021-11-16', 963, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(420, 33025, 282, 5, 2, NULL, '2021-11-16', 5324, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(421, 33026, 286, 5, 2, NULL, '2021-11-16', 2040, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(422, 33027, 322, 5, 2, NULL, '2021-11-16', 3198, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(423, 33028, 284, 5, 2, NULL, '2021-11-16', 13757, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(424, 33029, 285, 5, 2, NULL, '2021-11-16', 11153, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(425, 33030, 319, 5, 2, NULL, '2021-11-16', 7162, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(426, 33031, 289, 5, 2, NULL, '2021-11-16', 3428, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(427, 33032, 287, 5, 2, NULL, '2021-11-16', 2959, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(428, 33033, 288, 5, 2, NULL, '2021-11-16', 1872, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(429, 33034, 290, 5, 2, NULL, '2021-11-16', 6569, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(430, 33035, 292, 5, 2, NULL, '2021-11-16', 8820, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(431, 33036, 295, 5, 2, NULL, '2021-11-16', 2502, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(432, 33037, 296, 5, 2, NULL, '2021-11-16', 2692, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(433, 33038, 311, 5, 2, NULL, '2021-11-16', 3176, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(434, 33039, 297, 5, 2, NULL, '2021-11-16', 3628, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(435, 33040, 298, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(436, 33041, 294, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(437, 33042, 299, 5, 2, NULL, '2021-11-16', 3252, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `item_tracking` (`id`, `code`, `item_id`, `inventory_id_type_id`, `source`, `destination`, `date`, `quantity`, `bill_id`, `note`, `transaction_operation`, `active`, `sorting`, `p_code`, `create_at`, `create_by`, `delete_at`, `delete_by`, `delete_action`, `rotate_year`) VALUES
(438, 33043, 300, 5, 2, NULL, '2021-11-16', 3974, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(439, 33044, 301, 5, 2, NULL, '2021-11-16', 5250, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(440, 33045, 302, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(441, 33046, 308, 5, 2, NULL, '2021-11-16', 1830, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(442, 33047, 303, 5, 2, NULL, '2021-11-16', 5400, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(443, 33048, 304, 5, 2, NULL, '2021-11-16', 4149, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(444, 33049, 305, 5, 2, NULL, '2021-11-16', 4596, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(445, 33050, 306, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(446, 33051, 307, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(447, 33052, 309, 5, 2, NULL, '2021-11-16', 3092, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(448, 33053, 310, 5, 2, NULL, '2021-11-16', 5215, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(449, 33054, 316, 5, 2, NULL, '2021-11-16', 9082, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(450, 33055, 315, 5, 2, NULL, '2021-11-16', 6049, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(451, 33056, 312, 5, 2, NULL, '2021-11-16', 4148, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(452, 33057, 313, 5, 2, NULL, '2021-11-16', 3650, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(453, 33058, 314, 5, 2, NULL, '2021-11-16', 3376, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(454, 33059, 291, 5, 2, NULL, '2021-11-16', 6317, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(455, 33060, 318, 5, 2, NULL, '2021-11-16', 4900, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(456, 33061, 317, 5, 2, NULL, '2021-11-16', 4709, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(457, 33062, 321, 5, 2, NULL, '2021-11-16', 2908, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(458, 33063, 277, 5, 2, NULL, '2021-11-16', 2767, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(459, 33064, 278, 5, 2, NULL, '2021-11-16', 8625, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(460, 33065, 279, 5, 2, NULL, '2021-11-16', 5200, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(461, 33066, 293, 5, 2, NULL, '2021-11-16', 5100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(462, 33067, 320, 5, 2, NULL, '2021-11-16', 3631, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(463, 33068, 323, 5, 2, NULL, '2021-11-16', 9415, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(464, 33069, 261, 5, 2, NULL, '2021-11-16', 6830, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(465, 33070, 327, 5, 2, NULL, '2021-11-16', 10481, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(466, 33071, 324, 5, 2, NULL, '2021-11-16', 6718, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(467, 33072, 325, 5, 2, NULL, '2021-11-16', 8646, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(468, 33073, 326, 5, 2, NULL, '2021-11-16', 10643, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(469, 33074, 281, 5, 2, NULL, '2021-11-16', 2705, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(470, 33075, 328, 5, 2, NULL, '2021-11-16', 2042, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(471, 33076, 329, 5, 2, NULL, '2021-11-16', 3819, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(472, 33077, 330, 5, 2, NULL, '2021-11-16', 3491, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(473, 33078, 331, 5, 2, NULL, '2021-11-16', 5556, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(474, 33079, 332, 5, 2, NULL, '2021-11-16', 1176, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(475, 33080, 333, 5, 2, NULL, '2021-11-16', 4680, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(476, 33081, 334, 5, 2, NULL, '2021-11-16', 1688, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(477, 33082, 335, 5, 2, NULL, '2021-11-16', 4901, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(478, 33083, 336, 5, 2, NULL, '2021-11-16', 914, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(479, 33084, 337, 5, 2, NULL, '2021-11-16', 3884, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(480, 33085, 338, 5, 2, NULL, '2021-11-16', 3486, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(481, 33086, 339, 5, 2, NULL, '2021-11-16', 9000, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(482, 33087, 340, 5, 2, NULL, '2021-11-16', 10500, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(483, 33088, 341, 5, 2, NULL, '2021-11-16', 2907, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(484, 33090, 342, 5, 2, NULL, '2021-11-16', 5336, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(485, 33092, 343, 5, 2, NULL, '2021-11-16', 4825, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(486, 33094, 344, 5, 2, NULL, '2021-11-16', 5208, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(487, 33096, 345, 5, 2, NULL, '2021-11-16', 5500, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(488, 33098, 347, 5, 2, NULL, '2021-11-16', 8987, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(489, 33100, 348, 5, 2, NULL, '2021-11-16', 6285, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(490, 33102, 349, 5, 2, NULL, '2021-11-16', 5960, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(491, 33103, 350, 5, 2, NULL, '2021-11-16', 531, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(492, 33104, 351, 5, 2, NULL, '2021-11-16', 1160, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(493, 33105, 352, 5, 2, NULL, '2021-11-16', 4352, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(494, 33106, 353, 5, 2, NULL, '2021-11-16', 4700, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(495, 33107, 354, 5, 2, NULL, '2021-11-16', 4120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(496, 33108, 355, 5, 2, NULL, '2021-11-16', 4453, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(497, 33109, 356, 5, 2, NULL, '2021-11-16', 4184, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(498, 34002, 399, 5, 2, NULL, '2021-11-16', 11115, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(499, 34004, 395, 5, 2, NULL, '2021-11-16', -773, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(500, 34006, 401, 5, 2, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(501, 34007, 397, 5, 2, NULL, '2021-11-16', 7, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(502, 34009, 402, 5, 2, NULL, '2021-11-16', 22554, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(503, 35001, 230, 5, 2, NULL, '2021-11-16', 34, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(504, 35002, 236, 5, 2, NULL, '2021-11-16', 188, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(505, 35003, 233, 5, 2, NULL, '2021-11-16', 103, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(506, 35004, 229, 5, 2, NULL, '2021-11-16', 49, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(507, 35005, 232, 5, 2, NULL, '2021-11-16', 27, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(508, 35006, 228, 5, 2, NULL, '2021-11-16', 107, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(509, 35007, 235, 5, 2, NULL, '2021-11-16', 28, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(510, 35008, 234, 5, 2, NULL, '2021-11-16', 599, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(511, 35009, 231, 5, 2, NULL, '2021-11-16', 1491, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(512, 35011, 237, 5, 2, NULL, '2021-11-16', 288, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(513, 35012, 238, 5, 2, NULL, '2021-11-16', 202, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(514, 35013, 239, 5, 2, NULL, '2021-11-16', 6, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(515, 35014, 240, 5, 2, NULL, '2021-11-16', 9, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(516, 36000, 245, 5, 2, NULL, '2021-11-16', 542, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(517, 36001, 244, 5, 2, NULL, '2021-11-16', 1417, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(518, 36003, 248, 5, 2, NULL, '2021-11-16', 1803, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(519, 36004, 249, 5, 2, NULL, '2021-11-16', 838, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(520, 36005, 246, 5, 2, NULL, '2021-11-16', 343, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(521, 36006, 247, 5, 2, NULL, '2021-11-16', 903, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(522, 36007, 241, 5, 2, NULL, '2021-11-16', 473, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(523, 36008, 242, 5, 2, NULL, '2021-11-16', 720, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(524, 36009, 250, 5, 2, NULL, '2021-11-16', 1134, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(525, 36010, 251, 5, 2, NULL, '2021-11-16', 618, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(526, 36011, 252, 5, 2, NULL, '2021-11-16', 998, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(527, 36012, 253, 5, 2, NULL, '2021-11-16', 1065, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(528, 37000, 404, 5, 2, NULL, '2021-11-16', 4600, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(529, 37002, 410, 5, 2, NULL, '2021-11-16', 14525, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(530, 37003, 408, 5, 2, NULL, '2021-11-16', 40, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(531, 37004, 406, 5, 2, NULL, '2021-11-16', 9, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(532, 37007, 405, 5, 2, NULL, '2021-11-16', 50575, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(533, 37009, 411, 5, 2, NULL, '2021-11-16', 4600, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(534, 11028, 106, 5, 8, NULL, '2021-11-16', 156, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(535, 11029, 107, 5, 8, NULL, '2021-11-16', 768, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(536, 13001, 112, 5, 8, NULL, '2021-11-16', 468, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(537, 13002, 113, 5, 8, NULL, '2021-11-16', 36, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(538, 13003, 114, 5, 8, NULL, '2021-11-16', 371, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(539, 13004, 115, 5, 8, NULL, '2021-11-16', 600, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(540, 13005, 116, 5, 8, NULL, '2021-11-16', 55, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(541, 13006, 117, 5, 8, NULL, '2021-11-16', 68, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(542, 13007, 118, 5, 8, NULL, '2021-11-16', 216, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(543, 13008, 119, 5, 8, NULL, '2021-11-16', 60, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(544, 13009, 120, 5, 8, NULL, '2021-11-16', 1682, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(545, 13010, 121, 5, 8, NULL, '2021-11-16', 192, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(546, 13011, 122, 5, 8, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(547, 13012, 123, 5, 8, NULL, '2021-11-16', 264, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(548, 13013, 124, 5, 8, NULL, '2021-11-16', 609, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(549, 13014, 125, 5, 8, NULL, '2021-11-16', 132, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(550, 13015, 126, 5, 8, NULL, '2021-11-16', 1998, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(551, 13016, 127, 5, 8, NULL, '2021-11-16', 348, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(552, 13019, 129, 5, 8, NULL, '2021-11-16', 88, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(553, 13021, 131, 5, 8, NULL, '2021-11-16', -96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(554, 13026, 135, 5, 8, NULL, '2021-11-16', 518, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(555, 13027, 139, 5, 8, NULL, '2021-11-16', 96, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(556, 13029, 138, 5, 8, NULL, '2021-11-16', -1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(557, 13031, 140, 5, 8, NULL, '2021-11-16', 100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(558, 13032, 141, 5, 8, NULL, '2021-11-16', 1043, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(559, 13033, 144, 5, 8, NULL, '2021-11-16', 187, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(560, 13035, 146, 5, 8, NULL, '2021-11-16', 528, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(561, 13036, 149, 5, 8, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(562, 13041, 154, 5, 8, NULL, '2021-11-16', 156, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(563, 13048, 161, 5, 8, NULL, '2021-11-16', 100, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(564, 13051, 164, 5, 8, NULL, '2021-11-16', 33, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(565, 13052, 165, 5, 8, NULL, '2021-11-16', 924, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(566, 13053, 109, 5, 8, NULL, '2021-11-16', 645, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(567, 13059, 167, 5, 8, NULL, '2021-11-16', 180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(568, 13060, 168, 5, 8, NULL, '2021-11-16', 110, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(569, 13061, 169, 5, 8, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(570, 13062, 171, 5, 8, NULL, '2021-11-16', 168, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(571, 13063, 172, 5, 8, NULL, '2021-11-16', 864, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(572, 13064, 170, 5, 8, NULL, '2021-11-16', 144, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(573, 13065, 173, 5, 8, NULL, '2021-11-16', 567, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(574, 13067, 175, 5, 8, NULL, '2021-11-16', 564, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(575, 13068, 176, 5, 8, NULL, '2021-11-16', 160, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(576, 13069, 177, 5, 8, NULL, '2021-11-16', 28, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(577, 13073, 180, 5, 8, NULL, '2021-11-16', 219, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(578, 13075, 187, 5, 8, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(579, 13077, 183, 5, 8, NULL, '2021-11-16', 44, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(580, 13089, 197, 5, 8, NULL, '2021-11-16', 241, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(581, 13096, 204, 5, 8, NULL, '2021-11-16', 67, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(582, 13097, 205, 5, 8, NULL, '2021-11-16', 70, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(583, 13098, 206, 5, 8, NULL, '2021-11-16', 52, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(584, 11029, 107, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(585, 11030, 108, 5, 12, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(586, 12011, 95, 5, 12, NULL, '2021-11-16', 23, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(587, 13001, 112, 5, 12, NULL, '2021-11-16', 123, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(588, 13002, 113, 5, 12, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(589, 13003, 114, 5, 12, NULL, '2021-11-16', 346, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(590, 13004, 115, 5, 12, NULL, '2021-11-16', 179, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(591, 13005, 116, 5, 12, NULL, '2021-11-16', 31, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(592, 13006, 117, 5, 12, NULL, '2021-11-16', 30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(593, 13007, 118, 5, 12, NULL, '2021-11-16', 210, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(594, 13008, 119, 5, 12, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(595, 13009, 120, 5, 12, NULL, '2021-11-16', 551, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(596, 13011, 122, 5, 12, NULL, '2021-11-16', 98, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(597, 13012, 123, 5, 12, NULL, '2021-11-16', 31, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(598, 13013, 124, 5, 12, NULL, '2021-11-16', 25, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(599, 13014, 125, 5, 12, NULL, '2021-11-16', 127, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(600, 13015, 126, 5, 12, NULL, '2021-11-16', 93, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(601, 13016, 127, 5, 12, NULL, '2021-11-16', 117, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(602, 13018, 137, 5, 12, NULL, '2021-11-16', 42, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(603, 13019, 129, 5, 12, NULL, '2021-11-16', 53, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(604, 13020, 130, 5, 12, NULL, '2021-11-16', 7, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(605, 13021, 131, 5, 12, NULL, '2021-11-16', 27, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(606, 13023, 132, 5, 12, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(607, 13024, 133, 5, 12, NULL, '2021-11-16', 28, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(608, 13025, 134, 5, 12, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(609, 13026, 135, 5, 12, NULL, '2021-11-16', 37, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(610, 13027, 139, 5, 12, NULL, '2021-11-16', 172, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(611, 13028, 128, 5, 12, NULL, '2021-11-16', 26, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(612, 13029, 138, 5, 12, NULL, '2021-11-16', 38, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(613, 13030, 136, 5, 12, NULL, '2021-11-16', 58, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(614, 13031, 140, 5, 12, NULL, '2021-11-16', 16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(615, 13032, 141, 5, 12, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(616, 13033, 144, 5, 12, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(617, 13034, 145, 5, 12, NULL, '2021-11-16', 23, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(618, 13035, 146, 5, 12, NULL, '2021-11-16', 28, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(619, 13036, 149, 5, 12, NULL, '2021-11-16', 240, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(620, 13037, 150, 5, 12, NULL, '2021-11-16', 59, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(621, 13041, 154, 5, 12, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(622, 13042, 155, 5, 12, NULL, '2021-11-16', 11, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(623, 13046, 159, 5, 12, NULL, '2021-11-16', 160, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(624, 13047, 160, 5, 12, NULL, '2021-11-16', 11, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(625, 13048, 161, 5, 12, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(626, 13049, 162, 5, 12, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(627, 13050, 163, 5, 12, NULL, '2021-11-16', 16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(628, 13051, 164, 5, 12, NULL, '2021-11-16', 138, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(629, 13052, 165, 5, 12, NULL, '2021-11-16', 107, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(630, 13053, 109, 5, 12, NULL, '2021-11-16', 298, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(631, 13056, 147, 5, 12, NULL, '2021-11-16', 80, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(632, 13057, 166, 5, 12, NULL, '2021-11-16', 300, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(633, 13058, 142, 5, 12, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(634, 13059, 167, 5, 12, NULL, '2021-11-16', 333, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(635, 13060, 168, 5, 12, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(636, 13061, 169, 5, 12, NULL, '2021-11-16', 115, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(637, 13062, 171, 5, 12, NULL, '2021-11-16', 58, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(638, 13063, 172, 5, 12, NULL, '2021-11-16', 123, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(639, 13064, 170, 5, 12, NULL, '2021-11-16', 38, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(640, 13065, 173, 5, 12, NULL, '2021-11-16', 180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(641, 13067, 175, 5, 12, NULL, '2021-11-16', 87, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(642, 13069, 177, 5, 12, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(643, 13071, 179, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(644, 13075, 187, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(645, 13077, 183, 5, 12, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(646, 13078, 184, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(647, 13079, 185, 5, 12, NULL, '2021-11-16', 164, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(648, 13080, 188, 5, 12, NULL, '2021-11-16', 10, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(649, 13082, 190, 5, 12, NULL, '2021-11-16', 11, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(650, 13083, 191, 5, 12, NULL, '2021-11-16', 24, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(651, 13084, 192, 5, 12, NULL, '2021-11-16', 45, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(652, 13088, 196, 5, 12, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(653, 13089, 197, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(654, 13091, 199, 5, 12, NULL, '2021-11-16', 5, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(655, 13092, 200, 5, 12, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(656, 13093, 201, 5, 12, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(657, 13096, 204, 5, 12, NULL, '2021-11-16', 7, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(658, 13097, 205, 5, 12, NULL, '2021-11-16', 8, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(659, 13100, 208, 5, 12, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(660, 13101, 209, 5, 12, NULL, '2021-11-16', 3, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(661, 21048, 53, 5, 12, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(662, 12011, 95, 5, 16, NULL, '2021-11-16', 22, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(663, 12013, 97, 5, 16, NULL, '2021-11-16', 9, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(664, 12015, 99, 5, 16, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(665, 13014, 125, 5, 16, NULL, '2021-11-16', 4, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(666, 13051, 164, 5, 16, NULL, '2021-11-16', 2, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(667, 13073, 180, 5, 16, NULL, '2021-11-16', -30, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(668, 13089, 197, 5, 16, NULL, '2021-11-16', -1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(669, 13094, 202, 5, 16, NULL, '2021-11-16', -417, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(670, 12011, 95, 5, 13, NULL, '2021-11-16', 20, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(671, 12012, 96, 5, 13, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(672, 13007, 118, 5, 13, NULL, '2021-11-16', 108, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(673, 13008, 119, 5, 13, NULL, '2021-11-16', 191, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(674, 13009, 120, 5, 13, NULL, '2021-11-16', 1636, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(675, 13013, 124, 5, 13, NULL, '2021-11-16', 732, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(676, 13016, 127, 5, 13, NULL, '2021-11-16', 48, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(677, 13018, 137, 5, 13, NULL, '2021-11-16', 248, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(678, 13020, 130, 5, 13, NULL, '2021-11-16', 43, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(679, 13021, 131, 5, 13, NULL, '2021-11-16', 169, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(680, 13023, 132, 5, 13, NULL, '2021-11-16', 112, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(681, 13024, 133, 5, 13, NULL, '2021-11-16', 15, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(682, 13025, 134, 5, 13, NULL, '2021-11-16', 32, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(683, 13026, 135, 5, 13, NULL, '2021-11-16', 129, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(684, 13027, 139, 5, 13, NULL, '2021-11-16', 457, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(685, 13028, 128, 5, 13, NULL, '2021-11-16', 929, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(686, 13030, 136, 5, 13, NULL, '2021-11-16', 84, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(687, 13031, 140, 5, 13, NULL, '2021-11-16', 58, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(688, 13032, 141, 5, 13, NULL, '2021-11-16', 51, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(689, 13034, 145, 5, 13, NULL, '2021-11-16', 1, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(690, 13036, 149, 5, 13, NULL, '2021-11-16', 18, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(691, 13037, 150, 5, 13, NULL, '2021-11-16', 12, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(692, 13042, 155, 5, 13, NULL, '2021-11-16', 98, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(693, 13048, 161, 5, 13, NULL, '2021-11-16', 240, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(694, 13051, 164, 5, 13, NULL, '2021-11-16', 16, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(695, 13053, 109, 5, 13, NULL, '2021-11-16', 318, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(696, 13057, 166, 5, 13, NULL, '2021-11-16', 2292, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(697, 13063, 172, 5, 13, NULL, '2021-11-16', 120, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(698, 13065, 173, 5, 13, NULL, '2021-11-16', 48, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(699, 13069, 177, 5, 13, NULL, '2021-11-16', 68, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(700, 13071, 179, 5, 13, NULL, '2021-11-16', 216, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(701, 13079, 185, 5, 13, NULL, '2021-11-16', 180, NULL, NULL, 'in', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(704, 37010, 143, 2, 15, NULL, '2021-11-13', 150, 2, NULL, 'out', 1, NULL, 'INV-37010', NULL, NULL, '2021-12-07 10:34:38', 1, NULL, NULL),
(705, 37011, 143, 2, 15, NULL, '2021-11-13', 150, 3, NULL, 'out', 1, NULL, 'INV-37011', '2021-12-07 10:34:38', 1, '2021-12-16 10:41:39', 21, NULL, NULL),
(706, 37012, 143, 2, 15, NULL, '2021-11-13', 150, 1, NULL, 'out', 1, NULL, 'INV-37012', '2021-12-16 10:41:39', 21, '2021-12-22 08:12:02', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_units`
--

CREATE TABLE `item_units` (
  `id` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
(31, NULL, 'قطعة', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `background` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `from_scratch` tinyint(1) DEFAULT NULL,
  `background_color` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sorting` int DEFAULT NULL,
  `active` tinyint DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `languages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `title_en` varchar(200) DEFAULT NULL,
  `title_ar` varchar(200) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `cms_moduls_id` int DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `order_item` int DEFAULT NULL,
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` int NOT NULL,
  `code` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `phone_number` varchar(1000) DEFAULT NULL,
  `account_id` int DEFAULT NULL,
  `person_type_id` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `delegate_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `code`, `name_en`, `name_ar`, `email`, `phone_number`, `account_id`, `person_type_id`, `active`, `sorting`, `delegate_id`) VALUES
(1, 120101, NULL, 'توفيق المصري - حماه - قديم', NULL, NULL, 39, 1, 1, NULL, NULL),
(2, 120102, NULL, 'دحام الكيصوم', NULL, NULL, 40, 1, 1, NULL, NULL),
(3, 120103, NULL, 'باسم الكور', NULL, NULL, 41, 1, 1, NULL, NULL),
(4, 120104, NULL, 'خالد عمران', NULL, NULL, 42, 1, 1, NULL, NULL),
(5, 120105, NULL, 'صلاح عياش', NULL, NULL, 43, 1, 1, NULL, NULL),
(6, 120106, NULL, 'محمود مجركش', NULL, NULL, 44, 1, 1, NULL, NULL),
(7, 120107, NULL, 'حمادي حمادي', NULL, NULL, 45, 1, 1, NULL, NULL),
(8, 120108, NULL, 'علي عبد الله', NULL, NULL, 46, 1, 1, NULL, NULL),
(9, 120109, NULL, 'علي حيدر', NULL, NULL, 47, 1, 1, NULL, NULL),
(10, 120110, NULL, 'عبد الرحمن ديكو', NULL, NULL, 48, 1, 1, NULL, NULL),
(11, 120111, NULL, 'خالد الساكت', NULL, NULL, 49, 1, 1, NULL, NULL),
(12, 120112, NULL, 'خالد زرقان', NULL, NULL, 50, 1, 1, NULL, NULL),
(13, 120113, NULL, 'اغيد سحلول', NULL, NULL, 51, 1, 1, NULL, NULL),
(14, 120114, NULL, 'حسن عبود', NULL, NULL, 52, 1, 1, NULL, NULL),
(15, 120115, NULL, 'البعلبكي للزراعة', NULL, NULL, 53, 1, 1, NULL, NULL),
(16, 120116, NULL, 'شركة جهاد الشامي', NULL, NULL, 54, 1, 1, NULL, NULL),
(17, 120117, NULL, 'الشركة الوطنية للتطوير الزراعي', NULL, NULL, 55, 1, 1, NULL, NULL),
(18, 120118, NULL, 'خليل خطاب', NULL, NULL, 56, 1, 1, NULL, NULL),
(19, 120119, NULL, 'صلاح حلواني', NULL, NULL, 57, 1, 1, NULL, NULL),
(20, 120120, NULL, 'جودت العسكري', NULL, NULL, 58, 1, 1, NULL, NULL),
(21, 120121, NULL, 'علي الكيلاني', NULL, NULL, 59, 1, 1, NULL, NULL),
(22, 120122, NULL, 'عدنان عرسان', NULL, NULL, 60, 1, 1, NULL, NULL),
(23, 120123, NULL, 'بشار الطباع', NULL, NULL, 61, 1, 1, NULL, NULL),
(24, 120124, NULL, 'عمار مجركش', NULL, NULL, 62, 1, 1, NULL, NULL),
(25, 120125, NULL, 'حسن السيد', NULL, NULL, 63, 1, 1, NULL, NULL),
(26, 120126, NULL, 'ناصر الطوالبة - نوى', NULL, NULL, 64, 1, 1, NULL, NULL),
(27, 120127, NULL, 'توفيق المصري - حماه - جديد', NULL, NULL, 65, 1, 1, NULL, NULL),
(28, 120128, NULL, 'توفيق المصري / سولفيرتو - حماه - جديد', NULL, NULL, 66, 1, 1, NULL, NULL),
(29, 120129, NULL, 'باسم الأحمد', NULL, NULL, 67, 1, 1, NULL, NULL),
(30, 120130, NULL, 'حسن السيد ل.س', NULL, NULL, 68, 1, 1, NULL, NULL),
(31, 120131, NULL, 'محمود الحمران', NULL, NULL, 69, 1, 1, NULL, NULL),
(32, 120132, NULL, 'اتحاد غرف الزراعة', NULL, NULL, 70, 1, 1, NULL, NULL),
(33, 120133, NULL, 'علي نصر الله - جديد-', NULL, NULL, 71, 1, 1, NULL, NULL),
(34, 120134, NULL, 'امجد قويدر', NULL, NULL, 72, 1, 1, NULL, NULL),
(35, 120135, NULL, 'عرفان زيادة', NULL, NULL, 73, 1, 1, NULL, NULL),
(36, 120136, NULL, 'احمد خلوف', NULL, NULL, 74, 1, 1, NULL, NULL),
(37, 120137, NULL, 'عدنان الملك', NULL, NULL, 75, 1, 1, NULL, NULL),
(38, 120138, NULL, 'خليل خطاب - جديد -', NULL, NULL, 76, 1, 1, NULL, NULL),
(39, 120139, NULL, 'حسين العلاوي - قديم', NULL, NULL, 77, 1, 1, NULL, NULL),
(40, 120140, NULL, 'العامرة المنطقة الشرقية - بودرة', NULL, NULL, 78, 1, 1, NULL, NULL),
(41, 120141, NULL, 'فريد الصلخدي', NULL, NULL, 79, 1, 1, NULL, NULL),
(42, 120142, NULL, 'العامرة المنطقة الشرقية - جل', NULL, NULL, 80, 1, 1, NULL, NULL),
(43, 120143, NULL, 'العامرة المنطقة الشرقية - بذور', NULL, NULL, 81, 1, 1, NULL, NULL),
(44, 120144, NULL, 'العامرة المنطقة الشرقية - متفرقات', NULL, NULL, 82, 1, 1, NULL, NULL),
(45, 120145, NULL, 'شادي متوج', NULL, NULL, 83, 1, 1, NULL, NULL),
(46, 120146, NULL, 'سيتان الجندي', NULL, NULL, 84, 1, 1, NULL, NULL),
(47, 120147, NULL, 'صالح الشبلي', NULL, NULL, 85, 1, 1, NULL, NULL),
(48, 120148, NULL, 'موسى الجرخ', NULL, NULL, 86, 1, 1, NULL, NULL),
(49, 120149, NULL, 'محمد الشاويش - معدان الكمية - حلب', NULL, NULL, 87, 1, 1, NULL, NULL),
(50, 120150, NULL, 'قاسم وفا - ضمير - قديم', NULL, NULL, 88, 1, 1, NULL, NULL),
(51, 120301, NULL, 'ابراهيم البردان', NULL, NULL, 89, 1, 1, NULL, 3),
(52, 120302, NULL, 'ابراهيم قهوجي - درعا - قديم', NULL, NULL, 90, 1, 1, NULL, 3),
(53, 120303, NULL, 'ابو معروف رجب', NULL, NULL, 91, 1, 1, NULL, 3),
(54, 120304, NULL, 'احمد السعدي ', NULL, NULL, 92, 1, 1, NULL, 3),
(55, 120305, NULL, 'احمد العيشات', NULL, NULL, 93, 1, 1, NULL, 3),
(56, 120306, NULL, 'احمد حاج علي - جديد', NULL, NULL, 94, 1, 1, NULL, 3),
(57, 120307, NULL, 'احمد حوراني - جديد', NULL, NULL, 95, 1, 1, NULL, 3),
(58, 120308, NULL, 'احمد عبد الرزاق الزعبي', NULL, NULL, 96, 1, 1, NULL, 3),
(59, 120309, NULL, 'احمد كامل الزعبي - حديد', NULL, NULL, 97, 1, 1, NULL, 3),
(60, 120310, NULL, 'اياد عساوده', NULL, NULL, 98, 1, 1, NULL, 3),
(61, 120311, NULL, 'اياد نابلسي - قديم', NULL, NULL, 99, 1, 1, NULL, 3),
(62, 120312, NULL, 'بسام برمو', NULL, NULL, 100, 1, 1, NULL, 3),
(63, 120313, NULL, 'بلال مبارك - جاسم', NULL, NULL, 101, 1, 1, NULL, 3),
(64, 120314, NULL, 'جمال نابلسي -قديم-', NULL, NULL, 102, 1, 1, NULL, 3),
(65, 120315, NULL, 'حسام خريبة - جديد', NULL, NULL, 103, 1, 1, NULL, 3),
(66, 120316, NULL, 'حسان العاسمي', NULL, NULL, 104, 1, 1, NULL, 3),
(67, 120317, NULL, 'حمدان الحسن - درعا - قديم', NULL, NULL, 105, 1, 1, NULL, 3),
(68, 120318, NULL, 'خليل البردان - درعا - قديم', NULL, NULL, 106, 1, 1, NULL, 3),
(69, 120319, NULL, 'راني كيوان - قديم', NULL, NULL, 107, 1, 1, NULL, 3),
(70, 120320, NULL, 'رياض ربداوي - جديد', NULL, NULL, 108, 1, 1, NULL, 3),
(71, 120321, NULL, 'سالم النجار - جديد', NULL, NULL, 109, 1, 1, NULL, 3),
(72, 120322, NULL, 'سامح حرندين', NULL, NULL, 110, 1, 1, NULL, 3),
(73, 120323, NULL, 'سفيان نصيرات - جديد', NULL, NULL, 111, 1, 1, NULL, 3),
(74, 120324, NULL, 'صهيب الربداوي', NULL, NULL, 112, 1, 1, NULL, 3),
(75, 120325, NULL, 'طلحة ابو سعيفان - جديد', NULL, NULL, 113, 1, 1, NULL, 3),
(76, 120326, NULL, 'عبد الله غزالي - جديد', NULL, NULL, 114, 1, 1, NULL, 3),
(77, 120327, NULL, 'عبد الناصر الخبي', NULL, NULL, 115, 1, 1, NULL, 3),
(78, 120328, NULL, 'عبد الناصر كيوان', NULL, NULL, 116, 1, 1, NULL, 3),
(79, 120329, NULL, 'علي البردان - جديد', NULL, NULL, 117, 1, 1, NULL, 3),
(80, 120330, NULL, 'علي الشرف -نصيب-', NULL, NULL, 118, 1, 1, NULL, 3),
(81, 120331, NULL, 'عماد الشريف', NULL, NULL, 119, 1, 1, NULL, 3),
(82, 120332, NULL, 'عمر جباوي', NULL, NULL, 120, 1, 1, NULL, 3),
(83, 120333, NULL, 'فادي الزعبي - جديد', NULL, NULL, 121, 1, 1, NULL, 3),
(84, 120334, NULL, 'فايز ابو نعيم - جديد', NULL, NULL, 122, 1, 1, NULL, 3),
(85, 120335, NULL, 'قاسم ابو شنب - قديم', NULL, NULL, 123, 1, 1, NULL, 3),
(86, 120336, NULL, 'قاسم أبو حوران', NULL, NULL, 124, 1, 1, NULL, 3),
(87, 120337, NULL, 'قاسم مفعلاني - قديم - درعا', NULL, NULL, 125, 1, 1, NULL, 3),
(88, 120338, NULL, 'قصي النعسان', NULL, NULL, 126, 1, 1, NULL, 3),
(89, 120339, NULL, 'كمال الزعبي - قديم', NULL, NULL, 127, 1, 1, NULL, 3),
(90, 120340, NULL, 'كمال فالح الزعبي - جديد', NULL, NULL, 128, 1, 1, NULL, 3),
(91, 120341, NULL, 'م . عمران السموري', NULL, NULL, 129, 1, 1, NULL, 3),
(92, 120342, NULL, 'م. محمد نور برمو', NULL, NULL, 130, 1, 1, NULL, 3),
(93, 120343, NULL, 'م.محمد النوفل', NULL, NULL, 131, 1, 1, NULL, 3),
(94, 120344, NULL, 'مجيد النوفل - درعا', NULL, NULL, 132, 1, 1, NULL, 3),
(95, 120345, NULL, 'محمد الزعبي - جديد', NULL, NULL, 133, 1, 1, NULL, 3),
(96, 120346, NULL, 'محمد الصفوري - جديد', NULL, NULL, 134, 1, 1, NULL, 3),
(97, 120347, NULL, 'محمد جباوي', NULL, NULL, 135, 1, 1, NULL, 3),
(98, 120348, NULL, 'محمد خريبة - جديد', NULL, NULL, 136, 1, 1, NULL, 3),
(99, 120349, NULL, 'محمد قهوجي', NULL, NULL, 137, 1, 1, NULL, 3),
(100, 120350, NULL, 'محمد كامل الزعبي -قديم', NULL, NULL, 138, 1, 1, NULL, 3),
(101, 120351, NULL, 'محمد كيوان', NULL, NULL, 139, 1, 1, NULL, 3),
(102, 120352, NULL, 'محمود ابو نقطة - جديد', NULL, NULL, 140, 1, 1, NULL, 3),
(103, 120353, NULL, 'محمود الناطور', NULL, NULL, 141, 1, 1, NULL, 3),
(104, 120354, NULL, 'محمود سليمان - درعا', NULL, NULL, 142, 1, 1, NULL, 3),
(105, 120355, NULL, 'محمود كامل الزعبي', NULL, NULL, 143, 1, 1, NULL, 3),
(106, 120356, NULL, 'مصعب الزعبي -قديم -', NULL, NULL, 144, 1, 1, NULL, 3),
(107, 120357, NULL, 'معاذ برمو - جديد', NULL, NULL, 145, 1, 1, NULL, 3),
(108, 120358, NULL, 'معاذ كيوان', NULL, NULL, 146, 1, 1, NULL, 3),
(109, 120359, NULL, 'موسى البيطاري - جديد', NULL, NULL, 147, 1, 1, NULL, 3),
(110, 120360, NULL, 'ناصر محمد النابلسي', NULL, NULL, 148, 1, 1, NULL, 3),
(111, 120361, NULL, 'نبيل عيشات - جديد', NULL, NULL, 149, 1, 1, NULL, 3),
(112, 120362, NULL, 'نسيم ربداوي', NULL, NULL, 150, 1, 1, NULL, 3),
(113, 120363, NULL, 'هايل العوض', NULL, NULL, 151, 1, 1, NULL, 3),
(114, 120364, NULL, 'هشام نابلسي', NULL, NULL, 152, 1, 1, NULL, 3),
(115, 120365, NULL, 'وسيم العاسمي', NULL, NULL, 153, 1, 1, NULL, 3),
(116, 120366, NULL, 'وسيم حريذين', NULL, NULL, 154, 1, 1, NULL, 3),
(117, 120367, NULL, 'ياسر ابو خروب', NULL, NULL, 155, 1, 1, NULL, 3),
(118, 120368, NULL, 'ياسين الصبح', NULL, NULL, 156, 1, 1, NULL, 3),
(119, 120501, NULL, 'اَلان بشارة', NULL, NULL, 157, 1, 1, NULL, 20),
(120, 120502, NULL, 'ابراهيم حسن', NULL, NULL, 158, 1, 1, NULL, 20),
(121, 120503, NULL, 'ابراهيم شاهين قديم', NULL, NULL, 159, 1, 1, NULL, 20),
(122, 120504, NULL, 'احمد اسماعيل - قديم', NULL, NULL, 160, 1, 1, NULL, 20),
(123, 120505, NULL, 'احمد حيدر - جبلة - جديد', NULL, NULL, 161, 1, 1, NULL, 20),
(124, 120506, NULL, 'احمد خضر - جديد', NULL, NULL, 162, 1, 1, NULL, 20),
(125, 120507, NULL, 'احمد صبحي -جديد-', NULL, NULL, 163, 1, 1, NULL, 20),
(126, 120508, NULL, 'احمد عبيد -جديد-', NULL, NULL, 164, 1, 1, NULL, 20),
(127, 120509, NULL, 'احمد غنوم - بانياس', NULL, NULL, 165, 1, 1, NULL, 20),
(128, 120510, NULL, 'اسامة اسماعيل - بانياس - جديد', NULL, NULL, 166, 1, 1, NULL, 20),
(129, 120511, NULL, 'اكرم عابده -قديم', NULL, NULL, 167, 1, 1, NULL, 20),
(130, 120512, NULL, 'المهندس احمد امين - جديد', NULL, NULL, 168, 1, 1, NULL, 20),
(131, 120513, NULL, 'المهندس خضر احمد', NULL, NULL, 169, 1, 1, NULL, 20),
(132, 120514, NULL, 'المهندس رامز حسن - جديد', NULL, NULL, 170, 1, 1, NULL, 20),
(133, 120515, NULL, 'المهندس سليمان ناصر- قديم', NULL, NULL, 171, 1, 1, NULL, 20),
(134, 120516, NULL, 'المهندس عصام ديب - جديد', NULL, NULL, 172, 1, 1, NULL, 20),
(135, 120517, NULL, 'المهندس علي ابراهيم - جديد', NULL, NULL, 173, 1, 1, NULL, 20),
(136, 120518, NULL, 'المهندس علي عباس - قديم', NULL, NULL, 174, 1, 1, NULL, 20),
(137, 120519, NULL, 'المهندس علي محمد - جديد', NULL, NULL, 175, 1, 1, NULL, 20),
(138, 120520, NULL, 'المهندس مازن برو - جديد', NULL, NULL, 176, 1, 1, NULL, 20),
(139, 120521, NULL, 'المهندس ماهر حمد', NULL, NULL, 177, 1, 1, NULL, 20),
(140, 120522, NULL, 'المهندس نور الدين علي - جديد', NULL, NULL, 178, 1, 1, NULL, 20),
(141, 120523, NULL, 'المهندس وسام جبور - جديد', NULL, NULL, 179, 1, 1, NULL, 20),
(142, 120524, NULL, 'ايهاب مهنا - جديد', NULL, NULL, 180, 1, 1, NULL, 20),
(143, 120525, NULL, 'جمال دراج', NULL, NULL, 181, 1, 1, NULL, 20),
(144, 120526, NULL, 'جهاد صعبية - جبلة', NULL, NULL, 182, 1, 1, NULL, 20),
(145, 120527, NULL, 'حسام يا شوطي', NULL, NULL, 183, 1, 1, NULL, 20),
(146, 120528, NULL, 'حيدر خليل - اللاذقية', NULL, NULL, 184, 1, 1, NULL, 20),
(147, 120529, NULL, 'خليل خليل - جبلة', NULL, NULL, 185, 1, 1, NULL, 20),
(148, 120530, NULL, 'خيرات قدور-جديد-', NULL, NULL, 186, 1, 1, NULL, 20),
(149, 120531, NULL, 'د. احمد الصالح - جديد', NULL, NULL, 187, 1, 1, NULL, 20),
(150, 120532, NULL, 'د. حيدر شاهين - جديد', NULL, NULL, 188, 1, 1, NULL, 20),
(151, 120533, NULL, 'رامي الشغري - بانياس', NULL, NULL, 189, 1, 1, NULL, 20),
(152, 120534, NULL, 'رجب العلي - طرطوس- جديد', NULL, NULL, 190, 1, 1, NULL, 20),
(153, 120535, NULL, 'رفعت محفوض', NULL, NULL, 191, 1, 1, NULL, 20),
(154, 120536, NULL, 'رفعت محفوض -جديد', NULL, NULL, 192, 1, 1, NULL, 20),
(155, 120537, NULL, 'زياد سعد - جبلة', NULL, NULL, 193, 1, 1, NULL, 20),
(156, 120538, NULL, 'سامر احمد', NULL, NULL, 194, 1, 1, NULL, 20),
(157, 120539, NULL, 'سامر عبد الكريم - حريصون', NULL, NULL, 195, 1, 1, NULL, 20),
(158, 120540, NULL, 'سامر علوش', NULL, NULL, 196, 1, 1, NULL, 20),
(159, 120541, NULL, 'سليمان ناصر جديد', NULL, NULL, 197, 1, 1, NULL, 20),
(160, 120542, NULL, 'سيمون يعقوب -جديد-', NULL, NULL, 198, 1, 1, NULL, 20),
(161, 120543, NULL, 'شادي رسلان - بانياس', NULL, NULL, 199, 1, 1, NULL, 20),
(162, 120544, NULL, 'شعبان عيسى -قديم', NULL, NULL, 200, 1, 1, NULL, 20),
(163, 120545, NULL, 'عبد الكريم (أجمية ) - طرطوس - جديد', NULL, NULL, 201, 1, 1, NULL, 20),
(164, 120546, NULL, 'عبد الكريم غانم', NULL, NULL, 202, 1, 1, NULL, 20),
(165, 120547, NULL, 'علاء ونوس', NULL, NULL, 203, 1, 1, NULL, 20),
(166, 120548, NULL, 'علي منصور - الخراب', NULL, NULL, 204, 1, 1, NULL, 20),
(167, 120549, NULL, 'عيسى عيسى - حريصون - جديد', NULL, NULL, 205, 1, 1, NULL, 20),
(168, 120550, NULL, 'عيسى عيسى طرطوس جديد', NULL, NULL, 206, 1, 1, NULL, 20),
(169, 120551, NULL, 'غاندي داغر - البلاطة غربية', NULL, NULL, 207, 1, 1, NULL, 20),
(170, 120552, NULL, 'غاندي شاهين', NULL, NULL, 208, 1, 1, NULL, 20),
(171, 120553, NULL, 'فادي بجود', NULL, NULL, 209, 1, 1, NULL, 20),
(172, 120554, NULL, 'فراس حسين - الخراب - جديد', NULL, NULL, 210, 1, 1, NULL, 20),
(173, 120555, NULL, 'فراس حسين - الخراب - قديم', NULL, NULL, 211, 1, 1, NULL, 20),
(174, 120556, NULL, 'فراس حسين - طرطوس - جديد', NULL, NULL, 212, 1, 1, NULL, 20),
(175, 120557, NULL, 'فؤاد عيسى - جبلة - جديد', NULL, NULL, 213, 1, 1, NULL, 20),
(176, 120558, NULL, 'قتيبة درويش - جديد', NULL, NULL, 214, 1, 1, NULL, 20),
(177, 120559, NULL, 'كامل فوس - طرطوس - قديم', NULL, NULL, 215, 1, 1, NULL, 20),
(178, 120560, NULL, 'كرم نجار - طرطوس - جديد', NULL, NULL, 216, 1, 1, NULL, 20),
(179, 120561, NULL, 'لؤي حسين- طرطوس', NULL, NULL, 217, 1, 1, NULL, 20),
(180, 120562, NULL, 'م. عبد المنعم عباس - قديم', NULL, NULL, 218, 1, 1, NULL, 20),
(181, 120563, NULL, 'م. غسان حسن $', NULL, NULL, 219, 1, 1, NULL, 20),
(182, 120564, NULL, 'ماجد الحسين-قديم -', NULL, NULL, 220, 1, 1, NULL, 20),
(183, 120565, NULL, 'ماهر حمد قديم', NULL, NULL, 221, 1, 1, NULL, 20),
(184, 120566, NULL, 'محسن ترسيسي - جديد', NULL, NULL, 222, 1, 1, NULL, 20),
(185, 120567, NULL, 'محمد خليل - البيضة - مشتل البركة', NULL, NULL, 223, 1, 1, NULL, 20),
(186, 120568, NULL, 'محمد خليل - بانياس - جديد', NULL, NULL, 224, 1, 1, NULL, 20),
(187, 120569, NULL, 'محمد خير رسول - النبك', NULL, NULL, 225, 1, 1, NULL, 20),
(188, 120570, NULL, 'محمد صهيوني - طرطوس - قديم', NULL, NULL, 226, 1, 1, NULL, 20),
(189, 120571, NULL, 'محمد عبدو طجمية', NULL, NULL, 227, 1, 1, NULL, 20),
(190, 120572, NULL, 'محمد علي -قديم-', NULL, NULL, 228, 1, 1, NULL, 20),
(191, 120573, NULL, 'محمد قزيمة -جديد-', NULL, NULL, 229, 1, 1, NULL, 20),
(192, 120574, NULL, 'محمود الشيخ جديد', NULL, NULL, 230, 1, 1, NULL, 20),
(193, 120575, NULL, 'محمود الشيخ طرطوس', NULL, NULL, 231, 1, 1, NULL, 20),
(194, 120576, NULL, 'مروان حمود', NULL, NULL, 232, 1, 1, NULL, 20),
(195, 120577, NULL, 'معن دياب -قديم-', NULL, NULL, 233, 1, 1, NULL, 20),
(196, 120578, NULL, 'منصور اسماعيل - جديد', NULL, NULL, 234, 1, 1, NULL, 20),
(197, 120579, NULL, 'موسى فارس - الخراب', NULL, NULL, 235, 1, 1, NULL, 20),
(198, 120580, NULL, 'نادر ديوب - بانياس - جديد', NULL, NULL, 236, 1, 1, NULL, 20),
(199, 120581, NULL, 'نبيل قزيمة - جديد', NULL, NULL, 237, 1, 1, NULL, 20),
(200, 120582, NULL, 'نزار حسين - الخراب', NULL, NULL, 238, 1, 1, NULL, 20),
(201, 120583, NULL, 'نضال ديب', NULL, NULL, 239, 1, 1, NULL, 20),
(202, 120584, NULL, 'هاني شاهين - طرطوس', NULL, NULL, 240, 1, 1, NULL, 20),
(203, 120585, NULL, 'وسيم درميني', NULL, NULL, 241, 1, 1, NULL, 20),
(204, 120586, NULL, 'وسيم عيسى -جديد-', NULL, NULL, 242, 1, 1, NULL, 20),
(205, 120587, NULL, 'ياسر وحود - بانياس', NULL, NULL, 243, 1, 1, NULL, 20),
(206, 120588, NULL, 'يوسف الموعي', NULL, NULL, 244, 1, 1, NULL, 20),
(207, 120589, NULL, 'يوسف عفيف - جبلة - جديد', NULL, NULL, 245, 1, 1, NULL, 20),
(208, 1207001, NULL, 'ابراهيم الدايخ - محردة - جديد', NULL, NULL, 246, 1, 1, NULL, 5),
(209, 1207002, NULL, 'ابراهيم الضامن -جديد', NULL, NULL, 247, 1, 1, NULL, 5),
(210, 1207003, NULL, 'ابراهيم خضر', NULL, NULL, 248, 1, 1, NULL, 5),
(211, 1207004, NULL, 'ابراهيم نجار - محردة', NULL, NULL, 249, 1, 1, NULL, 5),
(212, 1207005, NULL, 'ابراهيم وسيل', NULL, NULL, 250, 1, 1, NULL, 5),
(213, 1207006, NULL, 'ابراهيم ونوس - قلعة جراس - قديم', NULL, NULL, 251, 1, 1, NULL, 5),
(214, 1207007, NULL, 'احمد اسبر - جديد', NULL, NULL, 252, 1, 1, NULL, 5),
(215, 1207008, NULL, 'احمد العتمان - حلفايا', NULL, NULL, 253, 1, 1, NULL, 5),
(216, 1207009, NULL, 'احمد سلطان الابراهيم', NULL, NULL, 254, 1, 1, NULL, 5),
(217, 1207010, NULL, 'احمد عثمان', NULL, NULL, 255, 1, 1, NULL, 5),
(218, 1207011, NULL, 'ادريس ادريس - مصياف', NULL, NULL, 256, 1, 1, NULL, 5),
(219, 1207012, NULL, 'اديب سعيد - السقيلبية', NULL, NULL, 257, 1, 1, NULL, 5),
(220, 1207013, NULL, 'اديب عليشة جديد', NULL, NULL, 258, 1, 1, NULL, 5),
(221, 1207014, NULL, 'اسامة خير بيك - الصقيلبية', NULL, NULL, 259, 1, 1, NULL, 5),
(222, 1207015, NULL, 'اسامة غريب', NULL, NULL, 260, 1, 1, NULL, 5),
(223, 1207016, NULL, 'اسكندر علي', NULL, NULL, 261, 1, 1, NULL, 5),
(224, 1207017, NULL, 'اصف عبد الناصر - المحروسة', NULL, NULL, 262, 1, 1, NULL, 5),
(225, 1207018, NULL, 'اكرم الخليف', NULL, NULL, 263, 1, 1, NULL, 5),
(226, 1207019, NULL, 'اكرم الملحم قديم', NULL, NULL, 264, 1, 1, NULL, 5),
(227, 1207020, NULL, 'الياس الياس', NULL, NULL, 265, 1, 1, NULL, 5),
(228, 1207021, NULL, 'امير عيسى - عين الكروم - قديم', NULL, NULL, 266, 1, 1, NULL, 5),
(229, 1207022, NULL, 'امين اسماعيل - نهر البارد - جديد', NULL, NULL, 267, 1, 1, NULL, 5),
(230, 1207023, NULL, 'انس سوتل', NULL, NULL, 268, 1, 1, NULL, 5),
(231, 1207024, NULL, 'باسل محمد - الصارمية', NULL, NULL, 269, 1, 1, NULL, 5),
(232, 1207025, NULL, 'بسام اليوسف - تيزين', NULL, NULL, 270, 1, 1, NULL, 5),
(233, 1207026, NULL, 'بسيم البودي', NULL, NULL, 271, 1, 1, NULL, 5),
(234, 1207027, NULL, 'بهيج النونو', NULL, NULL, 272, 1, 1, NULL, 5),
(235, 1207028, NULL, 'جرجس نصار - كفربو', NULL, NULL, 273, 1, 1, NULL, 5),
(236, 1207029, NULL, 'جمال المرعي', NULL, NULL, 274, 1, 1, NULL, 5),
(237, 1207030, NULL, 'جهاد الحمود', NULL, NULL, 275, 1, 1, NULL, 5),
(238, 1207031, NULL, 'حسام معلا - سلحب', NULL, NULL, 276, 1, 1, NULL, 5),
(239, 1207032, NULL, 'حسن المحمود - المحروسة', NULL, NULL, 277, 1, 1, NULL, 5),
(240, 1207033, NULL, 'حسين القليح', NULL, NULL, 278, 1, 1, NULL, 5),
(241, 1207034, NULL, 'خالد المصطفى', NULL, NULL, 279, 1, 1, NULL, 5),
(242, 1207035, NULL, 'خطاب القاسم - محردة', NULL, NULL, 280, 1, 1, NULL, 5),
(243, 1207036, NULL, 'خليل ضاهر - محردة', NULL, NULL, 281, 1, 1, NULL, 5),
(244, 1207037, NULL, 'رامز حمادة - المحروسة', NULL, NULL, 282, 1, 1, NULL, 5),
(245, 1207038, NULL, 'ربيع سليمان - الربيعة', NULL, NULL, 283, 1, 1, NULL, 5),
(246, 1207039, NULL, 'رضوان الرضوان - قديم', NULL, NULL, 284, 1, 1, NULL, 5),
(247, 1207040, NULL, 'رياض المحمود', NULL, NULL, 285, 1, 1, NULL, 5),
(248, 1207041, NULL, 'زكريا الاحمد', NULL, NULL, 286, 1, 1, NULL, 5),
(249, 1207042, NULL, 'زياد زرزور - محردة', NULL, NULL, 287, 1, 1, NULL, 5),
(250, 1207043, NULL, 'زياد عابده - خطاب - قديم', NULL, NULL, 288, 1, 1, NULL, 5),
(251, 1207044, NULL, 'سامر يعقوب - محردة', NULL, NULL, 289, 1, 1, NULL, 5),
(252, 1207045, NULL, 'سعد سعد', NULL, NULL, 290, 1, 1, NULL, 5),
(253, 1207046, NULL, 'سعود صوان - البياضية', NULL, NULL, 291, 1, 1, NULL, 5),
(254, 1207047, NULL, 'سلطان عيسى', NULL, NULL, 292, 1, 1, NULL, 5),
(255, 1207048, NULL, 'سليم عاصي', NULL, NULL, 293, 1, 1, NULL, 5),
(256, 1207049, NULL, 'سليمان المحمود - المحروسة', NULL, NULL, 294, 1, 1, NULL, 5),
(257, 1207050, NULL, 'سليمان المحمود -قديم', NULL, NULL, 295, 1, 1, NULL, 5),
(258, 1207051, NULL, 'سمير الجداوي - سلحب', NULL, NULL, 296, 1, 1, NULL, 5),
(259, 1207052, NULL, 'شادي حمود - الربيعة', NULL, NULL, 297, 1, 1, NULL, 5),
(260, 1207053, NULL, 'ضرار المحمود / عماد النعسان - السقيلبية', NULL, NULL, 298, 1, 1, NULL, 5),
(261, 1207054, NULL, 'طلال ابراهيم - كفربو - جديد', NULL, NULL, 299, 1, 1, NULL, 5),
(262, 1207055, NULL, 'عامر المصطفى - كرناز', NULL, NULL, 300, 1, 1, NULL, 5),
(263, 1207056, NULL, 'عبد الرحمن الشقيع', NULL, NULL, 301, 1, 1, NULL, 5),
(264, 1207057, NULL, 'عبد العزيز المحمد - جركيس', NULL, NULL, 302, 1, 1, NULL, 5),
(265, 1207058, NULL, 'عبد الكريم كرنازي - شيزر', NULL, NULL, 303, 1, 1, NULL, 5),
(266, 1207059, NULL, 'عبد الله الطالب', NULL, NULL, 304, 1, 1, NULL, 5),
(267, 1207060, NULL, 'عبد الله خباص', NULL, NULL, 305, 1, 1, NULL, 5),
(268, 1207061, NULL, 'عبد الله سوقية - صفصافية', NULL, NULL, 306, 1, 1, NULL, 5),
(269, 1207062, NULL, 'عبد المعطي الحسين', NULL, NULL, 307, 1, 1, NULL, 5),
(270, 1207063, NULL, 'عبد المعين غزال - خطاب', NULL, NULL, 308, 1, 1, NULL, 5),
(271, 1207064, NULL, 'عبد الهادي غزال', NULL, NULL, 309, 1, 1, NULL, 5),
(272, 1207065, NULL, 'عبدالله الطالب -قديم', NULL, NULL, 310, 1, 1, NULL, 5),
(273, 1207066, NULL, 'عبدو مرعي -نهر البارد-جديد', NULL, NULL, 311, 1, 1, NULL, 5),
(274, 1207067, NULL, 'عدي حيدر', NULL, NULL, 312, 1, 1, NULL, 5),
(275, 1207068, NULL, 'عروة ديوب', NULL, NULL, 313, 1, 1, NULL, 5),
(276, 1207069, NULL, 'عصام محفوض', NULL, NULL, 314, 1, 1, NULL, 5),
(277, 1207070, NULL, 'علاء الاطرش', NULL, NULL, 315, 1, 1, NULL, 5),
(278, 1207071, NULL, 'علاء شحود - جرجرة', NULL, NULL, 316, 1, 1, NULL, 5),
(279, 1207072, NULL, 'علاء عليشة-قديم -', NULL, NULL, 317, 1, 1, NULL, 5),
(280, 1207073, NULL, 'علي الخضر - مصياف', NULL, NULL, 318, 1, 1, NULL, 5),
(281, 1207074, NULL, 'علي ديبو - المحروسة', NULL, NULL, 319, 1, 1, NULL, 5),
(282, 1207075, NULL, 'عماد جماشيري', NULL, NULL, 320, 1, 1, NULL, 5),
(283, 1207076, NULL, 'عماد نعسان جديد', NULL, NULL, 321, 1, 1, NULL, 5),
(284, 1207077, NULL, 'عمار زيود- نبع الضب- جديد محرده', NULL, NULL, 322, 1, 1, NULL, 5),
(285, 1207078, NULL, 'عمر ابراهيم', NULL, NULL, 323, 1, 1, NULL, 5),
(286, 1207079, NULL, 'غسان ديب- عين الكروم محرده -جديد', NULL, NULL, 324, 1, 1, NULL, 5),
(287, 1207080, NULL, 'غسان سلوم - محردة', NULL, NULL, 325, 1, 1, NULL, 5),
(288, 1207081, NULL, 'فادي الخيرات - جديد', NULL, NULL, 326, 1, 1, NULL, 5),
(289, 1207082, NULL, 'فخر الدين المصري', NULL, NULL, 327, 1, 1, NULL, 5),
(290, 1207083, NULL, 'فراس نعوم - كفربهم - جديد', NULL, NULL, 328, 1, 1, NULL, 5),
(291, 1207084, NULL, 'فهد محفوض - كفر بهم- جديد', NULL, NULL, 329, 1, 1, NULL, 5),
(292, 1207085, NULL, 'قتيبة حاصود - حلفايا', NULL, NULL, 330, 1, 1, NULL, 5),
(293, 1207086, NULL, 'كامل محمود - المحروسة', NULL, NULL, 331, 1, 1, NULL, 5),
(294, 1207087, NULL, 'ليلى الحمود - البياضية', NULL, NULL, 332, 1, 1, NULL, 5),
(295, 1207088, NULL, 'متروك الرجب - جديد', NULL, NULL, 333, 1, 1, NULL, 5),
(296, 1207089, NULL, 'مجد السلوم - الصفصافية', NULL, NULL, 334, 1, 1, NULL, 5),
(297, 1207090, NULL, 'محمد الاحمد - كفر هود', NULL, NULL, 335, 1, 1, NULL, 5),
(298, 1207091, NULL, 'محمد المصطفى - جديد', NULL, NULL, 336, 1, 1, NULL, 5),
(299, 1207092, NULL, 'محمد خليل', NULL, NULL, 337, 1, 1, NULL, 5),
(300, 1207093, NULL, 'محمد منصور - الصفصافية - قديم', NULL, NULL, 338, 1, 1, NULL, 5),
(301, 1207094, NULL, 'مدحت النعسان', NULL, NULL, 339, 1, 1, NULL, 5),
(302, 1207095, NULL, 'مضر دومان - سلحب', NULL, NULL, 340, 1, 1, NULL, 5),
(303, 1207096, NULL, 'معتز الحسن - جديد', NULL, NULL, 341, 1, 1, NULL, 5),
(304, 1207097, NULL, 'منهل نصار - السقيلبية', NULL, NULL, 342, 1, 1, NULL, 5),
(305, 1207098, NULL, 'مهند الحسن - الكرامة', NULL, NULL, 343, 1, 1, NULL, 5),
(306, 1207099, NULL, 'مياد سلوم- محردة -جديد', NULL, NULL, 344, 1, 1, NULL, 5),
(307, 1207100, NULL, 'ناصر رمضان', NULL, NULL, 345, 1, 1, NULL, 5),
(308, 1207101, NULL, 'نجوان خيزران', NULL, NULL, 346, 1, 1, NULL, 5),
(309, 1207102, NULL, 'نزار يعقوب - محردة', NULL, NULL, 347, 1, 1, NULL, 5),
(310, 1207103, NULL, 'نزيه ماعود - كفربهم', NULL, NULL, 348, 1, 1, NULL, 5),
(311, 1207104, NULL, 'نضال بكور - جديد', NULL, NULL, 349, 1, 1, NULL, 5),
(312, 1207105, NULL, 'نضال شحود - المحروسة', NULL, NULL, 350, 1, 1, NULL, 5),
(313, 1207106, NULL, 'هشام ميواك', NULL, NULL, 351, 1, 1, NULL, 5),
(314, 1207107, NULL, 'وديع صقر - السقيلبية - جديد', NULL, NULL, 352, 1, 1, NULL, 5),
(315, 1207108, NULL, 'وسيم الاسعد', NULL, NULL, 353, 1, 1, NULL, 5),
(316, 1207109, NULL, 'ياسر الحكيم', NULL, NULL, 354, 1, 1, NULL, 5),
(317, 120201, NULL, 'ابراهيم طفور - دوما', NULL, NULL, 355, 1, 1, NULL, 6),
(318, 120202, NULL, 'ابو حسن سعد - ضمير', NULL, NULL, 356, 1, 1, NULL, 6),
(319, 120203, NULL, 'ابو حسن عربية - ضمير', NULL, NULL, 357, 1, 1, NULL, 6),
(320, 120204, NULL, 'ابو علوش - عدرا الصناعية', NULL, NULL, 358, 1, 1, NULL, 6),
(321, 120205, NULL, 'ابو محمد ( صحية )', NULL, NULL, 359, 1, 1, NULL, 6),
(322, 120206, NULL, 'احمد فرحان - عدرا الصناعية', NULL, NULL, 360, 1, 1, NULL, 6),
(323, 120207, NULL, 'اسامة الشيخ - جديد', NULL, NULL, 361, 1, 1, NULL, 6),
(324, 120208, NULL, 'اسامة مهرة', NULL, NULL, 362, 1, 1, NULL, 6),
(325, 120209, NULL, 'اسماعيل بكر', NULL, NULL, 363, 1, 1, NULL, 6),
(326, 120210, NULL, 'اياد نصير - درعا', NULL, NULL, 364, 1, 1, NULL, 6),
(327, 120211, NULL, 'ايهاب زغيب', NULL, NULL, 365, 1, 1, NULL, 6),
(328, 120212, NULL, 'بشير برخش - دوما', NULL, NULL, 366, 1, 1, NULL, 6),
(329, 120213, NULL, 'حازم نصير', NULL, NULL, 367, 1, 1, NULL, 6),
(330, 120214, NULL, 'حسام ادريس', NULL, NULL, 368, 1, 1, NULL, 6),
(331, 120215, NULL, 'خالد رحمة - الشيفونية - جديد', NULL, NULL, 369, 1, 1, NULL, 6),
(332, 120216, NULL, 'خلدون معروف - سوق الهال الجديد', NULL, NULL, 370, 1, 1, NULL, 6),
(333, 120217, NULL, 'خليل عبد الفتاح - الكسوة', NULL, NULL, 371, 1, 1, NULL, 6),
(334, 120218, NULL, 'رجب الاحمد - الضمير', NULL, NULL, 372, 1, 1, NULL, 6),
(335, 120219, NULL, 'سامر اللحام - الغوطة', NULL, NULL, 373, 1, 1, NULL, 6),
(336, 120220, NULL, 'سعيد الوغا', NULL, NULL, 374, 1, 1, NULL, 6),
(337, 120221, NULL, 'سهيل تكروري - جديد', NULL, NULL, 375, 1, 1, NULL, 6),
(338, 120222, NULL, 'صالح المحمد', NULL, NULL, 376, 1, 1, NULL, 6),
(339, 120223, NULL, 'صبحي طه', NULL, NULL, 377, 1, 1, NULL, 6),
(340, 120224, NULL, 'ضاهر عبد النبي - الصبورة', NULL, NULL, 378, 1, 1, NULL, 6),
(341, 120225, NULL, 'ظافر الاحمد', NULL, NULL, 379, 1, 1, NULL, 6),
(342, 120226, NULL, 'عارف الدج - دوما - جديد', NULL, NULL, 380, 1, 1, NULL, 6),
(343, 120227, NULL, 'عامر الزبيبي - سوق الهال', NULL, NULL, 381, 1, 1, NULL, 6),
(344, 120228, NULL, 'عبد الحي الصباغ', NULL, NULL, 382, 1, 1, NULL, 6),
(345, 120229, NULL, 'عبد الله الشبلي - النشابية', NULL, NULL, 383, 1, 1, NULL, 6),
(346, 120230, NULL, 'عبد الله شرف الدين', NULL, NULL, 384, 1, 1, NULL, 6),
(347, 120231, NULL, 'عبدو نكد', NULL, NULL, 385, 1, 1, NULL, 6),
(348, 120232, NULL, 'علاء الشبلي - سوق الهال - قديم', NULL, NULL, 386, 1, 1, NULL, 6),
(349, 120233, NULL, 'علي الصبح ( ربيع الخليل ) - القنية', NULL, NULL, 387, 1, 1, NULL, 6),
(350, 120234, NULL, 'علي سلطان - الشيفونية', NULL, NULL, 388, 1, 1, NULL, 6),
(351, 120235, NULL, 'عماد ابو يزبك - السويداء', NULL, NULL, 389, 1, 1, NULL, 6),
(352, 120236, NULL, 'عمار ادلبي', NULL, NULL, 390, 1, 1, NULL, 6),
(353, 120237, NULL, 'عمار عبد العزيز', NULL, NULL, 391, 1, 1, NULL, 6),
(354, 120238, NULL, 'عوض الخلف - عدرا الصناعية', NULL, NULL, 392, 1, 1, NULL, 6),
(355, 120239, NULL, 'عوني جمعة', NULL, NULL, 393, 1, 1, NULL, 6),
(356, 120240, NULL, 'غسان بطراكي - عدرا', NULL, NULL, 394, 1, 1, NULL, 6),
(357, 120241, NULL, 'غياث طه', NULL, NULL, 395, 1, 1, NULL, 6),
(358, 120242, NULL, 'قاسم طعمة', NULL, NULL, 396, 1, 1, NULL, 6),
(359, 120243, NULL, 'قاسم محمد سرحان - عدرا', NULL, NULL, 397, 1, 1, NULL, 6),
(360, 120244, NULL, 'م. علي نصر الله - سوق الهال', NULL, NULL, 398, 1, 1, NULL, 6),
(361, 120245, NULL, 'مالك شعبان', NULL, NULL, 399, 1, 1, NULL, 6),
(362, 120246, NULL, 'مأمون الاصفر', NULL, NULL, 400, 1, 1, NULL, 6),
(363, 120247, NULL, 'مأمون الحافي', NULL, NULL, 401, 1, 1, NULL, 6),
(364, 120248, NULL, 'محمد الاجوه', NULL, NULL, 402, 1, 1, NULL, 6),
(365, 120249, NULL, 'محمد الصوص', NULL, NULL, 403, 1, 1, NULL, 6),
(366, 120250, NULL, 'محمد زهير أبو جيب - دوما - جديد', NULL, NULL, 404, 1, 1, NULL, 6),
(367, 120251, NULL, 'محمود دعاس', NULL, NULL, 405, 1, 1, NULL, 6),
(368, 120252, NULL, 'مصطفى الأشرف - عدرا', NULL, NULL, 406, 1, 1, NULL, 6),
(369, 120253, NULL, 'مصطفى الصواف - الكسوة', NULL, NULL, 407, 1, 1, NULL, 6),
(370, 120254, NULL, 'مصطفى عبد الواحد', NULL, NULL, 408, 1, 1, NULL, 6),
(371, 120255, NULL, 'مصطفى علي', NULL, NULL, 409, 1, 1, NULL, 6),
(372, 120256, NULL, 'معمر بردان', NULL, NULL, 410, 1, 1, NULL, 6),
(373, 120257, NULL, 'موفق الجوجو', NULL, NULL, 411, 1, 1, NULL, 6),
(374, 120258, NULL, 'موفق شرف - الصبورة', NULL, NULL, 412, 1, 1, NULL, 6),
(375, 120259, NULL, 'هايل مزهر', NULL, NULL, 413, 1, 1, NULL, 6),
(376, 120260, NULL, 'يوسف السعدي - الضمير', NULL, NULL, 414, 1, 1, NULL, 6),
(377, 120801, NULL, 'ابراهيم رستناوي - صوران - جديد', NULL, NULL, 415, 1, 1, NULL, 7),
(378, 120802, NULL, 'احمد ادريس', NULL, NULL, 416, 1, 1, NULL, 7),
(379, 120803, NULL, 'احمد الصالح - الشيخ علي - جديد', NULL, NULL, 417, 1, 1, NULL, 7),
(380, 120804, NULL, 'احمد الضاهر -قديم-', NULL, NULL, 418, 1, 1, NULL, 7),
(381, 120805, NULL, 'احمد القاسم - سريحين', NULL, NULL, 419, 1, 1, NULL, 7),
(382, 120806, NULL, 'احمد عواد - تلبيسة - جديد', NULL, NULL, 420, 1, 1, NULL, 7),
(383, 120807, NULL, 'اديب عرابي', NULL, NULL, 421, 1, 1, NULL, 7),
(384, 120808, NULL, 'ايمن صويص - تلبيسة - جديد', NULL, NULL, 422, 1, 1, NULL, 7),
(385, 120809, NULL, 'جانيت صنعون', NULL, NULL, 423, 1, 1, NULL, 7),
(386, 120810, NULL, 'جمال سعيد - جرجيسة', NULL, NULL, 424, 1, 1, NULL, 7),
(387, 120811, NULL, 'حسن الشيخ حسن - سلمية - جديد', NULL, NULL, 425, 1, 1, NULL, 7),
(388, 120812, NULL, 'خالد الحميدي - يسيرين', NULL, NULL, 426, 1, 1, NULL, 7),
(389, 120813, NULL, 'خالد العسكري - تل قطا', NULL, NULL, 427, 1, 1, NULL, 7),
(390, 120814, NULL, 'سومر عبود-قديم', NULL, NULL, 428, 1, 1, NULL, 7),
(391, 120815, NULL, 'شادي الفرا-قديم-', NULL, NULL, 429, 1, 1, NULL, 7),
(392, 120816, NULL, 'صفوان السح - حماه - قديم', NULL, NULL, 430, 1, 1, NULL, 7),
(393, 120817, NULL, 'عامر خورشيد-قديم-', NULL, NULL, 431, 1, 1, NULL, 7),
(394, 120818, NULL, 'عامر صوي', NULL, NULL, 432, 1, 1, NULL, 7),
(395, 120819, NULL, 'عبد الرحمن القطميش', NULL, NULL, 433, 1, 1, NULL, 7),
(396, 120820, NULL, 'عبد الرحيم الجمعة - تلبيسة', NULL, NULL, 434, 1, 1, NULL, 7),
(397, 120821, NULL, 'عبد الرزاق النائب - حماه', NULL, NULL, 435, 1, 1, NULL, 7),
(398, 120822, NULL, 'عبد السلام الاكسح - الزعفرانة', NULL, NULL, 436, 1, 1, NULL, 7),
(399, 120823, NULL, 'عبد الكريم المدني -قديم', NULL, NULL, 437, 1, 1, NULL, 7),
(400, 120824, NULL, 'عبد الله مطر - الرستن', NULL, NULL, 438, 1, 1, NULL, 7),
(401, 120825, NULL, 'عبد المنعم الابراهيم -مورك -قديم', NULL, NULL, 439, 1, 1, NULL, 7),
(402, 120826, NULL, 'عبد المنعم السمرة - طيبة الامام', NULL, NULL, 440, 1, 1, NULL, 7),
(403, 120827, NULL, 'عبد المنعم سلورة - حماه', NULL, NULL, 441, 1, 1, NULL, 7),
(404, 120828, NULL, 'عبدالرحمن القطميش -قديم', NULL, NULL, 442, 1, 1, NULL, 7),
(405, 120829, NULL, 'عبدالله مطر -قديم', NULL, NULL, 443, 1, 1, NULL, 7),
(406, 120830, NULL, 'عثمان ايوب -قديم-', NULL, NULL, 444, 1, 1, NULL, 7),
(407, 120831, NULL, 'علاء اليوسف - ضاهرية', NULL, NULL, 445, 1, 1, NULL, 7),
(408, 120832, NULL, 'عمار السرميني - زعفرانة - جديد', NULL, NULL, 446, 1, 1, NULL, 7),
(409, 120833, NULL, 'فراس عدرا - سلمية', NULL, NULL, 447, 1, 1, NULL, 7),
(410, 120834, NULL, 'فرحان الشقفة - حماه', NULL, NULL, 448, 1, 1, NULL, 7),
(411, 120835, NULL, 'لؤي النجار - الرستن', NULL, NULL, 449, 1, 1, NULL, 7),
(412, 120836, NULL, 'محمد الابراهيم - جرجيسة', NULL, NULL, 450, 1, 1, NULL, 7),
(413, 120837, NULL, 'محمد الجرف - سلمية', NULL, NULL, 451, 1, 1, NULL, 7),
(414, 120838, NULL, 'محمد الكفري', NULL, NULL, 452, 1, 1, NULL, 7),
(415, 120839, NULL, 'محمد سودين - قمحانة - جديد', NULL, NULL, 453, 1, 1, NULL, 7),
(416, 120840, NULL, 'محمد شنو - دير الفرديس - جديد', NULL, NULL, 454, 1, 1, NULL, 7),
(417, 120841, NULL, 'محمود الخطيب - تلبيسة', NULL, NULL, 455, 1, 1, NULL, 7),
(418, 120842, NULL, 'مهند اليوسف - زور سريحين - جديد', NULL, NULL, 456, 1, 1, NULL, 7),
(419, 120843, NULL, 'ناصر يحيى - السلمية - جديد', NULL, NULL, 457, 1, 1, NULL, 7),
(420, 120844, NULL, 'هاشم شحود - سلمية - قديم', NULL, NULL, 458, 1, 1, NULL, 7),
(421, 120845, NULL, 'يامن ياسين - معر شحور - جديد', NULL, NULL, 459, 1, 1, NULL, 7),
(422, 120901, NULL, 'آلان امين - عامودا', NULL, NULL, 460, 1, 1, NULL, 8),
(423, 120902, NULL, 'بلال صالح بركات - القامشلي', NULL, NULL, 461, 1, 1, NULL, 8),
(424, 120903, NULL, 'بهجت محمود - القامشلي', NULL, NULL, 462, 1, 1, NULL, 8),
(425, 120904, NULL, 'ثلاج الكرو - القحطانية', NULL, NULL, 463, 1, 1, NULL, 8),
(426, 120905, NULL, 'جاك حشيشو - الحسكة', NULL, NULL, 464, 1, 1, NULL, 8),
(427, 120906, NULL, 'جمعة عمو - راس العين', NULL, NULL, 465, 1, 1, NULL, 8),
(428, 120907, NULL, 'جنيد شيخي - القامشلي', NULL, NULL, 466, 1, 1, NULL, 8),
(429, 120908, NULL, 'جوان عبد الرحمن - عامودا', NULL, NULL, 467, 1, 1, NULL, 8),
(430, 120909, NULL, 'جوان عيسى احمد - القامشلي', NULL, NULL, 468, 1, 1, NULL, 8),
(431, 120910, NULL, 'حاتم الجوادية - الجوادية', NULL, NULL, 469, 1, 1, NULL, 8),
(432, 120911, NULL, 'حسن حاج ابراهيم - القامشلي', NULL, NULL, 470, 1, 1, NULL, 8),
(433, 120912, NULL, 'حميد عبد العزيز - راس العين', NULL, NULL, 471, 1, 1, NULL, 8),
(434, 120913, NULL, 'حواس دللي - القامشلي', NULL, NULL, 472, 1, 1, NULL, 8),
(435, 120914, NULL, 'خليل حسن - القامشلي - جديد', NULL, NULL, 473, 1, 1, NULL, 8),
(436, 120915, NULL, 'خير الدين اوصمان - القامشلي', NULL, NULL, 474, 1, 1, NULL, 8),
(437, 120916, NULL, 'د. حسين الحنوش - القامشلي - جديد', NULL, NULL, 475, 1, 1, NULL, 8),
(438, 120917, NULL, 'د.اسعد مجباس - الحسكة', NULL, NULL, 476, 1, 1, NULL, 8),
(439, 120918, NULL, 'رائد حناوي - القحطانية', NULL, NULL, 477, 1, 1, NULL, 8),
(440, 120919, NULL, 'زبير حسي - القامشلي', NULL, NULL, 478, 1, 1, NULL, 8),
(441, 120920, NULL, 'زهدي داود - القامشلي', NULL, NULL, 479, 1, 1, NULL, 8),
(442, 120921, NULL, 'سامي عمسو - القامشلي', NULL, NULL, 480, 1, 1, NULL, 8),
(443, 120922, NULL, 'سرباز حاول - القحطانية', NULL, NULL, 481, 1, 1, NULL, 8),
(444, 120923, NULL, 'صالح بركات - القامشلي', NULL, NULL, 482, 1, 1, NULL, 8),
(445, 120924, NULL, 'صلاح حمزة - المالكية', NULL, NULL, 483, 1, 1, NULL, 8),
(446, 120925, NULL, 'ضياء الحق حسين - القحطانية', NULL, NULL, 484, 1, 1, NULL, 8),
(447, 120926, NULL, 'عز الدين خليل - عامودا', NULL, NULL, 485, 1, 1, NULL, 8),
(448, 120927, NULL, 'علاء المرعي - راس العين', NULL, NULL, 486, 1, 1, NULL, 8),
(449, 120928, NULL, 'علي برغوث - ابو راسين', NULL, NULL, 487, 1, 1, NULL, 8),
(450, 120929, NULL, 'فرزند الملا - الدرباسية', NULL, NULL, 488, 1, 1, NULL, 8),
(451, 120930, NULL, 'فواز زيدان - القحطانية', NULL, NULL, 489, 1, 1, NULL, 8),
(452, 120931, NULL, 'كبرئيل اسمان - القامشلي - جديد', NULL, NULL, 490, 1, 1, NULL, 8),
(453, 120932, NULL, 'لاوين سيف الدين - المعبدة', NULL, NULL, 491, 1, 1, NULL, 8),
(454, 120933, NULL, 'لزكين حرسان', NULL, NULL, 492, 1, 1, NULL, 8),
(455, 120934, NULL, 'م.جوزيف كوريه - المالكية', NULL, NULL, 493, 1, 1, NULL, 8),
(456, 120935, NULL, 'م.حسن جمعة - ابو راسين', NULL, NULL, 494, 1, 1, NULL, 8),
(457, 120936, NULL, 'م.محمد جياد - الحسكة - جديد', NULL, NULL, 495, 1, 1, NULL, 8),
(458, 120937, NULL, 'م.محمد عبد العزيز - راس العين', NULL, NULL, 496, 1, 1, NULL, 8),
(459, 120938, NULL, 'محمد حكمي - ابو راسين', NULL, NULL, 497, 1, 1, NULL, 8),
(460, 120939, NULL, 'محمد حمادي - القامشلي', NULL, NULL, 498, 1, 1, NULL, 8),
(461, 120940, NULL, 'محمد شاكر - القحطانية', NULL, NULL, 499, 1, 1, NULL, 8),
(462, 120941, NULL, 'محمود بدرو - راس العين', NULL, NULL, 500, 1, 1, NULL, 8),
(463, 120942, NULL, 'محمود حسن - القامشلي', NULL, NULL, 501, 1, 1, NULL, 8),
(464, 120943, NULL, 'مراد مصطفى - القامشلي', NULL, NULL, 502, 1, 1, NULL, 8),
(465, 120944, NULL, 'مصطفى ابو الصوف - القامشلي', NULL, NULL, 503, 1, 1, NULL, 8),
(466, 120601, NULL, 'احمد الزير - بانياس - قديم', NULL, NULL, 504, 1, 1, NULL, 9),
(467, 120602, NULL, 'احمد عبيد -قديم', NULL, NULL, 505, 1, 1, NULL, 9),
(468, 120603, NULL, 'اسامة اسماعيل - بانياس - قديم', NULL, NULL, 506, 1, 1, NULL, 9),
(469, 120604, NULL, 'ايهاب مهنا -قديم -', NULL, NULL, 507, 1, 1, NULL, 9),
(470, 120605, NULL, 'باسل سعود -قديم-', NULL, NULL, 508, 1, 1, NULL, 9),
(471, 120606, NULL, 'خيرات قدور -قديم -', NULL, NULL, 509, 1, 1, NULL, 9),
(472, 120607, NULL, 'رغيد بشارة -قديم', NULL, NULL, 510, 1, 1, NULL, 9),
(473, 120608, NULL, 'زياد موسى - الخراب', NULL, NULL, 511, 1, 1, NULL, 9),
(474, 120609, NULL, 'سعد خليل', NULL, NULL, 512, 1, 1, NULL, 9),
(475, 120610, NULL, 'صفيان كاملة', NULL, NULL, 513, 1, 1, NULL, 9),
(476, 120611, NULL, 'طلال ونوس -قديم', NULL, NULL, 514, 1, 1, NULL, 9),
(477, 120612, NULL, 'عبد الغني الشغري -جديد-', NULL, NULL, 515, 1, 1, NULL, 9),
(478, 120613, NULL, 'عبد القادر منصور-قديم-', NULL, NULL, 516, 1, 1, NULL, 9),
(479, 120614, NULL, 'عبد الله عيوش - قديم', NULL, NULL, 517, 1, 1, NULL, 9),
(480, 120615, NULL, 'علي بياسي -قديم', NULL, NULL, 518, 1, 1, NULL, 9),
(481, 120616, NULL, 'علي سليمان -قديم', NULL, NULL, 519, 1, 1, NULL, 9),
(482, 120617, NULL, 'علي معروف -قديم-', NULL, NULL, 520, 1, 1, NULL, 9),
(483, 120618, NULL, 'عيسى عيسى - حريصون', NULL, NULL, 521, 1, 1, NULL, 9),
(484, 120619, NULL, 'كامل موسى - الخراب - بانياس', NULL, NULL, 522, 1, 1, NULL, 9),
(485, 120620, NULL, 'ماهر عبود - قديم', NULL, NULL, 523, 1, 1, NULL, 9),
(486, 120621, NULL, 'محمد الشغري - بانياس', NULL, NULL, 524, 1, 1, NULL, 9),
(487, 120622, NULL, 'محمد رحمون ( حميد ) - بانياس', NULL, NULL, 525, 1, 1, NULL, 9),
(488, 120623, NULL, 'محمد لولو', NULL, NULL, 526, 1, 1, NULL, 9),
(489, 120624, NULL, 'محمد وحود', NULL, NULL, 527, 1, 1, NULL, 9),
(490, 120625, NULL, 'محمود منصور - قديم', NULL, NULL, 528, 1, 1, NULL, 9),
(491, 120626, NULL, 'مصطفى غلاونجي', NULL, NULL, 529, 1, 1, NULL, 9),
(492, 120627, NULL, 'مضر حويجة -قديم -', NULL, NULL, 530, 1, 1, NULL, 9),
(493, 121001, NULL, 'احمد المحمود دير حافر -قديم', NULL, NULL, 531, 1, 1, NULL, 21),
(494, 121002, NULL, 'اسماعيل كالو - تل عرن - حلب - جديد', NULL, NULL, 532, 1, 1, NULL, 21),
(495, 121003, NULL, 'المهندس يوسف كالو - تل عرن - حلب - جديد', NULL, NULL, 533, 1, 1, NULL, 21),
(496, 121004, NULL, 'جفال الجفال - تل عرن - حلب', NULL, NULL, 534, 1, 1, NULL, 21),
(497, 121005, NULL, 'حسن خليل جديد- السفيرة', NULL, NULL, 535, 1, 1, NULL, 21),
(498, 121006, NULL, 'حمود حمام- تل عرن- جديد', NULL, NULL, 536, 1, 1, NULL, 21),
(499, 121007, NULL, 'خالد النجار -جديد -', NULL, NULL, 537, 1, 1, NULL, 21),
(500, 121008, NULL, 'خليل الحسين جديد', NULL, NULL, 538, 1, 1, NULL, 21),
(501, 121009, NULL, 'د. عبد الرزاق الابراهيم - دير حافر - حلب - جديد', NULL, NULL, 539, 1, 1, NULL, 21),
(502, 121010, NULL, 'د. عبد اللطيف العساف - كويرس - حلب - جديد', NULL, NULL, 540, 1, 1, NULL, 21),
(503, 121011, NULL, 'د. محمد نور الدين العساف - دير حافر - حلب - جديد', NULL, NULL, 541, 1, 1, NULL, 21),
(504, 121012, NULL, 'صالح شبلي', NULL, NULL, 542, 1, 1, NULL, 21),
(505, 121013, NULL, 'صبحي فلاحة - حلب', NULL, NULL, 543, 1, 1, NULL, 21),
(506, 121014, NULL, 'عبود حرجة - تل عرن - حلب - جديد', NULL, NULL, 544, 1, 1, NULL, 21),
(507, 121015, NULL, 'علي ميرزو - تل حاصل - حلب - جديد', NULL, NULL, 545, 1, 1, NULL, 21),
(508, 121016, NULL, 'فهد الدبس - تل عرن - حلب - جديد', NULL, NULL, 546, 1, 1, NULL, 21),
(509, 121017, NULL, 'فهد عاشوري - دير حافر - حلب', NULL, NULL, 547, 1, 1, NULL, 21),
(510, 121018, NULL, 'م. خالد عاصي - حلب - جديد', NULL, NULL, 548, 1, 1, NULL, 21),
(511, 121019, NULL, 'م. خليل الحسين - تل عرن - حلب', NULL, NULL, 549, 1, 1, NULL, 21),
(512, 121020, NULL, 'م. عبد العزيز الصالح - السفيرة - حلب - جديد', NULL, NULL, 550, 1, 1, NULL, 21),
(513, 121021, NULL, 'م. مازن جاويش - حلب - جديد', NULL, NULL, 551, 1, 1, NULL, 21),
(514, 121022, NULL, 'م. محمد الكضيب - دير حافر - حلب', NULL, NULL, 552, 1, 1, NULL, 21),
(515, 121023, NULL, 'م. محمد خليل - حلب - جديد', NULL, NULL, 553, 1, 1, NULL, 21),
(516, 121024, NULL, 'م. محمود الحميدان - حلب - جديد', NULL, NULL, 554, 1, 1, NULL, 21),
(517, 121025, NULL, 'م. محمود الشيخ نوري - مسكنة - حلب - جديد', NULL, NULL, 555, 1, 1, NULL, 21),
(518, 121026, NULL, 'م. نبهان النبهان - النيرب - حلب - جديد', NULL, NULL, 556, 1, 1, NULL, 21),
(519, 121027, NULL, 'م.خالد عاصي - قديم', NULL, NULL, 557, 1, 1, NULL, 21),
(520, 121028, NULL, 'م.علي العمر - السفيرة - حلب - جديد', NULL, NULL, 558, 1, 1, NULL, 21),
(521, 121029, NULL, 'م.مازن جاويش -قديم', NULL, NULL, 559, 1, 1, NULL, 21),
(522, 121030, NULL, 'م.محمود ابريق - حلب', NULL, NULL, 560, 1, 1, NULL, 21),
(523, 121031, NULL, 'محمود الشيخ نوري -قديم -', NULL, NULL, 561, 1, 1, NULL, 21),
(524, 121032, NULL, 'مصطفى حنكول - حلب', NULL, NULL, 562, 1, 1, NULL, 21),
(525, 121033, NULL, 'نبهان النبهان -قديم -', NULL, NULL, 563, 1, 1, NULL, 21),
(526, 121034, NULL, 'هيثم هلول - تل عرن - حلب - جديد', NULL, NULL, 564, 1, 1, NULL, 21),
(527, 121101, NULL, 'اكرم بيريني -قديم -', NULL, NULL, 565, 1, 1, NULL, 11),
(528, 121102, NULL, 'انطوان نويران', NULL, NULL, 566, 1, 1, NULL, 11),
(529, 121103, NULL, 'اياد كفى - حمص', NULL, NULL, 567, 1, 1, NULL, 11),
(530, 121104, NULL, 'بسام فركوح - حمص', NULL, NULL, 568, 1, 1, NULL, 11),
(531, 121105, NULL, 'تامر غنوم - نقيرة', NULL, NULL, 569, 1, 1, NULL, 11),
(532, 121106, NULL, 'جهاد بريجاوي - حمص', NULL, NULL, 570, 1, 1, NULL, 11),
(533, 121107, NULL, 'حافظ العلي - حمص', NULL, NULL, 571, 1, 1, NULL, 11),
(534, 121108, NULL, 'حسام جمال - حمص - قديم', NULL, NULL, 572, 1, 1, NULL, 11),
(535, 121109, NULL, 'حسان وسوف - حمص', NULL, NULL, 573, 1, 1, NULL, 11),
(536, 121110, NULL, 'حسين القاسم - قديم', NULL, NULL, 574, 1, 1, NULL, 11),
(537, 121111, NULL, 'خالد اسماعيل -الزهورية -جديد', NULL, NULL, 575, 1, 1, NULL, 11),
(538, 121112, NULL, 'ديب نجم - زيدل - حمص', NULL, NULL, 576, 1, 1, NULL, 11),
(539, 121113, NULL, 'سمير حلاق', NULL, NULL, 577, 1, 1, NULL, 11),
(540, 121114, NULL, 'طارق مرش - حمص', NULL, NULL, 578, 1, 1, NULL, 11),
(541, 121115, NULL, 'عبد الحليم الجنيدي - حمص', NULL, NULL, 579, 1, 1, NULL, 11),
(542, 121116, NULL, 'عبد المعطي السمرة - حمص', NULL, NULL, 580, 1, 1, NULL, 11),
(543, 121117, NULL, 'عبد الناصر الكنج - قديم', NULL, NULL, 581, 1, 1, NULL, 11),
(544, 121118, NULL, 'علي الرضوان - حمص', NULL, NULL, 582, 1, 1, NULL, 11),
(545, 121119, NULL, 'غياث جبر - حمص', NULL, NULL, 583, 1, 1, NULL, 11),
(546, 121120, NULL, 'غياث ديوب - خربة التين - حمص', NULL, NULL, 584, 1, 1, NULL, 11),
(547, 121121, NULL, 'فيكتور عطية - حمص', NULL, NULL, 585, 1, 1, NULL, 11),
(548, 121122, NULL, 'محمد الابراهيم -قديم -', NULL, NULL, 586, 1, 1, NULL, 11),
(549, 121123, NULL, 'محمد خير عرفات - حمص- جديد', NULL, NULL, 587, 1, 1, NULL, 11),
(550, 121124, NULL, 'محمد سالم زكريا -قديم-', NULL, NULL, 588, 1, 1, NULL, 11),
(551, 121125, NULL, 'محمد مصطفى الحسن - حمص - جديد', NULL, NULL, 589, 1, 1, NULL, 11),
(552, 121126, NULL, 'محمد يونس موسى - حمص', NULL, NULL, 590, 1, 1, NULL, 11),
(553, 121127, NULL, 'وديع نصار - حمص', NULL, NULL, 591, 1, 1, NULL, 11),
(554, 120401, NULL, 'احمد ابو غازي النوفل - قديم', NULL, NULL, 592, 1, 1, NULL, 12),
(555, 120402, NULL, 'احمد الحريري-جديد-', NULL, NULL, 593, 1, 1, NULL, 12),
(556, 120403, NULL, 'احمد الحريري-قديم-', NULL, NULL, 594, 1, 1, NULL, 12),
(557, 120404, NULL, 'بشار نصير - ازرع - قديم', NULL, NULL, 595, 1, 1, NULL, 12),
(558, 120405, NULL, 'طارق الدنيفات', NULL, NULL, 596, 1, 1, NULL, 12),
(559, 120406, NULL, 'طارق قطف-جديد-', NULL, NULL, 597, 1, 1, NULL, 12),
(560, 120407, NULL, 'عبد الله العنزي -قديم', NULL, NULL, 598, 1, 1, NULL, 12),
(561, 120408, NULL, 'عبد الله غزالي - قديم', NULL, NULL, 599, 1, 1, NULL, 12),
(562, 120409, NULL, 'عبد المؤمن الشبلي', NULL, NULL, 600, 1, 1, NULL, 12),
(563, 120410, NULL, 'علي العنزي - الحراك - قديم', NULL, NULL, 601, 1, 1, NULL, 12),
(564, 120411, NULL, 'عمار العباس -قديم -', NULL, NULL, 602, 1, 1, NULL, 12),
(565, 120412, NULL, 'كمال الصبحات - طفس- جديد', NULL, NULL, 603, 1, 1, NULL, 12),
(566, 120413, NULL, 'م. بشار نصير - جديد -', NULL, NULL, 604, 1, 1, NULL, 12),
(567, 120414, NULL, 'محمد السعدي - قديم', NULL, NULL, 605, 1, 1, NULL, 12),
(568, 120415, NULL, 'مذكر عباس', NULL, NULL, 606, 1, 1, NULL, 12),
(569, 120416, NULL, 'مروان الشبلي -جديد-', NULL, NULL, 607, 1, 1, NULL, 12),
(570, 120417, NULL, 'مهند جباوي - جاسم -- جديد', NULL, NULL, 608, 1, 1, NULL, 12),
(571, 120418, NULL, 'نبيل عيشات - قديم', NULL, NULL, 609, 1, 1, NULL, 12),
(572, 120419, NULL, 'هشام نصير - ازرع - قديم', NULL, NULL, 610, 1, 1, NULL, 12),
(573, 120420, NULL, 'وليد ابو شنب - جديد', NULL, NULL, 611, 1, 1, NULL, 12),
(574, 121035, NULL, 'حيدر خليل  اللاذقية', NULL, NULL, 613, 1, 1, NULL, 21),
(575, 121128, NULL, 'عبد الله العنزي قديم', NULL, NULL, 614, 1, 1, NULL, 11),
(576, 121036, NULL, 'المهندس رامز حسن  قديم', NULL, NULL, 615, 1, 1, NULL, 21),
(577, 121129, NULL, 'مهند جباوي قديم', NULL, NULL, 616, 1, 1, NULL, 11),
(578, 121037, NULL, 'ابراهيم ونوس  قلعة جراس  قديم', NULL, NULL, 617, 1, 1, NULL, 21),
(579, 121038, NULL, 'طلال ابراهيم  كفر بهم  قديم', NULL, NULL, 618, 1, 1, NULL, 21),
(580, 121039, NULL, 'محمود الخطيب قديم', NULL, NULL, 619, 1, 1, NULL, 21),
(581, 122101, NULL, 'عبد الله عيوش  قديم', NULL, NULL, 620, 1, 1, NULL, NULL),
(582, 121040, NULL, 'حمدان الحسن  درعا  قديم', NULL, NULL, 621, 1, 1, NULL, 21),
(583, 121041, NULL, 'فراس حسين طرطوس قديم', NULL, NULL, 622, 1, 1, NULL, 21),
(584, 121042, NULL, 'شادي حمود  الربيعة', NULL, NULL, 623, 1, 1, NULL, 21),
(585, 121043, NULL, 'عبد العزيز المحمد جريكيس قديم', NULL, NULL, 624, 1, 1, NULL, 21),
(586, 121044, NULL, 'د. احمد الصالح  قديم', NULL, NULL, 625, 1, 1, NULL, 21),
(587, 121045, NULL, 'علي الشرف نصيب', NULL, NULL, 626, 1, 1, NULL, 21),
(588, 121046, NULL, 'م. خالد النجار  منبج', NULL, NULL, 627, 1, 1, NULL, 21),
(589, 121047, NULL, 'احمد كامل الزعبي  قديم', NULL, NULL, 628, 1, 1, NULL, 21),
(590, 121048, NULL, 'رضوان الرضوان  قديم', NULL, NULL, 629, 1, 1, NULL, 21),
(591, 121049, NULL, 'محمد علي قديم', NULL, NULL, 630, 1, 1, NULL, 21),
(592, 121130, NULL, 'امين اسماعيل  قديم', NULL, NULL, 631, 1, 1, NULL, 11),
(593, 122102, NULL, 'علي معروف قديم', NULL, NULL, 632, 1, 1, NULL, NULL),
(594, 121131, NULL, 'علي الرضوان قديم', NULL, NULL, 633, 1, 1, NULL, 11),
(595, 121050, NULL, 'مراد مصطفى  القامشلي', NULL, NULL, 634, 1, 1, NULL, 21),
(596, 121051, NULL, 'م. صخر العبدو  منبج', NULL, NULL, 635, 1, 1, NULL, 21),
(597, 121052, NULL, 'عبد الله غزالي  قديم', NULL, NULL, 636, 1, 1, NULL, 21),
(598, 121053, NULL, 'عبد المعطي الحسينقديم ', NULL, NULL, 637, 1, 1, NULL, 21),
(599, 121132, NULL, 'احمد الحريريقديم', NULL, NULL, 638, 1, 1, NULL, 11),
(600, 121133, NULL, 'نبهان النبهان قديم ', NULL, NULL, 639, 1, 1, NULL, 11),
(601, 121054, NULL, 'اسامة الشيخ  قديم', NULL, NULL, 640, 1, 1, NULL, 21),
(602, 121055, NULL, 'قاسم ابو شنب  قديم', NULL, NULL, 641, 1, 1, NULL, 21),
(603, 121056, NULL, 'وسيم عيسى قديم', NULL, NULL, 642, 1, 1, NULL, 21),
(604, 121057, NULL, 'المهندس وسام جبور  قديم', NULL, NULL, 643, 1, 1, NULL, 21),
(605, 121058, NULL, 'احمد حميد عبادي ع/ط اسماعيل العيسى  منبج', NULL, NULL, 644, 1, 1, NULL, 21),
(606, 121134, NULL, 'م.خالد عاصي  قديم', NULL, NULL, 645, 1, 1, NULL, 11),
(607, 121135, NULL, 'المهندس يوسف كالو  تل عرن  حلب  قديم', NULL, NULL, 646, 1, 1, NULL, 11),
(608, 121059, NULL, 'زياد موسى  الخراب', NULL, NULL, 647, 1, 1, NULL, 21),
(609, 121060, NULL, 'ابراهيم الدايغ  محردة  قديم', NULL, NULL, 648, 1, 1, NULL, 21),
(610, 121061, NULL, 'محسن ترسيسي  قديم', NULL, NULL, 649, 1, 1, NULL, 21),
(611, 121062, NULL, 'ابراهيم الضامن كررناز محرده قديم', NULL, NULL, 650, 1, 1, NULL, 21),
(612, 121136, NULL, 'حسين القاسم  قديم', NULL, NULL, 651, 1, 1, NULL, 11),
(613, 121063, NULL, 'مصعب الزعبي قديم ', NULL, NULL, 652, 1, 1, NULL, 21),
(614, 121064, NULL, 'رمضان شدو  منبج', NULL, NULL, 653, 1, 1, NULL, 21),
(615, 121065, NULL, 'ابراهيم قهوجي  درعا  قديم', NULL, NULL, 654, 1, 1, NULL, 21),
(616, 121066, NULL, 'وديع صقر  السقيلبية  قديم', NULL, NULL, 655, 1, 1, NULL, 21),
(617, 121067, NULL, 'سليمان المحمود قديم', NULL, NULL, 656, 1, 1, NULL, 21),
(618, 121068, NULL, 'راني كيوان  قديم', NULL, NULL, 657, 1, 1, NULL, 21),
(619, 121137, NULL, 'د. عبد الرزاق الابراهيم  دير حافر  حلب  قديم', NULL, NULL, 658, 1, 1, NULL, 11),
(620, 121069, NULL, 'علي البردان  قديم', NULL, NULL, 659, 1, 1, NULL, 21),
(621, 121070, NULL, 'فادي الخيرات  قديم', NULL, NULL, 660, 1, 1, NULL, 21),
(622, 121071, NULL, 'ادهم الزعيم  منبج', NULL, NULL, 661, 1, 1, NULL, 21),
(623, 121072, NULL, 'مصطفى حنكول  حلب', NULL, NULL, 662, 1, 1, NULL, 21),
(624, 121073, NULL, 'المهندس مازن برو  قديم', NULL, NULL, 663, 1, 1, NULL, 21),
(625, 121074, NULL, 'سفيان نصيرات  قديم', NULL, NULL, 664, 1, 1, NULL, 21),
(626, 121138, NULL, 'محمد خير عرفات  حمص  قديم', NULL, NULL, 665, 1, 1, NULL, 11),
(627, 121075, NULL, 'خليل البردان  درعا  قديم', NULL, NULL, 666, 1, 1, NULL, 21),
(628, 121076, NULL, 'ابراهيم رستناوي قديم', NULL, NULL, 667, 1, 1, NULL, 21),
(629, 121077, NULL, 'كمال الزعبي  قديم', NULL, NULL, 668, 1, 1, NULL, 21),
(630, 121078, NULL, 'قتيبة حاصود  قديم', NULL, NULL, 669, 1, 1, NULL, 21),
(631, 121079, NULL, 'معاذ برمو  قديم', NULL, NULL, 670, 1, 1, NULL, 21),
(632, 121080, NULL, 'يامن ياسين  معر شحور  قديم', NULL, NULL, 671, 1, 1, NULL, 21),
(633, 121081, NULL, 'قاسم مفعلاني  قديم  درعا', NULL, NULL, 672, 1, 1, NULL, 21),
(634, 121082, NULL, 'احمد حاج علي  قديم', NULL, NULL, 673, 1, 1, NULL, 21),
(635, 121083, NULL, 'احمد خضر  قديم', NULL, NULL, 674, 1, 1, NULL, 21),
(636, 121084, NULL, 'مجد سلوم  الصفصافية  قديم', NULL, NULL, 675, 1, 1, NULL, 21),
(637, 121085, NULL, 'ايهاب مهنا قديم ', NULL, NULL, 676, 1, 1, NULL, 21),
(638, 121086, NULL, 'مصطفى الصواف  الكسوة', NULL, NULL, 677, 1, 1, NULL, 21),
(639, 121087, NULL, 'المهندس نور الدين علي  قديم', NULL, NULL, 678, 1, 1, NULL, 21),
(640, 121088, NULL, 'محمد خريبة  قديم', NULL, NULL, 679, 1, 1, NULL, 21),
(641, 121139, NULL, 'د. محمد نور الدين العساف  دير حافر  حلب  قديم', NULL, NULL, 680, 1, 1, NULL, 11),
(642, 121140, NULL, 'حافظ العلي  حمص قديم', NULL, NULL, 682, 1, 1, NULL, 11),
(643, 121089, NULL, 'محمد رحمون ( حميد )  بانياس', NULL, NULL, 683, 1, 1, NULL, 21),
(644, 121090, NULL, 'المهندس احمد امين  قديم', NULL, NULL, 685, 1, 1, NULL, 21),
(645, 121091, NULL, 'مياد سلوم  حرده قديم', NULL, NULL, 686, 1, 1, NULL, 21),
(646, 121092, NULL, 'محمد زهير أبو جيب  دوما  قديم', NULL, NULL, 687, 1, 1, NULL, 21),
(647, 121093, NULL, 'المهندس عصام ديب  قديم', NULL, NULL, 688, 1, 1, NULL, 21),
(648, 121094, NULL, 'عماد ابو يزبك  السويداء', NULL, NULL, 689, 1, 1, NULL, 21),
(649, 121095, NULL, 'ضاهر عبد النبي  الصبورة', NULL, NULL, 690, 1, 1, NULL, 21),
(650, 121096, NULL, 'فراس حسين  الخراب  قديم', NULL, NULL, 691, 1, 1, NULL, 21),
(651, 121141, NULL, 'جهاد بريجاوي  قديم', NULL, NULL, 692, 1, 1, NULL, 11),
(652, 121097, NULL, 'محمود ابو نقطة  قديم', NULL, NULL, 693, 1, 1, NULL, 21),
(653, 121098, NULL, 'خليل عبد الفتاح  الكسوة', NULL, NULL, 694, 1, 1, NULL, 21),
(654, 121099, NULL, 'م. محمود طباش  منبج', NULL, NULL, 695, 1, 1, NULL, 21),
(655, 121100, NULL, 'د. حيدر شاهين  قديم', NULL, NULL, 696, 1, 1, NULL, 11),
(656, 121101, NULL, 'علي الحمادي  الطبقة', NULL, NULL, 697, 1, 1, NULL, 11),
(657, 121102, NULL, 'قاسم وفا  ضمير  قديم', NULL, NULL, 698, 1, 1, NULL, 11),
(658, 121103, NULL, 'بلال صالح بركات  القامشلي', NULL, NULL, 699, 1, 1, NULL, 11),
(659, 121104, NULL, 'حمادي الايوب ( ابو مشهود )  منبج', NULL, NULL, 700, 1, 1, NULL, 11),
(660, 121105, NULL, 'جمعة عمو  راس العين', NULL, NULL, 701, 1, 1, NULL, 11),
(661, 121106, NULL, 'عيسى عيسى  حريصون', NULL, NULL, 702, 1, 1, NULL, 11),
(662, 121107, NULL, 'سامر اللحام الغوطة  قديم ', NULL, NULL, 703, 1, 1, NULL, 11),
(663, 121108, NULL, 'جهاد حمود  قديم', NULL, NULL, 704, 1, 1, NULL, 11),
(664, 121109, NULL, 'اسماعيل العيسى ( الهواش )', NULL, NULL, 705, 1, 1, NULL, 11),
(665, 121110, NULL, 'العامرة المنطقة الشرقية  بذور', NULL, NULL, 706, 1, 1, NULL, 11),
(666, 121111, NULL, 'احمد اسماعيل  قديم', NULL, NULL, 707, 1, 1, NULL, 11);
INSERT INTO `persons` (`id`, `code`, `name_en`, `name_ar`, `email`, `phone_number`, `account_id`, `person_type_id`, `active`, `sorting`, `delegate_id`) VALUES
(667, 121142, NULL, 'عبد الحليم الجنيدي قديم', NULL, NULL, 708, 1, 1, NULL, 11),
(668, 121112, NULL, 'العامرة المنطقة الشرقية  متفرقات', NULL, NULL, 709, 1, 1, NULL, 11),
(669, 121113, NULL, 'نبيل عيشات  قديم', NULL, NULL, 710, 1, 1, NULL, 11),
(670, 121114, NULL, 'كامل موسى  الخراب  بانياس', NULL, NULL, 711, 1, 1, NULL, 11),
(671, 121115, NULL, 'حسين العلاوي  قديم', NULL, NULL, 712, 1, 1, NULL, 11),
(672, 121116, NULL, 'احمد صبحي قديم', NULL, NULL, 713, 1, 1, NULL, 11),
(673, 121117, NULL, 'حسام خريبة  قديم', NULL, NULL, 714, 1, 1, NULL, 11),
(674, 121118, NULL, 'احمد عبيد قديم', NULL, NULL, 715, 1, 1, NULL, 11),
(675, 121119, NULL, 'محمد كامل الزعبي قديم', NULL, NULL, 716, 1, 1, NULL, 11),
(676, 121120, NULL, 'محمد الزعبي  قديم', NULL, NULL, 717, 1, 1, NULL, 11),
(677, 121121, NULL, 'اسامة اسماعيل  بانياس  قديم', NULL, NULL, 718, 1, 1, NULL, 11),
(678, 121122, NULL, 'محمد الاحمد كفر هود قديم', NULL, NULL, 719, 1, 1, NULL, 11),
(679, 121143, NULL, 'د. عبد اللطيف العساف  كويرس  حلب  قديم', NULL, NULL, 720, 1, 1, NULL, 11),
(680, 121123, NULL, 'مجيد النوفل  درعا', NULL, NULL, 721, 1, 1, NULL, 11),
(681, 121144, NULL, 'احمد ابو غازي النوفل  قديم', NULL, NULL, 722, 1, 1, NULL, 11),
(682, 121124, NULL, 'سالم النجار  قديم', NULL, NULL, 723, 1, 1, NULL, 11),
(683, 121125, NULL, 'محمود سليمان  درعا', NULL, NULL, 724, 1, 1, NULL, 11),
(684, 121145, NULL, 'بشار نصير  ازرع  قديم', NULL, NULL, 725, 1, 1, NULL, 11),
(685, 121126, NULL, 'محمد الصفوري  قديم', NULL, NULL, 726, 1, 1, NULL, 11),
(686, 121127, NULL, 'احمد السعدي  قديم', NULL, NULL, 727, 1, 1, NULL, 11),
(687, 121146, NULL, 'خالد اسماعيل  الزهراوية  قديم', NULL, NULL, 728, 1, 1, NULL, 11),
(688, 121128, NULL, 'موسى البيطاري  قديم', NULL, NULL, 729, 1, 1, NULL, 11),
(689, 121129, NULL, 'علاء الشبلي  سوق الهال  قديم', NULL, NULL, 730, 1, 1, NULL, 11),
(690, 121130, NULL, 'العامرة المنطقة الشرقية  جل', NULL, NULL, 731, 1, 1, NULL, 11),
(691, 121131, NULL, 'العامرة المنطقة الشرقية  بودرة', NULL, NULL, 732, 1, 1, NULL, 11),
(692, 121132, NULL, 'م. علي نصر الله  سوق الهال', NULL, NULL, 733, 1, 1, NULL, 11),
(693, 121147, NULL, 'طارق قطف قديم ', NULL, NULL, 734, 1, 1, NULL, 11),
(694, 121133, NULL, 'احمد حوراني  قديم', NULL, NULL, 735, 1, 1, NULL, 11),
(695, 121134, NULL, 'فايز ابو نعيم  قديم', NULL, NULL, 736, 1, 1, NULL, 11),
(696, 121148, NULL, 'محمد سالم زكريا قديم', NULL, NULL, 737, 1, 1, NULL, 11),
(697, 121135, NULL, 'المهندس علي عباس  قديم', NULL, NULL, 738, 1, 1, NULL, 11),
(698, 121136, NULL, 'مجد السلوم  الصفصافية', NULL, NULL, 739, 1, 1, NULL, 11),
(699, 121137, NULL, 'علي الصبح ( ربيع الخليل )  القنية', NULL, NULL, 740, 1, 1, NULL, 11),
(700, 121138, NULL, 'توفيق المصري  حماه  قديم', NULL, NULL, 741, 1, 1, NULL, 11),
(701, 121139, NULL, 'عبد العزيز المحمد  جركيس', NULL, NULL, 742, 1, 1, NULL, 11),
(702, 121149, NULL, 'محمد السعدي جديد', NULL, NULL, 743, 1, 1, NULL, 11),
(703, 121150, NULL, 'مروان الشبلي جديد', NULL, NULL, 744, 1, 1, NULL, 11),
(704, 20102, NULL, 'عمر', NULL, '0933333', 753, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_type`
--

CREATE TABLE `person_type` (
  `id` int NOT NULL,
  `name_en` varchar(1000) DEFAULT NULL,
  `name_ar` varchar(1000) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `account_name` varchar(1000) DEFAULT NULL,
  `received_amount` decimal(10,0) DEFAULT NULL,
  `paid_amount` decimal(10,0) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rotate_data_result`
--

CREATE TABLE `rotate_data_result` (
  `id` int NOT NULL,
  `rotate_date` date DEFAULT NULL,
  `profit_and_loss` double DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` int NOT NULL,
  `description_en` varchar(3000) DEFAULT NULL,
  `description_ar` varchar(3000) DEFAULT NULL,
  `keywords_en` varchar(3000) DEFAULT NULL,
  `keywords_ar` varchar(3000) DEFAULT NULL,
  `author_en` varchar(3000) DEFAULT NULL,
  `author_ar` varchar(3000) DEFAULT NULL,
  `title_ar` varchar(3000) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `title_en` varchar(300) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `image` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `social_media` (
  `id` int NOT NULL,
  `title_en` varchar(200) DEFAULT NULL,
  `title_ar` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `sorting` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `statistics_setting` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statistics_setting`
--

INSERT INTO `statistics_setting` (`id`, `name`, `value`) VALUES
(1, 'طريقة العرض', '1'),
(2, 'الحسابات', '15,16,17,22,35');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int NOT NULL,
  `code` int NOT NULL,
  `p_code` varchar(50) NOT NULL,
  `voucher_type_id` int NOT NULL,
  `debit` int NOT NULL,
  `credit` int NOT NULL,
  `delegate_id` int DEFAULT NULL,
  `staff_id` int NOT NULL,
  `narration` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `currency_id` int NOT NULL,
  `amount` decimal(50,2) NOT NULL,
  `ex_rate` decimal(10,2) DEFAULT NULL,
  `equalizer` decimal(60,2) DEFAULT NULL,
  `opposite` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `sorting` int DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `delete_by` int NOT NULL DEFAULT '0',
  `delete_action` varchar(20) DEFAULT NULL,
  `rotate_year` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `p_code`, `voucher_type_id`, `debit`, `credit`, `delegate_id`, `staff_id`, `narration`, `date`, `currency_id`, `amount`, `ex_rate`, `equalizer`, `opposite`, `active`, `sorting`, `create_at`, `create_by`, `delete_at`, `delete_by`, `delete_action`, `rotate_year`) VALUES
(1, 1, 'IV-1', 4, 0, 63, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '12941.26', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(2, 2, 'IV-2', 4, 0, 613, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '700.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(3, 3, 'IV-3', 4, 0, 614, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '40.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(4, 4, 'IV-4', 4, 615, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '15.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(5, 5, 'IV-5', 4, 616, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '28.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(6, 6, 'IV-6', 4, 202, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '40.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(7, 7, 'IV-7', 4, 391, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '45.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(8, 8, 'IV-8', 4, 617, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '59.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(9, 9, 'IV-9', 4, 618, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '72.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(10, 10, 'IV-10', 4, 619, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '75.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(11, 11, 'IV-11', 4, 620, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '82.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(12, 12, 'IV-12', 4, 621, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '85.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(13, 13, 'IV-13', 4, 622, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '96.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(14, 14, 'IV-14', 4, 146, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '119.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(15, 15, 'IV-15', 4, 623, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '120.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(16, 16, 'IV-16', 4, 624, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '122.15', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(17, 17, 'IV-17', 4, 625, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '128.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(18, 18, 'IV-18', 4, 626, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '130.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(19, 19, 'IV-19', 4, 627, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '138.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(20, 20, 'IV-20', 4, 628, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '139.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(21, 21, 'IV-21', 4, 629, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '149.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(22, 22, 'IV-22', 4, 630, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '152.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(23, 23, 'IV-23', 4, 631, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '156.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(24, 24, 'IV-24', 4, 632, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '156.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(25, 25, 'IV-25', 4, 633, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '156.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(26, 26, 'IV-26', 4, 634, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '160.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(27, 27, 'IV-27', 4, 635, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '165.85', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(28, 28, 'IV-28', 4, 636, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '176.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(29, 29, 'IV-29', 4, 637, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '187.90', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(30, 30, 'IV-30', 4, 137, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '200.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(31, 31, 'IV-31', 4, 152, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '200.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(32, 32, 'IV-32', 4, 638, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '203.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(33, 33, 'IV-33', 4, 110, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '205.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(34, 34, 'IV-34', 4, 639, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '214.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(35, 35, 'IV-35', 4, 408, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '216.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(36, 36, 'IV-36', 4, 116, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '240.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(37, 37, 'IV-37', 4, 640, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '240.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(38, 38, 'IV-38', 4, 641, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '241.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(39, 39, 'IV-39', 4, 642, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '248.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(40, 40, 'IV-40', 4, 135, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '260.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(41, 41, 'IV-41', 4, 643, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '264.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(42, 42, 'IV-42', 4, 112, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '270.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(43, 43, 'IV-43', 4, 644, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '270.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(44, 44, 'IV-44', 4, 645, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '288.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(45, 45, 'IV-45', 4, 646, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '309.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(46, 46, 'IV-46', 4, 647, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '310.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(47, 47, 'IV-47', 4, 648, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '313.90', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(48, 48, 'IV-48', 4, 89, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '322.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(49, 49, 'IV-49', 4, 649, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '330.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(50, 50, 'IV-50', 4, 232, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '335.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(51, 51, 'IV-51', 4, 650, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '350.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(52, 52, 'IV-52', 4, 651, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '350.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(53, 53, 'IV-53', 4, 652, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '361.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(54, 54, 'IV-54', 4, 653, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '382.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(55, 55, 'IV-55', 4, 654, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '420.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(56, 56, 'IV-56', 4, 655, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '421.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(57, 57, 'IV-57', 4, 656, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '447.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(58, 58, 'IV-58', 4, 151, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '472.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(59, 59, 'IV-59', 4, 346, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '541.80', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(60, 60, 'IV-60', 4, 657, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '580.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(61, 61, 'IV-61', 4, 658, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '643.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(62, 62, 'IV-62', 4, 70, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '700.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(63, 63, 'IV-63', 4, 659, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '703.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(64, 64, 'IV-64', 4, 155, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '720.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(65, 65, 'IV-65', 4, 660, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '721.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(66, 66, 'IV-66', 4, 661, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '730.10', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(67, 67, 'IV-67', 4, 662, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '734.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(68, 68, 'IV-68', 4, 663, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '735.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(69, 69, 'IV-69', 4, 104, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '739.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(70, 70, 'IV-70', 4, 664, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '760.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(71, 71, 'IV-71', 4, 665, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '779.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(72, 72, 'IV-72', 4, 666, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '791.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(73, 73, 'IV-73', 4, 667, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '801.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(74, 74, 'IV-74', 4, 668, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '810.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(75, 75, 'IV-75', 4, 405, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '821.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(76, 76, 'IV-76', 4, 413, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '900.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(77, 77, 'IV-77', 4, 385, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '910.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(78, 78, 'IV-78', 4, 669, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '934.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(79, 79, 'IV-79', 4, 670, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '971.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(80, 80, 'IV-80', 4, 671, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1000.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(81, 81, 'IV-81', 4, 672, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1138.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(82, 82, 'IV-82', 4, 673, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1249.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(83, 83, 'IV-83', 4, 674, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1275.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(84, 84, 'IV-84', 4, 675, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1278.30', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(85, 85, 'IV-85', 4, 676, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1424.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(86, 86, 'IV-86', 4, 677, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1440.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(87, 87, 'IV-87', 4, 678, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1488.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(88, 88, 'IV-88', 4, 679, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1499.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(89, 89, 'IV-89', 4, 680, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1525.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(90, 90, 'IV-90', 4, 141, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1544.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(91, 91, 'IV-91', 4, 681, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1550.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(92, 92, 'IV-92', 4, 682, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1576.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(93, 93, 'IV-93', 4, 131, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1611.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(94, 94, 'IV-94', 4, 683, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1626.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(95, 95, 'IV-95', 4, 684, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1678.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(96, 96, 'IV-96', 4, 129, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1709.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(97, 97, 'IV-97', 4, 685, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1780.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(98, 98, 'IV-98', 4, 686, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1826.20', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(99, 99, 'IV-99', 4, 687, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1827.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(100, 100, 'IV-100', 4, 688, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1860.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(101, 101, 'IV-101', 4, 689, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1876.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(102, 102, 'IV-102', 4, 690, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1919.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(103, 103, 'IV-103', 4, 526, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1956.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(104, 104, 'IV-104', 4, 691, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1970.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(105, 105, 'IV-105', 4, 85, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '1975.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(106, 106, 'IV-106', 4, 40, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(107, 107, 'IV-107', 4, 69, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(108, 108, 'IV-108', 4, 119, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2025.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(109, 109, 'IV-109', 4, 231, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2040.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(110, 110, 'IV-110', 4, 692, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2042.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(111, 111, 'IV-111', 4, 96, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2072.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(112, 112, 'IV-112', 4, 693, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2188.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(113, 113, 'IV-113', 4, 694, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2257.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(114, 114, 'IV-114', 4, 695, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2300.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(115, 115, 'IV-115', 4, 696, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2497.45', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(116, 116, 'IV-116', 4, 697, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2530.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(117, 117, 'IV-117', 4, 698, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2530.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(118, 118, 'IV-118', 4, 699, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2547.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(119, 119, 'IV-119', 4, 700, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2590.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(120, 120, 'IV-120', 4, 701, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2711.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(121, 121, 'IV-121', 4, 702, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2731.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(122, 122, 'IV-122', 4, 703, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2769.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(123, 123, 'IV-123', 4, 704, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2955.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(124, 124, 'IV-124', 4, 705, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(125, 125, 'IV-125', 4, 403, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3040.35', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(126, 126, 'IV-126', 4, 706, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3071.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(127, 127, 'IV-127', 4, 707, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3090.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(128, 128, 'IV-128', 4, 48, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3316.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(129, 129, 'IV-129', 4, 708, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3353.75', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(130, 130, 'IV-130', 4, 363, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3472.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(131, 131, 'IV-131', 4, 709, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3481.60', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(132, 132, 'IV-132', 4, 710, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3494.85', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(133, 133, 'IV-133', 4, 711, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3653.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(134, 134, 'IV-134', 4, 712, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3698.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(135, 135, 'IV-135', 4, 527, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3792.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(136, 136, 'IV-136', 4, 713, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3891.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(137, 137, 'IV-137', 4, 714, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4128.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(138, 138, 'IV-138', 4, 130, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4240.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(139, 139, 'IV-139', 4, 715, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4517.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(140, 140, 'IV-140', 4, 716, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4621.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(141, 141, 'IV-141', 4, 717, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4684.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(142, 142, 'IV-142', 4, 718, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4750.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(143, 143, 'IV-143', 4, 719, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '4768.90', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(144, 144, 'IV-144', 4, 720, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '5280.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(145, 145, 'IV-145', 4, 721, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '5291.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(146, 146, 'IV-146', 4, 722, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '5442.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(147, 147, 'IV-147', 4, 723, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '6101.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(148, 148, 'IV-148', 4, 84, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '6242.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(149, 149, 'IV-149', 4, 724, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '6588.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(150, 150, 'IV-150', 4, 725, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '6670.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(151, 151, 'IV-151', 4, 726, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '6784.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(152, 152, 'IV-152', 4, 727, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '7081.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(153, 153, 'IV-153', 4, 728, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '7568.75', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(154, 154, 'IV-154', 4, 729, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '8448.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(155, 155, 'IV-155', 4, 730, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '9417.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(156, 156, 'IV-156', 4, 731, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '9872.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(157, 157, 'IV-157', 4, 100, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '10178.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(158, 158, 'IV-158', 4, 732, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '10394.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(159, 159, 'IV-159', 4, 733, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '11739.80', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(160, 160, 'IV-160', 4, 734, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '15331.75', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(161, 161, 'IV-161', 4, 735, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '15724.51', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(162, 162, 'IV-162', 4, 736, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '17000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(163, 163, 'IV-163', 4, 221, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '17191.50', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(164, 164, 'IV-164', 4, 737, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '18456.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(165, 165, 'IV-165', 4, 738, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '19185.08', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(166, 166, 'IV-166', 4, 739, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '34000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(167, 167, 'IV-167', 4, 740, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '35687.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(168, 168, 'IV-168', 4, 741, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '71734.02', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(169, 169, 'IV-169', 4, 307, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '75600.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(170, 170, 'IV-170', 4, 742, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '225500.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(171, 171, 'IV-171', 4, 743, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '306250.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(172, 172, 'IV-172', 4, 744, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '420000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(173, 173, 'IV-173', 4, 19, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '1419000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(174, 174, 'IV-174', 4, 20, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '30806475.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(175, 175, 'IV-175', 4, 0, 21, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '172000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(176, 176, 'IV-176', 4, 22, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '4978000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(177, 177, 'IV-177', 4, 23, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '227100.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(178, 178, 'IV-178', 4, 24, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '0.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(179, 179, 'IV-179', 4, 25, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '159000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(180, 180, 'IV-180', 4, 0, 26, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '10548500.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(181, 181, 'IV-181', 4, 27, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '3482300.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(182, 182, 'IV-182', 4, 745, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '917252.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(183, 183, 'IV-183', 4, 746, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '87700.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(184, 184, 'IV-184', 4, 747, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 1, '500000.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(185, 185, 'IV-185', 4, 20, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '100.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(186, 186, 'IV-186', 4, 22, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '2076.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(187, 187, 'IV-187', 4, 23, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '500.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(188, 188, 'IV-188', 4, 27, 0, NULL, 1, 'سند افتتاحي', '2021-11-17', 2, '3100.00', NULL, NULL, NULL, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(189, 1, 'RV-1', 1, 26, 562, 21, 21, 'دفعة على الحساب (1725000)', '2021-11-21', 2, '500.00', '3450.00', '500.00', 2, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(190, 2, 'RV-2', 1, 26, 539, 21, 21, 'دفعة على الحساب (562000)', '2021-11-14', 2, '163.00', '3450.00', '163.00', 2, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(191, 3, 'RV-3', 1, 26, 563, 21, 21, 'ا.قبض 355/10 من نبهان النبهان ترصيد حساب (378000)', '2021-11-14', 2, '214.00', '3450.00', '214.00', 2, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(192, 4, 'RV-4', 1, 26, 564, 21, 21, 'ا.قبض 356/10 من هيثم هلول ترصيد حساب (7762000)', '2021-11-14', 2, '2250.00', '3450.00', '2250.00', 2, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(193, 5, 'RV-5', 1, 26, 564, 21, 21, 'ا.قبض 356/10 من هيثم هلول ترصيد حساب (7762000)', '2021-11-14', 2, '2250.00', '3450.00', '2250.00', 2, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(194, 1, 'PV-1', 2, 29, 26, 21, 21, 'بنزين 25 ليتر بسعر 750 ل.س', '2021-11-07', 1, '19000.00', '1.00', '19000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(195, 2, 'PV-2', 2, 29, 26, 21, 21, 'بنزين 10 ليتر بسعر 4000 ل.س', '2021-11-10', 1, '40000.00', '1.00', '40000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(196, 3, 'PV-3', 2, 30, 26, 21, 21, 'اجار نقل من عدرا الى حلب', '2021-11-10', 1, '75000.00', '1.00', '75000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(197, 4, 'PV-4', 2, 30, 26, 21, 21, 'اجار نقل من حلب الى مستودع تل عرن', '2021-11-10', 1, '40000.00', '1.00', '40000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(198, 5, 'PV-5', 2, 30, 26, 21, 21, 'عمال تحميل وتنزيل', '2021-11-10', 1, '8000.00', '1.00', '8000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(199, 6, 'PV-6', 2, 29, 26, 21, 21, 'بنزين 25 ليتر بسعر 750 ل.س', '2021-11-12', 1, '19000.00', '1.00', '19000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(200, 7, 'PV-7', 2, 19, 26, 21, 21, 'دفعة الى ايمن النجار سلمت في سوق الهال', '2021-11-14', 1, '8800000.00', '1.00', '8800000.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(201, 8, 'PV-8', 2, 31, 26, 21, 21, 'حوالة بريدية', '2021-11-07', 1, '1500.00', '1.00', '1500.00', 1, 1, NULL, '2021-12-13 18:59:39', 0, NULL, 0, NULL, NULL),
(202, 6, 'RV-6', 1, 26, 540, 21, 21, 'ا.قبض 359/10 من عبد اللطيف العساف دفعة على الحساب ', '2021-12-07', 1, '6524000.00', '1.00', '6524000.00', 1, 1, NULL, '2021-12-14 11:07:31', 21, NULL, 0, NULL, NULL),
(203, 7, 'RV-7', 1, 26, 662, 21, 21, 'ا.قبض 358/10 من مصطفى حنكول دفعة على الحساب (27600', '2021-12-02', 1, '2760000.00', '3450.00', '800.00', 2, 1, NULL, '2021-12-14 11:12:07', 21, NULL, 0, NULL, NULL),
(204, 8, 'RV-8', 1, 26, 562, 21, 21, 'ا.قبض 360/10 من مصطفى حنكول دفعة على الحساب', '2021-12-09', 2, '300.00', '2300.00', '300.00', 2, 1, NULL, '2021-12-14 11:12:59', 21, NULL, 0, NULL, NULL),
(205, 6, 'RV-6-80-edited', 1, 26, 540, 21, 21, 'ا.قبض 359/10 من عبد اللطيف العساف دفعة على الحساب', '2021-12-07', 1, '6524000.00', '3450.00', '1891.01', 2, 1, NULL, '2021-12-14 11:07:31', 21, '2021-12-14 11:13:45', 21, 'edit', NULL),
(206, 9, 'RV-9', 1, 26, 537, 21, 21, 'وثيقة شحن 423/10', '2021-10-03', 1, '0.00', '3450.00', '54.20', 2, 1, NULL, '2021-12-15 12:41:11', 21, NULL, 0, NULL, NULL),
(207, 9, 'RV-9', 1, 26, 537, 21, 21, 'وثيقة شحن 423/10', '2021-10-03', 1, '187000.00', '3450.00', '54.20', 2, 1, NULL, '2021-12-15 12:41:11', 21, '2022-03-21 08:51:31', 21, 'edit', NULL),
(208, 10, 'RV-10', 1, 26, 531, 21, 21, 'ا.قبض 715/11 ثمن وثيقة الشحن رقم 734', '2014-09-12', 2, '56.00', '3900.00', '56.00', 2, 1, NULL, '2022-03-23 10:48:55', 21, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

CREATE TABLE `voucher_types` (
  `id` int NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `active` tinyint NOT NULL,
  `sorting` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `name_ar`, `name_en`, `prefix`, `active`, `sorting`) VALUES
(1, 'سند قبض', 'receipt voucher', 'RV-', 1, NULL),
(2, 'سند دفع', 'payment voucher', 'PV-', 1, NULL),
(3, 'سند تحويل', 'transfer voucher', 'TV-', 1, NULL),
(4, 'سند افتتاحي', 'initial voucher', 'IV-', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills_files`
--
ALTER TABLE `bills_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_item`
--
ALTER TABLE `bill_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_type`
--
ALTER TABLE `bill_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing_accounts_types`
--
ALTER TABLE `closing_accounts_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_apicustom`
--
ALTER TABLE `cms_apicustom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_apikey`
--
ALTER TABLE `cms_apikey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_dashboard`
--
ALTER TABLE `cms_dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_email_queues`
--
ALTER TABLE `cms_email_queues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_email_templates`
--
ALTER TABLE `cms_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_logs`
--
ALTER TABLE `cms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_menus`
--
ALTER TABLE `cms_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_menus_privileges`
--
ALTER TABLE `cms_menus_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_moduls`
--
ALTER TABLE `cms_moduls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_notifications`
--
ALTER TABLE `cms_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_privileges`
--
ALTER TABLE `cms_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_privileges_roles`
--
ALTER TABLE `cms_privileges_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_statistic_components`
--
ALTER TABLE `cms_statistic_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users_old`
--
ALTER TABLE `cms_users_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_history`
--
ALTER TABLE `currency_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delegates`
--
ALTER TABLE `delegates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_receiver`
--
ALTER TABLE `email_receiver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entry_base`
--
ALTER TABLE `entry_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files_vouchers`
--
ALTER TABLE `files_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_field`
--
ALTER TABLE `form_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_model`
--
ALTER TABLE `image_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_type_id`
--
ALTER TABLE `inventory_type_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_tracking`
--
ALTER TABLE `item_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_units`
--
ALTER TABLE `item_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_type`
--
ALTER TABLE `person_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotate_data_result`
--
ALTER TABLE `rotate_data_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistics_setting`
--
ALTER TABLE `statistics_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_types`
--
ALTER TABLE `voucher_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=771;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bills_files`
--
ALTER TABLE `bills_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bill_item`
--
ALTER TABLE `bill_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill_type`
--
ALTER TABLE `bill_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_apicustom`
--
ALTER TABLE `cms_apicustom`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_apikey`
--
ALTER TABLE `cms_apikey`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_dashboard`
--
ALTER TABLE `cms_dashboard`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_email_queues`
--
ALTER TABLE `cms_email_queues`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_email_templates`
--
ALTER TABLE `cms_email_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_logs`
--
ALTER TABLE `cms_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cms_menus`
--
ALTER TABLE `cms_menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `cms_menus_privileges`
--
ALTER TABLE `cms_menus_privileges`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=550;

--
-- AUTO_INCREMENT for table `cms_moduls`
--
ALTER TABLE `cms_moduls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `cms_notifications`
--
ALTER TABLE `cms_notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_privileges`
--
ALTER TABLE `cms_privileges`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_privileges_roles`
--
ALTER TABLE `cms_privileges_roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cms_statistics`
--
ALTER TABLE `cms_statistics`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_statistic_components`
--
ALTER TABLE `cms_statistic_components`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cms_users_old`
--
ALTER TABLE `cms_users_old`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency_history`
--
ALTER TABLE `currency_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delegates`
--
ALTER TABLE `delegates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_receiver`
--
ALTER TABLE `email_receiver`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `entry_base`
--
ALTER TABLE `entry_base`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files_vouchers`
--
ALTER TABLE `files_vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_field`
--
ALTER TABLE `form_field`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `image_model`
--
ALTER TABLE `image_model`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventory_type_id`
--
ALTER TABLE `inventory_type_id`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `item_tracking`
--
ALTER TABLE `item_tracking`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;

--
-- AUTO_INCREMENT for table `item_units`
--
ALTER TABLE `item_units`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;

--
-- AUTO_INCREMENT for table `person_type`
--
ALTER TABLE `person_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotate_data_result`
--
ALTER TABLE `rotate_data_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `statistics_setting`
--
ALTER TABLE `statistics_setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `voucher_types`
--
ALTER TABLE `voucher_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
