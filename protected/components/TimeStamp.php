<?php
class TimeStamp{

	private $lindenstamp;

	function __construct() {
       $this->lindenstamp=Yii::app()->params['lindenstamp'];//"/var/www/squid-pacific/egemen/bin/lindenstamp/lindenstamp";
    }

	public function checkBalance(){
		$response=shell_exec($this->lindenstamp." checkBalance");
		$response=json_decode($response);
		return $response;

	}

	public function doStamp($filepath,$stampPath=null){
		$response=shell_exec($this->lindenstamp." doStamp ".$filepath." ".$stampPath);
		//$response=json_decode(str_replace(array("\n", "\r"), '', $response));
		$response=str_replace(array("\n", "\r"), '', $response);
		//$response='{"status":1,"result":{"message":"sdfsdfsfdsdfsdf"}}';
		return $response;
	}

	public function checkStamp($filepath,$stampPath){
		$response=shell_exec($this->lindenstamp." checkStamp ".$filepath." ".$stampPath);
		$response=json_decode(str_replace(array("\n", "\r"), '', $response));
		return $response;		
	}

	public function nothing(){
		$response=shell_exec($this->lindenstamp);
		return $response;
	}
}