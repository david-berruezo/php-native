DELIMITER //
DROP PROCEDURE IF EXISTS sample_no_param//
CREATE PROCEDURE sample_no_param()
BEGIN 
  SELECT 1 + 1;
END//

DROP PROCEDURE IF EXISTS sample_2_param//
CREATE PROCEDURE sample_2_param(param1 INT, param2 INT)
BEGIN
  SELECT param1 + param2;
END//

CREATE PROCEDURE sample_out(OUT o_param INT)
BEGIN
  SELECT 1 + 1 INTO o_param;
END//

CREATE FUNCTION sample_func(param1 INT) 
RETURNS INT
BEGIN
  RETURN 1 + param1;
END//

DELIMITER ;
