-- ============================================================
-- cs_attendance_db — Railway MySQL setup
-- Run this in Railway's MySQL Query tab
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- year_levels (must be first — users references it)
DROP TABLE IF EXISTS `year_levels`;
CREATE TABLE `year_levels` (
  `id`         INT NOT NULL AUTO_INCREMENT,
  `level_name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `year_levels` VALUES (1,'1st Year'),(2,'2nd Year'),(3,'3rd Year'),(4,'4th Year');

-- users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`            INT NOT NULL AUTO_INCREMENT,
  `id_number`     VARCHAR(50)  DEFAULT NULL,
  `password`      VARCHAR(255) NOT NULL,
  `full_name`     VARCHAR(100) NOT NULL,
  `email`         VARCHAR(255) DEFAULT NULL,
  `profile_pic`   VARCHAR(255) DEFAULT 'default.png',
  `course`        ENUM('BSCS','BSIS','BSIT') NOT NULL,
  `year_level_id` INT DEFAULT NULL,
  `role`          ENUM('admin','student') DEFAULT 'student',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`),
  KEY `year_level_id` (`year_level_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`year_level_id`) REFERENCES `year_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin: ID = 23-a-00000 / password = admin
INSERT INTO `users` VALUES (6,'23-a-00000','admin','Administrator',NULL,'default.png','BSCS',4,'admin');

-- events
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id`          INT NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(100) NOT NULL,
  `description` TEXT,
  `start_event` DATETIME NOT NULL,
  `end_event`   DATETIME NOT NULL,
  `color`       VARCHAR(7) DEFAULT '#3788d8',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- attendance
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id`         INT NOT NULL AUTO_INCREMENT,
  `student_id` VARCHAR(50) NOT NULL,
  `event_id`   INT DEFAULT NULL,
  `status`     ENUM('present','absent','late') DEFAULT 'present',
  `remarks`    TEXT,
  `time_in`    DATETIME DEFAULT NULL,
  `time_out`   DATETIME DEFAULT NULL,
  `date`       DATE NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`event_id`)   REFERENCES `events` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- announcements
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id`         INT NOT NULL AUTO_INCREMENT,
  `user_id`    INT DEFAULT NULL,
  `message`    TEXT,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
