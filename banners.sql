-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: new_uksivt
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.17.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (11,'http://brsbs.ru/ru/biblioteka-govoryashchih-knig/38','http://www.uksivt.ru/web/upload/images/chitalka%281%29.jpg','Интернет читалка для слепых',0,NULL,'2018-04-12 05:03:35'),(13,'https://education.bashkortostan.ru/','http://drive.google.com/uc?export=view&id=0B-SC8AHRnwOMdXlDU0I5STdZSUE','Министерство образования РБ',0,NULL,'2018-04-12 05:03:41'),(15,'http://xn--80a1bd.xn--80acvaamej1aw.xn--p1ai/','http://drive.google.com/uc?export=view&id=0B-SC8AHRnwOMcXNnMklMN1pIeW8','Региональный центр развития конкурсов профессионального мастерства “Абилимпикс” по Республике Башкортостан',0,NULL,NULL),(16,'http://uksivt.ru/web/index.php?r=site/page&id=26','http://drive.google.com/uc?export=view&id=0B-SC8AHRnwOMN2lBd2NGZ3ZkdHM','Совет директоров',0,NULL,'2018-04-12 05:03:55'),(18,'http://bus.gov.ru/pub/independentRating/assessment','http://drive.google.com/uc?export=view&id=1waDZ-rbNUnPtR6gXXK-rUkyLGY_VJtCg','Независимая оценка качества образовательной деятельности',0,NULL,'2018-04-12 05:04:00'),(19,'https://gbpouuksivt.wixsite.com/portal','http://drive.google.com/uc?export=view&id=1FFUZJc9IocUF7UPbW0susC0QQvI7Aukn','Учебно-методический портал',0,NULL,'2018-04-12 05:04:06'),(20,'http://uksivt.ru/?r=news/select&id=221','http://drive.google.com/uc?export=view&id=1AATi5W4C3lTaCRhwT10-POi-8oMWwr2t','Лучший преподаватель года-2018',0,NULL,NULL),(21,'/ms.uksivt.ru','http://drive.google.com/uc?export=view&id=1ZWFOyd_71EautbuxLvhQxknSolQgpMZA','Система дистанционного образования',0,NULL,NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-26 11:31:08
