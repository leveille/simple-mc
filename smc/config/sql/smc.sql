-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2008 at 03:02 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `smc`
--

-- --------------------------------------------------------

--
-- Table structure for table `smc_blocks`
--

CREATE TABLE `smc_blocks` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `block` mediumtext collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `smc_blocks`
--


-- --------------------------------------------------------

--
-- Table structure for table `smc_roles`
--

CREATE TABLE `smc_roles` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `role` varchar(30) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `smc_roles`
--

INSERT INTO `smc_roles` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `smc_users`
--

CREATE TABLE `smc_users` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `username` varchar(15) collate utf8_unicode_ci NOT NULL,
  `password` varchar(60) collate utf8_unicode_ci NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `smc_users`
--

INSERT INTO `smc_users` (`id`, `username`, `password`, `role_id`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
(2, 'editor', 'ab41949825606da179db7c89ddcedcc167b64847', 2);
