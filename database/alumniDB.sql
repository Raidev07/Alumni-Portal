-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: alumniDB
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `alumnidetails`
--

DROP TABLE IF EXISTS `alumnidetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnidetails` (
  `alumni_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_graduated` year(4) NOT NULL,
  PRIMARY KEY (`alumni_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `student_number` (`student_number`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `alumnidetails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alumnidetails_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnidetails`
--

LOCK TABLES `alumnidetails` WRITE;
/*!40000 ALTER TABLE `alumnidetails` DISABLE KEYS */;
INSERT INTO `alumnidetails` VALUES (1,1,'24-00580',1,2024),(3,4,'13-31312',5,2011),(4,5,'12-31231',4,2023),(5,7,'43-44112',7,2032),(6,9,'24-00649',1,2024);
/*!40000 ALTER TABLE `alumnidetails` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_PreventDuplicateAlumni` BEFORE INSERT ON `alumnidetails` FOR EACH ROW BEGIN

    IF EXISTS (SELECT 1 FROM AlumniDetails WHERE student_number = NEW.student_number) THEN

        SIGNAL SQLSTATE '45000'

        SET MESSAGE_TEXT = 'Error: This Student Number is already registered to an alumni account.';

    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_PreventAlumniDetailsUpdate` BEFORE UPDATE ON `alumnidetails` FOR EACH ROW BEGIN



    IF OLD.student_number <> NEW.student_number THEN

        SIGNAL SQLSTATE '45000'

        SET MESSAGE_TEXT = 'Student number cannot be modified.';

    END IF;



    IF OLD.course_id <> NEW.course_id THEN

        SIGNAL SQLSTATE '45000'

        SET MESSAGE_TEXT = 'Course cannot be modified.';

    END IF;



    IF OLD.year_graduated <> NEW.year_graduated THEN

        SIGNAL SQLSTATE '45000'

        SET MESSAGE_TEXT = 'Year graduated cannot be modified.';

    END IF;



END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `alumnifeatured`
--

DROP TABLE IF EXISTS `alumnifeatured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnifeatured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alumni_name` varchar(150) NOT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `year_graduated` year(4) DEFAULT NULL,
  `category` enum('Science & Research','Community Impact','Arts & Culture','Business','Sports','Technology','Gaming','Food and Hospitality','Other') NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnifeatured`
--

LOCK TABLES `alumnifeatured` WRITE;
/*!40000 ALTER TABLE `alumnifeatured` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnifeatured` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_feature_update` AFTER UPDATE ON `alumnifeatured` 
FOR EACH ROW 
BEGIN
    
    IF NEW.title <> OLD.title 
       OR NEW.content <> OLD.content 
       OR NEW.category <> OLD.category THEN
       
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        
        VALUES ('alumnifeatured', NEW.id, 'UPDATE', NULL);
        
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_feature_delete` BEFORE DELETE ON `alumnifeatured` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    
    VALUES ('alumnifeatured', OLD.id, 'DELETE', NULL);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,'userprofile',3,'UPDATE',4,'2026-05-01 11:30:30'),(2,'users',2,'DELETE',NULL,'2026-05-01 14:08:00'),(3,'userprofile',4,'UPDATE',5,'2026-05-03 13:28:31'),(4,'userprofile',4,'UPDATE',5,'2026-05-03 13:55:36'),(5,'userprofile',4,'UPDATE',5,'2026-05-03 13:56:07'),(6,'userprofile',4,'UPDATE',5,'2026-05-03 13:59:42'),(7,'userprofile',4,'UPDATE',5,'2026-05-03 14:01:25'),(8,'userprofile',4,'UPDATE',5,'2026-05-03 14:01:32'),(9,'userprofile',4,'UPDATE',5,'2026-05-03 14:19:49'),(10,'userprofile',4,'UPDATE',5,'2026-05-03 14:21:01'),(11,'userprofile',4,'UPDATE',5,'2026-05-04 01:59:24'),(12,'userprofile',4,'UPDATE',5,'2026-05-04 01:59:27'),(13,'userprofile',4,'UPDATE',5,'2026-05-04 01:59:33'),(14,'userprofile',4,'UPDATE',5,'2026-05-04 01:59:42'),(15,'userprofile',4,'UPDATE',5,'2026-05-04 02:05:18'),(16,'userprofile',4,'UPDATE',5,'2026-05-04 05:52:50'),(17,'userprofile',4,'UPDATE',5,'2026-05-04 05:52:54'),(18,'userprofile',4,'UPDATE',5,'2026-05-04 05:54:05'),(19,'userprofile',4,'UPDATE',5,'2026-05-04 05:59:16'),(20,'userprofile',4,'UPDATE',5,'2026-05-04 05:59:20'),(21,'userprofile',4,'UPDATE',5,'2026-05-04 05:59:42'),(22,'userprofile',4,'UPDATE',5,'2026-05-04 05:59:59'),(23,'userprofile',4,'UPDATE',5,'2026-05-04 06:04:28'),(24,'userprofile',4,'UPDATE',5,'2026-05-04 06:48:53'),(25,'userprofile',4,'UPDATE',5,'2026-05-04 07:23:20'),(26,'userprofile',4,'UPDATE',5,'2026-05-04 07:27:20'),(27,'userprofile',4,'UPDATE',5,'2026-05-04 07:27:28'),(28,'userprofile',4,'UPDATE',5,'2026-05-04 07:28:11'),(29,'userprofile',4,'UPDATE',5,'2026-05-04 07:31:14'),(30,'userprofile',4,'UPDATE',5,'2026-05-04 07:31:20'),(31,'userprofile',4,'UPDATE',5,'2026-05-04 07:32:37'),(32,'userprofile',4,'UPDATE',5,'2026-05-04 07:34:42'),(33,'userprofile',4,'UPDATE',5,'2026-05-04 07:34:49'),(34,'userprofile',4,'UPDATE',5,'2026-05-04 07:40:13'),(35,'userprofile',4,'UPDATE',5,'2026-05-04 07:40:17'),(36,'userprofile',4,'UPDATE',5,'2026-05-04 07:41:47'),(37,'userprofile',4,'UPDATE',5,'2026-05-04 07:41:51'),(38,'userprofile',4,'UPDATE',5,'2026-05-04 07:46:12'),(39,'userprofile',4,'UPDATE',5,'2026-05-04 07:46:34'),(40,'userprofile',4,'UPDATE',5,'2026-05-05 03:22:39'),(41,'userprofile',4,'UPDATE',5,'2026-05-05 03:24:14'),(42,'userprofile',4,'UPDATE',5,'2026-05-05 03:24:25'),(43,'experience',5,'DELETE',9,'2026-05-06 02:05:02'),(44,'education',3,'INSERT',9,'2026-05-06 02:06:08'),(45,'skills',7,'INSERT',9,'2026-05-06 02:08:32'),(46,'skills',7,'DELETE',9,'2026-05-06 02:09:15'),(47,'education',3,'DELETE',9,'2026-05-06 02:09:51');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'Bachelor of Science in Information Technology','BSIT',1),(2,'Bachelor of Science in Computer Science','BSCS',1),(3,'Bachelor of Science in Education Major in English','BSED-ENG',2),(4,'Bachelor of Science in Education Major in Filipino','BSED-FIL',2),(5,'Bachelor of Science in Education Major in Math','BSED-MATH',2),(6,'Bachelor of Science in Nursing','BSN',3),(7,'Bachelor of Science in Engineering','BSE',4),(8,'Bachelor of Science in Hospitality Management','BSHM',5),(9,'Bachelor of Science in Business and Accountancy','BSBA',6),(10,'Bachelor of Science in Psychology','BSP',7);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'CCS'),(2,'COED'),(3,'CON'),(4,'COE'),(5,'CIHM'),(6,'CBA'),(7,'CAS');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `school` varchar(150) NOT NULL,
  `degree` varchar(150) NOT NULL,
  `awards` varchar(150) DEFAULT NULL,
  `start_year` year(4) DEFAULT NULL,
  `end_year` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`edu_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `education_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (2,5,'sd','sd','sd',1902,1905,'2026-05-04 06:37:51');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_insert` AFTER INSERT ON `education` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('education', NEW.edu_id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_update` AFTER UPDATE ON `education` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('education', NEW.edu_id, 'UPDATE', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_delete` BEFORE DELETE ON `education` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('education', OLD.edu_id, 'DELETE', OLD.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_title` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `event_type` enum('Networking','Workshop','Seminar','Reunion') NOT NULL,
  `max_attendees` int(11) DEFAULT NULL,
  `registration_deadline` date DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`event_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,5,'SD','2026-05-04','02:25:00','16:25:00','TA','Workshop',111,'2026-03-10','jay.escalona.je@gmail.com','hello its me text','upcoming','2026-05-05 03:26:03');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_CheckEventDates` BEFORE INSERT ON `events` FOR EACH ROW BEGIN

    IF NEW.registration_deadline > NEW.event_date THEN

        SIGNAL SQLSTATE '45000' 

        SET MESSAGE_TEXT = 'Error: Registration deadline cannot be later than the event date.';

    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_event_insert` AFTER INSERT ON `events` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('events', NEW.event_id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_event_update` AFTER UPDATE ON `events` FOR EACH ROW BEGIN

    

    IF NEW.event_date <> OLD.event_date 

       OR NEW.start_time <> OLD.start_time 

       OR NEW.end_time <> OLD.end_time 

       OR NOT (NEW.registration_deadline <=> OLD.registration_deadline) THEN

       

        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

        VALUES ('events', NEW.event_id, 'UPDATE', NEW.user_id);

        

    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_event_delete` BEFORE DELETE ON `events` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('events', OLD.event_id, 'DELETE', OLD.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `experience`
--

DROP TABLE IF EXISTS `experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experience` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`exp_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience`
--

LOCK TABLES `experience` WRITE;
/*!40000 ALTER TABLE `experience` DISABLE KEYS */;
INSERT INTO `experience` VALUES (1,5,'Software Developers','Rocketech','15-19 Bloomsbury Way, Holborn, London, WC1A 2TH.','2005-07-21','2011-06-14','The Software Engineer is responsible for the complete lifecycle of software development. This role applies engineering principles to design, develop, test, release, and maintain software programs that solve complex business or consumer needs','2026-05-04 02:18:16'),(3,5,'sd','sd','sd','2026-05-19','2026-05-18','sd','2026-05-04 13:17:42'),(4,5,'aya','aya','aya','2026-05-20','2026-05-15','ghost','2026-05-05 03:23:13');
/*!40000 ALTER TABLE `experience` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_insert` AFTER INSERT ON `experience` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('experience', NEW.exp_id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_update` AFTER UPDATE ON `experience` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('experience', NEW.exp_id, 'UPDATE', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_delete` BEFORE DELETE ON `experience` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('experience', OLD.exp_id, 'DELETE', OLD.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `jobpostings`
--

DROP TABLE IF EXISTS `jobpostings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobpostings` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `job_type` enum('Full-time','Part-time','Contract','Internship') NOT NULL,
  `modality` enum('Onsite','Remote','Hybrid') NOT NULL,
  `category` enum('Engineering','Marketing','Product','Theater','Programming','HR','Finance','Design','Operations','Other') NOT NULL,
  `salary_range` varchar(50) DEFAULT NULL,
  `application_link` varchar(255) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `job_description` text NOT NULL,
  `requirements_qualifications` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `status` enum('active','closed','archived') DEFAULT 'active',
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`job_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `jobpostings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobpostings`
--

LOCK TABLES `jobpostings` WRITE;
/*!40000 ALTER TABLE `jobpostings` DISABLE KEYS */;
INSERT INTO `jobpostings` VALUES (1,1,'Job Test','Poh.inc','Pasig City','Full-time','Onsite','Programming','20000','https://youtu.be/Aq5WXmQQooo?si=5Ki5WhNnXJZNeE6V','vehniahsamson@gmail.com','Dapat magaling','8 years of experience 5 years old male','Libre Samgyup araw-araw','active','2026-05-03 10:34:37'),(2,1,'Software Engineer','TectTalk.Inc','Pasig Ortigas Avenue','Full-time','Onsite','Engineering','10,000','https://docs.google.com/spreadsheets/d/1t9q6ugZPIeNdAVjit5rJIxrh1amkz4Udgax2_RoT8AA/edit?gid=0#gid=0','TectTalk@gmail.com','Dapat magaling mag tiktok','Nag titinda ng KangKong Chips','May Insurance sa akin','active','2026-05-03 11:00:47');
/*!40000 ALTER TABLE `jobpostings` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_job_insert` AFTER INSERT ON `jobpostings` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('jobpostings', NEW.job_id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_job_update` AFTER UPDATE ON `jobpostings` FOR EACH ROW BEGIN

    

    IF NEW.modality <> OLD.modality 

       OR NOT (NEW.contact_email <=> OLD.contact_email) THEN

       

        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

        VALUES ('jobpostings', NEW.job_id, 'UPDATE', NEW.user_id);

        

    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_job_delete` BEFORE DELETE ON `jobpostings` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('jobpostings', OLD.job_id, 'DELETE', OLD.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`skill_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (4,5,'ds','2026-05-04 07:49:41'),(5,5,'sd','2026-05-04 13:17:30'),(6,5,'JAVA','2026-05-05 03:23:36');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_insert` AFTER INSERT ON `skills` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('skills', NEW.skill_id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_update` AFTER UPDATE ON `skills` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('skills', NEW.skill_id, 'UPDATE', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_delete` BEFORE DELETE ON `skills` 
FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('skills', OLD.skill_id, 'DELETE', OLD.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userprofile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprofile`
--

LOCK TABLES `userprofile` WRITE;
/*!40000 ALTER TABLE `userprofile` DISABLE KEYS */;
INSERT INTO `userprofile` VALUES (1,1,'Vehniah','Samson','','Perol','09929952041','Callejon 2','2006-09-11','Male',NULL,NULL),(3,4,'Mark Venice','Escalomos','Sr.','Ash','09324424232','hello','2015-10-01','Male',NULL,NULL),(4,5,'John Jesse','Escalona','III','Macuana','09927756044','3078 barangay saksakan st. pasig city','2005-07-07','Male','avatar_5_1777951454.png','HELLO ITS ME KAT BADING'),(5,7,'Mark Venice','Samson','Sr.','Ash','09927756044','tao','2026-03-25','Male',NULL,NULL),(6,9,'Sam Aidan','Gonzaga','','Capalaran','09625928701','Mulawin St.','2005-11-17','Male',NULL,NULL);
/*!40000 ALTER TABLE `userprofile` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_profile_update` AFTER UPDATE ON `userprofile` FOR EACH ROW BEGIN

    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

    VALUES ('userprofile', NEW.profile_id, 'UPDATE', NEW.user_id);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('alumni','admin') NOT NULL,
  `status` enum('active','pending','inactive') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'vehniahsamson11@gmail.com','$2y$10$AVpzAFJ052lgkIMI/1sdS.uJyfq6mI0q/BKLbpXzhk8e2DEPYH.nW','alumni','pending','2026-04-30 14:59:11'),(3,'admin@plpasig.com','$2y$10$fz/M1Ji7xtwDBRDAeL6ptOQHpKXyABKpXe98RsyvdxWUH2ks6ym6O','admin','pending','2026-05-01 01:49:23'),(4,'yehey@gmail.com','$2y$10$1M8eAkVIzDux81flh282ZOFkwjafp0GCD0hE4ZQa.mXuH4g9RimyO','alumni','pending','2026-05-01 01:58:40'),(5,'jay.escalona.je@gmail.com','$2y$10$EbJmsz5mIJSMX73tHb0Xv.RiLinVmW/X3llHsuigjTQBKAgKOoznK','alumni','pending','2026-05-01 14:01:08'),(7,'escalonajj11ictc.bshs2122@gmail.com','$2y$10$ZURJzfW797KNlpCaYSrp..OHOYAT.p/lPDJsZiZjLPzXoVErXVhBK','alumni','pending','2026-05-01 14:11:29'),(9,'samaidangonzaga@gmail.com','$2y$10$Z88Xl62AX87rmzFzwbIXq.pdD/KrXz9mD6tlEbkisdbJXuBav.zgS','alumni','pending','2026-05-03 06:07:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_user_security` AFTER UPDATE ON `users` FOR EACH ROW BEGIN

    

    IF OLD.status <> NEW.status OR OLD.role <> NEW.role THEN

        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

        VALUES ('users', NEW.id, 'UPDATE', NEW.id);

    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_user_delete` BEFORE DELETE ON `users` FOR EACH ROW BEGIN

    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

    VALUES ('users', OLD.id, 'DELETE', OLD.id);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'alumniDB'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `evt_AutomateEventStatus` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = '+00:00' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `evt_AutomateEventStatus` ON SCHEDULE EVERY 15 MINUTE STARTS '2026-04-29 12:11:11' ON COMPLETION PRESERVE ENABLE DO BEGIN

    

    UPDATE events 

    SET status = 'completed' 

    WHERE status NOT IN ('completed', 'cancelled') 

      AND (

          event_date < CURRENT_DATE 

          OR (event_date = CURRENT_DATE AND CURRENT_TIME > end_time)

      );



    

    UPDATE events 

    SET status = 'ongoing' 

    WHERE status = 'upcoming' 

      AND event_date = CURRENT_DATE 

      AND CURRENT_TIME >= start_time 

      AND CURRENT_TIME <= end_time;



    

    UPDATE events 

    SET status = 'upcoming' 

    WHERE status IN ('ongoing', 'completed')

      AND status != 'cancelled'

      AND (

          event_date > CURRENT_DATE 

          OR (event_date = CURRENT_DATE AND CURRENT_TIME < start_time)

      );



END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'alumniDB'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_FilterEvents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_FilterEvents`(IN `p_event_type` VARCHAR(50))
BEGIN

    IF p_event_type = 'All' THEN

        SELECT * FROM Events WHERE status != 'cancelled' ORDER BY event_date ASC;

    ELSE

        SELECT * FROM Events 

        WHERE event_type = p_event_type 

        AND status != 'cancelled' 

        ORDER BY event_date ASC;

    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_FilterJobs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_FilterJobs`(IN `p_type` VARCHAR(50), IN `p_modality` VARCHAR(50))
BEGIN

    SELECT * FROM JobPostings

    WHERE (job_type = p_type OR p_type = 'All')

    AND (modality = p_modality OR p_modality = 'All')

    AND status = 'active'

    ORDER BY posted_at DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetLatestFeature` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLatestFeature`()
BEGIN
    
    SELECT id, title, alumni_name, profession, category, cover_image, excerpt 
    FROM alumnifeatured 
    ORDER BY created_at DESC 
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_RegisterAlumni` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_RegisterAlumni`(IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(255), IN `p_first_name` VARCHAR(50), IN `p_last_name` VARCHAR(50), IN `p_suffix` VARCHAR(10), IN `p_middle_name` VARCHAR(50), IN `p_contact_number` VARCHAR(11), IN `p_address` VARCHAR(255), IN `p_birthdate` DATE, IN `p_gender` ENUM('Male','Female'), IN `p_student_number` VARCHAR(20), IN `p_course_id` INT, IN `p_year_graduated` YEAR)
BEGIN

    DECLARE v_new_user_id INT;



    DECLARE EXIT HANDLER FOR SQLEXCEPTION 

    BEGIN

        ROLLBACK;

        RESIGNAL; 

    END;



    START TRANSACTION;



    

    INSERT INTO users (email, password, role) 

    VALUES (p_email, p_password, 'alumni');



    SET v_new_user_id = LAST_INSERT_ID();



    

    INSERT INTO userprofile (

        user_id, first_name, last_name, suffix, middle_name, 

        contact_number, address, birthdate, gender

    ) 

    VALUES (

        v_new_user_id, p_first_name, p_last_name, p_suffix, p_middle_name, 

        p_contact_number, p_address, p_birthdate, p_gender

    );



    

    INSERT INTO alumnidetails (user_id, student_number, course_id, year_graduated) 

    VALUES (v_new_user_id, p_student_number, p_course_id, p_year_graduated);



    COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_SearchEvents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SearchEvents`(IN `p_query` VARCHAR(100))
BEGIN

    SET @term = CONCAT('%', p_query, '%');

    

    

    SELECT e.*, p.first_name, p.last_name, p.suffix, p.profile_picture 

    FROM Events e

    JOIN UserProfile p ON e.user_id = p.user_id

    WHERE (e.event_title LIKE @term 

       OR e.event_description LIKE @term 

       OR e.location LIKE @term 

       OR e.event_type LIKE @term

       OR p.first_name LIKE @term 

       OR p.last_name LIKE @term 

       OR p.suffix LIKE @term)

    AND e.status != 'cancelled'

    ORDER BY e.event_date ASC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_SearchJobs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SearchJobs`(IN `p_query` VARCHAR(100))
BEGIN

    SET @term = CONCAT('%', p_query, '%');

    SELECT * FROM JobPostings

    WHERE (job_title LIKE @term 

       OR company_name LIKE @term 

       OR job_description LIKE @term 

       OR requirements_qualifications LIKE @term 

       OR benefits LIKE @term 

       OR location LIKE @term 

       OR category LIKE @term)

    AND status = 'active'

    ORDER BY posted_at DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-06 10:26:26
