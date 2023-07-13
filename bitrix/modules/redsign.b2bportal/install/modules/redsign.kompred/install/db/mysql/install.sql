CREATE TABLE IF NOT EXISTS `redsign_kompred_offer` (
	`ID` int NOT NULL auto_increment,
	`USER_ID` int NOT NULL,
	`CODE` varchar(255) NOT NULL,
	`SITE_ID` varchar(255) NOT NULL,
	`NAME` varchar(255) NOT NULL,
	`DATE_CREATED` datetime NOT NULL,
	`DATE_UPDATED` datetime NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `redsign_kompred_property` (
	`ID` int NOT NULL auto_increment,
	`OFFER_ID` int NOT NULL,
	`CODE` varchar(255) NOT NULL,
	`NAME` varchar(255) NOT NULL,
	`VALUE` text NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `redsign_kompred_product` (
	`ID` int NOT NULL auto_increment,
	`OFFER_ID` int NOT NULL,
	`PRODUCT_ID` int NOT NULL,
	`NAME` varchar(255) NOT NULL,
	`QUANTITY` double NOT NULL,
	`PRICE` decimal(18,2) NOT NULL,
	`CURRENCY` char(3) NOT NULL,
	`MEASURE` int NULL,
	`RATIO` DOUBLE NOT NULL DEFAULT '1',
	PRIMARY KEY (`ID`)
);

CREATE TABLE `redsign_kompred_offer_structure` (
  `ID` int(11) NOT NULL auto_increment,
  `OFFER_ID` int(11) NOT NULL,
  `STRUCTURE` text NOT NULL,
  PRIMARY KEY (`ID`)
);


CREATE TABLE `redsign_kompred_short_link` (
  `ID` int(11) NOT NULL auto_increment,
  `OFFER_ID` int(11) NOT NULL,
  `FULL_URI` varchar(255) NOT NULL,
  `SHORT_URI` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
);