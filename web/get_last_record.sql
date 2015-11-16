delimiter //
drop procedure if exists get_last_record;
create procedure get_last_record(in areaNumber int,in inter int,in buyLink int,in num int)
begin
	declare table_name varchar(20);
	declare sql_text varchar(2000);
	declare link varchar(500);
	
	set table_name = concat("record_5173_",areaNumber);
	set sql_text = '';

	if (buyLink = 1) then
		set link = ",buyLink ";
	else
		set link = " ";
	end if;
	
	set sql_text = concat("select numbername,univalence,price,createTime",link,"from ",table_name,",areanumber",
							" where to_days(now()) = to_days(createTime) -", inter,
							" and id=",areanumber+1," order by createTime desc limit ", num);
		select sql_text;
		set @sql_text = sql_text;
		prepare stmt from  @sql_text;
		execute stmt;
		deallocate prepare stmt;
end //
delimiter ;
