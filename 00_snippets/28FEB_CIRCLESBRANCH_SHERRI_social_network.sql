-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2017 at 02:26 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_entry`
--

CREATE TABLE `blog_entry` (
  `entryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `entry` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_entry`
--

INSERT INTO `blog_entry` (`entryID`, `userID`, `entry`, `date`) VALUES
(1, 1, 'hello there friend', '2017-02-21 03:21:35'),
(2, 1, 'i am testing this blog', '2017-02-21 03:21:43'),
(4, 4, 'hello my friends', '2017-02-22 00:57:13'),
(5, 2, 'greetings', '2017-02-22 00:57:22'),
(6, 4, 'this is my blog and my blog alone', '2017-02-22 00:57:37'),
(7, 2, 'Hello', '2017-02-22 15:38:25'),
(8, 3, 'aaaaa', '2017-02-24 01:46:52'),
(9, 3, 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-02-24 01:46:57'),
(10, 3, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2017-02-24 01:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `circle`
--

CREATE TABLE `circle` (
  `circleID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `privacyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circle`
--

INSERT INTO `circle` (`circleID`, `name`, `description`, `privacyID`) VALUES
(1, 'League of Extraordinary Cats', 'We are the League of Extraordinary Cats, dedicated to the commemoration of the achievements of truly outstanding cats who have been tireless advocates of the rights of cats. We gather to celebrate the greatness of cats and to formulate plans for world domination.', 1),
(2, 'Normal Cats', 'We are normal cats just living normal lives.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `circle_participants`
--

CREATE TABLE `circle_participants` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circle_participants`
--

INSERT INTO `circle_participants` (`circleID`, `userID`, `userStatus`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 3),
(1, 4, 1),
(1, 5, 1),
(1, 7, 1),
(2, 1, 3),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `friendship`
--

CREATE TABLE `friendship` (
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendship`
--

INSERT INTO `friendship` (`userID1`, `userID2`, `status`) VALUES
(1, 2, 0),
(1, 3, 1),
(1, 6, 0),
(1, 7, 1),
(2, 4, 1),
(2, 5, 1),
(3, 1, 1),
(3, 2, 0),
(3, 4, 1),
(4, 1, 0),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` int(11) NOT NULL,
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `circleID`, `userID`, `message`, `date`) VALUES
(3, 1, 3, 'does this work', '2017-02-22 00:14:26'),
(16, 2, 2, 'this is working for now', '2017-02-22 01:50:57'),
(21, 1, 7, 'please add me', '2017-02-22 23:25:20'),
(24, 2, 6, 'testing', '2017-02-23 00:54:53'),
(30, 1, 2, 'work ffs', '2017-02-23 16:43:26'),
(31, 2, 4, 'come on', '2017-02-23 16:45:44'),
(42, 2, 4, 'it works i think', '2017-02-24 01:52:44'),
(43, 2, 5, 't', '2017-02-24 02:06:09'),
(46, 1, 3, 'helhlelhehehoehoeh', '2017-02-28 13:16:43'),
(47, 1, 3, 'sdfghjkl;', '2017-02-28 13:38:21'),
(49, 1, 3, '23123123123123', '2017-02-28 13:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `photoID` int(11) NOT NULL,
  `collectionID` int(11) NOT NULL,
  `photoURL` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo_annotation`
--

CREATE TABLE `photo_annotation` (
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `annotationType` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo_collection`
--

CREATE TABLE `photo_collection` (
  `collectionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `privacyID` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo_comment`
--

CREATE TABLE `photo_comment` (
  `commentID` int(11) NOT NULL,
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_settings`
--

CREATE TABLE `privacy_settings` (
  `privacyID` int(11) NOT NULL,
  `option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privacy_settings`
--

INSERT INTO `privacy_settings` (`privacyID`, `option`) VALUES
(1, 'public'),
(2, 'friends of friends'),
(3, 'circles'),
(4, 'friends'),
(5, 'private');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `profilephotoURL` varchar(255) DEFAULT NULL,
  `privacyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `password`, `firstName`, `lastName`, `dob`, `gender`, `location`, `profilephotoURL`, `privacyID`) VALUES
(1, 'js@test.com', 'test', 'admin', 'test', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/1/1e/PI_Tangerines.png?version=afdf72aa1d0af3cbbac9b7e015fe8081', 1),
(2, 'second@test.com', 'test', 'the', 'second', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/0/0b/PI_Pachimari.png?version=b8f06ceabcfc1b9df1464e394be251d3', 1),
(3, 'third@friend.com', 'test', 'third', 'friend', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/3/33/PI_Lunamari.png?version=e544f707bf84b1e2822da79171a2d493', 1),
(4, 'fourth@test.com', 'test', 'fourth', 'person', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/6/6e/PI_Bokimari.png?version=098cc69f5de7e7f55eb7242d69985a3e', 1),
(5, 'fifth@test.com', 'test', 'fifth', 'user', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/1/14/PI_Sakura.png?version=28d4a4cb8b7830a7d6c3398a6e23c50b', 1),
(6, 'sixth@test.com', 'test', 'sixth', 'person', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/7/70/PI_Bao.png?version=cb2a9c0d0a8277d6427beb42439e5375', 1),
(7, 'seven@test.com', 'test', 'number', 'seven', NULL, NULL, NULL, 'https://hydra-media.cursecdn.com/overwatch.gamepedia.com/9/99/PI_Pachilantern.png?version=9373d394664fa7b4e7bcdcea103df7e5', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_entry`
--
ALTER TABLE `blog_entry`
  ADD PRIMARY KEY (`entryID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `circle`
--
ALTER TABLE `circle`
  ADD PRIMARY KEY (`circleID`),
  ADD KEY `privacyID` (`privacyID`);

--
-- Indexes for table `circle_participants`
--
ALTER TABLE `circle_participants`
  ADD PRIMARY KEY (`circleID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`userID1`,`userID2`),
  ADD KEY `userID2` (`userID2`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `circleID` (`circleID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photoID`),
  ADD KEY `collectionID` (`collectionID`);

--
-- Indexes for table `photo_annotation`
--
ALTER TABLE `photo_annotation`
  ADD PRIMARY KEY (`photoID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `photo_collection`
--
ALTER TABLE `photo_collection`
  ADD PRIMARY KEY (`collectionID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `privacyID` (`privacyID`);

--
-- Indexes for table `photo_comment`
--
ALTER TABLE `photo_comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `photoID` (`photoID`);

--
-- Indexes for table `privacy_settings`
--
ALTER TABLE `privacy_settings`
  ADD PRIMARY KEY (`privacyID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `privacyID` (`privacyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_entry`
--
ALTER TABLE `blog_entry`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `circle`
--
ALTER TABLE `circle`
  MODIFY `circleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `photoID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photo_collection`
--
ALTER TABLE `photo_collection`
  MODIFY `collectionID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photo_comment`
--
ALTER TABLE `photo_comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `privacy_settings`
--
ALTER TABLE `privacy_settings`
  MODIFY `privacyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_entry`
--
ALTER TABLE `blog_entry`
  ADD CONSTRAINT `blog_entry_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `circle`
--
ALTER TABLE `circle`
  ADD CONSTRAINT `circle_ibfk_1` FOREIGN KEY (`privacyID`) REFERENCES `privacy_settings` (`privacyID`);

--
-- Constraints for table `circle_participants`
--
ALTER TABLE `circle_participants`
  ADD CONSTRAINT `circle_participants_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `circle_participants_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circle` (`circleID`);

--
-- Constraints for table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `friendship_ibfk_1` FOREIGN KEY (`userID1`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `friendship_ibfk_2` FOREIGN KEY (`userID2`) REFERENCES `user` (`userID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circle` (`circleID`),
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`collectionID`) REFERENCES `photo_collection` (`collectionID`);

--
-- Constraints for table `photo_annotation`
--
ALTER TABLE `photo_annotation`
  ADD CONSTRAINT `photo_annotation_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `photo_annotation_ibfk_2` FOREIGN KEY (`photoID`) REFERENCES `photo` (`photoID`);

--
-- Constraints for table `photo_collection`
--
ALTER TABLE `photo_collection`
  ADD CONSTRAINT `photo_collection_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `photo_collection_ibfk_2` FOREIGN KEY (`privacyID`) REFERENCES `privacy_settings` (`privacyID`);

--
-- Constraints for table `photo_comment`
--
ALTER TABLE `photo_comment`
  ADD CONSTRAINT `photo_comment_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `photo_comment_ibfk_2` FOREIGN KEY (`photoID`) REFERENCES `photo` (`photoID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`privacyID`) REFERENCES `privacy_settings` (`privacyID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
