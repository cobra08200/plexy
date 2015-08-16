-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: plexy
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.12.04.1

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
-- Table structure for table `assigned_roles`
--

DROP TABLE IF EXISTS `assigned_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigned_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_user_id_index` (`user_id`),
  KEY `assigned_roles_role_id_index` (`role_id`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigned_roles`
--

LOCK TABLES `assigned_roles` WRITE;
/*!40000 ALTER TABLE `assigned_roles` DISABLE KEYS */;
INSERT INTO `assigned_roles` VALUES (1,1,1);
/*!40000 ALTER TABLE `assigned_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
  `issue_id` int(10) unsigned DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `comments_user_id_index` (`user_id`),
  KEY `comments_post_id_index` (`post_id`),
  KEY `comments_issue_id_index` (`issue_id`),
  CONSTRAINT `comments_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tmdb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('open','pending','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `topic` enum('miscellaneous','movies','music','tv') COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('issue','request') COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `poster_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `backdrop_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vote_average` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plex_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `issue_description` text COLLATE utf8_unicode_ci NOT NULL,
  `tv_episode_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_season_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_episode_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_episode_overview` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tv_episode_still_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `issues_user_id_index` (`user_id`),
  CONSTRAINT `issues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (12,5,'11857','closed','','request','Orange County (2002)','http://image.tmdb.org/t/p/w500/ifSt98anKHiVTIokvFZisgkfvKd.jpg','http://image.tmdb.org/t/p/w500/eWOGySTYiwnZMjvnhEdA0tHFnQU.jpg','6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-05-29 14:41:37','2015-05-29 17:21:40'),(16,9,'66634','closed','','request','Dingo (1991)','http://image.tmdb.org/t/p/w500/jiTProTQgDuCDbvvO9AGk55uEgY.jpg','https://plexy.ehumps.me/assets/img/no-backdrop.jpg','0','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-01 19:56:53','2015-06-02 11:59:42'),(18,5,'243938','closed','','request','Hot Tub Time Machine 2 (2015)','http://image.tmdb.org/t/p/w500/tQtWuwvMf0hCc2QR2tkolwl7c3c.jpg','http://image.tmdb.org/t/p/w500/wuPC7NqTgQZWXVrALvNWZCn8YJY.jpg','5.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-02 21:40:21','2015-06-03 19:53:18'),(22,12,'265228','closed','','issue','Timbuktu (2014)','http://image.tmdb.org/t/p/w500/wYAHH1uf9UAIrZ9dzuliijVlP98.jpg','http://image.tmdb.org/t/p/w500/yVgXiDVx2X9eyU8QIded6ckp9r4.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 13:33:03','2015-06-04 15:30:56'),(23,5,'4381','closed','tv','request','Good Eats (1999)','https://image.tmdb.org/t/p/w500/yfXkdToWwygWieGkqRuNORutFVF.jpg','https://image.tmdb.org/t/p/w500/cjixpU92TU63AgpxVvSkofMAy9g.jpg','0','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 16:58:01','2015-06-05 13:18:11'),(24,5,'62717','closed','tv','request','Jonathan Strange & Mr Norrell (2015)','https://image.tmdb.org/t/p/w500/6OUttntdOqOAepjZ9rzm5XaNRQz.jpg','https://image.tmdb.org/t/p/w500/xbOnQ5qqT2X0MTR4T4FELijdWI4.jpg','8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 17:40:55','2015-06-05 13:19:37'),(25,13,'1432','closed','tv','request','Veronica Mars (2004)','https://image.tmdb.org/t/p/w500/8ThWFacN4JIsaITvksyVl1xGpUp.jpg','https://image.tmdb.org/t/p/w500/iXFXSqkGFWKSggIYKyjfUKk1VEn.jpg','7.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 18:59:14','2015-06-05 13:20:11'),(26,13,'2059','closed','','request','National Treasure (2004)','http://image.tmdb.org/t/p/w500/luMoc56LLMWUt60vUNNpwxrbTNt.jpg','http://image.tmdb.org/t/p/w500/a8MKD2z2UuptTaA26ueJVJk3GGb.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 18:59:28','2015-06-05 14:10:22'),(27,13,'6637','closed','','request','National Treasure: Book of Secrets (2007)','http://image.tmdb.org/t/p/w500/5fOwo57lLZ3TFPG5jL6Db9Qaq8Q.jpg','http://image.tmdb.org/t/p/w500/oKLa1SGDlT0Zi9lyLcl2N2sFxsc.jpg','5.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 18:59:38','2015-06-05 23:21:33'),(28,13,'188222','pending','','request','Entourage (2015)','http://image.tmdb.org/t/p/w500/iDN131W0jebCuMBowa9s94RdQ1N.jpg','http://image.tmdb.org/t/p/w500/rohVTacbOboHVjLkng0UMeXtLUR.jpg','4.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:01:07','2015-06-06 02:50:17'),(29,13,'37680','closed','tv','request','Suits (2011)','https://image.tmdb.org/t/p/w500/i6Iu6pTzfL6iRWhXuYkNs8cPdJF.jpg','https://image.tmdb.org/t/p/w500/dpSTckg9dzOD8JKR9iVrStK2st1.jpg','8.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:01:27','2015-06-06 14:57:50'),(30,13,'1865','closed','','request','Pirates of the Caribbean: On Stranger Tides (2011)','http://image.tmdb.org/t/p/w500/jUkGuSC9Kt29rW3x6UiB9zyZr1M.jpg','http://image.tmdb.org/t/p/w500/ddPXVUAeCBFMbtTajh8bg4uyBvv.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:03:28','2015-06-05 23:21:35'),(31,13,'58','closed','','request','Pirates of the Caribbean: Dead Man\'s Chest (2006)','http://image.tmdb.org/t/p/w500/iwvyZBRD7qfDQ8ylRmf5NbLC5Oi.jpg','http://image.tmdb.org/t/p/w500/hdHgIcljPHli4xaJGt0INz8Gn3J.jpg','6.7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:03:37','2015-06-05 23:21:18'),(32,13,'285','closed','','request','Pirates of the Caribbean: At World\'s End (2007)','http://image.tmdb.org/t/p/w500/bXb00CkHqx7TPchTGG131sWV59y.jpg','http://image.tmdb.org/t/p/w500/8ZgpAftUiYTU76IhUADITa3Ur9n.jpg','6.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:03:50','2015-06-05 23:21:41'),(33,13,'612','closed','','request','Munich (2005)','http://image.tmdb.org/t/p/w500/3pnsX1egUElYvgmAcCqYvXVOY9O.jpg','http://image.tmdb.org/t/p/w500/qhOlcpkWW0AcrCRvqnddA6kgCH4.jpg','6.7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:05:12','2015-06-05 23:21:44'),(34,13,'9522','closed','','request','Wedding Crashers (2005)','http://image.tmdb.org/t/p/w500/vlnDz1Y3IcBhPyQAqAVtNghx4Eq.jpg','http://image.tmdb.org/t/p/w500/4V0hNC6SEbm836eg2BeaJvx1ZEO.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:06:47','2015-06-05 23:21:39'),(35,13,'9342','closed','','request','The Mask of Zorro (1998)','http://image.tmdb.org/t/p/w500/eh59q4ksXDQc97s52FUUQOkE8Th.jpg','http://image.tmdb.org/t/p/w500/734CjgMxoKZ0eTmE0R2WiMZQ5LL.jpg','6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:07:41','2015-06-05 23:21:12'),(36,13,'1656','closed','','request','The Legend of Zorro (2005)','http://image.tmdb.org/t/p/w500/rH3WJbSE3APS1l1hTXZZbz3NVP1.jpg','http://image.tmdb.org/t/p/w500/mXP2oP6feaovDp03Q2SbterHTfa.jpg','5.8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04 19:08:00','2015-06-05 23:21:36'),(38,13,'16072','closed','','request','Gods and Generals (2003)','http://image.tmdb.org/t/p/w500/jodqsKcMfd31vqXHCosQ8joB5Hm.jpg','http://image.tmdb.org/t/p/w500/digwjKMBvk0C7ZeAMAXgoz2EKRv.jpg','6.5','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-06 03:58:54','2015-06-06 13:57:41'),(39,13,'10655','closed','','request','Gettysburg (1993)','http://image.tmdb.org/t/p/w500/xjpMfoPmo4bX8MEZPpWl8lBq6rx.jpg','http://image.tmdb.org/t/p/w500/lMtCVnBJ6C1q4YnfHGs7I6hPeGI.jpg','6.4','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-06 04:04:21','2015-06-06 13:57:54'),(40,14,'270303','closed','','request','It Follows (2014)','http://image.tmdb.org/t/p/w500/4MrwJZr0R9LbyOgZqwLNmtzzxbu.jpg','http://image.tmdb.org/t/p/w500/3kaKAlAsv44hKJ2JkPsu0kNYEJl.jpg','7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-06 13:31:23','2015-06-06 14:57:55'),(41,14,'11054','closed','','request','Hairspray (1988)','http://image.tmdb.org/t/p/w500/awlcy51BoQxqxI6M6hqaQyUeEDj.jpg','http://image.tmdb.org/t/p/w500/ta9qJx96X4F9MK4PnYDpiAJeUWX.jpg','6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-06 14:54:22','2015-06-07 14:00:19'),(42,14,'8291','closed','','request','Poetic Justice (1993)','http://image.tmdb.org/t/p/w500/vfXuJbZucP2hgkuthwMyz1IEM8s.jpg','http://image.tmdb.org/t/p/w500/8OlUqdPsJTOG1fqshk9PEtTswdJ.jpg','6.2','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-11 04:30:00','2015-06-12 02:59:40'),(43,15,'320295','closed','','request','Detective Byomkesh Bakshy (2015)','http://image.tmdb.org/t/p/w500/hKf0pKDFZCPHd5Uf4vQIA8OzoIP.jpg','http://image.tmdb.org/t/p/w500/98cXh6jIzEcdxzSwXKcrBee7St3.jpg','8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-14 17:39:56','2015-06-16 02:43:02'),(45,16,'54671','closed','tv','issue','Penny Dreadful (2014)','https://image.tmdb.org/t/p/w500/fZXn2Nh8CNYRhGR2q1JVCnoeHJQ.jpg','https://image.tmdb.org/t/p/w500/xmmVkeA5xIpWuON7P9W28PINWKA.jpg','7.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-15 20:29:28','2015-06-30 23:48:24'),(46,17,'31911','closed','tv','request','Fullmetal Alchemist: Brotherhood (2009)','https://image.tmdb.org/t/p/w500/aYVBoq5MEtOBLlivSzDSpteZfXV.jpg','https://image.tmdb.org/t/p/w500/c368lahfH9sgdDHKp6ds7EprIga.jpg','7.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-21 16:37:53','2015-06-27 14:03:19'),(47,17,'37863','closed','tv','request','Fullmetal Alchemist (2004)','https://image.tmdb.org/t/p/w500/wMFZPYHT2z0LHQo38DNAsaKkrcs.jpg','https://image.tmdb.org/t/p/w500/dshSjE7LZRR7CK58hLDhOz5ANFe.jpg','5.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-21 16:38:03','2015-06-27 14:03:24'),(48,14,'10019','closed','','request','Mannequin (1987)','http://image.tmdb.org/t/p/w500/b60ZhkTTzlYdLF8TlGu43OHhd7Q.jpg','http://image.tmdb.org/t/p/w500/903PBoEP6Ii0f27x3iu1LgP9ox1.jpg','6.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-22 16:14:08','2015-06-27 14:05:11'),(49,5,'239573','closed','','request','Unfinished Business (2015)','http://image.tmdb.org/t/p/w500/syjAbeqw3pNwEmRQHlRGHZUG9kF.jpg','http://image.tmdb.org/t/p/w500/soIm2LsHjMxAd4RB2V9Ce67JW9t.jpg','4.8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-23 17:53:55','2015-06-28 03:22:07'),(50,5,'329','closed','','request','Jurassic Park (1993)','http://image.tmdb.org/t/p/w500/c414cDeQ9b6qLPLeKmiJuLDUREJ.jpg','http://image.tmdb.org/t/p/w500/37y4MDTAAoBnTbX93WqaAAqm0on.jpg','7.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-23 17:54:15','2015-06-27 14:06:13'),(51,5,'3003','closed','','request','The Lost World (2001)','http://image.tmdb.org/t/p/w500/1MELelWN5lxv9Ufnwii24JUe5zM.jpg','http://image.tmdb.org/t/p/w500/58IdBN1UfzJeP5D4UU2WyDj9TJj.jpg','5.4','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-23 17:54:28','2015-06-30 00:02:49'),(53,5,'257091','closed','','request','Get Hard (2015)','http://image.tmdb.org/t/p/w500/qRzUSrN4p6B7fzA5XGm4ebFg3co.jpg','http://image.tmdb.org/t/p/w500/8dHsvdiZLBdppKwRiZ0XZYngbeN.jpg','6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-23 17:54:47','2015-06-30 00:13:23'),(54,5,'62681','closed','tv','request','Deutschland 83 (2015)','https://image.tmdb.org/t/p/w500/yL7XdYrbjwPQg9Xt4NUspKLyM1K.jpg','https://image.tmdb.org/t/p/w500/mDDr2xJUpLWUcIHXDBIPydcC0Hd.jpg','0','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-24 21:41:39','2015-06-30 00:01:15'),(55,5,'62560','closed','tv','request','Mr. Robot (2015)','https://image.tmdb.org/t/p/w500/aubGV7NnVPjmX0XuXpHRlA1i5qF.jpg','https://image.tmdb.org/t/p/w500/9OEWK8nMTFmqQwAFpFyn7snIGP8.jpg','7.8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-24 23:06:13','2015-06-29 23:59:18'),(56,13,'33827','closed','tv','request','How the Universe Works (2010)','https://image.tmdb.org/t/p/w500/2MsdHYtEZQqcifU61qVL9pUkqur.jpg','https://image.tmdb.org/t/p/w500/3B1kSwOwaj5kJ12B6kUxV4Beh0Y.jpg','9.8','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-04 00:39:38','2015-07-05 21:24:07'),(57,13,'250066','closed','','request','American Heist (2014)','http://image.tmdb.org/t/p/w500/6BPoMjHNqLxMhIeoGO1zpcpQWlw.jpg','http://image.tmdb.org/t/p/w500/dGDXCE7b6gjwGtyw0r8YWCaGO6z.jpg','4.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-04 00:39:56','2015-07-05 21:24:13'),(58,17,'62744','closed','tv','request','Major Lazer (2015)','https://plexy.ehumps.me/assets/img/no-poster.jpg','https://image.tmdb.org/t/p/w500/q6fX7jCJr9mGNrYXoDmbxYG7aeL.jpg','0','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-05 17:52:18','2015-07-08 02:47:12'),(59,5,'62822','closed','tv','request','Humans (2015)','https://image.tmdb.org/t/p/w500/gJCyS65ieDT827F2NR9Nx9ZLuw5.jpg','https://image.tmdb.org/t/p/w500/98MkbBwdbw9xfmxJlYlBWqu6xZZ.jpg','7.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-09 21:37:48','2015-07-10 00:19:07'),(60,5,'201088','closed','','request','Blackhat (2015)','http://image.tmdb.org/t/p/w500/sW3VEsulmxMlOmQwm0h7H7lZROi.jpg','http://image.tmdb.org/t/p/w500/biw5Nn85iBZZd8GWYO9XXH56VK2.jpg','5','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-09 21:38:18','2015-07-10 00:19:13'),(61,19,'256924','closed','','request','Danny Collins (2015)','http://image.tmdb.org/t/p/w500/4urGjmgtjuEBvfOhf37Cb0sICvM.jpg','http://image.tmdb.org/t/p/w500/rMTGWpCDLQIbWIhkfZdB9xU36Gd.jpg','7.2','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-10 04:10:46','2015-07-15 01:39:44'),(62,13,'1535','closed','','request','Spy Game (2001)','http://image.tmdb.org/t/p/w500/hsb8hBeU3tkTX8SUYW6YYw6JPYD.jpg','http://image.tmdb.org/t/p/w500/1Q6thcZHsDiJ0iRMXZWf7IEtX2b.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-13 00:00:21','2015-07-15 01:39:50'),(63,13,'4169','closed','','request','Breach (2007)','http://image.tmdb.org/t/p/w500/z38R6SPSNZM3mwbfH2D4wgZEtzv.jpg','http://image.tmdb.org/t/p/w500/nYgZ3V4rmjwitlK1w2wcXcXoEqo.jpg','5.7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-13 00:01:34','2015-07-15 01:40:27'),(64,13,'1495','closed','','request','Kingdom of Heaven (2005)','http://image.tmdb.org/t/p/w500/d9GYuT9aMoDi4MPTKYe4M2PwUm4.jpg','http://image.tmdb.org/t/p/w500/dzMGckpN2xAQDLr2Ddr8CZ3WbYF.jpg','6.3','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-13 00:02:25','2015-07-15 01:40:35'),(65,13,'652','closed','','request','Troy (2004)','http://image.tmdb.org/t/p/w500/edMlij7nw2NMla32xskDnzMCFBM.jpg','http://image.tmdb.org/t/p/w500/lIyNUZbIeEwWpaWXAO5gnciB8Dq.jpg','6.7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-13 00:03:46','2015-07-15 01:41:04'),(66,5,'207703','closed','','request','Kingsman: The Secret Service (2015)','http://image.tmdb.org/t/p/w500/8x7ej0LnHdKUqilNNJXYOeyB6L9.jpg','http://image.tmdb.org/t/p/w500/9eKd1DDDAbrDNXR2he7ZJEu7UkI.jpg','7.7','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-15 18:59:20','2015-07-20 18:31:40'),(68,13,'4133','closed','','request','Blow (2001)','http://image.tmdb.org/t/p/w500/yCLLbZzAa7jreGus7pvjZmL0bj7.jpg','http://image.tmdb.org/t/p/w500/kvDTWK25Yp92wg2ksAhKebISXZY.jpg','7.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-21 19:36:09','2015-07-23 02:37:12'),(70,5,'182873','closed','','request','Green Street Hooligans: Underground (2013)','http://image.tmdb.org/t/p/w500/47O0DRT92EIfWEOYTjMQIF1vBE2.jpg','http://image.tmdb.org/t/p/w500/abNekkt3ZRATLgVaoRkQJnTHKVs.jpg','5','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-22 14:22:59','2015-07-23 02:37:26'),(71,5,'172533','closed','','request','Drinking Buddies (2013)','http://image.tmdb.org/t/p/w500/zongyslIHQmfnf9rgUioPkDaHmq.jpg','http://image.tmdb.org/t/p/w500/7XO35t81SB5woNWl2pkq86QN982.jpg','6.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-22 14:23:37','2015-07-24 02:34:20'),(72,5,'11528','closed','','request','The Sandlot (1993)','http://image.tmdb.org/t/p/w500/fKJUQrAm5QbVR5DqgH9U5IflHGQ.jpg','http://image.tmdb.org/t/p/w500/m6kXoIPsU2zkvpA08pbJ3klRSW6.jpg','7.2','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-22 14:23:52','2015-07-23 02:37:34'),(73,5,'8923','closed','','request','Hooligans (2005)','http://image.tmdb.org/t/p/w500/z3LC4kI8azbeuHRGgDdWo6VBCdX.jpg','http://image.tmdb.org/t/p/w500/qG2NKjGLsFxohQYUWcjgI1fsuzz.jpg','6.9','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-23 21:45:30','2015-07-26 02:49:23'),(74,20,'17414','closed','','request','Dunston Checks In (1996)','http://image.tmdb.org/t/p/w500/lXSWbUA3T2o792SYdbfFKFTcSC1.jpg','http://image.tmdb.org/t/p/w500/dpiciyrHsu9BchmC4x8PoCfubre.jpg','5.6','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-26 03:16:20','2015-07-26 04:24:28'),(76,7,'126963','closed','','request','Doragon boru Z: Kami to kami (2013)','http://image.tmdb.org/t/p/w500/xI5LlCzSkp8iFSbmla0Dh4iT5ie.jpg','http://image.tmdb.org/t/p/w500/xKVE8ZsNUBBI0sE4Vpv8yv6DsPZ.jpg','6.4','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-26 15:55:43','2015-07-26 16:14:48'),(77,21,'41727','closed','tv','request','Banshee (2013)','https://image.tmdb.org/t/p/w500/fvocBFChMERoxWb7MMuTsUqWEis.jpg','https://image.tmdb.org/t/p/w500/rvk7SMZRKR5BxDAxZmR5RF666uC.jpg','8.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-28 13:39:48','2015-07-30 02:41:29'),(78,7,'262500','closed','','request','Insurgent (2015)','http://image.tmdb.org/t/p/w500/aBBQSC8ZECGn6Wh92gKDOakSC8p.jpg','http://image.tmdb.org/t/p/w500/L5QRL1O3fGs2hH1LbtYyVl8Tce.jpg','7.1','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-29 21:34:14','2015-07-30 02:24:43'),(79,22,'139779','pending','','issue','Americans (2012)','http://plexy.ehumps.me/assets/img/no-poster.jpg','http://plexy.ehumps.me/assets/img/no-backdrop.jpg','0','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-30 01:31:42','2015-07-30 01:53:37'),(80,22,'21762','open','tv','request','Parenthood (2010)','https://image.tmdb.org/t/p/w500/bjTrFU3U7DRsNix6lAd3BTxtxGP.jpg','https://image.tmdb.org/t/p/w500/AnyJUFCXJj5TUpH7PhRSklB58jR.jpg','5.5','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-30 01:32:55','2015-07-30 01:32:55'),(81,4,'3049','open','','request','Ace Ventura: Pet Detective (1994)','http://image.tmdb.org/t/p/w500/nZirljb8XYbKTWsRQTplDGhx39Q.jpg','http://image.tmdb.org/t/p/w500/d29F2JeMP1S6MQG4o5N6BCpRC3n.jpg','6.2','','',NULL,NULL,NULL,NULL,NULL,NULL,'2015-07-30 15:29:26','2015-07-30 15:29:26');
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
  `issue_id` int(10) unsigned DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `messages_user_id_index` (`user_id`),
  KEY `messages_post_id_index` (`post_id`),
  KEY `messages_issue_id_index` (`issue_id`),
  CONSTRAINT `messages_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (4,5,NULL,12,'http://www.imdb.com/title/tt0273923/\r\n','2015-05-29 14:42:00','2015-05-29 14:42:00'),(5,1,NULL,12,'started the download, should be up today','2015-05-29 15:21:34','2015-05-29 15:21:34'),(7,1,NULL,12,'It\'s now on plex','2015-05-29 17:21:29','2015-05-29 17:21:29'),(9,1,NULL,16,'your dingo shall arrive shortly','2015-06-01 22:54:56','2015-06-01 22:54:56'),(10,1,NULL,16,'It\'s on plex now, you dingo','2015-06-02 12:00:05','2015-06-02 12:00:05'),(12,1,NULL,18,'Added to plex','2015-06-03 19:53:11','2015-06-03 19:53:11'),(13,12,NULL,22,'Need English subtitties','2015-06-04 13:33:20','2015-06-04 13:33:20'),(14,1,NULL,22,'i added some english subtitties for ya, might be showing up as \"unknown\". it is known.','2015-06-04 15:30:47','2015-06-04 15:30:47'),(15,1,NULL,23,'do you want all 14 seasons or just the latest','2015-06-04 17:03:16','2015-06-04 17:03:16'),(16,5,NULL,23,'HAHAHA ...maybe the last 4 or 5.  this thing needs emojis','2015-06-04 17:11:05','2015-06-04 17:11:05'),(17,13,NULL,34,'Full length not theatrical\r\n','2015-06-04 19:07:07','2015-06-04 19:07:07'),(18,1,NULL,23,'put up the last few seasons, holla if you need more. closing it for now','2015-06-05 13:18:05','2015-06-05 13:18:05'),(19,1,NULL,24,'its up on plex now, enjoy','2015-06-05 13:18:23','2015-06-05 13:18:23'),(20,1,NULL,24,'its up on plex now, enjoy','2015-06-05 13:18:23','2015-06-05 13:18:23'),(21,1,NULL,25,'done','2015-06-05 13:20:04','2015-06-05 13:20:04'),(22,1,NULL,26,'done, let me know if there are issues with it','2015-06-05 14:10:17','2015-06-05 14:10:17'),(25,1,NULL,28,'theaters June 12, 2015 prob leak 3 months after','2015-06-06 02:50:11','2015-06-06 02:50:11'),(26,1,NULL,42,'tupac on deck','2015-06-12 02:59:36','2015-06-12 02:59:36'),(27,1,NULL,45,'whats wrong with it?','2015-06-16 01:18:11','2015-06-16 01:18:11'),(28,1,NULL,43,'downloading now','2015-06-16 01:18:20','2015-06-16 01:18:20'),(29,1,NULL,50,'already had it','2015-06-27 14:06:08','2015-06-27 14:06:08'),(30,1,NULL,49,'downloading now','2015-06-27 14:06:21','2015-06-27 14:06:21'),(31,1,NULL,55,'downloading now','2015-06-29 23:59:23','2015-06-29 23:59:23'),(32,1,NULL,54,'downloading now','2015-06-30 00:01:08','2015-06-30 00:01:08'),(33,1,NULL,51,'i don\'t think this is the one you really want but its downloading regardless','2015-06-30 00:02:45','2015-06-30 00:02:45'),(35,1,NULL,53,'i think its downloading now','2015-06-30 00:13:14','2015-06-30 00:13:14'),(36,1,NULL,56,'downloading season 1 thru 3 now, season 4 starts july 14','2015-07-04 00:57:05','2015-07-04 00:57:05'),(37,1,NULL,57,'downloading now','2015-07-04 00:59:56','2015-07-04 00:59:56'),(38,12,NULL,22,'it doesnt work','2015-07-05 00:11:24','2015-07-05 00:11:24'),(39,1,NULL,59,'added i think','2015-07-10 00:19:03','2015-07-10 00:19:03'),(40,1,NULL,60,'added i think','2015-07-10 00:19:16','2015-07-10 00:19:16'),(41,1,NULL,61,'downloaded','2015-07-15 01:39:39','2015-07-15 01:39:39'),(42,1,NULL,62,'downloaded','2015-07-15 01:39:53','2015-07-15 01:39:53'),(43,1,NULL,63,'downloaded','2015-07-15 01:40:29','2015-07-15 01:40:29'),(44,1,NULL,64,'downloaded','2015-07-15 01:40:37','2015-07-15 01:40:37'),(45,1,NULL,65,'downloaded','2015-07-15 01:41:06','2015-07-15 01:41:06'),(47,1,NULL,66,'downloading now properly','2015-07-16 19:57:18','2015-07-16 19:57:18'),(50,1,NULL,68,'done','2015-07-23 02:37:16','2015-07-23 02:37:16'),(51,5,NULL,71,'closing this','2015-07-23 21:44:33','2015-07-23 21:44:33'),(52,5,NULL,71,'*can\'t delete comments - feature request*  But close this haha','2015-07-23 21:44:57','2015-07-23 21:44:57'),(53,1,NULL,71,'github that enhancement requesttttt','2015-07-24 02:34:36','2015-07-24 02:34:36'),(54,20,NULL,74,'i love you','2015-07-26 03:16:43','2015-07-26 03:16:43'),(58,1,NULL,74,'<img src=\"http://i.imgur.com/bMjFk0B.png\" width=\"100%\">','2015-07-26 04:24:11','2015-07-26 04:24:11'),(59,7,NULL,76,'','2015-07-26 15:55:52','2015-07-26 15:55:52'),(60,1,NULL,76,'downloading now','2015-07-26 16:00:51','2015-07-26 16:00:51'),(61,1,NULL,76,'done','2015-07-26 16:14:44','2015-07-26 16:14:44'),(62,22,NULL,79,'Episode 10, Season 2 stops playing around minute 39. ','2015-07-30 01:32:38','2015-07-30 01:32:38'),(63,1,NULL,77,'downloading now','2015-07-30 01:37:50','2015-07-30 01:37:50'),(64,1,NULL,79,'i just replaced it. try it now','2015-07-30 01:53:28','2015-07-30 01:53:28');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2009_02_05_024934_confide_setup_users_table',1),('2012_01_31_160913_create_issues_table',1),('2013_02_05_043505_create_posts_table',1),('2013_02_05_044505_create_comments_table',1),('2013_02_05_044505_create_messages_table',1),('2013_02_08_031702_entrust_setup_tables',1),('2013_05_21_024934_entrust_permissions',1),('2015_01_25_230157_create_requests_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reminders`
--

LOCK TABLES `password_reminders` WRITE;
/*!40000 ALTER TABLE `password_reminders` DISABLE KEYS */;
INSERT INTO `password_reminders` VALUES ('yourface91@gmail.com','9b1a28c74e929f343d85da06d223d1b4','2015-06-04 13:12:54');
/*!40000 ALTER TABLE `password_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_role_permission_id_role_id_unique` (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,6,2);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  UNIQUE KEY `permissions_display_name_unique` (`display_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage_blogs','manage blogs'),(2,'manage_posts','manage posts'),(3,'manage_comments','manage comments'),(4,'manage_users','manage users'),(5,'manage_roles','manage roles'),(6,'post_comment','post comment');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `posts_user_id_index` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'Lorem ipsum dolor sit amet','lorem-ipsum-dolor-sit-amet','In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?\n\nEst hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!\n\nSed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.\n\nSed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.\n\nTe amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!\n\nCu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.\n\nTe dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.\n\nMutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.\n\nEx dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!\n\nTe his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?','meta_title1','meta_description1','meta_keywords1','2015-05-28 04:48:34','2015-05-28 04:48:34'),(2,1,'Vivendo suscipiantur vim te vix','vivendo-suscipiantur-vim-te-vix','In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?\n\nEst hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!\n\nSed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.\n\nSed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.\n\nTe amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!\n\nCu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.\n\nTe dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.\n\nMutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.\n\nEx dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!\n\nTe his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?','meta_title2','meta_description2','meta_keywords2','2015-05-28 04:48:34','2015-05-28 04:48:34'),(3,1,'In iisque similique reprimique eum','in-iisque-similique-reprimique-eum','In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?\n\nEst hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!\n\nSed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.\n\nSed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.\n\nTe amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!\n\nCu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.\n\nTe dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.\n\nMutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.\n\nEx dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!\n\nTe his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?','meta_title3','meta_description3','meta_keywords3','2015-05-28 04:48:34','2015-05-28 04:48:34');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tmdb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('open','pending','closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `topic` enum('miscellaneous','movies','music','tv') COLLATE utf8_unicode_ci NOT NULL,
  `post_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `backdrop_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `requests_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2015-05-28 04:48:34','2015-05-28 04:48:34'),(2,'comment','2015-05-28 04:48:34','2015-05-28 04:48:34');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'evan','humphries.evan@gmail.com','$2y$10$g.HUR/mT261o99YFnhbMaerk6Yw.SpXfMg/RcULab9EZ48R.psDhK','4a25f6067b8834f16c888da030122f72','ylaivk3vxnIaboQKOKqBbZYrF64EYkJCslOkUxQdCPb8ym3BIZO16BW7ufb5',1,'2015-05-28 04:48:34','2015-07-28 04:25:11'),(3,'yourface91','yourface91@gmail.com','$2y$10$.WE4FjMLlWbzQOzux8/5V.ovi1zxZFyMjV2UCgLT3rpuUioKa/9/2','d4917229e8cdf8d23dd1cd66aa483b0d',NULL,1,'2015-05-28 05:21:08','2015-05-28 05:22:01'),(4,'ehumps','do.not.reply.contact.form@gmail.com','$2y$10$mySDtKXFcrtoCHVixlOUQuP65LXrmu.kPVioRRVSuyyis/M.AkSye','1e06cddc2580e94969c3fa3dd8fc3bf9','DsFt4Lv4ZoZMey5dXOpoth5rPzajD3mUOf7eZhrOProR4yNhhkH0O2JomeDi',1,'2015-05-28 05:21:42','2015-07-28 00:28:25'),(5,'jstewsy','jstew529+plexy@gmail.com','$2y$10$k64RkaYyc7q/4hUBlUyjX.hUzO3wt4VVULkE.a5TzAUugNrlpAiBW','10c7d239071cfdaa27e178dac483821d','2dACpGlTmJP2dA4w8TY1G56ZZTrYt1hZhMmlB0XNGzG74OH3BdRnh49jOgDS',1,'2015-05-29 13:36:24','2015-05-29 14:27:55'),(7,'whanna','whanna26@gmail.com','$2y$10$IhDiL5HqOgPMgNnRgLXHS.OsMQrr8De/09YAp21KU8wVnMEBA0v7a','5addbdbb751e6033cdf7fcb1fcd68538',NULL,1,'2015-05-29 15:24:12','2015-05-29 15:32:03'),(8,'autolue','autolue@gmail.com','$2y$10$12GA9a0501I9duy3UJkw0.uObJcLCx1RLnpqTf5W1pRM2l.07Mbdm','2d814e0ef3d3f2b7337872e7b67a0b66',NULL,1,'2015-05-29 15:27:03','2015-05-29 15:41:57'),(9,'Itrivedi','Ishan.trivedi@gmail.com','$2y$10$Vb/iDlIM.D0nLpQqUtxEF.wD5IpN3Akzw9ObeSrkC0SvhHcWAf/Dy','a31984aa72ee3087a329a4ab66c9a0e1',NULL,1,'2015-05-29 16:50:32','2015-05-29 16:55:54'),(10,'Derek','botaoftw@gmail.com','$2y$10$jUIQn6L70L4aKDMnP8WkqeKRIZeJzOfMSgHr4Ftw6bG1Sf6l29DDi','cb70ad871734ec4121dfc4c8cf998ca7','fp8W0v0ZVOjbP9Nk8QaWtjoMAgoQptfGxmhAYjEatYrUf3dJlrvWd8CPQgOn',1,'2015-05-29 16:51:48','2015-06-03 21:27:37'),(11,'chris17brown','chris17brown@gmail.com','$2y$10$QZxG0IgKtwCKGT51X/9fweg9OsbJQghczKInjloVyi5Q6eqd/Furm','f4576ec5459e51995577ce7ae473382c',NULL,0,'2015-05-29 21:08:03','2015-05-29 21:08:03'),(12,'danny','dannybotaochen@gmail.com','$2y$10$.q4bHwdGjDLAudOwhAf.K.inxJEPCTWedBB/YpSmzpDXcBYsBn4u.','80f6ecff1da3ff4be4b86995885f5550',NULL,1,'2015-06-04 13:20:09','2015-06-04 13:32:51'),(13,'derekmpreston','derek.m.preston@gmail.com','$2y$10$7m2oImvdU3YeNKX93t3w9e5WPbML6aVrwZl78bDx1bd55A6iYV.4m','40706e3997276cb56251d57bc91e0621',NULL,1,'2015-06-04 18:47:02','2015-06-04 18:58:50'),(14,'emmyhoov','emmy.hooven@gmail.com','$2y$10$kLdjxBUFVTIXHCiX480mi.aSVJpQVJxVV81QhmiCxACSyBK2.5SxK','23822ad61b84411a0026d5076734dc41',NULL,1,'2015-06-05 23:15:22','2015-06-06 00:14:31'),(15,'adas113','abhiroopdas31@gmail.com','$2y$10$RplaQe15TbBdYXczZAC.LeqUWOzt8DtzIc/tqVuiiY8ulQL1ITnWm','403007584e78b9cbc0daec6683d510f6',NULL,1,'2015-06-14 17:38:53','2015-06-14 17:39:10'),(16,'humfrolio','humfrolio@gmail.com','$2y$10$2.PJj/P0jYbugxk5b0IgrOuZ/S2KVjGIbgNwzrCoLuv5jarZXaYX6','7ae86d30292f7ad515e99b91c2e02274',NULL,1,'2015-06-14 20:47:05','2015-06-14 20:48:00'),(17,'gravychops','elsoch@gmail.com','$2y$10$L3V1gLOwJBW2KZEjoIKNcO7tWJf850HrplFlWfFbxWUiAkvMlwhtS','e96cf1dd6abf94f86973a5b1e3d5b0c5',NULL,1,'2015-06-21 16:36:58','2015-06-21 16:37:20'),(18,'njetsy4991','chris.cho.30@gmail.com','$2y$10$DJc4OQw1Xg3kJ0aw.K8bR.LBrjSfFLAdP4KUvks2n9r6mgD0r7ez.','146a2899cfa842dd82d97c3180a1d329',NULL,1,'2015-07-04 00:39:28','2015-07-04 00:45:40'),(19,'sophie','sophia.e.hastings@gmail.com','$2y$10$1Cgare6KHilszKtFyK5oOeh9V7A8qWJUBpVlpSBXMJ/mfBC3LYgrq','e5cc7604053b24e1ed9c6cc219fbf1f9',NULL,1,'2015-07-10 04:09:39','2015-07-10 04:10:19'),(20,'zelicoffm','zelicoffm@gmail.com','$2y$10$2BiKRiXgKd7aww9kHOYefuq2mk44z71lm8I0gQh8I2xQTHTVcS4HG','01a303e84321d5591cdcf3a2131e6e27',NULL,1,'2015-07-26 03:14:48','2015-07-26 03:15:38'),(21,'po13','peterott3@gmail.com','$2y$10$dvhkaCcPzvAYkMlw7XgLJ.E6mZJxq56/9XrFpU1UKjMR25NZPwF3W','9d1055b44bc098553ce5263de1480430',NULL,1,'2015-07-28 13:37:14','2015-07-28 13:37:34'),(22,'melprest','melanie.preston@gmail.com','$2y$10$hfuxwFvb4nV2StzM0QlvSuArw0KaRiEsfI1MkXP423g346ET2sffG','29a54021e26c53dfb7f3c8e0cb32bdd8',NULL,1,'2015-07-30 01:27:03','2015-07-30 01:27:37');
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

-- Dump completed on 2015-07-30 12:52:21
