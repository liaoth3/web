<?php
	class Sql{
		private $hostname = "localhost";
		private $username = "root";
		private $password = "root";
		private $databaseName = "crawler";
		public static $link = null;
		public function __construct(){
			if(self::$link ===null){
				self::$link = mysqli_connect($this->hostname,$this->username,$this->password) or die("connet database failed !");
				mysqli_select_db(self::$link, $this->databaseName) or die("database select failed !");
				mysqli_query(self::$link, "set names GBK");
				//echo "connect \n";
			}
		}

		//返回一个二维关联数组
		public function dql($sql){
			$result = mysqli_query(self::$link, $sql);
			$r = array();
			while($row = mysqli_fetch_assoc($result))$r[]=$row;
			mysqli_free_result($result);
			return $r;
		}
		public function dml($sql){
			$result = mysqli_query(self::$link, $sql);
			return $result;
		}
		public function __destruct(){
			mysqli_close(self::$link);
			self::$link = null;
			//echo "close \n";

		}

	}
