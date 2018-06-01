<?php
require('../phpQuery/phpQuery.php');

$doc = phpQuery::newDocument('<html><body><div><ul></ul></div></body></html>');
print_r($doc["html ul"]->elements);

$doc = phpQuery::newDocument('<body><div><ul></ul></div></body>');
print $doc["div > ul"];
