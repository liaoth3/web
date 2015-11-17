delimiter //
drop procedure if exists create_5173_table;
create procedure create_5173_table()
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
		set sql_text = concat('create table ',table_name,'(
			record_id int primary key auto_increment,
			univalence decimal(7,2) not null default 0,
			goldAmount decimal(7,2) not null default 0,
			price decimal(7,2) not null default 0,
			itemAmount tinyint not null default 1, 
			ensure tinyint,
			consign tinyint,
			sale tinyint,
			payfor tinyint,
			free tinyint,
			magic tinyint,
			platform varchar(10),
			credit varchar(10),
			createTime datetime,
			buylink varchar(150)
		)engine=myIsam charset = utf8');
		select sql_text;
		set @sql_text = sql_text;
		prepare stmt from  @sql_text;
		execute stmt;
		deallocate prepare stmt;
		set suffix = suffix + 1;
	end while;
end //
delimiter ;
