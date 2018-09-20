SELECT r.color, r.countries, c.is_dark, c.is_primary
FROM colors c,
     (SELECT color, GROUP_CONCAT(country) AS countries
      FROM   flags
      GROUP BY color) r
      WHERE c.color = r.color;
