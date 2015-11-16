delimiter //
drop procedure if exists convert_to_utf8;
create procedure convert_to_utf8()
begin
	declare suffix int;
	declare table_name varchar(20);
	declare sql_text varchar(2000);
	declare amount int;
	declare table_pre varchar(20);

	set suffix = 0;
	set amount  = 116;
	set table_pre = 'record_5173_';
	set table_name = '';
	set sql_text = '';

	while suffix < amount do
		set table_name = concat(table_pre,suffix);
		set sql_text = concat("alter table ", table_name, " convert to character set utf8");
		select sql_text;
		set @sql_text = sql_text;
		prepare stmt from  @sql_text;
		execute stmt;
		deallocate prepare stmt;
		set suffix = suffix + 1;
	end while;
end //
delimiter ;
