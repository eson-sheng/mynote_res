drop table if exists `mynote_request`;
create table `mynote_request`
(
	`id` serial primary key,
    `num` bigint,
    `uri` nvarchar(100),
    `sessid` nvarchar(20),
    `params` nvarchar(100),
    `time` nvarchar(20)
)engine=innodb;
