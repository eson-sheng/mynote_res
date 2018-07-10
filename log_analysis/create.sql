create database `log_data` default character set utf8 collate utf8_general_ci;
#drop database `log_data`;
use `log_data`;
#mysqldump -uroot log_data >D:\log_data.bak -p  #备份
#mysql -uroot log_data < D:\log_data.bak -p  #还原
#======================================
drop table if exists `requests`;
create table `requests`
(
	`id` serial primary key,
    `num` bigint,
    `uri` nvarchar(100),
    `sessid` nvarchar(20),
    `params` nvarchar(100),
    `time` nvarchar(20)
)engine=innodb;
#======================================
drop table if exists `requests2`;
create table `requests2`
(
	`id` serial primary key,
    `ip` nvarchar(20),
    `sessid` nvarchar(50),
    `time` nvarchar(50),
    `request_time` nvarchar(20),
    `ur_time` nvarchar(20),
    `request` nvarchar(80),
    `status` nvarchar(10),
    `bytes_sent` nvarchar(20),
    `ua` nvarchar(50),
    `forward` nvarchar(20)
)engine=innodb;