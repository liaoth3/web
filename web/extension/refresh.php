<?php
header("content-type:application/json; charset:utf-8");
require_once dirname(__FILE__) . "/../Crawler/common/Sql.class.php";
require_once dirname(__FILE__) . "/../lib/mail/sendMail.php";

echo json_encode(response());

function response(){
    try{
        $input        = file_get_contents("php://input");
        if(strlen($input) == 0){
            $arrUrl = getUrl();
            if(array_key_exists("fail",$arrUrl)){
                return array ('message'=>'没有新的URL.');
            }else{
                return $arrUrl;
            }
        }
        $jsonData     = json_decode($input);
        if(!$jsonData){
            throw new Exception();
        }
        if(empty($jsonData["area"])){
            return Array("user"=>"我我的的你不", "rank"=>"71");
        }
        if(empty($jsonData["fNumber"])){
            return Array("user"=>"我我的的你不", "rank"=>"71");
        }

        $list   = getUser($jsonData["area"],$jsonData["fNumber"]);

        if(array_key_exists("fail",$list)){
            return array ('message'=>'得到用户失败');
        }
        return $list;

    }catch (Exception $e){
        return array ('error'=>'请求不正确.');
    }

}
function getUrl(){
	try{
		$db = new Sql();
		$queryLocation  = "select * from location";
        $resultLocation = $db->dql($queryLocation);
		if(!isset($resultLocation["id"])) {
            throw new Exception();
        }
		$query  = "select id,buyurl from purchaseurl where id > " . $resultLocation["id"];
        $res    = array();
        $result = $db->dql($query);
        if(count($result) == 0){
            $res['fail']="fail";
            return $res;
        }

        foreach($result as $v){
			$key            = isset($key) ? max($key, $v["id"]) : $v["id"];
			$res[$v["id"]]  = $v['buyurl'];
		}

		if(isset($key)){
			$queryUpdate   = "update location set locationp = ".$key." where id = 1";
			$db->dml($queryUpdate);
		}

		return $res;
	}catch (Exception $e){
        return array("fail" =>'fail');
	}
}
function getUser($areaname, $numbername){
    try{
        $db     = new Sql();
        $query  = "select username,userlevel from areanumber where areaname = '$areaname' and numbername = '$numbername'";
        $result = $db->dql($query);
        if(count($result) == 0){
            throw new Exception();
        }

        return $result[0];
    }catch (Exception $e){
        return array ('message'=>'没有该区的角色.');
    }
}