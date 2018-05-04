<?php
ob_start();
//========================================
$__db_host = "localhost";
$__db_uname = "root";
$__db_pwd = "root";

if (file_exists("invoke.my.php")) {
	require_once("invoke.my.php");
}

function createDB(){
	global $__db_host,$__db_uname,$__db_pwd;
	$conn=mysql_connect($__db_host,$__db_uname,$__db_pwd);
	mysql_query("set names 'utf8'");
	mysql_select_db("plusoft_test",$conn);
	return $conn;
}
//========================================
$methodName = $_GET["method"];
if($methodName != null){
	eval("\$method = ".$methodName.";");
	
	if($method != null) $method();
}
function request($name){
	$value = $_GET[$name];
	if($value == null){
		$value = $_POST[$name];
	}
	return $value;
}
function writeJSON($obj){	
	
	if(is_string($obj)) {
		ob_end_clean();
		print_r($obj);
	}else {
		$json = json_encode($obj);		
		ob_end_clean();
		print_r($json);
	}
}
function gbk2utf8($data){
	if(is_array($data)){
		return array_map('gbk2utf8', $data);
	}
	return iconv('gbk','utf-8',$data);
}
function php_json_decode($str){
	$stripStr = stripslashes($str);
	$json = json_decode($stripStr,true);
	return $json;
}

?>