<?php
class Standard_Html5_Form_Element_Text_Month extends Standard_Html5_Form_Element_Text {
	public function init() {
		if ($this->isAutoloadValidators ()) {
			// @todo: base month numbers on Zend_Locale
			$this->addValidator ( 'Between', false, array (
					'min' => 1,
					'max' => 52 
			) );
		}
	}
}