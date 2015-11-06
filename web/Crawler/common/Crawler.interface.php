<?php
	interface Crawler{
		public function getInfoByPage($contents);
		public function start();
		public function getList();
	}