SELECT f.color, c.is_primary, c.is_dark, c.is_rainbow
FROM   flags f
NATURAL JOIN colors c
WHERE  f.country='USA';
