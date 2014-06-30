<?php

/**
 * This is the model class for table "organisation_workspaces".
 *
 * The followings are the available columns in table 'organisation_workspaces':
 * @property string $organisation_id
 * @property string $workspace_id
 */
class OrganisationWorkspaces extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganisationWorkspaces the static model class
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
		return 'organisation_workspaces';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organisation_id, workspace_id', 'required'),
			array('organisation_id, workspace_id', 'length', 'max'=>44),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('organisation_id, workspace_id', 'safe', 'on'=>'search'),
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
			'workspace_id' => 'Workspace',
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
		$criteria->compare('workspace_id',$this->workspace_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}