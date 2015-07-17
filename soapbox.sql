-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 17, 2015 at 01:14 PM
-- Server version: 5.5.38
-- PHP Version: 5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `soapbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

CREATE TABLE `activitylog` (
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL,
  `ref` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activitylog`
--

INSERT INTO `activitylog` (`description`, `timestamp`, `type`, `ref`, `uid`) VALUES
('Created a new thread "Meditation: path to a peaceful life!"', '2015-04-28 09:25:19', 3, 100, 10000),
('Created a new thread "DOTA 2"', '2015-04-28 09:25:23', 3, 101, 10001),
('Created a new thread "Pt. Bhimsen Joshi"', '2015-04-28 09:26:46', 3, 102, 10000),
('Created a new thread "Look at those birds."', '2015-04-28 09:27:03', 3, 103, 10002),
('Created a new thread "Zakir bhai"', '2015-04-28 09:27:14', 3, 104, 10001),
('Created a new thread "Crazy ones"', '2015-04-28 09:28:07', 3, 105, 10001),
('Created a new thread "Challenges before Modi regime!"', '2015-04-28 09:28:07', 3, 106, 10000),
('Created a new thread "New York"', '2015-04-28 09:29:15', 3, 107, 10001),
('Created a new thread "Counter Strike open IP''s are here... Have fun."', '2015-04-28 09:29:19', 3, 108, 10002),
('Created a new thread "Review: Porcupine Tree''s "Fear of the blank planet""', '2015-04-28 09:29:59', 3, 109, 10000),
('Created a new thread "old is gold"', '2015-04-28 09:30:46', 3, 110, 10002),
('Created a new thread "House of Cards Season 3"', '2015-04-28 09:31:41', 3, 111, 10000),
('Created a new thread "Social networking: curse or boon?"', '2015-04-28 09:32:52', 3, 112, 10002),
('Created a new thread "JSON Lesson 1"', '2015-04-28 09:33:26', 3, 113, 10001),
('Created a new thread "Expanded Consciousness"', '2015-04-28 09:34:18', 3, 114, 10000),
('Created a new thread "hey hey hey! My first working program. "', '2015-04-28 09:34:52', 3, 115, 10002),
('Created a new thread "SImplified: How to start apache service?"', '2015-04-28 09:35:49', 3, 116, 10000),
('Created a new thread "Ipod"', '2015-04-28 09:36:15', 3, 117, 10001),
('Created a new thread "Breaking Bad Season 6 is just a rumor!"', '2015-04-28 09:37:51', 3, 118, 10000),
('Created a new thread "instructions before going to gym!"', '2015-04-28 09:38:01', 3, 119, 10002),
('Created a new thread "Chess"', '2015-04-28 09:38:41', 3, 120, 10001),
('Upvoted instructions before going to gym!', '2015-04-28 09:39:05', 0, 1, 10000),
('Upvoted SImplified: How to start apache service?', '2015-04-28 09:39:14', 0, 2, 10001),
('Left a reply on instructions before going to gym!', '2015-04-28 09:39:24', 1, 1, 10000),
('Created a new thread "We miss you Paul Walker."', '2015-04-28 09:39:26', 3, 121, 10002),
('Left a reply on SImplified: How to start apache service?', '2015-04-28 09:39:27', 1, 2, 10001),
('Upvoted We miss you Paul Walker.', '2015-04-28 09:39:34', 0, 3, 10001),
('Upvoted hey hey hey! My first working program. ', '2015-04-28 09:39:38', 0, 4, 10000),
('Left a reply on hey hey hey! My first working program. ', '2015-04-28 09:40:13', 1, 3, 10000),
('Upvoted Chess', '2015-04-28 09:40:33', 0, 5, 10002),
('Upvoted Ipod', '2015-04-28 09:40:38', 0, 6, 10000),
('Left a reply on Ipod', '2015-04-28 09:40:52', 1, 4, 10000),
('Left a reply on We miss you Paul Walker.', '2015-04-28 09:41:08', 1, 5, 10001),
('Left a reply on Chess', '2015-04-28 09:41:13', 1, 6, 10002),
('Upvoted Breaking Bad Season 6 is just a rumor!', '2015-04-28 09:41:23', 0, 7, 10002),
('Upvoted hey hey hey! My first working program. ', '2015-04-28 09:41:28', 0, 8, 10001),
('Left a reply on JSON Lesson 1', '2015-04-28 09:41:32', 1, 7, 10000),
('Left a reply on Counter Strike open IP''s are here... Have fun.', '2015-04-28 09:42:04', 1, 8, 10000),
('Upvoted Counter Strike open IP''s are here... Have fun.', '2015-04-28 09:42:05', 0, 9, 10000),
('Left a reply on hey hey hey! My first working program. ', '2015-04-28 09:42:17', 1, 9, 10001),
('Left a reply on Breaking Bad Season 6 is just a rumor!', '2015-04-28 09:42:18', 1, 10, 10002),
('Upvoted Review: Porcupine Tree''s "Fear of the blank planet"', '2015-04-28 09:42:26', 0, 10, 10001),
('Upvoted Ipod', '2015-04-28 09:42:27', 0, 11, 10002),
('Left a comment on a reply to Breaking Bad Season 6 is just a rumor!', '2015-04-28 09:42:41', 2, 1, 10000),
('Left a reply on Ipod', '2015-04-28 09:42:55', 1, 11, 10002),
('Left a reply on Social networking: curse or boon?', '2015-04-28 09:43:04', 1, 12, 10000),
('Upvoted Social networking: curse or boon?', '2015-04-28 09:43:08', 0, 12, 10000),
('Left a reply on Review: Porcupine Tree''s "Fear of the blank planet"', '2015-04-28 09:43:12', 1, 13, 10001),
('Left a comment on a reply to SImplified: How to start apache service?', '2015-04-28 09:43:15', 2, 2, 10002),
('Upvoted SImplified: How to start apache service?', '2015-04-28 09:43:18', 0, 13, 10002),
('Upvoted a reply to hey hey hey! My first working program. ', '2015-04-28 09:43:42', 4, 1, 10002),
('Upvoted a reply to hey hey hey! My first working program. ', '2015-04-28 09:43:45', 4, 2, 10002),
('Upvoted DOTA 2', '2015-04-28 09:43:56', 0, 14, 10000),
('Left a comment on a reply to hey hey hey! My first working program. ', '2015-04-28 09:44:00', 2, 3, 10002),
('Left a comment on a reply to hey hey hey! My first working program. ', '2015-04-28 09:44:03', 2, 4, 10002),
('Upvoted JSON Lesson 1', '2015-04-28 09:44:09', 0, 15, 10002),
('Left a reply on DOTA 2', '2015-04-28 09:44:09', 1, 14, 10000),
('Left a reply on Social networking: curse or boon?', '2015-04-28 09:44:28', 1, 15, 10001),
('Left a reply on JSON Lesson 1', '2015-04-28 09:44:42', 1, 16, 10002),
('Left a comment on a reply to hey hey hey! My first working program. ', '2015-04-28 09:44:49', 2, 5, 10000),
('Left a comment on a reply to Social networking: curse or boon?', '2015-04-28 09:45:04', 2, 6, 10002),
('Upvoted a reply to Social networking: curse or boon?', '2015-04-28 09:45:12', 4, 3, 10002),
('Left a reply on House of Cards Season 3', '2015-04-28 09:45:45', 1, 17, 10002),
('Left a comment on a reply to House of Cards Season 3', '2015-04-28 09:46:00', 2, 7, 10000),
('Created a new thread "Sketch"', '2015-04-28 09:46:11', 3, 122, 10001),
('Left a comment on a reply to House of Cards Season 3', '2015-04-28 09:46:11', 2, 8, 10002),
('Created a new thread "Sizzlers"', '2015-04-28 09:47:48', 3, 123, 10001),
('Left a reply on Review: Porcupine Tree''s "Fear of the blank planet"', '2015-04-28 09:48:14', 1, 18, 10002),
('Left a comment on a reply to DOTA 2', '2015-04-28 09:48:52', 2, 9, 10001),
('Left a comment on a reply to DOTA 2', '2015-04-28 09:49:26', 2, 10, 10002),
('Created a new thread "Steve Jobs Just Before Death"', '2015-04-28 09:50:22', 3, 124, 10001),
('Left a reply on Sizzlers', '2015-04-28 09:50:44', 1, 19, 10002),
('Upvoted Steve Jobs Just Before Death', '2015-04-28 09:51:09', 0, 16, 10002),
('Left a reply on Steve Jobs Just Before Death', '2015-04-28 09:51:22', 1, 20, 10002),
('Created a new thread "Nostalgic an ode to college life"', '2015-04-28 09:52:00', 3, 125, 10001),
('Created a new thread "INTJ: There are no rules."', '2015-04-28 09:52:50', 3, 126, 10000),
('Created a new thread "Ga Di Madgulkar "', '2015-04-28 09:52:58', 3, 127, 10001),
('Upvoted INTJ: There are no rules.', '2015-04-28 09:53:23', 0, 17, 10001),
('Upvoted INTJ: There are no rules.', '2015-04-28 09:53:34', 0, 18, 10002),
('Left a reply on hey hey hey! My first working program. ', '2015-04-28 10:03:55', 1, 21, 10001),
('Created a new thread "9gag  is your best source of fun!"', '2015-04-28 10:36:28', 3, 128, 10003),
('Upvoted 9gag  is your best source of fun!', '2015-04-28 10:37:57', 0, 19, 10001),
('Left a reply on 9gag  is your best source of fun!', '2015-04-28 10:39:48', 1, 22, 10001),
('Left a reply on SImplified: How to start apache service?', '2015-04-28 10:41:44', 1, 23, 10001),
('Created a new thread "Creme Brulee"', '2015-05-28 12:46:32', 3, 129, 10001),
('Upvoted Creme Brulee', '2015-05-28 12:47:30', 0, 20, 10003),
('Left a comment on a reply to Social networking: curse or boon?', '2015-05-29 05:34:27', 2, 11, 10001),
('Left a comment on a reply to Social networking: curse or boon?', '2015-05-29 05:34:32', 2, 12, 10001),
('Created a new thread "My first C Program"', '2015-06-27 08:19:15', 3, 130, 10001),
('Created a new thread "dasd"', '2015-06-27 08:23:56', 3, 131, 10004),
('Upvoted dasd', '2015-06-27 08:25:45', 0, 21, 10001),
('Left a reply on dasd', '2015-06-27 08:25:59', 1, 24, 10001),
('Left a comment on a reply to dasd', '2015-06-27 08:26:14', 2, 13, 10004),
('Upvoted Sizzlers', '2015-07-02 14:45:20', 0, 22, 10005),
('Left a reply on Sizzlers', '2015-07-02 14:45:36', 1, 25, 10005),
('Upvoted Breaking Bad Season 6 is just a rumor!', '2015-07-02 14:46:31', 0, 23, 10005),
('Upvoted Ipod', '2015-07-02 14:47:02', 0, 24, 10005),
('Upvoted Ga Di Madgulkar ', '2015-07-10 12:47:33', 0, 25, 10001),
('Upvoted My first C Program', '2015-07-17 03:21:41', 0, 26, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
`srno` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `imagepath` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`srno`, `name`, `imagepath`) VALUES
(1, 'Books', 'categories/books.jpg'),
(2, 'Business', 'categories/business.jpg'),
(3, 'Cooking', 'categories/cooking.jpg'),
(4, 'Design', 'categories/design.jpg'),
(5, 'Economics', 'categories/economics.jpg'),
(6, 'Education', 'categories/education.jpg'),
(7, 'Fine Arts', 'categories/finearts.jpg'),
(8, 'Food', 'categories/food.jpg'),
(9, 'Gaming', 'categories/gaming.jpg'),
(10, 'Health & Fitness', 'categories/health.jpg'),
(11, 'History', 'categories/history.jpg'),
(12, 'Life Coaching', 'categories/lifecoach.png'),
(13, 'Mathematics', 'categories/mathematics.jpg'),
(14, 'Movies', 'categories/movies.jpg'),
(15, 'Music', 'categories/music.jpg'),
(16, 'Nature & Wildlife', 'categories/nature.jpg'),
(17, 'Philosophy', 'categories/philosophy.jpg'),
(18, 'Photography', 'categories/photography.jpg'),
(19, 'Politics', 'categories/politics.jpg'),
(20, 'Programming', 'categories/program.jpg'),
(21, 'Psychology', 'categories/psychology.jpg'),
(22, 'Science', 'categories/science.jpg'),
(23, 'Spirituality', 'categories/spirituality.jpg'),
(24, 'Sports', 'categories/sports.jpg'),
(25, 'Technology', 'categories/technology.jpg'),
(26, 'Traveling', 'categories/travel.jpg'),
(27, 'TV Shows', 'categories/tvseries.jpg'),
(28, 'Writing', 'categories/writing.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category_user`
--

CREATE TABLE `category_user` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_user`
--

INSERT INTO `category_user` (`cid`, `uid`) VALUES
(1, 10000),
(7, 10000),
(2, 10000),
(8, 10000),
(10, 10000),
(9, 10000),
(12, 10000),
(11, 10000),
(15, 10000),
(20, 10000),
(19, 10000),
(23, 10000),
(17, 10000),
(21, 10000),
(27, 10000),
(25, 10000),
(26, 10000),
(3, 10002),
(8, 10002),
(12, 10002),
(9, 10002),
(13, 10002),
(15, 10002),
(16, 10002),
(20, 10002),
(24, 10002),
(21, 10002),
(22, 10002),
(23, 10002),
(18, 10002),
(25, 10002),
(26, 10002),
(27, 10002),
(9, 10003),
(10, 10003),
(11, 10003),
(12, 10003),
(15, 10003),
(19, 10003),
(20, 10003),
(21, 10003),
(23, 10003),
(25, 10003),
(26, 10003),
(27, 10003),
(3, 10003),
(1, 10004),
(4, 10004),
(3, 10004),
(14, 10004),
(15, 10004),
(27, 10004),
(25, 10004),
(8, 10005),
(15, 10005),
(14, 10005),
(22, 10005),
(27, 10005),
(26, 10005),
(1, 10001),
(3, 10001),
(4, 10001),
(7, 10001),
(9, 10001),
(12, 10001),
(14, 10001),
(15, 10001),
(20, 10001),
(21, 10001),
(22, 10001),
(23, 10001),
(24, 10001),
(25, 10001),
(28, 10001),
(8, 10001),
(2, 10006),
(3, 10006),
(4, 10006),
(8, 10006),
(9, 10006),
(14, 10006),
(15, 10006),
(16, 10006),
(20, 10006),
(24, 10006);

-- --------------------------------------------------------

--
-- Table structure for table `extendedinfo`
--

CREATE TABLE `extendedinfo` (
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `avatarpath` text,
  `email` varchar(320) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `question` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `hometown` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `profession` varchar(30) DEFAULT NULL,
  `education` varchar(30) DEFAULT NULL,
  `college` varchar(30) DEFAULT NULL,
  `school` varchar(30) DEFAULT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `extendedinfo`
--

INSERT INTO `extendedinfo` (`fname`, `lname`, `avatarpath`, `email`, `gender`, `about`, `question`, `answer`, `hometown`, `city`, `profession`, `education`, `college`, `school`, `uid`) VALUES
('Abhishek', 'Sane', 'images/avatar_male.png', 'abhisane@gmail.com', 'm', '', 0, 'd76f3d05cc9ac98f1f9160274a39fe33', '', '', '', '', '', '', 10004),
('Chinmay', 'Joshi', 'userdata/10002/IMG_011648463_-_1432816368.JPG', 'chinmayj93@gmail.com', 'm', '', 0, '170ff3dc309569e660f248915dcc469b', 'Pune', 'Pune', 'Student', 'Computer Science', 'MIT', 'Abhinav Vidyalay', 10002),
('Atharva', 'Dandekar', 'userdata/10001/image39832_-_1430215517.jpg', 'dandekar.atharva@gmail.com', 'm', 'Altruistic Punk', 1, '70ede688a4ff6f69af05559c94e5d156', 'Mumbai', 'Pune', 'Web Developer', 'M. Sc Computer Science', 'MIT', 'St Teresa High School', 10001),
('Mihir', 'Karandikar', 'userdata/10000/avatar_mihir6385_-_1430213912.jpg', 'karandikar.mihir@outlook.com', 'm', 'Just another programmer in town! Passionate about music and knowledge!', 0, '65079b006e85a7e798abecb99e47c154', 'Pune', 'Pune', 'Web Developer', 'Graduate', 'MIT, Pune', 'MIT, Pune', 10000),
('Nihar', 'Dandekar', 'userdata/10006/image.jpg', 'nihar.dandekar@gmail.com', 'm', 'Thinking Different', 1, '70ede688a4ff6f69af05559c94e5d156', 'Mumbai', 'Sunnyvale', 'Web Developer', 'Master is SE', 'San Jose', 'St Teresa High School', 10006),
('Nikita', 'Pethe', 'userdata/10003/IMG_338429943_-_1432816561.JPG', 'nikipethe@gmail.com', 'f', '', 0, '587c8d2a43ec581df67365aac7ed819f', 'Pune', '', '', '', '', '', 10003),
('Tamanna', 'Ainarkar', 'userdata/10005/thumb_IMG_1685_1024.jpg', 'tamannarock@gmail.com', 'f', '', 0, 'c10b226cbedaa202da9b721c42fa37aa', 'Pune', '', '', '', '', '', 10005);

-- --------------------------------------------------------

--
-- Table structure for table `hidethread`
--

CREATE TABLE `hidethread` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `description` text NOT NULL,
  `type` int(11) NOT NULL,
  `ref` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `readflag` int(11) DEFAULT '0',
  `sent` int(11) DEFAULT '0',
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`description`, `type`, `ref`, `timestamp`, `readflag`, `sent`, `uid`) VALUES
('Mihir Karandikar upvoted your thread', 3, 1, '2015-04-28 09:39:05', 1, 1, 10002),
('Atharva Dandekar upvoted your thread', 3, 2, '2015-04-28 09:39:14', 1, 1, 10000),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 1, '2015-04-28 09:39:24', 1, 1, 10002),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 2, '2015-04-28 09:39:27', 1, 1, 10000),
('Atharva Dandekar upvoted your thread', 3, 3, '2015-04-28 09:39:34', 1, 1, 10002),
('Mihir Karandikar upvoted your thread', 3, 4, '2015-04-28 09:39:38', 1, 1, 10002),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 3, '2015-04-28 09:40:13', 1, 1, 10002),
('Chinmay Joshi upvoted your thread', 3, 5, '2015-04-28 09:40:33', 1, 1, 10001),
('Mihir Karandikar upvoted your thread', 3, 6, '2015-04-28 09:40:38', 1, 1, 10001),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 4, '2015-04-28 09:40:52', 1, 1, 10001),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 5, '2015-04-28 09:41:08', 1, 1, 10002),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 6, '2015-04-28 09:41:13', 1, 1, 10001),
('Chinmay Joshi upvoted your thread', 3, 7, '2015-04-28 09:41:23', 1, 1, 10000),
('Atharva Dandekar upvoted your thread', 3, 8, '2015-04-28 09:41:28', 1, 1, 10002),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 7, '2015-04-28 09:41:32', 1, 1, 10001),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 8, '2015-04-28 09:42:04', 1, 1, 10002),
('Mihir Karandikar upvoted your thread', 3, 9, '2015-04-28 09:42:05', 1, 1, 10002),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 9, '2015-04-28 09:42:17', 1, 1, 10002),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 10, '2015-04-28 09:42:18', 1, 1, 10000),
('Atharva Dandekar upvoted your thread', 3, 10, '2015-04-28 09:42:26', 1, 1, 10000),
('Chinmay Joshi upvoted your thread', 3, 11, '2015-04-28 09:42:27', 1, 1, 10001),
('Mihir Karandikar left a comment on your reply.', 2, 1, '2015-04-28 09:42:41', 1, 1, 10002),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 11, '2015-04-28 09:42:55', 1, 1, 10001),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 12, '2015-04-28 09:43:04', 1, 1, 10002),
('Mihir Karandikar upvoted your thread', 3, 12, '2015-04-28 09:43:08', 1, 1, 10002),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 13, '2015-04-28 09:43:12', 1, 1, 10000),
('Chinmay Joshi left a comment on your reply.', 2, 2, '2015-04-28 09:43:15', 1, 1, 10001),
('Chinmay Joshi upvoted your thread', 3, 13, '2015-04-28 09:43:18', 1, 1, 10000),
('Chinmay Joshi upvoted your reply on hey hey hey! My first working program. ', 4, 1, '2015-04-28 09:43:42', 1, 1, 10000),
('Chinmay Joshi upvoted your reply on hey hey hey! My first working program. ', 4, 2, '2015-04-28 09:43:45', 1, 1, 10001),
('@desc', 5, 9, '2015-04-28 09:43:48', 1, 1, 10001),
('Mihir Karandikar upvoted your thread', 3, 14, '2015-04-28 09:43:56', 1, 1, 10001),
('Chinmay Joshi left a comment on your reply.', 2, 3, '2015-04-28 09:44:00', 1, 1, 10001),
('Chinmay Joshi left a comment on your reply.', 2, 4, '2015-04-28 09:44:03', 1, 1, 10000),
('Chinmay Joshi upvoted your thread', 3, 15, '2015-04-28 09:44:09', 1, 1, 10001),
('Mihir Karandikar left a reply on a thread you are tracking', 1, 14, '2015-04-28 09:44:09', 1, 1, 10001),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 15, '2015-04-28 09:44:28', 1, 1, 10002),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 16, '2015-04-28 09:44:42', 1, 1, 10001),
('Mihir Karandikar left a comment on your reply.', 2, 5, '2015-04-28 09:44:49', 1, 1, 10001),
('Chinmay Joshi left a comment on your reply.', 2, 6, '2015-04-28 09:45:04', 1, 1, 10000),
('Chinmay Joshi upvoted your reply on Social networking: curse or boon?', 4, 3, '2015-04-28 09:45:12', 1, 1, 10001),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 17, '2015-04-28 09:45:45', 1, 1, 10000),
('Mihir Karandikar left a comment on your reply.', 2, 7, '2015-04-28 09:46:00', 1, 1, 10002),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 18, '2015-04-28 09:48:14', 1, 1, 10000),
('Atharva Dandekar left a comment on your reply.', 2, 9, '2015-04-28 09:48:52', 1, 1, 10000),
('Chinmay Joshi left a comment on your reply.', 2, 10, '2015-04-28 09:49:26', 1, 1, 10000),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 19, '2015-04-28 09:50:44', 1, 1, 10001),
('Chinmay Joshi upvoted your thread', 3, 16, '2015-04-28 09:51:09', 1, 1, 10001),
('Chinmay Joshi left a reply on a thread you are tracking', 1, 20, '2015-04-28 09:51:22', 1, 1, 10001),
('Atharva Dandekar upvoted your thread', 3, 17, '2015-04-28 09:53:23', 0, 1, 10000),
('Chinmay Joshi upvoted your thread', 3, 18, '2015-04-28 09:53:34', 0, 1, 10000),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 21, '2015-04-28 10:03:55', 1, 1, 10002),
('Atharva Dandekar upvoted your thread', 3, 19, '2015-04-28 10:37:57', 1, 1, 10003),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 22, '2015-04-28 10:39:48', 1, 1, 10003),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 23, '2015-04-28 10:41:44', 1, 1, 10000),
('@desc', 5, 23, '2015-04-28 10:41:56', 1, 1, 10001),
('Nikita Pethe upvoted your thread', 3, 20, '2015-05-28 12:47:30', 1, 1, 10001),
('Atharva Dandekar left a comment on your reply.', 2, 11, '2015-05-29 05:34:27', 0, 1, 10000),
('Atharva Dandekar upvoted your thread', 3, 21, '2015-06-27 08:25:45', 1, 1, 10004),
('Atharva Dandekar left a reply on a thread you are tracking', 1, 24, '2015-06-27 08:25:59', 1, 1, 10004),
('Abhishek Sane left a comment on your reply.', 2, 13, '2015-06-27 08:26:14', 1, 1, 10001),
('Tamanna Ainarkar upvoted your thread', 3, 22, '2015-07-02 14:45:20', 1, 1, 10001),
('Tamanna Ainarkar left a reply on a thread you are tracking', 1, 25, '2015-07-02 14:45:36', 1, 1, 10001),
('Tamanna Ainarkar left a reply on a thread you are tracking', 1, 25, '2015-07-02 14:45:36', 0, 0, 10002),
('Tamanna Ainarkar upvoted your thread', 3, 23, '2015-07-02 14:46:31', 0, 1, 10000),
('Tamanna Ainarkar upvoted your thread', 3, 24, '2015-07-02 14:47:02', 1, 1, 10001),
('Mihir Karandikar upvoted your thread', 3, 26, '2015-07-17 03:21:41', 1, 1, 10001);

-- --------------------------------------------------------

--
-- Table structure for table `readinglist`
--

CREATE TABLE `readinglist` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `readinglist`
--

INSERT INTO `readinglist` (`tid`, `uid`) VALUES
(101, 10000),
(119, 10000),
(128, 10001),
(113, 10002),
(117, 10002),
(118, 10002),
(123, 10002),
(124, 10002),
(124, 10003),
(125, 10003),
(128, 10003),
(129, 10004);

-- --------------------------------------------------------

--
-- Table structure for table `replies_to_reply`
--

CREATE TABLE `replies_to_reply` (
`srno` int(11) NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `replies_to_reply`
--

INSERT INTO `replies_to_reply` (`srno`, `description`, `timestamp`, `rid`, `uid`) VALUES
(1, 'No man >.', '2015-04-28 09:42:41', 10, 10000),
(2, 'same here. I wanted it too. You made it simple. :)', '2015-04-28 09:43:15', 2, 10002),
(3, 'thank you for add on... :)', '2015-04-28 09:44:00', 9, 10002),
(4, 'Nah', '2015-04-28 09:44:03', 3, 10002),
(5, 'you both are train wrecks. its int main() { return 0;}', '2015-04-28 09:44:49', 9, 10000),
(6, 'I agree with you mihir. ', '2015-04-28 09:45:04', 12, 10002),
(7, 'WAT WAT WAT', '2015-04-28 09:46:00', 17, 10000),
(8, 'oooing?', '2015-04-28 09:46:11', 17, 10002),
(9, 'but time flows, time moves', '2015-04-28 09:48:52', 14, 10001),
(10, 'huehuhue. i prefer strength and int. Agility are too mainstream. :P', '2015-04-28 09:49:26', 14, 10002),
(11, 'sdhjagshjdgajsd', '2015-05-29 05:34:27', 12, 10001),
(12, 'dasdasdasdas', '2015-05-29 05:34:32', 15, 10001),
(13, 'jhjhj', '2015-06-27 08:26:14', 24, 10004);

--
-- Triggers `replies_to_reply`
--
DELIMITER //
CREATE TRIGGER `ac_dRReply` AFTER DELETE ON `replies_to_reply`
 FOR EACH ROW begin 
set @uid = old.uid; 
set @rrid = old.srno; 
set @rid=old.rid;
set @rowner=(select uid from reply where srno=@rid);
delete from notifications where ref=@rrid and uid=@rowner and type=2;
delete from activitylog where ref=@rrid and uid=@uid and type=2; 
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iRReply` AFTER INSERT ON `replies_to_reply`
 FOR EACH ROW begin 
set @uid=new.uid; 
set @rrid=new.srno;
set @rid=new.rid; 
set @rowner=(select uid from reply where srno=@rid);
set @tid=(select tid from reply where srno=@rid); 
set @title=(select title from thread where srno=@tid);
set @desc=concat('Left a comment on a reply to ', @title); 
if @uid != @rowner then
set @rrowner=(select concat(fname, ' ', lname) from extendedinfo where uid=@uid);
insert into notifications(description, type, ref, uid) values(concat(@rrowner, ' left a comment on your reply.'), 2, @rrid, @rowner);
end if;
insert into activitylog(description, type, ref, uid) values(@desc, 2, @rrid, @uid);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
`srno` int(11) NOT NULL,
  `description` text NOT NULL,
  `imagepath` text,
  `attachment` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `correct` int(11) DEFAULT '0',
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`srno`, `description`, `imagepath`, `attachment`, `timestamp`, `correct`, `tid`, `uid`) VALUES
(1, '<p>thanks mate! appreciate it much!</p>', NULL, NULL, '2015-04-28 09:39:24', 0, 119, 10000),
(2, '<p>Ohh thanks alot Mihir i wanted it&nbsp;</p>', NULL, NULL, '2015-04-28 09:39:27', 0, 116, 10001),
(3, '<p>lol. shut up. you are ruining our page!! :D :D</p>', NULL, NULL, '2015-04-28 09:40:13', 0, 115, 10000),
(4, '<p>No words to describe their greatness __/\\__</p>', NULL, NULL, '2015-04-28 09:40:52', 0, 117, 10000),
(5, '<p>The irony is true !! He said</p><blockquote>If one day speed kills dont be sad I will be smiling ! - Paul Walker</blockquote>', NULL, NULL, '2015-04-28 09:41:08', 0, 121, 10001),
(6, '<p>Do you play chess? Amazing. Let''s meet up. 6 PM. Grubshup. I''ll bring the board.</p>', NULL, NULL, '2015-04-28 09:41:13', 0, 120, 10002),
(7, '<p>I can''t find a nice tutorial on google for JSON. Can you share something for everyone?</p>', NULL, NULL, '2015-04-28 09:41:32', 0, 113, 10000),
(8, '<p>Chal khelu attach!!! :D&nbsp;</p>', NULL, NULL, '2015-04-28 09:42:04', 0, 108, 10000),
(9, '<p>it should be</p><pre>int main()\n\nreturn 0;</pre>', NULL, NULL, '2015-04-28 09:42:17', 1, 115, 10001),
(10, '<p>Ohh crap. I thought they are really going to shoot.&nbsp;</p>', NULL, NULL, '2015-04-28 09:42:18', 0, 118, 10002),
(11, '<p>Most amazing product till now.<br><p>They should start its production again.&nbsp;</p></p>', NULL, NULL, '2015-04-28 09:42:55', 0, 117, 10002),
(12, '<p>definitely a boon..</p>', NULL, NULL, '2015-04-28 09:43:04', 0, 112, 10000),
(13, '<p>Porcupine Tree just heard about it , I want to listen to it</p><p>Suggesst me some good website where i can download its discography</p>', NULL, NULL, '2015-04-28 09:43:12', 0, 109, 10001),
(14, '<p>I always prefer intelligent heroes!!</p>', NULL, NULL, '2015-04-28 09:44:09', 0, 101, 10000),
(15, '<p>Its Life it depends upon How you take it !!</p>', NULL, NULL, '2015-04-28 09:44:28', 0, 112, 10001),
(16, '<p>That''s how its done. &nbsp;:)<br></p>', NULL, NULL, '2015-04-28 09:44:42', 0, 113, 10002),
(17, '<p>amazing jodi. (y)</p>', NULL, NULL, '2015-04-28 09:45:45', 0, 111, 10002),
(18, '<p>hey atharva. You can find it here.<a href="www.torrentz.eu" target="_blank"><br></a><p><a href="www.torrentz.eu"><br></a><p><a href="www.torrentz.eu" target="_blank">torrent</a></p><p><a href="www.ptd.com">Porcupine Tree Dicsography</a><a href="www.porcupinetree.com" target="_blank"><br></a><p><a href="www.porcupinetree.com">Discography</a></p></p></p></p>', NULL, NULL, '2015-04-28 09:48:14', 0, 109, 10002),
(19, '<p>yummm.. I love food. :)<br>Where can i find the good place to eat sizzler? in pune. :P&nbsp;</p>', NULL, NULL, '2015-04-28 09:50:44', 0, 123, 10002),
(20, '<p>Respect _/\\_</p>', NULL, NULL, '2015-04-28 09:51:22', 0, 124, 10002),
(21, '<p>Hmmmmmmmm</p>', NULL, NULL, '2015-04-28 10:03:55', 0, 115, 10001),
(22, '<p>okay</p>', NULL, NULL, '2015-04-28 10:39:48', 0, 128, 10001),
(23, '<p>just start from terminal</p>', NULL, NULL, '2015-04-28 10:41:44', 1, 116, 10001),
(24, '<p>Okdjdibdi</p>', NULL, NULL, '2015-06-27 08:25:59', 0, 131, 10001),
(25, '<p>Mouth watering !! i want it . . . .</p>', NULL, NULL, '2015-07-02 14:45:36', 0, 123, 10005);

--
-- Triggers `reply`
--
DELIMITER //
CREATE TRIGGER `ac_dReply` AFTER DELETE ON `reply`
 FOR EACH ROW begin 
declare done int default 0;
declare i int;
declare j int;
declare cursor1 cursor for select tid, uid from trackthread where tid=old.tid;
declare continue handler for not found set done=1;
open cursor1;
read_loop: loop
fetch cursor1 into i, j;
if done then leave read_loop;
end if;
delete from notifications where ref=old.srno and uid=j and type=1;
end loop;
close cursor1;
set @userid=old.uid;
set @ref=old.srno; 
delete from activitylog where uid=@userid and ref=@ref and type=1; 
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iCorrect` AFTER UPDATE ON `reply`
 FOR EACH ROW begin
set @flag=(select correct from reply where srno=new.srno);
if @flag=1 then
	set @rid=new.srno; 
	set @tid=(select tid from reply where srno=new.srno); 
	set @tuid=(select uid from thread where srno=@tid); 
	set @twoner=(select concat(fname, ' ', lname) from extendedinfo where uid=@tuid);
	set @desc=concat(@towner, ' marked your reply as correct');
	insert into notifications(description, type, ref, uid) values('@desc', 5, @rid, new.uid);
end if;
if @flag=0 then
	set @rid=new.srno; 
	delete from notifications where type=5 and ref=@rid and uid=new.uid;
end if;
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iReply` AFTER INSERT ON `reply`
 FOR EACH ROW begin 
declare done int default 0;
declare i int;
declare j int; 
declare cursor1 cursor for select `tid`, `uid` from `trackthread` where tid=new.tid; 
declare continue handler for not found set done=1; 
open cursor1; 
read_loop: loop fetch cursor1 into i, j; 
if done then leave read_loop; end if; 
set @rid=new.srno;
set @uid=new.uid;
if (@uid != j) then
set @name=(select concat(fname, ' ', lname) from extendedinfo where uid=@uid);
insert into notifications(description, type, ref, uid) values(concat(@name, ' left a reply on a thread you are tracking'), 1, @rid, j); 
end if;
end loop; 
close cursor1; 
set @title=(select title from thread where srno=new.tid); 
set @descr=concat('Left a reply on ', @title); 
insert into activitylog(description, type, ref, uid) values(@descr, 1, new.srno, new.uid); end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`name`) VALUES
('1d1'),
('9gag'),
('afterlife'),
('apache'),
('architects'),
('basics'),
('bhimsenjoshi'),
('birds'),
('bishop'),
('BJP'),
('brain'),
('BrBa'),
('BreakingBad'),
('brownsugar'),
('c'),
('camera'),
('chess'),
('chicken'),
('chickenshashlik'),
('classical'),
('code'),
('college'),
('consciousness'),
('cooking'),
('crazyones'),
('cremebrulle'),
('cs'),
('cs1.6'),
('custard'),
('death'),
('debate'),
('dhatirakita'),
('diet'),
('dota2'),
('dsd'),
('example'),
('facelessvoid'),
('filters'),
('frank'),
('freedom'),
('friends'),
('funn'),
('furious7'),
('gadima'),
('gaming'),
('geetramayan'),
('gym'),
('HD'),
('health'),
('Heisenberg'),
('hoc'),
('houseofcards'),
('ilovecooking'),
('India'),
('indian'),
('intj'),
('iPod'),
('irony'),
('iTunes'),
('javascript'),
('JessePinkman'),
('JSON'),
('kavita'),
('life'),
('linux'),
('marathipoem'),
('masterminds'),
('matrix'),
('MBTI'),
('meditation'),
('mind'),
('monk'),
('music'),
('NaMo'),
('NarendraModi'),
('nature'),
('newyork'),
('nostalgia'),
('ny'),
('old-is-gold'),
('online-gaming'),
('oopnotlikejava'),
('paul-walker'),
('peace'),
('poem'),
('politicaldebate'),
('prison'),
('program'),
('programming'),
('progressive'),
('progrock'),
('pt'),
('RIP'),
('rock'),
('rook'),
('sample'),
('script'),
('singer'),
('sizzlers'),
('sketchaday'),
('sketching'),
('skyline'),
('social-media'),
('social-networking'),
('steadler'),
('stevejobs'),
('sw'),
('tabla'),
('tags'),
('time'),
('trap'),
('traveling'),
('ubuntu'),
('underwoods'),
('USA'),
('wildlife'),
('workouts'),
('zakirhussain');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
`srno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `imagepath` text,
  `coordinates` varchar(30) DEFAULT NULL,
  `edit` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`srno`, `title`, `description`, `imagepath`, `coordinates`, `edit`, `timestamp`, `cid`, `uid`) VALUES
(100, 'Meditation: path to a peaceful life!', '<p>The Nine Personality Types of the Enneagram</p><p>Type 1: The Reformer. The rational, idealistic type.</p><p>Type 2: The Helper. The caring, nurturing type.</p><p>Type 3: The Motivator. The adaptable, success-oriented type.</p><p>Type 4: The Artist. The intuitive, reserved type.</p><p>Type 5: The Thinker. The perceptive, cerebral type.</p><p>Type 6: The Skeptic. The committed, security-oriented type.</p><p>Type 7: The Generalist. The enthusiastic, productive type.</p><p>Type 8: The Leader. The powerful, aggressive type.</p><p>Type 9: The Peacemaker. The easygoing, accommodating type.</p>', 'userdata/10000/shaolin-monk-photography-hd-wallpaper-1920x1200-626443302_-_143014741788911_-_1430213036.jpg', '0px -63px', 0, '2015-04-28 09:25:19', 10, 10000),
(101, 'DOTA 2', '<p>Dota 2 Faceless void commands</p><p><i>- I see the future and you are not in it</i></p><p><i>- I saw your death the moment you were born</i></p><p><a href="www.dota2.com">www.dota2.com</a></p>', 'userdata/10001/faceless_void45282_-_1430213039.png', '0px -19px', 0, '2015-04-28 09:25:23', 9, 10001),
(102, 'Pt. Bhimsen Joshi', '<p>Classical singer extraordinaire! How I wish I was alive when he was much younger. I''d have given anything to watch him sing in live concerts.</p>', 'userdata/10000/pandit-bhimsen-joshi-bhagvan-das22209_-_14301463473713_-_1430213126.jpg', '0px -365px', 0, '2015-04-28 09:26:46', 15, 10000),
(103, 'Look at those birds.', '<p>what is the species of the birds ?</p>', 'userdata/10002/_58227984_giovannifrescura,italy,openshortlist,nature&wildlife,sonyworldphotographyawards201251387_-_1430213164.jpg', '0px -44px', 0, '2015-04-28 09:27:03', 16, 10002),
(104, 'Zakir bhai', '<p>The man with the magical fingers !!&nbsp;</p><p>Was a pleasure to watch him from the first row at Vasantotsav 2015</p><p><br></p><p>DhaDhinDhinDha | DhaDhinDhinDha | DhaTinTinTa | TaDhinDhinDha</p>', 'userdata/10001/1932297_873616439332690_5512847863901033775_n91574_-_1430213150.jpg', '0px -27px', 0, '2015-04-28 09:27:14', 15, 10001),
(105, 'Crazy ones', '<blockquote>Here''s for the crazy ones<br> The misfits. The rebels.The troublemakers. The round pegs in the square holes.<br>The ones who see things differently.<br>They are not fond of rules. And they have no respect for the status quo.<br>You can quote them, disagree with them, glorify or vilify them.<br>About the only thing you cant do is ignore them.<br>Because they change things.<br>They push the human race forward.<br>While some may see them as the crazy ones, we see genius.<br>Because the people who are crazy enough to think they can change the world, are the ones who do. - STEVE JOBS</blockquote>', 'userdata/10001/test-image1289_-_1430213249.jpg', '0px -27px', 0, '2015-04-28 09:28:07', 12, 10001),
(106, 'Challenges before Modi regime!', '<p>What do you think are the main challenges before the new government? It''s been almost a year that Narendra Modi formed the government. He still has a long way to go!</p>', 'userdata/10000/modi36717_-_143014768433713_-_1430213213.jpg', '0% 0%', 0, '2015-04-28 09:28:07', 19, 10000),
(107, 'New York', '<p>The bold and the beauty of skyline of New York&nbsp;</p><p>Need i say more ?&nbsp;</p>', 'userdata/10001/ilovenewyork92141_-_1430213300.jpg', '0px -121px', 0, '2015-04-28 09:29:15', 12, 10001),
(108, 'Counter Strike open IP''s are here... Have fun.', '<p>1. 123.123.65.0.4560 de_dust<br>2. 23.225.159.265:44 train_map</p><p>3. 56.2566.254.1156 &nbsp;untitled<br></p><p>4. 123.123.65.0.4560          de_dust</p><p>5. 23.225.159.265:44          train_map</p><p>6. 56.2566.254.1156           untitled</p>', 'userdata/10002/counter-strike-2010-262970291_-_1430213231.jpg', '0% 0%', 0, '2015-04-28 09:29:19', 9, 10002),
(109, 'Review: Porcupine Tree''s "Fear of the blank planet"', '<p>There is no word to describe the new album of Porcupine Tree, our favorite progressive band. How do you feel about the new band?&nbsp;</p>', 'userdata/10000/11102704_920772431276353_4302178910384297934_n52947_-_143014523530963_-_1430213309.jpg', '0px 0px', 0, '2015-04-28 09:29:59', 15, 10000),
(110, 'old is gold', '<p>These are some pics of old cameras. If anyone has more information about it do post it. I have a project to do on this subject.</p>', 'userdata/10002/picking_your_first_camera88505_-_1430213382.jpg', '0px -13px', 0, '2015-04-28 09:30:46', 18, 10002),
(111, 'House of Cards Season 3', '<p>I just finished HOC''s season 3!! 2 days straight and I''m through with it! Waiting for the season 3 desperately. Too bad, we have to wait for another year now.</p>', 'userdata/10000/o-HOUSE-OF-CARDS-facebook51993_-_143014660467263_-_1430213415.jpg', '0% 0%', 0, '2015-04-28 09:31:41', 27, 10000),
(112, 'Social networking: curse or boon?', '<p>Do comment. Important topic to debate on.</p>', 'userdata/10002/social-networking-background-2426300691750_-_1430213460.jpg', '0px -77px', 0, '2015-04-28 09:32:52', 25, 10002),
(113, 'JSON Lesson 1', '<p>JSON is Javascript Object Notation which is a object literal for javascript</p><pre>var json = ["a","123"];<br>var json1 = ["a",{"b","abcd"}];<br>var json2 = ["a",{"b",{"c","0.5"}}];</pre><p>These are the various ways in which u can define a object which contains key - value pair wherein in each key can contain many keys and corresponding values.</p>', '', '0% 0%', 0, '2015-04-28 09:33:26', 20, 10001),
(114, 'Expanded Consciousness', '<p>The world is an illusion. It is a mere image. Everything you see, smell, touch, feel, eat, experience are mere electrical impulses in your brain. I refuse to get trapped in this Maya. I demand the higher beings to free my soul.</p>', 'userdata/10000/original14572_-_143020749920514_-_1430213523.jpg', '0% 0%', 0, '2015-04-28 09:34:18', 17, 10000),
(115, 'hey hey hey! My first working program. ', '<pre>#include&lt;stdio.h&gt;<br>void main()<br>{<br>    int i;<br>    for(i=0; i&lt;10; i++)<br>    {<br>        printf("Soapbox is amazing.");<br>        printf("It''s fun using soapbox.");<br>    }<br>}</pre>', '', '0% 0%', 0, '2015-04-28 09:34:52', 20, 10002),
(116, 'SImplified: How to start apache service?', '<pre>cmd$ /etc/init.d/apache2 start</pre><p>this is how you start apache service from your console!</p>', '', '0% 0%', 0, '2015-04-28 09:35:49', 20, 10000),
(117, 'Ipod', '<p>This picture has a great history ! The team which revolutionized the music industry and online music industry by reinventing music device called as iPod</p><blockquote>Its a tool for the heart and when you can touch someone''s heart its limitless , Its a music playing device , Its a thousand songs in a pocket . Let me introduce you to the iPod - STEVE JOBS</blockquote><p><br></p>', 'userdata/10001/IMG_172166661_-_1430213632.JPG', '0px -58px', 0, '2015-04-28 09:36:15', 25, 10001),
(118, 'Breaking Bad Season 6 is just a rumor!', '<p>Arrgghh. Disappointment! How did you feel when you came to know it was a rumor? I felt pretty sad. But now I feel okay, knowing that Breaking Bad ended perfectly in season 5.TvS</p>', 'userdata/10000/BB-explore-S2-980x551-clean13351_-_143014808032512_-_1430213761.jpg', '0px -39px', 0, '2015-04-28 09:37:51', 27, 10000),
(119, 'instructions before going to gym!', '<p>Don''t eat for 1 hour while going to gym.<br><br><p>Keep yourself hydrated.<br><br>Do take rest in between two sets.</p><p><br></p><p>Don''t burden yourself.<br><p><br><p>Do drink water.<br><br><i>Stay healthy stay foolish. :)</i></p></p></p></p>', 'userdata/10002/Gym-etiquette99096_-_1430213704.jpg', '0px -94px', 0, '2015-04-28 09:38:01', 10, 10002),
(120, 'Chess', '<p>The game which i love to play i read a quote</p><blockquote>Most gods throw dice but Fate plays chess and you dont find out till too late that he''s been playing with two queens all along !!</blockquote><p>i want to learn profession chess can anyone suggests me some books&nbsp;</p><p>Thanks&nbsp;</p>', 'userdata/10001/IMG_420290600_-_1430213802.JPG', '0px -81px', 0, '2015-04-28 09:38:41', 24, 10001),
(121, 'We miss you Paul Walker.', '<p>Paul walker has done a great job. We are going to miss you.&nbsp;</p>', 'userdata/10002/Paul-Walker-Photo-0997938310_-_1430213893.jpg', '0px -141px', 0, '2015-04-28 09:39:26', 14, 10002),
(122, 'Sketch', '<p>Heyy guyz this is my first sketch a castle!</p>', 'userdata/10001/IMG_371324791_-_1430214319.JPG', '0px -112px', 0, '2015-04-28 09:46:11', 4, 10001),
(123, 'Sizzlers', '<p>Yummmmmmmmy&nbsp;</p><p>Touche the Place , opposite SGS mall , Camp, Pune&nbsp;</p>', 'userdata/10001/IMG_387845090_-_1430214397.JPG', '0px -34px', 0, '2015-04-28 09:47:48', 8, 10001),
(124, 'Steve Jobs Just Before Death', '<blockquote>I remember sitting in his backyard in his garden, one day, and he started talking about God. He [Jobs] said, â€œ Sometimes I believe in God, sometimes I donâ€™t. I think itâ€™s 50/50, maybe. But ever since Iâ€™ve had cancer, Iâ€™ve been thinking about it more, and I find myself believing a bit more, maybe itâ€™s because I want to believe in an afterlife, that when you die, it doesnâ€™t just all disappear. The wisdom youâ€™ve accumulated, somehow it lives on.â€<br>Then he paused for a second and said, â€œYea, but sometimes, I think itâ€™s just like an On-Off switch. Click. And youâ€™re gone.â€ And then he paused again and said, â€œ And thatâ€™s why I donâ€™t like putting On-Off switches on Apple devices.â€<br>Joy to the WORLD! There IS an after-life!â€ &nbsp;- Steve Jobs</blockquote>', '', '0% 0%', 0, '2015-04-28 09:50:22', 12, 10001),
(125, 'Nostalgic an ode to college life', '<blockquote>Nostalgia<br>Rah dekhi thi is din ki kabse ,<br>  Ageke sapne saja rakhe the najane kabse<br>                                              bade utavle the jaane ko ,<br>Jindagi ka agla padhav paane ko<br>Najane kyu aj dil mein kuch aur ata hai ,                                                 Waqt ko rokhne ka jee chahata hai                                           Jin bato ko lekar rote the aj unpar hasi ati hai ,                                               Na jane kyu un paalon ki yaad aj bahot satati hai.                                       Kaha karta tha badi mushkil se do saal sehe gaya.                                        Lekin naajane kyu lagta hai ki kuch piche rehe gaya.                             Kahi ankahi hazaaro batein rehe gayi                                            Na bhulne wali kuch yaadein rehe gayi<br>                                              Meri taang ab kaun kheecha karega,<br>mera sir khaane ko kaun peecha karega<br>Jaha 2000 ka hisab nahi waha 2rs ke liye kaun ladhega ,<br>Kaun raat bhar jaagkar saath padega<br>Kaun mera lunch bina puche khaega ,<br>Kaun mere naaye naaye naam banaega<br>Main ab bina matlab ke kisse ladhunga ,<br>Bina topic ke kisse bakwas karunga<br>Kaun fail hone par dilasa dilaega ,<br>Kaun galti se number ane par gaaliya sunaega<br>Aise dost kaha milenge jo khaayi main bhi dhakka de aaye toh bachane khud bhi kud jaaye<br>Ab kiske saath khelunga , kiske saath boring lecture jhelunga<br> Meri certificates ko raddi keheneki himmat kaun karega ,<br>Bina dare sacchi raay dene ki himmat kaun karega<br> Naa jaane yeh fir kab hoga ,<br>Kehedo dosto dobara sab hoga<br>Dosto ke liye prof se kab ladh paenge ,<br>Kya ye din fir aa payenge<br>Raat ko 2 baje parathe khane kaun jaega,<br> 3 beer saath main pine ki shart kaun lagaega<br>Meri khushi main sach much khush kaun hoga,<br> mere gam main mujhse jyada dukhi kaun hoga<br>Meri ye kavita kaun padega ,<br>Kaun ise sach main samjhega<br>Bahut kuch likhna abhi baaki hai ,<br>Kuch saath shayad baki hai<br>Bas ek baat se dar lagta hai dosto, hum ajnabee na ban jaaye dosto<br>Zindagi ke rango main dosti ka rang fika na pad jaye,<br>Kahi aisa na ho dusre rishton ke bheed main dosti dam tod jaye<br>Zindagi mein milne ki faryaad karte rehna,<br>na mil sake to bas yaad karte rehna.<br>Chahe jitna haslo aj mujhpar main bura nahi manunga,<br>Is hasi ko dil main basa lunga<br>Aur jab yaad aayegi tumhari toh yehi hasi lekar muskura lunga<br>ATHARVA hai mera naam aur ye tha mere dosto ke liye ek chota sa pehgam. &nbsp;<br><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">- Atharva &nbsp;&nbsp;</span></blockquote><p> </p>', '', '0% 0%', 0, '2015-04-28 09:52:00', 12, 10001),
(126, 'INTJ: There are no rules.', '<p>We do not conform. We do not comply.</p>', 'userdata/10000/spoon-boy59673_-_143014692837671_-_1430214721.jpg', '0% 0%', 0, '2015-04-28 09:52:50', 21, 10000),
(127, 'Ga Di Madgulkar ', '<p>à¤…à¤œà¤¾à¤£à¤¤à¥‡ à¤ªà¤£à¥‡ à¤•à¥‡à¤µà¥à¤¹à¤¾ à¤®à¤¾à¤¤à¤¾ à¤˜à¤¾à¤²à¥€ à¤¬à¤¾à¤²à¤—à¥à¤Ÿà¥€</p><p>à¤¬à¥€à¤œ à¤§à¤°à¥à¤®à¤¾à¤šà¥à¤¯à¤¾ à¤¦à¥ƒà¤®à¤¾à¤šà¥‡ à¤•à¤£ à¤•à¤£ à¤—à¥‡à¤²à¥‡ à¤ªà¥‹à¤Ÿà¥€</p><p>à¤›à¤‚à¤¦ à¤œà¤¾à¤£à¤¤à¥‡à¤ªà¤£à¥‡à¤šà¤¾ à¤¿à¤¤à¤°à¥à¤¥à¥‡ à¤•à¤¾à¤µà¥à¤¯à¤¾à¤šà¥€ à¤§à¥à¤‚à¤¡à¥€à¤²à¥€</p><p>à¤•à¥à¤£à¥à¤¯à¤¾ à¤à¤•à¤¾ à¤­à¤¾à¤—à¥à¤¯ à¤µà¥‡à¤³à¥€ à¤ªà¥à¤œà¤¾ à¤°à¤¾à¤®à¤¾à¤šà¥€ à¤®à¤¾à¤‚à¤¡à¤²à¥€</p><p>à¤¦à¥‡à¤µ à¤µà¤¾à¤¿à¤£à¤¤à¤²à¥‡ à¤“à¤œ à¤¿à¤¶à¤¤à¤³à¤²à¥‡ à¤®à¤¾à¤à¥à¤¯à¤¾ à¤“à¤ à¥€&nbsp;</p><p>à¤µà¤¾à¤¿à¤²à¥à¤®à¤•à¥€à¤šà¥à¤¯à¤¾ à¤­à¤¾à¤¸à¥à¤•à¤°à¤¾à¤šà¥‡ à¤à¤¾à¤²à¥‡ à¤šà¤¾à¤‚à¤¦à¤£à¥‡ à¤®à¤°à¤¾à¤ à¥€</p><p>à¤à¤‚à¤•à¤¾à¤°à¤²à¥à¤¯à¤¾ à¤•à¤‚à¤  à¤¿à¤µà¤£à¤¾ à¤†à¤²à¥‡ à¤šà¤¾à¤‚à¤¦à¤£à¥à¤¯à¤¾à¤²à¤¾ à¤¸à¥‚à¤°</p><p>à¤­à¤¾à¤µ à¤®à¤¾à¤§à¥à¤°à¥à¤¯à¤¾à¤²à¤¾ à¤†à¤²à¤¾ à¤®à¤¹à¤¾à¤°à¤¾à¤¿à¤·à¥à¤Ÿà¥à¤°à¤¯ à¤®à¤¹à¤¾à¤ªà¥‚à¤°</p><p>à¤šà¤‚à¤¦à¥à¤°à¤­à¤¾à¤°à¤²à¥à¤¯à¤¾ à¤¿à¤œà¤µà¥à¤¹à¤¾à¤²à¤¾ à¤¨à¤¾à¤¹à¥€ à¤•à¤¶à¤¾à¤šà¥€à¤š à¤šà¤¾à¤¢</p><p>à¤®à¤²à¤¾ à¤•à¤¶à¤¾à¤²à¤¾ à¤®à¥‹à¤œà¤¤à¤¾ ? à¤®à¥€ à¤¤à¥‹ à¤­à¤¾à¤°à¤²à¥‡à¤²à¥‡ à¤à¤¾à¤¡</p><p><br></p><p>His explanation on Geet Ramayan</p>', '', '', 1, '2015-04-28 09:52:58', 28, 10001),
(128, '9gag  is your best source of fun!', '<p>Description goes here.</p><p><br></p><blockquote>quotes goes here -Author</blockquote><p><br></p><pre>int main(){<br>    printf("Hello World");<br>}</pre><p><br></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">list</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">list</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">list</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;"><br></span></li></ul></p><p><br></p>', 'userdata/10003/grid97898_-_143014751320017_-_1430217198.png', '0px -113px', 0, '2015-04-28 10:36:28', 20, 10003),
(129, 'Creme Brulee', '<p><b>Total Time</b></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5; background-color: initial;">3 hr 30 min</span><br></li></ul></p><p><b>Prep</b></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">15 min</span><br></li></ul></p><p><b>Inactive</b></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">2 hr 15 min</span><br></li></ul></p><p><b>Cook</b></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">1 hr</span></li></ul></p><p><b>Ingredients</b></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">1 quart heavy cream</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">1 vanilla bean, split and scraped</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">1 cup vanilla sugar, divided</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">6 large egg yolks</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">2 quarts hot water</span></li></ul><p><b>Directions</b></p></p><p>Preheat the oven to 325 degrees F.</p><p>Place the cream, vanilla bean and its pulp into a medium saucepan set over medium-high heat and bring to a boil. Remove from the heat, cover and allow to sit for 15 minutes. Remove the vanilla bean and reserve for another use.</p><p>In a medium bowl, whisk together 1/2 cup sugar and the egg yolks until well blended and it just starts to lighten in color. Add the cream a little at a time, stirring continually. Pour the liquid into 6 (7 to 8-ounce) ramekins. Place the ramekins into a large cake pan or roasting pan. Pour enough hot water into the pan to come halfway up the sides of the ramekins. Bake just until the creme brulee is set, but still trembling in the center, approximately 40 to 45 minutes. Remove the ramekins from the roasting pan and refrigerate for at least 2 hours and up to 3 days.</p><p>Remove the creme brulee from the refrigerator for at least 30 minutes prior to browning the sugar on top. Divide the remaining 1/2 cup vanilla sugar equally among the 6 dishes and spread evenly on top. Using a torch, melt the sugar and form a crispy top. Allow the creme brulee to sit for at least 5 minutes before serving.</p>', 'userdata/10001/cremebrulle16755_-_1432817031.jpeg', '0px -69px', 0, '2015-05-28 12:46:32', 3, 10001),
(130, 'My first C Program', '<pre>int main(){</pre><pre>    printf();<br></pre><pre>}</pre><p><br></p><p><ul><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">dashdjasdjasd</span><br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">asdasdad</span><br></li><li>ads<br></li><li><span style="font-family: ''Open Sans''; font-size: 12pt; font-style: normal; line-height: 1.5;">asdasdlas</span><br></li></ul></p>', '', '0% 0%', 0, '2015-06-27 08:19:15', 2, 10001),
(131, 'dasd', '<p>dasdasda</p><p>dsd</p><pre>asd<br>dsa</pre><pre>int main(){</pre><pre>   &nbsp;</pre><pre>}<br></pre>', 'userdata/10004/gg81309_-_1435393400.jpg', '0px 0px', 0, '2015-06-27 08:23:56', 1, 10004);

--
-- Triggers `thread`
--
DELIMITER //
CREATE TRIGGER `ac_dThread` AFTER DELETE ON `thread`
 FOR EACH ROW begin set @tid=old.srno; set @uid=old.uid;delete from activitylog where ref=@tid and uid=@uid and type=3; end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_eThread` AFTER UPDATE ON `thread`
 FOR EACH ROW begin 
insert into threadhistory(title, description, imagepath, coordinates,cid, uid, tid) values(old.title, old.description, old.imagepath, old.coordinates,old.cid, old.uid, old.srno); 
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iThread` AFTER INSERT ON `thread`
 FOR EACH ROW begin 
set @tid=new.srno; 
set @title=new.title; 
set @uid=new.uid; 
set @descr=concat('Created a new thread "', @title, '"'); 
insert into activitylog(description, type, ref, uid) values(@descr, 3, @tid, @uid); 
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `threadhistory`
--

CREATE TABLE `threadhistory` (
`srno` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `imagepath` text,
  `coordinates` varchar(30) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threadhistory`
--

INSERT INTO `threadhistory` (`srno`, `title`, `description`, `imagepath`, `coordinates`, `timestamp`, `cid`, `uid`, `tid`) VALUES
(1, 'Ga Di Madgulkar ', '<p>à¤…à¤œà¤¾à¤£à¤¤à¥‡ à¤ªà¤£à¥‡ à¤•à¥‡à¤µà¥à¤¹à¤¾ à¤®à¤¾à¤¤à¤¾ à¤˜à¤¾à¤²à¥€ à¤¬à¤¾à¤²à¤—à¥à¤Ÿà¥€</p><p>à¤¬à¥€à¤œ à¤§à¤°à¥à¤®à¤¾à¤šà¥à¤¯à¤¾ à¤¦à¥ƒà¤®à¤¾à¤šà¥‡ à¤•à¤£ à¤•à¤£ à¤—à¥‡à¤²à¥‡ à¤ªà¥‹à¤Ÿà¥€</p><p>à¤›à¤‚à¤¦ à¤œà¤¾à¤£à¤¤à¥‡à¤ªà¤£à¥‡à¤šà¤¾ à¤¿à¤¤à¤°à¥à¤¥à¥‡ à¤•à¤¾à¤µà¥à¤¯à¤¾à¤šà¥€ à¤§à¥à¤‚à¤¡à¥€à¤²à¥€</p><p>à¤•à¥à¤£à¥à¤¯à¤¾ à¤à¤•à¤¾ à¤­à¤¾à¤—à¥à¤¯ à¤µà¥‡à¤³à¥€ à¤ªà¥à¤œà¤¾ à¤°à¤¾à¤®à¤¾à¤šà¥€ à¤®à¤¾à¤‚à¤¡à¤²à¥€</p><p>à¤¦à¥‡à¤µ à¤µà¤¾à¤¿à¤£à¤¤à¤²à¥‡ à¤“à¤œ à¤¿à¤¶à¤¤à¤³à¤²à¥‡ à¤®à¤¾à¤à¥à¤¯à¤¾ à¤“à¤ à¥€ à¤µà¤¾à¤¿à¤²à¥à¤®à¤•à¥€à¤šà¥à¤¯à¤¾ à¤­à¤¾à¤¸à¥à¤•à¤°à¤¾à¤šà¥‡ à¤à¤¾à¤²à¥‡ à¤šà¤¾à¤‚à¤¦à¤£à¥‡ à¤®à¤°à¤¾à¤ à¥€</p><p>à¤à¤‚à¤•à¤¾à¤°à¤²à¥à¤¯à¤¾ à¤•à¤‚à¤  à¤¿à¤µà¤£à¤¾ à¤†à¤²à¥‡ à¤šà¤¾à¤‚à¤¦à¤£à¥à¤¯à¤¾à¤²à¤¾ à¤¸à¥‚à¤°</p><p>à¤­à¤¾à¤µ à¤®à¤¾à¤§à¥à¤°à¥à¤¯à¤¾à¤²à¤¾ à¤†à¤²à¤¾ à¤®à¤¹à¤¾à¤°à¤¾à¤¿à¤·à¥à¤Ÿà¥à¤°à¤¯ à¤®à¤¹à¤¾à¤ªà¥‚à¤°</p><p>à¤šà¤‚à¤¦à¥à¤°à¤­à¤¾à¤°à¤²à¥à¤¯à¤¾ à¤¿à¤œà¤µà¥à¤¹à¤¾à¤²à¤¾ à¤¨à¤¾à¤¹à¥€ à¤•à¤¶à¤¾à¤šà¥€à¤š à¤šà¤¾à¤¢</p><p>à¤®à¤²à¤¾ à¤•à¤¶à¤¾à¤²à¤¾ à¤®à¥‹à¤œà¤¤à¤¾ ? à¤®à¥€ à¤¤à¥‹ à¤­à¤¾à¤°à¤²à¥‡à¤²à¥‡ à¤à¤¾à¤¡</p><p><br></p><p>His explanation on Geet Ramayan</p>', '', '0% 0%', '2015-07-10 12:46:57', 28, 10001, 127);

-- --------------------------------------------------------

--
-- Table structure for table `thread_tags`
--

CREATE TABLE `thread_tags` (
  `name` varchar(30) DEFAULT NULL,
  `tid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread_tags`
--

INSERT INTO `thread_tags` (`name`, `tid`) VALUES
('health', 100),
('life', 100),
('meditation', 100),
('peace', 100),
('monk', 100),
('dota2', 101),
('facelessvoid', 101),
('gaming', 101),
('time', 101),
('bhimsenjoshi', 102),
('classical', 102),
('singer', 102),
('indian', 102),
('birds', 103),
('nature', 103),
('wildlife', 103),
('traveling', 103),
('zakirhussain', 104),
('tabla', 104),
('dhatirakita', 104),
('stevejobs', 105),
('crazyones', 105),
('life', 105),
('NaMo', 106),
('NarendraModi', 106),
('BJP', 106),
('India', 106),
('politicaldebate', 106),
('ny', 107),
('newyork', 107),
('skyline', 107),
('cs', 108),
('cs1.6', 108),
('gaming', 108),
('online-gaming', 108),
('progressive', 109),
('rock', 109),
('progrock', 109),
('pt', 109),
('sw', 109),
('old-is-gold', 110),
('camera', 110),
('filters', 110),
('HD', 110),
('hoc', 111),
('houseofcards', 111),
('frank', 111),
('USA', 111),
('underwoods', 111),
('social-media', 112),
('social-networking', 112),
('debate', 112),
('JSON', 113),
('javascript', 113),
('oopnotlikejava', 113),
('consciousness', 114),
('matrix', 114),
('trap', 114),
('freedom', 114),
('prison', 114),
('c', 115),
('basics', 115),
('programming', 115),
('apache', 116),
('script', 116),
('ubuntu', 116),
('linux', 116),
('stevejobs', 117),
('music', 117),
('iPod', 117),
('iTunes', 117),
('BrBa', 118),
('BreakingBad', 118),
('Heisenberg', 118),
('JessePinkman', 118),
('gym', 119),
('workouts', 119),
('diet', 119),
('chess', 120),
('brain', 120),
('mind', 120),
('rook', 120),
('bishop', 120),
('furious7', 121),
('paul-walker', 121),
('RIP', 121),
('sketching', 122),
('sketchaday', 122),
('steadler', 122),
('sizzlers', 123),
('chicken', 123),
('chickenshashlik', 123),
('stevejobs', 124),
('afterlife', 124),
('death', 124),
('irony', 124),
('college', 125),
('nostalgia', 125),
('funn', 125),
('friends', 125),
('intj', 126),
('masterminds', 126),
('architects', 126),
('MBTI', 126),
('gadima', 127),
('geetramayan', 127),
('poem', 127),
('kavita', 127),
('marathipoem', 127),
('program', 128),
('9gag', 128),
('sample', 128),
('example', 128),
('cremebrulle', 129),
('custard', 129),
('brownsugar', 129),
('cooking', 129),
('ilovecooking', 129),
('c', 130),
('dsd', 130),
('1d1', 130),
('tags', 131),
('code', 131);

-- --------------------------------------------------------

--
-- Table structure for table `trackthread`
--

CREATE TABLE `trackthread` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trackthread`
--

INSERT INTO `trackthread` (`tid`, `uid`) VALUES
(100, 10000),
(102, 10000),
(106, 10000),
(108, 10000),
(109, 10000),
(111, 10000),
(114, 10000),
(116, 10000),
(118, 10000),
(119, 10000),
(126, 10000),
(101, 10001),
(104, 10001),
(105, 10001),
(107, 10001),
(113, 10001),
(117, 10001),
(120, 10001),
(122, 10001),
(123, 10001),
(124, 10001),
(125, 10001),
(127, 10001),
(128, 10001),
(129, 10001),
(130, 10001),
(103, 10002),
(108, 10002),
(110, 10002),
(112, 10002),
(113, 10002),
(115, 10002),
(117, 10002),
(119, 10002),
(121, 10002),
(123, 10002),
(128, 10003),
(131, 10004);

-- --------------------------------------------------------

--
-- Table structure for table `upvotes_to_replies`
--

CREATE TABLE `upvotes_to_replies` (
`srno` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upvotes_to_replies`
--

INSERT INTO `upvotes_to_replies` (`srno`, `rid`, `uid`) VALUES
(1, 3, 10002),
(2, 9, 10002),
(3, 15, 10002);

--
-- Triggers `upvotes_to_replies`
--
DELIMITER //
CREATE TRIGGER `ac_dUpvoteToReply` AFTER DELETE ON `upvotes_to_replies`
 FOR EACH ROW begin 
set @srno=old.srno;
set @uid=old.uid; 
set @rid=old.rid;
set @rowner=(select uid from reply where srno=@rid);
delete from notifications where ref=@srno and uid=@rowner and type=4;
delete from activitylog where ref=@srno and uid=@uid and type=4; 
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iUpvoteToReply` AFTER INSERT ON `upvotes_to_replies`
 FOR EACH ROW begin
set @srno=new.srno;
set @uid=new.uid;
set @rid=new.rid;
set @tid=(select tid from reply where srno=@rid);
set @title=(select title from thread where srno=@tid);
set @descr=concat('Upvoted a reply to ', @title);
set @rowner=(select uid from reply where srno=@rid);
if @uid != @rowner then
set @name=(select concat(fname, ' ', lname) from extendedinfo where uid=@uid);
set @desc=concat(@name, ' upvoted your reply on ', @title);
insert into notifications(description, type, ref, uid) values(@desc, 4, @srno, @rowner);
end if;
insert into activitylog(description, type, ref, uid) values(@descr, 4, @srno, @uid);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `upvotes_to_thread`
--

CREATE TABLE `upvotes_to_thread` (
`srno` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upvotes_to_thread`
--

INSERT INTO `upvotes_to_thread` (`srno`, `tid`, `uid`) VALUES
(1, 119, 10000),
(2, 116, 10001),
(3, 121, 10001),
(4, 115, 10000),
(5, 120, 10002),
(6, 117, 10000),
(7, 118, 10002),
(8, 115, 10001),
(9, 108, 10000),
(10, 109, 10001),
(11, 117, 10002),
(12, 112, 10000),
(13, 116, 10002),
(14, 101, 10000),
(15, 113, 10002),
(16, 124, 10002),
(17, 126, 10001),
(18, 126, 10002),
(19, 128, 10001),
(20, 129, 10003),
(21, 131, 10001),
(22, 123, 10005),
(23, 118, 10005),
(24, 117, 10005),
(25, 127, 10001),
(26, 130, 10000);

--
-- Triggers `upvotes_to_thread`
--
DELIMITER //
CREATE TRIGGER `ac_dUpvote` AFTER DELETE ON `upvotes_to_thread`
 FOR EACH ROW begin 
set @srno = old.srno;
set @userid = old.uid;
set @threadid = old.tid;
set @towner=(select uid from thread where srno=@threadid);
delete from notifications where ref=@srno and type=3 and uid=@towner;
delete from activitylog where ref=@srno and uid=@userid and type=0; 
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `ac_iUpvote` AFTER INSERT ON `upvotes_to_thread`
 FOR EACH ROW begin 
set @srno=new.srno;
set @name=(select concat(fname, ' ', lname) from extendedinfo where uid=new.uid);
set @towner=(select uid from thread where srno=new.tid);
if @towner != new.uid then
insert into notifications(description, type, ref, uid) values(concat(@name, ' upvoted your thread'), 3, @srno, @towner);
end if;

set @userid = new.uid; 
set @threadid = new.tid; 
set @title = (select title from thread where srno=@threadid); 
set @desc = concat('Upvoted ', @title); 
insert into activitylog(description, type, ref, uid) values(@desc, 0, @srno, @userid); 
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
`srno` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`srno`, `username`, `password`, `timestamp`) VALUES
(10000, 'boom_shankar', '2dd948da0b7fc3df9ee4cb7d09b582e7', '2015-04-28 09:22:01'),
(10001, 'sipps7', '4280a1f43bdcb20dff373c79a8390df2', '2015-04-28 09:22:18'),
(10002, 'chinmayjoshi', '2dd948da0b7fc3df9ee4cb7d09b582e7', '2015-04-28 09:22:30'),
(10003, 'nikipethe', '2dd948da0b7fc3df9ee4cb7d09b582e7', '2015-04-28 10:29:22'),
(10004, 'abhishek', 'f589a6959f3e04037eb2b3eb0ff726ac', '2015-06-27 08:21:32'),
(10005, 'tammu', '659b4b5cc422ef697a4329883d29e4a2', '2015-07-02 14:37:45'),
(10006, 'nihard', '4280a1f43bdcb20dff373c79a8390df2', '2015-07-17 05:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`tid`, `uid`) VALUES
(101, 10000),
(101, 10001),
(101, 10002),
(102, 10000),
(102, 10002),
(104, 10002),
(105, 10002),
(107, 10002),
(108, 10000),
(109, 10000),
(109, 10001),
(109, 10002),
(110, 10002),
(111, 10000),
(111, 10001),
(111, 10002),
(112, 10000),
(112, 10001),
(112, 10002),
(113, 10000),
(113, 10001),
(113, 10002),
(114, 10000),
(115, 10000),
(115, 10001),
(115, 10002),
(116, 10000),
(116, 10001),
(116, 10002),
(117, 10000),
(117, 10001),
(117, 10002),
(117, 10005),
(118, 10000),
(118, 10002),
(118, 10005),
(119, 10000),
(120, 10002),
(121, 10001),
(121, 10002),
(123, 10001),
(123, 10002),
(123, 10005),
(124, 10001),
(124, 10002),
(125, 10001),
(125, 10002),
(126, 10000),
(126, 10001),
(126, 10002),
(127, 10001),
(128, 10000),
(128, 10001),
(128, 10002),
(128, 10003),
(129, 10001),
(129, 10003),
(130, 10000),
(130, 10001),
(131, 10001),
(131, 10004);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitylog`
--
ALTER TABLE `activitylog`
 ADD KEY `uid_al_fk` (`uid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `category_user`
--
ALTER TABLE `category_user`
 ADD KEY `cid_fk` (`cid`), ADD KEY `uid_fk_cu` (`uid`);

--
-- Indexes for table `extendedinfo`
--
ALTER TABLE `extendedinfo`
 ADD UNIQUE KEY `email` (`email`), ADD KEY `uid_fk` (`uid`);

--
-- Indexes for table `hidethread`
--
ALTER TABLE `hidethread`
 ADD PRIMARY KEY (`tid`,`uid`), ADD KEY `uid_ht_fk` (`uid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD KEY `uid_n_fk` (`uid`);

--
-- Indexes for table `readinglist`
--
ALTER TABLE `readinglist`
 ADD PRIMARY KEY (`tid`,`uid`), ADD KEY `uid_rl_fk` (`uid`);

--
-- Indexes for table `replies_to_reply`
--
ALTER TABLE `replies_to_reply`
 ADD PRIMARY KEY (`srno`), ADD KEY `rid_rr_fk` (`rid`), ADD KEY `uid_rr_fk` (`uid`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
 ADD PRIMARY KEY (`srno`), ADD KEY `tid_reply_fk` (`tid`), ADD KEY `uid_reply_fk` (`uid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
 ADD PRIMARY KEY (`srno`), ADD KEY `uid_thread_fk` (`uid`);

--
-- Indexes for table `threadhistory`
--
ALTER TABLE `threadhistory`
 ADD PRIMARY KEY (`srno`), ADD KEY `cid_th_fk` (`cid`), ADD KEY `uid_th_fk` (`uid`), ADD KEY `tid_th_fk` (`tid`);

--
-- Indexes for table `thread_tags`
--
ALTER TABLE `thread_tags`
 ADD KEY `tid_fk` (`tid`);

--
-- Indexes for table `trackthread`
--
ALTER TABLE `trackthread`
 ADD PRIMARY KEY (`tid`,`uid`), ADD KEY `uid_tt_fk` (`uid`);

--
-- Indexes for table `upvotes_to_replies`
--
ALTER TABLE `upvotes_to_replies`
 ADD PRIMARY KEY (`srno`), ADD KEY `rid_utr_fk` (`rid`), ADD KEY `uid_utr_fk` (`uid`);

--
-- Indexes for table `upvotes_to_thread`
--
ALTER TABLE `upvotes_to_thread`
 ADD PRIMARY KEY (`srno`), ADD KEY `tid_uvtt_fk` (`tid`), ADD KEY `uid_uvtt_fk` (`uid`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
 ADD PRIMARY KEY (`srno`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
 ADD PRIMARY KEY (`tid`,`uid`), ADD KEY `tid_v_fk` (`tid`), ADD KEY `uid_v_fk` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `replies_to_reply`
--
ALTER TABLE `replies_to_reply`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `threadhistory`
--
ALTER TABLE `threadhistory`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `upvotes_to_replies`
--
ALTER TABLE `upvotes_to_replies`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `upvotes_to_thread`
--
ALTER TABLE `upvotes_to_thread`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10007;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitylog`
--
ALTER TABLE `activitylog`
ADD CONSTRAINT `uid_al_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `category_user`
--
ALTER TABLE `category_user`
ADD CONSTRAINT `cid_fk` FOREIGN KEY (`cid`) REFERENCES `category` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_fk_cu` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `extendedinfo`
--
ALTER TABLE `extendedinfo`
ADD CONSTRAINT `uid_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `hidethread`
--
ALTER TABLE `hidethread`
ADD CONSTRAINT `tid_ht_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_ht_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
ADD CONSTRAINT `uid_n_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `readinglist`
--
ALTER TABLE `readinglist`
ADD CONSTRAINT `tid_rl_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_rl_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `replies_to_reply`
--
ALTER TABLE `replies_to_reply`
ADD CONSTRAINT `rid_rr_fk` FOREIGN KEY (`rid`) REFERENCES `reply` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_rr_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
ADD CONSTRAINT `tid_reply_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_reply_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
ADD CONSTRAINT `uid_thread_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `threadhistory`
--
ALTER TABLE `threadhistory`
ADD CONSTRAINT `cid_th_fk` FOREIGN KEY (`cid`) REFERENCES `category` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `tid_th_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_th_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `thread_tags`
--
ALTER TABLE `thread_tags`
ADD CONSTRAINT `tid_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `trackthread`
--
ALTER TABLE `trackthread`
ADD CONSTRAINT `tid_tt_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_tt_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `upvotes_to_replies`
--
ALTER TABLE `upvotes_to_replies`
ADD CONSTRAINT `rid_utr_fk` FOREIGN KEY (`rid`) REFERENCES `reply` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_utr_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `upvotes_to_thread`
--
ALTER TABLE `upvotes_to_thread`
ADD CONSTRAINT `tid_uvtt_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_uvtt_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
ADD CONSTRAINT `tid_v_fk` FOREIGN KEY (`tid`) REFERENCES `thread` (`srno`) ON DELETE CASCADE,
ADD CONSTRAINT `uid_v_fk` FOREIGN KEY (`uid`) REFERENCES `useraccounts` (`srno`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
