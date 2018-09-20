TRUNCATE TABLE example_memory
LOAD DATA INFILE '/usr/share/dict/words' INTO TABLE example_memory (c);

SELECT table_name,table_rows,row_format,
       data_length/1024 AS data,index_length/1024 AS indx
FROM   INFORMATION_SCHEMA.TABLES 
WHERE  table_name LIKE 'example_memory%';

SHOW GLOBAL VARIABLES LIKE 'max_heap_table_size';

SET SESSION max_heap_table_size = 256*1024*1024;

TRUNCATE TABLE example_memory;

LOAD DATA INFILE '/tmp/words' INTO TABLE example_memory (c);

SELECT table_name,table_rows,row_format,
       data_length/1024 AS data,index_length/1024 AS indx
FROM   INFORMATION_SCHEMA.TABLES 
WHERE  table_name LIKE 'example_memory%';
