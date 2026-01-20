-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2026 at 05:43 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u756254243_bharatstock`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_core_values`
--

CREATE TABLE `about_core_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_core_values`
--

INSERT INTO `about_core_values` (`id`, `section_id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 1, '<i class=\"fa-solid fa-shield\"></i>', 'Responsibility', 'Every recommendation is shared with user protection and regulatory compliance in mind.', 0, 1, '2026-01-09 06:26:44', '2026-01-09 06:50:29'),
(5, 1, '<i class=\"fa-solid fa-bullseye\"></i>', 'Accuracy', 'Insights are backed by market research — never by speculation.', 0, 1, '2026-01-09 06:27:01', '2026-01-09 06:50:57'),
(6, 1, '<i class=\"fa-solid fa-layer-group\"></i>', 'Transparency', 'Users always know what they’re getting — no hidden agendas, no unrealistic claims.', 0, 1, '2026-01-09 06:27:15', '2026-01-09 06:51:53'),
(7, 1, '<i class=\"fa-solid fa-globe\"></i>', 'Continuous Learning', 'The market evolves — and so do we, improving our research and communication every day.', 0, 1, '2026-01-09 06:27:31', '2026-01-09 06:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `about_core_value_sections`
--

CREATE TABLE `about_core_value_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_core_value_sections`
--

INSERT INTO `about_core_value_sections` (`id`, `badge`, `title`, `subtitle`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'about', 'Core values', NULL, 'The foundation of our approach\r\nto research and responsibility.', 1, 1, '2025-12-13 04:20:43', '2025-12-13 04:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `about_mission_values`
--

CREATE TABLE `about_mission_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `mission_text` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_mission_values`
--

INSERT INTO `about_mission_values` (`id`, `badge`, `title`, `mission_text`, `short_description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mission', 'Our Mission', 'To empower retail investors with reliable market insights that help them make informed and responsible trading decisions.', 'Simple and trusted stock research', 1, 1, '2025-12-13 04:08:41', '2026-01-09 06:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `about_why_platform_contents`
--

CREATE TABLE `about_why_platform_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_why_platform_contents`
--

INSERT INTO `about_why_platform_contents` (`id`, `section_id`, `content`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(26, 1, '<p>We saw this struggle every day.</p><p>So, we built a platform that focuses on what truly matters:</p><p><br></p><ul><li>Solid research</li><li>Clear communication</li><li>Timely updates</li><li>Responsible guidance</li></ul><p><br></p><p>Not hype.</p><p> Not promises.</p><p> Just insights backed by work that happens quietly behind the scenes so you can make decisions with confidence.</p><h3><strong>Our Goal is Simple</strong></h3><p>Help you understand the market better than yesterday.</p>', 0, 1, '2026-01-09 06:30:48', '2026-01-09 06:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `about_why_platform_sections`
--

CREATE TABLE `about_why_platform_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `badge` varchar(150) DEFAULT NULL,
  `heading` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `subheading` varchar(200) DEFAULT NULL,
  `closing_text` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_why_platform_sections`
--

INSERT INTO `about_why_platform_sections` (`id`, `badge`, `heading`, `image`, `subheading`, `closing_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'about', 'The stock market is full of information — but not all of it is useful. Most retail investors feel lost trying to separate noise from knowledge.', NULL, 'WHY WE BUILT THIS PLATFORM', NULL, 0, 1, '2025-12-13 04:35:53', '2025-12-13 06:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `content_json` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `reading_time` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_for` timestamp NULL DEFAULT NULL,
  `view_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `like_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `share_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `canonical_url` varchar(255) DEFAULT NULL,
  `table_of_contents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`table_of_contents`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `short_description`, `content`, `content_json`, `meta_title`, `meta_description`, `meta_keywords`, `reading_time`, `is_featured`, `status`, `published_at`, `scheduled_for`, `view_count`, `like_count`, `share_count`, `canonical_url`, `table_of_contents`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Esse ut et earum lab', 'esse-ut-et-earum-lab', NULL, '<pre>\r\n&copy;the new <strong>provision </strong><em>help</em></pre>', NULL, 'Dolores consequatur ad illo et non', 'Molestiae tempor dolor optio deleniti perferendis', NULL, NULL, 0, 'draft', NULL, NULL, 0, 0, 0, NULL, NULL, '2025-12-08 00:45:43', '2025-12-05 05:55:55', '2025-12-08 00:45:43'),
(2, 1, '5 Key Metrics Every Investor Should Know Before Picking a Stock', 'Stock Market', 'Stock market insights are actionable intelligence derived from analyzing market data, trends, and company fundamentals to make informed investment decisions.', '<p><s>newly content</s> <em>edited </em>by the <em><strong>content text editor</strong></em></p>', NULL, '\"Meta (META) Stock: AI Success Driving Record Rally.', 'Perspiciatis aliquam qui animi in fugit', '\"Soluta id aut est ac\"', 92, 1, 'published', '2025-09-22 11:45:00', NULL, 11, 0, 0, 'https://www.wiqyzyqel.com', NULL, NULL, '2025-12-07 22:28:27', '2026-01-09 08:21:03'),
(3, 1, 'Rupee holds steady against US Dollar amid mixed market signals', 'rupee-holds-steady-against-us-dollar-amid-mixed-market-signals', 'Currency traders monitor crude oil prices and FII activity closely', '<h1><strong>Understanding the Numbers</strong></h1>\r\n\r\n<p>Knowing what to measure is essential when you&#39;re growing a product. Metrics like churn, lifetime value, and customer acquisition cost offer powerful insights into the health of your business. Without these numbers, decisions are just guesses.</p>\r\n\r\n<h1><strong>The Metrics That Matter</strong></h1>\r\n\r\n<p>While there are many metrics to choose from, not all carry equal weight. Prioritize user engagement, conversion rates, and feature usage to truly understand how your product delivers value. These indicators guide you toward meaningful action.</p>\r\n\r\n<h1><strong>Applying the Insights</strong></h1>\r\n\r\n<p>Tracking metrics is only half the equation&mdash;what you do with them matters more. Use your data to validate ideas, improve user experiences, and spot areas of opportunity. Regular reviews lead to smarter decisions and more focused growth.</p>\r\n\r\n<h2>Bharat Stock Market Research</h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3>&nbsp;</h3>', NULL, 'Rupee holds steady against US Dollar amid mixed market signa', 'Rupee holds steady  against US Dollar amid mixed market signa', '\"Rupee holds steady\"', 5, 1, 'published', '2025-12-08 06:30:00', NULL, 33, 0, 0, 'https://example.com/my-first-blog', NULL, NULL, '2025-12-08 01:00:52', '2026-01-09 13:19:59'),
(4, 1, 'Market opens higher as global cues remain positive', 'market-opens-higher-as-global-cues-remain-positive', 'Buying interest seen in banking and IT stocks during early trade', '<h1><strong>Understanding the Numbers</strong></h1>\r\n\r\n<h3 style=\"color:#aaaaaa;font-style:italic;\">Knowing what to measure is essential when you&#39;re growing a product. Metrics like churn, lifetime value, and customer acquisition cost offer powerful insights into the health of your business. Without these numbers, decisions are just guesses.</h3>\r\n\r\n<h1><strong>The Metrics That Matter</strong></h1>\r\n\r\n<h3 style=\"color:#aaaaaa;font-style:italic;\">While there are many metrics to choose from, not all carry equal weight. Prioritize user engagement, conversion rates, and feature usage to truly understand how your product delivers value. These indicators guide you toward meaningful action.</h3>\r\n\r\n<h1><strong>Applying the Insights</strong></h1>\r\n\r\n<h3 style=\"color:#aaaaaa;font-style:italic;\">Tracking metrics is only half the equation&mdash;what you do with them matters more. Use your data to validate ideas, improve user experiences, and spot areas of opportunity. Regular reviews lead to smarter decisions and more focused growth.</h3>\r\n\r\n<h2>Bharat Stock Market Research</h2>\r\n\r\n<p>&nbsp;</p>', NULL, 'Market Opens higher as global cues remain positive', 'Buying interest seen in banking and IT stocks during early trade', '\"Market Opens\"', 1, 1, 'published', '2026-01-09 13:43:00', NULL, 7, 0, 0, NULL, NULL, NULL, '2025-12-31 14:41:53', '2026-01-09 08:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Stock Market Insights', 'stock-market-insights', '2025-12-05 05:45:36', '2025-12-05 05:45:36'),
(2, 'test', 'test', '2025-12-05 05:49:18', '2025-12-05 05:49:18'),
(3, 'test new', 'test-new', '2025-12-13 02:41:23', '2025-12-13 02:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('bharatstockmarketresearch-cache-angel_feed', 's:182:\"eyJhbGciOiJIUzUxMiJ9.eyJ1c2VybmFtZSI6Ik43NTUxNiIsImlhdCI6MTc2ODM5MjI2NCwiZXhwIjoxNzY4NDc4NjY0fQ.9EqhZiy34kdTsQynlKAPBr9nEuEvIAzppCIz3ymiKWokIlf6d4M0F0TYO3SbFwdEGf8LeNjI_clMoN7pJSSPrg\";', 1768395564),
('bharatstockmarketresearch-cache-angel_jwt', 's:1254:\"eyJhbGciOiJIUzUxMiJ9.eyJ1c2VybmFtZSI6Ik43NTUxNiIsInJvbGVzIjowLCJ1c2VydHlwZSI6IlVTRVIiLCJ0b2tlbiI6ImV5SmhiR2NpT2lKU1V6STFOaUlzSW5SNWNDSTZJa3BYVkNKOS5leUoxYzJWeVgzUjVjR1VpT2lKamJHbGxiblFpTENKMGIydGxibDkwZVhCbElqb2lkSEpoWkdWZllXTmpaWE56WDNSdmEyVnVJaXdpWjIxZmFXUWlPallzSW5OdmRYSmpaU0k2SWpNaUxDSmtaWFpwWTJWZmFXUWlPaUpsTTJSbU1XRmxOeTAxWVRSaExUTm1OVEl0T0dJMU55MDRZelUxWkdJME5XRmhZV0VpTENKcmFXUWlPaUowY21Ga1pWOXJaWGxmZGpJaUxDSnZiVzVsYldGdVlXZGxjbWxrSWpvMkxDSndjbTlrZFdOMGN5STZleUprWlcxaGRDSTZleUp6ZEdGMGRYTWlPaUpoWTNScGRtVWlmU3dpYldZaU9uc2ljM1JoZEhWeklqb2lZV04wYVhabEluMTlMQ0pwYzNNaU9pSjBjbUZrWlY5c2IyZHBibDl6WlhKMmFXTmxJaXdpYzNWaUlqb2lUamMxTlRFMklpd2laWGh3SWpveE56WTRORGM0TmpZMExDSnVZbVlpT2pFM05qZ3pPVEl3T0RRc0ltbGhkQ0k2TVRjMk9ETTVNakE0TkN3aWFuUnBJam9pWWpRMllUWTNNRGd0Tm1aa01TMDBNRFV6TFdJell6VXROR0V6TlRGak1ERmpaV1ZoSWl3aVZHOXJaVzRpT2lJaWZRLlhkWVdwZHY2UzljWlZrdl91NThIdGRLU0tFUmV2Q2ZhNUZsMnBPVzBTNGpMc0J2Q1JyY3ZkdUVRckM3R21sNlJoLXpaN3FuNmV6a1c5bzFqQ1VUOGF3VnVVSnN4aURLeGg0VHRqeHVSY0Q2WmNFOEdsRDhWOUd1ajZ6MkFPUmcwWDNSaVhFN2I0VGNRR1RiMmxoTXdoMXpzQmRoaDZ2Rnc4bEljWU41R2tBRSIsIkFQSS1LRVkiOiJVb3FxMmhvWSIsIlgtT0xELUFQSS1LRVkiOnRydWUsImlhdCI6MTc2ODM5MjI2NCwiZXhwIjoxNzY4NDE1NDAwfQ.rbH11lwB18l40CCCBnUl6FZJQNj_R7xUvBju220QDSsDOR-2SpgZT4PVmcW-kBLK4XaBirSCDuwkHldtciHiJg\";', 1768395564);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `from_role` enum('admin','user') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `from_user_id`, `to_user_id`, `message`, `is_read`, `from_role`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'hello', 1, 'user', '2025-12-26 04:37:26', '2025-12-26 04:37:38'),
(2, 1, 1, 'new live test', 1, 'user', '2025-12-29 13:11:12', '2025-12-29 13:11:15'),
(3, 27, 1, 'hi', 1, 'user', '2025-12-30 14:13:06', '2026-01-02 07:35:29'),
(4, 1, 1, 'test new', 1, 'user', '2026-01-02 07:33:33', '2026-01-02 07:35:31'),
(5, 1, 1, 'test', 1, 'user', '2026-01-03 13:05:26', '2026-01-03 13:05:29'),
(6, 1, 1, 'hello user..', 1, 'admin', '2026-01-03 13:05:41', '2026-01-03 13:05:49'),
(7, 1, 1, 'HELLO', 1, 'user', '2026-01-12 02:42:06', '2026-01-12 02:42:38'),
(8, 1, 27, 'JFLDSFLSJFSKLJFLKS', 0, 'admin', '2026-01-12 02:42:55', '2026-01-12 02:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `email`, `phone`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'infometawish.ai@gmail.com', '9876543210', 'sagun arcade 7th floor office 1st near apna sweets,\r\nvijay nagar, \r\nindore', 1, '2025-12-15 23:13:51', '2026-01-08 04:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `download_app_section`
--

CREATE TABLE `download_app_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_key` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `download_app_section`
--

INSERT INTO `download_app_section` (`id`, `page_key`, `title`, `heading`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Download Our App', 'Trade Smarter', 'Get insights on the go', 1, '2025-12-15 06:57:48', '2026-01-09 07:18:17'),
(2, 'about', 'Get the app', 'Still waiting to feel confident in the market?', 'Download the app and start getting insights that help you take action.', 1, '2025-12-15 06:59:59', '2025-12-15 07:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_type` varchar(255) NOT NULL,
  `page_slug` varchar(255) DEFAULT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `page_type`, `page_slug`, `question`, `answer`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'blog', NULL, 'How to analysis the trade.', 'The basic use to trade in the Bharat Stock Market Research helps to you.', 0, 1, '2025-12-12 23:04:56', '2025-12-15 01:49:58'),
(2, 'Service', NULL, 'What does this platform provide?', 'The platform provides stock recommendations, alerts, dashboards, and real-time market insights.', 1, 0, '2025-12-12 23:19:40', '2025-12-12 23:40:19'),
(5, 'Service', NULL, 'Do I need to complete KYC before accessing recommendations?', 'Yes, regulatory guidelines require every user to complete KYC for subscription activation.', 1, 0, '2025-12-12 23:41:49', '2025-12-12 23:41:49'),
(6, 'Service', NULL, 'What types of recommendations do you offer?', 'We provide intraday, short-term, medium-term, futures, and options-based research.', 1, 0, '2025-12-12 23:41:49', '2025-12-12 23:41:49'),
(7, 'Service', NULL, 'How do I receive updates when targets change?', 'Alerts are immediately delivered through the dashboard and notification system.', 1, 0, '2025-12-12 23:41:49', '2025-12-12 23:41:49'),
(8, 'Service', NULL, 'Does this platform guarantee returns? (Mandatory risk clarification)', 'No platform can guarantee returns. All recommendations come with inherent market risks.', 1, 0, '2025-12-12 23:41:49', '2025-12-12 23:41:49'),
(9, 'Service', NULL, 'test', 'test', 1, 0, '2025-12-13 03:33:17', '2025-12-13 03:33:17'),
(10, 'Service', NULL, 'test2', 'test2', 1, 0, '2025-12-13 03:33:17', '2025-12-13 03:33:17'),
(12, 'home', NULL, 'What does this platform provide?', 'This platform provides research-based stock market recommendations along with structured analysis, defined entry levels, targets, and risk parameters. It is designed to help investors make informed decisions using well-researched market insights.', 1, 0, '2025-12-15 01:36:26', '2026-01-09 07:05:12'),
(13, 'home', NULL, 'Do I need to complete KYC before accessing recommendations?', 'Yes. Completing KYC is mandatory before accessing any paid research recommendations. This ensures regulatory compliance and helps maintain transparency and investor protection as per SEBI guidelines.', 1, 0, '2025-12-15 01:36:53', '2026-01-09 07:05:20'),
(15, 'blog', 'blog', 'What is your platform?', 'We provide stock market research.', 1, 1, '2025-12-16 00:30:01', '2025-12-16 00:30:01'),
(17, 'home', NULL, 'What types of recommendations do you offer?', 'We offer equity research recommendations including short-term, positional, and medium-term investment ideas. Each recommendation is supported by research rationale, entry price, target levels, and risk management guidelines.', 1, 0, '2026-01-08 16:39:22', '2026-01-09 07:05:27'),
(18, 'home', NULL, 'How do I receive updates when targets or stop-loss levels change?', 'All updates, including target revisions, stop-loss changes, and exits, are communicated through platform notifications and dashboard updates. This ensures timely information without relying on external channels.', 1, 0, '2026-01-09 07:04:21', '2026-01-09 07:05:33'),
(19, 'home', NULL, 'Does this platform guarantee returns?', 'No. This platform does not guarantee any returns or profits. Stock market investments are subject to market risks, and past performance is not indicative of future results. Users are advised to invest based on their own risk assessment and financial suitability.', 1, 0, '2026-01-09 07:04:42', '2026-01-09 07:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `footer_brand_settings`
--

CREATE TABLE `footer_brand_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon_svg` longtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_brand_settings`
--

INSERT INTO `footer_brand_settings` (`id`, `title`, `icon_svg`, `description`, `subtitle`, `content`, `note`, `button_text`, `button_link`, `image`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Bharat Stock Market Research', '<svg width=\"28\" height=\"21\" viewBox=\"0 0 28 21\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M26.1244 21.0003C27.3531 18.8721 28 16.4578 28 14.0003C28 11.5428 27.3531 9.1286 26.1244 7.00033C24.8956 4.87206 23.1283 3.10473 21 1.87598C18.8717 0.64722 16.4575 0.000332078 14 0.000332343C11.5425 0.000332317 9.12827 0.64722 7 1.87598C4.87173 3.10473 3.1044 4.87206 1.87565 7.00033C0.646892 9.1286 3.69251e-06 11.5428 3.7701e-06 14.0003C4.90459e-06 16.4578 0.646893 18.8721 1.87565 21.0003L14 14.0003L26.1244 21.0003Z\" fill=\"#004AFF\"/>\r\n</svg>', NULL, 'Save Money, Time and Efforts', NULL, NULL, NULL, NULL, NULL, 1, 1, '2025-12-12 03:39:21', '2025-12-12 04:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `footer_columns`
--

CREATE TABLE `footer_columns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_columns`
--

INSERT INTO `footer_columns` (`id`, `title`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(9, 'USEFUL LINKS', 0, 1, '2025-12-11 03:00:31', '2026-01-12 05:28:50'),
(10, 'LEGAL & COMPLIANCE', 2, 1, '2025-12-11 03:06:22', '2026-01-12 05:28:50'),
(11, 'CUSTOMER SUPPORT', 1, 1, '2025-12-11 03:07:22', '2026-01-12 05:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `footer_column_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `footer_column_id`, `label`, `url`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(11, 9, 'Home', '/', 0, 1, '2025-12-11 03:06:34', '2026-01-12 05:27:13'),
(12, 9, 'About Us', '/about', 1, 1, '2025-12-11 03:06:45', '2026-01-12 05:27:18'),
(13, 10, 'Terms & Services', '/legal#terms-conditions', 3, 1, '2025-12-11 03:07:12', '2026-01-12 05:25:00'),
(14, 9, 'Contact Us', '/contact', 7, 1, '2025-12-11 04:11:04', '2026-01-12 05:27:13'),
(15, 10, 'Privacy Policy', '/legal#privacy-policy', 2, 1, '2025-12-11 04:17:42', '2026-01-12 05:25:00'),
(16, 10, 'Refund Policy', '/legal#refund-policy', 5, 1, '2025-12-11 11:03:47', '2026-01-12 05:25:00'),
(17, 9, 'Blogs', '/newsblogs', 5, 1, '2025-12-12 04:26:11', '2026-01-12 05:27:13'),
(18, 11, 'FAQ', '/faq', 1, 1, '2025-12-12 04:43:38', '2025-12-12 04:43:38'),
(19, 11, 'Help Center', '/helpcenter', 2, 1, '2025-12-12 04:43:58', '2025-12-12 04:43:58'),
(21, 11, 'Report an issue', '/reportissue', 3, 1, '2025-12-12 04:46:08', '2025-12-12 04:46:08'),
(24, 10, 'SEBI Disclouser', '/', 0, 1, '2026-01-12 05:22:01', '2026-01-12 05:25:00'),
(25, 10, 'Disclamer', '/', 1, 1, '2026-01-12 05:22:16', '2026-01-12 05:25:00'),
(26, 10, 'Risk Warnings', '/', 4, 1, '2026-01-12 05:22:46', '2026-01-12 05:25:00'),
(27, 10, 'Complaint Board', '/', 6, 1, '2026-01-12 05:23:10', '2026-01-12 05:25:00'),
(28, 10, 'Grevience Redressal / Escalation Matrix', '/', 7, 1, '2026-01-12 05:23:43', '2026-01-12 05:25:00'),
(29, 10, 'Investor Charter', '/', 8, 1, '2026-01-12 05:24:04', '2026-01-12 05:25:00'),
(30, 10, 'Complaint Redressal', '/', 9, 1, '2026-01-12 05:24:33', '2026-01-12 05:25:00'),
(31, 9, 'Plans', '/', 4, 1, '2026-01-12 05:26:00', '2026-01-12 05:27:13'),
(32, 9, 'Calculator', '/', 6, 1, '2026-01-12 05:26:17', '2026-01-12 05:27:13'),
(33, 9, 'Our Services', '/', 2, 1, '2026-01-12 05:27:00', '2026-01-12 05:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `email`, `address`, `phone`, `copyright_text`, `created_at`, `updated_at`) VALUES
(1, 'namitarathore05071992@gmail.com', 'Name: Bharat Stock Market Research\r\n\r\nProprietor: Namita Rathore\r\n\r\nType of Registration: Proprietorship\r\n\r\nSEBI Reg. No: INH000023728\r\n\r\nBSE Enlistment No: 6838\r\n\r\nValidity: 31 October 2025  - 30 October 2030\r\n\r\n\r\nAddress: 223, Qila Chawni,Near Holi Chowk Ward No. 47, Rampur Road, Bareilly India', '+919457296893', '© 2025 Bharat Stock Market Research', '2025-12-11 01:47:04', '2026-01-06 17:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `footer_social_links`
--

CREATE TABLE `footer_social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_social_links`
--

INSERT INTO `footer_social_links` (`id`, `label`, `icon`, `url`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'facebook', 'fa-brands fa-facebook', 'https://www.facebook.com/people/Bharat-Stock-Market-Research/61582965945419/?mibextid=wwXIfr&rdid=Is38cMe5mOiIHGxT&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F15fVp2RSDb%2F%3Fmibextid%3DwwXIfr', 0, 1, '2025-12-11 01:49:20', '2026-01-06 17:02:01'),
(2, 'Twitter', 'fa-brands fa-twitter', '/twiter', 1, 1, '2025-12-11 01:54:24', '2025-12-11 04:17:04'),
(3, 'Instagram', 'fa-brands fa-instagram', '/instagram', 2, 1, '2025-12-11 02:48:22', '2025-12-11 04:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `header_menus`
--

CREATE TABLE `header_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon_svg` text DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order_no` int(11) NOT NULL,
  `show_in_header` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `header_menus`
--

INSERT INTO `header_menus` (`id`, `icon_svg`, `title`, `slug`, `link`, `order_no`, `show_in_header`, `status`, `created_at`, `updated_at`) VALUES
(1, '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"800px\" height=\"800px\" viewBox=\"0 0 1024 1024\" class=\"icon\" version=\"1.1\"><path d=\"M473.4 918.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m19.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM450.8 896l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m64.5-7.9L504 876.7l11.3-11.3 11.3 11.3-11.3 11.4z m-87.2-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m109.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-132.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m155.1-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-177.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m200.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-222.9-14.7L349 794.2l11.3-11.3 11.3 11.3-11.3 11.3z m245.5-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-268.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m290.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM315 760.3L303.7 749l11.3-11.3 11.3 11.3-11.3 11.3z m336.1-8L639.8 741l11.3-11.3 11.3 11.3-11.3 11.3z m-358.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m381.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-404-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m426.6-8L685 695.7l11.3-11.3 11.3 11.3-11.3 11.3z m-449.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m471.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-494.4-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m517.1-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-539.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m562.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-585-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m607.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-630.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m652.9-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM134 579.2l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m698.1-7.9L820.8 560l11.3-11.3 11.3 11.3-11.3 11.3z m-720.7-14.7L98.7 544l10-10 5.7 5.7 1.3-1.3 7 7-11.3 11.2z m743.3-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM131.3 534L120 522.7l11.3-11.3 11.3 11.3-11.3 11.3z m746-8L866 514.7l11.3-11.3 11.3 11.3-11.3 11.3z m-723.4-14.6L142.6 500l11.3-11.3 11.3 11.3-11.3 11.4z m746.1-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-723.5-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m724.1-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-701.4-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m678.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-656.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m633.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-611-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m588.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-565.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m543-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-520.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m497.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM312.3 353L301 341.6l11.3-11.3 11.3 11.3-11.3 11.4z m452.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-430-14.7L323.6 319l11.3-11.3 11.3 11.3-11.3 11.3z m407.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-384.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m362-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-339.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m316.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-294.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m271.5-8L663 243.2l11.3-11.3 11.3 11.3-11.3 11.3z m-248.9-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m226.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-203.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m181-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-158.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m135.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-113.2-14.7L482 160.6l11.3-11.3 11.3 11.3-11.3 11.3z m90.5-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM516 149.3L504.6 138l11.3-11.3 11.3 11.3-11.2 11.3z m45.2-8L549.9 130l11.3-11.3 11.3 11.3-11.3 11.3z m-22.6-14.6l-11.3-11.3 15.3-15.3 7.3 7.3-5.7 5.7 4 4-9.6 9.6z\" fill=\"#0A0408\"/><path d=\"M387.6 206.3h384.2v611.8H249.9v-474\" fill=\"#FFFFFF\"/><path d=\"M779.8 826.1H241.9v-482h16v466h505.9V214.3H387.6v-16h392.2z\" fill=\"#0A0408\"/><path d=\"M417.8 259.4h308.6v491.5H307.1V370.1\" fill=\"#55B7A8\"/><path d=\"M391.8 206.3v137.8H254z\" fill=\"#FFFFFF\"/><path d=\"M391.8 352.1H254c-3.2 0-6.2-1.9-7.4-4.9s-0.6-6.4 1.7-8.7l137.8-137.8c2.3-2.3 5.7-3 8.7-1.7 3 1.2 4.9 4.2 4.9 7.4v137.8c0.1 4.3-3.5 7.9-7.9 7.9z m-118.4-16h110.5V225.6L273.4 336.1zM446.4 361h175v16h-175zM396 451.2h229.6v16H396zM396 552h229.6v16H396zM396 652.7h229.6v16H396z\" fill=\"#0A0408\"/><path d=\"M542.581 76.06l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M542.6 158L496 111.4l46.6-46.6 46.6 46.6-46.6 46.6z m-24-46.6l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M911.621 445.039l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M911.6 527.1L865 480.4l46.6-46.6 46.6 46.6-46.6 46.7z m-24-46.7l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M109.97 508.62l35.356 35.356-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M110 590.6L63.4 544l46.6-46.6 46.6 46.6-46.6 46.6zM86 544l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M479.081 877.67l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M479 959.6L432.4 913l46.6-46.6 46.6 46.6-46.6 46.6zM455 913l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/></svg>', 'Home', 'home', '/', 1, 1, 1, '2025-12-10 05:08:20', '2026-01-14 06:30:49'),
(2, '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"800px\" height=\"800px\" viewBox=\"0 0 1024 1024\" class=\"icon\" version=\"1.1\"><path d=\"M473.4 918.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m19.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM450.8 896l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m64.5-7.9L504 876.7l11.3-11.3 11.3 11.3-11.3 11.4z m-87.2-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m109.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-132.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m155.1-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-177.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m200.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-222.9-14.7L349 794.2l11.3-11.3 11.3 11.3-11.3 11.3z m245.5-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-268.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m290.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM315 760.3L303.7 749l11.3-11.3 11.3 11.3-11.3 11.3z m336.1-8L639.8 741l11.3-11.3 11.3 11.3-11.3 11.3z m-358.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m381.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-404-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m426.6-8L685 695.7l11.3-11.3 11.3 11.3-11.3 11.3z m-449.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m471.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-494.4-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m517.1-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-539.7-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m562.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-585-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m607.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-630.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m652.9-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM134 579.2l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m698.1-7.9L820.8 560l11.3-11.3 11.3 11.3-11.3 11.3z m-720.7-14.7L98.7 544l10-10 5.7 5.7 1.3-1.3 7 7-11.3 11.2z m743.3-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM131.3 534L120 522.7l11.3-11.3 11.3 11.3-11.3 11.3z m746-8L866 514.7l11.3-11.3 11.3 11.3-11.3 11.3z m-723.4-14.6L142.6 500l11.3-11.3 11.3 11.3-11.3 11.4z m746.1-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-723.5-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m724.1-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-701.4-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m678.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-656.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m633.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-611-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m588.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-565.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m543-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-520.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m497.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM312.3 353L301 341.6l11.3-11.3 11.3 11.3-11.3 11.4z m452.6-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-430-14.7L323.6 319l11.3-11.3 11.3 11.3-11.3 11.3z m407.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-384.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m362-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-339.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m316.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-294.2-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m271.5-8L663 243.2l11.3-11.3 11.3 11.3-11.3 11.3z m-248.9-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m226.3-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-203.6-14.7l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m181-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-158.4-14.6l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m135.8-8l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3z m-113.2-14.7L482 160.6l11.3-11.3 11.3 11.3-11.3 11.3z m90.5-7.9l-11.3-11.3 11.3-11.3 11.3 11.3-11.3 11.3zM516 149.3L504.6 138l11.3-11.3 11.3 11.3-11.2 11.3z m45.2-8L549.9 130l11.3-11.3 11.3 11.3-11.3 11.3z m-22.6-14.6l-11.3-11.3 15.3-15.3 7.3 7.3-5.7 5.7 4 4-9.6 9.6z\" fill=\"#0A0408\"/><path d=\"M387.6 206.3h384.2v611.8H249.9v-474\" fill=\"#FFFFFF\"/><path d=\"M779.8 826.1H241.9v-482h16v466h505.9V214.3H387.6v-16h392.2z\" fill=\"#0A0408\"/><path d=\"M417.8 259.4h308.6v491.5H307.1V370.1\" fill=\"#55B7A8\"/><path d=\"M391.8 206.3v137.8H254z\" fill=\"#FFFFFF\"/><path d=\"M391.8 352.1H254c-3.2 0-6.2-1.9-7.4-4.9s-0.6-6.4 1.7-8.7l137.8-137.8c2.3-2.3 5.7-3 8.7-1.7 3 1.2 4.9 4.2 4.9 7.4v137.8c0.1 4.3-3.5 7.9-7.9 7.9z m-118.4-16h110.5V225.6L273.4 336.1zM446.4 361h175v16h-175zM396 451.2h229.6v16H396zM396 552h229.6v16H396zM396 652.7h229.6v16H396z\" fill=\"#0A0408\"/><path d=\"M542.581 76.06l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M542.6 158L496 111.4l46.6-46.6 46.6 46.6-46.6 46.6z m-24-46.6l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M911.621 445.039l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M911.6 527.1L865 480.4l46.6-46.6 46.6 46.6-46.6 46.7z m-24-46.7l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M109.97 508.62l35.356 35.356-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M110 590.6L63.4 544l46.6-46.6 46.6 46.6-46.6 46.6zM86 544l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/><path d=\"M479.081 877.67l35.355 35.355-35.355 35.355-35.355-35.355z\" fill=\"#DC444A\"/><path d=\"M479 959.6L432.4 913l46.6-46.6 46.6 46.6-46.6 46.6zM455 913l24 24 24-24-24-24-24 24z\" fill=\"#0A0408\"/></svg>', 'About', 'about', '/about', 2, 1, 1, '2025-12-10 05:13:11', '2026-01-14 06:30:49'),
(3, NULL, 'Services', 'services', '/services', 3, 1, 1, '2025-12-10 05:48:16', '2026-01-14 06:30:49'),
(5, '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"800px\" height=\"800px\" viewBox=\"0 0 1024 1024\" class=\"icon\" version=\"1.1\"><path d=\"M906.3 583.4c-1.1 11-11.2 16.5-19.8 21.5-8 4.6-16 9.3-23.9 13.9-12.8 7.4-25.5 14.8-38.3 22.2-16 9.3-31.9 18.6-47.9 27.8-17.6 10.2-35.2 20.5-52.9 30.7-17.7 10.3-35.4 20.6-53.2 30.9-16.3 9.5-32.5 18.9-48.8 28.4-13.3 7.7-26.5 15.4-39.8 23.1-8.7 5-17.4 10.1-26.1 15.1-6.6 3.8-12.8 7.6-20.3 9.8-19.5 5.6-41.1 3.7-58.7-6.5-6.3-3.7-12.7-7.3-19-11-11.6-6.7-23.1-13.3-34.7-20-15.2-8.8-30.4-17.6-45.6-26.3-17.3-10-34.7-20-52-30-17.9-10.3-35.8-20.7-53.7-31-16.9-9.8-33.8-19.5-50.8-29.3l-43.2-24.9c-10.3-6-20.7-11.9-31-17.9-4.7-2.7-9.4-5.4-14.1-8.2-7.4-4.3-14.7-11.1-14.7-20.3 0 8.4 0 16.8-0.1 25.3 0 3-0.2 6.1 0 9.2 0.6 8.1 7 14.4 13.7 18.4 4.1 2.5 8.3 4.8 12.5 7.2 10.8 6.2 21.6 12.5 32.4 18.7 15.6 9 31.1 18 46.7 27 18.5 10.7 37.1 21.4 55.6 32.1 19.3 11.2 38.6 22.3 58 33.5 18.4 10.6 36.7 21.2 55.1 31.8 15.3 8.8 30.5 17.6 45.8 26.4 10.3 6 20.7 11.9 31 17.9 6 3.4 11.9 7.3 18.4 9.7 20.3 7.4 44.1 5.8 62.8-5.1 7.1-4.1 14.2-8.3 21.3-12.4 13.1-7.6 26.2-15.2 39.2-22.8 17.1-9.9 34.1-19.8 51.2-29.8 19.1-11.1 38.2-22.2 57.2-33.3l57.3-33.3c17.1-10 34.2-19.9 51.4-29.9 13.3-7.7 26.6-15.4 39.9-23.2 7.3-4.3 14.7-8.5 22-12.8 2.2-1.3 4.5-2.6 6.6-4.1 5.6-4.2 10-10 10.1-17.3 0.1-3.7 0-7.3 0-11 0-7.3 0-14.7 0.1-22 0.4 0.8 0.3 1.3 0.3 1.8-0.1 0.3 0-0.2 0 0z\" fill=\"#7A9EFD\"/><path d=\"M892 561.9c19 11 19.1 28.9 0.2 39.9L547.9 801.9c-18.9 11-49.8 11-68.8 0L132.3 601.8c-19-11-19.1-28.9-0.2-39.9l344.4-200.2c18.9-11 49.8-11 68.8 0L892 561.9z\" fill=\"#E4ECF9\"/><path d=\"M297.6 491.2c0-0.3 0.1-0.6 0.1-0.9 0-0.2 0.1-0.4 0.1-0.6 0-0.2 0.1-0.4 0.1-0.5 0.1-0.3 0.1-0.5 0.2-0.8 0-0.1 0.1-0.3 0.1-0.4l0.3-0.9c0-0.1 0.1-0.2 0.1-0.4 0.1-0.4 0.3-0.8 0.5-1.2 0 0 0-0.1 0.1-0.1 0.2-0.4 0.3-0.7 0.5-1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.6 0.5-1 0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.7 0.7-1.1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.5 0.5-0.8 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.2 0.3-0.4 0.5-0.6 0.1-0.2 0.3-0.3 0.4-0.5 0.1-0.2 0.3-0.3 0.4-0.5 0.2-0.3 0.5-0.5 0.7-0.8l0.4-0.4c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.4-0.3 0.9-0.5 1.3-0.6 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.6h-0.1c-0.2-0.1-0.4-0.2-0.5-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H299.2c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.6 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8l-0.2 0.2-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.3 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1 0 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9 0 3.4 1.2 5.8 3.1 6.9l14.8 8.6c-1.9-1.1-3.1-3.5-3.1-6.9 0-0.6 0-1.2 0.1-1.9-0.4-0.2-0.4-0.4-0.3-0.5z\" fill=\"#ACC5EA\"/><path d=\"M330.1 473.6c0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H318.1c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.4 5.4 14.8 8.6 9.4-5.4c0.4-0.2 0.7-0.4 1-0.5 0.1 0 0.2-0.1 0.3-0.1-0.1-0.1 0.1-0.1 0.3-0.2z\" fill=\"#2A2ABC\"/><path d=\"M300.5 500.5l-14.8-8.6h0.1l14.7 8.6\" fill=\"#28289E\"/><path d=\"M300.6 500.6l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.2-0.2-0.4-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M301.1 500.8l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M301.7 501l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4 0-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M302.3 501.2l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2-0.1-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M302.9 501.2l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M303.6 501.2l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0.1-0.5 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M304.4 501.2l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0-0.6 0.1-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M305.3 501l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.4 0.1-0.8 0.2-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M306.6 500.5l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.3-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M311.7 497l-14.8-8.6 1.2-1.2 14.8 8.6-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M312.9 495.8l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.4 0.4-0.7 0.7-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M313.7 494.7l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.4 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M314.4 493.7l-14.8-8.6 0.6-0.9 14.8 8.6c-0.1 0.3-0.4 0.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M315.1 492.8l-14.8-8.6 0.6-0.9 14.8 8.6c-0.3 0.3-0.5 0.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M315.6 491.9l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M316.1 491l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M316.6 490.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M317 489.2l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 1\" fill=\"#28289E\"/><path d=\"M317.4 488.2l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.2 0.3-0.3 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M317.7 487.2l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c0 0.4-0.1 0.7-0.3 1.1\" fill=\"#252594\"/><path d=\"M318.1 486.1l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M318.4 484.9l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M318.6 483.4l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1 0-0.5 0-0.9-0.1-1.4l14.8 8.6c0 0.5 0.1 0.9 0.1 1.4 0.1 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M282.6 483.6l-9.4 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6l-0.3 0.3-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.4 124.5c0 2.6 1 4.5 2.5 5.4l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-0.4-124.5c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.4-5.4-15.1-8.4z\" fill=\"#2A2ABC\"/><path d=\"M328.1 474.5c4.6-2.7 8.4-0.5 8.5 4.8l0.4 124.5c0 5.3-3.8 11.9-8.4 14.5l-40.1 23.1c-4.6 2.7-8.4 0.5-8.5-4.8l-0.4-124.5c0-5.3 3.8-11.9 8.4-14.5l9.4-5.4c0 0.5-0.1 1-0.1 1.5 0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5 0-0.5 0-0.9-0.1-1.4l9.5-5.4z\" fill=\"#4040FF\"/><path d=\"M306.6 469.1l9.3 5.3-18.3 17.9-4-2.3 9.1-20.9z\" fill=\"#ACC5EA\"/><path d=\"M308.1 475c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5c-5.9 3.4-10.7 0.7-10.7-6.1s4.7-15 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M424.6 361.7c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H413.2c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.2 0-0.1-0.1 0-0.1z\" fill=\"#2A2ABC\"/><path d=\"M395.6 387l-14.8-8.6h0.1l14.7 8.6c0.1 0 0.1 0 0 0\" fill=\"#28289E\"/><path d=\"M395.7 387l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.1-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M396.2 387.3l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M396.8 387.5l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M397.4 387.6l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M398.1 387.7l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M398.8 387.7l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.6 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M399.6 387.6l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.1-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M400.5 387.4l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.5 0.1-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M401.8 387l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.2-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M406.8 383.4l-14.8-8.6 1.2-1.2 14.8 8.6c-0.4 0.4-0.8 0.9-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M408 382.2l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M408.9 381.1l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.5 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M409.6 380.2l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M410.2 379.3l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M410.8 378.4l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.4 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M411.3 377.5l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.2-0.4 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M411.7 376.5l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.2 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M412.1 375.6l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M412.5 374.6l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M412.9 373.6l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c-0.1 0.4-0.2 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M413.2 372.5l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M413.5 371.3l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M413.8 369.8l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M377.7 371.5l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6-0.1 0.1-0.2 0.2-0.3 0.4l-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.6 198.2c0 2.6 0.9 4.5 2.5 5.4l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-9.9-5.7 9.9 5.7-0.8-198.2c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-14.9-8.5z\" fill=\"#2A2ABC\"/><path d=\"M423.3 362.3c4.6-2.7 8.4-0.5 8.5 4.8l0.6 198.2c0 5.3-3.8 11.9-8.4 14.5L383.8 603c-4.6 2.7-8.4 0.5-8.5-4.8l-0.5-198.2c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5l9.4-5.4z\" fill=\"#4040FF\"/><path d=\"M398.6 358.7l9.6 5.4-13.9 17.1-7.9-4.7z\" fill=\"#ACC5EA\"/><path d=\"M403.1 361.3c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5c-5.9 3.4-10.7 0.7-10.7-6.1 0.1-6.8 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M395.9 352l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H394.1c-0.2 0-0.4-0.1-0.6-0.1H392c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8l-0.2 0.2-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.6-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.3 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1 0 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9v0.3l14.8 8.6v-0.3c0-0.6 0-1.2 0.1-1.9 0-0.2 0-0.3 0.1-0.5 0-0.3 0.1-0.6 0.1-0.9 0-0.2 0.1-0.4 0.1-0.6 0-0.2 0.1-0.4 0.1-0.5 0.1-0.3 0.1-0.5 0.2-0.8 0-0.1 0.1-0.3 0.1-0.4l0.3-0.9c0-0.1 0.1-0.2 0.1-0.4 0.1-0.4 0.3-0.8 0.5-1.2 0 0 0-0.1 0.1-0.1 0.2-0.3 0.3-0.7 0.5-1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.6 0.5-1 0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.7 0.7-1.1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.4-0.5 0.5-0.8 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.2 0.3-0.4 0.5-0.6 0.1-0.2 0.3-0.3 0.4-0.5 0.1-0.2 0.3-0.3 0.4-0.5 0.2-0.3 0.5-0.5 0.7-0.8l0.4-0.4c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-15.1-8.4z\" fill=\"#ACC5EA\"/><path d=\"M520 368.5c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h0.9c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H508.5c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.1 0 0 0 0.1-0.1z\" fill=\"#2A2ABC\"/><path d=\"M491 393.8l-14.8-8.6h0.1l14.7 8.6\" fill=\"#28289E\"/><path d=\"M491 393.8l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.1-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M491.6 394.1l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.3-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M492.1 394.3l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M492.7 394.4l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.1 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M493.4 394.5l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M494.1 394.5l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.5 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M494.9 394.4l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.2-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M495.8 394.2l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.4 0.1-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M497.1 393.8l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.2-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M502.2 390.2l-14.8-8.6 1.2-1.2 14.8 8.6c-0.4 0.4-0.8 0.9-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M503.3 389l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M504.2 387.9l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.4 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M504.9 387l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M505.5 386.1l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M506.1 385.1l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M506.6 384.2l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M507.1 383.3l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M507.5 382.4l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.3 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M507.9 381.4l-14.8-8.6c0.1-0.3 0.2-0.7 0.4-1l14.8 8.6c-0.2 0.4-0.3 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M508.2 380.4l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c0 0.4-0.1 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M508.6 379.3l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M508.9 378.1l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M509.1 376.6l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0.1 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M458.2 550.4L473 559c-1.5-0.9-2.5-2.7-2.5-5.4l-14.8-8.6c0.1 2.7 1 4.6 2.5 5.4zM473 378.3l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6-0.1 0.1-0.2 0.2-0.3 0.4l-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7-0.1 0.2-0.2 0.4-0.3 0.7-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.4 146.8 14.8 8.6-0.4-146.8c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-15.1-8.6z\" fill=\"#2A2ABC\"/><path d=\"M518.6 369.2c4.6-2.7 8.4-0.5 8.4 4.8l0.4 146.8c0 5.3-3.8 11.9-8.4 14.5l-40 23.2c-4.6 2.7-8.4 0.5-8.4-4.8l-0.4-146.8c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1s10.7-11.7 10.7-18.5l9.3-5.4z\" fill=\"#4040FF\"/><path d=\"M498.6 368.4c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5-10.7 0.7-10.7-6.1 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M491.4 359.1l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H489.6c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8-0.1 0.1-0.1 0.2-0.2 0.2l-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.4 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.2-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1-0.1 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9v0.2l14.8 8.4c0-0.6 0-1.2 0.1-1.8v-0.4c0-0.3 0.1-0.6 0.1-0.9 0-0.1 0-0.3 0.1-0.4v-0.2c0-0.2 0.1-0.4 0.1-0.5 0-0.2 0.1-0.3 0.1-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0.1-0.3 0.1-0.4 0-0.1 0.1-0.3 0.1-0.4 0.1-0.2 0.1-0.3 0.2-0.5 0-0.1 0.1-0.2 0.1-0.4 0-0.1 0-0.1 0.1-0.2 0.1-0.3 0.3-0.6 0.4-1 0 0 0-0.1 0.1-0.1 0.1-0.3 0.2-0.5 0.3-0.8 0-0.1 0.1-0.2 0.1-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.4 0.4-0.7 0-0.1 0.1-0.1 0.1-0.2v-0.1l0.6-0.9 0.1-0.1c0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.3 0.3-0.5 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.2-0.3 0.3-0.4 0.1-0.1 0.1-0.2 0.2-0.3l0.3-0.3c0.1-0.2 0.3-0.3 0.4-0.5l0.2-0.2 0.2-0.2c0.2-0.3 0.5-0.5 0.7-0.8 0.1-0.1 0.1-0.2 0.2-0.2l0.1-0.1c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.8z m14.8 8.6z\" fill=\"#ACC5EA\"/><path d=\"M615 189.2c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H603.6c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.2 0-0.1-0.1 0-0.1z\" fill=\"#2A2ABC\"/><path d=\"M586 214.5l-14.8-8.6h0.1l14.7 8.6c0.1 0 0.1 0 0 0\" fill=\"#28289E\"/><path d=\"M586.1 214.5l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.2-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M586.6 214.8l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M587.2 215l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M587.8 215.1l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M588.4 215.2l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M589.2 215.2l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.6 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M590 215.1l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.2-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M590.9 214.9l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.5 0.2-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M592.2 214.5l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.6 0.2-1.1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M597.2 211l-14.8-8.6 1.2-1.2 14.8 8.6-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M598.4 209.7l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M599.3 208.7l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.3 0.3-0.5 0.6-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M600 207.7l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M600.6 206.8l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M601.1 205.9l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M601.6 205l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M602.1 204.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.2-0.2 0.5-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M602.5 203.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M602.9 202.2l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.1 0.3-0.2 0.6-0.4 1\" fill=\"#262699\"/><path d=\"M603.3 201.1l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c-0.1 0.4-0.2 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M603.6 200.1l-14.8-8.6 0.3-1.2 14.8 8.6c-0.1 0.3-0.2 0.7-0.3 1.2\" fill=\"#24248F\"/><path d=\"M603.9 198.8l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M604.2 197.3l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M553.7 497.7l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-14.8-8.6c0 2.7 1 4.6 2.5 5.4z\" fill=\"#2A2ABC\"/><path d=\"M568.2 199l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6l-0.3 0.3-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.8 273.4L566 501l-0.8-273.4c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-14.8-8.6z\" fill=\"#2A2ABC\"/><path d=\"M613.6 189.9c4.6-2.7 8.4-0.5 8.5 4.8l0.8 273.4c0 5.3-3.8 11.9-8.4 14.5l-40.1 23.1c-4.6 2.7-8.4 0.5-8.5-4.8l-0.8-273.4c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5l9.4-5.3z\" fill=\"#4040FF\"/><path d=\"M593.7 189.1c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5-10.7 0.7-10.7-6.1 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M586.5 179.8l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H584.7c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1-0.1 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8-0.1 0.1-0.1 0.2-0.2 0.2l-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.4 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.2-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1-0.1 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.2-0.1 1.8l14.8 8.8v-0.1c0-0.6 0-1.2 0.1-1.9v-0.4c0-0.3 0.1-0.6 0.1-0.9 0-0.1 0-0.3 0.1-0.4v-0.2c0-0.2 0.1-0.4 0.1-0.5 0-0.2 0.1-0.3 0.1-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0.1-0.3 0.1-0.4 0-0.1 0.1-0.3 0.1-0.4 0.1-0.2 0.1-0.3 0.2-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0-0.1 0.1-0.2 0.1-0.3 0.3-0.6 0.4-1 0 0 0-0.1 0.1-0.1 0.1-0.3 0.2-0.5 0.3-0.8 0-0.1 0.1-0.2 0.1-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.4 0.4-0.7 0-0.1 0.1-0.1 0.1-0.2v-0.1l0.6-0.9 0.1-0.1c0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.3 0.3-0.5 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.2-0.3 0.3-0.4 0.1-0.1 0.1-0.2 0.2-0.3l0.3-0.3c0.1-0.2 0.3-0.3 0.4-0.5l0.2-0.2 0.2-0.2c0.2-0.3 0.5-0.5 0.7-0.8l0.2-0.2 0.1-0.1c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.7z\" fill=\"#ACC5EA\"/><path d=\"M568.2 198.9c0 0.1 0 0.1 0 0 0 0.1 0 0.1 0 0z\" fill=\"#FFFFFF\"/><path d=\"M719.2 434.3c-0.1 0-0.1 0 0 0-0.3-0.2-0.5-0.3-0.8-0.4h-0.1c-0.1 0-0.2-0.1-0.2-0.1-0.1 0-0.2-0.1-0.4-0.1-0.1 0-0.3-0.1-0.4-0.1-0.1 0-0.2 0-0.2-0.1h-0.1c-0.3 0-0.5-0.1-0.8-0.1h-1.9c-0.1 0-0.2 0.1-0.3 0.1-0.2 0-0.4 0.1-0.6 0.1-0.1 0-0.2 0-0.3 0.1-0.1 0-0.2 0.1-0.3 0.1-0.3 0.1-0.6 0.2-1 0.3-0.1 0-0.2 0.1-0.3 0.1-0.1 0-0.1 0.1-0.2 0.1-0.6 0.2-1.1 0.5-1.7 0.8L569.7 516c-0.7 0.4-1.4 0.9-2.1 1.4-0.1 0.1-0.2 0.2-0.4 0.3-0.7 0.5-1.3 1.1-1.9 1.7-0.1 0.1-0.1 0.1-0.2 0.1l-0.3 0.3c-0.3 0.3-0.6 0.6-0.9 1l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.4 0.4-0.5 0.6-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.2 0.2-0.3 0.4-0.1 0.2-0.3 0.3-0.4 0.5-0.1 0.1-0.2 0.2-0.3 0.4-0.1 0.2-0.3 0.4-0.4 0.6-0.1 0.1-0.2 0.3-0.3 0.4 0 0.1-0.1 0.1-0.1 0.2-0.2 0.4-0.5 0.8-0.7 1.1v0.1c0 0.1-0.1 0.2-0.1 0.2-0.2 0.3-0.3 0.6-0.5 0.8-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.1-0.1 0.2-0.2 0.4-0.2 0.3-0.3 0.6-0.4 0.9 0 0.1-0.1 0.1-0.1 0.2-0.2 0.4-0.3 0.8-0.5 1.2 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.2-0.2 0.4-0.2 0.6-0.1 0.2-0.1 0.3-0.1 0.5-0.1 0.2-0.1 0.4-0.2 0.6 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.4-0.2 0.6-0.1 0.2-0.1 0.5-0.2 0.7 0 0.1 0 0.2-0.1 0.2 0 0.2-0.1 0.3-0.1 0.5-0.1 0.4-0.1 0.7-0.2 1.1 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.8-0.2 1.6-0.2 2.4l0.3 93.3c0 3.2 0.9 5.7 2.3 7.3 0.5 0.5 1 1 1.6 1.4l14.8 8.6c-2.4-1.4-3.9-4.4-4-8.7l0.1-93.3c0-0.8 0.1-1.6 0.2-2.4 0-0.2 0-0.4 0.1-0.6 0.1-0.4 0.1-0.7 0.2-1.1 0-0.2 0.1-0.5 0.1-0.7 0.1-0.2 0.1-0.5 0.2-0.7 0.1-0.3 0.2-0.6 0.3-1 0.1-0.2 0.1-0.4 0.2-0.6 0.1-0.4 0.2-0.7 0.4-1.1 0.1-0.1 0.1-0.3 0.2-0.4l0.6-1.5c0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.9 0.6-1.3 0.1-0.1 0.1-0.3 0.2-0.4 0.2-0.4 0.4-0.8 0.7-1.2 0-0.1 0.1-0.2 0.1-0.2 0.3-0.5 0.6-0.9 0.9-1.4 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.3 0.4-0.6 0.7-1 0.1-0.2 0.2-0.3 0.4-0.5 0.2-0.3 0.4-0.5 0.6-0.8 0.2-0.2 0.3-0.4 0.5-0.6 0.2-0.2 0.3-0.4 0.5-0.6 0.3-0.3 0.6-0.7 0.9-1 0.1-0.2 0.3-0.3 0.4-0.4 0.6-0.6 1.3-1.2 1.9-1.7 0.1-0.1 0.2-0.2 0.4-0.3 0.7-0.5 1.4-1 2.1-1.4l139.9-80.7c0.6-0.3 1.1-0.6 1.7-0.8 0.2-0.1 0.4-0.1 0.5-0.2 0.3-0.1 0.6-0.2 1-0.3 0.2-0.1 0.4-0.1 0.6-0.2 0.2 0 0.4-0.1 0.6-0.1 0.2 0 0.5-0.1 0.7-0.1h1.5c0.3 0 0.7 0.1 1 0.1 0.1 0 0.2 0 0.2 0.1 0.3 0.1 0.5 0.1 0.7 0.2 0.1 0 0.2 0.1 0.2 0.1 0.3 0.1 0.6 0.3 0.9 0.4l-15.1-8.7z\" fill=\"#C68620\"/><path d=\"M724.3 443.8c7.5-4.3 13.6-0.9 13.6 7.7l0.3 93.3c0 8.6-6 19.1-13.5 23.4l-139.9 80.7c-7.5 4.3-13.6 0.8-13.6-7.7L571 548c0-8.6 6-19.1 13.5-23.4l139.8-80.8z\" fill=\"#FFCD2E\"/><path d=\"M692.1 531.1l-10.4-6c-0.1-0.1-0.2-0.1-0.3-0.3l10.4 6c0.1 0.2 0.2 0.3 0.3 0.3\" fill=\"#674611\"/><path d=\"M688.7 526.5l-10.4-6 3.2 4.3 10.4 6.1z\" fill=\"#E8CFAC\"/><path d=\"M691.3 491.1c1.4-0.8 2.3 0.4 1.6 2.2l-9.4 24.3c-0.3 0.9-1 1.6-1.6 2-0.6 0.4-1.2 0.4-1.6-0.1l-3.1-4.4-28.2 35.2c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.6-2.2 0.6-2.8-0.2l-8-11.2-28.1 35c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2-0.9-1.3-0.4-3.9 1.2-5.8l30.9-38.5c0.5-0.6 1.1-1.1 1.6-1.5 1.1-0.7 2.2-0.6 2.8 0.2l8 11.2 25.4-31.7-3.1-4.4c-0.7-1 0.2-3.2 1.5-4l18.9-11.1z\" fill=\"#C68620\"/><path d=\"M649.6 547.6l10.4 6 25.4-31.7-3.1-4.4-10.4-6 3.1 4.3z\" fill=\"#E8CFAC\"/><path d=\"M704 502.4l-5.3-3.1-5.1-3h-1.1c-0.1 0-0.2 0.1-0.3 0.1l-18.9 11c-0.2 0.1-0.4 0.3-0.6 0.4l-0.2 0.2-0.1 0.1c0 0.1-0.1 0.1-0.1 0.2s-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2v0.1c0 0.1-0.1 0.1-0.1 0.2s0 0.1-0.1 0.2c0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2v0.9c0 0.2 0.1 0.4 0.2 0.5l10.4 6c-0.1-0.1-0.2-0.3-0.2-0.5v-1c0.1-0.4 0.2-0.8 0.4-1.1 0.1-0.2 0.2-0.4 0.3-0.5 0.1-0.1 0.2-0.3 0.4-0.4 0.2-0.2 0.4-0.3 0.6-0.4l18.9-11c0.1-0.1 0.2-0.1 0.3-0.2h0.1c0.1 0 0.2-0.1 0.3-0.1h0.3c0.4 0.2 0.5 0.2 0.5 0.2 0.1 0 0.1 0 0 0z m-48 60.5l-8-11.2-10.4-6 8 11.2c0.1 0.2 0.3 0.4 0.5 0.5l10.4 6c-0.2-0.1-0.3-0.3-0.5-0.5z\" fill=\"#E8CFAC\"/><path d=\"M641 535.9c-0.1 0-0.1-0.1-0.2-0.1s-0.1 0-0.2-0.1h-0.7c-0.1 0-0.2 0-0.3 0.1 0 0-0.1 0-0.1 0.1h-0.2c-0.2 0.1-0.3 0.1-0.5 0.2s-0.5 0.3-0.7 0.5l-0.2 0.2-0.2 0.2-0.4 0.4-0.2 0.2-30.9 38.5 10.4 6 30.9-38.5c0.2-0.3 0.5-0.5 0.7-0.8l0.2-0.2c0.2-0.2 0.5-0.4 0.7-0.5l0.6-0.3h0.1c0.2-0.1 0.4-0.1 0.5-0.1h0.5c0.2 0 0.3 0.1 0.5 0.2l-10.3-6z\" fill=\"#E8CFAC\"/><path d=\"M605.9 576.5c-0.1 0.1-0.1 0.2-0.2 0.3v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.1-0.1 0.2s-0.1 0.2-0.1 0.3c0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.3-0.1 0.4v0.1c0 0.1 0 0.2-0.1 0.3v1.3c0.1 0.3 0.2 0.7 0.4 0.9 0.1 0.2 0.3 0.4 0.5 0.5l10.4 6c-0.2-0.1-0.4-0.3-0.5-0.5-0.2-0.3-0.3-0.6-0.4-0.9v-0.1c-0.1-0.3-0.1-0.7 0-1.1 0-0.1 0-0.3 0.1-0.4v-0.1c0.1-0.3 0.1-0.5 0.2-0.8 0.1-0.3 0.2-0.5 0.3-0.8 0.1-0.3 0.3-0.5 0.4-0.8 0.2-0.3 0.3-0.5 0.5-0.7l-10.4-6-0.1 0.1c-0.1 0.1-0.1 0.2-0.2 0.3z\" fill=\"#E8CFAC\"/><path d=\"M702.8 502.6c1.4-0.8 2.3 0.4 1.6 2.2L695 529c-0.3 0.9-1 1.6-1.6 2-0.6 0.4-1.2 0.4-1.6-0.1l-3.1-4.4-28.3 35.2c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2l-8-11.2-28.1 35c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2-0.9-1.3-0.4-3.9 1.2-5.8l30.9-38.5c0.5-0.6 1.1-1.1 1.6-1.5 1.1-0.7 2.2-0.6 2.8 0.2l8 11.2 25.4-31.7-3.1-4.4c-0.7-1 0.2-3.2 1.5-4l19-11z\" fill=\"#FFFFFF\"/></svg>', 'Blog', 'blogs', '/newsblogs', 5, 1, 1, '2025-12-10 06:10:01', '2026-01-14 06:30:49');
INSERT INTO `header_menus` (`id`, `icon_svg`, `title`, `slug`, `link`, `order_no`, `show_in_header`, `status`, `created_at`, `updated_at`) VALUES
(6, '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"800px\" height=\"800px\" viewBox=\"0 0 1024 1024\" class=\"icon\" version=\"1.1\"><path d=\"M906.3 583.4c-1.1 11-11.2 16.5-19.8 21.5-8 4.6-16 9.3-23.9 13.9-12.8 7.4-25.5 14.8-38.3 22.2-16 9.3-31.9 18.6-47.9 27.8-17.6 10.2-35.2 20.5-52.9 30.7-17.7 10.3-35.4 20.6-53.2 30.9-16.3 9.5-32.5 18.9-48.8 28.4-13.3 7.7-26.5 15.4-39.8 23.1-8.7 5-17.4 10.1-26.1 15.1-6.6 3.8-12.8 7.6-20.3 9.8-19.5 5.6-41.1 3.7-58.7-6.5-6.3-3.7-12.7-7.3-19-11-11.6-6.7-23.1-13.3-34.7-20-15.2-8.8-30.4-17.6-45.6-26.3-17.3-10-34.7-20-52-30-17.9-10.3-35.8-20.7-53.7-31-16.9-9.8-33.8-19.5-50.8-29.3l-43.2-24.9c-10.3-6-20.7-11.9-31-17.9-4.7-2.7-9.4-5.4-14.1-8.2-7.4-4.3-14.7-11.1-14.7-20.3 0 8.4 0 16.8-0.1 25.3 0 3-0.2 6.1 0 9.2 0.6 8.1 7 14.4 13.7 18.4 4.1 2.5 8.3 4.8 12.5 7.2 10.8 6.2 21.6 12.5 32.4 18.7 15.6 9 31.1 18 46.7 27 18.5 10.7 37.1 21.4 55.6 32.1 19.3 11.2 38.6 22.3 58 33.5 18.4 10.6 36.7 21.2 55.1 31.8 15.3 8.8 30.5 17.6 45.8 26.4 10.3 6 20.7 11.9 31 17.9 6 3.4 11.9 7.3 18.4 9.7 20.3 7.4 44.1 5.8 62.8-5.1 7.1-4.1 14.2-8.3 21.3-12.4 13.1-7.6 26.2-15.2 39.2-22.8 17.1-9.9 34.1-19.8 51.2-29.8 19.1-11.1 38.2-22.2 57.2-33.3l57.3-33.3c17.1-10 34.2-19.9 51.4-29.9 13.3-7.7 26.6-15.4 39.9-23.2 7.3-4.3 14.7-8.5 22-12.8 2.2-1.3 4.5-2.6 6.6-4.1 5.6-4.2 10-10 10.1-17.3 0.1-3.7 0-7.3 0-11 0-7.3 0-14.7 0.1-22 0.4 0.8 0.3 1.3 0.3 1.8-0.1 0.3 0-0.2 0 0z\" fill=\"#7A9EFD\"/><path d=\"M892 561.9c19 11 19.1 28.9 0.2 39.9L547.9 801.9c-18.9 11-49.8 11-68.8 0L132.3 601.8c-19-11-19.1-28.9-0.2-39.9l344.4-200.2c18.9-11 49.8-11 68.8 0L892 561.9z\" fill=\"#E4ECF9\"/><path d=\"M297.6 491.2c0-0.3 0.1-0.6 0.1-0.9 0-0.2 0.1-0.4 0.1-0.6 0-0.2 0.1-0.4 0.1-0.5 0.1-0.3 0.1-0.5 0.2-0.8 0-0.1 0.1-0.3 0.1-0.4l0.3-0.9c0-0.1 0.1-0.2 0.1-0.4 0.1-0.4 0.3-0.8 0.5-1.2 0 0 0-0.1 0.1-0.1 0.2-0.4 0.3-0.7 0.5-1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.6 0.5-1 0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.7 0.7-1.1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.5 0.5-0.8 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.2 0.3-0.4 0.5-0.6 0.1-0.2 0.3-0.3 0.4-0.5 0.1-0.2 0.3-0.3 0.4-0.5 0.2-0.3 0.5-0.5 0.7-0.8l0.4-0.4c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.4-0.3 0.9-0.5 1.3-0.6 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.6h-0.1c-0.2-0.1-0.4-0.2-0.5-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H299.2c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.6 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8l-0.2 0.2-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.3 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1 0 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9 0 3.4 1.2 5.8 3.1 6.9l14.8 8.6c-1.9-1.1-3.1-3.5-3.1-6.9 0-0.6 0-1.2 0.1-1.9-0.4-0.2-0.4-0.4-0.3-0.5z\" fill=\"#ACC5EA\"/><path d=\"M330.1 473.6c0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H318.1c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.4 5.4 14.8 8.6 9.4-5.4c0.4-0.2 0.7-0.4 1-0.5 0.1 0 0.2-0.1 0.3-0.1-0.1-0.1 0.1-0.1 0.3-0.2z\" fill=\"#2A2ABC\"/><path d=\"M300.5 500.5l-14.8-8.6h0.1l14.7 8.6\" fill=\"#28289E\"/><path d=\"M300.6 500.6l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.2-0.2-0.4-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M301.1 500.8l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M301.7 501l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4 0-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M302.3 501.2l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2-0.1-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M302.9 501.2l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M303.6 501.2l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0.1-0.5 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M304.4 501.2l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0-0.6 0.1-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M305.3 501l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.4 0.1-0.8 0.2-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M306.6 500.5l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.3-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M311.7 497l-14.8-8.6 1.2-1.2 14.8 8.6-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M312.9 495.8l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.4 0.4-0.7 0.7-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M313.7 494.7l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.4 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M314.4 493.7l-14.8-8.6 0.6-0.9 14.8 8.6c-0.1 0.3-0.4 0.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M315.1 492.8l-14.8-8.6 0.6-0.9 14.8 8.6c-0.3 0.3-0.5 0.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M315.6 491.9l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M316.1 491l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M316.6 490.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M317 489.2l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 1\" fill=\"#28289E\"/><path d=\"M317.4 488.2l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.2 0.3-0.3 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M317.7 487.2l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c0 0.4-0.1 0.7-0.3 1.1\" fill=\"#252594\"/><path d=\"M318.1 486.1l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M318.4 484.9l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M318.6 483.4l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1 0-0.5 0-0.9-0.1-1.4l14.8 8.6c0 0.5 0.1 0.9 0.1 1.4 0.1 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M282.6 483.6l-9.4 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6l-0.3 0.3-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.4 124.5c0 2.6 1 4.5 2.5 5.4l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-0.4-124.5c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.4-5.4-15.1-8.4z\" fill=\"#2A2ABC\"/><path d=\"M328.1 474.5c4.6-2.7 8.4-0.5 8.5 4.8l0.4 124.5c0 5.3-3.8 11.9-8.4 14.5l-40.1 23.1c-4.6 2.7-8.4 0.5-8.5-4.8l-0.4-124.5c0-5.3 3.8-11.9 8.4-14.5l9.4-5.4c0 0.5-0.1 1-0.1 1.5 0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5 0-0.5 0-0.9-0.1-1.4l9.5-5.4z\" fill=\"#4040FF\"/><path d=\"M306.6 469.1l9.3 5.3-18.3 17.9-4-2.3 9.1-20.9z\" fill=\"#ACC5EA\"/><path d=\"M308.1 475c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5c-5.9 3.4-10.7 0.7-10.7-6.1s4.7-15 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M424.6 361.7c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H413.2c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.2 0-0.1-0.1 0-0.1z\" fill=\"#2A2ABC\"/><path d=\"M395.6 387l-14.8-8.6h0.1l14.7 8.6c0.1 0 0.1 0 0 0\" fill=\"#28289E\"/><path d=\"M395.7 387l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.1-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M396.2 387.3l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M396.8 387.5l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M397.4 387.6l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M398.1 387.7l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M398.8 387.7l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.6 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M399.6 387.6l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.1-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M400.5 387.4l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.5 0.1-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M401.8 387l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.2-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M406.8 383.4l-14.8-8.6 1.2-1.2 14.8 8.6c-0.4 0.4-0.8 0.9-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M408 382.2l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M408.9 381.1l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.5 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M409.6 380.2l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M410.2 379.3l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M410.8 378.4l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.4 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M411.3 377.5l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.2-0.4 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M411.7 376.5l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.2 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M412.1 375.6l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M412.5 374.6l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M412.9 373.6l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c-0.1 0.4-0.2 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M413.2 372.5l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M413.5 371.3l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M413.8 369.8l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M377.7 371.5l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6-0.1 0.1-0.2 0.2-0.3 0.4l-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.6 198.2c0 2.6 0.9 4.5 2.5 5.4l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-9.9-5.7 9.9 5.7-0.8-198.2c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-14.9-8.5z\" fill=\"#2A2ABC\"/><path d=\"M423.3 362.3c4.6-2.7 8.4-0.5 8.5 4.8l0.6 198.2c0 5.3-3.8 11.9-8.4 14.5L383.8 603c-4.6 2.7-8.4 0.5-8.5-4.8l-0.5-198.2c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5l9.4-5.4z\" fill=\"#4040FF\"/><path d=\"M398.6 358.7l9.6 5.4-13.9 17.1-7.9-4.7z\" fill=\"#ACC5EA\"/><path d=\"M403.1 361.3c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5c-5.9 3.4-10.7 0.7-10.7-6.1 0.1-6.8 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M395.9 352l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H394.1c-0.2 0-0.4-0.1-0.6-0.1H392c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8l-0.2 0.2-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.6-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.3 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1-0.1 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1 0 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9v0.3l14.8 8.6v-0.3c0-0.6 0-1.2 0.1-1.9 0-0.2 0-0.3 0.1-0.5 0-0.3 0.1-0.6 0.1-0.9 0-0.2 0.1-0.4 0.1-0.6 0-0.2 0.1-0.4 0.1-0.5 0.1-0.3 0.1-0.5 0.2-0.8 0-0.1 0.1-0.3 0.1-0.4l0.3-0.9c0-0.1 0.1-0.2 0.1-0.4 0.1-0.4 0.3-0.8 0.5-1.2 0 0 0-0.1 0.1-0.1 0.2-0.3 0.3-0.7 0.5-1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.3-0.6 0.5-1 0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.7 0.7-1.1 0.1-0.1 0.1-0.2 0.2-0.3 0.2-0.3 0.4-0.5 0.5-0.8 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.2 0.3-0.4 0.5-0.6 0.1-0.2 0.3-0.3 0.4-0.5 0.1-0.2 0.3-0.3 0.4-0.5 0.2-0.3 0.5-0.5 0.7-0.8l0.4-0.4c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-15.1-8.4z\" fill=\"#ACC5EA\"/><path d=\"M520 368.5c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h0.9c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H508.5c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.1 0 0 0 0.1-0.1z\" fill=\"#2A2ABC\"/><path d=\"M491 393.8l-14.8-8.6h0.1l14.7 8.6\" fill=\"#28289E\"/><path d=\"M491 393.8l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.1-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M491.6 394.1l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.3-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M492.1 394.3l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M492.7 394.4l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.1 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M493.4 394.5l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M494.1 394.5l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.5 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M494.9 394.4l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.2-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M495.8 394.2l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.4 0.1-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M497.1 393.8l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.5 0.2-1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M502.2 390.2l-14.8-8.6 1.2-1.2 14.8 8.6c-0.4 0.4-0.8 0.9-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M503.3 389l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M504.2 387.9l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.2 0.4-0.4 0.7-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M504.9 387l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M505.5 386.1l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M506.1 385.1l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M506.6 384.2l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.2 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M507.1 383.3l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M507.5 382.4l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.3 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M507.9 381.4l-14.8-8.6c0.1-0.3 0.2-0.7 0.4-1l14.8 8.6c-0.2 0.4-0.3 0.7-0.4 1\" fill=\"#262699\"/><path d=\"M508.2 380.4l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c0 0.4-0.1 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M508.6 379.3l-14.8-8.6 0.3-1.2 14.8 8.6-0.3 1.2\" fill=\"#24248F\"/><path d=\"M508.9 378.1l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M509.1 376.6l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0.1 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M458.2 550.4L473 559c-1.5-0.9-2.5-2.7-2.5-5.4l-14.8-8.6c0.1 2.7 1 4.6 2.5 5.4zM473 378.3l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6-0.1 0.1-0.2 0.2-0.3 0.4l-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7-0.1 0.2-0.2 0.4-0.3 0.7-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.4 146.8 14.8 8.6-0.4-146.8c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-15.1-8.6z\" fill=\"#2A2ABC\"/><path d=\"M518.6 369.2c4.6-2.7 8.4-0.5 8.4 4.8l0.4 146.8c0 5.3-3.8 11.9-8.4 14.5l-40 23.2c-4.6 2.7-8.4 0.5-8.4-4.8l-0.4-146.8c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1s10.7-11.7 10.7-18.5l9.3-5.4z\" fill=\"#4040FF\"/><path d=\"M498.6 368.4c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5-10.7 0.7-10.7-6.1 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M491.4 359.1l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H489.6c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1 0 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8-0.1 0.1-0.1 0.2-0.2 0.2l-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.4 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.2-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1-0.1 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.3-0.1 1.9v0.2l14.8 8.4c0-0.6 0-1.2 0.1-1.8v-0.4c0-0.3 0.1-0.6 0.1-0.9 0-0.1 0-0.3 0.1-0.4v-0.2c0-0.2 0.1-0.4 0.1-0.5 0-0.2 0.1-0.3 0.1-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0.1-0.3 0.1-0.4 0-0.1 0.1-0.3 0.1-0.4 0.1-0.2 0.1-0.3 0.2-0.5 0-0.1 0.1-0.2 0.1-0.4 0-0.1 0-0.1 0.1-0.2 0.1-0.3 0.3-0.6 0.4-1 0 0 0-0.1 0.1-0.1 0.1-0.3 0.2-0.5 0.3-0.8 0-0.1 0.1-0.2 0.1-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.4 0.4-0.7 0-0.1 0.1-0.1 0.1-0.2v-0.1l0.6-0.9 0.1-0.1c0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.3 0.3-0.5 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.2-0.3 0.3-0.4 0.1-0.1 0.1-0.2 0.2-0.3l0.3-0.3c0.1-0.2 0.3-0.3 0.4-0.5l0.2-0.2 0.2-0.2c0.2-0.3 0.5-0.5 0.7-0.8 0.1-0.1 0.1-0.2 0.2-0.2l0.1-0.1c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.8z m14.8 8.6z\" fill=\"#ACC5EA\"/><path d=\"M615 189.2c0.2-0.1 0.4-0.1 0.6-0.2 0.1 0 0.3-0.1 0.4-0.1 0.1 0 0.2-0.1 0.3-0.1 0.2 0 0.3-0.1 0.4-0.1h1c0.2 0 0.4 0 0.6 0.1h0.2c0.2 0 0.3 0.1 0.5 0.1 0 0 0.1 0 0.1 0.1l0.6 0.3-14.8-8.6c-0.1-0.1-0.3-0.1-0.4-0.2h-0.1s-0.1 0-0.1-0.1c-0.1 0-0.1-0.1-0.2-0.1s-0.2 0-0.2-0.1H603.6c-0.2 0-0.3 0-0.5-0.1h-1.3c-0.1 0-0.2 0-0.3 0.1h-0.2c-0.1 0-0.1 0-0.2 0.1-0.2 0.1-0.4 0.1-0.6 0.2-0.1 0-0.1 0-0.2 0.1 0 0-0.1 0-0.1 0.1-0.3 0.1-0.7 0.3-1 0.5l-9.3 5.4 14.8 8.6 9.3-5.4c0.4-0.2 0.7-0.4 1-0.5-0.2 0-0.1-0.1 0-0.1z\" fill=\"#2A2ABC\"/><path d=\"M586 214.5l-14.8-8.6h0.1l14.7 8.6c0.1 0 0.1 0 0 0\" fill=\"#28289E\"/><path d=\"M586.1 214.5l-14.8-8.6c0.2 0.1 0.4 0.2 0.5 0.3l14.8 8.6c-0.2-0.1-0.3-0.2-0.5-0.3\" fill=\"#2929A3\"/><path d=\"M586.6 214.8l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.2l14.8 8.6c-0.2-0.1-0.4-0.2-0.6-0.2\" fill=\"#2A2AA8\"/><path d=\"M587.2 215l-14.8-8.6c0.2 0.1 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2C2CAD\"/><path d=\"M587.8 215.1l-14.8-8.6c0.2 0 0.4 0.1 0.6 0.1l14.8 8.6c-0.2 0-0.4-0.1-0.6-0.1\" fill=\"#2D2DB3\"/><path d=\"M588.4 215.2l-14.8-8.6h0.7l14.8 8.6h-0.7\" fill=\"#2E2EB8\"/><path d=\"M589.2 215.2l-14.8-8.6c0.3 0 0.5 0 0.8-0.1l14.8 8.6c-0.3 0-0.6 0.1-0.8 0.1\" fill=\"#2F2FBD\"/><path d=\"M590 215.1l-14.8-8.6c0.3 0 0.6-0.1 0.9-0.2l14.8 8.6c-0.3 0.1-0.6 0.2-0.9 0.2\" fill=\"#3131C2\"/><path d=\"M590.9 214.9l-14.8-8.6c0.4-0.1 0.8-0.3 1.3-0.4l14.8 8.6c-0.5 0.2-0.9 0.3-1.3 0.4\" fill=\"#3232C7\"/><path d=\"M592.2 214.5l-14.8-8.6c0.5-0.2 1-0.5 1.5-0.7 1.3-0.7 2.5-1.7 3.6-2.8l14.8 8.6c-1.1 1.1-2.3 2-3.6 2.8-0.6 0.2-1.1 0.5-1.5 0.7\" fill=\"#3333CC\"/><path d=\"M597.2 211l-14.8-8.6 1.2-1.2 14.8 8.6-1.2 1.2\" fill=\"#3232C7\"/><path d=\"M598.4 209.7l-14.8-8.6c0.3-0.3 0.6-0.7 0.9-1.1l14.8 8.6c-0.3 0.4-0.6 0.8-0.9 1.1\" fill=\"#3131C2\"/><path d=\"M599.3 208.7l-14.8-8.6c0.2-0.3 0.5-0.6 0.7-1l14.8 8.6c-0.3 0.3-0.5 0.6-0.7 1\" fill=\"#2F2FBD\"/><path d=\"M600 207.7l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2E2EB8\"/><path d=\"M600.6 206.8l-14.8-8.6 0.6-0.9 14.8 8.6-0.6 0.9\" fill=\"#2D2DB3\"/><path d=\"M601.1 205.9l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.5 0.9\" fill=\"#2C2CAD\"/><path d=\"M601.6 205l-14.8-8.6c0.2-0.3 0.3-0.6 0.5-0.9l14.8 8.6c-0.1 0.3-0.3 0.6-0.5 0.9\" fill=\"#2A2AA8\"/><path d=\"M602.1 204.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-0.9l14.8 8.6c-0.1 0.2-0.2 0.5-0.4 0.9\" fill=\"#2929A3\"/><path d=\"M602.5 203.1l-14.8-8.6c0.1-0.3 0.3-0.6 0.4-1l14.8 8.6c-0.1 0.4-0.2 0.7-0.4 1\" fill=\"#28289E\"/><path d=\"M602.9 202.2l-14.8-8.6c0.1-0.3 0.3-0.7 0.4-1l14.8 8.6c-0.1 0.3-0.2 0.6-0.4 1\" fill=\"#262699\"/><path d=\"M603.3 201.1l-14.8-8.6c0.1-0.4 0.2-0.7 0.3-1.1l14.8 8.6c-0.1 0.4-0.2 0.8-0.3 1.1\" fill=\"#252594\"/><path d=\"M603.6 200.1l-14.8-8.6 0.3-1.2 14.8 8.6c-0.1 0.3-0.2 0.7-0.3 1.2\" fill=\"#24248F\"/><path d=\"M603.9 198.8l-14.8-8.6 0.3-1.5 14.8 8.6-0.3 1.5\" fill=\"#23238A\"/><path d=\"M604.2 197.3l-14.8-8.6c0.1-0.7 0.1-1.4 0.1-2.1l14.8 8.6c0 0.7 0 1.4-0.1 2.1\" fill=\"#212185\"/><path d=\"M553.7 497.7l14.8 8.6c-1.5-0.9-2.5-2.7-2.5-5.4l-14.8-8.6c0 2.7 1 4.6 2.5 5.4z\" fill=\"#2A2ABC\"/><path d=\"M568.2 199l-9.3 5.4c-0.5 0.3-1.1 0.7-1.6 1.1-0.2 0.1-0.3 0.3-0.5 0.4-0.2 0.2-0.5 0.4-0.7 0.6l-0.3 0.3-0.3 0.3-0.3 0.3c-0.2 0.3-0.5 0.5-0.7 0.8-0.1 0.1-0.2 0.2-0.2 0.3 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.3 0.5-0.5 0.7-0.2 0.2-0.3 0.5-0.4 0.7v0.2l-0.3 0.6c-0.1 0.2-0.2 0.5-0.4 0.7l-0.3 0.6c-0.1 0.3-0.2 0.5-0.3 0.8-0.1 0.3-0.2 0.5-0.3 0.8 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.6-0.2 1 0 0.2-0.1 0.4-0.1 0.6 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.6-0.1 1.1-0.1 1.6l0.8 273.4L566 501l-0.8-273.4c0-0.6 0.1-1.3 0.2-1.9 0-0.1 0-0.2 0.1-0.3 0.1-0.6 0.2-1.2 0.4-1.8 0-0.1 0-0.1 0.1-0.2 0.2-0.7 0.4-1.3 0.7-2 0.3-0.7 0.6-1.3 1-2v-0.1l1.2-1.8c0-0.1 0.1-0.1 0.1-0.2l1.2-1.5 0.3-0.3c0.3-0.4 0.7-0.7 1.1-1 0.2-0.1 0.3-0.3 0.5-0.4 0.5-0.4 1-0.8 1.6-1.1l9.3-5.4-14.8-8.6z\" fill=\"#2A2ABC\"/><path d=\"M613.6 189.9c4.6-2.7 8.4-0.5 8.5 4.8l0.8 273.4c0 5.3-3.8 11.9-8.4 14.5l-40.1 23.1c-4.6 2.7-8.4 0.5-8.5-4.8l-0.8-273.4c0-5.3 3.8-11.9 8.4-14.5l9.3-5.4c0 6.8 4.8 9.5 10.7 6.1 5.9-3.4 10.7-11.7 10.7-18.5l9.4-5.3z\" fill=\"#4040FF\"/><path d=\"M593.7 189.1c5.9-3.4 10.7-0.7 10.7 6.1s-4.8 15.1-10.7 18.5-10.7 0.7-10.7-6.1 4.8-15.1 10.7-18.5z\" fill=\"#FFFFFF\"/><path d=\"M586.5 179.8l-0.6-0.3h-0.1c-0.1 0-0.1 0-0.2-0.1-0.1 0-0.2-0.1-0.3-0.1-0.1 0-0.2 0-0.3-0.1H584.7c-0.2 0-0.4-0.1-0.6-0.1h-1.5c-0.1 0-0.2 0-0.3 0.1-0.1 0-0.3 0.1-0.4 0.1-0.1 0-0.2 0-0.2 0.1-0.1 0-0.2 0.1-0.2 0.1-0.2 0.1-0.5 0.2-0.8 0.3-0.1 0-0.2 0.1-0.3 0.1-0.1 0-0.1 0.1-0.2 0.1-0.4 0.2-0.9 0.4-1.3 0.7-0.6 0.3-1.1 0.7-1.7 1.1-0.1 0.1-0.2 0.1-0.3 0.2-0.5 0.4-1 0.9-1.5 1.3l-0.1 0.1-0.2 0.2c-0.2 0.2-0.5 0.5-0.7 0.8-0.1 0.1-0.1 0.2-0.2 0.2l-0.2 0.2c-0.1 0.2-0.3 0.3-0.4 0.5l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.2-0.2 0.3-0.3 0.5-0.1 0.1-0.1 0.2-0.2 0.3l-0.1 0.1-0.6 0.9v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.2-0.2 0.4-0.4 0.7-0.1 0.1-0.1 0.2-0.2 0.3-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3-0.1 0.3-0.2 0.5-0.4 0.8 0 0 0 0.1-0.1 0.1-0.1 0.3-0.3 0.6-0.4 1 0 0.1 0 0.1-0.1 0.2 0 0.1-0.1 0.2-0.1 0.3-0.1 0.2-0.1 0.3-0.2 0.5 0 0.1-0.1 0.2-0.1 0.4 0 0.1-0.1 0.3-0.1 0.4 0 0.1 0 0.2-0.1 0.3 0 0.2-0.1 0.3-0.1 0.5s-0.1 0.4-0.1 0.5v0.2c0 0.1-0.1 0.3-0.1 0.4-0.1 0.3-0.1 0.6-0.1 0.9v0.4c-0.1 0.6-0.1 1.2-0.1 1.8l14.8 8.8v-0.1c0-0.6 0-1.2 0.1-1.9v-0.4c0-0.3 0.1-0.6 0.1-0.9 0-0.1 0-0.3 0.1-0.4v-0.2c0-0.2 0.1-0.4 0.1-0.5 0-0.2 0.1-0.3 0.1-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0.1-0.3 0.1-0.4 0-0.1 0.1-0.3 0.1-0.4 0.1-0.2 0.1-0.3 0.2-0.5 0-0.1 0.1-0.2 0.1-0.3 0-0.1 0-0.1 0.1-0.2 0.1-0.3 0.3-0.6 0.4-1 0 0 0-0.1 0.1-0.1 0.1-0.3 0.2-0.5 0.3-0.8 0-0.1 0.1-0.2 0.1-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.4 0.4-0.7 0-0.1 0.1-0.1 0.1-0.2v-0.1l0.6-0.9 0.1-0.1c0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.2 0.2-0.3 0.3-0.5 0.1-0.1 0.1-0.2 0.2-0.3 0.1-0.1 0.2-0.3 0.3-0.4 0.1-0.1 0.1-0.2 0.2-0.3l0.3-0.3c0.1-0.2 0.3-0.3 0.4-0.5l0.2-0.2 0.2-0.2c0.2-0.3 0.5-0.5 0.7-0.8l0.2-0.2 0.1-0.1c0.5-0.5 1-0.9 1.5-1.3 0.1-0.1 0.2-0.1 0.3-0.2 0.5-0.4 1.1-0.8 1.7-1.1 0.5-0.3 0.9-0.5 1.3-0.7 0.1-0.1 0.3-0.1 0.4-0.2 0.3-0.1 0.5-0.2 0.8-0.3 0.2 0 0.3-0.1 0.5-0.1 0.1 0 0.3-0.1 0.4-0.1 0.2 0 0.4-0.1 0.6-0.1h1.2c0.3 0 0.5 0.1 0.8 0.1h0.2c0.2 0 0.4 0.1 0.6 0.2 0.1 0 0.1 0 0.2 0.1 0.2 0.1 0.5 0.2 0.7 0.3l-14.8-8.7z\" fill=\"#ACC5EA\"/><path d=\"M568.2 198.9c0 0.1 0 0.1 0 0 0 0.1 0 0.1 0 0z\" fill=\"#FFFFFF\"/><path d=\"M719.2 434.3c-0.1 0-0.1 0 0 0-0.3-0.2-0.5-0.3-0.8-0.4h-0.1c-0.1 0-0.2-0.1-0.2-0.1-0.1 0-0.2-0.1-0.4-0.1-0.1 0-0.3-0.1-0.4-0.1-0.1 0-0.2 0-0.2-0.1h-0.1c-0.3 0-0.5-0.1-0.8-0.1h-1.9c-0.1 0-0.2 0.1-0.3 0.1-0.2 0-0.4 0.1-0.6 0.1-0.1 0-0.2 0-0.3 0.1-0.1 0-0.2 0.1-0.3 0.1-0.3 0.1-0.6 0.2-1 0.3-0.1 0-0.2 0.1-0.3 0.1-0.1 0-0.1 0.1-0.2 0.1-0.6 0.2-1.1 0.5-1.7 0.8L569.7 516c-0.7 0.4-1.4 0.9-2.1 1.4-0.1 0.1-0.2 0.2-0.4 0.3-0.7 0.5-1.3 1.1-1.9 1.7-0.1 0.1-0.1 0.1-0.2 0.1l-0.3 0.3c-0.3 0.3-0.6 0.6-0.9 1l-0.3 0.3c-0.1 0.1-0.1 0.2-0.2 0.3-0.2 0.2-0.4 0.4-0.5 0.6-0.1 0.1-0.2 0.3-0.3 0.4-0.1 0.1-0.2 0.2-0.3 0.4-0.1 0.2-0.3 0.3-0.4 0.5-0.1 0.1-0.2 0.2-0.3 0.4-0.1 0.2-0.3 0.4-0.4 0.6-0.1 0.1-0.2 0.3-0.3 0.4 0 0.1-0.1 0.1-0.1 0.2-0.2 0.4-0.5 0.8-0.7 1.1v0.1c0 0.1-0.1 0.2-0.1 0.2-0.2 0.3-0.3 0.6-0.5 0.8-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.1-0.1 0.2-0.2 0.4-0.2 0.3-0.3 0.6-0.4 0.9 0 0.1-0.1 0.1-0.1 0.2-0.2 0.4-0.3 0.8-0.5 1.2 0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.3-0.2 0.4-0.1 0.2-0.2 0.4-0.2 0.6-0.1 0.2-0.1 0.3-0.1 0.5-0.1 0.2-0.1 0.4-0.2 0.6 0 0.1-0.1 0.2-0.1 0.4-0.1 0.2-0.1 0.4-0.2 0.6-0.1 0.2-0.1 0.5-0.2 0.7 0 0.1 0 0.2-0.1 0.2 0 0.2-0.1 0.3-0.1 0.5-0.1 0.4-0.1 0.7-0.2 1.1 0 0.1 0 0.2-0.1 0.3v0.3c-0.1 0.8-0.2 1.6-0.2 2.4l0.3 93.3c0 3.2 0.9 5.7 2.3 7.3 0.5 0.5 1 1 1.6 1.4l14.8 8.6c-2.4-1.4-3.9-4.4-4-8.7l0.1-93.3c0-0.8 0.1-1.6 0.2-2.4 0-0.2 0-0.4 0.1-0.6 0.1-0.4 0.1-0.7 0.2-1.1 0-0.2 0.1-0.5 0.1-0.7 0.1-0.2 0.1-0.5 0.2-0.7 0.1-0.3 0.2-0.6 0.3-1 0.1-0.2 0.1-0.4 0.2-0.6 0.1-0.4 0.2-0.7 0.4-1.1 0.1-0.1 0.1-0.3 0.2-0.4l0.6-1.5c0-0.1 0.1-0.1 0.1-0.2 0.2-0.4 0.4-0.9 0.6-1.3 0.1-0.1 0.1-0.3 0.2-0.4 0.2-0.4 0.4-0.8 0.7-1.2 0-0.1 0.1-0.2 0.1-0.2 0.3-0.5 0.6-0.9 0.9-1.4 0.1-0.1 0.2-0.3 0.3-0.4 0.2-0.3 0.4-0.6 0.7-1 0.1-0.2 0.2-0.3 0.4-0.5 0.2-0.3 0.4-0.5 0.6-0.8 0.2-0.2 0.3-0.4 0.5-0.6 0.2-0.2 0.3-0.4 0.5-0.6 0.3-0.3 0.6-0.7 0.9-1 0.1-0.2 0.3-0.3 0.4-0.4 0.6-0.6 1.3-1.2 1.9-1.7 0.1-0.1 0.2-0.2 0.4-0.3 0.7-0.5 1.4-1 2.1-1.4l139.9-80.7c0.6-0.3 1.1-0.6 1.7-0.8 0.2-0.1 0.4-0.1 0.5-0.2 0.3-0.1 0.6-0.2 1-0.3 0.2-0.1 0.4-0.1 0.6-0.2 0.2 0 0.4-0.1 0.6-0.1 0.2 0 0.5-0.1 0.7-0.1h1.5c0.3 0 0.7 0.1 1 0.1 0.1 0 0.2 0 0.2 0.1 0.3 0.1 0.5 0.1 0.7 0.2 0.1 0 0.2 0.1 0.2 0.1 0.3 0.1 0.6 0.3 0.9 0.4l-15.1-8.7z\" fill=\"#C68620\"/><path d=\"M724.3 443.8c7.5-4.3 13.6-0.9 13.6 7.7l0.3 93.3c0 8.6-6 19.1-13.5 23.4l-139.9 80.7c-7.5 4.3-13.6 0.8-13.6-7.7L571 548c0-8.6 6-19.1 13.5-23.4l139.8-80.8z\" fill=\"#FFCD2E\"/><path d=\"M692.1 531.1l-10.4-6c-0.1-0.1-0.2-0.1-0.3-0.3l10.4 6c0.1 0.2 0.2 0.3 0.3 0.3\" fill=\"#674611\"/><path d=\"M688.7 526.5l-10.4-6 3.2 4.3 10.4 6.1z\" fill=\"#E8CFAC\"/><path d=\"M691.3 491.1c1.4-0.8 2.3 0.4 1.6 2.2l-9.4 24.3c-0.3 0.9-1 1.6-1.6 2-0.6 0.4-1.2 0.4-1.6-0.1l-3.1-4.4-28.2 35.2c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.6-2.2 0.6-2.8-0.2l-8-11.2-28.1 35c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2-0.9-1.3-0.4-3.9 1.2-5.8l30.9-38.5c0.5-0.6 1.1-1.1 1.6-1.5 1.1-0.7 2.2-0.6 2.8 0.2l8 11.2 25.4-31.7-3.1-4.4c-0.7-1 0.2-3.2 1.5-4l18.9-11.1z\" fill=\"#C68620\"/><path d=\"M649.6 547.6l10.4 6 25.4-31.7-3.1-4.4-10.4-6 3.1 4.3z\" fill=\"#E8CFAC\"/><path d=\"M704 502.4l-5.3-3.1-5.1-3h-1.1c-0.1 0-0.2 0.1-0.3 0.1l-18.9 11c-0.2 0.1-0.4 0.3-0.6 0.4l-0.2 0.2-0.1 0.1c0 0.1-0.1 0.1-0.1 0.2s-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2v0.1c0 0.1-0.1 0.1-0.1 0.2s0 0.1-0.1 0.2c0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2 0 0.1 0 0.1-0.1 0.2v0.9c0 0.2 0.1 0.4 0.2 0.5l10.4 6c-0.1-0.1-0.2-0.3-0.2-0.5v-1c0.1-0.4 0.2-0.8 0.4-1.1 0.1-0.2 0.2-0.4 0.3-0.5 0.1-0.1 0.2-0.3 0.4-0.4 0.2-0.2 0.4-0.3 0.6-0.4l18.9-11c0.1-0.1 0.2-0.1 0.3-0.2h0.1c0.1 0 0.2-0.1 0.3-0.1h0.3c0.4 0.2 0.5 0.2 0.5 0.2 0.1 0 0.1 0 0 0z m-48 60.5l-8-11.2-10.4-6 8 11.2c0.1 0.2 0.3 0.4 0.5 0.5l10.4 6c-0.2-0.1-0.3-0.3-0.5-0.5z\" fill=\"#E8CFAC\"/><path d=\"M641 535.9c-0.1 0-0.1-0.1-0.2-0.1s-0.1 0-0.2-0.1h-0.7c-0.1 0-0.2 0-0.3 0.1 0 0-0.1 0-0.1 0.1h-0.2c-0.2 0.1-0.3 0.1-0.5 0.2s-0.5 0.3-0.7 0.5l-0.2 0.2-0.2 0.2-0.4 0.4-0.2 0.2-30.9 38.5 10.4 6 30.9-38.5c0.2-0.3 0.5-0.5 0.7-0.8l0.2-0.2c0.2-0.2 0.5-0.4 0.7-0.5l0.6-0.3h0.1c0.2-0.1 0.4-0.1 0.5-0.1h0.5c0.2 0 0.3 0.1 0.5 0.2l-10.3-6z\" fill=\"#E8CFAC\"/><path d=\"M605.9 576.5c-0.1 0.1-0.1 0.2-0.2 0.3v0.1c0 0.1-0.1 0.1-0.1 0.2-0.1 0.1-0.1 0.2-0.2 0.3 0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.1-0.1 0.2s-0.1 0.2-0.1 0.3c0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.2-0.1 0.3 0 0.1-0.1 0.3-0.1 0.4v0.1c0 0.1 0 0.2-0.1 0.3v1.3c0.1 0.3 0.2 0.7 0.4 0.9 0.1 0.2 0.3 0.4 0.5 0.5l10.4 6c-0.2-0.1-0.4-0.3-0.5-0.5-0.2-0.3-0.3-0.6-0.4-0.9v-0.1c-0.1-0.3-0.1-0.7 0-1.1 0-0.1 0-0.3 0.1-0.4v-0.1c0.1-0.3 0.1-0.5 0.2-0.8 0.1-0.3 0.2-0.5 0.3-0.8 0.1-0.3 0.3-0.5 0.4-0.8 0.2-0.3 0.3-0.5 0.5-0.7l-10.4-6-0.1 0.1c-0.1 0.1-0.1 0.2-0.2 0.3z\" fill=\"#E8CFAC\"/><path d=\"M702.8 502.6c1.4-0.8 2.3 0.4 1.6 2.2L695 529c-0.3 0.9-1 1.6-1.6 2-0.6 0.4-1.2 0.4-1.6-0.1l-3.1-4.4-28.3 35.2c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2l-8-11.2-28.1 35c-0.5 0.6-1.1 1.1-1.6 1.5-1.1 0.7-2.2 0.6-2.8-0.2-0.9-1.3-0.4-3.9 1.2-5.8l30.9-38.5c0.5-0.6 1.1-1.1 1.6-1.5 1.1-0.7 2.2-0.6 2.8 0.2l8 11.2 25.4-31.7-3.1-4.4c-0.7-1 0.2-3.2 1.5-4l19-11z\" fill=\"#FFFFFF\"/></svg>', 'Contact', 'contact', '/contact', 4, 1, 1, '2025-12-10 06:11:20', '2026-01-14 06:30:49'),
(7, NULL, 'Settings', 'setting', '/settings', 7, 1, 1, '2025-12-10 06:14:09', '2026-01-14 06:30:49'),
(9, '<svg>...</svg>', 'Features', 'features', '/featurs', 8, 1, 1, '2025-12-11 00:52:44', '2026-01-14 06:30:49'),
(10, NULL, 'Norms', 'Norms', '/norms', 9, 1, 1, '2025-12-31 14:55:32', '2026-01-14 06:30:49'),
(12, NULL, 'News', '/latest-news', '/news', 6, 1, 1, '2026-01-13 11:22:15', '2026-01-14 06:30:49'),
(13, NULL, 'testttt', 'testttt', NULL, 10, 0, 1, '2026-01-14 05:55:29', '2026-01-14 06:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `header_settings`
--

CREATE TABLE `header_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255) NOT NULL,
  `logo_svg` longtext DEFAULT NULL,
  `button_text` varchar(255) NOT NULL DEFAULT 'Sign In',
  `button_link` varchar(255) NOT NULL DEFAULT '#',
  `button_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `header_settings`
--

INSERT INTO `header_settings` (`id`, `website_name`, `logo_svg`, `button_text`, `button_link`, `button_active`, `created_at`, `updated_at`) VALUES
(1, 'Bharat Stock Market Research', '<svg width=\"28\" height=\"21\" viewBox=\"0 0 28 21\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\r\n<path d=\"M26.1244 21.0003C27.3531 18.8721 28 16.4578 28 14.0003C28 11.5428 27.3531 9.1286 26.1244 7.00033C24.8956 4.87206 23.1283 3.10473 21 1.87598C18.8717 0.64722 16.4575 0.000332078 14 0.000332343C11.5425 0.000332317 9.12827 0.64722 7 1.87598C4.87173 3.10473 3.1044 4.87206 1.87565 7.00033C0.646892 9.1286 3.69251e-06 11.5428 3.7701e-06 14.0003C4.90459e-06 16.4578 0.646893 18.8721 1.87565 21.0003L14 14.0003L26.1244 21.0003Z\" fill=\"#004AFF\"/>\r\n</svg>', 'Sign Up', '/login', 1, '2025-12-10 05:42:04', '2026-01-02 12:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `hero_banners`
--

CREATE TABLE `hero_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_key` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `button_text_1` varchar(255) DEFAULT NULL,
  `button_link_1` varchar(255) DEFAULT NULL,
  `button_text_2` varchar(255) DEFAULT NULL,
  `button_link_2` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `mobile_background_image` varchar(255) DEFAULT NULL,
  `overlay_color` varchar(255) DEFAULT '#000000',
  `text_color` varchar(255) DEFAULT '#ffffff',
  `alignment` varchar(255) DEFAULT 'left',
  `vertical_position` varchar(255) DEFAULT 'center',
  `overlay_opacity` decimal(4,2) DEFAULT 0.30,
  `show_badge` tinyint(1) DEFAULT 1,
  `show_buttons` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_banners`
--

INSERT INTO `hero_banners` (`id`, `page_key`, `badge`, `title`, `subtitle`, `description`, `button_text_1`, `button_link_1`, `button_text_2`, `button_link_2`, `background_image`, `mobile_background_image`, `overlay_color`, `text_color`, `alignment`, `vertical_position`, `overlay_opacity`, `show_badge`, `show_buttons`, `sort_order`, `status`, `settings`, `created_at`, `updated_at`) VALUES
(2, 'Services', NULL, 'Our Services', 'Plans that support your market journey', 'Select a plan that suits your investing style and get real-time recommendations, alerts,\r\n                        and full access to the dashboard.', NULL, NULL, NULL, NULL, '/tmp/php3jo96504fncb1BvxI7q', NULL, '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-12 05:39:39', '2026-01-13 17:17:15'),
(8, 'contact', 'Contact', 'Contact us', 'Any question or remarks? Just write us a message!', 'Contact', NULL, NULL, NULL, NULL, '/tmp/phpv3g8e4h0kg1capD4Mmi', '/tmp/phpe5d7cqa4qqbvas7KNbS', '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-12 06:20:13', '2026-01-13 07:03:22'),
(9, 'About', 'About', 'About', 'A research platform built around responsibility and trust.', 'We help retail investors understand the market better through clear, research-based stock insights. Our focus is to deliver timely updates and actionable recommendations — so you can trade with clarity instead of uncertainty.', NULL, NULL, NULL, NULL, '/tmp/phpolh4sjp5a2e5brXN5yT', '/tmp/phpc4l15st1e9gdbjFPNSY', '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-12 07:07:35', '2026-01-13 17:12:56'),
(10, 'blogs', 'Latest Blogs', 'Blogs', 'Plans that support your market journey', 'new description for News Blogs Banner', NULL, NULL, NULL, NULL, '/tmp/php3accnpgd1ekmbnB3nzu', NULL, '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-13 01:36:01', '2026-01-13 11:28:43'),
(11, 'moreblogs', 'Welcome', 'Smart Stock Research', 'Data-driven insights', 'Trusted by investors', NULL, NULL, NULL, NULL, '/tmp/phpi9j4r3ugcfb53GZYZQU', 'C:\\Users\\LAPTOP WORLD\\AppData\\Local\\Temp\\php4583.tmp', '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-13 02:31:18', '2026-01-13 17:16:21'),
(12, 'home', 'Home', 'Smart Stock Research', 'Reliable Market Guidance', 'Get expert-backed stock recommendations and market insights - designed for retail investors in India.', 'Join Now', '/', 'View Plans', '/', '/tmp/phpgvlt8871fut2aNHlVRj', '/tmp/phpd6a71l0e1mkg2xI3ooT', '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2025-12-13 06:15:34', '2026-01-08 10:42:53'),
(20, 'news', 'News', 'Bharat Stock Latest News', 'News', NULL, NULL, NULL, NULL, NULL, '/tmp/phpshmqh1p7ok4t5EzDjgv', NULL, '#000000', '#ffffff', 'left', 'center', 0.30, 1, 1, 0, 1, NULL, '2026-01-13 11:20:05', '2026-01-13 17:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `home_counters`
--

CREATE TABLE `home_counters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_counters`
--

INSERT INTO `home_counters` (`id`, `value`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '9+', 'Years of combined research\r\nexperience', 0, 1, '2025-12-13 06:47:06', '2026-01-06 16:58:44'),
(2, '8+', 'Market segments covered', 1, 1, '2025-12-13 06:47:40', '2025-12-16 01:16:50'),
(3, '0', 'Actionable insights\r\ndelivered', 3, 1, '2025-12-13 06:48:08', '2026-01-03 12:56:04'),
(4, '4/5', 'User experience satisfaction', 4, 1, '2025-12-13 06:48:33', '2026-01-06 16:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `home_key_feature_items`
--

CREATE TABLE `home_key_feature_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_key_feature_items`
--

INSERT INTO `home_key_feature_items` (`id`, `section_id`, `title`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(24, 1, NULL, 1, 1, '2026-01-09 07:35:26', '2026-01-09 07:35:26'),
(25, 1, NULL, 2, 1, '2026-01-09 07:35:44', '2026-01-09 07:35:44'),
(26, 1, NULL, 3, 1, '2026-01-09 07:35:59', '2026-01-09 07:35:59');

-- --------------------------------------------------------

--
-- Table structure for table `home_key_feature_sections`
--

CREATE TABLE `home_key_feature_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_key_feature_sections`
--

INSERT INTO `home_key_feature_sections` (`id`, `heading`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Key Features of the Platform', 'Everything you need in one platform', 1, '2025-12-15 00:53:29', '2025-12-15 01:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works_sections`
--

CREATE TABLE `how_it_works_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `sub_heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cta_text` varchar(255) DEFAULT NULL,
  `cta_url` varchar(255) DEFAULT NULL,
  `alignment` enum('left','center','right') NOT NULL DEFAULT 'center',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_it_works_sections`
--

INSERT INTO `how_it_works_sections` (`id`, `badge`, `heading`, `sub_heading`, `description`, `cta_text`, `cta_url`, `alignment`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(13, 'Process', 'How It Works', '3 easy steps', 'Start investing easily', NULL, NULL, 'center', 0, 1, '2025-12-15 00:10:35', '2025-12-16 01:34:20'),
(14, 'Process', 'How It Works', '3 easy steps', 'Start investing easily', NULL, NULL, 'center', 0, 1, '2025-12-16 01:32:42', '2025-12-16 01:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works_steps`
--

CREATE TABLE `how_it_works_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `short_title` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `highlight_text` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_it_works_steps`
--

INSERT INTO `how_it_works_steps` (`id`, `section_id`, `short_title`, `title`, `description`, `highlight_text`, `icon`, `link_text`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 13, NULL, 'Create Your Account', 'Register with your mobile number and email to get started.', NULL, NULL, NULL, NULL, 1, 1, '2025-12-15 00:13:37', '2026-01-08 13:07:40'),
(3, 13, NULL, 'Complete Your KYC', 'Verify PAN, Aadhaar, and eSign the agreement for compliance and security.', NULL, NULL, NULL, NULL, 2, 1, '2025-12-16 01:32:42', '2026-01-08 12:24:18'),
(4, 13, NULL, 'Choose Your Subscription Plan', 'Select the plan that suits your trading or investment goals.', NULL, NULL, NULL, NULL, 3, 1, '2026-01-08 13:12:52', '2026-01-08 13:12:52'),
(5, 13, NULL, 'Receive Recommendations in Real Time', 'Get timely alerts and insights delivered on the app.', NULL, NULL, NULL, NULL, 4, 1, '2026-01-08 13:12:52', '2026-01-08 13:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 25, 'sharad', 'verma', 'admin@example.com', '9752008368', 'General Inquiry', 'I need your support message on abd@gmail.com', '2025-12-12 07:16:03', '2025-12-12 07:16:03'),
(2, NULL, 'Anjolie', 'Dawson', 'Anjolie@gmail.com', '+919457296893', 'Support', 'for support !', '2025-12-12 07:18:55', '2025-12-12 07:18:55'),
(3, 1, 'Carter', 'Pollard', 'wusymoqacy@mailinator.com', NULL, NULL, 'Est ea impedit repu', '2025-12-13 00:21:02', '2025-12-13 00:21:02'),
(4, 1, 'Rhona', 'Miles', 'infometawish.ai@gmail.com', NULL, NULL, 'text something to checking for support', '2025-12-15 05:02:20', '2025-12-15 05:02:20'),
(5, NULL, 'Sharad', 'Kumar', 'sharad@gmail.com', '9876543210', 'Pricing inquiry', 'I want to know more about your premium plans.', '2025-12-16 02:18:16', '2025-12-16 02:18:16'),
(6, NULL, NULL, NULL, NULL, NULL, 'General Inquiry', 'fkjsdfjsfsdkf', '2025-12-30 14:29:02', '2025-12-30 14:29:02'),
(7, NULL, 'namita', 'Rathore', 'namitarathore05071992@gmail.com', NULL, NULL, 'hello this is my first message. I wan to join your services. kindly help me to join you. Second last name field is mandatory what about those who have only single name like as Namita, Footer is good but lacking of professional look.', '2026-01-09 16:31:21', '2026-01-09 16:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `investor_charter_pages`
--

CREATE TABLE `investor_charter_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `page_order` int(11) NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investor_charter_pages`
--

INSERT INTO `investor_charter_pages` (`id`, `policy_id`, `page_title`, `page_slug`, `content`, `page_order`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 1, 'First Page', 'first-page', '<p>sdfadf</p>', 1, 1, '2025-12-29 02:53:26', '2025-12-29 02:53:26'),
(2, 2, 'First Page', 'first-page', '<p>This Investor Charter has been prepared in accordance with the guidelines issued by the Securities and Exchange Board of India (SEBI) to enhance transparency, protect investor interests, and promote ethical practices in the securities market.</p><p>The purpose of this charter is to inform investors about the services provided by intermediaries, their rights and responsibilities, and the grievance redressal mechanisms available to them.</p><p>Investors are advised to carefully read and understand this document before engaging in trading or investment activities through any registered intermediary.</p><p>This charter applies to all retail and institutional investors who participate in the securities market through stock brokers, trading members, or authorized intermediaries.</p><p>This Investor Charter has been prepared in accordance with the guidelines issued by the Securities and Exchange Board of India (SEBI) to enhance transparency, protect investor interests, and promote ethical practices in the securities market.</p><p>The purpose of this charter is to inform investors about the services provided by intermediaries, their rights and responsibilities, and the grievance redressal mechanisms available to them.</p><p>Investors are advised to carefully read and understand this document before engaging in trading or investment activities through any registered intermediary.</p><p>This charter applies to all retail and institutional investors who participate in the securities market through stock brokers, trading members, or authorized intermediaries.</p><p>This Investor Charter has been prepared in accordance with the guidelines issued by the Securities and Exchange Board of India (SEBI) to enhance transparency, protect investor interests, and promote ethical practices in the securities market.</p><p>The purpose of this charter is to inform investors about the services provided by intermediaries, their rights and responsibilities, and the grievance redressal mechanisms available to them.</p><p>Investors are advised to carefully read and understand this document before engaging in trading or investment activities through any registered intermediary.</p><p>This charter applies to all retail and institutional investors who participate in the securities market through stock brokers, trading members, or authorized intermediaries.</p><p>This Investor Charter has been prepared in accordance with the guidelines issued by the Securities and Exchange Board of India (SEBI) to enhance transparency, protect investor interests, and promote ethical practices in the securities market.</p><p>The purpose of this charter is to inform investors about the services provided by intermediaries, their rights and responsibilities, and the grievance redressal mechanisms available to them.</p><p>Investors are advised to carefully read and understand this document before engaging in trading or investment activities through any registered intermediary.</p><p>This charter applies to all retail and institutional investors who participate in the securities market through stock brokers, trading members, or authorized intermediaries.</p><p>This Investor Charter has been prepared in accordance with the guidelines issued by the Securities and Exchange Board of India (SEBI) to enhance transparency, protect investor interests, and promote ethical practices in the securities market.</p><p>The purpose of this charter is to inform investors about the services provided by intermediaries, their rights and responsibilities, and the grievance redressal mechanisms available to them.</p><p>Investors are advised to carefully read and understand this document before engaging in trading or investment activities through any registered intermediary.</p><p>This charter applies to all retail and institutional investors who participate in the securities market through stock brokers, trading members, or authorized intermediaries.</p>', 1, 1, '2025-12-29 02:58:43', '2025-12-29 02:58:43'),
(3, 2, 'Vision & Mission', 'vision-mission', '<h3><strong>Vision</strong></h3><p>To create a transparent, fair, and secure investment environment where investor interests are protected and trust is maintained at all times.</p><h3><strong>Mission</strong></h3><ul><li>To provide efficient and reliable services to investors.</li><li>To ensure compliance with regulatory requirements.</li><li>To promote ethical conduct and professional integrity.</li><li>To resolve investor grievances in a timely and transparent manner.</li></ul><p>The intermediary strives to continuously improve service quality through technology, investor education, and adherence to best practices.</p><h3><strong>Mission</strong></h3><ul><li>To provide efficient and reliable services to investors.</li><li>To ensure compliance with regulatory requirements.</li><li>To promote ethical conduct and professional integrity.</li><li>To resolve investor grievances in a timely and transparent manner.</li></ul><p>The intermediary strives to continuously improve service quality through technology, investor education, and adherence to best practices.</p><h3><strong>Mission</strong></h3><ul><li>To provide efficient and reliable services to investors.</li><li>To ensure compliance with regulatory requirements.</li><li>To promote ethical conduct and professional integrity.</li><li>To resolve investor grievances in a timely and transparent manner.</li></ul><p>The intermediary strives to continuously improve service quality through technology, investor education, and adherence to best practices.</p><h3><strong>Mission</strong></h3><ul><li>To provide efficient and reliable services to investors.</li><li>To ensure compliance with regulatory requirements.</li><li>To promote ethical conduct and professional integrity.</li><li>To resolve investor grievances in a timely and transparent manner.</li></ul><p>The intermediary strives to continuously improve service quality through technology, investor education, and adherence to best practices.</p><h3><strong>Mission</strong></h3><ul><li>To provide efficient and reliable services to investors.</li><li>To ensure compliance with regulatory requirements.</li><li>To promote ethical conduct and professional integrity.</li><li>To resolve investor grievances in a timely and transparent manner.</li></ul><p>The intermediary strives to continuously improve service quality through technology, investor education, and adherence to best practices.</p>', 2, 1, '2025-12-29 02:58:43', '2025-12-29 02:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `investor_charter_policies`
--

CREATE TABLE `investor_charter_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investor_charter_policies`
--

INSERT INTO `investor_charter_policies` (`id`, `title`, `version`, `effective_from`, `effective_to`, `is_active`, `is_archived`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Investor Charter', '1.0', '2025-12-29', NULL, 0, 1, 'adsf', '2025-12-29 02:53:26', '2025-12-29 02:58:43'),
(2, 'Investor Charter', 'v1.1', '2025-12-29', NULL, 1, 0, 'test', '2025-12-29 02:58:43', '2025-12-29 02:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `investor_charter_policy_logs`
--

CREATE TABLE `investor_charter_policy_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `performed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investor_charter_policy_logs`
--

INSERT INTO `investor_charter_policy_logs` (`id`, `policy_id`, `action`, `remarks`, `performed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'created', 'Investor charter policy created', 1, '2025-12-29 02:53:26', '2025-12-29 02:53:26'),
(2, 2, 'created', 'Investor charter policy v1.1 created', 1, '2025-12-29 02:58:43', '2025-12-29 02:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"73da0433-bd6b-4e40-9f5d-139b0090e923\",\"displayName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"command\":\"O:58:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\\\":6:{s:14:\\\"\\u0000*\\u0000conversions\\\";O:52:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\ConversionCollection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:42:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Conversion\\\":11:{s:12:\\\"\\u0000*\\u0000fileNamer\\\";O:54:\\\"Spatie\\\\MediaLibrary\\\\Support\\\\FileNamer\\\\DefaultFileNamer\\\":0:{}s:28:\\\"\\u0000*\\u0000extractVideoFrameAtSecond\\\";d:0;s:16:\\\"\\u0000*\\u0000manipulations\\\";O:45:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Manipulations\\\":1:{s:16:\\\"\\u0000*\\u0000manipulations\\\";a:5:{s:8:\\\"optimize\\\";a:1:{i:0;O:36:\\\"Spatie\\\\ImageOptimizer\\\\OptimizerChain\\\":3:{s:13:\\\"\\u0000*\\u0000optimizers\\\";a:7:{i:0;O:42:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Jpegoptim\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m85\\\";i:1;s:7:\\\"--force\\\";i:2;s:11:\\\"--strip-all\\\";i:3;s:17:\\\"--all-progressive\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:9:\\\"jpegoptim\\\";}i:1;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Pngquant\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:7:\\\"--force\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"pngquant\\\";}i:2;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Optipng\\\":5:{s:7:\\\"options\\\";a:3:{i:0;s:3:\\\"-i0\\\";i:1;s:3:\\\"-o2\\\";i:2;s:6:\\\"-quiet\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"optipng\\\";}i:3;O:37:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Svgo\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:20:\\\"--disable=cleanupIDs\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:4:\\\"svgo\\\";}i:4;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Gifsicle\\\":5:{s:7:\\\"options\\\";a:2:{i:0;s:2:\\\"-b\\\";i:1;s:3:\\\"-O3\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"gifsicle\\\";}i:5;O:38:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Cwebp\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m 6\\\";i:1;s:8:\\\"-pass 10\\\";i:2;s:3:\\\"-mt\\\";i:3;s:5:\\\"-q 90\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:5:\\\"cwebp\\\";}i:6;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Avifenc\\\":6:{s:7:\\\"options\\\";a:8:{i:0;s:14:\\\"-a cq-level=23\\\";i:1;s:6:\\\"-j all\\\";i:2;s:7:\\\"--min 0\\\";i:3;s:8:\\\"--max 63\\\";i:4;s:12:\\\"--minalpha 0\\\";i:5;s:13:\\\"--maxalpha 63\\\";i:6;s:14:\\\"-a end-usage=q\\\";i:7;s:12:\\\"-a tune=ssim\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"avifenc\\\";s:16:\\\"decodeBinaryName\\\";s:7:\\\"avifdec\\\";}}s:9:\\\"\\u0000*\\u0000logger\\\";O:33:\\\"Spatie\\\\ImageOptimizer\\\\DummyLogger\\\":0:{}s:10:\\\"\\u0000*\\u0000timeout\\\";i:60;}}s:6:\\\"format\\\";a:1:{i:0;s:3:\\\"jpg\\\";}s:5:\\\"width\\\";a:1:{i:0;i:300;}s:6:\\\"height\\\";a:1:{i:0;i:200;}s:7:\\\"sharpen\\\";a:1:{i:0;i:10;}}}s:23:\\\"\\u0000*\\u0000performOnCollections\\\";a:0:{}s:17:\\\"\\u0000*\\u0000performOnQueue\\\";b:1;s:26:\\\"\\u0000*\\u0000keepOriginalImageFormat\\\";b:0;s:27:\\\"\\u0000*\\u0000generateResponsiveImages\\\";b:0;s:18:\\\"\\u0000*\\u0000widthCalculator\\\";N;s:24:\\\"\\u0000*\\u0000loadingAttributeValue\\\";N;s:16:\\\"\\u0000*\\u0000pdfPageNumber\\\";i:1;s:7:\\\"\\u0000*\\u0000name\\\";s:5:\\\"thumb\\\";}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:8:\\\"\\u0000*\\u0000media\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:49:\\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:14:\\\"\\u0000*\\u0000onlyMissing\\\";b:0;s:10:\\\"connection\\\";s:8:\\\"database\\\";s:5:\\\"queue\\\";s:0:\\\"\\\";s:11:\\\"afterCommit\\\";b:1;}\"},\"createdAt\":1765272673,\"delay\":null}', 0, NULL, 1765272673, 1765272673),
(2, 'default', '{\"uuid\":\"914661d1-f73c-447f-ba1d-23cc45dc2c8b\",\"displayName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"command\":\"O:58:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\\\":6:{s:14:\\\"\\u0000*\\u0000conversions\\\";O:52:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\ConversionCollection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:42:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Conversion\\\":11:{s:12:\\\"\\u0000*\\u0000fileNamer\\\";O:54:\\\"Spatie\\\\MediaLibrary\\\\Support\\\\FileNamer\\\\DefaultFileNamer\\\":0:{}s:28:\\\"\\u0000*\\u0000extractVideoFrameAtSecond\\\";d:0;s:16:\\\"\\u0000*\\u0000manipulations\\\";O:45:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Manipulations\\\":1:{s:16:\\\"\\u0000*\\u0000manipulations\\\";a:5:{s:8:\\\"optimize\\\";a:1:{i:0;O:36:\\\"Spatie\\\\ImageOptimizer\\\\OptimizerChain\\\":3:{s:13:\\\"\\u0000*\\u0000optimizers\\\";a:7:{i:0;O:42:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Jpegoptim\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m85\\\";i:1;s:7:\\\"--force\\\";i:2;s:11:\\\"--strip-all\\\";i:3;s:17:\\\"--all-progressive\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:9:\\\"jpegoptim\\\";}i:1;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Pngquant\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:7:\\\"--force\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"pngquant\\\";}i:2;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Optipng\\\":5:{s:7:\\\"options\\\";a:3:{i:0;s:3:\\\"-i0\\\";i:1;s:3:\\\"-o2\\\";i:2;s:6:\\\"-quiet\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"optipng\\\";}i:3;O:37:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Svgo\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:20:\\\"--disable=cleanupIDs\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:4:\\\"svgo\\\";}i:4;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Gifsicle\\\":5:{s:7:\\\"options\\\";a:2:{i:0;s:2:\\\"-b\\\";i:1;s:3:\\\"-O3\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"gifsicle\\\";}i:5;O:38:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Cwebp\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m 6\\\";i:1;s:8:\\\"-pass 10\\\";i:2;s:3:\\\"-mt\\\";i:3;s:5:\\\"-q 90\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:5:\\\"cwebp\\\";}i:6;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Avifenc\\\":6:{s:7:\\\"options\\\";a:8:{i:0;s:14:\\\"-a cq-level=23\\\";i:1;s:6:\\\"-j all\\\";i:2;s:7:\\\"--min 0\\\";i:3;s:8:\\\"--max 63\\\";i:4;s:12:\\\"--minalpha 0\\\";i:5;s:13:\\\"--maxalpha 63\\\";i:6;s:14:\\\"-a end-usage=q\\\";i:7;s:12:\\\"-a tune=ssim\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"avifenc\\\";s:16:\\\"decodeBinaryName\\\";s:7:\\\"avifdec\\\";}}s:9:\\\"\\u0000*\\u0000logger\\\";O:33:\\\"Spatie\\\\ImageOptimizer\\\\DummyLogger\\\":0:{}s:10:\\\"\\u0000*\\u0000timeout\\\";i:60;}}s:6:\\\"format\\\";a:1:{i:0;s:3:\\\"jpg\\\";}s:5:\\\"width\\\";a:1:{i:0;i:300;}s:6:\\\"height\\\";a:1:{i:0;i:200;}s:7:\\\"sharpen\\\";a:1:{i:0;i:10;}}}s:23:\\\"\\u0000*\\u0000performOnCollections\\\";a:0:{}s:17:\\\"\\u0000*\\u0000performOnQueue\\\";b:1;s:26:\\\"\\u0000*\\u0000keepOriginalImageFormat\\\";b:0;s:27:\\\"\\u0000*\\u0000generateResponsiveImages\\\";b:0;s:18:\\\"\\u0000*\\u0000widthCalculator\\\";N;s:24:\\\"\\u0000*\\u0000loadingAttributeValue\\\";N;s:16:\\\"\\u0000*\\u0000pdfPageNumber\\\";i:1;s:7:\\\"\\u0000*\\u0000name\\\";s:5:\\\"thumb\\\";}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:8:\\\"\\u0000*\\u0000media\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:49:\\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:14:\\\"\\u0000*\\u0000onlyMissing\\\";b:0;s:10:\\\"connection\\\";s:8:\\\"database\\\";s:5:\\\"queue\\\";s:0:\\\"\\\";s:11:\\\"afterCommit\\\";b:1;}\"},\"createdAt\":1765273478,\"delay\":null}', 0, NULL, 1765273478, 1765273478),
(3, 'default', '{\"uuid\":\"1479ce4c-f6f0-4cdf-bb20-b8a455382cc6\",\"displayName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"command\":\"O:58:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\\\":6:{s:14:\\\"\\u0000*\\u0000conversions\\\";O:52:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\ConversionCollection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:42:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Conversion\\\":11:{s:12:\\\"\\u0000*\\u0000fileNamer\\\";O:54:\\\"Spatie\\\\MediaLibrary\\\\Support\\\\FileNamer\\\\DefaultFileNamer\\\":0:{}s:28:\\\"\\u0000*\\u0000extractVideoFrameAtSecond\\\";d:0;s:16:\\\"\\u0000*\\u0000manipulations\\\";O:45:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Manipulations\\\":1:{s:16:\\\"\\u0000*\\u0000manipulations\\\";a:5:{s:8:\\\"optimize\\\";a:1:{i:0;O:36:\\\"Spatie\\\\ImageOptimizer\\\\OptimizerChain\\\":3:{s:13:\\\"\\u0000*\\u0000optimizers\\\";a:7:{i:0;O:42:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Jpegoptim\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m85\\\";i:1;s:7:\\\"--force\\\";i:2;s:11:\\\"--strip-all\\\";i:3;s:17:\\\"--all-progressive\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:9:\\\"jpegoptim\\\";}i:1;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Pngquant\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:7:\\\"--force\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"pngquant\\\";}i:2;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Optipng\\\":5:{s:7:\\\"options\\\";a:3:{i:0;s:3:\\\"-i0\\\";i:1;s:3:\\\"-o2\\\";i:2;s:6:\\\"-quiet\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"optipng\\\";}i:3;O:37:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Svgo\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:20:\\\"--disable=cleanupIDs\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:4:\\\"svgo\\\";}i:4;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Gifsicle\\\":5:{s:7:\\\"options\\\";a:2:{i:0;s:2:\\\"-b\\\";i:1;s:3:\\\"-O3\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"gifsicle\\\";}i:5;O:38:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Cwebp\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m 6\\\";i:1;s:8:\\\"-pass 10\\\";i:2;s:3:\\\"-mt\\\";i:3;s:5:\\\"-q 90\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:5:\\\"cwebp\\\";}i:6;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Avifenc\\\":6:{s:7:\\\"options\\\";a:8:{i:0;s:14:\\\"-a cq-level=23\\\";i:1;s:6:\\\"-j all\\\";i:2;s:7:\\\"--min 0\\\";i:3;s:8:\\\"--max 63\\\";i:4;s:12:\\\"--minalpha 0\\\";i:5;s:13:\\\"--maxalpha 63\\\";i:6;s:14:\\\"-a end-usage=q\\\";i:7;s:12:\\\"-a tune=ssim\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"avifenc\\\";s:16:\\\"decodeBinaryName\\\";s:7:\\\"avifdec\\\";}}s:9:\\\"\\u0000*\\u0000logger\\\";O:33:\\\"Spatie\\\\ImageOptimizer\\\\DummyLogger\\\":0:{}s:10:\\\"\\u0000*\\u0000timeout\\\";i:60;}}s:6:\\\"format\\\";a:1:{i:0;s:3:\\\"jpg\\\";}s:5:\\\"width\\\";a:1:{i:0;i:300;}s:6:\\\"height\\\";a:1:{i:0;i:200;}s:7:\\\"sharpen\\\";a:1:{i:0;i:10;}}}s:23:\\\"\\u0000*\\u0000performOnCollections\\\";a:0:{}s:17:\\\"\\u0000*\\u0000performOnQueue\\\";b:1;s:26:\\\"\\u0000*\\u0000keepOriginalImageFormat\\\";b:0;s:27:\\\"\\u0000*\\u0000generateResponsiveImages\\\";b:0;s:18:\\\"\\u0000*\\u0000widthCalculator\\\";N;s:24:\\\"\\u0000*\\u0000loadingAttributeValue\\\";N;s:16:\\\"\\u0000*\\u0000pdfPageNumber\\\";i:1;s:7:\\\"\\u0000*\\u0000name\\\";s:5:\\\"thumb\\\";}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:8:\\\"\\u0000*\\u0000media\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:49:\\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:14:\\\"\\u0000*\\u0000onlyMissing\\\";b:0;s:10:\\\"connection\\\";s:8:\\\"database\\\";s:5:\\\"queue\\\";s:0:\\\"\\\";s:11:\\\"afterCommit\\\";b:1;}\"},\"createdAt\":1765275391,\"delay\":null}', 0, NULL, 1765275391, 1765275391),
(4, 'default', '{\"uuid\":\"294e1100-5108-4079-8945-3d1749adbfe0\",\"displayName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\",\"command\":\"O:58:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Jobs\\\\PerformConversionsJob\\\":6:{s:14:\\\"\\u0000*\\u0000conversions\\\";O:52:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\ConversionCollection\\\":2:{s:8:\\\"\\u0000*\\u0000items\\\";a:1:{i:0;O:42:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Conversion\\\":11:{s:12:\\\"\\u0000*\\u0000fileNamer\\\";O:54:\\\"Spatie\\\\MediaLibrary\\\\Support\\\\FileNamer\\\\DefaultFileNamer\\\":0:{}s:28:\\\"\\u0000*\\u0000extractVideoFrameAtSecond\\\";d:0;s:16:\\\"\\u0000*\\u0000manipulations\\\";O:45:\\\"Spatie\\\\MediaLibrary\\\\Conversions\\\\Manipulations\\\":1:{s:16:\\\"\\u0000*\\u0000manipulations\\\";a:5:{s:8:\\\"optimize\\\";a:1:{i:0;O:36:\\\"Spatie\\\\ImageOptimizer\\\\OptimizerChain\\\":3:{s:13:\\\"\\u0000*\\u0000optimizers\\\";a:7:{i:0;O:42:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Jpegoptim\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m85\\\";i:1;s:7:\\\"--force\\\";i:2;s:11:\\\"--strip-all\\\";i:3;s:17:\\\"--all-progressive\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:9:\\\"jpegoptim\\\";}i:1;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Pngquant\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:7:\\\"--force\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"pngquant\\\";}i:2;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Optipng\\\":5:{s:7:\\\"options\\\";a:3:{i:0;s:3:\\\"-i0\\\";i:1;s:3:\\\"-o2\\\";i:2;s:6:\\\"-quiet\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"optipng\\\";}i:3;O:37:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Svgo\\\":5:{s:7:\\\"options\\\";a:1:{i:0;s:20:\\\"--disable=cleanupIDs\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:4:\\\"svgo\\\";}i:4;O:41:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Gifsicle\\\":5:{s:7:\\\"options\\\";a:2:{i:0;s:2:\\\"-b\\\";i:1;s:3:\\\"-O3\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:8:\\\"gifsicle\\\";}i:5;O:38:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Cwebp\\\":5:{s:7:\\\"options\\\";a:4:{i:0;s:4:\\\"-m 6\\\";i:1;s:8:\\\"-pass 10\\\";i:2;s:3:\\\"-mt\\\";i:3;s:5:\\\"-q 90\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:5:\\\"cwebp\\\";}i:6;O:40:\\\"Spatie\\\\ImageOptimizer\\\\Optimizers\\\\Avifenc\\\":6:{s:7:\\\"options\\\";a:8:{i:0;s:14:\\\"-a cq-level=23\\\";i:1;s:6:\\\"-j all\\\";i:2;s:7:\\\"--min 0\\\";i:3;s:8:\\\"--max 63\\\";i:4;s:12:\\\"--minalpha 0\\\";i:5;s:13:\\\"--maxalpha 63\\\";i:6;s:14:\\\"-a end-usage=q\\\";i:7;s:12:\\\"-a tune=ssim\\\";}s:9:\\\"imagePath\\\";s:0:\\\"\\\";s:10:\\\"binaryPath\\\";s:0:\\\"\\\";s:7:\\\"tmpPath\\\";N;s:10:\\\"binaryName\\\";s:7:\\\"avifenc\\\";s:16:\\\"decodeBinaryName\\\";s:7:\\\"avifdec\\\";}}s:9:\\\"\\u0000*\\u0000logger\\\";O:33:\\\"Spatie\\\\ImageOptimizer\\\\DummyLogger\\\":0:{}s:10:\\\"\\u0000*\\u0000timeout\\\";i:60;}}s:6:\\\"format\\\";a:1:{i:0;s:3:\\\"jpg\\\";}s:5:\\\"width\\\";a:1:{i:0;i:300;}s:6:\\\"height\\\";a:1:{i:0;i:200;}s:7:\\\"sharpen\\\";a:1:{i:0;i:10;}}}s:23:\\\"\\u0000*\\u0000performOnCollections\\\";a:0:{}s:17:\\\"\\u0000*\\u0000performOnQueue\\\";b:1;s:26:\\\"\\u0000*\\u0000keepOriginalImageFormat\\\";b:0;s:27:\\\"\\u0000*\\u0000generateResponsiveImages\\\";b:0;s:18:\\\"\\u0000*\\u0000widthCalculator\\\";N;s:24:\\\"\\u0000*\\u0000loadingAttributeValue\\\";N;s:16:\\\"\\u0000*\\u0000pdfPageNumber\\\";i:1;s:7:\\\"\\u0000*\\u0000name\\\";s:5:\\\"thumb\\\";}}s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;}s:8:\\\"\\u0000*\\u0000media\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:49:\\\"Spatie\\\\MediaLibrary\\\\MediaCollections\\\\Models\\\\Media\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:14:\\\"\\u0000*\\u0000onlyMissing\\\";b:0;s:10:\\\"connection\\\";s:8:\\\"database\\\";s:5:\\\"queue\\\";s:0:\\\"\\\";s:11:\\\"afterCommit\\\";b:1;}\"},\"createdAt\":1765279000,\"delay\":null}', 0, NULL, 1765279000, 1765279000),
(5, 'default', '{\"uuid\":\"02c262f3-2452-4afe-8cde-5385f78481de\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951384,\"delay\":null}', 0, NULL, 1765951384, 1765951384),
(6, 'default', '{\"uuid\":\"ec1dc500-71a4-47e3-a80f-0faa2dba8499\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951425,\"delay\":null}', 0, NULL, 1765951425, 1765951425),
(7, 'default', '{\"uuid\":\"92ed4392-e97d-43a4-94bf-cab7e1f4b6d6\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951449,\"delay\":null}', 0, NULL, 1765951449, 1765951449),
(8, 'default', '{\"uuid\":\"e0c41d81-f970-4292-99be-7b4fa723f09f\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951523,\"delay\":null}', 0, NULL, 1765951523, 1765951523),
(9, 'default', '{\"uuid\":\"a6374dba-6b7d-401a-8523-5817b51c452f\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951523,\"delay\":null}', 0, NULL, 1765951523, 1765951523),
(10, 'default', '{\"uuid\":\"7c629585-0532-42e5-b31b-9eaf83b049ed\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951580,\"delay\":null}', 0, NULL, 1765951580, 1765951580),
(11, 'default', '{\"uuid\":\"7b024dcc-1325-4bb0-a711-8fd9ee3d595c\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951608,\"delay\":null}', 0, NULL, 1765951608, 1765951608),
(12, 'default', '{\"uuid\":\"687ab7ba-0dee-44bf-9d74-34204d51cc98\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:10:\\\"hello user\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765951777,\"delay\":null}', 0, NULL, 1765951777, 1765951777),
(13, 'default', '{\"uuid\":\"d7812e87-0a9d-4456-aa2a-b478fd207668\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:20:\\\"Hello from BSMR Test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765954508,\"delay\":null}', 0, NULL, 1765954508, 1765954508),
(14, 'default', '{\"uuid\":\"b55d3304-6ffd-4522-a75d-6a56c787db69\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:16:\\\"another one test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765954606,\"delay\":null}', 0, NULL, 1765954606, 1765954606),
(15, 'default', '{\"uuid\":\"b0d6aa4a-dbe4-4944-ba94-309cf8413519\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:10:\\\"hello bhai\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765954643,\"delay\":null}', 0, NULL, 1765954643, 1765954643),
(16, 'default', '{\"uuid\":\"f77ea90f-81df-471e-8c1f-3ded6cb2a591\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:5:\\\"haaaa\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765954881,\"delay\":null}', 0, NULL, 1765954881, 1765954881),
(17, 'default', '{\"uuid\":\"e72a9336-2e37-4fbc-a429-c97abe5c7fdf\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:13:\\\"not providing\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765955010,\"delay\":null}', 0, NULL, 1765955010, 1765955010),
(18, 'default', '{\"uuid\":\"69534fd4-346e-42e6-99a3-a37395fe14b5\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:12:\\\"another test\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765955216,\"delay\":null}', 0, NULL, 1765955216, 1765955216),
(19, 'default', '{\"uuid\":\"802a3052-19f0-4d5d-b7c4-527bf6fd9146\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:4:\\\"neee\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765955852,\"delay\":null}', 0, NULL, 1765955853, 1765955853),
(20, 'default', '{\"uuid\":\"77f372f4-ddf3-47b1-ad31-0cbe5960db8f\",\"displayName\":\"App\\\\Events\\\\ChatMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\ChatMessageSent\\\":1:{s:7:\\\"message\\\";s:5:\\\"nnnnn\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765956067,\"delay\":null}', 0, NULL, 1765956067, 1765956067),
(21, 'default', '{\"uuid\":\"115da841-89f4-4059-8984-cf6df8435764\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 1 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747130,\"delay\":null}', 0, NULL, 1766747130, 1766747130),
(22, 'default', '{\"uuid\":\"56108c82-2de5-4749-abb5-c9e7b22ae598\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747172,\"delay\":null}', 0, NULL, 1766747172, 1766747172),
(23, 'default', '{\"uuid\":\"a177cd1c-e140-49b3-9e3f-b120459eefff\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747299,\"delay\":null}', 0, NULL, 1766747300, 1766747300),
(24, 'default', '{\"uuid\":\"3a26ac28-9a5f-4989-98d6-916fc4cec324\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747314,\"delay\":null}', 0, NULL, 1766747314, 1766747314),
(25, 'default', '{\"uuid\":\"d7cd4e4d-c224-4e2a-9683-77ff2fc58598\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747462,\"delay\":null}', 0, NULL, 1766747462, 1766747462),
(26, 'default', '{\"uuid\":\"c30909a7-30f0-4ee2-bdc4-2576965a3de2\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747471,\"delay\":null}', 0, NULL, 1766747471, 1766747471),
(27, 'default', '{\"uuid\":\"1c1cba61-37a8-4138-8dff-7e4bed423abc\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747525,\"delay\":null}', 0, NULL, 1766747525, 1766747525),
(28, 'default', '{\"uuid\":\"00fc3771-b5dc-4b4a-b681-037b3269840d\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766747549,\"delay\":null}', 0, NULL, 1766747549, 1766747549),
(29, 'default', '{\"uuid\":\"358258c1-2576-4712-b5b2-3daad5a7a549\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766749990,\"delay\":null}', 0, NULL, 1766749990, 1766749990),
(30, 'default', '{\"uuid\":\"9089d61a-899c-4cf6-b838-3a642fea85ba\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750044,\"delay\":null}', 0, NULL, 1766750044, 1766750044),
(31, 'default', '{\"uuid\":\"6c492e71-04e8-4b64-887d-c6e0cf06c442\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750052,\"delay\":null}', 0, NULL, 1766750052, 1766750052);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(32, 'default', '{\"uuid\":\"4641f23d-5723-4237-9a14-bd8cb8e62cb2\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 0 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750084,\"delay\":null}', 0, NULL, 1766750084, 1766750084),
(33, 'default', '{\"uuid\":\"6aa2710a-0000-4905-87ce-cc7b4efc71e2\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750090,\"delay\":null}', 0, NULL, 1766750090, 1766750090),
(34, 'default', '{\"uuid\":\"bdfc4230-db16-4440-a6a1-c28b837e81e8\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750096,\"delay\":null}', 0, NULL, 1766750096, 1766750096),
(35, 'default', '{\"uuid\":\"ef77f1d7-4eb2-4e42-9ece-d8c854ad6a49\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750105,\"delay\":null}', 0, NULL, 1766750105, 1766750105),
(36, 'default', '{\"uuid\":\"9b93df5a-503d-4b02-bdad-deea67e92712\",\"displayName\":\"App\\\\Events\\\\PlanExpiringEvent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\PlanExpiringEvent\\\":2:{s:7:\\\"message\\\";s:37:\\\"Alert: Your plan expires in 2 day(s)!\\\";s:6:\\\"userId\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1766750114,\"delay\":null}', 0, NULL, 1766750114, 1766750114);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marquees`
--

CREATE TABLE `marquees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marquees`
--

INSERT INTO `marquees` (`id`, `title`, `description`, `content`, `is_active`, `start_at`, `end_at`, `display_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, '⚠️ Disclaimer:', NULL, 'This website is for informational purposes only. We do not provide any financial, legal, or investment advice. Please consult a professional before making any decisions. ⚠️ Important: All information provided on this website is for general educational purposes only. • Investing in financial markets involves risks. Always consult with a professional advisor. • Past performance is not indicative of future results. Use this data at your own discretion. • BSMR does not take responsibility for any financial losses incurred using our tools or advice.', 1, NULL, NULL, 1, 1, NULL, '2026-01-14 08:33:03', '2026-01-14 08:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `uuid`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, '2724f930-0a4f-45b8-a17c-86f4ccd20b78', 'App\\Models\\Blog', 1, 'thumbnail', 'download (1)', 'download-(1).jpg', 'image/jpeg', 'public', 'public', 1923, '[]', '[]', '[]', '[]', 1, '2025-12-05 05:55:55', '2025-12-05 05:55:55'),
(2, '1ef23bea-af69-4a23-a639-a5141765f17a', 'App\\Models\\User', 1, 'profile_images', 'profile_image_1', 'tag_image.jpeg', 'image/jpeg', 'public', 'public', 132464, '[]', '[]', '{\"thumb\":true,\"medium\":true}', '[]', 1, '2025-12-06 01:59:00', '2025-12-06 01:59:01'),
(3, '4e056ebc-1989-498e-a0be-bee542a0dddc', 'App\\Models\\User', 1, 'profile_images', 'profile_image_1', '1752822925_VEDARO-Logo-png-(1).png', 'image/png', 'public', 'public', 50491, '[]', '[]', '{\"thumb\":true,\"medium\":true}', '[]', 2, '2025-12-06 02:02:20', '2025-12-06 02:02:21'),
(9, '20684c9f-62d7-46a1-be80-f86f6a543dd0', 'App\\Models\\User', 20, 'profile_images', 'profile_image_20', 'metawishlogo.png', 'image/png', 'public', 'public', 3370, '[]', '[]', '{\"thumb\":true,\"medium\":true}', '[]', 1, '2025-12-06 02:16:17', '2025-12-06 02:16:18'),
(16, '7bf8b4ce-51eb-4af8-9189-da99476daa90', 'App\\Models\\Package', 1, 'image', '1752822925_VEDARO Logo png (1)', '1752822925_VEDARO-Logo-png-(1).png', 'image/png', 'public', 'public', 50491, '[]', '[]', '[]', '[]', 1, '2025-12-09 04:14:38', '2025-12-09 04:14:38'),
(17, 'b30ab910-8e04-4d72-b66c-fb7035fa56a2', 'App\\Models\\Package', 3, 'image', 'chain-784422_1280', 'chain-784422_1280.jpg', 'image/jpeg', 'public', 'public', 342328, '[]', '[]', '[]', '[]', 1, '2025-12-09 04:46:31', '2025-12-09 04:46:31'),
(18, '371dad93-7140-44c3-a495-c51fcb32082e', 'App\\Models\\Package', 5, 'image', 'download (2)', 'download-(2).jpg', 'image/jpeg', 'public', 'public', 3878, '[]', '[]', '[]', '[]', 1, '2025-12-09 05:46:40', '2025-12-09 05:46:40'),
(19, '745989c9-24af-4450-baf4-e4f6288b5132', 'App\\Models\\HeroBanner', 0, 'global_media', 'Black-Dal-Makhani-1024x683', 'Black-Dal-Makhani-1024x683.webp', 'image/webp', 'public', 'public', 94178, '[]', '[]', '[]', '[]', 1, '2025-12-12 05:58:33', '2025-12-12 05:58:33'),
(23, '13f6fdca-3705-4dae-bdb0-7bfb9e6fe94e', 'App\\Models\\HeroBanner', 0, 'global_media', '1752822925_VEDARO Logo png (1)', '1752822925_VEDARO-Logo-png-(1).png', 'image/png', 'public', 'public', 50491, '[]', '[]', '[]', '[]', 2, '2025-12-12 06:06:01', '2025-12-12 06:06:01'),
(43, '9fd04514-e7a3-4bcf-8552-8e806a505671', 'App\\Models\\Review', 2, 'review_images', 'bangles', 'bangles.png', 'image/png', 'public', 'public', 1332841, '[]', '[]', '[]', '[]', 1, '2025-12-15 02:36:47', '2025-12-15 02:36:47'),
(44, '785ef3d0-0014-437d-8b0a-f3a185574902', 'App\\Models\\Review', 3, 'review_images', 'Screenshot (6)', 'Screenshot-(6).png', 'image/png', 'public', 'public', 254907, '[]', '[]', '[]', '[]', 1, '2025-12-15 02:45:58', '2025-12-15 02:45:58'),
(45, '7cf865c9-2fe2-4eb9-8b81-e985ef13991e', 'App\\Models\\Review', 4, 'review_images', '50', '50.jpg', 'image/jpeg', 'public', 'public', 1731, '[]', '[]', '[]', '[]', 1, '2025-12-15 02:47:06', '2025-12-15 02:47:06'),
(49, '96bcf4c1-5a90-4038-917f-4734c46f1123', 'App\\Models\\HowItWorksStep', 1, 'how_it_works_step', 'kanchanara-dVAW3YDHtSw-unsplash', 'step_1_1765796719.jpg', 'image/jpeg', 'public', 'public', 378250, '[]', '[]', '[]', '[]', 1, '2025-12-15 05:35:19', '2025-12-15 05:35:19'),
(60, '7d726796-7d06-4393-a15b-3753a658a38d', 'App\\Models\\HeroBanner', 11, 'mobile_background', '1752822925_VEDARO Logo png (1)', '1752822925_VEDARO-Logo-png-(1).png', 'image/png', 'public', 'public', 50491, '[]', '[]', '[]', '[]', 2, '2025-12-16 01:04:47', '2025-12-16 01:04:47'),
(75, '5aa87036-22ab-487b-9004-407088d54d38', 'App\\Models\\Review', 6, 'review_images', 'stock-market-6693060_1280', 'stock-market-6693060_1280.jpg', 'image/jpeg', 'public', 'public', 268936, '[]', '[]', '[]', '[]', 1, '2025-12-16 02:11:26', '2025-12-16 02:11:26'),
(86, 'd1209fc7-5d49-4415-a311-a2edbf34cf01', 'App\\Models\\User', 2, 'profile_images', 'profile_image_2', 'chain-784422_1280.jpg', 'image/jpeg', 'public', 'public', 342328, '[]', '[]', '{\"thumb\":true,\"medium\":true}', '[]', 1, '2025-12-30 06:28:53', '2025-12-30 06:28:53'),
(87, '6eb19eb9-fc1c-4a64-bfe3-eb5de3e9b18f', 'App\\Models\\WhyChooseSection', 1, 'why_choose_image', 'markus', 'markus.jpg', 'image/jpeg', 'public', 'public', 940991, '[]', '[]', '[]', '[]', 1, '2026-01-01 07:02:50', '2026-01-01 07:02:50'),
(97, '8f176d29-f389-4d67-809c-cbaee76e46fb', 'App\\Models\\HeroBanner', 9, 'mobile_background', '—Pngtree—online stock exchange market app_19871133', '—Pngtree—online-stock-exchange-market-app_19871133.jpg', 'image/jpeg', 'public', 'public', 903005, '[]', '[]', '[]', '[]', 2, '2026-01-06 17:11:13', '2026-01-06 17:11:13'),
(98, 'd8be45f8-a8f7-43be-a5dd-2aef8d2908d7', 'App\\Models\\HeroBanner', 10, 'background', '—Pngtree—person analyzing stock market data_19781914 (1)', '—Pngtree—person-analyzing-stock-market-data_19781914-(1).jpg', 'image/jpeg', 'public', 'public', 770032, '[]', '[]', '[]', '[]', 1, '2026-01-06 17:12:13', '2026-01-06 17:12:13'),
(100, '347aeac5-4cf5-4799-9f61-f431756fa1a9', 'App\\Models\\HeroBanner', 12, 'mobile_background', 'home_banner', 'home_banner.png', 'image/png', 'public', 'public', 287054, '[]', '[]', '[]', '[]', 4, '2026-01-08 04:53:08', '2026-01-08 04:53:08'),
(101, '545f7fa6-3442-4a71-b1f8-78b931579f9a', 'App\\Models\\HeroBanner', 12, 'background', 'home_banner', 'home_banner.png', 'image/png', 'public', 'public', 287054, '[]', '[]', '[]', '[]', 5, '2026-01-08 04:53:56', '2026-01-08 04:53:56'),
(102, 'd27a60f7-fdfe-4d97-9d7b-1817bf5c6581', 'App\\Models\\PageSection', 1, 'desktop', 'bangles', 'bangles.png', 'image/png', 'public', 'public', 1332841, '[]', '[]', '[]', '[]', 3, '2026-01-08 05:00:00', '2026-01-08 05:00:00'),
(103, '56aa8ca4-7459-4e47-8b4d-460ca0d343c7', 'App\\Models\\PageSection', 1, 'mobile', 'chain-784422_1280', 'chain-784422_1280.jpg', 'image/jpeg', 'public', 'public', 342328, '[]', '[]', '[]', '[]', 4, '2026-01-08 05:00:00', '2026-01-08 05:00:00'),
(105, '2c49aab2-b46f-4b63-815f-2f6f04d76675', 'App\\Models\\HowItWorksStep', 3, 'how_it_works_step', '8e2039cd82c06d0f6e7c08c9eaaf8f6338a955f5', 'step_3_1767875034.png', 'image/png', 'public', 'public', 138432, '[]', '[]', '[]', '[]', 1, '2026-01-08 12:23:54', '2026-01-08 12:23:54'),
(106, '92233a97-ec41-4211-9e43-304d8c30974a', 'App\\Models\\HowItWorksStep', 2, 'how_it_works_step', 'ChatGPT Image Jan 8, 2026, 06_08_22 PM', 'step_2_1767877660.png', 'image/png', 'public', 'public', 572207, '[]', '[]', '[]', '[]', 1, '2026-01-08 13:07:40', '2026-01-08 13:07:40'),
(107, '5c0535f1-78c8-4541-9c3e-0ee1b3c7c173', 'App\\Models\\HowItWorksStep', 4, 'how_it_works_step', '3230cfd1a5d73e62771db280693ac5ddd8367432', 'step_4_1767877972.png', 'image/png', 'public', 'public', 372068, '[]', '[]', '[]', '[]', 1, '2026-01-08 13:12:52', '2026-01-08 13:12:52'),
(108, '89a6c463-926a-4c17-b098-5dd7530f5e86', 'App\\Models\\HowItWorksStep', 5, 'how_it_works_step', 'ea6c7c6637a5e2e464e4932130409389c4567c02', 'step_5_1767877972.png', 'image/png', 'public', 'public', 229757, '[]', '[]', '[]', '[]', 1, '2026-01-08 13:12:52', '2026-01-08 13:12:52'),
(115, '6e59f8b4-99a4-4aff-9e81-144c2269cf04', 'App\\Models\\AboutWhyPlatformSection', 1, 'why_platform_image', '4a43ed6ca35ab71a73284c7fa9da7c5470fbdaec', '4a43ed6ca35ab71a73284c7fa9da7c5470fbdaec.jpg', 'image/jpeg', 'public', 'public', 101394, '[]', '[]', '[]', '[]', 1, '2026-01-09 06:30:48', '2026-01-09 06:30:48'),
(121, '00c0aa3f-338b-4a9a-90cb-54c93403bd22', 'App\\Models\\DownloadAppSection', 1, 'image', 'ChatGPT Image Jan 9, 2026, 12_40_53 PM', 'ChatGPT-Image-Jan-9,-2026,-12_40_53-PM.webp', 'image/webp', 'public', 'public', 383638, '[]', '[]', '[]', '[]', 1, '2026-01-09 07:18:17', '2026-01-09 07:18:17'),
(126, 'b5fba397-911b-49d3-8810-7e35eee39965', 'App\\Models\\HomeKeyFeatureItem', 24, 'feature_images', '7c77344e9fb9b07caf998c80cca7152a44b8845e (2)', '7c77344e9fb9b07caf998c80cca7152a44b8845e-(2).png', 'image/png', 'public', 'public', 318799, '[]', '[]', '[]', '[]', 1, '2026-01-09 07:35:26', '2026-01-09 07:35:26'),
(127, '6977240f-54db-4bc8-813f-1f97ae391ede', 'App\\Models\\HomeKeyFeatureItem', 25, 'feature_images', '736b83f7a4fab9c40d8be54fbf6f4a0934c0fea8 (1)', '736b83f7a4fab9c40d8be54fbf6f4a0934c0fea8-(1).png', 'image/png', 'public', 'public', 230894, '[]', '[]', '[]', '[]', 1, '2026-01-09 07:35:44', '2026-01-09 07:35:44'),
(128, '3621daaf-c682-450b-9de3-1fabd66d7d71', 'App\\Models\\HomeKeyFeatureItem', 26, 'feature_images', '7cc6232188b8153ef33f93476a5c42b183242a10 (1)', '7cc6232188b8153ef33f93476a5c42b183242a10-(1).png', 'image/png', 'public', 'public', 260090, '[]', '[]', '[]', '[]', 1, '2026-01-09 07:35:59', '2026-01-09 07:35:59'),
(129, 'de96697b-312b-406a-8f0d-fdc7dac9304e', 'App\\Models\\Blog', 4, 'thumbnail', 'b1c169ada0afe99ee71c719b16aff5bec86fc635', 'b1c169ada0afe99ee71c719b16aff5bec86fc635.jpg', 'image/jpeg', 'public', 'public', 59757, '[]', '[]', '[]', '[]', 1, '2026-01-09 08:14:27', '2026-01-09 08:14:27'),
(130, 'c6216c98-04cb-4f3c-99cc-6f210ebc33df', 'App\\Models\\Blog', 3, 'thumbnail', 'e7ce9c05efd8c425c557f811dc836086c06227a7', 'e7ce9c05efd8c425c557f811dc836086c06227a7.jpg', 'image/jpeg', 'public', 'public', 85383, '[]', '[]', '[]', '[]', 1, '2026-01-09 08:16:35', '2026-01-09 08:16:35'),
(131, '6a1e0fe0-e585-4c69-a1b0-239d330c1cfb', 'App\\Models\\Blog', 2, 'thumbnail', '45be8c3383a7b2a3ef318ad0ebe24ab29dd3c070', '45be8c3383a7b2a3ef318ad0ebe24ab29dd3c070.jpg', 'image/jpeg', 'public', 'public', 440707, '[]', '[]', '[]', '[]', 1, '2026-01-09 08:21:03', '2026-01-09 08:21:03'),
(132, 'd72fc251-ebdf-4317-9935-9663d38e1d35', 'App\\Models\\OfferBanner', 1, 'offer_banner_desktop', '1723523618003', '1723523618003.png', 'image/png', 'public', 'public', 596265, '[]', '[]', '{\"web\":true,\"mobile\":true,\"thumb\":true}', '[]', 1, '2026-01-13 06:53:55', '2026-01-13 06:53:56'),
(133, '29544356-0631-4dec-bf70-3d100a51783a', 'App\\Models\\OfferBanner', 1, 'offer_banner_mobile', '1723523618003', '1723523618003.png', 'image/png', 'public', 'public', 596265, '[]', '[]', '{\"web\":true,\"mobile\":true,\"thumb\":true}', '[]', 2, '2026-01-13 06:53:56', '2026-01-13 06:53:57'),
(134, 'f2900b6f-b418-4982-a203-d3d3944ff42f', 'App\\Models\\HeroBanner', 8, 'background', 'istockphoto-2189341260-612x612', 'istockphoto-2189341260-612x612.jpg', 'image/jpeg', 'public', 'public', 17462, '[]', '[]', '[]', '[]', 1, '2026-01-13 07:03:22', '2026-01-13 07:03:22'),
(135, '7c408841-ec67-4ca2-9217-8f88d0a7973d', 'App\\Models\\HeroBanner', 8, 'mobile_background', 'istockphoto-2189341260-612x612', 'istockphoto-2189341260-612x612.jpg', 'image/jpeg', 'public', 'public', 17462, '[]', '[]', '[]', '[]', 2, '2026-01-13 07:03:22', '2026-01-13 07:03:22'),
(136, '62f5ae47-6d5a-4e4e-8733-68de1228821d', 'App\\Models\\News', 1, 'thumbnail', 'markus', 'markus.jpg', 'image/jpeg', 'public', 'public', 940991, '[]', '[]', '[]', '[]', 1, '2026-01-13 10:38:32', '2026-01-13 10:38:32'),
(138, 'ab872802-f3ad-4edd-bd63-722e4a3c76fc', 'App\\Models\\HeroBanner', 9, 'background', '—Pngtree—online stock exchange market app_19871133 (2)', '—Pngtree—online-stock-exchange-market-app_19871133-(2).jpg', 'image/jpeg', 'public', 'public', 903005, '[]', '[]', '[]', '[]', 3, '2026-01-13 17:12:56', '2026-01-13 17:12:56'),
(141, 'fb2a902c-5f1c-4f90-a3c5-a8a3c5872927', 'App\\Models\\HeroBanner', 11, 'background', 'ChatGPT Image Jan 3, 2026, 12_38_53 PM', 'ChatGPT-Image-Jan-3,-2026,-12_38_53-PM.png', 'image/png', 'public', 'public', 2464076, '[]', '[]', '[]', '[]', 3, '2026-01-13 17:16:21', '2026-01-13 17:16:21'),
(142, '4b94c43c-27a9-4c9c-a156-8bb1c514a738', 'App\\Models\\HeroBanner', 2, 'background', 'pngtree-live-stock-market-data-on-screen-background-image_20716580', 'pngtree-live-stock-market-data-on-screen-background-image_20716580.webp', 'image/webp', 'public', 'public', 23440, '[]', '[]', '[]', '[]', 1, '2026-01-13 17:17:15', '2026-01-13 17:17:15'),
(143, '0b3ab1bb-8b51-406f-b9aa-b10a1593eff3', 'App\\Models\\HeroBanner', 20, 'background', 'market-analysis-display-stockcake', 'market-analysis-display-stockcake.webp', 'image/webp', 'public', 'public', 39944, '[]', '[]', '[]', '[]', 1, '2026-01-13 17:18:29', '2026-01-13 17:18:29'),
(144, 'ec8109cd-2d0c-49b1-9c36-3b66f4b3ad76', 'App\\Models\\OfferBanner', 2, 'offer_banner_desktop', 'Gemini_Generated_Image_lbbarelbbarelbba', 'Gemini_Generated_Image_lbbarelbbarelbba.png', 'image/png', 'public', 'public', 1374085, '[]', '[]', '{\"web\":true,\"mobile\":true,\"thumb\":true}', '[]', 1, '2026-01-14 07:25:30', '2026-01-14 07:25:31'),
(145, '5d83bebd-5658-4e44-8752-5f12efbed0a2', 'App\\Models\\OfferBanner', 2, 'offer_banner_mobile', 'Gemini_Generated_Image_cbdphpcbdphpcbdp', 'Gemini_Generated_Image_cbdphpcbdphpcbdp.png', 'image/png', 'public', 'public', 1373102, '[]', '[]', '{\"web\":true,\"mobile\":true,\"thumb\":true}', '[]', 2, '2026-01-14 07:25:31', '2026-01-14 07:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `message_campaigns`
--

CREATE TABLE `message_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'info',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_campaigns`
--

INSERT INTO `message_campaigns` (`id`, `title`, `description`, `message`, `image`, `content`, `type`, `is_active`, `starts_at`, `ends_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'New Offer', 'Update New Offer.', 'Offer (50% OFF)', 'https://bharatstockmarketresearch.com/public/storage/campaigns/oO7gUZIYXJyEL9CyQwI5WrYprCu2zFLkZWNm13cZ.webp', 'Test Offer', 'offer', 1, '2026-01-13 17:57:00', '2026-01-27 17:57:00', 1, '2026-01-13 12:27:59', '2026-01-13 12:27:59'),
(2, 'New Info', 'Test for Update this...', 'test', 'https://bharatstockmarketresearch.com/public/storage/campaigns/iiNSKfeFnSU6qf4iFHA7WCQA80eT0TSCS2FGZ1Hi.png', 'test', 'info', 1, '2026-01-01 13:03:00', '2026-01-30 13:03:00', 1, '2026-01-14 07:33:56', '2026-01-14 07:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `message_campaign_logs`
--

CREATE TABLE `message_campaign_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_campaign_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `seen_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_05_060157_create_permission_tables', 2),
(6, '2025_12_05_062346_add_extra_details_to_users_table', 3),
(9, '2025_12_05_103745_create_personal_access_tokens_table', 4),
(10, '2025_12_05_103954_create_blog_categories_table', 5),
(11, '2025_12_05_104026_create_blogs_table', 5),
(12, '2025_12_05_104627_create_media_table', 5),
(15, '2025_12_08_073448_create_packages_table', 6),
(16, '2025_12_08_075504_create_package_categories_table', 6),
(17, '2025_12_10_055155_create_service_plans_table', 7),
(18, '2025_12_10_055200_create_service_plan_durations_table', 7),
(19, '2025_12_10_055214_create_service_plan_features_table', 7),
(20, '2025_12_10_103216_create_header_menus_table', 8),
(21, '2025_12_10_104855_create_header_settings_table', 9),
(22, '2025_12_11_065138_create_footer_columns_table', 10),
(23, '2025_12_11_065210_create_footer_links_table', 10),
(24, '2025_12_11_065225_create_footer_settings_table', 10),
(26, '2025_12_11_065247_create_footer_social_links_table', 11),
(27, '2025_12_12_085218_create_footer_brand_settings_table', 12),
(28, '2025_12_12_105210_create_hero_banners_table', 13),
(29, '2025_12_12_124234_create_inquiries_table', 14),
(31, '2025_12_12_125141_create_faqs_table', 15),
(32, '2025_12_13_084355_create_about_mission_values_table', 16),
(33, '2025_12_13_084426_create_about_core_value_sections_table', 16),
(34, '2025_12_13_084451_create_about_core_values_table', 16),
(35, '2025_12_13_084519_create_about_why_platform_sections_table', 16),
(36, '2025_12_13_084544_create_about_why_platform_contents_table', 16),
(37, '2025_12_13_103415_create_page_sections_table', 17),
(38, '2025_12_13_120739_create_home_counters_table', 18),
(39, '2025_12_13_123752_create_why_choose_sections_table', 19),
(42, '2025_12_13_125110_create_how_it_works_sections_table', 20),
(43, '2025_12_13_125124_create_how_it_works_steps_table', 20),
(44, '2025_12_15_061421_create_home_key_feature_sections_table', 21),
(45, '2025_12_15_061443_create_home_key_feature_items_table', 21),
(46, '2025_12_15_075658_create_reviews_table', 22),
(48, '2025_12_15_112352_create_download_app_section_table', 23),
(50, '2025_12_15_172534_create_contact_details_table', 24),
(52, '2025_12_17_081938_create_chat_messages_table', 25),
(55, '2025_12_18_053339_create_notifications_table', 26),
(56, '2025_12_18_053354_create_notification_users_table', 26),
(57, '2025_12_26_064048_create_user_subscriptions_table', 27),
(58, '2025_12_26_065130_add_duration_days_to_service_plan_durations', 28),
(59, '2025_12_26_083304_create_tip_categories_table', 29),
(60, '2025_12_26_083419_create_tips_table', 29),
(62, '2025_12_26_083709_create_tip_updates_table', 30),
(63, '2025_12_29_065245_create_policies_table', 31),
(67, '2025_12_29_080854_create_investor_charter_policies_table', 32),
(68, '2025_12_29_080903_create_investor_charter_pages_table', 32),
(69, '2025_12_29_080914_create_investor_charter_policy_logs_table', 32),
(70, '2025_12_26_083614_create_tip_plan_access_table', 33),
(71, '2026_01_06_052254_add_type_and_derivatives_to_tips_table', 33),
(72, '2026_01_06_083445_alter_tips_add_version_and_status_table', 34),
(73, '2026_01_07_112230_create_popups_table', 35),
(74, '2026_01_12_132230_create_marquees_table', 36),
(75, '2026_01_13_060307_create_offer_banners_table', 36),
(76, '2026_01_13_071804_create_message_campaigns_table', 37),
(77, '2026_01_13_071826_create_message_campaign_logs_table', 37),
(78, '2026_01_13_093620_create_news_table', 37),
(79, '2026_01_13_093816_create_news_categories_table', 37),
(80, '2026_01_14_060127_add_symbol_token_to_tips_table', 38);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 25),
(1, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `content_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content_json`)),
  `news_type` enum('regular','breaking','exclusive','live') NOT NULL DEFAULT 'regular',
  `location` varchar(255) DEFAULT NULL,
  `source_name` varchar(255) DEFAULT NULL,
  `source_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_keywords`)),
  `canonical_url` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','scheduled','archived') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `priority_weight` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `share_count` int(11) NOT NULL DEFAULT 0,
  `reading_time` int(11) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_for` timestamp NULL DEFAULT NULL,
  `table_of_contents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`table_of_contents`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `slug`, `short_description`, `content`, `content_json`, `news_type`, `location`, `source_name`, `source_url`, `video_url`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `status`, `is_featured`, `is_trending`, `allow_comments`, `priority_weight`, `view_count`, `share_count`, `reading_time`, `published_at`, `scheduled_for`, `table_of_contents`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Headline', 'headline', 'Regular News', '<p>News Taza Khabar..</p>', NULL, 'regular', 'Indore Madhya Pradesh', 'UTI', 'https://www.gyzabec.org', 'https://www.vajemisusu.org.au', 'test news', 'test news description', NULL, 'https://www.bajiri.info', 'published', 1, 1, 1, 0, 3, 0, 0, '2026-01-13 10:38:32', NULL, NULL, NULL, '2026-01-13 10:38:32', '2026-01-13 11:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color_code` varchar(255) NOT NULL DEFAULT '#4f46e5',
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_priority` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `color_code`, `icon`, `is_active`, `order_priority`, `meta_title`, `meta_description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sports & Others', 'sports-others', NULL, '#4ce666', NULL, 1, 0, NULL, NULL, NULL, '2026-01-13 10:38:08', '2026-01-13 10:54:12'),
(2, 'Stock Market News', 'stock-market-news', NULL, '#1457ad', NULL, 1, 0, NULL, NULL, NULL, '2026-01-13 11:49:28', '2026-01-13 11:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `reason`, `title`, `message`, `url`, `sender_id`, `data`, `created_at`, `updated_at`) VALUES
(1, 'chat', NULL, 'New Support Message', 'sss', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":25}', '2025-12-18 01:47:50', '2025-12-18 01:47:50'),
(2, 'chat', NULL, 'New Support Message', 'test..', '/admin/chat?user=27', 27, '{\"from_user_id\":27,\"from_user_name\":\"User #27\",\"chat_id\":26}', '2025-12-18 01:48:21', '2025-12-18 01:48:21'),
(3, 'chat', NULL, 'New Support Message', 'afsd', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":27}', '2025-12-25 03:58:00', '2025-12-25 03:58:00'),
(4, 'chat', NULL, 'New Support Message', 'dgfdf', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":29}', '2025-12-25 04:12:56', '2025-12-25 04:12:56'),
(5, 'chat', NULL, 'New Support Message', 'hello', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":1}', '2025-12-26 04:37:26', '2025-12-26 04:37:26'),
(6, 'chat', NULL, 'New Support Message', 'new live test', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":2}', '2025-12-29 13:11:12', '2025-12-29 13:11:12'),
(7, 'chat', NULL, 'New Support Message', 'hi', '/admin/chat?user=27', 27, '{\"from_user_id\":27,\"from_user_name\":\"Test User\",\"chat_id\":3}', '2025-12-30 14:13:06', '2025-12-30 14:13:06'),
(8, 'chat', NULL, 'New Support Message', 'test new', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":4}', '2026-01-02 07:33:33', '2026-01-02 07:33:33'),
(9, 'chat', NULL, 'New Support Message', 'test', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":5}', '2026-01-03 13:05:26', '2026-01-03 13:05:26'),
(10, 'chat', NULL, 'New Support Message', 'HELLO', '/admin/chat?user=1', 1, '{\"from_user_id\":1,\"from_user_name\":\"admin\",\"chat_id\":7}', '2026-01-12 02:42:06', '2026-01-12 02:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `notification_users`
--

CREATE TABLE `notification_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_users`
--

INSERT INTO `notification_users` (`id`, `notification_id`, `user_id`, `read_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-18 01:49:17', 1, '2025-12-18 01:47:50', '2025-12-18 01:49:17'),
(2, 2, 1, '2025-12-18 01:49:17', 1, '2025-12-18 01:48:21', '2025-12-18 01:49:17'),
(3, 3, 1, '2025-12-25 03:58:06', 1, '2025-12-25 03:58:00', '2025-12-25 03:58:06'),
(4, 4, 1, '2025-12-25 04:13:10', 1, '2025-12-25 04:12:56', '2025-12-25 04:13:10'),
(5, 5, 1, '2025-12-26 04:37:31', 1, '2025-12-26 04:37:26', '2025-12-26 04:37:31'),
(6, 6, 1, '2025-12-29 13:11:17', 1, '2025-12-29 13:11:12', '2025-12-29 13:11:17'),
(7, 7, 1, '2026-01-03 13:05:47', 1, '2025-12-30 14:13:06', '2026-01-03 13:05:47'),
(8, 8, 1, '2026-01-03 13:05:47', 1, '2026-01-02 07:33:33', '2026-01-03 13:05:47'),
(9, 9, 1, '2026-01-03 13:05:47', 1, '2026-01-03 13:05:26', '2026-01-03 13:05:47'),
(10, 10, 1, '2026-01-12 02:42:33', 1, '2026-01-12 02:42:06', '2026-01-12 02:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `offer_banners`
--

CREATE TABLE `offer_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(150) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `sub_heading` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `highlight_text` varchar(255) DEFAULT NULL,
  `button1_text` varchar(100) NOT NULL,
  `button1_link` varchar(255) NOT NULL,
  `button1_target` enum('_self','_blank') DEFAULT '_self',
  `button2_text` varchar(100) NOT NULL,
  `button2_link` varchar(255) NOT NULL,
  `button2_target` enum('_self','_blank') DEFAULT '_self',
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `device_visibility` enum('all','desktop','mobile') NOT NULL DEFAULT 'all',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `view_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `click_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offer_banners`
--

INSERT INTO `offer_banners` (`id`, `slug`, `heading`, `sub_heading`, `content`, `highlight_text`, `button1_text`, `button1_link`, `button1_target`, `button2_text`, `button2_link`, `button2_target`, `position`, `is_active`, `device_visibility`, `start_date`, `end_date`, `view_count`, `click_count`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'trade-smarter-with-instant-updates-1768287235', 'Trade smarter with instant updates', 'New Trending', 'New Offer For Sometimes', NULL, 'join now', '/', '_self', 'claim offer', '/', '_self', 1, 1, 'all', '2026-01-13 12:23:00', '2026-02-06 12:23:00', 0, 0, NULL, NULL, '2026-01-13 06:53:55', '2026-01-14 08:27:35', '2026-01-14 08:27:35'),
(2, 'limited-time-offer-1768375530', 'Unlock Premium Insights at 50% Off', 'Join over 10,000+ traders and investors getting real-time market signals. Start your journey today with our most popular annual plan.', 'Join over 10,000+ traders and investors getting real-time market signals. Start your journey today with our most popular annual plan.', 'LIMITED TIME OFFER', 'Claim Discount', 'https://www.google.com', NULL, 'View Plans', 'https://www.google.com', NULL, 0, 1, 'all', '2026-01-13 13:56:00', NULL, 0, 0, NULL, NULL, '2026-01-14 07:25:30', '2026-01-14 08:26:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `amount` decimal(10,2) NOT NULL,
  `discount_percentage` int(11) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `trial_days` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `validity_type` enum('days','months','years') NOT NULL DEFAULT 'days',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `max_devices` int(11) NOT NULL DEFAULT 1,
  `telegram_support` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_type`, `name`, `slug`, `description`, `features`, `amount`, `discount_percentage`, `discount_amount`, `final_amount`, `trial_days`, `duration`, `validity_type`, `meta_title`, `meta_description`, `is_featured`, `status`, `max_devices`, `telegram_support`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Intraday', 'new test update check', 'new-test', 'test update the description.', '\"[\\\"Feature1\\\",\\\"Feature2\\\"]\"', 200.00, 10, 20.00, 180.00, 3, 3, 'days', 'test package', 'test', 1, 1, 3, 1, 1, '2025-12-09 00:07:57', '2025-12-09 04:50:55'),
(3, 'Niffty', 'Premium Package', 'premium-plan', 'This is the updated premium package', '\"[\\\"new 1\\\",\\\"new 2\\\",\\\"new 3\\\"]\"', 450.00, 10, 45.00, 405.00, 5, 30, 'days', 'Premium Package SEO Title', 'Premium package SEO description', 1, 1, 5, 1, 1, '2025-12-09 04:46:31', '2025-12-09 05:43:27'),
(4, 'Niffty', 'Dana Bonner', 'dana-bonner', 'Laboris ipsum culpa', '\"[\\\"Feature1\\\",\\\"Feature2\\\"]\"', 100.00, 10, 10.00, 90.00, 14, 97, 'days', 'Nisi nesciunt cupidatat autem duis consequatur Officia nos', 'Exercitation sed numquam possimus temporibus', 0, 0, 69, 0, 53, '2025-12-09 04:48:21', '2025-12-09 05:51:57'),
(5, 'Intraday', 'Kane Wynn', 'kane-wynn', 'Nemo repudiandae nul', '\"[\\\"test feature 1\\\",\\\"test feature 2\\\",\\\"test feature 3\\\"]\"', 100.00, 5, 5.00, 95.00, 10, 31, 'months', 'Blanditiis fugiat numquam consectetur quis nulla laudantium', 'Odit voluptatem consequatur Lorem aliqua Maiores', 1, 1, 18, 1, 74, '2025-12-09 05:46:40', '2025-12-09 05:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `package_categories`
--

CREATE TABLE `package_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_categories`
--

INSERT INTO `package_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Intraday', 'intraday', NULL, '2025-12-08 02:49:22', '2025-12-08 02:49:22'),
(2, 'Niffty', 'niffty', NULL, '2025-12-08 23:43:04', '2025-12-08 23:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `page_sections`
--

CREATE TABLE `page_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_type` varchar(255) NOT NULL,
  `section_key` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `button_1_text` varchar(255) DEFAULT NULL,
  `button_1_link` varchar(255) DEFAULT NULL,
  `button_2_text` varchar(255) DEFAULT NULL,
  `button_2_link` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_sections`
--

INSERT INTO `page_sections` (`id`, `page_type`, `section_key`, `title`, `subtitle`, `badge`, `slug`, `description`, `content`, `button_1_text`, `button_1_link`, `button_2_text`, `button_2_link`, `meta_title`, `meta_description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'home', 'home', 'home', 'home', 'home', NULL, 'short description', '<p>Write section content</p>', 'home', '/home', 'about', '/about', NULL, NULL, 0, 1, '2025-12-13 05:34:07', '2026-01-08 05:00:00'),
(3, 'about', NULL, 'Test', 'Test', 'WHY WE BUILT THIS PLATFORM', NULL, 'WHY WE BUILT THIS PLATFORM', '<p>dfdf</p>', 'test', 'WHY WE BUILT THIS PLATFORM', NULL, NULL, NULL, NULL, 0, 1, '2026-01-03 12:50:23', '2026-01-12 02:43:39'),
(4, 'services', '1', 'MY TEST ON', 'MY TEST 1', 'TESTING', NULL, 'THIS IS YOUR NEW TEST', '<p>KLKJFLSJFKLDJLFSJKLFJSKLFJSLKFJLKDSFJLSFJKLFJLKDSJFKLDSJFKLDSJFLKJFLSJKLF</p>', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2026-01-12 02:45:56', '2026-01-12 02:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage users', 'web', '2025-12-05 00:36:27', '2025-12-05 00:36:27'),
(2, 'manage stocks', 'web', '2025-12-05 00:36:27', '2025-12-05 00:36:27'),
(3, 'view dashboard', 'web', '2025-12-05 00:36:27', '2025-12-05 00:36:27'),
(5, 'view roles', 'web', '2025-12-05 02:35:44', '2025-12-05 02:35:44'),
(6, 'manage home', 'web', '2025-12-25 03:56:57', '2025-12-25 03:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api-token', '1246bb88c4a337d752f548c91f8ec4105a96d5ceba6e7106e6fe19a1ef38554a', '[\"*\"]', '2025-12-06 02:56:46', NULL, '2025-12-06 02:50:41', '2025-12-06 02:56:46'),
(2, 'App\\Models\\User', 1, 'api-token', 'f32a7710d5b51d5da73e53a097f832bac517b8e3cabe2d6b96ec6820b4e18ccd', '[\"*\"]', '2025-12-09 05:25:22', NULL, '2025-12-08 00:55:01', '2025-12-09 05:25:22'),
(3, 'App\\Models\\User', 1, 'api-token', 'a50eb27e8d2578a5087ad5db73a5a85a906754e9b308da2ccc2d097ca67563d8', '[\"*\"]', '2025-12-11 04:16:17', NULL, '2025-12-11 00:40:33', '2025-12-11 04:16:17'),
(4, 'App\\Models\\User', 1, 'api-token', '1b96bdd89328f1bc6ff35b307b3941f5701f57b79f6193ca8d1c8391e490a10d', '[\"*\"]', '2025-12-16 02:41:05', NULL, '2025-12-16 02:11:12', '2025-12-16 02:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `policy_contents`
--

CREATE TABLE `policy_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_master_id` bigint(20) UNSIGNED NOT NULL,
  `content` longtext NOT NULL,
  `updates_summary` text DEFAULT NULL,
  `version_number` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy_contents`
--

INSERT INTO `policy_contents` (`id`, `policy_master_id`, `content`, `updates_summary`, `version_number`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '<p><strong>1. Collection of Information :</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</li><li>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</li></ul><p><strong>2. Use of Information :</strong></p><p>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>&nbsp;</li></ul>', NULL, 1, 0, '2025-12-29 01:32:46', '2026-01-11 12:15:58'),
(2, 1, '<p><strong>1. Collection of Information :</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</li><li>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</li></ul><p><strong>2. Use of Information :</strong></p><p>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>&nbsp;</li></ul>', 'Changes in 1. Collection of the Information\r\n for the personal Information..', 2, 0, '2025-12-29 01:35:42', '2026-01-11 12:15:58'),
(3, 2, '<h2><strong>1. Acceptance of Terms</strong><br>By accessing or using our website, services, or applications, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</h2><h2><strong>2. Eligibility</strong><br>You must be at least 18 years old to use our services. By using this website, you confirm that you meet this requirement and have the legal capacity to enter into a binding agreement.</h2><h2><strong>3. Use of Services</strong><br>You agree to use the services only for lawful purposes.</h2><p>&nbsp;</p><ul><li>You must not misuse, hack, or attempt unauthorized access to the platform.</li></ul><p><br>You are responsible for maintaining the confidentiality of your account credentials.</p><p><br>&nbsp;</p><h2><strong>4. Intellectual Property</strong></h2><p>All content, logos, designs, text, graphics, and software on this website are the intellectual property of the company and are protected by applicable copyright and trademark laws.</p><h2><strong>5. User Content</strong></h2><p>Any content submitted by users remains their responsibility. We reserve the right to remove content that violates these terms or applicable laws.</p><h2><strong>6. Payments &amp; Refunds</strong></h2><p>All payments made on the platform are subject to our pricing and refund policy. Fees once paid are non-refundable unless explicitly stated otherwise.</p><h2><strong>7. Limitation of Liability</strong></h2><p>We shall not be liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services.</p><p><br>&nbsp;</p><h2><strong>8. Termination</strong></h2><p>We reserve the right to suspend or terminate your access to the services at any time, without prior notice, if you violate these Terms and Conditions.</p><p>&nbsp;</p>', NULL, 1, 0, '2025-12-29 01:49:44', '2026-01-11 17:24:37'),
(4, 2, '<h2><strong>1. Acceptance of Terms</strong><br>By accessing or using our website, services, or applications, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</h2><h2><strong>2. Eligibility</strong><br>You must be at least 18 years old to use our services. By using this website, you confirm that you meet this requirement and have the legal capacity to enter into a binding agreement.</h2><ul><li><strong>3. Use of Services</strong><br>You agree to use the services only for lawful purposes.</li><li>&nbsp;</li><li>You must not misuse, hack, or attempt unauthorized access to the platform.</li><li><br>You are responsible for maintaining the confidentiality of your account credentials.</li></ul><p><br>&nbsp;</p><h2><strong>4. Intellectual Property</strong></h2><p>All content, logos, designs, text, graphics, and software on this website are the intellectual property of the company and are protected by applicable copyright and trademark laws.</p><h2><strong>5. User Content</strong></h2><p>Any content submitted by users remains their responsibility. We reserve the right to remove content that violates these terms or applicable laws.</p><h2><strong>6. Payments &amp; Refunds</strong></h2><p>All payments made on the platform are subject to our pricing and refund policy. Fees once paid are non-refundable unless explicitly stated otherwise.</p><h2><strong>7. Limitation of Liability</strong></h2><p>We shall not be liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services.</p><p><br>&nbsp;</p><h2><strong>8. Termination</strong></h2><p>We reserve the right to suspend or terminate your access to the services at any time, without prior notice, if you violate these Terms and Conditions.</p><p>&nbsp;</p>', NULL, 2, 0, '2025-12-29 01:50:21', '2026-01-11 17:24:37'),
(5, 2, '<h2><strong>1. Acceptance of Terms</strong><br>By accessing or using our website, services, or applications, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</h2><h2><strong>2. Eligibility</strong><br>You must be at least 18 years old to use our services. By using this website, you confirm that you meet this requirement and have the legal capacity to enter into a binding agreement.</h2><ul><li><strong>3. Use of Services</strong><br>You agree to use the services only for lawful purposes.</li><li>You must not misuse, hack, or attempt unauthorized access to the platform.</li><li>You are responsible for maintaining the confidentiality of your account credentials.&nbsp;</li></ul><h2><strong>4. Intellectual Property</strong></h2><p>All content, logos, designs, text, graphics, and software on this website are the intellectual property of the company and are protected by applicable copyright and trademark laws.</p><h2><strong>5. User Content</strong></h2><p>Any content submitted by users remains their responsibility. We reserve the right to remove content that violates these terms or applicable laws.</p><h2><strong>6. Payments &amp; Refunds</strong></h2><p>All payments made on the platform are subject to our pricing and refund policy. Fees once paid are non-refundable unless explicitly stated otherwise.</p><h2><strong>7. Limitation of Liability</strong></h2><p>We shall not be liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services.</p><h2><strong>8. Termination</strong></h2><p>We reserve the right to suspend or terminate your access to the services at any time, without prior notice, if you violate these Terms and Conditions.</p><p>&nbsp;</p>', NULL, 3, 0, '2025-12-29 01:51:12', '2026-01-11 17:24:37'),
(6, 2, '<h2><strong>1. Acceptance of Terms</strong><br>By accessing or using our website, services, or applications, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</h2><h2><strong>2. Eligibility</strong><br>You must be at least 18 years old to use our services. By using this website, you confirm that you meet this requirement and have the legal capacity to enter into a binding agreement.</h2><h2><strong>3. Use of Services</strong><br>You agree to use the services only for lawful purposes.</h2><ul><li>You must not misuse, hack, or attempt unauthorized access to the platform.</li><li>You are responsible for maintaining the confidentiality of your account credentials.&nbsp;</li></ul><h2><strong>4. Intellectual Property</strong></h2><p>All content, logos, designs, text, graphics, and software on this website are the intellectual property of the company and are protected by applicable copyright and trademark laws.</p><h2><strong>5. User Content</strong></h2><p>Any content submitted by users remains their responsibility. We reserve the right to remove content that violates these terms or applicable laws.</p><h2><strong>6. Payments &amp; Refunds</strong></h2><p>All payments made on the platform are subject to our pricing and refund policy. Fees once paid are non-refundable unless explicitly stated otherwise.</p><h2><strong>7. Limitation of Liability</strong></h2><p>We shall not be liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services.</p><h2><strong>8. Termination</strong></h2><p>We reserve the right to suspend or terminate your access to the services at any time, without prior notice, if you violate these Terms and Conditions.</p><p>&nbsp;</p>', NULL, 4, 0, '2025-12-29 01:51:52', '2026-01-11 17:24:37'),
(7, 3, '<ol><li><strong>Collection of Information</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</li></ol><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</li><li>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</li><li>&nbsp;</li><li><strong>Use of Information</strong><br>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</li><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</li><li>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.<br><br><strong>Governing Law</strong></li></ul><p>This policy will be governed by and construed in accordance with the laws of India and subjected to the exclusive jurisdiction of Courts of Gurugram.</p><p><br>&nbsp;</p>', NULL, 1, 0, '2025-12-29 01:55:51', '2026-01-11 13:40:00'),
(8, 3, '<p><strong>1. &nbsp;Collection of Information</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</p><ul><li>&nbsp;</li></ul><p><strong>2. Use of Information</strong><br>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.<br><br><strong>3. Governing Law</strong></p><p>This policy will be governed by and construed in accordance with the laws of India and subjected to the exclusive jurisdiction of Courts of Gurugram.</p><p><br>&nbsp;</p>', NULL, 2, 0, '2025-12-29 01:57:49', '2026-01-11 13:40:00');
INSERT INTO `policy_contents` (`id`, `policy_master_id`, `content`, `updates_summary`, `version_number`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 3, '<p><strong>1. &nbsp;Collection of Information</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</p><p>&nbsp;</p><p><strong>2. Use of Information</strong><br>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.<br><br><strong>3. Governing Law</strong></p><p>This policy will be governed by and construed in accordance with the laws of India and subjected to the exclusive jurisdiction of Courts of Gurugram.</p><p><br>&nbsp;</p>', NULL, 3, 0, '2025-12-29 01:58:11', '2026-01-11 13:40:00'),
(10, 1, '<p><strong>1. Collection of Information :</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</li><li>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</li></ul><p><strong>2. Use of Information :</strong></p><p>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><ul><li>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</li><li>&nbsp;</li></ul>', NULL, 3, 0, '2026-01-06 15:01:56', '2026-01-11 12:15:58'),
(11, 1, '<h2><strong>1.</strong> <strong>Information We Collect</strong></h2><ul><li>Name, email, phone number</li><li>KYC documents (PAN, address proof, etc.)</li><li>Payment transaction details</li><li>Website usage data (non-personal)</li></ul><p>&nbsp;</p><h2><strong>2. Use of Information</strong></h2><p>Your data is used for:</p><ul><li>KYC compliance</li><li>Regulatory reporting</li><li>Service delivery</li><li>Customer communication</li><li>Legal &amp; compliance obligations</li></ul><p>&nbsp;</p><h2><strong>3. Data Sharing</strong></h2><p>We <strong>do not sell or trade</strong> your personal data.</p><p>Information may be shared only with:</p><ul><li>SEBI / RAASB / KRA agencies</li><li>Legal or regulatory authorities (if required by law)</li></ul><p>&nbsp;</p><h2><strong>4. Data Security</strong></h2><p>We implement reasonable safeguards; however:</p><ul><li>Internet data transmission is <strong>not 100% secure</strong></li><li>You acknowledge this risk when using our services</li></ul><p>&nbsp;</p><h2><strong>5. Data Retention</strong></h2><p>Client data is retained as per SEBI regulations and applicable Indian laws.</p><p>&nbsp;</p><h2><strong>6. Your Rights</strong></h2><p>You may request:</p><ul><li>Correction of inaccurate data</li><li>Update of contact details</li><li>Clarification on data usage</li></ul><p>&nbsp;</p><h2><strong>7. Contact for Privacy Queries</strong></h2><p>📧 <strong>namitarathore05071992@gmail.com</strong></p>', NULL, 4, 0, '2026-01-07 10:54:55', '2026-01-11 12:15:58'),
(12, 2, '<h2><strong>1. Introduction</strong></h2><p>These Terms &amp; Conditions (“T&amp;C”) govern the access and use of research services provided by <strong>Bharat Stock Market Research</strong>, a SEBI Registered Research Analyst (Registration No. <strong>INH000023728</strong>), owned by <strong>Namita Rathore</strong> (“RA”, “We”, “Us”).</p><p>&nbsp;</p><p>By accessing or subscribing to our services, you (“Client”, “You”) agree to be legally bound by these Terms, SEBI (Research Analyst) Regulations, 2014, and all applicable SEBI circulars.</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>2. Nature of Services</strong></h2><ul><li>We provide <strong>research and analysis only</strong></li><li><strong>No trade execution</strong>, fund handling, portfolio management, or assured returns</li><li>All recommendations are <strong>educational and informational in nature</strong></li><li>Past performance does <strong>not</strong> guarantee future results</li></ul><p>&nbsp;</p><h2><strong>3. Eligibility</strong></h2><ul><li>You must be <strong>18 years or older</strong></li><li>Must be legally competent to contract</li><li>Completion of <strong>KYC verification</strong> is mandatory</li><li>Services may be suspended if KYC is incomplete or incorrect</li></ul><p>&nbsp;</p><h2><strong>4. Fees &amp; Payments</strong></h2><ul><li>Maximum fee for Individual/HUF clients: <strong>₹1,51,000 per annum per family</strong></li><li>Fees exclude applicable statutory taxes</li><li>Payments accepted <strong>only via banking channels</strong> (UPI, NEFT, RTGS, Cheque, etc.)</li><li>Cash payments are strictly prohibited</li></ul><p>&nbsp;</p><h2><strong>5. No Guarantee of Returns</strong></h2><p>All investments are subject to market risks.<br>We <strong>do not guarantee profits, accuracy, or risk-free returns</strong>, and we are not liable for any losses arising from reliance on our research.</p><p>&nbsp;</p><h2><strong>6. Confidentiality &amp; Usage Restrictions</strong></h2><ul><li>Research content is <strong>strictly for personal use</strong></li><li>Redistribution, resale, or public sharing is prohibited</li><li>Legal action may be taken for misuse</li></ul><p>&nbsp;</p><h2><strong>7. Suspension &amp; Termination</strong></h2><p>We reserve the right to suspend or terminate services:</p><ul><li>For violation of these Terms</li><li>Non-payment of fees</li><li>Regulatory directions from SEBI</li></ul><p>&nbsp;</p><h2><strong>8. Grievance Redressal</strong></h2><p><strong>Contact Person:</strong> Namita Rathore<br><strong>Email:</strong> namitarathore05071992@gmail.com<br><strong>Phone:</strong> +91 9457296893<br><strong>Working Hours:</strong> Mon–Fri, 9 AM – 5 PM</p><p>&nbsp;</p><p>Unresolved complaints may be escalated via:</p><p>&nbsp;</p><ul><li><strong>SEBI SCORES</strong></li><li><strong>SMART ODR Portal</strong></li></ul><p>&nbsp;</p><h2><strong>9. Governing Law</strong></h2><p>These Terms shall be governed by the laws of <strong>India</strong>, with jurisdiction in <strong>Uttar Pradesh</strong>.</p>', NULL, 5, 0, '2026-01-07 10:55:47', '2026-01-11 17:24:37'),
(13, 4, '<h2><strong>1. Refund Eligibility</strong></h2><p>Refunds are governed strictly by <strong>SEBI RA Regulations</strong>.</p><p>&nbsp;</p><p>✔ Refunds are allowed <strong>only for the unexpired portion</strong> of the subscription<br>✔ Refunds are calculated on a <strong>pro-rata basis</strong></p><p>&nbsp;</p><h2><strong>2. Non-Refundable Cases</strong></h2><p>❌ Partial month usage is generally non-refundable<br>❌ No refund for services already consumed<br>❌ No penalty or breakage fee shall be charged</p><p>&nbsp;</p><h2><strong>3. Regulatory Suspension</strong></h2><p>If the RA’s SEBI registration is:</p><ul><li><strong>Suspended for more than 60 days</strong>, or</li><li><strong>Cancelled</strong></li></ul><p>Then unused fees will be refunded from the effective date onward.</p><p>&nbsp;</p><h2><strong>4. Mode &amp; Timeline</strong></h2><ul><li>Refunds are processed via the <strong>original payment method</strong></li><li>Timeline as per SEBI prescribed norms</li></ul><p>&nbsp;</p><h2><strong>5. Contact for Refund Requests</strong></h2><p>📧 <strong>namitarathore05071992@gmail.com</strong><br>📞 <strong>+91 9457296893</strong></p>', NULL, 1, 1, '2026-01-07 10:56:49', '2026-01-07 10:56:49'),
(14, 1, '<h2><strong>1.</strong> <strong>Information We Collect</strong></h2><ul><li>Name, email, phone number</li><li>KYC documents (PAN, address proof, etc.)</li><li>Payment transaction details</li><li>Website usage data (non-personal)</li></ul><p>&nbsp;</p><h2><strong>2. Use of Information</strong></h2><p>Your data is used for:</p><ul><li>KYC compliance</li><li>Regulatory reporting</li><li>Service delivery</li><li>Customer communication</li><li>Legal &amp; compliance obligations</li></ul><p>&nbsp;</p><h2><strong>3. Data Sharing</strong></h2><p>We <strong>do not sell or trade</strong> your personal data.</p><p>Information may be shared only with:</p><ul><li>SEBI / RAASB / KRA agencies</li><li>Legal or regulatory authorities (if required by law)</li></ul><p>&nbsp;</p><h2><strong>4. Data Security</strong></h2><p>We implement reasonable safeguards; however:</p><ul><li>Internet data transmission is <strong>not 100% secure</strong></li><li>You acknowledge this risk when using our services</li></ul><p>&nbsp;</p><h2><strong>5. Data Retention</strong></h2><p>Client data is retained as per SEBI regulations and applicable Indian laws.</p><p>&nbsp;</p><h2><strong>6. Your Rights</strong></h2><p>You may request:</p><ul><li>Correction of inaccurate data</li><li>Update of contact details</li><li>Clarification on data usage</li></ul><p>&nbsp;</p><h2><strong>7. Contact for Privacy Queries</strong></h2><p>📧 <strong>namitarathore05071992@gmail.com</strong></p>', NULL, 5, 1, '2026-01-11 12:15:58', '2026-01-11 12:15:58'),
(15, 3, '<p><strong>1. &nbsp;Collection of Information</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</p><p>&nbsp;</p><p><strong>2. Use of Information</strong><br>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.<br><br><strong>3. Governing Law</strong></p><p>This policy will be governed by and construed in accordance with the laws of India and subjected to the exclusive jurisdiction of Courts of Gurugram.</p><p><br>&nbsp;</p>', NULL, 4, 0, '2026-01-11 13:35:46', '2026-01-11 13:40:00'),
(16, 3, '<p><strong>1. &nbsp;Collection of Information</strong><br>We may collect Personal Information, Transaction Information and Non-Personal Information (defined below) from You when You register or set up an account with Us on the Platform or when You avail the Services. You can browse certain sections of the Platform without being a registered member, however, to avail certain Services on the Platform (such as investing in Stocks, P2P Lending etc.) You are required to register with Us. This Privacy Policy applies to the following information:</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.</p><p>&nbsp;</p><p><strong>2. Use of Information</strong><br>We use the Personal Information, Non-Personal Information, Transactional Information and User Communications and such other information provided by You for the following: (i) to provide and improve the Services on the Platform that You request; (ii) to resolve disputes and troubleshoot problems; (iii) to help promote a safe service on the Platform and protect the security and integrity of the Platform, the Services and the users; (iv) collect money from You in relation to the Services, (v) inform You about online and offline offers, products, services, and updates; (vi) customize Your experience on the Platform or share marketing material with You; (vii) to detect, prevent and protect Us from any errors, fraud and other criminal or prohibited activity on the Platform; (viii) enforce and inform about our terms and conditions; (ix) to process and fulfil Your request for Services or respond to Your comments, and queries on the Platform; (x) to contact You; (xi) to allow Our business partners and/or associates to present customised messages to You; (xii) to communicate important notices or changes in the Services, use of the Platform and the terms/policies which govern the relationship between You and the Company and with Our affiliates for providing Services to You; and (xiii) for any other purpose after obtaining Your consent at the time of collection.</p><p>Information You provide Us: You may provide certain information to Us voluntarily while registering on Our Platform or for using Our Services. Such information include any identification/ correspondence details including Your mobile number, email address, password, date of birth, gender, Permanent Account Number (PAN), signature, marital status, nominee details, residential/ current address, any national identifiers such as identity card / passport details / Aadhaar card details / Voter ID / driving license, and/or education details. We may also ask You to provide certain additional information about You or any person acting on Your behalf on a case-to-case basis (collectively “Personal Information”). Further, You hereby acknowledge and agree that Our affiliates or group or subsidiary companies registered with financial services regulators may retrieve from Your records available with third party including from Know Your Customer (KYC) Registration Agency (KRA) such as name, KYC details, KYC status, father’s name, occupation, address details and related documents.</p><p>Transactional Information: We may also ask You for certain financial information, including Your billing address, bank account details, income, expenses, and/or credit history, including transaction history, balances, and/or other payment related details or other payment method data, and debit instructions or other standing instructions to process payments for the Services. Further, if You choose to invest through the Platform, We will also collect information about Your transactions including transaction status/ ID and details and Your investing patterns and behaviour (collectively “Transaction Information”).</p><p>Non-Personal Information and Cookies: We may also collect certain non-personal information, such as Your internet protocol address, web request, operating system, browser type, URL, internet service provider, IP address, aggregate user data, browser type, software and hardware attributes, pages You request, and cookie information, etc. which will not identify with You specifically (“Non – Personal Information”), while You browse, access or use the Platform. We receive and store Non – Personal Information, using data collection devices such as “cookies” on certain pages of the Platform, in order to help and analyze Our web – page flow, track user trends, measure promotional effectiveness, and promote trust and safety. We offer certain additional features on the Platform that are only available through the use of a “cookie”. We place both permanent and temporary cookies in Your computer’s hard drive. We also use cookies to allow You to enter Your password less frequently during a session on the Platform. Most cookies are “session cookies,” meaning that they are automatically deleted from Your hard drive at the end of a session. You are always free to decline Our cookies if Your browser permits, although in that case, You may not be able to use certain features or Services being provided on the Platform or You may be required to re-enter Your password each time you log – in or access the Platform during a session. No Personal Data will be collected via cookies and other tracking technology; however, if You previously provided Personal Data, cookies may be tied to such information. When and if You download and/or use the Platform through Your mobile device, We may receive information about Your location, Your IP address, and/or Your mobile device, including a unique identifier number for Your device. We may use this information to provide You with location-based Services including but not limited to search results and other personalized content. You can withdraw Your consent at any time by disabling the location-tracking functions on Your mobile. However, this may affect Your use/ enjoyment of certain features on Our Platform. You acknowledge and agree that when You browse the Platform without being a registered member or without providing Your Personal Information, We may still collect and store Your Non-Personal Information.<br><br><strong>3. Governing Law</strong></p><p>This policy will be governed by and construed in accordance with the laws of India and subjected to the exclusive jurisdiction of Courts of Gurugram.</p><p>&nbsp;</p><h4><strong>Grievance Redressal</strong></h4><p>For any complaints or grievances related to our research services, please contact:</p><p><strong>Email: namitarathore05071992@gmail.com</strong></p><p><strong>Phone:</strong> <a href=\"tel:+918187861272\">+91 </a>9457296893</p><p><strong>Response Time:</strong> Within 30 days of receipt of the query.&nbsp;</p><p><br>&nbsp;</p>', NULL, 5, 1, '2026-01-11 13:40:00', '2026-01-11 13:40:00');
INSERT INTO `policy_contents` (`id`, `policy_master_id`, `content`, `updates_summary`, `version_number`, `is_active`, `created_at`, `updated_at`) VALUES
(17, 5, '<h2>Anti-Money Laundering (AML) Policy</h2><p><strong>Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore)</strong></p><h2>1. Introduction</h2><p>Optitrade Pro Services is committed to complying with the provisions of the Prevention of Money Laundering Act, 2002 (PMLA) and the rules notified thereunder. This policy outlines the framework for implementing Anti-Money Laundering (AML) measures, including procedures for client due diligence, monitoring of transactions, and reporting obligations.</p><h2>2. Regulatory Framework</h2><ul><li>Prevention of Money Laundering Act, 2002 (PMLA)</li><li>Securities and Exchange Board of India (SEBI) Guidelines</li><li>Financial Intelligence Unit – India (FIU-IND) Guidelines</li><li>Other relevant laws, rules, and regulations</li></ul><h2>3. Scope of the Policy</h2><p>This policy applies to all clients, partners, and associates of Optitrade Pro Services involved in financial transactions.</p><h2>4. Client Due Diligence (CDD) Process</h2><h3>a) Policy for Acceptance of Clients</h3><ul><li>No account shall be opened in a fictitious or anonymous name.</li><li>Clients must provide valid Know Your Customer (KYC) documents.</li><li>Accounts will not be opened for individuals/entities banned by SEBI/Stock Exchanges.</li><li>Risk assessment of clients shall be conducted using various parameters such as geographical location, nature of business, and financial transactions.</li></ul><h3>b) Procedure for Identifying Clients</h3><ul><li>Collect and verify PAN Card, Aadhaar, or other government-issued identity proof.</li><li>Validate KYC details through SEBI-registered KYC Registration Agencies (KRAs).</li><li>Conduct enhanced due diligence for high-risk clients.</li></ul><h3>c) Identifying Beneficial Ownership and Control</h3><ul><li>Identify and verify the ultimate beneficial owner (UBO) of an account.</li><li>Establish ownership/control of an entity in cases where the client is a corporate entity or a trust.</li></ul><h2>5. Transaction Monitoring and Reporting</h2><h3>a) Monitoring Transactions</h3><ul><li>Volume, frequency, and pattern of trades</li><li>Unusual or unjustified complexity</li><li>Lack of economic rationale</li><li>Transactions involving high-risk jurisdictions</li></ul><h3>b) Suspicious Transaction Reporting (STR)</h3><ul><li>Involve proceeds of criminal activities.</li><li>Appear unusually complex or lack an economic purpose.</li><li>Suggest an attempt to avoid regulatory reporting thresholds.</li></ul><h3>c) Cash Transaction Reporting (CTR)</h3><ul><li>Transactions involving cash deposits or withdrawals of ₹10 lakh or more (or equivalent in foreign currency) in a single day will be reported to FIU-IND.</li></ul><h2>6. Record-Keeping</h2><ul><li>All records related to client identification, transaction history, and AML compliance will be maintained for a minimum period of 10 years.</li><li>Records shall be made available to regulatory authorities upon request.</li></ul><h2>7. Employee Training &amp; Awareness</h2><ul><li>Annual AML training sessions will be conducted as applicable.</li><li>Any suspicious activities must be reported to the relevant authorities immediately.</li><li>Awareness sessions will be conducted on the latest AML regulatory developments.</li></ul><h2>8. Internal Audit and Review</h2><ul><li>Optitrade Pro Services will conduct regular internal audits to assess the effectiveness of its AML measures.</li><li>Any observations from the audit will be reviewed and corrective actions will be taken.</li></ul><h2>9. Review of Policy</h2><ul><li>This policy shall be reviewed annually or as required by regulatory changes.</li><li>Updates shall be communicated to all relevant stakeholders.</li></ul><h2>10. Confidentiality and Compliance</h2><ul><li>All reports and client data shall be treated confidentially.</li><li>No disclosure shall be made to clients regarding AML investigations or reports filed.</li><li>Strict disciplinary action will be taken against any violations of AML regulations.</li></ul><h2>11. Cooperation with Law Enforcement Authorities</h2><ul><li>Optitrade Pro Services will fully cooperate with regulatory authorities such as SEBI, FIU-IND, and law enforcement agencies in matters related to AML compliance.</li><li>Any request for information from such agencies shall be responded to promptly.</li></ul><p><strong>This AML Policy serves as a guiding document for ensuring compliance with Anti-Money Laundering regulations and safeguarding Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore) Services against financial crimes.</strong></p>', NULL, 1, 0, '2026-01-11 15:10:50', '2026-01-11 16:37:55'),
(18, 5, '<h2>Anti-Money Laundering (AML) Policy</h2><p><strong>Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore)</strong></p><h2>1. Introduction</h2><p>Optitrade Pro Services is committed to complying with the provisions of the Prevention of Money Laundering Act, 2002 (PMLA) and the rules notified thereunder. This policy outlines the framework for implementing Anti-Money Laundering (AML) measures, including procedures for client due diligence, monitoring of transactions, and reporting obligations.</p><h2>2. Regulatory Framework</h2><ul><li>Prevention of Money Laundering Act, 2002 (PMLA)</li><li>Securities and Exchange Board of India (SEBI) Guidelines</li><li>Financial Intelligence Unit – India (FIU-IND) Guidelines</li><li>Other relevant laws, rules, and regulations</li></ul><h2>3. Scope of the Policy</h2><p>This policy applies to all clients, partners, and associates of Optitrade Pro Services involved in financial transactions.</p><h2>4. Client Due Diligence (CDD) Process</h2><h3>a) Policy for Acceptance of Clients</h3><ul><li>No account shall be opened in a fictitious or anonymous name.</li><li>Clients must provide valid Know Your Customer (KYC) documents.</li><li>Accounts will not be opened for individuals/entities banned by SEBI/Stock Exchanges.</li><li>Risk assessment of clients shall be conducted using various parameters such as geographical location, nature of business, and financial transactions.</li></ul><h3>b) Procedure for Identifying Clients</h3><ul><li>Collect and verify PAN Card, Aadhaar, or other government-issued identity proof.</li><li>Validate KYC details through SEBI-registered KYC Registration Agencies (KRAs).</li><li>Conduct enhanced due diligence for high-risk clients.</li></ul><h3>c) Identifying Beneficial Ownership and Control</h3><ul><li>Identify and verify the ultimate beneficial owner (UBO) of an account.</li><li>Establish ownership/control of an entity in cases where the client is a corporate entity or a trust.</li></ul><h2>5. Transaction Monitoring and Reporting</h2><h3>a) Monitoring Transactions</h3><ul><li>Volume, frequency, and pattern of trades</li><li>Unusual or unjustified complexity</li><li>Lack of economic rationale</li><li>Transactions involving high-risk jurisdictions</li></ul><h3>b) Suspicious Transaction Reporting (STR)</h3><ul><li>Involve proceeds of criminal activities.</li><li>Appear unusually complex or lack an economic purpose.</li><li>Suggest an attempt to avoid regulatory reporting thresholds.</li></ul><h3>c) Cash Transaction Reporting (CTR)</h3><ul><li>Transactions involving cash deposits or withdrawals of ₹10 lakh or more (or equivalent in foreign currency) in a single day will be reported to FIU-IND.</li></ul><h2>6. Record-Keeping</h2><ul><li>All records related to client identification, transaction history, and AML compliance will be maintained for a minimum period of 10 years.</li><li>Records shall be made available to regulatory authorities upon request.</li></ul><h2>7. Employee Training &amp; Awareness</h2><ul><li>Annual AML training sessions will be conducted as applicable.</li><li>Any suspicious activities must be reported to the relevant authorities immediately.</li><li>Awareness sessions will be conducted on the latest AML regulatory developments.</li></ul><h2>8. Internal Audit and Review</h2><ul><li>Optitrade Pro Services will conduct regular internal audits to assess the effectiveness of its AML measures.</li><li>Any observations from the audit will be reviewed and corrective actions will be taken.</li></ul><h2>9. Review of Policy</h2><ul><li>This policy shall be reviewed annually or as required by regulatory changes.</li><li>Updates shall be communicated to all relevant stakeholders.</li></ul><h2>10. Confidentiality and Compliance</h2><ul><li>All reports and client data shall be treated confidentially.</li><li>No disclosure shall be made to clients regarding AML investigations or reports filed.</li><li>Strict disciplinary action will be taken against any violations of AML regulations.</li></ul><h2>11. Cooperation with Law Enforcement Authorities</h2><ul><li>Optitrade Pro Services will fully cooperate with regulatory authorities such as SEBI, FIU-IND, and law enforcement agencies in matters related to AML compliance.</li><li>Any request for information from such agencies shall be responded to promptly.</li></ul><p><strong>This AML Policy serves as a guiding document for ensuring compliance with Anti-Money Laundering regulations and safeguarding Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore) Services against financial crimes.</strong></p>', NULL, 2, 0, '2026-01-11 16:20:48', '2026-01-11 16:37:55'),
(19, 6, '<p><br>All SEBI-registered Research Analysts are required to bring the Investor Charter to the notice of their clients and thus pursuant to the same we are suo motu including the investor charter along with the T&amp;C and MITC. This ensures that the client is not into the regulatory hassle and can take our continued services without any interruption.</p><p>Bharat Stock Market Research hereby discloses the updated Investor Charter to all existing and prospective clients in compliance with the above circulars. The Investor Charter outlines the rights, responsibilities, and grievance redressal mechanisms available to clients and forms an integral part of the client on-boarding and service delivery process.</p><p>This Investor Charter is intended to promote transparency, protect investor interests, and improve awareness of client rights and grievance redressal mechanisms.</p><p>Clients are encouraged to read the Investor Charter carefully as part of their onboarding process and ongoing engagement.</p><p>INVESTOR CHARTER IN RESPECT OF RESEARCH ANALYST (RA)<br>A.<br>Vision and Mission Statements for investors.<br>•<br>Vision<br>Invest with knowledge &amp; safety.<br>•<br>Mission<br>Every investor should be able to invest in right investment products based on their needs, manage and monitor them to meet their goals, access reports and enjoy financial wellness.<br>B.<br>Details of business transacted by the Research Analyst with respect to the investors.<br>•<br>To publish research report based on the research activities of the RA<br>•<br>To provide an independent unbiased view on securities.<br>•<br>To offer unbiased recommendation, disclosing the financial interests in recommended securities.<br>•<br>To provide research recommendation, based on analysis of publicly available information and known observations.<br>•<br>To conduct audit annually<br>•<br>To ensure that all advertisements are in adherence to the provisions of the Advertisement Code for Research Analysts.<br>•<br>To maintain records of interactions, with all clients including prospective clients (prior to onboarding), where any conversation related to the research services has taken place.<br>C.<br>Details of services provided to investors (No Indicative Timelines)<br>•<br>Onboarding of Clients<br>•<br>Sharing of terms and conditions of research service<br>•<br>Completing KYC of fee-paying clients<br>•<br>Disclosure to Clients:<br>•<br>To disclose, information that is material for the client to make an informed decision, including details of its business activity, disciplinary history, the terms and conditions of research services, details of associates, risks and conflicts of interest, if any<br>•<br>To disclose the extent of use of Artificial Intelligence tools in providing research services<br>•<br>To disclose, while distributing a third-party research report, any material conflict of interest of such third-party research provider or provide web address that directs a recipient to the relevant disclosures<br>•<br>To disclose any conflict of interest of the activities of providing research services with other activities of the research analyst.<br>•<br>To distribute research reports and recommendations to the clients without discrimination.<br>•<br>To maintain confidentiality w.r.t publication of the research report until made available in the public domain.<br>•<br>To respect data privacy rights of clients and take measures to protect unauthorized use of their confidential information<br>•<br>To disclose the timelines for the services provided by the research analyst to clients and ensure adherence to the said timelines<br>•<br>To provide clear guidance and adequate caution notice to clients when providing recommendations for dealing in complex and high-risk financial products/services<br>•<br>To treat all clients with honesty and integrity<br>•<br>To ensure confidentiality of information shared by clients unless such information is required to be provided in furtherance of discharging legal obligations or a client has provided specific consent to share such information.<br>D.<br>Details of grievance redressal mechanism and how to access it<br>1.<br>Investor can lodge complaint/grievance against Research Analyst in the following ways:<br>Mode of filing the complaint with research analyst<br>In case of any grievance / complaint, an investor may approach the concerned Research Analyst who shall strive to redress the grievance immediately, but not later than 21 days of the receipt of the grievance.<br>Mode of filing the complaint on SCORES or with Research Analyst Administration and Supervisory Body (RAASB)<br>i.<br>SCORES 2.0 (a web based centralized grievance redressal system of SEBI for facilitating effective grievance redressal in time-bound manner) (https://scores.sebi.gov.in)<br>Two level review for complaint/grievance against Research Analyst:<br>•<br>First review done by designated body (RAASB)<br>•<br>Second review done by SEBI<br>ii.<br>Email to designated email ID of RAASB<br>2.<br>If the Investor is not satisfied with the resolution provided by the Market Participants, then the Investor has the option to file the complaint/ grievance on SMARTODR platform for its resolution through online conciliation or arbitration.<br>With regard to physical complaints, investors may send their complaints to:<br>Office of Investor Assistance and Education,<br>Securities and Exchange Board of India,<br>SEBI Bhavan, Plot No. C4-A, ‘G’ Block,<br>Bandra-Kurla Complex, Bandra (E),<br>Mumbai - 400 051<br>E.<br>Rights of investors<br>•<br>Right to Privacy and Confidentiality.<br>•<br>Right to Transparent Practices.<br>•<br>Right to fair and Equitable Treatment.<br>•<br>Right to Adequate Information.<br>•<br>Right to Initial and Continuing Disclosure -Right to receive information about all the statutory and regulatory disclosures.<br>•<br>Right to Fair &amp; True Advertisement.<br>•<br>Right to Awareness about Service Parameters and Turnaround Times.<br>•<br>Right to be informed of the timelines for each service.<br>•<br>Right to be Heard and Satisfactory Grievance Redressal.<br>•<br>Right to have timely redressal.<br>•<br>Right to Exit from Financial product or service in accordance with the terms and conditions agreed with the research analyst.<br>•<br>Right to receive clear guidance and caution notice when dealing in Complex and High-Risk Financial Products and Services.<br>•<br>Additional Rights to vulnerable consumers - Right to get access to services in a suitable manner even if differently abled.<br>•<br>Right to provide feedback on the financial products and services used.<br>•<br>Right against coercive, unfair, and one-sided clauses in financial agreements<br>F.<br>Expectations from the investors (Responsibilities of investors).<br>•<br>Do’s<br>I.<br>Always deal with SEBI registered Research Analyst.<br>II.<br>Ensure that the Research Analyst has a valid registration certificate.<br>III.<br>Check for SEBI registration number.<br>IV.<br>Please refer to the list of all SEBI registered Research Analyst which is available on SEBI website in the following link: https://www.sebi.gov.in/sebiweb/other/OtherAction.do?doRecognisedFpi=yes&amp;intmId=14) iv. Always pay attention towards disclosures made in the research reports before investing.<br>V.<br>Pay your Research Analyst through banking channels only and maintain duly signed receipts mentioning the details of your payments. You may make payment of fees through Centralized Fee Collection Mechanism (CeFCoM) of RAASB if research analyst has opted for the mechanism. (Applicable for fee paying clients only)<br>VI.<br>Before buying/ selling securities or applying in public offer, check for the research recommendation provided by your Research Analyst.<br>VII.<br>Ask all relevant questions and clear your doubts with your Research<br>Analyst before acting on recommendation.<br>VIII.<br>Seek clarifications and guidance on research recommendations from your Research Analyst, especially if it involves complex and high-risk financial products and services in form SEBI about Research Analyst offering assured or guaranteed returns.<br>IX.<br>Always be aware that you have the right to stop availing the service of a Research Analyst as per the terms of service agreed between you and your Research Analyst.<br>X.<br>Always be aware that you have the right to provide feedback to your Research Analyst in respect of the services received.<br>XI.<br>Always be aware that you will not be bound by any clause, prescribed by the research analyst, which is contravening any regulatory provisions.<br>XII.<br>Inform SEBI about Research Analyst offering assured or guaranteed returns.<br>•<br>Don’ts<br>I.<br>Do not provide funds for investment to the Research Analyst.<br>II.<br>Don’t fall prey to luring advertisements or market rumors.<br>III.<br>Do not get attracted to limited period discount or other incentive, gifts, etc. offered by Research Analyst.<br>IV.<br>Do not share login credentials and password of your trading and demat accounts with the Research Analyst.</p>', NULL, 1, 1, '2026-01-11 16:30:54', '2026-01-11 16:30:54'),
(20, 5, '<h2>Anti-Money Laundering (AML) Policy</h2><p><strong>Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore)</strong></p><h2>1. Introduction</h2><p>Optitrade Pro Services is committed to complying with the provisions of the Prevention of Money Laundering Act, 2002 (PMLA) and the rules notified thereunder. This policy outlines the framework for implementing Anti-Money Laundering (AML) measures, including procedures for client due diligence, monitoring of transactions, and reporting obligations.</p><h2>2. Regulatory Framework</h2><ul><li>Prevention of Money Laundering Act, 2002 (PMLA)</li><li>Securities and Exchange Board of India (SEBI) Guidelines</li><li>Financial Intelligence Unit – India (FIU-IND) Guidelines</li><li>Other relevant laws, rules, and regulations</li></ul><h2>3. Scope of the Policy</h2><p>This policy applies to all clients, partners, and associates of Optitrade Pro Services involved in financial transactions.</p><h2>4. Client Due Diligence (CDD) Process</h2><h3>a) Policy for Acceptance of Clients</h3><ul><li>No account shall be opened in a fictitious or anonymous name.</li><li>Clients must provide valid Know Your Customer (KYC) documents.</li><li>Accounts will not be opened for individuals/entities banned by SEBI/Stock Exchanges.</li><li>Risk assessment of clients shall be conducted using various parameters such as geographical location, nature of business, and financial transactions.</li></ul><h3>b) Procedure for Identifying Clients</h3><ul><li>Collect and verify PAN Card, Aadhaar, or other government-issued identity proof.</li><li>Validate KYC details through SEBI-registered KYC Registration Agencies (KRAs).</li><li>Conduct enhanced due diligence for high-risk clients.</li></ul><h3>c) Identifying Beneficial Ownership and Control</h3><ul><li>Identify and verify the ultimate beneficial owner (UBO) of an account.</li><li>Establish ownership/control of an entity in cases where the client is a corporate entity or a trust.</li></ul><h2>5. Transaction Monitoring and Reporting</h2><h3>a) Monitoring Transactions</h3><ul><li>Volume, frequency, and pattern of trades</li><li>Unusual or unjustified complexity</li><li>Lack of economic rationale</li><li>Transactions involving high-risk jurisdictions</li></ul><h3>b) Suspicious Transaction Reporting (STR)</h3><ul><li>Involve proceeds of criminal activities.</li><li>Appear unusually complex or lack an economic purpose.</li><li>Suggest an attempt to avoid regulatory reporting thresholds.</li></ul><h3>c) Cash Transaction Reporting (CTR)</h3><ul><li>Transactions involving cash deposits or withdrawals of ₹10 lakh or more (or equivalent in foreign currency) in a single day will be reported to FIU-IND.</li></ul><h2>6. Record-Keeping</h2><ul><li>All records related to client identification, transaction history, and AML compliance will be maintained for a minimum period of 10 years.</li><li>Records shall be made available to regulatory authorities upon request.</li></ul><h2>7. Employee Training &amp; Awareness</h2><ul><li>Annual AML training sessions will be conducted as applicable.</li><li>Any suspicious activities must be reported to the relevant authorities immediately.</li><li>Awareness sessions will be conducted on the latest AML regulatory developments.</li></ul><h2>8. Internal Audit and Review</h2><ul><li>Optitrade Pro Services will conduct regular internal audits to assess the effectiveness of its AML measures.</li><li>Any observations from the audit will be reviewed and corrective actions will be taken.</li></ul><h2>9. Review of Policy</h2><ul><li>This policy shall be reviewed annually or as required by regulatory changes.</li><li>Updates shall be communicated to all relevant stakeholders.</li></ul><h2>10. Confidentiality and Compliance</h2><ul><li>All reports and client data shall be treated confidentially.</li><li>No disclosure shall be made to clients regarding AML investigations or reports filed.</li><li>Strict disciplinary action will be taken against any violations of AML regulations.</li></ul><h2>11. Cooperation with Law Enforcement Authorities</h2><ul><li>Optitrade Pro Services will fully cooperate with regulatory authorities such as SEBI, FIU-IND, and law enforcement agencies in matters related to AML compliance.</li><li>Any request for information from such agencies shall be responded to promptly.</li></ul><p><strong>This AML Policy serves as a guiding document for ensuring compliance with Anti-Money Laundering regulations and safeguarding Bharat Stock Market Research SEBI Regisration Number INH00023728 (Proprietor: Namita Rathore) Services against financial crimes.</strong></p>', NULL, 3, 1, '2026-01-11 16:37:55', '2026-01-11 16:37:55'),
(21, 7, '<p>CODE OF CONDUCT FOR RESEARCH ANALYST<br>1.<br>Honesty and Good Faith<br>Research analyst or research entity shall act honestly and in good faith.<br>2.<br>Diligence<br>Research analyst or research entity shall act with due skill, care and diligence and shall ensure that the research report is prepared after thorough analysis.<br>3.<br>Conflict of Interest<br>Research analyst or research entity shall effectively address conflict of interest which may affect the impartiality of its research analysis and research report and shall make appropriate disclosures to address the same.<br>4.<br>Insider Trading or front running<br>Research analyst or research entity or its employees shall not engage in insider trading or front running or front running of its own research report.<br>5.<br>Confidentiality<br>Research analyst or research entity or its employees shall maintain confidentiality of report till the report is made public.<br>6.<br>Professional Standard<br>Research analyst or research entity or its employees engaged in research analysis shall observe high professional standard while preparing research report.<br>7.<br>Compliance<br>Research analyst or research entity shall comply with all regulatory requirements applicable to the conduct of its business activities.<br>8.<br>Responsibility of senior management<br>The senior management of research analyst or research entity shall bear primary responsibility for ensuring the maintenance of appropriate standards of conduct and adherence to proper procedures.</p>', NULL, 1, 0, '2026-01-11 16:39:31', '2026-01-11 16:40:33'),
(22, 7, '<p><br>1.<br>Honesty and Good Faith<br>Research analyst or research entity shall act honestly and in good faith.<br>2.<br>Diligence<br>Research analyst or research entity shall act with due skill, care and diligence and shall ensure that the research report is prepared after thorough analysis.<br>3.<br>Conflict of Interest<br>Research analyst or research entity shall effectively address conflict of interest which may affect the impartiality of its research analysis and research report and shall make appropriate disclosures to address the same.<br>4.<br>Insider Trading or front running<br>Research analyst or research entity or its employees shall not engage in insider trading or front running or front running of its own research report.<br>5.<br>Confidentiality<br>Research analyst or research entity or its employees shall maintain confidentiality of report till the report is made public.<br>6.<br>Professional Standard<br>Research analyst or research entity or its employees engaged in research analysis shall observe high professional standard while preparing research report.<br>7.<br>Compliance<br>Research analyst or research entity shall comply with all regulatory requirements applicable to the conduct of its business activities.<br>8.<br>Responsibility of senior management<br>The senior management of research analyst or research entity shall bear primary responsibility for ensuring the maintenance of appropriate standards of conduct and adherence to proper procedures.</p>', NULL, 2, 1, '2026-01-11 16:40:33', '2026-01-11 16:40:33'),
(23, 2, '<p>&nbsp;</p><p>MANDATORY TERMS &amp; CONDITIONS<br>Disclosure of minimum mandatory terms and conditions to client<br>RAs shall disclose to the client the terms and conditions of the research services offered including rights and obligations. RAs shall ensure that neither any research service is rendered nor any fee is charged until consent is received from the client on the terms and conditions.<br>Below are the minimum mandatory T&amp;Cs required by the Circular. These provisions are integral to Our agreement with You:<br>1.Availing the Services<br>By accepting delivery of the research service, the client confirms that he/she has elected to subscribe the research service of the RA at his/her sole discretion. RA confirms that research services shall be rendered in accordance with the applicable provisions of the RA Regulations.<br>2. Obligations on RA<br>RA and client shall be bound by SEBI Act and all the applicable rules and regulations of SEBI, including the RA Regulations and relevant notifications of Government, as may be in force, from time to time.<br>3. Client Information &amp; KYC<br>The client shall furnish all such details in full as may be required by the RA in its standard form with supporting details, if required, as may be made mandatory by RAASB/SEBI from time to time.<br>RA shall collect, store, upload and check KYC records of the clients with KYC Registration Agency (KRA) as specified by SEBI from time to time.<br>4. Standard Terms of Service<br>The consent of client shall be taken on the following understanding:<br>The client has read and understood the terms and conditions applicable to a research analyst as defined under regulation 2(1)(u) of the SEBI (Research Analyst) Regulations, 2014, including the fee structure.<br>The client is subscribing to the research services for our own benefits and consumption, and any reliance placed on the research report provided by research analyst shall be as per our own judgement and assessment of the conclusions contained in the research report.<br>The client understands that –<br>i.<br>Any investment made based on the recommendations in the research report are subject to market risk.<br>ii.<br>Recommendations in the research report do not provide any assurance of returns.<br>iii.<br>There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report.<br>Declaration of the RA that:<br>i.<br>It is duly registered with SEBI as an RA pursuant to the SEBI (Research Analysts) Regulations, 2014 and its registration details are: (registration number INH000023728, registration date 31.10.2025);<br>ii.<br>It has registration and qualifications required to render the services contemplated under the RA Regulations, and the same are valid and subsisting;<br>iii.<br>Research analyst services provided by it do not conflict with or violate any provision of law, rule or regulation, contract, or other instrument to which it is a party or to which any of its property is or may be subject;<br>iv.<br>The maximum fee that may be charged by RA is ₹1.51 lakhs per annum per family of client.<br>v.<br>The recommendations provided by RA do not provide any assurance of returns.<br>Additionally, if RA is an individual, declaration that:<br>It is not engaged in any additional professional or business activities, on a whole-time basis or in an executive capacity, which interfere with/influence or have the potential to interfere with/influence the independence of research report and/or recommendations contained therein.<br>5. Consideration &amp; Mode of Payment<br>The client shall duly pay to RA, the agreed fees for the services that RA renders to the client and statutory charges, as applicable. Such fees and statutory charges shall be payable through the specified manner and mode(s)/ mechanism(s).<br>6. Risk Factors<br>You acknowledge that investing in securities is subject to market risk, including but not limited to volatility and potential loss of principal, and any past performance is no indicator of future performance, and no returns are guaranteed.<br>7. Conflict of Interest<br>The RA shall adhere to the applicable regulations/ circulars/ directions specified by SEBI from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest.<br>RA shall disclose any conflicts of interest as mandated by SEBI and take steps to mitigate or avoid them. Full disclosures, if required, will be provided in each research report or at the time of giving a recommendation. The Client is advised to visit and thoroughly review all policies, disclosures, and disclaimers available on the official website of the Research Analyst. By signing this Agreement, it shall be deemed that the Client has had the opportunity to read, understand, and accept all such policies and disclaimers as published on the website. The Client confirms and agrees to be bound by the same.<br>8.Termination of Service &amp; Refund of Fees<br>The RA may suspend or terminate rendering of research services to client on account of suspension/ cancellation of registration of RA by SEBI and shall refund the residual amount to the client.<br>We may also suspend/terminate services in the event You breach these T&amp;Cs or as otherwise allowed by law.<br>In case of suspension of certificate of registration of the RA for more than 60 (sixty) days or cancellation of the RA registration, RA shall refund the fees, on a pro rata basis for the period from the effective date of cancellation/ suspension to end of the subscription period.<br>9.<br>Grievance Redressal &amp; Dispute Resolution<br>Any grievance related to<br>(i) non receipt of research report or<br>(ii) missing pages or inability to download the entire report, or<br>(iii) any other deficiency in the research services provided by RA, shall be escalated promptly by the client to the person/employee designated by RA, in this behalf (Namita Rathore Proprietor of Bharat Stock Market Research, namitarathore05071992@gmail.com)<br>The RA shall be responsible to resolve grievances within 7 (seven) business working days or such timelines as may be specified by SEBI under the RA Regulations.<br>RA shall redress grievances of the client in a timely and transparent manner.<br>Any dispute between the RA and his client may be resolved through arbitration or through any other modes or mechanism as specified by SEBI from time to time.<br>If unresolved, the client may escalate the complaint to SEBI via the SCORES portal or undertake online conciliation and/or online arbitration by participating in the ODR Portal and/or undertaking dispute resolution in the manner specified in the SEBI circular no. SEBI/HO/OIAE/OIAE_IAD-3/P/CIR/2023/195 Updated as on December 20, 2023on \"Online Resolution of Disputes in the Indian Securities Market.<br>10. Additional Clauses<br>Any additional voluntary clauses in this agreement shall not conflict with SEBI regulations/circulars. Any changes to such voluntary clauses shall be preceded by 15 days’ notice.<br>11. Mandatory Notice<br>The Client is requested to go through Do’s and Don’ts while dealing with RA as specified in SEBI master circular no. SEBI/HO/MIRSD-POD 1/P/CIR/2024/49 dated May 21, 2024 or as may be specified by SEBI from time to time.<br>12. Most Important Terms &amp; Conditions (MITC)<br>We shall also disclose MITC (as standardized by the Industry Standards Forum, in consultation with SEBI/RAASB).<br>The terms and conditions and the consent thereon are for the research services provided by the RA and RA cannot execute/ carry out any trade (purchase/ sell transaction) on behalf of the client. Thus, you are advised not to permit RA to execute any trade on your behalf.<br>13. Optional Centralised Fee Collection Mechanism: RA Shall provide the guidance to their clients on an optional ‘Centralised Fee Collection Mechanism for IA and RA’ (CeFCoM) available to them for payment of fees to RA.<br>PART C<br>Most Important Terms and Conditions (MITC)<br>1.<br>These terms and conditions, and consent thereon are for the research services provided by the Research Analyst (RA) and RA cannot execute/carry out any trade (purchase/sell transaction) on behalf of, the client. Thus, the clients are advised not to permit RA to execute any trade on their behalf.<br>2.<br>The fee charged by RA to the client will be subject to the maximum of amount prescribed by SEBI/ Research Analyst Administration and Supervisory Body (RAASB) from time to time (applicable only for Individual and HUF Clients).<br>Note:<br>2.1. The current fee limit is Rs 1,51,000/- per annum per family of client for all research services of the RA.<br>2.2. The fee limit does not include statutory charges.<br>2.3. The fee limits do not apply to a non-individual client / accredited investor.<br>3.<br>RA may charge fees in advance if agreed by the client. Such advance shall not exceed the period stipulated by SEBI; presently, it is one year. In case of premature<br>termination of the RA services by either the client or the RA, the client shall be entitled to seek a refund of proportionate fees only for the unexpired period.<br>4.<br>Fees to RA may be paid by the client through any of the specified modes like cheque, online bank transfer, UPI, etc. Cash payment is not allowed. Optionally the client can make payments through Centralized Fee Collection Mechanism (CeFCoM) managed by BSE Limited (i.e. currently recognized RAASB).<br>5.<br>The RA is required to abide by the applicable regulations/ circulars/ directions specified by SEBI and RAASB from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest. The RA will endeavour to promptly inform the client of any conflict of interest that may affect the services being rendered to the client.<br>6.<br>Any assured/guaranteed/fixed returns schemes or any other schemes of similar nature are prohibited by law. No scheme of this nature shall be offered to the client by the RA.<br>7.<br>The RA cannot guarantee returns, profits, accuracy, or risk-free investments from the use of the RA’s research services. All opinions, projections, estimates of the RA are based on the analysis of available data under certain assumptions as of the date of preparation/publication of research report.<br>8.<br>Any investment made based on recommendations in research reports are subject to market risks, and recommendations do not provide any assurance of returns. There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report. Any reliance placed on the research report provided by the RA shall be as per the client’s own judgement and assessment of the conclusions contained in the research report.<br>9.<br>The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>10.<br>For any grievances:<br>Step 1: The client should first contact the RA using the details on its website or the following contact details:<br>Customer Care Number</p><p><br>+91 9457296893<br>Contact Person Name<br>Namita Rathore<br>Address<br>House No 223, Qila Chawni Near Holi Chowk Ward No 47, Rampur Road, Bareilly, Uttar Pradesh, 243001<br>Email-ID<br>namitarathore05071992@gmail.com<br>Working hours when complainant can call<br>9 AM-5 PM (Monday-Friday)<br>Step 2: If the resolution is unsatisfactory, the client can lodge grievances through SEBI’s SCORES platform at www.scores.sebi.gov.in.<br>Step 3: The client may also consider the Online Dispute Resolution (ODR) through the Smart ODR portal at https://smartodr.in.<br>11.<br>Clients are required to keep contact details, including email id and mobile number/s updated with the RA at all times.<br>12.<br>The RA shall never ask for the client’s login credentials and OTPs for the client’s Trading Account Demat Account and Bank Account. Never share such information with anyone including RA. The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>&nbsp;</p>', NULL, 6, 0, '2026-01-11 17:15:31', '2026-01-11 17:24:37');
INSERT INTO `policy_contents` (`id`, `policy_master_id`, `content`, `updates_summary`, `version_number`, `is_active`, `created_at`, `updated_at`) VALUES
(24, 2, '<p>&nbsp;</p><p>MANDATORY TERMS &amp; CONDITIONS<br>Disclosure of minimum mandatory terms and conditions to client<br>RAs shall disclose to the client the terms and conditions of the research services offered including rights and obligations. RAs shall ensure that neither any research service is rendered nor any fee is charged until consent is received from the client on the terms and conditions.<br>Below are the minimum mandatory T&amp;Cs required by the Circular. These provisions are integral to Our agreement with You:<br>1.Availing the Services<br>By accepting delivery of the research service, the client confirms that he/she has elected to subscribe the research service of the RA at his/her sole discretion. RA confirms that research services shall be rendered in accordance with the applicable provisions of the RA Regulations.<br>2. Obligations on RA<br>RA and client shall be bound by SEBI Act and all the applicable rules and regulations of SEBI, including the RA Regulations and relevant notifications of Government, as may be in force, from time to time.<br>3. Client Information &amp; KYC<br>The client shall furnish all such details in full as may be required by the RA in its standard form with supporting details, if required, as may be made mandatory by RAASB/SEBI from time to time.<br>RA shall collect, store, upload and check KYC records of the clients with KYC Registration Agency (KRA) as specified by SEBI from time to time.<br>4. Standard Terms of Service<br>The consent of client shall be taken on the following understanding:<br>The client has read and understood the terms and conditions applicable to a research analyst as defined under regulation 2(1)(u) of the SEBI (Research Analyst) Regulations, 2014, including the fee structure.<br>The client is subscribing to the research services for our own benefits and consumption, and any reliance placed on the research report provided by research analyst shall be as per our own judgement and assessment of the conclusions contained in the research report.<br>The client understands that –<br>i.<br>Any investment made based on the recommendations in the research report are subject to market risk.<br>ii.<br>Recommendations in the research report do not provide any assurance of returns.<br>iii.<br>There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report.<br>Declaration of the RA that:<br>i.<br>It is duly registered with SEBI as an RA pursuant to the SEBI (Research Analysts) Regulations, 2014 and its registration details are: (registration number INH000023728, registration date 31.10.2025);<br>ii.<br>It has registration and qualifications required to render the services contemplated under the RA Regulations, and the same are valid and subsisting;<br>iii.<br>Research analyst services provided by it do not conflict with or violate any provision of law, rule or regulation, contract, or other instrument to which it is a party or to which any of its property is or may be subject;<br>iv.<br>The maximum fee that may be charged by RA is ₹1.51 lakhs per annum per family of client.<br>v.<br>The recommendations provided by RA do not provide any assurance of returns.<br>Additionally, if RA is an individual, declaration that:<br>It is not engaged in any additional professional or business activities, on a whole-time basis or in an executive capacity, which interfere with/influence or have the potential to interfere with/influence the independence of research report and/or recommendations contained therein.<br>5. Consideration &amp; Mode of Payment<br>The client shall duly pay to RA, the agreed fees for the services that RA renders to the client and statutory charges, as applicable. Such fees and statutory charges shall be payable through the specified manner and mode(s)/ mechanism(s).<br>6. Risk Factors<br>You acknowledge that investing in securities is subject to market risk, including but not limited to volatility and potential loss of principal, and any past performance is no indicator of future performance, and no returns are guaranteed.<br>7. Conflict of Interest<br>The RA shall adhere to the applicable regulations/ circulars/ directions specified by SEBI from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest.<br>RA shall disclose any conflicts of interest as mandated by SEBI and take steps to mitigate or avoid them. Full disclosures, if required, will be provided in each research report or at the time of giving a recommendation. The Client is advised to visit and thoroughly review all policies, disclosures, and disclaimers available on the official website of the Research Analyst. By signing this Agreement, it shall be deemed that the Client has had the opportunity to read, understand, and accept all such policies and disclaimers as published on the website. The Client confirms and agrees to be bound by the same.<br>8.Termination of Service &amp; Refund of Fees<br>The RA may suspend or terminate rendering of research services to client on account of suspension/ cancellation of registration of RA by SEBI and shall refund the residual amount to the client.<br>We may also suspend/terminate services in the event You breach these T&amp;Cs or as otherwise allowed by law.<br>In case of suspension of certificate of registration of the RA for more than 60 (sixty) days or cancellation of the RA registration, RA shall refund the fees, on a pro rata basis for the period from the effective date of cancellation/ suspension to end of the subscription period.<br>9.<br>Grievance Redressal &amp; Dispute Resolution<br>Any grievance related to<br>(i) non receipt of research report or<br>(ii) missing pages or inability to download the entire report, or<br>(iii) any other deficiency in the research services provided by RA, shall be escalated promptly by the client to the person/employee designated by RA, in this behalf (Namita Rathore Proprietor of Bharat Stock Market Research, namitarathore05071992@gmail.com)<br>The RA shall be responsible to resolve grievances within 7 (seven) business working days or such timelines as may be specified by SEBI under the RA Regulations.<br>RA shall redress grievances of the client in a timely and transparent manner.<br>Any dispute between the RA and his client may be resolved through arbitration or through any other modes or mechanism as specified by SEBI from time to time.<br>If unresolved, the client may escalate the complaint to SEBI via the SCORES portal or undertake online conciliation and/or online arbitration by participating in the ODR Portal and/or undertaking dispute resolution in the manner specified in the SEBI circular no. SEBI/HO/OIAE/OIAE_IAD-3/P/CIR/2023/195 Updated as on December 20, 2023on \"Online Resolution of Disputes in the Indian Securities Market.<br>10. Additional Clauses<br>Any additional voluntary clauses in this agreement shall not conflict with SEBI regulations/circulars. Any changes to such voluntary clauses shall be preceded by 15 days’ notice.<br>11. Mandatory Notice<br>The Client is requested to go through Do’s and Don’ts while dealing with RA as specified in SEBI master circular no. SEBI/HO/MIRSD-POD 1/P/CIR/2024/49 dated May 21, 2024 or as may be specified by SEBI from time to time.<br>12. Most Important Terms &amp; Conditions (MITC)<br>We shall also disclose MITC (as standardized by the Industry Standards Forum, in consultation with SEBI/RAASB).<br>The terms and conditions and the consent thereon are for the research services provided by the RA and RA cannot execute/ carry out any trade (purchase/ sell transaction) on behalf of the client. Thus, you are advised not to permit RA to execute any trade on your behalf.<br>13. Optional Centralised Fee Collection Mechanism: RA Shall provide the guidance to their clients on an optional ‘Centralised Fee Collection Mechanism for IA and RA’ (CeFCoM) available to them for payment of fees to RA.<br>PART C<br>Most Important Terms and Conditions (MITC)<br>1.<br>These terms and conditions, and consent thereon are for the research services provided by the Research Analyst (RA) and RA cannot execute/carry out any trade (purchase/sell transaction) on behalf of, the client. Thus, the clients are advised not to permit RA to execute any trade on their behalf.<br>2.<br>The fee charged by RA to the client will be subject to the maximum of amount prescribed by SEBI/ Research Analyst Administration and Supervisory Body (RAASB) from time to time (applicable only for Individual and HUF Clients).<br>Note:<br>2.1. The current fee limit is Rs 1,51,000/- per annum per family of client for all research services of the RA.<br>2.2. The fee limit does not include statutory charges.<br>2.3. The fee limits do not apply to a non-individual client / accredited investor.<br>3.<br>RA may charge fees in advance if agreed by the client. Such advance shall not exceed the period stipulated by SEBI; presently, it is one year. In case of premature<br>termination of the RA services by either the client or the RA, the client shall be entitled to seek a refund of proportionate fees only for the unexpired period.<br>4.<br>Fees to RA may be paid by the client through any of the specified modes like cheque, online bank transfer, UPI, etc. Cash payment is not allowed. Optionally the client can make payments through Centralized Fee Collection Mechanism (CeFCoM) managed by BSE Limited (i.e. currently recognized RAASB).<br>5.<br>The RA is required to abide by the applicable regulations/ circulars/ directions specified by SEBI and RAASB from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest. The RA will endeavour to promptly inform the client of any conflict of interest that may affect the services being rendered to the client.<br>6.<br>Any assured/guaranteed/fixed returns schemes or any other schemes of similar nature are prohibited by law. No scheme of this nature shall be offered to the client by the RA.<br>7.<br>The RA cannot guarantee returns, profits, accuracy, or risk-free investments from the use of the RA’s research services. All opinions, projections, estimates of the RA are based on the analysis of available data under certain assumptions as of the date of preparation/publication of research report.<br>8.<br>Any investment made based on recommendations in research reports are subject to market risks, and recommendations do not provide any assurance of returns. There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report. Any reliance placed on the research report provided by the RA shall be as per the client’s own judgement and assessment of the conclusions contained in the research report.<br>9.<br>The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>10.<br>For any grievances:<br>Step 1: The client should first contact the RA using the details on its website or the following contact details:<br>Customer Care Number</p><p><br>+91 9457296893<br>Contact Person Name<br>Namita Rathore<br>Address<br>House No 223, Qila Chawni Near Holi Chowk Ward No 47, Rampur Road, Bareilly, Uttar Pradesh, 243001<br>Email-ID<br>namitarathore05071992@gmail.com<br>Working hours when complainant can call<br>9 AM-5 PM (Monday-Friday)<br>Step 2: If the resolution is unsatisfactory, the client can lodge grievances through SEBI’s SCORES platform at www.scores.sebi.gov.in.<br>Step 3: The client may also consider the Online Dispute Resolution (ODR) through the Smart ODR portal at https://smartodr.in.<br>11.<br>Clients are required to keep contact details, including email id and mobile number/s updated with the RA at all times.<br>12.<br>The RA shall never ask for the client’s login credentials and OTPs for the client’s Trading Account Demat Account and Bank Account. Never share such information with anyone including RA. The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>&nbsp;</p>', NULL, 7, 0, '2026-01-11 17:16:04', '2026-01-11 17:24:37'),
(25, 2, '<p>&nbsp;</p><p><strong>MANDATORY TERMS &amp; CONDITIONS</strong></p><p><br><strong>Disclosure of minimum mandatory terms and conditions to client</strong></p><p><br>RAs shall disclose to the client the terms and conditions of the research services offered including rights and obligations. RAs shall ensure that neither any research service is rendered nor any fee is charged until consent is received from the client on the terms and conditions.<br>Below are the minimum mandatory T&amp;Cs required by the Circular. These provisions are integral to Our agreement with You:<br>1.Availing the Services<br>By accepting delivery of the research service, the client confirms that he/she has elected to subscribe the research service of the RA at his/her sole discretion. RA confirms that research services shall be rendered in accordance with the applicable provisions of the RA Regulations.<br>2. Obligations on RA<br>RA and client shall be bound by SEBI Act and all the applicable rules and regulations of SEBI, including the RA Regulations and relevant notifications of Government, as may be in force, from time to time.<br>3. Client Information &amp; KYC<br>The client shall furnish all such details in full as may be required by the RA in its standard form with supporting details, if required, as may be made mandatory by RAASB/SEBI from time to time.<br>RA shall collect, store, upload and check KYC records of the clients with KYC Registration Agency (KRA) as specified by SEBI from time to time.<br>4. Standard Terms of Service<br>The consent of client shall be taken on the following understanding:<br>The client has read and understood the terms and conditions applicable to a research analyst as defined under regulation 2(1)(u) of the SEBI (Research Analyst) Regulations, 2014, including the fee structure.<br>The client is subscribing to the research services for our own benefits and consumption, and any reliance placed on the research report provided by research analyst shall be as per our own judgement and assessment of the conclusions contained in the research report.<br>The client understands that –<br>i.<br>Any investment made based on the recommendations in the research report are subject to market risk.<br>ii.<br>Recommendations in the research report do not provide any assurance of returns.<br>iii.<br>There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report.<br>Declaration of the RA that:<br>i.<br>It is duly registered with SEBI as an RA pursuant to the SEBI (Research Analysts) Regulations, 2014 and its registration details are: (registration number INH000023728, registration date 31.10.2025);<br>ii.<br>It has registration and qualifications required to render the services contemplated under the RA Regulations, and the same are valid and subsisting;<br>iii.<br>Research analyst services provided by it do not conflict with or violate any provision of law, rule or regulation, contract, or other instrument to which it is a party or to which any of its property is or may be subject;<br>iv.<br>The maximum fee that may be charged by RA is ₹1.51 lakhs per annum per family of client.<br>v.<br>The recommendations provided by RA do not provide any assurance of returns.<br>Additionally, if RA is an individual, declaration that:<br>It is not engaged in any additional professional or business activities, on a whole-time basis or in an executive capacity, which interfere with/influence or have the potential to interfere with/influence the independence of research report and/or recommendations contained therein.<br>5. Consideration &amp; Mode of Payment<br>The client shall duly pay to RA, the agreed fees for the services that RA renders to the client and statutory charges, as applicable. Such fees and statutory charges shall be payable through the specified manner and mode(s)/ mechanism(s).<br>6. Risk Factors<br>You acknowledge that investing in securities is subject to market risk, including but not limited to volatility and potential loss of principal, and any past performance is no indicator of future performance, and no returns are guaranteed.<br>7. Conflict of Interest<br>The RA shall adhere to the applicable regulations/ circulars/ directions specified by SEBI from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest.<br>RA shall disclose any conflicts of interest as mandated by SEBI and take steps to mitigate or avoid them. Full disclosures, if required, will be provided in each research report or at the time of giving a recommendation. The Client is advised to visit and thoroughly review all policies, disclosures, and disclaimers available on the official website of the Research Analyst. By signing this Agreement, it shall be deemed that the Client has had the opportunity to read, understand, and accept all such policies and disclaimers as published on the website. The Client confirms and agrees to be bound by the same.<br>8.Termination of Service &amp; Refund of Fees<br>The RA may suspend or terminate rendering of research services to client on account of suspension/ cancellation of registration of RA by SEBI and shall refund the residual amount to the client.<br>We may also suspend/terminate services in the event You breach these T&amp;Cs or as otherwise allowed by law.<br>In case of suspension of certificate of registration of the RA for more than 60 (sixty) days or cancellation of the RA registration, RA shall refund the fees, on a pro rata basis for the period from the effective date of cancellation/ suspension to end of the subscription period.<br>9.<br>Grievance Redressal &amp; Dispute Resolution<br>Any grievance related to<br>(i) non receipt of research report or<br>(ii) missing pages or inability to download the entire report, or<br>(iii) any other deficiency in the research services provided by RA, shall be escalated promptly by the client to the person/employee designated by RA, in this behalf (Namita Rathore Proprietor of Bharat Stock Market Research, namitarathore05071992@gmail.com)<br>The RA shall be responsible to resolve grievances within 7 (seven) business working days or such timelines as may be specified by SEBI under the RA Regulations.<br>RA shall redress grievances of the client in a timely and transparent manner.<br>Any dispute between the RA and his client may be resolved through arbitration or through any other modes or mechanism as specified by SEBI from time to time.<br>If unresolved, the client may escalate the complaint to SEBI via the SCORES portal or undertake online conciliation and/or online arbitration by participating in the ODR Portal and/or undertaking dispute resolution in the manner specified in the SEBI circular no. SEBI/HO/OIAE/OIAE_IAD-3/P/CIR/2023/195 Updated as on December 20, 2023on \"Online Resolution of Disputes in the Indian Securities Market.<br>10. Additional Clauses<br>Any additional voluntary clauses in this agreement shall not conflict with SEBI regulations/circulars. Any changes to such voluntary clauses shall be preceded by 15 days’ notice.<br>11. Mandatory Notice<br>The Client is requested to go through Do’s and Don’ts while dealing with RA as specified in SEBI master circular no. SEBI/HO/MIRSD-POD 1/P/CIR/2024/49 dated May 21, 2024 or as may be specified by SEBI from time to time.<br>12. Most Important Terms &amp; Conditions (MITC)<br>We shall also disclose MITC (as standardized by the Industry Standards Forum, in consultation with SEBI/RAASB).<br>The terms and conditions and the consent thereon are for the research services provided by the RA and RA cannot execute/ carry out any trade (purchase/ sell transaction) on behalf of the client. Thus, you are advised not to permit RA to execute any trade on your behalf.<br>13. Optional Centralised Fee Collection Mechanism: RA Shall provide the guidance to their clients on an optional ‘Centralised Fee Collection Mechanism for IA and RA’ (CeFCoM) available to them for payment of fees to RA.<br>PART C<br><strong>Most Important Terms and Conditions (MITC)</strong><br>1.<br>These terms and conditions, and consent thereon are for the research services provided by the Research Analyst (RA) and RA cannot execute/carry out any trade (purchase/sell transaction) on behalf of, the client. Thus, the clients are advised not to permit RA to execute any trade on their behalf.<br>2.<br>The fee charged by RA to the client will be subject to the maximum of amount prescribed by SEBI/ Research Analyst Administration and Supervisory Body (RAASB) from time to time (applicable only for Individual and HUF Clients).<br>Note:<br>2.1. The current fee limit is Rs 1,51,000/- per annum per family of client for all research services of the RA.<br>2.2. The fee limit does not include statutory charges.<br>2.3. The fee limits do not apply to a non-individual client / accredited investor.<br>3.<br>RA may charge fees in advance if agreed by the client. Such advance shall not exceed the period stipulated by SEBI; presently, it is one year. In case of premature<br>termination of the RA services by either the client or the RA, the client shall be entitled to seek a refund of proportionate fees only for the unexpired period.<br>4.<br>Fees to RA may be paid by the client through any of the specified modes like cheque, online bank transfer, UPI, etc. Cash payment is not allowed. Optionally the client can make payments through Centralized Fee Collection Mechanism (CeFCoM) managed by BSE Limited (i.e. currently recognized RAASB).<br>5.<br>The RA is required to abide by the applicable regulations/ circulars/ directions specified by SEBI and RAASB from time to time in relation to disclosure and mitigation of any actual or potential conflict of interest. The RA will endeavour to promptly inform the client of any conflict of interest that may affect the services being rendered to the client.<br>6.<br>Any assured/guaranteed/fixed returns schemes or any other schemes of similar nature are prohibited by law. No scheme of this nature shall be offered to the client by the RA.<br>7.<br>The RA cannot guarantee returns, profits, accuracy, or risk-free investments from the use of the RA’s research services. All opinions, projections, estimates of the RA are based on the analysis of available data under certain assumptions as of the date of preparation/publication of research report.<br>8.<br>Any investment made based on recommendations in research reports are subject to market risks, and recommendations do not provide any assurance of returns. There is no recourse to claim any losses incurred on the investments made based on the recommendations in the research report. Any reliance placed on the research report provided by the RA shall be as per the client’s own judgement and assessment of the conclusions contained in the research report.<br>9.<br>The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>10.<br>For any grievances:<br>Step 1: The client should first contact the RA using the details on its website or the following contact details:</p><p><br><strong>Customer Care Number : +91 9457296893</strong></p><p><br><br><strong>Contact Person Name : Namita Rathore</strong><br><br><br><strong>Address : House No 223, Qila Chawni Near Holi Chowk Ward No 47, Rampur Road, Bareilly, Uttar Pradesh, 243001</strong><br><br><strong>Email-ID : </strong><a href=\"mailto:namitarathore05071992@gmail.com\"><strong>namitarathore05071992@gmail.com</strong></a></p><p><br><strong>Working hours when complainant can call : (9 AM-5 PM (Monday-Friday)</strong></p><p><br><br>Step 2: If the resolution is unsatisfactory, the client can lodge grievances through SEBI’s SCORES platform at www.scores.sebi.gov.in.<br>Step 3: The client may also consider the Online Dispute Resolution (ODR) through the Smart ODR portal at https://smartodr.in.<br>11.<br>Clients are required to keep contact details, including email id and mobile number/s updated with the RA at all times.<br>12.<br>The RA shall never ask for the client’s login credentials and OTPs for the client’s Trading Account Demat Account and Bank Account. Never share such information with anyone including RA. The SEBI registration, Enlistment with RAASB, and NISM certification do not guarantee the performance of the RA or assure any returns to the client.<br>&nbsp;</p>', NULL, 8, 1, '2026-01-11 17:24:37', '2026-01-11 17:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `policy_masters`
--

CREATE TABLE `policy_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy_masters`
--

INSERT INTO `policy_masters` (`id`, `name`, `slug`, `title`, `description`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', 'privacy-policy', 'By accessing the platform, you agree to the terms described in this policy. If you do not agree, please discontinue usage.', 'Bharat Stock Market Research (“Company”, “We”, “Us”) owns and operates the platform. This Privacy Policy explains how we collect, use, and protect your information.', 1, '2025-12-29 01:32:46', '2026-01-11 12:15:58'),
(2, 'MITC', 'mitc', 'Terms & Conditions', NULL, 1, '2025-12-29 01:49:43', '2026-01-11 17:16:04'),
(3, 'Grievance Redressal Policy', 'grievance-redressal-policy', 'By accessing the platform, you agree to the terms described in this policy. If you do not agree, please discontinue usage.', 'Bharat Stock Market Research(“Company”, “We”, “Us”) owns and operates the platform. This Privacy Policy explains how we collect, use, and protect your informatio', 1, '2025-12-29 01:55:51', '2026-01-11 13:35:46'),
(4, 'Refund Policy', 'refund-policy', 'Refund rules governed by SEBI regulations', 'Refunds are governed strictly by SEBI (Research Analyst) Regulations and related circulars. Refunds are applicable only for the unexpired portion of the subscription.', 1, '2026-01-07 10:56:49', '2026-01-07 10:56:49'),
(5, 'PMLA Policy', 'pmla-policy', 'PMLA Policy', NULL, 1, '2026-01-11 15:10:50', '2026-01-11 16:37:55'),
(6, 'Investor Charter', 'investor-charter', 'Investor Charter', 'DISCLOSURE OF INVESTOR CHARTER BY RESEARCH ANALYSTS FOR CLIENTS\r\nPURSUANT TO THE SEBI (RESEARCH ANALYST) REGULATIONS, 2014 READ WITH ANNEXURE A OF SEBI CIRCULAR SEBI/HO/MIRSD/MIRSD-PoD/P/CIR/2025/81 DATED JUNE 02, 2025 OR READ WITH CLAUSE 7 AND ANNEXURE D OF SEBI MASTER CIRCULAR FOR RESEARCH ANALYSTS SEBI/HO/MIRSD/MIRSD-PoD/P/CIR/2025/95 DATED JUNE 27, 2025.', 1, '2026-01-11 16:30:54', '2026-01-11 16:30:54'),
(7, 'Code of conduct', 'code-of-conduct', 'CODE OF CONDUCT', 'CODE OF CONDUCT FOR RESEARCH ANALYST', 1, '2026-01-11 16:39:31', '2026-01-11 16:39:31');

-- --------------------------------------------------------

--
-- Table structure for table `popups`
--

CREATE TABLE `popups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('notification','offer','policy','image','custom') DEFAULT NULL,
  `content_type` enum('text','html','image') DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `is_dismissible` tinyint(1) DEFAULT 1,
  `priority` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popups`
--

INSERT INTO `popups` (`id`, `title`, `slug`, `description`, `type`, `content_type`, `content`, `image`, `button_text`, `button_url`, `is_dismissible`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Notification', 'notification', NULL, 'image', NULL, '<h3><strong>&quot;New Notification</strong>&nbsp;Stock&quot;&nbsp;refers to royalty-free<strong>&nbsp;images, videos,&nbsp;</strong>and&nbsp;<strong>vectors&nbsp;</strong>of digital alerts (like&nbsp;<strong>mail, social media, updates</strong>) used in&nbsp;<em>design</em>, as well as setting up alerts for actual stock market movements. For design, you can find assets on sites like&nbsp;<a href=\"https://www.shutterstock.com/search/new-notification\" target=\"_blank\">Shutterstock</a>,&nbsp;<a href=\"https://www.gettyimages.in/photos/notification\" target=\"_blank\">Getty Images</a>, and&nbsp;<a href=\"https://www.pexels.com/search/notification/\" target=\"_blank\">Pexels</a>. For financial news, services like&nbsp;<a href=\"https://www.hl.co.uk/shares/alerts\" target=\"_blank\">Hargreaves Lansdown</a>&nbsp;and&nbsp;<a href=\"https://robinhood.com/support/articles/price-alerts/\" target=\"_blank\">Robinhood</a>&nbsp;<em>offer alerts</em>&nbsp;for stock price changes and news.&nbsp;</h3>', 'popups/pMChcYzjV3OTeApKG7EUl0N5zOcSxfLOHNUaV1DR.jpg', NULL, NULL, 1, 0, 'active', '2026-01-07 12:52:28', '2026-01-12 05:38:05'),
(2, 'Winter Offer', 'winter-offer', 'Update New Offer.', 'offer', NULL, '<p>An &quot;OFFER STOCK&quot; usually refers to an&nbsp;Offer for Sale (OFS), where major shareholders (promoters) of an already listed company sell their existing shares to the public via the stock exchange, rather than the company issuing new shares (like in an IPO). It&#39;s a fast, transparent way for large investors to reduce their stake, meet regulatory minimums (like India&#39;s 25% public shareholding rule), and raise funds, with investors bidding for shares, often at a discount.&nbsp;</p>', 'popups/ss1ULjblxKPa9DxsEwq07iKklNUXSKvGuOtuHkdQ.webp', NULL, NULL, 1, 0, 'inactive', '2026-01-08 11:11:28', '2026-01-12 05:38:05'),
(4, 'ONLY TEXT', 'only-text', 'BHARATSTOCKMARKETRESEARCH', 'notification', NULL, '<p>THIS IS ONLY TEXT MESSAGE &quot;JAI SHRI RAM&quot;</p>', NULL, NULL, NULL, 1, 0, 'inactive', '2026-01-09 16:53:55', '2026-01-09 18:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `review` text NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `name`, `email`, `rating`, `review`, `country`, `state`, `city`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'sharad', 'bhaisaniyasharad@gmail.com', 3, 'testing reviews', 'India', 'Madhya Pradesh', 'Bhopal', 0, '2025-12-15 02:35:43', '2025-12-15 02:35:43'),
(2, 1, 'admin', 'admin@example.com', 5, 'test for with auth', 'India', 'Madhya Pradesh', 'Bhopal', 1, '2025-12-15 02:36:47', '2025-12-15 02:36:47'),
(3, NULL, 'Dolor Morkal', 'bhaisaniyasharad@gmail.com', 4, 'Good enough', 'India', 'Madhya Pradesh', 'Bhopal', 0, '2025-12-15 02:45:58', '2025-12-15 02:45:58'),
(4, NULL, 'Akhil', 'test@example.com', 4, 'The dashboard is easy to use and shows only what matters. A helpful platform for retail traders.', 'India', 'Madhya Pradesh', 'Bhopal', 0, '2025-12-15 02:47:05', '2025-12-15 02:47:05'),
(6, NULL, 'Rahul Sharma', 'rahul@gmail.com', 5, 'Excellent research and support', 'India', 'Delhi', 'Delhi', 0, '2025-12-16 02:11:26', '2025-12-16 02:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'web', '2025-12-05 00:36:27', '2025-12-05 00:36:27'),
(3, 'customer', 'web', '2025-12-05 04:37:01', '2025-12-05 04:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_plans`
--

CREATE TABLE `service_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `button_text` varchar(255) NOT NULL DEFAULT 'Subscribe Now',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_plans`
--

INSERT INTO `service_plans` (`id`, `name`, `tagline`, `featured`, `status`, `sort_order`, `button_text`, `created_at`, `updated_at`) VALUES
(1, 'Premium', 'Monthly Subscription based', 1, 1, 3, 'Join Now', '2025-12-10 00:35:51', '2026-01-11 15:19:15'),
(7, 'Basic Intraday', 'Monthly Subscription based', 1, 1, 1, 'Subscribe Now', '2025-12-15 04:30:15', '2026-01-10 17:46:23'),
(10, 'Medium', 'M', 0, 1, 1, 'Subscribe Now', '2026-01-13 16:43:39', '2026-01-13 16:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `service_plan_durations`
--

CREATE TABLE `service_plan_durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_plan_id` bigint(20) UNSIGNED NOT NULL,
  `duration` varchar(255) NOT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_plan_durations`
--

INSERT INTO `service_plan_durations` (`id`, `service_plan_id`, `duration`, `duration_days`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, '1 Month', 30, 100.00, '2025-12-10 00:35:51', '2026-01-08 16:40:43'),
(2, 1, '3 Months', 90, 300.00, '2025-12-10 00:35:51', '2026-01-10 17:43:19'),
(18, 7, '1 Months', NULL, 100.00, '2026-01-11 15:20:13', '2026-01-11 15:20:13'),
(20, 10, '2 Month', 60, 200.00, '2026-01-13 16:43:39', '2026-01-13 16:43:39'),
(22, 7, '3 Months', NULL, 300.00, '2026-01-14 05:25:47', '2026-01-14 05:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `service_plan_features`
--

CREATE TABLE `service_plan_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_plan_duration_id` bigint(20) UNSIGNED NOT NULL,
  `svg_icon` longtext DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_plan_features`
--

INSERT INTO `service_plan_features` (`id`, `service_plan_duration_id`, `svg_icon`, `text`, `created_at`, `updated_at`) VALUES
(3, 2, '✔', 'test features', '2025-12-10 00:35:51', '2025-12-10 00:35:51'),
(19, 2, '✔', 'test features 2', '2025-12-13 03:31:44', '2025-12-13 03:31:44'),
(32, 1, '✔', 'Intraday Recommendations', '2026-01-03 12:31:55', '2026-01-03 12:31:55'),
(33, 1, '✔', 'Short-Term/Medium-Term', '2026-01-03 12:31:55', '2026-01-03 12:31:55'),
(34, 1, '✔', 'Options & Futures', '2026-01-03 12:31:55', '2026-01-03 12:31:55'),
(35, 1, '✔', 'Commodity Tips', '2026-01-03 12:31:55', '2026-01-03 12:32:18'),
(36, 1, '✔', 'Customer Support Priority', '2026-01-03 12:31:55', '2026-01-03 12:32:18'),
(46, 18, '✔', 'Equity cash Calls', '2026-01-11 15:20:13', '2026-01-11 15:20:13'),
(47, 18, '✔', 'Equity Intraday Short and Long Term Calls', '2026-01-11 15:20:13', '2026-01-11 15:20:13'),
(49, 20, '✔', 'future and Options', '2026-01-13 16:43:39', '2026-01-13 16:43:39'),
(50, 20, '✔', 'Equity cash', '2026-01-13 16:43:39', '2026-01-13 16:43:39'),
(54, 22, '✔', 'Equity cash Calls', '2026-01-14 05:25:47', '2026-01-14 05:25:47'),
(55, 22, '✔', 'Equity Intraday Short and Long Term Calls', '2026-01-14 05:25:47', '2026-01-14 05:25:47'),
(56, 22, 'Premium', 'Crude oil Calls', '2026-01-14 05:25:47', '2026-01-14 05:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1OTjjUTMxUyFYlz7tJSisBai9ydVVZgZ8thlyRzl', NULL, '198.244.226.212', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGxCZVl5N1hRVThGcWU1eVlOcFo1UFVnSjZmbDdCV0p6eUNtVXBBcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768409682),
('2zuRVsDaHoImlQJjCBhKmzOr6EcJXLr3gNqhcXgW', NULL, '192.71.23.211', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Agency/93.8.2357.5', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSU5RNzI0NWVxRnVkOGU3NjF2aWN4dndyQTV1RVRTcXFCbTVVSnZjMyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cHM6Ly9iaGFyYXRzdG9ja21hcmtldHJlc2VhcmNoLmNvbS9zdXBwb3J0L2NoYXQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo1MDoiaHR0cHM6Ly9iaGFyYXRzdG9ja21hcmtldHJlc2VhcmNoLmNvbS9zdXBwb3J0L2NoYXQiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768389849),
('4C4BmICEHpV9lgTKDGvmQc5r4Jb1vWHSgHcSUBbl', 1, '2401:4900:8822:3abd:cd4c:af64:769:98b3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoieGhYc0c4Y1d1MmF5OVJWcTludUdqZFRrdTlKUHFBdEpla1VTd3RiTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODI6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20vYXBpL2FuZ2VsL3F1b3RlP2V4Y2hhbmdlPU5TRSZzeW1ib2w9OTk5MjYwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkZ3oyd2VDYmJUUlh2SEU1dDRKYlJxLjhSZXBLM2x5aGtaSkdYZllXcWdDZGRkT3RYOHpEVHEiO30=', 1768393094),
('4laaUtuKopC6FEbd5UKOwO9AlcyPkFBsY36Ijj7N', NULL, '66.249.74.32', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.7499.192 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieW5IcXBsU3g3clU0NVFVUTFKTTBtaUh6T2V1aWxEVWEwVWRsUGE3NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768388188),
('8Iqcf61O68Cdpt4Qc6poOjB2whJWI9J3vYFoHoTa', NULL, '2405:201:6822:780a:45e3:5822:13fd:60f', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFd2cmowNENKbmxtSjJOTHpDc0VuNVNkbFIxdzNTZW5ocUtvSG9hSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768407565),
('dhgUEzYnuBzAROqSJRaFfMpPzm7C6NGB8m4wgvoK', NULL, '66.249.74.32', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHRzQ1poM1A2djl1ZHY4V1R1djlDbUNkTFozbjlkdkZGalVOMGRycCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768388169),
('esONhNXSB4Qq2XrPsfgbe0q7ha4cN80D1AReLvQ1', NULL, '66.249.74.34', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTNGY20xN2xlS2hZaFdpSzRVc2pFaU84cU8wOFo2WDZDR1BhVk5XSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768388172),
('Hn5ZTCSGzuu9dBpkcJgV3GG7fsUI3M2QU7JhwJQ6', NULL, '2a06:98c0:3600::103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0pWdzl0TXNnNmtZb005Z1ZzZW9kOVdPVVU0NGJ4S3B5YkFaNmZoYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768392651),
('HtmwAzSzwZ9NRPI9rJ7WRI8RJDq6SakbLJ6nrhQR', NULL, '2401:4900:8822:3abd:bda2:5660:7492:aa98', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVBVenlOSkNWYll6UU1DRDFIZlI0djF2UG16RERobXhKMmdkTjJpQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768394342),
('Mu338qXiyJHI9KwGav40w44w3I8fSOcdEFh3OanY', NULL, '192.71.224.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Agency/93.8.2357.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTlYQ2U1aDlPaW9ab2RzZjdSYWZPN3djc0loNnFwUjNwamFFNTRCUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20vZm9yZ290LXBhc3N3b3JkIjtzOjU6InJvdXRlIjtzOjE2OiJwYXNzd29yZC5yZXF1ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768389860),
('rwActiPYc7xSZDeIuW2u2RiwsN1UWspp1TeMohUa', NULL, '192.71.10.105', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Agency/93.8.2357.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkZLSWlwRVhIamNudEZ0b25hYnpQQzNLVklKZkR6OHkwd2p2NUwxYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768389860),
('TbPFyilBYT4wuZKu3A4NZBJ1HQALIP38yRzi5vLE', NULL, '192.71.142.35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Agency/93.8.2357.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0hyQW5NRmdDUVNNbDVGaW1jMW04TUREeEpsYU9rR3JHamU5NkVhVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768389849),
('uLpu7O3hoKupNDjbXDldxd7w9PNRxEsY7qTdcyiH', NULL, '192.36.248.249', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Agency/93.8.2357.5', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUWpHYjdQd2xxaXNvZDBHekFRQ2NvQXZGOUNpMmJVR2VnUUxOeEVmeSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cHM6Ly9iaGFyYXRzdG9ja21hcmtldHJlc2VhcmNoLmNvbS9zZXR0aW5ncyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwczovL2JoYXJhdHN0b2NrbWFya2V0cmVzZWFyY2guY29tL3NldHRpbmdzIjtzOjU6InJvdXRlIjtzOjIxOiJ1c2VyLnNldHRpbmdzLnByb2ZpbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768389859),
('WN5nQkHF6HXU5PFdExvBOyYVSq8pejBvXBX3oLvo', NULL, '49.43.168.32', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_2_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.151 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTlmSXBNTlhFWTBOZzhpOVhkc0xXNGhEcVNUeW0xV3ZXTFVDQzNMZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768401565),
('ZuMoj9JRZhdDokQRs8oBTVDjcMcpTpN5yaRZtwJK', NULL, '66.249.74.33', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.7499.192 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmo3dEVWcGdRaEQyVWFTRHJuNVN6c0hzRHRYQnR1cXdNRHM5c0xIWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmhhcmF0c3RvY2ttYXJrZXRyZXNlYXJjaC5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768388139);

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

CREATE TABLE `tips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tip_type` enum('equity','future','option') NOT NULL DEFAULT 'equity',
  `stock_name` varchar(255) NOT NULL,
  `symbol_token` varchar(255) DEFAULT NULL,
  `exchange` varchar(10) NOT NULL,
  `call_type` varchar(10) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `entry_price` decimal(10,2) NOT NULL,
  `target_price` decimal(10,2) NOT NULL,
  `target_price_2` decimal(15,2) DEFAULT NULL,
  `stop_loss` decimal(10,2) NOT NULL,
  `cmp_price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `strike_price` varchar(255) DEFAULT NULL,
  `option_type` enum('CE','PE') DEFAULT NULL,
  `status` enum('active','archived','cancel') NOT NULL DEFAULT 'active',
  `version` int(11) NOT NULL DEFAULT 1,
  `admin_note` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tips`
--

INSERT INTO `tips` (`id`, `parent_id`, `tip_type`, `stock_name`, `symbol_token`, `exchange`, `call_type`, `category_id`, `entry_price`, `target_price`, `target_price_2`, `stop_loss`, `cmp_price`, `expiry_date`, `strike_price`, `option_type`, `status`, `version`, `admin_note`, `created_by`, `created_at`, `updated_at`) VALUES
(13, NULL, 'equity', 'VEDL-EQ', '3063', 'NSE', 'Buy', 1, 672.50, 685.95, 699.40, 662.41, 669.80, NULL, NULL, NULL, 'active', 1, 'New Equity Tip Generated', 1, '2026-01-14 06:11:13', '2026-01-14 06:58:10'),
(14, NULL, 'equity', 'TATAINVEST-EQ', '1621', 'NSE', 'Buy', 1, 668.10, 681.46, 694.82, 658.08, 667.05, NULL, NULL, NULL, 'active', 1, 'New Equity Tip Generated', 1, '2026-01-14 06:21:03', '2026-01-14 06:57:58'),
(15, NULL, 'option', 'ITC-EQ', '1660', 'NSE', 'Buy', 5, 335.80, 344.19, 352.59, 329.08, 335.65, '2026-01-30', '340', 'CE', 'active', 1, 'New Option Tip Generated', 1, '2026-01-14 06:41:14', '2026-01-14 06:58:10'),
(17, NULL, 'option', 'NIFTY 50', '99926000', 'NSE', 'Buy', 5, 25761.75, 26405.79, 27049.84, 25246.51, 25754.50, '2026-01-20', '25750', 'CE', 'active', 1, 'New Option Tip Generated', 1, '2026-01-14 06:49:06', '2026-01-14 06:58:10'),
(18, NULL, 'equity', 'RELIANCE-EQ', '2885', 'NSE', 'Buy', 1, 1462.80, 1492.06, 1521.31, 1440.86, 1462.50, NULL, NULL, NULL, 'active', 1, 'New Equity Tip Generated', 1, '2026-01-14 06:52:55', '2026-01-14 06:58:10'),
(23, NULL, 'equity', 'TCS-EQ', '11536', 'NSE', 'Buy', 1, 3192.50, 3256.35, 3320.20, 3144.61, 3192.50, NULL, NULL, NULL, 'active', 1, 'New Equity Tip Generated', 1, '2026-01-14 11:17:48', '2026-01-14 11:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `tip_categories`
--

CREATE TABLE `tip_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tip_categories`
--

INSERT INTO `tip_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Swing', 1, '2026-01-06 08:04:38', '2026-01-06 08:04:38'),
(2, 'Niffty', 1, '2026-01-06 08:04:50', '2026-01-06 08:04:50'),
(3, 'Crude Oil', 1, '2026-01-06 17:14:24', '2026-01-06 17:14:24'),
(4, 'Intraday Tips', 1, '2026-01-11 11:37:42', '2026-01-11 11:37:42'),
(5, 'Intraday', 1, '2026-01-11 11:38:05', '2026-01-11 11:38:05'),
(6, 'Short Term', 1, '2026-01-11 11:38:21', '2026-01-11 11:38:21'),
(7, 'Long Term', 1, '2026-01-11 11:38:34', '2026-01-11 11:38:34'),
(8, 'Nifty', 1, '2026-01-11 11:38:55', '2026-01-11 11:38:55'),
(9, 'Banknifty', 1, '2026-01-11 11:39:03', '2026-01-11 11:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `tip_plan_access`
--

CREATE TABLE `tip_plan_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tip_id` bigint(20) UNSIGNED NOT NULL,
  `service_plan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tip_plan_access`
--

INSERT INTO `tip_plan_access` (`id`, `tip_id`, `service_plan_id`, `created_at`, `updated_at`) VALUES
(20, 13, 1, '2026-01-14 06:11:13', '2026-01-14 06:11:13'),
(21, 13, 7, '2026-01-14 06:11:13', '2026-01-14 06:11:13'),
(22, 13, 10, '2026-01-14 06:11:13', '2026-01-14 06:11:13'),
(23, 14, 1, '2026-01-14 06:21:03', '2026-01-14 06:21:03'),
(24, 14, 7, '2026-01-14 06:21:03', '2026-01-14 06:21:03'),
(25, 14, 10, '2026-01-14 06:21:03', '2026-01-14 06:21:03'),
(26, 15, 1, '2026-01-14 06:41:14', '2026-01-14 06:41:14'),
(27, 15, 7, '2026-01-14 06:41:14', '2026-01-14 06:41:14'),
(28, 15, 10, '2026-01-14 06:41:14', '2026-01-14 06:41:14'),
(32, 17, 1, '2026-01-14 06:49:06', '2026-01-14 06:49:06'),
(33, 17, 7, '2026-01-14 06:49:06', '2026-01-14 06:49:06'),
(34, 17, 10, '2026-01-14 06:49:06', '2026-01-14 06:49:06'),
(35, 18, 1, '2026-01-14 06:52:55', '2026-01-14 06:52:55'),
(36, 18, 7, '2026-01-14 06:52:55', '2026-01-14 06:52:55'),
(37, 18, 10, '2026-01-14 06:52:55', '2026-01-14 06:52:55'),
(50, 23, 10, '2026-01-14 11:17:48', '2026-01-14 11:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `tip_updates`
--

CREATE TABLE `tip_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tip_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status_snapshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `language_preference` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed','other') DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `adhar_card` varchar(255) DEFAULT NULL,
  `adhar_card_name` varchar(255) DEFAULT NULL,
  `pan_card` varchar(255) DEFAULT NULL,
  `pan_card_name` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `business_document` varchar(255) DEFAULT NULL,
  `education_institute` varchar(255) DEFAULT NULL,
  `education_degree` varchar(255) DEFAULT NULL,
  `education_document` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `hobbies` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `remember_token`, `created_at`, `updated_at`, `address`, `city`, `state`, `pincode`, `country`, `role_id`, `image`, `bio`, `language_preference`, `dob`, `gender`, `marital_status`, `blood_group`, `adhar_card`, `adhar_card_name`, `pan_card`, `pan_card_name`, `business_name`, `business_type`, `business_document`, `education_institute`, `education_degree`, `education_document`, `website`, `linkedin`, `twitter`, `facebook`, `social_links`, `hobbies`, `skills`, `emergency_contact_name`, `emergency_contact_phone`) VALUES
(1, 'admin', 'admin@example.com', NULL, '$2y$12$gz2weCbbTRXvHE5t4JbRq.8RepK3lyhkZJGXfYWqgCdddOtX8zDTq', '9752008368', 'GmsDSPU4aAAPXtgAQf4URSGflxjF5V7qTmR2Fs685eYwRCLdzbi5b3r5SFCp', '2025-12-05 00:29:30', '2025-12-16 05:27:01', NULL, 'Indore', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2000-02-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'User John', 'john@example.com', NULL, '$2y$12$gz2weCbbTRXvHE5t4JbRq.8RepK3lyhkZJGXfYWqgCdddOtX8zDTq', '1234567890', NULL, '2025-12-05 01:28:27', '2025-12-30 06:29:12', NULL, 'New York', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'User_8366', NULL, NULL, '$2y$12$yBh0LLr4J9rgXqU00QGhFeb049PVxjyhttq0VUYkvMedGIhqoSZgu', '9752008366', NULL, '2025-12-05 02:40:34', '2025-12-05 02:40:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'sharad', 'vicky21ind@gmail.com', NULL, '$2y$12$pG7RUt8QO/l7RGj.MQktT.U7ePO3dfCcqlQIAYrjH2MXWJ7uttATW', '8817440858', NULL, '2025-12-05 04:39:45', '2025-12-05 04:40:28', NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, '2025-12-02', 'male', 'single', 'O+', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Sharad Bhaisaniya', 'infometawish.ai@gmail.com', NULL, '$2y$12$zitry/tt91IPptPFsDmfi.zSgzkopLpRMeciYHc/mNjvDF4Hp8H2O', '8109010648', NULL, '2025-12-05 04:46:27', '2026-01-10 12:40:07', NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Md Raza', 'raza@gmail.com', NULL, '$2y$12$f.F7q/zfZSC2HxNGn9C1NeAolnyfYB6QOA5savJ51cJ69g3ZWrihC', '6268632584', NULL, '2025-12-06 01:43:29', '2025-12-06 01:43:46', NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Rahul', 'rahul@gmail.com', NULL, '$2y$12$3Zf3pxx1Qfpmz.3Mw7/ZlOQ94/w833q1MiHTQWjGq7np1HWbUSKqG', '9174358790', NULL, '2025-12-12 02:00:02', '2025-12-12 02:00:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2003-02-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'manager', 'abc@example.com', NULL, '$2y$12$vuFOr09n/3vja1eNypUEm.ES9S9wKEtvLlrCLkJ5YdZ4f3HhWvCeK', '9752008369', NULL, '2025-12-12 06:49:10', '2025-12-12 06:49:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'nnnn', 'nn@gmail.com', NULL, '$2y$12$tVcnJniE4UcBp6jkAY7AQeSO/ZGf6rh.iImGW1AdGFqj7AjNNIsxa', '9752745428', NULL, '2025-12-15 23:03:44', '2025-12-25 03:55:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Test User', 'test@gmail.com', NULL, '$2y$12$k01gMtFV4DNDGWmDOlGWa.mHVhbjqI29hQOQHDyLyM5uqvfdJ8H3W', '9286970120', NULL, '2025-12-16 04:37:36', '2025-12-30 06:35:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'faize', 'faize@gmail.com', NULL, '$2y$12$frzX5Brp7TZSw5bbeVAKHeEhIwRJffrzjYDHW78JfI0DrlQfTYY4q', '9589664572', NULL, '2026-01-03 09:13:47', '2026-01-03 09:13:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2002-01-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'saket kuamr', 'saketkumar@gmail.com', NULL, '$2y$12$LlIPADZgHHru8by6gWQ8fuxo6ftG1HrtaOvo32I31mIGsoxB6cIB2', '8989898985', NULL, '2026-01-09 15:42:00', '2026-01-09 16:02:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-02-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_plan_id` bigint(20) UNSIGNED NOT NULL,
  `service_plan_duration_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `is_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`id`, `user_id`, `service_plan_id`, `service_plan_duration_id`, `start_date`, `end_date`, `status`, `is_auto_renew`, `payment_reference`, `created_at`, `updated_at`) VALUES
(1, 17, 1, 1, '2026-01-10', '2026-02-09', 'active', 0, 'ADMIN_MANUAL_17', '2026-01-10 12:37:25', '2026-01-10 12:37:25'),
(2, 20, 1, 1, '2026-01-10', '2026-01-10', 'cancelled', 0, 'ADMIN_MANUAL_20', '2026-01-10 12:38:01', '2026-01-10 12:50:06'),
(3, 20, 1, 1, '2026-01-10', '2026-04-10', 'active', 0, 'DUMMY_69624afe4edae', '2026-01-10 12:50:06', '2026-01-10 12:50:06'),
(4, 1, 1, 1, '2026-01-13', '2026-01-13', 'cancelled', 0, 'DUMMY_69661ab8e1d78', '2026-01-13 10:13:12', '2026-01-13 10:13:45'),
(6, 1, 1, 1, '2026-01-13', '2026-01-13', 'cancelled', 0, 'DUMMY_69661b4822f7d', '2026-01-13 10:15:36', '2026-01-13 11:16:20'),
(7, 1, 1, 1, '2026-01-13', '2026-01-13', 'cancelled', 0, 'DUMMY_696629843191f', '2026-01-13 11:16:20', '2026-01-13 17:25:28'),
(8, 1, 10, 20, '2026-01-13', '2026-01-14', 'cancelled', 0, 'DUMMY_69668008a7cbd', '2026-01-13 17:25:28', '2026-01-14 05:40:35'),
(9, 1, 1, 2, '2026-01-14', '2026-01-14', 'cancelled', 0, 'DUMMY_69672c533df0d', '2026-01-14 05:40:35', '2026-01-14 11:27:16'),
(10, 1, 1, 2, '2026-01-14', '2026-01-14', 'cancelled', 0, 'DUMMY_69677d94d3027', '2026-01-14 11:27:16', '2026-01-14 11:27:29'),
(11, 1, 10, 20, '2026-01-14', '2026-03-15', 'active', 0, 'DUMMY_69677da1aefa9', '2026-01-14 11:27:29', '2026-01-14 11:27:29');

-- --------------------------------------------------------

--
-- Table structure for table `why_choose_sections`
--

CREATE TABLE `why_choose_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `why_choose_sections`
--

INSERT INTO `why_choose_sections` (`id`, `title`, `badge`, `heading`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Why Choose Us', 'Why Choose Us', 'Trusted by Investors,', 'SEBI compliant, data driven research,', 0, 1, '2025-12-13 07:16:08', '2026-01-09 06:00:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_core_values`
--
ALTER TABLE `about_core_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_core_values_section_id_foreign` (`section_id`);

--
-- Indexes for table `about_core_value_sections`
--
ALTER TABLE `about_core_value_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_mission_values`
--
ALTER TABLE `about_mission_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_why_platform_contents`
--
ALTER TABLE `about_why_platform_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_why_platform_contents_section_id_foreign` (`section_id`);

--
-- Indexes for table `about_why_platform_sections`
--
ALTER TABLE `about_why_platform_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_category_id_foreign` (`category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `download_app_section`
--
ALTER TABLE `download_app_section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `download_app_section_page_key_unique` (`page_key`),
  ADD KEY `download_app_section_page_key_index` (`page_key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_page_type_page_slug_index` (`page_type`,`page_slug`);

--
-- Indexes for table `footer_brand_settings`
--
ALTER TABLE `footer_brand_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_columns`
--
ALTER TABLE `footer_columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_links_footer_column_id_foreign` (`footer_column_id`);

--
-- Indexes for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_social_links`
--
ALTER TABLE `footer_social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_menus`
--
ALTER TABLE `header_menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `header_menus_slug_unique` (`slug`),
  ADD UNIQUE KEY `header_menus_order_no_unique` (`order_no`);

--
-- Indexes for table `header_settings`
--
ALTER TABLE `header_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_banners`
--
ALTER TABLE `hero_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_counters`
--
ALTER TABLE `home_counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_key_feature_items`
--
ALTER TABLE `home_key_feature_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_key_feature_items_section_id_foreign` (`section_id`);

--
-- Indexes for table `home_key_feature_sections`
--
ALTER TABLE `home_key_feature_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works_sections`
--
ALTER TABLE `how_it_works_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works_steps`
--
ALTER TABLE `how_it_works_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `how_it_works_steps_section_id_foreign` (`section_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_user_id_foreign` (`user_id`);

--
-- Indexes for table `investor_charter_pages`
--
ALTER TABLE `investor_charter_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investor_charter_pages_policy_id_page_slug_unique` (`policy_id`,`page_slug`);

--
-- Indexes for table `investor_charter_policies`
--
ALTER TABLE `investor_charter_policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investor_charter_policies_title_version_unique` (`title`,`version`);

--
-- Indexes for table `investor_charter_policy_logs`
--
ALTER TABLE `investor_charter_policy_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investor_charter_policy_logs_policy_id_foreign` (`policy_id`),
  ADD KEY `investor_charter_policy_logs_performed_by_foreign` (`performed_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marquees`
--
ALTER TABLE `marquees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `message_campaigns`
--
ALTER TABLE `message_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_campaign_logs`
--
ALTER TABLE `message_campaign_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_campaign_logs_message_campaign_id_user_id_unique` (`message_campaign_id`,`user_id`),
  ADD KEY `message_campaign_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_categories_name_unique` (`name`),
  ADD UNIQUE KEY `news_categories_slug_unique` (`slug`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_users`
--
ALTER TABLE `notification_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_users_user_id_read_at_index` (`user_id`,`read_at`),
  ADD KEY `notification_users_notification_id_index` (`notification_id`);

--
-- Indexes for table `offer_banners`
--
ALTER TABLE `offer_banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offer_banners_slug_unique` (`slug`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`);

--
-- Indexes for table `package_categories`
--
ALTER TABLE `package_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_categories_slug_unique` (`slug`);

--
-- Indexes for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `policy_contents`
--
ALTER TABLE `policy_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_contents_policy_master_id_foreign` (`policy_master_id`);

--
-- Indexes for table `policy_masters`
--
ALTER TABLE `policy_masters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `policy_masters_slug_unique` (`slug`);

--
-- Indexes for table `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `popups_slug_unique` (`slug`),
  ADD KEY `popups_status_index` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

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
-- Indexes for table `service_plans`
--
ALTER TABLE `service_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_plan_durations`
--
ALTER TABLE `service_plan_durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_plan_durations_service_plan_id_foreign` (`service_plan_id`);

--
-- Indexes for table `service_plan_features`
--
ALTER TABLE `service_plan_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_plan_features_service_plan_duration_id_foreign` (`service_plan_duration_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tips`
--
ALTER TABLE `tips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tips_category_id_foreign` (`category_id`),
  ADD KEY `tips_created_by_foreign` (`created_by`),
  ADD KEY `tips_parent_id_status_version_stock_name_index` (`parent_id`,`status`,`version`,`stock_name`);

--
-- Indexes for table `tip_categories`
--
ALTER TABLE `tip_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tip_plan_access`
--
ALTER TABLE `tip_plan_access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tip_plan_unique` (`tip_id`,`service_plan_id`),
  ADD KEY `tip_plan_access_service_plan_id_foreign` (`service_plan_id`);

--
-- Indexes for table `tip_updates`
--
ALTER TABLE `tip_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tip_updates_tip_id_foreign` (`tip_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_subscriptions_service_plan_id_foreign` (`service_plan_id`),
  ADD KEY `user_subscriptions_service_plan_duration_id_foreign` (`service_plan_duration_id`),
  ADD KEY `user_subscriptions_user_id_status_index` (`user_id`,`status`);

--
-- Indexes for table `why_choose_sections`
--
ALTER TABLE `why_choose_sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_core_values`
--
ALTER TABLE `about_core_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `about_core_value_sections`
--
ALTER TABLE `about_core_value_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_mission_values`
--
ALTER TABLE `about_mission_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `about_why_platform_contents`
--
ALTER TABLE `about_why_platform_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `about_why_platform_sections`
--
ALTER TABLE `about_why_platform_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `download_app_section`
--
ALTER TABLE `download_app_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `footer_brand_settings`
--
ALTER TABLE `footer_brand_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footer_columns`
--
ALTER TABLE `footer_columns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `footer_settings`
--
ALTER TABLE `footer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footer_social_links`
--
ALTER TABLE `footer_social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `header_menus`
--
ALTER TABLE `header_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `header_settings`
--
ALTER TABLE `header_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hero_banners`
--
ALTER TABLE `hero_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `home_counters`
--
ALTER TABLE `home_counters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `home_key_feature_items`
--
ALTER TABLE `home_key_feature_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `home_key_feature_sections`
--
ALTER TABLE `home_key_feature_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `how_it_works_sections`
--
ALTER TABLE `how_it_works_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `how_it_works_steps`
--
ALTER TABLE `how_it_works_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `investor_charter_pages`
--
ALTER TABLE `investor_charter_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `investor_charter_policies`
--
ALTER TABLE `investor_charter_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `investor_charter_policy_logs`
--
ALTER TABLE `investor_charter_policy_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `marquees`
--
ALTER TABLE `marquees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `message_campaigns`
--
ALTER TABLE `message_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `message_campaign_logs`
--
ALTER TABLE `message_campaign_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification_users`
--
ALTER TABLE `notification_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `offer_banners`
--
ALTER TABLE `offer_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `package_categories`
--
ALTER TABLE `package_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_sections`
--
ALTER TABLE `page_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `policy_contents`
--
ALTER TABLE `policy_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `policy_masters`
--
ALTER TABLE `policy_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_plans`
--
ALTER TABLE `service_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `service_plan_durations`
--
ALTER TABLE `service_plan_durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `service_plan_features`
--
ALTER TABLE `service_plan_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tips`
--
ALTER TABLE `tips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tip_categories`
--
ALTER TABLE `tip_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tip_plan_access`
--
ALTER TABLE `tip_plan_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tip_updates`
--
ALTER TABLE `tip_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `why_choose_sections`
--
ALTER TABLE `why_choose_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_core_values`
--
ALTER TABLE `about_core_values`
  ADD CONSTRAINT `about_core_values_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `about_core_value_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `about_why_platform_contents`
--
ALTER TABLE `about_why_platform_contents`
  ADD CONSTRAINT `about_why_platform_contents_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `about_why_platform_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD CONSTRAINT `footer_links_footer_column_id_foreign` FOREIGN KEY (`footer_column_id`) REFERENCES `footer_columns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `home_key_feature_items`
--
ALTER TABLE `home_key_feature_items`
  ADD CONSTRAINT `home_key_feature_items_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `home_key_feature_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `how_it_works_steps`
--
ALTER TABLE `how_it_works_steps`
  ADD CONSTRAINT `how_it_works_steps_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `how_it_works_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `investor_charter_pages`
--
ALTER TABLE `investor_charter_pages`
  ADD CONSTRAINT `investor_charter_pages_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `investor_charter_policies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investor_charter_policy_logs`
--
ALTER TABLE `investor_charter_policy_logs`
  ADD CONSTRAINT `investor_charter_policy_logs_performed_by_foreign` FOREIGN KEY (`performed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `investor_charter_policy_logs_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `investor_charter_policies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_campaign_logs`
--
ALTER TABLE `message_campaign_logs`
  ADD CONSTRAINT `message_campaign_logs_message_campaign_id_foreign` FOREIGN KEY (`message_campaign_id`) REFERENCES `message_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_campaign_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `notification_users`
--
ALTER TABLE `notification_users`
  ADD CONSTRAINT `notification_users_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `policy_contents`
--
ALTER TABLE `policy_contents`
  ADD CONSTRAINT `policy_contents_policy_master_id_foreign` FOREIGN KEY (`policy_master_id`) REFERENCES `policy_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_plan_durations`
--
ALTER TABLE `service_plan_durations`
  ADD CONSTRAINT `service_plan_durations_service_plan_id_foreign` FOREIGN KEY (`service_plan_id`) REFERENCES `service_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_plan_features`
--
ALTER TABLE `service_plan_features`
  ADD CONSTRAINT `service_plan_features_service_plan_duration_id_foreign` FOREIGN KEY (`service_plan_duration_id`) REFERENCES `service_plan_durations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tips`
--
ALTER TABLE `tips`
  ADD CONSTRAINT `tips_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tip_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tips_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tip_plan_access`
--
ALTER TABLE `tip_plan_access`
  ADD CONSTRAINT `tip_plan_access_service_plan_id_foreign` FOREIGN KEY (`service_plan_id`) REFERENCES `service_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tip_plan_access_tip_id_foreign` FOREIGN KEY (`tip_id`) REFERENCES `tips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tip_updates`
--
ALTER TABLE `tip_updates`
  ADD CONSTRAINT `tip_updates_tip_id_foreign` FOREIGN KEY (`tip_id`) REFERENCES `tips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_service_plan_duration_id_foreign` FOREIGN KEY (`service_plan_duration_id`) REFERENCES `service_plan_durations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_subscriptions_service_plan_id_foreign` FOREIGN KEY (`service_plan_id`) REFERENCES `service_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
