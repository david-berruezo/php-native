SELECT table_schema,table_name,engine, table_rows, avg_row_length,
      (data_length+index_length)/1024/1024 as total_mb, 
      (data_length)/1024/1024 as data_mb, 
      (index_length)/1024/1024 as index_mb
FROM   information_schema.tables 
WHERE  table_schema=DATABASE()
ORDER  BY 7 DESC
LIMIT  5;

