 <?php
 	@header("content-type:text/html;charset=GBK");
 	error_reporting(E_ALL);
 	require_once dirname(__FILE__) . '/5173/Crawler5173.class.php';
	require_once dirname(__FILE__) . '/common/functions.php';
 	$config = parse_ini_file(dirname(__FILE__) . '/common/config.ini',true);//¼ÓÔØÅäÖÃÎÄ¼þ

	$startArea 	= isset($_POST["startArea"]) ? $_POST["startArea"] : 60;
	$endArea 	= isset($_POST["endArea"]) ? $_POST["endArea"] : 70;
	$count 		= isset($_POST["count"]) ? $_POST["count"] : 1;

 	for($i=0; $i<$count; $i++){
		$output = test5173($config,$startArea, $endArea);
		echo $output;
	}











