drop table if exists `mynote_log`;
      
create table `mynote_log`
(
	`id` serial primary key,
    `datetime` datetime,
    `level` tinyint,
    `uri` nvarchar(1024),
    `class` nvarchar(50),
    `filename` nvarchar(100),
    `reqid` nvarchar(12),
    `message` text
)engine=innodb;
