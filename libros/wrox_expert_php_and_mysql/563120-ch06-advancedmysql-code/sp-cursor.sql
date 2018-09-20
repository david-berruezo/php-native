DELIMITER //
DROP FUNCTION IF EXISTS cursor_example//
CREATE PROCEDURE cursor_example ()
BEGIN
  DECLARE l_user VARCHAR(50);
  DECLARE done BOOLEAN DEFAULT FALSE;
  DECLARE cur1 CURSOR FOR SELECT user FROM mysql.user;
  DECLARE CONTINUE HANDLER FOR NOT FOUND 
    SET done = TRUE;
  
  OPEN cur1;

  lab: 
  LOOP
    FETCH cur1 INTO l_user;
    IF (done) THEN
      LEAVE lab;
    END IF;
  END LOOP;
END//  
  
DELIMITER ;
