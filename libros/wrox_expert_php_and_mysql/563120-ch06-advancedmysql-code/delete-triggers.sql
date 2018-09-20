DELIMITER $$
DROP TRIGGER IF EXISTS trigger_test_brd$$
CREATE TRIGGER trigger_test_brd 
BEFORE DELETE ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Delete',NOW(),OLD.id);
$$
DROP TRIGGER IF EXISTS trigger_test_ard$$
CREATE TRIGGER trigger_test_ard 
AFTER DELETE ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Delete',NOW(),OLD.id);
$$
DELIMITER ;

