<?php
header("Content-type:text/html;charset=GBK");
include "phpspider/config.php";
include "phpspider/db.php";
include "phpspider/cache.php";
include "phpspider/rolling_curl.php";
include "user.php";

$cookie = trim(file_get_contents("cookie.txt"));

$curl = new rolling_curl();
//$curl->set_cookie($cookie);
$curl->set_gzip(true);
$curl->callback = function($response, $info, $request, $error) {
    echo !empty($response) ? nl2br("response: " . $response) : nl2br("no");
    echo !empty($info) ? nl2br("info: " . $error) : nl2br("no");
    echo !empty($request) ? nl2br("request: " . $error) : nl2br("no");
    echo !empty($error) ? nl2br("error: " . $error) : nl2br("no");
    };
$urls = $GLOBALS["config"]["5173"]["url"];
for ($j = 0; $j < 1; $j++) 
{
    foreach($urls as $url)
    {
        $url = getUrl($url);
        $curl->get($url);
    }
    $data = $curl->execute();
    sleep(3);
}
