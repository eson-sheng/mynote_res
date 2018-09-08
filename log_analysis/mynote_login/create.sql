DROP TABLE IF EXISTS `mynote_login`;
CREATE TABLE IF NOT EXISTS `mynote_login` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `datetime` varchar(15) DEFAULT NULL,
  `reqid` varchar(100) DEFAULT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `sessionid` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mynote_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `reqid` (`reqid`),
  ADD KEY `sessionid` (`sessionid`),
  ADD KEY `uid` (`uid`);

ALTER TABLE `mynote_login`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
