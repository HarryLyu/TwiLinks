<?php

abstract class AbstractApplication {

	public static $loadedControllers = array();

	public static $currentController;
	public static $currentAction;

	public static $model = array();
	public static $state = array();
	public static $settings = array();

	public static $workingDir;

	public static function run(){}

// 	public static function loadSettings(){
// 		$settingsList = M::s("SELECT * FROM settings");
// 		foreach ($settingsList as $setting)
// 			$this->settings[$setting['name']] = $setting['value'];
// 	}

	public static function loadController($moduleName){
		if (!in_array($moduleName, self::$loadedControllers)) {
			if (file_exists(self::getWorkingDir().'/controllers/'.$moduleName.'Controller.php')){
				require_once self::getWorkingDir().'/controllers/'.$moduleName.'Controller.php';
				self::$loadedControllers[] = $moduleName;
			}else{
				die('There is no controller '.$moduleName.'Controller ('.self::getWorkingDir().'/controllers/'.$moduleName.'Controller.php);');
			}
		}
	}

	public static function isLogined() {
		return isset($_SESSION['login']) && $_SESSION['login'] == true;
	}

	public static function addMessage($message,$isError) {
		if (!isset($_SESSION['messages'])) {
			$_SESSION['messages'] = array();
		}

		$_SESSION['messages'][] = array(
			'message' => $message,
			'isError' => !$isError
		);
	}

	public static function showMessages() {
		if (isset($_SESSION['messages'])) {
			foreach ($_SESSION['messages'] as $message) {
				echo '<div class="messageInfo'.($message['isError'] ? 'Err' : 'Ok').'" title="Скрыть сообщение" onclick="$(this).slideUp()">'.$message['message'].'</div>';
			}
		}

		$_SESSION['messages'] = array();
	}

	public static function getController($controller){
		$controller = ucwords($controller);

		if (in_array($controller,self::$loadedControllers)) {
			$controller = new ReflectionClass($controller.'Controller');
			return $controller;
		} else {
			
		}
	}

	public static function getAction($controller,$action){
		$action = ucwords($action);

		foreach($controller->getMethods() as $method){
			if ($method->name == $action.'Action'){
				return $method;
			}
		}

		return null;
	}

	public static function getWorkingDir() {
		return self::$workingDir;
	}
	
	public static function setting($path,$value = NULL){
		if ($value != NULL)
			return ArrayUtils::setByPath($path, self::$settings, $value);
		else
			return ArrayUtils::getByPath($path, self::$settings);
	}
	
	public static function state($path,$value = NULL){
		if (isset($value))
			return ArrayUtils::setByPath($path, self::$state, $value);
		else
			return ArrayUtils::getByPath($path, self::$state);
	}
}