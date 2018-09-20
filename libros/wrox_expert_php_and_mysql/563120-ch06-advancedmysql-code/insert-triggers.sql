DELIMITER $$
DROP TRIGGER IF EXISTS trigger_test_bri$$
CREATE TRIGGER trigger_test_bri 
BEFORE INSERT ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Insert',NOW(),NEW.id);
$$
DROP TRIGGER IF EXISTS trigger_test_ari$$
CREATE TRIGGER trigger_test_ari 
AFTER INSERT ON trigger_test
FOR EACH ROW
  INSERT INTO logger(action,occured,id) VALUES('Insert',NOW(),NEW.id);
$$
DELIMITER ;

