<?php
class User_Plugin_Acl extends Zend_Acl {
	protected static $_instance;
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self ();
		}
		
		return self::$_instance;
	}
	public function __construct() {
		$this->addRole("GUEST");
		$this->addRole("USER",array("GUEST"));
		$this->addRole("ADMINISTRATOR",array("USER"));
		
		// Add bookmark as a resource
		$this->addResource("bookmark");
		$this->addResource("user");
		
		// Add login as resource
		$this->addResource("login");
		$this->allow("GUEST","login");
		
		// Add Logout as resource that is only accessible by logged in users
		$this->addResource("logout");
		$this->allow("USER","logout");
		
		$this->allow("GUEST","bookmark","view");
		$this->allow("USER","bookmark");
		$this->deny(array("USER","ADMINISTRATOR"),"login");
	}
}