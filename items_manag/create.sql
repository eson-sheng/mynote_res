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