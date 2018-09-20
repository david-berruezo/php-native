TRUNCATE TABLE trans_parent;
DROP TABLE IF EXISTS trans_child;
CREATE TABLE trans_child (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INT UNSIGNED NOT NULL,
  created   TIMESTAMP NOT NULL,
PRIMARY KEY (id),
INDEX (parent_id),
FOREIGN KEY (parent_id) REFERENCES trans_parent(id)
) ENGINE=InnoDB DEFAULT CHARSET latin1;

