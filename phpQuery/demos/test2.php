<?php
require('../phpQuery/phpQuery.php');

$html = "<p><div>1</div><div class='c1'>2</div> </p>";
$doc = phpQuery::newDocument($html);
phpQuery::selectDocument($doc);
$ps = pq("div");
$r = [];
print_r($ps->elements);
foreach($ps as $p) {
    $one = [];
    $one['name'] = $p->tagName;
    $one['value'] = $p->nodeValue;
    $r[] = $one;
}
print_r($r);
