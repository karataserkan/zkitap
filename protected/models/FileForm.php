<?php

class FileForm extends CFormModel
{
	public $pdf_file;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('pdf_file', 'file', 'types'=>'pdf'),
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
			'pdf_file'=>__('PDF dosyası')
		);
	}
}