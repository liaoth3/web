 <?php
 @header("content-type:text/html;charset=utf-8");
 error_reporting(E_ALL);
 require_once dirname(__FILE__) . '/common/functions.php';

 //$data = array("startArea"=>$argv[1],"endArea"=>$argv[2],"count"=>$argv[3]);
 //$output = login("http://localhost/web/Crawler/index.php",$data);
 $data      = array("method" => "getUrl","area" => "四川区", "fNumber" => "四川1区");
 $jsonStr   = json_encode($data);
 $output    = login_with_json_data("http://localhost/web/extension/refresh.php",$jsonStr);
 echo "$output\n";






