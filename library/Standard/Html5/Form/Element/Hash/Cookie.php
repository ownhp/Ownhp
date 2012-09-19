<?php
/**
 * Concrete class for settings form element hashes in cookies
 *
 * @category    Glitch
 * @package     Standard_Html5_Form
 * @subpackage  Element
 */
class Standard_Html5_Form_Element_Hash_Cookie implements Standard_Html5_Form_Element_Hash_Interface {
	
	/**
	 * Storage of the current url
	 * Used in cookie path
	 *
	 * @var string
	 */
	private $_url;
	
	/**
	 *
	 * @link Zend_Controller_Request::getCookie
	 *      
	 * @var array
	 */
	private $_cookie;
	
	/**
	 * Instance of Standard_Html5_Form_Element_Hash
	 *
	 * @var Standard_Html5_Form_Element_Hash
	 */
	private $_parent;
	
	/**
	 * The storage key used in the cookie
	 *
	 * @var string
	 */
	private $_key;
	
	/**
	 * Validator used for isValid
	 *
	 * @var string
	 */
	private $_validator = 'Identical';
	
	/**
	 * Constructor
	 * Parameter must be an instance of Standard_Html5_Form_Element_Hash
	 *
	 * @param Standard_Html5_Form_Element_Hash $parent        	
	 */
	public function __construct(Standard_Html5_Form_Element_Hash $parent) {
		$this->_parent = $parent;
		$this->_url = Zend_Controller_Front::getInstance ()->getRequest ()->getServer ( 'REQUEST_URI' );
		$this->_key = 'token_' . md5 ( __CLASS__ );
	}
	
	/**
	 * Set the validator for the element
	 *
	 * @return Standard_Html5_Form_Element_Hash_Cookie
	 */
	public function initCsrfValidator() {
		$cookie = $this->getCookie ();
		$rightHash = null;
		if (isset ( $cookie [$this->_key] )) {
			$rightHash = $cookie [$this->_key];
		}
		$this->_parent->addValidator ( $this->_validator, true, array (
				$rightHash 
		) );
		return $this;
	}
	
	/**
	 * Init the token used
	 *
	 * @return void
	 */
	public function initCsrfToken() {
		if (null !== $this->getCookie ( $this->_key )) {
			$timeout = Zend_Controller_Front::getInstance ()->getRequest ()->getServer ( 'REQUEST_TIME' ) + $this->_parent->getTimeout ();
			setcookie ( $this->_key, $this->_parent->getHash (), $timeout, $this->_url );
		}
	}
	
	/**
	 * Return cookie information
	 *
	 * A specific cookie can be specified or all cookies can be retrieved when
	 * not
	 * setting the key parameter
	 *
	 * @param string $key        	
	 * @return array
	 */
	public function getCookie($key = null) {
		if (null === $this->_cookie) {
			$this->_cookie = Zend_Controller_Front::getInstance ()->getRequest ()->getCookie ( $key );
		}
		return $this->_cookie;
	}
	
	/**
	 * Clear the cookie information
	 *
	 * @return Standard_Html5_Form_Element_Hash_Cookie
	 */
	public function clear() {
		$timeout = Zend_Controller_Front::getInstance ()->getRequest ()->getServer ( 'REQUEST_TIME' ) - $this->_parent->getTimeout ();
		setcookie ( $this->_key, '', $timeout, $this->_url );
		return $this;
	}
}