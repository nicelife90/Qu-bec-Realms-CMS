
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
-- Table structure for table `ae_account`
--

DROP TABLE IF EXISTS `ae_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` tinytext,
  `email` varchar(150) DEFAULT NULL,
  `profile_img` text,
  `last_login_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `login_attempt` int(1) NOT NULL DEFAULT '0',
  `account_group` int(1) DEFAULT NULL,
  `inscription_date` timestamp NULL DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `account_group` (`account_group`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC
  COMMENT ='Accounts';
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `ae_group`
--

DROP TABLE IF EXISTS `ae_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(2) NOT NULL,
  `group_name` varchar(35) NOT NULL,
  `dashboard` tinytext,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8
  COMMENT ='Groups';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_group`
--

LOCK TABLES `ae_group` WRITE;
/*!40000 ALTER TABLE `ae_group` DISABLE KEYS */;
INSERT INTO `ae_group`
VALUES (1, 1, 'Player', 'dashboard'), (2, -1, 'Developer', 'dashboard'), (3, 3, 'Game Master', 'dashboard'),
  (4, 4, 'Administrator', 'dashboard');
/*!40000 ALTER TABLE `ae_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ae_menu`
--

DROP TABLE IF EXISTS `ae_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(1) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `icon` tinytext NOT NULL,
  `display_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARSET = utf8
  COMMENT ='Menus';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_menu`
--

LOCK TABLES `ae_menu` WRITE;
/*!40000 ALTER TABLE `ae_menu` DISABLE KEYS */;
INSERT INTO `ae_menu` VALUES (4,12,'Configuration','fa-cogs',1);
/*!40000 ALTER TABLE `ae_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ae_module`
--

DROP TABLE IF EXISTS `ae_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `access_level` tinytext NOT NULL,
  `parent` int(11) NOT NULL,
  `static` int(1) NOT NULL DEFAULT '0',
  `visits` int(11) DEFAULT '0',
  `last_visit` timestamp NULL DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 39
  DEFAULT CHARSET = utf8
  COMMENT ='Modules';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_module`
--

LOCK TABLES `ae_module` WRITE;
/*!40000 ALTER TABLE `ae_module` DISABLE KEYS */;
INSERT INTO `ae_module`
VALUES (1, 'Dashboard', 'dashboard', 'fa-wrench', '1;-1;8;4', -1, 1, 470, '2018-02-28 23:17:26', 1),
  (2, 'Account Management', 'manage-account', 'fa-wrench', '-1', 12, 0, 111, '2018-02-28 20:27:57', 1),
  (4, 'Menu Management', 'manage-menu', 'fa-wrench', '-1', 12, 0, 191, '2018-02-28 20:28:00', 1),
  (5, 'Module Management', 'manage-module', 'fa-wrench', '-1', 12, 0, 132, '2018-02-28 20:30:58', 1),
  (6, 'My Account', 'profile', 'fa-wrench', '1;-1;8;4', -1, 1, 108, '2018-02-28 20:36:20', 1),
  (7, 'RBAC Management', 'manage-rbac', 'fa-wrench', '-1', 12, 0, 29, '2018-02-28 20:32:15', 1),
  (8, 'Access denied', 'denied', 'fa-wrench', '1;-1;8;4', -1, 1, 18, '2018-01-15 20:27:42', 1);
/*!40000 ALTER TABLE `ae_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ae_rbac_assignment`
--

DROP TABLE IF EXISTS `ae_rbac_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_rbac_assignment` (
  `group_id` int(11) NOT NULL,
  `rbac_items_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`rbac_items_id`),
  KEY `rbac_items_id` (`rbac_items_id`),
  CONSTRAINT `ae_rbac_assignment_ibfk_1` FOREIGN KEY (`rbac_items_id`) REFERENCES `ae_rbac_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ae_rbac_assignment_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `ae_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_rbac_assignment`
--

LOCK TABLES `ae_rbac_assignment` WRITE;
/*!40000 ALTER TABLE `ae_rbac_assignment` DISABLE KEYS */;
INSERT INTO `ae_rbac_assignment` VALUES (-1, 1), (1, 1), (3, 1), (4, 1), (-1, 2);
/*!40000 ALTER TABLE `ae_rbac_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ae_rbac_items`
--

DROP TABLE IF EXISTS `ae_rbac_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_rbac_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_rbac_items`
--

LOCK TABLES `ae_rbac_items` WRITE;
/*!40000 ALTER TABLE `ae_rbac_items` DISABLE KEYS */;
INSERT INTO `ae_rbac_items` VALUES (1, 'Can see the loading time of the page.'), (2, 'Can display the debug bar.');
/*!40000 ALTER TABLE `ae_rbac_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ae_setting`
--

DROP TABLE IF EXISTS `ae_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ae_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COMMENT ='Settings';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ae_setting`
--

LOCK TABLES `ae_setting` WRITE;
/*!40000 ALTER TABLE `ae_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `ae_setting` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-28 18:57:26
