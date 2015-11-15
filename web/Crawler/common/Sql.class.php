<?php
	class Sql{
		private $hostname 		= "123.56.126.96";
		private $username 		= "root";
		private $password 		= "root";
		private $databaseName 	= "crawler";
		private  $mysqli 		= null;
		public function __construct(){
				 $this->mysqli= new mysqli($this->hostname,$this->username,$this->password,$this->databaseName) or die("connet database failed !");
				if(mysqli_connect_error()){
					printf("Connect failed: %s\n", mysqli_connect_error());
    				exit();
				}
				$this->mysqli->query("set names GBK");
		}

		//返回一个二维关联数组
		public function dql($sql){
			$r = array();
			$result = $this->mysqli->query($sql);
			if($result){
				while($row = $result->fetch_assoc())$r[]=$row;
				$result->close();
			}
			return $r;
		}
		public function dml($sql){
			$result = $this->mysqli->query($sql);
			return $result;
		}
		public function __destruct(){
			$this->mysqli->close();
		}

	}
