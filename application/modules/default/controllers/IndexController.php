<?php
class Default_IndexController extends Zend_Controller_Action {
	private $_acl;
	private $_auth;
	public function init() {
		$this->user = false;
		$this->_acl = User_Plugin_Acl::getInstance ();
		$this->_auth = Zend_Auth::getInstance ();
	}
	public function indexAction() {
	}
}

