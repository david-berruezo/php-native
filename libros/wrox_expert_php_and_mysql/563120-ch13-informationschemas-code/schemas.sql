SELECT table_schema,
       SUM(data_length+index_length)/1024/1024 AS total_mb,
       SUM(data_length)/1024/1024 AS data_mb,
       SUM(index_length)/1024/1024 AS index_mb,
       COUNT(*) AS tables
FROM   information_schema.tables
GROUP BY table_schema
ORDER BY 2 DESC;

