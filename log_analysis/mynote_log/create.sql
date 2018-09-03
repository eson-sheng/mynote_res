drop table if exists `mynote_log`;
      
create table `mynote_log`
(
	`id` serial primary key,
    `datetime` datetime,
    `level` tinyint,
    `class` nvarchar(50),
    `filename` nvarchar(100),
    `reqnum` nvarchar(12),
    `message` text,
    `logger` nvarchar(10),
    KEY `reqnum` (`reqnum`)
)engine=innodb;
