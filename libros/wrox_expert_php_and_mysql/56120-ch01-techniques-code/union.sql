SELECT f.country
FROM    flags f
INNER JOIN colors c USING (color)
WHERE c.is_dark = 'yes'
UNION
SELECT f.country
FROM    flags f
INNER JOIN colors c USING (color)
WHERE c.is_primary = 'yes';

