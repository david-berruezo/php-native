DELIMITER $$
DROP TRIGGER IF EXISTS trigger_test_bru$$
CREATE TRIGGER trigger_test_bru 
BEFORE UPDATE ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Update',NOW(),OLD.id);
$$
DROP TRIGGER IF EXISTS trigger_test_aru$$
CREATE TRIGGER trigger_test_aru 
AFTER UPDATE ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Update',NOW(),NEW.id);
$$
DELIMITER ;

