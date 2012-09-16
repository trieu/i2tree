-- --------------------------------------------------------
-- Host:                         72.3.204.194
-- Server version:               5.1.61-log - Percona Server (GPL), 13.2, Revision 2
-- Server OS:                    unknown-linux-gnu
-- HeidiSQL version:             7.0.0.4126
-- Date/time:                    2012-09-16 06:41:43
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table 549152_bt2.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.categories: ~9 rows (approximately)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Advertising Services'),
	(2, 'Business Services'),
	(3, 'Coupon Services'),
	(4, 'Education Services'),
	(5, 'Gifting Services'),
	(6, 'SEO Services'),
	(7, 'Translation Services'),
	(8, 'Website Services'),
	(9, 'Writing Services');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.info_nodes
DROP TABLE IF EXISTS `info_nodes`;
CREATE TABLE IF NOT EXISTS `info_nodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `thumbnail_url` varchar(1000) DEFAULT '''''',
  `title` varchar(200) NOT NULL DEFAULT '''''',
  `content` text NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `creation_date` bigint(20) NOT NULL,
  `is_paid` tinyint(4) DEFAULT '0',
  `is_problem` tinyint(4) DEFAULT '0',
  `price` float DEFAULT '0',
  `user_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.info_nodes: ~2 rows (approximately)
DELETE FROM `info_nodes`;
/*!40000 ALTER TABLE `info_nodes` DISABLE KEYS */;
INSERT INTO `info_nodes` (`id`, `thumbnail_url`, `title`, `content`, `category`, `creation_date`, `is_paid`, `is_problem`, `price`, `user_id`) VALUES
	(1, 'http://www.jobsfor10.com/uploads/job/26cb55bf220a0f4ff2dadd7038e4c2886769e39e.jpg', 'I can successfully submit your website to over 900 directories and classified sites', 'I will submit your site to about 1509 websites that will provide you with seo backlinks to your site. Of these 1500+, You can expect around a 70% success rate, meaning your site should be accepted to over 900 directories. I will provide you with a full report of the submission and give you all the details of the successes. Some of them require a confirmation link to be clicked, so IF you want, I can also do that for you. ========================================" If you prefer to receive the emails so you can click and confirm them yourself, let me know. The report will show the submissions and those that are accepted will backlink to your site. I can\'t guarantee how many backlinks will show up, but they should start increasing within the week. I NEED:- 1) Your URL 2) Your name {first & last} 3) email 4) Title/keyword 5) Who should confirm the submission emails: you or me? (I suggest you so you can see the result).', 1, 0, 1, 0, 10, 1),
	(3, 'http://www.jobsfor10.com/uploads/job/26cb55bf220a0f4ff2dadd7038e4c2886769e39e.jpg', 'I need someone do marketing for my website', 'I need someone do marketing for my website, tasks are PR and sharing on facebook page', 1, 0, 1, 1, 5, 2);
/*!40000 ALTER TABLE `info_nodes` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.markers
DROP TABLE IF EXISTS `markers`;
CREATE TABLE IF NOT EXISTS `markers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `info_node_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.markers: ~0 rows (approximately)
DELETE FROM `markers`;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.object_tag
DROP TABLE IF EXISTS `object_tag`;
CREATE TABLE IF NOT EXISTS `object_tag` (
  `tag_id` int(11) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`tag_id`,`object_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.object_tag: ~0 rows (approximately)
DELETE FROM `object_tag`;
/*!40000 ALTER TABLE `object_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `object_tag` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.problem_answer
DROP TABLE IF EXISTS `problem_answer`;
CREATE TABLE IF NOT EXISTS `problem_answer` (
  `problem_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL,
  `creation_date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`problem_id`,`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.problem_answer: ~0 rows (approximately)
DELETE FROM `problem_answer`;
/*!40000 ALTER TABLE `problem_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `problem_answer` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.tags
DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.tags: ~0 rows (approximately)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;


-- Dumping structure for table 549152_bt2.user_device_ids
DROP TABLE IF EXISTS `user_device_ids`;
CREATE TABLE IF NOT EXISTS `user_device_ids` (
  `user_id` bigint(20) unsigned NOT NULL,
  `device_id` varchar(150) NOT NULL,
  `os_name` varchar(20) NOT NULL,
  `os_version` varchar(10) DEFAULT NULL,
  `notication_count` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`device_id`,`os_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 549152_bt2.user_device_ids: ~0 rows (approximately)
DELETE FROM `user_device_ids`;
/*!40000 ALTER TABLE `user_device_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_device_ids` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
