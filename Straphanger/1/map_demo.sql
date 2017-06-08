-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 28, 2015 at 06:35 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `map_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `poi_example`
--

CREATE TABLE IF NOT EXISTS `poi_example` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `desc` text NOT NULL,
  `lat` text NOT NULL,
  `lon` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `poi_example`
--

INSERT INTO `poi_example` (`id`, `name`, `desc`, `lat`, `lon`) VALUES
(1, '100 Club', 'Oxford Street, London  W1&lt;br/&gt;3 Nov 2010 : Buster Shuffle&lt;br/&gt;', '51.514980', '-0.144328'),
(2, '93 Feet East', '150 Brick Lane, London  E1 6RU&lt;br/&gt;7 Dec 2010 : Jenny &amp; Johnny&lt;br/&gt;', '51.521710', '-0.071737'),
(3, 'Adelphi Theatre', 'The Strand, London  WC2E 7NA&lt;br/&gt;11 Oct 2010 : Love Never Dies', '51.511010', '-0.120140'),
(4, 'Albany, The', '240 Gt. Portland Street, London  W1W 5QU', '51.521620', '-0.143394'),
(5, 'Aldwych Theatre', 'Aldwych, London  WC2B 4DF&lt;br/&gt;11 Oct 2010 : Dirty Dancing', '51.513170', '-0.117503'),
(6, 'Alexandra Palace', 'Wood Green, London  N22&lt;br/&gt;30 Oct 2010 : Lynx All-Nighter', '51.596490', '-0.109514');
