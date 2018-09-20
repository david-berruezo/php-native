SELECT DISTINCT f.color
FROM flags f
WHERE EXISTS
 (SELECT 1
  FROM colors c
  WHERE c.color = f.color);

