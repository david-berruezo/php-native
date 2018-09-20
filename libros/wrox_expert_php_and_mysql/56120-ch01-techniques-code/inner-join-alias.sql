SELECT f.color, c.is_primary, c.is_dark, c.is_rainbow
FROM   flags f
INNER JOIN colors c ON f.color = c.color
WHERE  f.country='USA';
