<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PublishBookForm extends CFormModel
{
	public $contentId;
	public $contentType;
	public $contentTitle;
	public $contentExplanation;
	public $contentIsForSale;
	public $contentPrice;
	public $contentPriceCurrencyCode;
	public $contentReaderGroup;
	public $created;
	public $organisationId;
	public $organisationName;
	public $contentHostAddress;
	public $contentHostPort;
	public $contentHostId;
	public $contentHostKey1;
	public $contentHostKey2;
	public $categories;
	public $abstract;
	public $identifier;
	public $language;
	public $subject;
	public $edition;
	public $author;
	public $translator;
	public $issn;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			
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
			'contentId'=>'Content Id',
			'contentType'=>'Content Type',
			'contentHostAddress'=>'Host Address',
			'contentHostPort'=>'Host Port',
			'contentHostId'=>'Host Id',
			'contentHostKey1'=>'Host Key 1',
			'contentHostKey2'=>'Host Key 2',
			'contentTitle'=>'Content Title',
			'contentExplanation'=>'Content Explanation',
			'contentIsForSale'=>'Is For Sale?',
			'contentPrice'=>'Content Price',
			'contentPriceCurrencyCode'=>'Currency',
			'contentReaderGroup'=>'Reader Group',
			'created'=>'Date',
			'organisationId'=>'organisation Id',
			'organisationName'=>'Organisation Name',
			'categories'=>'Kategoriler'
		);
	}
}