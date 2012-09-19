<?php
class User_Bootstrap extends Zend_Application_Module_Bootstrap {
	var $_auth;
	public function _initAuloload() {
		$this->_auth = Zend_Auth::getInstance ();
		$temp = $this->_auth->getStorage ();
		$fc = Zend_Controller_Front::getInstance ();
		if (! $this->_auth->hasIdentity ()) {
			$this->_auth->getStorage ()->write ( ( object ) array (
					'role' => 'GUEST' 
			) );
		}
		
		$fc->registerPlugin ( new User_Plugin_Authentication ( $this->_auth ) );
	}
}

