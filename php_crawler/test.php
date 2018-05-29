<?php

include_once 'phpQuery-onefile.php';

$page=file_get_contents('http://www.baidu.com/s?wd=note');

$doc=phpQuery::newDocument($page);

phpQuery::selectDocument($doc);

$result=pq('#page > a')->filter(':last');

var_dump(pq($result)->attr('href'));