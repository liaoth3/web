$location=document.getElementById("PurchaseOrderNew1_BizInfo1_lblGameAreaServer").innerHTML;
//$username="我我的的你不";
//$susername="我我的的你不";
//$rank="60";
var $phoneNumber="13929511767";
var $qqNumber="820598019";
//var $user="5oiR5oiR55qE55qE5L2g5LiN";
//选择使用其他角色名按钮
$("#PurchaseOrderNew1_BuyerGameRoleInfo1_rbExistGameRole").attr("checked",true);
$("#PurchaseOrderNew1_BuyerGameRoleInfo1_rbExistGameRole").trigger("click");
//$("#PurchaseOrderNew1_txtRoleGrade").attr("value",$rank);
//电话号码
$("#PurchaseOrderNew1_txtBuyerTel").attr("value",$phoneNumber);
//qq号码
$("#PurchaseOrderNew1_txtBuyerQQ").attr("value",$qqNumber);
//交易安全险
$("#PurchaseOrderNew1_rdNoPostSale").attr("checked",true);
getUser($location);
selectKF();    //选客服
//选客服函数
function selectKF(){
	var stop="false";
	var i=0;
	while(stop=="false"){
		for(i=0;i<9;i++){
			$price=$("#kf_list li:eq("+i+") .mod .bbox .sp1 b s").text();
			if($price=="0.00"){
				$("#kf_list li:eq("+i+")").trigger("click");
				stop="true";
				break;
			}
			if($price==null||$price==""){
				i=i-1;
				$("#kf_list li:eq("+i+")").trigger("click");
				stop="true";
				break;
			}
			if(i==10){
				$j=2;
				$("#page_roll .page-list .goto").attr("value",$j);
				$("#page_roll .page-list .sumbit_button").trigger("click");
				j++;
			}
		}
		
	}
	
}
function getUser($location){
	var $arr=$location.split("/");
	var $fNumber=$arr.pop();
	var $area=$arr.pop();
	if($area!=null && $area!="" && $fNumber!="" && $fNumber!=null){
		$.ajax({
			url: "http://localhost/web/extension/refresh.php",
			cache: false,
			type: "POST",
			data: JSON.stringify({method:"getUser",area:$area,fNumber:$fNumber}),
			dataType: "json",
			success:function(data){
				if(data.message){
					$username="我我的的你不";
					$rank="71";
				}
				
				else if(data.error){
					return;
				}
				else {
					$username=data["username"];
					$rank=data["userlevel"];
				}
				$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRole").attr("value",$username);
				$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleValidate").attr("value",$username);
				$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleOther").attr("value",$username);
				$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleValidateOther").attr("value",$username);
				$("#PurchaseOrderNew1_txtRoleGrade").attr("value",$rank);
				$("#PurchaseOrderNew1_btnCreateOrder").trigger("click");
				
			},
		});
	}
	else{
		$username="我我的的你不";
		$rank="70";	
		$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRole").attr("value",$username);
		$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleValidate").attr("value",$username);
		$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleOther").attr("value",$username);
		$("#PurchaseOrderNew1_BuyerGameRoleInfo1_txtGameRoleValidateOther").attr("value",$username);
		$("#PurchaseOrderNew1_txtRoleGrade").attr("value",$rank);
		$("#PurchaseOrderNew1_btnCreateOrder").trigger("click");
	}
}

