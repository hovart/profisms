/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.6.18-MariaDB : Database - multi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`multi` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `multi`;

/*Table structure for table `msisdn_list` */

DROP TABLE IF EXISTS `msisdn_list`;

CREATE TABLE `msisdn_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `msisdn_list_msisdn` */

DROP TABLE IF EXISTS `msisdn_list_msisdn`;

CREATE TABLE `msisdn_list_msisdn` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_msisdn_list` int(11) NOT NULL,
  `msisdn` text DEFAULT NULL,
  PRIMARY KEY (`id`,`id_msisdn_list`),
  KEY `id_msisdn_list` (`id_msisdn_list`),
  CONSTRAINT `msisdn_list_msisdn_ibfk_1` FOREIGN KEY (`id_msisdn_list`) REFERENCES `msisdn_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
