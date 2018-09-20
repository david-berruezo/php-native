SELECT f.color, c.is_primary, c.is_dark, c.is_rainbow
FROM   flags f, colors c
WHERE  f.country='USA'
AND    f.color = c.color;
