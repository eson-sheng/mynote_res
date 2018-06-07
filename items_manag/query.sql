use `items_manag`;
select * from `subcompanies`;
select * from `item_types`;
select * from `items`;
select * from `records`;
select * from `operators`;
#==========================================

#==========================================
show tables;
show databases;
show engines;
describe `subcompanies`;
show create table `subcompanies`;
show table status like 'items_manag';
select * from information_schema.`TABLE_CONSTRAINTS` where table_schema='items_manag';