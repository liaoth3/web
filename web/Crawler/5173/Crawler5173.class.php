<?php
	require_once dirname(__FILE__) . '/../common/Crawler.interface.php';
	require_once dirname(__FILE__) . '/../common/functions.php';
	require_once dirname(__FILE__) . '/../common/Sql.class.php';
	require_once dirname(__FILE__) . '/../common/cache.php';
	require_once dirname(__FILE__) . '/rolling_curl.php';
	class Crawler5173 implements Crawler{
		private $urlArray;//�洢url�Ķ�ά���飬$urlArray[0][1]��ʾ�㶫1������url
		private $lowPrice;//�۸�����
		private $highPrice;//�۸�����
		private $maxPage;//���ץȡ����ҳ
		private $result;//��ά����$result[0][0]["price"]��ʾ�㶫1ȥ�ļ۸�
		private $usedTime;//ץȡ��ʱ
		private $recordsAmount;
		private $multiAmount;//��󲢷���
		private $area;//�����������ƺͱ�Ŷ�Ӧ������
		private $areaAmount;//����������
		private $startArea;//��ʼ�������
		private $endArea;//�����������
		private $isSearchSales;//�Ƿ�������������
		private $storeAmount; //ÿ�������洢�ļ�¼����
		private $config;//���ñ���
		private $repeatTimes;//��ʱ�������ִ�ж��ٴ�
		public function  __construct($startArea,$endArea,$config){
			$this->config			= $config;
			$this->urlArray 		= $config["5173"]["url"];
			$this->lowPrice 		= intval($config["5173"]["lowPrice"]);
			$this->highPrice 		= intval($config["5173"]["highPrice"]);
			$this->maxPage 			= intval($config["5173"]["maxPage"]);
			$this->recordsAmount 	= intval($config["5173"]["recordsAmount"]);
			$this->multiAmount 		= intval($config["5173"]["multiAmount"]);
			$this->storeAmount		= intval($config["5173"]["storeAmount"]);
			$this->isSearchSales 	= intval($config["5173"]["isSearchSales"]);
			$this->repeatTimes		= intval($config["5173"]["repeatTimes"]);

			$this->area 			= $config["common"]["area"];
			$this->areaAmount 		= intval($config["common"]["areaAmount"]);

			$this->startArea 		= $startArea;
			$this->endArea 			= $endArea;
			$this->result 			= array();
			$this->usedTime 		= 0;

		}
		//$wholeUrlArray[]=$this->urlArray[$urlIndex]."$low-$high-0-itemprice_asc-1-$page.shtml";
		private function getUrl($url,$lowPrice,$highPrice,$page,$type){//$type=1 ƽ����$type=2 ����
			if($type==1){
				return $url."-0-bx1xiv-0-0-0-a-a-a-"."$lowPrice-$highPrice-0-itemprice_asc-1-$page.shtml";
			}else{
				return $url."-0-3juw0c-0-0-0-a-a-a-"."$lowPrice-$highPrice-0-itemprice_asc-1-$page.shtml";
			}
		}
		public function getAreaAmount(){
			return $this->areaAmount;
		}
		public function getAreaNumber($areaName){
			foreach($this->area as $k=>$v){
				if($areaName==$v)return $k;
			}
			return false;
		}
		public function getInfoByPage($webContents){
			if(substr_count($webContents,"��Ϸ������")>1){//�жϳ�������
				$type = 2;
			}
			else $type = 1;
			$r = array();
			//��Ʒ��ҳ��
			$areaName = $this->getAreaName($webContents);
			if(!$areaName)return array();//����޷��ж����������ؿ�
			$totalAmount = $this->getTotalAmount($webContents);
			$currentPage = $this->getCurrentPage($webContents);
			$pattern = '/<div class="sin_pdlbox"[\d\D]{1,3000}<\/div>/';
			preg_match_all($pattern,$webContents,$match);
			if(!is_array($match)&&!isset($match[0])){
				exit();
			}
			//$i=0;
			foreach($match[0] as $key=>$v){
				$tmp_arr = array();
				preg_match('/<ul class="pdlist_price">[\d\D]{1,100}<\/ul>/',$v,$price);
				preg_match('/<li class="tt">[\d\D]{100,600}<\/li>/',$v,$goldAmount);
				preg_match('/<ul class="pdlist_num">[\d\D]{1,100}<\/ul>/',$v,$itemAmount);
				preg_match('/<li class="credit">[\d\D]{50,500}<\/li>/',$v,$credit);
				preg_match('/<ul class="pdlist_delivery">[\d\D]{10,2000}<\/ul>/',$v,$tmp);
				preg_match('/href="[\d\D]*"/',$tmp[0],$buyLink);
				if(is_array($price)&&isset($price[0])){
					$price = (int)(strip_tags($price[0]));
					$tmp_arr["price"] = $price;
					if(isset($goldAmount[0])&&$goldAmount[0]){
						$goldAmount = (int)(strip_tags($goldAmount[0]));
					}else{
						exit();
					}
						
					$tmp_arr["goldAmount"] = $goldAmount;
			
					$itemAmount = (int)(strip_tags($itemAmount[0]));
			
					$tmp_arr["itemAmount"] = $itemAmount;
			
					$credit = substr($credit[0],strpos($credit[0],"title")+7,50);
			
					if(strpos($credit,"0")==false){
						$tmp_arr["credit"] = "����";
					}else{
							
						$tmp_arr["credit"] = substr($credit,0,4);
					}
					$buyLink = substr($buyLink[0],strpos($buyLink[0],"href=")+6);
					$buyLink = substr($buyLink,0,strpos($buyLink,'"'));
					$tmp_arr["buyLink"] = $buyLink;
					if($type==2)$tmp_arr["sale"] = 1;//��ʾ����
					else $tmp_arr["sale"] = 0;//��ʾ����
					
					if(strpos($v,"�������10Ԫ���"))$tmp_arr["payFor"] = 1;//��ʾ�⸶
					else $tmp_arr["payFor"] = 0;
					
					if(strpos($v,"�ɻ��ⵥ����"))$tmp_arr["free"] = 1;//��ʾ�ⵥ
					else $tmp_arr["free"] = 0;

					if(strpos($v,"��ħ")){
						$tmp_arr["magic"] = 1;
						//echo $v;
					}//��ʾ��ħ
					else $tmp_arr["magic"] = 0;
					
					if(substr_count($v,"danbao.5173.com")>1)$tmp_arr["ensure"] = 1;//��ʾ����
					else $tmp_arr["ensure"] = 0;
					
					if(substr_count($v,"consignment.5173.com")>1)$tmp_arr["consign"] = 1;//��ʾ����
					else $tmp_arr["consign"] = 0;

					//echo $v;
					$tmp_arr["time"] = date("Y-m-d H:i:s");
					$tmp_arr["platform"] = "5173";
					$r[] = $tmp_arr;
				}
				
		}
		$arr = array("contents"=>$r,"areaNumber"=>($this->getAreaNumber($areaName)),"currentPage"=>$currentPage,"totalAmount"=>$totalAmount,"type"=>$type);//1��ʾ�������ۣ�2��ʾ����
		return $arr;
	}
		private function getAreaName($webContent){
			preg_match('/<title>[\d\D]+-5173.com<\/title>/',$webContent,$area);
			if(isset($area)&&!empty($area[0]))
				return substr($area[0],strpos($area[0]," ")+1,strpos($area[0],"-")-strpos($area[0]," ")-1);
			else return false;
		}
		private function getCurrentPage($webContent){
			preg_match('/currentPage:\d+/',$webContent,$currentPage);
			//print_r($pageAmount);
			//exit();
			if(isset($currentPage)&&!empty($currentPage[0]))
				return (int)(substr($currentPage[0],strpos($currentPage[0],":")+1));
			else return false;
		}
		private function getTotalAmount($webContent){
			preg_match('/totalAmount:\d+/',$webContent,$pageAmount);
			//print_r($pageAmount);
			//exit();
			if(isset($pageAmount)&&!empty($pageAmount[0]))
				return (int)(substr($pageAmount[0],strpos($pageAmount[0],":")+1));
			else return false;
		}

		public function start(){
			$startTime = time();
			if($this->lowPrice<0)$this->lowPrice=0;
			if($this->highPrice<0)$this->highPrice=0;
			$low=min($this->lowPrice,$this->highPrice);
			$high=max($this->lowPrice,$this->highPrice);

			$wholeUrlArray = array();
			$page = 1;//��ǰҳ��
			for($urlIndex = $this->startArea;$urlIndex<$this->endArea&&$urlIndex<$this->areaAmount;$urlIndex++){
				$wholeUrlArray[$urlIndex] = $this->getUrl($this->urlArray[$urlIndex], $low, $high, $page, 1);
				//echo "<a href=" . $wholeUrlArray[$urlIndex] . ">click<a> \n <br>";
//				if($this->isSearchSales) {
//					$wholeUrlArray[] = $this->getUrl($this->urlArray[$urlIndex], $low, $high, $page, 2);
//				}

			}
			$curl = new rolling_curl($this->multiAmount);
			$curl->set_gzip(true);
			$urls = $wholeUrlArray;

			$cur_count = $this->repeatTimes;
			while($cur_count--) {
				$curl->clearRequest();
				foreach ($urls as $url) {
					$curl->get($url);
				}
				$contents = $curl->execute();
				//file_put_contents(dirname(__FILE__) . "/webPage/" . time() . ".html" ,$contents);
				$index = 0;
				$res = array();
				while ($index < count($contents)) {
					$r = $this->getInfoByPage($contents[$index++]);
					$res[] = $r;
				}

				foreach ($res as $k => $v) {
					if(empty($v))continue;
					if (isset($this->result[$v["areaNumber"]])) {
						$this->result[$v["areaNumber"]] = array_merge($this->result[$v["areaNumber"]], $v["contents"]);
					} else {
						$this->result[$v["areaNumber"]] = $v["contents"];
					}

				}
				$res = array();
				foreach ($this->result as $k => $v) {
					usort($v, "cmpByUnivalenceDesc");
					$res [$k] = $v;
					ksort($res);
				}
				$this->result = $res;

				if(count($this->result) == $this->endArea - $this->startArea)break;
				foreach($this->result as $k => $v){
					unset($urls[$k]);
				}
				//echo "urls: " . count($urls) . "\n";
				usleep(20000);
			}


			$endTime = time();
			$this->usedTime = $endTime - $startTime;
		}
		
		private function storageWebpage($c,$path){
			if(is_dir($path)){
				removeDir($path);
			}
			mkdir($path,0777);
			for($i=0;$i<count($c);$i++){
				file_put_contents($path."/$i.html",$c[$i]);
			}
		}
		public  function  storeArea(){
			foreach ($this->result as $index => $r){
				$count = 0;
				foreach($r as $K => $v){
					if($count++ >= ($this->storeAmount / 2 + 1) )break;
					$goldAmount 	= $v["goldAmount"];
					$price 			= $v["price"];
					$buyLink 		= $v["buyLink"];
					$time			= $v["time"];
					$areaname 		= $this->config["common"]["area"][$index];
					$univalence 	= round($goldAmount / $price,2);
					$buyUnivalence	= round($this->config["common"]["univalence"][$index],2);
					if($univalence 	>= $buyUnivalence){
                        		$redis = cache::get_instance();
						if(is_string($buyLink)){
							$buyLink_ = $buyLink . "toBuy";
							if($redis->exists($buyLink_)){
								continue;
							}else{
								$redis->set($buyLink_, 1);
							}
						}

						//search in DB
						$db = new Sql();
						
						$selectSql	 = "select id from purchaseurl where buyurl = '$buyLink'";
						$res = $db->dql($selectSql);
		                		//echo "$selectSql\n";
						if(count($res) > 0){
							continue;
						}
						$storeSql = "insert into purchaseurl(
						buyurl,
						areaname,
						price,
						coin,
						createTime
						)
						values(
						'$buyLink',
						'$areaname',
						$price,
						$goldAmount,
						'$time'
						)";
						//echo "$storeSql\n";
						$db->dml($storeSql);
					}

				}
			}
		}
		public function store()
		{	
			foreach ($this->result as $index => $r){
				$count = 0;
				foreach($r as $K => $v){
					if($count++ >= $this->storeAmount)break;
					$areaNumber = $index;
					$univalence 	= number_format($v["goldAmount"]/$v["price"],2);
					$goldAmount 	= $v["goldAmount"];
					$price 		    = $v["price"];
					$itemAmount 	= $v["itemAmount"];
					$ensure 	    = $v["ensure"];
					$consign 	    = $v["consign"];
					$sale 		    = $v["sale"];
					$payFor 	    = $v["payFor"];
					$free 		    = $v["free"];
					$magic 		    = $v["magic"];
					$platform 	    = $v["platform"];
					$credit 	    = $v["credit"];
					$time 		    = $v["time"];
					$buyLink	    = $v["buyLink"];
					//search in cache
					
					$redis = cache::get_instance();
					if(is_string($buyLink)){
						$amount = $redis->get($buyLink);
						if($amount){
							if($amount==$itemAmount){
								continue;
							}else{
								//if the itemAmout not equal update it
								$db = new Sql();
								$updateSql = "update record_5173_" . $areaNumber . " set itemAmount = "
											 . $amount . " where buyLink = '$buyLink'";
								$db->dml($updateSql);
								continue;
							}

						}else{
							$redis->set($buyLink,$itemAmount);
						}
					}
					
					//search in DB
					$db = new Sql();
					$selectSql	 = "select itemAmount from" . " record_5173_" . "$areaNumber where buyLink = '$buyLink'";
					$res = $db->dql($selectSql);
                    if(!empty($res["itemAmount"])){
						$db = new Sql();
						$updateSql = "update record_5173_" . $areaNumber . " set itemAmount = "
							. $amount . " where buyLink = '$buyLink'";
						$db->dml($updateSql);
						continue;
					}

					//finally insert data to DB
					$storeSql 	    = "insert into record_5173_"."$areaNumber(
					univalence,
					goldAmount,
					price,
					itemAmount,
					ensure,
					consign,
					sale,
					payfor,
					free,
					magic,
					platform,
					credit,
					createTime,
					buyLink
					) 
					values(
					$univalence,
					$goldAmount,
					$price,
					$itemAmount,
					$ensure,
					$consign,
					$sale,
					$payFor,
					$free,
					$magic,
					'$platform',
					'$credit',
					'$time',
					'$buyLink'
					)";
					$db->dml($storeSql);
				}
			}	
		}
	public function getList(){
		if($this->result==null)return "result is null \n";
		$str = $this->startArea . "-" . $this->endArea . " time: $this->usedTime area: " . count($this->result) . " nowTime: " .date("h:i:s"). "\n";
		return $str;
	
	}
	public function showList(){
		echo "<h1> total: " . count($this->result) . " areas</h1>";
		foreach ($this->result as $k => $r){
			if(empty($r))continue;
			echo "<table border=1 align='center'>";
			$areaNumber = $k + 1;
			echo "<caption><b>��{$areaNumber}��:".$this->area[$k]."</b> total:<b>".count($r)."</b> records,used time:<b>".$this->usedTime."</b> seconds</caption>";
			echo "<th>���</th><th>����</th><th>����</th><th>�۸�</th><th>����</th><th>����</th><th>����</th><th>����</th><th>�⸶</th><th>�ⵥ</th><th>��ħ</th><th>ƽ̨</th><th>����</th><th>ʱ��</th>";
			echo "<th>��������</th>";
			$count = 1;
			foreach ($r as $v) {
				echo "<tr width='200px'align='center'>";
				echo "<td width='30px'>".$count++."</td>";
				echo "<td width='100px'>".number_format($v["goldAmount"]/$v["price"],2)."</td>";
				echo "<td width='100px'>".$v["goldAmount"]."</td>";
				echo "<td width='100px'>".$v["price"]."</td>";
				echo "<td width='100px'>".$v["itemAmount"]."</td>";
				echo "<td width='30px'>".$v["ensure"]."</td>";
				echo "<td width='30px'>".$v["consign"]."</td>";
				echo "<td width='30px'>".$v["sale"]."</td>";
				echo "<td width='30px'>".$v["payFor"]."</td>";
				echo "<td width='30px'>".$v["free"]."</td>";
				echo  $v["magic"]==0 ? "<td width='30px'>".$v["magic"]."</td>" : "<td width='30px' bgcolor='red'>".$v["magic"]."</td>";
				echo "<td width='100px'>".$v["platform"]."</td>";
				echo "<td width='100px'>".$v["credit"]."</td>";
				echo "<td width='220px'>".$v["time"]."</td>";
				echo "<td width='200px'><a href=".'"'.$v["buyLink"].'">'."buy"."</a></td>";
				//echo "<td width='220px'>".$v["totalAmount"]."</td>";
				if($count>$this->recordsAmount)break;
			}
			echo "</table>";

		}
	}
}
function cmpByUnivalenceDesc($a,$b){
	return ($a["goldAmount"] / $a["price"])<($b["goldAmount"] / $b["price"]);
}
