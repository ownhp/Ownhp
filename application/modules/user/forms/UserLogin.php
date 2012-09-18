<?php
class User_Form_UserLogin extends Zend_Form {
	public function init() {
		
		// Set the view-script path for the user
		$this->setDecorators ( array (
				array (
						'ViewScript',
						array (
								'viewScript' => 'login/user-login.phtml',
								'foo' => 'bar' 
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
				'placeholder' => 'Username Or Email' 
		) );
		$this->addElement ( $username );
		
		// Password
		$password = new Zend_Form_Element_Password ( "password", array (
				'required' => true,
				'label' => 'Password',
				'placeholder' => 'Password' 
		) );
		$this->addElement ( $password );
		
		// Submit
		$password = new Zend_Form_Element_Submit ( "submit", array (
				'label' => 'Login',
				'ignore' => true 
		) );
		$this->addElement ( $password );
	}
}