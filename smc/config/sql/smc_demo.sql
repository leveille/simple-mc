-- phpMyAdmin SQL Dump
-- version 3.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2009 at 03:07 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `smc`
--

-- --------------------------------------------------------

--
-- Table structure for table `smc_blocks`
--

CREATE TABLE IF NOT EXISTS `smc_blocks` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `block` mediumtext collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `smc_blocks`
--

INSERT INTO `smc_blocks` (`id`, `block`, `description`, `locked`) VALUES
(1, '<h3>Sidebar</h3> <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus sollicitudin risus. In non velit et tellus tincidunt sagittis. Vestibulum interdum tincidunt tortor. Duis iaculis feugiat dui. Duis fermentum. Nam ullamcorper mi nec nulla. Curabitur congue fringilla lacus. Nam id neque tincidunt sem porta luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam feugiat ornare lacus.</p>', 'Sidebar', 0),
(2, '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>', 'Footer', 0),
(3, '<h2>Main Content</h2>                             <p><img title="Test Jpg" alt="A test jpg" src="/smc/tmp/demo/assets/images/bg/100.jpg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus sollicitudin risus. In non velit et tellus tincidunt sagittis. Vestibulum interdum tincidunt tortor. Duis iaculis feugiat dui. Duis fermentum. Nam ullamcorper mi nec nulla. Curabitur congue fringilla lacus. Nam id neque tincidunt sem porta luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam feugiat ornare lacus.</p>                             <p><img class="right" title="Test Gif" alt="A test gif" src="/smc/tmp/demo/assets/images/bg/pic.gif">Maecenas fringilla porttitor lacus. Pellentesque interdum. Aenean viverra, lacus eu tristique rhoncus, nulla nunc blandit erat, ut pellentesque neque odio consequat urna. Mauris porta lacus in nulla. Aenean odio nibh, pharetra in, malesuada sed, iaculis ut, sem. Donec posuere. Vivamus cursus tellus ac tortor. Duis sed nunc. Vestibulum bibendum. Quisque metus nibh, iaculis ac, lacinia vel, rhoncus et, justo. Curabitur non massa ac dolor feugiat malesuada. Aliquam suscipit. Aliquam consectetuer, erat nec luctus ornare, leo nisi faucibus tortor, vitae vestibulum ligula est eget arcu. Integer ultrices gravida nisi. Vestibulum elementum diam in eros. Mauris tellus massa, feugiat eu, consequat sit amet, tincidunt et, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas dolor. Sed eu ipsum. Mauris sit amet diam.</p>                             <p>Quisque placerat. Donec et nunc et mauris convallis bibendum. Donec eu diam sodales felis sagittis volutpat. Suspendisse fermentum condimentum sem. Nulla facilisi. Integer nec dui. Pellentesque sodales justo sit amet erat. Nulla feugiat, libero in consectetuer luctus, velit enim placerat arcu, tempor auctor nisl nunc non est. Praesent non dui. Sed lacus lectus, dapibus eu, dapibus ac, euismod nec, metus.</p>', 'Homepage Main Content', 0),
(5, '<h2>Left Content</h2>\n\n<p><img src="/smc/tmp/demo/assets/images/bg/100.jpg" alt="A test jpg" title="Test Jpg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus sollicitudin risus. In non velit et tellus tincidunt sagittis. Vestibulum interdum tincidunt tortor. Duis iaculis feugiat dui. Duis fermentum. Nam ullamcorper mi nec nulla. Curabitur congue fringilla lacus. Nam id neque tincidunt sem porta luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam feugiat ornare lacus. </p>\n\n<p><img src="/smc/tmp/demo/assets/images/bg/pic.gif" alt="A test gif" title="Test Gif" class="right">Maecenas fringilla porttitor lacus. Pellentesque interdum. Aenean viverra, lacus eu tristique rhoncus, nulla nunc blandit erat, ut pellentesque neque odio consequat urna. Mauris porta lacus in nulla. Aenean odio nibh, pharetra in, malesuada sed, iaculis ut, sem. Donec posuere. Vivamus cursus tellus ac tortor. Duis sed nunc. Vestibulum bibendum. Quisque metus nibh, iaculis ac, lacinia vel, rhoncus et, justo. Curabitur non massa ac dolor feugiat malesuada. Aliquam suscipit. Aliquam consectetuer, erat nec luctus ornare, leo nisi faucibus tortor, vitae vestibulum ligula est eget arcu. Integer ultrices gravida nisi. Vestibulum elementum diam in eros. Mauris tellus massa, feugiat eu, consequat sit amet, tincidunt et, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas dolor. Sed eu ipsum. Mauris sit amet diam. </p>', 'Page-2 Left Content', 0),
(6, '<h2>Middle Content</h2>\n<p><img src="/smc/tmp/demo/assets/images/bg/100.jpg" alt="A test jpg" title="Test Jpg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus sollicitudin risus. In non velit et tellus tincidunt sagittis. Vestibulum interdum tincidunt tortor. Duis iaculis feugiat dui. Duis fermentum. Nam ullamcorper mi nec nulla. Curabitur congue fringilla lacus. Nam id neque tincidunt sem porta luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam feugiat ornare lacus.</p>\n\n<p><img src="/smc/tmp/demo/assets/images/bg/pic.gif" alt="A test gif" title="Test Gif" class="right">Maecenas fringilla porttitor lacus. Pellentesque interdum. Aenean viverra, lacus eu tristique rhoncus, nulla nunc blandit erat, ut pellentesque neque odio consequat urna. Mauris porta lacus in nulla. Aenean odio nibh, pharetra in, malesuada sed, iaculis ut, sem. Donec posuere. Vivamus cursus tellus ac tortor. Duis sed nunc. Vestibulum bibendum. Quisque metus nibh, iaculis ac, lacinia vel, rhoncus et, justo. Curabitur non massa ac dolor feugiat malesuada. Aliquam suscipit. Aliquam consectetuer, erat nec luctus ornare, leo nisi faucibus tortor, vitae vestibulum ligula est eget arcu. Integer ultrices gravida nisi. Vestibulum elementum diam in eros. Mauris tellus massa, feugiat eu, consequat sit amet, tincidunt et, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas dolor. Sed eu ipsum. Mauris sit amet diam.</p>', 'Page-2 Middle Content', 0),
(7, '<h2>Right Content</h2> <p><img src="/smc/tmp/demo/assets/images/bg/100.jpg" alt="A test jpg" title="Test Jpg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus sollicitudin risus. In non velit et tellus tincidunt sagittis. Vestibulum interdum tincidunt tortor. Duis iaculis feugiat dui. Duis fermentum. Nam ullamcorper mi nec nulla. Curabitur congue fringilla lacus. Nam id neque tincidunt sem porta luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam feugiat ornare lacus.</p>  <p><img src="/smc/tmp/demo/assets/images/bg/pic.gif" alt="A test gif" title="Test Gif" class="right">Maecenas fringilla porttitor lacus. Pellentesque interdum. Aenean viverra, lacus eu tristique rhoncus, nulla nunc blandit erat, ut pellentesque neque odio consequat urna. Mauris porta lacus in nulla. Aenean odio nibh, pharetra in, malesuada sed, iaculis ut, sem. Donec posuere. Vivamus cursus tellus ac tortor. Duis sed nunc. Vestibulum bibendum. Quisque metus nibh, iaculis ac, lacinia vel, rhoncus et, justo. Curabitur non massa ac dolor feugiat malesuada. Aliquam suscipit. Aliquam consectetuer, erat nec luctus ornare, leo nisi faucibus tortor, vitae vestibulum ligula est eget arcu. Integer ultrices gravida nisi. Vestibulum elementum diam in eros. Mauris tellus massa, feugiat eu, consequat sit amet, tincidunt et, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas dolor. Sed eu ipsum. Mauris sit amet diam.</p>', 'Page-2 Right Content', 0);
