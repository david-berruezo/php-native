SELECT f.color, c.is_primary, c.is_dark, c.is_rainbow
FROM   flags f
INNER JOIN colors c USING (color)
WHERE  f.country='USA';
