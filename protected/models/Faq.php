<?php

/**
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
 * @property integer $faq_id
 * @property string $faq_question
 * @property string $faq_answer
 * @property integer $faq_frequency
 * @property string $lang
 * @property double $rate
 */
class Faq extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Faq the static model class
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
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faq_frequency', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('faq_question, faq_answer', 'length', 'max'=>10000),
			array('lang', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faq_id, faq_question, faq_answer, faq_frequency, lang, rate', 'safe', 'on'=>'search'),
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
			'faq_id' => 'Faq',
			'faq_question' => 'Faq Question',
			'faq_answer' => 'Faq Answer',
			'faq_frequency' => 'Faq Frequency',
			'lang' => 'Lang',
			'rate' => 'Rate',
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

		$criteria->compare('faq_id',$this->faq_id);
		$criteria->compare('faq_question',$this->faq_question,true);
		$criteria->compare('faq_answer',$this->faq_answer,true);
		$criteria->compare('faq_frequency',$this->faq_frequency);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('rate',$this->rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}