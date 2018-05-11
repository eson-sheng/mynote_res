<?php
defined('KONG_PATH') || exit;

$arr = array();
$arr[] = array('name' => 'TWCMS', 'url' => 'http://www.twcms.com');
$arr[] = array('name' => 'SEO赚钱培训', 'url' => 'http://www.seo.net.cn');
$arr[] = array('name' => '网络营销培训', 'url' => 'http://www.2010888.com');
$this->kv->set('tw_links', $arr);
