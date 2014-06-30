<?php

/**
 * This is the model class for table "organisations".
 *
 * The followings are the available columns in table 'organisations':
 * @property string $organisation_id
 * @property string $organisation_name
 * @property string $organisation_admin
 */
class Organisations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organisations the static model class
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
		return 'organisations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organisation_id, organisation_name, organisation_admin', 'required'),
			array('organisation_id', 'length', 'max'=>44),
			array('organisation_admin', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('organisation_id, organisation_name, organisation_admin', 'safe', 'on'=>'search'),
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
			'organisation_id' => 'Organisation',
			'organisation_name' => 'Organisation Name',
			'organisation_admin' => 'Organisation Admin',
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

		$criteria->compare('organisation_id',$this->organisation_id,true);
		$criteria->compare('organisation_name',$this->organisation_name,true);
		$criteria->compare('organisation_admin',$this->organisation_admin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}