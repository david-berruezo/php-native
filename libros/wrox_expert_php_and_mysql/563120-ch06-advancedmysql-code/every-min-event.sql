CREATE EVENT e_minute
ON SCHEDULE EVERY 1 MINUTE
COMMENT 'Perform event every minute'
DO
  INSERT INTO event_test (action,val) VALUES ('Minute',DATE_FORMAT(NOW(),'%i%s'));

