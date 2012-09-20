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
		$this->addRole("USER");
		$this->addRole("ADMINISTRATOR",array("USER","GUEST"));
		
		$this->addResource("bookmark");
		$this->addResource("user");
		$this->addResource("admin");
		
		$this->allow("GUEST","bookmark","view");
		$this->allow("USER","bookmark");
		$this->allow("ADMINISTRATOR","admin");
	}
}