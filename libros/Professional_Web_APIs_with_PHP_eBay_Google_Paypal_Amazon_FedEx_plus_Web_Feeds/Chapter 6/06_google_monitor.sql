CREATE TABLE `06_google_monitor` (
  `query` varchar(25) NOT NULL default '',
  `allowance` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `06_google_monitor_results` (
  `query` varchar(25) NOT NULL default '',
  `placement` int(11) NOT NULL default '0',
  `timestamp` timestamp(14) NOT NULL
) TYPE=MyISAM;
