drop table if exists `mynote_login`;
      
create table `mynote_login`
(
	`id` serial primary key,
    `datetime` datetime,
    `reqid` nvarchar(100),
    `nickname` nvarchar(50),
    `sessionid` nvarchar(100),
    `status` tinyint
)engine=innodb;
