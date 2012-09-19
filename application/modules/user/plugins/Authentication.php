<?php
class User_Plugin_Authentication extends Zend_Controller_Plugin_Abstract {
	private $_acl = null;
	private $_auth = null;
	public function __construct(Zend_Auth $auth) {
		$this->_auth = $auth;
	}
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$this->_acl = new User_Plugin_Acl();
		
		$module = $request->getModuleName ();
		$controller = $request->getControllerName ();
		$action = $request->getActionName ();
		
		if($controller != "error"){
			if(!$this->_auth->hasIdentity() && $controller!= "login" ){
				$request->setModuleName("user")->setControllerName("login")->setActionName("index");
			}
			
		}
		/*
		if (strtolower ( $request->getModuleName () ) != "admin") {
			
			if($resource != "error") {
				if (! $this->_auth->hasIdentity () && $resource != "forgot" && $action != "check-login" ) {
					$request->setModuleName("default")->setControllerName ( 'login' )->setActionName ( 'index' );
				} else if ((! isset ( $this->_auth->getStorage ()->read ()->group_id ) || $this->_auth->getStorage ()->read ()->group_id == 0) && $resource != "forgot" && $action != "check-login") {
					$request->setModuleName("default")->setControllerName ( 'login' )->setActionName ( 'index' );
				}
				
				if ($this->_auth->hasIdentity () && $this->_auth->getStorage ()->read ()->group_id != "guest") {
					if($request->getModuleName ()== "default" && 
							$this->_acl->hasRole($this->_auth->getStorage ()->read ()->group_id) && 
							$this->_acl->has($resource) &&
							$this->_acl->isAllowed($this->_auth->getStorage ()->read ()->group_id,$resource)) {
						// Access Allowed For Default Module
						$this->_initNavigation();
					} else if($request->getModuleName () != "default" &&
							$this->_acl->hasRole($this->_auth->getStorage ()->read ()->group_id) &&
							$this->_acl->has($request->getModuleName ()) &&
							$this->_acl->isAllowed($this->_auth->getStorage ()->read ()->group_id,$request->getModuleName ())) {
						// Access Allowed For Other Modules
						$this->_initNavigation();
					}
					else {
						$request->setModuleName("default")->setControllerName ( 'login' )->setActionName ( 'logout' );
					}
				} else {
					$request->setModuleName("default")->setControllerName ( 'login' )->setActionName ( 'index' );
				}
			}
		}*/
	}
}