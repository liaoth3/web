delimiter //
drop procedure if exists search;
create procedure search(in s int,	 in e int, in price int)
begin
	declare sql_text varchar(20000);
	declare table_name varchar(20);
	declare suffix int;
	declare table_pre varchar(20);
	
	set suffix = s;
	set table_pre = "record_5173_";
	set table_name = concat(table_pre, suffix);
	set sql_text = concat('(select univalence, price ,createTime from ',
							table_name,
							')'); 
	while suffix < e do
		set suffix = suffix + 1;
		set table_name = concat(table_pre, suffix);
		set sql_text = concat(sql_text, 
								' union ',
								'(select univalence,price,createTime from ',
								table_name,
								')');
	end while;
	set sql_text = concat(sql_text,' order by univalence desc  limit 100');  	
	select sql_text;
	set @sql_text = sql_text;
	prepare  stmt from  @sql_text;
	execute stmt;
	deallocate prepare stmt;
end //

delimiter ;
