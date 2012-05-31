# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: d2556579.dotcloud.com (MySQL 5.1.41-3ubuntu12.10-log)
# Database: ci_myuser
# Generation Time: 2012-05-31 13:16:48 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attacks
# ------------------------------------------------------------

CREATE TABLE `attacks` (
  `atk_id` varchar(48) NOT NULL,
  `atk_attacker` int(11) NOT NULL,
  `atk_defender` int(11) NOT NULL,
  `atk_start_time` varchar(50) NOT NULL,
  `atk_end_time` varchar(50) NOT NULL,
  `atk_winner` int(11) NOT NULL,
  `atk_log` blob NOT NULL,
  `atk_stats` blob,
  UNIQUE KEY `atk_id` (`atk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cache
# ------------------------------------------------------------

CREATE TABLE `cache` (
  `cache_item` varchar(15) NOT NULL DEFAULT '',
  `cache_value` varchar(80) NOT NULL DEFAULT '',
  UNIQUE KEY `cache_item` (`cache_item`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;

INSERT INTO `cache` (`cache_item`, `cache_value`)
VALUES
	('hospital_count','0'),
	('jail_count','0'),
	('sync','1338468292'),
	('sync_day','1338397254'),
	('lottery_jackpot','5552018'),
	('sync_lottery','1338704808'),
	('lottery_winners','a:2:{s:7:\"winners\";a:0:{}s:6:\"amount\";s:7:\"5331120\";}'),
	('sync_stock','1338469012');

/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contactlist
# ------------------------------------------------------------

CREATE TABLE `contactlist` (
  `cl_ID` int(11) NOT NULL AUTO_INCREMENT,
  `cl_ADDER` int(11) NOT NULL DEFAULT '0',
  `cl_ADDED` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cl_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table coursesdone
# ------------------------------------------------------------

CREATE TABLE `coursesdone` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `courseid` int(11) NOT NULL DEFAULT '0',
  KEY `uniqueEntry` (`userid`,`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table crimes
# ------------------------------------------------------------

CREATE TABLE `crimes` (
  `crimeID` int(11) NOT NULL AUTO_INCREMENT,
  `crimeNAME` varchar(255) NOT NULL DEFAULT '',
  `crimeBRAVE` int(11) NOT NULL DEFAULT '0',
  `crimePERCFORM` text NOT NULL,
  `crimeSUCCESSMUNY` int(11) NOT NULL DEFAULT '0',
  `crimeSUCCESSCRYS` int(11) NOT NULL DEFAULT '0',
  `crimeSUCCESSITEM` int(11) NOT NULL DEFAULT '0',
  `crimeGROUP` int(11) NOT NULL DEFAULT '0',
  `crimeITEXT` text NOT NULL,
  `crimeSTEXT` text NOT NULL,
  `crimeFTEXT` text NOT NULL,
  `crimeJTEXT` text NOT NULL,
  `crimeJAILTIME` int(10) NOT NULL DEFAULT '0',
  `crimeJREASON` varchar(255) NOT NULL DEFAULT '',
  `crimeXP` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`crimeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `crimes` WRITE;
/*!40000 ALTER TABLE `crimes` DISABLE KEYS */;

INSERT INTO `crimes` (`crimeID`, `crimeNAME`, `crimeBRAVE`, `crimePERCFORM`, `crimeSUCCESSMUNY`, `crimeSUCCESSCRYS`, `crimeSUCCESSITEM`, `crimeGROUP`, `crimeITEXT`, `crimeSTEXT`, `crimeFTEXT`, `crimeJTEXT`, `crimeJAILTIME`, `crimeJREASON`, `crimeXP`)
VALUES
	(1,'Rob an old lady',1,'((WILL*0.8)/2.5)+(LEVEL/4)',5,0,0,1,'You walk up to an old lady passing the streets and attempt to rob her. She looks away before you try to go close and take a snatch at her bag.','The strap on her bag fell off so you managed to pull the bag, run away into a side street, open the bag and you found $5!','She pulled a pepperspray quickly out of her pocket and sprayed you in your eyes so you ran away.','A cop car turned as soon as you tried to pull the bag, so the cop ran out and managed to pull you to the ground.',3,'Robbing an old lady',10),
	(2,'Search the floor',2,'((WILL*0.9)/2.6)+(LEVEL/4)',12,0,0,1,'You walk up and down the streets to try and find some valuables on the floor.','You found a dropped wallet which contained some useless paper which you threw away and $12 in the back pocket of the wallet.','You found an empty box with nothing inside of it other than empty cans of soda.','The police arrested you because they saw you with possession of an empty gun you found on the floor.',5,'Found possession with a empty old pistol',12),
	(3,'Raid a delivery van',4,'((WILL*0.4)/2.3)+(LEVEL/4)',30,1,0,1,'You walk up and see a delivery van stop outside someone\'s house so you try to get closer to the van without attempting getting caught.','You took a quick look at the van and saw $30 in a box and one gold bar in the left panel which you get and quickly run off without getting caught.','You took a look and found the van full of huge useless items which you were unable to take back, so you slowly exit the van and swiftly walk away.','The delivery van has a security camera which the police used to identify you and arrest you at your house when you attempted to go in there.',6,'Attempted robbery on a delivery van',15),
	(4,'Selling counterfeit DVD\'s',6,'((WILL*0.4)/2.3)+(LEVEL/3)',75,0,0,1,'You begin buying counterfeit DVD\'s from a local anonymous dealer and begin trying to flog them on the streets to any visitors walking by.','You earnt $75 through the DVD\'s as they were hugely popular and sold out extremely fast.','You saw a police van pull over so you quickly ran away without your DVD\'s as the police would have captured you.','One of the buyers of the DVD was an undercover cop that immediately arrested you and sent you to jail.',5,'Attempted to sell counterfeit DVD\'s',23),
	(5,'Mugging a resident',8,'((WILL*0.2)/2.8)+(LEVEL/4.5)',100,0,0,2,'You begin trying to analyse who you will attempt to mug and find a potential target who you secretly try to go behind.','Lucky day! You managed to beat him up successfully and found a cool $100 in his wallet.','He successfully used self-defence and ran away when you tried to attack him.','The person used their kung fu to lock you to the ground and call the police, who came and arrested you for assault.',9,'Attempted to mug an estate resident',30),
	(6,'Search a trashcan',9,'((WILL*0.35)/2.8)+(LEVEL/4.5)',0,1,6,2,'You begin searching the trashcans outside the residential estate one by one.','You didn\'t find any money but saw 1 crystal and a blunt machette.','You didn\'t find anything in the trashcan.','A person caught you searching the trashcans and called the police, who came over and arrested you for trespassing.',10,'Trespassing residential estate grounds',34),
	(7,'Ask locals for money',2,'((WILL*0.14)/2.8)+(LEVEL/1.4)',15,0,0,2,'You begin sitting down and start to kindly beg to locals if they can donate money to help you.','One man was really happy and gave you $15 out of his wallet.','Nobody acknowledged your existence and therefore you did not collect any money.','A policeman walked past and asked you to move, which you refused, and then he arrested you.',5,'Ignoring a police officer',10),
	(8,'Pickpocket a tourist',8,'((WILL*0.4)/2.3)+(LEVEL/4)',150,2,5,1,'You walk up to a foreign tourist and see valuables, and attempt to pickpocket them.','They didn\'t see you, and you managed to get $150, 2 gold and a new york cap!','They saw you, and screamed \'help\' which everyone came so you ran and made a lucky but swift exit.','A police office caught a glimpse of you stealing from him, and walked up to you and arrested you.',8,'Caught pickpocketing a tourist.',18);

/*!40000 ALTER TABLE `crimes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crystalmarket
# ------------------------------------------------------------

CREATE TABLE `crystalmarket` (
  `cmID` int(11) NOT NULL AUTO_INCREMENT,
  `cmQTY` int(11) NOT NULL DEFAULT '0',
  `cmADDER` int(11) NOT NULL DEFAULT '0',
  `cmPRICE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cmID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table emailchanges
# ------------------------------------------------------------

CREATE TABLE `emailchanges` (
  `userid` int(11) NOT NULL,
  `time` varchar(100) NOT NULL,
  `old_email` varchar(120) NOT NULL,
  `new_email` varchar(120) NOT NULL
) ENGINE=ARCHIVE DEFAULT CHARSET=latin1;



# Dump of table events
# ------------------------------------------------------------

CREATE TABLE `events` (
  `evID` int(11) NOT NULL AUTO_INCREMENT,
  `evUSER` int(11) NOT NULL DEFAULT '0',
  `evTIME` int(11) NOT NULL DEFAULT '0',
  `evREAD` int(11) NOT NULL DEFAULT '0',
  `evTEXT` text NOT NULL,
  PRIMARY KEY (`evID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table facebook_user
# ------------------------------------------------------------

CREATE TABLE `facebook_user` (
  `userid` int(11) NOT NULL,
  `fb_access_key` varchar(150) NOT NULL DEFAULT '',
  `fb_user_id` int(11) NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table inventory
# ------------------------------------------------------------

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_itemid` int(11) NOT NULL DEFAULT '0',
  `inv_userid` int(11) NOT NULL DEFAULT '0',
  `inv_qty` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table itemmarket
# ------------------------------------------------------------

CREATE TABLE `itemmarket` (
  `imID` int(11) NOT NULL AUTO_INCREMENT,
  `imITEM` int(11) NOT NULL DEFAULT '0',
  `imADDER` int(11) NOT NULL DEFAULT '0',
  `imPRICE` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `imCURRENCY` enum('money','crystals') NOT NULL DEFAULT 'money',
  PRIMARY KEY (`imID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table items
# ------------------------------------------------------------

CREATE TABLE `items` (
  `itmid` int(11) NOT NULL AUTO_INCREMENT,
  `itmtype` int(3) NOT NULL DEFAULT '0',
  `itmname` varchar(100) NOT NULL DEFAULT '',
  `itmdesc` varchar(200) NOT NULL DEFAULT '',
  `itmbuyprice` decimal(9,2) NOT NULL DEFAULT '0.00',
  `itmsellprice` decimal(9,2) NOT NULL DEFAULT '0.00',
  `itmbuyable` tinyint(1) NOT NULL DEFAULT '0',
  `effect1_on` tinyint(1) NOT NULL DEFAULT '0',
  `effect1` varchar(500) NOT NULL DEFAULT '',
  `effect2_on` tinyint(1) NOT NULL DEFAULT '0',
  `effect2` varchar(500) NOT NULL DEFAULT '',
  `effect3_on` tinyint(1) NOT NULL DEFAULT '0',
  `effect3` varchar(500) NOT NULL DEFAULT '',
  `weapon` int(6) NOT NULL DEFAULT '0',
  `armor` int(6) NOT NULL DEFAULT '0',
  `caught` decimal(3,2) NOT NULL,
  PRIMARY KEY (`itmid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;

INSERT INTO `items` (`itmid`, `itmtype`, `itmname`, `itmdesc`, `itmbuyprice`, `itmsellprice`, `itmbuyable`, `effect1_on`, `effect1`, `effect2_on`, `effect2`, `effect3_on`, `effect3`, `weapon`, `armor`, `caught`)
VALUES
	(3,1,'Butter Knife','A lightweight butter knife from a cutlery set',75.00,20.00,1,0,'',0,'',0,'',2,0,0.10),
	(4,3,'Mini Energy Drink','A small energy drink which refreshes your power.',100.00,25.00,1,1,'a:4:{s:4:\"stat\";s:6:\"energy\";s:3:\"dir\";s:3:\"pos\";s:8:\"inc_type\";s:7:\"percent\";s:10:\"inc_amount\";i:3;}',0,'',0,'',0,0,0.00),
	(5,3,'New York Cap','A collectible cap which is a great way to start your cap collection',25.00,12.00,1,0,'',0,'',0,'',0,0,0.00),
	(6,1,'Blunt Machette','A very popular knife which has been used from a restaurant',120.00,40.00,1,0,'',0,'',0,'',10,0,0.15),
	(7,1,'Pocket Knife','A portable knife with more than 30 different style knives',300.00,130.00,1,0,'',0,'',0,'',18,0,0.03),
	(8,1,'Throwing Knife','A knife with a precision handle to increase accuracy',750.00,200.00,1,0,'',0,'',0,'',25,0,0.32),
	(9,1,'Boot Knife','A knife which can be hidden in the boot to reduce police capture',1400.00,500.00,1,0,'',0,'',0,'',20,0,0.01),
	(10,8,'Skorpion','An old rusty gun used during the Cold War',275.00,90.00,1,0,'',0,'',0,'',25,0,0.04),
	(11,8,'Mini Uzi','A high fire, low clip gun used to attack foes',495.00,305.00,1,0,'',0,'',0,'',40,0,0.10),
	(12,8,'Dual Uzi','A combined implementation of Mini Uzi\'s',1520.00,920.00,1,0,'',0,'',0,'',80,0,0.40),
	(13,8,'PPsh-41','A gun used by the Soviet Union in warzones',2820.00,1020.00,1,0,'',0,'',0,'',100,0,0.23),
	(14,8,'FMG','A gun developed by the US Army in 1986',4920.00,2495.00,1,0,'',0,'',0,'',145,0,0.29),
	(15,8,'Type 100','A gun developed by the Japanese Army in 1960\'s',972.50,410.20,1,0,'',0,'',0,'',30,0,0.09),
	(16,9,'R4','A machine gun often seen used by the Haitian police against civilians',350.00,175.00,1,0,'',0,'',0,'',75,0,0.40),
	(17,9,'Vepr','A gun which has only just been created by the Ukrainian Army',4950.00,3100.00,1,0,'',0,'',0,'',110,0,0.28),
	(18,9,'M16','A common gun which has a huge clip but low damage to opponents',756.15,380.50,1,0,'',0,'',0,'',60,0,0.51),
	(19,9,'FAD','A single fire assault rifle with high accuracy and a low clip',1400.00,600.00,1,0,'',0,'',0,'',90,0,0.18),
	(20,9,'Sterling','A british gun which was never used in the army',3045.90,1950.00,1,0,'',0,'',0,'',60,0,0.11),
	(21,2,'Light Shield','A very lightweight circular shield used to avoid significant damage',1200.00,600.00,1,0,'',0,'',0,'',0,10,0.00),
	(22,3,'Soda can','An awesomely brilliant soda can which can be used to improve your power.',60.00,4.00,1,1,'a:4:{s:4:\"stat\";s:6:\"energy\";s:3:\"dir\";s:3:\"pos\";s:8:\"inc_type\";s:6:\"figure\";s:10:\"inc_amount\";i:1;}',0,'',0,'',0,0,0.00),
	(23,3,'Rusty Flamethrower','A fire weapon with a limited fire tube that can highly damage foes in battle.',48500.99,16400.99,1,0,'',0,'',0,'',200,0,0.01),
	(24,10,'Energy Jab','A small needle that has a little dose of energy to help you pick yourself back up.',1000.00,400.00,1,1,'a:4:{s:4:\"stat\";s:6:\"energy\";s:3:\"dir\";s:3:\"pos\";s:8:\"inc_type\";s:6:\"figure\";s:10:\"inc_amount\";i:12;}',0,'',0,'',0,0,0.01);

/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table jobranks
# ------------------------------------------------------------

CREATE TABLE `jobranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(255) NOT NULL DEFAULT '',
  `rank_job` int(11) NOT NULL DEFAULT '0',
  `rank_wage` decimal(11,2) NOT NULL DEFAULT '0.00',
  `rank_maxhours` int(11) DEFAULT NULL,
  `rank_iqgain` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `rank_labourgain` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `rank_strengthgain` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `rank_iqneed` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `rank_labourneed` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `rank_strengthneed` decimal(11,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `jobranks` WRITE;
/*!40000 ALTER TABLE `jobranks` DISABLE KEYS */;

INSERT INTO `jobranks` (`rank_id`, `rank_name`, `rank_job`, `rank_wage`, `rank_maxhours`, `rank_iqgain`, `rank_labourgain`, `rank_strengthgain`, `rank_iqneed`, `rank_labourneed`, `rank_strengthneed`)
VALUES
	(1,'Trainee',1,6.95,5,0.0050,0.0080,0.0040,10.0000,10.0000,10.0000),
	(2,'Cleaner',1,8.95,8,0.0100,0.0200,0.0140,11.0000,12.0000,12.0000),
	(3,'Barber',1,12.95,10,0.0400,0.0200,0.0800,15.0000,20.0000,20.0000),
	(4,'Manager',1,14.95,24,0.0800,0.1000,0.1100,20.0000,24.0000,22.0000),
	(5,'Boss',1,19.18,30,0.1900,0.2400,0.2000,30.0000,34.0000,50.0000),
	(6,'Shop Assistant',2,19.95,10,0.2300,0.2100,0.3000,50.0000,75.0000,65.0000),
	(7,'Delivery Driver',2,21.19,15,0.4500,0.4300,0.3400,52.0000,62.0000,72.0000),
	(8,'Cashier',2,25.91,20,0.5000,0.4500,0.3900,65.0000,70.0000,81.0000),
	(9,'Assistant Manager',2,29.15,20,0.6000,0.5500,0.4300,70.0000,80.0000,98.0000),
	(10,'Manager',2,33.15,22,0.7000,0.7000,0.7000,90.0000,90.0000,114.0000),
	(11,'Helper',3,14.15,16,0.2600,0.2600,0.2900,30.0000,24.0000,14.0000),
	(12,'Assistant Banker',3,18.29,18,0.4000,0.4200,0.3400,45.0000,29.0000,18.0000),
	(13,'Banker',3,24.19,24,0.4300,0.4500,0.4000,52.0000,34.0000,23.0000),
	(14,'Branch Manager',3,34.29,30,0.7500,0.8500,0.4300,100.0000,60.0000,39.0000),
	(15,'Area Manager',3,49.19,40,1.0500,1.1000,1.1000,110.0000,80.0000,45.0000),
	(18,'Investment Banker',3,120.00,40,2.0000,1.9000,1.6500,150.0000,120.0000,100.0000),
	(19,'Senior Investment Banker',3,165.00,45,3.1900,2.5900,2.0100,280.0000,230.0000,192.0000),
	(16,'Regional Manager',3,56.00,40,0.9100,0.9200,0.5800,116.0000,89.0000,60.0000),
	(20,'Assistant Runner',4,2.95,45,0.0050,0.0800,0.0800,10.5000,15.0000,19.0000),
	(21,'Senior Runner',4,8.95,50,0.0100,0.1600,0.1600,21.0000,24.0000,30.0000),
	(22,'Advisor',4,21.95,30,0.2000,0.2000,0.2000,45.0000,28.0000,34.0000),
	(23,'Costume Designer',4,34.95,40,0.4000,0.2300,0.3100,70.0000,36.0000,39.0000),
	(24,'Assistant Screenwriter',4,49.94,40,0.5500,0.4000,0.4000,95.0000,105.0000,54.0000),
	(25,'Screenwriter',4,65.95,40,0.6000,0.4500,0.4500,110.0000,130.0000,75.0000),
	(26,'Co-Director',4,75.49,40,0.7500,0.5000,0.5000,140.0000,150.0000,90.0000),
	(27,'Producer',4,115.00,50,1.0000,0.7500,0.7500,180.0000,195.0000,110.0000),
	(28,'Director',4,240.00,50,1.4000,1.1000,1.0500,300.0000,250.0000,150.0000);

/*!40000 ALTER TABLE `jobranks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table jobs
# ------------------------------------------------------------

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(255) NOT NULL DEFAULT '',
  `job_first` int(11) NOT NULL DEFAULT '0',
  `job_description` varchar(500) NOT NULL DEFAULT '',
  `job_owner` varchar(255) NOT NULL DEFAULT '',
  `job_wage` decimal(11,2) DEFAULT '2.95',
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;

INSERT INTO `jobs` (`job_id`, `job_name`, `job_first`, `job_description`, `job_owner`, `job_wage`)
VALUES
	(1,'Fresh Joes',1,'One of the most reputable and popular barbers in the area','Joe Stevenson',6.95),
	(2,'Tony\'s Guns',6,'A new gunstore which sells lightweight guns and armor to gangs and groups across the city','Richard',19.95),
	(3,'Local Bank',11,'The local bank which allows people to store their money safely and securely','Mike',14.15),
	(4,'Starfire Studios',20,'A new filming studio opened in the States to fund new, 21st-century films in production','Andre',2.95);

/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lotterytickets
# ------------------------------------------------------------

CREATE TABLE `lotterytickets` (
  `lt_id` int(11) NOT NULL AUTO_INCREMENT,
  `lt_user` int(11) NOT NULL,
  `lt_time` int(11) NOT NULL,
  `lt_num_1` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `lt_num_2` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `lt_num_3` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `lt_num_4` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `lt_num_5` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  PRIMARY KEY (`lt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table mail
# ------------------------------------------------------------

CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_read` int(11) NOT NULL DEFAULT '0',
  `mail_from` int(11) NOT NULL DEFAULT '0',
  `mail_to` int(11) NOT NULL DEFAULT '0',
  `mail_time` int(11) NOT NULL DEFAULT '0',
  `mail_subject` varchar(255) NOT NULL DEFAULT '',
  `mail_text` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table mobile_payments
# ------------------------------------------------------------

CREATE TABLE `mobile_payments` (
  `payment_time` varchar(255) NOT NULL,
  `payment_user` varchar(255) NOT NULL,
  `payment_network` varchar(255) NOT NULL,
  `payment_number` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table online
# ------------------------------------------------------------

CREATE TABLE `online` (
  `userid` int(11) NOT NULL,
  `laston` int(11) NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;



# Dump of table payments
# ------------------------------------------------------------

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_started` varchar(255) NOT NULL,
  `payment_last` varchar(255) NOT NULL,
  `payment_item` varchar(255) NOT NULL,
  `payment_amount` decimal(11,2) NOT NULL,
  `payment_total` decimal(11,2) NOT NULL,
  `payment_user` int(11) NOT NULL,
  `payment_status` enum('successful','cancelled','failed') NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table referrals
# ------------------------------------------------------------

CREATE TABLE `referrals` (
  `ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ref_referer` int(11) NOT NULL,
  `ref_referred` int(11) NOT NULL,
  `ref_time` int(11) NOT NULL,
  `ref_referer_ip` varchar(255) NOT NULL,
  `ref_referred_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table reset_passwords
# ------------------------------------------------------------

CREATE TABLE `reset_passwords` (
  `reset_key` varchar(30) NOT NULL,
  `reset_ip` varchar(75) NOT NULL,
  `reset_user` int(11) NOT NULL,
  `reset_expires` int(11) NOT NULL,
  UNIQUE KEY `reset_key` (`reset_key`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;



# Dump of table shopitems
# ------------------------------------------------------------

CREATE TABLE `shopitems` (
  `sitemID` int(11) NOT NULL AUTO_INCREMENT,
  `sitemSHOP` int(11) NOT NULL DEFAULT '0',
  `sitemITEMID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sitemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `shopitems` WRITE;
/*!40000 ALTER TABLE `shopitems` DISABLE KEYS */;

INSERT INTO `shopitems` (`sitemID`, `sitemSHOP`, `sitemITEMID`)
VALUES
	(1,2,3),
	(2,1,4),
	(3,1,5),
	(4,2,6),
	(5,2,7),
	(6,2,8),
	(7,2,9),
	(8,1,10),
	(9,1,11),
	(10,1,12),
	(11,1,13),
	(12,1,14),
	(13,1,15),
	(14,1,16),
	(15,1,17),
	(16,1,18),
	(17,1,19),
	(18,1,20),
	(19,1,21),
	(20,1,22),
	(21,3,23),
	(22,3,24);

/*!40000 ALTER TABLE `shopitems` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table statistics
# ------------------------------------------------------------

CREATE TABLE `statistics` (
  `userid` int(11) NOT NULL,
  `stat_name` varchar(50) NOT NULL DEFAULT '',
  `stat_value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table stock_holdings
# ------------------------------------------------------------

CREATE TABLE `stock_holdings` (
  `holdingID` bigint(25) NOT NULL AUTO_INCREMENT,
  `holdingUSER` bigint(25) NOT NULL DEFAULT '0',
  `holdingSTOCK` bigint(25) NOT NULL DEFAULT '0',
  `holdingQTY` bigint(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`holdingID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table stock_records
# ------------------------------------------------------------

CREATE TABLE `stock_records` (
  `recordUSER` bigint(25) NOT NULL DEFAULT '0',
  `recordTIME` bigint(25) NOT NULL DEFAULT '0',
  `recordTEXT` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `stock_records` WRITE;
/*!40000 ALTER TABLE `stock_records` DISABLE KEYS */;

INSERT INTO `stock_records` (`recordUSER`, `recordTIME`, `recordTEXT`)
VALUES
	(50,1316871419,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316871802,'support has successfully bought 1 of e-Electronics Productions stock for $300.00'),
	(50,1316872133,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316872151,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316872163,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316872220,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316872225,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316872243,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316907324,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316907500,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316907510,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316910044,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316910053,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316910060,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316911025,'support has successfully bought 4 of Top Gym stock for $416.00'),
	(50,1316911040,'support has successfully bought 5 of Top Gym stock for $520.00'),
	(50,1316911047,'support has successfully bought 1 of Top Gym stock for $104.00'),
	(50,1316911083,'support has successfully bought 1 of Trey\'s Phone Deals stock for $13.00'),
	(50,1316912293,'support has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(1,1316912609,'oxidati0n has successfully bought 10 of May\'s Music Store stock for $1,930.00'),
	(1,1316912619,'oxidati0n has successfully bought 2 of May\'s Music Store stock for $386.00'),
	(1,1316912625,'oxidati0n has successfully bought 4 of May\'s Music Store stock for $772.00'),
	(1,1316912711,'oxidati0n has successfully bought 9 of Trey\'s Phone Deals stock for $531.00'),
	(12,1316912814,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912822,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912824,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912826,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912827,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912829,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912833,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912835,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912837,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316912839,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(1,1316913320,'oxidati0n has successfully bought 1 of Smith\'s Jewellery stock for $3,067.00'),
	(12,1316913594,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913596,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913597,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913599,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913600,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913602,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316913604,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316914204,'JohnGato has successfully bought 1 of May\'s Music Store stock for $103.00'),
	(12,1316914207,'JohnGato has successfully bought 1 of May\'s Music Store stock for $103.00'),
	(12,1316914208,'JohnGato has successfully bought 1 of May\'s Music Store stock for $103.00'),
	(3,1316941121,'dranxz has successfully bought 10 of China\'s Casinos Limited stock for $10,920.00'),
	(3,1316941124,'dranxz has successfully bought 1 of China\'s Casinos Limited stock for $1,092.00'),
	(3,1316942981,'dranxz has successfully bought 100 of May\'s Music Store stock for $1,900.00'),
	(3,1316942993,'dranxz has successfully bought 500 of May\'s Music Store stock for $9,500.00'),
	(3,1316942997,'dranxz has successfully bought 100 of May\'s Music Store stock for $1,900.00'),
	(3,1316943000,'dranxz has successfully bought 100 of May\'s Music Store stock for $1,900.00'),
	(3,1316943005,'dranxz has successfully bought 10 of May\'s Music Store stock for $190.00'),
	(3,1316943016,'dranxz has successfully bought 20 of May\'s Music Store stock for $380.00'),
	(3,1316943022,'dranxz has successfully bought 1 of May\'s Music Store stock for $19.00'),
	(3,1316943027,'dranxz has successfully bought 5 of May\'s Music Store stock for $95.00'),
	(3,1316943031,'dranxz has successfully bought 1 of May\'s Music Store stock for $19.00'),
	(1,1316957033,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957034,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957400,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957401,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957402,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957402,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957403,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957404,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957404,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957406,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957407,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957407,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(1,1316957408,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $311.00'),
	(95,1316957914,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316957915,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958222,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958224,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958225,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958226,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958226,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958392,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958394,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958395,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958395,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958396,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(95,1316958397,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $253.00'),
	(12,1316958985,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958986,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958986,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958986,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958987,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958987,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958987,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958988,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958988,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958989,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958990,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958990,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958990,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958991,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958991,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958991,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958992,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958992,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958992,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958993,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958993,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316958993,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959003,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959004,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959004,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959004,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959005,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959005,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959009,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(12,1316959012,'JohnGato has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959447,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959449,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959451,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959513,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959515,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959515,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959516,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959517,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959518,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959519,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959519,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959520,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959562,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959563,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959564,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959565,'BallisticSmoke has successfully bought 1 of TalkPhone Enterprises stock for $24.00'),
	(95,1316959712,'BallisticSmoke has successfully bought 1 of Top Gym stock for $448.00'),
	(95,1316959713,'BallisticSmoke has successfully bought 1 of Top Gym stock for $448.00'),
	(95,1316959716,'BallisticSmoke has successfully bought 1 of Top Gym stock for $448.00'),
	(19,1316960666,'TheSpirit has successfully bought 1 of Trey\'s Phone Deals stock for $20.00'),
	(84,1316971943,'Elite has successfully bought 460 of TalkPhone Enterprises stock for $45,080.00'),
	(84,1316971952,'Elite has successfully bought 5 of TalkPhone Enterprises stock for $490.00'),
	(84,1316971972,'Elite has successfully bought 4 of TalkPhone Enterprises stock for $392.00'),
	(3,1316977799,'dranxz has successfully bought 10 of Top Gym stock for $2,270.00'),
	(3,1316977831,'dranxz has successfully bought 1 of Top Gym stock for $227.00'),
	(3,1316978632,'dranxz has successfully bought 10 of TalkPhone Enterprises stock for $4,810.00'),
	(84,1316979513,'Elite has successfully bought 2300 of China\'s Casinos Limited stock for $232,300.00'),
	(84,1316979537,'Elite has successfully bought 60 of China\'s Casinos Limited stock for $6,060.00'),
	(84,1316979544,'Elite has successfully bought 10 of China\'s Casinos Limited stock for $1,010.00'),
	(84,1316979566,'Elite has successfully bought 6 of China\'s Casinos Limited stock for $606.00'),
	(84,1316980004,'Elite has successfully bought 7 of China\'s Casinos Limited stock for $707.00'),
	(12,1316984549,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(12,1316984550,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(1,1316996099,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $607.00'),
	(1,1316996100,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $607.00'),
	(1,1316996109,'oxidati0n has successfully bought 3 of TalkPhone Enterprises stock for $1,821.00'),
	(1,1317032776,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(1,1317032778,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(1,1317032778,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(1,1317032779,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(1,1317032780,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(1,1317032781,'oxidati0n has successfully bought 1 of TalkPhone Enterprises stock for $884.00'),
	(95,1317062219,'BallisticSmoke has successfully bought 1 of Trey\'s Phone Deals stock for $825.00'),
	(95,1317062903,'BallisticSmoke has successfully bought 1 of May\'s Music Store stock for $1,566.00'),
	(84,1317140371,'Elite has successfully bought 600 of Trey\'s Phone Deals stock for $40,200.00'),
	(84,1317150023,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150026,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150028,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150029,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150030,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150031,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150032,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150032,'Elite has successfully bought 1 of Trey\'s Phone Deals stock for $-220.00'),
	(84,1317150039,'Elite has successfully bought 5000 of Trey\'s Phone Deals stock for $-1,100,000.00'),
	(84,1317150046,'Elite has successfully bought 5000 of Trey\'s Phone Deals stock for $-1,100,000.00'),
	(84,1317150163,'Elite has successfully bought 5000 of Trey\'s Phone Deals stock for $-2,195,000.00'),
	(84,1317150169,'Elite has successfully bought 10000 of Trey\'s Phone Deals stock for $-4,390,000.00'),
	(84,1317150177,'Elite has successfully bought 15000 of Trey\'s Phone Deals stock for $-6,585,000.00'),
	(84,1317150482,'Elite has successfully bought 10000 of Trey\'s Phone Deals stock for $-4,390,000.00'),
	(3,1317151737,'dranxz has successfully bought 9 of Top Gym stock for $20,241.00'),
	(3,1317152709,'dranxz has successfully bought 8 of May\'s Music Store stock for $19,552.00'),
	(50,1317153858,'support has successfully bought 1 of TalkPhone Enterprises stock for $-407.00'),
	(50,1317153860,'support has successfully bought 1 of TalkPhone Enterprises stock for $-407.00'),
	(50,1317153862,'support has successfully bought 1 of TalkPhone Enterprises stock for $-407.00'),
	(84,1317155402,'Elite has successfully bought 200 of Trey\'s Phone Deals stock for $21,000.00'),
	(3,1317157384,'dranxz has successfully bought 100 of Trey\'s Phone Deals stock for $5,900.00'),
	(3,1317157637,'dranxz has successfully bought 10 of Top Gym stock for $2,290.00'),
	(3,1317157641,'dranxz has successfully bought 8 of Top Gym stock for $1,832.00'),
	(3,1317157649,'dranxz has successfully bought 10 of Top Gym stock for $2,290.00'),
	(3,1317157654,'dranxz has successfully bought 10 of Top Gym stock for $2,290.00'),
	(3,1317157665,'dranxz has successfully bought 9 of Top Gym stock for $2,061.00'),
	(3,1317160691,'dranxz has successfully bought 100 of Trey\'s Phone Deals stock for $5,900.00'),
	(3,1317160704,'dranxz has successfully bought 200 of Trey\'s Phone Deals stock for $11,800.00'),
	(3,1317160720,'dranxz has successfully bought 60 of Trey\'s Phone Deals stock for $3,540.00'),
	(3,1317160725,'dranxz has successfully bought 10 of Trey\'s Phone Deals stock for $590.00'),
	(3,1317160733,'dranxz has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(3,1317160734,'dranxz has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(3,1317160734,'dranxz has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(50,1317163031,'support has successfully bought 1 of May\'s Music Store stock for $26.00'),
	(50,1317163032,'support has successfully bought 1 of May\'s Music Store stock for $26.00'),
	(50,1317163033,'support has successfully bought 1 of May\'s Music Store stock for $26.00'),
	(50,1317163034,'support has successfully bought 1 of May\'s Music Store stock for $26.00'),
	(50,1317163034,'support has successfully bought 1 of May\'s Music Store stock for $26.00'),
	(12,1317164721,'JohnGato has successfully bought 1 of Top Gym stock for $103.00'),
	(12,1317211708,'JohnGato has successfully bought 1 of e-Electronics Productions stock for $50.00'),
	(84,1317227742,'Elite has successfully bought 1000 of Top Gym stock for $103,000.00'),
	(84,1317234415,'Elite has successfully bought 100 of Deliliah\'s Private Schools Ltd stock for $10,000.00'),
	(84,1317234434,'Elite has successfully bought 800 of Deliliah\'s Private Schools Ltd stock for $80,000.00'),
	(84,1317234473,'Elite has successfully bought 99 of Deliliah\'s Private Schools Ltd stock for $9,900.00'),
	(1,1317245204,'oxidati0n has successfully bought 9 of Trey\'s Phone Deals stock for $873.00'),
	(84,1317311358,'Elite has successfully bought 1000 of Top Gym stock for $114,000.00'),
	(84,1317320241,'Elite has successfully bought 1000 of Trey\'s Phone Deals stock for $59,000.00'),
	(95,1317404747,'BallisticSmoke has successfully bought 1 of Deliliah\'s Private Schools Ltd stock for $8.00'),
	(95,1317404751,'BallisticSmoke has successfully bought 30 of Deliliah\'s Private Schools Ltd stock for $240.00'),
	(95,1317404756,'BallisticSmoke has successfully bought 15 of Deliliah\'s Private Schools Ltd stock for $120.00'),
	(95,1317404760,'BallisticSmoke has successfully bought 4 of Deliliah\'s Private Schools Ltd stock for $32.00'),
	(84,1317413310,'Elite has successfully bought 1000 of Top Gym stock for $103,000.00'),
	(84,1317413536,'Elite has successfully bought 2000 of Top Gym stock for $206,000.00'),
	(84,1317468736,'Elite has successfully bought 10 of China\'s Casinos Limited stock for $110.00'),
	(86,1320208678,'elmario has successfully bought 1 of Trey\'s Phone Deals stock for $59.00'),
	(84,1320396861,'Elite has successfully bought 1000 of Trey\'s Phone Deals stock for $59,000.00'),
	(12,1322014772,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $199.00'),
	(12,1322014773,'JohnGato has successfully bought 1 of Trey\'s Phone Deals stock for $199.00'),
	(3,1322586207,'dranxz has successfully bought 10 of Deliliah\'s Private Schools Ltd stock for $20,990.00'),
	(3,1322586214,'dranxz has successfully bought 3 of Deliliah\'s Private Schools Ltd stock for $6,297.00'),
	(104,1325442836,'BlackRipRedJack has successfully bought 2 of Top Gym stock for $412.00'),
	(104,1325442858,'BlackRipRedJack has successfully bought 5 of Trey\'s Phone Deals stock for $295.00');

/*!40000 ALTER TABLE `stock_records` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stock_stocks
# ------------------------------------------------------------

CREATE TABLE `stock_stocks` (
  `stockID` bigint(25) NOT NULL AUTO_INCREMENT,
  `stockNAME` varchar(255) NOT NULL DEFAULT 'Default Stock Name',
  `stockOPRICE` bigint(25) NOT NULL DEFAULT '0',
  `stockNPRICE` bigint(25) NOT NULL DEFAULT '0',
  `stockCHANGE` int(25) NOT NULL DEFAULT '50',
  `stockUD` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`stockID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `stock_stocks` WRITE;
/*!40000 ALTER TABLE `stock_stocks` DISABLE KEYS */;

INSERT INTO `stock_stocks` (`stockID`, `stockNAME`, `stockOPRICE`, `stockNPRICE`, `stockCHANGE`, `stockUD`)
VALUES
	(1,'Top Gym',103,5992,53,1),
	(2,'Smith\'s Jewellery',3040,8840,57,0),
	(3,'China\'s Casinos Limited',1344,9490,59,1),
	(4,'May\'s Music Store',193,10745,61,1),
	(5,'Trey\'s Phone Deals',59,4679,22,1),
	(6,'TalkPhone Enterprises',391,9436,50,0),
	(7,'Deliliah\'s Private Schools Ltd',1933,2420,49,0),
	(8,'e-Electronics Productions',850,6320,57,0);

/*!40000 ALTER TABLE `stock_stocks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tickets
# ------------------------------------------------------------

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_user` int(11) NOT NULL,
  `ticket_ip` int(11) NOT NULL,
  `ticket_time` int(11) NOT NULL,
  `ticket_subject` varchar(150) NOT NULL,
  `ticket_message` blob NOT NULL,
  `ticket_seen` enum('0','1') NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table totalvotes
# ------------------------------------------------------------

CREATE TABLE `totalvotes` (
  `list` varchar(50) NOT NULL,
  `votes` bigint(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table unlock_complete
# ------------------------------------------------------------

CREATE TABLE `unlock_complete` (
  `userid` int(11) NOT NULL,
  `unlock` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table unused-settings
# ------------------------------------------------------------

CREATE TABLE `unused-settings` (
  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_name` varchar(255) NOT NULL DEFAULT '',
  `conf_value` text NOT NULL,
  PRIMARY KEY (`conf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `unused-settings` WRITE;
/*!40000 ALTER TABLE `unused-settings` DISABLE KEYS */;

INSERT INTO `unused-settings` (`conf_id`, `conf_name`, `conf_value`)
VALUES
	(8,'ct_refillprice','12'),
	(9,'ct_iqpercrys','5'),
	(10,'ct_moneypercrys','425'),
	(11,'staff_pad','Here you can store notes for all staff to see.'),
	(12,'willp_item','0'),
	(15,'paypal','bilawal@games.com');

/*!40000 ALTER TABLE `unused-settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table used_txns
# ------------------------------------------------------------

CREATE TABLE `used_txns` (
  `txn_id` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table username_cache
# ------------------------------------------------------------

CREATE TABLE `username_cache` (
  `userid` int(11) NOT NULL,
  `username` varchar(16) NOT NULL DEFAULT '',
  FULLTEXT KEY `username` (`username`),
  FULLTEXT KEY `cache` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table usernotepads
# ------------------------------------------------------------

CREATE TABLE `usernotepads` (
  `userid` int(11) NOT NULL,
  `notepad` text CHARACTER SET latin1 NOT NULL,
  `notepad_updated` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `sessid` varchar(18) NOT NULL DEFAULT '',
  `login_name` varchar(16) NOT NULL DEFAULT '',
  `username` varchar(16) NOT NULL DEFAULT '',
  `userpass` varchar(255) NOT NULL DEFAULT '',
  `pass_salt` varchar(10) NOT NULL DEFAULT '',
  `is_ajax` tinyint(1) DEFAULT NULL,
  `donator` int(11) NOT NULL DEFAULT '0',
  `badges` varchar(500) NOT NULL DEFAULT '',
  `level` int(4) NOT NULL DEFAULT '0',
  `last_upgraded` int(11) NOT NULL DEFAULT '0',
  `exp` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `money` decimal(14,2) NOT NULL DEFAULT '0.00',
  `crystals` int(6) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0',
  `maxenergy` int(11) NOT NULL DEFAULT '0',
  `will` int(11) NOT NULL DEFAULT '0',
  `maxwill` int(11) NOT NULL DEFAULT '0',
  `brave` int(11) NOT NULL DEFAULT '0',
  `maxbrave` int(11) NOT NULL DEFAULT '0',
  `hp` int(11) NOT NULL DEFAULT '0',
  `maxhp` int(11) NOT NULL DEFAULT '0',
  `location` int(11) NOT NULL DEFAULT '0',
  `user_level` int(2) NOT NULL DEFAULT '1',
  `user_duties` varchar(255) NOT NULL DEFAULT 'N/A',
  `lastrest_life` int(11) NOT NULL DEFAULT '0',
  `lastrest_other` int(11) NOT NULL DEFAULT '0',
  `hospital` int(11) NOT NULL DEFAULT '0',
  `hospreason` varchar(255) NOT NULL DEFAULT '',
  `jail` int(11) NOT NULL DEFAULT '0',
  `jail_reason` varchar(255) NOT NULL DEFAULT '',
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `signedup` int(11) NOT NULL DEFAULT '0',
  `gang` int(11) NOT NULL DEFAULT '0',
  `gang_joined` int(11) NOT NULL DEFAULT '0',
  `course` int(11) NOT NULL DEFAULT '0',
  `course_expires` int(11) NOT NULL DEFAULT '0',
  `email` varchar(120) NOT NULL DEFAULT '',
  `display_pic` varchar(40) NOT NULL DEFAULT '',
  `bankmoney` decimal(11,2) NOT NULL DEFAULT '-1.00',
  `bankinterest` decimal(4,2) NOT NULL DEFAULT '0.00',
  `lastip` varchar(255) NOT NULL DEFAULT '',
  `lastip_login` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `lastip_signup` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `crimexp` int(11) NOT NULL DEFAULT '0',
  `attacking` int(11) NOT NULL DEFAULT '0',
  `new_events` int(3) NOT NULL DEFAULT '0',
  `new_mail` int(3) NOT NULL DEFAULT '0',
  `friend_count` int(4) NOT NULL DEFAULT '0',
  `enemy_count` int(4) NOT NULL DEFAULT '0',
  `contact_count` int(4) NOT NULL,
  `equip_primary` int(11) NOT NULL DEFAULT '0',
  `equip_secondary` int(11) NOT NULL DEFAULT '0',
  `equip_armor` int(11) NOT NULL DEFAULT '0',
  `force_logout` tinyint(1) NOT NULL DEFAULT '0',
  `jobrank` int(11) NOT NULL DEFAULT '0',
  `jobwage` decimal(11,2) DEFAULT NULL,
  `joblast` int(11) DEFAULT NULL,
  `is_hp_bonus` int(4) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `sessid` (`sessid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table usersigs
# ------------------------------------------------------------

CREATE TABLE `usersigs` (
  `userid` int(11) NOT NULL,
  `signature` blob NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table userstats
# ------------------------------------------------------------

CREATE TABLE `userstats` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `strength` decimal(8,4) NOT NULL DEFAULT '10.0000',
  `agility` decimal(8,4) NOT NULL DEFAULT '10.0000',
  `guard` decimal(8,4) NOT NULL DEFAULT '10.0000',
  `labour` decimal(8,4) NOT NULL DEFAULT '10.0000',
  `IQ` decimal(8,4) NOT NULL DEFAULT '10.0000',
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table votes
# ------------------------------------------------------------

CREATE TABLE `votes` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `list` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
