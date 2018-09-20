TRUNCATE TABLE example;

SET SESSION sql_mode='TRADITIONAL';

INSERT INTO example (i) VALUES (0), (-1),(255), (9000);
INSERT INTO example (c) VALUES ('A'),('BB'),('CCC');
SELECT * FROM example;

INSERT INTO example (i) VALUES (0);
INSERT INTO example (i) VALUES (-1);
INSERT INTO example (i) VALUES (255);
INSERT INTO example (i) VALUES (9000);
INSERT INTO example (c) VALUES ('A');
INSERT INTO example (i,c) VALUES (1,'A');
INSERT INTO example (i,c) VALUES (1,'BB');
INSERT INTO example (i,c) VALUES (1,'CCC');
SELECT * FROM example;

