SELECT country, GROUP_CONCAT(color) AS colors    
FROM   flags
GROUP BY country
HAVING COUNT(*) = 2;

