-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2019 at 11:16 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `squirrel`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) UNSIGNED NOT NULL,
  `foreignid` varchar(255) DEFAULT NULL COMMENT 'ID in external system',
  `name` varchar(255) NOT NULL,
  `description` text,
  `logo_id` varchar(255) DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `companyowner_id` int(11) NOT NULL DEFAULT '0',
  `type` int(4) NOT NULL DEFAULT '0' COMMENT '1=Builder, 2=Organisation, 3=PM, 4=Consult',
  `organisationtype` int(4) NOT NULL DEFAULT '0' COMMENT 'type if is organisation 1=supplier, 2=subcontract, 3=client, 4=consultant',
  `trade_id` int(11) NOT NULL DEFAULT '0',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `foreignid`, `name`, `description`, `logo_id`, `owner_id`, `companyowner_id`, `type`, `organisationtype`, `trade_id`, `modified_date`) VALUES
(1, NULL, 'BFC', NULL, NULL, 1, 0, 0, 0, 0, '2017-03-17 06:49:26'),
(2, '1', 'company', 'aoeu', NULL, 1, 0, 1, 0, 0, '2017-03-17 06:49:55'),
(3, NULL, 'My Company', 'a new company', NULL, 7, 0, 0, 0, 0, '2018-02-19 23:34:57'),
(4, NULL, 'My Company', 'a new company', NULL, 8, 0, 0, 0, 0, '2018-02-19 23:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `company_meta`
--

CREATE TABLE `company_meta` (
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `meta_name` varchar(250) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) UNSIGNED NOT NULL,
  `number` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `system_id` int(11) UNSIGNED NOT NULL,
  `create_user` int(11) UNSIGNED NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `number`, `name`, `description`, `system_id`, `create_user`, `create_date`, `deleted`) VALUES
(1, 1, 'test', 'test', 11, 1, '2017-03-17 07:50:46', 0),
(2, -1, 'aoeu', 'oaeu', 0, 1, '2017-03-21 10:38:53', 0),
(3, -1, 'ojeoj', 'oejoe', 0, 1, '2017-03-21 10:40:51', 0),
(4, -1, 'eudue', 'ekuek', 19, 1, '2017-03-21 10:41:42', 0),
(5, 0, 'jea', 'aeoj', 19, 1, '2017-03-21 10:44:26', 0),
(6, 1, 'aoje', 'aoej', 19, 1, '2017-03-21 10:44:38', 0),
(7, 0, 'Add SSL for all pages', 'Create page setting to force SSL for all pages.', 21, 1, '2017-03-21 11:46:15', 0),
(8, 0, 'Add redirect to index.php', 'blah blah here\'s what I did.', 13, 1, '2017-03-21 13:19:57', 0),
(9, 0, 'another test', 'this is a test', 0, 1, '2018-02-07 04:47:10', 0),
(10, 1, 'another test', 'this is a test', 0, 1, '2018-02-07 04:48:36', 0),
(11, 2, 'aoeu', 'aeou', 0, 1, '2018-02-07 04:51:30', 0),
(12, 3, 'aou', 'aoeu', 0, 1, '2018-02-07 04:53:31', 0),
(13, 4, 'jaoeja', 'aoejaoej', 0, 1, '2018-02-07 04:55:34', 0),
(14, 5, 'jeaoej', 'aojoej', 0, 1, '2018-02-07 04:55:45', 0),
(15, 0, 'eoj', 'oeaj', 20, 1, '2018-02-07 05:00:49', 1),
(16, 0, 'Create Relay Account', 'Created a relay account for squirrel mail on SMTP2Go using james@billson.com account.', 26, 1, '2018-02-11 01:23:39', 0),
(17, 0, 'Add SPF records for SMTP2GO', 'Added SPF and CNAME records to the DNS for billson.com to allow use of SMTP2GO', 25, 1, '2018-02-11 01:24:28', 0),
(18, 0, 'Changed the App directory in local config', 'The application directory was set to / . Changed to be empty.', 27, 1, '2018-02-11 01:25:51', 0),
(19, 1, 'Set SSL for live site', 'Set the protocol in local config to be SSL, using Cloudflare SSL', 27, 1, '2018-02-11 01:27:29', 0),
(20, 0, 'Establish SMTP2GO Account', 'Create account for PSI to send email from site.', 32, 1, '2018-02-12 04:36:27', 0),
(21, 0, 'Add SPF records for SMTP2GO', 'Add anti spam records and CNAME to psychsolutions DNS ', 31, 1, '2018-02-12 04:37:12', 0),
(22, 0, 'Deployment of live war file', 'Deployed version 2.2.5 with SMTP changes and issues #2, #3, #5', 33, 1, '2018-02-12 20:44:02', 0),
(23, 1, 'Added server specific hosts ', 'A atl 68.169.50.154\r\nA stl 199.217.112.209\r\nA syd 103.18.42.17', 31, 1, '2018-02-13 04:20:34', 0),
(24, 0, 'Add web server', 'Add server for development and hosting of site', 35, 1, '2018-02-14 00:12:30', 0),
(25, 0, 'Stripe invoice synchronisation', 'Read new invoice from Stripe and post to https://www.reqfire.com/app/user/invoice', 37, 1, '2018-02-18 06:08:55', 0),
(26, 0, 'Changed free period on subscriptions', 'Added a 30 days free to the two subscription types, as we take a payment at the time of subscribing.', 38, 1, '2018-02-19 08:00:20', 0),
(27, 0, 'Add extlink field to Release table', 'ALTER TABLE `release` ADD `extlink` VARCHAR(255) NULL AFTER `project_id`;', 40, 1, '2018-03-27 07:13:55', 0),
(28, 1, 'Add fields to Basicapproval table', 'Added link varchar 255 null, type tinyint 4 default 0', 40, 1, '2018-03-27 07:20:13', 0),
(29, 1, 'create builds.reqfire.com bucket', 'Created a new bucket called builds.reqfire.com to hold the react bundles for the front end.', 20, 1, '2018-04-10 23:34:22', 1),
(30, 1, 'Add CNAME for builds s3 bucket', 'pointed the host builds to the builds.reqfire.com.s3.amazonaws.com bucket.', 21, 1, '2018-04-10 23:35:16', 1),
(31, 2, 'Change SSL to Flexible', 'The amazon bucket is not https so switched the Crypto setting to flexible.', 21, 1, '2018-04-10 23:35:54', 0),
(32, 0, 'S3 bucket for images', 'Create a bucket called images.primary.app to store images', 23, 1, '2018-08-09 05:45:54', 0),
(33, 1, 'builds.primary.app bucket', 'change the bucket name for he storage of production code', 23, 1, '2018-08-09 05:47:18', 0),
(34, 3, 'Primary.App domain added', 'Add new domain to cloudflare', 21, 1, '2018-08-09 05:48:06', 0),
(35, 0, 'testing.psi certificate renewal script', 'The certificate update script that gets the new 90 day certificate from Lets Encrypt has to restart Apache to make the new certificate valid.', 29, 1, '2019-02-20 00:19:40', 0),
(36, 2, 'point testing to SYD', 'testing host was left pointing to STL which caused the SSL not to update.', 31, 1, '2019-02-20 00:20:33', 0),
(37, 0, 'uoe', 'oejaoej', 28, 1, '2019-05-21 02:26:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `firstname` varchar(255) NOT NULL DEFAULT '0',
  `lastname` varchar(255) NOT NULL,
  `link` varchar(50) NOT NULL,
  `modified` int(11) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follower`
--

INSERT INTO `follower` (`id`, `project_id`, `confirmed`, `email`, `firstname`, `lastname`, `link`, `modified`, `modified_date`) VALUES
(2, 1, 0, 'aoejoej@billson.com', 'jaoe', 'oej', '5a7e966d0dd3c0.73921477', 1, '2018-02-10 06:51:25'),
(3, 1, 1, 'testing@billson.com', 'test', 'testicle', '0', 1, '2018-02-10 07:46:21'),
(4, 1, 1, 'cirius@billson.com', 'Cirius', 'Test', '0', 1, '2018-02-11 10:57:09'),
(5, 1, 1, 'testagain3@billson.com', 'test', 'again', '0', 1, '2018-02-14 04:52:17'),
(7, 4, 1, 'c1@billson.com', 'test', 'test', '0', 1, '2018-02-19 23:32:18'),
(9, 6, 0, 'danny@clari.net.au', 'Danny', 'O\'Callaghan', '5a8b626b0da555.95977677', 1, '2018-02-19 23:48:59'),
(10, 4, 0, 'danny@clari.net.au', 'Danny', 'O\'callaghan', '5b6bd8441adea4.21853507', 1, '2018-08-09 05:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `id` int(11) NOT NULL,
  `ext` varchar(255) NOT NULL,
  `project_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`id`, `ext`, `project_id`, `number`, `name`, `description`, `active`) VALUES
(1, '2uiaejkajeuoeuoaeu', 1, 0, 'deploy master branch', 'aoeu', 1),
(2, '2fe9866c650f836e3b8be62c532260a0', 1, 0, 'deploy test branch', 'two\r\n', 1),
(3, 'a6bd898c8a551fc465c8485588e032fd', 6, 0, 'Swap servers between SYD and STL', 'Change the live server between Exigent server and Server4U\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `processresult`
--

CREATE TABLE `processresult` (
  `id` int(11) NOT NULL,
  `processrun_id` int(11) NOT NULL,
  `processstep_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `result` tinyint(1) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `processresult`
--

INSERT INTO `processresult` (`id`, `processrun_id`, `processstep_id`, `user_id`, `date`, `result`, `comments`) VALUES
(1, 13, 1, 1, '2019-02-25 06:03:06', 1, 'had to accept new key'),
(2, 13, 2, 1, '2019-02-25 06:03:06', 1, 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `processrun`
--

CREATE TABLE `processrun` (
  `id` int(11) NOT NULL,
  `ext` varchar(60) NOT NULL,
  `project_id` int(11) NOT NULL,
  `number` smallint(4) NOT NULL,
  `process_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `processrun`
--

INSERT INTO `processrun` (`id`, `ext`, `project_id`, `number`, `process_id`, `status`) VALUES
(12, '2a94bae7ecd4d473874a58df7986250a', 1, 1, 1, 1),
(13, '9829ba78ffd716400f060409ca1e6b84', 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `processstep`
--

CREATE TABLE `processstep` (
  `id` int(11) NOT NULL,
  `ext` varchar(60) NOT NULL,
  `process_id` int(11) NOT NULL,
  `number` varchar(30) NOT NULL,
  `action` text NOT NULL,
  `result` text NOT NULL,
  `link` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `processstep`
--

INSERT INTO `processstep` (`id`, `ext`, `process_id`, `number`, `action`, `result`, `link`) VALUES
(1, '14146039816e68a4065c1801ac93cd59', 1, '1', 'Open server in SSH', 'login prompt', 'ieoioe'),
(2, '2083d9af4f0a7bf71858693f16401250', 1, '2', 'change dir to /html', 'prompt shows dir name', 'ieoioe'),
(3, '309e9e383e8e265b5b43c14c44ccca14', 3, '1', 'Log in to STL, and to SYD if it is operating.', 'Log in success', ''),
(4, '169509e8aebf07855e6e60354099caab', 3, '2', 'If Sydney server is still operating, then:\r\na. kill apache with command apachectl stop\r\nb. run /usr/local/bin/rsync-from-syd-to-stl.sh ', 'root@stl:/usr/local/bin# ./rsync-from-syd-to-stl.sh\r\nWed Mar 7 08:22:41 AEDT 2018 rsync of /home/psi\r\nWed Mar 7 08:23:31 AEDT 2018 rsync of /home/staging\r\nWed Mar 7 08:24:04 AEDT 2018 rsync of /usr/local/etc and /usr/local/bin\r\nWed Mar 7 08:24:26 AEDT 2018 rs', ''),
(5, 'd5bcdac32c83d7b53e3389b6454e3b8d', 3, '3', 'On stl run /usr/local/bin/mysql-backups.sh', 'root@stl:/usr/local/bin# ./rsync-from-syd-to-stl.sh\r\nWed Mar 7 08:22:41 AEDT 2018 rsync of /home/psi\r\nWed Mar 7 08:23:31 AEDT 2018 rsync of /home/staging\r\nWed Mar 7 08:24:04 AEDT 2018 rsync of /usr/local/etc and /usr/local/bin\r\nWed Mar 7 08:24:26 AEDT 2018 rs', '');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `stage` int(4) NOT NULL DEFAULT '1' COMMENT '1=bidding, 2=const, 3=finish, 4=tender',
  `extlink` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `icon`, `company_id`, `deleted`, `stage`, `extlink`) VALUES
(1, 'Project One', 'aoeu', NULL, 1, 0, 1, NULL),
(2, 'eoiu', 'This is a stoopid project', NULL, 1, 1, 1, 'c5edbbf16963463ddfcef568a4aca46c'),
(3, 'Another Great Project', 'the second', NULL, 1, 1, 1, '8b247027d1b465f9de3c19e077f9326f'),
(4, 'Primary', 'Primary production system', NULL, 1, 0, 1, 'd0a8b97dc78b15103630bfddcb924a67'),
(5, 'Squirrel', 'Configuration Management System', NULL, 1, 0, 1, '3b4b1f57455d62524d2d690dfb7b54f9'),
(6, 'Psychsolutions', 'PSI client management and testing apps', NULL, 1, 0, 1, '34c95bd72fdf114f6bd573c868a3deea'),
(7, 'Axieo', 'Wordpress website', NULL, 1, 0, 1, '0ac43619788cccc5b8c2d48ebb8f820d');

-- --------------------------------------------------------

--
-- Table structure for table `projectsystem`
--

CREATE TABLE `projectsystem` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL,
  `description` text,
  `create_user` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectsystem`
--

INSERT INTO `projectsystem` (`id`, `project_id`, `system_id`, `description`, `create_user`, `create_date`, `deleted`) VALUES
(1, 1, 11, NULL, 1, '2018-02-11 07:51:41', 0),
(2, 3, 19, NULL, 1, '2018-02-11 07:51:41', 0),
(3, 3, 18, NULL, 1, '2018-02-11 07:51:41', 0),
(4, 3, 17, NULL, 1, '2018-02-11 07:51:41', 0),
(5, 3, 16, NULL, 1, '2018-02-11 07:51:41', 0),
(6, 3, 15, NULL, 1, '2018-02-11 07:51:41', 0),
(7, 3, 14, NULL, 1, '2018-02-11 07:51:41', 0),
(8, 3, 13, NULL, 1, '2018-02-11 07:51:41', 0),
(9, 4, 20, NULL, 1, '2018-02-11 07:51:41', 0),
(10, 4, 21, NULL, 1, '2018-02-11 07:51:41', 0),
(11, 4, 22, NULL, 1, '2018-02-11 07:51:41', 0),
(12, 4, 22, NULL, 1, '2018-02-11 07:51:41', 0),
(13, 4, 23, NULL, 1, '2018-02-11 07:51:41', 0),
(14, 5, 24, NULL, 1, '2018-02-11 07:51:41', 0),
(15, 5, 25, NULL, 1, '2018-02-11 07:51:41', 0),
(16, 5, 26, NULL, 1, '2018-02-11 07:52:19', 0),
(17, 5, 27, NULL, 1, '2018-02-11 07:52:19', 0),
(18, 6, 28, '', 1, '2018-02-11 11:00:54', 0),
(19, 6, 29, '', 1, '2018-02-11 11:01:40', 0),
(20, 6, 30, '', 1, '2018-02-11 11:02:08', 0),
(21, 6, 31, '', 1, '2018-02-11 11:02:47', 0),
(22, 6, 32, '', 1, '2018-02-11 11:03:20', 0),
(23, 6, 33, '', 1, '2018-02-12 20:39:09', 0),
(24, 6, 34, '', 1, '2018-02-12 21:00:09', 0),
(25, 6, 35, '', 1, '2018-02-14 00:10:52', 1),
(26, 7, 35, 'webserver', 1, '2018-02-14 00:11:45', 1),
(27, 6, 36, '', 1, '2018-02-15 10:29:47', 0),
(28, 4, 37, '', 1, '2018-02-18 06:05:47', 0),
(29, 4, 38, '', 1, '2018-02-18 06:06:04', 0),
(30, 4, 39, '', 1, '2018-02-18 06:07:19', 0),
(31, 4, 35, 'host for production and staging', 1, '2018-02-19 08:49:29', 0),
(32, 4, 40, '', 1, '2018-03-27 07:13:05', 0),
(33, 4, 41, '', 1, '2018-08-09 06:01:11', 0),
(34, 4, 42, '', 1, '2018-08-09 06:01:57', 0),
(35, 7, 43, '', 1, '2018-08-22 03:19:01', 0),
(36, 7, 35, 'host for virtual web server', 1, '2018-08-22 03:20:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_meta`
--

CREATE TABLE `project_meta` (
  `project_id` int(11) NOT NULL,
  `meta_name` varchar(250) NOT NULL,
  `meta_value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `create_user` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '-1',
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `name`, `description`, `create_user`, `create_date`, `number`, `deleted`, `type`, `parent_id`, `company_id`) VALUES
(11, 'First System', '', 1, '2017-02-20 23:41:36', 2, 0, 0, -1, 1),
(13, 'Web Server', 'A web server', 1, '2017-03-21 10:08:48', 17, 0, 0, -1, 1),
(14, 'Cloudflare', 'DNS and CDN', 1, '2017-03-21 10:09:56', 18, 0, 0, -1, 1),
(15, 'Application Server', '', 1, '2017-03-21 10:13:09', 15, 0, 0, -1, 1),
(16, 'Wordpress', '', 1, '2017-03-21 10:14:18', 16, 0, 0, -1, 1),
(17, 'aoe', '', 1, '2017-03-21 10:18:05', 7, 0, 0, -1, 1),
(18, 'joaejoaej', '', 1, '2017-03-21 10:20:14', 8, 0, 0, -1, 1),
(19, 'Mail server', '', 1, '2017-03-21 10:21:02', 9, 0, 0, -1, 1),
(20, 'Web Server', 'Nginix web server', 1, '2017-03-21 11:45:05', 41, 0, 0, 35, 1),
(21, 'Cloudflare', 'DNS and CDN service', 1, '2017-03-21 11:45:24', 13, 0, 0, -1, 1),
(22, 'Circle CI', 'Continuous integration System', 1, '2018-02-10 02:23:10', 19, 0, 0, -1, 1),
(23, 'Amazon Web Service - S3', 'S3 bucket for production code', 1, '2018-02-10 02:23:33', 20, 0, 0, -1, 1),
(24, 'Web Server', 'Web server hosting squirrel.billson.com', 1, '2018-02-10 06:06:25', 21, 0, 0, -1, 1),
(25, 'DNS - Cloudforge', 'DNS and CDN service', 1, '2018-02-10 06:06:47', 22, 0, 0, -1, 1),
(26, 'SMTP2Go', 'SMTP service', 1, '2018-02-10 06:07:04', 23, 0, 0, -1, 1),
(27, 'Yii Application Framework', 'The MVC framework that Squirrel is built on', 1, '2018-02-11 01:25:03', 24, 0, 0, -1, 1),
(28, 'Eapps production server', 'Legacy production server based in Atlanta.', 1, '2018-02-11 11:00:54', 25, 0, 0, -1, 1),
(29, 'Exigent production server', 'Server based in Sydney', 1, '2018-02-11 11:01:40', 26, 0, 0, -1, 1),
(30, 'Server4you back-up server', 'Server based in St Louis', 1, '2018-02-11 11:02:08', 27, 0, 0, -1, 1),
(31, 'Cloudflare', 'DNS and CDN system', 1, '2018-02-11 11:02:47', 28, 0, 0, -1, 1),
(32, 'SMTP2GO', 'Smtp Service', 1, '2018-02-11 11:03:20', 30, 0, 0, -1, 1),
(33, 'Clientlogin Application', 'Grails based Java Application', 1, '2018-02-12 20:39:09', 34, 0, 0, 28, 1),
(34, 'Abilities Application', 'Grails based Java application', 1, '2018-02-12 21:00:09', 35, 0, 0, 28, 1),
(35, 'bfc.aus.net virtual server', 'Virtual web server', 1, '2018-02-14 00:10:52', 33, 0, 1, -1, 1),
(36, 'Tomcat 6', 'Application Server', 1, '2018-02-15 10:29:47', 36, 0, 0, 28, 1),
(37, 'Zapier', 'Automated task system', 1, '2018-02-18 06:05:47', 37, 0, 1, -1, 1),
(38, 'Stripe', 'Payment system', 1, '2018-02-18 06:06:04', 38, 0, 0, -1, 1),
(39, 'bfc.aus.net virtual server management', 'Management System for hosting server', 1, '2018-02-18 06:07:19', 40, 0, 1, 35, 1),
(40, 'MySql DBMS', 'Database for Reqfire', 1, '2018-03-27 07:13:05', 42, 0, 0, 35, 1),
(41, 'vws4.clari.net.au', 'Virtual server host provided by Clarinet', 1, '2018-08-09 06:01:11', 43, 0, 1, -1, 1),
(42, 'primary.app web server', 'virtual server', 1, '2018-08-09 06:01:57', 44, 0, 0, 41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `system_id` int(10) UNSIGNED DEFAULT NULL,
  `config_id` int(11) UNSIGNED DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`id`, `company_id`, `user_id`, `project_id`, `system_id`, `config_id`, `start`, `end`, `note`) VALUES
(3, 1, 1, 6, 29, NULL, '2019-05-01 00:00:00', '2019-05-01 01:00:00', ''),
(9, 1, 1, 6, 29, 36, '2019-05-11 00:00:00', '2019-05-11 02:15:00', ''),
(15, 1, 1, 6, 28, 37, '2019-05-22 08:30:00', '2019-05-22 10:00:00', 'eaooeau'),
(16, 1, 1, 6, NULL, NULL, '2019-05-22 16:30:00', '2019-05-22 17:00:00', 'test no system'),
(17, 1, 1, 6, NULL, NULL, '2019-05-23 15:30:00', '2019-05-23 16:00:00', 'eou'),
(21, 1, 1, 6, NULL, NULL, '2019-05-23 15:30:00', '2019-05-23 16:00:00', 'project only'),
(22, 1, 1, 6, 33, NULL, '2019-05-23 15:30:00', '2019-05-23 16:00:00', 'debugging'),
(25, 1, 1, 6, 29, 35, '2019-05-24 12:30:00', '2019-05-24 16:00:00', 'oeauoaeu');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `address_id` int(11) DEFAULT NULL,
  `salt` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `company_id`, `address_id`, `salt`, `username`) VALUES
(1, 'James', 'Billson', 'james@billson.com', '1a1dc91c907325c69271ddf0c944bc72', 1, NULL, '53ec190a357c80.02231615', 'james@billson.com'),
(2, 'oaeuaoe', 'aoejoej', 'aojoeoe@oaueoaj.au', '05f60ba25a20f67f442f4127e4d6c4dd', 0, NULL, '58ab96c9b28c51.65454631', 'aojoeoe@oaueoaj.au'),
(3, 'aoej', 'ajeaoj', 'biuixx@kuok.au', '05f60ba25a20f67f442f4127e4d6c4dd', 0, NULL, '58ab9772ad8f06.62121697', 'biuixx@kuok.au'),
(4, 'aoeu', 'ajaoej', 'testagain3@billson.com', '05f60ba25a20f67f442f4127e4d6c4dd', 0, NULL, '5a83c0ff54a200.57340398', 'testagain3@billson.com'),
(7, 'aoeu', 'aoeu', 'c1@billson.com', '05f60ba25a20f67f442f4127e4d6c4dd', 3, NULL, '5a8b5f2133dd00.10059593', 'c1@billson.com'),
(8, 'Jack', 'Hurley', 'jack.hurley23@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', 4, NULL, '5a8b60a3d55e02.32716077', 'jack.hurley23@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_meta`
--
ALTER TABLE `company_meta`
  ADD KEY `ikEntity` (`company_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `processresult`
--
ALTER TABLE `processresult`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processrun`
--
ALTER TABLE `processrun`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `process_id` (`process_id`);

--
-- Indexes for table `processstep`
--
ALTER TABLE `processstep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `process_id` (`process_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `extlink` (`extlink`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `projectsystem`
--
ALTER TABLE `projectsystem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `system_id` (`system_id`),
  ADD KEY `create_user` (`create_user`),
  ADD KEY `create_date` (`create_date`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `config_id` (`config_id`),
  ADD KEY `system_id` (`system_id`),
  ADD KEY `system_id_2` (`system_id`),
  ADD KEY `project` (`project_id`),
  ADD KEY `company` (`company_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `address_id` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `follower`
--
ALTER TABLE `follower`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `processresult`
--
ALTER TABLE `processresult`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `processrun`
--
ALTER TABLE `processrun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `processstep`
--
ALTER TABLE `processstep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projectsystem`
--
ALTER TABLE `projectsystem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `time`
--
ALTER TABLE `time`
  ADD CONSTRAINT `company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `config` FOREIGN KEY (`config_id`) REFERENCES `config` (`id`),
  ADD CONSTRAINT `project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `system` FOREIGN KEY (`system_id`) REFERENCES `system` (`id`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
