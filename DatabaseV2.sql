CREATE TABLE `category` (
 `categoryid` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `categoryname` VARCHAR(45) NOT NULL,
 `parentcategory` VARCHAR(45) NOT NULL
);

CREATE TABLE `user` (
 `userid` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `username` VARCHAR(45) NOT NULL,
 `password` VARCHAR(45) NOT NULL,
 `email` VARCHAR(45) NOT NULL,
 `usertype` VARCHAR(15) NOT NULL,
 `classtype` VARCHAR(255) NOT NULL,
 `positivefeedback` INTEGER DEFAULT 0,
 `negativefeedback` INTEGER DEFAULT 0,
 `profilepic` VARCHAR(512) DEFAULT "default-profile.jpeg",
 `companyname` VARCHAR(45),
 `phonenumber` VARCHAR(45),
 `firstname` VARCHAR(45),
 `lastname` VARCHAR(45),
 `buildingnumber` VARCHAR(45),
 `streetname` VARCHAR(45),
 `cityname` VARCHAR(45),
 `countyname` VARCHAR(45),
 `postcode` VARCHAR(10)
);

CREATE TABLE `communication` (
 `communicationid` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `senderid` INTEGER NOT NULL,
 `receiverid` INTEGER NOT NULL,
 `communicationtype` VARCHAR(31) NOT NULL,
 `message` VARCHAR(300) NOT NULL,
 `messagedate` timestamp NOT NULL,
 `sent_by` INTEGER NOT NULL,
 `received_by` INTEGER NOT NULL,
 `classtype` VARCHAR(255) NOT NULL,
 `unread` tinyint(1),
 `isbuyer` tinyint(1),
 `ispositive` BOOLEAN DEFAULT 1
);

CREATE INDEX `idx_communication__received_by` ON `communication` (`received_by`);

CREATE INDEX `idx_communication__sent_by` ON `communication` (`sent_by`);

ALTER TABLE `communication` ADD CONSTRAINT `fk_communication__received_by` FOREIGN KEY (`received_by`) REFERENCES `user` (`userid`);

ALTER TABLE `communication` ADD CONSTRAINT `fk_communication__sent_by` FOREIGN KEY (`sent_by`) REFERENCES `user` (`userid`);

CREATE TABLE `item` (
 `itemid` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `sellerid` INTEGER NOT NULL,
 `categoryid` INTEGER NOT NULL,
 `title` VARCHAR(45) NOT NULL,
 `description` VARCHAR(300) NOT NULL,
 `itemcondition` VARCHAR(31) NOT NULL,
 `photo` VARCHAR(512) NOT NULL DEFAULT "default-item-photo.jpeg",
 `startprice` decimal(7,2) NOT NULL DEFAULT 0,
 `reserveprice` decimal(7,2) DEFAULT 0,
 `enddate` DATETIME NOT NULL,
 `itemviewcount` INTEGER NOT NULL DEFAULT 0,
 `notified` tinyint(1) NOT NULL,
 `contained_in` INTEGER NOT NULL,
 `added_by` INTEGER NOT NULL
);

CREATE INDEX `idx_item__added_by` ON `item` (`added_by`);

CREATE INDEX `idx_item__contained_in` ON `item` (`contained_in`);

ALTER TABLE `item` ADD CONSTRAINT `fk_item__added_by` FOREIGN KEY (`added_by`) REFERENCES `user` (`userid`);

ALTER TABLE `item` ADD CONSTRAINT `fk_item__contained_in` FOREIGN KEY (`contained_in`) REFERENCES `category` (`categoryid`);

CREATE TABLE `bid` (
 `bidid` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `itemid` INTEGER NOT NULL,
 `buyerid` INTEGER NOT NULL,
 `bidamount` decimal(7,2) NOT NULL,
 `biddate` timestamp NOT NULL,
 `bidwinning` BOOLEAN NOT NULL,
 `made_on` INTEGER NOT NULL,
 `made_by` INTEGER NOT NULL
);

CREATE INDEX `idx_bid__made_by` ON `bid` (`made_by`);

CREATE INDEX `idx_bid__made_on` ON `bid` (`made_on`);

ALTER TABLE `bid` ADD CONSTRAINT `fk_bid__made_by` FOREIGN KEY (`made_by`) REFERENCES `user` (`userid`);

ALTER TABLE `bid` ADD CONSTRAINT `fk_bid__made_on` FOREIGN KEY (`made_on`) REFERENCES `item` (`itemid`);

CREATE TABLE `watchlist_item` (
 `userid` INTEGER NOT NULL,
 `itemid` INTEGER NOT NULL,
 `contains` INTEGER NOT NULL,
 `added_by` INTEGER NOT NULL,
 CONSTRAINT `pk_watchlist_item` PRIMARY KEY (`userid`, `itemid`)
);

CREATE INDEX `idx_watchlist_item__added_by` ON `watchlist_item` (`added_by`);

CREATE INDEX `idx_watchlist_item__contains` ON `watchlist_item` (`contains`);

ALTER TABLE `watchlist_item` ADD CONSTRAINT `fk_watchlist_item__added_by` FOREIGN KEY (`added_by`) REFERENCES `user` (`userid`);

ALTER TABLE `watchlist_item` ADD CONSTRAINT `fk_watchlist_item__contains` FOREIGN KEY (`contains`) REFERENCES `item` (`itemid`)
