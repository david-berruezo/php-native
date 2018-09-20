CREATE SCHEMA IF NOT EXISTS chapter1;
USE chapter1;
DROP TABLE IF EXISTS colors;
CREATE TABLE colors (
  color      VARCHAR(20) NOT NULL,
  is_primary ENUM('yes','no') NOT NULL,
  is_dark    ENUM('yes','no') NOT NULL,
  is_rainbow ENUM('yes','no') NOT NULL COMMENT 'A color of the rainbow ROYGBIV',
  PRIMARY KEY (color)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS flags;
CREATE TABLE flags (
  country VARCHAR(20) NOT NULL,
  color   VARCHAR(20) NOT NULL,
  PRIMARY KEY (country,color),
  KEY color (color)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO colors (color, is_primary, is_dark, is_rainbow) VALUES 
('Black','no','yes','no'),
('Blue','yes','yes','yes'),
('Green','yes','yes','yes'),
('Red','yes','no','yes'),
('White','yes','no','no');

INSERT INTO flags (country, color) VALUES 
('USA','Red'), ('USA','White'), ('USA','Blue'),
('Canada','Red'), ('Canada','White'),
('Australia','Blue'), ('Australia','White'), ('Australia','Red'),
('Japan','White'), ('Japan','Red'),
('Sweden','Blue'), ('Sweden','Yellow');
