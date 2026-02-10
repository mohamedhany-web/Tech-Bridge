-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.2    Database: techbridge
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_subjects`
--

DROP TABLE IF EXISTS `academic_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `academic_year_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `academic_subjects_code_unique` (`code`),
  KEY `academic_subjects_academic_year_id_is_active_order_index` (`academic_year_id`,`is_active`,`order`),
  CONSTRAINT `academic_subjects_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_subjects`
--

LOCK TABLES `academic_subjects` WRITE;
/*!40000 ALTER TABLE `academic_subjects` DISABLE KEYS */;
INSERT INTO `academic_subjects` VALUES (3,1,'تطوير الويب','WEB101',NULL,'fa-globe','#8B5CF6',3,1,'2025-11-01 23:31:15','2025-11-01 23:31:15'),(4,2,'البرمجة المتقدمة','PROG201',NULL,'fa-code','#EF4444',1,1,'2025-11-01 23:31:15','2025-11-01 23:31:15'),(5,2,'تطوير التطبيقات','APP201',NULL,'fa-mobile-alt','#06B6D4',2,1,'2025-11-01 23:31:15','2025-11-01 23:31:15');
/*!40000 ALTER TABLE `academic_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `academic_years`
--

DROP TABLE IF EXISTS `academic_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_years` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `academic_years_code_unique` (`code`),
  KEY `academic_years_is_active_order_index` (`is_active`,`order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_years`
--

LOCK TABLES `academic_years` WRITE;
/*!40000 ALTER TABLE `academic_years` DISABLE KEYS */;
INSERT INTO `academic_years` VALUES (1,'Frontend','G10','html - css','fas fa-calendar-alt','#acf73b',1,1,'2025-11-01 23:31:15','2025-11-17 17:09:14'),(2,'الصف الثاني الثانوي','G11','السنة الثانية من المرحلة الثانوية','fa-graduation-cap','#10B981',2,1,'2025-11-01 23:31:15','2025-11-12 12:17:48');
/*!40000 ALTER TABLE `academic_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `type` enum('course_completion','exam_score','streak','points','custom') NOT NULL DEFAULT 'custom',
  `requirements` text,
  `points_reward` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `achievements_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `old_values` text,
  `new_values` text,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` text,
  `url` text,
  `method` varchar(255) DEFAULT NULL,
  `response_code` int DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (86,1,'data_created',NULL,NULL,NULL,'{\"delete_type\":\"filtered\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:10:24','2025-11-23 23:10:24','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/activity-log/clear','POST',200,NULL,NULL),(87,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:10:32','2025-11-23 23:10:32','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/invoices','GET',200,NULL,NULL),(88,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:13:42','2025-11-23 23:13:42','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/invoices','GET',200,NULL,NULL),(89,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:14:52','2025-11-23 23:14:52','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/invoices?status=pending','GET',200,NULL,NULL),(90,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:14:56','2025-11-23 23:14:56','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments','GET',200,NULL,NULL),(91,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:14:58','2025-11-23 23:14:58','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/invoices','GET',200,NULL,NULL),(92,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:19:08','2025-11-23 23:19:08','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(93,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:20:07','2025-11-23 23:20:07','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/performance','GET',200,NULL,NULL),(94,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:20:40','2025-11-23 23:20:40','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments','GET',200,NULL,NULL),(95,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:20:43','2025-11-23 23:20:43','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(96,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:21:02','2025-11-23 23:21:02','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(97,1,'page_visited',NULL,17,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:21:06','2025-11-23 23:21:06','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/17','GET',200,NULL,NULL),(98,1,'page_visited',NULL,17,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:21','2025-11-23 23:22:21','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/17','GET',200,NULL,NULL),(99,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:27','2025-11-23 23:22:27','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(100,1,'page_visited',NULL,17,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:29','2025-11-23 23:22:29','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/17','GET',200,NULL,NULL),(101,1,'page_visited',NULL,17,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:31','2025-11-23 23:22:31','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/17/edit','GET',200,NULL,NULL),(102,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:34','2025-11-23 23:22:34','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(103,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:22:37','2025-11-23 23:22:37','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments','GET',200,NULL,NULL),(104,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:25:34','2025-11-23 23:25:34','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments','GET',200,NULL,NULL),(105,1,'page_visited',NULL,7,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:25:41','2025-11-23 23:25:41','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments/7','GET',200,NULL,NULL),(106,1,'page_visited',NULL,7,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:25:46','2025-11-23 23:25:46','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/invoices/7','GET',200,NULL,NULL),(107,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:26:01','2025-11-23 23:26:01','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/wallets','GET',200,NULL,NULL),(108,5,'data_created',NULL,NULL,NULL,'{\"phone\":\"01203679764\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-23 23:26:19','2025-11-23 23:26:19','إنشاء بيانات','http://127.0.0.1:8000/login','POST',302,NULL,NULL),(109,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-23 23:26:23','2025-11-23 23:26:23','[لوحة الطالب] زيارة صفحة','http://127.0.0.1:8000/student/wallet','GET',200,NULL,NULL),(110,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-23 23:26:33','2025-11-23 23:26:33','[لوحة الطالب] زيارة صفحة','http://127.0.0.1:8000/student/certificates','GET',200,NULL,NULL),(111,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-23 23:26:35','2025-11-23 23:26:35','زيارة صفحة','http://127.0.0.1:8000/exams','GET',200,NULL,NULL),(112,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-23 23:26:37','2025-11-23 23:26:37','زيارة صفحة','http://127.0.0.1:8000/my-courses','GET',200,NULL,NULL),(113,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:26:46','2025-11-23 23:26:46','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/expenses','GET',200,NULL,NULL),(114,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:27:35','2025-11-23 23:27:35','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/reviews','GET',200,NULL,NULL),(115,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:27:40','2025-11-23 23:27:40','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/badges','GET',200,NULL,NULL),(116,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:27:42','2025-11-23 23:27:42','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/badges/create','GET',200,NULL,NULL),(117,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-23 23:27:49','2025-11-23 23:27:49','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/badges','GET',200,NULL,NULL),(118,1,'data_created',NULL,NULL,NULL,'{\"phone\":\"0500000000\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 19:56:21','2025-11-24 19:56:21','إنشاء بيانات','http://127.0.0.1:8000/login','POST',302,NULL,NULL),(119,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:25:06','2025-11-24 20:25:06','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/wallets','GET',200,NULL,NULL),(120,1,'page_visited',NULL,1,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:25:17','2025-11-24 20:25:17','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/wallets/1','GET',200,NULL,NULL),(121,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:25:26','2025-11-24 20:25:26','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(122,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:25:28','2025-11-24 20:25:28','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/create','GET',200,NULL,NULL),(123,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:26:04','2025-11-24 20:26:04','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/plans','GET',200,NULL,NULL),(124,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:26:08','2025-11-24 20:26:08','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements','GET',200,NULL,NULL),(125,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:26:17','2025-11-24 20:26:17','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',500,NULL,NULL),(126,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:27:23','2025-11-24 20:27:23','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',500,NULL,NULL),(127,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:28:03','2025-11-24 20:28:03','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(128,1,'data_created',NULL,6,NULL,'{\"status\":\"pending\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:28:17','2025-11-24 20:28:17','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/6/mark','POST',302,NULL,NULL),(129,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:28:17','2025-11-24 20:28:17','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(130,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:29:56','2025-11-24 20:29:56','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(131,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:30:47','2025-11-24 20:30:47','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(132,1,'data_created',NULL,6,NULL,'{\"status\":\"pending\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:30:50','2025-11-24 20:30:50','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/6/mark','POST',302,NULL,NULL),(133,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:30:50','2025-11-24 20:30:50','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(134,1,'data_created',NULL,6,NULL,'{\"status\":\"paid\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:30:56','2025-11-24 20:30:56','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/6/mark','POST',302,NULL,NULL),(135,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:30:56','2025-11-24 20:30:56','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(136,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:32:15','2025-11-24 20:32:15','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(137,1,'data_created',NULL,6,NULL,'{\"status\":\"paid\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:32:18','2025-11-24 20:32:18','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/6/mark','POST',302,NULL,NULL),(138,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:32:18','2025-11-24 20:32:18','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(139,1,'data_created',NULL,7,NULL,'{\"status\":\"paid\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:32:30','2025-11-24 20:32:30','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/7/mark','POST',302,NULL,NULL),(140,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:32:30','2025-11-24 20:32:30','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(141,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:03','2025-11-24 20:33:03','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(142,1,'data_created',NULL,7,NULL,'{\"status\":\"paid\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:05','2025-11-24 20:33:05','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/installments/payments/7/mark','POST',302,NULL,NULL),(143,1,'page_visited',NULL,2,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:05','2025-11-24 20:33:05','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements/2','GET',200,NULL,NULL),(144,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:11','2025-11-24 20:33:11','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/installments/agreements','GET',200,NULL,NULL),(145,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:25','2025-11-24 20:33:25','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions','GET',200,NULL,NULL),(146,1,'page_visited',NULL,18,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:29','2025-11-24 20:33:29','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/transactions/18','GET',200,NULL,NULL),(147,1,'page_visited',NULL,8,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:34','2025-11-24 20:33:34','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments/8','GET',200,NULL,NULL),(148,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:33:39','2025-11-24 20:33:39','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/payments','GET',200,NULL,NULL),(149,5,'data_created',NULL,NULL,NULL,'{\"phone\":\"01203679764\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:34:00','2025-11-24 20:34:00','إنشاء بيانات','http://127.0.0.1:8000/login','POST',302,NULL,NULL),(150,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:34:07','2025-11-24 20:34:07','زيارة صفحة','http://127.0.0.1:8000/referrals','GET',500,NULL,NULL),(151,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:35:28','2025-11-24 20:35:28','زيارة صفحة','http://127.0.0.1:8000/referrals','GET',200,NULL,NULL),(152,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:35:42','2025-11-24 20:35:42','[لوحة الطالب] زيارة صفحة','http://127.0.0.1:8000/student/invoices','GET',200,NULL,NULL),(153,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:35:43','2025-11-24 20:35:43','[لوحة الطالب] زيارة صفحة','http://127.0.0.1:8000/student/wallet','GET',200,NULL,NULL),(154,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:35:44','2025-11-24 20:35:44','[لوحة الطالب] زيارة صفحة','http://127.0.0.1:8000/student/certificates','GET',200,NULL,NULL),(155,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:35:46','2025-11-24 20:35:46','زيارة صفحة','http://127.0.0.1:8000/exams','GET',200,NULL,NULL),(156,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:36:00','2025-11-24 20:36:00','زيارة صفحة','http://127.0.0.1:8000/orders','GET',200,NULL,NULL),(157,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:17','2025-11-24 20:36:17','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(158,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:22','2025-11-24 20:36:22','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages/create','GET',200,NULL,NULL),(159,1,'data_created',NULL,NULL,NULL,'{\"recipient_type\":\"single\",\"user_id\":\"5\",\"course_id\":null,\"template_id\":null,\"message\":\"\\u0627\\u0644\\u0627\\u0644\\u0627\\u0644\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:30','2025-11-24 20:36:30','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/messages/send-single','POST',302,NULL,NULL),(160,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:30','2025-11-24 20:36:30','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages/create','GET',200,NULL,NULL),(161,1,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:56','2025-11-24 20:36:56','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/user-permissions','GET',200,NULL,NULL),(162,1,'page_visited',NULL,5,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:36:59','2025-11-24 20:36:59','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/user-permissions/5','GET',200,NULL,NULL),(163,1,'data_created',NULL,5,NULL,'{\"permission_id\":37}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:37:08','2025-11-24 20:37:08','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/user-permissions/5/attach','POST',200,NULL,NULL),(164,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:37:14','2025-11-24 20:37:14','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(165,1,'data_created',NULL,5,NULL,'{\"permission_id\":37}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:37:22','2025-11-24 20:37:22','[لوحة الإدارة] إنشاء بيانات','http://127.0.0.1:8000/admin/user-permissions/5/detach','POST',200,NULL,NULL),(166,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:37:26','2025-11-24 20:37:26','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(167,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:37:33','2025-11-24 20:37:33','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(168,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:38:00','2025-11-24 20:38:00','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(169,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:38:11','2025-11-24 20:38:11','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(170,1,'data_updated',NULL,5,NULL,'{\"permissions\":[\"56\",\"53\",\"55\",\"51\",\"48\",\"49\",\"47\",\"50\"]}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:39:13','2025-11-24 20:39:13','[لوحة الإدارة] تحديث بيانات','http://127.0.0.1:8000/admin/user-permissions/5','PUT',302,NULL,NULL),(171,1,'page_visited',NULL,5,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-11-24 20:39:13','2025-11-24 20:39:13','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/user-permissions/5','GET',200,NULL,NULL),(172,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:39:17','2025-11-24 20:39:17','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',200,NULL,NULL),(173,5,'page_visited',NULL,NULL,NULL,NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:39:53','2025-11-24 20:39:53','[لوحة الإدارة] زيارة صفحة','http://127.0.0.1:8000/admin/messages','GET',302,NULL,NULL),(174,5,'data_created',NULL,NULL,NULL,'{\"phone\":\"01203679764\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:43:05','2025-11-24 20:43:05','إنشاء بيانات','http://127.0.0.1:8000/login','POST',302,NULL,NULL),(175,5,'data_created',NULL,NULL,NULL,'{\"phone\":\"01203679764\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','2025-11-24 20:44:12','2025-11-24 20:44:12','إنشاء بيانات','http://127.0.0.1:8000/login','POST',302,NULL,NULL);
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advanced_courses`
--

DROP TABLE IF EXISTS `advanced_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advanced_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint unsigned DEFAULT NULL,
  `academic_subject_id` bigint unsigned DEFAULT NULL,
  `instructor_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `programming_language` varchar(255) DEFAULT NULL,
  `framework` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT (_utf8mb3'ar'),
  `description` text,
  `objectives` text,
  `level` varchar(255) NOT NULL DEFAULT (_utf8mb3'beginner'),
  `duration_hours` int NOT NULL DEFAULT (_utf8mb3'0'),
  `duration_minutes` int NOT NULL DEFAULT (_utf8mb3'0'),
  `price` decimal(10,0) NOT NULL DEFAULT (_utf8mb3'0'),
  `students_count` int NOT NULL DEFAULT (_utf8mb3'0'),
  `rating` decimal(10,0) NOT NULL DEFAULT (_utf8mb3'0'),
  `reviews_count` int NOT NULL DEFAULT (_utf8mb3'0'),
  `thumbnail` varchar(255) DEFAULT NULL,
  `requirements` text,
  `prerequisites` text,
  `what_you_learn` text,
  `skills` text,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `is_featured` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advanced_courses_new_category_index` (`category`),
  KEY `advanced_courses_new_instructor_id_index` (`instructor_id`),
  KEY `advanced_courses_new_is_active_is_featured_index` (`is_active`,`is_featured`),
  KEY `advanced_courses_new_programming_language_index` (`programming_language`),
  CONSTRAINT `advanced_courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advanced_courses`
--

LOCK TABLES `advanced_courses` WRITE;
/*!40000 ALTER TABLE `advanced_courses` DISABLE KEYS */;
INSERT INTO `advanced_courses` VALUES (1,NULL,NULL,1,'مقدمة في البرمجة - JavaScript','JavaScript',NULL,NULL,'ar','كورس شامل لتعلم أساسيات JavaScript من الصفر. ستعلم كيفية كتابة الأكواد البرمجية، استخدام المتغيرات والدوال، والعمل مع DOM.','فهم أساسيات JavaScript، كتابة الكود البرمجي، التعامل مع DOM','beginner',30,0,299,0,0,0,NULL,'لا توجد متطلبات مسبقة',NULL,'تعلم JavaScript من الصفر، كتابة الكود البرمجي، بناء مشاريع عملية',NULL,NULL,NULL,1,1,0,'2025-11-20 18:48:51','2025-11-20 18:48:51'),(2,NULL,NULL,1,'Python للمبتدئين','Python',NULL,NULL,'ar','ابدأ رحلتك في تعلم Python مع هذا الكورس الشامل. تعلم أساسيات اللغة البرمجية الأكثر شعبية في العالم.','تعلم Python من الصفر، فهم البرمجة الكائنية، بناء مشاريع عملية','beginner',40,0,349,0,0,0,NULL,'لا توجد متطلبات مسبقة',NULL,'Python basics، Data structures، Functions، OOP',NULL,NULL,NULL,1,1,0,'2025-11-20 18:49:21','2025-11-20 18:49:21'),(3,1,3,6,'تطوير الويب الكامل - Full Stack','JavaScript',NULL,'Web Development','ar','كورس شامل لتعلم تطوير الويب من الصفر إلى الاحتراف. HTML, CSS, JavaScript, React, Node.js وغيرها.','بناء مواقع ويب كاملة، تعلم Frontend و Backend، نشر المشاريع','intermediate',80,0,599,0,0,0,NULL,'معرفة أساسية بالبرمجة',NULL,'HTML/CSS، JavaScript، React، Node.js، Databases',NULL,NULL,NULL,1,1,0,'2025-11-20 18:49:31','2025-11-20 21:41:09'),(4,1,3,6,'React المتقدم','JavaScript','React',NULL,'ar','تعلم React بشكل متقدم مع Hooks، State Management، وبناء تطبيقات معقدة.','إتقان React، استخدام Hooks، State Management، بناء تطبيقات واقعية','advanced',50,0,449,0,0,0,NULL,'معرفة JavaScript و React أساسيات',NULL,'React Hooks، Redux، Context API، Performance Optimization',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 21:11:46'),(5,NULL,NULL,1,'Node.js و Express.js','JavaScript','Express.js',NULL,'ar','تعلم بناء واجهات برمجية (APIs) وخدمات خلفية باستخدام Node.js و Express.js.','بناء REST APIs، فهم Backend Development، التعامل مع Databases','intermediate',45,0,399,0,0,0,NULL,'معرفة JavaScript',NULL,'Node.js، Express.js، REST APIs، MongoDB، Authentication',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(6,NULL,NULL,1,'HTML & CSS للمبتدئين',NULL,NULL,'Web Development','ar','كورس شامل لتعلم HTML و CSS من الصفر. بناء صفحات ويب جميلة ومتجاوبة.','تعلم HTML و CSS، بناء صفحات ويب، Responsive Design','beginner',25,0,199,0,0,0,NULL,'لا توجد متطلبات مسبقة',NULL,'HTML Tags، CSS Styling، Flexbox، Grid، Responsive Design',NULL,NULL,NULL,1,1,0,'2025-11-20 18:50:24','2025-11-21 10:44:23'),(7,NULL,NULL,1,'PHP و Laravel','PHP','Laravel',NULL,'ar','تعلم PHP و إطار عمل Laravel لبناء تطبيقات ويب قوية وآمنة.','تعلم PHP، فهم Laravel Framework، بناء تطبيقات كاملة','intermediate',60,0,499,0,0,0,NULL,'معرفة أساسية بالبرمجة',NULL,'PHP Basics، Laravel Framework، MVC Pattern، Database',NULL,NULL,NULL,1,1,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(8,NULL,NULL,1,'البرمجة الكائنية - OOP',NULL,NULL,'Programming Concepts','ar','فهم مفاهيم البرمجة الكائنية والتوجه للكائنات في البرمجة.','فهم OOP Concepts، Classes و Objects، Inheritance، Polymorphism','intermediate',35,0,299,0,0,0,NULL,'معرفة أساسية بأي لغة برمجية',NULL,'Classes، Objects، Inheritance، Encapsulation، Polymorphism',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(9,NULL,NULL,1,'قواعد البيانات - SQL',NULL,NULL,'Database','ar','تعلم قواعد البيانات وإدارة البيانات باستخدام SQL.','فهم قواعد البيانات، تعلم SQL، تصميم Databases','beginner',30,0,249,0,0,0,NULL,'لا توجد متطلبات مسبقة',NULL,'SQL Queries، Database Design، Normalization، Relationships',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(10,NULL,NULL,1,'Algorithms و Data Structures',NULL,NULL,'Computer Science','ar','تعلم الخوارزميات وهياكل البيانات لتحسين مهاراتك البرمجية.','فهم Algorithms، Data Structures، Problem Solving','advanced',70,0,649,0,0,0,NULL,'معرفة متقدمة بالبرمجة',NULL,'Algorithms، Data Structures، Complexity Analysis، Problem Solving',NULL,NULL,NULL,1,1,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(11,NULL,NULL,1,'Vue.js من الصفر','JavaScript','Vue.js',NULL,'ar','تعلم Vue.js لإطار عمل JavaScript الحديث لبناء واجهات مستخدم تفاعلية.','تعلم Vue.js، بناء Single Page Applications، State Management','intermediate',40,0,379,0,0,0,NULL,'معرفة JavaScript و HTML/CSS',NULL,'Vue.js Basics، Components، Vuex، Vue Router',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(12,NULL,NULL,1,'Flutter لتطوير التطبيقات','Dart','Flutter',NULL,'ar','تعلم Flutter لبناء تطبيقات موبايل متعددة المنصات باستخدام Dart.','بناء تطبيقات موبايل، تعلم Flutter Framework، نشر التطبيقات','intermediate',55,0,549,0,0,0,NULL,'معرفة أساسية بالبرمجة',NULL,'Flutter Basics، Widgets، State Management، App Publishing',NULL,NULL,NULL,1,1,0,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(13,NULL,NULL,1,'Git و GitHub',NULL,NULL,'Tools','ar','تعلم إدارة المشاريع البرمجية باستخدام Git و GitHub.','فهم Git، استخدام GitHub، إدارة المشاريع، Collaboration','beginner',20,0,0,0,0,0,NULL,'لا توجد متطلبات مسبقة',NULL,'Git Commands، GitHub، Branching، Pull Requests، Collaboration',NULL,NULL,NULL,1,0,1,'2025-11-20 18:50:24','2025-11-20 18:50:24'),(14,NULL,NULL,1,'Docker و DevOps',NULL,NULL,'DevOps','ar','تعلم Docker و DevOps لتحسين عملية التطوير والنشر.','فهم Docker، CI/CD، DevOps Practices، Containerization','advanced',45,0,599,0,0,0,NULL,'معرفة بالبرمجة والنظم',NULL,'Docker، Kubernetes، CI/CD، DevOps Tools',NULL,NULL,NULL,1,0,0,'2025-11-20 18:50:24','2025-11-20 18:50:24');
/*!40000 ALTER TABLE `advanced_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advanced_notifications`
--

DROP TABLE IF EXISTS `advanced_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advanced_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `recipients` text NOT NULL,
  `is_broadcast` tinyint(1) NOT NULL DEFAULT '0',
  `scheduled_at` datetime DEFAULT NULL,
  `status` enum('draft','sent','scheduled') NOT NULL DEFAULT 'draft',
  `created_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `advanced_notifications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advanced_notifications`
--

LOCK TABLES `advanced_notifications` WRITE;
/*!40000 ALTER TABLE `advanced_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `advanced_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment_submission_versions`
--

DROP TABLE IF EXISTS `assignment_submission_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignment_submission_versions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int NOT NULL,
  `version` int NOT NULL,
  `content` text,
  `attachments` text,
  `github_link` varchar(255) DEFAULT NULL,
  `submitted_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assignment_submission_versions_submission_id_version_unique` (`submission_id`,`version`),
  KEY `assignment_submission_versions_submission_id_submitted_at_index` (`submission_id`,`submitted_at`),
  CONSTRAINT `assignment_submission_versions_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `assignment_submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment_submission_versions`
--

LOCK TABLES `assignment_submission_versions` WRITE;
/*!40000 ALTER TABLE `assignment_submission_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `assignment_submission_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment_submissions`
--

DROP TABLE IF EXISTS `assignment_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignment_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assignment_id` int NOT NULL,
  `student_id` int NOT NULL,
  `content` text,
  `attachments` text,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int DEFAULT NULL,
  `feedback` text,
  `graded_at` datetime DEFAULT NULL,
  `graded_by` int DEFAULT NULL,
  `status` enum('submitted','graded','returned') NOT NULL DEFAULT 'submitted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `version` int NOT NULL DEFAULT '1',
  `voice_feedback_path` varchar(255) DEFAULT NULL,
  `feedback_attachments` text,
  `code_test_results` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assignment_submissions_assignment_id_student_id_unique` (`assignment_id`,`student_id`),
  KEY `student_id` (`student_id`),
  KEY `graded_by` (`graded_by`),
  CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignment_submissions_ibfk_3` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment_submissions`
--

LOCK TABLES `assignment_submissions` WRITE;
/*!40000 ALTER TABLE `assignment_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `assignment_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `instructions` text,
  `course_id` int NOT NULL,
  `advanced_course_id` bigint unsigned DEFAULT NULL,
  `lesson_id` int DEFAULT NULL,
  `teacher_id` int NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `max_score` int NOT NULL DEFAULT '100',
  `allow_late_submission` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `github_link_support` tinyint(1) NOT NULL DEFAULT '1',
  `code_testing_api` varchar(255) DEFAULT NULL,
  `code_testing_config` text,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `assignments_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_records`
--

DROP TABLE IF EXISTS `attendance_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecture_id` int NOT NULL,
  `student_id` int NOT NULL,
  `joined_at` datetime DEFAULT NULL,
  `left_at` datetime DEFAULT NULL,
  `attendance_minutes` int NOT NULL DEFAULT '0',
  `total_minutes` int NOT NULL DEFAULT '0',
  `attendance_percentage` decimal(10,0) NOT NULL DEFAULT '0',
  `status` enum('present','late','absent','partial') NOT NULL DEFAULT 'absent',
  `source` varchar(255) NOT NULL DEFAULT 'manual',
  `teams_data` text,
  `teams_file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendance_records_lecture_id_student_id_unique` (`lecture_id`,`student_id`),
  KEY `attendance_records_lecture_id_status_index` (`lecture_id`,`status`),
  KEY `attendance_records_student_id_status_index` (`student_id`,`status`),
  CONSTRAINT `attendance_records_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_records_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_records`
--

LOCK TABLES `attendance_records` WRITE;
/*!40000 ALTER TABLE `attendance_records` DISABLE KEYS */;
INSERT INTO `attendance_records` VALUES (1,1,5,'2025-11-21 10:48:38',NULL,0,60,0,'present','manual',NULL,NULL,'2025-11-20 21:46:51','2025-11-21 10:48:38');
/*!40000 ALTER TABLE `attendance_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_statistics`
--

DROP TABLE IF EXISTS `attendance_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance_statistics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `total_lectures` int NOT NULL DEFAULT '0',
  `attended_lectures` int NOT NULL DEFAULT '0',
  `late_lectures` int NOT NULL DEFAULT '0',
  `absent_lectures` int NOT NULL DEFAULT '0',
  `attendance_rate` decimal(10,0) NOT NULL DEFAULT '0',
  `total_hours` int NOT NULL DEFAULT '0',
  `period_start` date DEFAULT NULL,
  `period_end` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendance_statistics_student_id_course_id_unique` (`student_id`,`course_id`),
  KEY `attendance_statistics_course_id_attendance_rate_index` (`course_id`,`attendance_rate`),
  CONSTRAINT `attendance_statistics_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_statistics_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_statistics`
--

LOCK TABLES `attendance_statistics` WRITE;
/*!40000 ALTER TABLE `attendance_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `type` enum('skill','milestone','special','seasonal') NOT NULL DEFAULT 'skill',
  `requirements` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `badges_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badges`
--

LOCK TABLES `badges` WRITE;
/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text,
  `content` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `images` text,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `views_count` int NOT NULL DEFAULT '0',
  `tags` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `author_id` (`author_id`),
  KEY `blog_posts_is_featured_index` (`is_featured`),
  KEY `blog_posts_slug_index` (`slug`),
  KEY `blog_posts_status_published_at_index` (`status`,`published_at`),
  CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,1,'ااااااااا','الصف الأول الثانوي','ااااااااااااااااا','ااااااااااااااااااا','images/blog/1762386336_690be1a08b718.png',NULL,'published',0,8,'[]','ىى','ىى','2025-11-05 23:09:23','2025-11-05 23:09:23','2025-11-14 01:00:37');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1764017199),('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1764017199;',1764017199),('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1764017111),('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1764017111;',1764017111),('laravel-cache-ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4','i:1;',1764017233),('laravel-cache-ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4:timer','i:1764017233;',1764017233);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_event_attendees`
--

DROP TABLE IF EXISTS `calendar_event_attendees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar_event_attendees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event_attendees`
--

LOCK TABLES `calendar_event_attendees` WRITE;
/*!40000 ALTER TABLE `calendar_event_attendees` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_event_attendees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendar_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_all_day` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('exam','lesson','assignment','meeting','holiday','deadline','review','personal','system') NOT NULL DEFAULT 'personal',
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `location` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_by` int NOT NULL,
  `visibility` enum('public','private','course','year','subject') NOT NULL DEFAULT 'private',
  `academic_year_id` int DEFAULT NULL,
  `academic_subject_id` int DEFAULT NULL,
  `advanced_course_id` int DEFAULT NULL,
  `has_reminder` tinyint(1) NOT NULL DEFAULT '0',
  `reminder_minutes` int DEFAULT NULL,
  `email_reminder` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('scheduled','completed','cancelled','postponed') NOT NULL DEFAULT 'scheduled',
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `recurrence_type` enum('daily','weekly','monthly','yearly') DEFAULT NULL,
  `recurrence_interval` int NOT NULL DEFAULT '1',
  `recurrence_end_date` date DEFAULT NULL,
  `has_grade` tinyint(1) NOT NULL DEFAULT '0',
  `max_grade` decimal(10,0) DEFAULT NULL,
  `grading_criteria` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `academic_subject_id` (`academic_subject_id`),
  KEY `advanced_course_id` (`advanced_course_id`),
  KEY `calendar_events_academic_year_id_academic_subject_id_index` (`academic_year_id`,`academic_subject_id`),
  KEY `calendar_events_created_by_type_index` (`created_by`,`type`),
  KEY `calendar_events_start_date_end_date_index` (`start_date`,`end_date`),
  KEY `calendar_events_visibility_status_index` (`visibility`,`status`),
  CONSTRAINT `calendar_events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calendar_events_ibfk_2` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calendar_events_ibfk_3` FOREIGN KEY (`academic_subject_id`) REFERENCES `academic_subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calendar_events_ibfk_4` FOREIGN KEY (`advanced_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_events`
--

LOCK TABLES `calendar_events` WRITE;
/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `certificate_type` enum('completion','achievement','participation','certification') NOT NULL DEFAULT 'completion',
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `user_id` int NOT NULL,
  `certificate_number` varchar(255) NOT NULL,
  `issued_at` datetime NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `metadata` text,
  `is_verified` tinyint(1) NOT NULL DEFAULT '1',
  `status` enum('pending','issued','revoked') NOT NULL DEFAULT 'pending',
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `data` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_number_unique` (`certificate_number`),
  UNIQUE KEY `certificates_verification_code_unique` (`verification_code`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classroom_students`
--

DROP TABLE IF EXISTS `classroom_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classroom_students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `classroom_id` int NOT NULL,
  `enrolled_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classroom_students_student_id_classroom_id_unique` (`student_id`,`classroom_id`),
  KEY `classroom_id` (`classroom_id`),
  CONSTRAINT `classroom_students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classroom_students_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classroom_students`
--

LOCK TABLES `classroom_students` WRITE;
/*!40000 ALTER TABLE `classroom_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `classroom_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classrooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `school_id` int NOT NULL,
  `teacher_id` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `classrooms_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classrooms_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classrooms`
--

LOCK TABLES `classrooms` WRITE;
/*!40000 ALTER TABLE `classrooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `classrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied','archived') NOT NULL DEFAULT 'new',
  `admin_notes` text,
  `replied_by` int DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `replied_by` (`replied_by`),
  KEY `contact_messages_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'mohamed hany','loransmogay@gmail.com','01203679764','اا','ااا','new',NULL,NULL,NULL,NULL,'2025-11-05 23:49:40','2025-11-05 23:49:40');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_usages`
--

DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_usages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_id` int NOT NULL,
  `user_id` int NOT NULL,
  `invoice_id` int DEFAULT NULL,
  `discount_amount` decimal(10,0) NOT NULL,
  `order_amount` decimal(10,0) NOT NULL,
  `final_amount` decimal(10,0) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `coupon_usages_coupon_id_user_id_index` (`coupon_id`,`user_id`),
  KEY `coupon_usages_invoice_id_index` (`invoice_id`),
  CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_usages`
--

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
INSERT INTO `coupon_usages` VALUES (1,1,5,NULL,55,549,494,'2025-11-22 01:57:49','2025-11-22 01:57:49');
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,0) NOT NULL,
  `minimum_amount` decimal(10,0) DEFAULT NULL,
  `maximum_discount` decimal(10,0) DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `usage_limit_per_user` int NOT NULL DEFAULT '1',
  `used_count` int NOT NULL DEFAULT '0',
  `starts_at` date DEFAULT NULL,
  `expires_at` date DEFAULT NULL,
  `applicable_to` enum('all','courses','subscriptions','specific') NOT NULL DEFAULT 'all',
  `applicable_course_ids` text,
  `applicable_user_ids` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`),
  KEY `coupons_code_is_active_index` (`code`,`is_active`),
  KEY `coupons_is_active_index` (`is_active`),
  KEY `coupons_starts_at_expires_at_index` (`starts_at`,`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'187802',']ldh\'',']ldh\'',NULL,'percentage',10,300,NULL,1,1,1,'2025-11-22','2025-11-29','all',NULL,NULL,1,1,'2025-11-22 00:24:15','2025-11-22 01:57:49');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_enrollments`
--

DROP TABLE IF EXISTS `course_enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_enrollments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `enrolled_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` datetime DEFAULT NULL,
  `progress_percentage` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `advanced_course_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_enrollments_student_id_course_id_unique` (`student_id`,`course_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_enrollments`
--

LOCK TABLES `course_enrollments` WRITE;
/*!40000 ALTER TABLE `course_enrollments` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lessons`
--

DROP TABLE IF EXISTS `course_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `advanced_course_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT (_utf8mb3'video'),
  `content` text,
  `video_url` varchar(255) DEFAULT NULL,
  `attachments` text,
  `duration_minutes` int DEFAULT '0',
  `order` int NOT NULL DEFAULT (_utf8mb3'0'),
  `is_free` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `is_active` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_lessons_advanced_course_id_is_active_index` (`advanced_course_id`,`is_active`),
  KEY `course_lessons_advanced_course_id_order_index` (`advanced_course_id`,`order`),
  CONSTRAINT `course_lessons_ibfk_1` FOREIGN KEY (`advanced_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lessons`
--

LOCK TABLES `course_lessons` WRITE;
/*!40000 ALTER TABLE `course_lessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_reviews`
--

DROP TABLE IF EXISTS `course_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `review` text,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_reviews_course_id_user_id_unique` (`course_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `course_reviews_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_reviews`
--

LOCK TABLES `course_reviews` WRITE;
/*!40000 ALTER TABLE `course_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `content` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `subject_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `classroom_id` int DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `duration_minutes` int DEFAULT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `classroom_id` (`classroom_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_activity_logs`
--

DROP TABLE IF EXISTS `exam_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `attempt_id` int NOT NULL,
  `student_id` int NOT NULL,
  `activity_type` enum('focus','blur','visibility_change','mouse_move','keyboard','copy','paste','cut') NOT NULL DEFAULT 'focus',
  `description` text,
  `metadata` text,
  `activity_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attempt_id` (`attempt_id`),
  KEY `exam_activity_logs_exam_id_attempt_id_activity_type_index` (`exam_id`,`attempt_id`,`activity_type`),
  KEY `exam_activity_logs_student_id_activity_at_index` (`student_id`,`activity_at`),
  CONSTRAINT `exam_activity_logs_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_activity_logs_ibfk_2` FOREIGN KEY (`attempt_id`) REFERENCES `exam_attempts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_activity_logs_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_activity_logs`
--

LOCK TABLES `exam_activity_logs` WRITE;
/*!40000 ALTER TABLE `exam_activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_anti_cheat_logs`
--

DROP TABLE IF EXISTS `exam_anti_cheat_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_anti_cheat_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `attempt_id` int NOT NULL,
  `student_id` int NOT NULL,
  `violation_type` enum('tab_switch','copy_paste','right_click','fullscreen_exit','window_blur','other') NOT NULL DEFAULT 'other',
  `description` text,
  `metadata` text,
  `violation_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attempt_id` (`attempt_id`),
  KEY `exam_anti_cheat_logs_exam_id_attempt_id_index` (`exam_id`,`attempt_id`),
  KEY `exam_anti_cheat_logs_student_id_violation_type_index` (`student_id`,`violation_type`),
  CONSTRAINT `exam_anti_cheat_logs_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_anti_cheat_logs_ibfk_2` FOREIGN KEY (`attempt_id`) REFERENCES `exam_attempts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_anti_cheat_logs_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_anti_cheat_logs`
--

LOCK TABLES `exam_anti_cheat_logs` WRITE;
/*!40000 ALTER TABLE `exam_anti_cheat_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_anti_cheat_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_attempts`
--

DROP TABLE IF EXISTS `exam_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `user_id` int NOT NULL,
  `started_at` datetime NOT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `score` int DEFAULT NULL,
  `answers` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT (_utf8mb3'in_progress'),
  `time_taken` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `tab_switches` int NOT NULL DEFAULT (_utf8mb3'0'),
  `suspicious_activities` text,
  `percentage` decimal(10,0) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `auto_submitted` tinyint(1) NOT NULL DEFAULT '0',
  `reviewed_by` int DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `feedback` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `exam_id` (`exam_id`),
  KEY `reviewed_by` (`reviewed_by`),
  CONSTRAINT `exam_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_attempts_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_attempts_ibfk_3` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_attempts`
--

LOCK TABLES `exam_attempts` WRITE;
/*!40000 ALTER TABLE `exam_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_questions`
--

DROP TABLE IF EXISTS `exam_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `question_id` int NOT NULL,
  `order` int NOT NULL,
  `marks` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `time_limit` int DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_questions_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_questions`
--

LOCK TABLES `exam_questions` WRITE;
/*!40000 ALTER TABLE `exam_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_tab_switch_logs`
--

DROP TABLE IF EXISTS `exam_tab_switch_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_tab_switch_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `attempt_id` int NOT NULL,
  `student_id` int NOT NULL,
  `switch_count` int NOT NULL DEFAULT '0',
  `first_switch_at` datetime DEFAULT NULL,
  `last_switch_at` datetime DEFAULT NULL,
  `switch_details` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_tab_switch_logs_exam_id_attempt_id_unique` (`exam_id`,`attempt_id`),
  KEY `attempt_id` (`attempt_id`),
  KEY `exam_tab_switch_logs_student_id_switch_count_index` (`student_id`,`switch_count`),
  CONSTRAINT `exam_tab_switch_logs_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_tab_switch_logs_ibfk_2` FOREIGN KEY (`attempt_id`) REFERENCES `exam_attempts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_tab_switch_logs_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_tab_switch_logs`
--

LOCK TABLES `exam_tab_switch_logs` WRITE;
/*!40000 ALTER TABLE `exam_tab_switch_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_tab_switch_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `course_id` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `duration_minutes` int NOT NULL,
  `total_marks` decimal(10,0) DEFAULT (_utf8mb3'0'),
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `attempts_allowed` int NOT NULL DEFAULT (_utf8mb3'1'),
  `shuffle_questions` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `show_results` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `status` varchar(255) NOT NULL DEFAULT (_utf8mb3'draft'),
  `settings` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `prevent_tab_switch` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `prevent_copy_paste` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `prevent_right_click` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `require_fullscreen` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `monitor_activity` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `passing_marks` decimal(10,0) NOT NULL DEFAULT (_utf8mb3'50'),
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `show_results_immediately` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `show_correct_answers` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `show_explanations` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `allow_review` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `randomize_questions` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `randomize_options` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `require_camera` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `require_microphone` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `auto_submit` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `is_published` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `instructions` text,
  `is_active` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `advanced_course_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advanced_course_id` (`advanced_course_id`),
  KEY `course_id` (`course_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`advanced_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `expense_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` enum('operational','marketing','salaries','utilities','equipment','maintenance','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EGP',
  `expense_date` date NOT NULL,
  `payment_method` enum('cash','bank_transfer','card','wallet','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `wallet_id` bigint unsigned DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint unsigned DEFAULT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_transaction_id_index` (`transaction_id`),
  KEY `expenses_invoice_id_index` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (7,'EXP-00000001','شراء معدات للقاعة','مصروف تجريبي لاختبار الترابط في نظام المحاسبة','operational',1466.00,'EGP','2025-10-25','bank_transfer',NULL,'REF-000001',NULL,'approved',1,'2025-11-09 15:37:36',NULL,NULL,'مصروف تجريبي',NULL,1,'2025-11-21 15:37:36','2025-11-21 15:37:36'),(8,'EXP-00000002','إعلانات على وسائل التواصل','مصروف تجريبي لاختبار الترابط في نظام المحاسبة','marketing',1550.00,'EGP','2025-11-13','bank_transfer',NULL,'REF-000002',NULL,'approved',1,'2025-11-01 15:37:36',NULL,NULL,'مصروف تجريبي',NULL,1,'2025-11-21 15:37:36','2025-11-21 15:37:36'),(9,'EXP-00000003','رواتب الموظفين','مصروف تجريبي لاختبار الترابط في نظام المحاسبة','salaries',271.00,'EGP','2025-10-28','cash',1,'REF-000003',NULL,'approved',1,'2025-11-18 15:37:36',NULL,NULL,'مصروف تجريبي',NULL,1,'2025-11-21 15:37:36','2025-11-21 15:37:36'),(10,'EXP-00000004','فاتورة الكهرباء','مصروف تجريبي لاختبار الترابط في نظام المحاسبة','utilities',977.00,'EGP','2025-11-15','bank_transfer',NULL,'REF-000004',NULL,'approved',1,'2025-11-19 15:37:36',NULL,NULL,'مصروف تجريبي',NULL,1,'2025-11-21 15:37:36','2025-11-21 15:37:36'),(11,'EXP-00000005','صيانة الأجهزة','مصروف تجريبي لاختبار الترابط في نظام المحاسبة','equipment',1037.00,'EGP','2025-11-12','card',NULL,'REF-000005',NULL,'approved',1,'2025-11-18 15:37:36',NULL,NULL,'مصروف تجريبي',NULL,1,'2025-11-21 15:37:36','2025-11-21 15:37:36');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` text NOT NULL,
  `exception` text NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views_count` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_category_index` (`category`),
  KEY `faqs_is_active_order_index` (`is_active`,`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `size` int NOT NULL,
  `uploaded_by` int NOT NULL,
  `fileable_type` varchar(255) NOT NULL,
  `fileable_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `files_fileable_type_fileable_id_index` (`fileable_type`,`fileable_id`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_members`
--

DROP TABLE IF EXISTS `group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` enum('leader','member') NOT NULL DEFAULT 'member',
  `joined_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_members_group_id_user_id_unique` (`group_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_members`
--

LOCK TABLES `group_members` WRITE;
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `leader_id` int DEFAULT NULL,
  `max_members` int NOT NULL DEFAULT '10',
  `status` enum('active','inactive','archived') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leader_id` (`leader_id`),
  KEY `groups_course_id_status_index` (`course_id`,`status`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`leader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installment_agreements`
--

DROP TABLE IF EXISTS `installment_agreements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `installment_agreements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `installment_plan_id` int NOT NULL,
  `student_course_enrollment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `advanced_course_id` int DEFAULT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `deposit_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `installments_count` int NOT NULL,
  `start_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `installment_plan_id` (`installment_plan_id`),
  KEY `student_course_enrollment_id` (`student_course_enrollment_id`),
  KEY `user_id` (`user_id`),
  KEY `advanced_course_id` (`advanced_course_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `installment_agreements_ibfk_1` FOREIGN KEY (`installment_plan_id`) REFERENCES `installment_plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `installment_agreements_ibfk_2` FOREIGN KEY (`student_course_enrollment_id`) REFERENCES `student_course_enrollments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `installment_agreements_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `installment_agreements_ibfk_4` FOREIGN KEY (`advanced_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `installment_agreements_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installment_agreements`
--

LOCK TABLES `installment_agreements` WRITE;
/*!40000 ALTER TABLE `installment_agreements` DISABLE KEYS */;
INSERT INTO `installment_agreements` VALUES (2,1,4,5,4,449,100,4,'2025-11-21','active','اتفاقية تقسيط تجريبية',1,'2025-11-21 17:37:36','2025-11-21 17:37:36');
/*!40000 ALTER TABLE `installment_agreements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installment_payments`
--

DROP TABLE IF EXISTS `installment_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `installment_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `installment_agreement_id` int NOT NULL,
  `sequence_number` int NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `payment_id` int DEFAULT NULL,
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `installment_payments_agreement_seq_unique` (`installment_agreement_id`,`sequence_number`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `installment_payments_ibfk_1` FOREIGN KEY (`installment_agreement_id`) REFERENCES `installment_agreements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `installment_payments_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installment_payments`
--

LOCK TABLES `installment_payments` WRITE;
/*!40000 ALTER TABLE `installment_payments` DISABLE KEYS */;
INSERT INTO `installment_payments` VALUES (6,2,0,'2025-11-21',100,'paid','2025-11-24 20:32:18',6,NULL,'2025-11-21 17:37:36','2025-11-24 20:32:18'),(7,2,1,'2025-12-21',87,'paid','2025-11-24 20:33:05',8,NULL,'2025-11-21 17:37:36','2025-11-24 20:33:05'),(8,2,2,'2026-01-21',87,'pending',NULL,NULL,NULL,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(9,2,3,'2026-02-21',87,'pending',NULL,NULL,NULL,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(10,2,4,'2026-03-21',87,'pending',NULL,NULL,NULL,'2025-11-21 17:37:36','2025-11-21 17:37:36');
/*!40000 ALTER TABLE `installment_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installment_plans`
--

DROP TABLE IF EXISTS `installment_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `installment_plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `advanced_course_id` int DEFAULT NULL,
  `total_amount` decimal(10,0) DEFAULT NULL,
  `deposit_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `installments_count` int NOT NULL,
  `frequency_unit` varchar(255) NOT NULL DEFAULT 'month',
  `frequency_interval` int NOT NULL DEFAULT '1',
  `grace_period_days` int NOT NULL DEFAULT '0',
  `auto_generate_on_enrollment` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `installment_plans_slug_unique` (`slug`),
  KEY `advanced_course_id` (`advanced_course_id`),
  CONSTRAINT `installment_plans_ibfk_1` FOREIGN KEY (`advanced_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installment_plans`
--

LOCK TABLES `installment_plans` WRITE;
/*!40000 ALTER TABLE `installment_plans` DISABLE KEYS */;
INSERT INTO `installment_plans` VALUES (1,'mohamed hany','mohamed-hany-isvu','لالالالالالالالالالالالالالالالالالالالا',NULL,1500,500,2,'month',1,0,1,1,NULL,'2025-11-13 14:40:32','2025-11-13 14:40:32');
/*!40000 ALTER TABLE `installment_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('course','subscription','membership','other') NOT NULL DEFAULT 'course',
  `description` varchar(255) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `tax_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `discount_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `total_amount` decimal(10,0) NOT NULL,
  `status` enum('draft','pending','paid','partial','overdue','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `notes` text,
  `items` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_due_date_index` (`due_date`),
  KEY `invoices_invoice_number_index` (`invoice_number`),
  KEY `invoices_user_id_status_index` (`user_id`,`status`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (5,'INV-00000001',5,'course','فاتورة شراء كورس: React المتقدم',449,0,0,449,'paid','2025-11-18','2025-11-11','فاتورة تلقائية من طلب رقم: 6','[{\"description\":\"React \\u0627\\u0644\\u0645\\u062a\\u0642\\u062f\\u0645\",\"quantity\":1,\"unit_price\":\"449.00\",\"total\":\"449.00\"}]','2025-11-21 17:37:36','2025-11-21 17:37:36'),(6,'INV-00000002',5,'course','فاتورة قسط تقسيط - قسط رقم: 0',100,0,0,100,'paid','2025-11-21','2025-11-16','فاتورة قسط تقسيط','[{\"description\":\"\\u0642\\u0633\\u0637 \\u062a\\u0642\\u0633\\u064a\\u0637 - \\u0642\\u0633\\u0637 \\u0631\\u0642\\u0645: 0\",\"quantity\":1,\"price\":\"100.00\",\"total\":\"100.00\"}]','2025-11-21 17:37:36','2025-11-21 17:37:36'),(7,'INV-00000003',5,'course','فاتورة تسجيل في الكورس: Flutter لتطوير التطبيقات',494,0,0,494,'paid','2025-11-22','2025-11-22','فاتورة مسبقة الدفع - من طلب رقم: 7','[{\"description\":\"\\u062a\\u0633\\u062c\\u064a\\u0644 \\u0641\\u064a \\u0627\\u0644\\u0643\\u0648\\u0631\\u0633: Flutter \\u0644\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a\",\"quantity\":1,\"price\":\"494.00\",\"total\":\"494.00\"}]','2025-11-22 01:58:18','2025-11-22 01:58:18');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` text NOT NULL,
  `options` text,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` text NOT NULL,
  `attempts` int NOT NULL,
  `reserved_at` int DEFAULT NULL,
  `available_at` int NOT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_assignment_submissions`
--

DROP TABLE IF EXISTS `lecture_assignment_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_assignment_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assignment_id` int NOT NULL,
  `student_id` int NOT NULL,
  `content` text,
  `attachments` text,
  `github_link` varchar(255) DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int DEFAULT NULL,
  `feedback` text,
  `voice_feedback_path` varchar(255) DEFAULT NULL,
  `feedback_attachments` text,
  `graded_at` datetime DEFAULT NULL,
  `graded_by` int DEFAULT NULL,
  `status` enum('submitted','graded','returned') NOT NULL DEFAULT 'submitted',
  `version` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_submission_version` (`assignment_id`,`student_id`,`version`),
  KEY `student_id` (`student_id`),
  KEY `graded_by` (`graded_by`),
  CONSTRAINT `lecture_assignment_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `lecture_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_assignment_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_assignment_submissions_ibfk_3` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_assignment_submissions`
--

LOCK TABLES `lecture_assignment_submissions` WRITE;
/*!40000 ALTER TABLE `lecture_assignment_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecture_assignment_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_assignments`
--

DROP TABLE IF EXISTS `lecture_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecture_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `instructions` text,
  `due_date` datetime DEFAULT NULL,
  `max_score` int NOT NULL DEFAULT '100',
  `allow_late_submission` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecture_id` (`lecture_id`),
  CONSTRAINT `lecture_assignments_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_assignments`
--

LOCK TABLES `lecture_assignments` WRITE;
/*!40000 ALTER TABLE `lecture_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecture_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_evaluations`
--

DROP TABLE IF EXISTS `lecture_evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_evaluations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecture_id` int NOT NULL,
  `student_id` int NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `feedback` text,
  `evaluation_data` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecture_evaluations_lecture_id_student_id_unique` (`lecture_id`,`student_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `lecture_evaluations_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_evaluations_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_evaluations`
--

LOCK TABLES `lecture_evaluations` WRITE;
/*!40000 ALTER TABLE `lecture_evaluations` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecture_evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lectures`
--

DROP TABLE IF EXISTS `lectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lectures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `course_lesson_id` bigint unsigned DEFAULT NULL,
  `instructor_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `teams_registration_link` varchar(255) DEFAULT NULL,
  `teams_meeting_link` varchar(255) DEFAULT NULL,
  `recording_url` varchar(255) DEFAULT NULL,
  `recording_file_path` varchar(255) DEFAULT NULL,
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int NOT NULL DEFAULT '60',
  `status` enum('scheduled','in_progress','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `notes` text,
  `has_attendance_tracking` tinyint(1) NOT NULL DEFAULT '1',
  `has_assignment` tinyint(1) NOT NULL DEFAULT '0',
  `has_evaluation` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lectures_course_id_scheduled_at_index` (`course_id`,`scheduled_at`),
  KEY `lectures_instructor_id_status_index` (`instructor_id`,`status`),
  CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lectures_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectures`
--

LOCK TABLES `lectures` WRITE;
/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;
INSERT INTO `lectures` VALUES (1,3,NULL,6,'test','g',NULL,NULL,NULL,NULL,'2025-11-21 23:43:00',60,'completed',NULL,1,1,1,'2025-11-20 21:44:07','2025-11-21 10:48:19');
/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `content` text,
  `video_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `course_id` int NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `duration_minutes` int DEFAULT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loyalty_programs`
--

DROP TABLE IF EXISTS `loyalty_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyalty_programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `type` enum('points','tier','referral','volume') NOT NULL DEFAULT 'points',
  `rules` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `starts_at` date DEFAULT NULL,
  `expires_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_programs`
--

LOCK TABLES `loyalty_programs` WRITE;
/*!40000 ALTER TABLE `loyalty_programs` DISABLE KEYS */;
/*!40000 ALTER TABLE `loyalty_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_galleries`
--

DROP TABLE IF EXISTS `media_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_galleries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` enum('image','video','document') NOT NULL DEFAULT 'image',
  `file_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `file_size` int NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `tags` text,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views_count` int NOT NULL DEFAULT '0',
  `uploaded_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `media_galleries_category_is_featured_index` (`category`,`is_featured`),
  KEY `media_galleries_type_is_active_index` (`type`,`is_active`),
  CONSTRAINT `media_galleries_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_galleries`
--

LOCK TABLES `media_galleries` WRITE;
/*!40000 ALTER TABLE `media_galleries` DISABLE KEYS */;
INSERT INTO `media_galleries` VALUES (1,'ا','ا','image','images/media/images/1762386926_690be3eec2525.png',NULL,'Screenshot 2025-06-11 194445.png','image/png',233747,'ا',NULL,1,1,1,1,'2025-11-05 23:55:26','2025-11-14 01:01:50');
/*!40000 ALTER TABLE `media_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_templates`
--

DROP TABLE IF EXISTS `message_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `variables` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `message_templates_type_is_active_index` (`type`,`is_active`),
  CONSTRAINT `message_templates_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_templates`
--

LOCK TABLES `message_templates` WRITE;
/*!40000 ALTER TABLE `message_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_08_30_011316_create_learning_platform_tables',1),(5,'2025_08_30_013755_create_advanced_platform_tables',1),(6,'2025_08_30_124816_create_orders_table',1),(7,'2025_08_30_130813_add_advanced_course_id_to_course_enrollments_table',1),(8,'2025_08_31_012310_create_student_course_enrollments_table',1),(9,'2025_08_31_154304_add_video_and_attachments_to_course_lessons_table',1),(10,'2025_09_01_024049_add_activity_log_columns',2),(11,'2025_11_01_233032_create_academic_years_and_subjects_tables',3),(12,'2025_11_01_234139_create_advanced_courses_table',4),(14,'2025_11_01_234339_create_coupons_and_discounts_system',6),(15,'2025_11_01_234342_create_certificates_and_achievements_system',7),(16,'2025_11_01_234346_update_course_enrollments_to_academy_system',8),(17,'2025_11_02_000001_remove_academic_fields_from_advanced_courses',9),(18,'2025_11_04_191812_create_course_lessons_table',10),(19,'2025_08_31_154500_update_course_lessons_duration_minutes_nullable',11),(20,'2025_08_31_160100_update_questions_table',12),(21,'2025_08_31_170421_create_question_categories_table_if_not_exists',12),(22,'2025_08_31_175753_create_notifications_table_enhanced',12),(23,'2025_08_31_190812_create_calendar_events_table',12),(24,'2025_08_31_191013_create_calendar_event_attendees_table',12),(25,'2025_11_04_191254_create_lectures_and_groups_system',13),(26,'2025_11_04_191257_create_tasks_system',14),(27,'2025_11_04_191301_create_attendance_system',15),(28,'2025_11_04_192343_create_public_pages_tables',16),(29,'2025_08_31_231829_add_parent_id_to_question_categories_table',17),(30,'2025_11_04_191304_enhance_assignments_system',18),(31,'2025_11_04_191307_enhance_exams_anti_cheat_system',18),(32,'2025_09_01_024744_create_whats_app_messages_table',19),(33,'2025_09_01_024811_create_student_reports_table',20),(34,'2025_11_01_235808_create_wallet_transactions_table',21),(35,'2025_08_31_232138_make_question_bank_id_nullable_in_questions_table',22),(36,'2025_08_31_233317_add_passing_marks_to_exams_table',22),(37,'2025_08_31_233345_make_description_nullable_in_advanced_courses_table',22),(38,'2025_08_31_233454_add_missing_columns_to_exams_table',22),(39,'2025_08_31_233702_add_is_active_to_exams_table',22),(40,'2025_08_31_233756_fix_course_id_in_exams_table',22),(41,'2025_08_31_233851_fix_created_by_in_exams_table',22),(42,'2025_08_31_234019_make_total_marks_nullable_in_exams_table',22),(43,'2025_08_31_234417_fix_date_time_columns_in_exams_table',22),(44,'2025_09_01_003807_fix_exams_date_columns',22),(45,'2025_09_01_021922_add_time_limit_and_is_required_to_exam_questions_table',22),(46,'2025_09_01_022319_add_missing_columns_to_exam_attempts_table',22),(47,'2025_09_01_022502_add_remaining_columns_to_exam_attempts_table',22),(48,'2025_09_01_024754_create_message_templates_table',22),(49,'2025_11_06_175225_create_user_permissions_table',23),(50,'2025_11_01_232031_update_user_roles_to_new_system',24),(51,'2025_11_01_234336_create_accounting_system_tables',25),(52,'2025_11_06_190000_create_installment_tables',26),(55,'2025_11_20_211138_fix_academic_fields_types_in_advanced_courses_table',27),(56,'2025_11_20_212901_add_advanced_course_id_to_assignments_table',28),(57,'2025_11_20_214901_add_course_lesson_id_to_lectures_table',29),(58,'2025_11_06_180000_create_packages_table',30),(59,'2025_11_21_160728_add_wallet_id_to_orders_table',31),(61,'2025_11_21_163652_add_invoice_and_payment_to_orders_table',32),(62,'2025_11_21_163708_create_expenses_table',33),(63,'2025_11_21_161839_add_electronic_wallet_fields_to_wallets_table',34),(64,'2025_11_21_172521_improve_accounting_relationships',35),(65,'2025_11_21_172522_improve_payments_relationships',35),(67,'2025_11_21_233832_add_status_to_certificates_table',36),(68,'2025_11_21_172523_improve_expenses_relationships',37),(69,'2025_11_21_235851_add_points_earned_to_user_achievements_table',38),(70,'2025_11_22_002314_add_title_to_coupons_table',39),(71,'2025_11_22_005654_create_referral_programs_table',40),(72,'2025_11_22_005655_add_referral_fields_to_users_table',41),(73,'2025_11_22_005657_add_referral_coupon_fields_to_referrals_table',42),(74,'2025_11_22_220000_add_coupon_fields_to_orders_table',43),(75,'2025_11_24_203441_add_discount_amount_to_referrals_table',44);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_reads`
--

DROP TABLE IF EXISTS `notification_reads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_reads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_id` int NOT NULL,
  `user_id` int NOT NULL,
  `read_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_reads_notification_id_user_id_unique` (`notification_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notification_reads_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `advanced_notifications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notification_reads_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_reads`
--

LOCK TABLES `notification_reads` WRITE;
/*!40000 ALTER TABLE `notification_reads` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_reads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT (_utf8mb3'info'),
  `is_read` tinyint(1) NOT NULL DEFAULT (_utf8mb3'0'),
  `read_at` datetime DEFAULT NULL,
  `data` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `action_text` varchar(255) DEFAULT NULL,
  `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  `target_type` enum('all_students','course_students','year_students','subject_students','individual') NOT NULL DEFAULT 'individual',
  `target_id` int DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `advanced_course_id` int NOT NULL,
  `coupon_id` bigint unsigned DEFAULT NULL,
  `original_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,0) NOT NULL,
  `payment_method` enum('bank_transfer','cash','other') NOT NULL DEFAULT 'bank_transfer',
  `wallet_id` bigint unsigned DEFAULT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `payment_id` bigint unsigned DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_status_created_at_index` (`status`,`created_at`),
  KEY `orders_user_id_advanced_course_id_index` (`user_id`,`advanced_course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,3,NULL,NULL,0.00,599,'bank_transfer',NULL,NULL,NULL,'payment-proofs/Vv9JQVxsk642nyHhUt34LJZw8PzlzVtVvaA3Lnff.png','approved',NULL,'2025-11-20 21:40:08',1,'2025-11-20 19:33:06','2025-11-20 21:40:08'),(2,5,12,NULL,NULL,0.00,549,'bank_transfer',NULL,NULL,NULL,'payment-proofs/Tjpg4jWX01Va4MQQQb5V2Yh4DukKqcad9HlT1BsK.png','rejected',NULL,NULL,1,'2025-11-21 16:21:57','2025-11-22 01:55:20'),(6,5,4,NULL,NULL,0.00,449,'cash',1,5,5,'payment-proofs/sample-5.jpg','approved','طلب تجريبي لاختبار الترابط','2025-11-16 17:37:36',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(7,5,12,1,549.00,54.90,494,'bank_transfer',NULL,7,7,'payment-proofs/ToxeOcaqFnfNTT4Y1lxdwbpfdF5ksUFPxY76Qskl.png','approved','خصم الكوبون (187802): 54.90 ج.م','2025-11-22 01:58:18',1,'2025-11-22 01:57:49','2025-11-22 01:58:18');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_course`
--

DROP TABLE IF EXISTS `package_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_course` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_course_package_id_foreign` (`package_id`),
  CONSTRAINT `package_course_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_course`
--

LOCK TABLES `package_course` WRITE;
/*!40000 ALTER TABLE `package_course` DISABLE KEYS */;
/*!40000 ALTER TABLE `package_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `features` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `original_price` decimal(10,2) DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_days` int DEFAULT NULL,
  `courses_count` int NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`),
  KEY `packages_is_active_is_featured_index` (`is_active`,`is_featured`),
  KEY `packages_slug_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_students`
--

DROP TABLE IF EXISTS `parent_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent_students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `student_id` int NOT NULL,
  `relation` enum('father','mother','guardian') NOT NULL DEFAULT 'father',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_students_parent_id_student_id_unique` (`parent_id`,`student_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `parent_students_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parent_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_students`
--

LOCK TABLES `parent_students` WRITE;
/*!40000 ALTER TABLE `parent_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `parent_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_number` varchar(255) NOT NULL,
  `invoice_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_method` enum('cash','card','bank_transfer','online','wallet','other') NOT NULL DEFAULT 'cash',
  `wallet_id` bigint unsigned DEFAULT NULL,
  `installment_payment_id` bigint unsigned DEFAULT NULL,
  `payment_gateway` enum('manual','moyasar','stripe','paypal','other') DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'EGP',
  `status` enum('pending','processing','completed','failed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `gateway_response` text,
  `notes` text,
  `paid_at` datetime DEFAULT NULL,
  `processed_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_number_unique` (`payment_number`),
  KEY `processed_by` (`processed_by`),
  KEY `payments_invoice_id_status_index` (`invoice_id`,`status`),
  KEY `payments_payment_number_index` (`payment_number`),
  KEY `payments_transaction_id_index` (`transaction_id`),
  KEY `payments_user_id_status_index` (`user_id`,`status`),
  KEY `payments_wallet_id_index` (`wallet_id`),
  KEY `payments_installment_payment_id_index` (`installment_payment_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (5,'PAY-00000001',5,5,'cash',1,NULL,NULL,449,'EGP','completed',NULL,NULL,NULL,'دفعة تلقائية من طلب رقم: 6','2025-11-11 00:00:00',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(6,'PAY-00000002',6,5,'bank_transfer',NULL,6,NULL,100,'EGP','completed',NULL,NULL,NULL,'دفعة قسط تقسيط','2025-11-16 17:37:36',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(7,'PAY-00000003',7,5,'bank_transfer',NULL,NULL,NULL,494,'EGP','completed',NULL,NULL,NULL,'دفعة من طلب رقم: 7','2025-11-22 01:58:18',1,'2025-11-22 01:58:18','2025-11-22 01:58:18'),(8,'PAY-00000004',5,5,'cash',NULL,7,NULL,87,'EGP','completed',NULL,NULL,NULL,'دفعة قسط تقسيط رقم: 1','2025-11-24 20:33:05',1,'2025-11-24 20:33:05','2025-11-24 20:33:05');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view.dashboard','عرض لوحة التحكم','إمكانية الوصول إلى لوحة التحكم','إدارة النظام','2025-11-06 17:11:37','2025-11-06 17:11:37'),(2,'manage.users','إدارة المستخدمين','إدارة المستخدمين (عرض، إضافة، تعديل، حذف)','إدارة النظام','2025-11-06 17:11:37','2025-11-06 17:11:37'),(3,'manage.orders','إدارة الطلبات','إدارة طلبات التسجيل في الكورسات','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(4,'manage.notifications','إدارة الإشعارات','إرسال وإدارة الإشعارات','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(5,'view.activity-log','عرض سجل النشاطات','عرض سجل نشاطات المستخدمين','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(6,'view.statistics','عرض الإحصائيات','عرض إحصائيات المنصة','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(7,'manage.roles','إدارة الأدوار','إدارة الأدوار والصلاحيات','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(8,'manage.permissions','إدارة الصلاحيات','إدارة الصلاحيات','إدارة النظام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(9,'manage.invoices','إدارة الفواتير','إدارة الفواتير','إدارة المحاسبة','2025-11-06 17:11:38','2025-11-06 17:11:38'),(10,'manage.payments','إدارة المدفوعات','إدارة المدفوعات','إدارة المحاسبة','2025-11-06 17:11:38','2025-11-06 17:11:38'),(11,'manage.transactions','إدارة المعاملات المالية','إدارة المعاملات المالية','إدارة المحاسبة','2025-11-06 17:11:38','2025-11-06 17:11:38'),(12,'manage.wallets','إدارة المحافظ','إدارة محافظ المستخدمين','إدارة المحاسبة','2025-11-06 17:11:38','2025-11-06 17:11:38'),(13,'manage.subscriptions','إدارة الاشتراكات','إدارة الاشتراكات','إدارة المحاسبة','2025-11-06 17:11:38','2025-11-06 17:11:38'),(14,'manage.coupons','إدارة الكوبونات','إدارة الكوبونات والخصومات','إدارة التسويق','2025-11-06 17:11:38','2025-11-06 17:11:38'),(15,'manage.referrals','إدارة برنامج الإحالات','إدارة برنامج الإحالات','إدارة التسويق','2025-11-06 17:11:38','2025-11-06 17:11:38'),(16,'manage.loyalty','إدارة برامج الولاء','إدارة برامج الولاء','إدارة التسويق','2025-11-06 17:11:38','2025-11-06 17:11:38'),(17,'manage.certificates','إدارة الشهادات','إدارة الشهادات','الشهادات والإنجازات','2025-11-06 17:11:38','2025-11-06 17:11:38'),(18,'manage.achievements','إدارة الإنجازات','إدارة الإنجازات','الشهادات والإنجازات','2025-11-06 17:11:38','2025-11-06 17:11:38'),(19,'manage.badges','إدارة الشارات','إدارة الشارات','الشهادات والإنجازات','2025-11-06 17:11:38','2025-11-06 17:11:38'),(20,'manage.reviews','إدارة التقييمات','إدارة التقييمات والمراجعات','الشهادات والإنجازات','2025-11-06 17:11:38','2025-11-06 17:11:38'),(21,'manage.academic-years','إدارة السنوات الدراسية','إدارة السنوات الدراسية','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(22,'manage.academic-subjects','إدارة المواد الدراسية','إدارة المواد الدراسية','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(23,'manage.courses','إدارة الكورسات','إدارة الكورسات والدروس','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(24,'manage.enrollments','إدارة تسجيل الطلاب','إدارة تسجيل الطلاب في الكورسات','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(25,'manage.lectures','إدارة المحاضرات','إدارة المحاضرات','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(26,'manage.groups','إدارة المجموعات','إدارة المجموعات الدراسية','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(27,'manage.assignments','إدارة الواجبات','إدارة الواجبات والمشاريع','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(28,'manage.exams','إدارة الامتحانات','إدارة الامتحانات','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(29,'manage.question-bank','إدارة بنك الأسئلة','إدارة بنك الأسئلة','إدارة المحتوى','2025-11-06 17:11:38','2025-11-06 17:11:38'),(30,'manage.blog','إدارة المدونة','إدارة مقالات المدونة','إدارة الصفحات الخارجية','2025-11-06 17:11:38','2025-11-06 17:11:38'),(31,'manage.faq','إدارة الأسئلة الشائعة','إدارة الأسئلة الشائعة','إدارة الصفحات الخارجية','2025-11-06 17:11:38','2025-11-06 17:11:38'),(32,'manage.contact-messages','إدارة رسائل التواصل','إدارة رسائل التواصل','إدارة الصفحات الخارجية','2025-11-06 17:11:38','2025-11-06 17:11:38'),(33,'manage.media','إدارة معرض الصور','إدارة معرض الصور والفيديوهات','إدارة الصفحات الخارجية','2025-11-06 17:11:38','2025-11-06 17:11:38'),(34,'manage.tasks','إدارة المهام','إدارة المهام','المهام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(35,'view.tasks','عرض المهام','عرض المهام المخصصة','المهام','2025-11-06 17:11:38','2025-11-06 17:11:38'),(36,'view.wallets','عرض المحافظ','عرض المحافظ الذكية','المحافظ الذكية','2025-11-06 17:11:38','2025-11-06 17:11:38'),(37,'manage.messages','إدارة الرسائل','إدارة الرسائل والتقارير','الرسائل والتقارير','2025-11-06 17:11:38','2025-11-06 17:11:38'),(38,'view.calendar','عرض التقويم','عرض التقويم','التقويم','2025-11-06 17:11:38','2025-11-06 17:11:38'),(39,'instructor.view.courses','عرض كورساتي','عرض الكورسات الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(40,'instructor.manage.lectures','إدارة محاضراتي','إدارة المحاضرات الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(41,'instructor.manage.groups','إدارة مجموعاتي','إدارة المجموعات الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(42,'instructor.manage.assignments','إدارة واجباتي','إدارة الواجبات الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(43,'instructor.manage.exams','إدارة اختباراتي','إدارة الامتحانات الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(44,'instructor.manage.attendance','إدارة الحضور','إدارة الحضور والانصراف','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(45,'instructor.view.tasks','عرض مهامي','عرض المهام الخاصة بالمدرب','صلاحيات المدرب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(46,'student.view.courses','تصفح الكورسات','تصفح الكورسات المتاحة','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(47,'student.view.my-courses','عرض كورساتي','عرض الكورسات المسجل فيها','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(48,'student.view.orders','عرض طلباتي','عرض طلبات التسجيل','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(49,'student.view.invoices','عرض فواتيري','عرض الفواتير','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(50,'student.view.wallet','عرض محفظتي','عرض المحفظة','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(51,'student.view.certificates','عرض شهاداتي','عرض الشهادات','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(52,'student.view.achievements','عرض إنجازاتي','عرض الإنجازات','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(53,'student.view.exams','عرض الامتحانات','عرض الامتحانات المتاحة','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(54,'student.view.notifications','عرض الإشعارات','عرض الإشعارات','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(55,'student.view.profile','عرض البروفايل','عرض وتعديل البروفايل','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(56,'student.view.settings','عرض الإعدادات','عرض الإعدادات','صلاحيات الطالب','2025-11-06 17:11:38','2025-11-06 17:11:38'),(57,'manage.user-permissions','إدارة صلاحيات المستخدمين','إدارة صلاحيات المستخدمين مباشرة','إدارة النظام','2025-11-06 17:54:57','2025-11-06 17:54:57');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platform_settings`
--

DROP TABLE IF EXISTS `platform_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `platform_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `group` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `platform_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platform_settings`
--

LOCK TABLES `platform_settings` WRITE;
/*!40000 ALTER TABLE `platform_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `platform_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_transactions`
--

DROP TABLE IF EXISTS `point_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `point_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_points_id` int NOT NULL,
  `type` enum('earned','redeemed','expired','adjusted') NOT NULL DEFAULT 'earned',
  `points` int NOT NULL,
  `points_before` int NOT NULL,
  `points_after` int NOT NULL,
  `description` text NOT NULL,
  `invoice_id` int DEFAULT NULL,
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_points_id` (`user_points_id`),
  KEY `point_transactions_invoice_id_index` (`invoice_id`),
  KEY `point_transactions_user_id_type_index` (`user_id`,`type`),
  CONSTRAINT `point_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `point_transactions_ibfk_2` FOREIGN KEY (`user_points_id`) REFERENCES `user_points` (`id`) ON DELETE CASCADE,
  CONSTRAINT `point_transactions_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_transactions`
--

LOCK TABLES `point_transactions` WRITE;
/*!40000 ALTER TABLE `point_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `point_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `progress_tracks`
--

DROP TABLE IF EXISTS `progress_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progress_tracks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `track_type` enum('course','lesson','exam','assignment','overall') NOT NULL DEFAULT 'course',
  `item_id` int DEFAULT NULL,
  `progress_percentage` int NOT NULL DEFAULT '0',
  `status` enum('not_started','in_progress','completed','failed') NOT NULL DEFAULT 'not_started',
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `time_spent_minutes` int NOT NULL DEFAULT '0',
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `progress_tracks_status_progress_percentage_index` (`status`,`progress_percentage`),
  KEY `progress_tracks_user_id_course_id_track_type_index` (`user_id`,`course_id`,`track_type`),
  CONSTRAINT `progress_tracks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progress_tracks_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `progress_tracks`
--

LOCK TABLES `progress_tracks` WRITE;
/*!40000 ALTER TABLE `progress_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `progress_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_banks`
--

DROP TABLE IF EXISTS `question_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_banks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `subject_id` int NOT NULL,
  `created_by` int NOT NULL,
  `difficulty` enum('easy','medium','hard') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `question_banks_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_banks_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_banks`
--

LOCK TABLES `question_banks` WRITE;
/*!40000 ALTER TABLE `question_banks` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_categories`
--

DROP TABLE IF EXISTS `question_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `academic_year_id` int NOT NULL,
  `academic_subject_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `academic_subject_id` (`academic_subject_id`),
  KEY `question_categories_academic_year_id_academic_subject_id_index` (`academic_year_id`,`academic_subject_id`),
  KEY `question_categories_parent_id_order_index` (`parent_id`,`order`),
  CONSTRAINT `question_categories_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_categories_ibfk_2` FOREIGN KEY (`academic_subject_id`) REFERENCES `academic_subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_categories_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `question_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_categories`
--

LOCK TABLES `question_categories` WRITE;
/*!40000 ALTER TABLE `question_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_bank_id` int DEFAULT NULL,
  `question` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `options` text,
  `correct_answer` text NOT NULL,
  `explanation` text,
  `points` decimal(10,0) NOT NULL DEFAULT (_utf8mb3'1'),
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT (_utf8mb3'1'),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `difficulty_level` enum('easy','medium','hard') NOT NULL DEFAULT (_utf8mb3'medium'),
  `image_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `time_limit` int DEFAULT NULL,
  `tags` text,
  PRIMARY KEY (`id`),
  KEY `question_bank_id` (`question_bank_id`),
  KEY `questions_category_id_type_index` (`category_id`,`type`),
  KEY `questions_difficulty_level_is_active_index` (`difficulty_level`,`is_active`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `question_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`question_bank_id`) REFERENCES `question_banks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_attempts`
--

DROP TABLE IF EXISTS `quiz_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `student_id` int NOT NULL,
  `started_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` datetime DEFAULT NULL,
  `answers` text,
  `score` int DEFAULT NULL,
  `total_points` int DEFAULT NULL,
  `status` enum('in_progress','completed','timeout') NOT NULL DEFAULT 'in_progress',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_attempts`
--

LOCK TABLES `quiz_attempts` WRITE;
/*!40000 ALTER TABLE `quiz_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `question` text NOT NULL,
  `type` enum('multiple_choice','true_false','short_answer','essay') NOT NULL,
  `options` text,
  `correct_answer` text NOT NULL,
  `points` int NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_questions`
--

LOCK TABLES `quiz_questions` WRITE;
/*!40000 ALTER TABLE `quiz_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quizzes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `course_id` int NOT NULL,
  `lesson_id` int DEFAULT NULL,
  `teacher_id` int NOT NULL,
  `duration_minutes` int NOT NULL DEFAULT '60',
  `max_attempts` int NOT NULL DEFAULT '1',
  `shuffle_questions` tinyint(1) NOT NULL DEFAULT '0',
  `show_results_immediately` tinyint(1) NOT NULL DEFAULT '0',
  `available_from` datetime DEFAULT NULL,
  `available_until` datetime DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `quizzes_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizzes`
--

LOCK TABLES `quizzes` WRITE;
/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;
/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referral_programs`
--

DROP TABLE IF EXISTS `referral_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referral_programs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `discount_type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `maximum_discount` decimal(10,2) DEFAULT NULL,
  `minimum_order_amount` decimal(10,2) DEFAULT NULL,
  `referrer_reward_type` enum('percentage','fixed','points') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `referrer_reward_value` decimal(10,2) DEFAULT NULL,
  `discount_valid_days` int NOT NULL DEFAULT '30',
  `referral_code_valid_days` int DEFAULT NULL,
  `max_referrals_per_user` int DEFAULT NULL,
  `max_discount_uses_per_referred` int NOT NULL DEFAULT '1',
  `allow_self_referral` tinyint(1) NOT NULL DEFAULT '0',
  `starts_at` date DEFAULT NULL,
  `expires_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `referral_programs_is_active_starts_at_expires_at_index` (`is_active`,`starts_at`,`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referral_programs`
--

LOCK TABLES `referral_programs` WRITE;
/*!40000 ALTER TABLE `referral_programs` DISABLE KEYS */;
INSERT INTO `referral_programs` VALUES (1,'برنامج الإحالات الافتراضي','برنامج إحالات أساسي - خصم 10% للمستخدم المحال ومكافأة 20 ج.م للمحيل','percentage',10.00,50.00,100.00,'fixed',20.00,30,NULL,NULL,1,0,NULL,NULL,1,NULL,'2025-11-21 23:03:42','2025-11-21 23:03:42');
/*!40000 ALTER TABLE `referral_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referrals`
--

DROP TABLE IF EXISTS `referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referrals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `referrer_id` int NOT NULL,
  `referred_id` int NOT NULL,
  `referral_code` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL,
  `commission_type` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `completed_at` datetime DEFAULT NULL,
  `reward_amount` decimal(10,0) DEFAULT NULL,
  `reward_points` int DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_used_count` int NOT NULL DEFAULT '0',
  `discount_expires_at` datetime DEFAULT NULL,
  `invoice_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `referral_program_id` bigint unsigned DEFAULT NULL,
  `auto_coupon_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referrals_referral_code_unique` (`referral_code`),
  UNIQUE KEY `referrals_referred_id_unique` (`referred_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `referrals_referral_code_index` (`referral_code`),
  KEY `referrals_referrer_id_status_index` (`referrer_id`,`status`),
  KEY `referrals_referral_program_id_index` (`referral_program_id`),
  KEY `referrals_auto_coupon_id_index` (`auto_coupon_id`),
  CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `referrals_ibfk_2` FOREIGN KEY (`referred_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `referrals_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `referrals_referral_program_id_foreign` FOREIGN KEY (`referral_program_id`) REFERENCES `referral_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referrals`
--

LOCK TABLES `referrals` WRITE;
/*!40000 ALTER TABLE `referrals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referrals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_helpful`
--

DROP TABLE IF EXISTS `review_helpful`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_helpful` (
  `id` int NOT NULL AUTO_INCREMENT,
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_helpful` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `review_helpful_review_id_user_id_unique` (`review_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `review_helpful_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `course_reviews` (`id`) ON DELETE CASCADE,
  CONSTRAINT `review_helpful_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_helpful`
--

LOCK TABLES `review_helpful` WRITE;
/*!40000 ALTER TABLE `review_helpful` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_helpful` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,1,4,NULL,NULL),(5,1,5,NULL,NULL),(6,1,6,NULL,NULL),(7,1,7,NULL,NULL),(8,1,8,NULL,NULL),(9,1,9,NULL,NULL),(10,1,10,NULL,NULL),(11,1,11,NULL,NULL),(12,1,12,NULL,NULL),(13,1,13,NULL,NULL),(14,1,14,NULL,NULL),(15,1,15,NULL,NULL),(16,1,16,NULL,NULL),(17,1,17,NULL,NULL),(18,1,18,NULL,NULL),(19,1,19,NULL,NULL),(20,1,20,NULL,NULL),(21,1,21,NULL,NULL),(22,1,22,NULL,NULL),(23,1,23,NULL,NULL),(24,1,24,NULL,NULL),(25,1,25,NULL,NULL),(26,1,26,NULL,NULL),(27,1,27,NULL,NULL),(28,1,28,NULL,NULL),(29,1,29,NULL,NULL),(30,1,30,NULL,NULL),(31,1,31,NULL,NULL),(32,1,32,NULL,NULL),(33,1,33,NULL,NULL),(34,1,34,NULL,NULL),(35,1,35,NULL,NULL),(36,1,36,NULL,NULL),(37,1,37,NULL,NULL),(38,1,38,NULL,NULL),(39,1,39,NULL,NULL),(40,1,40,NULL,NULL),(41,1,41,NULL,NULL),(42,1,42,NULL,NULL),(43,1,43,NULL,NULL),(44,1,44,NULL,NULL),(45,1,45,NULL,NULL),(46,1,46,NULL,NULL),(47,1,47,NULL,NULL),(48,1,48,NULL,NULL),(49,1,49,NULL,NULL),(50,1,50,NULL,NULL),(51,1,51,NULL,NULL),(52,1,52,NULL,NULL),(53,1,53,NULL,NULL),(54,1,54,NULL,NULL),(55,1,55,NULL,NULL),(56,1,56,NULL,NULL);
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','مدير عام','مدير عام للنظام - يمتلك جميع الصلاحيات',0,'2025-11-06 17:17:17','2025-11-06 17:17:17');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schools` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,'مدرسة النور الابتدائية','مدرسة ابتدائية متميزة تهتم بتطوير قدرات الطلاب',NULL,'الرياض، المملكة العربية السعودية','0112345678','info@alnoor.edu.sa',1,'2025-11-05 18:01:24','2025-11-05 18:01:24');
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('9wUaIDpQoi2n2SoCBAXcZHziFFYe8e3FkKYxN04R',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSDR1b2wzNWF1d09Ld0ZjZ3AwUmNCMW0ya0Z1MXF5SVRua2Z5NXliVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1764016985),('C0wNLOs1Gc5jgFpMj85D1gUngcQL4R1KkKNERN23',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaVprUTVubGxmTFVsUHVUbURZSFJLbTFFbWdHWjFhTHpSOXBkd0Q1UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=',1764017173),('rKFvgL6zdnFDR647GnUECBxk0Q1HDrcFt9fEYhYq',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieERVUEhRR2xSbXRhRDQzTDNsOFdIY1pJSFJvTHVIQ0NkajBhenBMMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1764017059),('TzI1cBem13aemV5qSFQIKffIZSO01jWytZHFVEd1',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicld0ZEJsMFlsUTUyeldLWW1wSE1TSGRFTTR6dHJNVHplMG9iaDFuMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1764017052),('uBcGsyDSI0jsGr3afmwVMpBeQURE7uN2B8eEKbUj',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVXU3NHZXQTB1S2pyWGVxMVdwNTZ3dzZGdjdPdU4yMmlTUktEQmtXWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1764017004),('Y5s1Ij9lQaYTbfCnKCFK4inF7HYTaeBdhsVTwrOh',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEN4bmpKNFJLa2VuZ29VRWdmdUE2VXZMTXB2OHZiR2s5ajl3NnAwSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1764017139);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_course_enrollments`
--

DROP TABLE IF EXISTS `student_course_enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_course_enrollments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `advanced_course_id` int NOT NULL,
  `enrolled_at` datetime NOT NULL DEFAULT (now()),
  `activated_at` datetime DEFAULT NULL,
  `activated_by` int DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT (_utf8mb3'pending'),
  `progress` decimal(10,0) NOT NULL DEFAULT (_utf8mb3'0'),
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `invoice_id` int DEFAULT NULL,
  `payment_id` int DEFAULT NULL,
  `coupon_id` int DEFAULT NULL,
  `original_price` decimal(10,0) NOT NULL DEFAULT '0',
  `discount_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `final_price` decimal(10,0) NOT NULL DEFAULT '0',
  `payment_method` enum('cash','card','bank_transfer','online','wallet','subscription','free') DEFAULT NULL,
  `enrollment_type` enum('purchase','subscription','gift','trial','promotional') NOT NULL DEFAULT 'purchase',
  `expires_at` datetime DEFAULT NULL,
  `access_type` enum('lifetime','limited','subscription') NOT NULL DEFAULT 'lifetime',
  `referral_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_course` (`user_id`,`advanced_course_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `payment_id` (`payment_id`),
  KEY `coupon_id` (`coupon_id`),
  KEY `student_course_enrollments_status_enrolled_at_index` (`status`,`enrolled_at`),
  CONSTRAINT `student_course_enrollments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_course_enrollments_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_course_enrollments_ibfk_3` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_course_enrollments`
--

LOCK TABLES `student_course_enrollments` WRITE;
/*!40000 ALTER TABLE `student_course_enrollments` DISABLE KEYS */;
INSERT INTO `student_course_enrollments` VALUES (1,5,3,'2025-11-20 21:40:08','2025-11-21 10:45:18',1,'active',0,NULL,'2025-11-20 21:40:08','2025-11-21 10:45:18',NULL,NULL,NULL,0,0,0,NULL,'purchase',NULL,'lifetime',NULL),(4,5,4,'2025-11-20 17:37:36','2025-11-16 17:37:36',1,'active',87,NULL,'2025-11-21 17:37:36','2025-11-21 17:37:36',5,5,NULL,449,0,449,'cash','purchase',NULL,'lifetime',NULL),(5,5,12,'2025-11-22 01:58:18','2025-11-22 01:58:18',1,'active',0,NULL,'2025-11-22 01:58:18','2025-11-22 01:58:18',NULL,NULL,NULL,0,0,0,NULL,'purchase',NULL,'lifetime',NULL);
/*!40000 ALTER TABLE `student_course_enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_reports`
--

DROP TABLE IF EXISTS `student_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `report_month` varchar(255) NOT NULL,
  `report_type` enum('monthly','weekly','custom') NOT NULL DEFAULT 'monthly',
  `report_data` text NOT NULL,
  `sent_via` enum('whatsapp','email','sms') NOT NULL DEFAULT 'whatsapp',
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `error_message` text,
  `generated_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_reports_student_id_report_month_report_type_unique` (`student_id`,`report_month`,`report_type`),
  KEY `generated_by` (`generated_by`),
  KEY `student_reports_parent_id_sent_at_index` (`parent_id`,`sent_at`),
  KEY `student_reports_student_id_report_month_index` (`student_id`,`report_month`),
  CONSTRAINT `student_reports_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_reports_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_reports_ibfk_3` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_reports`
--

LOCK TABLES `student_reports` WRITE;
/*!40000 ALTER TABLE `student_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `color` varchar(255) NOT NULL DEFAULT '#3B82F6',
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'الرياضيات','تعلم الأرقام والعمليات الحسابية والهندسة','#3B82F6','fas fa-calculator',1,'2025-11-05 18:01:24','2025-11-05 18:01:24'),(2,'العلوم','استكشاف الطبيعة والكيمياء والفيزياء','#10B981','fas fa-flask',1,'2025-11-05 18:01:24','2025-11-05 18:01:24'),(3,'اللغة العربية','تطوير مهارات القراءة والكتابة والتعبير','#8B5CF6','fas fa-book',1,'2025-11-05 18:01:24','2025-11-05 18:01:24'),(4,'اللغة الإنجليزية','تعلم اللغة الإنجليزية من الأساسيات إلى المستوى المتقدم','#F59E0B','fas fa-globe',1,'2025-11-05 18:01:24','2025-11-05 18:01:24'),(5,'التاريخ','دراسة الأحداث التاريخية والحضارات','#EF4444','fas fa-landmark',1,'2025-11-05 18:01:24','2025-11-05 18:01:24'),(6,'الجغرافيا','دراسة الأرض والبيئة والمناخ','#06B6D4','fas fa-map',1,'2025-11-05 18:01:24','2025-11-05 18:01:24');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `subscription_type` varchar(255) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','expired','cancelled','suspended') NOT NULL DEFAULT 'active',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '0',
  `billing_cycle` int NOT NULL DEFAULT '1',
  `invoice_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `subscriptions_end_date_index` (`end_date`),
  KEY `subscriptions_user_id_status_index` (`user_id`,`status`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_comments`
--

DROP TABLE IF EXISTS `task_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `voice_comment_path` varchar(255) DEFAULT NULL,
  `attachments` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `task_comments_task_id_created_at_index` (`task_id`,`created_at`),
  CONSTRAINT `task_comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_comments`
--

LOCK TABLES `task_comments` WRITE;
/*!40000 ALTER TABLE `task_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_notifications`
--

DROP TABLE IF EXISTS `task_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('reminder','due_soon','overdue','completed','comment') NOT NULL DEFAULT 'reminder',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `sent_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_notifications_task_id_type_index` (`task_id`,`type`),
  KEY `task_notifications_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `task_notifications_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_notifications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_notifications`
--

LOCK TABLES `task_notifications` WRITE;
/*!40000 ALTER TABLE `task_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('pending','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
  `due_date` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `related_course_id` int DEFAULT NULL,
  `related_lecture_id` int DEFAULT NULL,
  `related_assignment_id` int DEFAULT NULL,
  `related_type` varchar(255) DEFAULT NULL,
  `related_id` int DEFAULT NULL,
  `is_reminder` tinyint(1) NOT NULL DEFAULT '0',
  `reminder_at` datetime DEFAULT NULL,
  `tags` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `related_course_id` (`related_course_id`),
  KEY `related_lecture_id` (`related_lecture_id`),
  KEY `related_assignment_id` (`related_assignment_id`),
  KEY `tasks_related_type_related_id_index` (`related_type`,`related_id`),
  KEY `tasks_user_id_due_date_index` (`user_id`,`due_date`),
  KEY `tasks_user_id_status_index` (`user_id`,`status`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`related_course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`related_lecture_id`) REFERENCES `lectures` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`related_assignment_id`) REFERENCES `assignments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams_attendance_files`
--

DROP TABLE IF EXISTS `teams_attendance_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams_attendance_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecture_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL DEFAULT 'csv',
  `total_records` int NOT NULL DEFAULT '0',
  `processed_records` int NOT NULL DEFAULT '0',
  `status` enum('uploaded','processing','completed','failed') NOT NULL DEFAULT 'uploaded',
  `error_message` text,
  `uploaded_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `teams_attendance_files_lecture_id_status_index` (`lecture_id`,`status`),
  CONSTRAINT `teams_attendance_files_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teams_attendance_files_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams_attendance_files`
--

LOCK TABLES `teams_attendance_files` WRITE;
/*!40000 ALTER TABLE `teams_attendance_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams_attendance_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `payment_id` int DEFAULT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `expense_id` bigint unsigned DEFAULT NULL,
  `subscription_id` bigint unsigned DEFAULT NULL,
  `type` enum('debit','credit') NOT NULL,
  `category` enum('course_payment','subscription','refund','commission','fee','other') NOT NULL DEFAULT 'other',
  `amount` decimal(10,0) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'EGP',
  `description` text NOT NULL,
  `status` enum('pending','completed','cancelled','reversed') NOT NULL DEFAULT 'completed',
  `metadata` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_number_unique` (`transaction_number`),
  KEY `payment_id` (`payment_id`),
  KEY `created_by` (`created_by`),
  KEY `transactions_category_index` (`category`),
  KEY `transactions_transaction_number_index` (`transaction_number`),
  KEY `transactions_user_id_type_status_index` (`user_id`,`type`,`status`),
  KEY `transactions_invoice_id_index` (`invoice_id`),
  KEY `transactions_expense_id_index` (`expense_id`),
  KEY `transactions_subscription_id_index` (`subscription_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (10,'TXN-00000001',5,5,5,NULL,NULL,'credit','course_payment',449,'EGP','إيراد من شراء كورس: React المتقدم - فاتورة: INV-00000001','completed','{\"order_id\":6,\"invoice_id\":5,\"payment_id\":5,\"course_id\":4}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(11,'TXN-00000002',1,NULL,NULL,7,NULL,'debit','other',1466,'EGP','مصروف: شراء معدات للقاعة - رقم المصروف: EXP-00000001','completed','{\"expense_id\":7,\"expense_number\":\"EXP-00000001\",\"category\":\"operational\"}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(12,'TXN-00000003',1,NULL,NULL,8,NULL,'debit','other',1550,'EGP','مصروف: إعلانات على وسائل التواصل - رقم المصروف: EXP-00000002','completed','{\"expense_id\":8,\"expense_number\":\"EXP-00000002\",\"category\":\"marketing\"}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(13,'TXN-00000004',1,NULL,NULL,9,NULL,'debit','other',271,'EGP','مصروف: رواتب الموظفين - رقم المصروف: EXP-00000003','completed','{\"expense_id\":9,\"expense_number\":\"EXP-00000003\",\"category\":\"salaries\"}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(14,'TXN-00000005',1,NULL,NULL,10,NULL,'debit','other',977,'EGP','مصروف: فاتورة الكهرباء - رقم المصروف: EXP-00000004','completed','{\"expense_id\":10,\"expense_number\":\"EXP-00000004\",\"category\":\"utilities\"}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(15,'TXN-00000006',1,NULL,NULL,11,NULL,'debit','other',1037,'EGP','مصروف: صيانة الأجهزة - رقم المصروف: EXP-00000005','completed','{\"expense_id\":11,\"expense_number\":\"EXP-00000005\",\"category\":\"equipment\"}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(16,'TXN-00000007',5,6,6,NULL,NULL,'credit','course_payment',100,'EGP','دفعة قسط تقسيط - قسط رقم: 0','completed','{\"installment_agreement_id\":2,\"installment_payment_id\":6,\"sequence_number\":0}',1,'2025-11-21 17:37:36','2025-11-21 17:37:36'),(17,'TXN-00000008',5,7,7,NULL,NULL,'credit','course_payment',494,'EGP','دفعة مقابل تسجيل في الكورس: Flutter لتطوير التطبيقات - طلب رقم: 7 - فاتورة: INV-00000003','completed','{\"order_id\":7,\"invoice_id\":7,\"payment_id\":7,\"course_id\":12}',1,'2025-11-22 01:58:18','2025-11-22 01:58:18'),(18,'TXN-00000009',5,8,5,NULL,NULL,'credit','course_payment',87,'EGP','دفعة قسط تقسيط - React المتقدم - قسط رقم: 1','completed','{\"installment_agreement_id\":2,\"installment_payment_id\":7,\"sequence_number\":1}',1,'2025-11-24 20:33:05','2025-11-24 20:33:05');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_achievements`
--

DROP TABLE IF EXISTS `user_achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_achievements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `achievement_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `earned_at` datetime NOT NULL,
  `progress` int NOT NULL DEFAULT '100',
  `points_earned` int NOT NULL DEFAULT '0',
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_achievement` (`user_id`,`achievement_id`,`course_id`),
  KEY `achievement_id` (`achievement_id`),
  KEY `course_id` (`course_id`),
  KEY `user_achievements_user_id_earned_at_index` (`user_id`,`earned_at`),
  CONSTRAINT `user_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_achievements_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_achievements_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `advanced_courses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_achievements`
--

LOCK TABLES `user_achievements` WRITE;
/*!40000 ALTER TABLE `user_achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_badges`
--

DROP TABLE IF EXISTS `user_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_badges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `badge_id` int NOT NULL,
  `earned_at` datetime NOT NULL,
  `is_displayed` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_badges_user_id_badge_id_unique` (`user_id`,`badge_id`),
  KEY `badge_id` (`badge_id`),
  KEY `user_badges_user_id_is_displayed_index` (`user_id`,`is_displayed`),
  CONSTRAINT `user_badges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_badges_ibfk_2` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_badges`
--

LOCK TABLES `user_badges` WRITE;
/*!40000 ALTER TABLE `user_badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permissions_user_id_permission_id_unique` (`user_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (4,5,56,NULL,NULL),(5,5,53,NULL,NULL),(6,5,55,NULL,NULL),(7,5,49,NULL,NULL),(8,5,48,NULL,NULL),(9,5,51,NULL,NULL),(10,5,47,NULL,NULL),(11,5,50,NULL,NULL),(12,6,43,NULL,NULL),(13,6,44,NULL,NULL),(14,6,41,NULL,NULL),(16,6,42,NULL,NULL),(17,6,40,NULL,NULL),(18,6,45,NULL,NULL),(19,1,43,NULL,NULL),(20,1,44,NULL,NULL),(21,1,39,NULL,NULL),(22,1,41,NULL,NULL),(23,1,42,NULL,NULL),(24,1,40,NULL,NULL),(25,1,45,NULL,NULL),(26,1,47,NULL,NULL),(27,1,50,NULL,NULL),(28,1,48,NULL,NULL),(29,1,49,NULL,NULL),(30,1,55,NULL,NULL),(31,1,53,NULL,NULL),(32,1,56,NULL,NULL),(33,1,51,NULL,NULL),(34,1,46,NULL,NULL),(35,1,52,NULL,NULL),(36,1,54,NULL,NULL),(37,1,34,NULL,NULL),(38,1,35,NULL,NULL),(39,1,36,NULL,NULL),(40,1,18,NULL,NULL),(41,1,17,NULL,NULL),(42,1,20,NULL,NULL),(43,1,19,NULL,NULL),(44,1,37,NULL,NULL),(45,1,38,NULL,NULL),(46,1,6,NULL,NULL),(47,1,5,NULL,NULL),(48,1,1,NULL,NULL),(49,1,57,NULL,NULL),(50,1,2,NULL,NULL),(51,1,3,NULL,NULL),(52,1,7,NULL,NULL),(53,1,4,NULL,NULL),(54,1,8,NULL,NULL),(55,1,27,NULL,NULL),(56,1,29,NULL,NULL),(57,1,24,NULL,NULL),(58,1,22,NULL,NULL),(59,1,25,NULL,NULL),(60,1,26,NULL,NULL),(61,1,28,NULL,NULL),(62,1,21,NULL,NULL),(63,1,23,NULL,NULL),(64,1,10,NULL,NULL),(65,1,13,NULL,NULL),(66,1,9,NULL,NULL),(67,1,11,NULL,NULL),(68,1,12,NULL,NULL),(69,1,33,NULL,NULL),(70,1,31,NULL,NULL),(71,1,30,NULL,NULL),(72,1,32,NULL,NULL),(73,1,14,NULL,NULL),(74,1,16,NULL,NULL),(75,1,15,NULL,NULL),(76,6,39,NULL,NULL);
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_points`
--

DROP TABLE IF EXISTS `user_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `loyalty_program_id` int DEFAULT NULL,
  `points` int NOT NULL DEFAULT '0',
  `total_earned` int NOT NULL DEFAULT '0',
  `total_redeemed` int NOT NULL DEFAULT '0',
  `tier` enum('bronze','silver','gold','platinum','diamond') NOT NULL DEFAULT 'bronze',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_points_user_id_unique` (`user_id`),
  KEY `loyalty_program_id` (`loyalty_program_id`),
  KEY `user_points_tier_index` (`tier`),
  CONSTRAINT `user_points_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_points_ibfk_2` FOREIGN KEY (`loyalty_program_id`) REFERENCES `loyalty_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_points`
--

LOCK TABLES `user_points` WRITE;
/*!40000 ALTER TABLE `user_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text,
  `phone` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `avatar` text,
  `is_active` int DEFAULT '1',
  `referral_code` varchar(255) DEFAULT NULL,
  `bio` text,
  `parent_id` int DEFAULT NULL,
  `profile_image` text,
  `birth_date` text,
  `address` text,
  `academic_year_id` int DEFAULT NULL,
  `last_login_at` text,
  `remember_token` text,
  `created_at` text,
  `updated_at` text,
  `referred_by` bigint unsigned DEFAULT NULL,
  `referred_at` timestamp NULL DEFAULT NULL,
  `total_referrals` int NOT NULL DEFAULT '0',
  `completed_referrals` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  KEY `users_referral_code_index` (`referral_code`),
  KEY `users_referred_by_index` (`referred_by`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mohammad Hany','admin@techbridge.com','0500000000','$2y$12$ZbX7Xe8mT0gNtZ3PCYhAoOjVNOalyvaaMSw56mDqKPlBNK1PM4P46','super_admin',NULL,1,NULL,NULL,NULL,'profile-photos/7dd52445-58f4-4be9-aa36-4d76c99b09be.jpg',NULL,NULL,NULL,'2025-11-24 19:56:20',NULL,'2025-11-01 23:29:48','2025-11-09 20:28:28',NULL,NULL,0,0),(5,'mohamed hany','codermohamedhany@gmail.com','01203679764','$2y$12$IozkiILUSekgrtBA73HkNej3HAtOTLpGX61gfWuZRK8JURfhXs/0i','student',NULL,1,'REF000005YFU5',NULL,NULL,'profile-photos/29fd3b5f-ba40-4271-96dc-6a1d53be928a.png',NULL,NULL,NULL,'2025-11-24 20:44:12',NULL,'2025-11-09 18:16:45','2025-11-22 01:50:12',NULL,NULL,0,0),(6,'tutor','admin@nexusconnect.com','01044610507','$2y$12$UWvFcfojr8EzRUrRuznv/.LEAkrRKGqaNq1O3IDMbmIkLQGZfvPJ2','instructor',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-11-21 15:25:33',NULL,'2025-11-20 20:44:33','2025-11-20 20:44:33',NULL,NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_tokens`
--

DROP TABLE IF EXISTS `video_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_tokens_token_unique` (`token`),
  KEY `lesson_id` (`lesson_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `video_tokens_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `video_tokens_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_tokens`
--

LOCK TABLES `video_tokens` WRITE;
/*!40000 ALTER TABLE `video_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_watches`
--

DROP TABLE IF EXISTS `video_watches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_watches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `user_id` int NOT NULL,
  `watch_time` int NOT NULL,
  `video_duration` int NOT NULL,
  `progress_percentage` decimal(10,0) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_watches_lesson_id_user_id_unique` (`lesson_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `video_watches_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `video_watches_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_watches`
--

LOCK TABLES `video_watches` WRITE;
/*!40000 ALTER TABLE `video_watches` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_watches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_reports`
--

DROP TABLE IF EXISTS `wallet_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `wallet_id` int NOT NULL,
  `report_month` varchar(255) NOT NULL,
  `opening_balance` decimal(10,0) NOT NULL DEFAULT '0',
  `closing_balance` decimal(10,0) NOT NULL DEFAULT '0',
  `total_deposits` decimal(10,0) NOT NULL DEFAULT '0',
  `total_withdrawals` decimal(10,0) NOT NULL DEFAULT '0',
  `transactions_count` int NOT NULL DEFAULT '0',
  `expected_amounts` text,
  `actual_amounts` text,
  `difference` decimal(10,0) NOT NULL DEFAULT '0',
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_reports_wallet_id_report_month_unique` (`wallet_id`,`report_month`),
  KEY `wallet_reports_report_month_index` (`report_month`),
  CONSTRAINT `wallet_reports_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_reports`
--

LOCK TABLES `wallet_reports` WRITE;
/*!40000 ALTER TABLE `wallet_reports` DISABLE KEYS */;
INSERT INTO `wallet_reports` VALUES (1,1,'2025-11',0,0,0,0,0,NULL,NULL,0,'تقرير عن الفترة من 2025-11-01 إلى 2025-11-22','2025-11-22 02:02:17','2025-11-22 02:02:17');
/*!40000 ALTER TABLE `wallet_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `wallet_id` int NOT NULL,
  `transaction_id` int DEFAULT NULL,
  `type` enum('deposit','withdrawal','refund','commission','bonus','deduction') NOT NULL DEFAULT 'deposit',
  `amount` decimal(10,0) NOT NULL,
  `balance_before` decimal(10,0) NOT NULL,
  `balance_after` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'completed',
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `wallet_transactions_wallet_id_type_status_index` (`wallet_id`,`type`,`status`),
  CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallet_transactions_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('vodafone_cash','instapay','bank_transfer','cash','other') DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_holder` varchar(255) DEFAULT NULL,
  `notes` text,
  `balance` decimal(10,0) NOT NULL DEFAULT '0',
  `pending_balance` decimal(10,0) NOT NULL DEFAULT '0',
  `currency` varchar(255) NOT NULL DEFAULT 'EGP',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_user_id_unique` (`user_id`),
  KEY `wallets_user_id_index` (`user_id`),
  CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,5,'بنك مصر','bank_transfer',NULL,NULL,NULL,NULL,0,0,'EGP',1,'2025-11-14 01:10:47','2025-11-22 02:01:53');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whats_app_messages`
--

DROP TABLE IF EXISTS `whats_app_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whats_app_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `status` enum('pending','sent','delivered','read','failed') NOT NULL DEFAULT 'pending',
  `response_data` text,
  `whatsapp_message_id` varchar(255) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_params` text,
  `error_message` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whats_app_messages_phone_number_status_index` (`phone_number`,`status`),
  KEY `whats_app_messages_user_id_sent_at_index` (`user_id`,`sent_at`),
  CONSTRAINT `whats_app_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whats_app_messages`
--

LOCK TABLES `whats_app_messages` WRITE;
/*!40000 ALTER TABLE `whats_app_messages` DISABLE KEYS */;
INSERT INTO `whats_app_messages` VALUES (1,1,'201203679764','الالال','text','sent','{\"test_mode\":true,\"message\":\"\\u062a\\u0645 \\u0627\\u0644\\u062d\\u0641\\u0638 \\u0641\\u064a \\u0648\\u0636\\u0639 \\u0627\\u0644\\u062a\\u062c\\u0631\\u0628\\u0629\"}',NULL,'2025-11-24 20:36:30',NULL,NULL,NULL,NULL,NULL,'2025-11-24 20:36:30','2025-11-24 20:36:30');
/*!40000 ALTER TABLE `whats_app_messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-24 22:46:20
