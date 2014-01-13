<?php

/**
 * This is the model class for table "organisation_hostings".
 *
 * The followings are the available columns in table 'organisation_hostings':
 * @property string $organisation_id
 * @property string $hosting_client_IP
 * @property integer $hosting_client_port
 * @property string $hosting_client_id
 * @property string $hosting_client_key1
 * @property string $hosting_client_key2
 */
class OrganisationHostings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganisationHostings the static model class
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
		return 'organisation_hostings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organisation_id, hosting_client_IP, hosting_client_id, hosting_client_key1, hosting_client_key2', 'required'),
			array('hosting_client_port', 'numerical', 'integerOnly'=>true),
			array('organisation_id', 'length', 'max'=>44),
			array('hosting_client_IP', 'length', 'max'=>120),
			array('hosting_client_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('organisation_id, hosting_client_IP, hosting_client_port, hosting_client_id, hosting_client_key1, hosting_client_key2', 'safe', 'on'=>'search'),
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
			'hosting_client_IP' => 'Hosting Client Ip',
			'hosting_client_port' => 'Hosting Client Port',
			'hosting_client_id' => 'Hosting Client',
			'hosting_client_key1' => 'Hosting Client Key1',
			'hosting_client_key2' => 'Hosting Client Key2',
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
		$criteria->compare('hosting_client_IP',$this->hosting_client_IP,true);
		$criteria->compare('hosting_client_port',$this->hosting_client_port);
		$criteria->compare('hosting_client_id',$this->hosting_client_id,true);
		$criteria->compare('hosting_client_key1',$this->hosting_client_key1,true);
		$criteria->compare('hosting_client_key2',$this->hosting_client_key2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}