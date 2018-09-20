UPDATE flags INNER JOIN colors USING (color)
SET    flags.color = UPPER(color)
WHERE  colors.is_dark = 'yes';

SELECT color
FROM   flags
WHERE  country = 'USA';
