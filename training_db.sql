-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2020 at 06:03 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `id` int(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `batch` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `attendence` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `autoemailshortcode`
--

CREATE TABLE `autoemailshortcode` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autoemailshortcode`
--

INSERT INTO `autoemailshortcode` (`id`, `name`, `type`) VALUES
(1, '{firstname}', 'payment'),
(2, '{lastname}', 'payment'),
(3, '{name}', 'payment'),
(4, '{amount}', 'payment'),
(5, '{course}', 'payment'),
(6, '{batch}', 'payment'),
(7, '{firstname}', 'studentbatch'),
(8, '{name}', 'studentbatch'),
(9, '{lastname}', 'studentbatch'),
(10, '{course}', 'studentbatch'),
(11, '{batch}', 'studentbatch'),
(12, '{name}', 'instructor'),
(13, '{firstname}', 'instructor'),
(14, '{lastname}', 'instructor'),
(15, '{batch}', 'instructor'),
(16, '{course}', 'instructor'),
(17, '{firstname}', 'student'),
(18, '{lastname}', 'student'),
(19, '{name}', 'student'),
(20, '{name}', 'taskassign'),
(21, '{firstname}', 'taskassign'),
(22, '{lastname}', 'taskassign'),
(23, '{assignbyfirstname}', 'taskassign'),
(24, '{assignbylastname}', 'taskassign'),
(25, '{assignbyname}', 'taskassign'),
(26, '{name}', 'employee'),
(27, '{firstname}', 'employee'),
(28, '{lastname}', 'employee'),
(29, '{institution}', 'employee'),
(30, '{firstname}', 'instructoraapoin'),
(31, '{lastname}', 'instructoraapoin'),
(32, '{name}', 'instructoraapoin'),
(33, '{institution}', 'instructoraapoin'),
(34, '{institution}', 'student'),
(35, '{designation}', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `autoemailtemplate`
--

CREATE TABLE `autoemailtemplate` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autoemailtemplate`
--

INSERT INTO `autoemailtemplate` (`id`, `name`, `message`, `type`, `status`) VALUES
(1, 'Payment successful email to student for batch enrollment', '<p>Dear {name}, Your paying amount - Tk {amount} for course- {course} in batch- {batch} was successful. Thank You</p>\r\n', 'payment', 'Active'),
(2, 'Email to student for enrolling to batch', '<p>Dear {name}, You are enrolled to course- {course} and batch-{batch} . Thank You</p>\r\n', 'studentbatch', 'Active'),
(3, 'Email to instructor for assigning him/her for a batch', '<p>Dear {name}, You are now assigned for course- {course} and batch- {batch}. Thank You</p>\r\n', 'instructor', 'Active'),
(4, 'Email to student to enroll in institution', '<p>Dear {name}, Your are successfully admitted to this institute. Thank You</p>\r\n', 'student', 'Active'),
(5, 'Auto email to employee for notifying their assigning work', '<p>Dear {name}, You are assigned for this task-{taskname} . Assigned By- {assignbyname} Please Check your profile for further details. Thank you</p>\r\n', 'taskassign', 'Active'),
(6, 'Send appoint confirmation to employee', '<p>Dear {name},<br />\r\nYou are appointed as a {designation}&nbsp; in {institution}.<br />\r\nThank YOu</p>\r\n', 'employee', 'Inactive'),
(7, 'Send appoint confirmation to instructor', '<p>Dear {name}, You are appointed as a instructor in {institution}. Thank YOu</p>\r\n', 'instructoraapoin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `autoshortcode`
--

CREATE TABLE `autoshortcode` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `autosmstemplate`
--

CREATE TABLE `autosmstemplate` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autosmstemplate`
--

INSERT INTO `autosmstemplate` (`id`, `name`, `message`, `type`, `status`) VALUES
(1, 'Payment successful sms to student for batch enrollment', 'Dear {name}, Your paying amount - Tk {amount} for course- {course} in batch- {batch} was successful. Thank You\r\nPlease contact our support for furter queries.\r\n\r\n{course}\r\n', 'payment', 'Active'),
(2, 'Sms to student for enrolling to batch', 'Dear {name},\r\nYou are enrolled to course- {course} and batch-{batch} .\r\nThank You', 'studentbatch', 'Active'),
(3, 'Sms to instructor for assigning him/her for a batch', 'Dear {name},\r\nYou are now assigned for course- {course} and batch- {batch}.\r\n\r\nThank You', 'instructor', 'Active'),
(4, 'Sms to student to enroll in institution', 'Dear {name},\r\n Your are successfully admitted to this institute.\r\n\r\n Thank You ', 'student', 'Active'),
(7, 'Auto email to employee for notifying their assigning work', 'Dear {name},\r\nYou are assigned for this task-{taskname} .\r\nAssigned By- {assignbyname}\r\nPlease Check your profile for further details.\r\nThank you', 'taskassign', 'Active'),
(9, 'Send Registration Confirmation to Employee', 'Dear {name},\r\nYou are appointed as a {designation}  in {institution}.\r\nThank YOu', 'employee', 'Active'),
(10, 'Send Registration Confirmation to Instructor', 'Dear {name},\r\nYou are appointed as a instructor in {institution}.\r\nThank YOu', 'instructoraapoin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(100) NOT NULL,
  `batch_id` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `instructor` varchar(100) NOT NULL,
  `course_fee` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `n_o_students` varchar(100) NOT NULL,
  `coursename` varchar(1000) DEFAULT NULL,
  `instructorname` varchar(1000) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `employee` varchar(20) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `batch_id`, `course`, `instructor`, `course_fee`, `start_date`, `end_date`, `n_o_students`, `coursename`, `instructorname`, `start_time`, `end_time`, `feedback`, `employee`, `type`) VALUES
(26, '1', '16', '7', '10000', '1588284000', '1596146400', '', 'PHP', 'Mr Instructor', '09:30 AM', '10:30 AM', NULL, NULL, NULL),
(27, '2', '17', '7', '20000', '1588284000', '1596146400', '', 'React JS', 'Mr Instructor', '10:15 PM', '11:15 PM', 'Welcome Feedback data', '13', 'Support'),
(28, '3', '16', '12', '10000', '1589493600', '1592172000', '', 'PHP', 'Rajesh', '10:00 AM', '11:00 AM', 'The searching functionality provided by DataTables is useful for quickly search through the information in the table - however the search is global, and you may wish to present controls that search on specific columns.', NULL, NULL),
(29, '4', '17', '12', '20000', '1588629600', '1591308000', '', 'React JS', 'Rajesh', '02:15 PM', '03:15 PM', '', '13', 'Trainer');

-- --------------------------------------------------------

--
-- Table structure for table `batch_course`
--

CREATE TABLE `batch_course` (
  `id` int(100) NOT NULL,
  `batch` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `batch_material`
--

CREATE TABLE `batch_material` (
  `id` int(100) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `batch_id` varchar(1000) DEFAULT NULL,
  `batchname` varchar(1000) DEFAULT NULL,
  `course_id` varchar(1000) DEFAULT NULL,
  `coursename` varchar(1000) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `materialid` varchar(1000) DEFAULT NULL,
  `iconurl` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `batch_reports`
--

CREATE TABLE `batch_reports` (
  `id` int(6) UNSIGNED NOT NULL,
  `batch` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `feedback` varchar(50) DEFAULT NULL,
  `start_time` varchar(50) DEFAULT NULL,
  `end_time` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_reports`
--

INSERT INTO `batch_reports` (`id`, `batch`, `date`, `feedback`, `start_time`, `end_time`, `status`) VALUES
(1, 2, '05/15/2020', 'Welcome', '03:00 PM', '04:00 PM', 'stopped');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(100) NOT NULL,
  `course_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `course_fee` varchar(100) NOT NULL,
  `material` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_id`, `name`, `topic`, `duration`, `course_fee`, `material`) VALUES
(16, '1', 'PHP', 'OOPS', '2Months', '10000', ''),
(17, '2', 'React JS', 'React Development', '2', '20000', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_material`
--

CREATE TABLE `course_material` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `addtobatch` varchar(1000) DEFAULT NULL,
  `coursename` varchar(1000) DEFAULT NULL,
  `iconurl` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_material`
--

INSERT INTO `course_material` (`id`, `title`, `category`, `course`, `url`, `addtobatch`, `coursename`, `iconurl`) VALUES
(32, 'Test', '', '16', 'uploads/Testing_Doc.docx', NULL, 'PHP', 'uploads/docxcopy.png');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `dateformat` varchar(1000) DEFAULT NULL,
  `message` varchar(10000) NOT NULL,
  `reciepient` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `path` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `admin_email`, `type`, `user`, `password`) VALUES
(1, 'admin@example.com', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `name`, `message`, `type`) VALUES
(1, 'test2222', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>sds</td>\r\n			<td>sddsd</td>\r\n		</tr>\r\n		<tr>\r\n			<td>sdsds</td>\r\n			<td>sdsd</td>\r\n		</tr>\r\n		<tr>\r\n			<td>ddsds</td>\r\n			<td>sdsds</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n{email}{instructor}', 'email'),
(2, 'sdgfgfdgfdgdf', '{email}{instructor}{address}', 'email'),
(3, 'sdgfgfdgfdgdf', '{email}{instructor}{address}', 'email'),
(4, 'First Name', '{email}{instructor}{address}{course}{batch}', NULL),
(5, 'fgfdgdfgdf', 'gdfgdfgdfgdfgdfgdfgdfg', 'email');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(100) NOT NULL,
  `img_url` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL,
  `ion_user_id` varchar(100) NOT NULL,
  `salary` varchar(10) DEFAULT NULL,
  `incentive` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `img_url`, `name`, `email`, `address`, `designation`, `phone`, `x`, `ion_user_id`, `salary`, `incentive`, `status`, `feedback`) VALUES
(5, 'uploads/favicon5.png', 'Mr. Employee', 'employee@example.com', 'Collegepara, Rajbari', 'Admin Officer', '+0123456789', '', '354', NULL, NULL, NULL, NULL),
(13, 'uploads/1HSisLuifMO6KbLfPOKtLow1.jpeg', 'Pardhu', 'hr@gmail.com', 'Hyderabad', 'HR', '8019664488', '', '', '5000', '1000', 1, 'Welcome');

-- --------------------------------------------------------

--
-- Table structure for table `employee_incentive`
--

CREATE TABLE `employee_incentive` (
  `incentive_id` int(11) NOT NULL,
  `employee` int(11) DEFAULT NULL,
  `incentive` varchar(50) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_incentive`
--

INSERT INTO `employee_incentive` (`incentive_id`, `employee`, `incentive`, `date`) VALUES
(1, 13, '1000', '2020-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `start` varchar(100) NOT NULL,
  `end` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `category`, `date`, `amount`, `user`) VALUES
(77, 'Instructor Salary', '1589003728', '500', ''),
(78, 'Instructor Salary', '1589003735', '300', '');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL,
  `y` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`id`, `category`, `description`, `x`, `y`) VALUES
(53, 'Instructor Salary', 'Expense to Instructor', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `frontend`
--

CREATE TABLE `frontend` (
  `id` int(10) NOT NULL,
  `sliderImage1` varchar(500) NOT NULL,
  `sliderImage2` varchar(500) NOT NULL,
  `sliderImage3` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'Employee', 'For Financial Activities'),
(4, 'Instructor', 'Instructor'),
(5, 'Student', 'Students');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(100) NOT NULL,
  `img_url` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `add_date` varchar(100) NOT NULL,
  `ion_user_id` varchar(100) NOT NULL,
  `technology` varchar(100) DEFAULT NULL,
  `experiance` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `expected_amount` varchar(50) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `ifsc_code` varchar(50) DEFAULT NULL,
  `holder_name` varchar(50) DEFAULT NULL,
  `skill` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `img_url`, `name`, `email`, `phone`, `address`, `dob`, `add_date`, `ion_user_id`, `technology`, `experiance`, `status`, `feedback`, `expected_amount`, `employee`, `bank_name`, `bank_account`, `ifsc_code`, `holder_name`, `skill`, `type`) VALUES
(7, 'uploads/favicon8.png', 'Mr Instructor', 'instructor@example.com', '+0123456789', 'Collegepara, Rajbari', '', '', '353', '', '', 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'uploads/1HSisLuifMO6KbLfPOKtLow.jpeg', 'Rajesh', 'rajesh@gmail.com', '8019664488', 'Hyderabad', '', '', '', 'PHP', '3', 1, NULL, '6000', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'uploads/1HSisLuifMO6KbLfPOKtLow2.jpeg', 'Pardhu', 'pardhu@email.com', '9866700205', 'Hyderabad', '', '', '', 'React Js', '2', 1, 'Tesxvsdf', '20000', NULL, 'Axis', '91401005501665', 'UTIB0005503', 'Rajesh Goud', 'React Js', NULL),
(14, '', 'Praveen', 'praveen.jirra@gmail.com ', '95735 12381', 'Hyderabad', '', '', '', 'Devops & AWS', NULL, 1, NULL, '1000', NULL, NULL, '31555548535', 'SBIN0003742', NULL, 'Git, Docker, Ansible, Kubernetes, AWS', NULL),
(15, '', 'Atul garg', 'atulgarg1993@gmail.com', '7737711250', 'Pune', '', '', '', 'Guidewire PC', NULL, 1, NULL, '1000', NULL, NULL, '2240511879', 'CBIN0280460', NULL, 'Guidewire pc configuration', NULL),
(16, '', 'Tirupathi Rao', 'qatestingmantra@gmail.com ', '99994 90349', 'Hyderabad', '', '', '', 'Guidewire QA', NULL, 1, NULL, '1000', NULL, NULL, '105601527563', 'ICIC0001056', NULL, 'Guidewire QA PC, CC, BC', NULL),
(17, '', 'Shah Fahad', 'shahfahad.cse@gmail.com ', '99718 04003', 'Maharastra', '', '', '', 'Guidewire PC', NULL, 1, NULL, '1000', NULL, NULL, '50100123969951', ' HDFC0000929', NULL, 'Guidewire pc configuration & Integration', NULL),
(18, '', 'Anil', 'anilkumar.gaky@hotmail.com', '96422 20977', 'Hyderabad', '', '', '', 'Devops  ', NULL, 1, NULL, '1000', NULL, NULL, '20323754667', 'SBIN0000890', NULL, 'Devops, Kubernetes, helm, Terraform', NULL),
(19, '', 'Snehanshu Bhushan', 'sneh.misra@gmail.com', '99877 16787', 'Maharastra', '', '', '', 'Kafka', NULL, 1, NULL, '1000', NULL, NULL, '2351000137544', 'HDFC0000235', NULL, 'c,c++,mysql,Project Management,server administration,java,javascript,html,sql,databases,XMl,css,.net,c#,Drupal.php,linux,python,powershell,django,visual basic,JSOn,restful web services,SOAP,AWS,azure,AWSCWI,networking,web hosting,API development,WSDL,XML schema design,cassandra,Apache kafka,zookeeper,php develloper,kafka cluster,PCF\n\n', NULL),
(20, '', 'Kishore', 'kallurukishoredyn@gmail.com', '90525 22341', 'Singapore', '', '', '', 'Data cap', NULL, NULL, NULL, NULL, NULL, NULL, '100054154505', 'INDB0000226', NULL, 'Data cap, filenet admin, ICN', NULL),
(21, '', 'Harish', 'thathaharish@hotmail.com', '90008 86765', 'Hyderabad', '', '', '', 'Filenet developer', NULL, NULL, NULL, NULL, NULL, NULL, '50100157196496', 'HDFC0003777', NULL, 'Filenet developer', NULL),
(22, '', 'Tarun', 'tarunindia37@gmail.com', '89288 24606', 'Pune', '', '', '', 'Core Java', NULL, NULL, NULL, NULL, NULL, NULL, '4513183441', ' KKBK0000726', NULL, 'Java, spring, hibernate, restful webservices, JavaScript, typescript, Reactjs, CSS, Databases, core java', NULL),
(23, '', 'Hari Shankar Tripathi', 'tripathi.hsr@gmail.com', '78383 76366', 'Gurgoan', '', '', '', 'Devops', NULL, NULL, NULL, NULL, NULL, NULL, '7838376366', '2312294504', NULL, 'DevOps & Cloud evangelist | 3 × AWS certified | Hybris commerce environment specialist', NULL),
(24, '', 'Praveen', 'praveen.jirra@gmail.com ', '95735 12381', 'Hyderabad', '', '', '', 'Devops & AWS', NULL, 1, NULL, '1000', NULL, NULL, '31555548535', 'SBIN0003742', NULL, 'Git, Docker, Ansible, Kubernetes, AWS', NULL),
(25, '', 'Atul garg', 'atulgarg1993@gmail.com', '7737711250', 'Pune', '', '', '', 'Guidewire PC', NULL, 1, NULL, '1000', NULL, NULL, '2240511879', 'CBIN0280460', NULL, 'Guidewire pc configuration', NULL),
(26, '', 'Tirupathi Rao', 'qatestingmantra@gmail.com ', '99994 90349', 'Hyderabad', '', '', '', 'Guidewire QA', NULL, 1, NULL, '1000', NULL, NULL, '105601527563', 'ICIC0001056', NULL, 'Guidewire QA PC, CC, BC', NULL),
(27, '', 'Shah Fahad', 'shahfahad.cse@gmail.com ', '99718 04003', 'Maharastra', '', '', '', 'Guidewire PC', NULL, 1, NULL, '1000', NULL, NULL, '50100123969951', ' HDFC0000929', NULL, 'Guidewire pc configuration & Integration', NULL),
(28, '', 'Anil', 'anilkumar.gaky@hotmail.com', '96422 20977', 'Hyderabad', '', '', '', 'Devops  ', NULL, 1, NULL, '1000', NULL, NULL, '20323754667', 'SBIN0000890', NULL, 'Devops, Kubernetes, helm, Terraform', NULL),
(29, '', 'Snehanshu Bhushan', 'sneh.misra@gmail.com', '99877 16787', 'Maharastra', '', '', '', 'Kafka', NULL, 1, NULL, '1000', NULL, NULL, '2351000137544', 'HDFC0000235', NULL, 'c,c++,mysql,Project Management,server administration,java,javascript,html,sql,databases,XMl,css,.net,c#,Drupal.php,linux,python,powershell,django,visual basic,JSOn,restful web services,SOAP,AWS,azure,AWSCWI,networking,web hosting,API development,WSDL,XML schema design,cassandra,Apache kafka,zookeeper,php develloper,kafka cluster,PCF\n\n', NULL),
(30, '', 'Kishore', 'kallurukishoredyn@gmail.com', '90525 22341', 'Singapore', '', '', '', 'Data cap', NULL, NULL, NULL, NULL, NULL, NULL, '100054154505', 'INDB0000226', NULL, 'Data cap, filenet admin, ICN', NULL),
(31, '', 'Harish', 'thathaharish@hotmail.com', '90008 86765', 'Hyderabad', '', '', '', 'Filenet developer', NULL, NULL, NULL, NULL, NULL, NULL, '50100157196496', 'HDFC0003777', NULL, 'Filenet developer', NULL),
(32, '', 'Tarun', 'tarunindia37@gmail.com', '89288 24606', 'Pune', '', '', '', 'Core Java', NULL, NULL, NULL, NULL, NULL, NULL, '4513183441', ' KKBK0000726', NULL, 'Java, spring, hibernate, restful webservices, JavaScript, typescript, Reactjs, CSS, Databases, core java', NULL),
(33, '', 'Hari Shankar Tripathi', 'tripathi.hsr@gmail.com', '78383 76366', 'Gurgoan', '', '', '', 'Devops', NULL, NULL, NULL, NULL, NULL, NULL, '7838376366', '2312294504', NULL, 'DevOps & Cloud evangelist | 3 × AWS certified | Hybris commerce environment specialist', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `manualemailshortcode`
--

CREATE TABLE `manualemailshortcode` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manualemailshortcode`
--

INSERT INTO `manualemailshortcode` (`id`, `name`, `type`) VALUES
(1, '{firstname}', 'email'),
(2, '{lastname}', 'email'),
(3, '{name}', 'email'),
(4, '{batch}', 'email'),
(5, '{course}', 'email'),
(6, '{address}', 'email'),
(7, '{instructor}', 'email'),
(8, '{email}', 'email'),
(9, '{phone}', 'email');

-- --------------------------------------------------------

--
-- Table structure for table `manualshortcode`
--

CREATE TABLE `manualshortcode` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manualshortcode`
--

INSERT INTO `manualshortcode` (`id`, `name`, `type`) VALUES
(1, '{firstname}', 'sms'),
(2, '{lastname}', 'sms'),
(3, '{name}', 'sms'),
(4, '{email}', 'sms'),
(5, '{phone}', 'sms'),
(6, '{address}', 'sms'),
(7, '{batch}', 'sms'),
(8, '{instructor}', 'sms'),
(10, '{course}', 'sms');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` varchar(100) NOT NULL,
  `add_date` varchar(100) NOT NULL,
  `adddate` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `office_log`
--

CREATE TABLE `office_log` (
  `id` int(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `sign_in_time` varchar(100) NOT NULL,
  `sign_in_ip` varchar(100) NOT NULL,
  `sign_out_time` varchar(100) NOT NULL,
  `sign_out_ip` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(10) NOT NULL,
  `date` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `batch` varchar(100) NOT NULL,
  `student` varchar(100) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL DEFAULT '0',
  `discount` varchar(100) NOT NULL DEFAULT '0',
  `gross_total` varchar(100) NOT NULL,
  `amount_received` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `next_payment_date` varchar(100) DEFAULT NULL,
  `invoice_id` varchar(100) DEFAULT NULL,
  `tds` int(11) DEFAULT NULL,
  `paid_amount_date` varchar(50) DEFAULT NULL,
  `second_payment` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `date`, `course`, `batch`, `student`, `student_name`, `amount`, `vat`, `discount`, `gross_total`, `amount_received`, `status`, `next_payment_date`, `invoice_id`, `tds`, `paid_amount_date`, `second_payment`) VALUES
(443, '1589539490', '16', '27', '41', 'Rajesh', '2000', '0', '', '2000', '', '', '06/01/2020', '121', 0, '05/15/2020', 0),
(444, '1588677742', '16', '28', '6', 'Mr Student', '2000', '0', '0', '2000', '', '', '05/08/2020', NULL, NULL, NULL, 0),
(445, '1589376106', '16', '28', '6', 'Mr Student', '10000', '0', '', '10000', '', '', '05/08/2020', '12121212', 10, '05/14/2020', 0),
(446, '1589376092', '16', '28', '41', 'Mr Student', '1000', '0', '5', '995', '', '', '06/13/2020', '121', 10, '05/13/2020', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_category`
--

CREATE TABLE `payment_category` (
  `id` int(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `c_price` varchar(100) NOT NULL,
  `d_commission` int(100) NOT NULL,
  `h_commission` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pgateway`
--

CREATE TABLE `pgateway` (
  `id` int(11) NOT NULL,
  `gateway` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `signature` varchar(500) NOT NULL,
  `merchant_key` varchar(500) NOT NULL,
  `salt` varchar(500) NOT NULL,
  `publish` varchar(500) NOT NULL,
  `secret` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pgateway`
--

INSERT INTO `pgateway` (`id`, `gateway`, `username`, `password`, `signature`, `merchant_key`, `salt`, `publish`, `secret`, `status`) VALUES
(1, 'PayPal', '', '', '', '', '', '', '', ''),
(2, 'Stripe', '', '', '', '', '', '', '', ''),
(3, 'PayU Money', '', '', '', '', '', '', '', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `routine`
--

CREATE TABLE `routine` (
  `id` int(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `batch_id` varchar(100) NOT NULL,
  `batchcode` varchar(1000) DEFAULT NULL,
  `routine` varchar(5000) DEFAULT NULL,
  `x` varchar(100) NOT NULL,
  `y` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `system_vendor` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `facebook_id` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL,
  `date_format` varchar(100) NOT NULL,
  `login_title` varchar(100) NOT NULL,
  `login_logoo` varchar(100) NOT NULL,
  `codec_username` varchar(100) NOT NULL,
  `codec_purchase_code` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `sms_gateway` varchar(100) DEFAULT NULL,
  `payment_gateway` varchar(100) NOT NULL,
  `fb_link` varchar(100) DEFAULT NULL,
  `twitter_link` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_vendor`, `title`, `address`, `phone`, `email`, `facebook_id`, `currency`, `discount`, `vat`, `date_format`, `login_title`, `login_logoo`, `codec_username`, `codec_purchase_code`, `language`, `sms_gateway`, `payment_gateway`, `fb_link`, `twitter_link`) VALUES
(1, 'Code Aristos Training Academy', 'Trai ning', 'CollegePara, Rajbari', '+012345678', 'admin@example.com', '#', 'Rs.', '', 'percentage', '2', 'Training Center Management System', 'uploads/thumbnail.jpg', '', '', 'english', 'Twilio', 'PayPal', 'http://facebook.com', 'http://twitter.com');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` int(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `dateformat` varchar(100) DEFAULT NULL,
  `message` varchar(100) NOT NULL,
  `recipient` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `api_id` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `authkey` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `sid` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `sendernumber` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `name`, `username`, `password`, `api_id`, `sender`, `authkey`, `user`, `sid`, `token`, `sendernumber`) VALUES
(1, 'Clickatell', '', '', '', '', '', '1', '', '', ''),
(2, 'MSG91', '', '', '', '', '', '1', '', '', ''),
(5, 'Twilio', '', '', '', '', '', '1', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(100) NOT NULL,
  `img_url` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `add_date` varchar(100) NOT NULL,
  `ion_user_id` varchar(100) NOT NULL,
  `employee` int(11) DEFAULT NULL,
  `lead_from` varchar(255) DEFAULT NULL,
  `bank_details` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `img_url`, `name`, `email`, `address`, `phone`, `dob`, `add_date`, `ion_user_id`, `employee`, `lead_from`, `bank_details`, `status`) VALUES
(6, 'uploads/favicon3.png', 'Mr Student', 'student@example.com', 'Collegepara, Rajbari', '+0123456789', '', '1486066379', '358', 5, NULL, NULL, NULL),
(41, 'uploads/user-icon-male-person-profile-avatar-symbol-vector-20910842.jpg', 'Rajesh', 'rajeshgoud6785@gmail.com', 'Hyderabad', '9866700205', '', '1588396741', '', 5, NULL, NULL, NULL),
(42, '', 'Test1212', 'admin1@example.com', 'Hyderabad', '8019664488', '', '1588509952', '', 5, NULL, NULL, NULL),
(43, '', 'Venky', 'venky@gmail.com', 'Hyderabad', '8019664488', '', '1588675436', '', 5, 'Dot Consultancy', 'Rajesh Account Details', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_batch`
--

CREATE TABLE `student_batch` (
  `id` int(100) NOT NULL,
  `student` varchar(100) NOT NULL,
  `batch` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_batch`
--

INSERT INTO `student_batch` (`id`, `student`, `batch`) VALUES
(44, '41', '27'),
(45, '6', '27'),
(46, '41', '28');

-- --------------------------------------------------------

--
-- Table structure for table `student_lead`
--

CREATE TABLE `student_lead` (
  `lead_id` int(11) NOT NULL,
  `student` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_lead`
--

INSERT INTO `student_lead` (`lead_id`, `student`, `feedback`, `status`) VALUES
(1, 41, 'Interested but need some time', '0'),
(2, 41, 'Testing', '0'),
(3, 41, 'Payment Recieved', '0'),
(4, 6, 'Payment done', 'Payment Recieved');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `requested_by` varchar(100) NOT NULL,
  `requested_for` varchar(100) NOT NULL,
  `to_do` varchar(1000) NOT NULL,
  `timeline` varchar(100) NOT NULL,
  `to_do_report` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `add_date` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL,
  `requested_byname` varchar(1000) DEFAULT NULL,
  `requested_forname` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `x` varchar(100) NOT NULL,
  `y` varchar(100) NOT NULL,
  `z` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `name`, `message`, `type`) VALUES
(1, 'test', '{firstname} come to my offce {lastname}', 'sms'),
(2, 'test11', '{address} {name}{name} {phone}', 'sms'),
(3, 'sdgfgfdgfdgdf', '<p>{email}{instructor}{address} gfdgdfg</p>\r\n', 'email'),
(4, 'qwert', ' {firstname} is this', 'sms'),
(6, 'dsfsdfsdfds', ' {firstname}{lastname}{name}{address}{email}{phone}', 'sms'),
(7, 'test223', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>dsfsf</td>\r\n			<td>sdfsdf</td>\r\n		</tr>\r\n		<tr>\r\n			<td>sdfdsf</td>\r\n			<td>dfdsf</td>\r\n		</tr>\r\n		<tr>\r\n			<td>dfdf</td>\r\n			<td>dfdfd</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n{email}{instructor}', 'email');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'admin', '$2y$08$OAgeNPIn69nNwsN3nWxN1.ymfB21romB.m6LDPmlRcY8EVn8Xz8aC', '', 'admin@example.com', '', 'dc10sss4EZougSSnIBO8gu314b5803e044d47f0c', 1435777809, 'zCeJpcj78CKqJ4sVxVbxcO', 1268889823, 1589549130, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(353, '103.231.160.34', 'Mr Instructor', '$2y$08$X4xfhwAb5Uo3p543uhGhi.8T/FFU3RUxHIWEZ6UA5JqMBfZ05VWBy', NULL, 'instructor@example.com', NULL, NULL, NULL, NULL, 1485348618, 1576672054, 1, NULL, NULL, NULL, NULL),
(354, '103.231.160.34', 'Mr. Employee', '$2y$08$wJ6ApXTu4pHYPs5roPob2OXYq2NLusOT0NzpXNO/qkc9O92A1/8j6', NULL, 'employee@example.com', NULL, NULL, NULL, NULL, 1485348676, 1576671582, 1, NULL, NULL, NULL, NULL),
(358, '110.76.129.222', 'student@example.com', '$2y$08$OAgeNPIn69nNwsN3nWxN1.ymfB21romB.m6LDPmlRcY8EVn8Xz8aC', NULL, 'student@example.com', NULL, NULL, NULL, NULL, 1486066379, 1588242261, 1, NULL, NULL, NULL, NULL),
(376, '::1', 'rajeshgoud6785@gmail.com', '$2y$08$yzueab.G9Dl47MnfLtHDxOindmopP76i8iZMahaDUd8MsNRcWbsGi', NULL, 'rajeshgoud6785@gmail.com', NULL, NULL, NULL, NULL, 1588396741, NULL, 1, NULL, NULL, NULL, NULL),
(377, '::1', 'Rajesh', '$2y$08$7.XkVHh.MIcwE5UmnRBdX.ZgJT1TvaSuQOWu/vRLsWtPPWDbEUmzG', NULL, 'rajesh@gmail.com', NULL, NULL, NULL, NULL, 1588417914, NULL, 1, NULL, NULL, NULL, NULL),
(378, '::1', 'Pardhu', '$2y$08$s.UtWE70tET6IZcaPoYwH.qTYnTR8t.DW.MDQjomfNvWviGOI8tAK', NULL, 'hr@gmail.com', NULL, NULL, NULL, NULL, 1588436449, NULL, 1, NULL, NULL, NULL, NULL),
(379, '::1', 'Pardhu1', '$2y$08$cInoV8HBKwr1VTMxJuLwCeeWc9fXewSRap7mVnQSjvoT6D1DLQm8a', NULL, 'pardhu@email.com', NULL, NULL, NULL, NULL, 1588437583, NULL, 1, NULL, NULL, NULL, NULL),
(380, '::1', 'admin1@example.com', '$2y$08$liq8px6uzQR8rvyVg6ypxOvXMGMVw7Pszx.TRkg9tP6SfBFtlrDDq', NULL, 'admin1@example.com', NULL, NULL, NULL, NULL, 1588509952, NULL, 1, NULL, NULL, NULL, NULL),
(381, '::1', 'venky@gmail.com', '$2y$08$7FoU//cZCHAgWhq.Yl2ULu2azbNT15A7gijWML66k5b.qDG/CEAem', NULL, 'venky@gmail.com', NULL, NULL, NULL, NULL, 1588675436, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(355, 353, 4),
(356, 354, 3),
(360, 358, 5),
(378, 376, 5),
(379, 377, 4),
(380, 378, 3),
(381, 379, 4),
(382, 380, 5),
(383, 381, 5);

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(100) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `tumblr` varchar(500) NOT NULL,
  `slider1` varchar(500) NOT NULL,
  `slider2` varchar(500) NOT NULL,
  `slider3` varchar(500) NOT NULL,
  `course1` varchar(100) NOT NULL,
  `course1detail` varchar(500) NOT NULL,
  `course2` varchar(100) NOT NULL,
  `course2detail` varchar(500) NOT NULL,
  `course3` varchar(100) NOT NULL,
  `course3detail` varchar(500) NOT NULL,
  `instructor1` varchar(100) NOT NULL,
  `instructor1detail` varchar(500) NOT NULL,
  `instructor2` varchar(100) NOT NULL,
  `instructor2detail` varchar(500) NOT NULL,
  `instructor3` varchar(100) NOT NULL,
  `instructor3detail` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `about`, `facebook`, `twitter`, `tumblr`, `slider1`, `slider2`, `slider3`, `course1`, `course1detail`, `course2`, `course2detail`, `course3`, `course3detail`, `instructor1`, `instructor1detail`, `instructor2`, `instructor2detail`, `instructor3`, `instructor3detail`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.                                                                                                                                                                                                                                                                                                                                                                                                                                    ', 'https://www.facebook.com/casft', '#', '#', 'uploads/1UVm5I1j351RFw8aLHpVs5g.jpg', '', '', 'CSE115', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', 'CSE235', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', 'CSE456', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', 'asa', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', 'aga', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', 'ada', ' Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autoemailshortcode`
--
ALTER TABLE `autoemailshortcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autoemailtemplate`
--
ALTER TABLE `autoemailtemplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autoshortcode`
--
ALTER TABLE `autoshortcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autosmstemplate`
--
ALTER TABLE `autosmstemplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_course`
--
ALTER TABLE `batch_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_material`
--
ALTER TABLE `batch_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_reports`
--
ALTER TABLE `batch_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_material`
--
ALTER TABLE `course_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_incentive`
--
ALTER TABLE `employee_incentive`
  ADD PRIMARY KEY (`incentive_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontend`
--
ALTER TABLE `frontend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manualemailshortcode`
--
ALTER TABLE `manualemailshortcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manualshortcode`
--
ALTER TABLE `manualshortcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_log`
--
ALTER TABLE `office_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_category`
--
ALTER TABLE `payment_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pgateway`
--
ALTER TABLE `pgateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routine`
--
ALTER TABLE `routine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_batch`
--
ALTER TABLE `student_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_lead`
--
ALTER TABLE `student_lead`
  ADD PRIMARY KEY (`lead_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `autoemailshortcode`
--
ALTER TABLE `autoemailshortcode`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `autoemailtemplate`
--
ALTER TABLE `autoemailtemplate`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `autoshortcode`
--
ALTER TABLE `autoshortcode`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `autosmstemplate`
--
ALTER TABLE `autosmstemplate`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `batch_course`
--
ALTER TABLE `batch_course`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch_material`
--
ALTER TABLE `batch_material`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `batch_reports`
--
ALTER TABLE `batch_reports`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `course_material`
--
ALTER TABLE `course_material`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_incentive`
--
ALTER TABLE `employee_incentive`
  MODIFY `incentive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `frontend`
--
ALTER TABLE `frontend`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `manualemailshortcode`
--
ALTER TABLE `manualemailshortcode`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `manualshortcode`
--
ALTER TABLE `manualshortcode`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `office_log`
--
ALTER TABLE `office_log`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- AUTO_INCREMENT for table `payment_category`
--
ALTER TABLE `payment_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pgateway`
--
ALTER TABLE `pgateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routine`
--
ALTER TABLE `routine`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `student_batch`
--
ALTER TABLE `student_batch`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `student_lead`
--
ALTER TABLE `student_lead`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=384;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
