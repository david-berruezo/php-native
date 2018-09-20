
CREATE TABLE `03_store_products` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `category` varchar(25) NOT NULL default '',
  `price` decimal(5,2) NOT NULL default '0.00',
  `unit` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `03_store_products` VALUES (1, 'Marigolds', 'Beautiful perenial flower', 'perennial', 0.99, 'pack of 100 seeds');
INSERT INTO `03_store_products` VALUES (2, 'Tulip', 'Beautiful flower with two 
lips', 'Annual', 3.69, 'bulb');

CREATE TABLE `03_store_sales` (
  `week` int(11) NOT NULL default '0',
  `product_id` int(11) NOT NULL default '0',
  `sale_price` decimal(5,2) NOT NULL default '0.00',
  `sale_unit` varchar(25) NOT NULL default '',
  `blurb` text NOT NULL
) TYPE=MyISAM;

INSERT INTO `03_store_sales` VALUES (1, 1, 0.69, 'pack of 100 seeds', 'Marigolds are on sale this week only!');
INSERT INTO `03_store_sales` VALUES (1, 2, 4.59, 'Twin pack of 2 bulbs', 'Our suplier sent us the wrong shipment, so we can pass on the savings of these great
twin packs on to you!');    

CREATE TABLE `03_store_tips` (
  `id` int(11) NOT NULL auto_increment,
  `week` int(11) NOT NULL default '0',
  `name` varchar(25) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `title` varchar(50) NOT NULL default '',
  `tip` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `03_store_tips` VALUES (1, 1, 'Tom', 'tom@tomsgardenshed.com', 'Landscaping a shady hill', 'One question I often get asked is, Tom, how can I get the grass to grow on the top of, and the slope of, a small shaded hill on my property? No matter what I try it dies off mid season!.<br><br>My Anser: You don’t. Yes, there are hardier strains of grass out there, but with the combination of shade, poor irrigation and the packed clay soil prevalent in the area you are going to waste a lot of time on a small portion of your yard. You do however have several options. Ground covering ivy, or other low to ground shrubs will thrive in this environment, and should have shallow enough roots to avoid damaging your 
trees. ');   
