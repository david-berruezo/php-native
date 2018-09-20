SELECT f.country, f.color
FROM   flags f
LEFT OUTER JOIN colors c USING (color)
WHERE  c.color IS NULL;

SELECT c.color, c.is_primary
FROM   colors c
LEFT OUTER JOIN  flags f USING (color)
WHERE f.country IS NULL;

