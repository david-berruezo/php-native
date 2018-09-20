#CREATE DATABASE designpatterns CHARACTER SET utf8 COLLATE utf8_general_ci;
use designpatterns;
/*
# Singleton
CREATE TABLE singleton(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `band` varchar(60) DEFAULT NULL,
  `amount` int(10),
   PRIMARY KEY (`id`)
) ENGINE = InnoDB  DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

INSERT INTO `singleton` VALUES (1,'Marinero de Luces','Isabel Pantoja',50);
INSERT INTO `singleton` VALUES (2,'Mi carro me lo robaron','Manolo Escobar',50);
INSERT INTO `singleton` VALUES (3,'Morena mia','Miguel Bose',50);
#prototype
CREATE TABLE prototype(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `band` varchar(60) DEFAULT NULL,
  `amount` int(10),
   PRIMARY KEY (`id`)
) ENGINE = InnoDB  DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;
INSERT INTO `prototype` VALUES (1,'Marinero de Luces','Isabel Pantoja',50);
INSERT INTO `prototype` VALUES (2,'Mi carro me lo robaron','Manolo Escobar',50);
INSERT INTO `prototype` VALUES (3,'Morena mia','Miguel Bose',50);
#dataAccessObject
CREATE TABLE dataaccessobject(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `age` int(10),
   PRIMARY KEY (`id`)
) ENGINE = InnoDB  DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

INSERT INTO `dataaccessobject` VALUES (1,'David','Berruezo',37);
INSERT INTO `dataaccessobject` VALUES (2,'Antonio','Berruezo',77);
INSERT INTO `dataaccessobject` VALUES (3,'Loli','Bernat',66);
*/
