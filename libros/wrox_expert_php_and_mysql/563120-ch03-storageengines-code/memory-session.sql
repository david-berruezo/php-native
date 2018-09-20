DROP TABLE IF EXISTS example_memory_session;
CREATE TABLE example_memory_session(
  user_id  INT UNSIGNED NOT NULL,
  session  VARCHAR(1000) NOT NULL,
  created  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated  TIMESTAMP NOT NULL,
PRIMARY KEY(user_id))
ENGINE=Memory;

