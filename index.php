<?php
require_once 'config.php';

require_once $GBL_CONFIG['dirs']['shared'].'/classes/AbstractApplication.php';
require_once $GBL_CONFIG['dirs']['site'].'/classes/SiteApp.php';

SiteApp::$settings = $GBL_CONFIG;

SiteApp::run();

SiteApp::loadController('Home');
SiteApp::loadController('Login');
SiteApp::loadController('Error');
SiteApp::loadController('Api');

if (LoginController::isLogined()){
	SiteApp::state('user',$_SESSION['user']);
}

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($url == '/'){
	SiteApp::state('controller','home');
	SiteApp::state('action','view');
}

if (preg_match('/login\/([a-zA-z]*)$/', $url, $matches)){
	SiteApp::state('controller','login');
	SiteApp::state('action',$matches[1]);
}

if (preg_match('/api\/([a-zA-z]*)$/', $url, $matches)){
	SiteApp::state('controller','api');
	SiteApp::state('action',$matches[1]);
}

if (preg_match('/go\/(\d*)$/', $url, $matches)){
	$link = new Link($matches[1]);
	if ($link->isExists()){
		header('Location: '.$link->link);
		exit;
	}
}

SiteApp::$currentController = SiteApp::getController(SiteApp::state('controller'));

if (isset(SiteApp::$currentController)){
	if (!isset(SiteApp::$state['action'])){
		SiteApp::$currentAction = SiteApp::getAction(SiteApp::$currentController,
													SiteApp::$currentController->getStaticPropertyValue("defaultAction",NULL));
	}else{
		SiteApp::$currentAction = SiteApp::getAction(SiteApp::$currentController,SiteApp::$state['action']);
	}
}

if (SiteApp::$currentAction != null)
	SiteApp::$currentAction->invoke(null);
else
	ErrorController::Error404Action();

SiteApp::model('user',SiteApp::state('user'));

SiteApp::$smarty->display("index.htm");

//echo $indexTpl -> parse(SiteApp::$model);
