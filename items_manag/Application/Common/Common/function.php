<?php
#==================================================================
#封装公共的CURL函数，供后端调用页面。
function curl($url,$postdata=[]){
    $curl = curl_init();
    $url='http://'.IP.$url;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    if($postdata){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postdata));
        #http_build_query可封装多维数组
    }
    if(!$result=curl_exec($curl))
    {
        dump(curl_error($curl));
    }
    curl_close($curl);
    return $result;
}
#==================================================================
function allowAccess(){#供前端ajax跨域访问用
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:GET,POST");
}
#供前端调用后端接口的json数据封装。
function successInfo($msg,$data){
    return buildInfo('success',$msg,$data);
}
function errorInfo($msg){
    return buildInfo('error',$msg,'');
}
function buildInfo($result,$messsge,$data){
    $arr=['result'=>$result, 'message'=>$messsge, 'data'=>$data];
    return json_encode($arr);
}