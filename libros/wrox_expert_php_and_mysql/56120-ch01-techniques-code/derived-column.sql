SELECT DISTINCT f.country,(SELECT GROUP_CONCAT(color) FROM flags f2 WHERE f2.country = f.country) AS colors
FROM   flags f;

