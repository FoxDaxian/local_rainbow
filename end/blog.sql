-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-13 17:41:01
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `artical_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `up` smallint(5) unsigned NOT NULL DEFAULT '0',
  `down` smallint(5) unsigned NOT NULL DEFAULT '0',
  `look` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `about`
--

INSERT INTO `about` (`artical_id`, `up`, `down`, `look`) VALUES
(1, 2, 1, 3),
(2, 0, 0, 0),
(3, 0, 0, 0),
(4, 0, 0, 0),
(5, 0, 0, 0),
(6, 0, 0, 0),
(7, 0, 0, 0),
(8, 0, 0, 0),
(9, 0, 0, 0),
(10, 0, 0, 0),
(11, 0, 0, 0),
(12, 0, 0, 0),
(13, 0, 0, 0),
(14, 0, 0, 0),
(15, 0, 0, 0),
(16, 0, 0, 0),
(17, 0, 0, 0),
(18, 0, 0, 0),
(19, 0, 0, 0),
(20, 0, 0, 0),
(21, 0, 0, 0),
(22, 0, 0, 0),
(23, 0, 0, 0),
(24, 0, 0, 0),
(25, 0, 0, 0),
(26, 0, 0, 0),
(27, 0, 0, 0),
(28, 0, 0, 3),
(29, 0, 0, 1),
(30, 0, 0, 1),
(31, 1, 0, 1),
(32, 0, 0, 0),
(33, 0, 0, 8),
(34, 0, 2, 40);

-- --------------------------------------------------------

--
-- 表的结构 `artical`
--

CREATE TABLE IF NOT EXISTS `artical` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `release_time` bigint(20) unsigned NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `artical`
--

INSERT INTO `artical` (`id`, `user_id`, `title`, `release_time`, `content`) VALUES
(33, 2, '无标题文章', 1489383451739, '&lt;p&gt;1231132313213213213213211&lt;/p&gt;'),
(34, 2, '无标题文章', 1489384475993, '&lt;p&gt;112122122112212122&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `artical_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment_time` bigint(20) unsigned NOT NULL,
  `stars` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `artical_id`, `user_id`, `comment_time`, `stars`, `parent_id`, `content`) VALUES
(6, 33, 2, 1489383456146, 0, 0, '&lt;p&gt;2131212&lt;/p&gt;'),
(7, 33, 2, 1489384222146, 0, 0, '&lt;p&gt;1212121&lt;/p&gt;'),
(8, 33, 2, 1489384287682, 0, 6, '&lt;div data-v-1cee31b4=&quot;&quot; data-id=&quot;6&quot; class=&quot;markdown&quot;&gt;&lt;/div&gt;&lt;p&gt;121221&lt;/p&gt;'),
(9, 33, 2, 1489384310204, 0, 0, '&lt;p&gt;1221&lt;/p&gt;'),
(10, 34, 2, 1489384723930, 0, 0, '&lt;p&gt;1212121121212123123213&lt;/p&gt;'),
(11, 34, 2, 1489390507825, 0, 0, '&lt;p&gt;1221&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `draft`
--

CREATE TABLE IF NOT EXISTS `draft` (
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `draft`
--

INSERT INTO `draft` (`user_id`, `title`, `content`) VALUES
(1, '无标题文章', '&lt;p&gt;&lt;br&gt;&lt;/p&gt;'),
(2, '无标题文章', '&lt;p&gt;11&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `record_login`
--

CREATE TABLE IF NOT EXISTS `record_login` (
  `account` varchar(20) NOT NULL,
  `cookie` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `record_login`
--

INSERT INTO `record_login` (`account`, `cookie`) VALUES
('qweqweqwe', 'c9f0f895fb98ab9159f51fd0297e236d');

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `account` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `email_code` char(32) NOT NULL,
  `email_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`id`, `username`, `account`, `password`, `email`, `email_code`, `email_active`) VALUES
(1, '还是陈科呢吧1', 'qweqweqwe', 'b26986ceee60f744534aaab928cc12df', '945039036@qq.com', '666a5f7a9de089ef36cae9b4ccd84a84', 1),
(2, '陈科呢1', 'asdasdasd', 'a3dcb4d229de6fde0db5686dee47145d', '287220361@qq.com', '326facdc6fc349b3f178555ca5edd95e', 1),
(3, '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', 'f79d21f38891942a2f6346258292c23d', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
