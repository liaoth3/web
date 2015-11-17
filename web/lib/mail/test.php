<?php
	//引入邮件类
	//header("content-type:text/html;charset=utf-8");
	require("smtp.php");
	//发送成功返回true,否则返回false
	function sendMail($to,$mailsubject,$mailBody){//$to收件人的邮箱，$mailsubject, 邮件主题,$mailBody字符串表示的邮件内容
		 
		//使用163邮箱服务器
		$smtpserver = "smtp.qq.com";
		//163邮箱服务器端口 
		$smtpserverport = 25;
		//你的163服务器邮箱账号
		$mailAccounts = array("759285420@qq.com","741597558@qq.com","775970041@qq.com","793484521@qq.com","917215834@qq.com");
		$mailAccount  = $mailAccounts[rand(0,4)];
		$smtpusermail = $mailAccount;
		//收件人邮箱
		//$to = "820598019@qq.com";
		//你的邮箱账号(去掉@163.com)
		$smtpuser = $mailAccount;//SMTP服务器的用户帐号 
		//你的邮箱密码
		$smtppass = "lth147258369"; //SMTP服务器的用户密码  
		//邮件内容
		//$mailbody = "PHP+MySQL";
		//邮件格式（HTML/TXT）,TXT为文本邮件 
		$mailtype = "TXT";
		//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
		//是否显示发送的调试信息 
		$smtp->debug = false;
	//发送邮件
		$send_res = $smtp->sendmail($to, $smtpusermail, $mailsubject, $mailBody, $mailtype); 
		return $send_res;
	}
	//$res=sendmail("798646889@qq.com","插件运行日志","终于测试完毕了");	
	//if($res)echo("发送成功！");
	//else echo "发送失败！";
?>