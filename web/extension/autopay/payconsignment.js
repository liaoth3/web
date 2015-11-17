var $phoneNumber="13929511767";
var $qqNumber="820598019";
$location=$(".buyinfo_ybox dl dd:eq(1)").text().replace(/\s+/g,"");
//alert($location);
$("#rdOldRole").attr("checked",true);
$("#rdOldRole").trigger("click");
$("#rdbtnOffPostSaleIndemnity").attr("checked",true);
$("#txtPhone").attr("value",$phoneNumber);
$("#txtQq").attr("value",$qqNumber);
selectKF();
function selectKF(){
	var stop="false";
	var i=0;
	while(stop=="false"){
		for(i=0;i<9;i++){
			$price=$("#kf_list li:eq("+i+") .mod .bbox .sp1 b s").text();
			if($price=="0"){
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
getUser($location);
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
//					alert(data.message);
					$username="我我的的你不";
					$rank="71";
				}
				
				else if(data.error){
					alert(data.error);
					return;
				}
				else{
					$username=data["username"];
//					$susername=data["username"];
					$rank=data["userlevel"];
				}				
				$("#txtReceivingRole").attr("value",$username);
				$("#txtSureReceivingRole").attr("value",$username);
				$("#txtOldRole").attr("value",$username);
				$("#txtReOldRole").attr("value",$username);
				$("#HiddenField3").attr("value",$username);
				$("#linkOk").trigger("click");
//				$("#PurchaseOrderNew1_txtRoleGrade").attr("value",$rank);
				$("#hiddenBtnSureOk").trigger("click");
				
			},
		});
	}
	else{
		$username="我我的的你不";
		$rank="70";	
		$("#txtReceivingRole").attr("value",$username);
		$("#txtSureReceivingRole").attr("value",$username);
		$("#txtOldRole").attr("value",$username);
		$("#txtReOldRole").attr("value",$username);
		$("#HiddenField3").attr("value",$username);
		$("#linkOk").trigger("click");
//		$("#PurchaseOrderNew1_txtRoleGrade").attr("value",$rank);
		$("#hiddenBtnSureOk").trigger("click");
	}
}
