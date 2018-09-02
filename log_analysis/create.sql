create database `log_data` default character set utf8 collate utf8_general_ci;
#drop database `log_data`;
use `log_data`;
#mysqldump -uroot log_data >D:\log_data.bak -p  #备份
#mysql -uroot log_data < D:\log_data.bak -p  #还原

-- 日志查看行数存储
DROP TABLE IF EXISTS `mynote_indexfile`;
CREATE TABLE IF NOT EXISTS `mynote_indexfile`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `indexfile_path` VARCHAR(128) NOT NULL COMMENT '日志绝对路径',
    `last_end_index` VARCHAR(128) NOT NULL COMMENT '日志读取行数',
    PRIMARY KEY(`id`),
    UNIQUE KEY `id` (`id`),
    UNIQUE KEY `indexfile_path` (`indexfile_path`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志查看行数存储';