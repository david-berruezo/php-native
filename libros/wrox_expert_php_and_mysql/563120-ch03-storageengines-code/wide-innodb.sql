DROP TABLE IF EXISTS wide_myisam;
CREATE TABLE wide_myisam (
  word VARCHAR(100) NOT NULL,
  reverse_word VARCHAR(100) NOT NULL,
  soundex_word VARCHAR(100) NOT NULL,
  contains_a  ENUM('Y','N') NOT NULL DEFAULT 'N',
  md5 CHAR(32) NOT NULL,
PRIMARY KEY(word),
INDEX (soundex_word),
UNIQUE INDEX (md5),
INDEX (reverse_word(10))
) ENGINE=MyISAM DEFAULT CHARSET latin1 COLLATE latin1_general_cs;
INSERT INTO wide_myisam (word,reverse_word,soundex_word,contains_a,md5)
SELECT DISTINCT c,REVERSE(c),SOUNDEX(c),IF(INSTR(c,'a')>0,'Y','N'),MD5(c)
FROM example_innodb;

DROP TABLE IF EXISTS wide_innodb;
CREATE TABLE wide_innodb (
  word VARCHAR(100) NOT NULL,
  reverse_word VARCHAR(100) NOT NULL,
  soundex_word VARCHAR(100) NOT NULL,
  contains_a  ENUM('Y','N') NOT NULL DEFAULT 'N',
  md5 CHAR(32) NOT NULL,
PRIMARY KEY(word),
INDEX (soundex_word),
UNIQUE INDEX (md5),
INDEX (reverse_word(10))
) ENGINE=InnoDB DEFAULT CHARSET latin1 COLLATE latin1_general_cs;
INSERT INTO wide_innodb (word,reverse_word,soundex_word,contains_a,md5)
SELECT DISTINCT c,REVERSE(c),SOUNDEX(c),IF(INSTR(c,'a')>0,'Y','N'),MD5(c)
FROM example_innodb;

SELECT table_name,table_rows,row_format,
       data_length/1024 AS data,index_length/1024 AS indx
FROM   INFORMATION_SCHEMA.TABLES 
WHERE  table_name LIKE 'wide_%';

