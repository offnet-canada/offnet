-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2019 at 09:21 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rss`
--
CREATE DATABASE IF NOT EXISTS `rss` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rss`;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `url` varchar(225) NOT NULL,
  `source` varchar(50) NOT NULL,
  `feed` varchar(50) NOT NULL DEFAULT 'main',
  `user_id` int(11) DEFAULT NULL,
  `invalid` int(2) DEFAULT '0',
  `atom` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `url`, `source`, `feed`, `user_id`, `invalid`, `atom`) VALUES
(1, 'http://rss.cbc.ca/lineup/topstories.xml', 'cbc', 'main', NULL, 0, 0),
(2, 'http://rss.cbc.ca/lineup/arts.xml', 'cbc', 'art', NULL, 0, 0),
(3, 'http://rss.cbc.ca/lineup/business.xml', 'cbc', 'money', NULL, 1, 0),
(4, 'http://rss.cbc.ca/lineup/canada.xml', 'cbc', 'canadian', NULL, 1, 0),
(5, 'http://rss.cbc.ca/lineup/politics.xml', 'cbc', 'politics', NULL, 0, 0),
(6, 'http://rss.cbc.ca/lineup/sports.xml', 'cbc', 'sports', NULL, 1, 0),
(7, 'http://rss.cbc.ca/lineup/technology.xml', 'cbc', 'technology', NULL, 0, 0),
(8, 'http://rss.cbc.ca/lineup/world.xml', 'cbc', 'world', NULL, 1, 0),
(9, 'http://rss.cbc.ca/lineup/sports-nhl.xml', 'cbc', 'hockey', NULL, 0, 0),
(10, 'http://rss.cbc.ca/lineup/canada-novascotia.xml', 'cbc', 'novascotia', NULL, 0, 0),
(11, 'http://rss.cnn.com/rss/edition.rss', 'cnn', 'main', NULL, 0, 0),
(12, 'http://rss.cnn.com/rss/edition_entertainment.rss', 'cnn', 'entertainment', NULL, 0, 0),
(13, 'http://rss.cnn.com/rss/money_news_international.rss', 'cnn', 'money', NULL, 0, 0),
(14, 'http://rss.cnn.com/rss/cnn_latest.rss', 'cnn', 'recent', NULL, 0, 0),
(15, 'http://rss.cnn.com/rss/edition_space.rss', 'cnn', 'science', NULL, 0, 0),
(16, 'http://rss.cnn.com/rss/edition_sport.rss', 'cnn', 'sports', NULL, 0, 0),
(17, 'http://rss.cnn.com/rss/edition_technology.rss', 'cnn', 'technology', NULL, 0, 0),
(18, 'http://rss.cnn.com/rss/edition_world.rss', 'cnn', 'world', NULL, 0, 0),
(19, 'http://feeds.bbci.co.uk/news/rss.xml?edition=uk', 'bbc', 'main', NULL, 1, 0),
(20, 'http://feeds.bbci.co.uk/news/entertainment_and_arts/rss.xml', 'bbc', 'entertainment', NULL, 1, 0),
(21, 'http://feeds.bbci.co.uk/news/business/rss.xml', 'bbc', 'money', NULL, 1, 0),
(22, 'http://feeds.bbci.co.uk/news/politics/rss.xml', 'bbc', 'politics', NULL, 0, 0),
(23, 'http://feeds.bbci.co.uk/news/world/middle_east/rss.xml', 'bbc', 'middleeast', NULL, 0, 0),
(24, 'http://feeds.bbci.co.uk/news/world/us_and_canada/rss.xml', 'bbc', 'canadian', NULL, 0, 0),
(25, 'http://feeds.bbci.co.uk/news/technology/rss.xml', 'bbc', 'technology', NULL, 0, 0),
(26, 'http://feeds.bbci.co.uk/news/world/rss.xml', 'bbc', 'world', NULL, 0, 0),
(27, 'http://feeds.bbci.co.uk/news/health/rss.xml', 'bbc', 'health', NULL, 0, 0),
(28, 'http://feeds.bbci.co.uk/news/health/rss.xml', 'bbc', 'science', NULL, 0, 0),
(29, 'http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml', 'nyt', 'main', NULL, 0, 0),
(30, 'https://www.rt.com/rss/', 'rt', 'main', NULL, 0, 1),
(31, 'https://www.rt.com/rss/news/', 'rt', 'world', NULL, 0, 0),
(32, 'feeds.wired.com/wired/index', 'wired', 'main', NULL, 0, 1),
(33, 'https://www.techworld.com/news/rss', 'techworld', 'main', NULL, 1, 0),
(34, 'https://www.si.com/rss/si_topstories.rss', 'sportsillustrated', 'top', NULL, 0, 0),
(35, 'https://www.si.com/rss/si_nfl.rss', 'sportsillustrated', 'nfl', NULL, 0, 0),
(36, 'https://www.si.com/rss/si_mlb.rss', 'sportsillustrated', 'mlb', NULL, 0, 0),
(37, 'https://www.si.com/rss/si_nba.rss', 'sportsillustrated', 'nba', NULL, 0, 0),
(38, 'https://www.si.com/rss/si_soccer.rss', 'sportsillustrated', 'soccer', NULL, 0, 0),
(39, 'https://www.si.com/rss/si_tennis.rss', 'sportsillustrated', 'tennis', NULL, 0, 0),
(40, 'https://www.si.com/rss/si_fantasy.rss', 'sportsillustrated', 'fantasy', NULL, 0, 0),
(41, 'https://www.si.com/rss/si_mma.rss', 'sportsillustrated', 'mma', NULL, 0, 0),
(42, 'https://rss.nytimes.com/services/xml/rss/nyt/Sports.xml', 'nyt', 'sports', NULL, 0, 0),
(43, 'http://feeds.washingtonpost.com/rss/politics', 'washpost', 'politics', NULL, 0, 1),
(44, 'http://feeds.washingtonpost.com/rss/national', 'washpost', 'national', NULL, 0, 1),
(45, 'http://feeds.washingtonpost.com/rss/sports', 'washpost', 'sports', NULL, 1, 1),
(46, 'http://feeds.washingtonpost.com/rss/world', 'washpost', 'world', NULL, 1, 1),
(47, 'http://feeds.washingtonpost.com/rss/business', 'washpost', 'business', NULL, 1, 1),
(48, 'https://www.canada.ca/en/news/web-feeds/national-news.atom.xml', 'cangov', 'national', NULL, 1, 1),
(49, 'https://www.canada.ca/en/news/web-feeds/arts-culture-heritage.atom.xml', 'cangov', 'arts', NULL, 0, 1),
(50, 'https://www.canada.ca/en/news/web-feeds/business-industry.atom.xml', 'cangov', 'business', NULL, 0, 1),
(51, 'https://www.canada.ca/en/news/web-feeds/canada-world.atom.xml', 'cangov', 'world', NULL, 0, 1),
(52, 'https://www.canada.ca/en/news/web-feeds/defence-security.atom.xml', 'cangov', 'defence', NULL, 0, 1),
(53, 'https://www.canada.ca/en/news/web-feeds/health.atom.xml', 'cangov', 'health', NULL, 0, 1),
(54, 'https://www.canada.ca/en/news/web-feeds/immigration-citizenship.atom.xml', 'cangov', 'immigration', NULL, 0, 1),
(55, 'https://www.canada.ca/en/news/web-feeds/environment-natural-resources.atom.xml', 'cangov', 'environment', NULL, 0, 1),
(56, 'https://www.canada.ca/en/news/web-feeds/money-finances.atom.xml', 'cangov', 'money', NULL, 1, 1),
(57, 'https://www.canada.ca/en/news/web-feeds/public-safety.atom.xml', 'cangov', 'publicsafety', NULL, 0, 1),
(58, 'https://www.canada.ca/en/news/web-feeds/science-innovation.atom.xml', 'cangov', 'science', NULL, 0, 1),
(59, 'https://www.canada.ca/en/news/web-feeds/taxes.atom.xml', 'cangov', 'taxes', NULL, 0, 1),
(61, 'https://www.canada.ca/en/news/web-feeds/transport-infrastructure.atom.xml', 'cangov', 'transport', NULL, 0, 1),
(62, 'https://www.canada.ca/en/news/web-feeds/travel.atom.xml', 'cangov', 'travel', NULL, 0, 1),
(63, 'http://ctvnews.ca/rss/TopStories', 'ctv', 'main', NULL, 0, 0),
(64, 'http://ctvnews.ca/rss/Canada', 'ctv', 'canada', NULL, 0, 0),
(65, 'http://www.ctvnews.ca/rss/World', 'ctv', 'world', NULL, 0, 0),
(66, 'http://www.ctvnews.ca/rss/CTVNewsEnt', 'ctv', 'entertainment', NULL, 0, 0),
(67, 'http://www.ctvnews.ca/rss/Politics', 'ctv', 'politics', NULL, 0, 0),
(68, 'http://www.ctvnews.ca/rss/lifestyle/ctv-news-lifestyle-1.3407722', 'ctv', 'lifestyle', NULL, 0, 0),
(69, 'http://www.ctvnews.ca/rss/business/ctv-news-business-headlines-1.867648', 'ctv', 'business', NULL, 0, 0),
(70, 'http://www.ctvnews.ca/rss/SciTech', 'ctv', 'science', NULL, 0, 0),
(71, 'http://www.ctvnews.ca/rss/sports/ctv-news-sports-1.3407726', 'ctv', 'sports', NULL, 0, 0),
(72, 'http://www.ctvnews.ca/rss/Health', 'ctv', 'health', NULL, 0, 0),
(73, 'http://www.ctvnews.ca/rss/autos/ctv-news-autos-1.867636', 'ctv', 'auto', NULL, 0, 0),
(74, 'http://atlantic.ctvnews.ca/rss/Atlantic', 'ctv', 'atlantic', NULL, 0, 0),
(75, 'http://rss.canada.com/get/?F56', 'ocanada', 'main', NULL, 1, 0),
(76, 'http://rss.canada.com/get/?F75', 'ocanada', 'national', NULL, 1, 0),
(77, 'http://rss.canada.com/get/?F77', 'ocanada', 'world', NULL, 1, 0),
(78, 'http://rss.canada.com/get/?F7172', 'ocanada', 'business', NULL, 1, 0),
(79, 'http://rss.canada.com/get/?F71', 'ocanada', 'sports', NULL, 1, 0),
(80, 'http://rss.canada.com/get/?F72', 'ocanada', 'tech', NULL, 1, 0),
(81, 'http://rss.canada.com/get/?F69', 'ocanada', 'entertainment', NULL, 1, 1),
(82, 'http://rss.canada.com/get/?F178', 'ocanada', 'travel', NULL, 1, 0),
(83, 'http://rss.canada.com/get/?F67', 'ocanada', 'health', NULL, 1, 0),
(84, 'http://rss.canada.com/get/?F184', 'ocanada', 'lifestyle', NULL, 1, 0),
(85, 'https://www.yahoo.com/news/rss', 'yahoo', 'main', NULL, 0, 0),
(86, 'https://www.yahoo.com/tech/rss', 'yahoo', 'tech', NULL, 0, 0),
(87, 'https://sports.yahoo.com/rss/', 'yahoo', 'sports', NULL, 0, 0),
(88, 'https://www.theguardian.com/uk/rss', 'theguardian', 'main', NULL, 0, 0),
(89, 'https://www.theguardian.com/world/rss', 'theguardian', 'world', NULL, 0, 0),
(90, 'https://www.theguardian.com/uk/sport/rss', 'theguardian', 'sports', NULL, 0, 0),
(91, 'https://www.theguardian.com/science/rss', 'theguardian', 'science', NULL, 0, 0),
(92, 'https://www.theguardian.com/uk/technology/rss', 'theguardian', 'tech', NULL, 0, 0),
(93, 'https://www.theguardian.com/uk/business/rss', 'theguardian', 'business', NULL, 0, 0),
(94, 'https://www.theguardian.com/uk/environment/rss', 'theguardian', 'environment', NULL, 0, 0),
(95, 'https://www.theguardian.com/global-development/rss', 'theguardian', 'globaldev', NULL, 0, 0),
(96, 'https://www.theguardian.com/football/rss', 'theguardian', 'football', NULL, 0, 0),
(97, 'https://www.cnet.com/rss/all/', 'cnet', 'main', NULL, 0, 0),
(98, 'https://www.cnet.com/rss/news/', 'cnet', 'tech', NULL, 0, 0),
(99, 'http://rss.slashdot.org/Slashdot/slashdotMain?format=usm', 'slashdot', 'main', NULL, 1, 0),
(100, 'http://www.thestar.com/feeds.topstories.rss', 'metro', 'main', NULL, 1, 0),
(101, 'http://www.thestar.com/feeds.articles.vancouver.rss', 'metro', 'vancouver', NULL, 1, 0),
(102, 'http://www.thestar.com/feeds.articles.calgary.rss', 'metro', 'calgary', NULL, 1, 0),
(103, 'http://www.thestar.com/feeds.articles.edmonton.rss', 'metro', 'edmonton', NULL, 1, 0),
(104, 'http://www.thestar.com/feeds.articles.halifax.rss', 'metro', 'halifax', NULL, 1, 0),
(105, 'http://www.thestar.com/feeds.articles.news.canada.rss', 'metro', 'canada', NULL, 0, 0),
(106, 'http://www.thestar.com/feeds.articles.news.world.rss', 'metro', 'world', NULL, 1, 0),
(107, 'http://www.thestar.com/feeds.articles.opinion.rss', 'metro', 'opinion', NULL, 1, 0),
(108, 'http://www.thestar.com/feeds.articles.business.rss', 'metro', 'business', NULL, 1, 0),
(109, 'http://www.thestar.com/feeds.articles.sports.rss', 'metro', 'sports', NULL, 0, 0),
(110, 'http://www.thestar.com/feeds.articles.entertainment.rss', 'metro', 'entertainment', NULL, 0, 0),
(111, 'http://www.thestar.com/feeds.articles.life.rss', 'metro', 'lifestyle', NULL, 1, 0),
(112, 'https://news.google.com/_/rss', 'google', 'main', NULL, 0, 0),
(113, 'https://www.forbes.com/real-time/feed2/', 'forbes', 'main', NULL, 1, 0),
(114, 'https://www.forbes.com/most-popular/feed/', 'forbes', 'popular', NULL, 0, 0),
(115, 'https://www.huffingtonpost.com/section/us-news/feed', 'huffpost', 'us', NULL, 1, 0),
(116, 'https://www.huffingtonpost.com/section/health/feed', 'huffpost', 'health', NULL, 1, 0),
(117, 'https://www.huffingtonpost.com/section/politics/feed', 'huffpost', 'politics', NULL, 1, 1),
(118, 'https://www.huffingtonpost.com/section/technology/feed', 'huffpost', 'tech', NULL, 1, 1),
(119, 'https://www.huffingtonpost.com/section/business/feed', 'huffpost', 'business', NULL, 1, 0),
(120, 'https://www.huffingtonpost.com/section/science/feed', 'huffpost', 'science', NULL, 1, 1),
(121, 'https://www.huffingtonpost.com/section/travel/feed', 'huffpost', 'travel', NULL, 1, 0),
(122, 'https://www.huffingtonpost.com/topic/huffpost-code/feed', 'huffpost', 'code', NULL, 1, 0),
(123, 'https://www.huffingtonpost.com/section/world-news/feed', 'huffpost', 'world', NULL, 1, 1),
(124, 'https://www.huffingtonpost.com/section/front-page/feed', 'huffpost', 'main', NULL, 1, 1),
(125, 'https://www.wsj.com/xml/rss/3_7041.xml', 'wsj', 'opinion', NULL, 1, 0),
(126, 'https://www.wsj.com/xml/rss/3_7085.xml', 'wsj', 'world', NULL, 1, 1),
(127, 'https://www.wsj.com/xml/rss/3_7014.xml', 'wsj', 'business', NULL, 1, 0),
(128, 'https://www.wsj.com/xml/rss/3_7031.xml', 'wsj', 'market', NULL, 1, 1),
(129, 'https://www.wsj.com/xml/rss/3_7455.xml', 'wsj', 'tech', NULL, 1, 0),
(130, 'https://www.wsj.com/xml/rss/3_7201.xml', 'wsj', 'lifestyle', NULL, 1, 0),
(131, 'https://www.dal.ca/news.rss.html', 'dal', 'main', NULL, 1, 0),
(132, 'https://news.ycombinator.com/rss', 'hacknews', 'main', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feed_data`
--

CREATE TABLE `feed_data` (
  `feed_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `date` int(11) NOT NULL,
  `retrieved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_data`
--
ALTER TABLE `feed_data`
  ADD KEY `feed_id` (`feed_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
