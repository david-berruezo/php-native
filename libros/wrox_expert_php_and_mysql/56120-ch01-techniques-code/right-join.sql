SELECT c.color, c.is_primary
FROM   colors c
LEFT JOIN  flags f USING (color)
WHERE f.country IS NULL;

SELECT c.color, c.is_primary
FROM   flags f
RIGHT JOIN colors c USING (color)
WHERE f.country IS NULL;
