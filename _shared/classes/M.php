<?php

class M {
	
	public $link;
	
	static private $instance = NULL;
	
	static private $lastQuery = '';
	
	private function __construct(){
		global $GBL_CONFIG;
		
		$link = mysql_connect(
			$GBL_CONFIG['db']['server'],
			$GBL_CONFIG['db']['username'],
			$GBL_CONFIG['db']['password']
		);
		
		mysql_select_db($GBL_CONFIG['db']['database']);
		
	    foreach ($GBL_CONFIG['db']['connectQueries'] as $query) mysql_query($query);
	}
	
	public static function connect(){
    	if (self::$instance == NULL){
      		self::$instance = new M();
    	}
	}

	public static function s($query){
		self::connect();
		
		self::$lastQuery = $query;
		
		$r = mysql_query($query);
		
		if ($r === true) return true;
		if ($r === false) return false;
		
		if (mysql_errno()==0){
			$return = array();
			
			while ($row = mysql_fetch_array($r)){
				array_walk($row,'stripAllSlashes');
				$return[] = $row;
			}
			
			return $return;
		}else{
			return false;
		}
	}
	
	public static function su($query){
		$r = self::s($query);
		
		if (is_array($r)){
			return isset($r[0]) ? $r[0] : $r;
		}else
			return $r;
	}
	
	public static function q($query){
		self::connect();

		self::$lastQuery = $query;
		
		$r = mysql_query($query);

		if (mysql_errno()==0){
			return true;
		}else{
			return false;
		}
	}
	
	public static function lastId(){
		return mysql_insert_id();
	}
	
	public static function e(){
		return array(
			'msg' => mysql_error(),
			'code' => mysql_errno(),
			'lastQuery' => self::$lastQuery
		);
	}
}