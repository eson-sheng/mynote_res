drop table if exists `mynote_request`;

create table `mynote_request`
(
	`id` serial primary key,
    `reqnum` bigint,
    `uri` nvarchar(1024),
    `sessionid` nvarchar(40),
    `params` text,
    `time` nvarchar(20),
    KEY `reqnum` (`reqnum`),
    KEY `uri` (`uri`),
    KEY `sessionid` (`sessionid`)
)engine=innodb;
