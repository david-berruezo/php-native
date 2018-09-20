SELECT flags.color, colors.is_primary, colors.is_dark, colors.is_rainbow
FROM   flags
INNER JOIN colors ON flags.color = colors.color
WHERE  flags.country='USA';
