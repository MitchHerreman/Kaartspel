-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: cursusphp
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `cardgame`
--

DROP TABLE IF EXISTS `cardgame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cardgame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `hp` int(11) DEFAULT NULL,
  `hpP1` int(11) DEFAULT NULL,
  `hpP2` int(11) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `defense` int(11) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `stateP1` int(11) DEFAULT NULL,
  `stateP2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardgame`
--

LOCK TABLES `cardgame` WRITE;
/*!40000 ALTER TABLE `cardgame` DISABLE KEYS */;
INSERT INTO `cardgame` VALUES (1,'Akira Yuki',3,3,3,4,2,3,'akirayuki.png',0,0),(2,'Alex Kidd',2,2,2,3,1,2,'alexkidd.png',0,0),(3,'Alicia Melchiott',3,3,3,3,2,3,'aliciamelchiott.png',0,0),(4,'Alis Landale',3,3,3,3,2,3,'alislandale.png',1,0),(5,'Axel Stone',3,3,3,4,2,2,'axelstone.png',0,0),(6,'Bahn',4,4,4,4,2,2,'bahn.png',0,0),(7,'Bayonetta',4,4,4,4,2,4,'bayonetta.png',0,0),(8,'Beast Warrior',3,3,3,3,2,2,'beastwarrior.png',0,0),(9,'Beat',2,2,2,2,1,4,'beat.png',0,0),(10,'Blaze Fielding',3,3,3,3,2,3,'blazefielding.png',0,0),(11,'Blue Dragon',4,4,4,3,2,4,'bluedragon.png',1,1),(12,'Vectorman',3,3,3,3,2,2,'vectorman.png',0,0),(13,'Bruno Delinger',3,3,3,3,2,3,'brunodelinger.png',0,0),(14,'Death Adder',4,4,4,4,3,1,'deathadder.png',0,0),(15,'Dr. Robotnik',4,4,4,3,3,1,'drrobotnik.png',1,0),(16,'G',4,4,4,4,2,3,'g.png',0,0),(17,'Gilius Thunderhead',3,3,3,4,2,2,'giliusthunderhead.png',0,0),(18,'Harrier',2,2,2,3,1,4,'harrier.png',1,0),(19,'Hornet',3,3,3,2,2,4,'hornet.png',0,0),(20,'Janet Marshall',4,4,4,4,2,3,'janetmarshall.png',0,0),(21,'Joe Musashi',3,3,3,3,2,4,'joemusashi.png',0,1),(22,'Kazuma Kiryu',3,3,3,4,2,3,'kazumakiryu.png',0,0),(23,'Leanne',3,3,3,3,2,3,'leanne.png',0,0),(24,'NiGHTS',2,2,2,2,1,3,'nights.png',0,1),(25,'Opa-Opa',2,2,2,3,2,3,'opaopa.png',0,1),(26,'Ryo Hazuki',3,3,3,4,2,3,'ryohazuki.png',0,0),(27,'Sarah Bryant',3,3,3,3,2,4,'sarahbryant.png',0,0),(28,'Segata Sanshiro',4,4,4,4,3,4,'segatasanshiro.png',0,0),(29,'Sonic',2,2,2,3,1,4,'sonic.png',0,0),(30,'Tails',2,2,2,2,1,3,'tails.png',0,0),(31,'Vyse',4,4,4,3,2,3,'vyse.png',0,0),(32,'Lan Di',4,4,4,4,2,3,'landi.png',0,0),(33,'Goro Majima',3,3,3,4,2,3,'goromajima.png',0,0);
/*!40000 ALTER TABLE `cardgame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cardgameusers`
--

DROP TABLE IF EXISTS `cardgameusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cardgameusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardgameusers`
--

LOCK TABLES `cardgameusers` WRITE;
/*!40000 ALTER TABLE `cardgameusers` DISABLE KEYS */;
INSERT INTO `cardgameusers` VALUES (5,'Mitch','$2y$10$8ExQiL.xkDk8K3z30yML0.CGYpqkd9RbpGT.th6x8O8XkSE3AYdpy'),(6,'Raptor','$2y$10$lZR6ea.YRaOF2Lbh/KI7AugnZtzaCrCuZzsMati9SwLIegX6ELQSO'),(7,'Admin','$2y$10$e/o.OoaypG2XjE6V0QMRf.Un5EfGrKTzx07B7t40Da4NR5cd/nFmu'),(8,'Test','$2y$10$OpSUdLtKtCkP1p2FI7RaV./j73it.uT/sgHDYDgMn74B8fun9ll0e'),(9,'Test2','$2y$10$SGTSq2T/PUWgjRA/nz0fA.hB4V64wpm/YGEecbKNBPU1y30oyD94y'),(12,'Test 3','$2y$10$/1YiaXN/C5PsmatlK90GD.2S7abeSjNvunMLvimH1yIz/K4NiHXsW');
/*!40000 ALTER TABLE `cardgameusers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-04 11:01:20
