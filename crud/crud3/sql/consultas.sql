# create database crud3;
# create database davidber_opensource DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use davidber_opensource;

ALTER TABLE products ADD download varchar(128);

# busquedas name,description
# SHOW INDEXES FROM products;
# ALTER TABLE products ADD FULLTEXT(description);
# ALTER TABLE products ADD FULLTEXT(name);

/*
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `url` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
PRIMARY KEY (`id`)
) ENGINE = INNODB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;
*/


--
-- Dumping data for table `products`
--
/*
INSERT INTO `products` (`id`, `name`, `description`, `price`, `url`, `created`, `modified`) VALUES
(1, 'DayBook Accounts', 'Accounts managament for house', 300, 'http://wwww.prueba.com' ,'2016-07-17 10:05:00', '2016-07-17 10:05:00');
*/

/*
INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`) VALUES
(1, 'LG Optimus 4X HD P880 Black', 'Display - True HD-IPS LCD - 720 x 1280 pixels, 4.7 inches. Internal Memory - 16 GB storage (12 GB user available), 1 GB RAM. Camera - 8 MP, 3264x2448 pixels, autofocus, LED flash', 309, '2014-06-01 01:12:26', '2014-05-31 17:12:26'),
(2, 'Motorola Google Nexus 6, Midnight Blue 32GB', 'The stunning 6 inch Quad HD display is great for movies, videos, gaming, e-books, and surfing the Web, and the Nexus 6 provides exceptional battery life.', 400, '2014-06-01 01:12:26', '2014-05-31 17:12:26'),
(3, 'Samsung Galaxy S4 i9500 16GB', 'Make your life richer, simpler, and more fun. As a real life companion, the new Samsung GALAXY S4 helps bring us closer and captures those fun moments when we are together. Each feature was designed to simplify our daily lives. Furthermore, it cares enough to monitor our health and well-being.', 600, '2014-06-01 01:12:26', '2014-05-31 17:12:26'),
(6, 'Bench Men''s Bench Spokes Slim T-Shirt', 'Make their heads spin by rollin'' through with swag to spare. Cotton-poly heather blend provides for a soft, comfortable wear. Screen printed Bench graphics on front. Slim fitting for modern appeal. Contrast topstitching along shoulders. Ribbed crew neck. Short sleeves', 14, '2014-06-01 01:12:26', '2014-05-31 02:12:21'),
(7, 'HP ZBook 17 Mobile Business Workstation', 'Feel the power! Take performance to a new level with the HP ZBook 17 with Intel''s quad core CPU and 4GB GDDR5 Nvidia Quadro graphics.  Project a professional image at the office, client meetings, and on the road without sacrificing durability in a stylish chassis.', 5149, '2014-06-01 01:13:45', '2014-05-31 02:13:39'),
(8, 'Samsung Galaxy Tab 4', 'Ideal for watching HD movies, playing games, browsing the web, or reading, the Samsung Galaxy Tab 4 features a 10.1-inch, 1280x800 resolution screen, so you experience rich graphics, bright colors, and crisp text.', 210, '2014-06-01 01:14:13', '2014-05-31 02:14:08'),
(9, 'Spalding Men', 'Right from the beginning, it was all about being first, being the bestâ€¦being what others could only dream of becoming. Founded by Boston Red Stockings pitcher A.G. Spalding in 1876, Spalding has become a leader of innovation and quality in the sporting goods industry.', 49, '2014-06-01 01:18:36', '2014-05-31 02:18:31'),
(10, 'Sony Smart Watch 3', 'Contextually aware and smart, Android Wear gives you useful information at a glance and responds to your voice, feeding you relevant and specific information as you move.', 194, '2014-06-06 17:10:01', '2014-06-05 18:09:51'),
(11, 'Huawei SnapTo', 'Support all GSM 4G LTE Networks ( T-Mobile, AT&T, Straight Talk, NET10, etc.). 75% screen-body ratio and a stylish, leather-texture finish battery cover with a slim design make the phone compac', 179, '2014-06-06 17:11:04', '2014-06-05 18:10:54'),
(12, 'Abercrombie Men''s Lake Arnold Blazer', '100% Gabardine wool imported from Italy. Classic collegiate blazer with heritage A&F crest at left chest pocket. Front pockets with fold-over flaps.', 25, '2014-06-06 17:12:21', '2014-06-05 18:12:11');
*/

