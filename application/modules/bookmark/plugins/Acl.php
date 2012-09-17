<?php
class Default_Plugin_Acl extends Zend_Acl {
	protected static $_instance;
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self ();
		}
		
		return self::$_instance;
	}
	public function __construct() {
	}
}