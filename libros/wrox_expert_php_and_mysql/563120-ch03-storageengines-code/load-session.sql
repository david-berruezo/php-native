/* Based on http://datacharmer.blogspot.com/2006/06/filling-test-tables-quickly.html */

delimiter $$

drop procedure if exists make_dates $$
CREATE PROCEDURE make_dates( max_recs int)
begin
  declare updated datetime;
  declare rand_min int;
  declare numrecs int default 1;

  truncate table example_memory_session;
  while numrecs < max_recs
  do
    select round(rand() * 1440) INTO rand_min; 
    set updated = date_format( now() - interval rand_min minute, '%Y-%m-%d %H:%i:00');
    insert into example_memory_session (user_id, session, updated) values (numrecs, REPEAT('A',5), updated);
    set numrecs = numrecs + 1;
  end while;
  select count(*) from example_memory_session;
end $$

delimiter ;
