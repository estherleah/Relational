-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 10, 2017 at 02:35 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_entry`
--

INSERT INTO `blog_entry` (`entryID`, `userID`, `entry`, `date`) VALUES
(24, 1, 'new blog post', '2017-03-02 01:13:16'),
(25, 1, 'and another', '2017-03-02 01:13:19'),
(26, 1, 'yet another', '2017-03-02 01:13:23'),
(27, 1, 'yay!', '2017-03-02 02:02:35');

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

--
-- Dumping data for table `circle`
--

INSERT INTO `circle` (`circleID`, `name`, `description`, `privacyID`) VALUES
(1, 'circle1', NULL, 3),
(2, 'circle2', NULL, 1),
(3, 'circle3', NULL, 2),
(4, '', '', 1),
(5, 'new circle', 'bob', 1);

-- --------------------------------------------------------

--
-- Table structure for table `circle_participants`
--

CREATE TABLE `circle_participants` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userStatus` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `circle_participants`
--

INSERT INTO `circle_participants` (`circleID`, `userID`, `userStatus`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 5, 0),
(1, 6, 0),
(1, 10, 0),
(2, 6, 0),
(2, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `friendship`
--

CREATE TABLE `friendship` (
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friendship`
--

INSERT INTO `friendship` (`userID1`, `userID2`, `status`) VALUES
(1, 2, 1),
(1, 3, 1),
(1, 5, 1),
(1, 9, 1),
(1, 10, 0),
(2, 3, 1),
(2, 4, 1),
(3, 4, 1),
(5, 6, 1),
(5, 7, 0),
(5, 8, 1),
(5, 9, 1),
(5, 10, 1);

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

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `circleID`, `userID`, `message`, `date`) VALUES
(3, NULL, 1, 'new', '2017-02-22 18:55:33'),
(4, NULL, 1, '$(function() { // waits for document to be ready\\r\\n  $(document).on(\'click\',\'#postSubmit\',function(){\\r\\n    var post = $(\'#name\').val();\\r\\n    var dataString = \'name=\' + post;\\r\\n    if (!post) {\\r\\n      alert(\'Enter some text\');\\r\\n    }\\r\\n    else {\\r\\n      // call php code to write to DB\\r\\n      $.ajax({\\r\\n          type: \"POST\",\\r\\n          url: \"../includes/addPhotoCollection.php\",\\r\\n          data: dataString,\\r\\n          cache: false,\\r\\n          success: function(html) {\\r\\n              // reload data\\r\\n              $(\"#previousposts\").load(location.href + \" #previousposts\");\\r\\n          }\\r\\n      });\\r\\n    }\\r\\n\\r\\n  });\\r\\n\\r\\n});\\r\\n', '2017-02-22 18:57:42'),
(5, NULL, 1, 'hey everyone!', '2017-03-02 02:02:45');

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

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`photoID`, `collectionID`, `photoURL`, `date`) VALUES
(23, 4, 'uploads/userId-1/collectionId-4/Screen Shot 2017-03-01 at 20.14.00.png', '2017-03-01 22:52:46'),
(26, 4, 'uploads/userId-1/collectionId-4/Screen Shot 2017-03-01 at 22.15.33.png', '2017-03-01 23:15:38'),
(27, 4, 'uploads/userId-1/collectionId-4/Screen Shot 2017-03-02 at 00.15.24.png', '2017-03-02 01:16:08'),
(28, 3, 'uploads/userId-1/collectionId-3/Screen Shot 2017-03-02 at 00.15.24.png', '2017-03-02 01:45:08'),
(29, 5, 'uploads/userId-1/collectionId-5/Screen Shot 2017-03-01 at 22.15.33.png', '2017-03-02 01:45:32'),
(32, 8, 'uploads/userId-1/collectionId-8/Screen Shot 2017-03-05 at 18.22.00.png', '2017-03-07 14:16:29'),
(33, 9, 'uploads/userId-1/collectionId-9/LWScreenShot 2017-03-10 at 11.46.54.png', '2017-03-10 14:31:02');

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

--
-- Dumping data for table `photo_collection`
--

INSERT INTO `photo_collection` (`collectionID`, `userID`, `name`, `privacyID`, `date`) VALUES
(2, 1, 'r f', 1, '2017-02-22 19:53:21'),
(3, 1, 'yet another', 1, '2017-02-22 19:55:32'),
(4, 1, 'new photo collection', 1, '2017-02-23 16:01:41'),
(5, 1, 'the best photo collection ever', 1, '2017-03-02 01:45:28'),
(6, 1, 'try me', 1, '2017-03-02 01:56:32'),
(7, 1, 'new collection', 1, '2017-03-03 21:33:36'),
(8, 1, 'new collection 2', 1, '2017-03-07 14:16:19'),
(9, 1, 'remove photo test', 1, '2017-03-09 17:05:01');

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

--
-- Dumping data for table `photo_comment`
--

INSERT INTO `photo_comment` (`commentID`, `photoID`, `userID`, `comment`, `date`) VALUES
(2, 23, 1, 'comment', '2017-03-02 01:05:41'),
(3, 23, 1, 'comment', '2017-03-02 01:06:17'),
(4, 23, 1, 'comment', '2017-03-02 01:06:49'),
(5, 23, 1, 'new comment', '2017-03-02 01:07:29'),
(6, 23, 1, 'blah blah blah', '2017-03-02 01:08:13'),
(7, 23, 1, 'yo yo', '2017-03-02 01:09:13'),
(8, 26, 1, 'new comment', '2017-03-02 01:11:43'),
(9, 27, 1, 'hey', '2017-03-02 01:16:16'),
(10, 28, 1, 'some comment', '2017-03-02 02:02:30'),
(11, 32, 1, 'new comment from me', '2017-03-07 14:17:05'),
(12, 27, 1, 'This is a nice photo!', '2017-03-09 21:05:20'),
(13, 26, 1, 'hello!', '2017-03-09 21:07:25'),
(14, 27, 1, 'much better', '2017-03-09 21:09:33'),
(15, 33, 1, 'hello!', '2017-03-10 14:31:10'),
(16, 33, 1, 'this works now', '2017-03-10 14:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_settings`
--

CREATE TABLE `privacy_settings` (
  `privacyID` int(11) NOT NULL,
  `option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `password`, `firstName`, `lastName`, `dob`, `gender`, `location`, `profilephotoURL`, `privacyID`) VALUES
(1, 'rf@email.com', 'UWuXg/ylF+7L0dBk2i0WUxCxl1k=', 'r', 'f', '2017-03-10', 0, 'QA', 'img/userId-1/0fc59efffd13d661c3231986d2d7c60b4cb03b10a15b266dd6694c0326a224a2.jpg', 1),
(2, 'bsmith@email.com', 'p', 'bob', 'smith', NULL, NULL, NULL, 'https://robohash.org/quamnihileveniet.jpg?size=50x50&set=set1', 1),
(3, 'user3@email.com', 'p', 'user3', 'user3', NULL, NULL, NULL, 'https://robohash.org/quasiodiout.jpg?size=50x50&set=set1', 1),
(4, 'user4@email.com', 'p', 'user4', 'user4', NULL, NULL, NULL, 'https://robohash.org/doloresanimiest.jpg?size=50x50&set=set1', 1),
(5, 'user5@email.com', 'p', 'user5', 'user5', NULL, NULL, NULL, 'https://robohash.org/consecteturtemporenatus.jpg?size=50x50&set=set1', 1),
(6, 'fbanks0@51.la', 'WEaAJyr', 'Banks', 'Frank', '2001-12-11', 1, 'Phumĭ Véal Srê', 'https://robohash.org/quamnihileveniet.jpg?size=50x50&set=set1', 1),
(7, 'pperry1@1688.com', 'AuxVCMSVFy', 'Perry', 'Pamela', '1962-12-15', 1, 'Ulster Spring', 'https://robohash.org/quasiodiout.jpg?size=50x50&set=set1', 2),
(8, 'abishop2@topsy.com', 'IUJPRgFM', 'Bishop', 'Anne', '1955-12-09', 1, 'Campoverde', 'https://robohash.org/estetiure.jpg?size=50x50&set=set1', 3),
(9, 'ecooper3@google.com.au', 'OSKnWXN', 'Cooper', 'Elizabeth', '1995-09-10', 2, 'Sintansin', 'https://robohash.org/doloresanimiest.jpg?size=50x50&set=set1', 4),
(10, 'jlane4@yellowpages.com', '8i6ZYa', 'Lane', 'Jacqueline', '1999-04-01', 3, 'Punta Hermosa', 'https://robohash.org/consecteturtemporenatus.jpg?size=50x50&set=set1', 5),
(11, 'testuser@email.com', 'UWuXg/ylF+7L0dBk2i0WUxCxl1k=', 'Test', 'User', NULL, 2017, NULL, NULL, 1);

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
