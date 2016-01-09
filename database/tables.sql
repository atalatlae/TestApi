CREATE TABLE IF NOT EXISTS `Posts` (
  `id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


