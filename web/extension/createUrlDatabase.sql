use crawler;
create table purchaseurl 
(
   id int unsigned not null auto_increment,
   buyurl varchar(200) not null ,
   price int ,
   coin int ,
   primary key(id)

)default character set utf8 collate utf8_general_ci;

create table location 
(
   id int unsigned not null auto_increment,
   locationp int not null,
   primary key(id)
) default character set utf8 collate utf8_general_ci;

create table areanumber
(
   id int unsigned not null auto_increment,
   areaname varchar(50) not null ,
   numbername varchar(50) not null,
   username varchar(50) not null,
   userlevel int not null,
   primary key(id)
   
) default character set utf8 collate utf8_general_ci;