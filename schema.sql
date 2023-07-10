-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: parking
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` bigint(20) unsigned DEFAULT 1,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `limit_count` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_place_id_type_unique` (`place_id`,`type`),
  KEY `categories_created_by_foreign` (`created_by`),
  KEY `categories_modified_by_foreign` (`modified_by`),
  CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_wise_floor_slots`
--

DROP TABLE IF EXISTS `category_wise_floor_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_wise_floor_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `floor_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `slot_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slotId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slot_name_unique` (`place_id`,`floor_id`,`category_id`,`slot_name`),
  UNIQUE KEY `category_wise_floor_slots_slotid_unique` (`place_id`,`slotId`),
  KEY `category_wise_floor_slots_category_id_foreign` (`category_id`),
  KEY `category_wise_floor_slots_created_by_foreign` (`created_by`),
  KEY `category_wise_floor_slots_updated_by_foreign` (`updated_by`),
  KEY `category_wise_floor_slots_floor_id_foreign` (`floor_id`),
  CONSTRAINT `category_wise_floor_slots_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_wise_floor_slots_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_wise_floor_slots_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_wise_floor_slots_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  CONSTRAINT `category_wise_floor_slots_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_wise_floor_slots`
--

LOCK TABLES `category_wise_floor_slots` WRITE;
/*!40000 ALTER TABLE `category_wise_floor_slots` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_wise_floor_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_name_unique` (`name`),
  UNIQUE KEY `countries_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','af',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(2,'Åland Islands','ax',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(3,'Albania','al',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(4,'Algeria','dz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(5,'American Samoa','as',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(6,'Andorra','ad',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(7,'Angola','ao',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(8,'Anguilla','ai',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(9,'Antarctica','aq',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(10,'Antigua and Barbuda','ag',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(11,'Argentina','ar',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(12,'Armenia','am',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(13,'Aruba','aw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(14,'Australia','au',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(15,'Austria','at',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(16,'Azerbaijan','az',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(17,'Bahamas','bs',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(18,'Bahrain','bh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(19,'Bangladesh','bd',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(20,'Barbados','bb',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(21,'Belarus','by',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(22,'Belgium','be',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(23,'Belize','bz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(24,'Benin','bj',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(25,'Bermuda','bm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(26,'Bhutan','bt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(27,'Bolivia (Plurinational State of)','bo',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(28,'Bonaire, Sint Eustatius and Saba','bq',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(29,'Bosnia and Herzegovina','ba',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(30,'Botswana','bw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(31,'Bouvet Island','bv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(32,'Brazil','br',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(33,'British Indian Ocean Territory','io',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(34,'Brunei Darussalam','bn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(35,'Bulgaria','bg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(36,'Burkina Faso','bf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(37,'Burundi','bi',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(38,'Cabo Verde','cv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(39,'Cambodia','kh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(40,'Cameroon','cm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(41,'Canada','ca',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(42,'Cayman Islands','ky',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(43,'Central African Republic','cf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(44,'Chad','td',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(45,'Chile','cl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(46,'China','cn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(47,'Christmas Island','cx',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(48,'Cocos (Keeling) Islands','cc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(49,'Colombia','co',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(50,'Comoros','km',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(51,'Congo','cg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(52,'Congo, Democratic Republic of the','cd',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(53,'Cook Islands','ck',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(54,'Costa Rica','cr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(55,'Côte dIvoire','ci',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(56,'Croatia','hr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(57,'Cuba','cu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(58,'Curaçao','cw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(59,'Cyprus','cy',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(60,'Czechia','cz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(61,'Denmark','dk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(62,'Djibouti','dj',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(63,'Dominica','dm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(64,'Dominican Republic','do',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(65,'Ecuador','ec',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(66,'Egypt','eg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(67,'El Salvador','sv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(68,'Equatorial Guinea','gq',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(69,'Eritrea','er',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(70,'Estonia','ee',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(71,'Eswatini','sz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(72,'Ethiopia','et',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(73,'Falkland Islands (Malvinas)','fk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(74,'Faroe Islands','fo',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(75,'Fiji','fj',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(76,'Finland','fi',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(77,'France','fr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(78,'French Guiana','gf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(79,'French Polynesia','pf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(80,'French Southern Territories','tf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(81,'Gabon','ga',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(82,'Gambia','gm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(83,'Georgia','ge',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(84,'Germany','de',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(85,'Ghana','gh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(86,'Gibraltar','gi',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(87,'Greece','gr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(88,'Greenland','gl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(89,'Grenada','gd',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(90,'Guadeloupe','gp',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(91,'Guam','gu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(92,'Guatemala','gt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(93,'Guernsey','gg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(94,'Guinea','gn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(95,'Guinea-Bissau','gw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(96,'Guyana','gy',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(97,'Haiti','ht',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(98,'Heard Island and McDonald Islands','hm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(99,'Holy See','va',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(100,'Honduras','hn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(101,'Hong Kong','hk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(102,'Hungary','hu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(103,'Iceland','is',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(104,'India','in',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(105,'Indonesia','id',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(106,'Iran (Islamic Republic of)','ir',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(107,'Iraq','iq',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(108,'Ireland','ie',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(109,'Isle of Man','im',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(110,'Israel','il',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(111,'Italy','it',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(112,'Jamaica','jm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(113,'Japan','jp',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(114,'Jersey','je',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(115,'Jordan','jo',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(116,'Kazakhstan','kz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(117,'Kenya','ke',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(118,'Kiribati','ki',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(119,'Korea (Democratic Peoples Republic of)','kp',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(120,'Korea, Republic of','kr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(121,'Kuwait','kw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(122,'Kyrgyzstan','kg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(123,'Lao Peoples Democratic Republic','la',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(124,'Latvia','lv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(125,'Lebanon','lb',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(126,'Lesotho','ls',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(127,'Liberia','lr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(128,'Libya','ly',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(129,'Liechtenstein','li',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(130,'Lithuania','lt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(131,'Luxembourg','lu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(132,'Macao','mo',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(133,'Madagascar','mg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(134,'Malawi','mw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(135,'Malaysia','my',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(136,'Maldives','mv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(137,'Mali','ml',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(138,'Malta','mt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(139,'Marshall Islands','mh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(140,'Martinique','mq',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(141,'Mauritania','mr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(142,'Mauritius','mu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(143,'Mayotte','yt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(144,'Mexico','mx',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(145,'Micronesia (Federated States of)','fm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(146,'Moldova, Republic of','md',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(147,'Monaco','mc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(148,'Mongolia','mn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(149,'Montenegro','me',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(150,'Montserrat','ms',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(151,'Morocco','ma',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(152,'Mozambique','mz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(153,'Myanmar','mm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(154,'Namibia','na',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(155,'Nauru','nr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(156,'Nepal','np',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(157,'Netherlands','nl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(158,'New Caledonia','nc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(159,'New Zealand','nz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(160,'Nicaragua','ni',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(161,'Niger','ne',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(162,'Nigeria','ng',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(163,'Niue','nu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(164,'Norfolk Island','nf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(165,'North Macedonia','mk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(166,'Northern Mariana Islands','mp',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(167,'Norway','no',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(168,'Oman','om',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(169,'Pakistan','pk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(170,'Palau','pw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(171,'Palestine, State of','ps',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(172,'Panama','pa',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(173,'Papua New Guinea','pg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(174,'Paraguay','py',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(175,'Peru','pe',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(176,'Philippines','ph',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(177,'Pitcairn','pn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(178,'Poland','pl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(179,'Portugal','pt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(180,'Puerto Rico','pr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(181,'Qatar','qa',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(182,'Réunion','re',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(183,'Romania','ro',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(184,'Russian Federation','ru',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(185,'Rwanda','rw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(186,'Saint Barthélemy','bl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(187,'Saint Helena, Ascension and Tristan da Cunha','sh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(188,'Saint Kitts and Nevis','kn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(189,'Saint Lucia','lc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(190,'Saint Martin (French part)','mf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(191,'Saint Pierre and Miquelon','pm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(192,'Saint Vincent and the Grenadines','vc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(193,'Samoa','ws',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(194,'San Marino','sm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(195,'Sao Tome and Principe','st',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(196,'Saudi Arabia','sa',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(197,'Senegal','sn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(198,'Serbia','rs',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(199,'Seychelles','sc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(200,'Sierra Leone','sl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(201,'Singapore','sg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(202,'Sint Maarten (Dutch part)','sx',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(203,'Slovakia','sk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(204,'Slovenia','si',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(205,'Solomon Islands','sb',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(206,'Somalia','so',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(207,'South Africa','za',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(208,'South Georgia and the South Sandwich Islands','gs',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(209,'South Sudan','ss',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(210,'Spain','es',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(211,'Sri Lanka','lk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(212,'Sudan','sd',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(213,'Suriname','sr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(214,'Svalbard and Jan Mayen','sj',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(215,'Sweden','se',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(216,'Switzerland','ch',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(217,'Syrian Arab Republic','sy',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(218,'Taiwan, Province of China','tw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(219,'Tajikistan','tj',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(220,'Tanzania, United Republic of','tz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(221,'Thailand','th',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(222,'Timor-Leste','tl',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(223,'Togo','tg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(224,'Tokelau','tk',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(225,'Tonga','to',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(226,'Trinidad and Tobago','tt',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(227,'Tunisia','tn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(228,'Turkey','tr',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(229,'Turkmenistan','tm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(230,'Turks and Caicos Islands','tc',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(231,'Tuvalu','tv',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(232,'Uganda','ug',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(233,'Ukraine','ua',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(234,'United Arab Emirates','ae',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(235,'United Kingdom of Great Britain and Northern Ireland','gb',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(236,'United States of America','us',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(237,'United States Minor Outlying Islands','um',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(238,'Uruguay','uy',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(239,'Uzbekistan','uz',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(240,'Vanuatu','vu',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(241,'Venezuela (Bolivarian Republic of)','ve',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(242,'Viet Nam','vn',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(243,'Virgin Islands (British)','vg',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(244,'Virgin Islands (U.S.)','vi',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(245,'Wallis and Futuna','wf',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(246,'Western Sahara','eh',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(247,'Yemen','ye',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(248,'Zambia','zm',1,'2022-09-08 08:42:13','2022-09-08 08:42:13'),(249,'Zimbabwe','zw',1,'2022-09-08 08:42:13','2022-09-08 08:42:13');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floors`
--

DROP TABLE IF EXISTS `floors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `floors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `floors_place_id_name_unique` (`place_id`,`name`),
  UNIQUE KEY `floors_name_unique` (`place_id`,`name`),
  CONSTRAINT `floors_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floors`
--

LOCK TABLES `floors` WRITE;
/*!40000 ALTER TABLE `floors` DISABLE KEYS */;
/*!40000 ALTER TABLE `floors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_name_unique` (`name`),
  UNIQUE KEY `languages_code_unique` (`code`),
  KEY `languages_country_id_foreign` (`country_id`),
  CONSTRAINT `languages_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'Master','master',236,2,'2022-09-08 08:42:13','2022-09-08 08:42:13');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_03_27_184007_create_roles_table',1),(4,'2018_03_27_184207_create_role_user_table',1),(5,'2018_05_13_105030_add_status_column_in_users_table',1),(6,'2018_08_11_101437_create_salt_column_in_users_table',1),(7,'2019_02_11_045412_create_categories_table',1),(8,'2019_10_24_080706_create_parkings_table',1),(9,'2019_10_24_140234_create_tariffs_table',1),(10,'2019_10_31_181407_add_limit_on_category_table',1),(11,'2022_01_06_144511_create_settings_table',1),(12,'2022_01_17_111714_create_floors_table',1),(13,'2022_01_17_122657_create_category_wise_floor_slots_table',1),(14,'2022_01_19_144319_add_slot_id_in_parkings_table',1),(15,'2022_01_19_145300_add_order_id_to_floors_table',1),(16,'2022_01_30_124535_change_myisam_to_innobd__all_tables',1),(17,'2022_02_22_162827_create_places_table',1),(18,'2022_03_15_151241_create_languages_table',1),(19,'2022_03_15_151620_add_translation_column_in_general_settings_table',1),(20,'2022_03_15_152811_add_place_and_language_column_in_users_table',1),(21,'2022_06_26_143802_create_countries_table',1),(22,'2022_06_26_145107_add_colomn_country_id_on_languages_table',1),(23,'2022_07_25_110634_add_place_id_in_floors_table',1),(24,'2022_07_25_111412_add_place_id_in_tariffs_table',1),(25,'2022_07_25_111948_add_place_id_in_parkings_table',1),(26,'2022_07_25_161319_add_place_id_in_category_wise_floor_slots_table',1),(27,'2022_07_27_101210_change_unique_key_in_category_wise_floor_slots_table',1),(28,'2022_07_27_101307_change_unique_key_in_floors_table',1),(29,'2022_09_05_182108_create_rfid_vehicles_table',1),(30,'2022_09_06_183028_change_parkings_table_add_rfid_no',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parkings`
--

DROP TABLE IF EXISTS `parkings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parkings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `slot_id` bigint(20) unsigned DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfid_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parkings_barcode_unique` (`barcode`),
  KEY `parkings_category_id_foreign` (`category_id`),
  KEY `parkings_created_by_foreign` (`created_by`),
  KEY `parkings_modified_by_foreign` (`modified_by`),
  KEY `parkings_slot_id_foreign` (`slot_id`),
  KEY `parkings_place_id_foreign` (`place_id`),
  CONSTRAINT `parkings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parkings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parkings_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parkings_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  CONSTRAINT `parkings_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `category_wise_floor_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parkings`
--

LOCK TABLES `parkings` WRITE;
/*!40000 ALTER TABLE `parkings` DISABLE KEYS */;
/*!40000 ALTER TABLE `parkings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `places` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `places_name_unique` (`name`),
  KEY `places_created_by_foreign` (`created_by`),
  KEY `places_modified_by_foreign` (`modified_by`),
  CONSTRAINT `places_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `places_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `places`
--

LOCK TABLES `places` WRITE;
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` VALUES (1,'Default Place',NULL,1,1,NULL,'2022-09-08 08:42:13','2022-09-08 08:42:13');
/*!40000 ALTER TABLE `places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rfid_vehicles`
--

DROP TABLE IF EXISTS `rfid_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rfid_vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `vehicle_no` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfid_no` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rfid_vehicles_category_id_vehicle_no_unique` (`category_id`,`vehicle_no`),
  UNIQUE KEY `rfid_vehicles_category_id_rfid_no_unique` (`category_id`,`rfid_no`),
  KEY `rfid_vehicles_created_by_foreign` (`created_by`),
  KEY `rfid_vehicles_modified_by_foreign` (`modified_by`),
  CONSTRAINT `rfid_vehicles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rfid_vehicles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rfid_vehicles_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rfid_vehicles`
--

LOCK TABLES `rfid_vehicles` WRITE;
/*!40000 ALTER TABLE `rfid_vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `rfid_vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Admin User','2022-09-08 08:42:11','2022-09-08 08:42:11'),(2,'operator','Operator','2022-09-08 08:42:11','2022-09-08 08:42:11');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'img/logo.png','Demo Site','img/favicon.ico','img/login-bg.jpg','','2022-09-08 08:42:12','2022-09-08 08:42:12');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tariffs`
--

DROP TABLE IF EXISTS `tariffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tariffs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `place_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_amount` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned NOT NULL,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tariffs_category_id_foreign` (`category_id`),
  KEY `tariffs_created_by_foreign` (`created_by`),
  KEY `tariffs_modified_by_foreign` (`modified_by`),
  KEY `tariffs_place_id_foreign` (`place_id`),
  CONSTRAINT `tariffs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tariffs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tariffs_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tariffs_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tariffs`
--

LOCK TABLES `tariffs` WRITE;
/*!40000 ALTER TABLE `tariffs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tariffs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_id` bigint(20) unsigned DEFAULT NULL,
  `language_id` bigint(20) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_place_id_foreign` (`place_id`),
  KEY `users_language_id_foreign` (`language_id`),
  CONSTRAINT `users_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  CONSTRAINT `users_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Name','admin@gmail.com',NULL,1,NULL,'$2y$10$DA3yDZ36Z1CBKpWrmYZPqeMwm54MQ6lMIvphy.F1xIKoYIaV3mLTe',NULL,1,NULL,'2022-09-08 08:42:11','2022-09-08 08:42:13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'parking_new'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-08 14:43:24
