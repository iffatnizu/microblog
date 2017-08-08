-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 31, 2013 at 12:53 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cpr_microblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_deactivate_reason`
--

CREATE TABLE IF NOT EXISTS `tbl_account_deactivate_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_account_deactivate_reason`
--

INSERT INTO `tbl_account_deactivate_reason` (`id`, `reason`) VALUES
(1, 'I get too many emails, invitations, and requests from microblog.'),
(2, 'I have a privacy concern.'),
(3, 'I don''t feel safe on microblog.'),
(4, 'This is temporary. I''ll be back.'),
(5, 'I have another microblog account.'),
(6, 'I don''t find microblog useful.'),
(7, 'My account was hacked.'),
(8, 'I don''t understand how to use microblog.'),
(9, 'I spend too much time using microblog.'),
(10, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `adminUsername` varchar(200) NOT NULL,
  `adminPassword` varchar(200) NOT NULL,
  `adminLastLoginTime` varchar(200) NOT NULL,
  `adminIsActive` enum('0','1') NOT NULL,
  `adminPreviledge` enum('1','2','3','4','5') NOT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminId`, `adminUsername`, `adminPassword`, `adminLastLoginTime`, `adminIsActive`, `adminPreviledge`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '1377926465', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ads`
--

CREATE TABLE IF NOT EXISTS `tbl_ads` (
  `adId` int(11) NOT NULL AUTO_INCREMENT,
  `adFileName` varchar(250) NOT NULL,
  `adScript` text NOT NULL,
  `adLink` text NOT NULL,
  `adIsActive` enum('0','1') NOT NULL,
  `adType` int(11) NOT NULL,
  `addedDate` bigint(20) NOT NULL,
  PRIMARY KEY (`adId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_ads`
--

INSERT INTO `tbl_ads` (`adId`, `adFileName`, `adScript`, `adLink`, `adIsActive`, `adType`, `addedDate`) VALUES
(6, '5219daf3e3e4fad-1.png', '', 'www.google.com', '1', 2, 1377426163),
(7, '5219dafb7288ead-1.png', '', 'www.google.com', '1', 2, 1377426171);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_message`
--

CREATE TABLE IF NOT EXISTS `tbl_chat_message` (
  `chatId` bigint(20) NOT NULL AUTO_INCREMENT,
  `profileId` int(11) NOT NULL COMMENT 'user profile id',
  `senderId` int(11) NOT NULL COMMENT 'who send the first msg',
  `chatMessage` text NOT NULL,
  `receiverId` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `isRead` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`chatId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_chat_message`
--

INSERT INTO `tbl_chat_message` (`chatId`, `profileId`, `senderId`, `chatMessage`, `receiverId`, `time`, `isRead`) VALUES
(1, 1, 6, 'hello', 1, 0, '1'),
(2, 1, 1, 'hi', 1, 0, '1'),
(3, 1, 1, 'hello test ch3eck', 6, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `commentId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `feedId` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `userId` (`userId`),
  KEY `feedId` (`feedId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`commentId`, `userId`, `feedId`, `comment`) VALUES
(1, 1, 1, 'Action Looking So Nice'),
(4, 1, 1, 'Its bravo dude supper action.'),
(6, 1, 1, 'Established your career will be distracted.'),
(13, 1, 5, '<p>khamsaya.com er signup kaz korche na ki hoiche ektu dekhte hobe</p>'),
(14, 1, 18, 'gf'),
(15, 1, 18, 'g'),
(16, 1, 18, 'fgfg'),
(17, 1, 9, 'dssd'),
(18, 1, 10, 'hello'),
(21, 1, 1, 'fffff'),
(22, 1, 1, 'hhh'),
(23, 1, 8, 'erer'),
(24, 1, 8, 'ertre'),
(25, 1, 7, 'rrer'),
(26, 1, 8, 'ert'),
(27, 1, 7, 'ert'),
(28, 1, 6, 'ertr'),
(29, 1, 5, 'erer'),
(30, 1, 4, 'rteret'),
(31, 1, 3, 'erttr'),
(33, 1, 1, 'sdsdfds'),
(34, 1, 1, 'aakram'),
(35, 1, 1, 'k'),
(36, 1, 18, ','),
(37, 1, 3, 'hey you<br>'),
(38, 6, 18, 'hjug'),
(39, 1, 18, 'dsfs ad asd as a asd a<br><br><br>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_connection`
--

CREATE TABLE IF NOT EXISTS `tbl_connection` (
  `connectionId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId1` bigint(20) NOT NULL,
  `userId2` bigint(20) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Pending, 1=Accepted',
  PRIMARY KEY (`connectionId`),
  KEY `userId1` (`userId1`),
  KEY `userId2` (`userId2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_connection`
--

INSERT INTO `tbl_connection` (`connectionId`, `userId1`, `userId2`, `status`) VALUES
(1, 1, 2, '1'),
(2, 1, 3, '1'),
(3, 1, 5, '1'),
(4, 6, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE IF NOT EXISTS `tbl_content` (
  `contentId` int(11) NOT NULL AUTO_INCREMENT,
  `contentName` text NOT NULL,
  `contentTitle` tinytext NOT NULL,
  `contentDetails` longtext NOT NULL,
  PRIMARY KEY (`contentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_content`
--

INSERT INTO `tbl_content` (`contentId`, `contentName`, `contentTitle`, `contentDetails`) VALUES
(1, 'help', 'This is help title', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n'),
(3, 'about', 'This is about us title', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n'),
(4, 'terms', 'Terms and Condition', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),
(5, 'privacy', 'Privacy Policy', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deleted_account`
--

CREATE TABLE IF NOT EXISTS `tbl_deleted_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `deleteReasonId` tinytext NOT NULL,
  `explantion` text NOT NULL,
  `time` bigint(20) NOT NULL,
  `isReturn` int(11) NOT NULL DEFAULT '0',
  `returnTime` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_deleted_account`
--

INSERT INTO `tbl_deleted_account` (`id`, `userId`, `deleteReasonId`, `explantion`, `time`, `isReturn`, `returnTime`) VALUES
(1, 1, '5', ' I spend too much time using microblog. ', 1377942198, 1, 1377942887),
(2, 1, '4', ' This is temporary. I''ll be back. ', 1377942860, 1, 1377942887);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed`
--

CREATE TABLE IF NOT EXISTS `tbl_feed` (
  `feedId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `feedText` text NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `postDate` bigint(20) NOT NULL,
  PRIMARY KEY (`feedId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_feed`
--

INSERT INTO `tbl_feed` (`feedId`, `userId`, `feedText`, `imageName`, `postDate`) VALUES
(1, 1, '', 'demo-post-pic-1.jpg', 1374607315),
(3, 1, '', '33c99a2b281fe21f2239ee3af77ffd4a.jpg', 1375339785),
(4, 1, 'test it dude.', '', 1375342968),
(5, 1, 'Testing my luck.', '', 1376768588),
(6, 1, 'khamsaya.com er signup kaz korche na ki hoiche ektu dekhte hobe', '', 1377323288),
(7, 1, 'You status Successfully inserted.You did not select a file to upload.OR Maybe not post any status', '', 1377323337),
(8, 1, 'Application means one or more of the Atlassian software applications listed above or such other software application as notified by Atlassian from time to time', '', 1377323377),
(9, 1, 'Atlassian means Atlassian Pty Ltd (ABN 53 102 443 916) of 173-185 Sussex Street, Sydney, New South Wales 2000 Australia.', '', 1377323399),
(10, 6, 'As part of the Service, Atlassian will provide the Subscriber with use of the Service, including a browser interface and data transmission, access and storage. Subscriber''s registration for, or use of, the Service shall be deemed to be agreement to abide by these Terms of Use ("Agreement") including any materials and terms available on the Atlassian website incorporated by reference herein, including but not limited to Atlassian''s privacy and security policies.', '', 1377323421),
(11, 6, 'Service means hosting of the specific Atlassian software Application identified during the ordering process, developed or licensed, operated, and maintained by Atlassian, accessible via www.atlassian.com or another designated Atlassian web site or IP address, or ancillary online or offline products and services provided to Subscriber by Atlassian, to which Subscriber is being granted access under this Agreement.', '', 1377323773),
(12, 6, '3.1. Terms of Service. Subscriber acknowledges and agrees to the terms of service herein. In addition, Subscriber agrees that unless explicitly stated otherwise, any new features that augment or enhance the Service, and/or any new Service(s) subsequently purchased by the Subscriber will be subject to this Agreement.', '', 1377323793),
(13, 1, 'User means Subscriber''s employees, representatives, consultants, contractors, customers or agents who are authorized to use the Service and have been supplied user identifications and passwords by Subscriber (or by or for Atlassian at Subscriber''s request).', '', 1377323868),
(14, 6, '3.4. Email And Notices. Subscriber agrees to provide Atlassian with Subscriber''s e-mail address, to promptly provide Atlassian with any changes to Subscriber''s e-mail address, and to accept emails (or other electronic communications) from Atlassian at the e-mail address Subscriber specifies. Except as otherwise provided in this Agreement, Subscriber further agrees that Atlassian may provide any and all notices, statements, and other communications to Subscriber through either e-mail or posting on the Service.', '', 1377323985),
(15, 6, '3.5. Passwords, Access, And Notification. The maximum number of Users that Subscriber may designate under Subscriber''s account is the number of seats purchased by Subscriber, and Subscriber may provide and assign unique passwords and User names to each authorized User for each seat purchased. Subscriber acknowledges and agrees that Subscriber is prohibited from sharing passwords and/or User names with unauthorized users. Subscriber will be responsible for the confidentiality and use of Subscriber''s (including its employees'') passwords and User names.', '', 1377323994),
(16, 6, '3.7. Transmission Of Data. Atlassian employs security measures designed for the protection of information and data (see http://www.atlassian.com/hosted/security.jsp) However, Subscriber understands that the technical processing and transmission of Subscriber''s electronic communications is fundamentally necessary to Subscriber''s use of the Service. Subscriber agrees that Atlassian is not responsible for any electronic communications and/or Subscriber Data which are lost, altered, intercepted or stored without authorization during the transmission of any data whatsoever across networks not owned and/or operated by Atlassian.', '', 1377324004),
(17, 6, '3.11. Storage Limits. Subscriber acknowledges and agrees that Atlassian is not required to set the amount of database storage used; however, Atlassian retains the right, in its sole discretion, to create limits or change limits at any time and with or without notice. The storage limits set forth in this section 3.10 shall apply to all Services provided under this Agreement except for the software application of Bitbucket. Atlassian currently limits the amount of database storage as set forth in the relevant Order Form. Every account has a set amount of storage space as defined by the gigabytes of storage included in the package you select. Accounts that exceed that amount will be billed an over limit fee of $1.00 per gigabyte per month, or if different, the then-current fee. Storage capacity is only sold in blocks of 1 gigabytes. Any use of storage capacity over the specified limit will trigger the next $1.00 (or then-current) over-limit penalty amount.', '', 1377324049),
(18, 1, 'b. Atlassian may, without prior notice, change the Service; stop providing the Service or features of the Service, to subscribers or to users generally; or create/change usage limits for the Service. Atlassian may permanently or temporarily terminate or suspend Subscriber access to the Service without notice and liability for any reason, including if in Atlassian''s sole determination Subscriber violates any provision of this Agreement, or for no reason. Upon termination for any reason or no reason, Subscriber continues to be bound by this Agreement.', '', 1377324086);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follower`
--

CREATE TABLE IF NOT EXISTS `tbl_follower` (
  `followId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `followerId` bigint(20) NOT NULL,
  PRIMARY KEY (`followId`),
  KEY `userId` (`userId`),
  KEY `followerId` (`followerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_follower`
--

INSERT INTO `tbl_follower` (`followId`, `userId`, `followerId`) VALUES
(7, 6, 5),
(8, 6, 3),
(11, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_like`
--

CREATE TABLE IF NOT EXISTS `tbl_like` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `feedId` bigint(20) NOT NULL,
  `likeType` enum('1','-1') NOT NULL COMMENT '1=Like, -1=Dislike',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `feedId` (`feedId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_like`
--

INSERT INTO `tbl_like` (`id`, `userId`, `feedId`, `likeType`) VALUES
(1, 1, 18, '-1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reported_posts`
--

CREATE TABLE IF NOT EXISTS `tbl_reported_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedId` int(11) NOT NULL,
  `reportBy` int(11) NOT NULL,
  `reportReason` text NOT NULL,
  `time` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_reported_posts`
--

INSERT INTO `tbl_reported_posts` (`id`, `feedId`, `reportBy`, `reportReason`, `time`) VALUES
(1, 18, 6, 'Why you want to report this user ? write a short description', 1377501730);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reported_users`
--

CREATE TABLE IF NOT EXISTS `tbl_reported_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `reportBy` int(11) NOT NULL,
  `reportReason` text NOT NULL,
  `time` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteTitle` varchar(250) NOT NULL,
  `siteMetaKeyword` text NOT NULL,
  `siteMetaDescription` text NOT NULL,
  `siteLogo` varchar(200) NOT NULL,
  `siteEmail` varchar(50) NOT NULL,
  `sitePhone` varchar(100) NOT NULL,
  `siteVendorLogo` varchar(200) NOT NULL,
  `siteDisplayAdsNo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `siteTitle`, `siteMetaKeyword`, `siteMetaDescription`, `siteLogo`, `siteEmail`, `sitePhone`, `siteVendorLogo`, `siteDisplayAdsNo`) VALUES
(1, 'Microblog', 'microblog, services, restaurent', 'Your social microblog', '5200883fe95cbbg-invite.gif', 'admin@microblog.com', '1-555-555-555', '51f3702766aaabveyron.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `userId` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'User Auto Incriment Id',
  `name` varchar(255) NOT NULL COMMENT 'User Full Name',
  `email` varchar(255) NOT NULL COMMENT 'User Registered Email Address',
  `password` varchar(255) NOT NULL COMMENT 'User Login password',
  `registrationDate` bigint(20) NOT NULL COMMENT 'User Registration Date',
  `lastLoginDate` bigint(20) NOT NULL COMMENT 'User Last Login Date',
  `lastLoginIP` varchar(255) NOT NULL COMMENT 'Last Login IP Address',
  `isActive` enum('0','1') NOT NULL COMMENT '0=Inactive, 1=Active',
  `isDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userId`, `name`, `email`, `password`, `registrationDate`, `lastLoginDate`, `lastLoginIP`, `isActive`, `isDeleted`) VALUES
(1, 'Michael Peterson', 'michael@corepiler.com', '4297f44b13955235245b2497399d7a93', 1374346236, 1377943826, '::1', '1', 0),
(2, 'Leonardo Dicaprio', 'leonardo@corepiler.com', '4297f44b13955235245b2497399d7a93', 1374346426, 1377943690, '::1', '1', 0),
(3, 'Kate Winslet', 'kate@corepiler.com', '4297f44b13955235245b2497399d7a93', 1374607187, 1374696387, '127.0.0.1', '1', 0),
(4, 'Vin Diesel', 'vindiesel@corepiler.com', '4297f44b13955235245b2497399d7a93', 1374607315, 0, '', '1', 0),
(5, 'Paul Walker', 'paul@corepiler.com', '4297f44b13955235245b2497399d7a93', 1374607396, 0, '', '1', 0),
(6, 'akram', 'akram@corepiler.com', '4297f44b13955235245b2497399d7a93', 1377322155, 1377946148, '::1', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE IF NOT EXISTS `tbl_user_info` (
  `userInfoId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `coverImage` varchar(255) NOT NULL,
  PRIMARY KEY (`userInfoId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`userInfoId`, `userId`, `profileImage`, `coverImage`) VALUES
(1, 1, 'michael_peterson1.png', 'michael_peterson1.png'),
(2, 2, 'pro-pic-2.png', ''),
(3, 3, 'Kate-Winslet.jpg', ''),
(4, 4, 'Vin-Diesel.jpg', ''),
(5, 5, 'paul-walker.jpg', ''),
(6, 6, 'akram.png', 'akram1.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `tbl_comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`),
  ADD CONSTRAINT `tbl_comment_ibfk_2` FOREIGN KEY (`feedId`) REFERENCES `tbl_feed` (`feedId`);

--
-- Constraints for table `tbl_connection`
--
ALTER TABLE `tbl_connection`
  ADD CONSTRAINT `tbl_connection_ibfk_1` FOREIGN KEY (`userId1`) REFERENCES `tbl_user` (`userId`),
  ADD CONSTRAINT `tbl_connection_ibfk_2` FOREIGN KEY (`userId2`) REFERENCES `tbl_user` (`userId`);

--
-- Constraints for table `tbl_feed`
--
ALTER TABLE `tbl_feed`
  ADD CONSTRAINT `tbl_feed_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`);

--
-- Constraints for table `tbl_follower`
--
ALTER TABLE `tbl_follower`
  ADD CONSTRAINT `tbl_follower_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`),
  ADD CONSTRAINT `tbl_follower_ibfk_2` FOREIGN KEY (`followerId`) REFERENCES `tbl_user` (`userId`);

--
-- Constraints for table `tbl_like`
--
ALTER TABLE `tbl_like`
  ADD CONSTRAINT `tbl_like_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`),
  ADD CONSTRAINT `tbl_like_ibfk_2` FOREIGN KEY (`feedId`) REFERENCES `tbl_feed` (`feedId`);

--
-- Constraints for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD CONSTRAINT `tbl_user_info_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
