<?php

class LoginController{
	public static $name = "User";

	public static $defaultAction = "Empty";
	public static $controllerName = "User";

	public static function LoginWithTWAction(){
		$connection = new TwitterOAuth(SiteApp::setting('twitter/key'), SiteApp::setting('twitter/secret'));

		$redirectURI = '/login/loginTwitter';

		$request_token = $connection->getRequestToken(URLUtils::getSiteURL($redirectURI));

		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		switch ($connection->http_code) {
			case 200:
				$url = $connection->getAuthorizeURL($_SESSION['oauth_token']);
				header('Location: ' . $url);
				exit;
			break;
			default:
				ErrorController::Error500Action();
		}
	}

	public static function LoginTwitterAction(){
		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
			$_SESSION['oauth_status'] = 'oldtoken';
			ErrorController::Error500Action();
			return;
		}

		$connection = new TwitterOAuth(SiteApp::setting('twitter/key'), SiteApp::setting('twitter/secret'), $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		$profile = $connection->get('account/verify_credentials');

		$user = new User();
		$user = $user->findByExternalId($profile->id_str,'twitter');

		if (!$user){
			$user = new User();
			$user->saveOrUpdate();

			$userNet = new UserNet();
			$userNet->user = $user;
			$userNet->net = 'twitter';
			$userNet->external_id = $profile->id_str;
			$userNet->username = $profile->screen_name;
			$userNet->name = $profile->name;
			$userNet->profile = addslash(serialize($profile));
			$userNet->saveOrUpdate();

			$user->name = $userNet->name;
			$user->register_date = time();
			$user->default_net = $userNet;
		}

		$userNet = $user->getNet('twitter');

		$userNet->auth_key = $access_token['oauth_token'].'/'.$access_token['oauth_token_secret'];
		$userNet->saveOrUpdate();

		$user->saveOrUpdate();

		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		$_SESSION['user'] = $user;

		header('Location: /');
		exit;
	}

	public static function LogoutAction(){
		unset($_SESSION['user']);

		$redirectURI = URLUtils::getSiteURL();

		header('Location: '.$redirectURI);
		exit;
	}

	public static function isLogined(){
		return (isset($_SESSION['user']) && $_SESSION['user']->isExists());
	}
}
