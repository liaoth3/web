<?php
function test5173($config,$startArea, $endArea){
	$c = new Crawler5173($startArea,$endArea,$config);
	$c->start();
	$c->store();
	//$c->showList();
   	$c->storeArea();
	return $c->getList();
}
function login($url,$argv){
	$ch = curl_init();
	$post_data = $argv;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
    curl_close($ch);
	return $output;
}
function login_with_json_data($url, $jsonStr){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonStr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonStr))
    );
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function configMap($config){
    $result = $config;
    $map = array(
            0=>58, 1=>38, 2=>30, 3=>65, 4=>89, 5=>82, 6=>91, 7=>86, 8=>46, 9=>23,
        10=>62,11=>104, 12=>75, 13=>17, 14=>0, 15=>52, 16=>93, 17=>84, 18=>42, 19=>68,
        20=>72,21=>97, 22=>78, 23=>14, 24=>45, 25=>18, 26=>53, 27=>25, 28=>69, 29=>2,
    );
    foreach($map as $k => $v){
        $result["5173"]["url"][$k] = $config["5173"]["url"][$v];
        $result["common"]["area"][$k] = $config["common"]["area"][$v];
    }
    return $result;
}
function xhprof_debug($call_func_name, $parmArr){
    xhprof_enable();
    call_user_func_array($call_func_name, $parmArr);
    $xhprof_data = xhprof_disable();
        
    $XHPROF_ROOT = realpath(dirname(__FILE__) .'/../../lib/xhprof');
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
    
    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");     

    header("location:http://123.56.126.96/web/lib/xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_foo");
}

/**
 * cURL multi��������
 * 
 * @author mckee
 * @link http://www.111cn.net
 * 
 *
 */
//ǿ��ɾ���ļ�
function removeDir($dirName){
	if(!is_dir($dirName))return false;
	
	$handle =@opendir($dirName);
	while($file=readdir($handle)){
		if($file!='.'&&$file!='..'){
			$fileName = $dirName."/".$file;
			is_dir($fileName) ? removeDir($fileName):@unlink($fileName);
		}
	} 
	closedir($handle);
	return rmdir($dirName);
}
//����һ������url��һά����
function multi_get_contents($url_array){
	$handles = $contents = array(); 
	 
	//��ʼ��curl multi����
	$mh = curl_multi_init();
	 
	//���curl ������Ự
	foreach($url_array as $key => $url)
	{
	    $handles[$key] = curl_init($url);
	    curl_setopt($handles[$key], CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($handles[$key], CURLOPT_TIMEOUT, 10);
	    curl_multi_add_handle($mh, $handles[$key]);
	}
	 
	//======================ִ����������=================================
	$active = null;
	do {
	    $mrc = curl_multi_exec($mh, $active);
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);
	 
	 
	while ($active and $mrc == CURLM_OK) {
	    
	    if(curl_multi_select($mh) === -1){
	        usleep(100);
	    }
	    do {
	        $mrc = curl_multi_exec($mh, $active);
	    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
	 
	}
	 
	//��ȡ����������
	foreach($handles as $i => $ch)
	{
	    $content = curl_multi_getcontent($ch);
	    $contents[$i] = curl_errno($ch) == 0 ? $content : '';
	}
	 
	//�Ƴ���������
	foreach($handles as $ch)
	{
	    curl_multi_remove_handle($mh, $ch);
	}
	 
	//�ر���������
	curl_multi_close($mh);
	return $contents;
}

