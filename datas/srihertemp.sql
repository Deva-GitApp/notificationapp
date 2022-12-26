-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 26, 2022 at 09:11 AM
-- Server version: 8.0.29
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srihertemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_log`
--

DROP TABLE IF EXISTS `tbl_admin_log`;
CREATE TABLE IF NOT EXISTS `tbl_admin_log` (
  `admin_log_id` int NOT NULL AUTO_INCREMENT,
  `fk_user_id` int NOT NULL,
  `login` datetime NOT NULL,
  `login_ip` varchar(15) NOT NULL,
  `logout` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_user`
--

DROP TABLE IF EXISTS `tbl_admin_user`;
CREATE TABLE IF NOT EXISTS `tbl_admin_user` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `employee_id` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT 'no-image.jpg',
  `email` varchar(50) NOT NULL,
  `password` char(64) DEFAULT NULL,
  `user_pin` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landing_url` text,
  `country` text,
  `state` text,
  `city` text,
  `pincode` varchar(15) DEFAULT NULL,
  `geolocation_id` varchar(30) DEFAULT NULL,
  `fk_roletype_id` int NOT NULL,
  `fk_department_id` int NOT NULL,
  `visiting_consultant` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 => No need sent Cancel SMS 1=> Need to sent Cancel SMS',
  `status` enum('0','1') DEFAULT '1',
  `archive_status` enum('0','1') DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `mobile_UNIQUE` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_admin_user`
--

INSERT INTO `tbl_admin_user` (`admin_id`, `name`, `employee_id`, `photo`, `email`, `password`, `user_pin`, `mobile`, `address`, `landing_url`, `country`, `state`, `city`, `pincode`, `geolocation_id`, `fk_roletype_id`, `fk_department_id`, `visiting_consultant`, `status`, `archive_status`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, 'admin', 'ICON', 'adminprofile130148.png', 'admin@admin.com', 'ek4xUVBzR0diQ3dMQWRKWjd5RXNSUT09', '123456', '9856236589', 'Test Address', NULL, 'India', 'Tamil Nadu', 'Tirunelveli', '627801', '1000737972', 1, 3, '0', '1', '1', '2015-07-11 00:00:00', 1, '2022-11-18 07:00:28', 1),
(4, 'Controller of Examination', 'coe', 'no-image.jpg', 'coe@sriramachancdra.edu.in', 'T3pjT0ppNjRKQUJTTFM2RWcwaGE2Zz09', '123456', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '0', '1', '1', '2022-12-26 09:06:33', NULL, '2022-12-26 09:08:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dbbkdetails`
--

DROP TABLE IF EXISTS `tbl_dbbkdetails`;
CREATE TABLE IF NOT EXISTS `tbl_dbbkdetails` (
  `dbbkdetails_id` int NOT NULL AUTO_INCREMENT,
  `fk_project_id` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `db_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `db_path` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `status` enum('0','1') DEFAULT '1',
  `archive_status` enum('0','1') DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int DEFAULT NULL,
  PRIMARY KEY (`dbbkdetails_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_dbbkdetails`
--

INSERT INTO `tbl_dbbkdetails` (`dbbkdetails_id`, `fk_project_id`, `db_name`, `db_path`, `status`, `archive_status`, `created_date`, `created_by`, `modified_date`, `modified_by`) VALUES
(1, '1', 'test', 'https://www.sriramachandra.edu.in/', '1', '1', '2022-11-28 06:04:56', 1, '2022-11-28 08:29:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE IF NOT EXISTS `tbl_department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `department_code` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `department_week` int NOT NULL DEFAULT '0',
  `department_desc` varchar(250) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `archive_status` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
-- Error reading data for table srihertemp.tbl_department: #2006 - MySQL server has gone away
<div class="alert alert-danger" role="alert"><h1>Error</h1><p><strong>SQL query:</strong>  <a href="#" class="copyQueryBtn" data-text="SET SQL_QUOTE_SHOW_CREATE = 1">Copy</a>
<a href="index.php?route=/database/sql&sql_query=SET+SQL_QUOTE_SHOW_CREATE+%3D+1&show_query=1&db=srihertemp"><span class="nowrap"><img src="themes/dot.gif" title="Edit" alt="Edit" class="icon ic_b_edit">&nbsp;Edit</span></a>    </p>
<p>
<code class="sql"><pre>
SET SQL_QUOTE_SHOW_CREATE = 1
</pre></code>
</p>
<p>
    <strong>MySQL said: </strong><a href="./url.php?url=https%3A%2F%2Fdev.mysql.com%2Fdoc%2Frefman%2F8.0%2Fen%2Fserver-error-reference.html" target="mysql_doc"><img src="themes/dot.gif" title="Documentation" alt="Documentation" class="icon ic_b_help"></a>
</p>
<code>#2006 - MySQL server has gone away</code><br></div>