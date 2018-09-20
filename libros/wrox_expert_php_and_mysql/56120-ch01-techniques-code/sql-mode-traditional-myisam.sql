ALTER TABLE example ENGINE=MyISAM;
TRUNCATE TABLE example;
SET SESSION sql_mode='TRADITIONAL';
INSERT INTO example (i) VALUES (0), (-1),(255), (9000);
INSERT INTO example (i,c) VALUES (1,'A'),(1,'BB'),(1,'CCC');
SELECT * FROM example;

