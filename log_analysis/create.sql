-- 日志查看行数存储
DROP TABLE IF EXISTS `mynote_indexfile`;

CREATE TABLE IF NOT EXISTS `mynote_indexfile` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `indexfile_path` varchar(128) NOT NULL COMMENT '日志绝对路径',
  `last_end_index` varchar(128) NOT NULL COMMENT '日志读取行数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志查看行数存储';

ALTER TABLE `mynote_indexfile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `indexfile_path` (`indexfile_path`);

ALTER TABLE `mynote_indexfile`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID';