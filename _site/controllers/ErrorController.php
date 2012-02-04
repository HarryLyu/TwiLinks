<?php

class ErrorController{
	public static $name = "Ошибка";
	
	public static $defaultAction = "Error404";
	public static $controllerName = "error";
	
	public static function Error404Action(){		
		header("HTTP/1.1 404 Not Found");
		
		SiteApp::model('content',"Sorry, page you're requested is not found."); 
		SiteApp::model('title',"Page not found");
	}
	
	public static function Error500Action(){
		header("HTTP/1.1 500 Internal Server Error");
	
		SiteApp::model('content',"Sorry, we did something wrong and an error has happened. Please, try again you last action.");
		SiteApp::model('title',"Internal Server Error");
	}
	
	public static function ErrorAccessAction(){
		header("HTTP/1.1 401 Unauthorized");
		
		SiteApp::model('content',SiteApp::$smarty->fetch('snippets/accessError.htm'));
		SiteApp::model('title',"Access error");
	}
	
	public static function ErrorAccessAjaxAction(){
		header("HTTP/1.1 401 Unauthorized");
		
		echo json_encode(array(	'result' => 'error',
								'msg' => 'You must be logged in to access this page',
								'code' => 401)
						);
	}
}