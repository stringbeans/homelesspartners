# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: hpdev.cxwpqx7h40ct.us-west-2.rds.amazonaws.com (MySQL 5.6.13-log)
# Database: hpdev
# Generation Time: 2013-11-28 04:49:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `city_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` int(11) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mapped` tinyint(1) NOT NULL DEFAULT '1',
  `img_link_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `region_id` (`region_id`),
  CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`city_id`, `region_id`, `name`, `enabled`, `img`, `mapped`, `img_link_url`)
VALUES
	(1,1,'Calgary',0,'/uploads/city/556067_10151741215340008_829692973_n.jpg',1,'http://www.google.ca'),
	(4,2,'Vancouver',1,'imgs/4_vancouverbanner.jpg',1,NULL),
	(7,3,'Regina',1,'imgs/regina.PNG',1,NULL),
	(13,2,'Kelowna',1,'imgs/gift-icon.gif',1,NULL),
	(18,2,'Victoria',1,'imgs/victoria_logo.JPG',1,NULL),
	(20,2,'Vernon',1,'imgs/Vernon.jpg',1,NULL);

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table city_contributors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_contributors`;

CREATE TABLE `city_contributors` (
  `city_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `city_contributors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table city_coordinators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_coordinators`;

CREATE TABLE `city_coordinators` (
  `city_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `city_coordinators_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `city_coordinators_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city_coordinators` WRITE;
/*!40000 ALTER TABLE `city_coordinators` DISABLE KEYS */;

INSERT INTO `city_coordinators` (`city_id`, `user_id`)
VALUES
	(1,4443),
	(4,4443),
	(18,4452);

/*!40000 ALTER TABLE `city_coordinators` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `country_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;

INSERT INTO `country` (`country_id`, `name`)
VALUES
	(1,'Canada');

/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gifts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gifts`;

CREATE TABLE `gifts` (
  `gift_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` int(11) unsigned NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gift_id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `gifts_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`story_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pledges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pledges`;

CREATE TABLE `pledges` (
  `pledge_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gift_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` enum('pledged','droppedoff','received') NOT NULL DEFAULT 'pledged',
  `estimated_delivery_date` datetime DEFAULT NULL,
  `message` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`pledge_id`),
  KEY `gift_id` (`gift_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `pledges_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `pledges_ibfk_1` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`gift_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region` (
  `region_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`region_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `region_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;

INSERT INTO `region` (`region_id`, `country_id`, `name`)
VALUES
	(1,1,'Alberta'),
	(2,1,'British Columbia'),
	(3,1,'Saskatchewan');

/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shelter_contributors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shelter_contributors`;

CREATE TABLE `shelter_contributors` (
  `shelter_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`shelter_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `shelter_contributors_ibfk_1` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`shelter_id`) ON DELETE CASCADE,
  CONSTRAINT `shelter_contributors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shelter_coordinators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shelter_coordinators`;

CREATE TABLE `shelter_coordinators` (
  `shelter_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`shelter_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `shelter_coordinators_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `shelter_coordinators_ibfk_1` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`shelter_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shelter_coordinators` WRITE;
/*!40000 ALTER TABLE `shelter_coordinators` DISABLE KEYS */;

INSERT INTO `shelter_coordinators` (`shelter_id`, `user_id`)
VALUES
	(34,4437),
	(106,4437);

/*!40000 ALTER TABLE `shelter_coordinators` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shelter_dropoffs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shelter_dropoffs`;

CREATE TABLE `shelter_dropoffs` (
  `dropoff_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shelter_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`dropoff_id`),
  KEY `shelter_id` (`shelter_id`),
  CONSTRAINT `shelter_dropoffs_ibfk_1` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`shelter_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shelters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shelters`;

CREATE TABLE `shelters` (
  `shelter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) unsigned NOT NULL,
  `creator_id` int(11) unsigned NOT NULL,
  `name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `street` varchar(1024) CHARACTER SET latin1 DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `they_do` text CHARACTER SET latin1,
  `they_need` text CHARACTER SET latin1,
  `dropoff_details` text CHARACTER SET latin1,
  `ID_FORMAT` varchar(128) CHARACTER SET latin1 NOT NULL DEFAULT 'test',
  `website` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `mapped` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`shelter_id`),
  KEY `city_id` (`city_id`),
  KEY `creator_id` (`creator_id`),
  CONSTRAINT `shelters_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shelters` WRITE;
/*!40000 ALTER TABLE `shelters` DISABLE KEYS */;

INSERT INTO `shelters` (`shelter_id`, `city_id`, `creator_id`, `name`, `street`, `phone`, `they_do`, `they_need`, `dropoff_details`, `ID_FORMAT`, `website`, `email`, `mapped`, `date_created`, `enabled`, `img`, `bio`)
VALUES
	(34,13,19,'Inn From the Cold - Kelowna','1187 Sutherland Ave, Kelowna BC','250-448-6403','Respond to the needs of people experiencing homelessness in a welcoming, compassionate and mutually respectful manner by providing emergency shelter and comfort to those in need.','Hot chocolate mix; Creamer; Juice; Sugar; Cereals; Jam; canned soup; Canned luncheon meat; Granola bars; Safety razors; Ear plugs; Toilet paper; Toothbrushes; Socks; eye sleep covers, pajamas, cereal, peanut butter, jam, DVD movies, pancakes, eggs','Drop off Monday-Friday between 9-4','YYYYMMDD','www.innfromthecoldkelowna.org/','info@innfromthecoldkelowna.org',1,'0000-00-00 00:00:00',1,NULL,'Respond to the needs of people experiencing homelessness in a welcoming, compassionate and mutually respectful manner by providing emergency shelter and comfort to those in need.\nHot chocolate mix; Creamer; Juice; Sugar; Cereals; Jam; canned soup; Canned luncheon meat; Granola bars; Safety razors; Ear plugs; Toilet paper; Toothbrushes; Socks; eye sleep covers, pajamas, cereal, peanut butter, jam, DVD movies, pancakes, eggs'),
	(36,7,19,'Souls Harbour Rescue Mission','1475 Athol St, Regina, Sk','306-543-0011','To Rescue people from poverty and addiction by offering emergency help, such as food, clothing and shelter, Life Changing Recovery Programs, and the Gospel Message.','http://www.soulsharbourrescuemission.org/about/3-current-wish-list','','Initials and date of birth (MMDDYYYY)','http://www.soulsharbourrescuemission.org','blair@warmwelcome.ca',1,'0000-00-00 00:00:00',1,NULL,'To Rescue people from poverty and addiction by offering emergency help, such as food, clothing and shelter'),
	(39,1,19,'Anawim Christian Community','3733 North Williams, Portland, 97227','503-888-4453','Provide Meals and Care for Homeless Individuals','Gifts Listed Below','Please call Steve Kimes before attempting to deliver gifts. (503-888-4453)','stevekimes@aol.com','anawim.or.us.mennonite.net/','',1,'0000-00-00 00:00:00',0,NULL,'Provide Meals and Care for Homeless Individuals\r\nGifts Listed Below'),
	(42,13,19,'Willowbridge','330 Boyce Crescent, Kelowna BC','(778) 478-0244','Willowbridge is a supportive/transitional housing program for individuals on limited incomes who are at-risk of homelessness and have experienced significant barriers to maintaining long-term housing.','','','YYYYMMDD','http://www.kelowna.cmha.bc.ca/willowbridge','willowbridge@cmha.bc.ca',1,'0000-00-00 00:00:00',1,NULL,'Willowbridge is a supportive/transitional housing program for individuals on limited incomes who are at-risk of homelessness and have experienced significant barriers to maintaining long-term housing.'),
	(43,13,19,'Harmony House & Shiloh House','PO Box 22087 Capri PO, Kelowna, BC, V1Y 9N9','(250) 763-6544','Harmony House & Shiloh House are long-term recovery programs providing support & assistance to women & their children within a safe, secure& structured environment. Programs focus on assisting women in establishing independence, the ability to provide for ','','Gifts can be mailed (address above) or dropped off to Harmony House (office), please call to make arrangements (250) 763-6544.','YYYYMMDD','www.kelownagospelmission.ca/p_s_harmony_house.php','terra@kelownagospelmission.ca',1,'0000-00-00 00:00:00',1,NULL,'Harmony House & Shiloh House are long-term recovery programs providing support & assistance to women & their children within a safe, secure& structured environment. Programs focus on assisting women in establishing independence, the ability to provide for '),
	(62,7,691,'Salvation Army','2240 13th Ave','N/A','Thursday morning lunch program where they provide a warm meal and a time to hang out visit in a safe environment.','N/A','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 12PM, December 23rd.','test','N/A','N/A',1,'2009-11-15 22:02:47',0,NULL,'Thursday morning lunch program where they provide a warm meal and a time to hang out visit in a safe environment.\nN/A'),
	(66,18,1638,'Next Steps Transitional Shelter','2317 Dowler Place','','Provides an opportunity for 15 emergency shelter clients to access the resources and services they need to get their lives back on track.','','Please drop off all gifts at the Rock Bay Landing shelter, 535 Ellice Street, Victoria (250-383-1951, jconnolly@coolaid.org), open 24 hours a day.   Just let them know that it is for Homeless Partners.  If necessary, a back up drop off location is the Shelbourne Street Church of Christ, 3460 Shelbourne Street, Victoria (call 250-592-4914 for office hours).  We need all gifts by noon on December 22nd at the latest.  Please ensure gifts are labeled with the Assigned ID (that is posted with that individual)','test','http://www.coolaid.org/index.php?option=com_content&task=view&id=73&Itemid=237','secretary@shelbournestreet.com',1,'2009-11-18 23:52:15',1,NULL,'Provides an opportunity for 15 emergency shelter clients to access the resources and services they need to get their lives back on track.'),
	(67,7,691,'Souls Harbour Mens Lifechange Campus','3535 8th Ave','306-543-0011','his program is for anyone suffering from life controlling problems such as drug or alcohol abuse, joblessness, homelessness, mental illness, emotional breakdown, gambling, etc. This is a long term program that is designed to gradually help people work thei','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 4PM, December 23rd.','test','www.soulsharbourrescuemission.org','rescue@soulsharbourrescuemission.org',1,'2009-11-19 20:16:27',0,NULL,'his program is for anyone suffering from life controlling problems such as drug or alcohol abuse, joblessness, homelessness, mental illness, emotional breakdown, gambling, etc. This is a long term program that is designed to gradually help people work thei'),
	(68,7,691,'Souls Harbour Womens Lifechange Campus','3535 8th Ave','306-543-0011','This program is for anyone suffering from life controlling problems such as drug or alcohol abuse, joblessness, homelessness, mental illness, emotional breakdown, gambling, etc. This is a long term program that is designed to gradually help people work the','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 4PM, December 23rd.','test','www.soulsharbourrescuemission.org','rescue@soulsharbourrescuemission.org',1,'2009-11-19 20:17:40',0,NULL,'This program is for anyone suffering from life controlling problems such as drug or alcohol abuse, joblessness, homelessness, mental illness, emotional breakdown, gambling, etc. This is a long term program that is designed to gradually help people work the'),
	(69,7,691,'Souls Harbour Mens Emergency Shelter','3356 Stn Main, Regina, SK S4P 3H1','306-543-0011','Provides emergency shelter for men on a short-term basis','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 4PM, December 23rd.','test','www.soulsharbourrescuemission.org','rescue@soulsharbourrescuemission.org',1,'2009-11-19 20:19:30',0,NULL,'Provides emergency shelter for men on a short-term basis'),
	(70,7,691,'Souls Harbour Womens Emergency Shelter','3356 Stn Main, Regina, SK S4P 3H1 ','306-543-0011','Provides emergency shelter for women on a short-term basis','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 4PM, December 23rd.','test','www.soulsharbourrescuemission.org','rescue@soulsharbourrescuemission.org',1,'2009-11-19 20:20:15',0,NULL,'Provides emergency shelter for women on a short-term basis'),
	(71,4,1646,'Yukon Housing Centre - Vancouver','2088 Yukon Street, Vancouver','604-264-1680','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 2088 Yukon Street, Vancouver with the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.bc.ca','',1,'2009-12-01 02:37:46',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(72,4,1646,'Cliff Block - New Westminster','606 Clarkson Street, New Westminster','604-523-9126','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 606 Clarkson Street, New Westminster with the following: -gift labeled with first name and last initial/assigned id -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.bc.ca','',1,'2009-12-01 05:28:46',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(73,4,1646,'Living Room Drop-in - Vancouver','528 Powell Street, Vancouver','604-255-7026','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 528 Powell Street, Vancouver with the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.bc.ca','',1,'2009-12-01 05:38:41',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(74,4,1646,'North Shore Housing Centre','705 West 2nd Street, North Vancouver','604-982-9126','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 705 West 2nd Street, North Vancouver with the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.bc.ca','',1,'2009-12-01 05:39:59',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(75,4,1646,'Hyland House - Cloverdale','17910 Colebrook Road, Cloverdale','604-574-4341','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please have the following:   -gift labeled with first name and last initial/assigned id   -what the item is on the back of the gift tag   -separate any personal letters or notes.  DROP OFF LOCATION: 6595 King George Hwy (Surrey)','test','www.options.bc.ca','',1,'2009-12-01 05:48:38',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(76,4,1646,'Hyland House - Surrey','6595 King George Hwy, Surrey','604-599-8900','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 6595 King George Hwy, Surrey with the following:   -gift labeled with first name and last initial/assigned id    -what the item is on the back of the gift tag   -separate any personal letters or notes.','test','www.options.bc.ca','',1,'2009-12-01 05:51:20',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(80,20,1681,'Vernon and District Women','Gateway Shelter for Women, 2800 33rd Street, Vernon, BC V1T 5S5','250-260-2786','The Gateway shelter provides a bed, lockers, showers and laundry for the homeless. Casemanagement is available to assist individuals in  getting housing, employment, counselling, mental health and other resources in the community. ','the shelter is in needs of razors, soaps, shampoos, conditioners, socks, underclothing, and feminine hygiene products.','Gifts can be mailed or dropped off to Women','test','','',1,'2009-12-06 14:34:25',0,NULL,'The Gateway shelter provides a bed, lockers, showers and laundry for the homeless. Casemanagement is available to assist individuals in  getting housing, employment, counselling, mental health and other resources in the community. \nthe shelter is in needs of razors, soaps, shampoos, conditioners, socks, underclothing, and feminine hygiene products.'),
	(82,13,723,'Cardington Apartments','1436 St. Paul Street, Kelowna, BC, V1Y 2E6','(778) 436-9476','A project of the John Howard Society, the apartment building is a supportive housing development for adult men and women who are homeless or at risk of homelessness and working toward managing mental health and addictions issues. ','Bed linens for single beds; Towels; Pillows','Gifts will be handed out on December 21st, however later gifts will still be accepted.  Items can be mailed or delivered to building.','test','http://jhscso.bc.ca/services/cardington.html','',1,'2009-12-06 19:26:09',1,NULL,'A project of the John Howard Society, the apartment building is a supportive housing development for adult men and women who are homeless or at risk of homelessness and working toward managing mental health and addictions issues. \nBed linens for single beds; Towels; Pillows'),
	(87,20,19,'John Howard Society of North Okanagan/Kootenay','Gateway Shelter for Men, 2800 33rd Street, Vernon, BC V1T 5S5','250 260-2792','','','Gifts can be mailed or dropped off to the Gateway. Please call to make arrangements.','test','','',1,'2009-12-07 23:38:10',0,NULL,''),
	(88,20,19,'DJohn Howard Society  of North Okanagan/Kootenay','Men\'s Shelter 2306 43 Street, Vernon, BC V1T 6K7','250 542-4041','','','Gifts can be mailed or dropped off to the Gateway. Please call to make arrangements.','test','','',1,'2009-12-07 23:39:09',0,NULL,''),
	(90,18,1638,'Rock Bay Landing','535 Ellice Street','','Rock Bay Landing provides the very basic of needs to Victoriaâ€™s downtown street-entrenched populations: shelter, food and hygiene. It also provides transitional housing and has two units of family shelter.','','Please drop off all gifts at the Rock Bay Landing shelter, 535 Ellice Street, Victoria (250-383-1951, jconnolly@coolaid.org), open 24 hours a day.   Just let them know that it is for Homeless Partners.  If necessary, a back up drop off location is the Shelbourne Street Church of Christ, 3460 Shelbourne Street, Victoria (call 250-592-4914 for office hours).  We need all gifts by noon on December 22nd at the latest.  Please ensure gifts are labeled with the Assigned ID (that is posted with that individual)','test','http://www.coolaid.org/index.php?option=com_content&task=view&id=130&Itemid=197','secretary@shelbournestreet.com',1,'2009-12-14 23:39:09',1,NULL,'Rock Bay Landing provides the very basic of needs to Victoriaâ€™s downtown street-entrenched populations: shelter, food and hygiene. It also provides transitional housing and has two units of family shelter.'),
	(91,18,1638,'Sandy Merriman House','809 Burdett Ave','','The program provides 25 shelter beds for women, meals, basic needs, crisis intervention, counseling, referrals, medication and general support. It is open throughout the day for drop-in services and for shelter stays of up to 30 days.','','Please drop off all gifts at the Rock Bay Landing shelter, 535 Ellice Street, Victoria (250-383-1951, jconnolly@coolaid.org), open 24 hours a day.   Just let them know that it is for Homeless Partners.  If necessary, a back up drop off location is the Shelbourne Street Church of Christ, 3460 Shelbourne Street, Victoria (call 250-592-4914 for office hours).  We need all gifts by December 22nd at the latest.  Please ensure gifts are labeled with the Assigned ID (that is posted with that individual)','test','http://www.coolaid.org/index.php?option=com_content&task=view&id=72&Itemid=236','secretary@shelbournestreet.com',1,'2009-12-15 00:12:22',1,NULL,'The program provides 25 shelter beds for women, meals, basic needs, crisis intervention, counseling, referrals, medication and general support. It is open throughout the day for drop-in services and for shelter stays of up to 30 days.'),
	(92,4,1646,'Walton Hotel - Vancouver','261 East Hastings Street, Vancouver','604-688-9129','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please have the following:   -gift labeled with first name and last initial    -what the item is on the back of the gift tag   -separate any personal letters or notes.   ','test','www.lookoutsociety.bc.ca','',0,'2010-11-29 19:24:11',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(93,7,691,'Little Souls Daycare','1475 Athol St','','Little Souls Daycare provides  child care in North Central Regina so parents can rejoin the workforce without spending so much money on daycare.','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 12PM, December 16th.','test','http://www.soulsharbourrescuemission.org/wordpress/daycare/','',0,'2010-12-01 19:50:45',0,NULL,'Little Souls Daycare provides  child care in North Central Regina so parents can rejoin the workforce without spending so much money on daycare.'),
	(95,4,1646,'The Russell - New Westminster','740 Carnavon Street, New Westminster','604-529-9126','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please have the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.ca','',0,'2010-12-08 03:38:48',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(96,20,1690,'Gateway Emergency Shelter','','250-938-9558','provide emergency shelter and assist in finding housing, employment, advocacy and referrals to other community resources ','','Due to limited space, gifts are to be dropped off at the John Howard House on 2307 43 Street Vernon. Gifts will be transported to Gateway on Christmas Eve','test','','al_sonic@hotmail.com',0,'2010-12-10 05:50:29',1,NULL,'provide emergency shelter and assist in finding housing, employment, advocacy and referrals to other community resources '),
	(98,7,691,'Gentle Road Church of Christ','','','Gentle Road is a church plant in North Central Regina. They seek to serve people in this community through bible studies, addictions workshops, and supporting children through \"The Party\", a weekly children','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Email blair@warmwelcome.ca if you have any further questions. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that gifts must be new! All gifts must be dropped off by 4PM, December 21st.','test','http://www.missionalive.org/index.php?option=com_content&view=article&id=310&Itemid=133','kvancester@gmail.com',0,'2011-11-22 20:57:43',1,NULL,'Gentle Road is a church plant in North Central Regina. They seek to serve people in this community through bible studies, addictions workshops, and supporting children through \"The Party\", a weekly children'),
	(100,4,1646,'La Boussole - Vancouver','612 East Broadway, Vancouver','604-683-7337','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please have the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lbv.ca','',0,'2011-11-23 02:18:40',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.'),
	(101,13,3416,'Bedford Place','1043 Harvey Avenue, Kelowna BC','250 717-0702','A ten bed supportive recovery home for men recovering from substance abuse and addiction.','','','test','http://www.jhscso.bc.ca/bedford_place.html','info@jhscso.bc.ca',0,'2011-12-10 21:06:58',1,NULL,'A ten bed supportive recovery home for men recovering from substance abuse and addiction.'),
	(102,20,1690,'John Howard Society Men','2307 43rd street, Vernon, BC V1T 6K7','250-542-4041','provide shelter, meals, showers and laundry. Employment programs, Alcohol and Drug program, outreach, housing, transition housing, life skills training, general support.','the ','please drop off gifts at shelter with the person','test','http://www.jhsnok.ca/contactus.html','alison.houweling@jhsnok.ca',0,'2011-12-13 00:32:11',1,NULL,'provide shelter, meals, showers and laundry. Employment programs, Alcohol and Drug program, outreach, housing, transition housing, life skills training, general support.\nthe '),
	(103,13,3416,'Gateway','1440 St. Paul Street','250-763-1331','Gateway Mentoring Program is designed to provide one-to-one mentorship to those who have, or are highly suspected of having FASD (Fetal Alcohol Spectrum Disorder) and are involved in or at risk of involvement in the Criminal Justice System.','','','test','http://www.jhscso.bc.ca/','',0,'2011-12-15 20:44:07',1,NULL,'Gateway Mentoring Program is designed to provide one-to-one mentorship to those who have, or are highly suspected of having FASD (Fetal Alcohol Spectrum Disorder) and are involved in or at risk of involvement in the Criminal Justice System.'),
	(104,7,691,'Good News Chapel','','','Inner city church serving North Central Regina.','','Gifts can be delivered to: Glen Elm Church of Christ 1825 Rothwell St. Regina, Sk S4N 2C3 between the hours of 9 AM & 4 PM, Monday to Friday. Call 757-1825 before you come to ensure someone is at the building. Be sure to write the persons name and ID on the outside of gift wrapping! Please remember that ALL gifts must be new! All gifts must be dropped off by Friday, Dec 21st @ 4PM. Email blair@warmwelcome.ca if you have any further questions.','test','','',0,'2012-11-16 00:02:55',1,NULL,'Inner city church serving North Central Regina.'),
	(106,4,1646,'Rhoda Kaellis Residence - New Westminster','1105 Royal Avenue, New Westminster','604-544-5145','','Donations are a simple way to have direct impact in the life of someone who is homeless.','Please drop off at 1105 Royal Avenue, New Westminster with the following: -gift labeled with first name and last initial -what the item is on the back of the gift tag -separate any personal letters or notes.','test','www.lookoutsociety.ca','',0,'2012-11-25 01:36:20',1,NULL,'Donations are a simple way to have direct impact in the life of someone who is homeless.');

/*!40000 ALTER TABLE `shelters` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories`;

CREATE TABLE `stories` (
  `story_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shelter_id` int(11) unsigned NOT NULL,
  `creator_id` int(11) unsigned NOT NULL,
  `fname` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `lname` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `gender` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `assigned_id` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `story` text CHARACTER SET latin1,
  `display_order` int(11) unsigned NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`story_id`),
  KEY `creator_id` (`creator_id`),
  KEY `shelter_id` (`shelter_id`),
  CONSTRAINT `stories_ibfk_2` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`shelter_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `pw` varchar(16) CHARACTER SET latin1 NOT NULL,
  `role_old` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `role_new` enum('admin','city','shelter','user','contributor') CHARACTER SET latin1 NOT NULL DEFAULT 'user',
  `role` enum('admin','city','shelter','user','contributor') CHARACTER SET latin1 NOT NULL DEFAULT 'user',
  `name` varchar(255) DEFAULT '',
  `reset_key` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uid` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `email`, `pw`, `role_old`, `date_created`, `enabled`, `role_new`, `role`, `name`, `reset_key`)
VALUES
	(18,'ashbygreg@yahoo.com','123','0','0000-00-00 00:00:00',1,'user','user','',''),
	(19,'jenniek@uniserve.com','counsellor','5','0000-00-00 00:00:00',1,'admin','admin','',''),
	(690,'cindydavis43@hotmail.com','stella','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(691,'blair@warmwelcome.ca','glenelmcofc','5','2009-11-18 05:30:56',1,'city','city','',''),
	(692,'christmaswishs01@yahoo.com','tassls','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(696,'asantanachildren@aol.com','miami','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(697,'gobruce2000@yahoo.com','denver','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(698,'rclark@agapecoc.com ','portland','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(700,'office@agapecoc.com','agape','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(704,'info@calgarycofc.com','brandim','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(705,'melindahughes.pac@gmail.com','boise','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(707,'lynne.davies@cnrl.com','calgarycofc1','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(708,'judy.mooney@telus.net','calgarycofc2','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(709,'linda.aasen@shaw.ca','calgarycofc3','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(710,'lubar@shaw.ca','calgarycofc4','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(711,'raeofsunlight@shaw.ca','calgarycofc5','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(712,'sholland1004@hotmail.com','calgarycofc6','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(713,'bthansen@shaw.ca','calgarycofc7','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(714,'sheri@wiseones.net','calgarycofc8','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(715,'tmharkness@telus.net','calgarycofc9','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(716,'rippen@telusplanet.net','calgarycofc10','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(717,'carissa_k4@hotmail.com','calgarycofc11','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(718,'sylviawamuchefya@yahoo.ca','HolyHoly','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(719,'vjarvie@hotmail.com','calgarycofc13','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(720,'christine.bailey@shaw.ca','calgarycofc14','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(721,'nickelk@fsd.ab.ca','calgarycofc15','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(723,'bananarants@gmail.com','kelowna','5','0000-00-00 00:00:00',1,'city','city','',''),
	(725,'gerri.ashby@fhr.com','calgarycofc16','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(726,'g0ud@telus.net','calgarycofc17','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(727,'dhpawlak@shaw.ca','calgarycofc18','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(728,'nickelk@fsd38.ab.ca','calgarycofc15','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(731,'sharonc.christmas@gmail.com','1234','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(753,'tanys_klaeboe@yahoo.ca','vancouver','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(772,'pgrant@sfu.ca','vancouver','2','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(781,'pvdrem@telus.net','a5a15432','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(783,'quilterlimb@aol.com','calgarycofc19','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(881,'cindi@shayinvitations.com','achieve1','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(882,'stampinron@gmail.com','boise','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(885,'jonishepherdson@gmail.com','boise','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(919,'mcho03@hotmail.com','vancouver','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(1020,'lovebutterfly101@yahoo.com','tassls','5','0000-00-00 00:00:00',1,'city','city','',''),
	(1510,'joel@pittet.ca','linux272','1','0000-00-00 00:00:00',1,'contributor','contributor','',''),
	(1631,'homelesspartners@yahoo.com','wishes09','5','0000-00-00 00:00:00',1,'city','city','',''),
	(1633,'homelesspartnerskelowna@gmail.com','kelowna','2','2009-11-12 19:25:37',1,'contributor','contributor','',''),
	(1636,'carinawarner@gmail.com','mcallen','5','2009-11-17 00:08:39',1,'city','city','',''),
	(1637,'jessicamariesanchez@gmail.com','mcallen','1','2009-11-17 00:40:25',1,'contributor','contributor','',''),
	(1638,'secretary@shelbournestreet.com','victoria','5','2009-11-17 23:08:00',1,'city','city','',''),
	(1639,'vwcalison@uniserve.com','Vernon','1','2009-11-17 23:56:23',1,'contributor','contributor','',''),
	(1644,'jbmooney@shaw.ca','calgary','5','2009-11-23 17:19:55',1,'city','city','',''),
	(1645,'dnieto@agapecoc.com','portland','5','2009-11-23 17:23:50',1,'city','city','',''),
	(1646,'ptgrant@shaw.ca','vancouver','5','2009-11-23 17:24:36',1,'city','city','',''),
	(1647,'vwalison@uniserve.com','vernon','5','2009-11-23 17:25:28',1,'city','city','',''),
	(1657,'patsyjean.roberts@comcast.net','portland','5','2009-11-29 23:54:12',1,'city','city','',''),
	(1681,'ec4252@charter.net','stlouis','5','2009-12-03 21:20:04',1,'city','city','',''),
	(1682,'geoengineer@charter.net','stlouis','5','2009-12-03 21:20:21',1,'city','city','',''),
	(1690,'al_sonic@hotmail.com','vernon','5','2009-12-06 00:51:57',1,'city','city','',''),
	(1696,'agapecoc@comcast.net','portland','5','2009-12-06 22:47:12',1,'city','city','',''),
	(1831,'ben.cook1976@gmail.com','portland','5','2009-12-10 18:22:04',1,'city','city','',''),
	(1873,'typist1calgary@gmail.com','calgary','2','2009-12-11 22:31:55',1,'contributor','contributor','',''),
	(1874,'typist2calgary@gmail.com','calgary','2','2009-12-11 22:32:31',1,'contributor','contributor','',''),
	(1875,'typist3calgary@gmail.com','calgary','2','2009-12-11 22:32:59',1,'contributor','contributor','',''),
	(1876,'typist4calgary@gmail.com','calgary','2','2009-12-11 22:33:34',1,'contributor','contributor','',''),
	(1877,'typist5calgary@gmail.com','calgary','2','2009-12-11 22:34:00',1,'contributor','contributor','',''),
	(1902,'jsa11344@yahoo.com','lasvegas','5','2009-12-12 19:30:36',1,'city','city','',''),
	(2589,'Christmaswisho1@yahoo','dallas','5','2010-11-12 18:33:19',1,'city','contributor','',''),
	(2594,'evcarr@buckman.com','stlouis','5','2010-11-16 19:53:43',1,'city','city','',''),
	(2670,'phori29@gmail.com','losangeles','5','2010-12-02 23:17:49',1,'city','city','',''),
	(3407,'abigail.marie1982@gmail.com','stlouis','5','2011-12-03 19:00:04',1,'city','city','',''),
	(3412,'brianandcrystalm@gmail.com','victoria','5','2011-12-04 04:56:12',1,'city','city','',''),
	(3416,'rileyporritt@gmail.com','kelowna','5','2011-12-04 22:14:47',1,'city','city','',''),
	(3434,'erin_st_jean@yahoo.com','vancouver','5','2011-12-07 18:07:30',1,'city','city','',''),
	(4437,'davemeikle@ymail.com','test','0','0000-00-00 00:00:00',1,'shelter','shelter','',''),
	(4443,'jkor@eslexplorer.com','password','','2013-11-24 20:44:12',1,'user','admin','',''),
	(4444,'ryan.gerrard@gmail.com','testtest','','2013-11-24 22:41:45',1,'user','admin','',''),
	(4445,'aastfalk@gmail.com','test','','2013-11-25 01:45:11',1,'user','admin','',''),
	(4446,'aastfalk+2@gmail.com','test','','2013-11-25 02:41:49',1,'user','user','',''),
	(4447,'aastfalk+3@gmail.com','test','','2013-11-25 03:21:27',1,'user','user','',''),
	(4448,'kennywgrant@gmail.com','password','','2013-11-25 04:53:17',1,'user','admin','',''),
	(4449,'testing@hull.com','890','','2013-11-26 11:59:34',1,'user','shelter','',''),
	(4450,'andre.liem@gmail.com','invoke123','','2013-11-26 19:30:17',1,'user','admin','',''),
	(4451,'mikemartin604@gmail.com','mikemartin604','','2013-11-26 21:16:57',1,'user','admin','',''),
	(4452,'jennie@homelesspartners.com','launchmonday','','2013-11-28 00:09:51',1,'user','city','','');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
