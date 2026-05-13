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
  `is_archived` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`alumni_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `student_number` (`student_number`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `alumnidetails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alumnidetails_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnidetails`
--

LOCK TABLES `alumnidetails` WRITE;
/*!40000 ALTER TABLE `alumnidetails` DISABLE KEYS */;
INSERT INTO `alumnidetails` VALUES (1,2,'24-00001',1,2024,0),(2,3,'24-00002',3,2023,0),(3,4,'23-84912',1,2023,0),(4,5,'22-10485',9,2022,0),(5,6,'21-95831',7,2021,0),(6,7,'20-38471',6,2020,0),(7,8,'24-57291',2,2024,0),(8,9,'23-19284',10,2023,0),(9,10,'22-84729',8,2022,0),(10,11,'21-29485',5,2021,0),(11,12,'20-73819',1,2020,0),(12,13,'24-48192',3,2024,0),(13,14,'23-69281',9,2023,0),(14,15,'22-18492',6,2022,0),(15,16,'21-59382',7,2021,0),(16,17,'20-83719',10,2020,0),(17,18,'24-29481',2,2024,0),(18,19,'23-10492',8,2023,0),(19,20,'22-74829',4,2022,0),(20,21,'21-48291',9,2021,0),(21,22,'20-95821',1,2020,0),(22,23,'24-10394',6,2024,0),(23,24,'23-68291',7,2023,0),(24,25,'22-39184',10,2022,0),(25,26,'21-74821',2,2021,0),(26,27,'20-29481',8,2020,0),(27,28,'24-85729',5,2024,0),(28,29,'23-19482',9,2023,0),(29,30,'22-48291',1,2022,0),(30,31,'21-95821',6,2021,0),(31,32,'20-38194',7,2020,0),(32,33,'24-68291',10,2024,0),(33,34,'23-29481',2,2023,0),(34,35,'22-10492',8,2022,0),(35,36,'21-85729',3,2021,0),(36,37,'20-48291',9,2020,0),(37,38,'24-95821',1,2024,0),(38,39,'23-38194',6,2023,0),(39,40,'22-68291',7,2022,0),(40,41,'21-29482',10,2021,0),(41,42,'20-10493',2,2020,0),(42,43,'24-85730',8,2024,0),(43,44,'23-48292',4,2023,0),(44,45,'22-95822',9,2022,0),(45,46,'21-38195',1,2021,0),(46,47,'20-68292',6,2020,0),(47,48,'24-29483',7,2024,0),(48,49,'23-10494',10,2023,0),(49,50,'22-85731',2,2022,0),(50,51,'21-48293',8,2021,0),(51,52,'20-95823',5,2020,0),(52,53,'24-38196',9,2024,0),(53,54,'23-68293',1,2023,0),(54,55,'22-29484',6,2022,0),(55,56,'21-10495',7,2021,0),(56,57,'20-85732',10,2020,0),(57,58,'24-48294',2,2024,0),(58,59,'23-95824',8,2023,0),(59,60,'22-38197',3,2022,0),(60,61,'21-68294',9,2021,0),(61,62,'20-29485',1,2020,0),(62,63,'24-10496',6,2024,0),(63,64,'23-85733',7,2023,0),(64,65,'22-48295',10,2022,0),(65,66,'21-95825',2,2021,0),(66,67,'20-38198',8,2020,0),(67,68,'24-68295',4,2024,0),(68,69,'23-29486',9,2023,0),(69,70,'22-10497',1,2022,0),(70,71,'21-85734',6,2021,0),(71,72,'20-48296',7,2020,0),(72,73,'24-95826',10,2024,0),(73,74,'23-38199',2,2023,0),(74,75,'22-68296',8,2022,0),(75,76,'21-29487',5,2021,0),(76,77,'20-10498',9,2020,0),(77,78,'24-85735',1,2024,0),(78,79,'23-48297',6,2023,0),(79,80,'22-95827',7,2022,0),(80,81,'21-38200',10,2021,0),(81,82,'20-68297',2,2020,0),(82,83,'24-29488',8,2024,0),(83,84,'23-10499',3,2023,0),(84,85,'22-85736',9,2022,0),(85,86,'21-48298',1,2021,0),(86,87,'20-95828',6,2020,0),(87,88,'24-38201',7,2024,0),(88,89,'23-68298',10,2023,0),(89,90,'22-29489',2,2022,0),(90,91,'21-10500',8,2021,0),(91,92,'20-85737',4,2020,0),(92,93,'24-48299',9,2024,0),(93,94,'23-95829',1,2023,0),(94,95,'22-38202',6,2022,0),(95,96,'21-68299',7,2021,0),(96,97,'20-29490',10,2020,0),(97,98,'24-10501',2,2024,0),(98,99,'23-85738',8,2023,0);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_AutoVerifyAlumni` AFTER INSERT ON `alumnidetails` FOR EACH ROW BEGIN

    

    IF EXISTS (SELECT 1 FROM graduates WHERE student_number = NEW.student_number) THEN

        

        

        UPDATE users SET status = 'active' WHERE id = NEW.user_id;

        

        

        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)

        VALUES ('users', NEW.user_id, 'UPDATE', NEW.user_id);

        

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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_alumnidetails_insert` AFTER INSERT ON `alumnidetails` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('alumnidetails', NEW.alumni_id, 'INSERT', NEW.user_id);
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

IF @is_admin IS NULL OR @is_admin = 0 THEN

IF OLD.student_number <> NEW.student_number THEN

SIGNAL SQLSTATE '45000'

SET MESSAGE_TEXT = 'STUDENT NUMBER CONNOT BE MODEFIED.';

END IF;

IF OLD.course_id <> NEW.course_id THEN            SIGNAL SQLSTATE '45000'            SET MESSAGE_TEXT = 'Course cannot be modified.';        END IF;        IF OLD.year_graduated <> NEW.year_graduated THEN            SIGNAL SQLSTATE '45000'            SET MESSAGE_TEXT = 'Year graduated cannot be modified.';        END IF;    END IF;

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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_alumnidetails_delete` BEFORE DELETE ON `alumnidetails` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('alumnidetails', OLD.alumni_id, 'DELETE', OLD.user_id);
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
  `year_graduated` year(4) DEFAULT NULL,
  `category` enum('Science & Research','Community Impact','Arts & Culture','Business','Sports','Technology','Gaming','Food and Hospitality','Other') NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_featured_user` (`user_id`),
  CONSTRAINT `fk_featured_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnifeatured`
--

LOCK TABLES `alumnifeatured` WRITE;
/*!40000 ALTER TABLE `alumnifeatured` DISABLE KEYS */;
INSERT INTO `alumnifeatured` VALUES (1,'Heart of a Healer: Championing Patient Care on the Frontlines','Alyssa Villanueva Reyes',2023,'Community Impact','uploads/stories/6a049037f019b_Nursing.jpg','From surviving grueling clinical rotations at PLP to leading emergency response teams, Clara Mendoza shares her inspiring journey as a dedicated public health nurse','When Alyssa Villanueva Reyes first put on her white uniform at the Pamantasan ng Lungsod ng Pasig (PLP) College of Nursing, she knew the journey ahead would be anything but easy. Balancing sleepless nights of memorizing anatomy with physically demanding clinical duties at local health centers, Alyssa developed a deep sense of resilience and grit.','2026-05-13 14:48:25',39),(2,'Coding the Future: From PLP Computer Labs to Tech Leadership','Tomas Garcia Cruz Sr',2023,'Technology','uploads/stories/6a0490fd86919_IT.jpg','Discover how Tomas Garcia Cruz Sr went from debugging capstone projects in PLP\'s computer labs to leading a major software development team at a top tech firm.','Tomas Garcia Cruz Sr spent most of his college nights illuminated by the glow of a computer monitor. As a student at the Pamantasan ng Lungsod ng Pasig (PLP) College of Computer Studies, his days were fueled by coffee, complex algorithms, and the constant pursuit of tracking down missing semicolons in his code.','2026-05-13 14:55:57',54),(3,'Engineering the Intelligent Tomorrow: From Algorithm Optimization to Scalable Distributed Systems and ML','Danilo Garcia Cruz',2020,'Technology','uploads/stories/6a04925672459_BSCS.jpg','Explore how Danilo Garcia Cruz leveraged his profound love for algorithmic thinking and rigorous PLP Computer Science training to secure an impactful engineering role at a leading global technology firm, designing solutions for millions.','Danilo Garcia Cruz was never one to settle for merely functional code. As a Computer Science (BSCS) student at the Pamantasan ng Lungsod ng Pasig (PLP) College of Computer Studies, he thrived on theoretical challenges, spending countless nights optimizing algorithms and often leading his team in algorithmic problem-solving during coding competitions. For Mateo, the PLP computer labs were hubs of collaborative innovation and relentless debugging.','2026-05-13 15:01:42',82);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_feature_insert` AFTER INSERT ON `alumnifeatured` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('alumnifeatured', NEW.id, 'INSERT', NEW.user_id);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_feature_update` AFTER UPDATE ON `alumnifeatured` FOR EACH ROW BEGIN



    



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_feature_delete` BEFORE DELETE ON `alumnifeatured` FOR EACH ROW BEGIN



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
) ENGINE=InnoDB AUTO_INCREMENT=326 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,'users',1,'INSERT',1,'2026-05-13 03:53:50'),(2,'users',1,'UPDATE',1,'2026-05-13 03:54:48'),(3,'users',2,'INSERT',2,'2026-05-13 03:55:27'),(4,'userprofile',1,'INSERT',2,'2026-05-13 03:55:27'),(5,'alumnidetails',1,'INSERT',2,'2026-05-13 03:55:27'),(6,'users',3,'INSERT',3,'2026-05-13 03:55:27'),(7,'userprofile',2,'INSERT',3,'2026-05-13 03:55:27'),(8,'alumnidetails',2,'INSERT',3,'2026-05-13 03:55:27'),(9,'users',4,'INSERT',4,'2026-05-13 03:55:27'),(10,'userprofile',3,'INSERT',4,'2026-05-13 03:55:27'),(11,'alumnidetails',3,'INSERT',4,'2026-05-13 03:55:27'),(12,'users',5,'INSERT',5,'2026-05-13 03:55:27'),(13,'userprofile',4,'INSERT',5,'2026-05-13 03:55:27'),(14,'alumnidetails',4,'INSERT',5,'2026-05-13 03:55:27'),(15,'users',6,'INSERT',6,'2026-05-13 03:55:27'),(16,'userprofile',5,'INSERT',6,'2026-05-13 03:55:27'),(17,'alumnidetails',5,'INSERT',6,'2026-05-13 03:55:27'),(18,'users',7,'INSERT',7,'2026-05-13 03:55:27'),(19,'userprofile',6,'INSERT',7,'2026-05-13 03:55:27'),(20,'alumnidetails',6,'INSERT',7,'2026-05-13 03:55:27'),(21,'users',8,'INSERT',8,'2026-05-13 03:55:27'),(22,'userprofile',7,'INSERT',8,'2026-05-13 03:55:27'),(23,'alumnidetails',7,'INSERT',8,'2026-05-13 03:55:27'),(24,'users',9,'INSERT',9,'2026-05-13 03:55:27'),(25,'userprofile',8,'INSERT',9,'2026-05-13 03:55:27'),(26,'alumnidetails',8,'INSERT',9,'2026-05-13 03:55:27'),(27,'users',10,'INSERT',10,'2026-05-13 03:55:27'),(28,'userprofile',9,'INSERT',10,'2026-05-13 03:55:27'),(29,'alumnidetails',9,'INSERT',10,'2026-05-13 03:55:27'),(30,'users',11,'INSERT',11,'2026-05-13 03:55:28'),(31,'userprofile',10,'INSERT',11,'2026-05-13 03:55:28'),(32,'alumnidetails',10,'INSERT',11,'2026-05-13 03:55:28'),(33,'users',12,'INSERT',12,'2026-05-13 03:55:28'),(34,'userprofile',11,'INSERT',12,'2026-05-13 03:55:28'),(35,'alumnidetails',11,'INSERT',12,'2026-05-13 03:55:28'),(36,'users',13,'INSERT',13,'2026-05-13 03:55:28'),(37,'userprofile',12,'INSERT',13,'2026-05-13 03:55:28'),(38,'alumnidetails',12,'INSERT',13,'2026-05-13 03:55:28'),(39,'users',14,'INSERT',14,'2026-05-13 03:55:28'),(40,'userprofile',13,'INSERT',14,'2026-05-13 03:55:28'),(41,'alumnidetails',13,'INSERT',14,'2026-05-13 03:55:28'),(42,'users',15,'INSERT',15,'2026-05-13 03:55:28'),(43,'userprofile',14,'INSERT',15,'2026-05-13 03:55:28'),(44,'alumnidetails',14,'INSERT',15,'2026-05-13 03:55:28'),(45,'users',16,'INSERT',16,'2026-05-13 03:55:28'),(46,'userprofile',15,'INSERT',16,'2026-05-13 03:55:28'),(47,'alumnidetails',15,'INSERT',16,'2026-05-13 03:55:28'),(48,'users',17,'INSERT',17,'2026-05-13 03:55:28'),(49,'userprofile',16,'INSERT',17,'2026-05-13 03:55:28'),(50,'alumnidetails',16,'INSERT',17,'2026-05-13 03:55:28'),(51,'users',18,'INSERT',18,'2026-05-13 03:55:28'),(52,'userprofile',17,'INSERT',18,'2026-05-13 03:55:28'),(53,'alumnidetails',17,'INSERT',18,'2026-05-13 03:55:28'),(54,'users',19,'INSERT',19,'2026-05-13 03:55:28'),(55,'userprofile',18,'INSERT',19,'2026-05-13 03:55:28'),(56,'alumnidetails',18,'INSERT',19,'2026-05-13 03:55:28'),(57,'users',20,'INSERT',20,'2026-05-13 03:55:28'),(58,'userprofile',19,'INSERT',20,'2026-05-13 03:55:28'),(59,'alumnidetails',19,'INSERT',20,'2026-05-13 03:55:28'),(60,'users',21,'INSERT',21,'2026-05-13 03:55:28'),(61,'userprofile',20,'INSERT',21,'2026-05-13 03:55:28'),(62,'alumnidetails',20,'INSERT',21,'2026-05-13 03:55:28'),(63,'users',22,'INSERT',22,'2026-05-13 03:55:29'),(64,'userprofile',21,'INSERT',22,'2026-05-13 03:55:29'),(65,'alumnidetails',21,'INSERT',22,'2026-05-13 03:55:29'),(66,'users',23,'INSERT',23,'2026-05-13 03:55:29'),(67,'userprofile',22,'INSERT',23,'2026-05-13 03:55:29'),(68,'alumnidetails',22,'INSERT',23,'2026-05-13 03:55:29'),(69,'users',24,'INSERT',24,'2026-05-13 03:55:29'),(70,'userprofile',23,'INSERT',24,'2026-05-13 03:55:29'),(71,'alumnidetails',23,'INSERT',24,'2026-05-13 03:55:29'),(72,'users',25,'INSERT',25,'2026-05-13 03:55:29'),(73,'userprofile',24,'INSERT',25,'2026-05-13 03:55:29'),(74,'alumnidetails',24,'INSERT',25,'2026-05-13 03:55:29'),(75,'users',26,'INSERT',26,'2026-05-13 03:55:29'),(76,'userprofile',25,'INSERT',26,'2026-05-13 03:55:29'),(77,'alumnidetails',25,'INSERT',26,'2026-05-13 03:55:29'),(78,'users',27,'INSERT',27,'2026-05-13 03:55:29'),(79,'userprofile',26,'INSERT',27,'2026-05-13 03:55:29'),(80,'alumnidetails',26,'INSERT',27,'2026-05-13 03:55:29'),(81,'users',28,'INSERT',28,'2026-05-13 03:55:29'),(82,'userprofile',27,'INSERT',28,'2026-05-13 03:55:29'),(83,'alumnidetails',27,'INSERT',28,'2026-05-13 03:55:29'),(84,'users',29,'INSERT',29,'2026-05-13 03:55:29'),(85,'userprofile',28,'INSERT',29,'2026-05-13 03:55:29'),(86,'alumnidetails',28,'INSERT',29,'2026-05-13 03:55:29'),(87,'users',30,'INSERT',30,'2026-05-13 03:55:29'),(88,'userprofile',29,'INSERT',30,'2026-05-13 03:55:29'),(89,'alumnidetails',29,'INSERT',30,'2026-05-13 03:55:29'),(90,'users',31,'INSERT',31,'2026-05-13 03:55:29'),(91,'userprofile',30,'INSERT',31,'2026-05-13 03:55:29'),(92,'alumnidetails',30,'INSERT',31,'2026-05-13 03:55:29'),(93,'users',32,'INSERT',32,'2026-05-13 03:55:29'),(94,'userprofile',31,'INSERT',32,'2026-05-13 03:55:29'),(95,'alumnidetails',31,'INSERT',32,'2026-05-13 03:55:29'),(96,'users',33,'INSERT',33,'2026-05-13 03:55:30'),(97,'userprofile',32,'INSERT',33,'2026-05-13 03:55:30'),(98,'alumnidetails',32,'INSERT',33,'2026-05-13 03:55:30'),(99,'users',34,'INSERT',34,'2026-05-13 03:55:30'),(100,'userprofile',33,'INSERT',34,'2026-05-13 03:55:30'),(101,'alumnidetails',33,'INSERT',34,'2026-05-13 03:55:30'),(102,'users',35,'INSERT',35,'2026-05-13 03:55:30'),(103,'userprofile',34,'INSERT',35,'2026-05-13 03:55:30'),(104,'alumnidetails',34,'INSERT',35,'2026-05-13 03:55:30'),(105,'users',36,'INSERT',36,'2026-05-13 03:55:30'),(106,'userprofile',35,'INSERT',36,'2026-05-13 03:55:30'),(107,'alumnidetails',35,'INSERT',36,'2026-05-13 03:55:30'),(108,'users',37,'INSERT',37,'2026-05-13 03:55:30'),(109,'userprofile',36,'INSERT',37,'2026-05-13 03:55:30'),(110,'alumnidetails',36,'INSERT',37,'2026-05-13 03:55:30'),(111,'users',38,'INSERT',38,'2026-05-13 03:55:30'),(112,'userprofile',37,'INSERT',38,'2026-05-13 03:55:30'),(113,'alumnidetails',37,'INSERT',38,'2026-05-13 03:55:30'),(114,'users',39,'INSERT',39,'2026-05-13 03:55:30'),(115,'userprofile',38,'INSERT',39,'2026-05-13 03:55:30'),(116,'alumnidetails',38,'INSERT',39,'2026-05-13 03:55:30'),(117,'users',40,'INSERT',40,'2026-05-13 03:55:30'),(118,'userprofile',39,'INSERT',40,'2026-05-13 03:55:30'),(119,'alumnidetails',39,'INSERT',40,'2026-05-13 03:55:30'),(120,'users',41,'INSERT',41,'2026-05-13 03:55:30'),(121,'userprofile',40,'INSERT',41,'2026-05-13 03:55:30'),(122,'alumnidetails',40,'INSERT',41,'2026-05-13 03:55:30'),(123,'users',42,'INSERT',42,'2026-05-13 03:55:30'),(124,'userprofile',41,'INSERT',42,'2026-05-13 03:55:30'),(125,'alumnidetails',41,'INSERT',42,'2026-05-13 03:55:30'),(126,'users',43,'INSERT',43,'2026-05-13 03:55:30'),(127,'userprofile',42,'INSERT',43,'2026-05-13 03:55:30'),(128,'alumnidetails',42,'INSERT',43,'2026-05-13 03:55:30'),(129,'users',44,'INSERT',44,'2026-05-13 03:55:30'),(130,'userprofile',43,'INSERT',44,'2026-05-13 03:55:30'),(131,'alumnidetails',43,'INSERT',44,'2026-05-13 03:55:31'),(132,'users',45,'INSERT',45,'2026-05-13 03:55:31'),(133,'userprofile',44,'INSERT',45,'2026-05-13 03:55:31'),(134,'alumnidetails',44,'INSERT',45,'2026-05-13 03:55:31'),(135,'users',46,'INSERT',46,'2026-05-13 03:55:31'),(136,'userprofile',45,'INSERT',46,'2026-05-13 03:55:31'),(137,'alumnidetails',45,'INSERT',46,'2026-05-13 03:55:31'),(138,'users',47,'INSERT',47,'2026-05-13 03:55:31'),(139,'userprofile',46,'INSERT',47,'2026-05-13 03:55:31'),(140,'alumnidetails',46,'INSERT',47,'2026-05-13 03:55:31'),(141,'users',48,'INSERT',48,'2026-05-13 03:55:31'),(142,'userprofile',47,'INSERT',48,'2026-05-13 03:55:31'),(143,'alumnidetails',47,'INSERT',48,'2026-05-13 03:55:31'),(144,'users',49,'INSERT',49,'2026-05-13 03:55:31'),(145,'userprofile',48,'INSERT',49,'2026-05-13 03:55:31'),(146,'alumnidetails',48,'INSERT',49,'2026-05-13 03:55:31'),(147,'users',50,'INSERT',50,'2026-05-13 03:55:31'),(148,'userprofile',49,'INSERT',50,'2026-05-13 03:55:31'),(149,'alumnidetails',49,'INSERT',50,'2026-05-13 03:55:31'),(150,'users',51,'INSERT',51,'2026-05-13 03:55:31'),(151,'userprofile',50,'INSERT',51,'2026-05-13 03:55:31'),(152,'alumnidetails',50,'INSERT',51,'2026-05-13 03:55:31'),(153,'users',52,'INSERT',52,'2026-05-13 03:55:31'),(154,'userprofile',51,'INSERT',52,'2026-05-13 03:55:31'),(155,'alumnidetails',51,'INSERT',52,'2026-05-13 03:55:31'),(156,'users',53,'INSERT',53,'2026-05-13 03:55:31'),(157,'userprofile',52,'INSERT',53,'2026-05-13 03:55:31'),(158,'alumnidetails',52,'INSERT',53,'2026-05-13 03:55:31'),(159,'users',54,'INSERT',54,'2026-05-13 03:55:31'),(160,'userprofile',53,'INSERT',54,'2026-05-13 03:55:31'),(161,'alumnidetails',53,'INSERT',54,'2026-05-13 03:55:31'),(162,'users',55,'INSERT',55,'2026-05-13 03:55:31'),(163,'userprofile',54,'INSERT',55,'2026-05-13 03:55:31'),(164,'alumnidetails',54,'INSERT',55,'2026-05-13 03:55:31'),(165,'users',56,'INSERT',56,'2026-05-13 03:55:32'),(166,'userprofile',55,'INSERT',56,'2026-05-13 03:55:32'),(167,'alumnidetails',55,'INSERT',56,'2026-05-13 03:55:32'),(168,'users',57,'INSERT',57,'2026-05-13 03:55:32'),(169,'userprofile',56,'INSERT',57,'2026-05-13 03:55:32'),(170,'alumnidetails',56,'INSERT',57,'2026-05-13 03:55:32'),(171,'users',58,'INSERT',58,'2026-05-13 03:55:32'),(172,'userprofile',57,'INSERT',58,'2026-05-13 03:55:32'),(173,'alumnidetails',57,'INSERT',58,'2026-05-13 03:55:32'),(174,'users',59,'INSERT',59,'2026-05-13 03:55:32'),(175,'userprofile',58,'INSERT',59,'2026-05-13 03:55:32'),(176,'alumnidetails',58,'INSERT',59,'2026-05-13 03:55:32'),(177,'users',60,'INSERT',60,'2026-05-13 03:55:32'),(178,'userprofile',59,'INSERT',60,'2026-05-13 03:55:32'),(179,'alumnidetails',59,'INSERT',60,'2026-05-13 03:55:32'),(180,'users',61,'INSERT',61,'2026-05-13 03:55:32'),(181,'userprofile',60,'INSERT',61,'2026-05-13 03:55:32'),(182,'alumnidetails',60,'INSERT',61,'2026-05-13 03:55:32'),(183,'users',62,'INSERT',62,'2026-05-13 03:55:32'),(184,'userprofile',61,'INSERT',62,'2026-05-13 03:55:32'),(185,'alumnidetails',61,'INSERT',62,'2026-05-13 03:55:32'),(186,'users',63,'INSERT',63,'2026-05-13 03:55:32'),(187,'userprofile',62,'INSERT',63,'2026-05-13 03:55:32'),(188,'alumnidetails',62,'INSERT',63,'2026-05-13 03:55:32'),(189,'users',64,'INSERT',64,'2026-05-13 03:55:32'),(190,'userprofile',63,'INSERT',64,'2026-05-13 03:55:32'),(191,'alumnidetails',63,'INSERT',64,'2026-05-13 03:55:32'),(192,'users',65,'INSERT',65,'2026-05-13 03:55:32'),(193,'userprofile',64,'INSERT',65,'2026-05-13 03:55:32'),(194,'alumnidetails',64,'INSERT',65,'2026-05-13 03:55:32'),(195,'users',66,'INSERT',66,'2026-05-13 03:55:32'),(196,'userprofile',65,'INSERT',66,'2026-05-13 03:55:32'),(197,'alumnidetails',65,'INSERT',66,'2026-05-13 03:55:32'),(198,'users',67,'INSERT',67,'2026-05-13 03:55:33'),(199,'userprofile',66,'INSERT',67,'2026-05-13 03:55:33'),(200,'alumnidetails',66,'INSERT',67,'2026-05-13 03:55:33'),(201,'users',68,'INSERT',68,'2026-05-13 03:55:33'),(202,'userprofile',67,'INSERT',68,'2026-05-13 03:55:33'),(203,'alumnidetails',67,'INSERT',68,'2026-05-13 03:55:33'),(204,'users',69,'INSERT',69,'2026-05-13 03:55:33'),(205,'userprofile',68,'INSERT',69,'2026-05-13 03:55:33'),(206,'alumnidetails',68,'INSERT',69,'2026-05-13 03:55:33'),(207,'users',70,'INSERT',70,'2026-05-13 03:55:33'),(208,'userprofile',69,'INSERT',70,'2026-05-13 03:55:33'),(209,'alumnidetails',69,'INSERT',70,'2026-05-13 03:55:33'),(210,'users',71,'INSERT',71,'2026-05-13 03:55:33'),(211,'userprofile',70,'INSERT',71,'2026-05-13 03:55:33'),(212,'alumnidetails',70,'INSERT',71,'2026-05-13 03:55:33'),(213,'users',72,'INSERT',72,'2026-05-13 03:55:33'),(214,'userprofile',71,'INSERT',72,'2026-05-13 03:55:33'),(215,'alumnidetails',71,'INSERT',72,'2026-05-13 03:55:33'),(216,'users',73,'INSERT',73,'2026-05-13 03:55:33'),(217,'userprofile',72,'INSERT',73,'2026-05-13 03:55:33'),(218,'alumnidetails',72,'INSERT',73,'2026-05-13 03:55:33'),(219,'users',74,'INSERT',74,'2026-05-13 03:55:33'),(220,'userprofile',73,'INSERT',74,'2026-05-13 03:55:33'),(221,'alumnidetails',73,'INSERT',74,'2026-05-13 03:55:33'),(222,'users',75,'INSERT',75,'2026-05-13 03:55:33'),(223,'userprofile',74,'INSERT',75,'2026-05-13 03:55:33'),(224,'alumnidetails',74,'INSERT',75,'2026-05-13 03:55:33'),(225,'users',76,'INSERT',76,'2026-05-13 03:55:33'),(226,'userprofile',75,'INSERT',76,'2026-05-13 03:55:33'),(227,'alumnidetails',75,'INSERT',76,'2026-05-13 03:55:33'),(228,'users',77,'INSERT',77,'2026-05-13 03:55:33'),(229,'userprofile',76,'INSERT',77,'2026-05-13 03:55:33'),(230,'alumnidetails',76,'INSERT',77,'2026-05-13 03:55:33'),(231,'users',78,'INSERT',78,'2026-05-13 03:55:33'),(232,'userprofile',77,'INSERT',78,'2026-05-13 03:55:33'),(233,'alumnidetails',77,'INSERT',78,'2026-05-13 03:55:33'),(234,'users',79,'INSERT',79,'2026-05-13 03:55:33'),(235,'userprofile',78,'INSERT',79,'2026-05-13 03:55:34'),(236,'alumnidetails',78,'INSERT',79,'2026-05-13 03:55:34'),(237,'users',80,'INSERT',80,'2026-05-13 03:55:34'),(238,'userprofile',79,'INSERT',80,'2026-05-13 03:55:34'),(239,'alumnidetails',79,'INSERT',80,'2026-05-13 03:55:34'),(240,'users',81,'INSERT',81,'2026-05-13 03:55:34'),(241,'userprofile',80,'INSERT',81,'2026-05-13 03:55:34'),(242,'alumnidetails',80,'INSERT',81,'2026-05-13 03:55:34'),(243,'users',82,'INSERT',82,'2026-05-13 03:55:34'),(244,'userprofile',81,'INSERT',82,'2026-05-13 03:55:34'),(245,'alumnidetails',81,'INSERT',82,'2026-05-13 03:55:34'),(246,'users',83,'INSERT',83,'2026-05-13 03:55:34'),(247,'userprofile',82,'INSERT',83,'2026-05-13 03:55:34'),(248,'alumnidetails',82,'INSERT',83,'2026-05-13 03:55:34'),(249,'users',84,'INSERT',84,'2026-05-13 03:55:34'),(250,'userprofile',83,'INSERT',84,'2026-05-13 03:55:34'),(251,'alumnidetails',83,'INSERT',84,'2026-05-13 03:55:34'),(252,'users',85,'INSERT',85,'2026-05-13 03:55:34'),(253,'userprofile',84,'INSERT',85,'2026-05-13 03:55:34'),(254,'alumnidetails',84,'INSERT',85,'2026-05-13 03:55:34'),(255,'users',86,'INSERT',86,'2026-05-13 03:55:34'),(256,'userprofile',85,'INSERT',86,'2026-05-13 03:55:34'),(257,'alumnidetails',85,'INSERT',86,'2026-05-13 03:55:34'),(258,'users',87,'INSERT',87,'2026-05-13 03:55:34'),(259,'userprofile',86,'INSERT',87,'2026-05-13 03:55:34'),(260,'alumnidetails',86,'INSERT',87,'2026-05-13 03:55:34'),(261,'users',88,'INSERT',88,'2026-05-13 03:55:34'),(262,'userprofile',87,'INSERT',88,'2026-05-13 03:55:34'),(263,'alumnidetails',87,'INSERT',88,'2026-05-13 03:55:34'),(264,'users',89,'INSERT',89,'2026-05-13 03:55:34'),(265,'userprofile',88,'INSERT',89,'2026-05-13 03:55:34'),(266,'alumnidetails',88,'INSERT',89,'2026-05-13 03:55:34'),(267,'users',90,'INSERT',90,'2026-05-13 03:55:35'),(268,'userprofile',89,'INSERT',90,'2026-05-13 03:55:35'),(269,'alumnidetails',89,'INSERT',90,'2026-05-13 03:55:35'),(270,'users',91,'INSERT',91,'2026-05-13 03:55:35'),(271,'userprofile',90,'INSERT',91,'2026-05-13 03:55:35'),(272,'alumnidetails',90,'INSERT',91,'2026-05-13 03:55:35'),(273,'users',92,'INSERT',92,'2026-05-13 03:55:35'),(274,'userprofile',91,'INSERT',92,'2026-05-13 03:55:35'),(275,'alumnidetails',91,'INSERT',92,'2026-05-13 03:55:35'),(276,'users',93,'INSERT',93,'2026-05-13 03:55:35'),(277,'userprofile',92,'INSERT',93,'2026-05-13 03:55:35'),(278,'alumnidetails',92,'INSERT',93,'2026-05-13 03:55:35'),(279,'users',94,'INSERT',94,'2026-05-13 03:55:35'),(280,'userprofile',93,'INSERT',94,'2026-05-13 03:55:35'),(281,'alumnidetails',93,'INSERT',94,'2026-05-13 03:55:35'),(282,'users',95,'INSERT',95,'2026-05-13 03:55:35'),(283,'userprofile',94,'INSERT',95,'2026-05-13 03:55:35'),(284,'alumnidetails',94,'INSERT',95,'2026-05-13 03:55:35'),(285,'users',96,'INSERT',96,'2026-05-13 03:55:35'),(286,'userprofile',95,'INSERT',96,'2026-05-13 03:55:35'),(287,'alumnidetails',95,'INSERT',96,'2026-05-13 03:55:35'),(288,'users',97,'INSERT',97,'2026-05-13 03:55:35'),(289,'userprofile',96,'INSERT',97,'2026-05-13 03:55:35'),(290,'alumnidetails',96,'INSERT',97,'2026-05-13 03:55:35'),(291,'users',98,'INSERT',98,'2026-05-13 03:55:35'),(292,'userprofile',97,'INSERT',98,'2026-05-13 03:55:35'),(293,'alumnidetails',97,'INSERT',98,'2026-05-13 03:55:35'),(294,'users',99,'INSERT',99,'2026-05-13 03:55:35'),(295,'userprofile',98,'INSERT',99,'2026-05-13 03:55:35'),(296,'alumnidetails',98,'INSERT',99,'2026-05-13 03:55:35'),(297,'recovery_requests',1,'INSERT',38,'2026-05-13 03:57:46'),(298,'users',38,'UPDATE',38,'2026-05-13 03:58:21'),(299,'recovery_requests',1,'UPDATE',38,'2026-05-13 03:58:21'),(300,'jobpostings',1,'INSERT',93,'2026-05-13 04:14:57'),(301,'jobpostings',2,'INSERT',4,'2026-05-13 04:22:12'),(302,'jobpostings',3,'INSERT',63,'2026-05-13 04:26:31'),(303,'jobpostings',4,'INSERT',8,'2026-05-13 04:33:22'),(304,'jobpostings',5,'INSERT',13,'2026-05-13 04:44:10'),(305,'jobpostings',6,'INSERT',16,'2026-05-13 04:46:54'),(306,'jobpostings',7,'INSERT',19,'2026-05-13 04:49:52'),(307,'jobpostings',8,'INSERT',17,'2026-05-13 04:51:39'),(308,'jobpostings',9,'INSERT',11,'2026-05-13 04:53:33'),(309,'jobpostings',10,'INSERT',47,'2026-05-13 04:59:51'),(310,'users',47,'UPDATE',47,'2026-05-13 07:21:36'),(311,'users',47,'UPDATE',47,'2026-05-13 07:21:45'),(312,'tickets',1,'INSERT',47,'2026-05-13 07:28:38'),(313,'ticket_replies',1,'INSERT',47,'2026-05-13 07:28:38'),(314,'users',93,'UPDATE',93,'2026-05-13 07:45:45'),(315,'users',93,'UPDATE',93,'2026-05-13 07:47:23'),(316,'events',1,'INSERT',7,'2026-05-13 14:14:47'),(317,'events',2,'INSERT',15,'2026-05-13 14:18:18'),(318,'events',3,'INSERT',27,'2026-05-13 14:26:19'),(319,'events',4,'INSERT',39,'2026-05-13 14:29:25'),(320,'events',5,'INSERT',29,'2026-05-13 14:36:23'),(321,'alumnifeatured',1,'INSERT',39,'2026-05-13 14:48:25'),(322,'alumnifeatured',2,'INSERT',54,'2026-05-13 14:55:57'),(323,'alumnifeatured',2,'UPDATE',NULL,'2026-05-13 14:56:31'),(324,'alumnifeatured',1,'UPDATE',NULL,'2026-05-13 14:57:07'),(325,'alumnifeatured',3,'INSERT',82,'2026-05-13 15:01:42');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_codes`
--

DROP TABLE IF EXISTS `backup_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `backup_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_codes`
--

LOCK TABLES `backup_codes` WRITE;
/*!40000 ALTER TABLE `backup_codes` DISABLE KEYS */;
INSERT INTO `backup_codes` VALUES (1,47,'F3FA886F',0,'2026-05-13 07:19:44'),(2,47,'40A66D53',0,'2026-05-13 07:19:44'),(3,47,'05C286AA',0,'2026-05-13 07:19:44'),(4,47,'1781C45A',0,'2026-05-13 07:19:44'),(5,47,'FB63A28E',0,'2026-05-13 07:19:44');
/*!40000 ALTER TABLE `backup_codes` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_backup_codes_update` AFTER UPDATE ON `backup_codes` FOR EACH ROW 
BEGIN
    IF OLD.used <> NEW.used THEN
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('backup_codes', NEW.id, 'UPDATE', NEW.user_id);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_insert` AFTER INSERT ON `education` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_update` AFTER UPDATE ON `education` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_education_delete` BEFORE DELETE ON `education` FOR EACH ROW BEGIN



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,7,'FinTech Innovators Hackathon 2026','2026-08-15','08:00:00','20:00:00','Maya Philippines HQ, BGC Taguig','Workshop',150,'2026-08-01','hackathon@maya.ph','Join us for a 12-hour intense hackathon focused on building the next generation of financial technology! Open to all developers, UI/UX designers, and product managers. Food, swag, and cash prizes included.','upcoming','2026-05-13 14:14:47'),(2,15,'AWS Cloud Practitioner Boot Camp','2026-07-10','09:00:00','16:00:00','Online (Zoom)','Seminar',500,'2026-07-05','training@aws.amazon.com','A free, full-day virtual seminar hosted by Amazon Web Services. Learn the fundamentals of cloud computing and prepare for your AWS Certified Cloud Practitioner exam.','upcoming','2026-05-13 14:18:18'),(3,27,'Manila Tech Founders & Investors Mixer','2026-09-20','19:00:00','22:00:00','The Astbury, Poblacion Makati','Networking',80,'2026-09-15','events@startupph.org','An exclusive evening for startup founders, venture capitalists, and tech professionals to connect over drinks. Bring your business cards and your best elevator pitch!','upcoming','2026-05-13 14:26:19'),(4,39,'Global Health Innovations Summit','2026-10-05','08:00:00','17:00:00','Shangri-La The Fort, BGC','Seminar',300,'2026-09-25','summit@stlukes.com.ph','St. Luke\'s Medical Center invites all healthcare professionals to discuss the future of AI in diagnostics, telemedicine breakthroughs, and post-pandemic care protocols.','upcoming','2026-05-13 14:29:25'),(5,29,'Masterclass: Viral TikTok Marketing','2026-06-30','13:00:00','17:00:00','Ogilvy Manila Office, Ortigas','Workshop',40,'2026-06-20','masterclass@ogilvy.com','A hands-on workshop led by top creative directors on how to build brand presence, script short-form videos, and leverage TikTok\'s algorithm for corporate marketing.','upcoming','2026-05-13 14:36:23');
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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_event_insert` AFTER INSERT ON `events` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_event_delete` BEFORE DELETE ON `events` FOR EACH ROW BEGIN



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience`
--

LOCK TABLES `experience` WRITE;
/*!40000 ALTER TABLE `experience` DISABLE KEYS */;
/*!40000 ALTER TABLE `experience` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_insert` AFTER INSERT ON `experience` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_update` AFTER UPDATE ON `experience` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_experience_delete` BEFORE DELETE ON `experience` FOR EACH ROW BEGIN



    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)



    VALUES ('experience', OLD.exp_id, 'DELETE', OLD.user_id);



END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `graduates`
--

DROP TABLE IF EXISTS `graduates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graduates` (
  `grad_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_graduated` year(4) NOT NULL,
  PRIMARY KEY (`grad_id`),
  UNIQUE KEY `idx_student_number` (`student_number`),
  KEY `fk_grad_course` (`course_id`),
  CONSTRAINT `fk_grad_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graduates`
--

LOCK TABLES `graduates` WRITE;
/*!40000 ALTER TABLE `graduates` DISABLE KEYS */;
/*!40000 ALTER TABLE `graduates` ENABLE KEYS */;
UNLOCK TABLES;

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
  `contact_email` varchar(100) DEFAULT NULL,
  `job_description` text NOT NULL,
  `requirements_qualifications` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `status` enum('active','closed','archived') DEFAULT 'active',
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`job_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `jobpostings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobpostings`
--

LOCK TABLES `jobpostings` WRITE;
/*!40000 ALTER TABLE `jobpostings` DISABLE KEYS */;
INSERT INTO `jobpostings` VALUES (1,93,'Corporate Accountant','Prime Accounting','Ortigas Pasig','Full-time','Onsite','Finance','28,000 - 35,000','jobs@primeacct.com','Handle corporate bookkeeping, process bi-monthly payroll, and assist with annual tax preparation for clients.','BS Accountancy graduate, highly organized, detail-oriented, and proficient in accounting software.','13th-month pay, HMO upon regularization, paid sick leaves.','active','2026-05-13 04:14:57'),(2,4,'Frontend Web Developer','TechNova Solutions','Makati City','Full-time','Hybrid','Design','40,000 - 60,000','hr@technova.com','Build responsive user interface components for our main web application using React and Tailwind CSS.','2+ years experience with React, deep understanding of modern CSS, and a strong portfolio.','HMO on day 1, 15 days Paid Leave, MacBook Pro provided.','active','2026-05-13 04:22:12'),(3,63,'Registered Staff Nurse','Pasig City General Hospital','Pasig City','Full-time','Onsite','Other','30,000 - 35,000','hr.nursing@pcgh.gov.ph','Provide high-quality patient care in the general ward, administer medications, and assist attending physicians during rounds.','BS Nursing graduate, valid PRC license, at least 6 months of clinical hospital experience.','Hazard pay, government benefits (GSIS, PhilHealth), 13th and 14th-month pay.','active','2026-05-13 04:26:31'),(4,8,'Junior Software Engineer','CloudSync Systems','BGC Taguig','Full-time','Hybrid','Programming','40,000 - 60,000','dev@cloudsync.com','Write clean, efficient code for our core backend services and assist senior developers in building scalable cloud applications.','BSCS graduate, solid understanding of algorithms, data structures, and proficiency in Java or Python.','Hybrid setup (2 days onsite), annual tech budget, stock options.','active','2026-05-13 04:33:22'),(5,13,'High School English Teacher','St. Mary\'s Academy','Quezon City','Full-time','Onsite','Other','25,000 - 30,000','principal@stmarys.edu.ph','Teach World Literature and English Grammar to junior high school students. Prepare lesson plans and conduct student assessments.','BSED-ENG graduate, LET passer, excellent verbal and written communication skills.','Summer vacation leave, 13th-month pay, professional development seminars.','active','2026-05-13 04:44:10'),(6,16,'Junior Civil Engineer','BuildRight Const.','Makati City','Contract','Onsite','Engineering','30,000 - 40,000','recruitment@buildright.com','Assist the project manager in site planning, structural material cost estimation, and daily monitoring of construction progress.','BS Engineering graduate (Civil preferred), Registered Civil Engineer (RCE), proficient in AutoCAD.','Free meals on-site, project completion bonus, transportation allowance.','active','2026-05-13 04:46:54'),(7,19,'Hotel Front Desk Manager','Shangri-La Manila','Mandaluyong City','Full-time','Onsite','Operations','30,000 - 40,000','hr.manila@shangri-la.com','Oversee the reception area, manage VIP guest check-ins, handle escalated customer concerns, and supervise front desk staff.','BSHM graduate, excellent customer service skills, fluent in English (second language is a plus).','Duty meals provided, uniform laundry service, premium medical coverage.','active','2026-05-13 04:49:52'),(8,17,'HR Recruitment Associate','Global Corp','Quezon City','Full-time','Hybrid','HR','22,000 - 28,000','talent@globalcorp.com','Source candidates, conduct initial psychological screenings and behavioral interviews, and guide applicants through the hiring process.','BS/BA Psychology graduate, strong interpersonal skills, eager to learn corporate recruitment.','Fast promotion track, HMO, performance-based hiring commissions.','active','2026-05-13 04:51:39'),(9,11,'Senior High Mathematics Instructor','Pasig City Science High School','Pasig City','Full-time','Onsite','Other','28,000 - 35,000','hr@pasigsci.edu.ph','Instruct students in Advanced Algebra, Pre-Calculus, and Basic Statistics. Prepare students for inter-school math competitions.','BSED-MATH graduate, LET passer, highly analytical and patient.','Competitive government salary grade, holiday breaks, health insurance.','active','2026-05-13 04:53:33'),(10,47,'Operating Room (OR) Nurse','The Medical City','Pasig City','Full-time','Onsite','Other','35,000 - 45,000','hr@themedicalcity.com','Prep the operating room, scrub in to assist surgeons during procedures, and ensure all instruments are accounted for and sterile.','Valid RN license, OR training/certification, ability to work well under high pressure.','Premium hazard pay, comprehensive medical coverage, signing bonus for experienced hires.','active','2026-05-13 04:59:51');
/*!40000 ALTER TABLE `jobpostings` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_job_insert` AFTER INSERT ON `jobpostings` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_job_delete` BEFORE DELETE ON `jobpostings` FOR EACH ROW BEGIN



    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)



    VALUES ('jobpostings', OLD.job_id, 'DELETE', OLD.user_id);



END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `recovery_requests`
--

DROP TABLE IF EXISTS `recovery_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recovery_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `recovery_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recovery_requests`
--

LOCK TABLES `recovery_requests` WRITE;
/*!40000 ALTER TABLE `recovery_requests` DISABLE KEYS */;
INSERT INTO `recovery_requests` VALUES (1,38,'Forgot password - admin recovery request','approved','2026-05-13 03:57:46');
/*!40000 ALTER TABLE `recovery_requests` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_recovery_insert` AFTER INSERT ON `recovery_requests` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('recovery_requests', NEW.id, 'INSERT', NEW.user_id);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_recovery_update` AFTER UPDATE ON `recovery_requests` FOR EACH ROW 
BEGIN
    IF OLD.status <> NEW.status THEN
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('recovery_requests', NEW.id, 'UPDATE', NEW.user_id);
    END IF;
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
  `skill_level` varchar(50) NOT NULL DEFAULT 'Beginner',
  PRIMARY KEY (`skill_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_insert` AFTER INSERT ON `skills` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_update` AFTER UPDATE ON `skills` FOR EACH ROW BEGIN



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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_skills_delete` BEFORE DELETE ON `skills` FOR EACH ROW BEGIN



    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)



    VALUES ('skills', OLD.skill_id, 'DELETE', OLD.user_id);



END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ticket_replies`
--

DROP TABLE IF EXISTS `ticket_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_reply_ticket` (`ticket_id`),
  KEY `fk_reply_user` (`user_id`),
  CONSTRAINT `fk_reply_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reply_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_replies`
--

LOCK TABLES `ticket_replies` WRITE;
/*!40000 ALTER TABLE `ticket_replies` DISABLE KEYS */;
INSERT INTO `ticket_replies` VALUES (1,1,'user',47,'Where to submit recognitions to get featured in the website?','2026-05-13 07:28:38');
/*!40000 ALTER TABLE `ticket_replies` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_replies_insert` AFTER INSERT ON `ticket_replies` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('ticket_replies', NEW.id, 'INSERT', NEW.user_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('open','in_progress','resolved') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ticket_user` (`user_id`),
  CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,47,'Andrea Garcia','andrea.garcia@hotmail.com','Alumni Features','Where to submit recognitions to get featured in the website?','open','2026-05-13 07:28:38',NULL);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_tickets_insert` AFTER INSERT ON `tickets` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('tickets', NEW.id, 'INSERT', NEW.user_id);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_tickets_update` AFTER UPDATE ON `tickets` FOR EACH ROW 
BEGIN
    IF OLD.status <> NEW.status THEN
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('tickets', NEW.id, 'UPDATE', NEW.user_id);
    END IF;
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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprofile`
--

LOCK TABLES `userprofile` WRITE;
/*!40000 ALTER TABLE `userprofile` DISABLE KEYS */;
INSERT INTO `userprofile` VALUES (1,2,'Juan','Cruz','Jr','Dela','9171234567','Quezon City','2000-05-10','Male',NULL,NULL),(2,3,'Maria','Reyes','','Santos','9179876543','Manila','2001-08-21','Female',NULL,NULL),(3,4,'Mark','Villanueva','','Bautista','9171000001','Pasig City','0000-00-00','Male',NULL,NULL),(4,5,'Ana','Garcia','','Mendoza','9182000002','Marikina City','0000-00-00','Female',NULL,NULL),(5,6,'Paolo','Ocampo','III','Cruz','9193000003','Quezon City','0000-00-00','Male',NULL,NULL),(6,7,'Teresa','Aquino','','Ramos','9204000004','Taguig City','0000-00-00','Female',NULL,NULL),(7,8,'Miguel','Lopez','Jr','Santos','9175000005','Makati City','0000-00-00','Male',NULL,NULL),(8,9,'Sofia','Perez','','Mercado','9186000006','Pasig City','0000-00-00','Female',NULL,NULL),(9,10,'Carlos','Bautista','','Gonzales','9197000007','Mandaluyong City','0000-00-00','Male',NULL,NULL),(10,11,'Isabella','Reyes','','Villanueva','9208000008','Antipolo City','0000-00-00','Female',NULL,NULL),(11,12,'Luis','Cruz','','Garcia','9179000009','Cainta','0000-00-00','Male',NULL,NULL),(12,13,'Mikaela','Mendoza','','Ocampo','9181100010','Taytay','0000-00-00','Female',NULL,NULL),(13,14,'Rafael','Santos','Sr','Aquino','9192200011','Pasig City','0000-00-00','Male',NULL,NULL),(14,15,'Chloe','Ramos','','Lopez','9203300012','Quezon City','0000-00-00','Female',NULL,NULL),(15,16,'Antonio','Mercado','','Perez','9174400013','Marikina City','0000-00-00','Male',NULL,NULL),(16,17,'Angelica','Gonzales','','Bautista','9185500014','Pasig City','0000-00-00','Female',NULL,NULL),(17,18,'Manuel','Villanueva','','Reyes','9196600015','Taguig City','0000-00-00','Male',NULL,NULL),(18,19,'Bea','Garcia','','Cruz','9207700016','Makati City','0000-00-00','Female',NULL,NULL),(19,20,'Pedro','Ocampo','','Mendoza','9178800017','Antipolo City','0000-00-00','Male',NULL,NULL),(20,21,'Patricia','Aquino','','Santos','9189900018','Pasig City','0000-00-00','Female',NULL,NULL),(21,22,'Ricardo','Lopez','Jr','Ramos','9191010019','Mandaluyong City','0000-00-00','Male',NULL,NULL),(22,23,'Camille','Perez','','Mercado','9202120020','Cainta','0000-00-00','Female',NULL,NULL),(23,24,'Roberto','Bautista','','Gonzales','9173230021','Taytay','0000-00-00','Male',NULL,NULL),(24,25,'Bianca','Reyes','','Villanueva','9184340022','Pasig City','0000-00-00','Female',NULL,NULL),(25,26,'Fernando','Cruz','III','Garcia','9195450023','Quezon City','0000-00-00','Male',NULL,NULL),(26,27,'Katrina','Mendoza','','Ocampo','9206560024','Marikina City','0000-00-00','Female',NULL,NULL),(27,28,'Eduardo','Santos','','Aquino','9177670025','Taguig City','0000-00-00','Male',NULL,NULL),(28,29,'Diana','Ramos','','Lopez','9188780026','Makati City','0000-00-00','Female',NULL,NULL),(29,30,'Jose','Mercado','','Perez','9199890027','Pasig City','0000-00-00','Male',NULL,NULL),(30,31,'Vanessa','Gonzales','','Bautista','9200900028','Antipolo City','0000-00-00','Female',NULL,NULL),(31,32,'Ramon','Villanueva','','Reyes','9171011029','Mandaluyong City','0000-00-00','Male',NULL,NULL),(32,33,'Jasmine','Garcia','','Cruz','9182121030','Cainta','0000-00-00','Female',NULL,NULL),(33,34,'Arturo','Ocampo','Jr','Mendoza','9193232031','Taytay','0000-00-00','Male',NULL,NULL),(34,35,'Erika','Aquino','','Santos','9204343032','Pasig City','0000-00-00','Female',NULL,NULL),(35,36,'Julio','Lopez','','Ramos','9175454033','Quezon City','0000-00-00','Male',NULL,NULL),(36,37,'Nicole','Perez','','Mercado','9186565034','Marikina City','0000-00-00','Female',NULL,NULL),(37,38,'Mario','Bautista','','Gonzales','9197676035','Taguig City','0000-00-00','Male',NULL,NULL),(38,39,'Alyssa','Reyes','','Villanueva','9208787036','Makati City','0000-00-00','Female',NULL,NULL),(39,40,'Victor','Cruz','','Garcia','9179898037','Pasig City','0000-00-00','Male',NULL,NULL),(40,41,'Samantha','Mendoza','','Ocampo','9180909038','Antipolo City','0000-00-00','Female',NULL,NULL),(41,42,'Emilio','Santos','III','Aquino','9191010139','Mandaluyong City','0000-00-00','Male',NULL,NULL),(42,43,'Kyla','Ramos','','Lopez','9202121240','Cainta','0000-00-00','Female',NULL,NULL),(43,44,'Renato','Mercado','','Perez','9173232341','Taytay','0000-00-00','Male',NULL,NULL),(44,45,'Christine','Gonzales','','Bautista','9184343442','Pasig City','0000-00-00','Female',NULL,NULL),(45,46,'Albert','Villanueva','','Reyes','9195454543','Quezon City','0000-00-00','Male',NULL,NULL),(46,47,'Andrea','Garcia','','Cruz','9206565644','Marikina City','0000-00-00','Female',NULL,NULL),(47,48,'Oscar','Ocampo','Jr','Mendoza','9177676745','Taguig City','0000-00-00','Male',NULL,NULL),(48,49,'Michelle','Aquino','','Santos','9188787846','Makati City','0000-00-00','Female',NULL,NULL),(49,50,'Felipe','Lopez','','Ramos','9199898947','Pasig City','0000-00-00','Male',NULL,NULL),(50,51,'Joanna','Perez','','Mercado','9200909048','Antipolo City','0000-00-00','Female',NULL,NULL),(51,52,'Nestor','Bautista','','Gonzales','9171010149','Mandaluyong City','0000-00-00','Male',NULL,NULL),(52,53,'Clarisse','Reyes','','Villanueva','9182121250','Cainta','0000-00-00','Female',NULL,NULL),(53,54,'Tomas','Cruz','Sr','Garcia','9193232351','Taytay','0000-00-00','Male',NULL,NULL),(54,55,'Pauline','Mendoza','','Ocampo','9204343452','Pasig City','0000-00-00','Female',NULL,NULL),(55,56,'Vincent','Santos','','Aquino','9175454553','Quezon City','0000-00-00','Male',NULL,NULL),(56,57,'Angela','Ramos','','Lopez','9186565654','Marikina City','0000-00-00','Female',NULL,NULL),(57,58,'Dennis','Mercado','','Perez','9197676755','Taguig City','0000-00-00','Male',NULL,NULL),(58,59,'Roxanne','Gonzales','','Bautista','9208787856','Makati City','0000-00-00','Female',NULL,NULL),(59,60,'Edgar','Villanueva','Jr','Reyes','9179898957','Pasig City','0000-00-00','Male',NULL,NULL),(60,61,'Hazel','Garcia','','Cruz','9180909058','Antipolo City','0000-00-00','Female',NULL,NULL),(61,62,'Rolando','Ocampo','','Mendoza','9191010159','Mandaluyong City','0000-00-00','Male',NULL,NULL),(62,63,'Abigail','Aquino','','Santos','9202121260','Cainta','0000-00-00','Female',NULL,NULL),(63,64,'Martin','Lopez','','Ramos','9173232361','Taytay','0000-00-00','Male',NULL,NULL),(64,65,'Justine','Perez','','Mercado','9184343462','Pasig City','0000-00-00','Female',NULL,NULL),(65,66,'Leo','Bautista','III','Gonzales','9195454563','Quezon City','0000-00-00','Male',NULL,NULL),(66,67,'Monica','Reyes','','Villanueva','9206565664','Marikina City','0000-00-00','Female',NULL,NULL),(67,68,'Oliver','Cruz','','Garcia','9177676765','Taguig City','0000-00-00','Male',NULL,NULL),(68,69,'Janine','Mendoza','','Ocampo','9188787866','Makati City','0000-00-00','Female',NULL,NULL),(69,70,'Felix','Santos','','Aquino','9199898967','Pasig City','0000-00-00','Male',NULL,NULL),(70,71,'Rachel','Ramos','','Lopez','9200909068','Antipolo City','0000-00-00','Female',NULL,NULL),(71,72,'Gary','Mercado','Jr','Perez','9171010169','Mandaluyong City','0000-00-00','Male',NULL,NULL),(72,73,'Kimberly','Gonzales','','Bautista','9182121270','Cainta','0000-00-00','Female',NULL,NULL),(73,74,'Hector','Villanueva','','Reyes','9193232371','Taytay','0000-00-00','Male',NULL,NULL),(74,75,'Erica','Garcia','','Cruz','9204343472','Pasig City','0000-00-00','Female',NULL,NULL),(75,76,'Arnold','Ocampo','','Mendoza','9175454573','Quezon City','0000-00-00','Male',NULL,NULL),(76,77,'Melissa','Aquino','','Santos','9186565674','Marikina City','0000-00-00','Female',NULL,NULL),(77,78,'Reynaldo','Lopez','Sr','Ramos','9197676775','Taguig City','0000-00-00','Male',NULL,NULL),(78,79,'Jocelyn','Perez','','Mercado','9208787876','Makati City','0000-00-00','Female',NULL,NULL),(79,80,'Ariel','Bautista','','Gonzales','9179898977','Pasig City','0000-00-00','Male',NULL,NULL),(80,81,'Pamela','Reyes','','Villanueva','9180909078','Antipolo City','0000-00-00','Female',NULL,NULL),(81,82,'Danilo','Cruz','','Garcia','9191010179','Mandaluyong City','0000-00-00','Male',NULL,NULL),(82,83,'Cynthia','Mendoza','','Ocampo','9202121280','Cainta','0000-00-00','Female',NULL,NULL),(83,84,'Ruben','Santos','Jr','Aquino','9173232381','Taytay','0000-00-00','Male',NULL,NULL),(84,85,'Giselle','Ramos','','Lopez','9184343482','Pasig City','0000-00-00','Female',NULL,NULL),(85,86,'Alvin','Mercado','','Perez','9195454583','Quezon City','0000-00-00','Male',NULL,NULL),(86,87,'Myra','Gonzales','','Bautista','9206565684','Marikina City','0000-00-00','Female',NULL,NULL),(87,88,'Norman','Villanueva','','Reyes','9177676785','Taguig City','0000-00-00','Male',NULL,NULL),(88,89,'Irene','Garcia','','Cruz','9188787886','Makati City','0000-00-00','Female',NULL,NULL),(89,90,'Cesar','Ocampo','III','Mendoza','9199898987','Pasig City','0000-00-00','Male',NULL,NULL),(90,91,'Liza','Aquino','','Santos','9200909088','Antipolo City','0000-00-00','Female',NULL,NULL),(91,92,'Joel','Lopez','','Ramos','9171010189','Mandaluyong City','0000-00-00','Male',NULL,NULL),(92,93,'Carla','Perez','','Mercado','9182121290','Cainta','0000-00-00','Female',NULL,NULL),(93,94,'Roderick','Bautista','','Gonzales','9193232391','Taytay','0000-00-00','Male',NULL,NULL),(94,95,'Aileen','Reyes','','Villanueva','9204343492','Pasig City','0000-00-00','Female',NULL,NULL),(95,96,'Noel','Cruz','Sr','Garcia','9175454593','Quezon City','0000-00-00','Male',NULL,NULL),(96,97,'Evelyn','Mendoza','','Ocampo','9186565694','Marikina City','0000-00-00','Female',NULL,NULL),(97,98,'Elmer','Santos','','Aquino','9197676795','Taguig City','0000-00-00','Male',NULL,NULL),(98,99,'Sharon','Ramos','','Lopez','9208787896','Makati City','0000-00-00','Female',NULL,NULL);
/*!40000 ALTER TABLE `userprofile` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_profile_insert` AFTER INSERT ON `userprofile` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('userprofile', NEW.profile_id, 'INSERT', NEW.user_id);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_profile_update` AFTER UPDATE ON `userprofile` FOR EACH ROW BEGIN















    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)















    VALUES ('userprofile', NEW.profile_id, 'UPDATE', NEW.user_id);















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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_profile_delete` BEFORE DELETE ON `userprofile` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('userprofile', OLD.profile_id, 'DELETE', OLD.user_id);
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
  `twofa_secret` varchar(255) DEFAULT NULL,
  `twofa_enabled` tinyint(1) DEFAULT 0,
  `force_password_change` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@plpasig.com','$2y$10$aTv1RaW8CjeY8Ixuz05vwOMhVm/1cRajp5mrs4JvOexS7hyKtb.NG','admin','active','2026-05-13 03:53:50',NULL,0,0),(2,'juan@gmail.com','$2y$10$gSW0ePjCNK8jeNuWaoIb2eYViceMs4eoBOCuJooVkRgiBv9Nos8Oa','alumni','active','2026-05-13 03:55:27',NULL,0,0),(3,'maria@gmail.com','$2y$10$5DVTn0v.MTqqmKCzWF1UyOxbhxK8MTVqosCQxGVK69aBeAN4azux.','alumni','active','2026-05-13 03:55:27',NULL,0,0),(4,'mark.villanueva@gmail.com','$2y$10$mexMp6Z6EqE45cT9S/huOuryFjJnj9q5/tDb9o0od1LZBxfP1uMjm','alumni','active','2026-05-13 03:55:27',NULL,0,0),(5,'ana.garcia@yahoo.com','$2y$10$W09IhqQLtGs.1TtcZmtajevxElhSg.kUeYmJUDUw6nsic.xaFKjdq','alumni','active','2026-05-13 03:55:27',NULL,0,0),(6,'paolo.ocampo3@gmail.com','$2y$10$Js7HDAIW5G7xWtTC48tB6Oaoq7z.7LvEyflNcWcZLoxPzwrE.MQaW','alumni','active','2026-05-13 03:55:27',NULL,0,0),(7,'teresa.aquino@gmail.com','$2y$10$zKhDmMmTDUpXQbWA5GuueedDA3NFrumlhBDmlnEjWOhuIYl1Jx.4.','alumni','active','2026-05-13 03:55:27',NULL,0,0),(8,'miguel.lopez.jr@gmail.com','$2y$10$S9D0u6NDf6Z7J8k.DGFfQeo2XrmUMMm0SqDh454L8Y3IkibA41JAK','alumni','active','2026-05-13 03:55:27',NULL,0,0),(9,'sofia.perez@hotmail.com','$2y$10$YROGUOBZOyPJMrAvkRudnurKqdkPht7SBMFFKxUEQt58RVYGwHJM.','alumni','active','2026-05-13 03:55:27',NULL,0,0),(10,'carlos.bautista@gmail.com','$2y$10$oyqHinXVDWCn/NBr9SjHOOHQZboyCqol5jSBSoOjZk.60r6CgxQqy','alumni','active','2026-05-13 03:55:27',NULL,0,0),(11,'isabella.reyes@gmail.com','$2y$10$SwhkMWH5xkv7ADIPvbM6x.KmjRSIVsMZ0xLhlHToG42hajXFikJKe','alumni','active','2026-05-13 03:55:28',NULL,0,0),(12,'luis.cruz@yahoo.com','$2y$10$EXF6uXYivuALFzrigf56ke9H1CiPhrQZglsCLZLGYdm9FPVgnpSxi','alumni','active','2026-05-13 03:55:28',NULL,0,0),(13,'mikaela.mendoza@gmail.com','$2y$10$4p6u49UDWo7bSfuTSyMByOBjDBmH4qJu1LpXuzreERMGpqWa6cuq2','alumni','active','2026-05-13 03:55:28',NULL,0,0),(14,'rafael.santos@gmail.com','$2y$10$Hddrep975KJhWQucWvOkJOB0Schdlx3jmxvp5ZhazQLkF3EIGe0KG','alumni','active','2026-05-13 03:55:28',NULL,0,0),(15,'chloe.ramos@gmail.com','$2y$10$VHPalyNgw5e0IrvKBKQICubezjs7yw20SzGitUGFFdFvyPE8T9wRW','alumni','active','2026-05-13 03:55:28',NULL,0,0),(16,'antonio.mercado@gmail.com','$2y$10$wxl47mOrqNDdhSZdsod.X.VnZp77ZYfZAZmxWhuOwFcFaoc.U4tpG','alumni','active','2026-05-13 03:55:28',NULL,0,0),(17,'angelica.gonzales@yahoo.com','$2y$10$mR5HWUAd9CFGe0NU0iDy2ebjjCr1v5N78oLKempvu/m6XL/H1qEGi','alumni','active','2026-05-13 03:55:28',NULL,0,0),(18,'manuel.villanueva@gmail.com','$2y$10$.my7xy0frTB1o2WVumQ38uPa1KI/R1JGt5KwkTWFH9FLm6x6Vl7h6','alumni','active','2026-05-13 03:55:28',NULL,0,0),(19,'bea.garcia@gmail.com','$2y$10$9KZruxcyfuIB5ZKviktjuuuCnnTlSQ.5oj2vALeKI3eqQdEzxd07m','alumni','active','2026-05-13 03:55:28',NULL,0,0),(20,'pedro.ocampo@hotmail.com','$2y$10$5L/tRNu73hZ.YI2Weqtgl.WVez8do5FcRbv9to1ceydNCP8Q6glZO','alumni','active','2026-05-13 03:55:28',NULL,0,0),(21,'patricia.aquino@gmail.com','$2y$10$6L1.Yq.CCCcmmo/67YV0S.tXeMlHuMouSuK33FABAtGB2q3cuvH62','alumni','active','2026-05-13 03:55:28',NULL,0,0),(22,'ricardo.lopez@gmail.com','$2y$10$DQmTvObB0iNsc8Uu6mFV4uoqPFZhfOFjQaraW087tlzY2OFfhLW72','alumni','active','2026-05-13 03:55:29',NULL,0,0),(23,'camille.perez@gmail.com','$2y$10$OMqrm.6bBVuSSqQeKVJcEO7lvECQx9GT.S23u0kBwQSTzrLYEd.Ci','alumni','active','2026-05-13 03:55:29',NULL,0,0),(24,'roberto.bautista@yahoo.com','$2y$10$VQE9xzSc9i5FCtM3nH6Spu.sVIkEyFbQNi06/clXh9SsoBTlDxq2q','alumni','active','2026-05-13 03:55:29',NULL,0,0),(25,'bianca.reyes@gmail.com','$2y$10$MCI5quoNoxZMePcha1MaP.oOP1GKy7bxtQq.yiL/WosPlHNNjQWiq','alumni','active','2026-05-13 03:55:29',NULL,0,0),(26,'fernando.cruz@gmail.com','$2y$10$6AxyS/qU0EVyTduHcd1u0./LbR71rUEUVqgqr72SQGf4tPeEjKEN.','alumni','active','2026-05-13 03:55:29',NULL,0,0),(27,'katrina.mendoza@gmail.com','$2y$10$jmtAxhgBGy9NByZHHvAiseSMLZ3WoHiSTkNa5QHWuqzXtfXDtlzZe','alumni','active','2026-05-13 03:55:29',NULL,0,0),(28,'eduardo.santos@gmail.com','$2y$10$TLO1RjvU2kqRbSEmPjKk6u7lseen0VAgFO.HCzWHR66iRWGVyhMeu','alumni','active','2026-05-13 03:55:29',NULL,0,0),(29,'diana.ramos@yahoo.com','$2y$10$FXElJ.iYt6A/f.u/JQw7OONXnS3gcYQvVupmOginD0Z/MgTolEmc2','alumni','active','2026-05-13 03:55:29',NULL,0,0),(30,'jose.mercado@gmail.com','$2y$10$ZYTfLZP5jqaP895RRO4XceCGIqgBnaUAANpccZ.i31JdLcYOxdUSW','alumni','active','2026-05-13 03:55:29',NULL,0,0),(31,'vanessa.gonzales@hotmail.com','$2y$10$sdvcstuLEX5k24Wv0fWO5ugeBqv8FlQEMr2WXEZQLIRIPj1YDNy0e','alumni','active','2026-05-13 03:55:29',NULL,0,0),(32,'ramon.villanueva@gmail.com','$2y$10$maCuCcYImktRyaK0LwaHDejYO6EDLXZcAHbVJPcKFJ2ZezS19pBUy','alumni','active','2026-05-13 03:55:29',NULL,0,0),(33,'jasmine.garcia@gmail.com','$2y$10$6jLY54fRcjN1L3oKpJSN1OLdBQMH48QnisjNCsQfMjNUHvUhAELZq','alumni','active','2026-05-13 03:55:30',NULL,0,0),(34,'arturo.ocampo@gmail.com','$2y$10$kjqQSbT3Nk21H34ToqsB8uuzs9lY7vmg7KU0zbe8XSXHesVh.7gn6','alumni','active','2026-05-13 03:55:30',NULL,0,0),(35,'erika.aquino@gmail.com','$2y$10$hsPhGxtPjytTPjxDyrddAOpqUTRQSPG8XHywU0nOmHZviEkDGgQfu','alumni','active','2026-05-13 03:55:30',NULL,0,0),(36,'julio.lopez@yahoo.com','$2y$10$tawtnXOOqAeKFyEwE/EV0.O7jy.btx2eNlsPwrXEAFwJhE4HMmuSe','alumni','active','2026-05-13 03:55:30',NULL,0,0),(37,'nicole.perez@gmail.com','$2y$10$pAa8GUnJJW.VctbS3ZQX6ORWULqb0xXVgtyd4234lCMDCr8131uRW','alumni','active','2026-05-13 03:55:30',NULL,0,0),(38,'mario.bautista@gmail.com','$2y$10$PmXanvbi7OrmBL5g3RPokuEFmgrR/2zMeNwwDbs8KjFYD4xVMCFYC','alumni','active','2026-05-13 03:55:30',NULL,0,1),(39,'alyssa.reyes@hotmail.com','$2y$10$TebKLZEim4AYAjTvCmeXsu8tJQqFt7lGMs5shY0UuMjGitnPTRexC','alumni','active','2026-05-13 03:55:30',NULL,0,0),(40,'victor.cruz@gmail.com','$2y$10$yxLUsAgRFqKDXoYBeeIwkuIU3Qc6GCtVOpBw/6gHv7DsCGXzKmez6','alumni','active','2026-05-13 03:55:30',NULL,0,0),(41,'samantha.mendoza@gmail.com','$2y$10$3QvNBr.DMQxnwbgkds8c9.tg0qujJYDIqdnrDeCmwysErW1Q2b8iG','alumni','active','2026-05-13 03:55:30',NULL,0,0),(42,'emilio.santos@gmail.com','$2y$10$wX45TjU6Ct3zlyM//g0rOuufCp7ILoYhGpddZuYKbFnc6yaoQNflu','alumni','active','2026-05-13 03:55:30',NULL,0,0),(43,'kyla.ramos@yahoo.com','$2y$10$8TijlLvSXt6I9MgUKRp3ZOv/jZiwHXJpq5zPTXt1o065tfGO.pdw2','alumni','active','2026-05-13 03:55:30',NULL,0,0),(44,'renato.mercado@gmail.com','$2y$10$QsU.ByFFi0iFKYY3PEW0Fe1cBYNHLEa3EM51SkkgqINxC3YWN5L3W','alumni','active','2026-05-13 03:55:30',NULL,0,0),(45,'christine.gonzales@gmail.com','$2y$10$XN3L5ph4jYGEeIIVUqWWneLU2DW8NJd4QFeUY6bKd3GFc9yaaD2Q2','alumni','active','2026-05-13 03:55:31',NULL,0,0),(46,'albert.villanueva@gmail.com','$2y$10$.sIOseroc.1f.1QzxrZb1O8OQ2Db7ZMtq6V2WaUJ2sCdWEk36V6aa','alumni','active','2026-05-13 03:55:31',NULL,0,0),(47,'andrea.garcia@hotmail.com','$2y$10$8rLcl6LyrViOJx5KSJ.VEuxgYvXld9mwjZI4VkBgFVjE/r.sXEdOW','alumni','active','2026-05-13 03:55:31',NULL,0,0),(48,'oscar.ocampo@gmail.com','$2y$10$tGzqhe2Y9336UNzxLfEp0uVfmW0RS/hYSx7XRL0yQOahgj5vsFE2e','alumni','active','2026-05-13 03:55:31',NULL,0,0),(49,'michelle.aquino@gmail.com','$2y$10$HD3pc0RylglYyQc.e7yrVOlNyT1y/xQmrvAczKePRq6LX7xxKI3p.','alumni','active','2026-05-13 03:55:31',NULL,0,0),(50,'felipe.lopez@yahoo.com','$2y$10$P63Xy1hXKMFQKQuc7PJti.WuWgTjuaXJv2qQ3p7E3OTleYx0KhqvW','alumni','active','2026-05-13 03:55:31',NULL,0,0),(51,'joanna.perez@gmail.com','$2y$10$.dL1U6TAoKaJzV50.ZxLnetdfniz5gz9q5tO/QttGgA86uvUKPEja','alumni','active','2026-05-13 03:55:31',NULL,0,0),(52,'nestor.bautista@gmail.com','$2y$10$DLXxPfd7U7rw5eDeXTQLKOHShDnZOO0HTE1jzu5U8JJq.XrAY9BKW','alumni','active','2026-05-13 03:55:31',NULL,0,0),(53,'clarisse.reyes@gmail.com','$2y$10$5Zg.uiozeif/CxXvcLWl4.e4DdUKMelYaxwPwxqWqrkSjZ1utCj3.','alumni','active','2026-05-13 03:55:31',NULL,0,0),(54,'tomas.cruz@hotmail.com','$2y$10$FximC5.7F26l07Y/TmLr3uuGV0rxynmJQFqWpiY7/aBFaDuC1v47q','alumni','active','2026-05-13 03:55:31',NULL,0,0),(55,'pauline.mendoza@gmail.com','$2y$10$yvVW9c1w4AmqYdVNwhbS9.bMrszKBZUowxRrYAbUOQBSU2FEEjV8i','alumni','active','2026-05-13 03:55:31',NULL,0,0),(56,'vincent.santos@gmail.com','$2y$10$7UI94aPTdq2MCmxw5ZLNC.rKWj1ZmEBWmIsb4BuGNUWugVqGp.C7K','alumni','active','2026-05-13 03:55:32',NULL,0,0),(57,'angela.ramos@yahoo.com','$2y$10$kCOMB/tHNzzWlEFljqkW.uKqNKcpazpvQTKsvglqNd6fzyadHVamS','alumni','active','2026-05-13 03:55:32',NULL,0,0),(58,'dennis.mercado@gmail.com','$2y$10$LQR20cJQf4hrmpp5eN.CF.32Snp2rG2L8tMc3JqVTSOCVYzUj33Eu','alumni','active','2026-05-13 03:55:32',NULL,0,0),(59,'roxanne.gonzales@gmail.com','$2y$10$VTtOjgsKkJykYByw2zrVOOYILZCHbhkfX6AI8tvy2OwORQqPzbape','alumni','active','2026-05-13 03:55:32',NULL,0,0),(60,'edgar.villanueva@gmail.com','$2y$10$gY2hMUb71KO.h6CnfkB8Y.55M3WspJ9hWiYSiknN8lX6l1QPDkEru','alumni','active','2026-05-13 03:55:32',NULL,0,0),(61,'hazel.garcia@hotmail.com','$2y$10$QIZ3DMv6r2R70SLhWl3KhOLRFkoecSwYUvwJ0494u8SCALCUrWLLW','alumni','active','2026-05-13 03:55:32',NULL,0,0),(62,'rolando.ocampo@gmail.com','$2y$10$3evW42ygtLHhbMDJUGd3Eup0XmUyxjPpRyddXlRwllljHuZXpx8A2','alumni','active','2026-05-13 03:55:32',NULL,0,0),(63,'abigail.aquino@gmail.com','$2y$10$zBlgBMWkT4o9QwuUDsndr.gO.ItxkOvGs.uRjh4OecIaCdXHt5qq.','alumni','active','2026-05-13 03:55:32',NULL,0,0),(64,'martin.lopez@yahoo.com','$2y$10$U5x/Um3mgnDO3u0XRSJIwOhgXFDjwb/ua8vMQ0H6qNxABUdsva3WS','alumni','active','2026-05-13 03:55:32',NULL,0,0),(65,'justine.perez@gmail.com','$2y$10$dfk8VUrD818hysLBL/CUTetL4bK4IXmA4MTAuqJiyXem3wo9qyMcW','alumni','active','2026-05-13 03:55:32',NULL,0,0),(66,'leo.bautista@gmail.com','$2y$10$H7fH5zfDPQvltHu9D1RVm.XgAdBnrwYbmKicSm0Vu4xWbM8SFnexy','alumni','active','2026-05-13 03:55:32',NULL,0,0),(67,'monica.reyes@gmail.com','$2y$10$HKmyDbSvVnVtKqK8OX2gEO5KhTLRwb/UCY5EYRD34FvMIPtG5a0VS','alumni','active','2026-05-13 03:55:33',NULL,0,0),(68,'oliver.cruz@hotmail.com','$2y$10$nLku9Swoc1hkyop4o41YOe9ZyMUXM//ZZ6mPk0HPrW0SJrDHsgaoW','alumni','active','2026-05-13 03:55:33',NULL,0,0),(69,'janine.mendoza@gmail.com','$2y$10$/UEX6qbQQXNs064dw9JmbOhbg5U3PyO30VBFEVWJntxS74qNQBnIi','alumni','active','2026-05-13 03:55:33',NULL,0,0),(70,'felix.santos@gmail.com','$2y$10$L3tZuVzWXYMyBqyMevnv0ey8BJiK1E8eULH2W0uyiBC3ELEHfOywS','alumni','active','2026-05-13 03:55:33',NULL,0,0),(71,'rachel.ramos@yahoo.com','$2y$10$D6XyPrhKLgRMvH.fj4PPt..nj3LhdZOFldaF6ToLzPyoJu4zr3dKy','alumni','active','2026-05-13 03:55:33',NULL,0,0),(72,'gary.mercado@gmail.com','$2y$10$5JRwp1cGDFCyYXgeiY1NweohrkssWe/KIHG5pJ8VSH62SJ5X6ni9a','alumni','active','2026-05-13 03:55:33',NULL,0,0),(73,'kimberly.gonzales@gmail.com','$2y$10$kUrkXntVMx03Ibi5naO44uku60fvf0GlJAhCAvArcchCN7po2qRkS','alumni','active','2026-05-13 03:55:33',NULL,0,0),(74,'hector.villanueva@gmail.com','$2y$10$oxvtqRmwooc1EMRPyx7HT.pK7RV0vK5DT2jSy6TuuXAJYzINF1Ziy','alumni','active','2026-05-13 03:55:33',NULL,0,0),(75,'erica.garcia@hotmail.com','$2y$10$QJvAfpeueDGqtBLAPsAOb.Kh0EnHCVb71mxm7YCxHiwsEsiyCBfDe','alumni','active','2026-05-13 03:55:33',NULL,0,0),(76,'arnold.ocampo@gmail.com','$2y$10$7X7SLQ0ziI9l4hP0bhJR0Ob4RHQ9iaiv.aIqTpN6neNJIeyyICtTW','alumni','active','2026-05-13 03:55:33',NULL,0,0),(77,'melissa.aquino@gmail.com','$2y$10$VtTP9/CqXeAzOYwoww8rse1goBaJuyVG2/AxWZhURsz8UYvcxOklC','alumni','active','2026-05-13 03:55:33',NULL,0,0),(78,'reynaldo.lopez@yahoo.com','$2y$10$1Iu4SwYmOwhCshfgvpVjkuR1U9X69tEHnyWOTLonL4SrS4WXzC5/q','alumni','active','2026-05-13 03:55:33',NULL,0,0),(79,'jocelyn.perez@gmail.com','$2y$10$OsbBzzz1ID01JLXDiVpI8OH1abU4xsy8HTM4Ewavfi4KW2rPT.8SO','alumni','active','2026-05-13 03:55:33',NULL,0,0),(80,'ariel.bautista@gmail.com','$2y$10$96cpOhdo8IHf2knxm3lxTe2ygLvOlZllwWssb1qB5h2cYCUFdz3BW','alumni','active','2026-05-13 03:55:34',NULL,0,0),(81,'pamela.reyes@gmail.com','$2y$10$auqjd3ske6v70w04B75PN.WDw9rOvyMXcHUEkzGfPf6mHrV/Fb7mi','alumni','active','2026-05-13 03:55:34',NULL,0,0),(82,'danilo.cruz@hotmail.com','$2y$10$EJoj8rxAZwXxO8KwZEzBBe.y.KPNThaWCc0A8xcEYZBAXtxrAJ5ga','alumni','active','2026-05-13 03:55:34',NULL,0,0),(83,'cynthia.mendoza@gmail.com','$2y$10$H7Km/yMbDo7lEt2Ae9n8vuQAylWU8.N3AHTckt6PoeR9tLjhEybLG','alumni','active','2026-05-13 03:55:34',NULL,0,0),(84,'ruben.santos@gmail.com','$2y$10$39SyBCly.dVQ6hDBZdUyzutv4WgGmVgyQkqYLOV65UGVfK1e7Bqki','alumni','active','2026-05-13 03:55:34',NULL,0,0),(85,'giselle.ramos@yahoo.com','$2y$10$K82idbM2xhbgrm5aVhGT4.40nqJWWHw0SIXKtlqiIBUJ0URGNC6s2','alumni','active','2026-05-13 03:55:34',NULL,0,0),(86,'alvin.mercado@gmail.com','$2y$10$hHSxz.TwubADMLTvncqokuQuLEoDywkvM/SoSBbDWg41dYUfwxo9G','alumni','active','2026-05-13 03:55:34',NULL,0,0),(87,'myra.gonzales@gmail.com','$2y$10$8Cb2dTPAnUMnUjCmH0hrZekDXFDTCg67RtDiVf6ha4TNTvZiPCGA6','alumni','active','2026-05-13 03:55:34',NULL,0,0),(88,'norman.villanueva@gmail.com','$2y$10$hRWAWAfFqOoGQi0Qs5xshejfLdg/bsnEA7H21h2XLaMohZY0kfrWO','alumni','active','2026-05-13 03:55:34',NULL,0,0),(89,'irene.garcia@hotmail.com','$2y$10$MvTS58HfQCy8GxZkWHs00OnXmFxI4GidobjATofBJHNRkQDMYvO.u','alumni','active','2026-05-13 03:55:34',NULL,0,0),(90,'cesar.ocampo@gmail.com','$2y$10$LggPOrEvsCTwP9dz6btalOUzyEYzZfAlCes91ko8CN4FZjkbSPO4y','alumni','active','2026-05-13 03:55:35',NULL,0,0),(91,'liza.aquino@yahoo.com','$2y$10$ta1PqDKEgqmtpdIo9OLbReTnYmm6ra608ik8BFjx5tYBDYYm8lM2m','alumni','active','2026-05-13 03:55:35',NULL,0,0),(92,'joel.lopez@gmail.com','$2y$10$iR/Nd1NxmJieX/RtdGKcgerhs2gnNqCzdPK60o8Dtcy.iTeu3H7kq','alumni','active','2026-05-13 03:55:35',NULL,0,0),(93,'carla.perez@gmail.com','$2y$10$aIyRoT3a3ohmUH3vJfwp5OuZ0VXf/2HEEQy/pwIt9F3bsPhaXXk2W','alumni','active','2026-05-13 03:55:35',NULL,0,0),(94,'roderick.bautista@gmail.com','$2y$10$mGwD8zWaPfnFeddmnBC0O.uEI5agMGVfZo/qkKOR6uQlJs4gbbePe','alumni','active','2026-05-13 03:55:35',NULL,0,0),(95,'aileen.reyes@hotmail.com','$2y$10$u7D4v3v/1Bmqbi9lVmbPnOz46VHMcMtVR/R4E84AbUyu3dTPTW5xy','alumni','active','2026-05-13 03:55:35',NULL,0,0),(96,'noel.cruz@gmail.com','$2y$10$cEflE94rJjoY64Xrmh.SyOj9rlYpDitsK3vnUK.v7J4xICE.EXbsC','alumni','active','2026-05-13 03:55:35',NULL,0,0),(97,'evelyn.mendoza@yahoo.com','$2y$10$4Fp6Ov3.1aNKoGE0TW2PVuY9lRPZAKnwREl2p8RsPfTn8rzJIUcuy','alumni','active','2026-05-13 03:55:35',NULL,0,0),(98,'elmer.santos@gmail.com','$2y$10$MhLvr9s9t4L1dJZdXFLKP.tNHDmxOsvN5RMn1i//yGSbqUjt4x8cC','alumni','active','2026-05-13 03:55:35',NULL,0,0),(99,'sharon.ramos@gmail.com','$2y$10$mwzS9djaUw7MmJc0CYUsQuqGj4IStTCXonDERQmMU4Gt0k/vWntsu','alumni','active','2026-05-13 03:55:35',NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_user_insert` AFTER INSERT ON `users` FOR EACH ROW 
BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('users', NEW.id, 'INSERT', NEW.id);
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_audit_user_security` AFTER UPDATE ON `users` FOR EACH ROW 
BEGIN
    IF OLD.status <> NEW.status 
       OR OLD.role <> NEW.role 
       OR OLD.password <> NEW.password 
       OR OLD.twofa_enabled <> NEW.twofa_enabled 
       OR OLD.email <> NEW.email THEN
        
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
/*!50106 DROP EVENT IF EXISTS `evt_ArchiveOldJobs` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `evt_ArchiveOldJobs` ON SCHEDULE EVERY 1 DAY STARTS '2026-05-12 23:56:16' ON COMPLETION PRESERVE ENABLE DO BEGIN
    
    
    UPDATE jobpostings 
    SET status = 'archived' 
    WHERE status != 'archived' 
      AND posted_at <= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 DAY);

END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `evt_AutomateEventStatus` */;;
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
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_SearchEvents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
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
    AND e.status IN ('upcoming', 'ongoing')
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

-- Dump completed on 2026-05-13 23:06:34
