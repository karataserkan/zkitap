<?php

class BookDataForm extends CFormModel
{
	public $size;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('size', 'required')
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'size'=>'Size'
		);
	}
}