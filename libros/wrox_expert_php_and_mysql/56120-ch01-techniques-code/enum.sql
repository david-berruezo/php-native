CREATE TABLE example (
  currency  ENUM('USD','CAD','AUD') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET latin1;

INSERT INTO example (currency) VALUES ('AUD');
INSERT INTO example (currency) VALUES ('EUR');
