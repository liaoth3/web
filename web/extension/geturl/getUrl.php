<?php
header("content-type:application/json; charset:utf-8");
date_default_timezone_set("Asia/Shanghai");
$rawData = file_get_contents("php://input");
// $parameters = json_decode($rawData);
$arrUrl=getUrl();
if(array_key_exists("fail",$arrUrl)){
	exit(json_encode(array ('message'=>'没有新的URL.')));
}
else{
	exit(json_encode($arrUrl));
}
exit(json_encode(array ('error'=>'请求不正确.')));
 
function getUrl(){
	$mysql_server_name="localhost";
	$mysql_username="root";
	$mysql_password="root";
	$mysql_database="urldatabase";
	try{
		$conn=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
		if(!$conn){
			printf("不能连接到MySQL. 错误代码: %sn", mysqli_connect_error());
			exit;		
		}		
		$queryLocation="select * from location";
		$resultLocation=mysqli_query($conn,$queryLocation);
		while ($rowLocation=mysqli_fetch_assoc($resultLocation)){
			$key1=$rowLocation['id'];
			$arrL[$key1]=$rowLocation['locationp'];
		}
		mysqli_free_result($resultLocation);
		$query="select id,buyurl from purchaseurl where id>".$arrL[1];
		$result=mysqli_query($conn,$query);
		while ($row=mysqli_fetch_assoc($result)){
			$key=$row['id'];
			$arr[$key]=$row['buyurl'];
		}
		mysqli_free_result($result);
		if($key!=null||$key!=""){
			$queryUpdate="update location set locationp=".$key." where id=1";
			mysqli_query($conn,$queryUpdate);
		}
		mysqli_close($conn);
		if(count($arr)==0){
			$arr['fail']="fail";
		}
		return $arr;
	}catch (Exception $e){
		return $arr['fail']="fail";
	}
}