-- phpMyAdmin SQL Dump
-- version 2.11.9.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 03 Set, 2009 at 05:06 AM
-- Versione MySQL: 5.0.27
-- Versione PHP: 5.2.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `319_dfp`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dump dei dati per la tabella `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 1, 2, 3),
(2, 1, 4, 5),
(3, 1, 3, 1),
(5, 2, 1, 67),
(6, 4, 2, 32),
(7, 4, 1, 10),
(8, 4, 3, 3),
(9, 4, 4, 8),
(10, 6, 2, 45),
(11, 6, 4, 31);

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'eggs', 2),
(2, 'butter', 3),
(3, 'meat', 8),
(4, 'cheese', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(11) NOT NULL auto_increment,
  `acronym` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=108 ;

--
-- Dump dei dati per la tabella `provinces`
--

INSERT INTO `provinces` (`id`, `acronym`, `name`, `region`) VALUES
(1, 'AG', 'Agrigento', 'Sicilia'),
(2, 'AL', 'Alessandria', 'Piemonte'),
(3, 'AN', 'Ancona', 'Marche'),
(4, 'AO', 'Aosta', 'Valle d''Aosta'),
(5, 'AP', 'Ascoli Piceno', 'Marche'),
(6, 'AQ', 'l''Aquila', 'Abruzzo'),
(7, 'AR', 'Arezzo', 'Toscana'),
(8, 'AT', 'Asti', 'Piemonte'),
(9, 'AV', 'Avellino', 'Campania'),
(10, 'BA', 'Bari', 'Puglia'),
(11, 'BG', 'Bergamo', 'Lombardia'),
(12, 'BI', 'Biella', 'Piemonte'),
(13, 'BL', 'Belluno', 'Veneto'),
(14, 'BN', 'Benevento', 'Campania'),
(15, 'BO', 'Bologna', 'Emilia Romagna'),
(16, 'BR', 'Brindisi', 'Puglia'),
(17, 'BS', 'Brescia', 'Lombardia'),
(18, 'BZ', 'Bolzano', 'Trentino Alto Adige'),
(19, 'CA', 'Cagliari', 'Sardegna'),
(20, 'CB', 'Campobasso', 'Molise'),
(21, 'CE', 'Caserta', 'Campania'),
(22, 'CH', 'Chieti', 'Abruzzo'),
(23, 'CL', 'Caltanissetta', 'Sicilia'),
(24, 'CN', 'Cuneo', 'Piemonte'),
(25, 'CO', 'Como', 'Lombardia'),
(26, 'CR', 'Cremona', 'Lombardia'),
(27, 'CS', 'Cosenza', 'Calabria'),
(28, 'CT', 'Catania', 'Sicilia'),
(29, 'CZ', 'Catanzaro', 'Calabria'),
(30, 'EN', 'Enna', 'Sicilia'),
(31, 'FE', 'Ferrara', 'Emilia Romagna'),
(32, 'FG', 'Foggia', 'Puglia'),
(33, 'FI', 'Firenze', 'Toscana'),
(34, 'FC', 'Forli-Cesena', 'Emilia Romagna'),
(35, 'FR', 'Frosinone', 'Lazio'),
(36, 'GE', 'Genova', 'Liguria'),
(37, 'GO', 'Gorizia', 'Friuli Venezia Giulia'),
(38, 'GR', 'Grosseto', 'Toscana'),
(39, 'IM', 'Imperia', 'Liguria'),
(40, 'IS', 'Isernia', 'Molise'),
(41, 'KR', 'Crotone', 'Calabria'),
(42, 'LC', 'Lecco', 'Lombardia'),
(43, 'LE', 'Lecce', 'Puglia'),
(44, 'LI', 'Livorno', 'Toscana'),
(45, 'LO', 'Lodi', 'Lombardia'),
(46, 'LT', 'Latina', 'Lazio'),
(47, 'LU', 'Lucca', 'Toscana'),
(48, 'MC', 'Macerata', 'Marche'),
(49, 'ME', 'Messina', 'Sicilia'),
(50, 'MI', 'Milano', 'Lombardia'),
(51, 'MN', 'Mantova', 'Lombardia'),
(52, 'MO', 'Modena', 'Emilia Romagna'),
(53, 'MS', 'Massa Carrara', 'Toscana'),
(54, 'MT', 'Matera', 'Basilicata'),
(55, 'NA', 'Napoli', 'Campania'),
(56, 'NO', 'Novara', 'Piemonte'),
(57, 'NU', 'Nuoro', 'Sardegna'),
(58, 'OR', 'Oristano', 'Sardegna'),
(59, 'PA', 'Palermo', 'Sicilia'),
(60, 'PC', 'Piacenza', 'Emilia Romagna'),
(61, 'PD', 'Padova', 'Veneto'),
(62, 'PE', 'Pescara', 'Abruzzo'),
(63, 'PG', 'Perugia', 'Umbria'),
(64, 'PI', 'Pisa', 'Toscana'),
(65, 'PN', 'Pordenone', 'Friuli Venezia Giulia'),
(66, 'PO', 'Prato', 'Toscana'),
(67, 'PR', 'Parma', 'Emilia Romagna'),
(68, 'PU', 'Pesaro e Urbino', 'Marche'),
(69, 'PT', 'Pistoia', 'Toscana'),
(70, 'PV', 'Pavia', 'Lombardia'),
(71, 'PZ', 'Potenza', 'Basilicata'),
(72, 'RA', 'Ravenna', 'Emilia Romagna'),
(73, 'RC', 'Reggio Calabria', 'Calabria'),
(74, 'RE', 'Reggio Emilia', 'Emilia Romagna'),
(75, 'RG', 'Ragusa', 'Sicilia'),
(76, 'RI', 'Rieti', 'Lazio'),
(77, 'RM', 'Roma', 'Lazio'),
(78, 'RN', 'Rimini', 'Emilia Romagna'),
(79, 'RO', 'Rovigo', 'Veneto'),
(80, 'SA', 'Salerno', 'Campania'),
(81, 'SI', 'Siena', 'Toscana'),
(82, 'SO', 'Sondrio', 'Lombardia'),
(83, 'SP', 'La Spezia', 'Liguria'),
(84, 'SR', 'Siracusa', 'Sicilia'),
(85, 'SS', 'Sassari', 'Sardegna'),
(86, 'SV', 'Savona', 'Liguria'),
(87, 'TA', 'Taranto', 'Puglia'),
(88, 'TE', 'Teramo', 'Abruzzo'),
(89, 'TN', 'Trento', 'Trentino Alto Adige'),
(90, 'TO', 'Torino', 'Piemonte'),
(91, 'TP', 'Trapani', 'Sicilia'),
(92, 'TR', 'Terni', 'Umbria'),
(93, 'TS', 'Trieste', 'Friuli Venezia Giulia'),
(94, 'TV', 'Treviso', 'Veneto'),
(95, 'UD', 'Udine', 'Friuli Venezia Giulia'),
(96, 'VA', 'Varese', 'Lombardia'),
(97, 'VB', 'Verbano Cusio Ossola', 'Piemonte'),
(98, 'VC', 'Vercelli', 'Piemonte'),
(99, 'VE', 'Venezia', 'Veneto'),
(100, 'VI', 'Vicenza', 'Veneto'),
(101, 'VR', 'Verona', 'Veneto'),
(102, 'VT', 'Viterbo', 'Lazio'),
(103, 'VV', 'Vibo Valentia', 'Calabria'),
(104, 'CI', 'Carbonia-Iglesias', 'Sardegna'),
(105, 'MD', 'Medio Campidano', 'Sardegna'),
(106, 'OG', 'Ogliastra', 'Sardegna'),
(107, 'OT', 'Olbia-Tempio', 'Sardegna');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `inserting_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `surname` varchar(255) collate utf8_unicode_ci NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') collate utf8_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `profession` enum('student','employee','freelance','entrepreneur') collate utf8_unicode_ci NOT NULL,
  `notes` text collate utf8_unicode_ci,
  `curriculum` longtext collate utf8_unicode_ci NOT NULL,
  `photo_1` varchar(255) collate utf8_unicode_ci default NULL,
  `photo_2` varchar(255) collate utf8_unicode_ci default NULL,
  `attachment` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `inserting_date`, `name`, `surname`, `password`, `email`, `gender`, `province_id`, `birth_date`, `profession`, `notes`, `curriculum`, `photo_1`, `photo_2`, `attachment`) VALUES
(1, '0000-00-00 00:00:00', 'Michele', 'Castellucci', 'dc12a613487cfc433bdf981b7a65baf4', 'castellucci@cottonbit.it', 'male', 7, '1984-07-27', 'entrepreneur', '  ciaoooooo"', '<div style="text-align: right;">My curriculum have to be rewritten... <br /></div>', 'users_1_photo_1.jpg', NULL, ''),
(2, '0000-00-00 00:00:00', 'Chiara', 'Bianchi', '9003d1df22eb4d3820015070385194c8', 'c.bianchi@alice.it', 'female', 18, '1987-03-13', 'student', '', '<span style="font-weight: bold;">That''s the curriculum</span><br />', 'users_2_photo_1.jpg', NULL, NULL),
(3, '0000-00-00 00:00:00', 'Bob', 'Marly', '9003d1df22eb4d3820015070385194c8', 'bob.marly@jammin.com', 'male', 99, '1964-04-09', 'freelance', '', '<span style="font-weight: bold;">Hi</span> my name is <span style="text-decoration: underline;">Bob</span><br />', NULL, NULL, NULL),
(4, '0000-00-00 00:00:00', 'Salvo', 'Rossi', '9003d1df22eb4d3820015070385194c8', 'lorenzo.rossi@libero.it', 'male', 40, '1974-03-16', 'employee', '', '<span style="font-family: Times new roman;">This is my professional curriculum.<br /><br />...<br />...<br /></span>', NULL, NULL, 'users_4_attachment.jpg'),
(5, '0000-00-00 00:00:00', 'Marcella', 'Sartorio', '9003d1df22eb4d3820015070385194c8', 'sartorio@gmail.com', 'female', 38, '1981-11-18', 'entrepreneur', '', '<ul><li>The curriculum is here</li></ul>', NULL, NULL, NULL),
(6, '0000-00-00 00:00:00', 'Martina', 'Chiassai', '9003d1df22eb4d3820015070385194c8', 'marty@email.it', 'female', 59, '1989-01-06', 'student', '', 'Don''t have any curriculum<br />', NULL, NULL, NULL),
(7, '2009-09-01 00:21:29', 'John', 'Williams', '47bce5c74f589f4867dbd57e9ca9f808', 'fake@fake.com', 'male', 4, '1922-04-04', 'employee', '', '... <br />', NULL, NULL, NULL);
