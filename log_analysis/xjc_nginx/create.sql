drop table if exists `xjc_nginx`;
create table `xjc_nginx`
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
    `ua` nvarchar(100),
    `forward` nvarchar(20)
)engine=innodb;

