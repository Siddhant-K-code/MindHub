-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2017 at 06:14 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mindhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE IF NOT EXISTS `accesslog` (
  `memberId` smallint(5) unsigned NOT NULL,
  `pageUrl` varchar(255) NOT NULL,
  `numVisits` mediumint(9) NOT NULL,
  `lastAccess` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`memberId`,`pageUrl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accesslog`
--

INSERT INTO `accesslog` (`memberId`, `pageUrl`, `numVisits`, `lastAccess`) VALUES
(1, 'home.php', 18, '2016-08-26 18:31:48'),
(1, 'Logged_in_text_editor.php', 38, '2016-08-16 08:50:50'),
(1, 'news.php', 10, '2016-08-26 18:37:30'),
(2, 'home.php', 4, '2010-04-30 16:29:19'),
(2, 'Logged_in_text_editor.php', 2, '2016-07-30 05:04:45'),
(2, 'news.php', 16, '2016-09-26 17:00:13'),
(3, 'home.php', 1, '2010-04-30 16:31:22'),
(4, 'home.php', 1, '2016-07-19 16:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `ans`
--

CREATE TABLE IF NOT EXISTS `ans` (
  `answer_Id` int(11) NOT NULL AUTO_INCREMENT,
  `query_Id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `answeredBy` int(11) NOT NULL,
  `answeredOn` date NOT NULL,
  `urlReference` text,
  PRIMARY KEY (`answer_Id`),
  KEY `FK_QUERY_ID` (`query_Id`),
  KEY `FK_ANS_USER_ID` (`answeredBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ans`
--

INSERT INTO `ans` (`answer_Id`, `query_Id`, `answer`, `answeredBy`, `answeredOn`, `urlReference`) VALUES
(3, 5, 'Some answer', 2, '2017-03-21', NULL),
(5, 6, 'this is a new answer', 2, '2017-03-21', NULL),
(7, 6, 'again a new answer', 2, '2017-03-21', NULL),
(8, 11, 'answer to some question 3', 1, '2017-04-03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ask`
--

CREATE TABLE IF NOT EXISTS `ask` (
  `query_Id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `askedBy` int(11) NOT NULL,
  `askedOn` date NOT NULL,
  `quesType` enum('U','R') NOT NULL,
  PRIMARY KEY (`query_Id`),
  KEY `FK_USER_ID` (`askedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ask`
--

INSERT INTO `ask` (`query_Id`, `question`, `askedBy`, `askedOn`, `quesType`) VALUES
(5, 'is it not still working??', 2, '2017-02-24', 'U'),
(6, 'This is a new question?', 2, '2017-03-21', 'U'),
(11, 'Some ques 3?', 2, '2017-03-22', 'R'),
(12, 'Technology- Boon or Bane?', 1, '2017-03-22', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `debate`
--

CREATE TABLE IF NOT EXISTS `debate` (
  `debate_id` int(11) NOT NULL AUTO_INCREMENT,
  `debate_title` varchar(355) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_posted` date DEFAULT NULL,
  PRIMARY KEY (`debate_id`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `debate`
--

INSERT INTO `debate` (`debate_id`, `debate_title`, `user_id`, `date_posted`) VALUES
(2, 'Hello', 6, '2016-10-14'),
(3, 'Hello World!', 6, '2016-10-14'),
(4, 'Who would be the next president of United States?', 6, '2016-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `debate_comments`
--

CREATE TABLE IF NOT EXISTS `debate_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(355) NOT NULL,
  `debate_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_posted` date DEFAULT NULL,
  `comment_type` enum('FOR','AGAINST') DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `fk_debate` (`debate_id`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `debate_comments`
--

INSERT INTO `debate_comments` (`comment_id`, `comment`, `debate_id`, `user_id`, `date_posted`, `comment_type`) VALUES
(1, 'Some new thoughts', 3, 6, '2016-10-14', 'FOR'),
(2, 'This would be against the motion with a long comment two use more space.', 3, 6, '2016-10-14', 'AGAINST'),
(3, 'I guess Bill Gates', 4, 6, '2016-10-14', 'FOR'),
(4, 'Steve jobs is better than Bill Gates!!!!', 4, 6, '2016-10-14', 'AGAINST'),
(5, 'SUFDHviufjsd', 4, 2, '2016-10-19', 'FOR'),
(6, '698546518', 4, 2, '2016-12-06', 'FOR'),
(7, 'sJVoKSOBjSFM', 4, 1, '2016-12-07', 'AGAINST');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `password` char(41) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `institute` text NOT NULL,
  `position` enum('S','T') NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`,`emailAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`ID`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `emailAddress`, `gender`, `institute`, `position`, `score`) VALUES
(1, 'Akhil', 'Nair', 'akhil', '*63FE0507E0C38717237A25E1AC672B9A3751FF7B', '1989-12-19', 'akhil@gmail.com', 'm', '', 'T', 0),
(2, 'Rahul', 'Nair', 'rahul', '*266D4A68801B4CF67C2F24EEECEB43D67CFE4FF2', '2000-08-06', 'rahul@gmail.com', 'm', 'Aloy', 'S', 0),
(3, 'akshay', 'kumar', 'akshay', '*92B0981F5576D9E1F04E90D64A3FACCA168E7C3F', '2020-00-13', 'akshay@gmail.com', 'm', '', 'S', 0),
(4, 'Geeta', 'Nair', 'geeta_nair', '*09FD44FAF80E328C75BDC8B086D50D34C0640845', '1965-05-30', 'geeta_nair@gmail.com', 'f', '', 'S', 0),
(5, 'xyz', 'xyz', 'xyz', '*0E3CA784935AEDC2070B925F1F25B133FA831179', '2000-08-06', 'xyz@gmail.com', 'm', '', 'S', 0),
(6, 'Akhil', 'Nair', 'akhil_nair', '*63FE0507E0C38717237A25E1AC672B9A3751FF7B', '2016-10-13', 'akhil@thryft.in', 'm', '', 'T', 0),
(7, 'Shruti', 'Pillai', 'Shruti', '*E28948082ABB1792071995F36808C7C722DFE085', '1990-12-19', 'shruti@gmail.com', 'f', '', 'S', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(355) NOT NULL,
  `news_description` text,
  `news_url` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_posted` date DEFAULT NULL,
  PRIMARY KEY (`news_id`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_description`, `news_url`, `user_id`, `date_posted`) VALUES
(31, 'This is my First News', 'The Content Should be Awesome.', 'Some Random Source', 6, '2016-10-14'),
(32, 'Google''s new Pixel phones available to pre-order in India', '', 'http://www.gsmarena.com/googles_new_pixel_phones_available_to_preorder_in_india-news-21044.php', 2, '2016-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notice` text NOT NULL,
  `D.O.N.` date NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notice_id`, `user_id`, `notice`, `D.O.N.`) VALUES
(1, 2, 'You now have 100 points.', '2016-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `private_questions`
--

CREATE TABLE IF NOT EXISTS `private_questions` (
  `s_no` int(11) NOT NULL AUTO_INCREMENT,
  `query_id` int(11) NOT NULL,
  `asked_to` int(11) NOT NULL,
  PRIMARY KEY (`s_no`),
  KEY `FK_PRIVATE_QUERY_ID` (`query_id`),
  KEY `FK_PRIVATE_QUERY_USER_ID` (`asked_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `private_questions`
--

INSERT INTO `private_questions` (`s_no`, `query_id`, `asked_to`) VALUES
(4, 11, 1),
(5, 11, 4),
(6, 12, 1),
(7, 12, 3),
(8, 12, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ans`
--
ALTER TABLE `ans`
  ADD CONSTRAINT `FK_ANS_USER_ID` FOREIGN KEY (`answeredBy`) REFERENCES `members` (`ID`),
  ADD CONSTRAINT `FK_QUERY_ID` FOREIGN KEY (`query_Id`) REFERENCES `ask` (`query_Id`);

--
-- Constraints for table `ask`
--
ALTER TABLE `ask`
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`askedBy`) REFERENCES `members` (`ID`);

--
-- Constraints for table `debate`
--
ALTER TABLE `debate`
  ADD CONSTRAINT `debate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `members` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `debate_comments`
--
ALTER TABLE `debate_comments`
  ADD CONSTRAINT `debate_comments_ibfk_1` FOREIGN KEY (`debate_id`) REFERENCES `debate` (`debate_id`),
  ADD CONSTRAINT `debate_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `members` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `members` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `private_questions`
--
ALTER TABLE `private_questions`
  ADD CONSTRAINT `FK_PRIVATE_QUERY_ID` FOREIGN KEY (`query_id`) REFERENCES `ask` (`query_Id`),
  ADD CONSTRAINT `FK_PRIVATE_QUERY_USER_ID` FOREIGN KEY (`asked_to`) REFERENCES `members` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
