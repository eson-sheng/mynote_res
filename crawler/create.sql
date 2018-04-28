#drop database `crawler`;
#create database `crawler` default character set utf8 collate utf8_general_ci;
use `crawler`;
#mysqldump -uroot crawler >D:\crawler.bak #备份(-p password)
#mysql -uroot crawler < D:\crawler.bak #还原(-p password)
#======================================
drop table if exists `links`;
create table `links`
(
	`id` serial primary key,
    `keyword` nvarchar(30),
    `page` smallint,
    `link` nvarchar(50),
    `date` date
)engine=innodb;