use `log_data`;
select * from `requests`;
truncate `requests`;
#==========================================

#==========================================
show tables;
show databases;
show engines;
describe `requests`;
show create table `requests`;
show table status like 'requests';
select * from information_schema.`TABLE_CONSTRAINTS` where table_schema='requests';