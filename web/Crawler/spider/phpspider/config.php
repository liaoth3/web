<?php

$GLOBALS['config']['db'] = array(
    'host'=>'127.0.0.1',
    'user'=>'root',
    'pass'=>'root',
    'name'=>'test',
);

$GLOBALS['config']['redis'] = array(
    'host'=>'127.0.0.1',
    'port'=>6379,
);

$GLOBALS['config'] = parse_ini_file(dirname(__FILE__) . "/config.ini",true);

function getUrl($url,$lowPrice=0, $highPrice=500, $page=1, $type=1){//$type=1 平常，$type=2 批发
    if($type==1){
        return $url."-0-bx1xiv-0-0-0-a-a-a-"."$lowPrice-$highPrice-0-itemprice_asc-1-$page.shtml";
    }else{
        return $url."-0-3juw0c-0-0-0-a-a-a-"."$lowPrice-$highPrice-0-itemprice_asc-1-$page.shtml";
    }
}