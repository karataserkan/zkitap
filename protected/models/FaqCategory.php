<?php

/**
 * This is the model class for table "faq_category".
 *
 * The followings are the available columns in table 'faq_category':
 * @property integer $faq_category_id
 * @property string $faq_category_title
 * @property integer $parent_id
 * @property string $lang
 */
class FaqCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaqCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faq_category_id, faq_category_title, parent_id', 'required'),
			array('faq_category_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('faq_category_title', 'length', 'max'=>244),
			array('lang', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faq_category_id, faq_category_title, parent_id, lang', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faq_category_id' => 'Faq Category',
			'faq_category_title' => 'Faq Category Title',
			'parent_id' => 'Parent',
			'lang' => 'Lang',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('faq_category_id',$this->faq_category_id);
		$criteria->compare('faq_category_title',$this->faq_category_title,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('lang',$this->lang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}