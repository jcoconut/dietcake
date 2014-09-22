-- MySQL dump 10.13  Distrib 5.5.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: klabhouse
-- ------------------------------------------------------
-- Server version	5.5.27-0ubuntu2

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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`,`created`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,2,'<p>2</p>','2014-09-17 02:07:18',NULL),(2,2,9,'<p>dasda</p>','2014-09-17 02:08:00',NULL),(3,1,9,'<p>gdfgd</p>','2014-09-17 02:08:18',NULL),(4,1,13,'<p>fsdfs</p>','2014-09-17 02:12:04',NULL),(5,3,2,'<p>asdasda</p>','2014-09-17 02:19:54',NULL),(6,4,2,'<p>dasdas</p>','2014-09-17 02:19:58',NULL),(7,5,2,'<p>dasdas</p>','2014-09-17 02:20:02',NULL),(8,6,2,'<p>dasda</p>','2014-09-17 02:20:06',NULL),(9,7,2,'<p>dasdas</p>','2014-09-17 02:20:10',NULL),(10,8,2,'<p>dasdas</p>','2014-09-17 02:20:14',NULL),(11,9,2,'<p>dasdas</p>','2014-09-17 02:20:19',NULL),(12,10,2,'<p>dasdas</p>','2014-09-17 02:20:22',NULL),(13,11,2,'<p>dasdasd</p>','2014-09-17 02:20:26',NULL),(14,12,2,'<p>SDFSD</p>','2014-09-17 06:54:23',NULL),(15,12,2,'<p>fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff</p>','2014-09-17 07:13:16',NULL),(16,12,2,'<p>ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff</p>','2014-09-17 07:13:23',NULL),(17,13,5,'<p>meralco</p>','2014-09-17 07:34:29',NULL),(18,14,5,'<p>masonog ka</p>','2014-09-17 07:35:10',NULL),(19,15,5,'<p>kanina pa me<br />&nbsp;</p>','2014-09-17 07:35:37',NULL),(20,16,5,'<p>ito</p>','2014-09-17 07:35:50',NULL),(21,17,5,'<p>apotkas</p>','2014-09-17 07:36:06',NULL),(22,17,5,'<p>mainit init</p>','2014-09-17 07:36:28',NULL),(23,17,5,'<p>apuy</p>','2014-09-17 07:36:33',NULL),(24,17,5,'<p>bagong loto</p>','2014-09-17 07:36:39',NULL),(25,17,5,'<p>nanalo ko sa luto</p>','2014-09-17 07:36:46',NULL),(26,17,5,'<p>nikolas</p>','2014-09-17 07:36:52',NULL),(27,17,5,'<p>kolongan</p>','2014-09-17 07:36:58',NULL),(28,17,5,'<p>totoy bato</p>','2014-09-17 07:37:03',NULL),(29,17,5,'<p>totoy damo</p>','2014-09-17 07:37:10',NULL),(30,17,5,'<p>totoy shabu</p>','2014-09-17 07:37:17',NULL),(31,17,5,'<p>totoy singhot</p>','2014-09-17 07:37:24',NULL),(32,12,5,'<p>hawk bug<br />&nbsp;</p>','2014-09-17 07:37:56',NULL),(33,17,7,'<p>binatuta ng bata ang batuta ng binata</p>','2014-09-17 07:41:39',NULL),(34,18,10,'<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum.</p>','2014-09-17 07:45:00',NULL),(35,19,5,'<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>','2014-09-18 08:02:20',NULL),(36,20,5,'<p>&nbsp;&nbsp;&nbsp;</p>','2014-09-18 08:02:56',NULL);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klub`
--

DROP TABLE IF EXISTS `klub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klub` (
  `klub_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `klub_name` varchar(50) NOT NULL,
  `klub_details` text NOT NULL,
  `klub_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `klub_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`klub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klub`
--

LOCK TABLES `klub` WRITE;
/*!40000 ALTER TABLE `klub` DISABLE KEYS */;
INSERT INTO `klub` VALUES (2,'fdsfcs fdsf sd','details of two','0000-00-00 00:00:00','2014-09-16 11:30:16'),(3,'KLABTHREE','bla bla bla jkehf hjdfsk jksfsdhfkjs hfksjksa','0000-00-00 00:00:00','2014-09-16 11:33:08'),(4,'KLAB4','mary had a little lamb little lamb is on fiiire this lamb is on firee','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'Kluboon','haha','2014-09-11 02:40:56','2014-09-11 10:40:56'),(8,'fuefuefuez','sdfsdz','2014-09-12 02:21:58','2014-09-16 11:30:39'),(11,'MUSICmemberAKODITO','lu lu lu la la la tralala','2014-09-12 06:38:58','2014-09-15 16:25:40'),(12,'Tulog','We sleep all day everyday\r\nsleeping is power\r\nsleeping is the source of life','2014-09-15 09:08:11','2014-09-15 17:08:11'),(14,'fsdfsd','fsdfsd','2014-09-16 03:33:16','2014-09-16 11:33:16'),(15,'zzz','zzz','2014-09-16 03:33:24','2014-09-16 11:33:24'),(16,'ddfsd','fsdsd','2014-09-16 03:34:35','2014-09-16 11:34:35'),(17,'KLABtwo','fdsfsd','2014-09-16 03:34:56','2014-09-16 11:34:56'),(18,'KLABtwofdsfsd','fsdfsd','2014-09-16 03:38:43','2014-09-16 11:41:16'),(19,'fsdfgdfsdfsdf','sdfs','2014-09-16 03:51:03','2014-09-16 11:51:03'),(20,'sasas','12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890','2014-09-16 03:52:12','2014-09-16 11:52:12'),(21,'fsdfsdfsd','1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890','2014-09-16 04:02:14','2014-09-16 12:02:14'),(22,'fdssssssssssssssssssssssssssss','fdfdgdfgdf','2014-09-16 04:15:02','2014-09-16 12:15:02'),(23,'fdsfsd','fsdfsd','2014-09-17 02:45:12','2014-09-17 10:45:12'),(24,'fsdfsdzzz','fsdfsd','2014-09-17 02:45:19','2014-09-17 10:45:19'),(25,'rerere','rereer','2014-09-17 02:45:30','2014-09-17 10:45:30');
/*!40000 ALTER TABLE `klub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `klub_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level` tinyint(1) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,3,2,'2014-09-16 07:18:34',2,'2014-09-16 15:19:01'),(2,3,5,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(3,3,7,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(4,3,8,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(6,3,10,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(7,3,11,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(8,3,12,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(9,3,13,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(10,3,14,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(11,3,15,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(12,3,16,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(13,3,16,'0000-00-00 00:00:00',1,'2014-09-17 12:00:55'),(14,2,2,'2014-09-17 01:40:43',0,'2014-09-17 09:41:35'),(15,4,9,'2014-09-17 02:51:30',1,'2014-09-17 10:51:45'),(16,4,5,'2014-09-17 07:33:21',0,NULL),(17,2,5,'2014-09-17 07:33:25',0,NULL),(18,5,5,'2014-09-17 07:33:27',0,NULL),(19,8,5,'2014-09-17 07:33:31',0,NULL),(20,11,5,'2014-09-17 07:33:35',0,NULL),(21,12,5,'2014-09-17 07:33:39',0,NULL),(22,15,5,'2014-09-17 07:33:43',0,NULL),(23,4,7,'2014-09-17 07:39:38',0,NULL),(24,16,10,'2014-09-17 07:49:03',0,NULL),(25,4,2,'2014-09-17 07:57:16',0,NULL),(26,5,2,'2014-09-17 07:58:41',0,NULL);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `klub_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request`
--

LOCK TABLES `request` WRITE;
/*!40000 ALTER TABLE `request` DISABLE KEYS */;
/*!40000 ALTER TABLE `request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `privacy` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `klub_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
INSERT INTO `thread` VALUES (1,'private for klub2',1,2,2,'2014-09-17 02:07:18',NULL),(2,'dasdas',NULL,9,NULL,'2014-09-17 02:08:00',NULL),(3,'private for klub3',1,2,3,'2014-09-17 02:19:54',NULL),(4,'dasdas',NULL,2,NULL,'2014-09-17 02:19:58',NULL),(5,'dasdas',NULL,2,NULL,'2014-09-17 02:20:02',NULL),(12,'PRIVATE FOR K3',1,2,3,'2014-09-17 06:54:23',NULL),(13,'poste',0,5,0,'2014-09-17 07:34:29',NULL),(14,'don\'t litter',0,5,0,'2014-09-17 07:35:10',NULL),(15,'wer na yu',0,5,0,'2014-09-17 07:35:37',NULL),(16,'wala rin',0,5,0,'2014-09-17 07:35:50',NULL),(17,'saktopa',0,5,0,'2014-09-17 07:36:06',NULL),(18,'title',0,10,0,'2014-09-17 07:45:00',NULL),(19,'Â ',0,5,0,'2014-09-18 08:02:20',NULL),(20,'   ',0,5,0,'2014-09-18 08:02:56',NULL);
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Jay','Co','email','admin','09bd4bc65486ae454c504c456120cd7e',NULL,1,'2014-09-12 08:09:55',NULL),(2,'Jay Alvinz','Co','jay.co@klab.com','jcoconut','1619d7adc23f4f633f11014d2f22b7d8',NULL,0,'2014-09-12 08:22:14','2014-09-15 16:24:04'),(5,'geno','dasdasdsa','g.romualdo@klab.com','geno','1619d7adc23f4f633f11014d2f22b7d8',NULL,0,'2014-09-15 07:56:48','2014-09-17 15:48:00'),(7,'hindi ako to','ako to','f.pambid@klab.com','fpambid','1619d7adc23f4f633f11014d2f22b7d8',NULL,0,'2014-09-16 07:49:05','2014-09-17 15:49:25'),(8,'Robert','Bendik','r.deguzman@klab.com','rdeguzman','64277d86d86dc95edcf8d968da8867b6',NULL,0,'2014-09-16 08:47:55',NULL),(9,'chase','chaselast','c.gosingtian@klab.com','chase','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,'pam','pamlast','p.jasme@klab.com','pamela','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,'josip','islandia','j.isleta@klab.com','joseph','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,'jeszyjames','teamrocket','j.tanada@klab.com','jeszy','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,'kit','samson','k.samson@klab.com','sungkeith','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,'Master','Pogi','r.pogi@klab.com','paparomz','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,'Master','Bongga','e.bongga@klab.com','isabongga','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,'Magay','Bagay','j.magay@klab.com','tantan','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,'Lemme Well','Castro','l.castro@klab.com','lemwell','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,'Sell','Rust','r.sell@klab.com','rawsell','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,'Hello','Usi','s.usi@klab.com','usiusi','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,'Josh','Ee ef gee','j.dee@klab.com','deedee','1619d7adc23f4f633f11014d2f22b7d8','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(30) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('103476105731445808139','Jay Alvin(Cyscorpions)','CO','jay.co@klab.com',NULL,NULL,'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg',0,'2014-09-18 07:23:10',NULL),('103476105731445808139','Jay Alvin(Cyscorpions)','CO','jay.co@klab.com',NULL,NULL,'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg',0,'2014-09-18 07:49:33',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-18 16:18:45
