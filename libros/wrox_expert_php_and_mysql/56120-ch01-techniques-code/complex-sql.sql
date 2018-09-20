SELECT
  group_concat(
    IF(round(sqrt(pow(col_number/@stretch-0.5-(@size-1)/2, 2) + 
       pow(row_number-(@size-1)/2, 2))) BETWEEN @radius*2/3 AND @radius,
    (SELECT SUBSTRING(@colors, name_order, 1) FROM
      (
      SELECT
        name_order,
        name_column,
        value_column,
        accumulating_value,
        accumulating_value/@accumulating_value AS accumulating_value_ratio,
        @aggregated_data := CONCAT(@aggregated_data, name_column, ': ', 
           value_column, ' (', ROUND(100*value_column/@accumulating_value), '%)',
           '|') AS aggregated_name_column,
        2*PI()*accumulating_value/@accumulating_value AS accumulating_value_radians
      FROM (
        SELECT
          name_column,
          value_column,
          @name_order := @name_order+1 AS name_order,
          @accumulating_value := @accumulating_value+value_column 
            AS accumulating_value
        FROM (
          <strong>SELECT name AS name_column, value AS value_column 
             FROM sample_values2 LIMIT 4</strong>
          ) select_values,
          (SELECT @name_order := 0) select_name_order,
          (SELECT @accumulating_value := 0) select_accumulating_value,
          (SELECT @aggregated_data := '') select_aggregated_name_column
        ) select_accumulating_values
      ) select_for_radians
    WHERE accumulating_value_radians &gt;= radians LIMIT 1
    ), ' ')
    order by col_number separator '') as pie
FROM (
  SELECT
    t1.value AS col_number,
    t2.value AS row_number,
    @dx := (t1.value/@stretch - (@size-1)/2) AS dx,
    @dy := ((@size-1)/2 - t2.value) AS dy,
    @abs_radians := IF(@dx = 0, PI()/2, (atan(abs(@dy/@dx)))) AS abs_radians,
    CASE
      WHEN SIGN(@dy) &gt;= 0 AND SIGN(@dx) &gt;= 0 THEN @abs_radians
      WHEN SIGN(@dy) &gt;= 0 AND SIGN(@dx) &lt;= 0 THEN PI()-@abs_radians
      WHEN SIGN(@dy) &lt;= 0 AND SIGN(@dx) &lt;= 0 THEN PI()+@abs_radians
      WHEN SIGN(@dy) &lt;= 0 AND SIGN(@dx) &gt;= 0 THEN 2*PI()-@abs_radians
    END AS radians
  FROM
    tinyint_asc t1,
    tinyint_asc t2,
    (select @size := 23) sel_size,
    (select @radius := (@size/2 - 1)) sel_radius,
    (select @stretch := 4) sel_stretch,
    (select @colors := '#;o:X"@+-=123456789abcdef') sel_colors
  WHERE
    t1.value &lt; @size*@stretch
    AND t2.value &lt; @size) select_combinations
  GROUP BY row_number
UNION ALL
  SELECT
    CONCAT(
      REPEAT(SUBSTRING(@colors, value, 1), 2),
      '  ',
      SUBSTRING_INDEX(SUBSTRING_INDEX(@aggregated_data, '|', value), '|', -1)
    )
  FROM
    tinyint_asc
  WHERE
    value BETWEEN 1 AND @name_order
;