DROP TABLE IF EXISTS `mynote_log`;
CREATE TABLE IF NOT EXISTS `mynote_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `datetime` varchar(15) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `reqnum` varchar(20) DEFAULT NULL,
  `message` text,
  `logger` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mynote_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `reqnum` (`reqnum`);

ALTER TABLE `mynote_log`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
