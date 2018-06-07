create database `items_manag` default character set utf8 collate utf8_general_ci;
#drop database `items_manag`;
use `items_manag`;
#mysqldump -uroot items_manag >D:\items_manag.bak -p  #备份
#mysql -uroot items_manag < D:\items_manag.bak -p  #还原
#======================================
drop table if exists `subcompanies`;
create table `subcompanies`
(
	`id` serial primary key,
    `name` nvarchar(50) comment '子公司名',
    `deleted` boolean default 0
)engine=innodb;
insert into `subcompanies`(`name`) values
('子公司1'),('子公司2');
#======================================
drop table if exists `item_types`;
create table `item_types`
(
	`id` serial primary key,
    `name` nvarchar(10) comment '物品类型名',
	`deleted` boolean default 0
)engine=innodb;
insert into `item_types`(`name`) values
('证照类'),('印件类'),('其他类');
#======================================
drop table if exists `items`;
create table `items`
(
	`id` serial primary key,
    `typeid` bigint unsigned,
    `companyid` bigint unsigned,
    `name`  nvarchar(20) comment '物品名',
	`deleted` boolean default 0
)engine=innodb;
insert into `items`(`typeid`,`companyid`,`name`) values
(1,1,'证照1'),(1,1,'证照2'),(2,1,'印件1'),(2,2,'印件2'),(3,2,'其他物品1');
#======================================
drop table if exists `records`;
create table `records`
(
	`id` serial primary key,
    `itemid` bigint unsigned,
    `operatorid` bigint unsigned,
    `time`  datetime comment '操作时间',
    `person` nvarchar(10) comment '借走的人，或归还的人',
    `status` varchar(15) comment '状态：out借走、back归还',
    `comment` text comment '备注',
	`deleted` boolean default 0
)engine=innodb;
insert into `records`(`itemid`,`operatorid`,`time`,`person`,`status`,`comment`) values
(1,2,'2018-1-2 10:31:22','大师傅','out','tel: 13511112222，啥来的咖啡进来撒快递费历史卡，的非吉拉斯卡的房间拉，斯卡的房间历史卡的非，冻死了开发骄傲了速度快房间里卡士大夫，上岛咖啡开始了对方吉拉斯卡地方，两点开始放假'),
(2,1,'2018-2-3 14:21:5','第三方','back','去办一些事，收到了发卡机数量的看法，速度快放假死了快递费，思考地方，上岛咖啡');
#======================================
drop table if exists `operators`;
create table `operators`
(
    `id` serial primary key,
    `companyid` bigint unsigned,
    `type` varchar(20) comment '操作员类型：admin,normal',
    `name` nvarchar(10) comment '操作员登录名',
    `pwd` varchar(50) comment '操作员登录密码',
	`deleted` boolean default 0
)engine=innodb;
insert into `operators`(`companyid`,`type`,`name`,`pwd`) values
(1,'admin','a','4124bc0a9335c27f086f24ba207a4912'),
(2,'admin','b','21ad0bd836b90d08f4cf640b4c298e7c'),
(1,'normal','c','e0323a9039add2978bf5b49550572c7c'),
(2,'normal','d','1aabac6d068eef6a7bad3fdf50a05cc8');