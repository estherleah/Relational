# T29
# MySQL code snippets

####################
# Create Statement #
####################

CREATE DATABASE social_network;

USE social_network;

CREATE TABLE `privacy_settings` (
  `privacyID` INT NOT NULL AUTO_INCREMENT,
  `option` INT NOT NULL,
  PRIMARY KEY (privacyID)
);

CREATE TABLE `user` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `dob` DATE,
  `gender` INT,
  `location` VARCHAR(255),
  `profilephotoURL` VARCHAR(255),
  `privacyID` INT NOT NULL,
  PRIMARY KEY (userID),
  FOREIGN KEY (privacyID) REFERENCES privacy_settings(privacyID)
);

CREATE TABLE `friendship` (
  `userID1` INT NOT NULL,
  `userID2` INT NOT NULL,
  PRIMARY KEY (userID1, userID2),
  FOREIGN KEY (userID1) REFERENCES user(userID),
  FOREIGN KEY (userID2) REFERENCES user(userID)
);

CREATE TABLE `photo_collection` (
  `collectionID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NOT NULL,
  `privacyID` INT NOT NULL,
  PRIMARY KEY (collectionID),
  FOREIGN KEY (userID) REFERENCES user(userID),
  FOREIGN KEY (privacyID) REFERENCES privacy_settings(privacyID)
);

CREATE TABLE `circle` (
  `circleID` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `privacyID` INT NOT NULL,
  PRIMARY KEY (circleID),
  FOREIGN KEY (privacyID) REFERENCES privacy_settings(privacyID)
);

CREATE TABLE `circle_participants` (
  `circleID` INT NOT NULL,
  `userID` INT NOT NULL,
  PRIMARY KEY (circleID, userID),
  FOREIGN KEY (userID) REFERENCES user(userID),
  FOREIGN KEY (circleID) REFERENCES circle(circleID)
);

CREATE TABLE `photo` (
  `photoID` INT NOT NULL AUTO_INCREMENT,
  `collectionID` INT NOT NULL,
  `photoURL` VARCHAR(255) NOT NULL,
  PRIMARY KEY (photoID),
  FOREIGN KEY (collectionID) REFERENCES photo_collection(collectionID)
);

CREATE TABLE `photo_comment` (
  `commentID` INT NOT NULL AUTO_INCREMENT,
  `photoID` INT NOT NULL,
  `userID` INT NOT NULL,
  `comment` TEXT NOT NULL,
  PRIMARY KEY (commentID),
  FOREIGN KEY (userID) REFERENCES user(userID),
  FOREIGN KEY (photoID) REFERENCES photo(photoID)
);

CREATE TABLE `message` (
  `messageID` INT NOT NULL AUTO_INCREMENT,
  `circleID` INT NOT NULL,
  `userID` INT NOT NULL,
  `message` TEXT NOT NULL,
  PRIMARY KEY (messageID),
  FOREIGN KEY (userID) REFERENCES user(userID),
  FOREIGN KEY (circleID) REFERENCES circle(circleID)
);

CREATE TABLE `photo_annotation` (
  `photoID` INT NOT NULL,
  `userID` INT NOT NULL,
  `annotationType` INT NOT NULL,
  PRIMARY KEY (photoID, userID),
  FOREIGN KEY (userID) REFERENCES user(userID),
  FOREIGN KEY (photoID) REFERENCES photo(photoID)
);

CREATE TABLE `blog_entry` (
  `entryID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NOT NULL,
  `entry` TEXT NOT NULL,
  PRIMARY KEY (entryID),
  FOREIGN KEY (userID) REFERENCES user(userID)
);