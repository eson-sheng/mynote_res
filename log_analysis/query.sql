use `log_data`;
select * from `mynote_request`;
select * from `xjc_nginx`;
select * from `mynote_log`;
truncate `mynote_log`;
#==========================================

#==========================================
show tables;
show databases;
show engines;
describe `requests`;
show create table `requests`;
show table status like 'requests';
select * from information_schema.`TABLE_CONSTRAINTS` where table_schema='requests';