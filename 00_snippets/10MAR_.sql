-- THIS IS A MODIFIED CREATE STATEMENT (GENERIC) BASED ON ROB'S EXPORTED DB 10 MAR
-- THIS SHOULD WORK
-- USE THIS INSTEAD TO CREATE THE DATABASE FROM SCRATCH


CREATE DATABASE social_network;

USE social_network;

-- --------------------------------------------------------

--
-- Table structure for table `blog_entry`
--

CREATE TABLE `blog_entry` (
  `entryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `entry` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `circle`
--

CREATE TABLE `circle` (
  `circleID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `privacyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `circle_participants`
--

CREATE TABLE `circle_participants` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userStatus` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friendship`
--

CREATE TABLE `friendship` (
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` int(11) NOT NULL,
  `circleID` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `photoID` int(11) NOT NULL,
  `collectionID` int(11) NOT NULL,
  `photoURL` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo_annotation`
--

CREATE TABLE `photo_annotation` (
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `annotationType` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo_collection`
--

CREATE TABLE `photo_collection` (
  `collectionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `privacyID` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_settings`
--

CREATE TABLE `privacy_settings` (
  `privacyID` int(11) NOT NULL,
  `option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- This probably won't change, keep it
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD KEY `userID` (`userID`),
  ADD KEY `circleID` (`circleID`);

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
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `circle`
--
ALTER TABLE `circle`
  MODIFY `circleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `photoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `photo_collection`
--
ALTER TABLE `photo_collection`
  MODIFY `collectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `photo_comment`
--
ALTER TABLE `photo_comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `privacy_settings`
--
ALTER TABLE `privacy_settings`
  MODIFY `privacyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
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
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circle` (`circleID`);

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
