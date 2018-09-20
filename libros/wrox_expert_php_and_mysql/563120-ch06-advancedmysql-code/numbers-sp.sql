use chapter7
drop table if exists numbers;
create table numbers (id int unsigned not null primary key);

delimiter $$

drop procedure if exists fill_numbers $$
create procedure fill_numbers(in p_max int)
deterministic
begin
  declare counter int default 1;
  truncate table numbers;
  insert into numbers values (1);
  while counter < p_max
  do
      insert into numbers (id)
          select id + counter
          from numbers;
      select count(*) into counter from numbers;
      select counter;
  end while;
end $$
delimiter ;

call fill_numbers(2000000);

