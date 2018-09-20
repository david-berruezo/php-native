SELECT IF (2 > 1,'2 is greater then 1','2 is not greater then 1') AS answer;
SELECT @value,
 CASE
   WHEN @value < 3 THEN 'Value is < 3'
   WHEN @value > 6 THEN 'Value is > 6'
   WHEN @value = 3 OR @value = 6 THEN 'Value is 3 or 6'
   ELSE 'Value is 4 or 5'
   END;

SELECT IFNULL(NULL,'Value is NULL') AS result1, IFNULL(1 > 2, 'NULL result') AS result2;
SELECT NULLIF(TRUE,TRUE) AS istrue ,NULLIF(TRUE,FALSE) AS isfalse, NULLIF(TRUE,NULL) AS isnull;
