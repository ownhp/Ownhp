<?php
class Standard_Controller_Action extends Zend_Controller_Action {
	protected $_acl;
	protected $_auth;
	protected $_user = false;
	public function init() {
		$this->_acl = User_Plugin_Acl::getInstance ();
		$this->_auth = Zend_Auth::getInstance ();
		$this->_user = $this->_auth->getStorage ()->read ();
		$this->view->user = $this->_user;
	}
}