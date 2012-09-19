<?php
class User_Form_UserLogin extends Zend_Form {
	public function init() {
		
		// Set the view-script path for the user
		$this->setDecorators ( array (
				array (
						'ViewScript',
						array (
								'viewScript' => 'login/user-login.phtml' 
						) 
				) 
		) );
		
		// Set the default action for the form
		$this->setAction ( $this->getView ()->baseUrl ( "/user/login" ) );
		
		// Set the default method for the form
		$this->setMethod ( "post" );
		
		// Set the default form ID
		$this->setAttrib ( "id", "frmLogin" );
		
		// Username
		$username = new Zend_Form_Element_Text ( "username", array (
				'required' => true,
				'label' => 'Username',
				'size' => 32,
				'placeholder' => 'Username Or Email',
				'validators' => array (
						'NotEmpty' 
				),
				'filters' => array (
						'StringTrim' 
				) 
		) );
		// Do check that the username exists in database
		$usernameExists = new Zend_Validate_Db_RecordExists ( array (
				'table' => 'user',
				'field' => 'username',
				'exclude' => array (
						'field' => 'status',
						'value' => 'INACTIVE' 
				) 
		) );
		$usernameExists->setMessage ( "Invalid Username", Zend_Validate_Db_RecordExists::ERROR_NO_RECORD_FOUND );
		$username->addValidator($usernameExists);
		$this->addElement ( $username );
		
		// Password
		$password = new Zend_Form_Element_Password ( "password", array (
				'required' => true,
				'size' => 32,
				'label' => 'Password',
				'placeholder' => 'Password',
				'validators' => array (
						'NotEmpty' 
				) 
		) );
		$this->addElement ( $password );
		
		// Submit
		$submit = new Zend_Form_Element_Submit ( "submit", array (
				'label' => 'Login',
				'ignore' => true 
		) );
		$this->addElement ( $submit );
		
		// Submit
		$reset = new Zend_Form_Element_Reset ( "reset", array (
				'label' => 'Reset',
				'ignore' => true 
		) );
		$this->addElement ( $reset );
	}
}