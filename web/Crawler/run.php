 <?php
 @header("content-type:text/html;charset=GBK");
 error_reporting(E_ALL);
 require_once dirname(__FILE__) . '/common/functions.php';

 //$data = array("startArea"=>$argv[1],"endArea"=>$argv[2],"count"=>$argv[3]);
 //$output = login("http://localhost/web/Crawler/index.php",$data);
 $output = login_with_json_data("http://localhost/web/extension/refresh.php",json_encode(array()));
 echo "$output\n";






