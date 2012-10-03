<?php
class Bookmark_Form_Bookmark extends Zend_Form {
	public function init() {
		$view = $this->getView ();
		$this->setMethod ( "post" );
		$this->setAttrib ( "id", "frmBookmark" );
		$this->setAction ( $view->url ( array (
				'module' => 'bookmark',
				'controller' => 'index',
				'action' => 'add' 
		) ) );
		
		// Set the view-script path for the user
		$this->setDecorators ( array (
				array (
						'ViewScript',
						array (
								'viewScript' => 'index/bookmark-form.phtml' 
						) 
				) 
		) );
		
		// Bookmark ID
		$bookmark_id = new Zend_Form_Element_Hidden ( "bookmark_id", array (
				'filters' => array (
						'StringTrim' 
				) 
		) );
		$this->addElement ( $bookmark_id );
		
		// Bookmark Title
		$title = new Zend_Form_Element_Text ( "title", array (
				"label" => "Title",
				'size' => 32,
				'required' => true,
				'filters' => array (
						'StringTrim' 
				),
				'validators' => array (
						'NotEmpty' 
				) 
		) );
		$title->setAttrib ( "required", "required" );
		$this->addElement ( $title );
		
		// Bookmark Description
		$description = new Zend_Form_Element_Textarea ( "description", array (
				"label" => "Description",
				"rows" => "2",
				"cols" => "33",
				'filters' => array (
						'StringTrim' 
				) 
		) );
		$this->addElement ( $description );
		
		// Url for the bookmark
		$url = new Standard_Html5_Form_Element_Text_Url ( "url", array (
				"label" => "Url",
				'size' => 32,
				'filters' => array (
						'StringTrim' 
				),
				'required' => true,
				'validators' => array (
						'NotEmpty' 
				) 
		) );
		$url->setAttrib ( "required", "required" );
		$this->addElement ( $url );
		
		// Image Path
		$image_path = new Zend_Form_Element_Hidden ( "image_path", array (
				'filters' => array (
						'StringTrim' 
				) 
		) );
		$this->addElement ( $image_path );
		
		// Submit
		$submit = new Zend_Form_Element_Submit ( "submit", array (
				"label" => "Add Bookmark",
				'ignore' => true 
		) );
		$this->addElement ( $submit );
		
		// Submit
		$reset = new Zend_Form_Element_Reset ( "reset", array (
				"label" => "Reset Data",
				'ignore' => true 
		) );
		$this->addElement ( $reset );
	}
}