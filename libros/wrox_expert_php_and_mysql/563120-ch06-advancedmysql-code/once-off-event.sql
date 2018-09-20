CREATE EVENT e_nextminute
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE
COMMENT 'Perform event just once'
DO
  INSERT INTO event_test (action,val) VALUES ('1 Minute',DATE_FORMAT(NOW(),'%i%s'));

