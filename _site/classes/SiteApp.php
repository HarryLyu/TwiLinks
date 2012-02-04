<?php

class SiteApp extends AbstractApplication {
	
	public static $smarty;
	
	public static function run() {
		$sharedDir = self::$settings['dirs']['shared'];
		require_once $sharedDir.'/classes/utils.php';
		require_once $sharedDir.'/classes/M.php';
		
		require_once $sharedDir.'/classes/AbstractObjectModel.php';
		require_once self::setting('dirs/ext').'/php/smarty/Smarty.class.php';
		
		require_once self::setting('dirs/ext').'/php/twitter/OAuth.php';
		require_once self::setting('dirs/ext').'/php/twitter/twitteroauth.php';
		
		self::$workingDir = self::setting('dirs/site');
		
		self::$smarty = new Smarty();
		
		self::$smarty->template_dir = './tpl';
		self::$smarty->compile_error = true;
		self::$smarty->error_unassigned = true;
		
		date_default_timezone_set(self::setting('site/timezone'));
		
		array_walk($_POST,'addAllSlashes');
		
		$objectsDir = opendir($sharedDir.'/objects');
		while (false !== ($file = readdir($objectsDir))){
			if ($file != "." && $file != ".."){
				require_once $sharedDir.'/objects/'.$file;
			}
		}
		
		if (isset($_POST['sessionId']) && $_POST['sessionId'] != null)
			session_id($_POST['sessionId']);
		
		session_start();
	}
	
	public static function smrt($tpl_var,$value){
		self::$smarty->assign($tpl_var,$value);
	}
	
	
	public static function model($path,$value = NULL){
		if (isset($value)){
			$pathArr = explode("/", $path);
			$newPath = array_shift($pathArr);
			ArrayUtils::setByPath($path, self::$model, $value);
			self::smrt($newPath, self::$model[$newPath]);
		}else
			return ArrayUtils::getByPath($path, self::$model);
	}
	
}