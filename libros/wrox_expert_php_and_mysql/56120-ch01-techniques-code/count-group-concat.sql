SELECT country, GROUP_CONCAT(color) AS colors
FROM   flags
GROUP BY country;

SELECT country, GROUP_CONCAT(color) AS colors, COUNT(*) AS color_count
FROM   flags
GROUP BY country;

