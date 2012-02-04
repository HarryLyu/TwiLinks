<?

class HomeController {
	public static $name = "Home";
	
	public static $defaultAction = "View";
	public static $controllerName = "Home";
		
	public static function ViewAction(){
		if (LoginController::isLogined()){
			$links = new Link();
			$links = $links->selectAll('WHERE user = '.SiteApp::state('user')->getId());
			
			SiteApp::model('links',$links);
			SiteApp::model('user',SiteApp::state('user'));
		}

		SiteApp::model('statAll', M::s("SELECT domain, count(*) as count FROM `links` WHERE domain != '' group by domain order by count DESC LIMIT 0, 10"));
		SiteApp::model('statMonth', M::s("SELECT domain, count(*) as count FROM `links` WHERE domain != '' AND add_date > UNIX_TIME()-3600*24*30 group by domain order by count DESC LIMIT 0, 10"));
	}
}