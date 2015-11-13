<?php
header("content-type:application/json; charset:utf-8");
date_default_timezone_set("Asia/Shanghai");
$rawData = file_get_contents("php://input");
$parameters = json_decode($rawData);
 $arr["area"]=$parameters->area;
 $arr["fNumber"]=$parameters->fNumber;
 $area=trim($arr["area"]);
 $fNumber=trim($arr["fNumber"]);
$list=array();

if(empty($arr["area"])){
	$userlist=Array("user"=>"我我的的你不","rank"=>"70");
	exit(json_encode($userlist));

}
if(empty($arr["fNumber"])){
	$userlist=Array("user"=>"我我的的你不","rank"=>"70");
	exit(json_encode($userlist));
}
$list=getUser($area,$fNumber);


if(array_key_exists("fail",$list)){
	exit(json_encode(array ('message'=>'the area username not exit.')));
}
else{
	exit(json_encode($list));
}
exit(json_encode(array ('error'=>'the get username fail.')));


function getUser($arr1,$arr2){
	writeFile($arr2."/".$arr1);
	$mysql_server_name="localhost";
	$mysql_username="root";
	$mysql_password="";
	$mysql_database="urldatabase";
	try{
		$conn=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
		if(!$conn){
			printf("不能连接到MySQL. 错误代码: %sn", mysqli_connect_error());
			exit;
		}
		$querychar = "set names utf8";
		mysqli_query($conn,$querychar);
		$query="select username,userlevel from areanumber where areaname='$arr1' and numbername='$arr2'";
		writeFile($query);
		$result=mysqli_query($conn,$query);
		while ($row=mysqli_fetch_assoc($result)){
			$userlist["username"]=$row['username'];
			$userlist["userlevel"]=$row['userlevel'];
		}
		mysqli_close($conn);
	if( !empty($userlist["username"])&& !empty($userlist["userlevel"])){
			return $userlist;
		}
		else {
			return $userlist=array ('message'=>'没有该区的角色.');
		}

	}catch (Exception $e){
		return $userlist['fail']="fail";
	}
}

function writeFile($param){
	$param=$param."\n";
	$handle = fopen("hello.txt", "w+");
	fwrite($handle,$param);
	fclose($handle);
}

?>
