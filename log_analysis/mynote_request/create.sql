DROP TABLE IF EXISTS `mynote_request`;
CREATE TABLE IF NOT EXISTS `mynote_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reqnum` varchar(20) DEFAULT NULL,
  `uri` varchar(1024) DEFAULT NULL,
  `sessionid` varchar(40) DEFAULT NULL,
  `params` text,
  `time` varchar(20) DEFAULT NULL,
  `req_time` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mynote_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `reqnum` (`reqnum`),
  ADD KEY `uri` (`uri`),
  ADD KEY `sessionid` (`sessionid`);

ALTER TABLE `mynote_request`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
