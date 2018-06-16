-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2012 at 02:39 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ursaminor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `adminid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `adminemail` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `adminpasswd` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `adminsid` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminid`, `adminname`, `adminemail`, `adminpasswd`, `adminsid`) VALUES
(1, 'demo', 'demo@', 'fe01ce2a7fbac8fafaed7c982a04e229', '');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `fileid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `origname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` enum('left','right','top') COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isonline` tinyint(4) DEFAULT NULL,
  `isdeleted` tinyint(4) DEFAULT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`fileid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`fileid`, `filename`, `origname`, `location`, `url`, `isonline`, `isdeleted`, `dtcreated`) VALUES
(4, 'xD6YPc7EHXefFE9zkAzt3DcZkmHWZ9t4.gif', '180150.gif', 'left', 'http://www.test.com', NULL, 0, '2012-02-24 12:57:48'),
(6, 'dBa5PmycaFKp8Vszk4xHXFmKPU9B9k45.gif', '160600.gif', 'right', 'http://www.test.com', NULL, 0, '2012-02-24 13:00:45'),
(7, 'mt6mrF3NeszRFfxkFAP45n2Z22bk6pKv.gif', '180150.gif', 'left', 'http://www.test2.com', NULL, 0, '2012-02-24 13:01:21'),
(8, 'NxeEBm8nEu8hVWS8vKXE3X4uZ9bpbmc4.gif', '46860.gif', 'top', 'http://www.test.com', NULL, 0, '2012-03-23 11:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `imgid` int(11) NOT NULL AUTO_INCREMENT,
  `catid` smallint(6) NOT NULL DEFAULT '0',
  `filename` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `origname` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `imgwh` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isdeleted` tinyint(4) NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`imgid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`imgid`, `catid`, `filename`, `origname`, `imgwh`, `isdeleted`, `dtcreated`) VALUES
(1, 1, 'HZmudWme6yM5tBSps52VnbsTBZCbsBBv.jpg', 'surfonbeachwithcliffs.jpg', '640,480', 0, '2012-04-14 08:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `gallerycats`
--

CREATE TABLE IF NOT EXISTS `gallerycats` (
  `catid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `cattitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isdeleted` tinyint(4) NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gallerycats`
--

INSERT INTO `gallerycats` (`catid`, `cattitle`, `isdeleted`, `dtcreated`) VALUES
(1, 'gallery category 1', 0, '2012-04-14 08:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `globals`
--

CREATE TABLE IF NOT EXISTS `globals` (
  `globalid` smallint(6) NOT NULL AUTO_INCREMENT,
  `langid` tinyint(4) NOT NULL,
  `tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tagproperty` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tagvalue` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`globalid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `globals`
--

INSERT INTO `globals` (`globalid`, `langid`, `tag`, `tagproperty`, `tagvalue`) VALUES
(1, 11, 'settings', 'theme', 'a:11:{s:6:"langid";i:11;s:11:"description";s:13:"a description";s:8:"keywords";s:20:"keywords1, keywords2";s:4:"logo";s:8:"rABx.png";s:5:"title";s:10:"site title";s:8:"sitename";s:9:"site name";s:6:"slogan";s:6:"slogan";s:7:"welcome";s:669:"<p><span style="text-decoration: underline;"><em><strong>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec imperdiet cursus ligula. Vestibulum</strong> </em></span>ac eros aliquet leo<em><strong> dapibus porttitor nec convallis tortor. Praesent in fringilla libero. Etiam dapibus dignissim rutrum. Sed pellentesque facilisis nisl, consequat tristique libero bibendum vel. Pellentesque est ante, lobortis id vulputate in, interdum ut sem</strong></em>? Curabitur leo tortor, iaculis at gravida vel; euismod vel ante! Aliquam ut turpis purus. Morbi enim justo, semper vel mollis vitae, vehicula quis ante?<br /><br /></p>";s:7:"address";s:7:"Address";s:9:"indexlink";i:1;s:5:"theme";s:7:"default";}'),
(2, 10, 'settings', 'theme', 'a:11:{s:6:"langid";i:10;s:11:"description";s:24:"site kısa açıklaması";s:8:"keywords";s:34:"anahtar kelime 1, anahtar kelime 2";s:4:"logo";s:8:"UK4u.png";s:5:"title";s:16:"site başlığı";s:8:"sitename";s:9:"site adı";s:6:"slogan";s:6:"slogan";s:7:"welcome";s:405:"<p>Integer at porta ante. Nulla vulputate elit ac diam dictum malesuada. Mauris nec metus vel neque pulvinar hendrerit eget sit amet urna. Donec bibendum lacus et nisi consectetur sed tempor sem aliquet. Nam in felis mi. Suspendisse potenti. Maecenas tempus sollicitudin lacus sed consequat. Aenean dictum; neque et adipiscing vehicula, velit lectus sodales ligula, eu porta nisl felis sit amet velit.</p>";s:7:"address";s:5:"Adres";s:9:"indexlink";i:1;s:5:"theme";s:7:"default";}');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `langid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `langcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `browsercodes` VARCHAR(10) COLLATE utf8_unicode_ci NOT NULL;  
  `langflag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langtext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isdefault` tinyint(4) NOT NULL,
  `isdeleted` tinyint(4) NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`langid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`langid`, `langcode`, `langflag`, `langtext`, `isdefault`, `isdeleted`, `dtcreated`) VALUES
(10, 'tr_TR', NULL, 'Turkish', 0, 0, '2012-03-22 09:41:50'),
(11, 'en_US, en', NULL, 'English', 1, 0, '2012-03-22 09:43:42'),
(12, 'fr_FR, fr', NULL, 'French', 0, 0, '2012-03-23 12:49:27'),
(13, 'de_DE, de', NULL, 'German', 0, 0, '2012-03-23 12:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `logid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `logvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `newsid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `langid` tinyint(4) NOT NULL,
  `newstitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newsdetail` text COLLATE utf8_unicode_ci NOT NULL,
  `isdeleted` tinyint(4) NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`newsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`newsid`, `langid`, `newstitle`, `newsdetail`, `isdeleted`, `dtcreated`) VALUES
(1, 11, 'Aenean Dignissim Facilisis Urna', '<p>Aenean dignissim facilisis urna, semper consectetur justo rhoncus ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed a orci metus. Etiam egestas malesuada leo sit amet sagittis. Nulla euismod sem eget leo venenatis ultrices ac eu risus. Quisque et vehicula magna. Nunc faucibus, tortor a cursus mattis, magna quam fringilla velit, ut ultricies metus erat in sem. Praesent imperdiet semper erat non accumsan. Donec pulvinar magna sit amet libero ullamcorper vitae interdum est sollicitudin. Etiam interdum velit ac ipsum luctus ac imperdiet erat dignissim! Vestibulum ac risus dolor.<br /><br />Phasellus accumsan fringilla cursus! Aenean tincidunt, turpis ac ullamcorper viverra, diam metus vehicula lorem, eu dictum metus erat scelerisque urna! Aliquam orci diam; adipiscing vitae molestie vitae, ornare id nisl. Etiam sodales fringilla dapibus. Aliquam lacus sapien; rutrum at porttitor a, dictum in felis. Proin ultricies, lacus blandit imperdiet pretium; felis libero adipiscing lorem; id luctus velit nulla sit amet justo. Nam nec lorem lectus. <strong>Nullam diam enim, blandit at hendrerit nec, molestie ut nulla</strong>. Nunc nec nulla nibh. Proin porta sapien eu sem convallis tristique. In viverra, erat a porta lacinia, elit sem hendrerit quam; vitae hendrerit lorem nisl eget augue! Curabitur sodales ligula id arcu rutrum mollis. Pellentesque scelerisque porta dolor, at accumsan erat tincidunt ac. Integer fermentum luctus nibh sollicitudin ultricies! Maecenas ac erat risus? Ut lacinia odio nec nunc mollis tempus.<br /><br />Nam porta mollis tellus nec pulvinar. Nullam pulvinar massa ut lectus fermentum sagittis. Phasellus lobortis dapibus eros. In mauris enim, fermentum et ultricies rutrum, rutrum malesuada eros. Cras eleifend leo ut enim rhoncus consectetur. Donec vitae faucibus massa. Vivamus nec tellus tellus. Nunc tellus odio, egestas sed suscipit quis, interdum eu lectus. Phasellus ullamcorper pretium sapien, accumsan varius leo sagittis eu.<br /><br /></p>', 0, '2010-02-06 15:46:31'),
(7, 10, 'In hac habitasse platea dictumst', '<p>In hac habitasse platea dictumst. Duis sagittis nisi ultrices tortor <span style="text-decoration: underline;">dapibus</span> aliquet. Ut a risus ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc ipsum urna, feugiat sit amet egestas volutpat, hendrerit a risus. Vestibulum hendrerit aliquet viverra. Cras ac ornare ipsum. Pellentesque commodo sollicitudin arcu, nec aliquet.</p>\r\n<address><em><strong>In hac habitasse platea dictumst. Duis sagittis nisi ultrices tortor dapibus aliquet. Ut a risus ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc ipsum urna, feugiat sit amet egestas volutpat, hendrerit a risus. Vestibulum hendrerit aliquet viverra. Cras ac ornare ipsum. Pellentesque commodo sollicitudin arcu nec aliquet.</strong></em><br /><br /></address>', 0, '2012-03-09 14:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageid` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `langid` tinyint(4) NOT NULL,
  `pagetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pagelink` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagedetail` text COLLATE utf8_unicode_ci NOT NULL,
  `menuorder` smallint(6) NOT NULL,
  `isdeleted` tinyint(4) NOT NULL,
  `dtcreated` datetime NOT NULL,
  PRIMARY KEY (`pageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageid`, `langid`, `pagetitle`, `pagelink`, `pagedetail`, `menuorder`, `isdeleted`, `dtcreated`) VALUES
(1, 11, 'Products', NULL, '<p><span style="text-decoration: underline;"><strong>Nullam ut velit dolor</strong></span></p>\r\n<p>Nullam adipiscing, erat in sollicitudin sodales, neque lectus vulputate purus, a tincidunt risus metus in odio. Fusce sollicitudin pretium lacus vitae sollicitudin. Nulla dapibus felis ut lacus suscipit ac blandit augue dignissim. Duis turpis nunc, congue non fermentum id; dictum at magna. Aenean ut fringilla libero. Donec sed urna vel eros placerat lobortis in et nisl! Donec vel nibh nec odio aliquam imperdiet.<br /><br /><span style="text-decoration: underline;"><strong>Curabitur posuere congue tristique.</strong></span></p>\r\n<p>Mauris eu urna ligula. Morbi iaculis dictum porta. Ut fermentum ultricies nisi, at tempus leo feugiat quis. Proin nibh neque, dapibus in blandit sit amet, porttitor nec diam. Donec rhoncus hendrerit lacus, ac vestibulum risus mattis feugiat. Mauris condimentum tincidunt tincidunt. Integer suscipit mollis tortor vitae imperdiet! Nulla sollicitudin lacinia magna, nec lobortis justo ornare in. Fusce id ligula quis nunc molestie blandit id vitae dui.<br /><br /><span style="text-decoration: underline;"><strong>Praesent sollicitudin, dui quis aliquam sagittis</strong></span></p>\r\n<p>Metus risus ornare sem, a blandit arcu velit quis lacus. Curabitur tincidunt dignissim leo ac ultricies. Integer gravida nulla eu augue gravida egestas. Aenean in tortor in sem varius rhoncus sit amet quis ligula. Curabitur ornare, metus et aliquam fermentum; ipsum leo porttitor risus, ac iaculis metus nisl quis sem. In in neque id felis auctor rutrum. Nulla augue eros, blandit vel lobortis id, dignissim et diam. Cras erat risus, vulputate quis luctus sit amet, viverra vel sapien. Proin orci metus, pharetra non facilisis quis, accumsan pellentesque sem. Vivamus suscipit rhoncus dapibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.<br /><br /></p>\r\n<p>&nbsp;</p>', 1, 0, '2010-02-12 17:04:45'),
(6, 10, 'İletişim', 'contact.php?', '<p><strong>Suspendisse eu mauris ac ante tristique gravida</strong> <em></em></p>\r\n<p><em>Ut dictum consectetur facilisis.</em> In hac habitasse platea dictumst. Nullam tellus quam. lobortis eu aliquet eget, luctus quis felis. Donec eu dui dolor. Mauris varius sem sed urna hendrerit quis porttitor magna viverra. Quisque diam neque, commodo id auctor tempor, faucibus a augue! Donec sagittis sapien ac lectus luctus ut commodo tellus bibendum. Suspendisse magna ante, venenatis in vehicula et, venenatis at nisl. Integer massa nulla; sollicitudin a feugiat sit amet, auctor vel metus. Sed aliquam feugiat lectus, et venenatis purus feugiat non. Nulla ornare tellus quis massa imperdiet eget rutrum sapien aliquet!</p>', 1, 0, '2012-03-22 10:39:52'),
(3, 11, 'References', NULL, '<p>Donec est felis, porttitor at porta id, convallis ut nibh. Etiam egestas mauris auctor dolor tempus vestibulum nec eget eros. Pellentesque id odio leo, quis tristique ligula. Praesent non bibendum sem. Nunc condimentum laoreet leo et elementum. Nunc convallis ligula sit amet nulla posuere id lobortis enim tempus. Nullam diam magna, sagittis sit amet convallis sed, lacinia sit amet nibh. Etiam nunc nisi, commodo non semper et, suscipit id sem. Ut non varius sapien. Vivamus dictum suscipit blandit. Nam laoreet facilisis lacinia.<br /><br />Maecenas sodales mattis odio tempus fringilla. Vestibulum pellentesque velit non quam lacinia rhoncus. Mauris vel nisi a neque adipiscing sollicitudin. Aliquam sit amet nisi nec orci consectetur molestie vulputate at nibh! Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis in massa dui, non consequat libero. Vivamus eget sem leo. Donec metus leo, pharetra non iaculis non, egestas eget ligula. Morbi et augue at augue adipiscing iaculis! Etiam tristique malesuada ligula vitae laoreet. Nunc malesuada, purus quis suscipit mattis, nulla lectus pretium justo, ut scelerisque diam lacus a mi. Nam ac aliquet lorem. Integer malesuada viverra nibh vitae tincidunt. Proin at eros mi, ut consequat justo.<br /><br />Proin vehicula ornare enim, vitae pharetra eros cursus et. Nulla quis viverra velit. Sed sed massa nunc, eu pulvinar diam. Etiam sit amet arcu id est fringilla dictum. Vestibulum adipiscing condimentum fermentum. Proin rutrum placerat arcu, vel rutrum sapien mattis et. Donec at risus magna. Duis nisi nibh, interdum vel blandit a, lobortis sed nulla. Mauris placerat, eros ut adipiscing viverra, ipsum purus ornare tortor, commodo ullamcorper nibh odio a ligula! Sed rutrum, velit vel pharetra auctor, eros nulla ornare nulla, eget hendrerit ipsum orci ut tellus. Aliquam bibendum mauris id ligula venenatis congue. Morbi a metus nec ipsum pharetra imperdiet id in nisi. Donec egestas, ipsum rutrum suscipit adipiscing, massa eros dapibus nunc, ac lobortis diam dolor et sem. Aliquam quis tellus et mi venenatis pulvinar laoreet in justo. Ut nec leo sit amet nibh gravida interdum.</p>', 2, 0, '2010-02-12 18:39:07'),
(5, 11, 'Contact', 'contact.php?', '<p>Aliquam nec mauris turpis, ac cursus massa.<strong></strong></p>', 1, 0, '2012-02-22 16:12:19'),
(7, 10, 'Referanslar', NULL, '<p>In hac habitasse platea dictumst. Nullam tellus quam, lobortis eu aliquet eget, luctus quis felis. Donec eu dui dolor. Mauris varius sem sed urna hendrerit quis porttitor magna viverra. Quisque diam neque, commodo id auctor tempor, faucibus a augue! Donec sagittis sapien ac lectus luctus ut commodo tellus bibendum. Suspendisse magna ante, venenatis in vehicula et, venenatis at nisl. Integer massa nulla; sollicitudin a feugiat sit amet, auctor vel metus. Sed aliquam feugiat lectus, et venenatis purus feugiat non. Nulla ornare tellus quis massa imperdiet eget rutrum sapien aliquet!</p>', 5, 0, '2012-03-22 10:41:38'),
(8, 10, 'Ürünler', NULL, '<p>In hac habitasse platea dictumst. Nullam tellus quam, lobortis eu aliquet eget, luctus quis felis. Donec eu dui dolor. Mauris varius sem sed urna hendrerit quis porttitor magna viverra. Quisque diam neque, commodo id auctor tempor, faucibus a augue! Donec sagittis sapien ac lectus luctus ut commodo tellus bibendum. Suspendisse magna ante, venenatis in vehicula et, venenatis at nisl. Integer massa nulla; sollicitudin a feugiat sit amet, auctor vel metus. Sed aliquam feugiat lectus, et venenatis purus feugiat non. Nulla ornare tellus quis massa imperdiet eget rutrum sapien aliquet!</p>', 1, 0, '2012-03-22 10:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translates`
--

CREATE TABLE IF NOT EXISTS `translates` (
  `trid` int(11) NOT NULL AUTO_INCREMENT,
  `fkid` int(9) unsigned NOT NULL,
  `langid` tinyint(3) unsigned NOT NULL,
  `fktype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `trtext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`trid`),
  KEY `fkid` (`fkid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
