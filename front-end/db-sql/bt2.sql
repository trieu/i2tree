-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4126
-- Date/time:                    2012-07-05 11:16:33
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table brain_tuner.bt_scorers
DROP TABLE IF EXISTS `bt_scorers`;
CREATE TABLE IF NOT EXISTS `bt_scorers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `answered_question` int(10) unsigned NOT NULL,
  `star` int(10) unsigned NOT NULL,
  `os` varchar(20) NOT NULL,
  `os_version` varchar(30) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `social_security_number` varchar(20) NOT NULL,
  `timestamp` bigint(20) unsigned NOT NULL,
  `gps_lat` float unsigned DEFAULT NULL,
  `gps_lon` float unsigned DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `region_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table brain_tuner.bt_scorers: ~0 rows (approximately)
DELETE FROM `bt_scorers`;
/*!40000 ALTER TABLE `bt_scorers` DISABLE KEYS */;
/*!40000 ALTER TABLE `bt_scorers` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
