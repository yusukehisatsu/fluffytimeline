# ************************************************************
# Sequel Pro SQL dump
# バージョン 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# ホスト: 160.16.108.30 (MySQL 5.1.73)
# データベース: timeline
# 作成時刻: 2018-09-17 10:58:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ contact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contact`;

CREATE TABLE `contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `mail` varchar(100) DEFAULT NULL,
  `content` varchar(1000) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ignore` char(1) NOT NULL DEFAULT '0',
  `fix` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;

INSERT INTO `contact` (`id`, `name`, `mail`, `content`, `date`, `ignore`, `fix`)
VALUES
	(5,'test','test','test','2017-07-17 12:12:37','0','0'),
	(6,'JamisonFEK','johnkelly51kzp5cr@yahoo.com','Shops that require protection for high risk goods held on the premises will usually need to declare the total values of each stock item. High risk shop stock and goods are those that attract thieves and are expensive to replace. Examples of high risk stock items are electronic equipment, cigarettes,','2017-12-18 13:31:36','0','0'),
	(7,'Randy','Randy@TalkWithLead.com','Hi,\r\n\r\nMy name is Randy and I was looking at a few different sites online and came across your site fluffy-timeline.com.  I must say - your website is very impressive.  I found your website on the first page of the Search Engine. \r\n\r\nHave you noticed that 70 percent of visitors who leave your website will never return?  In most cases, this means that 95 percent to 98 percent of your marketing efforts are going to waste, not to mention that you are losing more money in customer acquisition costs than you need to.\r\n \r\nAs a business person, the time and money you put into your marketing efforts is extremely valuable.  So why let it go to waste?  Our users have seen staggering improvements in conversions with insane growths of 150 percent going upwards of 785 percent. Are you ready to unlock the highest conversion revenue from each of your website visitors?  \r\n\r\nTalkWithLead is a widget which captures a website visitor’s Name, Email address and Phone Number and then calls you immediately, ','2018-05-09 23:33:27','0','0'),
	(8,'Mallory Thomsen','kbaruffi@columbiabank.com','Hey\r\n\r\nShop Ray-Ban Sunglasses $19.95 only today @ http://linkin.gq/saving=fluffy-timeline.com\r\n\r\nBest,\r\n\r\n\r\nふわふわタイムライン|Fluffy Timeline --- http://fluffy-timeline.com/timeline/contact\r\nFacebook | https://twitter/@Twitter','2018-06-22 03:00:05','0','0'),
	(9,'Randy','Randy@TalkWithLead.com','Hi,\r\n\r\nMy name is Randy and I was looking at a few different sites online and came across your site fluffy-timeline.com.  I must say - your website is very impressive.  I found your website on the first page of the Search Engine. \r\n\r\nHave you noticed that 70 percent of visitors who leave your website will never return?  In most cases, this means that 95 percent to 98 percent of your marketing efforts are going to waste, not to mention that you are losing more money in customer acquisition costs than you need to.\r\n \r\nAs a business person, the time and money you put into your marketing efforts is extremely valuable.  So why let it go to waste?  Our users have seen staggering improvements in conversions with insane growths of 150 percent going upwards of 785 percent. Are you ready to unlock the highest conversion revenue from each of your website visitors?  \r\n\r\nTalkWithLead is a widget which captures a website visitor’s Name, Email address and Phone Number and then calls you immediately, ','2018-08-13 13:47:56','0','0');

/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;


# テーブルのダンプ tumblr_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tumblr_history`;

CREATE TABLE `tumblr_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT '',
  `offset` int(11) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `tag` varchar(300) DEFAULT NULL,
  `photo` varchar(10) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

LOCK TABLES `tumblr_history` WRITE;
/*!40000 ALTER TABLE `tumblr_history` DISABLE KEYS */;

INSERT INTO `tumblr_history` (`id`, `type`, `offset`, `speed`, `url`, `tag`, `photo`, `date`)
VALUES
	(7,'dashboard',0,0,NULL,NULL,'','2017-07-17 12:12:02'),
	(8,'tag',NULL,0,'','宮崎あおい',NULL,'2017-07-17 12:12:24'),
	(9,'dashboard',0,0,NULL,NULL,'photo','2017-07-17 23:33:56'),
	(10,'other',NULL,0,'qazzzqaz.tumblr.com','',NULL,'2017-07-18 13:47:37'),
	(11,'dashboard',0,0,NULL,NULL,'','2017-07-18 13:47:54'),
	(12,'dashboard',NULL,NULL,NULL,NULL,NULL,'2017-07-19 19:01:46'),
	(13,'tag',NULL,0,'','広瀬すず',NULL,'2017-07-19 19:05:56'),
	(14,'dashboard',0,0,NULL,NULL,'photo','2017-07-20 22:34:48'),
	(15,'dashboard',20,3,NULL,NULL,NULL,'2017-07-20 22:35:51'),
	(16,'dashboard',0,0,NULL,NULL,'photo','2017-07-21 22:01:12'),
	(17,'dashboard',20,3,NULL,NULL,NULL,'2017-07-21 22:02:15'),
	(18,'dashboard',0,0,NULL,NULL,'photo','2017-07-21 22:02:43'),
	(19,'tag',NULL,0,'','西野七瀬','photo','2017-07-21 22:03:08'),
	(20,'tag',NULL,0,'','後藤真希',NULL,'2017-07-22 22:40:15'),
	(21,'tag',NULL,0,'','大島優子',NULL,'2017-07-22 22:41:28'),
	(22,'tag',NULL,0,'','広瀬すず',NULL,'2017-08-04 20:50:59'),
	(23,'tag',NULL,0,'','えなこ',NULL,'2017-08-05 10:52:38'),
	(24,'tag',NULL,0,'','平手',NULL,'2017-08-05 14:06:23'),
	(25,'dashboard',NULL,NULL,NULL,NULL,NULL,'2017-08-08 10:24:24'),
	(26,'other',NULL,0,'qazzzqaz.tumblr.com','','photo','2017-08-08 10:24:50'),
	(27,'other',20,3,'qazzzqaz.tumblr.com',NULL,NULL,'2017-08-08 10:25:52'),
	(28,'dashboard',NULL,NULL,NULL,NULL,NULL,'2017-08-14 19:11:58'),
	(29,'tag',NULL,0,'','広瀬すず',NULL,'2017-09-10 14:17:47'),
	(30,'tag',NULL,0,'','広瀬すず',NULL,'2017-09-18 20:32:17'),
	(31,'tag',NULL,0,'','広瀬すず',NULL,'2017-09-19 18:36:58'),
	(32,'tag',NULL,0,'','広瀬すず',NULL,'2018-02-18 22:49:36'),
	(33,'dashboard',NULL,NULL,NULL,NULL,NULL,'2018-09-17 19:07:13'),
	(34,'other',NULL,0,'qazzzqaz.tumblr.com','',NULL,'2018-09-17 19:07:58');

/*!40000 ALTER TABLE `tumblr_history` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
