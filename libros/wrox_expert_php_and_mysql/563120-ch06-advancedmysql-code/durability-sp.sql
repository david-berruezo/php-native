use chapter7
drop table if exists durability_test;
create table durability_test (id int unsigned not null auto_increment primary key, c1 varchar(2000) not null) engine = innodb default charset latin1;

delimiter $$

drop procedure if exists fill_durability $$
create procedure fill_durability()
deterministic
begin
  declare counter int default 0;
  truncate table durability_test;
  while TRUE
  do
    start transaction;
    set counter := 0;
    while counter < 10
    do
      insert into durability_test(c1) values (repeat ('Expert PHP and MySQL',100));
      set counter := counter + 1;
    end while;
    commit;
  end while;
end $$
delimiter ;

call fill_durability();

