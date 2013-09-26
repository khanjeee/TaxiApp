-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2013 at 12:12 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kmdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_course`
--

CREATE TABLE IF NOT EXISTS `assign_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `year_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `batch_year` varchar(4) NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `assign_course`
--

INSERT INTO `assign_course` (`id`, `course_id`, `assigned_by`, `created_on`, `year_id`, `section_id`, `batch_year`, `modified_on`, `is_locked`, `status`) VALUES
(16, 12, 1, 20, '2013-08-25 05:06:22', 1,  '2011', '0000-00-00 00:00:00', 0, 1),
(17, 17, 1, 21, '2013-08-03 11:25:27', 2,  '2013', '0000-00-00 00:00:00', 0, 1),
(18, 12, 1, 21, '2013-08-25 05:11:07', 1,  '2014', '0000-00-00 00:00:00', 0, 1),
(19, 12, 1, 22, '2013-08-25 04:24:57', 2,  '2013', '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assign_course_teacher`
--

CREATE TABLE IF NOT EXISTS `assign_course_teacher` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(20) DEFAULT NULL,
  `assign_course_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assign_course_teacher`
--

INSERT INTO `assign_course_teacher` (`id`, `teacher_id`, `assign_course_id`) VALUES
(1, 21, 19),
(2, 22, 18),
(3, 21, 17),
(4, 20, 16);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_desc` text,
  `file_path` text NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `content_desc`, `file_path`, `content_type_id`, `created_by`, `created_on`) VALUES
(2, NULL, '67195-fullpage.png', 2, 1, '2013-07-20 23:40:37'),
(3, NULL, 'd9f9f-Curriculum-Vitae.pdf', 2, 1, '2013-07-24 00:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `type_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `type`, `type_desc`) VALUES
(1, 'Podcast', 'Podcast'),
(2, 'Lecture', 'Lecture'),
(3, 'Associated Material', 'Associated Material'),
(4, 'Video', 'Video ');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`, `department_id`, `description`, `status`, `section_id`, `year_id`, `created_by`, `created_on`) VALUES
(12, 'df2', 'Algorithm Design', 1, 'fsdfsdfds', 1, 1, 1, 1, '2013-07-04 23:46:09'),
(13, 'ahmed', 'Bio Technology', 3, 'ahmed', 2, 1, 1, 1, '2013-07-04 23:47:05'),
(14, 'testser', 'Pakistan Studies', 1, 'tester', 2, 2, 3, 1, '2013-07-06 13:03:53'),
(17, 'aaaaaaaaaaaaa', 'Data Structure', 1, 'aaaaaaaaaaaaa', 1, 1, 1, 1, '2013-07-06 13:08:57'),
(18, '342', 'sindhi', 2, 'sindhi', 1, 1, 1, 1, '2013-07-17 01:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `course_contents`
--

CREATE TABLE IF NOT EXISTS `course_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_lectures`
--

CREATE TABLE IF NOT EXISTS `course_lectures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `topic` varchar(200) NOT NULL,
  `topic_desc` text NOT NULL,
  `sort_order` tinyint(2) NOT NULL,
  `lecture_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `day` varchar(10) NOT NULL,
  `uploaded_file` text NOT NULL,
  `uploaded_audio` text,
  `section_id` int(11) NOT NULL,
  `batch_year` varchar(4) NOT NULL,
  `refer_links` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE IF NOT EXISTS `course_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contains relation between student and course' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Computer Science'),
(2, 'Mathematics'),
(3, 'Bio Technology');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Student', 'Student Group'),
(3, 'Teacher', 'Teacher Group'),
(4, 'HOD', 'Head of Department'),
(5, 'Web Admin', 'Web Administration'),
(6, 'bvb', '1vc');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_recipients`
--

CREATE TABLE IF NOT EXISTS `message_recipients` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_board`
--

CREATE TABLE IF NOT EXISTS `notification_board` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `news` text NOT NULL,
  `news_desc` text NOT NULL,
  `status` int(11) NOT NULL COMMENT 'publish/draft',
  `section_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notification_board`
--

INSERT INTO `notification_board` (`id`, `news`, `news_desc`, `status`, `section_id`, `year_id`, `group_id`, `created_on`, `modified_on`) VALUES
(1, '<p>\r\n	aaaaaaaaaaaaaaaa</p>\r\n', '<p>\r\n	aaaaaaaaaaaaaa</p>\r\n', 2, 1, 1, 5, '2013-07-16 00:50:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `type` enum('MCQ','TRUE/FALSE') DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_course_id` int(11) NOT NULL,
  `start_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `room` varchar(20) NOT NULL,
  `day` varchar(10) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `assign_course_id`, `start_on`, `end_on`, `room`, `day`, `duration`, `created_by`, `created_on`, `modified_on`) VALUES
(1, 16, '2013-07-31 19:00:00', '2013-08-27 19:00:00', '1', '1', 45, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 16, '2013-08-21 19:00:00', '2013-08-19 19:00:00', '5', '5', 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(100) NOT NULL,
  `section_desc` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section`, `section_desc`) VALUES
(1, 'Medical', 'Medical Section'),
(2, 'Dental', 'Dental Section');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `assign_course_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `student_id`, `assign_course_id`, `created`) VALUES
(31, 19, 18, '2013-08-25 05:08:06'),
(32, 20, 18, '2013-08-25 05:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `dob`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1377456443, 1, 'Admin', 'istrator', 'ADMIN', '0', '0000-00-00'),
(24, '\0\0', 'humera@gmail.com', '10c194d551b008a72ec90fdc8b77559b93f2409b', NULL, 'humera@gmail.com', NULL, NULL, NULL, NULL, 1373811185, 1376608406, 1, 'humera', NULL, NULL, '545451', '0000-00-00'),
(29, '\0\0', 'jansho@gmail.com', '37a6a9f1e10ee68b361e3ee6daa93496b64e8deb', NULL, 'jansho@gmail.com', NULL, NULL, NULL, NULL, 1374021544, 1377383430, 1, 'shoaib', 'shoaib', NULL, '555555555555', '0000-00-00'),
(30, '\0\0', 'badi@uok.edu', '6ab6c9e4d3801530455b12ebea984199dde7ca48', NULL, 'badi@uok.edu', NULL, NULL, NULL, NULL, 1374094944, 1374094944, 1, 'Badi', NULL, NULL, '5555555555', '0000-00-00'),
(31, '\0\0', 'shakeel@uok.edu', 'dc8abe963dc3cbb7aafb08b7141100f721e36792', NULL, 'shakeel@uok.edu', NULL, NULL, NULL, NULL, 1374095013, 1374095013, 1, 'shakeel', NULL, NULL, '44444', '0000-00-00'),
(32, '\0\0', 'qutub@mail.com', 'a54105e46836de63dcd60a46e8cd44c0c87d2c19', NULL, 'qutub@mail.com', NULL, NULL, NULL, NULL, 1374357451, 1375545205, 1, 'qutub', 'qutub', NULL, '4545454', '0000-00-00'),
(33, '\0\0', 'lala@mial.com', 'c843b35bc12237e51915fdc984fd73133f142ec7', NULL, 'lala@mial.com', NULL, NULL, NULL, NULL, 1374999714, 1374999714, 1, 'lala', 'lala', NULL, '545454', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(52, 1, 1),
(40, 24, 3),
(45, 29, 2),
(46, 30, 3),
(47, 31, 3),
(51, 32, 2),
(50, 33, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_question_attempts`
--

CREATE TABLE IF NOT EXISTS `user_question_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_answer_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_student`
--

CREATE TABLE IF NOT EXISTS `user_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone_father` bigint(12) NOT NULL,
  `phone_home` bigint(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `role_number` varchar(20) DEFAULT NULL,
  `batch_year` varchar(4) DEFAULT NULL COMMENT '2005',
  `section_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user_student`
--

INSERT INTO `user_student` (`id`, `user_id`, `student_id`, `forum_id`, `name`, `dob`, `gender`, `phone_father`, `phone_home`, `email`, `father_name`, `address`, `religion`, `phone`, `role_number`, `batch_year`, `section_id`, `year_id`) VALUES
(18, 29, '12s', 71, 'shoaib', '2013-07-16', 'male', 555555555, 55555555555, 'jansho@gmail.com', 'mannan', 'gulshan', 'islam', 555555555555, '55555555', '2013', 1, 1),
(19, 32, 'aw2', 74, 'qutub', '2013-07-23', 'male', 4545454, 45454545, 'qutub@mail.com', 'syed', 'abcd', 'islam', 4545454, 'fdfdf45', '2014', 1, 1),
(20, 33, '432f', 75, 'lala', '2013-07-09', 'male', 454545, 45454, 'lala@mial.com', 'abdul', 'fsdfsdf', 'islam', 545454, '454545', '2014', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_teacher`
--

CREATE TABLE IF NOT EXISTS `user_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `teacher_id` varchar(20) DEFAULT NULL,
  `forum_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_id in forums_user table',
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL COMMENT 'Engineer',
  `institution` varchar(100) NOT NULL,
  `skills` varchar(100) NOT NULL,
  `designation` enum('professor','assistant professor','lab attendant') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user_teacher`
--

INSERT INTO `user_teacher` (`id`, `user_id`, `teacher_id`, `forum_id`, `name`, `department_id`, `email`, `phone`, `qualification`, `institution`, `skills`, `designation`) VALUES
(20, 24, 'ad2', 65, 'humera', 1, 'humera@gmail.com', 545451, 'Ms', 'uok', 'computer', 'assistant professor'),
(21, 30, '123d', 72, 'Badi', 1, 'badi@uok.edu', 5555555555, 'Ms', 'UOK', 'many', 'assistant professor'),
(22, 31, 'we2', 73, 'shakeel', 2, 'shakeel@uok.edu', 44444, 'ms', 'uok', 'maths', 'lab attendant');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE IF NOT EXISTS `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(10) NOT NULL,
  `year_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `year`, `year_desc`) VALUES
(1, '1st Year', '1st Year'),
(2, '2nd Year', '2nd Year'),
(3, '3rd Year', '3rd Year'),
(4, '4th Year', '4th Year');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
