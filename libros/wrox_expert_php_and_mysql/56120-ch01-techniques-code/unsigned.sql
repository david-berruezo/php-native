DROP TABLE IF EXISTS example;
CREATE TABLE example (
   int_signed      INT NOT NULL,
   int_unsigned    INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET latin1;

INSERT INTO example (int_signed, int_unsigned) VALUES ( 1, 1);
INSERT INTO example (int_signed, int_unsigned) VALUES ( 0, 0);
INSERT INTO example (int_signed, int_unsigned) VALUES ( -1, 1);
INSERT INTO example (int_signed, int_unsigned) VALUES ( 1, -1);
