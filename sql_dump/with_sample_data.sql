-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 04, 2012 at 11:50 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `linker`
--

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `domain` text NOT NULL,
  `add_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `user`, `link`, `description`, `domain`, `add_date`) VALUES
(31, 1, 'http://rutracker.org/forum/index.php', 'BitTorrent трекер RuTracker.org (ex torrents.ru)', 'rutracker.org', 1328387818),
(30, 1, 'http://webmaster.yandex.ru/', 'Яндекс.Вебмастер - Мои сайты', 'webmaster.yandex.ru', 1328387807),
(29, 1, 'https://www.google.com/', 'Google', 'www.google.com', 1328388031),
(28, 1, 'http://www.facebook.com/', 'Facebook', 'www.facebook.com', 1328387685),
(27, 1, 'http://twitter.com/', 'Twitter / Home', 'twitter.com', 1328388165),
(26, 1, 'https://github.com/necolas/normalize.css', 'necolas/normalize.css - GitHub', 'github.com', 1328387475),
(22, 1, 'http://www.99lime.com/', 'HTML KickStart - Ultra–Lean HTML Building Blocks for Rapid Website Production - KickStart your Website Production - 99Lime.com', 'www.99lime.com', 1328385551),
(23, 1, 'https://dev.twitter.com/', 'Twitter Developers', 'dev.twitter.com', 1328387449),
(25, 1, 'https://github.com/necolas/normalize.css', 'necolas/normalize.css - GitHub', 'github.com', 1328387471),
(32, 1, 'http://closure-compiler.appspot.com/home', 'Closure Compiler Service', 'closure-compiler.appspot.com', 1328387826),
(33, 1, 'http://translate.google.ru/#ru|en', 'Google Translate', 'translate.google.ru', 1328387982),
(34, 1, 'http://www.youtube.com/', 'YouTube - Broadcast Yourself.', 'www.youtube.com', 1328388049),
(35, 1, 'http://www.youtube.com/watch?v=Vxjn7R_TU0o&feature=g-trend&context=G210bdc2YTAAAAAAABAA', 'Miguel "Adorn" - YouTube', 'www.youtube.com', 1328388089),
(36, 1, 'http://www.youtube.com/watch?v=FFiY7gJlYfA&feature=g-trend&context=G234ee22YTAAAAAAACAA', 'Skyrim Predicts the Super Bowl - YouTube', 'www.youtube.com', 1328388096),
(37, 1, 'http://www.youtube.com/watch?v=X-GXO_urMow&feature=g-trend&context=G2aaeb43YTAAAAAAAEAA', 'A Day Made of Glass 2: Unpacked. The Story Behind Corning''s Vision. - YouTube', 'www.youtube.com', 1328388100),
(38, 1, 'http://ya.ru', '', 'ya.ru', 1328388480);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `name` text NOT NULL,
  `gender` text NOT NULL,
  `default_net` int(11) NOT NULL,
  `register_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `gender`, `default_net`, `register_date`) VALUES
(1, '', 'Harry Lyubimov', '', 1, 1328374938);

-- --------------------------------------------------------

--
-- Table structure for table `user_net`
--

CREATE TABLE IF NOT EXISTS `user_net` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `net` text NOT NULL,
  `external_id` text NOT NULL,
  `username` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `auth_key` text NOT NULL,
  `profile` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_net`
--

INSERT INTO `user_net` (`id`, `user`, `net`, `external_id`, `username`, `name`, `email`, `auth_key`, `profile`) VALUES
(1, 1, 'twitter', '39434854', 'HarryLyu', 'Harry Lyubimov', '', '39434854-fiPd52s8OGQqXdku075gl67ASLWwRtgCLqmig1WN1/BzkZna83MIkWKq29J9FfaSzjQtDiidve68nSLeVFJrU', 'O:8:"stdClass":39:{s:12:"listed_count";i:18;s:14:"statuses_count";i:4534;s:28:"profile_use_background_image";b:0;s:9:"time_zone";s:11:"Novosibirsk";s:9:"protected";b:0;s:4:"lang";s:2:"en";s:11:"geo_enabled";b:1;s:18:"profile_text_color";s:6:"333333";s:3:"url";s:14:"http://luig.ru";s:4:"name";s:14:"Harry Lyubimov";s:15:"default_profile";b:0;s:28:"profile_background_image_url";s:63:"http://a0.twimg.com/profile_background_images/78451651/back.png";s:10:"utc_offset";i:25200;s:18:"profile_link_color";s:6:"0084B4";s:11:"description";s:28:"UI | webdev | js | Koh Samui";s:19:"follow_request_sent";b:0;s:23:"profile_image_url_https";s:69:"https://si0.twimg.com/profile_images/1246069372/x_933ae766_normal.jpg";s:34:"profile_background_image_url_https";s:65:"https://si0.twimg.com/profile_background_images/78451651/back.png";s:10:"created_at";s:30:"Tue May 12 04:37:27 +0000 2009";s:24:"profile_background_color";s:6:"ffffff";s:6:"status";O:8:"stdClass":20:{s:11:"coordinates";N;s:25:"in_reply_to_status_id_str";N;s:5:"place";N;s:23:"in_reply_to_user_id_str";N;s:3:"geo";N;s:21:"in_reply_to_status_id";N;s:13:"retweet_count";i:0;s:23:"in_reply_to_screen_name";N;s:9:"truncated";b:0;s:10:"created_at";s:30:"Sat Feb 04 12:19:58 +0000 2012";s:12:"contributors";N;s:19:"in_reply_to_user_id";N;s:27:"possibly_sensitive_editable";b:1;s:18:"possibly_sensitive";b:0;s:6:"id_str";s:18:"165771577428938752";s:9:"favorited";b:0;s:6:"source";s:72:"<a href="http://twitter.com/tweetbutton" rel="nofollow">Tweet Button</a>";s:2:"id";d:165771577428938752;s:9:"retweeted";b:0;s:4:"text";s:217:"«One Last Thing» — документальный фильм о Стиве Джобсе (2011 год), профессиональный русский перевод / Apple / Хабрахабр http://t.co/xQ0BHS0Y";}s:21:"default_profile_image";b:0;s:20:"contributors_enabled";b:0;s:9:"following";b:0;s:23:"profile_background_tile";b:0;s:13:"friends_count";i:183;s:11:"screen_name";s:8:"HarryLyu";s:16:"favourites_count";i:67;s:26:"profile_sidebar_fill_color";s:6:"C0DFEC";s:6:"id_str";s:8:"39434854";s:13:"is_translator";b:0;s:13:"notifications";b:0;s:21:"show_all_inline_media";b:1;s:28:"profile_sidebar_border_color";s:6:"a8c7f7";s:2:"id";i:39434854;s:8:"verified";b:0;s:15:"followers_count";i:453;s:17:"profile_image_url";s:67:"http://a2.twimg.com/profile_images/1246069372/x_933ae766_normal.jpg";s:8:"location";s:11:"Novosibirsk";}');
