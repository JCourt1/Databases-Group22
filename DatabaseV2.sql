CREATE TABLE `categories` (
 `categoryID` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `categoryName` VARCHAR(45) NOT NULL,
 `parentCategory` VARCHAR(45) NOT NULL
);

CREATE TABLE `users` (
 `userID` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `username` VARCHAR(45) NOT NULL,
 `password` VARCHAR(45) NOT NULL,
 `email` VARCHAR(45) NOT NULL,
 `userType` VARCHAR(15) NOT NULL,
 `positiveFeedback` INTEGER DEFAULT 0,
 `negativeFeedback` INTEGER DEFAULT 0,
 `profilePic` mediumtext,
 `companyName` VARCHAR(45),
 `phoneNumber` VARCHAR(45),
 `firstName` VARCHAR(45),
 `lastName` VARCHAR(45),
 `buildingNumber` VARCHAR(45),
 `streetName` VARCHAR(45),
 `cityName` VARCHAR(45),
 `countyName` VARCHAR(45),
 `postCode` VARCHAR(10)
);

CREATE TABLE `communication` (
 `communicationID` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `senderID` INTEGER NOT NULL,
 `receiverID` INTEGER NOT NULL,
 `communicationType` VARCHAR(31) NOT NULL,
 `message` VARCHAR(300) NOT NULL,
 `messageDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `unread` tinyint(1),
 `isBuyer` tinyint(1),
 `isPositive` BOOLEAN DEFAULT 1
);

 -- CREATE INDEX `idx_communication__received_by` ON `communication` (`received_by`);
 --
 -- CREATE INDEX `idx_communication__sent_by` ON `communication` (`sent_by`);
 --
 -- ALTER TABLE `communication` ADD CONSTRAINT `fk_communication__received_by` FOREIGN KEY (`received_by`) REFERENCES `user` (`userid`);
 --
 -- ALTER TABLE `communication` ADD CONSTRAINT `fk_communication__sent_by` FOREIGN KEY (`sent_by`) REFERENCES `user` (`userid`);

CREATE TABLE `items` (
 `itemID` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `sellerID` INTEGER NOT NULL,
 `categoryID` INTEGER NOT NULL,
 `title` VARCHAR(45) NOT NULL,
 `description` VARCHAR(300) NOT NULL,
 `itemCondition` VARCHAR(31) NOT NULL,
 `photo` mediumtext NOT NULL,
 `startPrice` decimal(7,2) NOT NULL DEFAULT 0,
 `reservePrice` decimal(7,2) DEFAULT 0,
 `endDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `itemViewCount` INTEGER NOT NULL DEFAULT 0,
 `notified` tinyint(1) NOT NULL,
 );

-- CREATE INDEX `idx_item__added_by` ON `item` (`added_by`);
--
-- CREATE INDEX `idx_item__contained_in` ON `item` (`contained_in`);
--
-- ALTER TABLE `item` ADD CONSTRAINT `fk_item__added_by` FOREIGN KEY (`added_by`) REFERENCES `user` (`userid`);
--
-- ALTER TABLE `item` ADD CONSTRAINT `fk_item__contained_in` FOREIGN KEY (`contained_in`) REFERENCES `category` (`categoryid`);

CREATE TABLE `bids` (
 `bidID` INTEGER PRIMARY KEY AUTO_INCREMENT,
 `itemID` INTEGER NOT NULL,
 `buyerID` INTEGER NOT NULL,
 `bidAmount` decimal(7,2) NOT NULL,
 `bidDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
);

-- CREATE INDEX `idx_bid__made_by` ON `bid` (`made_by`);
--
-- CREATE INDEX `idx_bid__made_on` ON `bid` (`made_on`);
--
-- ALTER TABLE `bid` ADD CONSTRAINT `fk_bid__made_by` FOREIGN KEY (`made_by`) REFERENCES `user` (`userid`);
--
-- ALTER TABLE `bid` ADD CONSTRAINT `fk_bid__made_on` FOREIGN KEY (`made_on`) REFERENCES `item` (`itemid`);

CREATE TABLE `watchlist_items` (
 `userID` INTEGER NOT NULL,
 `itemID` INTEGER NOT NULL,
 CONSTRAINT `pk_watchlist_item` PRIMARY KEY (`userid`, `itemid`)
);

-- CREATE INDEX `idx_watchlist_item__added_by` ON `watchlist_item` (`added_by`);
--
-- CREATE INDEX `idx_watchlist_item__contains` ON `watchlist_item` (`contains`);
--
-- ALTER TABLE `watchlist_item` ADD CONSTRAINT `fk_watchlist_item__added_by` FOREIGN KEY (`added_by`) REFERENCES `user` (`userid`);
--
-- ALTER TABLE `watchlist_item` ADD CONSTRAINT `fk_watchlist_item__contains` FOREIGN KEY (`contains`) REFERENCES `item` (`itemid`)
