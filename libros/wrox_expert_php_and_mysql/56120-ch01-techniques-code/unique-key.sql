CREATE TABLE example (
 int_unique           INT UNSIGNED NOT NULL,
 int_nullable_unique  INT UNSIGNED NULL,
 UNIQUE KEY (int_unique),
 UNIQUE KEY(int_nullable_unique)
) ENGINE=InnoDB DEFAULT CHARSET latin1;

INSERT INTO example (int_unique, int_nullable_unique) VALUES (1, 1);
INSERT INTO example (int_unique, int_nullable_unique) VALUES (2, NULL);
INSERT INTO example (int_unique, int_nullable_unique) VALUES (3, NULL);
INSERT INTO example (int_unique, int_nullable_unique) VALUES (1, NULL);

INSERT INTO example (int_unique, int_nullable_unique) VALUES (4, 1);

SELECT * FROM example;

