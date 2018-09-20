CREATE TABLE `06_google_cache` (
  `key` varchar(32) NOT NULL default '',
  `index` int(11) NOT NULL default '0',
  `query` varchar(255) NOT NULL default '',
  `start` int(11) NOT NULL default '0',
  `snippet` text NOT NULL,
  `title` varchar(75) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`key`)
) TYPE=MyISAM;

CREATE TABLE `06_google_cache_meta` (
  `key` varchar(32) NOT NULL default '',
  `query` varchar(255) NOT NULL default '',
  `start` int(11) NOT NULL default '0',
  `estimateIsExact` set('1','') NOT NULL default '',
  `estimatedTotalResultsCount` int(11) NOT NULL default '0',
  `time` timestamp(14) NOT NULL,
  PRIMARY KEY  (`key`)
) TYPE=MyISAM;
