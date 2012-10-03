<?php
class User_LogoutController extends Standard_Controller_Action {
	public function init(){
		parent::init();
		if(!$this->_acl->isAllowed($this->_user->role,"logout")){
			$this->_redirect("/");
		}
	}
	public function indexAction(){
		$auth = Zend_Auth::getInstance ();
		$auth->clearIdentity();
		$this->_redirect("/");
	}
	public function facebookAction(){
		$facebookSession = new Zend_Session_Namespace('facebook');
		$facebookConfig = new Zend_Config_Ini(APPLICATION_PATH."/configs/application.ini",APPLICATION_ENV);
		$facebookAppId = $facebookConfig->get('facebook')->app_id;
		$facebookAppSecret = $facebookConfig->get('facebook')->app_secret;
		$facebookAccessToken = $facebookSession->access_token; 
		$facebookRedirectUrl = urlencode($this->view->url(array(
				'module' => 'default',
				'controller' => 'index',
				'action' => 'index'
		)));
		$facebookLogoutUrl = "http://www.facebook.com/logout.php?"
    						. "next=".$facebookRedirectUrl
   							. "&access_token=".$facebookAccessToken;
		
		if(isset($facebookSession->user_details)){
			$this->_redirect($facebookLogoutUrl);
		} else {
			$this->_redirect("/");
		}
	} 
}

