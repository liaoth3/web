use crawler;
drop table if exists purchaseurl;
create table purchaseurl 
(
   id int unsigned not null auto_increment,
   buyurl varchar(200) not null ,
   areaname varchar(20) not null,
   price int ,
   coin int ,
   primary key(id)

)default character set utf8 collate utf8_general_ci;
drop table if exists location;
create table location 
(
   id int unsigned not null auto_increment,
   locationp int not null,
   primary key(id)
) default character set utf8 collate utf8_general_ci;
drop table  if exists areanumber;
create table areanumber
(
   id int unsigned not null auto_increment,
   areaname varchar(50) not null ,
   numbername varchar(50) not null,
   username varchar(50) not null,
   userlevel int not null,
   primary key(id)
   
) default character set utf8 collate utf8_general_ci;

insert into location(locationp) values(0);
insert into areanumber(areaname,numbername,username,userlevel) values('上海区','上海1区','冷剑逍遥',71);
insert into areanumber(areaname,numbername,username,userlevel) values('广西区','广西1区','黑炎—剑士',71);
insert into areanumber(areaname,numbername,username,userlevel) values('湖北区','湖北1区','嗜血长老',71);
insert into areanumber(areaname,numbername,username,userlevel) values('安徽区','安徽1区','请叫我，小贱',71);
insert into areanumber(areaname,numbername,username,userlevel) values('西北区','西北1区','5456423489',71);
insert into areanumber(areaname,numbername,username,userlevel) values('重庆区','重庆1区','今天打平00',71);
insert into areanumber(areaname,numbername,username,userlevel) values('陕西区','陕西1区','狂灭％天下',71);
insert into areanumber(areaname,numbername,username,userlevel) values('江西区','江西1区','飞の大学',71);
insert into areanumber(areaname,numbername,username,userlevel) values('浙江区','浙江1区','幻之刀刃',71);
insert into areanumber(areaname,numbername,username,userlevel) values('江苏区','江苏1区','啊去我为3',71);
insert into areanumber(areaname,numbername,username,userlevel) values('西南区','西南1区','战线上',71);
insert into areanumber(areaname,numbername,username,userlevel) values('湖南区','湖南1区','一切只为你8',71);
insert into areanumber(areaname,numbername,username,userlevel) values('福建区','福建1区','♀⒈☆',71);
insert into areanumber(areaname,numbername,username,userlevel) values('四川区','四川1区','我我的的你不',71);
insert into areanumber(areaname,numbername,username,userlevel) values('广东区','广东1区','呀热火朝天',71);
insert into areanumber(areaname,numbername,username,userlevel) values('山东区','山东1区','无敌女鬼剑??',71);
insert into areanumber(areaname,numbername,username,userlevel) values('吉林区','吉林1/2区','这是那啊',71);
insert into areanumber(areaname,numbername,username,userlevel) values('黑龙区','黑龙1/2区','花败为谁败',71);
insert into areanumber(areaname,numbername,username,userlevel) values('东北区','东北1区','I、m优秀',71);
insert into areanumber(areaname,numbername,username,userlevel) values('河北区','河北1区','嗜血战魂L5',71);
insert into areanumber(areaname,numbername,username,userlevel) values('辽宁区','辽宁1区','回首、泪囖',71);
insert into areanumber(areaname,numbername,username,userlevel) values('河南区','河南1区','小灰会',71);
insert into areanumber(areaname,numbername,username,userlevel) values('华北区','华北1区','11爱死你11',71);
insert into areanumber(areaname,numbername,username,userlevel) values('北京区','北京1区','qqlulu露露',71);
insert into areanumber(areaname,numbername,username,userlevel) values('东北区','东北3/7区','猫科动舞',71);
insert into areanumber(areaname,numbername,username,userlevel) values('四川区','四川2区','帅【哥】',71);
insert into areanumber(areaname,numbername,username,userlevel) values('山东区','山东2/7区','鬼丶狂战↗',71);
insert into areanumber(areaname,numbername,username,userlevel) values('江苏区','江苏3区','谔谔の我爱你',71);
insert into areanumber(areaname,numbername,username,userlevel) values('河北区','河北2区','魔灬狂丿',71);
insert into areanumber(areaname,numbername,username,userlevel) values('广东区','广东3区','血配者',71);

