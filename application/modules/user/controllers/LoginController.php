<?php
class User_LoginController extends Zend_Controller_Action {
	public function indexAction() {
		$auth = Zend_Auth::getInstance ();
		$auth->clearIdentity();
		
		$loginForm = new User_Form_UserLogin ();
		if ($this->_request->isPost ()) {
			if ($loginForm->isValid ( $this->_request->getParams () )) {
				$userMapper = new User_Model_Mapper_User ();
				
				// Get username and password
				$username = $loginForm->getValue('username');
				$password = $loginForm->getValue('password');
				
				// Get the dbtable and adapter for user
				$userDbTable = $userMapper->getDbTable();
				$userAdapter = $userDbTable->getAdapter ();
				
				// Where-Quatations for username and password
				$usernameCondition = $userAdapter->quoteInto ( "username = ?", $username );
				$passwordCondition = $userAdapter->quoteInto ( "password = ?", $password );
				
				// Select statement for the user
				$select = $userDbTable->select()->where($usernameCondition)->where($passwordCondition);
				$users = $userMapper->fetchAll ($select);
				
				// Check for user validity
				if($users && count($users)==1){
					$identity = new stdClass ();
					$identity->role = "GUEST";
					
					$storage = $auth->getStorage ();
					$storage->write ( $identity );
					$this->_redirect("/");
				} else {
					$this->_helper->json(array("errors"=>array("username"=>"Invalid Username/Password")));
				}
			} else {
				print_r ( $loginForm->getMessages () );
			}
		}
		$this->view->loginForm = $loginForm;
	}
	public function facebookAction() {
		$facebookConfig = new Zend_Config_Ini ( APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV );
		$facebookAppId = $facebookConfig->get ( 'facebook' )->app_id;
		$facebookAppSecret = $facebookConfig->get ( 'facebook' )->app_secret;
		$facebookRedirectUrl = urlencode ( $this->view->serverUrl () . $this->view->url ( array (
				"module" => "user",
				"controller" => "login",
				"action" => "facebook" 
		) ) );
		$facebookSession = new Zend_Session_Namespace ( 'facebook' );
		$code = $this->_request->getParam ( "code", false );
		$facebookState = $this->_request->getParam ( "state", "" );
		if ($code && $facebookSession->state == $facebookState) {
			$facebookDataUrl = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $facebookAppId . "&redirect_uri=" . $facebookRedirectUrl . "&client_secret=" . $facebookAppSecret . "&code=" . $code;
			$response = file_get_contents ( $facebookDataUrl );
			$params = null;
			parse_str ( $response, $params );
			$graph_url = "https://graph.facebook.com/me?fields=name,email&access_token=" . $params ['access_token'];
			$user = json_decode ( file_get_contents ( $graph_url ) );
			$facebookSession->access_token = $params ['access_token'];
			$facebookSession->user_details = $user;
			$this->_helper->json ( array (
					"code" => $code 
			) );
		} else {
			$facebookState = md5 ( uniqid ( mt_rand (), TRUE ) );
			$facebookSession->state = $facebookState;
			$facebookLoginUrl = "https://www.facebook.com/dialog/oauth?" . "client_id=" . $facebookAppId . "&redirect_uri=" . $facebookRedirectUrl . "&scope=user_about_me,email" . "&state=" . $facebookState;
			$this->_redirect ( $facebookLoginUrl );
		}
	}
}

