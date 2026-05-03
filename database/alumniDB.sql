-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 01:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumnidb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_FilterEvents` (IN `p_event_type` VARCHAR(50))   BEGIN
    IF p_event_type = 'All' THEN
        SELECT * FROM Events WHERE status != 'cancelled' ORDER BY event_date ASC;
    ELSE
        SELECT * FROM Events 
        WHERE event_type = p_event_type 
        AND status != 'cancelled' 
        ORDER BY event_date ASC;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_FilterJobs` (IN `p_type` VARCHAR(50), IN `p_modality` VARCHAR(50))   BEGIN
    SELECT * FROM JobPostings
    WHERE (job_type = p_type OR p_type = 'All')
    AND (modality = p_modality OR p_modality = 'All')
    AND status = 'active'
    ORDER BY posted_at DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_RegisterAlumni` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(255), IN `p_first_name` VARCHAR(50), IN `p_last_name` VARCHAR(50), IN `p_suffix` VARCHAR(10), IN `p_middle_name` VARCHAR(50), IN `p_contact_number` VARCHAR(11), IN `p_address` VARCHAR(255), IN `p_birthdate` DATE, IN `p_gender` ENUM('Male','Female'), IN `p_student_number` VARCHAR(20), IN `p_course_id` INT, IN `p_year_graduated` YEAR)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SearchEvents` (IN `p_query` VARCHAR(100))   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SearchJobs` (IN `p_query` VARCHAR(100))   BEGIN
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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alumnidetails`
--

CREATE TABLE `alumnidetails` (
  `alumni_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_graduated` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumnidetails`
--

INSERT INTO `alumnidetails` (`alumni_id`, `user_id`, `student_number`, `course_id`, `year_graduated`) VALUES
(1, 1, '24-00580', 1, '2024'),
(2, 3, '24-00624', 1, '2026');

--
-- Triggers `alumnidetails`
--
DELIMITER $$
CREATE TRIGGER `trg_PreventAlumniDetailsUpdate` BEFORE UPDATE ON `alumnidetails` FOR EACH ROW BEGIN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Error: Alumni academic details are permanent graduate records and cannot be modified.';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_PreventDuplicateAlumni` BEFORE INSERT ON `alumnidetails` FOR EACH ROW BEGIN
    IF EXISTS (SELECT 1 FROM AlumniDetails WHERE student_number = NEW.student_number) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: This Student Number is already registered to an alumni account.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `department_id`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT', 1),
(2, 'Bachelor of Science in Computer Science', 'BSCS', 1),
(3, 'Bachelor of Science in Education Major in English', 'BSED-ENG', 2),
(4, 'Bachelor of Science in Education Major in Filipino', 'BSED-FIL', 2),
(5, 'Bachelor of Science in Education Major in Math', 'BSED-MATH', 2),
(6, 'Bachelor of Science in Nursing', 'BSN', 3),
(7, 'Bachelor of Science in Engineering', 'BSE', 4),
(8, 'Bachelor of Science in Hospitality Management', 'BSHM', 5),
(9, 'Bachelor of Science in Business and Accountancy', 'BSBA', 6),
(10, 'Bachelor of Science in Psychology', 'BSP', 7);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'CCS'),
(2, 'COED'),
(3, 'CON'),
(4, 'COE'),
(5, 'CIHM'),
(6, 'CBA'),
(7, 'CAS');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `events`
--
DELIMITER $$
CREATE TRIGGER `trg_CheckEventDates` BEFORE INSERT ON `events` FOR EACH ROW BEGIN
    IF NEW.registration_deadline > NEW.event_date THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: Registration deadline cannot be later than the event date.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_audit_event_update` AFTER UPDATE ON `events` FOR EACH ROW BEGIN
    
    IF NEW.event_date <> OLD.event_date 
       OR NEW.start_time <> OLD.start_time 
       OR NEW.end_time <> OLD.end_time 
       OR NOT (NEW.registration_deadline <=> OLD.registration_deadline) THEN
       
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('events', NEW.event_id, 'UPDATE', NEW.user_id);
        
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jobpostings`
--

CREATE TABLE `jobpostings` (
  `job_id` int(11) NOT NULL,
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
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobpostings`
--

INSERT INTO `jobpostings` (`job_id`, `user_id`, `job_title`, `company_name`, `location`, `job_type`, `modality`, `category`, `salary_range`, `application_link`, `contact_email`, `job_description`, `requirements_qualifications`, `benefits`, `status`, `posted_at`) VALUES
(1, 1, 'Job Test', 'Poh.inc', 'Pasig City', 'Full-time', 'Onsite', 'Programming', '20000', 'https://youtu.be/Aq5WXmQQooo?si=5Ki5WhNnXJZNeE6V', 'vehniahsamson@gmail.com', 'Dapat magaling', '8 years of experience 5 years old male', 'Libre Samgyup araw-araw', 'active', '2026-05-03 10:34:37'),
(2, 1, 'Software Engineer', 'TectTalk.Inc', 'Pasig Ortigas Avenue', 'Full-time', 'Onsite', 'Engineering', '10,000', 'https://docs.google.com/spreadsheets/d/1t9q6ugZPIeNdAVjit5rJIxrh1amkz4Udgax2_RoT8AA/edit?gid=0#gid=0', 'TectTalk@gmail.com', 'Dapat magaling mag tiktok', 'Nag titinda ng KangKong Chips', 'May Insurance sa akin', 'active', '2026-05-03 11:00:47');

--
-- Triggers `jobpostings`
--
DELIMITER $$
CREATE TRIGGER `trg_audit_job_update` AFTER UPDATE ON `jobpostings` FOR EACH ROW BEGIN
    
    IF NEW.modality <> OLD.modality 
       OR NOT (NEW.contact_email <=> OLD.contact_email) THEN
       
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('jobpostings', NEW.job_id, 'UPDATE', NEW.user_id);
        
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`profile_id`, `user_id`, `first_name`, `last_name`, `suffix`, `middle_name`, `contact_number`, `address`, `birthdate`, `gender`, `profile_picture`) VALUES
(1, 1, 'Vehniah', 'Samson', '', 'Perol', '09929952041', 'Callejon 2', '2006-09-11', 'Male', NULL),
(2, 3, 'Geoff Laurence', 'Barrun', 'Sr', 'Llala', '09291880702', 'Rosario City', '2005-11-21', 'Female', NULL);

--
-- Triggers `userprofile`
--
DELIMITER $$
CREATE TRIGGER `trg_audit_profile_update` AFTER UPDATE ON `userprofile` FOR EACH ROW BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('userprofile', NEW.profile_id, 'UPDATE', NEW.user_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('alumni','admin') NOT NULL,
  `status` enum('active','pending','inactive') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'vehniahsamson11@gmail.com', '$2y$10$AVpzAFJ052lgkIMI/1sdS.uJyfq6mI0q/BKLbpXzhk8e2DEPYH.nW', 'alumni', 'pending', '2026-04-30 14:59:11'),
(2, 'admin@plpasig.com', '$2y$10$XijbpJC5OAGWMqGaWH6rf.Ro2YZLUGVSKMn7PJPAG9yf3Sgw/mo.W', 'admin', 'pending', '2026-05-02 06:43:53'),
(3, 'Geoff@gmail.com', '$2y$10$3sqjnOyiYRyR3BsmmTnk5O268/Iit8aN5hRDD.PUzAO1JqR1nZr9m', 'alumni', 'pending', '2026-05-03 07:36:57');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `trg_audit_user_delete` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
    VALUES ('users', OLD.id, 'DELETE', OLD.id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_audit_user_security` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    
    IF OLD.status <> NEW.status OR OLD.role <> NEW.role THEN
        INSERT INTO audit_logs (table_name, record_id, action_type, user_id)
        VALUES ('users', NEW.id, 'UPDATE', NEW.id);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnidetails`
--
ALTER TABLE `alumnidetails`
  ADD PRIMARY KEY (`alumni_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobpostings`
--
ALTER TABLE `jobpostings`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnidetails`
--
ALTER TABLE `alumnidetails`
  MODIFY `alumni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobpostings`
--
ALTER TABLE `jobpostings`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnidetails`
--
ALTER TABLE `alumnidetails`
  ADD CONSTRAINT `alumnidetails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alumnidetails_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobpostings`
--
ALTER TABLE `jobpostings`
  ADD CONSTRAINT `jobpostings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `evt_AutomateEventStatus` ON SCHEDULE EVERY 15 MINUTE STARTS '2026-04-29 12:11:11' ON COMPLETION PRESERVE ENABLE DO BEGIN
    
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

END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
