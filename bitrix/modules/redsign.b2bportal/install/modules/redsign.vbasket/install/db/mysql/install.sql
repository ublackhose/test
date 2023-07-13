create table if not exists rs_vbasket
(
	`ID` int(11) NOT NULL auto_increment,
	`CODE` varchar(255) NOT NULL,
	`FUSER_ID` int(11) NOT NULL,
	`SITE_ID` varchar(255) NOT NULL,
	`NAME` varchar(255) NOT NULL,
	`COLOR` varchar(255) NOT NULL,
	`DATE_CREATED` datetime NOT NULL,
	`DATE_UPDATED` datetime NOT NULL,
	primary key (ID)
);

create table if not exists rs_vbasket_item
(
	`ID` int(11) NOT NULL auto_increment,
	`VBASKET_ID` int(11) NOT NULL,
	`BASKET_ITEM_ID` int(11) NOT NULL,
	`PRODUCT_ID` int(11) NOT NULL,
	`FIELDS_VALUES` blob NOT NULL,
	`PROPS_VALUES` blob NOT NULL,
	primary key (ID)
);


create table if not exists rs_vbasket_shared
(
	`ID` int(11) NOT NULL auto_increment,
	`DATE_CREATED` datetime NOT NULL,
	`DATE_UPDATED` datetime NOT NULL,
	`SITE_ID` varchar(255) NOT NULL,
	`BASKET_ID` int(11) NOT NULL,
	`BASKET_UPDATED` datetime NOT NULL,
	`NAME` varchar(255) NOT NULL,
	`COLOR` varchar(255) NOT NULL,
	`HASH` varchar(255) NOT NULL,
	`SHORT_URI` varchar(255) NOT NULL,
	`PRODUCTS` blob NOT NULL,
	`DATE_LAST_APPLY` datetime NOT NULL,
	primary key (ID)
);