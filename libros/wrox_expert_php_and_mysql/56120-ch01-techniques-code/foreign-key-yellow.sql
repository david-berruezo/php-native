INSERT INTO colors (color,is_primary,is_dark,is_rainbow) VALUES ('Yellow','no','no','yes');

ALTER TABLE flags ADD FOREIGN KEY (color) REFERENCES colors (color) ON DELETE CASCADE;

SELECT * FROM colors WHERE color='Yellow';

SELECT * FROM flags WHERE country IN (SELECT country from flags WHERE color='Yellow');

