<?php
error_reporting(0);

//�����û���������@163.com��׺�ģ�
$user       = 'liaoth3@163.com';
//��������
$pass       = 'lpily1314';
//Ŀ������
//$mail_addr = uenucom@163.com';

//��½
$url            = 'http://reg.163.com/logins.jsp?type=1&url=http://entry.mail.163.com/coremail/fcg/ntesdoor2?lightweight%3D1%26verifycookie%3D1%26language%3D-1%26style%3D-1';
$ch             = curl_init($url);
//����һ�����ڴ��cookie��Ϣ����ʱ�ļ�
$cookie 	= "cookie_163.txt";
$fp         = fopen($cookie,"w+r+");
$referer_login = 'http://mail.163.com';
//���ؽ������ڱ����У�������Ĭ�ϵ�ֱ�����
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_REFERER, $referer_login);

$fields_post = array(
	'username'=> $user,
	'password'=> $pass,
	'verifycookie'=>1,
	'style'=>-1,
	'product'=> 'mail163',
	'selType'=>-1,
	'secure'=>'on'
);

$headers_login = array(
	'User-Agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/2008052906 Firefox/3.0',
	'Referer'           => 'http://www.163.com'
);

$fields_string = '';

foreach($fields_post as $key => $value)
{
	$fields_string .= $key . '=' . $value . '&';
}

$fields_string = rtrim($fields_string , '&');

curl_setopt($ch, CURLOPT_COOKIESESSION, true);
//�ر�����ʱ�����������˷��ص�cookie�����������ļ���
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_login);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

$result= curl_exec($ch);
curl_close($ch);


//��ת
$url='http://entry.mail.163.com/coremail/fcg/ntesdoor2?lightweight=1&verifycookie=1&language=-1&style=-1&username=loki_wuxi';

$ch = curl_init($url);

$headers = array(
	'User-Agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/2008052906 Firefox/3.0'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//��֮ǰ�����cookie��Ϣ��һ���͵���������
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
$result = curl_exec($ch);
curl_close($ch);

//ȡ��sid
preg_match('/sid=[^\"].*/', $result, $location);
$sid = substr($location[0], 4, -1);
//file_put_contents('./result.txt', $sid);


//ͨѶ¼��ַ
$url='http://g4a30.mail.163.com/jy3/address/addrlist.jsp?sid='.$sid.'&gid=all';
$ch = curl_init($url);

$headers = array(
	'User-Agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/2008052906 Firefox/3.0'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
$result = curl_exec($ch);
curl_close($ch);
//file_put_contents('./result.txt', $result);
//unlink($cookie);

//��ʼץȡ����
preg_match_all('/<td class="Ibx_Td_addrName"><a[^>]*>(.*?)<\/a><\/td><td class="Ibx_Td_addrEmail"><a[^>]*>(.*?)<\/a><\/td>/i', $result,$infos,PREG_SET_ORDER);
//1������2������
print_r($infos);

?>