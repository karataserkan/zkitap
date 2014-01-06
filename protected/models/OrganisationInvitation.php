<?php

/**
 * This is the model class for table "organisation_invitation".
 *
 * The followings are the available columns in table 'organisation_invitation':
 * @property string $organisation_id
 * @property integer $user_id
 * @property string $invitation_id
 */
class OrganisationInvitation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganisationInvitation the static model class
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
		return 'organisation_invitation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organisation_id, user_id, invitation_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('organisation_id, invitation_id', 'length', 'max'=>44),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('organisation_id, user_id, invitation_id', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'invitation_id' => 'Invitation',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('invitation_id',$this->invitation_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}