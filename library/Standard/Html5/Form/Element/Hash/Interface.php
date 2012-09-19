<?php
/**
 * Concrete class for handling form elements that are using hashes
 *
 * @category    Glitch
 * @package     Standard_Html5_Form
 * @subpackage  Element
 */
interface Standard_Html5_Form_Element_Hash_Interface {
	
	/**
	 * Add validators to the hash element
	 *
	 * @return Standard_Html5_Form_Element_Hash_Interface
	 */
	public function initCsrfValidator();
	
	/**
	 * Initialize the token for security
	 *
	 * @return void
	 */
	public function initCsrfToken();
	
	/**
	 * Add validators to the hash element
	 *
	 * @return Standard_Html5_Form_Element_Hash
	 */
	public function clear();
}