-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.15 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных test
CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test`;

-- Дамп структуры для таблица test.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` tinytext,
  `name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Имена для телефонных номеров';

-- Дамп данных таблицы test.contacts: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
REPLACE INTO `contacts` (`id`, `phone`, `name`) VALUES
	(1, '+380123456789', 'Contact #1');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;

-- Дамп структуры для таблица test.sim_events
CREATE TABLE IF NOT EXISTS `sim_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sim_ID` int(10) unsigned DEFAULT NULL,
  `request_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `response_time` datetime DEFAULT NULL,
  `request` tinytext,
  `response` text,
  `phone` tinytext,
  `type` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы test.sim_events: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `sim_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim_events` ENABLE KEYS */;

-- Дамп структуры для таблица test.sim_users
CREATE TABLE IF NOT EXISTS `sim_users` (
  `sim_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_ID` int(10) unsigned DEFAULT NULL,
  `number` tinytext,
  `balance` tinytext,
  `User_Agent` tinytext,
  PRIMARY KEY (`sim_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы test.sim_users: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `sim_users` DISABLE KEYS */;
REPLACE INTO `sim_users` (`sim_ID`, `user_ID`, `number`, `balance`, `User_Agent`) VALUES
	(1, 1, '+380123456789', '0 р.', 'VARIOUS WEB CLIENT');
/*!40000 ALTER TABLE `sim_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
