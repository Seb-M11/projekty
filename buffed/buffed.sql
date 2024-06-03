-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: buffed
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `nutrients`
--

DROP TABLE IF EXISTS `nutrients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nutrients` (
  `produkt` text,
  `wapn` text,
  `zelazo` text,
  `sol` text,
  `a` text,
  `c` text,
  `cholesterol` text,
  `kt` text,
  `proteiny` text,
  `weglowodany` text,
  `kcal` text,
  `cukry` text,
  `blonnik` text,
  `potas` text,
  `kt2` text,
  `lip` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nutrients`
--

LOCK TABLES `nutrients` WRITE;
/*!40000 ALTER TABLE `nutrients` DISABLE KEYS */;
INSERT INTO `nutrients` VALUES ('hamburger','13.3','10.2','29.6','263','0','44.8','0','0','5.95','1.8','116','2.87','22','110','197'),('pizza','1.86','7.54','32.3','204','0','57.7','0','0','15.8','1.7','21','0.88','12','47','109'),('chicken','26.7','6.33','0','164','0','65.8','0','0','0','0','15','0.73','23','236','278'),('apple','1.34','2.15','29.6','134','0','66.3','0','0','24.2','1.8','39','0.12','8','37','134'),('kiwi','1.06','0.44','14','64','0','83.9','0','0','8.99','3','35','0.24','16','34','198'),('egg','0.391','10.7','0.65','17.9','0','86.3','231','55','2.36','1.71','0.188','0.466','0.779','0.567','0.494'),('pasta','5.76','0.92','30.7','157','0','61.8','0','0','0.56','1.8','7','1.27','18','58','44');
/*!40000 ALTER TABLE `nutrients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plany`
--

DROP TABLE IF EXISTS `plany`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plany` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usera` int DEFAULT NULL,
  `dzien` text,
  `cwiczenie` text,
  `powtorzenia` int DEFAULT NULL,
  `waga` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plany`
--

LOCK TABLES `plany` WRITE;
/*!40000 ALTER TABLE `plany` DISABLE KEYS */;
/*!40000 ALTER TABLE `plany` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imie` text,
  `nazwisko` text,
  `login` text,
  `haslo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sebastian','Madzia','seb','123');
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

-- Dump completed on 2024-05-27 15:18:26
