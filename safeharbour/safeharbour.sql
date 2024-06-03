-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: safeharbour
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
-- Table structure for table `dangers`
--

DROP TABLE IF EXISTS `dangers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dangers` (
  `place` text,
  `latitude` text,
  `longitude` text,
  `type` text,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dangers`
--

LOCK TABLES `dangers` WRITE;
/*!40000 ALTER TABLE `dangers` DISABLE KEYS */;
INSERT INTO `dangers` VALUES ('Jeremiego Wiśniowieckiego, 33-309 Nowy Sącz, Poland','49.6009216','20.7224832','Konflikt Zbrojny','efe'),('Jeremiego Wiśniowieckiego, 33-309 Nowy Sącz, Poland','49.6009216','20.7224832','Kryzys Migracyjny','efe'),('Jana Freislera 7, 33-300 Nowy Sącz, Poland','49.6058691','20.7235448','Klęska Żywiołowa','vbvbv'),('Auchan, Gorzkowska 32, 33-300 Nowy Sącz, Poland','49.6041984','20.72576','Kryzys Zdrowotny','vbvbvbv'),('Auchan, Gorzkowska 32, 33-300 Nowy Sącz, Poland','49.6041984','20.72576','Kryzys Żywnościowy','dfdfd');
/*!40000 ALTER TABLE `dangers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupy`
--

DROP TABLE IF EXISTS `groupy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groupy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nazwa` text,
  `id_zalozyciela` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`id_zalozyciela`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`id_zalozyciela`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupy`
--

LOCK TABLES `groupy` WRITE;
/*!40000 ALTER TABLE `groupy` DISABLE KEYS */;
INSERT INTO `groupy` VALUES (1,'abc',1);
/*!40000 ALTER TABLE `groupy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor` text,
  `tresc` text,
  `id_grupy` int DEFAULT NULL,
  `id_autora` int DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'seb','fdfdfdfd',1,1,'2024-05-24'),(2,'seb','bfbffbfbfb',1,1,'2024-05-24'),(3,'seb','fgfhsajbfsdiufbdsafbdgfdgfsdhbg',1,1,'2024-05-24'),(4,'seb1','dfdffsdfdvasfds',1,2,'2024-05-24'),(5,'seb','elo',1,1,'2024-05-24'),(6,'seb','gej',1,1,'2024-05-24');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
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
  `email` text,
  `login` text,
  `haslo` text,
  `admin` text,
  `id_grupy` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_group_id` (`id_grupy`),
  CONSTRAINT `fk_group_id` FOREIGN KEY (`id_grupy`) REFERENCES `groupy` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sebastian','Madzia','sebastian.12345.ns.67@gmail.com','seb','$2b$10$PBAXY/1fTKQyvUiMtawMJ.eE5IKTLypoXyqoX7RG08V52zqy90Ina','0',1),(2,'Sebastian','Madzia','sebastian.12345.ns.67@gmail.com1','seb1','$2b$10$9SWbippRh40cKuI7FbqbuuEO4dP3VLZheTqAuQYFfhlRYyWQDsN82','0',1);
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

-- Dump completed on 2024-05-27 16:06:46
