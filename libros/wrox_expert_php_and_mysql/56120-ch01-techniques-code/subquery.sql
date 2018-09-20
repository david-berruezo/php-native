SELECT color
FROM colors
WHERE color IN 
 (SELECT color
  FROM flags);

