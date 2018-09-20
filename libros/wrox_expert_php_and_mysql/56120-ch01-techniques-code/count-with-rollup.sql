SELECT country, COUNT(*) AS color_count
FROM   flags
GROUP  BY country WITH ROLLUP;

SELECT c.color, c.is_dark, COUNT(*)
FROM    colors c, flags f
WHERE c.color = f.color
GROUP BY c.color, c.is_dark WITH ROLLUP;

