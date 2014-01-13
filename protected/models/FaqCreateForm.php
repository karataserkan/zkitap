<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class FaqCreateForm extends CFormModel
{
	public $faq_id;
	public $faq_question;
	public $faq_answer;
	public $faq_lang;
	public $faq_categories;
	public $faq_keywords;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('faq_id, faq_categories, faq_question, faq_answer,faq_lang', 'required')
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
			'faq_id'=>'ID',
			'faq_question'=>__('SSS Soru'),
			'faq_answer'=>__('SSS Cevap'),
			'faq_lang'=>__('Dil'),
			'faq_categories'=>__('Categoriler'),
			'faq_keywords'=>__('Anahtar Kelimeler')
		);
	}
}