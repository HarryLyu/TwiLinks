<?

class ApiController {
	public static $name = "Api";
	
	public static $defaultAction = "AddLink";
	public static $controllerName = "Api";
		
	public static function AddLinkAction(){
		if (!LoginController::isLogined()){
			ErrorController::ErrorAccessAjaxAction();
			exit;
		}

		$link = new Link();
		
		if (strlen($_POST['id']) > 0){
			$link = new Link(intval($_POST['id']));
			if ($link->user->getId() != SiteApp::state('user')->getId()){
				echo json_encode(array('result' => 'err','msg'=>'It seems that you are trying to access not your link!'));
				exit;
			}
		}

		$link->fillParams($_POST);
		$link->add_date = time();
		$link->domain = parse_url($link->link,PHP_URL_HOST);
		$link->saveOrUpdate();

		$link->user = SiteApp::state('user');
		$link->saveOrUpdate();

		echo json_encode(array('result' => 'ok', 'id' => $link->getId()));
		exit;
	}

	public static function DeleteLinkAction(){
		$link = new Link(intval($_POST['id']));

		if ($link->user->getId() != SiteApp::state('user')->getId()){
			echo json_encode(array('result' => 'err','msg'=>'It seems that you are trying to access not your link!'));
			exit;
		}

		$link->delete();

		echo json_encode(array('result' => 'ok'));
		exit;
	}

	public static function UpdateLinkAction(){
		$link = new Link(intval($_POST['id']));
		$link->fillParams($_POST);
		$link->saveOrUpdate();

		echo json_encode(array('result' => 'ok'));
		exit;
	}
}