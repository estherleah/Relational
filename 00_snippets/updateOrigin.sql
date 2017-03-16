ALTER TABLE `friendship` CHANGE `origin` `originUserID` INT(11) NOT NULL;
ALTER TABLE `friendship` ADD CONSTRAINT `friendship_ibfk_3` FOREIGN KEY (`originUserID`) REFERENCES `user`(`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
