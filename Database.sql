DROP Database Database; /* Delete DB each time */

CREATE DATABASE Database
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

GRANT SELECT,UPDATE,INSERT,DELETE
    ON Database.*
    TO 'root'@'localhost'
    IDENTIFIED BY '';

USE Database;

-- Users Table
CREATE TABLE Users (
    userID INTEGER NOT NULL AUTO_INCREMENT,
    username VARCHAR(40) NOT NULL,
    password VARCHAR(40) NOT NULL,
    positiveFeedback INTEGER NOT NULL, -- Increases if user receives positive feedback
    negativeFeedback INTEGER NOT NULL, -- Increases if user receives negative feedback
    profilePic VARCHAR(512),
    companyName VARCHAR(45),
    email VARCHAR(45) NOT NULL,
    phoneNumber VARCHAR(45),
    firstName VARCHAR(45),
    lastName VARCHAR(45),
    buildingNumber VARCHAR(45) NOT NULL,
    streetName VARCHAR(45) NOT NULL,
    cityName VARCHAR(45) NOT NULL,
    countyName VARCHAR(45),
    postCode VARCHAR(10) NOT NULL,
    CONSTRAINT UsersPK PRIMARY KEY (userID)
);

-- Items Table
CREATE TABLE Items (
    itemID INTEGER NOT NULL AUTO_INCREMENT,
    sellerID INTEGER NOT NULL, -- FOREIGN KEY
    title VARCHAR(45) NOT NULL,
    description VARCHAR(300) NOT NULL,
    itemCondition VARCHAR(31) NOT NULL,
    photo VARCHAR(512) NOT NULL,
    categoryID INTEGER NOT NULL, -- FOREIGN KEY
    startPrice decimal(7,2) NOT NULL,
    reservePrice decimal(7,2) NOT NULL,
    endDate date NOT NULL,
    itemViewCount INTEGER NOT NULL,
    CONSTRAINT ItemsPK PRIMARY KEY (itemID)
);

-- Bids Table
CREATE TABLE Bids (
    bidID INTEGER NOT NULL AUTO_INCREMENT,
    itemID INTEGER NOT NULL, -- FK
    buyerID INTEGER NOT NULL, -- FK
    bidAmount decimal(7,2) NOT NULL,
    bidDate date NOT NULL,
    bidWon boolean NOT NULL, -- True if bid won the auction, false otherwise
    CONSTRAINT BidsPK PRIMARY KEY (bidID)
);

-- Categories Table
CREATE TABLE Categories (
    categoryID INTEGER NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR(45) NOT NULL,
    parentCategory VARCHAR(45),
    CONSTRAINT CategoriesPK PRIMARY KEY (categoryID)
);

-- Watchlist Table
CREATE TABLE Watchlist_Items (
    userID INTEGER NOT NULL,
    itemID INTEGER NOT NULL,
    CONSTRAINT WatchlistPK PRIMARY KEY (userID,itemID)
);

-------------------------------------------
-- FOREIGN KEYS --
ALTER TABLE Items ADD CONSTRAINT ItemSeller FOREIGN KEY ItemSeller (sellerID) REFERENCES Users (userID);
ALTER TABLE Items ADD CONSTRAINT ItemCategory FOREGIN KEY ItemCategory (categoryID) REFERENCES Categories (categoryID);
ALTER TABLE Bids ADD CONSTRAINT BidItem FOREIGN KEY BidItem (itemID) REFERENCES Items (itemID);
ALTER TABLE Bids ADD CONSTRAINT BidMaker FOREGIN KEY BidMaker (buyerID) REFERENCES Users (userID);
ALTER TABLE Watchlist_Items ADD CONSTRAINT WatchlistOwner FOREIGN KEY WatchlistOwner (userID) REFERENCES Users (userID);
ALTER TABLE Watchlist_Items ADD CONSTRAINT WatchlistItem FOREGIN KEY WatchlistItem (itemID) REFERENCES Items (itemID);

-------------------------------------------
-- INITIAL DATA --

-- Initialising Users:
# INSERT INTO Users (username, password, positiveFeedback, negativeFeedback, profilePic, companyName, email, phoneNumber, firstName, lastName, buildingNumber, streetName, cityName, countyName, postCode)
# VALUES ('user','password',0,0,'generic_profile_url.com','The Company','user@user.com','01823987654','Lord','Sugah','10','Downing Street','Landan','Landanshire','LAD5 CUL8R');

-- Initialising Categories:
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Handbags and Accessories','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Jewellery and Watches','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Kids Fashion','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Men''s Clothing','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Shoes','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Women''s Clothing','Fashion');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Appliances','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Baby and Toddler','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Bath','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Celebrations and Occasions','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Crafts','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('DIY and Home Improvement','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Furniture and Homeware','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Garden','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Kitchen and Dining','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Pets','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Wine','Home and Garden');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Camera and Photo','Electronics');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Computers, Tablets and Networks','Electronics');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Mobile and Home Phones','Electronics');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Sound and Vision','Electronics');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Video Games and Consoles','Electronics');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Event Tickets','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Festivals (Camping and Hiking)','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Holidays and Travel','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Musical Instruments','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Sporting Goods','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Wholesale and Job Lots','Sports, Hobbies and Leisure');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Antiques','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Art','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Coins','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Collectables','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('DVDs, Films and TV','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Dolls and Bears','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Pottery and Glass','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Sports Memorabilia','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Stamps','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Toys and Games','Collectibles and Art');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Facial Skin Care','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Fragrances','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Hair Care and Styling','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Makeup','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Medical, Mobility & Disability','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Shaving and Hair Removal','Health and Beauty');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Cars','Motors');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('More Vehicles','Motors');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Motorcyle Parts and Accessories','Motors');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Motorcycles and Scooters','Motors');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Vehicle Parts and Accessories','Motors');
# INSERT INTO Categories (categoryName, parentCategory) VALUES ('Other','Other');
