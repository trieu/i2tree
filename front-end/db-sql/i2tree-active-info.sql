-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4126
-- Date/time:                    2012-10-05 17:29:38
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table i2tree.applications
DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `client_secret` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(250) NOT NULL DEFAULT '',
  `auto_approve` tinyint(1) NOT NULL DEFAULT '0',
  `autonomous` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('development','pending','approved','rejected') NOT NULL DEFAULT 'development',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `notes` tinytext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.applications: ~1 rows (approximately)
DELETE FROM `applications`;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` (`id`, `name`, `client_id`, `client_secret`, `redirect_uri`, `auto_approve`, `autonomous`, `status`, `suspended`, `notes`) VALUES
	(100, 'mobile app test', 'hello-i2tree', 'e10adc3949ba59abbe56e057f20f883e', 'http://localhost/i2tree/index.php/unit-tests/', 1, 0, 'development', 0, NULL);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;


-- Dumping structure for table i2tree.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table i2tree.categories: ~9 rows (approximately)
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


-- Dumping structure for table i2tree.groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.groups: ~3 rows (approximately)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Administrator'),
	(2, 'operator', 'Operator'),
	(3, 'user', 'User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Dumping structure for table i2tree.info_nodes
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

-- Dumping data for table i2tree.info_nodes: ~2 rows (approximately)
DELETE FROM `info_nodes`;
/*!40000 ALTER TABLE `info_nodes` DISABLE KEYS */;
INSERT INTO `info_nodes` (`id`, `thumbnail_url`, `title`, `content`, `category`, `creation_date`, `is_paid`, `is_problem`, `price`, `user_id`) VALUES
	(1, 'http://www.jobsfor10.com/uploads/job/26cb55bf220a0f4ff2dadd7038e4c2886769e39e.jpg', 'I can successfully submit your website to over 900 directories and classified sites', 'I will submit your site to about 1509 websites that will provide you with seo backlinks to your site. Of these 1500+, You can expect around a 70% success rate, meaning your site should be accepted to over 900 directories. I will provide you with a full report of the submission and give you all the details of the successes. Some of them require a confirmation link to be clicked, so IF you want, I can also do that for you. ========================================" If you prefer to receive the emails so you can click and confirm them yourself, let me know. The report will show the submissions and those that are accepted will backlink to your site. I can\'t guarantee how many backlinks will show up, but they should start increasing within the week. I NEED:- 1) Your URL 2) Your name {first & last} 3) email 4) Title/keyword 5) Who should confirm the submission emails: you or me? (I suggest you so you can see the result).', 1, 0, 1, 0, 10, 1),
	(3, 'http://www.jobsfor10.com/uploads/job/26cb55bf220a0f4ff2dadd7038e4c2886769e39e.jpg', 'I need someone do marketing for my website', 'I need someone do marketing for my website, tasks are PR and sharing on facebook page', 1, 0, 1, 1, 5, 2);
/*!40000 ALTER TABLE `info_nodes` ENABLE KEYS */;


-- Dumping structure for table i2tree.markers
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

-- Dumping data for table i2tree.markers: ~0 rows (approximately)
DELETE FROM `markers`;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;


-- Dumping structure for table i2tree.meta
DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ext_info` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.meta: ~2 rows (approximately)
DELETE FROM `meta`;
/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
INSERT INTO `meta` (`id`, `user_id`, `first_name`, `last_name`, `ext_info`) VALUES
	(2, 3, 'Trieu', 'Nguyen', '0'),
	(13, 15, 'tantrieuf31', 'databased', '0');
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;


-- Dumping structure for table i2tree.oauth_sessions
DROP TABLE IF EXISTS `oauth_sessions`;
CREATE TABLE IF NOT EXISTS `oauth_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(250) NOT NULL DEFAULT '',
  `type_id` varchar(64) DEFAULT NULL,
  `type` enum('user','auto') NOT NULL DEFAULT 'user',
  `code` text,
  `access_token` varchar(50) DEFAULT '',
  `stage` enum('request','granted') NOT NULL DEFAULT 'request',
  `first_requested` int(10) unsigned NOT NULL,
  `last_updated` int(10) unsigned NOT NULL,
  `limited_access` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Used for user agent flows',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `applications` (`client_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.oauth_sessions: ~1 rows (approximately)
DELETE FROM `oauth_sessions`;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;
INSERT INTO `oauth_sessions` (`id`, `client_id`, `redirect_uri`, `type_id`, `type`, `code`, `access_token`, `stage`, `first_requested`, `last_updated`, `limited_access`) VALUES
	(2, 'hello-i2tree', 'http://localhost/i2tree/index.php/unit-tests/', '1000', 'user', NULL, '3916f65b0af4687b30da58048815fab67416a874', 'granted', 1333475921, 1333478728, 0);
/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;


-- Dumping structure for table i2tree.oauth_session_scopes
DROP TABLE IF EXISTS `oauth_session_scopes`;
CREATE TABLE IF NOT EXISTS `oauth_session_scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `scope` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `scope` (`scope`),
  KEY `access_token` (`access_token`),
  CONSTRAINT `oauth_session_scopes_ibfk_1` FOREIGN KEY (`scope`) REFERENCES `scopes` (`scope`),
  CONSTRAINT `oauth_session_scopes_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.oauth_session_scopes: ~1 rows (approximately)
DELETE FROM `oauth_session_scopes`;
/*!40000 ALTER TABLE `oauth_session_scopes` DISABLE KEYS */;
INSERT INTO `oauth_session_scopes` (`id`, `session_id`, `access_token`, `scope`) VALUES
	(2, 2, '3916f65b0af4687b30da58048815fab67416a874', 'user.details');
/*!40000 ALTER TABLE `oauth_session_scopes` ENABLE KEYS */;


-- Dumping structure for table i2tree.object_tag
DROP TABLE IF EXISTS `object_tag`;
CREATE TABLE IF NOT EXISTS `object_tag` (
  `tag_id` int(11) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`tag_id`,`object_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table i2tree.object_tag: ~0 rows (approximately)
DELETE FROM `object_tag`;
/*!40000 ALTER TABLE `object_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `object_tag` ENABLE KEYS */;


-- Dumping structure for table i2tree.problem_answer
DROP TABLE IF EXISTS `problem_answer`;
CREATE TABLE IF NOT EXISTS `problem_answer` (
  `problem_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL,
  `creation_date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`problem_id`,`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table i2tree.problem_answer: ~0 rows (approximately)
DELETE FROM `problem_answer`;
/*!40000 ALTER TABLE `problem_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `problem_answer` ENABLE KEYS */;


-- Dumping structure for table i2tree.scopes
DROP TABLE IF EXISTS `scopes`;
CREATE TABLE IF NOT EXISTS `scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.scopes: ~1 rows (approximately)
DELETE FROM `scopes`;
/*!40000 ALTER TABLE `scopes` DISABLE KEYS */;
INSERT INTO `scopes` (`id`, `scope`, `name`, `description`) VALUES
	(1, 'user.details', 'user.details', 'Get user\'s details');
/*!40000 ALTER TABLE `scopes` ENABLE KEYS */;


-- Dumping structure for table i2tree.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.sessions: ~0 rows (approximately)
DELETE FROM `sessions`;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;


-- Dumping structure for table i2tree.students
DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(100) DEFAULT '0',
  `name` text,
  `email` varchar(500) DEFAULT NULL,
  `school` varchar(500) DEFAULT NULL,
  `year` int(10) unsigned DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table i2tree.students: ~0 rows (approximately)
DELETE FROM `students`;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;


-- Dumping structure for table i2tree.tags
DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table i2tree.tags: ~0 rows (approximately)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;


-- Dumping structure for table i2tree.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) CHARACTER SET utf8 NOT NULL,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `activation_code` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `forgotten_password_code` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `data_of_birth` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table i2tree.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `data_of_birth`) VALUES
	(3, 1, '127.0.0.1', 'trieu_drd', '0f376afb66926ffb0f4604223fd83d537b64c415', 'trieu@drdvietnam.com', '0', '0', 0),
	(15, 3, '127.0.0.1', 'tantrieuf31.dat', '92cd9fbe4db5e57eaa6f1f63881d6f43f0c3181d', 'tantrieuf31.database@gmail.com', '0', '0', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table i2tree.user_device_ids
DROP TABLE IF EXISTS `user_device_ids`;
CREATE TABLE IF NOT EXISTS `user_device_ids` (
  `user_id` bigint(20) unsigned NOT NULL,
  `device_id` varchar(150) NOT NULL,
  `os_name` varchar(20) NOT NULL,
  `os_version` varchar(10) DEFAULT NULL,
  `notication_count` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`device_id`,`os_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table i2tree.user_device_ids: ~0 rows (approximately)
DELETE FROM `user_device_ids`;
/*!40000 ALTER TABLE `user_device_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_device_ids` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
