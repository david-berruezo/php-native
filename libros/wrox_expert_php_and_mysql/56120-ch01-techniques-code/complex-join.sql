SELECT f1.country, c.population, IFNULL(ci.city,'Not Recorded') AS city, s.abbr, s.state
FROM   flags f1 
INNER JOIN flags f2 ON f1.country = f2.country
INNER JOIN flags f3 ON f1.country = f3.country
INNER JOIN countries c ON f1.country = c.country
LEFT JOIN cities ci ON f1.country = ci.country AND ci.is_country_capital = 'yes'
LEFT JOIN states s  ON f1.country = s.country AND ci.state = s.state
WHERE f1.color = 'Red'
AND   f2.color = 'White'
AND   f3.color = 'Blue';
