CREATE TABLE categories (
   categoryID INTEGER PRIMARY KEY AUTO_INCREMENT,
   categoryName VARCHAR(45) NOT NULL,
   parentCategory VARCHAR(45) NOT NULL
);

CREATE TABLE users (
   userID INTEGER PRIMARY KEY AUTO_INCREMENT,
   username VARCHAR(45) NOT NULL,
   password VARCHAR(45) NOT NULL,
   email VARCHAR(45) NOT NULL
);

CREATE TABLE administrators (
   userID INTEGER PRIMARY KEY,
   FOREIGN KEY (userID) REFERENCES users (userID)
);

CREATE TABLE clients (
   userID INTEGER PRIMARY KEY,
   profilePic mediumtext,
   companyName VARCHAR(45),
   phoneNumber VARCHAR(45),
   firstName VARCHAR(45),
   lastName VARCHAR(45),
   buildingNumber VARCHAR(45),
   streetName VARCHAR(45),
   cityName VARCHAR(45),
   countyName VARCHAR(45),
   postCode VARCHAR(10),
   FOREIGN KEY (userID) REFERENCES users (userID)
);

CREATE TABLE communication (
   communicationID INTEGER PRIMARY KEY AUTO_INCREMENT,
   senderID INTEGER NOT NULL,
   receiverID INTEGER NOT NULL,
   message VARCHAR(300) NOT NULL,
   messagedate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE private_message (
   communicationID INTEGER PRIMARY KEY,
   messageSubject VARCHAR(300),
   FOREIGN KEY (communicationID) REFERENCES communication (communicationID)
);

CREATE TABLE notification (
   communicationID INTEGER PRIMARY KEY,
   unread tinyint(1),
   isBuyer tinyint(1),
   FOREIGN KEY (communicationID) REFERENCES communication (communicationID)
);

CREATE TABLE feedback (
   senderID INTEGER NOT NULL,
   receiverID INTEGER NOT NULL,
   itemID INTEGER NOT NULL,
   isPositive tinyint(1),
   CONSTRAINT pk_feedback PRIMARY KEY (senderID, receiverID, itemID)
);

CREATE TABLE items (
   itemID INTEGER PRIMARY KEY AUTO_INCREMENT,
   sellerID INTEGER NOT NULL,
   categoryID INTEGER NOT NULL,
   title VARCHAR(45) NOT NULL,
   description VARCHAR(300) NOT NULL,
   itemCondition VARCHAR(31) NOT NULL,
   photo mediumtext NOT NULL,
   startPrice decimal(7,2) NOT NULL DEFAULT 0,
   reservePrice decimal(7,2) DEFAULT 0,
   endDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   itemViewCount INTEGER NOT NULL DEFAULT 0,
   itemDeleted tinyint(1) NOT NULL DEFAULT 0, -- Deleted items are not removed altogether from the database
   notified tinyint(1) NOT NULL
);

CREATE TABLE bids (
   bidID INTEGER PRIMARY KEY AUTO_INCREMENT,
   itemID INTEGER NOT NULL,
   buyerID INTEGER NOT NULL,
   bidAmount decimal(7,2) NOT NULL,
   bidDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE watchlist_items (
   userID INTEGER NOT NULL,
   itemID INTEGER NOT NULL,
   CONSTRAINT pk_watchlist_item PRIMARY KEY (userID, itemID)
);

ALTER TABLE communication ADD CONSTRAINT FK_communication_Received_By FOREIGN KEY (receiverID) REFERENCES users (userID);
ALTER TABLE communication ADD CONSTRAINT FK_communication_Sent_By FOREIGN KEY (senderID) REFERENCES users (userID);

ALTER TABLE feedback ADD CONSTRAINT FK_feedback_Received_By FOREIGN KEY (receiverID) REFERENCES users (userID);
ALTER TABLE feedback ADD CONSTRAINT FK_feedback_Sent_By FOREIGN KEY (senderID) REFERENCES users (userID);
ALTER TABLE feedback ADD CONSTRAINT FK_feedback_Refers_to FOREIGN KEY (itemID) REFERENCES items (itemID);

ALTER TABLE items ADD CONSTRAINT FK_items_Added_By FOREIGN KEY (sellerID) REFERENCES clients (userID);
ALTER TABLE items ADD CONSTRAINT FK_items_Contained_In FOREIGN KEY (categoryID) REFERENCES categories (categoryID);

ALTER TABLE bids ADD CONSTRAINT FK_bids_Made_By FOREIGN KEY (buyerID) REFERENCES clients (userID);
ALTER TABLE bids ADD CONSTRAINT FK_bids_Made_On FOREIGN KEY (itemID) REFERENCES items (itemID);

ALTER TABLE watchlist_items ADD CONSTRAINT FK_watchlist_items_Added_By FOREIGN KEY (userID) REFERENCES clients (userID);
ALTER TABLE watchlist_items ADD CONSTRAINT FK_watchlist_items_References_Item FOREIGN KEY (itemID) REFERENCES items (itemID);