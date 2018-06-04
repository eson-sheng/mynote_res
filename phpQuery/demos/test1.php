<?php
require('../phpQuery/phpQuery.php');

$html = "<p>1</p><p>2</p>";
$doc = phpQuery::newDocument($html);
phpQuery::selectDocument($doc);
$ps = pq("p");
$r = [];
foreach($ps as $p) {
    $one = [];
    $one['name'] = $p->tagName;
    $one['value'] = $p->nodeValue;
    $r[] = $one;
}
print_r($r);

echo "-----------------each:<br>\n";

// $node is DOMElement
function test_each($node) {
    print_r(pq($node));
}

$ps->each("test_each");
