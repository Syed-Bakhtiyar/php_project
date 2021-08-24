-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: tudime_sms
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `tudime_sms`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `tudime_sms` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `tudime_sms`;

--
-- Table structure for table `Calling_Rate`
--

DROP TABLE IF EXISTS `Calling_Rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Calling_Rate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Country_Name` varchar(900) NOT NULL,
  `Calling_Rate` varchar(900) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Calling_Rate`
--

LOCK TABLES `Calling_Rate` WRITE;
/*!40000 ALTER TABLE `Calling_Rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `Calling_Rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_call_balence_tbl`
--

DROP TABLE IF EXISTS `buy_call_balence_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buy_call_balence_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `useid` int NOT NULL,
  `plan_name` text NOT NULL,
  `plan_price` text NOT NULL,
  `Payment_Referance_no` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_call_balence_tbl`
--

LOCK TABLES `buy_call_balence_tbl` WRITE;
/*!40000 ALTER TABLE `buy_call_balence_tbl` DISABLE KEYS */;
INSERT INTO `buy_call_balence_tbl` VALUES (1,1,'Credit DebitMoney','19.999840000003577','debitMoney');
/*!40000 ALTER TABLE `buy_call_balence_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_tudime_subscription`
--

DROP TABLE IF EXISTS `buy_tudime_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buy_tudime_subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `useid` int NOT NULL,
  `plan_name` text NOT NULL,
  `plan_price` text NOT NULL,
  `Payment_Referance_no` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_tudime_subscription`
--

LOCK TABLES `buy_tudime_subscription` WRITE;
/*!40000 ALTER TABLE `buy_tudime_subscription` DISABLE KEYS */;
INSERT INTO `buy_tudime_subscription` VALUES (1,5,'TuDime Annual Membership','15','ch_1IlSvGF2i6ViGnO3k8dzZOcO','2021-04-29 11:30:28','2022-04-29 11:30:28',1),(2,6,'TuDime Annual Membership','15','ch_3JL0TUF2i6ViGnO30cgImcMo','2021-08-05 12:24:41','2022-08-05 12:24:41',1);
/*!40000 ALTER TABLE `buy_tudime_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_backup_tbl`
--

DROP TABLE IF EXISTS `chat_backup_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_backup_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `Backup_TimeStamp` int NOT NULL,
  `fileZip` text NOT NULL,
  `device_type` enum('Android','iOS') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_backup_tbl`
--

LOCK TABLES `chat_backup_tbl` WRITE;
/*!40000 ALTER TABLE `chat_backup_tbl` DISABLE KEYS */;
INSERT INTO `chat_backup_tbl` VALUES (1,111,123333,'',''),(2,1234444,111,'http probable.docx','iOS'),(3,3,2147483647,'TuDimeLocal','iOS'),(4,15,2147483647,'TuDimeLocal.xls','Android'),(5,15,2147483647,'TuDimeLocal.xls','Android'),(6,15,2147483647,'TuDimeLocal.xls','Android'),(7,15,2147483647,'TuDimeLocal.xls','Android'),(8,15,2147483647,'TuDimeLocal.xls','Android'),(9,15,2147483647,'TuDimeLocal.xls','Android');
/*!40000 ALTER TABLE `chat_backup_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_img_tbl`
--

DROP TABLE IF EXISTS `chat_img_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_img_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chatdialog_id` int NOT NULL,
  `chat_dialog_picture` text NOT NULL,
  `custom_data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_img_tbl`
--

LOCK TABLES `chat_img_tbl` WRITE;
/*!40000 ALTER TABLE `chat_img_tbl` DISABLE KEYS */;
INSERT INTO `chat_img_tbl` VALUES (1,60458325,'94222213.jpg','');
/*!40000 ALTER TABLE `chat_img_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(500) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `address` longtext NOT NULL,
  `country` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `comments` longtext NOT NULL,
  `create_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_us`
--

LOCK TABLES `contact_us` WRITE;
/*!40000 ALTER TABLE `contact_us` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mobile_otp_tbl`
--

DROP TABLE IF EXISTS `mobile_otp_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mobile_otp_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobile_no` varchar(20) NOT NULL,
  `otp` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mobile_otp_tbl`
--

LOCK TABLES `mobile_otp_tbl` WRITE;
/*!40000 ALTER TABLE `mobile_otp_tbl` DISABLE KEYS */;
INSERT INTO `mobile_otp_tbl` VALUES (1,'+660952919402',235100),(2,'+918336805840',311188),(3,'+918961110122',268957),(4,'918336805840',181217),(5,'918335079003',907118),(6,'919007870538',656393),(7,'919330053969',182552),(8,'+917980568565',174832),(9,'+918777655729',362442),(10,' 917980519150',164795),(11,'+660960909636',153907),(12,' 918336805840',157057),(13,'918766318889',158520),(14,'+66931545489',649716),(15,'+66932182918',339106),(16,'+660929768069',158246),(17,'+919108509569',372344),(18,'+919154697253',307088),(19,'+66656946980',272951),(20,'+916366356744',115970),(21,'+918766318889',442564),(22,'+660952475174',280013),(23,'+917615942197',215153),(24,' 919978816669',794769),(25,'+66959586327',146035),(26,'+917563859167',502592),(27,' 919414991456',117905),(28,'+919414991456',247889),(29,'+918766315889',276774),(30,'919414991456',655599),(31,'+919871778493',299422),(32,'+918826264862',331426);
/*!40000 ALTER TABLE `mobile_otp_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_store_chat_file`
--

DROP TABLE IF EXISTS `tb_store_chat_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_store_chat_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_chat_file` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_store_chat_file`
--

LOCK TABLES `tb_store_chat_file` WRITE;
/*!40000 ALTER TABLE `tb_store_chat_file` DISABLE KEYS */;
INSERT INTO `tb_store_chat_file` VALUES (1,'1614412790547.png'),(2,'1615135645115.png'),(3,'1615135668143.png'),(4,'1615135701114.png'),(5,'1615136339935.png'),(6,'1615182631433.png'),(7,'theme862389.jpeg'),(8,'theme381058.jpeg'),(9,'1618932619652.png'),(10,'paperwork.pdf'),(11,'Billing Management Console(1).PDF'),(12,'1625771038662.png'),(13,'1625771097458.png'),(14,'1625771140236.png'),(15,'1625771212631.png'),(16,'1625771338907.png'),(17,'1625771527373.png'),(18,'1625771612895.png'),(19,'1627590239578.png'),(20,'TuDime_Chat_Proposal.pdf'),(21,'Screenshot_20210731-105815_Gallery.jpg'),(22,'1629031893974.png'),(23,'1629032083655.png'),(24,'1629032671569.png'),(25,'1629055982180.png'),(26,'1629056175688.png'),(27,'1629056333731.png'),(28,'ic_launcher.png'),(29,'1629279878030.mp4'),(30,'1629287163077.mp4'),(31,'1629287478511.mp4'),(32,'1629303021997.mp4'),(33,'1629324367797.mp4'),(34,'1629381361251.png'),(35,'WhatsApp Image 2021-07-30 at 8.42.54 PM.jpeg'),(36,'1629541812537.png'),(37,'1629542108832.png'),(38,'1629574792243.png'),(39,'1629633560873.mp4'),(40,'1629822226096.png');
/*!40000 ALTER TABLE `tb_store_chat_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_profile_image`
--

DROP TABLE IF EXISTS `tbl_user_profile_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_user_profile_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `profile_image` varchar(225) NOT NULL,
  `status` int NOT NULL,
  `create_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_profile_image`
--

LOCK TABLES `tbl_user_profile_image` WRITE;
/*!40000 ALTER TABLE `tbl_user_profile_image` DISABLE KEYS */;
INSERT INTO `tbl_user_profile_image` VALUES (1,7,'603cd7700f618_ProfilePic957029.jpeg',1,'2021-03-01 12:00:48'),(3,16,'60444e49bdfaf_IMG-20210306-WA0011.jpg',1,'2021-03-07 03:53:45'),(4,16,'60444e49bf5a0_IMG-20210306-WA0010.jpg',1,'2021-03-07 03:53:45'),(5,16,'60444e49bfa20_IMG-20210306-WA0009.jpg',1,'2021-03-07 03:53:45'),(6,16,'60444e49c04ef_IMG-20210306-WA0008.jpg',1,'2021-03-07 03:53:45'),(7,16,'60444e49c09fe_IMG-20210306-WA0007.jpg',1,'2021-03-07 03:53:45'),(8,16,'60444e49c14fc_IMG-20210306-WA0006.jpg',1,'2021-03-07 03:53:45'),(9,16,'60444e49c18ee_IMG-20210225-WA0015.jpg',1,'2021-03-07 03:53:45'),(10,16,'60444e49c284d_IMG-20210123-WA0015.jpg',1,'2021-03-07 03:53:45'),(11,15,'6044a3117a798_doodle_1612705095191.png',1,'2021-03-07 09:55:29'),(12,15,'6044a32d7af58_processed-1.jpeg',1,'2021-03-07 09:55:57'),(15,22,'604658651ee43_Screenshot_20201217-225658_Gallery.jpg',1,'2021-03-08 17:01:25'),(16,22,'6046589f95c1e_Screenshot_20201217-225658_Gallery.jpg',1,'2021-03-08 17:02:23'),(17,22,'604658e8e8c22_Screenshot_20201217-225548_Gallery.jpg',1,'2021-03-08 17:03:36'),(18,22,'6046590db00bd_Screenshot_20201217-225635_Gallery.jpg',1,'2021-03-08 17:04:13'),(19,22,'6046593f92588_Screenshot_20201115-071327_Gallery.jpg',1,'2021-03-08 17:05:03'),(20,22,'604659b89c132_Screenshot_20201115-071312_Gallery.jpg',1,'2021-03-08 17:07:04'),(21,15,'604668300f265_1615110919358.jpg',1,'2021-03-08 18:08:48'),(22,3,'6047660c41ce0_ProfilePic642792.jpeg',1,'2021-03-09 12:11:56'),(23,3,'604772d53d8a6_IMG_20210112_204639_186.jpg',1,'2021-03-09 13:06:29'),(24,8,'604775f6423a7_FB_IMG_1615269297242.jpg',1,'2021-03-09 13:19:50'),(25,8,'6047775e8b9ba_FB_IMG_1614960697412.jpg',1,'2021-03-09 13:25:50'),(26,6,'610257b2d28cc_ProfilePic778664.jpeg',1,'2021-07-29 07:24:34'),(27,6,'61025836bfce2_ProfilePic776167.jpeg',1,'2021-07-29 07:26:46'),(28,42,'610b5caea69d2_ProfilePic403768.jpeg',1,'2021-08-05 03:36:14');
/*!40000 ALTER TABLE `tbl_user_profile_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tbl`
--

DROP TABLE IF EXISTS `user_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` text NOT NULL,
  `name` text NOT NULL,
  `email` varchar(700) NOT NULL,
  `privacy_status` varchar(100) NOT NULL,
  `Bio` text NOT NULL,
  `pic1` varchar(300) NOT NULL,
  `pic2` varchar(300) NOT NULL,
  `pic3` varchar(300) NOT NULL,
  `pic4` varchar(300) NOT NULL,
  `Cover_pic` varchar(300) NOT NULL,
  `QB_User_id` text NOT NULL,
  `create_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tbl`
--

LOCK TABLES `user_tbl` WRITE;
/*!40000 ALTER TABLE `user_tbl` DISABLE KEYS */;
INSERT INTO `user_tbl` VALUES (1,'+660952919402','Samsung A71 082121','','Public','','68001734.jpg','','','','','126837998','2021-08-23 17:05:43'),(2,'+BajaRentals@yahoo.com','Umidigi Android April 15','','Private','','','','','','','126593617','2021-04-15 15:16:46'),(3,'+918336805840','Ayan','','Private','','94425900.jpg','','','','ProfilePic254883.jpeg','126707488','2021-03-09 12:42:47'),(4,'+918961110122','Krish The King','','','','','','','','','126641232','2021-03-20 14:02:13'),(5,'+Hunter0719@aol.com','','','Private','','','','','','','127123873','2021-03-25 06:47:27'),(6,'+Michael@TuDime.com','','','Private','Try TuDime','CoverPic929100.jpeg','','','','ProfilePic826975.jpeg','126642271','2021-07-29 07:26:22'),(7,'+918335079003','','','Private','','CoverPic175702.jpeg','','','','ProfilePic633263.jpeg','126657895','2021-03-01 14:57:05'),(8,'+ayanjana4@gmail.com','Aj','','Private','','','','','','','126821827','2021-03-09 13:47:58'),(9,'+aj27091995@yahoo.com','','','','','','','','','','','2021-03-01 13:42:29'),(10,'+919007870538','','','','','','','','','','','2021-03-01 13:44:43'),(11,'+9874300476','','','','','','','','','','','2021-03-01 14:01:52'),(12,'+9830024942','','','','','','','','','','','2021-03-01 14:08:37'),(13,'+9007059700','','','','','','','','','','','2021-03-01 14:08:56'),(14,'+919330053969','','','','','','','','','','','2021-03-01 14:10:34'),(15,'+917980568565','Krishnendu','','Public','','','','','','','126733521','2021-05-09 14:41:44'),(16,'+krishnendumanna25@gmail.com','Krish Cyberswift','','','','','','','','','126770503','2021-03-06 17:52:56'),(17,'+namkhing198249@gmail.com','khing1982','','à¸ªà¸²à¸˜à¸²à¸£à¸“à¸°','','27437329.jpg','','','','','126796947','2021-07-29 02:32:54'),(18,'+918777655729','Kuntal','','Public','','','','','','','126796997','2021-03-08 05:29:15'),(19,'+insurancehunter@aol.com','Dirk Umidigi Android','','','','','','','','','126797003','2021-03-08 05:14:20'),(20,'+tudimechat@gmail.com','Dirk Umidigi March 7','','','','','','','','','126798274','2021-03-08 07:04:41'),(21,'+tester@gmail.com','','','','','','','','','','','2021-03-08 07:54:02'),(22,'+660960909636','Samsung J5 Aug 17','','Public','','38624381.jpg','','','','','126805643','2021-08-21 06:38:12'),(23,'+mhunter@TuDime.com','Samsung S4 Tablet  082121','','private','','','','','','','126837874','2021-08-21 09:54:18'),(24,'+payments@tudime.com','','','Private','','','','','','','126871284','2021-03-12 05:30:56'),(25,'+918766318889','Dharmendra','','Public','Urgent calls only','3376348.jpg','','','','','126965644','2021-08-24 11:24:17'),(26,'+660929768069','Dragon 1300','','','','','','','','','127253662','2021-04-01 03:54:03'),(27,'+919108509569','','','','','','','','','','','2021-04-06 12:32:24'),(28,'+919154697253','Jhondeo','','','','','','','','','127454317','2021-04-11 17:45:21'),(29,'+teamrr01234@gmail.com','teamrr01234','','','','','','','','','127466872','2021-04-12 10:32:34'),(30,'+elgoogclass1@gmail.com','johndoe','','','','','','','','','127727051','2021-04-27 07:54:35'),(31,'+testtempt2@gmail.com','ducks','','','','','','','','','127731578','2021-04-27 12:20:40'),(32,'+917980519150','','','','','','','','','','','2021-04-28 14:58:34'),(33,'+916366356744','Raj','','','','','','','','','127868012','2021-05-04 08:01:03'),(34,'+sthakur@objectsol.in','','','Private','','CoverPic956591.jpeg','','','','','128948344','2021-06-24 11:36:43'),(35,'+sayantant@gmail.com','Big Mike','','Private','','','','','','','126543122','2021-08-19 09:55:32'),(36,'+660952475174','Yo','','','','','','','','','129030919','2021-06-28 15:10:16'),(37,'+917615942197','Harry','','','','','','','','','129446031','2021-07-20 10:06:29'),(38,'+s@gmail.com','','','Private','','','','','','','129460448','2021-07-21 12:01:04'),(39,'+t@gmail.com','','','Private','','','','','','','129461580','2021-07-21 14:45:12'),(40,'+martharuiz15abril@gmail.com','Martha','','Público','','6251675.jpg','','','','','129485851','2021-07-24 01:17:15'),(41,'+juanarroyorios@gmail.com','jmarroyo','','','','','','','','','129502659','2021-07-23 21:02:58'),(42,'+mmandal@gmail.com','','','Private','','CoverPic359149.jpeg','','','','','129611877','2021-08-05 03:35:07'),(43,'+smogtowers@gmail.com','Shuddh','','Public','','','','','','','129612753','2021-07-29 19:21:52'),(44,'+919978816669','','','','','','','','','','','2021-07-29 17:36:56'),(45,'+m@gmail.com','','','Private','','','','','','','129728179','2021-08-04 12:22:30'),(46,'+66959586327','German4u2 ','','Public','','4611774.jpg','','','','','129909168','2021-08-22 12:29:25'),(47,'+917563859167','Rahul','','Public','Battery about to die','18758459.jpg','','','','','129944566','2021-08-24 18:53:24'),(48,'+919414991456','Vikas','','Public','','','','','','','130046760','2021-08-23 16:25:56'),(49,'+918826264862','Tulika','','Public','Life is awesome...','11115553.jpg','','','','','130139605','2021-08-24 19:38:06');
/*!40000 ALTER TABLE `user_tbl` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-24 20:07:52
