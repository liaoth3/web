 <?php
 @header("content-type:text/html;charset=GBK");
 error_reporting(E_ALL);
 require_once dirname(__FILE__) . '/common/functions.php';

 $data = array("startArea"=>$argv[1],"endArea"=>$argv[2],"count"=>$argv[3]);
 $output = login("http://localhost/web/Crawler/index.php",$data);
 echo "$output\n";







