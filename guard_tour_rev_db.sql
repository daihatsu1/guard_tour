/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - guard_tour_v3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`guard_tour_v3` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `guard_tour_v3`;

/*Table structure for table `admisecsgp_apikeys` */

DROP TABLE IF EXISTS `admisecsgp_apikeys`;

CREATE TABLE `admisecsgp_apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` varchar(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Table structure for table `admisecsgp_apilogs` */

DROP TABLE IF EXISTS `admisecsgp_apilogs`;

CREATE TABLE `admisecsgp_apilogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text DEFAULT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=utf8;

/*Table structure for table `admisecsgp_mstckp` */

DROP TABLE IF EXISTS `admisecsgp_mstckp`;

CREATE TABLE `admisecsgp_mstckp` (
  `checkpoint_id` varchar(20) NOT NULL,
  `check_no` varchar(100) NOT NULL,
  `check_name` varchar(150) NOT NULL,
  `admisecsgp_mstzone_zone_id` varchar(20) NOT NULL,
  `others` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) NOT NULL,
  `durasi_batas_atas` int(11) NOT NULL,
  `durasi_batas_bawah` int(11) NOT NULL,
  PRIMARY KEY (`checkpoint_id`),
  KEY `admisecsgp_mstckp_FK` (`admisecsgp_mstzone_zone_id`),
  KEY `admisecsgp_mstckp_FK_1` (`created_by`),
  KEY `admisecsgp_mstckp_FK_2` (`updated_by`),
  CONSTRAINT `admisecsgp_mstckp_FK` FOREIGN KEY (`admisecsgp_mstzone_zone_id`) REFERENCES `admisecsgp_mstzone` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstcmp` */

DROP TABLE IF EXISTS `admisecsgp_mstcmp`;

CREATE TABLE `admisecsgp_mstcmp` (
  `company_id` varchar(20) NOT NULL,
  `comp_name` varchar(30) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `comp_phone` varchar(50) NOT NULL,
  `others` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstevent` */

DROP TABLE IF EXISTS `admisecsgp_mstevent`;

CREATE TABLE `admisecsgp_mstevent` (
  `event_id` varchar(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `admisecsgp_mstkobj_kategori_id` varchar(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `FK_kobj` (`admisecsgp_mstkobj_kategori_id`),
  CONSTRAINT `FK_kategori` FOREIGN KEY (`admisecsgp_mstkobj_kategori_id`) REFERENCES `admisecsgp_mstkobj` (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstkobj` */

DROP TABLE IF EXISTS `admisecsgp_mstkobj`;

CREATE TABLE `admisecsgp_mstkobj` (
  `kategori_id` varchar(10) NOT NULL,
  `kategori_name` varchar(60) NOT NULL,
  `others` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstobj` */

DROP TABLE IF EXISTS `admisecsgp_mstobj`;

CREATE TABLE `admisecsgp_mstobj` (
  `objek_id` varchar(10) NOT NULL,
  `nama_objek` varchar(255) NOT NULL,
  `admisecsgp_mstkobj_kategori_id` varchar(20) NOT NULL,
  `admisecsgp_mstckp_checkpoint_id` varchar(20) NOT NULL,
  `others` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`objek_id`),
  KEY `admisecsgp_mstobj_FK` (`admisecsgp_mstckp_checkpoint_id`),
  KEY `admisecsgp_mstkobj_FK` (`admisecsgp_mstkobj_kategori_id`),
  KEY `admisecsgp_mstusr_FK` (`created_by`),
  KEY `admisecsgp_mstusr_FK_1` (`updated_by`),
  CONSTRAINT `admisecsgp_mstkobj_FK` FOREIGN KEY (`admisecsgp_mstkobj_kategori_id`) REFERENCES `admisecsgp_mstkobj` (`kategori_id`),
  CONSTRAINT `admisecsgp_mstobj_FK` FOREIGN KEY (`admisecsgp_mstckp_checkpoint_id`) REFERENCES `admisecsgp_mstckp` (`checkpoint_id`),
  CONSTRAINT `admisecsgp_mstusr_FK` FOREIGN KEY (`created_by`) REFERENCES `admisecsgp_mstusr` (`npk`),
  CONSTRAINT `admisecsgp_mstusr_FK_1` FOREIGN KEY (`updated_by`) REFERENCES `admisecsgp_mstusr` (`npk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstplant` */

DROP TABLE IF EXISTS `admisecsgp_mstplant`;

CREATE TABLE `admisecsgp_mstplant` (
  `plant_id` varchar(20) NOT NULL,
  `plant_name` varchar(50) NOT NULL,
  `kode_plant` varchar(20) NOT NULL,
  `admisecsgp_mstsite_site_id` varchar(20) NOT NULL,
  `others` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`plant_id`),
  KEY `admisecsgp_mstplant_FK` (`admisecsgp_mstsite_site_id`),
  KEY `admisecsgp_mstplant_FK_1` (`created_by`),
  KEY `admisecsgp_mstplant_FK_2` (`updated_by`),
  CONSTRAINT `admisecsgp_mstplant_FK` FOREIGN KEY (`admisecsgp_mstsite_site_id`) REFERENCES `admisecsgp_mstsite` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstproduction` */

DROP TABLE IF EXISTS `admisecsgp_mstproduction`;

CREATE TABLE `admisecsgp_mstproduction` (
  `produksi_id` varchar(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` bigint(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`produksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `admisecsgp_mstroleusr` */

DROP TABLE IF EXISTS `admisecsgp_mstroleusr`;

CREATE TABLE `admisecsgp_mstroleusr` (
  `role_id` varchar(20) NOT NULL,
  `level` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstshift` */

DROP TABLE IF EXISTS `admisecsgp_mstshift`;

CREATE TABLE `admisecsgp_mstshift` (
  `shift_id` varchar(11) NOT NULL,
  `nama_shift` varchar(100) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstsite` */

DROP TABLE IF EXISTS `admisecsgp_mstsite`;

CREATE TABLE `admisecsgp_mstsite` (
  `site_id` varchar(20) NOT NULL,
  `admisecsgp_mstcmp_company_id` varchar(20) NOT NULL,
  `site_name` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `others` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  KEY `admisecsgp_mstsite_FK` (`admisecsgp_mstcmp_company_id`),
  KEY `admisecsgp_mstsite_FK_1` (`created_by`),
  KEY `admisecsgp_mstsite_FK_2` (`updated_by`),
  CONSTRAINT `admisecsgp_mstsite_FK` FOREIGN KEY (`admisecsgp_mstcmp_company_id`) REFERENCES `admisecsgp_mstcmp` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstusr` */

DROP TABLE IF EXISTS `admisecsgp_mstusr`;

CREATE TABLE `admisecsgp_mstusr` (
  `npk` varchar(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admisecsgp_mstroleusr_role_id` varchar(11) NOT NULL,
  `admisecsgp_mstcmp_company_id` varchar(11) NOT NULL,
  `admisecsgp_mstsite_site_id` varchar(11) NOT NULL,
  `admisecsgp_mstplant_plant_id` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`npk`),
  KEY `admisecsgp_mstusr_FK_` (`admisecsgp_mstcmp_company_id`),
  KEY `admisecsgp_mstusr_FK12` (`admisecsgp_mstsite_site_id`),
  KEY `admisecsgp_mstplant_FK1` (`admisecsgp_mstplant_plant_id`),
  KEY `admisecsgp_mstusr_FK13` (`admisecsgp_mstroleusr_role_id`),
  KEY `admisecsgp_mstusr_FK14` (`created_by`),
  KEY `admisecsgp_mstusr_FK15` (`updated_by`),
  CONSTRAINT `admisecsgp_mstplant_FK1` FOREIGN KEY (`admisecsgp_mstplant_plant_id`) REFERENCES `admisecsgp_mstplant` (`plant_id`),
  CONSTRAINT `admisecsgp_mstusr_FK12` FOREIGN KEY (`admisecsgp_mstsite_site_id`) REFERENCES `admisecsgp_mstsite` (`site_id`),
  CONSTRAINT `admisecsgp_mstusr_FK13` FOREIGN KEY (`admisecsgp_mstroleusr_role_id`) REFERENCES `admisecsgp_mstroleusr` (`role_id`),
  CONSTRAINT `admisecsgp_mstusr_FK_` FOREIGN KEY (`admisecsgp_mstcmp_company_id`) REFERENCES `admisecsgp_mstcmp` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_mstzone` */

DROP TABLE IF EXISTS `admisecsgp_mstzone`;

CREATE TABLE `admisecsgp_mstzone` (
  `zone_id` varchar(20) NOT NULL,
  `zone_name` varchar(60) NOT NULL,
  `kode_zona` varchar(30) NOT NULL,
  `admisecsgp_mstplant_plant_id` varchar(11) NOT NULL,
  `others` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  `durasi_batas_atas` int(11) NOT NULL,
  `durasi_batas_bawah` int(11) NOT NULL,
  `status_produksi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `admisecsgp_mstzone_FK` (`admisecsgp_mstplant_plant_id`),
  KEY `admisecsgp_mstzone_FK_1` (`created_by`),
  KEY `admisecsgp_mstzone_FK_2` (`updated_by`),
  CONSTRAINT `admisecsgp_mstzone_FK` FOREIGN KEY (`admisecsgp_mstplant_plant_id`) REFERENCES `admisecsgp_mstplant` (`plant_id`),
  CONSTRAINT `admisecsgp_mstzone_FK_1` FOREIGN KEY (`created_by`) REFERENCES `admisecsgp_mstusr` (`npk`),
  CONSTRAINT `admisecsgp_mstzone_FK_2` FOREIGN KEY (`updated_by`) REFERENCES `admisecsgp_mstusr` (`npk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_trans_details` */

DROP TABLE IF EXISTS `admisecsgp_trans_details`;

CREATE TABLE `admisecsgp_trans_details` (
  `trans_detail_id` varchar(20) NOT NULL,
  `admisecsgp_trans_headers_trans_headers_id` varchar(20) NOT NULL,
  `admisecsgp_mstobj_objek_id` varchar(20) NOT NULL,
  `conditions` tinyint(4) NOT NULL,
  `admisecsgp_msteventdtls_detail_event_id` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `is_laporan_kejadian` tinyint(4) DEFAULT NULL,
  `laporkan_pic` tinyint(4) DEFAULT NULL,
  `is_tindakan_cepat` tinyint(4) DEFAULT NULL,
  `status_temuan` int(1) DEFAULT NULL,
  `deskripsi_tindakan` varchar(255) DEFAULT NULL,
  `note_tindakan_cepat` tinyint(4) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`trans_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_trans_headers` */

DROP TABLE IF EXISTS `admisecsgp_trans_headers`;

CREATE TABLE `admisecsgp_trans_headers` (
  `trans_header_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admisecsgp_mstshift_shift_id` varchar(20) NOT NULL,
  `admisecsgp_mstusr_npk` varchar(20) NOT NULL,
  `admisecsgp_mstzone_zone_id` varchar(20) NOT NULL,
  `admisecsgp_mstckp_checkpoint_id` varchar(20) NOT NULL,
  `date_patroli` date NOT NULL,
  `time_checkpoint` datetime NOT NULL,
  `status` bigint(20) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`trans_header_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_trans_jadwal_patroli` */

DROP TABLE IF EXISTS `admisecsgp_trans_jadwal_patroli`;

CREATE TABLE `admisecsgp_trans_jadwal_patroli` (
  `date_patroli` date NOT NULL,
  `admisecsgp_mstplant_plant_id` varchar(20) NOT NULL,
  `admisecsgp_mstusr_npk` varchar(20) NOT NULL,
  `admisecsgp_mstshift_shift_id` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`date_patroli`),
  KEY `FK_user_id` (`admisecsgp_mstusr_npk`),
  KEY `FK_plant_id` (`admisecsgp_mstplant_plant_id`),
  KEY `FK_shift_id` (`admisecsgp_mstshift_shift_id`),
  CONSTRAINT `FK_plant` FOREIGN KEY (`admisecsgp_mstplant_plant_id`) REFERENCES `admisecsgp_mstplant` (`plant_id`),
  CONSTRAINT `FK_shift_id` FOREIGN KEY (`admisecsgp_mstshift_shift_id`) REFERENCES `admisecsgp_mstshift` (`shift_id`),
  CONSTRAINT `FK_user_id` FOREIGN KEY (`admisecsgp_mstusr_npk`) REFERENCES `admisecsgp_mstusr` (`npk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `admisecsgp_trans_zona_patroli` */

DROP TABLE IF EXISTS `admisecsgp_trans_zona_patroli`;

CREATE TABLE `admisecsgp_trans_zona_patroli` (
  `date_patroli` date NOT NULL,
  `admisecsgp_mstshift_shift_id` bigint(20) NOT NULL,
  `admisecsgp_mstplant_plant_id` bigint(20) NOT NULL,
  `admisecsgp_mstzone_zona_id` bigint(20) NOT NULL,
  `admisecsg_mstproduksi_produksi_id` bigint(20) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_zona` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`date_patroli`),
  KEY `ms_plant` (`admisecsgp_mstplant_plant_id`),
  KEY `ms_zona` (`admisecsgp_mstzone_zona_id`),
  KEY `ms_shift` (`admisecsgp_mstshift_shift_id`),
  KEY `ms_produksi` (`admisecsg_mstproduksi_produksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
